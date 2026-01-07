-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 05, 2026 at 02:06 PM
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
-- Database: `myvax_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `history`
--

CREATE TABLE `history` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `username_input` varchar(255) DEFAULT NULL,
  `income` decimal(10,2) DEFAULT NULL,
  `tax` decimal(10,2) DEFAULT NULL,
  `net_salary` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `employee_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_croatian_ci;

--
-- Dumping data for table `history`
--

INSERT INTO `history` (`id`, `user_id`, `username_input`, `income`, `tax`, `net_salary`, `created_at`, `employee_name`) VALUES
(48, 4, NULL, 350000.00, 35000.00, 314250.00, '2025-11-11 16:14:02', NULL),
(61, 6, NULL, 35000.00, 3500.00, 30750.00, '2025-10-31 17:00:00', NULL),
(62, 6, NULL, 3500.00, 0.00, 3325.00, '2025-11-29 17:00:00', NULL),
(63, 6, NULL, 45000.00, 4500.00, 39750.00, '2025-12-30 17:00:00', NULL),
(64, 6, NULL, 15000.00, 1500.00, 12750.00, '2025-10-30 17:00:00', NULL),
(65, 6, NULL, 22000.00, 2200.00, 19050.00, '2025-09-29 17:00:00', NULL),
(66, 6, NULL, 67000.00, 6700.00, 59550.00, '2025-08-30 17:00:00', NULL),
(67, 6, NULL, 67000.00, 6700.00, 59550.00, '2025-08-30 17:00:00', NULL),
(68, 6, NULL, 67000.00, 6700.00, 59550.00, '2025-08-30 17:00:00', NULL),
(69, 6, NULL, 67000.00, 6700.00, 59550.00, '2025-08-30 17:00:00', NULL),
(70, 6, NULL, 17000.00, 1700.00, 14550.00, '2025-11-29 17:00:00', NULL),
(71, 6, NULL, 15000.00, 1500.00, 12750.00, '2025-11-29 17:00:00', NULL),
(90, 7, NULL, 60000.00, 6000.00, 53250.00, '2025-12-30 17:00:00', NULL),
(91, 7, NULL, 45800.00, 4580.00, 40470.00, '2025-11-29 17:00:00', NULL),
(92, 7, NULL, 36000.00, 3600.00, 31650.00, '2025-10-29 17:00:00', NULL),
(93, NULL, NULL, NULL, NULL, NULL, '2025-12-11 07:39:53', NULL),
(99, 9, NULL, 56000.00, 5600.00, 49650.00, '2025-12-30 17:00:00', NULL),
(100, 3, NULL, 12000.00, 0.00, 11400.00, '2026-01-30 17:00:00', NULL),
(101, 3, NULL, 14800.00, 0.00, 14060.00, '2026-02-27 17:00:00', NULL),
(102, 3, NULL, 15700.00, 785.00, 14165.00, '2026-01-30 17:00:00', NULL),
(103, 3, NULL, 15700.00, 1570.00, 13380.00, '2026-01-30 17:00:00', NULL),
(104, 3, NULL, 15700.00, 1570.00, 13380.00, '2026-01-30 17:00:00', NULL),
(105, 3, NULL, 15700.00, 1570.00, 13380.00, '2026-01-30 17:00:00', NULL),
(106, 3, NULL, 15700.00, 1570.00, 13380.00, '2026-01-30 17:00:00', NULL),
(107, 3, NULL, 15700.00, 1570.00, 13380.00, '2026-01-30 17:00:00', NULL),
(108, 3, NULL, 12900.00, 0.00, 12630.00, '0000-00-00 00:00:00', NULL),
(109, 3, NULL, 12900.00, 0.00, 12630.00, '2026-01-30 17:00:00', NULL),
(110, 3, NULL, 12900.00, 645.00, 11985.00, '0000-00-00 00:00:00', NULL),
(111, 3, NULL, 12900.00, 645.00, 11985.00, '0000-00-00 00:00:00', NULL),
(112, 3, NULL, 0.00, 0.00, 0.00, '0000-00-00 00:00:00', NULL),
(113, 3, NULL, 0.00, 0.00, 0.00, '0000-00-00 00:00:00', NULL),
(114, 3, NULL, 0.00, 0.00, 0.00, '0000-00-00 00:00:00', NULL),
(115, 3, NULL, 15000.00, 1500.00, 13050.00, '0000-00-00 00:00:00', NULL),
(116, 3, NULL, 15000.00, 1500.00, 12750.00, '2026-01-30 17:00:00', NULL),
(117, 3, NULL, 15000.00, 1500.00, 12750.00, '2026-01-30 17:00:00', NULL),
(118, 3, NULL, 15000.00, 1500.00, 12750.00, '0000-00-00 00:00:00', NULL),
(119, 3, NULL, 15000.00, 750.00, 13500.00, '2026-01-30 17:00:00', NULL),
(120, 3, NULL, 15000.00, 750.00, 13500.00, '2026-01-30 17:00:00', NULL),
(121, 3, NULL, 15000.00, 750.00, 13500.00, '2026-01-30 17:00:00', NULL),
(122, 3, NULL, 15000.00, 750.00, 13500.00, '2026-01-30 17:00:00', NULL),
(123, 3, NULL, 15000.00, 750.00, 13500.00, '2026-01-30 17:00:00', NULL),
(124, 3, NULL, 15000.00, 750.00, 13500.00, '2026-01-30 17:00:00', NULL),
(125, 3, NULL, 15000.00, 750.00, 13500.00, '2026-01-30 17:00:00', NULL),
(126, 3, NULL, 15000.00, 750.00, 13500.00, '2026-01-30 17:00:00', NULL),
(127, 3, NULL, 35000.00, 3500.00, 30750.00, '2026-01-29 17:00:00', NULL),
(128, 3, NULL, 15400.00, 770.00, 13880.00, '2026-01-30 17:00:00', NULL),
(129, 3, NULL, 11000.00, 0.00, 10450.00, '2026-02-26 17:00:00', NULL),
(130, 3, NULL, 14000.00, 700.00, 12600.00, '2026-01-30 17:00:00', NULL),
(131, 3, NULL, 14000.00, 700.00, 12600.00, '2026-01-30 17:00:00', NULL),
(132, 3, NULL, 14000.00, 700.00, 12600.00, '2026-01-30 17:00:00', NULL),
(133, 3, NULL, 14000.00, 700.00, 12600.00, '2026-01-30 17:00:00', NULL),
(134, 3, NULL, 14000.00, 700.00, 12600.00, '2026-01-30 17:00:00', NULL),
(135, 10, NULL, 12000.00, 0.00, 11400.00, '2026-01-30 17:00:00', NULL),
(136, 10, NULL, 14500.00, 725.00, 13050.00, '2026-02-27 17:00:00', NULL),
(137, 10, NULL, 9400.00, 0.00, 8930.00, '2026-03-30 17:00:00', NULL),
(138, 10, NULL, 45000.00, 6750.00, 37500.00, '2026-01-30 17:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `role` enum('admin','user') DEFAULT 'user',
  `avatar` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_croatian_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`, `role`, `avatar`) VALUES
(1, 'sudarat kanpian', NULL, '$2y$10$CWrWSRz3IbfAjw75EugwF.zIvJi0yaPxcN87BFXRopyF46NAktm5.', '2025-11-05 06:49:04', 'user', NULL),
(3, 'Chanapon', NULL, '$2y$10$KiIQt3wiRRIuEsXeZP1yz.9GJdP8SyKkG/L6GELfx3XJmMOmOt8hK', '2025-11-05 11:20:34', 'admin', NULL),
(4, 'ton', NULL, '$2y$10$rk46VcIGChHBMNF.Qcw9quq8aUzD8iQoISR0OS/awu4K6bWz2sMau', '2025-11-11 16:03:17', 'user', NULL),
(5, 'su', NULL, '$2y$10$MasHe4.hBmuNfGki7UdNcemmNAs/O31pXK2RHog6XYZtxblj8IfZ2', '2025-11-11 16:13:47', 'user', NULL),
(6, 'fai', NULL, '$2y$10$mMniLAgvg34n6JdkajXJP.sLpHi4g/0eKIX9gsRSC6RjtLonjRjTy', '2025-11-12 05:59:07', 'user', NULL),
(7, 'บิ๊ก', NULL, '$2y$10$ky94z.kxMcGh8GZu/TAUS.vixGyzjbFXV/5Gg54sDZTnJClp8xNeS', '2025-12-11 06:59:24', 'user', NULL),
(8, 'lll', NULL, '$2y$10$qzxheeWOhZNsRumUUDmXEOkeb0NzMK3nmOR4B8jBwDtlnQ1mkiqhy', '2025-12-25 14:34:01', 'user', NULL),
(9, 'got', NULL, '$2y$10$6OY83OOo0n/ycp2.GHt1guNRVV639zsZWlUYyH7M0PNozFFEoepqa', '2025-12-29 08:32:52', 'user', NULL),
(10, 'สุดารัตน์', 'sudaratkanpian23@gmail.com', '$2y$10$g85bq0KlYWSnB3lTBBnBEOuOxI.7U9StjgIghhzsZE3tlVWc8wwF6', '2026-01-04 14:56:44', 'user', 'uploads/695bac675ee3f.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `history`
--
ALTER TABLE `history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=139;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `history`
--
ALTER TABLE `history`
  ADD CONSTRAINT `history_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
