<?php include("../../includes/constantes.inc.php"); ?>

require (constant("PATH_CLASS") . "BLFE.class.php");
require (constant("PATH_CLASS") . "BLProyecto.class.php");

$objFE = new BLFE();
$objProy = new BLProyecto();

$Concurso = $objFunc->__Request('cboConcurso');
$Anio = $objFunc->__Request('cboAnios');
$sector = $objFunc->__Request('sector');
$region = $objFunc->__Request('region');

$anio_min = $objProy->AnioMenor();
$anio_max = $objProy->AnioMax();
?>
<?php if($objFunc->__QueryString()=="") { ?>
$totalp = 0;
$totale = 0;
for ($x = $anio_min; $anio_max >= $x; $x ++) {
    $rsProyectos = $objFE->ReCromPlaneadoAnio($x, $Concurso, $sector, $region);
    $planeado = 0;
    $ejecutado = 0;
    while ($row = mysqli_fetch_assoc($rsProyectos)) {
        $planeado += $row['planeado'];
        $ejecutado += $row['ejecutado'];
    }
    $row = mysqli_fetch_assoc($rsProyectos);
    $totalp += $planeado;
    $totale += $ejecutado;
    $porcentaje = ($ejecutado / $planeado);
    ?>
}
?>