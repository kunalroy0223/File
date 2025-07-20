document.addEventListener("DOMContentLoaded", function () {
    fetch("./backend/auth.php")
        .then(response => {
            if (!response.ok) {
                window.location.href = "./backend/login.php";
            }
        })
        .catch(error => console.error("Error checking authentication:", error));
});
