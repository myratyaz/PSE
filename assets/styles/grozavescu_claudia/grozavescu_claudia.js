const validUsername = "user";
const validPassword = "parola";

function login() {
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;
    const error = document.getElementById('error');

    if (username === validUsername && password === validPassword) {
        document.querySelector('.login-container').style.display = 'none';
        document.querySelector('.blog-container').style.display = 'flex';
        error.innerText = '';
    } else {
        error.innerText = 'Username sau parola incorecta!';
    }
}

function addPost() {
    const postUser = document.getElementById('postUser').value;
    const postDescription = document.getElementById('postDescription').value;
    const postImage = document.getElementById('postImage').value;
    const postsContainer = document.getElementById('posts');

    if (postUser && postDescription) {
        const postDiv = document.createElement('div');
        postDiv.classList.add('post');
        postDiv.onclick = () => showPostDetails(postDiv);

        const userP = document.createElement('p');
        userP.innerText = `User: ${postUser}`;

        const descriptionP = document.createElement('p');
        descriptionP.innerText = postDescription;

        const image = document.createElement('img');
        image.src = postImage;

        const deleteButton = document.createElement('button');
        deleteButton.innerText = 'Sterge Postare';
        deleteButton.onclick = (e) => {
            e.stopPropagation();
            postsContainer.removeChild(postDiv);
            document.getElementById('postDetails').innerHTML = '<h3>Detalii Postare</h3>';
        };

        postDiv.appendChild(userP);
        postDiv.appendChild(descriptionP);
        if (postImage) {
            postDiv.appendChild(image);
        }
        postDiv.appendChild(deleteButton);

        postsContainer.appendChild(postDiv);
    }
}

function showPostDetails(postDiv) {
    const postDetailsContainer = document.getElementById('postDetails');
    postDetailsContainer.innerHTML = '<h3>Detalii Postare</h3>';
    
    const userP = postDiv.querySelector('p').cloneNode(true);
    const descriptionP = postDiv.querySelectorAll('p')[1].cloneNode(true);
    const image = postDiv.querySelector('img') ? postDiv.querySelector('img').cloneNode(true) : null;
    
    const commentSection = document.createElement('div');
    commentSection.classList.add('comments');

    const commentUserInput = document.createElement('input');
    commentUserInput.placeholder = 'User';

    const commentTextInput = document.createElement('input');
    commentTextInput.placeholder = 'Comentariu';

    const addCommentButton = document.createElement('button');
    addCommentButton.innerText = 'Adauga Comentariu';
    addCommentButton.onclick = () => {
        const commentUser = commentUserInput.value;
        const commentText = commentTextInput.value;

        if (commentUser && commentText) {
            const commentDiv = document.createElement('div');
            commentDiv.classList.add('comment');

            const commentP = document.createElement('p');
            commentP.innerText = `${commentUser}: ${commentText}`;

            const deleteCommentButton = document.createElement('button');
            deleteCommentButton.innerText = 'Sterge Comentariu';
            deleteCommentButton.onclick = () => commentSection.removeChild(commentDiv);

            commentDiv.appendChild(commentP);
            commentDiv.appendChild(deleteCommentButton);
            commentSection.appendChild(commentDiv);
        }
    };

    postDetailsContainer.appendChild(userP);
    postDetailsContainer.appendChild(descriptionP);
    if (image) {
        postDetailsContainer.appendChild(image);
    }
    postDetailsContainer.appendChild(commentUserInput);
    postDetailsContainer.appendChild(commentTextInput);
    postDetailsContainer.appendChild(addCommentButton);
    postDetailsContainer.appendChild(commentSection);
}
