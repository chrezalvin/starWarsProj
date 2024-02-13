-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 13, 2024 at 07:09 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `swapi`
--

-- --------------------------------------------------------

--
-- Table structure for table `films`
--

CREATE TABLE `films` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `director` varchar(100) DEFAULT NULL,
  `producer` varchar(200) DEFAULT NULL,
  `release_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `films`
--

INSERT INTO `films` (`id`, `title`, `director`, `producer`, `release_date`) VALUES
(1, 'A New Hope', 'George Lucas', 'Gary Kurtz, Rick McCallum', '1977-05-25');

-- --------------------------------------------------------

--
-- Table structure for table `people`
--

CREATE TABLE `people` (
  `id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `height` int(11) DEFAULT NULL,
  `mass` int(11) DEFAULT NULL,
  `hair_color` varchar(45) DEFAULT NULL,
  `skin_color` varchar(45) DEFAULT NULL,
  `eye_color` varchar(45) DEFAULT NULL,
  `birth_year` varchar(45) DEFAULT NULL,
  `gender` varchar(45) DEFAULT NULL,
  `homeworld` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `people`
--

INSERT INTO `people` (`id`, `name`, `height`, `mass`, `hair_color`, `skin_color`, `eye_color`, `birth_year`, `gender`, `homeworld`) VALUES
(2, 'C-3PO', 167, 75, 'n/a', 'gold', 'yellow', '112BBY', 'n/a', 1),
(7, 'R2-D2', 96, 32, 'n/a', 'white, blue', 'red', '33BBY', 'n/a', 1),
(8, 'Darth Vader', 202, 136, 'n/a', 'white', 'yellow', '42BBY', 'male', 1),
(9, 'Leia Organa', 150, 49, 'brown', 'light', 'brown', '19BBY', 'female', 2),
(10, 'Owen Lars', 178, 120, 'brown, grey', 'light', 'blue', '52BBY', 'male', 1),
(11, 'Beru Whitesun lars', 165, 75, 'brown', 'light', 'blue', '47BBY', 'female', 1),
(12, 'R5-D4', 97, 32, 'n/a', 'white, red', 'red', '0BBY', 'n/a', 1),
(13, 'Biggs Darklighter', 183, 84, 'black', 'light', 'brown', '24BBY', 'male', 0),
(14, 'Luke Skywalker', 172, 77, 'blond', 'fair', 'blue', '19BBY', 'male', 0);

-- --------------------------------------------------------

--
-- Table structure for table `people_vehicle_lookup`
--

CREATE TABLE `people_vehicle_lookup` (
  `vehicles_id` int(11) NOT NULL,
  `people_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `people_vehicle_lookup`
--

INSERT INTO `people_vehicle_lookup` (`vehicles_id`, `people_id`) VALUES
(10, 14),
(11, 14);

-- --------------------------------------------------------

--
-- Stand-in structure for view `people_view`
-- (See below for the actual view)
--
CREATE TABLE `people_view` (
`id` int(11)
,`name` varchar(45)
,`height` int(11)
,`mass` int(11)
,`hair_color` varchar(45)
,`skin_color` varchar(45)
,`eye_color` varchar(45)
,`birth_year` varchar(45)
,`gender` varchar(45)
,`homeworld` varchar(100)
,`homeworld_id` int(11)
);

-- --------------------------------------------------------

--
-- Table structure for table `planets`
--

CREATE TABLE `planets` (
  `name` varchar(100) NOT NULL,
  `rotation_period` int(11) DEFAULT NULL,
  `orbital_period` int(11) DEFAULT NULL,
  `id` int(11) NOT NULL,
  `diameter` int(11) DEFAULT NULL,
  `climate` varchar(100) DEFAULT NULL,
  `gravity` varchar(100) DEFAULT NULL,
  `terrain` varchar(100) DEFAULT NULL,
  `surface_water` int(11) DEFAULT NULL,
  `population` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `planets`
--

INSERT INTO `planets` (`name`, `rotation_period`, `orbital_period`, `id`, `diameter`, `climate`, `gravity`, `terrain`, `surface_water`, `population`) VALUES
('Dummy', NULL, NULL, 0, NULL, 'n/a', 'n/a', 'n/a', NULL, NULL),
('Tatooine', 23, 304, 1, 10465, 'arid', '1 standard', 'desert', 1, 200000),
('Alderaan', 24, 364, 2, 12500, 'temperate', '1 standard', 'grasslands, mountains', 40, 2000000000),
('Yavin IV', 24, 4818, 3, 10200, 'temperate, tropical', '1 standard', 'jungle, rainforests', 8, 1000),
('Hoth', 23, 549, 5, 7200, 'frozen', '1.1 standard', 'tundra, ice caves, mountain ranges', 100, NULL),
('Dagobah', 23, 341, 6, 8900, 'murky', NULL, 'swamp, jungles', 8, NULL);

-- --------------------------------------------------------

--
-- Stand-in structure for view `planets_view`
-- (See below for the actual view)
--
CREATE TABLE `planets_view` (
`name` varchar(100)
,`rotation_period` int(11)
,`orbital_period` int(11)
,`id` int(11)
,`diameter` int(11)
,`climate` varchar(100)
,`gravity` varchar(100)
,`terrain` varchar(100)
,`surface_water` int(11)
,`population` int(11)
,`deletable` int(1)
);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(41) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'Chrezalvin', '*6BB4837EB74329105EE4568DDA7DC67ED2CA2AD9');

-- --------------------------------------------------------

--
-- Table structure for table `vehicles`
--

CREATE TABLE `vehicles` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `model` varchar(100) DEFAULT NULL,
  `manufacturer` varchar(100) DEFAULT NULL,
  `length` float DEFAULT NULL,
  `max_atmosphering_speed` int(11) DEFAULT NULL,
  `crew` int(11) DEFAULT NULL,
  `passengers` int(11) DEFAULT NULL,
  `vehicle_class` varchar(100) DEFAULT NULL,
  `cost_in_credits` int(11) DEFAULT NULL,
  `consumables` varchar(100) DEFAULT NULL,
  `cargo_capacity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vehicles`
--

INSERT INTO `vehicles` (`id`, `name`, `model`, `manufacturer`, `length`, `max_atmosphering_speed`, `crew`, `passengers`, `vehicle_class`, `cost_in_credits`, `consumables`, `cargo_capacity`) VALUES
(1, 'TIE Bomber', 'TIE/sa bomber', 'Sienar Fleet Systems', 7, 850, 1, NULL, 'space/planetary bomber', NULL, '2 days', NULL),
(4, 'AT-AT', 'All Terrain Armored Transport', 'Kuat Drive Yards, Imperial Department of Military Research', 20, 60, 5, 40, 'assault walker', NULL, NULL, 1000),
(5, 'AT-ST', 'All Terrain Scout Transport', 'Kuat Drive Yards, Imperial Department of Military Research', 2, 90, 2, NULL, 'walker', NULL, 'none', 200),
(6, 'Storm IV Twin-Pod cloud car', 'Storm IV Twin-Pod', 'Bespin Motors', 7, 1500, 2, NULL, 'repulsorcraft', 75000, '1 day', 10),
(7, 'Sail barge', 'Modified Luxury Sail Barge', 'Ubrikkian Industries Custom Vehicle Division', 30, NULL, NULL, 500, 'sail barge', 285000, 'Live food tanks', 200000),
(8, 'Bantha-II cargo skiff', 'Bantha-II', 'Ubrikkian Industries', 9.5, 250, 5, 16, 'repulsorcraft cargo skiff', 8000, '1 Day', 135000),
(9, 'TIE/IN interceptor', 'Twin Ion Engine Interceptor', 'Sienar Fleet Systems', 9, 1250, 1, NULL, 'starfighter', NULL, '2 days', 75),
(10, 'Imperial Speeder Bike', '74-Z speeder bike', 'Aratech Repulsor Compan', 3, 360, 1, 1, 'speeder', 8000, '1 day', 4),
(11, 'Snowspeeder', 't-47 airspeeder', 'Incom corporation', 4, 650, 2, NULL, 'airspeeder', NULL, NULL, 10);

-- --------------------------------------------------------

--
-- Structure for view `people_view`
--
DROP TABLE IF EXISTS `people_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `people_view`  AS SELECT `pe`.`id` AS `id`, `pe`.`name` AS `name`, `pe`.`height` AS `height`, `pe`.`mass` AS `mass`, `pe`.`hair_color` AS `hair_color`, `pe`.`skin_color` AS `skin_color`, `pe`.`eye_color` AS `eye_color`, `pe`.`birth_year` AS `birth_year`, `pe`.`gender` AS `gender`, `pl`.`name` AS `homeworld`, `pl`.`id` AS `homeworld_id` FROM (`people` `pe` join `planets` `pl`) WHERE `pe`.`homeworld` = `pl`.`id` ;

-- --------------------------------------------------------

--
-- Structure for view `planets_view`
--
DROP TABLE IF EXISTS `planets_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `planets_view`  AS SELECT `pl`.`name` AS `name`, `pl`.`rotation_period` AS `rotation_period`, `pl`.`orbital_period` AS `orbital_period`, `pl`.`id` AS `id`, `pl`.`diameter` AS `diameter`, `pl`.`climate` AS `climate`, `pl`.`gravity` AS `gravity`, `pl`.`terrain` AS `terrain`, `pl`.`surface_water` AS `surface_water`, `pl`.`population` AS `population`, if((select count(0) from `people` `pe` where `pe`.`homeworld` = `pl`.`id`) > 0,1,0) AS `deletable` FROM `planets` AS `pl` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `films`
--
ALTER TABLE `films`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `people`
--
ALTER TABLE `people`
  ADD PRIMARY KEY (`id`),
  ADD KEY `homeworld` (`homeworld`);

--
-- Indexes for table `people_vehicle_lookup`
--
ALTER TABLE `people_vehicle_lookup`
  ADD KEY `v_id_fk` (`vehicles_id`),
  ADD KEY `p_id_fk` (`people_id`);

--
-- Indexes for table `planets`
--
ALTER TABLE `planets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `films`
--
ALTER TABLE `films`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `people`
--
ALTER TABLE `people`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `planets`
--
ALTER TABLE `planets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `people`
--
ALTER TABLE `people`
  ADD CONSTRAINT `homeworld_fk` FOREIGN KEY (`homeworld`) REFERENCES `planets` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `people_vehicle_lookup`
--
ALTER TABLE `people_vehicle_lookup`
  ADD CONSTRAINT `p_id_fk` FOREIGN KEY (`people_id`) REFERENCES `people` (`id`),
  ADD CONSTRAINT `v_id_fk` FOREIGN KEY (`vehicles_id`) REFERENCES `vehicles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
