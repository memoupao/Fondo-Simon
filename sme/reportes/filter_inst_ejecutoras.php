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
				<legend>Busqueda de Instituciones</legend>
				<table width="90%" cellpadding="0" cellspacing="0">
					<thead>
					</thead>
					<tbody>
						<tr>
							<td width="178" align="left" valign="middle" class="Field">Concurso<br /></td>
							<td width="130" align="left" valign="middle"><select
								name="cboConcurso" id="cboConcurso" style="width: 60px;"
								class="filterparams">
									<option value="*" selected="selected">Todos</option>
          <?php
        $rs = $objTablas->ListaConcursosActivos();
        $objFunc->llenarComboI($rs, 'codigo', 'abreviatura', $objFunc->__Request("cboConcurso"));
        ?>
          </select></td>
							<td width="17" align="left" valign="middle">&nbsp;</td>
							<td width="537" rowspan="2" valign="middle">
								<button class="Button" onclick="NuevoReporte(); return false;"
									value="Nuevo">Buscar</button>
							</td>
						</tr>
						<tr>
							<td align="left" valign="middle"><span class="Field">Región</span>
							
							<td align="left" valign="middle"><select name="region"
								id="region" style="width: 130px" class="filterparams">
									<option value="*">Todos</option>
		 <?php
$objTablas = new BLTablasAux();
$rsDpto = $objTablas->ListaDepartamentos();
$objFunc->llenarComboI($rsDpto, 'codigo', 'descripcion', $dpto);
?>
      </select>
							
							<td align="left" valign="middle">
							
							<td width="1"></td>
							<td width="4" align="left" valign="middle">&nbsp;</td>
						</tr>
						<tr>
							<td align="left" valign="middle"><span class="Field">Sector
									Productivo</span>
							
							<td align="left" valign="middle"><select name="sector"
								id="sector" style="width: 130px" class="filterparams">
									<option value="*">Todos</option>
		<?php
$rsSectores = $objTablas->SectoresProductivos();
$objFunc->llenarCombo($rsSectores, 'codigo', 'descripcion', $t02_sector);
?>
      </select>
							
							<td align="left" valign="middle">
							
							<td width="1"></td>
							<td width="4" align="left" valign="middle">&nbsp;</td>
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




</script>
		</div>
		<!-- InstanceEndEditable -->
<?php if(!$NoInclude) { ?>
</form>
</body>
<!-- InstanceEnd -->
</html>
<?php } ?>