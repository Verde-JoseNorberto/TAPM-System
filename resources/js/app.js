import './bootstrap';

const successAlert = document.getElementById('success-alert');
if (successAlert) {
    setTimeout(function() {
        successAlert.style.display = 'none';
    }, 5000);
}

const errorAlert = document.getElementById('error-alert');
if (errorAlert) {
    setTimeout(function() {
        errorAlert.style.display = 'none';
    }, 5000);
}