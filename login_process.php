<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Validation
    if (empty($username) || empty($password)) {
        $error = "Username and password are required";
    } else {
        // Check user credentials
        $sql = "SELECT id, username, email, password FROM users WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            
            // Verify password
            if (password_verify($password, $user['password'])) {
                // Password is correct, start session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['email'] = $user['email'];
                
                // Redirect to welcome page
                header("Location: welcome.php");
                exit();
            } else {
                $error = "Invalid username or password";
            }
        } else {
            $error = "Invalid username or password";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Result - PHP CRUD</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="form-container">
            <?php if (isset($error)): ?>
                <div class="alert error"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <p><a href="login.php" class="btn">Try Again</a></p>
            <p><a href="register.php" class="btn">Create Account</a></p>
        </div>
    </div>
</body>
</html>