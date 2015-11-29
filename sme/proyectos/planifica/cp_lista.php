<?php
/**
 * CticServices
 *
 * Muestra el Cronograma de Productos
 *
 * @package     sme/proyectos/planifica
 * @author      AQ
 * @since       Version 2.0
 *
 */

include("../../../includes/constantes.inc.php");
include("../../../includes/validauser.inc.php");

require_once (constant("PATH_CLASS") . "BLMarcoLogico.class.php");
require_once (constant("PATH_CLASS") . "BLPOA.class.php");
require_once (constant("PATH_CLASS") . "HardCode.class.php");
require_once (constant('PATH_CLASS') . "BLProyecto.class.php");

$idProy = $objFunc->__Request('idProy');
//$idVersion = $objFunc->__Request('idVersion');
$ObjSession->VerProyecto = 1;
$idVersion = 1;
$idComp = $objFunc->__Request('idComp');
$modif = $objFunc->__Request('modif');
$modificar = false;
$objProy = new BLProyecto();

if (md5("enable") == $modif) {
    $modificar = true;
}

$row = $objProy->ProyectoSeleccionar($idProy, $idVersion);
$t02_num_mes = $row['mes'];

$objHC = new HardCode();

if ($ObjSession->MaxVersionProy($idProy) > $idVersion && $ObjSession->PerfilID != $objHC->Admin) {
    $lsDisabled = 'disabled="disabled"';
} else {
    $lsDisabled = '';
}
if ($ObjSession->MaxVersionProy($idProy) > $idVersion && $ObjSession->PerfilID != $objHC->Admin) {
    $alsDisabled = 'onclick="return false"';
} else {
    $alsDisabled = '';
}

if ($objFunc->__QueryString() == "") {
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=charset=utf-8" />
    <link href="../../../css/itemplate.css" rel="stylesheet" type="text/css" media="all" />
	<title>Cronograma de Productos</title>
</head>
<body>
	<form id="frmMain" name="frmMain" method="post" action="#">
<?php
}
?>
        <div id="divTableLista" class="TableGrid">
			<table width="500px" border="0" cellpadding="0" cellspacing="0">
				<tr class="SubtitleTable" style="border: solid 1px #CCC; background-color: #eeeeee;">
					<td rowspan="2" align="center" style="border: solid 1px #CCC;">&nbsp;</td>
					<td rowspan="2" align="center" style="border: solid 1px #CCC;">Cod.</td>
					<td width="217" rowspan="2" align="center" style="border: solid 1px #CCC;">Indicador / Característica</td>
					<td width="72" rowspan="2" align="center" style="border: solid 1px #CCC;">Unidad Medida</td>
					<td width="49" rowspan="2" align="center" style="border: solid 1px #CCC;">Meta Fisica</td>
					<?php
    				    $objML = new BLMarcoLogico();
    				    $duracion = $objML->obtenerDuracion($idProy, $idVersion);

    				    $i = 0;
    				    while ($duracion > $i) {
                            $i++;
                    ?>
                        <td height="26" align="center" style="border: solid 1px #CCC; min-width: 30px;" colspan="<?php echo(MESES);?>">Año <?php echo($i);?></td>
    			     <?php } ?>
				</tr>
				<tr class="SubtitleTable" style="border: solid 1px #CCC; background-color: #eeeeee;">
                    <?php
                        $i = 0;
                        while ($duracion > $i) {
                            $i++;
                            $j = 0;
                            while(MESES > $j){
                                $j++;
                    ?>
					<td class="td-mes-<?php echo($i);?>" width="27" align="center" style="border: solid 1px #CCC;">Mes <?php echo($j);?></td>
                    <?php } } ?>
				</tr>
				<tr class="SubtitleTable" style="border: solid 1px #CCC; background-color: #eeeeee;">
				    <td height="22" align="center" nowrap="nowrap">
    				        <a href="#"> <input type="image"
    							<?php echo($lsDisabled);  if($modificar){ echo " disabled";}?>
    							src="../../../img/pencil.gif" alt="" width="12" height="13"
    							border="0" style="border: 0px;" title="Editar Entregables"
    							onclick="btnProgramarEntregables(); return false;" />
                            </a>
                    </td>
                    <?php
                        $r = $objML->listarEntregables($idProy, $idVersion);
                    ?>
                        <td width="49" colspan="4" align="center" style="border: solid 1px #CCC;">
    				        ENTREGABLES
    				        <input type="hidden" value="<?php echo($r['ids']);?>" id="ids" name="ids"/>
    			        </td>
                    <?php
                        $i = 0;
                        while ($duracion > $i) {
                            $i++;
                            $j = 0;
                            while(MESES > $j){
                                $j++;
                                $name = "entregables[".$i."][".$j."]";
                    ?>
					<td class="td-mes-<?php echo($i);?>" width="27" align="center" style="border: solid 1px #CCC;"><span id="<?php echo($name);?>"></span></td>
                    <?php } } ?>
				</tr>
				<tbody class="data">
                    <?php
                    $aRs = $objML->ListadoActividadesOE($idProy, $idVersion, $idComp);
                    $AnioPOA = $objML->Proyecto->GetAnioPOA($idProy, $idVersion);
                    $objPOA = new BLPOA();

                    if (mysql_num_rows($aRs) > 0) {
                        while ($ract = mysql_fetch_assoc($aRs)) {
                            $idAct = $ract["t09_cod_act"];
                            $nomItem = trim ($ract["t09_act"]);
                            if (empty($nomItem)) {
								continue;
							}
                    ?>
                  <tr class="RowData" style="background-color: #FC9; border: 1px #000;">
						<td align="left">&nbsp;</td>
						<td align="center"><?php echo($ract["t08_cod_comp"].'.'.$ract["t09_cod_act"]);?></td>
						<td colspan="<?php echo($duracion*MESES - 1);?>" align="left"><?php echo $nomItem;?></td>
						<td align="center">&nbsp;</td>
						<td width="99" align="center">&nbsp;</td>
						<td width="79" align="center">&nbsp;</td>
						<td width="85" align="center">&nbsp;</td>
						<?php /* ?>
						<td align="center" bgcolor="#FFFFFF" style="padding: 1px;">
<!-- 						    <a href="javascript:">
						        <input type="image" <?php echo($lsDisabled); if($modificar){ echo " disabled";}?>
								src="../../../img/nuevo.gif" style="border: 0px;" alt="" border="0" title="Nuevo Indicador"
								onclick="btnNuevo_Clic('<?php echo($idAct);?>'); return false;" />
 							</a> -->
						</td>
						<?php */ ?>
					</tr>
                    <?php
                        $iRs = $objML->ListadoIndicadoresAct($idProy, $idVersion, $idComp, $idAct);
                        while ($row = mysql_fetch_assoc($iRs)) {
                            $idInd = $row["t09_cod_act_ind"];
                            
                            if(empty($row['t09_ind'])) {
								continue;
							}
                            
                    ?>
                    <tr class="RowData">
						<td height="22" align="left" nowrap="nowrap">
						    <span>
						        <a href="javascript:"> <input type="image"
									<?php echo($lsDisabled);  if($modificar){ echo " disabled";}?>
									src="../../../img/pencil.gif" alt="" width="12" height="13"
									border="0" style="border: 0px;" title="Editar Indicador"
									onclick="btnProgramarIndicador('<?php echo($row["t09_cod_act"]);?>','<?php echo($row["t09_cod_act_ind"]);?>'); return false;" />
                                </a>
                            </span>
                        </td>
						<td align="center"> <span style="font-family: Tahoma;">I</span>.<?php echo($row["t08_cod_comp"].'.'.$row["t09_cod_act"].'.'.$row["t09_cod_act_ind"]);?></td>
						<td align="left"><?php echo($row["t09_ind"]);?></td>
						<td align="center"><?php echo($row["t09_um"]);?></td>
						<td align="center">
							<span>
			                    <?php echo(number_format($row["t09_mta"]));?>
                            </span>
						</td>
						<?php
                            $i = 0;
                            while ($duracion > $i) {
                                $i++;
                                $j = 0;

                                $lista = $objML->getProgramaIndicador($idProy, $idVersion, $idComp, $idAct, $row["t09_cod_act_ind"], $i);

                                while(MESES > $j){
                                    $j++;
                                    echo '<td width="27" align="center">'.(array_key_exists($j, $lista)?$lista[$j]:'').'</td>';
                                }
                            } ?>
                            <?php /* ?>
						<td height="22" align="left" nowrap="nowrap">
					        
						    <a href="javascript:">
						        <input type="image"	<?php echo($lsDisabled); if($modificar){ echo " disabled";}?>
								src="../../../img/bt_elimina.gif" alt="" style="border: 0px;"
								width="12" height="13" border="0" title="Eliminar Indicador"
								onclick="btnEliminarIndicador('<?php echo($row["t09_cod_act"]);?>','<?php echo($row["t09_cod_act_ind"]);?>','<?php echo($row["t09_ind"]);?>'); return false;" />
						    </a>
						    
						</td>
						<?php */ ?>
					</tr>
					<?php
                        $cRs = $objML->listarCaracteristicas($idProy, $idVersion, $idComp, $idAct, $idInd);

                        while ($row = mysql_fetch_assoc($cRs)) {
							$nombreCaracteristica = trim($row["t09_ind"]);
							if (empty($nombreCaracteristica)) {
								continue;
							}
                    ?>
                    <tr class="RowData row-crct">
						<td height="22" align="left" nowrap="nowrap">
						    <span>
						        <a href="javascript:"> <input type="image"
									<?php echo($lsDisabled);  if($modificar){ echo " disabled";}?>
									src="../../../img/pencil.gif" alt="" width="12" height="13"
									border="0" style="border: 0px;" title="Editar Característica"
									onclick="btnProgramarCaracteristica('<?php echo($row["t09_cod_act"]);?>','<?php echo($row["t09_cod_act_ind"]);?>','<?php echo($row["t09_cod_act_ind_car"]);?>'); return false;" />
                                </a>
                            </span>
                        </td>
						<td align="center"> <span style="font-family: Tahoma;">C</span>.<?php echo($row["t08_cod_comp"].'.'.$row["t09_cod_act"].'.'.$row["t09_cod_act_ind"].'.'.$row["t09_cod_act_ind_car"]);?></td>
						<td align="left" colspan="3"><?php echo $nombreCaracteristica;?></td>
						<?php
						    $cRsCtrl = $objML->listarCaracteristicasCtrl($idProy, $idVersion, $idComp, $idAct, $idInd, $row["t09_cod_act_ind_car"], true);

						    if($cRsCtrl['ids'] != ''){
						        $ids_crct .= ', '. $cRsCtrl['ids'];
                            }

                            $i = 0;
                            while ($duracion > $i) {
                                $i++;
                                $j = 0;
                                while(MESES > $j){
                                    $j++;
                                    $name = 'ctrls-'.$idComp.'-'.$idAct.'-'.$idInd.'-'.$row["t09_cod_act_ind_car"].'-['.$i.']['.$j.']';
                        ?>
                            <td class="td-car-<?php echo($i);?>" width="27" align="center"><span id="<?php echo($name);?>"></span></td>
                        <?php } } ?>
                        <?php /*?>
						<td height="22" align="left" nowrap="nowrap">
						    
						    <a href="javascript:">
						        <input type="image"	<?php echo($lsDisabled); if($modificar){ echo " disabled";}?>
								src="../../../img/bt_elimina.gif" alt="" style="border: 0px;"
								width="12" height="13" border="0" title="Eliminar Característica"
								onclick="btnEliminarCaracteristica('<?php echo($row["t09_cod_act"]);?>','<?php echo($row["t09_cod_act_ind"]);?>','<?php echo($row["t09_cod_act_ind_car"]);?>','<?php echo($row["t09_ind"]);?>'); return false;" />
						    </a>
						    
						</td>
						<?php */?>
					</tr>
                    <?php
                            }
                        }
                    }
                }
                else {
                ?>
                    <tr class="RowData">
						<td align="center">&nbsp;</td>
						<td align="center">&nbsp;</td>
						<td align="left">&nbsp;</td>
						<td align="center">&nbsp;</td>
						<td align="right">&nbsp;</td>
						<td align="center">&nbsp;</td>
						<td align="right">&nbsp;</td>
						<td align="right">&nbsp;</td>
						<td align="right">&nbsp;</td>
						<td align="right">&nbsp;</td>
					</tr>
            <?php } ?>
                </tbody>
			</table>
			<input type="hidden" id="ids-crct" name="ids-crct" value="<?php echo($ids_crct);?>" />
			<input type="hidden" name="t02_cod_proy" value="<?php echo($idProy);?>" />
			<input type="hidden" name="t02_version" value="<?php echo($idVersion);?>" />
			<input type="hidden" name="t08_cod_comp" value="<?php echo($idComp);?>" />
			<input type="hidden" name="t09_cod_act"	value="<?php echo($idAct);?>" />
		</div>
        <?php if($objFunc->__QueryString()=="") { ?>
    </form>
</body>
</html>
<?php } ?>