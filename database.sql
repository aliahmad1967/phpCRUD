-- Create database if it doesn't exist
CREATE DATABASE IF NOT EXISTS phpcrud_db;

-- Use the database
USE phpcrud_db;

-- Create users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create posts table
CREATE TABLE IF NOT EXISTS posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    content TEXT NOT NULL,
    excerpt VARCHAR(300),
    status ENUM('draft', 'published', 'archived') DEFAULT 'draft',
    user_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user_id (user_id),
    INDEX idx_status (status),
    INDEX idx_created_at (created_at)
);

-- Create items table
CREATE TABLE IF NOT EXISTS items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    user_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user_id (user_id)
);

-- Insert sample user (password: password123)
INSERT IGNORE INTO users (id, username, email, password) VALUES (1, 'admin', 'admin@example.com', '$2y$10$G1s8lDF5rVSVv5HTimS7geUU5POYsA1qCsVoQ6NhtJQUrYc7/cqXm');

-- Insert sample posts (optional)
INSERT INTO posts (title, content, excerpt, status, user_id) VALUES 
('Welcome to Your First Post', 'This is the content of your first post. You can edit this post or create new ones using the manage posts section.', 'A welcoming message for new users', 'published', 1),
('Getting Started with PHP CRUD', 'Learn how to use this PHP CRUD application effectively. This system allows you to create, read, update, and delete posts with ease.', 'A guide to using the PHP CRUD system', 'published', 1),
('Draft Post Example', 'This is a draft post that hasn\'t been published yet. You can edit it and change the status to published when ready.', 'An example of a draft post', 'draft', 1);
