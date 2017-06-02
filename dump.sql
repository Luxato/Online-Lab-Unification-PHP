-- Adminer 4.2.5 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `actualities`;
CREATE TABLE `actualities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `content` text NOT NULL,
  `language` int(11) NOT NULL,
  `category` int(11) NOT NULL,
  `thumbnail_path` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id`),
  KEY `language` (`language`),
  KEY `category` (`category`),
  CONSTRAINT `actualities_ibfk_2` FOREIGN KEY (`category`) REFERENCES `categories` (`id`),
  CONSTRAINT `actualities_ibfk_3` FOREIGN KEY (`language`) REFERENCES `languages` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `actualities` (`id`, `name`, `content`, `language`, `category`, `thumbnail_path`, `created_at`, `updated_at`) VALUES
(13,	'Úvodník',	'                    <p>Toto je testovacia aktualita</p>                ',	0,	1,	'uploads/default.jpg',	'2017-06-01 22:41:12',	'2017-06-01 20:40:56');

DROP TABLE IF EXISTS `apikeys`;
CREATE TABLE `apikeys` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` text NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `apikeys_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `apikeys` (`id`, `key`, `user_id`, `updated_at`, `created_at`) VALUES
(10,	'ac11a2a2c0872bc988a16ffb554f2789',	2,	'2017-06-01 21:23:04',	'2017-04-24 12:41:31');

DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `categories` (`id`, `name`) VALUES
(1,	'Nezaradené');

DROP TABLE IF EXISTS `features`;
CREATE TABLE `features` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `language_id` int(11) NOT NULL,
  `title` text,
  `content_file` text,
  `controller` text,
  PRIMARY KEY (`id`),
  KEY `language_id` (`language_id`),
  CONSTRAINT `features_ibfk_6` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `features` (`id`, `language_id`, `title`, `content_file`, `controller`) VALUES
(24,	0,	'Experimenty',	NULL,	'experiments'),
(25,	0,	'Kontakt',	'contact_sk',	'contact'),
(26,	0,	'Služby',	NULL,	NULL),
(27,	0,	'Online Aplikácie',	NULL,	NULL),
(28,	0,	'Preposielanie formuláru',	'preposielanie_formularu_sk',	'preposielanie_formularu'),
(29,	0,	'Maxima Octave',	'maxima_octave_sk',	'maxima_octave'),
(36,	0,	'Hry',	NULL,	'hry'),
(37,	0,	'Párne alebo Nepárne',	'parne_alebo_neparne_sk',	'parne_alebo_neparne'),
(38,	1,	'Odd or Even',	'parne_alebo_neparne_en',	'odd_or_even'),
(42,	0,	'Anagramy',	'anagramy_sk',	'anagramy'),
(48,	0,	'Aktuality',	NULL,	'aktuality'),
(49,	0,	'Autentifikácia',	NULL,	'cuslogin'),
(50,	1,	'Aktuality',	NULL,	'aktuality'),
(51,	1,	'Autentifikácia',	NULL,	'cuslogin'),
(58,	0,	'LED cube',	'led-cube_sk',	'led-cube'),
(59,	0,	'ITEP2017',	'itep2017_sk',	'itep2017'),
(63,	0,	'Stavový priestor',	'stavovy-priestor_sk',	'stavovy-priestor'),
(98,	0,	'3D model hydraulickej sústavy',	'3d_model_hydraulickej_sustavy_sk',	'3d_model_hydraulickej_sustavy'),
(99,	0,	'3D Model segway vozidla',	'3d_model_segway_vozidla_sk',	'3d_model_segway_vozidla'),
(242,	0,	'Scilab Dokumentácia',	'scilab-dokumentcia_sk',	'scilab-dokumentcia'),
(243,	0,	'Computer Algebra Dokumentácia',	'computer-algebra-dokumentcia_sk',	'computer-algebra-dokumentcia'),
(245,	0,	'Open modelica Dokumentácia',	'open_modelica_dokumentacia_sk',	'open_modelica_dokumentacia'),
(247,	0,	'Tlmený harmonický oscilátor',	'tlmeny-harmonicky-oscilator_sk',	'tlmeny-harmonicky-oscilator'),
(249,	0,	'Teleso medzi stenami',	'teleso-medzi-stenami_sk',	'teleso-medzi-stenami'),
(250,	0,	'2 Oscilátory',	'2-oscilatory_sk',	'2-oscilatory');

DROP TABLE IF EXISTS `feature_page`;
CREATE TABLE `feature_page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `feature_id` int(11) NOT NULL,
  `page_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `feature_id` (`feature_id`),
  KEY `page_id` (`page_id`),
  CONSTRAINT `feature_page_ibfk_2` FOREIGN KEY (`feature_id`) REFERENCES `features` (`id`),
  CONSTRAINT `feature_page_ibfk_3` FOREIGN KEY (`page_id`) REFERENCES `navigation` (`section_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `feature_page` (`id`, `feature_id`, `page_id`) VALUES
(17,	25,	4),
(18,	24,	1),
(19,	26,	2),
(20,	27,	9),
(21,	28,	19),
(22,	29,	20),
(29,	36,	38),
(30,	37,	39),
(31,	38,	39),
(35,	42,	42),
(49,	48,	54),
(50,	50,	54),
(51,	49,	55),
(52,	51,	55),
(59,	58,	61),
(60,	59,	62),
(64,	63,	66),
(97,	98,	76),
(98,	99,	75),
(228,	242,	127),
(229,	243,	128),
(231,	245,	129),
(233,	247,	131),
(235,	249,	133),
(236,	250,	134);

DROP TABLE IF EXISTS `languages`;
CREATE TABLE `languages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `language_title` text NOT NULL,
  `language_shortcut` text NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `languages` (`id`, `language_title`, `language_shortcut`, `updated_at`, `created_at`) VALUES
(0,	'Slovenčina',	'sk',	'2017-03-23 23:40:40',	'0000-00-00 00:00:00'),
(1,	'English',	'en',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00');

DELIMITER ;;

CREATE TRIGGER `delete_actuality_by_lang` BEFORE DELETE ON `languages` FOR EACH ROW
DELETE FROM actualities WHERE language = id;;

CREATE TRIGGER `delete_feature_by_lang` BEFORE DELETE ON `languages` FOR EACH ROW
DELETE FROM features WHERE language_id = id;;

DELIMITER ;

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1,	'2014_10_12_000000_create_users_table',	1),
(2,	'2014_10_12_100000_create_password_resets_table',	1);

DROP TABLE IF EXISTS `navigation`;
CREATE TABLE `navigation` (
  `section_id` int(11) NOT NULL AUTO_INCREMENT,
  `order` int(11) NOT NULL DEFAULT '1',
  `parent_id` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`section_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `navigation` (`section_id`, `order`, `parent_id`, `updated_at`, `created_at`) VALUES
(1,	3,	NULL,	'2017-05-31 21:50:11',	'2017-05-05 16:17:14'),
(2,	4,	NULL,	'2017-05-31 21:50:11',	'2017-05-05 16:17:21'),
(4,	5,	NULL,	'2017-05-31 21:50:11',	'2017-05-05 16:17:26'),
(9,	1,	1,	'2017-05-31 21:50:11',	'2017-05-05 16:17:32'),
(19,	8,	2,	'2017-06-01 16:34:36',	'2017-05-05 16:17:37'),
(20,	9,	2,	'2017-06-01 16:34:36',	'2017-05-05 16:17:43'),
(38,	2,	1,	'2017-05-31 21:50:11',	'2017-04-05 16:12:14'),
(39,	9,	38,	'2017-06-01 20:41:47',	'2017-04-05 16:35:17'),
(42,	10,	38,	'2017-06-01 20:41:47',	'2017-04-20 06:34:21'),
(54,	1,	NULL,	'2017-05-31 21:50:11',	'2017-05-06 15:38:51'),
(55,	2,	NULL,	'2017-05-31 21:50:11',	NULL),
(61,	6,	9,	'2017-06-01 20:41:47',	'2017-05-10 06:34:03'),
(62,	4,	9,	'2017-06-01 19:48:14',	'2017-05-10 06:53:13'),
(66,	5,	9,	'2017-06-01 20:15:33',	'2017-05-10 08:09:18'),
(75,	3,	9,	'2017-06-01 19:48:14',	'2017-05-14 21:09:09'),
(76,	2,	9,	'2017-06-01 19:48:14',	'2017-05-15 14:37:38'),
(127,	4,	2,	'2017-06-01 14:51:16',	'2017-05-31 21:49:40'),
(128,	3,	2,	'2017-06-01 14:51:16',	'2017-05-31 21:51:35'),
(129,	5,	2,	'2017-06-01 14:51:16',	'2017-06-01 14:48:43'),
(131,	1,	9,	'2017-06-01 19:48:14',	'2017-06-01 19:37:37'),
(133,	7,	9,	'2017-06-01 20:41:47',	'2017-06-01 20:15:16'),
(134,	8,	9,	'2017-06-01 20:41:47',	'2017-06-01 20:22:25');

DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `setting_name` text CHARACTER SET utf8mb4 NOT NULL,
  `setting_value` text CHARACTER SET utf8mb4 NOT NULL,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `settings` (`id`, `setting_name`, `setting_value`, `updated_at`) VALUES
(1,	'default_language',	'sk',	'2017-05-14 13:23:36'),
(2,	'landing_page',	'{\"sk\":\"00\",\"en\":\"39\"}',	'2017-05-30 21:09:20');

DROP TABLE IF EXISTS `translations`;
CREATE TABLE `translations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `field` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `translations` (`id`, `field`) VALUES
(0,	'app_name'),
(1,	'login'),
(2,	'sign_in'),
(3,	'email_address'),
(4,	'password'),
(5,	'create_api_key'),
(6,	'logged_user'),
(8,	'actualities'),
(9,	'archive'),
(10,	'create_account'),
(11,	'registration'),
(12,	'create'),
(13,	'close'),
(14,	'or'),
(16,	'create_api_key'),
(17,	'logout'),
(19,	'duplicated_email'),
(20,	'account_created'),
(21,	'blank_page'),
(22,	'wrong_details'),
(23,	'connection_error'),
(24,	'successful_logout'),
(25,	'all_actualities'),
(26,	'empty_actualities'),
(27,	'profile'),
(28,	'edit_profile'),
(29,	'edit'),
(30,	'generate'),
(31,	'mandatory_field'),
(32,	'password_repeat'),
(34,	'home'),
(35,	'loading'),
(36,	'your_api_key');

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` varchar(100) COLLATE utf8_unicode_ci DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `users` (`id`, `name`, `email`, `password`, `type`, `created_at`, `updated_at`, `remember_token`) VALUES
(0,	'Administrátor',	'admin',	'$2y$10$cuOS4zgyuGhcLdPC3Grdje39f9ZwNmQi4bCrWXJLF7GGmEWXTawtS',	'administrator',	'2016-11-01 17:40:40',	'2017-06-01 22:21:24',	'AYSV5oLg0WqWYvir7jE98agoO21U72vHJZDLOWhUeJBj9OqXKAk3tmo0DpUH'),
(2,	'Tester',	'test@test.sk',	'$2y$10$2njrc9WY.aqDFW885jeukuyqEjnP0evDMJct8sHwHq7tGkeWsLQ9W',	'user',	'2017-03-08 21:41:35',	'2017-06-01 21:23:33',	NULL);

DELIMITER ;;

CREATE TRIGGER `delete_api_key_by_user` BEFORE DELETE ON `users` FOR EACH ROW
DELETE FROM apikeys WHERE id = user_id;;

DELIMITER ;

-- 2017-06-02 00:31:20