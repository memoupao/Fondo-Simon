<?php include("../includes/constantes.inc.php"); ?>
<?php include("../includes/validauseradm.inc.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<!-- InstanceBegin template="/Templates/tplMainMantenimiento.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<!-- InstanceBeginEditable name="doctitle" -->
<?php
require (constant('PATH_CLASS') . "BLMantenimiento.class.php");
$objMante = new BLMantenimiento();

$objFunc->SetTitle("Mantenimiento de Opciones de Menu");
$objFunc->SetSubTitle("Mantenimiento de Opciones de Menu");
$ObjSession->MostrarBotonesAccesoDirecto = false;
?>
<!-- InstanceEndEditable -->
<meta name="keywords" content="<?php echo($objFunc->Keywords); ?>" />
<meta name="description" content="<?php echo($objFunc->MetaTags); ?>" />
<!-- AQ 2.0 [22-10-2013 16:05]
     Eliminación de charset=UTF-8. -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="../img/feicon.ico" type="image/x-icon">
<title><?php echo($objFunc->Title);?></title>
<link href="../css/template.css" rel="stylesheet" media="all" />
<script src="../SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet"
	type="text/css" />
<!-- InstanceBeginEditable name="head" -->
<!-- InstanceEndEditable -->
<SCRIPT src="../jquery.ui-1.5.2/jquery-1.2.6.js" type=text/javascript></SCRIPT>
<SCRIPT src="../js/s3Slider.js" type=text/javascript></SCRIPT>
<!-- InstanceBeginEditable name="jQuery" -->
<script src="../SpryAssets/xpath.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryData.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryPagedView.js" type="text/javascript"></script>

<script type="text/javascript">
	var dsLista = null ;
	var pvLista = null;
	var pvListaPagedInfo = null;

	$("#divContent").css('display', 'none');
	function LoadDataGrid()
	{
		var modulo = $("#cbomodulo").val();
		var xmlurl = "man.xml.php?action=<?php echo(md5("lista_menus"));?>&modulo="+modulo ;

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
			dsLista = new Spry.Data.XMLDataSet(xmlurl, "menus/rowdata", {useCache: false});
			pvLista = new Spry.Data.PagedView(dsLista, { pageSize: 20});
			pvListaPagedInfo = pvLista.getPagingInfo();
		}
	}
	$.getScript("<?php echo(constant("PATH_JS")."editdata.js");?>");
</script>
<script src="../SpryAssets/SpryPopupDialog.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryPopupDialog.css" rel="stylesheet"
	type="text/css" />

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
      <?php include("../includes/Banner.php"); ?>
  </div>
		<div class="MenuBarHorizontalBack">
			<ul id="MenuBar1" class="MenuBarHorizontal">
        <?php include("../includes/MenuBarAdmin.php"); ?>
      </ul>
		</div>
		<script type='text/javascript'>
        var MenuBar1 = new Spry.Widget.MenuBar('MenuBar1');
     </script>

		<div class="Subtitle">
    <?php include("../includes/subtitle.php");?>
    </div>
		<div class="AccesosDirecto">
        <?php include("../includes/accesodirecto.php"); ?>
    </div>

		<div id="mainContent">
			<form id="FormData" method="post"
				enctype="application/x-www-form-urlencoded"
				action="<?php echo($_SERVER['PHP_SELF']);?>">
				<!-- InstanceBeginEditable name="Contenidos" -->


				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td width="17%">&nbsp;</td>
						<td width="83%">&nbsp;</td>
					</tr>
					<tr>
						<td height="18" align="center" nowrap="nowrap"
							style="font-size: 12px;">&nbsp;<strong>Modulo del Sistema</strong>
							&nbsp;
						</td>
						<td><select name="cbomodulo" id="cbomodulo" style="width: 250px"
							onchange="LoadDataGrid();">
								<option value="0">Modulo Sistema FONDOEMPLEO</option>
								<option value="1">Modulo Administración</option>
						</select></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>
				<div id="divContent"
					style="position: relative; font-family: Arial, Helvetica, sans-serif; padding-left: 5px; padding-right: 3px;">
					<div id="toolbar" style="height: 4px;">
						<script language="JavaScript" type="text/javascript">
<!--
function FilterData()
{
var tf = document.getElementById("txtBuscar");
if (!tf.value)
{
	dsLista.filter(null);
	return;
}

var regExpStr = tf.value;

var regExp = new RegExp(regExpStr, "i");
var filterFunc = function(ds, row, rowNumber)
{
	var str = row["nommenu"];
	if (str && str.search(regExp) != -1)
		return row;
	return null;
};

dsLista.filter(filterFunc);
}

function StartFilterTimer()
{
if (StartFilterTimer.timerID)
	clearTimeout(StartFilterTimer.timerID);
StartFilterTimer.timerID = setTimeout(function() { StartFilterTimer.timerID = null; FilterData(); }, 100);
}
-->
</script>

						<style>
.Inactivo {
	color: red;
	text-decoration: line-through;
}
</style>

						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="13%" nowrap="nowrap">
									<button class="Button" name="btnNuevo" id="btnNuevo"
										onclick="btnNuevo_Clic(); return false;" value="Nuevo">Nuevo
										Menu</button>
								</td>
								<td width="14%" nowrap="nowrap"><button class="Button"
										name="btnNuevo" id="btnNuevo2"
										onclick="LoadDataGrid(); return false;" value="Rfrescar Datos">Refrescar</button></td>
								<td width="2%">&nbsp;</td>
								<td width="13%">&nbsp;</td>
								<td width="58%" align="right">
									<div>
										<span>Buscar</span> <input name="txtBuscar" type="text"
											id="txtBuscar" size="17" onkeyup="StartFilterTimer();" /> <span>Mostrar</span>
										<select name="cbopageSize" id="cbopageSize"
											onchange="pvLista.setPageSize(parseInt(this.value));"
											style="width: 60px">
											<option value="5">5 Reg.</option>
											<option value="10">10 Reg.</option>
											<option value="20" selected="selected">20 Reg.</option>
											<option value="30">30 Reg.</option>
											<option value="50">50 Reg.</option>
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
						<table class="grid-table grid-width">
							<thead>
								<tr>
									<th width="44">&nbsp;</th>
									<th width="74" height="25" align="center" spry:sort="codigo">Codigo</th>
									<th width="285" align="center" spry:sort="nommenu">Título del
										Menu</th>
									<th width="68" align="center" spry:sort="activo">Estado</th>
									<th width="79" align="center" spry:sort="codparent">Id.Contenedor</th>
									<th width="238" align="center" spry:sort="parentmenu">Nombre
										Contenedor</th>
									<th width="44">&nbsp;</th>
								</tr>
							</thead>
							<tbody class="data">
								<tr class="RowData" spry:repeat="pvLista" spry:setrow="pvLista"
									id="{@id}" spry:select="RowSelected">
									<td nowrap="nowrap"><span> <a href="#"><img
												src="../img/pencil.gif" width="14" height="14"
												title="Editar Registro" border="0"
												onclick="btnEditar_Clic('{codigo}');" /></a>
									</span></td>
									<td align="center" class="{activo}">{codigo}</td>
									<td align="left" class="{activo}">{nommenu}</td>
									<td align="center" class="{activo}">{activo}</td>
									<td align="center" class="{activo}">{codparent}</td>
									<td align="left" class="{activo}">{parentmenu}</td>
									<td nowrap="nowrap"><span> <a href="#"><img
												src="../img/bt_elimina.gif" width="14" height="14"
												title="Eliminar Registro" border="0"
												onclick="Eliminar('{codigo}', '{nommenu}');" /></a>
									</span></td>
								</tr>
							</tbody>
							<tfoot>
								<tr>
									<th width="44">&nbsp;</th>
									<th width="74">&nbsp;</th>
									<th width="285">&nbsp;</th>
									<th width="68">&nbsp;</th>
									<th width="79">&nbsp;</th>
									<th align="right">
										<div>
											<input type="button" class="Boton"
												title="Ir a la Primera Pagina"
												onclick="pvLista.firstPage();"
												value="<<" />
            <input  type="button"
												class="Boton" title="Pagina Anterior"
												onclick="pvLista.previousPage();"
												value="<" />
            <input  type="button"
												class="Boton" title="Pagina Siguiente"
												onclick="pvLista.nextPage();" value=">" /> <input
												type="button" class="Boton" title="Ir a la Ultima Pagina"
												onclick="pvLista.lastPage();" value=">>" />
										</div>
									</th>
									<th width="44">&nbsp;</th>
								</tr>
							</tfoot>
						</table>
						<p spry:state="loading" align="center" id="pLoading">
							<img src="../img/indicator.gif" width="16" height="16" /><br>
							Cargando...
						</p>
					</div>

				</div>
				<div id="divContentEdit"
					style="position: relative; font-family: Arial, Helvetica, sans-serif; padding-left: 5px; padding-right: 3px; border: none;">
				</div>


				<script language="javascript" type="text/javascript">
 function btnNuevo_Clic()
  {
	$("#divContent").fadeOut("slow");
	$("#divContent").css('display', 'none');
	var url = "man_mnu_edit.php?mode=<?php echo(md5("ajax_new"));?>&id=&modulo="+$('#cbomodulo').val() ;
	loadUrlSpry("divContentEdit",url);
	return;

  }
 function btnEditar_Clic(idmenu)
  {
	if(dsLista.getRowCount()==0)
	{
		alert("No ha seleccionado ningun registro !!!");
		return;
	}

	var url = "man_mnu_edit.php?mode=<?php echo(md5("ajax_edit"));?>&id="+idmenu+"&modulo="+$('#cbomodulo').val() ;
	loadUrlSpry("divContentEdit",url);
	$("#divContent").fadeOut("slow");
	$("#divContent").css('display', 'none');

	return;


  }

 function ReloadLista()
 {
	$("#divContentEdit").fadeOut("slow");
	$("#divContentEdit").css('display', 'none');
	$("#divContent").fadeIn("slow");
	$("#divContent").css('display', 'block');
	$('#cbomodulo').removeAttr('disabled');
	dsLista.loadData();
 }
 function CancelEdit()
 {
	$("#divContentEdit").fadeOut("slow");
	$("#divContent").fadeIn("slow");
	$("#divContent").css('display', 'block');
	$("#divContentEdit").css('display', 'none');
	$('#cbomodulo').removeAttr('disabled');
	return true;
 }

  function Eliminar(codigo,Descripcion)
  {
	<?php $ObjSession->AuthorizedPage(); ?>

	if(dsLista.getRowCount()==0)
	{
		alert("No hay Registros para eliminar");
		return;
	}
	if(confirm("Estas seguro de eliminar el Registro \n" + Descripcion))
	{
		var BodyForm = "idMenu="+codigo;
		var sURL = "man_mnu_process.php?action=<?php echo(md5("ajax_del"))?>";
		var req = Spry.Utils.loadURL("POST", sURL, true, MySuccessCall, { postData: BodyForm, headers: { "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8" }, errorCallback: MyErrorCall});

	}
  }
  var idContainerLoading = "";
  function loadUrlSpry(ContainerID, pURL)
  {
	  idContainerLoading = "#"+ContainerID;
	  $(idContainerLoading).css('display', 'none');
	  $(idContainerLoading).html('<img src="../img/loading.gif" />');
	  $('#cbomodulo').attr('disabled','disabled');
	  var req = Spry.Utils.loadURL("GET", pURL, true, MySuccessLoad, { headers: {"Content-Type": "application/x-www-form-urlencoded; charset=UTF-8" }, errorCallback: MyErrorCall});
  }

  function MySuccessLoad(req)
  {
	  var respuesta = req.xhRequest.responseText;
  	  $(idContainerLoading).css('display', 'block');
	  $(idContainerLoading).html(respuesta);
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

				<script language="javascript">
  LoadDataGrid();
  </script>

				<div id="panelPopup" class="popupContainer"
					style="visibility: hidden;">
					<div class="popupBox">
						<div class="popupBar">
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td width="100%"><span id="titlePopup"></span></td>
									<td align="right"><a class="popupClose" href="javascript:;"
										onclick="spryPopupDialog01.displayPopupDialog(false);"><b>X</b></a></td>
								</tr>
							</table>
						</div>

						<div class="popupContent" style="background-color: #FFF;">
							<div id="popupText"></div>

							<div id="divChangePopup"></div>

						</div>
					</div>
				</div>

				<script language="JavaScript" type="text/javascript">
  var spryPopupDialog01= new Spry.Widget.PopupDialog("panelPopup", {modal:true, allowScroll:true, allowDrag:true});

  function loadPopup(title, url)
  {
	$('#titlePopup').html(title);
	loadUrlSpry("divChangePopup", url)
	spryPopupDialog01.displayPopupDialog(true);
	return false ;
  }

  </script>


				<!-- InstanceEndEditable -->
			</form>
		</div>
		<div id="footer">
	<?php include("../includes/Footer.php"); ?>
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
