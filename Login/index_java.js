const loginBtn = document.querySelector('.auth .login');
const signupBtn = document.querySelector('.auth .signup');

const loginSection = document.querySelector('#login');
const signupSection = document.querySelector('#signup');

const loginForm = document.querySelector('.login-form');
const loginUsername = document.querySelector('#login-username');
const loginPassword = document.querySelector('#login-password');

loginBtn.addEventListener('click', function() {
    signupSection.classList.remove('show');
    loginSection.classList.add('show');
    signupBtn.classList.remove('selected');
    loginBtn.classList.add('selected');
});


loginUsername.addEventListener('input', function() {
    if (loginUsername.validity.valid) {
        loginUsername.classList.remove('error');
        loginUsername.nextElementSibling.classList.remove('show');
    }
})

loginPassword.addEventListener('input', function() {
    if (loginPassword.validity.valid) {
        loginPassword.classList.remove('error');
        loginPassword.nextElementSibling.classList.remove('show');
    }
})

loginForm.addEventListener('submit', function(e) {
    if (!loginUsername.validity.valid) {
        loginUsername.classList.add('error');
        loginUsername.nextElementSibling.classList.add('show');
        e.preventDefault();
    }
    if (!loginPassword.validity.valid) {
        loginPassword.classList.add('error');
        loginPassword.nextElementSibling.classList.add('show');
        e.preventDefault();
    }

})