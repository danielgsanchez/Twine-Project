-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 19-06-2023 a las 22:39:53
-- Versión del servidor: 10.4.25-MariaDB
-- Versión de PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `db_twine`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `twn_blocks`
--

CREATE TABLE `twn_blocks` (
  `id` int(11) NOT NULL,
  `user1_id` int(11) NOT NULL COMMENT 'Usuario que bloquea',
  `user2_id` int(11) NOT NULL COMMENT 'Usuario bloqueado',
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `twn_chats`
--

CREATE TABLE `twn_chats` (
  `id` int(11) NOT NULL,
  `user1_id` int(11) NOT NULL COMMENT 'sender',
  `user2_id` int(11) NOT NULL COMMENT 'receiver'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `twn_chats`
--

INSERT INTO `twn_chats` (`id`, `user1_id`, `user2_id`) VALUES
(1, 1, 27),
(3, 1, 44),
(4, 1, 22);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `twn_chat_msg`
--

CREATE TABLE `twn_chat_msg` (
  `id` int(11) NOT NULL,
  `chat_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `msg_text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `timestamp` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `twn_chat_msg`
--

INSERT INTO `twn_chat_msg` (`id`, `chat_id`, `sender_id`, `msg_text`, `timestamp`) VALUES
(3, 1, 1, 'aaa', '2023-06-06 18:35:00'),
(4, 1, 27, 'eee', '2023-06-06 18:37:00'),
(5, 1, 1, 'aaeaeae', '2023-06-06 18:39:00'),
(6, 1, 1, 'aeaeae', '2023-06-06 19:24:41'),
(7, 3, 1, 'aeaeaeae', '2023-06-06 19:29:13'),
(11, 4, 1, 'asasasas', '2023-06-10 06:13:31'),
(12, 4, 1, 'hola', '2023-06-17 08:40:12'),
(13, 4, 22, 'aaaa', '2023-06-17 08:40:53'),
(14, 4, 22, 'hola', '2023-06-17 08:41:14'),
(15, 3, 1, 'aaaaa', '2023-06-17 08:41:14'),
(16, 4, 44, 'aeaeaeaeaeae', '2023-06-17 08:41:14'),
(17, 3, 44, 'asaasas', '2023-06-17 10:06:15'),
(18, 4, 1, 'hola hola hola', '2023-06-17 18:35:27'),
(19, 4, 22, 'hola hola', '2023-06-17 18:35:34');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `twn_genders`
--

CREATE TABLE `twn_genders` (
  `id` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `twn_genders`
--

INSERT INTO `twn_genders` (`id`, `name`) VALUES
('GL', 'Agénero'),
('B', 'Ambos'),
('F', 'Femenino'),
('GF', 'Género fluido'),
('CM', 'Hombre cis'),
('M', 'Masculino'),
('CF', 'Mujer cis'),
('NB', 'No binario'),
('TG', 'Transgénero');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `twn_interested_in`
--

CREATE TABLE `twn_interested_in` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `gender_id` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `twn_interested_in`
--

INSERT INTO `twn_interested_in` (`id`, `user_id`, `gender_id`) VALUES
(1, 1, 'M'),
(2, 2, 'F'),
(3, 3, 'B'),
(4, 4, 'F'),
(5, 5, 'F'),
(6, 6, 'F'),
(7, 7, 'M'),
(8, 8, 'B'),
(9, 9, 'B'),
(10, 10, 'B'),
(11, 11, 'B'),
(12, 12, 'F'),
(13, 13, 'M'),
(14, 14, 'M'),
(15, 15, 'B'),
(16, 16, 'M'),
(17, 17, 'F'),
(18, 18, 'B'),
(19, 19, 'M'),
(20, 20, 'F'),
(21, 21, 'B'),
(22, 22, 'F'),
(23, 23, 'M'),
(24, 24, 'M'),
(25, 25, 'F'),
(26, 26, 'M'),
(27, 27, 'F'),
(28, 28, 'M'),
(29, 29, 'M'),
(30, 30, 'M'),
(31, 31, 'M'),
(32, 32, 'M'),
(33, 33, 'M'),
(34, 34, 'F'),
(35, 35, 'B'),
(36, 36, 'M'),
(37, 37, 'M'),
(38, 38, 'F'),
(39, 39, 'F'),
(40, 40, 'F'),
(41, 41, 'F'),
(42, 42, 'F'),
(43, 43, 'M'),
(44, 44, 'F'),
(45, 45, 'B'),
(46, 46, 'F'),
(47, 47, 'M'),
(48, 48, 'M'),
(49, 49, 'B'),
(50, 50, 'M');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `twn_likes`
--

CREATE TABLE `twn_likes` (
  `id` int(11) NOT NULL,
  `user_id1` int(11) NOT NULL COMMENT 'El usuario que ha dado el like',
  `user_id2` int(11) NOT NULL COMMENT 'El usuario que ha recibido el like'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `twn_likes`
--

INSERT INTO `twn_likes` (`id`, `user_id1`, `user_id2`) VALUES
(1, 5, 1),
(2, 8, 1),
(3, 9, 1),
(4, 12, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `twn_matches`
--

CREATE TABLE `twn_matches` (
  `id` int(11) NOT NULL,
  `user1_id` int(11) NOT NULL,
  `user2_id` int(11) NOT NULL,
  `timestamp` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `twn_matches`
--

INSERT INTO `twn_matches` (`id`, `user1_id`, `user2_id`, `timestamp`) VALUES
(83, 1, 27, '2023-06-17'),
(84, 27, 1, '2023-06-17'),
(85, 1, 44, '2023-06-17'),
(86, 44, 1, '2023-06-17'),
(87, 1, 22, '2023-06-17');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `twn_rejects`
--

CREATE TABLE `twn_rejects` (
  `id` int(11) NOT NULL,
  `user1_id` int(11) NOT NULL,
  `user2_id` int(11) NOT NULL,
  `timestamp` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `twn_reports`
--

CREATE TABLE `twn_reports` (
  `id` int(11) NOT NULL,
  `user1_id` int(11) NOT NULL COMMENT 'Usuario que reporta',
  `user2_id` int(11) NOT NULL COMMENT 'Usuario reportado',
  `reason` text COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `twn_reports`
--

INSERT INTO `twn_reports` (`id`, `user1_id`, `user2_id`, `reason`) VALUES
(3, 27, 1, 'foto de perfil inadecuada'),
(4, 22, 1, 'foto de perfil inadecuada');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `twn_users`
--

CREATE TABLE `twn_users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender_id` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `screen_name` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `gold_sub` tinyint(1) NOT NULL DEFAULT 0,
  `password` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_banned` tinyint(4) NOT NULL,
  `confirmation_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hobbies` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `twn_users`
--

INSERT INTO `twn_users` (`id`, `first_name`, `last_name`, `gender_id`, `description`, `screen_name`, `email`, `gold_sub`, `password`, `is_banned`, `confirmation_code`, `hobbies`) VALUES
(1, 'Wye', 'Skipsey', 'M', 'Mauris enim leo, rhoncus sed, vestibulum sit amet, cursus id, turpis. Integer aliquet, massa id lobortis convallis, tortor risus dapibus augue, vel accumsan tellus nisi eu orci. Mauris lacinia sapien quis libero.\r\n\r\nNullam sit amet turpis elementum ligula vehicula consequat. Morbi a ipsum. Integer a nibh.\r\n\r\nIn quis justo. Maecenas rhoncus aliquam lacus. Morbi quis tortor id nulla ultrices aliquet.', 'wskipsey0', 'wskipsey0@uol.com.br', 0, '81dc9bdb52d04dc20036dbd8313ed055', 0, NULL, 'Fútbol, Lectura, Cocina, Viajes'),
(2, 'Robin', 'Gradwell', 'M', 'Morbi porttitor lorem id ligula. Suspendisse ornare consequat lectus. In est risus, auctor sed, tristique in, tempus sit amet, sem.\r\n\r\nFusce consequat. Nulla nisl. Nunc nisl.\r\n\r\nDuis bibendum, felis sed interdum venenatis, turpis enim blandit mi, in porttitor pede justo eu massa. Donec dapibus. Duis at velit eu est congue elementum.', 'rgradwell1', 'rgradwell1@bing.com', 0, '81dc9bdb52d04dc20036dbd8313ed055', 0, NULL, 'Pintura, Jardinería, Fotografía, Senderismo'),
(3, 'Janaye', 'Batho', 'F', 'Morbi non lectus. Aliquam sit amet diam in magna bibendum imperdiet. Nullam orci pede, venenatis non, sodales sed, tincidunt eu, felis.\n\nFusce posuere felis sed lacus. Morbi sem mauris, laoreet ut, rhoncus aliquet, pulvinar sed, nisl. Nunc rhoncus dui vel sem.\n\nSed sagittis. Nam congue, risus semper porta volutpat, quam pede lobortis ligula, sit amet eleifend pede libero quis orci. Nullam molestie nibh in lectus.', 'jbatho2', 'jbatho2@is.gd', 1, '81dc9bdb52d04dc20036dbd8313ed055', 0, NULL, 'Bailar, Cine, Yoga, Ajedrez '),
(4, 'Jacinta', 'Pitkeathly', 'F', 'Nulla ut erat id mauris vulputate elementum. Nullam varius. Nulla facilisi.\n\nCras non velit nec nisi vulputate nonummy. Maecenas tincidunt lacus at velit. Vivamus vel nulla eget eros elementum pellentesque.\n\nQuisque porta volutpat erat. Quisque erat eros, viverra eget, congue eget, semper rutrum, nulla. Nunc purus.', 'jpitkeathly3', 'jpitkeathly3@artisteer.com', 1, '81dc9bdb52d04dc20036dbd8313ed055', 0, NULL, 'Música, Deportes acuáticos, Videojuegos, Excursionismo '),
(5, 'Hazel', 'Cranney', 'M', 'Curabitur gravida nisi at nibh. In hac habitasse platea dictumst. Aliquam augue quam, sollicitudin vitae, consectetuer eget, rutrum at, lorem.\n\nInteger tincidunt ante vel ipsum. Praesent blandit lacinia erat. Vestibulum sed magna at nunc commodo placerat.\n\nPraesent blandit. Nam nulla. Integer pede justo, lacinia eget, tincidunt eget, tempus vel, pede.', 'hcranney4', 'hcranney4@princeton.edu', 0, '81dc9bdb52d04dc20036dbd8313ed055', 0, NULL, 'Fútbol, Lectura, Cocina, Viajes '),
(6, 'Agata', 'Dampney', 'F', 'Praesent id massa id nisl venenatis lacinia. Aenean sit amet justo. Morbi ut odio.\n\nCras mi pede, malesuada in, imperdiet et, commodo vulputate, justo. In blandit ultrices enim. Lorem ipsum dolor sit amet, consectetuer adipiscing elit.\n\nProin interdum mauris non ligula pellentesque ultrices. Phasellus id sapien in sapien iaculis congue. Vivamus metus arcu, adipiscing molestie, hendrerit at, vulputate vitae, nisl.', 'adampney5', 'adampney5@loc.gov', 1, '81dc9bdb52d04dc20036dbd8313ed055', 0, NULL, 'Pintura, Jardinería, Fotografía, Senderismo '),
(7, 'Dreddy', 'Halfpenny', 'F', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Proin risus. Praesent lectus.', 'dhalfpenny6', 'dhalfpenny6@surveymonkey.com', 1, '81dc9bdb52d04dc20036dbd8313ed055', 0, NULL, 'Bailar, Cine, Yoga, Ajedrez'),
(8, 'Gisela', 'Froude', 'F', 'Sed sagittis. Nam congue, risus semper porta volutpat, quam pede lobortis ligula, sit amet eleifend pede libero quis orci. Nullam molestie nibh in lectus.', 'gfroude7', 'gfroude7@imageshack.us', 0, '81dc9bdb52d04dc20036dbd8313ed055', 0, NULL, 'Música, Deportes acuáticos, Videojuegos, Excursionismo\n'),
(9, 'Cody', 'Pietruschka', 'M', 'Quisque porta volutpat erat. Quisque erat eros, viverra eget, congue eget, semper rutrum, nulla. Nunc purus.\n\nPhasellus in felis. Donec semper sapien a libero. Nam dui.\n\nProin leo odio, porttitor id, consequat in, consequat ut, nulla. Sed accumsan felis. Ut at dolor quis odio consequat varius.', 'cpietruschka8', 'cpietruschka8@w3.org', 0, '81dc9bdb52d04dc20036dbd8313ed055', 0, NULL, 'Cocina, Fotografía, Senderismo, Buceo, Juegos de mesa'),
(10, 'Charlotte', 'De Lacey', 'F', 'Nullam porttitor lacus at turpis. Donec posuere metus vitae ipsum. Aliquam non mauris.\n\nMorbi non lectus. Aliquam sit amet diam in magna bibendum imperdiet. Nullam orci pede, venenatis non, sodales sed, tincidunt eu, felis.\n\nFusce posuere felis sed lacus. Morbi sem mauris, laoreet ut, rhoncus aliquet, pulvinar sed, nisl. Nunc rhoncus dui vel sem.', 'cdelacey9', 'cdelacey9@myspace.com', 1, '81dc9bdb52d04dc20036dbd8313ed055', 0, NULL, 'Lectura, Pintura, Fútbol, Viajes, Canto '),
(11, 'Joseito', 'Braga', 'M', 'Praesent id massa id nisl venenatis lacinia. Aenean sit amet justo. Morbi ut odio.\n\nCras mi pede, malesuada in, imperdiet et, commodo vulputate, justo. In blandit ultrices enim. Lorem ipsum dolor sit amet, consectetuer adipiscing elit.\n\nProin interdum mauris non ligula pellentesque ultrices. Phasellus id sapien in sapien iaculis congue. Vivamus metus arcu, adipiscing molestie, hendrerit at, vulputate vitae, nisl.', 'jbragaa', 'jbragaa@go.com', 0, '81dc9bdb52d04dc20036dbd8313ed055', 0, NULL, 'Yoga, Cine, Jardinería, Escalada, Cocina internacional '),
(12, 'Kendra', 'Sewall', 'F', 'Fusce consequat. Nulla nisl. Nunc nisl.', 'ksewallb', 'ksewallb@mlb.com', 1, '81dc9bdb52d04dc20036dbd8313ed055', 0, NULL, 'Ajedrez, Danza, Surf, Excursionismo, Programación '),
(13, 'Eugene', 'McCurt', 'M', 'In hac habitasse platea dictumst. Morbi vestibulum, velit id pretium iaculis, diam erat fermentum justo, nec condimentum neque sapien placerat ante. Nulla justo.', 'emccurtc', 'emccurtc@tumblr.com', 1, '81dc9bdb52d04dc20036dbd8313ed055', 0, NULL, 'Artes marciales, Viajes, Pintura, Cocina vegetariana, Montañismo '),
(14, 'Susi', 'Maryska', 'F', 'Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Vivamus vestibulum sagittis sapien. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.\n\nEtiam vel augue. Vestibulum rutrum rutrum neque. Aenean auctor gravida sem.', 'smaryskad', 'smaryskad@ucoz.com', 1, '81dc9bdb52d04dc20036dbd8313ed055', 0, NULL, 'Cocina gourmet, Pintura, Yoga, Vela, Teatro '),
(15, 'Bren', 'MacCaughen', 'M', 'Phasellus sit amet erat. Nulla tempus. Vivamus in felis eu sapien cursus vestibulum.\n\nProin eu mi. Nulla ac enim. In tempor, turpis nec euismod scelerisque, quam turpis adipiscing lorem, vitae mattis nibh ligula nec sem.\n\nDuis aliquam convallis nunc. Proin at turpis a pede posuere nonummy. Integer non velit.', 'bmaccaughene', 'bmaccaughene@meetup.com', 0, '81dc9bdb52d04dc20036dbd8313ed055', 0, NULL, 'Baile latino, Lectura, Fotografía, Esquí, Jardinería '),
(16, 'Isaak', 'Kennicott', 'M', 'In quis justo. Maecenas rhoncus aliquam lacus. Morbi quis tortor id nulla ultrices aliquet.', 'ikennicottf', 'ikennicottf@naver.com', 1, '81dc9bdb52d04dc20036dbd8313ed055', 0, NULL, 'Escalada en roca, Música, Viajes, Surf, Cocina asiática '),
(17, 'Sophia', 'McKean', 'F', 'Proin interdum mauris non ligula pellentesque ultrices. Phasellus id sapien in sapien iaculis congue. Vivamus metus arcu, adipiscing molestie, hendrerit at, vulputate vitae, nisl.\n\nAenean lectus. Pellentesque eget nunc. Donec quis orci eget orci vehicula condimentum.', 'smckeang', 'smckeang@chronoengine.com', 0, '81dc9bdb52d04dc20036dbd8313ed055', 0, NULL, 'Cocina, Fotografía, Senderismo, Buceo, Juegos de mesa '),
(18, 'Mindy', 'Dwelly', 'F', 'Aliquam quis turpis eget elit sodales scelerisque. Mauris sit amet eros. Suspendisse accumsan tortor quis turpis.\n\nSed ante. Vivamus tortor. Duis mattis egestas metus.', 'mdwellyh', 'mdwellyh@sogou.com', 0, '81dc9bdb52d04dc20036dbd8313ed055', 0, NULL, 'Lectura, Pintura, Fútbol, Viajes, Canto '),
(19, 'Eb', 'Ridler', 'M', 'Aenean fermentum. Donec ut mauris eget massa tempor convallis. Nulla neque libero, convallis eget, eleifend luctus, ultricies eu, nibh.\n\nQuisque id justo sit amet sapien dignissim vestibulum. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Nulla dapibus dolor vel est. Donec odio justo, sollicitudin ut, suscipit a, feugiat et, eros.\n\nVestibulum ac est lacinia nisi venenatis tristique. Fusce congue, diam id ornare imperdiet, sapien urna pretium nisl, ut volutpat sapien arcu sed augue. Aliquam erat volutpat.', 'eridleri', 'eridleri@php.net', 1, '81dc9bdb52d04dc20036dbd8313ed055', 0, NULL, 'Ajedrez, Danza, Surf, Excursionismo, Programación '),
(20, 'Valerye', 'Athow', 'F', 'Cras non velit nec nisi vulputate nonummy. Maecenas tincidunt lacus at velit. Vivamus vel nulla eget eros elementum pellentesque.', 'vathowj', 'vathowj@nba.com', 0, '81dc9bdb52d04dc20036dbd8313ed055', 0, NULL, 'Fotografía, Musculación, Teatro, Voluntariado, Natación '),
(21, 'Bari', 'Paolone', 'F', 'Maecenas leo odio, condimentum id, luctus nec, molestie sed, justo. Pellentesque viverra pede ac diam. Cras pellentesque volutpat dui.', 'bpaolonek', 'bpaolonek@fc2.com', 1, '81dc9bdb52d04dc20036dbd8313ed055', 0, NULL, 'Artes marciales, Viajes, Pintura, Cocina vegetariana, Montañismo '),
(22, 'Brandice', 'Avery', 'F', 'Curabitur in libero ut massa volutpat convallis. Morbi odio odio, elementum eu, interdum eu, tincidunt in, leo. Maecenas pulvinar lobortis est.\n\nPhasellus sit amet erat. Nulla tempus. Vivamus in felis eu sapien cursus vestibulum.', 'baveryl', 'baveryl@accuweather.com', 0, '81dc9bdb52d04dc20036dbd8313ed055', 0, NULL, 'Ciclismo, Escritura creativa, Béisbol, Juegos de mesa, Astronomía '),
(23, 'Aurie', 'Houchin', 'F', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Proin risus. Praesent lectus.\n\nVestibulum quam sapien, varius ut, blandit non, interdum in, ante. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Duis faucibus accumsan odio. Curabitur convallis.', 'ahouchinm', 'ahouchinm@aboutads.info', 0, '81dc9bdb52d04dc20036dbd8313ed055', 0, NULL, 'Baile latino, Lectura, Fotografía, Esquí, Jardinería '),
(24, 'Steven', 'Sill', 'M', 'Praesent blandit. Nam nulla. Integer pede justo, lacinia eget, tincidunt eget, tempus vel, pede.\n\nMorbi porttitor lorem id ligula. Suspendisse ornare consequat lectus. In est risus, auctor sed, tristique in, tempus sit amet, sem.\n\nFusce consequat. Nulla nisl. Nunc nisl.', 'ssilln', 'ssilln@hugedomains.com', 0, '81dc9bdb52d04dc20036dbd8313ed055', 0, NULL, 'Cocina gourmet, Pintura, Yoga, Vela, Teatro '),
(25, 'Andriana', 'Brayfield', 'F', 'Pellentesque at nulla. Suspendisse potenti. Cras in purus eu magna vulputate luctus.', 'abrayfieldo', 'abrayfieldo@examiner.com', 1, '81dc9bdb52d04dc20036dbd8313ed055', 0, NULL, 'Cocina, Fotografía, Senderismo, Buceo, Juegos de mesa '),
(26, 'Rollin', 'Crumly', 'M', 'In congue. Etiam justo. Etiam pretium iaculis justo.', 'rcrumlyp', 'rcrumlyp@msu.edu', 1, '81dc9bdb52d04dc20036dbd8313ed055', 0, NULL, 'Lectura, Pintura, Fútbol, Viajes, Canto '),
(27, 'Leisha', 'Paszek', 'F', 'Phasellus in felis. Donec semper sapien a libero. Nam dui.\n\nProin leo odio, porttitor id, consequat in, consequat ut, nulla. Sed accumsan felis. Ut at dolor quis odio consequat varius.\n\nInteger ac leo. Pellentesque ultrices mattis odio. Donec vitae nisi.', 'lpaszekq', 'lpaszekq@fotki.com', 0, '81dc9bdb52d04dc20036dbd8313ed055', 0, NULL, 'Música, Deportes acuáticos, Videojuegos, Excursionismo '),
(28, 'Lucias', 'Grestye', 'M', 'Integer ac leo. Pellentesque ultrices mattis odio. Donec vitae nisi.\n\nNam ultrices, libero non mattis pulvinar, nulla pede ullamcorper augue, a suscipit nulla elit ac nulla. Sed vel enim sit amet nunc viverra dapibus. Nulla suscipit ligula in lacus.\n\nCurabitur at ipsum ac tellus semper interdum. Mauris ullamcorper purus sit amet nulla. Quisque arcu libero, rutrum ac, lobortis vel, dapibus at, diam.', 'lgrestyer', 'lgrestyer@guardian.co.uk', 1, '81dc9bdb52d04dc20036dbd8313ed055', 0, NULL, 'Ajedrez, Danza, Surf, Excursionismo, Programación '),
(29, 'Aubrey', 'Kagan', 'M', 'Duis aliquam convallis nunc. Proin at turpis a pede posuere nonummy. Integer non velit.\n\nDonec diam neque, vestibulum eget, vulputate ut, ultrices vel, augue. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Donec pharetra, magna vestibulum aliquet ultrices, erat tortor sollicitudin mi, sit amet lobortis sapien sapien non mi. Integer ac neque.', 'akagans', 'akagans@cyberchimps.com', 0, '81dc9bdb52d04dc20036dbd8313ed055', 0, NULL, 'Artes marciales, Viajes, Pintura, Cocina vegetariana, Montañismo '),
(30, 'Natalya', 'Tetford', 'F', 'Duis consequat dui nec nisi volutpat eleifend. Donec ut dolor. Morbi vel lectus in quam fringilla rhoncus.\n\nMauris enim leo, rhoncus sed, vestibulum sit amet, cursus id, turpis. Integer aliquet, massa id lobortis convallis, tortor risus dapibus augue, vel accumsan tellus nisi eu orci. Mauris lacinia sapien quis libero.\n\nNullam sit amet turpis elementum ligula vehicula consequat. Morbi a ipsum. Integer a nibh.', 'ntetfordt', 'ntetfordt@mapquest.com', 0, '81dc9bdb52d04dc20036dbd8313ed055', 0, NULL, 'Ciclismo, Escritura creativa, Béisbol, Juegos de mesa, Astronomía '),
(31, 'Elke', 'Pantecost', 'F', 'Maecenas ut massa quis augue luctus tincidunt. Nulla mollis molestie lorem. Quisque ut erat.\n\nCurabitur gravida nisi at nibh. In hac habitasse platea dictumst. Aliquam augue quam, sollicitudin vitae, consectetuer eget, rutrum at, lorem.\n\nInteger tincidunt ante vel ipsum. Praesent blandit lacinia erat. Vestibulum sed magna at nunc commodo placerat.', 'epantecostu', 'epantecostu@scientificamerican.com', 1, '81dc9bdb52d04dc20036dbd8313ed055', 0, NULL, 'Cocina gourmet, Pintura, Yoga, Vela, Teatro '),
(32, 'Garret', 'Prall', 'M', 'Nulla ut erat id mauris vulputate elementum. Nullam varius. Nulla facilisi.', 'gprallv', 'gprallv@ning.com', 0, '81dc9bdb52d04dc20036dbd8313ed055', 0, NULL, 'Escalada en roca, Música, Viajes, Surf, Cocina asiática '),
(33, 'Kaja', 'Tollerton', 'F', 'Duis bibendum. Morbi non quam nec dui luctus rutrum. Nulla tellus.', 'ktollertonw', 'ktollertonw@ihg.com', 1, '81dc9bdb52d04dc20036dbd8313ed055', 0, NULL, 'Cocina, Fotografía, Senderismo, Buceo, Juegos de mesa '),
(34, 'Steward', 'Richings', 'M', 'Cras mi pede, malesuada in, imperdiet et, commodo vulputate, justo. In blandit ultrices enim. Lorem ipsum dolor sit amet, consectetuer adipiscing elit.', 'srichingsx', 'srichingsx@creativecommons.org', 0, '81dc9bdb52d04dc20036dbd8313ed055', 0, NULL, 'Escalada en roca, Música, Viajes, Surf, Cocina asiática '),
(35, 'Cull', 'Shenton', 'M', 'Morbi porttitor lorem id ligula. Suspendisse ornare consequat lectus. In est risus, auctor sed, tristique in, tempus sit amet, sem.\n\nFusce consequat. Nulla nisl. Nunc nisl.\n\nDuis bibendum, felis sed interdum venenatis, turpis enim blandit mi, in porttitor pede justo eu massa. Donec dapibus. Duis at velit eu est congue elementum.', 'cshentony', 'cshentony@sphinn.com', 1, '81dc9bdb52d04dc20036dbd8313ed055', 0, NULL, 'Cocina gourmet, Pintura, Yoga, Vela, Teatro '),
(36, 'Tiffani', 'Culbard', 'F', 'Sed sagittis. Nam congue, risus semper porta volutpat, quam pede lobortis ligula, sit amet eleifend pede libero quis orci. Nullam molestie nibh in lectus.\n\nPellentesque at nulla. Suspendisse potenti. Cras in purus eu magna vulputate luctus.', 'tculbardz', 'tculbardz@yandex.ru', 0, '81dc9bdb52d04dc20036dbd8313ed055', 0, NULL, 'Baile latino, Lectura, Fotografía, Esquí, Jardinería '),
(37, 'Carolyn', 'Conwell', 'F', 'Duis bibendum, felis sed interdum venenatis, turpis enim blandit mi, in porttitor pede justo eu massa. Donec dapibus. Duis at velit eu est congue elementum.\n\nIn hac habitasse platea dictumst. Morbi vestibulum, velit id pretium iaculis, diam erat fermentum justo, nec condimentum neque sapien placerat ante. Nulla justo.\n\nAliquam quis turpis eget elit sodales scelerisque. Mauris sit amet eros. Suspendisse accumsan tortor quis turpis.', 'cconwell10', 'cconwell10@multiply.com', 0, '81dc9bdb52d04dc20036dbd8313ed055', 0, NULL, 'Ciclismo, Escritura creativa, Béisbol, Juegos de mesa, Astronomía '),
(38, 'Cullin', 'Bagworth', 'M', 'Integer tincidunt ante vel ipsum. Praesent blandit lacinia erat. Vestibulum sed magna at nunc commodo placerat.\n\nPraesent blandit. Nam nulla. Integer pede justo, lacinia eget, tincidunt eget, tempus vel, pede.\n\nMorbi porttitor lorem id ligula. Suspendisse ornare consequat lectus. In est risus, auctor sed, tristique in, tempus sit amet, sem.', 'cbagworth11', 'cbagworth11@eepurl.com', 1, '81dc9bdb52d04dc20036dbd8313ed055', 0, NULL, 'Artes marciales, Viajes, Pintura, Cocina vegetariana, Montañismo '),
(39, 'Pedro', 'Aldrin', 'M', 'Aenean lectus. Pellentesque eget nunc. Donec quis orci eget orci vehicula condimentum.', 'paldrin12', 'paldrin12@hubpages.com', 0, '81dc9bdb52d04dc20036dbd8313ed055', 0, NULL, 'Fotografía, Musculación, Teatro, Voluntariado, Natación '),
(40, 'Kerianne', 'Mamwell', 'F', 'Integer ac leo. Pellentesque ultrices mattis odio. Donec vitae nisi.', 'kmamwell13', 'kmamwell13@stanford.edu', 0, '81dc9bdb52d04dc20036dbd8313ed055', 0, NULL, 'Ajedrez, Danza, Surf, Excursionismo, Programación '),
(41, 'Griz', 'Croson', 'M', 'Morbi porttitor lorem id ligula. Suspendisse ornare consequat lectus. In est risus, auctor sed, tristique in, tempus sit amet, sem.\n\nFusce consequat. Nulla nisl. Nunc nisl.\n\nDuis bibendum, felis sed interdum venenatis, turpis enim blandit mi, in porttitor pede justo eu massa. Donec dapibus. Duis at velit eu est congue elementum.', 'gcroson14', 'gcroson14@whitehouse.gov', 1, '81dc9bdb52d04dc20036dbd8313ed055', 0, NULL, 'Yoga, Cine, Jardinería, Escalada, Cocina internacional '),
(42, 'Cassey', 'Guidetti', 'F', 'Etiam vel augue. Vestibulum rutrum rutrum neque. Aenean auctor gravida sem.\n\nPraesent id massa id nisl venenatis lacinia. Aenean sit amet justo. Morbi ut odio.', 'cguidetti15', 'cguidetti15@dagondesign.com', 1, '81dc9bdb52d04dc20036dbd8313ed055', 0, NULL, 'Música, Deportes acuáticos, Videojuegos, Excursionismo '),
(43, 'Jonathon', 'Acors', 'M', 'Suspendisse potenti. In eleifend quam a odio. In hac habitasse platea dictumst.\n\nMaecenas ut massa quis augue luctus tincidunt. Nulla mollis molestie lorem. Quisque ut erat.\n\nCurabitur gravida nisi at nibh. In hac habitasse platea dictumst. Aliquam augue quam, sollicitudin vitae, consectetuer eget, rutrum at, lorem.', 'jacors16', 'jacors16@ebay.co.uk', 1, '81dc9bdb52d04dc20036dbd8313ed055', 0, NULL, 'Bailar, Cine, Yoga, Ajedrez '),
(44, 'Kippie', 'Pedley', 'F', 'Suspendisse potenti. In eleifend quam a odio. In hac habitasse platea dictumst.\n\nMaecenas ut massa quis augue luctus tincidunt. Nulla mollis molestie lorem. Quisque ut erat.\n\nCurabitur gravida nisi at nibh. In hac habitasse platea dictumst. Aliquam augue quam, sollicitudin vitae, consectetuer eget, rutrum at, lorem.', 'kpedley17', 'kpedley17@marriott.com', 0, '81dc9bdb52d04dc20036dbd8313ed055', 0, NULL, 'Pintura, Jardinería, Fotografía, Senderismo '),
(45, 'Bax', 'Readshall', 'M', 'Duis bibendum. Morbi non quam nec dui luctus rutrum. Nulla tellus.\n\nIn sagittis dui vel nisl. Duis ac nibh. Fusce lacus purus, aliquet at, feugiat non, pretium quis, lectus.', 'breadshall18', 'breadshall18@diigo.com', 0, '81dc9bdb52d04dc20036dbd8313ed055', 0, NULL, 'Fútbol, Lectura, Cocina, Viajes '),
(46, 'Jamey', 'Gercken', 'M', 'Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Vivamus vestibulum sagittis sapien. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.\n\nEtiam vel augue. Vestibulum rutrum rutrum neque. Aenean auctor gravida sem.\n\nPraesent id massa id nisl venenatis lacinia. Aenean sit amet justo. Morbi ut odio.', 'jgercken19', 'jgercken19@usnews.com', 0, '81dc9bdb52d04dc20036dbd8313ed055', 0, NULL, 'Cocina, Fotografía, Senderismo, Buceo, Juegos de mesa '),
(47, 'Evaleen', 'Cathenod', 'F', 'Praesent blandit. Nam nulla. Integer pede justo, lacinia eget, tincidunt eget, tempus vel, pede.\n\nMorbi porttitor lorem id ligula. Suspendisse ornare consequat lectus. In est risus, auctor sed, tristique in, tempus sit amet, sem.\n\nFusce consequat. Nulla nisl. Nunc nisl.', 'ecathenod1a', 'ecathenod1a@cafepress.com', 1, '81dc9bdb52d04dc20036dbd8313ed055', 0, NULL, 'Lectura, Pintura, Fútbol, Viajes, Canto '),
(48, 'Janis', 'Shoveller', 'F', 'Sed ante. Vivamus tortor. Duis mattis egestas metus.\n\nAenean fermentum. Donec ut mauris eget massa tempor convallis. Nulla neque libero, convallis eget, eleifend luctus, ultricies eu, nibh.', 'jshoveller1b', 'jshoveller1b@java.com', 1, '81dc9bdb52d04dc20036dbd8313ed055', 0, NULL, 'Yoga, Cine, Jardinería, Escalada, Cocina internacional '),
(49, 'Elnora', 'Smythe', 'F', 'Aenean lectus. Pellentesque eget nunc. Donec quis orci eget orci vehicula condimentum.', 'esmythe1c', 'esmythe1c@dmoz.org', 0, '81dc9bdb52d04dc20036dbd8313ed055', 0, NULL, 'Ajedrez, Danza, Surf, Excursionismo, Programación '),
(50, 'Angy', 'Randales', 'F', 'Integer tincidunt ante vel ipsum. Praesent blandit lacinia erat. Vestibulum sed magna at nunc commodo placerat.\r\n\r\nPraesent blandit. Nam nulla. Integer pede justo, lacinia eget, tincidunt eget, tempus vel, pede.', 'arandales1d', 'arandales1d@paginegialle.it', 1, '81dc9bdb52d04dc20036dbd8313ed055', 0, NULL, 'Fotografía, Musculación, Teatro, Voluntariado, Natación'),
(59, 'admin', 'admin', NULL, 'admin', 'admin', 'admin@admin.es', 1, '81dc9bdb52d04dc20036dbd8313ed055', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `twn_user_photo`
--

CREATE TABLE `twn_user_photo` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `link` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `twn_user_photo`
--

INSERT INTO `twn_user_photo` (`id`, `user_id`, `link`, `description`) VALUES
(1, 1, 'chat_imgs\\avatares\\1.jpg', ''),
(2, 2, 'chat_imgs\\avatares\\2.jpg', ''),
(3, 3, 'chat_imgs\\avatares\\3.jpg', ''),
(4, 4, 'chat_imgs\\avatares\\4.jpg', ''),
(5, 5, 'chat_imgs\\avatares\\5.jpg', ''),
(6, 6, 'chat_imgs\\avatares\\6.jpg', ''),
(7, 7, 'chat_imgs\\avatares\\7.jpg', ''),
(8, 8, 'chat_imgs\\avatares\\8.jpg', ''),
(9, 9, 'chat_imgs\\avatares\\9.jpg', ''),
(10, 10, 'chat_imgs\\avatares\\10.jpg', ''),
(11, 11, 'chat_imgs\\avatares\\11.jpg', ''),
(12, 12, 'chat_imgs\\avatares\\12.jpg', ''),
(13, 13, 'chat_imgs\\avatares\\13.jpg', ''),
(14, 14, 'chat_imgs\\avatares\\14.jpg', ''),
(15, 15, 'chat_imgs\\avatares\\15.jpg', ''),
(16, 16, 'chat_imgs\\avatares\\16.jpg', ''),
(17, 17, 'chat_imgs\\avatares\\17.jpg', ''),
(18, 18, 'chat_imgs\\avatares\\18.jpg', ''),
(19, 19, 'chat_imgs\\avatares\\19.jpg', ''),
(20, 20, 'chat_imgs\\avatares\\20.jpg', ''),
(21, 21, 'chat_imgs\\avatares\\21.jpg', ''),
(22, 22, 'chat_imgs\\avatares\\22.jpg', ''),
(23, 23, 'chat_imgs\\avatares\\23.jpg', ''),
(24, 24, 'chat_imgs\\avatares\\24.jpg', ''),
(25, 25, 'chat_imgs\\avatares\\25.jpg', ''),
(26, 26, 'chat_imgs\\avatares\\26.jpg', ''),
(27, 27, 'chat_imgs\\avatares\\27.jpg', ''),
(28, 28, 'chat_imgs\\avatares\\28.jpg', ''),
(29, 29, 'chat_imgs\\avatares\\29.jpg', ''),
(30, 30, 'chat_imgs\\avatares\\30.jpg', ''),
(31, 31, 'chat_imgs\\avatares\\31.jpg', ''),
(32, 32, 'chat_imgs\\avatares\\32.jpg', ''),
(33, 33, 'chat_imgs\\avatares\\33.jpg', ''),
(34, 34, 'chat_imgs\\avatares\\34.jpg', ''),
(35, 35, 'chat_imgs\\avatares\\35.jpg', ''),
(36, 36, 'chat_imgs\\avatares\\36.jpg', ''),
(37, 37, 'chat_imgs\\avatares\\37.jpg', ''),
(38, 38, 'chat_imgs\\avatares\\38.jpg', ''),
(39, 39, 'chat_imgs\\avatares\\39.jpg', ''),
(40, 40, 'chat_imgs\\avatares\\40.jpg', ''),
(41, 41, 'chat_imgs\\avatares\\41.jpg', ''),
(42, 42, 'chat_imgs\\avatares\\42.jpg', ''),
(43, 43, 'chat_imgs\\avatares\\43.jpg', ''),
(44, 44, 'chat_imgs\\avatares\\44.jpg', ''),
(45, 45, 'chat_imgs\\avatares\\45.jpg', ''),
(46, 46, 'chat_imgs\\avatares\\46.jpg', ''),
(47, 47, 'chat_imgs\\avatares\\47.jpg', ''),
(48, 48, 'chat_imgs\\avatares\\48.jpg', ''),
(49, 49, 'chat_imgs\\avatares\\49.jpg', ''),
(50, 50, 'chat_imgs\\avatares\\50.jpg', '');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `twn_blocks`
--
ALTER TABLE `twn_blocks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user1_id` (`user1_id`),
  ADD KEY `user2_id` (`user2_id`);

--
-- Indices de la tabla `twn_chats`
--
ALTER TABLE `twn_chats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user1_id` (`user1_id`),
  ADD KEY `user2_id` (`user2_id`);

--
-- Indices de la tabla `twn_chat_msg`
--
ALTER TABLE `twn_chat_msg`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chat_id` (`chat_id`),
  ADD KEY `sender_id` (`sender_id`);

--
-- Indices de la tabla `twn_genders`
--
ALTER TABLE `twn_genders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQUE_GENDER_NAME` (`name`);

--
-- Indices de la tabla `twn_interested_in`
--
ALTER TABLE `twn_interested_in`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gender_id` (`gender_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `twn_likes`
--
ALTER TABLE `twn_likes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id1` (`user_id1`),
  ADD KEY `user_id2` (`user_id2`);

--
-- Indices de la tabla `twn_matches`
--
ALTER TABLE `twn_matches`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user1_id` (`user1_id`),
  ADD KEY `user2_id` (`user2_id`);

--
-- Indices de la tabla `twn_rejects`
--
ALTER TABLE `twn_rejects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user1_id` (`user1_id`),
  ADD KEY `user2_id` (`user2_id`);

--
-- Indices de la tabla `twn_reports`
--
ALTER TABLE `twn_reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user1_id` (`user1_id`),
  ADD KEY `user2_id` (`user2_id`);

--
-- Indices de la tabla `twn_users`
--
ALTER TABLE `twn_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQUE_EMAIL` (`email`),
  ADD KEY `gender_id` (`gender_id`);

--
-- Indices de la tabla `twn_user_photo`
--
ALTER TABLE `twn_user_photo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `twn_blocks`
--
ALTER TABLE `twn_blocks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `twn_chats`
--
ALTER TABLE `twn_chats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `twn_chat_msg`
--
ALTER TABLE `twn_chat_msg`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `twn_interested_in`
--
ALTER TABLE `twn_interested_in`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT de la tabla `twn_likes`
--
ALTER TABLE `twn_likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `twn_matches`
--
ALTER TABLE `twn_matches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- AUTO_INCREMENT de la tabla `twn_rejects`
--
ALTER TABLE `twn_rejects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=211;

--
-- AUTO_INCREMENT de la tabla `twn_reports`
--
ALTER TABLE `twn_reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `twn_users`
--
ALTER TABLE `twn_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT de la tabla `twn_user_photo`
--
ALTER TABLE `twn_user_photo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `twn_blocks`
--
ALTER TABLE `twn_blocks`
  ADD CONSTRAINT `twn_blocks_ibfk_1` FOREIGN KEY (`user1_id`) REFERENCES `twn_users` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `twn_blocks_ibfk_2` FOREIGN KEY (`user2_id`) REFERENCES `twn_users` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `twn_chats`
--
ALTER TABLE `twn_chats`
  ADD CONSTRAINT `twn_chats_ibfk_1` FOREIGN KEY (`user1_id`) REFERENCES `twn_users` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `twn_chats_ibfk_2` FOREIGN KEY (`user2_id`) REFERENCES `twn_users` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `twn_chat_msg`
--
ALTER TABLE `twn_chat_msg`
  ADD CONSTRAINT `twn_chat_msg_ibfk_1` FOREIGN KEY (`chat_id`) REFERENCES `twn_chats` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `twn_chat_msg_ibfk_2` FOREIGN KEY (`sender_id`) REFERENCES `twn_users` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `twn_interested_in`
--
ALTER TABLE `twn_interested_in`
  ADD CONSTRAINT `twn_interested_in_ibfk_1` FOREIGN KEY (`gender_id`) REFERENCES `twn_genders` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `twn_interested_in_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `twn_users` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `twn_likes`
--
ALTER TABLE `twn_likes`
  ADD CONSTRAINT `twn_likes_ibfk_1` FOREIGN KEY (`user_id1`) REFERENCES `twn_users` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `twn_likes_ibfk_2` FOREIGN KEY (`user_id2`) REFERENCES `twn_users` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `twn_matches`
--
ALTER TABLE `twn_matches`
  ADD CONSTRAINT `twn_matches_ibfk_1` FOREIGN KEY (`user1_id`) REFERENCES `twn_users` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `twn_matches_ibfk_2` FOREIGN KEY (`user2_id`) REFERENCES `twn_users` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `twn_rejects`
--
ALTER TABLE `twn_rejects`
  ADD CONSTRAINT `twn_rejects_ibfk_1` FOREIGN KEY (`user1_id`) REFERENCES `twn_users` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `twn_rejects_ibfk_2` FOREIGN KEY (`user2_id`) REFERENCES `twn_users` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `twn_reports`
--
ALTER TABLE `twn_reports`
  ADD CONSTRAINT `twn_reports_ibfk_1` FOREIGN KEY (`user1_id`) REFERENCES `twn_users` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `twn_reports_ibfk_2` FOREIGN KEY (`user2_id`) REFERENCES `twn_users` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `twn_users`
--
ALTER TABLE `twn_users`
  ADD CONSTRAINT `twn_users_ibfk_1` FOREIGN KEY (`gender_id`) REFERENCES `twn_genders` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `twn_user_photo`
--
ALTER TABLE `twn_user_photo`
  ADD CONSTRAINT `twn_user_photo_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `twn_users` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
