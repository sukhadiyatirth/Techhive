-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: techhive_db
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `addresses`
--

DROP TABLE IF EXISTS `addresses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `addresses` (
  `address_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `address_line1` varchar(255) NOT NULL,
  `address_line2` varchar(255) DEFAULT NULL,
  `city` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `pincode` varchar(20) NOT NULL,
  `country` varchar(100) NOT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`address_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `addresses_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `addresses`
--

LOCK TABLES `addresses` WRITE;
/*!40000 ALTER TABLE `addresses` DISABLE KEYS */;
INSERT INTO `addresses` VALUES (1,3,'121,sakar grace society,near gayatri temple ,backside of hyundai showroom,mansa g&#039;nagar highway ,mansa','','mansa','gujrat','382845','India',0);
/*!40000 ALTER TABLE `addresses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`admin_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` VALUES (1,'Super Admin','admin@techhive.com','$2y$10$xDURgSx/kclckPgjmjMgF.7VcjxAjUZoyhn9Do0oX0t46Es5YO3we','2026-08-16 08:23:11');
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `brands`
--

DROP TABLE IF EXISTS `brands`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `brands` (
  `brand_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`brand_id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `brands`
--

LOCK TABLES `brands` WRITE;
/*!40000 ALTER TABLE `brands` DISABLE KEYS */;
INSERT INTO `brands` VALUES (1,'Apple','apple',NULL,'active','2026-08-16 08:23:11'),(2,'Samsung','samsung',NULL,'active','2026-08-16 08:23:11'),(3,'Sony','sony',NULL,'active','2026-08-16 08:23:11'),(4,'Logitech','logitech',NULL,'active','2026-08-16 08:23:11'),(5,'JBL','jbl',NULL,'active','2026-08-16 08:23:11'),(6,'boAt','boat',NULL,'active','2026-08-16 11:32:31'),(7,'Zebronics','zebronics',NULL,'active','2026-08-16 11:32:31'),(8,'Asus','asus',NULL,'active','2026-08-16 11:32:31'),(9,'Portronics','portronics',NULL,'active','2026-08-16 11:32:31'),(10,'KDM','kdm',NULL,'active','2026-08-16 11:32:31'),(11,'HP','hp',NULL,'active','2026-08-16 11:41:00'),(12,'Lenovo','lenovo',NULL,'active','2026-08-16 11:41:00'),(13,'Dell','dell',NULL,'active','2026-08-16 11:41:00'),(14,'Anker','anker',NULL,'active','2026-08-16 11:41:00'),(15,'Belkin','belkin',NULL,'active','2026-08-16 11:41:00'),(16,'UGREEN','ugreen',NULL,'active','2026-08-16 11:41:00'),(17,'Razer','razer',NULL,'active','2026-08-16 16:06:11'),(18,'Keychron','keychron',NULL,'active','2026-08-16 16:06:11'),(19,'OnePlus','oneplus',NULL,'active','2026-08-16 16:16:21'),(20,'Realme','realme',NULL,'active','2026-08-16 16:16:21'),(21,'Xiaomi','xiaomi',NULL,'active','2026-08-16 16:16:21'),(22,'Ambrane','ambrane',NULL,'active','2026-08-16 16:16:21'),(23,'URBN','urbn',NULL,'active','2026-08-16 16:16:21'),(24,'Garmin','garmin',NULL,'active','2026-08-16 16:16:21'),(25,'Marshall','marshall',NULL,'active','2026-08-16 16:16:21'),(26,'Bose','bose',NULL,'active','2026-08-16 16:47:13'),(27,'Sonos','sonos',NULL,'active','2026-08-16 16:47:16'),(28,'Ultimate Ears','ultimate-ears',NULL,'active','2026-08-16 16:47:16'),(29,'Bang & Olufsen','bang-and-olufsen',NULL,'active','2026-08-16 16:47:17');
/*!40000 ALTER TABLE `brands` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cart`
--

DROP TABLE IF EXISTS `cart`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`cart_id`),
  KEY `user_id` (`user_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cart`
--

LOCK TABLES `cart` WRITE;
/*!40000 ALTER TABLE `cart` DISABLE KEYS */;
/*!40000 ALTER TABLE `cart` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`category_id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Laptops','laptops','Premium laptops for work and gaming.',NULL,'active','2026-08-16 08:23:11'),(2,'Earbuds','earbuds','True wireless earbuds with active noise cancellation.',NULL,'active','2026-08-16 08:23:11'),(3,'Smart Watches','smart-watches','Track your fitness and stay connected.',NULL,'active','2026-08-16 08:23:11'),(4,'Power Banks','power-banks','Portable chargers for your devices.',NULL,'active','2026-08-16 08:23:11'),(5,'Keyboards','keyboards','Mechanical and wireless keyboards.',NULL,'active','2026-08-16 08:23:11'),(6,'Mouse','mouse','Ergonomic and gaming mice.',NULL,'active','2026-08-16 08:23:11'),(7,'Speakers','speakers','High fidelity portable and home speakers.',NULL,'active','2026-08-16 11:32:31'),(8,'Neckbands','neckbands','Wireless neckband earphones for active lifestyles.',NULL,'active','2026-08-16 11:32:31'),(9,'Accessories','accessories','Premium workspace and tech accessories.',NULL,'active','2026-08-16 11:41:00'),(10,'Chargers','chargers','Fast chargers and power bricks.',NULL,'active','2026-08-16 11:41:00'),(11,'Cables','cables','Durable and high-speed cables.',NULL,'active','2026-08-16 11:41:00'),(12,'Adapters','adapters','Hubs and dongles for all connectivity needs.',NULL,'active','2026-08-16 11:41:00');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contact_messages`
--

DROP TABLE IF EXISTS `contact_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subject` varchar(200) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contact_messages`
--

LOCK TABLES `contact_messages` WRITE;
/*!40000 ALTER TABLE `contact_messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `contact_messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `coupons`
--

DROP TABLE IF EXISTS `coupons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `coupons` (
  `coupon_id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) NOT NULL,
  `discount_type` enum('percentage','fixed') NOT NULL,
  `discount_value` decimal(10,2) NOT NULL,
  `minimum_order` decimal(10,2) DEFAULT 0.00,
  `maximum_discount` decimal(10,2) DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `usage_limit` int(11) DEFAULT NULL,
  `used_count` int(11) DEFAULT 0,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`coupon_id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `coupons`
--

LOCK TABLES `coupons` WRITE;
/*!40000 ALTER TABLE `coupons` DISABLE KEYS */;
INSERT INTO `coupons` VALUES (1,'WELCOME10','percentage',10.00,50.00,NULL,NULL,100,0,'active','2026-08-16 08:23:11'),(2,'FLAT50','fixed',50.00,500.00,NULL,NULL,50,0,'active','2026-08-16 08:23:11'),(3,'BOGO20','percentage',12.00,1700.00,NULL,NULL,2,1,'active','2026-08-16 10:07:12');
/*!40000 ALTER TABLE `coupons` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `newsletter_subscribers`
--

DROP TABLE IF EXISTS `newsletter_subscribers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `newsletter_subscribers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `newsletter_subscribers`
--

LOCK TABLES `newsletter_subscribers` WRITE;
/*!40000 ALTER TABLE `newsletter_subscribers` DISABLE KEYS */;
/*!40000 ALTER TABLE `newsletter_subscribers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_items` (
  `order_item_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `product_name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  PRIMARY KEY (`order_item_id`),
  KEY `order_id` (`order_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE,
  CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_items`
--

LOCK TABLES `order_items` WRITE;
/*!40000 ALTER TABLE `order_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `order_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `order_number` varchar(50) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `discount` decimal(10,2) DEFAULT 0.00,
  `shipping_charge` decimal(10,2) DEFAULT 0.00,
  `total_amount` decimal(10,2) NOT NULL,
  `payment_method` enum('cod','online') NOT NULL,
  `payment_status` enum('pending','paid','failed') NOT NULL DEFAULT 'pending',
  `order_status` enum('pending','confirmed','processing','shipped','out_for_delivery','delivered','cancelled') NOT NULL DEFAULT 'pending',
  `shipping_address` text NOT NULL,
  `coupon_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`order_id`),
  UNIQUE KEY `order_number` (`order_number`),
  KEY `user_id` (`user_id`),
  KEY `coupon_id` (`coupon_id`),
  CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`coupon_id`) REFERENCES `coupons` (`coupon_id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `sku` varchar(100) NOT NULL,
  `short_description` varchar(500) DEFAULT NULL,
  `full_description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `discount_price` decimal(10,2) DEFAULT NULL,
  `discount_percentage` int(11) DEFAULT 0,
  `stock_quantity` int(11) NOT NULL DEFAULT 0,
  `product_image` varchar(255) NOT NULL,
  `image_2` varchar(255) DEFAULT NULL,
  `image_3` varchar(255) DEFAULT NULL,
  `image_4` varchar(255) DEFAULT NULL,
  `specifications` text DEFAULT NULL,
  `warranty` varchar(100) DEFAULT NULL,
  `rating` decimal(3,2) DEFAULT 0.00,
  `review_count` int(11) DEFAULT 0,
  `featured` tinyint(1) DEFAULT 0,
  `bestseller` tinyint(1) DEFAULT 0,
  `new_arrival` tinyint(1) DEFAULT 0,
  `status` enum('active','inactive','out_of_stock') NOT NULL DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`product_id`),
  UNIQUE KEY `slug` (`slug`),
  UNIQUE KEY `sku` (`sku`),
  KEY `category_id` (`category_id`),
  KEY `brand_id` (`brand_id`),
  CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`),
  CONSTRAINT `products_ibfk_2` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`brand_id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,1,1,'MacBook Pro 16\"','macbook-pro-16','APP-MBP-16','Supercharged by M3 Pro or M3 Max.','The 16-inch MacBook Pro brings a whole new class of performance to the pro user. With the powerful M3 Max chip, it delivers mind-blowing speed for machine learning, video editing, and complex 3D rendering. The Liquid Retina XDR display is the best ever in a notebook, offering Extreme Dynamic Range, incredible contrast, and true-to-life colors. Featuring up to 22 hours of battery life, a 1080p FaceTime HD camera, a high-fidelity six-speaker sound system, and a studio-quality mic array. It\'s the ultimate pro notebook for the ultimate pro workflow.',2499.99,2399.99,0,49,'1786970332_459_laptop_0.jpg',NULL,NULL,NULL,'Processor: Apple M3 Max 16-Core CPU\nGraphics: 40-Core GPU\nMemory: 48GB Unified Memory\nStorage: 1TB SSD\nDisplay: 16.2-inch Liquid Retina XDR\nBattery Life: Up to 22 hours\nPorts: 3x Thunderbolt 4, HDMI, SDXC, MagSafe 3\nWeight: 2.16 kg\nOS: macOS Sonoma',NULL,4.67,3,1,1,0,'active','2026-08-16 08:23:11','2026-08-17 12:38:55'),(2,2,1,'AirPods Pro (2nd Gen)','airpods-pro-2','APP-AP-2','Up to 2x more Active Noise Cancellation.','AirPods Pro (2nd generation) have been re-engineered to deliver up to 2x more Active Noise Cancellation. Adaptive Transparency reduces external noise while letting you hear your surroundings. Personalized Spatial Audio immerses you in sound. A single charge delivers up to 6 hours of battery life. And Touch control lets you easily adjust volume with a swipe. The MagSafe Charging Case is a marvel on its own with Precision Finding, a built-in speaker, and lanyard loop.',249.99,199.99,0,200,'1786876862_airpods_pro_2_1786876425334.jpg',NULL,NULL,NULL,'Audio Technology: Active Noise Cancellation, Adaptive Transparency\nChip: Apple H2 Headphone Chip\nSweat and Water Resistant: Yes (IPX4)\nBattery Life: Up to 6 hours (30 hours with case)\nCharging: MagSafe, Qi, Lightning\nConnectivity: Bluetooth 5.3\nWeight: 5.3g per earbud',NULL,4.67,3,1,1,0,'active','2026-08-16 08:23:11','2026-08-16 10:41:02'),(3,3,2,'Galaxy Watch 6','galaxy-watch-6','SAM-GW-6','Start your everyday wellness journey.','Meet the Samsung Galaxy Watch 6. Start your everyday wellness journey with the ultimate smart watch. It features our largest screen yet with a thinner bezel, so you can see more and do more. Advanced sleep coaching helps you build better habits, while personalized heart rate zones help you train smarter. The durable crystal glass and armor aluminum frame ensure it can withstand your daily adventures while looking premium.',299.99,NULL,0,150,'1786876862_galaxy_watch_6_1786876439311.jpg',NULL,NULL,NULL,'Display: 1.5-inch Super AMOLED\nResolution: 480 x 480 pixels\nProcessor: Exynos W930 Dual-Core 1.4GHz\nRAM: 2GB\nStorage: 16GB\nBattery: 425mAh (Up to 40 hours)\nDurability: Sapphire Crystal Glass, IP68, 5ATM\nSensors: Heart Rate, ECG, BIA, Temperature\nOS: Wear OS 4',NULL,4.67,3,1,0,1,'active','2026-08-16 08:23:11','2026-08-16 10:41:02'),(4,6,4,'MX Master 3S','mx-master-3s','LOG-MX-3S','The ultimate precision mouse.','Logitech MX Master 3S is an iconic mouse remastered for ultimate tactility, performance, and flow. Quiet Click buttons deliver a satisfying tactile feel with 90% less click noise. The 8,000 DPI optical sensor tracks anywhere, even on glass. The MagSpeed electromagnetic scroll wheel is precise enough to stop on a pixel and quick enough to scroll 1,000 lines per second. Its ergonomic silhouette is crafted to perfectly support your palm and fingers.',99.99,89.99,0,300,'1786876862_mx_master_3s_1786876703220.jpg',NULL,NULL,NULL,'Sensor: 8000 DPI Darkfield High Precision\nButtons: 7 (Quiet Clicks)\nScroll Wheel: MagSpeed Electromagnetic\nConnectivity: Bluetooth, Logi Bolt USB\nBattery: Rechargeable Li-Po (500 mAh)\nBattery Life: Up to 70 days\nCharging: USB-C (3 mins charge = 1 full day)\nOS Support: Windows, macOS, Linux',NULL,4.67,3,0,1,0,'active','2026-08-16 08:23:11','2026-08-16 16:06:11'),(5,2,3,'Sony WF-1000XM5','sony-wf-1000xm5','SON-WF-XM5','The best noise cancelling earbuds.','The Sony WF-1000XM5 wireless earbuds feature cutting-edge technology to deliver premium sound quality and the best noise canceling performance on the market. Real-time audio processors and high-performance mics power the specially designed driver unit for wide frequency reproduction, deep bass, and clear vocals. They are designed to immerse you in a sound so good, it feels like you\'re in the studio with your favorite artists.',298.00,NULL,0,100,'1786876862_sony_earbuds_1786876801928.jpg',NULL,NULL,NULL,'Driver Unit: 8.4mm Dynamic Driver X\nNoise Canceling: Multi-Noise Sensor Technology\nAudio Format: Hi-Res Audio Wireless, LDAC\nBattery Life: Up to 8 hours (24 hours with case)\nQuick Charge: 3 mins for 1 hour playback\nWater Resistance: IPX4\nWeight: 5.9g per earbud\nMultipoint Connection: Yes',NULL,4.67,3,1,0,1,'active','2026-08-16 08:23:11','2026-08-16 10:41:02'),(6,8,6,'boAt Rockerz 255 Pro+','boat-rockerz-255-pro-plus','BOAT-R255-PRO','Unbeatable sound with 40 Hours playback.','Leave all charging worries at bay as the Rockerz 255 Pro+ comes with a humongous battery backup of up to 40 hours. With a few minutes of ASAP Charge you can get up to 10 hours of audio time by charging them for only 10 mins. The unbeatable boAt signature sound shines through no matter what you\'re playing.',2990.00,1499.00,50,500,'1786879951_boat_neckband_1786878087364.jpg',NULL,NULL,NULL,'Playback: Up to 40 Hours\nASAP Charge: 10 mins = 10 hours\nBluetooth: v5.0\nWater Resistance: IPX7\nDriver Size: 10mm\nControls: Inline controls with mic',NULL,4.50,2,0,0,1,'active','2026-08-16 11:32:31','2026-08-16 11:32:31'),(7,2,7,'Zebronics Zeb-Sound Bomb 1','zebronics-zeb-sound-bomb-1','ZEB-SB1','Compact design, explosive sound.','Tune into your favorite beats with Zebronics Zeb-Sound Bomb 1 wireless earbuds. Featuring a compact and stylish design, they offer seamless Bluetooth 5.0 connectivity, touch controls, and a snug fit. With the portable charging case, you get extended playback to keep the music going all day.',1999.00,899.00,55,300,'1786879951_zeb_soundbomb_1786878143045.jpg',NULL,NULL,NULL,'Bluetooth: v5.0\nBattery Life: Up to 12 hours with case\nControls: Touch\nVoice Assistant Support: Yes\nMicrophone: Built-in',NULL,4.50,2,0,0,1,'active','2026-08-16 11:32:31','2026-08-16 11:32:31'),(8,6,8,'Asus ROG Gladius III','asus-rog-gladius-iii','ASUS-ROG-G3','Classic asymmetrical wireless gaming mouse with 26,000 dpi.','ROG Gladius III Wireless features tri-mode connectivity (2.4 GHz, Bluetooth, wired) and a 26,000 dpi optical sensor with 1% deviation (tuned to 26,000 dpi) for near-zero latency and unrivaled precision. The unique Push-Fit Switch Socket II design ensures compatibility with both 3-pin mechanical and 5-pin Omron optical micro switches.',8999.00,7499.00,17,150,'1786879951_asus_rog_mouse_1786878231166.jpg',NULL,NULL,NULL,'Sensor: 26,000 DPI Optical\nConnectivity: Wired / 2.4GHz / Bluetooth\nSwitches: Push-Fit Socket II\nLighting: Aura Sync RGB\nWeight: 89g',NULL,5.00,2,0,0,1,'active','2026-08-16 11:32:31','2026-08-16 11:32:31'),(9,7,26,'Bose SoundLink Flex','bose-soundlink-flex','PORT-SD1','State-of-the-art portable Bluetooth speaker with waterproof design and positionIQ technology.','The SoundDrum 1 is a 10W portable Bluetooth speaker that delivers surprisingly powerful stereo sound. It\'s built with a durable fabric mesh and rugged rubber housing, allowing it to outlast all of your adventures. Equipped with a built-in microphone, you can take crystal clear calls directly from the speaker.',14999.00,1299.00,48,400,'1786898836_279_bose-soundlink-flex.jpg',NULL,NULL,NULL,'Power Output: 10W\nConnectivity: Bluetooth 5.0, AUX, USB, FM\nBattery: 2000mAh (up to 6 hours)\nBuilt-in Mic: Yes\nForm Factor: Cylindrical',NULL,4.50,2,0,0,1,'active','2026-08-16 11:32:31','2026-08-16 16:47:16'),(10,8,10,'KDM A1 Wireless','kdm-a1-wireless','KDM-A1-WL','Reliable wireless audio on the go.','Experience uninterrupted music with the KDM A1 Wireless neckband. Designed for comfort and durability, it features a flexible neckband that sits softly around your neck. The magnetic earbuds snap together to prevent tangles when not in use, and the enhanced drivers deliver clear vocals and deep bass.',1499.00,699.00,53,600,'1786879951_kdm_neckband_1786879822597.jpg',NULL,NULL,NULL,'Connectivity: Bluetooth v5.0\nBattery Life: Up to 20 hours\nCharging: Micro USB\nDesign: Flexible and lightweight\nFeatures: Magnetic Earbuds',NULL,3.50,2,0,0,1,'active','2026-08-16 11:32:31','2026-08-16 11:32:31'),(11,1,11,'HP Spectre x360','hp-spectre-x360','HP-SP-X360','Convertible 2-in-1 laptop with stunning gem-cut design.','Crafted from a single block of aluminum, the HP Spectre x360 is exactingly designed for performance. With a 360-degree hinge, you can use it as a laptop, tent, or tablet.',149999.00,135000.00,10,50,'1786970335_758_laptop_1.jpg',NULL,NULL,NULL,'Processor: Intel Core i7\nRAM: 16GB\nStorage: 1TB SSD\nDisplay: 13.5\" OLED Touch',NULL,4.50,2,0,0,1,'active','2026-08-16 11:41:01','2026-08-17 12:38:55'),(12,1,12,'Lenovo ThinkPad X1 Carbon','lenovo-thinkpad-x1','LEN-TP-X1','The ultimate business ultrabook.','Ultralight and ultra-powerful, the ThinkPad X1 Carbon Gen 10 delivers enterprise-level security, long battery life, and the legendary ThinkPad keyboard.',189999.00,NULL,0,30,'1786970335_116_laptop_2.jpg',NULL,NULL,NULL,'Processor: Intel Core i7\nRAM: 32GB\nStorage: 1TB NVMe\nDisplay: 14\" WUXGA',NULL,5.00,2,0,0,1,'active','2026-08-16 11:41:02','2026-08-17 12:38:56'),(13,1,13,'Dell XPS 13 Plus','dell-xps-13-plus','DELL-XPS-13','Futuristic design with an edge-to-edge keyboard.','The XPS 13 Plus features a seamless glass haptic touchpad, zero-lattice keyboard, and a capacitive touch function row. Performance meets minimalist elegance.',165000.00,155000.00,6,45,'1786970336_774_laptop_3.jpg',NULL,NULL,NULL,'Processor: Intel Core i7\nRAM: 16GB\nStorage: 512GB SSD\nDisplay: 13.4\" FHD+ InfinityEdge',NULL,4.50,2,0,0,1,'active','2026-08-16 11:41:04','2026-08-17 12:38:56'),(14,9,16,'Ergonomic Aluminum Laptop Stand','ugreen-laptop-stand','UG-LSTND-1','Foldable cooling stand for 10-17 inch laptops.','Elevate your laptop to eye level to fix your posture. This heavy-duty aluminum stand supports up to 20kg and features hollow cooling designs to keep your machine running cold.',2499.00,1499.00,40,200,'1786895723_725_laptop_stand_1786895383591.jpg',NULL,NULL,NULL,'Material: Aluminum Alloy\nCompatibility: 10 to 17 inches\nWeight: 250g',NULL,5.00,1,0,0,1,'active','2026-08-16 11:41:06','2026-08-16 15:55:23'),(15,9,9,'Premium Vegan Leather Desk Mat','portronics-desk-mat','PORT-DM-BLK','Extended size desk pad, waterproof and anti-slip.','Protect your desk and provide a smooth gliding surface for your mouse. Crafted from durable vegan leather that wipes clean easily.',1299.00,899.00,31,500,'1786895723_865_desk_mat_1786895400607.jpg',NULL,NULL,NULL,'Dimensions: 900 x 400 mm\nMaterial: PU Leather\nFeatures: Water-resistant, Anti-slip backing',NULL,4.00,1,0,0,1,'active','2026-08-16 11:41:08','2026-08-16 15:55:23'),(16,10,14,'Anker 735 Nano II 65W Charger','anker-735-nano-65w','ANK-735-65','3-Port GaN fast charger for laptops and phones.','Power up to 3 devices simultaneously with this ultra-compact GaN charger. Capable of charging a MacBook Pro at full speed, or rapidly charging your phone, tablet, and earbuds.',4999.00,3999.00,20,150,'1786895723_304_gan_charger_1786895417499.jpg',NULL,NULL,NULL,'Output: 65W Max\nPorts: 2x USB-C, 1x USB-A\nTechnology: GaN II',NULL,5.00,1,0,0,1,'active','2026-08-16 11:41:10','2026-08-16 15:55:23'),(17,11,15,'Belkin BoostCharge Pro Braided USB-C Cable','belkin-boostcharge-usbc','BLK-BC-USBC','100W PD compatible braided cable, 2 meters.','Tested to survive 10,000+ bends, this heavy-duty braided cable supports up to 100W Power Delivery, making it ideal for fast charging laptops and flagship smartphones.',1499.00,999.00,33,800,'1786895723_395_usbc_cable_1786895452566.jpg',NULL,NULL,NULL,'Length: 2 Meters\nPower: Up to 100W\nMaterial: Double Braided Nylon',NULL,5.00,1,0,0,1,'active','2026-08-16 11:41:12','2026-08-16 15:55:23'),(18,4,14,'Anker PowerCore 20K PD','anker-powercore-20k','ANK-PC-20K','20,000mAh Power Bank with 20W USB-C output.','Keep your devices charged for days with a massive 20,000mAh capacity. Delivers high-speed charging to phones, tablets, and even Nintendo Switch.',5999.00,4499.00,25,120,'1786895723_800_powerbank_1786895468448.jpg',NULL,NULL,NULL,'Capacity: 20,000mAh\nOutput: 20W PD\nPorts: 1x USB-C, 1x USB-A',NULL,5.00,1,0,0,1,'active','2026-08-16 11:41:13','2026-08-16 15:55:23'),(19,12,16,'UGREEN 7-in-1 USB-C Hub','ugreen-7in1-hub','UG-7HUB','Multi-port adapter with 4K HDMI and 100W PD.','Expand your laptop\'s connectivity instantly. Features a 4K@60Hz HDMI port, 100W Power Delivery pass-through, SD/TF card readers, and 2 USB-A 3.0 ports.',3499.00,2499.00,29,250,'1786895723_133_usb_adapter_1786895485467.jpg',NULL,NULL,NULL,'Ports: HDMI, SD, MicroSD, 2x USB-A, 1x USB-C PD\nVideo: 4K @ 60Hz\nPower Pass-through: 100W',NULL,4.00,1,0,0,1,'active','2026-08-16 11:41:14','2026-08-16 15:55:23'),(20,5,4,'Logitech MX Keys','logitech-mx-keys','LOGI-MX-KEYS','Advanced Wireless Illuminated Keyboard.','Think it. Master it. MX Keys is an advanced wireless illuminated keyboard crafted for efficiency, stability, and precision. Perfect Stroke keys are shaped for your fingertips.',11999.00,10499.00,13,150,'1786896371_876_logitech_mx_keys_1786896071620.jpg',NULL,NULL,NULL,'Connectivity: Bluetooth / USB Receiver\nBacklight: Smart Illumination\nBattery: Up to 5 months (backlight off)',NULL,5.00,2,0,0,1,'active','2026-08-16 16:06:11','2026-08-16 16:06:11'),(21,5,17,'Razer BlackWidow V4 Pro','razer-blackwidow-v4-pro','RZ-BW-V4-PRO','Full-blown battlestation keyboard with Chroma RGB.','Empower your play with the ultimate gaming keyboard. Features Razer Mechanical Switches for quick, precise execution, and a dedicated Command Dial and 8 macro keys.',22999.00,19999.00,13,80,'1786896371_538_razer_blackwidow_1786896294542.jpg',NULL,NULL,NULL,'Switches: Razer Green/Yellow\nLighting: Underglow and per-key RGB\nWrist Rest: Magnetic Plush Leatherette',NULL,4.50,2,0,0,1,'active','2026-08-16 16:06:11','2026-08-16 16:06:11'),(22,5,18,'Keychron Q1 Pro','keychron-q1-pro','KC-Q1-PRO','QMK/VIA custom wireless mechanical keyboard.','A fully customizable 75% layout mechanical keyboard with QMK/VIA support. Features a full aluminum CNC machined body, double-gasket design, and wireless connectivity.',18999.00,17499.00,8,120,'1786896371_814_keychron_q1_1786896336167.jpg',NULL,NULL,NULL,'Layout: 75%\nBody: Full Aluminum\nConnectivity: Wireless & Wired\nHot-swappable: Yes',NULL,5.00,2,0,0,1,'active','2026-08-16 16:06:11','2026-08-16 16:06:11'),(23,8,19,'OnePlus Bullets Wireless Z2','oneplus-bullets-z2','OP-BW-Z2','Fast charging neckband with 30-hour battery life.','A quick 10-minute charge delivers up to 20 hours of immersive audio playback. The flagship-level battery life delivers up to 30 hours of non-stop music on a single charge.',2299.00,1999.00,13,500,'neck_var1.jpg',NULL,NULL,NULL,'Driver: 12.4mm\nBattery: 30 hours\nWater Resistance: IP55\nFast Charging: 10 mins = 20 hours',NULL,5.00,1,0,0,1,'active','2026-08-16 16:16:22','2026-08-16 16:38:04'),(24,8,20,'Realme Buds Wireless 3','realme-buds-wireless-3','RM-BW-3','30dB Active Noise Cancellation neckband.','Immerse yourself in pure music with 30dB ANC. Features a 13.6mm dynamic bass driver and 360-degree spatial audio effect.',2999.00,1799.00,40,300,'neck_var2.jpg',NULL,NULL,NULL,'ANC: 30dB\nDriver: 13.6mm\nBattery: 40 hours\nSpatial Audio: Yes',NULL,4.00,1,0,0,1,'active','2026-08-16 16:16:22','2026-08-16 16:38:04'),(25,8,3,'Sony WI-C100','sony-wi-c100','SNY-WI-C100','Comfortable wireless in-ear headphones.','Great sound quality with DSEE technology, up to 25 hours of battery life, and splash-proof design for peace of mind.',2790.00,1699.00,39,150,'neck_var3.jpg',NULL,NULL,NULL,'DSEE: Yes\nBattery: 25 hours\nWater Resistance: IPX4\nApp Support: Sony Headphones Connect',NULL,5.00,1,0,0,1,'active','2026-08-16 16:16:23','2026-08-16 16:38:04'),(26,4,21,'Xiaomi Mi Power Bank 3i 20000mAh','mi-powerbank-3i-20k','MI-PB-3I-20','Massive 20000mAh capacity with 18W fast charging and triple output ports.','The Xiaomi Mi Power Bank 3i features a massive 20000mAh capacity, housed in a sleek sandstone black finish. It offers 18W fast charging with triple port output, allowing you to charge three devices simultaneously. Its 12-layer advanced circuit protection ensures complete safety for your premium devices. The smart power management system allows you to safely charge low-power accessories like Bluetooth headsets and fitness bands by simply double-pressing the power button.',2199.00,1899.00,14,400,'1786898403_827_mi-powerbank-3i-20k.jpg',NULL,NULL,NULL,'Capacity: 20000mAh\nOutput: 18W Fast Charging (Triple Port)\nInput: Dual Input (Type-C & Micro USB)\nProtection: 12-Layer Advanced Chip Protection\nMaterial: Anti-slip & Scratch Resistant',NULL,5.00,1,0,0,1,'active','2026-08-16 16:16:23','2026-08-16 16:43:11'),(27,4,22,'Ambrane 20000mAh Power Bank','ambrane-20000mah','AMB-20K-PB','Reliable 20000mAh power bank featuring dual output ports and multi-layer protection.','Power up your devices on the go with the Ambrane 20000mAh Power Bank. Designed with a premium textured finish for a secure grip, it features dual USB outputs and blazing fast 22.5W Power Delivery. The integrated LED indicator keeps you informed of the battery level at a glance. Built with a high-density Lithium Polymer battery, it offers a safe and highly efficient charging experience for your smartphone, tablet, and smart wearables.',2499.00,1599.00,36,250,'1786898403_756_ambrane-20000mah.jpg',NULL,NULL,NULL,'Capacity: 20000mAh\nOutput: 22.5W Fast Charging (Dual USB + Type-C)\nInput: Type-C PD\nIndicator: LED Battery Level Display\nBuild: Textured Rugged Grip',NULL,4.00,1,0,0,1,'active','2026-08-16 16:16:24','2026-08-16 16:43:11'),(28,4,23,'URBN 10000mAh Ultra Compact','urbn-10000mah-compact','URBN-10K-C','Ultra-compact 10000mAh power bank, pocket-sized with 20W super-fast output.','Experience portability at its finest with the URBN 10000mAh Ultra Compact Power Bank. It boasts an incredibly small, pocket-sized footprint that fits right in the palm of your hand or perfectly slips into your jeans pocket. Despite its tiny size, it delivers 20W super-fast charging to get your smartphone to 50% in just 30 minutes. The soft-touch matte finish resists fingerprints and scratches, making it the perfect everyday carry accessory.',1999.00,999.00,50,600,'1786898403_780_urbn-10000mah-compact.jpg',NULL,NULL,NULL,'Capacity: 10000mAh\nOutput: 20W Super Fast Charging\nForm Factor: Ultra Compact Pocket-Sized\nPorts: 1x USB-A, 1x Type-C\nWeight: 180 grams',NULL,5.00,1,0,0,1,'active','2026-08-16 16:16:25','2026-08-16 16:43:11'),(29,3,1,'Apple Watch Series 9','apple-watch-series-9','AW-S9-45','A brighter mind. A brighter display.','The most powerful chip in Apple Watch ever. A magical new way to use your watch without touching the screen. A display that\'s twice as bright.',44900.00,41900.00,7,100,'watch_var1.jpg',NULL,NULL,NULL,'Chip: S9 SiP\nDisplay: Up to 2000 nits\nFeature: Double Tap Gesture\nHealth: Blood Oxygen, ECG',NULL,5.00,1,0,0,1,'active','2026-08-16 16:16:26','2026-08-16 16:38:04'),(30,3,2,'Samsung Galaxy Watch 5 Pro','galaxy-watch-5-pro','SAM-GW5-PRO','Built for adventurers. Titanium toughness.','Track your route, monitor your heart rate, and push your limits. With a titanium case and sapphire crystal glass, it\'s ready for any adventure.',39999.00,29999.00,25,80,'watch_var2.jpg',NULL,NULL,NULL,'Case: Titanium\nGlass: Sapphire Crystal\nBattery: Up to 80 hours\nGPS: Route Workout',NULL,5.00,1,0,0,1,'active','2026-08-16 16:16:26','2026-08-16 16:38:04'),(31,3,24,'Garmin Fenix 7 Sapphire Solar','garmin-fenix-7-solar','GAR-F7-SS','Rugged multisport GPS watch with solar charging.','Meet any athletic or outdoor challenge with the rugged fenix 7 Sapphire Solar multisport GPS watch. Its scratch-resistant Power Sapphire solar charging lens uses the sun\'s energy to extend battery life.',89990.00,84990.00,6,30,'watch_var3.jpg',NULL,NULL,NULL,'Lens: Power Sapphire\nBattery: Up to 22 days (Solar)\nMaps: Preloaded TopoActive\nDurability: MIL-STD-810',NULL,5.00,1,0,0,1,'active','2026-08-16 16:16:26','2026-08-16 16:38:04'),(32,7,28,'Ultimate Ears BOOM 3','ue-boom-3','JBL-FLIP-6','Super-portable wireless Bluetooth speaker: balanced 360-degree sound, deep bass, waterproof.','Loud, powerful sound in a highly portable package. The JBL Flip 6 features a 2-way speaker system engineered to deliver loud, crystal clear, powerful sound.',12999.00,9999.00,17,200,'1786898837_323_ue-boom-3.jpg',NULL,NULL,NULL,'Output: 20W RMS\nWaterproof: IP67\nBattery: 12 hours\nFeature: PartyBoost',NULL,5.00,1,0,0,1,'active','2026-08-16 16:16:27','2026-08-16 16:47:17'),(33,7,27,'Sonos Roam Portable','sonos-roam','SNY-XB13','The smart portable speaker for all your listening adventures, featuring WiFi and Bluetooth.','Don\'t be fooled by its compact shape, this little speaker packs major surround sound. The Sound Diffusion Processor expands sound in any space.',16999.00,3490.00,30,400,'1786898836_103_sonos-roam.jpg',NULL,NULL,NULL,'Feature: Extra Bass\nBattery: 16 hours\nWaterproof: IP67\nStrap: Multiway strap included',NULL,4.00,1,0,0,1,'active','2026-08-16 16:16:28','2026-08-16 16:47:16'),(34,7,29,'Bang & Olufsen Beosound A1','beosound-a1','MAR-EMB-1','Premium, portable Bluetooth speaker with built-in voice assistant and exceptional audio quality.','Emberton utilizes True Stereophonic, a unique form of multi-directional sound from Marshall. Experience absolute 360┬░ sound where every spot is a sweet spot.',24999.00,12999.00,13,150,'1786898837_612_beosound-a1.jpg',NULL,NULL,NULL,'Playtime: 20+ hours\nSound: True Stereophonic\nDurability: IPX7 Water-resistant\nControl: Multi-directional knob',NULL,5.00,1,0,0,1,'active','2026-08-16 16:16:28','2026-08-16 16:47:17');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reviews` (
  `review_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `review_text` text DEFAULT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`review_id`),
  KEY `product_id` (`product_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE,
  CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reviews`
--

LOCK TABLES `reviews` WRITE;
/*!40000 ALTER TABLE `reviews` DISABLE KEYS */;
INSERT INTO `reviews` VALUES (1,1,1,5,'Absolutely incredible machine. The battery life is insane even when compiling heavy code.','approved','2026-08-16 10:41:02'),(2,1,1,5,'The screen is gorgeous. I use it for color grading and it is dead accurate.','approved','2026-08-16 10:41:02'),(3,1,1,4,'Very heavy and expensive, but you get what you pay for. Unmatched performance.','approved','2026-08-16 10:41:02'),(4,2,1,5,'The noise cancellation upgrade is very noticeable. Best earbuds on the market.','approved','2026-08-16 10:41:02'),(5,2,1,5,'Fits perfectly in my ears and doesn\'t fall out during workouts. Sound quality is superb.','approved','2026-08-16 10:41:02'),(6,2,1,4,'Great audio, but the glossy white case still gets scratched way too easily.','approved','2026-08-16 10:41:02'),(7,3,1,4,'Love the larger screen and thinner bezels. Battery life is okay, usually gets me through a day and a half.','approved','2026-08-16 10:41:02'),(8,3,1,5,'The sleep tracking is extremely accurate. Highly recommend it for Samsung users.','approved','2026-08-16 10:41:02'),(9,3,1,5,'Very sleek design, doesn\'t feel bulky on the wrist. Bright display outdoors.','approved','2026-08-16 10:41:02'),(10,4,1,5,'The most comfortable mouse I\'ve ever used. The quiet clicks are a game changer in the office.','approved','2026-08-16 10:41:02'),(11,4,1,5,'Scrolling feels magical. I can fly through massive spreadsheets.','approved','2026-08-16 10:41:02'),(12,4,1,4,'A bit heavy for gaming, but unparalleled for productivity and coding.','approved','2026-08-16 10:41:02'),(13,5,1,5,'Sony did it again. The noise cancelling is slightly better than AirPods Pro 2 in my testing.','approved','2026-08-16 10:41:02'),(14,5,1,4,'The foam tips take some getting used to, but the sound quality is incredibly rich and detailed.','approved','2026-08-16 10:41:02'),(15,5,1,5,'Much smaller and lighter than the XM4s. Extremely comfortable for long flights.','approved','2026-08-16 10:41:02'),(16,6,1,5,'Amazing battery life! Sound is super bassy.','approved','2026-08-16 11:32:31'),(17,6,1,4,'Good for gym, fits well around the neck.','approved','2026-08-16 11:32:31'),(18,7,1,4,'Great value for money. Decent sound for daily commuting.','approved','2026-08-16 11:32:31'),(19,7,1,5,'Very small and pocketable case.','approved','2026-08-16 11:32:31'),(20,8,1,5,'The sensor is incredibly accurate. Love the hot-swappable switches!','approved','2026-08-16 11:32:31'),(21,8,1,5,'Ergonomics are perfect for palm grip users.','approved','2026-08-16 11:32:31'),(22,9,1,4,'Very loud for its size. The FM radio feature is a nice bonus.','approved','2026-08-16 11:32:31'),(23,9,1,5,'Solid build quality and great bass.','approved','2026-08-16 11:32:31'),(24,10,1,4,'Good budget neckband. Battery lasts me 3 days easily.','approved','2026-08-16 11:32:31'),(25,10,1,3,'Microphone quality is average during calls, but music sounds good.','approved','2026-08-16 11:32:31'),(26,11,1,5,'Beautiful design, OLED screen is stunning!','approved','2026-08-16 11:41:01'),(27,11,1,4,'A bit heavy for tablet mode, but very premium.','approved','2026-08-16 11:41:01'),(28,12,1,5,'Best keyboard on a laptop, hands down.','approved','2026-08-16 11:41:02'),(29,12,1,5,'Incredibly light and durable.','approved','2026-08-16 11:41:02'),(30,13,1,4,'Touchpad takes getting used to, but looks amazing.','approved','2026-08-16 11:41:04'),(31,13,1,5,'Screen bezels are basically invisible.','approved','2026-08-16 11:41:04'),(32,14,1,5,'Very sturdy, doesn\'t wobble when typing.','approved','2026-08-16 11:41:06'),(33,15,1,4,'Looks very professional. A bit curled out of the box but flattens quickly.','approved','2026-08-16 11:41:08'),(34,16,1,5,'Incredibly small for 65W! Charges my ThinkPad perfectly.','approved','2026-08-16 11:41:10'),(35,17,1,5,'Very thick and durable cable. Feels like it will last years.','approved','2026-08-16 11:41:12'),(36,18,1,5,'Charged my iPhone 5 times over on a camping trip!','approved','2026-08-16 11:41:13'),(37,19,1,4,'Gets a little warm under heavy load, but all ports work flawlessly.','approved','2026-08-16 11:41:14'),(38,20,1,5,'Best typing experience for office work.','approved','2026-08-16 16:06:11'),(39,20,1,5,'Seamless switching between devices.','approved','2026-08-16 16:06:11'),(40,21,1,5,'The RGB is insane and the switches feel incredibly responsive.','approved','2026-08-16 16:06:11'),(41,21,1,4,'A bit pricey, but worth it for the macro keys.','approved','2026-08-16 16:06:11'),(42,22,1,5,'The build quality is incredible. Super heavy and premium.','approved','2026-08-16 16:06:11'),(43,22,1,5,'Best custom keyboard you can get out of the box.','approved','2026-08-16 16:06:11'),(44,23,1,5,'Incredible bass and battery life!','approved','2026-08-16 16:16:22'),(45,24,1,4,'ANC is surprisingly good for the price.','approved','2026-08-16 16:16:22'),(46,25,1,5,'Classic Sony sound signature.','approved','2026-08-16 16:16:23'),(47,26,1,5,'Heavy, but holds a massive charge.','approved','2026-08-16 16:16:23'),(48,27,1,4,'LED display is very handy.','approved','2026-08-16 16:16:24'),(49,28,1,5,'Literally the size of a credit card!','approved','2026-08-16 16:16:25'),(50,29,1,5,'Double tap is a game changer!','approved','2026-08-16 16:16:26'),(51,30,1,5,'Battery life is finally good enough for multi-day hikes.','approved','2026-08-16 16:16:26'),(52,31,1,5,'The ultimate fitness tracking watch. Built like a tank.','approved','2026-08-16 16:16:26'),(53,32,1,5,'Amazing sound for such a small cylinder.','approved','2026-08-16 16:16:27'),(54,33,1,4,'Great for hanging in the shower!','approved','2026-08-16 16:16:28'),(55,34,1,5,'Looks incredible on a shelf and sounds even better.','approved','2026-08-16 16:16:28');
/*!40000 ALTER TABLE `reviews` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `password_hash` varchar(255) NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'John Doe','john@example.com','9876543210','$2y$10$z0OrKYQa/ABxvtJGZUfJI.rWhBy68GE9Dmace7dC3kfFivIQ9Z.ee','active','2026-08-16 08:23:11'),(2,'Jane Smith','jane@example.com','8765432109','$2y$10$z0OrKYQa/ABxvtJGZUfJI.rWhBy68GE9Dmace7dC3kfFivIQ9Z.ee','active','2026-08-16 08:23:11'),(3,'Sukhadiya Tirth chiragkumar','sukhadiyatirth771@gmail.com','07043617880','$2y$10$lVKw8/SJ5sk0EZK0dd4mVe/zLZAQV9SQXTzdJQFvVcCBKgnSchKUq','active','2026-08-16 10:08:34');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wishlist`
--

DROP TABLE IF EXISTS `wishlist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wishlist` (
  `wishlist_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`wishlist_id`),
  KEY `user_id` (`user_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `wishlist_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  CONSTRAINT `wishlist_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wishlist`
--

LOCK TABLES `wishlist` WRITE;
/*!40000 ALTER TABLE `wishlist` DISABLE KEYS */;
/*!40000 ALTER TABLE `wishlist` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-09-16 22:23:24
