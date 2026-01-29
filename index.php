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
            <span style="background: rgba(99, 102, 241, 0.2); color: #818cf8; padding: 0.5rem 1.5rem; border-radius: 999px; font-weight: 800; font-size: 0.9rem; margin-bottom: 2rem; display: inline-block; border: 1px solid rgba(99, 102, 241, 0.3);">
                NEW VERSION 2.0 IS HERE
            </span>
            <h1>The Next Generation of <br><span style="background: linear-gradient(to right, #6366f1, #ec4899); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Content Management</span></h1>
            <p>Empower your digital presence with our ultra-secure, blazing fast, and incredibly intuitive PHP CRUD engine.</p>
            
            <div class="hero-buttons">
                <a href="login.php" class="btn btn-lg btn-primary"><i class="fas fa-bolt"></i> Get Started Free</a>
                <a href="register.php" class="btn btn-lg btn-outline"><i class="fas fa-user-plus"></i> Join Community</a>
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