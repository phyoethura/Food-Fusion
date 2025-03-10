-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 10, 2025 at 06:41 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mmsp`
--

-- --------------------------------------------------------

--
-- Table structure for table `community_recipes`
--

CREATE TABLE `community_recipes` (
  `community_recipe_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `ingredients` text DEFAULT NULL,
  `categories` varchar(100) DEFAULT NULL,
  `dietary_preferences` varchar(100) DEFAULT NULL,
  `difficulty_level` enum('Easy','Medium','Hard') DEFAULT 'Easy',
  `submitted_by` int(11) DEFAULT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `community_recipes`
--

INSERT INTO `community_recipes` (`community_recipe_id`, `title`, `description`, `ingredients`, `categories`, `dietary_preferences`, `difficulty_level`, `submitted_by`, `submitted_at`) VALUES
(1, 'monthingar', 'burmese food', 'fish, noodle, banana tree', 'burmese', 'Non-Vegetarian', 'Medium', 2, '2025-03-10 12:05:10'),
(2, 'Classic Spaghetti Bolognese', 'A traditional Italian pasta dish with a rich and savory meat sauce.', 'Spaghetti, Ground Beef, Tomato Sauce, Onions, Garlic, Olive Oil, Salt, Pepper', 'Italian, Pasta', 'None', 'Medium', 2, '2025-03-10 12:07:34'),
(3, 'Vegan Buddha Bowl', 'A nutritious and colorful bowl full of fresh vegetables, grains, and a delicious tahini dressing.', 'Quinoa, Chickpeas, Avocado, Kale, Carrots, Tahini, Lemon Juice, Salt, Pepper', 'Vegan, Healthy', 'Vegan', 'Easy', 2, '2025-03-10 12:07:34'),
(4, 'Chicken Tikka Masala', 'A popular Indian dish with marinated chicken pieces cooked in a creamy tomato sauce.', 'Chicken, Yogurt, Tomato Sauce, Onions, Garlic, Ginger, Garam Masala, Cumin, Coriander, Turmeric, Cream', 'Indian, Curry', 'None', 'Hard', 2, '2025-03-10 12:07:34'),
(5, 'Gluten-Free Pancakes', 'Fluffy and delicious pancakes made without gluten, perfect for breakfast.', 'Gluten-Free Flour, Eggs, Milk, Baking Powder, Sugar, Salt, Butter', 'Breakfast, Gluten-Free', 'Gluten-Free', 'Easy', 2, '2025-03-10 12:07:34'),
(6, 'Shrimp Tacos', 'Tasty shrimp tacos with a zesty slaw and a creamy avocado sauce.', 'Shrimp, Tortillas, Cabbage, Carrots, Avocado, Lime, Cilantro, Sour Cream, Salt, Pepper', 'Mexican, Seafood', 'None', 'Medium', 2, '2025-03-10 12:07:34'),
(7, 'latphattoke', 'burmese food', 'beans, tea leaves', 'burmese', 'Vegetarian', 'Easy', 2, '2025-03-10 17:16:29');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `message_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `message` text NOT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`message_id`, `user_id`, `message`, `submitted_at`) VALUES
(1, 2, 'hell no', '2025-03-10 14:05:19'),
(2, 2, 'hello no\r\n', '2025-03-10 14:09:24'),
(3, NULL, 'dgf', '2025-03-10 17:02:20'),
(4, NULL, 'sdf', '2025-03-10 17:02:22'),
(5, 2, 'hi hi', '2025-03-10 17:16:43'),
(6, 2, 'hi', '2025-03-10 17:16:49');

-- --------------------------------------------------------

--
-- Table structure for table `educational_resources`
--

CREATE TABLE `educational_resources` (
  `educational_resource_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `file_path` varchar(255) NOT NULL,
  `resource_type` enum('Infographic','Video','Document') NOT NULL,
  `uploaded_by` int(11) DEFAULT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `event_id` int(11) NOT NULL,
  `event_name` varchar(255) NOT NULL,
  `event_description` text DEFAULT NULL,
  `event_date` datetime NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`event_id`, `event_name`, `event_description`, `event_date`, `location`, `created_at`, `created_by`) VALUES
(1, 'Tech Conference 2025', 'An annual conference focused on the latest advancements in technology.', '2025-05-15 09:00:00', 'San Francisco, CA', '2025-03-10 13:46:40', 1),
(2, 'Art Exhibition', 'A showcase of modern art by various artists.', '2025-06-20 18:00:00', 'New York, NY', '2025-03-10 13:46:40', 1),
(3, 'Music Festival', 'A three-day festival featuring performances by popular bands and artists.', '2025-07-10 12:00:00', 'Los Angeles, CA', '2025-03-10 13:46:40', 1),
(4, 'Charity Run', 'A 5K run to raise funds for local charities.', '2025-08-25 08:00:00', 'Chicago, IL', '2025-03-10 13:46:40', 1);

-- --------------------------------------------------------

--
-- Table structure for table `interaction_like`
--

CREATE TABLE `interaction_like` (
  `like_id` int(11) NOT NULL,
  `community_recipe_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `interaction_like`
--

INSERT INTO `interaction_like` (`like_id`, `community_recipe_id`, `user_id`) VALUES
(1, 1, 2),
(2, 2, 2),
(3, 6, 2),
(4, 5, 2),
(5, 3, 2),
(6, 4, 2),
(7, 7, 2);

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE `login_attempts` (
  `attempt_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `attempt_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `successful` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login_attempts`
--

INSERT INTO `login_attempts` (`attempt_id`, `user_id`, `attempt_time`, `successful`) VALUES
(1, 2, '2025-03-09 18:04:08', 1),
(2, 2, '2025-03-09 18:08:07', 1),
(3, 2, '2025-03-09 18:10:00', 1),
(4, 2, '2025-03-09 18:18:23', 1),
(5, 2, '2025-03-10 11:55:04', 1),
(6, 2, '2025-03-10 14:00:22', 1),
(7, 2, '2025-03-10 14:03:12', 1),
(8, 2, '2025-03-10 16:50:04', 1),
(9, 2, '2025-03-10 17:15:37', 1);

-- --------------------------------------------------------

--
-- Table structure for table `recipes`
--

CREATE TABLE `recipes` (
  `recipe_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `categories` varchar(100) DEFAULT NULL,
  `dietary_preferences` varchar(100) DEFAULT NULL,
  `difficulty_level` enum('Easy','Medium','Hard') DEFAULT 'Easy',
  `ingredients` text NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `recipes`
--

INSERT INTO `recipes` (`recipe_id`, `title`, `description`, `categories`, `dietary_preferences`, `difficulty_level`, `ingredients`, `created_by`, `created_at`) VALUES
(1, 'Classic Margherita Pizza', 'A simple yet delicious Italian pizza with fresh basil.', 'Italian', 'Vegetarian', 'Medium', 'Flour, Tomato Sauce, Mozzarella, Basil, Olive Oil, Yeast', 2, '2025-03-09 18:07:51'),
(2, 'Spaghetti Carbonara', 'A creamy and cheesy Roman pasta dish.', 'Italian', 'Non-Vegetarian', 'Medium', 'Spaghetti, Eggs, Parmesan, Pancetta, Black Pepper', 2, '2025-03-09 18:07:51'),
(3, 'Vegetable Stir Fry', 'A quick and healthy mix of stir-fried vegetables.', 'Asian', 'Vegan', 'Easy', 'Carrots, Broccoli, Bell Peppers, Soy Sauce, Garlic', 2, '2025-03-09 18:07:51'),
(4, 'Chicken Biryani', 'A flavorful and aromatic rice dish.', 'Indian', 'Non-Vegetarian', 'Hard', 'Chicken, Basmati Rice, Yogurt, Spices, Onions', 2, '2025-03-09 18:07:51'),
(5, 'Miso Ramen', 'A rich and savory miso-based ramen soup.', 'Japanese', 'Non-Vegetarian', 'Hard', 'Ramen Noodles, Miso Paste, Pork, Green Onions, Nori', 2, '2025-03-09 18:07:51'),
(6, 'French Onion Soup', 'A comforting soup with caramelized onions and melted cheese.', 'French', 'Vegetarian', 'Medium', 'Onions, Beef Broth, Butter, Baguette, Gruyere Cheese', 2, '2025-03-09 18:07:51'),
(7, 'Grilled Salmon with Lemon Butter', 'A simple and healthy grilled salmon recipe.', 'American', 'Non-Vegetarian', 'Easy', 'Salmon, Lemon, Butter, Garlic, Parsley', 2, '2025-03-09 18:07:51'),
(8, 'Falafel Wrap', 'A Middle Eastern wrap with crispy chickpea patties.', 'Middle Eastern', 'Vegan', 'Medium', 'Chickpeas, Garlic, Cilantro, Tahini, Pita Bread', 2, '2025-03-09 18:07:51'),
(9, 'Eggplant Parmesan', 'A hearty Italian dish with crispy eggplant and cheese.', 'Italian', 'Vegetarian', 'Medium', 'Eggplant, Tomato Sauce, Mozzarella, Parmesan, Basil', 2, '2025-03-09 18:07:51'),
(10, 'Shrimp Tacos', 'Mexican-style tacos with seasoned shrimp.', 'Mexican', 'Non-Vegetarian', 'Easy', 'Shrimp, Tortillas, Cabbage, Avocado, Lime, Sour Cream', 2, '2025-03-09 18:07:51'),
(11, 'Pad Thai', 'A famous Thai noodle dish with a sweet and tangy sauce.', 'Thai', 'Non-Vegetarian', 'Medium', 'Rice Noodles, Shrimp, Peanuts, Tamarind, Bean Sprouts', 2, '2025-03-09 18:07:51'),
(12, 'Vegetable Curry', 'A spiced and comforting Indian curry.', 'Indian', 'Vegan', 'Medium', 'Potatoes, Carrots, Peas, Coconut Milk, Spices', 2, '2025-03-09 18:07:51'),
(13, 'BBQ Chicken Wings', 'Crispy and flavorful barbecue chicken wings.', 'American', 'Non-Vegetarian', 'Easy', 'Chicken Wings, BBQ Sauce, Garlic, Honey, Paprika', 2, '2025-03-09 18:07:51'),
(14, 'Greek Salad', 'A refreshing Mediterranean salad with feta cheese.', 'Greek', 'Vegetarian', 'Easy', 'Tomatoes, Cucumber, Olives, Feta Cheese, Olive Oil', 2, '2025-03-09 18:07:51'),
(15, 'Sushi Rolls', 'Homemade sushi rolls with fresh ingredients.', 'Japanese', 'Non-Vegetarian', 'Hard', 'Rice, Seaweed, Salmon, Avocado, Cucumber', 2, '2025-03-09 18:07:51'),
(16, 'Mushroom Risotto', 'A creamy Italian rice dish with mushrooms.', 'Italian', 'Vegetarian', 'Medium', 'Arborio Rice, Mushrooms, Parmesan, White Wine, Onion', 2, '2025-03-09 18:07:51'),
(17, 'Beef Stroganoff', 'A rich and creamy Russian beef dish.', 'Russian', 'Non-Vegetarian', 'Medium', 'Beef, Mushrooms, Sour Cream, Onion, Egg Noodles', 2, '2025-03-09 18:07:51'),
(18, 'Chili Con Carne', 'A spicy Mexican-style chili with ground beef.', 'Mexican', 'Non-Vegetarian', 'Medium', 'Ground Beef, Beans, Tomatoes, Chili Peppers, Onion', 2, '2025-03-09 18:07:51'),
(19, 'Tofu Stir Fry', 'A quick and healthy tofu stir-fry with vegetables.', 'Asian', 'Vegan', 'Easy', 'Tofu, Broccoli, Bell Peppers, Soy Sauce, Garlic', 2, '2025-03-09 18:07:51'),
(20, 'Chocolate Lava Cake', 'A rich and gooey chocolate dessert.', 'French', 'Vegetarian', 'Medium', 'Chocolate, Butter, Eggs, Sugar, Flour', 2, '2025-03-09 18:07:51');

-- --------------------------------------------------------

--
-- Table structure for table `resources`
--

CREATE TABLE `resources` (
  `resource_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `file_path` varchar(255) NOT NULL,
  `resource_type` enum('Recipe Card','Tutorial','Video') NOT NULL,
  `uploaded_by` int(11) DEFAULT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') DEFAULT 'user',
  `date_joined` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `email`, `password`, `role`, `date_joined`) VALUES
(1, 'john', 'doe', 'john@gmail.com', '111111', 'user', '2025-03-09 18:03:33'),
(2, 'pyae', 'phyo', 'pyaephyo@gmail.com', '$2y$10$oCEMoHJ4grTk7dUlP.XKCetHUJxYuSgB3q5DE0XlBgk5nt018AEgS', 'user', '2025-03-09 18:03:54');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `community_recipes`
--
ALTER TABLE `community_recipes`
  ADD PRIMARY KEY (`community_recipe_id`),
  ADD KEY `submitted_by` (`submitted_by`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`message_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `educational_resources`
--
ALTER TABLE `educational_resources`
  ADD PRIMARY KEY (`educational_resource_id`),
  ADD KEY `uploaded_by` (`uploaded_by`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`event_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `interaction_like`
--
ALTER TABLE `interaction_like`
  ADD PRIMARY KEY (`like_id`),
  ADD KEY `fk_community_recipe` (`community_recipe_id`),
  ADD KEY `fk_user` (`user_id`);

--
-- Indexes for table `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`attempt_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `recipes`
--
ALTER TABLE `recipes`
  ADD PRIMARY KEY (`recipe_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `resources`
--
ALTER TABLE `resources`
  ADD PRIMARY KEY (`resource_id`),
  ADD KEY `uploaded_by` (`uploaded_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `community_recipes`
--
ALTER TABLE `community_recipes`
  MODIFY `community_recipe_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `educational_resources`
--
ALTER TABLE `educational_resources`
  MODIFY `educational_resource_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `interaction_like`
--
ALTER TABLE `interaction_like`
  MODIFY `like_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `attempt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `recipes`
--
ALTER TABLE `recipes`
  MODIFY `recipe_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `resources`
--
ALTER TABLE `resources`
  MODIFY `resource_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `community_recipes`
--
ALTER TABLE `community_recipes`
  ADD CONSTRAINT `community_recipes_ibfk_1` FOREIGN KEY (`submitted_by`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD CONSTRAINT `contact_messages_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL;

--
-- Constraints for table `educational_resources`
--
ALTER TABLE `educational_resources`
  ADD CONSTRAINT `educational_resources_ibfk_1` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `interaction_like`
--
ALTER TABLE `interaction_like`
  ADD CONSTRAINT `fk_community_recipe` FOREIGN KEY (`community_recipe_id`) REFERENCES `community_recipes` (`community_recipe_id`),
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD CONSTRAINT `login_attempts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `recipes`
--
ALTER TABLE `recipes`
  ADD CONSTRAINT `recipes_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `resources`
--
ALTER TABLE `resources`
  ADD CONSTRAINT `resources_ibfk_1` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
