const loginBtn = document.querySelector('.auth .login');
const signupBtn = document.querySelector('.auth .signup');

const loginSection = document.querySelector('#login');
const signupSection = document.querySelector('#signup');

const loginForm = document.querySelector('.signup-form');
const loginUsername = document.querySelector('#signup-username');
const loginPassword = document.querySelector('#signup-password');
const loginConfPass = document.querySelector('#signup-repassword');
const loginEmail = document.querySelector('#signup-email');
const Error_First = document.querySelector('#first_error');



/*signupBtn.addEventListener('click', function() {
    loginSection.classList.remove('show');
    signupSection.classList.add('show');
    loginBtn.classList.remove('selected');
    signupBtn.classList.add('selected');

});*/

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

loginConfPass.addEventListener('input', function() {
    if (loginConfPass.validity.valid) {
        var Pass = document.getElementById("signup-password").value;
        var Repass = document.getElementById('signup-repassword').value;
        if (Pass == Repass) {
            loginConfPass.classList.remove('error');
            loginConfPass.nextElementSibling.classList.remove('show');
            Error_First.nextElementSibling.classList.remove('show');
        } else if (Pass != Repass) {
            loginConfPass.classList.add('error');
            Error_First.nextElementSibling.classList.add('show');
        }
    }
})

loginEmail.addEventListener('input', function() {
    if (loginEmail.validity.valid) {
        loginEmail.classList.remove('error');
        loginEmail.nextElementSibling.classList.remove('show');
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
    if (!loginConfPass.validity.valid) {
        loginConfPass.classList.add('error');
        loginConfPass.nextElementSibling.classList.add('show');
        e.preventDefault();
    }
    if (!loginEmail.validity.valid) {
        loginEmail.classList.add('error');
        loginEmail.nextElementSibling.classList.add('show');
        e.preventDefault();
        return;
    }
    var Pass = document.getElementById("signup-password").value;
    var Repass = document.getElementById('signup-repassword').value;
    if (Pass != Repass) {
        loginConfPass.classList.add('error');
        Error_First.nextElementSibling.classList.add('show');
        e.preventDefault();
    }
    //alert("The Value Of Pass input is [" + Pass + "]");
})