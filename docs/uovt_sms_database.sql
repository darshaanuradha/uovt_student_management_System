-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 06, 2026 at 05:51 AM
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
-- Database: `uovt_sms`
--

DELIMITER $$
--
-- Procedures
--
DROP PROCEDURE IF EXISTS `AddDepartment`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `AddDepartment` (IN `p_name` VARCHAR(255))   BEGIN
    INSERT INTO departments (dept_name)
    VALUES (p_name);
END$$

DROP PROCEDURE IF EXISTS `AddLecturer`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `AddLecturer` (IN `p_name` VARCHAR(100), IN `p_email` VARCHAR(100), IN `p_dept_id` INT)   BEGIN
    INSERT INTO lecturers (name, email, dept_id)
    VALUES (p_name, p_email, p_dept_id);
END$$

DROP PROCEDURE IF EXISTS `DeleteDepartment`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `DeleteDepartment` (IN `p_id` INT)   BEGIN
    IF p_id IS NULL OR p_id <= 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Invalid department ID';
    END IF;

    DELETE FROM departments
    WHERE dept_id = p_id;

    IF ROW_COUNT() = 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Department not found';
    END IF;

END$$

DROP PROCEDURE IF EXISTS `delete_lecturer`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `delete_lecturer` (IN `p_lecturer_id` INT)   BEGIN
    DELETE FROM lecturers 
    WHERE lecturer_id = p_lecturer_id;
END$$

DROP PROCEDURE IF EXISTS `EnrollStudent`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `EnrollStudent` (IN `p_student_id` INT, IN `p_course_id` INT)   BEGIN
    DECLARE exit handler for sqlexception
    BEGIN
        ROLLBACK;
    END;

    START TRANSACTION;

    INSERT INTO enrollments (student_id, course_id)
    VALUES (p_student_id, p_course_id);

    UPDATE courses
    SET total_enrolled = total_enrolled + 1
    WHERE course_id = p_course_id;

    COMMIT;
END$$

DROP PROCEDURE IF EXISTS `GetDepartmentById`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `GetDepartmentById` (IN `p_id` INT)   BEGIN
    SELECT dept_id, dept_name
    FROM departments
    WHERE dept_id = p_id;
END$$

DROP PROCEDURE IF EXISTS `insert_lecturer`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_lecturer` (IN `p_name` VARCHAR(255), IN `p_email` VARCHAR(255), IN `p_dept_id` INT)   BEGIN
    INSERT INTO lecturers (name, email, dept_id)
    VALUES (p_name, p_email, p_dept_id);

    SELECT LAST_INSERT_ID() AS lecturer_id, 'SUCCESS' AS status;
END$$

DROP PROCEDURE IF EXISTS `sp_delete_course`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_delete_course` (IN `p_course_id` INT)   BEGIN
    DELETE FROM courses WHERE course_id = p_course_id;
END$$

DROP PROCEDURE IF EXISTS `sp_delete_student`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_delete_student` (IN `p_student_id` INT)   BEGIN
    DELETE FROM students
    WHERE student_id = p_student_id;
END$$

DROP PROCEDURE IF EXISTS `sp_get_all_lecturers`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_get_all_lecturers` ()   BEGIN
    SELECT lecturer_id, name FROM lecturers ORDER BY name ASC;
END$$

DROP PROCEDURE IF EXISTS `sp_get_courses`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_get_courses` ()   BEGIN
    SELECT
        c.course_id,
        c.course_name,
        c.total_enrolled,
        l.lecturer_id,
        l.name AS lecturer_name
    FROM courses c
    LEFT JOIN lecturers l ON c.lecturer_id = l.lecturer_id
    ORDER BY c.course_id ASC;
END$$

DROP PROCEDURE IF EXISTS `sp_get_course_by_id`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_get_course_by_id` (IN `p_course_id` INT)   BEGIN
    SELECT
        c.course_id,
        c.course_name,
        c.lecturer_id,
        c.total_enrolled
    FROM courses c
    WHERE c.course_id = p_course_id;
END$$

DROP PROCEDURE IF EXISTS `sp_get_students`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_get_students` ()   BEGIN
SELECT student_id,
    first_name,
    last_name,
    contact_email
FROM students
ORDER BY student_id DESC;
END$$

DROP PROCEDURE IF EXISTS `sp_get_student_by_id`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_get_student_by_id` (IN `p_student_id` INT)   BEGIN
    SELECT student_id, first_name, last_name, contact_email
    FROM students
    WHERE student_id = p_student_id;
END$$

DROP PROCEDURE IF EXISTS `sp_insert_course`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insert_course` (IN `p_course_name` VARCHAR(150), IN `p_lecturer_id` INT)   BEGIN
    INSERT INTO courses (course_name, lecturer_id)
    VALUES (p_course_name, p_lecturer_id);
END$$

DROP PROCEDURE IF EXISTS `sp_insert_student`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insert_student` (IN `p_first_name` VARCHAR(50), IN `p_last_name` VARCHAR(50), IN `p_contact_email` VARCHAR(100))   BEGIN
INSERT INTO students (first_name, last_name, contact_email)
VALUES (p_first_name, p_last_name, p_contact_email);
END$$

DROP PROCEDURE IF EXISTS `sp_search_students`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_search_students` (IN `keyword` VARCHAR(100))   BEGIN
    SELECT *
    FROM students
    WHERE first_name LIKE CONCAT('%', keyword, '%')
       OR last_name LIKE CONCAT('%', keyword, '%')
       OR contact_email LIKE CONCAT('%', keyword, '%');
END$$

DROP PROCEDURE IF EXISTS `sp_update_course`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_update_course` (IN `p_course_id` INT, IN `p_course_name` VARCHAR(150), IN `p_lecturer_id` INT)   BEGIN
    UPDATE courses
    SET
        course_name  = p_course_name,
        lecturer_id  = p_lecturer_id
    WHERE course_id = p_course_id;
END$$

DROP PROCEDURE IF EXISTS `sp_update_student`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_update_student` (IN `p_student_id` INT, IN `p_first_name` VARCHAR(50), IN `p_last_name` VARCHAR(50), IN `p_contact_email` VARCHAR(100))   BEGIN
    UPDATE students
    SET first_name = p_first_name,
        last_name = p_last_name,
        contact_email = p_contact_email
    WHERE student_id = p_student_id;
END$$

DROP PROCEDURE IF EXISTS `UpdateDepartment`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `UpdateDepartment` (IN `p_id` INT, IN `p_name` VARCHAR(255))   BEGIN
    IF p_id IS NULL OR p_id <= 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Invalid department ID';
    END IF;

    IF p_name IS NULL OR TRIM(p_name) = '' THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Department name cannot be empty';
    END IF;

    UPDATE departments
    SET dept_name = TRIM(p_name)
    WHERE dept_id = p_id;

    IF ROW_COUNT() = 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Department not found or no change';
    END IF;

END$$

DROP PROCEDURE IF EXISTS `update_lecturer`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `update_lecturer` (IN `p_lecturer_id` INT, IN `p_name` VARCHAR(255), IN `p_email` VARCHAR(255), IN `p_dept_id` INT)   BEGIN
    UPDATE lecturers 
    SET 
        name = p_name,
        email = p_email,
        dept_id = p_dept_id
    WHERE lecturer_id = p_lecturer_id;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

DROP TABLE IF EXISTS `courses`;
CREATE TABLE IF NOT EXISTS `courses` (
  `course_id` int NOT NULL AUTO_INCREMENT,
  `course_name` varchar(150) NOT NULL,
  `lecturer_id` int DEFAULT NULL,
  `total_enrolled` int DEFAULT '0',
  PRIMARY KEY (`course_id`),
  KEY `lecturer_id` (`lecturer_id`),
  KEY `idx_course_name` (`course_name`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`course_id`, `course_name`, `lecturer_id`, `total_enrolled`) VALUES
(1, 'Web Application Development', 3, 1),
(2, 'Project Management', 4, 1),
(3, 'Construction Technology', 2, 3),
(4, 'Educational Psychology', 1, 1),
(5, 'Advanced Database Systems', 1, 2),
(6, 'Cyber Security Fundamentals', 6, 1),
(7, 'Artificial Intelligence Concepts', 7, 0),
(8, 'Software Engineering Principles', 5, 4);

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

DROP TABLE IF EXISTS `departments`;
CREATE TABLE IF NOT EXISTS `departments` (
  `dept_id` int NOT NULL AUTO_INCREMENT,
  `dept_name` varchar(100) NOT NULL,
  PRIMARY KEY (`dept_id`),
  UNIQUE KEY `dept_name` (`dept_name`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`dept_id`, `dept_name`) VALUES
(1, 'Business Management'),
(2, 'Quantity Surveying'),
(3, 'Education Technology'),
(4, 'Information Technology'),
(5, 'Software Engineering'),
(6, 'Network Engineering'),
(7, 'Cyber Security'),
(8, 'Data Science'),
(9, 'Artificial Intelligence'),
(10, 'Project Management');

-- --------------------------------------------------------

--
-- Table structure for table `enrollments`
--

DROP TABLE IF EXISTS `enrollments`;
CREATE TABLE IF NOT EXISTS `enrollments` (
  `enrollment_id` int NOT NULL AUTO_INCREMENT,
  `student_id` int DEFAULT NULL,
  `course_id` int DEFAULT NULL,
  `enrollment_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`enrollment_id`),
  UNIQUE KEY `student_id` (`student_id`,`course_id`),
  KEY `course_id` (`course_id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `enrollments`
--

INSERT INTO `enrollments` (`enrollment_id`, `student_id`, `course_id`, `enrollment_date`) VALUES
(1, 38, 6, '2026-05-06 03:40:42'),
(2, 31, 8, '2026-05-06 03:40:47'),
(3, 16, 4, '2026-05-06 03:40:54'),
(4, 9, 5, '2026-05-06 03:41:00'),
(5, 11, 5, '2026-05-06 03:41:08'),
(6, 16, 1, '2026-05-06 03:41:15'),
(7, 70, 3, '2026-05-06 03:41:52'),
(8, 40, 2, '2026-05-06 03:41:57'),
(9, 11, 3, '2026-05-06 03:42:03'),
(10, 31, 3, '2026-05-06 03:42:09'),
(11, 58, 8, '2026-05-06 03:42:16'),
(12, 61, 8, '2026-05-06 03:42:22'),
(13, 70, 8, '2026-05-06 03:42:29');

--
-- Triggers `enrollments`
--
DROP TRIGGER IF EXISTS `After_Enrollment_Delete`;
DELIMITER $$
CREATE TRIGGER `After_Enrollment_Delete` AFTER DELETE ON `enrollments` FOR EACH ROW BEGIN
    UPDATE courses SET total_enrolled = total_enrolled - 1 WHERE course_id = OLD.course_id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `lecturers`
--

DROP TABLE IF EXISTS `lecturers`;
CREATE TABLE IF NOT EXISTS `lecturers` (
  `lecturer_id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `dept_id` int DEFAULT NULL,
  PRIMARY KEY (`lecturer_id`),
  UNIQUE KEY `email` (`email`),
  KEY `dept_id` (`dept_id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `lecturers`
--

INSERT INTO `lecturers` (`lecturer_id`, `name`, `email`, `dept_id`) VALUES
(1, 'Dr. Perera', 'perera@uovt.ac.lk', 5),
(2, 'Mr. Fernando', 'fernando@uovt.ac.lk', 6),
(3, 'Ms. Silva', 'silva@uovt.ac.lk', 7),
(4, 'Dr. Wickramasinghe', 'wickrama@uovt.ac.lk', 8),
(5, 'Mr. De Silva', 'desilva@uovt.ac.lk', 9),
(6, 'Ms. Karunaratne', 'karuna@uovt.ac.lk', 10),
(7, 'Dr. Rajapaksha', 'rajapaksha@uovt.ac.lk', 1),
(8, 'Mr. Senanayake', 'senanayake@uovt.ac.lk', 2),
(9, 'Ms. Dias', 'dias@uovt.ac.lk', 3),
(10, 'Dr. Abeysinghe', 'abey@uovt.ac.lk', 4),
(11, 'Mr. Madushanka', 'madushanka@uovt.ac.lk', 5);

-- --------------------------------------------------------

--
-- Stand-in structure for view `lecturer_departments_view`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `lecturer_departments_view`;
CREATE TABLE IF NOT EXISTS `lecturer_departments_view` (
`dept_name` varchar(100)
,`email` varchar(100)
,`lecturer_id` int
,`name` varchar(100)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `lecture_department_view`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `lecture_department_view`;
CREATE TABLE IF NOT EXISTS `lecture_department_view` (
`dept_name` varchar(100)
,`email` varchar(100)
,`lecturer_id` int
,`name` varchar(100)
);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

DROP TABLE IF EXISTS `students`;
CREATE TABLE IF NOT EXISTS `students` (
  `student_id` int NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `contact_email` varchar(100) NOT NULL,
  PRIMARY KEY (`student_id`),
  UNIQUE KEY `contact_email` (`contact_email`),
  KEY `idx_student_name` (`last_name`),
  KEY `idx_student_full_name` (`first_name`,`last_name`),
  KEY `idx_student_email` (`contact_email`)
) ENGINE=MyISAM AUTO_INCREMENT=77 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_id`, `first_name`, `last_name`, `contact_email`) VALUES
(1, 'Nimal', 'Perera', 'nimal1@uovt.ac.lk'),
(2, 'Saman', 'Fernando', 'saman1@uovt.ac.lk'),
(3, 'Kavindi', 'Silva', 'kavindi1@uovt.ac.lk'),
(4, 'Tharindu', 'Perera', 'tharindu1@uovt.ac.lk'),
(5, 'Ishara', 'Gunawardena', 'ishara1@uovt.ac.lk'),
(6, 'Malsha', 'Senanayake', 'malsha1@uovt.ac.lk'),
(7, 'Dilan', 'Rajapaksha', 'dilan1@uovt.ac.lk'),
(8, 'Piumi', 'Karunaratne', 'piumi1@uovt.ac.lk'),
(9, 'Sanduni', 'Dias', 'sanduni1@uovt.ac.lk'),
(10, 'Ravindu', 'Perera', 'ravindu1@uovt.ac.lk'),
(11, 'Ashen', 'Fernando', 'ashen1@uovt.ac.lk'),
(12, 'Nisala', 'Silva', 'nisala1@uovt.ac.lk'),
(13, 'Vihangi', 'Perera', 'vihangi1@uovt.ac.lk'),
(14, 'Supun', 'Gunasekara', 'supun1@uovt.ac.lk'),
(15, 'Madushi', 'Perera', 'madushi1@uovt.ac.lk'),
(16, 'Gayan', 'Fernando', 'gayan1@uovt.ac.lk'),
(17, 'Thilini', 'Silva', 'thilini1@uovt.ac.lk'),
(18, 'Chamod', 'Perera', 'chamod1@uovt.ac.lk'),
(19, 'Hasini', 'Fernando', 'hasini1@uovt.ac.lk'),
(20, 'Udara', 'Silva', 'udara1@uovt.ac.lk'),
(21, 'Kasuni', 'Perera', 'kasuni1@uovt.ac.lk'),
(22, 'Chathura', 'Fernando', 'chathura1@uovt.ac.lk'),
(23, 'Rashmi', 'Silva', 'rashmi1@uovt.ac.lk'),
(24, 'Dinuka', 'Perera', 'dinuka1@uovt.ac.lk'),
(25, 'Lakshmi', 'Fernando', 'lakshmi1@uovt.ac.lk'),
(26, 'Sajith', 'Silva', 'sajith1@uovt.ac.lk'),
(27, 'Nadeesha', 'Perera', 'nadeesha1@uovt.ac.lk'),
(28, 'Ramesh', 'Fernando', 'ramesh1@uovt.ac.lk'),
(29, 'Iresha', 'Silva', 'iresha1@uovt.ac.lk'),
(30, 'Janith', 'Perera', 'janith1@uovt.ac.lk'),
(31, 'Sandaru', 'Fernando', 'sandaru1@uovt.ac.lk'),
(32, 'Dinesh', 'Silva', 'dinesh1@uovt.ac.lk'),
(33, 'Harini', 'Perera', 'harini1@uovt.ac.lk'),
(34, 'Suresh', 'Fernando', 'suresh1@uovt.ac.lk'),
(35, 'Imesha', 'Silva', 'imesha1@uovt.ac.lk'),
(36, 'Rukshan', 'Perera', 'rukshan1@uovt.ac.lk'),
(37, 'Samanthi', 'Fernando', 'samanthi1@uovt.ac.lk'),
(38, 'Kelum', 'Silva', 'kelum1@uovt.ac.lk'),
(39, 'Shanika', 'Perera', 'shanika1@uovt.ac.lk'),
(40, 'Praveen', 'Fernando', 'praveen1@uovt.ac.lk'),
(41, 'Nirosha', 'Silva', 'nirosha1@uovt.ac.lk'),
(42, 'Dulanjan', 'Perera', 'dulanjan1@uovt.ac.lk'),
(43, 'Sanjeewa', 'Fernando', 'sanjeewa1@uovt.ac.lk'),
(44, 'Pabasara', 'Silva', 'pabasara1@uovt.ac.lk'),
(45, 'Ravishka', 'Perera', 'ravishka1@uovt.ac.lk'),
(46, 'Ashani', 'Fernando', 'ashani1@uovt.ac.lk'),
(47, 'Sithumina', 'Silva', 'sithumina1@uovt.ac.lk'),
(48, 'Dilhani', 'Perera', 'dilhani1@uovt.ac.lk'),
(49, 'Kavishka', 'Fernando', 'kavishka1@uovt.ac.lk'),
(50, 'Tharushi', 'Silva', 'tharushi1@uovt.ac.lk'),
(51, 'Rangana', 'Perera', 'rangana1@uovt.ac.lk'),
(52, 'Manoj', 'Fernando', 'manoj1@uovt.ac.lk'),
(53, 'Shashika', 'Silva', 'shashika1@uovt.ac.lk'),
(54, 'Gihan', 'Perera', 'gihan1@uovt.ac.lk'),
(55, 'Nipuni', 'Fernando', 'nipuni1@uovt.ac.lk'),
(56, 'Roshan', 'Silva', 'roshan1@uovt.ac.lk'),
(57, 'Duminda', 'Perera', 'duminda1@uovt.ac.lk'),
(58, 'Anjali', 'Fernando', 'anjali1@uovt.ac.lk'),
(59, 'Chinthaka', 'Silva', 'chinthaka1@uovt.ac.lk'),
(60, 'Sahan', 'Perera', 'sahan1@uovt.ac.lk'),
(61, 'Kanchana', 'Fernando', 'kanchana1@uovt.ac.lk'),
(62, 'Roshani', 'Silva', 'roshani1@uovt.ac.lk'),
(63, 'Vishwa', 'Perera', 'vishwa1@uovt.ac.lk'),
(64, 'Chamari', 'Fernando', 'chamari1@uovt.ac.lk'),
(65, 'Pasindu', 'Silva', 'pasindu1@uovt.ac.lk'),
(66, 'Tharanga', 'Perera', 'tharanga1@uovt.ac.lk'),
(67, 'Nayana', 'Fernando', 'nayana1@uovt.ac.lk'),
(68, 'Upeksha', 'Silva', 'upeksha1@uovt.ac.lk'),
(69, 'Janaka', 'Perera', 'janaka1@uovt.ac.lk'),
(70, 'Dilrukshi', 'Fernando', 'dilrukshi1@uovt.ac.lk'),
(71, 'Rukmini', 'Silva', 'rukmini1@uovt.ac.lk'),
(72, 'Shehan', 'Perera', 'shehan1@uovt.ac.lk'),
(73, 'Yasiru', 'Fernando', 'yasiru1@uovt.ac.lk'),
(74, 'Malini', 'Silva', 'malini1@uovt.ac.lk'),
(75, 'Isuru', 'Perera', 'isuru1@uovt.ac.lk'),
(76, 'Darsha', 'Anuradha', 'darsha.anuradha2020@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `system_users`
--

DROP TABLE IF EXISTS `system_users`;
CREATE TABLE IF NOT EXISTS `system_users` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('Admin','User') DEFAULT 'User',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `system_users`
--

INSERT INTO `system_users` (`user_id`, `email`, `password_hash`, `role`) VALUES
(1, 'perera@uovt.ac.lk', '$2y$10$a1f5yoIkKN8zFBQ2.2p2heEWPjL1NhX.tovcAlgY1PiIPo9JzrU5a', 'User'),
(2, 'silva@uovt.ac.lk', '$2y$10$a1f5yoIkKN8zFBQ2.2p2heEWPjL1NhX.tovcAlgY1PiIPo9JzrU5a', 'User'),
(3, 'nimal@uovt.ac.lk', '$2y$10$a1f5yoIkKN8zFBQ2.2p2heEWPjL1NhX.tovcAlgY1PiIPo9JzrU5a', 'User'),
(4, 'ayesha@uovt.ac.lk', '$2y$10$a1f5yoIkKN8zFBQ2.2p2heEWPjL1NhX.tovcAlgY1PiIPo9JzrU5a', 'User'),
(5, 'admin@uovt.ac.lk', '$2y$10$a1f5yoIkKN8zFBQ2.2p2heEWPjL1NhX.tovcAlgY1PiIPo9JzrU5a', 'Admin');

-- --------------------------------------------------------

--
-- Stand-in structure for view `viewenrollments`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `viewenrollments`;
CREATE TABLE IF NOT EXISTS `viewenrollments` (
`course_id` int
,`course_name` varchar(150)
,`enrollment_date` timestamp
,`enrollment_id` int
,`first_name` varchar(50)
,`last_name` varchar(50)
,`student_id` int
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_departments`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `view_departments`;
CREATE TABLE IF NOT EXISTS `view_departments` (
`dept_id` int
,`dept_name` varchar(100)
);

-- --------------------------------------------------------

--
-- Structure for view `lecturer_departments_view`
--
DROP TABLE IF EXISTS `lecturer_departments_view`;

DROP VIEW IF EXISTS `lecturer_departments_view`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `lecturer_departments_view`  AS SELECT `l`.`lecturer_id` AS `lecturer_id`, `l`.`name` AS `name`, `l`.`email` AS `email`, `d`.`dept_name` AS `dept_name` FROM (`lecturers` `l` join `departments` `d` on((`l`.`dept_id` = `d`.`dept_id`))) ;

-- --------------------------------------------------------

--
-- Structure for view `lecture_department_view`
--
DROP TABLE IF EXISTS `lecture_department_view`;

DROP VIEW IF EXISTS `lecture_department_view`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `lecture_department_view`  AS SELECT `l`.`lecturer_id` AS `lecturer_id`, `l`.`name` AS `name`, `l`.`email` AS `email`, `d`.`dept_name` AS `dept_name` FROM (`lecturers` `l` join `departments` `d` on((`l`.`dept_id` = `d`.`dept_id`))) ;

-- --------------------------------------------------------

--
-- Structure for view `viewenrollments`
--
DROP TABLE IF EXISTS `viewenrollments`;

DROP VIEW IF EXISTS `viewenrollments`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viewenrollments`  AS SELECT `e`.`enrollment_id` AS `enrollment_id`, `e`.`enrollment_date` AS `enrollment_date`, `s`.`student_id` AS `student_id`, `s`.`first_name` AS `first_name`, `s`.`last_name` AS `last_name`, `c`.`course_id` AS `course_id`, `c`.`course_name` AS `course_name` FROM ((`enrollments` `e` join `students` `s` on((`e`.`student_id` = `s`.`student_id`))) join `courses` `c` on((`e`.`course_id` = `c`.`course_id`))) ORDER BY `e`.`enrollment_date` DESC ;

-- --------------------------------------------------------

--
-- Structure for view `view_departments`
--
DROP TABLE IF EXISTS `view_departments`;

DROP VIEW IF EXISTS `view_departments`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_departments`  AS SELECT `departments`.`dept_id` AS `dept_id`, `departments`.`dept_name` AS `dept_name` FROM `departments` ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
