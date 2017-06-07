--
-- Table structure for table `units`
--

CREATE TABLE `units` (
`id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT,
`title` varchar(100) NOT NULL,
`desc` text,
`meta` text,
`createdate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
`datemodified` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
PRIMARY KEY (`id`),
UNIQUE KEY `unique_title` (`title`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `transactionitems` (
`id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
`title` varchar(100) NOT NULL,
`caller` varchar(100) NOT NULL,
`unit_id` smallint(5) UNSIGNED NOT NULL,
`type` enum('real','gift','prize','transfer') NOT NULL,
`minus` double UNSIGNED DEFAULT NULL,
`plus` double UNSIGNED DEFAULT NULL,
`autoverify` enum('yes','no') NOT NULL DEFAULT 'no',
`forcechange` enum('yes','no') NOT NULL DEFAULT 'no',
`desc` text,
`meta` text,
`status` enum('enable','disable','deleted','expired','awaiting','filtered','blocked','spam') NOT NULL,
`count` int(10) UNSIGNED NOT NULL DEFAULT '0',
`createdate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
`enddate` datetime DEFAULT NULL,
`date_modified` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
PRIMARY KEY (`id`),
UNIQUE KEY `unique_caller` (`caller`) USING BTREE,
CONSTRAINT `transactionitems_units_id` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `exchangerates` (
`id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
`from` smallint(5) UNSIGNED NOT NULL,
`to` smallint(5) UNSIGNED NOT NULL,
`rate` double NOT NULL,
`roundtype` enum('up','down','round') DEFAULT NULL,
`round` double DEFAULT NULL,
`wagestatic` double DEFAULT NULL,
`wage` double DEFAULT NULL,
`status` enum('enable','disable','deleted','expired','awaiting','filtered','blocked','spam') NOT NULL,
`desc` text,
`meta` text,
`createdate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
`enddate` datetime DEFAULT NULL,
`datemodified` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
PRIMARY KEY (`id`),
CONSTRAINT `exchangerates_units_id_from` FOREIGN KEY (`from`) REFERENCES `units` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
CONSTRAINT `exchangerates_units_id_to` FOREIGN KEY (`to`) REFERENCES `units` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
`id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
`title` varchar(100) NOT NULL,
`transactionitem_id` int(10) UNSIGNED NOT NULL,
`exchangerate_id` int(10) UNSIGNED DEFAULT NULL,
`user_id` int(10) UNSIGNED NOT NULL,
`post_id` bigint(20) UNSIGNED DEFAULT NULL,
`related_user_id` int(10) UNSIGNED DEFAULT NULL,
`type` enum('real','gift','prize','transfer') NOT NULL,
`unit_id` smallint(5) UNSIGNED NOT NULL,
`plus` double DEFAULT NULL,
`minus` double DEFAULT NULL,
`budgetbefore` double DEFAULT NULL,
`budget` double DEFAULT NULL,
`status` enum('enable','disable','deleted','expired','awaiting','filtered','blocked','spam') NOT NULL,
`meta` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
`desc` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
`parent_id` bigint(20) UNSIGNED DEFAULT NULL,
`finished` enum('yes','no') NOT NULL DEFAULT 'no',
`createdate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
`datemodified` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
PRIMARY KEY (`id`),
CONSTRAINT `transactions_exchangerate_id` FOREIGN KEY (`exchangerate_id`) REFERENCES `exchangerates` (`id`) ON UPDATE CASCADE,
CONSTRAINT `transactions_transactionitem_id` FOREIGN KEY (`transactionitem_id`) REFERENCES `transactionitems` (`id`) ON UPDATE CASCADE,
CONSTRAINT `transactions_transactions_id_parent` FOREIGN KEY (`parent_id`) REFERENCES `transactions` (`id`) ON UPDATE CASCADE,
CONSTRAINT `transactions_units_id` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`) ON UPDATE CASCADE,
CONSTRAINT `transactions_user_id_related` FOREIGN KEY (`related_user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE,
CONSTRAINT `transactions_users_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

