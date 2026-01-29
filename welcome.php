<?php
require_once 'config.php';
require_once 'auth_helper.php';

// Require login to access this page
requireLogin();

$user = getCurrentUser();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome - PHP CRUD</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="theme.js" defer></script>
</head>
<body>
    <button id="theme-toggle" class="btn btn-light" style="position: fixed; bottom: 2rem; right: 2rem; z-index: 2000; width: 60px; height: 60px; border-radius: 50%; padding: 0; display: flex; align-items: center; justify-content: center; background: var(--bg-glass); border: 1px solid var(--border); color: var(--primary); box-shadow: var(--shadow-lg);">
        <i class="fas fa-moon"></i>
    </button>
    <div class="container animate-fade">
        <div class="header">
            <h1>Welcome, <?php echo htmlspecialchars($user['username']); ?>!</h1>
            <nav>
                <a href="index.php" class="nav-link">Home</a>
                <a href="welcome.php" class="nav-link active">Dashboard</a>
                <a href="posts.php" class="nav-link">Posts</a>
                <a href="items.php" class="nav-link">Items</a>
                <a href="logout.php" class="nav-link">Logout</a>
            </nav>
        </div>
        
        <div class="content">
            <div class="welcome-card">
                <h2 style="margin-bottom: 2rem; color: var(--primary-color);">
                    <i class="fas fa-chart-line"></i> Dashboard Overview
                </h2>
                
                <div class="stats">
                    <div class="stat-card">
                        <i class="fas fa-id-card"></i>
                        <h3>USER PROFILE</h3>
                        <p><?php echo htmlspecialchars($user['username']); ?></p>
                        <span style="color: var(--text-muted); font-size: 0.85rem;"><?php echo htmlspecialchars($user['email']); ?></span>
                    </div>
                    
                    <div class="stat-card">
                        <i class="fas fa-magic"></i>
                        <h3>QUICK ACTIONS</h3>
                        <div style="display: flex; gap: 0.75rem; margin-top: 0.5rem;">
                            <a href="posts.php?action=create" class="btn btn-primary btn-small" style="padding: 0.75rem 1rem;">
                                <i class="fas fa-plus"></i> Post
                            </a>
                            <a href="items.php?action=create" class="btn btn-primary btn-small" style="padding: 0.75rem 1rem; background: var(--secondary);">
                                <i class="fas fa-plus"></i> Item
                            </a>
                        </div>
                    </div>

                    <div class="stat-card">
                        <i class="fas fa-layer-group"></i>
                        <h3>TOTAL ASSETS</h3>
                        <p>Multi-Module</p>
                        <div style="display: flex; gap: 0.5rem;">
                            <a href="posts.php" class="nav-link" style="padding: 0.2rem 0.5rem; font-size: 0.8rem;">View Posts</a>
                            <a href="items.php" class="nav-link" style="padding: 0.2rem 0.5rem; font-size: 0.8rem;">View Items</a>
                        </div>
                    </div>
                </div>
                
                <div class="recent-items">
                    <h3>Your Recent Posts</h3>
                    <?php
                    // Get user's posts
                    $sql = "SELECT * FROM posts WHERE user_id = ? ORDER BY created_at DESC LIMIT 5";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $user['id']);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    
                    if ($result->num_rows > 0):
                    ?>
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Status</th>
                                    <th>Excerpt</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($post = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($post['title']); ?></td>
                                        <td>
                                            <span class="status-badge status-<?php echo $post['status']; ?>">
                                                <?php echo ucfirst($post['status']); ?>
                                            </span>
                                        </td>
                                        <td><?php echo htmlspecialchars(substr($post['excerpt'], 0, 50)) . (strlen($post['excerpt']) > 50 ? '...' : ''); ?></td>
                                        <td><?php echo date('M j, Y', strtotime($post['created_at'])); ?></td>
                                        <td>
                                            <a href="posts.php?action=edit&id=<?php echo $post['id']; ?>" class="btn-small">Edit</a>
                                            <a href="posts.php?action=delete&id=<?php echo $post['id']; ?>" class="btn-small btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p>You haven't created any posts yet. <a href="posts.php?action=create">Create your first post!</a></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>