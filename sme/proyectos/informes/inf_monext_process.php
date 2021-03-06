<?php include("../../../includes/constantes.inc.php"); ?>
<?php include("../../../includes/validauserxml.inc.php"); ?>

<?php
require (constant('PATH_CLASS') . "BLInformes.class.php");
require_once (constant('PATH_CLASS') . "Validator.class.php");
?>

<?php

$Accion = $objFunc->__GET('action');

if ($Accion == '') {
    echo (Error());
    exit();
}

if (md5("ajax_new") == $Accion || md5("ajax_edit") == $Accion) {
    GuardarInforme($Accion);
    exit();
}

if (md5("ajax_del") == $Accion) {
    EliminarInforme();
    exit();
}

if (md5("ajax_ind_componente") == $Accion) {
    GuardarIndicadoresComponente();
    exit();
}

if (md5("ajax_indicadores_prod") == $Accion) {
    guardarIndicadoresProd();
    exit();
}

if (md5("ajax_actividad") == $Accion) {
    guardarActividades();
    exit();
}

if (md5("ajax_conclusiones") == $Accion) {
    guardarConclusiones();
    exit();
}

if (md5("ajax_calificacion") == $Accion) {
    guardarCalificaciones();
    exit();
}

if (md5("ajax_save_anexos") == $Accion) {
    guardarAnexosSE();
    exit();
}

if (md5("ajax_del_anexos") == $Accion) {
    eliminarAnexoSE();
    exit();
}

// -------------------------------------------------->
// DA 2.1 [24-04-2014 12:27]
// Actualizacion de las Observaciones del Avance Financiero
if (md5("ajax_avance_financiero") == $Accion) {	
	guardarAvanceFinanciero();
	exit;
}
// --------------------------------------------------<

?>
<?php
// nforme Mensual - Cabecera
function GuardarInforme($tipo)
{
    $objInf = new BLInformes();
    $bret = false;
    $retvs = 0; // Version del Informe
    $isValidIniVisDate = Validator::validateDate($_POST['iniVisita']);
    $isValidFinVisDate = Validator::validateDate($_POST['terVisita']);

    ob_clean();
    ob_start();

    if (!$isValidIniVisDate) {
        echo ("ERROR : \nFecha de Inicio de Visita no es válida.");
    } elseif (! $isValidFinVisDate) {
        echo ("ERROR : \nFecha de Término de Visita no es válida.");
    } elseif (Validator::compareDates($_POST['iniVisita'], $_POST['terVisita']) !== - 1) {
        echo ("ERROR : \nFecha de Inicio de Visita no puede ser mayor que la Fecha de Término de Visita.");
    } else {
        if ($tipo == md5("ajax_new")){
            $bret = $objInf->guardarCabInfSE();
        } else if ($tipo == md5("ajax_edit")) {
            $bret = $objInf->actualizarCabInfSE();
        }
        if ($bret)
            echo ("Exito Se guardaron los Datos correctamente");
        else
            echo ("ERROR : \n" . $objInf->GetError());
    }
    return $bret;
}

function EliminarInforme()
{
    ob_clean();
    ob_start();
    $objInf = new BLInformes();

    $bret = false;
    $bret = $objInf->eliminarInfSE();
    if ($bret) {
        echo ("Exito Se eliminó correctamente el Informe de Supervisión Externa");
    } else {
        echo ("ERROR : \n" . $objInf->GetError());
    }
    return $bret;
}
// ---

// ndicadores de Componente
function GuardarIndicadoresComponente()
{
    $objInf = new BLInformes();

    $bret = false;
    $bret = $objInf->guardarIndicadoresComponenteSE();
    ob_clean();
    ob_start();
    if ($bret) {
        echo ("Exito Se guardaron correctamente los Indicadores de Componente");
    } else {
        echo ("ERROR : \n" . $objInf->GetError());
    }
    return $bret;
}
// Indicadores de Actividad
function guardarIndicadoresProd()
{
    $objInf = new BLInformes();

    $bret = false;
    $bret = $objInf->guardarIndicadoresProdSE();

    ob_clean();
    ob_start();
    if ($bret) {
        echo ("Exito Se guardaron correctamente los Indicadores de Producto");
    } else {
        echo ("ERROR : \n" . $objInf->GetError());
    }
    return $bret;
}

// Actividades
function guardarActividades()
{
    $objInf = new BLInformes();

    $bret = false;
    $bret = $objInf->guardarActSE();
    ob_clean();
    ob_start();
    if ($bret) {
        echo ("Exito Se guardaron correctamente las obervaciones para las Actividades");
    } else {
        echo ("ERROR : \n" . $objInf->GetError());
    }
    return $bret;
}


// -------------------------------------------------->
// DA 2.1 [24-04-2014 12:27]
// Actualizacion de las Observaciones del Avance Financiero
function guardarAvanceFinanciero()
{
	$objInf = new BLInformes();
	$bret = false;
	$bret = $objInf->guardarAvanceFinancieroSE();
	ob_clean();
	ob_start();
	if ($bret) {
		echo ("Exito Se guardaron correctamente El Avance Financiero del Informe de Supervisión");
	} else {
		echo ("ERROR : \n" . $objInf->GetError());
	}
	return $bret;
}
// --------------------------------------------------<



// onclusiones
function guardarConclusiones()
{
    $objInf = new BLInformes();
    $bret = false;
    $bret = $objInf->guardarConclusionesSE();
    ob_clean();
    ob_start();
    if ($bret) {
        echo ("Exito Se guardaron correctamente las conclusiones del Informe de Supervisión");
    } else {
        echo ("ERROR : \n" . $objInf->GetError());
    }
    return $bret;
}
// alificaciones
function guardarCalificaciones()
{
    $objInf = new BLInformes();

    $bret = false;
    $bret = $objInf->guardarCalificacionesSE();

    ob_clean();
    ob_start();
    if ($bret) {
        echo ("Exito Se guardaron correctamente las calificaciones del Informe de Supervisión");
    } else {
        echo ("ERROR : \n" . $objInf->GetError());
    }
    return $bret;
}
// nexos
function guardarAnexosSE()
{
    $objInf = new BLInformes();
    $oFn = new Functions();

    $bret = false;
    $bret = $objInf->guardarAnexosSE();

    ob_clean();
    ob_start();
    if ($bret) {
        // echo("Exito Se Guardaron correctamente los Anexos Fotograficos");
        $HardCode = "alert('" . "Se Guardaron correctamente los Anexos del Informe" . "'); \n";
        $HardCode .= "parent.LoadAnexosSE(true); \n";
        $oFn->Javascript($HardCode);
    } else {
        $HardCode = "alert('" . $objInf->GetError() . "'); \n";
        // echo("ERROR : \n".$objInf->GetError());
    }
    return $bret;
}

function eliminarAnexoSE()
{
    ob_clean();
    ob_start();
    $objInf = new BLInformes();
    $bret = false;
    $bret = $objInf->eliminarAnexoSE();
    if ($bret) {
        echo ("Exito Se Elimino correctamente el Anexo del Informe de Supervisión");
    } else {
        echo ("ERROR : \n" . $objInf->GetError());
    }
    return $bret;
}

function Error($errormsg = "Error al Recibir Parametros")
{
    $err = "<b style='color:red'>Error:</b><br>" . $errormsg;
    echo ($err);
    return;
}
?>

<?php ob_end_flush(); ?>