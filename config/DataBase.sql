-- Create Database
CREATE DATABASE IF NOT EXISTS foodfinder_karachi;

USE foodfinder_karachi;

-- Users Table
CREATE TABLE IF NOT EXISTS users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    profile_image VARCHAR(255) DEFAULT 'default-avatar.png',
    role ENUM('user', 'admin') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Restaurants Table
CREATE TABLE IF NOT EXISTS restaurants (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    address VARCHAR(255),
    location VARCHAR(100),
    cuisine VARCHAR(100),
    price_range VARCHAR(50),
    rating DECIMAL(2, 1) DEFAULT 0,
    opening_hours VARCHAR(255),
    phone VARCHAR(50),
    image VARCHAR(255),
    featured BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Cafes Table
CREATE TABLE IF NOT EXISTS cafes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    address VARCHAR(255),
    location VARCHAR(100),
    coffee_types TEXT,
    rating DECIMAL(2, 1) DEFAULT 0,
    opening_hours VARCHAR(255),
    phone VARCHAR(50),
    image VARCHAR(255),
    featured BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Food Streets Table
CREATE TABLE IF NOT EXISTS food_streets (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    location VARCHAR(255),
    famous_for TEXT,
    image VARCHAR(255),
    rating DECIMAL(2, 1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Reviews Table
CREATE TABLE IF NOT EXISTS reviews (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    restaurant_id INT NULL,
    cafe_id INT NULL,
    rating INT CHECK (
        rating >= 1
        AND rating <= 5
    ),
    comment TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE,
    FOREIGN KEY (restaurant_id) REFERENCES restaurants (id) ON DELETE CASCADE,
    FOREIGN KEY (cafe_id) REFERENCES cafes (id) ON DELETE CASCADE
);

-- Favorites Table
CREATE TABLE IF NOT EXISTS favorites (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    item_type VARCHAR(50) NOT NULL,
    item_id INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    url VARCHAR(255) NOT NULL,
    subtitle VARCHAR(255) DEFAULT '',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_user_item (user_id, item_type, item_id),
    FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE
);

-- Locations Table
CREATE TABLE IF NOT EXISTS locations (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) UNIQUE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Statistics Table (for dashboard)
CREATE TABLE IF NOT EXISTS site_stats (
    id INT PRIMARY KEY AUTO_INCREMENT,
    total_restaurants INT DEFAULT 0,
    total_cafes INT DEFAULT 0,
    total_users INT DEFAULT 0,
    total_reviews INT DEFAULT 0,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert default admin account if missing
INSERT INTO
    users (name, email, password, role)
SELECT 'Default Admin', 'admin@vision.com', '$2y$10$5JHugF1x0l6VKGb1r2n1Pezigf3R/d6gL7F8w2Akl8N7qL0uIcw9q', 'admin'
WHERE
    NOT EXISTS (
        SELECT 1
        FROM users
        WHERE
            email = 'admin@vision.com'
    );

-- Insert sample data if tables are empty
INSERT INTO
    restaurants (
        name,
        description,
        address,
        location,
        cuisine,
        price_range,
        rating,
        opening_hours,
        phone,
        image,
        featured
    )
SELECT 'Kolahi', 'Authentic Pakistani cuisine with stunning sea view at Do Darya. Famous for their BBQ platters and traditional Karahi.', 'Do Darya, Karachi', 'Do Darya', 'Pakistani, BBQ', '$$$', 4.7, '12:00 PM - 12:00 AM', '+92 21 111-123-456', 'kolahi.jpg', 1
WHERE
    NOT EXISTS (
        SELECT 1
        FROM restaurants
        WHERE
            name = 'Kolahi'
    );

INSERT INTO
    restaurants (
        name,
        description,
        address,
        location,
        cuisine,
        price_range,
        rating,
        opening_hours,
        phone,
        image,
        featured
    )
SELECT 'BBQ Tonight', 'Karachi\'s most loved BBQ destination serving authentic grilled delicacies since 1992.', 'Gulshan-e-Iqbal, Karachi', 'Gulshan', 'BBQ, Pakistani', '$$', 4.6, '6:00 PM - 1:00 AM', '+92 21 111-234-567', 'bbq-tonight.jpg', 1
WHERE
    NOT EXISTS (
        SELECT 1
        FROM restaurants
        WHERE
            name = 'BBQ Tonight'
    );

INSERT INTO
    restaurants (
        name,
        description,
        address,
        location,
        cuisine,
        price_range,
        rating,
        opening_hours,
        phone,
        image,
        featured
    )
SELECT 'Al Bustan', 'Elegant Lebanese and Middle Eastern cuisine in the heart of Clifton.', 'Clifton, Karachi', 'Clifton', 'Lebanese, Middle Eastern', '$$$', 4.6, '12:00 PM - 11:00 PM', '+92 21 111-345-678', 'al-bustan.jpg', 1
WHERE
    NOT EXISTS (
        SELECT 1
        FROM restaurants
        WHERE
            name = 'Al Bustan'
    );

INSERT INTO
    cafes (
        name,
        description,
        address,
        location,
        coffee_types,
        rating,
        opening_hours,
        phone,
        image,
        featured
    )
SELECT 'Coffee Wagon', 'Artisanal coffee and cozy atmosphere in Clifton. Perfect for work or relaxation.', 'Clifton, Karachi', 'Clifton', 'Espresso, Latte, Cappuccino, Cold Brew', 4.6, '8:00 AM - 11:00 PM', '+92 21 111-678-901', 'coffee-wagon.jpg', 1
WHERE
    NOT EXISTS (
        SELECT 1
        FROM cafes
        WHERE
            name = 'Coffee Wagon'
    );

INSERT INTO
    cafes (
        name,
        description,
        address,
        location,
        coffee_types,
        rating,
        opening_hours,
        phone,
        image,
        featured
    )
SELECT 'Espresso', 'Premium coffee experience in Bahadurabad with imported beans.', 'Bahadurabad, Karachi', 'Bahadurabad', 'Espresso, Americano, Mocha, Caramel Latte', 4.7, '7:00 AM - 12:00 AM', '+92 21 111-789-012', 'espresso.jpg', 1
WHERE
    NOT EXISTS (
        SELECT 1
        FROM cafes
        WHERE
            name = 'Espresso'
    );

INSERT INTO
    food_streets (
        name,
        description,
        location,
        famous_for,
        image,
        rating
    )
SELECT 'Burns Road', 'Historic food street famous for traditional Pakistani street food since 1950s. Home to legendary food spots.', 'Karachi', 'Nihari, Biryani, BBQ, Rabri, Street Food', 'burns-road.jpg', 4.6
WHERE
    NOT EXISTS (
        SELECT 1
        FROM food_streets
        WHERE
            name = 'Burns Road'
    );

INSERT INTO
    locations (name)
SELECT 'Karachi'
WHERE
    NOT EXISTS (
        SELECT 1
        FROM locations
        WHERE
            name = 'Karachi'
    );

INSERT INTO
    locations (name)
SELECT 'Clifton'
WHERE
    NOT EXISTS (
        SELECT 1
        FROM locations
        WHERE
            name = 'Clifton'
    );

INSERT INTO
    locations (name)
SELECT 'DHA'
WHERE
    NOT EXISTS (
        SELECT 1
        FROM locations
        WHERE
            name = 'DHA'
    );

INSERT INTO
    locations (name)
SELECT 'Gulshan'
WHERE
    NOT EXISTS (
        SELECT 1
        FROM locations
        WHERE
            name = 'Gulshan'
    );

INSERT INTO
    locations (name)
SELECT 'Do Darya'
WHERE
    NOT EXISTS (
        SELECT 1
        FROM locations
        WHERE
            name = 'Do Darya'
    );

INSERT INTO
    locations (name)
SELECT 'Bahadurabad'
WHERE
    NOT EXISTS (
        SELECT 1
        FROM locations
        WHERE
            name = 'Bahadurabad'
    );

INSERT INTO
    locations (name)
SELECT 'Zamzama'
WHERE
    NOT EXISTS (
        SELECT 1
        FROM locations
        WHERE
            name = 'Zamzama'
    );

INSERT INTO
    site_stats (
        total_restaurants,
        total_cafes,
        total_users,
        total_reviews
    )
SELECT (
        SELECT COUNT(*)
        FROM restaurants
    ), (
        SELECT COUNT(*)
        FROM cafes
    ), (
        SELECT COUNT(*)
        FROM users
    ), (
        SELECT COUNT(*)
        FROM reviews
    )
WHERE
    NOT EXISTS (
        SELECT 1
        FROM site_stats
    );