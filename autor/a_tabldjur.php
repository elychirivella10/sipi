<?php
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
  echo "Acceso Denegado..."; exit(); }

//Variables
$usuario  = $_SESSION['usuario_login'];
$role     = $_SESSION['usuario_rol'];
$sql      = new mod_db();
$fecha   = fechahoy();

$vopc   = $_GET['vopc'];
$accion = $_POST['accion'];
$identificacion = $_POST['lced'].$_POST['nced'];
$nombre = $_POST['nombre'];
$datosreg = $_POST['datosreg'];
$telefono1= $_POST['telefono1'];
$telefono2= $_POST['telefono2'];
$fax= $_POST['fax'];
$email= $_POST['email'];
$indole= $_POST['indole'];
$titular= $_POST['titular'];

$smarty->assign('titulo','Sistema de Derecho de Autor');
$smarty->assign('subtitulo','Mantenimiento de Personas Juridicas / Modificacion'); 
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

if ($vopc==1 && $accion=='Modificacion') {
  $smarty->assign('vmodo','readonly=readonly'); 
  $smarty->assign('modo',''); 
  $smarty->assign('modo2',''); 
  $smarty->assign('accion',2);
  $smarty->assign('varfocus','frmstatus2.titular');

  //Verificando conexion
  $sql->connection();

  $resultado=pg_exec("SELECT * FROM stzsolic WHERE titular='$titular'");
  $filas_found=pg_numrows($resultado); 
  if ($filas_found==0) {
    mensajenew("NO EXISTEN DATOS ASOCIADOS ...!!!",'a_tabldjur.php?vopc=4',"N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();
  }else{
  $resdaper=pg_exec("SELECT * FROM stzdaper WHERE titular=$titular");
  $filas_found=pg_numrows($resdaper); 
  if ($filas_found>0) {
    mensajenew("Este Titular es Persona Natural. Verifique...!!!",'a_tabldjur.php?vopc=4',"N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  }
  $resdajur=pg_exec("SELECT * FROM stzdajur WHERE titular=$titular"); 	 
  }	 
  $reg = pg_fetch_array($resultado);
  $lced=substr($reg[identificacion],0,1);
  $nced=substr($reg[identificacion],1,9);
  $titular=$reg[titular];
  $nombre=ltrim(rtrim($reg[nombre]));
  $telefono1=ltrim(rtrim($reg[telefono1]));
  $telefono2=ltrim(rtrim($reg[telefono2]));
  $fax=ltrim(rtrim($reg[fax]));
  $email=ltrim(rtrim($reg[email]));
  $indole=$reg[indole];

  $reg2= pg_fetch_array($resdajur);
  $datosreg=ltrim(rtrim($reg2[datos_registro]));

  //Paso a Smarty los Valores
  $smarty->assign('lced',$lced);
  $smarty->assign('nced',$nced);
  $smarty->assign('nombre',$nombre);
  $smarty->assign('datosreg',$datosreg);
  $smarty->assign('telefono1',$telefono1);
  $smarty->assign('telefono2',$telefono2);
  $smarty->assign('fax',$fax);
  $smarty->assign('email',$email);
  $smarty->assign('indole',$indole);
  $smarty->assign('titular',$titular);
}

if ($vopc==4) {
  $smarty->assign('varfocus','frmstatus1.titular'); 
  $smarty->assign('modo1','disabled'); 
  $smarty->assign('modo2','disabled'); 
  $smarty->assign('vmodo',''); 
  $smarty->assign('modo','readonly=readonly'); 
  $smarty->assign('accion',2);
}

//Opcion Grabar...
if ($vopc==2) {
  //Verificando conexion
  $sql->connection();

  //Verificacion de que los campos requeridos esten llenos...
  if (empty($nombre)) {
    mensajenew("Hay Informacion basica en el formulario que esta Vacia ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }

   pg_exec("BEGIN WORK");
  //al Modificar
  if ($accion==2) {
    //La Fecha de Hoy y Hora para la transaccion
    $fechahoy = Hoy();
    $horactual= Hora();

    // Actualizo en Maestra de Personas Juridicas
    $update_cond="titular='$titular'";
    $update_str = "datos_registro='$datosreg'";
    $resultit=pg_exec("SELECT * FROM stzdajur WHERE titular='$titular'");
    if (pg_numrows($resultit)>0) {
       $sql->update("stzdajur","$update_str","$update_cond");
    }else{
       $insert_campos="titular,datos_registro,cedula_repre";
       $insert_valores="'$titular','$datosreg','V'";
       $sql->insert("stzdajur","$insert_campos","$insert_valores",""); 
    }

    // Actualizo en stzsolic
    $update_str = "identificacion='$identificacion',nombre='$nombre',email='$email',fax='$fax',indole='$indole',
                   telefono1='$telefono1',telefono2='$telefono2'";
    $sql->update("stzsolic","$update_str","$update_cond");
  }

  pg_exec("COMMIT WORK");
  //Desconexion de la Base de Datos
  $sql->disconnect();
  mensajenew('DATOS GUARDADOS CORRECTAMENTE !!!','a_tabldjur.php?vopc=4','S');
  $smarty->display('pie_pag.tpl'); exit(); 
}

$smarty->assign('campo01','C&oacute;digo del Titular:');
$smarty->assign('campo1','Rif:');

$smarty->assign('campo2','Nombre:');
$smarty->assign('campo3','Datos del Registro:');
$smarty->assign('campo81','Tel&eacute;fono1:');
$smarty->assign('campo82','Tel&eacute;fono2:');
$smarty->assign('campo9','Fax:');
$smarty->assign('campo12','Email:');
$smarty->assign('campo13','Indole:');
$smarty->assign('titular',$titular);
$smarty->assign('vopc',$vopc);
$smarty->assign('evento',$evento);
$smarty->assign('vindole_id',array(' ','G','C','O','P','N')); 
$smarty->assign('vindole_de',array(' ','Sector Publico','Cooperativa','Comunal','Empresa Privada','Persona Natural'));
$smarty->display('a_tabldjur.tpl');
$smarty->display('pie_pag.tpl');
?>
