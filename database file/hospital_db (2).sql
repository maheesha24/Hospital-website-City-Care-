-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 24, 2024 at 09:08 PM
-- Server version: 8.3.0
-- PHP Version: 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hospital_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

DROP TABLE IF EXISTS `appointments`;
CREATE TABLE IF NOT EXISTS `appointments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `specialization` varchar(100) NOT NULL,
  `doctor` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `age` int NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `appointment_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `specialization`, `doctor`, `name`, `phone`, `email`, `age`, `gender`, `appointment_date`) VALUES
(1, 'General Practitioner', '4', 'J.K.P Maheesha Sandesh', '0762863425', 'maheeshasandesh126@gmail.com', 52, 'Male', '2024-11-21 14:25:41'),
(2, 'General Practitioner', '4', 'J.K.P Maheesha Sandesh', '0762863425', 'maheeshasandesh126@gmail.com', 52, 'Male', '2024-11-21 15:25:46'),
(3, 'General Practitioner', '4', 'J.K.P Maheesha Sandesh', '0762863425', 'maheeshasandesh126@gmail.com', 52, 'Male', '2024-11-21 16:08:13'),
(4, 'General Practitioner', '4', 'J.K.P Maheesha Sandesh', '0762863425', 'maheeshasandesh126@gmail.com', 52, 'Male', '2024-11-21 16:12:01'),
(5, 'General Practitioner', '4', 'J.K.P Maheesha Sandesh', '0762863425', 'maheeshasandesh126@gmail.com', 52, 'Male', '2024-11-21 16:14:18'),
(6, 'General Practitioner', '4', 'J.K.P Maheesha Sandesh', '0762863425', 'maheeshasandesh126@gmail.com', 52, 'Female', '2024-11-21 16:20:51'),
(7, 'General Practitioner', '4', 'J.K.P Maheesha Sandesh', '0762863425', 'maheeshasandesh126@gmail.com', 52, 'Female', '2024-11-21 16:25:42'),
(8, 'General Practitioner', '4', 'J.K.P Maheesha Sandesh', '0762863425', 'maheeshasandesh126@gmail.com', 52, 'Female', '2024-11-21 16:25:49'),
(9, 'General Practitioner', 'test02', 'J.K.P Maheesha Sandesh', '0762863425', 'maheeshasandesh126@gmail.com', 52, 'Female', '2024-11-21 16:36:48'),
(10, 'General Practitioner', 'test02', 'J.K.P Maheesha Sandesh', '0762863425', 'maheeshasandesh126@gmail.com', 52, 'Female', '2024-11-21 16:37:30'),
(11, 'General Practitioner', 'test02', 'J.K.P Maheesha Sandesh', '0762863425', 'maheeshasandesh126@gmail.com', 52, 'Female', '2024-11-21 16:37:40'),
(12, 'General Practitioner', 'test02', 'J.K.P Maheesha Sandesh', '0762863425', 'maheeshasandesh126@gmail.com', 52, 'Female', '2024-11-21 16:40:49'),
(13, 'General Practitioner', 'test02', 'J.K.P Maheesha Sandesh', '0762863425', 'maheeshasandesh126@gmail.com', 52, 'Female', '2024-11-21 16:42:25'),
(14, 'General Practitioner', 'test02', 'J.K.P Maheesha Sandesh', '0762863425', 'maheeshasandesh126@gmail.com', 52, 'Female', '2024-11-21 16:45:29'),
(15, 'General Practitioner', 'test02', 'J.K.P Maheesha Sandesh', '0762863425', 'maheeshasandesh126@gmail.com', 52, 'Other', '2024-11-21 17:02:50'),
(16, 'General Practitioner', 'test02', 'J.K.P Maheesha Sandesh', '0762863425', 'maheeshasandesh126@gmail.com', 52, 'Female', '2024-11-22 14:58:51');

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

DROP TABLE IF EXISTS `blogs`;
CREATE TABLE IF NOT EXISTS `blogs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `author` varchar(100) NOT NULL,
  `date_created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `image_path` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `checkout_details`
--

DROP TABLE IF EXISTS `checkout_details`;
CREATE TABLE IF NOT EXISTS `checkout_details` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `quantity` int NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `shipping_cost` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `order_date` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

DROP TABLE IF EXISTS `contact_messages`;
CREATE TABLE IF NOT EXISTS `contact_messages` (
  `id` int NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text,
  `reply` text,
  `status` enum('Pending','Replied') DEFAULT 'Pending',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `email`, `phone`, `subject`, `message`, `reply`, `status`, `created_at`) VALUES
(2, 'J.K.P Maheesha Sandesh', 'maheeshasandesh126@gmail.com', '0762863425', 'General Inquiry', 'This is a test one for test case', 'TEST 01', 'Replied', '2024-11-24 19:12:38'),
(3, 'J.K.P Maheesha Sandesh', 'maheeshasandesh126@gmail.com', '0762863425', 'General Inquiry', 'THIS IS A TEST ONE FOR TEST CASE', NULL, 'Pending', '2024-11-24 19:13:10');

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

DROP TABLE IF EXISTS `doctors`;
CREATE TABLE IF NOT EXISTS `doctors` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `specialization` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `bio` text NOT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `reg_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `qualifications` varchar(255) DEFAULT NULL,
  `experience` int DEFAULT NULL,
  `languages` varchar(100) DEFAULT NULL,
  `about_me` text,
  `status` enum('active','inactive') DEFAULT 'active',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`id`, `name`, `specialization`, `email`, `bio`, `profile_image`, `reg_date`, `qualifications`, `experience`, `languages`, `about_me`, `status`) VALUES
(6, ' Dr. Maheesha sandesh', 'Cardiologist', 'maheeshasandesh126@gmail.com', 'Dr. Maheesha sandesh is a renowned cardiologist with over 10 years of experience treating complex cardiac conditions. He is passionate about improving patients\' lives through personalized care.\"', 'uploads/profile_images/User_icon_2.svg.png', '2024-11-24 20:36:22', 'MBBS, MD (Cardiology)', 15, 'Sinhala ,Engllish', 'I am dedicated to providing the highest standard of medical care to all my patients. My mission is to ensure their well-being and promote healthy lifestyles.\"', 'active'),
(7, 'Dr. Maneesha Maduwanthi', 'Obstetrician and Gynecologist', 'maneeshammc@gmail.com', 'Dr. Maneesha Maduwanthi is a highly experienced Obstetrician and Gynecologist specializing in prenatal care, high-risk pregnancies, and women’s reproductive health. With over 12 years of experience, she is committed to ensuring the health and well-being of her patients at every stage of life.\"', 'uploads/profile_images/User_icon_2.svg.png', '2024-11-24 20:44:54', 'MBBS, MS (Obstetrics and Gynecology)\r\nFellowship in Maternal-Fetal Medicine', 7, 'Sinhala ,Engllish', '\"As a dedicated Obstetrician and Gynecologist, I believe in empowering women through education and comprehensive healthcare. I strive to provide a safe and caring environment for all my patients.', 'active'),
(9, 'Dr. Sahan Jayanidu', 'General Practitioner', 'Sahanjayanidu@gmail.com', 'Dr. Michael Carter is an experienced Otolaryngologist specializing in the diagnosis and treatment of ear, nose, and throat disorders. With over 10 years of experience, he is dedicated to helping patients improve their quality of life through effective treatments and personalized care.', 'uploads/profile_images/User_icon_2.svg.png', '2024-11-24 20:48:18', 'MBBS, MS (ENT)\r\nFellowship in Head and Neck Surgery', 12, 'Sinhala ,Engllish', 'I am committed to providing comprehensive care for my patients, addressing a wide range of ENT concerns, from hearing loss to sinus issues. My goal is to ensure that every patient feels heard, comfortable, and confident in their treatment.', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `doctor_qualifications`
--

DROP TABLE IF EXISTS `doctor_qualifications`;
CREATE TABLE IF NOT EXISTS `doctor_qualifications` (
  `id` int NOT NULL AUTO_INCREMENT,
  `doctor_id` int DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `doctor_id` (`doctor_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `doctor_schedule`
--

DROP TABLE IF EXISTS `doctor_schedule`;
CREATE TABLE IF NOT EXISTS `doctor_schedule` (
  `id` int NOT NULL AUTO_INCREMENT,
  `doctor_id` int DEFAULT NULL,
  `day` enum('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday') DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `availability` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `doctor_id` (`doctor_id`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `doctor_schedule`
--

INSERT INTO `doctor_schedule` (`id`, `doctor_id`, `day`, `start_time`, `end_time`, `availability`) VALUES
(29, 4, 'Tuesday', '22:41:00', '22:42:00', 0),
(26, 2, 'Tuesday', '02:32:00', '00:35:00', 1),
(28, 4, 'Monday', '22:37:00', '22:40:00', 1),
(27, 4, 'Tuesday', '22:15:00', '22:17:00', 1),
(30, 1, 'Wednesday', '12:52:00', '00:54:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

DROP TABLE IF EXISTS `faqs`;
CREATE TABLE IF NOT EXISTS `faqs` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `question` varchar(255) NOT NULL,
  `answer` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_postings`
--

DROP TABLE IF EXISTS `job_postings`;
CREATE TABLE IF NOT EXISTS `job_postings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `location` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `deadline` date NOT NULL,
  `qualifications` text NOT NULL,
  `job_type` varchar(50) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `job_postings`
--

INSERT INTO `job_postings` (`id`, `title`, `location`, `description`, `deadline`, `qualifications`, `job_type`, `file_path`) VALUES
(8, 'Registered Nurse', 'city care hospital,matara', 'City Care Hospital is seeking a compassionate and experienced Registered Nurse (RN) to join our dynamic healthcare team. As an RN, you will be responsible for providing direct patient care, administering medications, and collaborating with doctors and other healthcare professionals to ensure the well-being of patients. The ideal candidate will have strong communication skills, attention to detail, and a commitment to high-quality patient care.', '2024-11-30', 'Current RN license At least 2 years of clinical experience in a hospital setting BLS (Basic Life Support) certification Excellent communication and interpersonal skills Ability to work effectively in a fast-paced environment', 'Full Time', '');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `full_name` varchar(255) DEFAULT NULL,
  `address` text,
  `city` varchar(100) DEFAULT NULL,
  `postal_code` varchar(20) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL,
  `shipping` decimal(10,2) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('Pending','Shipped','Canceled') DEFAULT 'Pending',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `full_name`, `address`, `city`, `postal_code`, `country`, `phone`, `subtotal`, `shipping`, `total`, `created_at`, `status`) VALUES
(1, 'J.K.P Maheesha Sandesh', 'no.2/2 gajanayaka gama gedara mulanyaya middeniya', 'middeniya', '82270', 'Sri Lanka', '0762863425', 5400.00, 500.00, 5900.00, '2024-11-24 13:18:21', 'Pending'),
(2, 'J.K.P Maheesha Sandesh', 'no.2/2 gajanayaka gama gedara mulanyaya middeniya', 'middeniya', '82270', 'Sri Lanka', '0762863425', 0.00, 500.00, 500.00, '2024-11-24 13:20:20', 'Pending'),
(3, 'J.K.P Maheesha Sandesh', 'no.2/2 gajanayaka gama gedara mulanyaya middeniya', 'middeniya', '82270', 'Sri Lanka', '0762863425', 1800.00, 500.00, 2300.00, '2024-11-24 13:20:46', 'Pending'),
(4, 'J.K.P Maheesha Sandesh', 'no.2/2 gajanayaka gama gedara mulanyaya middeniya', 'middeniya', '82270', 'Sri Lanka', '0762863425', 5400.00, 500.00, 5900.00, '2024-11-24 13:27:24', 'Canceled'),
(5, 'J.K.P Maheesha Sandesh', 'no.2/2 gajanayaka gama gedara mulanyaya middeniya', 'middeniya', '82270', 'Sri Lanka', '0762863425', 1800.00, 500.00, 2300.00, '2024-11-24 13:37:43', 'Canceled'),
(6, 'J.K.P Maheesha Sandesh', 'no.2/2 gajanayaka gama gedara mulanyaya middeniya', 'middeniya', '82270', 'Sri Lanka', '0762863425', 1800.00, 500.00, 2300.00, '2024-11-24 13:42:06', 'Canceled'),
(7, 'J.K.P Maheesha Sandesh', 'no.2/2 gajanayaka gama gedara mulanyaya middeniya', 'middeniya', '82270', 'Sri Lanka', '0762863425', 1800.00, 500.00, 2300.00, '2024-11-24 13:42:56', 'Shipped'),
(8, 'J.K.P Maheesha Sandesh', 'no.2/2 gajanayaka gama gedara mulanyaya middeniya', 'middeniya', '82270', 'Sri Lanka', '0762863425', 1800.00, 500.00, 2300.00, '2024-11-24 13:45:26', 'Shipped'),
(9, 'J.K.P Maheesha Sandesh', 'no.2/2 gajanayaka gama gedara mulanyaya middeniya', 'middeniya', '82270', 'Sri Lanka', '0762863425', 1800.00, 500.00, 2300.00, '2024-11-24 13:47:10', 'Shipped'),
(10, 'J.K.P Maheesha Sandesh', 'no.2/2 gajanayaka gama gedara mulanyaya middeniya', 'middeniya', '82270', 'Sri Lanka', '0762863425', 1800.00, 500.00, 2300.00, '2024-11-24 13:50:02', 'Shipped'),
(11, 'J.K.P Maheesha Sandesh', 'no.2/2 gajanayaka gama gedara mulanyaya middeniya', 'middeniya', '82270', 'Sri Lanka', '0762863425', 12600.00, 500.00, 13100.00, '2024-11-24 13:50:28', 'Shipped'),
(12, 'J.K.P Maheesha Sandesh', 'no.2/2 gajanayaka gama gedara mulanyaya middeniya', 'middeniya', '82270', 'Sri Lanka', '0762863425', 12600.00, 500.00, 13100.00, '2024-11-24 13:52:34', 'Shipped'),
(13, 'J.K.P Maheesha Sandesh', 'no.2/2 gajanayaka gama gedara mulanyaya middeniya', 'middeniya', '82270', 'Sri Lanka', '0762863425', 12600.00, 500.00, 13100.00, '2024-11-24 13:57:31', 'Shipped'),
(14, 'J.K.P Maheesha Sandesh', 'no.2/2 gajanayaka gama gedara mulanyaya middeniya', 'middeniya', '82270', 'Sri Lanka', '0762863425', 12600.00, 500.00, 13100.00, '2024-11-24 13:59:05', 'Shipped'),
(15, 'J.K.P Maheesha Sandesh', 'no.2/2 gajanayaka gama gedara mulanyaya middeniya', 'middeniya', '82270', 'Sri Lanka', '0762863425', 1800.00, 500.00, 2300.00, '2024-11-24 19:07:25', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
CREATE TABLE IF NOT EXISTS `order_items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_id` int DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `quantity` int DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_name`, `quantity`, `price`, `total`, `created_at`) VALUES
(1, 1, 'Cufloc-A COUGH SYRUP', 3, 1800.00, NULL, '2024-11-24 13:18:21'),
(2, 3, 'Cufloc-A COUGH SYRUP', 1, 1800.00, NULL, '2024-11-24 13:20:46'),
(3, 4, 'Cufloc-A COUGH SYRUP', 3, 1800.00, NULL, '2024-11-24 13:27:24'),
(4, 5, 'Cufloc-A COUGH SYRUP', 1, 1800.00, NULL, '2024-11-24 13:37:43'),
(5, 6, 'Cufloc-A COUGH SYRUP', 1, 1800.00, NULL, '2024-11-24 13:42:06'),
(6, 7, 'Cufloc-A COUGH SYRUP', 1, 1800.00, NULL, '2024-11-24 13:42:56'),
(7, 8, 'Cufloc-A COUGH SYRUP', 1, 1800.00, NULL, '2024-11-24 13:45:26'),
(8, 9, 'Cufloc-A COUGH SYRUP', 1, 1800.00, NULL, '2024-11-24 13:47:10'),
(9, 10, 'Cufloc-A COUGH SYRUP', 1, 1800.00, NULL, '2024-11-24 13:50:02'),
(10, 11, 'Cufloc-A COUGH SYRUP', 7, 1800.00, NULL, '2024-11-24 13:50:28'),
(11, 12, 'Cufloc-A COUGH SYRUP', 7, 1800.00, NULL, '2024-11-24 13:52:34'),
(12, 13, 'Cufloc-A COUGH SYRUP', 7, 1800.00, NULL, '2024-11-24 13:57:31'),
(13, 14, 'Cufloc-A COUGH SYRUP', 7, 1800.00, NULL, '2024-11-24 13:59:05'),
(14, 15, 'Cufloc-A COUGH SYRUP', 1, 1800.00, NULL, '2024-11-24 19:07:25');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `image`) VALUES
(12, 'Cufloc-A COUGH SYRUP', 1800.00, 'uploads/CUFLOC-A-SYP.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
CREATE TABLE IF NOT EXISTS `reviews` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `review` text NOT NULL,
  `rating` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('pending','accepted','rejected','deleted') DEFAULT 'pending',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `user_id`, `review`, `rating`, `created_at`, `status`) VALUES
(26, 53, 'THIS IS  A TEST REVIEW FOR TEST CASE', 3, '2024-11-23 18:38:10', 'accepted'),
(27, 53, 'THIS IS  A TEST REVIEW FOR TEST CASE', 3, '2024-11-23 18:40:36', 'pending'),
(28, 59, 'THIS IS TEST ONE FOR TEST CASE', 3, '2024-11-24 19:16:26', 'accepted'),
(29, 59, 'TEST 01 2', 3, '2024-11-24 19:17:18', 'accepted'),
(30, 59, 'TEST 01 2', 3, '2024-11-24 19:18:26', 'pending'),
(31, 59, 'TEST 01 2', 3, '2024-11-24 19:18:42', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `role` varchar(30) NOT NULL,
  `name` varchar(100) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `address` text NOT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `reg_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` enum('active','inactive') DEFAULT 'active',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=60 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role`, `name`, `first_name`, `last_name`, `phone`, `address`, `profile_picture`, `email`, `password`, `reg_date`, `status`) VALUES
(58, 'Admin', 'J.K.P Maheesha Sandesh', '', '', '', '', NULL, 'maheeshasandesh126@gmail.com', '$2y$10$42gzxNqo6nLiw46ASPCx2evNGxTwG/V4kSDqPUuoGgD4ofLl3dOey', '2024-11-23 19:16:44', 'active'),
(59, 'patient', 'maneesha', 'maneesha', 'maduwanthi', '0762863425', 'no.2/2 gajanayaka gama gedara mulanyaya middeniya', 'uploads/User_icon_2.svg.png', 'manee1@gmail.com', '$2y$10$Dr0P1jylfSh7XIfA6/WWE.kUElL6po5NbS60y6z8KKyipv3O86d3u', '2024-11-23 19:24:12', 'active'),
(50, 'patient', 'J.K.P Maheesha Sandesh', '', '', '', '', NULL, 'maheesha619@gmail.com', '$2y$10$P1t8gAsHeWhfLhoJY4SQ7.h/bSUAjeqpKKqGMUA0LZs1E8BBiQzv2', '2024-11-22 14:47:10', 'active'),
(52, 'patient', 'maneesha', '', '', '', '', NULL, 'maneeshammc@gmail.com', '$2y$10$d4g9g08p58M1ZwxytDNB1O.ubr2Zs4Mfz4LPlaEUM1/fD9ct87Lfu', '2024-11-23 08:33:45', 'active'),
(38, 'patient', 'AS', 'amila', 'pransanna', '0718208067', 'Amila Embroider Panamura road,Middeniya', 'uploads/IMG_20220128_074436.jpg', 'amilaemb@gmail.com', '$2y$10$Yvdg7mrWG5ZOFEdasQ9scOW97U8p97oo4ScvVp1kCEQk4I.ewpugi', '2024-09-29 19:45:40', 'active'),
(46, 'Admin', 'J.K.P Maheesha Sandesh', '', '', '', '', NULL, 'gmsahanj2002@gmail.com', '$2y$10$25JQdFlsH8Bq7SmWgLZRj.3S8yxAlym2Bndo3zXPZLxQnXq1DOG7S', '2024-10-13 06:07:47', 'active'),
(51, 'Staff', 'maheesha', '', '', '', '', NULL, 'pathiranagepr60@gmail.com', '$2y$10$M44X0Qd44CrQF8NHVCcQVeR/sVWsXZ7coSi.q.5oroyES3Gr3MNz.', '2024-11-22 19:12:10', 'active'),
(48, 'Admin', 'deloosha ', '', '', '', '', NULL, 'deloosha@icbtcampus.edu.lk', '$2y$10$PMBjcTNWmtIx4NSOIBaHO.6CuktSc0kT291gaYUWXiS6WGjWsLob.', '2024-11-20 04:44:29', 'active'),
(49, 'Admin', 'deloosha ', '', '', '', '', NULL, 'deloosha@yahoo.com', '$2y$10$5ndJD3kWWpcYhW5JKa6LT.hqT6.P1G78KLHXDz5xx0j8wu1ooNLeS', '2024-11-20 04:46:02', 'active');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
