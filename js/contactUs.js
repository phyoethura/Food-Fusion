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
    
    // Success popup handling - improved version
    const successPopup = document.getElementById('success-popup');
    const closeSuccessBtn = document.getElementById('close-success-popup');
    
    // Check if the success flag is set from PHP
    if (typeof successFlag !== 'undefined' && successFlag === true) {
        if (successPopup) {
            // Set timeout to ensure DOM is fully loaded
            setTimeout(() => {
                successPopup.style.display = 'flex'; // Using flex instead of block for better centering
                
                // Make sure it appears above cookie popup
                const cookiePopup = document.getElementById('cookie-popup');
                if (cookiePopup) {
                    cookiePopup.style.zIndex = '1000';
                }
            }, 100);
        }
    }
    
    // Add event listeners for closing the popup
    if (closeSuccessBtn && successPopup) {
        closeSuccessBtn.addEventListener('click', function() {
            successPopup.style.display = 'none';
        });
        
        // Close when clicking outside the popup content
        successPopup.addEventListener('click', function(event) {
            if (event.target === this) {
                this.style.display = 'none';
            }
        });
    }
});