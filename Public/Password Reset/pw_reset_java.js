const resetFormPass = document.querySelector('.container .reset-form-Pass');
const resetPass = document.querySelector('#reset-pass');
const resetRePass = document.querySelector('#reset-re-pass');
const firsterr = document.getElementById('first_err');



resetPass.addEventListener('input', function() {
    if (resetPass.validity.valid) {
        resetPass.classList.remove('error');
        resetPass.nextElementSibling.classList.remove('show');
    }
})

resetRePass.addEventListener('input', function() {
    if (resetRePass.validity.valid) {
        var resPassval = document.getElementById('reset-pass').value;
        var resRePassval = document.getElementById('reset-re-pass').value;
        if (resPassval == resRePassval) {
            resetRePass.classList.remove('error');
            resetRePass.nextElementSibling.classList.remove('show');
            resetRePass.nextElementSibling.nextElementSibling.classList.remove('show');
        } else if (resPassval != resRePassval) {
            resetRePass.classList.add('error');
        }
    }
})


resetFormPass.addEventListener('submit', function(e) {
    if (!resetPass.validity.valid) {
        resetPass.classList.add('error');
        resetPass.nextElementSibling.classList.add('show');
        e.preventDefault();
    }
    if (!resetRePass.validity.valid) {
        resetRePass.classList.add('error');
        resetRePass.nextElementSibling.classList.add('show');
        e.preventDefault();
    }
    var resPassval = document.getElementById('reset-pass').value;
    var resRePassval = document.getElementById('reset-re-pass').value;
    if (resPassval != resRePassval) {
        resetRePass.classList.add('error');
        firsterr.nextElementSibling.classList.add('show');
        e.preventDefault();
    }
})