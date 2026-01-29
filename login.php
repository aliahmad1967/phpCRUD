<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - PHP CRUD</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container animate-fade" style="display: flex; align-items: center; justify-content: center; min-height: 100vh;">
        <div class="form-container" style="width: 100%; max-width: 400px;">
            <div style="text-align: center; margin-bottom: 2rem;">
                <h2 style="font-size: 2rem; color: var(--primary-color);">Welcome Back</h2>
                <p style="color: var(--text-muted);">Please enter your details</p>
            </div>
            <form action="login_process.php" method="POST">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" placeholder="Enter your username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="••••••••" required>
                </div>
                <button type="submit" class="btn btn-primary" style="width: 100%;">Sign In</button>
            </form>
            <p class="link" style="margin-top: 1.5rem;">Don't have an account? <a href="register.php">Register here</a></p>
            <p class="link"><a href="index.php">Back to Home</a></p>
        </div>
    </div>
</body>
</html>