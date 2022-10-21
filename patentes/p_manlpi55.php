<script language="Javascript"> 

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

function browsecip(var1,var2,var3,var4) {
  open("adm_cip.php?vsol="+var1.value+"-"+var2.value+"&vtex="+var3.value+"&vmod="+var4.value,"Ventana", "scrollbars=yes,toolbar=no,directories=no,menubar=no,status=no"); }

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
 
</script>

<?php
// ************************************************************************************* 
// Programa: p_manlpi55.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Creado Año 2006 
// Modificado Año: 2009 BD - Relacional 
// *************************************************************************************
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");
//Clase que sube un archivo de imagen
include ("$include_lib/upload_class.php"); 

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variables
$usuario = trim($_SESSION['usuario_login']);
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
$tbname_21 = "stptmpcip";

$vopc     = $_GET['vopc'];
$vuser    = $_GET['vuser'];
$vaccion  = $_GET['vaccion'];
$vauxnum  = $_GET['vauxnum'];
$vsol1    = $_POST['vsol1'];
$vsol2    = $_POST['vsol2'];
$vsol     = $_POST['vsol'];
$psoli    = $_POST['psoli'];
$vder     = $_POST['vder'];

$fecha_solic=$_POST['fecha_solic'];
$tipo_paten=$_POST['tipo_paten'];
$nombre=$_POST['nombre'];
$agen_id=$_POST['agen_id'];
$vage1=$_POST['vagen'];
$vpod1=$_POST['vpod1'];
$vpod2=$_POST['vpod2'];
$tramitante=$_POST['tramitante'];
$pais_resid=$_POST['pais_resid'];
$resumen=$_POST['resumen'];
$dirano= $_POST['dirano'];
$vstring=$_POST['vstring'];
$vstring1=$_POST['vstring1'];
$vstring2=$_POST['vstring2'];
$campos=$_POST['campos'];
$accion=$_POST['accion'];
$vnumclase=$_POST['options'];
$vcodpais=$_POST['vcodpais'];
$arraynompais=$_POST['vnompais'];
$vcodage=$_POST['vcodage'];
$vnomagenew=$_POST['vnomage'];
$input1=$_POST['input1'];
$input2=$_POST['input2'];
$auxnum=$_POST['auxnum'];
$ubicacion=$_POST['ubicacion'];
$nroinv=$_POST['nroinv'];
$anualidad = $_POST['anualidad'];
$planilla  = $_POST['planilla'];
$tasa      = $_POST['tasa'];
$monto     = $_POST['monto'];

// ******************************************************************************************
$smarty->assign('titulo',$substpat);
$smarty->assign('subtitulo','Mantenimiento de Expediente - LPI-55'); 
if (($vopc==4) || ($vopc==1)) {
  $smarty->assign('subtitulo','Mantenimiento de Expediente / Modificaci&oacute;n - LPI-55'); }
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

$smarty->assign('arraytipom',array(N,A,C,E,D,B,G,F,V));
$smarty->assign('arraynotip',array('','INVENCION','DE MEJORA','MODELO INDUSTRIAL','DE INTRODUCCION','DIBUJO INDUSTRIAL','DISE&Ntilde;O INDUSTRIAL','MODELO DE UTILIDAD','VARIEDAD VEGETAL'));

// ************************************************************************************  
$nconexion = $_POST['nconexion'];
if (empty($nconexion)) { $nconexion = $_GET['nconexion']; }
$nveces = $_POST['nveces'];
if (empty($nveces)) { $nveces = $_GET['nveces']; }
// ************************************************************************************  
if (($vopc==1) || ($vopc==3)) {
  $nveces = $nveces + 1; 
  if ($nveces==1) { $nconexion = insconex($usuario,$modulo,'P'); } 

  //Obtencion de los Paises
  $obj_query = $sql->query("SELECT * FROM $tbname_1 order by nombre");
  if (!$obj_query) { 
    mensajenew("ERROR: Problema al intentar realizar la consulta en la tabla  $tbname_1 ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
  $filas_found=$sql->nums('',$obj_query);
  if ($filas_found==0) {
    mensajenew("ERROR: La Tabla de Paises esta Vacia ...!!!","javascript:history.back();","N");
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

//Opcion Modificar
if ($vopc==1) {
  $smarty->assign('modo1','disabled'); 
  $smarty->assign('vmodo',''); 
  $smarty->assign('modo',''); 
  $smarty->assign('modo2',''); 
  $smarty->assign('modo3','disabled'); 
  $smarty->assign('submitbutton3','submit');
  $smarty->assign('submitbutton','button');
  $smarty->assign('subtitulo','Mantenimiento de Expediente / Modificaci&oacute;n - LPI-55'); 
  $smarty->assign('accion',2);

  //Validacion del Numero de Solicitud
  if (empty($vsol1) && empty($vsol2)) {
    Mensajenew("ERROR: No introdujo ningun valor de Expediente ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }

  if (($vsol1=="0000") || ($vsol2=="000000")) { 
    Mensajenew("ERROR: Numero de Solicitud Vacio o Erroneo ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }

  //Armado del Numero de Expediente
  $varsol=$vsol1."-".sprintf("%06d",$vsol2);
  $dirano=$vsol1;
  //Variable Numero del Expediente
  $numero=substr($varsol,-6,6);

  if (($varsol=="-") || ($varsol=="0000-000000")) {
    Mensajenew("ERROR: Numero de Solicitud Vacio ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }
  
  //Verificando conexion
  $sql->connection($usuario);
  
  $resultado=pg_exec("SELECT * FROM $tbname_6 WHERE solicitud='$varsol' and solicitud!='' AND tipo_mp='P'");

  if (!$resultado) { 
     mensajenew("ERROR: PROBLEMA AL PROCESAR LA BUSQUEDA ...!!!","javascript:history.back();","N");
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  }	 
  $filas_found=pg_numrows($resultado); 
  if ($filas_found==0) {
     mensajenew("ERROR: NO EXISTEN DATOS ASOCIADOS ...!!!","javascript:history.back();","N");
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  }	 
  $reg = pg_fetch_array($resultado);

  $vsol=$reg[solicitud];
  $psoli=$reg[solicitud];
  $smarty->assign('psoli',$psoli); 
  $vsol1=substr($vsol,-11,4);
  $vsol2=substr($vsol,-6,6);
  $estatus=$reg[estatus];

  if (($estatus==2001) || ($estatus==2202) || ($estatus==2004) || ($estatus==2006)) { }  
  else { 
    if (($estatus==2003) || ($estatus==2008) || ($estatus==2010) || ($estatus==2102) || ($estatus==2011) || ($estatus==2200) || ($estatus==2651) || ($estatus==2800) || ($estatus==2806) || ($estatus==2910)) { 
      if (($usuario=='xamaris') || ($usuario=='breyes') || ($usuario=='fastudillo') || ($usuario=='ggalindez') || ($usuario=='ftorrico') || ($usuario=='jgil') ||  ($usuario=='rmendoza') || ($usuario=='ngonzalez')) { }
      else {
        Mensajenew("ERROR: Usuario NO tiene Permiso para modificar bajo este Estatus ...!!!","p_infosol.php?vopc=4","N");
        $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();
      }  
    }
    else {
      if (($usuario=='ggalindez') || ($usuario=='ftorrico') || ($usuario=='jgil') || ($usuario=='fastudillo') || ($usuario=='rmendoza') || ($usuario=='ngonzalez')) { }
      else {
        Mensajenew("ERROR: Usuario NO tiene Permiso para modificar bajo este Estatus ...!!!","p_infosol.php?vopc=4","N");
        $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();
      }
    }
  }
  
  //if (($estatus==2001) || ($estatus==2202) || ($estatus==2004) || ($estatus==2006)) { }
  //else {
  //    //mensajenew("Solo se puede modificar Expedientes en Estatus 1-SOLICITUD PRESENTADA ...!!!","p_manlpi55.php?vopc=4&vaccion=2&vauxnum=0","N");
  //    Mensajenew("ERROR: Solicitud en estatus NO Modificable ...!!!","p_infosol.php?vopc=4","N");
  //    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  //}
  $vder     = $reg[nro_derecho];  
  $registro = $reg[registro];
  $nombre   = trim($reg[nombre]);
  $nombre   = str_replace("'","´",$nombre);
  $vcodpais = $reg[pais_resid];
  $tipo_paten = $reg[tipo_derecho];
  $tramitante = trim($reg[tramitante]);
  $fecha_solic= $reg[fecha_solic];
  $poder = $reg[poder];
  $vpod1 = trim(substr($poder,-9,4));
  $vpod2 = trim(substr($poder,-4,4));
  $vcodage=$reg[agente];
   
  if (!empty($vpod1) && !empty($vpod2))
   { $vpoder= $vpod1."-".$vpod2; } else
   { $vpoder=''; }

  $resumen='';
  //Obtención de datos de la Patente  
  $obj_query = $sql->query("SELECT * FROM $tbname_4 WHERE nro_derecho='$vder'");
  $objs = $sql->objects('',$obj_query);
  $edicion   = $objs->edicion;
  $anualidad = $objs->anualidad;
  $resumen   = trim($objs->resumen);
  $resumen   = str_replace("'","´",$resumen);
  $smarty->assign('vstring1',$resumen);
  $smarty->assign('resumen',$resumen);
  $smarty->assign('tipo_paten',$tipo_paten);
  
  $auxnum = $vsol1;
  $smarty->assign('auxnum',$auxnum);

  //Obtención de datos de la Anualidad   
  $obj_query = $sql->query("SELECT * FROM $tbname_20 WHERE nro_derecho='$vder'");
  $objs = $sql->objects('',$obj_query);
  $anualidad = $objs->anualidad;
  $planilla  = $objs->planilla;
  $tasa      = $objs->tasa;
  $monto     = $objs->monto; 
  $smarty->assign('anualidad',$anualidad);
  $smarty->assign('planilla',$planilla);
  $smarty->assign('tasa',$tasa);
  $smarty->assign('monto',$monto);

  $nameimage = ver_imagen($vsol1,$vsol2,"P");  

  if (!file_exists($nameimage)) {
    $nameimage="../imagenes/sin_imagen8.png"; }
  $smarty->assign('ubicacion',$nameimage);
  
  //Almaceno en un string los valores de los campos antes de modificar alguno
  $pais_resid = $vcodpais;
  if (!empty($vcodagenew)) { $agen_id = $vcodagenew; }
  $valores_fields = array($nombre,$fecha_solic,$tipo_paten,$vcodage,$poder,$tramitante,$vcodpais);
  $campos = "nombre|fecha_solic|tipo_paten|agente|poder|tramitante|pais_resid";
  $vstring = bitacora_fields();
  $smarty->assign('vstring',$vstring);
  $smarty->assign('campos',$campos);
  
  $auxnum = $vsol1;
  $smarty->assign('auxnum',$auxnum);

  // Obtencion de Agentes  
  $sql->del("$tbname_18","solicitud='$varsol' AND tipo_mp='P'");
  if ($vcodage > 0) {
    $obj_query = $sql->query("SELECT * FROM $tbname_2 WHERE agente=$vcodage");
    $objs = $sql->objects('',$obj_query);
    $col_campos = "solicitud,agente,nombre,domicilio,tipo_mp,tipo_per";
    $insert_str = "'$varsol',$vcodage,'$objs->nombre','$objs->domicilio','P','1'";
    $insagen = $sql->insert("$tbname_18","$col_campos","$insert_str",""); }
  $obj_query = $sql->query("SELECT * FROM $tbname_17,$tbname_2 WHERE nro_derecho=$vder AND $tbname_17.agente=$tbname_2.agente ORDER BY $tbname_2.agente");
  $obj_filas = $sql->nums('',$obj_query);
  if ($obj_filas > 0) {  
    $objs = $sql->objects('',$obj_query);
    for ($contobj=0;$contobj<$obj_filas;$contobj++) {
      $vcod = $objs->agente;
      $nomb = $objs->nombre;
      $nomb = str_replace("'","´",$nomb);
      $domi = $objs->domicilio;
      $domi = str_replace("'","´",$domi);
      $col_campos = "solicitud,agente,nombre,domicilio,tipo_mp,tipo_per";
      $insert_str = "'$varsol','$vcod','$nomb','$domi','P','1'";
      $insagen = $sql->insert("$tbname_18","$col_campos","$insert_str","");
      $objs = $sql->objects('',$obj_query); }	  
  }

  // Obtencion de Prioridad   
  $sql->del("$tbname_19","solicitud='$varsol'");
  $obj_query = $sql->query("SELECT * FROM $tbname_15 WHERE nro_derecho=$vder ORDER BY fecha_priori");
  $obj_filas = $sql->nums('',$obj_query);
  if ($obj_filas > 0) {  
    $objs = $sql->objects('',$obj_query);
    for ($contobj=0;$contobj<$obj_filas;$contobj++) {
      $vcod = $objs->prioridad;
      $fech = $objs->fecha_priori;
      $pais = $objs->pais_priori;
      $col_campos = "solicitud,prioridad,pais_priori,fecha_priori,tipo_mp";
      $insert_str = "'$varsol','$vcod','$pais','$fech','P'";
      $insprio = $sql->insert("$tbname_19","$col_campos","$insert_str","");
      $objs = $sql->objects('',$obj_query); }	  
  }
  
  // Obtencion de Inventores    
  $sql->del("$tbname_11","solicitud='$varsol'");
  $obj_query = $sql->query("SELECT * FROM $tbname_8 WHERE nro_derecho=$vder ORDER BY nombre_inv");
  $obj_filas = $sql->nums('',$obj_query);
  if ($obj_filas > 0) {  
    $objs = $sql->objects('',$obj_query);
    for ($contobj=0;$contobj<$obj_filas;$contobj++) {
      $ninventor = trim($objs->nombre_inv);
      $ninventor = str_replace("'","´",$ninventor);
      $nac = $objs->nacionalidad;
      $insert_str = "'$varsol','$ninventor','$nac'";
      $sql->insert("$tbname_11","","$insert_str","");
      $objs = $sql->objects('',$obj_query); }	  
  }

  // Obtencion de Clasificacion Internacional de Patente     
  $sql->del("$tbname_21","solicitud='$varsol'");
  $obj_query = $sql->query("SELECT * FROM $tbname_16 WHERE nro_derecho=$vder");
  $obj_filas = $sql->nums('',$obj_query);
  if ($obj_filas > 0) {  
    $objs = $sql->objects('',$obj_query);
    for ($contobj=0;$contobj<$obj_filas;$contobj++) {
      $clase = trim($objs->clasificacion);
      $tipo = $objs->tipo_clas;
      $insert_str = "'$varsol','$clase','$tipo'";
      $sql->insert("$tbname_21","","$insert_str","");
      $objs = $sql->objects('',$obj_query); }	  
  }

  // Obtencion del o los Titular(es)  
  $sql->del("$tbname_9","solicitud='$varsol'");
  $obj_query = $sql->query("SELECT stzottid.titular,stzsolic.nombre,stzsolic.indole,stzottid.domicilio, stzottid.nacionalidad,stzottid.pais_domicilio
                            FROM stzottid,stzsolic WHERE stzottid.nro_derecho ='$vder' AND  
                                 stzottid.titular=stzsolic.titular");
  $obj_filas = $sql->nums('',$obj_query);
  $objs = $sql->objects('',$obj_query);
  for ($contobj=0;$contobj<$obj_filas;$contobj++) {
     $vcod = $objs->titular;
     $nomb = $objs->nombre;
     $nomb = str_replace("'","´",$nomb); 
     $domi = $objs->domicilio;
     $domi = str_replace("'","´",$domi);
     $pais = $objs->nacionalidad;
     $pdom = $objs->pais_domicilio;
     $indo = $objs->indole;
     if (empty($indo)) { $indo = "P"; }  
     $col_campos = "solicitud,titular,nombre,domicilio,nacionalidad,indole,tipo_mp,pais_domicilio";
     $insert_str = "'$varsol','$vcod','$nomb','$domi','$pais','$indo','P','$pdom'";
     $sql->insert("$tbname_9","$col_campos","$insert_str","");
  $objs = $sql->objects('',$obj_query); }	  
  
 //$smarty->assign('vmodo','readonly=readonly');
 $smarty->assign('vmodo','disabled');
}

//Opcion Grabar...
if (($vopc==2) || ($vopc==6)) {
  //La Fecha de Hoy y Hora para la transaccion
  $fechahoy = hoy();
  $horactual= Hora();

  //Verificando conexion
  $sql->connection($usuario);

  //Validacion del Numero de Solicitud
  if ($accion==2) {
    if (!empty($vsol1) && !empty($vsol2)) { 
      $varsol=$vsol1."-".sprintf("%06d",$vsol2); } 
  else {
    mensajenew("ERROR: Numero de Solicitud Vacio o con Error ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }
  }

  //Verificacion de que los campos requeridos esten llenos...
  $req_fields = array("nombre","fecha_solic","tipo_paten","resumen");
  $valores = array($nombre,$fecha_solic,$tipo_paten,$resumen);
  $vacios = check_empty_fields();
  if (!$vacios) { 
     mensajenew("ERROR: Hay Informacion en el formulario que esta Vacia ...!!!","javascript:history.back();","N");
     $smarty->display('pie_pag.tpl'); exit(); }
  
  $esmayor=compara_fechas($fecha_solic,$fechahoy);
  if ($esmayor==1) {
    mensajenew("ERROR: La Fecha de Solicitud No puede ser mayor a la de Hoy ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }
 
  $annno= Obtener_anno($fecha_solic,0);
  if ($dirano != $annno) { 
    Mensage_Error("ERROR: Los Cuatros primeros digitos del Expediente no son iguales a los cuatros ultimos de su Fecha ...!!!");
    $smarty->display('pie_pag.tpl'); exit();  }
    
  $varsol=$vsol1."-".$vsol2;
  $restitu=pg_exec("SELECT * FROM $tbname_9 where solicitud='$varsol'");
  $filas_titular=pg_numrows($restitu); 
  if ($filas_titular==0) {
    mensajenew("ERROR: Expediente $varsol sin ningun Titular asociado ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); 
  }

  if ($tipo_paten=='N') {  
    Mensage_Error("ERROR: No ha seleccionado el Tipo de Patente ...!!!");
    $smarty->display('pie_pag.tpl'); exit();  }

  if (empty($vcodpais)) {
    Mensajenew("ERROR: Expediente $varsol sin ningun Pa&iacute;s de Residencia asociado ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); } 

  $vcodage=0;
  // Validacion de Agentes  
  $res_agen=pg_exec("SELECT * FROM $tbname_18 where solicitud='$varsol' AND tipo_mp='P' ORDER BY agente");
  $filas_res_age=pg_numrows($res_agen); 
  $regagen = pg_fetch_array($res_agen);
  if ($filas_res_age==0) { $vcodage=0; }
  else { 
   if ($regagen[agente]!="0") { 
     $vcodage=$regagen[agente]; 
     $del_datos = $sql->del("$tbname_18","solicitud='$varsol' AND agente=$vcodage AND tipo_mp='P'"); } 
  } 

  if (empty($input2)) { $vcodpais=""; 
      mensajenew("AVISO: Debe indicar Pais de Residencia ...!!!","javascript:history.back();","N");
      $smarty->display('pie_pag.tpl'); exit(); }

  //Validacion del Poder
  if (!empty($vpod1) && !empty($vpod2))
   { $vpoder= $vpod1."-".sprintf("%04d",$vpod2); } else
   { $vpoder=""; }

  if (empty($tramitante) && empty($vpoder) && empty($vcodage)) {
      mensajenew("AVISO: Debe tener Tramitante o Poder o Agente(s) ...!!!","javascript:history.back();","N");
      $smarty->display('pie_pag.tpl'); exit(); }

  if ($tramitante!="") {
    if (($vpoder!="") || ($vcodage!="0")) {
      mensajenew("AVISO: Solo puede tener Tramitante o Poder o Agente(s) ...!!!","javascript:history.back();","N");
      $smarty->display('pie_pag.tpl'); exit(); } }

  $obj_query = $sql->query("SELECT * FROM $tbname_11 WHERE solicitud ='$varsol'");
  $obj_filas = $sql->nums('',$obj_query);
  if ($obj_filas==0) {
    Mensajenew("ERROR: Solicitud $varsol sin Inventor(es) asociado(s) ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }

  if ($accion==1) {
    // Ingreso de Solicitud
  } //Incluir
  else {
    // Modificar Solicitud
    $varsol = sprintf("%02d-%06d",$vsol1,$vsol2);

    pg_exec("BEGIN WORK");
    $updanual = true;
    $updpaten = true;
    $updderecho = true; 

    //Actualizacion del estatus del expediente en la maestra de patentes 
    pg_exec("LOCK TABLE stzderec IN SHARE ROW EXCLUSIVE MODE");
    $nombre = str_replace("'","´",$nombre);
    $tramitante = str_replace("'","´",$tramitante);
    $update_str = "fecha_solic='$fecha_solic',tipo_derecho='$tipo_paten',nombre='$nombre',
    poder='$vpoder',agente='$vcodage',tramitante='$tramitante',pais_resid='$input2'";
    $updderecho = $sql->update("$tbname_6","$update_str","nro_derecho='$vder'");

    //Actualizacion del resto de los datos de la maestra de Patentes  
    $vres = str_replace("'","´",$resumen);
    pg_exec("LOCK TABLE stppatee IN SHARE ROW EXCLUSIVE MODE");
    $update_str = "resumen = '$vres'";
    $updpaten = $sql->update("$tbname_4","$update_str","nro_derecho='$vder'");

    //Actualizacion de la maestra de eventos de tramite
    $update_str = "fecha_event='$fecha_solic'";
    $updtramite = $sql->update("$tbname_5","$update_str","nro_derecho='$vder' AND evento=2200");

    //Datos de Anualidad 
    pg_exec("LOCK TABLE stpanual IN SHARE ROW EXCLUSIVE MODE");
    //$update_str = "fecha_anual='$fecha_solic',planilla='$planilla',tasa='$tasa',monto=$monto";
    //$updanual   = $sql->update("$tbname_20","$update_str","nro_derecho='$vder'");

    // Tabla de Agentes  
    pg_exec("LOCK TABLE stzautod IN SHARE ROW EXCLUSIVE MODE");
    $del_datos = $sql->del("$tbname_17","nro_derecho='$vder'");
    $res_agen=pg_exec("SELECT * FROM $tbname_18 where solicitud='$varsol' AND tipo_mp='P' ORDER BY agente");
    $filas_res_age=pg_numrows($res_agen); 
    $regagen = pg_fetch_array($res_agen);
    
    $numagen = 0; 
    $insagen = true;
    for($i=0;$i<$filas_res_age;$i++) 
    {
     if ($i!=0) {
       if ($regagen[agente]!="0") {
           $obj_query = $sql->query("SELECT * FROM $tbname_17 where nro_derecho='$vder' and agente='$regagen[agente]'");
           if (!$obj_query) { 
             Mensajenew("ERROR: Problema al intentar realizar la consulta en la tabla $tbname_17 ...!!!","javascript:history.back();","N");
             $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
           $filas_agente=$sql->nums('',$obj_query);
           if ($filas_agente==0) {
             $col_campos = "nro_derecho,agente";
             $insert_str = "'$vder','$regagen[agente]'";
             $insagen = $sql->insert("$tbname_17","$col_campos","$insert_str","");
             if ($insagen) { }
             else { $numagen = $numagen + 1; }  
           } 
       }
     }
     $regagen = pg_fetch_array($res_agen); 
    }
    $del_datos = $sql->del("$tbname_18","solicitud='$varsol' AND tipo_mp='P'");

    $numprio = 0; 
    $insprio = true;
    // Tabla de Prioridades   
    pg_exec("LOCK TABLE stzpriod IN SHARE ROW EXCLUSIVE MODE");
    $del_datos = $sql->del("$tbname_15","nro_derecho='$vder'");
    $res_prio=pg_exec("SELECT * FROM $tbname_19 where solicitud='$varsol' AND tipo_mp='P'");
    $filas_res_prio=pg_numrows($res_prio); 
    $regprio = pg_fetch_array($res_prio);
    for($i=0;$i<$filas_res_prio;$i++) { 
      $obj_query = $sql->query("SELECT * FROM $tbname_15 where nro_derecho='$vder' AND prioridad='$regprio[prioridad]'");
      if (!$obj_query) { 
         Mensajenew("ERROR: Problema al intentar realizar la consulta en la tabla $tbname_15 ...!!!","javascript:history.back();","N");
         $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
      $filas_prioridad=$sql->nums('',$obj_query);
      if ($filas_prioridad==0) {
         $col_campos = "nro_derecho,prioridad,pais_priori,fecha_priori";
         $insert_str = "'$vder','$regprio[prioridad]','$regprio[pais_priori]','$regprio[fecha_priori]'";
         $insprio = $sql->insert("$tbname_15","$col_campos","$insert_str","");
         if ($insprio) { }
         else { $numprio = $numprio + 1; }  
      } 
      $regprio = pg_fetch_array($res_prio); 
    }
    $del_datos = $sql->del("$tbname_19","solicitud='$varsol' AND tipo_mp='P'");

    $numinv = 0; 
    $insinv = true;
    // Tabla de Inventores    
    pg_exec("LOCK TABLE stpinved IN SHARE ROW EXCLUSIVE MODE");
    $del_datos = $sql->del("$tbname_8","nro_derecho='$vder'");
    $res_inv=pg_exec("SELECT * FROM $tbname_11 where solicitud='$varsol'");
    $filas_res_inv=pg_numrows($res_inv); 
    $reginv = pg_fetch_array($res_inv);
    for($i=0;$i<$filas_res_inv;$i++) { 
      $obj_query = $sql->query("SELECT * FROM $tbname_8 WHERE nro_derecho='$vder' AND nombre_inv='$reginv[nombre_inv]'");
      if (!$obj_query) { 
         Mensajenew("ERROR: Problema al intentar realizar la consulta en la tabla $tbname_8 ...!!!","javascript:history.back();","N");
         $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
      $filas_inventor=$sql->nums('',$obj_query);
      if ($filas_inventor==0) {
         $ninventor = trim($reginv[nombre_inv]); 
         $ninventor = str_replace("'","´",$ninventor);
         $col_campos = "nro_derecho,nombre_inv,nacionalidad";
         $insert_str = "'$vder','$ninventor','$reginv[nacionalidad]'";
         $insinv = $sql->insert("$tbname_8","$col_campos","$insert_str","");
         if ($insinv) { }
         else { $numinv = $numinv + 1; }  
      } 
      $reginv = pg_fetch_array($res_inv); 
    }
    $del_datos = $sql->del("$tbname_11","solicitud='$varsol'");

    $numcip = 0;
    $inscip = true;
    // Tabla de CIP  
    pg_exec("LOCK TABLE stpclsfd IN SHARE ROW EXCLUSIVE MODE");
    $del_datos = $sql->del("$tbname_16","nro_derecho='$vder'");
    $obj_query = $sql->query("SELECT * FROM $tbname_21 WHERE solicitud ='$varsol'");
    $obj_filas = $sql->nums('',$obj_query);
    $objs = $sql->objects('',$obj_query);
    for ($contobj=0;$contobj<$obj_filas;$contobj++) {
      $clase = $objs->clasificacion;
      $tipo = $objs->tipo_clas;
      $insert_str = "'$vder','$clase','$tipo'";
      $inscip = $sql->insert("$tbname_16","","$insert_str",""); 
      if ($inscip) { }
      else { $numcip = $numcip + 1; }  
      $objs = $sql->objects('',$obj_query); }
    $del_datos = $sql->del("$tbname_21","solicitud='$varsol'");

    // Tabla de Solicitantes o Titulares 
    $res_titu=pg_exec("SELECT * FROM $tbname_9 where solicitud='$varsol' AND tipo_mp='P'");
    $filas_res_titu=pg_numrows($res_titu); 
    $regtitu = pg_fetch_array($res_titu);

    $numtitu = 0; 
    $ins_solic = true;
    $ins_titur = true; 
    $del_datos = $sql->del("$tbname_7","nro_derecho='$vder'");
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
         $insert_str = "'$vder','$act_titular','$regtitu[nacionalidad]','$regtitu[domicilio]','$regtitu[pais_domicilio]'";
         $ins_titur = $sql->insert("$tbname_7","$col_campos","$insert_str","");
         if ($ins_solic AND $ins_titur) { }
         else { $numtitu = $numtitu + 1; }  
       }
     else
       {
         $obj_query = $sql->query("SELECT * FROM $tbname_7 where nro_derecho='$vder' and titular='$regtitu[titular]'");
         if (!$obj_query) { 
           Mensajenew("ERROR: Problema al intentar realizar la consulta en la tabla $tbname_7 ...!!!","javascript:history.back();","N");
           $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
         $filas_titular=$sql->nums('',$obj_query);
         if ($filas_titular==0) {
           $col_campos = "nro_derecho,titular,nacionalidad,domicilio,pais_domicilio";
           $insert_str = "'$vder','$regtitu[titular]','$regtitu[nacionalidad]','$regtitu[domicilio]','$regtitu[pais_domicilio]'";
           $ins_titur = $sql->insert("$tbname_7","$col_campos","$insert_str","");
           if ($ins_titur) { }
           else { $numtitu = $numtitu + 1; }  
         } 
       }
     $regtitu = pg_fetch_array($res_titu);
    }
    $del_datos = $sql->del("$tbname_9","solicitud='$varsol' AND tipo_mp='P'");

    if ($numtitu==0 AND $numcip==0 AND $numprio==0 AND $numagen==0 AND 
        $numinv==0 AND $updanual AND $updpaten AND $updderecho) {

      pg_exec("COMMIT WORK");
      //Desconexion de la Base de Datos
      $sql->disconnect();

      Mensajenew("DATOS GUARDADOS CORRECTAMENTE ...!!!","p_manlpi55.php?vopc=4&nconexion=".$nconexion."&nveces=".$nveces,"S");
      $smarty->display('pie_pag.tpl'); exit();
    } 
    else {
      pg_exec("ROLLBACK WORK");
      //Desconexion de la Base de Datos
      $sql->disconnect();

      if (!$updderecho) { $error_der = " - Derecho "; }
      if (!$updpaten)   { $error_pat = " - Patentes "; }
      if (!$updanual)   { $error_anu = " - Anualidad "; }
      if ($numtitu!=0)  { $error_tit = " - Titular(es) "; }
      if ($numinv!=0)   { $error_inv = " - Inventores "; }
      if ($numprio!=0)  { $error_pri = " - Prioridad "; }
      if ($numagen!=0)  { $error_age = " - Agente(s) "; }
      if ($numcip!=0)   { $error_cip = " - Clasificaci&oacute;n Internacional "; }
            
      Mensajenew("ERROR: Falla de Actualizaci&oacute;n / Inserci&oacute;n de Datos en la BD $error_anu, $error_pat, $error_der, $error_tit, $error_inv, $error_pri, $error_age, $error_cip ...!!!","javascript:history.back();","N");
      $smarty->display('pie_pag.tpl'); exit();
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
  $smarty->assign('psoli',$vsol); 
  $smarty->assign('modo','readonly=readonly'); 
}

if ($vopc==4) {
  $smarty->assign('subtitulo','Mantenimiento de Expediente / Modificaci&oacute;n - LPI-55');
  $smarty->assign('varfocus','formarcas1.vsol1'); 
  $smarty->assign('submitbutton','submit');
  $smarty->assign('modo1','disabled'); 
  $smarty->assign('modo2','disabled'); 
  $smarty->assign('modo3','disabled'); 
  $smarty->assign('submitbutton3','button');
  $smarty->assign('vmodo',''); 
  $smarty->assign('psoli',$vsol); 
  $smarty->assign('modo','readonly=readonly'); 
  $smarty->assign('accion',2);
  $smarty->assign('auxnum',0);
  $nameimage="../imagenes/sin_imagen8.png";
}

//Pase de variables y Etiquetas al template
$smarty->assign('campo1','Expediente No.:');
$smarty->assign('campo2','Fecha Expediente:');
$smarty->assign('campo3','Tipo de Patente:');
$smarty->assign('campo4','Nombre:');
$smarty->assign('campo5','Dibujo o Dise&ntilde;o:');
$smarty->assign('campo6','Inventor(es):');
$smarty->assign('campo7','&nbsp;&nbsp;Pais de Residencia:');
$smarty->assign('campo8','Resumen:');
$smarty->assign('campo9','Inventor(es):');
$smarty->assign('campo10','Titular(es):');
$smarty->assign('campo11','Poder:');
$smarty->assign('campo12','Agente:');
$smarty->assign('campo13','Tramitante:');
$smarty->assign('campo14','Clasificaci&oacute;n Locarno:');
$smarty->assign('campo15','Edici&oacute;n:');
$smarty->assign('campo16','Clasificaci&oacute;n Internacional');
$smarty->assign('campo17','Prioridad(es):');
$smarty->assign('campo18','Anualidad No.:');
$smarty->assign('campo19','Planilla No.:');
$smarty->assign('campo20','Tasa No.:');
$smarty->assign('campo21','Monto:');

if ($vopc==1) {
  $smarty->assign('varfocus','formarcas2.fecha_solic');
  $smarty->assign('submitbutton','button');
  $smarty->assign('tipo_paten','V');
  $smarty->assign('tipo_paten',$tipo_paten);
 }

if ($vopc==2) {
  $smarty->assign('varfocus','formarcas1.vsol1'); 
  $smarty->assign('modo',''); 
  $smarty->assign('psoli',$vsol); 
  $smarty->assign('submitbutton','submit');
  $smarty->assign('tipo_paten',$tipo_paten); }

$smarty->assign('usuario',$usuario);
$smarty->assign('role',$role);
$smarty->assign('vder',$vder);
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
$smarty->assign('vcodclase',$vcodclase);
$smarty->assign('vnomclase',$vnomclase);
$smarty->assign('options',$vclase);
$smarty->assign('vopc',$vopc);

$smarty->display('p_manlpi55.tpl');
$smarty->display('pie_pag.tpl');
?>
