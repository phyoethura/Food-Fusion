-- 1. Table for storing user details
CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') DEFAULT 'user',
    date_joined TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 2. Table to store recipe information
CREATE TABLE recipes (
    recipe_id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    categories VARCHAR(100),
    dietary_preferences VARCHAR(100),
    difficulty_level ENUM('Easy', 'Medium', 'Hard') DEFAULT 'Easy',
    ingredients TEXT NOT NULL,
    created_by INT, -- Reference to the user who created the recipe
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES users(user_id)
);

-- 3. Table for community-submitted recipes
CREATE TABLE community_recipes (
    community_recipe_id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    categories VARCHAR(100),
    dietary_preferences VARCHAR(100),
    difficulty_level ENUM('Easy', 'Medium', 'Hard') DEFAULT 'Easy',
    ingredients TEXT NOT NULL,
    submitted_by INT, -- Reference to the user who submitted the recipe
    submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (submitted_by) REFERENCES users(user_id)
);

-- 4. Table to store upcoming cooking events
CREATE TABLE events (
    event_id INT AUTO_INCREMENT PRIMARY KEY,
    event_name VARCHAR(255) NOT NULL,
    event_description TEXT,
    event_date DATETIME NOT NULL,
    location VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    created_by INT,
    FOREIGN KEY (created_by) REFERENCES users(user_id)
);

-- 5. Table for culinary resources (e.g., downloadable recipe cards, tutorials)
CREATE TABLE resources (
    resource_id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    file_path VARCHAR(255) NOT NULL, -- Path to downloadable file
    resource_type ENUM('Recipe Card', 'Tutorial', 'Video') NOT NULL,
    uploaded_by INT, -- Reference to the user who uploaded the resource
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (uploaded_by) REFERENCES users(user_id)
);

-- 6. Table for educational resources (e.g., renewable energy resources)
CREATE TABLE educational_resources (
    educational_resource_id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    file_path VARCHAR(255) NOT NULL, -- Path to downloadable file or video
    resource_type ENUM('Infographic', 'Video', 'Document') NOT NULL,
    uploaded_by INT, -- Reference to the user who uploaded the educational resource
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (uploaded_by) REFERENCES users(user_id)
);

-- 7. Table to track login attempts and handle account lockouts
CREATE TABLE login_attempts (
    attempt_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    attempt_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    successful BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

CREATE TABLE interaction_like (
    like_id INT PRIMARY KEY AUTO_INCREMENT,
    community_recipe_id INT,
    user_id INT,
    CONSTRAINT fk_community_recipe
        FOREIGN KEY (community_recipe_id) REFERENCES community_recipes(community_recipe_id),
    CONSTRAINT fk_user
        FOREIGN KEY (user_id) REFERENCES users(user_id)
);


CREATE TABLE contact_messages (
    message_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NULL,
    message TEXT NOT NULL,
    submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE SET NULL
);


INSERT INTO recipes (title, description, ingredients, categories, dietary_preferences, difficulty_level, created_by) VALUES
('Classic Margherita Pizza', 'A simple yet delicious Italian pizza with fresh basil.', 'Flour, Tomato Sauce, Mozzarella, Basil, Olive Oil, Yeast', 'Italian', 'Vegetarian', 'Medium', 2),
('Spaghetti Carbonara', 'A creamy and cheesy Roman pasta dish.', 'Spaghetti, Eggs, Parmesan, Pancetta, Black Pepper', 'Italian', 'Non-Vegetarian', 'Medium', 2),
('Vegetable Stir Fry', 'A quick and healthy mix of stir-fried vegetables.', 'Carrots, Broccoli, Bell Peppers, Soy Sauce, Garlic', 'Asian', 'Vegan', 'Easy', 2),
('Chicken Biryani', 'A flavorful and aromatic rice dish.', 'Chicken, Basmati Rice, Yogurt, Spices, Onions', 'Indian', 'Non-Vegetarian', 'Hard', 2),
('Miso Ramen', 'A rich and savory miso-based ramen soup.', 'Ramen Noodles, Miso Paste, Pork, Green Onions, Nori', 'Japanese', 'Non-Vegetarian', 'Hard', 2),
('French Onion Soup', 'A comforting soup with caramelized onions and melted cheese.', 'Onions, Beef Broth, Butter, Baguette, Gruyere Cheese', 'French', 'Vegetarian', 'Medium', 2),
('Grilled Salmon with Lemon Butter', 'A simple and healthy grilled salmon recipe.', 'Salmon, Lemon, Butter, Garlic, Parsley', 'American', 'Non-Vegetarian', 'Easy', 2),
('Falafel Wrap', 'A Middle Eastern wrap with crispy chickpea patties.', 'Chickpeas, Garlic, Cilantro, Tahini, Pita Bread', 'Middle Eastern', 'Vegan', 'Medium', 2),
('Eggplant Parmesan', 'A hearty Italian dish with crispy eggplant and cheese.', 'Eggplant, Tomato Sauce, Mozzarella, Parmesan, Basil', 'Italian', 'Vegetarian', 'Medium', 2),
('Shrimp Tacos', 'Mexican-style tacos with seasoned shrimp.', 'Shrimp, Tortillas, Cabbage, Avocado, Lime, Sour Cream', 'Mexican', 'Non-Vegetarian', 'Easy', 2),
('Pad Thai', 'A famous Thai noodle dish with a sweet and tangy sauce.', 'Rice Noodles, Shrimp, Peanuts, Tamarind, Bean Sprouts', 'Thai', 'Non-Vegetarian', 'Medium', 2),
('Vegetable Curry', 'A spiced and comforting Indian curry.', 'Potatoes, Carrots, Peas, Coconut Milk, Spices', 'Indian', 'Vegan', 'Medium', 2),
('BBQ Chicken Wings', 'Crispy and flavorful barbecue chicken wings.', 'Chicken Wings, BBQ Sauce, Garlic, Honey, Paprika', 'American', 'Non-Vegetarian', 'Easy', 2),
('Greek Salad', 'A refreshing Mediterranean salad with feta cheese.', 'Tomatoes, Cucumber, Olives, Feta Cheese, Olive Oil', 'Greek', 'Vegetarian', 'Easy', 2),
('Sushi Rolls', 'Homemade sushi rolls with fresh ingredients.', 'Rice, Seaweed, Salmon, Avocado, Cucumber', 'Japanese', 'Non-Vegetarian', 'Hard', 2),
('Mushroom Risotto', 'A creamy Italian rice dish with mushrooms.', 'Arborio Rice, Mushrooms, Parmesan, White Wine, Onion', 'Italian', 'Vegetarian', 'Medium', 2),
('Beef Stroganoff', 'A rich and creamy Russian beef dish.', 'Beef, Mushrooms, Sour Cream, Onion, Egg Noodles', 'Russian', 'Non-Vegetarian', 'Medium', 2),
('Chili Con Carne', 'A spicy Mexican-style chili with ground beef.', 'Ground Beef, Beans, Tomatoes, Chili Peppers, Onion', 'Mexican', 'Non-Vegetarian', 'Medium', 2),
('Tofu Stir Fry', 'A quick and healthy tofu stir-fry with vegetables.', 'Tofu, Broccoli, Bell Peppers, Soy Sauce, Garlic', 'Asian', 'Vegan', 'Easy', 2),
('Chocolate Lava Cake', 'A rich and gooey chocolate dessert.', 'Chocolate, Butter, Eggs, Sugar, Flour', 'French', 'Vegetarian', 'Medium', 2);

INSERT INTO events (event_name, event_description, event_date, location, created_by)
VALUES
('Tech Conference 2025', 'An annual conference focused on the latest advancements in technology.', '2025-05-15 09:00:00', 'San Francisco, CA', 1),
('Art Exhibition', 'A showcase of modern art by various artists.', '2025-06-20 18:00:00', 'New York, NY', 2),
('Music Festival', 'A three-day festival featuring performances by popular bands and artists.', '2025-07-10 12:00:00', 'Los Angeles, CA', 3),
('Charity Run', 'A 5K run to raise funds for local charities.', '2025-08-25 08:00:00', 'Chicago, IL', 4);

