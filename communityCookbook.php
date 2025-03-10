<?php
// Start session
session_start();
require_once 'db_connect.php'; // Include database connection

$loggedIn = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
$userId = $loggedIn ? $_SESSION['user_id'] : null;
// Handle recipe submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_recipe'])) {
    if ($loggedIn) {
        $title = $_POST['name'];
        $categories = $_POST['cuisine'];
        $dietary = $_POST['dietary'];
        $difficulty = $_POST['difficulty'];
        $description = $_POST['description'];
        $ingredients = $_POST['ingredients']; // Add this line to get ingredients

        $stmt = $conn->prepare("INSERT INTO community_recipes (title, description, ingredients, categories, dietary_preferences, difficulty_level, submitted_by) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssi", $title, $description, $ingredients, $categories, $dietary, $difficulty, $userId);
        $stmt->execute();
        $stmt->close();

        // Redirect to prevent form resubmission
        header("Location: communityCookbook.php");
        exit();
    } else {
        echo "<script>alert('You must be logged in to submit a recipe.');</script>";
    }
}

// Fetch user-specific recipes
$yourRecipes = [];
if ($loggedIn) {
    $stmt = $conn->prepare("SELECT * FROM community_recipes WHERE submitted_by = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $yourRecipes[] = $row;
    }
    $stmt->close();
}

// Fetch all community recipes
$communityRecipes = [];
$result = $conn->query("SELECT * FROM community_recipes");
while ($row = $result->fetch_assoc()) {
    $communityRecipes[] = $row;
}
// Handle like action (AJAX request)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['recipe_id']) && empty($_POST['submit_recipe'])) {
    if (!$loggedIn) {
        echo json_encode(['error' => 'User not logged in']);
        exit();
    }

    $recipeId = $_POST['recipe_id'];
    $stmt = $conn->prepare("SELECT * FROM interaction_like WHERE user_id = ? AND community_recipe_id = ?");
    $stmt->bind_param("ii", $userId, $recipeId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Unlike the recipe
        $stmt = $conn->prepare("DELETE FROM interaction_like WHERE user_id = ? AND community_recipe_id = ?");
        $stmt->bind_param("ii", $userId, $recipeId);
        $stmt->execute();
        $liked = false;
    } else {
        // Like the recipe
        $stmt = $conn->prepare("INSERT INTO interaction_like (user_id, community_recipe_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $userId, $recipeId);
        $stmt->execute();
        $liked = true;
    }

    // Get updated like count
    $stmt = $conn->prepare("SELECT COUNT(*) FROM interaction_like WHERE community_recipe_id = ?");
    $stmt->bind_param("i", $recipeId);
    $stmt->execute();
    $stmt->bind_result($likeCount);
    $stmt->fetch();

    echo json_encode(['liked' => $liked, 'like_count' => $likeCount]);
    exit();
}

// Fetch community recipes with like count
$communityRecipes = [];
$stmt = $conn->prepare("
    SELECT cr.*, 
            (SELECT COUNT(*) FROM interaction_like WHERE community_recipe_id = cr.community_recipe_id) AS like_count,
            (SELECT COUNT(*) FROM interaction_like WHERE community_recipe_id = cr.community_recipe_id AND user_id = ?) AS user_liked
    FROM community_recipes cr
");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $communityRecipes[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HomePage</title>
    <link rel="stylesheet" href="css/hello.css">
    <link rel="stylesheet" href="css/communityCookbook.css">
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
                    <li><a class="active" href="communityCookbook.php">Community Cookbook</a></li>
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

            <!-- Create Recipe Button -->
            <div class="container" style="align-items: center; padding: 10px">
                <button class="open-recipe-btn" id="open-recipe-btn">Create Recipe</button>

                <!-- Recipe Popup -->
                <div id="recipe-modal" class="modal">
                    <div class="modal-content">
                        <span class="close-btn" id="close-recipe-btn">&times;</span>
                        <h2>Create Your Recipe</h2>
                        <form class="recipe-form" method="POST">
                            <label for="name">Name:</label>
                            <input type="text" name="name" id="name" placeholder="Enter recipe name" required>

                            <label for="cuisine">Cuisine:</label>
                            <input type="text" name="cuisine" id="cuisine" placeholder="e.g., Italian, Chinese, Mexican" required>

                            <label for="dietary">Dietary:</label>
                            <select name="dietary" id="dietary">
                                <option value="Vegetarian">Vegetarian</option>
                                <option value="Non-Vegetarian">Non-Vegetarian</option>
                                <option value="Vegan">Vegan</option>
                            </select>

                            <label for="difficulty">Difficulty:</label>
                            <select name="difficulty" id="difficulty">
                                <option value="Easy">Easy</option>
                                <option value="Medium">Medium</option>
                                <option value="Hard">Hard</option>
                            </select>
                            <label for="ingredients">Ingredients (comma separated):</label>
                            <textarea name="ingredients" id="ingredients" rows="3" placeholder="Enter ingredients separated by commas..." required></textarea>

                            <label for="description">Description:</label>
                            <textarea name="description" id="description" rows="4" placeholder="Write a short description..." required></textarea>

                            <button type="submit" name="submit_recipe">Submit Recipe</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- User Recipes -->
            <div class="container">
                <h3 style="padding: 30px;">Your Recipes:</h3>
                <div class="recipeContainer">
                    <?php if ($loggedIn && !empty($yourRecipes)): ?>
                        <?php foreach ($yourRecipes as $recipe): ?>
                            <div class="recipe">
                                <h2><?= htmlspecialchars($recipe['title']); ?></h2>
                                <p><strong>Category:</strong> <?= htmlspecialchars($recipe['categories']); ?></p>
                                <p><strong>Dietary:</strong> <?= htmlspecialchars($recipe['dietary_preferences']); ?></p>
                                <p><strong>Difficulty:</strong> <?= htmlspecialchars($recipe['difficulty_level']); ?></p>
                                <p><strong>Ingredients:</strong></p>
                                <?php 
                                    // Display ingredients as a list
                                    $ingredientsList = explode(',', $recipe['ingredients']);
                                    if (count($ingredientsList) > 0): 
                                ?>
                                <ul class="ingredients-list">
                                    <?php foreach ($ingredientsList as $ingredient): ?>
                                        <li><?php echo htmlspecialchars(trim($ingredient)); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                                <?php endif; ?>
                                <p><strong>Description:</strong> <?= htmlspecialchars($recipe['description']); ?></p>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No recipes found. Start creating your own!</p>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Horizontal line to separate sections -->
            <hr style="width: 100%; margin: 20px auto; border: 1px solid #ccc; ">

            <h3 style="padding: 30px;">Community Cookbook</h3>
            <!-- Place this in your communityCookbook.php file, replacing the existing recipe container -->
            <div class="recipeContainer">
                <?php foreach ($communityRecipes as $recipe): ?>
                    <div class="recipe" id="recipe-<?php echo $recipe['community_recipe_id']; ?>">
                        <h2><?php echo htmlspecialchars($recipe['title']); ?></h2>
                        <p><strong>Name:</strong> <?php echo htmlspecialchars($recipe['title']); ?></p>
                        <p><strong>Dietary:</strong> <?php echo htmlspecialchars($recipe['dietary_preferences']); ?></p>
                        <p><strong>Difficulty:</strong> <?php echo htmlspecialchars($recipe['difficulty_level']); ?></p>
                        <p><strong>Ingredients:</strong></p>
                        <?php 
                            // Display ingredients as a list
                            $ingredientsList = explode(',', $recipe['ingredients']);
                            if (count($ingredientsList) > 0 && !empty(trim($recipe['ingredients']))): 
                        ?>
                        <ul class="ingredients-list">
                            <?php foreach ($ingredientsList as $ingredient): ?>
                                <li><?php echo htmlspecialchars(trim($ingredient)); ?></li>
                            <?php endforeach; ?>
                        </ul>
                        <?php endif; ?>
                        <p><strong>Description:</strong> <?php echo htmlspecialchars($recipe['description']); ?></p>
                        
                        <!-- Love Button -->
                        <button type="button" class="reactButton love-btn" data-recipe-id="<?php echo $recipe['community_recipe_id']; ?>">
                            <i class="fas fa-heart" style="color: <?php echo ($recipe['user_liked'] > 0) ? 'red' : 'black'; ?>;"></i>
                        </button>
                        
                        <!-- Like Count -->
                        <?php if ($recipe['like_count'] > 0): ?>
                            <span class="like-count">Liked by <?php echo $recipe['like_count']; ?></span>
                        <?php else: ?>
                            <span class="like-count" style="display: none;"></span>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
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
    <script src="js/communityCookbook.js"></script>
    <script>
    $(document).ready(function() {
        $(".love-button").click(function() {
            var button = $(this);
            var recipeId = button.data("recipe-id");
            var icon = button.find("i");
            var likeCountSpan = button.find(".like-count");

            $.post("communityCookbook.php", { like_action: 1, recipe_id: recipeId }, function(response) {
                var data = JSON.parse(response);
                if (data.error) {
                    alert(data.error);
                } else {
                    var likeCount = data.like_count;
                    var isLiked = icon.css("color") === "rgb(0, 0, 0)"; // Check if color is black
                    icon.css("color", isLiked ? "red" : "black"); // Toggle color
                    likeCountSpan.text("Liked by " + likeCount);
                }
            });
        });
    });
    
        
    
    </script>
    
</body>
</html>