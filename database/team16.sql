-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 29 May 2018, 18:43:20
-- Sunucu sürümü: 10.1.8-MariaDB
-- PHP Sürümü: 5.6.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `team16`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `brands`
--

CREATE TABLE `brands` (
  `brand_id` int(100) NOT NULL,
  `brand_title` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Tablo döküm verisi `brands`
--

INSERT INTO `brands` (`brand_id`, `brand_title`) VALUES
(1, 'HP'),
(2, 'Samsung'),
(3, 'Apple'),
(4, 'Sony'),
(5, 'LG'),
(6, 'Cloth Brand'),
(7, 'Lenovo'),
(8, 'Xiaomi'),
(9, 'MSI'),
(10, 'DELL'),
(11, 'Kindle'),
(12, 'Beats'),
(13, 'JBL'),
(14, 'Sennheiser'),
(15, 'Spigen'),
(16, 'Porto'),
(17, 'Strandmon'),
(18, 'Mineo'),
(19, 'Alfemo'),
(20, 'Knoll'),
(21, 'John Lewis'),
(22, 'Istikbal'),
(23, 'White Westinghouse'),
(24, 'Bosch'),
(25, 'Philips'),
(26, 'Siemens'),
(44, 'Gothenburg'),
(45, 'Logitech');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `cart`
--

CREATE TABLE `cart` (
  `id` int(10) NOT NULL,
  `p_id` int(10) NOT NULL,
  `ip_add` varchar(250) NOT NULL,
  `user_id` int(10) DEFAULT NULL,
  `qty` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Tablo döküm verisi `cart`
--

INSERT INTO `cart` (`id`, `p_id`, `ip_add`, `user_id`, `qty`) VALUES
(5, 1, '::1', 4, 1),
(6, 1, '::1', 5, 1),
(7, 2, '::1', 5, 1),
(8, 3, '::1', 5, 1),
(13, 2, '', 3, 2),
(14, 1, '', -1, 1),
(16, 2, '', -1, 1),
(18, 1, '', 3, 1),
(19, 4, '', -1, 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `categories`
--

CREATE TABLE `categories` (
  `cat_id` int(100) NOT NULL,
  `cat_title` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Tablo döküm verisi `categories`
--

INSERT INTO `categories` (`cat_id`, `cat_title`) VALUES
(1, 'Electronics'),
(2, 'Ladies Wears'),
(3, 'Mens Wear'),
(4, 'Kids Wear'),
(5, 'Furnitures'),
(6, 'Home Appliances'),
(7, 'Electronics Gadgets');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `comments`
--

CREATE TABLE `comments` (
  `product_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `rating` double DEFAULT NULL,
  `comments` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Tablo döküm verisi `comments`
--

INSERT INTO `comments` (`product_id`, `user_id`, `rating`, `comments`) VALUES
(1, 3, 4.6, 'good'),
(1, 2, 3.3, 'Could be better'),
(2, 1, 1, 'Just Don''t'),
(1, 1, 3, 'Useful');

--
-- Tetikleyiciler `comments`
--
DELIMITER $$
CREATE TRIGGER `after_add_review` AFTER INSERT ON `comments` FOR EACH ROW BEGIN
UPDATE products SET rating=(SELECT AVG(rating) FROM comments WHERE(comments.product_id=new.product_id)) WHERE products.product_id=new.product_id;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_remove_review` BEFORE DELETE ON `comments` FOR EACH ROW BEGIN
UPDATE products SET rating=(SELECT AVG(rating) FROM comments WHERE(comments.product_id=old.product_id)) WHERE products.product_id=old.product_id;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `verifyOrdered` BEFORE INSERT ON `comments` FOR EACH ROW BEGIN
        IF new.product_id NOT IN (
            select A.product_id
            From orders A  
            where (new.product_id = A.product_id and new.user_id = A.user_id)
        ) THEN 
           CALL `Not Ordered!`;

        END IF;
    END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `trx_id` varchar(255) NOT NULL,
  `p_status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Tablo döküm verisi `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `product_id`, `qty`, `trx_id`, `p_status`) VALUES
(1, 2, 7, 1, '07M47684BS5725041', 'Completed'),
(2, 2, 2, 1, '07M47684BS5725041', 'Completed'),
(3, 1, 1, 1, '7JX9604834237671E', 'Completed'),
(4, 1, 3, 1, '7JX9604834237671E', 'Completed'),
(5, 1, 2, 1, '4SE40336VA0469356', 'Completed'),
(6, 1, 3, 1, '4SE40336VA0469356', 'Completed'),
(7, 1, 4, 1, '1G919651X00112032', 'Completed'),
(8, 1, 21, 1, '1G919651X00112032', 'Completed'),
(9, 1, 22, 1, '9H800224FB672953G', 'Completed'),
(10, 1, 21, 1, '9H800224FB672953G', 'Completed'),
(11, 1, 1, 1, '9H800224FB672953G', 'Completed');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `products`
--

CREATE TABLE `products` (
  `product_id` int(100) NOT NULL,
  `product_cat` int(100) NOT NULL,
  `product_brand` int(100) NOT NULL,
  `product_title` varchar(255) NOT NULL,
  `product_price` int(100) NOT NULL,
  `buying_price` int(100) NOT NULL,
  `product_desc` text NOT NULL,
  `product_image` text NOT NULL,
  `product_keywords` text NOT NULL,
  `stock` int(100) NOT NULL DEFAULT '0',
  `rating` double DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Tablo döküm verisi `products`
--

INSERT INTO `products` (`product_id`, `product_cat`, `product_brand`, `product_title`, `product_price`, `buying_price`, `product_desc`, `product_image`, `product_keywords`, `stock`, `rating`) VALUES
(1, 1, 2, 'Samsung Dous 2', 4000, 3800, 'Samsung Dous 2 sgh ', 'samsung mobile.jpg', 'samsung mobile electronics', 600, 3.633333333333333),
(2, 1, 3, 'iPhone 5s', 25000, 22000, 'iphone 5s', 'iphone mobile.jpg', 'mobile iphone apple', 3000, 1),
(4, 1, 3, 'iPhone 6s', 32000, 31300, 'Apple iPhone ', 'iphone.jpg', 'iphone apple mobile', 3500, 0),
(5, 1, 2, 'iPad 2', 10000, 11000, 'samsung ipad', 'ipad 2.jpg', 'ipad tablet samsung', 3400, 0),
(6, 1, 1, 'Hp Laptop r series', 35000, 33270, 'Hp Red and Black combination Laptop', 'k2-_ed8b8f8d-e696-4a96-8ce9-d78246f10ed1.v1.jpg-bc204bdaebb10e709a997a8bb4518156dfa6e3ed-optim-450x450.jpg', 'hp laptop ', 4800, 0),
(7, 1, 1, 'Laptop Pavillion', 50000, 45560, 'Laptop Hp Pavillion', '12039452_525963140912391_6353341236808813360_n.png', 'Laptop Hp Pavillion', 2450, 0),
(8, 1, 4, 'Sony', 40000, 35698, 'Sony Mobile', 'sony mobile.jpg', 'sony mobile', 2860, 0),
(9, 1, 3, 'iPhone New', 12000, 11000, 'iphone', 'white iphone.png', 'iphone apple mobile', 4600, 0),
(10, 2, 6, 'Red Ladies dress', 1000, 999, 'red dress for girls', 'reddress.jpg', 'red dress ', 800, 0),
(11, 2, 6, 'Blue Heave dress', 1200, 1000, 'Blue dress', 'heavewoman.jpg', 'blue dress cloths', 950, 0),
(12, 2, 6, 'Ladies Casual Cloths', 1500, 1290, 'ladies casual summer two colors pleted', '7475-ladies-casual-dresses-summer-two-colors-pleated.jpg', 'girl dress cloths casual', 500, 0),
(13, 2, 6, 'SpringAutumnDress', 1200, 1150, 'girls dress', 'Spring-Autumn-Winter-Young-Ladies-Casual-Wool-Dress-Women-s-One-Piece-Dresse-Dating-Clothes-Medium.jpg_640x640.jpg', 'girl dress', 680, 0),
(14, 2, 6, 'Casual Dress', 1400, 1267, 'girl dress', 'download.jpg', 'ladies cloths girl', 390, 0),
(15, 2, 6, 'Formal Look', 1500, 1276, 'girl dress', 'shutterstock_203611819.jpg', 'ladies wears dress girl', 560, 0),
(16, 3, 6, 'Sweter for men', 600, 560, '2012-Winter-Sweater-for-Men-for-better-outlook', 'sweaterMen.jpg', 'black sweter cloth winter', 870, 0),
(17, 3, 6, 'Gents formal', 1000, 880, 'gents formal look', 'gents-formal-250x250.jpg', 'gents wear cloths', 560, 0),
(19, 3, 6, 'Formal Coat', 3000, 2700, 'ad', 'images (1).jpg', 'coat blazer gents', 780, 0),
(20, 3, 6, 'Mens Sweeter', 1600, 1500, 'jg', 'Winter-fashion-men-burst-sweater.png', 'sweeter gents ', 670, 0),
(21, 3, 6, 'T shirt', 800, 700, 'ssds', 'IN-Mens-Apparel-Voodoo-Tiles-09._V333872612_.jpg', 'formal t shirt black', 560, 0),
(22, 4, 6, 'Yellow T shirt ', 1300, 1104, 'yello t shirt with pant', '1.0x0.jpg', 'kids yellow t shirt', 680, 0),
(23, 4, 6, 'Girls cloths', 1900, 1670, 'sadsf', 'GirlsClothing_Widgets.jpg', 'formal kids wear dress', 900, 0),
(24, 4, 6, 'Blue T shirt', 700, 560, 'g', 'images.jpg', 'kids dress', 1000, 0),
(25, 4, 6, 'Yellow girls dress', 750, 700, 'as', 'images (3).jpg', 'yellow kids dress', 780, 0),
(26, 4, 6, 'Skyblue dress', 650, 640, 'nbk', 'kids-wear-121.jpg', 'skyblue kids dress', 900, 0),
(27, 4, 6, 'Formal look', 690, 660, 'sd', 'image28.jpg', 'formal kids dress', 870, 0),
(32, 5, 0, 'Book Shelf', 2500, 2300, 'book shelf', 'furniture-book-shelf-250x250.jpg', 'book shelf furniture', 1350, 0),
(33, 6, 2, 'Refrigerator', 35000, 34900, 'Refrigerator', 'CT_WM_BTS-BTC-AppliancesHome_20150723.jpg', 'refrigerator samsung', 1400, 0),
(34, 6, 4, 'Emergency Light', 1000, 980, 'Emergency Light', 'emergency light.JPG', 'emergency light', 4500, 0),
(35, 6, 0, 'Vaccum Cleaner', 6000, 5400, 'Vaccum Cleaner', 'images (2).jpg', 'Vaccum Cleaner', 3400, 0),
(36, 6, 5, 'Iron', 1500, 1487, 'gj', 'iron.JPG', 'iron', 4000, 0),
(37, 6, 5, 'LED TV', 20000, 19999, 'LED TV', 'images (4).jpg', 'led tv lg', 2350, 0),
(38, 6, 4, 'Microwave Oven', 3500, 3456, 'Microwave Oven', 'images.jpg', 'Microwave Oven', 3410, 0),
(39, 6, 5, 'Mixer Grinder', 2500, 2346, 'Mixer Grinder', 'singer-mixer-grinder-mg-46-medium_4bfa018096c25dec7ba0af40662856ef.jpg', 'Mixer Grinder', 1200, 0),
(40, 2, 6, 'Formal girls dress', 3000, 3000, 'Formal girls dress', 'girl-walking.jpg', 'ladies', 790, 0),
(45, 1, 2, 'Samsung Galaxy Note 3', 10000, 8576, '0', 'samsung_galaxy_note3_note3neo.JPG', 'samsung galaxy Note 3 neo', 2000, 0),
(46, 1, 2, 'Samsung Galaxy Note 3', 10000, 9874, '', 'samsung_galaxy_note3_note3neo.JPG', 'samsung galxaxy note 3 neo', 2670, 0),
(49, 1, 3, 'Apple TV', 3000, 2896, 'Apple Tv', 'apple-tv.jpg', 'Apple TV', 4000, 0),
(50, 1, 3, 'Macbook Air', 4000, 3400, 'Macbook Air', 'macbook-air.jpg', 'laptop macbook air', 4000, 0),
(51, 1, 3, 'Macbook Pro', 3000, 2300, 'Macbook Pro Silver', 'macbook-pro.jpg', 'laptop macbook pro', 4000, 0),
(52, 1, 11, 'Amazon Kindle Fire', 2500, 2400, 'Amazon Kindle Fire 7 inch Tablet', 'amazon-kindle-fire.jpg', 'Tablet Amazon Kindle Fire', 5000, 0),
(53, 1, 11, 'Dell Inspiron', 2500, 2400, 'Dell Inspiron Laptop', 'dell-inspiron.jpg', 'Laptop Dell Inspiron', 6000, 0),
(54, 1, 11, 'Dell XPS', 5500, 5000, 'Dell XPS Laptop', 'dell-xps.jpg', 'Laptop Dell XPS', 7000, 0),
(55, 1, 7, 'Lenovo All-in-One PC', 4500, 4300, 'Lenovo All-in-One PC', 'lenovo-aio.jpg', 'All-in-One Lenovo PC', 4500, 0),
(56, 1, 7, 'Lenovo Yoga', 7500, 5600, 'Lenovo Yoga Foldable Laptop with Touchscreen', 'lenovo-yoga.png', 'Laptop Foldable Lenovo Yoga', 6000, 0),
(57, 1, 9, 'MSI All-in-One ', 8500, 8000, 'MSI All-in-One PC', 'msi-aio.jpg', 'MSI All-in-One PC', 4000, 0),
(58, 1, 9, 'MSI Nightblade ', 9500, 9000, 'MSI Nightblade PC', 'msi-nightblade.jpg', 'MSI Nightblade PC', 4000, 0),
(59, 1, 8, 'Xiaomi Mi Mix ', 4500, 4000, 'Xiaomi Mi Mix Bezel-less Smartphone', 'mi-mix.jpg', 'Xiaomi Mi Mix Smartphone', 4000, 0),
(60, 5, 16, '3-Seater Porto', 2300, 2000, 'Porto 3-seater for living room', '3-seater-porto.jpg', 'Porto Seater', 3400, 0),
(61, 5, 17, 'Armchair Strandmon', 3300, 3000, 'Strandmon Armchair-Children Size', 'armchair-for-children-strandmon.jpg', 'Strandmon Armchair Children', 3450, 0),
(62, 5, 44, 'Armchair Gothenburg', 5300, 5000, 'Gothenburg armchair', 'armchair-gothenburg.jpg', 'Armchair Seater Gothenburg', 6400, 0),
(63, 5, 18, 'Armchair Mineo', 4300, 4000, 'Mineo armchair', 'armchair-mineo.jpg', 'Armchair Seater Mineo', 6800, 0),
(64, 5, 19, 'Dining Group Alfemo', 3300, 3000, 'Alfemo Dining group', 'dining-group-alfemo.jpg', 'Alfemo Dining Group', 2400, 0),
(65, 5, 20, 'Table Knoll', 5300, 5000, 'Knoll Table', 'dining-table-knoll.jpg', 'Dining Table Knoll', 7400, 0),
(66, 5, 21, 'Dinner Table John Lewis', 5600, 5500, 'John Lewis Foldable Dinner Table', 'dinner-table-foldable-john-lew?s.jpg', 'Dinner Table John Lewis', 2400, 0),
(67, 5, 16, 'HandChair Porto', 5300, 5000, 'Porto Hand Shaped Chair', 'hand-chair-porto.jpg', 'HandChair Porto', 7400, 0),
(68, 5, 19, 'Seating Group Alfemo', 9300, 9000, 'Alfemo Seating Group', 'seating-group-alfemo.jpg', 'Alfemo Seating Group', 1400, 0),
(69, 5, 22, 'Seating Group Istikbal', 7300, 7000, 'Ist?kbal Seating Group', 'seating-group-istikbal.jpg', 'Seating Group Istikbal', 2400, 0),
(70, 7, 12, 'Beats Pill 2', 6300, 6000, 'Beats Pill 2 Bluetooth Speakers', 'beats-pill2.jpg', 'Bluetooth Speakers Beats Pill ', 4450, 0),
(71, 7, 12, 'Beats Solo 3', 5300, 5000, 'Beats Solo 3 Headphones', 'beats-solo3.jpg', 'Headphones Beats Solo ', 6450, 0),
(72, 7, 12, 'Beats Studio 3', 7300, 7000, 'Beats Studio 3 Headphones', 'beats-studio3-golden.jpg', 'Headphones Beats Studio', 7450, 0),
(73, 7, 13, 'JBL E25BT', 4300, 4000, 'JBL E25BT Bluetooth Headphones', 'jbl-e25bt.jpg', 'Headphones JBL E25BT', 2450, 0),
(74, 7, 45, 'Logitech K480', 2300, 2000, 'Logitech K480 Bluetooth Phone Keyboard', 'logitech-k480-phone-keyboard.jpg', 'Phone Keyboard Bluetooth Logitech', 9450, 0),
(75, 7, 12, 'Beats Solo 3', 5300, 5000, 'Beats Solo 3 Headphones', 'beats-solo3.jpg', 'Headphones Beats Solo 3', 6450, 0),
(76, 7, 14, 'Sennheiser Momentum On-Ear', 6250, 6200, 'Sennheiser Momentum On-ear Headphones', 'sennheiser-momentum-onear.jpg', 'Momentum On-Ear Heaphones Sennheiser', 8450, 0),
(77, 7, 15, 'Spigen Selfie Stick', 1100, 1000, 'Spigen Selfie Stick', 'spigen-selfie-stick.jpg', 'Selfie Stick Spigen', 1450, 0),
(78, 7, 14, 'Sennheiser Momentum Over-Ear', 8300, 8000, 'Sennheiser Momentum Over-Ear Headphones', 'sennheiser-momentum-overear.jpg', 'Sennheiser Over-Ear Momentum Headphones', 6230, 0),
(79, 7, 8, 'Xiaomi Mi Band 2', 2300, 2000, 'Xiaomi Mi Band 2 Smartwatch', 'xiami-mi-band-2.jpg', 'Fitness Smartwatch Xiaomi Mi Band', 3450, 0),
(81, 6, 5, 'LG Dishwasher', 8300, 8000, 'LG Dishwasher Silver', 'dishwasher-lg.jpg', 'LG Dishwasher', 3450, 0),
(82, 6, 2, 'Samsung Dishwasher', 9000, 8900, 'Samsung Dishwasher Silver', 'dishwasher-samsung.jpg', 'Samsung Dishwasher', 6400, 0),
(83, 6, 5, 'LG Fridge', 5000, 4500, 'LG Fridge Silver', 'fridge-lg.jpg', 'LG Fridge', 4800, 0),
(84, 6, 2, 'Samsung Fridge', 9000, 8600, 'Samsung Fridge Blue', 'fridge-samsung.jpg', 'Samsung Fridge', 3050, 0),
(85, 6, 23, 'White Westinghouse Fridge', 4000, 3950, 'White Westinghouse Fridge Silver', 'fridge-whitewestinghouse.jpg', 'White Westinghouse Fridge', 1300, 0),
(86, 6, 5, 'LG Microwave', 3000, 2500, 'LG Microwave Black', 'microwave-lg.jpg', 'LG Microwave', 3800, 0),
(87, 6, 24, 'Bosch Mixer', 2000, 1600, 'Bosch Mixer', 'mixer-bosch.jpg', 'Bosch Mixer', 2000, 0),
(88, 6, 25, 'Philips Mixer', 2000, 1400, 'Philips Mixer Black', 'mixer-philips.jpg', 'Philips Mixer', 3700, 0),
(89, 6, 26, 'Siemens Toaster', 3400, 2000, 'Siemens Toaster', 'toaster-siemens.jpg', 'Siemens Toaster', 1800, 0),
(90, 6, 2, 'Samsung Washingmachine', 8040, 8000, 'Samsung Washingmachine Black', 'washingmachine-samsung.jpg', 'Samsung Washingmachine', 2600, 0),
(91, 4, 6, 'Jacket-Boys', 4000, 3000, 'Black Jacket For Boys', 'diesel-jacket-boy.jpg', 'Black Jacket Kids Boys', 9400, 0),
(92, 4, 6, 'Sweatshirt-Girls', 4800, 4500, 'Navy Blue Sweatshirt For Girls', 'adidas-sweatshirt-girl.jpg', 'Blue Sweatshirt Girls', 9400, 0),
(93, 4, 6, 'Jeans-Boys', 3200, 3000, 'Jeans For Boys', 'diesel-jeans-boys.jpg', 'Jeans Boys', 2400, 0),
(94, 4, 6, 'Sneakers-Boys', 3150, 3100, 'Black Sneakers For Boys', 'nike-sneakers-boy.jpg', 'Black Sneakers Kids Boys', 2100, 0),
(95, 3, 6, 'Black Leather Jacket-Men', 10000, 9990, 'Black Leather Jacket For Men', 'jacket-men-2.jpg', 'Black Leather M3n Jacket', 2410, 0),
(96, 3, 6, 'Blue Jeans-Men', 5000, 4560, 'Blue Jeans For Men', 'jeans-men-3.jpg', 'Blue Jeans Men', 5410, 0),
(97, 3, 6, 'Scarf-Men', 2000, 1900, 'Scarf For Men', 'scarf-men.jpg', 'Scarf Men', 7000, 0),
(98, 3, 6, 'Trench Coat-Men', 9000, 7609, 'Trench Coat For Men', 'trenchcoat-men.jpg', 'Trench Coat Men', 3000, 0),
(99, 3, 6, 'Gray Trousers-Men', 6000, 4589, 'Grey Trousers For Men', 'trousers-men.jpg', 'Gray Trousers Men', 2000, 0),
(100, 2, 6, 'Black Jeans-Women', 7300, 7000, 'Black Jeans For Women', 'jeans-women.jpg', 'Black Jeans Women', 8450, 0),
(101, 2, 6, 'Red Jacket-Women', 9800, 9650, 'Red Jacket For Women', 'jacket-women.jpg', 'Red Jacket Women', 2433, 0),
(102, 2, 6, 'Blue Sneakers-Women', 2300, 2300, 'Blue Sneakers For Women', 'nike-women-sneakers2.jpg', 'Blue Running Sneakers Women', 2480, 0),
(103, 2, 6, 'Red Sweater-Women', 5400, 5400, 'Red Sweater For Women', 'women-sweater.jpg', 'Red Sweater Women', 5280, 0);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `user_info`
--

CREATE TABLE `user_info` (
  `user_id` int(10) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(300) NOT NULL,
  `password` varchar(300) NOT NULL,
  `mobile` varchar(10) NOT NULL,
  `address1` varchar(300) NOT NULL,
  `address2` varchar(11) NOT NULL,
  `Lv` varchar(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Tablo döküm verisi `user_info`
--

INSERT INTO `user_info` (`user_id`, `first_name`, `last_name`, `email`, `password`, `mobile`, `address1`, `address2`, `Lv`) VALUES
(1, 'Sezer', 'Selin', 'selinsezer@ymail.com', '25f9e794323b453885f5181f1b624d0b', '8389080183', 'Sabanci', 'Tuzla', 'U'),
(2, 'Sezer', 'Selin', 'selinsezer@ymail.com', '25f9e794323b453885f5181f1b624d0b', '8389080183', 'Sabanci', 'Tuzla', 'U'),
(3, 'berke', 'ton', 'berke@ymail.com', '25f9e794323b453885f5181f1b624d0b', '1234567899', '234fsvsdfv', 'sfvgdfvbdvb', 'U'),
(4, 'Man', 'Man', 'wowow@gmail.thy', '202cb962ac59075b964b07152d234b70', '1234567891', 'Home', 'World', 'U'),
(5, 'berke', 'berke', 'berke@mail.com', '202cb962ac59075b964b07152d234b70', '1234567891', 'asd', 'asd', 'U'),
(8, 'Product', 'Manager', 'pm@team16.com', 'e807f1fcf82d132f9bb018ca6738a19f', '5339255123', 'Okul', 'Sabanci', 'U');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`brand_id`);

--
-- Tablo için indeksler `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`cat_id`);

--
-- Tablo için indeksler `comments`
--
ALTER TABLE `comments`
  ADD KEY `product_id` (`product_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Tablo için indeksler `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Tablo için indeksler `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Tablo için indeksler `user_info`
--
ALTER TABLE `user_info`
  ADD PRIMARY KEY (`user_id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `brands`
--
ALTER TABLE `brands`
  MODIFY `brand_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;
--
-- Tablo için AUTO_INCREMENT değeri `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- Tablo için AUTO_INCREMENT değeri `categories`
--
ALTER TABLE `categories`
  MODIFY `cat_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- Tablo için AUTO_INCREMENT değeri `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- Tablo için AUTO_INCREMENT değeri `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;
--
-- Tablo için AUTO_INCREMENT değeri `user_info`
--
ALTER TABLE `user_info`
  MODIFY `user_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user_info` (`user_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
