-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: Jan 16, 2022 at 12:20 PM
-- Server version: 8.0.27
-- PHP Version: 7.4.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `iab`
--

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE `address` (
  `address_id` int NOT NULL,
  `street` varchar(255) DEFAULT NULL,
  `street_nr` int DEFAULT NULL,
  `flat_nr` int DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `postcode` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `address`
--

INSERT INTO `address` (`address_id`, `street`, `street_nr`, `flat_nr`, `city`, `postcode`, `country`) VALUES
(1, 'Palmerston Blvd.', 1, 23, 'Toronto', 'M6G 2N9', 'Canada'),
(2, 'Randolph Street', 345, 12, 'Chicago', '60601-6436', 'USA'),
(3, 'Avenue Victor Hugo', 1, 67, 'Paris', '75116', 'France'),
(4, 'Kurfürstendamm', 21, 15, 'Berlin', '11-237', 'Germany');

-- --------------------------------------------------------

--
-- Table structure for table `cars`
--

CREATE TABLE `cars` (
  `id` int NOT NULL,
  `make` varchar(255) DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `cars`
--

INSERT INTO `cars` (`id`, `make`, `model`) VALUES
(2, 'Audi', 'A4'),
(1, 'BMW', 'X5'),
(3, 'Fiat', 'Punto'),
(6, 'Ford', 'Fiesta'),
(7, 'Kia', 'Sportage'),
(8, 'Mercedes', 'S-Class'),
(5, 'Opel', 'Astra'),
(4, 'Seat', 'Ibiza');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `part_id` int NOT NULL,
  `quantity` int DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `car_parts`
--

CREATE TABLE `car_parts` (
  `id` int NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `manufacturer_id` int NOT NULL,
  `car_id` int NOT NULL,
  `price` decimal(15,2) DEFAULT NULL,
  `status` enum('out_of_stock','in_stock') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `car_parts`
--

INSERT INTO `car_parts` (`id`, `name`, `manufacturer_id`, `car_id`, `price`, `status`) VALUES
(1, 'AllSeasonContact Tire', 7, 2, '300.00', 'in_stock'),
(2, 'Genuine OE BOSCH oil filter', 6, 3, '30.00', 'in_stock'),
(3, 'BOSCH Spotlight Bulb', 6, 5, '280.00', 'in_stock'),
(4, 'Air filter BMW', 8, 1, '100.00', 'in_stock'),
(5, 'KYB Shock Absorber', 3, 3, '400.00', 'in_stock'),
(6, 'Brake disc Zimmermann', 6, 5, '120.00', 'in_stock'),
(7, 'Competition Clutch Stage 2', 2, 6, '800.00', 'in_stock'),
(8, 'Castrol Edge 5W-40', 8, 7, '50.00', 'in_stock'),
(9, 'Oil filter Mercedes-Benz', 2, 8, '80.00', 'in_stock');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int NOT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(4, 'Air filter'),
(6, 'Brake disc'),
(8, 'Clutch kit'),
(7, 'Engine oil'),
(3, 'Light bulb'),
(1, 'Oil filter'),
(5, 'Shock absorber'),
(2, 'Tire');

-- --------------------------------------------------------

--
-- Table structure for table `category_item`
--

CREATE TABLE `category_item` (
  `part_id` int NOT NULL,
  `category_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `category_item`
--

INSERT INTO `category_item` (`part_id`, `category_id`) VALUES
(1, 2),
(2, 1),
(3, 3),
(4, 4),
(5, 5),
(6, 6),
(7, 8),
(8, 7),
(9, 1);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `telephone` int DEFAULT NULL,
  `address_id` int NOT NULL,
  `password` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `username`, `full_name`, `email`, `telephone`, `address_id`, `password`) VALUES
(1, 'randy123', 'Randy Newton', 'randy.newton@gmail.com', 123456789, 1, '$2y$10$Pmxc8IgrO8kCaZjvB8Zu1er.bXVu//Vu4.ff.sJn4GTXs4vwuU7PO'),
(2, 'marcobag', 'Marco Bagetti', 'marco.bagetti@gmail.com', 321465978, 3, '$2y$10$4692Oqdmcud1Gjc.NiC/fOnipgyBDlm6vSrgNb4Te3tgRuPSW2Buu');

-- --------------------------------------------------------

--
-- Table structure for table `manufacturer`
--

CREATE TABLE `manufacturer` (
  `id` int NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `manufacturer`
--

INSERT INTO `manufacturer` (`id`, `name`, `country`) VALUES
(1, 'Dana Incorporated', 'USA'),
(2, 'Lear Corporation', 'USA'),
(3, 'Visteon Corporation', 'USA'),
(4, 'The Goodyaar Tire & Rubber Company', 'USA'),
(5, 'Accuride Corporation', 'USA'),
(6, 'Robert Bosch GmbH', 'Germany'),
(7, 'Continental AG', 'Germany'),
(8, 'Faurecia', 'France');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int NOT NULL,
  `customer_id` int NOT NULL,
  `status` enum('awaiting_payment','in_progress','shipping','finished') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_id`, `status`, `created_at`) VALUES
(1, 1, 'in_progress', '2021-11-13 17:38:51'),
(2, 2, 'shipping', '2021-11-13 17:38:51');

-- --------------------------------------------------------

--
-- Table structure for table `order_item`
--

CREATE TABLE `order_item` (
  `order_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `order_item`
--

INSERT INTO `order_item` (`order_id`, `product_id`, `quantity`) VALUES
(1, 1, 4),
(2, 3, 2),
(2, 2, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`address_id`),
  ADD KEY `Address_index_1` (`country`,`postcode`);

--
-- Indexes for table `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Cars_index_7` (`make`,`model`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD KEY `part_id` (`part_id`);

--
-- Indexes for table `car_parts`
--
ALTER TABLE `car_parts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `manufacturer_id` (`manufacturer_id`),
  ADD KEY `car_id` (`car_id`),
  ADD KEY `Car_parts_index_4` (`name`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Category_index_6` (`name`);

--
-- Indexes for table `category_item`
--
ALTER TABLE `category_item`
  ADD KEY `category_id` (`category_id`),
  ADD KEY `Category_item_index_8` (`part_id`,`category_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `address_id` (`address_id`),
  ADD KEY `Customers_index_0` (`username`,`full_name`);

--
-- Indexes for table `manufacturer`
--
ALTER TABLE `manufacturer`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Manufacturer_index_5` (`name`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Orders_index_2` (`id`),
  ADD KEY `Orders_index_3` (`customer_id`);

--
-- Indexes for table `order_item`
--
ALTER TABLE `order_item`
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `address`
--
ALTER TABLE `address`
  MODIFY `address_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `cars`
--
ALTER TABLE `cars`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `car_parts`
--
ALTER TABLE `car_parts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `manufacturer`
--
ALTER TABLE `manufacturer`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `part_id_constraint` FOREIGN KEY (`part_id`) REFERENCES `car_parts` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `car_parts`
--
ALTER TABLE `car_parts`
  ADD CONSTRAINT `car_parts_ibfk_1` FOREIGN KEY (`manufacturer_id`) REFERENCES `manufacturer` (`id`),
  ADD CONSTRAINT `car_parts_ibfk_2` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`);

--
-- Constraints for table `category_item`
--
ALTER TABLE `category_item`
  ADD CONSTRAINT `category_item_ibfk_1` FOREIGN KEY (`part_id`) REFERENCES `car_parts` (`id`),
  ADD CONSTRAINT `category_item_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`);

--
-- Constraints for table `customers`
--
ALTER TABLE `customers`
  ADD CONSTRAINT `customers_ibfk_1` FOREIGN KEY (`address_id`) REFERENCES `address` (`address_id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`);

--
-- Constraints for table `order_item`
--
ALTER TABLE `order_item`
  ADD CONSTRAINT `order_item_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_item_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `car_parts` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
