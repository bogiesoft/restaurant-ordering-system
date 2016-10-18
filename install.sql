
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE IF NOT EXISTS `brands` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `brand` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;


CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `category` varchar(30) NOT NULL,
  `image` varchar(80) NOT NULL DEFAULT 'images/categories/categorie.gif',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;


CREATE TABLE IF NOT EXISTS `customers` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;


CREATE TABLE IF NOT EXISTS `discounts` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `item_id` int(8) NOT NULL,
  `percent_off` int(11) NOT NULL,
  `comment` blob,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `items` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;


CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL DEFAULT '0000-00-00',
  `customer_id` int(8) DEFAULT NULL,
  `order_total` varchar(30) NOT NULL,
  `items_ordered` int(8) NOT NULL,
  `sold_by` int(8) NOT NULL,
  `comment` blob,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=35 ;

CREATE TABLE IF NOT EXISTS `orders_items` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `order_id` int(8) NOT NULL,
  `item_id` int(8) NOT NULL,
  `quantity_ordered` int(8) NOT NULL,
  `quantity_delivered` int(11) NOT NULL,
  `status` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=94 ;


CREATE TABLE IF NOT EXISTS `sales` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;


CREATE TABLE IF NOT EXISTS `sales_items` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=124 ;


CREATE TABLE IF NOT EXISTS `suppliers` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;


CREATE TABLE IF NOT EXISTS `users` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(75) NOT NULL,
  `last_name` varchar(75) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(60) NOT NULL,
  `type` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

