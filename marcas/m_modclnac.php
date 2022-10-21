<script language="Javascript"> 
  function pregunta() { 
    return confirm('Estas seguro de grabar la Informacion ?'); }
</script>

<?php
// *************************************************************************************
// Programa: m_modclas.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MILCO
// Desarrollado Año 2009 II Semestre BD - Relacional 
// *************************************************************************************

//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variables
$usuario   = $_SESSION['usuario_login'];
$sql       = new mod_db();
$fecha     = fechahoy();
$modulo    = "m_modclas.php";

$tbname_1 = "stzderec";
$tbname_2 = "stmmarce";
$tbname_3 = "stmclnac";
$tbname_4 = "stmbatfon";
$tbname_5 = "stzbitac";

$vopc     = $_GET['vopc'];
$vaccion  = $_GET['vaccion'];
$vsol1    = $_POST['vsol1'];
$vsol2    = $_POST['vsol2'];
$vsol     = $_POST['vsol'];
$vder     = $_POST['vder'];

$fecha_solic =$_POST['fecha_solic'];
$tipo_marca  =$_POST['tipo_marca'];
$nombre      =$_POST['nombre'];
$clase_id    =$_POST['clase_id'];
$vclase      =$_POST['vclase'];
$distingue   =$_POST['distingue'];
$dirano      =$_POST['dirano'];
$accion      =$_POST['accion'];
$vder        =$_POST['vder'];
$vclnac      =$_POST['vclnac'];
$modalidad   =$_POST['modalidad'];
$mstring1    =$_POST['mstring1'];
$campos1     =$_POST['campos1'];
$mstring2    =$_POST['mstring2'];
$campos2     =$_POST['campos2'];
$mstring3    =$_POST['mstring3'];
$campos3     =$_POST['campos3'];

// ************************************************************************************  
$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Mantenimiento de Expediente / Modificaci&oacute;n Clase'); 
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

$smarty->assign('arraytipom',array(V,M,N,L,S,C,D));
$smarty->assign('arraynotip',array('','MARCA DE PRODUCTO','NOMBRE COMERCIAL','LEMA COMERCIAL','MARCA DE SERVICIO','MARCA COLECTIVA','DENOMINACION DE ORIGEN'));
$smarty->assign('arrayvclase',array(I,N));
$smarty->assign('arraytclase',array('INTERNACIONAL','NACIONAL'));
$smarty->assign('arrayvmodal',array(N,D,G,M));
$smarty->assign('arraytmodal',array('','DENOMINATIVA','GRAFICA','MIXTA'));

// ************************************************************************************  
$nconexion = $_POST['nconexion'];
if (empty($nconexion)) { $nconexion = $_GET['nconexion']; }
$nveces = $_POST['nveces'];
if (empty($nveces)) { $nveces = $_GET['nveces']; }

// ************************************************************************************  
if (($vopc==1) || ($vopc==3)) {
  $nveces = $nveces + 1; 
  if ($nveces==1) { $nconexion = insconex($usuario,$modulo,'M'); } 
}

//Opcion Modificar
if ($vopc==1) {
  $smarty->assign('accion',2);
  $smarty->assign('modo1',''); 
  $smarty->assign('vmodo','disabled'); 
  $smarty->assign('modo','disabled'); 
  $smarty->assign('modo2','disabled'); 
  $smarty->assign('modo3',''); 
  $smarty->assign('varfocus','formarcas2.vclase');
  $smarty->assign('subtitulo','Mantenimiento de Expediente / Modificaci&oacute;n Clase'); 

  //Validacion del Numero de Solicitud
  if (empty($vsol1) && empty($vsol2)) {
     mensajenew("No introdujo ningn valor de Expediente ...!!!","javascript:history.back();","N");
     $smarty->display('pie_pag.tpl'); exit(); }

  if (($vresol=="-") || ($vresol=="0000-000000")) {
    mensajenew("Numero de Solicitud Vacio ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }

  if (($vsol1=="0000") || ($vsol2=="000000")) { 
    mensajenew("Numero de Solicitud Vacio o Erroneo ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }

  //Armado del Numero de Expediente
  $varsol=$vsol1."-".sprintf("%06d",$vsol2);
  
  //Verificando conexion
  $sql->connection($usuario);
  
  $resultado=pg_exec("SELECT * FROM $tbname_1 WHERE solicitud='$varsol' AND solicitud!='' AND tipo_mp='M'"); 

  if (!$resultado) { 
     Mensajenew("ERROR AL PROCESAR LA BUSQUEDA ...!!!","javascript:history.back();","N");
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }	 
  $filas_found=pg_numrows($resultado); 
  if ($filas_found==0) {
     Mensajenew("ERROR: NO EXISTEN DATOS ASOCIADOS ...!!!","javascript:history.back();","N");
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }	 
  $reg = pg_fetch_array($resultado);

  $vsol    = $reg[solicitud];
  $psoli   = $reg[solicitud];
  $vsol1   = substr($vsol,-11,4);
  $vsol2   = substr($vsol,-6,6);
  $estatus = $reg[estatus];
  $smarty->assign('psoli',$psoli); 

  $vder        = $reg[nro_derecho];  
  $fecha_solic = $reg[fecha_solic];
  $nombre      = trim($reg[nombre]);
  $tipo_marca  = $reg[tipo_derecho];

  //Almaceno en un string los valores de los campos antes de modificar alguno
  $valores_fields = array($vder,$vsol,$fecha_solic,trim($nombre),$tipo_marca);
  $campos1 = "nro_derecho|solicitud|fecha_solic|nombre|tipo_derecho";
  $mstring1 = bitacora_fields(); 
  $smarty->assign('mstring1',$mstring1);
  $smarty->assign('campos1',$campos1);

  //Obtención de la clase nacional de la Marca 
  $obj_query = $sql->query("SELECT * FROM $tbname_3 WHERE nro_derecho='$vder'");
  $filas_found=$sql->nums('',$obj_query);
  if ($filas_found!=0) { 
    $objs = $sql->objects('',$obj_query);
    $vclnac = $objs->clase_nac; }
  else { $vclnac = 0; }

  //Almaceno en un string los valores de los campos antes de modificar alguno
  $valores_fields = array($vder,$vclnac);
  $campos2 = "nro_derecho|clase_nac";
  $mstring2 = bitacora_fields(); 
  $smarty->assign('mstring2',$mstring2);
  $smarty->assign('campos2',$campos2);
  
  $fecha_ref = "15/09/2008";
  //$fecharef = Convertir_en_fecha($fecha_ref,0);
  $esmayor=compara_fechas($fecha_ref,$fecha_solic);
  if ($esmayor==1) {
    Mensajenew("Solo se puede modificar Expedientes despues del 15/09/2008 ...!!!","m_modclnac.php?vopc=4&vaccion=2&vauxnum=0","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();
  }

  $distingue='';
  //Obtención de datos de la Marca 
  $obj_query = $sql->query("SELECT * FROM $tbname_2 WHERE nro_derecho='$vder'");
  $objs = $sql->objects('',$obj_query);
  $vclase    = $objs->clase;
  $clase_id  = $objs->ind_claseni;
  $distingue = trim($objs->distingue);
  $modalidad = $objs->modalidad;
  $smarty->assign('modalidad',$modalidad);
  $smarty->assign('tipo_marca',$tipo_marca);
  $smarty->assign('tipomarca',$tipo_marca);

  //Almaceno en un string los valores de los campos antes de modificar alguno
  $valores_fields = array($vder,$vclase,$clase_id,$modalidad);
  $campos3= "nro_derecho|clase|ind_claseni|modalidad";
  $mstring3 = bitacora_fields(); 
  $smarty->assign('mstring3',$mstring3);
  $smarty->assign('campos3',$campos3);

}

//Opcion Grabar...
if ($vopc==2) {
  //La Fecha de Hoy y Hora para la transaccion
  $fechahoy = hoy();
  $horactual= Hora();

  //Verificando conexion
  $sql->connection($usuario);

  //Validacion del Numero de Solicitud
  if ($accion==2) {
    if (!empty($vsol1) && !empty($vsol2)) { 
      $varsol=$vsol1."-".sprintf("%06d",$vsol2); } 
  else {
    Mensajenew("Numero de Solicitud Vacio o con Error ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }
  }

  if ($accion==1) {
    $vclase = substr($vnumclase,0,2); }

  if (empty($vclase)) {
    Mensajenew("Clase Internacional Vacia ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }

  $vclatipo = 0;
  //echo "clase nueva=$tipo_marca $vclase $vclnac $vsol1 $vsol2";
  switch ($tipo_marca) {
     case "M":
       if ($vclase>0 and $vclase<35) {
           $vclatipo = 1; }
       break;
     case "S":
       if ($vclase>34 and $vclase<46) {
           $vclatipo = 1; }
       break;
     case "N":
       if ($vclase==46) {
           $vclatipo = 1; }
       break;
     case "L":
       if ($vclase==47) {
           $vclatipo = 1; }
       break;
     case "D":
       if ($vclase==48) {
           $vclatipo = 1; }
       break;
     case "C":
       if ($vclase>0 and $vclase<46) {
           $vclatipo = 1; }
       break;
  }       
  
  if ($vclatipo==0) {
    mensajenew("Clase Internacional de Niza no corresponde con el Tipo de Marca ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }

  if (($vclnac==0) || (empty($vclnac))) {
    Mensajenew("Error en Clase Nacional o esta vacia ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }

  $vclatipo = 0;
  switch ($tipo_marca) {
     case "M":
       if ($vclnac>0 and $vclnac<51) {
           $vclatipo = 1; }
       break;
     case "S":
       if ($vclnac==50) { 
           $vclatipo = 1; }
       break;
     case "N":
       if ($vclnac==50) { 
           $vclatipo = 1; }
       break;
     case "L":
       if ($vclnac==50) { 
           $vclatipo = 1; }
       break;
     case "D":
       if ($vclnac==50) {  
           $vclatipo = 1; }
       break;
     case "C":
       if ($vclnac>0 and $vclnac<51) {  
           $vclatipo = 1; }
       break;
  }       

  if ($vclatipo==0) {
    Mensajenew("Clase Nacional NO corresponde con el Tipo de Marca ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }


  if ($accion==1) {
  } //Incluir
  else {
    // Modificar Solicitud
    $varsol = sprintf("%02d-%06d",$vsol1,$vsol2);

    pg_exec("BEGIN WORK");

    //Se obtiene el proximo valor para el secuencial a guardar en stzbitac a partir de stzsistem
    pg_exec("BEGIN WORK");
    pg_exec("LOCK TABLE stzsystem IN SHARE ROW EXCLUSIVE MODE");
    $sys_actual = next_sys("nbitaco");
    echo " valor es secuencia= $sys_actual ";
    $vsecuencial = grabar_sys("nbitaco",$sys_actual);
    pg_exec("COMMIT WORK");
    
    // Almaceno registro original en Bitacora
    $insert_str = "'$sys_actual','$fechahoy','$horactual','$usuario','M','$vder','$varsol','M','$tbname_1','$campos1','$mstring1'";
    $sql->insert("$tbname_5","","$insert_str","");

    //Se obtiene el proximo valor para el secuencial a guardar en stzbitac a partir de stzsistem
    pg_exec("BEGIN WORK");
    pg_exec("LOCK TABLE stzsystem IN SHARE ROW EXCLUSIVE MODE");
    $sys_actual = next_sys("nbitaco");
    $vsecuencial = grabar_sys("nbitaco",$sys_actual);
    pg_exec("COMMIT WORK");
    
    // Almaceno registro original en Bitacora
    $insert_str = "'$sys_actual','$fechahoy','$horactual','$usuario','M','$vder','$varsol','M','$tbname_3','$campos2','$mstring2'";
    $sql->insert("$tbname_5","","$insert_str","");

    //Se obtiene el proximo valor para el secuencial a guardar en stzbitac a partir de stzsistem
    pg_exec("BEGIN WORK");
    pg_exec("LOCK TABLE stzsystem IN SHARE ROW EXCLUSIVE MODE");
    $sys_actual = next_sys("nbitaco");
    $vsecuencial = grabar_sys("nbitaco",$sys_actual);
    pg_exec("COMMIT WORK");

    // Almaceno registro original en Bitacora
    $insert_str = "'$sys_actual','$fechahoy','$horactual','$usuario','M','$vder','$varsol','M','$tbname_2','$campos3','$mstring3'";
    $sql->insert("$tbname_5","","$insert_str","");

    $updderec = true;
    //Actualizacion del resto de los daros de la maestra de marcas 
    pg_exec("LOCK TABLE stzderec IN SHARE ROW EXCLUSIVE MODE");
    $update_str = "tipo_derecho='$tipo_marca'";
    $updderec = $sql->update("$tbname_1","$update_str","nro_derecho='$vder'");

    $updmarce = true;
    pg_exec("LOCK TABLE stmmarce IN SHARE ROW EXCLUSIVE MODE");
    $update_str = "clase=$vclase,ind_claseni='I',modalidad='$modalidad'";
    $updmarce = $sql->update("$tbname_2","$update_str","nro_derecho='$vder'");

    $insfon = true;
    // Tabla de Batfon 
    $insert_str = "'$varsol'";
    $insfon = $sql->insert("$tbname_4","","$insert_str","");

    $insclanac=true;
    $updclanac=true;
    $obj_query = $sql->query("SELECT * FROM $tbname_3 WHERE nro_derecho='$vder'");
    $objs = $sql->objects('',$obj_query);
    $filas_found=$sql->nums('',$obj_query);
    if ($filas_found==0) {
      //Insercion de la Clase Nacional   
      $insert_str = "'$vder','$vclnac'";
      $insclanac  = $sql->insert("$tbname_3","","$insert_str",""); }
    else {
      //Actualizacion de la Clase Nacional   
      $update_str = "clase_nac=$vclnac";
      $updclanac = $sql->update("$tbname_3","$update_str","nro_derecho='$vder'");
    }  

    if ($updderec AND $updmarce AND $insclanac AND $updclanac AND $insfon) {
      pg_exec("COMMIT WORK");
      //Desconexion de la Base de Datos
      $sql->disconnect();

      Mensajenew("DATOS GUARDADOS CORRECTAMENTE ...!!!","m_modclnac.php?vopc=4&nconexion=".$nconexion."&nveces=".$nveces,"S");
      $smarty->display('pie_pag.tpl'); exit();
    } 
    else {
      pg_exec("ROLLBACK WORK");
      //Desconexion de la Base de Datos
      $sql->disconnect();

      if (!$updderec)   { $error_der = " - Derecho "; }
      if (!$updmarce)   { $error_mar = " - Marcas "; }
      if (!$insfon)     { $error_fon = " - Fonetica "; }
      if (!$$updclanac) { $error_cln = " - Clase Nacional "; }
      if (!$$insclanac) { $error_cln = " - Clase Nacional "; }
            
      Mensajenew("Falla de Actualizaci&oacute;n / Inserci&oacute;n de Datos en la BD $error_mar, $error_der, $error_fon, $error_cln ...!!!","javascript:history.back();","N");
      $smarty->display('pie_pag.tpl'); exit();
    }
  } // Modificar
}

if ($vopc==4) {
  $smarty->assign('subtitulo','Mantenimiento de Expediente CAN-486/ Modificaci&oacute;n'); 
  $smarty->assign('varfocus','formarcas1.vsol1'); 
  $smarty->assign('vmodo',''); 
  $smarty->assign('modo1','readonly=readonly'); 
  $smarty->assign('modo2','disabled'); 
  $smarty->assign('modo3','disabled'); 
  $smarty->assign('modo','readonly=readonly'); 
  $smarty->assign('accion',2);
}

//Pase de variables y Etiquetas al template
$smarty->assign('campo1','Expediente No.:');
$smarty->assign('campo2','Fecha Expediente:');
$smarty->assign('campo3','Tipo de Marca:');
$smarty->assign('campo4','Nombre:');
$smarty->assign('campo5','Clase Internacional:');
$smarty->assign('campo6','Clase Nacional:');
$smarty->assign('campo7','Modalidad:');
$smarty->assign('campo8','Distingue:');

$smarty->assign('vder',$vder);
$smarty->assign('usuario',$usuario);
$smarty->assign('vsol1',$vsol1);
$smarty->assign('vsol2',$vsol2);
$smarty->assign('varsol',$varsol);
$smarty->assign('dirano',$dirano);
$smarty->assign('nombre',$nombre);
$smarty->assign('clase_id',$clase_id);
$smarty->assign('vclase',$vclase);
$smarty->assign('vclnac',$vclnac);
$smarty->assign('fecha_solic',$fecha_solic);
$smarty->assign('tipo_marca',$tipo_marca);
$smarty->assign('modalidad',$modalidad);
$smarty->assign('distingue',$distingue);
$smarty->assign('vcodclase',$vcodclase);
$smarty->assign('vnomclase',$vnomclase);
$smarty->assign('options',$vclase);
$smarty->assign('vopc',$vopc);
$smarty->assign('nconexion',$nconexion); 
$smarty->assign('nveces',$nveces);  

$smarty->display('m_modclnac.tpl');
$smarty->display('pie_pag.tpl');
?>
