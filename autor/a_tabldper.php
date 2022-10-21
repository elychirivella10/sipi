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
$fechanac= $_POST['fechanac'];
$fechadef= $_POST['fechadef'];
$estado= $_POST['estado'];
$domicilio= $_POST['domicilio'];
$pais= $_POST['pais'];
$telefono1= $_POST['telefono1'];
$telefono2= $_POST['telefono2'];
$fax= $_POST['fax'];
$email= $_POST['email'];
$profesion= $_POST['profesion'];
$seudonimo= $_POST['seudonimo'];
$indole= $_POST['indole'];
$titular= $_POST['titular'];

$smarty->assign('titulo','Sistema de Derecho de Autor');
$smarty->assign('subtitulo','Mantenimiento de Personas Naturales / Modificacion'); 
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

  $resultado=pg_exec("SELECT * FROM stzsolic WHERE titular=$titular");
  $filas_found=pg_numrows($resultado); 
  if ($filas_found==0) {
    mensajenew("NO EXISTEN DATOS ASOCIADOS ...!!!",'a_tabldper.php?vopc=4',"N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  }else{
  $resdajur=pg_exec("SELECT * FROM stzdajur WHERE titular=$titular");
  $filas_found=pg_numrows($resdajur); 
  if ($filas_found>0) {
    mensajenew("Este Titular es Persona Jurídica. Verifique...!!!",'a_tabldper.php?vopc=4',"N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  } 
  $resdaper=pg_exec("SELECT * FROM stzdaper WHERE titular=$titular");
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

  $reg2= pg_fetch_array($resdaper);
  $fechanac=$reg2[fecha_nacim];
  $fechadef=$reg2[fecha_defun]; 
  $estado=$reg2[estado_civil];
  $profesion=ltrim(rtrim($reg2[profesion]));
  $seudonimo=ltrim(rtrim($reg2[seudonimo]));


  //Paso a Smarty los Valores
  $smarty->assign('lced',$lced);
  $smarty->assign('nced',$nced);
  $smarty->assign('nombre',$nombre);
  $smarty->assign('fechanac',$fechanac);
  $smarty->assign('fechadef',$fechadef); 
  $smarty->assign('estado',$estado);
  $smarty->assign('telefono1',$telefono1);
  $smarty->assign('telefono2',$telefono2);
  $smarty->assign('fax',$fax);
  $smarty->assign('email',$email);
  $smarty->assign('profesion',$profesion);
  $smarty->assign('seudonimo',$seudonimo);
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
  if (empty($nombre) || empty($estado)) {
    mensajenew("Hay Informacion basica en el formulario que esta Vacia ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }

   pg_exec("BEGIN WORK");
  //al Modificar
  if ($accion==2) {
    //La Fecha de Hoy y Hora para la transaccion
    $fechahoy = Hoy();
    $horactual= Hora();

    // Actualizo en Maestra de Personas Naturales
    $update_cond="titular='$titular'";
    $update_str = "estado_civil='$estado',profesion='$profesion',seudonimo='$seudonimo'";
    if (!empty($fechanac)) {$update_str = $update_str.",fecha_nacim='$fechanac'";}
    if (!empty($fechadef)) {$update_str = $update_str.",fecha_defun='$fechadef'";}
    $resultit=pg_exec("SELECT * FROM stzdaper WHERE titular='$titular'");
    if (pg_numrows($resultit)>0) {
       $sql->update("stzdaper","$update_str","$update_cond");
    }else{
       $insert_campos="titular,estado_civil,profesion,seudonimo";
       $insert_valores="'$titular','$estado','$profesion','$seudonimo'";
       if (!empty($fechanac)) {$insert_campos = $insert_campos.",fecha_nacim";
                               $insert_valores= $insert_valores.",'$fechanac'";}
       if (!empty($fechadef)) {$insert_campos = $insert_campos.",fecha_defun";
                               $insert_valores= $insert_valores.",'$fechadef'";}
       $sql->insert("stzdaper","$insert_campos","$insert_valores",""); 
    }

    // Actualizo en stzsolic
    $update_str = "identificacion='$identificacion',nombre='$nombre',email='$email',fax='$fax',
                   indole='$indole',telefono1='$telefono1',telefono2='$telefono2'";
    $sql->update("stzsolic","$update_str","$update_cond");
  }

  pg_exec("COMMIT WORK");
  //Desconexion de la Base de Datos
  $sql->disconnect();
  mensajenew('DATOS GUARDADOS CORRECTAMENTE !!!','a_tabldper.php?vopc=4','S');
  $smarty->display('pie_pag.tpl'); exit(); 
}

$smarty->assign('campo01','C&oacute;digo del Titular:');
$smarty->assign('campo1','C&eacute;dula:');
$smarty->assign('campo2','Nombre:');
$smarty->assign('campo3','Fecha de Nacimiento:');
$smarty->assign('campo4','Fecha de Defunci&oacute;n:');
$smarty->assign('campo5','Estado Civil:');
$smarty->assign('campo81','Tel&eacute;fono1:');
$smarty->assign('campo82','Tel&eacute;fono2:');
$smarty->assign('campo9','Fax:');
$smarty->assign('campo10','Profesi&oacute;n:');
$smarty->assign('campo11','Seudonimo:');
$smarty->assign('campo12','Email:');
$smarty->assign('campo13','Indole:');
$smarty->assign('titular',$titular);
$smarty->assign('vopc',$vopc);
$smarty->assign('evento',$evento);
$smarty->assign('vestado_id',array('S','C','D','V')); 
$smarty->assign('vestado_de',array('Soltero(a)','Casado(a)','Divorciado(a)','Viudo(a)'));
$smarty->assign('vindole_id',array(' ','G','C','O','P','N')); 
$smarty->assign('vindole_de',array(' ','Sector Publico','Cooperativa','Comunal','Empresa Privada','Persona Natural'));
$smarty->display('a_tabldper.tpl');
$smarty->display('pie_pag.tpl');
?>
