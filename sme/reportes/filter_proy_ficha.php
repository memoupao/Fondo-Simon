<?php include("../../includes/constantes.inc.php"); ?>
<?php include("../../includes/validauser.inc.php"); ?>
<?php

$NoInclude = true;

require (constant('PATH_CLASS') . "BLProyecto.class.php");

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
							onclick="Buscarproyectos(); return false;"
						
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
		arrayControls[1] = "idVersion=" + $('#cboversion').val();
	var params = arrayControls.join("&"); 
	var sID = "<?php echo($objFunc->__Request('ReportID'));?>" ;
	showReport(sID, params);
}

function MostrarTodos()
{

	var arrayControls = new Array();
		arrayControls[0] = "all=1";
	var params = arrayControls.join("&"); 
	var sID = "<?php echo($objFunc->__Request('ReportID'));?>" ;
	showReport(sID, params);
}
</script>
<?php if(!$NoInclude) { ?>
</form>