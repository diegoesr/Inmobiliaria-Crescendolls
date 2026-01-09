-- =============================================
-- Base de Datos: Inmobiliaria Crescendolls
-- =============================================
-- Instrucciones:
-- 1. Crear la base de datos: CREATE DATABASE inmobiliaria_db;
-- 2. Seleccionarla: USE inmobiliaria_db;
-- 3. Ejecutar este script
-- =============================================

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- =============================================
-- Tabla: contactos
-- Almacena mensajes del formulario de contacto
-- =============================================
DROP TABLE IF EXISTS `contactos`;
CREATE TABLE `contactos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `asunto` varchar(200) DEFAULT NULL,
  `mensaje` text NOT NULL,
  `fecha_contacto` timestamp NOT NULL DEFAULT current_timestamp(),
  `estado` enum('nuevo','leido','respondido') DEFAULT 'nuevo',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- =============================================
-- Tabla: propiedades
-- Catálogo de propiedades inmobiliarias
-- =============================================
DROP TABLE IF EXISTS `propiedades`;
CREATE TABLE `propiedades` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` decimal(12,2) NOT NULL,
  `habitaciones` int(11) DEFAULT NULL,
  `banos` int(11) DEFAULT NULL,
  `metros_cuadrados` int(11) DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `disponible` tinyint(1) DEFAULT 1,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Datos de ejemplo
INSERT INTO `propiedades` VALUES 
(1,'Casa Moderna','Casa','Hermosa casa moderna con acabados de lujo, jardín amplio y excelente ubicación en zona residencial',8000000.00,4,3,300,'img/casa2.webp',1,NOW()),
(2,'Departamento Centro','Departamento','Apartamento céntrico cerca de todas las comodidades, transporte público y zonas comerciales',1000000.00,2,1,80,'img/depa1.webp',1,NOW()),
(3,'Casa de Lujo','Casa','Exclusiva residencia de lujo con piscina, amplios espacios, acabados premium y seguridad 24/7',30000000.00,5,4,500,'img/casa3.webp',1,NOW()),
(4,'Departamento Familiar','Departamento','Amplio departamento ideal para familias, con áreas verdes y estacionamiento',2500000.00,3,2,120,'img/depa2.webp',1,NOW()),
(5,'Casa Colonial','Casa','Hermosa casa estilo colonial restaurada, con detalles arquitectónicos únicos y patio central',5500000.00,3,2,250,'img/casa4.webp',1,NOW()),
(6,'Penthouse Ejecutivo','Departamento','Penthouse de lujo con vista panorámica, gimnasio y amenidades exclusivas',15000000.00,4,3,200,'img/casa5.webp',1,NOW());

-- =============================================
-- Tabla: solicitudes_contacto
-- Solicitudes de información sobre propiedades
-- =============================================
DROP TABLE IF EXISTS `solicitudes_contacto`;
CREATE TABLE `solicitudes_contacto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `propiedad_id` int(11) NOT NULL,
  `nombre_cliente` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `mensaje` text DEFAULT NULL,
  `tipo_interes` enum('compra','renta','informacion') DEFAULT 'informacion',
  `fecha_solicitud` timestamp NOT NULL DEFAULT current_timestamp(),
  `estado` enum('pendiente','contactado','finalizado') DEFAULT 'pendiente',
  PRIMARY KEY (`id`),
  KEY `propiedad_id` (`propiedad_id`),
  CONSTRAINT `solicitudes_contacto_ibfk_1` FOREIGN KEY (`propiedad_id`) REFERENCES `propiedades` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- =============================================
-- Fin del script
-- =============================================

