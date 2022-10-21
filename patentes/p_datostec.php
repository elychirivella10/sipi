<!-- DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd" -->

<head>
<!-- TinyMCE -->
  <script type="text/javascript" src="../include/jscripts/tiny_mce/tiny_mce.js"></script>
  <script type="text/javascript">
	tinyMCE.init({
		// General options
		mode : "exact",
		elements : "vresumen-malo",
		theme : "advanced",
		skin : "o2k7",
		plugins : "safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,inlinepopups",

		// Theme options
		theme_advanced_buttons1 : "newdocument,|,bold,italic,underline,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,|,undo,redo,|,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor",
		theme_advanced_buttons3 : "tablecontrols,|,hr,|,sub,sup,|,charmap,emotions,iespell,|,print,|,ltr,rtl,|,fullscreen",
		theme_advanced_buttons4 : "moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,|,visualchars,nonbreaking",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,

		// Example content CSS (should be your site CSS)
		content_css : "css/content.css",

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "lists/template_list.js",
		external_link_list_url : "lists/link_list.js",
		external_image_list_url : "lists/image_list.js",
		media_external_list_url : "lists/media_list.js",

		// Replace values for the template plugin
		template_replace_values : {
			username : "Some User",
			staffid : "991235"
		}
	});
  </script>
<!-- /TinyMCE -->

<script language="Javascript"> 

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

function browsequivap(var1,var2,var3,var4) {
  open("adm_equiv.php?vsol="+var1.value+"-"+var2.value+"&vtex="+var3.value+"&vmod="+var4.value,"Ventana", "scrollbars=yes,toolbar=no,directories=no,menubar=no,status=no"); }

function pregunta() { 
  return confirm('Estas seguro de grabar la Informacion ?'); }

</script> 

</head>

<?php
// *************************************************************************************
// Programa: p_datostec.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MILCO
// Año: 2007
// Modificado I Semestre 2009 BD - Relacional   
// *************************************************************************************
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado"; exit(); }

//Variables
$usuario = $_SESSION['usuario_login'];
//$role    = $_SESSION['usuario_rol'];
$sql     = new mod_db();
$fecha   = fechahoy();

$tbname_1 = "stppatee";
$tbname_2 = "stpclsfd";
$tbname_3 = "stplocad";
$tbname_4 = "stzderec";
$tbname_5 = "stzstder";
$tbname_6 = "stzagenr";
$tbname_7 = "stpinved";
$tbname_8 = "stptmpinv";
$tbname_9 = "stptmpcip";
$tbname_10= "stzpriod";
$tbname_11= "stztmprio";
$tbname_12= "stpequiv";
$tbname_13= "stptmpeq";
$tbname_14= "stztmptit";
$tbname_15= "stzottid";
$tbname_16= "stzsolic";
$tbname_17= "stplocar";
$tbname_18= "stpnotas";

$vopc  = $_GET['vopc'];
$vder  = $_POST['vder'];
$vsol1 = $_POST['vsol1'];
$vsol2 = $_POST['vsol2'];
$vreg1 = $_POST['vreg1'];
$vreg2 = $_POST['vreg2'];
$vtipo = $_POST['vtipo'];
$vest  = $_POST['vest'];
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

$vresumen = $_POST['vresumen'];
$locarno1 = $_POST['locarno1']; 
$locarno2 = $_POST['locarno2'];
$vnom     = $_POST['vnom'];
$vnotas   = $_POST['vnotas'];
$vnota_ant= $_POST['vnota_ant'];
$vtipo=$_POST["vtipo"];

$smarty->assign('titulo',$substpat);
$smarty->assign('subtitulo','Actualizaci&oacute;n de Datos T&eacute;cnicos');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Submit cuando vopc es diferente de 1 y 2 y cuando pasa la primera vez  
//$smarty ->assign('submitbutton','submit'); 
$smarty ->assign('varfocus','formarcas1.vsol1'); 
$smarty ->assign('vmodo','disabled'); 

if (empty($vopc)) {
  $smarty ->assign('modo2','disabled'); 
  $smarty ->assign('modo3','disabled');
  $smarty ->assign('modo4','disabled'); } 

$smarty->assign('arraytipom',array(V,A,B,C,D,G,E,F));
$smarty->assign('arraynotip',array('','INVENCION','DIBUJO','MEJORA','INTRODUCCION','DISE&Ntilde;O INDUSTRIAL','MODELO INDUSTRIAL','MODELO DE UTILIDAD'));


//Verificando conexion
$sql->connection($usuario);

if (!empty($vsol1) && !empty($vsol2)) {
  //Armado del Numero de Expediente
  $vsol=$vsol1."-".$vsol2;
  $varsol=$vsol1."-".$vsol2;
}  
if (!empty($vreg1) && !empty($vreg2))
  { $vreg = $vreg1.$vreg2; }
  
$resultado=true;

  if ($vopc==1) {
   //Validacion del Numero de Solicitud
   if (empty($vsol1) && empty($vsol2)) {
     mensajenew('No introdujo ningún valor de Expediente ...!!!','javascript:history.back();','N');
     $smarty->display('pie_pag.tpl'); exit(); }
   $resultado=pg_exec("SELECT * FROM $tbname_4 WHERE solicitud='$vsol' AND solicitud!='' AND tipo_mp='P'");
  }

  if ($vopc==2) {
   //Validacion del Numero de Registro - Mostrar Informacion 
   if (empty($vreg1) && empty($vreg2))
    {
      mensajenew('No introdujo ningún valor de Expediente ...!!!','javascript:history.back();','N');
      $smarty->display('pie_pag.tpl'); exit(); }
   $resultado=pg_exec("SELECT * FROM $tbname_4 WHERE registro='$vreg' and registro!='' AND tipo_mp='P'");   
  }
  
  if ($vopc==1 || $vopc==2) {
    //$smarty ->assign('submitbutton','button'); 
    $smarty ->assign('varfocus','formarcas3.vdoc'); 
    $smarty ->assign('vmodo','readonly'); 
    $smarty ->assign('modo2',''); 
    $smarty ->assign('modo','disabled');
 
    if (!$resultado) { 
      mensajenew('ERROR AL PROCESAR LA BUSQUEDA ...!!!','p_datostec.php','N');
	   $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }	 
    $filas_found=pg_numrows($resultado); 
    if ($filas_found==0) {
      mensajenew('ERROR: NO EXISTEN DATOS ASOCIADOS ...!!!','p_datostec.php','N');
	   $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }	 
    $reg = pg_fetch_array($resultado);

    $vder=$reg[nro_derecho];
    $vsol=$reg[solicitud];
    $vest=$reg[estatus];
    $vsol1=substr($vsol,-11,4);
    $vsol2=substr($vsol,-6,6);
    $vreg=$reg[registro];
    $vreg1=substr($vreg,-7,1);
    $vreg2=substr($vreg,1);
    $vnom=trim($reg[nombre]);
    $vtipo=$reg[tipo_derecho];
    $vfecsol=$reg[fecha_solic];
    $vfecreg=$reg[fecha_regis];
    $vfecven=$reg[fecha_venc];
    $vcodage=$reg[agente];
    $vtra=trim($reg[tramitante]);

    switch ($vtipo) {
      case "A":
         $vtip='INVENCION';
         break;
      case "B":
         $vtip='DIBUJO INDUSTRIAL';
         break;
      case "C":
         $vtip='DE MEJORA';
         break;
      case "D":
         $vtip='DE INTODUCCION';
         break;
      case "G":
         $vtip='DISE&Ntilde;O INDUSTRIAL';
         break;
      case "E":
         $vtip='MODELO INDUSTRIAL';
         break;
      case "F":
         $vtip='MODELO DE UTILIDAD';
         break;
    }

    // Nombre del Agente si es el caso      
    if ($vcodage!='') {
      $resulage=pg_exec("SELECT nombre FROM $tbname_6 WHERE agente=$vcodage");
      $regage = pg_fetch_array($resulage);
      $vnomage=$regage[nombre];
      $vtra=$vcodage." - ".$vnomage;
    }
    //Obtención de la Descripción del Estatus 
    $vdesest = estatus($vest);

    $resumen='';
    //Obtención de datos de la Patente  
    $obj_query = $sql->query("SELECT * FROM $tbname_1 WHERE nro_derecho='$vder'");
    $objs = $sql->objects('',$obj_query);
    $vresumen  = trim($objs->resumen);

    $vnotas='';
    //Obtención de las Observaciones o Comentarios de la Patente  
    $obj_query = $sql->query("SELECT * FROM $tbname_18 WHERE nro_derecho='$vder' ORDER BY id_nota DESC");
    $objs = $sql->objects('',$obj_query);
    $vnotas  = trim($objs->notas);
    $vnota_ant = trim($objs->notas);

    // Obtencion de Inventores    
    $sql->del("$tbname_8","solicitud='$vsol'");
    $obj_query = $sql->query("SELECT * FROM $tbname_7 WHERE nro_derecho=$vder ORDER BY nombre_inv");
    $obj_filas = $sql->nums('',$obj_query);
    if ($obj_filas > 0) {  
      $objs = $sql->objects('',$obj_query);
      for ($contobj=0;$contobj<$obj_filas;$contobj++) {
        $ninventor = trim($objs->nombre_inv);
        $nac = $objs->nacionalidad;
        $insert_str = "'$vsol','$ninventor','$nac'";
        $sql->insert("$tbname_8","","$insert_str","");
        $objs = $sql->objects('',$obj_query); }	  
    }

    // Obtencion del o los Titular(es)  
    $sql->del("$tbname_14","solicitud='$vsol'");
    $obj_query = $sql->query("SELECT stzottid.titular,stzsolic.nombre,stzsolic.indole,stzottid.domicilio,stzottid.nacionalidad 
                              FROM stzottid,stzsolic WHERE stzottid.nro_derecho ='$vder' AND  
                                   stzottid.titular=stzsolic.titular");
    $obj_filas = $sql->nums('',$obj_query);
    $objs = $sql->objects('',$obj_query);
    for ($contobj=0;$contobj<$obj_filas;$contobj++) {
      $vcod = $objs->titular;
      $nomb = $objs->nombre;
      $domi = $objs->domicilio;
      $pais = $objs->nacionalidad;
      $indo = $objs->indole;
      if (empty($indo)) { $indo = "P"; }  
      $col_campos = "solicitud,titular,nombre,domicilio,nacionalidad,indole,tipo_mp";
      $insert_str = "'$vsol','$vcod','$nomb','$domi','$pais','$indo','P'";
      $sql->insert("$tbname_14","$col_campos","$insert_str","");
    $objs = $sql->objects('',$obj_query); }	  

    // Obtencion de Prioridad   
    $sql->del("$tbname_11","solicitud='$vsol'");
    $obj_query = $sql->query("SELECT * FROM $tbname_10 WHERE nro_derecho=$vder ORDER BY fecha_priori");
    $obj_filas = $sql->nums('',$obj_query);
    if ($obj_filas > 0) {  
      $objs = $sql->objects('',$obj_query);
      for ($contobj=0;$contobj<$obj_filas;$contobj++) {
        $vcod = $objs->prioridad;
        $fech = $objs->fecha_priori;
        $pais = $objs->pais_priori;
        $col_campos = "solicitud,prioridad,pais_priori,fecha_priori,tipo_mp";
        $insert_str = "'$vsol','$vcod','$pais','$fech','P'";
        $insprio = $sql->insert("$tbname_11","$col_campos","$insert_str","");
        $objs = $sql->objects('',$obj_query); }	  
    }

    // Obtencion de Clasificacion Internacional de Patente     
    $sql->del("$tbname_9","solicitud='$vsol'");
    $obj_query = $sql->query("SELECT * FROM $tbname_2 WHERE nro_derecho=$vder");
    $obj_filas = $sql->nums('',$obj_query); 
    if ($obj_filas > 0) {  
      $objs = $sql->objects('',$obj_query);
      for ($contobj=0;$contobj<$obj_filas;$contobj++) {
        $clase = trim($objs->clasificacion);
        $tipo = $objs->tipo_clas;
        $insert_str = "'$vsol','$clase','$tipo'";
        $sql->insert("$tbname_9","","$insert_str","");
        $objs = $sql->objects('',$obj_query); }	  
    }

    $codigo = 0;
    $fechahoy = hoy();
    // Obtencion de Equivalencias       
    $sql->del("$tbname_13","solicitud='$vsol'");
    $obj_query = $sql->query("SELECT * FROM $tbname_12 WHERE nro_derecho=$vder ORDER BY equivalente");
    $obj_filas = $sql->nums('',$obj_query);
    if ($obj_filas > 0) {  
      $objs = $sql->objects('',$obj_query);
      for ($contobj=0;$contobj<$obj_filas;$contobj++) {
        $nequivale = trim($objs->equivalente);
        $codigo = $codigo + 1;
        $insert_str = "'$vsol','$nequivale','$fechahoy','$codigo'";
        $sql->insert("$tbname_13","","$insert_str","");
        $objs = $sql->objects('',$obj_query); }	  
    }
    
    if ($vtipo=="G") { $smarty ->assign('modo4','disabled'); }
    if ($vtipo=="B") { $smarty ->assign('modo4','disabled'); }
    if ($vtipo=="E") { $smarty ->assign('modo4','disabled'); }
    if ($vtipo=="A") { $smarty ->assign('modo3','disabled'); }
    if ($vtipo=="F") { $smarty ->assign('modo3','disabled'); }
    
    if (($vtipo=="B") || ($vtipo=="E") || ($vtipo=="G")) {
      $resulocar=pg_exec("SELECT * FROM $tbname_3 WHERE nro_derecho='$vder'"); 
      if (!$resulocar) { 
      }	 
      $filas_found=pg_numrows($resulocar); 
      if ($filas_found!=0) {
        $regloc = pg_fetch_array($resulocar);
        $loc1=substr($regloc[clasi_locarno],-5,2);
        $loc2=substr($regloc[clasi_locarno],-2,2);
        $smarty ->assign('locarno1',$loc1);
        $smarty ->assign('locarno2',$loc2); 
        $smarty ->assign('modo3','disabled');
      }
    }

  }

  // Opcion de Grabar Informacion  
  if ($vopc==3) {
    if ((empty($vsol) || ($vsol=="0000-000000")) && empty($vreg)) {
      Mensajenew('ERROR: NO SELECCIONO NINGUN EXPEDIENTE ...!!!','p_datostec.php','N');
      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

    if (empty($vnom)) { 
      Mensajenew('ERROR: El Titulo de la Patente esta en blanco ...!!!','javascript:history.back();','N');
      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

    if (empty($vresumen)) {
      Mensajenew('ERROR: El Resumen de la Patente no puede estar vacio ...!!!','javascript:history.back();','N');
      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

    $act_prim  = true;
    $act_paten = true;
    $act_notas = true;
    $ins_notas = true;

    // Comienzo de Transaccion 
    pg_exec("BEGIN WORK");
    $fechahoy = hoy();
    $horactual = hora();

    // Maestra Principal   
    pg_exec("LOCK TABLE stzderec IN SHARE ROW EXCLUSIVE MODE");
    $nombre = str_replace("'","´",$vnom);
    $update_str = "nombre='$vnom',tipo_derecho='$vtipo'";
    $act_prim   = $sql->update("$tbname_4","$update_str","nro_derecho='$vder'");

    // Maestra de Patentes
    $vres = trim($vresumen);
    $vres = str_replace("'","´",$vresumen);
    pg_exec("LOCK TABLE stppatee IN SHARE ROW EXCLUSIVE MODE");
    $update_str = "resumen='$vres'";
    $act_paten = $sql->update("$tbname_1","$update_str","nro_derecho='$vder'");

    // Maestra Observaciones o Comentarios
    $vnot = strtoupper(trim($vnotas));
    $vnot = str_replace("'","´",$vnotas);
    //$obj_query = $sql->query("SELECT * FROM $tbname_18 WHERE nro_derecho='$vder'");
    //$obj_filas = $sql->nums('',$obj_query);
    //if ($obj_filas == 0) {   
    //  $col_campos = "nro_derecho,notas,usuario,fecha_trans,hora";
    //  $insert_str = "'$vder','$vnot','$usuario','$fechahoy','$horactual'";
    //  $insnota = $sql->insert("$tbname_18","$col_campos","$insert_str","");
    //} else {
    //    pg_exec("LOCK TABLE stpnotas IN SHARE ROW EXCLUSIVE MODE");
    //    $update_str = "notas='$vnot'";
    //    $act_notas = $sql->update("$tbname_18","$update_str","nro_derecho='$vder'");
    //}
    if ($vnota_ant==$vnot) { } 
    else { 
      $insert_str = "nextval('stpnotas_id_nota_seq'),'$vder','$vnot','$usuario','$fechahoy','$horactual'";
      $ins_notas = $sql->insert("$tbname_18","$col_campos","$insert_str",""); }

    $numeqv = 0;  
    $inseqv = true;
    // Grabar en Tabla de Equivalencias     
    pg_exec("LOCK TABLE stpequiv IN SHARE ROW EXCLUSIVE MODE");
    $del_datos = $sql->del("$tbname_12","nro_derecho='$vder'");
    $res_eqv=pg_exec("SELECT * FROM $tbname_13 WHERE solicitud='$vsol'");
    $filas_res_eqv=pg_numrows($res_eqv); 
    $regeqv = pg_fetch_array($res_eqv);
    for($i=0;$i<$filas_res_eqv;$i++) { 
      $obj_query = $sql->query("SELECT * FROM $tbname_12 WHERE nro_derecho='$vder' AND equivalente='$regeqv[equivalente]'");
      if (!$obj_query) { 
         Mensajenew("Problema al intentar realizar la consulta en la tabla $tbname_12 ...!!!","javascript:history.back();","N");
         $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
      $filas_equival=$sql->nums('',$obj_query);
      if ($filas_equival==0) {
         $insert_str = "'$vder','$regeqv[equivalente]'";
         $inseqv = $sql->insert("$tbname_12","","$insert_str","");
         if ($inseqv) { }
         else { $numeqv = $numeqv + 1; }  
      } 
      $regeqv = pg_fetch_array($res_eqv); 
    }
    $del_datos = $sql->del("$tbname_13","solicitud='$vsol'");

    // Grabar Clasificaciones IPC
    $num_cip = 0;
    $inscip = true;
    // Tabla de CIP  
    pg_exec("LOCK TABLE stpclsfd IN SHARE ROW EXCLUSIVE MODE");
    $del_datos = $sql->del("$tbname_2","nro_derecho='$vder'");
    $obj_query = $sql->query("SELECT * FROM $tbname_9 WHERE solicitud ='$vsol'");
    $obj_filas = $sql->nums('',$obj_query);
    $objs = $sql->objects('',$obj_query);
    for ($contobj=0;$contobj<$obj_filas;$contobj++) {
      $clase = $objs->clasificacion;
      $tipo = $objs->tipo_clas;
      $insert_str = "'$vder','$clase','$tipo'";
      $inscip = $sql->insert("$tbname_2","","$insert_str",""); 
      if ($inscip) { }
      else { $num_cip = $num_cip + 1; }  
      $objs = $sql->objects('',$obj_query); }
    $del_datos = $sql->del("$tbname_9","solicitud='$vsol'");

    for ($cont=1;$cont<=12;$cont++) {
      $arraycls[$cont] = 0;
      $arraytip[$cont] = 0; }

    $fechahoy = hoy();
    $horactual = hora();
    $solicitud = $vsol1."-".$vsol2;

    // Solo Invencion y Modelos de Utilidad 
    if (($vtipo=="A") || ($vtipo=="F") || ($vtipo=="C")) {
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
     $inscip = 0;
     for ($cont=1;$cont<=12;$cont++) {
         $valor=$arraycls[$cont];
         if (!empty($valor)) {
           $clsfd = $arraycls[$cont];  
           $tipcl = $arraytip[$cont];
           // Nelson anexo estas lineas de codigo el 11/08/2009
           // para guardar solamente si la clasificacion no existe en la tabla  
           $obj_query_n = $sql->query("SELECT * FROM $tbname_2 WHERE nro_derecho='$vder' 
                                       and clasificacion='$clsfd'");
           $obj_filas_n = $sql->nums('',$obj_query_n);
           if ($obj_filas_n==0) { 
              $col_campos = "nro_derecho,clasificacion,tipo_clas";
              $insert_str = "'$vder','$clsfd','$tipcl'";
              $inscip = $sql->insert("$tbname_2","$col_campos","$insert_str","");
              if (!$inscip) { $numcip = $numcip + 1; } 
           } 
           // Fin del anexo
         } 
     }
    }

    // Grabar Locarno - Solo Diseño Grafico 
    $ins_locar = true;
    if (($vtipo=="B") || ($vtipo=="E") || ($vtipo=="G")) {
      //Verificacion
      if ((trim($locarno1)!="") && (trim($locarno2)!="")) {   
        if (((trim($locarno1)!="00") && (trim($locarno2)!="00")) || 
           ((trim($locarno1)=="31") && (trim($locarno2)=="00")) || 
           ((trim($locarno1)=="32") && (trim($locarno2)=="00"))) { 
          $locarno = trim($locarno1)."-".trim($locarno2);
          $obj_query = $sql->query("SELECT * FROM $tbname_17 WHERE subclase ='$locarno'");
          $obj_filas = $sql->nums('',$obj_query);
          if ($obj_filas!=0) {
            $sql->del("stplocad","nro_derecho='$vder'");
            $col_campos = "nro_derecho,clasi_locarno";
            $insert_str = "'$vder','$locarno'";
            $ins_locar = $sql->insert("$tbname_3","$col_campos","$insert_str",""); }
          else {
            Mensajenew('ERROR: Clasificaci&oacute;n de Locarno NO Existe ...!!!','javascript:history.back();','N');
	         $smarty->display('pie_pag.tpl'); exit(); } 
        }
        else {  
          Mensajenew('ERROR: Clasificacion de Locarno NO puede tener 00 ...!!!','javascript:history.back();','N');
	       $smarty->display('pie_pag.tpl'); exit(); } 
	   }
      else {  
        mensajenew('ERROR: La Clasificacion de Locarno NO puede estar Vacia ...!!!','javascript:history.back();','N');
        $smarty->display('pie_pag.tpl'); exit(); } 
    }
    
    // Verificacion y actualizacion real de los Datos en BD 

    if ($act_notas AND $ins_notas AND $act_prim AND $act_paten AND $ins_locar AND $numcip==0 AND 
        $numprio==0 AND $numinv==0 AND $numeqv==0 AND $num_cip==0) {
      pg_exec("COMMIT WORK");
      //Desconexion de la Base de Datos
      $sql->disconnect();

      Mensajenew('DATOS GUARDADOS CORRECTAMENTE!!!','p_datostec.php','S');
      $smarty->display('pie_pag.tpl'); exit();
    }
    else {
      pg_exec("ROLLBACK WORK"); 
      //Desconexion de la Base de Datos
      $sql->disconnect();

      if (!$act_notas) { $error_notas = " - Notas o Comentarios "; }
      if (!$ins_notas) { $error_notas = " - Notas o Comentarios "; }
      if (!$act_prim)  { $error_prim  = " - Maestra de Derecho "; }
      if (!$ins_locar) { $error_locar = " - Locarno "; }
      if (!$act_paten) { $error_paten = " - Patentes "; }
      if ($numprio!=0) { $error_prio  = " - Prioridad(es) "; } 
      if ($numeqv!=0)  { $error_equiv = " - Equivalente(s) "; } 
      if ($numinv!=0)  { $error_inv   = " - Inventores "; } 
      if ($numcip!=0)  { $error_ipc   = " - Clasificacion Internacional de Patentes "; } 
      if ($num_cip!=0) { $error_ipc   = " - Clasificacion Internacional de Patentes "; }
      
      Mensajenew("Falla de Ingreso de Datos en la BD, Transacciones Abortadas, Error en datos asociados a: $error_prim $error_locar $error_paten $error_ipc $error_prio $error_inv $error_equiv ...!!!","javascript:history.back();","N");
      $smarty->display('pie_pag.tpl'); exit();  
    }
  
  }

$smarty->assign('campo1','Expediente No.:');
$smarty->assign('campo2','Registro No.:');
$smarty->assign('campo3','de Fecha:');
$smarty->assign('campo4','Tipo:');
$smarty->assign('campo6','T&iacute;tulo:');
$smarty->assign('campo7','Estatus:');
$smarty->assign('campo8','Fecha Registro:');
$smarty->assign('campo9','Fecha Vencimiento:');
$smarty->assign('campo10','Agente/Tramitante:');
$smarty->assign('campo11','Titular(es):');
$smarty->assign('campo12','Pais:');
$smarty->assign('campo13','Fecha del Evento:');
$smarty->assign('campo14','Clasificaci&oacute;n Locarno:');
$smarty->assign('campo15','Edici&oacute;n:');
$smarty->assign('campo16','Resumen:');
$smarty->assign('campo17','Domicilio:');
$smarty->assign('campo18','Clasificaci&oacute;n Inter.:');
$smarty->assign('campo19','Inventor(es):');
$smarty->assign('campo20','Nombre Inventor:');
$smarty->assign('campo21','Nro:');
$smarty->assign('campo22','Prioridad:');
$smarty->assign('campo23','Prioridad(es):');
$smarty->assign('campo24','Equivalente:');
$smarty->assign('campo25','Equivalente(es):');
$smarty->assign('campo26','Observaciones:');

$smarty->assign('opcion',$vopc); 
$smarty->assign('vsol1',$vsol1); 
$smarty->assign('vsol2',$vsol2); 
$smarty->assign('vsol',$vsol);
$smarty->assign('vder',$vder); 
$smarty->assign('vreg1',$vreg1);
$smarty->assign('vreg2',$vreg2);
$smarty->assign('vreg',$vreg);
$smarty->assign('vfec',$vfec);
$smarty->assign('nombre',$vnom); 
$smarty->assign('vtit',$vtit); 
$smarty->assign('vest',$vest-2000); 
$smarty->assign('vdesest',$vdesest); 
$smarty->assign('vfecsol',$vfecsol); 
$smarty->assign('vfecreg',$vfecreg); 
$smarty->assign('vfecven',$vfecven);
$smarty->assign('vresumen',$vresumen); 
$smarty->assign('vnotas',$vnotas); 
$smarty->assign('vnota_ant',$vnota_ant); 
$smarty->assign('arraycodest',$arraycodest);
$smarty->assign('arraynombre',$arraynombre);
$smarty->assign('nameimage',$nameimage);
$smarty->assign('vtip',$vtip);
$smarty->assign('vtipo',$vtipo);
$smarty->assign('tipo_paten',$tipo_paten);
$smarty->assign('vtra',$vtra);
$smarty->assign('vcodtit',$vcodtit);
$smarty->assign('vnomtit',$vnomtit);
$smarty->assign('vnactit',$vnactit);
$smarty->assign('vnadtit',$vnadtit);
$smarty->assign('vdomtit',$vdomtit);
$smarty->assign('varfocus','formarcas1.vsol1'); 
$smarty->assign('usuario',$usuario);

$smarty->display('p_datostec.tpl');
$smarty->display('pie_pag.tpl');
?>
