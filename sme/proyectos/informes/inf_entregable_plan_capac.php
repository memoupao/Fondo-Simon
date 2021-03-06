<?php
/**
 * CticServices
 *
 * Permite la edición del Plan de Capacitación para el Informe de Entregable
 *
 * @package     sme/proyectos/informes
 * @author      AQ
 * @since       Version 2.0
 *
 */
include("../../../includes/constantes.inc.php");
include("../../../includes/validauser.inc.php");
require_once (constant("PATH_CLASS") . "BLBene.class.php");
require_once (constant('PATH_CLASS') . "BLTablasAux.class.php");

error_reporting("E_PARSE");
$idProy = $objFunc->__Request('idProy');
$idVersion = $objFunc->__Request('idVersion');
$anio = $objFunc->__Request('anio');
$idEntregable = $objFunc->__Request('idEntregable');
$idVersion = $objFunc->__Request('idVersion');
$dpto = $objFunc->__Request('dpto');
$prov = $objFunc->__Request('prov');
$dist = $objFunc->__Request('dist');
$case = $objFunc->__Request('case');

if ($idProy == "") {
    ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=charset=utf-8" />
    <title>Plan de Capacitación</title>
    <script language="javascript" type="text/javascript" src="../../../jquery.ui-1.5.2/jquery-1.2.6.js"></script>
    <link href="../../../css/itemplate.css" rel="stylesheet" type="text/css" media="all" />
</head>
<body>
	<form id="frmMain" name="frmMain" method="post" action="#">
<?php
}
?>
        <table width="1000" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<th width="60%">
				    <b>Avance en Capacitaciones de los Beneficiarios</b>
			    </th>
			    <th width="35%" rowspan="2">
				    <button onclick="Guardar_PlanCapacita(); return false;" class="boton">Guardar</button>
				    <button onclick="LoadPlanCapacList(); return false;" class="boton">Refrescar</button>
				    <button onclick="ExportPlanesCapacitacion(); return false;" class="boton">Exportar</button>
			    </th>
			</tr>
			<tr>
				<th colspan="2">
					<table width="300" border="0" cellspacing="2" class="TableEditReg">
						<tr>
							<td>&nbsp;</td>
							<td align="center">Departamento</td>
							<td align="center">Provincia</td>
							<td align="center">Distrito</td>
							<td align="center">Caserio</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>
							    <select name="cbodpto" id="cbodpto" style="width: 120px;"
								onchange="LoadProv();" class="PlanCapacitacion PlanCapacList cmbnormal">
                                <?php
                                $objBene = new BLBene();
                                $rsDpto = $objBene->ListaUbigeoDpto($idProy);
                                $dpto1 = $objFunc->llenarComboI($rsDpto, 'iddpto', 'dpto', $dpto);
                                if ($dpto1 != $dpto) {
                                    $dpto = $dpto1;
                                }
                                ?>
                            	</select>
                        	</td>
							<td>
							    <select name="cboprov" id="cboprov" class="PlanCapacitacion PlanCapacList cmbnormal">
									<option value="" selected="selected"></option>
                                    	<?php
                                        $objBene = new BLBene();
                                        $rsDpto = $objBene->ListaUbigeoProv($idProy, $dpto);
                                        $prov1 = $objFunc->llenarComboI($rsDpto, 'idprov', 'prov', $prov);
                                        ?>
                                </select></td>
							<td>
							    <select name="cbodist" id="cbodist" class="PlanCapacitacion PlanCapacList cmbnormal">
									<option value="" selected="selected"></option>
                                      	<?php
                                        $objTablas = new BLTablasAux();
                                        $rsProv = $objTablas->ListaDistritos($dpto, $prov);
                                        $objFunc->llenarComboI($rsProv, 'codigo', 'descripcion', $dist);
                                        ?>
        	                    </select>
    	                    </td>
							<td>
							    <select name="cbocase" id="cbocase" class="PlanCapacitacion PlanCapacList cmbnormal">
									<option value="" selected="selected"></option>
        	                        <?php
                                        $rsCase = $objTablas->ListaCaserios($dpto, $prov, $dist);
                                        $objFunc->llenarComboI($rsCase, 'codigo', 'descripcion', $case);
                                    ?>
        	                    </select>
    	                    </td>
						</tr>
					</table>
				</th>
			</tr>
		</table>

		<div class="TableGrid" id='PlanCapacTableGrid' style="overflow: auto; max-width: 880px; max-height: 350px;"></div>

		<input type="hidden" name="idProy" value="<?php echo($idProy);?>" class="PlanCapacitacion PlanCapacList" />
		<input type="hidden" name="idVersion" value="<?php echo($idVersion);?>" class="PlanCapacitacion PlanCapacList" />
		<input type="hidden" name="anio" value="<?php echo($anio);?>" class="PlanCapacitacion PlanCapacList" />
		<input type="hidden" name="idEntregable" value="<?php echo($idEntregable);?>" class="PlanCapacitacion PlanCapacList" />

		<script language="javascript">
	    $(document).ready(function(){
	        LoadPlanCapacList();
    		$('#cbodpto').change(function(pEvent) {
    			LoadPlanCapacList();
    			LoadProv();
    		});

    		$('#cboprov').change(function(pEvent) {
    			LoadPlanCapacList();
    			if ($(pEvent.target).val()) {
    				LoadDist();
    			}
    			else {
    				$('#cbodist').html('');
    				$('#cbocase').html('');
    			}
    		});

    		$('#cbodist').change(function(pEvent) {
    			LoadPlanCapacList();
    			if ($(pEvent.target).val())
    				LoadCase();
    			else
    				$('#cbocase').html('');
    		});

    		$('#cbocase').change(function(pEvent) {
    			LoadPlanCapacList();
    		});
    	});

    	function LoadPlanCapacList()
    	{
    		var aQueryString = $('.PlanCapacList').serialize();
    		$('#PlanCapacTableGrid').html("<p align='center'><img src='../../../img/indicator.gif' width='16' height='16' /><br>Cargando..<br></p>")
    								.load('inf_entregable_plan_capac_list.php?' + aQueryString);
    	}

        function ActivarPlanCapac(subact)
        {
        	$('.PlanCapacitacion:input[subact="'+subact+'"]').each( function(i) {
                var iTxt = document.getElementsByName("txt_"+subact+"[]")[i];
                if(iTxt.className=="PlanCapacitacion")
                { iTxt.value = (this.checked ? "1" : "0"); }
            } ) ;
        }

        function LoadProv()
        {
        	var BodyForm = "idproy=<?php echo($idProy);?>&dpto=" + $('#cbodpto').val();
        	var sURL = "../anexos/amb_geo_process.php?action=<?php echo(md5("lista_provincias"))?>" ;
        	$('#cboprov').html('<option value=""> Cargando ... </option>');
        	$('#cbodist').html('');
        	var req = Spry.Utils.loadURL("POST", sURL, true, ProvSuccessCallback, { postData: BodyForm, headers: { "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8" }, errorCallback: MyErrorCallback });
        }

        function ProvSuccessCallback(req)
        {
            var respuesta = req.xhRequest.responseText;
            $('#cboprov').html(respuesta);

            if($("#cboprov").val()=="") {
                $('#cboprov').focus();
            }
            else {
                LoadDist();
            }
        }

        function LoadDist()
        {
        	var BodyForm = "idproy=<?php echo($idProy);?>&dpto=" + $('#cbodpto').val() + "&prov=" + $('#cboprov').val() ;
        	var sURL = "../anexos/amb_geo_process.php?action=<?php echo(md5("lista_distritos"))?>" ;
        	$('#cbodist').html('<option value=""> Cargando ... </option>');
        	var req = Spry.Utils.loadURL("POST", sURL, true, DistSuccessCallback, { postData: BodyForm, headers: { "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8" }, errorCallback: MyErrorCallback });
        }

        function DistSuccessCallback(req)
        {
            var respuesta = req.xhRequest.responseText;
            $('#cbodist').html(respuesta);

            if($("#cbodist").val()=="")
            {
                $('#cboprov').focus();
            }
            else
            {
                LoadCase();
            }

            $('#cbodist').focus();
        }

        function LoadCase()
        {
        	var BodyForm = "idproy=<?php echo($idProy);?>&dpto=" + $('#cbodpto').val() + "&prov=" + $('#cboprov').val()+ "&dist=" + $('#cbodist').val() ;
        	var sURL = "../anexos/amb_geo_process.php?action=<?php echo(md5("lista_caserios"))?>" ;
        	$('#cbocase').html('<option value=""> Cargando ... </option>');
        	var req = Spry.Utils.loadURL("POST", sURL, true, CaseSuccessCallback, { postData: BodyForm, headers: { "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8" }, errorCallback: MyErrorCallback });
        }

        function CaseSuccessCallback(req)
        {
            var respuesta = req.xhRequest.responseText;
            $('#cbocase').html(respuesta);
            $('#cbocase').focus();
        }

        function Guardar_PlanCapacita()
        {
            <?php $ObjSession->AuthorizedPage(); ?>

            var BodyForm=$("#FormData .PlanCapacitacion").serialize();
            if(confirm("Estas seguro de Guardar el avance en Capacitación?"))
            {
                var sURL = "inf_entregable_process.php?action=<?php echo(md5('save_plan_capac'));?>";
                var req = Spry.Utils.loadURL("POST", sURL, true, PlanCapacSuccessCallback, { postData: BodyForm, headers: { "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8" }, errorCallback: MyErrorCallback });
            }
        }

        function PlanCapacSuccessCallback(req)
        {
            var respuesta = req.xhRequest.responseText;
            respuesta = respuesta.replace(/^\s*|\s*$/g,"");
            var ret = respuesta.substring(0,5);

            if(ret=="Exito")
            {
                alert(respuesta.replace(ret,""));
                LoadPlanCapacList();
            }
            else
            {alert(respuesta);}
        }

        function ExportPlanesCapacitacion()
        {
        	var params = "&idProy=<?php echo($idProy);?>&anio=<?php echo($anio);?>&idEntregable=<?php echo($idEntregable);?>";
        	var url = "<?php echo(constant("PATH_RPT"))?>reportviewer.php?ReportID=44" + params;
        	var win =  window.open(url, "wrpt_plancapac", "fullscreen,scrollbars");
            win.focus();

        }
        function ExportPlanesCapacitacion2()
        {
        	//var params = "&idProy=<?php echo($idProy);?>&anio=<?php echo($anio);?>&idEntregable=<?php echo($idEntregable);?>";
        	//var url = "<?php echo(constant("PATH_RPT"))?>reportviewer.php?ReportID=60" + params;
        	//var win =  window.open(url, "wrpt_plancapac", "fullscreen,scrollbars");
            //win.focus();
        }
        </script>

		<fieldset style="color: navy; display: none;">
			<legend class="nota">Opciones</legend>
			<b>C</b> : Capacitado &nbsp;&nbsp;|&nbsp;&nbsp;
			<b>P</b> : En Proceso &nbsp;&nbsp;|&nbsp;&nbsp;
			<b>R</b> : Retirado <br />
			<span class="nota">Colocar en los cuadros de Texto sólo	una de las 3 opciones, cuaquier otro valor, no sera tomado en cuenta.</span>
		</fieldset>

<?php if($idProy=="") { ?>
</form>
</body>
</html>
<?php } ?>