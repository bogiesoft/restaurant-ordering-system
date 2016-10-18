-- MySQL dump 10.13  Distrib 5.1.73, for redhat-linux-gnu (x86_64)
--
-- Host: localhost    Database: install
-- ------------------------------------------------------
-- Server version	5.1.73

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `brands`
--

DROP TABLE IF EXISTS `brands`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `brands` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `brand` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `brands`
--

LOCK TABLES `brands` WRITE;
/*!40000 ALTER TABLE `brands` DISABLE KEYS */;
INSERT INTO `brands` VALUES (3,'Tropicana'),(4,'Borden'),(5,'Silk'),(6,'Dean Food'),(7,'Hoja');
/*!40000 ALTER TABLE `brands` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `category` varchar(30) NOT NULL,
  `image` varchar(80) NOT NULL DEFAULT 'images/categories/categorie.gif',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (12,'Dairy','images/categories/11080415_372503946266428_5429155017090234615_o.jpg'),(13,'Vegetable ','images/categories/category.png'),(14,'Meat','images/categories/category.png');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customers` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(75) NOT NULL,
  `last_name` varchar(75) NOT NULL,
  `account_number` varchar(30) DEFAULT NULL,
  `address` varchar(80) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `pcode` varchar(30) DEFAULT NULL,
  `state` varchar(50) DEFAULT NULL,
  `country` varchar(50) DEFAULT NULL,
  `phone_number` varchar(25) DEFAULT NULL,
  `email` varchar(80) DEFAULT NULL,
  `discount` int(11) NOT NULL DEFAULT '0',
  `comments` blob,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customers`
--

LOCK TABLES `customers` WRITE;
/*!40000 ALTER TABLE `customers` DISABLE KEYS */;
INSERT INTO `customers` VALUES (15,'HOJA','PIEJA','1234','123 Hello ave.','Piscataway','08901','NJ','USA','123456789','Paul.Fischer@rutgers.edu',1,'123'),(18,'Dunking Donut','Yay','account number','1234 A rd, apt 3','New Brunswick','08901','NJ','USA','6465221234','haha@rutgers.edu',1,''),(19,'Henry diner','','','1 Rutgers ave','Piscataway','08901','NJ','USA','0000001234','henry@rutgers.edu',0,'');
/*!40000 ALTER TABLE `customers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `discounts`
--

DROP TABLE IF EXISTS `discounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `discounts` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `item_id` int(8) NOT NULL,
  `percent_off` int(11) NOT NULL,
  `comment` blob,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `discounts`
--

LOCK TABLES `discounts` WRITE;
/*!40000 ALTER TABLE `discounts` DISABLE KEYS */;
/*!40000 ALTER TABLE `discounts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `items`
--

DROP TABLE IF EXISTS `items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `items` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `item_name` varchar(100) NOT NULL,
  `item_number` varchar(20) DEFAULT NULL,
  `description` blob,
  `brand_id` int(8) NOT NULL,
  `category_id` int(8) NOT NULL,
  `supplier_id` int(8) NOT NULL,
  `buy_price` varchar(30) NOT NULL,
  `unit_price` varchar(30) NOT NULL,
  `supplier_item_number` varchar(50) DEFAULT NULL,
  `tax_percent` varchar(10) NOT NULL,
  `total_cost` varchar(30) NOT NULL,
  `quantity` int(8) DEFAULT NULL,
  `reorder_level` int(8) DEFAULT NULL,
  `image` varchar(80) DEFAULT 'images/items/item.gif',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `items`
--

LOCK TABLES `items` WRITE;
/*!40000 ALTER TABLE `items` DISABLE KEYS */;
INSERT INTO `items` VALUES (29,'Chocolate Milk','1234','Every body loves chocolate milk.',5,12,2,'4.99','1','01234','.0725','8.99',300,50,'images/items/item.png'),(30,'Cheese','1235','Cheese all the way',4,12,2,'5.99','4.99','1234','0','10.99',500,50,'images/items/item.png'),(31,'Brocali','10','',6,13,2,'99.99','55.99','123','.25','56.13',200,150,'images/items/item.png'),(32,'Beef','1234','',4,14,2,'8.99','12.99','1234','1.25','13.15',200,20,'images/items/item.png');
/*!40000 ALTER TABLE `items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL DEFAULT '0000-00-00',
  `customer_id` int(8) DEFAULT NULL,
  `order_total` varchar(30) NOT NULL,
  `items_ordered` int(8) NOT NULL,
  `sold_by` int(8) NOT NULL,
  `comment` blob,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders_items`
--

DROP TABLE IF EXISTS `orders_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders_items` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `order_id` int(8) NOT NULL,
  `item_id` int(8) NOT NULL,
  `quantity_ordered` int(8) NOT NULL,
  `quantity_delivered` int(11) NOT NULL,
  `status` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=104 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders_items`
--

LOCK TABLES `orders_items` WRITE;
/*!40000 ALTER TABLE `orders_items` DISABLE KEYS */;
INSERT INTO `orders_items` VALUES (101,39,29,400,0,''),(102,39,30,200,0,'');
/*!40000 ALTER TABLE `orders_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sales`
--

DROP TABLE IF EXISTS `sales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sales` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL DEFAULT '0000-00-00',
  `customer_id` int(8) DEFAULT NULL,
  `sale_sub_total` varchar(30) NOT NULL,
  `sale_total_cost` varchar(30) NOT NULL,
  `paid_with` varchar(50) DEFAULT NULL,
  `items_purchased` int(8) NOT NULL,
  `sold_by` int(8) NOT NULL,
  `comment` blob,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sales`
--

LOCK TABLES `sales` WRITE;
/*!40000 ALTER TABLE `sales` DISABLE KEYS */;
INSERT INTO `sales` VALUES (27,'2015-04-26',4,'0','0',NULL,1,0,NULL),(28,'2015-04-26',5,'1995.78','1995.78',NULL,1,0,NULL),(29,'2015-04-26',0,'30.97','30.97',NULL,2,0,NULL),(30,'2015-04-26',0,'89.90','89.90',NULL,1,0,NULL),(31,'2015-04-28',15,'0','0',NULL,1,0,NULL),(32,'2015-04-28',15,'112.26','111.14',NULL,1,0,NULL),(33,'2015-04-28',0,'0','0',NULL,1,1,NULL),(34,'2015-04-28',15,'0.00','0.00',NULL,0,0,NULL),(35,'2015-04-28',15,'112.26','111.14',NULL,1,0,NULL),(36,'2015-04-29',15,'437.67','433.29',NULL,4,1,NULL),(37,'2015-04-29',0,'963.26','963.26',NULL,3,1,NULL),(38,'2015-04-29',18,'117.18','117.17',NULL,2,3,NULL),(39,'2015-04-29',0,'224.52','224.52',NULL,1,3,NULL),(40,'2015-04-29',15,'28.97','28.68',NULL,2,2,NULL);
/*!40000 ALTER TABLE `sales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sales_items`
--

DROP TABLE IF EXISTS `sales_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sales_items` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `sale_id` int(8) NOT NULL,
  `item_id` int(8) NOT NULL,
  `quantity_purchased` int(8) NOT NULL,
  `item_unit_price` varchar(30) NOT NULL,
  `item_buy_price` varchar(30) NOT NULL,
  `item_tax_percent` varchar(10) NOT NULL,
  `item_total_tax` varchar(30) NOT NULL,
  `item_total_cost` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=151 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sales_items`
--

LOCK TABLES `sales_items` WRITE;
/*!40000 ALTER TABLE `sales_items` DISABLE KEYS */;
INSERT INTO `sales_items` VALUES (124,20,30,20,'4.99','5.99','0','0.00','219.80'),(125,21,29,33,'1','4.99','.0725','0','0'),(126,22,29,999,'1','4.99','0.0725','0.00','8981.01'),(127,25,30,339,'4.99','5.99','0','0.00','3725.61'),(128,25,29,451,'1','4.99','0.0725','0.00','4054.49'),(129,26,29,36,'1','4.99','.0725','0','0'),(130,27,29,111,'1','4.99','.0725','0','0'),(131,28,29,222,'1','4.99','.0725','0.00','1995.78'),(132,29,29,1,'1','4.99','.0725','0.00','8.99'),(133,29,30,2,'4.99','5.99','0','0.00','21.98'),(134,30,29,10,'1','4.99','.0725','0.00','89.90'),(135,31,29,7,'1','4.99','.0725','0','0'),(136,32,31,2,'55.99','99.99','0.25','0.00','112.26'),(137,33,31,666,'55.99','99.99','.25','0','0'),(138,35,31,2,'55.99','99.99','.25','0.00','112.26'),(139,36,31,6,'55.99','99.99','.25','0.00','336.78'),(140,36,29,4,'1','4.99','.0725','0.00','35.96'),(141,36,29,6,'1','4.99','.0725','0.00','53.94'),(142,36,30,1,'4.99','5.99','0','0.00','10.99'),(143,37,30,10,'4.99','5.99','0','0.00','109.90'),(144,37,29,20,'1','4.99','.0725','0.00','179.80'),(145,37,31,12,'55.99','99.99','.25','0.00','673.56'),(146,38,32,4,'12.99','8.99','1.25','0.52','52.60'),(147,38,32,5,'12.99','8.99','1.25','0.65','65.75'),(148,39,31,4,'55.99','99.99','.25','0.00','224.52'),(149,40,29,2,'1','4.99','.0725','0.00','17.98'),(150,40,30,1,'4.99','5.99','0','0.00','10.99');
/*!40000 ALTER TABLE `sales_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `suppliers`
--

DROP TABLE IF EXISTS `suppliers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `suppliers` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `supplier` varchar(80) NOT NULL,
  `address` varchar(80) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `pcode` varchar(30) DEFAULT NULL,
  `state` varchar(50) DEFAULT NULL,
  `country` varchar(50) DEFAULT NULL,
  `phone_number` varchar(25) DEFAULT NULL,
  `contact` varchar(60) DEFAULT NULL,
  `email` varchar(80) DEFAULT NULL,
  `comments` blob,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `suppliers`
--

LOCK TABLES `suppliers` WRITE;
/*!40000 ALTER TABLE `suppliers` DISABLE KEYS */;
INSERT INTO `suppliers` VALUES (2,'Costco','25 Promenade Blvd','Bridgewater','08807','NJ','USA','(732)584-1003','John Cena','costco@costco.com','Good quality and cheap.'),(3,'Kilmer Market','123 Livingston Campus Plaza','Piscataway','08097','NJ','USA','(646)777-0000','Clark Hibga','clark.hibga@kilmermarket.com','convient but pricy. ');
/*!40000 ALTER TABLE `suppliers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(75) NOT NULL,
  `last_name` varchar(75) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(60) NOT NULL,
  `type` varchar(30) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Frank','Lee','frank','81dc9bdb52d04dc20036dbd8313ed055','1'),(2,'Amgad','Armanus','Amgad','81dc9bdb52d04dc20036dbd8313ed055','1'),(3,'HyunMo','Yang','HyunMo','81dc9bdb52d04dc20036dbd8313ed055',''),(4,'Johnny','Linn','Johny','81dc9bdb52d04dc20036dbd8313ed055',''),(5,'Nelson','Yu','nelson','81dc9bdb52d04dc20036dbd8313ed055',''),(6,'Lynn','Xu','lynn','81dc9bdb52d04dc20036dbd8313ed055',''),(7,'Robert','Chiu','robert','81dc9bdb52d04dc20036dbd8313ed055',''),(8,'Andy','Chou','andy','81dc9bdb52d04dc20036dbd8313ed055',''),(16,'Mana1','mana_last_name','test_manager','81dc9bdb52d04dc20036dbd8313ed055','1');
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

-- Dump completed on 2015-04-29 22:52:57
