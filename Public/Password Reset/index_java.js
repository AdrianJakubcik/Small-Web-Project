const resetForm = document.querySelector('.container .reset-form');
const resetEmail = document.querySelector('#reset-email');

var email_value = document.getElementById('reset-email').value;
resetEmail.addEventListener('input', function() {
    if (resetEmail.validity.valid) {
        resetEmail.classList.remove('error');
        resetEmail.nextElementSibling.classList.remove('show');
    } else {
        resetEmail.classList.add('error');
    }
})



resetForm.addEventListener('submit', function(e) {
    if (!resetEmail.validity.valid) {
        resetEmail.classList.add('error');
        resetEmail.nextElementSibling.classList.add('show');
        e.preventDefault();
    }

})