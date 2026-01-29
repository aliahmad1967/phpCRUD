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
