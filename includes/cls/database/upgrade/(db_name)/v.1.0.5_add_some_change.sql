ALTER TABLE `companies` CHANGE `status` `status` ENUM('enable','disable','expire','deleted') NOT NULL DEFAULT 'enable';

