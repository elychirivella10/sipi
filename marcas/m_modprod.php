<script language="Javascript"> 
 function pregunta() { 
   return confirm('Estas seguro de grabar la Informacion ?'); }
</script>

<?php
// *************************************************************************************
// Programa: m_modprod.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MILCO
// Desarrollado Año 2006 
// Modificado Año 2009 BD - Relacional 
// *************************************************************************************

//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variables
$usuario = trim($_SESSION['usuario_login']);
//$role    = $_SESSION['usuario_rol'];
$sql     = new mod_db();
$fecha   = fechahoy();
$modulo  = "m_modprod.php";

$tbname_3  = "stzderec";
$tbname_4  = "stmmarce";
$tbname_6  = "stmdistd";

$vopc     = $_GET['vopc'];
$vaccion  = $_GET['vaccion'];

$vsol1 = $_POST['vsol1'];
$vsol2 = $_POST['vsol2'];
$vreg1 = $_POST['vreg1'];
$vreg2 = $_POST['vreg2'];
$vsol  = $_POST['vsol'];
$vreg  = $_POST['vreg'];

$fecha_solic=$_POST['fecha_solic'];
$tipo_marca=$_POST['tipo_marca'];
$nombre=$_POST['nombre'];
$vclase=$_POST['vclase'];
$distingue=$_POST['distingue'];
$accion=$_POST['accion'];
$vder=$_POST['vder'];

$nconexion = $_POST['nconexion'];
if (empty($nconexion)) { $nconexion = $_GET['nconexion']; }
$nveces = $_POST['nveces'];
if (empty($nveces)) { $nveces = $_GET['nveces']; }

// ************************************************************************************  
$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Modificaci&oacute;n de Distingue'); 
if ($vopc==4) {
  $smarty->assign('subtitulo','Modificaci&oacute;n de Distingue'); }
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

$smarty->assign('arraytipom',array(V,M,N,L,S,C,D));
$smarty->assign('arraynotip',array('','MARCA DE PRODUCTO','NOMBRE COMERCIAL','LEMA COMERCIAL','MARCA DE SERVICIO','MARCA COLECTIVA','DENOMINACION DE ORIGEN'));

// ************************************************************************************  
//Opcion Modificar
if ($vopc==1) {
  $smarty->assign('vmodo','disabled'); 
  $smarty->assign('modo','');
  $smarty->assign('modo1','disabled'); 
  $smarty->assign('modo2',''); 
  $smarty->assign('subtitulo','Modificaci&oacute;n de Distingue'); 
  $smarty->assign('accion',2);

  //Armado del Numero de Expediente
  $varreg=$vreg1.$vreg2;
  $varsol=$vsol1."-".sprintf("%06d",$vsol2);
  $numero=substr($varsol,-6,6);
  
  //Verificando conexion
  $sql->connection($usuario);
  
  if (!empty($varreg)) {
     $resultado=pg_exec("SELECT * FROM $tbname_3 WHERE registro='$varreg' AND tipo_mp = 'M'"); }
  else {
     $resultado=pg_exec("SELECT * FROM $tbname_3 WHERE solicitud='$varsol' AND tipo_mp = 'M'"); }

  if (!$resultado) { 
     mensajenew("ERROR AL PROCESAR LA BUSQUEDA ...!!!","javascript:history.back();","N");
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }	 
  $filas_found=pg_numrows($resultado); 
  if ($filas_found==0) {
     mensajenew("NO EXISTEN DATOS ASOCIADOS ...!!!","javascript:history.back();","N");
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }	 
  $reg = pg_fetch_array($resultado);

  $vder=$reg[nro_derecho];
  $vsol=$reg[solicitud];
  $varsol=$vsol; 
  $psoli=$reg[solicitud];
  $vsol1=substr($vsol,-11,4);
  $vsol2=substr($vsol,-6,6);
  $registro=$reg[registro];
  $vreg1=substr($registro,-8,1);
  $vreg2=substr($registro,-7,6);
  $estatus=$reg[estatus];
  $nombre=trim($reg[nombre]);
  $fecha_solic=$reg[fecha_solic];
  $tipo_marca=$reg[tipo_derecho];
  
  if ($usuario=='rmendoza') { }
  else {
    if (($estatus==1001) || ($estatus==1002) || ($estatus==1004) || ($estatus==1006) || ($estatus==1108) || ($estatus==1104) || ($estatus==1008) || ($estatus==1300)) { }  
    else {
      if (($estatus==1400)) { 
        if (($usuario=='rmendoza')) { }
        else {
          Mensajenew("ERROR: Usuario NO tiene Permiso para modificar bajo este Estatus ...!!!","m_modprod.php?vopc=4","N");
          $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();
        }
      }
      else { 
        Mensajenew("ERROR: Solicitud en estatus NO Modificable ...!!!","m_modprod.php?vopc=4","N");
        $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();
      }
    }  
  }
  // Obtencion de los datos restante de la Marca
  $distingue='';
  $obj_query = $sql->query("SELECT * FROM $tbname_4 WHERE nro_derecho ='$vder'");
  $obj_filas = $sql->nums('',$obj_query);
  if ($obj_filas!=0) {
    $objs = $sql->objects('',$obj_query);
    $vclase= $objs->clase;
    $distingue = trim($objs->distingue); }
  $smarty->assign('tipo_marca',$tipo_marca);
}

// ************************************************************************************  
//Opcion Grabar...
if (($vopc==2) || ($vopc==6)) {
  //La Fecha de Hoy y Hora para la transaccion
  $fechahoy = hoy();
  $horactual= Hora();
  $vder  = $_POST['vder'];
  
  //Verificando conexion
  $sql->connection($usuario);

  //Validacion del Numero de Solicitud
  if ($accion==2) {
    if (!empty($vsol1) && !empty($vsol2)) { 
      $varsol=$vsol1."-".sprintf("%06d",$vsol2); } 
  else {
    mensajenew("Numero de Solicitud Vacio o con Error ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }
  }      
  //Verificacion de que los campos requeridos esten llenos...
  if (empty($distingue)) { 
     mensajenew("Hay Informacion en el formulario que esta Vacia ...!!!","javascript:history.back();","N");
     $smarty->display('pie_pag.tpl'); exit(); }

  if ($accion==2) {
    // Modificar Solicitud
    $varsol = sprintf("%02d-%06d",$vsol1,$vsol2);
    $varreg = $vreg1.$vreg2;
 
    //Direccion IP de la Maquina
    $dirIP = getRealIP(); 

    $insaud = true;
    // Tabla Auditoria de Modificacion 
    $columnas_str = "fecha,hora,ip_acceso,usuario,solicitud,registro,tipo_mp,modulo";
    $insert_str = "'$fechahoy','$horactual','$dirIP','$usuario','$varsol','$varreg','M','m_modprod.php'"; 
    $insaud = $sql->insert("stzaudmod","$columnas_str","$insert_str","");
   
    pg_exec("BEGIN WORK");
    $actdis = true;
    $insdis = true;
    pg_exec("LOCK TABLE stmmarce IN SHARE ROW EXCLUSIVE MODE");
    $vdis = str_replace("'","´",$distingue);
    $obj_query = $sql->query("SELECT * FROM $tbname_4 WHERE nro_derecho ='$vder'");
    $obj_filas = $sql->nums('',$obj_query);
    if ($obj_filas!=0) { 
      $update_str = "distingue= '$vdis'";
      $actdis =  $sql->update("$tbname_4","$update_str","nro_derecho='$vder'");
    } else {
    	
    }

    if (($actdis) && ($insdis)) {
      pg_exec("COMMIT WORK");
      //Desconexion de la Base de Datos
      $sql->disconnect();
   
      Mensajenew("DATOS GUARDADOS CORRECTAMENTE !!!","m_modprod.php?vopc=4&nconexion=".$nconexion,"S");
      $smarty->display('pie_pag.tpl'); exit();
    }
    else {
      pg_exec("ROLLBACK WORK");
      //Desconexion de la Base de Datos
      $sql->disconnect();

      if ((!$actdis) || (!$insdis)) { $error_dis  = " - Marcas - Distingue "; } 
        mensajenew("Falla de Actualizaci&oacute;n / Inserci&oacute;n de Datos en la BD $error_dis ...!!!","javascript:history.back();","N");
        $smarty->display('pie_pag.tpl'); exit();
    }

  } // Modificar
}

// ************************************************************************************  
if (($vopc!=1) && ($vopc!=2) && ($vopc!=3) && ($vopc!=4)) {
  $smarty->assign('modo1',''); 
  $smarty->assign('modo2','disabled'); 
  $smarty->assign('modo','readonly=readonly'); 
  $smarty->assign('vmodo','readonly=readonly'); 
}

// ************************************************************************************  
if ($vopc==4) {
  $smarty->assign('varfocus','formarcas1.vreg1'); 
  $smarty->assign('modo1','disabled'); 
  $smarty->assign('modo2','disabled'); 
  $smarty->assign('vmodo',''); 
  $smarty->assign('modo','readonly=readonly'); 
  $smarty->assign('accion',2);
}

// ************************************************************************************  
if ($vopc==1) {
  $smarty->assign('varfocus','formarcas2.fecha_solic');
  $smarty->assign('tipo_marca','V');
  $smarty->assign('tipo_marca',$tipo_marca);

  $nveces = $nveces + 1; 
  if ($nveces==1) { $nconexion = insconex($usuario,$modulo,'M'); } 
}

// ************************************************************************************  
if ($vopc==2) {
  $smarty->assign('varfocus','formarcas1.vreg1'); 
  $smarty->assign('modo',''); 
  $smarty->assign('psoli',$vsol); 
  $smarty->assign('tipo_marca',$tipo_marca); }

// ************************************************************************************  
//Pase de variables y Etiquetas al template
$smarty->assign('campo1','Registro No.:');
$smarty->assign('campo2','Fecha Expediente:');
$smarty->assign('campo3','Tipo de Marca:');
$smarty->assign('campo4','Nombre:');
$smarty->assign('campo5','Clase Internacional:');
$smarty->assign('campo8','Distingue:');

$smarty->assign('usuario',$usuario);
$smarty->assign('vsol1',$vsol1);
$smarty->assign('vsol2',$vsol2);
$smarty->assign('varsol',$varsol);
$smarty->assign('nombre',$nombre);
$smarty->assign('vclase',$vclase);
$smarty->assign('fecha_solic',$fecha_solic);
$smarty->assign('distingue',$distingue);
$smarty->assign('vopc',$vopc);
$smarty->assign('registro1',$vreg1);
$smarty->assign('registro2',$vreg2);
$smarty->assign('vreg1',$vreg1);
$smarty->assign('vreg2',$vreg2);
$smarty->assign('nconexion',$nconexion); 
$smarty->assign('nveces',$nveces);  
$smarty->assign('vder',$vder);

$smarty->display('m_modprod.tpl');
$smarty->display('pie_pag.tpl');
?>
