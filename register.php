<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - PHP CRUD</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="theme.js" defer></script>
</head>
<body>
    <button id="theme-toggle" class="btn btn-light" style="position: fixed; top: 1.5rem; right: 1.5rem; z-index: 2000; width: 50px; height: 50px; border-radius: 50%; padding: 0; display: flex; align-items: center; justify-content: center; background: var(--bg-glass); border: 1px solid var(--border); color: var(--primary);">
        <i class="fas fa-moon"></i>
    </button>
    <div class="container animate-fade" style="display: flex; align-items: center; justify-content: center; min-height: 100vh;">
        <div class="form-container" style="width: 100%; max-width: 450px;">
            <div style="text-align: center; margin-bottom: 2rem;">
                <h2 style="font-size: 2rem; color: var(--primary-color);">Create Account</h2>
                <p style="color: var(--text-muted);">Join our community today</p>
            </div>
            <form action="register_process.php" method="POST">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" placeholder="Choose a username" required>
                </div>
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" placeholder="email@example.com" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Minimum 6 characters" required>
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirm Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" placeholder="Repeat your password" required>
                </div>
                <button type="submit" class="btn btn-primary" style="width: 100%;">Create Account</button>
            </form>
            <p class="link" style="margin-top: 1.5rem;">Already have an account? <a href="login.php">Login here</a></p>
            <p class="link"><a href="index.php">Back to Home</a></p>
        </div>
    </div>
</body>
</html>