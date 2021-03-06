/**
 * CticServices
 *
 * Creación de la Tabla para la gestión de 
 * los Controles para las Características
 * de Actividades (Productos)
 *
 * @package     sql
 * @author      AQ
 * @since       Version 2.0
 *
 */
--
-- Estructura de tabla para la tabla `t09_act_car_ctrl`
--

DROP TABLE IF EXISTS `t09_act_car_ctrl`;

CREATE TABLE IF NOT EXISTS `t09_act_car_ctrl` (
  `t02_cod_proy` varchar(10) NOT NULL,
  `t02_version` int(11) NOT NULL,
  `t08_cod_comp` int(11) NOT NULL,
  `t09_cod_act` int(11) NOT NULL,
  `t09_cod_act_car` int(11) NOT NULL,
  `t09_car_anio` tinyint(4) NOT NULL,
  `t09_car_mes` tinyint(4) NOT NULL,
  `t09_car_ctrl` tinyint(4) DEFAULT NULL,
  `usr_crea` char(20) DEFAULT NULL,
  `fch_crea` datetime DEFAULT NULL,
  `usr_actu` char(20) DEFAULT NULL,
  `fch_actu` datetime DEFAULT NULL,
  `est_audi` char(1) DEFAULT NULL,
  PRIMARY KEY (`t02_cod_proy`,`t02_version`,`t08_cod_comp`,`t09_cod_act`,`t09_cod_act_car`,`t09_car_anio`,`t09_car_mes`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `t09_act_car_ctrl`
--
ALTER TABLE `t09_act_car_ctrl`
  ADD CONSTRAINT `t09_act_car_ctrl_ibfk_1` FOREIGN KEY (`t02_cod_proy`, `t02_version`, `t08_cod_comp`, `t09_cod_act`, `t09_cod_act_car`) REFERENCES `t09_act_car` (`t02_cod_proy`, `t02_version`, `t08_cod_comp`, `t09_cod_act`, `t09_cod_act_car`) ON DELETE CASCADE ON UPDATE CASCADE;

