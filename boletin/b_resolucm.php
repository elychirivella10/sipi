<?php
// *************************************************************************************
// Programa: b_resolucm.php 
// Realizado por el Analista de Sistema Karina Perez
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Desarrollado Año: 2010
// Modificado Año 
// *************************************************************************************
 // Funcion que permite llevar la fecha de numeros a letras
 function Cambiar_fecha_res($fechaini)
 {
   $dia=substr($fechaini,8,2);
   $mes=substr($fechaini,5,2);
   $anio=substr($fechaini,0,4);
   if ($mes=='01') {$mes=' DE ENERO DE ';}
   if ($mes=='02') {$mes=' DE FEBRERO DE ';}
   if ($mes=='03') {$mes=' DE MARZO DE ';}
   if ($mes=='04') {$mes=' DE ABRIL DE ';}
   if ($mes=='05') {$mes=' DE MAYO DE ';}
   if ($mes=='06') {$mes=' DE JUNIO DE ';}
   if ($mes=='07') {$mes=' DE JULIO DE ';}
   if ($mes=='08') {$mes=' DE AGOSTO DE ';}
   if ($mes=='09') {$mes=' DE SEPTIEMBRE DE ';}
   if ($mes=='10') {$mes=' DE OCTUBRE DE ';}
   if ($mes=='11') {$mes=' DE NOVIEMBRE DE ';}
   if ($mes=='12') {$mes=' DE DICIEMBRE DE ';}
   $fecha=$dia.$mes.$anio;
   return $fecha;
 }

 function resolucion($nbol,$anoi,$anof,$nro_resol) {

 $boletin = $nbol;
 $numbol = $boletin;
 $nro_resoluc = $nro_resol;
 global $numbol,$pagina,$boletin,$nro_resoluc;
 $boletin = $nbol;
 $numbol = $boletin;
 $nro_resoluc = $nro_resol;


//****************************************************************************************
//Resoluciones de marcas
//****************************************************************************************

//Busqueda de resoluciones x boletin
$res_resul = pg_exec("SELECT * FROM res.res_tmpboletin WHERE tmp_boletin = '$nbol'");
$nfil = pg_numrows($res_resul);
if ($nfil==0) {$mensaje= $mensaje.'  - No se genero Resoluciones de Marcas ';} 
else {
$mensaje= $mensaje.'  - Se genero Resoluciones de Marcas ';
 //Inicio del Pdf
$mpdf=new mPDF();

 for($cont=0;$cont<$nfil;$cont++) { 
 //busqueda de los datos de la resolucion
 $resultado=pg_exec("SELECT *	
	FROM res.res_tmpboletin a, res.res_resoluciones b
	WHERE a.tmp_idpreres = b.res_preid
	");
 $registro = pg_fetch_array($resultado);
 $filas_resultado=pg_numrows($resultado); 
 $total=$filas_resultado;
 if ($filas_resultado==0) {} 
 else { 
 // Montando la resolucion

      $nro_resoluc = $nro_resoluc+1;
      
      $mpdf->WriteHTML("_______________________________________________________________________________________________________");
      $mpdf->WriteHTML($registro['res_encabezado']); 
      // fecha y numero de resolucion
      $mpdf->ln(6); 
      
      $mpdf->WriteHTML('Caracas, '.strtolower(Cambiar_fecha_res($registro['res_fechafin'])));      
      $mpdf->ln(6); 
      $mpdf->WriteHTML('Resolucion No: '.$nro_resoluc);       
      $mpdf->ln(6); 
            
      $mpdf->WriteHTML($registro['res_vistos']); 
      $mpdf->WriteHTML($registro['res_oponente']); 
      $mpdf->WriteHTML($registro['res_contestante']); 
      $mpdf->WriteHTML($registro['res_analisis']); 
      $mpdf->WriteHTML($registro['res_motiva']); 
      $mpdf->WriteHTML($registro['res_desicion']); 
      $mpdf->WriteHTML($registro['res_pie']);        
        
      $mpdf->ln(12);   

       // Graba el numero de resolucion en las tablas de resoluciones

      pg_exec("LOCK TABLE res.res_tmpboletin IN SHARE ROW EXCLUSIVE MODE");

      $actualiza=pg_exec("UPDATE res.res_tmpboletin SET tmp_resid='$nro_resoluc' WHERE res.res_tmpboletin.tmp_idpreres = '$registro[res_preid]'");
     // $sql->disconnect();
                                    
  }//fin de else
 } //fin del for  
 
 $mpdf->Output("../../boletin/boletin_reslm.pdf");
} //fin del else si no hay resultado (filas_resultado)

//Salida del Reporte
echo "<H3><p><img src='../imagenes/messagebox_warning.png' align='middle'> $mensaje</p></H3>"; 

return $nro_resoluc;

}
       
?>
