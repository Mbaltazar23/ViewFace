-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-12-2022 a las 23:32:17
-- Versión del servidor: 10.4.6-MariaDB
-- Versión de PHP: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `viewface`
--
CREATE DATABASE IF NOT EXISTS `viewface` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `viewface`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

DROP TABLE IF EXISTS `categoria`;
CREATE TABLE `categoria` (
  `idCategoria` int(11) NOT NULL,
  `NombreCategoria` varchar(45) NOT NULL,
  `DescripcionCategoria` varchar(45) NOT NULL,
  `EstadoCategoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`idCategoria`, `NombreCategoria`, `DescripcionCategoria`, `EstadoCategoria`) VALUES
(1, 'Carnes', 'son las carnes mas deliciosas de arica', 1),
(2, 'Lacteos', 'son los yogures mas ricos de chile', 0),
(3, 'Frutas', 'son las frutas mas dulces de todo chile', 1),
(4, 'verduras', 'son las verduras mas dulces de chile', 1),
(5, 'Enjuagues', 'son para mantener la boca en buen estado de h', 1),
(6, 'Pastas', 'son las pastas mas ricas de todo chile', 1),
(7, 'Refrigerios', 'son los refrigerios mas ricos', 1),
(8, 'frituras', 'sera una categoria para la comida grasosa', 1),
(9, 'Alcohol', 'seran la marca mas util de todo chile', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

DROP TABLE IF EXISTS `cliente`;
CREATE TABLE `cliente` (
  `idCliente` int(11) NOT NULL,
  `NombreCliente` varchar(50) NOT NULL,
  `ClaveCliente` varchar(45) NOT NULL,
  `TelefonoCliente` varchar(45) NOT NULL,
  `VinculoCliente` int(11) NOT NULL,
  `ClienteEstado` int(11) DEFAULT NULL,
  `CargoCliente` varchar(55) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`idCliente`, `NombreCliente`, `ClaveCliente`, `TelefonoCliente`, `VinculoCliente`, `ClienteEstado`, `CargoCliente`) VALUES
(23, 'Mario', '671809fc411ab7898b89e27b23ed674a', '+56975745575', 42, 1, ''),
(24, 'Barry', 'f5a3225d25cc265fb9bea757ad7b46b4', '+56956657575', 50, 1, ''),
(25, 'Pepe', 'ce4472f5facc7d2467ad9b89cc564e48', '+56967894561', 43, 1, 'tiene un local de pescados'),
(26, 'Raul', 'a60f6f9da3b479dc820a530203d55859', '+56956354646', 51, 1, 'tiene el cargo en un negocio de frutas'),
(27, 'Betin', '671809fc411ab7898b89e27b23ed674a', '+56954656575', 52, 1, ''),
(28, 'juan', 'a60f6f9da3b479dc820a530203d55859', '+56965757867', 53, 1, ''),
(29, 'alex', '37826646153b9a437ab77cc85da2daaf', '+56956576586', 54, 0, ''),
(30, 'Juanit', 'a60f6f9da3b479dc820a530203d55859', '+56946576786', 55, 1, ''),
(31, 'Perico', 'a89f1d2ef4071237cf372630b350f031', '+56986757959', 49, 1, ''),
(32, 'Macerl', 'cef8d62415b2ac554e34a210f7dca5a2', '+56968867897', 56, 1, 'tiene un cargo de cajero'),
(33, 'A', 'd1c373360bf592bf735c72c210cd9a74', '+56978686868', 57, 0, ''),
(34, 'Juanita', '29efab395f1d714d51770521f1bcf7ea', '+56966876867', 59, 1, 'cajera'),
(35, 'Pepiño', '29efab395f1d714d51770521f1bcf7ea', '+56986564574', 58, 1, ''),
(36, 'Mario', '29efab395f1d714d51770521f1bcf7ea', '+56975647575', 60, 1, ''),
(37, 'Waldo de la barra', '83e43f3f074f1d000615e4f91470ff4c', '+56955657576', 61, 1, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comuna`
--

DROP TABLE IF EXISTS `comuna`;
CREATE TABLE `comuna` (
  `idComuna` int(11) NOT NULL,
  `ComunaNombre` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `comuna`
--

INSERT INTO `comuna` (`idComuna`, `ComunaNombre`) VALUES
(1, 'Arica y Parinacota'),
(2, 'Tarapacá'),
(3, 'Antofagasta'),
(4, 'Atacama'),
(5, 'Coquimbo'),
(6, 'Valparaiso'),
(7, 'Metropolitana de Santiago'),
(8, 'Libertador General Bernardo O\'Higgins'),
(9, 'Maule'),
(10, 'Ñuble'),
(11, 'Biobío'),
(12, 'La Araucanía'),
(13, 'Los Ríos'),
(14, 'Los Lagos'),
(15, 'Aysén del General Carlos Ibáñez del Campo'),
(16, 'Magallanes y de la Antártica Chilena');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detallecargocliente`
--

DROP TABLE IF EXISTS `detallecargocliente`;
CREATE TABLE `detallecargocliente` (
  `idDetalleCargoCliente` int(11) NOT NULL,
  `ClienteCargo` int(11) NOT NULL,
  `NegocioCargo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `detallecargocliente`
--

INSERT INTO `detallecargocliente` (`idDetalleCargoCliente`, `ClienteCargo`, `NegocioCargo`) VALUES
(1, 23, 11),
(2, 24, 11),
(3, 25, 9),
(4, 26, 7),
(6, 27, 11),
(8, 28, 11),
(10, 29, 11),
(12, 31, 11),
(13, 32, 8),
(14, 33, 11),
(15, 34, 8),
(16, 35, 11),
(17, 36, 8),
(18, 37, 11);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalleventa`
--

DROP TABLE IF EXISTS `detalleventa`;
CREATE TABLE `detalleventa` (
  `idDetalleVenta` int(11) NOT NULL,
  `CantidadVenta` int(11) DEFAULT NULL,
  `PrecioVenta` varchar(45) DEFAULT NULL,
  `InsumoVendido` int(11) NOT NULL,
  `VentaId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `detalleventa`
--

INSERT INTO `detalleventa` (`idDetalleVenta`, `CantidadVenta`, `PrecioVenta`, `InsumoVendido`, `VentaId`) VALUES
(63, 5, '2000', 2, 81),
(64, 3, '450', 18, 81),
(65, 2, '1800', 17, 82),
(66, 4, '2300', 8, 82),
(67, 2, '2000', 2, 82),
(68, 8, '300', 7, 83),
(69, 3, '340', 6, 84),
(70, 4, '2000', 2, 85),
(71, 3, '2300', 8, 86),
(72, 4, '300', 7, 86),
(75, 3, '2000', 2, 88),
(76, 3, '300', 7, 89),
(77, 3, '450', 18, 90),
(78, 2, '340', 4, 91),
(79, 3, '2000', 2, 92),
(80, 3, '340', 6, 93),
(81, 2, '340', 4, 94),
(82, 2, '340', 6, 94),
(83, 2, '340', 6, 95),
(85, 2, '2300', 8, 87),
(86, 3, '340', 6, 87),
(88, 3, '340', 6, 97),
(89, 3, '450', 18, 97),
(92, 4, '300', 7, 99),
(93, 3, '2000', 2, 100),
(94, 3, '2300', 8, 101),
(95, 2, '340', 4, 102),
(96, 3, '2300', 8, 103),
(97, 2, '300', 7, 104),
(98, 3, '340', 6, 105),
(105, 2, '1800', 17, 98),
(111, 2, '340', 6, 108),
(112, 2, '340', 4, 108),
(115, 3, '450', 18, 109),
(116, 3, '200', 9, 109),
(117, 4, '500', 5, 109),
(120, 3, '2000', 2, 110),
(121, 2, '2300', 8, 111),
(122, 2, '340', 4, 112),
(125, 4, '500', 5, 114),
(126, 3, '400', 16, 114),
(138, 4, '400', 16, 115),
(139, 2, '3400', 3, 115),
(140, 4, '500', 18, 116),
(141, 3, '1890', 9, 116),
(142, 4, '340', 6, 106),
(143, 2, '3000', 10, 106),
(144, 3, '500', 14, 106),
(145, 4, '500', 14, 117),
(146, 3, '2300', 8, 117),
(147, 4, '500', 14, 118),
(148, 1, '4200', 19, 118),
(149, 3, '2300', 8, 96),
(152, 2, '1800', 17, 107),
(153, 2, '500', 14, 107),
(154, 3, '2200', 3, 107),
(155, 3, '200', 9, 113),
(156, 2, '500', 18, 113);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `direccion`
--

DROP TABLE IF EXISTS `direccion`;
CREATE TABLE `direccion` (
  `idDireccion` int(11) NOT NULL,
  `DireccionNombre` varchar(45) DEFAULT NULL,
  `DireccionComuna` int(11) NOT NULL,
  `ValorEnvio` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `direccion`
--

INSERT INTO `direccion` (`idDireccion`, `DireccionNombre`, `DireccionComuna`, `ValorEnvio`) VALUES
(1, 'Pedro Aguirre Cerda', 1, 500),
(2, 'Juan Antonio Rios', 1, 600),
(3, '21 de mayo', 1, 800),
(4, 'Las petunias', 1, 390),
(5, 'Alonso SantoBeña', 2, 370),
(6, 'avenida siempre Viva', 3, 900),
(7, 'Calle Queen\'s', 3, 690),
(8, 'arturo Pratt 34', 1, 790),
(9, 'pasaje San bernardo', 1, 690),
(10, 'Pedro con quillaes', 1, 780),
(11, '1 de mayo ', 1, 880),
(12, 'Las cucarachas', 4, 670),
(13, 'juan antonio', 4, 600),
(14, 'metropolis 1554', 4, 700);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `insumo`
--

DROP TABLE IF EXISTS `insumo`;
CREATE TABLE `insumo` (
  `idInsumo` int(11) NOT NULL,
  `NombreInsumo` varchar(50) NOT NULL,
  `DescripcionInsumo` text NOT NULL,
  `EstadoInsumo` int(11) NOT NULL,
  `CategoriaInsumo` int(11) NOT NULL,
  `CantidadInsumo` int(11) NOT NULL,
  `PrecioUnitarioInsumo` double DEFAULT NULL,
  `PrecioTotalInsumo` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `insumo`
--

INSERT INTO `insumo` (`idInsumo`, `NombreInsumo`, `DescripcionInsumo`, `EstadoInsumo`, `CategoriaInsumo`, `CantidadInsumo`, `PrecioUnitarioInsumo`, `PrecioTotalInsumo`) VALUES
(2, 'SuperPollo', 'son los pollos mas dulces de todo chile', 1, 1, 4, 2000, 8000),
(3, 'Pavo Aristia', 'son los pagos mas ricos de todo Arica', 1, 1, 15, 2200, 33000),
(4, 'Yogures', 'son los yogures mas mas livianos de todo chile', 0, 2, 10, 345, 3450),
(5, 'Paltas', 'son las paltas mas deliciosas de todo chile', 0, 4, 76, 500, 38000),
(6, 'Yogur Lite', 'son los yogures mas livianos', 0, 2, 11, 340, 3740),
(7, 'Yogu-Yogu', 'son los yogures mas vendidos', 0, 2, 18, 300, 5400),
(8, 'Filete de Res', 'son los filetes mas sabrosos de chile', 1, 1, 2, 2300, 4600),
(9, 'Pasta Dental', 'es la pasta dental mas limpia de todo ', 1, 5, 8, 1890, 15120),
(10, 'Pavos', 'son los pavos mas ricos de todo Chile', 1, 1, 21, 3000, 63000),
(12, 'Filete de Carnero', 'es la carne mas amplia', 1, 1, 120, 3400, 408000),
(14, 'Peras', 'son las frutas mas aguadas', 1, 3, 1, 500, 500),
(16, 'Fideo verde', 'son los fideos mas sanos', 1, 6, 25, 400, 10000),
(17, 'Pasta dentas', 'son la pasta dental mas economica de chile', 1, 5, 10, 1800, 18000),
(18, 'Pepinos', 'son los pepinos mas verdes', 1, 4, 37, 500, 18500),
(19, 'Champaña', 'son la botella mas deliciosa de todo la comuna', 1, 9, 95, 4200, 399000);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mercancia`
--

DROP TABLE IF EXISTS `mercancia`;
CREATE TABLE `mercancia` (
  `idMercancia` int(11) NOT NULL,
  `NombreMercancia` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `mercancia`
--

INSERT INTO `mercancia` (`idMercancia`, `NombreMercancia`) VALUES
(1, 'bebidas'),
(2, 'basado en leche'),
(3, 'licores'),
(4, 'dulces artificiales'),
(5, 'dulces naturales'),
(6, 'refrigerios'),
(7, 'embutidos'),
(8, 'encurtidos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `negocio`
--

DROP TABLE IF EXISTS `negocio`;
CREATE TABLE `negocio` (
  `idNegocio` int(11) NOT NULL,
  `NegocioNombre` varchar(45) NOT NULL,
  `NegocioDescripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `negocio`
--

INSERT INTO `negocio` (`idNegocio`, `NegocioNombre`, `NegocioDescripcion`) VALUES
(7, 'Abarroteria', NULL),
(8, 'Supermercado', NULL),
(9, 'Local de pescados', 'es el local mas amplio'),
(10, 'Negocio Agricola', NULL),
(11, 'Sin negocio Fijo', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pago`
--

DROP TABLE IF EXISTS `pago`;
CREATE TABLE `pago` (
  `idPago` int(11) NOT NULL,
  `PagoFecha` datetime NOT NULL,
  `PagoDescripcion` text DEFAULT NULL,
  `PagoMonto` double DEFAULT NULL,
  `PagoEstado` varchar(55) DEFAULT NULL,
  `VentaPagada` int(11) NOT NULL,
  `TipoPago` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `pago`
--

INSERT INTO `pago` (`idPago`, `PagoFecha`, `PagoDescripcion`, `PagoMonto`, `PagoEstado`, `VentaPagada`, `TipoPago`) VALUES
(31, '2021-06-05 01:22:17', 'pagare con efectivo', 17590, '1', 82, 1),
(34, '2021-06-05 01:27:20', 'pagare con cheque', 8800, '1', 85, 2),
(35, '2021-06-08 00:11:55', 'pagare esta deuda y esperare a que me lo traigan', 6670, '1', 100, 2),
(37, '2021-06-08 00:13:48', 'pagare con efectivo estos yogures', 1810, '1', 105, 1),
(38, '2021-06-09 20:58:45', 'pagare con efectivo estos productos', 11850, '0', 81, 1),
(39, '2021-06-13 01:44:40', 'pagare con un deposito cuando me llegue', 5750, '0', 109, 3),
(40, '2021-06-15 20:51:03', 'pagare esto con un deposito bancario', 4990, '0', 111, 3),
(41, '2021-06-16 20:50:43', 'pagare con efectivo cuando me llegue', 4000, '0', 114, 1),
(42, '2021-07-01 20:52:27', 'pagare esta venta', 8900, '1', 115, 1),
(44, '2021-07-01 21:02:23', 'pagare estos productos', 8270, '1', 116, 1),
(45, '2021-07-05 00:18:35', 'pagare con cheque', 6600, '1', 110, 2),
(46, '2021-07-05 00:31:16', 'pagare con efectivo esta venta', 7000, '1', 118, 1),
(47, '2021-07-12 21:29:39', 'pagare con deposito bancario', 8700, '1', 86, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal`
--

DROP TABLE IF EXISTS `personal`;
CREATE TABLE `personal` (
  `idPersonal` int(11) NOT NULL,
  `CorreoPersonal` varchar(45) NOT NULL,
  `ClavePersonal` varchar(45) NOT NULL,
  `CargoPersonal` varchar(45) NOT NULL,
  `PerfilUsuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `personal`
--

INSERT INTO `personal` (`idPersonal`, `CorreoPersonal`, `ClavePersonal`, `CargoPersonal`, `PerfilUsuario`) VALUES
(1, 'Julia45@gmail.com', '2344521e389d6897ae7af9abf16e7ccc', 'Jefa', 3),
(2, 'Sergio35@gmail.com', '2344521e389d6897ae7af9abf16e7ccc', 'Contador Auditor', 1),
(3, 'Ivan34@gmail.com', '2344521e389d6897ae7af9abf16e7ccc', 'Analista-financiero', 2),
(4, 'Marcela45@gmail.com', '2344521e389d6897ae7af9abf16e7ccc', 'Administrador de Empresas', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recibo`
--

DROP TABLE IF EXISTS `recibo`;
CREATE TABLE `recibo` (
  `idRecibo` int(11) NOT NULL,
  `ReciboTelefono` varchar(45) NOT NULL,
  `SubTotalRecibo` double NOT NULL,
  `TotalRecibo` double NOT NULL,
  `DireccionRecibo` text NOT NULL,
  `ReciboFecha` datetime DEFAULT NULL,
  `EstadoRecibo` int(11) NOT NULL,
  `ReciboPago` int(11) NOT NULL,
  `ReciboComuna` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `recibo`
--

INSERT INTO `recibo` (`idRecibo`, `ReciboTelefono`, `SubTotalRecibo`, `TotalRecibo`, `DireccionRecibo`, `ReciboFecha`, `EstadoRecibo`, `ReciboPago`, `ReciboComuna`) VALUES
(11, '+56975745575', 8000, 8800, '21 de mayo', '2021-06-05 01:27:20', 1, 34, 1),
(12, '+56975745575', 6000, 6670, 'Las cucarachas', '2021-06-08 00:11:55', 1, 35, 4),
(14, '+56975745575', 1020, 1810, 'arturo Pratt 34', '2021-06-08 00:13:48', 1, 37, 1),
(15, '+56975745575', 11350, 11850, 'Pedro Aguirre Cerda', '2021-06-09 20:58:45', 0, 38, 1),
(16, '+56956354646', 4950, 5750, '21 de mayo', '2021-06-13 01:44:40', 1, 39, 1),
(17, '+56967894561', 4600, 4990, 'Las petunias', '2021-06-15 20:51:03', 0, 40, 1),
(18, '+56968867897', 3200, 4000, '21 de mayo', '2021-06-16 20:50:43', 1, 41, 1),
(19, '+56967894561', 8400, 8900, 'Pedro Aguirre Cerda', '2021-07-01 20:52:27', 1, 42, 1),
(21, '+56967894561', 7670, 8270, 'Juan Antonio Rios', '2021-07-01 21:02:23', 1, 44, 1),
(22, '+56975745575', 16800, 17590, '21 de mayo', '2021-06-05 06:23:14', 1, 31, 1),
(23, '+56967894561', 6000, 6600, 'Juan Antonio Rios', '2021-07-05 00:18:35', 1, 45, 1),
(24, '+56967894561', 6200, 7000, '21 de mayo', '2021-07-05 00:31:16', 1, 46, 1),
(25, '+56975745575', 8100, 8700, 'Juan Antonio Rios', '2021-07-12 21:29:39', 1, 47, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registro`
--

DROP TABLE IF EXISTS `registro`;
CREATE TABLE `registro` (
  `idRegistro` int(11) NOT NULL,
  `FechaRegistro` datetime NOT NULL,
  `ClienteRegistrado` int(11) NOT NULL,
  `Personal` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `registro`
--

INSERT INTO `registro` (`idRegistro`, `FechaRegistro`, `ClienteRegistrado`, `Personal`) VALUES
(20, '2021-05-23 01:38:41', 23, 1),
(21, '2021-06-13 01:17:48', 24, 1),
(22, '2021-06-13 01:29:52', 25, 1),
(23, '2021-06-13 01:35:06', 26, 1),
(24, '2021-06-15 20:46:03', 27, 1),
(25, '2021-06-15 21:20:33', 28, 1),
(26, '2021-06-15 21:23:27', 29, 1),
(27, '2021-06-15 21:26:10', 30, 1),
(28, '2021-06-15 21:28:32', 31, 1),
(29, '2021-06-16 20:48:49', 32, 1),
(30, '2021-07-07 20:11:18', 33, 1),
(31, '2021-07-12 21:20:33', 34, 1),
(32, '2021-07-12 21:25:42', 35, 1),
(33, '2021-09-02 23:35:02', 36, 1),
(34, '2021-10-09 18:26:05', 37, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `respuestasolicitud`
--

DROP TABLE IF EXISTS `respuestasolicitud`;
CREATE TABLE `respuestasolicitud` (
  `idRespuesta_solicitud` int(11) NOT NULL,
  `RecepcionMensaje` text NOT NULL,
  `MensajeRespuesta` text DEFAULT NULL,
  `FechaRespuesta` datetime DEFAULT NULL,
  `RespuestaCliente` int(11) NOT NULL,
  `RespuestaSolicitud` int(11) NOT NULL,
  `estadoRespuesta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `respuestasolicitud`
--

INSERT INTO `respuestasolicitud` (`idRespuesta_solicitud`, `RecepcionMensaje`, `MensajeRespuesta`, `FechaRespuesta`, `RespuestaCliente`, `RespuestaSolicitud`, `estadoRespuesta`) VALUES
(2, 'muchas gracias', 'no hay de que, tenga paciencia\n', '2021-10-10 23:31:52', 23, 86, 2),
(5, 'muchas gracias por su respuesta', 'ok, cuente con nosostros', '2021-07-12 21:21:37', 23, 87, 1),
(6, 'me gustaria otra variedad de licores', 'no hay de que, tenga paciencia\n', '2021-10-11 00:21:32', 23, 90, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitud`
--

DROP TABLE IF EXISTS `solicitud`;
CREATE TABLE `solicitud` (
  `idSolicitud` int(11) NOT NULL,
  `SolicitudFecha` datetime NOT NULL,
  `CargoSolicitud` varchar(45) NOT NULL,
  `ClienteSolicitud` int(11) NOT NULL,
  `SolicitudEstado` int(11) DEFAULT NULL,
  `SolicitudDescripcion` text NOT NULL,
  `TipoMercancia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `solicitud`
--

INSERT INTO `solicitud` (`idSolicitud`, `SolicitudFecha`, `CargoSolicitud`, `ClienteSolicitud`, `SolicitudEstado`, `SolicitudDescripcion`, `TipoMercancia`) VALUES
(86, '2021-06-22 00:42:18', 'Sin negocio Fijo', 23, 1, 'deseo lacteos de diferente variedades\n', 2),
(87, '2021-06-20 00:58:48', 'Sin negocio Fijo', 23, 2, 'me gustaria pedir mas productos de este tipo', 6),
(88, '2021-06-20 23:47:28', 'Local de pescados', 25, 0, 'quisiera pedir mas variedad de lacteos', 2),
(89, '2021-06-29 20:37:09', 'Sin negocio Fijo', 23, 0, 'me gustaria saber que otro licores tiene', 3),
(90, '2021-07-12 21:28:26', 'Sin negocio Fijo', 23, 1, 'me gustaria otra variedad de licores', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipopago`
--

DROP TABLE IF EXISTS `tipopago`;
CREATE TABLE `tipopago` (
  `idTipoPago` int(11) NOT NULL,
  `nombreTipoPago` varchar(55) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tipopago`
--

INSERT INTO `tipopago` (`idTipoPago`, `nombreTipoPago`) VALUES
(1, 'Efectivo'),
(2, 'Cheque'),
(3, 'Deposito Bancario'),
(4, 'Tarjeta');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE `usuario` (
  `idUsuario` int(11) NOT NULL,
  `UserNombre` varchar(45) NOT NULL,
  `UserApellidos` varchar(45) NOT NULL,
  `UserDescripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idUsuario`, `UserNombre`, `UserApellidos`, `UserDescripcion`) VALUES
(1, 'Sergio', 'Juares', 'Es que se hara cargo de los gatos de la empre'),
(2, 'Iván ', 'Ñavez', 'Es quien se encargara de los balances'),
(3, 'Julia', 'Navarro', 'Es quien se encargara de manejar gran parte d'),
(4, 'Marcela', 'Dañez', 'es quien se encarga de administrar los pagos '),
(5, 'Laurerio', 'Juares', 'es quien se encarga ademas de Sergio de admin');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta`
--

DROP TABLE IF EXISTS `venta`;
CREATE TABLE `venta` (
  `idVenta` int(11) NOT NULL,
  `PrecioVenta` double NOT NULL,
  `EstadoVenta` int(11) NOT NULL,
  `FechaVenta` datetime NOT NULL,
  `ClienteVenta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `venta`
--

INSERT INTO `venta` (`idVenta`, `PrecioVenta`, `EstadoVenta`, `FechaVenta`, `ClienteVenta`) VALUES
(81, 11350, 0, '2021-06-05 01:20:27', 23),
(82, 16800, 2, '2021-06-05 01:20:45', 23),
(83, 2400, 2, '2021-06-05 01:24:03', 23),
(84, 1020, 0, '2021-06-05 01:25:08', 23),
(85, 8000, 2, '2021-06-05 01:27:02', 23),
(86, 8100, 2, '2021-06-06 00:51:05', 23),
(87, 5620, 0, '2021-06-07 14:32:05', 23),
(88, 6000, 0, '2021-06-07 13:24:20', 23),
(89, 900, 0, '2021-06-07 13:24:59', 23),
(90, 1350, 0, '2021-06-07 13:29:03', 23),
(91, 680, 0, '2021-06-07 14:22:56', 23),
(92, 6000, 0, '2021-06-07 14:25:23', 23),
(93, 1020, 0, '2021-06-07 14:26:04', 23),
(94, 1360, 0, '2021-06-07 14:27:07', 23),
(95, 680, 0, '2021-06-07 14:29:02', 23),
(96, 6900, 1, '2021-07-12 21:28:48', 23),
(97, 2370, 0, '2021-06-07 14:42:56', 23),
(98, 3600, 1, '2021-06-12 21:19:46', 23),
(99, 1200, 1, '2021-06-07 15:07:41', 23),
(100, 6000, 2, '2021-06-07 15:09:58', 23),
(101, 6900, 0, '2021-06-07 15:10:50', 23),
(102, 680, 0, '2021-06-07 15:13:03', 23),
(103, 6900, 0, '2021-06-07 15:14:19', 23),
(104, 600, 0, '2021-06-07 15:14:27', 23),
(105, 1020, 2, '2021-06-07 15:14:57', 23),
(106, 8860, 1, '2021-07-03 23:52:40', 23),
(107, 11200, 1, '2021-10-12 00:05:37', 23),
(108, 1360, 1, '2021-06-13 01:41:08', 26),
(109, 4950, 2, '2021-06-13 01:43:50', 26),
(110, 6000, 2, '2021-06-15 20:49:57', 25),
(111, 4600, 0, '2021-06-15 20:50:28', 25),
(112, 680, 1, '2021-06-16 01:57:18', 23),
(113, 1600, 1, '2021-10-12 00:08:34', 23),
(114, 3200, 2, '2021-06-16 20:49:54', 32),
(115, 8400, 2, '2021-07-01 20:43:18', 25),
(116, 7670, 2, '2021-07-01 20:43:41', 25),
(117, 8900, 1, '2021-07-05 00:18:18', 25),
(118, 6200, 2, '2021-07-05 00:30:30', 25);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vinculacion`
--

DROP TABLE IF EXISTS `vinculacion`;
CREATE TABLE `vinculacion` (
  `idVinculacion` int(11) NOT NULL,
  `nombreVinculo` varchar(45) NOT NULL,
  `telefonoVinculo` varchar(30) NOT NULL,
  `correoVinculo` varchar(45) NOT NULL,
  `claveVinculo` varchar(45) NOT NULL,
  `fechaVinculo` datetime NOT NULL,
  `EstadoVinculo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `vinculacion`
--

INSERT INTO `vinculacion` (`idVinculacion`, `nombreVinculo`, `telefonoVinculo`, `correoVinculo`, `claveVinculo`, `fechaVinculo`, `EstadoVinculo`) VALUES
(42, 'Mario', '+56975745575', 'mbaltazarlanchipa@gmail.com', 'gogeta24', '2021-05-23 03:20:19', 0),
(43, 'Pepe', '+56967894561', 'peep45@gmail.com', 'pepe45ssjblue', '2021-05-22 23:30:40', 0),
(49, 'Perico', '+56986757959', 'perico45@gmail.com', 'perico45', '2021-06-09 21:44:52', 0),
(50, 'Barry', '+56956657575', 'barry45@gmail.com', 'gogeta23', '2021-06-11 00:59:02', 0),
(51, 'Raul', '+56956354646', 'raul56@gmail.com', 'Julia45', '2021-06-13 01:34:26', 0),
(52, 'Betin', '+56954656575', 'betin45@gmail.com', 'gogeta24', '2021-06-15 20:43:48', 0),
(53, 'juan', '+56965757867', 'juan56@gmail.com', 'Julia45', '2021-06-15 21:20:12', 0),
(54, 'alex', '+56956576586', 'alex56@gmail.com', 'Alex1234Bin', '2021-06-15 21:23:04', 0),
(55, 'Juanit', '+56946576786', 'juanita45@gmail.com', 'Julia45', '2021-06-15 21:25:47', 0),
(56, 'Macerl', '+56968867897', 'marcel45@gmail.com', 'marcel1234', '2021-06-16 20:47:40', 0),
(57, 'A', '+56978686868', 'alterto45@gmail.com', 'gogeta24ssjblue45', '2021-07-07 20:05:17', 0),
(58, 'Pepiño', '+56986564574', 'pepiño45@gmail.com', 'gogeta24ssj', '2021-07-12 20:50:08', 0),
(59, 'Juanita', '+56966876867', 'juanitaV56@gmail.com', 'gogeta24ssj', '2021-07-12 20:50:35', 0),
(60, 'Mario', '+56975647575', 'mbaltazar46@gmail.com', 'gogeta24ssj', '2021-09-02 23:34:21', 0),
(61, 'Waldo de la barra', '+56955657576', 'waldin45@gmail.com', 'waldin45ssj', '2021-10-09 18:22:42', 0),
(62, 'pee', '+56956457457', 'pepe46@gmail.com', 'Mario24ssjblue', '2021-10-10 22:37:30', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`idCategoria`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`idCliente`),
  ADD KEY `fk_Cliente_Vinculacion1_idx` (`VinculoCliente`);

--
-- Indices de la tabla `comuna`
--
ALTER TABLE `comuna`
  ADD PRIMARY KEY (`idComuna`);

--
-- Indices de la tabla `detallecargocliente`
--
ALTER TABLE `detallecargocliente`
  ADD PRIMARY KEY (`idDetalleCargoCliente`),
  ADD KEY `fk_detallecargocliente_negocio1_idx` (`NegocioCargo`),
  ADD KEY `fk_detallecargocliente_cliente1_idx` (`ClienteCargo`);

--
-- Indices de la tabla `detalleventa`
--
ALTER TABLE `detalleventa`
  ADD PRIMARY KEY (`idDetalleVenta`),
  ADD KEY `fk_Detalle Venta_insumo_idx` (`InsumoVendido`),
  ADD KEY `fk_Detalle Venta_venta1_idx` (`VentaId`);

--
-- Indices de la tabla `direccion`
--
ALTER TABLE `direccion`
  ADD PRIMARY KEY (`idDireccion`),
  ADD KEY `fk_direccion_comuna1_idx` (`DireccionComuna`);

--
-- Indices de la tabla `insumo`
--
ALTER TABLE `insumo`
  ADD PRIMARY KEY (`idInsumo`),
  ADD KEY `fk_Insumo_Categoria1_idx` (`CategoriaInsumo`);

--
-- Indices de la tabla `mercancia`
--
ALTER TABLE `mercancia`
  ADD PRIMARY KEY (`idMercancia`);

--
-- Indices de la tabla `negocio`
--
ALTER TABLE `negocio`
  ADD PRIMARY KEY (`idNegocio`);

--
-- Indices de la tabla `pago`
--
ALTER TABLE `pago`
  ADD PRIMARY KEY (`idPago`),
  ADD KEY `fk_pago_venta1_idx` (`VentaPagada`),
  ADD KEY `fk_pago_TipoPago1_idx` (`TipoPago`);

--
-- Indices de la tabla `personal`
--
ALTER TABLE `personal`
  ADD PRIMARY KEY (`idPersonal`),
  ADD KEY `fk_Personal_Usuario1_idx` (`PerfilUsuario`);

--
-- Indices de la tabla `recibo`
--
ALTER TABLE `recibo`
  ADD PRIMARY KEY (`idRecibo`),
  ADD KEY `fk_recibo_pago1_idx` (`ReciboPago`),
  ADD KEY `fk_recibo_comuna1_idx` (`ReciboComuna`);

--
-- Indices de la tabla `registro`
--
ALTER TABLE `registro`
  ADD PRIMARY KEY (`idRegistro`),
  ADD KEY `fk_Registro_Cliente1_idx` (`ClienteRegistrado`),
  ADD KEY `fk_Registro_Personal1_idx` (`Personal`);

--
-- Indices de la tabla `respuestasolicitud`
--
ALTER TABLE `respuestasolicitud`
  ADD PRIMARY KEY (`idRespuesta_solicitud`),
  ADD KEY `fk_respuesta solicitud_cliente1_idx` (`RespuestaCliente`),
  ADD KEY `fk_respuesta solicitud_solicitud1_idx` (`RespuestaSolicitud`);

--
-- Indices de la tabla `solicitud`
--
ALTER TABLE `solicitud`
  ADD PRIMARY KEY (`idSolicitud`),
  ADD KEY `fk_Solicitud_Cliente1_idx` (`ClienteSolicitud`),
  ADD KEY `fk_solicitud_mercancia1_idx` (`TipoMercancia`);

--
-- Indices de la tabla `tipopago`
--
ALTER TABLE `tipopago`
  ADD PRIMARY KEY (`idTipoPago`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idUsuario`);

--
-- Indices de la tabla `venta`
--
ALTER TABLE `venta`
  ADD PRIMARY KEY (`idVenta`),
  ADD KEY `fk_Venta_Cliente1_idx` (`ClienteVenta`);

--
-- Indices de la tabla `vinculacion`
--
ALTER TABLE `vinculacion`
  ADD PRIMARY KEY (`idVinculacion`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `idCategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `idCliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT de la tabla `comuna`
--
ALTER TABLE `comuna`
  MODIFY `idComuna` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `detallecargocliente`
--
ALTER TABLE `detallecargocliente`
  MODIFY `idDetalleCargoCliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `detalleventa`
--
ALTER TABLE `detalleventa`
  MODIFY `idDetalleVenta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=157;

--
-- AUTO_INCREMENT de la tabla `direccion`
--
ALTER TABLE `direccion`
  MODIFY `idDireccion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `insumo`
--
ALTER TABLE `insumo`
  MODIFY `idInsumo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `mercancia`
--
ALTER TABLE `mercancia`
  MODIFY `idMercancia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `negocio`
--
ALTER TABLE `negocio`
  MODIFY `idNegocio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `pago`
--
ALTER TABLE `pago`
  MODIFY `idPago` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT de la tabla `personal`
--
ALTER TABLE `personal`
  MODIFY `idPersonal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `recibo`
--
ALTER TABLE `recibo`
  MODIFY `idRecibo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `registro`
--
ALTER TABLE `registro`
  MODIFY `idRegistro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de la tabla `respuestasolicitud`
--
ALTER TABLE `respuestasolicitud`
  MODIFY `idRespuesta_solicitud` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `solicitud`
--
ALTER TABLE `solicitud`
  MODIFY `idSolicitud` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT de la tabla `tipopago`
--
ALTER TABLE `tipopago`
  MODIFY `idTipoPago` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `venta`
--
ALTER TABLE `venta`
  MODIFY `idVenta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;

--
-- AUTO_INCREMENT de la tabla `vinculacion`
--
ALTER TABLE `vinculacion`
  MODIFY `idVinculacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD CONSTRAINT `fk_Cliente_Vinculacion1` FOREIGN KEY (`VinculoCliente`) REFERENCES `vinculacion` (`idVinculacion`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `detallecargocliente`
--
ALTER TABLE `detallecargocliente`
  ADD CONSTRAINT `fk_detallecargocliente_cliente1` FOREIGN KEY (`ClienteCargo`) REFERENCES `cliente` (`idCliente`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_detallecargocliente_negocio1` FOREIGN KEY (`NegocioCargo`) REFERENCES `negocio` (`idNegocio`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `detalleventa`
--
ALTER TABLE `detalleventa`
  ADD CONSTRAINT `fk_Detalle Venta_insumo` FOREIGN KEY (`InsumoVendido`) REFERENCES `insumo` (`idInsumo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Detalle Venta_venta1` FOREIGN KEY (`VentaId`) REFERENCES `venta` (`idVenta`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `direccion`
--
ALTER TABLE `direccion`
  ADD CONSTRAINT `fk_direccion_comuna1` FOREIGN KEY (`DireccionComuna`) REFERENCES `comuna` (`idComuna`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `insumo`
--
ALTER TABLE `insumo`
  ADD CONSTRAINT `fk_Insumo_Categoria1` FOREIGN KEY (`CategoriaInsumo`) REFERENCES `categoria` (`idCategoria`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `pago`
--
ALTER TABLE `pago`
  ADD CONSTRAINT `fk_pago_TipoPago1` FOREIGN KEY (`TipoPago`) REFERENCES `tipopago` (`idTipoPago`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_pago_venta1` FOREIGN KEY (`VentaPagada`) REFERENCES `venta` (`idVenta`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `personal`
--
ALTER TABLE `personal`
  ADD CONSTRAINT `fk_Personal_Usuario1` FOREIGN KEY (`PerfilUsuario`) REFERENCES `usuario` (`idUsuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `recibo`
--
ALTER TABLE `recibo`
  ADD CONSTRAINT `fk_recibo_comuna1` FOREIGN KEY (`ReciboComuna`) REFERENCES `comuna` (`idComuna`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_recibo_pago1` FOREIGN KEY (`ReciboPago`) REFERENCES `pago` (`idPago`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `registro`
--
ALTER TABLE `registro`
  ADD CONSTRAINT `fk_Registro_Cliente1` FOREIGN KEY (`ClienteRegistrado`) REFERENCES `cliente` (`idCliente`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Registro_Personal1` FOREIGN KEY (`Personal`) REFERENCES `personal` (`idPersonal`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `respuestasolicitud`
--
ALTER TABLE `respuestasolicitud`
  ADD CONSTRAINT `fk_respuesta solicitud_cliente1` FOREIGN KEY (`RespuestaCliente`) REFERENCES `cliente` (`idCliente`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_respuesta solicitud_solicitud1` FOREIGN KEY (`RespuestaSolicitud`) REFERENCES `solicitud` (`idSolicitud`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `solicitud`
--
ALTER TABLE `solicitud`
  ADD CONSTRAINT `fk_Solicitud_Cliente1` FOREIGN KEY (`ClienteSolicitud`) REFERENCES `cliente` (`idCliente`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_solicitud_mercancia1` FOREIGN KEY (`TipoMercancia`) REFERENCES `mercancia` (`idMercancia`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `venta`
--
ALTER TABLE `venta`
  ADD CONSTRAINT `fk_Venta_Cliente1` FOREIGN KEY (`ClienteVenta`) REFERENCES `cliente` (`idCliente`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
