<script language="Javascript"> 

function pregunta() { 
  return confirm('Estas seguro de grabar la Informacion ?'); }

</script>

<?php
// *************************************************************************************
// Programa: m_verbusext.php 
// Realizado por el Analista de Sistema Ing. Romulo Mendoza / PIII 
// Coordinaci�n de Inform�tica / Direcci�n de Soporte Administrativo / SAPI / MILCO
// Desarrollo A�o: 2018 II Semestre
// *************************************************************************************
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");
//Clase que sube el archivo
include ("$include_lib/upload_class.php"); 

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variables
$usuario = $_SESSION['usuario_login'];
$role = $_SESSION['usuario_rol'];

//Conexion
$sql = new mod_db();
$sql->connection($usuario);

//Variables
$tbname_1 = "stmcntrl";
$tbname_2 = "stmviena";
$tbname_3 = "stzusuar";
$tbname_4 = "stmtmpccv";

$fecha   = fechahoy();

$vopc=$_GET['vopc'];
$vauxnum=$_GET['vauxnum'];
$vsol1=$_POST['v1'];
$v1 = $_POST['v1'];
$recibo=$_POST['recibo'];
$fecharec=$_POST['fecharec'];
$prioridad=$_POST['prioridad'];
$solicitant=$_POST['solicitant'];
$accion=$_POST['accion'];
$clase=$_POST['clase'];
$sede=$_POST['sede'];

// ****************************************
$smarty->assign('titulo',$substmar);
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
if ($vopc==1) {
  $smarty->assign('subtitulo','B&uacute;squeda Externa de Elemento Figurativo'); 
  $smarty->assign('modo1',''); 
  $smarty->assign('modo3',''); 
  $smarty->assign('accion',1);
}

//Borra tablas temporales anteriores a la fecha de hoy 
//del_tmpef();

//Verifica si el programa esta en mantenimiento
$manphp = vman_php("m_pbexfigu.php");
if ($manphp==1) {
  $smarty->display('encabezado1.tpl');
  MensageError('AVISO: Modulo en Mantenimiento ...!!!','N');
  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

if (empty($vopc) or ($vopc==1)) {
  $smarty->display('encabezado1.tpl'); }

$smarty->assign('arraytipom',array(N,L));
$smarty->assign('arraynotip',array('NORMAL','LINEA'));

//Opcion Procesar
if ($vopc==1) {
  $smarty->assign('modo1',''); 
  $smarty->assign('modo','readonly=readonly'); 
  $smarty->assign('modo2','disabled'); 
  $smarty->assign('modo3',''); 
  $smarty->assign('submitbutton3','submit');
  $smarty->assign('submitbutton','button');
  $smarty->assign('subtitulo','B&uacute;squeda Externa de Elemento Figurativo'); 
  $smarty->assign('accion',1);

  //Validacion del Numero de Solicitud
  if (empty($vsol1)) {
     mensajenew('AVISO: No introdujo ning&uacute;n valor de Pedido ...!!!','m_verbusext.php?vopc=5','N');
     $smarty->display('pie_pag.tpl'); exit(); }

  $resultado=pg_exec("SELECT * FROM $tbname_1 WHERE pedido='$vsol1'");
  if (!$resultado) { 
     mensajenew('ERROR: PROBLEMA AL PROCESAR LA BUSQUEDA ...!!!','m_verbusext.php?vopc=5','N');
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }	 
  $filas_found=pg_numrows($resultado); 
  if ($filas_found==0) {
     mensajenew('ERROR: NO EXISTEN DATOS ASOCIADOS ...!!!','m_verbusext.php?vopc=5','N');
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }	 
  $reg = pg_fetch_array($resultado);
  $sede=trim($reg[sede]);

  if ($sede=='3') {  }
  else {
    $planilla = "";
    $resplanilla=pg_exec("SELECT cod_planilla FROM stmbusplan WHERE nro_pedido='$vsol1' AND tipo_busq='G'");
    $filas_found=pg_numrows($resplanilla); 
    if ($filas_found!=0) {
      $regplan = pg_fetch_array($resplanilla);
      $planilla= trim($regplan[cod_planilla]); }
    else {
      mensajenew('ERROR: El Pedido NO tiene asociado la Imagen con la planilla ...!!!','m_verbusext.php?vopc=5','N');
      $smarty->display('pie_pag.tpl'); exit();
    }
  }  

  $existe_img = 0;
  if ($sede=='3') {
    $logo_img = "/var/www/apl/sipi/graficos/logbext/".$vsol1.".jpg";
    if (file_exists($logo_img)) {
      $existe_img = 1;
      $nameimage = "$img_virtual/logbext/".$vsol1.".jpg";
    }
  }
  else {
    $logo_img = "$img_virtual/planblog/".$planilla.".jpg";
    //echo "ruta= $logo_img";
    if (file_exists($logo_img)) {
      $existe_img = 1;
      //$nameimage = "../graficos1/logbext/".$vsol1.".jpg";
      //$nameimage = "$img_virtual/logbext/".$vsol1.".jpg"; 
      $nameimage = "$img_virtual/planblog/".$planilla.".jpg";  
    }
    if ($existe_img==0) {  
      //$logo_img = $img_virtual."/logbext/".$vsol1.".png";
      $logo_img = $img_virtual."/planblog/".$planilla.".png";
      if (file_exists($logo_img)) {
        $existe_img = 1;
        //$nameimage = $img_virtual."/logbext/".$vsol1.".png";
        $nameimage = $img_virtual."/planblog/".$planilla.".png";
      }
    }  
    //echo "ruta= $logo_img ";
  }  
  if ($existe_img==0) {
    mensajenew('ERROR: NO EXISTE la Imagen o Logotipo asociado al pedido ...!!!','m_verbusext.php?vopc=5','N');
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();	 
  }
  $smarty->assign('nameimage',$nameimage);

  $vsol1=$reg[pedido];
  $recibo=$reg[recibo];
  $fecharec=$reg[fecharec];
  $solicitant=trim($reg[solicitant]);
  $prioridad=$reg[prioridad];
  $fechaing=$reg[fechaing];
  $horaing=$reg[hora];
  $clase=$reg[clase];
  $envio=$reg[envio];
  $email=$reg[email];
    
  //Almaceno en un string los valores de los campos antes de modificar alguno
  $valores_fields = array($recibo,$fecharec,$solicitant,$prioridad,$fechaing,$horaing);
  $campos = "recibo|fecharec|solicitant|prioridad|fechaing|hora";
  $vstring = bitacora_fields();
  $smarty->assign('fecharec',$fecharec);
  $smarty->assign('vstring',$vstring);
  $smarty->assign('campos',$campos);

  //$rutafinal = '/apl/webpi/graficas/'; 
  $rutafinal = '../documentos/busquedas/webpi/graficas/'; 
  $archivo   = $rutafinal.trim($vsol1).".pdf";

  //$name ="../../../../../apl/webpi/graficas/".$vsol1.".pdf"; 
  $name = $archivo;
  //echo "$name";
  $smarty->assign('name',$name);
    
  if (!is_file($name)) {
    //echo "<td align='left'><a href='$name' target='_blank'><img border='1' src='$imagenresultado' width='80' height='80'></a>";
    mensajenew('ERROR: NO EXISTE El Archivo de Resultados asociado al pedido ...!!!','m_verbusext.php?vopc=5','N');
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();	 
  }

  $sql->del("$tbname_4","solicitud='$vsol1'");
  //Desconexion de la Base de Datos
  $sql->disconnect();
}

if ($vopc!=1) {
  $smarty->assign('modo1',''); 
  $smarty->assign('modo2','disabled'); 
  $smarty->assign('modo3','disabled'); 
  $smarty->assign('submitbutton','button');
  $smarty->assign('submitbutton3','button');
  $smarty->assign('vmodo','readonly=readonly'); 
  $smarty->assign('modo','readonly=readonly'); 
  $nameimage="../imagenes/sin_imagen8.png";
  $smarty->assign('nameimage',$nameimage);
}

if ($vopc==5) {
  $smarty->assign('subtitulo','B&uacute;squeda Externa de Elemento Figurativo'); 
  $smarty->assign('varfocus','formarcas1.v1'); 
  $smarty->assign('submitbutton','submit');
  $smarty->assign('modo1',''); 
  $smarty->assign('modo2','disabled'); 
  $smarty->assign('modo3','disabled'); 
  $smarty->assign('submitbutton3','button');
  $smarty->assign('vmodo',''); 
  $smarty->assign('modo','readonly=readonly'); 
  $smarty->assign('accion',1);
  $smarty->display('encabezado1.tpl');
}

//Pase de variables y Etiquetas al template
$smarty->assign('campo1','Pedido No.:');
$smarty->assign('campo2','Fecha busqueda:');
$smarty->assign('campo3','Tipo de busqueda:');
$smarty->assign('campo4','Recibo Numero:');
$smarty->assign('campo5','Solicitante:');
$smarty->assign('campo6','en Clase:');
$smarty->assign('campo7','Imagen o Logotipo a Buscar:');
$smarty->assign('campo8','Cod. Viena:');
$smarty->assign('campo10','No. Control Planilla:');
$smarty->assign('lcviena','C&oacute;digos de Viena '); 

if ($vopc==1) {
  $smarty->assign('varfocus','formarcas2.vviena'); 
  $smarty->assign('submitbutton','submit');
  $smarty->assign('prioridad',$prioridad); }

$smarty->assign('usuario',$usuario);
$smarty->assign('role',$role);
$smarty->assign('vsol1',$v1);
$smarty->assign('recibo',$recibo);
$smarty->assign('fecharec',$fecharec);
$smarty->assign('prioridad',$prioridad);
$smarty->assign('solicitant',$solicitant);
$smarty->assign('clase',$clase);
$smarty->assign('sede',$sede);
$smarty->assign('planilla',$planilla); 
$smarty->assign('envio',$envio);
$smarty->assign('email',$email);
$smarty->assign('name',$name);

$smarty->display('m_verbusext.tpl');
$smarty->display('pie_pag.tpl');
?>
