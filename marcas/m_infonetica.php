<?php
// *************************************************************************************
// Programa: m_infonetica.php 
// Desarrollado por el Analista de Sistema Ing Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// II Semestre 2011 
// ************************************************************************************
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");
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
$usrsede = $_SESSION['usuario_sede'];

//Verificando conexion
$sql = new mod_db();
$sql->connection($usuario);

//Variables
$tbname_1 = "stmbusfac";
$tbname_2 = "stmaudbus";
$tbname_3 = "stmbusplan";
$tbname_4 = "stmbusqueda";

$fecha   = fechahoy();
$vopc    = $_GET['vopc'];
$recibo  = trim($_POST['recibo']);
$fecharec= $_POST['fecharec'];
$prioridad = $_POST['prioridad'];
$solicitant= trim($_POST['solicitant']);
$indole    = $_POST['indole'];
$busqueda  = $_POST['busqueda'];
$cantidad  = $_POST['cantidad'];
$accion    = $_POST['accion'];
$clase     = $_POST['options'];
$lced      = $_POST['lced'];
$nced      = trim($_POST['nced']);
$telefono  = trim($_POST['telefono']);

// ****************************************
$smarty->assign('titulo',$substmar);
if (($vopc!=1) && ($vopc!=3) && ($vopc!=4)) {
  $smarty->assign('subtitulo','B&uacute;squedas / Control de Facturas'); 
}
if ($vopc==1) {
  $smarty->assign('subtitulo','B&uacute;squedas Control de Facturas - Modificar/Eliminar'); 
}
if ($vopc==3) {
  $smarty->assign('subtitulo','B&uacute;squedas Control de Facturas / Ingreso'); 
}
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
if (empty($vopc) or ($vopc==1) or ($vopc==3) or ($vopc==7)) {
  $smarty->display('encabezado1.tpl'); }

$smarty->assign('arraytipom',array('B','A'));
$smarty->assign('arraynotip',array('NORMAL','HABILITADA'));

$smarty->assign('arraybusqt',array('F','G','P'));
$smarty->assign('arraynobus',array('FONETICA','GRAFICA','PETICIONARIO'));

//Opcion Modificar
if (($vopc==1) || ($vopc==7)) {
  $smarty->assign('subtitulo','B&uacute;squedas Control de Facturas / Modificar'); 
  $smarty->assign('modo','readonly=readonly'); 
  $smarty->assign('accion',2);
  if ($vopc==1) { $vopc=1; }
 
  //Validacion del Numero de Recibo
  if (empty($recibo)) {
     mensajenew('ERROR: No introdujo ningún Numero de Factura ...!!!','m_infonetica.php?vopc=4','N');
     $smarty->display('pie_pag2.tpl'); exit(); }
  
  $resultado=pg_exec("SELECT * FROM $tbname_1 WHERE nro_recibo='$recibo'");
  if (!$resultado) { 
    mensajenew('ERROR: No se pudo accesar la Base da Datos ...!!!','m_infonetica.php?vopc=4','N');
    $smarty->display('pie_pag2.tpl'); $sql->disconnect(); exit(); }	 
  $filas_found=pg_numrows($resultado); 
  if ($filas_found==0) {
     mensajenew('AVISO: NO EXISTEN DATOS ASOCIADOS ...!!!','m_infonetica.php?vopc=4','N');
     $smarty->display('pie_pag2.tpl'); $sql->disconnect(); exit(); }	 
  $reg = pg_fetch_array($resultado);

  $recibo    = trim($reg[nro_recibo]);
  $fecharec  = $reg[f_recibo];
  $solicitant= trim($reg[solicitante]);
  $prioridad = $reg[prioridad];
  $fechaing  = $reg[f_carga];
  $horaing   = $reg[hora_c];
  $indole    = $reg[indole];
  $busqueda  = $reg[busqueda];
  $cantidad  = $reg[cantidad]; 
  $lced      = substr($reg[identificacion],0,1);
  $nced      = trim(substr($reg[identificacion],1,9));
  $cedrif    = $reg[identificacion];
  $telefono  = trim($reg[telefono]);

  $objquery = $sql->query("SELECT * FROM $tbname_4 WHERE nro_recibo='$recibo'");
  $objfilas = $sql->nums('',$objquery);
  if ($objfilas!=0) {
     mensajenew('AVISO: Datos de la Factura NO pueden ser Modificados, B&uacute;squedas ya Cargadas y/o Procesadas ...!!!','m_infonetica.php?vopc=4','N');
     $smarty->display('pie_pag2.tpl'); $sql->disconnect(); exit(); }	 

  //Almaceno en un string los valores de los campos antes de modificar alguno
  $valores_fields = array($recibo,$fecharec,$solicitant,$prioridad,$f_carga,$hora_c); 
  $campos = "recibo|fecharec|solicitant|prioridad|fechaing|hora";
  $vstring = bitacora_fields();
  
  //$smarty->assign('recibo',$recibo); 
  //$smarty->assign('fecharec',$fecharec);
  $smarty->assign('vstring',$vstring);
  $smarty->assign('campos',$campos);
  //$smarty->assign('prioridad',$prioridad);
  $smarty->assign('varfocus','formarcas2.recibo');
}

if ($vopc==1) {
  $smarty->assign('varfocus','formarcas2.recibo');
}

//Opcion Grabar...
if ($vopc==2) {
  $smarty->assign('subtitulo','B&uacute;squedas / Control de Facturas');
  $smarty->display('encabezado1.tpl');
  $smarty->assign('varfocus','formarcas1.recibo'); 
  $smarty->assign('prioridad',$prioridad);

  if ($accion==2) {
    if (empty($recibo)) {
      mensajenew('ERROR: No introdujo ningún Numero de Factura ...!!!','m_infonetica.php?vopc=4','N');
      $smarty->display('pie_pag2.tpl'); exit(); }
  }

  $indole = trim($indole);
  if (empty($indole)) {
    if ($accion==2) {
      mensajenew('ERROR: No selecciono la indole del Solicitante ...!!!','m_infonetica.php?vopc=4','N'); }
    else {
      mensajenew('ERROR: No selecciono la indole del Solicitante ...!!!','m_infonetica.php?vopc=3','N'); }
    $smarty->display('pie_pag2.tpl'); exit();
  } 

  $cantidad = trim($cantidad);
  if (empty($cantidad)) { $cantidad=0; } 
  if ($cantidad==0) {
    if ($accion==2) {
      mensajenew('ERROR: No selecciono la Cantidad de Busqueda a Realizar ...!!!','m_infonetica.php?vopc=4','N'); }
    else {
      mensajenew('ERROR: No selecciono la Cantidad de Busqueda a Realizar ...!!!','m_infonetica.php?vopc=3','N'); }
    $smarty->display('pie_pag2.tpl'); exit();
  } 

  $cedrif = $lced.$nced;
  //Verificacion de que los campos requeridos esten llenos...
  if (empty($fecharec) || empty($prioridad) || empty($recibo) || empty($solicitant) || empty($cedrif) || empty($telefono)) { 
     mensajenew('AVISO: Hay Informacion basica en el formulario que esta Vacia ...!!!','m_infonetica.php?vopc=3','N');
     $smarty->display('pie_pag2.tpl'); exit(); }

  // Ingreso de Solicitud
  if ($accion==1) {
    //Variable para la busqueda de la imagen
    $insbusq  = true;
    $fechahoy = Hoy();
    $horactual= Hora();

    $cedrif = $lced.$nced;
    pg_exec("BEGIN WORK");
    $resultado=pg_exec("SELECT * FROM stmbusfac WHERE nro_recibo='$recibo'");
    $filas_found=pg_numrows($resultado); 
    if ($filas_found!=0) {
       mensajenew('ERROR: Numero de Factura YA existe en la Base de Datos ...!!!','m_infonetica.php?vopc=3','N');
       $smarty->display('pie_pag2.tpl'); $sql->disconnect(); exit(); }
    $solicitant = str_replace("'","´",$solicitant);
    $col_campos = "f_recibo,nro_recibo,prioridad,busqueda,cantidad,solicitante,usuario,f_carga,hora_c,sede,indole,identificacion,telefono";
    $insert_str = "'$fecharec','$recibo','$prioridad','$busqueda',$cantidad,'$solicitant','$usuario','$fechahoy','$horactual','$usrsede','$indole','$cedrif','$telefono'";  
    $insbusq = $sql->insert("$tbname_1","$col_campos","$insert_str","");

    if ($insbusq) {
      pg_exec("COMMIT WORK");
      //Desconexion de la Base de Datos
      $sql->disconnect();
      Mensajenew('DATOS GUARDADOS CORRECTAMENTE ...!!!','m_infonetica.php?vopc=3','S');
      $smarty->display('pie_pag2.tpl'); exit();
    }
    else {
      pg_exec("ROLLBACK WORK");
      //Desconexion de la Base de Datos
      $sql->disconnect();
      Mensajenew("Falla de Actualizaci&oacute;n / Inserci&oacute;n de Datos en la BD ...!!!","m_infonetica.php?vopc=3","N");
      $smarty->display('pie_pag2.tpl'); exit();
    }

  } //Incluir
  // Modificar Solicitud
  else {
    $recibo = $_POST['recibo']; 
    $actbusq  = true;
    //La Fecha de Hoy y Hora para la transaccion
    $fechahoy = Hoy();
    $horactual= Hora();

    $resultado=pg_exec("SELECT * FROM $tbname_1 WHERE nro_recibo='$recibo'");
    $reg_ant = pg_fetch_array($resultado);
    $vrecibo    = trim($reg_ant[nro_recibo]);
    $vfecharec  = $reg_ant[f_recibo];
    $vprioridad = $reg_ant[prioridad];
    $vbusqueda  = $reg_ant[busqueda];
    $vcantidad  = $reg_ant[cantidad]; 
    $vsolicitant= trim($reg_ant[solicitante]);
    $vindole    = $reg_ant[indole];
    $vusuario   = $reg_ant[usuario];
    $vfechaing  = $reg_ant[f_carga];
    $vhoraing   = $reg_ant[hora_c];
    $vsede      = $reg_ant[sede];

    pg_exec("BEGIN WORK");
    $col_campos = "auditor,f_recibo,nro_recibo,prioridad,busqueda,cantidad,solicitante,indole,usuario,f_carga,hora_c,sede,operacion,responsable,fecha_oper,hora_oper"; 
    $insert_str = "nextval('stmaudbus_auditor_seq'),'$vfecharec','$vrecibo','$vprioridad','$vbusqueda',$vcantidad,'$vsolicitant','$vindole','$vusuario','$vfechaing','$vhoraing','$vsede','M','$usuario','$fechahoy','$horactual'";  
    $insaudi = $sql->insert("$tbname_2","$col_campos","$insert_str","");

    // Actualizo en Maestra de Facturas  
    pg_exec("LOCK TABLE stmbusfac IN SHARE ROW EXCLUSIVE MODE");
    $update_str = "f_recibo='$fecharec',prioridad='$prioridad',solicitante='$solicitant',busqueda='$busqueda',cantidad=$cantidad,indole='$indole',identificacion='$cedrif',telefono='$telefono'";
    $actbusq = $sql->update("$tbname_1","$update_str","nro_recibo='$recibo'");

    if ($actbusq) {
      pg_exec("COMMIT WORK");
      //Desconexion de la Base de Datos
      $sql->disconnect();
   
      Mensajenew('DATOS MODIFICADOS CORRECTAMENTE CON REGISTRO DE AUDITORIA ...!!!','m_infonetica.php?vopc=4','S');
      $smarty->display('pie_pag2.tpl'); exit();
    }
    else {
      pg_exec("ROLLBACK WORK");
      //Desconexion de la Base de Datos
      $sql->disconnect();

      Mensajenew("Falla de Actualizaci&oacute;n / Actualizar Inserci&oacute;n de Datos en la BD ...!!!","m_infonetica.php?vopc=4","N");
      $smarty->display('pie_pag2.tpl'); exit();
    }
  } // Modificar

}

//Opcion Eliminar ...
if ($vopc==5) {
  $smarty->assign('subtitulo','B&uacute;squedas Control de Facturas / Eliminar ');
  $smarty->display('encabezado1.tpl');
  $smarty->assign('varfocus','formarcas1.recibo'); 

  $fechahoy = Hoy();
  $horactual= Hora();

  //Pase de variable 
  $recibo = $_GET['recibo']; 

  //Busqueda de datos a registrar en auditoria  
  $obj_query = $sql->query("SELECT * FROM $tbname_1 WHERE nro_recibo='$recibo'");
  $objs = $sql->objects('',$obj_query);
  $vrecibo    = trim($objs->nro_recibo);
  $vfecharec  = $objs->f_recibo;
  $vprioridad = $objs->prioridad;
  $vbusqueda  = $objs->busqueda;
  $vcantidad  = $objs->cantidad; 
  $vsolicitant= trim($objs->solicitante);
  $vindole    = $objs->indole;
  $vusuario   = $objs->usuario;
  $vfechaing  = $objs->f_carga;
  $vhoraing   = $objs->hora_c;
  $vsede      = $objs->sede;

  pg_exec("BEGIN WORK");

  //Registro en tabla de auditoria 
  $col_campos = "auditor,f_recibo,nro_recibo,prioridad,busqueda,cantidad,solicitante,indole,usuario,f_carga,hora_c,sede,operacion,responsable,fecha_oper,hora_oper"; 
  $insert_str = "nextval('stmaudbus_auditor_seq'),'$vfecharec','$vrecibo','$vprioridad','$vbusqueda',$vcantidad,'$vsolicitant','$vindole','$vusuario','$vfechaing','$vhoraing','$vsede','E','$usuario','$fechahoy','$horactual'";  
  $insaudi = $sql->insert("$tbname_2","$col_campos","$insert_str","");

  //Borrado de Datos   
  $del_datos = true;
  $del_datos = $sql->del("$tbname_1","nro_recibo='$recibo'");
  if ($del_datos) {
    pg_exec("COMMIT WORK");
    //Desconexion de la Base de Datos
    $sql->disconnect();
 
    Mensajenew('DATOS ELIMINADOS CORRECTAMENTE CON REGISTRO DE AUDITORIA ...!!!','m_infonetica.php?vopc=4','S');
    $smarty->display('pie_pag2.tpl'); exit();
  }
  else {
    pg_exec("ROLLBACK WORK");
    //Desconexion de la Base de Datos
    $sql->disconnect();
    Mensajenew("Falla de Eliminaci&oacute;n en la BD ...!!!","m_infonetica.php?vopc=4","N");
    $smarty->display('pie_pag2.tpl'); exit();
  }
}

if (($vopc!=1) && ($vopc!=2) && ($vopc!=3) && ($vopc!=4)) {
  $smarty->assign('modo1',''); 
  $smarty->assign('modo','readonly=readonly'); 
}

if ($vopc==3) {
  $smarty->assign('subtitulo','B&uacute;squedas / Ingreso Control de Facturas'); 
  //La Fecha de Hoy para la solicitud
  $fecharec = hoy();
  $smarty->assign('fecharec',$fecharec);
  $smarty->assign('varfocus','formarcas2.recibo');
  $smarty->assign('accion',1);
}

if ($vopc==4) {
  $smarty->assign('subtitulo','B&uacute;squedas Control de Factura - Modificar/Eliminar'); 
  $smarty->display('encabezado1.tpl');
  $smarty->assign('varfocus','formarcas1.recibo'); 
  $smarty->assign('modo',''); 
  $smarty->assign('modo1','disabled'); 
  $smarty->assign('modo2','disabled'); 
  $smarty->assign('accion',2);
  $smarty->assign('vopc',$vopc);
}

//Pase de variables y Etiquetas al template
$smarty->assign('campo2','Factura Fecha:');
$smarty->assign('campo3','Prioridad:');
$smarty->assign('campo4','Factura N&uacute;mero:');
$smarty->assign('campo5','Tipo de B&uacute;squeda:');
$smarty->assign('campo6','Cantidad:');
$smarty->assign('campo7','Solicitante:');
$smarty->assign('campo8','Indole:');
$smarty->assign('campo9','Sede:');
$smarty->assign('campo10','C&eacute;dula/Rif.:');
$smarty->assign('campo11','Nomenclatura:');
$smarty->assign('campo12','Tel&eacute;fono:');

$smarty->assign('lced_id',array(' ','V','E','P','J','G')); 
$smarty->assign('lced_de',array(' ','V','E','P','J','G'));
$smarty->assign('vindole_id',array(' ','G','C','O','P','N')); 
$smarty->assign('vindole_de',array(' ','Sector Publico','Cooperativa','Comunal','Empresa Privada','Persona Natural'));

$smarty->assign('vopc',$vopc);
$smarty->assign('usuario',$usuario);
$smarty->assign('recibo',$recibo);
$smarty->assign('fecharec',$fecharec);
$smarty->assign('prioridad',$prioridad);
$smarty->assign('solicitant',$solicitant);
$smarty->assign('indole',$indole);
$smarty->assign('busqueda',$busqueda);
$smarty->assign('cantidad',$cantidad);
$smarty->assign('lced',$lced);
$smarty->assign('nced',$nced);
$smarty->assign('telefono',$telefono);

$smarty->display('m_infonetica.tpl');
$smarty->display('pie_pag3.tpl');
?>
