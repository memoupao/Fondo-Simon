DELIMITER $$

DROP PROCEDURE IF EXISTS `sp_rpt_nroproy_region_alt`$$

CREATE PROCEDURE `sp_rpt_nroproy_region_alt`(IN _concurso  VARCHAR(10), IN _estado  VARCHAR(10))
BEGIN
	SELECT 	dep.nom_ubig AS region, 
			COUNT(DISTINCT proy.t02_cod_proy) AS cantidad,
			tinst.abrev AS tipoinst,
			SUM(fn_costo_presupuesto_fe(proy.t02_cod_proy, proy.t02_version)) AS FE,
			SUM(fn_costo_presupuesto_otros(proy.t02_cod_proy, proy.t02_version)) AS otros,
			SUM(fn_costos_total_proyecto(proy.t02_cod_proy, proy.t02_version)) AS total,
			inst.t01_tipo_inst
	FROM 			t01_dir_inst	inst
	JOIN		t02_dg_proy		proy	ON (inst.t01_id_inst = proy.t01_id_inst)
	LEFT JOIN	(SELECT t02_cod_proy, t03_dpto 
				FROM t03_dist_proy 
				WHERE t02_version = fn_pri_version_proy(t02_cod_proy)
				GROUP BY t02_cod_proy)	dp	ON (proy.t02_cod_proy = dp.t02_cod_proy)
	LEFT JOIN	adm_tablas_aux 	tinst	ON (tinst.codi = inst.t01_tipo_inst)
	LEFT JOIN	adm_ubigeo		dep		ON (dp.t03_dpto = dep.cod_dpto AND dep.cod_prov='00' AND dep.cod_dist='00')
	WHERE	proy.t02_version = fn_pri_version_proy(proy.t02_cod_proy) 
		AND SUBSTR(proy.t02_cod_proy,3,2) = (CASE WHEN _concurso='*' THEN SUBSTR(proy.t02_cod_proy,3,2) ELSE _concurso END )
		AND proy.t02_estado = (CASE WHEN _estado='*' THEN proy.t02_estado ELSE _estado END ) 
	GROUP BY region, tipoinst
	ORDER BY -region DESC, region, -tipoinst DESC, tipoinst ;
	
END$$

DELIMITER ;