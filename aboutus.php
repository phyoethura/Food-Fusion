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
    <title>HomePage</title>
    <link rel="stylesheet" href="css/hello.css">
    
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
                    <li><a class="active" href="aboutus.php">About Us</a></li>
                    <li><a href="recipecollection.php">Recipe Collections</a></li>
                    <li><a href="communityCookbook.php">Community Cookbook</a></li>
                    <li><a href="contactUs.php">Contact Us</a></li>
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



            <div class="container" style="padding: 40px; background-color:rgb(255, 255, 255)">
                
                <h3>FoodFusion’s Culinary Philosophy & Values</h3>
                <p>At FoodFusion, we believe that cooking is more than just preparing meals—it’s an art, a tradition, and a way to bring people together. Our philosophy is rooted in creativity, inclusivity, and sustainability, ensuring that every dish tells a story and inspires home cooks worldwide.</p>
                <h4>🌿 Our Culinary Philosophy</h4>
                    <p>✔ Creativity in Cooking – We encourage experimentation in the kitchen, blending flavors, techniques, and traditions from different cultures.✔ Authenticity & Innovation – Honoring traditional recipes while embracing modern culinary trends.✔ Quality & Simplicity – Great food starts with fresh, high-quality ingredients and simple yet effective techniques.</p>
                    <h4>✨ Our Core Values</h4>
                <p>❤️ Community & Sharing – Food brings people together, and we aim to build a vibrant community where food lovers can share recipes, stories, and experiences.🌍 Sustainability & Conscious Cooking – We promote mindful eating, minimizing food waste, and supporting eco-friendly practices.📚 Education & Growth – From beginners to seasoned chefs, we provide resources to help everyone grow in their culinary journey.</p>
                At FoodFusion, we celebrate the joy of cooking and the connections it creates. Whether you're exploring new flavors, perfecting a family recipe, or discovering exciting food trends, we’re here to inspire and empower your culinary adventure.
                

            </div>
            <div class="container" style="padding: 40px; background-color:rgb(152, 237, 252)">
                
                
                <h3>👨‍🍳 Meet the FoodFusion Team</h3>
                <p>Our passionate team of chefs, food enthusiasts, and culinary experts work together to bring you the best recipes, tips, and cooking inspiration.</p>
                <h4>👩‍🍳 Emma Carter – Founder & Head Chef</h4>
                <p> "Cooking is an art, and every dish tells a story."Emma is the creative mind behind FoodFusion, with 15+ years of experience in global cuisine. She specializes in blending traditional flavors with modern techniques.</p>
                <h4>👨‍🍳 Alex Thompson – Culinary Director</h4>
                <p>"The secret to great cooking? Passion and fresh ingredients!" Alex oversees recipe development, ensuring each dish is flavorful, authentic, and easy to follow for home cooks.</p>
                <h4>📸 Sarah Lee – Food Photographer & Stylist</h4>
                <p>"A great dish deserves to be captured beautifully." Sarah brings recipes to life with her stunning food photography and presentation skills.</p>
                <h4>📝 David Wilson – Content & Community Manager </h4>
                <p>"Food is best enjoyed when shared." David manages our blog, community cookbook, and social engagement, connecting food lovers worldwide.</p>

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