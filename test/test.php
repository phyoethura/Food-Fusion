<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Your Recipe</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f9f9f9;
        }
        .recipe-form {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            width: 400px;
        }
        .recipe-form label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
        }
        .recipe-form input,
        .recipe-form select,
        .recipe-form textarea {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .recipe-form button {
            margin-top: 15px;
            padding: 10px;
            width: 100%;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .recipe-form button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

    <form class="recipe-form">
        <h2>Create Your Recipe</h2>

        <label for="name">Name:</label>
        <input type="text" id="name" placeholder="Enter recipe name" required>

        <label for="cuisine">Cuisine:</label>
        <input type="text" id="cuisine" placeholder="e.g., Italian, Chinese, Mexican" required>

        <label for="dietary">Dietary:</label>
        <select id="dietary">
            <option value="Vegetarian">Vegetarian</option>
            <option value="Non-Vegetarian">Non-Vegetarian</option>
            <option value="Vegan">Vegan</option>
        </select>

        <label for="difficulty">Difficulty:</label>
        <select id="difficulty">
            <option value="Easy">Easy</option>
            <option value="Medium">Medium</option>
            <option value="Hard">Hard</option>
        </select>

        <label for="description">Description:</label>
        <textarea id="description" rows="4" placeholder="Write a short description..."></textarea>

        <button type="submit">Submit Recipe</button>
    </form>

</body>
</html>
