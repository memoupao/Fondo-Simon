<?php include("../../includes/constantes.inc.php"); ?>
<?php include("../../includes/validauser.inc.php"); ?>
<?php

require_once (constant("PATH_CLASS") . "BLMarcoLogico.class.php");
require_once (constant("PATH_CLASS") . "BLBene.class.php");

$idProy = $objFunc->__Request('idProy');
$idVersion = $objFunc->__Request('idVersion');
$idConcurso = $objFunc->__Request('cboConcurso');

$objML = new BLMarcoLogico();
$ML = $objML->GetML($idProy, $idVersion);

?>

<?php if($idProy=='') { ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<!-- InstanceBegin template="/Templates/tempReports.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type"
	content="text/html; charset=charset=utf-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Reporte de Beneficiarios</title>
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
<?php
$objBenef = new BLBene();
$rsBenef = $objBenef->ListadoBeneficiariosTotales($idConcurso);
$num = mysqli_num_rows($rsBenef);
?>
<table width="99%" border="0" align="center" cellpadding="0"
				cellspacing="1" class="TableGrid">
				<tr>
					<th width="19%" align="left"></th>
					<td width="47%" align="left"><?php echo($ML['t02_cod_proy']);?></td>
					<th width="15%" align="left" nowrap="nowrap"></th>
					<td width="19%" align="left"><?php echo($ML['t02_fch_ini']);?></td>
				</tr>
				<tr>
					<th align="left" nowrap="nowrap"></th>
					<td align="left"><?php echo($ML['t02_nom_proy']);?></td>
					<th align="left" nowrap="nowrap"></th>
					<td align="left"><?php echo($ML['t02_fch_ter']);?></td>
				</tr>
				<tr>
					<th height="20" align="left">&nbsp;</th>
					<td>&nbsp;</td>
					<td align="left"><strong>Total de Beneficiarios</strong></td>
					<td align="left">  <?php echo($num);?>  </td>
				</tr>
			</table>

			<table width="99%" align="center" cellpadding="0" cellspacing="0">
				<thead>
					<tr>
						<td height="33" align="center" valign="middle">N&ordm;</td>
						<td align="center" valign="middle">Proyecto</td>
						<td align="center" valign="middle">Inst. Ejecutora</td>
						<td align="center" valign="middle">DNI</td>
						<td align="center" valign="middle">Apellidos y Nombres</td>
						<td align="center" valign="middle">Sexo</td>
						<td align="center" valign="middle">Edad</td>
						<td align="center" valign="middle">Instrucción</td>
						<td align="center" valign="middle">Especialidad</td>
						<td align="center" valign="middle">Departamento</td>
						<td align="center" valign="middle">Provincia</td>
						<td align="center" valign="middle">Distrito</td>
						<td align="center" valign="middle">Centro Poblado</td>
						<td align="center" valign="middle">Dirección</td>
						<td align="center" valign="middle">Ciudad</td>
						<td align="center" valign="middle">Teléfono</td>
						<td align="center" valign="middle">Celular</td>
						<td align="center" valign="middle">Email</td>
						<td align="center" valign="middle">Actividad Principal</td>
						<td align="center" valign="middle">Sector Productivo</td>
						<td align="center" valign="middle">Sub Sector</td>
						<td align="center" valign="middle">Unidades de Producción</td>
						<td align="center" valign="middle">Total de Unidades de
							Producción</td>
						<td align="center" valign="middle">Unidades de Producción con el
							Proyecto</td>
						<td align="center" valign="middle">Estado</td>
						<td align="center" valign="middle">Fecha de Incorporación</td>
						<td align="center" valign="middle">Fecha de Cese</td>
						<td align="center" valign="middle">Capacitaciones en Producción</td>
						<td align="center" valign="middle">Capacitaciones en Gestión</td>
						<td align="center" valign="middle">Capacitaciones en
							Comercialización</td>
						<td align="center" valign="middle">Capacitaciones en
							Emprededurismo</td>
						<td align="center" valign="middle">AT en Producción</td>
						<td align="center" valign="middle">AT en Gestión</td>
						<td align="center" valign="middle">AT en Comercialización</td>
						<td align="center" valign="middle">AT en Emprededurismo</td>
						<td align="center" valign="middle">Nro. Créditos Otorgados</td>
						<td align="center" valign="middle">Total Monto Prestado</td>
						<td align="center" valign="middle">Total Monto Pagado</td>
						<td align="center" valign="middle">Total Monto por Pagar</td>
						<td align="center" valign="middle">Otros Servicios: Insumos</td>
						<td align="center" valign="middle">Otros Servicios: Herramientas</td>
						<td align="center" valign="middle">Otros Servicios:
							Infraestructura</td>
						<td align="center" valign="middle">Otros Servicios: Productivos</td>
					</tr>
				</thead>
				<tbody class="data" bgcolor="#FFFFFF">
    <?php
    $Index = 1;
    while ($row = mysqli_fetch_assoc($rsBenef)) {
        ?>
    <tr style="font-size: 11px;">
						<td align="center" valign="middle"><?php echo($Index);?></td>
						<td align="left" valign="middle"><?php echo($row['codigo_proyecto']);?></td>
						<td align="left" valign="middle"><?php echo($row['inst_eject']);?></td>
						<td align="left" valign="middle"><?php echo($row['dni']);?> </td>
						<td align="left" valign="middle" nowrap="nowrap"><?php echo($row['nombres']);?></td>
						<td align="left" valign="middle"><?php echo($row['sexo']);?></td>
						<td align="left" valign="middle"><?php echo($row['edad']);?></td>
						<td align="left" valign="middle"><?php echo($row['nivel_educ']);?></td>
						<td align="left" valign="middle"><?php echo($row['especialidad']);?></td>
						<td align="left" valign="middle"><?php echo($row['dpto']);?></td>
						<td align="left" valign="middle"><?php echo($row['prov']);?></td>
						<td align="left" valign="middle"><?php echo($row['dist']);?></td>
						<td align="left" valign="middle"><?php echo($row['caserio']);?></td>
						<td align="left" valign="middle"><?php echo($row['t11_direccion']);?></td>
						<td align="left" valign="middle"><?php echo($row['t11_ciudad']);?></td>
						<td align="left" valign="middle"><?php echo($row['t11_telefono']);?></td>
						<td align="left" valign="middle"><?php echo($row['t11_celular']);?></td>
						<td align="left" valign="middle"><?php echo($row['t11_mail']);?></td>
						<td align="left" valign="middle"><?php echo($row['t11_act_princ']);?></td>
						<td align="left" valign="middle"><?php
        
echo ($row['sector1'] . '<br/>' . $row['sector2'] . '<br/>' . $row['sector3']);
        ?></td>
						<td align="left" valign="middle"><?php
        
echo ($row['subsector1'] . '<br/>' . $row['subsector2'] . '<br/>' . $row['subsector3']);
        ?></td>
						<td align="center" valign="middle"><?php
        
echo ($row['uni_prod1'] . '<br/>' . $row['uni_prod2'] . '<br/>' . $row['uni_prod3']);
        ?></td>
						<td align="center" valign="middle"><?php
        
echo ($row['t11_tot_unid_prod'] . '<br/>' . $row['t11_tot_unid_prod_2'] . '<br/>' . $row['t11_tot_unid_prod_3']);
        ?></td>
						<td align="center" valign="middle"><?php
        
echo ($row['t11_nro_up_b'] . '<br/>' . $row['t11_nro_up_b_2'] . '<br/>' . $row['t11_nro_up_b_3']);
        ?></td>
						<td align="left" valign="middle"><?php echo($row['estado']);?></td>
						<td align="left" valign="middle"><?php echo($row['fec_ini']);?></td>
						<td align="left" valign="middle"><?php echo($row['fec_cese']);?></td>
						<td align="left" valign="middle"><?php echo($row['cap_prod']);?></td>
						<td align="left" valign="middle"><?php echo($row['cap_gest']);?></td>
						<td align="left" valign="middle"><?php echo($row['cap_comer']);?></td>
						<td align="left" valign="middle"><?php echo($row['cap_empre']);?></td>
						<td align="left" valign="middle"><?php echo($row['at_prod']);?></td>
						<td align="left" valign="middle"><?php echo($row['at_gest']);?></td>
						<td align="left" valign="middle"><?php echo($row['at_comer']);?></td>
						<td align="left" valign="middle"><?php echo($row['at_empre']);?></td>
						<td align="left" valign="middle"><?php echo(number_format($row['nro_cred']));?></td>
						<td align="left" valign="middle"><?php echo(number_format($row['mto_pres'], 2));?></td>
						<td align="left" valign="middle"><?php echo(number_format($row['mto_pgdo'], 2));?></td>
						<td align="left" valign="middle"><?php echo(number_format($row['mto_pres'] - $row['mto_pgdo'], 2));?></td>
						<td align="left" valign="middle"><?php echo($row['otr_prod']);?></td>
						<td align="left" valign="middle"><?php echo($row['otr_gest']);?></td>
						<td align="left" valign="middle"><?php echo($row['otr_comer']);?></td>
						<td align="left" valign="middle"><?php echo($row['otr_empre']);?></td>
					</tr>
    <?php
        $Index ++;
    } // End While
    $rsBenef->free();
    ?>
  </tbody>
				<tfoot>
					<tr>
						<td align="left" valign="middle">&nbsp;</td>
						<td align="left" valign="middle">&nbsp;</td>
						<td align="left" valign="middle">&nbsp;</td>
						<td align="left" valign="middle">&nbsp;</td>
						<td align="left" valign="middle">&nbsp;</td>
						<td colspan="7" align="left" valign="middle">&nbsp;</td>
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
<?php } ?>