/* Nuevo campo de tasa del proyecto*/

alter table `t02_tasas_proy` add column `t02_proc_gast_superv` varchar(10) NULL after `t02_porc_imprev`;


/* actualizacion en la seleccion del proyecto*/
DELIMITER $$

DROP PROCEDURE IF EXISTS  `sp_get_proyecto`$$

CREATE PROCEDURE `sp_get_proyecto`(IN _proy VARCHAR(10), 
                   IN _vs   INT)
BEGIN
SELECT  p.t02_cod_proy, 
    p.t02_version, 
    p.t02_nro_exp, 
	
    p.t00_cod_linea, 
    p.t01_id_inst, 
    i.t01_sig_inst,
    p.t02_nom_proy, 
    DATE_FORMAT(p.t02_fch_apro,'%d/%m/%Y') AS apro, 
    DATE_FORMAT(p.t02_fch_ini,'%d/%m/%Y') AS ini, 
    DATE_FORMAT(p.t02_fch_ter,'%d/%m/%Y') AS fin , 
    p.t02_fin, 
    p.t02_pro, 
    p.t02_ben_obj, 
    p.t02_amb_geo, 
    p.t02_cre_fe,
    p.t02_pres_fe,
    p.t02_pres_eje,
    p.t02_pres_otro, 
    p.t02_pres_tot, 
    p.t02_moni_tema, 
    p.t02_moni_fina, 
    p.t02_moni_ext, 
    p.t02_sup_inst, 
    p.t02_dire_proy, 
    p.t02_ciud_proy, 
    p.t02_tele_proy, 
    p.t02_fax_proy, 
    p.t02_mail_proy,
    DATE_FORMAT((CASE WHEN p.t02_fch_isc =0 THEN NULL ELSE p.t02_fch_isc END),'%d/%m/%Y') AS isc,
    DATE_FORMAT(p.t02_fch_ire,'%d/%m/%Y') AS ire, 
    DATE_FORMAT(p.t02_fch_tre,'%d/%m/%Y') AS tre, 
    DATE_FORMAT((CASE WHEN p.t02_fch_tam =0 THEN NULL ELSE p.t02_fch_tam END),'%d/%m/%Y') AS tam,
    p.t02_num_mes AS mes,
    p.t02_num_mes_amp,
    p.t02_sect_prod,
    p.t02_subsect_prod,
    p.t02_estado, 
    i.t01_web_inst,
    cta.t01_id_cta,
    cta.t02_nom_benef,
    p.usr_crea, 
    p.fch_crea, 
    p.usr_actu, 
    p.fch_actu, 
    p.est_audi,
    p.env_rev,
    apr.t02_vb_proy, 
    apr.t02_aprob_proy, 
    apr.t02_fch_vb_proy, 
    apr.t02_fch_aprob_proy, 
    apr.t02_obs_vb_proy, 
    apr.t02_obs_aprob_proy, 
    apr.t02_aprob_ml, 
    apr.t02_aprob_cro, 
    apr.t02_aprob_pre, 
    apr.t02_fch_ml, 
    apr.t02_fch_cro, 
    apr.t02_fch_pre, 
    apr.t02_aprob_ml_mon, 
    apr.t02_aprob_cro_mon, 
    apr.t02_aprob_pre_mon, 
    apr.t02_obs_ml, 
    apr.t02_obs_cro, 
    apr.t02_obs_pre, 
    apr.t02_fch_ml_mon, 
    apr.t02_fch_cro_mon, 
    apr.t02_fch_pre_mon,
    
    tp.t02_gratificacion,
    tp.t02_porc_cts,
    tp.t02_porc_ess,
    tp.t02_porc_gast_func,
    tp.t02_porc_linea_base,
    tp.t02_porc_imprev,
    tp.t02_proc_gast_superv

FROM       t02_dg_proy p
LEFT JOIN t01_dir_inst i ON (p.t01_id_inst=i.t01_id_inst)
LEFT JOIN t02_proy_ctas cta ON (p.t02_cod_proy=cta.t02_cod_proy AND cta.est_audi=1)
LEFT JOIN t02_aprob_proy apr ON(p.t02_cod_proy=apr.t02_cod_proy)
LEFT JOIN t02_tasas_proy tp ON(p.t02_cod_proy=tp.t02_cod_proy AND p.t02_version = tp.t02_version)
WHERE p.t02_cod_proy = _proy 
AND p.t02_version=_vs ;     
END$$

DELIMITER ;



/* Actualicion del procedure para guardar nuevo proyecto con la nueva tasa */
DELIMITER $$

DROP PROCEDURE IF EXISTS `sp_ins_proyecto`$$

CREATE  PROCEDURE `sp_ins_proyecto`(IN _t02_nro_exp     VARCHAR(20) ,
                    IN _t00_cod_linea   INT,
                    IN _t01_id_inst     INT,
                    IN _t02_cod_proy    VARCHAR(10),
                    IN _t02_nom_proy    VARCHAR(250),
                    IN _t02_fch_apro    DATE,
                    IN _t02_estado      INT ,
                    IN _t02_fin     TEXT,
                    IN _t02_pro     TEXT,
                    IN _t02_ben_obj     VARCHAR(5000),
                    IN _t02_amb_geo     VARCHAR(5000),
                    IN _t02_moni_tema   INT,
                    IN _t02_moni_fina   INT,
                    IN _t02_moni_ext    VARCHAR(10),                    
                    IN _t02_sup_inst    INT,
                    IN _t02_dire_proy   VARCHAR(200),
                    IN _t02_ciud_proy   VARCHAR(50),
                    IN _t02_tele_proy    VARCHAR(30),
                    IN _t02_fax_proy    VARCHAR(30),
                    IN _t02_mail_proy   VARCHAR(50),
                    IN _t02_fch_isc     DATE,
                    IN _t02_fch_ire     DATE,
                    IN _t02_fch_tre     DATE,
                    IN _t02_fch_tam     DATE,   
                    IN _t02_num_mes     INT,
                    IN _t02_num_mes_amp INT,
                    IN _t02_sector      INT,
                    IN _t02_subsector   INT,
                    IN _t02_cre_fe      CHAR(1),
                    IN _t02_gratificacion       VARCHAR(10),
                    IN _t02_porc_cts        VARCHAR(10),
                    IN _t02_porc_ess        VARCHAR(10),
                    IN _t02_porc_gast_func      VARCHAR(10),
                    IN _t02_porc_linea_base     VARCHAR(10),
                    IN _t02_porc_imprev     VARCHAR(10),
		    IN _t02_proc_gast_superv     VARCHAR(10),			
                    IN _UserID      VARCHAR(20) )
trans1 : BEGIN                  
    DECLARE _msg        VARCHAR(100);
    DECLARE _existe     INT ;
    DECLARE _vs         INT DEFAULT 1;
    DECLARE _t02_fch_ini    DATE;
    DECLARE _fecha_ter  DATE;
    DECLARE _num_rows   INT ;
    DECLARE _numrows    INT ;
    DECLARE _fcredito   INT DEFAULT 200;
    SELECT COUNT(1)
    INTO _existe
    FROM t02_dg_proy
    WHERE t02_cod_proy=_t02_cod_proy AND t01_id_inst=_t01_id_inst;
    
  IF _existe > 0 THEN
      
    SELECT CONCAT('El proyecto esta registrado por el Supervidor de Proyectos ')
    INTO _msg; 
    SELECT 0 AS numrows,_t02_cod_proy AS codigo, _msg AS msg ;
    
   LEAVE trans1;
  END IF;
   
   
SET AUTOCOMMIT=0;
 START TRANSACTION ;
    
    /*establecer las fechas de inicio y termino para manejo del proyecto*/   
    SELECT _t02_fch_ire, (CASE WHEN IFNULL(DATEDIFF(_t02_fch_tre, _t02_fch_tam),0) <> 0 THEN _t02_fch_tam ELSE _t02_fch_tre END)
    INTO _t02_fch_ini, _fecha_ter;
   
   INSERT INTO t02_dg_proy 
    (
    t02_cod_proy, 
    t02_version, 
    t02_nro_exp,
    t00_cod_linea,
    t01_id_inst, 
    t02_nom_proy, 
    t02_fch_apro, 
    t02_fch_ini, 
    t02_fch_ter, 
    t02_fin, 
    t02_pro, 
    t02_ben_obj, 
    t02_amb_geo, 
    t02_moni_tema, 
    t02_moni_fina, 
    t02_moni_ext, 
    t02_sup_inst, 
    t02_dire_proy, 
    t02_ciud_proy, 
    t02_tele_proy, 
    t02_fax_proy, 
    t02_mail_proy, 
    t02_estado, 
    t02_sect_prod, 
    t02_subsect_prod, 
    t02_cre_fe, 
    t02_fch_isc, 
    t02_fch_ire, 
    t02_fch_tre, 
    t02_fch_tam, 
    t02_num_mes, 
    t02_num_mes_amp, 
    usr_crea, 
    fch_crea, 
    est_audi
    )
    VALUES
    (
    _t02_cod_proy, 
    _vs, 
    _t02_nro_exp,
    _t00_cod_linea,
    _t01_id_inst, 
    _t02_nom_proy, 
    _t02_fch_apro, 
    _t02_fch_ini, 
    _fecha_ter, 
    _t02_fin, 
    _t02_pro, 
    _t02_ben_obj, 
    _t02_amb_geo, 
    _t02_moni_tema, 
    _t02_moni_fina, 
    _t02_moni_ext, 
    _t02_sup_inst, 
    _t02_dire_proy, 
    _t02_ciud_proy, 
    _t02_tele_proy, 
    _t02_fax_proy, 
    _t02_mail_proy, 
    _t02_estado, 
    _t02_sector, 
    _t02_subsector, 
    _t02_cre_fe, 
    _t02_fch_isc, 
    _t02_fch_ire, 
    _t02_fch_tre, 
    _t02_fch_tam, 
    _t02_num_mes, 
    _t02_num_mes_amp,
    _UserID, 
    NOW(), 
    '1'
    );
    INSERT INTO t02_aprob_proy(t02_cod_proy, usu_crea, fch_crea) VALUES (_t02_cod_proy,_UserID, NOW());
    
    #
    # -------------------------------------------------->
    # DA 2.0 [23-10-2013 20:45]
    # Registramos en las tasas en la tabla t02_tasas_proy: 
    #
    INSERT INTO t02_tasas_proy (t02_cod_proy, t02_version, t02_gratificacion, t02_porc_cts, t02_porc_ess, 
            t02_porc_gast_func, t02_porc_linea_base, t02_porc_imprev, t02_proc_gast_superv ,usr_crea, fch_crea ) 
        VALUES ( _t02_cod_proy, _vs, _t02_gratificacion, _t02_porc_cts, _t02_porc_ess, 
            _t02_porc_gast_func, _t02_porc_linea_base, _t02_porc_imprev, _t02_proc_gast_superv, _UserID, now() );
    # --------------------------------------------------<
    
           
    SELECT ROW_COUNT() INTO _num_rows;
    
    CALL sp_calcula_anios_proy(_t02_cod_proy, _vs);
    
    SELECT COUNT(t02_sector)  INTO   _existe
      FROM t02_sector_prod  
     WHERE t02_cod_proy  = _t02_cod_proy
       AND t02_sector    = _t02_sector
       AND t02_subsec    = _t02_subsector;
    
    IF _existe <=0 THEN
      CALL sp_ins_sector_prod(_t02_cod_proy, _t02_sector, _t02_subsector, 'Principal', _UserID );
    END IF;
    #
    # -------------------------------------------------->
    # DA 2.0 [29-10-2013 22:57]
    # Correccion del valor del tercer y quinto parametro del procedimiento  sp_ins_fte_fin antes estaba vacio '',
    # ahora sera '0' porque en el campo t02_fuente_finan.t02_porc_def y t02_fuente_finan.t02_mto_financ son 
    # del tipo DOUBLE
    CALL sp_ins_fte_fin(_t02_cod_proy,'10','0','','0',_UserID,NOW());
    CALL sp_ins_fte_fin(_t02_cod_proy,'63','0','','0',_UserID,NOW());
    CALL sp_ins_fte_fin(_t02_cod_proy,_t01_id_inst,'0','','0',_UserID,NOW());
    # --------------------------------------------------<
    
    IF _t02_cre_fe='S' THEN 
	#
	# -------------------------------------------------->
	# DA 2.0 [29-10-2013 22:57]
	# Correccion del valor del tercer y quinto parametro del procedimiento  sp_ins_fte_fin antes estaba vacio '',
	# ahora sera '0' porque en el campo t02_fuente_finan.t02_porc_def y t02_fuente_finan.t02_mto_financ son 
	# del tipo DOUBLE
        CALL sp_ins_fte_fin(_t02_cod_proy,_fcredito,'0','','0',_UserID,NOW());
	# --------------------------------------------------<
    END IF; 
    
    SELECT ROW_COUNT() INTO _numrows;
  COMMIT ;
    
    SELECT _numrows  AS numrows, _cod_proy AS codigo, _msg AS msg ;
END$$

DELIMITER ;



/* Actualizacion de procedure para el editado de un proyecto con la nueva tasa*/
DELIMITER $$

DROP PROCEDURE IF EXISTS `sp_upd_proyecto`$$

CREATE PROCEDURE `sp_upd_proyecto`( IN _version INT,
                    IN _nro_exp VARCHAR(20) ,
                    IN _cod_linea INT,
                    IN _inst INT,
                    IN _cod_proy VARCHAR(10) ,
                    IN _nom_proy VARCHAR(250) ,
                    IN _fch_apro DATE,                                  
                    IN _estado INT,                                 
                    IN _fin TEXT ,
                    IN _pro TEXT,
                    IN _ben_obj VARCHAR(5000) ,
                    IN _amb_geo VARCHAR(5000) ,
                    IN _moni_tema INT,
                    IN _moni_fina INT,
                    IN _moni_ext VARCHAR(10) ,
                    IN _sup_inst INT,
                    IN _dire_proy VARCHAR(200),
                    IN _ciud_proy VARCHAR(50) ,                                 
                    IN _tele_proy VARCHAR(30) ,
                    IN _fax_proy VARCHAR(30) ,
                    IN _mail_proy VARCHAR(50) ,                                 
                    IN _t02_fch_isc  DATE ,
                    IN _t02_fch_ire  DATE ,
                    IN _t02_fch_tre  DATE ,
                    IN _t02_fch_tam  DATE ,
                    IN _t02_num_mes INT,    
                    IN _t02_num_mes_amp INT,                                
                    IN _sect_prod INT,
                    IN _subsect_prod INT,
                    IN _t02_cre_fe CHAR(1),
                    IN _t02_gratificacion       VARCHAR(10),
                    IN _t02_porc_cts        VARCHAR(10),
                    IN _t02_porc_ess        VARCHAR(10),
                    IN _t02_porc_gast_func      VARCHAR(10),
                    IN _t02_porc_linea_base     VARCHAR(10),
                    IN _t02_porc_imprev     VARCHAR(10),
                    IN _t02_proc_gast_superv     VARCHAR(10),
                    IN _usr VARCHAR(20))
BEGIN
    DECLARE _msg        VARCHAR(100);
    DECLARE _existe     INT ;
    DECLARE _fch_ini    DATE;
    DECLARE _fch_ter    DATE;
    DECLARE _num_rows   INT ;  
    DECLARE _numrows    INT ; 
    DECLARE _fcredito   INT DEFAULT 200;
 
 
SET AUTOCOMMIT=0;
 START TRANSACTION ;
 
    /*establecer las fechas de inicio y termino para manejo del proyecto*/   
    SELECT _t02_fch_ire, (CASE WHEN IFNULL(DATEDIFF(_t02_fch_tre, _t02_fch_tam),0) <> 0 THEN _t02_fch_tam ELSE _t02_fch_tre END)
    INTO _fch_ini, _fch_ter;
        
    UPDATE t02_dg_proy 
       SET
        t02_nro_exp = _nro_exp , 
        t00_cod_linea = _cod_linea , 
        t01_id_inst = _inst , 
        t02_nom_proy = _nom_proy , 
        t02_fch_apro = _fch_apro , 
        t02_fch_ini = _fch_ini , 
        t02_fch_ter = _fch_ter , 
        t02_fin     = _fin , 
        t02_pro     = _pro , 
        t02_ben_obj = _ben_obj , 
        t02_amb_geo = _amb_geo ,
        t02_cre_fe  = _t02_cre_fe, 
        t02_moni_tema = _moni_tema , 
        t02_moni_fina = _moni_fina , 
        t02_moni_ext = _moni_ext , 
        t02_sup_inst = _sup_inst , 
        t02_dire_proy = _dire_proy , 
        t02_ciud_proy = _ciud_proy , 
        t02_tele_proy = _tele_proy , 
        t02_fax_proy = _fax_proy , 
        t02_mail_proy = _mail_proy ,        
        t02_fch_isc = _t02_fch_isc ,
        t02_fch_ire = _t02_fch_ire ,
        t02_fch_tre = _t02_fch_tre ,
        t02_fch_tam = _t02_fch_tam ,
        t02_num_mes = _t02_num_mes ,
        t02_num_mes_amp = _t02_num_mes_amp ,
        t02_estado = _estado , 
        t02_sect_prod = _sect_prod , 
        t02_subsect_prod = _subsect_prod , 
        usr_actu = _usr , 
        fch_actu = NOW()                    
    WHERE t02_cod_proy = _cod_proy 
      AND t02_version = _version ;
    SELECT ROW_COUNT() INTO _num_rows;
    
    #
    # -------------------------------------------------->
    # DA 2.0 [23-10-2013 20:45]
    # Registramos en las tasas en la tabla t02_tasas_proy: 
    #
    UPDATE t02_tasas_proy SET  
        t02_gratificacion = _t02_gratificacion,
        t02_porc_cts = _t02_porc_cts,
        t02_porc_ess = _t02_porc_ess,
        t02_porc_gast_func = _t02_porc_gast_func, 
        t02_porc_linea_base = _t02_porc_linea_base, 
        t02_porc_imprev = _t02_porc_imprev,
        t02_proc_gast_superv = _t02_proc_gast_superv,
        usr_actu = _usr,
        fch_actu = NOW()
    WHERE t02_cod_proy = _cod_proy AND t02_version = _version;
    # --------------------------------------------------<
    
    CALL sp_calcula_anios_proy(_cod_proy, _version);
    
    SELECT COUNT(t02_sector)  INTO   _existe
      FROM t02_sector_prod  
     WHERE t02_cod_proy  = _cod_proy
       AND t02_sector    = _sect_prod
       AND t02_subsec    = _subsect_prod;
    
    IF _existe <=0 THEN
      CALL sp_ins_sector_prod(_cod_proy, _sect_prod, _subsect_prod, 'Principal', _usr );
    END IF;
    
    IF _t02_cre_fe='S' THEN 
      CALL sp_ins_fte_fin(_cod_proy,_fcredito,'','','',_usr,NOW());
    END IF;     
    
 COMMIT ;
    SELECT _num_rows  AS numrows, _cod_proy AS codigo, _msg AS msg ;
END$$

DELIMITER ;



/* Actualizacion en el borrado del proyecto */
DELIMITER $$

DROP PROCEDURE IF EXISTS  `sp_delete_proy`$$

CREATE  PROCEDURE `sp_delete_proy`(IN _proy VARCHAR(10), IN _vs INT)
BEGIN
declare numrows int;
DELETE from t09_act WHERE t09_act.t02_cod_proy = _proy;
DELETE from t08_comp WHERE t08_comp.t02_cod_proy = _proy;
DELETE from t02_dg_proy WHERE t02_dg_proy.t02_cod_proy = _proy;
#
# -------------------------------------------------->
# DA 2.0 [08-11-2013 11:45]
# Eliminamos datos tambien de las tasas del proyecto. 
#
DELETE from t02_tasas_proy WHERE t02_tasas_proy.t02_cod_proy = _proy;
# --------------------------------------------------<
DELETE from t02_fuente_finan WHERE t02_fuente_finan.t02_cod_proy = _proy;
DELETE from t02_aprob_proy WHERE t02_aprob_proy.t02_cod_proy = _proy;
DELETE from t02_sector_prod WHERE t02_sector_prod.t02_cod_proy = _proy;
DELETE from t02_carta_fianza WHERE t02_carta_fianza.t02_cod_proy = _proy;
DELETE from t02_duracion WHERE t02_duracion.t02_cod_proy = _proy;
DELETE from t02_noobjecion_compra WHERE t02_noobjecion_compra.t02_cod_proy = _proy;
DELETE from t02_noobjecion_compra_anx WHERE t02_noobjecion_compra_anx.t02_cod_proy = _proy;
DELETE from t02_poa WHERE t02_poa.t02_cod_proy = _proy;
DELETE from t02_poa_anexos WHERE t02_poa_anexos.t02_cod_proy = _proy;
DELETE from t02_proy_anx WHERE t02_proy_anx.t02_cod_proy = _proy;
DELETE from t02_proy_ctas WHERE t02_proy_ctas.t02_cod_proy = _proy;
DELETE from t02_proy_version WHERE t02_proy_version.t02_cod_proy = _proy;
DELETE from t03_dist_proy WHERE t03_dist_proy.t02_cod_proy = _proy;
DELETE from t03_mp_equi WHERE t03_mp_equi.t02_cod_proy = _proy;
DELETE from t03_mp_equi_ftes WHERE t03_mp_equi_ftes.t02_cod_proy = _proy;
DELETE from t03_mp_equi_metas WHERE t03_mp_equi_metas.t02_cod_proy = _proy;
DELETE from t03_mp_gas_adm WHERE t03_mp_gas_adm.t02_cod_proy = _proy;
DELETE from t03_mp_gas_fun_cost WHERE t03_mp_gas_fun_cost.t02_cod_proy = _proy;
DELETE from t03_mp_gas_fun_ftes WHERE t03_mp_gas_fun_ftes.t02_cod_proy = _proy;
DELETE from t03_mp_gas_fun_metas WHERE t03_mp_gas_fun_metas.t02_cod_proy = _proy;
DELETE from t03_mp_gas_fun_part WHERE t03_mp_gas_fun_part.t02_cod_proy = _proy;
DELETE from t03_mp_imprevistos WHERE t03_mp_imprevistos.t02_cod_proy = _proy;
DELETE from t03_mp_linea_base WHERE t03_mp_linea_base.t02_cod_proy = _proy;
DELETE from t03_mp_per WHERE t03_mp_per.t02_cod_proy = _proy;
DELETE from t03_mp_per_ftes WHERE t03_mp_per_ftes.t02_cod_proy = _proy;
DELETE from t03_mp_per_metas WHERE t03_mp_per_metas.t02_cod_proy = _proy;
DELETE from t04_equi_proy WHERE t04_equi_proy.t02_cod_proy = _proy;
DELETE from t04_sol_cambio_per WHERE t04_sol_cambio_per.t02_cod_proy = _proy;
DELETE from t06_fin_ind WHERE t06_fin_ind.t02_cod_proy = _proy;
DELETE from t06_fin_sup WHERE t06_fin_sup.t02_cod_proy = _proy;
DELETE from t07_prop_ind WHERE t07_prop_ind.t02_cod_proy = _proy;
DELETE from t07_prop_ind_inf WHERE t07_prop_ind_inf.t02_cod_proy = _proy;
DELETE from t07_prop_sup WHERE t07_prop_sup.t02_cod_proy = _proy;
DELETE from t08_comp_ind WHERE t08_comp_ind.t02_cod_proy = _proy;
DELETE from t08_comp_ind_inf WHERE t08_comp_ind_inf.t02_cod_proy = _proy;
DELETE from t08_comp_ind_inf_me WHERE t08_comp_ind_inf_me.t02_cod_proy = _proy;
DELETE from t08_comp_ind_inf_mi WHERE t08_comp_ind_inf_mi.t02_cod_proy = _proy;
DELETE from t08_comp_sup WHERE t08_comp_sup.t02_cod_proy = _proy;
DELETE from t09_act_ind WHERE t09_act_ind.t02_cod_proy = _proy;
DELETE from t09_act_ind_inf_me WHERE t09_act_ind_inf_me.t02_cod_proy = _proy;
DELETE from t09_act_ind_inf_mi WHERE t09_act_ind_inf_mi.t02_cod_proy = _proy;
DELETE from t09_act_ind_mtas WHERE t09_act_ind_mtas.t02_cod_proy = _proy;
DELETE from t09_act_ind_mtas_inf WHERE t09_act_ind_mtas_inf.t02_cod_proy = _proy;
DELETE from t09_act_sub_mtas_inf WHERE t09_act_sub_mtas_inf.t02_cod_proy = _proy;
DELETE from t09_act_sub_mtas_inf_me WHERE t09_act_sub_mtas_inf_me.t02_cod_proy = _proy;
DELETE from t09_act_sub_mtas_inf_mi WHERE t09_act_sub_mtas_inf_mi.t02_cod_proy = _proy;
DELETE from t09_sub_act_mtas WHERE t09_sub_act_mtas.t02_cod_proy = _proy;
DELETE from t09_sub_act_plan WHERE t09_sub_act_plan.t02_cod_proy = _proy;
DELETE from t09_subact WHERE t09_subact.t02_cod_proy = _proy;
DELETE from t10_cost_fte WHERE t10_cost_fte.t02_cod_proy = _proy;
DELETE from t10_cost_sub WHERE t10_cost_sub.t02_cod_proy = _proy;
DELETE from t11_bco_bene WHERE t11_bco_bene.t02_cod_proy = _proy;
DELETE from t12_plan_at WHERE t12_plan_at.t02_cod_proy = _proy;
DELETE from t12_plan_capac WHERE t12_plan_capac.t02_cod_proy = _proy;
DELETE from t12_plan_capac_tema WHERE t12_plan_capac_tema.t02_cod_proy = _proy;
DELETE from t12_plan_cred WHERE t12_plan_cred.t02_cod_proy = _proy;
DELETE from t12_plan_cred_benef WHERE t12_plan_cred_benef.t02_cod_proy = _proy;
DELETE from t12_plan_otros WHERE t12_plan_otros.t02_cod_proy = _proy;
DELETE from t20_inf_mes WHERE t20_inf_mes.t02_cod_proy = _proy;
DELETE from t20_inf_mes_anx WHERE t20_inf_mes_anx.t02_cod_proy = _proy;
DELETE from t20_inf_mes_prob WHERE t20_inf_mes_prob.t02_cod_proy = _proy;
DELETE from t25_inf_trim WHERE t25_inf_trim.t02_cod_proy = _proy;
DELETE from t25_inf_trim_anx WHERE t25_inf_trim_anx.t02_cod_proy = _proy;
DELETE from t25_inf_trim_at WHERE t25_inf_trim_at.t02_cod_proy = _proy;
DELETE from t25_inf_trim_capac WHERE t25_inf_trim_capac.t02_cod_proy = _proy;
DELETE from t25_inf_trim_cred WHERE t25_inf_trim_cred.t02_cod_proy = _proy;
DELETE from t25_inf_trim_otros WHERE t25_inf_trim_otros.t02_cod_proy = _proy;
DELETE from t30_inf_me WHERE t30_inf_me.t02_cod_proy = _proy;
DELETE from t30_inf_me_anexos WHERE t30_inf_me_anexos.t02_cod_proy = _proy;
DELETE from t31_plan_me WHERE t31_plan_me.t02_cod_proy = _proy;
DELETE from t31_plan_me_aprob WHERE t31_plan_me_aprob.t02_cod_proy = _proy;
DELETE from t32_plan_act WHERE t32_plan_act.t02_cod_proy = _proy;
DELETE from t32_plan_vta WHERE t32_plan_vta.t02_cod_proy = _proy;
DELETE from t40_inf_financ WHERE t40_inf_financ.t02_cod_proy = _proy;
DELETE from t40_inf_financ_anx WHERE t40_inf_financ_anx.t02_cod_proy = _proy;
DELETE from t41_inf_financ_gasto WHERE t41_inf_financ_gasto.t02_cod_proy = _proy;
DELETE from t42_inf_financ_gasto_det WHERE t42_inf_financ_gasto_det.t02_cod_proy = _proy;
DELETE from t45_inf_mi WHERE t45_inf_mi.t02_cod_proy = _proy;
DELETE from t45_inf_mi_anexos WHERE t45_inf_mi_anexos.t02_cod_proy = _proy;
DELETE from t45_inf_mi_subact WHERE t45_inf_mi_subact.t02_cod_proy = _proy;
DELETE from t46_cron_visita_mi WHERE t46_cron_visita_mi.t02_cod_proy = _proy;
DELETE from t50_equiv_codis WHERE t50_equiv_codis.t02_cod_proy = _proy;
DELETE from t50_plan_moni_ext WHERE t50_plan_moni_ext.t02_cod_proy = _proy;
DELETE from t51_inf_mf WHERE t51_inf_mf.t02_cod_proy = _proy;
DELETE from t51_inf_mf_anexos WHERE t51_inf_mf_anexos.t02_cod_proy = _proy;
DELETE from t51_inf_mf_avance_meta WHERE t51_inf_mf_avance_meta.t02_cod_proy = _proy;
DELETE from t51_inf_mf_avance_monto WHERE t51_inf_mf_avance_monto.t02_cod_proy = _proy;
DELETE from t51_inf_mf_docs WHERE t51_inf_mf_docs.t02_cod_proy = _proy;
DELETE from t51_inf_mf_gastos_no_aceptados WHERE t51_inf_mf_gastos_no_aceptados.t02_cod_proy = _proy;
DELETE from t51_inf_mf_observa WHERE t51_inf_mf_observa.t02_cod_proy = _proy;
DELETE from t52_inf_visita_mf WHERE t52_inf_visita_mf.t02_cod_proy = _proy;
DELETE from t52_inf_visita_mf_anexos WHERE t52_inf_visita_mf_anexos.t02_cod_proy = _proy;
DELETE from t55_inf_unico_anual WHERE t55_inf_unico_anual.t02_cod_proy = _proy;
DELETE from t55_inf_unico_anual_avance_meta WHERE t55_inf_unico_anual_avance_meta.t02_cod_proy = _proy;
DELETE from t55_inf_unico_anual_avance_presup WHERE t55_inf_unico_anual_avance_presup.t02_cod_proy = _proy;
DELETE from t59_aprob_primer_desemb WHERE t59_aprob_primer_desemb.t02_cod_proy = _proy;
DELETE from t60_aprobacion_desemb WHERE t60_aprobacion_desemb.t02_cod_proy = _proy;
DELETE from t60_desembolsos WHERE t60_desembolsos.t02_cod_proy = _proy;
DELETE from t60_ejecucion_desemb WHERE t60_ejecucion_desemb.t02_cod_proy = _proy;
DELETE from t60_ejecucion_desemb_me WHERE t60_ejecucion_desemb_me.t02_cod_proy = _proy;
DELETE from adm_usuarios WHERE adm_usuarios.t02_cod_proy = _proy;
set numrows = 1;
SELECT numrows;
END$$

DELIMITER ;





