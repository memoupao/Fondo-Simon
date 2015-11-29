<?php include_once("../includes/constantes.inc.php"); ?>

<?php include_once("../includes/validauseradm.inc.php"); ?>

<?php

require_once (constant('PATH_CLASS') . "BLMantenimiento.class.php");
require_once (constant('PATH_CLASS') . "HardCode.class.php");

$objMante = new BLMantenimiento();
$HC = new HardCode();

$view = $objFunc->__GET('mode');

$row = 0;

if ($view == md5("ajax_edit")) 

{
    
    $objFunc->SetSubTitle("Editando Concursos");
    
    $id = $objFunc->__GET('id');
    
    $row = $objMante->ConcursoSeleccionar($id);
} 

else {
    
    $row = 0;
    
    $objFunc->SetSubTitle("Nuevo Concurso");
}

?>



<?php if($view=='') { ?>

<?php
    
$objFunc->verifyAjax();
    
    if (! $objFunc->Ajax) {
        ?>

<meta name="keywords" content="<?php echo($objFunc->Keywords); ?>" />
<link href="../jquery.ui-1.5.2/themes/ui.datepicker.css" rel="stylesheet" type="text/css" />
<?php } ?>

</head>

 <?php } ?>

	<div id="EditForm" style="width: 700px; border: solid 1px #D3D3D3;">
							<?php 
							// -------------------------------------------------->
							// DA 2.0 [07-11-2013 10:48]
							// Nuevos campos de tasas por lineas del concurso.
							// En caso de que exista un concurso ya registrado y mas adelante se
							// se registre nuevas lineas, estas tendran que ser adicionados manualmente
							// ya que para el registro se obtendran con las ultimas lineas registradas y
							// si se edita el concurso se obtendrasn con las lineas ya registradas mas no 
							// las nuevas lineas (si en caso de haberlas).
							
							?>
							<tr>
								<td>
								
								<fieldset>
    								<legend>Tasas del Concurso</legend>
    								<div class="TableGrid">
    								<table width="100%" border="0" cellspacing="1" cellpadding="0" class='TableGrid'>
    								    <thead>
    								    <tr>
    								        <th>Lineas \ Tasas</th>
    								        <th>(%) Gastos Funcionales</th>
    								        <th>(%) Linea Base</th>
    								        <th>(%) Imprevistos</th>
    								        <th>(%) Gastos Supervision del Proyecto</th>
    								    </tr>
    								    </thead>
    								    <tbody>
    								    <?php
    								    
    								    $rs = $objMante->getListTasasPorConcurso($id);
    								    $posLinea = 0;
    								    while ($row = mysql_fetch_assoc($rs)) {            
                                            $posLinea++;
                                             
                                        ?>
                                        <tr>
    								        <th>
    								            <?php echo $row['abrev'];?>
    								            <small><?php echo $row['nombre'];?></small>
    								            <input type="hidden" name="linea_<?php echo $posLinea;?>" value="<?php echo $row['codigo'];?>">
    								        </th>
    								        
    								        <td><input class="inputSmall" type="text" name="tfun_<?php echo $posLinea;?>" value="<?php echo  (isset($row['porc_gast_func']) ? $row['porc_gast_func'] : $HC->Porcent_Gast_Func);;?>"/></td>
    								        <td><input class="inputSmall" type="text" name="tlib_<?php echo $posLinea;?>" value="<?php echo (isset($row['porc_linea_base']) ? $row['porc_linea_base'] : $HC->Porcent_Linea_Base); ?>"/></td>
    								        <td><input class="inputSmall" type="text" name="timp_<?php echo $posLinea;?>" value="<?php echo (isset($row['porc_imprev']) ? $row['porc_imprev'] : $HC->Porcent_Imprevistos);?>"/></td>
    								        <td><input class="inputSmall" type="text" name="tgsp_<?php echo $posLinea;?>" value="<?php echo (isset($row['porc_gast_superv_proy']) ? $row['porc_gast_superv_proy'] : $HC->porcentGastSupervProy);?>"/></td>
    								    </tr>                                   
                                        <?php } ?>
                                        </tbody>    								    
    								</table>
    								</div>
    								    <input type="hidden" name="totLineas" value="<?php echo $posLinea;?>"  />
							     </fieldset>
								
								</td>
							</tr>
							<?php // --------------------------------------------------< ?>

  function btnGuardar_Clic()

	{

	 if( $('#txtanio').val()=="" ) {alert("Ingrese el año del concurso"); $('#txtanio').focus(); return false;}	
	 if( $('#txtnombre').val()=="" ) {alert("Ingrese el nombre del concurso"); $('#txtnombre').focus(); return false;}	

	 if( $('#txtabreviado').val()=="" ) {alert("Ingrese Nombre Abreviado del Concurso"); $('#txtabreviado').focus(); return false;}	

		// -------------------------------------------------->
	    // DA 2.0 [04-11-2013 12:54]
	    // Validacion de longitud minima en formulario de edicion y nuevo 	
	    if (typeof(isValidFormsMantenimiento) == "function") {		    
		    	if( ! isValidFormsMantenimiento() ) return false;
		}
		// --------------------------------------------------<
			 

	 var BodyForm = $("#FormData").serialize() ;

	 var sURL = "man_conc_process.php?action=<?php echo($view);?>"

	 var req = Spry.Utils.loadURL("POST", sURL, true, MySuccessCallback, { postData: BodyForm, headers: { "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8" }, errorCallback: MyErrorCallback });

	

	return false;

	

	}

</script>

  



 <?php if($view=='') { ?>

  <!-- InstanceEndEditable -->


