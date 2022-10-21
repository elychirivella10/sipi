<script language="Javascript"> 
function CambiarImagen(oImagen,Ruta)
{
	oImagen.src='file:///'+Ruta;
}

function pregunta() { 
  return confirm('Estas seguro de grabar la Informacion ?'); }

function browseagentep(var1,var2,var3,var4) {
  this.derecho='P';
  open("../comun/adm_agente.php?vsol="+var1.value+"-"+var2.value+"&vtex="+var3.value+"&vmod="+var4.value+"&vtip="+this.derecho,"Ventana", "scrollbars=yes,toolbar=no,directories=no,menubar=no,status=no"); }

function browsetitularp(var1,var2,var3,var4) {
  this.derecho='P';
  open("../comun/adm_titular.php?vsol="+var1.value+"-"+var2.value+"&vtex="+var3.value+"&vmod="+var4.value+"&vtip="+this.derecho,"Ventana", "scrollbars=yes,toolbar=no,directories=no,menubar=no,status=no"); }

function browseprioridp(var1,var2,var3,var4) {
  this.derecho='P';
  open("../comun/adm_priorid.php?vsol="+var1.value+"-"+var2.value+"&vtex="+var3.value+"&vmod="+var4.value+"&vtip="+this.derecho,"Ventana", "scrollbars=yes,toolbar=no,directories=no,menubar=no,status=no"); }

function browseinventorp(var1,var2,var3,var4) {
  open("adm_inventor.php?vsol="+var1.value+"-"+var2.value+"&vtex="+var3.value+"&vmod="+var4.value,"Ventana", "scrollbars=yes,toolbar=no,directories=no,menubar=no,status=no"); }

 function habil(vcampo,vcampo1,vcampo2,vcampo3,vcampo4)
 {
   if (vcampo.value.length>0) {
      vcampo1.value = ""; 
      vcampo1.disabled = true;
      vcampo2.value = ""; 
      vcampo2.disabled = true;
      vcampo3.value = ""; 
      vcampo3.disabled = true;
      vcampo4.disabled = true;
      }
   else {
      vcampo.disabled = false;
      vcampo1.disabled = false;
      vcampo2.disabled = false;
      vcampo3.disabled = false;
   }
 }

 function habilitar(vtipo,vnombre,vcampo,botoni,botone,botonv,ubica)
 {
   if (vtipo.value == "D") {
      vnombre.disabled = false;
      vcampo.value = ""; 
      vcampo.disabled = true;
      botoni.disabled = true;
      botone.disabled = true;
      botonv.disabled = true;
      ubica.disabled = true;
   }
   if (vtipo.value == "G") {
      vnombre.value = ""; 
      vnombre.disabled = true;
      vcampo.disabled = false; 
      botoni.disabled = false; 
      botone.disabled = false;
      botonv.disabled = false;
      ubica.disabled = false;
   }
   if (vtipo.value == "M") {
      vnombre.disabled = false;
      vcampo.value = ""; 
      vcampo.disabled = false; 
      botoni.disabled = false; 
      botone.disabled = false;
      botonv.disabled = false;
      ubica.disabled = false;
   }
 }

</script>

<?php
// ************************************************************************************* 
// Programa: p_ingsol55.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Año: 2009 BD - Relacional 
// *************************************************************************************
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");
//Clase que sube un archivo de imagen
include ("$include_lib/upload_class.php"); 

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variables
$usuario = $_SESSION['usuario_login'];
$role = $_SESSION['usuario_rol'];
$sql  = new mod_db();
$fecha   = fechahoy();

$tbname_1 = "stzpaisr";
$tbname_2 = "stzagenr";
$tbname_3 = "stzsolic";
$tbname_4 = "stppatee";
$tbname_5 = "stzevtrd";
$tbname_6 = "stzderec";
$tbname_7 = "stzottid";
$tbname_8 = "stpinved";
$tbname_9 = "stztmptit";
$tbname_10 = "stzusuar";
$tbname_11 = "stptmpinv";
$tbname_12 = "stzbitac";
$tbname_13 = "stzbider";
$tbname_14 = "stplocad";
$tbname_15 = "stzpriod";
$tbname_16 = "stpclsfd";
$tbname_17 = "stzautod";
$tbname_18 = "stztmpage";
$tbname_19 = "stztmprio";
$tbname_20 = "stpanual";

$vopc=$_GET['vopc'];
$vuser=$_GET['vuser'];
$vaccion=$_GET['vaccion'];
$vauxnum=$_GET['vauxnum'];
$depto_id=$_GET['vdepto'];
$vsol1=$_POST['vsol1'];
$vsol2=$_POST['vsol2'];
$vsol1a=$_POST['vsol1a'];
$vsol2a=$_POST['vsol2a'];
$vsol=$_POST['vsol'];

$fecha_solic=$_POST['fecha_solic'];
$tipo_paten=$_POST['tipo_paten'];
$nombre=$_POST['nombre'];
$psoli=$_POST['psoli'];
$vpod1=$_POST['vpod1'];
$vpod2=$_POST['vpod2'];
$tramitante=$_POST['tramitante'];
$resumen=$_POST['resumen'];
$vstring=$_POST['vstring'];
$vstring1=$_POST['vstring1'];
$vstring2=$_POST['vstring2'];
$campos=$_POST['campos'];
$accion=$_POST['accion'];
$auxnum=$_POST['auxnum'];
$vnumclase=$_POST['options'];
$input2=$_POST['input2'];
$vsol3=$_POST['vsol3'];
$vsol4=$_POST['vsol4'];
$vreg1d=$_POST['vreg1d'];
$vreg2d=$_POST['vreg2d'];
$ubicacion= $_POST['ubicacion'];
$locarno1 = $_POST['locarno1']; 
$locarno2 = $_POST['locarno2'];
$edicion  = $_POST['edicion'];
//$anualidad= $_POST['anualidad'];
$planilla = $_POST['planilla'];
$tasa     = $_POST['tasa'];
$monto    = $_POST['monto'];
$anualidad= "1";
 
//Clasificaciones
$c1l1 = $_POST['c1l1'];
$c1n1 = $_POST['c1n1']; 
$c1l2 = $_POST['c1l2'];
$c1n2 = $_POST['c1n2'];
$c1n3 = $_POST['c1n3'];
$t1 = $_POST['t1'];
$c2l1 = $_POST['c2l1'];
$c2n1 = $_POST['c2n1']; 
$c2l2 = $_POST['c2l2'];
$c2n2 = $_POST['c2n2'];
$c2n3 = $_POST['c2n3'];
$t2 = $_POST['t2'];
$c3l1 = $_POST['c3l1'];
$c3n1 = $_POST['c3n1']; 
$c3l2 = $_POST['c3l2'];
$c3n2 = $_POST['c3n2'];
$c3n3 = $_POST['c3n3'];
$t3 = $_POST['t3'];
$c4l1 = $_POST['c4l1'];
$c4n1 = $_POST['c4n1']; 
$c4l2 = $_POST['c4l2'];
$c4n2 = $_POST['c4n2'];
$c4n3 = $_POST['c4n3'];
$t4 = $_POST['t4'];
$c5l1 = $_POST['c5l1'];
$c5n1 = $_POST['c5n1']; 
$c5l2 = $_POST['c5l2'];
$c5n2 = $_POST['c5n2'];
$c5n3 = $_POST['c5n3'];
$t5 = $_POST['t5'];
$c6l1 = $_POST['c6l1'];
$c6n1 = $_POST['c6n1']; 
$c6l2 = $_POST['c6l2'];
$c6n2 = $_POST['c6n2'];
$c6n3 = $_POST['c6n3'];
$t6 = $_POST['t6'];
$c7l1 = $_POST['c7l1'];
$c7n1 = $_POST['c7n1']; 
$c7l2 = $_POST['c7l2'];
$c7n2 = $_POST['c7n2'];
$c7n3 = $_POST['c7n3'];
$t7 = $_POST['t7'];
$c8l1 = $_POST['c8l1'];
$c8n1 = $_POST['c8n1']; 
$c8l2 = $_POST['c8l2'];
$c8n2 = $_POST['c8n2'];
$c8n3 = $_POST['c8n3'];
$t8 = $_POST['t8'];
$c9l1 = $_POST['c9l1'];
$c9n1 = $_POST['c9n1']; 
$c9l2 = $_POST['c9l2'];
$c9n2 = $_POST['c9n2'];
$c9n3 = $_POST['c9n3'];
$t9 = $_POST['t9'];
$c10l1 = $_POST['c10l1'];
$c10n1 = $_POST['c10n1']; 
$c10l2 = $_POST['c10l2'];
$c10n2 = $_POST['c10n2'];
$c10n3 = $_POST['c10n3'];
$t10 = $_POST['t10'];
$c11l1 = $_POST['c11l1'];
$c11n1 = $_POST['c11n1']; 
$c11l2 = $_POST['c11l2'];
$c11n2 = $_POST['c11n2'];
$c11n3 = $_POST['c11n3'];
$t11 = $_POST['t11'];
$c12l1 = $_POST['c12l1'];
$c12n1 = $_POST['c12n1']; 
$c12l2 = $_POST['c12l2'];
$c12n2 = $_POST['c12n2'];
$c12n3 = $_POST['c12n3'];
$t12 = $_POST['t12'];

$smarty->assign('titulo',$substpat);
$smarty->assign('subtitulo','Mantenimiento de Expediente / Ingreso LPI55'); 
if ($vopc==3) {
  $smarty->assign('subtitulo','Mantenimiento de Expediente / Ingreso LPI55'); }
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

$vresol=$vsol1.'-'.$vsol2;

if ($vopc==4) {
  //Verificando conexion
  $sql->connection($usuario);
  $resulm = pg_exec("SELECT * FROM $tbname_6 WHERE solicitud='$vresol' AND tipo_mp='P'");
  $regm = pg_fetch_array($resulm);
  $nfil = pg_numrows($resulm);
  if ($nfil!=0) {
   Mensajenew("Solicitud ya existe en la Base de Datos ...!!!","javascript:history.back();","N");
   $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  } 
}   

//$smarty->assign('arraytipom',array(N,A,C,E,D,B,G,F,V));
//$smarty->assign('arraynotip',array('','INVENCION','DE MEJORA','MODELO INDUSTRIAL','DE INTRODUCCION','DIBUJO INDUSTRIAL','DISE&Ntilde;O INDUSTRIAL','MODELO DE UTILIDAD','VARIEDAD VEGETAL'));
//Se quito la opcion "Variedad Vegetal" por peticion de la Coordinadora: Maria Gabriela Alvarez. requerimiento: 193503 de fecha: 24/10/2013
//$smarty->assign('arraytipom',array(N,A,C,E,D,B,G,F));
//$smarty->assign('arraynotip',array('','INVENCION','DE MEJORA','MODELO INDUSTRIAL','DE INTRODUCCION','DIBUJO INDUSTRIAL','DISE&Ntilde;O INDUSTRIAL','MODELO DE UTILIDAD'));
$smarty->assign('arraytipom',array(N,A,C,E,D,B));
$smarty->assign('arraynotip',array('','INVENCION','DE MEJORA','MODELO INDUSTRIAL','DE INTRODUCCION','DIBUJO INDUSTRIAL'));


if (($vopc==1) || ($vopc==3) || ($vopc==4)) {
  //Obtención de los Paises
  $obj_query = $sql->query("SELECT * FROM $tbname_1 order by nombre");
  if (!$obj_query) { 
    mensajenew("Problema al intentar realizar la consulta en la tabla   $tbname_1 ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
  $filas_found=$sql->nums('',$obj_query);
  if ($filas_found==0) {
    mensajenew("La Tabla de Paises esta Vacia ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 
  
  $cont = 0;
  $arraycodpais[$cont]=0;
  $arraynompais[$cont]='';
  $objs = $sql->objects('',$obj_query);
  for($cont=1;$cont<=$filas_found;$cont++) 
  { 
    $arraycodpais[$cont]=$objs->pais;
    $arraynompais[$cont]=trim($objs->nombre);
    $objs = $sql->objects('',$obj_query);
  }

}

if (($vopc!=1) && ($vopc!=2) && ($vopc!=3) && ($vopc!=4)) {
  $smarty->assign('modo1',''); 
  $smarty->assign('modo2','disabled'); 
  $smarty->assign('modo3','disabled'); 
  $smarty->assign('vmodo','readonly=readonly'); 
  $smarty->assign('psoli',$vsol); 
  $smarty->assign('modo','readonly=readonly'); 
}

if ($vopc==3) {
  $smarty->assign('subtitulo','Mantenimiento de Expediente / Ingreso'); 
  $smarty->assign('varfocus','formarcas1.vsol1');
  $smarty->assign('vmodo','readonly=readonly'); 
  $smarty->assign('modo1',''); 
  $smarty->assign('modo','readonly=readonly'); 
  $smarty->assign('modo2','disabled'); 
  $smarty->assign('modo3','disabled'); 
  $smarty->assign('accion',1);

  //La Fecha de Hoy para la solicitud
  $fecha_solic = hoy();
  $nameimage="../imagenes/sin_imagen8.png";
  $smarty->assign('nameimage',$nameimage);
}

if ($vopc==4) {
  $smarty->assign('subtitulo','Mantenimiento de Expediente / Ingreso'); 
  $smarty->assign('varfocus','formarcas2.fecha_solic');
  $smarty->assign('fechahoy',$fecha);
  $fecha_solic = hoy();
  $smarty->assign('accion',2);
  $smarty->assign('modo1','disabled'); 
  $smarty->assign('modo',''); 
  $smarty->assign('modo2',''); 
  $smarty->assign('modo3',''); 
  $nameimage="../imagenes/sin_imagen8.png";
  $smarty->assign('nameimage',$nameimage);
}

//Opcion Grabar...
if ($vopc==2) {
  //La Fecha de Hoy y Hora para la transaccion
  $fechahoy = hoy();
  $horactual= Hora();

  //Verificando conexion
  $sql->connection($usuario);

  if ($accion==1) {
    $vsol1 = $vsol1a;
    $vsol2 = $vsol2a;}

  //Validacion del Numero de Solicitud
  if (empty($vsol1) || empty($vsol2)) { 
    mensajenew("Numero de Solicitud Vacio o con Error ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }

  $varsol=$vsol1."-".$vsol2;    
  //Verificacion de que los campos requeridos esten llenos...
  $req_fields = array("fecha_solic","tipo_paten","resumen");
  $valores = array($fecha_solic,$tipo_paten,$resumen);
  $vacios = check_empty_fields();
  if (!$vacios) { 
     mensajenew("Hay Informacion en el formulario que esta Vacia ...!!!","javascript:history.back();","N");
     $smarty->display('pie_pag.tpl'); exit(); }

  // Verificacion de si existe o no en la base de datos la solicitud 
  $obj_query = $sql->query("SELECT * FROM $tbname_6 WHERE solicitud='$varsol' AND tipo_mp ='P'");
  $obj_filas = $sql->nums('',$obj_query);
  if ($obj_filas!=0) {
    Mensajenew("Error: Solicitud YA existe en la Base de Datos ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }

  $esmayor=compara_fechas($fecha_solic,$fechahoy);
  if ($esmayor==1) {
    mensajenew("La Fecha de Solicitud No puede ser mayor a la de Hoy ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }
  
  $annno= Obtener_anno($fecha_solic,0);
  if ($vsol1 != $annno) { 
    Mensage_Error("Los Cuatros primeros digitos del Expediente no son iguales a los cuatros ultimos de su Fecha ...!!!");
    $smarty->display('pie_pag.tpl'); exit();  }

  if ($tipo_paten=='N') {  
    Mensage_Error("Error: No ha seleccionado el Tipo de Patente ...!!!");
    $smarty->display('pie_pag.tpl'); exit();  }

  if (empty($input2)) { 
     $vcodpais=""; 
     mensajenew("Debe indicar Pais de Residencia ...!!!","javascript:history.back();","N");
     $smarty->display('pie_pag.tpl'); exit(); }

  //Validacion del Poder
  if (!empty($vpod1) && !empty($vpod2))
   { $vpoder= $vpod1."-".sprintf("%04d",$vpod2); } else
   { $vpoder=""; }

  if ((empty($monto)) || ($monto==0)) {
     Mensajenew('ERROR: El Monto esta en blanco o NO puede ser Cero ...!!!','javascript:history.back();','N');
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

  if ((empty($tasa)) || ($tasa=='0')) {
     Mensajenew('ERROR: La Tasa esta en blanco o NO puede ser Cero ...!!!','javascript:history.back();','N');
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

  $vcodage=0;
  // Validacion de Agentes  
  $res_agen=pg_exec("SELECT * FROM $tbname_18 where solicitud='$varsol' AND tipo_mp='P' ORDER BY agente");
  $filas_res_age=pg_numrows($res_agen); 
  $regagen = pg_fetch_array($res_agen);
  if ($filas_res_age==0) { $vcodage=0; }
  else { 
     if ($regagen[agente]!="0") { $vcodage=$regagen[agente]; } } 

  if (empty($tramitante) && empty($vpoder) && ($vcodage==0)) {
      mensajenew("Debe tener Tramitante o Poder o Agente(s) ...!!!","javascript:history.back();","N");
      $smarty->display('pie_pag.tpl'); exit(); }

  if ($tramitante!="") {
    if (($vpoder!="") || ($vcodage!=0)) {
      mensajenew("Solo puede tener Tramitante o Poder o Agente(s) ...!!!","javascript:history.back();","N");
      $smarty->display('pie_pag.tpl'); exit(); } }

  //Validacion del Titular o Solicitante  
  $filas_titular = 0; 
  $obj_query = $sql->query("SELECT * FROM $tbname_9 where solicitud='$varsol'");
  if (!$obj_query) { 
    mensajenew("Problema al intentar realizar la consulta en la tabla $tbname_9 ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
  $filas_titular=$sql->nums('',$obj_query);
  if ($filas_titular==0) {
    mensajenew("Expediente $varsol sin ningun Titular asociado ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 

  //Validacion del o los Inventores  
  $filas_titular = 0; 
  $obj_query = $sql->query("SELECT * FROM $tbname_11 where solicitud='$varsol'");
  if (!$obj_query) { 
    mensajenew("Problema al intentar realizar la consulta en la tabla $tbname_9 ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
  $filas_titular=$sql->nums('',$obj_query);
  if ($filas_titular==0) {
    Mensajenew("Expediente $varsol sin Inventores asociados ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 

  if (empty($anualidad) || empty($planilla) || empty($tasa) || empty($monto)) { 
     Mensajenew("Debe indicar Datos Completos de la Anualidad ...!!!","javascript:history.back();","N");
     $smarty->display('pie_pag.tpl'); exit(); }

  //Grabacion de Datos de nueva Solicitud
  if ($accion==2) {
    $resultado=pg_exec("SELECT * FROM stzevder WHERE evento=2200");
    if (!$resultado) { 
      mensajenew("Código de Evento NO existe en la Base de Datos ...!!!","javascript:history.back();","N");
      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
    $filas_found=pg_numrows($resultado); 
    if ($filas_found==0) {
      mensajenew("No existen Datos asociados al Evento ...!!!","javascript:history.back();","N");
      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 
    $regeve = pg_fetch_array($resultado);
    $vdes=trim($regeve['mensa_automatico']);
    $documento=0;
    $comentario="";

    $dirano = $vsol1;
    $varsol=$vsol1."-".$vsol2;
    //Variable para la busqueda de la imagen
    $vnewnombre=$dirano.substr($vsol2,-6,6); 
    //$ruta = "/var/www/sistemas/imagenes/patentes/".$dirano."/";
    $ruta = "/graficos/patentes/di".$dirano."/";

    //Copiar archivo de logotipo en ruta final
    $archivop = $_FILES['ubicacion']['name'];
    if (!empty($archivop)) {
      $max_size = 1024*100; // the max. size for uploading	
      $my_upload = new file_upload;
      $my_upload->upload_dir = $ruta; // "files" is the folder for the uploaded files (you have to create this folder)
      $my_upload->extensions = array(".jpg", ".jpge",".png"); // specify the allowed extensions here
      $my_upload->max_length_filename = 50; // change this value to fit your field length in your database (standard 100)
      $my_upload->rename_file = true;
      $my_upload->the_temp_file = $_FILES['ubicacion']['tmp_name'];
      $my_upload->the_file = $_FILES['ubicacion']['name'];
      $my_upload->http_error = $_FILES['ubicacion']['error'];
      $my_upload->validateExtension();
      if ($my_upload->upload($vnewnombre)) { 
        echo ''; } 
      else {
      //Mensage_Error($my_upload->show_error_string());
      //  mensajenew($my_upload->show_error_string(),"javascript:history.back();","N");
      //  $smarty->display('pie_pag.tpl'); 
      // exit(); 
         }
    }

    if (empty($edicion)) { $edicion=0; }
    
    // Validacion de si el Numero existe o NO en la BD 
    $resulm=pg_exec("SELECT * FROM $tbname_6 WHERE solicitud='$varsol' AND tipo_mp='P'");
    $regm= pg_fetch_array($resulm);
    $nfil=pg_numrows($resulm);
    if ($nfil>0) {
      Mensajenew("Solicitud ya existe en la Base de Datos ...!!!","p_ingsol55.php?vopc=3","N");
      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

    $vcodpais=$input2;
    // Tabla Maestra de Derecho y Patentes 
    pg_exec("BEGIN WORK");

    //Generacion del Numero de Derecho
    $instram = true;
    $inslocar = true;
    $inspaten = true;
    $insanual = true;
    $insderecho = true; 
    $prox_derecho = 0;

    $obj_query = $sql->query("UPDATE stzsystem SET nro_derecho=nextval('stzsystem_nro_derecho_seq')");
    if ($obj_query) {
      $obj_query = $sql->query("SELECT last_value FROM stzsystem_nro_derecho_seq");
      $objs = $sql->objects('',$obj_query);
      $prox_derecho = $objs->last_value; }

    //Insercion del Registro Nuevo en la Maestra de Derecho 
    $col_campos = "nro_derecho,tipo_derecho,solicitud,fecha_solic,tipo_mp,nombre,estatus,pais_resid,poder,tramitante,agente";
    $vnom = str_replace("'","´",$nombre);
    $vtra = str_replace("'","´",$tramitante);

    $insert_str = "'$prox_derecho','$tipo_paten','$varsol','$fecha_solic','P','$vnom',2001,'$vcodpais','$vpoder','$vtra','$vcodage'";
    $insderecho = $sql->insert("$tbname_6","$col_campos","$insert_str","");

    if (empty($edicion)) { $edicion = 0; } 
    //Insercion del Registro Nuevo en la Maestra de Patentes    
    $col_campos = "nro_derecho,anualidad,edicion,resumen";
    $resumen = trim($resumen);
    $vres = str_replace("'","´",$resumen);
    $insert_str = "'$prox_derecho',1,$edicion,'$vres'";
    $inspaten = $sql->insert("$tbname_4","$col_campos","$insert_str","");

    $obser = '';
    $horactual = Hora();
    //Insercion Datos de Anualidad     
    $monto = str_replace(",",".",$monto);
    $col_campos = "nro_derecho,fecha_anual,anualidad,monto,observacion,planilla,tasa,usuario,fecha_trans,hora";
    $insert_str = "'$prox_derecho','$fecha_solic',1,$monto,'$obser','$planilla','$tasa','$usuario','$fechahoy','$horactual'";
    $insanual = $sql->insert("$tbname_20","$col_campos","$insert_str","");

    // Tabla de Eventos de Tramite  
    $col_campos = "nro_derecho,evento,fecha_event,secuencial,estat_ant,documento,fecha_trans,usuario,desc_evento,hora";
    $insert_str = "'$prox_derecho',2200,'$fecha_solic',nextval('stzevtrd_secuencial_seq'),2000,0,'$fechahoy','$usuario','$vdes','$horactual'";
    $instram = $sql->insert("$tbname_5","$col_campos","$insert_str","");

    if ($tipo_paten=="G") {
      if ((trim($locarno1)!="") && (trim($locarno2)!="")) {   
        if ((trim($locarno1)!="00") && (trim($locarno2)!="00")) {
          $locarno = $locarno1."-".$locarno2;
          $col_campos = "nro_derecho,clasi_locarno";
          $insert_str = "'$prox_derecho','$locarno'";
          $inslocar = $sql->insert("$tbname_14","$col_campos","$insert_str","");
        }
        else {  
          mensajenew('Error en la Clasificacion de Locarno ...!!!','javascript:history.back();','N');
	       $smarty->display('pie_pag.tpl'); exit(); } 
	   }
    }

    if (($tipo_paten=="A") || ($tipo_paten=="F")) {
      // Validacion de las Clasificaciones 
      if (!empty($c1l1) && !empty($c1l2)) {
      if ((trim($c1n2)!="") && (trim($c1n3)!="")) {   
        $c1 = $c1l1.$c1n1.$c1l2." ".$c1n2."/".$c1n3; 
        $arraycls[1]=$c1; $arraytip[1]=$t1; }
      else {
        if ((trim($c1n2)=="") && (trim($c1n3)=="")) {         
          $c1 = $c1l1.$c1n1.$c1l2; $arraycls[1]=$c1; $arraytip[1]=$t1; }
        else {  
          mensajenew('Error en la Clasificacion No. 1 ...!!!','javascript:history.back();','N');
	       $smarty->display('pie_pag.tpl'); exit(); } }      
      }
      if (!empty($c2l1) && !empty($c2l2)) { 
      if ((trim($c2n2)!="") && (trim($c2n3)!="")) {          
        $c2 = $c2l1.$c2n1.$c2l2." ".$c2n2."/".$c2n3;
        $arraycls[2]=$c2; $arraytip[2]=$t2; }
      else {
        if ((trim($c3n2)=="") && (trim($c3n3)=="")) {         
          $c2 = $c2l1.$c2n1.$c2l2; $arraycls[2]=$c2; $arraytip[2]=$t2; }
        else {  
          mensajenew('Error en la Clasificacion No. 2 ...!!!','javascript:history.back();','N');
	       $smarty->display('pie_pag.tpl'); exit(); } }       
      }
      if (!empty($c3l1) && !empty($c3l2)) {      
      if ((trim($c3n2)!="") && (trim($c3n3)!="")) {   
        $c3 = $c3l1.$c3n1.$c3l2." ".$c3n2."/".$c3n3; 
        $arraycls[3]=$c3; $arraytip[3]=$t3; }
      else {
        if ((trim($c3n2)=="") && (trim($c3n3)=="")) {         
          $c3 = $c3l1.$c3n1.$c3l2; $arraycls[3]=$c3; $arraytip[3]=$t3; }
        else {  
          mensajenew('Error en la Clasificacion No. 3 ...!!!','javascript:history.back();','N');
	       $smarty->display('pie_pag.tpl'); exit(); } }
	   }          
      if (!empty($c4l1) && !empty($c4l2)) {      
      if ((trim($c4n2)!="") && (trim($c4n3)!="")) {   
        $c4 = $c4l1.$c4n1.$c4l2." ".$c4n2."/".$c4n3; 
        $arraycls[4]=$c4; $arraytip[4]=$t4; }
      else {
        if ((trim($c4n2)=="") && (trim($c4n3)=="")) {         
          $c4 = $c4l1.$c4n1.$c4l2; $arraycls[4]=$c4; $arraytip[4]=$t4; }
        else {  
          mensajenew('Error en la Clasificacion No. 4 ...!!!','javascript:history.back();','N');
	       $smarty->display('pie_pag.tpl'); exit(); } }
	   }          
      if (!empty($c5l1) && !empty($c5l2)) {      
      if ((trim($c5n2)!="") && (trim($c5n3)!="")) {   
        $c5 = $c5l1.$c5n1.$c5l2." ".$c5n2."/".$c5n3; 
        $arraycls[5]=$c5; $arraytip[5]=$t5; }
      else {
        if ((trim($c5n2)=="") && (trim($c5n3)=="")) {         
          $c5 = $c5l1.$c5n1.$c5l2; $arraycls[5]=$c5; $arraytip[5]=$t5; }
        else {  
          mensajenew('Error en la Clasificacion No. 5 ...!!!','javascript:history.back();','N');
	       $smarty->display('pie_pag.tpl'); exit(); } }
	   }          
      if ((trim($c6n2)!="") && (trim($c6n3)!="")) {   
        $c6 = $c6l1.$c6n1.$c6l2." ".$c6n2."/".$c6n3; 
        $arraycls[6]=$c6; $arraytip[6]=$t6; }
      else {
        if ((trim($c6n2)=="") && (trim($c6n3)=="")) {         
          $c6 = $c6l1.$c6n1.$c6l2; $arraycls[6]=$c6; $arraytip[6]=$t6; }
        else {  
          mensajenew('Error en la Clasificacion No. 6 ...!!!','javascript:history.back();','N');
	       $smarty->display('pie_pag.tpl'); exit(); } }      
      if ((trim($c7n2)!="") && (trim($c7n3)!="")) {   
        $c7 = $c7l1.$c7n1.$c7l2." ".$c7n2."/".$c7n3; 
        $arraycls[7]=$c7; $arraytip[7]=$t7; }
      else {
        if ((trim($c7n2)=="") && (trim($c7n3)=="")) {         
          $c7 = $c7l1.$c7n1.$c7l2; $arraycls[7]=$c7; $arraytip[7]=$t7; }
        else {  
          mensajenew('Error en la Clasificacion No. 7 ...!!!','javascript:history.back();','N');
	       $smarty->display('pie_pag.tpl'); exit(); } }      
      if ((trim($c8n2)!="") && (trim($c8n3)!="")) {   
        $c8 = $c8l1.$c8n1.$c8l2." ".$c8n2."/".$c8n3; 
        $arraycls[8]=$c8; $arraytip[8]=$t8; }
      else {
        if ((trim($c8n2)=="") && (trim($c8n3)=="")) {         
          $c8 = $c8l1.$c8n1.$c8l2; $arraycls[8]=$c8; $arraytip[8]=$t8; }
        else {  
          mensajenew('Error en la Clasificacion No. 8 ...!!!','javascript:history.back();','N');
	       $smarty->display('pie_pag.tpl'); exit(); } }      
      if ((trim($c9n2)!="") && (trim($c9n3)!="")) {   
        $c9 = $c9l1.$c9n1.$c9l2." ".$c9n2."/".$c9n3; 
        $arraycls[9]=$c9; $arraytip[9]=$t9; }
      else {
        if ((trim($c9n2)=="") && (trim($c9n3)=="")) {         
          $c9 = $c9l1.$c9n1.$c9l2; $arraycls[9]=$c9; $arraytip[9]=$t9; }
        else {  
          mensajenew('Error en la Clasificacion No. 9 ...!!!','javascript:history.back();','N');
	       $smarty->display('pie_pag.tpl'); exit(); } }      
      if ((trim($c10n2)!="") && (trim($c10n3)!="")) {   
        $c10 = $c10l1.$c10n1.$c10l2." ".$c10n2."/".$c10n3; 
        $arraycls[10]=$c10; $arraytip[10]=$t10; }
      else {
        if ((trim($c10n2)=="") && (trim($c10n3)=="")) {         
          $c10 = $c10l1.$c10n1.$c10l2; $arraycls[10]=$c10; $arraytip[10]=$t10; }
        else {  
          mensajenew('Error en la Clasificacion No. 10 ...!!!','javascript:history.back();','N');
	       $smarty->display('pie_pag.tpl'); exit(); } }      
      if ((trim($c11n2)!="") && (trim($c11n3)!="")) {   
        $c11 = $c11l1.$c11n1.$c11l2." ".$c11n2."/".$c11n3; 
        $arraycls[11]=$c11; $arraytip[11]=$t11; }
      else {
        if ((trim($c11n2)=="") && (trim($c11n3)=="")) {         
          $c11 = $c11l1.$c11n1.$c11l2; $arraycls[11]=$c11; $arraytip[11]=$t11; }
        else {  
          mensajenew('Error en la Clasificacion No. 11 ...!!!','javascript:history.back();','N');
	       $smarty->display('pie_pag.tpl'); exit(); } }      
      if ((trim($c12n2)!="") && (trim($c12n3)!="")) {   
        $c12 = $c12l1.$c12n1.$c12l2." ".$c12n2."/".$c12n3; 
        $arraycls[12]=$c12; $arraytip[12]=$t12; }
      else {
        if ((trim($c12n2)=="") && (trim($c12n3)=="")) {         
          $c12 = $c12l1.$c12n1.$c12l2; $arraycls[12]=$c12; $arraytip[12]=$t12; }
        else {  
          mensajenew('Error en la Clasificacion No. 12 ...!!!','javascript:history.back();','N');
	       $smarty->display('pie_pag.tpl'); exit(); } }
	             
      // Chequeo si introdujo alguna Clasificacion o todas estan en blanco  
      //if  (empty($c1) && empty($c2) && empty($c3) && empty($c4) && empty($c5) && empty($c6) && 
      //     empty($c7) && empty($c8) && empty($c9) && empty($c10) && empty($c11) && empty($c12)) { 
      //  mensajenew('No introdujo ninguna Clasificacion ...!!!','javascript:history.back();','N');
      //  $smarty->display('pie_pag.tpl'); exit(); }

      // Verifico que haya especificado el tipo de Clasificacion 
      if ($c1!="") {
        if ($t1=="") {
          mensajenew('No especifico el Tipo de Clasificacion en la No. 1 ...!!!','javascript:history.back();','N');
          $smarty->display('pie_pag.tpl'); exit(); } }
      if ($c2!="") {
        if ($t2=="") {
          mensajenew('No especifico el Tipo de Clasificacion en la No. 2 ...!!!','javascript:history.back();','N');
          $smarty->display('pie_pag.tpl'); exit(); } }
      if ($c3!="") {
        if ($t3=="") {
          mensajenew('No especifico el Tipo de Clasificacion en la No. 3 ...!!!','javascript:history.back();','N');
          $smarty->display('pie_pag.tpl'); exit(); } }
      if ($c4!="") {
        if ($t4=="") {
          mensajenew('No especifico el Tipo de Clasificacion en la No. 4 ...!!!','javascript:history.back();','N');
          $smarty->display('pie_pag.tpl'); exit(); } }
      if ($c5!="") {
        if ($t5=="") {
          mensajenew('No especifico el Tipo de Clasificacion en la No. 5 ...!!!','javascript:history.back();','N');
          $smarty->display('pie_pag.tpl'); exit(); } }
      if ($c6!="") {
        if ($t6=="") {
          mensajenew('No especifico el Tipo de Clasificacion en la No. 6 ...!!!','javascript:history.back();','N');
          $smarty->display('pie_pag.tpl'); exit(); } }
      if ($c7!="") {
        if ($t7=="") {
          mensajenew('No especifico el Tipo de Clasificacion en la No. 7 ...!!!','javascript:history.back();','N');
          $smarty->display('pie_pag.tpl'); exit(); } }
      if ($c8!="") {
        if ($t8=="") {
          mensajenew('No especifico el Tipo de Clasificacion en la No. 8 ...!!!','javascript:history.back();','N');
          $smarty->display('pie_pag.tpl'); exit(); } }
      if ($c9!="") {
        if ($t9=="") {
          mensajenew('No especifico el Tipo de Clasificacion en la No. 9 ...!!!','javascript:history.back();','N');
          $smarty->display('pie_pag.tpl'); exit(); } }
      if ($c10!="") {
        if ($t10=="") {
          mensajenew('No especifico el Tipo de Clasificacion en la No. 10 ...!!!','javascript:history.back();','N');
          $smarty->display('pie_pag.tpl'); exit(); } }
      if ($c11!="") {
        if ($t11=="") {
          mensajenew('No especifico el Tipo de Clasificacion en la No. 11 ...!!!','javascript:history.back();','N');
          $smarty->display('pie_pag.tpl'); exit(); } }
      if ($c12!="") {
        if ($t12=="") {
          mensajenew('No especifico el Tipo de Clasificacion en la No. 12 ...!!!','javascript:history.back();','N');
          $smarty->display('pie_pag.tpl'); exit(); } }

     $numcip = 0;
     $inscip = true;
     for ($cont=1;$cont<=12;$cont++) {
       $valor=$arraycls[$cont];
       if (!empty($valor)) {
         $clsfd = $arraycls[$cont];  
         $tipcl = $arraytip[$cont];
         $col_campos = "nro_derecho,clasificacion,tipo_clas";
         $insert_str = "'$prox_derecho','$clsfd','$tipcl'";
         $inscip = $sql->insert("$tbname_16","$col_campos","$insert_str","");
         if (!$inscip) { $numcip = $numcip + 1; }
       } 
     }
    }

    $numinv = 0; 
    $insinv = true;
    // Tabla de Inventores    
    $res_inv=pg_exec("SELECT * FROM $tbname_11 where solicitud='$varsol'");
    $filas_res_inv=pg_numrows($res_inv); 
    $reginv = pg_fetch_array($res_inv);
    for($i=0;$i<$filas_res_inv;$i++) { 
      $obj_query = $sql->query("SELECT * FROM $tbname_8 WHERE nro_derecho='$prox_derecho' AND nombre_inv='$reginv[prioridad]'");
      if (!$obj_query) { 
         Mensajenew("Problema al intentar realizar la consulta en la tabla $tbname_8 ...!!!","javascript:history.back();","N");
         $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
      $filas_inventor=$sql->nums('',$obj_query);
      if ($filas_inventor==0) {
         $nbinv = $reginv[nombre_inv];
         $nbinv = str_replace("'","´",$nbinv); 
         $col_campos = "nro_derecho,nombre_inv,nacionalidad";
         $insert_str = "'$prox_derecho','$nbinv','$reginv[nacionalidad]'";
         $insinv = $sql->insert("$tbname_8","$col_campos","$insert_str","");
         if ($insinv) { }
         else { $numinv = $numinv + 1; }  
      } 
      $reginv = pg_fetch_array($res_inv); 
    }
    $del_datos = $sql->del("$tbname_11","solicitud='$varsol'");
    
    $numprio = 0; 
    $insprio = true;
    // Tabla de Prioridades   
    $res_prio=pg_exec("SELECT * FROM $tbname_19 where solicitud='$varsol' AND tipo_mp='P'");
    $filas_res_prio=pg_numrows($res_prio); 
    $regprio = pg_fetch_array($res_prio);
    for($i=0;$i<$filas_res_prio;$i++) { 
      $obj_query = $sql->query("SELECT * FROM $tbname_15 WHERE nro_derecho='$prox_derecho' AND prioridad='$regprio[prioridad]'");
      if (!$obj_query) { 
         Mensajenew("Problema al intentar realizar la consulta en la tabla $tbname_15 ...!!!","javascript:history.back();","N");
         $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
      $filas_prioridad=$sql->nums('',$obj_query);
      if ($filas_prioridad==0) {
         $col_campos = "nro_derecho,prioridad,pais_priori,fecha_priori";
         $insert_str = "'$prox_derecho','$regprio[prioridad]','$regprio[pais_priori]','$regprio[fecha_priori]'";
         $insprio = $sql->insert("$tbname_15","$col_campos","$insert_str","");
         if ($insprio) { }
         else { $numprio = $numprio + 1; }  
      } 
      $regprio = pg_fetch_array($res_prio); 
    }
    $del_datos = $sql->del("$tbname_19","solicitud='$varsol' AND tipo_mp='P'");

    // Tabla de Agentes  
    $res_agen=pg_exec("SELECT * FROM $tbname_18 where solicitud='$varsol' AND tipo_mp='P' ORDER BY agente");
    $filas_res_age=pg_numrows($res_agen); 
    $regagen = pg_fetch_array($res_agen);
    
    $numagen = 0; 
    $insagen = true;
    for($i=0;$i<$filas_res_age;$i++) 
    {
     if ($i!=0) {
       if ($regagen[agente]!="0") {
           $obj_query = $sql->query("SELECT * FROM $tbname_17 WHERE nro_derecho='$prox_derecho' AND agente='$regagen[agente]'"); 
           if (!$obj_query) { 
             Mensajenew("Problema al intentar realizar la consulta en la tabla $tbname_17 ...!!!","javascript:history.back();","N");
             $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
           $filas_agente=$sql->nums('',$obj_query);
           if ($filas_agente==0) {
             $col_campos = "nro_derecho,agente";
             $insert_str = "'$prox_derecho','$regagen[agente]'";
             $insagen = $sql->insert("$tbname_17","$col_campos","$insert_str","");
             if ($insagen) { }
             else { $numagen = $numagen + 1; }  
           } 
       }
     }
     $regagen = pg_fetch_array($res_agen); 
    }
    $del_datos = $sql->del("$tbname_18","solicitud='$varsol' AND tipo_mp='P'");

    // Tabla de Solicitantes o Titulares 
    $res_titu=pg_exec("SELECT * FROM $tbname_9 WHERE solicitud='$varsol' AND tipo_mp='P'");
    $filas_res_titu=pg_numrows($res_titu); 
    $regtitu = pg_fetch_array($res_titu);
    $numtitu = 0; 
    $ins_solic = true;
    $ins_titur = true; 
    for($i=0;$i<$filas_res_titu;$i++) 
    { 
     if ($regtitu[titular]=="0")
       {
         $col_campos = "titular,identificacion,nombre,indole,telefono1,telefono2,fax,email";
         $vident = $regtitu[identificacion];
         $regtitu[nombre] = str_replace("'","´",$regtitu[nombre]);
         $insert_str = "nextval('stzsolic_titular_seq'),'$regtitu[identificacion]','$regtitu[nombre]','$regtitu[indole]','$regtitu[telefono1]','$regtitu[telefono2]','$regtitu[fax]','$regtitu[email]'";
         $ins_solic = $sql->insert("$tbname_3","$col_campos","$insert_str","");

         $obj_query = $sql->query("select last_value from stzsolic_titular_seq");
         $objs = $sql->objects('',$obj_query);
         $act_titular = $objs->last_value;
         $regtitu[domicilio] = str_replace("'","´",$regtitu[domicilio]);

         $col_campos = "nro_derecho,titular,nacionalidad,domicilio,pais_domicilio";
         $insert_str = "'$prox_derecho','$act_titular','$regtitu[nacionalidad]','$regtitu[domicilio]',
'$regtitu[pais_domicilio]'";
         $ins_titur = $sql->insert("$tbname_7","$col_campos","$insert_str","");
         if ($ins_solic AND $ins_titur) { }
         else { $numtitu = $numtitu + 1; }  
       }
     else
       {
         $obj_query = $sql->query("SELECT * FROM $tbname_7 WHERE nro_derecho='$prox_derecho' AND titular='$regtitu[titular]'");
         if (!$obj_query) { 
           Mensajenew("Problema al intentar realizar la consulta en la tabla $tbname_7 ...!!!","javascript:history.back();","N");
           $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
         $filas_titular=$sql->nums('',$obj_query);
         if ($filas_titular==0) {
           $col_campos = "nro_derecho,titular,nacionalidad,domicilio,pais_domicilio";
           $insert_str = "'$prox_derecho','$regtitu[titular]','$regtitu[nacionalidad]','$regtitu[domicilio]',
'$regtitu[pais_domicilio]'";
           $ins_titur = $sql->insert("$tbname_7","$col_campos","$insert_str","");
           if ($ins_titur) { }
           else { $numtitu = $numtitu + 1; }  
         } 
       }
     $regtitu = pg_fetch_array($res_titu);
    }
    $del_datos = $sql->del("$tbname_9","solicitud='$varsol' AND tipo_mp='P'");

    if ($numtitu==0 AND $numcip==0 AND $numprio==0 AND $numagen==0 AND  
        $instram AND $inspaten AND $insderecho AND $insanual AND $inslocar) {
      pg_exec("COMMIT WORK");
      //Desconexion de la Base de Datos
      $sql->disconnect();
      
      Mensajenew('DATOS GUARDADOS CORRECTAMENTE !!!','p_ingsol55.php?vopc=3&nconex=$n_conex&salir=1&conx=0','S');
      $smarty->display('pie_pag.tpl'); exit();
    } 
    else {
      pg_exec("ROLLBACK WORK");
      //Desconexion de la Base de Datos
      $sql->disconnect();

      if (!$insanual)   { $error_anu = " - Anualidad "; }
      if (!$instram)    { $error_tra = " - Tramite "; }
      if (!$inslocar)   { $error_loc = " - Locarno "; }
      if (!$inspaten)   { $error_pat = " - Patentes "; }
      if (!$insderecho) { $error_der = " - Derecho "; }
      if ($numtitu!=0)  { $error_tit = " - Titular(es) "; }
      if ($numinv!=0)   { $error_inv = " - Inventores "; }
      if ($numprio!=0)  { $error_pri = " - Prioridad "; }
      if ($numagen!=0)  { $error_age = " - Agente(s) "; }
      if ($numcip!=0)   { $error_cip = " - Clasificaci&oacute;n Internacional "; }
            
      Mensajenew("Falla de Actualizaci&oacute;n / Inserci&oacute;n de Datos en la BD $error_anu, $error_tra, $error_loc, $error_pat, $error_der, $error_tit, $error_inv, $error_pri, $error_age, $error_cip ...!!!","javascript:history.back();","N");
      $smarty->display('pie_pag.tpl'); exit();
    }

  }
}

//Pase de variables y Etiquetas al template
$smarty->assign('campo1','Expediente No.:');
$smarty->assign('campo2','Fecha Expediente:');
$smarty->assign('campo3','Tipo de Patente:');
$smarty->assign('campo4','T&iacute;tulo:');
$smarty->assign('campo5','Dibujo o Dise&ntilde;o:');
$smarty->assign('campo6','Inventor(es):');
$smarty->assign('campo7','&nbsp;&nbsp;Pa&iacute;s de Residencia:');
$smarty->assign('campo8','Resumen:');
$smarty->assign('campo9','&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Inventor(es):');
$smarty->assign('campo10','Titular(es):');
$smarty->assign('campo11','Poder:');
$smarty->assign('campo12','Agente(s):');
$smarty->assign('campo13','Tramitante:');
$smarty->assign('campo14','Clasificaci&oacute;n Locarno:');
$smarty->assign('campo15','Edici&oacute;n:');
$smarty->assign('campo16','Clasificaci&oacute;n Internacional');
$smarty->assign('campo17','Prioridad(es):');
$smarty->assign('campo18','Anualidad No.:');
$smarty->assign('campo19','Planilla No.:');
$smarty->assign('campo20','Tasa No.:');
$smarty->assign('campo21','Monto:');

$smarty->assign('anualidad',$anualidad);
$smarty->assign('usuario',$usuario);
$smarty->assign('depto_id',$depto_id);
$smarty->assign('role',$role);
$smarty->assign('arraycodpais',$arraycodpais);
$smarty->assign('arraynompais',$arraynompais);
$smarty->assign('vcodagenew',$vcodagenew);
$smarty->assign('vnomagenew',$vnomagenew);
$smarty->assign('vcodage',$vcodage);
$smarty->assign('vnomage',$vnomage);
$smarty->assign('vcodpais',$vcodpais);
$smarty->assign('vnompais',$vnompais);
$smarty->assign('nameimage',$nameimage);
$smarty->assign('vsol1',$vsol1);
$smarty->assign('vsol2',$vsol2);
$smarty->assign('varsol',$varsol);
$smarty->assign('dirano',$dirano);
$smarty->assign('nombre',$nombre);
$smarty->assign('agen_id',$vcodage);
$smarty->assign('pais_resid',$pais_resid);
$smarty->assign('vcodpais',$vcodpais);
$smarty->assign('tramitante',$tramitante);
$smarty->assign('fecha_solic',$fecha_solic);
$smarty->assign('resumen',$resumen);
$smarty->assign('vpod1',$vpod1);
$smarty->assign('vpod2',$vpod2);
$smarty->assign('campos',$campos);
$smarty->assign('vopc',$vopc);
$smarty->assign('psoli',$vsol); 

$smarty->display('p_ingsol55.tpl');
$smarty->display('pie_pag.tpl');
?>
