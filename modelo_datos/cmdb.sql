-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 31-03-2025 a las 23:16:12
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
-- Base de datos: `cmdb`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asociaciones`
--

CREATE TABLE `asociaciones` (
  `id` int(11) NOT NULL,
  `objeto_padre_id` int(11) NOT NULL,
  `objeto_hijo_id` int(11) NOT NULL,
  `tipo_relacion` enum('dependencia','contenido','conexion','cluster','otra') NOT NULL DEFAULT 'dependencia',
  `notas` text DEFAULT NULL,
  `creado_en` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clases`
--

CREATE TABLE `clases` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `imagen_por_defecto` varchar(255) DEFAULT NULL,
  `creado_en` timestamp NOT NULL DEFAULT current_timestamp(),
  `actualizado_en` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `clases`
--

INSERT INTO `clases` (`id`, `nombre`, `descripcion`, `imagen_por_defecto`, `creado_en`, `actualizado_en`) VALUES
(1, 'servidor_fisico', 'Servidor físico', NULL, '2025-03-29 16:38:35', '2025-03-29 16:38:35'),
(2, 'servidor_virtual', 'Servidor virtual', NULL, '2025-03-29 16:38:35', '2025-03-29 16:38:35'),
(3, 'almacenamiento', 'Sistema de almacenamiento', NULL, '2025-03-29 16:38:35', '2025-03-29 16:38:35'),
(4, 'switch', 'Switch de red', NULL, '2025-03-29 16:38:35', '2025-03-29 16:38:35'),
(5, 'router', 'Router de red', NULL, '2025-03-29 16:38:35', '2025-03-29 16:38:35'),
(6, 'firewall', 'Firewall de red', NULL, '2025-03-29 16:38:35', '2025-03-29 16:38:35'),
(7, 'bd', 'Base de datos', NULL, '2025-03-29 16:38:35', '2025-03-29 16:38:35'),
(8, 'aplicacion', 'Aplicación', NULL, '2025-03-29 16:38:35', '2025-03-29 16:38:35'),
(9, 'sistema_operativo', 'Sistema operativo', NULL, '2025-03-29 16:38:35', '2025-03-29 16:38:35'),
(10, 'otro_hardware', 'Otro tipo de hardware', NULL, '2025-03-29 16:38:35', '2025-03-29 16:38:35'),
(11, 'otro_software', 'Otro tipo de software', NULL, '2025-03-29 16:38:35', '2025-03-29 16:38:35');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fechas_objeto`
--

CREATE TABLE `fechas_objeto` (
  `id` int(11) NOT NULL,
  `objeto_id` int(11) NOT NULL,
  `tipo_fecha_id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `notas` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagenes_objeto`
--

CREATE TABLE `imagenes_objeto` (
  `id` int(11) NOT NULL,
  `objeto_id` int(11) NOT NULL,
  `ruta_imagen` varchar(255) NOT NULL,
  `nombre_archivo` varchar(100) NOT NULL,
  `tamano` int(11) DEFAULT NULL,
  `tipo_mime` varchar(50) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `subido_en` timestamp NOT NULL DEFAULT current_timestamp(),
  `usuario_subio_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `accion` varchar(50) NOT NULL,
  `entidad` varchar(50) NOT NULL,
  `entidad_id` int(11) DEFAULT NULL,
  `datos_antes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`datos_antes`)),
  `datos_despues` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`datos_despues`)),
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `creado_en` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `objetos`
--

CREATE TABLE `objetos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `tipo` enum('hardware','software','sistema_operativo') NOT NULL,
  `clase_id` int(11) DEFAULT NULL,
  `estado` enum('activo','inactivo','mantenimiento','retirado') DEFAULT 'activo',
  `ubicacion` varchar(100) DEFAULT NULL,
  `planta` varchar(50) DEFAULT NULL,
  `modulo` varchar(50) DEFAULT NULL,
  `rack` varchar(50) DEFAULT NULL,
  `u` varchar(10) DEFAULT NULL,
  `brs` tinyint(1) DEFAULT 0,
  `notas` text DEFAULT NULL,
  `usuario_creador_id` int(11) NOT NULL,
  `creado_en` timestamp NOT NULL DEFAULT current_timestamp(),
  `actualizado_en` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `objetos_caracteristicas`
--

CREATE TABLE `objetos_caracteristicas` (
  `id` int(11) NOT NULL,
  `objeto_id` int(11) NOT NULL,
  `tipo_caracteristica_id` int(11) NOT NULL,
  `valor` varchar(255) NOT NULL,
  `notas` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `objetos_ips`
--

CREATE TABLE `objetos_ips` (
  `id` int(11) NOT NULL,
  `objeto_id` int(11) NOT NULL,
  `tipo_ip` enum('principal','consola','secundaria','cluster','otra') NOT NULL DEFAULT 'principal',
  `direccion_ip` varchar(45) NOT NULL,
  `mascara` varchar(45) DEFAULT NULL,
  `gateway` varchar(45) DEFAULT NULL,
  `vlan` varchar(10) DEFAULT NULL,
  `dns_primario` varchar(45) DEFAULT NULL,
  `dns_secundario` varchar(45) DEFAULT NULL,
  `notas` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `permisos` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`permisos`)),
  `creado_en` timestamp NOT NULL DEFAULT current_timestamp(),
  `actualizado_en` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `nombre`, `descripcion`, `permisos`, `creado_en`, `actualizado_en`) VALUES
(1, 'admin', 'Administrador total del sistema', '{\"*\": \"manage\"}', '2025-03-29 16:38:34', '2025-03-29 16:38:34'),
(2, 'editor', 'Puede crear y modificar objetos', '{\"objetos\": [\"create\", \"read\", \"update\"], \"caracteristicas\": [\"create\", \"read\", \"update\"]}', '2025-03-29 16:38:34', '2025-03-29 16:38:34'),
(3, 'lectura', 'Solo lectura', '{\"objetos\": [\"read\"], \"caracteristicas\": [\"read\"]}', '2025-03-29 16:38:34', '2025-03-29 16:38:34');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_caracteristicas`
--

CREATE TABLE `tipos_caracteristicas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `unidad` varchar(20) DEFAULT NULL,
  `tipo_dato` enum('texto','numero','decimal','lista','boolean') NOT NULL DEFAULT 'texto',
  `opciones` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`opciones`)),
  `es_obligatorio` tinyint(1) DEFAULT 0,
  `orden` int(11) DEFAULT 0,
  `aplica_a` enum('hardware','software','sistema_operativo','todos') DEFAULT 'todos'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tipos_caracteristicas`
--

INSERT INTO `tipos_caracteristicas` (`id`, `nombre`, `descripcion`, `unidad`, `tipo_dato`, `opciones`, `es_obligatorio`, `orden`, `aplica_a`) VALUES
(1, 'CPU', 'Procesador principal', 'núcleos', 'numero', NULL, 1, 1, 'hardware'),
(2, 'RAM', 'Memoria RAM', 'GB', 'numero', NULL, 1, 2, 'hardware'),
(3, 'HDD', 'Capacidad de disco duro', 'GB', 'numero', NULL, 1, 3, 'hardware'),
(4, 'vCPUs', 'CPU virtuales', 'núcleos', 'numero', NULL, 0, 4, 'hardware'),
(5, 'SO', 'Sistema operativo', NULL, 'texto', NULL, 0, 5, 'hardware'),
(6, 'version_so', 'Versión del sistema operativo', NULL, 'texto', NULL, 0, 6, 'hardware'),
(7, 'fabricante', 'Fabricante del hardware', NULL, 'texto', NULL, 0, 7, 'hardware'),
(8, 'modelo', 'Modelo del equipo', NULL, 'texto', NULL, 0, 8, 'hardware'),
(9, 'numero_serie', 'Número de serie', NULL, 'texto', NULL, 0, 9, 'hardware'),
(10, 'version', 'Versión del software', NULL, 'texto', NULL, 1, 1, 'software'),
(11, 'licencia', 'Tipo de licencia', NULL, 'texto', NULL, 0, 2, 'software'),
(12, 'arquitectura', 'Arquitectura (32/64 bits)', 'bits', 'texto', NULL, 0, 3, 'software'),
(13, 'lenguaje', 'Lenguaje de programación', NULL, 'texto', NULL, 0, 4, 'software'),
(14, 'framework', 'Framework utilizado', NULL, 'texto', NULL, 0, 5, 'software'),
(15, 'requisitos', 'Requisitos del sistema', NULL, 'texto', NULL, 0, 6, 'software'),
(16, 'virtualizado', '¿Está virtualizado?', NULL, 'boolean', NULL, 0, 10, 'hardware'),
(17, 'cluster', '¿Pertenece a un cluster?', NULL, 'boolean', NULL, 0, 11, 'hardware'),
(18, 'redundante', '¿Tiene redundancia?', NULL, 'boolean', NULL, 0, 12, 'hardware');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_fecha`
--

CREATE TABLE `tipos_fecha` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `es_obligatorio` tinyint(1) DEFAULT 0,
  `orden` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tipos_fecha`
--

INSERT INTO `tipos_fecha` (`id`, `nombre`, `descripcion`, `es_obligatorio`, `orden`) VALUES
(1, 'EOL', 'End of Life - Fin de vida del producto', 1, 1),
(2, 'EOS', 'End of Support - Fin de soporte', 1, 2),
(3, 'extended_support', 'Soporte extendido', 0, 3),
(4, 'compra', 'Fecha de compra', 0, 4),
(5, 'instalacion', 'Fecha de instalación', 0, 5),
(6, 'garantia', 'Fin de garantía', 0, 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `rol_id` int(11) NOT NULL,
  `activo` tinyint(1) DEFAULT 1,
  `ultimo_login` timestamp NULL DEFAULT NULL,
  `creado_en` timestamp NOT NULL DEFAULT current_timestamp(),
  `actualizado_en` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fecha_creacion` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `username`, `password_hash`, `email`, `rol_id`, `activo`, `ultimo_login`, `creado_en`, `actualizado_en`, `fecha_creacion`) VALUES
(1, 'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin@empresa.com', 1, 1, NULL, '2025-03-29 16:38:35', '2025-03-29 16:38:35', NULL),
(2, 'andres.matias', '60fe74406e7f353ed979f350f2fbb6a2e8690a5fa7d1b0c32983d1d8b3f95f67', 'andres.matias@dachser.com', 1, 1, NULL, '2025-03-30 22:01:12', '2025-03-30 22:01:12', '2025-03-31');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `asociaciones`
--
ALTER TABLE `asociaciones`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `objeto_padre_id` (`objeto_padre_id`,`objeto_hijo_id`,`tipo_relacion`),
  ADD KEY `objeto_hijo_id` (`objeto_hijo_id`);

--
-- Indices de la tabla `clases`
--
ALTER TABLE `clases`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `fechas_objeto`
--
ALTER TABLE `fechas_objeto`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `objeto_id` (`objeto_id`,`tipo_fecha_id`),
  ADD KEY `tipo_fecha_id` (`tipo_fecha_id`);

--
-- Indices de la tabla `imagenes_objeto`
--
ALTER TABLE `imagenes_objeto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `objeto_id` (`objeto_id`),
  ADD KEY `usuario_subio_id` (`usuario_subio_id`);

--
-- Indices de la tabla `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `objetos`
--
ALTER TABLE `objetos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `clase_id` (`clase_id`),
  ADD KEY `usuario_creador_id` (`usuario_creador_id`);

--
-- Indices de la tabla `objetos_caracteristicas`
--
ALTER TABLE `objetos_caracteristicas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `objeto_id` (`objeto_id`,`tipo_caracteristica_id`),
  ADD KEY `tipo_caracteristica_id` (`tipo_caracteristica_id`);

--
-- Indices de la tabla `objetos_ips`
--
ALTER TABLE `objetos_ips`
  ADD PRIMARY KEY (`id`),
  ADD KEY `objeto_id` (`objeto_id`),
  ADD KEY `direccion_ip` (`direccion_ip`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `tipos_caracteristicas`
--
ALTER TABLE `tipos_caracteristicas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `tipos_fecha`
--
ALTER TABLE `tipos_fecha`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `rol_id` (`rol_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `asociaciones`
--
ALTER TABLE `asociaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `clases`
--
ALTER TABLE `clases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `fechas_objeto`
--
ALTER TABLE `fechas_objeto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `imagenes_objeto`
--
ALTER TABLE `imagenes_objeto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `objetos`
--
ALTER TABLE `objetos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `objetos_caracteristicas`
--
ALTER TABLE `objetos_caracteristicas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `objetos_ips`
--
ALTER TABLE `objetos_ips`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `tipos_caracteristicas`
--
ALTER TABLE `tipos_caracteristicas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `tipos_fecha`
--
ALTER TABLE `tipos_fecha`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `asociaciones`
--
ALTER TABLE `asociaciones`
  ADD CONSTRAINT `asociaciones_ibfk_1` FOREIGN KEY (`objeto_padre_id`) REFERENCES `objetos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `asociaciones_ibfk_2` FOREIGN KEY (`objeto_hijo_id`) REFERENCES `objetos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `fechas_objeto`
--
ALTER TABLE `fechas_objeto`
  ADD CONSTRAINT `fechas_objeto_ibfk_1` FOREIGN KEY (`objeto_id`) REFERENCES `objetos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fechas_objeto_ibfk_2` FOREIGN KEY (`tipo_fecha_id`) REFERENCES `tipos_fecha` (`id`);

--
-- Filtros para la tabla `imagenes_objeto`
--
ALTER TABLE `imagenes_objeto`
  ADD CONSTRAINT `imagenes_objeto_ibfk_1` FOREIGN KEY (`objeto_id`) REFERENCES `objetos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `imagenes_objeto_ibfk_2` FOREIGN KEY (`usuario_subio_id`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `logs`
--
ALTER TABLE `logs`
  ADD CONSTRAINT `logs_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `objetos`
--
ALTER TABLE `objetos`
  ADD CONSTRAINT `objetos_ibfk_1` FOREIGN KEY (`clase_id`) REFERENCES `clases` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `objetos_ibfk_2` FOREIGN KEY (`usuario_creador_id`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `objetos_caracteristicas`
--
ALTER TABLE `objetos_caracteristicas`
  ADD CONSTRAINT `objetos_caracteristicas_ibfk_1` FOREIGN KEY (`objeto_id`) REFERENCES `objetos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `objetos_caracteristicas_ibfk_2` FOREIGN KEY (`tipo_caracteristica_id`) REFERENCES `tipos_caracteristicas` (`id`);

--
-- Filtros para la tabla `objetos_ips`
--
ALTER TABLE `objetos_ips`
  ADD CONSTRAINT `objetos_ips_ibfk_1` FOREIGN KEY (`objeto_id`) REFERENCES `objetos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
