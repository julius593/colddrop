-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-08-2026 a las 04:44:29
-- Versión del servidor: 8.0.46
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";
create database colddrop;

use colddrop;


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `colddrop`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito`
--


CREATE TABLE `carrito` (
  `PRODUCTOS_Codigo` varchar(45) NOT NULL,
  `PEDIDOS_idPEDIDOS` int NOT NULL,
  `cantidad` int DEFAULT NULL,
  `costoTotal` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `idPEDIDOS` int NOT NULL,
  `Nombre` varchar(255) DEFAULT NULL,
  `Fecha` varchar(45) DEFAULT NULL,
  `Estado` varchar(45) DEFAULT NULL,
  `NombreVendedor` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `Codigo` varchar(45) NOT NULL,
  `Nombre` varchar(45) DEFAULT NULL,
  `Tipo` varchar(45) DEFAULT NULL,
  `Talla` varchar(45) DEFAULT NULL,
  `Color` varchar(45) DEFAULT NULL,
  `Costo` varchar(45) DEFAULT NULL,
  `Stock` varchar(45) DEFAULT NULL,
  `Imagen` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`Codigo`, `Nombre`, `Tipo`, `Talla`, `Color`, `Costo`, `Stock`, `Imagen`) VALUES
('H001', 'Hoodie Classic Negro', 'Hoodie', 'L', 'Negro', '200', '15', 'hoodie1.jpg'),
('H002', 'Hoodie Classic Blanco', 'Hoodie', 'XL', 'Blanco', '200', '10', 'hoodie2.jpg'),
('H003', 'Hoodie Classic Azul', 'Hoodie', 'M', 'Azul', '210', '8', 'hoodie3.jpg'),
('H004', 'Hoodie Classic Gris', 'Hoodie', 'L', 'Gris', '210', '12', 'hoodie4.jpg'),
('H005', 'Hoodie Oversized Marrón', 'Hoodie', 'M', 'Marrón', '230', '9', 'hoodie5.jpg'),
('H006', 'Hoodie Oversized Beige', 'Hoodie', 'L', 'Beige', '230', '11', 'hoodie6.jpg'),
('H007', 'Hoodie Wave Verde', 'Hoodie', 'M', 'Verde', '220', '14', 'hoodie7.jpg'),
('H008', 'Hoodie Wave Vintage', 'Hoodie', 'L', 'Gris Lavado', '240', '6', 'hoodie 8.jpg'),
('P001', 'Polera Wave Negra', 'Polera', 'M', 'Negro', '79', '20', 'polera1.jpg'),
('P002', 'Polera Wave Blanca', 'Polera', 'L', 'Blanco', '79', '15', 'polera2.jpg'),
('P003', 'Polera Wave Azul', 'Polera', 'S', 'Azul', '85', '8', 'polera3.jpg'),
('P004', 'Polera Wave Ploma', 'Polera', 'XL', 'Gris', '85', '12', 'polera4.jpg'),
('P005', 'Polera Wave Roja', 'Polera', 'M', 'Rojo', '79', '8', 'polera5.jpg'),
('P006', 'Polera Wave Beige', 'Polera', 'L', 'Beige', '90', '14', 'polera6.jpg'),
('P007', 'Polera Wave Verde', 'Polera', 'M', 'Verde', '90', '18', 'polera7.jpg'),
('P008', 'Polera Wave Vintage', 'Polera', 'L', 'Negro Lavado', '95', '5', 'polera8.jpg'),
('PA01', 'Pantalón Cargo Negro', 'Pantalón', '30', 'Negro', '150', '10', 'pant1.jpg'),
('PA02', 'Pantalón Cargo Beige', 'Pantalón', '32', 'Beige', '150', '12', 'pant2.jpg'),
('PA03', 'Jeans Slim Azul', 'Pantalón', '30', 'Azul', '140', '8', 'pant3.jpg'),
('PA04', 'Pantalón Jogger Gris', 'Pantalón', 'M', 'Gris', '120', '15', 'pant4.jpg'),
('PA05', 'Jeans Loose Fit Oscuro', 'Pantalón', '34', 'Azul Oscuro', '160', '7', 'pant5.jpg'),
('PA06', 'Pantalón Chino Khaki', 'Pantalón', '32', 'Khaki', '135', '9', 'pant6.jpg'),
('PA07', 'Pantalón Parachute Verde', 'Pantalón', '30', 'Verde', '170', '6', 'pant7.jpg'),
('PA08', 'Jeans Carpenter Blanco', 'Pantalón', '32', 'Blanco', '155', '5', 'pant8.jpg'),
('S001', 'Short Deportivo Negro', 'Short', 'S', 'Negro', '60', '25', 'sh1.jpg'),
('S002', 'Short Deportivo Gris', 'Short', 'M', 'Gris', '60', '20', 'sh2.jpg'),
('S003', 'Short Playero Wave', 'Short', 'L', 'Azul', '70', '15', 'sh3.jpg'),
('S004', 'Short Cargo Beige', 'Short', '32', 'Beige', '80', '12', 'sh4.jpg'),
('S005', 'Short Cargo Verde', 'Short', '30', 'Verde', '80', '10', 'sh5.jpg'),
('S006', 'Short de Algodón Negro', 'Short', 'M', 'Negro', '65', '18', 'sh6.jpg'),
('S007', 'Short Jeans Celeste', 'Short', '32', 'Celeste', '85', '9', 'sh7.jpg'),
('S008', 'Short Jeans Negro', 'Short', '30', 'Negro', '85', '11', 'sh8.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `Nombre` varchar(45) DEFAULT NULL,
  `Apellido` varchar(45) DEFAULT NULL,
  `Usuario` varchar(45) DEFAULT NULL,
  `Contrasena` varchar(100) DEFAULT NULL,
  `Direccion` varchar(45) DEFAULT NULL,
  `Celular` varchar(45) DEFAULT NULL,
  `Rol` varchar(45) DEFAULT NULL,
  `Estado` varchar(45) DEFAULT NULL,
  `CI` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`Nombre`, `Apellido`, `Usuario`, `Contrasena`, `Direccion`, `Celular`, `Rol`, `Estado`, `CI`) VALUES
('Admin', 'Sistema', 'admin', 'admin123', 'Oficina Central', '77777777', 'Administrador', 'Activo', '1111');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `idVenta` int NOT NULL,
  `PEDIDOS_idPEDIDOS` int NOT NULL,
  `Fecha` varchar(100) NOT NULL,
  `MontoTotal` decimal(10,2) NOT NULL DEFAULT '0.00',
  `NombreVendedor` varchar(150) NOT NULL,
  `Cliente` varchar(255) NOT NULL,
  `Estado` varchar(50) NOT NULL DEFAULT 'Completada'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD PRIMARY KEY (`PRODUCTOS_Codigo`,`PEDIDOS_idPEDIDOS`),
  ADD KEY `fk_PRODUCTOS_has_PEDIDOS_PEDIDOS1_idx` (`PEDIDOS_idPEDIDOS`),
  ADD KEY `fk_PRODUCTOS_has_PEDIDOS_PRODUCTOS_idx` (`PRODUCTOS_Codigo`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`idPEDIDOS`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`Codigo`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`CI`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`idVenta`),
  ADD KEY `PEDIDOS_idPEDIDOS` (`PEDIDOS_idPEDIDOS`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `idPEDIDOS` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `idVenta` int NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD CONSTRAINT `fk_PRODUCTOS_has_PEDIDOS_PEDIDOS1` FOREIGN KEY (`PEDIDOS_idPEDIDOS`) REFERENCES `pedidos` (`idPEDIDOS`),
  ADD CONSTRAINT `fk_PRODUCTOS_has_PEDIDOS_PRODUCTOS` FOREIGN KEY (`PRODUCTOS_Codigo`) REFERENCES `productos` (`Codigo`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
CREATE TABLE medioambiental (
    id_medioambiental INT AUTO_INCREMENT PRIMARY KEY,
    Nombre VARCHAR(100) NOT NULL,
    Apellido VARCHAR(100) NOT NULL,
    Tipo VARCHAR(100) NOT NULL,
    Importancia VARCHAR(20) NOT NULL,
    Comentario TEXT NOT NULL,
    Propuesta TEXT,
    Fecha DATETIME DEFAULT CURRENT_TIMESTAMP
);
// ==============================
// 2. Consulta: producto más vendido del mes
// ==============================
// `carrito` guarda el detalle de cada pedido (producto + cantidad).
// `ventas.PEDIDOS_idPEDIDOS` conecta cada venta con su pedido, que es la
// misma clave usada en `carrito.PEDIDOS_idPEDIDOS`.
// `ventas.Fecha` es varchar en formato DD/MM/YYYY, por eso se usa STR_TO_DATE.
$sql = "SELECT p.Codigo, p.Nombre, p.Imagen, SUM(c.cantidad) AS TotalVendido
        FROM carrito c
        INNER JOIN ventas v ON v.PEDIDOS_idPEDIDOS = c.PEDIDOS_idPEDIDOS
        INNER JOIN productos p ON p.Codigo = c.PRODUCTOS_Codigo
        WHERE MONTH(STR_TO_DATE(v.Fecha, '%d/%m/%Y')) = MONTH(CURDATE())
          AND YEAR(STR_TO_DATE(v.Fecha, '%d/%m/%Y')) = YEAR(CURDATE())
        GROUP BY p.Codigo, p.Nombre, p.Imagen
        ORDER BY TotalVendido DESC
        LIMIT 1";