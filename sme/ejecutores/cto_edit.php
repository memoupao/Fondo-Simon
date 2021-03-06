<?php include("../../includes/constantes.inc.php"); ?>
<?php include("../../includes/validauser.inc.php"); ?>

<?php
require (constant('PATH_CLASS') . "BLTablasAux.class.php");
require (constant('PATH_CLASS') . "BLEjecutor.class.php");

$OjbTab = new BLTablasAux();
$view = $objFunc->__GET('mode');
$accion = $objFunc->__GET('accion');
$idme = $objFunc->__GET('idme');
$row = 0;
$objEjec = new BLEjecutor();
if ($view == md5("ajax_edit")) {
    if ($accion == md5("editar")) {
        $objFunc->SetSubTitle("Contactos Institución - Editar Registro");
    } else {
        $objFunc->SetSubTitle("Contactos Institución - Ver Registro");
    }
    
    $idInst = $objFunc->__GET('idInst');
    $id = $objFunc->__GET('id');
    
    $row = $objEjec->ContactosSeleccionar($idInst, $id);
    
    $t01_id_inst = $row['t01_id_inst'];
    $t01_id_cto = $row['t01_id_cto'];
    $t01_dni_cto = $row['t01_dni_cto'];
    $t01_ape_pat = $row['t01_ape_pat'];
    $t01_ape_mat = $row['t01_ape_mat'];
    $t01_nom_cto = $row['t01_nom_cto'];
    $t01_fono_ofi = $row['t01_fono_ofi'];
    $t01_mail_cto = $row['t01_mail_cto'];
    $t01_mail_cto2 = $row['t01_mail_cto2'];
    $t01_cel_cto = $row['t01_cel_cto'];
    $t01_cgo_cto = $row['t01_cgo_cto'];
    $usr_crea = $row['usr_crea'];
    $fch_crea = $row['fch_crea'];
    $est_audi = $row['est_audi'];
    
    $t01_tel2_cto = $row['t01_tel2_cto'];
    $t01_rpm_cto = $row['t01_rpm_cto'];
    $t01_fax_cto = $row['t01_fax_cto'];
    $t01_rpc_cto = $row['t01_rpc_cto'];
    $t01_nex_cto = $row['t01_nex_cto'];
    $t11_sexo = $row['t01_sexo'];
    
    $objEjec = NULL;
    // Se va a modificar el registro !!
} else {
    $objFunc->SetSubTitle("Contactos de Institución - Nuevo Registro");
    $t01_id_inst = $objFunc->__GET('idInst');
    $inst = $objFunc->__GET('inst');
    $cto = $objFunc->__GET('cto');
    if ($idme == "me") {
        $row = $objEjec->ContactosSeleccionar($inst, $cto);
        
        $t01_id_inst = $row['t01_id_inst'];
        $t01_id_cto = $row['t01_id_cto'];
        $t01_dni_cto = $row['t01_dni_cto'];
        $t01_ape_pat = $row['t01_ape_pat'];
        $t01_ape_mat = $row['t01_ape_mat'];
        $t01_nom_cto = $row['t01_nom_cto'];
        $t01_fono_ofi = $row['t01_fono_ofi'];
        $t01_mail_cto = $row['t01_mail_cto'];
        $t01_mail_cto2 = $row['t01_mail_cto2'];
        $t01_cel_cto = $row['t01_cel_cto'];
        $t01_cgo_cto = $row['t01_cgo_cto'];
        $usr_crea = $row['usr_crea'];
        $fch_crea = $row['fch_crea'];
        $est_audi = $row['est_audi'];
        
        $t01_tel2_cto = $row['t01_tel2_cto'];
        $t01_rpm_cto = $row['t01_rpm_cto'];
        $t01_fax_cto = $row['t01_fax_cto'];
        $t01_rpc_cto = $row['t01_rpc_cto'];
        $t01_nex_cto = $row['t01_nex_cto'];
        $t11_sexo = $row['t01_sexo'];
    }
}

?>

<?php if($objFunc->__QueryString()=='') {?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<!-- InstanceBegin template="/Templates/tplAjaxForm.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<!-- InstanceBeginEditable name="doctitle" -->
<?php
    $objFunc->SetTitle("Instituciones - Contactos");
    ?>
<!-- InstanceEndEditable -->
<?php
    
$objFunc->verifyAjax();
    if (! $objFunc->Ajax) {
        ?>
<meta name="keywords" content="<?php echo($objFunc->Keywords); ?>" />
<meta name="description" content="<?php echo($objFunc->MetaTags); ?>" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo($objFunc->Title);?></title>
<link href="../../css/template.css" rel="stylesheet" media="all" />
<SCRIPT src="../../jquery.ui-1.5.2/jquery-1.2.6.js" type=text/javascript></SCRIPT>
<script src="../../jquery.ui-1.5.2/ui/ui.datepicker.js"
	type="text/javascript"></script>
<link href="../../jquery.ui-1.5.2/themes/ui.datepicker.css"
	rel="stylesheet" type="text/css" />

<!-- InstanceBeginEditable name="head" -->
<!-- InstanceEndEditable -->

<?php } ?>
</head>
<body class="oneColElsCtrHdr">
	<!-- Inicio de Container Page-->
	<div id="container">
		<div id="mainContent">
			<form id="FormData" method="post"
				enctype="application/x-www-form-urlencoded"
				action="<?php echo($_SERVER['PHP_SELF']);?>">
				<!-- InstanceBeginEditable name="TemplateEditDetails" -->
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td width="1%">&nbsp;</td>
						<td width="73%">&nbsp;</td>
						<td width="26%">&nbsp;</td>
					</tr>
					<tr>
						<td height="18">&nbsp;</td>
						<td><b style="text-decoration: underline"> </b> &nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>
				<!-- InstanceEndEditable -->
				<div id="divContent">
					<!-- InstanceBeginEditable name="Contenidos" -->
	<?php } ?>
    <script src="../../jquery.ui-1.5.2/jquery.maskedinput.js"
						type="text/javascript"></script>
					<script src="../../jquery.ui-1.5.2/jquery.numeric.js"
						type="text/javascript"></script>

					<br />
					<div id="toolbar" style="height: 4px;" class="BackColor">
						<table width="100%" border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td width="9%"><button value="Guardar" class="Button"
										id="btnGuardar" onclick="btnGuardar_Clic(); return false;">Guardar
									</button></td>
								<td width="22%"><button class="Button"
										onclick="btnCancelar_Clic(); return false;" value="Cancelar"
										style="white-space: nowrap;">Cerrar y Volver</button></td>
								<td align="center"><?php echo($objFunc->SubTitle) ;?></td>
							</tr>
						</table>
					</div>
					<table width="100%" border="0" cellpadding="0" cellspacing="2"
						class="TableEditReg">
						<tr>
							<td width="1%">&nbsp;</td>
							<td colspan="6">
      <?php
    
if ($id == "") {
        $sURL = "process_cto.php?action=" . md5("ajax_new");
    } else {
        $sURL = "process_cto.php?action=" . md5("ajax_edit");
    }
    ?>
      <input type="hidden" name="txturlsave" id="txturlsave"
								value="<?php echo($sURL); ?>" /> <input type="hidden"
								name="t01_id_inst" id="t01_id_inst"
								value="<?php echo($t01_id_inst); ?>" /> <input type="hidden"
								name="t01_id_cto" id="t01_id_cto"
								value="<?php echo($t01_id_cto); ?>" />
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td width="12%"><strong>DNI</strong></td>
							<td colspan="5"><input name="t01_dni_cto" type="text"
								id="t01_dni_cto" value="<?php echo($t01_dni_cto); ?>" size="15"
								maxlength="8" class="ContactInst" /></td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td nowrap="nowrap"><strong>Apellido Paterno</strong></td>
							<td colspan="4"><input name="t01_ape_pat" type="text"
								class="ContactInst" id="t01_ape_pat"
								value="<?php echo($t01_ape_pat); ?>" size="35" maxlength="50" /></td>

<?php 
// -------------------------------------------------->
// DA 2.0 [21-11-2013 11:55]
// Deshabilitado el cambio de contacto en el momento de edicion.
// Ahora tendra que ir nuevamente al listado
/* ?>								
							<td>Supervisor Externo</td>
							<td colspan="2">
							 <select name="t_concacto" id="t_concacto" style="width: 130px;">
									<option value=""></option>
	      <?php
    $objEjec = new BLEjecutor();
    $rsz = $objEjec->contactosListME();
    $objFunc->llenarComboI($rsz, 'id', 'nombre', "$t01_id_inst.$t01_id_cto");
    ?>  
	                           </select>
	                       </td>
	    
<?php */
// --------------------------------------------------<
?>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td nowrap="nowrap"><strong>Apellido Materno</strong></td>
							<td colspan="5"><input name="t01_ape_mat" type="text"
								class="ContactInst" id="t01_ape_mat"
								value="<?php echo($t01_ape_mat); ?>" size="35" maxlength="50" /></td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td><strong>Nombres</strong></td>
							<td colspan="5"><input name="t01_nom_cto" type="text"
								class="ContactInst" id="t01_nom_cto"
								value="<?php echo($t01_nom_cto); ?>" size="35" maxlength="50" /></td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td><strong>Sexo</strong></td>
							<td colspan="5"><select name="t11_sexo" id="t11_sexo"
								style="width: 130px;">
									<option value=""></option>
      <?php
    $rs = $OjbTab->Sexo(12);
    $objFunc->llenarCombo($rs, 'codigo', 'descripcion', $t11_sexo);
    ?>
    </select></td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td><strong>Cargo</strong></td>
							<td colspan="5"><select name="t01_cgo_cto" id="t01_cgo_cto"
								style="width: 150px;" class="ContactInst">
									<option value=""></option>
      <?php
    $rs = $OjbTab->TipoCargoContacto();
    $objFunc->llenarCombo($rs, 'codigo', 'descripcion', $t01_cgo_cto);
    ?>
      </select></td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td><strong>Teléfono 1</strong></td>
							<td width="11%"><input name="t01_fono_ofi" type="text"
								class="ContactInst" id="t01_fono_ofi"
								value="<?php echo($t01_fono_ofi); ?>" size="14" maxlength="50" /></td>
							<td width="8%"><strong>Teléfono 2</strong></td>
							<td width="11%"><input name="t01_tel2_cto" type="text"
								class="ContactInst" id="t01_tel2_cto"
								value="<?php echo($t01_tel2_cto); ?>" size="14" maxlength="50" /></td>
							<td width="4%"><strong>Fax</strong></td>
							<td width="53%"><strong> <input name="t01_fax_cto" type="text"
									class="ContactInst" id="t01_fax_cto"
									value="<?php echo($t01_fax_cto); ?>" size="14" maxlength="50" />
							</strong></td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td><strong>Celular</strong></td>
							<td><input name="t01_cel_cto" type="text" class="ContactInst"
								id="t01_cel_cto" value="<?php echo($t01_cel_cto); ?>" size="14"
								maxlength="50" /></td>
							<td><strong>RPM</strong></td>
							<td><input name="t01_rpm_cto" type="text" class="ContactInst"
								id="t01_rpm_cto" value="<?php echo($t01_rpm_cto); ?>" size="14"
								maxlength="50" /></td>
							<td><strong>RPC</strong></td>
							<td><input name="t01_rpc_cto" type="text" class="ContactInst"
								id="t01_rpc_cto" value="<?php echo($t01_rpc_cto); ?>" size="14"
								maxlength="50" /></td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td><strong>Nextel</strong></td>
							<td><input name="t01_nex_cto" type="text" class="ContactInst"
								id="t01_nex_cto" value="<?php echo($t01_nex_cto); ?>" size="14"
								maxlength="50" /></td>
							<td>&nbsp;</td>
							<td colspan="3">&nbsp;</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td><strong>E-mail</strong></td>
							<td colspan="5"><input name="t01_mail_cto" type="text"
								class="ContactInst" id="t01_mail_cto"
								value="<?php echo($t01_mail_cto); ?>" size="60" maxlength="50" /></td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td><strong>E-mail</strong> 2</td>
							<td colspan="5"><input name="t01_mail_cto2" type="text"
								class="ContactInst" id="t01_mail_cto2"
								value="<?php echo($t01_mail_cto2); ?>" size="60" maxlength="50" /></td>
						</tr>
					</table>

					<br />

					<script language="javascript">
  <?php if($accion!=md5("editar") && $view == md5("ajax_edit")) { ?>
	  $('#btnGuardar').attr("disabled","disabled");
	  $('.ContactInst').attr("disabled","disabled");
  <?php } else { ?>
    
	//$.mask.definitions['*']='[*#]';
	//$.mask.definitions['0']='[0123456789 ]';
	
	$('#t01_dni_cto').mask('?99999999');
	/*
	$('#t01_fono_ofi').mask('(0?9)999-9999');
	$('#t01_tel2_cto').mask('(0?9)999-9999');
	$('#t01_fax_cto').mask('(0?9)999-9999');
	$('#t01_rpm_cto').mask('*999999');
	$('#t01_rpc_cto').mask('999-999-999');
	$('#t01_cel_cto').mask('999-999-999');
	$('#t01_nex_cto').mask('999 * 9999'); 
	*/
  <?php } ?>
  
  
  
  </script>
<?php 
// -------------------------------------------------->
// DA 2.0 [21-11-2013 11:55]
// Deshabilitado el cambio de contacto en el momento de edicion.
// Ahora tendra que ir nuevamente al listado
/*  
<script>
	$("#t_concacto").change(function(){
		
		var id = $(this).val();
		var i = id.split('.');
		
		var url = "cto_edit.php?mode=<?php echo(md5("ajax_new"));?>&idme=me&inst="+i[0]+"&cto="+i[1]+"&idInst="+$('#txtidInst').val()+"&id=";
		loadUrlSpry("divContentEdit",url);
	});
</script>
*/
?>
  
  <?php if($objFunc->__QueryString()=='') {?>
  <!-- InstanceEndEditable -->
				</div>
			</form>
		</div>
		<!-- Fin de Container Page-->
	</div>

</body>
<!-- InstanceEnd -->
</html>
<?php } ?>