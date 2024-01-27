--
-- Base de datos: `muebleriasapito`
--
CREATE DATABASE IF NOT EXISTS `muebleriasapito` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `muebleriasapito`;


--
-- Estructura de tabla para la tabla `usuario`
--
CREATE TABLE `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `password` varchar(150) DEFAULT NULL,
  `usuario` varchar(50) DEFAULT NULL,
  `roles` varchar(50) DEFAULT 'usuario',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
--
-- datos para la tabla `usuario`
--
INSERT INTO `usuario`(`id`, `email`, `password`, `usuario`, `roles`) 
VALUES (0,'Stevenbazan@hotmail.com','12345678','Steven','vendedor');

INSERT INTO `usuario`(`id`, `email`, `password`, `usuario`, `roles`) 
VALUES (1,'LuisBaldeon@hotmail.com','12345678','Luis','vendedor');

INSERT INTO `usuario`(`id`, `email`, `password`, `usuario`, `roles`) 
VALUES (2,'AlexisYagual@hotmail.com','12345678','Alexis','vendedor');
--
-- Estructura de tabla para la tabla `categoria`
--
CREATE TABLE `categoria` (
  `cat_id` int(11) NOT NULL,
  `cat_nombre` varchar(30) NOT NULL,
  `cat_descripcion` varchar(100) NOT NULL,
  `cat_estado` int(1) NOT NULL,
  `cat_usuarioActualizacion` varchar(12) NOT NULL,
  `cat_fechaActualizacion` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
--
-- datos para la tabla `categoria`
--
-- Categoría 1
INSERT INTO `categoria` (`cat_id`, `cat_nombre`, `cat_descripcion`, `cat_estado`, `cat_usuarioActualizacion`, `cat_fechaActualizacion`) 
VALUES (1, 'Muebles', 'Muebles para el hogar', 1, '', '2024-01-01 15:50:44');
-- Categoría 2
INSERT INTO `categoria` (`cat_id`, `cat_nombre`, `cat_descripcion`, `cat_estado`, `cat_usuarioActualizacion`, `cat_fechaActualizacion`)
VALUES (2, 'Sillas', 'Sillas para el hogar', 1, '', '2024-01-01 15:51:00');
-- Categoría 3
INSERT INTO `categoria` (`cat_id`, `cat_nombre`, `cat_descripcion`, `cat_estado`, `cat_usuarioActualizacion`, `cat_fechaActualizacion`)
VALUES (3, 'Mesas', 'Mesas para el hogar', 1, '', '2024-01-01 15:51:15');
-- Categoría 4
INSERT INTO `categoria` (`cat_id`, `cat_nombre`, `cat_descripcion`, `cat_estado`, `cat_usuarioActualizacion`, `cat_fechaActualizacion`)
VALUES (4, 'Camas', 'Camas para el hogar', 1, '', '2024-01-01 15:51:30');


--
-- Estructura de tabla para la tabla `productos`
--
CREATE TABLE `productos` (
  `prod_id` int(11) NOT NULL,
  `prod_nombre` varchar(50) NOT NULL,
  `prod_estado` int(1) NOT NULL,
  `prod_precio` double NOT NULL,
  `prod_idCategoria` int(11) NOT NULL,
  `prod_usuarioActualizacion` varchar(12) NOT NULL,
  `prod_fechaActualizacion` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
--
-- datos para la tabla `productos`
--
INSERT INTO productos (prod_nombre, prod_estado, prod_precio, prod_idCategoria, prod_usuarioActualizacion, prod_fechaActualizacion)
VALUES ('Silla de Oficina', 1, 50.0, 2, 'admin', NOW());

INSERT INTO productos (prod_nombre, prod_estado, prod_precio, prod_idCategoria, prod_usuarioActualizacion, prod_fechaActualizacion)
VALUES ('Mesa de Comedor', 1, 150.0, 3, 'admin', NOW());

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`cat_id`);
--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`prod_id`),
  ADD KEY `fk_categoria` (`prod_idCategoria`);
--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `prod_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;
--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `fk_categoria` FOREIGN KEY (`prod_idCategoria`) REFERENCES `categoria` (`cat_id`);
COMMIT;