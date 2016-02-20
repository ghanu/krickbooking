CREATE TABLE `customer` (
  `id_customer` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `gender` enum('female','male') DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_customer`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `booking_slot` (
  `id_booking_slot` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `slot_hours` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_booking_slot`),
  KEY `slot_hours_UNIQUE` (`slot_hours`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `booking_status` (
  `id_booking_status` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_booking_status`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS booking (
	`id_booking` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    `fk_customer` int(10) UNSIGNED NOT NULL,
    `fk_booking_slot` int(10) UNSIGNED NOT NULL,
    `fk_booking_status` int(10) UNSIGNED NOT NULL,
    `booking_date` date DEFAULT NULL,
	`created_at` datetime DEFAULT NULL,
	`updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY(id_booking),
	CONSTRAINT `customer_fk` FOREIGN KEY (`fk_customer`) REFERENCES `customer` (`id_customer`) ON DELETE CASCADE ON UPDATE CASCADE,
	CONSTRAINT `booking_slot_fk` FOREIGN KEY (`fk_booking_slot`) REFERENCES `booking_slot` (`id_booking_slot`) ON DELETE CASCADE ON UPDATE CASCADE,
	CONSTRAINT `booking_status_fk` FOREIGN KEY (`fk_booking_status`) REFERENCES `booking_status` (`id_booking_status`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



/**
Initial Data 
**/
INSERT IGNORE INTO booking_slot (`slot_hours`,`created_at`) VALUES ('5-6', now());
INSERT IGNORE INTO booking_slot (`slot_hours`,`created_at`) VALUES ('6-7', now());
INSERT IGNORE INTO booking_slot (`slot_hours`,`created_at`) VALUES ('7-8', now());
INSERT IGNORE INTO booking_slot (`slot_hours`,`created_at`) VALUES ('8-9', now());
INSERT IGNORE INTO booking_slot (`slot_hours`,`created_at`) VALUES ('9-10', now());
INSERT IGNORE INTO booking_slot (`slot_hours`,`created_at`) VALUES ('10-11', now());
INSERT IGNORE INTO booking_slot (`slot_hours`,`created_at`) VALUES ('11-12', now());
INSERT IGNORE INTO booking_slot (`slot_hours`,`created_at`) VALUES ('12-13', now());
INSERT IGNORE INTO booking_slot (`slot_hours`,`created_at`) VALUES ('13-14', now());
INSERT IGNORE INTO booking_slot (`slot_hours`,`created_at`) VALUES ('14-15', now());
INSERT IGNORE INTO booking_slot (`slot_hours`,`created_at`) VALUES ('15-16', now());
INSERT IGNORE INTO booking_slot (`slot_hours`,`created_at`) VALUES ('16-17', now());
INSERT IGNORE INTO booking_slot (`slot_hours`,`created_at`) VALUES ('17-18', now());

INSERT IGNORE INTO customer (`email`,`created_at`) VALUES ('khanraj.2k5@gmail.com', now());
INSERT IGNORE INTO customer (`email`,`created_at`) VALUES ('ghanu@zalora.com', now());
INSERT IGNORE INTO customer (`email`,`created_at`) VALUES ('test@krickbooking.com', now());
INSERT IGNORE INTO customer (`email`,`created_at`) VALUES ('test@krickbooking.com', now());

INSERT IGNORE INTO booking_status (`name`,`created_at`) VALUES ('booked', now());
INSERT IGNORE INTO booking_status (`name`,`created_at`) VALUES ('cancel', now());
INSERT IGNORE INTO booking_status (`name`,`created_at`) VALUES ('changed', now());




