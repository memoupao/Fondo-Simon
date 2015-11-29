<?php include("../../includes/constantes.inc.php"); ?>
<?php include("../../includes/validauser.inc.php"); ?>
<?php

$NoInclude = true;

require (constant('PATH_CLASS') . "BLProyecto.class.php");
require (constant('PATH_CLASS') . "BLFuentes.class.php");

$objProy = new BLProyecto();

$ObjSession->VerifyProyecto();

$row = 0;

if ($ObjSession->CodProyecto != "" && $ObjSession->VerProyecto > 0) 

{
    
    $row = $objProy->GetProyecto($ObjSession->CodProyecto, $ObjSession->VerProyecto);
}

?>
<?php if(!$NoInclude) { ?>
<?php } ?>
<!-- InstanceBeginEditable name="BodyAjax" -->
        
$max = $objProy->MaxVersion($row['t02_cod_proy']);
        for ($i = 1; $max > $i; $i ++) {
            ?>
				<option value="<?php echo $i; ?>">POA<?php echo $i; ?></option>
			<?php } ?>-->
                          <?php
                        $objFte = new BLFuentes();
                        $Rs = $objFte->ContactosListado($row['t02_cod_proy']);
                        $objFunc->llenarCombo($Rs, "t01_id_inst", "t01_sig_inst", $_POST['idFte']);
                        $objFte = NULL;
                        ?>
                        </select></td>
function Buscarproyectos()
{
	
	var pagina = document.URL;
	var viewer = "reportviewer.php";
	var ret = pagina.search(viewer);
	
	var arrayControls = new Array();
		arrayControls[0] = "ctrl_idinst=txtidInst";
		arrayControls[1] = "ctrl_idproy=txtCodProy";
		arrayControls[2] = "ctrl_idversion=cboversion";
		arrayControls[3] = "ctrl_ejecutor=txtNomejecutor";
		arrayControls[4] = "ctrl_proyecto=txtNomproyecto";
		arrayControls[5] = "evaljs=LoadFuentesFinanc";
		
	var params = "?" + arrayControls.join("&"); 
	var sUrl = "<?php echo(constant("DOCS_PATH"));?>sme/proyectos/datos/lista_proyectos.php" + params;
	
	if(ret < 0)
	{
		window.open(sUrl,"BuscaProy", "width=603, height=400,menubar=no, scrollbars=yes, location=no, resizable=no, status=no",true);
	}
	else
	{
		ChangeStylePopup("PopupDialog");
		spryPopupFilter.displayPopupDialog(true);
		$('#spanTitle').html('Busqueda de Proyectos');
		if($('#divPopupText').html()=='')
		{
    		$('#divPopupText').html($('#divCargando').html());
			var sUrl = "<?php echo(constant("DOCS_PATH"));?>sme/proyectos/datos/lista_proyectos.php" + params;
			var vhtml="<iframe id='ifrmBuscarproy' src='"+sUrl+"' style='width:100%; height:440px;' frameborder='0' scrollbars='0'></iframe>";
			$('#divPopupText').html(vhtml);
		}
    	//var req = Spry.Utils.loadURL("POST", url, true, SuccessLoadFilter, { postData: BodyForm, headers: { "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8" }, errorCallback: onErrorLoadFilter });
	}
}

function HideBusqueda()
{
	spryPopupFilter.displayPopupDialog(false);
	NuevoReporte();
}

function NuevoReporte()
{
	/*
	var params = $(".filterparams").serialize();
	var sID = "<?php echo($objFunc->__Request('ReportID'));?>" ;
	showReport(sID, params);
	*/
	if($('#txtCodProy').val()=='')
	{
		alert("Seleccione un Proyecto");
		return ;
	}
	var arrayControls = new Array();
		arrayControls[0] = "idProy=" + $('#txtCodProy').val();
		arrayControls[1] = "idVersion=" + $('#poa').val();
		arrayControls[2] = "idFte=" + $('#cboFtesFinanc').val();
		
	var params = arrayControls.join("&"); 
	var sID = "<?php echo($objFunc->__Request('ReportID'));?>" ;
	showReport(sID, params);
}
function LoadFuentesFinanc()
{
	var sURL = "<?php echo(constant("PATH_SME")."proyectos/anexos/");?>fuentes_process.php?action=<?php echo(md5("ajax_lista_fte"))?>" ;

	var arrayControls = new Array();
		arrayControls[0] = "idProy=" + $('#txtCodProy').val();
		arrayControls[1] = "idVersion=" + $('#cboversion').val();
	var BodyForm = arrayControls.join("&"); 
	$('#cboFtesFinanc').html('<option> Cargando ... </option>');
	var req = Spry.Utils.loadURL("POST", sURL, true, FuentesFinancSuccessCallback, { postData: BodyForm, headers: { "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8" } });
}
function FuentesFinancSuccessCallback(req)
{
  var respuesta = req.xhRequest.responseText;
  $('#cboFtesFinanc').html(respuesta);
  $('#cboFtesFinanc').focus();
}
</script>
<?php if(!$NoInclude) { ?>
</form>