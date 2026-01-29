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
            $name = sanitize($_POST['name']);
            $description = sanitize($_POST['description']);
            $price = floatval($_POST['price']);
            
            if (!empty($name)) {
                $sql = "INSERT INTO items (name, description, price, user_id) VALUES (?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssdi", $name, $description, $price, $user['id']);
                
                if ($stmt->execute()) {
                    $message = displayAlert("Item created successfully!");
                } else {
                    $message = displayAlert("Error creating item.", "error");
                }
            }
            break;
            
        case 'update':
            $id = intval($_POST['id']);
            $name = sanitize($_POST['name']);
            $description = sanitize($_POST['description']);
            $price = floatval($_POST['price']);
            
            if (!empty($name)) {
                $sql = "UPDATE items SET name = ?, description = ?, price = ? WHERE id = ? AND user_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssdii", $name, $description, $price, $id, $user['id']);
                
                if ($stmt->execute()) {
                    $message = displayAlert("Item updated successfully!");
                } else {
                    $message = displayAlert("Error updating item.", "error");
                }
            }
            break;
            
        case 'delete':
            $id = intval($_POST['id']);
            $sql = "DELETE FROM items WHERE id = ? AND user_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $id, $user['id']);
            
            if ($stmt->execute()) {
                $message = displayAlert("Item deleted successfully!");
            } else {
                $message = displayAlert("Error deleting item.", "error");
            }
            break;
    }
}

// Handle GET requests for edit/delete confirmation
$edit_item = null;
$action = isset($_GET['action']) ? $_GET['action'] : '';

if ($action == 'edit' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "SELECT * FROM items WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $id, $user['id']);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 1) {
        $edit_item = $result->fetch_assoc();
    }
}

// Get all user items
$items = [];
$sql = "SELECT * FROM items WHERE user_id = ? ORDER BY created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user['id']);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $items[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Items - PHP CRUD</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container animate-fade">
        <div class="header">
            <h1>Manage Items</h1>
            <nav>
                <a href="index.php" class="nav-link">Home</a>
                <a href="welcome.php" class="nav-link">Dashboard</a>
                <a href="posts.php" class="nav-link">Posts</a>
                <a href="items.php" class="nav-link active">Items</a>
                <a href="logout.php" class="nav-link">Logout</a>
            </nav>
        </div>
        
        <div class="content">
            <?php echo $message; ?>
            
            <?php if ($action == 'create' || $edit_item): ?>
                <div class="form-container">
                    <h2><?php echo $edit_item ? 'Edit Item' : 'Create New Item'; ?></h2>
                    <form method="POST" action="items.php">
                        <input type="hidden" name="action" value="<?php echo $edit_item ? 'update' : 'create'; ?>">
                        <?php if ($edit_item): ?>
                            <input type="hidden" name="id" value="<?php echo $edit_item['id']; ?>">
                        <?php endif; ?>
                        
                        <div class="form-group">
                            <label for="name">Item Name:</label>
                            <input type="text" id="name" name="name" required 
                                   value="<?php echo $edit_item ? htmlspecialchars($edit_item['name']) : ''; ?>">
                        </div>
                        
                        <div class="form-group">
                            <label for="description">Description:</label>
                            <textarea id="description" name="description" rows="4"><?php echo $edit_item ? htmlspecialchars($edit_item['description']) : ''; ?></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="price">Price:</label>
                            <input type="number" id="price" name="price" step="0.01" required 
                                   value="<?php echo $edit_item ? htmlspecialchars($edit_item['price']) : ''; ?>">
                        </div>
                        
                        <button type="submit" class="btn">
                            <?php echo $edit_item ? 'Update Item' : 'Create Item'; ?>
                        </button>
                        <a href="items.php" class="btn">Cancel</a>
                    </form>
                </div>
            <?php else: ?>
                <div class="content-header">
                    <h2>Your Items</h2>
                    <a href="items.php?action=create" class="btn btn-primary">Add New Item</a>
                </div>
                
                <?php if (count($items) > 0): ?>
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Price</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($items as $item): ?>
                                <tr>
                                    <td><?php echo $item['id']; ?></td>
                                    <td><?php echo htmlspecialchars($item['name']); ?></td>
                                    <td><?php echo htmlspecialchars($item['description']); ?></td>
                                    <td>$<?php echo number_format($item['price'], 2); ?></td>
                                    <td><?php echo date('M j, Y', strtotime($item['created_at'])); ?></td>
                                    <td>
                                        <a href="items.php?action=edit&id=<?php echo $item['id']; ?>" class="btn-small">Edit</a>
                                        <form method="POST" action="items.php" style="display: inline;">
                                            <input type="hidden" name="action" value="delete">
                                            <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                                            <button type="submit" class="btn-small btn-danger" 
                                                    onclick="return confirm('Are you sure you want to delete this item?')">
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
                        <p>You don't have any items yet.</p>
                        <a href="items.php?action=create" class="btn btn-primary">Create Your First Item</a>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>