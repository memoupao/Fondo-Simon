<?php include("../../includes/constantes.inc.php"); ?>
<?php include("../../includes/validauser.inc.php"); ?>
<?php
// require_once(constant("PATH_CLASS")."BLEquipo.class.php");
require_once (constant("PATH_CLASS") . "BLProyecto.class.php");

// require(constant('PATH_CLASS')."BLManejoProy.class.php");
// $objManP = new BLManejoProy();

$idProy = $objFunc->__Request('idProy');

$objProy = new BLProyecto();

$ls_version = $objProy->MaxVersion($idProy);

$Proy = $objProy->GetProyecto($idProy, $ls_version);

?>

<?php  if($idProy=='') { ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<!-- InstanceBegin template="/Templates/tempReports.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type"
	content="text/html; charset=charset=utf-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Monitor Externo</title>
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
<div id="divBodyAjax" class="TableGrid">
			<!-- InstanceBeginEditable name="BodyAjax" -->
			<table width="95%" border="0" align="center" cellpadding="0"
				cellspacing="1" class="TableGrid">
				<tr>
					<th align="left">&nbsp;</th>
					<td width="60%">&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<th width="18%" height="18" align="left">CODIGO DEL PROYECTO</th>
					<td align="left"><?php echo($Proy['t02_cod_proy']." - ".$Proy['t01_nom_inst']);?></td>
					<th width="2%" align="left" nowrap="nowrap">&nbsp;</th>
					<th width="7%" align="left" nowrap="nowrap">INICIO</th>
					<td width="13%" align="left"><?php echo($Proy['t02_fch_ini']);?></td>
				</tr>
				<tr>
					<th height="18" align="left" nowrap="nowrap">DESCRIPCION DEL
						PROYECTO</th>
					<td align="left"><?php echo($Proy['t02_nom_proy']);?></td>
					<th align="left" nowrap="nowrap">&nbsp;</th>
					<th align="left" nowrap="nowrap">TERMINO</th>
					<td align="left"><?php echo($Proy['t02_fch_ter']);?></td>
				</tr>
				<tr>
					<th align="left">&nbsp;</th>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
			</table>


			<table width="95%" align="center" cellpadding="0" cellspacing="0">
				<thead>
					<tr>
						<td width="15%" height="33" align="center" valign="middle">Especialidad</td>
						<td width="18%" align="center" valign="middle">Nombre</td>
						<td width="14%" align="center" valign="middle">Edad</td>
						<td width="14%" align="center" valign="middle">Sexo</td>
						<td width="14%" align="center" valign="middle">Documento de
							Identidad</td>
						<td width="15%" align="center" valign="middle">Grado</td>
						<td width="11%" align="center" valign="middle">Funcion</td>
						<td width="9%" align="center" valign="middle">Mail</td>
						<td width="9%" align="center" valign="middle">Telefono</td>
						<td width="9%" align="center" valign="middle">Celular</td>
						<td width="9%" align="center" valign="middle">Experiencia</td>
						<td width="9%" align="center" valign="middle">Estado</td>
					</tr>
				</thead>

				<tbody class="data" bgcolor="#FFFFFF">
    <?php
    
    $rsPersonal = $objProy->Personal_ListadoEqui($idProy);
    
    while ($row = mysqli_fetch_assoc($rsPersonal)) {
        
        $nombre = $row['paterno'] . ' ' . $row['materno'] . ', ' . $row['nombre'];
        ?>
    <tr style="font-size: 11px;">
						<td align="left" valign="middle"><?php echo($row['especialidad']);?></td>
						<td align="left" valign="middle"><?php echo($nombre);?></td>
						<td align="center" valign="middle"><?php echo($row['t04_edad_equi']);?></td>
						<td align="center" valign="middle"><?php echo($row['sexo']);?></td>
						<td align="center" valign="middle"><?php echo($row['t04_dni_equi']);?></td>
						<td align="left" valign="middle"><?php echo($row['grado']);?></td>
						<td align="center" valign="middle"><?php echo($row['t04_func_equi']);?></td>
						<td align="center" valign="middle"><?php echo($row['t04_mail_equi']);?></td>
						<td align="center" valign="middle"><?php echo($row['t04_telf_equi']);?></td>
						<td align="center" valign="middle"><?php echo($row['t04_cel_equi']);?></td>
						<td align="center" valign="middle"><?php echo($row['t04_exp_lab']);?></td>
						<td align="center" valign="middle"><?php echo($row['estado']);?></td>
					</tr>
    <?php
        
        $Index ++;
    } // End While
    $rsEquipo->free();
    ?>
  </tbody>
				<tfoot>
					<tr>
						<td align="left" valign="middle">&nbsp;</td>
						<td align="left" valign="middle">&nbsp;</td>
						<td align="left" valign="middle">&nbsp;</td>
						<td align="left" valign="middle">&nbsp;</td>
						<td align="left" valign="middle">&nbsp;</td>
						<td align="left" valign="middle">&nbsp;</td>
						<td align="left" valign="middle">&nbsp;</td>
						<td align="left" valign="middle">&nbsp;</td>
					</tr>
				</tfoot>
			</table>
			<br />
			<!-- InstanceEndEditable -->
		</div>
<?php if($objFunc->__QueryString()=="") { ?>
</form>
</body>
<!-- InstanceEnd -->
</html>
<?php  } ?>