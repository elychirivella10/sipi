<script language="JavaScript">

function pregunta() { 
  return confirm('Estas seguro de grabar la Informacion ?'); }

function browsesolicitante(var1,var2,var3) {
  this.interesado='Solicitante';
  open("adm_solobra.php?vsol="+var1.value+"&vtex="+var2.value+"&vmod="+var3.value+"&vtip="+this.interesado,"Ventana", "scrollbars=yes,toolbar=no,directories=no,menubar=no,status=no"); }

function browseproductor(var1,var2,var3) {
  this.interesado='Productor';
  open("adm_solobra.php?vsol="+var1.value+"&vtex="+var2.value+"&vmod="+var3.value+"&vtip="+this.interesado,"Ventana", "scrollbars=yes,toolbar=no,directories=no,menubar=no,status=no"); }

function browseobfie(var1,var2,var3) {
  this.interesado='Fijadas';
  open("d_opinobfie.php?vsol="+var1.value+"&vtex="+var2.value+"&vmod="+var3.value+"&vtip="+this.interesado,"Ventana", "scrollbars=yes,toolbar=no,directories=no,menubar=no,status=no"); }

function browsemobfie(var1,var2,var3) {
  this.interesado='Fijadas';
  open("d_opinobfie.php?vsol="+var1.value+"&vtex="+var2.value+"&vmod="+var3.value+"&vtip="+this.interesado,"Ventana", "scrollbars=yes,toolbar=no,directories=no,menubar=no,status=no"); }

</script> 

<?php
// *************************************************************************************
// Programa: a_obrpfononw.php 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Desarrollado Año: 2010
// *************************************************************************************
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variables
$usuario = $_SESSION['usuario_login'];
$sql     = new mod_db();
$fecha   = fechahoy();
$modulo  = "a_obrpfononw.php";

// Definicion de Tablas 
$tbname_1 = "stdobras";
$tbname_2 = "stdfijin";
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
$tbname_13 = "stdobpro";
$tbname_14 = "stdfijac";
$tbname_15 = "stdtrans";
$tbname_16 = "stdtmpso";
$tbname_17 = "stdtmppt";
$tbname_18 = "stdtmpfie";
$tbname_19 = "stzbitac";
$tbname_20 = "stzbider";
$tbname_21 = "stzsolic";

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
$fecha_solpf   =$_POST['fecha_solpf'];
$titulobr      =$_POST['titulobr'];
$traduccion    =$_POST['traduccion'];
$pais_origen   =$_POST['pais_origen'];
$p_origen      =$_POST['p_origen'];
$cod_idioma    =$_POST['cod_idioma'];
$idioma        =$_POST['idioma'];
$idioma_orig   =$_POST['idioma_orig'];
$annofijacion  =$_POST['annofijacion'];  
$annopripubli  =$_POST['annopripubli'];
$transferen    =$_POST['transferen'];
$productor     =$_POST['productor'];
$solicitante   =$_POST['solicitante'];
$tipo_caracter =$_POST['tipo_caracter'];
$otro_caracter =$_POST['otro_caracter'];
$prueba_repres =$_POST['prueba_repres'];
$n_ejemplares  =$_POST['n_ejemplares'];
$tipo_soporte  =$_POST['tipo_soporte'];
$observacion   =$_POST['observacion'];
$hojas_adicio  =$_POST['hojas_adicio'];
$n_hojas_adic  =$_POST['n_hojas_adic'];
$datos_ampli   =$_POST['datos_ampli'];
$datos_adicio  =$_POST['datos_adicio'];
$string        =$_POST['string']; 
$campos        =$_POST['campos']; 
$string14      =$_POST['string14']; 
$campos14      =$_POST['campos14']; 
$string15      =$_POST['string15']; 
$horactual     =date("h:i:s");
$nplanilla     =substr($_POST['vsol1'],0,6);

// ************************************************************************************
$smarty->assign('titulo',$substaut);
$smarty->assign('subtitulo','Producci&oacute;n Fonogr&aacute;fica');
if ($vopc==3 || $vopc==4) {
  $smarty->assign('subtitulo','Ingreso de Solicitud / Producci&oacute;n Fonogr&aacute;fica'); }
if ($vopc==5 || $vopc==6) {
  $smarty->assign('subtitulo','Mantenimiento de Expediente / Modificaci&oacute;n Producci&oacute;n Fonogr&aacute;fica'); } 

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
//Verificando conexion
 $sql->connection($usuario);

// Obtención de los idiomas 
  $obj_query = $sql->query("SELECT * FROM $tbname_3 order by idioma");
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
  $obj_query = $sql->query("SELECT * FROM $tbname_10 order by nombre");
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
    mensajenew("AVISO: No introdujo ningún valor de Expediente ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); } 

  $res_obra = pg_exec("select * from $tbname_1 where solicitud='$vsol'");
  $nfil = pg_numrows($res_obra);
  if ($nfil>0) {
   mensajenew("AVISO: Solicitud $vsol ya existe en la Base de Datos ...!!!","javascript:history.back();","N");
   $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 

  //La Fecha de Hoy para la solicitud
  $fecha_solpf = hoy();
  $smarty->assign('fecha_solpf',$fecha_solpf);
  $smarty->assign('varfocus','forfonog.fecha_solpf');
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

  // Obtencion de los datos de la Produccion Fonografica  
  $obj_query = $sql->query("SELECT * FROM $tbname_1 WHERE solicitud='$vsol' AND tipo_obra='PF'");
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
  $fecha_solpf  = $objs->fecha_solic;
  $titulobr     = trim($objs->titulo_obra);
  $traduccion   = trim($objs->traduccion);
  $p_origen     = $objs->pais_origen;
  $pais_origen  = $objs->pais_origen;
  $cod_idioma   = $objs->cod_idioma;
  $idioma_orig  = $objs->cod_idioma;
  $annopripubli = $objs->anno_1publica;
  $n_ejemplares = $objs->n_ejemplares;  
  $tipo_soporte = trim($objs->tipo_soporte);
  $observacion  = trim($objs->observacion);
  $n_hojas_adic = $objs->n_hojas_adic;
  $datos_ampli  = trim($objs->datos_ampli);
  $datos_adicio = trim($objs->datos_adicio);
  $nu_planilla  = $objs->nplanilla;

  if ($n_hojas_adic==0) { $hojas_adicio = "N"; }
  else { $hojas_adicio = "S"; } 
    
  $valores_fields = array($vsol,$fecha_solpf,$titulobr,$traduccion,$p_origen,$cod_idioma,$annopripubli,$n_ejemplares,$tipo_soporte,$observacion,$n_hojas_adic,$datos_ampli,$nplanilla,$datos_adicio);
  $campos = "solicitud|fecha_solic|titulo_obra|traduccion|pais_origen|cod_idioma|anno_1publica|n_ejemplares|tipo_soporte|observacion|n_hojas_adic|datos_ampli|nplanilla|datos_adicio";
  $string = bitacora_fields();
  $smarty->assign('string',$string);
  $smarty->assign('campos',$campos);
  
  // Obtencion de los Datos de Fijacion 
  $obj_query = $sql->query("SELECT * FROM $tbname_14 WHERE nro_derecho='$vder'");
  if (!$obj_query) { 
    mensajenew("ERROR: Problema al intentar realizar la consulta en la tabla $tbname_14 ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
  $filas_found=$sql->nums('',$obj_query);
  //if ($filas_found==0) {
  //  mensajenew("NO EXISTEN DATOS ASOCIADOS ...!!!","javascript:history.back();","N");
  //  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 
  if ($filas_found!=0) {    $objs = $sql->objects('',$obj_query);
    $annofijacion  = $objs->anno_fijacion; }

  $valores_fields = array($vsol,$annofijacion);
  $campos14 = "solicitud|anno_fijacion";
  $string14 = bitacora_fields();
  $smarty->assign('string14',$string14);
  $smarty->assign('campos14',$campos14);

  // Obtencion de la Transferencia  
  $transferen = '';
  $obj_query = $sql->query("SELECT * FROM $tbname_15 WHERE nro_derecho='$vder'");
  if (!$obj_query) { 
    Mensajenew("ERROR: Problema al intentar realizar la consulta en la tabla $tbname_15 ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
  $filas_found=$sql->nums('',$obj_query);
  if ($filas_found==1) {
    $objs = $sql->objects('',$obj_query);
    $transferen = trim($objs->transferencia); 
  }
  $smarty->assign('string15',$transferen);

  // Obtencion de las Obras Fijadas     
  $del_datsol = $sql->del("stdtmpfie","solicitud='$vsol'");
  $obj_query = $sql->query("SELECT * FROM $tbname_2 WHERE nro_derecho='$vder'");
  if (!$obj_query) { 
    Mensajenew("ERROR: Problema al intentar realizar la consulta en la tabla $tbname_2 ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
  $filas_found=$sql->nums('',$obj_query);
  $objs = $sql->objects('',$obj_query);
  for($cont=0;$cont<$filas_found;$cont++) { 
    $codigo     = $objs->cod_obfinej;
    $titulo     = $objs->titulo_obfija; 
    $autor      = $objs->nombre_autor;
    $arreglista = $objs->arreglista;
    $interprete = $objs->interprete;
    $tipoobra   = $objs->tipo_obfija; 
    $col_campos = "solicitud,nro_obfinej,titulo_obfie,nombre_autor,arreglista,interprete,tipo_obfie";
    $insert_str = "'$vsol','$codigo','$titulo','$autor','$arreglista','$interprete','$tipoobra'";
    $ins_obrfie = $sql->insert("$tbname_18","$col_campos","$insert_str","");
    $objs = $sql->objects('',$obj_query);
  }
  
  // Obtencion del Solicitante 
  $del_datsol = $sql->del("stdtmpso","solicitud='$vsol'");
  $obj_query = $sql->query("SELECT * FROM $tbname_21,$tbname_7 WHERE $tbname_7.nro_derecho='$vder' AND $tbname_7.titular=$tbname_21.titular");
  if (!$obj_query) { 
    Mensajenew("ERROR: Problema al intentar realizar la consulta en la tabla $tbname_7 ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
  $filas_found=$sql->nums('',$obj_query);
  if ($filas_found > 0) {
    $objs = $sql->objects('',$obj_query);
    //$codigo        = $objs->doc_solicita;
    $codigo        = $objs->titular;
    $tipo_caracter = $objs->caracter;
    $otro_caracter = $objs->otro_caracter;
    $prueba_repres = $objs->prueba_repres;
    $recupera_int  = llenatemporal($tbname_7,$tbname_16,$codigo,$vsol); }

  // Obtencion del Productor 
  $del_datart = $sql->del("stdtmppt","solicitud='$vsol'");
  $obj_query = $sql->query("SELECT * FROM $tbname_13 WHERE $tbname_13.nro_derecho='$vder'");
  if (!$obj_query) { 
    mensajenew("ERROR: Problema al intentar realizar la consulta en la tabla $tbname_13 ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
  $filas_found=$sql->nums('',$obj_query);
  $objs = $sql->objects('',$obj_query);
  for($cont=0;$cont<$filas_found;$cont++) { 
    //$codigo       = $objs->doc_productor;
    $codigo       = $objs->titular;
    $recupera_int = llenatemporal($tbname_13,$tbname_17,$codigo,$vsol); 
    $objs = $sql->objects('',$obj_query);
  }

  $smarty->assign('modo','disabled'); 
  $smarty->assign('n_conex',$nconex); 

} // final de $vopc==6  


// ************************************************************************************ 
//Opcion Grabar...
if ($vopc==2) {
  $n_conex = $_POST['nconex'];

  // Código del Evento de Ingreso 
  $evento = 200;
  // La Fecha de Hoy y Hora para la transaccion
  $fechahoy = hoy();
  $horactual= Hora();
  
  // Verificación de que el Evento 200 de Carga Inicial existe 
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

  // Comparación de la fecha de Solicitud
  $esmayor=compara_fechas($fecha_solpf,$fechahoy);
  if ($esmayor==1) {
    mensajenew("AVISO: La Fecha de Solicitud No puede ser mayor a la de Hoy ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }

  // Verificacion de que los campos requeridos esten llenos...
  $req_fields = array("fecha_solpf","titulobr","pais","n_ejemplares","tipo_soporte");
  $valores = array($fecha_solpf,$titulobr,$p_origen,$n_ejemplares,$tipo_soporte);
  $vacios = check_empty_fields();
  if (!$vacios) { 
     mensajenew("AVISO: Hay Informacion en el formulario que esta Vacia ...!!!","javascript:history.back();","N");
     $smarty->display('pie_pag.tpl'); exit(); }

  if (empty($p_origen)) { 
    mensajenew("AVISO: Debe indicar Pais de la Firma ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }

  // Validación de que se le haya cargado el solicitante
  $resoli=pg_exec("SELECT * FROM stdtmpso where solicitud='$vsol'");
  $filas_solicita=pg_numrows($resoli); 
  if ($filas_solicita==0) {
    Mensajenew("AVISO: Expediente $vsol sin ningún Solicitante asociado ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }

  //// Validacion de Numero de Planilla
  //if (($accion=="I") || (($accion=="M") and ($nplanilla!=$nu_planilla))) {   
  //  $resplan=pg_exec("select * from $tbname_1 where nplanilla='$nplanilla'");
  //  $nfil=pg_numrows($resplan);
  //  if ($nfil>0) {
  //    mensajenew("Numero de Planilla $nplanilla ya existe en la Base de Datos ...!!!","javascript:history.back();","N");
  //    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
  //}
  
  //if (empty($nplanilla)) { $nplanilla=0; }
   
  $vtitulobr     = str_replace("'","´",$titulobr);
  $vtraduccion   = str_replace("'","´",$traduccion);  
  $vtransferen   = str_replace("'","´",$transferen);
  $vdatos_ampli  = str_replace("'","´",$datos_ampli);
  $vdatos_adicio = str_replace("'","´",$datos_adicio);
  
  if ($hojas_adicio=="N") { $n_hojas_adic=0; }
  if ($hojas_adicio=="S") {
    if (empty($vdatos_adicio)) {
      mensajenew("AVISO: Debe indicar la Informacion en la pestaña de Hojas Adicionales ...!!!","javascript:history.back();","N");
      $smarty->display('pie_pag.tpl'); exit(); }
  }

  if (empty($tipo_caracter)) {
      mensajenew("AVISO: Debe indicar el caracter en que actua el Solicitante ...!!!","javascript:history.back();","N");
      $smarty->display('pie_pag.tpl'); exit(); }

  if (empty($annopripubli)) { $annopripubli=0; }
  
  if ($accion=="I") { //Comienzo de INCLUIR   

    // Comienzo de Transaccion 
    pg_exec("BEGIN WORK");

    // Tabla Maestra de Obras 
    //$resula=pg_exec("select * from $tbname_1 where solicitud='$vsol'");
    //$rega= pg_fetch_array($resula);
    //$nfil=pg_numrows($resula);
    //if ($nfil>0) {
    //  mensajenew("AVISO: Solicitud $vsol ya existe en la Base de Datos ...!!!","a_obrpfono.php?vopc=3","N");
    //  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

    //Generacion del Numero de Derecho
    $obj_query = $sql->query("UPDATE stzsystem SET nro_derecho=nextval('stzsystem_nro_derecho_seq')");
    if ($obj_query) {
      $obj_query = $sql->query("SELECT last_value FROM stzsystem_nro_derecho_seq");
      $objs = $sql->objects('',$obj_query);
      $vder = $objs->last_value; }
  
    // La Hora actual para la transaccion
    $horactual= Hora();
  
    // Insertamos primero en la Tabla Maestra de Obras 
    $col_campos = "nro_derecho,solicitud,fecha_solic,titulo_obra,tipo_obra,traduccion,clase,origen,forma,cod_idioma,estatus,anno_1publica,pais_origen,n_ejemplares,tipo_soporte,observacion,n_hojas_adic,datos_ampli,datos_adicio,nplanilla";
    $insert_str = "'$vder','-','$fecha_solpf','$titulobr','PF','$vtraduccion','N','N','N','$cod_idioma',1,'$annopripubli','$p_origen','$n_ejemplares','$tipo_soporte','$vobservacion','$n_hojas_adic','$vdatos_ampli','$vdatos_adicio','$nplanilla'";
    $ins_obras = $sql->insert("$tbname_1","$col_campos","$insert_str","");

    // Insertamos en la Tabla de Tramite 
    $col_campos = "nro_derecho,evento,fecha_event,secuencial,estat_ant,fecha_trans,usuario,desc_evento,hora";
    $insert_str = "'$vder',200,'$fecha_solpf',nextval('stdevtrd_secuencial_seq'),0,'$fechahoy','$usuario','$vdescrip','$horactual'";
    $ins_tramite = $sql->insert("$tbname_9","$col_campos","$insert_str","");

    // Insertamos en la Tabla de Transferencia
    $ins_transf = true;
    if (!empty($vtransferen)) {  
      $col_campos = "nro_derecho,transferencia";
      $insert_str = "'$vder','$vtransferen'";
      $ins_transf = $sql->insert("$tbname_15","$col_campos","$insert_str","");
    }  

    if (empty($annofijacion)) { $annofijacion=0; } 
    // Insertamos en la Tabla correspondiente a Fijacion
    $col_campos = "nro_derecho,anno_fijacion,tipo_fijacion";
    $insert_str = "'$vder',$annofijacion,'S'";
    $ins_fijaci = $sql->insert("$tbname_14","$col_campos","$insert_str","");

    // Tabla de Obras Fijadas
    $ins_fie    = 0;
    $ins_obrfie = true; 
    $del_obrfie = true;
    pg_exec("LOCK TABLE stdtmpfie IN SHARE ROW EXCLUSIVE MODE");
    $res_fie=pg_exec("SELECT * FROM stdtmpfie where solicitud='$vsol'");
    $filas_res_fie=pg_numrows($res_fie); 
    $regfie = pg_fetch_array($res_fie);
    for($i=0;$i<$filas_res_fie;$i++) 
     { 
       $codigo=$regfie[nro_obfinej];
       $titulo = str_replace("'","´",$regfie[titulo_obfie]); 
       $autor = str_replace("'","´",$regfie[nombre_autor]);
       $arreglista = str_replace("'","´",$regfie[arreglista]);
       $interprete = str_replace("'","´",$regfie[interprete]);
       $tipoobra = $regfie[tipo_obfie];
       $col_campos = "nro_derecho,cod_obfinej,titulo_obfija,nombre_autor,arreglista,interprete,tipo_obfija";
       $insert_str = "'$vder','$codigo','$titulo','$autor','$arreglista','$interprete','$tipoobra'";
       $ins_obrfie = $sql->insert("$tbname_2","$col_campos","$insert_str","");
       if (!$ins_obrfie) { $ins_fie = $ins_fie + 1; } 
       $regfie = pg_fetch_array($res_fie);
     }
    $del_obrfie = $sql->del("stdtmpfie","solicitud='$vsol'");
  
    // Tabla de Solicitante
    $ins_sol = 0;
    $res_int=pg_exec("SELECT * FROM stdtmpso WHERE solicitud='$vsol'");
    $filas_int=pg_numrows($res_int); 
    if ($filas_int>0) {
      $ins_sol=guardar_interesado('Solicitante',$vsol,$vder,'U',$tipo_caracter,$otro_caracter,$prueba_repres); }
  
    // Tabla de Productor 
    $ins_pro = 0; 
    $res_int=pg_exec("SELECT * FROM stdtmppt where solicitud='$vsol'");
    $filas_int=pg_numrows($res_int); 
    if ($filas_int>0) {
      $ins_pro=guardar_interesado('Productor',$vsol,$vder,'V'); }

    // Verificacion y actualizacion real de los Datos en BD 

    if ($ins_obras AND $ins_tramite AND $ins_fijaci AND $ins_transf AND $ins_sol==0 AND $ins_pro==0 AND $ins_fie==0) {
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
             "a_obrpfononw.php?vopc=3","S"); } 
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
      if (!$ins_tramite) { $error_tramite= " - Tramite "; }
      if (!$ins_transf)  { $error_trans  = " - Transferencia "; }
      if (!$ins_fijaci)  { $error_datfij = " - Datos de Fijacion "; } 
      if ($ins_sol!=0)   { $error_datsol = " - Solicitante "; } 
      if ($ins_pro!=0)   { $error_datpro = " - Productor "; }
      if ($ins_fie!=0)   { $error_datfie = " - Obras Fijadas "; }

      Mensajenew("ERROR: Falla de Ingreso de Datos en la BD, Transacciones Abortadas, Error en datos asociados a: $error_obras $error_tramite $error_trans $error_datfij $error_datsol $error_datpro $error_datfie...!!!","javascript:history.back();","N");
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
    //$sql->insert("$tbname_19","","$insert_str","");

    // Se obtiene el proximo valor para el secuencial a guardar en stzbitac a partir de stzsistem
    //pg_exec("BEGIN WORK");
    //pg_exec("LOCK TABLE stzsystem IN SHARE ROW EXCLUSIVE MODE");
    //$sys_actual = next_sys("nbitaco");
    //$vsecuencial = grabar_sys("nbitaco",$sys_actual);
    //pg_exec("COMMIT WORK");
    
    // Almaceno registro original en Bitacora stzbitac
    //$insert_str = "'$vsecuencial','$fechahoy','$horactual','$usuario','$tbname_14','A','M','$vsol','$string14','$campos14'";
    //$sql->insert("$tbname_19","","$insert_str","");

    //Se obtiene el proximo valor para el secuencial a guardar en stzbider a partir de stzsistem para transferencia
    //pg_exec("BEGIN WORK");
    //pg_exec("LOCK TABLE stzsystem IN SHARE ROW EXCLUSIVE MODE");
    //$sys_actual = next_sys("nbitaco");
    //$vsecuencial = grabar_sys("nbitaco",$sys_actual);
    //pg_exec("COMMIT WORK");

    // Almaceno registro original en Bitacora stzbider
    //$insert_str = "'$vsecuencial','$fechahoy','$horactual','$usuario','$tbname_15','A','M','$vsol','$string15'";
    //$sql->insert("$tbname_20","","$insert_str","");

    // Comienzo de Transaccion 
    pg_exec("BEGIN WORK");

    // Actualizacion de Tabla Maestra de Obras 
    pg_exec("LOCK TABLE stdobras IN SHARE ROW EXCLUSIVE MODE");
    $update_str = "fecha_solic='$fecha_solpf',pais_origen='$p_origen',anno_1publica='$annopripubli',n_ejemplares='$n_ejemplares',
tipo_soporte='$tipo_soporte',observacion='$observacion',n_hojas_adic='$n_hojas_adic',datos_ampli='$vdatos_ampli',
datos_adicio='$vdatos_adicio',titulo_obra='$vtitulobr',traduccion='$vtraduccion',nplanilla='$nplanilla'";
    $act_obras = $sql->update("$tbname_1","$update_str","nro_derecho='$vder'");

    $ins_fijaci = true;
    $act_obfija = true;
    if (empty($annofijacion)) { $annofijacion=0; } 
    // Obtencion de los Datos de Fijacion 
    $obj_query = $sql->query("SELECT * FROM $tbname_14 WHERE nro_derecho='$vder'");
    $filas_found=$sql->nums('',$obj_query);
    if ($filas_found==0) {      // Insertamos en la Tabla correspondiente a Fijacion
      $col_campos = "nro_derecho,anno_fijacion,tipo_fijacion";
      $insert_str = "'$vder',$annofijacion,'S'";
      $ins_fijaci = $sql->insert("$tbname_14","$col_campos","$insert_str",""); }
    else {
      // Actualizacion de la Tabla correspondiente a Fijacion
      pg_exec("LOCK TABLE stdfijac IN SHARE ROW EXCLUSIVE MODE");
      $update_str = "anno_fijacion=$annofijacion";
      $act_obfija = $sql->update("$tbname_14","$update_str","nro_derecho='$vder'");
    }  

    // Actualizacion de Tabla de Transferencia  
    $act_trans = true;
    if (!empty($vtransferen)) {  
      pg_exec("LOCK TABLE stdtrans IN SHARE ROW EXCLUSIVE MODE");
      $update_str = "transferencia='$vtransferen'";
      $act_trans = $sql->update("$tbname_15","$update_str","nro_derecho='$vder'");
    }

    // Tabla de Obras Fijadas 
    $ins_fie = 0;
    $ins_obrfie = true; 
    $del_obrfie = true; 
    $del_tmpfie = true;
    $del_obrfie = $sql->del("stdfijin","nro_derecho='$vder'");     
    pg_exec("LOCK TABLE stdtmpfie IN SHARE ROW EXCLUSIVE MODE");
    $res_fie=pg_exec("SELECT * FROM stdtmpfie where solicitud='$vsol'");
    $filas_res_fie=pg_numrows($res_fie); 
    $regfie = pg_fetch_array($res_fie);
    for($i=0;$i<$filas_res_fie;$i++) 
     { 
       $codigo=$regfie[nro_obfinej];
       $titulo = str_replace("'","´",$regfie[titulo_obfie]); 
       $autor = str_replace("'","´",$regfie[nombre_autor]);
       $arreglista = str_replace("'","´",$regfie[arreglista]);
       $interprete = str_replace("'","´",$regfie[interprete]);
       $tipoobra = $regfie[tipo_obfie];
       $col_campos = "nro_derecho,cod_obfinej,titulo_obfija,nombre_autor,arreglista,interprete,tipo_obfija";
       $insert_str = "'$vder','$codigo','$titulo','$autor','$arreglista','$interprete','$tipoobra'";
       $ins_obrfie = $sql->insert("$tbname_2","$col_campos","$insert_str","");
       if (!$ins_obrfie) { $ins_fie = $ins_fie + 1; }  
       $regfie = pg_fetch_array($res_fie);
     }
    $del_tmpfie = $sql->del("stdtmpfie","solicitud='$vsol'");

    // Tabla de Productor
    $ins_pro = 0;
    $res_int=pg_exec("SELECT * FROM stdtmppt WHERE solicitud='$vsol'");
    $filas_int=pg_numrows($res_int); 
    if ($filas_int>0) {
      $del_obrpro = $sql->del("stdobpro","nro_derecho='$vder'");
      $ins_pro=guardar_interesado('Productor',$vsol,$vder,'V'); }

    // Tabla de Solicitante
    $ins_sol = 0;
    $res_int=pg_exec("SELECT * FROM stdtmpso WHERE solicitud='$vsol'");
    $filas_int=pg_numrows($res_int); 
    if ($filas_int>0) {
      $del_obrsol = $sql->del("stdobsol","nro_derecho='$vder'");
      $ins_sol=guardar_interesado('Solicitante',$vsol,$vder,'U',$tipo_caracter,$otro_caracter,$prueba_repres); }

    // Verificacion y actualizacion real de los Datos en BD 
    if ($act_obras AND $ins_fijaci AND $act_obfija and $act_trans and $ins_pro==0 and $ins_fie==0 and $ins_sol==0)  {
      pg_exec("COMMIT WORK");
      //Desconexion de la Base de Datos
      $sql->disconnect();
    }
    else {
      pg_exec("ROLLBACK WORK");
      //Desconexion de la Base de Datos
      $sql->disconnect();

      if (!$act_obras)    { $error_obras  = " - Obras "; } 
      if (!$act_obfija)   { $error_obfija = " - A&ntilde;o de Fijaci&oacute;n "; }    
      if (!$act_trans)    { $error_trans  = " - Transferencia "; }    
      if ($ins_sol!=0)    { $error_datsol = " - Solicitante "; } 
      if ($ins_pro!=0)    { $error_datpro = " - Productor "; }
      if ($ins_fie!=0)    { $error_datfie = " - Obras Fijadas "; } 

      mensajenew("ERROR: Falla de Actualizaci&oacute;n de Datos en la BD $error_obras $error_trans  $error_datsol $error_datpro $error_datfie ...!!!","javascript:history.back();","N");
      $smarty->display('pie_pag.tpl'); exit();
    }
  }
  
  //Desconexion de la Base de Datos
  //$sql->disconnect();

  if ($accion=="I") { 
    //Mensajenew("DATOS GUARDADOS CORRECTAMENTE ...!!!","a_obrpfononw.php?vopc=3&nconex=$n_conex&salir=1&conx=0","S");
  }
  else {
    Mensajenew("DATOS GUARDADOS CORRECTAMENTE ...!!!","a_obrpfononw.php?vopc=5&nconex=$n_conex&salir=1&conx=0","S"); }
  $smarty->display('pie_pag.tpl'); exit();
   
}

//Pase de variables y Etiquetas al template
$smarty->assign('campo1','Expediente No.:');
$smarty->assign('campo2','de Fecha:');
$smarty->assign('campo3','N&uacute;mero de Planilla:');
$smarty->assign('campo4','T&iacute;tulo:');
$smarty->assign('campo5','Pa&iacute;s de Origen:');
$smarty->assign('campo6','Idioma Original:');
$smarty->assign('campo7','Traducci&oacute;n al Castellano:');
$smarty->assign('campo8','A&ntilde;o de Fijaci&oacute;n:');
$smarty->assign('campo9','A&ntilde;o de Primera Publicaci&oacute;n:');
$smarty->assign('campo10','Nombre o Raz&oacute;n Social:');
$smarty->assign('campo11','Car&aacute;cter con el que Act&uacute;a:');
$smarty->assign('campo12','Otro Car&aacute;cter con el que Act&uacute;a:');
$smarty->assign('campo13','Prueba de Representaci&oacute;n o Transferencia de Derechos:');
$smarty->assign('campo14','Ejemplares Depositados:');
$smarty->assign('campo15','Tipo de Soporte Material:');
$smarty->assign('campo16','Observaciones:');
$smarty->assign('campo17','Incluye Hoja(s) Adicional(es):');
$smarty->assign('campo18','No. de Hoja(s) Adicional(es):');
$smarty->assign('campo19','Dato(s) ampliado(s) en la(s) Hoja(s) Adicional(es):');
$smarty->assign('campo20','T&iacute;tulo de Obra Fijada:');
$smarty->assign('campo21','C&oacute;digo de Obra:');

$smarty->assign('vopc',$vopc);
$smarty->assign('vsol1',$vsol);
$smarty->assign('vder',$vder);
$smarty->assign('usuario',$usuario);
$smarty->assign('accion',$accion);
$smarty->assign('titulobr',$titulobr);
$smarty->assign('traduccion',$traduccion);
$smarty->assign('fecha_solpf',$fecha_solpf);
$smarty->assign('estatus',$estatus);
$smarty->assign('nplanilla',$nplanilla);
$smarty->assign('nu_planilla',$nu_planilla);
$smarty->assign('pais_origen',$pais_origen); 
$smarty->assign('p_origen',$p_origen);
$smarty->assign('pais_origen',$p_origen);
$smarty->assign('pais',$p_origen);
$smarty->assign('idioma_orig',$idioma_orig);
$smarty->assign('cod_idioma',$cod_idioma);
$smarty->assign('idioma',$cod_idioma);
$smarty->assign('annofijacion',$annofijacion); 
$smarty->assign('annopripubli',$annopripubli); 
$smarty->assign('tipo_caracter',$tipo_caracter); 
$smarty->assign('otro_caracter',$otro_caracter);  
$smarty->assign('prueba_repres',$prueba_repres); 
$smarty->assign('n_ejemplares',$n_ejemplares); 
$smarty->assign('tipo_soporte',$tipo_soporte);
$smarty->assign('observacion',$observacion); 
$smarty->assign('hojas_adicio',$hojas_adicio);
$smarty->assign('n_hojas_adic',$n_hojas_adic); 
$smarty->assign('datos_ampli',$datos_ampli); 
$smarty->assign('datos_adicio',$datos_adicio); 
$smarty->assign('transferen',$transferen); 
$smarty->assign('arraycodpais',$arraycodpais);
$smarty->assign('arraynompais',$arraynompais);
$smarty->assign('arraycodidiom',$arraycodidiom);
$smarty->assign('arraynomidiom',$arraynomidiom);

$smarty->display('a_obrpfononw.tpl');
$smarty->display('pie_pag.tpl');
?>
