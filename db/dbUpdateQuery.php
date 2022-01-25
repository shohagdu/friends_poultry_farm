<!---
ALTER TABLE `product_info` ADD `purchase_price` DECIMAL(10,2) NOT NULL AFTER `unit_sale_price`;
ALTER TABLE `product_info` CHANGE `is_active` `is_active` TINYINT(1) NULL DEFAULT '1' COMMENT '0= Delete, 1 = Active, 2 = Inactive ';
ALTER TABLE `stock_info` ADD `purchaseAmtForSales` DECIMAL(10,2) NULL DEFAULT NULL AFTER `total_price`;
-----------Updated

ALTER TABLE `stock_info` ADD `product_code` INT(11) UNSIGNED NULL DEFAULT NULL AFTER `updated_ip`;
UPDATE  `stock_info` SET `total_price`=`total_item`*`unit_price` ORDER BY id DESC LIMIT 1


UPDATE stock_info as T1   JOIN product_info as T2 ON T1.product_code = T2.productCode
  SET T1.product_id = T2.id
WHERE T1.product_code is NOT NULL

-----------Updated

UPDATE `product_info` SET `band_id`=15,`source_id`=22 ORDER BY id DESC
-----------Updated

SELECT LPAD(productCode, 4, 0) as newCode , productCode FROM product_info
ORDER BY id ASC
-----------Updated

30-10-2021

ALTER TABLE `tbl_pos_users` ADD `is_active` TINYINT NOT NULL DEFAULT '1' COMMENT '0= Delete, 1=Active, 2=Inactive' AFTER `outlet_id`;


CREATE TABLE `acl_menu_info` (
  `id` int(11) NOT NULL,
  `glyphicon_icon` varchar(200) DEFAULT NULL,
  `title` varchar(200) DEFAULT NULL,
  `link` varchar(500) DEFAULT NULL,
  `is_main_menu` tinyint(1) UNSIGNED DEFAULT NULL COMMENT '1=Yes, 2=No',
  `parent_id` int(11) UNSIGNED DEFAULT NULL COMMENT 'NULL=Main Menu, Otherwise Chil(Contains Parent)',
  `display_position` int(1) UNSIGNED DEFAULT NULL,
  `is_active` tinyint(3) UNSIGNED DEFAULT 1 COMMENT '0=delete, 1=active, 2=inactive',
  `created_by` int(11) UNSIGNED DEFAULT NULL,
  `created_time` datetime DEFAULT NULL,
  `created_ip` varchar(15) DEFAULT NULL,
  `updated_by` int(11) UNSIGNED DEFAULT NULL,
  `updated_time` datetime DEFAULT NULL,
  `updated_ip` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `acl_menu_info`
--

INSERT INTO `acl_menu_info` (`id`, `glyphicon_icon`, `title`, `link`, `is_main_menu`, `parent_id`, `display_position`, `is_active`, `created_by`, `created_time`, `created_ip`, `updated_by`, `updated_time`, `updated_ip`) VALUES
(1, 'fa fa-folder', 'Sales', '#', 1, NULL, 3, 1, 2, '2020-05-07 08:22:00', '127.0.0.1', 2, '2020-05-07 08:22:00', '127.0.0.1'),
(2, '', 'New Sales', 'pos/index', 2, 1, 1, 1, 2, '2020-05-07 08:22:01', '127.0.0.2', 3, '2020-05-07 08:22:01', '127.0.0.2'),
(3, '', 'List POS Sales', 'pos/salesList', 2, 1, 2, 1, 2, '2020-05-07 08:22:02', '127.0.0.3', 4, '2020-05-07 08:22:02', '127.0.0.3'),
(5, 'fa fa-folder', 'Purchases', '#', 1, NULL, 5, 1, 2, '2020-05-07 08:22:15', '127.0.0.16', 17, '2020-05-07 08:22:15', '127.0.0.16'),
(6, '', 'Add New ', 'purchases/create', 2, 5, 2, 1, 2, '2020-05-07 08:22:16', '127.0.0.17', 18, '2020-05-07 08:22:16', '127.0.0.17'),
(7, '', 'List', 'purchases/index', 2, 5, 2, 1, 2, '2020-05-07 08:22:17', '127.0.0.18', 19, '2020-05-07 08:22:17', '127.0.0.18'),
(15, 'fa fa-folder', 'Customer Info', '#', 1, NULL, 11, 1, 2, '2020-05-07 08:22:29', '127.0.0.30', 31, '2020-05-07 08:22:29', '127.0.0.30'),
(16, '', 'Customer Record', 'settings/customer_info', 2, 15, 1, 1, 2, '2020-05-07 08:22:30', '127.0.0.31', 32, '2020-05-07 08:22:30', '127.0.0.31'),
(17, '', 'Customer Due Collecton', 'settings/customer_due_collection', 2, 15, 2, 1, 2, '2020-05-07 08:22:31', '127.0.0.32', 33, '2020-05-07 08:22:31', '127.0.0.32'),
(52, 'fa fa-folder', 'Products', '#', 1, NULL, 16, 1, 2, '2020-05-07 08:22:52', '127.0.0.53', 54, '2020-05-07 08:22:52', '127.0.0.53'),
(54, '', 'Products Record', 'products/index', 2, 52, 1, 1, 2, '2020-05-07 08:22:54', '127.0.0.55', 56, '2020-05-07 08:22:54', '127.0.0.55'),
(55, '', 'Bar Code Print', 'products/printBarcodes', 2, 52, 2, 1, 2, '2020-05-07 08:22:54', '127.0.0.55', 56, '2020-05-07 08:22:54', '127.0.0.55'),
(56, 'fa fa-folder', 'Sales Report', '#', 2, 86, 16, 1, 2, '2020-05-07 08:22:52', '127.0.0.53', 54, '2020-05-07 08:22:52', '127.0.0.53'),
(57, '', 'Daily Sales', 'reports/dailySalesStatement', 3, 56, 1, 1, 2, '2020-05-07 08:22:53', '127.0.0.54', 55, '2020-05-07 08:22:53', '127.0.0.54'),
(58, '', 'Details  Sales', 'reports/salesReport', 3, 56, 2, 1, 2, '2020-05-07 08:22:54', '127.0.0.55', 56, '2020-05-07 08:22:54', '127.0.0.55'),
(59, 'fa fa-folder', 'Purchase Report', '#', 2, 86, 16, 1, 2, '2020-05-07 08:22:52', '127.0.0.53', 54, '2020-05-07 08:22:52', '127.0.0.53'),
(60, '', 'Date Wise Purchase Report', 'reports/dateWisePurchse', 3, 59, 1, 1, 2, '2020-05-07 08:22:53', '127.0.0.54', 55, '2020-05-07 08:22:53', '127.0.0.54'),
(63, 'fa fa-folder', 'Inventory', '#', 2, 86, 16, 1, 2, '2020-05-07 08:22:52', '127.0.0.53', 54, '2020-05-07 08:22:52', '127.0.0.53'),
(64, '', 'Inventory Report', 'reports/inventory_report', 3, 63, 1, 1, 2, '2020-05-07 08:22:53', '127.0.0.54', 55, '2020-05-07 08:22:53', '127.0.0.54'),
(70, 'fa fa-folder', 'Settings', '#', 1, NULL, 17, 1, 2, '2020-05-07 08:22:55', '127.0.0.56', 57, '2020-05-07 08:22:55', '127.0.0.56'),
(71, '', ' User Info', 'settings/listUser', 2, 70, 1, 1, 2, '2020-05-07 08:22:56', '127.0.0.57', 58, '2020-05-07 08:22:56', '127.0.0.57'),
(72, '', ' User Access', 'UserAccessRole', 2, 70, 2, 1, 2, '2020-05-07 08:22:57', '127.0.0.58', 59, '2020-05-07 08:22:57', '127.0.0.58'),
(73, '', 'Product Band', 'settings/productSource', 2, 70, 3, 1, 2, '2020-05-07 08:22:58', '127.0.0.59', 60, '2020-05-07 08:22:58', '127.0.0.59'),
(74, '', 'Product Type', 'settings/productType', 2, 70, 4, 1, 2, '2020-05-07 08:22:59', '127.0.0.60', 61, '2020-05-07 08:22:59', '127.0.0.60'),
(75, '', 'Product Unit', 'settings/productUnit', 2, 70, 5, 1, 2, '2020-05-07 08:22:59', '127.0.0.61', 62, '2020-05-07 08:22:59', '127.0.0.61'),
(76, '', 'Product Unit', 'settings/productUnit', 2, 70, 6, 1, 2, '2020-05-07 08:22:59', '127.0.0.62', 63, '2020-05-07 08:22:59', '127.0.0.62'),
(77, '', 'Shop Configuration', 'settings/PosConfigIndex', 2, 70, 7, 1, 2, '2020-05-07 08:22:59', '127.0.0.63', 64, '2020-05-07 08:22:59', '127.0.0.63'),
(81, 'fa fa-folder', 'Change Password', 'settings/profile', 1, NULL, 17, 1, 2, '2020-05-07 08:22:55', '127.0.0.56', 57, '2020-05-07 08:22:55', '127.0.0.56'),
(82, 'glyphicon glyphicon-off', 'Log Out', 'login/logOut', 1, NULL, 17, 1, 2, '2020-05-07 08:22:55', '127.0.0.56', 57, '2020-05-07 08:22:55', '127.0.0.56'),
(84, 'fa fa-folder', 'Dashboard', NULL, 1, NULL, 1, 1, 2, '2020-05-07 08:22:00', '127.0.0.1', 2, '2020-05-07 08:22:00', '127.0.0.1'),
(85, 'fa fa-folder', 'Dashboard 2', 'indexOthers', 1, NULL, 1, 0, 2, '2020-05-07 08:22:00', '127.0.0.1', 2, '2020-05-07 08:22:00', '127.0.0.1'),
(86, 'fa fa-folder', 'All Report', '#', 1, NULL, 16, 1, 2, '2020-05-07 08:22:00', '127.0.0.1', 2, '2020-05-07 08:22:00', '127.0.0.1'),
(187, 'fa fa-folder', 'Outlet', 'settings/outlet_info', 1, NULL, 17, 0, 2, '2020-05-07 08:22:00', '127.0.0.1', 2, '2020-05-07 08:22:00', '127.0.0.1');

-- --------------------------------------------------------

--
-- Table structure for table `acl_role_info`
--

CREATE TABLE `acl_role_info` (
  `id` int(11) NOT NULL,
  `role_name` varchar(150) DEFAULT NULL,
  `role_info` text DEFAULT NULL,
  `is_active` tinyint(1) UNSIGNED DEFAULT 1,
  `created_by` int(11) UNSIGNED DEFAULT NULL,
  `created_time` datetime DEFAULT NULL,
  `created_ip` varchar(15) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_time` datetime DEFAULT NULL,
  `updated_ip` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `acl_role_info`
--

INSERT INTO `acl_role_info` (`id`, `role_name`, `role_info`, `is_active`, `created_by`, `created_time`, `created_ip`, `updated_by`, `updated_time`, `updated_ip`) VALUES
(1, 'Admin', '{\"84\":\"on\",\"1\":{\"2\":\"on\",\"3\":\"on\"},\"5\":{\"6\":\"on\",\"7\":\"on\"},\"15\":{\"16\":\"on\",\"17\":\"on\"},\"52\":{\"54\":\"on\",\"55\":\"on\"},\"86\":{\"56\":{\"57\":\"on\",\"58\":\"on\"},\"59\":{\"60\":\"on\"},\"63\":{\"64\":\"on\"}},\"70\":{\"71\":\"on\",\"72\":\"on\",\"73\":\"on\",\"74\":\"on\",\"75\":\"on\",\"76\":\"on\",\"77\":\"on\"},\"81\":\"on\",\"82\":\"on\"}', 1, 2, '2020-07-09 10:33:39', '::1', NULL, '2021-10-30 01:02:49', '::1'),
(2, 'Manager', '{\"1\":{\"2\":\"on\",\"3\":\"on\"},\"81\":\"on\",\"82\":\"on\"}', 1, 2, '2020-07-09 11:09:35', '::1', NULL, '2021-10-30 01:08:08', '::1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `acl_menu_info`
--
ALTER TABLE `acl_menu_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `acl_role_info`
--
ALTER TABLE `acl_role_info`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `acl_menu_info`
--
ALTER TABLE `acl_menu_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=188;

--
-- AUTO_INCREMENT for table `acl_role_info`
--
ALTER TABLE `acl_role_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
======Updated


31-10-2021
ALTER TABLE `sales_info` ADD `remaining_due_make_discount` DECIMAL(10,2) NULL DEFAULT NULL AFTER `discount`;
====updated

31-10-2021
UPDATE `acl_menu_info` SET `title` = 'Daily Sales (Profit/Lose)' WHERE `acl_menu_info`.`id` = 57;
UPDATE `acl_menu_info` SET `title` = 'Detail Sales (Profit/Lose)' WHERE `acl_menu_info`.`id` = 58;

INSERT INTO `acl_menu_info` (`id`, `glyphicon_icon`, `title`, `link`, `is_main_menu`, `parent_id`, `display_position`, `is_active`, `created_by`, `created_time`, `created_ip`, `updated_by`, `updated_time`, `updated_ip`) VALUES (NULL, '', 'Daily Sales', 'reports/dailySalesReports', '3', '56', '3', '1', '2', '2020-05-07 08:22:54', '127.0.0.55', '56', '2020-05-07 08:22:54', '127.0.0.55');

INSERT INTO `acl_menu_info` (`id`, `glyphicon_icon`, `title`, `link`, `is_main_menu`, `parent_id`, `display_position`, `is_active`, `created_by`, `created_time`, `created_ip`, `updated_by`, `updated_time`, `updated_ip`) VALUES (NULL, '', 'Detail Sales', 'reports/detailsSalesReport', '3', '56', '4', '1', '2', '2020-05-07 08:22:54', '127.0.0.55', '56', '2020-05-07 08:22:54', '127.0.0.55');
