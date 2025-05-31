// Script for show/hide password
document.addEventListener('DOMContentLoaded', function () {
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');

    togglePassword.addEventListener('click', function () {
        // Toggle the type attribute of the password input
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);

        // Toggle the eye / eye-slash icon
        this.classList.toggle('bi-eye');
        this.classList.toggle('bi-eye-slash');
    });

    const successAlert = document.querySelector('.alert-success');
    if (successAlert) {
        setTimeout(function () {
            const bsAlert = new bootstrap.Alert(successAlert);
            bsAlert.close();
        }, 7000);
    }
});