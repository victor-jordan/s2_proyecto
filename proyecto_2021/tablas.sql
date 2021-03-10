CREATE TABLE IF NOT EXISTS `usuario` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `username` varchar(12) NOT NULL,
  `password` varchar(12) NOT NULL,
  `nombre` varchar(15) DEFAULT NULL,
  `apellido` varchar(25) DEFAULT NULL,
  `activo` boolean DEFAULT TRUE,
  PRIMARY KEY (`id`),
  CONSTRAINT unq_username (username) UNIQUE,
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `pelicula` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(25) NOT NULL,
  `genero` varchar(3) NOT NULL,
  `anho` varchar(4) DEFAULT NULL,
  `director` varchar(30) DEFAULT NULL,
  `formato` varchar(3) NOT NULL,
  `precio_alquiler` int(6) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `cliente` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `documento` int(8) NOT NULL,
  `dv` int(1) DEFAULT NULL,
  `nombres` varchar(4) NOT NULL,
  `apellidos` varchar(30) NOT NULL,
  `fecha_ingreso` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `alquiler` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_cliente` int(5) NOT NULL,
  `fecha_alquiler` datetime NOT NULL,
  `nro_factura` varchar(9) DEFAULT NULL,
  `monto` int(6) DEFAULT 0,
  `creado_por` int(2),
  PRIMARY KEY (`id`),
  CONSTRAINT FOREIGN KEY fk_cliente (id_cliente) REFERENCES cliente (id),
  CONSTRAINT FOREIGN KEY fk_usuario (creado_por) REFERENCES usuario (id)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `alquiler_pelicula` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_alquiler` int(11) NOT NULL,
  `id_pelicula` int(5) NOT NULL,
  `alquilado_en` datetime NOT NULL,
  `devuelto_en` datetime DEFAULT NULL,
  `monto` int(6) NOT NULL,
  PRIMARY KEY (`id`, `id_alquiler`),
  CONSTRAINT FOREIGN KEY fk_alquiler (id_alquiler) REFERENCES alquiler (id),
  CONSTRAINT FOREIGN KEY fk_pelicula (id_pelicula) REFERENCES pelicula (id)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `auditoria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` datetime NOT NULL,
  `tabla` varchar(17) NOT NULL,
  `accion` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4;