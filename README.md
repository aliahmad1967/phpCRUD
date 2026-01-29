# PHP CRUD Application

A modern, secure, and responsive PHP CRUD (Create, Read, Update, Delete) application for managing Users, Posts, and Items.

## 🚀 Features

- **User Authentication:** Secure registration and login system with password hashing.
- **Content Management:** Create, edit, and delete blog posts.
- **Inventory System:** Manage items with names, descriptions, and pricing.
- **Modern UI:** Responsive design with a clean landing page and intuitive dashboard.
- **Security:** Built with SQL injection protection (prepared statements) and session management.

## 🛠️ Technology Stack

- **Backend:** PHP 8.x
- **Database:** MySQL / MariaDB
- **Frontend:** HTML5, CSS3 (with Font Awesome icons)
- **Server:** Apache (XAMPP/WAMP compatible)

## 📋 Prerequisites

- PHP installed (v7.4 or higher recommended)
- MySQL/MariaDB server
- Web server (Apache or Nginx)

## ⚙️ Installation & Setup

1. **Clone the repository:**
   ```bash
   git clone https://github.com/aliahmad1967/phpCRUD.git
   ```

2. **Database Configuration:**
   - Import the `database.sql` file into your MySQL database.
   - Update `config.php` with your database credentials:
     ```php
     define('DB_HOST', 'localhost');
     define('DB_USER', 'your_username');
     define('DB_PASS', 'your_password');
     define('DB_NAME', 'phpcrud_db');
     ```

3. **Sample Credentials:**
   - **Username:** `admin`
   - **Password:** `admin123`

## 📖 User Guide

### 1. Getting Started
- Navigate to the home page (`index.php`).
- Click on **"Go to Dashboard"** to proceed to the login screen.
- If you don't have an account, click **"Create Account"** to register.

### 2. Dashboard Overview
Once logged in, you will be redirected to the **Welcome Dashboard**. Here you can:
- See your account details.
- View a summary of your recent posts.
- Use the quick action buttons to manage content.

### 3. Managing Posts
- Click **"Manage Posts"** from the dashboard or navigation menu.
- **Create:** Click "Create New Post", fill in the title, content, and status, then save.
- **Edit:** Click the "Edit" button next to any post to modify its details.
- **Delete:** Click the "Delete" button to remove a post (requires confirmation).

### 4. Managing Items (Inventory)
- Click **"Manage Items"** in the navigation menu.
- **Add Item:** Click "Add New Item" to record a new product with its price and description.
- **Update/Delete:** Similar to posts, you can modify or remove items from your list.

### 5. Logging Out
- To securely end your session, click the **"Logout"** link in the navigation bar from any page.

## 📂 Project Structure

- `index.php` - Modern landing page
- `login.php` / `register.php` - Authentication forms
- `welcome.php` - User dashboard
- `posts.php` - Post management
- `items.php` - Item/Inventory management
- `config.php` - Database connection and settings
- `auth_helper.php` - Authentication utilities
- `style.css` - Custom styling for the entire app

## 🛡️ Security

This application implements several security best practices:
- Password hashing using `password_hash()`.
- Prepared statements (`mysqli_prepare`) to prevent SQL Injection.
- Session-based authentication.
- Input sanitization.

## 📄 License

This project is open-source and available under the MIT License.
