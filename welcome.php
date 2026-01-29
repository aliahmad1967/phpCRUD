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
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Welcome, <?php echo htmlspecialchars($user['username']); ?>!</h1>
            <nav>
                <a href="welcome.php" class="nav-link">Home</a>
                <a href="items.php" class="nav-link">Manage Items</a>
                <a href="logout.php" class="nav-link">Logout</a>
            </nav>
        </div>
        
        <div class="content">
            <div class="welcome-card">
                <h2>Dashboard</h2>
                <p>Welcome to your PHP CRUD application dashboard!</p>
                
                <div class="stats">
                    <div class="stat-card">
                        <h3>User Information</h3>
                        <p><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
                        <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                    </div>
                    
                    <div class="stat-card">
                        <h3>Quick Actions</h3>
                        <a href="posts.php" class="btn">Manage Posts</a>
                        <a href="posts.php?action=create" class="btn btn-primary">Create New Post</a>
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