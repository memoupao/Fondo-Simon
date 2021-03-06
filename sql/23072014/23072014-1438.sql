/*
// -------------------------------------------------->
// AQ 2.1 [23-07-2014 14:38]
// Fixed: Incidencia #244
// --------------------------------------------------<
*/

DROP PROCEDURE IF EXISTS `sp_lis_resumen_gastos_comp_fte`;

DELIMITER $$
CREATE PROCEDURE `sp_lis_resumen_gastos_comp_fte`(_proy VARCHAR(10), _ver INT)
BEGIN
DECLARE _contador INT ;
DECLARE _rowcount INT ;
DECLARE _codfte   INT ;
DECLARE _nomfte   VARCHAR(50) ;
DECLARE _sql      TEXT;
DECLARE _subquery TEXT;
DECLARE _sqlMP      TEXT;
DECLARE _subqueryMP TEXT;
DROP TEMPORARY TABLE IF EXISTS tmpFuentes;
DROP TEMPORARY TABLE IF EXISTS tmpFuentesMP;
CREATE TEMPORARY TABLE tmpFuentes 
( id INT AUTO_INCREMENT,
  idfte INT,
  nomfte VARCHAR(250),
  PRIMARY KEY (id)
) ;
CREATE TEMPORARY TABLE tmpFuentesMP 
( id INT AUTO_INCREMENT,
  actividad VARCHAR(50) ,
  idfte INT,
  nomfte VARCHAR(250),
  total  DOUBLE,
  PRIMARY KEY (id)
) ;
INSERT INTO tmpFuentes(idfte, nomfte)
SELECT  f.t01_id_inst,
  i.t01_sig_inst
FROM    t02_fuente_finan f
LEFT JOIN t01_dir_inst     i ON (f.t01_id_inst=i.t01_id_inst)
WHERE f.t02_cod_proy=_proy ;
INSERT INTO tmpFuentesMP(actividad, idfte, nomfte, total)
SELECT 'Personal del Proyecto' AS Actividad,
  f.t01_id_inst,
  i.t01_sig_inst,
  IFNULL(SUM(fte.t03_monto),0) AS total_fuente
FROM       t02_fuente_finan f
LEFT  JOIN t01_dir_inst     i   ON(f.t01_id_inst = i.t01_id_inst)
LEFT  JOIN t03_mp_per_ftes  fte ON(f.t02_cod_proy=fte.t02_cod_proy AND fte.t02_version=_ver AND f.t01_id_inst=fte.t03_id_inst)
WHERE f.t02_cod_proy=_proy
GROUP BY 1,2,3
UNION ALL
SELECT 'Equipamiento del Proyecto' AS Actividad,
  f.t01_id_inst,
  i.t01_sig_inst,
  IFNULL(SUM(fte.t03_monto),0) AS total_fuente
FROM       t02_fuente_finan f
LEFT  JOIN t01_dir_inst     i   ON(f.t01_id_inst = i.t01_id_inst)
LEFT  JOIN t03_mp_equi_ftes  fte ON(f.t02_cod_proy=fte.t02_cod_proy AND fte.t02_version=_ver AND f.t01_id_inst=fte.t03_id_inst)
WHERE f.t02_cod_proy=_proy
GROUP BY 1,2,3
UNION ALL
SELECT 'Gastos de Funcionamiento' AS Actividad,
  f.t01_id_inst,
  i.t01_sig_inst,
  IFNULL(SUM(fte.t03_monto),0) AS total_fuente
FROM       t02_fuente_finan f
LEFT  JOIN t01_dir_inst     i   ON(f.t01_id_inst = i.t01_id_inst)
LEFT  JOIN t03_mp_gas_fun_ftes  fte ON(f.t02_cod_proy=fte.t02_cod_proy AND fte.t02_version=_ver AND f.t01_id_inst=fte.t03_id_inst)
WHERE f.t02_cod_proy=_proy
GROUP BY 1,2,3 ;
SELECT '
SELECT  CONCAT(cmp.t08_cod_comp, ".-" ,cmp.t08_comp_desc) AS componente,
  SUM(c.t10_cu * c.t10_cant * s.t09_mta) AS costo_total'
INTO _sql ;
SELECT ' UNION ALL 
  SELECT  \'Manejo del Proyecto \',
    SUM(total) AS costo_total'
INTO _sqlMP;
SELECT 1 INTO _contador ;  
WHILE (SELECT COUNT(1) FROM  tmpFuentes) >= _contador DO
  SELECT idfte  ,  nomfte
  INTO   _codfte, _nomfte 
  FROM tmpFuentes 
  WHERE id = _contador;
  
  SELECT   CONCAT(', 
     (SELECT SUM(CASE WHEN fte.t01_id_inst=',_codfte,' THEN fte.t10_mont ELSE 0 END )
        FROM t10_cost_fte fte 
       WHERE fte.t02_cod_proy=c.t02_cod_proy 
         AND fte.t02_version =c.t02_version 
         AND fte.t08_cod_comp=c.t08_cod_comp ) as \'', _nomfte, '\'') INTO _subquery ;
  SELECT CONCAT(_sql, _subquery) INTO _sql ;
  
  SELECT CONCAT(',
           SUM(CASE WHEN idfte=',_codfte,' THEN total ELSE 0 END) AS \'', _nomfte, '\'' ) INTO _subqueryMP;
  SELECT CONCAT(_sqlMP, _subqueryMP) INTO _sqlMP ;
  
  SET _contador = _contador + 1;
END WHILE;
SELECT CONCAT( _sql , 
        ' FROM       t10_cost_sub c
    INNER JOIN t09_subact   s   ON(c.t02_cod_proy=s.t02_cod_proy AND c.t02_version=s.t02_version AND c.t08_cod_comp=s.t08_cod_comp AND c.t09_cod_act=s.t09_cod_act AND c.t09_cod_sub=s.t09_cod_sub)
    INNER JOIN t08_comp     cmp ON(c.t02_cod_proy=cmp.t02_cod_proy AND c.t02_version=cmp.t02_version AND c.t08_cod_comp=cmp.t08_cod_comp) 
    WHERE c.t02_cod_proy = ', '\'', _proy , '\'' ,
    ' AND c.t02_version  = ', _ver,
    ' GROUP BY 1 \n') INTO _sql;
    
SELECT CONCAT( _sqlMP, ' \n FROM tmpFuentesMP') INTO _sqlMP ;
SELECT CONCAT(_sql, _sqlMP) INTO @txtsql;
PREPARE stmt FROM @txtsql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt; 
DROP TEMPORARY TABLE tmpFuentes;
DROP TEMPORARY TABLE tmpFuentesMP;
END $$
DELIMITER ;

DROP FUNCTION IF EXISTS `fn_costos_componentes`;

DELIMITER $$
CREATE FUNCTION `fn_costos_componentes`(_proy varchar(10), _ver int) RETURNS double
    DETERMINISTIC
BEGIN
  declare _return double;
  
  /*SELECT  SUM(cost.t10_cost_tot)
  INTO  _return
  FROM  t10_cost_sub cost
  WHERE cost.t02_cod_proy=_proy AND cost.t02_version=_ver;*/

  SELECT
  SUM(ROUND(c.t10_cu * c.t10_cant * s.t09_mta,2) )
  INTO  _return
  FROM t10_cost_sub c
  INNER JOIN t09_subact s ON(c.t02_cod_proy=s.t02_cod_proy AND c.t02_version=s.t02_version AND c.t08_cod_comp=s.t08_cod_comp AND c.t09_cod_act=s.t09_cod_act AND c.t09_cod_sub=s.t09_cod_sub) 
  INNER JOIN t08_comp cmp ON(c.t02_cod_proy=cmp.t02_cod_proy AND c.t02_version=cmp.t02_version AND c.t08_cod_comp=cmp.t08_cod_comp) 
  WHERE c.t02_cod_proy = _proy
  AND c.t02_version  = _ver;

  RETURN ifnull(_return,0) ;
    END $$
DELIMITER ;

DROP FUNCTION IF EXISTS `fn_manejo_proyecto`;
DELIMITER $$
CREATE FUNCTION `fn_manejo_proyecto`(_proy VARCHAR(10), _ver INT) RETURNS double
    DETERMINISTIC
BEGIN
  declare _return double;
  
  select SUM(mnproy.costo_total) 
    INTO  _return
    from (
    SELECT  'Personal' AS Tipo,
      SUM(t03_gasto_tot) AS costo_total
    FROM  t03_mp_per
    WHERE t02_cod_proy = _proy
      AND t02_version  = _ver
    UNION ALL
    SELECT  'Equipamiento' AS Tipo,
      SUM(t03_costo_tot) AS costo_total
    FROM  t03_mp_equi
    WHERE t02_cod_proy = _proy
      AND t02_version  = _ver
    UNION ALL
    SELECT  'Gastos Funcionamiento' AS Tipo,
      SUM(ROUND(c.t03_cu * c.t03_cant * p.t03_meta,2) ) AS costo_total
    FROM       t03_mp_gas_fun_cost c
    INNER JOIN t03_mp_gas_fun_part p ON(c.t02_cod_proy=p.t02_cod_proy AND c.t02_version=p.t02_version AND c.t03_partida=p.t03_partida)
    WHERE c.t02_cod_proy = _proy
      AND c.t02_version  = _ver
    ) as mnproy ;
  
  RETURN ifnull(_return,0) ;
    END $$
DELIMITER ;