$(document).ready(function(){
    $(".option-box1").click(function(){
        var page = $(this).data("page");

        // Load content dynamically
        $("#main-content").load("./content/" + page);

        // Update breadcrumbs
        $("#breadcrumb").html(`
            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link" data-page="academics.php">Academics</a></li>
        `);
    });
});
document.addEventListener("DOMContentLoaded", function () {
    // Select all cards
    document.querySelectorAll(".card").forEach(card => {
        card.addEventListener("click", function () {
            // Get the data-page attribute value
            const page = this.getAttribute("data-page");
            
            // Navigate to the specified page
            if (page) {
                window.location.href = page;
            }
        });
    });
});
