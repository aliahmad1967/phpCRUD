<?php
// Database test script
require_once 'config.php';

echo "<h2>Database Connection Test</h2>";

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "<p style='color: green;'>✓ Database connection successful</p>";
}

echo "<h3>Database Info:</h3>";
echo "<p>Host: " . DB_HOST . "</p>";
echo "<p>Database: " . DB_NAME . "</p>";

echo "<h3>Check if database exists:</h3>";
$result = $conn->query("SHOW DATABASES LIKE 'phpcrud_db'");
if ($result->num_rows > 0) {
    echo "<p style='color: green;'>✓ Database 'phpcrud_db' exists</p>";
} else {
    echo "<p style='color: red;'>✗ Database 'phpcrud_db' does not exist</p>";
    echo "<p>Please run the database.sql file in phpMyAdmin first.</p>";
}

echo "<h3>Check if tables exist:</h3>";
$result = $conn->query("SHOW TABLES");
if ($result->num_rows > 0) {
    while($row = $result->fetch_array()) {
        echo "<p style='color: green;'>✓ Table: " . $row[0] . "</p>";
    }
} else {
    echo "<p style='color: red;'>✗ No tables found</p>";
}

echo "<h3>Users in database:</h3>";
$result = $conn->query("SELECT id, username, email FROM users");
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<p>ID: " . $row['id'] . " | Username: " . htmlspecialchars($row['username']) . " | Email: " . htmlspecialchars($row['email']) . "</p>";
    }
} else {
    echo "<p style='color: orange;'>⚠ No users found in database</p>";
    echo "<p>You need to register a user first at: <a href='register.php'>register.php</a></p>";
}

echo "<h3>Posts in database:</h3>";
$result = $conn->query("SELECT id, title, status, user_id FROM posts");
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<p>ID: " . $row['id'] . " | Title: " . htmlspecialchars($row['title']) . " | Status: " . $row['status'] . " | User ID: " . $row['user_id'] . "</p>";
    }
} else {
    echo "<p style='color: orange;'>⚠ No posts found in database</p>";
}

echo "<h3>Test admin user creation:</h3>";
$test_username = 'admin';
$test_password = 'admin123';
$hashed_password = password_hash($test_password, PASSWORD_DEFAULT);

// Check if admin already exists
$check_sql = "SELECT id FROM users WHERE username = ?";
$stmt = $conn->prepare($check_sql);
$stmt->bind_param("s", $test_username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    // Create admin user
    $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $test_email = 'admin@example.com';
    $stmt->bind_param("sss", $test_username, $test_email, $hashed_password);
    
    if ($stmt->execute()) {
        echo "<p style='color: green;'>✓ Admin user created successfully!</p>";
        echo "<p>Username: admin<br>Password: admin123</p>";
        echo "<p>You can now login at: <a href='login.php'>login.php</a></p>";
    } else {
        echo "<p style='color: red;'>✗ Failed to create admin user</p>";
    }
} else {
    echo "<p style='color: blue;'>ℹ Admin user already exists</p>";
}
?>