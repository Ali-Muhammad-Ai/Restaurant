-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 02, 2026 at 07:16 PM
-- Server version: 8.4.3
-- PHP Version: 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `foodfinder_karachi`
--

-- --------------------------------------------------------

--
-- Table structure for table `cafes`
--

CREATE TABLE `cafes` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text,
  `address` varchar(255) DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL,
  `coffee_types` text,
  `rating` decimal(2,1) DEFAULT '0.0',
  `opening_hours` varchar(255) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `featured` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `cafes`
--

INSERT INTO `cafes` (`id`, `name`, `description`, `address`, `location`, `coffee_types`, `rating`, `opening_hours`, `phone`, `image`, `featured`, `created_at`) VALUES
(1, 'Coffee Wagon', 'Artisanal coffee and cozy atmosphere in Clifton. Perfect for work or relaxation.', 'Clifton, Karachi', 'Clifton', 'Espresso, Latte, Cappuccino, Cold Brew', 4.6, '8:00 AM - 11:00 PM', '+92 21 111-678-901', 'coffee-wagon.jpg', 1, '2026-06-03 21:10:05'),
(2, 'Espresso', 'Premium coffee experience in Bahadurabad with imported beans.', 'Bahadurabad, Karachi', 'Bahadurabad', 'Espresso, Americano, Mocha, Caramel Latte', 4.7, '7:00 AM - 12:00 AM', '+92 21 111-789-012', 'espresso.jpg', 1, '2026-06-03 21:10:05'),
(3, 'Cafe Aylanto', 'Elegant cafe with Continental cuisine and premium coffee.', 'Zamzama, Karachi', 'Zamzama', 'Cappuccino, Latte, Special Brews', 4.5, '9:00 AM - 11:30 PM', '+92 21 111-890-123', 'cafe-aylanto.jpg', 1, '2026-06-03 21:10:05'),
(4, 'Ginoxy', 'Trendy cafe in Clifton with unique coffee blends.', 'Clifton, Karachi', 'Clifton', 'Frappuccino, Espresso, Turkish Coffee', 4.4, '10:00 AM - 12:00 AM', '+92 21 111-901-234', 'ginoxy-cafe.jpg', 1, '2026-06-03 21:10:05'),
(5, 'Evergreen Cafe', 'Garden-themed cafe perfect for breakfast and brunch.', 'Clifton, Karachi', 'Clifton', 'Cold Coffee, Frappuccino, Americano', 4.4, '10:00 AM - 10:00 PM', '+92 21 111-012-345', 'evergreen.jpg', 0, '2026-06-03 21:10:05'),
(6, 'Big Tree House Cafe', 'Unique treehouse experience in DHA.', 'DHA, Karachi', 'DHA', 'Specialty Coffee, Tea, Espresso', 4.6, '8:00 AM - 11:00 PM', '+92 21 111-123-789', 'big-tree.jpg', 0, '2026-06-03 21:10:05'),
(7, 'Cafe Flo', 'French-inspired cafe with authentic pastries.', 'Clifton, Karachi', 'Clifton', 'French Press, Espresso, Latte', 4.5, '8:00 AM - 10:00 PM', '+92 21 111-234-890', 'cafe-flo.jpg', 0, '2026-06-03 21:10:05'),
(8, 'Cote Rotie', 'Luxury cafe experience with premium coffee blends.', 'DHA Phase 8, Karachi', 'DHA', 'Premium Blends, Single Origin', 4.8, '7:00 AM - 1:00 AM', '+92 21 111-345-901', 'cote-rotie.jpg', 1, '2026-06-03 21:10:05');

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE `favorites` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `item_type` varchar(50) NOT NULL,
  `item_id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `subtitle` varchar(255) DEFAULT '',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `food_streets`
--

CREATE TABLE `food_streets` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text,
  `location` varchar(255) DEFAULT NULL,
  `famous_for` text,
  `image` varchar(255) DEFAULT NULL,
  `rating` decimal(2,1) DEFAULT '0.0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `food_streets`
--

INSERT INTO `food_streets` (`id`, `name`, `description`, `location`, `famous_for`, `image`, `rating`, `created_at`) VALUES
(1, 'Burns Road', 'Historic food street famous for traditional Pakistani street food since 1950s. Home to legendary food spots.', 'Karachi', 'Nihari, Biryani, BBQ, Rabri, Street Food', 'burns-road.jpg', 4.6, '2026-06-03 21:10:05'),
(2, 'Do Darya', 'Waterfront dining destination with premium restaurants offering stunning Arabian Sea views.', 'Clifton, Karachi', 'Seafood, Fine Dining, BBQ, Continental', 'do-darya.jpg', 4.5, '2026-06-03 21:10:05'),
(3, 'Boat Basin', 'Lively food hub with diverse dining options open till late night.', 'Karachi', 'BBQ, Fast Food, Continental, Desi', 'boat-basin.jpg', 4.4, '2026-06-03 21:10:05'),
(4, 'Hussainabad', 'Famous for late night BBQ and authentic street food experience.', 'Karachi', 'BBQ, Seekh Kabab, Malai Boti, Street Food', 'hussainabad.jpg', 4.5, '2026-06-03 21:10:05'),
(5, 'Bahadurabad', 'Food paradise with budget-friendly options and famous sweet shops.', 'Bahadurabad, Karachi', 'Fast Food, Desi Food, Sweets, Biryani', 'bahadurabad.jpg', 4.3, '2026-06-03 21:10:05'),
(6, 'Zamzama', 'Upscale dining destination with trendy cafes and fine dining restaurants.', 'DHA, Karachi', 'Cafes, Continental, Fine Dining, Italian', 'zamzama.jpg', 4.6, '2026-06-03 21:10:05');

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`id`, `name`, `created_at`) VALUES
(1, 'Karachi', '2026-07-01 10:40:51'),
(2, 'Clifton', '2026-07-01 10:40:51'),
(3, 'DHA', '2026-07-01 10:40:51'),
(4, 'Gulshan', '2026-07-01 10:40:51'),
(5, 'Do Darya', '2026-07-01 10:40:51'),
(6, 'Bahadurabad', '2026-07-01 10:40:51'),
(7, 'Zamzama', '2026-07-01 10:40:51');

-- --------------------------------------------------------

--
-- Table structure for table `restaurants`
--

CREATE TABLE `restaurants` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text,
  `address` varchar(255) DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL,
  `cuisine` varchar(100) DEFAULT NULL,
  `price_range` varchar(50) DEFAULT NULL,
  `rating` decimal(2,1) DEFAULT '0.0',
  `opening_hours` varchar(255) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `featured` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `restaurants`
--

INSERT INTO `restaurants` (`id`, `name`, `description`, `address`, `location`, `cuisine`, `price_range`, `rating`, `opening_hours`, `phone`, `image`, `featured`, `created_at`) VALUES
(1, 'Kolahi', 'Authentic Pakistani cuisine with stunning sea view at Do Darya. Famous for their BBQ platters and traditional Karahi.', 'Do Darya, Karachi', 'Do Darya', 'Pakistani, BBQ', '$$$', 4.7, '12:00 PM - 12:00 AM', '+92 21 111-123-456', 'kolahi.jpg', 1, '2026-06-03 21:10:05'),
(2, 'BBQ Tonight', 'Karachi\'s most loved BBQ destination serving authentic grilled delicacies since 1992.', 'Gulshan-e-Iqbal, Karachi', 'Gulshan', 'BBQ, Pakistani', '$$', 4.6, '6:00 PM - 1:00 AM', '+92 21 111-234-567', 'bbq-tonight.jpg', 1, '2026-06-03 21:10:05'),
(3, 'Al Bustan', 'Elegant Lebanese and Middle Eastern cuisine in the heart of Clifton.', 'Clifton, Karachi', 'Clifton', 'Lebanese, Middle Eastern', '$$$', 4.6, '12:00 PM - 11:00 PM', '+92 21 111-345-678', 'al-bustan.jpg', 1, '2026-06-03 21:10:05'),
(4, 'Saltanat', 'Royal Mughlai cuisine experience fit for kings.', 'DHA Phase 8, Karachi', 'DHA', 'Mughlai, Pakistani', '$$$', 4.5, '1:00 PM - 12:00 AM', '+92 21 111-456-789', 'saltanat.jpg', 0, '2026-06-03 21:10:05'),
(5, 'Ginsoy', 'Best Chinese cuisine in Karachi with authentic flavors.', 'Clifton, Karachi', 'Clifton', 'Chinese', '$$', 4.4, '12:00 PM - 11:30 PM', '+92 21 111-567-890', 'ginsoy.jpg', 0, '2026-06-03 21:10:05');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `restaurant_id` int DEFAULT NULL,
  `cafe_id` int DEFAULT NULL,
  `rating` int DEFAULT NULL,
  `comment` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`user_id`, `restaurant_id`, `cafe_id`, `rating`, `comment`) VALUES
(2, 1, NULL, 5, 'Amazing food and great service! The BBQ platter is a must try.'),
(3, 2, NULL, 5, 'Best BBQ in town. Their malai boti is incredible!'),
( 4, 3, NULL, 4, 'Great Lebanese food. Hummus and falafel were delicious.'),
(2, 4, NULL, 5, 'Royal experience! The mutton karahi was outstanding.'),
(3, 5, NULL, 4, 'Best Chinese food in Karachi. Highly recommend chowmein.'),
(2, NULL, 1, 5, 'Best coffee in Clifton. Great ambiance for work.'),
(3, NULL, 2, 5, 'Espresso here is perfect. Barista knows his craft.'),
(4, NULL, 3, 4, 'Beautiful place, amazing coffee and pastries.'),
(2, NULL, 6, 5, 'Unique experience! Must visit for coffee lovers.'),
(3, NULL, 8, 5, 'Premium coffee at its best. Worth every penny.');





INSERT INTO `reviews` (`id`, `user_id`, `restaurant_id`, `cafe_id`, `rating`, `comment`, `created_at`) VALUES
(1, 2, 1, NULL, 5, 'Amazing food and great service! The BBQ platter is a must try.', '2026-06-03 21:10:05'),
(2, 3, 2, NULL, 5, 'Best BBQ in town. Their malai boti is incredible!', '2026-06-03 21:10:05'),
(3, 4, 3, NULL, 4, 'Great Lebanese food. Hummus and falafel were delicious.', '2026-06-03 21:10:05'),
(4, 2, 4, NULL, 5, 'Royal experience! The mutton karahi was outstanding.', '2026-06-03 21:10:05'),
(5, 3, 5, NULL, 4, 'Best Chinese food in Karachi. Highly recommend chowmein.', '2026-06-03 21:10:05'),
(6, 2, NULL, 1, 5, 'Best coffee in Clifton. Great ambiance for work.', '2026-06-03 21:10:05'),
(7, 3, NULL, 2, 5, 'Espresso here is perfect. Barista knows his craft.', '2026-06-03 21:10:05'),
(8, 4, NULL, 3, 4, 'Beautiful place, amazing coffee and pastries.', '2026-06-03 21:10:05'),
(9, 2, NULL, 6, 5, 'Unique experience! Must visit for coffee lovers.', '2026-06-03 21:10:05'),
(10, 3, NULL, 8, 5, 'Premium coffee at its best. Worth every penny.', '2026-06-03 21:10:05');

-- --------------------------------------------------------

--
-- Table structure for table `site_stats`
--

CREATE TABLE `site_stats` (
  `id` int NOT NULL,
  `total_restaurants` int DEFAULT '0',
  `total_cafes` int DEFAULT '0',
  `total_users` int DEFAULT '0',
  `total_reviews` int DEFAULT '0',
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `site_stats`
--

INSERT INTO `site_stats` (`id`, `total_restaurants`, `total_cafes`, `total_users`, `total_reviews`, `updated_at`) VALUES
(1, 5, 8, 6, 10, '2026-07-02 19:12:14');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile_image` varchar(255) DEFAULT 'default-avatar.png',
  `role` enum('user','admin') DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `profile_image`, `role`, `created_at`) VALUES
(1, 'Admin User', 'admin@foodfinder.com', '$2y$10$YourHashedPasswordHere', 'default-avatar.png', 'admin', '2026-06-03 21:10:05'),
(2, 'Ali Raza', 'ali@example.com', '$2y$10$YourHashedPasswordHere', 'default-avatar.png', 'user', '2026-06-03 21:10:05'),
(3, 'Sana Khan', 'sana@example.com', '$2y$10$YourHashedPasswordHere', 'default-avatar.png', 'user', '2026-06-03 21:10:05'),
(4, 'Ayisha Khan', 'ayisha@example.com', '$2y$10$YourHashedPasswordHere', 'default-avatar.png', 'user', '2026-06-03 21:10:05'),
(5, 'Default Admin', 'admin@vision.com', '$2y$10$Vj3IIvKNcKdWroajWc3Ya.VDiRhBXG/gpM4vNWF./hLOKGZlEwZOC', 'default-avatar.png', 'admin', '2026-07-01 10:40:51'),
(6, 'Shaaz', 'shaaz@vision.com', '$2y$10$A89Y0qGkMSQsSzuJyPDk4e/HXpvuN87t1GB3eQVelpbT5bndGrKIq', 'default-avatar.png', 'user', '2026-07-01 20:17:43');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cafes`
--
ALTER TABLE `cafes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_user_item` (`user_id`,`item_type`,`item_id`);

--
-- Indexes for table `food_streets`
--
ALTER TABLE `food_streets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `restaurants`
--
ALTER TABLE `restaurants`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `restaurant_id` (`restaurant_id`),
  ADD KEY `cafe_id` (`cafe_id`);

--
-- Indexes for table `site_stats`
--
ALTER TABLE `site_stats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cafes`
--
ALTER TABLE `cafes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `food_streets`
--
ALTER TABLE `food_streets`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=561;

--
-- AUTO_INCREMENT for table `restaurants`
--
ALTER TABLE `restaurants`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `site_stats`
--
ALTER TABLE `site_stats`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `favorites_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`restaurant_id`) REFERENCES `restaurants` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_3` FOREIGN KEY (`cafe_id`) REFERENCES `cafes` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
