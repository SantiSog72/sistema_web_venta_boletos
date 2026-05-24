-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-05-2026 a las 17:57:39
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `db_sistema_boletos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asiento`
--

CREATE TABLE `asiento` (
  `nro_asiento` int(11) NOT NULL,
  `tipo_tarifa` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `asiento`
--

INSERT INTO `asiento` (`nro_asiento`, `tipo_tarifa`) VALUES
(1, 'normal'),
(2, 'normal'),
(3, 'normal'),
(4, 'normal'),
(5, 'normal'),
(6, 'normal'),
(7, 'normal'),
(8, 'normal'),
(9, 'normal'),
(10, 'normal'),
(11, 'normal'),
(12, 'normal'),
(13, 'normal'),
(14, 'normal'),
(15, 'normal'),
(16, 'normal'),
(17, 'normal'),
(18, 'normal'),
(19, 'normal'),
(20, 'normal'),
(21, 'promocional'),
(22, 'promocional'),
(23, 'promocional'),
(24, 'promocional'),
(25, 'promocional'),
(26, 'promocional'),
(27, 'promocional'),
(28, 'promocional'),
(29, 'promocional'),
(30, 'promocional'),
(31, 'promocional'),
(32, 'promocional'),
(33, 'promocional'),
(34, 'promocional'),
(35, 'promocional'),
(36, 'promocional'),
(37, 'promocional'),
(38, 'promocional'),
(39, 'promocional'),
(40, 'promocional'),
(41, 'promocional'),
(42, 'promocional'),
(43, 'promocional'),
(44, 'promocional'),
(45, 'promocional'),
(46, 'promocional'),
(47, 'promocional'),
(48, 'promocional'),
(49, 'ejecutiva'),
(50, 'ejecutiva'),
(51, 'ejecutiva'),
(52, 'ejecutiva'),
(53, 'ejecutiva'),
(54, 'ejecutiva'),
(55, 'ejecutiva'),
(56, 'ejecutiva'),
(57, 'ejecutiva'),
(58, 'ejecutiva'),
(59, 'ejecutiva'),
(60, 'ejecutiva');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `boleto`
--

CREATE TABLE `boleto` (
  `nro_boleto` int(11) NOT NULL,
  `fecha_emision` varchar(10) NOT NULL DEFAULT current_timestamp(),
  `fecha_viaje` varchar(10) NOT NULL,
  `cod_ruta` varchar(20) NOT NULL,
  `nro_asiento` int(11) NOT NULL,
  `tipo_tarifa` varchar(20) NOT NULL,
  `precio_final` decimal(10,2) NOT NULL,
  `dni_usuario` varchar(8) NOT NULL,
  `dni_pasajero` varchar(8) NOT NULL,
  `pago_efectivo` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `boleto`
--

INSERT INTO `boleto` (`nro_boleto`, `fecha_emision`, `fecha_viaje`, `cod_ruta`, `nro_asiento`, `tipo_tarifa`, `precio_final`, `dni_usuario`, `dni_pasajero`, `pago_efectivo`) VALUES
(1, '2026-5-13', '2026-06-30', 'BA_COR_2200', 13, 'normal', 53200.00, '12345678', '12345678', 1),
(2, '10/05/2026', '2026-06-30', 'BA_COR_2200', 12, 'normal', 53200.00, '12345678', '87654321', 1),
(3, '2026-05-20', '2026-06-30', 'BA_COR_2200', 11, 'normal', 53200.00, '12345678', '43480639', 1),
(4, '2026-05-20', '2026-06-30', 'BA_COR_2200', 51, 'ejecutiva', 106400.00, '12345678', '22222222', 0),
(5, '2026-05-20', '2026-06-30', 'BA_COR_2200', 33, 'promocional', 15960.00, '12345678', '11111111', 1),
(6, '2026-05-21', '2026-06-29', 'BA_MP_0800', 5, 'normal', 42600.00, '12345678', '88888888', 1),
(7, '2026-05-21', '2026-06-29', 'BA_MP_0800', 51, 'ejecutiva', 85200.00, '12345678', '11111111', 1),
(8, '2026-05-21', '2026-06-29', 'BA_MP_0800', 4, 'normal', 42600.00, '12345678', '44444444', 1),
(9, '2026-05-21', '2026-06-30', 'BA_COR_2200', 3, 'normal', 53200.00, '12345678', '55555555', 1),
(10, '2026-05-21', '2026-06-30', 'BA_COR_2200', 1, 'normal', 53200.00, '12345678', '99999999', 1),
(11, '2026-05-22', '2026-06-29', 'BA_MP_0800', 27, 'promocional', 12780.00, '12345678', '33333333', 1),
(12, '2026-05-22', '2026-06-29', 'BA_MP_0800', 20, 'normal', 42600.00, '12345678', '73019452', 1),
(13, '2026-05-23', '2026-06-30', 'BA_COR_2200', 24, 'promocional', 15960.00, '12345678', '63078215', 1),
(14, '2026-05-23', '2026-06-30', 'BA_COR_2200', 36, 'promocional', 15960.00, '12345678', '61048364', 1),
(15, '2026-05-23', '2026-06-30', 'BA_COR_2200', 43, 'promocional', 15960.00, '12345678', '64938512', 1),
(16, '2026-05-23', '2026-06-30', 'BA_COR_2200', 59, 'ejecutiva', 106400.00, '12345678', '49722956', 1),
(17, '2026-05-23', '2026-06-30', 'BA_COR_2200', 22, 'promocional', 15960.00, '12345678', '37343333', 1),
(18, '2026-05-23', '2026-06-30', 'BA_COR_2200', 31, 'promocional', 15960.00, '12345678', '37777777', 1),
(19, '2026-05-24', '2026-06-30', 'BA_COR_2200', 46, 'promocional', 39900.00, '12345678', '75001234', 0),
(20, '2026-05-19', '2026-01-30', 'BA_COR_2200', 5, 'normal', 53200.00, '22222222', '11111111', 1),
(21, '2026-05-10', '2026-06-29', 'BA_COR_2200', 51, 'ejecutiva', 106400.00, '22222222', '43480639', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pasajero`
--

CREATE TABLE `pasajero` (
  `dni` varchar(8) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pasajero`
--

INSERT INTO `pasajero` (`dni`, `apellido`, `nombre`) VALUES
('11111111', 'uno', 'ochos'),
('12345678', 'Gonzales', 'Pepe'),
('22222222', 'uno', 'ochos'),
('33333333', 'paluza', 'lola'),
('37343333', 'Sanchez', 'pepe'),
('37777777', 'como', 'ochos'),
('43480639', 'servin', 'santiago'),
('44444444', 'Gonzales', 'juan'),
('49722956', 'servin', 'santiago'),
('55555555', 'como', 'pepe'),
('61048364', 'perez', 'pedrito'),
('63078215', 'yuri', 'zapian'),
('64938512', 'palacini', 'juan'),
('73019452', 'ceballos', 'franco'),
('75001234', 'Sanchez', 'pedro'),
('83740174', 'argento', 'juan'),
('87654321', 'Servin', 'Santiago'),
('88888888', 'argento', 'pepe'),
('99999999', 'rodriguez', 'laucha');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ruta`
--

CREATE TABLE `ruta` (
  `cod_ruta` varchar(20) NOT NULL,
  `lugar_origen` varchar(100) NOT NULL,
  `lugar_destino` varchar(100) NOT NULL,
  `tarifa_normal` int(20) NOT NULL,
  `duracion` varchar(5) NOT NULL,
  `hora_salida` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ruta`
--

INSERT INTO `ruta` (`cod_ruta`, `lugar_origen`, `lugar_destino`, `tarifa_normal`, `duracion`, `hora_salida`) VALUES
('BA_COR_2200', 'Buenos Aires', 'Córdoba', 53200, '0', '22:00'),
('BA_MP_0800', 'Buenos Aires', 'Mar del Plata', 42600, '0', '08:00'),
('BA_MP_1800', 'Buenos Aires', 'Mar del Plata', 42600, '0', '18:00'),
('BA_ROS_0600', 'Buenos Aires', 'Rosario', 52700, '0', '06:00'),
('BA_ROS_2030', 'Buenos Aires', 'Rosario', 52700, '0', '20:30'),
('COR_BA_2100', 'Córdoba', 'Buenos Aires', 53200, '0', '21:00'),
('COR_RC_1100', 'Córdoba', 'Rio Cuarto', 21250, '0', '11:00'),
('MP_BA_0700', 'Mar del Plata', 'Buenos Aires', 42600, '0', '07:00'),
('MP_BA_1300', 'Mar del Plata', 'Buenos Aires', 42600, '0', '13:00'),
('RC_COR_1600', 'Rio Cuarto', 'Córdoba', 21250, '0', '16:00'),
('ROS_BA_0730', 'Rosario', 'Buenos Aires', 52700, '0', '07:30'),
('ROS_BA_1600', 'Rosario', 'Buenos Aires', 52700, '0', '16:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `dni` varchar(8) NOT NULL,
  `contrasena` varchar(200) NOT NULL,
  `nombre_usuario` varchar(100) NOT NULL,
  `primer_nombre` varchar(100) NOT NULL,
  `segundo_nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `nro_celular` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`dni`, `contrasena`, `nombre_usuario`, `primer_nombre`, `segundo_nombre`, `apellido`, `nro_celular`, `email`) VALUES
('11111111', 'Contraseña123', 'dafdsfdafd', 'santiago', 'pepe', 'Sanchez', '12345678', 'santiago@samchez'),
('12345678', '12345678', 'pepe1990', 'Pepe', 'Carlos', 'Gonzales', '2971234567', 'pepe@Gonzale.com'),
('22222222', '11111111', 'usuario1', 'juan', 'pepe', 'menzi', '12345678', 'pepe@menzi');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_frecuente`
--

CREATE TABLE `usuario_frecuente` (
  `dni` varchar(8) NOT NULL,
  `puntos` int(10) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario_frecuente`
--

INSERT INTO `usuario_frecuente` (`dni`, `puntos`) VALUES
('11111111', 0),
('12345678', 28579);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `viaje`
--

CREATE TABLE `viaje` (
  `fecha_viaje` varchar(10) NOT NULL,
  `cod_ruta` varchar(20) NOT NULL,
  `fecha_llegada` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `viaje`
--

INSERT INTO `viaje` (`fecha_viaje`, `cod_ruta`, `fecha_llegada`) VALUES
('2026-01-30', 'BA_COR_2200', '2026-01-30'),
('2026-06-17', 'COR_BA_2100', NULL),
('2026-06-17', 'MP_BA_0700', NULL),
('2026-06-22', 'BA_MP_0800', NULL),
('2026-06-29', 'BA_COR_2200', NULL),
('2026-06-29', 'BA_MP_0800', NULL),
('2026-06-30', 'BA_COR_2200', '2026-6-30'),
('2026-06-30', 'BA_MP_0800', '2026-6-30'),
('2026-06-30', 'BA_MP_1800', NULL),
('2026-06-30', 'BA_ROS_0600', NULL),
('2026-06-30', 'BA_ROS_2030', NULL),
('2026-06-30', 'COR_BA_2100', '2026-6-30'),
('2026-06-30', 'RC_COR_1600', NULL),
('2026-06-30', 'ROS_BA_1600', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `asiento`
--
ALTER TABLE `asiento`
  ADD PRIMARY KEY (`nro_asiento`);

--
-- Indices de la tabla `boleto`
--
ALTER TABLE `boleto`
  ADD PRIMARY KEY (`nro_boleto`),
  ADD UNIQUE KEY `asiento_unico_por_viaje` (`fecha_viaje`,`cod_ruta`,`nro_asiento`),
  ADD UNIQUE KEY `unico_pasajero_por_viaje` (`fecha_viaje`,`cod_ruta`,`dni_pasajero`),
  ADD KEY `boleto_ibfk_2` (`nro_asiento`),
  ADD KEY `boleto_ibfk_3` (`dni_usuario`),
  ADD KEY `boleto_ibfk_4` (`dni_pasajero`);

--
-- Indices de la tabla `pasajero`
--
ALTER TABLE `pasajero`
  ADD PRIMARY KEY (`dni`);

--
-- Indices de la tabla `ruta`
--
ALTER TABLE `ruta`
  ADD PRIMARY KEY (`cod_ruta`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`dni`);

--
-- Indices de la tabla `usuario_frecuente`
--
ALTER TABLE `usuario_frecuente`
  ADD PRIMARY KEY (`dni`);

--
-- Indices de la tabla `viaje`
--
ALTER TABLE `viaje`
  ADD PRIMARY KEY (`fecha_viaje`,`cod_ruta`),
  ADD KEY `cod_ruta` (`cod_ruta`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `boleto`
--
ALTER TABLE `boleto`
  MODIFY `nro_boleto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `boleto`
--
ALTER TABLE `boleto`
  ADD CONSTRAINT `boleto_ibfk_1` FOREIGN KEY (`fecha_viaje`,`cod_ruta`) REFERENCES `viaje` (`fecha_viaje`, `cod_ruta`) ON UPDATE CASCADE,
  ADD CONSTRAINT `boleto_ibfk_2` FOREIGN KEY (`nro_asiento`) REFERENCES `asiento` (`nro_asiento`) ON UPDATE CASCADE,
  ADD CONSTRAINT `boleto_ibfk_3` FOREIGN KEY (`dni_usuario`) REFERENCES `usuario` (`dni`) ON UPDATE CASCADE,
  ADD CONSTRAINT `boleto_ibfk_4` FOREIGN KEY (`dni_pasajero`) REFERENCES `pasajero` (`dni`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuario_frecuente`
--
ALTER TABLE `usuario_frecuente`
  ADD CONSTRAINT `usuario_frecuente_ibfk_1` FOREIGN KEY (`dni`) REFERENCES `usuario` (`dni`);

--
-- Filtros para la tabla `viaje`
--
ALTER TABLE `viaje`
  ADD CONSTRAINT `viaje_ibfk_1` FOREIGN KEY (`cod_ruta`) REFERENCES `ruta` (`cod_ruta`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
