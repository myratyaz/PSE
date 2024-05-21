document.addEventListener('DOMContentLoaded', () => {
    const loginButton = document.getElementById('admin-login-btn');
    const clearPostsButton = document.getElementById('clear-posts-btn');
    const registrationSection = document.getElementById('registration-section');
    const loginSection = document.getElementById('login-section');
    const postFormSection = document.getElementById('new-post-section');
    const postForm = document.getElementById('post-form');
    const postsList = document.getElementById('posts');
    const registrationForm = document.getElementById('registration-form');
    const loginForm = document.getElementById('login-form');
    let blogPosts = JSON.parse(localStorage.getItem('blogPosts')) || [];
    let users = JSON.parse(localStorage.getItem('users')) || [];
    let currentUser = JSON.parse(localStorage.getItem('currentUser')) || null;
    const quill = new Quill('#post-content', {
        theme: 'snow'
    });

    const adminUsername = "admin";
    const adminPassword = "admin";

    function toggleVisibility(element, show) {
        element.classList.toggle('hidden', !show);
    }

    loginButton.addEventListener('click', () => {
        if (!currentUser) {
            toggleVisibility(registrationSection, true);
            toggleVisibility(loginSection, true);
        } else {
            currentUser = null;
            localStorage.removeItem('currentUser');
            loginButton.textContent = "Login/Register";
            toggleVisibility(postFormSection, false);
            toggleVisibility(clearPostsButton, false);
        }
    });

    registrationForm.addEventListener('submit', event => {
        event.preventDefault();
        const username = document.getElementById('register-username').value;
        const password = document.getElementById('register-password').value;
        const userExists = users.find(user => user.username === username);
        if (userExists) {
            alert("Username already taken.");
        } else {
            const newUser = {
                username,
                password: btoa(password)
            };
            users.push(newUser);
            localStorage.setItem('users', JSON.stringify(users));
            alert("Registration successful. Please login.");
            toggleVisibility(registrationSection, false);
            toggleVisibility(loginSection, true);
        }
    });

    loginForm.addEventListener('submit', event => {
        event.preventDefault();
        const username = document.getElementById('login-username').value;
        const password = document.getElementById('login-password').value;
        const user = users.find(user => user.username === username && user.password === btoa(password));
        if (user) {
            currentUser = user;
            localStorage.setItem('currentUser', JSON.stringify(currentUser));
            loginButton.textContent = `Logout (${username})`;
            toggleVisibility(postFormSection, true);
            toggleVisibility(clearPostsButton, true);
            toggleVisibility(loginSection, false);
        } else {
            alert("Invalid username or password.");
        }
    });

    postForm.addEventListener('submit', event => {
        event.preventDefault();
        if (currentUser) {
            const title = document.getElementById('post-title').value;
            const content = quill.root.innerHTML;
            const category = document.getElementById('post-category').value;
            addPost(title, content, category);
            postForm.reset();
            quill.root.innerHTML = '';
        } else {
            alert("You must be logged in to add a post.");
        }
    });

    clearPostsButton.addEventListener('click', () => {
        localStorage.removeItem('blogPosts');
        blogPosts = [];
        renderPosts();
    });

    function addPost(title, content, category) {
        const postId = new Date().toISOString();
        const newPost = {
            id: postId,
            title,
            content,
            category,
            date: postId,
            comments: []
        };
        blogPosts.push(newPost);
        localStorage.setItem('blogPosts', JSON.stringify(blogPosts));
        renderPosts();
    }

    function renderPosts() {
        postsList.innerHTML = '';
        blogPosts.sort((a, b) => new Date(b.date) - new Date(a.date)).forEach(post => {
            const postElement = document.createElement('li');
            postElement.classList.add('post-item');
            postElement.innerHTML = `
                <h3>${post.title}</h3>
                <p>${post.content}</p>
                <small>Posted on ${new Date(post.date).toLocaleString()} in ${post.category}</small>
                <div class="admin-controls hidden">
                    <button class="approve-comment-btn">Approve</button>
                    <button class="delete-comment-btn">Delete</button>
                </div>
                <form class="comment-form" data-post-id="${post.id}">
                    <input type="text" class="comment-author" placeholder="Your Name" required>
                    <textarea class="comment-text" placeholder="Your Comment" required></textarea>
                    <button type="submit">Add Comment</button>
                </form>
                <ul class="comment-list" data-post-id="${post.id}"></ul>
            `;
            postsList.appendChild(postElement);
            renderComments(post.id);
        });
        if (currentUser) {
            document.querySelectorAll('.admin-controls').forEach(ctrl => ctrl.classList.remove('hidden'));
        }
    }

    function renderComments(postId) {
        const post = blogPosts.find(p => p.id === postId);
        const commentList = document.querySelector(`.comment-list[data-post-id="${postId}"]`);
        if (!commentList) {
            console.error(`No comment list found for post ID: ${postId}`);
            return;
        }
        commentList.innerHTML = '';
        if (post && post.comments) {
            post.comments.forEach(comment => {
                const commentElement = document.createElement('li');
                commentElement.classList.add('comment-item');
                commentElement.innerHTML = `<b>${comment.author}</b>: ${comment.text}`;
                if (currentUser) {
                    commentElement.innerHTML += `
                        <div class="admin-controls">
                            <button class="approve-comment-btn">Approve</button>
                            <button class="delete-comment-btn">Delete</button>
                        </div>
                    `;
                }
                commentList.appendChild(commentElement);
            });
        }
    }

    document.addEventListener('submit', event => {
        if (event.target && event.target.matches('.comment-form')) {
            event.preventDefault();
            const postId = event.target.getAttribute('data-post-id');
            const author = event.target.querySelector('.comment-author').value;
            const text = event.target.querySelector('.comment-text').value;
            addComment(postId, author, text);
            event.target.reset();
        }
    });

    document.addEventListener('click', event => {
        if (event.target && event.target.matches('.approve-comment-btn')) {
            const commentElement = event.target.closest('.comment-item');
            commentElement.classList.add('approved');
            // Additional logic for approving comments can be added here
        } else if (event.target && event.target.matches('.delete-comment-btn')) {
            const commentElement = event.target.closest('.comment-item');
            const postId = commentElement.closest('.comment-list').getAttribute('data-post-id');
            const commentIndex = Array.from(commentElement.parentNode.children).indexOf(commentElement);
            deleteComment(postId, commentIndex);
        }
    });

    function addComment(postId, author, text) {
        const post = blogPosts.find(p => p.id === postId);
        if (post) {
            const newComment = { author, text, date: new Date().toISOString() };
            post.comments.push(newComment);
            localStorage.setItem('blogPosts', JSON.stringify(blogPosts));
            renderComments(postId);
        } else {
            console.error(`Post with ID ${postId} not found`);
        }
    }

    function deleteComment(postId, commentIndex) {
        const post = blogPosts.find(p => p.id === postId);
        if (post && post.comments[commentIndex]) {
            post.comments.splice(commentIndex, 1);
            localStorage.setItem('blogPosts', JSON.stringify(blogPosts));
            renderComments(postId);
        } else {
            console.error(`Comment not found for post ID ${postId}`);
        }
    }

    if (currentUser) {
        loginButton.textContent = `Logout (${currentUser.username})`;
        toggleVisibility(postFormSection, true);
        toggleVisibility(clearPostsButton, true);
    }
    renderPosts();
});
