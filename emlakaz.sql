-- phpMyAdmin SQL Dump
-- version 4.4.15.10
-- https://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 10, 2018 at 12:57 PM
-- Server version: 5.5.56-MariaDB
-- PHP Version: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `emlakaz`
--

-- --------------------------------------------------------

--
-- Table structure for table `about`
--

CREATE TABLE IF NOT EXISTS `about` (
  `id` int(11) NOT NULL,
  `title_az` varchar(255) NOT NULL,
  `title_en` varchar(255) NOT NULL,
  `title_ru` varchar(255) NOT NULL,
  `title_tr` varchar(255) NOT NULL,
  `short_text_az` text NOT NULL,
  `short_text_en` text NOT NULL,
  `short_text_ru` text NOT NULL,
  `short_text_tr` text NOT NULL,
  `text_az` longtext NOT NULL,
  `text_en` longtext NOT NULL,
  `text_ru` longtext NOT NULL,
  `text_tr` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `thumb` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `albums`
--

CREATE TABLE IF NOT EXISTS `albums` (
  `id` int(11) NOT NULL,
  `title_az` varchar(255) NOT NULL,
  `title_en` varchar(255) NOT NULL,
  `title_ru` varchar(255) NOT NULL,
  `title_tr` varchar(255) NOT NULL,
  `text_az` text NOT NULL,
  `text_en` text NOT NULL,
  `text_ru` text NOT NULL,
  `text_tr` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `thumb` varchar(255) NOT NULL,
  `table_name` varchar(255) NOT NULL,
  `table_id` int(11) NOT NULL,
  `position` int(11) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `create_time` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `save_mode` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `albums_inner`
--

CREATE TABLE IF NOT EXISTS `albums_inner` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `title_az` varchar(255) NOT NULL,
  `title_en` varchar(255) NOT NULL,
  `title_ru` varchar(255) NOT NULL,
  `title_tr` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `thumb` varchar(255) NOT NULL,
  `position` int(11) NOT NULL,
  `create_time` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `announces`
--

CREATE TABLE IF NOT EXISTS `announces` (
  `id` int(11) NOT NULL,
  `email` tinytext NOT NULL,
  `mobile` tinytext NOT NULL,
  `name` tinytext NOT NULL,
  `price` float NOT NULL,
  `cover` tinytext NOT NULL,
  `images` varchar(7500) NOT NULL,
  `logo_images` varchar(7500) NOT NULL,
  `room_count` tinyint(2) NOT NULL,
  `rent_type` tinyint(1) NOT NULL COMMENT '1=>gunluk, 2=>ayliq',
  `property_type` tinyint(1) NOT NULL COMMENT '1=>yeni, 2=>kohne, 3=>ev/villa, 4=>bag evi, 5>ofis, 6=>qaraj, 7=>torpaq, 8=>obyekt',
  `announce_type` tinyint(1) NOT NULL COMMENT '1=>satilir, 2=>icare',
  `country` tinyint(2) NOT NULL,
  `city` tinyint(3) NOT NULL,
  `region` tinyint(3) NOT NULL,
  `settlement` tinyint(3) NOT NULL,
  `metro` tinyint(3) NOT NULL,
  `mark` tinytext NOT NULL COMMENT 'nisangah',
  `address` tinytext NOT NULL,
  `google_map` tinytext NOT NULL,
  `floor_count` tinyint(2) NOT NULL,
  `current_floor` tinyint(2) NOT NULL,
  `space` float NOT NULL COMMENT 'sahesi',
  `repair` tinyint(1) NOT NULL COMMENT '0=>temirsiz, 1=>natamam, 2=>zeif, 3=>orta temirli, 4=>yaxsi, 5=>ela temirli',
  `document` tinyint(1) NOT NULL COMMENT '0=>yoxdur, 1=>var',
  `text` text NOT NULL,
  `view_count` mediumint(6) NOT NULL,
  `announcer` tinyint(1) NOT NULL COMMENT '1=mulkiyyetci, 2=>vasiteci',
  `status` tinyint(1) NOT NULL COMMENT '0=>gozlemede, 1=>aktiv, 2=>bitmis, 3=>tesdiqlenmemis, 4=>silinmis',
  `insert_type` tinyint(1) NOT NULL COMMENT '0=>free, 1=>mobile_package,2=>user_package',
  `urgently` int(11) NOT NULL COMMENT 'tecili statusunun bitme tarixi',
  `sort_search` int(11) NOT NULL COMMENT 'axtaris siralama',
  `sort_foward` int(11) NOT NULL COMMENT 'ireli siralama',
  `sort_package` int(11) NOT NULL COMMENT 'paketle alanlar ucun siralama',
  `sort_premium` int(11) NOT NULL COMMENT 'premium siralama',
  `announce_date` int(11) NOT NULL COMMENT 'elanin tarixi ve adi siralama',
  `create_time` int(11) NOT NULL,
  `deleted_time` int(11) NOT NULL,
  `reasons` tinytext NOT NULL,
  `discount` tinyint(1) NOT NULL,
  `panarama` varchar(255) NOT NULL,
  `sms_status` varchar(10) NOT NULL,
  `archive_view` int(11) NOT NULL,
  `cdn_server` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `announces_archive_2014`
--

CREATE TABLE IF NOT EXISTS `announces_archive_2014` (
  `id` int(11) NOT NULL,
  `email` tinytext NOT NULL,
  `mobile` tinytext NOT NULL,
  `name` tinytext NOT NULL,
  `price` float NOT NULL,
  `cover` tinytext NOT NULL,
  `images` varchar(7500) NOT NULL,
  `logo_images` varchar(7500) NOT NULL,
  `room_count` tinyint(2) NOT NULL,
  `rent_type` tinyint(1) NOT NULL COMMENT '1=>gunluk, 2=>ayliq',
  `property_type` tinyint(1) NOT NULL COMMENT '1=>yeni, 2=>kohne, 3=>ev/villa, 4=>bag evi, 5>ofis, 6=>qaraj, 7=>torpaq, 8=>obyekt',
  `announce_type` tinyint(1) NOT NULL COMMENT '1=>satilir, 2=>icare',
  `country` tinyint(2) NOT NULL,
  `city` tinyint(3) NOT NULL,
  `region` tinyint(3) NOT NULL,
  `settlement` tinyint(3) NOT NULL,
  `metro` tinyint(3) NOT NULL,
  `mark` tinytext NOT NULL COMMENT 'nisangah',
  `address` tinytext NOT NULL,
  `google_map` tinytext NOT NULL,
  `floor_count` tinyint(2) NOT NULL,
  `current_floor` tinyint(2) NOT NULL,
  `space` float NOT NULL COMMENT 'sahesi',
  `repair` tinyint(1) NOT NULL COMMENT '0=>temirsiz, 1=>natamam, 2=>zeif, 3=>orta temirli, 4=>yaxsi, 5=>ela temirli',
  `document` tinyint(1) NOT NULL COMMENT '0=>yoxdur, 1=>var',
  `text` text NOT NULL,
  `view_count` mediumint(6) NOT NULL,
  `announcer` tinyint(1) NOT NULL COMMENT '1=mulkiyyetci, 2=>vasiteci',
  `status` tinyint(1) NOT NULL COMMENT '0=>gozlemede, 1=>aktiv, 2=>bitmis, 3=>tesdiqlenmemis, 4=>silinmis',
  `insert_type` tinyint(1) NOT NULL COMMENT '0=>free, 1=>mobile_package,2=>user_package',
  `urgently` int(11) NOT NULL COMMENT 'tecili statusunun bitme tarixi',
  `sort_search` int(11) NOT NULL COMMENT 'axtaris siralama',
  `sort_foward` int(11) NOT NULL COMMENT 'ireli siralama',
  `sort_package` int(11) NOT NULL COMMENT 'paketle alanlar ucun siralama',
  `sort_premium` int(11) NOT NULL COMMENT 'premium siralama',
  `announce_date` int(11) NOT NULL COMMENT 'elanin tarixi ve adi siralama',
  `create_time` int(11) NOT NULL,
  `deleted_time` int(11) NOT NULL,
  `reasons` tinytext NOT NULL,
  `discount` tinyint(1) NOT NULL,
  `panarama` varchar(255) NOT NULL,
  `sms_status` varchar(10) NOT NULL,
  `archive_view` int(11) NOT NULL,
  `cdn_server` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `announces_archive_2015`
--

CREATE TABLE IF NOT EXISTS `announces_archive_2015` (
  `id` int(11) NOT NULL,
  `email` tinytext NOT NULL,
  `mobile` tinytext NOT NULL,
  `name` tinytext NOT NULL,
  `price` float NOT NULL,
  `cover` tinytext NOT NULL,
  `images` varchar(7500) NOT NULL,
  `logo_images` varchar(7500) NOT NULL,
  `room_count` tinyint(2) NOT NULL,
  `rent_type` tinyint(1) NOT NULL COMMENT '1=>gunluk, 2=>ayliq',
  `property_type` tinyint(1) NOT NULL COMMENT '1=>yeni, 2=>kohne, 3=>ev/villa, 4=>bag evi, 5>ofis, 6=>qaraj, 7=>torpaq, 8=>obyekt',
  `announce_type` tinyint(1) NOT NULL COMMENT '1=>satilir, 2=>icare',
  `country` tinyint(2) NOT NULL,
  `city` tinyint(3) NOT NULL,
  `region` tinyint(3) NOT NULL,
  `settlement` tinyint(3) NOT NULL,
  `metro` tinyint(3) NOT NULL,
  `mark` tinytext NOT NULL COMMENT 'nisangah',
  `address` tinytext NOT NULL,
  `google_map` tinytext NOT NULL,
  `floor_count` tinyint(2) NOT NULL,
  `current_floor` tinyint(2) NOT NULL,
  `space` float NOT NULL COMMENT 'sahesi',
  `repair` tinyint(1) NOT NULL COMMENT '0=>temirsiz, 1=>natamam, 2=>zeif, 3=>orta temirli, 4=>yaxsi, 5=>ela temirli',
  `document` tinyint(1) NOT NULL COMMENT '0=>yoxdur, 1=>var',
  `text` text NOT NULL,
  `view_count` mediumint(6) NOT NULL,
  `announcer` tinyint(1) NOT NULL COMMENT '1=mulkiyyetci, 2=>vasiteci',
  `status` tinyint(1) NOT NULL COMMENT '0=>gozlemede, 1=>aktiv, 2=>bitmis, 3=>tesdiqlenmemis, 4=>silinmis',
  `insert_type` tinyint(1) NOT NULL COMMENT '0=>free, 1=>mobile_package,2=>user_package',
  `urgently` int(11) NOT NULL COMMENT 'tecili statusunun bitme tarixi',
  `sort_search` int(11) NOT NULL COMMENT 'axtaris siralama',
  `sort_foward` int(11) NOT NULL COMMENT 'ireli siralama',
  `sort_package` int(11) NOT NULL COMMENT 'paketle alanlar ucun siralama',
  `sort_premium` int(11) NOT NULL COMMENT 'premium siralama',
  `announce_date` int(11) NOT NULL COMMENT 'elanin tarixi ve adi siralama',
  `create_time` int(11) NOT NULL,
  `deleted_time` int(11) NOT NULL,
  `reasons` tinytext NOT NULL,
  `discount` tinyint(1) NOT NULL,
  `panarama` varchar(255) NOT NULL,
  `sms_status` varchar(10) NOT NULL,
  `archive_view` int(11) NOT NULL,
  `cdn_server` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `announces_archive_2016`
--

CREATE TABLE IF NOT EXISTS `announces_archive_2016` (
  `id` int(11) NOT NULL,
  `email` tinytext NOT NULL,
  `mobile` tinytext NOT NULL,
  `name` tinytext NOT NULL,
  `price` float NOT NULL,
  `cover` tinytext NOT NULL,
  `images` varchar(7500) NOT NULL,
  `logo_images` varchar(7500) NOT NULL,
  `room_count` tinyint(2) NOT NULL,
  `rent_type` tinyint(1) NOT NULL COMMENT '1=>gunluk, 2=>ayliq',
  `property_type` tinyint(1) NOT NULL COMMENT '1=>yeni, 2=>kohne, 3=>ev/villa, 4=>bag evi, 5>ofis, 6=>qaraj, 7=>torpaq, 8=>obyekt',
  `announce_type` tinyint(1) NOT NULL COMMENT '1=>satilir, 2=>icare',
  `country` tinyint(2) NOT NULL,
  `city` tinyint(3) NOT NULL,
  `region` tinyint(3) NOT NULL,
  `settlement` tinyint(3) NOT NULL,
  `metro` tinyint(3) NOT NULL,
  `mark` tinytext NOT NULL COMMENT 'nisangah',
  `address` tinytext NOT NULL,
  `google_map` tinytext NOT NULL,
  `floor_count` tinyint(2) NOT NULL,
  `current_floor` tinyint(2) NOT NULL,
  `space` float NOT NULL COMMENT 'sahesi',
  `repair` tinyint(1) NOT NULL COMMENT '0=>temirsiz, 1=>natamam, 2=>zeif, 3=>orta temirli, 4=>yaxsi, 5=>ela temirli',
  `document` tinyint(1) NOT NULL COMMENT '0=>yoxdur, 1=>var',
  `text` text NOT NULL,
  `view_count` mediumint(6) NOT NULL,
  `announcer` tinyint(1) NOT NULL COMMENT '1=mulkiyyetci, 2=>vasiteci',
  `status` tinyint(1) NOT NULL COMMENT '0=>gozlemede, 1=>aktiv, 2=>bitmis, 3=>tesdiqlenmemis, 4=>silinmis',
  `insert_type` tinyint(1) NOT NULL COMMENT '0=>free, 1=>mobile_package,2=>user_package',
  `urgently` int(11) NOT NULL COMMENT 'tecili statusunun bitme tarixi',
  `sort_search` int(11) NOT NULL COMMENT 'axtaris siralama',
  `sort_foward` int(11) NOT NULL COMMENT 'ireli siralama',
  `sort_package` int(11) NOT NULL COMMENT 'paketle alanlar ucun siralama',
  `sort_premium` int(11) NOT NULL COMMENT 'premium siralama',
  `announce_date` int(11) NOT NULL COMMENT 'elanin tarixi ve adi siralama',
  `create_time` int(11) NOT NULL,
  `deleted_time` int(11) NOT NULL,
  `reasons` tinytext NOT NULL,
  `discount` tinyint(1) NOT NULL,
  `panarama` varchar(255) NOT NULL,
  `sms_status` varchar(10) NOT NULL,
  `archive_view` int(11) NOT NULL,
  `cdn_server` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `announces_archive_2017`
--

CREATE TABLE IF NOT EXISTS `announces_archive_2017` (
  `id` int(11) NOT NULL,
  `email` tinytext NOT NULL,
  `mobile` tinytext NOT NULL,
  `name` tinytext NOT NULL,
  `price` float NOT NULL,
  `cover` tinytext NOT NULL,
  `images` varchar(7500) NOT NULL,
  `logo_images` varchar(7500) NOT NULL,
  `room_count` tinyint(2) NOT NULL,
  `rent_type` tinyint(1) NOT NULL COMMENT '1=>gunluk, 2=>ayliq',
  `property_type` tinyint(1) NOT NULL COMMENT '1=>yeni, 2=>kohne, 3=>ev/villa, 4=>bag evi, 5>ofis, 6=>qaraj, 7=>torpaq, 8=>obyekt',
  `announce_type` tinyint(1) NOT NULL COMMENT '1=>satilir, 2=>icare',
  `country` tinyint(2) NOT NULL,
  `city` tinyint(3) NOT NULL,
  `region` tinyint(3) NOT NULL,
  `settlement` tinyint(3) NOT NULL,
  `metro` tinyint(3) NOT NULL,
  `mark` tinytext NOT NULL COMMENT 'nisangah',
  `address` tinytext NOT NULL,
  `google_map` tinytext NOT NULL,
  `floor_count` tinyint(2) NOT NULL,
  `current_floor` tinyint(2) NOT NULL,
  `space` float NOT NULL COMMENT 'sahesi',
  `repair` tinyint(1) NOT NULL COMMENT '0=>temirsiz, 1=>natamam, 2=>zeif, 3=>orta temirli, 4=>yaxsi, 5=>ela temirli',
  `document` tinyint(1) NOT NULL COMMENT '0=>yoxdur, 1=>var',
  `text` text NOT NULL,
  `view_count` mediumint(6) NOT NULL,
  `announcer` tinyint(1) NOT NULL COMMENT '1=mulkiyyetci, 2=>vasiteci',
  `status` tinyint(1) NOT NULL COMMENT '0=>gozlemede, 1=>aktiv, 2=>bitmis, 3=>tesdiqlenmemis, 4=>silinmis',
  `insert_type` tinyint(1) NOT NULL COMMENT '0=>free, 1=>mobile_package,2=>user_package',
  `urgently` int(11) NOT NULL COMMENT 'tecili statusunun bitme tarixi',
  `sort_search` int(11) NOT NULL COMMENT 'axtaris siralama',
  `sort_foward` int(11) NOT NULL COMMENT 'ireli siralama',
  `sort_package` int(11) NOT NULL COMMENT 'paketle alanlar ucun siralama',
  `sort_premium` int(11) NOT NULL COMMENT 'premium siralama',
  `announce_date` int(11) NOT NULL COMMENT 'elanin tarixi ve adi siralama',
  `create_time` int(11) NOT NULL,
  `deleted_time` int(11) NOT NULL,
  `reasons` tinytext NOT NULL,
  `discount` tinyint(1) NOT NULL,
  `panarama` varchar(255) NOT NULL,
  `sms_status` varchar(10) NOT NULL,
  `archive_view` int(11) NOT NULL,
  `cdn_server` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `announces_archive_2018`
--

CREATE TABLE IF NOT EXISTS `announces_archive_2018` (
  `id` int(11) NOT NULL,
  `email` tinytext NOT NULL,
  `mobile` tinytext NOT NULL,
  `name` tinytext NOT NULL,
  `price` float NOT NULL,
  `cover` tinytext NOT NULL,
  `images` varchar(7500) NOT NULL,
  `logo_images` varchar(7500) NOT NULL,
  `room_count` tinyint(2) NOT NULL,
  `rent_type` tinyint(1) NOT NULL COMMENT '1=>gunluk, 2=>ayliq',
  `property_type` tinyint(1) NOT NULL COMMENT '1=>yeni, 2=>kohne, 3=>ev/villa, 4=>bag evi, 5>ofis, 6=>qaraj, 7=>torpaq, 8=>obyekt',
  `announce_type` tinyint(1) NOT NULL COMMENT '1=>satilir, 2=>icare',
  `country` tinyint(2) NOT NULL,
  `city` tinyint(3) NOT NULL,
  `region` tinyint(3) NOT NULL,
  `settlement` tinyint(3) NOT NULL,
  `metro` tinyint(3) NOT NULL,
  `mark` tinytext NOT NULL COMMENT 'nisangah',
  `address` tinytext NOT NULL,
  `google_map` tinytext NOT NULL,
  `floor_count` tinyint(2) NOT NULL,
  `current_floor` tinyint(2) NOT NULL,
  `space` float NOT NULL COMMENT 'sahesi',
  `repair` tinyint(1) NOT NULL COMMENT '0=>temirsiz, 1=>natamam, 2=>zeif, 3=>orta temirli, 4=>yaxsi, 5=>ela temirli',
  `document` tinyint(1) NOT NULL COMMENT '0=>yoxdur, 1=>var',
  `text` text NOT NULL,
  `view_count` mediumint(6) NOT NULL,
  `announcer` tinyint(1) NOT NULL COMMENT '1=mulkiyyetci, 2=>vasiteci',
  `status` tinyint(1) NOT NULL COMMENT '0=>gozlemede, 1=>aktiv, 2=>bitmis, 3=>tesdiqlenmemis, 4=>silinmis',
  `insert_type` tinyint(1) NOT NULL COMMENT '0=>free, 1=>mobile_package,2=>user_package',
  `urgently` int(11) NOT NULL COMMENT 'tecili statusunun bitme tarixi',
  `sort_search` int(11) NOT NULL COMMENT 'axtaris siralama',
  `sort_foward` int(11) NOT NULL COMMENT 'ireli siralama',
  `sort_package` int(11) NOT NULL COMMENT 'paketle alanlar ucun siralama',
  `sort_premium` int(11) NOT NULL COMMENT 'premium siralama',
  `announce_date` int(11) NOT NULL COMMENT 'elanin tarixi ve adi siralama',
  `create_time` int(11) NOT NULL,
  `deleted_time` int(11) NOT NULL,
  `reasons` tinytext NOT NULL,
  `discount` tinyint(1) NOT NULL,
  `panarama` varchar(255) NOT NULL,
  `sms_status` varchar(10) NOT NULL,
  `archive_view` int(11) NOT NULL,
  `cdn_server` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `announces_edited`
--

CREATE TABLE IF NOT EXISTS `announces_edited` (
  `id` int(11) NOT NULL,
  `announce_id` int(11) NOT NULL,
  `email` tinytext NOT NULL,
  `mobile` tinytext NOT NULL,
  `name` tinytext NOT NULL,
  `price` float NOT NULL,
  `images` varchar(7500) NOT NULL,
  `logo_images` varchar(7500) NOT NULL,
  `room_count` tinyint(2) NOT NULL,
  `rent_type` tinyint(1) NOT NULL COMMENT '1=>gunluk, 2=>ayliq',
  `property_type` tinyint(1) NOT NULL COMMENT '1=>yeni, 2=>kohne, 3=>ev/villa, 4=>bag evi, 5>ofis, 6=>qaraj, 7=>torpaq, 8=>obyekt',
  `announce_type` tinyint(1) NOT NULL COMMENT '1=>satilir, 2=>icare',
  `country` tinyint(2) NOT NULL,
  `city` tinyint(3) NOT NULL,
  `region` tinyint(3) NOT NULL,
  `settlement` tinyint(3) NOT NULL,
  `metro` tinyint(3) NOT NULL,
  `mark` tinytext NOT NULL COMMENT 'nisangah',
  `address` tinytext NOT NULL,
  `google_map` tinytext NOT NULL,
  `floor_count` tinyint(2) NOT NULL,
  `current_floor` tinyint(2) NOT NULL,
  `space` float NOT NULL COMMENT 'sahesi',
  `repair` tinyint(1) NOT NULL COMMENT '0=>temirsiz, 1=>natamam, 2=>zeif, 3=>orta temirli, 4=>yaxsi, 5=>ela temirli',
  `document` tinyint(1) NOT NULL COMMENT '0=>yoxdur, 1=>var',
  `text` text NOT NULL,
  `announcer` tinyint(1) NOT NULL COMMENT '1=mulkiyyetci, 2=>vasiteci',
  `create_time` int(11) NOT NULL,
  `reasons` varchar(255) NOT NULL,
  `discount` tinyint(1) NOT NULL,
  `view_count` mediumint(6) NOT NULL,
  `panarama` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `announces_share`
--

CREATE TABLE IF NOT EXISTS `announces_share` (
  `id` int(11) NOT NULL,
  `announce_id` int(11) NOT NULL,
  `create_time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `apartments`
--

CREATE TABLE IF NOT EXISTS `apartments` (
  `id` bigint(20) NOT NULL,
  `album_id` int(11) NOT NULL,
  `album_id2` int(11) NOT NULL,
  `title_az` varchar(255) NOT NULL,
  `title_en` varchar(255) NOT NULL,
  `title_ru` varchar(255) NOT NULL,
  `title_tr` varchar(255) NOT NULL,
  `short_text_az` varchar(1000) NOT NULL,
  `short_text_en` varchar(1000) NOT NULL,
  `short_text_ru` varchar(1000) NOT NULL,
  `short_text_tr` varchar(1000) NOT NULL,
  `about_project_az` text NOT NULL,
  `about_project_en` text NOT NULL,
  `about_project_ru` text NOT NULL,
  `about_project_tr` text NOT NULL,
  `about_company_az` text NOT NULL,
  `about_company_en` text NOT NULL,
  `about_company_ru` text NOT NULL,
  `about_company_tr` text NOT NULL,
  `address_az` varchar(255) NOT NULL,
  `address_en` varchar(255) NOT NULL,
  `address_ru` varchar(255) NOT NULL,
  `address_tr` varchar(255) NOT NULL,
  `google_map` varchar(255) NOT NULL,
  `price` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `thumb` varchar(255) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `position` int(11) NOT NULL,
  `status` int(2) NOT NULL,
  `view_count` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `archive_db`
--

CREATE TABLE IF NOT EXISTS `archive_db` (
  `id` bigint(20) NOT NULL,
  `from_` varchar(255) NOT NULL COMMENT 'kimden (User:email, Admin:4,Announce:5785)',
  `to_` tinytext NOT NULL COMMENT 'kime(esas) (User:email,Announce:5785,Mobile:(050) 999-99-99)',
  `operation` tinytext NOT NULL COMMENT 'premium_elan, elan_paket, ireli_paket',
  `mobiles` tinytext NOT NULL,
  `insert_type` tinyint(1) NOT NULL COMMENT '0=>free, 1=>mobile_package,2=>user_package',
  `time_count` tinytext NOT NULL COMMENT 'muudet ve ya say. (30 gunluk ve ya 50)',
  `price` float NOT NULL DEFAULT '0',
  `announce_id` int(11) NOT NULL,
  `text` varchar(5000) NOT NULL,
  `note` tinytext NOT NULL,
  `create_time` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `authors`
--

CREATE TABLE IF NOT EXISTS `authors` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `about_az` longtext NOT NULL,
  `about_en` longtext NOT NULL,
  `about_ru` longtext NOT NULL,
  `about_tr` longtext NOT NULL,
  `image` varchar(255) NOT NULL,
  `thumb` varchar(255) NOT NULL,
  `post_count` int(11) NOT NULL,
  `last_post_time` int(11) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `create_time` int(11) NOT NULL,
  `status` tinyint(2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE IF NOT EXISTS `banners` (
  `id` int(11) NOT NULL,
  `title_az` varchar(255) NOT NULL,
  `title_en` varchar(255) NOT NULL,
  `title_ru` varchar(255) NOT NULL,
  `title_tr` varchar(255) NOT NULL,
  `text_az` longtext NOT NULL,
  `text_en` longtext NOT NULL,
  `text_ru` longtext NOT NULL,
  `text_tr` text NOT NULL,
  `position` int(11) NOT NULL,
  `status` tinyint(2) NOT NULL,
  `save_mode` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `black_list`
--

CREATE TABLE IF NOT EXISTS `black_list` (
  `id` int(11) NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `date` int(11) NOT NULL,
  `time` int(11) NOT NULL COMMENT 'muddet',
  `from_` int(11) NOT NULL COMMENT 'kim_terefinden',
  `reason` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `table_name` varchar(10) NOT NULL,
  `title_az` varchar(255) NOT NULL,
  `title_en` varchar(255) NOT NULL,
  `title_ru` varchar(255) NOT NULL,
  `title_tr` varchar(255) NOT NULL,
  `text_az` longtext NOT NULL,
  `text_en` longtext NOT NULL,
  `text_ru` longtext NOT NULL,
  `text_tr` text NOT NULL,
  `position` int(11) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `status` tinyint(2) NOT NULL,
  `save_mode` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE IF NOT EXISTS `cities` (
  `id` int(11) NOT NULL,
  `title_az` varchar(255) NOT NULL,
  `title_en` varchar(255) NOT NULL,
  `title_ru` varchar(255) NOT NULL,
  `title_tr` varchar(255) NOT NULL,
  `status` tinyint(2) NOT NULL,
  `save_mode` tinyint(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE IF NOT EXISTS `contact` (
  `id` int(11) NOT NULL,
  `address_az` varchar(255) NOT NULL,
  `address_en` varchar(255) NOT NULL,
  `address_ru` varchar(255) NOT NULL,
  `address_tr` varchar(255) NOT NULL,
  `text_az` text NOT NULL,
  `text_en` text NOT NULL,
  `text_ru` text NOT NULL,
  `text_tr` text NOT NULL,
  `footer_az` text NOT NULL,
  `footer_en` text NOT NULL,
  `footer_ru` text NOT NULL,
  `footer_tr` text NOT NULL,
  `email` varchar(255) NOT NULL,
  `facebook` varchar(255) NOT NULL,
  `twitter` varchar(255) NOT NULL,
  `vkontakte` varchar(255) NOT NULL,
  `linkedin` varchar(255) NOT NULL,
  `digg` varchar(255) NOT NULL,
  `flickr` varchar(255) NOT NULL,
  `dribbble` varchar(255) NOT NULL,
  `vimeo` varchar(255) NOT NULL,
  `myspace` varchar(255) NOT NULL,
  `google` varchar(255) NOT NULL,
  `youtube` varchar(255) NOT NULL,
  `instagram` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `phone2` varchar(255) NOT NULL,
  `mobile2` varchar(255) NOT NULL,
  `skype` varchar(255) NOT NULL,
  `fax` varchar(255) NOT NULL,
  `reklam_phone` varchar(255) NOT NULL,
  `google_map` text NOT NULL,
  `position` int(11) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `save_mode` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE IF NOT EXISTS `countries` (
  `id` int(11) NOT NULL,
  `title_az` varchar(255) NOT NULL,
  `title_en` varchar(255) NOT NULL,
  `title_ru` varchar(255) NOT NULL,
  `title_tr` varchar(255) NOT NULL,
  `status` tinyint(2) NOT NULL,
  `save_mode` tinyint(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `count_announces`
--

CREATE TABLE IF NOT EXISTS `count_announces` (
  `id` int(11) NOT NULL,
  `count_announces` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `currency`
--

CREATE TABLE IF NOT EXISTS `currency` (
  `id` int(11) NOT NULL,
  `usd` float NOT NULL,
  `date` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `email_changer`
--

CREATE TABLE IF NOT EXISTS `email_changer` (
  `id` int(11) NOT NULL,
  `old_email` varchar(50) NOT NULL,
  `new_email` varchar(50) NOT NULL,
  `code` varchar(100) NOT NULL,
  `code2` varchar(100) NOT NULL,
  `create_time` int(11) NOT NULL,
  `status` tinyint(2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `estate_orders`
--

CREATE TABLE IF NOT EXISTS `estate_orders` (
  `id` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `create_time` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `position` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `marks`
--

CREATE TABLE IF NOT EXISTS `marks` (
  `id` int(11) NOT NULL,
  `title_az` varchar(255) NOT NULL,
  `title_en` varchar(255) NOT NULL,
  `title_ru` varchar(255) NOT NULL,
  `title_tr` varchar(255) NOT NULL,
  `status` tinyint(2) NOT NULL,
  `save_mode` tinyint(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `metros`
--

CREATE TABLE IF NOT EXISTS `metros` (
  `id` int(11) NOT NULL,
  `title_az` varchar(255) NOT NULL,
  `title_en` varchar(255) NOT NULL,
  `title_ru` varchar(255) NOT NULL,
  `title_tr` varchar(255) NOT NULL,
  `status` tinyint(2) NOT NULL,
  `save_mode` tinyint(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `migration`
--

CREATE TABLE IF NOT EXISTS `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mobile_package`
--

CREATE TABLE IF NOT EXISTS `mobile_package` (
  `id` int(11) NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `balance` int(11) NOT NULL,
  `create_time` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `package_prices`
--

CREATE TABLE IF NOT EXISTS `package_prices` (
  `id` int(11) NOT NULL,
  `announce_limit` tinyint(4) NOT NULL,
  `announce_time` tinyint(3) NOT NULL,
  `announce_package1` tinyint(4) NOT NULL,
  `announce_package10` tinyint(4) NOT NULL,
  `announce_package50` tinyint(4) NOT NULL,
  `announce_premium10` tinyint(4) NOT NULL,
  `announce_premium15` tinyint(4) NOT NULL,
  `announce_premium30` tinyint(4) NOT NULL,
  `announce_foward1` tinyint(4) NOT NULL,
  `announce_foward20` tinyint(4) NOT NULL,
  `announce_foward50` tinyint(4) NOT NULL,
  `announce_foward_time` tinyint(2) NOT NULL,
  `announce_fb` tinyint(4) NOT NULL,
  `announce_search10` tinyint(4) NOT NULL,
  `announce_urgent` tinyint(4) NOT NULL COMMENT 'tecili',
  `realtor_premium1` tinyint(4) NOT NULL,
  `realtor_premium3` tinyint(4) NOT NULL,
  `realtor_premium6` tinyint(4) NOT NULL,
  `announce_download` tinyint(4) NOT NULL COMMENT 'elanin sekillerini yukleyir'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE IF NOT EXISTS `pages` (
  `id` int(11) NOT NULL,
  `title_az` varchar(255) NOT NULL,
  `title_en` varchar(255) NOT NULL,
  `title_ru` varchar(255) NOT NULL,
  `title_tr` varchar(255) NOT NULL,
  `short_text_az` text NOT NULL,
  `short_text_en` text NOT NULL,
  `short_text_ru` text NOT NULL,
  `short_text_tr` text NOT NULL,
  `text_az` longtext NOT NULL,
  `text_en` longtext NOT NULL,
  `text_ru` longtext NOT NULL,
  `text_tr` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `thumb` varchar(255) NOT NULL,
  `position` int(11) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `status` tinyint(2) NOT NULL,
  `save_mode` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `password_changer`
--

CREATE TABLE IF NOT EXISTS `password_changer` (
  `id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `code` varchar(100) NOT NULL,
  `create_time` int(11) NOT NULL,
  `status` tinyint(2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `id` bigint(20) NOT NULL,
  `category_id` int(11) NOT NULL,
  `album_id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  `title_az` varchar(255) NOT NULL,
  `title_en` varchar(255) NOT NULL,
  `title_ru` varchar(255) NOT NULL,
  `title_tr` varchar(255) NOT NULL,
  `short_text_az` varchar(255) NOT NULL,
  `short_text_en` varchar(255) NOT NULL,
  `short_text_ru` varchar(255) NOT NULL,
  `short_text_tr` varchar(255) NOT NULL,
  `text_az` longtext NOT NULL,
  `text_en` longtext NOT NULL,
  `text_ru` longtext NOT NULL,
  `text_tr` longtext NOT NULL,
  `tags` varchar(255) NOT NULL,
  `desc` text NOT NULL,
  `view_count` int(11) NOT NULL,
  `like_count` int(11) NOT NULL,
  `dislike_count` int(11) NOT NULL,
  `comment_count` int(11) NOT NULL,
  `news_time` int(11) NOT NULL,
  `flash_status` tinyint(2) NOT NULL,
  `image` varchar(255) NOT NULL,
  `thumb` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `create_time` int(11) NOT NULL,
  `status` int(2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `regions`
--

CREATE TABLE IF NOT EXISTS `regions` (
  `id` int(11) NOT NULL,
  `title_az` varchar(255) NOT NULL,
  `title_en` varchar(255) NOT NULL,
  `title_ru` varchar(255) NOT NULL,
  `title_tr` varchar(255) NOT NULL,
  `status` tinyint(2) NOT NULL,
  `save_mode` tinyint(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `seo`
--

CREATE TABLE IF NOT EXISTS `seo` (
  `id` int(11) NOT NULL,
  `link_` varchar(999) NOT NULL,
  `title_` varchar(999) NOT NULL,
  `description_` varchar(999) NOT NULL,
  `sql_` varchar(999) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `seo_manual`
--

CREATE TABLE IF NOT EXISTS `seo_manual` (
  `id` int(11) NOT NULL,
  `title_` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `seo_manual_inner`
--

CREATE TABLE IF NOT EXISTS `seo_manual_inner` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `link_` varchar(999) NOT NULL,
  `title_` varchar(999) NOT NULL,
  `description_` varchar(999) NOT NULL,
  `keywords_` varchar(255) NOT NULL,
  `page_title` varchar(255) NOT NULL,
  `text_top` text NOT NULL,
  `text_bottom` text NOT NULL,
  `sql_` varchar(999) NOT NULL,
  `word_` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE IF NOT EXISTS `services` (
  `id` int(11) NOT NULL,
  `title_az` varchar(255) NOT NULL,
  `title_en` varchar(255) NOT NULL,
  `title_ru` varchar(255) NOT NULL,
  `title_tr` varchar(255) NOT NULL,
  `short_text_az` text NOT NULL,
  `short_text_en` text NOT NULL,
  `short_text_ru` text NOT NULL,
  `short_text_tr` text NOT NULL,
  `text_az` longtext NOT NULL,
  `text_en` longtext NOT NULL,
  `text_ru` longtext NOT NULL,
  `text_tr` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `thumb` varchar(255) NOT NULL,
  `position` int(11) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `status` tinyint(2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(11) NOT NULL,
  `default_language` varchar(5) NOT NULL,
  `s_description` varchar(255) NOT NULL,
  `s_keywords` varchar(255) NOT NULL,
  `s_title` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `settlements`
--

CREATE TABLE IF NOT EXISTS `settlements` (
  `id` int(11) NOT NULL,
  `title_az` varchar(255) NOT NULL,
  `title_en` varchar(255) NOT NULL,
  `title_ru` varchar(255) NOT NULL,
  `title_tr` varchar(255) NOT NULL,
  `status` tinyint(2) NOT NULL,
  `save_mode` tinyint(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sliders`
--

CREATE TABLE IF NOT EXISTS `sliders` (
  `id` int(11) NOT NULL,
  `title_az` varchar(255) NOT NULL,
  `title_en` varchar(255) NOT NULL,
  `title_ru` varchar(255) NOT NULL,
  `title_tr` varchar(255) NOT NULL,
  `text_az` text NOT NULL,
  `text_en` text NOT NULL,
  `text_ru` text NOT NULL,
  `text_tr` text NOT NULL,
  `table_name` varchar(255) NOT NULL,
  `table_id` int(11) NOT NULL,
  `create_time` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `save_mode` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sliders_inner`
--

CREATE TABLE IF NOT EXISTS `sliders_inner` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `title_az` varchar(255) NOT NULL,
  `title_en` varchar(255) NOT NULL,
  `title_ru` varchar(255) NOT NULL,
  `title_tr` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `thumb` varchar(255) NOT NULL,
  `target` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `position` int(11) NOT NULL,
  `create_time` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sms_ann`
--

CREATE TABLE IF NOT EXISTS `sms_ann` (
  `id` int(11) NOT NULL,
  `message_status` int(11) NOT NULL COMMENT '1=>aktiv, 2=>bitmis, 3=>tesdiqlenmemis, 4=>silinmis',
  `time` int(13) NOT NULL,
  `ann_id` int(11) NOT NULL,
  `sms_status` int(11) NOT NULL,
  `sms_id` varchar(150) NOT NULL,
  `charge` int(11) NOT NULL,
  `error_text` varchar(255) NOT NULL,
  `mobile` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sqlmapfile`
--

CREATE TABLE IF NOT EXISTS `sqlmapfile` (
  `data` longtext
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ps` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `login` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `image` varchar(255) NOT NULL,
  `thumb` varchar(255) NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `newsletter` tinyint(2) NOT NULL,
  `package_announce` smallint(6) NOT NULL COMMENT 'elan paketi',
  `package_foward` smallint(6) NOT NULL COMMENT 'ireli paket',
  `package_search` smallint(6) NOT NULL COMMENT 'axtaris paket',
  `paket_social` tinyint(4) NOT NULL,
  `premium` int(11) NOT NULL,
  `announce_count` int(11) NOT NULL COMMENT 'only active announces',
  `create_time` int(11) NOT NULL,
  `status` tinyint(2) NOT NULL,
  `archive_ann` text NOT NULL,
  `title_` varchar(255) NOT NULL,
  `desc_` text NOT NULL,
  `keywords_` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users_equal_emails`
--

CREATE TABLE IF NOT EXISTS `users_equal_emails` (
  `id` int(11) NOT NULL,
  `email` tinytext NOT NULL,
  `equal_id` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `videogallery`
--

CREATE TABLE IF NOT EXISTS `videogallery` (
  `id` int(11) NOT NULL,
  `title_az` varchar(255) NOT NULL,
  `title_en` varchar(255) NOT NULL,
  `title_ru` varchar(255) NOT NULL,
  `title_tr` varchar(255) NOT NULL,
  `text_az` text NOT NULL,
  `text_en` text NOT NULL,
  `text_ru` text NOT NULL,
  `text_tr` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `thumb` varchar(255) NOT NULL,
  `position` int(11) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `create_time` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `save_mode` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `videogallery_inner`
--

CREATE TABLE IF NOT EXISTS `videogallery_inner` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `title_az` varchar(255) NOT NULL,
  `title_en` varchar(255) NOT NULL,
  `title_ru` varchar(255) NOT NULL,
  `title_tr` varchar(255) NOT NULL,
  `text_az` text NOT NULL,
  `text_en` text NOT NULL,
  `text_ru` text NOT NULL,
  `text_tr` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `thumb` varchar(255) NOT NULL,
  `position` int(11) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `create_time` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `about`
--
ALTER TABLE `about`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `albums`
--
ALTER TABLE `albums`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `albums_inner`
--
ALTER TABLE `albums_inner`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `announces`
--
ALTER TABLE `announces`
  ADD PRIMARY KEY (`id`),
  ADD KEY `metro` (`metro`),
  ADD KEY `status` (`status`),
  ADD KEY `create_time` (`create_time`),
  ADD KEY `sort_premium` (`sort_premium`),
  ADD KEY `announce_date` (`announce_date`),
  ADD KEY `price` (`price`),
  ADD KEY `room_count` (`room_count`),
  ADD KEY `rent_type` (`rent_type`),
  ADD KEY `property_type` (`property_type`),
  ADD KEY `announce_type` (`announce_type`),
  ADD KEY `country` (`country`),
  ADD KEY `city` (`city`),
  ADD KEY `region` (`region`),
  ADD KEY `settlement` (`settlement`),
  ADD KEY `floor_count` (`floor_count`),
  ADD KEY `current_floor` (`current_floor`),
  ADD KEY `repair` (`repair`),
  ADD KEY `document` (`document`),
  ADD KEY `announcer` (`announcer`),
  ADD KEY `insert_type` (`insert_type`),
  ADD KEY `urgently` (`urgently`),
  ADD KEY `sort_search` (`sort_search`),
  ADD KEY `sort_foward` (`sort_foward`),
  ADD KEY `sort_package` (`sort_package`),
  ADD FULLTEXT KEY `telefon` (`mobile`);
ALTER TABLE `announces`
  ADD FULLTEXT KEY `email` (`email`);
ALTER TABLE `announces`
  ADD FULLTEXT KEY `text` (`text`);

--
-- Indexes for table `announces_archive_2014`
--
ALTER TABLE `announces_archive_2014`
  ADD PRIMARY KEY (`id`),
  ADD KEY `metro` (`metro`),
  ADD KEY `status` (`status`),
  ADD KEY `create_time` (`create_time`),
  ADD KEY `sort_premium` (`sort_premium`),
  ADD KEY `announce_date` (`announce_date`),
  ADD KEY `price` (`price`),
  ADD KEY `room_count` (`room_count`),
  ADD KEY `rent_type` (`rent_type`),
  ADD KEY `property_type` (`property_type`),
  ADD KEY `announce_type` (`announce_type`),
  ADD KEY `country` (`country`),
  ADD KEY `city` (`city`),
  ADD KEY `region` (`region`),
  ADD KEY `settlement` (`settlement`),
  ADD KEY `floor_count` (`floor_count`),
  ADD KEY `current_floor` (`current_floor`),
  ADD KEY `repair` (`repair`),
  ADD KEY `document` (`document`),
  ADD KEY `announcer` (`announcer`),
  ADD KEY `insert_type` (`insert_type`),
  ADD KEY `urgently` (`urgently`),
  ADD KEY `sort_search` (`sort_search`),
  ADD KEY `sort_foward` (`sort_foward`),
  ADD KEY `sort_package` (`sort_package`),
  ADD FULLTEXT KEY `telefon` (`mobile`);
ALTER TABLE `announces_archive_2014`
  ADD FULLTEXT KEY `email` (`email`);
ALTER TABLE `announces_archive_2014`
  ADD FULLTEXT KEY `text` (`text`);

--
-- Indexes for table `announces_archive_2015`
--
ALTER TABLE `announces_archive_2015`
  ADD PRIMARY KEY (`id`),
  ADD KEY `metro` (`metro`),
  ADD KEY `status` (`status`),
  ADD KEY `create_time` (`create_time`),
  ADD KEY `sort_premium` (`sort_premium`),
  ADD KEY `announce_date` (`announce_date`),
  ADD KEY `price` (`price`),
  ADD KEY `room_count` (`room_count`),
  ADD KEY `rent_type` (`rent_type`),
  ADD KEY `property_type` (`property_type`),
  ADD KEY `announce_type` (`announce_type`),
  ADD KEY `country` (`country`),
  ADD KEY `city` (`city`),
  ADD KEY `region` (`region`),
  ADD KEY `settlement` (`settlement`),
  ADD KEY `floor_count` (`floor_count`),
  ADD KEY `current_floor` (`current_floor`),
  ADD KEY `repair` (`repair`),
  ADD KEY `document` (`document`),
  ADD KEY `announcer` (`announcer`),
  ADD KEY `insert_type` (`insert_type`),
  ADD KEY `urgently` (`urgently`),
  ADD KEY `sort_search` (`sort_search`),
  ADD KEY `sort_foward` (`sort_foward`),
  ADD KEY `sort_package` (`sort_package`),
  ADD FULLTEXT KEY `telefon` (`mobile`);
ALTER TABLE `announces_archive_2015`
  ADD FULLTEXT KEY `email` (`email`);
ALTER TABLE `announces_archive_2015`
  ADD FULLTEXT KEY `text` (`text`);

--
-- Indexes for table `announces_archive_2016`
--
ALTER TABLE `announces_archive_2016`
  ADD PRIMARY KEY (`id`),
  ADD KEY `metro` (`metro`),
  ADD KEY `status` (`status`),
  ADD KEY `create_time` (`create_time`),
  ADD KEY `sort_premium` (`sort_premium`),
  ADD KEY `announce_date` (`announce_date`),
  ADD KEY `price` (`price`),
  ADD KEY `room_count` (`room_count`),
  ADD KEY `rent_type` (`rent_type`),
  ADD KEY `property_type` (`property_type`),
  ADD KEY `announce_type` (`announce_type`),
  ADD KEY `country` (`country`),
  ADD KEY `city` (`city`),
  ADD KEY `region` (`region`),
  ADD KEY `settlement` (`settlement`),
  ADD KEY `floor_count` (`floor_count`),
  ADD KEY `current_floor` (`current_floor`),
  ADD KEY `repair` (`repair`),
  ADD KEY `document` (`document`),
  ADD KEY `announcer` (`announcer`),
  ADD KEY `insert_type` (`insert_type`),
  ADD KEY `urgently` (`urgently`),
  ADD KEY `sort_search` (`sort_search`),
  ADD KEY `sort_foward` (`sort_foward`),
  ADD KEY `sort_package` (`sort_package`),
  ADD FULLTEXT KEY `telefon` (`mobile`);
ALTER TABLE `announces_archive_2016`
  ADD FULLTEXT KEY `email` (`email`);
ALTER TABLE `announces_archive_2016`
  ADD FULLTEXT KEY `text` (`text`);

--
-- Indexes for table `announces_archive_2017`
--
ALTER TABLE `announces_archive_2017`
  ADD PRIMARY KEY (`id`),
  ADD KEY `metro` (`metro`),
  ADD KEY `status` (`status`),
  ADD KEY `create_time` (`create_time`),
  ADD KEY `sort_premium` (`sort_premium`),
  ADD KEY `announce_date` (`announce_date`),
  ADD KEY `price` (`price`),
  ADD KEY `room_count` (`room_count`),
  ADD KEY `rent_type` (`rent_type`),
  ADD KEY `property_type` (`property_type`),
  ADD KEY `announce_type` (`announce_type`),
  ADD KEY `country` (`country`),
  ADD KEY `city` (`city`),
  ADD KEY `region` (`region`),
  ADD KEY `settlement` (`settlement`),
  ADD KEY `floor_count` (`floor_count`),
  ADD KEY `current_floor` (`current_floor`),
  ADD KEY `repair` (`repair`),
  ADD KEY `document` (`document`),
  ADD KEY `announcer` (`announcer`),
  ADD KEY `insert_type` (`insert_type`),
  ADD KEY `urgently` (`urgently`),
  ADD KEY `sort_search` (`sort_search`),
  ADD KEY `sort_foward` (`sort_foward`),
  ADD KEY `sort_package` (`sort_package`),
  ADD FULLTEXT KEY `telefon` (`mobile`);
ALTER TABLE `announces_archive_2017`
  ADD FULLTEXT KEY `email` (`email`);
ALTER TABLE `announces_archive_2017`
  ADD FULLTEXT KEY `text` (`text`);

--
-- Indexes for table `announces_archive_2018`
--
ALTER TABLE `announces_archive_2018`
  ADD PRIMARY KEY (`id`),
  ADD KEY `metro` (`metro`),
  ADD KEY `status` (`status`),
  ADD KEY `create_time` (`create_time`),
  ADD KEY `sort_premium` (`sort_premium`),
  ADD KEY `announce_date` (`announce_date`),
  ADD KEY `price` (`price`),
  ADD KEY `room_count` (`room_count`),
  ADD KEY `rent_type` (`rent_type`),
  ADD KEY `property_type` (`property_type`),
  ADD KEY `announce_type` (`announce_type`),
  ADD KEY `country` (`country`),
  ADD KEY `city` (`city`),
  ADD KEY `region` (`region`),
  ADD KEY `settlement` (`settlement`),
  ADD KEY `floor_count` (`floor_count`),
  ADD KEY `current_floor` (`current_floor`),
  ADD KEY `repair` (`repair`),
  ADD KEY `document` (`document`),
  ADD KEY `announcer` (`announcer`),
  ADD KEY `insert_type` (`insert_type`),
  ADD KEY `urgently` (`urgently`),
  ADD KEY `sort_search` (`sort_search`),
  ADD KEY `sort_foward` (`sort_foward`),
  ADD KEY `sort_package` (`sort_package`),
  ADD FULLTEXT KEY `telefon` (`mobile`);
ALTER TABLE `announces_archive_2018`
  ADD FULLTEXT KEY `email` (`email`);
ALTER TABLE `announces_archive_2018`
  ADD FULLTEXT KEY `text` (`text`);

--
-- Indexes for table `announces_edited`
--
ALTER TABLE `announces_edited`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `qiymeti` (`price`),
  ADD KEY `emlakin_novu` (`property_type`),
  ADD KEY `elanin_novu` (`announce_type`),
  ADD KEY `icare_muddeti` (`rent_type`),
  ADD KEY `olke` (`country`),
  ADD KEY `seher` (`city`),
  ADD KEY `rayon` (`region`),
  ADD KEY `qesebe` (`settlement`),
  ADD KEY `metro` (`metro`),
  ADD KEY `mertebe_sayi` (`floor_count`),
  ADD KEY `yerlesdiyi_mertebe` (`current_floor`),
  ADD KEY `sahesi` (`space`),
  ADD KEY `otaq_sayi` (`room_count`),
  ADD KEY `otaq_sayi_2` (`room_count`),
  ADD KEY `temir` (`repair`),
  ADD KEY `sened` (`document`),
  ADD KEY `elan_veren` (`announcer`),
  ADD KEY `create_time` (`create_time`),
  ADD FULLTEXT KEY `elave_melumat` (`text`);
ALTER TABLE `announces_edited`
  ADD FULLTEXT KEY `elave_melumat_2` (`text`);
ALTER TABLE `announces_edited`
  ADD FULLTEXT KEY `telefon` (`mobile`);

--
-- Indexes for table `announces_share`
--
ALTER TABLE `announces_share`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `apartments`
--
ALTER TABLE `apartments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `archive_db`
--
ALTER TABLE `archive_db`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `authors`
--
ALTER TABLE `authors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `black_list`
--
ALTER TABLE `black_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `count_announces`
--
ALTER TABLE `count_announces`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `currency`
--
ALTER TABLE `currency`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_changer`
--
ALTER TABLE `email_changer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `estate_orders`
--
ALTER TABLE `estate_orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `marks`
--
ALTER TABLE `marks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `metros`
--
ALTER TABLE `metros`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `mobile_package`
--
ALTER TABLE `mobile_package`
  ADD PRIMARY KEY (`id`),
  ADD KEY `telefon` (`mobile`),
  ADD KEY `id` (`id`),
  ADD FULLTEXT KEY `telefon_2` (`mobile`);

--
-- Indexes for table `package_prices`
--
ALTER TABLE `package_prices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_changer`
--
ALTER TABLE `password_changer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `regions`
--
ALTER TABLE `regions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `seo`
--
ALTER TABLE `seo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `seo_manual`
--
ALTER TABLE `seo_manual`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `seo_manual_inner`
--
ALTER TABLE `seo_manual_inner`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settlements`
--
ALTER TABLE `settlements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sliders`
--
ALTER TABLE `sliders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sliders_inner`
--
ALTER TABLE `sliders_inner`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sms_ann`
--
ALTER TABLE `sms_ann`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `users_equal_emails`
--
ALTER TABLE `users_equal_emails`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `videogallery`
--
ALTER TABLE `videogallery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `videogallery_inner`
--
ALTER TABLE `videogallery_inner`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `about`
--
ALTER TABLE `about`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `albums`
--
ALTER TABLE `albums`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `albums_inner`
--
ALTER TABLE `albums_inner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `announces`
--
ALTER TABLE `announces`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `announces_archive_2014`
--
ALTER TABLE `announces_archive_2014`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `announces_archive_2015`
--
ALTER TABLE `announces_archive_2015`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `announces_archive_2016`
--
ALTER TABLE `announces_archive_2016`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `announces_archive_2017`
--
ALTER TABLE `announces_archive_2017`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `announces_archive_2018`
--
ALTER TABLE `announces_archive_2018`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `announces_edited`
--
ALTER TABLE `announces_edited`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `announces_share`
--
ALTER TABLE `announces_share`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `apartments`
--
ALTER TABLE `apartments`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `archive_db`
--
ALTER TABLE `archive_db`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `authors`
--
ALTER TABLE `authors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `black_list`
--
ALTER TABLE `black_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `count_announces`
--
ALTER TABLE `count_announces`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `currency`
--
ALTER TABLE `currency`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `email_changer`
--
ALTER TABLE `email_changer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `estate_orders`
--
ALTER TABLE `estate_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `marks`
--
ALTER TABLE `marks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `metros`
--
ALTER TABLE `metros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `mobile_package`
--
ALTER TABLE `mobile_package`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `package_prices`
--
ALTER TABLE `package_prices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `password_changer`
--
ALTER TABLE `password_changer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `regions`
--
ALTER TABLE `regions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `seo`
--
ALTER TABLE `seo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `seo_manual`
--
ALTER TABLE `seo_manual`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `seo_manual_inner`
--
ALTER TABLE `seo_manual_inner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `settlements`
--
ALTER TABLE `settlements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sliders`
--
ALTER TABLE `sliders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sliders_inner`
--
ALTER TABLE `sliders_inner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sms_ann`
--
ALTER TABLE `sms_ann`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users_equal_emails`
--
ALTER TABLE `users_equal_emails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `videogallery`
--
ALTER TABLE `videogallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `videogallery_inner`
--
ALTER TABLE `videogallery_inner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
