# TechHive Electronic 🚀

A premium, fully functional e-commerce web application for luxury electronics, built with a custom PHP backend and a stunning modern UI.

## Features ✨

- **Premium UI/UX**: Dark mode aesthetic, glassmorphism, smooth CSS animations, and highly responsive design.
- **Dynamic Catalog**: Browse laptops, earbuds, smartwatches, and accessories with real-time filtering, search, and sorting.
- **Full Shopping Cart System**: Add to cart, adjust quantities, view subtotal, and dynamic shipping calculations.
- **User Accounts**: Registration, login, profile management, and order history.
- **Admin Dashboard**: Full CRUD capabilities for products, categories, brands, orders, and users.
- **Contact & Newsletter**: Fully functioning backend with database storage and AJAX submissions.
- **Secure Architecture**: PDO prepared statements for SQL injection prevention, password hashing, and session-based auth.

## Tech Stack 🛠️

- **Frontend**: Vanilla HTML5, CSS3 (with custom variables and animations), Vanilla JavaScript.
- **Backend**: PHP 8+
- **Database**: MySQL (MariaDB)
- **Icons**: Lucide Icons

## Setup Instructions ⚙️

1. **Clone the repository**:
   ```bash
   git clone https://github.com/yourusername/TechHive-Electronic.git
   ```

2. **Server Setup**:
   - Install XAMPP, MAMP, or any Apache/MySQL server.
   - Place the repository folder into your `htdocs` (or `www`) directory.

3. **Database Configuration**:
   - Open phpMyAdmin (usually `http://localhost/phpmyadmin`).
   - Create a new database named `techhive_db`.
   - Import the `database.sql` file provided in the root directory.

4. **Run the App**:
   - Access the site via `http://localhost/TechHive-Electronic/` (adjust the folder name based on your setup).
   
5. **Admin Access**:
   - Navigate to `http://localhost/TechHive-Electronic/admin/login.php`
   - Use the seeded admin credentials to login.

## Folder Structure 📁

- `/assets`: CSS, JS, and product images
- `/includes`: Header, Footer, Navbar, and reusable components
- `/config`: Database connection (`database.php`)
- `/admin`: Backend admin panel
- `/logs`: Error and email logs
- `*.php`: Main frontend application pages

## License 📄

This project is licensed under the MIT License.
