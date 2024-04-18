-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         10.4.28-MariaDB - mariadb.org binary distribution
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.6.0.6765
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para bdtodolist
CREATE DATABASE IF NOT EXISTS `bdtodolist` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `bdtodolist`;

-- Volcando estructura para tabla bdtodolist.categoria
CREATE TABLE IF NOT EXISTS `categoria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla bdtodolist.categoria: ~8 rows (aproximadamente)
DELETE FROM `categoria`;
INSERT INTO `categoria` (`id`, `nombre`) VALUES
	(1, 'Trabajo'),
	(2, 'Personal'),
	(3, 'Estudios'),
	(4, 'Ocio'),
	(5, 'Ejercicio'),
	(6, 'Proyecto personal'),
	(7, 'Limpieza del hogar'),
	(8, 'Cita médica');

-- Volcando estructura para tabla bdtodolist.tareas
CREATE TABLE IF NOT EXISTS `tareas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` date DEFAULT NULL,
  `hora` time DEFAULT NULL,
  `titulo` varchar(255) DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `prioridad` int(11) DEFAULT NULL,
  `lugar` varchar(255) DEFAULT NULL,
  `cat_id` int(11) DEFAULT NULL,
  `estado` varchar(20) DEFAULT 'pendiente',
  PRIMARY KEY (`id`),
  KEY `cat_id` (`cat_id`),
  CONSTRAINT `tareas_ibfk_1` FOREIGN KEY (`cat_id`) REFERENCES `categoria` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla bdtodolist.tareas: ~11 rows (aproximadamente)
DELETE FROM `tareas`;
INSERT INTO `tareas` (`id`, `fecha`, `hora`, `titulo`, `imagen`, `descripcion`, `prioridad`, `lugar`, `cat_id`, `estado`) VALUES
	(1, '2024-04-18', '10:00:00', 'Reunión de trabajo', '', 'Reunión semanal de equipo', 1, 'Oficina', 1, 'completada'),
	(2, '2024-04-19', '14:30:00', 'Comprar víveres', '', 'Ir al supermercado y comprar comida para la semana', 2, 'Supermercado XYZ', 2, 'completada'),
	(3, '2024-04-20', '08:00:00', 'Estudiar para el examen', '', 'Repasar los temas de matemáticas', 3, 'Biblioteca', 3, 'pendiente'),
	(4, '2024-04-21', '19:00:00', 'Ver una película', '', 'Ver la nueva película de ciencia ficción', 2, 'Cine', 4, 'pendiente'),
	(5, '2024-04-22', '18:00:00', 'Entrenamiento en el gimnasio', '', 'Hacer ejercicio durante una hora', 2, 'Gimnasio FitnessMax', 5, 'completada'),
	(6, '2024-04-23', '09:00:00', 'Trabajar en el proyecto de programación', '', 'Avanzar en la implementación de la aplicación', 1, 'Casa', 6, 'pendiente'),
	(7, '2024-04-24', '11:30:00', 'Limpiar la casa', '', 'Realizar una limpieza general en todas las habitaciones', 3, 'Hogar', 7, 'completada'),
	(8, '2024-04-25', '15:45:00', 'Consulta médica con el dentista', '', 'Revisión dental de rutina', 4, 'Clínica Dental Smile', 8, 'pendiente'),
	(22, NULL, NULL, 'Nueva tarea', '', 'Descripción de la nueva tarea', NULL, 'Lugar de la nueva tarea', 3, 'pendiente'),
	(23, NULL, NULL, 'Nueva tarea', '', 'Descripción de la nueva tarea', NULL, 'Lugar de la nueva tarea', 3, 'pendiente'),
	(24, NULL, NULL, 'Nueva tarea', '', 'Descripción de la nueva tarea', NULL, 'Lugar de la nueva tarea', 3, 'pendiente');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
