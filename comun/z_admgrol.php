<script language="Javascript"> 

function pregunta() { 
  return confirm('Estas seguro de grabar la Informacion ?'); }

</script> 

<?php
// *************************************************************************************
// Programa: z_admgrol.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MILCO
// Año: 2008 
// *************************************************************************************

//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variables
$usuario  = $_SESSION['usuario_login'];
//$role     = $_SESSION['usuario_rol'];
$sql      = new mod_db();
$fecha    = fechahoy();
$modulo   = "z_admgrol.php";

$tbname1  = "stzroles";
$tbname2  = "stzusuar";
$tbname3  = "stzroleve";
$tbname4  = "stzevder";
$tbname5  = "stpevpar";
$tbname6  = "stdevobr";
$tbname7  = "stzuserol";

$vrol   = $_GET['vrol'];
$vmodo  = $_GET['vmod'];
$vtip   = $_GET['vtip'];
$vmodal = $_GET['vmodal'];
$conx   = $_GET['conx']; 
$nconex = $_GET['nconex'];
$vopm   = $_GET['vopm']; 
$vopc   = $_GET['vopc'];
$salir  = $_GET['salir']; 

$n_conex = $_POST['n_conex'];
$navega  = $_POST['navega'];

$modal   = $_POST['modal'];

$totalevm = $_POST["totalevm"];
$totalevp = $_POST["totalevp"];
$totaleva = $_POST["totaleva"];
$idm_even = $_POST["idm_even"];
$idp_even = $_POST["idp_even"];
$ida_even = $_POST["ida_even"];
$asg_usrs = $_POST["asg_usrs"]; 

// ************************************************************************************  
$smarty->assign('titulo','M&oacute;dulo de Acceso');
$smarty->assign('subtitulo','Consulta de Roles');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

// ************************************************************************************  
// Control de acceso: Entrada y Salida al Modulo 
if ($conx==0) { 
  $smarty->assign('n_conex',$nconex);      }
else {
  $opra='I';
  $res_conex = insconex($usuario,$modulo,$opra);
  $smarty->assign('n_conex',$res_conex);   }

if (($salir==0) && ($nconex>0)) {
  $logout = salirconx($nconex);
}

// ************************************************************************************  

//Verificando conexion
$sql->connection();

//Obtención de los Usuarios 
$obj_query = $sql->query("SELECT usuario,nombre FROM $tbname2 order by nombre");
if (!$obj_query) { 
    mensajenew("Problema al intentar realizar la consulta en la tabla $tbname_2 ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
$filas_found=$sql->nums('',$obj_query);
$totalusr=$filas_found;
if ($filas_found==0) {
    mensajenew("Tabla de Usuarios Vacia ...!!!","index.php","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 
$cont = 0;
$objs = $sql->objects('',$obj_query);
for($cont=1;$cont<=$filas_found;$cont++) { 
    $arraylogin[$cont]=$objs->usuario;
    $arrayusuario[$cont]=str_pad(trim($objs->usuario),10,"*",STR_PAD_RIGHT)." - ".trim($objs->nombre); 
    $objs = $sql->objects('',$obj_query); }

//Obtención de los Eventos de Marcas
$obj_query = $sql->query("SELECT evento,descripcion FROM $tbname4 WHERE tipo_mp='M' ORDER BY evento");
if (!$obj_query) { 
    mensajenew("Problema al intentar realizar la consulta en la tabla $tbname4 ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
$filas_found=$sql->nums('',$obj_query);
$totevm=$filas_found;
if ($filas_found==0) {
    mensajenew("Tabla de Eventos de Marcas Vacia ...!!!","index.php","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 
$cont = 0;
$objs = $sql->objects('',$obj_query);
for($cont=1;$cont<=$filas_found;$cont++) { 
    $mevento[$cont]=$objs->evento;
    $mdescev[$cont]=str_pad($objs->evento,3,"0",STR_PAD_LEFT)."&nbsp;&nbsp;&nbsp;".trim($objs->descripcion);
    $objs = $sql->objects('',$obj_query); }

//Obtención de los Eventos de Patentes
$obj_query = $sql->query("SELECT evento,descripcion FROM $tbname4 WHERE tipo_mp='P' ORDER BY evento");
if (!$obj_query) { 
    mensajenew("Problema al intentar realizar la consulta en la tabla $tbname4 ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
$filas_found=$sql->nums('',$obj_query);
$totevp=$filas_found;
if ($filas_found==0) {
    mensajenew("Tabla de Eventos de Patentes Vacia ...!!!","index.php","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 
$cont = 0;
$objs = $sql->objects('',$obj_query);
for($cont=1;$cont<=$filas_found;$cont++) { 
    $pevento[$cont]=$objs->evento;
    $pdescev[$cont]=str_pad($objs->evento,3,"0",STR_PAD_LEFT)."&nbsp;&nbsp;&nbsp;".trim($objs->descripcion);
    $objs = $sql->objects('',$obj_query); }

//Obtención de los Eventos de Derecho de Autor 
$obj_query = $sql->query("SELECT evento,descripcion FROM $tbname6 ORDER BY evento");
if (!$obj_query) { 
    mensajenew("Problema al intentar realizar la consulta en la tabla $tbname6 ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
$filas_found=$sql->nums('',$obj_query);
$toteva=$filas_found;
if ($filas_found==0) {
    mensajenew("Tabla de Eventos de Derecho de Autor Vacia ...!!!","../comun/z_ingevrol.php?conx=0&na_conex=$na_conex&nconex=$nconex&salir=1","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 
$cont = 0;
$objs = $sql->objects('',$obj_query);
for($cont=1;$cont<=$filas_found;$cont++) { 
    $aevento[$cont]=$objs->evento;
    $adescev[$cont]=str_pad($objs->evento,3,"0",STR_PAD_LEFT)."&nbsp;&nbsp;&nbsp;".trim($objs->descripcion);
    $objs = $sql->objects('',$obj_query); }


//Mostrar Datos del Rol 
$where = " role=".$vrol;

$filasfound = 0;
$obj_query = $sql->query("SELECT * FROM $tbname1 WHERE role='$vrol'");
if ($obj_query) { 
  $filasfound = $sql->nums('',$obj_query); 
  if ($filasfound==1) {
    $objs        = $sql->objects('',$obj_query);
    $vrole       = trim($objs->nombre); 
    $vdescripcion = trim($objs->descripcion); 
    $vcreacion   = $objs->fecha_crea." - ".$objs->hora_crea;
  }

  //Obtención de los Usuarios asignados el Rol
  $totalusr=0;
  $obj_query = $sql->query("SELECT usuario,nombre FROM $tbname2 where role='$vrol' and estatus='1' order by nombre");
  if (!$obj_query) { 
      Mensajenew("Problema al intentar realizar la consulta en la tabla $tbname2 ...!!!","../comun/z_admgrol.php?conx=0&na_conex=$na_conex&nconex=$nconex&salir=0","N");
      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
  $filas_found=$sql->nums('',$obj_query);
  $userasig=$filas_found;
  if ($filas_found>0) {
    $cont = 0;
    $objs = $sql->objects('',$obj_query);
    for($cont=1;$cont<=$filas_found;$cont++) { 
      $arrayusers[$cont]=$objs->usuario;
      $arraynames[$cont]=str_pad(trim($objs->usuario),10,"*",STR_PAD_RIGHT)." - ".trim($objs->nombre); 
      $objs = $sql->objects('',$obj_query); }
  }

  //Obtención de los Eventos de Marcas asignados el Rol
  $totalevm=0;
  $obj_query = $sql->query("SELECT stzevder.evento,descripcion FROM $tbname3,$tbname4 WHERE role='$vrol' AND tipo_mp='M' AND stzevder.evento=stzroleve.evento AND estado='A' AND stzroleve.tip_derecho='M' ORDER BY stzroleve.evento");
  if (!$obj_query) { 
      Mensajenew("Problema al intentar realizar la consulta en las tablas $tbname3 y $tbname4 ...!!!","../comun/z_admgrol.php?conx=0&na_conex=$na_conex&nconex=$nconex&salir=0","N");
      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
  $filas_found=$sql->nums('',$obj_query);
  $totalevm=$filas_found;
  if ($filas_found>0) {
    $cont = 0;
    $objs = $sql->objects('',$obj_query);
    for($cont=1;$cont<=$filas_found;$cont++) { 
      $marrayevento[$cont]=$objs->evento;
      $marraydescev[$cont]=str_pad($objs->evento,3,"0",STR_PAD_LEFT)."&nbsp;&nbsp;&nbsp;".trim($objs->descripcion);
      $objs = $sql->objects('',$obj_query);  }
  }

  //Obtención de los Eventos de Patentes asignados el Rol
  $totalevp=0;
  $obj_query = $sql->query("SELECT stzevder.evento,descripcion FROM $tbname3,$tbname4 WHERE role='$vrol' AND tipo_mp='P' AND stzevder.evento=stzroleve.evento AND estado='A' AND stzroleve.tip_derecho='P' ORDER BY stzroleve.evento");
  if ($obj_query) { 
    $filas_found=$sql->nums('',$obj_query);
    $totalevp=$filas_found;
    if ($filas_found>0) {
      $cont = 0;
      $objs = $sql->objects('',$obj_query);
      for($cont=1;$cont<=$filas_found;$cont++) { 
        $parrayevento[$cont]=$objs->evento;
        $parraydescev[$cont]=str_pad($objs->evento,3,"0",STR_PAD_LEFT)."&nbsp;&nbsp;&nbsp;".trim($objs->descripcion);
        $objs = $sql->objects('',$obj_query);  }
    }
  }

  //Obtención de los Eventos de Derecho de Autor asignados el Rol
  $totaleva=0;
  $obj_query = $sql->query("SELECT stdevobr.evento,descripcion FROM $tbname3,$tbname6 where role='$vrol' and stdevobr.evento=stzroleve.evento and estado='A' and stzroleve.tip_derecho='A' order by stzroleve.evento");
  if ($obj_query) { 
    $filas_found=$sql->nums('',$obj_query);
    $totaleva=$filas_found;
    if ($filas_found>0) {
      $cont = 0;
      $objs = $sql->objects('',$obj_query);
      for($cont=1;$cont<=$filas_found;$cont++) { 
        $aarrayevento[$cont]=$objs->evento;
        $aarraydescev[$cont]=str_pad($objs->evento,3,"0",STR_PAD_LEFT)."&nbsp;&nbsp;&nbsp;".trim($objs->descripcion);
        $objs = $sql->objects('',$obj_query);  }
    }
  }

}

if ($vopc==1) {
  $smarty->assign('vmodo','readonly=readonly'); 
  $smarty->assign('modo',''); 
  $nconex = $_POST['nconex'];
  
}

// ************************************************************************************  
//Opcion Grabar...
if ($vopc==2) {
  $vrol    = $_POST['vrole'];
  $n_conex = $_POST['nconex'];
  $opcion  = $_POST['opcion'];

  //La Fecha de Hoy y Hora para la transaccion
  $fechahoy = hoy();
  $horactual= Hora();

  //Verificando conexion
  $sql->connection();
    
  switch ($opcion) {
    case "Eliminar Usuario":
      //Cuento cuantos usuarios fueron seleccionados 
      $uselecion = count($asg_usrs);

      //Se verifican si el arreglo trae valores
      $selu=0;
      for ($cont=0;$cont<$uselecion;$cont++)
      { 
         $val_usrs= $asg_usrs[$cont];
         if (!empty($val_usrs)) { $selu=1; }
      }

      //Se verifica que hayan elementos seleccionados
      if ($selu==0) {
        Mensajenew("Hay Informacion en el formulario Vacia ...!!!","javascript:history.back();","N");
        $smarty->display('pie_pag.tpl'); exit(); }

      // Comienzo de Transaccion 
      pg_exec("BEGIN WORK");

      $hora = hora();
      // Eliminacion de Usuarios asociados al Rol 
      $elm_usr = 0;
      if ($selu!=0) {
        for ($cont=0;$cont<$uselecion;$cont++) { 
          $val_usrs = $asg_usrs[$cont];
          //if ($asg_usrs[$cont].checked==true) { echo " provea usuario = $val_usrs "; }
          $update_str = "role='',estatus='2'";
          $act_usrol = $sql->update("$tbname2","$update_str","usuario='$val_usrs' and estatus='1'");          
          $update_str = "estado='E',fecha_elim='$fechahoy',hora_elim='$hora'";
          $del_usrol = $sql->update("$tbname7","$update_str","role='$vrol' and usuario='$val_usrs' and estado='A'");
          if (!$del_usrol) { $elm_usr = $elm_usr + 1; }  
        }  
      }

      // Verificacion y actualizacion real de los Datos en BD 
      if ($elm_usr==0) {
        pg_exec("COMMIT WORK"); 
    
        //Desconexion de la Base de Datos
        $sql->disconnect();
        Mensajenew("DATOS ELIMINADOS CORRECTAMENTE...!","../comun/z_admgrol.php?conx=0&na_conex=$na_conex&nconex=$nconex&salir=0","S");
        $smarty->display('pie_pag.tpl'); exit(); }

      else {
        pg_exec("ROLLBACK WORK");

        //Desconexion de la Base de Datos
        $sql->disconnect();

        Mensajenew("Falla de Actualizaci&oacute;n de Datos en la BD ...!!!","z_admgrol.php","N");
        $smarty->display('pie_pag.tpl'); exit(); 
      }
      break;
    
    case "Detener":
      $evento = "54";
      break;
  }
    
  //Desconexion de la Base de Datos
  $sql->disconnect();

  Mensaje("DATOS GUARDADOS CORRECTAMENTE...!","z_admgrol.php?nconex=$n_conex&salir=1&conx=0");
  $smarty->display('pie_pag.tpl'); exit(); 
}

if (($vopc!=1) && ($vopc!=2)) {
  $smarty->assign('vmodo','disabled'); 
  $smarty->assign('modo','readonly=readonly'); 
}

//Pase de variables y Etiquetas al template
$smarty->assign('campo1','C&oacute;digo.');
$smarty->assign('campo2','Nombre Rol:');
$smarty->assign('campo3','Creaci&oacute;n');
$smarty->assign('campo4','Descripci&oacute;n:');
$smarty->assign('campo5','Usuarios a Eliminar: ');
$smarty->assign('campo6','de Marcas:');
$smarty->assign('campo7','de Patentes:');
$smarty->assign('campo8','de Derecho de Autor:');

$smarty->assign('vrol',$vrol);
$smarty->assign('vrole',$vrol);
$smarty->assign('vdescripcion',$vdescripcion);
$smarty->assign('vcreacion',$vcreacion);

$smarty->assign('mevento',$mevento);
$smarty->assign('mdescev',$mdescev);
$smarty->assign('vevento_m',0);
$smarty->assign('pevento',$pevento);
$smarty->assign('pdescev',$pdescev);
$smarty->assign('vevento_p',0);
$smarty->assign('aevento',$aevento);
$smarty->assign('adescev',$adescev);
$smarty->assign('vevento_a',0);
$smarty->assign('totevm',$totevm);
$smarty->assign('totevp',$totevp);
$smarty->assign('toteva',$toteva);

$smarty->assign('arrayusers',$arrayusers);
$smarty->assign('arraynames',$arraynames);
$smarty->assign('userasig',$userasig);
$smarty->assign('asig_usr',0);

$smarty->assign('arraylogin',$arraylogin);
$smarty->assign('arrayusuario',$arrayusuario);
$smarty->assign('totalusr',$totalusr);
$smarty->assign('user_r',0);

$smarty->assign('marrayevento',$marrayevento);
$smarty->assign('marraydescev',$marraydescev);
$smarty->assign('evento_m',0);
$smarty->assign('parrayevento',$parrayevento);
$smarty->assign('parraydescev',$parraydescev);
$smarty->assign('evento_p',0);
$smarty->assign('aarrayevento',$aarrayevento);
$smarty->assign('aarraydescev',$aarraydescev);
$smarty->assign('evento_a',0);
$smarty->assign('totalevm',$totalevm);
$smarty->assign('totalevp',$totalevp);
$smarty->assign('totaleva',$totaleva);

$smarty->assign('nconex',$nconex);
$smarty->assign('vtip',$vtip);
$smarty->assign('vopm',$vopm);

$smarty->assign('usuario',$usuario);
$smarty->assign('vopc',$vopc);

$smarty->display('z_admgrol.tpl');
$smarty->display('pie_pag.tpl');
?>
