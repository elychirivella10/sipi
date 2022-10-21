<?php
// *************************************************************************************
// Programa: m_bexfigu.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MILCO
// Desarrollado en Año: 2006
// Modificado por Maryury Bonilla el 25 de Mayo de 2009 a las 12:20pm
// *************************************************************************************

//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");
//Clase que sube el archivo
include ("$include_lib/upload_class.php"); 
   
?>
<script language="Javascript"> 

function pregunta() { 
  return confirm('Estas seguro de grabar la Informacion ?'); }

</script> 

<?php

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variables
$usuario = $_SESSION['usuario_login'];
$role = $_SESSION['usuario_rol'];

//Verificando conexion
$sql = new mod_db();
$sql->connection($usuario);

//Variables
$tbname_1 = "stmcntrl";
$tbname_2 = "stzbitac";
$tbname_3 = "stmbusplan";
$fecha    = fechahoy();

$vopc      = $_GET['vopc'];
$vauxnum   = $_GET['vauxnum'];
$vsol1     = $_POST['vsol1'];
$recibo    = $_POST['recibo'];
$fecharec  = $_POST['fecharec'];
$prioridad = $_POST['prioridad'];
$solicitant= trim($_POST['solicitant']);
$accion    = $_POST['accion'];
$auxnum    = $_POST['auxnum'];
$nameimage = $_POST['nameimage'];
$ubicacion = $_POST['ubicacion'];
$telefono  = trim($_POST['telefono']);
$indole    = trim($_POST['indole']);
$lced      = trim($_POST['lced']);
$nced      = $_POST['nced'];
$planilla  = trim($_POST['planilla']); 

// ****************************************
$smarty->assign('titulo',$substmar);
if (($vopc!=1) && ($vopc!=3) && ($vopc!=4)) {
  $smarty->assign('subtitulo','Elemento Figurativo'); 
}
if ($vopc==1) {
  $smarty->assign('subtitulo','Elemento Figurativo / Modificar'); 
}
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
if (empty($vopc) or ($vopc==1)) {
  $smarty->display('encabezado1.tpl'); }

$smarty->assign('arraytipom',array(N,L));
$smarty->assign('arraynotip',array('NORMAL','HABILITADA'));

//Borra tablas temporales  
//delri_tmpef();

//Verifica si el programa esta en mantenimiento
$manphp = vman_php("m_bexfigu.php");
if ($manphp==1) {
  $smarty->display('encabezado1.tpl');
  MensageError('AVISO: Modulo en Mantenimiento ...!!!','N');
  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

//Opcion Modificar
if ($vopc==1) {
  $smarty->assign('modo1','disabled'); 
  $smarty->assign('vmodo','disabled'); 
  $smarty->assign('modo',''); 
  $smarty->assign('modo2',''); 
  $smarty->assign('modo3',''); 
  $smarty->assign('subtitulo','Elemento Figurativo / Modificar'); 
  $smarty->assign('accion',2);
  $vopc=1;

  //Validacion del Numero de Solicitud
  if (empty($vsol1)) {
     mensajenew('AVISO: No introdujo ning&uacute;n valor de Pedido ...!!!','m_bexfigu.php?vopc=4&vauxnum=0','N');
     $smarty->display('pie_pag.tpl'); exit(); }
  
  $resultado=pg_exec("SELECT * FROM $tbname_1 WHERE pedido='$vsol1'");
  if (!$resultado) { 
    mensajenew('ERROR AL PROCESAR LA BUSQUEDA ...!!!','m_bexfigu.php?vopc=4','N');
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }	 
  $filas_found=pg_numrows($resultado); 
  if ($filas_found==0) {
    mensajenew('AVISO: NO EXISTEN DATOS ASOCIADOS ...!!!','m_bexfigu.php?vopc=4','N');
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
  $nced      = substr($reg[identificacion],1,9);
  $cedrif    = $reg[identificacion];
  $indole    = $reg[indole];
  $telefono  = trim($reg[telefono]);

  $resplanilla=pg_exec("SELECT cod_planilla FROM stmbusplan WHERE nro_pedido='$vsol1' AND tipo_busq='G'");
  $filas_found=pg_numrows($resplanilla); 
  if ($filas_found!=0) {
    $regplan = pg_fetch_array($resplanilla);
    $planilla= trim($regplan[cod_planilla]);
    $planilla1= trim($regplan[cod_planilla]);
  } else { $planilla= ""; }

  //Colocado el 19/11/2012 
  //$nameimage = $img_virtual."/logbext/".$vsol1.".jpg";
  $nameimage = $img_virtual."/planblog/".$planilla.".jpg";
  $smarty->assign('nameimage',$nameimage);

  //Almaceno en un string los valores de los campos antes de modificar alguno
  $valores_fields = array($recibo,$fecharec,$solicitant,$prioridad,$fechaing,$horaing,$cedrif);
  $campos = "recibo|fecharec|solicitant|prioridad|fechaing|hora|identificacion";
  $vstring = bitacora_fields();
  $smarty->assign('fecharec',$fecharec);
  $smarty->assign('vstring',$vstring);
  $smarty->assign('campos',$campos);
  $smarty->assign('planilla',$planilla);
  $smarty->assign('planilla1',$planilla1);
}

//Opcion Grabar...
if ($vopc==2) {
  $smarty->assign('subtitulo','Elemento Figurativo');
  $smarty->display('encabezado1.tpl');
  $planilla  = trim($_POST['planilla']);
  $planilla1 = trim($_POST['planilla1']);
  
  //Validacion del Numero de Evento
  if (empty($vsol1)) {
     mensajenew('ERROR: No introdujo ning&uacute;n valor de Pedido ...!!!','m_bexfigu.php?vopc=4','N');
     $smarty->display('pie_pag.tpl'); exit(); }

  //Validacion del Numero de Evento
  if (empty($planilla)) {
     mensajenew('ERROR: No introdujo el Valor de la Planilla Blanca... !!!','m_bexfigu.php?vopc=4','N');
     $smarty->display('pie_pag.tpl'); exit(); }

  $cedrif = trim($lced.$nced);
  //Verificacion de que los campos requeridos esten llenos...
  if (empty($fecharec) || empty($prioridad) || empty($recibo) || 
     empty($solicitant) || empty($vsol1) || empty($indole)) {
     if ($accion==1) {
       mensajenew('AVISO: Hay Informaci&oacute;n b&aacute;sica en el formulario que esta Vacia ...!!!','m_bexfigu.php?vopc=3','N'); }
     else {
       mensajenew('AVISO: Hay Informaci&oacute;n b&aacute;sica en el formulario que esta Vacia ...!!!','m_bexfigu.php?vopc=4','N'); }
     $smarty->display('pie_pag.tpl'); exit(); }

  // Ingreso de Solicitud
  if ($accion==1) {
    //Variable para la busqueda de la imagen
    $insbusq  = true;
    $fechahoy = Hoy();
    $horactual= Hora();

    pg_exec("BEGIN WORK");
    $resultado=pg_exec("SELECT * FROM stmcntrl WHERE pedido='$vsol1'");
    $filas_found=pg_numrows($resultado); 
    if ($filas_found!=0) {
       mensajenew('ERROR: N&uacute;mero de Pedido YA existe en la Base de Datos ...!!!','m_bexfigu.phpvopc=3','N');
       $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
    $solicitant = str_replace("'","",$solicitant);

    $insert_str = "'$vsol1','$recibo','$fecharec','$horactual','$solicitant','$fechahoy','1','$usuario',null,'$prioridad','$cedrif','$indole','$telefono'"; 
    $insbusq  = $sql->insert("$tbname_1","","$insert_str","");
    pg_exec("COMMIT WORK");

    //Variable para la busqueda de la imagen en busqueda
    //$ruta = "../graficos/logbext/";
    $ruta = $img_virtual."/logbext/";
    $archivo = $_FILES['ubicacion']['name'];
	//echo "<hr>".$ruta.$archivo."<hr>";
    if (!empty($archivo)) {
       //Copiar archivo de logotipo en ruta final
       $max_size = 1024*100; // the max. size for uploading	
       $my_upload = new file_upload;
       //$my_upload->upload_dir = "/var/www/sistemas/imagenes/temp/"; // "files" is the folder for the uploaded files (you have to create this folder)
       $my_upload->upload_dir = $ruta; // "files" is the folder for the uploaded files (you have to create this folder)
       $my_upload->extensions = array(".jpg", ".jpge",".png"); // specify the allowed extensions here
       $my_upload->max_length_filename = 50; // change this value to fit your field length in your database (standard 100)
       $my_upload->rename_file = true;
       $my_upload->the_temp_file = $_FILES['ubicacion']['tmp_name'];
       $my_upload->the_file = $_FILES['ubicacion']['name'];
       $my_upload->http_error = $_FILES['ubicacion']['error'];
       $my_upload->validateExtension();
       if ($my_upload->upload($vsol1)) { 
	  echo '';		
       } 
       else {
	  //Mensage_Error($my_upload->show_error_string());
          mensajenew($my_upload->show_error_string(),"javascript:history.back();","N");
          $smarty->display('pie_pag.tpl'); exit(); }
    }
    else {
       mensajenew('AVISO: Imagen aun NO seleccionada ...!!!','javascript:history.back();','N');
       $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();
    }

  } //Incluir
  // Modificar Solicitud
  else {
    //Variable para la busqueda de la imagen en busqueda
	 //$ruta = "../graficos/logbext/";
    //$ruta = $img_virtual."/logbext/";
    //Colocado el 19/11/2012 
    $ruta = $img_virtual."/planblog/";
    $archivo = $_FILES['ubicacion']['name'];
	 //echo "<hr>".$ruta.$archivo."<hr>";
    if (!empty($archivo)) {
       $anterior=$ruta.$vsol1.".jpg";
       //unlink($anterior);
       //Copiar archivo de logotipo en ruta final
       $max_size = 1024*100; // the max. size for uploading	
       $my_upload = new file_upload;
       //$my_upload->upload_dir = "/var/www/sistemas/imagenes/temp/"; // "files" is the folder for the uploaded files (you have to create this folder)
       $my_upload->upload_dir = $ruta; // "files" is the folder for the uploaded files (you have to create this folder)
       $my_upload->extensions = array(".jpg", ".jpge",".png"); // specify the allowed extensions here
       $my_upload->max_length_filename = 50; // change this value to fit your field length in your database (standard 100)
       $my_upload->rename_file = true;
       $my_upload->the_temp_file = $_FILES['ubicacion']['tmp_name'];
       $my_upload->the_file = $_FILES['ubicacion']['name'];
       $my_upload->http_error = $_FILES['ubicacion']['error'];
       $my_upload->validateExtension();
       //if ($my_upload->upload($vsol1)) {
       //Colocado el 19/11/2012  
       if ($my_upload->upload($planilla)) {        
	       echo '';		
       } 
       else {
	  //Mensage_Error($my_upload->show_error_string());
         mensajenew($my_upload->show_error_string(),"javascript:history.back();","N");
         $smarty->display('pie_pag.tpl'); exit(); }
    }

    //Se obtiene el proximo valor para el secuencial a guardar en stzbitac a partir de stzsistem
    //pg_exec("BEGIN WORK");
    //pg_exec("LOCK TABLE stzsystem IN SHARE ROW EXCLUSIVE MODE");
    //$sys_actual = next_sys("nbitaco");
    //$vsecuencial = grabar_sys("nbitaco",$sys_actual);
    //pg_exec("COMMIT WORK");

    $actbusq = true;
    $actplan = true;
    $insplan = true;
    //La Fecha de Hoy y Hora para la transaccion
    $fechahoy = Hoy();
    $horactual= Hora();
    // Almaceno registro original en Bitacora
    //$insert_str = "'$vsecuencial','$fechahoy','$horactual','$usuario','$tbname_1','M','M','$pedido','$vstring','$campos'";
    //$sql->insert("$tbname_2","","$insert_str","");

    // Actualizo en Maestra de Eventos
    pg_exec("BEGIN WORK");
    pg_exec("LOCK TABLE stmcntrl IN SHARE ROW EXCLUSIVE MODE");
    $solicitant = str_replace("'","",$solicitant);

    //$update_str = "recibo='$recibo',fecharec='$fecharec',prioridad='$prioridad',solicitant='$solicitant',identificacion='$cedrif',indole='$indole',telefono='$telefono'";
    $update_str = "telefono='$telefono'";
    echo "cambio=$update_str, $planilla1 ";
    $actbusq = $sql->update("$tbname_1","$update_str","pedido='$vsol1'");

    if ($planilla!=$planilla1) {
      $resplanilla=pg_exec("SELECT * FROM stmbusplan WHERE cod_planilla='$planilla' AND tipo_busq='G'");
      $filas_found=pg_numrows($resplanilla); 
      echo "son=$filas_found";
      if ($filas_found==0) {
        pg_exec("LOCK TABLE stmbusplan IN SHARE ROW EXCLUSIVE MODE");
        //$del_datos = $sql->del("$tbname_3","nro_pedido='$vsol1' AND tipo_busq='G'");
        //$insert_str = "'$vsol1','G','$planilla','2013'";
        //$insplan = $sql->insert("$tbname_3","","$insert_str","");
        $update_str = "cod_planilla='$planilla'";
        $actplan = $sql->update("$tbname_3","$update_str","nro_pedido='$vsol1'"); 
      }
      else {
      //  $insert_str = "'$vsol1','G','$planilla','2013'";
      //  $insplan = $sql->insert("$tbname_3","","$insert_str","");
        mensajenew('ERROR: N&uacute;mero de Planilla YA existe en la Base de Datos ...!!!','javascript:history.back();','N');
        $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
      }
    }    
    
    if (($actbusq) && ($actplan) && ($insplan)) { 
      pg_exec("COMMIT WORK");
      //Desconexion de la Base de Datos
      $sql->disconnect();
   
      Mensajenew('DATOS GUARDADOS CORRECTAMENTE ...!!!','m_bexfigu.php?vopc=4','S');
      $smarty->display('pie_pag.tpl'); exit();
    }
    else {
      pg_exec("ROLLBACK WORK");
      //Desconexion de la Base de Datos
      $sql->disconnect();

      Mensajenew("ERROR: Falla de Actualizaci&oacute;n de Datos en la BD... !!!","javascript:history.back();","N");
      $smarty->display('pie_pag.tpl'); exit();
    }
    
  } // Modificar

  ////Desconexion de la Base de Datos
  //$sql->disconnect();

  //$smarty->assign('subtitulo','Elemento Figurativo');
  //$smarty->display('encabezado1.tpl');
  if ($accion==1) {
    //Desconexion de la Base de Datos
    $sql->disconnect();

    mensajenew('DATOS GUARDADOS CORRECTAMENTE!!!','m_bexfigu.php?vopc=3','S');
    $smarty->display('pie_pag.tpl'); exit();
  }
  //else {
  //  mensajenew('DATOS GUARDADOS CORRECTAMENTE!!!','m_bexfigu.php?vopc=4','S'); }
  //$smarty->display('pie_pag.tpl'); exit();
}
$smarty->assign('lced',$lced);
$smarty->assign('nced',$nced);
$smarty->assign('telefono',$telefono);
$smarty->assign('indole',$indole);

if (($vopc!=1) && ($vopc!=2) && ($vopc!=3) && ($vopc!=4)) {
  $smarty->assign('modo1',''); 
  $smarty->assign('modo2','disabled'); 
  $smarty->assign('modo3',''); 
  $smarty->assign('vmodo','readonly=readonly'); 
  $smarty->assign('modo','readonly=readonly'); 
  $nameimage="../imagenes/sin_imagen8.png";
  $smarty->assign('nameimage',$nameimage);
}

if ($vopc==3) {
  $smarty->assign('subtitulo','Elemento Figurativo / Ingreso'); 
  $smarty->display('encabezado1.tpl');
  $smarty->assign('varfocus','formarcas2.nueva');
  $smarty->assign('vmodo','disabled'); 
  $smarty->assign('modo1','disabled'); 
  $smarty->assign('modo','disabled'); 
  $smarty->assign('modo2','disabled'); 
  $smarty->assign('modo3','disabled');
  $nameimage="../imagenes/sin_imagen8.png";
  $smarty->assign('nameimage',$nameimage);
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
  
  $smarty->assign('subtitulo','Elemento Figurativo / Ingreso'); 
  $smarty->assign('fecharec',$fecharec);
  $smarty->display('encabezado1.tpl');
  $smarty->assign('varfocus','formarcas2.fecharec');
  $smarty->assign('vmodo','readonly=readonly'); 
  $smarty->assign('modo1',''); 
  $smarty->assign('modo',''); 
  $smarty->assign('modo2',''); 
  $smarty->assign('modo3',''); 
  $smarty->assign('accion',1);
  $vsol1 = $vauxnum;
  $nameimage="../imagenes/sin_imagen8.png";
  $smarty->assign('nameimage',$nameimage);
}

if ($vopc==4) {
  $smarty->assign('subtitulo','Elemento Figurativo / Modificar'); 
  $smarty->display('encabezado1.tpl');
  $smarty->assign('varfocus','formarcas1.vsol1'); 
  $smarty->assign('modo1','disabled'); 
  $smarty->assign('modo2','disabled'); 
  $smarty->assign('modo3','disabled'); 
  $smarty->assign('vmodo',''); 
  $smarty->assign('modo','readonly=readonly'); 
  $smarty->assign('accion',2);
  $nameimage="../imagenes/sin_imagen8.png";
  $smarty->assign('nameimage',$nameimage);
  $smarty->assign('vopc',$vopc);
}

//Pase de variables y Etiquetas al template
$smarty->assign('campo1','Pedido No.:');
$smarty->assign('campo2','Fecha busqueda:');
$smarty->assign('campo3','Tipo de busqueda:');
$smarty->assign('campo4','Recibo Numero:');
$smarty->assign('campo5','Solicitante:');
$smarty->assign('campo6','Indole:');
$smarty->assign('campo7','C&eacute;dula/Rif.:');
$smarty->assign('campo8','Nomenclatura:');
$smarty->assign('campo9','Tel&eacute;fono:');
$smarty->assign('lced_id',array(' ','V','E','P','J','G')); 
$smarty->assign('lced_de',array(' ','V','E','P','J','G'));
$smarty->assign('vindole_id',array(' ','G','C','O','P','N')); 
$smarty->assign('vindole_de',array(' ','Sector Publico','Cooperativa','Comunal','Empresa Privada','Persona Natural'));
$smarty->assign('campo10','Logotipo:');
$smarty->assign('campo11','Numero Control de Planilla Blanca:');

if ($vopc==1) {
  $smarty->assign('varfocus','formarcas2.fecharec');
  //$smarty->assign('modo3','disabled'); 
}

if ($vopc==2) {
  $smarty->assign('varfocus','formarcas1.vsol1'); 
  $smarty->assign('modo',''); 
  $smarty->assign('prioridad',$prioridad); }

$smarty->assign('vopc',$vopc);
$smarty->assign('usuario',$usuario);
$smarty->assign('role',$role);
$smarty->assign('vsol1',$vsol1);
$smarty->assign('recibo',$recibo);
$smarty->assign('fecharec',$fecharec);
$smarty->assign('prioridad',$prioridad);
$smarty->assign('solicitant',$solicitant);
$smarty->assign('nameimage',$nameimage);
$smarty->assign('lced',$lced);
$smarty->assign('nced',$nced);
$smarty->assign('telefono',$telefono);
$smarty->assign('indole',$indole);

$smarty->display('m_bexfigu.tpl');
$smarty->display('pie_pag.tpl');
?>
