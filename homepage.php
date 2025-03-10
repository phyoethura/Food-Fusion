<?php
// Start session
session_start();
require_once 'db_connect.php';


// Check if user is logged in
$loggedIn = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;


// Function to format date and time
function formatDateTime($dateTime) {
    $date = new DateTime($dateTime);
    return $date->format('F j, Y, g:i A');
}

// Function to format ingredients list
function formatIngredients($ingredientsText) {
    // Split ingredients by new lines or commas
    $ingredients = preg_split('/[,\n]+/', $ingredientsText);
    $ingredients = array_map('trim', $ingredients);
    $ingredients = array_filter($ingredients); // Remove empty entries
    
    return $ingredients;
}

// Fetch 4 random recipes
$recipeQuery = "SELECT recipe_id, title, description, categories, dietary_preferences, difficulty_level, ingredients 
                FROM recipes 
                ORDER BY RAND() 
                LIMIT 4";
$recipeResult = $conn->query($recipeQuery);

// Fetch upcoming events (ordered by date, events in the future)
$eventQuery = "SELECT event_id, event_name, event_description, event_date, location 
                FROM events 
                WHERE event_date > NOW() 
                ORDER BY event_date 
                LIMIT 2";
$eventResult = $conn->query($eventQuery);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HomePage</title>
    <link rel="stylesheet" href="css/hello.css">
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .recipe {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 15px;
            margin: 10px;
            background-color: #f9f9f9;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: transform 0.2s;
        }
        
        .recipe:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .recipe h2 {
            color: #2a9d8f;
            margin-top: 0;
        }
        
        .recipeContainer {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        
        .recipe {
            flex: 1 0 45%;
            max-width: 48%;
        }
        
        .event {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 15px;
            margin: 10px;
            background-color: #f9f9f9;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: transform 0.2s;
        }
        
        .event:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .event h2 {
            color: #e76f51;
            margin-top: 0;
        }
        
        .eventContainer {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        
        .event {
            flex: 1 0 45%;
            max-width: 48%;
        }
        
        @media (max-width: 768px) {
            .recipe, .event {
                max-width: 100%;
                margin: 10px 0;
            }
        }
        
        .difficulty-easy {
            color: #2a9d8f;
        }
        
        .difficulty-medium {
            color: #e9c46a;
        }
        
        .difficulty-hard {
            color: #e76f51;
        }
        
        .ingredients-list {
            background-color: #f0f8ff;
            border-left: 3px solid #2a9d8f;
            padding: 10px;
            margin: 10px 0;
            max-height: 150px;
            overflow-y: auto;
        }
        
        .ingredients-list h4 {
            margin-top: 0;
            color: #264653;
        }
        
        .ingredients-list ul {
            margin: 0;
            padding-left: 20px;
        }
        
        .ingredients-list li {
            margin-bottom: 4px;
        }
        
        .ingredient-toggle {
            background-color: #2a9d8f;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 3px;
            cursor: pointer;
            font-size: 0.9em;
            margin-top: 5px;
        }
        
        .ingredient-toggle:hover {
            background-color: #264653;
        }
        
        .hidden {
            display: none;
        }
    </style>
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
                    <li><a class="active" href="homepage.php">Home</a></li>
                    <li><a href="aboutus.php">About Us</a></li>
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



                <div class="container">
                <h3 style="padding: 40px; background-color: #2a9d8f; color: white;">
                FoodFusion is a culinary platform dedicated to promoting home cooking and culinary creativity among food enthusiasts. They have commissioned you to develop an engaging website that serves as a central hub for sharing recipes, culinary tips, and fostering a vibrant food community.
                </h3>
                
                <h3 style="padding: 10px">Featured Recipes</h3>
                <div class="recipeContainer">
                    <?php
                    // Check if we have recipes
                    if ($recipeResult && $recipeResult->num_rows > 0) {
                        $count = 0;
                        
                        // Output data of each row
                        while ($row = $recipeResult->fetch_assoc()) {
                            // Open a new row after every 2 recipes
                            if ($count % 2 == 0 && $count > 0) {
                                echo '</div><div class="recipeContainer">';
                            }
                            
                            // Format difficulty class
                            $difficultyClass = 'difficulty-' . strtolower($row['difficulty_level']);
                            
                            // Process ingredients
                            $ingredientsList = formatIngredients($row['ingredients']);
                            
                            echo '<div class="recipe">';
                            echo '<h2>' . htmlspecialchars($row['title']) . '</h2>';
                            echo '<p><strong>Category:</strong> ' . htmlspecialchars($row['categories']) . '</p>';
                            echo '<p><strong>Dietary:</strong> ' . htmlspecialchars($row['dietary_preferences']) . '</p>';
                            echo '<p><strong>Difficulty:</strong> <span class="' . $difficultyClass . '">' . htmlspecialchars($row['difficulty_level']) . '</span></p>';
                            echo '<p><strong>Description:</strong> ' . htmlspecialchars($row['description']) . '</p>';
                            
                            // Add toggle button for ingredients
                            echo '<button class="ingredient-toggle" onclick="toggleIngredients(\'ingredients-' . $row['recipe_id'] . '\')">Show Ingredients</button>';
                            
                            // Add ingredients section (hidden by default)
                            echo '<div id="ingredients-' . $row['recipe_id'] . '" class="ingredients-list hidden">';
                            echo '<h4>Ingredients</h4>';
                            echo '<ul>';
                            
                            foreach ($ingredientsList as $ingredient) {
                                echo '<li>' . htmlspecialchars($ingredient) . '</li>';
                            }
                            
                            echo '</ul>';
                            echo '</div>';
                            
                            echo '</div>';
                            
                            $count++;
                        }
                    } else {
                        // Display placeholders if no recipes exist
                        // Placeholder recipe 1
                        echo '<div class="recipe">';
                        echo '<h2>Classic Spaghetti Carbonara</h2>';
                        echo '<p><strong>Category:</strong> Italian</p>';
                        echo '<p><strong>Dietary:</strong> Non-Vegetarian</p>';
                        echo '<p><strong>Difficulty:</strong> <span class="difficulty-medium">Medium</span></p>';
                        echo '<p><strong>Description:</strong> A classic Italian pasta dish made with eggs, cheese, pancetta, and pepper. It\'s simple yet delicious and loved by many.</p>';
                        
                        echo '<button class="ingredient-toggle" onclick="toggleIngredients(\'ingredients-placeholder-1\')">Show Ingredients</button>';
                        echo '<div id="ingredients-placeholder-1" class="ingredients-list hidden">';
                        echo '<h4>Ingredients</h4>';
                        echo '<ul>';
                        echo '<li>400g spaghetti</li>';
                        echo '<li>200g pancetta or guanciale, diced</li>';
                        echo '<li>4 large eggs</li>';
                        echo '<li>100g Pecorino Romano cheese, grated</li>';
                        echo '<li>50g Parmigiano Reggiano, grated</li>';
                        echo '<li>Freshly ground black pepper</li>';
                        echo '<li>Salt to taste</li>';
                        echo '</ul>';
                        echo '</div>';
                        echo '</div>';
                        
                        // Placeholder recipe 2
                        echo '<div class="recipe">';
                        echo '<h2>Vegan Black Bean Tacos</h2>';
                        echo '<p><strong>Category:</strong> Mexican</p>';
                        echo '<p><strong>Dietary:</strong> Vegan</p>';
                        echo '<p><strong>Difficulty:</strong> <span class="difficulty-easy">Easy</span></p>';
                        echo '<p><strong>Description:</strong> Delicious vegan tacos filled with a mixture of black beans, corn, avocado, and topped with a tangy lime dressing.</p>';
                        
                        echo '<button class="ingredient-toggle" onclick="toggleIngredients(\'ingredients-placeholder-2\')">Show Ingredients</button>';
                        echo '<div id="ingredients-placeholder-2" class="ingredients-list hidden">';
                        echo '<h4>Ingredients</h4>';
                        echo '<ul>';
                        echo '<li>8 corn tortillas</li>';
                        echo '<li>1 can black beans, drained and rinsed</li>';
                        echo '<li>1 cup corn kernels</li>';
                        echo '<li>2 ripe avocados, sliced</li>';
                        echo '<li>1 red onion, finely diced</li>';
                        echo '<li>2 limes</li>';
                        echo '<li>1/4 cup cilantro, chopped</li>';
                        echo '<li>1 tbsp olive oil</li>';
                        echo '<li>1 tsp cumin</li>';
                        echo '<li>Salt and pepper to taste</li>';
                        echo '</ul>';
                        echo '</div>';
                        echo '</div>';
                        
                        echo '</div><div class="recipeContainer">';
                        
                        // Placeholder recipe 3
                        echo '<div class="recipe">';
                        echo '<h2>Authentic Ramen Bowl</h2>';
                        echo '<p><strong>Category:</strong> Asian</p>';
                        echo '<p><strong>Dietary:</strong> Gluten-Free</p>';
                        echo '<p><strong>Difficulty:</strong> <span class="difficulty-hard">Hard</span></p>';
                        echo '<p><strong>Description:</strong> A flavorful bowl of traditional ramen with homemade broth, fresh vegetables, and perfectly cooked noodles.</p>';
                        
                        echo '<button class="ingredient-toggle" onclick="toggleIngredients(\'ingredients-placeholder-3\')">Show Ingredients</button>';
                        echo '<div id="ingredients-placeholder-3" class="ingredients-list hidden">';
                        echo '<h4>Ingredients</h4>';
                        echo '<ul>';
                        echo '<li>1.5 kg pork bones</li>';
                        echo '<li>2 onions, halved</li>';
                        echo '<li>2 carrots, roughly chopped</li>';
                        echo '<li>4 garlic cloves</li>';
                        echo '<li>1 thumb-sized piece of ginger</li>';
                        echo '<li>200g dried rice noodles (gluten-free)</li>';
                        echo '<li>4 eggs</li>';
                        echo '<li>100g baby spinach</li>';
                        echo '<li>4 spring onions, sliced</li>';
                        echo '<li>1 sheet nori, cut into strips</li>';
                        echo '<li>1 tbsp sesame oil</li>';
                        echo '<li>Soy sauce (gluten-free) to taste</li>';
                        echo '</ul>';
                        echo '</div>';
                        echo '</div>';
                        
                        // Placeholder recipe 4
                        echo '<div class="recipe">';
                        echo '<h2>Chocolate Lava Cake</h2>';
                        echo '<p><strong>Category:</strong> Dessert</p>';
                        echo '<p><strong>Dietary:</strong> Vegetarian</p>';
                        echo '<p><strong>Difficulty:</strong> <span class="difficulty-medium">Medium</span></p>';
                        echo '<p><strong>Description:</strong> A decadent chocolate lava cake with a gooey center, topped with vanilla ice cream and fresh berries.</p>';
                        
                        echo '<button class="ingredient-toggle" onclick="toggleIngredients(\'ingredients-placeholder-4\')">Show Ingredients</button>';
                        echo '<div id="ingredients-placeholder-4" class="ingredients-list hidden">';
                        echo '<h4>Ingredients</h4>';
                        echo '<ul>';
                        echo '<li>200g dark chocolate</li>';
                        echo '<li>100g butter</li>';
                        echo '<li>3 eggs</li>';
                        echo '<li>3 egg yolks</li>';
                        echo '<li>60g sugar</li>';
                        echo '<li>40g flour</li>';
                        echo '<li>Pinch of salt</li>';
                        echo '<li>Vanilla ice cream for serving</li>';
                        echo '<li>Mixed berries for garnish</li>';
                        echo '<li>Powdered sugar for dusting</li>';
                        echo '</ul>';
                        echo '</div>';
                        echo '</div>';
                    }
                    ?>
                </div>

                <h3 style="padding: 10px">Upcoming Events</h3>
                <div class="eventContainer">
                    <?php
                    // Check if we have events
                    if ($eventResult && $eventResult->num_rows > 0) {
                        // Output data of each row
                        while ($row = $eventResult->fetch_assoc()) {
                            $formattedDate = formatDateTime($row['event_date']);
                            
                            echo '<div class="event">';
                            echo '<h2>' . htmlspecialchars($row['event_name']) . '</h2>';
                            echo '<p><strong>Location:</strong> ' . htmlspecialchars($row['location']) . '</p>';
                            echo '<p><strong>Date:</strong> ' . $formattedDate . '</p>';
                            echo '<p><strong>Description:</strong> ' . htmlspecialchars($row['event_description']) . '</p>';
                            echo '</div>';
                        }
                    } else {
                        // Display placeholders if no events exist
                        echo '<div class="event">';
                        echo '<h2>Culinary Workshop</h2>';
                        echo '<p><strong>Location:</strong> San Francisco, CA</p>';
                        echo '<p><strong>Date:</strong> March 20, 2025</p>';
                        echo '<p><strong>Time:</strong> 10:00 AM - 4:00 PM</p>';
                        echo '<p><strong>Description:</strong> Join us for a hands-on cooking workshop where professional chefs will teach you their secrets to creating perfect pasta dishes from scratch.</p>';
                        echo '</div>';
                        
                        echo '<div class="event">';
                        echo '<h2>Food Festival</h2>';
                        echo '<p><strong>Location:</strong> New York, NY</p>';
                        echo '<p><strong>Date:</strong> April 5, 2025</p>';
                        echo '<p><strong>Time:</strong> 9:00 AM - 5:00 PM</p>';
                        echo '<p><strong>Description:</strong> Experience a day filled with food tastings, cooking demonstrations, and networking with fellow food enthusiasts from around the country.</p>';
                        echo '</div>';
                    }
                    ?>
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
    <script>
        // Function to toggle the ingredients section
        function toggleIngredients(id) {
            const ingredientsDiv = document.getElementById(id);
            const button = ingredientsDiv.previousElementSibling;
            
            if (ingredientsDiv.classList.contains('hidden')) {
                ingredientsDiv.classList.remove('hidden');
                button.textContent = 'Hide Ingredients';
            } else {
                ingredientsDiv.classList.add('hidden');
                button.textContent = 'Show Ingredients';
            }
        }
    </script>
    <script src="js/script.js"></script>
</body>
</html>