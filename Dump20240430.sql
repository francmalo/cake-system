CREATE DATABASE  IF NOT EXISTS `cake` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `cake`;
-- MySQL dump 10.13  Distrib 8.0.34, for Win64 (x86_64)
--
-- Host: localhost    Database: cake
-- ------------------------------------------------------
-- Server version	8.0.34

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `category` (
  `category_id` int NOT NULL AUTO_INCREMENT,
  `category_name` varchar(255) DEFAULT NULL,
  `active` int DEFAULT '1',
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category`
--

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` VALUES (1,'Birthday',1),(2,'Wedding',1);
/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `customers` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `first_name` varchar(45) DEFAULT NULL,
  `second_name` varchar(45) DEFAULT NULL,
  `user_email` varchar(45) DEFAULT NULL,
  `email_valid` int DEFAULT '0',
  `phone` varchar(15) DEFAULT NULL,
  `user_pasword` varchar(60) DEFAULT NULL,
  `level` int DEFAULT '0',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `EMAIL` (`user_email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customers`
--

LOCK TABLES `customers` WRITE;
/*!40000 ALTER TABLE `customers` DISABLE KEYS */;
INSERT INTO `customers` VALUES (1,'francis','malombe','francis@gmail.com',1,'0790309700','$2y$10$/SQtfv2DUCf9vibHhiCa7ez5dP5qaWOVGFSBW1yfus0jFwnZE7Q02',0),(2,'Ian','One','Ian@gmail.com',0,NULL,'$2y$10$rPdOafEmN.1swgit3qutLOqvQY1pinAoJJDZC7wQ.4nbm964MP5S6',0),(3,'Grace ','Two','grace@gmail.com',0,'0790309722','$2y$10$JEJU.FMempdnUkuF3.9xU.vvIPvtCiA6AEjLDxLVh/GDWnUAosehS',0);
/*!40000 ALTER TABLE `customers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orderline`
--

DROP TABLE IF EXISTS `orderline`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orderline` (
  `orderline_id` int NOT NULL AUTO_INCREMENT,
  `order_id` int DEFAULT NULL,
  `product_id` int DEFAULT NULL,
  `price` varchar(45) DEFAULT NULL,
  `custom_desc` varchar(45) DEFAULT NULL,
  `orderline_status` int DEFAULT '1',
  `quantity` int DEFAULT NULL,
  PRIMARY KEY (`orderline_id`),
  KEY `order_fk_idx` (`order_id`),
  KEY `product_fk_idx` (`product_id`),
  CONSTRAINT `order_fk` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  CONSTRAINT `product_fk` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orderline`
--

LOCK TABLES `orderline` WRITE;
/*!40000 ALTER TABLE `orderline` DISABLE KEYS */;
INSERT INTO `orderline` VALUES (1,1,1,'4500','chocolate kwa wingi',0,2),(2,4,3,'4500',NULL,1,1),(3,5,1,'4500',NULL,1,1),(4,5,2,'4500',NULL,1,6);
/*!40000 ALTER TABLE `orderline` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders` (
  `order_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `order_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `delivery_date` date DEFAULT NULL,
  `delivery_type` int DEFAULT NULL,
  `address` varchar(1000) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `order_status` int DEFAULT '0',
  `invoice_status` int DEFAULT '0',
  `confirmed_by` int DEFAULT NULL,
  `date_confirmed` datetime DEFAULT NULL,
  `dispatched_by` int DEFAULT NULL,
  `date_dispatched` datetime DEFAULT NULL,
  `delivered_by` int DEFAULT NULL,
  `date_delivered` datetime DEFAULT NULL,
  PRIMARY KEY (`order_id`),
  KEY `user_fk_idx` (`user_id`),
  CONSTRAINT `customer_fk` FOREIGN KEY (`user_id`) REFERENCES `customers` (`user_id`) ON DELETE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (1,1,'2024-04-23 10:46:08','2024-04-30',1,'mzima house','012452365',3,0,1,'2024-04-24 00:00:00',1,'2024-04-24 00:00:00',1,'2024-04-24 00:00:00'),(2,1,'2024-04-30 03:52:11','2024-04-30',1,'rgfgfgfg','790309700',1,1,NULL,NULL,NULL,NULL,NULL,NULL),(3,1,'2024-04-30 03:53:13','2024-04-30',1,'gfft','790309700',1,1,NULL,NULL,NULL,NULL,NULL,NULL),(4,1,'2024-04-30 04:01:06','2024-04-30',1,'gfft','790309700',1,1,NULL,NULL,NULL,NULL,NULL,NULL),(5,1,'2024-04-30 08:41:25','2024-04-30',1,'gnghnn','790309700',1,1,NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product` (
  `product_id` int NOT NULL AUTO_INCREMENT,
  `product_name` varchar(255) DEFAULT NULL,
  `product_desc` varchar(1000) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `category_id` int DEFAULT NULL,
  `tag` varchar(255) DEFAULT NULL,
  `current_price` varchar(45) DEFAULT NULL,
  `prev_price` varchar(45) DEFAULT NULL,
  `status` int DEFAULT '1',
  PRIMARY KEY (`product_id`),
  KEY `category_fk_idx` (`category_id`),
  CONSTRAINT `category_fk` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`) ON DELETE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product`
--

LOCK TABLES `product` WRITE;
/*!40000 ALTER TABLE `product` DISABLE KEYS */;
INSERT INTO `product` VALUES (1,'1.5 kg Choco Chip','Far from boring, this delightful cake is dotted with chocolate chips throughout and then coated in a creamy fresh cream frosting with plenty of chocolate chips mixed in.','images/products/pic1.jpg',1,NULL,'4500','6000',1),(2,'1.5 kg Choco Chip','Far from boring, this delightful cake is dotted with chocolate chips throughout and then coated in a creamy fresh cream frosting with plenty of chocolate chips mixed in.','images/products/pic2.jpg',1,NULL,'4500','6000',1),(3,'1.5 kg Choco Chip','Far from boring, this delightful cake is dotted with chocolate chips throughout and then coated in a creamy fresh cream frosting with plenty of chocolate chips mixed in.','images/products/pic3.jpg',1,NULL,'4500','6000',1),(4,'1.5 kg Choco Chip','Far from boring, this delightful cake is dotted with chocolate chips throughout and then coated in a creamy fresh cream frosting with plenty of chocolate chips mixed in.','images/products/pic3.jpg',1,NULL,'4500','6000',1),(5,'1.5 kg Choco Chip','Far from boring, this delightful cake is dotted with chocolate chips throughout and then coated in a creamy fresh cream frosting with plenty of chocolate chips mixed in.','images/products/pic4.jpg',1,NULL,'4500','6000',1),(6,'1.5 kg Choco Chip','Far from boring, this delightful cake is dotted with chocolate chips throughout and then coated in a creamy fresh cream frosting with plenty of chocolate chips mixed in.','images/products/pic5.jpg',1,NULL,'4500','6000',1),(7,'1.5 kg Choco Chip','Far from boring, this delightful cake is dotted with chocolate chips throughout and then coated in a creamy fresh cream frosting with plenty of chocolate chips mixed in.','images/products/pic6.jpg',1,NULL,'4500','6000',1),(8,'1.5 kg Choco Chip','Far from boring, this delightful cake is dotted with chocolate chips throughout and then coated in a creamy fresh cream frosting with plenty of chocolate chips mixed in.','images/products/pic7.jpg',1,NULL,'4500','6000',1),(9,'1.5 kg Choco Chip','Far from boring, this delightful cake is dotted with chocolate chips throughout and then coated in a creamy fresh cream frosting with plenty of chocolate chips mixed in.','images/products/pic8.jpg',1,NULL,'4500','6000',1),(10,'1.5 kg Choco Chip','Far from boring, this delightful cake is dotted with chocolate chips throughout and then coated in a creamy fresh cream frosting with plenty of chocolate chips mixed in.','images/products/pic1.jpg',2,NULL,'4500','6000',1),(11,'1.5 kg Choco Chip','Far from boring, this delightful cake is dotted with chocolate chips throughout and then coated in a creamy fresh cream frosting with plenty of chocolate chips mixed in.','images/products/pic1.jpg',2,NULL,'4500','6000',1),(12,'1.5 kg Choco Chip','Far from boring, this delightful cake is dotted with chocolate chips throughout and then coated in a creamy fresh cream frosting with plenty of chocolate chips mixed in.','images/products/pic1.jpg',2,NULL,'4500','6000',1);
/*!40000 ALTER TABLE `product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tag`
--

DROP TABLE IF EXISTS `tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tag` (
  `tag_id` int NOT NULL AUTO_INCREMENT,
  `tag_name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`tag_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tag`
--

LOCK TABLES `tag` WRITE;
/*!40000 ALTER TABLE `tag` DISABLE KEYS */;
/*!40000 ALTER TABLE `tag` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `first_name` varchar(45) DEFAULT NULL,
  `second_name` varchar(45) DEFAULT NULL,
  `user_email` varchar(45) DEFAULT NULL,
  `email_valid` int DEFAULT '1',
  `phone` varchar(15) DEFAULT NULL,
  `user_pasword` varchar(60) DEFAULT NULL,
  `level` int DEFAULT '0',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `EMAIL` (`user_email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'francis','malombe','francis@gmail.com',1,NULL,'$2y$10$/SQtfv2DUCf9vibHhiCa7ez5dP5qaWOVGFSBW1yfus0jFwnZE7Q02',0);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-04-30 16:00:08
