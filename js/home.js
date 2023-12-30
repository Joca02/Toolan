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