const loginBtn = document.getElementById('login-btn');
const newArticleSection = document.getElementById('new-article');
const articleForm = document.getElementById('article-form');
const articleList = document.getElementById('article-list');
const loginError = document.getElementById('login-error');
let articles = JSON.parse(localStorage.getItem('articles')) || [];
let loggedIn = false;

// Credentials 
const adminUsername = "admin";
const adminPassword = "admin";

loginBtn.addEventListener('click', () => {
    if (!loggedIn) {
        const username = prompt("Enter username:");
        const password = prompt("Enter password:");
        if (username === adminUsername && password === adminPassword) {
            loggedIn = true;
            loginBtn.textContent = "Logout";
            newArticleSection.style.display = "block";
            loginError.textContent = '';
        } else {
            loginError.textContent = 'Invalid username or password';
            return; 
        }
    } else {
        loggedIn = false;
        loginBtn.textContent = "Login as Admin";
        newArticleSection.style.display = "none";
    }
    displayArticles();
});

articleForm.addEventListener('submit', event => {
    event.preventDefault(); 
    console.log("Attempting to add article"); 
    if (loggedIn) {
        const title = document.getElementById('title').value;
        const content = document.getElementById('content').value;
        if (title && content) {
            addArticle(title, content);
            articleForm.reset(); // Clear form after submission
        } else {
            console.error("Title or content missing!"); 
        }
    } else {
        console.error("Not logged in!");
        alert("Please login to publish articles");
    }
});

function addArticle(title, content) {
    const newArticle = {
        id: new Date().toISOString(),
        title,
        content,
        date: new Date().toISOString()
    };
    articles.push(newArticle);
    localStorage.setItem('articles', JSON.stringify(articles));
    displayArticles();
}

function displayArticles() {
    articleList.innerHTML = '';
    articles.sort((a, b) => new Date(b.date) - new Date(a.date))
        .forEach(article => {
            const articleItem = document.createElement('li');
            articleItem.innerHTML = `<h3>${article.title}</h3><p>${article.content}</p><small>Posted on ${new Date(article.date).toLocaleString()}</small>`;
            articleList.appendChild(articleItem);
        });
}
// Other code remains unchanged

function displayArticles() {
    articleList.innerHTML = '';
    articles.sort((a, b) => new Date(b.date) - new Date(a.date))
        .forEach(article => {
            const articleItem = document.createElement('li');
            articleItem.innerHTML = `
                <h3>${article.title}</h3>
                <p>${article.content}</p>
                <small>Posted on ${new Date(article.date).toLocaleString()}</small>
                <form class="comment-form" data-article-id="${article.id}">
                    <input type="text" class="comment-name" placeholder="Your Name" required>
                    <textarea class="comment-text" placeholder="Your Comment" required></textarea>
                    <button type="submit">Submit Comment</button>
                </form>
                <ul class="comment-list" data-article-id="${article.id}"></ul>
            `;
            articleList.appendChild(articleItem);
            displayComments(article.id);
        });
}

articleForm.addEventListener('submit', event => {
    event.preventDefault();
    if (loggedIn) {
        const title = document.getElementById('title').value;
        const content = document.getElementById('content').value;
        if (title && content) {
            addArticle(title, content);
            articleForm.reset();
        } else {
            alert("Please fill in all article details");
        }
    } else {
        alert("Please login to publish articles");
    }
});


//Creating section to add comments

document.addEventListener('submit', event => {
    if (event.target && event.target.matches('.comment-form')) {
        event.preventDefault();
        console.log("Form submitted!"); // Debugging line
        const articleId = event.target.getAttribute('data-article-id');
        const name = event.target.querySelector('.comment-name').value;
        const text = event.target.querySelector('.comment-text').value;
        console.log("Name:", name, "Text:", text); // Debugging line
        if (name && text) {
            addComment(articleId, name, text);
            event.target.reset();
            displayComments(articleId);
        } else {
            alert("Please fill in all comment details");
        }
    }
});



function displayComments(articleId) {
    const commentList = document.querySelector(`.comment-list[data-article-id="${articleId}"]`);
    if (!commentList) {
        console.error(`Comment list not found for article with ID ${articleId}`);
        return; // Stop further execution if comment list is not found
    }
    commentList.innerHTML = '';
    const article = articles.find(article => article.id === articleId);
    if (article && article.comments && article.comments.length > 0) { // Check if article and comments exist
        article.comments.forEach(comment => {
            const commentItem = document.createElement('li');
            commentItem.innerHTML = `<b>${comment.name}</b> - ${comment.text}`;
            commentList.appendChild(commentItem);
        });
    } else {
        console.warn(`No comments found for article with ID ${articleId}`);
    }
}

function addComment(articleId, name, text) {
    const article = articles.find(article => article.id === articleId);
    if (article) {
        if (!article.comments) {
            article.comments = []; // Initialize comments array if it doesn't exist
        }
        const comment = new Comment(name, text); // Ensure that name and text are passed correctly here
        article.comments.push(comment);
        localStorage.setItem('articles', JSON.stringify(articles));
        displayComments(articleId); // Update displayed comments
    } else {
        console.error(`Article with ID ${articleId} not found`);
    }
}
const Comment = function(name, text) {
    this.name = name; // Make sure that name property is set correctly
    this.text = text; // Make sure that text property is set correctly
    this.date = new Date().toISOString(); // Optionally, you can set a date property here
};







// Clearing the articles in frontend
function clearArticles() {
    articles = []; // Clear the articles array
    localStorage.removeItem('articles'); // Remove articles from localStorage
    articleList.innerHTML = ''; // Clear the displayed articles in the UI
}

// Add event listener to the "Clear All Articles" button
const clearArticlesBtn = document.getElementById('clear-articles-btn');
clearArticlesBtn.addEventListener('click', () => {
    clearArticles(); // Call clearArticles() function when the button is clicked
});
