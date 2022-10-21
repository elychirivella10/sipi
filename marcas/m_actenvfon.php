<script language="Javascript"> 

  function valenvio(formulario) {
   enviar = formulario.vplus.value;
   if (enviar=='N') {
     formulario.email.value='';
   }
   return
  }

  function isEmail2(who,formulario) {
    var emailpat=/^[A-Za-z0-9][\w-.]+@[A-Za-z0-9]([\w-.]+[A-Za-z0-9]\.)+([A-Za-z]){2,4}$/i;
    if (!emailpat.test(who)) { alert('¡ Cuenta Email o Correo no Válido ...!!!'); formulario.email.focus(); return false }
    return
  }

</script>

<?php
// *************************************************************************************
// Programa: m_actenvfon.php 
// Desarrollado por el Analista de Sistema Ing Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Desarrollado I Semestre 2015 
// ************************************************************************************
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");
?>

<script language="Javascript"> 
function pregunta() { 
  return confirm('Estas seguro de actualizar la Informacion ?'); }
</script> 

<?php
if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }
//Variables
$login   = $_SESSION['usuario_login'];
$usrsede = $_SESSION['usuario_sede'];

//Verificando conexion
$sql = new mod_db();
$sql->connection($login);

//Variables
$tbname_1 = "stmbusqueda";

$fecha   = fechahoy();
$vopc    = $_GET['vopc'];
$vauxnum = $_GET['vauxnum'];
$vsol1   = $_POST['vsol1'];
$recibo  = $_POST['recibo'];
$accion  = $_POST['accion'];
$auxnum  = $_POST['auxnum'];
$clase   = $_POST['options'];
$envio   = trim($_POST['vplus']);
$email   = trim($_POST['email']);
$vfiltro = trim($_POST['vfiltro']);

// ****************************************
$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','B&uacute;squeda Fonetica / Actualizaci&oacute;n de Estatus para Proceso de Re-Env&iacute;o de Resultados'); 
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl'); 

//Opcion Modificar
if ($vopc==1) {
  $smarty->assign('vmodo','disabled'); 
  $smarty->assign('modo','disabled'); 
  $smarty->assign('modo1',''); 
  $smarty->assign('modo2','disabled'); 
  $smarty->assign('modo3','disabled'); 
  $smarty->assign('modo4',''); 
  $smarty->assign('accion',2);
  if ($vopc==1) { $vopc=1; }

  //Validacion del Numero de Recibo y/o Pedido
  if (empty($vsol1) && empty($recibo)) {
     mensajenew('ERROR: No introdujo ningún valor de No Factura o Pedido ...!!!','m_actenvfon.php?vopc=4','N');
     $smarty->display('pie_pag3.tpl'); exit(); }

  //Validacion del Numero de Recibo
  if (!empty($recibo)) {
  	 $vfiltro = "1"; 
    $resultado=pg_exec("SELECT * FROM $tbname_1 WHERE nro_recibo='$recibo'");
    if (!$resultado) { 
      mensajenew('ERROR: No se pudo accesar la Base da Datos ...!!!','m_actenvfon.php?vopc=4&vauxnum=0','N');
      $smarty->display('pie_pag3.tpl'); $sql->disconnect(); exit(); }	 
    $filas_found=pg_numrows($resultado); 
    if ($filas_found==0) {
      mensajenew('AVISO: NO EXISTEN DATOS ASOCIADOS ...!!!','m_actenvfon.php?vopc=4&vauxnum=0','N');
      echo "<br><br><br><br><br><br><br><br><br><br><br><br><br>";
      $smarty->display('pie_pag3.tpl'); $sql->disconnect(); exit();
    }  
  }

  //Validacion del Numero de Pedido
  if (!empty($vsol1)) {
  	 $vfiltro = "2";
    $resultado=pg_exec("SELECT * FROM $tbname_1 WHERE nro_pedido='$vsol1'");
    if (!$resultado) { 
      mensajenew('ERROR: No se pudo accesar la Base da Datos ...!!!','m_actenvfon.php?vopc=4&vauxnum=0','N');
      $smarty->display('pie_pag3.tpl'); $sql->disconnect(); exit(); }	 
    $filas_found=pg_numrows($resultado); 
    if ($filas_found==0) {
      mensajenew('AVISO: NO EXISTEN DATOS ASOCIADOS ...!!!','m_actenvfon.php?vopc=4&vauxnum=0','N');
      echo "<br><br><br><br><br><br><br><br><br><br><br><br><br>";
      $smarty->display('pie_pag3.tpl'); $sql->disconnect(); exit(); 
    }
  }    	 

  $reg = pg_fetch_array($resultado);
  $vsol1     = $reg[nro_pedido];
  $recibo    = $reg[nro_recibo];
  if($vfiltro=="1") { $vsol1=""; }     
  $email     = trim($reg[email]);
  $envio     = $reg[envio];
}

//Opcion Grabar...
if ($vopc==2) {
  $smarty->assign('varfocus','formarcas1.recibo'); 
  $smarty->assign('modo',''); 

  // Modificar Solicitud
  $actbusq  = true;

  //La Fecha de Hoy y Hora para la transaccion
  $fechahoy = Hoy();
  $horactual= Hora();

  $envio = trim($_POST['vplus']);
  if($envio=='V') { 
    mensajenew('ERROR: Debe seleccionar si desea enviar por Correo los Resultados ...!!!','javascript:history.back();','N');
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  }
  if($envio=='N') { $email = ''; }
  if($envio=='S') {
  	if (empty($email)) { 
      mensajenew('ERROR: Falto escribir el Correo para enviar los Resultados ...!!!','javascript:history.back();','N');
      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();
    }   
  }

  // Actualizo en Maestra de Eventos
    pg_exec("BEGIN WORK");
    pg_exec("LOCK TABLE stmbusqueda IN SHARE ROW EXCLUSIVE MODE");
    $update_str = "envio='$envio',email='$email',estatus_envio='N'"; 
    
    if($vfiltro=="1") {    
      $actbusq = $sql->update("$tbname_1","$update_str","nro_recibo='$recibo'"); }
    else {   
      $actbusq = $sql->update("$tbname_1","$update_str","nro_pedido='$vsol1'"); }

    if ($actbusq) {
      pg_exec("COMMIT WORK");
      //Desconexion de la Base de Datos
      $sql->disconnect();
   
      Mensajenew('DATOS GUARDADOS CORRECTAMENTE ...!!!','m_actenvfon.php?vopc=4','S');
      $smarty->display('pie_pag3.tpl'); exit();
    }
    else {
      pg_exec("ROLLBACK WORK");
      //Desconexion de la Base de Datos
      $sql->disconnect();

      Mensajenew("Falla de Actualizaci&oacute;n / Inserci&oacute;n de Datos en la BD ...!!!","javascript:history.back();","N");
      $smarty->display('pie_pag3.tpl'); exit();
    }
}

if (($vopc!=1) && ($vopc!=2) && ($vopc!=4)) {
  $smarty->assign('modo1',''); 
  $smarty->assign('modo2','disabled'); 
  $smarty->assign('modo3','disabled'); 
  $smarty->assign('vmodo','readonly=readonly'); 
  $smarty->assign('modo','readonly=readonly'); 
}

if ($vopc==4) {
  $smarty->assign('varfocus','formarcas1.recibo'); 
  $smarty->assign('modo1','disabled'); 
  $smarty->assign('modo2','disabled'); 
  $smarty->assign('modo3','disabled'); 
  $smarty->assign('modo4','disabled'); 
  $smarty->assign('vmodo',''); 
  $smarty->assign('modo','readonly=readonly'); 
  $smarty->assign('accion',2);
  $smarty->assign('vopc',$vopc);
}

//Pase de variables y Etiquetas al template
$smarty->assign('campo1','Factura No.:');
$smarty->assign('campo2','Pedido No.:');
$smarty->assign('campo3','Enviar por Correo:');
$smarty->assign('campo4','Correo:');
$smarty->assign('arrayplus',array('V','N','S'));
$smarty->assign('arraydesplus',array('','NO','SI'));

$smarty->assign('vopc',$vopc);
$smarty->assign('login',$login);
$smarty->assign('usuario',$usuario);
$smarty->assign('vsol1',$vsol1);
$smarty->assign('recibo',$recibo);
$smarty->assign('email',$email);
$smarty->assign('vplus',$envio);
$smarty->assign('vfiltro',$vfiltro);

$smarty->display('m_actenvfon.tpl');
$smarty->display('pie_pag3.tpl');
?>
