-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 19, 2020 at 11:42 AM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ipass_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `add_column`
--

CREATE TABLE `add_column` (
  `column_id` int(11) NOT NULL,
  `column_space_id` int(11) NOT NULL,
  `column_user_id` int(11) NOT NULL,
  `column_name` varchar(100) CHARACTER SET latin2 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `add_column`
--

INSERT INTO `add_column` (`column_id`, `column_space_id`, `column_user_id`, `column_name`) VALUES
(15, 49, 2, 'dropdown'),
(16, 49, 2, 'text'),
(69, 49, 6, 'sample_textarea12'),
(94, 49, 1, 'email'),
(95, 49, 1, 'sample12345678_23sw');

-- --------------------------------------------------------

--
-- Table structure for table `child`
--

CREATE TABLE `child` (
  `child_id` int(11) NOT NULL,
  `child_order` int(11) NOT NULL,
  `child_name` varchar(50) CHARACTER SET latin2 NOT NULL,
  `child_field_id` int(11) NOT NULL,
  `child_color` varchar(20) CHARACTER SET latin2 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `child`
--

INSERT INTO `child` (`child_id`, `child_order`, `child_name`, `child_field_id`, `child_color`) VALUES
(61, 0, 'Option1', 276, '#440386'),
(62, 1, 'Option2', 276, '#00AD04'),
(63, 2, 'Option3', 276, '#A30061'),
(64, 0, 'Option1', 287, '#45919B'),
(65, 1, 'Option2', 287, '#005FAD'),
(66, 2, 'Option3', 287, '#00AD1D'),
(73, 0, 'Sample1222', 298, '#440485'),
(74, 1, 'Sample2', 298, '#B90453'),
(75, 2, 'Sample3', 298, '#0EE213'),
(76, 0, '111', 315, '#005AC7'),
(77, 1, '222', 315, '#17AD0B'),
(85, 0, 'sad', 306, '#5C797C'),
(86, 1, 'happy', 306, '#000000'),
(87, 3, 'Option4', 276, '#D60606'),
(88, 0, 'Option123', 361, '#FF0012');

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `comment_id` int(11) NOT NULL,
  `comment_task_id` varchar(11) NOT NULL,
  `comment_user_id` varchar(11) NOT NULL,
  `comment_message` varchar(500) NOT NULL,
  `comment_date` datetime NOT NULL,
  `comment_attactment` varchar(500) NOT NULL,
  `comment_type` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin2;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`comment_id`, `comment_task_id`, `comment_user_id`, `comment_message`, `comment_date`, `comment_attactment`, `comment_type`) VALUES
(426, '206', '1', '1', '2020-06-17 15:44:20', '', ''),
(428, '206', '1', '', '2020-06-17 15:44:28', '', ''),
(429, '206', '1', 'asd', '2020-06-17 15:44:44', '154444-151204-Untitl.png', ''),
(431, '206', '1', 'asd', '2020-06-17 15:56:31', '155631-PDF.pdf', ''),
(433, '206', '1', '', '2020-06-17 16:32:50', '163250-JPG.jpg', ''),
(434, '206', '1', 'Sample text', '2020-06-17 17:06:54', '', ''),
(435, '206', '1', 'Sample attachement', '2020-06-17 17:07:09', '170709-151204-Untitl.png', ''),
(436, '206', '1', 'Update field name: \"Radio1\" value: \"yes\".', '2020-06-18 09:33:22', '', '1'),
(437, '206', '1', 'Update field name: \"sad\" value: \"TEXT1\".', '2020-06-18 10:27:23', '', '1'),
(438, '206', '1', 'Update field name: \"sad\" value: \"TEXT\".', '2020-06-18 10:27:30', '', '1'),
(439, '206', '2', 'Update field name: \"sad\" value: \"TEXT11\".', '2020-06-18 11:05:26', '', '1'),
(440, '206', '2', 'asd', '2020-06-18 11:05:30', '', ''),
(441, '221', '1', 'Update field name: \"sad\" value: \"asd\".', '2020-06-24 13:20:51', '', '1'),
(442, '221', '1', 'Update field name: \"Email\" value: \"dasd@gmail.com\".', '2020-06-24 13:20:51', '', '1'),
(443, '221', '1', 'Update field name: \"adasdww\" value: \"ddd\".', '2020-06-24 13:23:26', '', '1'),
(444, '210', '1', 'Update field name: \"SAMPLE4\" value: \"sad\".', '2020-06-24 13:35:53', '', '1'),
(445, '210', '1', 'Update field name: \"SAMPLE4\" value: \"\".', '2020-06-24 13:42:31', '', '1'),
(446, '210', '1', 'Update field name: \"SAMPLE4\" value: \"sad\".', '2020-06-24 13:42:53', '', '1'),
(447, '222', '1', 'Update field name: \"sad\" value: \"ss\".', '2020-06-25 11:20:53', '', '1'),
(448, '222', '1', 'Update field name: \"Email\" value: \"a@gmail.com\".', '2020-06-25 11:20:54', '', '1'),
(449, '222', '1', 'Update field name: \"adasdww\" value: \"asd\".', '2020-06-25 11:20:54', '', '1'),
(450, '210', '1', 'Update field name: \"SAMPLE1\" value: \"1asd\".', '2020-06-25 11:22:26', '', '1'),
(451, '223', '1', 'Update field name: \"SAMPLE1\" value: \"sample\".', '2020-06-25 13:02:44', '', '1'),
(452, '222', '1', 'Update field name: \"Dropdown\" value: \"Option1\".', '2020-06-25 13:28:15', '', '1'),
(453, '224', '1', 'Update field name: \"sad\" value: \"TEXT\".', '2020-07-06 15:10:18', '', '1'),
(454, '224', '1', 'Update field name: \"Email\" value: \"nicodamejaucila@gmail.com\".', '2020-07-06 15:10:18', '', '1'),
(455, '224', '1', 'Update field name: \"adasdww\" value: \"asd\".', '2020-07-06 15:10:18', '', '1'),
(456, '224', '1', 'Update field name: \"Dropdown\" value: \"Option1\".', '2020-07-06 15:10:19', '', '1'),
(457, '224', '1', 'Update field name: \"Phone\" value: \"456789\".', '2020-07-06 15:10:19', '', '1'),
(458, '224', '1', 'Update field name: \"Number\" value: \"3\".', '2020-07-06 15:10:33', '', '1'),
(459, '224', '1', 'Update field name: \"Number\" value: \"\".', '2020-07-06 15:11:33', '', '1'),
(460, '224', '1', 'Update field name: \"Phone\" value: \"\".', '2020-07-06 15:12:06', '', '1'),
(461, '224', '1', 'Update field name: \"Email\" value: \"gilmar@gmail.com\".', '2020-07-06 15:12:38', '', '1'),
(462, '224', '1', 'Update field name: \"Phone\" value: \"456789\".', '2020-07-06 15:12:38', '', '1'),
(463, '224', '1', 'Update field name: \"Number\" value: \"123\".', '2020-07-06 15:12:38', '', '1'),
(464, '224', '1', 'Update field name: \"EMAIL1234\" value: \"dasd@gmail.com\".', '2020-07-06 15:12:38', '', '1'),
(465, '224', '1', 'Update field name: \"SAMPLE TEXTAREA12\" value: \"2323\".', '2020-07-06 15:12:38', '', '1'),
(466, '224', '1', 'Update field name: \"Radio1\" value: \"yes\".', '2020-07-06 15:12:38', '', '1'),
(467, '224', '1', 'Update field name: \"asd\" value: \"Sample1222\".', '2020-07-06 15:12:38', '', '1'),
(468, '224', '1', 'Update field name: \"sss\" value: \"yes\".', '2020-07-06 15:12:38', '', '1'),
(469, '224', '1', 'Update field name: \"sad\" value: \"\".', '2020-07-06 15:13:08', '', '1'),
(470, '224', '1', 'Update field name: \"Email\" value: \"\".', '2020-07-06 15:13:08', '', '1'),
(471, '224', '1', 'Update field name: \"adasdww\" value: \"\".', '2020-07-06 15:13:08', '', '1'),
(472, '224', '1', 'Update field name: \"Dropdown\" value: \"\".', '2020-07-06 15:13:08', '', '1'),
(473, '224', '1', 'Update field name: \"Phone\" value: \"\".', '2020-07-06 15:13:08', '', '1'),
(474, '224', '1', 'Update field name: \"sad\" value: \"asd\".', '2020-07-06 15:19:38', '', '1'),
(475, '224', '1', 'Update field name: \"Email\" value: \"gilmar@gmail.com\".', '2020-07-06 15:19:38', '', '1'),
(476, '224', '1', 'Update field name: \"adasdww\" value: \"asd\".', '2020-07-06 15:19:39', '', '1'),
(477, '224', '1', 'Update field name: \"Dropdown\" value: \"Option1\".', '2020-07-06 15:19:39', '', '1'),
(478, '224', '1', 'Update field name: \"Phone\" value: \"456789\".', '2020-07-06 15:19:39', '', '1'),
(479, '224', '1', 'Update field name: \"Radio1\" value: \"no\".', '2020-07-06 15:21:06', '', '1'),
(480, '224', '1', 'Update field name: \"Radio1\" value: \"\".', '2020-07-06 15:21:16', '', '1'),
(481, '224', '1', 'Update field name: \"Radio1\" value: \"yes\".', '2020-07-06 15:21:19', '', '1'),
(482, '224', '1', 'Update field name: \"Radio1\" value: \"\".', '2020-07-06 15:23:32', '', '1'),
(483, '224', '1', 'Update field name: \"sss\" value: \"\".', '2020-07-06 15:23:32', '', '1'),
(484, '224', '1', 'Update field name: \"Number\" value: \"\".', '2020-07-06 15:23:45', '', '1'),
(485, '224', '1', 'Update field name: \"EMAIL1234\" value: \"\".', '2020-07-06 15:23:45', '', '1'),
(486, '224', '1', 'Update field name: \"SAMPLE TEXTAREA12\" value: \"\".', '2020-07-06 15:23:45', '', '1'),
(487, '224', '1', 'Update field name: \"asd\" value: \"\".', '2020-07-06 15:23:45', '', '1'),
(488, '209', '1', 'Update field name: \"adasdww\" value: \"asdasd\".', '2020-07-06 15:26:14', '', '1'),
(489, '236', '1', 'Update field name: \"sad\" value: \"asd\".', '2020-07-06 15:40:43', '', '1'),
(490, '236', '1', 'Update field name: \"Email\" value: \"dasd@gmail.com\".', '2020-07-06 15:40:43', '', '1'),
(491, '236', '1', 'Update field name: \"adasdww\" value: \"asdasd\".', '2020-07-06 15:41:03', '', '1'),
(492, '224', '1', 'Update field name: \"Dropdown\" value: \"Option2\".', '2020-07-08 10:07:24', '', '1'),
(493, '224', '1', 'Update field name: \"Dropdown\" value: \"\".', '2020-07-08 10:07:35', '', '1'),
(494, '224', '1', 'Update field name: \"Dropdown\" value: \"Option1\".', '2020-07-08 10:08:18', '', '1'),
(495, '206', '1', 'Update field name: \"SAMPLE TEXTAREA12\" value: \"\".', '2020-07-27 10:28:39', '', '1'),
(496, '236', '1', 'Update field name: \"sad\" value: \"\".', '2020-07-27 10:31:02', '', '1'),
(497, '209', '1', 'Update field name: \"Dropdown1\" value: \"\".', '2020-07-27 10:32:07', '', '1'),
(498, '209', '1', 'Update field name: \"Dropdown1\" value: \"Option4\".', '2020-07-27 10:44:48', '', '1'),
(499, '236', '1', 'Update field name: \"Radio1\" value: \"no\".', '2020-07-27 10:45:36', '', '1'),
(500, '236', '1', 'Update field name: \"sss\" value: \"no\".', '2020-07-27 10:45:36', '', '1'),
(501, '206', '1', 'Sample', '2020-07-28 16:33:14', '', ''),
(502, '206', '1', 'SAPLE\n', '2020-07-29 10:35:01', '', ''),
(503, '209', '1', 'Update field name: \"Sample12345678\" value: \"Option123\".', '2020-08-04 14:50:00', '', '1'),
(504, '209', '1', 'Update field name: \"Dropdown1\" value: \"Option1\".', '2020-08-04 15:09:51', '', '1'),
(505, '209', '1', 'Update field name: \"Dropdown1\" value: \"Option2\".', '2020-08-04 15:10:02', '', '1'),
(506, '206', '1', 'Update field name: \"Sample12345678\" value: \"Option123\".', '2020-08-04 15:17:15', '', '1'),
(508, '241', '1', '', '2020-08-12 14:09:42', '140942-XLXS.xlsx', ''),
(510, '241', '1', 'Update field name: \"Sample12345678\" value: \"Option123\".', '2020-08-13 10:56:32', '', '1'),
(511, '241', '1', 'Update field name: \"Sample12345678\" value: \"\".', '2020-08-13 11:07:47', '', '1'),
(512, '241', '1', 'Update field name: \"Sample12345678\" value: \"Option123\".', '2020-08-13 11:08:57', '', '1'),
(513, '241', '1', 'Update field name: \"Sample12345678\" value: \"\".', '2020-08-13 11:10:20', '', '1'),
(514, '241', '1', 'Update field name: \"sad\" value: \"TEXT\".', '2020-08-13 11:10:20', '', '1'),
(515, '241', '1', 'Update field name: \"Email\" value: \"dasd@gmail.com\".', '2020-08-13 11:10:35', '', '1'),
(516, '241', '1', 'Update field name: \"Sample12345678\" value: \"Option123\".', '2020-08-13 11:11:43', '', '1'),
(517, '241', '1', 'Update field name: \"Sample12345678\" value: \"\".', '2020-08-13 11:16:27', '', '1'),
(518, '241', '1', 'Update field name: \"Sample12345678\" value: \"Option123\".', '2020-08-13 11:29:25', '', '1'),
(519, '241', '1', 'Update field name: \"Sample12345678\" value: \"\".', '2020-08-13 11:30:54', '', '1'),
(520, '241', '1', 'Update field name: \"Sample12345678\" value: \"Option123\".', '2020-08-13 11:57:52', '', '1'),
(521, '241', '1', 'Update field name: \"Sample12345678\" value: \"\".', '2020-08-13 13:25:50', '', '1'),
(524, '241', '1', 'Update field name: \"Sample12345678\" value: \"Option123\".', '2020-08-13 14:52:00', '', '1'),
(525, '241', '1', 'Update field name: \"Sample12345678\" value: \"\".', '2020-08-17 11:02:35', '', '1');

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `contact_id` int(11) NOT NULL,
  `contact_fname` varchar(30) CHARACTER SET latin2 NOT NULL,
  `contact_mname` varchar(30) CHARACTER SET latin2 NOT NULL,
  `contact_lname` varchar(30) CHARACTER SET latin2 NOT NULL,
  `contact_bdate` date NOT NULL,
  `contact_gender` varchar(20) CHARACTER SET latin2 NOT NULL,
  `contact_email` varchar(100) CHARACTER SET latin2 NOT NULL,
  `contact_fbname` varchar(100) CHARACTER SET latin2 NOT NULL,
  `contact_messenger` varchar(200) CHARACTER SET latin2 NOT NULL,
  `contact_cpnum` varchar(20) CHARACTER SET latin2 NOT NULL,
  `contact_country` varchar(100) CHARACTER SET latin2 NOT NULL,
  `contact_city` varchar(100) CHARACTER SET latin2 NOT NULL,
  `contact_zip` varchar(20) CHARACTER SET latin2 NOT NULL,
  `contact_street` varchar(200) CHARACTER SET latin2 NOT NULL,
  `contact_location` varchar(100) CHARACTER SET latin2 NOT NULL,
  `contact_date_created` datetime NOT NULL,
  `contact_created_by` varchar(100) CHARACTER SET latin2 NOT NULL,
  `contact_assign_to` varchar(200) CHARACTER SET latin2 NOT NULL,
  `contact_password` varchar(100) CHARACTER SET latin2 NOT NULL,
  `contact_profile` varchar(200) CHARACTER SET latin2 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`contact_id`, `contact_fname`, `contact_mname`, `contact_lname`, `contact_bdate`, `contact_gender`, `contact_email`, `contact_fbname`, `contact_messenger`, `contact_cpnum`, `contact_country`, `contact_city`, `contact_zip`, `contact_street`, `contact_location`, `contact_date_created`, `contact_created_by`, `contact_assign_to`, `contact_password`, `contact_profile`) VALUES
(80, 'Dingdong1', 'M.1', 'Dantes1', '2020-04-01', 'Female', 'dingdong@gmail.com', 'learnardo@yahoo.com2', '12', '567891', 'Afghanistan', 'Davao City1', '23451', 'Bajada1', 'bayan park aurora hill baguio city1', '2020-04-27 17:32:25', '1', '49,68,288,49,61,264,52,64,282', '9Vd2puf18A', '142512-JPG.jp.jpg'),
(83, 'Maja', 'B,', 'Salvador', '2020-04-16', 'Female', 'dasd@gmail.com', 'juan@yahoo.com', '', '2345', 'Philippines', 'Select City / Municipality', '', '', 'Davao City', '2020-04-28 11:49:00', '6', '49,61,263', 'xlcV5sUQt8', '31495-maja-salvador-1.jpg'),
(86, 'dasd', 'D.', 'La Cruz', '2020-06-01', 'Male', 'juandelacruz@gmail.com', 'learnardo@yahoo.com', 'http/messenger', '22', 'Philippines', 'Davao City', '2345', 'Bajada', '22', '2020-06-03 15:07:31', '1', '49,61,264,49,68,290', '2j0xBOaNpK', ''),
(87, 'Juna', 'D.', 'La Cruz', '2020-06-02', 'Male', 'juandelacruz@gmail.com', 'learnardo@yahoo.com', 'asdasd', '56789', 'Philippines', 'Davao City', '2345', 'Bajada', '22', '2020-06-03 15:08:02', '1', '57,71,287', 'MFx6lPJb5a', ''),
(98, 'Aunte', 'D.', 'Judite', '2020-07-15', 'Female', 'sam@gmail.com', 'kat@yahoo.com', 'juan@ss.com', '56789', 'Philippines', 'Select City / Municipality', '2345', 'Davao City', 'bayan park aurora hill baguio city', '2020-07-27 15:31:45', '1', '49,61,262', '7I5pJ3Yq9a', ''),
(99, 'Kirk', 'S.', 'Salvador', '2020-07-15', 'Male', 'dasd@gmail.com', 'learnardo@yahoo.com', 'Assign to', '158523', 'Philippines', 'Select City / Municipality', '2345', 'Davao City', 'ASDFG', '2020-07-29 10:01:32', '1', '49,61,262', 'rSc8sukTy3', '');

-- --------------------------------------------------------

--
-- Table structure for table `email_assign`
--

CREATE TABLE `email_assign` (
  `assign_id` int(11) NOT NULL,
  `assign_by` varchar(11) CHARACTER SET latin2 NOT NULL,
  `assign_email_id` varchar(11) CHARACTER SET latin2 NOT NULL,
  `assign_list_id` varchar(11) CHARACTER SET latin2 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `email_assign`
--

INSERT INTO `email_assign` (`assign_id`, `assign_by`, `assign_email_id`, `assign_list_id`) VALUES
(24, '1', '9', '61'),
(25, '1', '6', '61'),
(26, '1', '2', '61'),
(27, '1', '9', '68'),
(28, '1', '1', '68'),
(29, '1', '1', '64'),
(32, '1', '1', '61'),
(39, '1', '1', '62'),
(40, '1', '1', '66'),
(41, '1', '1', '71'),
(42, '1', '6', '68');

-- --------------------------------------------------------

--
-- Table structure for table `email_format`
--

CREATE TABLE `email_format` (
  `email_id` int(11) NOT NULL,
  `email_created_by` varchar(11) CHARACTER SET latin2 NOT NULL,
  `email_template` varchar(100) CHARACTER SET latin2 NOT NULL,
  `email_name` varchar(100) CHARACTER SET latin2 NOT NULL,
  `email_subject` varchar(100) CHARACTER SET latin2 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `email_format`
--

INSERT INTO `email_format` (`email_id`, `email_created_by`, `email_template`, `email_name`, `email_subject`) VALUES
(1, '1', '1', 'IPASS', 'IPASS'),
(2, '1', '1', 'Sample1', 'Sample2'),
(6, '1', '1', 'IPASS Registration', 'IPASS Registration'),
(9, '1', '1', 'Sample12345', 'Sample12345'),
(16, '1', '1', 'New email', 'New email form');

-- --------------------------------------------------------

--
-- Table structure for table `email_send_history`
--

CREATE TABLE `email_send_history` (
  `email_send_id` int(11) NOT NULL,
  `email_send_date` datetime DEFAULT NULL,
  `email_send_by` int(11) DEFAULT NULL,
  `email_format_id` int(11) DEFAULT NULL,
  `email_send_to` varchar(255) DEFAULT NULL,
  `email_task_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `email_send_history`
--

INSERT INTO `email_send_history` (`email_send_id`, `email_send_date`, `email_send_by`, `email_format_id`, `email_send_to`, `email_task_id`) VALUES
(7, '2020-08-07 05:00:00', 1, 9, 'sam@gmail.com', 241),
(30, '2020-08-07 05:00:00', 1, 6, 'sam@gmail.com', 241);

-- --------------------------------------------------------

--
-- Table structure for table `field`
--

CREATE TABLE `field` (
  `field_id` int(11) NOT NULL,
  `field_order` int(11) NOT NULL,
  `field_space_id` varchar(11) CHARACTER SET latin2 NOT NULL,
  `field_type` varchar(30) CHARACTER SET latin2 NOT NULL,
  `field_name` varchar(50) CHARACTER SET latin2 NOT NULL,
  `field_date_create` datetime NOT NULL,
  `field_col_name` varchar(50) CHARACTER SET latin2 NOT NULL,
  `field_assign_to` varchar(100) CHARACTER SET latin2 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `field`
--

INSERT INTO `field` (`field_id`, `field_order`, `field_space_id`, `field_type`, `field_name`, `field_date_create`, `field_col_name`, `field_assign_to`) VALUES
(274, 1, '49', 'Text', 'sad', '2020-04-16 17:20:05', 'text', '68,288,61,262'),
(275, 2, '49', 'Email', 'Email', '2020-04-16 17:20:09', 'email', '61,262,68,288'),
(276, 4, '49', 'Dropdown', 'Dropdown1', '2020-04-16 17:20:17', 'dropdown', '61,264,68,288'),
(277, 5, '49', 'Phone', 'Phone', '2020-04-16 17:20:22', 'phone', '61,265,68,288'),
(278, 6, '49', 'Date', 'Date payment', '2020-04-16 17:20:26', 'date', '61,267,68,288'),
(279, 7, '49', 'Number', 'Number', '2020-04-16 17:20:31', 'number', '61,267,68,289'),
(285, 1, '50', 'Text', 'Sample text', '2020-04-17 14:51:47', 'sample_text', ''),
(286, 2, '50', 'Email', 'Sample email', '2020-04-17 14:51:58', 'sample_email', ''),
(287, 3, '50', 'Dropdown', 'Sample dropdown', '2020-04-17 14:52:07', 'sample_dropdown', ''),
(288, 4, '50', 'Phone', 'Sample phone', '2020-04-17 14:52:13', 'sample_phone', ''),
(289, 5, '50', 'Date', 'Sample date', '2020-04-17 14:52:20', 'sample_date', ''),
(290, 6, '50', 'Number', 'Sample number', '2020-04-17 14:52:26', 'sample_number', ''),
(291, 7, '50', 'Radio', 'Sample radio', '2020-04-17 14:52:34', 'sample_radio', ''),
(292, 9, '49', 'Textarea', 'SAMPLE TEXTAREA12', '2020-04-20 16:50:41', 'sample_textarea12', '61,269,68,289'),
(293, 8, '49', 'Email', 'EMAIL1234', '2020-04-21 11:40:00', 'email1234', '61,268,68,289'),
(298, 11, '49', 'Dropdown', 'asd', '2020-04-24 16:16:50', 'drop1234', '61,277,68,289'),
(303, 0, '52', 'Textarea', 'SAMPLE1', '2020-04-28 17:38:38', 'sample_38qu', ''),
(304, 1, '52', 'Text', 'SAMPLE2', '2020-04-28 17:38:41', 'sample_41Bh', ''),
(305, 2, '52', 'Email', 'SAMPLE3', '2020-04-28 17:38:43', 'sample_43Wa', ''),
(306, 3, '52', 'Dropdown', 'SAMPLE4', '2020-04-28 17:38:46', 'sample_46YO', ''),
(307, 4, '52', 'Phone', 'SAMPLE5', '2020-04-28 17:38:49', 'sample_49fV', ''),
(308, 5, '52', 'Date', 'SAMPLE', '2020-04-28 17:38:52', 'sample_527p', ''),
(309, 6, '52', 'Number', 'SAMPLE', '2020-04-28 17:38:55', 'sample_55jv', ''),
(310, 7, '52', 'Radio', 'SAMPLE', '2020-04-28 17:38:58', 'sample_58iM', ''),
(311, 10, '49', 'Radio', 'Radio1', '2020-04-29 11:12:55', 'radio1_55l3', '61,276,68,289'),
(312, 1, '54', 'Textarea', 'AAA', '2020-05-06 13:59:59', 'aaa_59oe', ''),
(313, 2, '54', 'Text', 'BBB', '2020-05-06 14:00:04', 'bbb_042U', ''),
(314, 3, '54', 'Email', 'CCC', '2020-05-06 14:00:07', 'ccc_073w', ''),
(315, 4, '54', 'Dropdown', 'DDD', '2020-05-06 14:00:11', 'ddd_11r4', ''),
(316, 5, '54', 'Phone', 'EEE', '2020-05-06 14:00:14', 'eee_14qA', ''),
(317, 6, '54', 'Date', 'FFF', '2020-05-06 14:00:17', 'fff_1728', ''),
(318, 7, '54', 'Number', 'GGG', '2020-05-06 14:00:21', 'ggg_21Pe', ''),
(319, 8, '54', 'Radio', 'HHH', '2020-05-06 14:00:25', 'hhh_25aG', ''),
(342, 3, '49', 'Textarea', 'adasdww', '2020-05-08 13:20:09', 'adasd_09KV', '61,263,68,288'),
(359, 12, '49', 'Radio', 'sss', '2020-05-22 13:16:25', 'sss_25M1', '61,278,68,289'),
(360, 13, '49', 'Date', 'gg', '2020-05-26 13:43:09', 'gg_095h', '61,278,68,289'),
(361, 0, '49', 'Dropdown', 'Sample12345678', '2020-08-04 14:46:23', 'sample12345678_23sw', '');

-- --------------------------------------------------------

--
-- Table structure for table `filter`
--

CREATE TABLE `filter` (
  `filter_id` int(11) NOT NULL,
  `filter_space_id` varchar(11) NOT NULL,
  `filter_user_id` varchar(11) NOT NULL,
  `filter_name` varchar(100) NOT NULL,
  `filter_value` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin2;

-- --------------------------------------------------------

--
-- Table structure for table `finance_child`
--

CREATE TABLE `finance_child` (
  `child_id` int(11) NOT NULL,
  `child_name` varchar(50) CHARACTER SET latin2 NOT NULL,
  `child_field_id` varchar(11) CHARACTER SET latin2 NOT NULL,
  `child_color` varchar(20) CHARACTER SET latin2 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `finance_currency`
--

CREATE TABLE `finance_currency` (
  `currency_id` int(11) NOT NULL,
  `currency_date` datetime NOT NULL,
  `currency_name` varchar(50) CHARACTER SET latin2 NOT NULL,
  `currency_code` varchar(10) CHARACTER SET latin2 NOT NULL,
  `currency_val_usd` varchar(20) CHARACTER SET latin2 NOT NULL,
  `currency_val_php` varchar(20) CHARACTER SET latin2 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `finance_currency`
--

INSERT INTO `finance_currency` (`currency_id`, `currency_date`, `currency_name`, `currency_code`, `currency_val_usd`, `currency_val_php`) VALUES
(1, '2020-07-09 16:18:32', 'Philippine peso', 'PHP', '50.71', '1'),
(2, '2020-07-09 16:14:47', 'U.S. dollar', 'USD', '1', '50.5'),
(3, '2020-07-08 17:10:02', 'Canadian dollar', 'CAD', '0.73', '36.79'),
(4, '2020-07-09 16:00:23', 'Euro', 'EUR', '1.101', '55.75'),
(5, '2020-07-09 16:09:47', 'British pound', 'GBP', '1.23', '62.13'),
(6, '2020-07-09 16:09:03', 'Swiss franc', 'CHF', '1.03', '52.30'),
(7, '2020-07-09 16:09:35', 'New Zealand dollar', 'NZD', '0.621', '31.43'),
(8, '2020-07-09 16:13:46', 'Australian dollar', 'AUD', '0.66', '33.60'),
(9, '2020-08-12 09:22:19', 'Japanese yen', 'JPY', '0.0093', '0.47');

-- --------------------------------------------------------

--
-- Table structure for table `finance_discount`
--

CREATE TABLE `finance_discount` (
  `discount_id` int(11) NOT NULL,
  `discount_by` varchar(20) CHARACTER SET latin2 NOT NULL,
  `discount_phase_id` varchar(20) CHARACTER SET latin2 NOT NULL,
  `discount_assign_to` varchar(20) CHARACTER SET latin2 NOT NULL,
  `discount_amount` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `finance_discount`
--

INSERT INTO `finance_discount` (`discount_id`, `discount_by`, `discount_phase_id`, `discount_assign_to`, `discount_amount`) VALUES
(42, '1', '1', '206', '10'),
(43, '1', '2', '206', '20'),
(44, '1', '4', '206', '10'),
(45, '1', '1', '241', '10');

-- --------------------------------------------------------

--
-- Table structure for table `finance_field`
--

CREATE TABLE `finance_field` (
  `finance_id` int(11) NOT NULL,
  `finance_space_id` varchar(11) CHARACTER SET latin2 NOT NULL,
  `finance_phase_id` varchar(20) CHARACTER SET latin2 NOT NULL,
  `finance_order` int(11) NOT NULL,
  `finance_name` varchar(100) CHARACTER SET latin2 NOT NULL,
  `finance_currency` varchar(20) CHARACTER SET latin2 NOT NULL,
  `finance_value` varchar(20) CHARACTER SET latin2 NOT NULL,
  `finance_type` varchar(20) CHARACTER SET latin2 NOT NULL,
  `finance_privacy` varchar(20) CHARACTER SET latin2 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `finance_field`
--

INSERT INTO `finance_field` (`finance_id`, `finance_space_id`, `finance_phase_id`, `finance_order`, `finance_name`, `finance_currency`, `finance_value`, `finance_type`, `finance_privacy`) VALUES
(63, '49', '1', 0, 'Payment1', 'USD', '400.50', 'text', 'Public'),
(69, '49', '2', 0, 'Sample1', 'USD', '110', 'text', 'Public'),
(71, '49', '2', 1, 'Sample2', 'USD', '120', 'text', 'Public'),
(86, '49', '4', 0, 'Sample1', 'USD', '1000', 'text', 'Private'),
(87, '49', '4', 1, 'Sample2', 'USD', '100', 'text', 'Public'),
(89, '49', '12', 0, 'adasds', 'PHP', '22', 'text', 'Public'),
(90, '49', '12', 1, 'asdddd', '', '10.2', 'dropdown', 'Public'),
(94, '49', '2', 3, 'fff', 'USD', '20', 'text', 'Public'),
(100, '49', '1', 1, 'Payment2', 'USD', '77.5', 'text', 'Public'),
(101, '49', '9', 0, 'dd', 'USD', '100', 'text', 'Public'),
(102, '49', '18', 0, 'SAMPL12345', 'USD', '500', 'text', 'Public'),
(115, '49', '19', 0, 'SAMPL123459456123', 'JPY', '0.93', 'text', 'Public'),
(116, '49', '19', 1, 'SAMPL12345', 'PHP', '1.97', 'text', 'Public'),
(117, '49', '19', 2, 'asdadasdcxz', 'CAD', '73.00', 'text', 'Public'),
(118, '49', '19', 3, 'yguhijokl9856', 'USD', '100.00', 'text', 'Private'),
(121, '49', '19', 4, 'GHJAKMSL,DASD', 'AUD', '66.00', 'text', 'Private'),
(122, '52', '6', 0, 'SAMPL123459456123', 'USD', '1000.00', 'text', 'Public');

-- --------------------------------------------------------

--
-- Table structure for table `finance_field_ca`
--

CREATE TABLE `finance_field_ca` (
  `custom_amount_id` int(11) NOT NULL,
  `custom_amount_user_id` varchar(11) CHARACTER SET latin2 NOT NULL,
  `custom_amount_task_id` varchar(11) CHARACTER SET latin2 NOT NULL,
  `custom_amount_field_id` varchar(11) CHARACTER SET latin2 NOT NULL,
  `custom_amount_value` varchar(30) CHARACTER SET latin2 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `finance_field_ca`
--

INSERT INTO `finance_field_ca` (`custom_amount_id`, `custom_amount_user_id`, `custom_amount_task_id`, `custom_amount_field_id`, `custom_amount_value`) VALUES
(5, '1', '241', '115', '100');

-- --------------------------------------------------------

--
-- Table structure for table `finance_field_hide`
--

CREATE TABLE `finance_field_hide` (
  `hideshow_id` int(11) NOT NULL,
  `hideshow_user_id` varchar(11) CHARACTER SET latin2 NOT NULL,
  `hideshow_task_id` varchar(11) CHARACTER SET latin2 NOT NULL,
  `hideshow_field_id` varchar(11) CHARACTER SET latin2 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `finance_field_hide`
--

INSERT INTO `finance_field_hide` (`hideshow_id`, `hideshow_user_id`, `hideshow_task_id`, `hideshow_field_id`) VALUES
(98, '1', '206', '63');

-- --------------------------------------------------------

--
-- Table structure for table `finance_phase`
--

CREATE TABLE `finance_phase` (
  `phase_id` int(11) NOT NULL,
  `phase_space_id` int(11) NOT NULL,
  `phase_name` varchar(100) CHARACTER SET latin2 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `finance_phase`
--

INSERT INTO `finance_phase` (`phase_id`, `phase_space_id`, `phase_name`) VALUES
(1, 49, 'Phase1: Credintial Evaluation'),
(2, 49, 'Phase2: Evaluation'),
(3, 50, 'Phase1: Sample'),
(4, 49, 'Phase3: Examination'),
(6, 52, 'Phase1: Payment'),
(7, 52, 'Phase2: Evaluation'),
(9, 49, 'Phase4: Final'),
(18, 49, 'sample122122'),
(19, 49, 'Phase 5: SAMPLE');

-- --------------------------------------------------------

--
-- Table structure for table `finance_remarks`
--

CREATE TABLE `finance_remarks` (
  `remarks_id` int(11) NOT NULL,
  `remarks_by` varchar(20) CHARACTER SET latin2 NOT NULL,
  `remarks_to` varchar(20) CHARACTER SET latin2 NOT NULL,
  `remarks_phase_id` varchar(20) CHARACTER SET latin2 NOT NULL,
  `remarks_value` varchar(50) CHARACTER SET latin2 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `finance_remarks`
--

INSERT INTO `finance_remarks` (`remarks_id`, `remarks_by`, `remarks_to`, `remarks_phase_id`, `remarks_value`) VALUES
(10, '1', '206', '1', 'Pending'),
(11, '1', '206', '2', 'Payment received'),
(12, '1', '241', '4', 'Payment received'),
(13, '1', '241', '1', 'Payment received'),
(14, '1', '241', '2', 'Payment received'),
(15, '1', '241', '19', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `finance_transaction`
--

CREATE TABLE `finance_transaction` (
  `val_id` int(11) NOT NULL,
  `val_add_by` int(20) NOT NULL,
  `val_phase_id` varchar(11) CHARACTER SET latin2 NOT NULL,
  `val_assign_to` varchar(11) CHARACTER SET latin2 NOT NULL,
  `val_date` date NOT NULL,
  `val_method` varchar(50) CHARACTER SET latin2 NOT NULL,
  `val_transaction_no` varchar(50) CHARACTER SET latin2 NOT NULL,
  `val_currency` varchar(30) CHARACTER SET latin2 NOT NULL,
  `val_amount` varchar(20) CHARACTER SET latin2 NOT NULL,
  `val_charge` varchar(20) CHARACTER SET latin2 NOT NULL,
  `val_initial_amount` varchar(20) CHARACTER SET latin2 NOT NULL,
  `val_usd_rate` varchar(20) CHARACTER SET latin2 NOT NULL,
  `val_usd_total` varchar(20) CHARACTER SET latin2 NOT NULL,
  `val_php_rate` varchar(20) CHARACTER SET latin2 NOT NULL,
  `val_php_total` varchar(20) CHARACTER SET latin2 NOT NULL,
  `val_client_rate` varchar(20) CHARACTER SET latin2 NOT NULL,
  `val_client_total` varchar(20) CHARACTER SET latin2 NOT NULL,
  `val_note` varchar(500) CHARACTER SET latin2 NOT NULL,
  `val_attachment` varchar(300) CHARACTER SET latin2 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `finance_transaction`
--

INSERT INTO `finance_transaction` (`val_id`, `val_add_by`, `val_phase_id`, `val_assign_to`, `val_date`, `val_method`, `val_transaction_no`, `val_currency`, `val_amount`, `val_charge`, `val_initial_amount`, `val_usd_rate`, `val_usd_total`, `val_php_rate`, `val_php_total`, `val_client_rate`, `val_client_total`, `val_note`, `val_attachment`) VALUES
(138, 1, '1', '206', '2020-07-13', 'BDO PI', 'ASDFG2345', 'USD', '10', 'USD|1', '9.00', '1', '9.00', '50.5', '454.50', '50', '450.00', 'asd', '151502-151204.png'),
(139, 1, '1', '206', '2020-07-19', 'BDO PI', 'ASDFG2345', '50', '10', 'USD|1  ', '8.39', '0.621', '5.21', '31.43', '263.70', '50', '419.50', 'asd', '132653-Captur.PNG'),
(140, 1, '1', '206', '2020-09-03', 'BDO PJ', 'ASDFG2346', '50', '1', 'USD|1               ', '-0.61', '0.621', '-0.38', '31.43', '-19.17', '50', '-30.50', 'asd', '101902-saitam.jpg'),
(141, 1, '3', '209', '2020-08-14', 'BDO PI', 'ASDFG2345', 'USD', '400', '|', '400.00', '1', '400.00', '50.5', '20200.00', '50', '20000.00', 'Sample', '163626-JPEG.j.jpeg'),
(142, 1, '2', '209', '2020-07-31', 'BDO DI', '1111', '10', '100', 'USD|10 ', '90.00', '1', '90.00', '50.5', '4545.00', '10', '900.00', 'Sample', '130732-Commen.png'),
(143, 1, '1', '209', '2020-08-17', 'BDO PI', 'ASDFG2345', '50', '100', 'PHP|5 ', '95.00', '50.71', '1.87', '1', '95.00', '50', '4750.00', 'Sample', '133114-replac.PNG'),
(144, 1, '2', '206', '2020-08-12', 'BDO PI', 'ASDFG2345', 'USD', '100', 'USD|10', '90.00', '1', '90.00', '50.5', '4545.00', '50.48', '4543.20', '', '101639-151204.png'),
(145, 1, '2', '206', '2020-08-12', 'BDO PI', 'ASDFG2345', 'USD', '100', 'USD|10', '90.00', '1', '90.00', '50.5', '4545.00', '50.48', '4543.20', '', '101654-151204.png'),
(146, 1, '2', '206', '2020-08-12', 'BDO PI', 'ASDFG2345', 'USD', '100', 'USD|10', '90.00', '1', '90.00', '50.5', '4545.00', '50.48', '4543.20', '', '101716-JPG.jp.jpg'),
(147, 1, '2', '206', '2020-08-12', 'BDO PI', 'ASDFG2345', 'USD', '100', 'USD|10', '90.00', '1', '90.00', '50.5', '4545.00', '50.48', '4543.20', '', '101814-151204.png'),
(148, 1, '1', '241', '2020-07-31', 'BDO PI', 'ASDFG2345', 'USD', '100', 'USD|10', '90.00', '1', '90.00', '50.5', '4545.00', '50.48', '4543.20', '', '104445-JPG.jp.jpg'),
(149, 1, '1', '241', '2020-08-05', 'BDO PI', 'ASDFG2345', 'CAD', '100', 'USD|10', '86.30', '0.73', '63.00', '36.79', '3174.98', '50.48', '4356.42', '', '105108-JPEG.j.jpeg'),
(150, 1, '1', '224', '2020-08-17', 'BDO DI', 'ASDFG2345', 'USD', '100', 'USD|10', '90.00', '1', '90.00', '50.5', '4545.00', '50.48', '4543.20', '', '161226-JPG.jp.jpg'),
(151, 1, '6', '236', '2020-08-16', 'BDO PI', 'ASDFG2345', 'USD', '100', 'USD|10', '90.00', '1', '90.00', '50.5', '4545.00', '50.48', '4543.20', '', '164734-JPG.jp.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `list`
--

CREATE TABLE `list` (
  `list_id` int(20) NOT NULL,
  `list_name` varchar(100) NOT NULL,
  `list_space_id` varchar(20) NOT NULL,
  `list_date_created` datetime NOT NULL,
  `list_assign_id` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin2;

--
-- Dumping data for table `list`
--

INSERT INTO `list` (`list_id`, `list_name`, `list_space_id`, `list_date_created`, `list_assign_id`) VALUES
(61, 'Arizona List', '49', '2020-04-15 13:20:12', '4,3,1,6,2,11,10,9'),
(62, 'Pensilvania list', '50', '2020-04-15 15:44:52', ''),
(64, 'Texas List', '52', '2020-04-20 16:49:23', '1,6'),
(65, 'Private list', '53', '2020-04-27 14:51:56', ''),
(66, 'Sample List1', '54', '2020-05-06 13:53:46', '1'),
(68, 'List2', '49', '0000-00-00 00:00:00', '4,1'),
(71, 'America list', '57', '2020-06-19 17:55:40', '1'),
(74, 'Sample2 list', '60', '2020-07-06 10:00:44', ''),
(76, 'List3 sample', '62', '2020-08-17 09:39:50', '');

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `id` int(11) NOT NULL,
  `sender_id` varchar(20) CHARACTER SET latin2 NOT NULL,
  `message` varchar(1500) CHARACTER SET latin2 NOT NULL,
  `reciever_id` varchar(20) CHARACTER SET latin2 NOT NULL,
  `chat_date` datetime NOT NULL,
  `code` varchar(20) CHARACTER SET latin2 NOT NULL,
  `attachment` varchar(200) CHARACTER SET latin2 NOT NULL,
  `status` varchar(20) CHARACTER SET latin2 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`id`, `sender_id`, `message`, `reciever_id`, `chat_date`, `code`, `attachment`, `status`) VALUES
(65, '5', 'Sample attachment GIF', '1', '2020-04-02 17:44:47', '5,1', '200402-174447 GIF.gif', '0'),
(73, '1', '', '5', '2020-04-03 14:26:49', '1,5', '200403-142649 JPEG.jpeg', '0'),
(78, '5', 'Nice one', '1', '2020-04-03 15:18:53', '5,1', '', '0'),
(86, '5', 'HAI', '1', '2020-04-03 17:07:07', '5,1', '', '0'),
(87, '5', 'Hai', '1', '2020-04-10 12:59:00', '5,1', '', '0'),
(88, '1', 'Low', '5', '2020-04-10 12:59:30', '1,5', '', '0'),
(89, '5', '1234', '1', '2020-04-10 12:59:59', '5,1', '', '0'),
(91, '1', '', '5', '2020-04-23 10:23:04', '1,5', '200423-102304 CSV.csv', '1'),
(92, '6', 'Hai', '1', '2020-04-27 14:18:08', '6,1', '', '0'),
(93, '1', 'Low', '6', '2020-04-27 14:21:00', '1,6', '', '0'),
(98, '6', '', '1', '2020-04-27 15:23:28', '6,1', '200427-152328 CSV.csv', '0'),
(100, '6', 'Hai', '2', '2020-05-07 14:44:27', '6,2', '', '0'),
(101, '2', 'Low', '6', '2020-05-07 14:44:38', '2,6', '', '0'),
(112, '6', 'Hai', '1', '2020-05-12 14:24:06', '6,1', '', '0'),
(113, '1', 'Low', '6', '2020-05-12 14:24:19', '1,6', '', '0'),
(114, '6', '1234', '1', '2020-05-12 14:26:30', '6,1', '', '0'),
(124, '1', 'dd', '6', '2020-05-12 14:50:14', '1,6', '', '0'),
(126, '1', 'asd', '6', '2020-05-12 14:53:10', '1,6', '', '0'),
(128, '6', 'ddd', '1', '2020-05-12 14:53:57', '6,1', '', '0'),
(129, '1', 'asfsda', '5', '2020-08-05 11:38:33', '1,5', '', '1'),
(130, '1', 'asfsd', '5', '2020-08-05 11:38:39', '1,5', '', '1'),
(131, '1', 'sfsadf', '2', '2020-08-05 11:38:49', '1,2', '', '1'),
(132, '1', 'dgsdgsd', '3', '2020-08-05 11:39:01', '1,3', '', '1'),
(133, '1', 'fsad', '5', '2020-08-12 09:21:48', '1,5', '', '1'),
(134, '1', 'fsfsa', '5', '2020-08-12 09:21:53', '1,5', '', '1');

-- --------------------------------------------------------

--
-- Table structure for table `mode`
--

CREATE TABLE `mode` (
  `mode_id` int(11) NOT NULL,
  `mode_user_id` int(11) NOT NULL,
  `mode_type` varchar(30) CHARACTER SET latin2 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mode`
--

INSERT INTO `mode` (`mode_id`, `mode_user_id`, `mode_type`) VALUES
(17, 2, 'Dark'),
(18, 1, 'Dark');

-- --------------------------------------------------------

--
-- Table structure for table `requirement_child`
--

CREATE TABLE `requirement_child` (
  `child_id` int(11) NOT NULL,
  `child_name` varchar(100) CHARACTER SET latin2 NOT NULL,
  `child_field_id` varchar(11) CHARACTER SET latin2 NOT NULL,
  `child_color` varchar(20) CHARACTER SET latin2 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `requirement_child`
--

INSERT INTO `requirement_child` (`child_id`, `child_name`, `child_field_id`, `child_color`) VALUES
(11, 'Complete', '19', '#48A509'),
(12, 'Incomplete', '19', '#EE0000'),
(13, 'Onhold', '19', '#BFC304');

-- --------------------------------------------------------

--
-- Table structure for table `requirement_comment`
--

CREATE TABLE `requirement_comment` (
  `comment_id` int(11) NOT NULL,
  `comment_task_id` varchar(11) NOT NULL,
  `comment_user_id` varchar(11) NOT NULL,
  `comment_message` varchar(500) NOT NULL,
  `comment_date` datetime NOT NULL,
  `comment_attactment` varchar(500) NOT NULL,
  `comment_type` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin2;

--
-- Dumping data for table `requirement_comment`
--

INSERT INTO `requirement_comment` (`comment_id`, `comment_task_id`, `comment_user_id`, `comment_message`, `comment_date`, `comment_attactment`, `comment_type`) VALUES
(70, '206', '2', 'Sample Text', '2020-06-18 10:52:40', '', ''),
(71, '206', '2', 'Attachment', '2020-06-18 10:52:48', '105248-151204.png', ''),
(72, '206', '2', 'Update field name: \"Sample Text1\" value: \"Text1\".', '2020-06-18 10:52:51', '', '1'),
(73, '206', '2', 'Update field name: \"Status\" value: \"Complete\".', '2020-06-18 10:53:15', '', '1'),
(74, '206', '1', 'Update field name: \"Sample Text2\" value: \"Text2\".', '2020-06-18 10:53:49', '', '1'),
(75, '206', '1', 'ddd', '2020-07-28 16:33:19', '', ''),
(76, '209', '1', 'Update field name: \"Sample Text1\" value: \"Done\".', '2020-08-04 09:06:08', '', '1'),
(77, '209', '1', 'sffsdf', '2020-08-04 09:06:29', '', ''),
(87, '241', '1', 'Update field name: \"Sample Text2\" value: \"asdasd\".', '2020-08-13 11:11:20', '', '1'),
(88, '241', '1', 'Update field name: \"Sample Text1\" value: \"dasf\".', '2020-08-13 11:11:20', '', '1'),
(89, '241', '1', 'Update field name: \"Status\" value: \"Complete\".', '2020-08-13 11:18:08', '', '1'),
(90, '241', '1', 'Update field name: \"Status\" value: \"Incomplete\".', '2020-08-13 11:31:03', '', '1'),
(91, '241', '1', 'Update field name: \"Status\" value: \"Complete\".', '2020-08-13 11:38:15', '', '1'),
(92, '241', '1', 'Update field name: \"Status\" value: \"Incomplete\".', '2020-08-17 11:02:30', '', '1');

-- --------------------------------------------------------

--
-- Table structure for table `requirement_field`
--

CREATE TABLE `requirement_field` (
  `requirement_id` int(11) NOT NULL,
  `requirement_order_no` int(11) NOT NULL,
  `requirement_space_id` varchar(11) CHARACTER SET latin2 NOT NULL,
  `requirement_type` varchar(30) CHARACTER SET latin2 NOT NULL,
  `requirement_privacy` varchar(30) CHARACTER SET latin2 NOT NULL,
  `requirement_name` varchar(100) CHARACTER SET latin2 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `requirement_field`
--

INSERT INTO `requirement_field` (`requirement_id`, `requirement_order_no`, `requirement_space_id`, `requirement_type`, `requirement_privacy`, `requirement_name`) VALUES
(18, 1, '49', 'Text', 'Public', 'Sample Text2'),
(19, 2, '49', 'Dropdown', 'Public', 'Status'),
(23, 0, '49', 'Text', 'Public', 'Sample Text1');

-- --------------------------------------------------------

--
-- Table structure for table `requirement_value`
--

CREATE TABLE `requirement_value` (
  `value_id` int(11) NOT NULL,
  `value_by` varchar(11) CHARACTER SET latin2 NOT NULL,
  `value_to` varchar(11) CHARACTER SET latin2 NOT NULL,
  `value_field_id` varchar(11) CHARACTER SET latin2 NOT NULL,
  `value_value` varchar(100) CHARACTER SET latin2 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `requirement_value`
--

INSERT INTO `requirement_value` (`value_id`, `value_by`, `value_to`, `value_field_id`, `value_value`) VALUES
(24, '1', '206', '23', 'Text1'),
(25, '1', '206', '19', '11'),
(26, '1', '206', '18', 'Text2'),
(27, '1', '209', '23', 'Done'),
(28, '1', '241', '23', 'dasf'),
(29, '1', '241', '18', 'asdasd'),
(30, '1', '241', '19', '12');

-- --------------------------------------------------------

--
-- Table structure for table `sort`
--

CREATE TABLE `sort` (
  `sort_id` int(11) NOT NULL,
  `sort_space_id` int(11) NOT NULL,
  `sort_user_id` int(11) NOT NULL,
  `sort_name` varchar(20) NOT NULL,
  `sort_type` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin2;

-- --------------------------------------------------------

--
-- Table structure for table `space`
--

CREATE TABLE `space` (
  `space_id` int(20) NOT NULL,
  `space_name` varchar(100) NOT NULL,
  `space_type` varchar(50) NOT NULL,
  `space_date_created` datetime NOT NULL,
  `space_db_table` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin2;

--
-- Dumping data for table `space`
--

INSERT INTO `space` (`space_id`, `space_name`, `space_type`, `space_date_created`, `space_db_table`) VALUES
(49, 'Arizona ada a dsdadads asdas d', 'IPASS Processing Workspace', '2020-04-15 13:20:12', 'z04152012_ari'),
(50, 'Pensilvania', 'IPASS Processing Workspace', '2020-04-15 15:44:52', 'z04154452_pen'),
(52, 'Texas', 'IPASS Processing Workspace', '2020-04-20 16:49:22', 'z04204922_tex'),
(53, 'Private', 'Private', '2020-04-27 14:51:56', 'z04275156_pri'),
(54, 'Sample1', 'IPASS Processing Workspace', '2020-05-06 13:53:46', 'z05065345_sam'),
(57, 'America', 'IPASS Processing Workspace', '2020-06-19 17:55:40', 'z06195540_ame'),
(60, 'Sample2', 'Private', '2020-07-06 10:00:44', 'z07060043_sam'),
(62, 'Sample3 Space', 'IPASS Processing Workspace', '2020-08-17 09:39:50', 'z08173950_sam_spa');

-- --------------------------------------------------------

--
-- Table structure for table `space_sort`
--

CREATE TABLE `space_sort` (
  `sort_id` int(11) NOT NULL,
  `sort_user_id` varchar(11) CHARACTER SET latin2 NOT NULL,
  `sort_space_id` varchar(11) CHARACTER SET latin2 NOT NULL,
  `sort_space_order` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `space_sort`
--

INSERT INTO `space_sort` (`sort_id`, `sort_user_id`, `sort_space_id`, `sort_space_order`) VALUES
(68, '1', '49', 0),
(69, '1', '57', 2),
(70, '1', '50', 1),
(71, '1', '53', 5),
(72, '1', '54', 3),
(73, '1', '60', 4),
(74, '1', '52', 6),
(75, '1', '62', 8);

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `status_id` int(20) NOT NULL,
  `status_order_no` int(11) NOT NULL,
  `status_name` varchar(100) NOT NULL,
  `status_color` varchar(50) NOT NULL,
  `status_list_id` varchar(20) NOT NULL,
  `status__date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin2;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`status_id`, `status_order_no`, `status_name`, `status_color`, `status_list_id`, `status__date_created`) VALUES
(262, 0, 'Step 1 Phase 1as ad asd adsad', '#8ad00c', '61', '2020-04-13 15:41:13'),
(263, 1, 'Step 1 Phase 2 asdasd asdasd', '#bfc304', '61', '2020-04-13 15:41:20'),
(264, 2, 'Step 1 Phase 3', '#6FAD00', '61', '2020-04-13 15:41:29'),
(265, 3, 'Step 2 Phase 1', '#ca0b85', '61', '2020-04-13 15:41:43'),
(266, 10, 'Close', '#017514', '61', '2020-04-13 15:42:20'),
(267, 4, 'Step 2 Phase 2', '#000000', '61', '2020-04-13 15:42:52'),
(268, 5, 'Step 2 Phase 3', '#05981d', '61', '2020-04-14 15:41:36'),
(269, 6, 'Step 3 Phase 1', '#5600AD', '61', '2020-04-14 15:42:01'),
(270, 0, 'Step 1 Phase 1', '#0088AD', '62', '2020-04-15 15:45:43'),
(271, 1, 'Step 1 Phase 2', '#017514', '62', '2020-04-17 14:44:05'),
(272, 2, 'Step 1 Phase 3', '#5600AD', '62', '2020-04-17 14:44:09'),
(273, 3, 'Step 2 Phase 1', '#00AD1D', '62', '2020-04-17 14:44:31'),
(274, 4, 'Step 2 Phase 2', '#0015AD', '62', '2020-04-17 14:44:41'),
(275, 5, 'Close', '#827a71', '62', '2020-04-17 14:44:55'),
(276, 7, 'Step 3 Phase 2', '#827a71', '61', '2020-04-20 13:16:04'),
(277, 8, 'Step 3 Phase 3', '#440386', '61', '2020-04-20 13:16:11'),
(278, 9, 'Step 4 Phase 1', '#d47604', '61', '2020-04-20 13:17:28'),
(282, 0, 'Step 1 Phase 1', '#00AD67', '64', '2020-04-28 16:54:32'),
(284, 1, 'Step 1 Phase 1', '#b90453', '66', '2020-05-06 13:54:02'),
(287, 0, 'Step 1 Phase 1', '#5600AD', '71', '2020-06-22 09:25:20'),
(288, 0, 'Step 1 Phase 1 asd asd asdasd asddasd adddsd asdasd', '#6FAD00', '68', '2020-06-25 13:13:33'),
(289, 1, 'Step 1 Phase 2', '#AD9000', '68', '2020-06-26 13:32:35'),
(290, 2, 'Close', '#005FAD', '68', '2020-07-06 15:54:27'),
(292, 0, 'Step 1 Phase 1', '#000000', '76', '2020-08-17 09:40:03'),
(293, 1, 'Step 1 Phase 2', '#b90453', '76', '2020-08-17 09:40:37');

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `tag_id` int(20) NOT NULL,
  `tag_name` varchar(100) NOT NULL,
  `tag_list_id` varchar(20) NOT NULL,
  `tag_color` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin2;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`tag_id`, `tag_name`, `tag_list_id`, `tag_color`) VALUES
(20, 'Tasg1234', '61', '#f5ba87'),
(21, 'Sample', '61', '#f8bdf9'),
(22, 'null 13223 adsds', '61', '#b5e094');

-- --------------------------------------------------------

--
-- Table structure for table `task`
--

CREATE TABLE `task` (
  `task_id` int(20) NOT NULL,
  `task_name` varchar(100) NOT NULL,
  `task_order_no` varchar(20) NOT NULL,
  `task_status_id` varchar(20) NOT NULL,
  `task_list_id` varchar(20) NOT NULL,
  `task_created_by` varchar(11) NOT NULL,
  `task_date_created` date DEFAULT NULL,
  `task_due_date` date DEFAULT NULL,
  `task_priority` varchar(20) NOT NULL,
  `task_tag` varchar(300) NOT NULL,
  `task_assign_to` varchar(300) NOT NULL,
  `task_contact` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin2;

--
-- Dumping data for table `task`
--

INSERT INTO `task` (`task_id`, `task_name`, `task_order_no`, `task_status_id`, `task_list_id`, `task_created_by`, `task_date_created`, `task_due_date`, `task_priority`, `task_tag`, `task_assign_to`, `task_contact`) VALUES
(206, 'Dingdong1 M.1 Dantes1', '', '264', '61', '1', '2020-07-27', '2020-07-27', 'D Urgent', '22,21', '2,3,11', '80'),
(209, 'Maja B, Salvador', '', '263', '61', '3', '2020-07-28', '2020-07-29', 'D Urgent', '21,22', '4,1,2', '83'),
(224, 'Dingdong1 M.1 Dantes1', '', '288', '68', '1', '2020-06-25', '0000-00-00', '', '', '4,1', '80'),
(236, 'dasd D. La Cruz', '', '264', '61', '1', '2020-07-01', '2020-07-31', 'C High', '', '1,10,6', '86'),
(237, 'dasd D. La Cruz', '', '290', '68', '1', '2020-08-10', '0000-00-00', '', '', '', '86'),
(239, 'Dingdong1 M.1 Dantes1', '', '282', '64', '1', '2020-07-06', '0000-00-00', '', '', '1', '80'),
(240, 'Juna D. La Cruz', '', '287', '71', '1', '2020-07-12', '0000-00-00', '', '', '', '87'),
(241, 'Aunte D. Judite', '', '262', '61', '1', '2020-08-10', '2020-08-14', 'D Urgent', '', '1,4', '98'),
(242, 'Kirk S. Salvador', '', '262', '61', '1', '2020-08-13', '0000-00-00', '', '', '1,4', '99');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(20) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `mname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `address` varchar(200) NOT NULL,
  `contact_number` varchar(15) NOT NULL,
  `email` varchar(200) NOT NULL,
  `bdate` date NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `user_type` varchar(20) NOT NULL,
  `profile_pic` varchar(200) NOT NULL,
  `user_color` varchar(20) NOT NULL,
  `team` varchar(50) NOT NULL,
  `log` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin2;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `fname`, `mname`, `lname`, `address`, `contact_number`, `email`, `bdate`, `username`, `password`, `user_type`, `profile_pic`, `user_color`, `team`, `log`) VALUES
(1, 'Admin1a11', 'J.', 'Adminasd', 'Davao City', '09507539819', 'nicodamejaucila@gmail.com', '1997-12-05', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'Admin', '104240-5cd220.jpg', '#AD0000', 'Team Davao', 1),
(2, 'Nicodame', 'J.', 'Aucila', '111', '111', 'aucilanicodamej@gmail.com', '2020-01-07', 'nico', '410ec15153a6dff0bed851467309bcbd', 'Member', '64401-386ac21811a8ae746abafdd3a78533d7--mens-short-hairstyles--men-hairstyles.jpg', '#5600AD', 'Team Davao', 0),
(3, 'Ronel', 'asd', 'Ocstero', 'asd', '1234', 'gilmar@gmail.com', '0000-00-00', 'ronel', '8679706534fa2fbe83c8a2ade62e666a', 'Member', '', '#0088AD', 'Team Davao', 0),
(4, 'Christian', 's', 'Sabijon', 'sss', '7890', 'Erwin@gmail.com', '2020-03-05', 'christian', '2fa51b6310807beecb789c764d8a6ac8', 'Member', '', '#00AD1D', 'Team Davao', 0),
(5, 'Gilmar', 'E.', 'Padua', 'Davao City222', '456789', 'gilmar@gmail.com', '0000-00-00', 'gilmar', 'f2721d21d588ee07d81fc543cd9d52b3', 'Admin', '54276-69570-gilmar-photo.jpg', '#AD9000', 'Team Davao', 0),
(6, 'Erwin1', 'E.', 'Tulfo', 'Davao City222', '456789', 'gilmar@gmail.com', '2020-04-07', 'erwin', 'ab23e695da88403af009dd1bfa84b696', 'Supervisory', '85746-mens-professional-hairstyle1.jpg', '#5C797C', 'Team Davao', 0),
(9, 'James', 'A', 'Bond', 'Davao City', '1234', 'dasd@gmail.com', '2020-04-07', 'james', 'ffed880985d9e700410b9cb7133f0517', '', '', '#39595C', '', 0),
(10, 'Peter', 'A.', 'Bongcales', 'Davao City', '456789', 'dasd@gmail.com', '2020-04-14', 'peter', '9170711da32d96229baf98f9904c7fcc', 'Member', '', '#AD9000', '', 0),
(11, 'Roque', 'M.', 'Day', 'Davao City', '456789', 'dasd@gmail.com', '2020-04-02', 'roque', '0f4810049bad90a2098fa3eb7decb90d', 'Member', '', '#6FAD00', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `z04152012_ari`
--

CREATE TABLE `z04152012_ari` (
  `id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `text` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `dropdown` varchar(50) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `date` date NOT NULL,
  `number` varchar(50) NOT NULL,
  `sample_textarea12` varchar(1000) NOT NULL,
  `email1234` varchar(50) NOT NULL,
  `drop1234` varchar(50) NOT NULL,
  `radio1_55l3` varchar(50) NOT NULL,
  `adasd_09KV` varchar(1000) NOT NULL,
  `sss_25M1` varchar(50) NOT NULL,
  `gg_095h` date NOT NULL,
  `sample12345678_23sw` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin2;

--
-- Dumping data for table `z04152012_ari`
--

INSERT INTO `z04152012_ari` (`id`, `task_id`, `text`, `email`, `dropdown`, `phone`, `date`, `number`, `sample_textarea12`, `email1234`, `drop1234`, `radio1_55l3`, `adasd_09KV`, `sss_25M1`, `gg_095h`, `sample12345678_23sw`) VALUES
(17, 206, 'TEXT11', 'dasd@gmail.com', '61', '456789', '2020-04-08', '12323', '', 'dasd@gmail.com', '73', 'yes', 'asdasd', '', '0000-00-00', '88'),
(20, 209, 'sss2', 'dd@gmai.com', '62', '', '2020-05-25', '', '', '', '', '', 'asdasd', '', '0000-00-00', '88'),
(27, 224, 'asd', 'gilmar@gmail.com', '61', '456789', '2020-07-05', '', '', '', '', '', 'asd', '', '2020-07-05', ''),
(39, 236, '', 'dasd@gmail.com', '', '', '0000-00-00', '', '', '', '', 'no', 'asdasd', 'no', '0000-00-00', ''),
(40, 237, '', '', '', '', '0000-00-00', '', '', '', '', '', '', '', '0000-00-00', ''),
(41, 241, 'TEXT', 'dasd@gmail.com', '', '', '0000-00-00', '', '', '', '', '', '', '', '0000-00-00', ''),
(42, 242, '', '', '', '', '0000-00-00', '', '', '', '', '', '', '', '0000-00-00', '');

-- --------------------------------------------------------

--
-- Table structure for table `z04154452_pen`
--

CREATE TABLE `z04154452_pen` (
  `id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `texareass` varchar(50) NOT NULL,
  `sample_text` varchar(50) NOT NULL,
  `sample_email` varchar(50) NOT NULL,
  `sample_dropdown` varchar(50) NOT NULL,
  `sample_phone` varchar(50) NOT NULL,
  `sample_date` date NOT NULL,
  `sample_number` varchar(50) NOT NULL,
  `sample_radio` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin2;

-- --------------------------------------------------------

--
-- Table structure for table `z04204922_tex`
--

CREATE TABLE `z04204922_tex` (
  `id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `sample_38qu` varchar(1000) NOT NULL,
  `sample_41Bh` varchar(50) NOT NULL,
  `sample_43Wa` varchar(50) NOT NULL,
  `sample_46YO` varchar(50) NOT NULL,
  `sample_49fV` varchar(50) NOT NULL,
  `sample_527p` date NOT NULL,
  `sample_55jv` varchar(50) NOT NULL,
  `sample_58iM` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin2;

--
-- Dumping data for table `z04204922_tex`
--

INSERT INTO `z04204922_tex` (`id`, `task_id`, `sample_38qu`, `sample_41Bh`, `sample_43Wa`, `sample_46YO`, `sample_49fV`, `sample_527p`, `sample_55jv`, `sample_58iM`) VALUES
(4, 239, '', '', '', '', '', '0000-00-00', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `z04275156_pri`
--

CREATE TABLE `z04275156_pri` (
  `id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin2;

-- --------------------------------------------------------

--
-- Table structure for table `z05065345_sam`
--

CREATE TABLE `z05065345_sam` (
  `id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `aaa_59oe` varchar(1000) NOT NULL,
  `bbb_042U` varchar(50) NOT NULL,
  `ccc_073w` varchar(50) NOT NULL,
  `ddd_11r4` varchar(50) NOT NULL,
  `eee_14qA` varchar(50) NOT NULL,
  `fff_1728` date NOT NULL,
  `ggg_21Pe` varchar(50) NOT NULL,
  `hhh_25aG` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin2;

-- --------------------------------------------------------

--
-- Table structure for table `z06195540_ame`
--

CREATE TABLE `z06195540_ame` (
  `id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin2;

--
-- Dumping data for table `z06195540_ame`
--

INSERT INTO `z06195540_ame` (`id`, `task_id`) VALUES
(1, 240);

-- --------------------------------------------------------

--
-- Table structure for table `z07060043_sam`
--

CREATE TABLE `z07060043_sam` (
  `id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin2;

-- --------------------------------------------------------

--
-- Table structure for table `z08173950_sam_spa`
--

CREATE TABLE `z08173950_sam_spa` (
  `id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin2;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `add_column`
--
ALTER TABLE `add_column`
  ADD PRIMARY KEY (`column_id`);

--
-- Indexes for table `child`
--
ALTER TABLE `child`
  ADD PRIMARY KEY (`child_id`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`contact_id`);

--
-- Indexes for table `email_assign`
--
ALTER TABLE `email_assign`
  ADD PRIMARY KEY (`assign_id`);

--
-- Indexes for table `email_format`
--
ALTER TABLE `email_format`
  ADD PRIMARY KEY (`email_id`);

--
-- Indexes for table `email_send_history`
--
ALTER TABLE `email_send_history`
  ADD PRIMARY KEY (`email_send_id`);

--
-- Indexes for table `field`
--
ALTER TABLE `field`
  ADD PRIMARY KEY (`field_id`);

--
-- Indexes for table `filter`
--
ALTER TABLE `filter`
  ADD PRIMARY KEY (`filter_id`);

--
-- Indexes for table `finance_child`
--
ALTER TABLE `finance_child`
  ADD PRIMARY KEY (`child_id`);

--
-- Indexes for table `finance_currency`
--
ALTER TABLE `finance_currency`
  ADD PRIMARY KEY (`currency_id`);

--
-- Indexes for table `finance_discount`
--
ALTER TABLE `finance_discount`
  ADD PRIMARY KEY (`discount_id`);

--
-- Indexes for table `finance_field`
--
ALTER TABLE `finance_field`
  ADD PRIMARY KEY (`finance_id`);

--
-- Indexes for table `finance_field_ca`
--
ALTER TABLE `finance_field_ca`
  ADD PRIMARY KEY (`custom_amount_id`);

--
-- Indexes for table `finance_field_hide`
--
ALTER TABLE `finance_field_hide`
  ADD PRIMARY KEY (`hideshow_id`);

--
-- Indexes for table `finance_phase`
--
ALTER TABLE `finance_phase`
  ADD PRIMARY KEY (`phase_id`);

--
-- Indexes for table `finance_remarks`
--
ALTER TABLE `finance_remarks`
  ADD PRIMARY KEY (`remarks_id`);

--
-- Indexes for table `finance_transaction`
--
ALTER TABLE `finance_transaction`
  ADD PRIMARY KEY (`val_id`);

--
-- Indexes for table `list`
--
ALTER TABLE `list`
  ADD PRIMARY KEY (`list_id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mode`
--
ALTER TABLE `mode`
  ADD PRIMARY KEY (`mode_id`);

--
-- Indexes for table `requirement_child`
--
ALTER TABLE `requirement_child`
  ADD PRIMARY KEY (`child_id`);

--
-- Indexes for table `requirement_comment`
--
ALTER TABLE `requirement_comment`
  ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `requirement_field`
--
ALTER TABLE `requirement_field`
  ADD PRIMARY KEY (`requirement_id`);

--
-- Indexes for table `requirement_value`
--
ALTER TABLE `requirement_value`
  ADD PRIMARY KEY (`value_id`);

--
-- Indexes for table `sort`
--
ALTER TABLE `sort`
  ADD PRIMARY KEY (`sort_id`);

--
-- Indexes for table `space`
--
ALTER TABLE `space`
  ADD PRIMARY KEY (`space_id`);

--
-- Indexes for table `space_sort`
--
ALTER TABLE `space_sort`
  ADD PRIMARY KEY (`sort_id`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`status_id`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`tag_id`);

--
-- Indexes for table `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`task_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `z04152012_ari`
--
ALTER TABLE `z04152012_ari`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `z04154452_pen`
--
ALTER TABLE `z04154452_pen`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `z04204922_tex`
--
ALTER TABLE `z04204922_tex`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `z04275156_pri`
--
ALTER TABLE `z04275156_pri`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `z05065345_sam`
--
ALTER TABLE `z05065345_sam`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `z06195540_ame`
--
ALTER TABLE `z06195540_ame`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `z07060043_sam`
--
ALTER TABLE `z07060043_sam`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `z08173950_sam_spa`
--
ALTER TABLE `z08173950_sam_spa`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `add_column`
--
ALTER TABLE `add_column`
  MODIFY `column_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT for table `child`
--
ALTER TABLE `child`
  MODIFY `child_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=526;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `contact_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT for table `email_assign`
--
ALTER TABLE `email_assign`
  MODIFY `assign_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `email_format`
--
ALTER TABLE `email_format`
  MODIFY `email_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `email_send_history`
--
ALTER TABLE `email_send_history`
  MODIFY `email_send_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `field`
--
ALTER TABLE `field`
  MODIFY `field_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=362;

--
-- AUTO_INCREMENT for table `filter`
--
ALTER TABLE `filter`
  MODIFY `filter_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=569;

--
-- AUTO_INCREMENT for table `finance_child`
--
ALTER TABLE `finance_child`
  MODIFY `child_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `finance_currency`
--
ALTER TABLE `finance_currency`
  MODIFY `currency_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `finance_discount`
--
ALTER TABLE `finance_discount`
  MODIFY `discount_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `finance_field`
--
ALTER TABLE `finance_field`
  MODIFY `finance_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123;

--
-- AUTO_INCREMENT for table `finance_field_ca`
--
ALTER TABLE `finance_field_ca`
  MODIFY `custom_amount_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `finance_field_hide`
--
ALTER TABLE `finance_field_hide`
  MODIFY `hideshow_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- AUTO_INCREMENT for table `finance_phase`
--
ALTER TABLE `finance_phase`
  MODIFY `phase_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `finance_remarks`
--
ALTER TABLE `finance_remarks`
  MODIFY `remarks_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `finance_transaction`
--
ALTER TABLE `finance_transaction`
  MODIFY `val_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=152;

--
-- AUTO_INCREMENT for table `list`
--
ALTER TABLE `list`
  MODIFY `list_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=135;

--
-- AUTO_INCREMENT for table `mode`
--
ALTER TABLE `mode`
  MODIFY `mode_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `requirement_child`
--
ALTER TABLE `requirement_child`
  MODIFY `child_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `requirement_comment`
--
ALTER TABLE `requirement_comment`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT for table `requirement_field`
--
ALTER TABLE `requirement_field`
  MODIFY `requirement_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `requirement_value`
--
ALTER TABLE `requirement_value`
  MODIFY `value_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `sort`
--
ALTER TABLE `sort`
  MODIFY `sort_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT for table `space`
--
ALTER TABLE `space`
  MODIFY `space_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `space_sort`
--
ALTER TABLE `space_sort`
  MODIFY `sort_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
  MODIFY `status_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=294;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `tag_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `task`
--
ALTER TABLE `task`
  MODIFY `task_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=244;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `z04152012_ari`
--
ALTER TABLE `z04152012_ari`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `z04154452_pen`
--
ALTER TABLE `z04154452_pen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `z04204922_tex`
--
ALTER TABLE `z04204922_tex`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `z04275156_pri`
--
ALTER TABLE `z04275156_pri`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `z05065345_sam`
--
ALTER TABLE `z05065345_sam`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `z06195540_ame`
--
ALTER TABLE `z06195540_ame`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `z07060043_sam`
--
ALTER TABLE `z07060043_sam`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `z08173950_sam_spa`
--
ALTER TABLE `z08173950_sam_spa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
