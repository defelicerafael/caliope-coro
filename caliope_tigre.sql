-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-01-2025 a las 15:20:23
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
-- Base de datos: `caliope_tigre`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asistencia`
--

CREATE TABLE `asistencia` (
  `id` int(11) NOT NULL,
  `id_caliopero` int(11) NOT NULL,
  `asistio` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `comentarios` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `audiciones`
--

CREATE TABLE `audiciones` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `apellido` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `celular` varchar(20) NOT NULL,
  `coro` varchar(255) NOT NULL,
  `cuerda` varchar(255) NOT NULL,
  `evaluacion_final` varchar(255) NOT NULL,
  `comentarios` text DEFAULT NULL,
  `fecha` date NOT NULL,
  `vocalizacion` varchar(255) NOT NULL,
  `armonizacion` varchar(255) NOT NULL,
  `interpretacion` varchar(255) NOT NULL,
  `onda` varchar(255) NOT NULL,
  `traslado` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `profes` varchar(1500) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `quedo` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calioperos`
--

CREATE TABLE `calioperos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(200) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `apellido` varchar(200) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `celular` int(12) NOT NULL,
  `pass` varchar(50) NOT NULL,
  `cuerda` int(11) NOT NULL,
  `activo` int(11) NOT NULL,
  `comentarios` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fecha_de_ingreso` date NOT NULL,
  `coro` varchar(500) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuracion_bases`
--

CREATE TABLE `configuracion_bases` (
  `id` int(11) NOT NULL,
  `n` varchar(50) NOT NULL,
  `t` varchar(50) NOT NULL,
  `b` varchar(50) NOT NULL,
  `d` varchar(50) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `configuracion_bases`
--

INSERT INTO `configuracion_bases` (`id`, `n`, `t`, `b`, `d`, `nombre`) VALUES
(1, 'nombre', 'text', '', '', 'configuracion_bases'),
(2, 'n', 'text', '', '', 'configuracion_bases'),
(3, 't', 'select', 'types', 'nombre', 'configuracion_bases'),
(4, 'b', 'text', '', '', 'configuracion_bases'),
(5, 'd', 'text', '', '', 'configuracion_bases'),
(6, 'nombre', 'text', '', '', 'profes'),
(7, 'apellido', 'text', '', '', 'profes'),
(8, 'email', 'email', '', '', 'profes'),
(9, 'celular', 'number', '', '', 'profes'),
(10, 'profe_de', 'selectM', 'sedes', 'nombre', 'profes'),
(11, 'director_de', 'select', 'sedes', 'nombre', 'profes'),
(12, 'nombre', 'text', '', '', 'sedes'),
(13, 'direccion', 'text', '', '', 'sedes'),
(14, 'nombre_contacto', 'text', '', '', 'sedes'),
(15, 'email_contacto', 'text', '', '', 'sedes'),
(16, 'celu_contacto', 'number', '', '', 'sedes'),
(17, 'nombre', 'text', '', '', 'secres'),
(18, 'apellido', 'text', '', '', 'secres'),
(19, 'email', 'email', '', '', 'secres'),
(20, 'celular', 'number', '', '', 'secres'),
(21, 'secre_de', 'selectM', 'sedes', 'nombre', 'secres'),
(22, 'nombre', 'text', '', '', 'audiciones'),
(23, 'apellido', 'text', '', '', 'audiciones'),
(24, 'email', 'email', '', '', 'audiciones'),
(25, 'celular', 'number', '', '', 'audiciones'),
(26, 'coro', 'select', 'sedes', 'nombre', 'audiciones'),
(27, 'cuerda', 'select', 'cuerdas', 'nombre', 'audiciones'),
(28, 'evaluacion_final', 'select', 'criterios', 'nombre', 'audiciones'),
(29, 'comentarios', 'area', '', '', 'audiciones'),
(30, 'fecha', 'date', '', '', 'audiciones'),
(31, 'vocalizacion', 'select', 'criterios', 'nombre', 'audiciones'),
(32, 'armonizacion', 'select', 'criterios', 'nombre', 'audiciones'),
(33, 'interpretacion', 'select', 'criterios', 'nombre', 'audiciones'),
(34, 'onda', 'select', 'criterios', 'nombre', 'audiciones'),
(35, 'traslado', 'select', 'sedes', 'nombre', 'audiciones'),
(36, 'quedo', 'select', 'mostrar', 'nombre', 'audiciones'),
(37, 'nombre', 'text', '', '', 'cuerdas'),
(38, 'nombre', 'select', '', '', 'medios_de_pago'),
(39, 'nombre', 'text', '', '', 'calioperos'),
(40, 'apellido', 'text', '', '', 'calioperos'),
(41, 'email', 'email', '', '', 'calioperos'),
(42, 'celular', 'number', '', '', 'calioperos'),
(43, 'pass', 'text', '', '', 'calioperos'),
(44, 'cuerda', 'select', 'cuerdas', 'nombre', 'calioperos'),
(45, 'activo', 'select', 'mostrar', 'nombre', 'calioperos'),
(46, 'comentarios', 'area', '', '', 'calioperos'),
(47, 'fecha_de_ingreso', 'date', '', '', 'calioperos'),
(48, 'coro', 'selectM', 'sedes', 'nombre', 'calioperos'),
(49, 'email', 'email', '', '', 'users'),
(50, 'pass', 'password', '', '', 'users'),
(51, 'id_caliopero', 'select', 'calioperos', 'id', 'asistencia'),
(52, 'asistio', 'select', 'mostrar', 'nombre', 'asistencia'),
(53, 'fecha', 'date', '', '', 'asistencia'),
(54, 'comentarios', 'area', '', '', 'asistencia'),
(55, 'id_caliopero', 'select', 'calioperos', 'id', 'pagos'),
(56, 'valor', 'number', '', '', 'pagos'),
(57, 'fecha_de_pago', 'date', '', '', 'pagos'),
(58, 'medio', 'select', 'medios_de_pago', 'nombre', 'pagos'),
(59, 'comentarios', 'area', '', '', 'pagos'),
(60, 'nombre', 'text', '', '', 'criterios');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `criterios`
--

CREATE TABLE `criterios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `criterios`
--

INSERT INTO `criterios` (`id`, `nombre`) VALUES
(2, 'Le falta'),
(3, 'Con lo justo'),
(4, 'Cumple'),
(5, 'Cumple bien'),
(6, 'Sobrado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuerdas`
--

CREATE TABLE `cuerdas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `cuerdas`
--

INSERT INTO `cuerdas` (`id`, `nombre`) VALUES
(1, 'BAJOS'),
(2, 'TENORES 1'),
(3, 'TENORES 2'),
(4, 'CONTRAS 1'),
(5, 'CONTRAS 2'),
(6, 'SOPRIS 1'),
(7, 'SOPRIS 2');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medios_de_pago`
--

CREATE TABLE `medios_de_pago` (
  `id` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `medios_de_pago`
--

INSERT INTO `medios_de_pago` (`id`, `nombre`) VALUES
(1, 'Mercado Pago'),
(2, 'Transferencia'),
(3, 'Debito de débito'),
(4, 'Tarjeta de crédito'),
(5, 'Efectivo'),
(6, 'otros');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `meses`
--

CREATE TABLE `meses` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `meses`
--

INSERT INTO `meses` (`id`, `nombre`) VALUES
(1, 'Enero'),
(2, 'Febrero'),
(3, 'Marzo'),
(4, 'Abril'),
(5, 'Mayo'),
(6, 'Junio'),
(7, 'Julio'),
(8, 'Agosto'),
(9, 'Septiembre'),
(10, 'Octubre'),
(11, 'Noviembre'),
(12, 'Diciembre');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mostrar`
--

CREATE TABLE `mostrar` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `mostrar`
--

INSERT INTO `mostrar` (`id`, `nombre`) VALUES
(1, 'si'),
(2, 'no');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos`
--

CREATE TABLE `pagos` (
  `id` int(11) NOT NULL,
  `id_caliopero` int(11) NOT NULL,
  `valor` int(11) NOT NULL,
  `fecha_de_pago` date NOT NULL,
  `medio` varchar(200) NOT NULL,
  `cometarios` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profes`
--

CREATE TABLE `profes` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `apellido` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `email` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `celular` int(20) NOT NULL,
  `profe_de` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `director_de` varchar(500) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `profes`
--

INSERT INTO `profes` (`id`, `nombre`, `apellido`, `email`, `celular`, `profe_de`, `director_de`) VALUES
(1, 'Rafael', 'Defelice', 'defelicerafal@gmail.com', 114437599, '[CATEDRAL], [TIGRE]', 'TIGRE');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `secres`
--

CREATE TABLE `secres` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `apellido` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `email` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `celular` int(20) NOT NULL,
  `secre_de` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `secres`
--

INSERT INTO `secres` (`id`, `nombre`, `apellido`, `email`, `celular`, `secre_de`) VALUES
(1, 'Mechi', 'Llorente', '', 1169412738, '[CATEDRAL]');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sedes`
--

CREATE TABLE `sedes` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `direccion` varchar(100) NOT NULL,
  `nombre_contacto` varchar(50) NOT NULL,
  `email_contacto` varchar(50) NOT NULL,
  `celu_contacto` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `sedes`
--

INSERT INTO `sedes` (`id`, `nombre`, `direccion`, `nombre_contacto`, `email_contacto`, `celu_contacto`) VALUES
(1, 'CATEDRAL', '', '', '', 0),
(2, 'TIGRE', '', '', '', 0),
(3, 'BOUTIQUE', '', '', '', 0),
(4, 'PLAY', '', '', '', 0),
(5, 'ROOTS CAPITAL', '', '', '', 0),
(6, 'ROOTS PILAR', '', '', '', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `types`
--

CREATE TABLE `types` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `mostrar` enum('si','no') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `types`
--

INSERT INTO `types` (`id`, `nombre`, `mostrar`) VALUES
(1, 'text', 'si'),
(2, 'select', 'si'),
(3, 'selectM', 'si'),
(4, 'check', 'si'),
(5, 'number', 'si'),
(6, 'email', 'si'),
(7, 'date', 'si'),
(8, 'area', 'si'),
(9, 'password', 'si');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(250) NOT NULL,
  `pass` varchar(250) NOT NULL,
  `activo` enum('si','no') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `email`, `pass`, `activo`) VALUES
(1, 'defelicerafael@gmail.com', '$2y$10$ztxAME5Fuv1UXPJdZQdYLeot0iqgcYCcopCb3cga3QRNboIJjhmWO', 'si'),
(2, 'lafi.jmusica@gmail.com', '$2y$10$lnPwPz/woYhsEM/t5H0CPOyRHfVEim.zx8veps.9Ras5E09QKgnOu', 'si'),
(3, 'mercedes.llorente@colegiopalermochico.edu.ar', '$2y$10$EIGgXclqwOmbQ4urL6Ft/OCXcS3gMn/vvCOjTKUjwHHJZyMuJzX6O', 'si'),
(4, 'lulipizarro@gmail.com', '$2y$10$EIGgXclqwOmbQ4urL6Ft/OCXcS3gMn/vvCOjTKUjwHHJZyMuJzX6O', 'si'),
(5, 'sebidela@gmail.com', '$2y$10$0rnLRSek0daXrSsVwLcDNeuk.CrOT34es/MA9C0htaRK12eEWBNeW', 'si');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `year`
--

CREATE TABLE `year` (
  `id` int(11) NOT NULL,
  `year` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `year`
--

INSERT INTO `year` (`id`, `year`) VALUES
(1, 2024);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `asistencia`
--
ALTER TABLE `asistencia`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `audiciones`
--
ALTER TABLE `audiciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `calioperos`
--
ALTER TABLE `calioperos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `configuracion_bases`
--
ALTER TABLE `configuracion_bases`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `criterios`
--
ALTER TABLE `criterios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cuerdas`
--
ALTER TABLE `cuerdas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `medios_de_pago`
--
ALTER TABLE `medios_de_pago`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `meses`
--
ALTER TABLE `meses`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `mostrar`
--
ALTER TABLE `mostrar`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `profes`
--
ALTER TABLE `profes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `secres`
--
ALTER TABLE `secres`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `sedes`
--
ALTER TABLE `sedes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `types`
--
ALTER TABLE `types`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `year`
--
ALTER TABLE `year`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `asistencia`
--
ALTER TABLE `asistencia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `audiciones`
--
ALTER TABLE `audiciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `calioperos`
--
ALTER TABLE `calioperos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `configuracion_bases`
--
ALTER TABLE `configuracion_bases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT de la tabla `criterios`
--
ALTER TABLE `criterios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `cuerdas`
--
ALTER TABLE `cuerdas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `medios_de_pago`
--
ALTER TABLE `medios_de_pago`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `meses`
--
ALTER TABLE `meses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `mostrar`
--
ALTER TABLE `mostrar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `pagos`
--
ALTER TABLE `pagos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `profes`
--
ALTER TABLE `profes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `secres`
--
ALTER TABLE `secres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `sedes`
--
ALTER TABLE `sedes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `types`
--
ALTER TABLE `types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `year`
--
ALTER TABLE `year`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
