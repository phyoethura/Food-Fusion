<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HomePage</title>
    <link rel="stylesheet" href="css/hello.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        /* Additional styles for the login popup */
        .login-popup {
            display: none; /* Hidden by default */
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4); /* Black w/ opacity */
        }

        .login-popup-content {
            background-color: #fefefe;
            margin: 15% auto; /* 15% from the top and centered */
            padding: 20px;
            border: 1px solid #888;
            width: 80%; /* Could be more or less, depending on screen size */
            max-width: 500px; /* Maximum width */
            border-radius: 10px;
        }

        .login-popup form {
            display: flex;
            flex-direction: column;
        }

        .login-popup label {
            margin-bottom: 10px;
        }

        .login-popup input {
            margin-bottom: 20px;
            padding: 10px;
            font-size: 16px;
        }

        .login-popup button {
            padding: 10px;
            font-size: 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }

        .login-popup button:hover {
            background-color: #45a049;
        }

        .form-link {
            text-align: center;
            margin-top: 15px;
        }

        .form-link a {
            color: #4CAF50;
            text-decoration: none;
        }

        .form-link a:hover {
            text-decoration: underline;
        }

        /* Success message styles */
        .success-message {
            display: none;
            background-color: #dff0d8;
            color: #3c763d;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <!--Header-->
        <div class="headerIcon">
            <h1>FoodFusion</h1>
            <button class="signup-btn" id="signup-btn">Join Us</button>
        </div>
                
        <div class="mainContent">

            <!--Navi-->
            <nav class="navbar">
                <div class="menu-icon" id="menu-icon">
                    <i class="fas fa-bars"></i>
                </div>
                <ul class="nav-links" id="nav-links">
                    <li><a class="active" href="#home">Home</a></li>
                    <li><a href="#news">About Us</a></li>
                    <li><a href="#contact">Recipe Collections</a></li>
                    <li><a href="#news">Community Cookbook</a></li>
                    <li><a href="#contact">Contact Us</a></li>
                    <li><a href="#news">Culinary Resources</a></li>
                    <li><a href="#contact">Educational Resources</a></li>
                    <li style="float:right"><a href="#about"><i class="fas fa-user"></i> Profile</a></li>
                </ul>
            </nav>
            <div class="container">
                <h3 style="padding: 40px; background-color: #D6FAF1">
                FoodFusion is a culinary platform dedicated to promoting home cooking and culinary creativity among food enthusiasts. They have commissioned you to develop an engaging website that serves as a central hub for sharing recipes, culinary tips, and fostering a vibrant food community.
                </h3>
                <h3 style="padding: 10px">Featured Recipes</h3>
                <div class="recipeContainer">
                    <div class="recipe">
                        <h2>Recipe 1</h2>
                        <p><strong>Name:</strong> Spaghetti Carbonara</p>
                        <p><strong>Cuisine:</strong> Italian</p>
                        <p><strong>Dietary:</strong> Non-Vegetarian</p>
                        <p><strong>Difficulty:</strong> Medium</p>
                        <p><strong>Description:</strong> A classic Italian pasta dish made with eggs, cheese, pancetta, and pepper. It's simple yet delicious and loved by many.</p>
                    </div>
                    <div class="recipe">
                        <h2>Recipe 2</h2>
                        <p><strong>Name:</strong> Vegan Tacos</p>
                        <p><strong>Cuisine:</strong> Mexican</p>
                        <p><strong>Dietary:</strong> Vegan</p>
                        <p><strong>Difficulty:</strong> Easy</p>
                        <p><strong>Description:</strong> Delicious vegan tacos filled with a mixture of black beans, corn, avocado, and topped with a tangy lime dressing.</p>
                    </div>
                </div>
                <div class="recipeContainer">
                    <div class="recipe">
                        <h2>Recipe 3</h2>
                        <p><strong>Name:</strong> Spaghetti Carbonara</p>
                        <p><strong>Cuisine:</strong> Italian</p>
                        <p><strong>Dietary:</strong> Non-Vegetarian</p>
                        <p><strong>Difficulty:</strong> Medium</p>
                        <p><strong>Description:</strong> A classic Italian pasta dish made with eggs, cheese, pancetta, and pepper. It's simple yet delicious and loved by many.</p>
                    </div>
                    <div class="recipe">
                        <h2>Recipe 4</h2>
                        <p><strong>Name:</strong> Vegan Tacos</p>
                        <p><strong>Cuisine:</strong> Mexican</p>
                        <p><strong>Dietary:</strong> Vegan</p>
                        <p><strong>Difficulty:</strong> Easy</p>
                        <p><strong>Description:</strong> Delicious vegan tacos filled with a mixture of black beans, corn, avocado, and topped with a tangy lime dressing.</p>
                    </div>
                </div>

                <h3 style="padding: 10px">Upcoming Events</h3>
                <div class="eventContainer">
                    <div class="event">
                        <h2>Event 1</h2>
                        <p><strong>Name:</strong> Recipt Event 1</p>
                        <p><strong>Location:</strong> San Francisco, CA</p>
                        <p><strong>Date:</strong> March 20, 2025</p>
                        <p><strong>Time:</strong> 10:00 AM - 4:00 PM</p>
                        <p><strong>Description:</strong> Recipt Event 1</p>
                    </div>
                    <div class="event">
                        <h2>Event 2</h2>
                        <p><strong>Name:</strong> Recipt Event 1 2</p>
                        <p><strong>Location:</strong> New York, NY</p>
                        <p><strong>Date:</strong> April 5, 2025</p>
                        <p><strong>Time:</strong> 9:00 AM - 5:00 PM</p>
                        <p><strong>Description:</strong> Recipt Event 2</p>
                    </div>
                </div>

            </div>
            
            <div class="container">

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

    <!-- Cookie Popup -->
    <div class="cookie-popup" id="cookie-popup">
        <div class="cookie-popup-content">
            <p>We use cookies to ensure you get the best experience on our website. <a href="#">Learn more</a></p>
            <button class="accept-btn" id="accept-btn">Accept</button>
        </div>
    </div>

    <script src="js/script.js"></script>
    
</body>
</html>