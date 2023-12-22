function buttonEnabled(txtArea) {
    var btn = document.getElementById("btn-qpost");
    var submitButton = document.getElementById("confirm-post");

    if (txtArea.value.trim().length >= 3) {
        btn.disabled = false;
        submitButton.classList.add('enabled');
    } else {
        btn.disabled = true;
        submitButton.classList.remove('enabled');
    }
}

function validateForm() {
    var password1 = document.getElementsByName('password')[0].value;
    var password2 = document.getElementsByName('password2')[0].value;

    if (password1 !== password2) {
        alert('Passwords do not match!');
        return false; //ne prolazi
    }
    //prolazi form submission
    return true; 
}