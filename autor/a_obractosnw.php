<script language="JavaScript">

function pregunta() { 
  return confirm('Estas seguro de grabar la Informacion ?'); }

function browsesolicitante(var1,var2,var3) {
  this.interesado='Solicitante';
  open("adm_solobra.php?vsol="+var1.value+"&vtex="+var2.value+"&vmod="+var3.value+"&vtip="+this.interesado,"Ventana", "scrollbars=yes,toolbar=no,directories=no,menubar=no,status=no"); }
</script> 

<?php
//   open("d_opinsoli.php?vsol="+var1.value+"&vtex="+var2.value+"&vmod="+var3.value+"&vtip="+this.interesado,"Ventana", "scrollbars=yes,toolbar=no,directories=no,menubar=no,status=no"); } 
// *************************************************************************************
// Programa: a_obractosnw.php 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Año: 2010
// *************************************************************************************

//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variables
$usuario = $_SESSION['usuario_login'];
$sql     = new mod_db();
$fecha   = fechahoy();
$modulo  = "a_obractosnw.php";

// Definicion de Tablas 
$tbname_1 = "stdobras";
$tbname_2 = "stdactos";
$tbname_3 = "stdidiom";
$tbname_4 = "stddaper";
$tbname_5 = "stddajur";
$tbname_6 = "stdrepre";
$tbname_7 = "stdobsol";
$tbname_8 = "stdstobr";
$tbname_9 = "stdevtrd";
$tbname_10 = "stzpaisr";
$tbname_11 = "stzusuar";
$tbname_12 = "stdevobr";
$tbname_13 = "stdtmpso";
$tbname_14 = "stzbitac";
$tbname_15 = "stzbider";
$tbname_16 = "stzsolic";

// Obtencion de variables de los campos del tpl 
$vopc   = $_GET['vopc'];
$conx   = $_GET['conx']; 
$nconex = $_GET['nconex'];
$salir  = $_GET['salir']; 

$vsol          =$_POST['vsol1'];
$vder          =$_POST['vder'];
$accion        =$_POST['accion'];
//$nplanilla     =$_POST['nplanilla'];
$nu_planilla   =$_POST['nu_planilla'];
$fecha_solic   =$_POST['fecha_solic'];
$partes        =$_POST['partes'];
$naturaleza    =$_POST['naturaleza'];
$objeto        =$_POST['objeto'];
$duracion      =$_POST['duracion'];
$domicilio     =$_POST['domicilio'];
$pais_origen   =$_POST['pais_origen'];
$p_origen      =$_POST['p_origen'];
$fecha_firma   =$_POST['fecha_firma'];
$cod_idioma    =$_POST['cod_idioma'];
$idioma        =$_POST['idioma'];
$idioma_orig   =$_POST['idioma_orig'];
$datosregistro =$_POST['datosregistro'];
$derechos      =$_POST['derechos'];
$tipo_cuantia  =$_POST['tipo_cuantia'];
$espec_cuantia =$_POST['espec_cuantia'];
$solicitante   =$_POST['solicitante'];
$tipo_caracter =$_POST['tipo_caracter'];
$otro_caracter =$_POST['otro_caracter'];
$prueba_repres =$_POST['prueba_repres'];
$tipo_soporte  =$_POST['tipo_soporte'];
$observacion   =$_POST['observacion'];
$hojas_adicio  =$_POST['hojas_adicio'];
$n_hojas_adic  =$_POST['n_hojas_adic'];
$datos_ampli   =$_POST['datos_ampli'];
$datos_adicio  =$_POST['datos_adicio'];
$string        =$_POST['string']; 
$campos        =$_POST['campos']; 
$string2       =$_POST['string2']; 
$campos2       =$_POST['campos2']; 
$horactual     =date("h:i:s");
$nplanilla     =substr($_POST['vsol1'],0,6);

// ************************************************************************************
$smarty->assign('titulo',$substaut);
$smarty->assign('subtitulo','Ingreso de Solicitud / Actos y Contratos'); 
if ($vopc==3 || $vopc==4) {
  $smarty->assign('subtitulo','Mantenimiento de Expediente / Ingreso Actos y Contratos'); }
if ($vopc==5 || $vopc==6) {
  $smarty->assign('subtitulo','Mantenimiento de Expediente / Modificaci&oacute;n Actos y Contratos'); } 

$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');
$smarty->assign('vhora',$horactual);
$smarty->assign('nplanilla',$nplanilla);
$smarty->assign('tipo_soli',array(N,J));
$smarty->assign('soli_def',array('Natural','Juridico'));
$smarty->assign('tipo_carac',array(A,N,C,P,T,H,O));
$smarty->assign('carac_def',array('Autor','En Nombre del Titular','Por Cesi&oacute;n','Parte que Interviene','Como Titular Derivado','Heredero','Otro'));
$smarty->assign('tipo_hadic',array(N,S));
$smarty->assign('hadic_def',array('No','Si'));
$smarty->assign('tipo_cuan',array(G,O));
$smarty->assign('cuan_def',array('A Titulo Gratuito','A Titulo Oneroso'));

// ************************************************************************************  
// Control de acceso: Entrada y Salida al Modulo 
if ($conx==0) { 
  $smarty->assign('n_conex',$nconex);      }
else {
  if ($vopc == 3) { $opra='I'; }
  if ($vopc == 5) { $opra='M'; }
  $res_conex = insconex($usuario,$modulo,$opra);
  $smarty->assign('n_conex',$res_conex);   }

if (($salir==0) && ($nconex>0)) {
  $logout = salirconx($nconex);
}

// ************************************************************************************  
// Verificando conexion
$sql->connection($usuario);

// Obtención de los idiomas 
  $obj_query = $sql->query("SELECT * FROM $tbname_3 ORDER BY idioma");
  if (!$obj_query) { 
    mensajenew("ERROR: Problema al intentar realizar la consulta en la tabla $tbname_3 ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
  $filas_found=$sql->nums('',$obj_query);
  if ($filas_found==0) {
    mensajenew("ERROR: La Tabla de Idiomas esta Vacia ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 
  
  $cont = 0;
  $arraycodidiom[$cont]=0;
  $arraynomidiom[$cont]='';
  $objs = $sql->objects('',$obj_query);
  for($cont=1;$cont<=$filas_found;$cont++) { 
    $arraycodidiom[$cont]=$objs->cod_idioma;
    $arraynomidiom[$cont]=trim($objs->idioma);
    $objs = $sql->objects('',$obj_query);  }

  // Obtención de los Paises
  $obj_query = $sql->query("SELECT * FROM $tbname_10 ORDER BY nombre");
  if (!$obj_query) { 
    mensajenew("ERROR: Problema al intentar realizar la consulta en la tabla $tbname_10 ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
  $filas_found=$sql->nums('',$obj_query);
  if ($filas_found==0) {
    mensajenew("ERROR: La Tabla de Paises esta Vacia ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 
  
  $cont = 0;
  $arraycodpais[$cont]=0;
  $arraynompais[$cont]='';
  $objs = $sql->objects('',$obj_query);
  for($cont=1;$cont<=$filas_found;$cont++) { 
    $arraycodpais[$cont]=$objs->pais;
    $arraynompais[$cont]=trim($objs->nombre);
    $objs = $sql->objects('',$obj_query);  }

// ************************************************************************************
if ($vopc==3) {
  $smarty->assign('varfocus','foractos.vsol1');
  $smarty->assign('bmodo','disabled'); 
  $smarty->assign('modo',''); 
  $smarty->assign('modo1','disabled'); 
  $smarty->assign('modo2','disabled'); 
  $accion = "I";
}

// ************************************************************************************
if ($vopc==4) {
  $accion = "I";
  $nconex = $_POST['nconex'];

  if (empty($vsol)) {
    mensajenew("AVISO: No introdujo ningún valor de Planilla ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); } 

  $res_obra = pg_exec("SELECT * FROM $tbname_1 WHERE solicitud='$vsol'");
  $nfil = pg_numrows($res_obra);
  if ($nfil>0) {
   mensajenew("AVISO: Solicitud $vsol ya existe en la Base de Datos ...!!!","javascript:history.back();","N");
   $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 

  //La Fecha de Hoy para la solicitud
  $fecha_solic = hoy();
  $smarty->assign('fecha_solic',$fecha_solic);
  $smarty->assign('varfocus','forautor.fecha_solic');
  $smarty->assign('bmodo',''); 
  $smarty->assign('modo','disabled'); 
  $smarty->assign('modo1',''); 
  $smarty->assign('modo2',''); 
  $smarty->assign('n_conex',$nconex); 

} // final de $vopc==4

// ************************************************************************************
if ($vopc==5) {
  $smarty->assign('varfocus','foractos.vsol1');
  $smarty->assign('bmodo','disabled'); 
  $smarty->assign('modo',''); 
  $smarty->assign('modo1','disabled'); 
  $smarty->assign('modo2','disabled'); 
  $accion = "M";
}

// ************************************************************************************ 
if ($vopc==6) {
  $accion = "M";
  $nconex = $_POST['nconex'];

  if (empty($vsol)) {
    mensajenew("AVISO: No introdujo ningún valor de Expediente ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); } 

  // Obtencion de los datos de la Obra   
  $obj_query = $sql->query("SELECT * FROM $tbname_1 WHERE solicitud='$vsol' AND tipo_obra='AC'");
  if (!$obj_query) { 
    mensajenew("ERROR: Problema al intentar realizar la consulta en la tabla $tbname_1 ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
  $filas_found=$sql->nums('',$obj_query);
  if ($filas_found==0) {
    mensajenew("ERROR: NO EXISTEN DATOS ASOCIADOS ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 

  $objs = $sql->objects('',$obj_query);
  $nplanilla    = $objs->nplanilla;
  $vder         = $objs->nro_derecho;   
  $fecha_solic  = $objs->fecha_solic;
  $titulobr     = trim($objs->titulo_obra);
  $p_origen     = $objs->pais_origen;
  $pais_origen  = $objs->pais_origen;
  $cod_idioma   = $objs->cod_idioma;
  $idioma_orig  = $objs->cod_idioma;
  $n_ejemplares = $objs->n_ejemplares;  
  $tipo_soporte = trim($objs->tipo_soporte);
  $observacion  = trim($objs->observacion);
  $n_hojas_adic = $objs->n_hojas_adic;
  $datos_ampli  = trim($objs->datos_ampli);
  $datos_adicio = trim($objs->datos_adicio);
  $nu_planilla  = $objs->nplanilla;

  if ($n_hojas_adic==0) { $hojas_adicio = "N"; }
  else { $hojas_adicio = "S"; } 
    
  $valores_fields = array($vsol,$fecha_solic,$titulobr,$traduccion,$p_origen,$idioma,$n_ejemplares,$tipo_soporte,$observacion,$n_hojas_adic,$datos_ampli,$nplanilla,$datos_adicio);
  $campos = "solicitud|fecha_solic|titulo_obra|traduccion|pais_origen|cod_idioma|n_ejemplares|tipo_soporte|observacion|n_hojas_adic|datos_ampli|nplanilla|datos_adicio";
  $string = bitacora_fields();
  $smarty->assign('string',$string);
  $smarty->assign('campos',$campos);

  // Obtencion de los datos del Acto o Contrato  
  $obj_query = $sql->query("SELECT * FROM $tbname_2 WHERE nro_derecho='$vder'");
  if (!$obj_query) { 
    mensajenew("ERROR: Problema al intentar realizar la consulta en la tabla $tbname_2 ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
  $filas_found=$sql->nums('',$obj_query);
  if ($filas_found==0) {
    mensajenew("ERROR: NO EXISTEN DATOS ASOCIADOS ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 

  $objs = $sql->objects('',$obj_query);
  $partes        = trim($objs->partes);
  $naturaleza    = trim($objs->naturaleza);
  $objeto        = trim($objs->objeto);
  $derechos      = trim($objs->derechos);
  $tipo_cuantia  = $objs->tipo_cuantia;
  $espec_cuantia = trim($objs->espec_cuantia);
  $duracion      = trim($objs->duracion);
  $domicilio     = trim($objs->domicilio);
  $datosregistro = trim($objs->datosregistro);
  $fecha_firma   = $objs->fecha_firma;

  $valores_fields = array($vsol,$partes,$naturaleza,$objeto,$derechos,$tipo_cuantia,$espec_cuantia,$duracion,$domicilio,$datos_registro,$fecha_firma);
  $campos2 = "solicitud|partes|naturaleza|objeto|derechos|tipo_cuantia|espec_cuantia|duracion|domicilio|datos_registro|fecha_firma";
  $string2 = bitacora_fields();
  $smarty->assign('string2',$string2);
  $smarty->assign('campos2',$campos2);
 
  // Obtencion del Solicitante 
  $del_datsol = $sql->del("stdtmpso","solicitud='$vsol'");
  $obj_query = $sql->query("SELECT * FROM $tbname_16,$tbname_7 WHERE $tbname_7.nro_derecho='$vder' AND $tbname_7.titular=$tbname_16.titular");
  if (!$obj_query) { 
    mensajenew("ERROR: Problema al intentar realizar la consulta en la tabla $tbname_7 ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
  $filas_found=$sql->nums('',$obj_query);
  if ($filas_found > 0) {
    $objs = $sql->objects('',$obj_query);
    $codigo        = $objs->titular;
    $tipo_caracter = $objs->caracter;
    $otro_caracter = $objs->otro_caracter;
    $prueba_repres = $objs->prueba_repres;
    $recupera_int  = llenatemporal($tbname_7,$tbname_13,$codigo,$vsol); }

  $smarty->assign('modo','disabled'); 
  $smarty->assign('n_conex',$nconex); 

} // final de $vopc==6  

// ************************************************************************************
//Opcion Grabar...
if ($vopc==2) {
  $n_conex = $_POST['nconex'];

  //Código del Evento de Ingreso 
  $evento = 200;
  //La Fecha de Hoy y Hora para la transaccion
  $fechahoy = hoy();
  $horactual= Hora();
  $tipo_soporte="PAPEL";
  
  //Verificación de que el Evento 200 de Carga Inicial existe 
  $resultado=pg_exec("SELECT * FROM $tbname_12 WHERE evento=200");
  if (!$resultado) { 
    mensajenew("ERROR: Código de Evento NO existe en la Base de Datos ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
  $filas_found=pg_numrows($resultado); 
  if ($filas_found==0) {
    mensajenew("ERROR: No existen Datos asociados al Evento ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 
  $regeve = pg_fetch_array($resultado);
  $vdescrip=trim($regeve['mensa_automatico']);
  $comentario="";

  //Comparación de la fecha de Solicitud
  $esmayor=compara_fechas($fecha_solic,$fechahoy);
  if ($esmayor==1) {
    mensajenew("AVISO: La Fecha de Solicitud No puede ser mayor a la de Hoy ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }

  //Verificacion de que los campos requeridos esten llenos...
  $req_fields = array("fecha_solic","partes","naturaleza","objeto","derechos","duracion","domicilio","pais","fecha_firma","datosregistro","observacion");
  $valores = array($fecha_solic,$partes,$naturaleza,$objeto,$derechos,$duracion,$domicilio,$p_origen,$fecha_firma,$datosregistro,$observacion);
  $vacios = check_empty_fields();
  if (!$vacios) { 
     mensajenew("AVISO: Hay Informacion en el formulario que esta Vacia ...!!!","javascript:history.back();","N");
     $smarty->display('pie_pag.tpl'); exit(); }

  if (empty($p_origen)) { 
    mensajenew("AVISO: Debe indicar Pais de la Firma ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }

  if (empty($tipo_cuantia)) { 
    mensajenew("AVISO: Debe indicar si la cuantia es Onerosa o Gratuita ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }

  if (empty($tipo_caracter)) {
      mensajenew("AVISO: Debe indicar el caracter en que actua el Solicitante ...!!!","javascript:history.back();","N");
      $smarty->display('pie_pag.tpl'); exit(); }

  //Validación de que se le haya cargado el solicitante
  $resoli=pg_exec("SELECT * FROM stdtmpso WHERE solicitud='$vsol'");
  $filas_solicita=pg_numrows($resoli); 
  if ($filas_solicita==0) {
    mensajenew("AVISO: Expediente $vsol sin ningún Solicitante asociado ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }

//  // Validacion de Numero de Planilla
//  if (($accion=="I") || (($accion=="M") and ($nplanilla!=$nu_planilla))) {   
//    $resplan=pg_exec("select * from $tbname_1 where nplanilla='$nplanilla'");
//    $nfil=pg_numrows($resplan);
//    if ($nfil>0) {
//      mensajenew("Numero de Planilla $nplanilla ya existe en la Base de Datos ...!!!","javascript:history.back();","N");
//      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
//  }
  
  //if (empty($nplanilla)) { $nplanilla = 0; }
  
  $vpartes        = str_replace("'","´",$partes);
  $vnaturaleza    = str_replace("'","´",$naturaleza);
  $vobjeto        = str_replace("'","´",$objeto);
  $vderechos      = str_replace("'","´",$derechos);
  $vdomicilio     = str_replace("'","´",$domicilio);
  $vduracion      = str_replace("'","´",$duracion);
  $vobservacion   = str_replace("'","´",$observacion);
  $vdatosregistro = str_replace("'","´",$datosregistro);
    
  if (empty($espec_cuantia)) { 
    $vespec_cuantia = ''; }
  else { 
    $vespec_cuantia = str_replace("'","´",$espec_cuantia); }
    $vdatos_ampli   = str_replace("'","´",$datos_ampli);
    $vdatos_adicio  = str_replace("'","´",$datos_adicio);
  
  if ($hojas_adicio=="N") { $n_hojas_adic=0; }
  if ($hojas_adicio=="S") {
    if (empty($vdatos_adicio)) {
      mensajenew("AVISO: Debe indicar la Informacion en la pestaña de Hojas Adicionales ...!!!","javascript:history.back();","N");
      $smarty->display('pie_pag.tpl'); exit(); }
  }

  if ($accion=="I") { //Comienzo de INCLUIR
    $vder = 0; 
    $ins_obras = true;
    $ins_actos = true;
    $ins_tramite = true;
    // Comienzo de Transaccion 
    pg_exec("BEGIN WORK");

    // Tabla Maestra de Obras 
    $resula=pg_exec("SELECT * FROM $tbname_1 WHERE solicitud='$vsol'");
    $rega= pg_fetch_array($resula);
    $nfil=pg_numrows($resula);
    if ($nfil>0) {
      mensajenew("AVISO: Solicitud $vsol ya existe en la Base de Datos ...!!!","a_obractos.php?vopc=3","N");
      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
  
    //Generacion del Numero de Derecho
    $obj_query = $sql->query("UPDATE stzsystem SET nro_derecho=nextval('stzsystem_nro_derecho_seq')");
    if ($obj_query) {
      $obj_query = $sql->query("SELECT last_value FROM stzsystem_nro_derecho_seq");
      $objs = $sql->objects('',$obj_query);
      $vder = $objs->last_value; }
  
    // Insertamos primero en la Tabla Maestra de Obras 
    $col_campos = "nro_derecho,solicitud,fecha_solic,titulo_obra,tipo_obra,clase,origen,forma,cod_idioma,estatus,pais_origen,n_ejemplares,tipo_soporte,observacion,n_hojas_adic,datos_ampli,datos_adicio,nplanilla";
    $insert_str = "'$vder','-','$fecha_solic','$vnaturaleza','AC','N','N','N','$cod_idioma',1,'$p_origen',1,'$tipo_soporte','$vobservacion','$n_hojas_adic','$vdatos_ampli','$vdatos_adicio','$nplanilla'";
    $ins_obras = $sql->insert("$tbname_1","$col_campos","$insert_str","");

    // Insertamos en la Tabla de Actos y Contratos 
    $col_campos = "nro_derecho,partes,naturaleza,objeto,derechos,tipo_cuantia,espec_cuantia,duracion,domicilio,fecha_firma,datosregistro";
    $insert_str = "'$vder','$vpartes','$vnaturaleza','$vobjeto','$vderechos','$tipo_cuantia','$vespec_cuantia','$vduracion','$vdomicilio','$fecha_firma','$vdatosregistro'";
    $ins_actos = $sql->insert("$tbname_2","$col_campos","$insert_str","");

    // Insertamos en la Tabla de Tramite 
    $col_campos = "nro_derecho,evento,fecha_event,secuencial,estat_ant,fecha_trans,usuario,desc_evento,hora";
    $insert_str = "'$vder',200,'$fecha_solic',nextval('stdevtrd_secuencial_seq'),0,'$fechahoy','$usuario','$vdescrip','$horactual'";
    $ins_tramite = $sql->insert("$tbname_9","$col_campos","$insert_str","");

    // Tabla de Solicitante
    $ins_sol = 0;
    $res_int=pg_exec("SELECT * FROM stdtmpso WHERE solicitud='$vsol'");
    $filas_int=pg_numrows($res_int); 
    if ($filas_int>0) {
      $ins_sol=guardar_interesado('Solicitante',$vsol,$vder,'U',$tipo_caracter,$otro_caracter,$prueba_repres); }

    // Verificacion y actualizacion real de los Datos en BD 
    if ($ins_obras AND $ins_actos AND $ins_tramite AND $ins_sol==0) {
      $res_sol=pg_exec("select dsolicitud from stzsystem");
      $reg_sol = pg_fetch_array($res_sol); 
      $v_sol=$reg_sol[dsolicitud]+1;
      $v_sol=str_repeat('0',6-strlen($v_sol)).$v_sol; 
      $update_str="dsolicitud='$v_sol'";
      $valido1 = $sql->update("stzsystem","$update_str","true");
      $update_str="solicitud='$v_sol'";
      $update_cond="nro_derecho='$vder'";
      $valido2 = $sql->update("stdobras","$update_str","$update_cond");
      if ($valido1 and $valido2) {
        pg_exec("COMMIT WORK");
        //Desconexion de la Base de Datos
        $sql->disconnect(); 
        Mensajenew("DATOS GUARDADOS CORRECTAMENTE BAJO EL NUMERO DE EXPEDIENTE: ".$v_sol,
             "a_obractosnw.php?vopc=3","S"); }
      else {
        pg_exec("ROLLBACK WORK"); 
        //Desconexion de la Base de Datos
        $sql->disconnect();
        Mensajenew("Falla de Ingreso de Datos en la BD, Transacciones Abortadas, 
                 Error en datos asociados...!!!","javascript:history.back();","N");
        $smarty->display('pie_pag.tpl'); exit();    
      }
    }
    else {
      pg_exec("ROLLBACK WORK");
      //Desconexion de la Base de Datos
      $sql->disconnect();

      if (!$ins_obras)   { $error_obras  = " - Obras "; }
      if (!$ins_actos)   { $error_actos  = " - Actos "; }
      if (!$ins_tramite) { $error_tramite= " - Tramite "; }
      if ($ins_sol!=0)   { $error_datsol = " - Solicitante "; } 
      
      Mensajenew("ERROR: Falla de Ingreso de Datos en la BD, Transacciones Abortadas, Error en datos asociados a: $error_obras $error_actos $error_tramite $error_datsol ...!!!","javascript:history.back();","N");
      $smarty->display('pie_pag.tpl'); exit(); }

  } // Final de Incluir 
  else { //Comienzo de MODIFICAR 
    // La Fecha de Hoy y Hora para la transaccion
    $fechahoy = hoy();
    $horactual= Hora();

    // Se obtiene el proximo valor para el secuencial a guardar en stzbitac a partir de stzsistem
    //pg_exec("BEGIN WORK");
    //pg_exec("LOCK TABLE stzsystem IN SHARE ROW EXCLUSIVE MODE");
    //$sys_actual = next_sys("nbitaco");
    //$vsecuencial = grabar_sys("nbitaco",$sys_actual);
    //pg_exec("COMMIT WORK");
    
    // Almaceno registro original en Bitacora stzbitac 
    //$insert_str = "'$vsecuencial','$fechahoy','$horactual','$usuario','$tbname_1','A','M','$vsol','$string','$campos'";
    //$sql->insert("$tbname_14","","$insert_str","");

    // Se obtiene el proximo valor para el secuencial a guardar en stzbitac a partir de stzsistem
    //pg_exec("BEGIN WORK");
    //pg_exec("LOCK TABLE stzsystem IN SHARE ROW EXCLUSIVE MODE");
    //$sys_actual = next_sys("nbitaco");
    //$vsecuencial = grabar_sys("nbitaco",$sys_actual);
    //pg_exec("COMMIT WORK");
    
    // Almaceno registro original en Bitacora stzbitac 
    //$insert_str = "'$vsecuencial','$fechahoy','$horactual','$usuario','$tbname_2','A','M','$vsol','$string2','$campos2'";
    //$sql->insert("$tbname_14","","$insert_str","");

    // Comienzo de Transaccion 
    pg_exec("BEGIN WORK");

    $act_obras = true;
    $act_actos = true;
    // Actualizacion de Tabla Maestra de Obras 
    pg_exec("LOCK TABLE stdobras IN SHARE ROW EXCLUSIVE MODE");
    $update_str ="fecha_solic='$fecha_solic',titulo_obra='$vnaturaleza',pais_origen='$p_origen',cod_idioma='$cod_idioma',observacion='$vobservacion',n_hojas_adic='$n_hojas_adic',datos_ampli='$vdatos_ampli',datos_adicio='$vdatos_adicio',nplanilla='$nplanilla'";
    $act_obras = $sql->update("$tbname_1","$update_str","nro_derecho='$vder'");

    // Actualizacion de la Tabla de Actos y Contratos 
    $update_str = "partes='$vpartes',naturaleza='$vnaturaleza',objeto='$vobjeto',derechos='$vderechos',tipo_cuantia='$tipo_cuantia',espec_cuantia='$vespec_cuantia',duracion='$vduracion',domicilio='$vdomicilio',fecha_firma='$fecha_firma',datosregistro='$vdatosregistro'";
    $act_actos = $sql->update("$tbname_2","$update_str","nro_derecho='$vder'");

    // Tabla de Solicitante
    $ins_sol = 0;
    $res_int=pg_exec("SELECT * FROM stdtmpso WHERE solicitud='$vsol'");
    $filas_int=pg_numrows($res_int); 
    if ($filas_int>0) {
      $del_obrart = $sql->del("stdobsol","nro_derecho='$vder'");
      $ins_sol=guardar_interesado('Solicitante',$vsol,$vder,'U',$tipo_caracter,$otro_caracter,$prueba_repres); }

    // Verificacion y actualizacion real de los Datos en BD 
    if ($act_obras AND $act_actos AND $ins_sol==0) {
      pg_exec("COMMIT WORK");    
      //Desconexion de la Base de Datos
      $sql->disconnect(); }
    else {
      pg_exec("ROLLBACK WORK");    
      //Desconexion de la Base de Datos
      $sql->disconnect();

      if (!$act_obras)   { $error_obras  = " - Obras "; }
      if (!$act_actos)   { $error_actos  = " - Actos "; }
      if ($ins_sol!=0)   { $error_datsol = " - Solicitante "; } 
      Mensajenew("ERROR: Falla de Actualizacion de Datos en la BD, Transacciones Abortadas, Error en datos asociados a: $error_obras $error_actos $error_datsol ...!!!","javascript:history.back();","N");
      $smarty->display('pie_pag.tpl'); exit();
    }
  }

  //Desconexion de la Base de Datos
  //$sql->disconnect();
  if ($accion=="I") { 
    //Mensajenew("DATOS GUARDADOS CORRECTAMENTE ...!!!","a_obractosnw.php?vopc=3&nconex=$n_conex&salir=1&conx=0","S"); 
  }
  else {
    Mensajenew("DATOS GUARDADOS CORRECTAMENTE ...!!!","a_obractosnw.php?vopc=5&nconex=$n_conex&salir=1&conx=0","S"); }
    $smarty->display('pie_pag.tpl'); exit(); 
}

//Pase de variables y Etiquetas al template
$smarty->assign('campo1','Expediente No.:');
$smarty->assign('campo2','de Fecha:');
$smarty->assign('campo3','N&uacute;mero de Planilla:');
$smarty->assign('campo4','Partes que Intervienen:');
$smarty->assign('campo5','Naturaleza:');
$smarty->assign('campo6','Duraci&oacute;n:');
$smarty->assign('campo7','Lugar de la Firma (Ciudad):');
$smarty->assign('campo8','Pa&iacute;s:');
$smarty->assign('campo9','Fecha de la Firma:');
$smarty->assign('campo10','Idioma Original:');
$smarty->assign('campo11','Datos del Registro:');
$smarty->assign('campo12','Derechos o Modalidades de Explotaci&oacute;n:');
$smarty->assign('campo13','Tipo de Cuant&iacute;a:');
$smarty->assign('campo14','Especificaci&oacute;n Cuant&iacute;a:');
$smarty->assign('campo15','Nombre o Raz&oacute;n Social:');
$smarty->assign('campo16','Car&aacute;cter con el que Act&uacute;a:');
$smarty->assign('campo17','Otro Car&aacute;cter con el que Actua:');
$smarty->assign('campo18','Prueba de Representaci&oacute;n o Transferencia de Derechos:');
$smarty->assign('campo19','Documentos Anexos:');
$smarty->assign('campo20','Incluye Hoja(s) Adicional(es):');
$smarty->assign('campo21','No. de Hoja(s) Adicional(es):');
$smarty->assign('campo22','Dato(s) ampliado(s) en la(s) Hoja(s) Adicional(es):');

$smarty->assign('vopc',$vopc);
$smarty->assign('vsol1',$vsol);
$smarty->assign('vder',$vder);
$smarty->assign('accion',$accion);
$smarty->assign('usuario',$usuario);
$smarty->assign('fecha_solic',$fecha_solic);
$smarty->assign('nplanilla',$nplanilla);
$smarty->assign('nu_planilla',$nu_planilla);
$smarty->assign('partes',$partes);
$smarty->assign('naturaleza',$naturaleza);
$smarty->assign('objeto',$objeto);
$smarty->assign('derechos',$derechos);
$smarty->assign('tipo_cuantia',$tipo_cuantia);
$smarty->assign('espec_cuantia',$espec_cuantia);
$smarty->assign('duracion',$duracion);
$smarty->assign('domicilio',$domicilio);
$smarty->assign('pais_origen',$pais_origen); 
$smarty->assign('p_origen',$p_origen);
$smarty->assign('pais_origen',$p_origen);
$smarty->assign('pais',$p_origen);
$smarty->assign('fecha_firma',$fecha_firma);
$smarty->assign('cod_idioma',$cod_idioma);
$smarty->assign('idioma_orig',$idioma_orig);
$smarty->assign('idioma',$idioma);
$smarty->assign('datosregistro',$datosregistro);
$smarty->assign('tipo_caracter',$tipo_caracter); 
$smarty->assign('otro_caracter',$otro_caracter);  
$smarty->assign('prueba_repres',$prueba_repres); 
$smarty->assign('observacion',$observacion); 
$smarty->assign('hojas_adicio',$hojas_adicio);
$smarty->assign('n_hojas_adic',$n_hojas_adic); 
$smarty->assign('datos_ampli',$datos_ampli); 
$smarty->assign('datos_adicio',$datos_adicio); 
$smarty->assign('n_ejemplares',$n_ejemplares);
$smarty->assign('tipo_soporte',$tipo_soporte);

$smarty->assign('estatus',$estatus);
$smarty->assign('arraycodpais',$arraycodpais);
$smarty->assign('arraynompais',$arraynompais);
$smarty->assign('arraycodidiom',$arraycodidiom);
$smarty->assign('arraynomidiom',$arraynomidiom);

$smarty->display('a_obractosnw.tpl');
$smarty->display('pie_pag.tpl');
?>
