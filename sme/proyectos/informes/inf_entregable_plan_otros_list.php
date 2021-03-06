<?php
/**
 * CticServices
 *
 * Lista el Plan de Otros para el Informe de Entregable
 *
 * @package     sme/proyectos/informes
 * @author      AQ
 * @since       Version 2.0
 *
 */
include_once ("../../../includes/constantes.inc.php");
include_once ("../../../includes/validauser.inc.php");
require_once (constant("PATH_CLASS") . "BLInformes.class.php");
require_once (constant("PATH_CLASS") . "BLPOA.class.php");

$idProy = $_GET['idProy'];
$idVersion = $_GET['idVersion'];
$anio = $_GET['anio'];
$partes = explode("-", $_GET['idEntregable']);
$idEntregable = $partes[1];
$dpto = $_GET['cbodpto_ot'];
$prov = $_GET['cboprov_ot'];
$dist = $_GET['cbodist_ot'];
$case = $_GET['cbocase_ot'];

$objPOA = new BLPOA();
//$idVS = $objPOA->UltimaVersionPoa($idProy, $anio);

$rsMod = $objPOA->listarPlanOtros(1, $idProy, $idVersion, NULL, NULL);
$arrMod = NULL;
$arrSub = NULL;
$arrTem = NULL;
?>
<table border="0" cellspacing="0" cellpadding="0" width="770">
	<tbody class="data" bgcolor="#eeeeee">
		<tr>
			<td colspan="2" align="center" valign="middle">
			    <b>Datos del Beneficiario </b>
		    </td>
            <?php
            while ($rm = mysqli_fetch_assoc($rsMod)) {
                $arrMod[] = $rm['codtipo'];
                ?>
            <td colspan="<?php echo($rm['numsub']); ?>" align="center" valign="middle" style="min-width: 120px;">
                <b><?php echo( $rm['nomtipo']);?></b></td>
            <?php } ?>
        </tr>
		<tr>
			<td width="3%" rowspan="2" align="center" valign="middle"><b>DNI</b></td>
			<td rowspan="2" align="center" valign="middle" style="min-width: 250px;"><b>Apellidos y </b><b>Nombres</b></td>
            <?php
            for ($x = 0; $x < count($arrMod); $x ++) {
                $rsSub = $objPOA->listarPlanOtros(2, $idProy, $idVersion, $arrMod[$x]);
                while ($rsub = mysqli_fetch_assoc($rsSub)) {
                    $codig = $rsub['codigo'];
                    $arrSub[$arrMod[$x]][] = $rsub['codigo'];
                    ?>
            <td colspan="<?php echo($rsub['numtema']);?>" align="center" valign="top" style="min-width: 120px;">
                <b><?php echo($rsub['codigo'].'<br>'.$rsub['t09_sub'])?></b>
				<input name="txtcodsub[]" type="hidden" id="txtcodsub[]" value="<?php echo($codig); ?>" class="PlanOtros" />
			</td>
              <?php
                }
            } ?>
        </tr>
	</tbody>
	<tbody class="data">
    <?php
    $objInf = new BLInformes();
    $iRsBenef = $objInf->listarPlanOtrosInfEntregable($idProy, $idVersion, $anio, $idEntregable, $dpto, $prov, $dist, $case);
    while ($rb = mysqli_fetch_assoc($iRsBenef)) {
        ?>
        <tr>
			<td width="3%" align="center" valign="middle">
			    <input name="txtbenef[]" type="hidden" id="txtbenef[]" value="<?php echo($rb['t11_cod_bene']); ?>" class="PlanOtros" />
	  	        <?php echo($rb['t11_dni']); ?>
            </td>
			<td valign="middle" style="min-width: 150px;"><?php echo($rb['nombres']); ?></td>
      <?php

        for ($x = 0; $x < count($arrMod); $x ++) {
            for ($y = 0; $y < count($arrSub[$arrMod[$x]]); $y ++) {
                $codig = $arrSub[$arrMod[$x]][$y];
                $avalotros = explode('|', $rb[$codig]);
                $valor = $avalotros[0]; // $rb[$codig] ;
                $cont = $avalotros[1];

                ?>
        			<td width="3%" valign="middle" align="center"><input
							type="hidden" name="txt_<?php echo($codig);?>[]"
							id="txt_<?php echo($codig);?>[]" class="PlanOtros" maxlength="20"
							value="<?php echo($valor);?>"
							style="width: 20px; text-align: center; text-transform: uppercase;"
							title="<?php echo($codig);?>" /> <input type="checkbox"
							name="chk_<?php echo($codig);?>[]"
							id="chk_<?php echo($codig);?>[]" class="PlanOtros" maxlength="20"
							value="1" <?php if($valor=='1'){echo("checked");}?>
							title="<?php echo($codig);?>"
							onclick="ActivarOtrosServ('<?php echo($codig);?>');"
							subact="<?php echo($codig);?>" /> <input type="text"
							name="val_<?php echo($codig);?>[]"
							id="val_<?php echo($codig);?>[]" class="PlanOtros" maxlength="20"
							value="<?php echo($cont);?>"
							style="width: 50px; text-align: center; text-transform: uppercase;"
							title="<?php echo($codig);?>" /></td>
        <?php
            }
        }

        ?>
    </tr>
    <?php } ?>
    </tbody>
</table>