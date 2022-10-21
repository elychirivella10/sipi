<script language="Javascript"> 
function CambiarImagen(oImagen,Ruta)
{
	oImagen.src='file:///'+Ruta;
}

function pregunta() { 
  return confirm('Estas seguro de grabar la Informacion ?'); }

function browseinventorviejo(var1,var2,var3,var4) {
  open("act_inventor.php?vsol="+var1.value+"-"+var2.value+"&vtex="+var3.value+"&vmod="+var4.value,"Ventana", "scrollbars=yes,toolbar=no,directories=no,menubar=no,status=no"); }

function browsetitular(var1,var2,var3,var4) {
  open("act_titular.php?vsol="+var1.value+"-"+var2.value+"&vtex="+var3.value+"&vmod="+var4.value,"Ventana", "scrollbars=yes,toolbar=no,directories=no,menubar=no,status=no"); }

function browseinventor(var1,var2,var3,var4) {
  this.interesado='Inventor';
  open("p_inventores.php?vsol="+var1.value+"-"+var2.value+"&vinv="+var3.value+"&vpais="+var4.value+"&vtip="+this.interesado,"Ventana", "scrollbars=yes,toolbar=no,directories=no,menubar=no,status=no"); }

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
//Para trabajar con Operaciones de Bases de Datos
include ("../setting.inc.php");
//Clase que sube un archivo de imagen
include ("$include_path/upload_class.php"); 
//Para trabajar con Smarty 
require ("$root_path/include.php");
//Para trabajar con sessiones
require("$root_path/aut_verifica.inc.php");
//LLamadas a funciones de Libreria 
include ("$include_path/libreria.php");
include ("$include_path/library.php");

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variables
$usuario = $_SESSION['usuario_login'];
$role = $_SESSION['usuario_rol'];
$sql  = new mod_db();
$fecha   = fechahoy();

$tbname_1 = "stzpaisr";
$tbname_2 = "stzagenr";
$tbname_3 = "stztitur";
$tbname_4 = "stppatee";
$tbname_5 = "stpevtrd";
$tbname_6 = "stpresud";
$tbname_7 = "stpottid";
$tbname_8 = "stpinved";
$tbname_9 = "tempinven";
$tbname_10 = "stzusuar";
$tbname_11 = "tmpptitu";
$tbname_12 = "stzbitac";
$tbname_13 = "stzbider";
$tbname_14 = "stplocad";
$tbname_15 = "stppriod";
$tbname_16 = "stpclsfd";
$tbname_17 = "stpautod";

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
$locarno1=$_POST['locarno1']; 
$locarno2=$_POST['locarno2'];
$edicion=$_POST['edicion'];
//Agentes 
$input1=$_POST['input1'];
$vcodage=$_POST['vcodage'];
$vnomagenew=$_POST['vnomage'];
$input4=$_POST['input4'];
$vcodage4=$_POST['vcodage4'];
$vnomagenew4=$_POST['vnomage4'];
$input5=$_POST['input5'];
$vcodage5=$_POST['vcodage5'];
$vnomagenew5=$_POST['vnomage5'];
$input6=$_POST['input6'];
$vcodage6=$_POST['vcodage6'];
$vnomagenew6=$_POST['vnomage6'];
//Prioridades 
$vnprior=$_POST['vnprior'];
$vfechaprior=$_POST['vfechaprior'];
$vpaisprior=$_POST['vpaisprior'];
$vnprior1=$_POST['vnprior1'];
$v1fechaprior=$_POST['v1fechaprior'];
$v1paisprior=$_POST['v1paisprior'];
$vnprior2=$_POST['vnprior2'];
$v2fechaprior=$_POST['v2fechaprior'];
$v2paisprior=$_POST['v2paisprior'];
$vnprior3=$_POST['vnprior3'];
$v3fechaprior=$_POST['v3fechaprior'];
$v3paisprior=$_POST['v3paisprior'];
//Inventores 
$inventor1=$_POST['inventor1'];
$invnac1=$_POST['invnac1'];
$inventor2=$_POST['inventor2'];
$invnac2=$_POST['invnac2'];
$inventor3=$_POST['inventor3'];
$invnac3=$_POST['invnac3'];
$inventor4=$_POST['inventor4'];
$invnac4=$_POST['invnac4'];
$inventor5=$_POST['inventor5'];
$invnac5=$_POST['invnac5'];
$inventor6=$_POST['inventor6'];
$invnac6=$_POST['invnac6'];
$inventor7=$_POST['inventor7'];
$invnac7=$_POST['invnac7'];
$inventor8=$_POST['inventor8'];
$invnac8=$_POST['invnac8'];
$inventor9=$_POST['inventor9'];
$invnac9=$_POST['invnac9'];
$inventor10=$_POST['inventor10'];
$invnac10=$_POST['invnac10'];
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

$smarty->assign('titulo','Sistema de Patentes');
$smarty->assign('subtitulo','Mantenimiento de Expediente / Ingreso'); 
if ($vopc==3) {
  $smarty->assign('subtitulo','Mantenimiento de Expediente / Ingreso'); }
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

$vresol=$vsol1.'-'.$vsol2;

if ($vopc==4) {
  //Verificando conexion
  $sql->connection();
  $resulm = pg_exec("select * from stppatee where solicitud='$vresol'");
  $regm = pg_fetch_array($resulm);
  $nfil = pg_numrows($resulm);
  if ($nfil>0) {
   mensajenew("AVISO: Solicitud ya existe en la Base de Datos ...!!!","javascript:history.back();","N");
   $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
  else {
    $fhoy = hoy();
    $sql->del("$tbname_9","fecha_carga <'$fhoy'"); }  
}   

$smarty->assign('arraytipom',array(V,A,G,F));
$smarty->assign('arraynotip',array('','INVENCION','DISE&Ntilde;O INDUSTRIAL','MODELO DE UTILIDAD'));

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
  for($cont=1;$cont<=$filas_found;$cont++) 
  { 
    $arraycodpais[$cont]=$objs->pais;
    $arraynompais[$cont]=trim($objs->nombre);
    $objs = $sql->objects('',$obj_query);
  }

  // Obtencion de los de Agentes
  $obj_query = $sql->query("SELECT * FROM $tbname_2 ORDER BY nombre");
  $obj_filas = $sql->nums('',$obj_query);
  $contobj = 0;
  $vcodagenew[$contobj] = '';
  $vnomagenew[$contobj] = '';
  $objs = $sql->objects('',$obj_query);
  for ($contobj=1;$contobj<=$obj_filas;$contobj++) {
     $vcodagenew[$contobj] = $objs->agente;
     $vnomagenew[$contobj] = $objs->nombre;
  $objs = $sql->objects('',$obj_query);}	  

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
  $nameimage="imagenes/sin_imagen8.png";
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
}

//Opcion Grabar...
if ($vopc==2) {
  //La Fecha de Hoy y Hora para la transaccion
  $fechahoy = hoy();
  $horactual= Hora();

  //Verificando conexion
  $sql->connection();

  if ($accion==1) {
    $vsol1 = $vsol1a;
    $vsol2 = $vsol2a;}

  //Validacion del Numero de Solicitud
  if (empty($vsol1) || empty($vsol2)) { 
    mensajenew("AVISO: Numero de Solicitud Vacio o con Error ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }

  //Verificacion de que los campos requeridos esten llenos...
  $req_fields = array("fecha_solic","tipo_paten","resumen");
  $valores = array($fecha_solic,$tipo_paten,$resumen);
  $vacios = check_empty_fields();
  if (!$vacios) { 
     mensajenew("AVISO: Hay Informacion en el formulario que esta Vacia ...!!!","javascript:history.back();","N");
     $smarty->display('pie_pag.tpl'); exit(); }

  $esmayor=compara_fechas($fecha_solic,$fechahoy);
  if ($esmayor==1) {
    mensajenew("AVISO: La Fecha de Solicitud No puede ser mayor a la de Hoy ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }
  
  $annno= Obtener_anno($fecha_solic,0);
  if ($vsol1 != $annno) { 
    Mensage_Error("AVISO: Los Cuatros primeros digitos del Expediente no son iguales a los cuatros ultimos de su Fecha ...!!!");
    $smarty->display('pie_pag.tpl'); exit();  }

  if (empty($input2)) { 
     $vcodpais=""; 
     mensajenew("AVISO: Debe indicar Pais de Residencia ...!!!","javascript:history.back();","N");
     $smarty->display('pie_pag.tpl'); exit(); }

  //Validacion del Poder
  if (!empty($vpod1) && !empty($vpod2))
   { $vpoder= $vpod1."-".sprintf("%04d",$vpod2); } else
   { $vpoder=""; }

  if (empty($input1)) { $vcodage=0; }
  else { $vcodage=$input1; }

  if (empty($tramitante) && empty($vpoder) && empty($vcodage)) {
      mensajenew("AVISO: Debe tener Tramitante o Poder o Agente(s) ...!!!","javascript:history.back();","N");
      $smarty->display('pie_pag.tpl'); exit(); }

  if ($tramitante!="") {
    if (($vpoder!="") || ($vcodage!="0")) {
      mensajenew("AVISO: Solo puede tener Tramitante o Poder o Agente(s) 1...!!!","javascript:history.back();","N");
      $smarty->display('pie_pag.tpl'); exit(); } }

  $varsol=$vsol1."-".$vsol2;
  $restitu=pg_exec("SELECT * FROM tmpptitu where solicitud='$varsol'");
  $filas_titular=pg_numrows($restitu); 
  if ($filas_titular==0) {
    mensajenew("ERROR: Expediente $varsol sin ningun Titular asociado ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); 
  }

  //Grabacion de Datos de nueva Solicitud
  if ($accion==2) {
    $resultado=pg_exec("SELECT * FROM stpevpar WHERE evento=200");
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
    $ruta = "/var/www/sistemas/imagenes/patentes/".$dirano."/";

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

    //Validacion de Inventores 
    $inventor1 = trim($inventor1);
    $inventor2 = trim($inventor2);
    $inventor3 = trim($inventor3);
    $inventor4 = trim($inventor4);
    $inventor5 = trim($inventor5);
    $inventor6 = trim($inventor6);
    $inventor7 = trim($inventor7);
    $inventor8 = trim($inventor8);
    $inventor9 = trim($inventor9);
    $inventor10 = trim($inventor10);
    if (empty($inventor1) and empty($inventor2) and empty($inventor3) and empty($inventor4) and empty($inventor5) and 
       empty($inventor6) and empty($inventor7) and empty($inventor8) and empty($inventor9) and empty($inventor10)) {
       Mensajenew("ERROR: Solicitud sin Inventores asociados ...!!!","javascript:history.back();","N");
       $smarty->display('pie_pag.tpl'); exit();
    }

    $vcodpais=$input2;
    // Tabla Maestra de Patentes 
    pg_exec("BEGIN WORK");
    pg_exec("LOCK TABLE stppatee IN SHARE ROW EXCLUSIVE MODE");
    $resulm=pg_exec("select * from stppatee where solicitud='$varsol'");
    $regm= pg_fetch_array($resulm);
    $nfil=pg_numrows($resulm);
    if ($nfil>0) {
      mensajenew("AVISO: Solicitud ya existe en la Base de Datos ...!!!","p_ingresol.php?vopc=3","N");
      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

    $col_campos = "solicitud,fecha_solic,tipo_paten,nombre,agente,estatus,poder,tramitante,pais_resid,edicion,ubicacion,usuario,edo_ubic";
    $vnom = str_replace("'","´",$nombre);
    $vtra = str_replace("'","´",$tramitante);

    $insert_str = "'$varsol','$fecha_solic','$tipo_paten','$vnom','$vcodage',1,'$vpoder','$vtra','$vcodpais',$edicion,'$depto','$usuario',0";
    $sql->insert("$tbname_4","$col_campos","$insert_str","");

    $horactual = Hora();
    // Tabla de Eventos de Tramite
    $col_campos = "solicitud,evento,fecha_event,secuencial,estat_ant,documento,fecha_trans,usuario,desc_evento,hora";
    $insert_str = "'$varsol',200,'$fecha_solic',nextval('stpevtrd_secuencial_seq'),0,0,'$fechahoy','$usuario','$vdes','$horactual'";
    $sql->insert("$tbname_5","$col_campos","$insert_str","");

    // Tabla de Resumen 
    $resumen = trim($resumen);
    $vdis = str_replace("'","´",$resumen);
    $insert_str = "'$varsol','$vdis'";
    $sql->insert("$tbname_6","","$insert_str","");
    
    if ($tipo_paten=="G") {
      if ((trim($locarno1)!="") && (trim($locarno2)!="")) {   
        if ((trim($locarno1)!="00") && (trim($locarno2)!="00")) {
          $locarno = $locarno1."-".$locarno2;
          $col_campos = "solicitud,clasi_locarno";
          $insert_str = "'$varsol','$locarno'";
          $sql->insert("$tbname_14","$col_campos","$insert_str","");
        }
        else {  
          mensajenew('AVISO: Error en la Clasificacion de Locarno ...!!!','javascript:history.back();','N');
	       $smarty->display('pie_pag.tpl'); exit(); } 
	   }
      //else {  
      //  mensajenew('Error en la Clasificacion de Locarno ...!!!','javascript:history.back();','N');
      //  $smarty->display('pie_pag.tpl'); exit(); } 
    }
    //pg_exec("COMMIT WORK");

    //Otros Agentes 
    if (!empty($input4)) {
      $insert_str = "'$varsol','$input4'";
      $sql->insert("$tbname_17","","$insert_str","");
    }
    if (!empty($input5)) {
      $insert_str = "'$varsol','$input5'";
      $sql->insert("$tbname_17","","$insert_str","");
    }
    if (!empty($input6)) {
      $insert_str = "'$varsol','$input6'";
      $sql->insert("$tbname_17","","$insert_str","");
    }
    
    // Tabla de Inventores
    if (!empty($inventor1)) {
      $nombinv = str_replace("'","´",$inventor1);
      $insert_str = "'$varsol','$nombinv','$invnac1'";
      $sql->insert("$tbname_8","","$insert_str",""); }
    if (!empty($inventor2)) {
      $nombinv = str_replace("'","´",$inventor2);
      $insert_str = "'$varsol','$nombinv','$invnac2'";
      $sql->insert("$tbname_8","","$insert_str",""); }
    if (!empty($inventor3)) {
      $nombinv = str_replace("'","´",$inventor3);
      $insert_str = "'$varsol','$nombinv','$invnac3'";
      $sql->insert("$tbname_8","","$insert_str",""); }
    if (!empty($inventor4)) {
      $nombinv = str_replace("'","´",$inventor4);
      $insert_str = "'$varsol','$nombinv','$invnac4'";
      $sql->insert("$tbname_8","","$insert_str",""); }
    if (!empty($inventor5)) {
      $nombinv = str_replace("'","´",$inventor5);
      $insert_str = "'$varsol','$nombinv','$invnac5'";
      $sql->insert("$tbname_8","","$insert_str",""); }
    if (!empty($inventor6)) {
      $nombinv = str_replace("'","´",$inventor6);
      $insert_str = "'$varsol','$nombinv','$invnac6'";
      $sql->insert("$tbname_8","","$insert_str",""); }
    if (!empty($inventor7)) {
      $nombinv = str_replace("'","´",$inventor7);
      $insert_str = "'$varsol','$nombinv','$invnac7'";
      $sql->insert("$tbname_8","","$insert_str",""); }
    if (!empty($inventor8)) {
      $nombinv = str_replace("'","´",$inventor8);
      $insert_str = "'$varsol','$nombinv','$invnac8'";
      $sql->insert("$tbname_8","","$insert_str",""); }
    if (!empty($inventor9)) {
      $nombinv = str_replace("'","´",$inventor9);
      $insert_str = "'$varsol','$nombinv','$invnac9'";
      $sql->insert("$tbname_8","","$insert_str",""); }
    if (!empty($inventor10)) {
      $nombinv = str_replace("'","´",$inventor10);
      $insert_str = "'$varsol','$nombinv','$invnac10'";
      $sql->insert("$tbname_8","","$insert_str",""); }

    //pg_exec("BEGIN WORK");
    //pg_exec("LOCK TABLE tempinven IN SHARE ROW EXCLUSIVE MODE");
    //$res_inv=pg_exec("SELECT * FROM tempinven where solicitud='$varsol'");
    //$filas_inv_res=pg_numrows($res_inv);
    //if ($filas_inv_res == 0) {
    //  mensajenew("Expediente sin ningun Inventor asociado ...!!!","javascript:history.back();","N");
    //  $smarty->display('pie_pag.tpl'); exit(); }
    //else {
    //  $reginve = pg_fetch_array($res_inv);
    //  for($i=0;$i<$filas_inv_res;$i++) 
    //  { 
    //    $nombinv = str_replace("'","´",$reginve[nombre]);
    //    $col_campos = "solicitud,nombre_inv,nacionalidad";
    //    $insert_str = "'$varsol','$nombinv','$reginve[nacionalidad]'";
    //    $sql->insert("$tbname_8","$col_campos","$insert_str","");
    //    $reginve = pg_fetch_array($res_inv);
    //  }
    //} 

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
          mensajenew('AVISO: Error en la Clasificacion No. 1 ...!!!','javascript:history.back();','N');
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
          mensajenew('AVISO: Error en la Clasificacion No. 2 ...!!!','javascript:history.back();','N');
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
          mensajenew('AVISO: Error en la Clasificacion No. 3 ...!!!','javascript:history.back();','N');
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
          mensajenew('AVISO: Error en la Clasificacion No. 4 ...!!!','javascript:history.back();','N');
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
          mensajenew('AVISO: Error en la Clasificacion No. 5 ...!!!','javascript:history.back();','N');
	       $smarty->display('pie_pag.tpl'); exit(); } }
	   }          
      if ((trim($c6n2)!="") && (trim($c6n3)!="")) {   
        $c6 = $c6l1.$c6n1.$c6l2." ".$c6n2."/".$c6n3; 
        $arraycls[6]=$c6; $arraytip[6]=$t6; }
      else {
        if ((trim($c6n2)=="") && (trim($c6n3)=="")) {         
          $c6 = $c6l1.$c6n1.$c6l2; $arraycls[6]=$c6; $arraytip[6]=$t6; }
        else {  
          mensajenew('AVISO: Error en la Clasificacion No. 6 ...!!!','javascript:history.back();','N');
	       $smarty->display('pie_pag.tpl'); exit(); } }      
      if ((trim($c7n2)!="") && (trim($c7n3)!="")) {   
        $c7 = $c7l1.$c7n1.$c7l2." ".$c7n2."/".$c7n3; 
        $arraycls[7]=$c7; $arraytip[7]=$t7; }
      else {
        if ((trim($c7n2)=="") && (trim($c7n3)=="")) {         
          $c7 = $c7l1.$c7n1.$c7l2; $arraycls[7]=$c7; $arraytip[7]=$t7; }
        else {  
          mensajenew('AVISO: Error en la Clasificacion No. 7 ...!!!','javascript:history.back();','N');
	       $smarty->display('pie_pag.tpl'); exit(); } }      
      if ((trim($c8n2)!="") && (trim($c8n3)!="")) {   
        $c8 = $c8l1.$c8n1.$c8l2." ".$c8n2."/".$c8n3; 
        $arraycls[8]=$c8; $arraytip[8]=$t8; }
      else {
        if ((trim($c8n2)=="") && (trim($c8n3)=="")) {         
          $c8 = $c8l1.$c8n1.$c8l2; $arraycls[8]=$c8; $arraytip[8]=$t8; }
        else {  
          mensajenew('AVISO: Error en la Clasificacion No. 8 ...!!!','javascript:history.back();','N');
	       $smarty->display('pie_pag.tpl'); exit(); } }      
      if ((trim($c9n2)!="") && (trim($c9n3)!="")) {   
        $c9 = $c9l1.$c9n1.$c9l2." ".$c9n2."/".$c9n3; 
        $arraycls[9]=$c9; $arraytip[9]=$t9; }
      else {
        if ((trim($c9n2)=="") && (trim($c9n3)=="")) {         
          $c9 = $c9l1.$c9n1.$c9l2; $arraycls[9]=$c9; $arraytip[9]=$t9; }
        else {  
          mensajenew('AVISO: Error en la Clasificacion No. 9 ...!!!','javascript:history.back();','N');
	       $smarty->display('pie_pag.tpl'); exit(); } }      
      if ((trim($c10n2)!="") && (trim($c10n3)!="")) {   
        $c10 = $c10l1.$c10n1.$c10l2." ".$c10n2."/".$c10n3; 
        $arraycls[10]=$c10; $arraytip[10]=$t10; }
      else {
        if ((trim($c10n2)=="") && (trim($c10n3)=="")) {         
          $c10 = $c10l1.$c10n1.$c10l2; $arraycls[10]=$c10; $arraytip[10]=$t10; }
        else {  
          mensajenew('AVISO: Error en la Clasificacion No. 10 ...!!!','javascript:history.back();','N');
	       $smarty->display('pie_pag.tpl'); exit(); } }      
      if ((trim($c11n2)!="") && (trim($c11n3)!="")) {   
        $c11 = $c11l1.$c11n1.$c11l2." ".$c11n2."/".$c11n3; 
        $arraycls[11]=$c11; $arraytip[11]=$t11; }
      else {
        if ((trim($c11n2)=="") && (trim($c11n3)=="")) {         
          $c11 = $c11l1.$c11n1.$c11l2; $arraycls[11]=$c11; $arraytip[11]=$t11; }
        else {  
          mensajenew('AVISO: Error en la Clasificacion No. 11 ...!!!','javascript:history.back();','N');
	       $smarty->display('pie_pag.tpl'); exit(); } }      
      if ((trim($c12n2)!="") && (trim($c12n3)!="")) {   
        $c12 = $c12l1.$c12n1.$c12l2." ".$c12n2."/".$c12n3; 
        $arraycls[12]=$c12; $arraytip[12]=$t12; }
      else {
        if ((trim($c12n2)=="") && (trim($c12n3)=="")) {         
          $c12 = $c12l1.$c12n1.$c12l2; $arraycls[12]=$c12; $arraytip[12]=$t12; }
        else {  
          mensajenew('AVISO: Error en la Clasificacion No. 12 ...!!!','javascript:history.back();','N');
	       $smarty->display('pie_pag.tpl'); exit(); } }
	             
      // Chequeo si introdujo alguna Clasificacion o todas estan en blanco  
      //if  (empty($c1) && empty($c2) && empty($c3) && empty($c4) && empty($c5) && empty($c6) && 
      //     empty($c7) && empty($c8) && empty($c9) && empty($c10) && empty($c11) && empty($c12)) { 
      //  mensajenew('No introdujo ninguna Clasificacion ...!!!','javascript:history.back();','N');
      //  $smarty->display('pie_pag.tpl'); exit(); }

      // Verifico que haya especificado el tipo de Clasificacion 
      if ($c1!="") {
        if ($t1=="") {
          mensajenew('AVISO: No especifico el Tipo de Clasificacion en la No. 1 ...!!!','javascript:history.back();','N');
          $smarty->display('pie_pag.tpl'); exit(); } }
      if ($c2!="") {
        if ($t2=="") {
          mensajenew('AVISO: No especifico el Tipo de Clasificacion en la No. 2 ...!!!','javascript:history.back();','N');
          $smarty->display('pie_pag.tpl'); exit(); } }
      if ($c3!="") {
        if ($t3=="") {
          mensajenew('AVISO: No especifico el Tipo de Clasificacion en la No. 3 ...!!!','javascript:history.back();','N');
          $smarty->display('pie_pag.tpl'); exit(); } }
      if ($c4!="") {
        if ($t4=="") {
          mensajenew('AVISO: No especifico el Tipo de Clasificacion en la No. 4 ...!!!','javascript:history.back();','N');
          $smarty->display('pie_pag.tpl'); exit(); } }
      if ($c5!="") {
        if ($t5=="") {
          mensajenew('AVISO: No especifico el Tipo de Clasificacion en la No. 5 ...!!!','javascript:history.back();','N');
          $smarty->display('pie_pag.tpl'); exit(); } }
      if ($c6!="") {
        if ($t6=="") {
          mensajenew('AVISO: No especifico el Tipo de Clasificacion en la No. 6 ...!!!','javascript:history.back();','N');
          $smarty->display('pie_pag.tpl'); exit(); } }
      if ($c7!="") {
        if ($t7=="") {
          mensajenew('AVISO: No especifico el Tipo de Clasificacion en la No. 7 ...!!!','javascript:history.back();','N');
          $smarty->display('pie_pag.tpl'); exit(); } }
      if ($c8!="") {
        if ($t8=="") {
          mensajenew('AVISO: No especifico el Tipo de Clasificacion en la No. 8 ...!!!','javascript:history.back();','N');
          $smarty->display('pie_pag.tpl'); exit(); } }
      if ($c9!="") {
        if ($t9=="") {
          mensajenew('AVISO: No especifico el Tipo de Clasificacion en la No. 9 ...!!!','javascript:history.back();','N');
          $smarty->display('pie_pag.tpl'); exit(); } }
      if ($c10!="") {
        if ($t10=="") {
          mensajenew('AVISO: No especifico el Tipo de Clasificacion en la No. 10 ...!!!','javascript:history.back();','N');
          $smarty->display('pie_pag.tpl'); exit(); } }
      if ($c11!="") {
        if ($t11=="") {
          mensajenew('AVISO: No especifico el Tipo de Clasificacion en la No. 11 ...!!!','javascript:history.back();','N');
          $smarty->display('pie_pag.tpl'); exit(); } }
      if ($c12!="") {
        if ($t12=="") {
          mensajenew('AVISO: No especifico el Tipo de Clasificacion en la No. 12 ...!!!','javascript:history.back();','N');
          $smarty->display('pie_pag.tpl'); exit(); } }

     for ($cont=1;$cont<=12;$cont++) {
         $valor=$arraycls[$cont];
         if (!empty($valor)) {
           $clsfd = $arraycls[$cont];  
           $tipcl = $arraytip[$cont];
           $col_campos = "solicitud,clasificacion,tipo_clas";
           $insert_str = "'$varsol','$clsfd','$tipcl'";
           $sql->insert("$tbname_16","$col_campos","$insert_str","");
         } 
     }
    }
    // Tabla de Prioridades
    if (!empty($vnprior)) {
      $insert_str = "'$varsol','$vnprior','$vpaisprior','$vfechaprior'";
      $sql->insert("$tbname_15","","$insert_str",""); }
    if (!empty($vnprior1)) {
      $insert_str = "'$varsol','$vnprior1','$v1paisprior','$v1fechaprior'";
      $sql->insert("$tbname_15","","$insert_str",""); }
    if (!empty($vnprior2)) {
      $insert_str = "'$varsol','$vnprior2','$v2paisprior','$v2fechaprior'";
      $sql->insert("$tbname_15","","$insert_str",""); }
    if (!empty($vnprior3)) {
      $insert_str = "'$varsol','$vnprior3','$v3paisprior','$v3fechaprior'";
      $sql->insert("$tbname_15","","$insert_str",""); }
    pg_exec("COMMIT WORK");

    // Tabla de Titulares
    pg_exec("BEGIN WORK");
    pg_exec("LOCK TABLE tmpptitu IN SHARE ROW EXCLUSIVE MODE");
    $res_titu=pg_exec("SELECT * FROM tmpptitu where solicitud='$varsol'");
    $filas_res_titu=pg_numrows($res_titu);
    //if ($filas_res_titu == 0) {
    //  mensajenew("Expediente sin ningun Titular asociado ...!!!","javascript:history.back();","N");
    //  $smarty->display('pie_pag.tpl'); exit(); }
    //else {
      $regtitu = pg_fetch_array($res_titu);
      for($i=0;$i<$filas_res_titu;$i++) 
      { 
       if ($regtitu[titular]=="0")
         {
            $res_cod=pg_exec("SELECT * FROM stztitur order by titular DESC");
            //$res_cod=pg_exec("SELECT max(titular) FROM stztitur");
            $regcod = pg_fetch_array($res_cod);
            $vtit=$regcod[titular];
            $vtit=$vtit+1;
            $regtitu[nombre] = str_replace("'","´",$regtitu[nombre]);
            $regtitu[domicilio] = str_replace("'","´",$regtitu[domicilio]);
            $resultado=pg_exec("INSERT INTO stztitur (titular,nombre,pais_resid) VALUES ('$vtit','$regtitu[nombre]','$regtitu[pais_resid]')");
            $resultado=pg_exec("INSERT INTO stpottid (solicitud,titular,nacionalidad,domicilio) VALUES ('$varsol','$vtit','$regtitu[nacionalidad]','$regtitu[domicilio]')");
         }
       else
         {
            $resul=pg_exec("SELECT * FROM stpottid where solicitud='$varsol' and titular='$regtitu[titular]'");
            $filas_resul=pg_numrows($resul);
            if ($filas_resul==0) {
               $resultado=pg_exec("INSERT INTO stpottid (solicitud,titular,nacionalidad,domicilio) VALUES ('$varsol','$regtitu[titular]','$regtitu[nacionalidad]','$regtitu[domicilio]')");
            }  
         }
       $regtitu = pg_fetch_array($res_titu);
      }
    //} 
    pg_exec("COMMIT WORK");
  }

  //Desconexion de la Base de Datos
  $sql->disconnect();

  if ($accion==1) {
    Mensaje2("DATOS GUARDADOS CORRECTAMENTE !!!","p_ingresol.php?vopc=3","p_genera.php?vnum=$vnumero");
    $smarty->display('pie_pag.tpl'); exit(); }
  else {
    mensajenew('DATOS GUARDADOS CORRECTAMENTE !!!','p_ingresol.php?vopc=3','S');
    $smarty->display('pie_pag.tpl'); exit(); }
}

//Pase de variables y Etiquetas al template
$smarty->assign('campo1','Expediente No.:');
$smarty->assign('campo2','Fecha Expediente:');
$smarty->assign('campo3','Tipo de Patente:');
$smarty->assign('campo4','T&iacute;tulo:');
$smarty->assign('campo5','Dibujo o Dise&ntilde;o:');
//$smarty->assign('campo6','Modalidad:');
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
$smarty->display('p_ingresol.tpl');
$smarty->display('pie_pag.tpl');
?>
