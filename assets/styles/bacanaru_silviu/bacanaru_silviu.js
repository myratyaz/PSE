document.getElementById('login-form').addEventListener('submit', function(event) {
    event.preventDefault();
    
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;
    const errorMessage = document.getElementById('error-message');
    
    const hardcodedUsername = 'test';
    const hardcodedPassword = 'test';
    
    if (username === hardcodedUsername && password === hardcodedPassword) {
        document.getElementById('login-page').style.display = 'none';
        document.getElementById('blog-page').style.display = 'block';
        loadInitialPosts();
    } else {
        errorMessage.textContent = 'Invalid username or password.';
    }
});

document.querySelectorAll('.tab-button').forEach(button => {
    button.addEventListener('click', () => {
        document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));
        document.getElementById(button.dataset.tab).classList.add('active');
    });
});

document.getElementById('tech-post-form').addEventListener('submit', function(event) {
    event.preventDefault();
    addPost('tech');
});

document.getElementById('fashion-post-form').addEventListener('submit', function(event) {
    event.preventDefault();
    addPost('fashion');
});

document.getElementById('sports-post-form').addEventListener('submit', function(event) {
    event.preventDefault();
    addPost('sports');
});

function loadInitialPosts() {
    const initialPosts = {
        tech: [
            {
                title: "Inteligența Artificială: Revoluționarea Viitorului Tehnologic",
                content: "Inteligența Artificială (IA) a devenit una dintre cele mai importante și revoluționare tehnologii ale secolului 21. De la asistenți vocali precum Siri și Alexa, până la mașini autonome și sisteme medicale avansate, IA transformă modul în care trăim și lucrăm. Dar ce este exact inteligența artificială și cum funcționează?",
                image: "https://images.pexels.com/photos/6153354/pexels-photo-6153354.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1",
                comments: []
            }
        ],
        fashion: [
            {
                title: "Cum să alegi pantofii potriviți pentru tine?",
                content: "Este o problemă generală că pantofii potriviți sunt tot mai greu de găsit, și poți ajunge într-o situație confuză",
                image: "https://images.pexels.com/photos/298863/pexels-photo-298863.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1",
                comments: []
            }
        ],
        sports: [
            {
                title: "Basketul, un sport popular în rândul tinerilor",
                content: "Basketul tinde sa devină un trend tot mai popular în special în rândul băieților de liceu.",
                image: "https://images.pexels.com/photos/945471/pexels-photo-945471.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1",
                comments: []
            }
        ]
    };

    for (const category in initialPosts) {
        initialPosts[category].forEach(post => addPostToDOM(category, post.title, post.content, post.image, post.comments));
    }
}

function addPost(category) {
    const title = document.getElementById(`${category}-post-title`).value;
    const content = document.getElementById(`${category}-post-content`).value;
    const image = document.getElementById(`${category}-post-image`).value;

    addPostToDOM(category, title, content, image, []);

    document.getElementById(`${category}-post-title`).value = '';
    document.getElementById(`${category}-post-content`).value = '';
    document.getElementById(`${category}-post-image`).value = '';
}

function addPostToDOM(category, title, content, image, comments) {
    const post = document.createElement('div');
    post.classList.add('post');
    post.innerHTML = `
        <h4>${title}</h4>
        <img src="${image}" alt="${title}">
        <p>${content}</p>
        <div class="comments"></div>
        <form class="comment-form">
            <input type="text" placeholder="Autor" required>
            <input type="text" placeholder="Adaugă un comentariu" required>
            <button type="submit">Comentează</button>
        </form>
        <div class="post-actions">
            <button class="delete-post-button">Șterge</button>
        </div>
    `;

    const commentsDiv = post.querySelector('.comments');
    comments.forEach(comment => addCommentToDOM(commentsDiv, comment.author, comment.text));

    post.querySelector('.comment-form').addEventListener('submit', function(event) {
        event.preventDefault();
        const authorInput = this.querySelector('input[type="text"]');
        const commentInput = this.querySelectorAll('input')[1];
        addCommentToDOM(commentsDiv, authorInput.value, commentInput.value);
        authorInput.value = '';
        commentInput.value = '';
    });

    post.querySelector('.delete-post-button').addEventListener('click', () => {
        post.remove();
    });

    document.getElementById(`${category}-posts`).appendChild(post);
}

function addCommentToDOM(commentsDiv, author, commentText) {
    const comment = document.createElement('div');
    comment.classList.add('comment');
    comment.innerHTML = `
        <p><strong>${author}:</strong> ${commentText}</p>
        <div class="comment-actions">
            <button class="edit-button">Editează</button>
            <button class="delete-button">Șterge</button>
        </div>
    `;

    const editButton = comment.querySelector('.edit-button');
    const deleteButton = comment.querySelector('.delete-button');

    editButton.addEventListener('click', () => {
        const newCommentText = prompt("Editează comentariul:", commentText);
        if (newCommentText !== null) {
            comment.querySelector('p').innerHTML = `<strong>${author}:</strong> ${newCommentText}`;
        }
    });

    deleteButton.addEventListener('click', () => {
        comment.remove();
    });

    commentsDiv.appendChild(comment);
}
