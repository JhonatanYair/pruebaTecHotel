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

INSERT INTO `apartamentos` (`id`, `nombre`, `tarifa`) VALUES
(1, 'Apartamento A', 150.00),
(2, 'Apartamento B', 120.00),
(3, 'Apartamento C', 180.00),
(4, 'Apartamento D', 200.00),
(5, 'Apartamento E', 130.00),
(6, 'Apartamento F', 170.00),
(7, 'Apartamento G', 140.00),
(8, 'Apartamento H', 160.00),
(9, 'Apartamento I', 190.00),
(10, 'Apartamento J', 175.00),
(11, 'Apartamento K', 165.00),
(12, 'Apartamento L', 145.00),
(13, 'Apartamento M', 155.00),
(14, 'Apartamento N', 125.00),
(15, 'Apartamento O', 135.00),
(16, 'Apartamento P', 170.00),
(17, 'Apartamento Q', 180.00),
(18, 'Apartamento R', 195.00),
(19, 'Apartamento S', 185.00),
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
(3, 'Carlos', 'carlos.lopez@example.com', 'López'),
(4, 'Ana', 'ana.martinez@example.com', 'Martínez'),
(5, 'Pedro', 'pedro.garcia@example.com', 'García'),
(6, 'Laura', 'laura.hernandez@example.com', 'Hernández'),
(7, 'Diego', 'diego.diaz@example.com', 'Díaz'),
(8, 'Sofía', 'sofia.rodriguez@example.com', 'Rodríguez'),
(9, 'Javier', 'javier.sanchez@example.com', 'Sánchez'),
(10, 'Carmen', 'carmen.ramirez@example.com', 'Ramírez'),
(11, 'Luis', 'luis.torres@example.com', 'Torres'),
(12, 'Elena', 'elena.flores@example.com', 'Flores'),
(13, 'Manuel', 'manuel.jimenez@example.com', 'Jiménez'),
(14, 'Raquel', 'raquel.moreno@example.com', 'Moreno'),
(15, 'Francisco', 'francisco.ortega@example.com', 'Ortega'),
(16, 'Marina', 'marina.ruiz@example.com', 'Ruiz'),
(17, 'Daniel', 'daniel.castro@example.com', 'Castro'),
(18, 'Isabel', 'isabel.santos@example.com', 'Santos'),
(19, 'Antonio', 'antonio.vargas@example.com', 'Vargas'),
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
