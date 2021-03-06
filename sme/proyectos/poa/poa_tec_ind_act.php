<?php
/**
 * CticServices
 *
 * Gestiona el Cronograma de Productos
 *
 * @package     sme/proyectos/planifica
 * @author      AQ
 * @since       Version 2.0
 *
 */
include("../../../includes/constantes.inc.php");
include("../../../includes/validauser.inc.php");

require_once (constant("PATH_CLASS") . "BLMarcoLogico.class.php");
require_once (constant("PATH_CLASS") . "HardCode.class.php");
require_once (constant("PATH_CLASS") . "BLPOA.class.php");

$objML = new BLMarcoLogico();
$objProy = $objML->Proyecto;
$objHC = new HardCode();
$objPOA = new BLPOA();

$objFunc->SetTitle("Proyectos - Cronograma de Productos");
$objFunc->SetSubTitle("Cronograma de Productos");

$idProy = $objFunc->__Request('idProy');
$idVersion = $objFunc->__Request('idVersion');
$idAnio = $objFunc->__Request('idAnio');
$rowPOA = $objPOA->POA_Seleccionar($idProy, $idAnio);

//error_reporting(E_ALL);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="keywords" content="<?php echo($objFunc->Keywords); ?>" />
    <meta name="description" content="<?php echo($objFunc->MetaTags); ?>" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="shortcut icon" href="../../../img/feicon.ico" type="image/x-icon"/>
    <link href="../../../css/template.css" rel="stylesheet" media="all" />
    <script src="<?php echo(PATH_JS);?>general.js" type="text/javascript"></script>
    <script src="../../../SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
    <link href="../../../SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
    <script src="../../../SpryAssets/xpath.js" type="text/javascript"></script>
    <script src="../../../SpryAssets/SpryData.js" type="text/javascript"></script>
    <script src="../../../SpryAssets/SpryPagedView.js" type="text/javascript"></script>
    <script src="../../../jquery.ui-1.5.2/jquery-1.2.6.js" type=text/javascript></script>
    <script src="../../../js/s3Slider.js" type=text/javascript></script>
    <script src="../../../SpryAssets/SpryPopupDialog.js" type="text/javascript"></script>
    <script type="text/javascript">

    x=$(document);
    x.ready(inicializarEventos);

    function inicializarEventos()
    {
    	if ($("#txtCodProy").length > 0) {
    	$("#exportar").removeAttr("disabled");
    	}else{
    		$("#exportar").attr("disabled","-1");
    		}
    }

    var dsproyectos = null ;
    var pvProyectos = null;
    var pvProyectosPagedInfo = null;

    function ChangeVersion(id)
    {
        var sVersion = $("#cboversion").val();
        if(sVersion > 0) {
            $('#FormData').submit();
        }
        else {alert("No se especificado la version del Proyecto");}
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
    <link href="../../../SpryAssets/SpryPopupDialog.css" rel="stylesheet" type="text/css" />
    <title><?php echo($objFunc->Title);?></title>
</head>
<?php
    $ObjSession->VerifyProyecto();
    $ObjSession->VerProyecto = $idVersion;
    $row = 0;
    if ($ObjSession->CodProyecto != "" && $ObjSession->VerProyecto > 0) {
        $row = $objML->Proyecto->GetProyecto($ObjSession->CodProyecto, $ObjSession->VerProyecto);
    }
?>
<body class="oneColElsCtrHdr">
	<form id="FormData" method="post" enctype="application/x-www-form-urlencoded" action="<?php echo($_SERVER['PHP_SELF']);?>">
		<script language="javascript" type="text/javascript">
        	function LoadCronogramaProductos()
        	{
        		var idProy = '<?php echo($row['t02_cod_proy']);?>';
        		var idVersion = '<?php echo($row['t02_version']);?>' ;
        		var idComp = $('#cboComponente').val();

        		var BodyForm = "action=<?php echo(md5("lista_costeo"));?>&idProy="+idProy+"&idVersion="+idVersion+"&idComp="+idComp+"&modif=<?php if(($row["t02_env_croprod"]==1 || $row["t02_aprob_croprod"]==1) && ($ObjSession->PerfilID==$objHC->Ejec || $ObjSession->PerfilID==$objHC->GP || $ObjSession->PerfilID==$objHC->Admin)){ echo md5("enable");}?>";
        	 	var sURL = "poa_tec_ind_act_lista.php";
        		$('#divCronograma').html("<p align='center'><img src='../../../img/indicator.gif' width='16' height='16' /><br>Cargando..<br></p>");
        	 	var req = Spry.Utils.loadURL("POST", sURL, true, SuccessLoadCosteo, { postData: BodyForm, headers: { "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8" }, errorCallback: onErrorCosteo });
        	}

        	function SuccessLoadCosteo(req)
            {
                var respuesta = req.xhRequest.responseText;
                $("#divCronograma").html(respuesta);
                $($('#ids').val()).html('X');
                $($('#ids-crct').val()).html('X');
                return;
            }

        	function onErrorCosteo(req)
        	{
        		return ;
        	}

        	function btnGuardarMsg()
        	{
        		$('#FormData').submit();
        	}

        	var spryPopupDialog01     = new Spry.Widget.PopupDialog("panelPopup", {modal:true, allowScroll:true, allowDrag:true});
        	var htmlLoading = "<p align='center'><img src='<?php echo(constant("PATH_IMG"));?>indicator.gif' width='16' height='16' /><br>Cargando..<br></p>";

        	function loadPopup(title, url)
        	{

        		$('#titlePopup').html(title);
        		$('#divChangePopup').html(htmlLoading);
        		$('#divChangePopup').load(url);
        		spryPopupDialog01.displayPopupDialog(true);
        		return false ;
        	}

        	function closePopup()
        	{
        		$('#divChangePopup').html("");
        		spryPopupDialog01.displayPopupDialog(false);
        	}
    	</script>
        <?php if($row["t02_aprob_ml"]==1){?>
        <div id="divContent" class="crngr-prod">
			<table width="99%">
				<tr>
					<td>
					    <b>COMPONENTE</b>
					    &nbsp;
					    <select name="cboComponente" class="TextDescripcion" id="cboComponente" style="width: 520px;" onchange="LoadCronogramaProductos();">
                            <?php
                                $rs = $objML->ListadoDefinicionOE($row['t02_cod_proy'], $row['t02_version']);
                                $objFunc->llenarComboSinItemsBlancos($rs, "t08_cod_comp", 'descripcion', '','',array(),'t08_comp_desc');
                            ?>
    					</select>
    					&nbsp;&nbsp;&nbsp;&nbsp;
    					<?php
                            $disabledGuardar = "";
                            if ($rowPOA['t02_estado'] == $objHC->especTecAprobRA) {
                                $disabledGuardar = " disabled";
                            }
                        ?>
                        
                        <input type="button" value="Refrescar" onclick="LoadCronogramaProductos();" class="btn_save_custom"/>
                        
    					<input type="button" value="Guardar Programación" onclick="btnProgramarEntregables();" class="btn_save_custom" <?php echo($disabledGuardar);?>/>
    					&nbsp; &nbsp;
    					<select name="cboAgregarItem" id="cboAgregarItem" style="width: 130px; font-size: 11px;" class="SubActividad" onchange="LoadAgregarItem(true);">
							<option value="0" style="color: #F00">Seleccionar opción</option>
							<option value="1" style="background: #FFBF55; font-weight: bold">Agregar Componente</option>
							<option value="2" style="background: #DAF3DD; font-weight: bold">Agregar Producto</option>
						</select>
				    </td>
				</tr>
				<tr>
					<td>
						<div id="divCronograma"></div>
					</td>
				</tr>
				</table>
			</div>
<?php }else{ ?>
<?php if($row['t02_cod_proy']) {?>
	<div id="Alerta"
			style="padding: 20px; font-size: 14px; color: #003366;"> Para continuar con el llenado del Cronograma de Productos, el Marco Lógico del Proyecto "<?php echo $row['t02_cod_proy']; ?>"  debe ser Aprobado</div>
<?php }else{ ?>
	<div id="Alerta"
			style="padding: 20px; font-size: 14px; color: #003366;">Elija un
			Proyecto, antes de continuar..</div>
<?php } ?>
<?php } ?>
        <br />
		<div id="panelEditSubAct" class="popupContainer"
			style="visibility: hidden;">
			<div class="popupBox">
				<div class="popupBar">
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td width="100%"></td>
							<td align="right"><a class="popupClose" href="javascript:;"
								onclick="spryPopupDialogEditReg.displayPopupDialog(false);"><b>X</b></a></td>
						</tr>
					</table>
				</div>
				<div class="popupContent">
					<div id="popupText2"></div>
					<iframe class="Iframe" src="#"
						id="iPopup" name="iPopup" scrolling="no"
						style="width: 99%; height: 380px;"></iframe>
				</div>
			</div>
		</div>

<script language="javascript" type="text/javascript">
  function VerifyActividades()
  {
	  var idComponente = $('#cboComponente').val();
	  if(idComponente > 0)
	  {
		  var idAct = $('#cboActividad').val();
		  if(idAct=="" || idAct==null )
		  {LoadActividades();}
	  }
  }

  function btnEstablecerEntregables()
  {
	  var idProy = $('#txtCodProy').val();
	  var idVersion = '<?php echo($idVersion);?>';
	  if( idProy == '' || idProy==null) {alert("Seleccione un Proyecto"); return false;}
	  $('#iPopup').attr('src', "../planifica/cp_ent_prog.php?idProy="+idProy+"&idVersion="+idVersion);
	  spryPopupDialogEditReg.displayPopupDialog(true);
	  return true;
  }

  function btnNuevo_Clic(idActividad)
  {
	  var idProy = $('#txtCodProy').val();
	  var idVersion = '<?php echo($idVersion);?>';
	  var idComponente = $('#cboComponente').val();
	  //var idActividad = $('#cboActividad').val();
	  //var idAnio = $('#cboAnios').val();

	  if( idProy == '' || idProy==null) {alert("Seleccione un Proyecto"); return false;}
	  if( idActividad == '' || idActividad==null) {alert("Seleccione una Actividad"); return false;}

	  var params = "&idProy="+idProy+"&idVersion="+idVersion+"&idComp="+idComponente+"&idActiv="+idActividad+"&idSActiv=";
	  var url = "../planifica/poa_sact_edit.php?action=<?php echo(md5("new"));?>" + params ;
	  $('#iSubActividades').attr('src',url);
	  spryPopupDialogEditReg.displayPopupDialog(true);
	  return true;
  }

  function btnProgramarIndicador(idAct, idInd)
  {
	  var idProy = $('#txtCodProy').val();
	  var idVersion = '<?php echo($idVersion);?>';
	  var idComponente = $('#cboComponente').val();

	  if( idProy == '' || idProy==null) {alert("Seleccione un Proyecto"); return false;}

	  var params = "&idProy="+idProy+"&idVersion="+idVersion+"&idComp="+idComponente+"&idAct="+idAct+"&idInd="+idInd;
	  var url = "../planifica/cp_ind_prog.php?action=<?php echo(md5("edit"));?>&view=edit" + params ;
	  $('#iPopup').attr('src',url);
	  spryPopupDialogEditReg.displayPopupDialog(true);
	  return true;
  }

  function btnAgregarIndicador(idAct)
  {
	  var idProy = $('#txtCodProy').val();
	  var idVersion = '<?php echo($idVersion);?>';
	  var idComponente = $('#cboComponente').val();

	  if( idProy == '' || idProy==null) {alert("Seleccione un Proyecto"); return false;}

	  var params = "&idProy="+idProy+"&idVersion="+idVersion+"&idComp="+idComponente+"&idAct="+idAct;
	  var url = "../planifica/cp_ind_prog.php?action=<?php echo(md5("edit"));?>" + params ;
	  $('#iPopup').attr('src',url);
	  spryPopupDialogEditReg.displayPopupDialog(true);
	  return true;
  }

  function btnProgramarCaracteristica(idAct, idInd, idCar)
  {
	  var idProy = $('#txtCodProy').val();
	  var idVersion = '<?php echo($idVersion);?>';
	  var idComponente = $('#cboComponente').val();

	  if( idProy == '' || idProy==null) {alert("Seleccione un Proyecto"); return false;}

	  var params = "&idProy="+idProy+"&idVersion="+idVersion+"&idComp="+idComponente+"&idAct="+idAct+"&idInd="+idInd+"&idCar="+idCar+"&view=edit";
	  $('#iPopup').attr('src', "../planifica/cp_car_prog.php?" + params );
	  spryPopupDialogEditReg.displayPopupDialog(true);
	  return true;
  }

  function btnAgregarCaracteristica(idAct, idInd)
  {
	  var idProy = $('#txtCodProy').val();
	  var idVersion = '<?php echo($idVersion);?>';
	  var idComponente = $('#cboComponente').val();

	  if( idProy == '' || idProy==null) {alert("Seleccione un Proyecto"); return false;}

	  var params = "&idProy="+idProy+"&idVersion="+idVersion+"&idComp="+idComponente+"&idAct="+idAct+"&idInd="+idInd+"&view=new";
	  $('#iPopup').attr('src', "../planifica/cp_car_prog.php?" + params );
	  spryPopupDialogEditReg.displayPopupDialog(true);
	  return true;
  }

  function btnEliminarIndicador(idAct, idInd, ind)
  {
	  <?php $ObjSession->AuthorizedPage('ELIMINAR'); ?>
	  if(!confirm("¿Estás seguro de Eliminar el Indicador \n\"" + ind + "\"  y todas sus Características?")){return false ;}

	  var idProy = $('#txtCodProy').val();
	  var idVersion = '<?php echo($idVersion);?>';
	  var idComponente = $('#cboComponente').val();
	  var params = "&idProy="+idProy+"&idVersion="+idVersion+"&idComp="+idComponente+"&idAct="+idAct+"&idInd="+idInd;
	  var url = "../planifica/cp_ind_prog.php?action=<?php echo(md5("del"));?>" + params;
	  $('#iPopup').attr('src',url);
	  return true;
  }

  function btnEliminarCaracteristica(idAct, idInd, idCar, car)
  {
	  <?php $ObjSession->AuthorizedPage('ELIMINAR'); ?>
	  if(!confirm("¿Estás seguro de Eliminar la Característica \n\"" + car + "\" ?")){return false ;}

	  var idProy = $('#txtCodProy').val();
	  var idVersion = '<?php echo($idVersion);?>';
	  var idComponente = $('#cboComponente').val();
	  var params = "&idProy="+idProy+"&idVersion="+idVersion+"&idComp="+idComponente+"&idAct="+idAct+"&idInd="+idInd+"&idCar="+idCar;
	  var url = "../planifica/cp_car_prog.php?action=<?php echo(md5("del"));?>" + params;
	  $('#iPopup').attr('src',url);
	  return true;
  }

  function btnEliminar_Clic(idActividad, idSAct, Subact)
  {
	  <?php $ObjSession->AuthorizedPage('ELIMINAR'); ?>

	  if(!confirm("¿ Estás seguro de Eliminar el Registro seleccionado \n\"" + Subact + "\"?")){return false ;}

	  var idProy = $('#txtCodProy').val();
	  var idVersion = '<?php echo($idVersion);?>';
	  var idComponente = $('#cboComponente').val();

	  if( idActividad == '' || idActividad==null) {alert("Seleccione una Actividad"); return false;}
	  if( idSAct == '' || idSAct==null) {alert("Seleccione una Actividad"); return false;}

	  var params = "&t02_cod_proy="+idProy+"&t02_version="+idVersion+"&t08_cod_comp="+idComponente+"&t09_cod_act="+idActividad+"&t09_cod_sub="+idSAct;
	  var url = "../planifica/poa_sact_edit.php?proc=<?php echo(md5("del"));?>" + params ;
	  //spryPopupDialogEditReg.displayPopupDialog(true);
	  $('#iSubActividades').attr('src',url);

	  return true;
  }

  function btnMetas_Clic(idActividad, idSAct, anio)
  {
	var idProy = $('#txtCodProy').val();
	var idVersion = '<?php echo($idVersion);?>';
	var idComponente = $('#cboComponente').val();

	if( idActividad == '' || idActividad==null) {alert("Seleccione una Actividad"); return false;}
	if( idSAct == '' || idSAct==null) {alert("No se ha seleccionado ninguna Actividad"); return false;}
	var params = "&idProy="+idProy+"&idVersion="+idVersion+"&idComp="+idComponente+"&idActiv="+idActividad+"&idSActiv="+idSAct+"&anio="+anio;

	var url = "../planifica/poa_meta_edit.php?action=<?php echo(md5("edit"));?>" + params ;
    $('#iSubActividades').attr('src',url);
    spryPopupDialogEditReg.displayPopupDialog(true);
  }

  function btnExportar_onclick()
  {
	  alert("En etapa de Desarrollo") ;
	  return false;
  }

  function btnCancel_Clic()
  {
	  spryPopupDialogEditReg.displayPopupDialog(false);
	  return true;
  }

  function btnSuccess()
  {
	  spryPopupDialogEditReg.displayPopupDialog(false);
	  LoadCronogramaProductos();
	  return true;
  }

  function btnProgramarEntregables()
  {
        <?php $ObjSession->AuthorizedPage(); ?>

        var idComp = $('#cboComponente').val();
        var aValidFlg = true;

        /*$("[id='txtIndCompMeta[]']").each(function(){
            var aValue = $(this).val();
            if (aValue != "" && isNaN(parseFloat(aValue))) {
            	aValidFlg = false;
            	alert("Valor Anual ingresdo no es correcto");
            	$(this).focus();
            	return false;
            }
        });*/

        if (!aValidFlg) return false;

        var BodyForm="idComp="+idComp+"&" +$("#FormData .prog").serialize();

        if(confirm("Está seguro de Guardar la Programación de los Entregables ?"))
        {
            var sURL = "poa_tec_process.php?action=<?php echo(md5('ajax_prog_entregables'));?>";
            var req = Spry.Utils.loadURL("POST", sURL, true, ProgEntregablesSuccessCallback, { postData: BodyForm, headers: { "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8" }, errorCallback: MyErrorCallback });
        }

        return false;
    }

    function ProgEntregablesSuccessCallback	(req)
    {
        var respuesta = req.xhRequest.responseText;
        //alert(respuesta);
        respuesta = respuesta.replace(/^\s*|\s*$/g,"");
        var ret = respuesta.substring(0,5);

        if(ret=="Exito")
        {
            LoadCronogramaProductos();
            alert($('<div></div>').html(respuesta.replace(ret,"")).text());
        }
        else
        {alert(respuesta);}
    }

    function LoadAgregarItem()
    {	var idProy 		= $('#t02_cod_proy').val();
	 	var idVersion 	= $('#t02_version').val();
	 	var idComp 		= $('#t08_cod_comp').val();

	 	var idProy = '<?php echo($row['t02_cod_proy']);?>';
		var idVersion = '<?php echo($row['t02_version']);?>';
		var idComp = $('#cboComponente').val();

		$('#divChangePopup').html('<iframe class="Iframe" id="iAgregarPOA" name="iAgregarPOA" scrolling="no" style="width:99%; height:380px;"></iframe>');

		var cod = $('#cboAgregarItem').val();
		parent.AgregarItemPOA(cod, idProy, idVersion, idComp);
		return false;
	 }

  </script>
        <script language="Javascript" type="text/javascript">
            var spryPopupDialogEditReg= new Spry.Widget.PopupDialog("panelEditSubAct", {modal:true, allowScroll:true, allowDrag:true});
            LoadCronogramaProductos();
	    </script>
        <?php
        if ($ObjSession->MaxVersionProy($ObjSession->CodProyecto) > $ObjSession->VerProyecto && $ObjSession->PerfilID != $objHC->Admin) {
            echo ("<script>alert('Esta versión \"" . $ObjSession->VerProyecto."\" del Proyecto \"".$ObjSession->CodProyecto."\", no es Modificable');</script>"); }
        ?>
	</form>
</body>
</html>
