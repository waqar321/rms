/*
SQLyog Community v13.2.0 (64 bit)
MySQL - 8.0.30 : Database - rms
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`rms` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;

USE `rms`;

/*Table structure for table `receipt_items` */

DROP TABLE IF EXISTS `receipt_items`;

CREATE TABLE `receipt_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `receipt_id` bigint unsigned NOT NULL,
  `item_id` bigint unsigned DEFAULT NULL,
  `item_qty` int NOT NULL,
  `item_price` decimal(8,2) NOT NULL,
  `item_sub_total` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `receipt_items_receipt_id_foreign` (`receipt_id`),
  KEY `receipt_items_item_id_foreign` (`item_id`),
  CONSTRAINT `receipt_items_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE,
  CONSTRAINT `receipt_items_receipt_id_foreign` FOREIGN KEY (`receipt_id`) REFERENCES `receipts` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `receipt_items` */

insert  into `receipt_items`(`id`,`receipt_id`,`item_id`,`item_qty`,`item_price`,`item_sub_total`,`created_at`,`updated_at`,`deleted_at`) values 
(1,4,2,1,350.00,350.00,NULL,NULL,NULL),
(2,4,3,2,160.00,320.00,NULL,NULL,NULL),
(3,4,5,2,70.00,140.00,NULL,NULL,NULL),
(4,4,6,1,600.00,600.00,NULL,NULL,NULL),
(5,4,7,1,1200.00,1200.00,NULL,NULL,NULL),
(6,5,2,1,350.00,350.00,NULL,'2025-04-18 21:16:30','2025-04-18 21:16:30'),
(7,6,3,3,160.00,480.00,NULL,NULL,NULL),
(8,6,5,2,70.00,140.00,NULL,NULL,NULL),
(9,6,7,1,1200.00,1200.00,NULL,NULL,NULL),
(10,6,11,2,400.00,800.00,NULL,NULL,NULL),
(11,7,3,2,160.00,320.00,'2025-04-18 21:17:35',NULL,NULL),
(12,7,6,2,600.00,1200.00,'2025-04-18 21:17:35',NULL,NULL),
(13,7,8,2,2400.00,4800.00,'2025-04-18 21:17:35',NULL,NULL),
(14,7,9,2,500.00,1000.00,'2025-04-18 21:17:35',NULL,NULL),
(15,7,11,1,400.00,400.00,'2025-04-18 21:17:35',NULL,NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
