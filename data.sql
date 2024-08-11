-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 11, 2024 at 06:25 PM
-- Server version: 10.3.15-MariaDB
-- PHP Version: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `restoranku`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `pkey` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`pkey`, `name`) VALUES
(1, 'Makanan'),
(2, 'Minuman'),
(3, 'Rawdaw');

-- --------------------------------------------------------

--
-- Table structure for table `dining_table`
--

CREATE TABLE `dining_table` (
  `pkey` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dining_table`
--

INSERT INTO `dining_table` (`pkey`, `name`) VALUES
(1, 'MEJA NO 1'),
(2, 'MEJA NO 2'),
(3, 'MEJA NO 3');

-- --------------------------------------------------------

--
-- Table structure for table `order_detail`
--

CREATE TABLE `order_detail` (
  `pkey` int(11) NOT NULL,
  `refkey` int(11) NOT NULL,
  `qty` decimal(20,7) NOT NULL,
  `productkey` int(11) NOT NULL,
  `promokey` int(11) NOT NULL,
  `price` decimal(20,7) NOT NULL,
  `amount` decimal(20,7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_detail`
--

INSERT INTO `order_detail` (`pkey`, `refkey`, `qty`, `productkey`, `promokey`, `price`, `amount`) VALUES
(692, 220, '1.0000000', 1, 0, '12000.0000000', '12000.0000000'),
(693, 220, '1.0000000', 6, 0, '6000.0000000', '6000.0000000'),
(694, 220, '1.0000000', 3, 0, '8000.0000000', '8000.0000000'),
(695, 220, '1.0000000', 8, 0, '15000.0000000', '15000.0000000');

-- --------------------------------------------------------

--
-- Table structure for table `order_promo_detail`
--

CREATE TABLE `order_promo_detail` (
  `pkey` int(11) NOT NULL,
  `refkey` int(11) NOT NULL,
  `qty` decimal(20,7) NOT NULL,
  `promokey` int(11) NOT NULL,
  `price` decimal(20,7) NOT NULL,
  `amount` decimal(20,7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_promo_detail`
--

INSERT INTO `order_promo_detail` (`pkey`, `refkey`, `qty`, `promokey`, `price`, `amount`) VALUES
(45, 220, '2.0000000', 1, '23000.0000000', '46000.0000000');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `pkey` int(11) NOT NULL,
  `categorykey` int(11) NOT NULL,
  `name` varchar(225) NOT NULL,
  `price` decimal(20,7) NOT NULL,
  `variantkey` int(11) NOT NULL,
  `printerkey` int(11) NOT NULL,
  `statuskey` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`pkey`, `categorykey`, `name`, `price`, `variantkey`, `printerkey`, `statuskey`) VALUES
(1, 2, 'Jeruk Dingin', '12000.0000000', 1, 3, 1),
(2, 2, 'Jeruk Hangat', '10000.0000000', 2, 3, 1),
(3, 2, 'Teh Manis', '8000.0000000', 3, 3, 1),
(4, 2, 'Teh Tawar', '5000.0000000', 4, 3, 1),
(5, 2, 'Kopi Dingin', '8000.0000000', 1, 3, 1),
(6, 2, 'Kopi Panas', '6000.0000000', 2, 3, 1),
(7, 2, 'Extra Es Batu', '2000.0000000', 1, 3, 1),
(8, 1, 'Mie Goreng', '15000.0000000', 5, 2, 1),
(9, 1, 'Mie Kuah', '15000.0000000', 6, 2, 1),
(11, 1, 'Nasi Goreng', '15000.0000000', 5, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `promo`
--

CREATE TABLE `promo` (
  `pkey` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(20,7) NOT NULL,
  `statuskey` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `promo`
--

INSERT INTO `promo` (`pkey`, `name`, `price`, `statuskey`) VALUES
(1, 'Promo nasi goreng + Jeruk Dingin', '23000.0000000', 1);

-- --------------------------------------------------------

--
-- Table structure for table `promo_detail`
--

CREATE TABLE `promo_detail` (
  `pkey` int(11) NOT NULL,
  `refkey` int(11) NOT NULL,
  `productkey` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `promo_detail`
--

INSERT INTO `promo_detail` (`pkey`, `refkey`, `productkey`) VALUES
(1, 1, 1),
(2, 1, 11);

-- --------------------------------------------------------

--
-- Table structure for table `sales_order`
--

CREATE TABLE `sales_order` (
  `pkey` int(11) NOT NULL,
  `tablekey` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sales_order`
--

INSERT INTO `sales_order` (`pkey`, `tablekey`) VALUES
(220, 1);

-- --------------------------------------------------------

--
-- Table structure for table `station_printer`
--

CREATE TABLE `station_printer` (
  `pkey` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `station_printer`
--

INSERT INTO `station_printer` (`pkey`, `name`) VALUES
(1, 'Printer Kasir'),
(2, 'Printer Dapur'),
(3, 'Printer Bar');

-- --------------------------------------------------------

--
-- Table structure for table `variant`
--

CREATE TABLE `variant` (
  `pkey` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `variant`
--

INSERT INTO `variant` (`pkey`, `name`) VALUES
(1, 'Dingin'),
(2, 'Hangat'),
(3, 'Manis'),
(4, 'Tawar'),
(5, 'Goreng'),
(6, 'Kuah');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`pkey`);

--
-- Indexes for table `dining_table`
--
ALTER TABLE `dining_table`
  ADD PRIMARY KEY (`pkey`);

--
-- Indexes for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD PRIMARY KEY (`pkey`);

--
-- Indexes for table `order_promo_detail`
--
ALTER TABLE `order_promo_detail`
  ADD PRIMARY KEY (`pkey`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`pkey`);

--
-- Indexes for table `promo`
--
ALTER TABLE `promo`
  ADD PRIMARY KEY (`pkey`);

--
-- Indexes for table `promo_detail`
--
ALTER TABLE `promo_detail`
  ADD PRIMARY KEY (`pkey`);

--
-- Indexes for table `sales_order`
--
ALTER TABLE `sales_order`
  ADD PRIMARY KEY (`pkey`);

--
-- Indexes for table `station_printer`
--
ALTER TABLE `station_printer`
  ADD PRIMARY KEY (`pkey`);

--
-- Indexes for table `variant`
--
ALTER TABLE `variant`
  ADD PRIMARY KEY (`pkey`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `pkey` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `dining_table`
--
ALTER TABLE `dining_table`
  MODIFY `pkey` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `order_detail`
--
ALTER TABLE `order_detail`
  MODIFY `pkey` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=696;

--
-- AUTO_INCREMENT for table `order_promo_detail`
--
ALTER TABLE `order_promo_detail`
  MODIFY `pkey` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `pkey` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `promo`
--
ALTER TABLE `promo`
  MODIFY `pkey` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `promo_detail`
--
ALTER TABLE `promo_detail`
  MODIFY `pkey` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `sales_order`
--
ALTER TABLE `sales_order`
  MODIFY `pkey` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=221;

--
-- AUTO_INCREMENT for table `station_printer`
--
ALTER TABLE `station_printer`
  MODIFY `pkey` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `variant`
--
ALTER TABLE `variant`
  MODIFY `pkey` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
