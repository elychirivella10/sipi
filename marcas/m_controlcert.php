<script language="Javascript"> 

function pregunta() { 
  return confirm('Esta seguro de grabar la Informacion ? Debe estar completa antes de Grabarla ..!!'); }

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

function agent(vcampo,vcampo1)
{
  if(vcampo.checked) {
    alert('Debe estar registrado como Agente y poseer numero asignado ...!!!');
    vcampo1.focus(); vcampo1.disabled = false }
  else { vcampo1.value=0; vcampo1.disabled = true }  
}

function aut(vcampo,vcampo1)
{
  <!-- alert('La opción seleccionada es: '+indaut.options[indaut.selectedIndex].value); --> 
  if(vcampo.value=="S") {
    vcampo1.focus(); vcampo1.disabled = false }
  else { vcampo1.value=''; vcampo1.disabled = true }  
}

function browseautoriza(var1,var2,var3) {
  open("adm_autoriza.php?vcod="+var1.value+"&vtex="+var2.value+"&vmod="+var3.value,"Ventana", "scrollbars=yes,toolbar=no,directories=no,menubar=no,status=no"); }

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
$usuario = $_SESSION['usuario_login'];
$usrsede = $_SESSION['usuario_sede'];

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
$tbname_10 = "stmtmpcer";
$tbname_11 = "stmpceraut"; 
$tbname_12 = "stmceraut"; 

$vopc      = $_GET['vopc'];
$tipo      = $_POST['tipo'];
$fechaper  = $_POST['fechaper'];

$vsola=$vsol1."-".sprintf("%06d",$vsol2);
$vsolb=$vsol3."-".sprintf("%06d",$vsol4);
$resultado=false;

$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Control de Certificados de Registros de Marcas');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');
$smarty->assign('varfocus','formarcas1.vsol1'); 
$smarty->assign('modo2','readonly');

//Verificando conexion
$sql->connection($usuario);

//Carga el tipo de marca para mostrarlo en el combo
$blanco='';
$arraytipo[0]='';
$arraytipo[1]='FIRMAR';
$arraytipo[2]='CORREGIR';

if ($vopc==3) {
  $smarty->assign('modo','disabled'); 
  $smarty->assign('modo1','disabled'); 
  $smarty->assign('modo2','disabled'); 
  $smarty->assign('modo3','disabled'); 
  $smarty->assign('vmodo','readonly=readonly'); 
}   

if ($vopc==5) {
  //Se obtiene el proximo valor para el secuencial a guardar a partir de stzsistem
  pg_exec("BEGIN WORK");
  pg_exec("LOCK TABLE stzsystem IN SHARE ROW EXCLUSIVE MODE");
  $obj_query = $sql->query("SELECT last_value FROM stzsystem_controlcert_seq");
  $objs = $sql->objects('',$obj_query);
  $control1 = $objs->last_value;
  $control2 = $control1 + 1;
  pg_exec("ALTER SEQUENCE stzsystem_controlcert_seq RESTART WITH $control2");
  $update_str = "controlcert=$control2";
  $updsystem = $sql->update("$tbname_6","$update_str","");
  pg_exec("COMMIT WORK");
  
  //$sys_actual = next_sys("controlcert");
  //$vsecuencial = grabar_sys("controlcert",$sys_actual);
  //$nctrlcer=$sys_actual;
  $smarty->assign('nctrlcer',$control1); 
  $del_datos = $sql->del("$tbname_10","control='$control1'");
  $fechaper = $fechahoy;   
  $direccion = getRealIP();
  $smarty->assign('fechaper',$fechaper);
  $smarty->assign('direccion',$direccion); 
  $smarty->assign('modo3','disabled'); 
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
    $smarty->display('encabezado1.tpl');
    mensajenew('ERROR: NO se pueden ejecutar eventos(fechas) a Futuros ...!!!','javascript:history.back();','N');
    $smarty->display('pie_pag.tpl'); exit();  } 

  $solicitante = trim($_POST['solicitante']);
  $cisolicita = $_POST['cisolicita'];
  $telefono = $_POST['telefono'];
  $correo = $_POST['correo'];
  $indaut = $_POST['indaut'];
  $lced  = $_POST['lced'];
  $lced1 = $_POST['lced1'];

  if (empty($solicitante) ) {
    mensajenew('ERROR: No introdujo el Nombre del Solicitante ...!!!','javascript:history.back();','N');
    $smarty->display('pie_pag.tpl'); exit(); }

  if (empty($cisolicita) ) {
    mensajenew('ERROR: No introdujo la Cedula del Solicitante ...!!!','javascript:history.back();','N');
    $smarty->display('pie_pag.tpl'); exit(); }
  $ced_solicitante = $lced.$cisolicita;
    
  if (empty($telefono) ) {
    mensajenew('ERROR: No introdujo el Telefono del Solicitante ...!!!','javascript:history.back();','N');
    $smarty->display('pie_pag.tpl'); exit(); }

  //if (empty($correo) ) {
  //  mensajenew('ERROR: No introdujo el Correo del Solicitante ...!!!','javascript:history.back();','N');
  //  $smarty->display('pie_pag.tpl'); exit(); }

  //if ($indaut=="S") {
  //  $autorizado = trim($_POST['autorizado']);
  //  $ciautorizado = trim($_POST['ciautorizado']);
    
  //  if (empty($autorizado) ) {
  //    mensajenew('ERROR: No introdujo el Nombre del Autorizado ...!!!','javascript:history.back();','N');
  //    $smarty->display('pie_pag.tpl'); exit(); }

  //  if (empty($ciautorizado) ) {
  //    mensajenew('ERROR: No introdujo la cedula del Autorizado ...!!!','javascript:history.back();','N');
  //    $smarty->display('pie_pag.tpl'); exit(); }
  //  $ced_autorizado = $lced1.$ciautorizado;
  //}
  
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
     
  $resuleve=pg_exec("SELECT * FROM stzevder WHERE evento=1835");
  if (!$resuleve) { 
    mensajenew("ERROR: Código de Evento NO existe en la Base de Datos ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
  $filas_found=pg_numrows($resuleve); 
  if ($filas_found==0) {
    mensajenew("ERROR: No existen Datos asociados al Evento ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 
  $regeve = pg_fetch_array($resuleve);
  $vdes=trim($regeve['mensa_automatico']);

  $instcer  = true;
  $vcod=$_POST['nctrlcer'];
  $direccion=$_POST['direccion'];

  $errorgrabar = 0;
  $resultado=pg_exec("SELECT * FROM stmtmpcer WHERE control = '$vcod'");
  $filas_found=pg_numrows($resultado);    

  if ($filas_found == 0) {
    mensajenew('ERROR: No introdujo Expedientes Registrados en estatus 555 ...!!!','javascript:history.back();','N');
    $smarty->display('pie_pag.tpl'); exit(); }
    $horactual=hora();
    //$insert_str = "$vcod,'$accion','$fechaper','$solicitante','$ced_solicitante','$telefono','$correo','$vges1','$vges2','$vges3','$vges4','$indaut','$autorizado','$ced_autorizado','$vagente',$filas_found,'1','$usuario','$usrsede','$fechahoy','$horactual','$direccion'";   
    $insert_str = "$vcod,'$accion','$fechaper','$solicitante','$ced_solicitante','$telefono','$correo','$vges1','$vges2','$vges3','$vges4','$indaut','$vagente',$filas_found,'1','$usuario','$usrsede','$fechahoy','$horactual','$direccion'";   
    $instcer = $sql->insert("$tbname_8","","$insert_str",""); 
    if ($instcer) { }  
      else {
        $errorgrabar = $errorgrabar+1; }
 
    $horactual = Hora();
    $comenta = "Tramite: ".$accion." - ".$tipo." / Solicitante: ".$solicitante;
    
    if ($indaut=="S") {

      $numaut = 0; 
      $insaut = true;
      $autorizado = "";
      // Tabla de Autorizados  
      $res_aut=pg_exec("SELECT * FROM $tbname_11 where control='$vcod'");
      $filas_res_aut=pg_numrows($res_aut); 
      $regaut = pg_fetch_array($res_aut);
      for($i=0;$i<$filas_res_aut;$i++) { 
        $cdaut = $regaut[cedula_aut];
        $nbaut = $regaut[nombre_aut];
        $nbaut = str_replace("'","´",$nbaut);
        if ($i==0) {
           $autorizado = $autorizado.$nbaut." CI. ".$cdaut; } 
        else {
           $autorizado = $autorizado.", ".$nbaut." CI. ".$cdaut; } 
        $col_campos = "control,ci_autorizado,autorizado";
        $insert_str = "'$vcod','$cdaut','$nbaut'";
        $insaut = $sql->insert("$tbname_12","$col_campos","$insert_str","");
        if ($insaut) { }
        else { $errorgrabar = $errorgrabar+1; }  
        $regaut = pg_fetch_array($res_aut); 
      } 
      $comenta = "Tramite: ".$accion." - ".$tipo." / Solicitante: ".$solicitante.", autoriza a Presentar/Retirar a: ".$autorizado; 
    }
    $del_datos = $sql->del("$tbname_11","control='$vcod'");

    for ($cont=0;$cont<$filas_found;$cont++) {     
       $reg = pg_fetch_array($resultado); 
       $horactual=hora();
       $instreg = true;
       $vcod = $reg[control];
       $vder = $reg[nro_derecho];
       $vreg = $reg[registro];
       //Inserto Datos en la tabla de Control de Certificado 
       $insert_str = "$vcod,'$vder','$vreg','1'";
       
       $filas_registro = 0; 
       $obj_query = $sql->query("SELECT * FROM $tbname_9 where control='$vcod' AND nro_derecho='$vder'");
       $filas_registro = $sql->nums('',$obj_query);
       if ($filas_registro==0) {
         $instreg = $sql->insert("$tbname_9","","$insert_str","");  

         $resulest=pg_exec("SELECT estatus FROM stzderec WHERE nro_derecho='$vder'");
         $regestmar = pg_fetch_array($resulest);
         $vest=trim($regestmar['estatus']);

         if ($instreg) { }
         else {
           $errorgrabar = $errorgrabar+1; }

         $instram = true;
         // Tabla de Eventos de Tramite  
         if ($errorgrabar==0) {    //Validacion del Numero de Solicitud
           $col_campos = "nro_derecho,evento,fecha_event,secuencial,estat_ant,documento,comentario,fecha_trans,usuario,desc_evento,hora";
           $insert_str = "'$vder',1835,'$fechaper',nextval('stzevtrd_secuencial_seq'),'$vest','$vcod','$comenta','$fec_hoy','$usuario','$vdes','$horactual'";
           $instram = $sql->insert("$tbname_4","$col_campos","$insert_str","");
           if ($instram) { }
           else {
             $errorgrabar = $errorgrabar+1; }
         }   
       }
    }  
   
    // Verificacion y actualizacion real de los Datos en BD 
    if ($errorgrabar==0) {    //Validacion del Numero de Solicitud
       pg_exec("COMMIT WORK");
       //Desconexion de la Base de Datos
       $sql->disconnect();
       Mensajenew('DATOS GUARDADOS CORRECTAMENTE!!!','m_controlcert.php?vopc=3','S');
       $smarty->display('pie_pag.tpl'); exit();
    }
    else {
      pg_exec("ROLLBACK WORK");
      //Desconexion de la Base de Datos
      $sql->disconnect();
      //if (!$instcer) { $error_cer  = " - Control de Certificados "; } 
      //if (!$instreg) { $error_reg  = " - Expedientes  "; }
      Mensajenew("Falla de Actualizaci&oacute;n / Inserci&oacute;n en la Datos en la BD ...!!!","javascript:history.back();","N");
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
//$smarty->assign('submitbutton','submit'); 
//$smarty->assign('submitbutton1','button'); 

$smarty->assign('campo1','Acci&oacute;n:');
$smarty->assign('campo2','&nbsp;&nbsp;&nbsp;Fecha de Pedido:');
$smarty->assign('campo3','M&aacute;ximo 10 Expedientes:');
$smarty->assign('campo4','CONTROL No.:');
$smarty->assign('campo5','Autorizaciones:');
$smarty->assign('campo6','C&eacute;dula de Identidad:');
$smarty->assign('campo7','Tel&eacute;fono:');
$smarty->assign('campo8','Correo:');
$smarty->assign('campo9','&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Actuando en su condici&oacute;n de:');
$smarty->assign('campo10','Autoriza para Presentar y/o Retirar:');
$smarty->assign('lced_id',array(' ','V','E','P')); 
$smarty->assign('lced_de',array(' ','V','E','P'));

$smarty->assign('usuario',$usuario);
$smarty->assign('tipo',$tipo);
$smarty->assign('fechaper',$fechaper);
$smarty->assign('vpag',$vpag); 
$smarty->assign('fechat',$fechat); 
$smarty->assign('fechaeven',$fechaeven); 
//$smarty->assign('nctrlcer',$nctrlcer);
$smarty->assign('nctrlcer',$control1);
$smarty->assign('lced',$lced);
$smarty->assign('lced1',$lced1);

$smarty->display('m_controlcert.tpl');
$smarty->display('pie_pag.tpl');

?>
