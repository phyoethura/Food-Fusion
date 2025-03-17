<?php
// Start session
session_start();

require_once 'db_connect.php';

// Check if user is logged in
$loggedIn = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
$userId = $loggedIn ? $_SESSION['user_id'] : null;

// Handle form submission
$successMessage = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    
    $contactMessage = $_POST['message'];
    
    // Basic validation
    if (empty($contactMessage)) {
        $errorMessage = "Please fill out all fields.";
    }  else {
        // Prepare and execute SQL query to insert message
        // Only storing user_id and message as requested
        $stmt = $conn->prepare("INSERT INTO contact_messages (user_id, message) VALUES (?, ?)");
        $stmt->bind_param("is", $userId, $contactMessage);
        
        if ($stmt->execute()) {
            $successMessage = true;
            // Clear form data after successful submission
            $contactMessage = "";
        } else {
            $errorMessage = "Error: " . $stmt->error;
        }
        
        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - FoodFusion</title>
    <link rel="stylesheet" href="css/hello.css">
    <link rel="stylesheet" href="css/contactUs.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <div class="container">
        <!--Header-->
        <div class="headerIcon">
            <h1>FoodFusion</h1>
            <?php if (!$loggedIn): ?>
                <button class="signup-btn" id="signup-btn">Join Us</button>
            <?php endif; ?>
        </div>
                
        <div class="mainContent">
            <!--Navigation-->
            <nav class="navbar">
                <div class="menu-icon" id="menu-icon">
                    <i class="fas fa-bars"></i>
                </div>
                <ul class="nav-links" id="nav-links">
                    <li><a href="homepage.php">Home</a></li>
                    <li><a href="aboutus.php">About Us</a></li>
                    <li><a href="recipecollection.php">Recipe Collections</a></li>
                    <li><a href="communityCookbook.php">Community Cookbook</a></li>
                    <li><a class="active" href="contactUs.php">Contact Us</a></li>
                    <li><a href="culinaryResources.php">Culinary Resources</a></li>
                    <li><a href="eduResources.php">Educational Resources</a></li>
                    <li style="float:right"><a href="#" <?php echo !$loggedIn ? 'id="profile-btn"' : 'id="profile-link"'; ?>><i class="fas fa-user"></i> Profile</a></li>
                </ul>
            </nav>
                <!-- Profile Settings Popup -->
                <div class="profile-popup" id="profile-popup">
                    <div class="profile-popup-content">
                        <span class="close-btn" id="profile-close-btn">&times;</span>
                        <h2>Profile Settings</h2>
                        <div class="success-message" id="profile-success" style="display: none;">
                            Profile updated successfully!
                        </div>
                        <div class="error-message" id="profile-error" style="display: none;"></div>
                        
                        <form id="profile-form">
                            <div class="form-group">
                                <label for="profile-firstname">First Name:</label>
                                <input type="text" id="profile-firstname" name="firstname" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="profile-lastname">Last Name:</label>
                                <input type="text" id="profile-lastname" name="lastname" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="profile-email">Email:</label>
                                <input type="email" id="profile-email" name="email" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="profile-role">Role:</label>
                                <input type="text" id="profile-role" name="role" disabled>
                            </div>
                            
                            <div class="form-group password-section">
                                <h3>Change Password (optional)</h3>
                                <label for="current-password">Current Password:</label>
                                <input type="password" id="current-password" name="current-password">
                                
                                <label for="new-password">New Password:</label>
                                <input type="password" id="new-password" name="new-password">
                                
                                <label for="confirm-new-password">Confirm New Password:</label>
                                <input type="password" id="confirm-new-password" name="confirm-new-password">
                            </div>
                            
                            <button type="submit">Update Profile</button>
                            
                        </form>
                        <div class="logout-btn-container">
                            <a href="logout.php" class="logout-btn">Logout</a>
                        </div>
                    </div>
                </div>
            
            <!-- Contact Form Section -->
            <div class="content" style="display: flex; justify-content: center; align-items: center; padding: 50px 20px;">
                <div class="contact-box">
                    <h2>Contact Us</h2>
                    <p>Have questions, suggestions, or feedback? We'd love to hear from you!</p>
                    
                    <?php if (isset($errorMessage)): ?>
                        <div class="error-message">
                            <?php echo $errorMessage; ?>
                        </div>
                    <?php endif; ?>
                    
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" onsubmit="return validateForm()">
                        
                        
                        <label for="message">Message:</label>
                        <textarea id="message" name="message" rows="5"><?php echo isset($contactMessage) ? $contactMessage : ''; ?></textarea>
                        
                        <div id="error-message" class="error-message" style="display: none;"></div>
                        
                        <button type="submit">Send Message</button>
                    </form>
                </div>
            </div>
        </div>

        <!--Footer-->
        <div class="footerIcon">
            @All Right Reserved.
        </div>
    </div>
    
    <div class="social-media-links">
        <a href="https://www.facebook.com" target="_blank"><i class="fab fa-facebook-f"></i></a>
        <a href="https://www.twitter.com" target="_blank"><i class="fab fa-twitter"></i></a>
        <a href="https://www.instagram.com" target="_blank"><i class="fab fa-instagram"></i></a>
    </div>

    <!-- Success Popup -->
    <div class="success-popup" id="success-popup" style="display: none;">
        <div class="success-popup-content">
            <h3><i class="fas fa-check-circle"></i> Thank You!</h3>
            <p>Your message has been sent successfully. We'll get back to you soon!</p>
            <button id="close-success-popup">Close</button>
        </div>
    </div>

    <!-- Signup Popup -->
    <div class="signup-popup" id="signup-popup">
        <div class="signup-popup-content">
            <span class="close-btn" id="close-btn">&times;</span>
            <h2>Sign Up</h2>
            <div class="success-message" id="signup-success">
                Your account has been created successfully! You can now log in.
            </div>
            <div class="error-message" id="signup-error" style="display: none; background-color: #f8d7da; color: #721c24; padding: 15px; margin-bottom: 20px; border-radius: 4px; text-align: center;"></div>
            <form id="signup-form">
                <label for="firstname">First Name:</label>
                <input type="text" id="firstname" name="firstname" required>
                
                <label for="lastname">Last Name:</label>
                <input type="text" id="lastname" name="lastname" required>
                
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
                
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
                
                <label for="confirm-password">Confirm Password:</label>
                <input type="password" id="confirm-password" name="confirm-password" required>
                
                <button type="submit">Sign Up</button>
            </form>
            <div class="form-link">
                <a href="#" id="login-link">Have already an account?</a>
            </div>
        </div>
    </div>

    <!-- Login Popup -->
    <div class="login-popup" id="login-popup">
        <div class="login-popup-content">
            <span class="close-btn" id="login-close-btn">&times;</span>
            <h2>Login</h2>
            <div class="success-message" id="login-success">
                You have successfully logged in!
            </div>
            <div class="error-message" id="login-error" style="display: none; background-color: #f8d7da; color: #721c24; padding: 15px; margin-bottom: 20px; border-radius: 4px; text-align: center;"></div>
            <form id="login-form">
                <label for="login-email">Email:</label>
                <input type="email" id="login-email" name="login-email" required>
                
                <label for="login-password">Password:</label>
                <input type="password" id="login-password" name="login-password" required>
                
                <button type="submit">Login</button>
            </form>
            <div class="form-link">
                <a href="#" id="signup-link">Don't have an account? Sign up</a>
            </div>
        </div>
    </div>

    <!-- Replace the cookie popup in homepage.php with this: -->
    <div class="cookie-popup" id="cookie-popup">
        <div class="cookie-popup-content">
            <p>We use cookies to ensure you get the best experience on our website. By continuing to use this site, you agree to our cookie policy. <a href="#">Learn more</a></p>
            <div class="cookie-buttons">
                <button class="accept-btn" id="accept-btn">Accept</button>
                <button class="reject-btn" id="reject-btn">Reject</button>
            </div>
        </div>
    </div>

    <!-- Include JavaScript files -->
    <script src="js/script.js"></script>
    <script src="js/contactUs.js"></script>
    <script>
    // Pass PHP session login status to JavaScript
    const isUserLoggedIn = <?php echo $loggedIn ? 'true' : 'false'; ?>;
    
    // This will help display the success popup when needed
    const successFlag = <?php echo $successMessage ? 'true' : 'false'; ?>;
    </script>
    

</body>
</html>