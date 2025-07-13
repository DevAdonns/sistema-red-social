-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-07-2025 a las 05:44:20
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `prueba_platzilla`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl-admin`
--

CREATE TABLE `tbl-admin` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl-admin`
--

INSERT INTO `tbl-admin` (`id`, `nombre`, `password`) VALUES
(1, 'Julián', '12345');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl-amigos`
--

CREATE TABLE `tbl-amigos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `edad` int(3) NOT NULL,
  `password` varchar(100) NOT NULL,
  `avatar` varchar(100) NOT NULL,
  `amigos` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl-amigos`
--

INSERT INTO `tbl-amigos` (`id`, `nombre`, `edad`, `password`, `avatar`, `amigos`) VALUES
(17, 'diego', 16, '12345', 'Avatar1.webp', 'albani (ID: 18)'),
(18, 'albani', 24, '1234567890', 'avatar3.webp', 'diego (ID: 17)'),
(19, 'angel', 21, '1234', 'avatar2.avif', ''),
(20, 'pedro', 18, '12345', 'Avatar1.webp', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl-amistades`
--

CREATE TABLE `tbl-amistades` (
  `id` int(11) NOT NULL,
  `id_usuario1` int(100) NOT NULL,
  `id_usuario2` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl-amistades`
--

INSERT INTO `tbl-amistades` (`id`, `id_usuario1`, `id_usuario2`) VALUES
(3, 17, 18),
(4, 0, 20),
(5, 17, 19);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_eventos`
--

CREATE TABLE `tbl_eventos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `fecha` date NOT NULL,
  `descripcion` text NOT NULL,
  `creador_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_eventos`
--

INSERT INTO `tbl_eventos` (`id`, `nombre`, `fecha`, `descripcion`, `creador_id`) VALUES
(1, 'fiesta', '2025-07-23', 'fiestas', 17);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_invitados_evento`
--

CREATE TABLE `tbl_invitados_evento` (
  `id` int(11) NOT NULL,
  `evento_id` int(11) NOT NULL,
  `invitado_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbl_invitados_evento`
--

INSERT INTO `tbl_invitados_evento` (`id`, `evento_id`, `invitado_id`) VALUES
(1, 1, 18),
(2, 1, 19),
(3, 1, 17);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tbl-admin`
--
ALTER TABLE `tbl-admin`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tbl-amigos`
--
ALTER TABLE `tbl-amigos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_2` (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `id_3` (`id`);

--
-- Indices de la tabla `tbl-amistades`
--
ALTER TABLE `tbl-amistades`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tbl_eventos`
--
ALTER TABLE `tbl_eventos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tbl_invitados_evento`
--
ALTER TABLE `tbl_invitados_evento`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tbl-admin`
--
ALTER TABLE `tbl-admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tbl-amigos`
--
ALTER TABLE `tbl-amigos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `tbl-amistades`
--
ALTER TABLE `tbl-amistades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `tbl_eventos`
--
ALTER TABLE `tbl_eventos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tbl_invitados_evento`
--
ALTER TABLE `tbl_invitados_evento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
