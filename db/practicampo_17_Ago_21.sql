-- MySQL dump 10.14  Distrib 5.5.65-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: practicampoud
-- ------------------------------------------------------
-- Server version	5.5.65-MariaDB

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
-- Table structure for table `categoria`
--

DROP TABLE IF EXISTS `categoria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categoria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categoria` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categoria`
--

LOCK TABLES `categoria` WRITE;
/*!40000 ALTER TABLE `categoria` DISABLE KEYS */;
INSERT INTO `categoria` VALUES (1,'PROFESOR ASISTENTE'),(2,'PROFESOR ASISTENTE COMPLETO'),(3,'PROFESOR ASOCIADO'),(4,'PROFESOR ASOCIADO COMPLETO'),(5,'PROFESOR AUXILIAR'),(6,'PROFESOR AUXILIAR COMPLETO'),(7,'PROFESOR TITULAR'),(8,'PROFESOR TITULAR COMPLETO'),(9,'TITULAR XIII'),(10,'TITULAR XVII'),(11,'TITULAR XVIII'),(12,'TITULAR XIX'),(13,'TITULAR XXII');
/*!40000 ALTER TABLE `categoria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `control_sistema`
--

DROP TABLE IF EXISTS `control_sistema`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `control_sistema` (
  `id` int(11) DEFAULT NULL,
  `fecha_apert_proy` date DEFAULT NULL,
  `fecha_cierre_proy` date DEFAULT NULL,
  `fecha_apert_solic` date DEFAULT NULL,
  `fecha_cierre_solic` date DEFAULT NULL,
  `fecha_actualizacion` date DEFAULT NULL,
  `vlr_estud_max` bigint(20) DEFAULT NULL,
  `vlr_estud_min` bigint(20) DEFAULT NULL,
  `vlr_docen_max` bigint(20) DEFAULT NULL,
  `vlr_docen_min` bigint(20) DEFAULT NULL,
  `id_usuer_update` bigint(20) DEFAULT NULL,
  `estado_proy` bit(1) DEFAULT b'0',
  `estado_solic` bit(1) DEFAULT b'0',
  `noti_apert_proy` bit(1) DEFAULT b'0',
  `noti_apert_solic` bit(1) DEFAULT b'0',
  `noti_cierre_proy` bit(1) DEFAULT b'0',
  `noti_cierre_solic` bit(1) DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `control_sistema`
--

LOCK TABLES `control_sistema` WRITE;
/*!40000 ALTER TABLE `control_sistema` DISABLE KEYS */;
INSERT INTO `control_sistema` VALUES (1,'2021-06-23','2021-07-22','2021-06-23','2021-07-22','2021-06-23',52600,35100,135400,0,659863256,'','','','\0','','\0');
/*!40000 ALTER TABLE `control_sistema` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `costos_proyeccion`
--

DROP TABLE IF EXISTS `costos_proyeccion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `costos_proyeccion` (
  `id` int(11) NOT NULL,
  `vlr_materiales_rp` bigint(20) DEFAULT '0',
  `vlr_materiales_ra` bigint(20) DEFAULT '0',
  `vlr_otros_boletas_rp` bigint(20) DEFAULT '0',
  `vlr_otros_boletas_ra` bigint(20) DEFAULT '0',
  `vlr_guias_baquianos_rp` bigint(20) DEFAULT '0',
  `vlr_guias_baquianos_ra` bigint(20) DEFAULT '0',
  `viaticos_estudiantes_rp` bigint(20) DEFAULT NULL,
  `viaticos_estudiantes_ra` bigint(20) DEFAULT NULL,
  `viaticos_docente_rp` bigint(20) DEFAULT NULL,
  `viaticos_docente_ra` bigint(20) DEFAULT NULL,
  `costo_total_transporte_menor_rp` bigint(20) DEFAULT '0',
  `costo_total_transporte_menor_ra` bigint(20) DEFAULT '0',
  `valor_estimado_transporte_rp` bigint(20) DEFAULT NULL,
  `valor_estimado_transporte_ra` bigint(20) DEFAULT NULL,
  `total_presupuesto_rp` bigint(20) DEFAULT NULL,
  `total_presupuesto_ra` bigint(20) DEFAULT NULL,
  KEY `fk_costos_proyeccion_preliminar_idx` (`id`),
  CONSTRAINT `fk_costos_proyeccion_preliminar` FOREIGN KEY (`id`) REFERENCES `proyeccion_preliminar` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `costos_proyeccion`
--

LOCK TABLES `costos_proyeccion` WRITE;
/*!40000 ALTER TABLE `costos_proyeccion` DISABLE KEYS */;
/*!40000 ALTER TABLE `costos_proyeccion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `docentes_practica`
--

DROP TABLE IF EXISTS `docentes_practica`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `docentes_practica` (
  `id` int(11) NOT NULL,
  `soporte_personal_apoyo` longtext COLLATE utf8mb4_unicode_ci,
  `num_docentes_acomp` int(11) DEFAULT NULL,
  `num_docentes_apoyo` int(11) DEFAULT NULL,
  `num_doc_docente_apoyo_1` bigint(20) DEFAULT NULL,
  `num_doc_docente_apoyo_2` bigint(20) DEFAULT NULL,
  `num_doc_docente_apoyo_3` bigint(20) DEFAULT NULL,
  `num_doc_docente_apoyo_4` bigint(20) DEFAULT NULL,
  `num_doc_docente_apoyo_5` bigint(20) DEFAULT NULL,
  `num_doc_docente_apoyo_6` bigint(20) DEFAULT NULL,
  `num_doc_docente_apoyo_7` bigint(20) DEFAULT NULL,
  `num_doc_docente_apoyo_8` bigint(20) DEFAULT NULL,
  `num_doc_docente_apoyo_9` bigint(20) DEFAULT NULL,
  `num_doc_docente_apoyo_10` bigint(20) DEFAULT NULL,
  `docente_apoyo_1` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `docente_apoyo_2` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `docente_apoyo_3` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `docente_apoyo_4` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `docente_apoyo_5` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `docente_apoyo_6` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `docente_apoyo_7` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `docente_apoyo_8` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `docente_apoyo_9` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `docente_apoyo_10` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `monitor` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `num_monitor` bigint(50) DEFAULT NULL,
  KEY `fk_docente_practica_proyeccion_preliminar_idx` (`id`),
  CONSTRAINT `fk_docente_practica_proyeccion_preliminar` FOREIGN KEY (`id`) REFERENCES `proyeccion_preliminar` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `docentes_practica`
--

LOCK TABLES `docentes_practica` WRITE;
/*!40000 ALTER TABLE `docentes_practica` DISABLE KEYS */;
/*!40000 ALTER TABLE `docentes_practica` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `documentos_requeridos_solicitud`
--

DROP TABLE IF EXISTS `documentos_requeridos_solicitud`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `documentos_requeridos_solicitud` (
  `id` int(11) DEFAULT NULL,
  `seguro_estudiantil` bit(1) DEFAULT b'0',
  `documento_identificacion` bit(1) DEFAULT b'0',
  `documento_rh` bit(1) DEFAULT b'0',
  `certificado_eps` bit(1) DEFAULT b'0',
  `permiso_acudiente` bit(1) DEFAULT b'0',
  `vacuna_fiebre_amarilla` bit(1) DEFAULT b'0',
  `vacuna_tetanos` bit(1) DEFAULT b'0',
  `certificado_natacion` bit(1) DEFAULT b'0',
  `certificado_adicional_1` bit(1) DEFAULT b'0',
  `certificado_adicional_2` bit(1) DEFAULT b'0',
  `certificado_adicional_3` bit(1) DEFAULT b'0',
  `detalle_certificado_adcional_1` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `detalle_certificado_adcional_2` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `detalle_certificado_adcional_3` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `documentos_requeridos_solicitud`
--

LOCK TABLES `documentos_requeridos_solicitud` WRITE;
/*!40000 ALTER TABLE `documentos_requeridos_solicitud` DISABLE KEYS */;
/*!40000 ALTER TABLE `documentos_requeridos_solicitud` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `encuesta_transporte`
--

DROP TABLE IF EXISTS `encuesta_transporte`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `encuesta_transporte` (
  `id` int(11) NOT NULL,
  `cumplio_expect` bit(1) DEFAULT NULL,
  `ruta_prevista` bit(1) DEFAULT NULL,
  `carac_solicitadas` bit(1) DEFAULT NULL,
  `comport_adecuado` bit(1) DEFAULT NULL,
  `horar_estab` bit(1) DEFAULT NULL,
  `nov_cron_ruta` bit(1) DEFAULT NULL,
  `adecuado_traslado` bit(1) DEFAULT NULL,
  `no_cumplio_expect` longtext COLLATE utf8_unicode_ci,
  `no_ruta_prevista` longtext COLLATE utf8_unicode_ci,
  `no_carac_solicitadas` longtext COLLATE utf8_unicode_ci,
  `no_comport_adecuado` longtext COLLATE utf8_unicode_ci,
  `no_horar_estab` longtext COLLATE utf8_unicode_ci,
  `con_nov_cron_ruta` longtext COLLATE utf8_unicode_ci,
  `no_adecuado_traslado` longtext COLLATE utf8_unicode_ci,
  `diligenciado` bit(1) DEFAULT b'0',
  `fecha_diligenciamiento` date DEFAULT NULL,
  KEY `fk_encuesta_transporte_solicitud_practica_idx` (`id`),
  CONSTRAINT `fk_encuesta_transporte_solicitud_practica` FOREIGN KEY (`id`) REFERENCES `solicitud_practica` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `encuesta_transporte`
--

LOCK TABLES `encuesta_transporte` WRITE;
/*!40000 ALTER TABLE `encuesta_transporte` DISABLE KEYS */;
/*!40000 ALTER TABLE `encuesta_transporte` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `espacio_academico`
--

DROP TABLE IF EXISTS `espacio_academico`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `espacio_academico` (
  `id` int(11) NOT NULL,
  `id_programa_academico` int(11) NOT NULL,
  `codigo_espacio_academico` int(11) NOT NULL,
  `espacio_academico` varchar(90) COLLATE utf8mb4_unicode_ci NOT NULL,
  `plan_estudios_1` int(11) DEFAULT '0',
  `plan_estudios_2` int(11) DEFAULT '0',
  `tipo_espacio` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `electiva` bit(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_programa_academico_espacio_academico_idx` (`id_programa_academico`),
  CONSTRAINT `fk_programa_academico_espacio_academico` FOREIGN KEY (`id_programa_academico`) REFERENCES `programa_academico` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `espacio_academico`
--

LOCK TABLES `espacio_academico` WRITE;
/*!40000 ALTER TABLE `espacio_academico` DISABLE KEYS */;
INSERT INTO `espacio_academico` VALUES (1,1,7019,'Deporte Formativo',248,348,'T/P','\0'),(2,1,7021,'Desarrollo Organizacional',248,348,'T/P','\0'),(3,1,7046,'Deporte de Alto Rendimiento',248,348,'T/P','\0'),(4,1,7050,'Escenarios y Entornos Deportivos',248,348,'T/P','\0'),(5,1,7058,'Organización de Eventos Recreo-Deportivos y Culturales',248,348,'T/P','\0'),(10,10,2148,'Aprovechamiento Forestal',242,342,'T/P','\0'),(11,10,2175,'Áreas Protegidas',242,342,'T/P','\0'),(12,10,2170,'Biología de la Conservación',242,342,'T/P','\0'),(13,10,2111,'Biología General',242,342,'T/P','\0'),(14,10,2115,'Botánica Taxonómica',242,342,'T/P','\0'),(15,10,2147,'Conservación de Suelos',242,342,'T/P','\0'),(16,10,2153,'Cuencas Hidrográficas',242,342,'T/P','\0'),(17,10,2124,'Dendrología I',242,342,'T/P','\0'),(18,10,2132,'Dendrología II',242,NULL,'T/P','\0'),(19,10,2130,'Ecología Forestal Avanzada',242,342,'T/P','\0'),(20,10,2161,'Estructuras de Madera',242,342,'T/P','\0'),(21,10,2166,'Evaluación Ambiental',242,342,'T/P','\0'),(22,10,2156,'Extensión Forestal',242,342,'T/P','\0'),(23,10,2134,'Fisiología Forestal',242,342,'T/P','\0'),(24,10,2155,'Fitomejoramiento Forestal',242,342,'T/P','\0'),(25,10,2119,'Geologia y Geomorfología',242,342,'T/P','\0'),(26,10,2177,'Gestión del Riesgo',242,342,'T/P','\0'),(27,10,2139,'Hidrología',242,342,'T/P','\0'),(28,10,2167,'Industrias Forestales I',242,342,'T/P','\0'),(29,10,2174,'Industrias Forestales II',242,342,'T/P','\0'),(30,10,2113,'Introducción a la Ingeniería Forestal',242,342,'T/P','\0'),(31,10,2138,'Mediciones Forestales',242,342,'T/P','\0'),(32,10,2152,'Modelamiento de Fenómenos Biológicos',242,342,'T/P','\0'),(33,10,2173,'Ordenación de Bosques',242,342,'T/P','\0'),(34,10,2160,'Ordenamiento Territorial',242,342,'T/P','\0'),(35,10,2126,'Percepción Remota e Interpretación de Imágenes',242,342,'T/P','\0'),(36,10,2137,'Práctica Integrada I',242,342,'P','\0'),(37,10,2159,'Práctica Integrada II',242,342,'P','\0'),(38,10,2179,'Práctica Integrada III',242,342,'P','\0'),(39,10,2154,'Propiedades de la Madera',242,342,'T/P','\0'),(40,10,2128,'Química de Productos Forestales',242,342,'T/P','\0'),(41,10,2146,'Sanidad Forestal',242,342,'T/P','\0'),(42,10,2163,'Silvicultura de Bosque Natural',242,342,'T/P','\0'),(43,10,2149,'Silvicultura de Plantaciones',242,342,'T/P','\0'),(44,10,2116,'Sistemas Agroforestales',242,342,'T/P','\0'),(45,10,2127,'Suelos I',242,342,'T/P','\0'),(46,10,2133,'Suelos II',242,342,'T/P','\0'),(47,131,2238,'Cartografía Digital',243,343,'T/P','\0'),(48,131,2232,'Fotogrametria y Fotointerpretación',243,NULL,'T/P','\0'),(49,131,2245,'Geodesia Posicional',243,NULL,'T/P','\0'),(50,131,19604,'Levantamientos Altimétricos',343,NULL,'T/P','\0'),(51,131,19605,'Levantamientos Astronómicos',343,NULL,'T/P','\0'),(52,131,2241,'Levantamientos Especiales',243,NULL,'T/P','\0'),(53,131,19608,'Levantamientos Especiales I',343,NULL,'T/P','\0'),(54,131,19611,'Levantamientos Fotogramétricos',343,NULL,'T/P','\0'),(55,131,19615,'Levantamientos Geodésicos',343,NULL,'T/P','\0'),(56,131,19601,'Levantamientos Planimétricos',343,NULL,'T/P','\0'),(57,131,2228,'Localización de Vías',243,NULL,'T/P','\0'),(58,131,19610,'Obras Civiles I',343,NULL,'T/P','\0'),(59,131,19613,'Topografía Ambiental',343,NULL,'T/P','\0'),(60,131,19606,'Topografía de Vías I',343,NULL,'T/P','\0'),(61,131,19609,'Topografía de Vías II',343,NULL,'T/P','\0'),(62,131,19612,'Trabajo Comunitario',343,NULL,'T/P','\0'),(63,32,2005,'Planimetría',241,NULL,'T/P','\0'),(64,32,2007,'Altimetria',341,NULL,'T/P','\0'),(65,32,2015,'Geodesia Geométrica',341,NULL,'T/P','\0'),(66,32,2020,'Diseño Geométrico de Vías',341,NULL,'T/P','\0'),(67,32,2024,'Localización de Vías',341,NULL,'T/P','\0'),(68,32,2031,'Mecánica de Suelos',341,NULL,'T/P','\0'),(69,32,2038,'Evaluación Ambiental',341,NULL,'T/P','\0'),(70,32,2041,'Levantamientos Especiales',341,NULL,'T/P','\0'),(71,32,2053,'Ingeniería Ambiental',341,NULL,'T/P','\0'),(72,81,2325,'Administración Municipal y Desarrollo Local',244,344,'T/P','\0'),(73,81,2319,'Calidad del Agua',244,344,'T/P','\0'),(74,81,2312,'Ecología',244,344,'T/P','\0'),(75,81,2327,'Gestión Ambiental I',344,NULL,'T/P','\0'),(76,81,2323,'Gestión Ambiental II',344,NULL,'T/P','\0'),(77,81,2346,'Gestión Comercial de los Servicios Públicos',244,344,'T/P','\0'),(78,81,2328,'Manejo Integral de Cuencas Hidrográficas',344,244,'T/P','\0'),(79,81,2324,'Manejo Integral de Residuos Líquidos',344,244,'T/P','\0'),(80,81,2331,'Manejo Integral de Residuos Sólidos',344,NULL,'T/P','\0'),(81,81,2334,'Operación de Plantas y Estaciones de Bombeo',244,344,'T/P','\0'),(82,81,2339,'Servicio Público de Acueducto y Alcantarillado',244,344,'T/P','\0'),(83,81,2341,'Servicio Público de Energía Eléctrica',244,344,'T/P','\0'),(84,85,2519,'Calidad del Agua',246,NULL,'T/P','\0'),(85,85,2524,'Fundamentos de Acueductos y Alcantarillados',246,NULL,'T/P','\0'),(86,85,2027,'Fundamentos de Ecología',246,NULL,'T/P','\0'),(87,85,2506,'Hidráulica',246,NULL,'T/P','\0'),(88,85,2503,'Introducción al Saneamiento Ambiental',344,NULL,'T/P','\0'),(89,85,2526,'Manejo Residuos Líquidos',246,NULL,'T/P','\0'),(90,85,2528,'Organización Comunitaria',246,NULL,'T/P','\0'),(91,85,2532,'Residuos Sólidos',246,NULL,'T/P','\0'),(92,85,2543,'Salida Integral de Saneamiento',246,NULL,'T/P','\0'),(93,85,2540,'Salud Ocupacional y Seguridad Industrial',246,NULL,'T/P','\0'),(94,85,2539,'Saneamiento Urbano y Rural',246,NULL,'T/P','\0'),(95,85,2509,'Sociedad y Ambiente',246,NULL,'T/P','\0'),(96,85,2507,'Topografía y Cartografía',246,NULL,'T/P','\0'),(97,85,2525,'Tratamiento de Agua para Consumo',246,NULL,'T/P','\0'),(98,85,2520,'Zoonosis',246,NULL,'T/P','\0'),(99,180,2728,'Contaminación Ambiental I',247,347,'T/P','\0'),(100,180,2734,'Contaminación Ambiental II',247,347,'T/P','\0'),(101,180,2727,'Ecología Analítica',247,347,'T/P','\0'),(102,180,2742,'Evaluación Ambiental I',247,347,'T/P','\0'),(103,180,2746,'Evaluación Ambiental II',347,NULL,'T/P','\0'),(104,180,2730,'Físico Química de Fluidos',347,247,'T/P','\0'),(105,180,2027,'Fundamentos de Ecología',247,NULL,'T/P','\0'),(106,180,2716,'Geología y Geomorfología',247,347,'T/P','\0'),(107,180,2736,'Hidrogeología',247,347,'T/P','\0'),(108,180,2726,'Hidrología',247,347,'T/P','\0'),(109,180,2703,'Introducción a la Ingeniería Ambiental',247,347,'T/P','\0'),(110,180,2743,'Manejo Técnico Ambiental',247,347,'T/P','\0'),(111,180,2733,'Ordenamiento Territorial Rural',247,347,'T/P','\0'),(112,180,2724,'Química Ambiental Aplicada',247,NULL,'T/P','\0'),(113,180,2720,'Suelos',247,347,'T/P','\0'),(114,180,2735,'Tecnologías Apropiadas I',247,347,'T/P','\0'),(115,180,2739,'Tecnologías Apropiadas II',247,347,'T/P','\0'),(116,181,11810,'Acueductos',249,349,'T/P','\0'),(117,181,11812,'Calidad del Aire',249,349,'T/P','\0'),(118,181,11802,'Ecología Humana',249,349,'T/P','\0'),(119,181,2531,'Emisiones Atmosféricas',249,349,'T/P','\0'),(120,181,2027,'Fundamentos de Ecología',249,349,'T/P','\0'),(121,181,2528,'Organización Comunitaria',249,349,'T/P','\0'),(122,181,11817,'Plantas de Agua Potable',249,349,'T/P','\0'),(123,181,11820,'Plantas de Agua Residual',249,349,'T/P','\0'),(124,181,11811,'Procesos Unitarios I',249,349,'T/P','\0'),(125,181,11809,'Química Sanitaria',249,349,'T/P','\0'),(126,181,2532,'Residuos Sólidos',249,349,'T/P','\0'),(127,181,11821,'Salida Integral de Ingeniería Sanitaria',249,349,'T/P','\0'),(128,181,2509,'Sociedad y Ambiente',249,349,'T/P','\0'),(129,181,11814,'Tratamiento y Disposición de Residuos Sólidos',249,349,'T/P','\0'),(130,181,11804,'Zoonosis y Epidemiología',249,349,'T/P','\0'),(131,185,2418,'Problemas y Alternativas Ambientales',245,NULL,'T/P','\0'),(132,185,2429,'Factores de Riesgo Ambiental en Salud Pública',245,NULL,'T/P','\0'),(133,185,2434,'Vulnerabilidad y Riesgos',245,NULL,'T/P','\0'),(134,185,2439,'Planificación Ambiental Territorial',245,NULL,'T/P','\0'),(135,185,2443,'Administración de Recursos Naturales',245,NULL,'T/P','\0'),(139,185,19101,'Planificación Ambiental Territorial',345,NULL,'T/P','\0'),(141,114,11402101,'Planificación ambiental en el desarrollo local',2,NULL,'T/P','\0'),(142,114,11402103,'Evaluación del impacto ambiental',2,NULL,'T/P','\0'),(143,14,1430103,'Diseño Geométrico de Carreteras',2,NULL,'T/P','\0'),(144,14,1430104,'Diseño de Pavimentos Mantenimientos y Reahabilitación',2,NULL,'T/P','\0'),(145,13,1301002,'Ecología de Recursos Naturales',2,NULL,'T/P','\0'),(146,13,1301004,'Ordenamiento Territorial',2,NULL,'T/P','\0'),(147,21,11011003,'Fundamentos de Ecología',1,NULL,'T/P','\0'),(148,21,11012001,'Biología de la Conservación ',1,NULL,'T/P','\0'),(149,21,11012002,'Geografía Ambiental y de los Recursos Naturales',1,NULL,'T/P','\0'),(150,110,2101001,'Diversidad Forestal',1,NULL,'T/P','\0'),(151,110,2101002,'Manejo Forestal',1,NULL,'T/P','\0'),(152,110,2101007,'Electiva I',1,NULL,'T/P','\0'),(153,200,1234,'Prueba',12,NULL,'T/P','\0'),(999,999,0,'N/A',0,0,'N/A','\0');
/*!40000 ALTER TABLE `espacio_academico` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estado`
--

DROP TABLE IF EXISTS `estado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `estado` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `estado` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abrev` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estado`
--

LOCK TABLES `estado` WRITE;
/*!40000 ALTER TABLE `estado` DISABLE KEYS */;
INSERT INTO `estado` VALUES (1,'Activo','Act.'),(2,'Inactivo','Inact.'),(3,'Aprobado','Aprob.'),(4,'Desaprobado','Desap.'),(5,'Pendiente','Pend.'),(6,'Realizada','Hecho'),(7,'Visto Bueno','V.° B.°');
/*!40000 ALTER TABLE `estado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estudiantes_solicitud_practica`
--

DROP TABLE IF EXISTS `estudiantes_solicitud_practica`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `estudiantes_solicitud_practica` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_solicitud_practica` int(11) NOT NULL,
  `id_tipo_identificacion` int(11) DEFAULT '0',
  `num_identificacion` bigint(20) DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `estado_estudiante` int(11) NOT NULL DEFAULT '1',
  `nombre_completo` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `fecha_nacimiento` date DEFAULT NULL,
  `eps` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `celular` bigint(20) DEFAULT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `grupo` int(11) DEFAULT '1',
  `aprob_terminos_condiciones` bit(1) DEFAULT b'0',
  `verificacion_asistencia` bit(1) DEFAULT b'0',
  `seguro_estudiantil` longtext COLLATE utf8mb4_unicode_ci,
  `documento_identificacion` longtext COLLATE utf8mb4_unicode_ci,
  `documento_rh` longtext COLLATE utf8mb4_unicode_ci,
  `certificado_eps` longtext COLLATE utf8mb4_unicode_ci,
  `permiso_acudiente` longtext COLLATE utf8mb4_unicode_ci,
  `vacuna_fiebre_amarilla` longtext COLLATE utf8mb4_unicode_ci,
  `vacuna_tetanos` longtext COLLATE utf8mb4_unicode_ci,
  `certificado_natacion` longtext COLLATE utf8mb4_unicode_ci,
  `certificado_adicional_1` longtext COLLATE utf8mb4_unicode_ci,
  `certificado_adicional_2` longtext COLLATE utf8mb4_unicode_ci,
  `certificado_adicional_3` longtext COLLATE utf8mb4_unicode_ci,
  `detalle_certificado_adicional_1` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `detalle_certificado_adicional_2` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `detalle_certificado_adicional_3` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `noti_15_dias` bit(1) DEFAULT b'0',
  `noti_8_dias` bit(1) DEFAULT b'0',
  `habilitado` bit(1) DEFAULT b'1',
  `id_role` int(11) DEFAULT '8',
  PRIMARY KEY (`id`),
  KEY `fk_estudiantes_solicitud_practica_tipo_identificacion_idx` (`id_tipo_identificacion`),
  KEY `fk_estudiantes_solicitud_practica_solicitud_practica_idx` (`id_solicitud_practica`),
  KEY `fk_estudiantes_solicitud_practica_estado_idx` (`estado_estudiante`),
  KEY `fk_estudiantes_solicitud_practica_roles` (`id_role`),
  CONSTRAINT `fk_estudiantes_solicitud_practica_estado` FOREIGN KEY (`estado_estudiante`) REFERENCES `estado` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_estudiantes_solicitud_practica_roles` FOREIGN KEY (`id_role`) REFERENCES `roles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_estudiantes_solicitud_practica_solicitud_practica` FOREIGN KEY (`id_solicitud_practica`) REFERENCES `solicitud_practica` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_estudiantes_solicitud_practica_tipo_identificacion` FOREIGN KEY (`id_tipo_identificacion`) REFERENCES `tipo_identificacion` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estudiantes_solicitud_practica`
--

LOCK TABLES `estudiantes_solicitud_practica` WRITE;
/*!40000 ALTER TABLE `estudiantes_solicitud_practica` DISABLE KEYS */;
/*!40000 ALTER TABLE `estudiantes_solicitud_practica` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `materiales_herramientas_proyeccion`
--

DROP TABLE IF EXISTS `materiales_herramientas_proyeccion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `materiales_herramientas_proyeccion` (
  `id` int(11) NOT NULL,
  `det_materiales_rp` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `det_materiales_ra` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `det_otros_boletas_rp` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `det_otros_boletas_ra` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `det_guias_baquianos_rp` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `det_guias_baquianos_ra` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  KEY `fk_materiales_herramientas_proyeccion_preliminar_idx` (`id`),
  CONSTRAINT `fk_materiales_herramientas_proyeccion_preliminar` FOREIGN KEY (`id`) REFERENCES `proyeccion_preliminar` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `materiales_herramientas_proyeccion`
--

LOCK TABLES `materiales_herramientas_proyeccion` WRITE;
/*!40000 ALTER TABLE `materiales_herramientas_proyeccion` DISABLE KEYS */;
/*!40000 ALTER TABLE `materiales_herramientas_proyeccion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oficio`
--

DROP TABLE IF EXISTS `oficio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oficio` (
  `id` int(11) DEFAULT NULL,
  `parr_1` longtext COLLATE utf8_unicode_ci,
  `parr_2` longtext COLLATE utf8_unicode_ci,
  `parr_3` longtext COLLATE utf8_unicode_ci,
  `parr_4` longtext COLLATE utf8_unicode_ci,
  `parr_5` longtext COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oficio`
--

LOCK TABLES `oficio` WRITE;
/*!40000 ALTER TABLE `oficio` DISABLE KEYS */;
INSERT INTO `oficio` VALUES (1,'DFAMARENA-','FRANKLIN WILCHES REYES','Jefe Sección Presupuesto','Respetado Doctor Wilches:','PBX 57(1)3239300 EXT.4000');
/*!40000 ALTER TABLE `oficio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
INSERT INTO `password_resets` VALUES ('lvgiraldos@udistrital.edu.co','$2y$10$HgeDytZK.jrf3HIyz13Y1.IJFsGWDx.w2cMoF5n3JIuoPT9MrFxEa','2021-01-28 22:01:51'),('lauritagiraldo.s@gmail.com','$2y$10$QYOBioYq/CuzeTvh6CzG7.3NzM/zWvXgAyCFZBqMTiJOw4/Lc991u','2021-02-04 17:17:41'),('lvgiraldos@udistrital.edu.co','$2y$10$HgeDytZK.jrf3HIyz13Y1.IJFsGWDx.w2cMoF5n3JIuoPT9MrFxEa','2021-01-28 22:01:51'),('lauritagiraldo.s@gmail.com','$2y$10$QYOBioYq/CuzeTvh6CzG7.3NzM/zWvXgAyCFZBqMTiJOw4/Lc991u','2021-02-04 17:17:41');
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `periodo_academico`
--

DROP TABLE IF EXISTS `periodo_academico`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `periodo_academico` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `periodo_academico` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `periodo_academico`
--

LOCK TABLES `periodo_academico` WRITE;
/*!40000 ALTER TABLE `periodo_academico` DISABLE KEYS */;
INSERT INTO `periodo_academico` VALUES (1,'I'),(2,'II'),(3,'III');
/*!40000 ALTER TABLE `periodo_academico` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `practicas_integradas`
--

DROP TABLE IF EXISTS `practicas_integradas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `practicas_integradas` (
  `id` int(11) NOT NULL,
  `cant_espa_aca` int(11) DEFAULT NULL,
  `id_espa_aca_1` int(11) DEFAULT NULL,
  `id_espa_aca_2` int(11) DEFAULT NULL,
  `id_espa_aca_3` int(11) DEFAULT NULL,
  `id_espa_aca_4` int(11) DEFAULT NULL,
  `id_espa_aca_5` int(11) DEFAULT NULL,
  `id_espa_aca_6` int(11) DEFAULT NULL,
  `id_espa_aca_7` int(11) DEFAULT NULL,
  `id_docen_espa_aca_1` bigint(20) DEFAULT NULL,
  `id_docen_espa_aca_2` bigint(20) DEFAULT NULL,
  `id_docen_espa_aca_3` bigint(20) DEFAULT NULL,
  `id_docen_espa_aca_4` bigint(20) DEFAULT NULL,
  `id_docen_espa_aca_5` bigint(20) DEFAULT NULL,
  `id_docen_espa_aca_6` bigint(20) DEFAULT NULL,
  `id_docen_espa_aca_7` bigint(20) DEFAULT NULL,
  KEY `fk_proyeccion_preliminar_practica_integrada_idx` (`id`),
  CONSTRAINT `fk_proyeccion_preliminar_practica_integrada` FOREIGN KEY (`id`) REFERENCES `proyeccion_preliminar` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `practicas_integradas`
--

LOCK TABLES `practicas_integradas` WRITE;
/*!40000 ALTER TABLE `practicas_integradas` DISABLE KEYS */;
/*!40000 ALTER TABLE `practicas_integradas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `programa_academico`
--

DROP TABLE IF EXISTS `programa_academico`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `programa_academico` (
  `id` int(11) NOT NULL,
  `programa_academico` varchar(70) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pregrado` bit(1) DEFAULT b'1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `programa_academico`
--

LOCK TABLES `programa_academico` WRITE;
/*!40000 ALTER TABLE `programa_academico` DISABLE KEYS */;
INSERT INTO `programa_academico` VALUES (1,'Administración Deportiva',''),(10,'Ingeniería Forestal',''),(13,'Especialización en Gerencia de Recursos Naturales','\0'),(14,'Especialización en Diseño de Vías Urbanas, Transito y Transporte','\0'),(21,'Maestría en Desarrollo Sustentable y Gestión Ambiental','\0'),(32,'Ingeniería Topográfica',''),(81,'Tecnología en Gestión Ambiental',''),(85,'Tecnología en Saneamiento Ambiental',''),(110,'Maestría en Manejo, Uso y Conservación del Bosque ','\0'),(114,'Especialización en Ambiente y Desarrollo Local','\0'),(131,'Tecnología en Levantamientos Topográficos',''),(180,'Ingeniería Ambiental',''),(181,'Ingeniería Sanitaria',''),(185,'Administración Ambiental',''),(200,'Maestría en Infraestructura Vial','\0'),(999,'N/A','');
/*!40000 ALTER TABLE `programa_academico` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `proyeccion_preliminar`
--

DROP TABLE IF EXISTS `proyeccion_preliminar`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `proyeccion_preliminar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_estado` int(11) NOT NULL DEFAULT '0',
  `practicas_integradas` bit(1) NOT NULL DEFAULT b'0',
  `id_programa_academico` int(11) DEFAULT NULL,
  `id_espacio_academico` int(11) DEFAULT NULL,
  `id_periodo_academico` int(11) DEFAULT NULL,
  `anio_periodo` int(11) DEFAULT NULL,
  `id_semestre_asignatura` int(11) DEFAULT NULL,
  `id_docente_responsable` bigint(20) DEFAULT NULL,
  `num_estudiantes_aprox` int(11) DEFAULT NULL,
  `cantidad_grupos` int(11) DEFAULT NULL,
  `grupo_1` int(11) DEFAULT NULL,
  `grupo_2` int(11) DEFAULT NULL,
  `grupo_3` int(11) DEFAULT NULL,
  `grupo_4` int(11) DEFAULT NULL,
  `destino_rp` longtext COLLATE utf8mb4_unicode_ci,
  `cantidad_url_rp` int(11) DEFAULT NULL,
  `ruta_principal` longblob,
  `ruta_principal_2` longblob,
  `ruta_principal_3` longblob,
  `ruta_principal_4` longblob,
  `ruta_principal_5` longblob,
  `ruta_principal_6` longblob,
  `destino_ra` longtext COLLATE utf8mb4_unicode_ci,
  `cantidad_url_ra` int(11) DEFAULT NULL,
  `ruta_alterna` longblob,
  `ruta_alterna_2` longblob,
  `ruta_alterna_3` longblob,
  `ruta_alterna_4` longblob,
  `ruta_alterna_5` longblob,
  `ruta_alterna_6` longblob,
  `det_recorrido_interno_rp` longtext COLLATE utf8mb4_unicode_ci,
  `det_recorrido_interno_ra` longtext COLLATE utf8mb4_unicode_ci,
  `lugar_salida_rp` int(11) NOT NULL,
  `lugar_salida_ra` int(11) DEFAULT NULL,
  `lugar_regreso_rp` int(11) DEFAULT NULL,
  `lugar_regreso_ra` int(11) DEFAULT NULL,
  `fecha_salida_aprox_rp` date DEFAULT NULL,
  `fecha_salida_aprox_ra` date DEFAULT NULL,
  `fecha_regreso_aprox_rp` date DEFAULT NULL,
  `fecha_regreso_aprox_ra` date DEFAULT NULL,
  `duracion_num_dias_rp` int(11) DEFAULT NULL,
  `duracion_num_dias_ra` int(11) DEFAULT NULL,
  `confirm_creador` bit(1) DEFAULT NULL,
  `id_creador_confirm` bigint(20) DEFAULT NULL,
  `confirm_docente` bit(1) DEFAULT NULL,
  `id_docente_confirm` bigint(20) DEFAULT NULL,
  `confirm_coord` bit(1) DEFAULT NULL,
  `id_coordinador_confirm` bigint(20) DEFAULT NULL,
  `confirm_electiva_coord` bit(1) DEFAULT NULL,
  `id_coordinador_electiva_confirm` bigint(20) DEFAULT NULL,
  `confirm_asistD` bit(1) DEFAULT NULL,
  `id_asistD_confirm` bigint(20) DEFAULT NULL,
  `conf_curricul_plan_pract_rp` bit(1) DEFAULT NULL,
  `conf_curricul_plan_pract_ra` bit(1) DEFAULT NULL,
  `observ_coordinador` longtext COLLATE utf8mb4_unicode_ci,
  `observ_decano` longtext COLLATE utf8mb4_unicode_ci,
  `aprobacion_coordinador` int(11) DEFAULT NULL,
  `id_coordinador_aprob` bigint(20) DEFAULT NULL,
  `aprobacion_decano` int(11) DEFAULT NULL,
  `id_decano_aprob` bigint(20) DEFAULT NULL,
  `aprobacion_asistD` int(11) DEFAULT NULL,
  `id_asistD_aprob` bigint(20) DEFAULT NULL,
  `aprobacion_consejo_facultad` int(11) DEFAULT NULL,
  `num_acta_consejo_facultad` int(11) DEFAULT NULL,
  `fecha_acta_consejo_facultad` date DEFAULT NULL,
  `id_asistD_aprob_consejo` bigint(20) DEFAULT NULL,
  `fecha_diligenciamiento` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_proyeccion_preliminar_users_idx` (`id_docente_responsable`),
  KEY `fk_proyeccion_preliminar_espacio_academico_idx` (`id_espacio_academico`),
  KEY `fk_proyeccion_preliminar_periodo_academico_idx` (`id_periodo_academico`),
  KEY `fk_proyeccion_preliminar_semestre_asignatura_idx` (`id_semestre_asignatura`),
  KEY `fk_proyeccion_preliminar_estado_coord_idx` (`aprobacion_coordinador`),
  KEY `fk_proyeccion_preliminar_estado_dec_idx` (`aprobacion_decano`),
  KEY `fk_proyeccion_preliminar_programa_academico_idx` (`id_programa_academico`),
  KEY `fk_proyeccion_preliminar_estado_asistD_idx` (`aprobacion_asistD`),
  KEY `fk_proyeccion_preliminar_estado_cons_facultad_idx` (`aprobacion_consejo_facultad`),
  KEY `fk_proyeccion_preliminar_estado_idx` (`id_estado`),
  KEY `fk_proyeccion_preliminar_sedes_regreso_rp_idx` (`lugar_regreso_rp`),
  KEY `fk_proyeccion_preliminar_sedes_regreso_ra_idx` (`lugar_regreso_ra`),
  KEY `fk_proyeccion_preliminar_sedes_salida_rp_idx` (`lugar_salida_rp`),
  KEY `fk_proyeccion_preliminar_sedes_salida_ra_idx` (`lugar_salida_ra`),
  CONSTRAINT `fk_proyeccion_preliminar_espacio_academico` FOREIGN KEY (`id_espacio_academico`) REFERENCES `espacio_academico` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_proyeccion_preliminar_estado` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_proyeccion_preliminar_estado_asistD` FOREIGN KEY (`aprobacion_asistD`) REFERENCES `estado` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_proyeccion_preliminar_estado_cons_facultad` FOREIGN KEY (`aprobacion_consejo_facultad`) REFERENCES `estado` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_proyeccion_preliminar_estado_coord` FOREIGN KEY (`aprobacion_coordinador`) REFERENCES `estado` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_proyeccion_preliminar_estado_dec` FOREIGN KEY (`aprobacion_decano`) REFERENCES `estado` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_proyeccion_preliminar_periodo_academico` FOREIGN KEY (`id_periodo_academico`) REFERENCES `periodo_academico` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_proyeccion_preliminar_programa_academico` FOREIGN KEY (`id_programa_academico`) REFERENCES `programa_academico` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_proyeccion_preliminar_sedes_regreso_ra` FOREIGN KEY (`lugar_regreso_ra`) REFERENCES `sedes_universidad` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_proyeccion_preliminar_sedes_regreso_rp` FOREIGN KEY (`lugar_regreso_rp`) REFERENCES `sedes_universidad` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_proyeccion_preliminar_sedes_salida_ra` FOREIGN KEY (`lugar_salida_ra`) REFERENCES `sedes_universidad` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_proyeccion_preliminar_sedes_salida_rp` FOREIGN KEY (`lugar_salida_rp`) REFERENCES `sedes_universidad` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_proyeccion_preliminar_semestre_asignatura` FOREIGN KEY (`id_semestre_asignatura`) REFERENCES `semestre_asignatura` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_proyeccion_preliminar_users` FOREIGN KEY (`id_docente_responsable`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPRESSED;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proyeccion_preliminar`
--

LOCK TABLES `proyeccion_preliminar` WRITE;
/*!40000 ALTER TABLE `proyeccion_preliminar` DISABLE KEYS */;
/*!40000 ALTER TABLE `proyeccion_preliminar` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `resolucion`
--

DROP TABLE IF EXISTS `resolucion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `resolucion` (
  `id` int(11) DEFAULT NULL,
  `parr_1` longtext COLLATE utf8mb4_unicode_ci,
  `parr_2` longtext COLLATE utf8mb4_unicode_ci,
  `parr_3` longtext COLLATE utf8mb4_unicode_ci,
  `parr_4` longtext COLLATE utf8mb4_unicode_ci,
  `parr_5` longtext COLLATE utf8mb4_unicode_ci,
  `parr_6` longtext COLLATE utf8mb4_unicode_ci,
  `parr_6_1` longtext COLLATE utf8mb4_unicode_ci,
  `parr_7` longtext COLLATE utf8mb4_unicode_ci,
  `parr_8` longtext COLLATE utf8mb4_unicode_ci,
  `parr_9` longtext COLLATE utf8mb4_unicode_ci,
  `parr_10` longtext COLLATE utf8mb4_unicode_ci,
  `parr_11` longtext COLLATE utf8mb4_unicode_ci,
  `parr_12` longtext COLLATE utf8mb4_unicode_ci,
  `parr_13` longtext COLLATE utf8mb4_unicode_ci,
  `parr_14` longtext COLLATE utf8mb4_unicode_ci,
  `parr_15` longtext COLLATE utf8mb4_unicode_ci,
  `parr_16` longtext COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `resolucion`
--

LOCK TABLES `resolucion` WRITE;
/*!40000 ALTER TABLE `resolucion` DISABLE KEYS */;
INSERT INTO `resolucion` VALUES (1,'Que en virtud de las Resoluciones No. 009 del 15 de enero de 2020 el señor Rector de la Universidad Distrital Francisco José de Caldas delega en el Decano de la Facultad de Medio Ambiente y Recursos Naturales la ordenación del gasto y la contratación para el rubro de Practicas Académicas Facultad del Medio Ambiente.','Que mediante Resolución del Consejo Superior Universitario No. 004 del 4 de marzo de 2003, se establecen las escalas salariales de las distintas categorías de empleos de la Universidad Distrital Francisco José de Caldas y se dictan otras disposiciones.','Que en el artículo cuarto de la Resolución de la Rectoría No. 311 del 25 de junio de 2019, se establece que: “para la realización de prácticas académicas, a los docentes de carrera y de vinculación especial, sólo se les podrán reconocer viáticos, a 31 de diciembre de 2003, hasta por el valor de SESENTA Y CINCO MIL PESOS ($65.000) MC/TE por día pernoctado. Dicha suma, se reajustará anualmente en un porcentaje igual al incremento del índice de Precios al Consumidor (1.P.C.) Nacional, que registre el DANE a 31 de diciembre de cada','Que mediante Resolución de Rectoría No. 311 del 25 de junio de 2019, se reglamenta el procedimiento general de solicitud de los avances, aprobación, desembolso y su correspondiente legalización en la Universidad.','Que en el artículo tercero de la Resolución de Rectoría No. 311 del 25 de junio de 2019, se establecen las modalidades de avances.','Que en el artículo primero del Acuerdo 012 del 24 de octubre de 2019 el Consejo Superior modificó el Artículo del Acuerdo No. 010 de 1988, en el cual determinó que:','\"ARTÍCULO 2°. Los estudiantes que deban realizar prácticas académicas fuera de la ciudad de Bogotá en el territorio Nacional, según la normatividad interna, recibirán un auxilio económico equivalente al valor de uno punto dos (1.2) Salarios Mínimos Diarios Legales Mensuales Vigentes —SMDLV, cuando la práctica sea por un solo  día.','En el caso que las prácticas sean por dos (2) o más días, los estudiantes recibirán un auxilio económico equivalente al valor de uno punto ocho 0.8) Salarios Mínimos Diarios Legales Mensuales Vigentes —SMDLV, por cada uno de los días de práctica académica\"','Que se hace necesario autorizar el trámite de un avance a la División Financiera de la Universidad Distrital Francisco José de Caldas, y así mismo el manejo y ejecución del mismo a un docente de  la una actividad académica.','Que los planes de prácticas de los diferentes Proyectos Curriculares adscritos a la Facultad del Medio Ambiente y Recursos Naturales se aprobaron por el Consejo de Facultad mediante sesión del',NULL,'** El viático de cada docente es de  (el número de días – 0.5)  * $','El auxilio de cada estudiante  para prácticas de un día cuyo destino es fuera de la ciudad de Bogotá es de $','El auxilio diario de cada estudiante  para prácticas de más de un día cuyo destino es fuera de la ciudad de Bogotá  es de $','Que el Decano de la Facultad del Medio Ambiente y Recursos Naturales en uso de sus facultades legales y especialmente las contempladas en el Articulo 91 del Acuerdo 11 de 2002, literal e, concede comisión para adelantar actividades relacionadas con su actividad académica al (los) docente(s) que participara(n) en la(s) práctica(s) académica(s) descrita es este acto administrativo','Delegar al citado docente para el manejo y legalización de los recursos entregados','La presente Resolución rige a partir de la de fecha de su expedición.');
/*!40000 ALTER TABLE `resolucion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `riesgos_amenazas_practica`
--

DROP TABLE IF EXISTS `riesgos_amenazas_practica`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `riesgos_amenazas_practica` (
  `id` int(11) NOT NULL,
  `areas_acuaticas_rp` bit(1) NOT NULL DEFAULT b'0',
  `areas_acuaticas_ra` bit(1) NOT NULL DEFAULT b'0',
  `alturas_rp` bit(1) NOT NULL DEFAULT b'0',
  `alturas_ra` bit(1) NOT NULL DEFAULT b'0',
  `riesgo_biologico_rp` bit(1) NOT NULL DEFAULT b'0',
  `riesgo_biologico_ra` bit(1) NOT NULL DEFAULT b'0',
  `espacios_confinados_rp` bit(1) NOT NULL DEFAULT b'0',
  `espacios_confinados_ra` bit(1) NOT NULL DEFAULT b'0',
  KEY `fk_riesgos_amenazas_proyeccion_preliminar_idx` (`id`),
  CONSTRAINT `fk_riesgos_amenazas_proyeccion_preliminar` FOREIGN KEY (`id`) REFERENCES `proyeccion_preliminar` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `riesgos_amenazas_practica`
--

LOCK TABLES `riesgos_amenazas_practica` WRITE;
/*!40000 ALTER TABLE `riesgos_amenazas_practica` DISABLE KEYS */;
/*!40000 ALTER TABLE `riesgos_amenazas_practica` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'Admin'),(2,'Decano'),(3,'Asistente Decanatura'),(4,'Coordinador Proyecto'),(5,'Docente'),(6,'Vicerrectoria Administrativa'),(7,'Transportador'),(8,'Estudiante');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sedes_universidad`
--

DROP TABLE IF EXISTS `sedes_universidad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sedes_universidad` (
  `id` int(11) NOT NULL,
  `sede` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `direccion` varchar(190) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sedes_universidad`
--

LOCK TABLES `sedes_universidad` WRITE;
/*!40000 ALTER TABLE `sedes_universidad` DISABLE KEYS */;
INSERT INTO `sedes_universidad` VALUES (1,'Central','Carrera 7 # 40B - 53'),(2,'Macarena','Carrera 3 # 26A - 40'),(3,'Porvenir','Calle 52 Sur # 93D - 97'),(4,'Tecnológica','Calle 68D Bis A Sur # 49F - 70'),(5,'Vivero','Carrera 5 Este # 15-82');
/*!40000 ALTER TABLE `sedes_universidad` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `semestre_asignatura`
--

DROP TABLE IF EXISTS `semestre_asignatura`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `semestre_asignatura` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `semestre_asignatura` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `semestre_asignatura`
--

LOCK TABLES `semestre_asignatura` WRITE;
/*!40000 ALTER TABLE `semestre_asignatura` DISABLE KEYS */;
INSERT INTO `semestre_asignatura` VALUES (1,'I'),(2,'II'),(3,'III'),(4,'IV'),(5,'V'),(6,'VI'),(7,'VII'),(8,'VIII'),(9,'IX'),(10,'X');
/*!40000 ALTER TABLE `semestre_asignatura` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `solicitud_practica`
--

DROP TABLE IF EXISTS `solicitud_practica`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `solicitud_practica` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_proyeccion_preliminar` int(11) DEFAULT NULL,
  `id_estado_solicitud_practica` int(11) DEFAULT NULL,
  `tipo_ruta` int(11) DEFAULT NULL,
  `si_capital` bit(1) DEFAULT NULL,
  `num_solicitud_necesidad` varchar(9) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tiene_resolucion` bit(1) DEFAULT NULL,
  `num_resolucion` int(9) DEFAULT NULL,
  `fecha_resolucion` date DEFAULT NULL,
  `num_cdp` int(4) DEFAULT NULL,
  `confirm_creador` bit(1) DEFAULT b'0',
  `id_docente_creador` bigint(20) DEFAULT NULL,
  `confirm_docente` bit(1) DEFAULT b'0',
  `id_docente_confirm` bigint(20) DEFAULT NULL,
  `confirm_coord` bit(1) DEFAULT b'0',
  `id_coordinador_confirm` bigint(20) DEFAULT NULL,
  `confirm_asistD` bit(1) DEFAULT b'0',
  `id_asistD_confirm` bigint(20) DEFAULT NULL,
  `aprobacion_coordinador` int(11) DEFAULT NULL,
  `id_coordinador_aprob` bigint(20) DEFAULT NULL,
  `aprobacion_decano` int(11) DEFAULT NULL,
  `id_decano_aprob` bigint(20) DEFAULT NULL,
  `aprobacion_asistD` int(11) DEFAULT NULL,
  `id_asistD_aprob` bigint(20) DEFAULT NULL,
  `id_asistD_legal` bigint(20) DEFAULT NULL,
  `fecha_salida` date DEFAULT NULL,
  `hora_salida` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha_regreso` date DEFAULT NULL,
  `hora_regreso` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `duracion_num_dias` int(11) DEFAULT '0',
  `listado_estudiantes` bit(1) DEFAULT b'0',
  `num_estudiantes` int(11) DEFAULT '0',
  `num_acompaniantes` int(11) DEFAULT '0',
  `num_acompaniantes_apoyo` int(11) DEFAULT '0',
  `radicado_financiera` bit(1) DEFAULT b'0',
  `num_radicado_financiera` int(8) DEFAULT '0',
  `fecha_radicado_financiera` date DEFAULT NULL,
  `legalizado_financiera` bit(1) DEFAULT b'0',
  `confirm_transportadora` bit(1) DEFAULT b'0',
  `id_transport_confirm` bigint(20) DEFAULT NULL,
  `lugar_salida` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lugar_regreso` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cronograma` longtext COLLATE utf8mb4_unicode_ci,
  `observaciones` longtext COLLATE utf8mb4_unicode_ci,
  `justificacion` longtext COLLATE utf8mb4_unicode_ci,
  `objetivo_general` longtext COLLATE utf8mb4_unicode_ci,
  `metodologia_evaluacion` longtext COLLATE utf8mb4_unicode_ci,
  `consec_cordis` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `consec_dfamarena` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_solicitud_practica_proyeccion_preliminar_idx` (`id_proyeccion_preliminar`),
  KEY `fk_solicitud_practica_estado_idx` (`id_estado_solicitud_practica`),
  KEY `fk_solicitud_practica_estado_dec_idx` (`aprobacion_decano`),
  KEY `fk_solicitud_practica_estado_coord_idx` (`aprobacion_coordinador`),
  KEY `fk_solicitud_practica_estado_asistD_idx` (`aprobacion_asistD`),
  CONSTRAINT `fk_solicitud_practica_estado` FOREIGN KEY (`id_estado_solicitud_practica`) REFERENCES `estado` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_solicitud_practica_estado_asistD` FOREIGN KEY (`aprobacion_asistD`) REFERENCES `estado` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_solicitud_practica_estado_coord` FOREIGN KEY (`aprobacion_coordinador`) REFERENCES `estado` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_solicitud_practica_estado_dec` FOREIGN KEY (`aprobacion_decano`) REFERENCES `estado` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_solicitud_practica_proyeccion_preliminar` FOREIGN KEY (`id_proyeccion_preliminar`) REFERENCES `proyeccion_preliminar` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `solicitud_practica`
--

LOCK TABLES `solicitud_practica` WRITE;
/*!40000 ALTER TABLE `solicitud_practica` DISABLE KEYS */;
/*!40000 ALTER TABLE `solicitud_practica` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `solicitud_transporte`
--

DROP TABLE IF EXISTS `solicitud_transporte`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `solicitud_transporte` (
  `id` int(11) NOT NULL,
  `nombre_conductor_vehi_1` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nombre_conductor_2_vehi_1` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `celular_conductor_vehi_1` bigint(20) DEFAULT NULL,
  `celular_conductor_2_vehi_1` bigint(20) DEFAULT NULL,
  `email_conductor_vehi_1` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_conductor_2_vehi_1` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `placa_vehi_1` tinytext COLLATE utf8mb4_unicode_ci,
  `nombre_conductor_vehi_2` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nombre_conductor_2_vehi_2` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `celular_conductor_vehi_2` bigint(20) DEFAULT NULL,
  `celular_conductor_2_vehi_2` bigint(20) DEFAULT NULL,
  `email_conductor_vehi_2` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_conductor_2_vehi_2` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `placa_vehi_2` tinytext COLLATE utf8mb4_unicode_ci,
  `nombre_conductor_vehi_3` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nombre_conductor_2_vehi_3` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `celular_conductor_vehi_3` bigint(20) DEFAULT NULL,
  `celular_conductor_2_vehi_3` bigint(20) DEFAULT NULL,
  `email_conductor_vehi_3` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_conductor_2_vehi_3` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `placa_vehi_3` tinytext COLLATE utf8mb4_unicode_ci,
  `diligenciado` bit(1) DEFAULT b'0',
  `fecha_diligenciamiento` date DEFAULT NULL,
  KEY `fk_transporte_solicitud_practica_idx` (`id`),
  CONSTRAINT `fk_solicitud_transporte_solicitud_practica` FOREIGN KEY (`id`) REFERENCES `solicitud_practica` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `solicitud_transporte`
--

LOCK TABLES `solicitud_transporte` WRITE;
/*!40000 ALTER TABLE `solicitud_transporte` DISABLE KEYS */;
/*!40000 ALTER TABLE `solicitud_transporte` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipo_certificacion`
--

DROP TABLE IF EXISTS `tipo_certificacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipo_certificacion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_certificacion` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_certificacion`
--

LOCK TABLES `tipo_certificacion` WRITE;
/*!40000 ALTER TABLE `tipo_certificacion` DISABLE KEYS */;
INSERT INTO `tipo_certificacion` VALUES (1,'Constancia salida'),(2,'Constancia asistencia');
/*!40000 ALTER TABLE `tipo_certificacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipo_documentacion`
--

DROP TABLE IF EXISTS `tipo_documentacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipo_documentacion` (
  `id` int(11) DEFAULT NULL,
  `tipo_documentacion` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `abrev` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `editable` bit(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_documentacion`
--

LOCK TABLES `tipo_documentacion` WRITE;
/*!40000 ALTER TABLE `tipo_documentacion` DISABLE KEYS */;
INSERT INTO `tipo_documentacion` VALUES (3,'Resolución','Res.',''),(1,'Autorización Giro','Auto. Giro.','\0'),(4,'Solicitud avance','Sol. Avan.','\0'),(2,'Oficio','Ofi.',''),(5,'Solicitud Prácticas Académicas','Sol. Prac. Acad.','\0'),(6,'Solicitud Transporte','Sol. Transp.','\0');
/*!40000 ALTER TABLE `tipo_documentacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipo_identificacion`
--

DROP TABLE IF EXISTS `tipo_identificacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipo_identificacion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_identificacion` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sigla` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_identificacion`
--

LOCK TABLES `tipo_identificacion` WRITE;
/*!40000 ALTER TABLE `tipo_identificacion` DISABLE KEYS */;
INSERT INTO `tipo_identificacion` VALUES (1,'Cédula de Ciudadanía','C.C'),(2,'Cédula de Extranjería','C.E'),(3,'Pasaporte','PAS');
/*!40000 ALTER TABLE `tipo_identificacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipo_transporte`
--

DROP TABLE IF EXISTS `tipo_transporte`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipo_transporte` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_transporte` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_transporte`
--

LOCK TABLES `tipo_transporte` WRITE;
/*!40000 ALTER TABLE `tipo_transporte` DISABLE KEYS */;
INSERT INTO `tipo_transporte` VALUES (1,'Bus'),(2,'Buseta'),(3,'Colectivo'),(4,'Camioneta');
/*!40000 ALTER TABLE `tipo_transporte` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipo_vinculacion`
--

DROP TABLE IF EXISTS `tipo_vinculacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipo_vinculacion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_vinculacion` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_vinculacion`
--

LOCK TABLES `tipo_vinculacion` WRITE;
/*!40000 ALTER TABLE `tipo_vinculacion` DISABLE KEYS */;
INSERT INTO `tipo_vinculacion` VALUES (1,'(Hora cátedra) Docente de vinculación especial'),(2,'(Hora cátedra por honorarios) Docente de vinculación especial'),(3,'(Medio tiempo completo ocasional) Docente de vinculación especial'),(4,'(Tiempo completo ocasional) Docente de vinculación especial'),(5,'(Planta) Docente de carrera'),(6,'Transportador'),(7,'Administrador');
/*!40000 ALTER TABLE `tipo_vinculacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipo_zona_transitar`
--

DROP TABLE IF EXISTS `tipo_zona_transitar`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipo_zona_transitar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_zona` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_zona_transitar`
--

LOCK TABLES `tipo_zona_transitar` WRITE;
/*!40000 ALTER TABLE `tipo_zona_transitar` DISABLE KEYS */;
INSERT INTO `tipo_zona_transitar` VALUES (1,'Rural'),(2,'Urbana'),(3,'Rural - Urbana');
/*!40000 ALTER TABLE `tipo_zona_transitar` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transporte_menor`
--

DROP TABLE IF EXISTS `transporte_menor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transporte_menor` (
  `id` int(11) NOT NULL,
  `cant_trans_menor_rp` int(11) NOT NULL DEFAULT '0',
  `cant_trans_menor_ra` int(11) NOT NULL DEFAULT '0',
  `docente_resp_t_menor_rp` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `docente_resp_t_menor_ra` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `trans_menor_rp_1` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `trans_menor_rp_2` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `trans_menor_rp_3` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `trans_menor_rp_4` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `trans_menor_ra_1` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `trans_menor_ra_2` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `trans_menor_ra_3` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `trans_menor_ra_4` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `vlr_trans_menor_rp_1` bigint(20) DEFAULT NULL,
  `vlr_trans_menor_rp_2` bigint(20) DEFAULT NULL,
  `vlr_trans_menor_rp_3` bigint(20) DEFAULT NULL,
  `vlr_trans_menor_rp_4` bigint(20) DEFAULT NULL,
  `vlr_trans_menor_ra_1` bigint(20) DEFAULT NULL,
  `vlr_trans_menor_ra_2` bigint(20) DEFAULT NULL,
  `vlr_trans_menor_ra_3` bigint(20) DEFAULT NULL,
  `vlr_trans_menor_ra_4` bigint(20) DEFAULT NULL,
  KEY `fk_transporte_menor_solicitud_practica` (`id`),
  CONSTRAINT `fk_transporte_menor_solicitud_practica` FOREIGN KEY (`id`) REFERENCES `proyeccion_preliminar` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transporte_menor`
--

LOCK TABLES `transporte_menor` WRITE;
/*!40000 ALTER TABLE `transporte_menor` DISABLE KEYS */;
/*!40000 ALTER TABLE `transporte_menor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transporte_proyeccion`
--

DROP TABLE IF EXISTS `transporte_proyeccion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transporte_proyeccion` (
  `id` int(11) NOT NULL,
  `cant_transporte_rp` int(11) DEFAULT NULL,
  `cant_transporte_ra` int(11) DEFAULT NULL,
  `id_tipo_transporte_rp_1` int(11) NOT NULL,
  `id_tipo_transporte_rp_2` int(11) DEFAULT '0',
  `id_tipo_transporte_rp_3` int(11) DEFAULT '0',
  `id_tipo_transporte_ra_1` int(11) DEFAULT NULL,
  `id_tipo_transporte_ra_2` int(11) DEFAULT '0',
  `id_tipo_transporte_ra_3` int(11) DEFAULT '0',
  `det_tipo_transporte_rp_1` longtext COLLATE utf8mb4_unicode_ci,
  `det_tipo_transporte_rp_2` longtext COLLATE utf8mb4_unicode_ci,
  `det_tipo_transporte_rp_3` longtext COLLATE utf8mb4_unicode_ci,
  `det_tipo_transporte_ra_1` longtext COLLATE utf8mb4_unicode_ci,
  `det_tipo_transporte_ra_2` longtext COLLATE utf8mb4_unicode_ci,
  `det_tipo_transporte_ra_3` longtext COLLATE utf8mb4_unicode_ci,
  `docen_respo_trasnporte_rp` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `docen_respo_trasnporte_ra` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `capac_transporte_rp_1` int(11) DEFAULT NULL,
  `capac_transporte_rp_2` int(11) DEFAULT NULL,
  `capac_transporte_rp_3` int(11) DEFAULT NULL,
  `capac_transporte_ra_1` int(11) DEFAULT NULL,
  `capac_transporte_ra_2` int(11) DEFAULT NULL,
  `capac_transporte_ra_3` int(11) DEFAULT NULL,
  `exclusiv_tiempo_rp_1` bit(1) DEFAULT NULL,
  `exclusiv_tiempo_rp_2` bit(1) DEFAULT NULL,
  `exclusiv_tiempo_rp_3` bit(1) DEFAULT NULL,
  `exclusiv_tiempo_ra_1` bit(1) DEFAULT NULL,
  `exclusiv_tiempo_ra_2` bit(1) DEFAULT NULL,
  `exclusiv_tiempo_ra_3` bit(1) DEFAULT NULL,
  KEY `fk_transporte_proyeccion_preliminar_idx` (`id`),
  KEY `fk_transporte_tipo_transporte_rp_1_idx` (`id_tipo_transporte_rp_1`),
  KEY `fk_transporte_tipo_transporte_ra_1_idx` (`id_tipo_transporte_ra_1`),
  KEY `fk_transporte_tipo_transporte_rp_2_idx` (`id_tipo_transporte_rp_2`),
  KEY `fk_transporte_tipo_transporte_rp_3_idx` (`id_tipo_transporte_rp_3`),
  KEY `fk_transporte_tipo_transporte_ra_2_idx` (`id_tipo_transporte_ra_2`),
  KEY `fk_transporte_tipo_transporte_ra_3_idx` (`id_tipo_transporte_ra_3`),
  CONSTRAINT `fk_transporte_proyeccion_preliminar` FOREIGN KEY (`id`) REFERENCES `proyeccion_preliminar` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_transporte_tipo_transporte_ra_1` FOREIGN KEY (`id_tipo_transporte_ra_1`) REFERENCES `tipo_transporte` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_transporte_tipo_transporte_ra_2` FOREIGN KEY (`id_tipo_transporte_ra_2`) REFERENCES `tipo_transporte` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_transporte_tipo_transporte_ra_3` FOREIGN KEY (`id_tipo_transporte_ra_3`) REFERENCES `tipo_transporte` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_transporte_tipo_transporte_rp_1` FOREIGN KEY (`id_tipo_transporte_rp_1`) REFERENCES `tipo_transporte` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_transporte_tipo_transporte_rp_2` FOREIGN KEY (`id_tipo_transporte_rp_2`) REFERENCES `tipo_transporte` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_transporte_tipo_transporte_rp_3` FOREIGN KEY (`id_tipo_transporte_rp_3`) REFERENCES `tipo_transporte` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transporte_proyeccion`
--

LOCK TABLES `transporte_proyeccion` WRITE;
/*!40000 ALTER TABLE `transporte_proyeccion` DISABLE KEYS */;
/*!40000 ALTER TABLE `transporte_proyeccion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) NOT NULL,
  `id_role` int(11) NOT NULL,
  `id_tipo_identificacion` int(11) NOT NULL,
  `id_tipo_vinculacion` int(11) NOT NULL,
  `id_estado` int(11) NOT NULL,
  `cant_espacio_academico` int(11) NOT NULL,
  `id_espacio_academico_1` int(11) NOT NULL,
  `id_espacio_academico_2` int(11) DEFAULT NULL,
  `id_espacio_academico_3` int(11) DEFAULT NULL,
  `id_espacio_academico_4` int(11) DEFAULT NULL,
  `id_espacio_academico_5` int(11) DEFAULT NULL,
  `id_espacio_academico_6` int(11) DEFAULT NULL,
  `id_programa_academico_coord` int(11) DEFAULT NULL,
  `usuario` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expedicion_identificacion` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `primer_nombre` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `segundo_nombre` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `primer_apellido` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `segundo_apellido` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `celular` bigint(20) NOT NULL,
  `telefono` bigint(20) DEFAULT NULL,
  `email` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `firma_litografica` longtext COLLATE utf8mb4_unicode_ci,
  `tiene_firma` bit(1) DEFAULT b'0',
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `usuario` (`usuario`),
  UNIQUE KEY `id` (`id`),
  KEY `fk_users_roles_idx` (`id_role`),
  KEY `fk_users_tipo_identificacion_idx` (`id_tipo_identificacion`),
  KEY `fk_users_espacio_academico_1_idx` (`id_espacio_academico_1`),
  KEY `fk_users_espacio_academico_2_idx` (`id_espacio_academico_2`),
  KEY `fk_users_espacio_academico_3_idx` (`id_espacio_academico_3`),
  KEY `fk_users_espacio_academico_4_idx` (`id_espacio_academico_4`),
  KEY `fk_users_espacio_academico_5_idx` (`id_espacio_academico_5`),
  KEY `fk_users_espacio_academico_6_idx` (`id_espacio_academico_6`),
  KEY `fk_users_estado` (`id_estado`),
  KEY `fk_users_tipo_vinculacion_idx` (`id_tipo_vinculacion`),
  KEY `fk_users_programa_academico_idx` (`id_programa_academico_coord`),
  CONSTRAINT `fk_users_espacio_academico_1` FOREIGN KEY (`id_espacio_academico_1`) REFERENCES `espacio_academico` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_users_espacio_academico_2` FOREIGN KEY (`id_espacio_academico_2`) REFERENCES `espacio_academico` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `fk_users_espacio_academico_3` FOREIGN KEY (`id_espacio_academico_3`) REFERENCES `espacio_academico` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `fk_users_espacio_academico_4` FOREIGN KEY (`id_espacio_academico_4`) REFERENCES `espacio_academico` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `fk_users_espacio_academico_5` FOREIGN KEY (`id_espacio_academico_5`) REFERENCES `espacio_academico` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `fk_users_espacio_academico_6` FOREIGN KEY (`id_espacio_academico_6`) REFERENCES `espacio_academico` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `fk_users_estado` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_users_programa_academico` FOREIGN KEY (`id_programa_academico_coord`) REFERENCES `programa_academico` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_users_roles` FOREIGN KEY (`id_role`) REFERENCES `roles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_users_tipo_identificacion` FOREIGN KEY (`id_tipo_identificacion`) REFERENCES `tipo_identificacion` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_users_tipo_vinculacion` FOREIGN KEY (`id_tipo_vinculacion`) REFERENCES `tipo_vinculacion` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (79794356,2,1,5,1,1,999,NULL,NULL,NULL,NULL,NULL,999,'dmedioa','Bogotá D.C','Jaime','Eddy','Ussa','Garzón',3103451502,2841658,'dmedioa@udistrital.edu.co',NULL,'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','','$2y$10$RsP2c8fICXVn0SnxrugDOuwOhjTXKJdAcCk89pwACiQLKbgildFku',NULL,'2020-02-16 23:44:20','2021-07-29 05:00:00'),(659863256,3,1,5,1,1,999,NULL,NULL,NULL,NULL,NULL,999,'arojasc','Bogotá D.C','Alejandro',NULL,'Rojas','Castro',32569874536,5632121,'arojasc@udistrital.edu.co',NULL,'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','\0','$2y$10$DN4qfMqnvr0cbaNPHOpjpudtJ3Z8TlHPHNtDl.6CfzZ9wPOBiozcO',NULL,'2020-02-16 23:40:10','2021-07-28 05:00:00'),(1038410523,1,1,7,1,1,999,NULL,NULL,NULL,NULL,NULL,999,'practicampo','Bogotá D.C','Laura','Vanessa','Giraldo','Salazar',3107964434,6267500,'practicampo@udistrital.edu.co',NULL,NULL,'\0','$2y$10$V/4DkEVqMJNNXiHyUY42sOqTSRHtfhJAoOViAeoVxzbFwvj72ELg.',NULL,'2020-02-16 23:34:35','2021-07-28 05:00:00');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-08-17 11:39:33
