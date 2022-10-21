<script language="javascript">
 function pregunta() { 
    return confirm('Estas seguro de grabar la Informacion ?'); }
</script>

<?php
// *************************************************************************************
// Programa: z_ingobrol.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MILCO
// Año: II Semestre 2007
// Modificado el Año: 2009 a BD - Relacional 
// *************************************************************************************
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
  echo "Acceso Denegado..."; exit(); }

//Variables
$usuario  = $_SESSION['usuario_login'];
$role     = $_SESSION['usuario_rol'];
$tbname_1 = "stzroles";
$tbname_2 = "stzmenu";
$tbname_3 = "stzrolmenu";
$fecha    = fechahoy();
$sql      = new mod_db();

$vopc=$_GET['vopc'];
$rol_id=$_POST["rol_id"];
$totalobj=$_POST["totalobj"];
$id_objeto=$_POST["id_objeto"];

$smarty->assign('titulo',$substacc);
$smarty->assign('subtitulo','Asignaci&oacute;n de Opciones del Menu por Rol');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Obtención de los Roles
$obj_query = $sql->query("SELECT * FROM $tbname_1 order by nombre");
if (!$obj_query) 
  { 
    mensajenew("Problema al intentar realizar la consulta en la tabla $tbname_1 ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  }
$filas_found=$sql->nums('',$obj_query);
if ($filas_found==0) {
    mensajenew("Tabla de Roles Vacia ...!!!","index.php","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  } 
$cont = 0;
$arrayrole[$cont]=0;
$arraynombre[$cont]='';
$objs = $sql->objects('',$obj_query);
for($cont=1;$cont<=$filas_found;$cont++) { 
    $arrayrole[$cont]=$objs->role;
    $arraynombre[$cont]=trim($objs->nombre);
    $objs = $sql->objects('',$obj_query);
  }

//Obtención de los Objetos del Sistema
$obj_query = $sql->query("SELECT codmenu,nombre FROM $tbname_2 ");
if (!$obj_query) { 
    mensajenew("Problema al intentar realizar la consulta en la tabla $tbname_2 ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  }
$filas_found=$sql->nums('',$obj_query);
$totalobj=$filas_found;
if ($filas_found==0) {
    mensajenew("Tabla de Objetos del Sistema Vacia ...!!!","index.php","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  } 
$cont = 0;
//$arrayobjeto[$cont]=0;
//$arraydescob[$cont]='';
$objs = $sql->objects('',$obj_query);
for($cont=1;$cont<=$filas_found;$cont++) { 
    $arrayobjeto[$cont]=$objs->codmenu;
    $arraydescob[$cont]=$objs->nombre;
    $objs = $sql->objects('',$obj_query);
  }

if ($vopc==2) {
  $fechahoy = hoy();
  $selecion= 0;
  
  //Cuento cuantos eventos fueron seleccionados de Marcas como Patentes
  $selecion= count($id_objeto);

  //Se verifican si los arreglos traen valores
  $selm=0;
  for ($cont=0;$cont<$selecion;$cont++) { 
     $val_objt= $id_objeto[$cont];
     if (!empty($val_objt)) { $selm=1; }
   }

  //Se verifica que hayan elementos seleccionados
  if (($rol_id=="0") || ($selm==0)) {
    mensajenew("Hay Informacion en el formulario requerida que esta Vacia ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); 
  }
  //Nos Conectamos a la base de datos
  $sql->connection();

  //Inserto Datos en la tabla de Objetos asociados al Rol
  if ($selm!=0)
  {
    for ($cont=0;$cont<$selecion;$cont++)
     { 
       $exobjrol = 0;
       $val_objt= $id_objeto[$cont];
    
       $exobjrol= Exrolmenu($rol_id,$val_objt);
       if ($exobjrol==0)
       {
         $insert_str = "'$rol_id','$val_objt','$fechahoy','A'";
         $sql->insert("$tbname_3","","$insert_str","");
       }  
     }  
    
      $gen_txt= gen_txt($rol_id);
         
  }
  
  //Desconexion de la Base de Datos
  $sql->disconnect();

  mensajenew('DATOS GUARDADOS CORRECTAMENTE ..!','z_ingobrol.php','S');
  $smarty->display('pie_pag.tpl'); exit();
}

$smarty->assign('arrayrole',$arrayrole);
$smarty->assign('arraynombre',$arraynombre);
$smarty->assign('rol_id',0);
$smarty->assign('arrayobjeto',$arrayobjeto);
$smarty->assign('arraydescob',$arraydescob);
$smarty->assign('id_objeto',$id_objeto);
$smarty->assign('totalobj',$totalobj);

$smarty->assign('campo1','Role:');
$smarty->assign('campo2','Objetos:');
$smarty->assign('varfocus','forobrol.rol_id'); 

$smarty->display('z_ingobrol.tpl');
$smarty->display('pie_pag.tpl');
?>
