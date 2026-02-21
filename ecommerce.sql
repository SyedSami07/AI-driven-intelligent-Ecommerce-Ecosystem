-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 25, 2026 at 03:51 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ecommerce`
--

-- --------------------------------------------------------

--
-- Table structure for table `add_logo`
--

CREATE TABLE `add_logo` (
  `id` int(10) NOT NULL,
  `img` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `add_logo`
--

INSERT INTO `add_logo` (`id`, `img`) VALUES
(2, 'logo.png');

-- --------------------------------------------------------

--
-- Table structure for table `admin_info`
--

CREATE TABLE `admin_info` (
  `admin_id` int(11) NOT NULL,
  `admin_email` varchar(60) NOT NULL,
  `admin_pass` varchar(60) NOT NULL,
  `role` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_info`
--

INSERT INTO `admin_info` (`admin_id`, `admin_email`, `admin_pass`, `role`) VALUES
(5, 'syedsami.connect@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 1),
(8, 'mod@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 2),
(9, 'admin@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 1);

-- --------------------------------------------------------

--
-- Stand-in structure for view `all_order_info`
-- (See below for the actual view)
--
CREATE TABLE `all_order_info` (
`order_id` int(255)
,`product_name` varchar(255)
,`pdt_quantity` int(11)
,`amount` int(11)
,`uses_coupon` varchar(35)
,`customer_name` varchar(60)
,`Shipping_mobile` varchar(20)
,`trans_id` varchar(25)
,`shiping_address` varchar(255)
,`order_status` int(3)
,`order_time` timestamp
,`order_date` date
);

-- --------------------------------------------------------

--
-- Table structure for table `catagory`
--

CREATE TABLE `catagory` (
  `ctg_id` int(11) NOT NULL,
  `ctg_name` varchar(60) NOT NULL,
  `ctg_des` varchar(150) NOT NULL,
  `ctg_status` tinyint(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `catagory`
--

INSERT INTO `catagory` (`ctg_id`, `ctg_name`, `ctg_des`, `ctg_status`) VALUES
(12, 'Daily Essentials', 'The foundation of a healthy home. Fresh, versatile fruits like apples and bananas, delivered daily for your family’s routine nutrition', 1),
(13, 'Summer Mix', 'Stay refreshed and hydrated naturally. Explore our juicy selection of melons and grapes, perfect for summer cooling and revitalizing snacks', 1),
(14, 'Healthy Choice', 'Small in size, big on benefits. A powerhouse collection of antioxidant-rich berries and vitamin-packed fruits to fuel your wellness journey.', 0),
(15, 'High Value', 'Experience the extraordinary. Discover our premium gallery of exotic imports and luxury dried fruits, hand-selected for the finest quality and taste.', 1);

-- --------------------------------------------------------

--
-- Table structure for table `chat_messages`
--

CREATE TABLE `chat_messages` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_bullying` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `cupon`
--

CREATE TABLE `cupon` (
  `cupon_id` int(11) NOT NULL,
  `cupon_code` varchar(25) NOT NULL,
  `description` varchar(255) NOT NULL,
  `discount` int(5) NOT NULL,
  `status` int(2) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cupon`
--

INSERT INTO `cupon` (`cupon_id`, `cupon_code`, `description`, `discount`, `status`) VALUES
(4, 'NEUB26', 'NEUB26', 26, 0),
(9, 'bd50', 'bd50', 50, 1);

-- --------------------------------------------------------

--
-- Table structure for table `customer_feedback`
--

CREATE TABLE `customer_feedback` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `pdt_id` int(11) NOT NULL,
  `comment` varchar(255) NOT NULL,
  `comment_date` date NOT NULL,
  `ai_status` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer_feedback`
--

INSERT INTO `customer_feedback` (`id`, `user_id`, `user_name`, `pdt_id`, `comment`, `comment_date`, `ai_status`) VALUES
(67, 30, 'Sami', 25, 'Oranges are juicy, refreshing, and packed with vitamin C, making them a healthy and delicious choice', '2026-01-22', 0),
(86, 30, 'Sami', 22, 'this is a nice banana', '2026-01-23', 0),
(87, 30, 'Sami', 22, 'বালের প্রোডাক্ট ', '2026-01-23', 1),
(88, 30, 'Sami', 28, 'ভালো প্রোডাক্ট ', '2026-01-24', 1),
(89, 30, 'Sami', 28, 'তর মায়রে পুটকি মারি  ', '2026-01-24', 1),
(90, 30, 'Sami', 28, 'this is a nice banana', '2026-01-24', 0);

-- --------------------------------------------------------

--
-- Table structure for table `header_info`
--

CREATE TABLE `header_info` (
  `id` int(10) NOT NULL,
  `email` varchar(30) NOT NULL,
  `tweeter` varchar(500) NOT NULL,
  `fb_link` varchar(500) NOT NULL,
  `pinterest` varchar(500) NOT NULL,
  `phone` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `header_info`
--

INSERT INTO `header_info` (`id`, `email`, `tweeter`, `fb_link`, `pinterest`, `phone`) VALUES
(10, 'fruid@gmail.com', 'https://Instagram.com/', 'https://facebook.com/', 'https://www.youtube.com/', '01303968132');

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `order_id` int(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `pdt_quantity` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `uses_coupon` varchar(35) NOT NULL,
  `order_status` int(3) NOT NULL,
  `trans_id` varchar(25) NOT NULL,
  `Shipping_mobile` varchar(20) NOT NULL,
  `shiping` varchar(255) NOT NULL,
  `order_time` timestamp NULL DEFAULT current_timestamp(),
  `order_date` date DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`order_id`, `user_id`, `product_name`, `pdt_quantity`, `amount`, `uses_coupon`, `order_status`, `trans_id`, `Shipping_mobile`, `shiping`, `order_time`, `order_date`) VALUES
(50, 8, 'Bananna', 1, 60, '', 3, '54', '75544', 'syl', '2026-01-19 18:09:25', '2026-01-20'),
(51, 8, 'Lemon', 1, 70, '', 3, '4', '75544', 'syl', '2026-01-19 18:14:30', '2026-01-20'),
(52, 8, 'Apple', 1, 250, '', 2, '424', '75544', 'syl', '2026-01-19 18:23:45', '2026-01-20'),
(53, 8, 'Pears', 1, 40, '', 3, '54', '75544', 'syl', '2026-01-19 18:25:46', '2026-01-20'),
(54, 8, 'Malton', 1, 120, '', 2, '545', '75544', 'syl', '2026-01-19 18:36:23', '2026-01-20'),
(55, 8, 'Malton', 1, 120, '', 2, '54', '75544', 'syl', '2026-01-19 18:44:53', '2026-01-20'),
(56, 8, 'Apple', 1, 250, '', 3, '54', '75544', 'syl', '2026-01-19 18:44:53', '2026-01-20'),
(57, 30, 'Banana', 1, 60, 'bd50', 2, '50005000', '01303968132', 'sheikhghat, sylhet', '2026-01-21 19:15:59', '2026-01-22'),
(58, 30, 'Apple', 1, 250, '', 0, '54', '01303968132', 'sheikhghat, sylhet', '2026-01-21 19:37:15', '2026-01-22');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `pdt_id` int(255) NOT NULL,
  `pdt_name` varchar(200) NOT NULL,
  `pdt_price` int(255) NOT NULL,
  `pdt_des` varchar(250) NOT NULL,
  `pdt_ctg` int(200) NOT NULL,
  `pdt_img` varchar(250) NOT NULL,
  `product_stock` int(5) NOT NULL,
  `pdt_calorie` int(11) DEFAULT 0,
  `pdt_status` tinyint(5) NOT NULL,
  `calories` int(11) DEFAULT 50,
  `color_hex` varchar(7) DEFAULT '#ffcc00',
  `is_creamy` tinyint(1) DEFAULT 0,
  `flavor_profile` enum('Sweet','Sour','Creamy','Fresh') DEFAULT 'Sweet',
  `pdt_diet_type` varchar(50) DEFAULT 'General'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`pdt_id`, `pdt_name`, `pdt_price`, `pdt_des`, `pdt_ctg`, `pdt_img`, `product_stock`, `pdt_calorie`, `pdt_status`, `calories`, `color_hex`, `is_creamy`, `flavor_profile`, `pdt_diet_type`) VALUES
(21, 'Bananna', 60, 'Indulge in the creamy richness of our Bananna, perfect for a quick energy boost or a delicious addition to your daily meals. With its high potassium content and smooth texture, this delectable fruit is a treasure trove of health benefits. Enjoy it on', 11, '1768567144_bananna.jpg', 5, 0, 1, 50, '#ffcc00', 0, 'Sweet', 'General'),
(22, 'Banana', 60, 'Indulge in the sweetness of life with our premium Bananas, carefully hand-picked from the sun-kissed orchards of the tropics. Rich in potassium, vitamins, and minerals, our Bananas are the perfect snack to fuel your active lifestyle. With their velve', 12, '1768568061_bananna.jpg', 5, 0, 1, 50, '#ffcc00', 0, 'Sweet', 'General'),
(23, 'Apple', 250, 'Indulge in the crunchy sweetness of a perfectly ripened apple, bursting with juicy flavor and packed with nutrients to fuel your active lifestyle. Our apples are carefully hand-picked from the finest orchards to ensure the highest quality and taste. ', 12, '1768568131_apple.jpg', 12, 0, 1, 50, '#ffcc00', 0, 'Sweet', 'General'),
(24, 'Pears', 40, 'Savor the sweetness of life with our succulent pears, carefully handpicked from the finest orchards to bring a burst of juicy flavor to your senses. Rich in antioxidants and fiber, they\'re not only a treat for your taste buds but also a healthy addit', 12, '1768568244_pears.jpg', 5, 0, 1, 50, '#ffcc00', 0, 'Sweet', 'General'),
(25, 'Oranges', 300, 'Indulge in the sweet, succulent taste of nature\'s candy, freshly harvested from the finest orchards. Our juicy oranges burst with vibrant flavor, a symphony of citrus and sunshine in every bite. Rich in vitamin C and antioxidants, they boost your imm', 12, '1768568334_Orange.jpg', 20, 0, 1, 50, '#ffcc00', 0, 'Sweet', 'General'),
(26, 'Lemon', 70, 'Imagine the invigorating zing of a freshly squeezed lemon, bursting with sunshine and citrusy charm. Our lemons are hand-picked at the peak of ripeness to ensure the perfect balance of sweetness and tartness. Rich in vitamin C and antioxidants, they\'', 12, 'Lemon.jpg', 6, 0, 1, 50, '#ffcc00', 0, 'Sweet', 'General'),
(27, 'Malton', 120, 'Imagine sinking into plush comfort with every step, the softness enveloping your feet in serene tranquility. Introducing Malton, expertly crafted to redefine the art of footwear. With its supple leather upper and plush insole, Malton cradles your fee', 12, '1768568453_Malton.jpg', 30, 0, 1, 50, '#ffcc00', 0, 'Sweet', 'General'),
(28, 'Watermelon', 350, 'Indulge in the sweetest summer treat that\'s refreshing, revitalizing, and bursting with juicy goodness. Our premium watermelon is hand-picked from the finest farms to bring you the crispest texture and most refreshing taste. Rich in vitamin C and ant', 13, '1768568530_Watermelon.jpg', 20, 0, 1, 50, '#ffcc00', 0, 'Sweet', 'General'),
(29, 'Cantaloupe', 220, 'Indulge in the sweet haven of summer with our succulent cantaloupe, bursting with juicy flavor and nutrients. Its vibrant orange flesh is infused with a hint of musky undertones, creating a taste experience that\'s both refreshing and revitalizing. Ri', 13, '1768568613_Cantaloupe.jpg', 20, 0, 1, 50, '#ffcc00', 0, 'Sweet', 'General'),
(30, 'Graphes Green', 280, 'Experience the ultimate fusion of style and sustainability with Graphes Green, an extraordinary new product that\'s about to revolutionize the way you live, work, and interact with the world around you. This innovative masterpiece seamlessly blends fo', 13, '1768568689_Graphes Green.jpg', 5, 0, 1, 50, '#ffcc00', 0, 'Sweet', 'General'),
(31, 'Graphes Black', 230, 'Imagine sinking into a world of sleek sophistication with every step. Graphes Black embodies refined elegance, its premium materials and timeless design effortlessly elevating your style. Whether you\'re dressing up or dressing down, this versatile sh', 13, '1768568751_Graphes Black.jpg', 5, 0, 1, 50, '#ffcc00', 0, 'Sweet', 'General'),
(32, 'Graphes Red', 235, 'Experience the vibrant fusion of style and substance with Graphes Red, a revolutionary product that redefines the boundaries of innovation. With its sleek design and exceptional performance, this stunning creation elevates your daily life to new heig', 13, '1768568797_Graphes Red.jpg', 5, 0, 1, 50, '#ffcc00', 0, 'Sweet', 'General'),
(34, 'Mangoes', 250, 'Indulge in the succulent sweetness of our premium mangoes, carefully selected from the finest orchards to bring you an unparalleled snacking experience. Rich in vitamins A and C, potassium, and fiber, our mangoes not only tantalize your taste buds bu', 13, '1768568865_Mangoes.jpg', 30, 0, 1, 50, '#ffcc00', 0, 'Sweet', 'General'),
(35, 'Strawberries', 290, 'Indulge in the sweetest summer treat, carefully selected to bring you the most delectable flavor and unparalleled freshness. Our succulent strawberries are picked at the peak of ripeness, ensuring every bite is bursting with juicy sweetness and a hin', 14, '1768568926_Strawberries.jpg', 5, 0, 1, 50, '#ffcc00', 0, 'Sweet', 'General'),
(36, 'Blueberries', 400, 'Indulge in the sweet and tangy delight of our premium blueberries, carefully hand-picked to ensure the perfect blend of flavor and nutrition. With their vibrant purple hue and burst of juicy goodness, you\'ll be hooked from the very first bite. Rich i', 14, '1768568970_Blueberries.jpg', 4, 0, 1, 50, '#ffcc00', 0, 'Sweet', 'General'),
(37, 'Papaya', 50, 'Indulge in the vibrant taste of sunshine with our Papaya, a luscious tropical fruit renowned for its exceptional health benefits and mouthwatering sweetness. Rich in vitamins A and C, potassium, and antioxidants, our Papaya is the perfect snack to no', 14, '1768569013_Papaya.jpg', 5, 0, 1, 50, '#ffcc00', 0, 'Sweet', 'General'),
(38, 'Guava', 40, 'Indulge your senses in the sweet and tangy taste of our Guava, carefully handpicked from the lush orchards of tropical paradises. With its vibrant orange hue and juicy pulp, this succulent fruit is not only a feast for the eyes but also a treasure tr', 14, '1768569054_Guava.jpg', 8, 0, 1, 50, '#ffcc00', 0, 'Sweet', 'General'),
(39, 'Pomegranates', 90, 'Unlock the juicy secrets of the world\'s most coveted superfood. Pomegranates are a symphony of flavors, bursting with the sweetness of paradise. Rich in antioxidants and packed with vitamins, this crimson gem is a powerhouse of health and wellness. D', 14, '1768569091_Pomegranates.jpg', 20, 0, 1, 50, '#ffcc00', 0, 'Sweet', 'General'),
(40, 'Dragon fruit', 260, 'Indulge in the vibrant taste and unparalleled nutrition of dragon fruit, a tropical superfood bursting with flavor and antioxidants. With its vibrant pink skin and juicy white flesh, this exotic gem is packed with vitamins C and B2, potassium, and fi', 15, '1768569133_Dragon fruit.jpg', 20, 0, 1, 50, '#ffcc00', 0, 'Sweet', 'General'),
(41, 'Kiwi', 160, 'Imagine the burst of vibrant flavor in every bite, as the sweetness of the kiwi harmoniously balances the tanginess in your mouth. Our kiwis are carefully hand-picked from lush orchards, ensuring the perfect blend of juiciness and crunch in every pie', 15, '1768569183_Kiwi.jpg', 20, 0, 1, 50, '#ffcc00', 0, 'Sweet', 'General'),
(42, 'Avocado', 300, 'Indulge in the creamy richness of nature\'s perfect superfood. Plump, ripe avocados are a haven for the senses, bursting with velvety texture and deep, nutty flavors that elevate any dish. Packed with essential nutrients and healthy fats, they\'re a gu', 15, '1768569236_Avocado.jpg', 2, 0, 1, 50, '#ffcc00', 0, 'Sweet', 'General'),
(43, 'Dates', 400, 'Indulge in the succulent sweetness of nature\'s candy, meticulously crafted to provide a burst of energy and flavor in every bite. Our premium dates are carefully selected to ensure the perfect balance of sweetness and chewiness. Rich in antioxidants,', 15, '1768569292_Dates.jpg', 5, 0, 1, 50, '#ffcc00', 0, 'Sweet', 'General'),
(45, 'Nuts', 1100, 'Indulge in the rich flavors and crunch of our handpicked Nuts, carefully selected to elevate your snacking experience. Our premium selection includes a diverse range of varieties, from the buttery taste of almonds to the nutty goodness of walnuts. No', 15, '1768569372_Nuts.jpg', 5, 0, 1, 50, '#ffcc00', 0, 'Sweet', 'General');

-- --------------------------------------------------------

--
-- Stand-in structure for view `product_info_ctg`
-- (See below for the actual view)
--
CREATE TABLE `product_info_ctg` (
`pdt_id` int(255)
,`pdt_name` varchar(200)
,`pdt_price` int(255)
,`pdt_des` varchar(250)
,`pdt_img` varchar(250)
,`product_stock` int(5)
,`pdt_status` tinyint(5)
,`ctg_id` int(11)
,`ctg_name` varchar(60)
);

-- --------------------------------------------------------

--
-- Table structure for table `slider`
--

CREATE TABLE `slider` (
  `slider_id` int(11) NOT NULL,
  `first_line` varchar(255) NOT NULL,
  `second_line` varchar(255) NOT NULL,
  `third_line` varchar(255) NOT NULL,
  `btn_left` varchar(25) NOT NULL,
  `btn_right` varchar(25) NOT NULL,
  `slider_img` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `slider`
--

INSERT INTO `slider` (`slider_id`, `first_line`, `second_line`, `third_line`, `btn_left`, `btn_right`, `slider_img`) VALUES
(1, 'Farm-Fresh Fruits Delivered', 'Handpicked Daily for Maximum Freshness', 'Taste the natural sweetness you deserve', 'Shop now', 'View lookbook', 'green-slide-01.jpg'),
(2, 'Pomegranate', 'Orange 100% Organic', 'A blend of freshly squeezed green apple & fruits', 'Shop now', 'View lookbook', 'green-slide-02.jpg'),
(3, 'Pomegranate', 'Banana 100% Organic', 'A blend of freshly squeezed green apple & fruits', 'Shop now', 'View lookbook', 'green-slide-01.jpg'),
(4, 'Pomegranate', 'Apple 100% Organic', 'A blend of freshly squeezed green apple & fruits', 'Shop now', 'View lookbook', 'green-slide-02.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(6) NOT NULL,
  `user_name` varchar(60) NOT NULL,
  `user_firstname` varchar(60) NOT NULL,
  `user_lastname` varchar(60) NOT NULL,
  `user_email` varchar(60) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `v_token` varchar(255) DEFAULT NULL,
  `v_status` tinyint(1) DEFAULT 0,
  `user_mobile` int(11) NOT NULL,
  `user_address` varchar(255) NOT NULL,
  `user_roles` tinyint(4) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `verification_code` varchar(255) DEFAULT NULL,
  `is_verified` tinyint(1) DEFAULT 0,
  `v_created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_firstname`, `user_lastname`, `user_email`, `user_password`, `v_token`, `v_status`, `user_mobile`, `user_address`, `user_roles`, `created_at`, `modified_at`, `verification_code`, `is_verified`, `v_created_at`) VALUES
(30, 'Sami', 'syed salman', 'sami', 'syedsami.connect@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', NULL, 1, 1303968132, 'sheikhghat, sylhet', 5, '2026-01-21 18:45:20', '2026-01-21 18:45:20', NULL, 0, '2026-01-21 18:45:20');

-- --------------------------------------------------------

--
-- Table structure for table `user_address`
--

CREATE TABLE `user_address` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_address` varchar(100) NOT NULL,
  `postal_code` varchar(8) NOT NULL,
  `city` varchar(25) NOT NULL,
  `country` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_payment`
--

CREATE TABLE `user_payment` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `payment_type` varchar(20) NOT NULL,
  `provider` varchar(35) NOT NULL,
  `account_no` int(11) DEFAULT NULL,
  `expiry` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure for view `all_order_info`
--
DROP TABLE IF EXISTS `all_order_info`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `all_order_info`  AS SELECT `order_details`.`order_id` AS `order_id`, `order_details`.`product_name` AS `product_name`, `order_details`.`pdt_quantity` AS `pdt_quantity`, `order_details`.`amount` AS `amount`, `order_details`.`uses_coupon` AS `uses_coupon`, `users`.`user_firstname` AS `customer_name`, `order_details`.`Shipping_mobile` AS `Shipping_mobile`, `order_details`.`trans_id` AS `trans_id`, `order_details`.`shiping` AS `shiping_address`, `order_details`.`order_status` AS `order_status`, `order_details`.`order_time` AS `order_time`, `order_details`.`order_date` AS `order_date` FROM (`order_details` join `users`) WHERE `users`.`user_id` = `order_details`.`user_id` ;

-- --------------------------------------------------------

--
-- Structure for view `product_info_ctg`
--
DROP TABLE IF EXISTS `product_info_ctg`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `product_info_ctg`  AS SELECT `products`.`pdt_id` AS `pdt_id`, `products`.`pdt_name` AS `pdt_name`, `products`.`pdt_price` AS `pdt_price`, `products`.`pdt_des` AS `pdt_des`, `products`.`pdt_img` AS `pdt_img`, `products`.`product_stock` AS `product_stock`, `products`.`pdt_status` AS `pdt_status`, `catagory`.`ctg_id` AS `ctg_id`, `catagory`.`ctg_name` AS `ctg_name` FROM (`products` join `catagory`) WHERE `products`.`pdt_ctg` = `catagory`.`ctg_id` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `add_logo`
--
ALTER TABLE `add_logo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_info`
--
ALTER TABLE `admin_info`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `catagory`
--
ALTER TABLE `catagory`
  ADD PRIMARY KEY (`ctg_id`);

--
-- Indexes for table `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cupon`
--
ALTER TABLE `cupon`
  ADD PRIMARY KEY (`cupon_id`);

--
-- Indexes for table `customer_feedback`
--
ALTER TABLE `customer_feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `header_info`
--
ALTER TABLE `header_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`pdt_id`);

--
-- Indexes for table `slider`
--
ALTER TABLE `slider`
  ADD PRIMARY KEY (`slider_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_name` (`user_name`),
  ADD UNIQUE KEY `user_email` (`user_email`);

--
-- Indexes for table `user_address`
--
ALTER TABLE `user_address`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_payment`
--
ALTER TABLE `user_payment`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `add_logo`
--
ALTER TABLE `add_logo`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `admin_info`
--
ALTER TABLE `admin_info`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `catagory`
--
ALTER TABLE `catagory`
  MODIFY `ctg_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `chat_messages`
--
ALTER TABLE `chat_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `cupon`
--
ALTER TABLE `cupon`
  MODIFY `cupon_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `customer_feedback`
--
ALTER TABLE `customer_feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `header_info`
--
ALTER TABLE `header_info`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `order_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `pdt_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `slider`
--
ALTER TABLE `slider`
  MODIFY `slider_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `user_address`
--
ALTER TABLE `user_address`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_payment`
--
ALTER TABLE `user_payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
