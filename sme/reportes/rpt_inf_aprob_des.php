<?php include("../../includes/constantes.inc.php"); ?>
<?php include("../../includes/validauser.inc.php"); ?>
<?php

require_once (constant("PATH_CLASS") . "BLProyecto.class.php");

require_once (constant("PATH_CLASS") . "BLReportes.class.php");

require (constant("PATH_CLASS") . "BLFE.class.php");

require (constant("PATH_CLASS") . "BLTablasAux.class.php");

$Consurso = $objFunc->__Request('cboconcurso');

$idInstitucion = $objFunc->__Request('cboinstitucion');

?>


<?php if($idProy=='') { ?>
<?php } ?>
<div id="divBodyAjax" class="TableGrid">
      <?php
    
    $objFE = new BLFE();
    
    $iRs = $objFE->ListadoProyectos_Aprob_Primer_Desembolso($Consurso, $idInstitucion);
    
    $RowIndex = 0;
    
    if ($iRs->num_rows > 0) 

    {
        
        while ($row = mysqli_fetch_assoc($iRs)) {
            
            $rAprob = $objFE->Aprobacion_Primer_Desemb_Seleccionar($row['t59_id_aprob']);
            
            if ($rAprob['t59_aprueba_mf'] == '1') {
                $colorpendiente = "style=\"color:#039;\"";
            } else {
                $colorpendiente = "";
            }
            
            ?>
      <tr class="RowData" <?php echo($colorpendiente);?>
      <?php
            
            $RowIndex ++;
        }
        
        $iRs->free();
    } 

    else 

    {
        
        ?>
        <tr>
       <?php  }  ?>
    </tbody>
<?php if($objFunc->__QueryString()=="") { ?>
</form>