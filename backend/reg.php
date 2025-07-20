<?php
session_start();

include "./config.php";

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    // Check if username or email already exists
    $checkSql = "SELECT * FROM users WHERE username = :username OR email = :email";
    $stmt = $pdo->prepare($checkSql);
    $stmt->bindParam(":username", $username);
    $stmt->bindParam(":email", $email);
    $stmt->execute();
    
    if ($stmt->rowCount() > 0) {
        echo "Username or Email already exists. Try another one.";
    } else {
        // Hash the password using bcrypt
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Insert new user into the database
        $insertSql = "INSERT INTO users (username, password, email) VALUES (:username, :password, :email)";
        $stmt = $pdo->prepare($insertSql);
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":password", $hashed_password);
        $stmt->bindParam(":email", $email);
        
        if ($stmt->execute()) {
            echo "<script>if(confirm('Registration successful! Now Login')){document.location.href='../login.php'};</script>";
        } else {
            // echo "alert("Registration failed. Please try again.")";
            echo "<script>alert('Registration failed. Please try again.');</script>";
        }
    }
}
?>
