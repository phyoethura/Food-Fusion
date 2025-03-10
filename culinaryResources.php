<?php
// Start session
session_start();

// Check if user is logged in
$loggedIn = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Culinary Resources - FoodFusion</title>
    <link rel="stylesheet" href="css/hello.css">
    <link rel="stylesheet" href="css/eduResources.css">
    
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
            <?php else: ?>
                
            <?php endif; ?>
        </div>
                
        <div class="mainContent">

            <!--Navi-->
            <nav class="navbar">
                <div class="menu-icon" id="menu-icon">
                    <i class="fas fa-bars"></i>
                </div>
                <ul class="nav-links" id="nav-links">
                    <li><a href="homepage.php">Home</a></li>
                    <li><a href="aboutus.php">About Us</a></li>
                    <li><a href="recipecollection.php">Recipe Collections</a></li>
                    <li><a href="communityCookbook.php">Community Cookbook</a></li>
                    <li><a href="contactUs.php">Contact Us</a></li>
                    <li><a class="active" href="culinaryResources.php">Culinary Resources</a></li>
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
            
            <header>
                <h1>Culinary Resources</h1>
                <p>Enhance your cooking skills with our collection of downloadable recipe cards, cooking tutorials, and instructional videos.</p>
            </header>
            
            <main>
                <!-- 📜 Downloadable Recipe Cards -->
                <section class="section">
                    <h2>📜 Downloadable Recipe Cards</h2>
                    <p>Print these beautifully designed recipe cards for your kitchen collection:</p>
                    <ul>
                        <li><a href="resources/calinary_resources/recipe_cards/pasta.jpg" download>Classic Italian Pasta</a></li>
                        <li><a href="resources/calinary_resources/recipe_cards/bread.jpg" download>Homemade Bread Guide</a></li>
                        <li><a href="resources/calinary_resources/recipe_cards/vegan.jpg" download>Vegan Meal Prep</a></li>
                        <li><a href="resources/calinary_resources/recipe_cards/desserts.jpg" download>Quick Desserts</a></li>
                        <li><a href="resources/calinary_resources/recipe_cards/smoothies.jpg" download>Healthy Smoothies</a></li>
                    </ul>
                </section>

                <!-- 🔪 Cooking Tutorials -->
                <section class="section">
                    <h2>🔪 Cooking Tutorials</h2>
                    <p>Learn essential techniques with our detailed guides:</p>
                    <ul>
                        <li><a href="resources/calinary_resources/pdfs/knife_skill.pdf" download>Knife Skills for Beginners (PDF)</a></li>
                        <li><a href="resources/calinary_resources/pdfs/sauces.pdf" download>Perfecting Sauces (PDF)</a></li>
                        <li><a href="resources/calinary_resources/pdfs/baking.pdf" download>Baking Essentials (PDF)</a></li>
                        <li><a href="resources/calinary_resources/pdfs/kitchen_hacks.pdf" download>Time-Saving Kitchen Hacks (PDF)</a></li>
                        <li><a href="resources/calinary_resources/pdfs/flavor.pdf" download>Flavor Pairing Guide (PDF)</a></li>
                    </ul>
                </section>

                <!-- 🍳 Instructional Videos -->
                <section class="videos">
                    <h2>🍳 Instructional Videos</h2>
                    <p>Watch and learn various cooking techniques:</p>
                    <div class="video-container">
                        <h3>Mastering Knife Skills</h3>
                        <video controls>
                            <source src="resources\calinary_resources\videos\basic_kinfe_skill.mp4" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                        <p>A comprehensive overview of Mastering Knife Skills</p>
                    </div>
                    
                    <div class="video-container">
                        <h3>Perfect Pasta Techniques</h3>
                        <video controls>
                            <source src="resources\calinary_resources\videos\pasta.mp4" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                        <p>Explore the Perfect Pasta Techniques.</p>
                    </div>
                    
                    <div class="video-container">
                        <h3>Baking Secrets Revealed</h3>
                        <video controls>
                            <source src="resources/calinary_resources/videos/bake.mp4" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                        <p>Baking Secrets Revealed</p>
                    </div>
                </section>
            </main>

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

    <script src="js/script.js"></script>
    
</body>
</html>