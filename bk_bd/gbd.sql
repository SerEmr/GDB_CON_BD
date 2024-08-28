-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-08-2024 a las 07:55:21
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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `datos`
--

CREATE TABLE `datos` (
  `DatoID` int(11) NOT NULL,
  `ColumnaID` int(11) NOT NULL,
  `Valor` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(1, 'Admin', 'Admin_C', 'admin');

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
  MODIFY `BaseDeDatosID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `columnas`
--
ALTER TABLE `columnas`
  MODIFY `ColumnaID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT de la tabla `datos`
--
ALTER TABLE `datos`
  MODIFY `DatoID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT de la tabla `tablas`
--
ALTER TABLE `tablas`
  MODIFY `TablaID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

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
