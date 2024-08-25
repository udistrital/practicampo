CREATE TABLE IF NOT EXISTS `categoria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categoria` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla practicampo.categoria: ~13 rows (aproximadamente)
/*!40000 ALTER TABLE `categoria` DISABLE KEYS */;
REPLACE INTO `categoria` (`id`, `categoria`) VALUES
	(1, 'PROFESOR ASISTENTE'),
	(2, 'PROFESOR ASISTENTE COMPLETO'),
	(3, 'PROFESOR ASOCIADO'),
	(4, 'PROFESOR ASOCIADO COMPLETO'),
	(5, 'PROFESOR AUXILIAR'),
	(6, 'PROFESOR AUXILIAR COMPLETO'),
	(7, 'PROFESOR TITULAR'),
	(8, 'PROFESOR TITULAR COMPLETO'),
	(9, 'TITULAR XIII'),
	(10, 'TITULAR XVII'),
	(11, 'TITULAR XVIII'),
	(12, 'TITULAR XIX'),
	(13, 'TITULAR XXII');
	
CREATE TABLE IF NOT EXISTS `espacio_academico` (
  `id` int(11) NOT NULL,
  `id_programa_academico` int(11) NOT NULL,
  `codigo_espacio_academico` int(11) NOT NULL,
  `espacio_academico` varchar(90) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `plan_estudios_1` int(11) DEFAULT '0',
  `plan_estudios_2` int(11) DEFAULT '0',
  `tipo_espacio` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_programa_academico_espacio_academico` (`id_programa_academico`),
  CONSTRAINT `fk_programa_academico_espacio_academico` FOREIGN KEY (`id_programa_academico`) REFERENCES `programa_academico` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;	

REPLACE INTO `espacio_academico` (`id`, `id_programa_academico`, `codigo_espacio_academico`, `espacio_academico`, `plan_estudios_1`, `plan_estudios_2`, `tipo_espacio`) VALUES
	(1, 81, 2346, 'Gestión comercial', 344, 244, 'Teórico-Práctica'),
	(2, 81, 2328, 'Cuencas', 344, NULL, 'Teórico-Práctica'),
	(3, 81, 2324, 'Residuos líquidos ', 344, 244, 'Teórico-Práctica'),
	(4, 81, 2334, 'Operación de plantas y estaciones de bombeo', 344, 244, 'Teórico-Práctica'),
	(5, 81, 2323, 'Gestión ambiental II', 344, NULL, 'Teórico-Práctica'),
	(6, 81, 2312, 'Ecología', 344, 244, 'Teórico-Práctica'),
	(7, 81, 2319, 'Calidad del agua ', 344, 244, 'Teórico-Práctica'),
	(8, 81, 2331, 'Residuos sólidos', 344, 244, 'Teórico-Práctica'),
	(9, 81, 2327, 'Gestión ambiental I', 344, NULL, 'Teórico-Práctica'),
	(10, 81, 2325, 'Administración ambiental y desarrollo local', 344, 244, 'Teórico-Práctica'),
	(11, 81, 2341, 'Servicio público de energía', 344, 244, 'Teórico-Práctica'),
	(12, 181, 2112, 'Fundamentos de química', 349, 249, 'Teórico-Práctica'),
	(13, 181, 11809, 'Química sanitaria', 349, 249, 'Teórico-Práctica'),
	(14, 181, 11811, 'Procesos unitarios I', 349, 249, 'Teórico-Práctica'),
	(15, 181, 11802, 'Ecología humana', 349, 249, 'Teórico-Práctica'),
	(16, 181, 2509, 'Sociedad y ambiente', 349, 249, 'Teórico-Práctica'),
	(17, 181, 11817, 'Plantas de tratamiento para agua potable', 349, 249, 'Teórico-Práctica'),
	(18, 181, 11820, 'Plantas de tratamiento para agua residual', 349, 249, 'Teórico-Práctica'),
	(19, 181, 2531, 'Emisiones atmosféricas', 349, 249, 'Teórico-Práctica'),
	(20, 181, 11812, 'Calidad del aire', 349, 249, 'Teórico-Práctica'),
	(21, 181, 11814, 'Tratamiento y disposición de residuos sólidos', 349, 249, 'Teórico-Práctica'),
	(22, 181, 11821, 'Salida integrada', 349, 249, 'Teórico-Práctica'),
	(23, 181, 11804, 'Zoonosis y epidemiología', 349, 249, 'Teórico-Práctica'),
	(24, 181, 11836, 'Elementos de planificación territorial', 349, 249, 'Teórico-Práctica'),
	(25, 181, 2539, 'Saneamiento urbano y rural', 349, 249, 'Teórico-Práctica'),
	(26, 181, 11816, 'Política sanitaria', 349, 249, 'Teórico-Práctica'),
	(27, 181, 11810, 'Acueductos', 349, 249, 'Teórico-Práctica'),
	(28, 181, 2027, 'Fundamentos de ecología', 349, 249, 'Teórico-Práctica'),
	(29, 10, 2137, 'Práctica integrada I', 342, 242, 'Teórico-Práctica'),
	(30, 10, 2166, 'Evaluación ambiental', 342, 242, 'Teórico-Práctica'),
	(31, 10, 2162, 'Silvicultura comunitaria', 342, 242, 'Teórico-Práctica'),
	(32, 10, 2119, 'Geología y geomorfología', 342, 242, 'Teórico-Práctica'),
	(33, 10, 2160, 'Ordenamiento territorial', 342, 242, 'Teórico-Práctica'),
	(34, 10, 2113, 'Introducción a la ingeniería forestal', 342, 242, 'Teórico-Práctica'),
	(35, 10, 2126, 'Percepción remota e interpretación de imágenes', 342, 242, 'Teórico-Práctica'),
	(36, 10, 2175, 'Áreas protegidas', 342, 242, 'Teórico-Práctica'),
	(37, 10, 2109, 'Micorrizas', 342, 242, 'Teórico-Práctica'),
	(38, 10, 2127, 'Suelos I', 342, 242, 'Teórico-Práctica'),
	(39, 10, 2132, 'Dendrología II', 342, 242, 'Teórico-Práctica'),
	(40, 10, 2163, 'Silvicultura de bosques naturales', 342, 242, 'Teórico-Práctica'),
	(41, 10, 2117, 'Fertilización y fertilizantes', 342, 242, 'Teórico-Práctica'),
	(42, 10, 2128, 'Química de productos forestales', 342, 242, 'Teórico-Práctica'),
	(43, 10, 2148, 'Aprovechamiento forestal', 342, 242, 'Teórico-Práctica'),
	(44, 10, 2116, 'Sistemas agroforestales', 342, 242, 'Teórico-Práctica'),
	(45, 10, 2161, 'Estructuras de la madera', 342, 242, 'Teórico-Práctica'),
	(46, 10, 2124, 'Dendrología I', 342, 242, 'Teórico-Práctica'),
	(47, 10, 2179, 'Práctica integrada III', 342, 242, 'Teórico-Práctica'),
	(48, 10, 2152, 'Modelamiento de fenómenos biológicos', 342, 242, 'Teórico-Práctica'),
	(49, 10, 2170, 'Biología de la conservación', 342, 242, 'Teórico-Práctica'),
	(50, 10, 2177, 'Gestión del riesgo', 342, 242, 'Teórico-Práctica'),
	(51, 10, 2111, 'Biología general', 342, 242, 'Teórico-Práctica'),
	(52, 10, 2154, 'Propiedades de la madera', 342, 242, 'Teórico-Práctica'),
	(53, 10, 2115, 'Botánica taxonómica', 342, 242, 'Teórico-Práctica'),
	(54, 10, 2156, 'Extensión forestal', 342, 242, 'Teórico-Práctica'),
	(55, 10, 2134, 'Fisiología forestal', 342, 242, 'Teórico-Práctica'),
	(56, 10, 2147, 'Conservación de suelos', 342, 242, 'Teórico-Práctica'),
	(57, 10, 2155, 'Fitomejoramiento', 342, 242, 'Teórico-Práctica'),
	(58, 10, 2173, 'Ordenación de bosques', 342, 242, 'Teórico-Práctica'),
	(59, 10, 2130, 'Ecología forestal avanzada', 342, 242, 'Teórico-Práctica'),
	(60, 10, 2146, 'Sanidad forestal', 342, 242, 'Teórico-Práctica'),
	(61, 10, 2139, 'Hidrología', 342, 242, 'Teórico-Práctica'),
	(62, 10, 2165, 'Ingeniería del riego', 342, 242, 'Teórico-Práctica'),
	(63, 10, 2133, 'Suelos II', 342, 242, 'Teórico-Práctica'),
	(64, 10, 2167, 'Industrias forestales I', 342, 242, 'Teórico-Práctica'),
	(65, 10, 2138, 'Mediciones forestales', 342, 242, 'Teórico-Práctica'),
	(66, 10, 2149, 'Silvicultura de plantaciones', 342, 242, 'Teórico-Práctica'),
	(67, 10, 2174, 'Industrias forestales II', 342, 242, 'Teórico-Práctica'),
	(69, 10, 2159, 'Práctica integrada II', 342, 242, 'Teórico-Práctica'),
	(70, 10, 2153, 'Cuencas hidrográficas', 342, 242, 'Teórico-Práctica'),
	(71, 10, 2158, 'Desarrollo y medio ambiente', 342, 242, 'Teórico-Práctica'),
	(74, 32, 2043, 'Topografía automatizada', 341, 241, 'Teórico-Práctica'),
	(75, 32, 2042, 'Tránsito y transportes ', 341, 241, 'Teórico-Práctica'),
	(76, 32, 2005, 'Planimetría', 341, 241, 'Teórico-Práctica'),
	(77, 32, 2031, 'Mecánica de suelos', 341, 241, 'Teórico-Práctica'),
	(78, 32, 2044, 'Pavimentos', 341, 241, 'Teórico-Práctica'),
	(79, 32, 2025, 'Geología y geomorfología', 341, 241, 'Teórico-Práctica'),
	(80, 32, 2045, 'Análisis y gestión del riesgo', 341, 241, 'Teórico-Práctica'),
	(81, 32, 2041, 'Levantamientos especiales', 341, 241, 'Teórico-Práctica'),
	(82, 31, 2238, 'Cartografía digital ', 243, NULL, 'Teórico-Práctica'),
	(83, 31, 19604, 'Levantamientos altimétricos', NULL, NULL, 'Teórico-Práctica'),
	(84, 31, 19606, 'Topografía de vías', NULL, NULL, 'Teórico-Práctica'),
	(85, 31, 2228, 'Localización de vías', 243, NULL, 'Teórico-Práctica'),
	(86, 31, 2249, 'Arqueoastronomía', 243, NULL, 'Teórico-Práctica'),
	(87, 31, 2232, 'Fotogrametría y fotointerpretación', 243, NULL, 'Teórico-Práctica'),
	(88, 31, 2245, 'Geodesia posicional', 243, NULL, 'Teórico-Práctica'),
	(89, 31, 2251, 'Uso del vehículo aéreo no tripulado-vant en la ingeniería', 243, NULL, 'Teórico-Práctica'),
	(90, 31, 2221, 'Diseño geométrico de vías', 243, NULL, 'Teórico-Práctica'),
	(91, 31, 19601, 'Levantamientos planimétricos', NULL, NULL, 'Teórico-Práctica'),
	(92, 180, 2703, 'Introducción a la ingeniería ambiental', 347, 247, 'Teórico-Práctica'),
	(93, 180, 2716, 'Geología y geomorfología', 347, 247, 'Teórico-Práctica'),
	(94, 180, 2720, 'Suelos', 347, 247, 'Teórico-Práctica'),
	(95, 180, 2724, 'Química ambiental aplicada', 347, 247, 'Teórico-Práctica'),
	(96, 180, 2727, 'Ecología analítica', 347, 247, 'Teórico-Práctica'),
	(97, 180, 2728, 'Contaminación ambiental I', 347, 247, 'Teórico-Práctica'),
	(98, 180, 2729, 'Hidráulica', 347, 247, 'Teórico-Práctica'),
	(99, 180, 2733, 'Ordenamiento territorial rural', 347, 247, 'Teórico-Práctica'),
	(100, 180, 2734, 'Contaminación ambiental II', 347, 247, 'Teórico-Práctica'),
	(101, 180, 2735, 'Tecnologías apropiadas I', 347, 247, 'Teórico-Práctica'),
	(102, 180, 2736, 'Hidrogeología', 347, 247, 'Teórico-Práctica'),
	(103, 180, 2739, 'Tecnologías apropiadas II', 347, 247, 'Teórico-Práctica'),
	(104, 180, 2746, 'Evaluación ambiental II', 347, 247, 'Teórico-Práctica'),
	(105, 180, 2742, 'Evaluación ambiental I', 347, 247, 'Teórico-Práctica'),
	(106, 180, 2743, 'Manejo técnico ambiental', 347, 247, 'Teórico-Práctica'),
	(107, 180, 2730, 'Fisicoquímica de fluidos', 347, 247, 'Teórico-Práctica'),
	(108, 180, 2726, 'Hidrología', 347, 247, 'Teórico-Práctica'),
	(109, 85, 2525, 'Tratamiento de agua para consumo humano', 246, NULL, 'Teórico-Práctica'),
	(110, 85, 2526, 'Residuos líquidos', 246, NULL, 'Teórico-Práctica'),
	(111, 85, 2503, 'Introducción al saneamiento ambiental', 246, NULL, 'Teórico-Práctica'),
	(112, 85, 2507, 'Topografía', 246, NULL, 'Teórico-Práctica'),
	(113, 85, 2524, 'Fundamentos acueductos y alcantarillados', 246, NULL, 'Teórico-Práctica'),
	(114, 85, 2519, 'Calidad del agua ', 246, NULL, 'Teórico-Práctica'),
	(115, 85, 2520, 'Zoonosis', 246, NULL, 'Teórico-Práctica'),
	(116, 85, 2528, 'Organización comunitaria', 246, NULL, 'Teórico-Práctica'),
	(117, 85, 2534, 'Administración municipal', 246, NULL, 'Teórico-Práctica'),
	(118, 85, 2532, 'Residuos Sólidos', 246, NULL, 'Teórico-Práctica'),
	(119, 85, 2027, 'Fundamentos de ecología', 246, NULL, 'Teórico-Práctica'),
	(120, 85, 2509, 'Sociedad y ambiente', 246, NULL, 'Teórico-Práctica'),
	(121, 85, 2506, 'Hidráulica', 246, NULL, 'Teórico-Práctica'),
	(122, 85, 2543, 'Salida integrada', 246, NULL, 'Teórico-Práctica'),
	(123, 85, 2539, 'Saneamiento urbano y rural', 246, NULL, 'Teórico-Práctica'),
	(124, 1, 7019, 'Deporte formativo', 348, 248, 'Teórico-Práctica'),
	(125, 1, 7021, 'Desarrollo organizacional', 348, 248, 'Teórico-Práctica'),
	(126, 1, 7032, 'Recreación', 348, 248, 'Teórico-Práctica'),
	(127, 1, 7046, 'Deporte de alto rendimiento', 348, 248, 'Teórico-Práctica'),
	(128, 1, 7050, 'Escenarios y entornos deportivos', 348, 248, 'Teórico-Práctica'),
	(129, 185, 2443, 'Administración de recursos naturales ', 345, 245, 'Teórico-Práctica'),
	(130, 185, 2429, 'Factores de riesgo ambiental en salud pública', 345, 245, 'Teórico-Práctica'),
	(131, 185, 2418, 'Problemas y alternativas ambientales', 345, 245, 'Teórico-Práctica'),
	(132, 185, 2408, 'Sociedad y ambiente', 345, 245, 'Teórico-Práctica'),
	(133, 185, 2439, 'Planificación ambiental territorial ', 245, NULL, 'Teórico-Práctica'),
	(134, 185, 19101, 'Planificación ambiental territorial ', 345, NULL, 'Teórico-Práctica'),
	(135, 185, 2434, 'Vulnerabilidad y riesgos ', 345, 245, 'Teórico-Práctica'),
	(136, 185, 2403, 'Introducción a la administración ambiental', 345, 245, 'Teórico-Práctica'),
	(137, 185, 2413, 'Organización comunitaria', 345, 245, 'Teórico-Práctica'),
	(999, 999, 0, 'N/A', 0, 0, 'N/A');
	
CREATE TABLE IF NOT EXISTS `estado` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `estado` varchar(50) NOT NULL,
  `abrev` varchar(6) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

REPLACE INTO `estado` (`id`, `estado`, `abrev`) VALUES
	(1, 'Activo', 'Act.'),
	(2, 'Inactivo', 'Inact.'),
	(3, 'Aprobado', 'Aprob.'),
	(4, 'Desaprobado', 'Desap.'),
	(5, 'Pendiente', 'Pend.');
	
CREATE TABLE IF NOT EXISTS `estudiantes_solicitud_practica` (
  `id` int(11) NOT NULL DEFAULT '0',
  `num_identificacion` bigint(20) NOT NULL,
  `cod_estudiantil` bigint(20) NOT NULL,
  `id_tipo_identificacion` int(11) NOT NULL DEFAULT '0',
  `id_solicitud_practica` int(11) NOT NULL DEFAULT '0',
  `nombres` varchar(50) NOT NULL DEFAULT '0',
  `apellidos` varchar(50) NOT NULL DEFAULT '0',
  `fecha_nacimiento` date NOT NULL,
  `eps` varchar(50) NOT NULL DEFAULT '0',
  `email` varchar(255) NOT NULL DEFAULT '0',
  `aprob_terminos_condiciones` bit(1) NOT NULL DEFAULT b'0',
  `verificacion_asistencia` bit(1) NOT NULL DEFAULT b'0',
  `permiso_padres` blob NOT NULL,
  `seguro_estudiantil` blob NOT NULL,
  `documento_adicional_1` blob NOT NULL,
  `documento_adicional_2` blob NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_estudiantes_solicitud_practica_tipo_identificacion_idx` (`id_tipo_identificacion`),
  KEY `fk_estudiantes_solicitud_practica_solicitud_practica_idx` (`id_solicitud_practica`),
  CONSTRAINT `fk_estudiantes_solicitud_practica_solicitud_practica` FOREIGN KEY (`id_solicitud_practica`) REFERENCES `solicitud_practica` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_estudiantes_solicitud_practica_tipo_identificacion` FOREIGN KEY (`id_tipo_identificacion`) REFERENCES `tipo_identificacion` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `herramientas_equipos_practica` (
  `id` int(11) NOT NULL,
  `nombre_elemento` varchar(50) NOT NULL DEFAULT '',
  `id_solicitud_practica` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_herramientas_equipos_solicitud_practica_idx` (`id_solicitud_practica`),
  CONSTRAINT `fk_herramientas_equipos_solicitud_practica` FOREIGN KEY (`id_solicitud_practica`) REFERENCES `solicitud_practica` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

REPLACE INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_000000_create_users_table', 1),
	(2, '2014_10_12_100000_create_password_resets_table', 1);
	
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `periodo_academico` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `periodo_academico` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

REPLACE INTO `periodo_academico` (`id`, `periodo_academico`) VALUES
	(1, 'I'),
	(2, 'II'),
	(3, 'III');
	
CREATE TABLE IF NOT EXISTS `programa_academico` (
  `id` int(11) NOT NULL,
  `programa_academico` varchar(70) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

REPLACE INTO `programa_academico` (`id`, `programa_academico`) VALUES
	(1, 'Administración deportiva'),
	(10, 'Ingeniería forestal'),
	(31, 'Tecnología en levantamientos topográficos'),
	(32, 'Ingeniería topográfica'),
	(81, 'Tecnología en gestión ambiental'),
	(85, 'Tecnología en saneamiento ambiental'),
	(180, 'Ingeniería ambiental'),
	(181, 'Ingeniería sanitaria'),
	(185, 'Administración ambiental'),
	(999, 'N/A');
	
CREATE TABLE IF NOT EXISTS `proyeccion_preliminar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_tipo_transporte_rp_1` int(11) DEFAULT NULL,
  `id_tipo_transporte_rp_2` int(11) DEFAULT NULL,
  `id_tipo_transporte_rp_3` int(11) DEFAULT NULL,
  `id_tipo_transporte_ra_1` int(11) DEFAULT NULL,
  `id_tipo_transporte_ra_2` int(11) DEFAULT NULL,
  `id_tipo_transporte_ra_3` int(11) DEFAULT NULL,
  `id_programa_academico` int(11) DEFAULT NULL,
  `id_docente_responsable` bigint(20) DEFAULT NULL,
  `id_espacio_academico` int(11) DEFAULT NULL,
  `id_peridodo_academico` int(11) DEFAULT NULL,
  `id_semestre_asignatura` int(11) DEFAULT NULL,
  `id_tipo_zona_transitar` int(11) DEFAULT NULL,
  `ruta_principal` blob(8000) DEFAULT NULL,
  `destino_rp` varchar(255) DEFAULT NULL,
  `ruta_alterna` blob(8000) DEFAULT NULL,
  `destino_ra` varchar(255) DEFAULT NULL,
  `lugar_salida_rp` blob(8000) DEFAULT NULL,
  `lugar_salida_ra` blob(8000) DEFAULT NULL,
  `lugar_regreso_rp` blob,
  `lugar_regreso_ra` blob,
  `fecha_salida_aprox_rp` date DEFAULT NULL,
  `fecha_salida_aprox_ra` date NOT NULL,
  `fecha_regreso_aprox_rp` date DEFAULT NULL,
  `fecha_regreso_aprox_ra` date DEFAULT NULL,
  `num_estudiantes_aprox` int(11) DEFAULT NULL,
  `num_acompaniantes` int(11) DEFAULT NULL,
  `observ_coordinador` blob(8000) DEFAULT NULL,
  `observ_decano` blob(8000) DEFAULT NULL,
  `det_recorrido_interno_rp` blob(8000) DEFAULT NULL,
  `det_recorrido_interno_ra` blob(8000) DEFAULT NULL,
  `det_tipo_transporte_rp_1` varchar(50) DEFAULT NULL,
  `otro_tipo_transporte_ra_1` varchar(50) DEFAULT NULL,
  `otro_tipo_transporte_ra_2` varchar(50) DEFAULT NULL,
  `otro_tipo_transporte_ra_3` varchar(50) DEFAULT NULL,
  `otro_tipo_transporte_rp_1` varchar(50) DEFAULT NULL,
  `otro_tipo_transporte_rp_2` varchar(50) DEFAULT NULL,
  `otro_tipo_transporte_rp_3` varchar(50) DEFAULT NULL,
  `det_tipo_transporte_rp_2` varchar(50) DEFAULT NULL,
  `det_tipo_transporte_rp_3` varchar(50) DEFAULT NULL,
  `det_tipo_transporte_ra_1` varchar(50) DEFAULT NULL,
  `det_tipo_transporte_ra_2` varchar(50) DEFAULT NULL,
  `det_tipo_transporte_ra_3` varchar(50) DEFAULT NULL,
  `num_paradas_trayecto` int(11) DEFAULT NULL,
  `cantidad_grupos` int(11) DEFAULT NULL,
  `grupo_1` int(11) DEFAULT NULL,
  `grupo_2` int(11) DEFAULT NULL,
  `grupo_3` int(11) DEFAULT NULL,
  `grupo_4` int(11) DEFAULT NULL,
  `duracion_num_dias_rp` int(11) DEFAULT NULL,
  `duracion_num_dias_ra` int(11) DEFAULT NULL,
  `viaticos_estudiantes` int(11) DEFAULT NULL,
  `viaticos_docente` int(11) DEFAULT NULL,
  `costo_total_transporte` int(11) DEFAULT NULL,
  `cant_transporte_rp` int(11) DEFAULT NULL,
  `cant_transporte_ra` int(11) DEFAULT NULL,
  `capac_transporte_rp_1` int(11) DEFAULT NULL,
  `capac_transporte_rp_2` int(11) DEFAULT NULL,
  `capac_transporte_rp_3` int(11) DEFAULT NULL,
  `capac_transporte_ra_1` int(11) DEFAULT NULL,
  `capac_transporte_ra_2` int(11) DEFAULT NULL,
  `capac_transporte_ra_3` int(11) DEFAULT NULL,
  `exclusiv_tiempo_rp_1` tinyint(1) DEFAULT NULL,
  `exclusiv_tiempo_rp_2` tinyint(1) DEFAULT NULL,
  `exclusiv_tiempo_rp_3` tinyint(1) DEFAULT NULL,
  `exclusiv_tiempo_ra_1` tinyint(1) DEFAULT NULL,
  `exclusiv_tiempo_ra_2` tinyint(1) DEFAULT NULL,
  `exclusiv_tiempo_ra_3` tinyint(4) DEFAULT NULL,
  `aprobacion_coordinador` int(11) DEFAULT NULL,
  `aprobacion_decano` int(11) DEFAULT NULL,
  `fecha_diligenciamiento` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_proyeccion_preliminar_users_idx` (`id_docente_responsable`),
  KEY `fk_proyeccion_preliminar_espacio_academico_idx` (`id_espacio_academico`),
  KEY `fk_proyeccion_preliminar_tipo_transporte_idx` (`id_tipo_transporte_rp_1`),
  KEY `fk_proyeccion_preliminar_periodo_academico_idx` (`id_peridodo_academico`),
  KEY `fk_proyeccion_preliminar_semestre_asignatura_idx` (`id_semestre_asignatura`),
  KEY `fk_proyeccion_preliminar_tipo_zona_transitar_idx` (`id_tipo_zona_transitar`),
  KEY `fk_proyeccion_preliminar_estado_coord_idx` (`aprobacion_coordinador`),
  KEY `fk_proyeccion_preliminar_estado_dec_idx` (`aprobacion_decano`),
  KEY `fk_proyeccion_preliminar_programa_academico_idx` (`id_programa_academico`),
  CONSTRAINT `fk_proyeccion_preliminar_espacio_academico` FOREIGN KEY (`id_espacio_academico`) REFERENCES `espacio_academico` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_proyeccion_preliminar_estado_coord` FOREIGN KEY (`aprobacion_coordinador`) REFERENCES `estado` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_proyeccion_preliminar_estado_dec` FOREIGN KEY (`aprobacion_decano`) REFERENCES `estado` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_proyeccion_preliminar_periodo_academico` FOREIGN KEY (`id_peridodo_academico`) REFERENCES `periodo_academico` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_proyeccion_preliminar_programa_academico` FOREIGN KEY (`id_programa_academico`) REFERENCES `programa_academico` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_proyeccion_preliminar_semestre_asignatura` FOREIGN KEY (`id_semestre_asignatura`) REFERENCES `semestre_asignatura` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_proyeccion_preliminar_tipo_transporte` FOREIGN KEY (`id_tipo_transporte_rp_1`) REFERENCES `tipo_transporte` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_proyeccion_preliminar_tipo_zona_transitar` FOREIGN KEY (`id_tipo_zona_transitar`) REFERENCES `tipo_zona_transitar` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_proyeccion_preliminar_users` FOREIGN KEY (`id_docente_responsable`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

REPLACE INTO `proyeccion_preliminar` (`id`, `id_tipo_transporte_rp_1`, `id_tipo_transporte_rp_2`, `id_tipo_transporte_rp_3`, `id_tipo_transporte_ra_1`, `id_tipo_transporte_ra_2`, `id_tipo_transporte_ra_3`, `id_programa_academico`, `id_docente_responsable`, `id_espacio_academico`, `id_peridodo_academico`, `id_semestre_asignatura`, `id_tipo_zona_transitar`, `ruta_principal`, `destino_rp`, `ruta_alterna`, `destino_ra`, `lugar_salida_rp`, `lugar_salida_ra`, `lugar_regreso_rp`, `lugar_regreso_ra`, `fecha_salida_aprox_rp`, `fecha_salida_aprox_ra`, `fecha_regreso_aprox_rp`, `fecha_regreso_aprox_ra`, `num_estudiantes_aprox`, `num_acompaniantes`, `observ_coordinador`, `observ_decano`, `det_recorrido_interno_rp`, `det_recorrido_interno_ra`, `det_tipo_transporte_rp_1`, `otro_tipo_transporte_ra_1`, `otro_tipo_transporte_ra_2`, `otro_tipo_transporte_ra_3`, `otro_tipo_transporte_rp_1`, `otro_tipo_transporte_rp_2`, `otro_tipo_transporte_rp_3`, `det_tipo_transporte_rp_2`, `det_tipo_transporte_rp_3`, `det_tipo_transporte_ra_1`, `det_tipo_transporte_ra_2`, `det_tipo_transporte_ra_3`, `num_paradas_trayecto`, `cantidad_grupos`, `grupo_1`, `grupo_2`, `grupo_3`, `grupo_4`, `duracion_num_dias_rp`, `duracion_num_dias_ra`, `viaticos_estudiantes`, `viaticos_docente`, `costo_total_transporte`, `cant_transporte_rp`, `cant_transporte_ra`, `capac_transporte_rp_1`, `capac_transporte_rp_2`, `capac_transporte_rp_3`, `capac_transporte_ra_1`, `capac_transporte_ra_2`, `capac_transporte_ra_3`, `exclusiv_tiempo_rp_1`, `exclusiv_tiempo_rp_2`, `exclusiv_tiempo_rp_3`, `exclusiv_tiempo_ra_1`, `exclusiv_tiempo_ra_2`, `exclusiv_tiempo_ra_3`, `aprobacion_coordinador`, `aprobacion_decano`, `fecha_diligenciamiento`, `created_at`, `updated_at`) VALUES
	(4, 4, NULL, NULL, 1, NULL, NULL, 999, 30569841, 10, 1, 10, NULL, 'https://www.google.com/maps/dir/\'\'/Mesitas+del+Colegio,+Cundinamarca/Hacienda+Misiones,+Mesitas+del+Colegio,+Cundinamarca/Universidad+Distrital+Francisco+Jos%C3%A9+de+Caldas,+Cra.+7+%23%2340b-53,+Bogot%C3%A1/@4.5450322,-74.4668794,13.25z/data=!4m26!4m25!1m5!1m1!1s0x8e3f9a286d598bd5:0xddf14904a87dfb47!2m2!1d-74.0654527!2d4.6281045!1m5!1m1!1s0x8e3f6d19af65c3af:0x42b29d5a047e0908!2m2!1d-74.445236!2d4.584195!1m5!1m1!1s0x8e3f13aef84fb263:0xe1524b9000a9cfee!2m2!1d-74.4499699!2d4.54997!1m5!1m1!1s0x8e3f9a286d598bd5:0xddf14904a87dfb47!2m2!1d-74.0654527!2d4.6281045!3e0', 'Hacienda Misiones', 'https://www.google.com/maps/dir/\'\'/Mesitas+del+Colegio,+Cundinamarca/Hacienda+Misiones,+Mesitas+del+Colegio,+Cundinamarca/Universidad+Distrital+Francisco+Jos%C3%A9+de+Caldas,+Cra.+7+%23%2340b-53,+Bogot%C3%A1/@4.5450322,-74.4668794,13.25z/data=!4m26!4m25!1m5!1m1!1s0x8e3f9a286d598bd5:0xddf14904a87dfb47!2m2!1d-74.0654527!2d4.6281045!1m5!1m1!1s0x8e3f6d19af65c3af:0x42b29d5a047e0908!2m2!1d-74.445236!2d4.584195!1m5!1m1!1s0x8e3f13aef84fb263:0xe1524b9000a9cfee!2m2!1d-74.4499699!2d4.54997!1m5!1m1!1s0x8e3f9a286d598bd5:0xddf14904a87dfb47!2m2!1d-74.0654527!2d4.6281045!3e0', 'Impro arroz', 'https://www.google.com/maps/place/Universidad+Distrital+Francisco+Jos%C3%A9+de+Caldas/@4.6281098,-74.0676414,17z/data=!3m1!4b1!4m5!3m4!1s0x8e3f9a286d598bd5:0xddf14904a87dfb47!8m2!3d4.6281045!4d-74.0654527', 'https://www.google.com/maps/place/Universidad+Distrital+Francisco+Jos%C3%A9+de+Caldas/@4.6281098,-74.0676414,17z/data=!3m1!4b1!4m5!3m4!1s0x8e3f9a286d598bd5:0xddf14904a87dfb47!8m2!3d4.6281045!4d-74.0654527', _binary 0x68747470733A2F2F7777772E676F6F676C652E636F6D2F6D6170732F706C6163652F556E6976657273696461642B44697374726974616C2B4672616E636973636F2B4A6F732543332541392B64652B43616C6461732F40342E363238313039382C2D37342E303637363431342C31377A2F646174613D21336D312134623121346D3521336D342131733078386533663961323836643539386264353A30786464663134393034613837646662343721386D32213364342E363238313034352134642D37342E30363534353237, _binary 0x68747470733A2F2F7777772E676F6F676C652E636F6D2F6D6170732F706C6163652F556E6976657273696461642B44697374726974616C2B4672616E636973636F2B4A6F732543332541392B64652B43616C6461732F40342E363238313039382C2D37342E303637363431342C31377A2F646174613D21336D312134623121346D3521336D342131733078386533663961323836643539386264353A30786464663134393034613837646662343721386D32213364342E363238313034352134642D37342E30363534353237, '2020-09-07', '2020-09-07', '2020-09-08', '2020-09-08', 40, 2, 'Prueba', NULL, '"DIA UNO\r\nSALIDA DE BOGOTA 6:00 a. m.\r\nCORREGIMIENTO LA VICTORIA–HACIENDA MISIONES 9:00 a.m.\r\nDESAYUNO 9:30 a. m.\r\nMEDICION DE CAUDAL 11:00 a. m.\r\nBOCATOMA 12:30 m.\r\nALMUERZO 1:30 p. m.\r\nRECORRIDO HIDROELÉCTRICA 2:00 p. m.\r\nARMADO DE CAMPING 4:00 p. m.\r\nCENA 7:00 p. m.\r\nPRESENTACIÓN DE AVANCES TRABAJO 8:00 p.m.\r\nDIA DOS\r\nDESAYUNO 7:00 a. m.\r\nRECORRIDO MIRADOR SANTA LUCIA 9:00 a. m.\r\nALMUERZO 12:30 p. m.\r\nBOSQUE NATURAL ROBLE 1:30 p. m.\r\nRESERVORIO, USO DEL SUELO 2:00 p. m.\r\nREGRESO A ZONA DE CAMPING 3:00 p. m.\r\nPUNTO DE CAMPING 5:00 p. m.\r\nMAPAS DEL TERRITORIO 10:00 a. m.\r\nRECORRIDO HACIENDA Y BENEFICIO 11:00 a. m. LOMBRICULTIVO 11:30 a. m.\r\nPETROGLIFOS 12:00 p. m.\r\nALMUERZO 1:00 p. m.\r\nCULTIVOS 2:00 p. m.\r\nRESEVERA - MINA 3:00 p. m.\r\nRESERVORIO 3:30 p. m.\r\nPTAR 4:00 p. m.\r\nPORTON 4:30 p. m.\r\nSALIDA A BOGOTA 4:30 p. m.\r\nLLEGADA A BOGOTA 7:00 p. m."', 'Bogota (Edificio Sabio Caldas) - Villavicencio - Potosí (Impro Arroz) - Acacias -  Villavicencio - Bogota (Edificio Sabio Caldas)', 'carretera destapada', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'carretera destapada', NULL, NULL, NULL, 2, 501, 502, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, 20, NULL, NULL, 40, NULL, NULL, 2, NULL, NULL, 2, NULL, NULL, 2, 2, '2020-03-04', '2020-03-04 22:12:46', '2020-04-23 16:37:08'),
	(6, 1, NULL, NULL, 1, NULL, NULL, 999, 30314801, 5, 1, 10, NULL, 'https://www.google.com/maps/dir/\'\'/Mesitas+del+Colegio,+Cundinamarca/Hacienda+Misiones,+Mesitas+del+Colegio,+Cundinamarca/Universidad+Distrital+Francisco+Jos%C3%A9+de+Caldas,+Cra.+7+%23%2340b-53,+Bogot%C3%A1/@4.5450322,-74.4668794,13.25z/data=!4m26!4m25!1m5!1m1!1s0x8e3f9a286d598bd5:0xddf14904a87dfb47!2m2!1d-74.0654527!2d4.6281045!1m5!1m1!1s0x8e3f6d19af65c3af:0x42b29d5a047e0908!2m2!1d-74.445236!2d4.584195!1m5!1m1!1s0x8e3f13aef84fb263:0xe1524b9000a9cfee!2m2!1d-74.4499699!2d4.54997!1m5!1m1!1s0x8e3f9a286d598bd5:0xddf14904a87dfb47!2m2!1d-74.0654527!2d4.6281045!3e0', 'Hacienda Misiones', 'https://www.google.com/maps/dir/\'\'/Mesitas+del+Colegio,+Cundinamarca/Hacienda+Misiones,+Mesitas+del+Colegio,+Cundinamarca/Universidad+Distrital+Francisco+Jos%C3%A9+de+Caldas,+Cra.+7+%23%2340b-53,+Bogot%C3%A1/@4.5450322,-74.4668794,13.25z/data=!4m26!4m25!1m5!1m1!1s0x8e3f9a286d598bd5:0xddf14904a87dfb47!2m2!1d-74.0654527!2d4.6281045!1m5!1m1!1s0x8e3f6d19af65c3af:0x42b29d5a047e0908!2m2!1d-74.445236!2d4.584195!1m5!1m1!1s0x8e3f13aef84fb263:0xe1524b9000a9cfee!2m2!1d-74.4499699!2d4.54997!1m5!1m1!1s0x8e3f9a286d598bd5:0xddf14904a87dfb47!2m2!1d-74.0654527!2d4.6281045!3e0', 'Impro Arroz', 'https://www.google.com/maps/place/Universidad+Distrital+Francisco+Jos%C3%A9+de+Caldas/@4.6281098,-74.0676414,17z/data=!3m1!4b1!4m5!3m4!1s0x8e3f9a286d598bd5:0xddf14904a87dfb47!8m2!3d4.6281045!4d-74.0654527', 'https://www.google.com/maps/place/Universidad+Distrital+Francisco+Jos%C3%A9+de+Caldas/@4.6281098,-74.0676414,17z/data=!3m1!4b1!4m5!3m4!1s0x8e3f9a286d598bd5:0xddf14904a87dfb47!8m2!3d4.6281045!4d-74.0654527', _binary 0x68747470733A2F2F7777772E676F6F676C652E636F6D2F6D6170732F706C6163652F556E6976657273696461642B44697374726974616C2B4672616E636973636F2B4A6F732543332541392B64652B43616C6461732F40342E363238313039382C2D37342E303637363431342C31377A2F646174613D21336D312134623121346D3521336D342131733078386533663961323836643539386264353A30786464663134393034613837646662343721386D32213364342E363238313034352134642D37342E30363534353237, _binary 0x68747470733A2F2F7777772E676F6F676C652E636F6D2F6D6170732F706C6163652F556E6976657273696461642B44697374726974616C2B4672616E636973636F2B4A6F732543332541392B64652B43616C6461732F40342E363238313039382C2D37342E303637363431342C31377A2F646174613D21336D312134623121346D3521336D342131733078386533663961323836643539386264353A30786464663134393034613837646662343721386D32213364342E363238313034352134642D37342E30363534353237, '2020-09-07', '2020-09-07', '2020-09-08', '2020-09-08', 60, 1, 'prueba 23 abril', NULL, '"DIA UNO\r\nSALIDA DE BOGOTA 6:00 a. m.\r\nCORREGIMIENTO LA VICTORIA–HACIENDA MISIONES 9:00 a.m.\r\nDESAYUNO 9:30 a. m.\r\nMEDICION DE CAUDAL 11:00 a. m.\r\nBOCATOMA 12:30 m.\r\nALMUERZO 1:30 p. m.\r\nRECORRIDO HIDROELÉCTRICA 2:00 p. m.\r\nARMADO DE CAMPING 4:00 p. m.\r\nCENA 7:00 p. m.\r\nPRESENTACIÓN DE AVANCES TRABAJO 8:00 p.m.\r\nDIA DOS\r\nDESAYUNO 7:00 a. m.\r\nRECORRIDO MIRADOR SANTA LUCIA 9:00 a. m.\r\nALMUERZO 12:30 p. m.\r\nBOSQUE NATURAL ROBLE 1:30 p. m.\r\nRESERVORIO, USO DEL SUELO 2:00 p. m.\r\nREGRESO A ZONA DE CAMPING 3:00 p. m.\r\nPUNTO DE CAMPING 5:00 p. m.\r\nMAPAS DEL TERRITORIO 10:00 a. m.\r\nRECORRIDO HACIENDA Y BENEFICIO 11:00 a. m. LOMBRICULTIVO 11:30 a. m.\r\nPETROGLIFOS 12:00 p. m.\r\nALMUERZO 1:00 p. m.\r\nCULTIVOS 2:00 p. m.\r\nRESEVERA - MINA 3:00 p. m.\r\nRESERVORIO 3:30 p. m.\r\nPTAR 4:00 p. m.\r\nPORTON 4:30 p. m.\r\nSALIDA A BOGOTA 4:30 p. m.\r\nLLEGADA A BOGOTA 7:00 p. m."', 'Bogota (Edificio Sabio Caldas) - Villavicencio - Potosí (Impro Arroz) - Acacias -  Villavicencio - Bogota (Edificio Sabio Caldas)', 'carretera destapada', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'carretera destapada', NULL, NULL, NULL, 1, 504, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, 20, NULL, NULL, 20, NULL, NULL, 2, 2, 2, 2, 2, 2, 2, 2, '2020-03-04', '2020-03-05 02:21:41', '2020-04-23 16:36:49'),
	(14, 1, NULL, NULL, 1, NULL, NULL, 999, 30314801, 9, 3, 10, NULL, 'BOGOTÁ- SANTA ROSA DE OSOS- YARUMAL- MONTELIBANO- CORREGIMIENTO BOCAS DE URE- CORREGIMIENTO VILLA MARÍA- MONTERÍA- TIERRA ALTA- EMBALSE DE URRA- SAN BERNARDO DEL VIENTO- LORICA- INMEDIACIONES DE LORICA- CORREGIMIENTO DE SANTA CRUZ- SAN ANTERO- BAHÍA DE CISPTA- BOSCONIA- BOGOTÁ', 'CORREGIMIENTO DE SANTA CRUZ', 'BOGOTÁ- SANTA ROSA DE OSOS- YARUMAL- MONTELIBANO- CORREGIMIENTO BOCAS DE URE- CORREGIMIENTO VILLA MARÍA- MONTERÍA- TIERRA ALTA- EMBALSE DE URRA- SAN BERNARDO DEL VIENTO- LORICA- INMEDIACIONES DE LORICA- CORREGIMIENTO DE SANTA CRUZ- SAN ANTERO- BAHÍA DE CISPTA- BOSCONIA- BOGOTÁ', 'CORREGIMIENTO DE SANTA CRUZ', 'https://www.google.com/maps/place/Universidad+Distrital+Francisco+Jos%C3%A9+de+Caldas/@4.6281098,-74.0676414,17z/data=!3m1!4b1!4m5!3m4!1s0x8e3f9a286d598bd5:0xddf14904a87dfb47!8m2!3d4.6281045!4d-74.0654527', 'https://www.google.com/maps/place/Universidad+Distrital+Francisco+Jos%C3%A9+de+Caldas/@4.6281098,-74.0676414,17z/data=!3m1!4b1!4m5!3m4!1s0x8e3f9a286d598bd5:0xddf14904a87dfb47!8m2!3d4.6281045!4d-74.0654527', _binary 0x68747470733A2F2F7777772E676F6F676C652E636F6D2F6D6170732F706C6163652F556E6976657273696461642B44697374726974616C2B4672616E636973636F2B4A6F732543332541392B64652B43616C6461732F40342E363238313039382C2D37342E303637363431342C31377A2F646174613D21336D312134623121346D3521336D342131733078386533663961323836643539386264353A30786464663134393034613837646662343721386D32213364342E363238313034352134642D37342E30363534353237, _binary 0x68747470733A2F2F7777772E676F6F676C652E636F6D2F6D6170732F706C6163652F556E6976657273696461642B44697374726974616C2B4672616E636973636F2B4A6F732543332541392B64652B43616C6461732F40342E363238313039382C2D37342E303637363431342C31377A2F646174613D21336D312134623121346D3521336D342131733078386533663961323836643539386264353A30786464663134393034613837646662343721386D32213364342E363238313034352134642D37342E30363534353237, '2020-09-09', '2020-09-09', '2020-09-17', '2020-09-17', 65, NULL, 'prueba', NULL, '9 de semtiembre: Desplazamiento Bogotá a Santa Rosa de osos; 10 de septiembre: Visista planatcion forestal y desplazamiento a Motelibano; 11 de septiembre visista a Cerro Matoso- Corregimiento de de San jose de Ure y Villa Maria; 12 Dezplazamiento a Tierra Alta y visita a embalse de Urra; 13 Visita tecnica a planatciones de Canguroy; 14 septiembre: Desplazamiento a San Bernardo del Viento y recorrido tecnico por manglares; 15 de Septiembre:Desplazamiento a Lorica y visita técnica a proyecto agroforestales; 16 Desplazamiento a Bahia de Cispata ( San Antero)  y recorrido manglares y rio Sinú; 17 Desplzamiento  San Antero a Bogotá', '9 de semtiembre: Desplazamiento Bogotá a Santa Rosa de osos; 10 de septiembre: Visista planatcion forestal y desplazamiento a Motelibano; 11 de septiembre visista a Cerro Matoso- Corregimiento de de San jose de Ure y Villa Maria; 12 Dezplazamiento a Tierra Alta y visita a embalse de Urra; 13 Visita tecnica a planatciones de Canguroy; 14 septiembre: Desplazamiento a San Bernardo del Viento y recorrido tecnico por manglares; 15 de Septiembre:Desplazamiento a Lorica y visita técnica a proyecto agroforestales; 16 Desplazamiento a Bahia de Cispata ( San Antero)  y recorrido manglares y rio Sinú; 17 Desplzamiento  San Antero a Bogotá', 'df', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'sdfa', NULL, NULL, NULL, 1, 502, NULL, NULL, NULL, 8, 8, NULL, NULL, NULL, NULL, NULL, 25, NULL, NULL, 40, NULL, NULL, 1, 1, NULL, 1, 1, NULL, 2, 2, '2020-04-23', '2020-04-23 08:09:56', '2020-04-23 16:37:45'),
	(15, 2, NULL, NULL, 2, NULL, NULL, 999, 79418769, 51, 1, 1, NULL, 'https://www.google.com/maps/dir/Universidad+Distrital,+Carrera+7,+Bogot%C3%A1/Silvania,+Cundinamarca/Tibacuy,+Cundinamarca/Cerro+Quinini,+Tibacuy,+Cundinamarca/Universidad+Distrital+Francisco+Jos%C3%A9+de+Caldas,+Carrera+7,+Bogot%C3%A1/@4.4249221,-74.398792,11.75z/data=!4m32!4m31!1m5!1m1!1s0x8e3f9a286d598bd5:0xddf14904a87dfb47!2m2!1d-74.0654527!2d4.6281045!1m5!1m1!1s0x8e3f0ff275767b01:0x230bff6a5d6ebb18!2m2!1d-74.3994432!2d4.3867287!1m5!1m1!1s0x8e3f1ba819227f1d:0x72541d4ebb3e0f96!2m2!1d-74.45254!2d4.347837!1m5!1m1!1s0x8e3f1b0682c73755:0x2eb8871c42828666!2m2!1d-74.45254!2d4.347837!1m5!1m1!1s0x8e3f9a286d598bd5:0xddf14904a87dfb47!2m2!1d-74.0654527!2d4.6281045!3e0', 'CERRO QUININÍ 2', 'https://www.google.com/maps/dir/Universidad+Distrital,+Carrera+7,+Bogot%C3%A1/Silvania,+Cundinamarca/Tibacuy,+Cundinamarca/Cerro+Quinini,+Tibacuy,+Cundinamarca/Universidad+Distrital+Francisco+Jos%C3%A9+de+Caldas,+Carrera+7,+Bogot%C3%A1/@4.4249221,-74.398792,11.75z/data=!4m32!4m31!1m5!1m1!1s0x8e3f9a286d598bd5:0xddf14904a87dfb47!2m2!1d-74.0654527!2d4.6281045!1m5!1m1!1s0x8e3f0ff275767b01:0x230bff6a5d6ebb18!2m2!1d-74.3994432!2d4.3867287!1m5!1m1!1s0x8e3f1ba819227f1d:0x72541d4ebb3e0f96!2m2!1d-74.45254!2d4.347837!1m5!1m1!1s0x8e3f1b0682c73755:0x2eb8871c42828666!2m2!1d-74.45254!2d4.347837!1m5!1m1!1s0x8e3f9a286d598bd5:0xddf14904a87dfb47!2m2!1d-74.0654527!2d4.6281045!3e0', 'CERRO QUININÍ 2', 'https://www.google.com/maps/place/Universidad+Distrital+Francisco+Jos%C3%A9+de+Caldas/@4.6281098,-74.0676414,17z/data=!3m1!4b1!4m5!3m4!1s0x8e3f9a286d598bd5:0xddf14904a87dfb47!8m2!3d4.6281045!4d-74.0654527', 'https://www.google.com/maps/place/Universidad+Distrital+Francisco+Jos%C3%A9+de+Caldas/@4.6281098,-74.0676414,17z/data=!3m1!4b1!4m5!3m4!1s0x8e3f9a286d598bd5:0xddf14904a87dfb47!8m2!3d4.6281045!4d-74.0654527', _binary 0x68747470733A2F2F7777772E676F6F676C652E636F6D2F6D6170732F706C6163652F556E6976657273696461642B44697374726974616C2B4672616E636973636F2B4A6F732543332541392B64652B43616C6461732F40342E363238313039382C2D37342E303637363431342C31377A2F646174613D21336D312134623121346D3521336D342131733078386533663961323836643539386264353A30786464663134393034613837646662343721386D32213364342E363238313034352134642D37342E30363534353237, _binary 0x68747470733A2F2F7777772E676F6F676C652E636F6D2F6D6170732F706C6163652F556E6976657273696461642B44697374726974616C2B4672616E636973636F2B4A6F732543332541392B64652B43616C6461732F40342E363238313039382C2D37342E303637363431342C31377A2F646174613D21336D312134623121346D3521336D342131733078386533663961323836643539386264353A30786464663134393034613837646662343721386D32213364342E363238313034352134642D37342E30363534353237, '2020-09-12', '2020-09-13', '2020-09-12', '2020-09-12', 35, NULL, 'prueba 2', NULL, 'BOGOTÁ- SILVANIA- TIBACUY- CERRO QUININÍ- BOGOTÁ', 'BOGOTÁ- SILVANIA- TIBACUY- CERRO QUININÍ- BOGOTÁ', 'prueba 2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'prueba2', NULL, NULL, NULL, NULL, 302, 402, NULL, NULL, 1, 1, NULL, NULL, NULL, 1, 1, 36, NULL, NULL, 36, NULL, NULL, 2, NULL, NULL, 2, NULL, NULL, 5, 5, '2020-04-23', '2020-04-23 19:12:29', '2020-04-24 00:45:53');

CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

REPLACE INTO `roles` (`id`, `role`) VALUES
	(1, 'Admin'),
	(2, 'Decano'),
	(3, 'Asistente Decanatura'),
	(4, 'Coordinador Proyecto'),
	(5, 'Docente'),
	(6, 'Vicerrectoria Administrativa'),
	(7, 'Transportador');
	
CREATE TABLE IF NOT EXISTS `semestre_asignatura` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `semestre_asignatura` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

REPLACE INTO `semestre_asignatura` (`id`, `semestre_asignatura`) VALUES
	(1, 'I'),
	(2, 'II'),
	(3, 'III'),
	(4, 'IV'),
	(5, 'V'),
	(6, 'VI'),
	(7, 'VII'),
	(8, 'VIII'),
	(9, 'IX'),
	(10, 'X');
	
CREATE TABLE IF NOT EXISTS `solicitud_practica` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_proyeccion_preliminar` int(11) DEFAULT NULL,
  `id_estado_solicitud_practica` int(11) DEFAULT NULL,
  `si_capital` bit(1) DEFAULT b'0',
  `tiene_resolucion` bit(1) DEFAULT b'0',
  `num_cdp` bigint(20) DEFAULT '0',
  `fecha_resolucion` date DEFAULT NULL,
  `fecha_salida` date DEFAULT NULL,
  `fecha_regreso` date DEFAULT NULL,
  `num_estudiantes` int(11) DEFAULT '0',
  `num_radicado_financiera` int(11) DEFAULT '0',
  `num_acompaniantes` int(11) DEFAULT '0',
  `lugar_salida` varchar(50) DEFAULT NULL,
  `lugar_regreso` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_solicitud_practica_proyeccion_preliminar_idx` (`id_proyeccion_preliminar`),
  KEY `fk_solicitud_practica_estado_idx` (`id_estado_solicitud_practica`),
  CONSTRAINT `fk_solicitud_practica_estado` FOREIGN KEY (`id_estado_solicitud_practica`) REFERENCES `estado` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_solicitud_practica_proyeccion_preliminar` FOREIGN KEY (`id_proyeccion_preliminar`) REFERENCES `proyeccion_preliminar` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `solicitud_transporte` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_solicitud_practica` int(11) NOT NULL,
  `nombre_conductor` varchar(255) DEFAULT NULL,
  `celular_conductor` bigint(20) DEFAULT NULL,
  `email_conductor` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_solicitud_transporte_solicitud_practica_idx` (`id_solicitud_practica`),
  CONSTRAINT `fk_solicitud_transporte_solicitud_practica` FOREIGN KEY (`id_solicitud_practica`) REFERENCES `solicitud_practica` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `tipo_certificacion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_certificacion` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

REPLACE INTO `tipo_certificacion` (`id`, `tipo_certificacion`) VALUES
	(1, 'Constancia salida'),
	(2, 'Constancia asistencia');
	
CREATE TABLE IF NOT EXISTS `tipo_identificacion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_identificacion` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sigla` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

REPLACE INTO `tipo_identificacion` (`id`, `tipo_identificacion`, `sigla`) VALUES
	(1, 'Cédula de Ciudadanía', 'C.C'),
	(2, 'Cédula de Extranjería', 'C.E'),
	(3, 'Pasaporte', 'PAS');
	
CREATE TABLE IF NOT EXISTS `tipo_transporte` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_transporte` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

REPLACE INTO `tipo_transporte` (`id`, `tipo_transporte`) VALUES
	(1, 'Bus'),
	(2, 'Buseta'),
	(3, 'Camioneta'),
	(4, 'Otro');
	
CREATE TABLE IF NOT EXISTS `tipo_vinculacion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_vinculacion` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1

REPLACE INTO `tipo_vinculacion` (`id`, `tipo_vinculacion`) VALUES
	(1, 'Docente catedra (contrato)'),
	(2, 'Docente catedra (Honorario)'),
	(3, 'Docente medio tiempo ocasional'),
	(4, 'Docenete tiempo completo ocasional'),
	(5, 'Docente planta compartido'),
	(6, 'Docente planta tiempo completo'),
	(7, 'Transportador');
	
CREATE TABLE IF NOT EXISTS `tipo_zona_transitar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_zona` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

REPLACE INTO `tipo_zona_transitar` (`id`, `tipo_zona`) VALUES
	(1, 'Rural'),
	(2, 'Urbana'),
	(3, 'Rural - Urbana');
	
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) NOT NULL,
  `id_role` int(11) NOT NULL DEFAULT '2',
  `id_tipo_identificacion` int(11) NOT NULL DEFAULT '1',
  `id_tipo_vinculacion` int(11) NOT NULL DEFAULT '1',
  `id_estado` int(11) NOT NULL DEFAULT '1',
  `id_espacio_academico_1` int(11) NOT NULL,
  `id_espacio_academico_2` int(11) DEFAULT NULL,
  `id_espacio_academico_3` int(11) DEFAULT NULL,
  `id_espacio_academico_4` int(11) DEFAULT NULL,
  `id_espacio_academico_5` int(11) DEFAULT NULL,
  `id_espacio_academico_6` int(11) DEFAULT NULL,
  `id_programa_academico` int(11) DEFAULT NULL,
  `usuario` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `primer_nombre` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `segundo_nombre` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `primer_apellido` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `segundo_apellido` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `celular` bigint(20) NOT NULL,
  `telefono` bigint(20) DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
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
  KEY `fk_users_programa_academico_idx` (`id_programa_academico`),
  CONSTRAINT `fk_users_espacio_academico_2` FOREIGN KEY (`id_espacio_academico_2`) REFERENCES `espacio_academico` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `fk_users_espacio_academico_3` FOREIGN KEY (`id_espacio_academico_3`) REFERENCES `espacio_academico` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `fk_users_espacio_academico_4` FOREIGN KEY (`id_espacio_academico_4`) REFERENCES `espacio_academico` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `fk_users_espacio_academico_5` FOREIGN KEY (`id_espacio_academico_5`) REFERENCES `espacio_academico` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `fk_users_espacio_academico_6` FOREIGN KEY (`id_espacio_academico_6`) REFERENCES `espacio_academico` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `fk_users_estado` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_users_programa_academico` FOREIGN KEY (`id_programa_academico`) REFERENCES `programa_academico` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_users_roles` FOREIGN KEY (`id_role`) REFERENCES `roles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_users_tipo_identificacion` FOREIGN KEY (`id_tipo_identificacion`) REFERENCES `tipo_identificacion` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_users_tipo_vinculacion` FOREIGN KEY (`id_tipo_vinculacion`) REFERENCES `tipo_vinculacion` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

REPLACE INTO `users` (`id`, `id_role`, `id_tipo_identificacion`, `id_tipo_vinculacion`, `id_estado`, `id_espacio_academico_1`, `id_espacio_academico_2`, `id_espacio_academico_3`, `id_espacio_academico_4`, `id_espacio_academico_5`, `id_espacio_academico_6`, `id_programa_academico`, `usuario`, `primer_nombre`, `segundo_nombre`, `primer_apellido`, `segundo_apellido`, `celular`, `telefono`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
	(30314801, 5, 1, 1, 1, 5, 9, 47, NULL, NULL, NULL, 999, 'emontesr', 'Emilia', NULL, 'Montes', 'Rojas', 3154269895, 7289645, 'lauritagiraldo.s@gmail.com.co', NULL, '$2y$10$JyWtQxOKKx9W2eWBn2yCduyRCcSU4W5YF6gErdNfeJ6B.Ti.Gl1S6', NULL, '2020-02-27 02:52:56', '2020-02-27 02:52:56'),
	(30569841, 4, 1, 1, 1, 10, NULL, NULL, NULL, NULL, NULL, 81, 'jposadam', 'Jairo', NULL, 'Posada', 'Martinez', 3152695487, 3216956, 'jposadam@udistrital.edu.co', NULL, '$2y$10$ZNaeSKLtN/17lX6SVEmP2.TetVJQuvjBQTR93LLyat6B1VpuXOuI.', NULL, '2020-02-27 02:53:02', '2020-02-27 02:53:02'),
	(52527490, 4, 1, 1, 1, 58, 66, NULL, NULL, NULL, NULL, 10, 'npbonzap', 'Niria', 'Pastora', 'Bonza', 'Perez', 5711748, 5711748, 'npbonzap@udistrital.edu.co', NULL, '$2y$10$LXwvSEa5esmKWD52sV.dRukGlS6ZTiFEq0Oe/mqk122xJfjWsu3IO', NULL, '2020-04-23 18:49:10', '2020-04-23 18:49:10'),
	(79418769, 5, 1, 1, 1, 51, NULL, NULL, NULL, NULL, NULL, 999, 'cagarciav', 'Cesar', 'Augusto', 'Garcia', 'Valbuena', 5472365, 5472365, 'cagarciav@udistrital.edu.co', NULL, '$2y$10$rT54iBkqRKdycG78y8ypvO6u3L6uNST9kPkTZgqwn8pGA5dbdO93.', NULL, '2020-04-23 18:49:10', '2020-04-23 18:49:10'),
	(310698563, 2, 1, 3, 1, 10, NULL, NULL, NULL, NULL, NULL, 999, 'fussar', 'Freddy', NULL, 'Ussa', 'Rodriguez', 3156984569, 4523698, 'fussar@udistrital.edu.co', NULL, '$2y$10$r.oFd571jYk5PM4ycnfnr.OP1mV5HocwmN9z9Flt69qjeWnO6wRbi', NULL, '2020-02-16 23:44:20', '2020-02-16 23:44:20'),
	(659863256, 3, 1, 6, 1, 4, 999, NULL, NULL, NULL, NULL, 999, 'arojasc', 'Alejandro', NULL, 'Rojas', 'Castro', 32569874536, 5632121, 'arojasc@udistrital.edu.co', NULL, '$2y$10$zX5X9sIdU6OgWDABgq7G2uQKji/mGgZSIi0TfZpMzUn4zbKv2S1be', NULL, '2020-02-16 23:40:10', '2020-02-16 23:40:10'),
	(1038410523, 1, 1, 1, 1, 136, 132, 137, 131, NULL, NULL, 999, 'lvgiraldos', 'Laura', 'Vanessa', 'Giraldo', 'Salazar', 3107964434, 4125679, 'lvgiraldos@udistrital.edu.co', NULL, '$2y$10$V/4DkEVqMJNNXiHyUY42sOqTSRHtfhJAoOViAeoVxzbFwvj72ELg.', NULL, '2020-02-16 23:34:35', '2020-02-16 23:34:35');