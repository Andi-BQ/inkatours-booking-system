-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-04-2026 a las 05:27:46
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
-- Base de datos: `inkatours`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividades`
--

CREATE TABLE `actividades` (
  `id` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `descripcion` text NOT NULL,
  `descripcion_corta` varchar(500) DEFAULT NULL,
  `imagen_principal` varchar(255) NOT NULL,
  `categoria` enum('cultural','aventura','comunidad','naturaleza') NOT NULL,
  `duracion` varchar(50) NOT NULL,
  `participantes_min` int(11) DEFAULT 1,
  `participantes_max` int(11) DEFAULT 15,
  `dificultad` varchar(50) DEFAULT 'Moderada',
  `impacto` enum('Alto','Medio','Bajo') DEFAULT 'Bajo',
  `precio` decimal(10,2) NOT NULL,
  `incluye` longtext DEFAULT NULL,
  `requisitos` longtext DEFAULT NULL,
  `destacado` tinyint(1) DEFAULT 0,
  `activo` tinyint(1) DEFAULT 1,
  `rating_promedio` decimal(3,2) DEFAULT 4.50,
  `total_resenas` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articulos_blog`
--

CREATE TABLE `articulos_blog` (
  `id` int(11) NOT NULL,
  `titulo` varchar(200) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `contenido` longtext NOT NULL,
  `resumen` text NOT NULL,
  `imagen_principal` varchar(255) NOT NULL,
  `categoria_id` int(11) NOT NULL,
  `autor_id` int(11) NOT NULL,
  `fecha_publicacion` date NOT NULL,
  `tiempo_lectura` int(11) NOT NULL,
  `palabras_clave` longtext DEFAULT NULL,
  `visitas` int(11) DEFAULT 0,
  `likes` int(11) DEFAULT 0,
  `destacado` tinyint(1) DEFAULT 0,
  `activo` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias_blog`
--

CREATE TABLE `categorias_blog` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `color` varchar(7) DEFAULT '#3498db',
  `activo` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `categorias_blog`
--

INSERT INTO `categorias_blog` (`id`, `nombre`, `slug`, `descripcion`, `color`, `activo`, `created_at`) VALUES
(1, 'Sostenibilidad', 'sostenibilidad', NULL, '#2A9D8F', 1, '2026-04-24 02:23:11'),
(2, 'Comunidad', 'comunidad', NULL, '#E76F51', 1, '2026-04-24 02:23:11'),
(3, 'Aventura', 'aventura', NULL, '#3498DB', 1, '2026-04-24 02:23:11');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias_destinos`
--

CREATE TABLE `categorias_destinos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `icono` varchar(50) DEFAULT NULL,
  `color` varchar(7) DEFAULT '#2A9D8F',
  `activo` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `categorias_destinos`
--

INSERT INTO `categorias_destinos` (`id`, `nombre`, `descripcion`, `icono`, `color`, `activo`, `created_at`) VALUES
(1, 'Sitios Arqueológicos', NULL, NULL, '#2A9D8F', 1, '2026-04-24 02:23:11'),
(2, 'Naturaleza y Aventura', NULL, NULL, '#27AE60', 1, '2026-04-24 02:23:11'),
(3, 'Cultural y Comunitario', NULL, NULL, '#E76F51', 1, '2026-04-24 02:23:11'),
(4, 'Trekking y Senderismo', NULL, NULL, '#F4A261', 1, '2026-04-24 02:23:11');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `destinos`
--

CREATE TABLE `destinos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `descripcion` text NOT NULL,
  `descripcion_corta` varchar(500) DEFAULT NULL,
  `imagen_principal` varchar(255) NOT NULL,
  `galeria` longtext DEFAULT NULL,
  `categoria_id` int(11) NOT NULL,
  `tipo` enum('cultural','naturaleza','aventura','comunitario') NOT NULL,
  `dificultad` enum('facil','moderada','dificil') NOT NULL,
  `distancia` decimal(8,2) DEFAULT NULL,
  `altitud` int(11) DEFAULT NULL,
  `clima` varchar(100) DEFAULT NULL,
  `mejor_epoca` varchar(100) DEFAULT NULL,
  `ubicacion` point NOT NULL,
  `precio_base` decimal(10,2) NOT NULL,
  `duracion_horas` int(11) NOT NULL,
  `destacado` tinyint(1) DEFAULT 0,
  `activo` tinyint(1) DEFAULT 1,
  `rating_promedio` decimal(3,2) DEFAULT 4.50,
  `total_resenas` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `destinos_actividades`
--

CREATE TABLE `destinos_actividades` (
  `id` int(11) NOT NULL,
  `destino_id` int(11) NOT NULL,
  `actividad_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resenas`
--

CREATE TABLE `resenas` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `tipo` enum('destino','actividad') NOT NULL,
  `elemento_id` int(11) NOT NULL,
  `calificacion` int(11) NOT NULL,
  `titulo` varchar(200) DEFAULT NULL,
  `comentario` text DEFAULT NULL,
  `aprobado` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservas`
--

CREATE TABLE `reservas` (
  `id` int(11) NOT NULL,
  `numero_reserva` varchar(20) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `estado` enum('pendiente','confirmada','pagada','completada','cancelada') DEFAULT 'pendiente',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `genero` enum('masculino','femenino','otro') DEFAULT 'otro',
  `avatar` varchar(255) DEFAULT 'default-unisex.jpg',
  `telefono` varchar(20) DEFAULT NULL,
  `pais` varchar(50) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `idioma_preferido` enum('es','en','qu','pt') DEFAULT 'es',
  `notificaciones` tinyint(1) DEFAULT 1,
  `rol` enum('usuario','admin','guia') DEFAULT 'usuario',
  `verificado` tinyint(1) DEFAULT 0,
  `ultimo_login` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `email`, `password`, `genero`, `avatar`, `telefono`, `pais`, `fecha_nacimiento`, `idioma_preferido`, `notificaciones`, `rol`, `verificado`, `ultimo_login`, `created_at`, `updated_at`) VALUES
(1, 'Administrador InkaTours', 'admin@inkatours.com', '$2y$10$ePhGAaUuBHY9CJ3Cs5BwJeu31fnX1wqcQIwt6Ed/1z0a7BDBXsI4e', 'otro', 'default-unisex.jpg', NULL, NULL, NULL, 'es', 1, 'admin', 1, NULL, '2026-04-24 02:23:11', '2026-04-24 02:23:11');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `actividades`
--
ALTER TABLE `actividades`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indices de la tabla `articulos_blog`
--
ALTER TABLE `articulos_blog`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `fk_blog_cat` (`categoria_id`),
  ADD KEY `fk_blog_user` (`autor_id`);

--
-- Indices de la tabla `categorias_blog`
--
ALTER TABLE `categorias_blog`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indices de la tabla `categorias_destinos`
--
ALTER TABLE `categorias_destinos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `destinos`
--
ALTER TABLE `destinos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD SPATIAL KEY `idx_ubicacion` (`ubicacion`),
  ADD KEY `fk_dest_cat` (`categoria_id`);

--
-- Indices de la tabla `destinos_actividades`
--
ALTER TABLE `destinos_actividades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_da_dest` (`destino_id`),
  ADD KEY `fk_da_act` (`actividad_id`);

--
-- Indices de la tabla `resenas`
--
ALTER TABLE `resenas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_res_user` (`usuario_id`);

--
-- Indices de la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `num_reserva` (`numero_reserva`),
  ADD KEY `fk_rev_user` (`usuario_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `actividades`
--
ALTER TABLE `actividades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `articulos_blog`
--
ALTER TABLE `articulos_blog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `categorias_blog`
--
ALTER TABLE `categorias_blog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `categorias_destinos`
--
ALTER TABLE `categorias_destinos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `destinos`
--
ALTER TABLE `destinos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `destinos_actividades`
--
ALTER TABLE `destinos_actividades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `resenas`
--
ALTER TABLE `resenas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `reservas`
--
ALTER TABLE `reservas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `articulos_blog`
--
ALTER TABLE `articulos_blog`
  ADD CONSTRAINT `fk_blog_cat` FOREIGN KEY (`categoria_id`) REFERENCES `categorias_blog` (`id`),
  ADD CONSTRAINT `fk_blog_user` FOREIGN KEY (`autor_id`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `destinos`
--
ALTER TABLE `destinos`
  ADD CONSTRAINT `fk_dest_cat` FOREIGN KEY (`categoria_id`) REFERENCES `categorias_destinos` (`id`);

--
-- Filtros para la tabla `destinos_actividades`
--
ALTER TABLE `destinos_actividades`
  ADD CONSTRAINT `fk_da_act` FOREIGN KEY (`actividad_id`) REFERENCES `actividades` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_da_dest` FOREIGN KEY (`destino_id`) REFERENCES `destinos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `resenas`
--
ALTER TABLE `resenas`
  ADD CONSTRAINT `fk_res_user` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD CONSTRAINT `fk_rev_user` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
