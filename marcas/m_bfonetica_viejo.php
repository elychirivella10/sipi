<?php
// *************************************************************************************
// Programa: m_bfonetica.php 
// Desarrollado por el Analista de Sistema Ing Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// I Semestre 2010 
// Modificado por la Analista de Sistema Ing Maryury Bonilla el 21/05/2010 
// para la Taquilla Unica. 
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

//Verificando conexion
$sql = new mod_db();
$sql->connection($usuario);

//Variables
$tbname_1 = "stmbusqueda";

$sede    = "2";
$fecha   = fechahoy();
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
$clase     = $_POST['options'];
$denominacion=$_POST['denominacion'];
$vsede     = trim($_POST['vsede']);

// Obtencion de las Sedes 
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

// Obtencion de las Clases Internacionales
$contobji=0;
$vcodclase[$contobji] = '';
$vnomclase[$contobji] = '';
$objquery = $sql->query("SELECT * FROM stmclinr ORDER BY clase_inter");
$objfilas = $sql->nums('',$objquery);
$objs = $sql->objects('',$objquery);
for ($contobji=1;$contobji<=$objfilas;$contobji++) {
   $vcodclase[$contobji] = $objs->clase_inter;
   $vnomclase[$contobji] = trim(sprintf("%02d",$objs->clase_inter)." ".trim($objs->productos));
   $objs = $sql->objects('',$objquery); }	  

// ****************************************
$smarty->assign('titulo',$substmar);
if (($vopc!=1) && ($vopc!=3) && ($vopc!=4)) {
  $smarty->assign('subtitulo','B&uacute;squeda Fonetica'); 
}
if ($vopc==1) {
  $smarty->assign('subtitulo','B&uacute;squeda Fonetica / Modificar'); 
}
if ($vopc==3) {
  $smarty->assign('subtitulo','B&uacute;squeda Fonetica / Ingreso'); 
}
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
if (empty($vopc) or ($vopc==1) or ($vopc==3)) {
  $smarty->display('encabezado1.tpl'); }

$smarty->assign('arraytipom',array('B'));
$smarty->assign('arraynotip',array('NORMAL'));

//Opcion Modificar
if ($vopc==1) {
  $smarty->assign('modo1','disabled'); 
  $smarty->assign('vmodo','disabled'); 
  $smarty->assign('modo',''); 
  $smarty->assign('modo2',''); 
  $smarty->assign('modo3',''); 
  $smarty->assign('submitbutton3','submit');
  $smarty->assign('submitbutton','button');
  $smarty->assign('subtitulo','B&uacute;squeda Fonetica / Modificar'); 
  $smarty->assign('accion',2);
  $vopc=1;

  //Validacion del Numero de Solicitud
  if (empty($vsol1)) {
     mensajenew('ERROR: No introdujo ningún valor de nro_pedido ...!!!','m_bfonetica.php?vopc=4','N');
     $smarty->display('pie_pag2.tpl'); exit(); }
  
  $resultado=pg_exec("SELECT * FROM $tbname_1 WHERE nro_pedido='$vsol1'");
  if (!$resultado) { 
    mensajenew('ERROR: No se pudo accesar la Base da Datos ...!!!','m_bfonetica.php?vopc=4&vauxnum=0','N');
    $smarty->display('pie_pag2.tpl'); $sql->disconnect(); exit(); }	 
  $filas_found=pg_numrows($resultado); 
  if ($filas_found==0) {
     mensajenew('AVISO: NO EXISTEN DATOS ASOCIADOS ...!!!','m_bfonetica.php?vopc=4&vauxnum=0','N');
     $smarty->display('pie_pag2.tpl'); $sql->disconnect(); exit(); }	 
  $reg = pg_fetch_array($resultado);

  $vsol1     = $reg[nro_pedido];
  $recibo    = $reg[nro_recibo];
  $fecharec  = $reg[f_pedido];
  $solicitant= trim($reg[solicitante]);
  $denominacion= trim($reg[denominacion]);
  $prioridad = $reg[prioridad];
  $fechaing  = $reg[fechaing];
  $horaing   = $reg[hora];
  $lced      = substr($reg[identificacion],0,1);
  $nced      = trim(substr($reg[identificacion],1,9));
  $cedrif    = $reg[identificacion];
  $indole    = $reg[indole];
  $telefono  = trim($reg[telefono]);
  $clase= trim($reg[clase]);
  
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
  $smarty->assign('subtitulo','B&uacute;squeda Fonetica');
  $smarty->display('encabezado1.tpl');

  //Validacion del Numero de Evento
  if ($accion==2) {
    if (empty($vsol1)) {
      mensajenew('No introdujo ningún valor de nro_pedido ...!!!','m_bfonetica.php?vopc=4','N');
      $smarty->display('pie_pag2.tpl'); exit(); }
  }

  $cedrif = $lced.$nced;
  //Verificacion de que los campos requeridos esten llenos...
  if (empty($fecharec) || empty($prioridad) || empty($recibo) || 
     empty($solicitant) || empty($vsol1) || empty($cedrif)) {
     mensajenew('Hay Informacion basica en el formulario que esta Vacia ...!!!','m_bfonetica.php','N');
     $smarty->display('pie_pag2.tpl'); exit(); }

  // Ingreso de Solicitud
  if ($accion==1) {
    //Variable para la busqueda de la imagen
    $insbusq  = true;
    $fechahoy = Hoy();
    $horactual= Hora();
    
    pg_exec("BEGIN WORK");
    $resultado=pg_exec("SELECT * FROM stmbusqueda WHERE nro_pedido='$vsol1'");
    $filas_found=pg_numrows($resultado); 
    if ($filas_found!=0) {
       mensajenew('Numero de nro_pedido YA existe en la Base de Datos ...!!!','m_bfonetica.php?vopc=3','N');
       $smarty->display('pie_pag2.tpl'); $sql->disconnect(); exit(); }
    $solicitant = str_replace("'","´",$solicitant);
    $col_campos = "nro_pedido,f_pedido,tipobusq,solicitante,denominacion,clase,nro_recibo,usuario,monto,f_transac,hora_c,pagina,sede,identificacion,indole,telefono";
    $insert_str = "'$vsol1','$fecharec','$prioridad','$solicitant','$denominacion','$clase','$recibo','$usuario',0,'$fechahoy','$horactual',70,'$sede','$cedrif','$indole','$telefono'"; 
    $insbusq = $sql->insert("$tbname_1","$col_campos","$insert_str","");

    if ($insbusq) {
      pg_exec("COMMIT WORK");
      //Desconexion de la Base de Datos
      $sql->disconnect();
      Mensajenew('DATOS GUARDADOS CORRECTAMENTE ...!!!','m_bfonetica.php?vopc=3','S');
      $smarty->display('pie_pag2.tpl'); exit();
    }
    else {
      pg_exec("ROLLBACK WORK");
      //Desconexion de la Base de Datos
      $sql->disconnect();
      Mensajenew("Falla de Actualizaci&oacute;n / Inserci&oacute;n de Datos en la BD ...!!!","javascript:history.back();","N");
      $smarty->display('pie_pag2.tpl'); exit();
    }

  } //Incluir
  // Modificar Solicitud
  else {
    $actbusq  = true;
    //La Fecha de Hoy y Hora para la transaccion
    $fechahoy = Hoy();
    $horactual= Hora();
    // Actualizo en Maestra de Eventos
    pg_exec("BEGIN WORK");
    pg_exec("LOCK TABLE stmcntrl IN SHARE ROW EXCLUSIVE MODE");
    $update_str = "nro_recibo='$recibo',f_pedido='$fecharec',tipobusq='$prioridad',solicitante='$solicitant',denominacion='$denominacion',identificacion='$cedrif',indole='$indole',telefono='$telefono',clase='$clase'";
    //echo $update_str;
    $actbusq = $sql->update("$tbname_1","$update_str","nro_pedido='$vsol1'");

    if ($actbusq) {
      pg_exec("COMMIT WORK");
      //Desconexion de la Base de Datos
      $sql->disconnect();
   
      Mensajenew('DATOS GUARDADOS CORRECTAMENTE ...!!!','m_bfonetica.php?vopc=4','S');
      $smarty->display('pie_pag2.tpl'); exit();
    }
    else {
      pg_exec("ROLLBACK WORK");
      //Desconexion de la Base de Datos
      $sql->disconnect();

      Mensajenew("Falla de Actualizaci&oacute;n / Inserci&oacute;n de Datos en la BD ...!!!","javascript:history.back();","N");
      $smarty->display('pie_pag2.tpl'); exit();
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
  //$tnumera='fonetica';
  //Se obtiene el proximo valor segun stzsystem
  //$sys_actual = next_sys("$tnumera");
  //$vauxnum = grabar_sys("$tnumera",$sys_actual);
  $obj_query = $sql->query("update stzsystem set fonetica=nextval('stzsystem_fonetica_seq')");
  $obj_query = $sql->query("select last_value from stzsystem_fonetica_seq");
  $objs = $sql->objects('',$obj_query);
  $sys_actual = $objs->last_value;
  $vauxnum = $sys_actual;
  
  $smarty->assign('subtitulo','B&uacute;squeda Fonetica / Ingreso'); 
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
  $vsede   = "2";
  $smarty->assign('options',$vsede);

  $vsol1 = $vauxnum;
}

if ($vopc==3) {
  $smarty->assign('subtitulo','B&uacute;squeda Fonetica / Ingreso'); 
  //$smarty->display('encabezado1.tpl');
  $smarty->assign('vmodo','disabled'); 
  $smarty->assign('modo','disabled'); 
  $smarty->assign('modo2','disabled'); 
}

if ($vopc==4) {
  $smarty->assign('subtitulo','B&uacute;squeda Fonetica / Modificar'); 
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
$smarty->assign('campo1','nro_pedido No.:');
$smarty->assign('campo2','Factura Fecha:');
$smarty->assign('campo3','Tipo de B&uacute;squeda:');
$smarty->assign('campo4','Factura N&uacute;mero:');
$smarty->assign('campo5','Solicitante:');
$smarty->assign('campo6','Indole:');
$smarty->assign('campo7','C&eacute;dula/Rif.:');
$smarty->assign('campo8','Nomenclatura:');
$smarty->assign('campo9','Tel&eacute;fono:');
$smarty->assign('campo10','Clase:');
$smarty->assign('campo11','Denominaci&oacute;n:');
$smarty->assign('campo12','Sede:');
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
$smarty->assign('vcodclase',$vcodclase);
$smarty->assign('vnomclase',$vnomclase);
$smarty->assign('denominacion',$denominacion);
$smarty->assign('clase',$clase);
$smarty->assign('vcodsede',$vcodsede);
$smarty->assign('vnomsede',$vnomsede); 
$smarty->assign('options',$vsede);


$smarty->display('m_bfonetica.tpl');
$smarty->display('pie_pag3.tpl');
?>
