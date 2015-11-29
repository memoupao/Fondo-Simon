<?php include("../../includes/constantes.inc.php"); ?>

require_once (constant("PATH_CLASS") . "BLFE.class.php");

$objFE = new BLFE();
$Concurso = $objFunc->__Request('cboConcurso');
$Anio = $objFunc->__Request('anio');

?>

function LoadReportData(&$pResultSet, $pLv1, $pLv2, $pLv3, $pSum)
{
    $total = 0;
    $aReportData = array();
    while ($row = mysqli_fetch_assoc($pResultSet)) {
        $aSum = $row[$pSum] == "" ? 0 : $row[$pSum];
        $aReportData[$row[$pLv1]][$row[$pLv2]][$row[$pLv3]] = $aSum;
        $total += $aSum;
    }
    return $aReportData;
}

function GenerateReportOutput($pReportData)
{
    $aTotal = 0;
    foreach ($pReportData as $aLv1Name => $aLv1ArrData) {
        $aLv1Rows = 0;
        $aLv1Flg = true;
        $aLv2Td = '';
        foreach ($aLv1ArrData as $aLv2Name => $aLv2ArrData) {
            $aLv2Rows = 0;
            $aLv2Flg = true;
            $aLv3Td = '';
            foreach ($aLv2ArrData as $aLv3Name => $aSumNum) {
                $aLv1Rows ++;
                $aLv2Rows ++;
                $aTotal += $aSumNum;
                if (! $aLv2Flg)
                    $aLv3Td .= "<tr>";
                $aLv3Td .= "<td>$aLv3Name</td><td align='center'>" . number_format($aSumNum) . "</td></tr>";
                $aLv2Flg = false;
            }
            if (! $aLv1Flg)
                $aLv2Td .= "<tr>";
            $aLv2Td .= "<td rowspan='$aLv2Rows' " . "align='left' valign='middle'>" . $aLv2Name . "</td>" . $aLv3Td;
            $aLv1Flg = false;
        }
        $aLv1Td = "<tr><td rowspan='$aLv1Rows' " . "align='left' valign='middle'>" . $aLv1Name . "</td>" . $aLv2Td . "</tr>";
        echo $aLv1Td;
    }
    
    return $aTotal;
}
?>
$aResultSet = $objFE->RepTipoServRegion($Anio, $Concurso);
$aReportData = LoadReportData($aResultSet, 'servicio', 'modulo', 'region', 'benef');
$aReportTotal = GenerateReportOutput($aReportData);

?>
$aResultSet = $objFE->RepTipoServSector($Anio, $Concurso);
$aReportData = LoadReportData($aResultSet, 'servicio', 'modulo', 'actividad', 'benef');
$aReportTotal = GenerateReportOutput($aReportData);
?>