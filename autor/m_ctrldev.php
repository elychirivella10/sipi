<script language="Javascript"> 

function pregunta() { 
  return confirm('Estas seguro de grabar la Informacion ?'); }

 function habilagen(vcampo,vtipo)
 {
   if (vtipo.value == "A") {
     alert('Debe estar registrado como Agente y poseer numero asignado ...!!!');
     vcampo.disabled = false;
     vcampo.focus() }
   else { vcampo.value=0; vcampo.disabled = true
          }
   if (vtipo.value == "P") {
     alert('Debe presentar Documento Poder en el SAPI para poder tramitar Solicitud(es) de Marca(s) ...!!!');
   }
 }

function cntrlcertificado(var1,var2,var3,var4) {
  open("adm_ctrlcerti.php?vreg="+var1.value+var2.value+"&vmod="+var3.value+"&vcod="+var4.value,"Ventana", "scrollbars=yes,toolbar=no,directories=no,menubar=no,status=no"); }

</script>
<?php
// *************************************************************************************
// Programa: m_controlcert.php 
// Realizado por el Analista de Sistema Romulo Mendoza
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Año 2011 II Semestre
// *************************************************************************************


//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

//Clase que sube el archivo
include ("$include_lib/upload_class.php");

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado"; exit();}

//Variables
$usuario   = $_SESSION['usuario_login'];
$fecha     = fechahoy();
$fechahoy  = hoy();
$sql = new mod_db();
$tbname_1  = "stmmarce";
$tbname_2  = "stzevder";
$tbname_3  = "stzstder";
$tbname_4  = "stzevtrd";
$tbname_5  = "stzmigrr";
$tbname_6  = "stzsystem";
$tbname_7  = "stzderec";
$tbname_8  = "stmcertif";
$tbname_9  = "stmregcer";

$vopc      = $_GET['vopc'];
$tipo      = $_POST['tipo'];
$fechaper  = $_POST['fechaper'];

//$vsola=$vsol1."-".sprintf("%06d",$vsol2);
//$vsolb=$vsol3."-".sprintf("%06d",$vsol4);
$resultado=false;
$subtitulo = "Control de Certificados de Registros de Marcas";

$smarty->assign('titulo',$substmar);
//$smarty->assign('subtitulo','Control de Certificados de Registros de Marcas');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado2.tpl'); 
$smarty->assign('varfocus','formarcas1.vsol1'); 
$smarty->assign('modo2','readonly');

echo "<table border='0' cellpadding='0' cellspacing='0' class='titulo_marca'>";
echo " <td>";
echo "   <i><b><font>$subtitulo</font></b></i>";
echo " </td>";
echo "</table>"; 

//Incremento de Control de estadisticas
$modulo= "mod_ctrlcer";
$sys_actual = control_auditor($usuario,$fechahoy,$modulo);

//Verificando conexion
$sql->connection1();

//Carga el tipo de marca para mostrarlo en el combo
$blanco='';
$arraytipo[0]='';
$arraytipo[1]='FIRMAR';
$arraytipo[2]='CORREGIR';

if ($vopc==3) {
  $smarty->assign('modo','disabled'); 
  $smarty->assign('modo1','disabled'); 
  $smarty->assign('modo2','disabled'); 
  $smarty->assign('vmodo','readonly=readonly'); 
}   

if ($vopc==5) {
  //Se obtiene el proximo valor para el secuencial a guardara partir de stzsistem
  $obj_query = $sql->query1("update stzsystem set controlcert=nextval('stzsystem_controlcert_seq')");
  if ($obj_query) {
    $obj_query = $sql->query1("select last_value from stzsystem_controlcert_seq");
    $objs = $sql->objects1('',$obj_query);
    $vsecuencial = $objs->last_value; }

  $nctrlcer=$vsecuencial;
  $smarty->assign('nctrlcer',$nctrlcer); 
}   
   
if ($vopc==2) {
  //Validacion de los campos
  if (empty($tipo) ) {
    mensajenew('ERROR: No introdujo la acci&oacute;n a Realizar ...!!!','javascript:history.back();','N');
    $smarty->display('pie_pag.tpl'); exit(); }
  if ($tipo == "FIRMAR") { $accion= "F"; } else { $accion= "C"; }    
    
  if (empty($fechaper) ) {
    mensajenew('ERROR: No introdujo la Fecha de la Solicitud ...!!!','javascript:history.back();','N');
    $smarty->display('pie_pag.tpl'); exit(); }
      
  $fec_hoy = hoy();
  $rev_fecha = Convertir_en_fecha($fechaper,0);
  $esmayor=compara_fechas($rev_fecha,$fec_hoy);
  if ($esmayor==1) {
    $smarty->display('encabezado2.tpl');
    mensajenew('ERROR: NO se pueden ejecutar eventos(fechas) a Futuros ...!!!','javascript:history.back();','N');
    $smarty->display('pie_pag.tpl'); exit();  } 

  $solicitante = $_POST['solicitante'];
  $cisolicita = $_POST['cisolicita'];
  $telefono = $_POST['telefono'];
  $correo = $_POST['correo'];
  $indaut = $_POST['indaut'];

  if (empty($solicitante) ) {
    mensajenew('ERROR: No introdujo el Nombre del Solicitante ...!!!','javascript:history.back();','N');
    $smarty->display('pie_pag.tpl'); exit(); }

  if (empty($cisolicita) ) {
    mensajenew('ERROR: No introdujo la Cedula del Solicitante ...!!!','javascript:history.back();','N');
    $smarty->display('pie_pag.tpl'); exit(); }
    
  if (empty($telefono) ) {
    mensajenew('ERROR: No introdujo el Telefono del Solicitante ...!!!','javascript:history.back();','N');
    $smarty->display('pie_pag.tpl'); exit(); }

  //if (empty($correo) ) {
  //  mensajenew('ERROR: No introdujo el Correo del Solicitante ...!!!','javascript:history.back();','N');
  //  $smarty->display('pie_pag.tpl'); exit(); }

  if ($indaut=="S") {
    $autorizado = $_POST['autorizado'];
    $ciautorizado = $_POST['ciautorizado'];
    
    if (empty($autorizado) ) {
      mensajenew('ERROR: No introdujo el Nombre del Autorizado ...!!!','javascript:history.back();','N');
      $smarty->display('pie_pag.tpl'); exit(); }

    if (empty($ciautorizado) ) {
      mensajenew('ERROR: No introdujo la cedula del Autorizado ...!!!','javascript:history.back();','N');
      $smarty->display('pie_pag.tpl'); exit(); }
  }
  
  $vges1="";
  $vges2="";
  $vges3="";
  $vges4="";
  $vagente = 0;
  
  $vgestor_pn = $_POST['gestor_pn'];
  $vgestor_pj = $_POST['gestor_pj'];
  $vgestor_ap = $_POST['gestor_ap'];
  $vgestor_ag = $_POST['gestor_ag'];
    
  $vges1=""; $vges2=""; $vges3=""; $vges4="";
  if ($vgestor_pn == "on") { $vges1= "X"; }   
  if ($vgestor_pj == "on") { $vges2= "X"; }
  if ($vgestor_ap == "on") { $vges3= "X"; }
  if ($vgestor_ag == "on") { 
    $vges4= "X"; $vagente = $_POST['agente'];
    if ($vagente==0) {
      mensajenew('ERROR: No introdujo el C&oacute;digo de Agente de la Propiedad Industrial ...!!!','javascript:history.back();','N');
      $smarty->display('pie_pag.tpl'); exit(); }
  }

  if (($vges1=="") AND ($vges2=="") AND ($vges3=="") AND ($vges4=="")) {
    mensajenew('ERROR: No introdujo bajo que Condici&oacute;n actua ...!!!','javascript:history.back();','N');
    $smarty->display('pie_pag.tpl'); exit();
  }   
     
  $instram  = true;
  $actestat = true;
  $vcod=$_POST['nctrlcer'];

  $resultado=pg_exec("SELECT * FROM stmtmpcer WHERE control = '$vcod'");
  $filas_found=pg_numrows($resultado);    

  if ($filas_found == 0) {
    mensajenew('ERROR: No introdujo Expedientes Registrados en estatus 555 ...!!!','javascript:history.back();','N');
    $smarty->display('pie_pag.tpl'); exit(); }

    $insert_str = "$vcod,'$accion','$fechaper','$solicitante','$cisolicita','$telefono','$correo','$vges1','$vges2','$vges3','$vges4','$indaut','$autorizado','$ciautorizado','$vagente',$filas_found,'1'";  
    $instcer = $sql->insert1("$tbname_8","","$insert_str",""); 
    //if (!$instcer) {  
    //  pg_exec("ROLLBACK WORK");
    //  //Desconexion de la Base de Datos
    //  $sql->disconnect();
    //  Mensajenew("Falla de Inserci&oacute;n de Datos en la Maestra Control de Certificado ...!!!","javascript:history.back();","N");
    //  $smarty->display('pie_pag.tpl'); exit();
    //}  
 
    $errorgrabar = 0;
    for ($cont=0;$cont<$filas_found;$cont++) {     
       $reg = pg_fetch_array($resultado); 
       $horactual=hora();
       $instram = true;
       $vcod = $reg[control];
       $vder = $reg[nro_derecho];
       $vreg = $reg[registro];
       //Inserto Datos en la tabla de Control de Certificado 
       $insert_str = "$vcod,'$vder','$vreg','1'";
       $instreg = $sql->insert1("$tbname_9","","$insert_str",""); 
          
       //Actualizo la maestra en estatus a 5
       if ($instram) { }
       else {
         $errorgrabar = $errorgrabar+1; }
    }  
   
    // Verificacion y actualizacion real de los Datos en BD 
    if (($instcer) AND ($errorgrabar == 0)) {    //Validacion del Numero de Solicitud
       pg_exec("COMMIT WORK");
       //Desconexion de la Base de Datos
       $sql->disconnect1();
       //Mensajenew('DATOS GUARDADOS CORRECTAMENTE!!!','m_controlcert.php?vopc=3','S');
       Msgrptimp("DATOS GUARDADOS CORRECTAMENTE ...!!!","m_controlcert.php?vopc=3","m_rptctrlcert.php?vped=$vcod&vusr=$usuario");
       $smarty->display('pie_pag.tpl'); exit();
    }
    else {
      pg_exec("ROLLBACK WORK");
      //Desconexion de la Base de Datos
      $sql->disconnect1();
      if (!$instcer) { $error_cer  = " - Control de Certificados "; } 
      if (!$instreg) { $error_reg  = " - Expedientes  "; }
      Mensajenew("Falla de Actualizaci&oacute;n / Inserci&oacute;n de Datos en la BD $error_cer $error_reg  ...!!!","javascript:history.back();","N");
      $smarty->display('pie_pag.tpl'); exit();
    }
    
  }

//Paso de variables de datos
$smarty->assign('vopc',$vopc);
$smarty->assign('arraytipo',$arraytipo);
$smarty->assign('tipo_id',0);

$smarty->assign('arrayvind',array(B,N,J,P,A));
$smarty->assign('arraytind',array('','Persona Natural Titular','Rep. Persona Juridica Nacional','Apoderado','Agente'));
$smarty->assign('arrayvaut',array(N,S));
$smarty->assign('arraytaut',array('No','Si'));

//Pase de variables y Etiquetas al template
$smarty->assign('submitbutton','submit'); 
$smarty->assign('submitbutton1','button'); 

$smarty->assign('campo1','Acci&oacute;n:');
$smarty->assign('campo2','&nbsp;&nbsp;&nbsp;Fecha de Pedido:');
$smarty->assign('campo3','M&aacute;ximo 10 Expedientes:');
$smarty->assign('campo4','Control No.:');
$smarty->assign('campo5','Nombre:');
$smarty->assign('campo6','C&eacute;dula de Identidad:');
$smarty->assign('campo7','Tel&eacute;fono:');
$smarty->assign('campo8','Correo:');
$smarty->assign('campo9','&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Actuando en su condici&oacute;n de:');
$smarty->assign('campo10','Autoriza para Presentar y/o Retirar:');


$smarty->assign('usuario',$usuario);
$smarty->assign('tipo',$tipo);
$smarty->assign('fechaper',$fechaper);
$smarty->assign('vpag',$vpag); 
$smarty->assign('fechat',$fechat); 
$smarty->assign('fechaeven',$fechaeven); 
$smarty->assign('nctrlcer',$nctrlcer); 

$smarty->display('m_controlcert.tpl');
$smarty->display('pie_pag.tpl');

?>
