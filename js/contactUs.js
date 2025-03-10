function validateForm() {
    // Check if user is logged in (this will be set by PHP)
    const loggedIn = typeof isUserLoggedIn !== 'undefined' ? isUserLoggedIn : false;
    
    if (!loggedIn) {
        // Show login popup if user is not logged in
        const loginPopup = document.getElementById('login-popup');
        const loginError = document.getElementById('login-error');
        
        if (loginPopup && loginError) {
            loginPopup.style.display = 'block';
            loginError.style.display = 'block';
            loginError.textContent = "Please login before submitting your message.";
        }
        return false; // Prevent form submission
    }
    
    // Continue with regular form validation
    let message = document.getElementById("message").value.trim();
    let errorMessage = document.getElementById("error-message");

    if (message === "") {
        errorMessage.style.display = 'block';
        errorMessage.textContent = "Please enter your message.";
        return false;
    }

    errorMessage.style.display = 'none';
    return true;
}

// Add this code to handle DOM events when the page loads
document.addEventListener('DOMContentLoaded', function() {
    // Make the error message element visible if needed
    const errorMessage = document.getElementById("error-message");
    if (errorMessage) {
        errorMessage.style.display = errorMessage.textContent ? 'block' : 'none';
    }
    
    // Make login popup close when the close button is clicked
    const loginCloseBtn = document.getElementById('login-close-btn');
    const loginPopup = document.getElementById('login-popup');
    
    if (loginCloseBtn && loginPopup) {
        loginCloseBtn.addEventListener('click', function() {
            loginPopup.style.display = 'none';
        });
    }
});