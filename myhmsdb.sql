-- phpMyAdmin SQL Dump — Patel Hospitals HMS
-- Fixed version: added doctb PK, payment default, prestb index

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+05:30";

CREATE DATABASE IF NOT EXISTS `myhmsdb` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `myhmsdb`;

-- --------------------------------------------------------
-- Table: admintb
-- --------------------------------------------------------
DROP TABLE IF EXISTS `admintb`;
CREATE TABLE `admintb` (
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `admintb` VALUES ('admin','admin123');

-- --------------------------------------------------------
-- Table: doctb  (FIX: added id PK, was missing in original)
-- --------------------------------------------------------
DROP TABLE IF EXISTS `doctb`;
CREATE TABLE `doctb` (
  `id`       int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL DEFAULT '',
  `email`    varchar(50) NOT NULL DEFAULT '',
  `spec`     varchar(50) NOT NULL DEFAULT 'General',
  `docFees`  int(10) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `doctb` (`username`,`password`,`email`,`spec`,`docFees`) VALUES
('ashok',  'ashok123',  'ashok@gmail.com',  'General',      500),
('arun',   'arun123',   'arun@gmail.com',   'Cardiologist', 600),
('Dinesh', 'dinesh123', 'dinesh@gmail.com', 'General',      700),
('Ganesh', 'ganesh123', 'ganesh@gmail.com', 'Pediatrician', 550),
('Kumar',  'kumar123',  'kumar@gmail.com',  'Pediatrician', 800),
('Amit',   'amit123',   'amit@gmail.com',   'Cardiologist', 1000),
('Abbis',  'abbis123',  'abbis@gmail.com',  'Neurologist',  1500),
('Tiwary', 'tiwary123', 'tiwary@gmail.com', 'Pediatrician', 450);

-- --------------------------------------------------------
-- Table: patreg
-- --------------------------------------------------------
DROP TABLE IF EXISTS `patreg`;
CREATE TABLE `patreg` (
  `pid`       int(11) NOT NULL AUTO_INCREMENT,
  `fname`     varchar(20) NOT NULL,
  `lname`     varchar(20) NOT NULL,
  `gender`    varchar(10) NOT NULL DEFAULT 'Unknown',
  `email`     varchar(30) NOT NULL,
  `contact`   varchar(10) NOT NULL DEFAULT '',
  `password`  varchar(100) NOT NULL,
  `cpassword` varchar(100) NOT NULL,
  PRIMARY KEY (`pid`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `patreg` (`pid`,`fname`,`lname`,`gender`,`email`,`contact`,`password`,`cpassword`) VALUES
(1,'Ram','Kumar','Male','ram@gmail.com','9876543210','ram123','ram123'),
(2,'Alia','Bhatt','Female','alia@gmail.com','8976897689','alia123','alia123'),
(3,'Shahrukh','Khan','Male','shahrukh@gmail.com','8976898463','shahrukh123','shahrukh123'),
(4,'Kishan','Lal','Male','kishansmart0@gmail.com','8838489464','kishan123','kishan123'),
(5,'Gautam','Shankararam','Male','gautam@gmail.com','9070897653','gautam123','gautam123'),
(6,'Sushant','Singh','Male','sushant@gmail.com','9059986865','sushant123','sushant123'),
(7,'Nancy','Deborah','Female','nancy@gmail.com','9128972454','nancy123','nancy123'),
(8,'Kenny','Sebastian','Male','kenny@gmail.com','9809879868','kenny123','kenny123'),
(9,'William','Blake','Male','william@gmail.com','8683619153','william123','william123'),
(10,'Peter','Norvig','Male','peter@gmail.com','9609362815','peter123','peter123'),
(11,'Shraddha','Kapoor','Female','shraddha@gmail.com','9768946252','shraddha123','shraddha123');

-- --------------------------------------------------------
-- Table: appointmenttb  (FIX: payment has DEFAULT 'Pending')
-- --------------------------------------------------------
DROP TABLE IF EXISTS `appointmenttb`;
CREATE TABLE `appointmenttb` (
  `pid`          int(11) NOT NULL,
  `ID`           int(11) NOT NULL AUTO_INCREMENT,
  `fname`        varchar(20) NOT NULL,
  `lname`        varchar(20) NOT NULL,
  `gender`       varchar(10) NOT NULL DEFAULT 'Unknown',
  `email`        varchar(30) NOT NULL,
  `contact`      varchar(10) NOT NULL,
  `doctor`       varchar(30) NOT NULL,
  `docFees`      int(5) NOT NULL DEFAULT 0,
  `appdate`      date NOT NULL,
  `apptime`      time NOT NULL,
  `userStatus`   int(1) NOT NULL DEFAULT 1,
  `doctorStatus` int(1) NOT NULL DEFAULT 1,
  `payment`      varchar(20) NOT NULL DEFAULT 'Pending',
  PRIMARY KEY (`ID`),
  KEY `pid` (`pid`),
  KEY `doctor` (`doctor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `appointmenttb` (`pid`,`ID`,`fname`,`lname`,`gender`,`email`,`contact`,`doctor`,`docFees`,`appdate`,`apptime`,`userStatus`,`doctorStatus`,`payment`) VALUES
(4,1,'Kishan','Lal','Male','kishansmart0@gmail.com','8838489464','Ganesh',550,'2020-02-14','10:00:00',1,0,'Pending'),
(4,2,'Kishan','Lal','Male','kishansmart0@gmail.com','8838489464','Dinesh',700,'2020-02-28','10:00:00',0,1,'Paid'),
(4,3,'Kishan','Lal','Male','kishansmart0@gmail.com','8838489464','Amit',1000,'2020-02-19','03:00:00',0,1,'Pending'),
(11,4,'Shraddha','Kapoor','Female','shraddha@gmail.com','9768946252','ashok',500,'2020-02-29','20:00:00',1,1,'Paid'),
(4,5,'Kishan','Lal','Male','kishansmart0@gmail.com','8838489464','Dinesh',700,'2020-02-28','12:00:00',1,1,'Pending'),
(4,6,'Kishan','Lal','Male','kishansmart0@gmail.com','8838489464','Ganesh',550,'2020-02-26','15:00:00',0,1,'Pending'),
(2,8,'Alia','Bhatt','Female','alia@gmail.com','8976897689','Ganesh',550,'2020-03-21','10:00:00',1,1,'Paid'),
(5,9,'Gautam','Shankararam','Male','gautam@gmail.com','9070897653','Ganesh',550,'2020-03-19','20:00:00',1,0,'Pending'),
(4,11,'Kishan','Lal','Male','kishansmart0@gmail.com','8838489464','Dinesh',700,'2020-03-27','15:00:00',1,1,'Paid'),
(9,12,'William','Blake','Male','william@gmail.com','8683619153','Kumar',800,'2020-03-26','12:00:00',1,1,'Pending'),
(9,13,'William','Blake','Male','william@gmail.com','8683619153','Tiwary',450,'2020-03-26','14:00:00',1,1,'Pending');

-- --------------------------------------------------------
-- Table: prestb
-- --------------------------------------------------------
DROP TABLE IF EXISTS `prestb`;
CREATE TABLE `prestb` (
  `pres_id`      int(11) NOT NULL AUTO_INCREMENT,
  `doctor`       varchar(50) NOT NULL,
  `pid`          int(11) NOT NULL,
  `ID`           int(11) NOT NULL,
  `fname`        varchar(50) NOT NULL,
  `lname`        varchar(50) NOT NULL,
  `appdate`      date NOT NULL,
  `apptime`      time NOT NULL,
  `disease`      varchar(250) NOT NULL,
  `allergy`      varchar(250) NOT NULL,
  `prescription` varchar(1000) NOT NULL,
  PRIMARY KEY (`pres_id`),
  KEY `pid` (`pid`),
  KEY `ID` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `prestb` (`doctor`,`pid`,`ID`,`fname`,`lname`,`appdate`,`apptime`,`disease`,`allergy`,`prescription`) VALUES
('Dinesh',4,11,'Kishan','Lal','2020-03-27','15:00:00','Cough','Nothing','Take a teaspoon of Benadryl every night'),
('Ganesh',2,8,'Alia','Bhatt','2020-03-21','10:00:00','Severe Fever','Nothing','Take bed rest for 3 days'),
('Kumar',9,12,'William','Blake','2020-03-26','12:00:00','Severe Fever','None','Paracetamol 500mg - 1 every morning and night'),
('Tiwary',9,13,'William','Blake','2020-03-26','14:00:00','Cough','Skin dryness','Intake fruits with more water content');

-- --------------------------------------------------------
-- Table: contact
-- --------------------------------------------------------
DROP TABLE IF EXISTS `contact`;
CREATE TABLE `contact` (
  `id`      int(11) NOT NULL AUTO_INCREMENT,
  `name`    varchar(30) NOT NULL,
  `email`   varchar(50) NOT NULL,
  `contact` varchar(10) NOT NULL,
  `message` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `contact` (`name`,`email`,`contact`,`message`) VALUES
('Anu','anu@gmail.com','7896677554','Hey Admin'),
('Viki','viki@gmail.com','9899778865','Good Job, Pal'),
('Ananya','ananya@gmail.com','9997888879','How can I reach you?'),
('Aakash','aakash@gmail.com','8788979967','Love your site'),
('Mani','mani@gmail.com','8977768978','Want some coffee?');

COMMIT;
