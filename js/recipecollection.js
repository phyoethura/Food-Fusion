document.addEventListener("DOMContentLoaded", function () {
    const dropdownBtn = document.getElementById("dropdown-btn");
    const dropdownList = document.getElementById("dropdown-list");
    const recipeContainer = document.getElementById("recipe-container");
    const dropdownItems = dropdownList.querySelectorAll("li a");
    
    let isOpen = false;

    // Toggle dropdown menu
    dropdownBtn.addEventListener("click", function (event) {
        event.stopPropagation();
        isOpen = !isOpen;
        dropdownList.style.display = isOpen ? "block" : "none";
    });

    document.addEventListener("click", function () {
        dropdownList.style.display = "none";
        isOpen = false;
    });

    dropdownList.addEventListener("click", function (event) {
        event.stopPropagation();
    });

    // Handle category selection
    dropdownItems.forEach(item => {
        item.addEventListener("click", function (event) {
            event.preventDefault();
            const selectedCategory = this.textContent.trim();

            // Change button text
            dropdownBtn.textContent = selectedCategory + " ▼";

            // Fetch recipes based on category
            fetch(`fetch_recipes.php?category=${encodeURIComponent(selectedCategory)}`)
                .then(response => response.text())
                .then(data => {
                    recipeContainer.innerHTML = data;
                })
                .catch(error => console.error("Error fetching recipes:", error));
        });
    });
});