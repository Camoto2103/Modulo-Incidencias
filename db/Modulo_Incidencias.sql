CREATE TABLE `usuarioPO` (
  `cedula` VARCHAR(20) PRIMARY KEY NOT NULL,
  `nombre` VARCHAR(40) NOT NULL,
  `canal` VARCHAR(50) NOT NULL,
  `cargo` VARCHAR(50) NOT NULL
);

CREATE TABLE `incidencia` (
  `id` INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `cedula_usuario` VARCHAR(20) NOT NULL,
  `correo` VARCHAR(100) NOT NULL,
  `nombre_herramienta` TEXT NOT NULL,
  `descripcion` TEXT NOT NULL,
  `url` VARCHAR(200) NOT NULL,
  `adjunto` VARCHAR(50) NOT NULL,
  `fecha_registro` TIMESTAMP NOT NULL,
  `estatus` VARCHAR(40) NOT NULL
);

CREATE TABLE `estado` (
  `estatus` VARCHAR(40) PRIMARY KEY NOT NULL
);

CREATE TABLE `historico_incidencias` (
  `id` INT(20) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `id_user_management` INT NOT NULL,
  `id_incidencia` INT(20) NOT NULL,
  `comentarios` VARCHAR(300) NOT NULL,
  `fecha_actualizacion` TIMESTAMP NOT NULL,
  `estatus` VARCHAR(20)
);

CREATE TABLE `asignaciones` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `id_incidencia` INT,
  `id_user_management` INT
);

CREATE TABLE `user_management` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `cedula` VARCHAR(20),
  `nombre` VARCHAR(200),
  `id_rol` INT
);

CREATE TABLE `roles` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `nombre_rol` VARCHAR(30)
);

-- ALTER TABLE `incidencia` ADD FOREIGN KEY (`cedula_usuario`) REFERENCES `usuarioPO` (`cedula`);

ALTER TABLE `historico_incidencias` ADD FOREIGN KEY (`id_incidencia`) REFERENCES `incidencia` (`id`);

-- ALTER TABLE `incidencia` ADD FOREIGN KEY (`estatus`) REFERENCES `estado` (`estatus`); 

ALTER TABLE `historico_incidencias` ADD FOREIGN KEY (`estatus`) REFERENCES `incidencia` (`estatus`);

ALTER TABLE `asignaciones` ADD FOREIGN KEY (`id_incidencia`) REFERENCES `incidencia` (`id`);

-- ALTER TABLE `user_management` ADD FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id`);

ALTER TABLE `user_management` ADD FOREIGN KEY (`id`) REFERENCES `asignaciones` (`id_user_management`);

ALTER TABLE `historico_incidencias` ADD FOREIGN KEY (`id_user_management`) REFERENCES `user_management` (`id`);
