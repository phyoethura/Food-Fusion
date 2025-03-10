document.addEventListener("DOMContentLoaded", function() {
    const menuIcon = document.getElementById("menu-icon");
    const navLinks = document.getElementById("nav-links");
    const signupBtn = document.getElementById("signup-btn");
    const profileBtn = document.getElementById("profile-btn");
    const signupPopup = document.getElementById("signup-popup");
    const loginPopup = document.getElementById("login-popup");
    const closeBtn = document.getElementById("close-btn");
    const loginCloseBtn = document.getElementById("login-close-btn");
    const cookiePopup = document.getElementById("cookie-popup");
    const acceptBtn = document.getElementById("accept-btn");
    const loginLink = document.getElementById("login-link");
    const signupLink = document.getElementById("signup-link");
    const signupForm = document.getElementById("signup-form");
    const loginForm = document.getElementById("login-form");
    const signupSuccess = document.getElementById("signup-success");
    const loginSuccess = document.getElementById("login-success");
    const signupError = document.getElementById("signup-error");
    const loginError = document.getElementById("login-error");

    // Check if signup popup exists and there's no active session
    if (signupPopup && signupBtn) {
        // Show the signup popup when the page loads
        signupPopup.style.display = 'block';
    }
    
    // Set initial state for mobile
    if (window.innerWidth <= 768) {
        navLinks.style.display = "none";
    }

    // Function to handle responsive navigation display
    function handleResponsiveNav() {
        if (window.innerWidth > 768) {
            // Always show nav on desktop
            navLinks.style.display = "flex";
        } else {
            // Default to hidden on mobile unless manually toggled
            if (!navLinks.classList.contains('active')) {
                navLinks.style.display = "none";
            }
        }
    }

    // Initialize responsive navigation
    handleResponsiveNav();

    // Listen for window resize to adjust navigation display
    window.addEventListener("resize", handleResponsiveNav);

    // Simple toggle for mobile menu
    if (menuIcon) {
        menuIcon.addEventListener("click", function() {
            // Simple toggle - if nav is visible, hide it; if hidden, show it
            if (navLinks.style.display === "block") {
                navLinks.style.display = "none";
                navLinks.classList.remove('active');
            } else {
                navLinks.style.display = "block";
                navLinks.classList.add('active');
            }
        });
    }

    // Show signup popup
    if (signupBtn) {
        signupBtn.addEventListener("click", function() {
            signupPopup.style.display = "block";
            if (loginPopup) loginPopup.style.display = "none";
            signupSuccess.style.display = "none";
            signupError.style.display = "none";
        });
    }

    // Show login popup if clicking profile when not logged in
    if (profileBtn) {
        profileBtn.addEventListener("click", function(e) {
            e.preventDefault();
            loginPopup.style.display = "block";
            if (signupPopup) signupPopup.style.display = "none";
            loginSuccess.style.display = "none";
            loginError.style.display = "none";
        });
    }

    // Close signup popup
    if (closeBtn) {
        closeBtn.addEventListener("click", function() {
            signupPopup.style.display = "none";
        });
    }

    // Close login popup
    if (loginCloseBtn) {
        loginCloseBtn.addEventListener("click", function() {
            loginPopup.style.display = "none";
        });
    }

    // Close popups when clicking outside
    window.addEventListener("click", function(event) {
        if (signupPopup && event.target == signupPopup) {
            signupPopup.style.display = "none";
        }
        if (loginPopup && event.target == loginPopup) {
            loginPopup.style.display = "none";
        }
    });

    // Switch to login popup
    if (loginLink) {
        loginLink.addEventListener("click", function(e) {
            e.preventDefault();
            signupPopup.style.display = "none";
            loginPopup.style.display = "block";
            loginSuccess.style.display = "none";
            loginError.style.display = "none";
        });
    }

    // Switch to signup popup
    if (signupLink) {
        signupLink.addEventListener("click", function(e) {
            e.preventDefault();
            loginPopup.style.display = "none";
            signupPopup.style.display = "block";
            signupSuccess.style.display = "none";
            signupError.style.display = "none";
        });
    }

    // Handle signup form submission with AJAX
    if (signupForm) {
        signupForm.addEventListener("submit", function(e) {
            e.preventDefault();
            
            // Validate passwords match
            const password = document.getElementById("password").value;
            const confirmPassword = document.getElementById("confirm-password").value;
            
            if (password !== confirmPassword) {
                signupError.textContent = "Passwords do not match!";
                signupError.style.display = "block";
                return;
            }
            
            // Create FormData object
            const formData = new FormData(signupForm);
            
            // Send AJAX request
            fetch('signup_handler.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    // Reset the form
                    signupForm.reset();
                    
                    // Show success message
                    signupSuccess.textContent = data.message;
                    signupSuccess.style.display = "block";
                    signupError.style.display = "none";
                    
                    // Automatically switch to login after 3 seconds
                    setTimeout(function() {
                        signupPopup.style.display = "none";
                        loginPopup.style.display = "block";
                        loginSuccess.style.display = "none";
                        loginError.style.display = "none";
                    }, 3000);
                } else {
                    // Show error message
                    signupError.textContent = data.message;
                    signupError.style.display = "block";
                    signupSuccess.style.display = "none";
                }
            })
            .catch(error => {
                console.error('Error:', error);
                signupError.textContent = "An error occurred. Please try again.";
                signupError.style.display = "block";
                signupSuccess.style.display = "none";
            });
        });
    }

    // Handle login form submission with AJAX
    if (loginForm) {
        loginForm.addEventListener("submit", function(e) {
            e.preventDefault();
            
            // Create FormData object
            const formData = new FormData(loginForm);
            
            // Clear previous error/success messages
            loginSuccess.style.display = "none";
            loginError.style.display = "none";
            
            // Send AJAX request
            fetch('login_handler.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    // Reset the form
                    loginForm.reset();
                    
                    // Show success message
                    loginSuccess.textContent = data.message;
                    loginSuccess.style.display = "block";
                    
                    // Refresh the page after 2 seconds to update UI based on session
                    setTimeout(function() {
                        window.location.reload();
                    }, 2000);
                } else {
                    // Show error message
                    loginError.textContent = data.message;
                    loginError.style.display = "block";
                    
                    // If account is locked, disable the login button for 3 minutes
                    if (data.message.includes("Account is locked") || data.message.includes("Too many failed")) {
                        const loginButton = loginForm.querySelector("button[type='submit']");
                        loginButton.disabled = true;
                        
                        // If there's a specific countdown provided, we could show it
                        if (data.message.includes("Try again in")) {
                            // Start a countdown timer to re-enable the button
                            const countdownInterval = setInterval(function() {
                                // Update message with new countdown
                                loginError.textContent = data.message;
                                
                                // If it's done, clear interval and enable button
                                if (data.message.includes("Try again in 0 minute(s) and 0 second(s)")) {
                                    clearInterval(countdownInterval);
                                    loginButton.disabled = false;
                                    loginError.textContent = "Account unlocked. You may try again.";
                                }
                            }, 1000);
                            
                            // Re-enable after 3 minutes in any case
                            setTimeout(function() {
                                clearInterval(countdownInterval);
                                loginButton.disabled = false;
                                loginError.textContent = "Account unlocked. You may try again.";
                            }, 3 * 60 * 1000);
                        } else {
                            // General 3-minute lockout
                            setTimeout(function() {
                                loginButton.disabled = false;
                                loginError.textContent = "Account unlocked. You may try again.";
                            }, 3 * 60 * 1000);
                        }
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                loginError.textContent = "An error occurred. Please try again.";
                loginError.style.display = "block";
            });
        });
    }

        // Check if the user has already accepted cookies
    // Modified cookie popup functionality
    if (!localStorage.getItem("cookiesAccepted") && !localStorage.getItem("cookiesRejected")) {
        if (cookiePopup) {
            // Show cookie popup
            cookiePopup.style.display = "block";
            
            // Prevent interaction with main content
            document.body.classList.add('cookie-pending');
            
            // Handle accept cookie button
            if (acceptBtn) {
                acceptBtn.addEventListener("click", function() {
                    cookiePopup.style.display = "none";
                    document.body.classList.remove('cookie-pending');
                    
                    // Save preference in localStorage
                    localStorage.setItem("cookiesAccepted", "true");
                });
            }
            
            // Handle reject cookie button
            const rejectBtn = document.getElementById("reject-btn");
            if (rejectBtn) {
                rejectBtn.addEventListener("click", function() {
                    cookiePopup.style.display = "none";
                    document.body.classList.remove('cookie-pending');
                    
                    // Save rejection preference in localStorage
                    localStorage.setItem("cookiesRejected", "true");
                    
                    // You could add additional logic here for cookie rejection
                    // For example, disabling certain features or tracking
                });
            }
        }
    }


    // Profile popup elements
    const profilePopup = document.getElementById("profile-popup");
    const profileCloseBtn = document.getElementById("profile-close-btn");
    const profileForm = document.getElementById("profile-form");
    const profileSuccess = document.getElementById("profile-success");
    const profileError = document.getElementById("profile-error");
    
    const profileLink = document.getElementById("profile-link");

    // Show profile popup when clicking on profile when logged in
    if (profileLink) {
        profileLink.addEventListener("click", function(e) {
            e.preventDefault();
            // Load user data
            loadUserProfile();
            // Show profile popup
            profilePopup.style.display = "block";
        });
    }
    
    // Close profile popup
    if (profileCloseBtn) {
        profileCloseBtn.addEventListener("click", function() {
            profilePopup.style.display = "none";
        });
    }
    
    // Close popup when clicking outside
    window.addEventListener("click", function(event) {
        if (event.target == profilePopup) {
            profilePopup.style.display = "none";
        }
    });
    
    // Load user profile data
    function loadUserProfile() {
        fetch('get_profile.php')
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                document.getElementById("profile-firstname").value = data.user.first_name;
                document.getElementById("profile-lastname").value = data.user.last_name;
                document.getElementById("profile-email").value = data.user.email;
                document.getElementById("profile-role").value = data.user.role || 'User';
                
                // Reset password fields
                document.getElementById("current-password").value = '';
                document.getElementById("new-password").value = '';
                document.getElementById("confirm-new-password").value = '';
                
                // Hide messages
                profileSuccess.style.display = "none";
                profileError.style.display = "none";
            } else {
                profileError.textContent = "Failed to load profile: " + data.message;
                profileError.style.display = "block";
            }
        })
        .catch(error => {
            console.error('Error:', error);
            profileError.textContent = "An error occurred while loading your profile.";
            profileError.style.display = "block";
        });
    }
    
    // Handle profile form submission
    if (profileForm) {
        profileForm.addEventListener("submit", function(e) {
            e.preventDefault();
            
            // Validate new password if present
            const currentPassword = document.getElementById("current-password").value;
            const newPassword = document.getElementById("new-password").value;
            const confirmNewPassword = document.getElementById("confirm-new-password").value;
            
            // Check if user wants to change password
            if (newPassword || confirmNewPassword || currentPassword) {
                if (!currentPassword) {
                    profileError.textContent = "Current password is required to change password.";
                    profileError.style.display = "block";
                    return;
                }
                
                if (newPassword !== confirmNewPassword) {
                    profileError.textContent = "New passwords do not match.";
                    profileError.style.display = "block";
                    return;
                }
                
                if (newPassword.length < 6) {
                    profileError.textContent = "New password must be at least 6 characters.";
                    profileError.style.display = "block";
                    return;
                }
            }
            
            // Create FormData
            const formData = new FormData(profileForm);
            
            // Send AJAX request
            fetch('update_profile.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    // Show success message
                    profileSuccess.textContent = data.message;
                    profileSuccess.style.display = "block";
                    profileError.style.display = "none";
                    
                    // Clear password fields
                    document.getElementById("current-password").value = '';
                    document.getElementById("new-password").value = '';
                    document.getElementById("confirm-new-password").value = '';
                } else {
                    // Show error message
                    profileError.textContent = data.message;
                    profileError.style.display = "block";
                    profileSuccess.style.display = "none";
                }
            })
            .catch(error => {
                console.error('Error:', error);
                profileError.textContent = "An error occurred while updating your profile.";
                profileError.style.display = "block";
                profileSuccess.style.display = "none";
            });
        });
    }
});
