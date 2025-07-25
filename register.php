<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Register</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <div class="container d-flex justify-content-center align-items-center vh-100">
            <div class="card p-4 shadow" style="max-width: 400px; width: 100%;">
                <h3 class="text-center" style="color: #2E368F;">Register</h3>
                <!-- Show alert if redirected with error -->
                <?php if (isset($_GET['error'])): ?>
                    <div class="alert alert-danger py-2 text-center">
                        <?= htmlspecialchars($_GET['error']) ?>
                    </div>
                <?php endif; ?>
                <?php if (isset($_GET['message'])): ?>
                    <div class="alert alert-success py-2 text-center">
                        <?= htmlspecialchars($_GET['message']) ?>
                    </div>
                <?php endif; ?>

                <form action="./backend/reg.php" method="POST">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username:</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail:</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn w-100" style="background-color: #FDD306; color: black;">Register</button>
                </form>
                
                <p class="text-center mt-3">Already have an account? <a href="/f/backend/login.php" style="color: #2E368F;">Login here</a></p>

            </div>
        </div>
    </body>
</html>