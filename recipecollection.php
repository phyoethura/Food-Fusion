<?php
// Start session
session_start();
$loggedIn = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;

// Database connection
require_once 'db_connect.php';

// Get selected category from AJAX request
$selectedCategory = isset($_GET['category']) ? $_GET['category'] : '';

// Fetch distinct categories for the dropdown
$categoryQuery = "SELECT DISTINCT categories FROM recipes WHERE categories IS NOT NULL";
$categoryResult = $conn->query($categoryQuery);

if ($selectedCategory) {
    $stmt = $conn->prepare("SELECT title, description, categories, dietary_preferences, difficulty_level, ingredients FROM recipes WHERE categories = ?");
    $stmt->bind_param("s", $selectedCategory);
} else {
    $stmt = $conn->prepare("SELECT title, description, categories, dietary_preferences, difficulty_level, ingredients FROM recipes");
}

$stmt->execute();
$result = $stmt->get_result();
$recipes = $result->fetch_all(MYSQLI_ASSOC); // Store all rows in an array
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe Collections</title>
    <link rel="stylesheet" href="css/hello.css">
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="css/recipecollection.css">
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="headerIcon">
            <h1>FoodFusion</h1>
            <?php if (!$loggedIn): ?>
                <button class="signup-btn" id="signup-btn">Join Us</button>
            <?php endif; ?>
        </div>
                
        <div class="mainContent">
            <!-- Navigation -->
            <nav class="navbar">
                <div class="menu-icon" id="menu-icon">
                    <i class="fas fa-bars"></i>
                </div>
                <ul class="nav-links" id="nav-links">
                    <li><a href="homepage.php">Home</a></li>
                    <li><a href="aboutus.php">About Us</a></li>
                    <li><a class="active" href="recipecollection.php">Recipe Collections</a></li>
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

            <!-- Categories Dropdown -->
            <div class="container" style="align-items: center; padding-top:5px">
                <div class="dropdown">
                    <select id="category-select" class="dropdown-btn">
                        <option value="">All Categories</option>
                        <?php while ($row = $categoryResult->fetch_assoc()): ?>
                            <option value="<?php echo htmlspecialchars($row['categories']); ?>" 
                                <?php echo ($selectedCategory == $row['categories']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($row['categories']); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
            </div>
            
            <!-- Recipe List -->
            <div class="recipeContainer" id="recipe-container">
                <?php if (count($recipes) > 0): ?>
                    <?php foreach ($recipes as $row): ?>
                        <div class="recipe">
                            <h2><?php echo htmlspecialchars($row['title']); ?></h2>
                            <p><strong>Category:</strong> <?php echo htmlspecialchars($row['categories']); ?></p>
                            <p><strong>Dietary:</strong> <?php echo htmlspecialchars($row['dietary_preferences']); ?></p>
                            <p><strong>Difficulty:</strong> <?php echo htmlspecialchars($row['difficulty_level']); ?></p>
                            <p><strong>Ingredients:</strong></p>
                            <?php 
                                // Assuming ingredients are stored as comma-separated values
                                $ingredientsList = explode(',', $row['ingredients']);
                                if (count($ingredientsList) > 0): 
                            ?>
                            <ul class="ingredients-list">
                                <?php foreach ($ingredientsList as $ingredient): ?>
                                    <li><?php echo htmlspecialchars(trim($ingredient)); ?></li>
                                <?php endforeach; ?>
                            </ul>
                            <?php endif; ?>
                            <p><strong>Description:</strong> <?php echo htmlspecialchars($row['description']); ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No recipes found.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Footer -->
        <div class="footerIcon">
            @All Rights Reserved.
        </div>
    </div>
    
    <!-- Social Media Links -->
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

    <!-- JavaScript -->
    <script src="js/recipecollection.js"></script>
    <script src="js/script.js"></script>

    <script>
        document.getElementById("category-select").addEventListener("change", function () {
            const selectedCategory = this.value;
            window.location.href = "recipecollection.php?category=" + encodeURIComponent(selectedCategory);
        });
    </script>
</body>
</html>
