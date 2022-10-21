<script language="JavaScript">

function pregunta() { 
  return confirm('Estas seguro de grabar la Informacion ?'); }

function browsesolicitante(var1,var2,var3) {
  this.interesado='Solicitante';
  open("adm_solobra.php?vsol="+var1.value+"&vtex="+var2.value+"&vmod="+var3.value+"&vtip="+this.interesado,"Ventana", "scrollbars=yes,toolbar=no,directories=no,menubar=no,status=no"); }

function browsetitular(var1,var2,var3) {
  this.interesado='Titular';
  open("adm_solobra.php?vsol="+var1.value+"&vtex="+var2.value+"&vmod="+var3.value+"&vtip="+this.interesado,"Ventana", "scrollbars=yes,toolbar=no,directories=no,menubar=no,status=no"); }

function browseartista(var1,var2,var3) {
  this.interesado='Artista';
  open("d_opinsoli.php?vsol="+var1.value+"&vtex="+var2.value+"&vmod="+var3.value+"&vtip="+this.interesado,"Ventana", "scrollbars=yes,toolbar=no,directories=no,menubar=no,status=no"); }

function browseobfie(var1,var2,var3) {
  this.interesado='Interpretada';
  open("d_opinobfie.php?vsol="+var1.value+"&vtex="+var2.value+"&vmod="+var3.value+"&vtip="+this.interesado,"Ventana", "scrollbars=yes,toolbar=no,directories=no,menubar=no,status=no"); }

</script> 

<?php
// *************************************************************************************
// Programa: a_obraieanw.php 
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
$modulo  = "a_obraieanw.php";

// Definicion de tablas 
$tbname_1 = "stdobras";
$tbname_2 = "stdfijin";
$tbname_3 = "stdidiom";
$tbname_4 = "stzdaper";
$tbname_5 = "stzdajur";
$tbname_6 = "stdrepre";
$tbname_7 = "stdobsol";
$tbname_8 = "stdstobr";
$tbname_9 = "stdevtrd";
$tbname_10 = "stzpaisr";
$tbname_11 = "stzusuar";
$tbname_12 = "stdevobr";
$tbname_13 = "stdobart";
$tbname_14 = "stdfijac";
$tbname_15 = "stdgrupo";
$tbname_16 = "stdtrans";
$tbname_17 = "stdobtit";
$tbname_18 = "stdgener";
$tbname_19 = "stdtmpso";
$tbname_20 = "stdtmpar";
$tbname_21 = "stdtmpti";
$tbname_22 = "stdtmpfie";
$tbname_23 = "stzsolic";
$tbname_24 = "stzbitac";
$tbname_25 = "stzbider";

// Obtencion de variables de los campos del tpl 
$vopc   = $_GET['vopc'];
$conx   = $_GET['conx']; 
$nconex = $_GET['nconex'];
$salir  = $_GET['salir']; 

$vsol         =$_POST['vsol1'];
$vder         =$_POST['vder'];
$accion       =$_POST['accion'];
//$nplanilla    =$_POST['nplanilla'];
$nu_planilla  =$_POST['nu_planilla'];
$fecha_solie  =$_POST['fecha_solie'];
$nbgrupo      =$_POST['nbgrupo'];
$tipo_grupo   =$_POST['tipo_grupo'];
$tgrupo       =$_POST['tgrupo'];
$director     =$_POST['director'];
$doc_cedula   =$_POST['doc_cedula'];
$dir_cedula   =$_POST['dir_cedula'];
$domicilio    =$_POST['domicilio'];
$pais_origen  =$_POST['pais_origen'];
$p_origen     =$_POST['p_origen'];
$ntelefono    =$_POST['ntelefono'];
$nfax         =$_POST['nfax'];
$tipo_fijacion=$_POST['tipo_fijacion'];
$annofijacion =$_POST['annofijacion'];  
$annopripubli =$_POST['annopripubli'];
$otrosdatos   =$_POST['otrosdatos'];
$tipo_caracter=$_POST['tipo_caracter'];
$otro_caracter=$_POST['otro_caracter'];
$prueba_repres=$_POST['prueba_repres'];
$n_ejemplares =$_POST['n_ejemplares'];
$tipo_soporte =$_POST['tipo_soporte'];
$observacion  =$_POST['observacion'];
$hojas_adicio =$_POST['hojas_adicio'];
$n_hojas_adic =$_POST['n_hojas_adic'];
$datos_ampli  =$_POST['datos_ampli'];
$datos_adicio =$_POST['datos_adicio'];
$transferen   =$_POST['transferen'];
$string       =$_POST['string']; 
$campos       =$_POST['campos']; 
$string4      =$_POST['string4']; 
$campos4      =$_POST['campos4']; 
$string14     =$_POST['string14']; 
$campos14     =$_POST['campos14']; 
$string15     =$_POST['string15']; 
$campos15     =$_POST['campos15']; 
$string16     =$_POST['string16']; 
$horactual     =date("h:i:s");
$nplanilla     =substr($_POST['vsol1'],0,6);

// ************************************************************************************  
$smarty->assign('titulo',$substaut);
$smarty->assign('subtitulo','Interpretaciones y Ejecuciones Art&iacute;sticas');
if ($vopc==3 || $vopc==4) {
  $smarty->assign('subtitulo','Ingreso de Solicitud / Interpretaciones y Ejecuciones Art&iacute;sticas'); }
if ($vopc==5 || $vopc==6) {
  $smarty->assign('subtitulo','Mantenimiento de Expediente / Modificaci&oacute;n Interpretaciones y Ejecuciones Art&iacute;sticas'); } 

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
$smarty->assign('tipo_fija',array(S,A));
$smarty->assign('fija_def',array('Sonora','Audiovisual'));

// ************************************************************************************  
// Control de acceso: Entrada y Salida al Modulo 
if ($conx==0) { 
  $smarty->assign('n_conex',$nconex);      }
else {
  if ($vopc == 3) { $opra='I'; }
  if ($vopc == 5) { $opra='M'; }
  $res_conex = insconex($usuario,$modulo,$opra);
  $smarty->assign('n_conex',$res_conex);   }

//if (($salir==0) && ($nconex>0)) {
//  $logout = salirconx($nconex);
//}

// ************************************************************************************  
// Verificando conexion
 $sql->connection($usuario);

// Obtención de los Paises
 $obj_query = $sql->query("SELECT * FROM $tbname_10 ORDER BY nombre");
 if (!$obj_query) { 
   mensajenew("Problema al intentar realizar la consulta en la tabla $tbname_10 ...!!!","javascript:history.back();","N");
   $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
 $filas_found=$sql->nums('',$obj_query);
 if ($filas_found==0) {
   mensajenew("La Tabla de Paises esta Vacia ...!!!","javascript:history.back();","N");
   $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 
  
 $cont = 0;
 $arraycodpais[$cont]=0;
 $arraynompais[$cont]='';
 $objs = $sql->objects('',$obj_query);
 for($cont=1;$cont<=$filas_found;$cont++) { 
   $arraycodpais[$cont]=$objs->pais;
   $arraynompais[$cont]=trim($objs->nombre);
   $objs = $sql->objects('',$obj_query);  }

// Obtención de los Generos 
 $obj_query = $sql->query("SELECT * FROM $tbname_18 ORDER BY desc_genero");
 if (!$obj_query) { 
   mensajenew("Problema al intentar realizar la consulta en la tabla $tbname_18 ...!!!","javascript:history.back();","N");
   $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
 $filas_found=$sql->nums('',$obj_query);
 if ($filas_found==0) {
   mensajenew("La Tabla de Generos esta Vacia ...!!!","javascript:history.back();","N");
   $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 

 $cont = 0;
 $arrcodgener[$cont]=0;
 $arrnomgener[$cont]='';
 $objs = $sql->objects('',$obj_query);
 for($cont=1;$cont<=$filas_found;$cont++) { 
   $arrcodgener[$cont]=$objs->cod_genero;
   $arrnomgener[$cont]=trim($objs->desc_genero);
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
    mensajenew("No introdujo ningún valor de Expediente ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); } 

  $res_obra = pg_exec("SELECT * FROM $tbname_1 WHERE solicitud='$vsol'");
  $nfil = pg_numrows($res_obra);
  if ($nfil>0) {
   mensajenew("Solicitud $vsol ya existe en la Base de Datos ...!!!","javascript:history.back();","N");
   $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 

  //La Fecha de Hoy para la solicitud
  $fecha_solie = hoy();
  $smarty->assign('fecha_solie',$fecha_solie);
  $smarty->assign('varfocus','forobfie.fecha_solie');
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
    mensajenew("No introdujo ningún valor de Expediente ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); } 

  // Obtencion de los Datos de la Interpretacion y Ejecucion Artistica 
  $obj_query = $sql->query("SELECT * FROM $tbname_1 WHERE solicitud='$vsol' AND tipo_obra='IE'");
  if (!$obj_query) { 
    mensajenew("Problema al intentar realizar la consulta en la tabla $tbname_1 ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
  $filas_found=$sql->nums('',$obj_query);

  if ($filas_found==0) {
    mensajenew("NO EXISTEN DATOS ASOCIADOS ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 

  $objs = $sql->objects('',$obj_query);
  $vder         = $objs->nro_derecho;
  $nplanilla    = $objs->nplanilla;
  $fecha_solie  = $objs->fecha_solic;
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
    
  //$valores_fields = array($vsol,$fecha_solie,$annopripubli,$n_ejemplares,$tipo_soporte,$observacion,$n_hojas_adic,$datos_ampli,$nplanilla,$datos_adicio);
  //$campos = "solicitud|fecha_solic|anno_1publica|n_ejemplares|tipo_soporte|observacion|n_hojas_adic|datos_ampli|nplanilla|datos_adicio";
  //$string = bitacora_fields();
  //$smarty->assign('string',$string);
  //$smarty->assign('campos',$campos);
  
  // Obtencion de los Datos del Grupo 
  $obj_query = $sql->query("SELECT * FROM $tbname_15 WHERE nro_derecho='$vder'");
  if (!$obj_query) { 
    mensajenew("Problema al intentar realizar la consulta en la tabla $tbname_15 ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
  $filas_found=$sql->nums('',$obj_query);
  if ($filas_found==0) {
    mensajenew("NO EXISTEN DATOS ASOCIADOS ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 

  $objs = $sql->objects('',$obj_query);
  $nbgrupo      = trim($objs->nombre_grupo);
  $tipo_grupo   = $objs->tipo_agrupa;
  $doc_director = $objs->doc_director;
  $domicilio    = trim($objs->domicilio);
  $pais_origen  = $objs->pais_resid;
  $p_origen     = $objs->pais_resid;

  //$valores_fields = array($vsol,$nbgrupo,$tipo_grupo,$doc_director,$domicilio,$pais_origen);
  //$campos15 = "solicitud|nombre_grupo|tipo_grupo|doc_director|domicilio|pais_resid";
  //$string15 = bitacora_fields();
  //$smarty->assign('string15',$string15);
  //$smarty->assign('campos15',$campos15);
  
  // Obtencion de los Datos del Director 
  $obj_query = $sql->query("SELECT * FROM $tbname_4,$tbname_23 WHERE $tbname_23.identificacion='$doc_director' AND $tbname_4.titular=$tbname_23.titular");
  if (!$obj_query) { 
    mensajenew("Problema al intentar realizar la consulta en la tabla $tbname_4 ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
  $filas_found=$sql->nums('',$obj_query);
  if ($filas_found==0) {
    mensajenew("NO EXISTEN DATOS ASOCIADOS ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 

  $objs = $sql->objects('',$obj_query);
  $director    = trim($objs->nombre);
  $doc_cedula  = $objs->identificacion;
  $dir_cedula  = $objs->identificacion;
  $codtit      = $objs->titular;
  $ntelefono   = $objs->telefono1;
  $ntelefon2   = $objs->telefono2;
  $nfax        = $objs->fax;
  $nmail       = $objs->email;
  
  //$valores_fields = array($doc_cedula,$director,$ntelefon1,$ntelefon2,$nfax,$nmail);
  //$campos4 = "cedula|nombre|telefono1|telefono2|fax|email";
  //$string4 = bitacora_fields();
  //$smarty->assign('string4',$string4);
  //$smarty->assign('campos4',$campos4);

  // Obtencion de los Datos de Fijacion 
  $obj_query = $sql->query("SELECT * FROM $tbname_14 WHERE nro_derecho='$vder'");
  if (!$obj_query) { 
    Mensajenew("Problema al intentar realizar la consulta en la tabla $tbname_14 ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
  $filas_found=$sql->nums('',$obj_query);
  if ($filas_found==0) {
    Mensajenew("NO EXISTEN DATOS ASOCIADOS ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 

  $objs = $sql->objects('',$obj_query);
  $annofijacion  = $objs->anno_fijacion;
  $tipo_fijacion = $objs->tipo_fijacion;
  $otrosdatos    = trim($objs->ficha_datos);

  //$valores_fields = array($vsol,$annofijacion,$tipo_fijacion,$otrosdatos);
  //$campos14 = "solicitud|anno_fijacion|tipo_fijacion|ficha_datos";
  //$string14 = bitacora_fields();
  //$smarty->assign('string14',$string14);
  //$smarty->assign('campos14',$campos14);

  // Obtencion de la Transferencia  
  $transferen = '';
  $obj_query = $sql->query("SELECT * FROM $tbname_16 WHERE nro_derecho='$vder'");
  if (!$obj_query) { 
    mensajenew("Problema al intentar realizar la consulta en la tabla $tbname_16 ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
  $filas_found=$sql->nums('',$obj_query);
  if ($filas_found==1) {
    $objs = $sql->objects('',$obj_query);
    $transferen = trim($objs->transferencia); 
  }
  $smarty->assign('string16',$transferen);

  // Obtencion de las Obras Interpretadas o Ejecutadas    
  
  $del_datsol = $sql->del("stdtmpfie","solicitud='$vsol'");
  $obj_query = $sql->query("SELECT * FROM $tbname_2 WHERE nro_derecho='$vder'");
  if (!$obj_query) { 
    Mensajenew("Problema al intentar realizar la consulta en la tabla $tbname_2 ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
  $filas_found=$sql->nums('',$obj_query);
  $objs = $sql->objects('',$obj_query);
  for($cont=0;$cont<$filas_found;$cont++) { 
    $codigo     = $objs->cod_obfinej;
    $titulo     = $objs->titulo_obfija; 
    $autor      = $objs->nombre_autor;
    $tipoobra   = $objs->tipo_obfija; 
    $col_campos = "solicitud,nro_obfinej,titulo_obfie,nombre_autor,tipo_obfie";
    $insert_str = "'$vsol','$codigo','$titulo','$autor','$tipoobra'";
    $ins_obrfie = $sql->insert("$tbname_22","$col_campos","$insert_str","");
    $objs = $sql->objects('',$obj_query);
  }
  
  // Obtencion del Solicitante 
  $del_datsol = $sql->del("stdtmpso","solicitud='$vsol'");
  $obj_query = $sql->query("SELECT * FROM $tbname_7 WHERE nro_derecho='$vder'");
  if (!$obj_query) { 
    mensajenew("Problema al intentar realizar la consulta en la tabla $tbname_7 ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
  $filas_found=$sql->nums('',$obj_query);
  if ($filas_found > 0) {
    $objs = $sql->objects('',$obj_query);
    //$codigo        = $objs->doc_solicita;
    $codigo        = $objs->titular;
    $tipo_caracter = $objs->caracter;
    $otro_caracter = $objs->otro_caracter;
    $prueba_repres = $objs->prueba_repres;
    $recupera_int  = llenatemporal($tbname_7,$tbname_19,$codigo,$vsol); }

  // Obtencion del Artista
  $del_datart = $sql->del("stdtmpar","solicitud='$vsol'");
  
  $obj_query = $sql->query("SELECT * FROM $tbname_13 WHERE nro_derecho='$vder'");
  if (!$obj_query) { 
    mensajenew("Problema al intentar realizar la consulta en la tabla $tbname_13 ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
  $filas_found=$sql->nums('',$obj_query);
  $objs = $sql->objects('',$obj_query);
  for($cont=0;$cont<$filas_found;$cont++) { 
    //$codigo       = $objs->doc_artista;
    $codigo       = $objs->titular;
    $recupera_int = llenatemporal($tbname_13,$tbname_20,$codigo,$vsol); 
    $objs = $sql->objects('',$obj_query);
  }

  // Obtencion del Titular 
  $del_datart = $sql->del("stdtmpti","solicitud='$vsol'");
 
  $obj_query = $sql->query("SELECT * FROM $tbname_17 WHERE nro_derecho='$vder'");
  if (!$obj_query) { 
    mensajenew("Problema al intentar realizar la consulta en la tabla $tbname_17 ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
  $filas_found=$sql->nums('',$obj_query);
  if ($filas_found > 0) {
    $objs = $sql->objects('',$obj_query);
    //$codigo       = $objs->doc_titular;
    $codigo       = $objs->titular;
    $recupera_int = llenatemporal($tbname_17,$tbname_21,$codigo,$vsol); }

  $smarty->assign('modo','disabled'); 
  $smarty->assign('n_conex',$nconex); 

} // final de $vopc==6  

// ************************************************************************************ 
// Opcion Grabar...
if ($vopc==2) {
  $n_conex = $_POST['nconex'];
    
  // Código del Evento de Ingreso 
  $evento = 200;
  // La Fecha de Hoy y Hora para la transaccion
  $fechahoy = hoy();

  // Verificación de que el Evento 200 de Carga Inicial existe 
  $resultado=pg_exec("SELECT * FROM $tbname_12 WHERE evento=200");
  if (!$resultado) { 
    mensajenew("Código de Evento NO existe en la Base de Datos ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
  $filas_found=pg_numrows($resultado); 
  if ($filas_found==0) {
    mensajenew("No existen Datos asociados al Evento ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 
  $regeve = pg_fetch_array($resultado);
  $vdescrip=trim($regeve['mensa_automatico']);
  $comentario="";

  // Comparación de la fecha de Solicitud
  $esmayor=compara_fechas($fecha_solie,$fechahoy);
  if ($esmayor==1) {
    mensajenew("La Fecha de Solicitud No puede ser mayor a la de Hoy ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }

  // Verificacion de que los campos requeridos esten llenos...
  $req_fields = array("fecha_solie","nbgrupo","tipo_grupo","director","doc_cedula","domicilio","pais","tipo_fijacion","annofijacion","annopripubli");
  $valores = array($fecha_solie,$nbgrupo,$tipo_grupo,$director,$doc_cedula,$domicilio,$p_origen,$tipo_fijacion,$annofijacion,$annopripubli);
  $vacios = check_empty_fields();
  if (!$vacios) { 
     mensajenew("Hay Informacion asociada a GRUPO/DAT que esta Vacia ...!!!","javascript:history.back();","N");
     $smarty->display('pie_pag.tpl'); exit(); }

  $req_fields = array("n_ejemplares","tipo_soporte","hojas_adicio"); 
  $valores = array($n_ejemplares,$tipo_soporte,$hojas_adicio);
  $vacios = check_empty_fields();
  if (!$vacios) { 
     mensajenew("Hay Informacion asociada al DEPOSITO que esta Vacia ...!!!","javascript:history.back();","N");
     $smarty->display('pie_pag.tpl'); exit(); }

  if (empty($tipo_caracter)) {
      mensajenew("Debe indicar el caracter en que actua el Solicitante ...!!!","javascript:history.back();","N");
      $smarty->display('pie_pag.tpl'); exit(); }

  $annno= Obtener_anno($fecha_solie,0);
  if ($annofijacion > $annno) { 
    mensajenew("El A&ntilde;o de Fijaci&oacute;n No puede ser Mayor a la Fecha de Solicitud ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit();  }

  if ($annopripubli > $annno) {
    mensajenew("El A&ntilde;o de Publicaci&oacute;n No puede ser Mayor a la Fecha de Solicitud ...!!!","javascript:history.back();","N"); 
    $smarty->display('pie_pag.tpl'); exit();  }

  //// Validacion de Numero de Planilla
  //if (($accion=="I") || (($accion=="M") and ($nplanilla!=$nu_planilla))) { 
  //  $resplan=pg_exec("select * from $tbname_1 where nplanilla='$nplanilla'");
  //  $nfil=pg_numrows($resplan);
  //  if ($nfil>0) {
  //    mensajenew("Numero de Planilla $nplanilla ya existe en la Base de Datos ...!!!","javascript:history.back();","N");
  //    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
  //}  

  // Validación de que se le haya cargado el solicitante
  $resoli=pg_exec("SELECT * FROM stdtmpso where solicitud='$vsol'");
  $filas_solicita=pg_numrows($resoli); 
  if ($filas_solicita==0) {
    mensajenew("Expediente $vsol sin ningún Solicitante asociado ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }

  // Validación de que se le haya cargado el Artista
  $resart=pg_exec("SELECT * FROM stdtmpar where solicitud='$vsol'");
  $filas_artista=pg_numrows($resart); 
  if ($filas_artista==0) {
    mensajenew("Expediente $vsol sin ningún Artista asociado ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }

  // Validación de que se le haya cargado alguna obra Interpretada o Ejecutada 
  $resfie=pg_exec("SELECT * FROM stdtmpfie where solicitud='$vsol'");
  $filas_obfie=pg_numrows($resfie); 
  if ($filas_obfie==0) {
    mensajenew("Expediente $vsol sin ninguna Obra Interpretada o Ejecutada asociado ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }

  //if (empty($nplanilla)) { $nplanilla = 0; }
  
  $vnbgrupo      = str_replace("'","´",$nbgrupo);
  $vtipo_grupo   = str_replace("'","´",$tipo_grupo);
  $vdirector     = str_replace("'","´",$director);
  $vdomicilio    = str_replace("'","´",$domicilio);
  $vobservacion  = str_replace("'","´",$observacion);
  $vtransferen   = str_replace("'","´",$transferen);
  $vdatos_ampli  = str_replace("'","´",$datos_ampli);
  $vdatos_adicio = str_replace("'","´",$datos_adicio);
  $votros_datos  = str_replace("'","´",$otrosdatos);
  
  if ($hojas_adicio=="N") { $n_hojas_adic = 0; }
  if ($hojas_adicio=="S") {
    if ($n_hojas_adic==0) {
      mensajenew("Debe indicar el No. de Hojas Adicionales en la pestaña DEPOSITO ...!!!","javascript:history.back();","N");
      $smarty->display('pie_pag.tpl'); exit(); }
    if (empty($vdatos_ampli)) {
      mensajenew("Debe indicar la Informacion en los Datos Ampliados en la pestaña DEPOSITO ...!!!","javascript:history.back();","N");
      $smarty->display('pie_pag.tpl'); exit(); }
    if (empty($vdatos_adicio)) {
      mensajenew("Debe indicar la Informacion en la pestaña de Hojas Adicionales ...!!!","javascript:history.back();","N");
      $smarty->display('pie_pag.tpl'); exit(); }
  }

  if ($accion=="I") { //Comienzo de INCLUIR   

    // Comienzo de Transaccion 
    pg_exec("BEGIN WORK");

    // Tabla Maestra de Obras 
    $resula=pg_exec("select * from $tbname_1 WHERE solicitud='$vsol'");
    $rega= pg_fetch_array($resula);
    $nfil=pg_numrows($resula);
    if ($nfil>0) {
      mensajenew("Solicitud $vsol ya existe en la Base de Datos ...!!!","a_obrpfono.php?vopc=3","N");
      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
  
    //Generacion del Numero de Derecho
    $obj_query = $sql->query("UPDATE stzsystem SET nro_derecho=nextval('stzsystem_nro_derecho_seq')");
    if ($obj_query) {
      $obj_query = $sql->query("SELECT last_value FROM stzsystem_nro_derecho_seq");
      $objs = $sql->objects('',$obj_query);
      $vder = $objs->last_value; }

    $titulobr='';
    $cod_idioma="CA";
    // La Hora actual para la transaccion
    $horactual= Hora();
      
    // Insertamos primero en la Tabla Maestra de Obras 
    $col_campos = "nro_derecho,solicitud,fecha_solic,titulo_obra,tipo_obra,clase,origen,forma,cod_idioma,estatus,pais_origen,anno_1publica,n_ejemplares,tipo_soporte,observacion,n_hojas_adic,datos_ampli,datos_adicio,nplanilla";
    $insert_str = "'$vder','-','$fecha_solie','$titulobr','IE','N','N','N','$cod_idioma',1,'$p_origen','$annopripubli','$n_ejemplares','$tipo_soporte','$vobservacion','$n_hojas_adic','$vdatos_ampli','$vdatos_adicio','$nplanilla'";
    $ins_obras = $sql->insert("$tbname_1","$col_campos","$insert_str","");

    $ins_datsol = true;
    $ins_datper = true;
    // Insertamos en la Tabla de Grupo, Orquesta Musical, Vocales y Otros
    $res_dir=pg_exec("SELECT * FROM stzsolic WHERE identificacion='$doc_cedula'");
    $filas_direc=pg_numrows($res_dir);  
    if ($filas_direc==0) {
      $col_campos = "identificacion,nombre,indole,telefono1,fax";
      $insert_str = "'$doc_cedula','$director','N','$ntelefono','$nfax'";
      $ins_datsol = $sql->insert("$tbname_23","$col_campos","$insert_str","");
      $res_vtitu=pg_exec("SELECT last_value FROM stzsolic_titular_seq"); 
      $reg_vtitu = pg_fetch_array($res_vtitu); 
      $vtit=$reg_vtitu[last_value];
      $col_campos = "titular,estado_civil";
      $insert_str = "'$vtit','S'";
      $ins_datper = $sql->insert("$tbname_4","$col_campos","$insert_str","");
    }  
    else {
      $reg_vtitu = pg_fetch_array($res_dir); 
      $vtit=$reg_vtitu[titular];
    }
    $col_campos = "nro_derecho,nombre_grupo,tipo_agrupa,doc_director,titular,domicilio,pais_resid";
    $insert_str = "'$vder','$vnbgrupo','$vtipo_grupo','$doc_cedula','$vtit','$domicilio','$p_origen'";
    $ins_grupo = $sql->insert("$tbname_15","$col_campos","$insert_str","");

    // Insertamos en la Tabla de Transferencia
    $ins_transf = true;
    if (!empty($vtransferen)) {  
      $col_campos = "nro_derecho,transferencia";
      $insert_str = "'$vder','$vtransferen'";
      $ins_transf = $sql->insert("$tbname_16","$col_campos","$insert_str","");
    }  
  
    // Insertamos en la Tabla correspondiente a Fijacion
    $col_campos = "nro_derecho,anno_fijacion,tipo_fijacion,ficha_datos";
    $insert_str = "'$vder','$annofijacion','$tipo_fijacion','$votros_datos'";
    $ins_fijaci = $sql->insert("$tbname_14","$col_campos","$insert_str","");
  
    // Insertamos en la Tabla de Tramite 
    $col_campos = "nro_derecho,evento,fecha_event,secuencial,estat_ant,fecha_trans,usuario,desc_evento,hora";
    $insert_str = "'$vder',200,'$fecha_solie',DEFAULT,0,'$fechahoy','$usuario','$vdescrip','$horactual'";
    $ins_tramit = $sql->insert("$tbname_9","$col_campos","$insert_str","");

    // Tabla de Obras Interpretadas o Ejecutadas 
    $ins_fie    = 0;
    $ins_obrfie = true; 
    $del_obrfie = true; 
    $res_fie=pg_exec("SELECT * FROM stdtmpfie WHERE solicitud='$vsol'");
    $filas_res_fie=pg_numrows($res_fie); 
    $regfie = pg_fetch_array($res_fie);
    for($i=0;$i<$filas_res_fie;$i++) 
     { 
       $codigo     = $regfie[nro_obfinej];
       $titulo     = str_replace("'","´",$regfie[titulo_obfie]); 
       $autor      = str_replace("'","´",$regfie[nombre_autor]);
       $tipoobra   = $regfie[tipo_obfie];
       $col_campos = "nro_derecho,cod_obfinej,titulo_obfija,nombre_autor,tipo_obfija,interprete";
       $insert_str = "'$vder','$codigo','$titulo','$autor','$tipoobra','$vnbgrupo'";
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

    // Tabla de Artistas
    $ins_art = 0;
    $res_int=pg_exec("SELECT * FROM stdtmpar WHERE solicitud='$vsol'");
    $filas_int=pg_numrows($res_int); 
    if ($filas_int>0) {
      $ins_art=guardar_interesado('Artista',$vsol,$vder,'V'); }
      
    // Tabla de Titulares
    $ins_tit = 0; 
    $res_int=pg_exec("SELECT * FROM stdtmpti WHERE solicitud='$vsol'"); 
    $filas_int=pg_numrows($res_int); 
    if ($filas_int>0) {
      $ins_tit=guardar_interesado('Titular',$vsol,$vder,'V'); }

    if ($ins_obras and $ins_tramit and $ins_grupo and $ins_transf and $ins_fijaci and $ins_datper and $ins_fie==0 and $ins_sol==0 and $ins_art==0 and $ins_tit==0) {
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
             "a_obraieanw.php?vopc=3","S"); }
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
      // Desconexion de la Base de Datos
      $sql->disconnect();

      if (!$ins_obras)  { $error_obras  = " - Obras "; } 
      if (!$ins_tramit) { $error_tramit = " - Tramite "; }
      if (!$ins_grupo)  { $error_grupo  = " - Grupo/Orquesta "; }
      if (!$ins_transf) { $error_trans  = " - Transferencia "; }    
      if (!$ins_datper) { $error_datper = " - Director "; }
      if (!$ins_fijaci) { $error_datfij = " - Tipo de Fijacion "; } 
      if ($ins_sol!=0)  { $error_datsol = " - Solicitante "; } 
      if ($ins_art!=0)  { $error_datart = " - Artistas "; }
      if ($ins_tit!=0)  { $error_dattit = " - Titular "; } 
      if ($ins_fie!=0)  { $error_datfie = " - Obras Interpretadas/Ejecutadas "; }

      Mensajenew("Falla de Ingreso de Datos en la BD, Transacciones Abortadas, Error en datos asociados a: $error_obras $error_grupo $error_tramit $error_datper $error_datsol $error_datrep $error_dattit $error_datfij $error_datfie $error_trans ...!!!","javascript:history.back();","N");
      $smarty->display('pie_pag.tpl'); exit();    
    }
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
    
    // Almaceno registro original en Bitacora
    //$insert_str = "'$vsecuencial','$fechahoy','$horactual','$usuario','$tbname_1','A','M','$vsol','$string','$campos'";
    //$sql->insert("$tbname_23","","$insert_str","");

    // Se obtiene el proximo valor para el secuencial a guardar en stzbitac a partir de stzsistem
    //pg_exec("BEGIN WORK");
    //pg_exec("LOCK TABLE stzsystem IN SHARE ROW EXCLUSIVE MODE");
    //$sys_actual = next_sys("nbitaco");
    //$vsecuencial = grabar_sys("nbitaco",$sys_actual);
    //pg_exec("COMMIT WORK");
    
    // Almaceno registro original en Bitacora
    //$insert_str = "'$vsecuencial','$fechahoy','$horactual','$usuario','$tbname_4','A','M','$vsol','$string4','$campos4'";
    //$sql->insert("$tbname_23","","$insert_str","");

    // Se obtiene el proximo valor para el secuencial a guardar en stzbitac a partir de stzsistem
    //pg_exec("BEGIN WORK");
    //pg_exec("LOCK TABLE stzsystem IN SHARE ROW EXCLUSIVE MODE");
    //$sys_actual = next_sys("nbitaco");
    //$vsecuencial = grabar_sys("nbitaco",$sys_actual);
    //pg_exec("COMMIT WORK");
    
    // Almaceno registro original en Bitacora
    //$insert_str = "'$vsecuencial','$fechahoy','$horactual','$usuario','$tbname_15','A','M','$vsol','$string15','$campos15'";
    //$sql->insert("$tbname_23","","$insert_str","");

    // Se obtiene el proximo valor para el secuencial a guardar en stzbitac a partir de stzsistem
    //pg_exec("BEGIN WORK");
    //pg_exec("LOCK TABLE stzsystem IN SHARE ROW EXCLUSIVE MODE");
    //$sys_actual = next_sys("nbitaco");
    //$vsecuencial = grabar_sys("nbitaco",$sys_actual);
    //pg_exec("COMMIT WORK");
    
    // Almaceno registro original en Bitacora
    //$insert_str = "'$vsecuencial','$fechahoy','$horactual','$usuario','$tbname_14','A','M','$vsol','$string14','$campos14'";
    //$sql->insert("$tbname_23","","$insert_str","");

    //Se obtiene el proximo valor para el secuencial a guardar en stzbider a partir de stzsistem para transferencia
    //pg_exec("BEGIN WORK");
    //pg_exec("LOCK TABLE stzsystem IN SHARE ROW EXCLUSIVE MODE");
    //$sys_actual = next_sys("nbitaco");
    //$vsecuencial = grabar_sys("nbitaco",$sys_actual);
    //pg_exec("COMMIT WORK");
    // Almaceno registro original en Bitacora stzbider
    //$insert_str = "'$vsecuencial','$fechahoy','$horactual','$usuario','$tbname_16','A','M','$vsol','$string16'";
    //$sql->insert("$tbname_24","","$insert_str","");

    // Comienzo de Transaccion 
    pg_exec("BEGIN WORK");
  
    // Actualizacion de Tabla Maestra de Obras 
    pg_exec("LOCK TABLE stdobras IN SHARE ROW EXCLUSIVE MODE");
    $update_str = "fecha_solic='$fecha_solie',pais_origen='$p_origen',anno_1publica='$annopripubli',n_ejemplares='$n_ejemplares',
tipo_soporte='$tipo_soporte',observacion='$observacion',n_hojas_adic='$n_hojas_adic',datos_ampli='$vdatos_ampli',
datos_adicio='$vdatos_adicio',nplanilla='$nplanilla'";
    $act_obras = $sql->update("$tbname_1","$update_str","nro_derecho='$vder'");

    // Actualizacion del Director en tabla de Persona Natural 
    $ins_datper = true;
    $act_director = true;
    if ($doc_cedula!=$dir_cedula) { 
      $res_nat=pg_exec("SELECT * FROM stzsolic WHERE identificacion='$doc_cedula'");
      $filas_natur=pg_numrows($res_nat);
      if ($filas_natur==0) {
        $col_campos = "identificacion,nombre,indole,telefono1,fax";
        $insert_str = "'$doc_cedula','$director','N','$ntelefono','$nfax'";
        $ins_datsol = $sql->insert("$tbname_23","$col_campos","$insert_str","");
        $res_vtitu=pg_exec("SELECT last_value FROM stzsolic_titular_seq"); 
        $reg_vtitu = pg_fetch_array($res_vtitu); 
        $vtit=$reg_vtitu[last_value];
        $col_campos = "titular,estado_civil";
        $insert_str = "'$vtit','S'";
        $ins_datper = $sql->insert("$tbname_4","$col_campos","$insert_str","");
      }
      else {
        $regtitu = pg_fetch_array($res_nat); 
        $vtit=$regtitu[titular];
        pg_exec("LOCK TABLE stzsolic IN SHARE ROW EXCLUSIVE MODE");
        $update_str = "nombre='$director',telefono1='$ntelefono',fax='$nfax'";
        $act_director = $sql->update("$tbname_23","$update_str","titular='$vtit'");
      }
    }
    // Actualizacion de la Tabla de Grupo, Orquesta Musical, Vocales y Otros
    pg_exec("LOCK TABLE stdgrupo IN SHARE ROW EXCLUSIVE MODE");
    $update_str = "nombre_grupo='$vnbgrupo',tipo_agrupa='$vtipo_grupo',doc_director='$doc_cedula',domicilio='$domicilio',pais_resid='$p_origen'";
    $act_grupo = $sql->update("$tbname_15","$update_str","nro_derecho='$vder'");

    // Actualizacion de Tabla de Transferencia  
    $act_trans = true;
    if (!empty($vtransferen)) {  
      pg_exec("LOCK TABLE stdtrans IN SHARE ROW EXCLUSIVE MODE");
      $update_str = "transferencia='$vtransferen'";
      $act_trans = $sql->update("$tbname_16","$update_str","nro_derecho='$vder'");
    }

    // Actualizacion de la Tabla correspondiente a Fijacion
    pg_exec("LOCK TABLE stdfijac IN SHARE ROW EXCLUSIVE MODE");
    $update_str = "anno_fijacion='$annofijacion',tipo_fijacion='$tipo_fijacion',ficha_datos='$votros_datos'";
    $act_obfija = $sql->update("$tbname_14","$update_str","nro_derecho='$vder'");

    // Tabla de Obras Interpretadas o Ejecutadas
    $ins_fie = 0;
    $ins_obrfie = true; 
    $del_obrfie = true; 
    $del_tmpfie = true;
    $del_obrfie = $sql->del("stdfijin","nro_derecho='$vder'");     
    //pg_exec("LOCK TABLE stdtmpfie IN SHARE ROW EXCLUSIVE MODE");
    $res_fie=pg_exec("SELECT * FROM stdtmpfie WHERE solicitud='$vsol'");
    $filas_res_fie=pg_numrows($res_fie); 
    $regfie = pg_fetch_array($res_fie);
    for($i=0;$i<$filas_res_fie;$i++) 
     { 
       $codigo=$regfie[nro_obfinej];
       $titulo = str_replace("'","´",$regfie[titulo_obfie]); 
       $autor = str_replace("'","´",$regfie[nombre_autor]);
       $tipoobra = $regfie[tipo_obfie];
       $col_campos = "nro_derecho,cod_obfinej,titulo_obfija,nombre_autor,tipo_obfija,interprete";
       $insert_str = "'$vder','$codigo','$titulo','$autor','$tipoobra','$vnbgrupo'";
       $ins_obrfie = $sql->insert("$tbname_2","$col_campos","$insert_str","");
       if (!$ins_obrfie) { $ins_fie = $ins_fie + 1; }  
       $regfie = pg_fetch_array($res_fie);
     }
    $del_tmpfie = $sql->del("stdtmpfie","solicitud='$vsol'");

    // Tabla de Artistas
    $ins_art = 0;
    $res_int=pg_exec("SELECT * FROM stdtmpar WHERE solicitud='$vsol'");
    $filas_int=pg_numrows($res_int); 
    if ($filas_int>0) {
      $del_obrart = $sql->del("stdobart","nro_derecho='$vder'");
      $ins_art=guardar_interesado('Artista',$vsol,$vder,'V'); }

    // Tabla de Titulares
    $ins_tit = 0; 
    $res_int=pg_exec("SELECT * FROM stdtmpti WHERE solicitud='$vsol'");
    $filas_int=pg_numrows($res_int); 
    if ($filas_int>0) {
      $del_obrart = $sql->del("stdobtit","nro_derecho='$vder'");
      $ins_tit=guardar_interesado('Titular',$vsol,$vder,'V'); }

    // Tabla de Solicitante
    $ins_sol = 0;
    $res_int=pg_exec("SELECT * FROM stdtmpso WHERE solicitud='$vsol'");
    $filas_int=pg_numrows($res_int); 
    if ($filas_int>0) {
      $del_obrart = $sql->del("stdobsol","nro_derecho='$vder'");
      $ins_sol=guardar_interesado('Solicitante',$vsol,$vder,'U',$tipo_caracter,$otro_caracter,$prueba_repres); }

    // Verificacion y actualizacion real de los Datos en BD 
    if ($act_obras and $act_director and $act_grupo and $act_trans and $act_obfija and $ins_fie==0 and $ins_sol==0 and $ins_art==0 and $ins_tit==0) {
      pg_exec("COMMIT WORK");  
      // Desconexion de la Base de Datos
      $sql->disconnect();
    }
    else {
      pg_exec("ROLLBACK WORK");
      // Desconexion de la Base de Datos
      $sql->disconnect();
       
      if (!$act_obras)    { $error_obras  = " - Obras "; } 
      if (!$act_grupo)    { $error_grupo  = " - Grupo/Orquesta "; }
      if (!$act_transf)   { $error_trans  = " - Transferencia "; }    
      if (!$act_director) { $error_direc  = " - Director de Grupo"; }
      if (!$ins_datper)   { $error_datper = " - Persona Natural - Director "; }
      if ($ins_sol!=0)    { $error_datsol = " - Solicitante "; } 
      if ($ins_art!=0)    { $error_datart = " - Artistas "; }
      if ($ins_tit!=0)    { $error_dattit = " - Titular "; } 
      if ($ins_fie!=0)    { $error_datfie = " - Obras Interpretadas/Ejecutadas "; } 

      mensajenew("Falla de Actualizaci&oacute;n de Datos en la BD $error_obras $error_grupo $error_direc $error_trans $error_datper $error_datsol $error_datart $error_dattit $error_datfie ...!!!","javascript:history.back();","N");
      $smarty->display('pie_pag.tpl'); exit();
    }
   
  }

  // Desconexion de la Base de Datos
  //$sql->disconnect();

  if ($accion=="I") { 
    //Mensajenew("DATOS GUARDADOS CORRECTAMENTE...!","a_obraieanw.php?vopc=3&nconex=$n_conex&salir=1&conx=0","S");
  }
  else {
    Mensajenew("DATOS GUARDADOS CORRECTAMENTE...!","a_obraieanw.php?vopc=5&nconex=$n_conex&salir=1&conx=0","S"); }
  $smarty->display('pie_pag.tpl'); exit(); 

}

// Pase de variables y Etiquetas al template
$smarty->assign('campo1','Expediente No.:');
$smarty->assign('campo2','de Fecha:');
$smarty->assign('campo3','N&uacute;mero de Planilla:');
$smarty->assign('campo4','Nombre de la Agrupaci&oacute;n:');
$smarty->assign('campo5','Tipo de Agrupaci&oacute;n:');
$smarty->assign('campo6','Nombre Director:');
$smarty->assign('campo7','Documento de Identidad:');
$smarty->assign('campo8','Domicilio:');
$smarty->assign('campo9','Nacionalidad:');
$smarty->assign('campo10','Tel&eacute;fono:');
$smarty->assign('campo11','Fax:');
$smarty->assign('campo12','Tipo de Fijaci&oacute;n:');
$smarty->assign('campo13','A&ntilde;o de Fijaci&oacute;n:');
$smarty->assign('campo14','A&ntilde;o de Primera Publicaci&oacute;n:');

$smarty->assign('campo15','Nombre o Raz&oacute;n Social:');
$smarty->assign('campo16','Car&aacute;cter con el que Act&uacute;a:');
$smarty->assign('campo17','Otro Car&aacute;cter con el que Act&uacute;a:');
$smarty->assign('campo18','Prueba de Representaci&oacute;n o Transferencia de Derechos:');
$smarty->assign('campo19','Ejemplares Depositados:');
$smarty->assign('campo20','Tipo de Soporte Material:');
$smarty->assign('campo21','Observaciones:');
$smarty->assign('campo22','Incluye Hoja(s) Adicional(es):');
$smarty->assign('campo23','No. de Hoja(s) Adicional(es):');
$smarty->assign('campo24','Dato(s) ampliado(s) en la(s) Hoja(s) Adicional(es):');
$smarty->assign('campo25','Obra Interpretada/Ejec.:');
$smarty->assign('campo26','C&oacute;digo de Obra:');
$smarty->assign('campo27','Nombre:');
$smarty->assign('campo28','Tipo de Fijaci&oacute;n:');
$smarty->assign('campo29','Otros Datos:');
$smarty->assign('campo30','C&eacute;dula del Artista:');

$smarty->assign('vopc',$vopc);
$smarty->assign('vsol1',$vsol);
$smarty->assign('vder',$vder);
$smarty->assign('accion',$accion);
$smarty->assign('usuario',$usuario);
$smarty->assign('fecha_solie',$fecha_solie);
$smarty->assign('nplanilla',$nplanilla);
$smarty->assign('nu_planilla',$nu_planilla);
$smarty->assign('estatus',$estatus);
$smarty->assign('arraycodpais',$arraycodpais);
$smarty->assign('arraynompais',$arraynompais);
$smarty->assign('arrcodgener',$arrcodgener);
$smarty->assign('arrnomgener',$arrnomgener);
$smarty->assign('nbgrupo',$nbgrupo);
$smarty->assign('tipo_grupo',$tipo_grupo);
$smarty->assign('director',$director);
$smarty->assign('doc_cedula',$doc_cedula);
$smarty->assign('dir_cedula',$dir_cedula);  
$smarty->assign('domicilio',$domicilio); 
$smarty->assign('pais_origen',$pais_origen); 
$smarty->assign('p_origen',$p_origen);
$smarty->assign('pais_origen',$p_origen);
$smarty->assign('pais',$p_origen);
$smarty->assign('ntelefono',$ntelefono); 
$smarty->assign('nfax',$nfax); 
$smarty->assign('tipo_fijacion',$tipo_fijacion); 
$smarty->assign('annofijacion',$annofijacion); 
$smarty->assign('annopripubli',$annopripubli); 
$smarty->assign('otrosdatos',$otrosdatos); 
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

$smarty->display('a_obraieanw.tpl');
$smarty->display('pie_pag.tpl');
?>
