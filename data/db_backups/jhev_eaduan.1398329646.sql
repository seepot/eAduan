# MySQL dump of database 'jhev_eaduan' on host '192.168.110.184'
# backup date and time: 24-Apr-2014 16:54:06
# Template Zend

# comment:
# aaaaa

CREATE DATABASE IF NOT EXISTS `jhev_eaduan`;

USE `jhev_eaduan`;


### structure of table `acl_module` ###

DROP TABLE IF EXISTS `acl_module`;

CREATE TABLE `acl_module` (
  `acl_module_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Module ID',
  `acl_module_name` varchar(32) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Module Name',
  `acl_module_desc` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Module Description',
  `acl_module_show` tinyint(1) unsigned NOT NULL COMMENT 'Module Show',
  PRIMARY KEY (`acl_module_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='ACL Modules' AUTO_INCREMENT=13;


### data of table `acl_module` ###

insert into `acl_module` values ('1', 'default', 'Utama', '2');
insert into `acl_module` values ('2', 'admin', 'Induk', '1');
insert into `acl_module` values ('7', 'layout', 'Layout', '0');
insert into `acl_module` values ('8', 'menu', 'Menu Kiri', '0');
insert into `acl_module` values ('9', 'tempahan', 'Tempahan', '1');
insert into `acl_module` values ('10', 'bp', 'Pencen', '1');
insert into `acl_module` values ('11', 'bkp', 'Bahagian Khidmat Pengurusan', '1');
insert into `acl_module` values ('12', 'btm', 'Modul BTM', '1');


### structure of table `acl_privilege` ###

DROP TABLE IF EXISTS `acl_privilege`;

CREATE TABLE `acl_privilege` (
  `acl_privilege_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Privilege ID',
  `acl_resource_id` tinyint(3) unsigned NOT NULL COMMENT 'Resource ID',
  `acl_privilege_name` varchar(32) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Privilege Name',
  `acl_privilege_desc` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Privilege Desc',
  `acl_privilege_show` tinyint(1) NOT NULL COMMENT 'Privilege Show',
  PRIMARY KEY (`acl_privilege_id`),
  UNIQUE KEY `acl_resource_id_2` (`acl_resource_id`,`acl_privilege_name`),
  KEY `acl_resource_id` (`acl_resource_id`),
  KEY `acl_privilege_name` (`acl_privilege_name`)
) ENGINE=InnoDB AUTO_INCREMENT=98 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='ACL Privileges' AUTO_INCREMENT=98;


### data of table `acl_privilege` ###

insert into `acl_privilege` values ('1', '1', 'index', '', '0');
insert into `acl_privilege` values ('2', '2', 'login', '', '0');
insert into `acl_privilege` values ('3', '2', 'logout', '', '0');
insert into `acl_privilege` values ('4', '3', 'error', '', '0');
insert into `acl_privilege` values ('5', '4', 'index', '', '0');
insert into `acl_privilege` values ('6', '4', 'noaccess', '', '0');
insert into `acl_privilege` values ('7', '5', 'index', '', '0');
insert into `acl_privilege` values ('8', '5', 'list', 'Senarai Pengguna', '1');
insert into `acl_privilege` values ('9', '5', 'add', 'Tambah Pengguna', '1');
insert into `acl_privilege` values ('10', '5', 'view', 'Papar Pengguna', '1');
insert into `acl_privilege` values ('11', '5', 'delete', 'Hapus Pengguna', '1');
insert into `acl_privilege` values ('12', '6', 'index', '', '0');
insert into `acl_privilege` values ('13', '6', 'list', 'Senarai Kumpulan Pengguna', '1');
insert into `acl_privilege` values ('14', '6', 'add', 'Tambah Kumpulan Pengguna', '1');
insert into `acl_privilege` values ('15', '5', 'edit', 'Kemaskini Pengguna', '1');
insert into `acl_privilege` values ('17', '8', 'module', 'Senarai Modul', '0');
insert into `acl_privilege` values ('18', '8', 'resources', 'Senarai Resource', '0');
insert into `acl_privilege` values ('19', '8', 'privileges', 'Senarai Privileges', '0');
insert into `acl_privilege` values ('20', '8', 'module_add', 'Tambah Modul', '0');
insert into `acl_privilege` values ('21', '8', 'resource_add', 'Tambah Resource', '0');
insert into `acl_privilege` values ('22', '8', 'privilege_add', 'Tambah Privilege', '0');
insert into `acl_privilege` values ('23', '4', 'pdf', 'Test PDF', '1');
insert into `acl_privilege` values ('24', '6', 'edit', 'Kemaskini Kumpulan Pengguna', '1');
insert into `acl_privilege` values ('25', '4', 'print', 'Test DAtaGRid', '1');
insert into `acl_privilege` values ('28', '8', 'resource_delete', 'Hapus Resource', '0');
insert into `acl_privilege` values ('29', '8', 'privilege_delete', 'Hapus Privilege', '0');
insert into `acl_privilege` values ('31', '8', 'module_delete', 'Hapus Module', '0');
insert into `acl_privilege` values ('34', '16', 'head', 'Header', '0');
insert into `acl_privilege` values ('35', '17', 'index', '-', '0');
insert into `acl_privilege` values ('39', '25', 'index', 'Menu Tempahan', '0');
insert into `acl_privilege` values ('40', '23', 'list', 'Senarai Permohonan Baru', '1');
insert into `acl_privilege` values ('41', '23', 'apply', 'Permohonan Baru - Maklumat Am', '1');
insert into `acl_privilege` values ('42', '23', 'menu', 'Permohonan Baru - Menu', '1');
insert into `acl_privilege` values ('43', '23', 'bilik', 'Permohonan Baru - Bilik Perbincangan/Mesyuarat/Dewan', '1');
insert into `acl_privilege` values ('44', '23', 'perakuan', 'Permohonan Baru - Perakuan', '1');
insert into `acl_privilege` values ('45', '23', 'kelulusan', 'Keputusan Permohonan', '1');
insert into `acl_privilege` values ('46', '24', 'list', 'Transaksi Permohonan', '1');
insert into `acl_privilege` values ('47', '24', 'schedule', 'Jadual Penggunaan', '1');
insert into `acl_privilege` values ('48', '24', 'index', 'Index List Transaksi', '0');
insert into `acl_privilege` values ('49', '23', 'index', 'Index List New', '0');
insert into `acl_privilege` values ('51', '24', 'view', 'Papar Permohonan', '1');
insert into `acl_privilege` values ('52', '2', 'register', 'Pendaftaran', '0');
insert into `acl_privilege` values ('53', '27', 'profileedit', 'Kemaskini Profil', '1');
insert into `acl_privilege` values ('54', '28', 'index', '...', '0');
insert into `acl_privilege` values ('55', '27', 'profile', 'Profil Pesara', '1');
insert into `acl_privilege` values ('56', '27', 'fotoedit', 'Kemaskini Foto', '1');
insert into `acl_privilege` values ('57', '27', 'password', 'Tukar Kata Laluan', '1');
insert into `acl_privilege` values ('58', '29', 'carian', 'Carian', '1');
insert into `acl_privilege` values ('59', '29', 'tahun2009', 'Penyata Tahun 2009', '1');
insert into `acl_privilege` values ('60', '29', 'tahun2010', 'Penyata Tahun 2010', '1');
insert into `acl_privilege` values ('62', '31', 'index', '....', '0');
insert into `acl_privilege` values ('63', '2', 'forgotpassword', 'Lupa Kata Laluan', '0');
insert into `acl_privilege` values ('64', '29', 'index', '...', '0');
insert into `acl_privilege` values ('65', '27', 'bantuan', 'Bantuan - Profil', '1');
insert into `acl_privilege` values ('66', '29', 'bantuan', 'Bantuan - Penyata', '1');
insert into `acl_privilege` values ('67', '32', 'add', 'Tambah Maklumbalas', '1');
insert into `acl_privilege` values ('68', '33', 'index', '...', '0');
insert into `acl_privilege` values ('69', '32', 'listuser', 'Senarai Maklumbalas - Pengguna', '1');
insert into `acl_privilege` values ('70', '32', 'view', 'Papar Maklumbalas', '1');
insert into `acl_privilege` values ('71', '34', 'index', '...', '0');
insert into `acl_privilege` values ('72', '34', 'userlist', 'Transaksi Permohonan', '1');
insert into `acl_privilege` values ('73', '34', 'jhevlist', 'Senarai Permohonan', '1');
insert into `acl_privilege` values ('74', '35', 'index', '...', '0');
insert into `acl_privilege` values ('75', '35', 'apply', 'Permohonan - Maklumat Veteran', '1');
insert into `acl_privilege` values ('76', '35', 'operasi', 'Permohonan - Maklumat Operasi', '1');
insert into `acl_privilege` values ('77', '35', 'status', 'Permohonan - Maklumat Status', '1');
insert into `acl_privilege` values ('78', '35', 'lampiran', 'Permohonan - Lampiran', '1');
insert into `acl_privilege` values ('79', '35', 'perakuan', 'Permohonan - Perakuan', '1');
insert into `acl_privilege` values ('80', '34', 'view', 'Papar Permohonan PJM', '1');
insert into `acl_privilege` values ('81', '36', 'index', '...', '0');
insert into `acl_privilege` values ('82', '34', 'perakuanpp', 'Perakuan Penolong Pengarah Negeri', '1');
insert into `acl_privilege` values ('83', '34', 'sokongan', 'Sokongan Pengarah Negeri', '1');
insert into `acl_privilege` values ('84', '34', 'pengesahan', 'Pengesahan Ketua Pengarah JHEV', '1');
insert into `acl_privilege` values ('85', '37', 'index', '....', '0');
insert into `acl_privilege` values ('86', '38', 'index', '...', '0');
insert into `acl_privilege` values ('87', '38', 'carian', 'Carian', '1');
insert into `acl_privilege` values ('88', '29', 'tahun2011', 'Penyata 2011', '1');
insert into `acl_privilege` values ('89', '39', 'index', '....', '0');
insert into `acl_privilege` values ('90', '40', 'carian', 'Carian', '1');
insert into `acl_privilege` values ('91', '2', 'facebook', '...', '0');
insert into `acl_privilege` values ('92', '2', 'google', '...', '0');
insert into `acl_privilege` values ('93', '29', 'tahun2012', 'Penyata Tahun 20121', '1');
insert into `acl_privilege` values ('94', '2', 'state', 'Negeri', '0');
insert into `acl_privilege` values ('95', '2', 'district', 'Daerah', '0');
insert into `acl_privilege` values ('96', '2', 'dept', 'Bahagian', '0');
insert into `acl_privilege` values ('97', '2', 'unit', 'Unit', '0');


### structure of table `acl_resource` ###

DROP TABLE IF EXISTS `acl_resource`;

CREATE TABLE `acl_resource` (
  `acl_resource_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Resource ID',
  `acl_module_id` tinyint(3) unsigned NOT NULL COMMENT 'Module ID',
  `acl_resource_name` varchar(32) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Resource Name',
  `acl_resource_desc` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Resource Description',
  `acl_resource_show` tinyint(1) NOT NULL COMMENT 'Resource Show',
  PRIMARY KEY (`acl_resource_id`),
  KEY `acl_module_id` (`acl_module_id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='ACL Resources' AUTO_INCREMENT=41;


### data of table `acl_resource` ###

insert into `acl_resource` values ('1', '1', 'index', '', '2');
insert into `acl_resource` values ('2', '1', 'authentication', '', '2');
insert into `acl_resource` values ('3', '1', 'error', '', '2');
insert into `acl_resource` values ('4', '2', 'index', '', '2');
insert into `acl_resource` values ('5', '2', 'user', 'Pengguna', '1');
insert into `acl_resource` values ('6', '2', 'group', 'Kumpulan Pengguna', '1');
insert into `acl_resource` values ('8', '2', 'acl', 'Senarai Role', '0');
insert into `acl_resource` values ('16', '7', 'admin', 'Header', '0');
insert into `acl_resource` values ('17', '8', 'master', 'Menu Induk', '0');
insert into `acl_resource` values ('23', '9', 'new', 'Permohonan Tempahan', '1');
insert into `acl_resource` values ('24', '9', 'transaksi', 'Transaksi Permohonan', '1');
insert into `acl_resource` values ('25', '8', 'tempahan', 'Menu Tempahan', '0');
insert into `acl_resource` values ('26', '2', 'staff', 'Kakitangan', '1');
insert into `acl_resource` values ('27', '10', 'personal', 'Profil Peribadi', '1');
insert into `acl_resource` values ('28', '8', 'bp', 'Pencen', '1');
insert into `acl_resource` values ('29', '10', 'penyata', 'Penyata Pencen', '1');
insert into `acl_resource` values ('31', '8', 'profil', 'Menu Profil Pengguna', '0');
insert into `acl_resource` values ('32', '10', 'feedback', 'Maklumbalas', '1');
insert into `acl_resource` values ('33', '8', 'feedback', 'Maklumbalas', '0');
insert into `acl_resource` values ('34', '11', 'transaksi', 'Permohonan', '1');
insert into `acl_resource` values ('35', '11', 'medal', 'PJM - Permohonan', '1');
insert into `acl_resource` values ('36', '8', 'medal', '...', '0');
insert into `acl_resource` values ('37', '8', 'bpx', '....', '0');
insert into `acl_resource` values ('38', '10', 'semakan', 'Semak', '1');
insert into `acl_resource` values ('39', '8', 'bsn', '..s', '0');
insert into `acl_resource` values ('40', '12', 'bsn', 'Pencen Bank', '1');


### structure of table `acl_role` ###

DROP TABLE IF EXISTS `acl_role`;

CREATE TABLE `acl_role` (
  `acl_role_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ACL Role ID',
  `acl_role_name` varchar(32) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Role Name',
  `acl_role_desc` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Role Description',
  `acl_inherit_id` tinyint(3) unsigned NOT NULL COMMENT 'Inherit ID',
  `type_group_id` int(11) NOT NULL,
  `acl_role_status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`acl_role_id`),
  KEY `acl_role_name` (`acl_role_name`),
  KEY `acl_inherit_id` (`acl_inherit_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT COMMENT='ACL Roles' AUTO_INCREMENT=12;


### data of table `acl_role` ###

insert into `acl_role` values ('1', 'Pengguna Biasa', '', '0', '2', '0');
insert into `acl_role` values ('2', 'Pentadbir Sistem', '', '1', '1', '1');
insert into `acl_role` values ('3', 'Pengguna Berdaftar', 'Mempunyai capaian untuk membuat pengemaskinian profil dan melihat penyata pencen', '1', '2', '1');


### structure of table `acl_role_privilege` ###

DROP TABLE IF EXISTS `acl_role_privilege`;

CREATE TABLE `acl_role_privilege` (
  `acl_role_id` tinyint(3) unsigned NOT NULL COMMENT 'Role ID',
  `acl_privilege_id` smallint(5) unsigned NOT NULL COMMENT 'Privilege ID',
  PRIMARY KEY (`acl_role_id`,`acl_privilege_id`),
  KEY `acl_role_id` (`acl_role_id`),
  KEY `acl_privilege_id` (`acl_privilege_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='ACL Role Privileges';


### data of table `acl_role_privilege` ###

insert into `acl_role_privilege` values ('1', '1');
insert into `acl_role_privilege` values ('1', '2');
insert into `acl_role_privilege` values ('1', '3');
insert into `acl_role_privilege` values ('1', '4');
insert into `acl_role_privilege` values ('1', '5');
insert into `acl_role_privilege` values ('1', '6');
insert into `acl_role_privilege` values ('1', '34');
insert into `acl_role_privilege` values ('1', '35');
insert into `acl_role_privilege` values ('1', '39');
insert into `acl_role_privilege` values ('1', '48');
insert into `acl_role_privilege` values ('1', '49');
insert into `acl_role_privilege` values ('1', '52');
insert into `acl_role_privilege` values ('1', '54');
insert into `acl_role_privilege` values ('1', '61');
insert into `acl_role_privilege` values ('1', '62');
insert into `acl_role_privilege` values ('1', '63');
insert into `acl_role_privilege` values ('1', '64');
insert into `acl_role_privilege` values ('1', '68');
insert into `acl_role_privilege` values ('1', '74');
insert into `acl_role_privilege` values ('1', '85');
insert into `acl_role_privilege` values ('1', '89');
insert into `acl_role_privilege` values ('1', '91');
insert into `acl_role_privilege` values ('1', '92');
insert into `acl_role_privilege` values ('1', '94');
insert into `acl_role_privilege` values ('1', '95');
insert into `acl_role_privilege` values ('1', '96');
insert into `acl_role_privilege` values ('1', '97');
insert into `acl_role_privilege` values ('2', '9');
insert into `acl_role_privilege` values ('2', '10');
insert into `acl_role_privilege` values ('2', '11');
insert into `acl_role_privilege` values ('2', '13');
insert into `acl_role_privilege` values ('2', '14');
insert into `acl_role_privilege` values ('2', '15');
insert into `acl_role_privilege` values ('2', '24');
insert into `acl_role_privilege` values ('3', '41');
insert into `acl_role_privilege` values ('3', '42');
insert into `acl_role_privilege` values ('3', '43');
insert into `acl_role_privilege` values ('3', '44');
insert into `acl_role_privilege` values ('3', '46');
insert into `acl_role_privilege` values ('3', '47');
insert into `acl_role_privilege` values ('3', '51');
insert into `acl_role_privilege` values ('3', '53');
insert into `acl_role_privilege` values ('3', '55');
insert into `acl_role_privilege` values ('3', '56');
insert into `acl_role_privilege` values ('3', '57');
insert into `acl_role_privilege` values ('3', '59');
insert into `acl_role_privilege` values ('3', '60');
insert into `acl_role_privilege` values ('3', '65');
insert into `acl_role_privilege` values ('3', '66');
insert into `acl_role_privilege` values ('3', '67');
insert into `acl_role_privilege` values ('3', '69');
insert into `acl_role_privilege` values ('3', '70');
insert into `acl_role_privilege` values ('3', '72');
insert into `acl_role_privilege` values ('3', '75');
insert into `acl_role_privilege` values ('3', '76');
insert into `acl_role_privilege` values ('3', '77');
insert into `acl_role_privilege` values ('3', '78');
insert into `acl_role_privilege` values ('3', '79');
insert into `acl_role_privilege` values ('3', '80');
insert into `acl_role_privilege` values ('3', '88');
insert into `acl_role_privilege` values ('3', '93');
insert into `acl_role_privilege` values ('4', '40');
insert into `acl_role_privilege` values ('4', '45');
insert into `acl_role_privilege` values ('4', '47');
insert into `acl_role_privilege` values ('4', '51');
insert into `acl_role_privilege` values ('5', '58');
insert into `acl_role_privilege` values ('6', '55');
insert into `acl_role_privilege` values ('6', '56');
insert into `acl_role_privilege` values ('6', '57');
insert into `acl_role_privilege` values ('6', '58');
insert into `acl_role_privilege` values ('6', '90');
insert into `acl_role_privilege` values ('7', '73');
insert into `acl_role_privilege` values ('7', '80');
insert into `acl_role_privilege` values ('7', '82');
insert into `acl_role_privilege` values ('8', '73');
insert into `acl_role_privilege` values ('8', '80');
insert into `acl_role_privilege` values ('8', '83');
insert into `acl_role_privilege` values ('9', '73');
insert into `acl_role_privilege` values ('9', '80');
insert into `acl_role_privilege` values ('9', '84');
insert into `acl_role_privilege` values ('10', '87');
insert into `acl_role_privilege` values ('11', '53');
insert into `acl_role_privilege` values ('11', '55');
insert into `acl_role_privilege` values ('11', '56');
insert into `acl_role_privilege` values ('11', '57');
insert into `acl_role_privilege` values ('11', '58');
insert into `acl_role_privilege` values ('11', '59');
insert into `acl_role_privilege` values ('11', '60');
insert into `acl_role_privilege` values ('11', '65');
insert into `acl_role_privilege` values ('11', '66');
insert into `acl_role_privilege` values ('11', '67');
insert into `acl_role_privilege` values ('11', '69');
insert into `acl_role_privilege` values ('11', '70');
insert into `acl_role_privilege` values ('11', '88');
insert into `acl_role_privilege` values ('11', '93');


### structure of table `ea_aduan` ###

DROP TABLE IF EXISTS `ea_aduan`;

CREATE TABLE `ea_aduan` (
  `aduan_id` int(10) NOT NULL AUTO_INCREMENT,
  `aduan_bpm` smallint(1) NOT NULL,
  `aduan_kategorimasalah` varchar(2) NOT NULL,
  `aduan_lokasi` varchar(3) NOT NULL,
  `aduan_ringkasan` varchar(255) NOT NULL,
  `aduan_hadpelulus` varchar(200) DEFAULT NULL,
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
  `staf_user` varchar(200) DEFAULT NULL,
  `staf_date` datetime DEFAULT NULL,
  `insert_by` varchar(50) NOT NULL,
  `insert_date` datetime NOT NULL,
  `update_by` varchar(50) DEFAULT NULL,
  `update_date` datetime DEFAULT NULL,
  `status` varchar(3) NOT NULL,
  PRIMARY KEY (`aduan_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 AUTO_INCREMENT=6;


### data of table `ea_aduan` ###

insert into `ea_aduan` values ('1', '1', '2', '1', 'adsdsd', '4545', '2014-03-12', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, 'yusri.harun@gmail.com', '2014-03-14 10:14:02', null, null, '10');
insert into `ea_aduan` values ('2', '0', '5', '1', 'aaaaaaaaaaaaaaa', '20000', '2014-04-16', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, 'yusri.harun@gmail.com', '2014-04-16 14:47:01', null, null, '10');
insert into `ea_aduan` values ('3', '2', '2', '2', 'dfdffdfd', '', '2014-04-16', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, 'yusri.harun@gmail.com', '2014-04-16 14:49:38', null, null, '10');
insert into `ea_aduan` values ('4', '2', '2', '2', 'dfdffdfd', '', '2014-04-16', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, 'yusri.harun@gmail.com', '2014-04-16 14:52:23', null, null, '10');
insert into `ea_aduan` values ('5', '1', '3', '1', 'TAKTAU', '', '2014-04-16', null, '1', 'gfhgfh', 'yusri.harun@gmail.com', '2014-04-17 14:29:59', '1', '2', '1', 'yusri.harun@gmail.com', 'xxx', 'yusri.harun@gmail.com', '2014-04-23 09:39:33', '3', 'Since file uploads are done to the folder APPLICATION_PATH/uploads, the application tries to create this folder if it does not exists. For this reason APPLICATION_PATH should be writable, or uploads folder created manually with necessary rights. The application also requires \'uploadprogress\' PECL package since it uses \'uploadprogress_get_info\' function for getting the information about upload progress.', 'yusri.harun@gmail.com', '2014-04-23 11:48:13', 'achik.amiez@gmail.com', '2014-04-16 20:15:15', null, null, '33');


### structure of table `ea_bahagian` ###

DROP TABLE IF EXISTS `ea_bahagian`;

CREATE TABLE `ea_bahagian` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `desc` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1 AUTO_INCREMENT=11;


### data of table `ea_bahagian` ###

insert into `ea_bahagian` values ('1', 'Bahagian Pengurusan Maklumat');
insert into `ea_bahagian` values ('2', 'Bahagian Pencen');
insert into `ea_bahagian` values ('3', 'Bahagian Kewangan dan Akaun');
insert into `ea_bahagian` values ('4', 'Bahagian Kebajikan');
insert into `ea_bahagian` values ('5', 'Bahagian Khidmat Pengurusan');
insert into `ea_bahagian` values ('6', 'Bahagian Dasar');
insert into `ea_bahagian` values ('7', 'Bahagian Kerjaya dan Sosioekonomi');
insert into `ea_bahagian` values ('8', 'Pejabat Ketua Pengarah');
insert into `ea_bahagian` values ('9', 'Pejabat Timbalan Ketua Pengarah');
insert into `ea_bahagian` values ('10', 'Cawangan Selangor');


### structure of table `ea_bpm` ###

DROP TABLE IF EXISTS `ea_bpm`;

CREATE TABLE `ea_bpm` (
  `bpm_id` int(10) NOT NULL AUTO_INCREMENT,
  `bpm_name` varchar(200) NOT NULL,
  PRIMARY KEY (`bpm_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 AUTO_INCREMENT=3;


### data of table `ea_bpm` ###

insert into `ea_bpm` values ('1', 'Sistem dan Aplikasi');
insert into `ea_bpm` values ('2', 'Operasi dan Keselamatan Rangkaian');


### structure of table `ea_kategoriMasalah` ###

DROP TABLE IF EXISTS `ea_kategoriMasalah`;

CREATE TABLE `ea_kategoriMasalah` (
  `km_id` int(10) NOT NULL AUTO_INCREMENT,
  `km_desc` varchar(255) NOT NULL,
  `bpm_id` int(3) NOT NULL,
  PRIMARY KEY (`km_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 AUTO_INCREMENT=7;


### data of table `ea_kategoriMasalah` ###

insert into `ea_kategoriMasalah` values ('1', 'Perkakasan', '2');
insert into `ea_kategoriMasalah` values ('2', 'Rangkaian', '2');
insert into `ea_kategoriMasalah` values ('3', 'Aplikasi/Sistem', '1');
insert into `ea_kategoriMasalah` values ('4', 'Perisian', '2');
insert into `ea_kategoriMasalah` values ('5', 'Pengurusan ID', '1');
insert into `ea_kategoriMasalah` values ('6', 'Lain-lain', '0');


### structure of table `ea_kelulusan` ###

DROP TABLE IF EXISTS `ea_kelulusan`;

CREATE TABLE `ea_kelulusan` (
  `kelulusan_id` smallint(3) NOT NULL,
  `kelulusan_desc` varchar(100) NOT NULL,
  PRIMARY KEY (`kelulusan_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


### data of table `ea_kelulusan` ###

insert into `ea_kelulusan` values ('0', 'Tidah Lulus');
insert into `ea_kelulusan` values ('1', 'Lulus');


### structure of table `ea_pengesahan` ###

DROP TABLE IF EXISTS `ea_pengesahan`;

CREATE TABLE `ea_pengesahan` (
  `pengesahan_id` smallint(3) NOT NULL,
  `pengesahan_desc` varchar(100) NOT NULL,
  PRIMARY KEY (`pengesahan_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


### data of table `ea_pengesahan` ###

insert into `ea_pengesahan` values ('0', 'Tidah Sah');
insert into `ea_pengesahan` values ('1', 'Disahkan');


### structure of table `ea_statusmasalah` ###

DROP TABLE IF EXISTS `ea_statusmasalah`;

CREATE TABLE `ea_statusmasalah` (
  `status_id` int(3) NOT NULL AUTO_INCREMENT,
  `status_desc` varchar(100) NOT NULL,
  PRIMARY KEY (`status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 AUTO_INCREMENT=4;


### data of table `ea_statusmasalah` ###

insert into `ea_statusmasalah` values ('1', 'Selesai');
insert into `ea_statusmasalah` values ('2', 'Tangguh');
insert into `ea_statusmasalah` values ('3', 'Tidak Dapat Diselesaikan');


### structure of table `ea_tahap` ###

DROP TABLE IF EXISTS `ea_tahap`;

CREATE TABLE `ea_tahap` (
  `tahap_id` int(3) NOT NULL AUTO_INCREMENT,
  `tahap_desc` varchar(100) NOT NULL,
  PRIMARY KEY (`tahap_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 AUTO_INCREMENT=4;


### data of table `ea_tahap` ###

insert into `ea_tahap` values ('1', 'Rendah');
insert into `ea_tahap` values ('2', 'Sederhana');
insert into `ea_tahap` values ('3', 'Tinggi');


### structure of table `ea_unit` ###

DROP TABLE IF EXISTS `ea_unit`;

CREATE TABLE `ea_unit` (
  `unit_id` int(10) NOT NULL AUTO_INCREMENT,
  `unit_desc` varchar(255) NOT NULL,
  `dept_id` int(3) DEFAULT NULL,
  PRIMARY KEY (`unit_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 AUTO_INCREMENT=3;


### data of table `ea_unit` ###

insert into `ea_unit` values ('1', 'Unit Bayaran', '3');
insert into `ea_unit` values ('2', 'Unit Akaun', '3');


### structure of table `sys_bahasa` ###

DROP TABLE IF EXISTS `sys_bahasa`;

CREATE TABLE `sys_bahasa` (
  `bahasa_id` int(11) NOT NULL AUTO_INCREMENT,
  `bahasa_name` varchar(20) NOT NULL,
  `bahasa_aktif` int(11) NOT NULL,
  PRIMARY KEY (`bahasa_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1 AUTO_INCREMENT=17;


### data of table `sys_bahasa` ###

insert into `sys_bahasa` values ('1', 'Bahasa Malaysia', '1');
insert into `sys_bahasa` values ('2', 'Bahasa Inggeris', '1');
insert into `sys_bahasa` values ('3', 'Mandarin', '1');
insert into `sys_bahasa` values ('4', 'Swiss', '1');
insert into `sys_bahasa` values ('5', 'Belanda', '1');
insert into `sys_bahasa` values ('6', 'Tamil', '1');
insert into `sys_bahasa` values ('7', 'Jepun', '1');
insert into `sys_bahasa` values ('8', 'Korea', '1');
insert into `sys_bahasa` values ('9', 'Itali', '1');
insert into `sys_bahasa` values ('10', 'Arab', '1');
insert into `sys_bahasa` values ('11', 'Perancis', '1');
insert into `sys_bahasa` values ('12', 'Sepanyol', '1');
insert into `sys_bahasa` values ('13', 'Jerman', '1');
insert into `sys_bahasa` values ('14', 'Finnish', '1');
insert into `sys_bahasa` values ('15', 'Rusia', '1');
insert into `sys_bahasa` values ('16', 'Lain-lain', '1');


### structure of table `sys_contact` ###

DROP TABLE IF EXISTS `sys_contact`;

CREATE TABLE `sys_contact` (
  `contact_id` int(11) NOT NULL AUTO_INCREMENT,
  `contact_name` varchar(50) NOT NULL COMMENT 'ingin dihubungi melalui',
  PRIMARY KEY (`contact_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 AUTO_INCREMENT=4;


### data of table `sys_contact` ###

insert into `sys_contact` values ('1', 'Melalui Sistem SPIP');
insert into `sys_contact` values ('2', 'Emel');
insert into `sys_contact` values ('3', 'SMS');


### structure of table `sys_district` ###

DROP TABLE IF EXISTS `sys_district`;

CREATE TABLE `sys_district` (
  `district_id` int(11) NOT NULL AUTO_INCREMENT,
  `sta_id` int(11) NOT NULL,
  `district_name` varchar(50) NOT NULL,
  `district_status` int(11) NOT NULL,
  PRIMARY KEY (`district_id`)
) ENGINE=InnoDB AUTO_INCREMENT=303 DEFAULT CHARSET=latin1 AUTO_INCREMENT=303;


### data of table `sys_district` ###

insert into `sys_district` values ('1', '1', 'BATU PAHAT', '1');
insert into `sys_district` values ('2', '1', 'JOHOR BAHRU', '1');
insert into `sys_district` values ('3', '1', 'KLUANG', '1');
insert into `sys_district` values ('4', '1', 'KOTA TINGGI', '1');
insert into `sys_district` values ('5', '1', 'MERSING', '1');
insert into `sys_district` values ('6', '1', 'MUAR', '1');
insert into `sys_district` values ('7', '1', 'PONTIAN', '1');
insert into `sys_district` values ('8', '1', 'SEGAMAT', '1');
insert into `sys_district` values ('9', '1', 'KULAI JAYA', '1');
insert into `sys_district` values ('10', '1', 'LEDANG', '1');
insert into `sys_district` values ('11', '1', 'YONG PENG', '1');
insert into `sys_district` values ('12', '1', 'SENAI', '1');
insert into `sys_district` values ('13', '1', 'PASIR GUDANG', '1');
insert into `sys_district` values ('14', '1', 'SKUDAI', '1');
insert into `sys_district` values ('15', '1', 'TANJUNG PUTERI', '1');
insert into `sys_district` values ('16', '1', 'MASAI', '1');
insert into `sys_district` values ('17', '1', 'TANGKAK', '1');
insert into `sys_district` values ('18', '1', 'KULAI', '1');
insert into `sys_district` values ('19', '1', 'NUSAJAYA', '1');
insert into `sys_district` values ('20', '1', 'TAMPOI', '1');
insert into `sys_district` values ('21', '1', 'ULU TIRAM', '1');
insert into `sys_district` values ('22', '1', 'GELANG PATAH', '1');
insert into `sys_district` values ('23', '1', 'TEBRAU', '1');
insert into `sys_district` values ('24', '1', 'SIMPANG RENGGAM', '1');
insert into `sys_district` values ('25', '1', 'PENGERANG', '1');
insert into `sys_district` values ('26', '1', 'PEKAN NANAS', '1');
insert into `sys_district` values ('27', '2', 'BALING', '1');
insert into `sys_district` values ('28', '2', 'BANDAR BAHARU', '1');
insert into `sys_district` values ('29', '2', 'KOTA SETAR', '1');
insert into `sys_district` values ('30', '2', 'KUALA MUDA', '1');
insert into `sys_district` values ('31', '2', 'KUBANG PASU', '1');
insert into `sys_district` values ('32', '2', 'KULIM', '1');
insert into `sys_district` values ('33', '2', 'LANGKAWI', '1');
insert into `sys_district` values ('34', '2', 'PADANG TERAP', '1');
insert into `sys_district` values ('35', '2', 'PENDANG', '1');
insert into `sys_district` values ('36', '2', 'POKOK SENA', '1');
insert into `sys_district` values ('37', '2', 'SIK', '1');
insert into `sys_district` values ('38', '2', 'YAN', '1');
insert into `sys_district` values ('39', '2', 'ALOR SETAR', '1');
insert into `sys_district` values ('40', '2', 'SUNGAI PETANI', '1');
insert into `sys_district` values ('41', '2', 'BEDONG', '1');
insert into `sys_district` values ('42', '2', 'KUALA NERANG', '1');
insert into `sys_district` values ('43', '2', 'JITRA', '1');
insert into `sys_district` values ('44', '2', 'SINTOK', '1');
insert into `sys_district` values ('45', '2', 'GURUN', '1');
insert into `sys_district` values ('46', '2', 'KUAH', '1');
insert into `sys_district` values ('47', '2', 'CHANGLOON', '1');
insert into `sys_district` values ('48', '2', 'BUKIT KAYU HITAM', '1');
insert into `sys_district` values ('49', '2', 'KEPALA BATAS', '1');
insert into `sys_district` values ('50', '2', 'KUALA KEDAH', '1');
insert into `sys_district` values ('51', '2', 'LUNAS', '1');
insert into `sys_district` values ('52', '2', 'KARANGAN', '1');
insert into `sys_district` values ('53', '2', 'NAKA', '1');
insert into `sys_district` values ('54', '3', 'BACHOK', '1');
insert into `sys_district` values ('55', '3', 'GUA MUSANG', '1');
insert into `sys_district` values ('56', '3', 'JELI', '1');
insert into `sys_district` values ('57', '0', 'KUALA KRAI', '1');
insert into `sys_district` values ('58', '3', 'KUALA KRAI', '1');
insert into `sys_district` values ('59', '3', 'MACHANG', '1');
insert into `sys_district` values ('60', '3', 'PASIR MAS', '1');
insert into `sys_district` values ('61', '3', 'PASIR PUTEH', '1');
insert into `sys_district` values ('62', '3', 'TANAH MERAH', '1');
insert into `sys_district` values ('63', '3', 'TUMPAT', '1');
insert into `sys_district` values ('64', '3', 'KOTA BHARU', '1');
insert into `sys_district` values ('65', '3', 'RANTAU PANJANG', '1');
insert into `sys_district` values ('66', '4', 'ALOR GAJAH', '1');
insert into `sys_district` values ('67', '4', 'MELAKA TENGAH', '1');
insert into `sys_district` values ('68', '4', 'JASIN', '1');
insert into `sys_district` values ('69', '4', 'BANDAR HILIR', '1');
insert into `sys_district` values ('70', '4', 'TANJUNG BIDARA', '1');
insert into `sys_district` values ('71', '4', 'AYER KEROH', '1');
insert into `sys_district` values ('72', '4', 'BALAI PANJANG', '1');
insert into `sys_district` values ('73', '4', 'PERINGGIT', '1');
insert into `sys_district` values ('74', '4', 'MASJID TANAH', '1');
insert into `sys_district` values ('75', '4', 'BACHANG', '1');
insert into `sys_district` values ('76', '4', 'DURIAN TUNGGAL', '1');
insert into `sys_district` values ('77', '4', 'SEMABOK', '1');
insert into `sys_district` values ('78', '4', 'SUNGAI UDANG', '1');
insert into `sys_district` values ('79', '4', 'BATU BERENDAM', '1');
insert into `sys_district` values ('80', '4', 'MERLIMAU', '1');
insert into `sys_district` values ('81', '5', 'JELEBU', '1');
insert into `sys_district` values ('82', '5', 'JEMPOL', '1');
insert into `sys_district` values ('83', '5', 'KUALA PILAH', '1');
insert into `sys_district` values ('84', '5', 'PORT DICKSON', '1');
insert into `sys_district` values ('85', '5', 'REMBAU', '1');
insert into `sys_district` values ('86', '5', 'SEREMBAN', '1');
insert into `sys_district` values ('87', '5', 'TAMPIN', '1');
insert into `sys_district` values ('88', '5', 'BANDAR BARU NILAI', '1');
insert into `sys_district` values ('89', '5', 'BAHAU', '1');
insert into `sys_district` values ('90', '5', 'NILAI', '1');
insert into `sys_district` values ('91', '5', 'SENAWANG', '1');
insert into `sys_district` values ('92', '5', 'GEMAS', '1');
insert into `sys_district` values ('93', '5', 'GEMENCHEH', '1');
insert into `sys_district` values ('94', '6', 'BENTONG', '1');
insert into `sys_district` values ('95', '6', 'BERA', '1');
insert into `sys_district` values ('96', '6', 'CAMERON HIGHLAND', '1');
insert into `sys_district` values ('97', '6', 'JERANTUT', '1');
insert into `sys_district` values ('98', '6', 'KUANTAN', '1');
insert into `sys_district` values ('99', '6', 'LIPIS', '1');
insert into `sys_district` values ('100', '6', 'MARAN', '1');
insert into `sys_district` values ('101', '6', 'PEKAN', '1');
insert into `sys_district` values ('102', '6', 'RAUB', '1');
insert into `sys_district` values ('103', '6', 'ROMPIN', '1');
insert into `sys_district` values ('104', '6', 'TEMERLOH', '1');
insert into `sys_district` values ('105', '6', 'GENTING HIGHLANDS', '1');
insert into `sys_district` values ('106', '6', 'KUALA ROMPIN', '1');
insert into `sys_district` values ('107', '6', 'MENTAKAB', '1');
insert into `sys_district` values ('108', '6', 'FRASER HILL', '1');
insert into `sys_district` values ('109', '6', 'KUALA LIPIS', '1');
insert into `sys_district` values ('110', '6', 'JENGKA', '1');
insert into `sys_district` values ('111', '6', 'TRIANG', '1');
insert into `sys_district` values ('112', '6', 'CHERATING', '1');
insert into `sys_district` values ('113', '6', 'PULAU TIOMAN', '1');
insert into `sys_district` values ('114', '6', 'BENTA', '1');
insert into `sys_district` values ('115', '6', 'KEMAYAN', '1');
insert into `sys_district` values ('116', '7', 'TIMUR LAUT', '1');
insert into `sys_district` values ('117', '7', 'BARAT DAYA', '1');
insert into `sys_district` values ('118', '7', 'SEBERANG PERAI UTARA', '1');
insert into `sys_district` values ('119', '7', 'SEBERANG PERAI TENGAH', '1');
insert into `sys_district` values ('120', '7', 'SEBERANG PERAI SELATAN', '1');
insert into `sys_district` values ('121', '7', 'GEORGETOWN', '1');
insert into `sys_district` values ('122', '7', 'BATU FERRINGHI', '1');
insert into `sys_district` values ('123', '7', 'TELUK BAHANG', '1');
insert into `sys_district` values ('124', '7', 'BAYAN LEPAS', '1');
insert into `sys_district` values ('125', '7', 'TANJUNG BUNGAH', '1');
insert into `sys_district` values ('126', '7', 'SEBERANG JAYA', '1');
insert into `sys_district` values ('127', '7', 'TANJUNG TOKONG', '1');
insert into `sys_district` values ('128', '7', 'BUKIT MERTAJAM', '1');
insert into `sys_district` values ('129', '7', 'BUTTERWORTH', '1');
insert into `sys_district` values ('130', '7', 'BAYAN BARU', '1');
insert into `sys_district` values ('131', '7', 'BUKIT BENDERA', '1');
insert into `sys_district` values ('132', '7', 'PENGKALAN WELD', '1');
insert into `sys_district` values ('133', '7', 'PRAI', '1');
insert into `sys_district` values ('134', '7', 'GELUGOR', '1');
insert into `sys_district` values ('135', '7', 'SUNGAI NIBONG', '1');
insert into `sys_district` values ('136', '7', 'KEPALA BATAS', '1');
insert into `sys_district` values ('137', '7', 'SUNGAI DUA', '1');
insert into `sys_district` values ('138', '7', 'BALIK PULAU', '1');
insert into `sys_district` values ('139', '8', 'BATANG PADANG', '1');
insert into `sys_district` values ('140', '8', 'HILIR PERAK', '1');
insert into `sys_district` values ('141', '8', 'HULU PERAK', '1');
insert into `sys_district` values ('142', '8', 'KERIAN', '1');
insert into `sys_district` values ('143', '8', 'KINTA', '1');
insert into `sys_district` values ('144', '8', 'KUALA KANGSAR', '1');
insert into `sys_district` values ('145', '8', 'LARUT', '1');
insert into `sys_district` values ('146', '8', 'MATANG', '1');
insert into `sys_district` values ('147', '8', 'SELAMA', '1');
insert into `sys_district` values ('148', '8', 'MANJUNG', '1');
insert into `sys_district` values ('149', '8', 'PERAK TENGAH', '1');
insert into `sys_district` values ('150', '8', 'PULAU PANGKOR', '1');
insert into `sys_district` values ('151', '8', 'IPOH', '1');
insert into `sys_district` values ('152', '8', 'LUMUT', '1');
insert into `sys_district` values ('153', '8', 'SEMANGGOL', '1');
insert into `sys_district` values ('154', '8', 'TAIPING', '1');
insert into `sys_district` values ('155', '8', 'GERIK', '1');
insert into `sys_district` values ('156', '8', 'PARIT BUNTAR', '1');
insert into `sys_district` values ('157', '8', 'SETIAWAN', '1');
insert into `sys_district` values ('158', '8', 'TELUK INTAN', '1');
insert into `sys_district` values ('159', '8', 'KAMPAR', '1');
insert into `sys_district` values ('160', '8', 'TANJUNG MALIM', '1');
insert into `sys_district` values ('161', '8', 'TAPAH', '1');
insert into `sys_district` values ('162', '8', 'BIDOR', '1');
insert into `sys_district` values ('163', '8', 'SLIM RIVER', '1');
insert into `sys_district` values ('164', '8', 'BAGAN SERAI', '1');
insert into `sys_district` values ('165', '8', 'LENGGONG', '1');
insert into `sys_district` values ('166', '8', 'HUTAN MELINTANG', '1');
insert into `sys_district` values ('167', '8', 'PENGKALAN HULU', '1');
insert into `sys_district` values ('168', '8', 'BATU GAJAH', '1');
insert into `sys_district` values ('169', '8', 'KAMUNTING', '1');
insert into `sys_district` values ('170', '8', 'PANTAI REMIS', '1');
insert into `sys_district` values ('171', '8', 'TRONOH', '1');
insert into `sys_district` values ('172', '8', 'GOPENG', '1');
insert into `sys_district` values ('173', '8', 'BOTA', '1');
insert into `sys_district` values ('174', '9', 'ARAU', '1');
insert into `sys_district` values ('175', '9', 'KAKI BUKIT', '1');
insert into `sys_district` values ('176', '9', 'KANGAR', '1');
insert into `sys_district` values ('177', '9', 'KUALA PERLIS', '1');
insert into `sys_district` values ('178', '9', 'PADANG BESAR', '1');
insert into `sys_district` values ('179', '9', 'SIMPANG EMPAT', '1');
insert into `sys_district` values ('180', '10', 'GOMBAK', '1');
insert into `sys_district` values ('181', '10', 'HULU LANGAT', '1');
insert into `sys_district` values ('182', '10', 'HULU SELANGOR', '1');
insert into `sys_district` values ('183', '10', 'KLANG', '1');
insert into `sys_district` values ('184', '10', 'KUALA LANGAT', '1');
insert into `sys_district` values ('185', '10', 'KUALA SELANGOR', '1');
insert into `sys_district` values ('186', '10', 'PETALING', '1');
insert into `sys_district` values ('187', '10', 'SABAK BERNAM', '1');
insert into `sys_district` values ('188', '10', 'SEPANG', '1');
insert into `sys_district` values ('189', '10', 'PETALING JAYA', '1');
insert into `sys_district` values ('190', '10', 'SUBANG', '1');
insert into `sys_district` values ('191', '10', 'SUBANG JAYA', '1');
insert into `sys_district` values ('192', '10', 'BANGI', '1');
insert into `sys_district` values ('193', '10', 'SHAH ALAM', '1');
insert into `sys_district` values ('194', '10', 'SERI KEMBANGAN', '1');
insert into `sys_district` values ('195', '10', 'CYBERJAYA', '1');
insert into `sys_district` values ('196', '10', 'KAJANG', '1');
insert into `sys_district` values ('197', '10', 'AMPANG', '1');
insert into `sys_district` values ('198', '10', 'PELABUHAN KLANG', '1');
insert into `sys_district` values ('199', '10', 'PUCHONG', '1');
insert into `sys_district` values ('200', '10', 'BATU CAVES', '1');
insert into `sys_district` values ('201', '10', 'RAWANG', '1');
insert into `sys_district` values ('202', '10', 'SUNGAI BULOH', '1');
insert into `sys_district` values ('203', '10', 'BANTING', '1');
insert into `sys_district` values ('204', '10', 'PULAU KETAM', '1');
insert into `sys_district` values ('205', '10', 'ULU KLANG', '1');
insert into `sys_district` values ('206', '10', 'BANDAR BARU BANGI', '1');
insert into `sys_district` values ('207', '10', 'KUALA KUBU BARU', '1');
insert into `sys_district` values ('208', '10', 'KELANA JAYA', '1');
insert into `sys_district` values ('209', '10', 'SELAYANG', '1');
insert into `sys_district` values ('210', '10', 'SEMENYIH', '1');
insert into `sys_district` values ('211', '10', 'SERENDAH', '1');
insert into `sys_district` values ('212', '10', 'DENGKIL', '1');
insert into `sys_district` values ('213', '10', 'SEKINCHAN', '1');
insert into `sys_district` values ('214', '10', 'KAPAR', '1');
insert into `sys_district` values ('215', '10', 'BANDAR PUTRA PERMAI', '1');
insert into `sys_district` values ('216', '10', 'KOTA DAMANSARA', '1');
insert into `sys_district` values ('217', '10', 'BATANG BERJUNTAI', '1');
insert into `sys_district` values ('218', '10', 'BANDAR SUNWAY', '1');
insert into `sys_district` values ('219', '10', 'BATANG KALI', '1');
insert into `sys_district` values ('220', '11', 'BESUT', '1');
insert into `sys_district` values ('221', '11', 'DUNGUN', '1');
insert into `sys_district` values ('222', '11', 'HULU TERENGGANU', '1');
insert into `sys_district` values ('223', '11', 'KEMAMAN', '1');
insert into `sys_district` values ('224', '11', 'KUALA TERENGGANU', '1');
insert into `sys_district` values ('225', '11', 'MARANG', '1');
insert into `sys_district` values ('226', '11', 'SETIU', '1');
insert into `sys_district` values ('227', '11', 'PAKA', '1');
insert into `sys_district` values ('228', '11', 'KERTEH', '1');
insert into `sys_district` values ('229', '11', 'KUALA BESUT', '1');
insert into `sys_district` values ('230', '11', 'JERTEH', '1');
insert into `sys_district` values ('231', '11', 'KUALA BERANG', '1');
insert into `sys_district` values ('232', '12', 'BEAUFORT', '1');
insert into `sys_district` values ('233', '12', 'KENINGAU', '1');
insert into `sys_district` values ('234', '12', 'KUALA PENYU', '1');
insert into `sys_district` values ('235', '12', 'NABAWAN', '1');
insert into `sys_district` values ('236', '12', 'SIPITANG', '1');
insert into `sys_district` values ('237', '12', 'TAMBUNAN', '1');
insert into `sys_district` values ('238', '12', 'TENOM', '1');
insert into `sys_district` values ('239', '12', 'KOTA MARUDU', '1');
insert into `sys_district` values ('240', '12', 'KUDAT', '1');
insert into `sys_district` values ('241', '12', 'PITAS', '1');
insert into `sys_district` values ('242', '12', 'BELURAN', '1');
insert into `sys_district` values ('243', '12', 'KINABATANGAN', '1');
insert into `sys_district` values ('244', '12', 'SANDAKAN', '1');
insert into `sys_district` values ('245', '12', 'TONGOD', '1');
insert into `sys_district` values ('246', '12', 'KUNAK', '1');
insert into `sys_district` values ('247', '12', 'LAHAD DATU', '1');
insert into `sys_district` values ('248', '12', 'SEMPORNA', '1');
insert into `sys_district` values ('249', '12', 'TAWAU', '1');
insert into `sys_district` values ('250', '12', 'KOTA BELUD', '1');
insert into `sys_district` values ('251', '12', 'KOTA KINABALU', '1');
insert into `sys_district` values ('252', '12', 'PAPAR', '1');
insert into `sys_district` values ('253', '12', 'PENAMPANG', '1');
insert into `sys_district` values ('254', '12', 'PUTATAN', '1');
insert into `sys_district` values ('255', '12', 'RANAU', '1');
insert into `sys_district` values ('256', '12', 'TUARAN', '1');
insert into `sys_district` values ('257', '12', 'KUNDASANG', '1');
insert into `sys_district` values ('258', '12', 'TANJUNG ARU', '1');
insert into `sys_district` values ('259', '12', 'LIKAS', '1');
insert into `sys_district` values ('260', '12', 'MENGGATAL', '1');
insert into `sys_district` values ('261', '12', 'LIDO', '1');
insert into `sys_district` values ('262', '13', 'BETONG', '1');
insert into `sys_district` values ('263', '13', 'SARATOK', '1');
insert into `sys_district` values ('264', '13', 'BINTULU', '1');
insert into `sys_district` values ('265', '13', 'TATAU', '1');
insert into `sys_district` values ('266', '13', 'BELAGA', '1');
insert into `sys_district` values ('267', '13', 'KAPIT', '1');
insert into `sys_district` values ('268', '13', 'SONG', '1');
insert into `sys_district` values ('269', '13', 'BAU', '1');
insert into `sys_district` values ('270', '13', 'KUCHING', '1');
insert into `sys_district` values ('271', '13', 'LUNDU', '1');
insert into `sys_district` values ('272', '13', 'LAWAS', '1');
insert into `sys_district` values ('273', '13', 'LIMBANG', '1');
insert into `sys_district` values ('274', '13', 'MARUDI', '1');
insert into `sys_district` values ('275', '13', 'MIRI', '1');
insert into `sys_district` values ('276', '13', 'DALAT', '1');
insert into `sys_district` values ('277', '13', 'DARO', '1');
insert into `sys_district` values ('278', '13', 'MATU', '1');
insert into `sys_district` values ('279', '13', 'MUKAH', '1');
insert into `sys_district` values ('280', '13', 'ASAJAYA', '1');
insert into `sys_district` values ('281', '13', 'SAMARAHAN', '1');
insert into `sys_district` values ('282', '13', 'SERIAN', '1');
insert into `sys_district` values ('283', '13', 'SIMUNJAN', '1');
insert into `sys_district` values ('284', '13', 'JULAU', '1');
insert into `sys_district` values ('285', '13', 'MERADONG', '1');
insert into `sys_district` values ('286', '13', 'SARIKEI', '1');
insert into `sys_district` values ('287', '13', 'KANOWIT', '1');
insert into `sys_district` values ('288', '13', 'SIBU', '1');
insert into `sys_district` values ('289', '13', 'LUBOK ANTU', '1');
insert into `sys_district` values ('290', '13', 'SRI AMAN', '1');
insert into `sys_district` values ('291', '13', 'BINTANGOR', '1');
insert into `sys_district` values ('292', '13', 'BARAM', '1');
insert into `sys_district` values ('293', '13', 'SEMATAN', '1');
insert into `sys_district` values ('294', '13', 'BATU NIAH', '1');
insert into `sys_district` values ('295', '14', 'KUALA LUMPUR', '1');
insert into `sys_district` values ('296', '14', 'CHERAS', '1');
insert into `sys_district` values ('297', '14', 'SENTUL', '1');
insert into `sys_district` values ('298', '14', 'KEPONG', '1');
insert into `sys_district` values ('299', '14', 'BANGSAR', '1');
insert into `sys_district` values ('300', '14', 'SETAPAK', '1');
insert into `sys_district` values ('301', '15', 'LABUAN', '1');
insert into `sys_district` values ('302', '16', 'PUTRAJAYA', '1');


### structure of table `sys_education_level` ###

DROP TABLE IF EXISTS `sys_education_level`;

CREATE TABLE `sys_education_level` (
  `sys_edu_level_id` tinyint(1) NOT NULL AUTO_INCREMENT,
  `sys_edu_level_desc_bm` varchar(50) NOT NULL,
  `sys_edu_level_decs_bi` varchar(50) NOT NULL,
  `sys_edu_level_status` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`sys_edu_level_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1 AUTO_INCREMENT=10;


### data of table `sys_education_level` ###

insert into `sys_education_level` values ('1', 'Tiada Maklumat', 'No Info', '1');
insert into `sys_education_level` values ('2', 'Penilaian Menengah Rendah (PMR)', 'PMR', '1');
insert into `sys_education_level` values ('3', 'Sijil Pelajaran Malaysia (SPM)', 'SPM', '1');
insert into `sys_education_level` values ('4', 'Sijil', 'Certificate', '1');
insert into `sys_education_level` values ('5', 'Diploma', 'Diploma', '1');
insert into `sys_education_level` values ('6', 'Diploma Lanjutan', 'Higher Diploma', '1');
insert into `sys_education_level` values ('7', 'Ijazah Sarjana Muda', 'Bachelor Degree', '1');
insert into `sys_education_level` values ('8', 'Ijazah Sarjana', 'Master Degree', '1');
insert into `sys_education_level` values ('9', 'Doktor Falsafah (PhD)', 'Philosophy Doctor (PhD)', '1');


### structure of table `sys_gender` ###

DROP TABLE IF EXISTS `sys_gender`;

CREATE TABLE `sys_gender` (
  `gender_id` tinyint(2) NOT NULL AUTO_INCREMENT,
  `gender_desc_may` varchar(255) NOT NULL DEFAULT '',
  `gender_desc_eng` varchar(255) NOT NULL DEFAULT '',
  `gender_status` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`gender_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT AUTO_INCREMENT=4;


### data of table `sys_gender` ###

insert into `sys_gender` values ('1', 'Lelaki', 'Male', '1');
insert into `sys_gender` values ('2', 'Perempuan', 'Female', '1');
insert into `sys_gender` values ('3', 'Tiada Maklumat', 'No Data', '1');


### structure of table `sys_information_page` ###

DROP TABLE IF EXISTS `sys_information_page`;

CREATE TABLE `sys_information_page` (
  `ipage_id` int(1) NOT NULL,
  `ipage_name` varchar(100) NOT NULL,
  `ipage_desc` varchar(255) NOT NULL,
  `ipage_content` text,
  `ipage_edit_user` varchar(100) NOT NULL,
  `ipage_edit_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ipage_status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`ipage_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


### data of table `sys_information_page` ###

insert into `sys_information_page` values ('1', 'Halaman Daftar Masuk', 'Halaman daftar masuk', '<p align=\"left\"><strong>Selamat</strong> datang ke portal ePengembangan Jabatan Perikanan Malaysia. Laman ini menyediakan perkhidmatan program usahawan bimbingan untuk kumpulan sasaran di bawah naungan Jabatan Perikanan Malaysia.<br />\r\n<br />\r\nSistem ini merangkumi 4 program usahawan bimbingan iaitu :</p>\r\n<ul>\r\n    <li>Komuniti Pengurusan Sumber Perikanan (KPSP)</li>\r\n    <li>Projek Percubaan &amp; Demonstrasi (P&amp;D)</li>\r\n    <li>Usahawan Industri Asas Tani (UIAT)</li>\r\n    <li>\r\n    <div align=\"left\">Projek Inkubator Pemprosesan (PIP)</div>\r\n    </li>\r\n</ul>', 'administrator', '2009-06-10 14:43:58', '1');
insert into `sys_information_page` values ('2', 'Halaman Pengguna', 'Halaman pengguna', '<p align=\"left\">Selamat datang ke portal ePengembangan Jabatan Perikanan Malaysia. Laman ini menyediakan perkhidmatan program usahawan bimbingan untuk kumpulan sasaran di bawah naungan Jabatan Perikanan Malaysia.<br />\r\n<br />\r\nSistem ini merangkumi 4 program usahawan bimbingan iaitu :</p>\r\n<p>&nbsp;</p>\r\n<ul>\r\n    <li>Komuniti Pengurusan Sumber Perikanan (KPSP)</li>\r\n    <li>Projek Percubaan &amp; Demonstrasi (P&amp;D)</li>\r\n    <li>Usahawan Industri Asas Tani (UIAT)</li>\r\n    <li>\r\n    <div align=\"left\">Projek Inkubator Pemprosesan (PIP)</div>\r\n    </li>\r\n</ul>\r\n<p><img height=\"182\" width=\"200\" src=\"/userfiles/image/test/200px-AllHopeIsGoneAlbum.jpg\" alt=\"\" /></p>', 'administrator', '2009-06-02 15:10:00', '1');
insert into `sys_information_page` values ('5', 'Penafian', 'Laman penafian		  		  		  ', '<P align=left><SPAN style=\\\"FONT-SIZE: 12pt; FONT-FAMILY: Arial; mso-fareast-font-family: \\\'Times New Roman\\\'; mso-ansi-language: EN-US; mso-fareast-language: EN-US; mso-bidi-language: AR-SA\\\"><FONT size=2>Kerajaan Malaysia dan Jabatan Perikanan Malaysia tidak bertanggungjawab terhadap sebarang kerosakan atau kehilangan yang dialami kerana menggunakan maklumat dalam laman ini.</FONT></SPAN></P>', 'administrator', '2008-01-14 10:56:59', '1');
insert into `sys_information_page` values ('6', 'Dasar Privasi', 'Dasar Privasi', '<p line-height:=\"\" style=\"\"><b><span lang=\"MS\" mso-ansi-language:=\"\" style=\"\"><font size=\"2\">Privasi anda</font></span></b><span lang=\"MS\" mso-ansi-language:=\"\" style=\"\"><br />\r\n<font size=\"2\">Halaman ini menerangkan dasar privasi yang merangkumi penggunaan dan<br />\r\nperlindungan maklumat yang dikemukakan oleh pengunjung.</font></span><font size=\"2\"> </font></p>\r\n<p line-height:=\"\" style=\"\"><font size=\"2\"><span lang=\"MS\" mso-ansi-language:=\"\" style=\"\">Sekiranya anda membuat transaksi atau menghantar e-mel yang mengandungi<br />\r\nmaklumat peribadi, maklumat ini mungkin akan dikongsi bersama dengan agensi awam lain untuk membantu penyediaan perkhidmatan yang lebih berkesan dan efektif. Contohnya seperti di dalam menyelesaikan aduan yang memerlukan maklumbalas dari agensi-agensi lain.</span> </font></p>\r\n<p line-height:=\"\" style=\"\"><b><span lang=\"MS\" mso-ansi-language:=\"\" style=\"\"><font size=\"2\">Perlindungan Data</font></span></b><span lang=\"MS\" mso-ansi-language:=\"\" style=\"\"><br />\r\n<font size=\"2\">Teknologi terkini termasuk penyulitan data adalah digunakan untuk melindungi<br />\r\ndata yang dikemukakan dan pematuhan kepada standard keselamatan yang ketat adalah terpakai untuk menghalang capaian yang tidak dibenarkan.</font></span><font size=\"2\"> </font></p>\r\n<p line-height:=\"\" style=\"\"><b><span lang=\"MS\" mso-ansi-language:=\"\" style=\"\"><font size=\"2\">Keselamatan Storan</font></span></b><span lang=\"MS\" mso-ansi-language:=\"\" style=\"\"><br />\r\n<font size=\"2\">Semua storan elektronik dan penghantaran data peribadi akan dilindungi dan<br />\r\ndisimpan dengan menggunakan teknologi keselamatan yang sesuai.</font></span><font size=\"2\"> </font></p>\r\n<p line-height:=\"\" style=\"\"><b><span lang=\"MS\" mso-ansi-language:=\"\" style=\"\"><font size=\"2\">Maklumat Yang Dikumpul</font></span></b><span lang=\"MS\" mso-ansi-language:=\"\" style=\"\"><br />\r\n<font size=\"2\">Tiada maklumat peribadi akan dikumpul semasa anda melayari laman web ini<br />\r\nkecuali maklumat yang dikemukakan oleh anda melalui e-mel. </font></span></p>\r\n<p line-height:=\"\" style=\"\"><b><span lang=\"MS\" mso-ansi-language:=\"\" style=\"\"><font size=\"2\">Apa yang akan Berlaku jika Saya Membuat Pautan kepada Laman Web yang Lain?<o:p></o:p></font></span></b></p>\r\n<p style=\"\"><span lang=\"MS\" mso-ansi-language:=\"\" style=\"\"><font size=\"2\">Dasar privasi ini hanya terpakai untuk laman web ini sahaja. Perlu diingatkan bahawa laman web yang terdapat dalam pautan mungkin mempunyai dasar privasi yang berbeza dan pengunjung dinasihatkan supaya meneliti dan memahami dasar privasi bagi setiap laman web yang dilayari. </font></span></p>\r\n<p><b><span lang=\"MS\" mso-bidi-language:=\"\" mso-fareast-language:=\"\" new=\"\" times=\"\" mso-fareast-font-family:=\"\" mso-ansi-language:=\"\" font-family:=\"\" style=\"\"><font size=\"2\">Pindaan Dasar</font></span></b><span lang=\"MS\" mso-bidi-language:=\"\" mso-fareast-language:=\"\" new=\"\" times=\"\" mso-fareast-font-family:=\"\" mso-ansi-language:=\"\" font-family:=\"\" style=\"\"><br />\r\n<font size=\"2\">Sekiranya dasar privasi ini dipinda, pindaan akan dikemas kini di halaman ini.<br />\r\nDengan sering melayari halaman ini, anda akan dikemas kini dengan maklumat yang dikumpul, cara ia digunakan dan dalam keadaan tertentu, bagaimana maklumat dikongsi bersama pihak yang lain.</font></span></p>', 'administrator', '2009-06-02 15:03:55', '1');
insert into `sys_information_page` values ('7', 'Dasar Keselamatan edit', 'Dasar Keselamatan edit', '<p><font size=\"2\"><b><span style=\"font-family: Arial;\">Dasar Keselamatan</span></b><span style=\"font-family: Arial;\"> edit<o:p></o:p></span></font></p>\r\n<p style=\"vertical-align: top;\"><b><span style=\"font-family: Arial;\"><font size=\"2\">Perlindungan Data edit</font></span></b><span style=\"font-family: Arial;\"><br />\r\n<font size=\"2\">Teknologi keselamatan terkini adalah digunakan untuk melindungi data yang dikemukakan dan pematuhan kepada standard keselamatan yang ketat adalah terpakai untuk menghalang capaian yang tidak dibenarkan. edit</font></span><span style=\"font-family: Arial;\"><o:p></o:p></span></p>\r\n<p><b><span style=\"font-size: 12pt; font-family: Arial;\"><font size=\"2\">Keselamatan Storan edit</font></span></b><span style=\"font-size: 12pt; font-family: Arial;\"><br />\r\n<font size=\"2\">Semua storan elektronik dan penghantaran data peribadi adalah dilindungi dan<br />\r\ndisimpan dengan menggunakan teknologi keselamatan yang sesuai.</font><span style=\"color: rgb(102, 102, 102);\">&Acirc;&nbsp;</span></span>&Acirc;&nbsp;edit</p>', 'administrator', '2009-06-02 15:02:45', '1');
insert into `sys_information_page` values ('12', 'Halaman Utama', '--', '<p>&nbsp;<img height=\"300\" align=\"middle\" width=\"400\" alt=\"\" src=\"/Zend_template/data/files/image/test/IMG_0640.jpg\" /></p>', 'administrator', '2009-06-03 09:21:57', '1');


### structure of table `sys_jhevnegeri` ###

DROP TABLE IF EXISTS `sys_jhevnegeri`;

CREATE TABLE `sys_jhevnegeri` (
  `jhevnegeri_id` int(10) NOT NULL AUTO_INCREMENT,
  `jhevnegeri_name` varchar(255) NOT NULL,
  `jhevnegeri_alamat` text NOT NULL,
  `jhevnegeri_status` int(1) NOT NULL,
  PRIMARY KEY (`jhevnegeri_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1 AUTO_INCREMENT=10;


### data of table `sys_jhevnegeri` ###

insert into `sys_jhevnegeri` values ('1', 'CAWANGAN NEGERI KEDAH, PERLIS DAN P. PINANG', '268, Kompleks Shahab Perdana\r\nLebuh Raya Sultanah Bahiyah\r\n05350 Alor Setar\r\nKedah Darul Aman', '1');
insert into `sys_jhevnegeri` values ('2', 'CAWANGAN NEGERI PERAK ', 'Lot 3-10, (A-C) Tingkat 3\r\nBangunan Seri Kinta\r\nJalan Sultan Idris Shah\r\n30000 Ipoh\r\nPerak Darul Ridzuan', '1');
insert into `sys_jhevnegeri` values ('3', 'CAWANGAN NEGERI SELANGOR DAN W.P. KUALA LUMPUR', '301, Medan Tuanku\r\nJalan Tuanku Abdul Rahman\r\nPeti Surat 13191\r\n50802 Kuala Lumpur', '1');
insert into `sys_jhevnegeri` values ('4', 'CAWANGAN NEGERI MELAKA DAN N. SEMBILAN', 'Aras 1-A, Wisma Persekutuan\r\nJalan MITC, Hang Tuah Jaya\r\n75450 Ayer Keroh,\r\nMelaka', '1');
insert into `sys_jhevnegeri` values ('5', 'CAWANGAN NEGERI JOHOR', 'Bilik 4, Tingkat 9,\r\nBangunan KWSP, Jalan Dato’ Dalam\r\n80250 Johor Bharu\r\nJohor Darul Takzim ', '1');
insert into `sys_jhevnegeri` values ('6', 'CAWANGAN NEGERI PAHANG', 'Tingkat Satu, Wisma Pahlawan\r\nJalan Gambut\r\n25000 Kuantan\r\nPahang Darul Makmur ', '1');
insert into `sys_jhevnegeri` values ('7', 'CAWANGAN NEGERI KELANTAN DAN TERENGGANU', 'Tingkat 9, Menara Perbadanan\r\nJalan Tengku Petra Semerak\r\n15000 Kota Bharu\r\nKelantan Darul Naim ', '1');
insert into `sys_jhevnegeri` values ('8', 'CAWANGAN NEGERI SABAH', 'Pintu C7-3, Tingkat 7, Blok C\r\nBangunan KWSP\r\nJalan Karamunsing\r\n88000 Kota Kinabalu\r\nSabah ', '1');
insert into `sys_jhevnegeri` values ('9', 'CAWANGAN NEGERI SARAWAK', 'Tingkat 1, Lot 331, 332 & 333\r\nSeksyen 9, Jalan Satok\r\n93400 Kuching\r\nSarawak ', '1');


### structure of table `sys_marital` ###

DROP TABLE IF EXISTS `sys_marital`;

CREATE TABLE `sys_marital` (
  `usrmrd_id` tinyint(1) NOT NULL AUTO_INCREMENT,
  `ursmrd_name` varchar(50) NOT NULL,
  `usrmrd_status` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`usrmrd_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT AUTO_INCREMENT=6;


### data of table `sys_marital` ###

insert into `sys_marital` values ('1', 'Bujang', '1');
insert into `sys_marital` values ('2', 'Berkahwin', '1');
insert into `sys_marital` values ('3', 'Duda', '1');
insert into `sys_marital` values ('4', 'Janda', '1');
insert into `sys_marital` values ('5', 'Tiada Maklumat', '1');


### structure of table `sys_nationality` ###

DROP TABLE IF EXISTS `sys_nationality`;

CREATE TABLE `sys_nationality` (
  `nationality_id` tinyint(1) NOT NULL AUTO_INCREMENT,
  `nationality_name` varchar(50) NOT NULL,
  PRIMARY KEY (`nationality_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 AUTO_INCREMENT=3;


### data of table `sys_nationality` ###

insert into `sys_nationality` values ('1', 'Warganegara');
insert into `sys_nationality` values ('2', 'Bukan Warganegara');


### structure of table `sys_nolesen` ###

DROP TABLE IF EXISTS `sys_nolesen`;

CREATE TABLE `sys_nolesen` (
  `nolesen_id` int(11) NOT NULL AUTO_INCREMENT,
  `usr_id` varchar(50) DEFAULT NULL,
  `nolesen_tarikh` datetime DEFAULT NULL,
  `nolesen_status` int(11) NOT NULL,
  PRIMARY KEY (`nolesen_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;


### data of table `sys_nolesen` ###



### structure of table `sys_pangkat` ###

DROP TABLE IF EXISTS `sys_pangkat`;

CREATE TABLE `sys_pangkat` (
  `pangkat_id` int(11) NOT NULL,
  `pangkat_kod` varchar(32) NOT NULL,
  `pangkat_desc` varchar(255) NOT NULL,
  `pangkat_perkhidmatan` int(5) DEFAULT NULL,
  `pangkat_status` tinyint(1) NOT NULL,
  PRIMARY KEY (`pangkat_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


### data of table `sys_pangkat` ###

insert into `sys_pangkat` values ('1', 'JEN (PAT)', 'PANGLIMA ANGKATAN TENTERA', '10', '1');
insert into `sys_pangkat` values ('102', 'JEN', 'JENERAL', '2', '1');
insert into `sys_pangkat` values ('103', 'LT JEN', 'LEFTENAN JENERAL', '2', '1');
insert into `sys_pangkat` values ('104', 'MEJ JEN', 'MEJAR JENERAL', '2', '1');
insert into `sys_pangkat` values ('105', 'BRID JEN', 'BRIGADIER JENERAL', '2', '1');
insert into `sys_pangkat` values ('106', 'KOL', 'KOLONEL', '2', '1');
insert into `sys_pangkat` values ('107', 'LT KOL', 'LEFTENAN KOLONEL', '2', '1');
insert into `sys_pangkat` values ('108', 'MEJ', 'MEJAR', '2', '1');
insert into `sys_pangkat` values ('109', 'KAPT', 'KAPTEN', '2', '1');
insert into `sys_pangkat` values ('110', 'LEFT ', 'LEFTENAN', '2', '1');
insert into `sys_pangkat` values ('111', 'LT M', 'LEFTENAN MUDA', '2', '1');
insert into `sys_pangkat` values ('112', 'KDT KANAN', 'KDT KANAN', null, '0');
insert into `sys_pangkat` values ('113', 'KDT', 'KDT', null, '0');
insert into `sys_pangkat` values ('114', 'PW I', 'PEGAWAI WAREN SATU', '2', '1');
insert into `sys_pangkat` values ('115', 'PW II', 'PEGAWAI WAREN DUA', '2', '1');
insert into `sys_pangkat` values ('116', 'SSJN', 'STAF SARJAN', '2', '1');
insert into `sys_pangkat` values ('117', 'SJN', 'SARJAN', '2', '1');
insert into `sys_pangkat` values ('118', 'KPL', 'KOPERAL', '2', '1');
insert into `sys_pangkat` values ('119', 'LKPL', 'LANS KOPERAL', '2', '1');
insert into `sys_pangkat` values ('120', 'PBT', 'PREBET', '2', '1');
insert into `sys_pangkat` values ('202', 'LAKSAMANA', 'LAKSAMANA', '3', '1');
insert into `sys_pangkat` values ('203', 'LAKSDYA', 'LAKSAMANA MADYA', '3', '1');
insert into `sys_pangkat` values ('204', 'LAKSDA', 'LAKSAMANA MUDA', '3', '1');
insert into `sys_pangkat` values ('205', 'LAKSMA', 'LAKSAMANA PERTAMA', '3', '1');
insert into `sys_pangkat` values ('206', 'KEPT TLDM', 'KEPTEN', '3', '1');
insert into `sys_pangkat` values ('207', 'KDR TLDM', 'KOMANDER', '3', '1');
insert into `sys_pangkat` values ('208', 'LT KDR TLDM', 'LEFTENAN KOMANDER', '3', '1');
insert into `sys_pangkat` values ('209', 'LT TLDM', 'LEFTENAN (TLDM)', '3', '1');
insert into `sys_pangkat` values ('210', 'LT DYA TLDM', 'LEFTENAN MADYA', '3', '1');
insert into `sys_pangkat` values ('211', 'LT M TLDM', 'LEFTENAN MUDA (TLDM)', '3', '1');
insert into `sys_pangkat` values ('214', 'PW I', 'PEGAWAI WAREN SATU (TLDM)', '3', '1');
insert into `sys_pangkat` values ('215', 'PW II', 'PEGAWAI WAREN DUA (TLDM)', '3', '1');
insert into `sys_pangkat` values ('216', 'BK', 'BINTARA KANAN', '3', '1');
insert into `sys_pangkat` values ('217', 'BM', 'BINTARA MUDA', '3', '1');
insert into `sys_pangkat` values ('218', 'LK', 'LASKAR KANAN', '3', '1');
insert into `sys_pangkat` values ('219', 'LK I', 'LASKAR KELAS SATU', '3', '1');
insert into `sys_pangkat` values ('220', 'LK II', 'LASKAR KELAS DUA', '3', '1');
insert into `sys_pangkat` values ('221', 'LKM', 'LASKAR MUDA', '3', '1');
insert into `sys_pangkat` values ('302', 'JEN(TUDM)    ', 'JENERAL (TUDM)', null, '1');
insert into `sys_pangkat` values ('303', 'LT JEN(TUDM)    ', 'LEFTENAN JENERAL  (TUDM)', '4', '1');
insert into `sys_pangkat` values ('304', 'MEJ JEN(TUDM)', 'MEJ JENERAL  (TUDM)', '4', '1');
insert into `sys_pangkat` values ('305', 'BRIG JEN(TUDM)  ', 'BRIGEDIER JENERAL  (TUDM)', '4', '1');
insert into `sys_pangkat` values ('306', 'KOL (TUDM)', 'KOLONEL  (TUDM)', '4', '1');
insert into `sys_pangkat` values ('307', 'LT KOL(TUDM)  ', 'LEFTENAN KOLONEL  (TUDM)', '4', '1');
insert into `sys_pangkat` values ('308', 'MEJ(TUDM)     ', 'MEJAR  (TUDM)', '4', '1');
insert into `sys_pangkat` values ('309', 'KAPT(TUDM)  ', 'KAPTEN  (TUDM)', '4', '1');
insert into `sys_pangkat` values ('310', 'LT(TUDM)  ', 'LEFTENAN  (TUDM)', '4', '1');
insert into `sys_pangkat` values ('311', 'LTM(TUDM)   ', 'LEFTENAN MUDA  (TUDM)', '4', '1');
insert into `sys_pangkat` values ('314', 'PW U I', 'PEGAWAI WAREN UDARA SATU', '4', '1');
insert into `sys_pangkat` values ('315', 'PW U II ', 'PEGAWAI WAREN UDARA DUA', '4', '1');
insert into `sys_pangkat` values ('316', 'F/SJN', 'FLAIT SARJAN', '4', '1');
insert into `sys_pangkat` values ('317', 'SJN U', 'SARJAN UDARA', '4', '1');
insert into `sys_pangkat` values ('318', 'KPL U ', 'KOPERAL UDARA', '4', '1');
insert into `sys_pangkat` values ('319', 'LUK', 'LASKAR UDARA KANAN', '4', '1');
insert into `sys_pangkat` values ('320', 'LU I', 'LASKAR UDARA 1', '4', '1');
insert into `sys_pangkat` values ('321', 'LU II', 'LASKAR UDARA II', '4', '1');
insert into `sys_pangkat` values ('999', 'NA', 'TIADA MAKLUMAT', null, '1');


### structure of table `sys_race` ###

DROP TABLE IF EXISTS `sys_race`;

CREATE TABLE `sys_race` (
  `race_id` int(10) NOT NULL AUTO_INCREMENT,
  `race_desc` varchar(255) NOT NULL,
  `race_status` tinyint(1) NOT NULL,
  PRIMARY KEY (`race_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1 AUTO_INCREMENT=8;


### data of table `sys_race` ###

insert into `sys_race` values ('1', 'Melayu', '1');
insert into `sys_race` values ('2', 'Cina', '1');
insert into `sys_race` values ('3', 'India', '1');
insert into `sys_race` values ('4', 'Bumiputra Sarawak', '1');
insert into `sys_race` values ('5', 'Bumiputra Sabah', '1');
insert into `sys_race` values ('6', 'Lain-lain', '1');
insert into `sys_race` values ('7', 'Tiada Maklumat', '1');


### structure of table `sys_religion` ###

DROP TABLE IF EXISTS `sys_religion`;

CREATE TABLE `sys_religion` (
  `religion_id` tinyint(3) NOT NULL AUTO_INCREMENT,
  `religion_desc` varchar(50) NOT NULL,
  `religion_status` tinyint(1) NOT NULL,
  PRIMARY KEY (`religion_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 AUTO_INCREMENT=7;


### data of table `sys_religion` ###

insert into `sys_religion` values ('1', 'Tiada Maklumat', '1');
insert into `sys_religion` values ('2', 'Islam', '1');
insert into `sys_religion` values ('3', 'Buddha', '1');
insert into `sys_religion` values ('4', 'Hindu', '1');
insert into `sys_religion` values ('5', 'Kristian', '1');
insert into `sys_religion` values ('6', 'Lain-lain', '1');


### structure of table `sys_state` ###

DROP TABLE IF EXISTS `sys_state`;

CREATE TABLE `sys_state` (
  `sta_id` tinyint(2) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `sta_code` varchar(255) NOT NULL DEFAULT '',
  `sta_name` varchar(255) NOT NULL DEFAULT '',
  `sta_status` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`sta_id`)
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=latin1 AUTO_INCREMENT=101;


### data of table `sys_state` ###

insert into `sys_state` values ('01', 'JOH', 'JOHOR', '1');
insert into `sys_state` values ('02', 'KED', 'KEDAH', '1');
insert into `sys_state` values ('03', 'KEL', 'KELANTAN', '1');
insert into `sys_state` values ('04', 'MEL', 'MELAKA', '1');
insert into `sys_state` values ('05', 'NS', 'NEGERI SEMBILAN', '1');
insert into `sys_state` values ('06', 'PAH', 'PAHANG', '1');
insert into `sys_state` values ('07', 'PEN', 'PULAU PINANG', '1');
insert into `sys_state` values ('08', 'PRK', 'PERAK', '1');
insert into `sys_state` values ('09', 'PER', 'PERLIS', '1');
insert into `sys_state` values ('10', 'SEL', 'SELANGOR', '1');
insert into `sys_state` values ('11', 'TRG', 'TERENGGANU', '1');
insert into `sys_state` values ('12', 'SAB', 'SABAH', '1');
insert into `sys_state` values ('13', 'SRWK', 'SARAWAK', '1');
insert into `sys_state` values ('14', 'KL', 'WILAYAH PERSEKUTUAN KUALA LUMPUR', '1');
insert into `sys_state` values ('15', 'LBN', 'WILAYAH PERSEKUTUAN LABUAN', '1');
insert into `sys_state` values ('16', 'PRJY', 'WILAYAH PERSEKUTUAN PUTRAJAYA', '1');
insert into `sys_state` values ('98', 'LUAR', 'LUAR NEGERI', '1');
insert into `sys_state` values ('99', 'LAIN', 'LAIN-LAIN', '1');
insert into `sys_state` values ('100', 'NA', 'TIADA MAKLUMAT', '1');


### structure of table `sys_taraf_pekerjaan` ###

DROP TABLE IF EXISTS `sys_taraf_pekerjaan`;

CREATE TABLE `sys_taraf_pekerjaan` (
  `taraf_pekerjaan_id` int(11) NOT NULL AUTO_INCREMENT,
  `taraf_pekerjaan_name` varchar(20) NOT NULL,
  PRIMARY KEY (`taraf_pekerjaan_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 AUTO_INCREMENT=4;


### data of table `sys_taraf_pekerjaan` ###

insert into `sys_taraf_pekerjaan` values ('1', 'Sepenuh Masa');
insert into `sys_taraf_pekerjaan` values ('2', 'Sambilan');
insert into `sys_taraf_pekerjaan` values ('3', 'Bebas');


### structure of table `sys_user` ###

DROP TABLE IF EXISTS `sys_user`;

CREATE TABLE `sys_user` (
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


### data of table `sys_user` ###

insert into `sys_user` values ('achik.amiez@gmail.com', 'Achik Amiez', null, '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'achik.amiez@gmail.com', null, null, null, '0', '1', '2', '1', null);
insert into `sys_user` values ('amiez_boyzus@yahoo.com.my', 'Ninjaboy Amie Boyzus', null, '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'amiez_boyzus@yahoo.com.my', null, null, null, '0', '1', '3', '1', null);
insert into `sys_user` values ('yusri.harun@gmail.com', 'Yusri Harun', null, '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 'yusri.harun@gmail.com', null, null, null, '0', '1', '2', '1', null);


### structure of table `sys_user_active` ###

DROP TABLE IF EXISTS `sys_user_active`;

CREATE TABLE `sys_user_active` (
  `active_id` int(2) NOT NULL,
  `active_name` varchar(80) NOT NULL,
  PRIMARY KEY (`active_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


### data of table `sys_user_active` ###

insert into `sys_user_active` values ('0', 'Tidak Aktif');
insert into `sys_user_active` values ('1', 'Aktif');


### structure of table `sys_user_contact` ###

DROP TABLE IF EXISTS `sys_user_contact`;

CREATE TABLE `sys_user_contact` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usr_id` varchar(80) NOT NULL,
  `contact_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1 AUTO_INCREMENT=28;


### data of table `sys_user_contact` ###

insert into `sys_user_contact` values ('20', 'test13', '1');
insert into `sys_user_contact` values ('21', 'test13', '3');
insert into `sys_user_contact` values ('22', '123456', '1');
insert into `sys_user_contact` values ('23', '123456', '2');
insert into `sys_user_contact` values ('24', 'ilia', '1');
insert into `sys_user_contact` values ('25', 'ilia', '2');
insert into `sys_user_contact` values ('26', 'narowi', '1');
insert into `sys_user_contact` values ('27', 'narowi', '3');


### structure of table `sys_user_detail` ###

DROP TABLE IF EXISTS `sys_user_detail`;

CREATE TABLE `sys_user_detail` (
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
  KEY `usr_state_primary_2` (`usr_state_primary`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


### data of table `sys_user_detail` ###

insert into `sys_user_detail` values ('achik.amiez@gmail.com', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '2', null, null, null, null, null);
insert into `sys_user_detail` values ('amiez_boyzus@yahoo.com.my', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
insert into `sys_user_detail` values ('yusri.harun@gmail.com', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '1', null, null, null, null, null);


### structure of table `sys_user_type` ###

DROP TABLE IF EXISTS `sys_user_type`;

CREATE TABLE `sys_user_type` (
  `user_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_type_name` varchar(50) NOT NULL,
  `type_group_id` int(11) NOT NULL COMMENT '1: pengguna dalaman; 2; pengguna luar',
  PRIMARY KEY (`user_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1 AUTO_INCREMENT=11;


### data of table `sys_user_type` ###

insert into `sys_user_type` values ('1', 'Individu', '2');
insert into `sys_user_type` values ('2', 'Syarikat', '2');
insert into `sys_user_type` values ('10', 'Kakitangan', '1');


### structure of table `sys_user_type_group` ###

DROP TABLE IF EXISTS `sys_user_type_group`;

CREATE TABLE `sys_user_type_group` (
  `type_group_id` int(11) NOT NULL AUTO_INCREMENT,
  `type_group_name` varchar(20) NOT NULL,
  PRIMARY KEY (`type_group_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 AUTO_INCREMENT=3;


### data of table `sys_user_type_group` ###

insert into `sys_user_type_group` values ('1', 'Pengguna Dalaman');
insert into `sys_user_type_group` values ('2', 'Pengguna Luar');


### structure of table `tbl_aktif` ###

DROP TABLE IF EXISTS `tbl_aktif`;

CREATE TABLE `tbl_aktif` (
  `aktif_id` int(11) NOT NULL AUTO_INCREMENT,
  `aktif_name` varchar(15) NOT NULL,
  PRIMARY KEY (`aktif_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT AUTO_INCREMENT=3;


### data of table `tbl_aktif` ###

insert into `tbl_aktif` values ('1', 'Aktif');
insert into `tbl_aktif` values ('2', 'Tidak Aktif');


### structure of table `tbl_audit_trail` ###

DROP TABLE IF EXISTS `tbl_audit_trail`;

CREATE TABLE `tbl_audit_trail` (
  `audit_trail_id` int(11) NOT NULL AUTO_INCREMENT,
  `audit_trail_module` varchar(255) NOT NULL,
  `usr_id` varchar(80) NOT NULL,
  `audit_trail_datetime` datetime NOT NULL,
  `audit_trail_task` varchar(255) NOT NULL,
  `audit_trail_ipaddress` varchar(20) NOT NULL,
  PRIMARY KEY (`audit_trail_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1 AUTO_INCREMENT=9;


### data of table `tbl_audit_trail` ###

insert into `tbl_audit_trail` values ('1', 'Pendaftaran', 'yusri.harun@gmail.com', '2014-02-25 15:34:31', 'Pengguna Baru - yusri.harun@gmail.com', '10.0.20.7');
insert into `tbl_audit_trail` values ('2', 'Pendaftaran', 'achik.amiez@gmail.com', '2014-03-14 12:48:39', 'Pengguna Baru - achik.amiez@gmail.com', '10.0.20.7');
insert into `tbl_audit_trail` values ('3', 'Pendaftaran', 'amiez_boyzus@yahoo.com.my', '2014-03-16 14:29:21', 'Pengguna Baru - amiez_boyzus@yahoo.com.my', '183.171.171.141');
insert into `tbl_audit_trail` values ('4', 'Pendaftaran', '', '2014-03-16 14:32:31', 'Pengguna Baru - ', '183.171.171.141');
insert into `tbl_audit_trail` values ('5', 'Pendaftaran', 'eila_lovemail@yahoo.com', '2014-04-18 13:00:05', 'Pengguna Baru - eila_lovemail@yahoo.com', '192.168.100.14');
insert into `tbl_audit_trail` values ('6', 'Pendaftaran', '', '2014-04-23 12:37:23', 'Pengguna Baru - ', '10.0.20.7');
insert into `tbl_audit_trail` values ('7', 'Pendaftaran', 'jhevians@gmail.com', '2014-04-23 12:37:57', 'Pengguna Baru - jhevians@gmail.com', '10.0.20.7');
insert into `tbl_audit_trail` values ('8', 'Pendaftaran', 'jhevians@gmail.com', '2014-04-23 12:42:42', 'Pengguna Baru - jhevians@gmail.com', '10.0.20.7');
