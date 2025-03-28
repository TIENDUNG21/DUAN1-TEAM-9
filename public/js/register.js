document.getElementById("loginForm").addEventListener("submit", function(event) {
    event.preventDefault(); 

    // Get input values
    const username = document.getElementById("username").value;
    const email = document.getElementById("email").value;
    const phone = document.getElementById("phone").value;
    const password = document.getElementById("password").value;

    if (username === "") {
        showErrorMessage("Username is required.");
    } else if (!validateEmail(email)) {
        showErrorMessage("Please enter a valid email address.");
    } else if (!validatePhone(phone)) {
        showErrorMessage("Please enter a valid phone number.");
    } else if (password.length < 6) {
        showErrorMessage("Password must be at least 6 characters long.");
    } else {
        showErrorMessage(""); 
        alert("Registration Successful!"); 
    }
});

function validateEmail(email) {
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailPattern.test(email);
}

function validatePhone(phone) {
    const phonePattern = /^[0-9]{10,12}$/; 
    return phonePattern.test(phone);
}
function showErrorMessage(message) {
    const errorMessage = document.getElementById("error-message");
    errorMessage.textContent = message;

    if (message) {
        errorMessage.style.display = "block"; 
    } else {
        errorMessage.style.display = "none"; 
    }
}
