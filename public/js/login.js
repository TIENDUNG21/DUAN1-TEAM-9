document.getElementById("loginForm").addEventListener("submit", function(event) {
    event.preventDefault();

    const username = document.getElementById("username").value;
    const password = document.getElementById("password").value;

    if (username === "" || password === "") {
        showErrorMessage("ko dc de trong.");
    } else if (password.length < 6) {
        showErrorMessage("Mat khau phai dai tu 6 ky tu");
    } else {
        showErrorMessage(""); 
        alert("dang nhap thanh cong"); 
    }
});

function showErrorMessage(message) {
    const errorMessage = document.getElementById("error-message");
    errorMessage.textContent = message;

    if (message) {
        errorMessage.style.display = "block"; 
    } else {
        errorMessage.style.display = "none";
    }
}
