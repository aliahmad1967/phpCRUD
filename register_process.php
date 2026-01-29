<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validation
    if (empty($username) || empty($email) || empty($password)) {
        $error = "All fields are required";
    } elseif ($password !== $confirm_password) {
        $error = "Passwords do not match";
    } elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters long";
    } else {
        // Check if username or email already exists
        $sql = "SELECT id FROM users WHERE username = ? OR email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error = "Username or email already exists";
        } else {
            // Hash password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert new user
            $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $username, $email, $hashed_password);

            if ($stmt->execute()) {
                $success = "Registration successful! Please login.";
                header("refresh:2;url=login.php");
            } else {
                $error = "Registration failed. Please try again.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Result - PHP CRUD</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="form-container">
            <?php if (isset($error)): ?>
                <div class="alert error"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <?php if (isset($success)): ?>
                <div class="alert success"><?php echo $success; ?></div>
            <?php endif; ?>
            
            <p><a href="register.php" class="btn">Try Again</a></p>
            <p><a href="login.php" class="btn">Go to Login</a></p>
        </div>
    </div>
</body>
</html>