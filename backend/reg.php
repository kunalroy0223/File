<?php
session_start();
include "./config.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";

    // Check for empty fields
    if (empty($username) || empty($email) || empty($password)) {
        echo "<script>alert('All fields are required.');</script>";
        exit;
    }

    // Check if username or email already exists
    $checkSql = "SELECT 1 FROM users WHERE username = :username OR email = :email";
    $stmt = $conn->prepare($checkSql);
    $stmt->execute([":username" => $username, ":email" => $email]);
    
    if ($stmt->fetch()) {
        echo "<script>alert('Username or Email already exists. Try another one.');</script>";
    } else {
        // Hash the password using bcrypt
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Insert new user into the database
        $insertSql = "INSERT INTO users (username, password, email) VALUES (:username, :password, :email)";
        $stmt = $conn->prepare($insertSql);
        $result = $stmt->execute([
            ":username" => $username,
            ":password" => $hashed_password,
            ":email" => $email
        ]);
        
        if ($result) {
            echo "<script>alert('Registration successful! Now Login.');window.location.href='../index.php';</script>";
        } else {
            echo "<script>alert('Registration failed. Please try again.');</script>";
        }
    }
}
?>