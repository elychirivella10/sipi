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
// Programa: m_grabarbus1.php 
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
$sede    = $_SESSION['usuario_sede'];

//Verificando conexion
$sql = new mod_db();
$sql->connection();

//Variables
$tbname_1 = "stmbusfac";
$tbname_2 = "stmbusqueda";
$tbname_3 = "stmbusplan"; 
$tbname_4 = "stmtmpbus";
$tbname_5 = "stmcntrl";
$tbname_6 = "stmcvplan";
$tbname_7 = "stmcvbgra";
$tbname_8 = "stmfactura";
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
$nbusgra    = $_POST['nbusgra'];
$correo     = trim($_POST['email']); 
$vplus      = $_POST["vplus"];
$vplus1     = $_POST["vplus1"];
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
  //$sede     = 1;
  $malplanillas = "";
  $anio=substr($fechahoy,6,4);
  //echo "sede= $vsede, $sede ";
  
  if ($nbusfon!=0) {
    // Tabla de Busquedas Foneticas conteo... 
    $res_fone=pg_exec("SELECT * FROM $tbname_4 where nro_factura='$factura' AND tipo_bus='F' ORDER BY nro_planilla");
    $filas_res_fon=pg_numrows($res_fone); 

    if ($filas_res_fon==0) {
      mensajenew("ERROR: No ha ingresado las B&uacute;squeda Fonetica ...!!!","javascript:history.back();","N");
      $smarty->display('pie_pag2.tpl'); exit(); }

    if ($filas_res_fon < $nbusfon) {
      mensajenew("ERROR: NO ha ingresado la cantidad exacta de busquedas a solicitar ...!!!","javascript:history.back();","N");
      $smarty->display('pie_pag2.tpl'); exit();  }
  }

  if ($nbusgra!=0) {
    // Tabla de Busquedas Graficas conteo... 
    $res_graf=pg_exec("SELECT * FROM $tbname_4 where nro_factura='$factura' AND tipo_bus='G' ORDER BY nro_planilla");
    $filas_res_graf=pg_numrows($res_graf); 

    //if (($filas_res_fon==0) AND ($filas_res_graf==0)) {
    //if (($filas_res_fon < $nbusfon) || ($filas_res_graf < $nbusgra)) {
    if ($filas_res_graf==0) {
      mensajenew("ERROR: No ha ingresado las B&uacute;squeda Gr&aacute;ficas ...!!!","javascript:history.back();","N");
      $smarty->display('pie_pag2.tpl'); exit(); }

    if ($filas_res_graf < $nbusgra) {
      mensajenew("ERROR: NO ha ingresado la cantidad exacta de busquedas a solicitar ...!!!","javascript:history.back();","N");
      $smarty->display('pie_pag2.tpl'); exit(); }
  }

  $cedrif = $lced.$nced;
  if ($prioridad1=="B") { $vmonto = 113; } 
    { $vmonto = 150; } 

  $solicitant = str_replace("'","´",$solicitant);

  pg_exec("BEGIN WORK");

  // Tabla Temporal de Busquedas Foneticas ... 
  $numfone = 0; 
  if ($nbusfon!=0) {
    $insfone = true;
    $regfone = pg_fetch_array($res_fone);
    for($i=0;$i<$filas_res_fon;$i++) 
    {
      $clase = $regfone[clase];
      $planilla = $regfone[nro_planilla];
      $denominacion = trim($regfone[denominacion]);
      $denominacion = str_replace("'","´",$denominacion); 

      $objquery = $sql->query("SELECT * FROM stmbusplan WHERE cod_planilla='$planilla'");
      $objfilas = $sql->nums('',$objquery);
      if ($objfilas!=0) { 
        $numfone = $numfone + 1; 
        if ($malplanillas=='') { $malplanillas = $planilla; }
        else { $malplanillas = $malplanillas.",".$planilla; }   
      }   

      //echo "control= $numfone ";
      if ($numfone==0) {
        //Se obtiene el proximo valor segun stzsystem de pedbusqueda de acuerdo al valor asociado al Servidor Fonetico 
        $obj_query = $sql->query("update stzsystem set pedbusqueda=nextval('stzsystem_pedbusqueda_seq')");
        $obj_query = $sql->query("select last_value from stzsystem_pedbusqueda_seq");
        $objs = $sql->objects('',$obj_query);
        $sys_actual = $objs->last_value;
        $vpedido = $sys_actual;
    
        //Ingreso de datos de la busqueda y factura  
        $col_campos = "nro_pedido,f_pedido,tipobusq,solicitante,denominacion,clase,nro_recibo,usuario,monto,f_transac,hora_c,pagina,sede,identificacion,indole,telefono,envio,estatus_envio,email";
        $insert_str = "'$vpedido','$fechadep','$prioridad1','$solicitant','$denominacion','$clase','$factura','$usuario',$vmonto,'$fechahoy','$horactual',0,'$sede','$cedrif','$indole1','$telefono','$vplus1','N','$correo'"; 
        //echo " $col_campos  ***  $insert_str "; exit();
        $insfone = $sql->insert("$tbname_2","$col_campos","$insert_str","");
        if ($insfone) { }
          else { $numfone = $numfone + 1; }  
        //echo "1- $numfone ";
        //Ingreso de datos de la planilla busqueda 
        $tipobus = "F";
        $insert_str = "'$vpedido','$tipobus','$planilla','$anio'"; 
        $insbuplan = $sql->insert("$tbname_3","","$insert_str","");
        if ($insbuplan) { }
        else { $numfone = $numfone + 1; }  
        //echo "2- $numfone ";
      }
      $regfone = pg_fetch_array($res_fone); 
    }
    $del_datos = $sql->del("$tbname_4","nro_factura='$factura' AND tipo_bus='F'");
    
  }

  // Tabla Temporal de Busquedas Graficas ... 
  $numgraf = 0; 

  if ($nbusgra!=0) {
    $insgraf = true;
    $reggraf = pg_fetch_array($res_graf);
    $ruta_original = $imagen_temp."/";
    $ruta_final = $imagen_def."/";
    //echo "son= $filas_res_graf ";
    for($i=0;$i<$filas_res_graf;$i++) 
    {
      $clase = $reggraf[clase];
      $planilla = trim($reggraf[nro_planilla]);
      $denominacion = trim($reggraf[denominacion]);
      //echo "plan= $planilla, i=$i  ";
      
      if ($planilla!='') {            
        $objquery = $sql->query("SELECT * FROM stmbusplan WHERE cod_planilla='$planilla'");
        $objfilas = $sql->nums('',$objquery);
        if ($objfilas!=0) { 
          $numgraf = $numgraf + 1; 
          if ($malplanillas=='') { $malplanillas = $planilla; }
          else { $malplanillas = $malplanillas.",".$planilla; }
        }     
      }

      if ($numgraf==0) {
        $logotipo = $ruta_original.trim($reggraf[denominacion]);
        $obj_query = $sql->query("update stzsystem set figurativo=nextval('stzsystem_figurativo_seq')");
        $obj_query = $sql->query("select last_value from stzsystem_figurativo_seq");
        $objs = $sql->objects('',$obj_query);
        $vnumgra = $objs->last_value;

        //$obj_query = $sql->query("update stzsystem set nro_bgra=nextval('stzsystem_nro_bgra_seq')");
        //$obj_query = $sql->query("select last_value from stzsystem_nro_bgra_seq");
        //$objs = $sql->objects('',$obj_query);
        //$vnumgra = $objs->last_value;
        //Anteriormente numero de pedido era la imagen
        //$imgnueva = $ruta_final.trim($vnumgra).".png"; //cambiar a png
    
        $imgnueva = $ruta_final.trim($planilla).".jpg"; //cambiar a png
        $cmd = "mv $logotipo $imgnueva";
        exec($cmd,$salida);
      
        //Ingreso de datos de la busqueda y factura  
        $col_campos = "pedido,recibo,fecharec,hora,solicitant,fechaing,estatus,usuario,imagfile,prioridad,identificacion,indole,telefono,sede,clase,envio,estatus_envio,email";
        $insert_str = "'$vnumgra','$factura','$fechadep','$horactual','$solicitant','$fechahoy','1','$usuario','$imgnueva','$prioridad1','$cedrif','$indole1','$telefono','$sede','$clase','$vplus1','N','$correo'"; 
        //echo " $col_campos  ***  $insert_str "; exit();
        $insgraf = $sql->insert("$tbname_5","$col_campos","$insert_str","");
        if ($insgraf) { }
        else { $numgraf = $numgraf + 1; }  

        //Ingreso de datos de la planilla busqueda 
        $tipobus = "G";
        $insert_str = "'$vnumgra','$tipobus','$planilla','$anio'"; 
        $insbuplan = $sql->insert("$tbname_3","","$insert_str","");
        if ($insbuplan) { }
        else { $numgraf = $numgraf + 1; }

        //echo " error 1= $numgraf ";        
        $objsqlccv = $sql->query("SELECT ccv FROM stmcvplan WHERE factura='$factura' AND cod_planilla='$planilla'");
        $objfilccv = $sql->nums('',$objsqlccv); 
        //echo "codigos=  $objfilccv ";
        $objcampo  = $sql->objects('',$objsqlccv);
        for($j=0;$j<$objfilccv;$j++) {
        	 $codv = $objcampo->ccv; 
        	 //echo " $codv para $planilla ";
          $insert_val = "'$vnumgra','$codv'";
          $sql->insert("$tbname_7","","$insert_val","");
          $objcampo  = $sql->objects('',$objsqlccv);
        }   
        //echo " error 2= $numgraf ";        
          
      }
      $reggraf = pg_fetch_array($res_graf); 
    }
    //$del_datos = $sql->del("$tbname_4","nro_factura='$vfac' AND tipo_bus='G'");
    //$del_datos = $sql->del("$tbname_6","factura='$vfac'");
  }
 //echo " final= $numfone, $numgraf "; exit();
  $col_campos = "nro_factura,fecha_factura,cant_fonetica,cant_grafica,cant_derecho,sede";
  $insert_str = "'$factura','$fechadep',$nbusfon,$nbusgra,0,'$sede'";  
  $insfactu = $sql->insert("$tbname_8","$col_campos","$insert_str","");
 
  if (($numfone==0) && ($numgraf==0) && ($insfactu)) { 
    pg_exec("COMMIT WORK");
    //Desconexion de la Base de Datos
    $sql->disconnect();
    //echo " Facturaci&oacute;n o Exoneraci&oacute;n No.: $factura, cargado por el Usuario: $usuario ";
    //Mensajenew('DATOS GUARDADOS CORRECTAMENTE ...!!!','m_ingfacfon1.php?vopc=1','S');
    //if ($nbusfon!=0) {
    //  Mensaje2("DATOS GUARDADOS CORRECTAMENTE ...!!!","m_ingfacfon1.php?vopc=1","m_rptingfon.php?vfac=$factura&vusr=$usuario"); }
    //else {
    //  Mensaje2("DATOS GUARDADOS CORRECTAMENTE ...!!!","m_ingfacfon1.php?vopc=1","m_rptingraf.php?vfac=$factura&vusr=$usuario"); }
    Mensaje2("DATOS GUARDADOS CORRECTAMENTE ...!!!","m_ingfacfon1.php?vopc=1","m_rptingbus.php?vfac=$factura&vusr=$usuario&nfon=$nbusfon&ngra=$nbusgra");
    $smarty->display('pie_pag2.tpl'); exit();
  }
  else {
    pg_exec("ROLLBACK WORK");
    //Desconexion de la Base de Datos
    $sql->disconnect();
    //echo "Planillas que NO puderon ser Cargadas: ".$malplanillas;
    echo "<font face='Arial' color='#800000' size='2'>AVISO, Planillas que impidieron la Carga de la Factura: ".$malplanillas."</font>";
    Mensajenew("Falla de Inserci&oacute;n de Datos de la Factura/Exoneraci&oacute;n en la BD ...!!!","../index1.php","N");
    $smarty->display('pie_pag2.tpl'); exit();
  }
}

?>
<html>
