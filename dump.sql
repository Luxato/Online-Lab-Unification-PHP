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
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `from` text,
  `to` text,
  PRIMARY KEY (`id`),
  KEY `language` (`language`),
  KEY `category` (`category`),
  CONSTRAINT `actualities_ibfk_1` FOREIGN KEY (`language`) REFERENCES `languages` (`id`),
  CONSTRAINT `actualities_ibfk_2` FOREIGN KEY (`category`) REFERENCES `categories` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `actualities` (`id`, `name`, `content`, `language`, `category`, `thumbnail_path`, `created_at`, `updated_at`, `from`, `to`) VALUES
(12,	'Druha aktualita',	'<p><img src=\"http://static.srcdn.com/wp-content/uploads/Darth-Vader-Star-Wars-8-Hayden-Christensen.jpg\" /></p>\r\n',	0,	6,	'uploads/img-1491136108.jpg',	'2017-03-15 22:18:44',	'2017-03-15 22:18:44',	NULL,	NULL),
(13,	'Nova aktualita',	'<p>Easy (and free!) You should check out our premium features.</p>',	0,	1,	'uploads/starwars-1491136032.jpg',	'2017-04-02 10:27:12',	'2017-04-02 10:27:12',	NULL,	NULL);

DROP TABLE IF EXISTS `apikeys`;
CREATE TABLE `apikeys` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` text NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `apikeys_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `apikeys` (`id`, `key`, `user_id`, `updated_at`, `created_at`) VALUES
(7,	'dfgdfbdf',	5,	'2017-04-09 17:35:12',	'2017-04-09 17:35:12'),
(8,	'ascascascsacas',	8,	'2017-04-17 16:59:37',	'2017-04-17 16:59:37'),
(10,	'c1d9190bd056897ad12293acd14ab508',	2,	'2017-04-24 12:41:31',	'2017-04-24 12:41:31');

DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `categories` (`id`, `name`) VALUES
(1,	'Nezaradené'),
(2,	'Zaradené'),
(3,	'test'),
(6,	'bla');

DROP TABLE IF EXISTS `features`;
CREATE TABLE `features` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `language_id` int(11) NOT NULL,
  `title` text,
  `content_file` text,
  `controller` text,
  PRIMARY KEY (`id`),
  KEY `language_id` (`language_id`),
  CONSTRAINT `features_ibfk_5` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `features` (`id`, `language_id`, `title`, `content_file`, `controller`) VALUES
(24,	0,	'Experimenty',	NULL,	'experiments'),
(25,	0,	'Kontakt',	'contact_sk',	'contact'),
(26,	0,	'Služby',	NULL,	NULL),
(27,	0,	'Online Aplikácie',	NULL,	NULL),
(28,	0,	'Preposielanie formuláru',	'preposielanie_formularu_sk',	'preposielanie_formularu'),
(29,	0,	'Maxima Octave',	'maxima_octave_sk',	'maxima_octave'),
(31,	0,	'3D model hydraulickej sústavy',	'3D-model-hydraulickej-sustavy_sk',	'3D-model-hydraulickej-sustavy'),
(36,	0,	'Hry',	NULL,	'hry'),
(37,	0,	'Párne alebo Nepárne',	'parne_alebo_neparne_sk',	'parne_alebo_neparne'),
(38,	1,	'Odd or Even',	'parne_alebo_neparne_en',	'odd_or_even'),
(39,	1,	'Only english site',	NULL,	'only_english_site'),
(42,	0,	'Anagramy',	'anagramy_sk',	'anagramy'),
(48,	0,	'Aktuality',	NULL,	'aktuality'),
(49,	0,	'Autentifikácia',	NULL,	'cuslogin'),
(50,	1,	'Aktuality',	NULL,	'aktuality'),
(51,	1,	'Autentifikácia',	NULL,	'cuslogin'),
(57,	0,	'Maxima',	'maxima_sk',	'maxima'),
(58,	0,	'LED cube',	'led-cube_sk',	'led-cube'),
(59,	0,	'ITEP2017',	'itep2017_sk',	'itep2017'),
(60,	0,	'Teleso medzi stenami',	'teleso-medzi-stenami_sk',	'teleso-medzi-stenami'),
(61,	0,	'Scilab',	'scilab_sk',	'scilab'),
(62,	0,	'Algebra API',	'algebra-api_sk',	'algebra-api'),
(63,	0,	'Stavový priestor',	'stavovy-priestor_sk',	'stavovy-priestor'),
(94,	2,	'Aktuality na pevno',	NULL,	'aktuality'),
(96,	0,	'Model segway vozidla',	'model_segway_vozidla_sk',	'model_segway_vozidla');

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
(24,	31,	29),
(29,	36,	38),
(30,	37,	39),
(31,	38,	39),
(32,	39,	40),
(35,	42,	42),
(49,	48,	54),
(50,	50,	54),
(51,	49,	55),
(52,	51,	55),
(58,	57,	60),
(59,	58,	61),
(60,	59,	62),
(61,	60,	63),
(62,	61,	64),
(63,	62,	65),
(64,	63,	66),
(95,	96,	75);

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
(1,	'English',	'en',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(2,	'Japoncina',	'jpa',	'2017-05-14 14:18:38',	'2017-05-14 14:18:38');

DROP TABLE IF EXISTS `logs_authentification`;
CREATE TABLE `logs_authentification` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


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
(1,	3,	NULL,	'2017-05-10 07:00:41',	'2017-05-05 16:17:14'),
(2,	5,	NULL,	'2017-05-10 07:00:41',	'2017-05-05 16:17:21'),
(4,	6,	NULL,	'2017-05-10 07:00:41',	'2017-05-05 16:17:26'),
(9,	1,	1,	'2017-05-05 17:54:49',	'2017-05-05 16:17:32'),
(19,	4,	2,	'2017-05-09 19:11:52',	'2017-05-05 16:17:37'),
(20,	5,	2,	'2017-05-09 19:11:52',	'2017-05-05 16:17:43'),
(29,	8,	9,	'2017-05-10 08:12:02',	'2017-05-05 16:16:51'),
(38,	2,	1,	'2017-05-05 17:54:49',	'2017-04-05 16:12:14'),
(39,	9,	38,	'2017-05-10 08:12:02',	'2017-04-05 16:35:17'),
(40,	4,	NULL,	'2017-05-10 07:00:41',	'2017-04-09 18:09:31'),
(42,	10,	38,	'2017-05-10 08:12:02',	'2017-04-20 06:34:21'),
(54,	1,	NULL,	'2017-05-06 15:38:51',	'2017-05-06 15:38:51'),
(55,	2,	NULL,	'2017-05-10 07:00:41',	NULL),
(60,	3,	2,	'2017-05-09 19:11:52',	'2017-05-09 16:33:30'),
(61,	7,	9,	'2017-05-15 10:08:12',	'2017-05-10 06:34:03'),
(62,	2,	9,	'2017-05-15 10:08:12',	'2017-05-10 06:53:13'),
(63,	3,	9,	'2017-05-15 10:08:12',	'2017-05-10 06:57:28'),
(64,	6,	9,	'2017-05-15 10:08:12',	'2017-05-10 07:38:12'),
(65,	5,	9,	'2017-05-15 10:08:12',	'2017-05-10 08:03:53'),
(66,	4,	9,	'2017-05-15 10:08:12',	'2017-05-10 08:09:18'),
(75,	1,	9,	'2017-05-15 10:08:12',	'2017-05-14 21:09:09');

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
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `setting_name` text CHARACTER SET utf8mb4 NOT NULL,
  `setting_value` text CHARACTER SET utf8mb4 NOT NULL,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `settings` (`id`, `setting_name`, `setting_value`, `updated_at`) VALUES
(1,	'default_language',	'sk',	'2017-05-14 13:23:36'),
(2,	'landing_page',	'{\"sk\":\"00\",\"en\":\"00\"}',	'2017-05-14 14:17:30');

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
(8,	'actualities'),
(9,	'archive'),
(10,	'create_account'),
(11,	'registration'),
(12,	'create'),
(13,	'close'),
(14,	'or'),
(16,	'create_api_key'),
(17,	'logout'),
(18,	'login_google'),
(19,	'duplicated_email'),
(20,	'account_created'),
(21,	'blank_page'),
(22,	'wrong_details'),
(23,	'connection_error'),
(24,	'successful_logout');

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` varchar(100) COLLATE utf8_unicode_ci DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `users` (`id`, `name`, `email`, `password`, `remember_token`, `type`, `created_at`, `updated_at`) VALUES
(0,	'Administrátor',	'admin',	'$2y$10$RlnNDfEo7DaRHezOb9SlO.aJn36jfmU8KLvF6VVAKZzhfVX/8HEwK',	'1ZQYHSHxq08t5mJS6V8JsvubV7aPB1krMUkdm5Qkb2aoUAMH64BZ8TqfeuM2',	'administrator',	'2016-11-01 17:40:40',	'2017-05-05 17:41:46'),
(2,	'Michal',	'test@test.sk',	'$2y$10$HK5ca9YcmmpnN4HRzQvHCOqmHsQNcUCtbwuPToaVnIsDhU7sFTTUy',	'ynuLDzn50lvyAJ8kQZM0ugJdQNlIefeHKG6agkQoVFN1CeyNQUOQBZasPGCm',	'user',	'2017-03-08 21:41:35',	'2017-04-24 12:41:31'),
(5,	'Alfonz',	'al@al.sk',	'$2y$10$C6IYvzYA4cIwJqmHWU3GiubdWQiIOa9lR6wHN5nh5wGJhwbRiwwPm',	'lWBAQgtubqxJ73wMrWobitLcUEzsCfULXWBvupuJXhWAyxzNkxrNPjMl8Whv',	'user',	'2017-03-22 21:51:09',	'2017-04-09 17:38:03'),
(6,	'Milan',	'milan@milan.sk',	'$2y$10$9OWNUWROJcqwi3kBMQvA1eeY8KBp5./aEIgRxpCwqXJPN9mP225Pm',	NULL,	'user',	'2017-03-22 22:13:23',	'2017-03-22 22:13:23'),
(8,	'Milos52',	'milos@milos.cz',	'$2y$10$fZ/sFR/tlgZe4hIW9HzER.5MYYiNBmcTNzXxih7GIKPJgGoJOY4sW',	NULL,	'user',	'2017-03-22 22:26:27',	'2017-04-09 17:34:46'),
(9,	'Juraj',	'juraj@juraj.sk',	'$2y$10$B3QMf2C4vuaS7FkmsCv5TOg9PnAB3OGOUUFGbmAWdvj0f/81zlt2i',	NULL,	'user',	'2017-03-31 18:54:02',	'2017-04-09 17:25:23'),
(11,	'blablabo',	'blabla@ascsa.sk',	'$2y$10$W7uzFh5JN9XCo114HTyIW.HAdnru6xRNkBNb209xtBm41w/JcP52G',	NULL,	'user',	'2017-05-06 12:38:05',	'2017-05-06 12:38:05');

-- 2017-05-15 13:09:47