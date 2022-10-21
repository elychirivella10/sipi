<?php
// *************************************************************************************
// Programa: m_bexlogo.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Desarrollado en Año: 2010
// *************************************************************************************

//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");
?>

<script language="Javascript"> 

function pregunta() { 
  return confirm('Estas seguro de grabar la Informacion ?'); }

</script> 

<script type="text/javascript">
String.prototype.reverse=function(){return this.split('').reverse().join('');};
function number_condec(e){
function f(){
var v=this.value;
var pos=v.indexOf('.');
var vdec=v.substring(pos+1,pos+3);
var vent=v.substring(0,pos);
if (pos>0) {this.value=vent.concat('.').concat(vdec);}
this.value=this.value.reverse().replace(/[^0-9.]/g,'').replace(/\.(?=\d*[.]\d*)/g,'').reverse();
}
e.onkeyup=f
e.onkeydown=f
e.onkeypress=f
e.onmousedown=f
e.onmouseup=f
e.onclick=f
e.onchange=t
e.onblur=f
}

function number_sindec(e){
function f(){
this.value=this.value.reverse().replace(/[^0-9]/g,'').replace(/\.(?=\d*[.]\d*)/g,'').reverse();
}
e.onkeyup=f
e.onkeydown=f
e.onkeypress=f
e.onmousedown=f
e.onmouseup=f
e.onclick=f
e.onchange=t
e.onblur=f
}

function solo2dec(n) {
   var v=n.value;
   var pos=v.indexOf('.');
   var vdec=v.substring(pos+1,pos+3);
   var vent=v.substring(0,pos);
   var vfin=vent.concat('.').concat(vdec);
   if (pos>0) {n.value=vfin;}
}

</script>


<?php

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variables
$usuario = $_SESSION['usuario_login'];

//Verificando conexion
$sql = new mod_db();
$sql->connection($usuario);

//Variables
$tbname_1 = "stmcntrl";
$tbname_2 = "stzbitac";
$tbname_3 = "stmbusplan";
$fecha    = fechahoy();

$vopc    = $_GET['vopc'];
$vauxnum = $_GET['vauxnum'];
$vsol1   = $_POST['vsol1'];
$recibo  = $_POST['recibo'];
$fecharec= $_POST['fecharec'];
$prioridad = $_POST['prioridad'];
$solicitant= trim($_POST['solicitant']);
$telefono  = trim($_POST['telefono']);
$indole    = $_POST['indole'];
$lced      = $_POST['lced'];
$nced      = trim($_POST['nced']);
$accion    = $_POST['accion'];
$auxnum    = $_POST['auxnum'];
$vsede     = trim($_POST['vsede']);
$clase     = $_POST['clase'];
$planilla  = $_POST['planilla'];

// ****************************************
$smarty->assign('titulo',$substmar);
if (($vopc!=1) && ($vopc!=3) && ($vopc!=4)) {
  $smarty->assign('subtitulo','B&uacute;squeda de Elemento Figurativo'); 
}
if ($vopc==1) {
  $smarty->assign('subtitulo','B&uacute;squeda de Elemento Figurativo / Modificar'); 
}
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
if (empty($vopc) or ($vopc==1)) {
  $smarty->display('encabezado1.tpl'); }

$smarty->assign('arraytipom',array(N,L));
$smarty->assign('arraynotip',array('NORMAL','HABILITADA'));

$contobji=0;
$vcodsede[$contobji] = '';
$vnomsede[$contobji] = '';
$objquery = $sql->query("SELECT * FROM stzsede ORDER BY sede");
$objfilas = $sql->nums('',$objquery);
$objs = $sql->objects('',$objquery);
for ($contobji=1;$contobji<=$objfilas;$contobji++) {
  $vcodsede[$contobji] = $objs->sede;
  $vnomsede[$contobji] = trim(sprintf("%02d",$objs->sede)." ".trim($objs->nombre));
  $objs = $sql->objects('',$objquery); }	  

//Opcion Modificar
if ($vopc==1) {
  $smarty->assign('modo1','disabled'); 
  $smarty->assign('vmodo','disabled'); 
  $smarty->assign('modo',''); 
  $smarty->assign('modo2',''); 
  $smarty->assign('modo3',''); 
  $smarty->assign('submitbutton3','submit');
  $smarty->assign('submitbutton','button');
  $smarty->assign('subtitulo','B&uacute;squeda de Elemento Figurativo / Modificar'); 
  $smarty->assign('accion',2);
  $vopc=1;

  //Validacion del Numero de Solicitud
  if (empty($vsol1)) {
     mensajenew('ERROR: No introdujo ningún valor de Pedido ...!!!','m_bexlogo.php?vopc=4','N');
     $smarty->display('pie_pag.tpl'); exit(); }
  
  $resultado=pg_exec("SELECT * FROM $tbname_1 WHERE pedido='$vsol1' AND estatus='1'");
  if (!$resultado) { 
    mensajenew('ERROR: No se pudo accesar la Base da Datos ...!!!','m_bexlogo.php?vopc=4&vauxnum=0','N');
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }	 
  $filas_found=pg_numrows($resultado); 
  if ($filas_found==0) {
     mensajenew('AVISO: NO EXISTEN DATOS ASOCIADOS O PEDIDO EN ESTATUS DIFERENTE PARA MODIFICAR ...!!!','m_bexlogo.php?vopc=4&vauxnum=0','N');
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }	 
  $reg = pg_fetch_array($resultado);

  $vsol1     = $reg[pedido];
  $recibo    = $reg[recibo];
  $fecharec  = $reg[fecharec];
  $solicitant= trim($reg[solicitant]);
  $prioridad = $reg[prioridad];
  $fechaing  = $reg[fechaing];
  $horaing   = $reg[hora];
  $lced      = substr($reg[identificacion],0,1);
  $nced      = trim(substr($reg[identificacion],1,9));
  $cedrif    = $reg[identificacion];
  $indole    = $reg[indole];
  $telefono  = trim($reg[telefono]);
  $vsede     = trim($reg[sede]);
  $clase     = $reg[clase];

  //Almaceno en un string los valores de los campos antes de modificar alguno
  $valores_fields = array($recibo,$fecharec,$solicitant,$prioridad,$fechaing,$horaing,$cedrif);
  $campos = "recibo|fecharec|solicitant|prioridad|fechaing|hora|identificacion";
  $vstring = bitacora_fields();
  $smarty->assign('fecharec',$fecharec);
  $smarty->assign('vstring',$vstring);
  $smarty->assign('campos',$campos);
}

//Opcion Grabar...
if ($vopc==2) {
  $smarty->assign('subtitulo','B&uacute;squeda de Elemento Figurativo');
  $smarty->display('encabezado1.tpl');

  //Validacion del Numero de Evento
  if ($accion==2) {
    if (empty($vsol1)) {
      mensajenew('ERROR: No introdujo ningún valor de Pedido ...!!!','m_bexlogo.php?vopc=4','N');
      $smarty->display('pie_pag.tpl'); exit(); }
  }

  $cedrif = $lced.$nced;
  //Verificacion de que los campos requeridos esten llenos...
  if (empty($fecharec) || empty($prioridad) || empty($recibo) || 
     empty($solicitant) || empty($vsol1) || empty($cedrif)) {
     mensajenew('ERROR: Hay Informacion basica en el formulario que esta Vacia ...!!!','m_bexlogo.php','N');
     $smarty->display('pie_pag.tpl'); exit(); }

  if (empty($vsede)) {
      mensajenew('AVISO: Debe seleccionar la Sede donde se recibio el Pedido ...!!!','javascript:history.back();','N');
      $smarty->display('pie_pag.tpl'); exit(); }

  if ((empty($planilla)) || ($planilla=='00000000')) {
      mensajenew('ERROR: Debe ingresar el N&uacute;mero de Planilla Blanca del Pedido o no puede ser Cero ...!!!','javascript:history.back();','N');
      $smarty->display('pie_pag.tpl'); exit(); }

  // Ingreso de Solicitud
  if ($accion==1) {
    //Variable para la busqueda de la imagen
    $insplan  = true;
    $insbusq  = true;
    $fechahoy = Hoy();
    $horactual= Hora();
    
    pg_exec("BEGIN WORK");
    $resultado=pg_exec("SELECT * FROM stmcntrl WHERE pedido='$vsol1'");
    $filas_found=pg_numrows($resultado); 
    if ($filas_found!=0) {
       mensajenew('Numero de Pedido YA existe en la Base de Datos ...!!!','m_bexlogo.phpvopc=3','N');
       $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

    $resplanilla=pg_exec("SELECT * FROM stmbusplan WHERE cod_planilla='$planilla'");
    $filas_found=pg_numrows($resplanilla); 
    if ($filas_found!=0) {
      mensajenew('ERROR: N&uacute;mero Control de Planilla Blanca YA usado en otro Pedido ...!!!','m_bexlogo.phpvopc=3','N');
      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

    $solicitant = str_replace("'","´",$solicitant);

    $insert_str = "'$vsol1','$recibo','$fecharec','$horactual','$solicitant','$fechahoy','1','$usuario',null,'$prioridad','$cedrif','$indole','$telefono','$vsede','$clase'"; 
    $insbusq = $sql->insert("$tbname_1","","$insert_str","");

    $insert_str = "'$vsol1','G','$planilla','2013'";
    $insplan = $sql->insert("$tbname_3","","$insert_str","");

    //Variable para la busqueda de la imagen en busqueda
    //$ruta = "../graficos/logbext/";
    //$archivo = "$vsol1";
    //if (!empty($archivo)) {
    //  //Copiar archivo de logotipo en ruta final
    //  $max_size = 1024*100; // the max. size for uploading	
    //  $my_upload = new file_upload;
    //  $my_upload->upload_dir = $ruta; // "files" is the folder for the uploaded files (you have to create this folder)
    //  $my_upload->extensions = array(".jpg", ".jpge",".png"); // specify the allowed extensions here
    //  $my_upload->max_length_filename = 50; // change this value to fit your field length in your database (standard 100)
    //  $my_upload->rename_file = true;
    //  //$my_upload->the_temp_file = $_FILES['ubicacion']['tmp_name'];
    //  //$my_upload->the_file = $_FILES['ubicacion']['name'];
    //  $my_upload->the_temp_file = "../graficos/sin_imagen.jpg";
    //  $my_upload->the_file = "$vsol1";
    //  //$my_upload->http_error = $_FILES['ubicacion']['error'];
    //  $my_upload->validateExtension();
    //  if ($my_upload->upload($vsol1)) { 
	 //    echo '';		
    //  } 
    //else {
    //  mensajenew($my_upload->show_error_string(),"javascript:history.back();","N");
    //  $smarty->display('pie_pag.tpl'); exit(); }
    //}

    if (($insbusq) && ($insplan)) {
      pg_exec("COMMIT WORK");
      //Desconexion de la Base de Datos
      $sql->disconnect();
   
      Mensajenew('DATOS GUARDADOS CORRECTAMENTE ...!!!','m_bexlogo.php?vopc=3','S');
      $smarty->display('pie_pag.tpl'); exit();
    }
    else {
      pg_exec("ROLLBACK WORK");
      //Desconexion de la Base de Datos
      $sql->disconnect();

      Mensajenew("Falla de Actualizaci&oacute;n / Inserci&oacute;n de Datos en la BD ...!!!","javascript:history.back();","N");
      $smarty->display('pie_pag.tpl'); exit();
    }

  } //Incluir
  // Modificar Solicitud
  else {
    $actbusq = true;
    $actplan = true;
    //La Fecha de Hoy y Hora para la transaccion
    $fechahoy = Hoy();
    $horactual= Hora();

    // Actualizo en Maestra de Eventos

    pg_exec("BEGIN WORK");
    pg_exec("LOCK TABLE stmcntrl IN SHARE ROW EXCLUSIVE MODE");
    $update_str = "recibo='$recibo',fecharec='$fecharec',prioridad='$prioridad',solicitant='$solicitant',identificacion='$cedrif',indole='$indole',telefono='$telefono',sede='$vsede',clase=$clase";
    $actbusq = $sql->update("$tbname_1","$update_str","pedido='$vsol1'");

    pg_exec("LOCK TABLE stmbusplan IN SHARE ROW EXCLUSIVE MODE");
    $update_str = "cod_planilla='$planilla'";
    $actplan = $sql->update("$tbname_3","$update_str","nro_pedido='$vsol1'");

    if (($actbusq) && ($actplan)) { 
      pg_exec("COMMIT WORK");
      //Desconexion de la Base de Datos
      $sql->disconnect();
   
      Mensajenew('DATOS GUARDADOS CORRECTAMENTE ...!!!','m_bexlogo.php?vopc=4','S');
      $smarty->display('pie_pag.tpl'); exit();
    }
    else {
      pg_exec("ROLLBACK WORK");
      //Desconexion de la Base de Datos
      $sql->disconnect();

      Mensajenew("Falla de Actualizaci&oacute;n / Inserci&oacute;n de Datos en la BD ...!!!","javascript:history.back();","N");
      $smarty->display('pie_pag.tpl'); exit();
    }
  } // Modificar

}

if (($vopc!=1) && ($vopc!=2) && ($vopc!=3) && ($vopc!=4)) {
  $smarty->assign('modo1',''); 
  $smarty->assign('modo2','disabled'); 
  $smarty->assign('modo3','disabled'); 
  $smarty->assign('submitbutton','button');
  $smarty->assign('submitbutton3','button');
  $smarty->assign('vmodo','readonly=readonly'); 
  $smarty->assign('modo','readonly=readonly'); 
}

if ($vopc==5) {
  //La Fecha de Hoy para la solicitud
  $fecharec = hoy();
  //$tnumera='secuencial';
  //Se obtiene el proximo valor segun stzsystem
  //$sys_actual = next_sys("$tnumera");
  //$vauxnum = grabar_sys("$tnumera",$sys_actual);
  
  $obj_query = $sql->query("update stzsystem set figurativo=nextval('stzsystem_figurativo_seq')");
  $obj_query = $sql->query("select last_value from stzsystem_figurativo_seq");
  $objs = $sql->objects('',$obj_query);
  $sys_actual = $objs->last_value;
  $vauxnum = $sys_actual;
  
  $smarty->assign('subtitulo','B&uacute;squeda de Elemento Figurativo / Ingreso'); 
  $smarty->assign('fecharec',$fecharec);
  $smarty->display('encabezado1.tpl');
  $smarty->assign('varfocus','formarcas2.fecharec');
  $smarty->assign('vmodo','readonly=readonly'); 
  $smarty->assign('submitbutton','button');
  $smarty->assign('submitbutton3','submit');
  $smarty->assign('modo1','disabled'); 
  $smarty->assign('modo',''); 
  $smarty->assign('modo2',''); 
  $smarty->assign('modo3',''); 
  $smarty->assign('accion',1);
  $vsol1 = $vauxnum;
}

if ($vopc==3) {
  ////La Fecha de Hoy para la solicitud
  //$fecharec = hoy();
  //$tnumera='secuencial';
  ////Se obtiene el proximo valor segun stzsystem
  //$sys_actual = next_sys("$tnumera");
  //$vauxnum = grabar_sys("$tnumera",$sys_actual);
  $smarty->assign('subtitulo','B&uacute;squeda de Elemento Figurativo / Ingreso'); 
  //$smarty->assign('fecharec',$fecharec);
  $smarty->display('encabezado1.tpl');
  //$smarty->assign('varfocus','formarcas2.fecharec');
  $smarty->assign('vmodo','disabled'); 
  //$smarty->assign('submitbutton','button');
  //$smarty->assign('submitbutton3','submit');
  //$smarty->assign('modo1','disabled'); 
  $smarty->assign('modo','disabled'); 
  $smarty->assign('modo2','disabled'); 
  //$smarty->assign('modo3',''); 
  //$smarty->assign('accion',1);
  //$vsol1 = $vauxnum;
}

if ($vopc==4) {
  $smarty->assign('subtitulo','B&uacute;squeda de Elemento Figurativo / Modificar'); 
  $smarty->display('encabezado1.tpl');
  $smarty->assign('varfocus','formarcas1.vsol1'); 
  $smarty->assign('submitbutton','submit');
  $smarty->assign('modo1','disabled'); 
  $smarty->assign('modo2','disabled'); 
  $smarty->assign('modo3','disabled'); 
  $smarty->assign('submitbutton3','button');
  $smarty->assign('vmodo',''); 
  $smarty->assign('modo','readonly=readonly'); 
  $smarty->assign('accion',2);
  $smarty->assign('vopc',$vopc);

}

//Pase de variables y Etiquetas al template
$smarty->assign('campo1','Pedido No.:');
$smarty->assign('campo2','Fecha Recibo:');
$smarty->assign('campo3','Tipo de B&uacute;squeda:');
$smarty->assign('campo4','Recibo N&uacute;mero:');
$smarty->assign('campo5','Solicitante:');
$smarty->assign('campo6','Indole:');
$smarty->assign('campo7','C&eacute;dula/Rif.:');
$smarty->assign('campo8','Nomenclatura:');
$smarty->assign('campo9','Tel&eacute;fono:');
$smarty->assign('campo10','Sede:');
$smarty->assign('campo11','Clase:');
$smarty->assign('campo12','N&uacute;mero Control Planilla Blanca:');
$smarty->assign('lced_id',array(' ','V','E','P','J','G')); 
$smarty->assign('lced_de',array(' ','V','E','P','J','G'));
$smarty->assign('vindole_id',array(' ','G','C','O','P','N')); 
$smarty->assign('vindole_de',array(' ','Sector Publico','Cooperativa','Comunal','Empresa Privada','Persona Natural'));

if ($vopc==1) {
  $smarty->assign('varfocus','formarcas2.fecharec');
  $smarty->assign('submitbutton','button');
  $smarty->assign('modo3','disabled'); }

if ($vopc==2) {
  $smarty->assign('varfocus','formarcas1.vsol1'); 
  $smarty->assign('modo',''); 
  $smarty->assign('submitbutton','submit');
  $smarty->assign('prioridad',$prioridad); }

$smarty->assign('vopc',$vopc);
$smarty->assign('usuario',$usuario);
$smarty->assign('vsol1',$vsol1);
$smarty->assign('recibo',$recibo);
$smarty->assign('fecharec',$fecharec);
$smarty->assign('prioridad',$prioridad);
$smarty->assign('solicitant',$solicitant);
$smarty->assign('lced',$lced);
$smarty->assign('nced',$nced);
$smarty->assign('telefono',$telefono);
$smarty->assign('indole',$indole);
$smarty->assign('vcodsede',$vcodsede);
$smarty->assign('vnomsede',$vnomsede); 
$smarty->assign('vsede',$vsede);

$smarty->display('m_bexlogo.tpl');
$smarty->display('pie_pag.tpl');
?>
