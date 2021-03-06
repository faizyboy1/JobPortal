-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 29, 2021 at 05:54 PM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 7.4.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `recruit`
--

-- --------------------------------------------------------

--
-- Table structure for table `applicant_notes`
--

CREATE TABLE `applicant_notes` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `job_application_id` int(10) UNSIGNED NOT NULL,
  `note_text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `application_settings`
--

CREATE TABLE `application_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED NOT NULL,
  `legal_term` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mail_setting` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `application_settings`
--

INSERT INTO `application_settings` (`id`, `company_id`, `legal_term`, `mail_setting`, `created_at`, `updated_at`) VALUES
(1, 1, 'If any provision of these Terms and Conditions is held to be invalid or unenforceable, the provision shall be removed (or interpreted, if possible, in a manner as to be enforceable), and the remaining provisions shall be enforced. Headings are for reference purposes only and in no way define, limit, construe or describe the scope or extent of such section. Our failure to act with respect to a breach by you or others does not waive our right to act with respect to subsequent or similar breaches. These Terms and Conditions set forth the entire understanding and agreement between us with respect to the subject matter contained herein and supersede any other agreement, proposals and communications, written or oral, between our representatives and you with respect to the subject matter hereof, including any terms and conditions on any of customer\'s documents or purchase orders.<br>No Joint Venture, No Derogation of Rights. You agree that no joint venture, partnership, employment, or agency relationship exists between you and us as a result of these Terms and Conditions or your use of the Site. Our performance of these Terms and Conditions is subject to existing laws and legal process, and nothing contained herein is in derogation of our right to comply with governmental, court and law enforcement requests or requirements relating to your use of the Site or information provided to or gathered by us with respect to such use.', '{\"1\":{\"name\":\"applied\",\"status\":true},\"2\":{\"name\":\"phone screen\",\"status\":true},\"3\":{\"name\":\"interview\",\"status\":true},\"4\":{\"name\":\"hired\",\"status\":true},\"5\":{\"name\":\"rejected\",\"status\":true}}', '2021-09-22 07:39:43', '2021-09-22 07:39:43');

-- --------------------------------------------------------

--
-- Table structure for table `application_status`
--

CREATE TABLE `application_status` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `position` smallint(6) DEFAULT NULL,
  `color` varchar(12) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `application_status`
--

INSERT INTO `application_status` (`id`, `company_id`, `status`, `slug`, `position`, `color`, `created_at`, `updated_at`) VALUES
(1, 1, 'applied', 'applied', 1, '#2b2b2b', NULL, '2021-09-22 07:39:44'),
(2, 1, 'phone screen', 'phone screen', 2, '#f1e52e', NULL, '2021-09-22 07:39:44'),
(3, 1, 'interview', 'interview', 3, '#3d8ee8', NULL, '2021-09-22 07:39:44'),
(4, 1, 'hired', 'hired', 4, '#32ac16', NULL, '2021-09-22 07:39:44'),
(5, 1, 'rejected', 'rejected', 5, '#ee1127', NULL, '2021-09-22 07:39:44');

-- --------------------------------------------------------

--
-- Table structure for table `client_feedbacks`
--

CREATE TABLE `client_feedbacks` (
  `id` int(10) UNSIGNED NOT NULL,
  `language_settings_id` int(10) UNSIGNED NOT NULL DEFAULT 18,
  `feedback` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `client_title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `client_feedbacks`
--

INSERT INTO `client_feedbacks` (`id`, `language_settings_id`, `feedback`, `client_title`, `created_at`, `updated_at`) VALUES
(1, 18, 'We\'re crazy and obsessed with our hiring process, and Recruit caters exactly to what we need - optimize the shortest way to the best candidates.', 'Froiden - Head of HR', '2021-09-22 07:39:37', '2021-09-22 07:39:37'),
(2, 18, 'Thanks to Recruit, we were easily able to bring all elements of our recruitment together in one place.', 'Tops - Recruitment Manager', '2021-09-22 07:39:37', '2021-09-22 07:39:37');

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` int(10) UNSIGNED NOT NULL,
  `package_id` int(10) UNSIGNED DEFAULT NULL,
  `company_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `locale` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `timezone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Asia/Kolkata',
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `show_in_frontend` enum('true','false') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'true',
  `career_page_link` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `package_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `licence_expire_on` date DEFAULT NULL,
  `job_opening_title` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `job_opening_text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `linkedin` enum('enable','disable') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'disable',
  `stripe_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `card_brand` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `card_last_four` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trial_ends_at` timestamp NULL DEFAULT NULL,
  `featured` tinyint(1) NOT NULL DEFAULT 0,
  `featured_start_date` date DEFAULT NULL,
  `featured_end_date` date DEFAULT NULL,
  `login_background` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delete_account_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `package_id`, `company_name`, `company_email`, `company_phone`, `logo`, `address`, `website`, `locale`, `timezone`, `status`, `show_in_frontend`, `career_page_link`, `created_at`, `updated_at`, `package_type`, `licence_expire_on`, `job_opening_title`, `job_opening_text`, `linkedin`, `stripe_id`, `card_brand`, `card_last_four`, `trial_ends_at`, `featured`, `featured_start_date`, `featured_end_date`, `login_background`, `delete_account_at`) VALUES
(1, 1, 'Froiden Technologies Pvt Ltd', 'company@example.com', '1234512345', NULL, 'Jaipur, India', 'http://www.xyz.com', '', 'Asia/Kolkata', 'active', 'true', 'froiden-technologies-pvt-ltd', '2021-09-22 07:39:35', '2021-09-22 07:39:45', NULL, NULL, 'Working at Froiden!', 'We want people to thrive at Froiden <br>we believe you do your best work when you feel your best.', 'disable', NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `company_packages`
--

CREATE TABLE `company_packages` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED NOT NULL,
  `package_id` int(10) UNSIGNED NOT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `stripe_id` int(11) DEFAULT NULL,
  `paypal_id` int(11) DEFAULT NULL,
  `paypal_environment` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `package_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `company_packages`
--

INSERT INTO `company_packages` (`id`, `company_id`, `package_id`, `status`, `start_date`, `end_date`, `stripe_id`, `paypal_id`, `paypal_environment`, `created_at`, `updated_at`, `package_type`) VALUES
(1, 1, 1, 'active', '2021-09-22', '2021-10-06', NULL, NULL, NULL, '2021-09-22 07:39:45', '2021-09-22 07:39:45', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` int(10) UNSIGNED NOT NULL,
  `country_code` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `country_code`, `country_name`) VALUES
(1, 'AF', 'Afghanistan'),
(2, 'AL', 'Albania'),
(3, 'DZ', 'Algeria'),
(4, 'DS', 'American Samoa'),
(5, 'AD', 'Andorra'),
(6, 'AO', 'Angola'),
(7, 'AI', 'Anguilla'),
(8, 'AQ', 'Antarctica'),
(9, 'AG', 'Antigua and Barbuda'),
(10, 'AR', 'Argentina'),
(11, 'AM', 'Armenia'),
(12, 'AW', 'Aruba'),
(13, 'AU', 'Australia'),
(14, 'AT', 'Austria'),
(15, 'AZ', 'Azerbaijan'),
(16, 'BS', 'Bahamas'),
(17, 'BH', 'Bahrain'),
(18, 'BD', 'Bangladesh'),
(19, 'BB', 'Barbados'),
(20, 'BY', 'Belarus'),
(21, 'BE', 'Belgium'),
(22, 'BZ', 'Belize'),
(23, 'BJ', 'Benin'),
(24, 'BM', 'Bermuda'),
(25, 'BT', 'Bhutan'),
(26, 'BO', 'Bolivia'),
(27, 'BA', 'Bosnia and Herzegovina'),
(28, 'BW', 'Botswana'),
(29, 'BV', 'Bouvet Island'),
(30, 'BR', 'Brazil'),
(31, 'IO', 'British Indian Ocean Territory'),
(32, 'BN', 'Brunei Darussalam'),
(33, 'BG', 'Bulgaria'),
(34, 'BF', 'Burkina Faso'),
(35, 'BI', 'Burundi'),
(36, 'KH', 'Cambodia'),
(37, 'CM', 'Cameroon'),
(38, 'CA', 'Canada'),
(39, 'CV', 'Cape Verde'),
(40, 'KY', 'Cayman Islands'),
(41, 'CF', 'Central African Republic'),
(42, 'TD', 'Chad'),
(43, 'CL', 'Chile'),
(44, 'CN', 'China'),
(45, 'CX', 'Christmas Island'),
(46, 'CC', 'Cocos (Keeling) Islands'),
(47, 'CO', 'Colombia'),
(48, 'KM', 'Comoros'),
(49, 'CG', 'Congo'),
(50, 'CK', 'Cook Islands'),
(51, 'CR', 'Costa Rica'),
(52, 'HR', 'Croatia (Hrvatska)'),
(53, 'CU', 'Cuba'),
(54, 'CY', 'Cyprus'),
(55, 'CZ', 'Czech Republic'),
(56, 'DK', 'Denmark'),
(57, 'DJ', 'Djibouti'),
(58, 'DM', 'Dominica'),
(59, 'DO', 'Dominican Republic'),
(60, 'TP', 'East Timor'),
(61, 'EC', 'Ecuador'),
(62, 'EG', 'Egypt'),
(63, 'SV', 'El Salvador'),
(64, 'GQ', 'Equatorial Guinea'),
(65, 'ER', 'Eritrea'),
(66, 'EE', 'Estonia'),
(67, 'ET', 'Ethiopia'),
(68, 'FK', 'Falkland Islands (Malvinas)'),
(69, 'FO', 'Faroe Islands'),
(70, 'FJ', 'Fiji'),
(71, 'FI', 'Finland'),
(72, 'FR', 'France'),
(73, 'FX', 'France, Metropolitan'),
(74, 'GF', 'French Guiana'),
(75, 'PF', 'French Polynesia'),
(76, 'TF', 'French Southern Territories'),
(77, 'GA', 'Gabon'),
(78, 'GM', 'Gambia'),
(79, 'GE', 'Georgia'),
(80, 'DE', 'Germany'),
(81, 'GH', 'Ghana'),
(82, 'GI', 'Gibraltar'),
(83, 'GK', 'Guernsey'),
(84, 'GR', 'Greece'),
(85, 'GL', 'Greenland'),
(86, 'GD', 'Grenada'),
(87, 'GP', 'Guadeloupe'),
(88, 'GU', 'Guam'),
(89, 'GT', 'Guatemala'),
(90, 'GN', 'Guinea'),
(91, 'GW', 'Guinea-Bissau'),
(92, 'GY', 'Guyana'),
(93, 'HT', 'Haiti'),
(94, 'HM', 'Heard and Mc Donald Islands'),
(95, 'HN', 'Honduras'),
(96, 'HK', 'Hong Kong'),
(97, 'HU', 'Hungary'),
(98, 'IS', 'Iceland'),
(99, 'IN', 'India'),
(100, 'IM', 'Isle of Man'),
(101, 'ID', 'Indonesia'),
(102, 'IR', 'Iran (Islamic Republic of)'),
(103, 'IQ', 'Iraq'),
(104, 'IE', 'Ireland'),
(105, 'IL', 'Israel'),
(106, 'IT', 'Italy'),
(107, 'CI', 'Ivory Coast'),
(108, 'JE', 'Jersey'),
(109, 'JM', 'Jamaica'),
(110, 'JP', 'Japan'),
(111, 'JO', 'Jordan'),
(112, 'KZ', 'Kazakhstan'),
(113, 'KE', 'Kenya'),
(114, 'KI', 'Kiribati'),
(115, 'KP', 'Korea, Democratic People\'s Republic of'),
(116, 'KR', 'Korea, Republic of'),
(117, 'XK', 'Kosovo'),
(118, 'KW', 'Kuwait'),
(119, 'KG', 'Kyrgyzstan'),
(120, 'LA', 'Lao People\'s Democratic Republic'),
(121, 'LV', 'Latvia'),
(122, 'LB', 'Lebanon'),
(123, 'LS', 'Lesotho'),
(124, 'LR', 'Liberia'),
(125, 'LY', 'Libyan Arab Jamahiriya'),
(126, 'LI', 'Liechtenstein'),
(127, 'LT', 'Lithuania'),
(128, 'LU', 'Luxembourg'),
(129, 'MO', 'Macau'),
(130, 'MK', 'Macedonia'),
(131, 'MG', 'Madagascar'),
(132, 'MW', 'Malawi'),
(133, 'MY', 'Malaysia'),
(134, 'MV', 'Maldives'),
(135, 'ML', 'Mali'),
(136, 'MT', 'Malta'),
(137, 'MH', 'Marshall Islands'),
(138, 'MQ', 'Martinique'),
(139, 'MR', 'Mauritania'),
(140, 'MU', 'Mauritius'),
(141, 'TY', 'Mayotte'),
(142, 'MX', 'Mexico'),
(143, 'FM', 'Micronesia, Federated States of'),
(144, 'MD', 'Moldova, Republic of'),
(145, 'MC', 'Monaco'),
(146, 'MN', 'Mongolia'),
(147, 'ME', 'Montenegro'),
(148, 'MS', 'Montserrat'),
(149, 'MA', 'Morocco'),
(150, 'MZ', 'Mozambique'),
(151, 'MM', 'Myanmar'),
(152, 'NA', 'Namibia'),
(153, 'NR', 'Nauru'),
(154, 'NP', 'Nepal'),
(155, 'NL', 'Netherlands'),
(156, 'AN', 'Netherlands Antilles'),
(157, 'NC', 'New Caledonia'),
(158, 'NZ', 'New Zealand'),
(159, 'NI', 'Nicaragua'),
(160, 'NE', 'Niger'),
(161, 'NG', 'Nigeria'),
(162, 'NU', 'Niue'),
(163, 'NF', 'Norfolk Island'),
(164, 'MP', 'Northern Mariana Islands'),
(165, 'NO', 'Norway'),
(166, 'OM', 'Oman'),
(167, 'PK', 'Pakistan'),
(168, 'PW', 'Palau'),
(169, 'PS', 'Palestine'),
(170, 'PA', 'Panama'),
(171, 'PG', 'Papua New Guinea'),
(172, 'PY', 'Paraguay'),
(173, 'PE', 'Peru'),
(174, 'PH', 'Philippines'),
(175, 'PN', 'Pitcairn'),
(176, 'PL', 'Poland'),
(177, 'PT', 'Portugal'),
(178, 'PR', 'Puerto Rico'),
(179, 'QA', 'Qatar'),
(180, 'RE', 'Reunion'),
(181, 'RO', 'Romania'),
(182, 'RU', 'Russian Federation'),
(183, 'RW', 'Rwanda'),
(184, 'KN', 'Saint Kitts and Nevis'),
(185, 'LC', 'Saint Lucia'),
(186, 'VC', 'Saint Vincent and the Grenadines'),
(187, 'WS', 'Samoa'),
(188, 'SM', 'San Marino'),
(189, 'ST', 'Sao Tome and Principe'),
(190, 'SA', 'Saudi Arabia'),
(191, 'SN', 'Senegal'),
(192, 'RS', 'Serbia'),
(193, 'SC', 'Seychelles'),
(194, 'SL', 'Sierra Leone'),
(195, 'SG', 'Singapore'),
(196, 'SK', 'Slovakia'),
(197, 'SI', 'Slovenia'),
(198, 'SB', 'Solomon Islands'),
(199, 'SO', 'Somalia'),
(200, 'ZA', 'South Africa'),
(201, 'GS', 'South Georgia South Sandwich Islands'),
(202, 'ES', 'Spain'),
(203, 'LK', 'Sri Lanka'),
(204, 'SH', 'St. Helena'),
(205, 'PM', 'St. Pierre and Miquelon'),
(206, 'SD', 'Sudan'),
(207, 'SR', 'Suriname'),
(208, 'SJ', 'Svalbard and Jan Mayen Islands'),
(209, 'SZ', 'Swaziland'),
(210, 'SE', 'Sweden'),
(211, 'CH', 'Switzerland'),
(212, 'SY', 'Syrian Arab Republic'),
(213, 'TW', 'Taiwan'),
(214, 'TJ', 'Tajikistan'),
(215, 'TZ', 'Tanzania, United Republic of'),
(216, 'TH', 'Thailand'),
(217, 'TG', 'Togo'),
(218, 'TK', 'Tokelau'),
(219, 'TO', 'Tonga'),
(220, 'TT', 'Trinidad and Tobago'),
(221, 'TN', 'Tunisia'),
(222, 'TR', 'Turkey'),
(223, 'TM', 'Turkmenistan'),
(224, 'TC', 'Turks and Caicos Islands'),
(225, 'TV', 'Tuvalu'),
(226, 'UG', 'Uganda'),
(227, 'UA', 'Ukraine'),
(228, 'AE', 'United Arab Emirates'),
(229, 'GB', 'United Kingdom'),
(230, 'US', 'United States'),
(231, 'UM', 'United States minor outlying islands'),
(232, 'UY', 'Uruguay'),
(233, 'UZ', 'Uzbekistan'),
(234, 'VU', 'Vanuatu'),
(235, 'VA', 'Vatican City State'),
(236, 'VE', 'Venezuela'),
(237, 'VN', 'Vietnam'),
(238, 'VG', 'Virgin Islands (British)'),
(239, 'VI', 'Virgin Islands (U.S.)'),
(240, 'WF', 'Wallis and Futuna Islands'),
(241, 'EH', 'Western Sahara'),
(242, 'YE', 'Yemen'),
(243, 'ZR', 'Zaire'),
(244, 'ZM', 'Zambia'),
(245, 'ZW', 'Zimbabwe');

-- --------------------------------------------------------

--
-- Table structure for table `currencies`
--

CREATE TABLE `currencies` (
  `id` int(10) UNSIGNED NOT NULL,
  `currency_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `currency_symbol` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `currency_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `currencies`
--

INSERT INTO `currencies` (`id`, `currency_name`, `currency_symbol`, `currency_code`, `created_at`, `updated_at`) VALUES
(1, 'Dollars', '$', 'USD', '2021-09-22 07:39:37', '2021-09-22 07:39:37'),
(2, 'Pounds', '??', 'GBP', '2021-09-22 07:39:37', '2021-09-22 07:39:37'),
(3, 'Euros', '???', 'EUR', '2021-09-22 07:39:37', '2021-09-22 07:39:37'),
(4, 'Rupee', '???', 'INR', '2021-09-22 07:39:37', '2021-09-22 07:39:37');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `designations`
--

CREATE TABLE `designations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED NOT NULL,
  `documentable_id` int(11) NOT NULL,
  `documentable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hashname` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `footer_menu`
--

CREATE TABLE `footer_menu` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `language_settings_id` int(10) UNSIGNED NOT NULL DEFAULT 18,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `footer_settings`
--

CREATE TABLE `footer_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `language_settings_id` int(10) UNSIGNED NOT NULL DEFAULT 18,
  `social_links` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `footer_copyright_text` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `footer_settings`
--

INSERT INTO `footer_settings` (`id`, `language_settings_id`, `social_links`, `footer_copyright_text`, `created_at`, `updated_at`) VALUES
(1, 18, '[{\"name\":\"facebook\",\"link\":\"https:\\/\\/facebook.com\"},{\"name\":\"twitter\",\"link\":\"https:\\/\\/twitter.com\"},{\"name\":\"instagram\",\"link\":\"https:\\/\\/instagram.com\"},{\"name\":\"dribbble\",\"link\":\"https:\\/\\/dribbble.com\"}]', 'Copyright ?? 2020. All Rights Reserved', '2021-09-22 07:39:43', '2021-09-22 07:39:43');

-- --------------------------------------------------------

--
-- Table structure for table `front_cms_headers`
--

CREATE TABLE `front_cms_headers` (
  `id` int(10) UNSIGNED NOT NULL,
  `language_settings_id` int(10) UNSIGNED NOT NULL DEFAULT 18,
  `title` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `header_image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `header_background_color` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `header_backround_image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `show_login_in_menu` tinyint(1) NOT NULL,
  `show_register_in_menu` tinyint(1) NOT NULL,
  `show_login_in_header` tinyint(1) NOT NULL,
  `show_register_in_header` tinyint(1) NOT NULL,
  `custom_css` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `call_to_action_title` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `call_to_action_button` enum('login','register') COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_text` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_details` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `login_background` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `register_background` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `front_cms_headers`
--

INSERT INTO `front_cms_headers` (`id`, `language_settings_id`, `title`, `description`, `logo`, `header_image`, `header_background_color`, `header_backround_image`, `show_login_in_menu`, `show_register_in_menu`, `show_login_in_header`, `show_register_in_header`, `custom_css`, `call_to_action_title`, `call_to_action_button`, `contact_text`, `meta_details`, `created_at`, `updated_at`, `login_background`, `register_background`) VALUES
(1, 18, 'Talent Acquisition Platform', 'Powerful software that makes hiring easy.', NULL, NULL, '#4a90e2', NULL, 1, 1, 0, 1, NULL, 'Ready to get started?', 'login', 'Give us a call or drop by anytime, we endeavour to answer all enquiries within 24 hours on business days.', '{\"title\":\"Recruit \\u2013 Recruitment Manager SAAS Version\",\"description\":\"Recruit is an application to manage the recruitment process of a company. If you are a company who need an application through which job seekers can apply directly on your website and you can manage those job applicants from an admin panel then this is the app you need.\",\"keywords\":\"\"}', '2021-09-22 07:39:37', '2021-09-22 07:39:43', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `front_icon_features`
--

CREATE TABLE `front_icon_features` (
  `id` int(10) UNSIGNED NOT NULL,
  `language_settings_id` int(10) UNSIGNED NOT NULL DEFAULT 18,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `front_icon_features`
--

INSERT INTO `front_icon_features` (`id`, `language_settings_id`, `title`, `description`, `icon`, `created_at`, `updated_at`) VALUES
(1, 18, 'Social Media Integration', 'Share jobs on social media from career site.', 'fas fa-share-alt', '2021-09-22 07:39:37', '2021-09-22 07:39:37'),
(2, 18, 'Export to excel', 'Export applicants in excel.', 'far fa-file-excel', '2021-09-22 07:39:37', '2021-09-22 07:39:37'),
(3, 18, 'Quick Filters', 'Add quick filters to narrow your talent pool searches. ', 'fas fa-filter', '2021-09-22 07:39:37', '2021-09-22 07:39:37'),
(4, 18, 'Applicant Rating', 'Quickly evaluate candidates with rating system.', 'fas fa-star', '2021-09-22 07:39:37', '2021-09-22 07:39:37'),
(5, 18, 'Questionnaires', 'Create custom questionnaires for job application form.', 'fas fa-edit', '2021-09-22 07:39:37', '2021-09-22 07:39:37'),
(6, 18, 'Flexible hiring roles', 'Assign flexible hiring roles to your team.', 'fas fa-users', '2021-09-22 07:39:37', '2021-09-22 07:39:37'),
(7, 18, 'Theme Settings', 'Change logo and color of the app according to your branding.', 'fas fa-paint-brush', '2021-09-22 07:39:37', '2021-09-22 07:39:37'),
(8, 18, 'Multiple Languages', 'Recruit is available in multiple languages', 'fas fa-language', '2021-09-22 07:39:37', '2021-09-22 07:39:37');

-- --------------------------------------------------------

--
-- Table structure for table `front_image_features`
--

CREATE TABLE `front_image_features` (
  `id` int(10) UNSIGNED NOT NULL,
  `language_settings_id` int(10) UNSIGNED NOT NULL DEFAULT 18,
  `title` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `front_image_features`
--

INSERT INTO `front_image_features` (`id`, `language_settings_id`, `title`, `description`, `image`, `created_at`, `updated_at`) VALUES
(1, 18, 'Applicant Tracking', 'From screening to hire, view the candidate status through each stage of the recruitment process. ', 'feature-1.png', '2021-09-22 07:39:37', '2021-09-22 07:39:37'),
(2, 18, 'Schedule Interviews', 'Recruit\'s interview scheduler so you never miss out on a great hire', 'feature-2.png', '2021-09-22 07:39:37', '2021-09-22 07:39:37'),
(3, 18, 'Career Website', 'A career website to advertise your jobs and let the candidates apply from it.', 'feature-3.png', '2021-09-22 07:39:37', '2021-09-22 07:39:37');

-- --------------------------------------------------------

--
-- Table structure for table `global_settings`
--

CREATE TABLE `global_settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `currency_id` int(10) UNSIGNED NOT NULL,
  `company_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `website` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `locale` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'en',
  `purchase_code` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `supported_until` timestamp NULL DEFAULT NULL,
  `google_recaptcha_status` tinyint(1) NOT NULL DEFAULT 0,
  `google_recaptcha_key` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `google_recaptcha_secret` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `system_update` tinyint(1) NOT NULL DEFAULT 1,
  `show_review_modal` tinyint(1) NOT NULL DEFAULT 1,
  `delete_account_in` int(11) DEFAULT NULL,
  `delete_account_hour_day` enum('day','hour') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'hour'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `global_settings`
--

INSERT INTO `global_settings` (`id`, `currency_id`, `company_name`, `company_email`, `company_phone`, `logo`, `address`, `website`, `created_at`, `updated_at`, `locale`, `purchase_code`, `supported_until`, `google_recaptcha_status`, `google_recaptcha_key`, `google_recaptcha_secret`, `system_update`, `show_review_modal`, `delete_account_in`, `delete_account_hour_day`) VALUES
(1, 1, 'Froiden', 'company@email.com', '1234567891', NULL, 'Company address', 'www.domain.com', '2021-09-22 07:39:37', '2021-09-22 07:39:37', 'en', NULL, NULL, 0, NULL, NULL, 1, 1, NULL, 'hour');

-- --------------------------------------------------------

--
-- Table structure for table `interview_schedules`
--

CREATE TABLE `interview_schedules` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `job_application_id` int(10) UNSIGNED NOT NULL,
  `schedule_date` datetime NOT NULL,
  `status` enum('rejected','hired','pending','canceled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `interview_type` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_accept_status` enum('accept','refuse','waiting') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'waiting',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `meeting_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `interview_schedule_comments`
--

CREATE TABLE `interview_schedule_comments` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `interview_schedule_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `interview_schedule_employees`
--

CREATE TABLE `interview_schedule_employees` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `interview_schedule_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `user_accept_status` enum('accept','refuse','waiting') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'waiting',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `job_company_id` int(10) UNSIGNED DEFAULT NULL,
  `job_description` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `job_requirement` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_positions` int(11) NOT NULL,
  `location_id` int(10) UNSIGNED DEFAULT NULL,
  `category_id` int(10) UNSIGNED DEFAULT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `status` enum('active','inactive','expired') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `required_columns` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_details` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `section_visibility` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `title`, `slug`, `company_id`, `job_company_id`, `job_description`, `job_requirement`, `total_positions`, `location_id`, `category_id`, `start_date`, `end_date`, `status`, `required_columns`, `meta_details`, `section_visibility`, `created_at`, `updated_at`) VALUES
(1, 'Developer', 'developer-lahore-z7xsgGCk', 1, 1, 'Developer', 'BSCS', 2, 1, 1, '2021-09-28 00:00:00', '2021-10-28 00:00:00', 'active', '{\"gender\":true,\"dob\":true,\"country\":true}', '{\"title\":\"Developer\",\"description\":\"Developer\"}', '{\"profile_image\":\"yes\",\"resume\":\"yes\",\"cover_letter\":\"yes\",\"terms_and_conditions\":\"yes\"}', '2021-09-28 04:28:37', '2021-09-28 04:28:37');

-- --------------------------------------------------------

--
-- Table structure for table `job_applications`
--

CREATE TABLE `job_applications` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `full_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `country` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rating` enum('1','2','3','4','5') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `skills` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `skype_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cover_letter` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `job_id` int(10) UNSIGNED DEFAULT NULL,
  `status_id` int(10) UNSIGNED DEFAULT NULL,
  `is_viewed` tinyint(1) NOT NULL,
  `column_priority` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_application_answers`
--

CREATE TABLE `job_application_answers` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `job_application_id` int(10) UNSIGNED NOT NULL,
  `job_id` int(10) UNSIGNED NOT NULL,
  `question_id` int(10) UNSIGNED NOT NULL,
  `answer` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_categories`
--

CREATE TABLE `job_categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `job_categories`
--

INSERT INTO `job_categories` (`id`, `company_id`, `name`, `created_at`, `updated_at`) VALUES
(1, 1, 'IT', '2021-09-28 04:27:36', '2021-09-28 04:27:36');

-- --------------------------------------------------------

--
-- Table structure for table `job_companies`
--

CREATE TABLE `job_companies` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `company_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `show_in_frontend` enum('true','false') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'true',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `job_companies`
--

INSERT INTO `job_companies` (`id`, `company_id`, `company_name`, `company_email`, `company_phone`, `logo`, `address`, `website`, `status`, `show_in_frontend`, `created_at`, `updated_at`) VALUES
(1, 1, 'Froiden Technologies Pvt Ltd', '', NULL, NULL, NULL, NULL, 'active', 'true', '2021-09-22 07:39:45', '2021-09-22 07:39:45');

-- --------------------------------------------------------

--
-- Table structure for table `job_job_application`
--

CREATE TABLE `job_job_application` (
  `job_application_id` int(10) UNSIGNED NOT NULL,
  `job_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_locations`
--

CREATE TABLE `job_locations` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `location` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `job_locations`
--

INSERT INTO `job_locations` (`id`, `company_id`, `location`, `country_id`, `created_at`, `updated_at`) VALUES
(1, 1, 'Lahore', 167, '2021-09-28 04:27:17', '2021-09-28 04:27:17');

-- --------------------------------------------------------

--
-- Table structure for table `job_questions`
--

CREATE TABLE `job_questions` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `question_id` int(10) UNSIGNED NOT NULL,
  `job_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_skills`
--

CREATE TABLE `job_skills` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `skill_id` int(10) UNSIGNED DEFAULT NULL,
  `job_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `language_settings`
--

CREATE TABLE `language_settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `language_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `language_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('enabled','disabled') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `language_settings`
--

INSERT INTO `language_settings` (`id`, `language_code`, `language_name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'ar', 'Arabic', 'disabled', NULL, NULL),
(2, 'de', 'German', 'disabled', NULL, NULL),
(3, 'es', 'Spanish', 'enabled', NULL, NULL),
(4, 'et', 'Estonian', 'disabled', NULL, NULL),
(5, 'fa', 'Farsi', 'disabled', NULL, NULL),
(6, 'fr', 'French', 'enabled', NULL, NULL),
(7, 'gr', 'Greek', 'disabled', NULL, NULL),
(8, 'it', 'Italian', 'disabled', NULL, NULL),
(9, 'nl', 'Dutch', 'disabled', NULL, NULL),
(10, 'pl', 'Polish', 'disabled', NULL, NULL),
(11, 'pt', 'Portuguese', 'disabled', NULL, NULL),
(12, 'pt-br', 'Portuguese (Brazil)', 'disabled', NULL, NULL),
(13, 'ro', 'Romanian', 'disabled', NULL, NULL),
(14, 'ru', 'Russian', 'enabled', NULL, NULL),
(15, 'tr', 'Turkish', 'disabled', NULL, NULL),
(16, 'zh-CN', 'Chinese (S)', 'disabled', NULL, NULL),
(17, 'zh-TW', 'Chinese (T)', 'disabled', NULL, NULL),
(18, 'en', 'English', 'enabled', '2021-09-22 07:39:43', '2021-09-22 07:39:43');

-- --------------------------------------------------------

--
-- Table structure for table `linked_in_settings`
--

CREATE TABLE `linked_in_settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `client_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `client_secret` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('enable','disable') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'disable',
  `callback_url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `linked_in_settings`
--

INSERT INTO `linked_in_settings` (`id`, `client_id`, `client_secret`, `status`, `callback_url`, `created_at`, `updated_at`) VALUES
(1, '', '', 'disable', '', '2021-09-22 07:39:38', '2021-09-22 07:39:38');

-- --------------------------------------------------------

--
-- Table structure for table `ltm_translations`
--

CREATE TABLE `ltm_translations` (
  `id` int(10) UNSIGNED NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `locale` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `group` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `key` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_04_02_193005_create_translations_table', 1),
(2, '2014_10_12_000000_create_users_table', 1),
(3, '2014_10_12_100000_create_password_resets_table', 1),
(4, '2018_06_03_132522_create_job_categories_table', 1),
(5, '2018_06_04_152857_create_skills_table', 1),
(6, '2018_06_04_154802_create_countries_table', 1),
(7, '2018_06_04_155025_create_job_location_table', 1),
(8, '2018_06_04_162742_create_company_settings_table', 1),
(9, '2018_06_04_171244_create_jobs_table', 1),
(10, '2018_06_04_172111_create_job_skills_table', 1),
(11, '2018_06_04_174729_create_application_status_table', 1),
(12, '2018_06_04_174936_create_job_applications_table', 1),
(13, '2018_06_05_165900_create_tasks_table', 1),
(14, '2018_06_28_191256_create_language_settings_table', 1),
(15, '2018_07_03_054511_entrust_setup_tables', 1),
(16, '2018_07_08_103701_create_modules_table', 1),
(17, '2018_07_09_071111_add_permissions', 1),
(18, '2018_07_11_070438_add_skills_permissions', 1),
(19, '2018_07_11_084527_add_locations_permissions', 1),
(20, '2018_07_11_102717_add_jobs_permissions', 1),
(21, '2018_07_12_190134_add_slug_column_jobs_table', 1),
(22, '2018_07_13_190220_add_job_application_permission', 1),
(23, '2018_07_16_120833_add_column_priority_column_job_applications', 1),
(24, '2018_07_17_053002_add_image_column_users_table', 1),
(25, '2018_07_17_061732_add_team_permission', 1),
(26, '2018_07_17_113611_create_theme_settings_table', 1),
(27, '2018_07_19_064526_create_notifications_table', 1),
(28, '2018_09_11_195258_fix_user_roles', 1),
(29, '2018_10_12_120216_create_smtp_settings_table', 1),
(30, '2018_10_15_120216_create_questions_table', 1),
(31, '2018_10_15_130216_create_job_questions_table', 1),
(32, '2018_10_15_140216_create_job_question_answer_table', 1),
(33, '2018_10_15_261732_add_question_permission', 1),
(34, '2018_10_17_051239_alter_smtp_setting_table', 1),
(35, '2018_10_29_140216_create_interview_schedule_table', 1),
(36, '2018_10_31_061732_add_interview_schedule_permission', 1),
(37, '2018_11_01_140216_create_schedule_employee_table', 1),
(38, '2018_12_08_051239_alter_interview_schedule_table', 1),
(39, '2018_12_08_840216_create_schedule_comment_table', 1),
(40, '2018_12_13_104131_change_cover_letter_column_nullable_job_applications_table', 1),
(41, '2018_12_14_251239_alter_job_application_table', 1),
(42, '2018_12_21_251239_alter_job_application_rating_table', 1),
(43, '2019_03_14_113901_create_companies_table', 1),
(44, '2019_03_14_114823_add_company_id_column', 1),
(45, '2019_03_14_115620_add_company_permissions', 1),
(46, '2019_03_14_131217_add_status_column_companies_table', 1),
(47, '2019_03_16_061717_add_show_in_frontend_column_companies_table', 1),
(48, '2019_04_25_115014_add_company_id_columns', 1),
(49, '2019_04_26_084317_remove_company_permissions', 1),
(50, '2019_05_02_074330_remove_roles_unique', 1),
(51, '2019_05_03_184939_add_columns_company_table', 1),
(52, '2019_05_07_122806_add_is_superadmin_column_users_table', 1),
(53, '2019_05_07_124323_create_currencies_table', 1),
(54, '2019_05_07_130617_create_global_settings_table', 1),
(55, '2019_05_07_140719_add_superadmin_theme_settings', 1),
(56, '2019_05_15_114458_create_front_cms_headers_table', 1),
(57, '2019_05_20_103754_create_front_image_features_table', 1),
(58, '2019_05_20_122429_create_front_icon_features_table', 1),
(59, '2019_05_22_071733_create_client_feedbacks_table', 1),
(60, '2019_05_23_124330_create_packages_table', 1),
(61, '2019_05_28_074135_add_career_page_link_column', 1),
(62, '2019_05_28_111636_create_company_packages_table', 1),
(63, '2019_05_29_115008_add_is_viewed_column_job_applications_table', 1),
(64, '2019_06_02_1165158_create_payment_setting_table', 1),
(65, '2019_06_02_1265158_paypal_invoice_table', 1),
(66, '2019_06_03_115008_alter_company_package_table', 1),
(67, '2019_06_14_034518_create_stripe_invoices_table', 1),
(68, '2019_06_14_1365158_alter_payment_setting_table', 1),
(69, '2019_06_21_121411_add_package_type_column_company_packages_table', 1),
(70, '2019_07_02_110331_add_locale_column_global_settings', 1),
(71, '2019_07_02_111453_add_job_opening_columns_companies_table', 1),
(72, '2019_07_16_133145_add_email_verification_code_column_users_table', 1),
(73, '2019_07_23_110712_check_verify_purchase_file', 1),
(74, '2019_07_23_111456_create_linked_in_settings_table', 1),
(75, '2019_07_23_111459_add_linkedin_columns_to_companies_table', 1),
(76, '2019_08_02_060100_create_applicant_notes_table', 1),
(77, '2019_08_13_073129_update_settings_add_envato_key', 1),
(78, '2019_08_13_073129_update_settings_add_support_key', 1),
(79, '2019_08_28_081847_update_smtp_setting_verified', 1),
(80, '2019_09_05_061905_add_google_recaptcha_key_column_global_settings', 1),
(81, '2019_09_16_081847_add_image_theme_setting_table', 1),
(82, '2019_09_17_095950_create_subscriptions_table', 1),
(83, '2019_09_17_5121902_alter_company_stripe_table', 1),
(84, '2019_09_17_5221902_alter_packages_table', 1),
(85, '2019_09_19_5221902_alter_company_packages_table', 1),
(86, '2019_09_24_5221902_check_paypal_detail_table', 1),
(87, '2019_10_01_062707_create_sms_settings_table', 1),
(88, '2019_10_03_061505_create_sticky_notes_table', 1),
(89, '2019_10_03_084612_add_mobile_related_columns_in_users_table', 1),
(90, '2019_10_21_084622_add_paypal_mode_columns_in_payment_settings_table', 1),
(91, '2019_10_22_085707_create_new_job_email_status_table', 1),
(92, '2019_11_05_1534518_create_razorpay_invoices_table', 1),
(93, '2019_11_05_191818_add_razorpay_detail_in_payment_gateway_credentials_table', 1),
(94, '2019_11_05_295950_create_razorpay_subscriptions_table', 1),
(95, '2019_11_12_054145_add_system_update_column_in_global_settings_table', 1),
(96, '2019_11_29_0974848_create_departments_table', 1),
(97, '2019_11_29_1074848_create_designation_table', 1),
(98, '2019_11_29_1174848_create_onboard_details_table', 1),
(99, '2019_11_29_1274848_create_onboard_files_table', 1),
(100, '2019_12_02_115133_alter_onboard_status_table', 1),
(101, '2019_12_20_115133_alter_company_feature_table', 1),
(102, '2019_12_23_081452_create_todo_items_table', 1),
(103, '2019_12_27_095246_add_english_row_in_language_settings_table', 1),
(104, '2020_01_02_085443_add_gender_age_country_city_columns_to_job_applications_table', 1),
(105, '2020_01_02_090553_add_required_columns_column_in_jobs_table', 1),
(106, '2020_01_10_102309_add_skills_column_in_job_applications_table', 1),
(107, '2020_01_29_123548_create_application_settings_table', 1),
(108, '2020_02_01_101914_update_settings_review', 1),
(109, '2020_04_29_052705_add_mail_setting_column_in_application_settings_table', 1),
(110, '2020_04_29_084637_add_meta_details_and_section_visibility_columns_in_jobs_table', 1),
(111, '2020_04_29_084733_remove_profile_image_show_column_from_application_settings_table', 1),
(112, '2020_04_29_084804_create_documents_table', 1),
(113, '2020_05_06_063651_add_meta_details_column_in_front_cms_headers_table', 1),
(114, '2020_05_07_063651_add_login_image_in_front_cms_headers_table', 1),
(115, '2020_05_08_124243_add_paypal_environment_column_in_company_packages_table', 1),
(116, '2020_05_22_052635_add_position_and_color_columns_in_application_status_table', 1),
(117, '2020_05_27_065948_create_footer_settings_table', 1),
(118, '2020_05_27_104734_create_footer_menu_table', 1),
(119, '2020_05_28_081932_create_seo_details_table', 1),
(120, '2020_06_03_121224_add_language_id_column_in_different_tables', 1),
(121, '2020_07_04_121224_add_delete_account_company_tables', 1),
(122, '2020_07_29_112558_add_default_timezone_company', 1),
(123, '2020_08_18_093240_modify_jobs_status_column', 1),
(124, '2020_09_30_093614_add_slug_column_application_status_table', 1),
(125, '2020_10_07_112558_add_default_timezone_again_company', 1),
(126, '2020_10_08_121750_add_stripe_active_subscription', 1),
(127, '2020_10_14_112558_add_default_timezone_last_company', 1),
(128, '2021_03_24_111009_add_google_recaptcha_key_in_global_settings_table', 1),
(129, '2021_06_21_105749_change_slug_in_jobs_table', 1),
(130, '2021_07_06_044438_create_zoom_meetings_table', 1),
(131, '2021_07_06_045310_create_zoom_settings_table', 1),
(132, '2021_07_06_045757_create_user_zoom_meeting_table', 1),
(133, '2021_07_06_045927_create_zoom_category_table', 1),
(134, '2021_07_06_050209_add_category_id_zoom_meetings_table', 1),
(135, '2021_07_06_051948_add_meeting_app_column_settings_table', 1),
(136, '2021_07_07_090754_add_interview_type_in_interview_schedules_table', 1),
(137, '2021_07_16_084348_add_enable_zoom_column_in_zoom_settings_table', 1),
(138, '2021_07_16_093106_change_interview_type_column_nullable_in_interview_schedules_table', 1),
(139, '2021_07_22_092958_add_rtl_column_in_theme_settings_table', 1),
(140, '2021_08_31_105749_job_opening_heading', 1),
(141, '2021_09_08_124052_create_job_companies_table', 1),
(142, '2021_09_08_155942_add_job_company_id_in_jobs_table', 1),
(143, '2021_09_09_061203_add_company_permission_in_module_table', 1),
(144, '2021_09_17_092509_add_make_private_column_packages_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE `modules` (
  `id` int(10) UNSIGNED NOT NULL,
  `module_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`id`, `module_name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'job categories', '', NULL, NULL),
(2, 'job skills', '', NULL, NULL),
(3, 'job applications', '', NULL, NULL),
(4, 'job locations', '', NULL, NULL),
(6, 'jobs', '', NULL, NULL),
(7, 'settings', '', NULL, NULL),
(8, 'team', '', NULL, NULL),
(9, 'question', '', NULL, NULL),
(10, 'schedule', '', '2021-09-22 07:39:35', '2021-09-22 07:39:35'),
(12, 'job company', '', '2021-09-22 07:39:45', '2021-09-22 07:39:45');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `on_board_details`
--

CREATE TABLE `on_board_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED NOT NULL,
  `job_application_id` int(10) UNSIGNED DEFAULT NULL,
  `designation_id` bigint(20) UNSIGNED DEFAULT NULL,
  `department_id` bigint(20) UNSIGNED DEFAULT NULL,
  `reports_to_id` int(10) UNSIGNED DEFAULT NULL,
  `salary_offered` int(11) NOT NULL,
  `joining_date` date NOT NULL,
  `accept_last_date` date NOT NULL,
  `offer_code` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sign` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reject_reason` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hired_status` enum('offered','accepted','rejected','canceled') COLLATE utf8mb4_unicode_ci NOT NULL,
  `employee_status` enum('part_time','full_time','on_contract') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `on_board_files`
--

CREATE TABLE `on_board_files` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED NOT NULL,
  `on_board_detail_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hash_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `monthly_price` double(8,2) NOT NULL,
  `annual_price` double(8,2) NOT NULL,
  `no_of_job_openings` int(11) DEFAULT NULL,
  `no_of_candidate_access` int(11) DEFAULT NULL,
  `career_website` tinyint(1) NOT NULL,
  `multiple_roles` tinyint(1) NOT NULL,
  `recommended` tinyint(1) NOT NULL,
  `is_trial` tinyint(1) NOT NULL,
  `is_private` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `trial_duration` int(11) NOT NULL,
  `stripe_annual_plan_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `razorpay_annual_plan_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `razorpay_monthly_plan_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stripe_monthly_plan_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billing_cycle` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `packages`
--

INSERT INTO `packages` (`id`, `name`, `description`, `monthly_price`, `annual_price`, `no_of_job_openings`, `no_of_candidate_access`, `career_website`, `multiple_roles`, `recommended`, `is_trial`, `is_private`, `status`, `trial_duration`, `stripe_annual_plan_id`, `razorpay_annual_plan_id`, `razorpay_monthly_plan_id`, `stripe_monthly_plan_id`, `billing_cycle`, `created_at`, `updated_at`) VALUES
(1, 'Trial Package', 'description', 0.00, 0.00, NULL, NULL, 1, 1, 0, 1, 0, 1, 14, NULL, NULL, NULL, NULL, 0, '2021-09-22 07:39:37', '2021-09-22 07:39:37'),
(2, 'Professional', 'description', 20.00, 200.00, 4, 100, 0, 0, 0, 0, 0, 1, 0, NULL, NULL, NULL, NULL, 0, '2021-09-22 07:39:37', '2021-09-22 07:39:37'),
(3, 'Expert', 'description', 40.00, 420.00, 10, 500, 1, 1, 1, 0, 0, 1, 0, NULL, NULL, NULL, NULL, 0, '2021-09-22 07:39:37', '2021-09-22 07:39:37'),
(4, 'Corporate', 'description', 40.00, 420.00, NULL, NULL, 1, 1, 0, 0, 0, 1, 0, NULL, NULL, NULL, NULL, 0, '2021-09-22 07:39:37', '2021-09-22 07:39:37');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_settings`
--

CREATE TABLE `payment_settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `paypal_client_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `paypal_secret` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `api_key` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `api_secret` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `webhook_key` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `paypal_status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'inactive',
  `stripe_status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'inactive',
  `razorpay_key` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `razorpay_secret` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `razorpay_webhook_secret` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `razorpay_status` enum('active','deactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'deactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `paypal_mode` enum('sandbox','live') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'sandbox'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_settings`
--

INSERT INTO `payment_settings` (`id`, `paypal_client_id`, `paypal_secret`, `api_key`, `api_secret`, `webhook_key`, `paypal_status`, `stripe_status`, `razorpay_key`, `razorpay_secret`, `razorpay_webhook_secret`, `razorpay_status`, `created_at`, `updated_at`, `paypal_mode`) VALUES
(1, NULL, NULL, NULL, NULL, NULL, 'inactive', 'inactive', NULL, NULL, NULL, 'deactive', '2021-09-22 07:39:37', '2021-09-22 07:39:37', 'sandbox');

-- --------------------------------------------------------

--
-- Table structure for table `paypal_invoices`
--

CREATE TABLE `paypal_invoices` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `currency_id` int(10) UNSIGNED DEFAULT NULL,
  `package_id` int(10) UNSIGNED DEFAULT NULL,
  `sub_total` double DEFAULT NULL,
  `total` double DEFAULT NULL,
  `transaction_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remarks` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billing_frequency` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billing_interval` int(11) DEFAULT NULL,
  `paid_on` datetime DEFAULT NULL,
  `next_pay_date` datetime DEFAULT NULL,
  `recurring` enum('yes','no') COLLATE utf8mb4_unicode_ci DEFAULT 'no',
  `status` enum('paid','unpaid','pending') COLLATE utf8mb4_unicode_ci DEFAULT 'pending',
  `plan_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `event_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `end_on` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `module_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `display_name`, `description`, `module_id`, `created_at`, `updated_at`) VALUES
(1, 'add_category', 'Add Category', NULL, 1, '2021-09-22 07:39:34', '2021-09-22 07:39:34'),
(2, 'view_category', 'View Category', NULL, 1, '2021-09-22 07:39:34', '2021-09-22 07:39:34'),
(3, 'edit_category', 'Edit Category', NULL, 1, '2021-09-22 07:39:34', '2021-09-22 07:39:34'),
(4, 'delete_category', 'Delete Category', NULL, 1, '2021-09-22 07:39:34', '2021-09-22 07:39:34'),
(5, 'manage_settings', 'Manage Settings', NULL, 7, '2021-09-22 07:39:34', '2021-09-22 07:39:34'),
(6, 'add_skills', 'Add Skills', NULL, 2, '2021-09-22 07:39:34', '2021-09-22 07:39:34'),
(7, 'view_skills', 'View Skills', NULL, 2, '2021-09-22 07:39:34', '2021-09-22 07:39:34'),
(8, 'edit_skills', 'Edit Skills', NULL, 2, '2021-09-22 07:39:34', '2021-09-22 07:39:34'),
(9, 'delete_skills', 'Delete Skills', NULL, 2, '2021-09-22 07:39:34', '2021-09-22 07:39:34'),
(10, 'add_locations', 'Add Location', NULL, 4, '2021-09-22 07:39:34', '2021-09-22 07:39:34'),
(11, 'view_locations', 'View Location', NULL, 4, '2021-09-22 07:39:34', '2021-09-22 07:39:34'),
(12, 'edit_locations', 'Edit Location', NULL, 4, '2021-09-22 07:39:34', '2021-09-22 07:39:34'),
(13, 'delete_locations', 'Delete Location', NULL, 4, '2021-09-22 07:39:34', '2021-09-22 07:39:34'),
(14, 'add_jobs', 'Add Jobs', NULL, 6, '2021-09-22 07:39:34', '2021-09-22 07:39:34'),
(15, 'view_jobs', 'View Jobs', NULL, 6, '2021-09-22 07:39:34', '2021-09-22 07:39:34'),
(16, 'edit_jobs', 'Edit Jobs', NULL, 6, '2021-09-22 07:39:34', '2021-09-22 07:39:34'),
(17, 'delete_jobs', 'Delete Jobs', NULL, 6, '2021-09-22 07:39:34', '2021-09-22 07:39:34'),
(18, 'add_job_applications', 'Add Job Applications', NULL, 3, '2021-09-22 07:39:34', '2021-09-22 07:39:34'),
(19, 'view_job_applications', 'View Job Applications', NULL, 3, '2021-09-22 07:39:34', '2021-09-22 07:39:34'),
(20, 'edit_job_applications', 'Edit Job Applications', NULL, 3, '2021-09-22 07:39:34', '2021-09-22 07:39:34'),
(21, 'delete_job_applications', 'Delete Job Applications', NULL, 3, '2021-09-22 07:39:34', '2021-09-22 07:39:34'),
(22, 'add_team', 'Add Team', NULL, 8, '2021-09-22 07:39:34', '2021-09-22 07:39:34'),
(23, 'view_team', 'View Team', NULL, 8, '2021-09-22 07:39:34', '2021-09-22 07:39:34'),
(24, 'edit_team', 'Edit Team', NULL, 8, '2021-09-22 07:39:34', '2021-09-22 07:39:34'),
(25, 'delete_team', 'Delete Team', NULL, 8, '2021-09-22 07:39:34', '2021-09-22 07:39:34'),
(26, 'add_question', 'Add Question', NULL, 9, '2021-09-22 07:39:35', '2021-09-22 07:39:35'),
(27, 'view_question', 'View Question', NULL, 9, '2021-09-22 07:39:35', '2021-09-22 07:39:35'),
(28, 'edit_question', 'Edit Question', NULL, 9, '2021-09-22 07:39:35', '2021-09-22 07:39:35'),
(29, 'delete_question', 'Delete Question', NULL, 9, '2021-09-22 07:39:35', '2021-09-22 07:39:35'),
(30, 'add_schedule', 'Add Schedule', NULL, 10, '2021-09-22 07:39:35', '2021-09-22 07:39:35'),
(31, 'view_schedule', 'View Schedule', NULL, 10, '2021-09-22 07:39:35', '2021-09-22 07:39:35'),
(32, 'edit_schedule', 'Edit Schedule', NULL, 10, '2021-09-22 07:39:35', '2021-09-22 07:39:35'),
(33, 'delete_schedule', 'Delete Schedule', NULL, 10, '2021-09-22 07:39:35', '2021-09-22 07:39:35'),
(38, 'add_job_company', 'Add Job Company', NULL, 12, '2021-09-22 07:39:45', '2021-09-22 07:39:45'),
(39, 'view_job_company', 'View Job Company', NULL, 12, '2021-09-22 07:39:45', '2021-09-22 07:39:45'),
(40, 'edit_job_company', 'Edit Job Company', NULL, 12, '2021-09-22 07:39:45', '2021-09-22 07:39:45'),
(41, 'delete_job_company', 'Delete Job Company', NULL, 12, '2021-09-22 07:39:45', '2021-09-22 07:39:45');

-- --------------------------------------------------------

--
-- Table structure for table `permission_role`
--

CREATE TABLE `permission_role` (
  `permission_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permission_role`
--

INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(20, 1),
(21, 1),
(22, 1),
(23, 1),
(24, 1),
(25, 1),
(26, 1),
(27, 1),
(28, 1),
(29, 1),
(30, 1),
(31, 1),
(32, 1),
(33, 1),
(38, 1),
(39, 1),
(40, 1),
(41, 1);

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `question` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('enable','disable') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'enable',
  `required` enum('yes','no') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'no',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `razorpay_invoices`
--

CREATE TABLE `razorpay_invoices` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED NOT NULL,
  `currency_id` int(11) DEFAULT NULL,
  `invoice_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subscription_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `package_id` int(10) UNSIGNED NOT NULL,
  `transaction_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(12,2) UNSIGNED NOT NULL,
  `pay_date` date NOT NULL,
  `next_pay_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `razorpay_subscriptions`
--

CREATE TABLE `razorpay_subscriptions` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED NOT NULL,
  `subscription_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customer_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `razorpay_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `razorpay_plan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int(11) NOT NULL,
  `trial_ends_at` timestamp NULL DEFAULT NULL,
  `ends_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `company_id`, `name`, `display_name`, `description`, `created_at`, `updated_at`) VALUES
(1, 1, 'admin', 'App Administrator', 'Admin is allowed to manage everything of the app.', '2021-09-22 07:39:34', '2021-09-22 07:39:36');

-- --------------------------------------------------------

--
-- Table structure for table `role_user`
--

CREATE TABLE `role_user` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_user`
--

INSERT INTO `role_user` (`user_id`, `role_id`) VALUES
(2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `seo_details`
--

CREATE TABLE `seo_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `footer_menu_id` bigint(20) UNSIGNED NOT NULL,
  `seo_title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seo_keywords` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seo_description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seo_author` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `skills`
--

CREATE TABLE `skills` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sms_settings`
--

CREATE TABLE `sms_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nexmo_status` enum('active','deactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'deactive',
  `nexmo_key` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nexmo_secret` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nexmo_from` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT 'NEXMO',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sms_settings`
--

INSERT INTO `sms_settings` (`id`, `nexmo_status`, `nexmo_key`, `nexmo_secret`, `nexmo_from`, `created_at`, `updated_at`) VALUES
(1, 'deactive', NULL, NULL, 'NEXMO', '2021-09-22 07:39:41', '2021-09-22 07:39:41');

-- --------------------------------------------------------

--
-- Table structure for table `smtp_settings`
--

CREATE TABLE `smtp_settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `mail_driver` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'smtp',
  `mail_host` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'smtp.gmail.com',
  `mail_port` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '587',
  `mail_username` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'youremail@gmail.com',
  `mail_password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'your password',
  `mail_from_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Recruit Saas',
  `mail_from_email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'admin@example.com',
  `mail_encryption` enum('tls','ssl') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `verified` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `smtp_settings`
--

INSERT INTO `smtp_settings` (`id`, `mail_driver`, `mail_host`, `mail_port`, `mail_username`, `mail_password`, `mail_from_name`, `mail_from_email`, `mail_encryption`, `created_at`, `updated_at`, `verified`) VALUES
(1, 'smtp', 'smtp.gmail.com', '587', 'youremail@gmail.com', 'your password', 'Recruit Saas', 'admin@example.com', 'tls', '2021-09-22 07:39:34', '2021-09-22 07:39:34', 0);

-- --------------------------------------------------------

--
-- Table structure for table `sticky_notes`
--

CREATE TABLE `sticky_notes` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `note_text` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `colour` enum('blue','yellow','red','gray','purple','green') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'blue',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stripe_invoices`
--

CREATE TABLE `stripe_invoices` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED NOT NULL,
  `invoice_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `package_id` int(10) UNSIGNED NOT NULL,
  `transaction_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` decimal(12,2) UNSIGNED NOT NULL,
  `pay_date` date NOT NULL,
  `next_pay_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

CREATE TABLE `subscriptions` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stripe_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stripe_plan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int(11) NOT NULL,
  `trial_ends_at` timestamp NULL DEFAULT NULL,
  `ends_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `stripe_status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `due_date` datetime NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `theme_settings`
--

CREATE TABLE `theme_settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `primary_color` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `admin_custom_css` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `front_custom_css` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `home_background_image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `rtl` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `theme_settings`
--

INSERT INTO `theme_settings` (`id`, `company_id`, `primary_color`, `admin_custom_css`, `front_custom_css`, `home_background_image`, `created_at`, `updated_at`, `rtl`) VALUES
(1, 1, '#1579d0', '/*Enter your custom css after this line*/ \n        .sidebar-dark-primary {\n           background-image: linear-gradient(to top, #00c6fb 0%, #005bea 100%);\n        }', NULL, NULL, '2021-09-22 07:39:34', '2021-09-22 07:39:36', 0),
(2, NULL, '#1579d0', '/*Enter your custom css after this line*/ \n        .sidebar-dark-primary {\n           background-image: linear-gradient(to top, #00c6fb 0%, #005bea 100%);\n        }', NULL, NULL, '2021-09-22 07:39:37', '2021-09-22 07:39:37', 0);

-- --------------------------------------------------------

--
-- Table structure for table `todo_items`
--

CREATE TABLE `todo_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('pending','completed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `position` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `calling_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile_verified` tinyint(1) NOT NULL DEFAULT 0,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_superadmin` tinyint(1) NOT NULL DEFAULT 0,
  `email_verification_code` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `company_id`, `name`, `email`, `calling_code`, `mobile`, `mobile_verified`, `password`, `remember_token`, `created_at`, `updated_at`, `image`, `is_superadmin`, `email_verification_code`, `status`) VALUES
(1, NULL, 'Superadmin name', 'superadmin@example.com', NULL, NULL, 0, '$2y$10$u9qn58il66x5rBN1XH5s6uWV4zdh6nJnbZDj5owjuF7vZHH9xHo7q', NULL, '2021-09-22 07:39:37', '2021-09-22 07:39:37', NULL, 1, NULL, 'active'),
(2, 1, 'Admin', 'admin@example.com', NULL, NULL, 0, '$2y$10$v2Wt8lYUggYY3KT0bQX2tuE.9p3io7ByJGMuLWy88pJzAXwZYtM7G', NULL, '2021-09-22 07:39:45', '2021-09-22 07:39:45', NULL, 0, NULL, 'active');

-- --------------------------------------------------------

--
-- Table structure for table `user_zoom_meeting`
--

CREATE TABLE `user_zoom_meeting` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `zoom_meeting_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `zoom_categories`
--

CREATE TABLE `zoom_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `category_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `zoom_meetings`
--

CREATE TABLE `zoom_meetings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `meeting_id` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `meeting_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `label_color` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_date_time` datetime NOT NULL,
  `end_date_time` datetime NOT NULL,
  `repeat` tinyint(1) NOT NULL DEFAULT 0,
  `repeat_every` int(11) DEFAULT NULL,
  `repeat_cycles` int(11) DEFAULT NULL,
  `repeat_type` enum('day','week','month','year') COLLATE utf8mb4_unicode_ci NOT NULL,
  `send_reminder` tinyint(1) NOT NULL DEFAULT 0,
  `remind_time` int(11) DEFAULT NULL,
  `remind_type` enum('day','hour','minute') COLLATE utf8mb4_unicode_ci NOT NULL,
  `host_video` tinyint(1) NOT NULL DEFAULT 0,
  `participant_video` tinyint(1) NOT NULL DEFAULT 0,
  `start_link` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `join_link` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `source_meeting_id` bigint(20) UNSIGNED DEFAULT NULL,
  `occurrence_id` bigint(20) DEFAULT NULL,
  `occurrence_order` int(11) DEFAULT NULL,
  `status` enum('waiting','live','canceled','finished') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'waiting',
  `password` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `zoom_settings`
--

CREATE TABLE `zoom_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `api_key` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `secret_key` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `purchase_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `supported_until` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `meeting_app` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'in_app',
  `enable_zoom` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `zoom_settings`
--

INSERT INTO `zoom_settings` (`id`, `company_id`, `api_key`, `secret_key`, `purchase_code`, `supported_until`, `created_at`, `updated_at`, `meeting_app`, `enable_zoom`) VALUES
(1, 1, NULL, NULL, NULL, NULL, '2021-09-22 07:39:44', '2021-09-22 07:39:44', 'in_app', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `applicant_notes`
--
ALTER TABLE `applicant_notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `applicant_notes_user_id_foreign` (`user_id`),
  ADD KEY `applicant_notes_job_application_id_foreign` (`job_application_id`);

--
-- Indexes for table `application_settings`
--
ALTER TABLE `application_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `application_settings_company_id_foreign` (`company_id`);

--
-- Indexes for table `application_status`
--
ALTER TABLE `application_status`
  ADD PRIMARY KEY (`id`),
  ADD KEY `application_status_company_id_foreign` (`company_id`);

--
-- Indexes for table `client_feedbacks`
--
ALTER TABLE `client_feedbacks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_feedbacks_language_settings_id_foreign` (`language_settings_id`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `companies_career_page_link_unique` (`career_page_link`),
  ADD KEY `companies_package_id_foreign` (`package_id`);

--
-- Indexes for table `company_packages`
--
ALTER TABLE `company_packages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_packages_company_id_foreign` (`company_id`),
  ADD KEY `company_packages_package_id_foreign` (`package_id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `currencies`
--
ALTER TABLE `currencies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `departments_company_id_foreign` (`company_id`);

--
-- Indexes for table `designations`
--
ALTER TABLE `designations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `designations_company_id_foreign` (`company_id`);

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_document` (`company_id`,`documentable_id`,`documentable_type`,`name`);

--
-- Indexes for table `footer_menu`
--
ALTER TABLE `footer_menu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `footer_menu_language_settings_id_foreign` (`language_settings_id`);

--
-- Indexes for table `footer_settings`
--
ALTER TABLE `footer_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `footer_settings_language_settings_id_foreign` (`language_settings_id`);

--
-- Indexes for table `front_cms_headers`
--
ALTER TABLE `front_cms_headers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `front_cms_headers_language_settings_id_foreign` (`language_settings_id`);

--
-- Indexes for table `front_icon_features`
--
ALTER TABLE `front_icon_features`
  ADD PRIMARY KEY (`id`),
  ADD KEY `front_icon_features_language_settings_id_foreign` (`language_settings_id`);

--
-- Indexes for table `front_image_features`
--
ALTER TABLE `front_image_features`
  ADD PRIMARY KEY (`id`),
  ADD KEY `front_image_features_language_settings_id_foreign` (`language_settings_id`);

--
-- Indexes for table `global_settings`
--
ALTER TABLE `global_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `global_settings_currency_id_foreign` (`currency_id`);

--
-- Indexes for table `interview_schedules`
--
ALTER TABLE `interview_schedules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `interview_schedules_job_application_id_foreign` (`job_application_id`),
  ADD KEY `interview_schedules_company_id_foreign` (`company_id`),
  ADD KEY `interview_schedules_meeting_id_foreign` (`meeting_id`);

--
-- Indexes for table `interview_schedule_comments`
--
ALTER TABLE `interview_schedule_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `interview_schedule_comments_interview_schedule_id_foreign` (`interview_schedule_id`),
  ADD KEY `interview_schedule_comments_user_id_foreign` (`user_id`),
  ADD KEY `interview_schedule_comments_company_id_foreign` (`company_id`);

--
-- Indexes for table `interview_schedule_employees`
--
ALTER TABLE `interview_schedule_employees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `interview_schedule_employees_interview_schedule_id_foreign` (`interview_schedule_id`),
  ADD KEY `interview_schedule_employees_user_id_foreign` (`user_id`),
  ADD KEY `interview_schedule_employees_company_id_foreign` (`company_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_location_id_foreign` (`location_id`),
  ADD KEY `jobs_category_id_foreign` (`category_id`),
  ADD KEY `jobs_company_id_foreign` (`company_id`),
  ADD KEY `jobs_job_company_id_foreign` (`job_company_id`);

--
-- Indexes for table `job_applications`
--
ALTER TABLE `job_applications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `job_applications_job_id_foreign` (`job_id`),
  ADD KEY `job_applications_status_id_foreign` (`status_id`),
  ADD KEY `job_applications_company_id_foreign` (`company_id`);

--
-- Indexes for table `job_application_answers`
--
ALTER TABLE `job_application_answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `job_application_answers_job_application_id_foreign` (`job_application_id`),
  ADD KEY `job_application_answers_job_id_foreign` (`job_id`),
  ADD KEY `job_application_answers_question_id_foreign` (`question_id`),
  ADD KEY `job_application_answers_company_id_foreign` (`company_id`);

--
-- Indexes for table `job_categories`
--
ALTER TABLE `job_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `job_categories_company_id_foreign` (`company_id`);

--
-- Indexes for table `job_companies`
--
ALTER TABLE `job_companies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `job_companies_company_id_foreign` (`company_id`);

--
-- Indexes for table `job_job_application`
--
ALTER TABLE `job_job_application`
  ADD KEY `job_job_application_job_application_id_foreign` (`job_application_id`),
  ADD KEY `job_job_application_job_id_foreign` (`job_id`);

--
-- Indexes for table `job_locations`
--
ALTER TABLE `job_locations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `job_locations_country_id_foreign` (`country_id`),
  ADD KEY `job_locations_company_id_foreign` (`company_id`);

--
-- Indexes for table `job_questions`
--
ALTER TABLE `job_questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `job_questions_question_id_foreign` (`question_id`),
  ADD KEY `job_questions_job_id_foreign` (`job_id`),
  ADD KEY `job_questions_company_id_foreign` (`company_id`);

--
-- Indexes for table `job_skills`
--
ALTER TABLE `job_skills`
  ADD PRIMARY KEY (`id`),
  ADD KEY `job_skills_skill_id_foreign` (`skill_id`),
  ADD KEY `job_skills_job_id_foreign` (`job_id`),
  ADD KEY `job_skills_company_id_foreign` (`company_id`);

--
-- Indexes for table `language_settings`
--
ALTER TABLE `language_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `linked_in_settings`
--
ALTER TABLE `linked_in_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ltm_translations`
--
ALTER TABLE `ltm_translations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `modules`
--
ALTER TABLE `modules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `on_board_details`
--
ALTER TABLE `on_board_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `on_board_details_company_id_foreign` (`company_id`),
  ADD KEY `on_board_details_job_application_id_foreign` (`job_application_id`),
  ADD KEY `on_board_details_designation_id_foreign` (`designation_id`),
  ADD KEY `on_board_details_department_id_foreign` (`department_id`),
  ADD KEY `on_board_details_reports_to_id_foreign` (`reports_to_id`);

--
-- Indexes for table `on_board_files`
--
ALTER TABLE `on_board_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `on_board_files_company_id_foreign` (`company_id`),
  ADD KEY `on_board_files_on_board_detail_id_foreign` (`on_board_detail_id`);

--
-- Indexes for table `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `payment_settings`
--
ALTER TABLE `payment_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `paypal_invoices`
--
ALTER TABLE `paypal_invoices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `paypal_invoices_company_id_foreign` (`company_id`),
  ADD KEY `paypal_invoices_currency_id_foreign` (`currency_id`),
  ADD KEY `paypal_invoices_package_id_foreign` (`package_id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_unique` (`name`),
  ADD KEY `permissions_module_id_foreign` (`module_id`);

--
-- Indexes for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `permission_role_role_id_foreign` (`role_id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `questions_company_id_foreign` (`company_id`);

--
-- Indexes for table `razorpay_invoices`
--
ALTER TABLE `razorpay_invoices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `razorpay_invoices_company_id_foreign` (`company_id`),
  ADD KEY `razorpay_invoices_package_id_foreign` (`package_id`);

--
-- Indexes for table `razorpay_subscriptions`
--
ALTER TABLE `razorpay_subscriptions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `roles_company_id_foreign` (`company_id`);

--
-- Indexes for table `role_user`
--
ALTER TABLE `role_user`
  ADD PRIMARY KEY (`user_id`,`role_id`),
  ADD KEY `role_user_role_id_foreign` (`role_id`);

--
-- Indexes for table `seo_details`
--
ALTER TABLE `seo_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `seo_details_footer_menu_id_foreign` (`footer_menu_id`);

--
-- Indexes for table `skills`
--
ALTER TABLE `skills`
  ADD PRIMARY KEY (`id`),
  ADD KEY `skills_category_id_foreign` (`category_id`),
  ADD KEY `skills_company_id_foreign` (`company_id`);

--
-- Indexes for table `sms_settings`
--
ALTER TABLE `sms_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `smtp_settings`
--
ALTER TABLE `smtp_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sticky_notes`
--
ALTER TABLE `sticky_notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sticky_notes_user_id_foreign` (`user_id`);

--
-- Indexes for table `stripe_invoices`
--
ALTER TABLE `stripe_invoices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stripe_invoices_company_id_foreign` (`company_id`),
  ADD KEY `stripe_invoices_package_id_foreign` (`package_id`);

--
-- Indexes for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tasks_user_id_foreign` (`user_id`);

--
-- Indexes for table `theme_settings`
--
ALTER TABLE `theme_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `theme_settings_company_id_foreign` (`company_id`);

--
-- Indexes for table `todo_items`
--
ALTER TABLE `todo_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `todo_items_company_id_foreign` (`company_id`),
  ADD KEY `todo_items_user_id_foreign` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_company_id_foreign` (`company_id`);

--
-- Indexes for table `user_zoom_meeting`
--
ALTER TABLE `user_zoom_meeting`
  ADD KEY `user_zoom_meeting_user_id_foreign` (`user_id`),
  ADD KEY `user_zoom_meeting_zoom_meeting_id_foreign` (`zoom_meeting_id`);

--
-- Indexes for table `zoom_categories`
--
ALTER TABLE `zoom_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `zoom_categories_company_id_foreign` (`company_id`);

--
-- Indexes for table `zoom_meetings`
--
ALTER TABLE `zoom_meetings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `zoom_meetings_company_id_foreign` (`company_id`),
  ADD KEY `zoom_meetings_created_by_foreign` (`created_by`),
  ADD KEY `zoom_meetings_source_meeting_id_foreign` (`source_meeting_id`),
  ADD KEY `zoom_meetings_category_id_foreign` (`category_id`);

--
-- Indexes for table `zoom_settings`
--
ALTER TABLE `zoom_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `zoom_settings_company_id_foreign` (`company_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `applicant_notes`
--
ALTER TABLE `applicant_notes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `application_settings`
--
ALTER TABLE `application_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `application_status`
--
ALTER TABLE `application_status`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `client_feedbacks`
--
ALTER TABLE `client_feedbacks`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `company_packages`
--
ALTER TABLE `company_packages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=246;

--
-- AUTO_INCREMENT for table `currencies`
--
ALTER TABLE `currencies`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `designations`
--
ALTER TABLE `designations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `footer_menu`
--
ALTER TABLE `footer_menu`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `footer_settings`
--
ALTER TABLE `footer_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `front_cms_headers`
--
ALTER TABLE `front_cms_headers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `front_icon_features`
--
ALTER TABLE `front_icon_features`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `front_image_features`
--
ALTER TABLE `front_image_features`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `global_settings`
--
ALTER TABLE `global_settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `interview_schedules`
--
ALTER TABLE `interview_schedules`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `interview_schedule_comments`
--
ALTER TABLE `interview_schedule_comments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `interview_schedule_employees`
--
ALTER TABLE `interview_schedule_employees`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `job_applications`
--
ALTER TABLE `job_applications`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `job_application_answers`
--
ALTER TABLE `job_application_answers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `job_categories`
--
ALTER TABLE `job_categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `job_companies`
--
ALTER TABLE `job_companies`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `job_locations`
--
ALTER TABLE `job_locations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `job_questions`
--
ALTER TABLE `job_questions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `job_skills`
--
ALTER TABLE `job_skills`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `language_settings`
--
ALTER TABLE `language_settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `linked_in_settings`
--
ALTER TABLE `linked_in_settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ltm_translations`
--
ALTER TABLE `ltm_translations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=145;

--
-- AUTO_INCREMENT for table `modules`
--
ALTER TABLE `modules`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `on_board_details`
--
ALTER TABLE `on_board_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `on_board_files`
--
ALTER TABLE `on_board_files`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `payment_settings`
--
ALTER TABLE `payment_settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `paypal_invoices`
--
ALTER TABLE `paypal_invoices`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `razorpay_invoices`
--
ALTER TABLE `razorpay_invoices`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `razorpay_subscriptions`
--
ALTER TABLE `razorpay_subscriptions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `seo_details`
--
ALTER TABLE `seo_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `skills`
--
ALTER TABLE `skills`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sms_settings`
--
ALTER TABLE `sms_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `smtp_settings`
--
ALTER TABLE `smtp_settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sticky_notes`
--
ALTER TABLE `sticky_notes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stripe_invoices`
--
ALTER TABLE `stripe_invoices`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subscriptions`
--
ALTER TABLE `subscriptions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `theme_settings`
--
ALTER TABLE `theme_settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `todo_items`
--
ALTER TABLE `todo_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `zoom_categories`
--
ALTER TABLE `zoom_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `zoom_meetings`
--
ALTER TABLE `zoom_meetings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `zoom_settings`
--
ALTER TABLE `zoom_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `applicant_notes`
--
ALTER TABLE `applicant_notes`
  ADD CONSTRAINT `applicant_notes_job_application_id_foreign` FOREIGN KEY (`job_application_id`) REFERENCES `job_applications` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `applicant_notes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `application_settings`
--
ALTER TABLE `application_settings`
  ADD CONSTRAINT `application_settings_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `application_status`
--
ALTER TABLE `application_status`
  ADD CONSTRAINT `application_status_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `client_feedbacks`
--
ALTER TABLE `client_feedbacks`
  ADD CONSTRAINT `client_feedbacks_language_settings_id_foreign` FOREIGN KEY (`language_settings_id`) REFERENCES `language_settings` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `companies`
--
ALTER TABLE `companies`
  ADD CONSTRAINT `companies_package_id_foreign` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `company_packages`
--
ALTER TABLE `company_packages`
  ADD CONSTRAINT `company_packages_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `company_packages_package_id_foreign` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `departments`
--
ALTER TABLE `departments`
  ADD CONSTRAINT `departments_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `designations`
--
ALTER TABLE `designations`
  ADD CONSTRAINT `designations_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `documents`
--
ALTER TABLE `documents`
  ADD CONSTRAINT `documents_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `footer_menu`
--
ALTER TABLE `footer_menu`
  ADD CONSTRAINT `footer_menu_language_settings_id_foreign` FOREIGN KEY (`language_settings_id`) REFERENCES `language_settings` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `footer_settings`
--
ALTER TABLE `footer_settings`
  ADD CONSTRAINT `footer_settings_language_settings_id_foreign` FOREIGN KEY (`language_settings_id`) REFERENCES `language_settings` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `front_cms_headers`
--
ALTER TABLE `front_cms_headers`
  ADD CONSTRAINT `front_cms_headers_language_settings_id_foreign` FOREIGN KEY (`language_settings_id`) REFERENCES `language_settings` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `front_icon_features`
--
ALTER TABLE `front_icon_features`
  ADD CONSTRAINT `front_icon_features_language_settings_id_foreign` FOREIGN KEY (`language_settings_id`) REFERENCES `language_settings` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `front_image_features`
--
ALTER TABLE `front_image_features`
  ADD CONSTRAINT `front_image_features_language_settings_id_foreign` FOREIGN KEY (`language_settings_id`) REFERENCES `language_settings` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `global_settings`
--
ALTER TABLE `global_settings`
  ADD CONSTRAINT `global_settings_currency_id_foreign` FOREIGN KEY (`currency_id`) REFERENCES `currencies` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `interview_schedules`
--
ALTER TABLE `interview_schedules`
  ADD CONSTRAINT `interview_schedules_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `interview_schedules_job_application_id_foreign` FOREIGN KEY (`job_application_id`) REFERENCES `job_applications` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `interview_schedules_meeting_id_foreign` FOREIGN KEY (`meeting_id`) REFERENCES `zoom_meetings` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `interview_schedule_comments`
--
ALTER TABLE `interview_schedule_comments`
  ADD CONSTRAINT `interview_schedule_comments_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `interview_schedule_comments_interview_schedule_id_foreign` FOREIGN KEY (`interview_schedule_id`) REFERENCES `interview_schedules` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `interview_schedule_comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `interview_schedule_employees`
--
ALTER TABLE `interview_schedule_employees`
  ADD CONSTRAINT `interview_schedule_employees_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `interview_schedule_employees_interview_schedule_id_foreign` FOREIGN KEY (`interview_schedule_id`) REFERENCES `interview_schedules` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `interview_schedule_employees_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `jobs`
--
ALTER TABLE `jobs`
  ADD CONSTRAINT `jobs_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `job_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `jobs_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `jobs_job_company_id_foreign` FOREIGN KEY (`job_company_id`) REFERENCES `job_companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `jobs_location_id_foreign` FOREIGN KEY (`location_id`) REFERENCES `job_locations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `job_applications`
--
ALTER TABLE `job_applications`
  ADD CONSTRAINT `job_applications_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `job_applications_job_id_foreign` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `job_applications_status_id_foreign` FOREIGN KEY (`status_id`) REFERENCES `application_status` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `job_application_answers`
--
ALTER TABLE `job_application_answers`
  ADD CONSTRAINT `job_application_answers_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `job_application_answers_job_application_id_foreign` FOREIGN KEY (`job_application_id`) REFERENCES `job_applications` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `job_application_answers_job_id_foreign` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `job_application_answers_question_id_foreign` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `job_categories`
--
ALTER TABLE `job_categories`
  ADD CONSTRAINT `job_categories_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `job_companies`
--
ALTER TABLE `job_companies`
  ADD CONSTRAINT `job_companies_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `job_job_application`
--
ALTER TABLE `job_job_application`
  ADD CONSTRAINT `job_job_application_job_application_id_foreign` FOREIGN KEY (`job_application_id`) REFERENCES `job_applications` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `job_job_application_job_id_foreign` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `job_locations`
--
ALTER TABLE `job_locations`
  ADD CONSTRAINT `job_locations_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `job_locations_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `job_questions`
--
ALTER TABLE `job_questions`
  ADD CONSTRAINT `job_questions_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `job_questions_job_id_foreign` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `job_questions_question_id_foreign` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `job_skills`
--
ALTER TABLE `job_skills`
  ADD CONSTRAINT `job_skills_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `job_skills_job_id_foreign` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `job_skills_skill_id_foreign` FOREIGN KEY (`skill_id`) REFERENCES `skills` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `on_board_details`
--
ALTER TABLE `on_board_details`
  ADD CONSTRAINT `on_board_details_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `on_board_details_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `on_board_details_designation_id_foreign` FOREIGN KEY (`designation_id`) REFERENCES `designations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `on_board_details_job_application_id_foreign` FOREIGN KEY (`job_application_id`) REFERENCES `job_applications` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `on_board_details_reports_to_id_foreign` FOREIGN KEY (`reports_to_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `on_board_files`
--
ALTER TABLE `on_board_files`
  ADD CONSTRAINT `on_board_files_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `on_board_files_on_board_detail_id_foreign` FOREIGN KEY (`on_board_detail_id`) REFERENCES `on_board_details` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `paypal_invoices`
--
ALTER TABLE `paypal_invoices`
  ADD CONSTRAINT `paypal_invoices_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `paypal_invoices_currency_id_foreign` FOREIGN KEY (`currency_id`) REFERENCES `currencies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `paypal_invoices_package_id_foreign` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `permissions`
--
ALTER TABLE `permissions`
  ADD CONSTRAINT `permissions_module_id_foreign` FOREIGN KEY (`module_id`) REFERENCES `modules` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `razorpay_invoices`
--
ALTER TABLE `razorpay_invoices`
  ADD CONSTRAINT `razorpay_invoices_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `razorpay_invoices_package_id_foreign` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `roles`
--
ALTER TABLE `roles`
  ADD CONSTRAINT `roles_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `role_user`
--
ALTER TABLE `role_user`
  ADD CONSTRAINT `role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `role_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `seo_details`
--
ALTER TABLE `seo_details`
  ADD CONSTRAINT `seo_details_footer_menu_id_foreign` FOREIGN KEY (`footer_menu_id`) REFERENCES `footer_menu` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `skills`
--
ALTER TABLE `skills`
  ADD CONSTRAINT `skills_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `job_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `skills_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sticky_notes`
--
ALTER TABLE `sticky_notes`
  ADD CONSTRAINT `sticky_notes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `stripe_invoices`
--
ALTER TABLE `stripe_invoices`
  ADD CONSTRAINT `stripe_invoices_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `stripe_invoices_package_id_foreign` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `theme_settings`
--
ALTER TABLE `theme_settings`
  ADD CONSTRAINT `theme_settings_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `todo_items`
--
ALTER TABLE `todo_items`
  ADD CONSTRAINT `todo_items_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `todo_items_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_zoom_meeting`
--
ALTER TABLE `user_zoom_meeting`
  ADD CONSTRAINT `user_zoom_meeting_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_zoom_meeting_zoom_meeting_id_foreign` FOREIGN KEY (`zoom_meeting_id`) REFERENCES `zoom_meetings` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `zoom_categories`
--
ALTER TABLE `zoom_categories`
  ADD CONSTRAINT `zoom_categories_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `zoom_meetings`
--
ALTER TABLE `zoom_meetings`
  ADD CONSTRAINT `zoom_meetings_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `zoom_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `zoom_meetings_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `zoom_meetings_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `zoom_meetings_source_meeting_id_foreign` FOREIGN KEY (`source_meeting_id`) REFERENCES `zoom_meetings` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `zoom_settings`
--
ALTER TABLE `zoom_settings`
  ADD CONSTRAINT `zoom_settings_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
