<?php
session_start();

include "./config.php";

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $input_username_or_email = $_POST['username_or_email'];
    $input_password = $_POST['password'];

    // Debugging output
    echo "Username/Email: " . htmlspecialchars($input_username_or_email) . "<br>";
    echo "Password: " . htmlspecialchars($input_password) . "<br>";

    // SQL query to fetch user by username or email
    $sql = "SELECT * FROM users WHERE username = :username_or_email OR email = :username_or_email LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':username_or_email', $input_username_or_email);
    $stmt->execute();

    // Fetch the user data
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verify password
    if ($user && password_verify($input_password, $user['password'])) {
        // Authentication successful
        $_SESSION['user_id'] = $user['id']; // Store user ID in session
        header("Location: ../index.php"); // Redirect to index page
        exit();
    } else {
        // Invalid login credentials
        echo "<script>if(confirm('Invalid username/email or password')){document.location.href='../login.php'};</script>";
        
    }
}

?>
