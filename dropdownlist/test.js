document.addEventListener("DOMContentLoaded", function () {
    const dropdownBtn = document.getElementById("dropdown-btn");
    const dropdownList = document.getElementById("dropdown-list");
    
    let isOpen = false;

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
});
