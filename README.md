# FoodFinder Karachi

A glassmorphism-inspired restaurant finder website for Karachi, built with PHP and Bootstrap.

## What’s included

- Homepage with featured restaurants, cafes, food streets, and recent reviews
- Restaurant, cafe, and food-street listing and detail pages
- User authentication with signup and login
- Database-backed favorites for logged-in users
- Admin panel for managing restaurants, cafes, food streets, and locations

## Main files

- `index.php` — homepage
- `restaurants.php` / `restaurant.php` — restaurant browsing and details
- `cafes.php` / `cafe.php` — cafe browsing and details
- `food-streets.php` / `food-street.php` — food-street browsing and details
- `favorites.php` — saved favorites page
- `login.php`, `signup.php`, `logout.php` — authentication flow
- `admin-panel.php` — admin-only management dashboard
- `config/database.php` — database connection, auth helpers, and favorites support
- `config/DataBase.sql` — database schema and sample data

## Default admin account

- Email: `admin@vision.com`
- Password: `admin123`

## Setup

1. Make sure PHP and MySQL are installed.
2. Import `config/DataBase.sql` into your local database.
3. Update `config/database.php` with your local database credentials if needed.
4. Serve the site using your local web server or PHP built-in server.
5. Open `login.php` to sign in, or visit `signup.php` to create a regular user account.

## Notes

- Favorites are stored in the database for logged-in users.
- Admin users can access the management dashboard from the navigation menu after signing in.
