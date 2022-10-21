<script language="Javascript"> 

function pregunta() { 
  return confirm('Estas seguro de grabar la Informacion ?'); }

</script>

<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<?php
// *************************************************************************************
// Programa: m_grabarbus.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Desarrollado en Año: 2010 II Semestre
// *************************************************************************************
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variables
$usuario = trim($_SESSION['usuario_login']);

//Verificando conexion
$sql = new mod_db();
$sql->connection();

//Variables
$tbname_1 = "stmbusfac";
$tbname_2 = "stmbusqueda";
$tbname_3 = "stmbusplan"; 
$tbname_4 = "stmtmpbus";

$fecha    = fechahoy();

$vopc       = $_GET['vopc'];
$vsol1      = $_POST['vsol1'];
$accion     = $_POST['accion'];
$factura    = $_POST['factura'];
$fechadep   = $_POST['fechadep'];
$prioridad  = $_POST['prioridad'];
$prioridad1 = $_POST['prioridad1'];
$solicitant = $_POST['solicitant'];
$indole     = $_POST['indole'];
$indole1    = $_POST['indole1'];
$lced       = $_POST['lced1'];
$nced       = $_POST['nced'];
$telefono   = $_POST['telefono']; 
$vsede      = $_POST['vsede'];
$nbusfon    = $_POST['nbusfon'];
$subtitulo  = "Solicitud(es) de B&uacute;squeda(s) Fon&eacute;tica y/o Gr&aacute;fica";

// ****************************************
$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo',$subtitulo);
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Opcion Grabar...
if ($vopc==2) {
  // Ingreso de Pedidos
  $horactual= Hora();
  $fechahoy = hoy();
  $sede     = 1;

  // Tabla de Busquedas Foneticas conteo... 
  $res_fone=pg_exec("SELECT * FROM $tbname_4 where nro_factura='$factura' AND tipo_bus='F' ORDER BY nro_planilla");
  $filas_res_fon=pg_numrows($res_fone); 

  // Tabla de Busquedas Graficas conteo... 
  //$res_graf=pg_exec("SELECT * FROM $tbname_4 where nro_factura='$factura' AND tipo_bus='G' ORDER BY nro_planilla");
  //$filas_res_graf=pg_numrows($res_graf); 

  //if (($filas_res_fon==0) AND ($filas_res_graf==0)) {
  if ($filas_res_fon==0) {
    mensajenew("ERROR: No ha ingresado las B&uacute;squeda Fonetica ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag2.tpl'); exit();
  }

  //if (($filas_res_fon < $nbusfon) || ($filas_res_graf < $nbusgra)) {
  if ($filas_res_fon < $nbusfon) {
    mensajenew("ERROR: NO ha ingresado la cantidad exacta de busquedas a solicitar ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag2.tpl'); exit();
  }

  $cedrif = $lced.$nced;
  if ($prioridad1=="B") { $vmonto = 113; } 
    { $vmonto = 150; } 

  $solicitant = str_replace("'","´",$solicitant);
  pg_exec("BEGIN WORK");
  // Tabla Temporal de Busquedas Foneticas y Graficas ... 
  $numfone = 0; 
  $insfone = true;
  $regfone = pg_fetch_array($res_fone);
  for($i=0;$i<$filas_res_fon;$i++) 
  {
    //Se obtiene el proximo valor segun stzsystem de pedbusqueda de acuerdo al valor asociado al Servidor Fonetico 
    $obj_query = $sql->query("update stzsystem set pedbusqueda=nextval('stzsystem_pedbusqueda_seq')");
    $obj_query = $sql->query("select last_value from stzsystem_pedbusqueda_seq");
    $objs = $sql->objects('',$obj_query);
    $sys_actual = $objs->last_value;
    $vpedido = $sys_actual;

    $clase = $regfone[clase];
    $planilla = $regfone[nro_planilla];
    $denominacion = trim($regfone[denominacion]);
    $denominacion = str_replace("'","´",$denominacion); 
    
    //Ingreso de datos de la busqueda y factura  
    $col_campos = "nro_pedido,f_pedido,tipobusq,solicitante,denominacion,clase,nro_recibo,usuario,monto,f_transac,hora_c,pagina,sede,identificacion,indole,telefono";
    $insert_str = "'$vpedido','$fechadep','$prioridad1','$solicitant','$denominacion','$clase','$factura','$usuario',$vmonto,'$fechahoy','$horactual',0,'$sede','$cedrif','$indole1','$telefono'"; 
    //echo " $col_campos  ***  $insert_str "; exit();
    $insfone = $sql->insert("$tbname_2","$col_campos","$insert_str","");
    if ($insfone) { }
      else { $numfone = $numfone + 1; }  

    //Ingreso de datos de la planilla busqueda 
    $tipobus = "F";
    $insert_str = "'$vpedido','$tipobus','$planilla','2013'"; 
    $insbuplan = $sql->insert("$tbname_3","","$insert_str","");
    if ($insbuplan) { }
      else { $numfone = $numfone + 1; }  

    $regfone = pg_fetch_array($res_fone); 
  }
  $del_datos = $sql->del("$tbname_4","nro_factura='$factura' AND tipo_bus='F'");

  // Tabla Temporal de Busquedas Graficas ... 
  $numgraf = 0; 
  //$insgraf = true;
  //$reggraf = pg_fetch_array($res_graf);
  //$ruta_original = $imagen_temp."/";
  //$ruta_final = $imagen_path."/";
  //for($i=0;$i<$filas_res_graf;$i++) 
  //{
  //  $logotipo = $ruta_original.trim($reggraf[denominacion]);
  //  $obj_query = $sql->query("update stzsystem set nro_bgra=nextval('stzsystem_nro_bgra_seq')");
  //  $obj_query = $sql->query("select last_value from stzsystem_nro_bgra_seq");
  //  $objs = $sql->objects('',$obj_query);
  //  $vnumgra = $objs->last_value;

  //  $imgnueva = $ruta_final.trim($vnumgra).".png"; //cambiar a png
  //  $cmd = "mv $logotipo $imgnueva";
  //  exec($cmd,$salida);
  //  foreach($salida as $line) { 
  //  echo "Hola<br>";	
  //  echo "$line<br>"; }    
      
  //  $col_campos = "nro_busgra,nro_tramite,archivo_logo,clase,f_vencimiento,usuario,f_transac,hora_trans";
  //  $insert_str = "$vnumgra,'$vsol1','$imgnueva',$reggraf[clase],'$fechavenc','$usuario','$reggraf[f_transac]','$reggraf[hora_trans]'";
  //  $insgraf = $sql->insert("$tbname_3","$col_campos","$insert_str","");
  //  if ($insgraf) { }
  //    else { $numgraf = $numgraf + 1; }  
  //  $reggraf = pg_fetch_array($res_graf); 
  //}
  //$del_datos = $sql->del("$tbname_4","nro_tramite='$vsol1' AND tipo_bus='G'");

  if (($numfone==0) && ($numgraf==0)) { 
    pg_exec("COMMIT WORK");
    //Desconexion de la Base de Datos
    $sql->disconnect();

    Mensajenew('DATOS GUARDADOS CORRECTAMENTE ...!!!','m_ingfacfon.php?vopc=1','S');
    $smarty->display('pie_pag2.tpl'); exit();
  }
  else {
    pg_exec("ROLLBACK WORK");
    //Desconexion de la Base de Datos
    $sql->disconnect();

    Mensajenew("Falla de Inserci&oacute;n de Datos en la BD ...!!!","../index1.php","N");
    $smarty->display('pie_pag2.tpl'); exit();
  }
}

?>
<html>
