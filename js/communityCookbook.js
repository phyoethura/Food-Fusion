// Wait for the DOM to be fully loaded
document.addEventListener("DOMContentLoaded", function() {
    console.log("DOM loaded, setting up like buttons");
    
    // Set up click handlers for all like buttons
    setupLikeButtons();
    
    // Modal functionality (unchanged)
    const openModalBtn = document.getElementById("open-recipe-btn");
    const closeModalBtn = document.getElementById("close-recipe-btn");
    const recipeModal = document.getElementById("recipe-modal");
    
    if (openModalBtn) {
        openModalBtn.addEventListener("click", function() {
            recipeModal.style.display = "block";
        });
    }
    
    if (closeModalBtn) {
        closeModalBtn.addEventListener("click", function() {
            recipeModal.style.display = "none";
        });
    }
    
    window.addEventListener("click", function(event) {
        if (event.target === recipeModal) {
            recipeModal.style.display = "none";
        }
    });
});

// Function to set up like buttons
function setupLikeButtons() {
    const likeButtons = document.querySelectorAll(".love-btn");
    console.log(`Found ${likeButtons.length} like buttons`);
    
    likeButtons.forEach(button => {
        // Remove any existing event listeners to prevent duplicates
        const newButton = button.cloneNode(true);
        button.parentNode.replaceChild(newButton, button);
        
        // Add click event listener to the new button
        newButton.addEventListener("click", function(event) {
            event.preventDefault();
            event.stopPropagation();
            
            const recipeId = this.getAttribute("data-recipe-id");
            console.log(`Like button clicked for recipe ${recipeId}`);
            
            // Create form data
            const formData = new FormData();
            formData.append("recipe_id", recipeId);
            
            // Send AJAX request
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "like_recipe.php", true);
            
            xhr.onload = function() {
                if (xhr.status >= 200 && xhr.status < 300) {
                    try {
                        const response = JSON.parse(xhr.responseText);
                        console.log("Server response:", response);
                        
                        if (!response.success) {
                            console.error("Error:", response.error);
                            alert("Error: " + response.error);
                            return;
                        }
                        
                        // Update heart icon color
                        const icon = newButton.querySelector("i.fa-heart");
                        if (icon) {
                            icon.style.color = response.liked ? "red" : "black";
                        } else {
                            newButton.style.color = response.liked ? "red" : "black";
                        }
                        
                        // Find or create the like count span
                        let likeCountSpan = newButton.nextElementSibling;
                        if (!likeCountSpan || !likeCountSpan.classList.contains("like-count")) {
                            likeCountSpan = document.createElement("span");
                            likeCountSpan.classList.add("like-count");
                            newButton.parentNode.insertBefore(likeCountSpan, newButton.nextSibling);
                        }
                        
                        // Update like count text and visibility
                        if (response.like_count > 0) {
                            likeCountSpan.textContent = `Liked by ${response.like_count}`;
                            likeCountSpan.style.display = "inline";
                        } else {
                            likeCountSpan.style.display = "none";
                        }
                        
                    } catch (error) {
                        console.error("JSON parsing error:", error);
                        console.log("Raw response:", xhr.responseText);
                    }
                } else {
                    console.error("Request failed with status:", xhr.status);
                }
            };
            
            xhr.onerror = function() {
                console.error("Network error occurred");
            };
            
            // Send the request
            xhr.send(new URLSearchParams(formData));
        });
    });
}