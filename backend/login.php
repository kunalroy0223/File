<?php
error_reporting(E_ALL);
include "./config.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
session_start();

include "./config.php";

if (!isset($conn)) {
    die("Database connection error.");
}

$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = trim($_POST['username_or_email']);
    $pass = trim($_POST['password']);

    if (empty($user) || empty($pass)) {
        $error_message = "Please fill in all fields.";
    } else {
        try {
            $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = :user OR email = :user");
            $stmt->bindParam(':user', $user);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                if (password_verify($pass, $row['password'])) {
                    session_regenerate_id(true);
                    $_SESSION['user_id'] = $row['id'];
                    $_SESSION['username'] = $row['username'];
                    header("Location: ../index.php");
                    exit;
                } else {
                    $error_message = "Invalid password.";
                }
            } else {
                $error_message = "No user found.";
            }
        } catch (PDOException $e) {
            $error_message = "Database error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card p-4 shadow" style="max-width: 400px; width: 100%; height: fit-content;">
            <h3 class="text-center" style="color: #2E368F; font-weight:bold;">Login</h3>

            <?php if (!empty($error_message)): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($error_message); ?></div>
            <?php endif; ?>

            <form action="" method="POST">
                <div class="mb-3">
                    <label for="username_or_email" class="form-label">Username or Email:</label>
                    <input type="text" class="form-control" id="username_or_email" name="username_or_email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn w-100" style="background-color: #FDD306; color: black;">Login</button>
            </form>

            <p class="text-center mt-3">Don't have an account? <a href="../register.php" style="color: #2E368F;">Sign up</a></p>
        </div>
    </div>
</body>
</html>
