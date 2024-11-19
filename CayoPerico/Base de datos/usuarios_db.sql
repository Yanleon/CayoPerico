-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 23-10-2024 a las 05:55:54
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

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id`, `cliente_id`, `producto_id`, `cantidad`, `fecha_pedido`, `estado`) VALUES
(16, 4, 4, 11, '2024-10-22 11:02:53', 'Pendiente'),
(17, 6, 4, 1, '2024-10-22 11:29:52', 'Pendiente'),
(18, 6, 4, 1, '2024-10-22 11:46:37', 'Pendiente'),
(19, 6, 5, 1, '2024-10-22 11:46:37', 'Pendiente'),
(20, 4, 4, 2, '2024-10-22 11:57:11', 'Pendiente'),
(21, 4, 5, 2, '2024-10-22 11:57:11', 'Pendiente'),
(22, 4, 4, 2, '2024-10-22 11:58:28', 'Pendiente'),
(23, 4, 4, 1, '2024-10-22 12:00:37', 'Pendiente'),
(24, 4, 4, 1, '2024-10-22 12:40:49', 'Pendiente'),
(25, 6, 4, 2, '2024-10-22 14:07:57', 'Pendiente'),
(26, 6, 5, 1, '2024-10-22 14:07:57', 'Pendiente'),
(27, 6, 6, 1, '2024-10-22 14:07:57', 'Pendiente'),
(28, 4, 4, 20, '2024-10-22 15:12:45', 'Pendiente'),
(29, 4, 5, 1, '2024-10-22 15:12:45', 'Pendiente'),
(30, 4, 6, 1, '2024-10-22 15:12:45', 'Pendiente'),
(31, 4, 7, 2, '2024-10-22 15:12:45', 'Pendiente');

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
(4, 'Glock', 'Pistola semiautomática compacta y ligera que se usa en labores policiales y defensa personal. Con cargador de 12 balas que puede ampliarse a 16.', 190000.00, 'uploads/glock.png', 1000, '2024-10-22 15:58:22'),
(5, 'Uzi', 'Microsubfusil- Combina su diseño compacto con una alta cadencia de disparo de unos 700-900 proyectiles por minuto.', 520000.00, 'uploads/Uzi.jpg', 10000, '2024-10-22 16:46:00'),
(6, 'Escopeta Descargada', 'Escopeta estándar, ideal para el combate a corto alcance. La dispersión de sus proyectiles compensa su escasa precisión a largo alcance.', 230000.00, 'uploads/Escopeta.png', 1000, '2024-10-22 19:07:38'),
(7, 'Vintages', 'Necesitas un arma reconocible y distinguida. Destaca en los atracos a mano armada con esta pistola vintage grabada.', 10000.00, 'uploads/W_PI_VintagePistol.jpg', 1000, '2024-10-22 20:11:46');

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
(1, 'Yan', 'juan_12086@hotmail.com', 'Admin', '$2y$10$79Golzt5nO3.jXJlksBTL.scgoHeZJc.8ypPpgj0p.t7gXdT/rT5i', 'admin'),
(2, 'dentis', '19luis.leon74@gmail.com', 'dentiss', '$2y$10$oujWQiv1iax4fTmX2Oos2ODtfAwV85L.ttxPUA61SObNV4r2A2lfS', 'user'),
(4, 'Cayo', 'cato1@gas.com', 'Cayoperico', '$2y$10$Cvrxw6QhMgKayI/1HFNcHeCunMb5oxpHeQZq5kt6fn2wo.vmTuqNK', 'user'),
(6, 'CDM', 'angelshopcol@gmail.com', 'CDM', '$2y$10$y0lah3.0UauZtSuLW6jqXu3siiwHZQZ4DAIvWoShhEsN1DMz7Z4.i', 'user');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
