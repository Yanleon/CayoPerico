-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 19-11-2024 a las 18:09:50
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
-- Base de datos: `usuarios_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `cliente_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `fecha_pedido` datetime DEFAULT current_timestamp(),
  `estado` varchar(50) DEFAULT 'Pendiente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `descripcion`, `precio`, `imagen`, `stock`, `fecha_creacion`) VALUES
(1, 'Vintaje', '1 kilo', 120000.00, 'uploads/W_PI_VintagePistol.jpg', 100, '2024-11-16 02:42:54'),
(2, 'Cargador de Asalto 32 balas', 'Precio Calle 750k Peso en KG 1', 480000.00, 'uploads/32.jpeg', 1000, '2024-11-16 22:12:44'),
(3, 'Uzi Cargada', 'Precio Calle 850K Peso en KG 2', 550000.00, 'uploads/Uzi.jpg', 100, '2024-11-16 22:40:36'),
(4, 'Skorpion 1 Bala', 'Precio calle 250k peso en KG 2', 150000.00, 'uploads/Mini_SMG_GTA_V.jpg', 100, '2024-11-16 22:41:30'),
(5, 'Cargador de subfusil de 16', 'Precio Calle 450k Peso en KG 1', 290000.00, 'uploads/cargador-mp7-hi-cap-well.jpg', 100, '2024-11-16 22:42:25'),
(6, 'Cargador de subfusil de 32', 'Precio calle 800k Peso en KG 1', 550000.00, 'uploads/cargador-subfusil-gas-hk-mp7-gas-6mm-bb.jpg', 100, '2024-11-16 22:43:26'),
(7, 'Escopeta Descargada', 'Precio calle 380k Peso en KG 3', 250000.00, 'uploads/Escopeta_recortada_GTA_V.jpg', 100, '2024-11-16 22:44:18'),
(8, 'Cargador de Escopeta 12 balas', 'Precio calle 380k Peso en KG 1', 260000.00, 'uploads/l_100034502_2_m.jpg', 100, '2024-11-16 22:44:52'),
(9, 'Glock', 'Precio calle 300k Peso en KG 2', 240000.00, 'uploads/glock.png', 100, '2024-11-16 22:45:39'),
(10, 'Cargadores de Pistola 12 balas', 'Precio calle 18k', 15000.00, 'uploads/images.jpeg', 100, '2024-11-16 22:46:28');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `email`, `username`, `password`, `role`) VALUES
(1, 'Santos el Jefe', 'Santos@cayo.com', 'Admin', '$2y$10$12jCPkF2cQbfsuSb25EGQOw03dmfIH2gaTE31iyeBJritNlU5SzoK', 'admin'),
(3, 'Santos el Jefe', 'Santos@cayo.com', 'Santos', '$2y$10$7k9/iz5PC0bROq3aj0zpkOlV9IZxIGjZyu9xPWJD8rNJE8O/Nzsde', 'user');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cliente_id` (`cliente_id`),
  ADD KEY `producto_id` (`producto_id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`cliente_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pedidos_ibfk_2` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
