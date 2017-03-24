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
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  `from` text,
  `to` text,
  PRIMARY KEY (`id`),
  KEY `language` (`language`),
  KEY `category` (`category`),
  CONSTRAINT `actualities_ibfk_1` FOREIGN KEY (`language`) REFERENCES `languages` (`id`),
  CONSTRAINT `actualities_ibfk_2` FOREIGN KEY (`category`) REFERENCES `news_categories` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `actualities` (`id`, `name`, `content`, `language`, `category`, `thumbnail_path`, `created_at`, `updated_at`, `from`, `to`) VALUES
(1,	'testovacia aktualita',	'<p>testovacia aktualita</p>\r\n',	0,	1,	'C:\\wamp64\\www\\Online-Lab-Unification-PHP\\public\\uploads/storage/uploads/aldrin-1489618839.jpg',	'2017-03-14 11:22:58',	'2017-03-14 11:22:58',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(10,	'obrazok',	'<p><img src=\"http://blogs.transparent.com/arabic/files/2016/08/space-624054_960_720.jpg\" /></p>\r\n',	0,	1,	'C:\\wamp64\\www\\Online-Lab-Unification-PHP\\public\\uploads/storage/uploads/aldrin-1489618839.jpg',	'2017-03-15 22:00:39',	'2017-03-15 22:00:39',	NULL,	NULL),
(11,	'Obrazok',	'<p><img src=\"http://blogs.transparent.com/arabic/files/2016/08/space-624054_960_720.jpg\" /></p>\r\n',	0,	1,	'C:\\wamp64\\www\\Online-Lab-Unification-PHP\\public\\uploads/storage/uploads/aldrin-1489618839.jpg',	'2017-03-15 22:01:51',	'2017-03-15 22:01:51',	NULL,	NULL),
(12,	'Druha aktualita',	'<p><img src=\"http://static.srcdn.com/wp-content/uploads/Darth-Vader-Star-Wars-8-Hayden-Christensen.jpg\" /></p>\r\n',	0,	6,	'C:\\wamp64\\www\\Online-Lab-Unification-PHP\\public\\uploads/vader-1489619924.jpg',	'2017-03-15 22:18:44',	'2017-03-15 22:18:44',	NULL,	NULL);

DROP TABLE IF EXISTS `apikeys`;
CREATE TABLE `apikeys` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` text NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `apikeys_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `apikeys` (`id`, `key`, `user_id`) VALUES
(3,	'acjkasnckjasbcakjsbcajskb',	2);

DROP TABLE IF EXISTS `features`;
CREATE TABLE `features` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `language_id` int(11) NOT NULL,
  `title` text,
  `content_file` text,
  `controller` text,
  PRIMARY KEY (`id`),
  KEY `language_id` (`language_id`),
  CONSTRAINT `features_ibfk_1` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `features` (`id`, `language_id`, `title`, `content_file`, `controller`) VALUES
(24,	0,	'Experimenty',	NULL,	'experiments'),
(25,	0,	'Kontakt',	'contact_sk',	'contact'),
(26,	0,	'Služby',	NULL,	NULL),
(27,	0,	'Online Aplikácie',	NULL,	NULL),
(28,	0,	'Preposielanie formuláru',	'preposielanie_formularu_sk',	'preposielanie_formularu'),
(29,	0,	'Maxima Octave',	'maxima_octave_sk',	'maxima_octave'),
(30,	0,	'3D model segway vozidla',	'3D-model-sagway-vozidla_sk',	'3D-model-sagway-vozidla'),
(31,	0,	'3D model hydraulickej sústavy',	'3D-model-hydraulickej-sustavy_sk',	'3D-model-hydraulickej-sustavy');

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
(23,	30,	28),
(24,	31,	29);

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
  `name` text,
  `controller` text,
  `order` int(11) NOT NULL DEFAULT '1',
  `parent_id` int(11) DEFAULT NULL,
  `content_file` text,
  `active` text,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`section_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `navigation` (`section_id`, `name`, `controller`, `order`, `parent_id`, `content_file`, `active`, `updated_at`, `created_at`) VALUES
(1,	'experiments',	'experiments',	1,	NULL,	'',	NULL,	'2016-11-29 20:02:25',	NULL),
(2,	'services',	'services',	2,	NULL,	'',	NULL,	'2016-11-29 20:03:31',	NULL),
(4,	'contact',	'contact',	3,	NULL,	'contact.blade.php',	NULL,	'2016-12-06 07:01:15',	NULL),
(9,	'online_applications',	'online_applications',	1,	1,	'',	NULL,	'2016-11-29 20:03:31',	NULL),
(19,	'Preposielanie formuláru',	'preposielanie_formularu',	2,	2,	'preposielanie_formularu.blade.php',	NULL,	'2016-12-06 07:01:15',	NULL),
(20,	'Maxima Octave',	'maxima_octave',	3,	2,	'maxima_octave.blade.php',	NULL,	'2016-12-06 07:17:43',	NULL),
(28,	'3D model segway vozidla',	'3D-model-sagway-vozidla',	2,	9,	'3D-model-sagway-vozidla.blade.php',	NULL,	'2016-12-06 22:38:58',	NULL),
(29,	'3D model hydraulickej sústavy',	'3D-model-hydraulickej-sustavy',	2,	9,	'3D-model-hydraulickej-sustavy.blade.php',	NULL,	'2016-12-06 22:38:58',	NULL);

DROP TABLE IF EXISTS `news_categories`;
CREATE TABLE `news_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `news_categories` (`id`, `name`) VALUES
(1,	'Nezaradené'),
(2,	'Zaradené'),
(3,	'test'),
(6,	'bla');

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings` (
  `setting_id` int(11) NOT NULL AUTO_INCREMENT,
  `setting_name` text CHARACTER SET utf8mb4 NOT NULL,
  `setting_value` text CHARACTER SET utf8mb4 NOT NULL,
  PRIMARY KEY (`setting_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `settings` (`setting_id`, `setting_name`, `setting_value`) VALUES
(1,	'admin_email',	''),
(2,	'default_language',	''),
(3,	'landing_page',	'32'),
(4,	'default_language',	'sk');

DROP TABLE IF EXISTS `translations`;
CREATE TABLE `translations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `field` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `translations` (`id`, `field`) VALUES
(1,	'login'),
(2,	'sign_in'),
(3,	'email_address'),
(4,	'password'),
(5,	'create_api_key'),
(6,	'logged_user'),
(7,	'forget_the_password'),
(8,	'actualities'),
(9,	'archive'),
(10,	'create_account'),
(11,	'registration'),
(12,	'create'),
(13,	'close'),
(14,	'or'),
(15,	'lost_password'),
(16,	'create_api_key'),
(17,	'logout');

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` varchar(100) COLLATE utf8_unicode_ci DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `users` (`id`, `name`, `email`, `password`, `remember_token`, `type`, `created_at`, `updated_at`) VALUES
(1,	'admin',	'admin',	'$2y$10$RlnNDfEo7DaRHezOb9SlO.aJn36jfmU8KLvF6VVAKZzhfVX/8HEwK',	'1MmxhU7BijWgoOXqPRG2EB96G8lJx6LlABfhD0j4jLmEF8J3gaywmosrpCNX',	'administrator',	'2016-11-01 17:40:40',	'2017-03-23 23:45:11'),
(2,	'Michal',	'test@test.sk',	'$2y$10$RlnNDfEo7DaRHezOb9SlO.aJn36jfmU8KLvF6VVAKZzhfVX/8HEwK',	'ynuLDzn50lvyAJ8kQZM0ugJdQNlIefeHKG6agkQoVFN1CeyNQUOQBZasPGCm',	'user',	'2017-03-08 21:41:35',	'2017-03-09 20:54:14'),
(4,	'tester',	'tester@testovic.sk',	'$2y$10$4WQhgnCi1fu0VuavbNZ/bu7hQOfncn.cNDtOFluqFsxFE9P5mwhjS',	NULL,	'user',	'2017-03-22 19:58:12',	'2017-03-22 19:58:12'),
(5,	'Alfonz',	'al@al.sk',	'$2y$10$WZ15PF1mhbST6TzuGf.hJeNfa.IjPQYH2XJ4IxmbtZffDmv/rCceK',	'lWBAQgtubqxJ73wMrWobitLcUEzsCfULXWBvupuJXhWAyxzNkxrNPjMl8Whv',	'user',	'2017-03-22 21:51:09',	'2017-03-22 21:51:09'),
(6,	'Milan',	'milan@milan.sk',	'$2y$10$9OWNUWROJcqwi3kBMQvA1eeY8KBp5./aEIgRxpCwqXJPN9mP225Pm',	NULL,	'user',	'2017-03-22 22:13:23',	'2017-03-22 22:13:23'),
(7,	'test',	'wetwe@qaca.sk',	'$2y$10$WXOryOaJCzuba/KgOGQbpOccGPduj/gwxJlOfhJ/pfG0wce2HCFnO',	NULL,	'user',	'2017-03-22 22:15:19',	'2017-03-22 22:15:19'),
(8,	'Milos',	'milos@milos.sk',	'$2y$10$WGucHsyvuu6rNbVKX5/nYOo2orNlHECoXJTzUAoY6mG4twIOUmO5K',	NULL,	'user',	'2017-03-22 22:26:27',	'2017-03-22 22:26:27');

-- 2017-03-24 01:05:48