-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Nov 27, 2021 at 04:31 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cmyces`
--

-- --------------------------------------------------------

--
-- Table structure for table `academic_year`
--

CREATE TABLE `academic_year` (
  `academic_id` varchar(10) NOT NULL,
  `academic_year_from` int(4) NOT NULL,
  `academic_year_to` int(4) NOT NULL,
  `academic_term` text NOT NULL,
  `academic_status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `academic_year`
--

INSERT INTO `academic_year` (`academic_id`, `academic_year_from`, `academic_year_to`, `academic_term`, `academic_status`) VALUES
('155255', 2020, 2021, '2nd Semester', 0),
('246266', 2020, 2021, '1st Semester', 0),
('267956', 2017, 2018, '2nd Semester', 0),
('295139', 2019, 2020, '1st Semester', 0),
('296033', 2016, 2017, '1st Semester', 0),
('339936', 2018, 2019, '1st Semester', 1),
('511667', 2021, 2022, '1st Semester', 0),
('568956', 2018, 2019, '2nd Semester', 0),
('596410', 2016, 2017, '2nd Semester', 0),
('639188', 2015, 2016, '2nd Semester', 0),
('747745', 2021, 2022, '2nd Semester', 0),
('835121', 2019, 2020, '2nd Semester', 0),
('858557', 2017, 2018, '1st Semester', 0),
('858560', 2015, 2016, '1st Semester', 0);

-- --------------------------------------------------------

--
-- Table structure for table `faculty_account`
--

CREATE TABLE `faculty_account` (
  `account_user_id` varchar(50) NOT NULL,
  `account_firstname` varchar(50) NOT NULL,
  `account_lastname` varchar(50) NOT NULL,
  `account_password` varchar(50) NOT NULL,
  `account_position` varchar(50) NOT NULL,
  `account_status` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `faculty_account`
--

INSERT INTO `faculty_account` (`account_user_id`, `account_firstname`, `account_lastname`, `account_password`, `account_position`, `account_status`) VALUES
('22-2021-138', 'RHYAN', 'DE LOYOLA', 'rarara', 'Teacher', '1'),
('22-2021-269', 'Rojj', 'Dedoyco', 'rojj123', 'System Admin', '1'),
('22-2021-355', 'sasa', 'BANIHIT', 'sasasa', 'Registrar', '1'),
('28-2021-147', 'WINNA', 'BUCAO', 'cmyces', 'Teacher', '1'),
('28-2021-164', 'NAHDEM', 'COLUMIDA', 'cmyces', 'Teacher', '1'),
('28-2021-207', 'ARIEL', 'SUMAGAYSAY', 'cmyces', 'Teacher', '1'),
('28-2021-254', 'MAY', 'CUAYCONG', 'cmyces', 'Teacher', '1'),
('28-2021-459', 'ORVILLE', 'BALANGUE', 'cmyces', 'Teacher', '1'),
('28-2021-483', 'JUVANI', 'DELO SANTOS', 'cmyces', 'Teacher', '1');

-- --------------------------------------------------------

--
-- Table structure for table `grades_report`
--

CREATE TABLE `grades_report` (
  `student_id` varchar(15) NOT NULL,
  `enrollment_id` varchar(10) NOT NULL,
  `academic_id` varchar(10) NOT NULL,
  `curriculum_id` varchar(10) NOT NULL,
  `program_id` varchar(10) NOT NULL,
  `department_id` varchar(10) NOT NULL,
  `subject_id` varchar(10) NOT NULL,
  `prelim` float NOT NULL,
  `midterm` float NOT NULL,
  `semi_final` float NOT NULL,
  `final` float NOT NULL,
  `remarks` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `grades_report`
--

INSERT INTO `grades_report` (`student_id`, `enrollment_id`, `academic_id`, `curriculum_id`, `program_id`, `department_id`, `subject_id`, `prelim`, `midterm`, `semi_final`, `final`, `remarks`) VALUES
('22-2021-171', '693114', '339936', '331466', '548953', '235533', '282576', 0, 0, 0, 0, ''),
('22-2021-171', '693114', '339936', '331466', '548953', '235533', '485882', 0, 0, 0, 0, ''),
('22-2021-171', '693114', '339936', '331466', '548953', '235533', '600550', 0, 0, 0, 0, ''),
('22-2021-171', '693114', '339936', '331466', '548953', '235533', '610492', 0, 0, 0, 0, ''),
('22-2021-171', '693114', '339936', '331466', '548953', '235533', '700885', 0, 0, 0, 0, ''),
('22-2021-171', '693114', '339936', '331466', '548953', '235533', '834165', 89, 92, 93, 89.5, ''),
('22-2021-171', '693114', '339936', '331466', '548953', '235533', '855295', 0, 0, 0, 0, ''),
('22-2021-171', '693114', '339936', '331466', '548953', '235533', '933924', 0, 0, 0, 0, ''),
('22-2021-171', '693114', '339936', '331466', '548953', '235533', '948667', 0, 0, 0, 0, ''),
('22-2021-338', '810789', '339936', '331466', '548953', '235533', '282576', 0, 0, 0, 0, ''),
('22-2021-338', '810789', '339936', '331466', '548953', '235533', '485882', 0, 0, 0, 0, ''),
('22-2021-338', '810789', '339936', '331466', '548953', '235533', '600550', 0, 0, 0, 0, ''),
('22-2021-338', '810789', '339936', '331466', '548953', '235533', '610492', 0, 0, 0, 0, ''),
('22-2021-338', '810789', '339936', '331466', '548953', '235533', '700885', 0, 0, 0, 0, ''),
('22-2021-338', '810789', '339936', '331466', '548953', '235533', '834165', 0, 0, 0, 0, ''),
('22-2021-338', '810789', '339936', '331466', '548953', '235533', '855295', 0, 0, 0, 0, ''),
('22-2021-338', '810789', '339936', '331466', '548953', '235533', '933924', 0, 0, 0, 0, ''),
('22-2021-338', '810789', '339936', '331466', '548953', '235533', '948667', 0, 0, 0, 0, ''),
('22-2021-182', '784825', '339936', '331466', '548953', '235533', '282576', 0, 0, 0, 0, ''),
('22-2021-182', '784825', '339936', '331466', '548953', '235533', '485882', 0, 0, 0, 0, ''),
('22-2021-182', '784825', '339936', '331466', '548953', '235533', '600550', 0, 0, 0, 0, ''),
('22-2021-182', '784825', '339936', '331466', '548953', '235533', '610492', 0, 0, 0, 0, ''),
('22-2021-182', '784825', '339936', '331466', '548953', '235533', '700885', 0, 0, 0, 0, ''),
('22-2021-182', '784825', '339936', '331466', '548953', '235533', '834165', 0, 0, 0, 0, ''),
('22-2021-182', '784825', '339936', '331466', '548953', '235533', '855295', 0, 0, 0, 0, ''),
('22-2021-182', '784825', '339936', '331466', '548953', '235533', '933924', 0, 0, 0, 0, ''),
('22-2021-182', '784825', '339936', '331466', '548953', '235533', '948667', 0, 0, 0, 0, ''),
('22-2021-341', '894050', '339936', '331466', '548953', '235533', '282576', 0, 0, 0, 0, ''),
('22-2021-341', '894050', '339936', '331466', '548953', '235533', '485882', 0, 0, 0, 0, ''),
('22-2021-341', '894050', '339936', '331466', '548953', '235533', '600550', 0, 0, 0, 0, ''),
('22-2021-341', '894050', '339936', '331466', '548953', '235533', '610492', 0, 0, 0, 0, ''),
('22-2021-341', '894050', '339936', '331466', '548953', '235533', '700885', 0, 0, 0, 0, ''),
('22-2021-341', '894050', '339936', '331466', '548953', '235533', '834165', 0, 0, 0, 0, ''),
('22-2021-341', '894050', '339936', '331466', '548953', '235533', '855295', 0, 0, 0, 0, ''),
('22-2021-341', '894050', '339936', '331466', '548953', '235533', '933924', 0, 0, 0, 0, ''),
('22-2021-341', '894050', '339936', '331466', '548953', '235533', '948667', 0, 0, 0, 0, ''),
('22-2021-268', '460451', '339936', '331466', '548953', '235533', '282576', 0, 0, 0, 0, ''),
('22-2021-268', '460451', '339936', '331466', '548953', '235533', '485882', 0, 0, 0, 0, ''),
('22-2021-268', '460451', '339936', '331466', '548953', '235533', '600550', 0, 0, 0, 0, ''),
('22-2021-268', '460451', '339936', '331466', '548953', '235533', '610492', 0, 0, 0, 0, ''),
('22-2021-268', '460451', '339936', '331466', '548953', '235533', '700885', 0, 0, 0, 0, ''),
('22-2021-268', '460451', '339936', '331466', '548953', '235533', '834165', 0, 0, 0, 0, ''),
('22-2021-268', '460451', '339936', '331466', '548953', '235533', '855295', 0, 0, 0, 0, ''),
('22-2021-268', '460451', '339936', '331466', '548953', '235533', '933924', 0, 0, 0, 0, ''),
('22-2021-268', '460451', '339936', '331466', '548953', '235533', '948667', 0, 0, 0, 0, ''),
('26-2021-152', '685569', '339936', '331466', '548953', '235533', '282576', 0, 0, 0, 0, ''),
('26-2021-152', '685569', '339936', '331466', '548953', '235533', '485882', 0, 0, 0, 0, ''),
('26-2021-152', '685569', '339936', '331466', '548953', '235533', '600550', 0, 0, 0, 0, ''),
('26-2021-152', '685569', '339936', '331466', '548953', '235533', '610492', 0, 0, 0, 0, ''),
('26-2021-152', '685569', '339936', '331466', '548953', '235533', '700885', 0, 0, 0, 0, ''),
('26-2021-152', '685569', '339936', '331466', '548953', '235533', '834165', 0, 0, 0, 0, ''),
('26-2021-152', '685569', '339936', '331466', '548953', '235533', '855295', 0, 0, 0, 0, ''),
('26-2021-152', '685569', '339936', '331466', '548953', '235533', '933924', 0, 0, 0, 0, ''),
('26-2021-152', '685569', '339936', '331466', '548953', '235533', '948667', 0, 0, 0, 0, ''),
('26-2021-306', '603848', '339936', '331466', '548953', '235533', '282576', 0, 0, 0, 0, ''),
('26-2021-306', '603848', '339936', '331466', '548953', '235533', '485882', 0, 0, 0, 0, ''),
('26-2021-306', '603848', '339936', '331466', '548953', '235533', '600550', 0, 0, 0, 0, ''),
('26-2021-306', '603848', '339936', '331466', '548953', '235533', '610492', 0, 0, 0, 0, ''),
('26-2021-306', '603848', '339936', '331466', '548953', '235533', '700885', 0, 0, 0, 0, ''),
('26-2021-306', '603848', '339936', '331466', '548953', '235533', '834165', 0, 0, 0, 0, ''),
('26-2021-306', '603848', '339936', '331466', '548953', '235533', '855295', 0, 0, 0, 0, ''),
('26-2021-306', '603848', '339936', '331466', '548953', '235533', '933924', 0, 0, 0, 0, ''),
('26-2021-306', '603848', '339936', '331466', '548953', '235533', '948667', 0, 0, 0, 0, ''),
('26-2021-184', '495941', '339936', '331466', '548953', '235533', '282576', 0, 0, 0, 0, ''),
('26-2021-184', '495941', '339936', '331466', '548953', '235533', '485882', 0, 0, 0, 0, ''),
('26-2021-184', '495941', '339936', '331466', '548953', '235533', '600550', 0, 0, 0, 0, ''),
('26-2021-184', '495941', '339936', '331466', '548953', '235533', '610492', 0, 0, 0, 0, ''),
('26-2021-184', '495941', '339936', '331466', '548953', '235533', '700885', 0, 0, 0, 0, ''),
('26-2021-184', '495941', '339936', '331466', '548953', '235533', '834165', 0, 0, 0, 0, ''),
('26-2021-184', '495941', '339936', '331466', '548953', '235533', '855295', 0, 0, 0, 0, ''),
('26-2021-184', '495941', '339936', '331466', '548953', '235533', '933924', 0, 0, 0, 0, ''),
('26-2021-184', '495941', '339936', '331466', '548953', '235533', '948667', 0, 0, 0, 0, ''),
('27-2021-152', '990497', '339936', '331466', '548953', '235533', '282576', 0, 0, 0, 0, ''),
('27-2021-152', '990497', '339936', '331466', '548953', '235533', '485882', 0, 0, 0, 0, ''),
('27-2021-152', '990497', '339936', '331466', '548953', '235533', '600550', 0, 0, 0, 0, ''),
('27-2021-152', '990497', '339936', '331466', '548953', '235533', '855295', 0, 0, 0, 0, ''),
('27-2021-152', '990497', '339936', '331466', '548953', '235533', '933924', 0, 0, 0, 0, ''),
('27-2021-152', '990497', '339936', '331466', '548953', '235533', '948667', 0, 0, 0, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `manage_curriculum`
--

CREATE TABLE `manage_curriculum` (
  `curriculum_id` varchar(10) NOT NULL,
  `program_id` varchar(10) NOT NULL,
  `department_id` varchar(10) NOT NULL,
  `curriculum_year` varchar(50) NOT NULL,
  `curriculum_status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `manage_curriculum`
--

INSERT INTO `manage_curriculum` (`curriculum_id`, `program_id`, `department_id`, `curriculum_year`, `curriculum_status`) VALUES
('165294', '548953', '235533', '2019', '0'),
('228637', '771581', '235533', '2021', '1'),
('331466', '548953', '235533', '2018', '1'),
('448838', '281193', '730245', '2021', '1'),
('560891', '289314', '949552', '2021', '1'),
('866919', '666322', '425818', '2021', '1');

-- --------------------------------------------------------

--
-- Table structure for table `manage_department`
--

CREATE TABLE `manage_department` (
  `department_id` varchar(10) NOT NULL,
  `department_code` varchar(20) NOT NULL,
  `department_description` text NOT NULL,
  `department_status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `manage_department`
--

INSERT INTO `manage_department` (`department_id`, `department_code`, `department_description`, `department_status`) VALUES
('235533', 'CICT', 'College Of Information And Communication Technology', 1),
('282255', 'COC', 'College Of Chuchu', 1),
('285262', 'CBMA', 'College Of Business Management And Administration', 1),
('425818', 'COED', 'College Of Education', 1),
('530695', 'CLAS', 'College Of Liberal Arts And Sciences', 1),
('730245', 'COE', 'College of Engineering', 1),
('949552', 'COA', 'College Of Agriculture', 1);

-- --------------------------------------------------------

--
-- Table structure for table `manage_enrollment`
--

CREATE TABLE `manage_enrollment` (
  `enrollment_id` varchar(10) NOT NULL,
  `student_id` varchar(15) NOT NULL,
  `student_firstname` varchar(50) NOT NULL,
  `student_middlename` varchar(50) NOT NULL,
  `student_lastname` varchar(50) NOT NULL,
  `student_name_extension` varchar(10) NOT NULL,
  `academic_id` varchar(10) NOT NULL,
  `curriculum_id` varchar(10) NOT NULL,
  `program_id` varchar(10) NOT NULL,
  `department_id` varchar(10) NOT NULL,
  `student_status` varchar(20) NOT NULL,
  `student_year_level` varchar(50) NOT NULL,
  `student_semester` varchar(50) NOT NULL,
  `student_section` varchar(5) NOT NULL,
  `enrolled_date` varchar(20) NOT NULL,
  `enrolled_time` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `manage_enrollment`
--

INSERT INTO `manage_enrollment` (`enrollment_id`, `student_id`, `student_firstname`, `student_middlename`, `student_lastname`, `student_name_extension`, `academic_id`, `curriculum_id`, `program_id`, `department_id`, `student_status`, `student_year_level`, `student_semester`, `student_section`, `enrolled_date`, `enrolled_time`) VALUES
('460451', '22-2021-268', 'Nicole', 'Rivera', 'Guniabo', '', '339936', '331466', '548953', '235533', 'Regular', '1', '1st Semester', 'B', '11-22-2021', '08:03:46pm'),
('495941', '26-2021-184', 'Barellano', 'Anacleto', 'Levi', '', '339936', '331466', '548953', '235533', 'Regular', '1', '1st Semester', 'A', '11-26-2021', '11:41:09am'),
('603848', '26-2021-306', 'Arvy', 'Rock', 'Bato', '', '339936', '331466', '548953', '235533', 'Regular', '1', '1st Semester', 'A', '11-26-2021', '11:42:39am'),
('685569', '26-2021-152', 'Harvey', 'Barellano', 'Anacleto', '', '339936', '331466', '548953', '235533', 'Regular', '1', '1st Semester', 'A', '11-26-2021', '11:37:21am'),
('693114', '22-2021-171', 'Samson', 'Sardido', 'Banihit', '', '339936', '331466', '548953', '235533', 'Regular', '1', '1st Semester', 'B', '11-24-2021', '06:35:36am'),
('784825', '22-2021-182', 'Thea Marie', 'Columida', 'Gabinete', '', '339936', '331466', '548953', '235533', 'Regular', '1', '1st Semester', 'B', '11-22-2021', '08:09:17pm'),
('810789', '22-2021-338', 'Rojj', 'Aleluya', 'Dedoyco', 'Jr.', '339936', '331466', '548953', '235533', 'Regular', '1', '1st Semester', 'B', '11-22-2021', '08:00:03pm'),
('990497', '27-2021-152', 'Eunice', 'Anacleto', 'Chang', '', '339936', '331466', '548953', '235533', 'Regular', '1', '1st Semester', 'C', '11-27-2021', '10:01:47am');

-- --------------------------------------------------------

--
-- Table structure for table `manage_program`
--

CREATE TABLE `manage_program` (
  `program_id` varchar(10) NOT NULL,
  `department_id` varchar(10) NOT NULL,
  `program_code` varchar(20) NOT NULL,
  `program_description` text NOT NULL,
  `program_status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `manage_program`
--

INSERT INTO `manage_program` (`program_id`, `department_id`, `program_code`, `program_description`, `program_status`) VALUES
('281193', '730245', 'BSEE', 'Bachelor Of Science In Electronic Engineering', 1),
('289314', '949552', 'BSA', 'Bachelor Of Science In Agriculture', 1),
('488809', '285262', 'BSBA', 'Bachelor Of Science In Business Administration', 1),
('548444', '235533', 'BSCS', 'Bachelor Of Science In Computer Science', 1),
('548953', '235533', 'BSIT', 'Bachelor Of Science In Information Technology', 1),
('589515', '235533', 'BSIS', 'Bachelor Of Science In Information System', 1),
('666322', '425818', 'ABELS', 'Bachelor Of Arts In English Language Studies', 1),
('771581', '235533', 'BSSS', 'Bachelor Of Scinence In Solar System', 1);

-- --------------------------------------------------------

--
-- Table structure for table `manage_subject`
--

CREATE TABLE `manage_subject` (
  `subject_id` varchar(10) NOT NULL,
  `curriculum_id` varchar(10) NOT NULL,
  `program_id` varchar(10) NOT NULL,
  `department_id` varchar(10) NOT NULL,
  `subject_code` varchar(20) NOT NULL,
  `subject_description` text NOT NULL,
  `subject_unit` int(2) NOT NULL,
  `subject_id_prerequisite` varchar(20) NOT NULL,
  `subject_year_level` varchar(50) NOT NULL,
  `subject_semester` varchar(50) NOT NULL,
  `subject_status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `manage_subject`
--

INSERT INTO `manage_subject` (`subject_id`, `curriculum_id`, `program_id`, `department_id`, `subject_code`, `subject_description`, `subject_unit`, `subject_id_prerequisite`, `subject_year_level`, `subject_semester`, `subject_status`) VALUES
('103670', '331466', '548953', '235533', 'INTE 1021', 'System Integration and Architecture', 3, 'None', '2', '2nd Semester', 1),
('115314', '331466', '548953', '235533', 'PHED 1002', 'Physical Education 2 (Rhythmic Dancing)', 2, 'None', '1', '2nd Semester', 1),
('115821', '331466', '548953', '235533', 'GEDC 1006', 'Readings in Philippine History', 3, 'None', '3', '1st Semester', 1),
('122994', '331466', '548953', '235533', 'INTE 1039', 'IT Capstone Project 2', 3, 'None', '4', '1st Semester', 0),
('149025', '331466', '548953', '235533', 'INSY 1010', 'Information Assurance and Security (Cybersecurity Fundamentals)', 3, 'None', '3', '1st Semester', 0),
('149435', '331466', '548953', '235533', 'INSY 1024', 'Event-Driven Programming', 3, 'None', '3', '2nd Semester', 0),
('154062', '331466', '548953', '235533', 'INSY 1003', 'Professional Issues in Information System and Technology', 3, 'None', '3', '1st Semester', 0),
('154705', '331466', '548953', '235533', 'COSC 1002', 'Discrete Structures 1 (Discrete Mathematics)', 3, 'None', '1', '2nd Semester', 0),
('155636', '334321', '488809', '285262', 'TRY', 'Try lang guys ha hehe', 3, 'None', '1', '1st Semester', 0),
('159300', '331466', '548953', '235533', 'PHED 1004', 'Physical Education 4 (Team Sports)', 2, '605840', '2', '2nd Semester', 0),
('177967', '331466', '548953', '235533', 'GEDC 1003', 'The Entrepreneurial Mind', 3, 'None', '2', '1st Semester', 0),
('178629', '331466', '548953', '235533', 'CITE 1011', 'Information Management', 3, 'None', '2', '2nd Semester', 0),
('185362', '331466', '548953', '235533', 'INTE 1020', 'Quantitative Methods', 3, 'None', '2', '2nd Semester', 0),
('209104', '331466', '548953', '235533', 'INTE 1005', 'Network Technology 1', 3, 'None', '2', '2nd Semester', 0),
('215276', '331466', '548953', '235533', 'INTE 1013', 'IT Service Management', 3, 'None', '4', '1st Semester', 0),
('238034', '331466', '548953', '235533', 'BUSS 1013', 'Technopreneurship', 3, 'None', '2', '2nd Semester', 0),
('253980', '331466', '548953', '235533', 'INTE 1041', 'Computers Graphics Programming', 3, 'None', '4', '1st Semester', 0),
('260893', '331466', '548953', '235533', 'STIC 1006', 'Purposive Communication 2', 3, '327451', '2', '2nd Semester', 0),
('277962', '331466', '548953', '235533', 'INTE1043', 'IT Practicum (486 Hours)', 9, 'None', '4', '2nd Semester', 0),
('278782', '331466', '548953', '235533', 'INSY 1007', 'Management Information Systems', 3, 'None', '3', '2nd Semester', 0),
('280184', '331466', '548953', '235533', 'GEDC 1013', 'Science, Technology and Society', 3, 'None', '1', '2nd Semester', 0),
('282576', '331466', '548953', '235533', 'PHED 1001', 'Physical Education 1 (Physical Fitness and Conditioning)', 2, 'None', '1', '1st Semester', 0),
('286524', '331466', '548953', '235533', 'INTE 1056', 'Advanced Systems Integration and Architecture', 3, 'None', '3', '2nd Semester', 0),
('291413', '331466', '548953', '235533', 'INTE 1006', 'System Administration and Maintenance 1', 3, 'None', '1', '2nd Semester', 0),
('309858', '331466', '548953', '235533', 'STIC 1007', 'Euthenics 2', 1, '700885', '4', '1st Semester', 0),
('311398', '331466', '548953', '235533', 'INTE 1027', 'IT Elective 3', 3, '919993', '3', '1st Semester', 0),
('327451', '331466', '548953', '235533', 'GEDC 1012', 'Purposive Communication', 3, 'None', '1', '2nd Semester', 0),
('331658', '331466', '548953', '235533', 'NSTP 1010', 'National Service Training Program 2', 3, '855295', '1', '2nd Semester', 0),
('340580', '331466', '548953', '235533', 'INTE 1040', 'IT Elective 4', 3, '311398', '4', '1st Semester', 0),
('390846', '448838', '281193', '730245', 'ENGCHU', 'Engineering in Chuchu', 3, 'None', '1', '2nd Semester', 0),
('426540', '331466', '548953', '235533', 'COSC 1008', 'Platform Technology 1 (Operating Systems)', 3, 'None', '2', '1st Semester', 0),
('426920', '331466', '548953', '235533', 'INTE 1025', 'Data and Digital Communication (Data Communication)', 3, 'None', '3', '1st Semester', 0),
('430295', '331466', '548953', '235533', 'COSC 1001', 'Principles of Communication', 3, 'None', '2', '1st Semester', 0),
('441563', '331466', '548953', '235533', 'INTE 1010', 'Integrative Programming 1', 3, 'None', '2', '2nd Semester', 0),
('445094', '331466', '548953', '235533', 'COSC 1007', 'Human-Computer Interaction', 3, 'None', '2', '1st Semester', 0),
('445829', '331466', '548953', '235533', 'INTE 1083', 'Web Systems and Technologies', 3, 'None', '3', '2nd Semester', 0),
('459108', '331466', '548953', '235533', 'CITE 1008', 'Application Development and Emerging Technologies', 3, 'None', '3', '1st Semester', 0),
('485882', '331466', '548953', '235533', 'CITE1004', 'Introduction to Computing', 3, 'None', '1', '1st Semester', 0),
('512371', '331466', '548953', '235533', 'INSY 1011', 'Advanced Database Systems', 3, 'None', '3', '1st Semester', 0),
('514887', '331466', '548953', '235533', 'INTE 1031', 'IT Capstone Project 1', 3, 'None', '3', '2nd Semester', 0),
('600550', '331466', '548953', '235533', 'GEDC 1002', 'The Contemporary World', 3, 'None', '1', '1st Semester', 0),
('605840', '331466', '548953', '235533', 'PHED 1003', 'Physical Education 3 (Individual/Dual Sports)', 2, '115314', '2', '1st Semester', 0),
('610492', '331466', '548953', '235533', 'GEDC 1004', 'Filipino 1: Istruktura ng Wikang Filipino', 3, 'None', '1', '1st Semester', 0),
('662640', '331466', '548953', '235533', 'GEDC 1010', 'Art Appreciation', 3, 'None', '1', '2nd Semester', 0),
('687812', '331466', '548953', '235533', 'GEDC 1014', 'Rizal\'s Life and Works', 3, 'None', '4', '1st Semester', 0),
('700885', '331466', '548953', '235533', 'STIC 1002', 'Euthenics 1', 1, 'None', '1', '1st Semester', 0),
('723298', '331466', '548953', '235533', 'INSY 1005', 'Information Assurance and Security (Data Privacy)', 3, 'None', '3', '2nd Semester', 0),
('771839', '331466', '548953', '235533', 'INTE 1015', 'IT Elective 1', 3, 'None', '2', '1st Semester', 0),
('782512', '331466', '548953', '235533', 'GEDC 1009', 'Ethics', 3, 'None', '3', '2nd Semester', 0),
('811875', '331466', '548953', '235533', 'INTE 1030', 'Network Technology 2', 3, '209104', '3', '2nd Semester', 0),
('828563', '331466', '548953', '235533', 'INTE 1084', 'Mobile System and Technologies', 3, 'None', '4', '1st Semester', 0),
('834165', '331466', '548953', '235533', 'CITE1003', 'Computer Programming 1', 3, 'None', '1', '1st Semester', 0),
('838614', '331466', '548953', '235533', 'COSC 1003', 'Data Structures and Algorithms', 3, 'None', '2', '1st Semester', 0),
('844154', '331466', '548953', '235533', 'CITE 1006', 'Computer Programming 2', 3, '834165', '1', '2nd Semester', 0),
('855295', '331466', '548953', '235533', 'NSTP 1008', 'National Service Training Program 1', 3, 'None', '1', '1st Semester', 0),
('906814', '331466', '548953', '235533', 'GEDC 1007', 'Panitikang Pilipino', 3, 'None', '2', '1st Semester', 0),
('919993', '331466', '548953', '235533', 'INTE 1019', 'IT Elective 2', 3, '771839', '2', '2nd Semester', 0),
('933924', '331466', '548953', '235533', 'GEDC 1005', 'Mathematics in the Modern World', 3, 'None', '1', '1st Semester', 0),
('948667', '331466', '548953', '235533', 'GEDC 1008', 'Understanding the Self', 3, 'None', '1', '1st Semester', 0),
('982257', '331466', '548953', '235533', 'GEDC 1011', 'Filipino 2: Introduksyon sa Pamamahayag', 3, '610492', '1', '2nd Semester', 0);

-- --------------------------------------------------------

--
-- Table structure for table `student_info`
--

CREATE TABLE `student_info` (
  `student_id` varchar(15) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `middlename` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `name_extension` varchar(10) NOT NULL,
  `address` text NOT NULL,
  `birthdate` date NOT NULL,
  `birthplace` text NOT NULL,
  `gender` varchar(50) NOT NULL,
  `civil_status` varchar(50) NOT NULL,
  `citizenship` varchar(50) NOT NULL,
  `religion` varchar(50) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `student_info`
--

INSERT INTO `student_info` (`student_id`, `firstname`, `middlename`, `lastname`, `name_extension`, `address`, `birthdate`, `birthplace`, `gender`, `civil_status`, `citizenship`, `religion`, `phone_number`, `email`) VALUES
('22-2021-171', 'Samson', 'Sardido', 'Banihit', '', '#2947 PHHC Road Brgy. Villamonte Bacolod City', '1998-12-11', 'Bacolod City', 'Male', 'Single', 'Filipino', 'Roman Catholic', '09276106684', 'sambanihit@gmail.com'),
('22-2021-182', 'Thea Marie', 'Columida', 'Gabinete', '', 'dsagfsh df', '2021-11-10', 'gfdgdf', 'Female', 'Single', 'gfd', 'gfd', '0912356789', 'thea@gmail.com'),
('22-2021-268', 'Nicole', 'Rivera', 'Guniabo', '', 'Silay', '2021-10-31', 'Silay', 'Female', 'Single', 'Filipino', 'Roman Catholic', '09123456789', 'nicole@gmail.com'),
('22-2021-338', 'Rojj', 'Aleluya', 'Dedoyco', 'Jr.', 'Camelot', '2021-11-08', 'Bacolod City', 'Male', 'Single', 'Filipino', 'Roman Catholic', '09123456789', 'rojj@gmail.com'),
('22-2021-341', 'Patrick', 'Tito', 'Guintivano', '', ' gsdgds gsd gds', '2021-11-10', ' agdfs gads', 'Male', 'Married', 'g sgs', 'g dsgs', '0912456789', 'pat@gmail.com'),
('26-2021-152', 'Harvey', 'Barellano', 'Anacleto', '', 'Sialy', '2021-11-09', 'Silay', 'Male', 'Single', 'Filipino', 'Roman Catholic', '09123456789', 'harvey@gmail.com'),
('26-2021-184', 'Barellano', 'Anacleto', 'Levi', '', 'San CAarlos', '2021-11-10', 'SCC', 'Female', 'Married', 'Egyptian', 'Romantic Catholic', '09123456789', 'levi@gmail.com'),
('26-2021-306', 'Arvy', 'Rock', 'Bato', '', 'ambot', '2021-11-03', 'ambot a', 'Male', 'Single', 'Shih Tzu', 'Miami Heat', '09123456789', 'arvy@gmail.com'),
('27-2021-152', 'Eunice', 'Anacleto', 'Chang', '', 'Villa Angela', '2021-11-03', 'Villa Angela', 'Female', 'Married', 'Chinese', 'Romantic Catholic', '09123456789', 'chang@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `student_subject_load`
--

CREATE TABLE `student_subject_load` (
  `student_subject_load_id` int(10) NOT NULL,
  `enrollment_id` varchar(10) NOT NULL,
  `student_id` varchar(15) NOT NULL,
  `academic_id` varchar(10) NOT NULL,
  `curriculum_id` varchar(10) NOT NULL,
  `program_id` varchar(10) NOT NULL,
  `department_id` varchar(10) NOT NULL,
  `subject_id` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student_subject_load`
--

INSERT INTO `student_subject_load` (`student_subject_load_id`, `enrollment_id`, `student_id`, `academic_id`, `curriculum_id`, `program_id`, `department_id`, `subject_id`) VALUES
(927901, '693114', '22-2021-171', '339936', '331466', '548953', '235533', '282576'),
(927902, '693114', '22-2021-171', '339936', '331466', '548953', '235533', '485882'),
(927903, '693114', '22-2021-171', '339936', '331466', '548953', '235533', '600550'),
(927904, '693114', '22-2021-171', '339936', '331466', '548953', '235533', '610492'),
(927905, '693114', '22-2021-171', '339936', '331466', '548953', '235533', '700885'),
(927906, '693114', '22-2021-171', '339936', '331466', '548953', '235533', '834165'),
(927907, '693114', '22-2021-171', '339936', '331466', '548953', '235533', '855295'),
(927908, '693114', '22-2021-171', '339936', '331466', '548953', '235533', '933924'),
(927909, '693114', '22-2021-171', '339936', '331466', '548953', '235533', '948667'),
(927910, '810789', '22-2021-338', '339936', '331466', '548953', '235533', '282576'),
(927911, '810789', '22-2021-338', '339936', '331466', '548953', '235533', '485882'),
(927912, '810789', '22-2021-338', '339936', '331466', '548953', '235533', '600550'),
(927913, '810789', '22-2021-338', '339936', '331466', '548953', '235533', '610492'),
(927914, '810789', '22-2021-338', '339936', '331466', '548953', '235533', '700885'),
(927915, '810789', '22-2021-338', '339936', '331466', '548953', '235533', '834165'),
(927916, '810789', '22-2021-338', '339936', '331466', '548953', '235533', '855295'),
(927917, '810789', '22-2021-338', '339936', '331466', '548953', '235533', '933924'),
(927918, '810789', '22-2021-338', '339936', '331466', '548953', '235533', '948667'),
(927919, '784825', '22-2021-182', '339936', '331466', '548953', '235533', '282576'),
(927920, '784825', '22-2021-182', '339936', '331466', '548953', '235533', '485882'),
(927921, '784825', '22-2021-182', '339936', '331466', '548953', '235533', '600550'),
(927922, '784825', '22-2021-182', '339936', '331466', '548953', '235533', '610492'),
(927923, '784825', '22-2021-182', '339936', '331466', '548953', '235533', '700885'),
(927924, '784825', '22-2021-182', '339936', '331466', '548953', '235533', '834165'),
(927925, '784825', '22-2021-182', '339936', '331466', '548953', '235533', '855295'),
(927926, '784825', '22-2021-182', '339936', '331466', '548953', '235533', '933924'),
(927927, '784825', '22-2021-182', '339936', '331466', '548953', '235533', '948667'),
(927928, '894050', '22-2021-341', '339936', '331466', '548953', '235533', '282576'),
(927929, '894050', '22-2021-341', '339936', '331466', '548953', '235533', '485882'),
(927930, '894050', '22-2021-341', '339936', '331466', '548953', '235533', '600550'),
(927931, '894050', '22-2021-341', '339936', '331466', '548953', '235533', '610492'),
(927932, '894050', '22-2021-341', '339936', '331466', '548953', '235533', '700885'),
(927933, '894050', '22-2021-341', '339936', '331466', '548953', '235533', '834165'),
(927934, '894050', '22-2021-341', '339936', '331466', '548953', '235533', '855295'),
(927935, '894050', '22-2021-341', '339936', '331466', '548953', '235533', '933924'),
(927936, '894050', '22-2021-341', '339936', '331466', '548953', '235533', '948667'),
(927937, '460451', '22-2021-268', '339936', '331466', '548953', '235533', '282576'),
(927938, '460451', '22-2021-268', '339936', '331466', '548953', '235533', '485882'),
(927939, '460451', '22-2021-268', '339936', '331466', '548953', '235533', '600550'),
(927940, '460451', '22-2021-268', '339936', '331466', '548953', '235533', '610492'),
(927941, '460451', '22-2021-268', '339936', '331466', '548953', '235533', '700885'),
(927942, '460451', '22-2021-268', '339936', '331466', '548953', '235533', '834165'),
(927943, '460451', '22-2021-268', '339936', '331466', '548953', '235533', '855295'),
(927944, '460451', '22-2021-268', '339936', '331466', '548953', '235533', '933924'),
(927945, '460451', '22-2021-268', '339936', '331466', '548953', '235533', '948667'),
(927946, '685569', '26-2021-152', '339936', '331466', '548953', '235533', '282576'),
(927947, '685569', '26-2021-152', '339936', '331466', '548953', '235533', '485882'),
(927948, '685569', '26-2021-152', '339936', '331466', '548953', '235533', '600550'),
(927949, '685569', '26-2021-152', '339936', '331466', '548953', '235533', '610492'),
(927950, '685569', '26-2021-152', '339936', '331466', '548953', '235533', '700885'),
(927951, '685569', '26-2021-152', '339936', '331466', '548953', '235533', '834165'),
(927952, '685569', '26-2021-152', '339936', '331466', '548953', '235533', '855295'),
(927953, '685569', '26-2021-152', '339936', '331466', '548953', '235533', '933924'),
(927954, '685569', '26-2021-152', '339936', '331466', '548953', '235533', '948667'),
(927955, '603848', '26-2021-306', '339936', '331466', '548953', '235533', '282576'),
(927956, '603848', '26-2021-306', '339936', '331466', '548953', '235533', '485882'),
(927957, '603848', '26-2021-306', '339936', '331466', '548953', '235533', '600550'),
(927958, '603848', '26-2021-306', '339936', '331466', '548953', '235533', '610492'),
(927959, '603848', '26-2021-306', '339936', '331466', '548953', '235533', '700885'),
(927960, '603848', '26-2021-306', '339936', '331466', '548953', '235533', '834165'),
(927961, '603848', '26-2021-306', '339936', '331466', '548953', '235533', '855295'),
(927962, '603848', '26-2021-306', '339936', '331466', '548953', '235533', '933924'),
(927963, '603848', '26-2021-306', '339936', '331466', '548953', '235533', '948667'),
(927964, '495941', '26-2021-184', '339936', '331466', '548953', '235533', '282576'),
(927965, '495941', '26-2021-184', '339936', '331466', '548953', '235533', '485882'),
(927966, '495941', '26-2021-184', '339936', '331466', '548953', '235533', '600550'),
(927967, '495941', '26-2021-184', '339936', '331466', '548953', '235533', '610492'),
(927968, '495941', '26-2021-184', '339936', '331466', '548953', '235533', '700885'),
(927969, '495941', '26-2021-184', '339936', '331466', '548953', '235533', '834165'),
(927970, '495941', '26-2021-184', '339936', '331466', '548953', '235533', '855295'),
(927971, '495941', '26-2021-184', '339936', '331466', '548953', '235533', '933924'),
(927972, '495941', '26-2021-184', '339936', '331466', '548953', '235533', '948667'),
(927973, '990497', '27-2021-152', '339936', '331466', '548953', '235533', '282576'),
(927974, '990497', '27-2021-152', '339936', '331466', '548953', '235533', '485882'),
(927975, '990497', '27-2021-152', '339936', '331466', '548953', '235533', '600550'),
(927976, '990497', '27-2021-152', '339936', '331466', '548953', '235533', '855295'),
(927977, '990497', '27-2021-152', '339936', '331466', '548953', '235533', '933924'),
(927978, '990497', '27-2021-152', '339936', '331466', '548953', '235533', '948667');

-- --------------------------------------------------------

--
-- Table structure for table `teacher_subject_load`
--

CREATE TABLE `teacher_subject_load` (
  `subject_load_id` int(10) NOT NULL,
  `academic_id` varchar(10) NOT NULL,
  `account_user_id` varchar(15) NOT NULL,
  `subject_id` varchar(10) NOT NULL,
  `curriculum_id` varchar(10) NOT NULL,
  `program_id` varchar(10) NOT NULL,
  `department_id` varchar(10) NOT NULL,
  `day_initial` varchar(10) NOT NULL,
  `subject_time_from` time NOT NULL,
  `subject_time_to` time NOT NULL,
  `subject_room` varchar(50) NOT NULL,
  `subject_section` varchar(50) NOT NULL,
  `subject_year_level_teacher` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `teacher_subject_load`
--

INSERT INTO `teacher_subject_load` (`subject_load_id`, `academic_id`, `account_user_id`, `subject_id`, `curriculum_id`, `program_id`, `department_id`, `day_initial`, `subject_time_from`, `subject_time_to`, `subject_room`, `subject_section`, `subject_year_level_teacher`) VALUES
(108508, '339936', '28-2021-147', '485882', '331466', '548953', '235533', '5Fri', '10:05:00', '10:10:00', 'B609', 'C', '1'),
(183483, '339936', '22-2021-138', '771839', '331466', '548953', '235533', '3Wed', '20:53:00', '20:59:00', 'B202', 'C', '2'),
(239455, '339936', '22-2021-138', '834165', '331466', '548953', '235533', '4Thu', '08:00:00', '09:00:00', 'B500', 'B', '1'),
(638016, '339936', '22-2021-138', '834165', '331466', '548953', '235533', '1Mon', '14:45:00', '14:50:00', 'B306', 'A', '1'),
(948262, '339936', '22-2021-138', '834165', '331466', '548953', '235533', '3Wed', '14:47:00', '14:52:00', 'B306', 'B', '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `academic_year`
--
ALTER TABLE `academic_year`
  ADD PRIMARY KEY (`academic_id`);

--
-- Indexes for table `faculty_account`
--
ALTER TABLE `faculty_account`
  ADD PRIMARY KEY (`account_user_id`);

--
-- Indexes for table `grades_report`
--
ALTER TABLE `grades_report`
  ADD KEY `student_id` (`student_id`),
  ADD KEY `enrollment_id` (`enrollment_id`),
  ADD KEY `academic_id` (`academic_id`),
  ADD KEY `subject_id` (`subject_id`),
  ADD KEY `curriculum_id` (`curriculum_id`),
  ADD KEY `program_id` (`program_id`),
  ADD KEY `department_id` (`department_id`);

--
-- Indexes for table `manage_curriculum`
--
ALTER TABLE `manage_curriculum`
  ADD PRIMARY KEY (`curriculum_id`),
  ADD KEY `department_id` (`department_id`),
  ADD KEY `program_id` (`program_id`);

--
-- Indexes for table `manage_department`
--
ALTER TABLE `manage_department`
  ADD PRIMARY KEY (`department_id`);

--
-- Indexes for table `manage_enrollment`
--
ALTER TABLE `manage_enrollment`
  ADD PRIMARY KEY (`enrollment_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `academic_id` (`academic_id`,`curriculum_id`,`program_id`,`department_id`);

--
-- Indexes for table `manage_program`
--
ALTER TABLE `manage_program`
  ADD PRIMARY KEY (`program_id`),
  ADD KEY `department_id` (`department_id`);

--
-- Indexes for table `manage_subject`
--
ALTER TABLE `manage_subject`
  ADD PRIMARY KEY (`subject_id`),
  ADD KEY `department_id` (`department_id`),
  ADD KEY `program_id` (`program_id`),
  ADD KEY `curriculum_id` (`curriculum_id`);

--
-- Indexes for table `student_info`
--
ALTER TABLE `student_info`
  ADD PRIMARY KEY (`student_id`);

--
-- Indexes for table `student_subject_load`
--
ALTER TABLE `student_subject_load`
  ADD PRIMARY KEY (`student_subject_load_id`),
  ADD KEY `enrollment_id` (`enrollment_id`,`student_id`,`academic_id`,`curriculum_id`),
  ADD KEY `program_id` (`program_id`,`department_id`,`subject_id`);

--
-- Indexes for table `teacher_subject_load`
--
ALTER TABLE `teacher_subject_load`
  ADD PRIMARY KEY (`subject_load_id`),
  ADD KEY `academic_id` (`academic_id`),
  ADD KEY `account_user_id` (`account_user_id`),
  ADD KEY `course_id` (`subject_id`),
  ADD KEY `curriculum_id` (`curriculum_id`),
  ADD KEY `program_id` (`program_id`),
  ADD KEY `department_id` (`department_id`),
  ADD KEY `day_initial` (`day_initial`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `student_subject_load`
--
ALTER TABLE `student_subject_load`
  MODIFY `student_subject_load_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=927979;

--
-- AUTO_INCREMENT for table `teacher_subject_load`
--
ALTER TABLE `teacher_subject_load`
  MODIFY `subject_load_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=963164;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
