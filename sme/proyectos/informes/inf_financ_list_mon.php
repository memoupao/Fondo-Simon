<?php include("../../../includes/constantes.inc.php"); ?>
<?php include("../../../includes/validauser.inc.php"); ?>
<?php require_once(constant("PATH_CLASS")."HardCode.class.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<!-- InstanceBegin template="/Templates/tplMainLista.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<!-- InstanceBeginEditable name="doctitle" -->
<?php

$objFunc->SetTitle("Informe Financiero del Ejecutor - Proyectos");
$objFunc->SetSubTitle("Revisión del Informe Financiero del Ejecutor");

$objHC = new HardCode();

switch ($ObjSession->PerfilID) {
    case $objHC->Ejec:
        $res_editar = "'{est_eje}' == 'Elaboracion' || '{est_eje}' == 'Correccion'";
        $res_ver = "'{est_eje}' == 'Elaboracion' || '{est_eje}' == 'Correccion' || '{est_eje}' == 'Aprobado Monitor'";
        $res_elim = "'{est_eje}' == 'Elaboracion'";
        break;
    case $objHC->MF:
    case $objHC->CMF:
        $res_editar = "'{est_eje}' == 'Revision'";
        $res_ver = "'{est_eje}' == 'Elaboracion' || '{est_eje}' == 'Correccion' || '{est_eje}' == 'Aprobado Monitor'";
        $res_elim = "'{est_eje}' == 'NoPuede'";
        break;
    case $objHC->MT:
    case $objHC->CMT:
        $res_editar = "'{est_eje}' == 'NoPuede'";
        $res_ver = "'{est_eje}' == 'Elaboracion' || '{est_eje}' == 'Correccion' || '{est_eje}' == 'Aprobado Monitor'";
        $res_elim = "'{est_eje}' == 'NoPuede'";
        break;
    case $objHC->Admin:
        $res_editar = "'{est_eje}' == 'Elaboracion' || '{est_eje}' == 'Correccion' || '{est_eje}' == 'Aprobado Monitor' || '{est_eje}' == 'Revision'";
        $res_ver = "'{est_eje}' == 'Elaboracion' || '{est_eje}' == 'Correccion' || '{est_eje}' == 'Aprobado Monitor' || '{est_eje}' == 'Revision'";
        $res_elim = "'{est_eje}' == 'Elaboracion' || '{est_eje}' == 'Correccion' || '{est_eje}' == 'Aprobado Monitor' || '{est_eje}' == 'Revision'";
        break;
}

?>
<!-- InstanceEndEditable -->
<meta name="keywords" content="<?php echo($objFunc->Keywords); ?>" />
<meta name="description" content="<?php echo($objFunc->MetaTags); ?>" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo($objFunc->Title);?></title>
<link href="../../../css/template.css" rel="stylesheet" media="all" />
<script src="<?php echo(PATH_JS);?>general.js" type="text/javascript"></script>
<script src="../../../SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="../../../SpryAssets/SpryMenuBarHorizontal.css"
	rel="stylesheet" type="text/css" />
<!-- InstanceBeginEditable name="head" -->
<script src="../../../SpryAssets/xpath.js" type="text/javascript"></script>
<script src="../../../SpryAssets/SpryData.js" type="text/javascript"></script>
<script src="../../../SpryAssets/SpryPagedView.js"
	type="text/javascript"></script>
<!-- InstanceEndEditable -->
<SCRIPT src="../../../jquery.ui-1.5.2/jquery-1.2.6.js"
	type=text/javascript></SCRIPT>
<SCRIPT src="../../../js/s3Slider.js" type=text/javascript></SCRIPT>
<!-- InstanceBeginEditable name="jQuery" -->
<script src="../../../SpryAssets/SpryPopupDialog.js"
	type="text/javascript"></script>
<link href="../../../SpryAssets/SpryPopupDialog.css" rel="stylesheet"
	type="text/css" />
<script src="../../../SpryAssets/SpryTabbedPanels.js"
	type="text/javascript"></script>
<link href="../../../SpryAssets/SpryTabbedPanels.css" rel="stylesheet"
	type="text/css" />

<script type="text/javascript">
var dsproyectos = null ;
var pvProyectos = null;
var pvProyectosPagedInfo = null;
Loadproyectos();
function Loadproyectos()
{
	var xmlurl = "../datos/process.xml.php?action=<?php echo(md5("buscar"));?>&idInst=<?php echo($ObjSession->IdInstitucion);?>";
	dsproyectos = new Spry.Data.XMLDataSet(xmlurl, "proyectos/rowdata", {useCache: true});

	pvProyectos	= new Spry.Data.PagedView(dsproyectos, { pageSize: 10});
	pvProyectosPagedInfo = pvProyectos.getPagingInfo();
}

	var dsLista = null ;
	var pvLista = null;
	var pvListaPagedInfo = null;
	$("#divContent").css('display', 'none');

	function LoadDataGrid(idProy)
	{
		var xmlurl = "inf_financ_process.xml.php?action=<?php echo(md5("lista"));?>&idProy=" + idProy ;

		if(dsLista!=null)
		{
			if(dsLista.url != xmlurl)
			{
				dsLista.setURL(xmlurl);
				dsLista.loadData();
			}
			else {dsLista.loadData();}
		}
		else
		{
			dsLista = new Spry.Data.XMLDataSet(xmlurl, "informes/rowdata", {useCache: false});
			pvLista = new Spry.Data.PagedView(dsLista, { pageSize: 12});
			pvListaPagedInfo = pvLista.getPagingInfo();
		}
	}
</script>
<script type="text/javascript">
	$.getScript("<?php echo(constant("PATH_JS")."editdata.js");?>");
</script>
<!-- InstanceEndEditable -->
<SCRIPT type=text/javascript>
    $(document).ready(function() {
        $('#slider').s3Slider({
            timeOut: 4500
        });
    });
</SCRIPT>
</head>
<body class="oneColElsCtrHdr">
	<!-- Inicio de Container Page-->
	<div id="container">
		<div id="banner">
      <?php include("../../../includes/Banner.php"); ?>
  </div>
		<div class="MenuBarHorizontalBack">
			<ul id="MenuBar1" class="MenuBarHorizontal">
        <?php include("../../../includes/MenuBar.php"); ?>
      </ul>
		</div>
		<script type='text/javascript'>
        var MenuBar1 = new Spry.Widget.MenuBar('MenuBar1');
     </script>

		<div class="Subtitle">
    <?php include("../../../includes/subtitle.php");?>
    </div>
		<div class="AccesosDirecto">
        <?php include("../../../includes/accesodirecto.php"); ?>
    </div>

		<div id="mainContent">
			<form id="FormData" method="post"
				enctype="application/x-www-form-urlencoded"
				action="<?php echo($_SERVER['PHP_SELF']);?>">
				<!-- InstanceBeginEditable name="Contenidos" -->
				<table width="100%" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td width="0%">&nbsp;</td>
						<td width="58%">
    <?php
    require (constant('PATH_CLASS') . "BLProyecto.class.php");
    $objProy = new BLProyecto();
    
    $ObjSession->VerifyProyecto();
    
    $row = 0;
    if ($ObjSession->CodProyecto != "" && $ObjSession->VerProyecto > 0) {
        $row = $objProy->GetProyecto($ObjSession->CodProyecto, $ObjSession->VerProyecto);
    }
    ?>
      <fieldset id="proyecto">
								<legend>Busqueda de Proyectos</legend>

								<table width="86%" border="0" cellpadding="0" cellspacing="2"
									class="TableEditReg">
									<tr>
										<td width="102" valign="middle" nowrap="nowrap"><input
											name="txtidInst" type="hidden" id="txtidInst"
											value="<?php echo($row['t01_id_inst']);?>" /> <input
											name="txtCodProy" type="text" id="txtCodProy" size="16"
											title="Ingresar Siglas de la Institución"
											style="text-align: center;" readonly="readonly"
											value="<?php echo($row['t02_cod_proy']);?>" /></td>
										<td width="16" align="center" valign="middle" nowrap="nowrap">
											<input type="image" name="btnBuscar" id="btnBuscar"
											src="../../../img/gosearch.gif" width="14" height="15"
											class="Image" onclick="Buscarproyectos(); return false;"
											title="Seleccionar proyectos Ejecutoras" />
										</td>
										<td align="left" valign="middle"><input name="txtNomejecutor"
											type="text" readonly="readonly" id="txtNomejecutor" size="66"
											value="<?php echo($row['t01_nom_inst']);?>" /></td>
									</tr>
									<tr>
										<td colspan="3" valign="middle" nowrap="nowrap"><input
											name="txtNomproyecto" type="text" readonly="readonly"
											id="txtNomproyecto" size="88"
											value="<?php echo($row['t02_nom_proy']);?>" /></td>
									</tr>
								</table>
							</fieldset>
						</td>
						<td width="0%"></td>
						<td width="42%">&nbsp;</td>
					</tr>
				</table>
				<div id="divContent"
					style="font-family: Arial, Helvetica, sans-serif; padding-left: 5px; padding-right: 3px;">
					<br />
		<?php
$objFunc->verifyAjax();
if ($objFunc->Ajax) {
    ob_clean();
    ob_start();
}
?>
   <div id="toolbar" style="height: 4px;">
						<script language="JavaScript" type="text/javascript">
	<!--
	function FilterData()
	{
	var tf = document.getElementById("txtBuscaproyecto");
	if (!tf.value)
	{
		dsproyectos.filter(null);
		return;
	}

	var regExpStr = tf.value;
	//regExpStr = "^" + regExpStr;
	var regExp = new RegExp(regExpStr, "i");
	var filterFunc = function(ds, row, rowNumber)
	{
		//var str = row["nombres"];
		var str = row["nombre"]+"|"+row["ejecutor"]+"|"+row["codigo"] ;
		if (str && str.search(regExp) != -1)
			return row;
		return null;
	};
	dsproyectos.filter(filterFunc);
	}

	function StartFilterTimer()
	{
	if (StartFilterTimer.timerID)
		clearTimeout(StartFilterTimer.timerID);
		StartFilterTimer.timerID = setTimeout(function() { StartFilterTimer.timerID = null; FilterData(); }, 100);
	}

	-->

	</script>

						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="7%">
 <?php if($ObjSession->AuthorizedOpcion("NUEVO")) { ?>
 <button class="Button" name="btnNuevo" id="btnNuevo"
										onclick="btnNuevo_Clic(); return false;" value="Nuevo">Nuevo</button>
 <?php } ?>
 </td>
								<td width="10%">
									<button class="Button" name="btnRefrescar" id="btnRefrescar"
										onclick="dsLista.loadData(); return false;" value="Refrescar">
										Actualizar</button>
								</td>
								<td width="28%"><button name="btnRefrescar" value="Refrescar"
										class="Button" id="btnExportar"
										onclick="ExportarInformeFinanciero(); return false;">Exportar</button></td>
								<td width="9%">&nbsp;</td>
								<td width="46%" align="right">
									<div>
										<span>Mostrar</span> <select name="cbopageSize"
											id="cbopageSize"
											onchange="pvLista.setPageSize(parseInt(this.value));"
											style="width: 60px">
											<option value="6">6 Reg.</option>
											<option value="12" selected="selected">12 Reg.</option>
											<option value="24">24 Reg.</option>
											<option value="36">36 Reg.</option>
											<option value="48">48 Reg.</option>
										</select> <span>Ir a </span> <span
											spry:region="pvListaPagedInfo" style="width: 75px;"> <select
											name="cboFilter" id="cboFilter"
											onchange="pvLista.goToPage(parseInt(this.value));"
											spry:repeatchildren="pvListaPagedInfo" style="width: 60px">
												<option
													spry:if="({ds_PageNumber} == pvLista.getCurrentPage())"
													value="{ds_PageNumber}" selected="selected">Pag.
													{ds_PageNumber}</option>
												<option
													spry:if="({ds_PageNumber} != pvLista.getCurrentPage())"
													value="{ds_PageNumber}">Pag. {ds_PageNumber}</option>
										</select>
										</span>
									</div>
								</td>
							</tr>
						</table>
					</div>

					<div class="TableGrid" spry:region="pvLista">
						<div spry:state="loading" align="center">
							<img src="../../../img/indicator.gif" width="16" height="16" />
						</div>
						<table class="grid-table grid-width">
							<thead>
								<tr>
									<th width="20" height="26">&nbsp;</th>
									<th width="38" align="center">Año</th>
									<th width="44" align="center">Mes</th>
									<th width="64" align="center">Periodo Referencia</th>
									<th width="76" align="center">Fecha Presentacion</th>
									<th width="61" align="center">Estado</th>
									<th width="66" align="center">Monto Informado</th>
									<th width="305" align="center">Observaciones</th>
									<th width="27" align="center">&nbsp;</th>
								</tr>
							</thead>
							<tbody class="data">
								<tr class="RowData" spry:repeat="pvLista" spry:setrow="pvLista"
									id="{@id}" spry:select="RowSelected">
									<td nowrap="nowrap"><span>
         	<?php if($ObjSession->AuthorizedOpcion("EDITAR")) { ?>
            <a href="#"
											<?php if($res_editar){echo('spry:if="'.$res_editar.'"');}  ?>><img
												src="../../../img/pencil.gif" width="14" height="14"
												title="Editar Registro" border="0"
												onclick="btnEditar_Clic('{t40_anio}','{t40_mes}'); return false;" /></a>
            <?php } ?>

            <?php // if($ObjSession->AuthorizedOpcion("VER")) { ?>

            <?php // } ?>
         </span></td>
									<td align="center">{anio}</td>
									<td align="center">{mes}</td>
									<td align="center">{periodo}</td>
									<td align="center">{fec_pre}</td>
									<td align="center">{est_eje}</td>
									<td align="right" bgcolor="#EEEEEE">{monto}</td>
									<td align="left">{observaciones}</td>
									<td align="left">
        <?php if($ObjSession->AuthorizedOpcion("ELIMINAR")) { ?>
        <a href="#"
										<?php if($res_elim){echo('spry:if="'.$res_elim.'"');}  ?>><img
											src="../../../img/bt_elimina.gif" width="14" height="14"
											title="Eliminar Registro" border="0"
											onclick="Eliminar('{t40_anio}','{t40_mes}'); return false;" /></a>
        <?php } ?>
        </td>
								</tr>
							</tbody>
							<tfoot>
								<tr>
									<th>&nbsp;</th>
									<th width="38">&nbsp;</th>
									<th width="44">&nbsp;</th>
									<th width="64">&nbsp;</th>
									<th width="76">&nbsp;</th>
									<th align="right">&nbsp;</th>
									<th colspan="3" align="right"><input type="button"
										class="Boton" title="Ir a la Primera Pagina"
										onclick="pvLista.firstPage();" value="&lt;&lt;" /> <input
										type="button" class="Boton" title="Pagina Anterior"
										onclick="pvLista.previousPage();" value="&lt;" /> <input
										type="button" class="Boton" title="Pagina Siguiente"
										onclick="pvLista.nextPage();" value="&gt;" /> <input
										type="button" class="Boton" title="Ir a la Ultima Pagina"
										onclick="pvLista.lastPage();" value="&gt;&gt;" /></th>
								</tr>
							</tfoot>
						</table>
					</div>

				</div>

				<div id="divContentEdit"
					style="position: relative; font-family: Arial, Helvetica, sans-serif; padding-left: 5px; padding-right: 3px; border: none;">
				</div>

				<br />

				<div id="panelBusquedaProy" class="popupContainer">
					<div class="popupBox">
						<div class="popupBar">
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td width="100%">BUSQUEDA DE PROYECTOS</td>
									<td align="right"><a class="popupClose" href="javascript:;"
										onclick="spryPopupDialogBuqueda.displayPopupDialog(false);"><b>X</b></a></td>
								</tr>
							</table>
						</div>

						<div class="popupContent">
							<div id="popupText"></div>
							<div id="toolbar">
								<table width="100%" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="11%" height="25" valign="middle">Buscar:</td>
										<td width="30%" valign="top"><input name="txtBuscaproyecto"
											type="text" class="Boton" id="txtBuscaproyecto"
											style="text-align: center;" title="Nombre del Proyecto"
											size="35" onkeyup="StartFilterTimer();" /><br /></td>
										<td width="5%" valign="middle">&nbsp;&nbsp;<input type="image"
											src="../../../img/btnRecuperar.gif" width="16" height="16"
											onclick="dsproyectos.loadData(); return false;"
											title="Actualizar Datos" /></td>
										<td width="5%" valign="middle"></td>
										<td width="49%" valign="middle"><span>Mostrar</span> <select
											name="cbopageSize" id="cbopageSize"
											onchange="pvProyectos.setPageSize(parseInt(this.value));"
											style="width: 60px">
												<option value="5">5 Reg.</option>
												<option value="10" selected="selected">10 Reg.</option>
												<option value="20">20 Reg.</option>
												<option value="30">30 Reg.</option>
												<option value="50">50 Reg.</option>
										</select> <span>Ir a </span> <span
											spry:region="pvProyectosPagedInfo" style="width: 75px;"> <select
												name="cboFilter" id="cboFilter"
												onchange="pvProyectos.goToPage(parseInt(this.value));"
												spry:repeatchildren="pvProyectosPagedInfo"
												style="width: 60px">
													<option
														spry:if="({ds_PageNumber} == pvProyectos.getCurrentPage())"
														value="{ds_PageNumber}" selected="selected">Pag.
														{ds_PageNumber}</option>
													<option
														spry:if="({ds_PageNumber} != pvProyectos.getCurrentPage())"
														value="{ds_PageNumber}">Pag. {ds_PageNumber}</option>
											</select>
										</span></td>
									</tr>
								</table>
							</div>
							<div class="TableGrid" spry:region="pvProyectos dsproyectos">
								<p spry:state="loading" align="center">
									<img src="../../../img/indicator.gif" width="16" height="16" /><br>
									Cargando...
								</p>
								<table width="580" border="0" cellpadding="0" cellspacing="0">
									<thead>
										<tr>
											<th width="115" height="26" align="center"
												spry:sort="ejecutor">EJECUTOR</th>
											<th width="59" align="center" spry:sort="codigo">CODIGO</th>
											<th width="38" align="center" spry:sort="exp">EXP</th>
											<th width="20" align="center" spry:sort="vs">VS</th>
											<th width="335" align="center" spry:sort="nombre">DESCRIPCION
												DEL PROYECTO</th>
										</tr>
									</thead>
									<tbody class="data" bgcolor="#FFFFFF">
										<tr class="RowData" spry:repeat="pvProyectos"
											spry:setrow="pvProyectos" id="{@id}"
											spry:select="RowSelected">
											<td align="left">{ejecutor}</td>
											<td align="center"><A
												href="javascript:Seleccionarproyecto();"
												title="Seleccionar Proyecto">{codigo}</A></td>
											<td align="center">{exp}</td>
											<td align="center">{vs}</td>
											<td align="left">{nombre}</td>
										</tr>
									</tbody>
									<tfoot>
										<tr>
											<th width="115">&nbsp;</th>
											<th width="59" align="right">&nbsp;</th>
											<th colspan="3" align="right"><input type="button"
												class="Boton" title="Ir a la Primera Pagina"
												onclick="pvProyectos.firstPage();" value="&lt;&lt;" /> <input
												type="button" class="Boton" title="Pagina Anterior"
												onclick="pvProyectos.previousPage();" value="&lt;" /> <input
												type="button" class="Boton" title="Pagina Siguiente"
												onclick="pvProyectos.nextPage();" value="&gt;" /> <input
												type="button" class="Boton" title="Ir a la Ultima Pagina"
												onclick="pvProyectos.lastPage();" value="&gt;&gt;" /></th>
										</tr>
									</tfoot>
								</table>

							</div>
						</div>
					</div>
				</div>
				<script language="JavaScript" type="text/javascript">
 var spryPopupDialogBuqueda= new Spry.Widget.PopupDialog("panelBusquedaProy", {modal:true, allowScroll:true, allowDrag:true});
</script>



				<div id="panelImportargastos" class="PopupDialog2"
					style="visibility: hidden;">
					<div class="popupBox">
						<div class="popupBar">
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td width="100%">Importar Gastos</td>
									<td align="right"><a class="popupClose" href="javascript:;"
										onclick="spryPopupImportar.displayPopupDialog(false);$('#divImportarGastos').html('');"><b>X</b></a></td>
								</tr>
							</table>
						</div>
						<div class="popupContent">
							<div id="popupText">
								<div id="divImportarGastos"
									style="height: 425px; background-color: #FFF; color: #333;"></div>
							</div>
						</div>

					</div>
				</div>
				<script type="text/javascript" language="javascript">
     var spryPopupImportar= new Spry.Widget.PopupDialog("panelImportargastos", {modal:true, allowScroll:true, allowDrag:true});
    </script>





				<script language="JavaScript" type="text/javascript">
 function btnNuevo_Clic()
  {
	 if($('#txtCodProy').val()=="")
	 {alert("Seleccione un Proyecto"); return false;}

	$("#divContent").fadeOut("slow");
	$("#divContent").css('display', 'none');

	var url = "inf_financ_edit.php?mode=<?php echo(md5("ajax_new"));?>&idProy="+$('#txtCodProy').val()+"&idanio=&idmes=";
	loadUrlSpry("divContentEdit",url);
	return;
  }
 function btnEditar_Clic(anio, mes)
  {
	var url = "inf_financ_edit.php?mode=<?php echo(md5("ajax_edit"));?>&idProy="+$('#txtCodProy').val()+"&idanio="+anio+"&idmes="+mes+"&mode_vista=<?php echo(md5("mf"));?>";
	loadUrlSpry("divContentEdit",url);
	$("#divContent").fadeOut("slow");
	$("#divContent").css('display', 'none');

	return;
  }


 function ReloadLista()
 {
	dsLista.loadData();
	$("#divContentEdit").fadeOut("slow");
	$("#divContentEdit").css('display', 'none');
	$("#divContent").fadeIn("slow");
	$("#divContent").css('display', 'block');
 }
 function CancelEdit()
 {
	$("#divContentEdit").fadeOut("slow");
	$("#divContent").fadeIn("slow");
	$("#divContent").css('display', 'block');
	$("#divContentEdit").css('display', 'none');
	return true;
 }

  function Eliminar(anio, mes)
  {
	<?php $ObjSession->AuthorizedPage(); ?>
	if(dsLista.getRowCount()==0)
	{
		alert("No hay Registros para eliminar");
		return;
	}
	if(confirm("¿Estás seguro de eliminar el Registro seleccionado, Año "+anio+" Mes " +  mes + " ?"))
	{
		var BodyForm = "t02_cod_proy="+$('#txtCodProy').val()+"&t40_anio="+anio+"&t40_mes="+mes;

		var sURL = "inf_financ_process.php?action=<?php echo(md5("ajax_del"))?>";
		var req = Spry.Utils.loadURL("POST", sURL, true, MySuccessCall, { postData: BodyForm, headers: { "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8" }, errorCallback: MyErrorCall});

	}
  }

  var idContainerLoading = "";
  function loadUrlSpry(ContainerID, pURL)
  {
	  idContainerLoading = "#"+ContainerID;
	  //$(idContainerLoading).css('display', 'none');
	  $(idContainerLoading).html("<p align='center'><img src='../../../img/indicator.gif' width='16' height='16' /><br>Cargando..<br></p>");
	  var req = Spry.Utils.loadURL("GET", pURL, true, MySuccessLoad, { headers: {"Content-Type": "application/x-www-form-urlencoded; charset=UTF-8" }, errorCallback: MyErrorCall});
  }
  var TabsInforme = null;
  function MySuccessLoad(req)
  {
	  var respuesta = req.xhRequest.responseText;
  	  $(idContainerLoading).css('display', 'block');

	  //alert(respuesta);

	  $(idContainerLoading).html(respuesta);

	  TabsInforme = new Spry.Widget.TabbedPanels("ssTabInforme");

  	  $(idContainerLoading).fadeIn("slow");
 	  return;
  }

  function MySuccessCall(req)
  {
	var respuesta = req.xhRequest.responseText;
	respuesta = respuesta.replace(/^\s*|\s*$/g,"");
	var ret = respuesta.substring(0,5);
	if(ret=="Exito")
	{ 	alert(respuesta.replace(ret,"")); dsLista.loadData();	}
	else
	{alert(respuesta);}
  }

  function MyErrorCall(req)
  {	  alert("ERROR: " + req);   }

</script>

				<script language="javascript" type="text/javascript">
function Buscarproyectos()
  {
	  spryPopupDialogBuqueda.displayPopupDialog(true);
  }
function Seleccionarproyecto()
{
	var rowid = dsproyectos.getCurrentRowID()
	var row = dsproyectos.getRowByID(rowid);
	if(row)
	{
		$("#txtidInst").val(row.t01_id_inst);
		$("#txtCodProy").val(row.codigo);
		$("#cboversion").val(row.vs);
		$("#txtNomejecutor").val( htmlEncode(row.ejecutor));
		$("#txtNomproyecto").val(htmlEncode(row.nombre));

		spryPopupDialogBuqueda.displayPopupDialog(false);

		$("#divContent").css('display', 'block');
		$("#divContentEdit").css('display', 'none');

		LoadDataGrid(row.codigo);

		var setURL = "<?php echo(constant("PATH_SME"));?>utiles.php?action=<?php echo(md5("setProyDefault"));?>&idProy=" + row.codigo ;
		$.get(setURL);

		return;
	}
	else
	{ alert("Error al Seleccionar el Proyecto !!!"); }
}


LoadDataGrid('<?php echo($ObjSession->CodProyecto);?>');


function ExportarInformeFinanciero()
{

	var row = dsLista.getRowByID(dsLista.getCurrentRowID());
	if(row)
	{
		var arrayControls = new Array();
			arrayControls[0] = "idProy=" + $("#txtCodProy").attr("value");
			arrayControls[1] = "idVers=" + $("#txtVersion").attr("value");
			arrayControls[2] = "idAnio=" + row.t40_anio;
			arrayControls[3] = "idMes=" + row.t40_mes;
		var params = arrayControls.join("&");

		var sID = "26" ;
		showReport(sID, params);
	}
	else
	{ alert("No se ha seleccionado ningun Proyecto."); return;}
}

 function showReport(reportID, params)
  {
	 var newURL = "<?php echo constant('PATH_RPT') ;?>reportviewer.php?ReportID=" + reportID + "&" + params ;
	 $('#FormData').attr({target: "winReport"});
	 $('#FormData').attr({action: newURL});
	 $('#FormData').submit();
	 $('#FormData').attr({target: "_self"});
     $("#FormData").removeAttr("action");
  }


</script>

				<!-- InstanceEndEditable -->
			</form>
		</div>
		<div id="footer">
	<?php include("../../../includes/Footer.php"); ?>
  </div>

		<!-- Fin de Container Page-->
	</div>

	<script language="javascript" type="text/javascript">
//FormData : Formulario Principal
var FormData = document.getElementById("FormData");
function CloseSesion()
{
	if(confirm("Estas seguro de Cerrar la Sesion de <?php echo($ObjSession->UserName);?>"))
	  {
			FormData.action = "<?php echo(constant("DOCS_PATH"));?>closesesion.php";
			FormData.submit();
	  }
	return true;
}
</script>
</body>
<!-- InstanceEnd -->
</html>
