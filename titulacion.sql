-- MySQL dump 10.13  Distrib 5.6.35, for Linux (x86_64)
--
-- Host: localhost    Database: titulacion
-- ------------------------------------------------------
-- Server version	5.6.35-cll-lve

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `Academia`
--

DROP TABLE IF EXISTS `Academia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Academia` (
  `idAcademia` int(11) NOT NULL AUTO_INCREMENT,
  `academia` varchar(45) DEFAULT NULL,
  `password` varchar(256) DEFAULT NULL,
  `carrera` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idAcademia`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Academia`
--

LOCK TABLES `Academia` WRITE;
/*!40000 ALTER TABLE `Academia` DISABLE KEYS */;
INSERT INTO `Academia` VALUES (1,'100','d404559f602eab6fd602ac7680dacbfaadd13630335e951f097af3900e9de176b6db28512f2e000b9d04fba5133e8b1c6e8df59db3a8ab9d60be4b97cc9e81db','DIVISION'),(2,'200','d404559f602eab6fd602ac7680dacbfaadd13630335e951f097af3900e9de176b6db28512f2e000b9d04fba5133e8b1c6e8df59db3a8ab9d60be4b97cc9e81db','ESCOLARES'),(3,'300','d404559f602eab6fd602ac7680dacbfaadd13630335e951f097af3900e9de176b6db28512f2e000b9d04fba5133e8b1c6e8df59db3a8ab9d60be4b97cc9e81db','ING. SISTEMAS');
/*!40000 ALTER TABLE `Academia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Carrera`
--

DROP TABLE IF EXISTS `Carrera`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Carrera` (
  `carrera` varchar(70) NOT NULL,
  PRIMARY KEY (`carrera`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Carrera`
--

LOCK TABLES `Carrera` WRITE;
/*!40000 ALTER TABLE `Carrera` DISABLE KEYS */;
INSERT INTO `Carrera` VALUES ('ING. SISTEMAS COMPUTACIONALES');
/*!40000 ALTER TABLE `Carrera` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Citas`
--

DROP TABLE IF EXISTS `Citas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Citas` (
  `idCitas` int(11) NOT NULL AUTO_INCREMENT,
  `lugar` varchar(45) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `hora` time(6) DEFAULT NULL,
  `Egresado_numControl` int(11) DEFAULT NULL,
  PRIMARY KEY (`idCitas`),
  KEY `fk_Citas_Egresado1_idx` (`Egresado_numControl`),
  CONSTRAINT `fk_Citas_Egresado1` FOREIGN KEY (`Egresado_numControl`) REFERENCES `Egresado` (`numControl`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Citas`
--

LOCK TABLES `Citas` WRITE;
/*!40000 ALTER TABLE `Citas` DISABLE KEYS */;
INSERT INTO `Citas` VALUES (1,'DIVISION','2017-06-28','09:00:00.000000',11270752),(5,'TITULACION','2017-06-29','13:35:00.000000',11270753),(6,'TITULACION','2017-06-29','13:10:00.000000',11270754),(7,'TITULACION','2017-06-27','13:35:00.000000',11270751),(8,'TITULACION','2017-06-30','11:30:00.000000',11270772),(9,'TITULACION','2017-08-02','12:20:00.000000',11270780),(10,'TITULACION','2017-08-02','11:55:00.000000',11270781),(11,'DIVISION','2017-06-29','11:55:00.000000',11270783),(12,'DIVISION','2017-06-29','09:00:00.000000',11270784),(13,'DIVISION','2017-06-30','10:15:00.000000',11270790),(14,'TITULACION','2017-08-01','10:40:00.000000',11270791);
/*!40000 ALTER TABLE `Citas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Config`
--

DROP TABLE IF EXISTS `Config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Config` (
  `idConfig` int(11) NOT NULL AUTO_INCREMENT,
  `f_inicio` date DEFAULT NULL,
  `f_fin` date DEFAULT NULL,
  `h_inicio` time DEFAULT NULL,
  `h_fin` time DEFAULT NULL,
  `intervalo` int(11) DEFAULT NULL,
  `api` tinyint(2) DEFAULT NULL,
  `Calpertenecea` varchar(10) NOT NULL,
  PRIMARY KEY (`idConfig`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Config`
--

LOCK TABLES `Config` WRITE;
/*!40000 ALTER TABLE `Config` DISABLE KEYS */;
INSERT INTO `Config` VALUES (1,'2017-06-05','2017-06-30','09:00:00','14:00:00',25,1,'DIVISION'),(2,'2017-08-01','2017-08-30','09:00:00','15:00:00',30,1,'ESCOLARES');
/*!40000 ALTER TABLE `Config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Egresado`
--

DROP TABLE IF EXISTS `Egresado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Egresado` (
  `numControl` int(11) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `apellidos` varchar(45) DEFAULT NULL,
  `nombreComp` varchar(45) DEFAULT NULL,
  `deudor` varchar(45) DEFAULT NULL,
  `password` varchar(256) DEFAULT NULL,
  `status` varchar(45) DEFAULT 'NUEVO',
  `correo` varchar(45) DEFAULT NULL,
  `planEstudios` varchar(10) NOT NULL,
  `carrera` varchar(70) NOT NULL,
  PRIMARY KEY (`numControl`),
  KEY `fk_Egresado_Plan1_idx` (`planEstudios`),
  KEY `fk_Egresado_Carrera1_idx` (`carrera`),
  CONSTRAINT `fk_Egresado_Carrera1` FOREIGN KEY (`carrera`) REFERENCES `Carrera` (`carrera`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Egresado_Plan1` FOREIGN KEY (`planEstudios`) REFERENCES `Plan` (`plan`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Egresado`
--

LOCK TABLES `Egresado` WRITE;
/*!40000 ALTER TABLE `Egresado` DISABLE KEYS */;
INSERT INTO `Egresado` VALUES (11270751,'Abraham','GarduÃ±o','Abraham GarduÃ±o SÃ¡nchez','N','d404559f602eab6fd602ac7680dacbfaadd13630335e951f097af3900e9de176b6db28512f2e000b9d04fba5133e8b1c6e8df59db3a8ab9d60be4b97cc9e81db','EN TRAMITE','1234','2017','ING. SISTEMAS COMPUTACIONALES'),(11270752,'Andres','Palomeque Ruiz','Andres Palomeque Ruiz','N','3627909a29c31381a071ec27f7c9ca97726182aed29a7ddd2e54353322cfb30abb9e3a6df2ac2c20fe23436311d678564d0c8d305930575f60e2d3d048184d79','EN TRAMITE','correo@mail.com','2017','ING. SISTEMAS COMPUTACIONALES'),(11270753,'Juan','Perez Sanchez','Juan Perez Sanchez','N','d404559f602eab6fd602ac7680dacbfaadd13630335e951f097af3900e9de176b6db28512f2e000b9d04fba5133e8b1c6e8df59db3a8ab9d60be4b97cc9e81db','EN TRAMITE','correo@mail.com','2017','ING. SISTEMAS COMPUTACIONALES'),(11270754,'Oscar','Valdez','Bezarez','N','3627909a29c31381a071ec27f7c9ca97726182aed29a7ddd2e54353322cfb30abb9e3a6df2ac2c20fe23436311d678564d0c8d305930575f60e2d3d048184d79','EN TRAMITE','correo@gmaiil.com','2017','ING. SISTEMAS COMPUTACIONALES'),(11270772,'Hernan','Cortez Diaz','Hernan Cortez Diaz','N','d404559f602eab6fd602ac7680dacbfaadd13630335e951f097af3900e9de176b6db28512f2e000b9d04fba5133e8b1c6e8df59db3a8ab9d60be4b97cc9e81db','EN TRAMITE','correo@mail.com','2017','ING. SISTEMAS COMPUTACIONALES'),(11270780,'Ochenta','Ocho','Ochenta Ocho','N','d404559f602eab6fd602ac7680dacbfaadd13630335e951f097af3900e9de176b6db28512f2e000b9d04fba5133e8b1c6e8df59db3a8ab9d60be4b97cc9e81db','EN TRAMITE','1234','2017','ING. SISTEMAS COMPUTACIONALES'),(11270781,'Ochenta','y UNO','Ochenta Y uNO','N','d404559f602eab6fd602ac7680dacbfaadd13630335e951f097af3900e9de176b6db28512f2e000b9d04fba5133e8b1c6e8df59db3a8ab9d60be4b97cc9e81db','EN TRAMITE','1234','2017','ING. SISTEMAS COMPUTACIONALES'),(11270783,'Ochenta','Y TRES','OCHENTA Y TRES','N','d404559f602eab6fd602ac7680dacbfaadd13630335e951f097af3900e9de176b6db28512f2e000b9d04fba5133e8b1c6e8df59db3a8ab9d60be4b97cc9e81db','EN TRAMITE','1234','2017','ING. SISTEMAS COMPUTACIONALES'),(11270784,'Ochenta','Garduño','Sánchez','N','d404559f602eab6fd602ac7680dacbfaadd13630335e951f097af3900e9de176b6db28512f2e000b9d04fba5133e8b1c6e8df59db3a8ab9d60be4b97cc9e81db','EN TRAMITE','1234','2017','ING. SISTEMAS COMPUTACIONALES'),(11270790,'Esteban','Ruiz Ruiz','Esteban Ruiz Ruiz','N','d404559f602eab6fd602ac7680dacbfaadd13630335e951f097af3900e9de176b6db28512f2e000b9d04fba5133e8b1c6e8df59db3a8ab9d60be4b97cc9e81db','EN TRAMITE','correo@correo.mx','2017','ING. SISTEMAS COMPUTACIONALES'),(11270791,'Pepito','Prueba Sistema','Pepito Prueba Sistema','N','d404559f602eab6fd602ac7680dacbfaadd13630335e951f097af3900e9de176b6db28512f2e000b9d04fba5133e8b1c6e8df59db3a8ab9d60be4b97cc9e81db','EN TRAMITE','prueba@correo','2017','ING. SISTEMAS COMPUTACIONALES');
/*!40000 ALTER TABLE `Egresado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Festivo`
--

DROP TABLE IF EXISTS `Festivo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Festivo` (
  `idFechas` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(10) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  PRIMARY KEY (`idFechas`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Festivo`
--

LOCK TABLES `Festivo` WRITE;
/*!40000 ALTER TABLE `Festivo` DISABLE KEYS */;
/*!40000 ALTER TABLE `Festivo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Jurado`
--

DROP TABLE IF EXISTS `Jurado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Jurado` (
  `idJurado` int(11) NOT NULL AUTO_INCREMENT,
  `numTarjeta` varchar(45) DEFAULT NULL,
  `nombre` varchar(200) DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  `tipo` varchar(45) DEFAULT NULL,
  `Tramite_idTramite` int(11) NOT NULL,
  PRIMARY KEY (`idJurado`),
  KEY `fk_Jurado_Tramite1_idx` (`Tramite_idTramite`),
  CONSTRAINT `fk_Jurado_Tramite1` FOREIGN KEY (`Tramite_idTramite`) REFERENCES `Tramite` (`idTramite`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=83 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Jurado`
--

LOCK TABLES `Jurado` WRITE;
/*!40000 ALTER TABLE `Jurado` DISABLE KEYS */;
INSERT INTO `Jurado` VALUES (1,'1','UNO','ASIGNADO','ASESOR',1),(2,'2','DOS','ASIGNADO','ASESOR',1),(3,'3','TRES','ASIGNADO','ASESOR',1),(4,'1','UNO','ASIGNADO','ASESOR',2),(5,'2','DOS.','ASIGNADO','ASESOR',2),(6,'4','CUATRO','ASIGNADO','ASESOR',2),(7,'1','UNO','ASIGNADO','ASESOR',3),(8,'2','DOS','ASIGNADO','ASESOR',3),(9,'3','TRES','ASIGNADO','ASESOR',3),(10,'1','UNO','ASIGNADO','ASESOR',4),(11,'2','DOS','ASIGNADO','ASESOR',4),(12,'3','TRES','ASIGNADO','ASESOR',4),(13,'1','UNO','ASIGNADO','JURADO',1),(14,'5','CINCO','ASIGNADO','JURADO',1),(15,'3','TRES','ASIGNADO','JURADO',1),(16,'6','SEIS','ASIGNADO','JURADO',1),(17,'3','TRES','ASIGNADO','JURADO',2),(18,'2','DOS','ASIGNADO','JURADO',2),(19,'1','UNO','ASIGNADO','JURADO',2),(20,'0','CERO','ASIGNADO','JURADO',2),(21,'1','Higinio GarcÃ­a Mendoza','ASIGNADO','ASESOR',5),(22,'2','Jorge ElÃ­ Castellanos MartÃ­nez','ASIGNADO','ASESOR',5),(23,'5','JosÃ© Luis Escobar VillagrÃ¡n','ASIGNADO','ASESOR',5),(24,'483','Jorge Octavio GuzmÃ¡n SÃ¡nchez','ASIGNADO','ASESOR',6),(25,'201','Jorge DÃ­az HernÃ¡ndez','ASIGNADO','ASESOR',6),(26,'204','LucÃ­a MarÃ­a Cristina Ventura Canseco','ASIGNADO','ASESOR',6),(27,'1','Higinio GarcÃ­Â­a Mendoza','ASIGNADO','JURADO',5),(28,'2','Jorge ElÃ­Â­ Castellanos MartÃ­nez','ASIGNADO','JURADO',5),(29,'5','JosÃ© Luis Escobar VillagrÃ¡n','ASIGNADO','JURADO',5),(30,'483','Jorge Octavio GuzmÃ¡n SÃ¡nchez','ASIGNADO','JURADO',5),(31,'483','Jorge Octavio GuzmÃƒÂ¡n SÃƒÂ¡nchez','ASIGNADO','JURADO',6),(32,'201','Jorge DÃƒÂ­az HernÃƒÂ¡ndez','ASIGNADO','JURADO',6),(33,'204','LucÃƒÂ­a MarÃƒÂ­a Cristina Ventura Canseco','ASIGNADO','JURADO',6),(34,'101','Amado Castillejos Brindis','ASIGNADO','JURADO',6),(35,'1','Higinio GarcÃ­a Mendoza','ASIGNADO','ASESOR',7),(36,'2','Jorge ElÃ­ Castellanos MartÃ­nez','ASIGNADO','ASESOR',7),(37,'5','JosÃ© Luis Escobar VillagrÃ¡n','ASIGNADO','ASESOR',7),(38,'1','Higinio GarcÃ­Â­a Mendoza','ASIGNADO','JURADO',7),(39,'2','Jorge ElÃ­Â­ Castellanos MartÃ­Â­nez','ASIGNADO','JURADO',7),(40,'5','JosÃ© Luis Escobar VillagrÃ¡n','ASIGNADO','JURADO',7),(41,'483','Jorge Octavio GuzmÃ¡n SÃ¡nchez','ASIGNADO','JURADO',7),(42,'1','Higinio GarcÃ­a Mendoza','ASIGNADO','ASESOR',8),(43,'5','JosÃ© Luis Escobar VillagrÃ¡n','ASIGNADO','ASESOR',8),(44,'12','RenÃ© RÃ­os CoutiÃ±o','ASIGNADO','ASESOR',8),(45,'1','Higinio GarcÃ­a Mendoza','ASIGNADO','JURADO',8),(46,'5','JosÃ© Luis Escobar VillagrÃ¡n','ASIGNADO','JURADO',8),(47,'2','Jorge ElÃ­ Castellanos MartÃ­nez','ASIGNADO','JURADO',8),(48,'18','Imelda Valles LÃ³pez','ASIGNADO','JURADO',8),(49,'18','Imelda Valles LÃ³pez','ASIGNADO','ASESOR',9),(50,'56','Octavio Ariosto RÃ­os Tercero','ASIGNADO','ASESOR',9),(51,'185','Miguel Arturo VÃ¡zquez VelÃ¡zquez','ASIGNADO','ASESOR',9),(52,'185','Miguel Arturo VÃ¡zquez VelÃ¡zquez','ASIGNADO','ASESOR',10),(53,'18','Imelda Valles LÃ³pez','ASIGNADO','ASESOR',10),(54,'286','Daniel RÃ­os GarcÃ­a','ASIGNADO','ASESOR',10),(55,'18','Imelda Valles LÃƒÂ³pez','ASIGNADO','JURADO',9),(56,'56','Octavio Ariosto RÃƒÂ­os Tercero','ASIGNADO','JURADO',9),(57,'185','Miguel Arturo VÃƒÂ¡zquez VelÃƒÂ¡zquez','ASIGNADO','JURADO',9),(58,'483','Jorge Octavio GuzmÃ¡n SÃ¡nchez','ASIGNADO','JURADO',9),(59,'185','Miguel Arturo VÃƒÂ¡zquez VelÃƒÂ¡zquez','ASIGNADO','JURADO',10),(60,'18','Imelda Valles LÃƒÂ³pez','ASIGNADO','JURADO',10),(61,'286','Daniel RÃƒÂ­os GarcÃƒÂ­a','ASIGNADO','JURADO',10),(62,'483','Jorge Octavio GuzmÃ¡n SÃ¡nchez','ASIGNADO','JURADO',10),(63,'18','Imelda Valles LÃ³pez','ASIGNADO','ASESOR',9),(64,'56','Octavio Ariosto RÃ­os Tercero','ASIGNADO','ASESOR',9),(65,'185','Miguel Arturo VÃ¡zquez VelÃ¡zquez','ASIGNADO','ASESOR',9),(66,'18','Imelda Valles LÃƒÂ³pez','ASIGNADO','JURADO',9),(67,'56','Octavio Ariosto RÃƒÂ­os Tercero','ASIGNADO','JURADO',9),(68,'185','Miguel Arturo VÃƒÂ¡zquez VelÃƒÂ¡zquez','ASIGNADO','JURADO',9),(69,'483','Jorge Octavio GuzmÃ¡n SÃ¡nchez','ASIGNADO','JURADO',9),(70,'18','Imelda Valles LÃ³pez','ASIGNADO','ASESOR',11),(71,'185','Miguel Arturo VÃ¡zquez VelÃ¡zquez','ASIGNADO','ASESOR',11),(72,'483','Jorge Octavio GuzmÃ¡n SÃ¡nchez','ASIGNADO','ASESOR',11),(73,'1','Higinio GarcÃ­a Mendoza','ASIGNADO','ASESOR',13),(74,'18','Imelda Valles LÃ³pez','ASIGNADO','ASESOR',13),(75,'19','Raquel Camacho MÃ©ndez','ASIGNADO','ASESOR',13),(76,'1','Higinio GarcÃ­a Mendoza','ASIGNADO','ASESOR',14),(77,'5','JosÃ© Luis Escobar VillagrÃ¡n','ASIGNADO','ASESOR',14),(78,'18','Imelda Valles LÃ³pez','ASIGNADO','ASESOR',14),(79,'1','Higinio GarcÃÂ­a Mendoza','ASIGNADO','JURADO',14),(80,'5','JosÃÂ© Luis Escobar VillagrÃÂ¡n','ASIGNADO','JURADO',14),(81,'18','Imelda Valles LÃÂ³pez','ASIGNADO','JURADO',14),(82,'19','Raquel Camacho MÃ©ndez','ASIGNADO','JURADO',14);
/*!40000 ALTER TABLE `Jurado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Mensajes`
--

DROP TABLE IF EXISTS `Mensajes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Mensajes` (
  `idMensajes` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(15) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `contenido` varchar(500) DEFAULT NULL,
  `para` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`idMensajes`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Mensajes`
--

LOCK TABLES `Mensajes` WRITE;
/*!40000 ALTER TABLE `Mensajes` DISABLE KEYS */;
INSERT INTO `Mensajes` VALUES (1,'ALERTA',NULL,'Tu trámite ha sido cancelado por: CORRECCION DE DATOS','11270754'),(2,'ALERTA',NULL,'Tu trámite ha sido cancelado por: CORRECCION DE DATOS','11270754'),(3,'ALERTA',NULL,'Tu trámite ha sido cancelado por: CORRECCION DE DATOS','11270753');
/*!40000 ALTER TABLE `Mensajes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Opciones`
--

DROP TABLE IF EXISTS `Opciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Opciones` (
  `idOpciones` int(11) NOT NULL AUTO_INCREMENT,
  `imagen` varchar(45) DEFAULT NULL,
  `nombre` varchar(150) DEFAULT NULL,
  `numero` varchar(5) DEFAULT NULL,
  `descripcion` mediumtext,
  `tiempo` varchar(15) DEFAULT NULL,
  `plan` varchar(10) NOT NULL,
  `motivo` varchar(45) DEFAULT NULL,
  `protocolaria` int(11) NOT NULL,
  PRIMARY KEY (`idOpciones`),
  KEY `fk_Opciones_Plan1_idx` (`plan`),
  CONSTRAINT `fk_Opciones_Plan1` FOREIGN KEY (`plan`) REFERENCES `Plan` (`plan`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Opciones`
--

LOCK TABLES `Opciones` WRITE;
/*!40000 ALTER TABLE `Opciones` DISABLE KEYS */;
INSERT INTO `Opciones` VALUES (1,'tesis.png','Tesis','I','Se realiza una tesis para poder titularse.','6 meses','2017',NULL,0),(2,'opcion2','Examen global por areas del conocimiento','VI','			MÓDULO DE MATERIAS  O TESTIMONIO DE\r\n          DESEMPEÑO SOBRESALIENTE ? SATISFACTORIO Y CONSTANCIA DEL CENEVAL.	','5 Meses','2017',NULL,1);
/*!40000 ALTER TABLE `Opciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Plan`
--

DROP TABLE IF EXISTS `Plan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Plan` (
  `plan` varchar(10) NOT NULL,
  `activo` tinyint(2) DEFAULT NULL,
  PRIMARY KEY (`plan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Plan`
--

LOCK TABLES `Plan` WRITE;
/*!40000 ALTER TABLE `Plan` DISABLE KEYS */;
INSERT INTO `Plan` VALUES ('2017',1);
/*!40000 ALTER TABLE `Plan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Puesto`
--

DROP TABLE IF EXISTS `Puesto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Puesto` (
  `idPuesto` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) DEFAULT NULL,
  `puesto` varchar(45) DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  `area` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idPuesto`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Puesto`
--

LOCK TABLES `Puesto` WRITE;
/*!40000 ALTER TABLE `Puesto` DISABLE KEYS */;
INSERT INTO `Puesto` VALUES (1,'M.C. MARÍA GUADALUPE MONJARAS VELASCO','JEFE DE ACADEMIA','ACTIVO','ING. SISTEMAS COMPUTACIONALES'),(2,'M.C. JUAN CARLOS NIÑOS TORRES','JEFE DE DIVISION','ACTIVO','DIVISIÓN DE ESTUDIOS PROFESIONALES');
/*!40000 ALTER TABLE `Puesto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Requisitos`
--

DROP TABLE IF EXISTS `Requisitos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Requisitos` (
  `idRequisitos` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) DEFAULT NULL,
  `tipo` varchar(100) DEFAULT NULL,
  `ejemplo` varchar(45) DEFAULT NULL,
  `imagen` varchar(45) DEFAULT NULL,
  `Opciones_idOpciones` int(11) NOT NULL,
  PRIMARY KEY (`idRequisitos`),
  KEY `fk_Requisitos_Opciones1_idx` (`Opciones_idOpciones`),
  CONSTRAINT `fk_Requisitos_Opciones1` FOREIGN KEY (`Opciones_idOpciones`) REFERENCES `Opciones` (`idOpciones`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Requisitos`
--

LOCK TABLES `Requisitos` WRITE;
/*!40000 ALTER TABLE `Requisitos` DISABLE KEYS */;
INSERT INTO `Requisitos` VALUES (1,'TEMA','texto',NULL,NULL,1),(2,'MODULO DE MATERIAS','archivo',NULL,NULL,2);
/*!40000 ALTER TABLE `Requisitos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Sinodales`
--

DROP TABLE IF EXISTS `Sinodales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Sinodales` (
  `numTarjeta` varchar(200) NOT NULL,
  `Nombre` varchar(200) NOT NULL,
  `Profesion` varchar(200) NOT NULL,
  `Cedula` int(200) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Sinodales`
--

LOCK TABLES `Sinodales` WRITE;
/*!40000 ALTER TABLE `Sinodales` DISABLE KEYS */;
INSERT INTO `Sinodales` VALUES ('1','Higinio García Mendoza','Licenciado en Periodismo',3855883),('2','Jorge Elí Castellanos Martínez','Ingeniero Industrial Electricista',1085775),('5','José Luis Escobar Villagrán','Ingeniero Químico Industrial',977520),('12','René Ríos Coutiño','Maestro en Ciencias en Enseñanza de las Ciencias',4437781),('13','Filiberto Gutiérrez Contreras','Ingeniero',1523712),('14','Luis Modesto Velasco Mota','Maestro en Administración',1856361),('18','Imelda Valles López','Maestro en Ciencias en Administración',3869247),('19','Raquel Camacho Méndez','Maestro en Ciencias en Enseñanza de las Ciencias',4437850),('25','Humberto Torres Jiménez ','Ingeniero Bioquímico',311070),('30','Julio Betanzos Toledo','Ingeniero Electricista',981769),('46','Herlinda González Mendoza','Ingeniero Industrial en Producción',1578115),('48','Gerardo Fernando Díaz Borrego','Ingeniero en Comunicaciones y Electrónica',935695),('52','Jorge Antonio Mijangos López','Maestro en Ciencias en Ingeniería Industrial',2858114),('53','María Elidia Castellanos Morales','Contador Público',2555373),('56','Octavio Ariosto Ríos Tercero','Maestro en Ciencias en Ciencias Computacionales',3433436),('58','Roberto Antonio Meza Guillén','Licenciado en Matemáticas',1615303),('61','Fidel Tovilla Hernández','Ingeniero Industrial Electricista',1221917),('62','Mario Toledo Martínez','Ingeniero Electromecánico en Producción',1137293),('67','Vicente León Orozco','Ingeniero Electricista',1709776),('70','Jesús Alfredo Espinosa Calvo','Ingeniero en Comunicaciones y Electrónica',1687800),('71','Gualberto Juan García Rodríguez','Ingeniero',1523761),('73','Juan José Solís Zavala','Maestro en Educación Química',3610380),('74','Lorenzo Marciano Vázquez','Maestro en Ingeniería Mecánica',3655797),('76','Ricardo Suárez Castillejos','Ingeniero Químico Industrial',625070),('79','Oscar Suárez Ruiz','Ingeniero',1212002),('84','Jacinta Luna Villalobos','Maestro en Administración',3891770),('86','Sabino Velázquez Trujillo','Doctor en Ingeniería en el Área de Procesos de Manufactura',7194459),('92','José Luis Ríos Coutiño','Ingeniero Industrial en Eléctrica',4631968),('94','Wilbert Morgan Blanco Carrillo','Ingeniero Químico',591777),('95','Arnulfo Cabrera Gómez','Maestro en Ciencias en Ingeniería Electrónica',4369000),('98','Roberto Ibáñez Córdova ','Maestro en Ciencias en Ingeniería Electrónica',4033312),('99','J. Guadalupe Hernández Telesfor','Licenciado en Administración de Empresas',1463956),('101','Amado Castillejos Brindis','Contador Público',684342),('104','Gilberto de Jesús  Castañeda Ordóñez','Licenciado en Educación media con Especialidad en Ciencias Sociales',1771233),('105','José Alberto Morales Mancilla','Maestro en Ciencias de la Computación',6000970),('106','José Manuel Montoya Magaña','Ingeniero',1607632),('112','Raúl Moreno Rincón','Maestro en Ciencias en Ingeniería Electrónica',3869307),('113','Evaristo Julio Ballinas Díaz ','Maestro en Ciencias en la Especialidad de Bioingeniería',4123758),('115','Vicente Agustín Coello Constantino','Maestro en Ciencias en Administración',6366790),('120','Lisandro Jiménez López','Ingeniero en Comunicaciones y Electrónica',1193152),('122','Ramón Caralampio Figueroa Pulido','Ingeniero Químico Industrial',1723761),('125','Rodrigo Ferrer González','Ingeniero Industrial Químico',1354973),('127','José Luis Méndez Navarro','Maestro en Educación Holista para el Desarrollo Sustentable',5467888),('129','Carlos Cerda Martínez','Ingeniero',958377),('130','Miguel Cid del Prado Martínez','Maestro en Ciencias de la Administración',4650119),('133','César Arturo Sánchez Elorza','Licenciado en Derecho',239478),('134','Enrique Hernández Maldonado','Maestro en Psicología Educativa',1053972),('136','Roberto Náfate Gómez','Ingeniero',273018),('143','Julio César Ochoa Coutiño','Licenciado en Educación',1875108),('146','Atanacio Hernández Chan','Ingeniero Industrial en Producción',1301117),('148','René Javier Than Márquez','Ingeniero Industrial en Química',1049619),('149','Marco Antonio Mazariegos Morales','Ingeniero Químico Industrial',1278262),('151','Ricardo Alfonso Castellanos Martínez','Ingeniero Industrial en Producción',1552637),('152','Hipólito Hernández Pérez','Licenciado',1176749),('154','Eucario Zenteno Velasco','Químico Bacteriólogo Parasitólogo',906780),('155','Joaquín Adolfo Montes Molina ','Doctor en Ciencias en la Especialidad de Biotecnología',5468273),('156','Leonel Torres Miranda','Ingeniero en Comunicaciones y  Electrónica',1199994),('163','Aura Flores Pérez','Químico Bacteriólogo Parasitólogo',521921),('164','Jesús Maldonado Ramírez','Ingeniero Arquitecto',993554),('166','Federico Antonio Gutiérrez Miceli','Doctor en Ciencias en la Especialidad de Biotecnología',4424804),('167','Pedro Cruz Farrera','Ingeniero Industrial en Eléctrica',1523575),('170','Javier Alfaro Mendoza','Ingeniero Químico Industrial',475845),('171','Ariosto Mandujano Cabrera','Ingeniero Industrial Electricista',1623922),('173','Lázaro Grajales Pascacio','Arquitecto',494018),('176','Arturo Peralta López','Ingeniero Industrial en Producción',1523585),('178','Roberto del Ángel Torres','Ingeniero Mecánico Electricista',1132078),('179','Miguel Ángel de la Cruz Castañeda','Licenciado en Ciencias de la Educación',956637),('183','Odilio Orozco Magdaleno','Ingeniero Electricista',1503946),('185','Miguel Arturo Vázquez Velázquez','Ingeniero en Control  y  Computación',1416035),('188','Neville Rodolfo Culebro Espinosa ','Ingeniero Químico Industrial',123715),('189','Alexis Aguilar Brindis','Ingeniero Industrial en Producción',1898087),('190','Ángel Seín Pérez Rodríguez ','Maestro en Educación Área de Enseñanza Superior',3526473),('193','Rodolfo Isabel Coello Albores','Maestro en Ingeniería en Construcción',7244140),('195','Jaqueline Leyra Hernández','Ingeniero Bioquímico',589444),('197','David Guzmán Molina','Ingeniero Electricista',670586),('199','Isel Coello Ruiz','Contador Público',4318591),('201','Jorge Díaz Hernández','Ingeniero Electricista',4076681),('204','Lucía María Cristina Ventura Canseco','Maestro en Ciencias en Biotecnología de Fermentaciones',3913854),('205','José Antonio Gómez Roblero','Maestro en Administración',9255972),('206','Saúl Rigoberto Ruiz Cruz','Ingeniero Industrial',3311153),('211','Arturo Ochoa Ruiz','Ingeniero Industrial Químico',2318782),('212','Alejandro A Pérez Espinosa','Ing Eléctrico',1155855),('212','Alejandro Rogelio Avelino Pérez Espinosa','Ingeniero Electricista',1155855),('215','Crisanto  Estrada López','Ingeniero',1085704),('224','Abraham Ocampo Solórzano','Ingeniero Industrial Electricista',1877344),('225','Patricia Guadalupe Sánchez Iturbe','Doctor en Ciencias y Biotecnología de Plantas',5149307),('227','Javier Alonso Montero Díaz','Licenciado en Educación Media en el área de Ciencias Naturales',2108491),('232','José Francisco Martínez ','Especialista en Ingeniería Ambiental',4452450),('233','Jorge Arturo Sarmiento Torres','Ingeniero Industrial en Producción',1113714),('234','José Rafael Sánchez Maldonado','Maestro en Ciencias de la Educación',5218470),('240','Francisco Ramón Sánchez Rodríguez','Ingeniero en Comunicaciones y  Electrónica',752582),('241','Margarita Marcelín Madrigal','Ingeniero Bioquímico',772320),('242','Dulce María Hernández Beristain','Químico Farmacobiólogo',763521),('245','Marco Antonio Muñoz Cruz','Ingeniero Industrial en Producción',896214),('246','Samuel Enciso Sáenz','Doctor en Estudios Regionales',8723208),('247','Marco Antonio Gutiérrez Domínguez','Ingeniero Industrial Electricista',1085765),('248','Ignacio Arrioja Cárdenas','Maestro en Ciencias en Ingeniería Mecánica',4322335),('249','Elías Neftalí Escobar Gómez','Doctor en Ingeniería en el Área de Procesos de Manufactura',6586368),('250','Jorge Gonzalo González Aranda','Licenciado',401922),('252','Juan Humberto Carpio Tovilla','Licenciado',576142),('256','José Luis Cuesta Salinas','Ingeniero',2811306),('257','Jorge Ciro Jiménez Ocaña','Maestro en Ciencias con Especialidad en Ingeniería Química',745456),('259','Héctor Ricardo Hernández de León','Doctor en Ciencias en Ingeniería Electrónica',7283033),('264','Rutilo Morales Álvarez ','Ingeniero Industrial Mecánico',2395631),('266','Eneida Lourdes Dávila Mandujano','Doctora en Psicología Educativa',2208622),('273','Héctor Guerra Crespo','Doctor en Sistemas Computacionales',7822421),('274','Javier Ramírez Díaz','Ingeniero Bioquímico',1552688),('276','Julio Moreno Gordillo','Licenciado',873093),('277','Ángel Reyes Albores','Ingeniero Electricista',2065688),('283','Jorge Alfredo León Camacho','Ingeniero Mecánico',1027259),('284','José Anibal López Zamorano','Maestro en Ciencias de la Educación',5070404),('286','Daniel Ríos García','Ingeniero en Electrónica',2275372),('287','Reiner Rincón Rosales','Doctor en Ciencias Biológicas',5989386),('291','Melquiceded Domínguez Holán','Maestro en Finanzas',8713379),('293','Pedro Tomás Ortiz y Ojeda ','Doctor en Matemática Educativa',3586459),('295','Ceín Teco López','Ingeniero Industrial en Eléctrica',1806717),('296','Julio César Lláven Gordillo','Ingeniero Mecánico',2498802),('297','Juan José Villalobos Maldonado','Maestro en Ciencias con Especialidad en Ingeniería Ambiental',2531713),('298','Carlos Ríos Rojas','Doctor en Ciencias en Ingeniería Mecánica',6745078),('301','Víctor Manuel Vázquez Ramírez','Ingeniero Industrial Mecánico',2348332),('302','Jesús Carlos Sánchez Guzmán ','Doctor en Sistemas Computacionales',7528539),('303','Aída Guillermina Cossío Martínez','Maestro en Ciencias en Administración',4387266),('304','Ildeberto de los Santos Ruiz','Ingeniero en Electrónica',2327037),('305','Oscar Javier Rincón Zapata','Ingeniero Industrial en Producción',2205940),('313','Indalecio Daniel  Rodríguez Rojas','Ingeniero Industrial en Eléctrica',23070934),('315','Lester Acosta Maza','Licenciado en Física y Matemáticas',2074911),('317','Jorge Antonio Orozco Torres','Maestro en Ciencias Computacionales',6026519),('318','Walter Torres Robledo','Ingeniero en Electrónica',2333674),('324','Alicia González Laguna','Licenciado en Computación',2425356),('325','María Delina Culebro Farrera','Ingeniero Administrador de Sistemas',2370513),('330','Rigoberto Jiménez Jonapá','Ingeniero en Electrónica',2507329),('331','Madaín Pérez Patricio','Doctor en Ciencias Computacionales',4951023),('332','José Manuel Santiago Calvo','Licenciado en Sistemas de Computación Administrativa',2141968),('333','Fernando Alfonso May Arrioja','Ingeniero Mecánico',2275632),('334','Dalila Brisceyda Cantoral Díaz','Contador Público',4077565),('338','María Candelaria Gutiérrez Gómez','Doctora en Administración',7936395),('339','Rafael Mota Grajales','Maestro en Ciencias en Ingeniería Eléctrica',2499051),('341','Álvaro Hernández Sol','Ingeniero en Electrónica',2220499),('342','Jorge William Figueroa Corzo','Maestro en Administración',7981821),('344','Rubén Herrera Galicia','Doctor en Ingeniería Eléctrica',6290027),('345','Daniel Samayoa Penagos','Maestro en Administración',3772105),('350','José Ángel Zepeda Hernández','Maestro en Ingeniería Mecatrónica',8603985),('351','Roberto Carlos García Gómez','Maestro en Ciencias en Ingeniería Mecánica',6285807),('352','Francisco de Jesús Suárez Ruiz','Ingeniero en Sistemas Computacionales',2721831),('353','Raúl Paredes Trinidad','Ingeniero en Sistemas Computacionales',2507334),('356','Julio Enrique Megchún Vázquez','Ingeniero Industrial en Eléctrica',2902638),('358','Karlos Velázquez Moreno','Ingeniero Industrial en Eléctrica',2903135),('363','Leonardo Gómez Gutiérrez','Ingeniero Químico',2206508),('364','Joaquín Eduardo Domínguez Zenteno','Maestro en Ciencias en Ingeniería Electrónica',4322359),('365','Miguel Abud Archila','Maestro en Ciencias en Alimentos',3913853),('374','Galdino Belizario Nango Solis','Maestro en Ciencias de la Computación',4050080),('375','Roberto Cifuentes Villafuerte','Ingeniero Mecánico',4718249),('378','Marco Antonio Zúñiga Reyes','Ingeniero en Electrónica',2507339),('379','René Cuesta Díaz','Ingeniero Químico',2903167),('385','Carlos Venturino de Coss Pérez','Maestro en Ciencias en Ingeniería Industrial',5210443),('387','Apolinar Pérez López','Maestro en Ingeniería ',5856578),('395','Adriana del Carmen González Escobar','Licenciado en Psicología',991535),('401','Madeleine Hidalgo Morales','Maestro en Ciencias en Alimentos',3148092),('402','Hernán Valencia Sánchez','Maestro en Ciencias en Ingenieria Mecatrónica',9562173),('403','Octavio Rolando Lara Martínez','Doctor en Educación',9890189),('408','Sandy Luz Ovando Chacón','Doctora en Ciencias en Alimentos',4904506),('411','Judith Arminda García Cancino','Maestra en Ciencias de la Educación',3516861),('412','Teresa del Rosario Ayora Talavera','Maestro en Ciencias en Biotecnología',1961570),('417','David Teco López','Ingeniero Bioquímico',3429395),('418','Carlos Ramón Alfonzo Santiago','Ingeniero Mecánico',2721801),('421','Jorge Luis Camas Anzueto','Doctor en Ciencias con Especialidad en Óptica',4471708),('427','Jorge Armando Gómez Salinas','Ingeniero Bioquímico',3903162),('431','Alejandro Medina Santiago','Doctor en Ciencias en la Especialidad de Ingeniería Eléctrica',6257785),('432','Luis Alberto Pérez Lozano','Ingeniero Eléctrico',5680617),('437','Ciclalli Cabrera García','Licenciada en Informática',5558964),('438','Helios Seth Pérez Gómez','Ingeniero Industrial',5432271),('444','Edalí Ramos Mijangos','Ingeniera Industrial',4183509),('449','Rosa Isela Cruz Rodríguez','Maestra en Ciencias en Ingeniería Bioquímica',6326633),('451','Gilberto Hernández Cruz','Maestro en Ciencias de la Educación',6230781),('452','María Guadalupe Monjarás Velasco','Ingeniera en Sistemas Computacionales',5784553),('455','Rosy Ilda Basave Torres','Maestra en Ciencias de la Computación',4904518),('456','Lidya Margarita Blanco González','Maestra en Ciencias en Ingeniería Administrativa',5114717),('458','Samuel Gómez Peñate','Ingeniero en Electrónica',4718262),('459','Juan Carlos Niños Torres','Maestro en Ingeniería Mecánica',6331560),('460','Amín Rodríguez Meneses','Maestro en Ciencias de la Salud',7239966),('463','Pedro Pablo Mayorga Álvarez','Ingeniero en Sistemas Computacionales',4046208),('468','Mario Alberto de la Cruz Padilla','Maestro en Ciencias en Ingeniería Mecánica',5608159),('469','Roberto Cruz Gordillo','Ingeniero Electrónico',2647701),('472','María Celina Luján Hidalgo','Maestra en Ciencias en Ingeniería Bioquímica',6326634),('480','Edna Morales Coutiño','Maestra en Ciencias de la Educación',2320560),('481','José Humberto Castañón González','Maestro en Ciencias Quimicobiológicas',4164689),('483','Jorge Octavio Guzmán Sánchez','Maestro en Ciencias de la Computación',6860785),('485','José del Carmen Vázquez Hernández','Doctor en Administración',10442259),('489','Gabriela Alejandra Ríos Zúñiga','Maestra en Administración ',6285148),('493','Claudia Ivette Ruiz Suárez','Ingniera Química',4248451),('494','Rocío Farrera Alcázar ','Ingeniero Químico',2483749),('495','José Manuel Rasgado Bezáres','Ingeniero Mecánico',2498788),('496','German Ríos Toledo','Maestro en Ciencias de la Computación',6055898),('498','Arnulfo Rosales Quintero','Maestro en Ciencias con Especialidad en Ingeniería Química',5264892),('499','Roberto Antonio Meza Meneses','Doctor en Administración',8388678),('500','Francisco Ronay López Estrada','Doctor en Ciencias en Ingeniería Electrónica',9526502),('501','Rocío Meza Gordillo','Doctora en Ciencias en la Especialidad de Química Orgánica',8318069),('502','Catalina Salgado Gutiérrez','Maestra en Administración ',8379403),('503','Roberto David Vázquez Solís','Maestro en Biotecnología',4127153),('504','María Laura Porraz Ruiz','Maestra en Ciencias  en  Ingeniería Bioquímica',6528934),('505','José Alfredo Gómez Santíz','Maestro en Ciencias Bioquímicas',7801886),('506','Luis Alberto Jiménez Zebadúa','Ingeniero Bioquímico',4467956),('507','Osbaldo Ysaac García Ramos','Ingeniero Eléctrico',3641218),('509','Saúl de Jesús Molina Domínguez','Maestro en Ciencias en Ingeniería Mecánica',6331557),('512','Gustavo Méndez Lambarén','Ingeniero Industrial',5993332),('516','Lenin Russell Suárez Aguilar','Maestro en Ciencias en Ingeniería Mecánica',6888666),('517','Néstor Antonio Morales Navarro','Maestro en Ingeniería Mecatrónica',7298860),('518','Osvaldo Brindis Velázquez','Maestro en Ciencias en Ingeniería Mecatrónica',7298854),('521','Aldo Esteban Aguilar Castillejos','Maestro en Ciencias en Ingeniería Mecatrónica',7298853),('523','Víctor Manuel Ruiz Valdiviezo','Doctor en Ciencias en la Especialidad de Biotecnología',8765307),('524','José Santos Cruz','Doctor en Ciencias en la Especialidad de Materiales',9672673),('525','Pavel Vorobiev','Doctor en Ciencias',0),('526','Juan José Arreola Ordaz','Ingeniero Bioquímico',7753853),('527','Jorge Humberto Ruiz Ovalle','Doctor en Sistemas Computacionales',9684008),('528','Nancy Ruiz Lau','Doctora en Ciencias Biólogicas: BioquimÍca y Biología Molecular',9642120),('529','Carlos Alberto Lecona Guzmán','Doctor en Ciencias Biológicas Bioquímica y Biología',7982054),('530','Lizeth Torres Ortiz','Maestra en Ciencias de la Ingeniería Electrónica',5075078),('531','Luis Alberto  Morales Alias','Maestro en Ciencias en Ingeniería Mecánica',502665);
/*!40000 ALTER TABLE `Sinodales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Tramite`
--

DROP TABLE IF EXISTS `Tramite`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Tramite` (
  `idTramite` int(11) NOT NULL AUTO_INCREMENT,
  `opcion` varchar(45) DEFAULT NULL,
  `estado` varchar(45) DEFAULT NULL,
  `Egresado_numControl` int(11) NOT NULL,
  `Academia_idAcademia` int(11) DEFAULT NULL,
  `motivo` varchar(100) NOT NULL,
  PRIMARY KEY (`idTramite`),
  KEY `fk_Tramite_Egresado1_idx` (`Egresado_numControl`),
  KEY `fk_Tramite_Academia1_idx` (`Academia_idAcademia`),
  CONSTRAINT `fk_Tramite_Academia1` FOREIGN KEY (`Academia_idAcademia`) REFERENCES `Academia` (`idAcademia`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Tramite_Egresado1` FOREIGN KEY (`Egresado_numControl`) REFERENCES `Egresado` (`numControl`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Tramite`
--

LOCK TABLES `Tramite` WRITE;
/*!40000 ALTER TABLE `Tramite` DISABLE KEYS */;
INSERT INTO `Tramite` VALUES (1,'1','ACTO AGENDADO',11270752,NULL,''),(2,'1','CANCELADO',11270753,NULL,'CORRECCION DE DATOS'),(3,'1','CANCELADO',11270754,NULL,'CORRECCION DE DATOS'),(4,'1','CANCELADO',11270754,NULL,'CORRECCION DE DATOS'),(5,'1','TRAMITE FINALIZADO',11270753,NULL,''),(6,'1','TRAMITE FINALIZADO',11270754,NULL,''),(7,'1','JURADO ASIGNADO',11270751,NULL,''),(8,'2','TRAMITE FINALIZADO',11270772,NULL,''),(9,'1','TRAMITE FINALIZADO',11270780,NULL,''),(10,'2','TRAMITE FINALIZADO',11270781,NULL,''),(11,'1','ASESORES ASIGNADOS',11270783,NULL,''),(12,'1','CITA AGENDADA',11270784,NULL,''),(13,'1','REVISION ESCOLARES',11270790,NULL,''),(14,'2','TRAMITE FINALIZADO',11270791,NULL,'');
/*!40000 ALTER TABLE `Tramite` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Valores`
--

DROP TABLE IF EXISTS `Valores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Valores` (
  `idValores` int(11) NOT NULL AUTO_INCREMENT,
  `datos` varchar(350) DEFAULT NULL,
  `informacion` varchar(100) DEFAULT NULL,
  `Requisitos_idRequisitos` int(11) NOT NULL,
  `Egresado_numControl` int(11) NOT NULL,
  PRIMARY KEY (`idValores`),
  KEY `fk_Valores_Requisitos1_idx` (`Requisitos_idRequisitos`),
  KEY `fk_Valores_Egresado1_idx` (`Egresado_numControl`),
  CONSTRAINT `fk_Valores_Egresado1` FOREIGN KEY (`Egresado_numControl`) REFERENCES `Egresado` (`numControl`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Valores_Requisitos1` FOREIGN KEY (`Requisitos_idRequisitos`) REFERENCES `Requisitos` (`idRequisitos`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Valores`
--

LOCK TABLES `Valores` WRITE;
/*!40000 ALTER TABLE `Valores` DISABLE KEYS */;
INSERT INTO `Valores` VALUES (1,'TESIS PARA OBTENER EL GRADO DE ...',NULL,1,11270780),(2,'QUIERO TESIS POR GANAR',NULL,1,11270783),(3,'tema',NULL,1,11270784),(4,'esto es un prueba',NULL,1,11270790);
/*!40000 ALTER TABLE `Valores` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-07-02 21:11:21
