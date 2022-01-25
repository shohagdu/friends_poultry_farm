-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 18, 2021 at 09:11 PM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 7.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sk_fashion_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `all_settings_info`
--

CREATE TABLE `all_settings_info` (
  `id` int(11) UNSIGNED NOT NULL,
  `type` mediumint(6) UNSIGNED DEFAULT NULL COMMENT '1=Product Setup, 2= Band Setup, 3= Source, 4= Product Type, 5= Unit',
  `title` varchar(300) DEFAULT NULL,
  `is_active` tinyint(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT '0 = Delete, 1 = Active, 2 = Inactive  ',
  `created_by` int(11) UNSIGNED DEFAULT NULL,
  `created_time` varchar(15) DEFAULT NULL,
  `created_ip` varchar(15) DEFAULT NULL,
  `updated_by` int(11) UNSIGNED DEFAULT NULL,
  `updated_time` datetime DEFAULT NULL,
  `updated_ip` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `all_settings_info`
--

INSERT INTO `all_settings_info` (`id`, `type`, `title`, `is_active`, `created_by`, `created_time`, `created_ip`, `updated_by`, `updated_time`, `updated_ip`) VALUES
(1, 6, 'Pieces', 1, 7, '2020-06-26 15:2', '0', 7, '2021-08-18 22:55:36', '::1'),
(2, 6, 'N/A', 1, 7, '2020-06-26 19:4', '::1', 1, '2021-07-18 22:42:42', '175.176.33.162'),
(6, 2, 'Brand 1', 1, 7, '2020-06-26 21:0', '::1', 7, '2021-08-18 22:53:16', '::1'),
(8, 3, 'BD', 1, 7, '2020-06-26 22:2', '::1', 1, '2021-07-18 22:11:47', '175.176.33.162'),
(9, 3, 'PH', 1, 7, '2020-06-26 22:2', '::1', 7, '2020-06-28 20:13:54', '::1'),
(10, 4, 'Boys', 1, 7, '2020-06-26 22:2', '::1', 7, '2021-08-18 22:54:53', '::1'),
(11, 4, 'Girl', 1, 7, '2020-06-26 22:3', '::1', 7, '2021-08-18 22:55:05', '::1'),
(12, 2, 'Zara', 1, 7, '2020-06-27 12:0', '::1', 7, '2020-06-28 20:10:54', '::1'),
(15, 2, 'Band 2', 1, 7, '2020-06-28 20:1', '::1', 7, '2021-08-18 22:54:31', '::1'),
(16, 2, 'Reebok', 1, 7, '2020-06-28 20:1', '::1', NULL, NULL, NULL),
(17, 2, 'Levis', 1, 7, '2020-06-28 20:1', '::1', NULL, NULL, NULL),
(18, 2, 'Lee', 1, 1, '2020-08-16 20:0', '180.191.157.77', 1, '2021-07-18 22:16:09', '175.176.33.162'),
(20, 4, 'Free Size', 1, 1, '2021-02-11 12:5', '180.191.157.61', 7, '2021-08-18 22:55:18', '::1'),
(21, 6, 'Dorzon', 1, 1, '2021-02-11 12:5', '180.191.157.61', 7, '2021-08-18 22:55:46', '::1'),
(22, 3, 'N/A', 1, 1, '2021-02-11 12:5', '180.191.157.61', 7, '2021-08-18 22:56:39', '::1');

-- --------------------------------------------------------

--
-- Table structure for table `app_config`
--

CREATE TABLE `app_config` (
  `id` int(11) NOT NULL,
  `company_info` varchar(1000) CHARACTER SET utf8 NOT NULL,
  `contactPerson` varchar(55) CHARACTER SET utf8 DEFAULT NULL,
  `address` varchar(255) CHARACTER SET utf8 NOT NULL,
  `contactNo` varchar(111) CHARACTER SET utf8 DEFAULT NULL,
  `is_sms_costing` tinyint(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT '1 = continue sms costing, 0 = not continue  ',
  `sms_costing` decimal(10,2) DEFAULT NULL,
  `updated_by` int(11) UNSIGNED DEFAULT NULL,
  `updated_time` datetime DEFAULT NULL,
  `updated_ip` varchar(15) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `app_config`
--

INSERT INTO `app_config` (`id`, `company_info`, `contactPerson`, `address`, `contactNo`, `is_sms_costing`, `sms_costing`, `updated_by`, `updated_time`, `updated_ip`) VALUES
(6, 'MOTU PATLU KIDS ZONE', 'Tuhin', 'Feni Shishu Niketon, Trunk Road, Feni', '01819805231', 1, '0.00', 7, '2021-08-18 23:01:13', '::1');

-- --------------------------------------------------------

--
-- Table structure for table `customer_shipment_member_info`
--

CREATE TABLE `customer_shipment_member_info` (
  `id` int(11) NOT NULL,
  `type` tinyint(1) UNSIGNED DEFAULT NULL COMMENT '1= Sales customer, 2=Shipment Customer',
  `outlet_id` int(11) UNSIGNED DEFAULT NULL,
  `name` varchar(300) DEFAULT NULL,
  `mobile` varchar(50) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `is_active` tinyint(4) DEFAULT NULL COMMENT '0=delete, 1=active, 2=inactive',
  `remarks` text DEFAULT NULL,
  `created_time` timestamp NULL DEFAULT NULL,
  `created_by` int(11) UNSIGNED DEFAULT NULL,
  `created_ip` varchar(15) DEFAULT NULL,
  `updated_by` int(11) UNSIGNED DEFAULT NULL,
  `updated_time` timestamp NULL DEFAULT NULL,
  `updated_ip` varchar(15) DEFAULT NULL,
  `opening_due` decimal(10,0) DEFAULT NULL,
  `opening_stock_qty` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `outlet_setup`
--

CREATE TABLE `outlet_setup` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(300) DEFAULT NULL,
  `mobile` varchar(50) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `parent_id` int(11) UNSIGNED DEFAULT NULL COMMENT '0 = Main Branch, Other Wise Outlet',
  `is_active` tinyint(1) UNSIGNED DEFAULT NULL COMMENT '0 = Delete, 1 = Active, 2 = Inactive',
  `created_by` int(11) UNSIGNED DEFAULT NULL,
  `created_time` datetime DEFAULT NULL,
  `created_ip` varchar(15) DEFAULT NULL,
  `updated_by` int(11) UNSIGNED DEFAULT NULL,
  `updated_time` datetime DEFAULT NULL,
  `updated_ip` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `outlet_setup`
--

INSERT INTO `outlet_setup` (`id`, `name`, `mobile`, `email`, `address`, `parent_id`, `is_active`, `created_by`, `created_time`, `created_ip`, `updated_by`, `updated_time`, `updated_ip`) VALUES
(1, 'Main Outlet', '01839707645', 'main@gmail.com', 'Feni', 0, 1, NULL, NULL, NULL, 7, '2021-08-18 22:50:48', '::1');

-- --------------------------------------------------------

--
-- Table structure for table `product_info`
--

CREATE TABLE `product_info` (
  `id` int(11) NOT NULL,
  `name` varchar(300) DEFAULT NULL,
  `productCode` varchar(50) DEFAULT NULL,
  `band_id` int(11) DEFAULT NULL,
  `source_id` int(11) UNSIGNED DEFAULT NULL,
  `product_type` int(11) UNSIGNED DEFAULT NULL,
  `unit_id` int(11) UNSIGNED DEFAULT NULL,
  `unit_sale_price` decimal(10,2) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL COMMENT '0= Delete, 1 = Active, 2 = Inactive ',
  `created_by` int(11) UNSIGNED DEFAULT NULL,
  `created_time` datetime DEFAULT NULL,
  `created_ip` varchar(15) DEFAULT NULL,
  `updated_by` int(11) UNSIGNED DEFAULT NULL,
  `updated_time` datetime DEFAULT NULL,
  `updated_ip` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product_info`
--

INSERT INTO `product_info` (`id`, `name`, `productCode`, `band_id`, `source_id`, `product_type`, `unit_id`, `unit_sale_price`, `is_active`, `created_by`, `created_time`, `created_ip`, `updated_by`, `updated_time`, `updated_ip`) VALUES
(1, 'MTS', '0001', 7, 9, 11, 1, '222.00', 0, NULL, NULL, NULL, 7, '2020-07-02 10:13:02', '::1'),
(2, 'LTS', '0002', 15, 9, 10, 1, '12.00', 0, 7, '2020-06-27 11:26:28', '::1', 7, '2020-06-30 01:25:05', '::1'),
(3, 'Boys T S', '0004', 13, 9, 11, 1, '150.00', 0, 7, '2020-06-27 11:30:32', '::1', 7, '2020-06-30 01:25:14', '::1'),
(4, 'L.Short', '0003', 16, 8, 11, 1, '150.00', 0, 7, '2020-06-27 11:31:48', '::1', 7, '2020-06-30 01:24:54', '::1'),
(5, 'Mts', 'sk1', 14, 8, 11, 1, '110.00', 0, 1, '2020-07-29 17:35:42', '180.191.155.126', NULL, NULL, NULL),
(6, 'Mts', 'sk0001', 15, 8, 11, 1, '100.00', 0, 1, '2020-08-16 20:05:44', '180.191.157.77', NULL, NULL, NULL),
(7, 'mts', 'sk0002', 18, 8, 11, 1, '100.00', 0, 1, '2020-08-16 20:07:29', '180.191.157.77', NULL, NULL, NULL),
(8, 'Boy T-shirt', '0001', 6, 9, 11, 1, '100.00', 1, 7, '2021-02-11 21:15:59', '103.205.71.20', 7, '2021-08-19 01:06:02', '::1'),
(9, 'বেবী জিন্স', '0002', 18, 9, 11, 21, '100.00', 1, 7, '2021-02-11 21:17:29', '103.205.71.20', 7, '2021-08-19 01:05:23', '::1'),
(10, 'বয়েজ সার্ট', '0003', 17, 9, 20, 21, '100.00', 1, 7, '2021-02-11 21:17:53', '103.205.71.20', 7, '2021-08-19 01:05:39', '::1'),
(11, 'প্যান্ট', '0004', 15, 9, 20, 21, '100.00', 1, 7, '2021-02-11 21:18:21', '103.205.71.20', 7, '2021-08-19 01:05:48', '::1');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_info_stock_in`
--

CREATE TABLE `purchase_info_stock_in` (
  `id` int(11) UNSIGNED NOT NULL,
  `purchase_id` varchar(30) DEFAULT NULL,
  `supplier_id` int(11) UNSIGNED DEFAULT NULL,
  `outlet_id` int(11) UNSIGNED DEFAULT NULL,
  `purchase_date` date DEFAULT NULL,
  `note` text DEFAULT NULL,
  `is_active` tinyint(1) UNSIGNED DEFAULT 1,
  `created_by` int(11) UNSIGNED DEFAULT NULL,
  `created_time` datetime DEFAULT NULL,
  `created_ip` varchar(15) DEFAULT NULL,
  `updated_by` int(11) UNSIGNED DEFAULT NULL,
  `updated_time` datetime DEFAULT NULL,
  `updated_ip` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sales_info`
--

CREATE TABLE `sales_info` (
  `id` int(10) UNSIGNED NOT NULL,
  `sales_date` date DEFAULT NULL,
  `outletID` int(11) UNSIGNED DEFAULT NULL,
  `invoice_no` varchar(50) DEFAULT NULL,
  `customer_id` int(11) UNSIGNED DEFAULT NULL,
  `type` tinyint(3) UNSIGNED DEFAULT NULL COMMENT '1=Sales, 2=Transfer',
  `sub_total` decimal(10,2) DEFAULT NULL,
  `discount_type` tinyint(4) DEFAULT NULL,
  `discount_percent` decimal(10,2) DEFAULT NULL,
  `discount` decimal(10,2) DEFAULT NULL,
  `net_total` decimal(10,2) DEFAULT NULL,
  `payment_by` text DEFAULT NULL,
  `payment_amount` decimal(10,2) DEFAULT NULL,
  `current_due_amt` decimal(10,2) DEFAULT NULL,
  `previous_due` decimal(10,2) DEFAULT NULL,
  `total_due` decimal(10,2) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1 COMMENT '0=delete, 1=active, 2=inactive',
  `created_by` int(11) UNSIGNED DEFAULT NULL,
  `created_time` datetime DEFAULT NULL,
  `created_ip` varchar(15) DEFAULT NULL,
  `updated_by` int(11) UNSIGNED DEFAULT NULL,
  `updated_time` datetime DEFAULT NULL,
  `updated_ip` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `shipment_record`
--

CREATE TABLE `shipment_record` (
  `id` int(11) NOT NULL,
  `title` varchar(300) DEFAULT NULL,
  `arrival_dt` date DEFAULT NULL,
  `receive_dt` date DEFAULT NULL,
  `details` text DEFAULT NULL,
  `is_active` tinyint(4) DEFAULT NULL COMMENT '0=delete, 1=active, 2=inactive',
  `created_by` int(11) UNSIGNED DEFAULT NULL,
  `created_time` datetime DEFAULT NULL,
  `created_ip` varchar(15) DEFAULT NULL,
  `updated_by` int(11) UNSIGNED DEFAULT NULL,
  `updated_time` datetime DEFAULT NULL,
  `updated_ip` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `shipment_stock_details`
--

CREATE TABLE `shipment_stock_details` (
  `id` int(11) NOT NULL,
  `member_id` int(11) UNSIGNED DEFAULT NULL,
  `shipment_id` int(11) UNSIGNED DEFAULT NULL,
  `payment_by` text DEFAULT NULL,
  `trans_date` date DEFAULT NULL,
  `type` tinyint(1) DEFAULT NULL COMMENT '1=add, 2=Out, 3=payment',
  `debit_qty` int(11) UNSIGNED DEFAULT NULL,
  `credit_qty` int(11) UNSIGNED DEFAULT NULL,
  `unit_price` decimal(10,2) DEFAULT NULL,
  `sub_total` decimal(10,2) DEFAULT NULL,
  `discount` decimal(10,2) DEFAULT NULL,
  `debit_amount` decimal(10,2) DEFAULT NULL COMMENT 'Total Billing Amt',
  `credit_amount` decimal(10,2) DEFAULT NULL COMMENT 'Payment Amt',
  `is_active` tinyint(1) DEFAULT 1,
  `remarks` text DEFAULT NULL,
  `created_by` int(11) UNSIGNED DEFAULT NULL,
  `created_time` datetime DEFAULT NULL,
  `created_ip` varchar(15) DEFAULT NULL,
  `updated_by` int(11) UNSIGNED DEFAULT NULL,
  `updated_time` datetime DEFAULT NULL,
  `updated_ip` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `shipment_stock_info`
--

CREATE TABLE `shipment_stock_info` (
  `id` int(11) NOT NULL,
  `shipment_id` int(11) UNSIGNED DEFAULT NULL,
  `destibute_dt` date DEFAULT NULL,
  `note` text DEFAULT NULL,
  `total_qty` int(11) UNSIGNED DEFAULT NULL,
  `shipment_sub_total` decimal(10,2) DEFAULT NULL,
  `shipment_discount` decimal(10,2) DEFAULT NULL,
  `shipment_net_total` decimal(10,2) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL COMMENT '0=delete, 1=active, 2=inactive',
  `created_by` int(11) UNSIGNED DEFAULT NULL,
  `created_time` datetime DEFAULT NULL,
  `created_ip` varchar(15) DEFAULT NULL,
  `updated_by` int(11) UNSIGNED DEFAULT NULL,
  `updated_time` datetime DEFAULT NULL,
  `updated_ip` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `stock_info`
--

CREATE TABLE `stock_info` (
  `id` int(11) UNSIGNED NOT NULL,
  `product_id` int(11) UNSIGNED DEFAULT NULL,
  `sales_id` int(11) UNSIGNED DEFAULT NULL COMMENT '#sales_info TBL',
  `purchase_id` int(11) UNSIGNED DEFAULT NULL,
  `transfer_id` int(11) UNSIGNED DEFAULT NULL,
  `stock_type` tinyint(1) UNSIGNED DEFAULT NULL COMMENT '1= Purchase(+), 2= Sales(-), 3= Transfer, 6= Opening Stock',
  `total_item` int(11) UNSIGNED DEFAULT NULL,
  `unit_price` decimal(10,2) DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `debit_outlet` int(11) UNSIGNED DEFAULT NULL COMMENT 'when IN Exp (Purchase,Transfer IN, Opening Stock)',
  `credit_outlet` int(11) UNSIGNED DEFAULT NULL COMMENT 'when out Exp (Sales,Transfer Out)',
  `is_active` tinyint(1) UNSIGNED DEFAULT 1 COMMENT '0= delete, 1= active, 2=Inactive',
  `created_by` int(11) UNSIGNED DEFAULT NULL,
  `created_time` datetime DEFAULT NULL,
  `created_ip` varchar(15) DEFAULT NULL,
  `updated_by` int(11) UNSIGNED DEFAULT NULL,
  `updated_time` datetime DEFAULT NULL,
  `updated_ip` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pos_users`
--

CREATE TABLE `tbl_pos_users` (
  `userID` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(55) NOT NULL,
  `email` varchar(100) NOT NULL,
  `roleID` int(11) NOT NULL COMMENT '1=super admin,2=manager, 3=salesman, 4=waiter, 5=cooker',
  `outlet_id` int(11) UNSIGNED DEFAULT NULL,
  `created_by` int(11) UNSIGNED DEFAULT NULL,
  `created_time` datetime DEFAULT NULL,
  `created_ip` varchar(15) DEFAULT NULL,
  `updated_by` int(11) UNSIGNED DEFAULT NULL,
  `updated_time` datetime DEFAULT NULL,
  `updated_ip` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_pos_users`
--

INSERT INTO `tbl_pos_users` (`userID`, `username`, `password`, `email`, `roleID`, `outlet_id`, `created_by`, `created_time`, `created_ip`, `updated_by`, `updated_time`, `updated_ip`) VALUES
(1, 'Owner', '4d3f808dcd73cba7760df2105672ad4c', 'ronty311280@pos.com', 1, 1, 7, '2020-07-10 18:34:59', '::1', 1, '2020-11-14 13:06:36', '180.191.158.39'),
(7, 'superadmin', 'e10adc3949ba59abbe56e057f20f883e', 'skadmin@gmail.com', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `transaction_info`
--

CREATE TABLE `transaction_info` (
  `id` int(11) UNSIGNED NOT NULL,
  `customer_member_id` int(11) UNSIGNED DEFAULT NULL,
  `sales_id` int(11) UNSIGNED DEFAULT NULL,
  `payment_id` int(11) UNSIGNED DEFAULT NULL,
  `payment_by` text DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `type` tinyint(1) UNSIGNED DEFAULT NULL COMMENT '1=Sales Total Amt, 2= when sales then payment, 3=due collection',
  `outletID` int(11) UNSIGNED DEFAULT NULL,
  `debit_amount` decimal(10,2) DEFAULT NULL COMMENT 'Total Biling Amount',
  `credit_amount` decimal(10,2) DEFAULT NULL COMMENT 'Total Payment Amount',
  `is_active` tinyint(1) UNSIGNED DEFAULT 1,
  `remarks` text DEFAULT NULL,
  `created_by` int(11) UNSIGNED DEFAULT NULL,
  `created_time` datetime DEFAULT NULL,
  `created_ip` varchar(15) DEFAULT NULL,
  `updated_by` int(11) UNSIGNED DEFAULT NULL,
  `updated_time` datetime DEFAULT NULL,
  `updated_ip` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `transfer_info`
--

CREATE TABLE `transfer_info` (
  `id` int(11) UNSIGNED NOT NULL,
  `transfer_id` varchar(30) DEFAULT NULL,
  `from_outlet_id` int(11) UNSIGNED DEFAULT NULL,
  `to_outlet_id` int(11) UNSIGNED DEFAULT NULL,
  `transfer_date` date DEFAULT NULL,
  `note` text DEFAULT NULL,
  `is_active` tinyint(1) UNSIGNED DEFAULT 1 COMMENT '0 = delete, 1= active, 2=inactive',
  `created_by` int(11) UNSIGNED DEFAULT NULL,
  `created_time` datetime DEFAULT NULL,
  `created_ip` varchar(15) DEFAULT NULL,
  `updated_by` int(11) UNSIGNED DEFAULT NULL,
  `updated_time` datetime DEFAULT NULL,
  `updated_ip` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `all_settings_info`
--
ALTER TABLE `all_settings_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_config`
--
ALTER TABLE `app_config`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_shipment_member_info`
--
ALTER TABLE `customer_shipment_member_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `outlet_setup`
--
ALTER TABLE `outlet_setup`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_info`
--
ALTER TABLE `product_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_info_stock_in`
--
ALTER TABLE `purchase_info_stock_in`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales_info`
--
ALTER TABLE `sales_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shipment_record`
--
ALTER TABLE `shipment_record`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shipment_stock_details`
--
ALTER TABLE `shipment_stock_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shipment_stock_info`
--
ALTER TABLE `shipment_stock_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stock_info`
--
ALTER TABLE `stock_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_pos_users`
--
ALTER TABLE `tbl_pos_users`
  ADD PRIMARY KEY (`userID`);

--
-- Indexes for table `transaction_info`
--
ALTER TABLE `transaction_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transfer_info`
--
ALTER TABLE `transfer_info`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `all_settings_info`
--
ALTER TABLE `all_settings_info`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `app_config`
--
ALTER TABLE `app_config`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `customer_shipment_member_info`
--
ALTER TABLE `customer_shipment_member_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `outlet_setup`
--
ALTER TABLE `outlet_setup`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `product_info`
--
ALTER TABLE `product_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `purchase_info_stock_in`
--
ALTER TABLE `purchase_info_stock_in`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sales_info`
--
ALTER TABLE `sales_info`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shipment_record`
--
ALTER TABLE `shipment_record`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shipment_stock_details`
--
ALTER TABLE `shipment_stock_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shipment_stock_info`
--
ALTER TABLE `shipment_stock_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stock_info`
--
ALTER TABLE `stock_info`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_pos_users`
--
ALTER TABLE `tbl_pos_users`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `transaction_info`
--
ALTER TABLE `transaction_info`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transfer_info`
--
ALTER TABLE `transfer_info`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
