<script language="Javascript"> 
function CambiarImagen(oImagen,Ruta)
{
	oImagen.src='file:///'+Ruta;
}

function pregunta() { 
  return confirm('Estas seguro de grabar la Informacion ?'); }

function browseagentep(var1,var2,var3,var4) {
  this.derecho='M';
  open("../comun/adm_agente.php?vsol="+var1.value+"-"+var2.value+"&vtex="+var3.value+"&vmod="+var4.value+"&vtip="+this.derecho,"Ventana", "scrollbars=yes,toolbar=no,directories=no,menubar=no,status=no"); }

function browsetitularp(var1,var2,var3,var4) {
  this.derecho='M';
  open("../comun/adm_titular.php?vsol="+var1.value+"-"+var2.value+"&vtex="+var3.value+"&vmod="+var4.value+"&vtip="+this.derecho,"Ventana", "scrollbars=yes,toolbar=no,directories=no,menubar=no,status=no"); }

function browseprioridp(var1,var2,var3,var4) {
  this.derecho='M';
  open("../comun/adm_priorid.php?vsol="+var1.value+"-"+var2.value+"&vtex="+var3.value+"&vmod="+var4.value+"&vtip="+this.derecho,"Ventana", "scrollbars=yes,toolbar=no,directories=no,menubar=no,status=no"); }

function gestionvienap(var1,var2,var3,var4) {
  open("adm_viena.php?vsol="+var1.value+"-"+var2.value+"&vtex="+var3.value+"&vmod="+var4.value,"Ventana", "scrollbars=yes,toolbar=no,directories=no,menubar=no,status=no"); }

function buscarimagen(var1,var2,var3) {
  open("../comun/adm_imagen.php?vsol="+var1.value+"-"+var2.value+"&vcod="+var3.value,"Ventana", "scrollbars=yes,toolbar=no,directories=no,menubar=no,status=no"); }

function limpiarimagen(var1,var2) {
  open("../comun/adm_elimimag.php?vsol="+var1.value+"-"+var2.value,"Ventana", "scrollbars=yes,toolbar=no,directories=no,menubar=no,status=no"); }

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

 function limpiarplan(vcampo1)
 {
      vcampo1.value = ""; 
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

 function habilema(vtipo,vcampo1,vcampo2,vcampo3,vcampo4)
 {
   if (vtipo.value == "L") {
      vcampo1.disabled = false;
      vcampo2.disabled = false;
      vcampo3.disabled = false; 
      vcampo4.disabled = false; }
   else { vcampo1.value = "";
          vcampo1.disabled = true; 
          vcampo2.value = "";
          vcampo2.disabled = true;
          vcampo3.value = "";
          vcampo3.disabled = true;
          vcampo4.value = "";
          vcampo4.disabled = true;
          }

 }
</script>

<?php
// *************************************************************************************
// Programa: m_ingresol.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MILCO
// Año: 2006
// Modificado Año 2009 BD - Relacional 
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
$modulo  = "m_ingresol.php";

$tbname_1 = "stzpaisr";
$tbname_2 = "stzagenr";
$tbname_3 = "stzsolic";
$tbname_4 = "stmmarce";
$tbname_5 = "stzevtrd";
$tbname_6 = "stzderec";
$tbname_7 = "stzottid";
$tbname_8 = "stmlogos";
$tbname_9 = "stztmptit";
$tbname_10 = "stzusuar";
$tbname_11 = "stmtmpccv";
$tbname_12 = "stzbitac";
$tbname_13 = "stzbider";
$tbname_14 = "stmlemad";
$tbname_15 = "stzpriod";
$tbname_16 = "stzautod";
$tbname_17 = "stmccvma";
$tbname_18 = "stztmpage";
$tbname_19 = "stztmprio";
$tbname_20 = "stmbatfon";
$tbname_21 = "stmclnac";

$vopc   = $_GET['vopc'];
$conx   = $_GET['conx']; 
$nconex = $_GET['nconex'];
$salir  = $_GET['salir']; 

$vuser=$_GET['vuser'];
$vaccion=$_GET['vaccion'];
$vauxnum=$_GET['vauxnum'];
$depto_id=$_GET['vdepto'];
$vsol1=$_POST['vsol1'];
$vsol2=$_POST['vsol2'];
$vsol1a=$_POST['vsol1a'];
$vsol2a=$_POST['vsol2a'];
$vsol=$_POST['vsol'];

$modalidad=$_POST['modalidad'];
$fecha_solic=$_POST['fecha_solic'];
$tipo_marca=$_POST['tipo_marca'];
$nombre=$_POST['nombre'];
$psoli=$_POST['psoli'];
$vpod1=$_POST['vpod1'];
$vpod2=$_POST['vpod2'];
$tramitante=$_POST['tramitante'];
$distingue=$_POST['distingue'];
$etiqueta=$_POST['etiqueta'];
$vstring=$_POST['vstring'];
$vstring1=$_POST['vstring1'];
$vstring2=$_POST['vstring2'];
$campos=$_POST['campos'];
$accion=$_POST['accion'];
$auxnum=$_POST['auxnum'];
$vnumclase=$_POST['options'];
$vcodage=$_POST['vcodage'];
$vnomagenew=$_POST['vnomage'];
$input1=$_POST['input1'];
$input2=$_POST['input2'];
$vsol3=$_POST['vsol3'];
$vsol4=$_POST['vsol4'];
$vreg1d=$_POST['vreg1d'];
$vreg2d=$_POST['vreg2d'];
$vclnac=$_POST['vclnac'];
$ubicacion= $_POST['ubicacion'];
$planilla=$_POST['planilla'];

$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Mantenimiento de Expediente'); 
if ($vopc==3) {
  $smarty->assign('subtitulo','Mantenimiento de Expediente / Ingreso'); }
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');
$vresol=$vsol1.'-'.$vsol2;

// ************************************************************************************  
// Control de acceso: Entrada y Salida al Modulo 
if ($conx==0) { 
  $smarty->assign('n_conex',$nconex);      }
else {
  if ($vopc == 3) { $opra='I'; }
  $res_conex = insconex($usuario,$modulo,$opra);
  $smarty->assign('n_conex',$res_conex);   }

if (($salir==0) && ($nconex>0)) {
  $logout = salirconx($nconex);
}

// ************************************************************************************  
if ($vopc==4) {
  $vresol = trim($vresol);
  if ($vresol=="-") {
    Mensajenew("AVISO: NO introdujo Ningun valor de Solicitud ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
  
  //Verificando conexion
  $sql->connection($usuario);
  $resulm = pg_exec("SELECT * FROM $tbname_6 WHERE solicitud='$vresol' AND tipo_mp='M'");
  $regm = pg_fetch_array($resulm);
  $nfil = pg_numrows($resulm);
  if ($nfil!=0) { 
    Mensajenew("AVISO: Solicitud ya existe en la Base de Datos ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
  else {
    $fhoy = hoy();
    $sql->del("$tbname_9","fecha_carga <'$fhoy'"); 
    $sql->del("$tbname_9","solicitud='$vresol' AND tipo_mp='M'"); }  
}   

$smarty->assign('arraytipom',array(V,M,N,L,S,C,D,O));
$smarty->assign('arraynotip',array('','MARCA DE PRODUCTO','NOMBRE COMERCIAL','LEMA COMERCIAL','MARCA DE SERVICIO','MARCA COLECTIVA','DENOMINACION COMERCIAL','DENOMINACION DE ORIGEN'));
$smarty->assign('arrayvclase',array(I,N));
$smarty->assign('arraytclase',array('INTERNACIONAL','NACIONAL'));
$smarty->assign('arrayvmodal',array(N,D,G,M));
$smarty->assign('arraytmodal',array('','DENOMINATIVA','GRAFICA','MIXTA'));

if (($vopc==1) || ($vopc==3) || ($vopc==4)) {
  //Obtención de los Paises
  $obj_query = $sql->query("SELECT * FROM $tbname_1 order by nombre");
  if (!$obj_query) { 
    mensajenew("ERROR: Problema al intentar realizar la consulta en la tabla   $tbname_1 ...!!!","javascript:history.back();","N");
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
    $objs = $sql->objects('',$obj_query);
  }

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
  $smarty->assign('subtitulo','Mantenimiento de Expediente / Ingreso '); 
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
  $n_conex = $_POST['nconex'];
  //La Fecha de Hoy y Hora para la transaccion
  $fechahoy = hoy();
  $horactual= Hora();

  //Verificando conexion
  $sql->connection($usuario);

  if ($accion==1) {
    $vsol1 = $vsol1a;
    $vsol2 = $vsol2a;
    $vclase = substr($vnumclase,0,2); }

  $vclase = substr($vnumclase,0,2);
  
  //Validacion del Numero de Solicitud
  if (empty($vsol1) || empty($vsol2)) { 
    Mensajenew("AVISO: Numero de Solicitud Vacio o con Error ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }

  if ($modalidad=="D" || $modalidad=="M") { 
     if (empty($nombre)) {
       Mensajenew("AVISO: Nombre de la Marca no puede estar Vacia por ser Denominativa o Mixta ...!!!","javascript:history.back();","N");
       $smarty->display('pie_pag.tpl'); exit(); } 
  }
      
  $varsol=$vsol1."-".$vsol2;
  //Verificacion de que los campos requeridos esten llenos...
  $req_fields = array("fecha_solic","tipo_marca","modalidad","distingue");
  $valores = array($fecha_solic,$tipo_marca,$modalidad,$distingue);
  $vacios = check_empty_fields();
  if (!$vacios) { 
     Mensajenew("AVISO: Hay Informacion en el formulario que esta Vacia ...!!!","javascript:history.back();","N");
     $smarty->display('pie_pag.tpl'); exit(); }

  // Verificacion de si existe o no en la base de datos la solicitud 
  $obj_query = $sql->query("SELECT * FROM $tbname_6 WHERE solicitud='$varsol' AND tipo_mp ='M'");
  $obj_filas = $sql->nums('',$obj_query);
  if ($obj_filas!=0) {
    Mensajenew("ERROR: Solicitud YA existe en la Base de Datos ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }

  $vclatipo = 0;
  switch ($tipo_marca) {
     case "M":
       if ($vclase>0 and $vclase<35) {
           $vclatipo = 1; }
       break;
     case "S":
       if ($vclase>34 and $vclase<46) {
           $vclatipo = 1; }
       break;
     case "N":
       if ($vclase==46) {
           $vclatipo = 1; }
       break;
     case "L":
       if ($vclase==47) {
           $vclatipo = 1; }
       break;
     case "D":
       if ($vclase==46) {
           $vclatipo = 1; }
       break;
     case "O":
       if ($vclase==48) {
           $vclatipo = 1; }
       break;
     case "C":
       if ($vclase>0 and $vclase<46) {
           $vclatipo = 1; }
       break;
  }       
  
  if ($vclatipo==0) {
    Mensajenew("AVISO: Clase Internacional de Niza no corresponde con el Tipo de Marca ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }

  if (($vclnac==0) || (empty($vclnac))) {
    Mensajenew("AVISO: Error en Clase Nacional o esta vacia ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }

  $vclatipo = 0;
  switch ($tipo_marca) {
     case "M":
       if ($vclnac>0 and $vclnac<51) {
           $vclatipo = 1; }
       break;
     case "S":
       if ($vclnac==50) { 
           $vclatipo = 1; }
       break;
     case "N":
       if ($vclnac==50) { 
           $vclatipo = 1; }
       break;
     case "L":
       if ($vclnac==50) { 
           $vclatipo = 1; }
       break;
     case "D":
       if ($vclnac==50) {  
           $vclatipo = 1; }
       break;
     case "O":
       if ($vclnac==50) {  
           $vclatipo = 1; }
       break;
     case "C":
       if ($vclnac>0 and $vclnac<51) {  
           $vclatipo = 1; }
       break;
  }       
  if ($vclatipo==0) {
    Mensajenew("AVISO: Clase Nacional NO corresponde con el Tipo de Marca ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }

  if ($tipo_marca=="D") {
    $fechacambio = "05/08/1992";
    $esmayor=compara_fechas($fecha_solic,$fechacambio);
    if ($esmayor==1) {
      mensajenew("ERROR: Tipo de Marca (DC) usado hasta el 05/08/1992, corresponde actualmente a Nombre Comercial (NC) ...!!!","javascript:history.back();","N");
      $smarty->display('pie_pag.tpl'); exit(); }
  }

  $esmayor=compara_fechas($fecha_solic,$fechahoy);
  if ($esmayor==1) {
    mensajenew("AVISO: La Fecha de Solicitud No puede ser mayor a la de Hoy ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }
 
   if ($tipo_marca!="L") {
     $vsol3='';
     $vsol4='';
     $vreg1d='';
     $vreg2d='';
   }
   
   if ($tipo_marca=="L") {
     $vsolema = trim($vsol3."-".$vsol4);
     $vreglema= trim($vreg1d.$vreg2d);
     
     if (($vsolema=="-") && empty($vreglema)) {
       mensajenew("AVISO: La Solicitud por ser Lema necesita a que Marca sera aplicado ...!!!","javascript:history.back();","N");
       $smarty->display('pie_pag.tpl'); exit();
     }

     if ($vsolema!='') {
       $obj_query = $sql->query("SELECT * FROM $tbname_6 WHERE solicitud='$vsolema' AND tipo_mp ='M'"); }
     if ($vreglema!='') {
       $obj_query = $sql->query("SELECT * FROM $tbname_6 WHERE registro='$vreglema' AND tipo_mp ='M'"); }
     $obj_filas = $sql->nums('',$obj_query);
     if ($obj_filas==0) {
       mensajenew("ERROR: Solicitud o Registro NO existe en la Base de Datos ...!!!","javascript:history.back();","N");
       $smarty->display('pie_pag.tpl'); exit(); }
   }

  $annno= Obtener_anno($fecha_solic,0);
  if ($vsol1 != $annno) { 
    Mensage_Error("AVISO: Los Cuatros primeros digitos del Expediente no son iguales a los cuatros ultimos de su Fecha ...!!!");
    $smarty->display('pie_pag.tpl'); exit();  }

  if ($modalidad=="N") {
      mensajenew("AVISO: No ha seleccionado la Modalidad ...!!!","javascript:history.back()","N");
      $smarty->display('pie_pag.tpl'); exit(); }

  //Verificacion de que si existe la imagen en disco y ha sido descrita
  if (($modalidad=="G") || ($modalidad=="M")) {
   if (empty($etiqueta)) {
      mensajenew("AVISO: Por ser Grafica o Mixta, necesita se describa la Etiqueta ...!!!","javascript:history.back()","N");
      $smarty->display('pie_pag.tpl'); exit(); }  
  }
      
  if ($modalidad=="G") { $nombre=""; }

  //Verificacion del pais de residencia 
  if (empty($input2)) { 
     $vcodpais=""; 
     mensajenew("AVISO: Debe indicar Pais de Residencia ...!!!","javascript:history.back();","N");
     $smarty->display('pie_pag.tpl'); exit(); }

  //Validacion del Poder
  if (!empty($vpod1) && !empty($vpod2))
   { $vpoder= $vpod1."-".sprintf("%04d",$vpod2); } 
  else { $vpoder=""; }

  $vcodage=0;
  // Validacion de Agentes  
  $res_agen=pg_exec("SELECT * FROM $tbname_18 where solicitud='$varsol' AND tipo_mp='M' ORDER BY agente");
  $filas_res_age=pg_numrows($res_agen); 
  $regagen = pg_fetch_array($res_agen);
  if ($filas_res_age==0) { $vcodage=0; }
  else { 
     if ($regagen[agente]!="0") { $vcodage=$regagen[agente]; } } 

  if (empty($tramitante) && empty($vpoder) && ($vcodage==0)) {
      mensajenew("AVISO: Debe tener Tramitante o Poder o Agente(s) ...!!!","javascript:history.back();","N");
      $smarty->display('pie_pag.tpl'); exit(); }

  if ($tramitante!="") {
    if (($vpoder!="") || ($vcodage!=0)) {
      mensajenew("AVISO: Solo puede tener Tramitante o Poder o Agente(s) ...!!!","javascript:history.back();","N");
      $smarty->display('pie_pag.tpl'); exit(); } }

  //Validacion del titular 
  $filas_titular = 0; 
  $obj_query = $sql->query("SELECT * FROM $tbname_9 where solicitud='$varsol'");
  if (!$obj_query) { 
    mensajenew("ERROR: Problema al intentar realizar la consulta en la tabla $tbname_9 ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
  $filas_titular=$sql->nums('',$obj_query);
  if ($filas_titular==0) {
    mensajenew("ERROR: Expediente $varsol sin ningun Titular asociado ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 
  //}

  //Grabacion de Datos de nueva Solicitud
  if ($accion==2) {
    $resultado=pg_exec("SELECT * FROM stzevder WHERE evento=1200");
    if (!$resultado) { 
      mensajenew("ERROR: Código de Evento NO existe en la Base de Datos ...!!!","javascript:history.back();","N");
      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
    $filas_found=pg_numrows($resultado); 
    if ($filas_found==0) {
      mensajenew("ERROR: No existen Datos asociados al Evento ...!!!","javascript:history.back();","N");
      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 
    $regeve = pg_fetch_array($resultado);
    $vdes=trim($regeve['mensa_automatico']);
    $documento=0;
    $comentario="";

    $dirano = $vsol1;
    $varsol=$vsol1."-".$vsol2;
    //Variable para la busqueda de la imagen
    $vnewnombre=$dirano.substr($vsol2,-6,6); 
    $ruta = "/graficos/marcas/ef".$dirano."/";

    //Copiar archivo de logotipo en ruta final
    if (($modalidad=="G") || ($modalidad=="M")) {
      //$max_size = 1024*100; // the max. size for uploading	
      //$my_upload = new file_upload;
      //$my_upload->upload_dir = $ruta; // "files" is the folder for the uploaded files (you have to create this folder)
      //$my_upload->extensions = array(".jpg", ".jpge",".png"); // specify the allowed extensions here
      //$my_upload->max_length_filename = 50; // change this value to fit your field length in your database (standard 100)
      //$my_upload->rename_file = true;
      //$my_upload->the_temp_file = $_FILES['ubicacion']['tmp_name'];
      //$my_upload->the_file = $_FILES['ubicacion']['name'];
      //$my_upload->http_error = $_FILES['ubicacion']['error'];
      //$my_upload->validateExtension();
      //if ($my_upload->upload($vnewnombre)) { 
      //  echo ''; } 
      //else {
      ////Mensage_Error($my_upload->show_error_string());
      ////  mensajenew($my_upload->show_error_string(),"javascript:history.back();","N");
      ////  $smarty->display('pie_pag.tpl'); 
      //// exit(); 
      //}
      $ruta_original = $imagen_def."/";
      $ruta_final = "/var/www/apl/sipi/graficos/marcas/ef".trim($dirano)."/";
      $existeimagen = "N";
      //$planilla = "";
      if (empty($planilla)) {  }
      else {
        $logotipo = $ruta_original.trim($planilla).".jpg"; 
        $imgnueva = $ruta_final.$vsol1.trim($vsol2).".jpg"; //cambio de lugar 
        //$cmd = "mv $logotipo $imgnueva";
        $cmd = "cp $logotipo $imgnueva";
        //echo " $cmd "; 
        $existe_img = 2;
        $existeimagen = "S";
        if (file_exists($logotipo)) { 
          $existe_img = 1;
        }
        if ($existe_img==2) {
          mensajenew('ERROR: NO EXISTE la Imagen o Logotipo de la Busqueda asociada a la Solicitud ...!!!','m_infosol.php?vopc=3','N');
          $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();	 
        }
        exec($cmd,$salida);
      }
    }

    $vcodpais=$input2;
    pg_exec("BEGIN WORK");
    //Generacion del Numero de Derecho
    $insccv = true;
    $inslema = true;
    $instram = true;
    $inslogo = true;
    $insprio = true;
    $insagen = true;
    $insmarce = true;
    $insderecho = true; 
    $prox_derecho = 0; 
    $obj_query = $sql->query("update stzsystem set nro_derecho=nextval('stzsystem_nro_derecho_seq')");
    if ($obj_query) {
      $obj_query = $sql->query("select last_value from stzsystem_nro_derecho_seq");
      $objs = $sql->objects('',$obj_query);
      $prox_derecho = $objs->last_value; }

    //pg_exec("LOCK TABLE stmmarce IN SHARE ROW EXCLUSIVE MODE");
    //$resulm=pg_exec("select * from stmmarce where solicitud='$varsol'");
    //$regm= pg_fetch_array($resulm);
    //$nfil=pg_numrows($resulm);
    //if ($nfil>0) {
    //  mensajenew("Solicitud ya existe en la Base de Datos ...!!!","m_ingresol.php?vopc=3","N");
    //  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

    //Insercion del Registro Nuevo en la Maestra de Derecho 
    $col_campos = "nro_derecho,tipo_derecho,solicitud,fecha_solic,tipo_mp,nombre,estatus,pais_resid,poder,tramitante,agente";
    $vnom = str_replace("'","´",$nombre);
    $vnom = stripslashes($nombre);
    $vtra = str_replace("'","´",$tramitante);

    $insert_str = "'$prox_derecho','$tipo_marca','$varsol','$fecha_solic','M','$vnom',1001,'$vcodpais','$vpoder','$vtra','$vcodage'";
    $insderecho = $sql->insert("$tbname_6","$col_campos","$insert_str","");

    //Insercion del Registro Nuevo en la Maestra de Marcas   
    $col_campos = "nro_derecho,clase,ind_claseni,modalidad,distingue";
    $distingue = trim($distingue);
    $vdis = str_replace("'","´",$distingue);
    $vdis = stripslashes($distingue);

    $insert_str = "'$prox_derecho','$vclase','I','$modalidad','$vdis'";
    $insmarce = $sql->insert("$tbname_4","$col_campos","$insert_str","");

    $insclanac=true;
    //Insercion de la Clase Nacional   
    $col_campos = "nro_derecho,clase_nac";
    $insert_str = "'$prox_derecho','$vclnac'";
    $insclanac  = $sql->insert("$tbname_21","$col_campos","$insert_str","");

    // Tabla de Lemas Asociados 
    if ($tipo_marca=="L") {
      $vsolema = $vsol3."-".$vsol4;
      $vreglema= $vreg1d.$vreg2d;

     if ($vsolema!='') {
       $col_campos = "nro_derecho,solicitud_aso"; 
       $insert_str = "'$prox_derecho','$vsolema'";  }
     if ($vreglema!='') {
       $col_campos = "nro_derecho,registro_aso"; 
       $insert_str = "'$prox_derecho','$vreglema'"; }
     $inslema = $sql->insert("$tbname_14","$col_campos","$insert_str","");
    }

    $horactual = Hora();
    // Tabla de Eventos de Tramite  
    $col_campos = "nro_derecho,evento,fecha_event,secuencial,estat_ant,documento,fecha_trans,usuario,desc_evento,hora";
    $insert_str = "'$prox_derecho',1200,'$fecha_solic',nextval('stzevtrd_secuencial_seq'),1000,0,'$fechahoy','$usuario','$vdes','$horactual'";
    $instram = $sql->insert("$tbname_5","$col_campos","$insert_str","");

    // Tabla de Logos
    if (($modalidad=="G") || ($modalidad=="M")) {
      $vetq = str_replace("'","´",$etiqueta);
      $vetq = stripslashes($etiqueta);
      $insert_str = "'$prox_derecho','$vetq'";
      $inslogo = $sql->insert("$tbname_8","","$insert_str","");
    }  
    
    // Tabla de Batfon 
    $insert_str = "'$varsol'";
    $sql->insert("$tbname_20","","$insert_str","");

    $numccv = 0;
    $insccv = true;
    // Tabla de Clasificaciones de Viena
    if (($modalidad=="G") || ($modalidad=="M")) {
      $obj_query = $sql->query("SELECT * FROM $tbname_11 WHERE solicitud='$varsol'");
      $obj_filas = $sql->nums('',$obj_query);
      $objs = $sql->objects('',$obj_query);
      for($i=0;$i<$obj_filas;$i++) { 
        $resul=pg_exec("SELECT * FROM $tbname_17 WHERE nro_derecho='$prox_derecho' AND ccv='$objs->ccv'");
        $filas_resul=pg_numrows($resul);
        if ($filas_resul==0) {
          $insert_str = "'$prox_derecho','$objs->ccv'";  
          $insccv = $sql->insert("$tbname_17","","$insert_str","");
          if (!$insccv) { $numccv = $numccv + 1; } 
        }   
        $objs = $sql->objects('',$obj_query);
      }
      $del_datos = $sql->del("$tbname_11","solicitud='$varsol'");
    }

    $numprio = 0; 
    $insprio = true;
    // Tabla de Prioridades   
    $res_prio=pg_exec("SELECT * FROM $tbname_19 where solicitud='$varsol' AND tipo_mp='M'");
    $filas_res_prio=pg_numrows($res_prio); 
    $regprio = pg_fetch_array($res_prio);
    for($i=0;$i<$filas_res_prio;$i++) { 
      $obj_query = $sql->query("SELECT * FROM $tbname_15 where nro_derecho='$prox_derecho' and prioridad='$regprio[prioridad]'");
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
    $del_datos = $sql->del("$tbname_19","solicitud='$varsol' AND tipo_mp='M'");

    // Tabla de Agentes  
    $res_agen=pg_exec("SELECT * FROM $tbname_18 where solicitud='$varsol' AND tipo_mp='M' ORDER BY agente");
    $filas_res_age=pg_numrows($res_agen); 
    $regagen = pg_fetch_array($res_agen);
    
    $numagen = 0; 
    $insagen = true;
    for($i=0;$i<$filas_res_age;$i++) 
    {
     if ($i!=0) {
       if ($regagen[agente]!="0") {
           $obj_query = $sql->query("SELECT * FROM $tbname_16 where nro_derecho='$prox_derecho' and agente='$regagen[agente]'");
           if (!$obj_query) { 
             Mensajenew("Problema al intentar realizar la consulta en la tabla $tbname_16 ...!!!","javascript:history.back();","N");
             $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
           $filas_agente=$sql->nums('',$obj_query);
           if ($filas_agente==0) {
             $col_campos = "nro_derecho,agente";
             $insert_str = "'$prox_derecho','$regagen[agente]'";
             $insagen = $sql->insert("$tbname_16","$col_campos","$insert_str","");
             if ($insagen) { }
             else { $numagen = $numagen + 1; }  
           } 
       }
     }
     $regagen = pg_fetch_array($res_agen); 
    }
    $del_datos = $sql->del("$tbname_18","solicitud='$varsol' AND tipo_mp='M'");

    // Tabla de Solicitantes o Titulares 
    $res_titu=pg_exec("SELECT * FROM $tbname_9 where solicitud='$varsol' AND tipo_mp='M'");
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
         $vnombret = str_replace("'","´",$regtitu[nombre]);
         $insert_str = "nextval('stzsolic_titular_seq'),'$regtitu[identificacion]','$vnombret','$regtitu[indole]','$regtitu[telefono1]','$regtitu[telefono2]','$regtitu[fax]','$regtitu[email]'";
         $ins_solic = $sql->insert("$tbname_3","$col_campos","$insert_str","");

         $obj_query = $sql->query("select last_value from stzsolic_titular_seq");
         $objs = $sql->objects('',$obj_query);
         $act_titular = $objs->last_value;
         $vdom = str_replace("'","´",$regtitu[domicilio]);

         $col_campos = "nro_derecho,titular,nacionalidad,domicilio,pais_domicilio";
         $insert_str = "'$prox_derecho','$act_titular','$regtitu[nacionalidad]','$vdom','$regtitu[pais_domicilio]'";
         $ins_titur = $sql->insert("$tbname_7","$col_campos","$insert_str","");
         if ($ins_solic AND $ins_titur) { }
         else { $numtitu = $numtitu + 1; }  
       }
     else
       {
         $obj_query = $sql->query("SELECT * FROM $tbname_7 where nro_derecho='$prox_derecho' and titular='$regtitu[titular]'");
         if (!$obj_query) { 
           Mensajenew("Problema al intentar realizar la consulta en la tabla $tbname_7 ...!!!","javascript:history.back();","N");
           $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
         $filas_titular=$sql->nums('',$obj_query);
         if ($filas_titular==0) {
           $vdomit = str_replace("'","´",$regtitu[domicilio]);
           $col_campos = "nro_derecho,titular,nacionalidad,domicilio,pais_domicilio";
           $insert_str = "'$prox_derecho','$regtitu[titular]','$regtitu[nacionalidad]','$vdomit','$regtitu[pais_domicilio]'";
           $ins_titur = $sql->insert("$tbname_7","$col_campos","$insert_str","");
           if ($ins_titur) { }
           else { $numtitu = $numtitu + 1; }  
         } 
       }
     $regtitu = pg_fetch_array($res_titu);
    }
    $del_datos = $sql->del("$tbname_9","solicitud='$varsol' AND tipo_mp='M'");

    if ($numtitu==0 AND $numccv==0 AND $inslema AND $instram AND $inslogo AND 
        $numprio==0 AND $numagen==0 AND $insmarce AND $insderecho AND $insclanac) {
      pg_exec("COMMIT WORK");
      //Desconexion de la Base de Datos
      $sql->disconnect();
      if (($existeimagen=="N") AND (($modalidad=="G") OR ($modalidad=="M"))) {
        echo "<div align='center'>";
        echo "<font size='3' color='#800000'></p><small><I><b><blink><U>AVISO: La Solicitud cargada, se le debe Escanear o Digitalizar su correspondiente Imagen."; 
        echo "</U></blink></b></I></small><p></font></p>";
        echo "</div>";
      }
      Mensajenew('DATOS GUARDADOS CORRECTAMENTE !!!','m_ingresol.php?vopc=3&nconex=$n_conex&salir=1&conx=0','S'); 
      $smarty->display('pie_pag.tpl'); exit();
    } 
    else {
      pg_exec("ROLLBACK WORK");
      //Desconexion de la Base de Datos
      $sql->disconnect();

      if (!$inslema)    { $error_lem = " - Lema "; }
      if (!$instram)    { $error_tra = " - Tramite "; }
      if (!$inslogo)    { $error_log = " - Descripcion del Logo "; }
      if (!$insmarce)   { $error_mar = " - Marcas "; }
      if (!$insderecho) { $error_der = " - Derecho "; }
      if ($numtitu!=0)  { $error_tit = " - Titular(es) "; }
      if ($numccv!=0)   { $error_ccv = " - Clasificacion Vienna "; }
      if ($numprio!=0)  { $error_pri = " - Prioridad "; }
      if ($numagen!=0)  { $error_age = " - Agente(s) "; }
      if (!$insclanac)  { $error_cla = " - Clase Nacional "; }

      Mensajenew("ERROR: Falla de Actualizaci&oacute;n / Inserci&oacute;n de Datos en la BD $error_lem, $error_tra, $error_log, $error_pri, $error_age, $error_mar, $error_der, $error_tit, $error_ccv, $error_cla ...!!!","javascript:history.back();","N");
      $smarty->display('pie_pag.tpl'); exit();
    }
    
  }
}

//Pase de variables y Etiquetas al template
$smarty->assign('campo1','Expediente No.:');
$smarty->assign('campo2','Fecha Expediente:');
$smarty->assign('campo3','Tipo de Marca:');
$smarty->assign('campo4','Nombre:');
$smarty->assign('campo5','Clase Internacional:');
$smarty->assign('campo6','Modalidad:');
$smarty->assign('campo7','&nbsp;&nbsp;Pa&iacute;s de Residencia:');
$smarty->assign('campo8','Distingue:');
$smarty->assign('campo9','Descripci&oacute;n Etiqueta:');
$smarty->assign('campo10','Titular(es):');
$smarty->assign('campo11','Poder:');
$smarty->assign('campo12','Agente:');
$smarty->assign('campo13','Tramitante:');
$smarty->assign('campo14','Clasificaci&oacute;n de Viena:');
$smarty->assign('campo15','Logotipo:');
$smarty->assign('campo16','Lema Aplicado a:');
$smarty->assign('campo17','Prioridad:');
$smarty->assign('campo20','Clase Nacional:');
$smarty->assign('campo21','&nbsp;Solicitud:');
$smarty->assign('campo22','&nbsp;Registro:');
$smarty->assign('campo23','C&oacute;d. Plan Busq Graf:');
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
$smarty->assign('clase_id',$clase_id);
$smarty->assign('vclase',$vclase);
$smarty->assign('agen_id',$vcodage);
$smarty->assign('pais_resid',$pais_resid);
$smarty->assign('vcodpais',$vcodpais);
$smarty->assign('tramitante',$tramitante);
$smarty->assign('fecha_solic',$fecha_solic);
$smarty->assign('distingue',$distingue);
$smarty->assign('etiqueta',$etiqueta);
$smarty->assign('vpod1',$vpod1);
$smarty->assign('vpod2',$vpod2);
$smarty->assign('campos',$campos);
$smarty->assign('vcodclase',$vcodclase);
$smarty->assign('vnomclase',$vnomclase);
$smarty->assign('options',$vclase);
$smarty->assign('planilla',$planilla);
$smarty->assign('vopc',$vopc);
$smarty->assign('psoli',$vsol); 

$smarty->display('m_ingresol.tpl');
$smarty->display('pie_pag.tpl');
?>
