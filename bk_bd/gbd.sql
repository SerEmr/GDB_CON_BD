-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-03-2024 a las 17:14:12
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
-- Base de datos: `gbd`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `basesdedatos`
--

CREATE TABLE `basesdedatos` (
  `BaseDeDatosID` int(11) NOT NULL,
  `Nombre` varchar(255) NOT NULL,
  `Cotejamiento` varchar(30) NOT NULL,
  `UsuarioID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `basesdedatos`
--

INSERT INTO `basesdedatos` (`BaseDeDatosID`, `Nombre`, `Cotejamiento`, `UsuarioID`) VALUES
(20, 'GBD', 'utf8_general_ci', 1),
(22, 'Supermercado', 'utf8mb4_unicode_ci', 1),
(25, 'GBD2', 'utf8mb4_unicode_ci', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `columnas`
--

CREATE TABLE `columnas` (
  `ColumnaID` int(11) NOT NULL,
  `Nombre` varchar(255) NOT NULL,
  `Tipo` varchar(255) NOT NULL,
  `AutoIncrement` varchar(10) NOT NULL,
  `PK` varchar(10) NOT NULL,
  `Nulo` varchar(10) NOT NULL,
  `TablaID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `columnas`
--

INSERT INTO `columnas` (`ColumnaID`, `Nombre`, `Tipo`, `AutoIncrement`, `PK`, `Nulo`, `TablaID`) VALUES
(56, 'id_usuarios', 'INT', 'Si', 'Si', 'No', 25),
(57, 'Nombre_usuario', 'VARCHAR(20)', 'No', 'No', 'No', 25),
(58, 'Nombre_completo', 'VARCHAR(30)', 'No', 'No', 'No', 25),
(59, 'edad', 'INT', 'No', 'No', 'No', 25),
(61, 'id_sucursal', 'INT', 'Si', 'Si', 'No', 26),
(62, 'nombre_sucursal', 'VARCHAR(40)', 'No', 'No', 'No', 26),
(63, 'direccion', 'TEXT', 'No', 'No', 'No', 26),
(64, 'RFC', 'VARCHAR(70)', 'No', 'No', 'No', 26),
(65, 'id_personas', 'INT', 'Si', 'Si', 'No', 27),
(66, 'nombre_persona', 'VARCHAR(40)', 'No', 'No', 'No', 27),
(67, 'edad', 'INT', 'No', 'No', 'No', 27),
(72, 'id_prueba', 'INT', 'Si', 'Si', 'No', 29),
(73, 'nombre_prueba', 'VARCHAR(40)', 'No', 'No', 'No', 29),
(74, 'id_prueba', 'INT', 'Si', 'Si', 'No', 30),
(75, 'nombre', 'TEXT', 'No', 'No', 'No', 30),
(76, 'edad', 'INT', 'No', 'No', 'No', 30),
(77, 'rfc', 'VARCHAR(40)', 'No', 'No', 'No', 30),
(78, 'curp', 'VARCHAR(50)', 'No', 'No', 'No', 30),
(79, 'dia_nacimiento', 'VARCHAR(50)', 'No', 'No', 'No', 30),
(80, 'SS', 'VARCHAR(50)', 'No', 'No', 'No', 30),
(81, 'Matricula', 'VARCHAR(50)', 'No', 'No', 'No', 30),
(82, 'ine', 'VARCHAR(50)', 'No', 'No', 'No', 30);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `datos`
--

CREATE TABLE `datos` (
  `DatoID` int(11) NOT NULL,
  `ColumnaID` int(11) NOT NULL,
  `Valor` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `datos`
--

INSERT INTO `datos` (`DatoID`, `ColumnaID`, `Valor`) VALUES
(26, 61, '1'),
(27, 62, 'Pedrito supermarket'),
(28, 63, 'Avenida san pablo del meoyo'),
(29, 64, 'JKK384PPP'),
(34, 65, '1'),
(35, 66, 'Lalox'),
(36, 67, '18'),
(46, 56, '2'),
(47, 57, 'Yochix'),
(48, 58, 'Sergio Eduardo '),
(49, 59, '23'),
(54, 72, '1'),
(55, 73, 'Prueba3');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tablas`
--

CREATE TABLE `tablas` (
  `TablaID` int(11) NOT NULL,
  `Nombre` varchar(255) NOT NULL,
  `Motor_alm` varchar(30) NOT NULL,
  `BaseDeDatosID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tablas`
--

INSERT INTO `tablas` (`TablaID`, `Nombre`, `Motor_alm`, `BaseDeDatosID`) VALUES
(25, 'usuarios', 'MyISAM', 20),
(26, 'Sucursal', 'InnoDB', 22),
(27, 'personas', 'MyISAM', 20),
(29, 'prueba44', 'MyISAM', 25),
(30, 'prueba55', 'MyISAM', 25);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `UsuarioID` int(11) NOT NULL,
  `Usuario` varchar(25) NOT NULL,
  `PasswordHash` varchar(255) NOT NULL,
  `Rol` enum('admin','usuario') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`UsuarioID`, `Usuario`, `PasswordHash`, `Rol`) VALUES
(1, 'Sergio', 'cheyo2003', 'admin');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `basesdedatos`
--
ALTER TABLE `basesdedatos`
  ADD PRIMARY KEY (`BaseDeDatosID`),
  ADD KEY `UsuarioID` (`UsuarioID`);

--
-- Indices de la tabla `columnas`
--
ALTER TABLE `columnas`
  ADD PRIMARY KEY (`ColumnaID`),
  ADD KEY `TablaID` (`TablaID`);

--
-- Indices de la tabla `datos`
--
ALTER TABLE `datos`
  ADD PRIMARY KEY (`DatoID`),
  ADD KEY `ColumnaID` (`ColumnaID`);

--
-- Indices de la tabla `tablas`
--
ALTER TABLE `tablas`
  ADD PRIMARY KEY (`TablaID`),
  ADD KEY `BaseDeDatosID` (`BaseDeDatosID`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`UsuarioID`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `basesdedatos`
--
ALTER TABLE `basesdedatos`
  MODIFY `BaseDeDatosID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `columnas`
--
ALTER TABLE `columnas`
  MODIFY `ColumnaID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT de la tabla `datos`
--
ALTER TABLE `datos`
  MODIFY `DatoID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT de la tabla `tablas`
--
ALTER TABLE `tablas`
  MODIFY `TablaID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `UsuarioID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `basesdedatos`
--
ALTER TABLE `basesdedatos`
  ADD CONSTRAINT `basesdedatos_ibfk_1` FOREIGN KEY (`UsuarioID`) REFERENCES `usuarios` (`UsuarioID`) ON DELETE SET NULL;

--
-- Filtros para la tabla `columnas`
--
ALTER TABLE `columnas`
  ADD CONSTRAINT `columnas_ibfk_1` FOREIGN KEY (`TablaID`) REFERENCES `tablas` (`TablaID`) ON DELETE CASCADE;

--
-- Filtros para la tabla `datos`
--
ALTER TABLE `datos`
  ADD CONSTRAINT `datos_ibfk_1` FOREIGN KEY (`ColumnaID`) REFERENCES `columnas` (`ColumnaID`) ON DELETE CASCADE;

--
-- Filtros para la tabla `tablas`
--
ALTER TABLE `tablas`
  ADD CONSTRAINT `tablas_ibfk_1` FOREIGN KEY (`BaseDeDatosID`) REFERENCES `basesdedatos` (`BaseDeDatosID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
