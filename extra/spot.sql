-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 25, 2013 at 01:31 AM
-- Server version: 5.5.29
-- PHP Version: 5.3.10-1ubuntu3.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `spot`
--

-- --------------------------------------------------------

--
-- Table structure for table `sp_activities`
--

CREATE TABLE IF NOT EXISTS `sp_activities` (
  `activity_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL DEFAULT '0',
  `activity` varchar(255) NOT NULL,
  `module` varchar(255) NOT NULL,
  `created_on` datetime NOT NULL,
  `deleted` tinyint(12) NOT NULL DEFAULT '0',
  PRIMARY KEY (`activity_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=28 ;

--
-- Dumping data for table `sp_activities`
--

INSERT INTO `sp_activities` (`activity_id`, `user_id`, `activity`, `module`, `created_on`, `deleted`) VALUES
(1, 1, 'logged in from: 127.0.0.1', 'users', '2013-03-20 13:35:43', 0),
(2, 1, 'Created Module: Places : 127.0.0.1', 'modulebuilder', '2013-03-20 13:44:43', 0),
(3, 1, 'Created record with ID: 1 : 127.0.0.1', 'places', '2013-03-20 13:58:38', 0),
(4, 2, 'logged out from: 127.0.0.1', 'users', '2013-03-21 17:07:48', 0),
(5, 1, 'logged in from: 127.0.0.1', 'users', '2013-03-21 17:08:24', 0),
(6, 1, 'logged out from: 127.0.0.1', 'users', '2013-03-21 17:20:48', 0),
(7, 1, 'logged in from: 127.0.0.1', 'users', '2013-03-21 17:25:30', 0),
(8, 1, 'logged in from: 127.0.0.1', 'users', '2013-03-22 13:23:12', 0),
(9, 1, 'logged in from: 127.0.0.1', 'users', '2013-03-23 07:40:34', 0),
(10, 3, 'registered a new account.', 'users', '2013-03-23 08:04:05', 0),
(11, 1, 'logged out from: 127.0.0.1', 'users', '2013-03-23 08:04:26', 0),
(12, 4, 'registered a new account.', 'users', '2013-03-23 10:02:56', 0),
(13, 5, 'registered a new account.', 'users', '2013-03-23 10:04:10', 0),
(14, 6, 'registered a new account.', 'users', '2013-03-23 10:07:56', 0),
(15, 5, 'logged in from: 127.0.0.1', 'users', '2013-03-23 10:14:25', 0),
(16, 5, 'logged out from: 127.0.0.1', 'users', '2013-03-23 10:49:21', 0),
(17, 7, 'registered a new account.', 'users', '2013-03-23 10:49:58', 0),
(18, 8, 'registered a new account.', 'users', '2013-03-23 11:34:00', 0),
(19, 9, 'registered a new account.', 'users', '2013-03-23 11:35:03', 0),
(20, 8, 'logged in from: 127.0.0.1', 'users', '2013-03-23 11:35:58', 0),
(21, 1, 'logged in from: 127.0.0.1', 'users', '2013-03-24 15:56:47', 0),
(22, 1, 'Created record with ID: 3 : 127.0.0.1', 'places', '2013-03-24 15:58:21', 0),
(23, 1, 'Created record with ID: 4 : 127.0.0.1', 'places', '2013-03-24 17:47:13', 0),
(24, 1, 'Created record with ID: 5 : 127.0.0.1', 'places', '2013-03-24 17:49:42', 0),
(25, 1, 'Updated record with ID: 4 : 127.0.0.1', 'places', '2013-03-24 17:58:39', 0),
(26, 1, 'Updated record with ID: 5 : 127.0.0.1', 'places', '2013-03-24 17:59:00', 0),
(27, 1, 'Updated record with ID: 5 : 127.0.0.1', 'places', '2013-03-24 17:59:25', 0);

-- --------------------------------------------------------

--
-- Table structure for table `sp_email_queue`
--

CREATE TABLE IF NOT EXISTS `sp_email_queue` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `to_email` varchar(128) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `alt_message` text,
  `max_attempts` int(11) NOT NULL DEFAULT '3',
  `attempts` int(11) NOT NULL DEFAULT '0',
  `success` tinyint(1) NOT NULL DEFAULT '0',
  `date_published` datetime DEFAULT NULL,
  `last_attempt` datetime DEFAULT NULL,
  `date_sent` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `sp_login_attempts`
--

CREATE TABLE IF NOT EXISTS `sp_login_attempts` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(40) NOT NULL,
  `login` varchar(50) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `sp_permissions`
--

CREATE TABLE IF NOT EXISTS `sp_permissions` (
  `permission_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(100) NOT NULL,
  `status` enum('active','inactive','deleted') DEFAULT 'active',
  PRIMARY KEY (`permission_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=67 ;

--
-- Dumping data for table `sp_permissions`
--

INSERT INTO `sp_permissions` (`permission_id`, `name`, `description`, `status`) VALUES
(1, 'Site.Signin.Allow', 'Allow users to login to the site', 'active'),
(2, 'Site.Content.View', 'Allow users to view the Content Context', 'active'),
(3, 'Site.Reports.View', 'Allow users to view the Reports Context', 'active'),
(4, 'Site.Settings.View', 'Allow users to view the Settings Context', 'active'),
(5, 'Site.Developer.View', 'Allow users to view the Developer Context', 'active'),
(6, 'Bonfire.Roles.Manage', 'Allow users to manage the user Roles', 'active'),
(7, 'Bonfire.Users.Manage', 'Allow users to manage the site Users', 'active'),
(8, 'Bonfire.Users.View', 'Allow users access to the User Settings', 'active'),
(9, 'Bonfire.Users.Add', 'Allow users to add new Users', 'active'),
(10, 'Bonfire.Database.Manage', 'Allow users to manage the Database settings', 'active'),
(11, 'Bonfire.Emailer.Manage', 'Allow users to manage the Emailer settings', 'active'),
(12, 'Bonfire.Logs.View', 'Allow users access to the Log details', 'active'),
(13, 'Bonfire.Logs.Manage', 'Allow users to manage the Log files', 'active'),
(14, 'Bonfire.Emailer.View', 'Allow users access to the Emailer settings', 'active'),
(15, 'Site.Signin.Offline', 'Allow users to login to the site when the site is offline', 'active'),
(16, 'Bonfire.Permissions.View', 'Allow access to view the Permissions menu unders Settings Context', 'active'),
(17, 'Bonfire.Permissions.Manage', 'Allow access to manage the Permissions in the system', 'active'),
(18, 'Bonfire.Roles.Delete', 'Allow users to delete user Roles', 'active'),
(19, 'Bonfire.Modules.Add', 'Allow creation of modules with the builder.', 'active'),
(20, 'Bonfire.Modules.Delete', 'Allow deletion of modules.', 'active'),
(21, 'Permissions.Administrator.Manage', 'To manage the access control permissions for the Administrator role.', 'active'),
(22, 'Permissions.Editor.Manage', 'To manage the access control permissions for the Editor role.', 'active'),
(24, 'Permissions.User.Manage', 'To manage the access control permissions for the User role.', 'active'),
(25, 'Permissions.Developer.Manage', 'To manage the access control permissions for the Developer role.', 'active'),
(27, 'Activities.Own.View', 'To view the users own activity logs', 'active'),
(28, 'Activities.Own.Delete', 'To delete the users own activity logs', 'active'),
(29, 'Activities.User.View', 'To view the user activity logs', 'active'),
(30, 'Activities.User.Delete', 'To delete the user activity logs, except own', 'active'),
(31, 'Activities.Module.View', 'To view the module activity logs', 'active'),
(32, 'Activities.Module.Delete', 'To delete the module activity logs', 'active'),
(33, 'Activities.Date.View', 'To view the users own activity logs', 'active'),
(34, 'Activities.Date.Delete', 'To delete the dated activity logs', 'active'),
(35, 'Bonfire.UI.Manage', 'Manage the Bonfire UI settings', 'active'),
(36, 'Bonfire.Settings.View', 'To view the site settings page.', 'active'),
(37, 'Bonfire.Settings.Manage', 'To manage the site settings.', 'active'),
(38, 'Bonfire.Activities.View', 'To view the Activities menu.', 'active'),
(39, 'Bonfire.Database.View', 'To view the Database menu.', 'active'),
(40, 'Bonfire.Migrations.View', 'To view the Migrations menu.', 'active'),
(41, 'Bonfire.Builder.View', 'To view the Modulebuilder menu.', 'active'),
(42, 'Bonfire.Roles.View', 'To view the Roles menu.', 'active'),
(43, 'Bonfire.Sysinfo.View', 'To view the System Information page.', 'active'),
(44, 'Bonfire.Translate.Manage', 'To manage the Language Translation.', 'active'),
(45, 'Bonfire.Translate.View', 'To view the Language Translate menu.', 'active'),
(46, 'Bonfire.UI.View', 'To view the UI/Keyboard Shortcut menu.', 'active'),
(47, 'Bonfire.Update.Manage', 'To manage the Bonfire Update.', 'active'),
(48, 'Bonfire.Update.View', 'To view the Developer Update menu.', 'active'),
(49, 'Bonfire.Profiler.View', 'To view the Console Profiler Bar.', 'active'),
(50, 'Bonfire.Roles.Add', 'To add New Roles', 'active'),
(51, 'Places.Content.View', '', 'active'),
(52, 'Places.Content.Create', '', 'active'),
(53, 'Places.Content.Edit', '', 'active'),
(54, 'Places.Content.Delete', '', 'active'),
(55, 'Places.Reports.View', '', 'active'),
(56, 'Places.Reports.Create', '', 'active'),
(57, 'Places.Reports.Edit', '', 'active'),
(58, 'Places.Reports.Delete', '', 'active'),
(59, 'Places.Settings.View', '', 'active'),
(60, 'Places.Settings.Create', '', 'active'),
(61, 'Places.Settings.Edit', '', 'active'),
(62, 'Places.Settings.Delete', '', 'active'),
(63, 'Places.Developer.View', '', 'active'),
(64, 'Places.Developer.Create', '', 'active'),
(65, 'Places.Developer.Edit', '', 'active'),
(66, 'Places.Developer.Delete', '', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `sp_places`
--

CREATE TABLE IF NOT EXISTS `sp_places` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `places_name` varchar(255) NOT NULL,
  `places_address` varchar(255) NOT NULL,
  `places_type` varchar(255) NOT NULL,
  `places_longitude` double NOT NULL,
  `places_latitude` double NOT NULL,
  `places_image` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `sp_places`
--

INSERT INTO `sp_places` (`id`, `places_name`, `places_address`, `places_type`, `places_longitude`, `places_latitude`, `places_image`) VALUES
(1, 'dat', 'dat', 'dat', 0, 0, 'dat'),
(2, 'dat1', 'dat1', 'dat1', 0, 0, 'dat1'),
(3, 'test', 'test', 'test', 232.122, 122.222, 'test'),
(4, 'Test1', '1627 Phạm Thế Hiển, 6, Quận 8', 'Test', 106.652648, 10.738832, 'test1'),
(5, 'Test 2', '1649 Phạm Thế Hiển, 6, Quận 8', 'Test', 106.652348, 10.738747, 'Test');

-- --------------------------------------------------------

--
-- Table structure for table `sp_roles`
--

CREATE TABLE IF NOT EXISTS `sp_roles` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(60) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `default` tinyint(1) NOT NULL DEFAULT '0',
  `can_delete` tinyint(1) NOT NULL DEFAULT '1',
  `login_destination` varchar(255) NOT NULL DEFAULT '/',
  `deleted` int(1) NOT NULL DEFAULT '0',
  `default_context` varchar(255) NOT NULL DEFAULT 'content',
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `sp_roles`
--

INSERT INTO `sp_roles` (`role_id`, `role_name`, `description`, `default`, `can_delete`, `login_destination`, `deleted`, `default_context`) VALUES
(1, 'Administrator', 'Has full control over every aspect of the site.', 0, 0, '', 0, 'content'),
(2, 'Editor', 'Can handle day-to-day management, but does not have full power.', 0, 1, '', 0, 'content'),
(4, 'User', 'This is the default user with access to login.', 1, 0, '', 0, 'content'),
(6, 'Developer', 'Developers typically are the only ones that can access the developer tools. Otherwise identical to Administrators, at least until the site is handed off.', 0, 1, '', 0, 'content');

-- --------------------------------------------------------

--
-- Table structure for table `sp_role_permissions`
--

CREATE TABLE IF NOT EXISTS `sp_role_permissions` (
  `role_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  PRIMARY KEY (`role_id`,`permission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sp_role_permissions`
--

INSERT INTO `sp_role_permissions` (`role_id`, `permission_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 7),
(1, 8),
(1, 9),
(1, 10),
(1, 11),
(1, 12),
(1, 13),
(1, 14),
(1, 15),
(1, 16),
(1, 17),
(1, 18),
(1, 19),
(1, 20),
(1, 21),
(1, 22),
(1, 24),
(1, 25),
(1, 27),
(1, 28),
(1, 29),
(1, 30),
(1, 31),
(1, 32),
(1, 33),
(1, 34),
(1, 35),
(1, 36),
(1, 37),
(1, 38),
(1, 39),
(1, 40),
(1, 41),
(1, 42),
(1, 43),
(1, 44),
(1, 45),
(1, 46),
(1, 47),
(1, 48),
(1, 49),
(1, 50),
(1, 51),
(1, 52),
(1, 53),
(1, 54),
(1, 55),
(1, 56),
(1, 57),
(1, 58),
(1, 59),
(1, 60),
(1, 61),
(1, 62),
(1, 63),
(1, 64),
(1, 65),
(1, 66),
(2, 1),
(2, 2),
(2, 3),
(4, 1),
(6, 1),
(6, 2),
(6, 3),
(6, 4),
(6, 5),
(6, 6),
(6, 7),
(6, 8),
(6, 9),
(6, 10),
(6, 11),
(6, 12),
(6, 13),
(6, 49);

-- --------------------------------------------------------

--
-- Table structure for table `sp_schema_version`
--

CREATE TABLE IF NOT EXISTS `sp_schema_version` (
  `type` varchar(40) NOT NULL,
  `version` int(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sp_schema_version`
--

INSERT INTO `sp_schema_version` (`type`, `version`) VALUES
('app_', 0),
('core', 34),
('places_', 2);

-- --------------------------------------------------------

--
-- Table structure for table `sp_sessions`
--

CREATE TABLE IF NOT EXISTS `sp_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text,
  PRIMARY KEY (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sp_settings`
--

CREATE TABLE IF NOT EXISTS `sp_settings` (
  `name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `module` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`name`),
  UNIQUE KEY `unique - name` (`name`),
  KEY `index - name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `sp_settings`
--

INSERT INTO `sp_settings` (`name`, `module`, `value`) VALUES
('auth.allow_name_change', 'core', '1'),
('auth.allow_register', 'core', '1'),
('auth.allow_remember', 'core', '1'),
('auth.do_login_redirect', 'core', '1'),
('auth.login_type', 'core', 'email'),
('auth.name_change_frequency', 'core', '1'),
('auth.name_change_limit', 'core', '1'),
('auth.password_force_mixed_case', 'core', '0'),
('auth.password_force_numbers', 'core', '0'),
('auth.password_force_symbols', 'core', '0'),
('auth.password_min_length', 'core', '8'),
('auth.password_show_labels', 'core', '0'),
('auth.remember_length', 'core', '1209600'),
('auth.use_extended_profile', 'core', '0'),
('auth.use_usernames', 'core', '1'),
('auth.user_activation_method', 'core', '0'),
('form_save', 'core.ui', 'ctrl+s/⌘+s'),
('goto_content', 'core.ui', 'alt+c'),
('mailpath', 'email', '/usr/sbin/sendmail'),
('mailtype', 'email', 'text'),
('protocol', 'email', 'mail'),
('sender_email', 'email', 'me@home.com'),
('site.languages', 'core', 'a:3:{i:0;s:7:"english";i:1;s:10:"portuguese";i:2;s:7:"persian";}'),
('site.list_limit', 'core', '25'),
('site.show_front_profiler', 'core', '1'),
('site.show_profiler', 'core', '1'),
('site.status', 'core', '1'),
('site.system_email', 'core', 'me@home.com'),
('site.title', 'core', 'Spot'),
('smtp_host', 'email', ''),
('smtp_pass', 'email', ''),
('smtp_port', 'email', ''),
('smtp_timeout', 'email', ''),
('smtp_user', 'email', ''),
('updates.bleeding_edge', 'core', '1'),
('updates.do_check', 'core', '1');

-- --------------------------------------------------------

--
-- Table structure for table `sp_spots`
--

CREATE TABLE IF NOT EXISTS `sp_spots` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `spots_user_id` int(11) NOT NULL,
  `spots_place_id` int(11) NOT NULL,
  `checkin_status` tinyint(4) NOT NULL,
  `is_checkin` tinyint(4) NOT NULL,
  `checkin_time` datetime DEFAULT NULL,
  `checkout_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `sp_spots`
--

INSERT INTO `sp_spots` (`id`, `spots_user_id`, `spots_place_id`, `checkin_status`, `is_checkin`, `checkin_time`, `checkout_time`) VALUES
(1, 1, 1, 1, 0, '2013-03-22 00:00:00', '2013-03-23 06:35:43'),
(5, 2, 1, 1, 0, '2013-03-22 17:57:00', '2013-03-23 06:25:16');

-- --------------------------------------------------------

--
-- Table structure for table `sp_users`
--

CREATE TABLE IF NOT EXISTS `sp_users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL DEFAULT '4',
  `email` varchar(120) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `username` varchar(30) NOT NULL DEFAULT '',
  `password_hash` varchar(40) NOT NULL,
  `reset_hash` varchar(40) DEFAULT NULL,
  `salt` varchar(7) NOT NULL,
  `last_login` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_ip` varchar(40) NOT NULL DEFAULT '',
  `created_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `banned` tinyint(1) NOT NULL DEFAULT '0',
  `ban_message` varchar(255) DEFAULT NULL,
  `reset_by` int(10) DEFAULT NULL,
  `display_name` varchar(255) DEFAULT '',
  `display_name_changed` date DEFAULT NULL,
  `timezone` char(4) NOT NULL DEFAULT 'UM6',
  `language` varchar(20) NOT NULL DEFAULT 'english',
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `activate_hash` varchar(40) NOT NULL DEFAULT '',
  `gender` tinyint(6) NOT NULL DEFAULT '0' COMMENT '0:female,1:male',
  `image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `sp_users`
--

INSERT INTO `sp_users` (`id`, `role_id`, `email`, `first_name`, `last_name`, `username`, `password_hash`, `reset_hash`, `salt`, `last_login`, `last_ip`, `created_on`, `deleted`, `banned`, `ban_message`, `reset_by`, `display_name`, `display_name_changed`, `timezone`, `language`, `active`, `activate_hash`, `gender`, `image`) VALUES
(1, 1, 'me@home.com', '', '', 'admin', 'ace1cf1bee204c2270114bb4fb845904a896f0a4', NULL, 'gMSh9Ib', '2013-03-24 15:56:47', '127.0.0.1', '0000-00-00 00:00:00', 0, 0, NULL, NULL, '', NULL, 'UM6', 'english', 1, '', 0, NULL),
(2, 4, 'abc@gmail.com', '', '', '', 'd3c6d2973285cc60fda1995e17b1e3b8db2b15ae', NULL, 'dcRVxZ8', '2013-03-21 16:28:26', '127.0.0.1', '2013-03-21 16:15:40', 0, 0, NULL, NULL, 'abc@gmail.com', NULL, 'UM6', 'english', 1, '', 1, NULL),
(3, 4, 'test@gmail.com', '', '', '', 'd6824ab71a97ccdd8daa6fd51a2ac3a29e780c21', NULL, 'BIPCmNj', '0000-00-00 00:00:00', '', '2013-03-23 08:04:05', 0, 0, NULL, NULL, 'test@gmail.com', NULL, 'UM6', 'english', 1, '', 0, NULL),
(4, 4, 'test111@gmail.com', '', '', '', '207e5cac8b866ab4ef897999ee8f4e31a615a9d1', NULL, 'Y6qFYug', '0000-00-00 00:00:00', '', '2013-03-23 10:02:56', 0, 0, NULL, NULL, 'test111@gmail.com', NULL, 'UM6', 'english', 1, '', 0, NULL),
(5, 4, 'testaaa@gmail.com', '', '', '', '17dafb551512a25c230b448100fdeccc8f03ab19', NULL, 'witYe7m', '2013-03-23 10:14:25', '127.0.0.1', '2013-03-23 10:04:09', 0, 0, NULL, NULL, 'testaaa@gmail.com', NULL, 'UM6', 'english', 1, '', 1, NULL),
(6, 4, 'aaaa@rergg.com', '', '', '', '53bea7619034a83b2ce9928e9a1721f36f46375a', NULL, '3U3bBZ0', '0000-00-00 00:00:00', '', '2013-03-23 10:07:56', 0, 0, NULL, NULL, 'aaaa@rergg.com', NULL, 'UM6', 'english', 1, '', 1, NULL),
(7, 4, '111111@gmail.com', '', '', '', '5e334573f518adb59c8694a7da9d7aaf56be45c9', NULL, 'C2ziJu3', '0000-00-00 00:00:00', '', '2013-03-23 10:49:58', 0, 0, NULL, NULL, '111111@gmail.com', NULL, 'UM6', 'english', 1, '', 0, NULL),
(8, 4, 'aaa@gmail.com', '', '', '', '587f93f67933e1f63fca81760661f061802b8213', NULL, 'gyMJ4Wq', '2013-03-24 15:28:35', '192.168.0.107', '2013-03-23 11:34:00', 0, 0, NULL, NULL, 'aaa@gmail.com', NULL, 'UM6', 'english', 1, '', 1, NULL),
(9, 4, 'aaaaaaaa@gmail.com', '', '', '', '7b38c0503f06516ef9dd3672fb4c128af6a4ced9', NULL, '41OQuwu', '0000-00-00 00:00:00', '', '2013-03-23 11:35:02', 0, 0, NULL, NULL, 'aaaaaaaa@gmail.com', NULL, 'UM6', 'english', 1, '', 0, NULL),
(10, 4, 'data@gmail.com', 'dat', 'vo', '', '094ab8c5a90f9e6f6e547526434a34883e9944ee', NULL, 'jaKYLLl', '0000-00-00 00:00:00', '', '2013-03-24 15:19:34', 0, 0, NULL, NULL, 'data@gmail.com', NULL, 'UM6', 'english', 1, '', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sp_user_cookies`
--

CREATE TABLE IF NOT EXISTS `sp_user_cookies` (
  `user_id` bigint(20) NOT NULL,
  `token` varchar(128) NOT NULL,
  `created_on` datetime NOT NULL,
  KEY `token` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sp_user_meta`
--

CREATE TABLE IF NOT EXISTS `sp_user_meta` (
  `meta_id` int(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(20) unsigned NOT NULL DEFAULT '0',
  `meta_key` varchar(255) NOT NULL DEFAULT '',
  `meta_value` text,
  PRIMARY KEY (`meta_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
