<?php include("../../includes/constantes.inc.php"); ?>
<?php include("../../includes/validauser.inc.php"); ?>
<?php

$NoInclude = true;
require_once (constant("PATH_CLASS") . "BLTablasAux.class.php");
require_once (constant("PATH_CLASS") . "BLEjecutor.class.php");
$objTablas = new BLTablasAux();
$objEjec = new BLEjecutor();

?>
<?php if(!$NoInclude) { ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<!-- InstanceBegin template="/Templates/tempFilterReports.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type"
	content="text/html; charset=charset=utf-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>REPORTES</title>
<!-- InstanceEndEditable -->
<script language="javascript" type="text/javascript"
	src="../../jquery.ui-1.5.2/jquery-1.2.6.js"></script>
<link href="../../css/reportes.css" rel="stylesheet" type="text/css"
	media="all" />
<!-- InstanceBeginEditable name="head" -->
<!-- InstanceEndEditable -->
</head>

<body>
	<form id="frmMain" name="frmMain" method="post" action="#">
<?php } ?>
<!-- InstanceBeginEditable name="BodyAjax" -->
		<style>
.Filter {
	font-size: 10px;
	font: Arial, Helvetica, sans-serif;
	padding: 3px;
	overflow: hidden;
}

.Filter fieldset {
	border: 1px solid #2A3F55;
}

.Filter fieldset legend {
	color: #2A3F55;
	font-weight: bold;
}

.Filter select {
	font-size: 10px;
	color: navy;
	font-weight: normal;
}

.Filter .Field {
	color: #000080;
	font-weight: bold;
	font-size: 11px;
	padding: 4px;
}

.Filter input,textarea {
	font-size: 11px;
	color: navy;
	font-weight: normal;
	border: 1px solid #2A3F00;
}

.Filter input:focus,textarea:focus {
	background-color: #FCFDD5;
}

.Filter .Button {
	padding: 2px;
	padding-bottom: 3px;
	padding-top: 3px;
	padding-left: 8px;
	padding-right: 8px;
	background-color: #EEE;
	border: solid 1px #999;
	cursor: pointer;
}
</style>

		<div id="divBodyAjax" class="Filter">
			<fieldset>
				<legend>Busqueda de Proyectos</legend>
				<table width="90%" cellpadding="0" cellspacing="0">
					<thead>
					</thead>
					<tbody>
						<tr>
							<td width="149" align="left" valign="middle" class="Field">Concurso<br /></td>
							<td width="96" align="left" valign="middle"><select
								name="cboConcurso" id="cboConcurso" style="width: 60px;"
								class="filterparams">
									<option value="*" selected="selected">Todos</option>
          <?php
        $rs = $objTablas->ListaConcursosActivos();
        $objFunc->llenarComboI($rs, 'codigo', 'abreviatura', $objFunc->__Request("cboConcurso"));
        ?>
          </select></td>
							<td width="10" align="left" valign="middle">&nbsp;</td>
							<td width="95" align="left" valign="middle" class="Field">&nbsp;</td>
							<td width="77" align="left" valign="middle">&nbsp;</td>
							<td width="4" align="left" valign="middle">&nbsp;</td>
							<td width="676" rowspan="2" valign="middle">
								<button class="Button" onclick="NuevoReporte(); return false;"
									value="Nuevo">Buscar</button>
							</td>
						</tr>
						<tr>
							<td height="29" align="left" valign="middle" nowrap="nowrap"
								class="Field">Institución Ejecutora<br /></td>
							<td colspan="4" align="left" valign="middle"><select
								name="cboEjecutor" id="cboEjecutor" style="width: 240px;"
								class="filterparams">
									<option value="0">Todos</option>
          <?php
        $rs = $objEjec->ListaInstitucionesEjecutoras();
        $objFunc->llenarComboI($rs, 't01_id_inst', 't01_sig_inst', $objFunc->__Request("cboEjecutor"));
        ?>
        </select></td>
							<td align="left" valign="middle">&nbsp;</td>
						</tr>
						<tr>
							<td align="left" valign="middle" nowrap="nowrap" class="Field">Periodo
								Desembolso</td>
							<td colspan="6" align="left" valign="middle"><select
								name="cboMesIni" id="cboMesIni" style="width: 80px;"
								class="filterparams">
      <?php
    $rs = $objTablas->ListadoMesesCalendario();
    $objFunc->llenarCombo($rs, 'codigo', 'descripcion', $objFunc->__Request("cboMesIni"));
    ?>
      </select> <input name="txtanioini" type="text"
								class="filterparams" id="txtanioini" style="text-align: center;"
								value="<?php echo $objFunc->__Request('txtanioini'); ?>"
								size="6" maxlength="4" /> &nbsp; <strong class="Field">Hasta</strong>
								<select name="cboMesFin" id="cboMesFin" style="width: 80px;"
								class="filterparams">
         <?php
        $rs = $objTablas->ListadoMesesCalendario();
        $objFunc->llenarCombo($rs, 'codigo', 'descripcion', $objFunc->__Request("cboMesFin"));
        ?>
		</select> <input name="txtaniofin" type="text" class="filterparams"
								id="txtaniofin" style="text-align: center;"
								value="<?php echo $objFunc->__Request('txtaniofin'); ?>"
								size="6" maxlength="4" /></td>
						</tr>
					</tbody>
					<tfoot>
					</tfoot>
				</table>

			</fieldset>

			<script language="JavaScript" type="text/javascript">
function NuevoReporte()
{
	var params = $(".filterparams").serialize();
	var sID = "<?php echo($objFunc->__Request('ReportID'));?>" ;
	showReport(sID, params);
}

function Buscarproyectos()
{	try
	{ChangeStylePopup("PopupDialog");}
	catch(e)
	{}
	
	var pagina = document.URL;
	var viewer = "reportviewer.php";
	var ret = pagina.search(viewer);
	
	var arrayControls = new Array();
		arrayControls[0] = "ctrl_idinst=txtidInst";
		arrayControls[1] = "ctrl_idproy=txtCodProy";
		arrayControls[2] = "ctrl_idversion=cboversion";
		arrayControls[3] = "ctrl_ejecutor=txtNomejecutor";
		arrayControls[4] = "ctrl_proyecto=txtNomproyecto";
		
	var params = "?" + arrayControls.join("&"); 
	var sUrl = "<?php echo(constant("DOCS_PATH"));?>sme/proyectos/datos/lista_proyectos.php" + params;
	
	if(ret < 0)
	{
		window.open(sUrl,"BuscaProy", "width=550, height=400,menubar=no, scrollbars=yes, location=no, resizable=no, status=no",true);
	}
	else
	{
		var sUrl = "<?php echo(constant("DOCS_PATH"));?>sme/proyectos/datos/lista_proyectos.php" + params;
		var vhtml="<iframe id='ifrmBuscarproy' src='"+sUrl+"' style='width:100%; height:430px;' frameborder='0' scrollbars='0'></iframe>";
		spryPopupFilter.displayPopupDialog(true);
		
		$('#spanTitle').html('Busqueda de Proyectos');
		
		if($('#divPopupText').html()!=vhtml)
		{
    		$('#divPopupText').html($('#divCargando').html());
			$('#divPopupText').html(vhtml);
		}
    	//var req = Spry.Utils.loadURL("POST", url, true, SuccessLoadFilter, { postData: BodyForm, headers: { "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8" }, errorCallback: onErrorLoadFilter });
	}
}

function HideBusqueda()
{
	spryPopupFilter.displayPopupDialog(false);

}


function CargarPeriodoActual()
{
	
	if("<?php echo($objFunc->__Request("cboMesIni"));?>"=="") {	$("#cboMesIni").val("<?php echo($objFunc->MesActual());?>"); 	}
	if("<?php echo($objFunc->__Request("cboMesFin"));?>"=="") {	$("#cboMesFin").val("<?php echo($objFunc->MesActual());?>"); 	}
	if("<?php echo($objFunc->__Request("txtanioini"));?>"=="") {$("#txtanioini").val("<?php echo($objFunc->AnioActual());?>"); 	}
	if("<?php echo($objFunc->__Request("txtaniofin"));?>"=="") {$("#txtaniofin").val("<?php echo($objFunc->AnioActual());?>"); 	}
}

CargarPeriodoActual();

</script>
		</div>
		<!-- InstanceEndEditable -->
<?php if(!$NoInclude) { ?>
</form>
</body>
<!-- InstanceEnd -->
</html>
<?php } ?>