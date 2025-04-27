-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 17, 2024 at 11:45 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `accommodation_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `ads`
--

CREATE TABLE `ads` (
  `ad_id` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ads`
--

INSERT INTO `ads` (`ad_id`, `description`, `image_path`) VALUES
(2, '🌟 Explore Colombo! Book Your Stay Now! 🏠\r\n\r\nDiscover comfort and convenience at our cozy hostel in the heart of Colombo, Sri Lanka. With clean rooms, complimentary Wi-Fi, and a prime location near the city\'s attractions, your adventure awaits. Book your stay today for an unforgettable experience! 🛏️🌴', '../uploads/getlstd-property-photo.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `approved_properties`
--

CREATE TABLE `approved_properties` (
  `property_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `rental` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `approved_properties`
--

INSERT INTO `approved_properties` (`property_id`, `user_id`, `address`, `description`, `rental`, `created_at`) VALUES
(1, 19, 'sgdga', 'agweg', 2353.00, '2024-03-17 19:52:21'),
(2, 19, 'sgdga', 'agweg', 2353.00, '2024-03-17 19:53:15'),
(3, 19, 'sgdga', 'agweg', 2353.00, '2024-03-17 19:53:22'),
(4, 19, 'sgdga', 'agweg', 2353.00, '2024-03-17 19:54:15'),
(5, 19, 'sgdga', 'agweg', 2353.00, '2024-03-17 19:55:15'),
(6, 19, 'sgdga', 'agweg', 2353.00, '2024-03-17 19:56:09'),
(7, 19, 'sgdga', 'agweg', 2353.00, '2024-03-17 19:57:25'),
(8, 19, 'sgdga', 'agweg', 2353.00, '2024-03-17 19:57:29');

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE `articles` (
  `article_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `published_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `properties`
--

CREATE TABLE `properties` (
  `property_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `rental` decimal(10,2) NOT NULL,
  `status` enum('available','reserved','rejected') DEFAULT 'available',
  `warden_status` enum('approved','rejected','pending') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `student_request` enum('requested','not_requested') DEFAULT 'not_requested'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `properties`
--

INSERT INTO `properties` (`property_id`, `user_id`, `address`, `description`, `image_path`, `rental`, `status`, `warden_status`, `created_at`, `student_request`) VALUES
(19, 19, 'jj', 'jjjjj', '../uploads/THEME_HOTEL_HOSTEL_BEDROOM-shutterstock-portfolio_1708374559.jpg', 99999999.99, 'reserved', 'approved', '2024-03-17 20:39:25', 'not_requested'),
(20, 19, 'Colombo, Sri Lanka', 'Nestled amidst lush greenery in the coastal town of Mirissa, Tropical Haven Hostel offers a tranquil retreat for budget travelers. Enjoy comfortable dormitory-style accommodation, complimentary breakfast, and easy access to Mirissa Beach for surfing and whale watching adventures.', '../uploads/465800942.jpg', 20000.00, 'available', 'approved', '2024-03-17 21:55:44', 'not_requested'),
(21, 19, 'Kottawa, Sri Lanka', 'Experience the vibrant energy of Colombo at Cityscape Backpackers. Located in the heart of the city, this hostel offers modern amenities, including air-conditioned dormitories, a rooftop terrace with panoramic views, and a lively communal area. Explore nearby attractions such as Gangaramaya Temple and Galle Face Green.', '../uploads/THEME_HOTEL_HOSTEL_BEDROOM-shutterstock-portfolio_1708374559.jpg', 30000.00, 'available', 'approved', '2024-03-17 21:56:10', 'not_requested'),
(22, 19, 'Pitipana Sri, Lanka', 'Perched atop the picturesque hills of Ella, Ella Heights Hostel provides breathtaking views of the lush tea plantations below. Relax in cozy dormitory rooms, savor authentic', '../uploads/1200px-A_room_at_the_Hostal_Providencia_in_Santiago.jpg', 100000.00, 'available', 'pending', '2024-03-17 21:56:39', 'not_requested'),
(23, 19, 'Maharagama, Sri Lanka', 'Immerse yourself in the rich cultural heritage of Kandy at Cultural Oasis Hostel. Set within a traditional Sri Lankan house', '../uploads/hostel-room-types-5.jpg', 700000.00, 'available', 'approved', '2024-03-17 21:57:02', 'not_requested');

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `reservation_id` int(11) NOT NULL,
  `property_id` int(11) DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`reservation_id`, `property_id`, `student_id`, `status`, `created_at`) VALUES
(4, 19, 6, 'pending', '2024-03-17 20:41:57');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` enum('landlord','warden','student','admin') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `user_type`) VALUES
(1, '', '$2y$10$3eT0pijEEpYx4OBaonVgPepfA3pWZ44dkl9PHnwr6aW6spRYJK3Sa', 'student'),
(6, 'student', '$2y$10$54ADQrNnrWQ4y0o9NqBJSeMm40QS/N93X5KGpo6Q5Xo3pBIV6.dTC', 'student'),
(7, 'landloard1', '$2y$10$Yv1emSLG5yQIphvN.argae1yOkm7Maz7Voj7Ye7b0e75Drp4ckmpG', 'landlord'),
(10, 'student3', '$2y$10$w3xjk19MXjZ9L/L3osa4.Ojterp4arh1sc5h4wziJXWPaIgudOM1m', 'student'),
(11, 'student4', '$2y$10$sUaCNw7.S.2Qj1gX9v4L7.tAaydvRSoCXWPbm5J22h1FnEdzjvmt.', 'student'),
(12, 'student6', '$2y$10$WFAizmzF4jNTJWG4ROxKau3wX9WIptMas43P7fsGVbtWl9Z49U2yC', 'student'),
(13, 'student8', '$2y$10$8LR8L7HAmCiL6h0Bjk2.ae8ROJNJRgv6/rRM242E81zCtpKgAuwii', 'student'),
(14, 'student5', '$2y$10$cCgV5ptag9OKQis9whhQ2.vMErhcEaln.KtOlDWa8Dqa/vfG1Tx/C', 'student'),
(15, 'student09', '$2y$10$EfUErVdZRipiiHMOr4lrN.nAp6i0cQzSp063nGdDaPLNgKkeMfLfK', 'student'),
(16, 'admin', '$2y$10$1BaGLjtf4xq3/pOjjLgMqefUxLFpxCybK/vt7wlQPI17IWntQw9n', 'admin'),
(17, 'admin1', '$2y$10$vrlOW1uBo5v/1Y.FTXBKNuidVqGthjz7iSeGc94pdeNfmazyTsawa', 'admin'),
(18, 'warden1', '$2y$10$f5xAa1ywcOfi4lQtAfo.OeFIGH5yQDeiPeftK2sv.5Td/qHBYDxzK', 'warden'),
(19, 'landlord', '$2y$10$HzI23EYpXFqv3AEXvll9..qD5yJyhY7tDd2GUnNdzPrj4kYWBDuX2', 'landlord'),
(20, 'wardern1', '$2y$10$IKre5VjxGAx2xk16mm0CEuHXCXpFnZhQpqAAx0vlBc2FE7q3MWcIq', 'student'),
(21, 'wardern', '$2y$10$ib//FNlZkSYXrkweMP0zZeqZdHuklbNTOc2G07kz.ReQL.WOyPzeu', 'warden');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ads`
--
ALTER TABLE `ads`
  ADD PRIMARY KEY (`ad_id`);

--
-- Indexes for table `approved_properties`
--
ALTER TABLE `approved_properties`
  ADD PRIMARY KEY (`property_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`article_id`);

--
-- Indexes for table `properties`
--
ALTER TABLE `properties`
  ADD PRIMARY KEY (`property_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`reservation_id`),
  ADD KEY `property_id` (`property_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ads`
--
ALTER TABLE `ads`
  MODIFY `ad_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `approved_properties`
--
ALTER TABLE `approved_properties`
  MODIFY `property_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `articles`
--
ALTER TABLE `articles`
  MODIFY `article_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `properties`
--
ALTER TABLE `properties`
  MODIFY `property_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `reservation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `approved_properties`
--
ALTER TABLE `approved_properties`
  ADD CONSTRAINT `approved_properties_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `properties`
--
ALTER TABLE `properties`
  ADD CONSTRAINT `properties_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`property_id`) REFERENCES `properties` (`property_id`),
  ADD CONSTRAINT `reservations_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
