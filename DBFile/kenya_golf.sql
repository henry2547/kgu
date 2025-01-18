-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 29, 2024 at 04:37 PM
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
-- Database: `kenya_golf`
--

-- --------------------------------------------------------

--
-- Table structure for table `available_tees`
--

CREATE TABLE `available_tees` (
  `id` int(11) NOT NULL,
  `tee_name` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `available_tees`
--

INSERT INTO `available_tees` (`id`, `tee_name`, `description`) VALUES
(1, 'Red Tee', 'Beginner tee designed for shorter distances and easier play.'),
(2, 'Blue Tee', 'Intermediate tee offering moderate distance and challenge.'),
(3, 'White Tee', 'Advanced tee for longer distances and higher difficulty.'),
(4, 'Gold Tee', 'Professional tee providing the longest distances and maximum challenge.'),
(5, 'Green Tee', 'Standard tee used by most players.'),
(6, 'Silver Tee', 'Tee designed for senior players with reduced length.'),
(7, 'Black Tee', 'Championship tee used in tournaments for maximum challenge.'),
(8, 'Yellow Tee', 'Ladies tee offering reduced distance and challenge.'),
(9, 'Orange Tee', 'Junior tee with the shortest distance and easier play.'),
(10, 'Purple Tee', 'Tee used for specific handicap categories with tailored distance.');

-- --------------------------------------------------------

--
-- Table structure for table `awards`
--

CREATE TABLE `awards` (
  `awardId` int(11) NOT NULL,
  `typeId` int(11) DEFAULT NULL,
  `resultId` int(11) DEFAULT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `claim_award` varchar(50) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `awardType`
--

CREATE TABLE `awardType` (
  `typeId` int(11) NOT NULL,
  `awardName` text NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `awardType`
--

INSERT INTO `awardType` (`typeId`, `awardName`, `date`) VALUES
(1, 'First position', '2024-07-16'),
(2, 'Second position', '2024-07-16'),
(3, 'Third position', '2024-07-16');

-- --------------------------------------------------------

--
-- Table structure for table `booktee`
--

CREATE TABLE `booktee` (
  `bookingId` int(11) NOT NULL,
  `golferId` int(11) NOT NULL,
  `teeId` int(11) NOT NULL,
  `BookedHoles` int(11) NOT NULL,
  `Statement` text DEFAULT NULL,
  `isPaid` varchar(50) NOT NULL DEFAULT 'unpaid',
  `bookingDate` datetime NOT NULL DEFAULT current_timestamp(),
  `BookingStatus` varchar(50) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booktee`
--

INSERT INTO `booktee` (`bookingId`, `golferId`, `teeId`, `BookedHoles`, `Statement`, `isPaid`, `bookingDate`, `BookingStatus`) VALUES
(1, 1, 1, 10, '<p>Approved to play!</p>\r\n', 'paid', '2024-07-28 18:21:15', 'approved');

-- --------------------------------------------------------

--
-- Table structure for table `booktournament`
--

CREATE TABLE `booktournament` (
  `bookId` int(11) NOT NULL,
  `tournamentId` int(11) NOT NULL,
  `golferId` int(11) NOT NULL,
  `clubId` int(11) NOT NULL,
  `Statement` text DEFAULT NULL,
  `bookingDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `BookingStatus` varchar(50) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booktournament`
--

INSERT INTO `booktournament` (`bookId`, `tournamentId`, `golferId`, `clubId`, `Statement`, `bookingDate`, `BookingStatus`) VALUES
(1, 1, 1, 1, '<p>Approved to play!</p>\r\n', '2024-07-17 10:22:26', 'approved'),
(2, 1, 2, 2, '<p>Approved to play!</p>\r\n', '2024-07-18 10:11:33', 'approved');

-- --------------------------------------------------------

--
-- Table structure for table `clubs`
--

CREATE TABLE `clubs` (
  `clubId` int(11) NOT NULL,
  `ClubName` varchar(255) NOT NULL,
  `region` varchar(255) NOT NULL,
  `district` varchar(255) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clubs`
--

INSERT INTO `clubs` (`clubId`, `ClubName`, `region`, `district`, `date`) VALUES
(1, 'Kirinyaga Golf Club', 'Central Region', 'Kirinyaga', '2024-07-14'),
(2, 'Naivasha Golf Club', 'Rift Valley Region', 'Naivasha', '2024-07-16'),
(3, 'Nairobi Golf Club', 'Nairobi Region', 'Embakasi West', '2024-07-16');

-- --------------------------------------------------------

--
-- Table structure for table `coach`
--

CREATE TABLE `coach` (
  `coachId` int(11) NOT NULL,
  `golferId` int(11) NOT NULL,
  `comments` text NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `coach`
--

INSERT INTO `coach` (`coachId`, `golferId`, `comments`, `date`) VALUES
(1, 1, '<ol>\r\n	<li>Check on how to position your shoulder.</li>\r\n	<li>Check on your swing.</li>\r\n</ol>\r\n', '2024-07-28');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `feedbackId` int(11) NOT NULL,
  `golferId` int(11) NOT NULL,
  `message_to` varchar(50) NOT NULL,
  `Message` text NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `golfer`
--

CREATE TABLE `golfer` (
  `golferId` int(11) NOT NULL,
  `clubId` int(11) NOT NULL,
  `FirstName` varchar(50) NOT NULL,
  `SecondName` varchar(50) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Phone` varchar(20) NOT NULL,
  `Address` varchar(255) NOT NULL,
  `Gender` varchar(50) NOT NULL,
  `Password` char(40) NOT NULL,
  `RegistrationDate` date NOT NULL DEFAULT current_timestamp(),
  `GolferStatus` varchar(50) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `golfer`
--

INSERT INTO `golfer` (`golferId`, `clubId`, `FirstName`, `SecondName`, `Email`, `Phone`, `Address`, `Gender`, `Password`, `RegistrationDate`, `GolferStatus`) VALUES
(1, 1, 'Henry', 'Muchiri', 'henrynjue@gmail.com', '0757641234', 'Kirinyaga', 'male', '7c4a8d09ca3762af61e59520943dc26494f8941b', '2024-07-14', 'approved'),
(2, 2, 'Ann', 'Muthoni', 'annmuthoni@gmail.com', '0763528478', 'Naivasha', 'female', '7c4a8d09ca3762af61e59520943dc26494f8941b', '2024-07-16', 'approved');

-- --------------------------------------------------------

--
-- Table structure for table `golf_tools`
--

CREATE TABLE `golf_tools` (
  `kitId` int(11) NOT NULL,
  `supplyId` varchar(50) NOT NULL DEFAULT 'Supply100',
  `tool_name` varchar(50) NOT NULL,
  `kit_quantity` int(10) NOT NULL DEFAULT 100,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `golf_tools`
--

INSERT INTO `golf_tools` (`kitId`, `supplyId`, `tool_name`, `kit_quantity`, `date`) VALUES
(2, 'Supply100', 'Golf balls', 100, '2024-07-17 02:34:44'),
(3, 'Supply100', 'Golf tees', 100, '2024-07-22 02:34:44'),
(4, 'Supply100', 'Golf gloves', 114, '2024-07-13 02:34:44'),
(5, 'Supply100', 'Golf shoes', 149, '2024-07-16 02:34:44'),
(6, 'Supply100', 'Golf bag', 100, '2024-07-16 02:34:44'),
(7, 'Supply100', 'Golf umbrella', 100, '2024-07-20 02:34:44'),
(8, 'Supply100', 'Golf towel', 100, '2024-07-20 02:34:44'),
(9, 'Supply100', 'Golf hat', 100, '2024-07-26 02:34:44'),
(10, 'Supply100', 'Golf rangefinder', 100, '2024-07-18 02:34:44');

-- --------------------------------------------------------

--
-- Table structure for table `matches`
--

CREATE TABLE `matches` (
  `matchId` int(11) NOT NULL,
  `clubId1` int(11) NOT NULL,
  `clubId2` int(11) NOT NULL,
  `matchStatus` varchar(50) NOT NULL DEFAULT 'pending',
  `matchDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `matches`
--

INSERT INTO `matches` (`matchId`, `clubId1`, `clubId2`, `matchStatus`, `matchDate`) VALUES
(1, 1, 2, 'playing', '2024-07-28 15:02:56');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `paymentId` int(11) NOT NULL,
  `golferId` int(11) NOT NULL,
  `PaymentCode` varchar(50) NOT NULL,
  `Amount` decimal(10,2) NOT NULL,
  `mode_payment` varchar(50) NOT NULL,
  `Statement` text DEFAULT NULL,
  `PaymentDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `paymentStatus` varchar(255) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`paymentId`, `golferId`, `PaymentCode`, `Amount`, `mode_payment`, `Statement`, `PaymentDate`, `paymentStatus`) VALUES
(1, 1, 'E3Y38S6SGH', 1190.00, 'Mpesa', '<p>Paid!</p>\r\n', '2024-07-28 15:27:26', 'approved');

-- --------------------------------------------------------

--
-- Table structure for table `replies`
--

CREATE TABLE `replies` (
  `replyid` int(11) NOT NULL,
  `feedbackId` int(11) NOT NULL,
  `message_reply` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `requested_kit`
--

CREATE TABLE `requested_kit` (
  `requestId` int(11) NOT NULL,
  `kitId` int(11) NOT NULL,
  `quantity` int(10) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `isUpdated` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `requested_kit`
--

INSERT INTO `requested_kit` (`requestId`, `kitId`, `quantity`, `date`, `isUpdated`) VALUES
(1, 4, 14, '2024-07-26 02:49:48', 1),
(2, 5, 49, '2024-07-28 14:47:01', 1);

-- --------------------------------------------------------

--
-- Table structure for table `results`
--

CREATE TABLE `results` (
  `resultId` int(11) NOT NULL,
  `matchId` int(11) DEFAULT NULL,
  `clubId1` int(11) DEFAULT NULL,
  `clubId2` int(11) DEFAULT NULL,
  `resultDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `saveSupply`
--

CREATE TABLE `saveSupply` (
  `supplyId` int(11) NOT NULL,
  `requestId` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `payment` int(11) NOT NULL DEFAULT 0,
  `mode_payment` varchar(50) DEFAULT NULL,
  `comments` text DEFAULT NULL,
  `code` varchar(10) DEFAULT NULL,
  `supPayment` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `saveSupply`
--

INSERT INTO `saveSupply` (`supplyId`, `requestId`, `quantity`, `amount`, `date`, `payment`, `mode_payment`, `comments`, `code`, `supPayment`) VALUES
(1, 1, 14, 6900, '2024-07-26 03:47:25', 1, 'Mpesa', 'Paid!', 'EYU43B3BNR', 1),
(2, 2, 49, 4000, '2024-07-28 14:47:22', 1, 'Mpesa', 'Paid', 'T3KJS900SN', 1);

-- --------------------------------------------------------

--
-- Table structure for table `teetime`
--

CREATE TABLE `teetime` (
  `teeId` int(11) NOT NULL,
  `Image` varchar(255) DEFAULT NULL,
  `availableTeeId` int(10) NOT NULL,
  `Description` text NOT NULL,
  `NumberOfHoles` int(11) NOT NULL,
  `Price` int(11) NOT NULL,
  `uploadDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `TeeStatus` varchar(50) NOT NULL DEFAULT 'approved'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teetime`
--

INSERT INTO `teetime` (`teeId`, `Image`, `availableTeeId`, `Description`, `NumberOfHoles`, `Price`, `uploadDate`, `TeeStatus`) VALUES
(1, 'download (1).jpeg', 1, 'This is the description of the Red Tee time', 90, 119, '2024-07-24 11:16:02', 'approved'),
(2, 'download (2).jpeg', 2, 'This is the description of the blue tee', 90, 129, '2024-07-28 12:47:22', 'approved'),
(3, 'download (5).jpeg', 3, 'This is the description of the above tee time.', 99, 170, '2024-07-29 09:20:25', 'approved'),
(4, 'download.jpeg', 7, 'This is the description of the above tee time.', 59, 90, '2024-07-29 09:21:02', 'approved'),
(5, 'download (6).jpeg', 8, 'description about the Yellow tee.', 100, 189, '2024-07-29 09:22:22', 'approved');

-- --------------------------------------------------------

--
-- Table structure for table `tournament`
--

CREATE TABLE `tournament` (
  `tournmentId` int(11) NOT NULL,
  `TournamentName` varchar(100) NOT NULL,
  `TournamentVenue` varchar(255) NOT NULL,
  `StartDate` date NOT NULL,
  `EndDate` date NOT NULL,
  `registrationDeadline` date NOT NULL,
  `Description` text NOT NULL,
  `Prizes` text NOT NULL,
  `CreateAt` datetime NOT NULL DEFAULT current_timestamp(),
  `TournamentStatus` varchar(50) NOT NULL DEFAULT 'approved'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tournament`
--

INSERT INTO `tournament` (`tournmentId`, `TournamentName`, `TournamentVenue`, `StartDate`, `EndDate`, `registrationDeadline`, `Description`, `Prizes`, `CreateAt`, `TournamentStatus`) VALUES
(1, 'Kirinyaga Golf club Tournament', 'Kirinyaga County', '2024-07-18', '2024-07-20', '2024-07-17', 'This is the description of the tournament.', '1. First winner will be awarded Kshs 200,000<br />\r\n2. Second winner to be awarded Kshs 100,000<br />\r\n3. Third winner to be awarded Kshs 50,000', '2024-07-15 12:08:49', 'approved');

-- --------------------------------------------------------

--
-- Table structure for table `tutorials`
--

CREATE TABLE `tutorials` (
  `tutorialId` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tutorials`
--

INSERT INTO `tutorials` (`tutorialId`, `name`, `description`, `date`) VALUES
(1, 'How to Score', '<p>click&nbsp;<a href=\"http://ume254.mystrikingly.com\">here</a>&nbsp;to view on how to score in the golf game.</p>\r\n', '2024-07-21');

-- --------------------------------------------------------

--
-- Table structure for table `userlogin`
--

CREATE TABLE `userlogin` (
  `id` int(11) NOT NULL DEFAULT 0,
  `staffid` varchar(20) NOT NULL,
  `status` varchar(50) NOT NULL,
  `surname` varchar(50) NOT NULL,
  `othernames` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `userlogin`
--

INSERT INTO `userlogin` (`id`, `staffid`, `status`, `surname`, `othernames`, `password`) VALUES
(0, '1001', 'Admin', 'Henry', 'Muchiri', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220'),
(0, 'Award100', 'Award', 'Moh', 'Kinya', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220'),
(0, 'Coach100', 'Coach', 'Amos', 'Njoroge', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220'),
(0, 'Finance100', 'Finance', 'Lucy ', 'Njeri', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220'),
(0, 'Ref100', 'Referee', 'Ann', 'Muthoni', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220'),
(0, 'Supply100', 'Supplier', 'John', 'Muchiri', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220'),
(0, 'Tee100', 'Tee', 'Joy', 'Wanja', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220'),
(0, 'Tourn100', 'Tournament', 'Purity', 'Muthoni', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220'),
(0, 'Tutorial100', 'Tutorial', 'Amos', 'Kariuki', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `available_tees`
--
ALTER TABLE `available_tees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `awards`
--
ALTER TABLE `awards`
  ADD PRIMARY KEY (`awardId`),
  ADD KEY `typeId` (`typeId`),
  ADD KEY `resultId` (`resultId`);

--
-- Indexes for table `awardType`
--
ALTER TABLE `awardType`
  ADD PRIMARY KEY (`typeId`);

--
-- Indexes for table `booktee`
--
ALTER TABLE `booktee`
  ADD PRIMARY KEY (`bookingId`),
  ADD KEY `golferId` (`golferId`),
  ADD KEY `teeId` (`teeId`);

--
-- Indexes for table `booktournament`
--
ALTER TABLE `booktournament`
  ADD PRIMARY KEY (`bookId`),
  ADD KEY `tournamentId` (`tournamentId`),
  ADD KEY `golferId` (`golferId`),
  ADD KEY `clubId` (`clubId`);

--
-- Indexes for table `clubs`
--
ALTER TABLE `clubs`
  ADD PRIMARY KEY (`clubId`);

--
-- Indexes for table `coach`
--
ALTER TABLE `coach`
  ADD PRIMARY KEY (`coachId`),
  ADD KEY `golferId` (`golferId`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`feedbackId`),
  ADD KEY `golferId` (`golferId`);

--
-- Indexes for table `golfer`
--
ALTER TABLE `golfer`
  ADD PRIMARY KEY (`golferId`),
  ADD KEY `clubId` (`clubId`);

--
-- Indexes for table `golf_tools`
--
ALTER TABLE `golf_tools`
  ADD PRIMARY KEY (`kitId`),
  ADD KEY `supplyId` (`supplyId`);

--
-- Indexes for table `matches`
--
ALTER TABLE `matches`
  ADD PRIMARY KEY (`matchId`),
  ADD KEY `clubId1` (`clubId1`),
  ADD KEY `clubId2` (`clubId2`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`paymentId`),
  ADD KEY `golferId` (`golferId`);

--
-- Indexes for table `replies`
--
ALTER TABLE `replies`
  ADD PRIMARY KEY (`replyid`),
  ADD KEY `feedbackId` (`feedbackId`);

--
-- Indexes for table `requested_kit`
--
ALTER TABLE `requested_kit`
  ADD PRIMARY KEY (`requestId`),
  ADD KEY `kitId` (`kitId`);

--
-- Indexes for table `results`
--
ALTER TABLE `results`
  ADD PRIMARY KEY (`resultId`),
  ADD KEY `matchId` (`matchId`);

--
-- Indexes for table `saveSupply`
--
ALTER TABLE `saveSupply`
  ADD PRIMARY KEY (`supplyId`),
  ADD KEY `requestId` (`requestId`);

--
-- Indexes for table `teetime`
--
ALTER TABLE `teetime`
  ADD PRIMARY KEY (`teeId`),
  ADD KEY `availableTeeId` (`availableTeeId`);

--
-- Indexes for table `tournament`
--
ALTER TABLE `tournament`
  ADD PRIMARY KEY (`tournmentId`);

--
-- Indexes for table `tutorials`
--
ALTER TABLE `tutorials`
  ADD PRIMARY KEY (`tutorialId`);

--
-- Indexes for table `userlogin`
--
ALTER TABLE `userlogin`
  ADD PRIMARY KEY (`staffid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `available_tees`
--
ALTER TABLE `available_tees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `awards`
--
ALTER TABLE `awards`
  MODIFY `awardId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `awardType`
--
ALTER TABLE `awardType`
  MODIFY `typeId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `booktee`
--
ALTER TABLE `booktee`
  MODIFY `bookingId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `booktournament`
--
ALTER TABLE `booktournament`
  MODIFY `bookId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `clubs`
--
ALTER TABLE `clubs`
  MODIFY `clubId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `coach`
--
ALTER TABLE `coach`
  MODIFY `coachId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `feedbackId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `golfer`
--
ALTER TABLE `golfer`
  MODIFY `golferId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `golf_tools`
--
ALTER TABLE `golf_tools`
  MODIFY `kitId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `matches`
--
ALTER TABLE `matches`
  MODIFY `matchId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `paymentId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `replies`
--
ALTER TABLE `replies`
  MODIFY `replyid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `requested_kit`
--
ALTER TABLE `requested_kit`
  MODIFY `requestId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `results`
--
ALTER TABLE `results`
  MODIFY `resultId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `saveSupply`
--
ALTER TABLE `saveSupply`
  MODIFY `supplyId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `teetime`
--
ALTER TABLE `teetime`
  MODIFY `teeId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tournament`
--
ALTER TABLE `tournament`
  MODIFY `tournmentId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tutorials`
--
ALTER TABLE `tutorials`
  MODIFY `tutorialId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `awards`
--
ALTER TABLE `awards`
  ADD CONSTRAINT `awards_ibfk_1` FOREIGN KEY (`typeId`) REFERENCES `awardType` (`typeId`),
  ADD CONSTRAINT `awards_ibfk_2` FOREIGN KEY (`resultId`) REFERENCES `results` (`resultId`);

--
-- Constraints for table `booktee`
--
ALTER TABLE `booktee`
  ADD CONSTRAINT `booktee_ibfk_1` FOREIGN KEY (`golferId`) REFERENCES `golfer` (`golferId`),
  ADD CONSTRAINT `booktee_ibfk_2` FOREIGN KEY (`teeId`) REFERENCES `teetime` (`teeId`);

--
-- Constraints for table `booktournament`
--
ALTER TABLE `booktournament`
  ADD CONSTRAINT `booktournament_ibfk_1` FOREIGN KEY (`tournamentId`) REFERENCES `tournament` (`tournmentId`),
  ADD CONSTRAINT `booktournament_ibfk_2` FOREIGN KEY (`golferId`) REFERENCES `golfer` (`golferId`),
  ADD CONSTRAINT `booktournament_ibfk_3` FOREIGN KEY (`clubId`) REFERENCES `clubs` (`clubId`);

--
-- Constraints for table `coach`
--
ALTER TABLE `coach`
  ADD CONSTRAINT `coach_ibfk_1` FOREIGN KEY (`golferId`) REFERENCES `golfer` (`golferId`);

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`golferId`) REFERENCES `golfer` (`golferId`);

--
-- Constraints for table `golfer`
--
ALTER TABLE `golfer`
  ADD CONSTRAINT `golfer_ibfk_1` FOREIGN KEY (`clubId`) REFERENCES `clubs` (`clubId`);

--
-- Constraints for table `golf_tools`
--
ALTER TABLE `golf_tools`
  ADD CONSTRAINT `golf_tools_ibfk_1` FOREIGN KEY (`supplyId`) REFERENCES `userlogin` (`staffid`);

--
-- Constraints for table `matches`
--
ALTER TABLE `matches`
  ADD CONSTRAINT `matches_ibfk_1` FOREIGN KEY (`clubId1`) REFERENCES `clubs` (`clubId`),
  ADD CONSTRAINT `matches_ibfk_2` FOREIGN KEY (`clubId2`) REFERENCES `clubs` (`clubId`);

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`golferId`) REFERENCES `golfer` (`golferId`);

--
-- Constraints for table `replies`
--
ALTER TABLE `replies`
  ADD CONSTRAINT `replies_ibfk_1` FOREIGN KEY (`feedbackId`) REFERENCES `feedback` (`feedbackId`);

--
-- Constraints for table `requested_kit`
--
ALTER TABLE `requested_kit`
  ADD CONSTRAINT `requested_kit_ibfk_1` FOREIGN KEY (`kitId`) REFERENCES `golf_tools` (`kitId`);

--
-- Constraints for table `results`
--
ALTER TABLE `results`
  ADD CONSTRAINT `results_ibfk_1` FOREIGN KEY (`matchId`) REFERENCES `matches` (`matchId`);

--
-- Constraints for table `saveSupply`
--
ALTER TABLE `saveSupply`
  ADD CONSTRAINT `saveSupply_ibfk_1` FOREIGN KEY (`requestId`) REFERENCES `requested_kit` (`requestId`);

--
-- Constraints for table `teetime`
--
ALTER TABLE `teetime`
  ADD CONSTRAINT `teetime_ibfk_1` FOREIGN KEY (`availableTeeId`) REFERENCES `available_tees` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
