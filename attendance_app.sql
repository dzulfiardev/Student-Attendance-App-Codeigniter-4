-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 02 Apr 2021 pada 04.43
-- Versi server: 10.1.35-MariaDB
-- Versi PHP: 7.2.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `attendance_app`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `admin_id` int(11) NOT NULL,
  `admin_user_name` varchar(100) DEFAULT NULL,
  `admin_password` varchar(200) DEFAULT NULL,
  `user_created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_admin`
--

INSERT INTO `tbl_admin` (`admin_id`, `admin_user_name`, `admin_password`, `user_created_at`) VALUES
(1, 'admin', '$2y$10$9yZmj8v28Kc4Saodu32JuuoSz9z18bBsU1MpGRiTUi4AaXBGNfsPK', '2021-03-20 04:32:56');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_attendance`
--

CREATE TABLE `tbl_attendance` (
  `attendance_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `attendance_status` enum('Absent','Present') NOT NULL,
  `attendance_date` date NOT NULL,
  `teacher_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_attendance`
--

INSERT INTO `tbl_attendance` (`attendance_id`, `student_id`, `attendance_status`, `attendance_date`, `teacher_id`) VALUES
(49, 5, 'Present', '2021-03-01', 15),
(50, 6, 'Present', '2021-03-01', 15),
(51, 7, 'Present', '2021-03-01', 15),
(52, 8, 'Present', '2021-03-01', 15),
(53, 5, 'Present', '2021-03-02', 15),
(54, 6, 'Absent', '2021-03-02', 15),
(55, 7, 'Present', '2021-03-02', 15),
(56, 8, 'Absent', '2021-03-02', 15),
(57, 5, 'Absent', '2021-03-03', 15),
(58, 6, 'Present', '2021-03-03', 15),
(59, 7, 'Absent', '2021-03-03', 15),
(60, 8, 'Absent', '2021-03-03', 15),
(91, 1, 'Present', '2021-03-01', 6),
(92, 2, 'Present', '2021-03-01', 6),
(93, 3, 'Present', '2021-03-01', 6),
(94, 4, 'Present', '2021-03-01', 6),
(95, 9, 'Present', '2021-03-01', 6),
(96, 1, 'Present', '2021-03-02', 6),
(97, 2, 'Absent', '2021-03-02', 6),
(98, 3, 'Absent', '2021-03-02', 6),
(99, 4, 'Present', '2021-03-02', 6),
(100, 9, 'Present', '2021-03-02', 6),
(101, 1, 'Present', '2021-03-03', 6),
(102, 2, 'Present', '2021-03-03', 6),
(103, 3, 'Present', '2021-03-03', 6),
(104, 4, 'Present', '2021-03-03', 6),
(105, 9, 'Absent', '2021-03-03', 6),
(106, 1, 'Present', '2021-03-04', 6),
(107, 2, 'Present', '2021-03-04', 6),
(108, 3, 'Present', '2021-03-04', 6),
(109, 4, 'Present', '2021-03-04', 6),
(110, 9, 'Present', '2021-03-04', 6),
(111, 5, 'Present', '2021-03-04', 15),
(112, 6, 'Present', '2021-03-04', 15),
(113, 7, 'Present', '2021-03-04', 15),
(114, 8, 'Absent', '2021-03-04', 15),
(115, 1, 'Present', '2021-03-05', 6),
(116, 2, 'Present', '2021-03-05', 6),
(117, 3, 'Absent', '2021-03-05', 6),
(118, 4, 'Present', '2021-03-05', 6),
(119, 9, 'Present', '2021-03-05', 6),
(120, 1, 'Present', '2021-03-07', 6),
(121, 2, 'Present', '2021-03-07', 6),
(122, 3, 'Present', '2021-03-07', 6),
(123, 4, 'Present', '2021-03-07', 6),
(124, 9, 'Present', '2021-03-07', 6);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_grade`
--

CREATE TABLE `tbl_grade` (
  `grade_id` int(11) NOT NULL,
  `grade_name` varchar(111) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_grade`
--

INSERT INTO `tbl_grade` (`grade_id`, `grade_name`) VALUES
(1, '11 - A'),
(2, '11 - B'),
(3, '12 - A'),
(4, '12 - B'),
(18, '11 - C'),
(19, '12 - C');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_student`
--

CREATE TABLE `tbl_student` (
  `student_id` int(11) NOT NULL,
  `student_name` varchar(123) NOT NULL,
  `student_roll_number` int(11) NOT NULL,
  `student_dob` date NOT NULL,
  `student_grade_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_student`
--

INSERT INTO `tbl_student` (`student_id`, `student_name`, `student_roll_number`, `student_dob`, `student_grade_id`) VALUES
(1, 'Naruto Uzumaki', 1, '2003-02-16', 1),
(2, 'Uchiha Sasukee', 2, '2004-03-22', 1),
(3, 'Uchiha Madara', 3, '2003-12-16', 1),
(4, 'Zubair bin Ahmad', 4, '2003-03-16', 1),
(5, 'Eren Yaeger', 1, '2004-06-09', 2),
(6, 'Levi Ackerman', 2, '2004-02-19', 2),
(7, 'Utsman Muhammad', 3, '2003-03-09', 2),
(8, 'Muhammad Dzulfikar', 4, '2003-10-22', 2),
(9, 'Ahmad Hambali', 5, '2003-03-09', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_teacher`
--

CREATE TABLE `tbl_teacher` (
  `teacher_id` int(11) NOT NULL,
  `teacher_name` varchar(111) NOT NULL,
  `teacher_address` text NOT NULL,
  `teacher_emailid` varchar(111) NOT NULL,
  `teacher_password` varchar(111) NOT NULL,
  `teacher_qualification` varchar(111) NOT NULL,
  `teacher_doj` date NOT NULL,
  `teacher_image` varchar(111) NOT NULL,
  `teacher_grade_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_teacher`
--

INSERT INTO `tbl_teacher` (`teacher_id`, `teacher_name`, `teacher_address`, `teacher_emailid`, `teacher_password`, `teacher_qualification`, `teacher_doj`, `teacher_image`, `teacher_grade_id`) VALUES
(6, 'Dzulfikar', 'South Borobudur Street number 13 AB', 'dzulfikar.sauki@gmail.com', '$2y$10$Dq15hWCDhAAplEYezj6u0u0cSMZjVBzuWQOisu1GztuZg/WW0ki6S', 'Computer Sains', '2021-03-06', '1616815992_d99feced239d553daa57.jpg', 1),
(15, 'Sauki A', 'Jl. Suratmo 224B', 'sauki@gmail.com', '$2y$10$soz8DGM5ILFO0yV1AFC80uN01P2cvlzQ.dhtMzqnSxa6ktL4q6QMe', 'Technical', '2021-03-04', '1616403468_fe6cfe677adb0b045021.jpg', 2);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indeks untuk tabel `tbl_attendance`
--
ALTER TABLE `tbl_attendance`
  ADD PRIMARY KEY (`attendance_id`),
  ADD KEY `student_id_foreign_key` (`student_id`),
  ADD KEY `teacher_id_foreign_key` (`teacher_id`);

--
-- Indeks untuk tabel `tbl_grade`
--
ALTER TABLE `tbl_grade`
  ADD PRIMARY KEY (`grade_id`);

--
-- Indeks untuk tabel `tbl_student`
--
ALTER TABLE `tbl_student`
  ADD PRIMARY KEY (`student_id`),
  ADD KEY `student_grade_id_foreign_key` (`student_grade_id`);

--
-- Indeks untuk tabel `tbl_teacher`
--
ALTER TABLE `tbl_teacher`
  ADD PRIMARY KEY (`teacher_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `tbl_attendance`
--
ALTER TABLE `tbl_attendance`
  MODIFY `attendance_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=125;

--
-- AUTO_INCREMENT untuk tabel `tbl_grade`
--
ALTER TABLE `tbl_grade`
  MODIFY `grade_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `tbl_student`
--
ALTER TABLE `tbl_student`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `tbl_teacher`
--
ALTER TABLE `tbl_teacher`
  MODIFY `teacher_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `tbl_attendance`
--
ALTER TABLE `tbl_attendance`
  ADD CONSTRAINT `student_id_foreign_key` FOREIGN KEY (`student_id`) REFERENCES `tbl_student` (`student_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `teacher_id_foreign_key` FOREIGN KEY (`teacher_id`) REFERENCES `tbl_teacher` (`teacher_id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tbl_student`
--
ALTER TABLE `tbl_student`
  ADD CONSTRAINT `student_grade_id_foreign_key` FOREIGN KEY (`student_grade_id`) REFERENCES `tbl_grade` (`grade_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
