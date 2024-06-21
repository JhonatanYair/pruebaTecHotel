-- Crear la base de datos si no existe
CREATE DATABASE IF NOT EXISTS hotelselect;

-- Usar la base de datos creada
USE hotelselect;

-- Estructura de tabla para la tabla `apartamentos`
CREATE TABLE `apartamentos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `tarifa` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`)
);

-- Volcado de datos para la tabla `apartamentos`
INSERT INTO `apartamentos` (`id`, `nombre`, `tarifa`) VALUES
(1, 'Apartamento A', 150.00),
(2, 'Apartamento B', 120.00),
...
(20, 'Apartamento T', 200.00);

-- Estructura de tabla para la tabla `clientes`
CREATE TABLE `clientes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
);

-- Volcado de datos para la tabla `clientes`
INSERT INTO `clientes` (`id`, `nombre`, `email`, `apellido`) VALUES
(1, 'Juan', 'juan.perez@example.com', 'Pérez'),
(2, 'María', 'maria.gonzalez@example.com', 'González'),
...
(20, 'Beatriz', 'beatriz.gil@example.com', 'Gil');

-- Estructura de tabla para la tabla `reservas`
CREATE TABLE `reservas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `apartamento_id` int(11) NOT NULL,
  `cliente_id` int(11) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `estado` int(11) NOT NULL,
  `fecha_creacion` date NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `apartamento_id` (`apartamento_id`,`fecha_inicio`,`fecha_fin`),
  KEY `cliente_id` (`cliente_id`),
  CONSTRAINT `fk_reserva_apartamento` FOREIGN KEY (`apartamento_id`) REFERENCES `apartamentos` (`id`),
  CONSTRAINT `fk_reserva_cliente` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`)
);

-- Ajustes de AUTO_INCREMENT para las tablas
ALTER TABLE `apartamentos` AUTO_INCREMENT = 21;
ALTER TABLE `clientes` AUTO_INCREMENT = 21;
ALTER TABLE `reservas` AUTO_INCREMENT = 3;

-- Fin del script
