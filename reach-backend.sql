-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 25, 2023 at 05:39 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `reach-backend`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `createdAt`, `updatedAt`) VALUES
(1, 'Doctor', '2023-01-25 01:07:44', '2023-01-25 01:07:44'),
(2, 'Nurse', '2023-01-25 01:07:44', '2023-01-25 01:07:44'),
(3, 'Maid', '2023-01-25 01:07:44', '2023-01-25 01:07:44'),
(4, 'Electrician', '2023-01-25 01:07:44', '2023-01-25 01:07:44'),
(5, 'Plumber', '2023-01-25 01:08:03', '2023-01-25 01:08:03');

-- --------------------------------------------------------

--
-- Table structure for table `chat`
--

CREATE TABLE `chat` (
  `id` int(11) NOT NULL,
  `senderId` int(11) NOT NULL,
  `receiverId` int(11) NOT NULL,
  `message` text NOT NULL,
  `sentAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `randNumber` varchar(255) NOT NULL,
  `serviceConsumerId` int(11) NOT NULL,
  `serviceProviderId` int(11) NOT NULL,
  `serviceStartTime` timestamp NOT NULL DEFAULT current_timestamp(),
  `approxServiceDuration` varchar(255) NOT NULL,
  `status` enum('Created','In Progress','Completed') NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `service_options`
--

CREATE TABLE `service_options` (
  `userId` int(11) NOT NULL,
  `isHourBased` tinyint(4) DEFAULT NULL,
  `isServiceBased` tinyint(4) DEFAULT NULL,
  `approxCharge` decimal(10,2) DEFAULT NULL,
  `regularServiceStartsAt` varchar(255) NOT NULL,
  `regularServiceEndsAt` varchar(255) NOT NULL,
  `offDays` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`offDays`)),
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `firstName` varchar(20) NOT NULL,
  `lastName` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(14) NOT NULL,
  `password` varchar(255) NOT NULL,
  `isVerified` tinyint(1) NOT NULL DEFAULT 0,
  `description` text NOT NULL,
  `categoryId` int(11) DEFAULT NULL,
  `currentBalance` decimal(10,2) NOT NULL DEFAULT 0.00,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstName`, `lastName`, `email`, `phone`, `password`, `isVerified`, `description`, `categoryId`, `currentBalance`, `createdAt`, `updatedAt`) VALUES
(1, 'Sourav', 'Malo', 'sourav.cse5.bu@gmail.com', '+8801303458829', '$2y$10$ThXri/FOce0FHOd9QkIQTu9bZh6D27S17x/PLg9qF.JG92DQVWI6O', 0, 'I am currently a CSE student styding at University of Barishal. I am doing part time freelancing for last 2 years on fiverr marketplace.', NULL, '0.00', '2023-01-25 04:29:54', '2023-01-25 04:29:54');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `senderId` (`senderId`),
  ADD KEY `receiverId` (`receiverId`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `randNumber` (`randNumber`),
  ADD KEY `serviceConsumerId` (`serviceConsumerId`),
  ADD KEY `serviceProviderId` (`serviceProviderId`);

--
-- Indexes for table `service_options`
--
ALTER TABLE `service_options`
  ADD KEY `userId` (`userId`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `phone` (`phone`),
  ADD KEY `categoryId` (`categoryId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `chat`
--
ALTER TABLE `chat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chat`
--
ALTER TABLE `chat`
  ADD CONSTRAINT `chat_ibfk_1` FOREIGN KEY (`senderId`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `chat_ibfk_2` FOREIGN KEY (`receiverId`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`serviceConsumerId`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`serviceProviderId`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `service_options`
--
ALTER TABLE `service_options`
  ADD CONSTRAINT `service_options_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`categoryId`) REFERENCES `categories` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
