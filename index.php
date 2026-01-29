<?php
require_once 'config.php';
require_once 'auth_helper.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP CRUD - Modern Application</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    
    <div class="hero">
        <div class="container animate-fade">
            <h1><i class="fas fa-rocket"></i> Manage Your Content With Ease</h1>
            <p>A powerful, secure, and modern PHP CRUD application for managing users, posts, and items efficiently.</p>
            
            <div class="hero-buttons">
                <a href="login.php" class="btn btn-lg btn-light"><i class="fas fa-tachometer-alt"></i> Go to Dashboard</a>
                <?php if (isLoggedIn()): ?>
                    <a href="logout.php" class="btn btn-lg btn-outline"><i class="fas fa-sign-out-alt"></i> Logout</a>
                <?php else: ?>
                    <a href="register.php" class="btn btn-lg btn-outline"><i class="fas fa-user-plus"></i> Create Account</a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="container animate-fade" style="margin-top: -3rem;">
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-users"></i>
                </div>
                <h3>User Management</h3>
                <p>Secure authentication system with registration, login, and profile management capabilities.</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-file-alt"></i>
                </div>
                <h3>Content Creation</h3>
                <p>Create, read, update, and delete posts with a rich and intuitive interface.</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-box-open"></i>
                </div>
                <h3>Inventory System</h3>
                <p>Track items with pricing, descriptions, and real-time updates for your inventory.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h3>Secure & Safe</h3>
                <p>Built with security in mind, featuring password hashing, SQL injection protection, and session management.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-mobile-alt"></i>
                </div>
                <h3>Responsive Design</h3>
                <p>Fully responsive layout that works perfectly on desktop, tablet, and mobile devices.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-code"></i>
                </div>
                <h3>Clean Code</h3>
                <p>Organized, maintainable PHP code structure following best practices for development.</p>
            </div>
        </div>
    </div>

    <div class="footer">
        <div class="container">
            <p>&copy; <?php echo date('Y'); ?> PHP CRUD Application. All rights reserved.</p>
        </div>
    </div>

</body>
</html>