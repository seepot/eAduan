-- phpMyAdmin SQL Dump
-- version 3.3.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 29, 2014 at 10:30 AM
-- Server version: 5.1.50
-- PHP Version: 5.3.14

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `jhev_eaduan`
--

-- --------------------------------------------------------

--
-- Table structure for table `acl_module`
--

CREATE TABLE IF NOT EXISTS `acl_module` (
  `acl_module_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Module ID',
  `acl_module_name` varchar(32) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Module Name',
  `acl_module_desc` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Module Description',
  `acl_module_show` tinyint(1) unsigned NOT NULL COMMENT 'Module Show',
  PRIMARY KEY (`acl_module_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='ACL Modules' AUTO_INCREMENT=15 ;

--
-- Dumping data for table `acl_module`
--

INSERT INTO `acl_module` (`acl_module_id`, `acl_module_name`, `acl_module_desc`, `acl_module_show`) VALUES
(1, 'default', 'Utama', 2),
(2, 'admin', 'Induk', 1),
(7, 'layout', 'Layout', 0),
(8, 'menu', 'Menu Kiri', 0),
(13, 'bpm', 'Modul BPM', 1),
(14, 'bp', 'Peribadi', 1);

-- --------------------------------------------------------

--
-- Table structure for table `acl_privilege`
--

CREATE TABLE IF NOT EXISTS `acl_privilege` (
  `acl_privilege_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Privilege ID',
  `acl_resource_id` tinyint(3) unsigned NOT NULL COMMENT 'Resource ID',
  `acl_privilege_name` varchar(32) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Privilege Name',
  `acl_privilege_desc` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Privilege Desc',
  `acl_privilege_show` tinyint(1) NOT NULL COMMENT 'Privilege Show',
  PRIMARY KEY (`acl_privilege_id`),
  UNIQUE KEY `acl_resource_id_2` (`acl_resource_id`,`acl_privilege_name`),
  KEY `acl_resource_id` (`acl_resource_id`),
  KEY `acl_privilege_name` (`acl_privilege_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='ACL Privileges' AUTO_INCREMENT=124 ;

--
-- Dumping data for table `acl_privilege`
--

INSERT INTO `acl_privilege` (`acl_privilege_id`, `acl_resource_id`, `acl_privilege_name`, `acl_privilege_desc`, `acl_privilege_show`) VALUES
(1, 1, 'index', '', 0),
(2, 2, 'login', '', 0),
(3, 2, 'logout', '', 0),
(4, 3, 'error', '', 0),
(5, 4, 'index', '', 0),
(6, 4, 'noaccess', '', 0),
(7, 5, 'index', '', 0),
(8, 5, 'list', 'Senarai Pengguna', 1),
(9, 5, 'add', 'Tambah Pengguna', 1),
(10, 5, 'view', 'Papar Pengguna', 1),
(11, 5, 'delete', 'Hapus Pengguna', 1),
(12, 6, 'index', '', 0),
(13, 6, 'list', 'Senarai Kumpulan Pengguna', 1),
(14, 6, 'add', 'Tambah Kumpulan Pengguna', 1),
(15, 5, 'edit', 'Kemaskini Pengguna', 1),
(17, 8, 'module', 'Senarai Modul', 0),
(18, 8, 'resources', 'Senarai Resource', 0),
(19, 8, 'privileges', 'Senarai Privileges', 0),
(20, 8, 'module_add', 'Tambah Modul', 0),
(21, 8, 'resource_add', 'Tambah Resource', 0),
(22, 8, 'privilege_add', 'Tambah Privilege', 0),
(23, 4, 'pdf', 'Test PDF', 1),
(24, 6, 'edit', 'Kemaskini Kumpulan Pengguna', 1),
(25, 4, 'print', 'Test DAtaGRid', 1),
(28, 8, 'resource_delete', 'Hapus Resource', 0),
(29, 8, 'privilege_delete', 'Hapus Privilege', 0),
(31, 8, 'module_delete', 'Hapus Module', 0),
(34, 16, 'head', 'Header', 0),
(35, 17, 'index', '-', 0),
(39, 25, 'index', 'Menu Tempahan', 0),
(40, 23, 'list', 'Senarai Permohonan Baru', 1),
(41, 23, 'apply', 'Permohonan Baru - Maklumat Am', 1),
(42, 23, 'menu', 'Permohonan Baru - Menu', 1),
(43, 23, 'bilik', 'Permohonan Baru - Bilik Perbincangan/Mesyuarat/Dewan', 1),
(44, 23, 'perakuan', 'Permohonan Baru - Perakuan', 1),
(45, 23, 'kelulusan', 'Keputusan Permohonan', 1),
(46, 24, 'list', 'Transaksi Permohonan', 1),
(47, 24, 'schedule', 'Jadual Penggunaan', 1),
(48, 24, 'index', 'Index List Transaksi', 0),
(49, 23, 'index', 'Index List New', 0),
(51, 24, 'view', 'Papar Permohonan', 1),
(52, 2, 'register', 'Pendaftaran', 0),
(53, 27, 'profileedit', 'Kemaskini Profil', 1),
(54, 28, 'index', '...', 0),
(55, 27, 'profile', 'Profil Pesara', 1),
(56, 27, 'fotoedit', 'Kemaskini Foto', 1),
(57, 27, 'password', 'Tukar Kata Laluan', 1),
(58, 29, 'carian', 'Carian', 1),
(59, 29, 'tahun2009', 'Penyata Tahun 2009', 1),
(60, 29, 'tahun2010', 'Penyata Tahun 2010', 1),
(62, 31, 'index', '....', 0),
(63, 2, 'forgotpassword', 'Lupa Kata Laluan', 0),
(64, 29, 'index', '...', 0),
(65, 27, 'bantuan', 'Bantuan - Profil', 1),
(66, 29, 'bantuan', 'Bantuan - Penyata', 1),
(67, 32, 'add', 'Tambah Maklumbalas', 1),
(68, 33, 'index', '...', 0),
(69, 32, 'listuser', 'Senarai Maklumbalas - Pengguna', 1),
(70, 32, 'view', 'Papar Maklumbalas', 1),
(71, 34, 'index', '...', 0),
(72, 34, 'userlist', 'Transaksi Permohonan', 1),
(73, 34, 'jhevlist', 'Senarai Permohonan', 1),
(74, 35, 'index', '...', 0),
(75, 35, 'apply', 'Permohonan - Maklumat Veteran', 1),
(76, 35, 'operasi', 'Permohonan - Maklumat Operasi', 1),
(77, 35, 'status', 'Permohonan - Maklumat Status', 1),
(78, 35, 'lampiran', 'Permohonan - Lampiran', 1),
(79, 35, 'perakuan', 'Permohonan - Perakuan', 1),
(80, 34, 'view', 'Papar Permohonan PJM', 1),
(81, 36, 'index', '...', 0),
(82, 34, 'perakuanpp', 'Perakuan Penolong Pengarah Negeri', 1),
(83, 34, 'sokongan', 'Sokongan Pengarah Negeri', 1),
(84, 34, 'pengesahan', 'Pengesahan Ketua Pengarah JHEV', 1),
(85, 37, 'index', '....', 0),
(86, 38, 'index', '...', 0),
(87, 38, 'carian', 'Carian', 1),
(88, 29, 'tahun2011', 'Penyata 2011', 1),
(89, 39, 'index', '....', 0),
(90, 40, 'carian', 'Carian', 1),
(91, 2, 'facebook', '...', 0),
(92, 2, 'google', '...', 0),
(93, 29, 'tahun2012', 'Penyata Tahun 20121', 1),
(94, 2, 'state', 'Negeri', 0),
(95, 2, 'district', 'Daerah', 0),
(96, 2, 'dept', 'Bahagian', 0),
(97, 2, 'unit', 'Unit', 0),
(98, 41, 'transaction', 'Transaksi Aduan', 1),
(99, 41, 'add', 'Aduan Baru', 1),
(100, 41, 'penyelialist', 'Senarai Aduan - Penyelia', 1),
(101, 41, 'pegawailist', 'Senarai Aduan - Pegawai', 1),
(102, 41, 'staflist', 'Senarai Aduan - Staf BPM', 1),
(103, 41, 'penyelia', 'Pengesahan Penyelia', 1),
(104, 41, 'pegawai', 'Tindakan Pegawai BPM', 1),
(105, 41, 'staf', 'Tindakan Staf BPM', 1),
(106, 42, 'index', '...', 0),
(107, 43, 'index', '...', 0),
(108, 41, 'view', 'Papar Aduan', 1),
(109, 41, 'bpm', '...', 0),
(110, 41, 'masalah', '...', 0),
(111, 41, 'stafbpm', '...', 0),
(112, 41, 'unit', '...', 0),
(113, 41, 'status', '...', 0),
(114, 41, 'task', 'Pop-up Tugas Staf BPM', 1),
(115, 44, 'profile', 'Profil Pengguna', 1),
(116, 44, 'profileedit', 'Kemaskini Profil', 1),
(117, 44, 'password', 'Kemaskini Kata Laluan', 1),
(118, 41, 'bpm2', '...', 0),
(119, 41, 'edit', 'Kemaskini Aduan', 1),
(120, 45, 'index', '...', 0),
(121, 46, 'index', '...', 0),
(122, 46, 'month', 'Laporan Bulanan', 1),
(123, 46, 'monthdetail', 'Laporan Terperinci  Bulanan', 1);

-- --------------------------------------------------------

--
-- Table structure for table `acl_resource`
--

CREATE TABLE IF NOT EXISTS `acl_resource` (
  `acl_resource_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Resource ID',
  `acl_module_id` tinyint(3) unsigned NOT NULL COMMENT 'Module ID',
  `acl_resource_name` varchar(32) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Resource Name',
  `acl_resource_desc` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Resource Description',
  `acl_resource_show` tinyint(1) NOT NULL COMMENT 'Resource Show',
  PRIMARY KEY (`acl_resource_id`),
  KEY `acl_module_id` (`acl_module_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='ACL Resources' AUTO_INCREMENT=47 ;

--
-- Dumping data for table `acl_resource`
--

INSERT INTO `acl_resource` (`acl_resource_id`, `acl_module_id`, `acl_resource_name`, `acl_resource_desc`, `acl_resource_show`) VALUES
(1, 1, 'index', '', 2),
(2, 1, 'authentication', '', 2),
(3, 1, 'error', '', 2),
(4, 2, 'index', '', 2),
(5, 2, 'user', 'Pengguna', 1),
(6, 2, 'group', 'Kumpulan Pengguna', 1),
(8, 2, 'acl', 'Senarai Role', 0),
(16, 7, 'admin', 'Header', 0),
(17, 8, 'master', 'Menu Induk', 0),
(23, 9, 'new', 'Permohonan Tempahan', 1),
(24, 9, 'transaksi', 'Transaksi Permohonan', 1),
(25, 8, 'tempahan', 'Menu Tempahan', 0),
(26, 2, 'staff', 'Kakitangan', 1),
(27, 10, 'personal', 'Profil Peribadi', 1),
(28, 8, 'bp', 'Pencen', 1),
(29, 10, 'penyata', 'Penyata Pencen', 1),
(31, 8, 'profil', 'Menu Profil Pengguna', 0),
(32, 10, 'feedback', 'Maklumbalas', 1),
(33, 8, 'feedback', 'Maklumbalas', 0),
(34, 11, 'transaksi', 'Permohonan', 1),
(35, 11, 'medal', 'PJM - Permohonan', 1),
(38, 10, 'semakan', 'Semak', 1),
(40, 12, 'bsn', 'Pencen Bank', 1),
(41, 13, 'aduan', 'Aduan BPM', 1),
(42, 8, 'bpm', '...', 0),
(43, 8, 'aduan', '...', 0),
(44, 14, 'personal', 'Peribadi', 1),
(45, 8, 'report', '...', 0),
(46, 13, 'report', 'Laporan', 1);

-- --------------------------------------------------------

--
-- Table structure for table `acl_role`
--

CREATE TABLE IF NOT EXISTS `acl_role` (
  `acl_role_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ACL Role ID',
  `acl_role_name` varchar(32) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Role Name',
  `acl_role_desc` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Role Description',
  `acl_inherit_id` tinyint(3) unsigned NOT NULL COMMENT 'Inherit ID',
  `type_group_id` int(11) NOT NULL,
  `acl_role_status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`acl_role_id`),
  KEY `acl_role_name` (`acl_role_name`),
  KEY `acl_inherit_id` (`acl_inherit_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT COMMENT='ACL Roles' AUTO_INCREMENT=15 ;

--
-- Dumping data for table `acl_role`
--

INSERT INTO `acl_role` (`acl_role_id`, `acl_role_name`, `acl_role_desc`, `acl_inherit_id`, `type_group_id`, `acl_role_status`) VALUES
(1, 'Pengguna Biasa', '', 0, 2, 0),
(2, 'Pentadbir Sistem', '', 1, 1, 1),
(3, 'Pengguna Berdaftar', 'Mempunyai capaian untuk membuat aduan ke BPM', 1, 2, 1),
(12, 'Penyelia Unit', 'Menganalisa aduan dari staf unit sebelum dimajukan kepada BPM', 1, 2, 1),
(13, 'Pegawai BPM', 'Menganalisa aduan daripada pengguna JHEV dan mengagihkan kepada staf BPM untuk tindakan.', 1, 2, 1),
(14, 'Staf BPM', 'Membuat tindakan terhadap aduan yang dimajukan.', 1, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `acl_role_privilege`
--

CREATE TABLE IF NOT EXISTS `acl_role_privilege` (
  `acl_role_id` tinyint(3) unsigned NOT NULL COMMENT 'Role ID',
  `acl_privilege_id` smallint(5) unsigned NOT NULL COMMENT 'Privilege ID',
  PRIMARY KEY (`acl_role_id`,`acl_privilege_id`),
  KEY `acl_role_id` (`acl_role_id`),
  KEY `acl_privilege_id` (`acl_privilege_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='ACL Role Privileges';

--
-- Dumping data for table `acl_role_privilege`
--

INSERT INTO `acl_role_privilege` (`acl_role_id`, `acl_privilege_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 34),
(1, 35),
(1, 39),
(1, 48),
(1, 49),
(1, 52),
(1, 54),
(1, 55),
(1, 61),
(1, 62),
(1, 63),
(1, 64),
(1, 68),
(1, 74),
(1, 85),
(1, 89),
(1, 91),
(1, 92),
(1, 94),
(1, 95),
(1, 96),
(1, 97),
(1, 106),
(1, 107),
(1, 109),
(1, 110),
(1, 111),
(1, 112),
(1, 113),
(1, 118),
(1, 120),
(1, 121),
(2, 9),
(2, 10),
(2, 11),
(2, 13),
(2, 14),
(2, 15),
(2, 24),
(3, 98),
(3, 99),
(3, 108),
(3, 115),
(3, 116),
(3, 117),
(3, 119),
(4, 40),
(4, 45),
(4, 47),
(4, 51),
(5, 58),
(6, 56),
(6, 57),
(6, 58),
(6, 90),
(7, 73),
(7, 80),
(7, 82),
(8, 73),
(8, 80),
(8, 83),
(9, 73),
(9, 80),
(9, 84),
(10, 87),
(11, 53),
(11, 55),
(11, 56),
(11, 57),
(11, 58),
(11, 59),
(11, 60),
(11, 65),
(11, 66),
(11, 67),
(11, 69),
(11, 70),
(11, 88),
(11, 93),
(12, 98),
(12, 99),
(12, 100),
(12, 103),
(12, 108),
(12, 115),
(12, 116),
(12, 117),
(13, 98),
(13, 99),
(13, 101),
(13, 104),
(13, 108),
(13, 114),
(13, 115),
(13, 116),
(13, 117),
(13, 122),
(13, 123),
(14, 98),
(14, 99),
(14, 102),
(14, 104),
(14, 105),
(14, 108),
(14, 115),
(14, 116),
(14, 117),
(14, 122),
(14, 123);

-- --------------------------------------------------------

--
-- Table structure for table `ea_aduan`
--

CREATE TABLE IF NOT EXISTS `ea_aduan` (
  `aduan_id` int(10) NOT NULL AUTO_INCREMENT,
  `aduan_bpm` smallint(1) NOT NULL,
  `aduan_kategorimasalah` varchar(2) NOT NULL,
  `aduan_lokasi` varchar(100) NOT NULL,
  `aduan_ringkasan` varchar(255) NOT NULL,
  `aduan_hadpelulus` varchar(200) DEFAULT NULL,
  `aduan_lampiran` varchar(255) DEFAULT NULL,
  `aduan_tarikh` date NOT NULL,
  `aduan_userid` varchar(50) DEFAULT NULL,
  `penyelia_pengesahan` tinyint(1) DEFAULT NULL,
  `penyelia_catatan` text,
  `penyelia_user` varchar(200) DEFAULT NULL,
  `penyelia_date` datetime DEFAULT NULL,
  `pegawai_kelulusan` tinyint(1) DEFAULT NULL,
  `pegawai_tahap` tinyint(1) DEFAULT NULL,
  `pegawai_unit` smallint(3) DEFAULT NULL,
  `pegawai_staf` varchar(200) DEFAULT NULL,
  `pegawai_catatan` text,
  `pegawai_user` varchar(200) DEFAULT NULL,
  `pegawai_date` datetime DEFAULT NULL,
  `staf_status` smallint(2) DEFAULT NULL,
  `staf_tindakan` text,
  `staf_lampiran` varchar(255) DEFAULT NULL,
  `staf_user` varchar(200) DEFAULT NULL,
  `staf_date` datetime DEFAULT NULL,
  `insert_by` varchar(50) NOT NULL,
  `insert_date` datetime NOT NULL,
  `update_by` varchar(50) DEFAULT NULL,
  `update_date` datetime DEFAULT NULL,
  `status` int(3) NOT NULL,
  PRIMARY KEY (`aduan_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

--
-- Dumping data for table `ea_aduan`
--

INSERT INTO `ea_aduan` (`aduan_id`, `aduan_bpm`, `aduan_kategorimasalah`, `aduan_lokasi`, `aduan_ringkasan`, `aduan_hadpelulus`, `aduan_lampiran`, `aduan_tarikh`, `aduan_userid`, `penyelia_pengesahan`, `penyelia_catatan`, `penyelia_user`, `penyelia_date`, `pegawai_kelulusan`, `pegawai_tahap`, `pegawai_unit`, `pegawai_staf`, `pegawai_catatan`, `pegawai_user`, `pegawai_date`, `staf_status`, `staf_tindakan`, `staf_lampiran`, `staf_user`, `staf_date`, `insert_by`, `insert_date`, `update_by`, `update_date`, `status`) VALUES
(1, 1, '2', '1', 'adsdsd', '4545', NULL, '2014-03-12', NULL, 0, 'No Jam, No Parking, No Data Fill In\r\nConvenience &amp; Renew in One Minute.', 'yusri.harun@gmail.com', '2014-04-25 14:53:27', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'yusri.harun@gmail.com', '2014-03-14 10:14:02', NULL, NULL, 20),
(2, 0, '5', '1', 'aaaaaaaaaaaaaaa', '20000', NULL, '2014-04-16', NULL, 1, 'Malaysia''s #1 Financial Comparison\r\nSite. Find the Best For You', 'yusri.harun@gmail.com', '2014-04-25 14:51:28', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'yusri.harun@gmail.com', '2014-04-16 14:47:01', NULL, NULL, 20),
(3, 2, '2', '2', 'dfdffdfd', '', NULL, '2014-04-16', NULL, 1, 'United States President Barack Obama should use his historic April 26-27 visit to Malaysia to speak directly on concerns about the country&rsquo;s deteriorating human rights situation.', 'yusri.harun@gmail.com', '2014-04-25 14:50:30', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'yusri.harun@gmail.com', '2014-04-16 14:49:38', NULL, NULL, 20),
(4, 2, '2', '2', 'dfdffdfd', '', NULL, '2014-04-16', NULL, 1, 'adasas', 'yusri.harun@gmail.com', '2014-04-25 13:06:19', 1, 2, 1, 'yusri.harun@gmail.com', 'Just about everything you need to know about our All-New Honda City is in this video! Don&rsquo;t be left behind, get your hands on this machine of Innovation today! ', 'yusri.harun@gmail.com', '2014-04-25 13:08:55', 3, 'cccccccccc', '20140527-yusri.harun@gmail.commind_map_-_requirements_management.pdf', 'yusri.harun@gmail.com', '2014-05-27 16:43:52', 'yusri.harun@gmail.com', '2014-04-16 14:52:23', NULL, NULL, 33),
(5, 1, '3', '1', 'TAKTAU', '', NULL, '2014-04-16', NULL, 1, 'gfhgfh', 'yusri.harun@gmail.com', '2014-04-17 14:29:59', 1, 2, 1, 'yusri.harun@gmail.com', 'xxx', 'yusri.harun@gmail.com', '2014-04-25 09:39:33', NULL, NULL, NULL, NULL, NULL, 'achik.amiez@gmail.com', '2014-04-16 20:15:15', NULL, NULL, 20),
(6, 2, '2', '2', 'xxxxxxxxxxxxxxxxxxxx', '', NULL, '2014-04-23', NULL, 1, '$message = new Zend_Form_Element_Textarea(''message'', array(\r\n            ''decorators'' =&gt; $this-&gt;elementDecorators,\r\n            ''label'' =&gt; ''Message'',\r\n            ''rows'' =&gt; 10,\r\n            ''cols'' =&gt; 50,\r\n            ''required'' =&gt; true,\r\n            ''filters'' =&gt; array(\r\n                ''StringTrim''\r\n            ),\r\n            ''validators'' =&gt; array(\r\n                array(''StringLength'', false, array(20, 1500))\r\n            )\r\n        ));', 'achik.amiez@gmail.com', '2014-04-25 17:59:12', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'achik.amiez@gmail.com', '2014-04-25 17:52:38', NULL, NULL, 20),
(7, 1, '3', '2', 'sistem vibes keluar error pada menu Daftar Bayar', '', NULL, '2014-04-29', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'elektro71', '2014-04-29 12:21:40', NULL, NULL, 10),
(8, 1, '3', '1', 'xxxx', '', NULL, '2014-05-09', NULL, NULL, NULL, 'amiez_boyzus@yahoo.com.my', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'yusri.harun@gmail.com', '2014-05-09 16:56:20', NULL, NULL, 10),
(9, 2, '1', '1', 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx\r\n\r\ncscs\r\n\r\ncsc', '', NULL, '2014-05-09', NULL, 1, 'layanxx', 'amiez_boyzus@yahoo.com.my', '2014-05-09 17:26:22', 1, 2, 2, 'achik.amiez@gmail.com', 'xxxx', 'lena', '2014-05-09 17:33:43', 1, 'cccc', NULL, 'achik.amiez@gmail.com', '2014-05-09 17:41:25', 'yusri.harun@gmail.com', '2014-05-09 17:24:05', NULL, NULL, 80),
(10, 2, '2', '2', 'testing', '', NULL, '2014-05-25', NULL, 1, 'Mohon segera diambil tindakan', 'achik.amiez@gmail.com', '2014-05-25 18:50:42', 1, 2, 2, 'achik.amiez@gmail.com', 'pastikan siap', 'achik.amiez@gmail.com', '2014-05-25 19:03:31', 1, 'format pc - ok', NULL, 'achik.amiez@gmail.com', '2014-05-25 19:10:01', 'achik.amiez@gmail.com', '2014-05-25 18:43:50', NULL, NULL, 80),
(11, 2, '2', '5', 'masalah tiada internet', '', NULL, '2014-05-25', NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'user1', '2014-05-25 19:40:23', NULL, NULL, 10),
(12, 1, '5', '3', 'cxxzvvcdv', '', '20140527-artiesaeaduan_info.txt', '2014-04-29', NULL, 1, 'xx..xx', 'yusri.harun@gmail.com', '2014-05-27 16:39:07', 0, 3, 2, 'achik.amiez@gmail.com', 'testing', 'achik.amiez@gmail.com', '2014-05-27 19:35:57', 2, 'tidak dapat amibil', '20140527-achik.amiez@gmail.comeaduan_info.txt', 'achik.amiez@gmail.com', '2014-05-27 19:38:09', 'artiesa', '2014-05-27 16:34:22', NULL, NULL, 35),
(13, 2, '1', '1', 'network down', '', '20140527-pengadu1snap1.png', '2014-05-27', NULL, 1, 'mohon tindakan lanjut', 'achik.amiez@gmail.com', '2014-05-27 19:30:46', 1, 2, 2, 'achik.amiez@gmail.com', 'semak netweok', 'lena', '2014-05-27 19:34:49', 1, 'ok', '20140527-achik.amiez@gmail.com1.htm', 'achik.amiez@gmail.com', '2014-05-27 19:39:47', 'Pengadu1', '2014-05-27 19:18:54', NULL, NULL, 80),
(14, 3, '7', '8', 'Audio Tidak berbunyi', '', '20140528-pengadu1audio.png', '2014-05-28', NULL, 1, 'mohon tindakan segera', 'shuhaimi', '2014-05-28 01:02:15', 1, 2, 2, 'achik.amiez@gmail.com', 'sila segera ambil tindakan', 'shuhaimi', '2014-05-28 01:18:19', 1, 'ok dah ', '20140528-shuhaimi1.htm', 'shuhaimi', '2014-05-28 01:39:34', 'Pengadu1', '2014-05-28 00:07:53', NULL, NULL, 80),
(15, 3, '7', '8', 'audio tiada', '', '20140528-pengadu1audio.png', '2014-05-28', NULL, 1, 'cter try', 'shuhaimi', '2014-05-28 01:30:22', 1, 1, 2, 'achik.amiez@gmail.com', 'repere', 'shuhaimi', '2014-05-28 22:25:35', 1, 'ok', '', 'shuhaimi', '2014-05-28 22:25:53', 'Pengadu1', '2014-05-28 01:27:29', NULL, NULL, 80),
(16, 2, '2', '3', 'Internet Slow', '', '', '2014-05-28', NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'shuhaimi', '2014-05-28 01:52:50', NULL, NULL, 10),
(17, 2, '2', '3', 'network slow', '', '20140528-pengadu1snap1.png', '2014-05-28', NULL, 1, 'ok', 'shuhaimi', '2014-05-28 02:05:15', 1, 2, 2, 'achik.amiez@gmail.com', 'swmak', 'shuhaimi', '2014-05-28 02:07:26', 1, 'ok dah', '20140528-shuhaimiaudio.png', 'shuhaimi', '2014-05-28 02:08:13', 'Pengadu1', '2014-05-28 01:55:08', NULL, NULL, 80),
(18, 2, '2', '1', 'test', '', '20140528-shuhaimieaduan_info.txt', '2014-05-27', NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'shuhaimi', '2014-05-28 21:35:34', NULL, NULL, 10),
(19, 1, '3', '1', 'ssssssssss', '', '', '2014-05-14', NULL, NULL, NULL, 'amiez_boyzus@yahoo.com.my', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Pengadu1', '2014-05-29 09:36:11', NULL, NULL, 10),
(20, 1, '5', '1', 'ssssssssssss', '', '', '2014-05-01', NULL, 1, 'xxx', 'penyelia1', '2014-05-29 09:54:21', NULL, NULL, NULL, NULL, NULL, 'artiesa', NULL, NULL, NULL, NULL, NULL, NULL, 'Pengadu1', '2014-05-29 09:44:47', NULL, NULL, 20),
(22, 1, '3', 'belakang pc', 'sadkjadskjdsd', '', '', '2014-05-14', NULL, 0, 'xccc', 'penyelia1', '2014-05-29 16:38:25', NULL, NULL, NULL, NULL, NULL, 'artiesa', NULL, NULL, NULL, NULL, NULL, NULL, 'Pengadu1', '2014-05-29 11:10:52', NULL, NULL, 15),
(23, 1, '3', 'sdsdsddsd', 'sdlsdksdldsd', '', '20140529-pengadu1ainan_tasneem.docx', '2014-05-16', NULL, 1, 'xxcxcxc', 'penyelia1', '2014-05-29 16:34:24', NULL, NULL, NULL, NULL, NULL, 'artiesa', NULL, NULL, NULL, NULL, NULL, NULL, 'Pengadu1', '2014-05-29 16:31:36', NULL, NULL, 20),
(24, 1, '3', 'Pencen', 'testing network', '', '20140529-useraduanaudio.png', '2014-05-29', NULL, 1, 'xxxx', 'penyelia1', '2014-05-29 17:21:46', 1, 2, 3, 'staf1', 'sada', 'artiesa', '2014-05-29 17:23:19', 1, 'xxxx', '20140529-staf1eaduan_info.txt', 'staf1', '2014-05-29 17:45:39', 'UserAduan', '2014-05-29 17:13:36', NULL, NULL, 80),
(25, 2, '1', 'BKA', 'Newtoerk', '', '20140529-pengadu1eaduan_info.txt', '2014-05-29', NULL, 1, 'ok', 'penyelia1', '2014-05-29 17:50:03', 1, 2, 3, 'staf1', 'amibil tindakan', 'lena', '2014-05-29 17:51:12', 1, 'ok', '20140529-staf1audio.png', 'staf1', '2014-05-29 17:53:30', 'Pengadu1', '2014-05-29 17:48:53', NULL, NULL, 80);

-- --------------------------------------------------------

--
-- Table structure for table `ea_bahagian`
--

CREATE TABLE IF NOT EXISTS `ea_bahagian` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `desc` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `ea_bahagian`
--

INSERT INTO `ea_bahagian` (`id`, `desc`) VALUES
(1, 'Bahagian Pengurusan Maklumat'),
(2, 'Bahagian Pencen'),
(3, 'Bahagian Kewangan dan Akaun'),
(4, 'Bahagian Kebajikan'),
(5, 'Bahagian Khidmat Pengurusan'),
(6, 'Bahagian Dasar'),
(7, 'Bahagian Kerjaya dan Sosioekonomi'),
(8, 'Pejabat Ketua Pengarah'),
(9, 'Pejabat Timbalan Ketua Pengarah'),
(10, 'Cawangan Selangor');

-- --------------------------------------------------------

--
-- Table structure for table `ea_bpm`
--

CREATE TABLE IF NOT EXISTS `ea_bpm` (
  `bpm_id` int(10) NOT NULL AUTO_INCREMENT,
  `bpm_name` varchar(200) NOT NULL,
  `pegawai_id` varchar(200) DEFAULT NULL,
  `unit_id` int(3) DEFAULT NULL,
  PRIMARY KEY (`bpm_id`),
  KEY `pegawai_id` (`pegawai_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `ea_bpm`
--

INSERT INTO `ea_bpm` (`bpm_id`, `bpm_name`, `pegawai_id`, `unit_id`) VALUES
(1, 'Sistem dan Aplikasi', 'artiesa', 4),
(2, 'Operasi dan Keselamatan Rangkaian', 'lena', 3);

-- --------------------------------------------------------

--
-- Table structure for table `ea_jawatan`
--

CREATE TABLE IF NOT EXISTS `ea_jawatan` (
  `jawatan_id` int(10) NOT NULL AUTO_INCREMENT,
  `jawatan_code` varchar(50) NOT NULL,
  `jawatan_desc` varchar(200) NOT NULL,
  `bahagian_id` int(10) NOT NULL,
  PRIMARY KEY (`jawatan_id`),
  KEY `bpm_id` (`bahagian_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `ea_jawatan`
--

INSERT INTO `ea_jawatan` (`jawatan_id`, `jawatan_code`, `jawatan_desc`, `bahagian_id`) VALUES
(1, 'P (BPM)', 'Pengarah BPM', 1),
(2, 'PP 1 (BPM)', 'Penolong Pengarah 1 BPM', 1),
(3, 'PP 2 (BPM)', 'Penolong Pengarah 2 BPM', 1),
(4, 'PP 3 (BPM)', 'Penolong Pengarah 3 BPM', 1),
(5, 'PP 4 (BPM)', 'Penolong Pengarah 4 BPM', 1),
(6, 'PP 5 (BPM)', 'Penolong Pengarah 5 BPM', 1),
(7, 'PP 6 (BPM)', 'Penolong Pengarah 6 BPM', 1),
(8, 'PP 7 (BPM)', 'Penolong Pengarah 7 BPM', 1),
(9, 'FT', 'Juruteknik Komputer', 1),
(10, 'PT', 'Pembantu Tadbir', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ea_kategorimasalah`
--

CREATE TABLE IF NOT EXISTS `ea_kategorimasalah` (
  `km_id` int(10) NOT NULL AUTO_INCREMENT,
  `km_desc` varchar(255) NOT NULL,
  `bpm_id` int(3) NOT NULL,
  PRIMARY KEY (`km_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `ea_kategorimasalah`
--

INSERT INTO `ea_kategorimasalah` (`km_id`, `km_desc`, `bpm_id`) VALUES
(1, 'Perkakasan', 2),
(2, 'Rangkaian', 2),
(3, 'Aplikasi/Sistem', 1),
(4, 'Perisian', 2),
(5, 'Pengurusan ID', 1),
(6, 'Lain-lain', 0),
(7, 'Audio', 3);

-- --------------------------------------------------------

--
-- Table structure for table `ea_kelulusan`
--

CREATE TABLE IF NOT EXISTS `ea_kelulusan` (
  `kelulusan_id` smallint(3) NOT NULL,
  `kelulusan_desc` varchar(100) NOT NULL,
  PRIMARY KEY (`kelulusan_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ea_kelulusan`
--

INSERT INTO `ea_kelulusan` (`kelulusan_id`, `kelulusan_desc`) VALUES
(0, 'Tidah Lulus'),
(1, 'Lulus');

-- --------------------------------------------------------

--
-- Table structure for table `ea_pengesahan`
--

CREATE TABLE IF NOT EXISTS `ea_pengesahan` (
  `pengesahan_id` smallint(3) NOT NULL,
  `pengesahan_desc` varchar(100) NOT NULL,
  PRIMARY KEY (`pengesahan_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ea_pengesahan`
--

INSERT INTO `ea_pengesahan` (`pengesahan_id`, `pengesahan_desc`) VALUES
(0, 'Tidah Sah'),
(1, 'Disahkan');

-- --------------------------------------------------------

--
-- Table structure for table `ea_status`
--

CREATE TABLE IF NOT EXISTS `ea_status` (
  `status_id` smallint(3) NOT NULL,
  `status_desc` varchar(100) NOT NULL,
  `status_post` varchar(100) NOT NULL,
  PRIMARY KEY (`status_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ea_status`
--

INSERT INTO `ea_status` (`status_id`, `status_desc`, `status_post`) VALUES
(10, 'Aduan Baru', 'Penyelia'),
(15, 'Tidak Sah', 'Pengguna'),
(20, 'Aduan Disahkan', 'Pegawai BPM'),
(30, 'Aduan Dalam Tindakan BPM', 'Tindakan BPM'),
(33, 'Aduan Dalam Tindakan BPM', 'Tindakan BPM - Tidak Dapat Diselesaikan'),
(35, 'Aduan Dalam Tindakan BPM', 'Tindakan BPM - Tangguh'),
(80, 'Aduan Selesai', 'Tutup');

-- --------------------------------------------------------

--
-- Table structure for table `ea_statusmasalah`
--

CREATE TABLE IF NOT EXISTS `ea_statusmasalah` (
  `status_id` int(3) NOT NULL AUTO_INCREMENT,
  `status_desc` varchar(100) NOT NULL,
  PRIMARY KEY (`status_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `ea_statusmasalah`
--

INSERT INTO `ea_statusmasalah` (`status_id`, `status_desc`) VALUES
(1, 'Selesai'),
(2, 'Tangguh'),
(3, 'Tidak Dapat Diselesaikan');

-- --------------------------------------------------------

--
-- Table structure for table `ea_tahap`
--

CREATE TABLE IF NOT EXISTS `ea_tahap` (
  `tahap_id` int(3) NOT NULL AUTO_INCREMENT,
  `tahap_desc` varchar(100) NOT NULL,
  PRIMARY KEY (`tahap_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `ea_tahap`
--

INSERT INTO `ea_tahap` (`tahap_id`, `tahap_desc`) VALUES
(1, 'Rendah'),
(2, 'Sederhana'),
(3, 'Tinggi');

-- --------------------------------------------------------

--
-- Table structure for table `ea_unit`
--

CREATE TABLE IF NOT EXISTS `ea_unit` (
  `unit_id` int(10) NOT NULL AUTO_INCREMENT,
  `unit_desc` varchar(255) NOT NULL,
  `dept_id` int(3) DEFAULT NULL,
  `penyelia_id` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`unit_id`),
  KEY `penyelia_id` (`penyelia_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `ea_unit`
--

INSERT INTO `ea_unit` (`unit_id`, `unit_desc`, `dept_id`, `penyelia_id`) VALUES
(1, 'Unit Bayaran', 3, 'penyelia1'),
(2, 'Unit Akaun', 3, 'yusri.harun@gmail.com'),
(3, 'Unit Rangkaian', 1, 'amiez_boyzus@yahoo.com.my'),
(4, 'Unit Aplikasi', 1, 'amiez_boyzus@yahoo.com.my'),
(8, 'Unit Perkhidmatan', 2, 'penyelia1'),
(9, 'Unit Terbitan', 2, 'user2');

-- --------------------------------------------------------

--
-- Table structure for table `sys_bahasa`
--

CREATE TABLE IF NOT EXISTS `sys_bahasa` (
  `bahasa_id` int(11) NOT NULL AUTO_INCREMENT,
  `bahasa_name` varchar(20) NOT NULL,
  `bahasa_aktif` int(11) NOT NULL,
  PRIMARY KEY (`bahasa_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `sys_bahasa`
--

INSERT INTO `sys_bahasa` (`bahasa_id`, `bahasa_name`, `bahasa_aktif`) VALUES
(1, 'Bahasa Malaysia', 1),
(2, 'Bahasa Inggeris', 1),
(3, 'Mandarin', 1),
(4, 'Swiss', 1),
(5, 'Belanda', 1),
(6, 'Tamil', 1),
(7, 'Jepun', 1),
(8, 'Korea', 1),
(9, 'Itali', 1),
(10, 'Arab', 1),
(11, 'Perancis', 1),
(12, 'Sepanyol', 1),
(13, 'Jerman', 1),
(14, 'Finnish', 1),
(15, 'Rusia', 1),
(16, 'Lain-lain', 1);

-- --------------------------------------------------------

--
-- Table structure for table `sys_contact`
--

CREATE TABLE IF NOT EXISTS `sys_contact` (
  `contact_id` int(11) NOT NULL AUTO_INCREMENT,
  `contact_name` varchar(50) NOT NULL COMMENT 'ingin dihubungi melalui',
  PRIMARY KEY (`contact_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `sys_contact`
--

INSERT INTO `sys_contact` (`contact_id`, `contact_name`) VALUES
(1, 'Melalui Sistem SPIP'),
(2, 'Emel'),
(3, 'SMS');

-- --------------------------------------------------------

--
-- Table structure for table `sys_district`
--

CREATE TABLE IF NOT EXISTS `sys_district` (
  `district_id` int(11) NOT NULL AUTO_INCREMENT,
  `sta_id` int(11) NOT NULL,
  `district_name` varchar(50) NOT NULL,
  `district_status` int(11) NOT NULL,
  PRIMARY KEY (`district_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=303 ;

--
-- Dumping data for table `sys_district`
--

INSERT INTO `sys_district` (`district_id`, `sta_id`, `district_name`, `district_status`) VALUES
(1, 1, 'BATU PAHAT', 1),
(2, 1, 'JOHOR BAHRU', 1),
(3, 1, 'KLUANG', 1),
(4, 1, 'KOTA TINGGI', 1),
(5, 1, 'MERSING', 1),
(6, 1, 'MUAR', 1),
(7, 1, 'PONTIAN', 1),
(8, 1, 'SEGAMAT', 1),
(9, 1, 'KULAI JAYA', 1),
(10, 1, 'LEDANG', 1),
(11, 1, 'YONG PENG', 1),
(12, 1, 'SENAI', 1),
(13, 1, 'PASIR GUDANG', 1),
(14, 1, 'SKUDAI', 1),
(15, 1, 'TANJUNG PUTERI', 1),
(16, 1, 'MASAI', 1),
(17, 1, 'TANGKAK', 1),
(18, 1, 'KULAI', 1),
(19, 1, 'NUSAJAYA', 1),
(20, 1, 'TAMPOI', 1),
(21, 1, 'ULU TIRAM', 1),
(22, 1, 'GELANG PATAH', 1),
(23, 1, 'TEBRAU', 1),
(24, 1, 'SIMPANG RENGGAM', 1),
(25, 1, 'PENGERANG', 1),
(26, 1, 'PEKAN NANAS', 1),
(27, 2, 'BALING', 1),
(28, 2, 'BANDAR BAHARU', 1),
(29, 2, 'KOTA SETAR', 1),
(30, 2, 'KUALA MUDA', 1),
(31, 2, 'KUBANG PASU', 1),
(32, 2, 'KULIM', 1),
(33, 2, 'LANGKAWI', 1),
(34, 2, 'PADANG TERAP', 1),
(35, 2, 'PENDANG', 1),
(36, 2, 'POKOK SENA', 1),
(37, 2, 'SIK', 1),
(38, 2, 'YAN', 1),
(39, 2, 'ALOR SETAR', 1),
(40, 2, 'SUNGAI PETANI', 1),
(41, 2, 'BEDONG', 1),
(42, 2, 'KUALA NERANG', 1),
(43, 2, 'JITRA', 1),
(44, 2, 'SINTOK', 1),
(45, 2, 'GURUN', 1),
(46, 2, 'KUAH', 1),
(47, 2, 'CHANGLOON', 1),
(48, 2, 'BUKIT KAYU HITAM', 1),
(49, 2, 'KEPALA BATAS', 1),
(50, 2, 'KUALA KEDAH', 1),
(51, 2, 'LUNAS', 1),
(52, 2, 'KARANGAN', 1),
(53, 2, 'NAKA', 1),
(54, 3, 'BACHOK', 1),
(55, 3, 'GUA MUSANG', 1),
(56, 3, 'JELI', 1),
(57, 0, 'KUALA KRAI', 1),
(58, 3, 'KUALA KRAI', 1),
(59, 3, 'MACHANG', 1),
(60, 3, 'PASIR MAS', 1),
(61, 3, 'PASIR PUTEH', 1),
(62, 3, 'TANAH MERAH', 1),
(63, 3, 'TUMPAT', 1),
(64, 3, 'KOTA BHARU', 1),
(65, 3, 'RANTAU PANJANG', 1),
(66, 4, 'ALOR GAJAH', 1),
(67, 4, 'MELAKA TENGAH', 1),
(68, 4, 'JASIN', 1),
(69, 4, 'BANDAR HILIR', 1),
(70, 4, 'TANJUNG BIDARA', 1),
(71, 4, 'AYER KEROH', 1),
(72, 4, 'BALAI PANJANG', 1),
(73, 4, 'PERINGGIT', 1),
(74, 4, 'MASJID TANAH', 1),
(75, 4, 'BACHANG', 1),
(76, 4, 'DURIAN TUNGGAL', 1),
(77, 4, 'SEMABOK', 1),
(78, 4, 'SUNGAI UDANG', 1),
(79, 4, 'BATU BERENDAM', 1),
(80, 4, 'MERLIMAU', 1),
(81, 5, 'JELEBU', 1),
(82, 5, 'JEMPOL', 1),
(83, 5, 'KUALA PILAH', 1),
(84, 5, 'PORT DICKSON', 1),
(85, 5, 'REMBAU', 1),
(86, 5, 'SEREMBAN', 1),
(87, 5, 'TAMPIN', 1),
(88, 5, 'BANDAR BARU NILAI', 1),
(89, 5, 'BAHAU', 1),
(90, 5, 'NILAI', 1),
(91, 5, 'SENAWANG', 1),
(92, 5, 'GEMAS', 1),
(93, 5, 'GEMENCHEH', 1),
(94, 6, 'BENTONG', 1),
(95, 6, 'BERA', 1),
(96, 6, 'CAMERON HIGHLAND', 1),
(97, 6, 'JERANTUT', 1),
(98, 6, 'KUANTAN', 1),
(99, 6, 'LIPIS', 1),
(100, 6, 'MARAN', 1),
(101, 6, 'PEKAN', 1),
(102, 6, 'RAUB', 1),
(103, 6, 'ROMPIN', 1),
(104, 6, 'TEMERLOH', 1),
(105, 6, 'GENTING HIGHLANDS', 1),
(106, 6, 'KUALA ROMPIN', 1),
(107, 6, 'MENTAKAB', 1),
(108, 6, 'FRASER HILL', 1),
(109, 6, 'KUALA LIPIS', 1),
(110, 6, 'JENGKA', 1),
(111, 6, 'TRIANG', 1),
(112, 6, 'CHERATING', 1),
(113, 6, 'PULAU TIOMAN', 1),
(114, 6, 'BENTA', 1),
(115, 6, 'KEMAYAN', 1),
(116, 7, 'TIMUR LAUT', 1),
(117, 7, 'BARAT DAYA', 1),
(118, 7, 'SEBERANG PERAI UTARA', 1),
(119, 7, 'SEBERANG PERAI TENGAH', 1),
(120, 7, 'SEBERANG PERAI SELATAN', 1),
(121, 7, 'GEORGETOWN', 1),
(122, 7, 'BATU FERRINGHI', 1),
(123, 7, 'TELUK BAHANG', 1),
(124, 7, 'BAYAN LEPAS', 1),
(125, 7, 'TANJUNG BUNGAH', 1),
(126, 7, 'SEBERANG JAYA', 1),
(127, 7, 'TANJUNG TOKONG', 1),
(128, 7, 'BUKIT MERTAJAM', 1),
(129, 7, 'BUTTERWORTH', 1),
(130, 7, 'BAYAN BARU', 1),
(131, 7, 'BUKIT BENDERA', 1),
(132, 7, 'PENGKALAN WELD', 1),
(133, 7, 'PRAI', 1),
(134, 7, 'GELUGOR', 1),
(135, 7, 'SUNGAI NIBONG', 1),
(136, 7, 'KEPALA BATAS', 1),
(137, 7, 'SUNGAI DUA', 1),
(138, 7, 'BALIK PULAU', 1),
(139, 8, 'BATANG PADANG', 1),
(140, 8, 'HILIR PERAK', 1),
(141, 8, 'HULU PERAK', 1),
(142, 8, 'KERIAN', 1),
(143, 8, 'KINTA', 1),
(144, 8, 'KUALA KANGSAR', 1),
(145, 8, 'LARUT', 1),
(146, 8, 'MATANG', 1),
(147, 8, 'SELAMA', 1),
(148, 8, 'MANJUNG', 1),
(149, 8, 'PERAK TENGAH', 1),
(150, 8, 'PULAU PANGKOR', 1),
(151, 8, 'IPOH', 1),
(152, 8, 'LUMUT', 1),
(153, 8, 'SEMANGGOL', 1),
(154, 8, 'TAIPING', 1),
(155, 8, 'GERIK', 1),
(156, 8, 'PARIT BUNTAR', 1),
(157, 8, 'SETIAWAN', 1),
(158, 8, 'TELUK INTAN', 1),
(159, 8, 'KAMPAR', 1),
(160, 8, 'TANJUNG MALIM', 1),
(161, 8, 'TAPAH', 1),
(162, 8, 'BIDOR', 1),
(163, 8, 'SLIM RIVER', 1),
(164, 8, 'BAGAN SERAI', 1),
(165, 8, 'LENGGONG', 1),
(166, 8, 'HUTAN MELINTANG', 1),
(167, 8, 'PENGKALAN HULU', 1),
(168, 8, 'BATU GAJAH', 1),
(169, 8, 'KAMUNTING', 1),
(170, 8, 'PANTAI REMIS', 1),
(171, 8, 'TRONOH', 1),
(172, 8, 'GOPENG', 1),
(173, 8, 'BOTA', 1),
(174, 9, 'ARAU', 1),
(175, 9, 'KAKI BUKIT', 1),
(176, 9, 'KANGAR', 1),
(177, 9, 'KUALA PERLIS', 1),
(178, 9, 'PADANG BESAR', 1),
(179, 9, 'SIMPANG EMPAT', 1),
(180, 10, 'GOMBAK', 1),
(181, 10, 'HULU LANGAT', 1),
(182, 10, 'HULU SELANGOR', 1),
(183, 10, 'KLANG', 1),
(184, 10, 'KUALA LANGAT', 1),
(185, 10, 'KUALA SELANGOR', 1),
(186, 10, 'PETALING', 1),
(187, 10, 'SABAK BERNAM', 1),
(188, 10, 'SEPANG', 1),
(189, 10, 'PETALING JAYA', 1),
(190, 10, 'SUBANG', 1),
(191, 10, 'SUBANG JAYA', 1),
(192, 10, 'BANGI', 1),
(193, 10, 'SHAH ALAM', 1),
(194, 10, 'SERI KEMBANGAN', 1),
(195, 10, 'CYBERJAYA', 1),
(196, 10, 'KAJANG', 1),
(197, 10, 'AMPANG', 1),
(198, 10, 'PELABUHAN KLANG', 1),
(199, 10, 'PUCHONG', 1),
(200, 10, 'BATU CAVES', 1),
(201, 10, 'RAWANG', 1),
(202, 10, 'SUNGAI BULOH', 1),
(203, 10, 'BANTING', 1),
(204, 10, 'PULAU KETAM', 1),
(205, 10, 'ULU KLANG', 1),
(206, 10, 'BANDAR BARU BANGI', 1),
(207, 10, 'KUALA KUBU BARU', 1),
(208, 10, 'KELANA JAYA', 1),
(209, 10, 'SELAYANG', 1),
(210, 10, 'SEMENYIH', 1),
(211, 10, 'SERENDAH', 1),
(212, 10, 'DENGKIL', 1),
(213, 10, 'SEKINCHAN', 1),
(214, 10, 'KAPAR', 1),
(215, 10, 'BANDAR PUTRA PERMAI', 1),
(216, 10, 'KOTA DAMANSARA', 1),
(217, 10, 'BATANG BERJUNTAI', 1),
(218, 10, 'BANDAR SUNWAY', 1),
(219, 10, 'BATANG KALI', 1),
(220, 11, 'BESUT', 1),
(221, 11, 'DUNGUN', 1),
(222, 11, 'HULU TERENGGANU', 1),
(223, 11, 'KEMAMAN', 1),
(224, 11, 'KUALA TERENGGANU', 1),
(225, 11, 'MARANG', 1),
(226, 11, 'SETIU', 1),
(227, 11, 'PAKA', 1),
(228, 11, 'KERTEH', 1),
(229, 11, 'KUALA BESUT', 1),
(230, 11, 'JERTEH', 1),
(231, 11, 'KUALA BERANG', 1),
(232, 12, 'BEAUFORT', 1),
(233, 12, 'KENINGAU', 1),
(234, 12, 'KUALA PENYU', 1),
(235, 12, 'NABAWAN', 1),
(236, 12, 'SIPITANG', 1),
(237, 12, 'TAMBUNAN', 1),
(238, 12, 'TENOM', 1),
(239, 12, 'KOTA MARUDU', 1),
(240, 12, 'KUDAT', 1),
(241, 12, 'PITAS', 1),
(242, 12, 'BELURAN', 1),
(243, 12, 'KINABATANGAN', 1),
(244, 12, 'SANDAKAN', 1),
(245, 12, 'TONGOD', 1),
(246, 12, 'KUNAK', 1),
(247, 12, 'LAHAD DATU', 1),
(248, 12, 'SEMPORNA', 1),
(249, 12, 'TAWAU', 1),
(250, 12, 'KOTA BELUD', 1),
(251, 12, 'KOTA KINABALU', 1),
(252, 12, 'PAPAR', 1),
(253, 12, 'PENAMPANG', 1),
(254, 12, 'PUTATAN', 1),
(255, 12, 'RANAU', 1),
(256, 12, 'TUARAN', 1),
(257, 12, 'KUNDASANG', 1),
(258, 12, 'TANJUNG ARU', 1),
(259, 12, 'LIKAS', 1),
(260, 12, 'MENGGATAL', 1),
(261, 12, 'LIDO', 1),
(262, 13, 'BETONG', 1),
(263, 13, 'SARATOK', 1),
(264, 13, 'BINTULU', 1),
(265, 13, 'TATAU', 1),
(266, 13, 'BELAGA', 1),
(267, 13, 'KAPIT', 1),
(268, 13, 'SONG', 1),
(269, 13, 'BAU', 1),
(270, 13, 'KUCHING', 1),
(271, 13, 'LUNDU', 1),
(272, 13, 'LAWAS', 1),
(273, 13, 'LIMBANG', 1),
(274, 13, 'MARUDI', 1),
(275, 13, 'MIRI', 1),
(276, 13, 'DALAT', 1),
(277, 13, 'DARO', 1),
(278, 13, 'MATU', 1),
(279, 13, 'MUKAH', 1),
(280, 13, 'ASAJAYA', 1),
(281, 13, 'SAMARAHAN', 1),
(282, 13, 'SERIAN', 1),
(283, 13, 'SIMUNJAN', 1),
(284, 13, 'JULAU', 1),
(285, 13, 'MERADONG', 1),
(286, 13, 'SARIKEI', 1),
(287, 13, 'KANOWIT', 1),
(288, 13, 'SIBU', 1),
(289, 13, 'LUBOK ANTU', 1),
(290, 13, 'SRI AMAN', 1),
(291, 13, 'BINTANGOR', 1),
(292, 13, 'BARAM', 1),
(293, 13, 'SEMATAN', 1),
(294, 13, 'BATU NIAH', 1),
(295, 14, 'KUALA LUMPUR', 1),
(296, 14, 'CHERAS', 1),
(297, 14, 'SENTUL', 1),
(298, 14, 'KEPONG', 1),
(299, 14, 'BANGSAR', 1),
(300, 14, 'SETAPAK', 1),
(301, 15, 'LABUAN', 1),
(302, 16, 'PUTRAJAYA', 1);

-- --------------------------------------------------------

--
-- Table structure for table `sys_education_level`
--

CREATE TABLE IF NOT EXISTS `sys_education_level` (
  `sys_edu_level_id` tinyint(1) NOT NULL AUTO_INCREMENT,
  `sys_edu_level_desc_bm` varchar(50) NOT NULL,
  `sys_edu_level_decs_bi` varchar(50) NOT NULL,
  `sys_edu_level_status` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`sys_edu_level_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `sys_education_level`
--

INSERT INTO `sys_education_level` (`sys_edu_level_id`, `sys_edu_level_desc_bm`, `sys_edu_level_decs_bi`, `sys_edu_level_status`) VALUES
(1, 'Tiada Maklumat', 'No Info', 1),
(2, 'Penilaian Menengah Rendah (PMR)', 'PMR', 1),
(3, 'Sijil Pelajaran Malaysia (SPM)', 'SPM', 1),
(4, 'Sijil', 'Certificate', 1),
(5, 'Diploma', 'Diploma', 1),
(6, 'Diploma Lanjutan', 'Higher Diploma', 1),
(7, 'Ijazah Sarjana Muda', 'Bachelor Degree', 1),
(8, 'Ijazah Sarjana', 'Master Degree', 1),
(9, 'Doktor Falsafah (PhD)', 'Philosophy Doctor (PhD)', 1);

-- --------------------------------------------------------

--
-- Table structure for table `sys_gender`
--

CREATE TABLE IF NOT EXISTS `sys_gender` (
  `gender_id` tinyint(2) NOT NULL AUTO_INCREMENT,
  `gender_desc_may` varchar(255) NOT NULL DEFAULT '',
  `gender_desc_eng` varchar(255) NOT NULL DEFAULT '',
  `gender_status` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`gender_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT AUTO_INCREMENT=4 ;

--
-- Dumping data for table `sys_gender`
--

INSERT INTO `sys_gender` (`gender_id`, `gender_desc_may`, `gender_desc_eng`, `gender_status`) VALUES
(1, 'Lelaki', 'Male', 1),
(2, 'Perempuan', 'Female', 1),
(3, 'Tiada Maklumat', 'No Data', 1);

-- --------------------------------------------------------

--
-- Table structure for table `sys_information_page`
--

CREATE TABLE IF NOT EXISTS `sys_information_page` (
  `ipage_id` int(1) NOT NULL,
  `ipage_name` varchar(100) NOT NULL,
  `ipage_desc` varchar(255) NOT NULL,
  `ipage_content` text,
  `ipage_edit_user` varchar(100) NOT NULL,
  `ipage_edit_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ipage_status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`ipage_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sys_information_page`
--

INSERT INTO `sys_information_page` (`ipage_id`, `ipage_name`, `ipage_desc`, `ipage_content`, `ipage_edit_user`, `ipage_edit_time`, `ipage_status`) VALUES
(1, 'Halaman Daftar Masuk', 'Halaman daftar masuk', '<p align="left"><strong>Selamat</strong> datang ke portal ePengembangan Jabatan Perikanan Malaysia. Laman ini menyediakan perkhidmatan program usahawan bimbingan untuk kumpulan sasaran di bawah naungan Jabatan Perikanan Malaysia.<br />\r\n<br />\r\nSistem ini merangkumi 4 program usahawan bimbingan iaitu :</p>\r\n<ul>\r\n    <li>Komuniti Pengurusan Sumber Perikanan (KPSP)</li>\r\n    <li>Projek Percubaan &amp; Demonstrasi (P&amp;D)</li>\r\n    <li>Usahawan Industri Asas Tani (UIAT)</li>\r\n    <li>\r\n    <div align="left">Projek Inkubator Pemprosesan (PIP)</div>\r\n    </li>\r\n</ul>', 'administrator', '2009-06-10 14:43:58', 1),
(2, 'Halaman Pengguna', 'Halaman pengguna', '<p align="left">Selamat datang ke portal ePengembangan Jabatan Perikanan Malaysia. Laman ini menyediakan perkhidmatan program usahawan bimbingan untuk kumpulan sasaran di bawah naungan Jabatan Perikanan Malaysia.<br />\r\n<br />\r\nSistem ini merangkumi 4 program usahawan bimbingan iaitu :</p>\r\n<p>&nbsp;</p>\r\n<ul>\r\n    <li>Komuniti Pengurusan Sumber Perikanan (KPSP)</li>\r\n    <li>Projek Percubaan &amp; Demonstrasi (P&amp;D)</li>\r\n    <li>Usahawan Industri Asas Tani (UIAT)</li>\r\n    <li>\r\n    <div align="left">Projek Inkubator Pemprosesan (PIP)</div>\r\n    </li>\r\n</ul>\r\n<p><img height="182" width="200" src="/userfiles/image/test/200px-AllHopeIsGoneAlbum.jpg" alt="" /></p>', 'administrator', '2009-06-02 15:10:00', 1),
(5, 'Penafian', 'Laman penafian		  		  		  ', '<P align=left><SPAN style=\\"FONT-SIZE: 12pt; FONT-FAMILY: Arial; mso-fareast-font-family: \\''Times New Roman\\''; mso-ansi-language: EN-US; mso-fareast-language: EN-US; mso-bidi-language: AR-SA\\"><FONT size=2>Kerajaan Malaysia dan Jabatan Perikanan Malaysia tidak bertanggungjawab terhadap sebarang kerosakan atau kehilangan yang dialami kerana menggunakan maklumat dalam laman ini.</FONT></SPAN></P>', 'administrator', '2008-01-14 10:56:59', 1),
(6, 'Dasar Privasi', 'Dasar Privasi', '<p line-height:="" style=""><b><span lang="MS" mso-ansi-language:="" style=""><font size="2">Privasi anda</font></span></b><span lang="MS" mso-ansi-language:="" style=""><br />\r\n<font size="2">Halaman ini menerangkan dasar privasi yang merangkumi penggunaan dan<br />\r\nperlindungan maklumat yang dikemukakan oleh pengunjung.</font></span><font size="2"> </font></p>\r\n<p line-height:="" style=""><font size="2"><span lang="MS" mso-ansi-language:="" style="">Sekiranya anda membuat transaksi atau menghantar e-mel yang mengandungi<br />\r\nmaklumat peribadi, maklumat ini mungkin akan dikongsi bersama dengan agensi awam lain untuk membantu penyediaan perkhidmatan yang lebih berkesan dan efektif. Contohnya seperti di dalam menyelesaikan aduan yang memerlukan maklumbalas dari agensi-agensi lain.</span> </font></p>\r\n<p line-height:="" style=""><b><span lang="MS" mso-ansi-language:="" style=""><font size="2">Perlindungan Data</font></span></b><span lang="MS" mso-ansi-language:="" style=""><br />\r\n<font size="2">Teknologi terkini termasuk penyulitan data adalah digunakan untuk melindungi<br />\r\ndata yang dikemukakan dan pematuhan kepada standard keselamatan yang ketat adalah terpakai untuk menghalang capaian yang tidak dibenarkan.</font></span><font size="2"> </font></p>\r\n<p line-height:="" style=""><b><span lang="MS" mso-ansi-language:="" style=""><font size="2">Keselamatan Storan</font></span></b><span lang="MS" mso-ansi-language:="" style=""><br />\r\n<font size="2">Semua storan elektronik dan penghantaran data peribadi akan dilindungi dan<br />\r\ndisimpan dengan menggunakan teknologi keselamatan yang sesuai.</font></span><font size="2"> </font></p>\r\n<p line-height:="" style=""><b><span lang="MS" mso-ansi-language:="" style=""><font size="2">Maklumat Yang Dikumpul</font></span></b><span lang="MS" mso-ansi-language:="" style=""><br />\r\n<font size="2">Tiada maklumat peribadi akan dikumpul semasa anda melayari laman web ini<br />\r\nkecuali maklumat yang dikemukakan oleh anda melalui e-mel. </font></span></p>\r\n<p line-height:="" style=""><b><span lang="MS" mso-ansi-language:="" style=""><font size="2">Apa yang akan Berlaku jika Saya Membuat Pautan kepada Laman Web yang Lain?<o:p></o:p></font></span></b></p>\r\n<p style=""><span lang="MS" mso-ansi-language:="" style=""><font size="2">Dasar privasi ini hanya terpakai untuk laman web ini sahaja. Perlu diingatkan bahawa laman web yang terdapat dalam pautan mungkin mempunyai dasar privasi yang berbeza dan pengunjung dinasihatkan supaya meneliti dan memahami dasar privasi bagi setiap laman web yang dilayari. </font></span></p>\r\n<p><b><span lang="MS" mso-bidi-language:="" mso-fareast-language:="" new="" times="" mso-fareast-font-family:="" mso-ansi-language:="" font-family:="" style=""><font size="2">Pindaan Dasar</font></span></b><span lang="MS" mso-bidi-language:="" mso-fareast-language:="" new="" times="" mso-fareast-font-family:="" mso-ansi-language:="" font-family:="" style=""><br />\r\n<font size="2">Sekiranya dasar privasi ini dipinda, pindaan akan dikemas kini di halaman ini.<br />\r\nDengan sering melayari halaman ini, anda akan dikemas kini dengan maklumat yang dikumpul, cara ia digunakan dan dalam keadaan tertentu, bagaimana maklumat dikongsi bersama pihak yang lain.</font></span></p>', 'administrator', '2009-06-02 15:03:55', 1),
(7, 'Dasar Keselamatan edit', 'Dasar Keselamatan edit', '<p><font size="2"><b><span style="font-family: Arial;">Dasar Keselamatan</span></b><span style="font-family: Arial;"> edit<o:p></o:p></span></font></p>\r\n<p style="vertical-align: top;"><b><span style="font-family: Arial;"><font size="2">Perlindungan Data edit</font></span></b><span style="font-family: Arial;"><br />\r\n<font size="2">Teknologi keselamatan terkini adalah digunakan untuk melindungi data yang dikemukakan dan pematuhan kepada standard keselamatan yang ketat adalah terpakai untuk menghalang capaian yang tidak dibenarkan. edit</font></span><span style="font-family: Arial;"><o:p></o:p></span></p>\r\n<p><b><span style="font-size: 12pt; font-family: Arial;"><font size="2">Keselamatan Storan edit</font></span></b><span style="font-size: 12pt; font-family: Arial;"><br />\r\n<font size="2">Semua storan elektronik dan penghantaran data peribadi adalah dilindungi dan<br />\r\ndisimpan dengan menggunakan teknologi keselamatan yang sesuai.</font><span style="color: rgb(102, 102, 102);">&Acirc;&nbsp;</span></span>&Acirc;&nbsp;edit</p>', 'administrator', '2009-06-02 15:02:45', 1),
(12, 'Halaman Utama', '--', '<p>&nbsp;<img height="300" align="middle" width="400" alt="" src="/Zend_template/data/files/image/test/IMG_0640.jpg" /></p>', 'administrator', '2009-06-03 09:21:57', 1);

-- --------------------------------------------------------

--
-- Table structure for table `sys_jhevnegeri`
--

CREATE TABLE IF NOT EXISTS `sys_jhevnegeri` (
  `jhevnegeri_id` int(10) NOT NULL AUTO_INCREMENT,
  `jhevnegeri_name` varchar(255) NOT NULL,
  `jhevnegeri_alamat` text NOT NULL,
  `jhevnegeri_status` int(1) NOT NULL,
  PRIMARY KEY (`jhevnegeri_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `sys_jhevnegeri`
--

INSERT INTO `sys_jhevnegeri` (`jhevnegeri_id`, `jhevnegeri_name`, `jhevnegeri_alamat`, `jhevnegeri_status`) VALUES
(1, 'CAWANGAN NEGERI KEDAH, PERLIS DAN P. PINANG', '268, Kompleks Shahab Perdana\r\nLebuh Raya Sultanah Bahiyah\r\n05350 Alor Setar\r\nKedah Darul Aman', 1),
(2, 'CAWANGAN NEGERI PERAK ', 'Lot 3-10, (A-C) Tingkat 3\r\nBangunan Seri Kinta\r\nJalan Sultan Idris Shah\r\n30000 Ipoh\r\nPerak Darul Ridzuan', 1),
(3, 'CAWANGAN NEGERI SELANGOR DAN W.P. KUALA LUMPUR', '301, Medan Tuanku\r\nJalan Tuanku Abdul Rahman\r\nPeti Surat 13191\r\n50802 Kuala Lumpur', 1),
(4, 'CAWANGAN NEGERI MELAKA DAN N. SEMBILAN', 'Aras 1-A, Wisma Persekutuan\r\nJalan MITC, Hang Tuah Jaya\r\n75450 Ayer Keroh,\r\nMelaka', 1),
(5, 'CAWANGAN NEGERI JOHOR', 'Bilik 4, Tingkat 9,\r\nBangunan KWSP, Jalan Dato’ Dalam\r\n80250 Johor Bharu\r\nJohor Darul Takzim ', 1),
(6, 'CAWANGAN NEGERI PAHANG', 'Tingkat Satu, Wisma Pahlawan\r\nJalan Gambut\r\n25000 Kuantan\r\nPahang Darul Makmur ', 1),
(7, 'CAWANGAN NEGERI KELANTAN DAN TERENGGANU', 'Tingkat 9, Menara Perbadanan\r\nJalan Tengku Petra Semerak\r\n15000 Kota Bharu\r\nKelantan Darul Naim ', 1),
(8, 'CAWANGAN NEGERI SABAH', 'Pintu C7-3, Tingkat 7, Blok C\r\nBangunan KWSP\r\nJalan Karamunsing\r\n88000 Kota Kinabalu\r\nSabah ', 1),
(9, 'CAWANGAN NEGERI SARAWAK', 'Tingkat 1, Lot 331, 332 & 333\r\nSeksyen 9, Jalan Satok\r\n93400 Kuching\r\nSarawak ', 1);

-- --------------------------------------------------------

--
-- Table structure for table `sys_marital`
--

CREATE TABLE IF NOT EXISTS `sys_marital` (
  `usrmrd_id` tinyint(1) NOT NULL AUTO_INCREMENT,
  `ursmrd_name` varchar(50) NOT NULL,
  `usrmrd_status` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`usrmrd_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT AUTO_INCREMENT=6 ;

--
-- Dumping data for table `sys_marital`
--

INSERT INTO `sys_marital` (`usrmrd_id`, `ursmrd_name`, `usrmrd_status`) VALUES
(1, 'Bujang', 1),
(2, 'Berkahwin', 1),
(3, 'Duda', 1),
(4, 'Janda', 1),
(5, 'Tiada Maklumat', 1);

-- --------------------------------------------------------

--
-- Table structure for table `sys_nationality`
--

CREATE TABLE IF NOT EXISTS `sys_nationality` (
  `nationality_id` tinyint(1) NOT NULL AUTO_INCREMENT,
  `nationality_name` varchar(50) NOT NULL,
  PRIMARY KEY (`nationality_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `sys_nationality`
--

INSERT INTO `sys_nationality` (`nationality_id`, `nationality_name`) VALUES
(1, 'Warganegara'),
(2, 'Bukan Warganegara');

-- --------------------------------------------------------

--
-- Table structure for table `sys_nolesen`
--

CREATE TABLE IF NOT EXISTS `sys_nolesen` (
  `nolesen_id` int(11) NOT NULL AUTO_INCREMENT,
  `usr_id` varchar(50) DEFAULT NULL,
  `nolesen_tarikh` datetime DEFAULT NULL,
  `nolesen_status` int(11) NOT NULL,
  PRIMARY KEY (`nolesen_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `sys_nolesen`
--


-- --------------------------------------------------------

--
-- Table structure for table `sys_pangkat`
--

CREATE TABLE IF NOT EXISTS `sys_pangkat` (
  `pangkat_id` int(11) NOT NULL,
  `pangkat_kod` varchar(32) NOT NULL,
  `pangkat_desc` varchar(255) NOT NULL,
  `pangkat_perkhidmatan` int(5) DEFAULT NULL,
  `pangkat_status` tinyint(1) NOT NULL,
  PRIMARY KEY (`pangkat_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sys_pangkat`
--

INSERT INTO `sys_pangkat` (`pangkat_id`, `pangkat_kod`, `pangkat_desc`, `pangkat_perkhidmatan`, `pangkat_status`) VALUES
(1, 'JEN (PAT)', 'PANGLIMA ANGKATAN TENTERA', 10, 1),
(102, 'JEN', 'JENERAL', 2, 1),
(103, 'LT JEN', 'LEFTENAN JENERAL', 2, 1),
(104, 'MEJ JEN', 'MEJAR JENERAL', 2, 1),
(105, 'BRID JEN', 'BRIGADIER JENERAL', 2, 1),
(106, 'KOL', 'KOLONEL', 2, 1),
(107, 'LT KOL', 'LEFTENAN KOLONEL', 2, 1),
(108, 'MEJ', 'MEJAR', 2, 1),
(109, 'KAPT', 'KAPTEN', 2, 1),
(110, 'LEFT ', 'LEFTENAN', 2, 1),
(111, 'LT M', 'LEFTENAN MUDA', 2, 1),
(112, 'KDT KANAN', 'KDT KANAN', NULL, 0),
(113, 'KDT', 'KDT', NULL, 0),
(114, 'PW I', 'PEGAWAI WAREN SATU', 2, 1),
(115, 'PW II', 'PEGAWAI WAREN DUA', 2, 1),
(116, 'SSJN', 'STAF SARJAN', 2, 1),
(117, 'SJN', 'SARJAN', 2, 1),
(118, 'KPL', 'KOPERAL', 2, 1),
(119, 'LKPL', 'LANS KOPERAL', 2, 1),
(120, 'PBT', 'PREBET', 2, 1),
(202, 'LAKSAMANA', 'LAKSAMANA', 3, 1),
(203, 'LAKSDYA', 'LAKSAMANA MADYA', 3, 1),
(204, 'LAKSDA', 'LAKSAMANA MUDA', 3, 1),
(205, 'LAKSMA', 'LAKSAMANA PERTAMA', 3, 1),
(206, 'KEPT TLDM', 'KEPTEN', 3, 1),
(207, 'KDR TLDM', 'KOMANDER', 3, 1),
(208, 'LT KDR TLDM', 'LEFTENAN KOMANDER', 3, 1),
(209, 'LT TLDM', 'LEFTENAN (TLDM)', 3, 1),
(210, 'LT DYA TLDM', 'LEFTENAN MADYA', 3, 1),
(211, 'LT M TLDM', 'LEFTENAN MUDA (TLDM)', 3, 1),
(214, 'PW I', 'PEGAWAI WAREN SATU (TLDM)', 3, 1),
(215, 'PW II', 'PEGAWAI WAREN DUA (TLDM)', 3, 1),
(216, 'BK', 'BINTARA KANAN', 3, 1),
(217, 'BM', 'BINTARA MUDA', 3, 1),
(218, 'LK', 'LASKAR KANAN', 3, 1),
(219, 'LK I', 'LASKAR KELAS SATU', 3, 1),
(220, 'LK II', 'LASKAR KELAS DUA', 3, 1),
(221, 'LKM', 'LASKAR MUDA', 3, 1),
(302, 'JEN(TUDM)    ', 'JENERAL (TUDM)', NULL, 1),
(303, 'LT JEN(TUDM)    ', 'LEFTENAN JENERAL  (TUDM)', 4, 1),
(304, 'MEJ JEN(TUDM)', 'MEJ JENERAL  (TUDM)', 4, 1),
(305, 'BRIG JEN(TUDM)  ', 'BRIGEDIER JENERAL  (TUDM)', 4, 1),
(306, 'KOL (TUDM)', 'KOLONEL  (TUDM)', 4, 1),
(307, 'LT KOL(TUDM)  ', 'LEFTENAN KOLONEL  (TUDM)', 4, 1),
(308, 'MEJ(TUDM)     ', 'MEJAR  (TUDM)', 4, 1),
(309, 'KAPT(TUDM)  ', 'KAPTEN  (TUDM)', 4, 1),
(310, 'LT(TUDM)  ', 'LEFTENAN  (TUDM)', 4, 1),
(311, 'LTM(TUDM)   ', 'LEFTENAN MUDA  (TUDM)', 4, 1),
(314, 'PW U I', 'PEGAWAI WAREN UDARA SATU', 4, 1),
(315, 'PW U II ', 'PEGAWAI WAREN UDARA DUA', 4, 1),
(316, 'F/SJN', 'FLAIT SARJAN', 4, 1),
(317, 'SJN U', 'SARJAN UDARA', 4, 1),
(318, 'KPL U ', 'KOPERAL UDARA', 4, 1),
(319, 'LUK', 'LASKAR UDARA KANAN', 4, 1),
(320, 'LU I', 'LASKAR UDARA 1', 4, 1),
(321, 'LU II', 'LASKAR UDARA II', 4, 1),
(999, 'NA', 'TIADA MAKLUMAT', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `sys_race`
--

CREATE TABLE IF NOT EXISTS `sys_race` (
  `race_id` int(10) NOT NULL AUTO_INCREMENT,
  `race_desc` varchar(255) NOT NULL,
  `race_status` tinyint(1) NOT NULL,
  PRIMARY KEY (`race_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `sys_race`
--

INSERT INTO `sys_race` (`race_id`, `race_desc`, `race_status`) VALUES
(1, 'Melayu', 1),
(2, 'Cina', 1),
(3, 'India', 1),
(4, 'Bumiputra Sarawak', 1),
(5, 'Bumiputra Sabah', 1),
(6, 'Lain-lain', 1),
(7, 'Tiada Maklumat', 1);

-- --------------------------------------------------------

--
-- Table structure for table `sys_religion`
--

CREATE TABLE IF NOT EXISTS `sys_religion` (
  `religion_id` tinyint(3) NOT NULL AUTO_INCREMENT,
  `religion_desc` varchar(50) NOT NULL,
  `religion_status` tinyint(1) NOT NULL,
  PRIMARY KEY (`religion_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `sys_religion`
--

INSERT INTO `sys_religion` (`religion_id`, `religion_desc`, `religion_status`) VALUES
(1, 'Tiada Maklumat', 1),
(2, 'Islam', 1),
(3, 'Buddha', 1),
(4, 'Hindu', 1),
(5, 'Kristian', 1),
(6, 'Lain-lain', 1);

-- --------------------------------------------------------

--
-- Table structure for table `sys_state`
--

CREATE TABLE IF NOT EXISTS `sys_state` (
  `sta_id` tinyint(2) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `sta_code` varchar(255) NOT NULL DEFAULT '',
  `sta_name` varchar(255) NOT NULL DEFAULT '',
  `sta_status` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`sta_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=101 ;

--
-- Dumping data for table `sys_state`
--

INSERT INTO `sys_state` (`sta_id`, `sta_code`, `sta_name`, `sta_status`) VALUES
(01, 'JOH', 'JOHOR', 1),
(02, 'KED', 'KEDAH', 1),
(03, 'KEL', 'KELANTAN', 1),
(04, 'MEL', 'MELAKA', 1),
(05, 'NS', 'NEGERI SEMBILAN', 1),
(06, 'PAH', 'PAHANG', 1),
(07, 'PEN', 'PULAU PINANG', 1),
(08, 'PRK', 'PERAK', 1),
(09, 'PER', 'PERLIS', 1),
(10, 'SEL', 'SELANGOR', 1),
(11, 'TRG', 'TERENGGANU', 1),
(12, 'SAB', 'SABAH', 1),
(13, 'SRWK', 'SARAWAK', 1),
(14, 'KL', 'WILAYAH PERSEKUTUAN KUALA LUMPUR', 1),
(15, 'LBN', 'WILAYAH PERSEKUTUAN LABUAN', 1),
(16, 'PRJY', 'WILAYAH PERSEKUTUAN PUTRAJAYA', 1),
(98, 'LUAR', 'LUAR NEGERI', 1),
(99, 'LAIN', 'LAIN-LAIN', 1),
(100, 'NA', 'TIADA MAKLUMAT', 1);

-- --------------------------------------------------------

--
-- Table structure for table `sys_taraf_pekerjaan`
--

CREATE TABLE IF NOT EXISTS `sys_taraf_pekerjaan` (
  `taraf_pekerjaan_id` int(11) NOT NULL AUTO_INCREMENT,
  `taraf_pekerjaan_name` varchar(20) NOT NULL,
  PRIMARY KEY (`taraf_pekerjaan_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `sys_taraf_pekerjaan`
--

INSERT INTO `sys_taraf_pekerjaan` (`taraf_pekerjaan_id`, `taraf_pekerjaan_name`) VALUES
(1, 'Sepenuh Masa'),
(2, 'Sambilan'),
(3, 'Bebas');

-- --------------------------------------------------------

--
-- Table structure for table `sys_user`
--

CREATE TABLE IF NOT EXISTS `sys_user` (
  `usr_id` varchar(80) NOT NULL COMMENT 'ID Pengguna',
  `usr_fullname` varchar(80) NOT NULL COMMENT 'Nama Penuh',
  `usr_identno` varchar(12) DEFAULT NULL COMMENT 'No KP',
  `usr_password` varchar(100) NOT NULL DEFAULT '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8' COMMENT 'Password',
  `usr_email` varchar(50) NOT NULL COMMENT 'Email',
  `usr_bday` date DEFAULT NULL COMMENT 'User Birthday',
  `usr_lastlogin` datetime DEFAULT NULL COMMENT 'Login Terakhir',
  `usr_jhevnegeri` int(5) DEFAULT NULL,
  `level_id` int(2) NOT NULL DEFAULT '0' COMMENT 'Level ID',
  `usr_active` int(1) NOT NULL DEFAULT '1' COMMENT 'Status',
  `role_id` tinyint(3) unsigned DEFAULT '3' COMMENT 'Role ID',
  `type_id` int(11) DEFAULT '1' COMMENT 'jenis pengguna',
  `new_user` smallint(1) DEFAULT NULL,
  PRIMARY KEY (`usr_id`),
  KEY `role_id` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sys_user`
--

INSERT INTO `sys_user` (`usr_id`, `usr_fullname`, `usr_identno`, `usr_password`, `usr_email`, `usr_bday`, `usr_lastlogin`, `usr_jhevnegeri`, `level_id`, `usr_active`, `role_id`, `type_id`, `new_user`) VALUES
('achik.amiez@gmail.com', 'Mohd Shuhaimi Bin Abdul Aziz', '850722075081', '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'achik.amiez@gmail.com', '1985-07-22', NULL, NULL, 0, 1, 2, 1, NULL),
('amiez_boyzus@yahoo.com.my', 'Amiez Aziz', '120000000000', 'e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855', 'amiez_boyzus@yahoo.com.my', '1988-04-30', NULL, NULL, 0, 1, 14, 1, NULL),
('artiesa', 'Artiesa Arris', '860610355628', '0b14d501a594442a01c6859541bcb3e8164d183d32937b851835442f69d5c94e', 'artiesa@mod.gov.my', NULL, NULL, NULL, 0, 1, 13, 1, NULL),
('elektro71', 'Elek Tro Go', '200210065102', 'e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855', 'jhevians@gmail.com', NULL, NULL, NULL, 0, 1, 13, 1, NULL),
('lena', 'Lena Anggie', '800921078000', '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'lena@mod.gov.my', NULL, NULL, NULL, 0, 1, 13, 1, NULL),
('pegawaibpm1', 'Pegawai BPM 1', '860610355626', '58f64d13a0260e94d0cc24193028da8faacd5ea1281303f9d59b295ce710a233', 'pegawaibpm1@jhev.gov.my', NULL, NULL, NULL, 0, 1, 13, 1, NULL),
('Pengadu1', 'Pengadu 01', '850610355627', '0e58b9af759873290cbd79d3c1bc6c56380603e543767926b09a2347081fa19a', 'pengadu1@mod.gov.my', NULL, NULL, NULL, 0, 1, 3, 1, NULL),
('penyelia1', 'Pegawai Penyelia 1', '860610355623', '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'penyelia1@jhev.gov.my', NULL, NULL, NULL, 0, 1, 12, 1, NULL),
('shuhaimi', 'Mohd Shuhaimi', '850722075082', '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'shuhaimi@mod.gov.my', '1985-07-22', '0000-00-00 00:00:00', NULL, 0, 1, 2, 1, NULL),
('staf1', 'Staf BPM Multimedia', '860610355622', '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'staf1@jhev.gov.my', NULL, NULL, NULL, 0, 1, 14, 1, NULL),
('user1', 'User Pengadu', '123456789012', '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'user1@jhev.gov.my', NULL, NULL, NULL, 0, 1, 3, 1, NULL),
('user2', 'Penyelia Penguna (User 2)', '860610355627', '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'penyelia.pengguna@jhev.gov.my', NULL, NULL, NULL, 0, 1, 12, 1, NULL),
('UserAduan', 'Pengadu No 2', '860610355612', '0b14d501a594442a01c6859541bcb3e8164d183d32937b851835442f69d5c94e', 'useraduan1@mod.gov.my', NULL, NULL, NULL, 0, 1, 3, 1, NULL),
('yusri.harun@gmail.com', 'Yusri Harun', '880108055103', '0b14d501a594442a01c6859541bcb3e8164d183d32937b851835442f69d5c94e', 'yusri.harun@gmail.com', NULL, NULL, NULL, 0, 1, 2, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sys_user_active`
--

CREATE TABLE IF NOT EXISTS `sys_user_active` (
  `active_id` int(2) NOT NULL,
  `active_name` varchar(80) NOT NULL,
  PRIMARY KEY (`active_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sys_user_active`
--

INSERT INTO `sys_user_active` (`active_id`, `active_name`) VALUES
(0, 'Tidak Aktif'),
(1, 'Aktif');

-- --------------------------------------------------------

--
-- Table structure for table `sys_user_contact`
--

CREATE TABLE IF NOT EXISTS `sys_user_contact` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usr_id` varchar(80) NOT NULL,
  `contact_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=28 ;

--
-- Dumping data for table `sys_user_contact`
--

INSERT INTO `sys_user_contact` (`id`, `usr_id`, `contact_id`) VALUES
(20, 'test13', 1),
(21, 'test13', 3),
(22, '123456', 1),
(23, '123456', 2),
(24, 'ilia', 1),
(25, 'ilia', 2),
(26, 'narowi', 1),
(27, 'narowi', 3);

-- --------------------------------------------------------

--
-- Table structure for table `sys_user_detail`
--

CREATE TABLE IF NOT EXISTS `sys_user_detail` (
  `usr_id` varchar(80) NOT NULL,
  `usr_nokplama` varchar(20) DEFAULT NULL,
  `usr_date_birth` date DEFAULT NULL,
  `usr_religion` tinyint(3) DEFAULT NULL,
  `usr_race` tinyint(3) DEFAULT NULL,
  `usr_sex` tinyint(3) DEFAULT NULL,
  `usr_nationality` tinyint(1) DEFAULT NULL,
  `usr_marital_status` tinyint(1) DEFAULT NULL,
  `usr_education_level` tinyint(3) DEFAULT NULL,
  `usr_add_primary` varchar(255) DEFAULT NULL,
  `usr_add_primary2` varchar(200) DEFAULT NULL,
  `usr_add_primary3` varchar(200) DEFAULT NULL,
  `usr_poscode_primary` varchar(5) DEFAULT NULL,
  `usr_city_primary` varchar(50) DEFAULT NULL,
  `usr_state_primary` tinyint(2) unsigned zerofill DEFAULT NULL,
  `usr_country_primary` varchar(50) DEFAULT NULL,
  `usr_phone_no` varchar(12) DEFAULT NULL,
  `usr_mobile_no` varchar(12) DEFAULT NULL,
  `usr_bpm` smallint(3) DEFAULT NULL,
  `jhev_jawatan` int(10) DEFAULT NULL,
  `jhev_no` varchar(100) DEFAULT NULL,
  `jhev_dept` int(3) DEFAULT NULL,
  `jhev_unit` int(3) DEFAULT NULL,
  `record_by` varchar(255) DEFAULT NULL,
  `record_date` datetime DEFAULT NULL,
  PRIMARY KEY (`usr_id`),
  KEY `usr_religion` (`usr_religion`,`usr_sex`,`usr_nationality`,`usr_marital_status`,`usr_education_level`),
  KEY `usr_state_primary` (`usr_state_primary`),
  KEY `usr_sex` (`usr_sex`),
  KEY `usr_nationality` (`usr_nationality`),
  KEY `usr_education_level` (`usr_education_level`),
  KEY `usr_marital_status` (`usr_marital_status`),
  KEY `usr_state_primary_2` (`usr_state_primary`),
  KEY `jhev_unit` (`jhev_unit`),
  KEY `jhev_dept` (`jhev_dept`),
  KEY `jhev_jawatan` (`jhev_jawatan`),
  KEY `usr_bpm` (`usr_bpm`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sys_user_detail`
--

INSERT INTO `sys_user_detail` (`usr_id`, `usr_nokplama`, `usr_date_birth`, `usr_religion`, `usr_race`, `usr_sex`, `usr_nationality`, `usr_marital_status`, `usr_education_level`, `usr_add_primary`, `usr_add_primary2`, `usr_add_primary3`, `usr_poscode_primary`, `usr_city_primary`, `usr_state_primary`, `usr_country_primary`, `usr_phone_no`, `usr_mobile_no`, `usr_bpm`, `jhev_jawatan`, `jhev_no`, `jhev_dept`, `jhev_unit`, `record_by`, `record_date`) VALUES
('achik.amiez@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0125374226', 2, 5, NULL, 5, NULL, NULL, NULL),
('amiez_boyzus@yahoo.com.my', NULL, '2012-00-00', NULL, NULL, 1, NULL, NULL, NULL, 'KL', NULL, NULL, '55100', '295', 14, NULL, '0320508000', '0125374226', 1, NULL, 'A1515', 1, 4, NULL, NULL),
('artiesa', NULL, '1986-06-10', NULL, NULL, 2, NULL, NULL, NULL, 'no 1', NULL, NULL, '20000', '241', 12, NULL, '0320508000', '0137227224', NULL, NULL, '1-1000', 1, 4, NULL, NULL),
('elektro71', NULL, '2020-02-10', NULL, NULL, 1, NULL, NULL, NULL, 'no 2', NULL, NULL, '23456', '119', 07, NULL, '0320508000', '0121234567', NULL, NULL, '1-101', 1, 4, NULL, NULL),
('lena', NULL, '1980-09-21', NULL, NULL, 2, NULL, NULL, NULL, 'no 1', NULL, NULL, '68000', '197', 10, NULL, '0320508000', '0137227224', NULL, NULL, '1-1000', 1, 3, NULL, NULL),
('pegawaibpm1', NULL, '1986-06-10', NULL, NULL, 2, NULL, NULL, NULL, 'Tingkat 8 Unit Pencen', NULL, NULL, '55100', '295', 14, NULL, '0320508000', '0137227224', NULL, NULL, 'A8481744', 2, 8, NULL, NULL),
('Pengadu1', NULL, '1985-06-10', NULL, NULL, 1, NULL, NULL, NULL, 'Unit Akaun JHEV HQ', NULL, NULL, '55100', '295', 14, NULL, '0320508000', '0137227224', NULL, NULL, '1-234', 3, 1, NULL, NULL),
('penyelia1', NULL, '1986-06-10', NULL, NULL, 1, NULL, NULL, NULL, 'Tingkat 9JHEV HQ Unit BKA', NULL, NULL, '55100', '295', 14, NULL, '0320508000', '0125374226', NULL, NULL, 'A8481744', 3, 1, NULL, NULL),
('shuhaimi', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL),
('staf1', NULL, '1986-06-10', NULL, NULL, 1, NULL, NULL, NULL, 'Tingkat 20 BPM JHEV', NULL, NULL, '55100', '295', 14, NULL, '0320508000', '0125374226', NULL, NULL, 'A8481744', 1, 3, NULL, NULL),
('user1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, NULL, NULL, NULL),
('user2', NULL, '1986-06-10', NULL, NULL, 1, NULL, NULL, NULL, 'JHEV HQ', NULL, NULL, '55100', '295', 14, NULL, '0320508107', '0125374226', NULL, NULL, 'A-1413', 3, 1, NULL, NULL),
('UserAduan', NULL, '1986-06-10', NULL, NULL, 1, NULL, NULL, NULL, 'KL', NULL, NULL, '55100', '133', 07, NULL, '0320508000', '0125374226', NULL, NULL, 'A-1346', 2, 8, NULL, NULL),
('yusri.harun@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0126579487', 1, 7, '2-1420', 3, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sys_user_type`
--

CREATE TABLE IF NOT EXISTS `sys_user_type` (
  `user_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_type_name` varchar(50) NOT NULL,
  `type_group_id` int(11) NOT NULL COMMENT '1: pengguna dalaman; 2; pengguna luar',
  PRIMARY KEY (`user_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `sys_user_type`
--

INSERT INTO `sys_user_type` (`user_type_id`, `user_type_name`, `type_group_id`) VALUES
(1, 'Individu', 2),
(2, 'Syarikat', 2),
(10, 'Kakitangan', 1);

-- --------------------------------------------------------

--
-- Table structure for table `sys_user_type_group`
--

CREATE TABLE IF NOT EXISTS `sys_user_type_group` (
  `type_group_id` int(11) NOT NULL AUTO_INCREMENT,
  `type_group_name` varchar(20) NOT NULL,
  PRIMARY KEY (`type_group_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `sys_user_type_group`
--

INSERT INTO `sys_user_type_group` (`type_group_id`, `type_group_name`) VALUES
(1, 'Pengguna Dalaman'),
(2, 'Pengguna Luar');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_aktif`
--

CREATE TABLE IF NOT EXISTS `tbl_aktif` (
  `aktif_id` int(11) NOT NULL AUTO_INCREMENT,
  `aktif_name` varchar(15) NOT NULL,
  PRIMARY KEY (`aktif_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tbl_aktif`
--

INSERT INTO `tbl_aktif` (`aktif_id`, `aktif_name`) VALUES
(1, 'Aktif'),
(2, 'Tidak Aktif');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_audit_trail`
--

CREATE TABLE IF NOT EXISTS `tbl_audit_trail` (
  `audit_trail_id` int(11) NOT NULL AUTO_INCREMENT,
  `audit_trail_module` varchar(255) NOT NULL,
  `usr_id` varchar(80) NOT NULL,
  `audit_trail_datetime` datetime NOT NULL,
  `audit_trail_task` varchar(255) NOT NULL,
  `audit_trail_ipaddress` varchar(20) NOT NULL,
  PRIMARY KEY (`audit_trail_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

--
-- Dumping data for table `tbl_audit_trail`
--

INSERT INTO `tbl_audit_trail` (`audit_trail_id`, `audit_trail_module`, `usr_id`, `audit_trail_datetime`, `audit_trail_task`, `audit_trail_ipaddress`) VALUES
(1, 'Pendaftaran', 'yusri.harun@gmail.com', '2014-02-25 15:34:31', 'Pengguna Baru - yusri.harun@gmail.com', '10.0.20.7'),
(2, 'Pendaftaran', 'achik.amiez@gmail.com', '2014-03-14 12:48:39', 'Pengguna Baru - achik.amiez@gmail.com', '10.0.20.7'),
(3, 'Pendaftaran', 'amiez_boyzus@yahoo.com.my', '2014-03-16 14:29:21', 'Pengguna Baru - amiez_boyzus@yahoo.com.my', '183.171.171.141'),
(4, 'Pendaftaran', '', '2014-03-16 14:32:31', 'Pengguna Baru - ', '183.171.171.141'),
(5, 'Pendaftaran', 'eila_lovemail@yahoo.com', '2014-04-18 13:00:05', 'Pengguna Baru - eila_lovemail@yahoo.com', '192.168.100.14'),
(6, 'Pendaftaran', '', '2014-04-23 12:37:23', 'Pengguna Baru - ', '10.0.20.7'),
(7, 'Pendaftaran', 'jhevians@gmail.com', '2014-04-23 12:37:57', 'Pengguna Baru - jhevians@gmail.com', '10.0.20.7'),
(8, 'Pendaftaran', 'jhevians@gmail.com', '2014-04-23 12:42:42', 'Pengguna Baru - jhevians@gmail.com', '10.0.20.7'),
(9, 'Profil Pengguna', 'yusri.harun@gmail.com', '2014-05-27 17:01:15', 'Kemaskini Kata Laluan - yusri.harun@gmail.com', '127.0.0.1'),
(10, 'Profil Pengguna', 'Pengadu1', '2014-05-29 11:02:13', 'Kemaskini Profil - Pengadu1', '127.0.0.1'),
(11, 'Aduan', 'Pengadu1', '2014-05-29 11:10:54', 'Aduan Baru ID : 22 - Pengadu1', '127.0.0.1'),
(12, 'Aduan', 'pegawaibpm1', '2014-05-29 16:14:59', 'Kelulusan Aduan ID : 21 - pegawaibpm1', '127.0.0.1'),
(13, 'Aduan', 'pegawaibpm1', '2014-05-29 16:18:05', 'Kelulusan Aduan ID : 21 - pegawaibpm1', '127.0.0.1'),
(14, 'Aduan', 'staf1', '2014-05-29 16:22:34', 'Tindakan Aduan ID : 21 - staf1', '127.0.0.1'),
(15, 'Profil Pengguna', 'Pengadu1', '2014-05-29 16:24:47', 'Kemaskini Profil - Pengadu1', '127.0.0.1'),
(16, 'Aduan', 'Pengadu1', '2014-05-29 16:31:40', 'Aduan Baru ID : 23 - Pengadu1', '127.0.0.1'),
(17, 'Profil Pengguna', 'penyelia1', '2014-05-29 16:32:36', 'Kemaskini Profil - penyelia1', '127.0.0.1'),
(18, 'Aduan', 'penyelia1', '2014-05-29 16:34:24', 'Pengesahan Aduan ID : 23 - penyelia1', '127.0.0.1'),
(19, 'Aduan', 'penyelia1', '2014-05-29 16:38:32', 'Pengesahan Aduan ID : 22 - penyelia1', '127.0.0.1'),
(20, 'Aduan', 'UserAduan', '2014-05-29 17:13:42', 'Aduan Baru ID : 24 - UserAduan', '127.0.0.1'),
(21, 'Profil Pengguna', 'UserAduan', '2014-05-29 17:14:14', 'Kemaskini Profil - UserAduan', '127.0.0.1'),
(22, 'Profil Pengguna', 'UserAduan', '2014-05-29 17:15:00', 'Kemaskini Kata Laluan - UserAduan', '127.0.0.1'),
(23, 'Aduan', 'penyelia1', '2014-05-29 17:21:52', 'Pengesahan Aduan ID : 24 - penyelia1', '127.0.0.1'),
(24, 'Aduan', 'artiesa', '2014-05-29 17:23:19', 'Kelulusan Aduan ID : 24 - artiesa', '127.0.0.1'),
(25, 'Profil Pengguna', 'artiesa', '2014-05-29 17:25:08', 'Kemaskini Kata Laluan - artiesa', '127.0.0.1'),
(26, 'Aduan', 'staf1', '2014-05-29 17:45:44', 'Tindakan Aduan ID : 24 - staf1', '127.0.0.1'),
(27, 'Aduan', 'Pengadu1', '2014-05-29 17:48:56', 'Aduan Baru ID : 25 - Pengadu1', '127.0.0.1'),
(28, 'Aduan', 'penyelia1', '2014-05-29 17:50:04', 'Pengesahan Aduan ID : 25 - penyelia1', '127.0.0.1'),
(29, 'Aduan', 'lena', '2014-05-29 17:51:12', 'Kelulusan Aduan ID : 25 - lena', '127.0.0.1'),
(30, 'Aduan', 'staf1', '2014-05-29 17:53:31', 'Tindakan Aduan ID : 25 - staf1', '127.0.0.1');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ea_bpm`
--
ALTER TABLE `ea_bpm`
  ADD CONSTRAINT `ea_bpm_ibfk_1` FOREIGN KEY (`pegawai_id`) REFERENCES `sys_user` (`usr_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `ea_jawatan`
--
ALTER TABLE `ea_jawatan`
  ADD CONSTRAINT `ea_jawatan_ibfk_1` FOREIGN KEY (`bahagian_id`) REFERENCES `ea_bahagian` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `ea_unit`
--
ALTER TABLE `ea_unit`
  ADD CONSTRAINT `ea_unit_ibfk_1` FOREIGN KEY (`penyelia_id`) REFERENCES `sys_user` (`usr_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `sys_user_detail`
--
ALTER TABLE `sys_user_detail`
  ADD CONSTRAINT `sys_user_detail_ibfk_1` FOREIGN KEY (`usr_state_primary`) REFERENCES `sys_state` (`sta_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `sys_user_detail_ibfk_2` FOREIGN KEY (`jhev_jawatan`) REFERENCES `ea_jawatan` (`jawatan_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `sys_user_detail_ibfk_3` FOREIGN KEY (`jhev_dept`) REFERENCES `ea_bahagian` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `sys_user_detail_ibfk_4` FOREIGN KEY (`jhev_unit`) REFERENCES `ea_unit` (`unit_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
