<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start session and connect to database
session_start();
require_once 'db_connect.php';

// Set content type to JSON
header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(["success" => false, "error" => "User not logged in"]);
    exit;
}

// Validate recipe_id is present and is a number
if (!isset($_POST['recipe_id']) || !is_numeric($_POST['recipe_id'])) {
    echo json_encode(["success" => false, "error" => "Invalid recipe ID"]);
    exit;
}

$userId = $_SESSION['user_id'];
$recipeId = (int)$_POST['recipe_id'];

// Log the request for debugging
error_log("Like request - User ID: $userId, Recipe ID: $recipeId");

try {
    // Check if the user already liked this recipe
    $checkStmt = $conn->prepare("SELECT * FROM interaction_like WHERE user_id = ? AND community_recipe_id = ?");
    $checkStmt->bind_param("ii", $userId, $recipeId);
    $checkStmt->execute();
    $result = $checkStmt->get_result();
    $alreadyLiked = ($result->num_rows > 0);
    $checkStmt->close();

    // Toggle the like status
    if ($alreadyLiked) {
        // User already liked this recipe, so unlike it
        $deleteStmt = $conn->prepare("DELETE FROM interaction_like WHERE user_id = ? AND community_recipe_id = ?");
        $deleteStmt->bind_param("ii", $userId, $recipeId);
        $success = $deleteStmt->execute();
        $deleteStmt->close();
        $newLikedStatus = false;
        error_log("Removing like - Success: " . ($success ? "Yes" : "No"));
    } else {
        // User hasn't liked this recipe, so add a like
        $insertStmt = $conn->prepare("INSERT INTO interaction_like (user_id, community_recipe_id) VALUES (?, ?)");
        $insertStmt->bind_param("ii", $userId, $recipeId);
        $success = $insertStmt->execute();
        $insertStmt->close();
        $newLikedStatus = true;
        error_log("Adding like - Success: " . ($success ? "Yes" : "No"));
    }

    // Get the updated like count
    $countStmt = $conn->prepare("SELECT COUNT(*) AS count FROM interaction_like WHERE community_recipe_id = ?");
    $countStmt->bind_param("i", $recipeId);
    $countStmt->execute();
    $countResult = $countStmt->get_result();
    $likeCount = $countResult->fetch_assoc()['count'];
    $countStmt->close();

    // Return the result
    echo json_encode([
        "success" => true,
        "liked" => $newLikedStatus,
        "like_count" => $likeCount,
        "recipe_id" => $recipeId
    ]);
    
} catch (Exception $e) {
    error_log("Error in like_recipe.php: " . $e->getMessage());
    echo json_encode([
        "success" => false,
        "error" => "Database error: " . $e->getMessage()
    ]);
}
?>