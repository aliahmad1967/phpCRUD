<?php
require_once 'config.php';
require_once 'auth_helper.php';

// Require login to access this page
requireLogin();

$user = getCurrentUser();
$message = '';

// Handle CRUD operations
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];
    
    switch ($action) {
        case 'create':
            $title = sanitize($_POST['title']);
            $content = sanitize($_POST['content']);
            $excerpt = sanitize($_POST['excerpt']);
            $status = sanitize($_POST['status']);
            
            if (!empty($title) && !empty($content)) {
                $sql = "INSERT INTO posts (title, content, excerpt, status, user_id) VALUES (?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssssi", $title, $content, $excerpt, $status, $user['id']);
                
                if ($stmt->execute()) {
                    $message = displayAlert("Post created successfully!");
                } else {
                    $message = displayAlert("Error creating post.", "error");
                }
            }
            break;
            
        case 'update':
            $id = intval($_POST['id']);
            $title = sanitize($_POST['title']);
            $content = sanitize($_POST['content']);
            $excerpt = sanitize($_POST['excerpt']);
            $status = sanitize($_POST['status']);
            
            if (!empty($title) && !empty($content)) {
                $sql = "UPDATE posts SET title = ?, content = ?, excerpt = ?, status = ? WHERE id = ? AND user_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssssii", $title, $content, $excerpt, $status, $id, $user['id']);
                
                if ($stmt->execute()) {
                    $message = displayAlert("Post updated successfully!");
                } else {
                    $message = displayAlert("Error updating post.", "error");
                }
            }
            break;
            
        case 'delete':
            $id = intval($_POST['id']);
            $sql = "DELETE FROM posts WHERE id = ? AND user_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $id, $user['id']);
            
            if ($stmt->execute()) {
                $message = displayAlert("Post deleted successfully!");
            } else {
                $message = displayAlert("Error deleting post.", "error");
            }
            break;
    }
}

// Handle GET requests for edit/delete confirmation
$edit_post = null;
$action = isset($_GET['action']) ? $_GET['action'] : '';

if ($action == 'edit' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "SELECT * FROM posts WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $id, $user['id']);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 1) {
        $edit_post = $result->fetch_assoc();
    }
}

// Get all user posts
$posts = [];
$sql = "SELECT * FROM posts WHERE user_id = ? ORDER BY created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user['id']);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $posts[] = $row;
}

// Get statistics
$total_posts = count($posts);
$published_posts = count(array_filter($posts, function($post) { return $post['status'] == 'published'; }));
$draft_posts = count(array_filter($posts, function($post) { return $post['status'] == 'draft'; }));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Posts - PHP CRUD</title>
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
            <h1>Manage Posts</h1>
            <nav>
                <a href="index.php" class="nav-link">Home</a>
                <a href="welcome.php" class="nav-link">Dashboard</a>
                <a href="posts.php" class="nav-link active">Posts</a>
                <a href="items.php" class="nav-link">Items</a>
                <a href="logout.php" class="nav-link">Logout</a>
            </nav>
        </div>
        
        <div class="content">
            <?php echo $message; ?>
            
            <!-- Statistics Section -->
            <div class="stats">
                <div class="stat-card">
                    <h3>📊 Statistics</h3>
                    <p><strong>Total Posts:</strong> <?php echo $total_posts; ?></p>
                    <p><strong>Published:</strong> <?php echo $published_posts; ?></p>
                    <p><strong>Drafts:</strong> <?php echo $draft_posts; ?></p>
                </div>
                
                <div class="stat-card">
                    <h3>📝 Quick Actions</h3>
                    <a href="posts.php?action=create" class="btn btn-primary">Create New Post</a>
                    <a href="welcome.php" class="btn">View Dashboard</a>
                </div>
            </div>
            
            <?php if ($action == 'create' || $edit_post): ?>
                <div class="form-container">
                    <h2><?php echo $edit_post ? 'Edit Post' : 'Create New Post'; ?></h2>
                    <form method="POST" action="posts.php">
                        <input type="hidden" name="action" value="<?php echo $edit_post ? 'update' : 'create'; ?>">
                        <?php if ($edit_post): ?>
                            <input type="hidden" name="id" value="<?php echo $edit_post['id']; ?>">
                        <?php endif; ?>
                        
                        <div class="form-group">
                            <label for="title">Post Title:</label>
                            <input type="text" id="title" name="title" required 
                                   value="<?php echo $edit_post ? htmlspecialchars($edit_post['title']) : ''; ?>">
                        </div>
                        
                        <div class="form-group">
                            <label for="excerpt">Excerpt (Optional):</label>
                            <input type="text" id="excerpt" name="excerpt" 
                                   value="<?php echo $edit_post ? htmlspecialchars($edit_post['excerpt']) : ''; ?>"
                                   placeholder="Brief description of the post">
                        </div>
                        
                        <div class="form-group">
                            <label for="status">Status:</label>
                            <select id="status" name="status" class="form-control">
                                <option value="draft" <?php echo ($edit_post && $edit_post['status'] == 'draft') ? 'selected' : ''; ?>>Draft</option>
                                <option value="published" <?php echo ($edit_post && $edit_post['status'] == 'published') ? 'selected' : ''; ?>>Published</option>
                                <option value="archived" <?php echo ($edit_post && $edit_post['status'] == 'archived') ? 'selected' : ''; ?>>Archived</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="content">Content:</label>
                            <textarea id="content" name="content" rows="8" required><?php echo $edit_post ? htmlspecialchars($edit_post['content']) : ''; ?></textarea>
                        </div>
                        
                        <button type="submit" class="btn">
                            <?php echo $edit_post ? 'Update Post' : 'Create Post'; ?>
                        </button>
                        <a href="posts.php" class="btn">Cancel</a>
                    </form>
                </div>
            <?php else: ?>
                <div class="content-header">
                    <h2>Your Posts</h2>
                    <a href="posts.php?action=create" class="btn btn-primary">Create New Post</a>
                </div>
                
                <?php if (count($posts) > 0): ?>
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Status</th>
                                <th>Excerpt</th>
                                <th>Created</th>
                                <th>Updated</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($posts as $post): ?>
                                <tr>
                                    <td><?php echo $post['id']; ?></td>
                                    <td><?php echo htmlspecialchars($post['title']); ?></td>
                                    <td>
                                        <span class="status-badge status-<?php echo $post['status']; ?>">
                                            <?php echo ucfirst($post['status']); ?>
                                        </span>
                                    </td>
                                    <td><?php echo htmlspecialchars(substr($post['excerpt'], 0, 50)) . (strlen($post['excerpt']) > 50 ? '...' : ''); ?></td>
                                    <td><?php echo date('M j, Y', strtotime($post['created_at'])); ?></td>
                                    <td><?php echo date('M j, Y', strtotime($post['updated_at'])); ?></td>
                                    <td>
                                        <a href="posts.php?action=edit&id=<?php echo $post['id']; ?>" class="btn-small">Edit</a>
                                        <form method="POST" action="posts.php" style="display: inline;">
                                            <input type="hidden" name="action" value="delete">
                                            <input type="hidden" name="id" value="<?php echo $post['id']; ?>">
                                            <button type="submit" class="btn-small btn-danger" 
                                                    onclick="return confirm('Are you sure you want to delete this post?')">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="empty-state">
                        <p>You haven't created any posts yet.</p>
                        <a href="posts.php?action=create" class="btn btn-primary">Create Your First Post</a>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>