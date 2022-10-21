<!-- <?php 
ob_start();
?> -->
<script language="Javascript"> 

function pregunta() { 
  return confirm('Estas seguro de grabar la Informacion ?'); }

 function browsetitular(var1,var2,var3,var4) {
   open("act_titular.php?vsol="+var1.value+"-"+var2.value+"&vtex="+var3.value+"&vmod="+var4.value,"Ventana", "scrollbars=yes,toolbar=no,directories=no,menubar=no,status=no"); }

 function browse_inventor(var1,var2,var3,var4) {
  open("act_inventor.php?vsol="+var1.value+"-"+var2.value+"&vtex="+var3.value+"&vmod="+var4.value,"Ventana", "scrollbars=yes,toolbar=no,directories=no,menubar=no,status=no"); }

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
 
</script>

<?php
//Para trabajar con Operaciones de Bases de Datos
include ("../setting.inc.php");
//Clase que sube el archivo
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
$tbname_14 = "stppriod";
$tbname_15 = "stptmpinv";

$vopc     = $_GET['vopc'];
$vuser    = $_GET['vuser'];
$vaccion  = $_GET['vaccion'];
$vauxnum  = $_GET['vauxnum'];
$depto_id = $_GET['vdepto'];
$vsol1    = $_POST['vsol1'];
$vsol2    = $_POST['vsol2'];
$vsol     = $_POST['vsol'];
$psoli    = $_POST['psoli'];

$fecha_solic=$_POST['fecha_solic'];
$tipo_paten=$_POST['tipo_derecho'];
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
//$vsol3=$_POST['vsol3'];
//$vsol4=$_POST['vsol4'];
//$vreg1d=$_POST['vreg1d'];
//$vreg2d=$_POST['vreg2d'];
$auxnum=$_POST['auxnum'];
$ubicacion=$_POST['ubicacion'];
$nroinv=$_POST['nroinv'];
//Prioridades 
$vnprior= $_POST['vnprior'];
$vfechaprior= $_POST['vfechaprior'];
$vpaisprior= $_POST['vpaisprior'];
$vnprior1= $_POST['vnprior1'];
$v1fechaprior= $_POST['v1fechaprior'];
$v1paisprior= $_POST['v1paisprior'];
$vnprior2= $_POST['vnprior2'];
$v2fechaprior= $_POST['v2fechaprior'];
$v2paisprior= $_POST['v2paisprior'];
$vnprior3= $_POST['vnprior3'];
$v3fechaprior= $_POST['v3fechaprior'];
$v3paisprior= $_POST['v3paisprior'];
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

// ******************************************************************************************
$smarty->assign('titulo','Sistema de Patentes');
$smarty->assign('subtitulo','Mantenimiento de Expediente'); 
if ($vopc==3) {
  $smarty->assign('subtitulo','Mantenimiento de Expediente / Ingreso'); }
if (($vopc==4) || ($vopc==1)) {
  $smarty->assign('subtitulo','Mantenimiento de Expediente / Modificaci&oacute;n'); }
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

$smarty->assign('arraytipom',array(V,A,G,F));
$smarty->assign('arraynotip',array('','INVENCION','DISE&Ntilde;O INDUSTRIAL','MODELO DE UTILIDAD'));
 
if (($vopc==1) || ($vopc==3)) {
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

//Opcion Modificar
if ($vopc==1) {
  $smarty->assign('modo1','disabled'); 
  $smarty->assign('vmodo',''); 
  $smarty->assign('modo',''); 
  $smarty->assign('modo2',''); 
  $smarty->assign('modo3','disabled'); 
  $smarty->assign('submitbutton3','submit');
  $smarty->assign('submitbutton','button');
  $smarty->assign('subtitulo','Mantenimiento de Expediente / Modificaci&oacute;n'); 
  $smarty->assign('accion',2);

  //Validacion del Numero de Solicitud
  if (empty($vsol1) && empty($vsol2)) {
     mensajenew("ERROR: No introdujo ningun valor de Expediente ...!!!","javascript:history.back();","N");
     $smarty->display('pie_pag.tpl'); exit(); }

  //Armado del Numero de Expediente
  $varsol=$vsol1."-".sprintf("%06d",$vsol2);
  $dirano=$vsol1;
  //Variable Numero del Expediente
  $numero=substr($varsol,-6,6);
  
  //Verificando conexion
  $sql->connection();
  
  $resultado=pg_exec("SELECT * FROM $tbname_4 WHERE solicitud='$varsol' and solicitud!=''");

  if (!$resultado) { 
     mensajenew("ERROR: PROBLEMA AL PROCESAR LA BUSQUEDA ...!!!","javascript:history.back();","N");
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  }	 
  $filas_found=pg_numrows($resultado); 
  if ($filas_found==0) {
     mensajenew("AVISO: NO EXISTEN DATOS ASOCIADOS ...!!!","javascript:history.back();","N");
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  }	 
  $reg = pg_fetch_array($resultado);

  $vsol=$reg[solicitud];
  $psoli=$reg[solicitud];
  $smarty->assign('psoli',$psoli); 
  $vsol1=substr($vsol,-11,4);
  $vsol2=substr($vsol,-6,6);
  $estatus=$reg[estatus];
  
  if (($estatus==1) || ($estatus==4)) { }  
  else {
    if ($usuario=='mrocha') { }
    else {
      Mensajenew("ERROR: Usuario NO tiene Permiso para modificar bajo este Estatus ...!!!","p_manteni.php?vopc=4&vaccion=2&vauxnum=0","N");
      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();
    }
  }
  
  $registro=$reg[registro];
  $nombre=trim($reg[nombre]);
  $vcodpais=$reg[pais_resid];
  $tipo_paten=$reg[tipo_paten];
  $tramitante=trim($reg[tramitante]);
  $fecha_solic=$reg[fecha_solic];
  $poder = $reg[poder];
  $vpod1 = trim(substr($poder,-9,4));
  $vpod2 = trim(substr($poder,-4,4));
  $vcodage=$reg[agente];

  if (!empty($vpod1) && !empty($vpod2))
   { $vpoder= $vpod1."-".$vpod2; } else
   { $vpoder=''; }

  //if ($vcodagenew!='' || !empty($vcodagenew)) {
  //   $resulage = pg_exec("select * from stzagenr where agente='$vcodagenew'");
  //   $regage = pg_fetch_array($resulage);
  //   $vcodage=$regage[agente];
  //   $vnomage=$regage[nombre]; }
     
  //if ($arraycodpais!='' || !empty($arraycodpais)) {
  //    $resulpais = pg_exec("select * from stzpaisr where pais='$arraycodpais'");
  //    $regpais = pg_fetch_array($resulpais);
  //    $vnompais=$regpais[nombre];
  //    $vcodpais=$regpais[pais]; }

  //Almaceno en un string los valores de los campos antes de modificar alguno
  //$pais_resid = $arraycodpais;
  $pais_resid = $vcodpais;
  if (!empty($vcodagenew)) { $agen_id = $vcodagenew; }
  $valores_fields = array($nombre,$fecha_solic,$tipo_paten,$agen_id,$vpoder,$tramitante,$pais_resid);
  $campos = "nombre|fecha_solic|tipo_paten|agente|poder|tramitante|pais_resid";
  $vstring = bitacora_fields();
  $smarty->assign('vstring',$vstring);
  $smarty->assign('campos',$campos);
  
  $auxnum = $vsol1;
  $smarty->assign('auxnum',$auxnum);
  
  // Obtencion del o los Titulares
  $sql->del("$tbname_11","solicitud='$varsol'");
  $obj_query = $sql->query("SELECT stpottid.titular,stztitur.nombre,stpottid.nacionalidad,stpottid.domicilio,stztitur.pais_resid 
                            FROM stpottid,stztitur WHERE solicitud ='$varsol' and 
                                 stpottid.titular=stztitur.titular");
  $obj_filas = $sql->nums('',$obj_query);
  $objs = $sql->objects('',$obj_query);
  for ($contobj=0;$contobj<$obj_filas;$contobj++) {
     $vcod = $objs->titular;
     $nomb = $objs->nombre;
     $pais = $objs->nacionalidad;
     $domi = $objs->domicilio;
     $resi = $objs->pais_resid;
     $insert_str = "'$varsol','$vcod','$pais','$domi','$nomb','$resi'";
     $sql->insert("$tbname_11","","$insert_str","");
  $objs = $sql->objects('',$obj_query); }	  

  //Inventores
  $sql->del("$tbname_15","solicitud='$varsol'");
  $obj_query = $sql->query("SELECT * FROM stpinved WHERE solicitud ='$varsol' order by nombre_inv");
  $obj_filas = $sql->nums('',$obj_query);
  $objs = $sql->objects('',$obj_query);
  $codigo = 0;
  for ($contobj=0;$contobj<$obj_filas;$contobj++) {
     $ninventor = trim($objs->nombre_inv);
     $nac = $objs->nacionalidad;
     $codigo = $codigo + 1;
     $insert_str = "'$varsol','$ninventor','$nac',$codigo";
     $sql->insert("stptmpinv","","$insert_str","");
     $objs = $sql->objects('',$obj_query);
  }

  //// Obtencion del o los Inventor(es) 
  //$obj_query = $sql->query("SELECT * FROM stpinved WHERE solicitud ='$varsol' order by nombre_inv");
  //$obj_filas = $sql->nums('',$obj_query);
  //$objs = $sql->objects('',$obj_query);
  //for ($contobj=1;$contobj<=$obj_filas;$contobj++) {
  //   $inventor[$contobj] = $objs->nombre_inv;
  //   $invnac[$contobj] = $objs->nacionalidad;
  //   $insert_str = "'$contobj','$varsol','$objs->nombre_inv','$objs->nacionalidad'";
  //   $sql->insert("tempinven","","$insert_str","");
  //   $objs = $sql->objects('',$obj_query);
  //}
  //$sql->del("$tbname_8","solicitud='$varsol'");
  //$smarty->assign('nroinv',$obj_filas);
  //$smarty->assign('inventor1',$inventor[1]); 
  //$smarty->assign('paisinv1',$invnac[1]); 
  //$smarty->assign('inventor2',$inventor[2]); 
  //$smarty->assign('paisinv2',$invnac[2]); 
  //$smarty->assign('inventor3',$inventor[3]); 
  //$smarty->assign('paisinv3',$invnac[3]); 
  //$smarty->assign('inventor4',$inventor[4]); 
  //$smarty->assign('paisinv4',$invnac[4]); 
  //$smarty->assign('inventor5',$inventor[5]); 
  //$smarty->assign('paisinv5',$invnac[5]); 
  //$smarty->assign('inventor6',$inventor[6]); 
  //$smarty->assign('paisinv6',$invnac[6]); 
  //$smarty->assign('inventor7',$inventor[7]); 
  //$smarty->assign('paisinv7',$invnac[7]); 
  //$smarty->assign('inventor8',$inventor[8]); 
  //$smarty->assign('paisinv8',$invnac[8]); 
  //$smarty->assign('inventor9',$inventor[9]); 
  //$smarty->assign('paisinv9',$invnac[9]); 
  //$smarty->assign('inventor10',$inventor[10]); 
  //$smarty->assign('paisinv10',$invnac[10]); 

  //Obtencion de las Prioridades 
  $obj_query = $sql->query("SELECT * FROM $tbname_14 WHERE solicitud='$varsol' and solicitud!=''");
  $obj_filas = $sql->nums('',$obj_query);
  if ($obj_filas!=0) {
    $objs = $sql->objects('',$obj_query);
    $vnprior= $objs->prioridad;
    $vfechaprior= $objs->fecha_priori;
    $vpaisprior= $objs->pais_priori; 
    $smarty->assign('vnprior',$vnprior); 
    $smarty->assign('vfechaprior',$vfechaprior); 
    $smarty->assign('vpais_prior',$vpaisprior); }
  if ($obj_filas > 1) {
    $objs = $sql->objects('',$obj_query);
    $vnprior1= $objs->prioridad;
    $v1fechaprior= $objs->fecha_priori;
    $v1paisprior= $objs->pais_priori; 
    $smarty->assign('vnprior1',$vnprior1); 
    $smarty->assign('v1fechaprior',$v1fechaprior); 
    $smarty->assign('v1pais_prior',$v1paisprior); }
  if ($obj_filas > 2) {
    $objs = $sql->objects('',$obj_query);
    $vnprior2= $objs->prioridad;
    $v2fechaprior= $objs->fecha_priori;
    $v2paisprior= $objs->pais_priori; 
    $smarty->assign('vnprior2',$vnprior2); 
    $smarty->assign('v2fechaprior',$v2fechaprior); 
    $smarty->assign('v2pais_prior',$v2paisprior); }
  if ($obj_filas > 3) {
    $objs = $sql->objects('',$obj_query);
    $vnprior3= $objs->prioridad;
    $v3fechaprior= $objs->fecha_priori;
    $v3paisprior= $objs->pais_priori; 
    $smarty->assign('vnprior3',$vnprior3); 
    $smarty->assign('v3fechaprior',$v3fechaprior); 
    $smarty->assign('v3pais_prior',$v3paisprior); }

  // Obtencion del resumen 
  $resumen='';
  $obj_query = $sql->query("SELECT * FROM $tbname_6 WHERE solicitud ='$varsol'");
  $obj_filas = $sql->nums('',$obj_query);
  if ($obj_filas!=0) {
    $objs = $sql->objects('',$obj_query);
    $resumen = trim($objs->resumen);
    $smarty->assign('resumen',$resumen); }
  $smarty->assign('vstring1',$resumen);
  $smarty->assign('tipo_paten',$tipo_paten);
  
}

//Opcion Grabar...
if (($vopc==2) || ($vopc==6)) {
  //La Fecha de Hoy y Hora para la transaccion
  $fechahoy = hoy();
  $horactual= Hora();

  //Verificando conexion
  $sql->connection();

  //Validacion del Numero de Solicitud
  if ($accion==2) {
    if (!empty($vsol1) && !empty($vsol2)) { 
      $varsol=$vsol1."-".sprintf("%06d",$vsol2); } 
  else {
    mensajenew("AVISO: Numero de Solicitud Vacio o con Error ...!!!","javascript:history.back();","N");
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
    
  if ($accion==1) 
  {
    $vcodage=$vnomagenew;
    if ($vnomagenew!='' || !empty($vnomagenew)) {
      $resulage = pg_exec("select * from stzagenr where nombre='$vcodage'");
      $regage = pg_fetch_array($resulage);
      $vcodagenew=$regage[agente];
      $vcodage=$regage[agente];
      $vnomage=$regage[nombre]; 
      $vnomagenew=$regage[nombre]; 
      $smarty->assign('vcodage',$vcodage);
      $smarty->assign('vnomage',$vnomage);
    } 
  } 
  else {
    if ($vcodage!='' || empty($vcodage)) {
      $resulage = pg_exec("select * from stzagenr where nombre='$vcodage'");
      $regage = pg_fetch_array($resulage);
      $vcodagenew=$regage[agente];
      $vnomage=$regage[nombre]; }
  } 

  if (empty($input2)) { 
      $vcodpais="";  
      mensajenew("Debe indicar Pais de Residencia ...!!!","javascript:history.back();","N"); 
      $smarty->display('pie_pag.tpl'); exit(); }

  //Validacion del Poder
  if (!empty($vpod1) && !empty($vpod2))
   { $vpoder= $vpod1."-".sprintf("%04d",$vpod2); } else
   { $vpoder=""; }

  if (empty($input1)) { $vcodage=0; }
  else { $vcodage=$input1; }

  if (empty($tramitante) && empty($vpoder) && empty($vcodage)) {
      mensajenew("Debe tener Tramitante o Poder o Agente(s) ...!!!","javascript:history.back();","N");
      $smarty->display('pie_pag.tpl'); exit(); }

  if ($tramitante!="") {
    if (($vpoder!="") || ($vcodage!="0")) {
      mensajenew("Solo puede tener Tramitante o Poder o Agente(s) ...!!!","javascript:history.back();","N");
      $smarty->display('pie_pag.tpl'); exit(); } }

  //if ($vcodage!="") {
   // if (($vpoder!="") || ($tramitante!="")) {
    //  mensajenew("Solo puede tener Tramitante o Poder o Agente(s) ...!!!","javascript:history.back();","N");
    //  $smarty->display('pie_pag.tpl'); exit(); } }
   
  //if ($vpoder!="") {
   // if (($vcodage!="") || ($tramitante!="")) {
    //  mensajenew("Solo puede tener Tramitante o Poder o Agente(s) ...!!!","javascript:history.back();","N");
     // $smarty->display('pie_pag.tpl'); exit(); } }

  $obj_query = $sql->query("SELECT * FROM stptmpinv WHERE solicitud ='$varsol'");
  $obj_filas = $sql->nums('',$obj_query);
  if ($obj_filas==0) {
    Mensajenew("ERROR: Solicitud sin Inventor(es) asociado(s) ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }

  if ($accion==1) {
    // Ingreso de Solicitud
  } //Incluir
  else {
    // Modificar Solicitud
    $varsol = sprintf("%02d-%06d",$vsol1,$vsol2);

    //Se obtiene el proximo valor para el secuencial a guardar en stzbitac a partir de stzsistem
    pg_exec("BEGIN WORK");
    pg_exec("LOCK TABLE stzsystem IN SHARE ROW EXCLUSIVE MODE");
    $sys_actual = next_sys("nbitaco");
    $vsecuencial = grabar_sys("nbitaco",$sys_actual);
    pg_exec("COMMIT WORK");
    
    // Corregir campos, colocado a tipo serial 
    // Almaceno registro original en Bitacora
    //$insert_str = "'$vsecuencial','$fechahoy','$horactual','$usuario','$tbname_4','M','M','$varsol','$vstring','$campos'";
    //$sql->insert("$tbname_12","","$insert_str","");

    //Se obtiene el proximo valor para el secuencial a guardar en stzbider a partir de stzsistem para distingue
    pg_exec("BEGIN WORK");
    pg_exec("LOCK TABLE stzsystem IN SHARE ROW EXCLUSIVE MODE");
    $sys_actual = next_sys("nbitaco");
    $vsecuencial = grabar_sys("nbitaco",$sys_actual);
    pg_exec("COMMIT WORK");

    // Almaceno registro original en Bitacora stzbider
    //$insert_str = "'$vsecuencial','$fechahoy','$horactual','$usuario','$tbname_6','M','M','$varsol','$vstring1'";
    //$sql->insert("$tbname_13","","$insert_str","");

    //Actualizacion del estatus del expediente en la maestra de patentes 
    pg_exec("BEGIN WORK");
    pg_exec("LOCK TABLE stppatee IN SHARE ROW EXCLUSIVE MODE");
    $nombre = str_replace("'","",$nombre);
    $tramitante = str_replace("'","",$tramitante);
    $update_str = "fecha_solic='$fecha_solic',tipo_paten='$tipo_paten',nombre='$nombre',poder='$vpoder',agente='$vcodage',tramitante='$tramitante',pais_resid='$input2'";
    $sql->update("$tbname_4","$update_str","solicitud='$varsol'");

    // Tabla de Resumen
    $vres = str_replace("'","´",$resumen);
    $obj_query = $sql->query("SELECT * FROM $tbname_6 WHERE solicitud ='$varsol'");
    $obj_filas = $sql->nums('',$obj_query);
    pg_exec("LOCK TABLE stpresud IN SHARE ROW EXCLUSIVE MODE");
    if ($obj_filas==0) {
      $insert_str = "'$varsol','$vres'";
      $sql->insert("$tbname_6","","$insert_str",""); }
    else {
      $update_str = "resumen = '$vres'";
      $sql->update("$tbname_6","$update_str","solicitud='$varsol'"); }  
    pg_exec("COMMIT WORK");

    // Tabla de Prioridades
    pg_exec("BEGIN WORK");
    $sql->del("stppriod","solicitud='$varsol'");
    if (!empty($vnprior)) {
      $insert_str = "'$varsol','$vnprior','$vpaisprior','$vfechaprior'";
      $sql->insert("$tbname_14","","$insert_str",""); }
    if (!empty($vnprior1)) {
      $insert_str = "'$varsol','$vnprior1','$v1paisprior','$v1fechaprior'";
      $sql->insert("$tbname_14","","$insert_str",""); }
    if (!empty($vnprior2)) {
      $insert_str = "'$varsol','$vnprior2','$v2paisprior','$v2fechaprior'";
      $sql->insert("$tbname_14","","$insert_str",""); }
    if (!empty($vnprior3)) {
      $insert_str = "'$varsol','$vnprior3','$v3paisprior','$v3fechaprior'";
      $sql->insert("$tbname_14","","$insert_str",""); }

    // Tabla de Inventores 
    pg_exec("LOCK TABLE stpinved IN SHARE ROW EXCLUSIVE MODE");
    //$sql->del("stpinved","solicitud='$varsol'");
    //if (!empty($inventor1)) {
    //  $nombinv = str_replace("'","´",$inventor1);
    //  $insert_str = "'$varsol','$nombinv','$invnac1'";
    //  $sql->insert("$tbname_8","","$insert_str",""); }
    //if (!empty($inventor2)) {
    //  $nombinv = str_replace("'","´",$inventor2);
    //  $insert_str = "'$varsol','$nombinv','$invnac2'";
    //  $sql->insert("$tbname_8","","$insert_str",""); }
    //if (!empty($inventor3)) {
    //  $nombinv = str_replace("'","´",$inventor3);
    //  $insert_str = "'$varsol','$nombinv','$invnac3'";
    //  $sql->insert("$tbname_8","","$insert_str",""); }
    //if (!empty($inventor4)) {
    //  $nombinv = str_replace("'","´",$inventor4);
    //  $insert_str = "'$varsol','$nombinv','$invnac4'";
    //  $sql->insert("$tbname_8","","$insert_str",""); }
    //if (!empty($inventor5)) {
    //  $nombinv = str_replace("'","´",$inventor5);
    //  $insert_str = "'$varsol','$nombinv','$invnac5'";
    //  $sql->insert("$tbname_8","","$insert_str",""); }
    //if (!empty($inventor6)) {
    //  $nombinv = str_replace("'","´",$inventor6);
    //  $insert_str = "'$varsol','$nombinv','$invnac6'";
    //  $sql->insert("$tbname_8","","$insert_str",""); }
    //if (!empty($inventor7)) {
    //  $nombinv = str_replace("'","´",$inventor7);
    //  $insert_str = "'$varsol','$nombinv','$invnac7'";
    //  $sql->insert("$tbname_8","","$insert_str",""); }
    //if (!empty($inventor8)) {
    //  $nombinv = str_replace("'","´",$inventor8);
    //  $insert_str = "'$varsol','$nombinv','$invnac8'";
    //  $sql->insert("$tbname_8","","$insert_str",""); }
    //if (!empty($inventor9)) {
    //  $nombinv = str_replace("'","´",$inventor9);
    //  $insert_str = "'$varsol','$nombinv','$invnac9'";
    //  $sql->insert("$tbname_8","","$insert_str",""); }
    //if (!empty($inventor10)) {
    //  $nombinv = str_replace("'","´",$inventor10);
    //  $insert_str = "'$varsol','$nombinv','$invnac10'";
    //  $sql->insert("$tbname_8","","$insert_str",""); }
    
    // Grabacion del resto de Inventor(es) 
    //if ($nroinv > 10) {
    //   $obj_query = $sql->query("SELECT * FROM tempinven WHERE solicitud ='$varsol' and nroinv > 10 order by nombre");
    //   $obj_filas = $sql->nums('',$obj_query);
    //   $objs = $sql->objects('',$obj_query);
    //   for ($contobj=0;$contobj<=$obj_filas;$contobj++) {
    //      $insert_str = "'$varsol','$objs->nombre','$objs->nacionalidad'";
    //      $sql->insert("stpinved","","$insert_str","");
    //      $objs = $sql->objects('',$obj_query);
    //   }
    //}  
    //$sql->del("tempinven","solicitud='$varsol'");

    $sql->del("stpinved","solicitud='$varsol'");
    $obj_query = $sql->query("SELECT * FROM stptmpinv WHERE solicitud ='$varsol'");
    $obj_filas = $sql->nums('',$obj_query);
    $objs = $sql->objects('',$obj_query);
    for ($contobj=0;$contobj<$obj_filas;$contobj++) {
      $nbnombre = $objs->nombre_inv;
      $pais = $objs->nacionalidad;
      $insert_str = "'$varsol','$nbnombre','$pais'";
      $sql->insert("stpinved","","$insert_str","");
      $objs = $sql->objects('',$obj_query); }
    $sql->del("$tbname_15","solicitud='$varsol'");

    // Tabla de Titulares
    pg_exec("LOCK TABLE tmpptitu IN SHARE ROW EXCLUSIVE MODE");
    $res_titu=pg_exec("SELECT * FROM tmpptitu where solicitud='$varsol'");
    $filas_res_titu=pg_numrows($res_titu);
    if ($filas_res_titu==0) {
      Mensage_Error("Solicitud No tiene ningun titular asociado ...!!!");
      $smarty->display('pie_pag.tpl'); exit(); }
    
    $sql->del("stpottid","solicitud='$varsol'");
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
    pg_exec("COMMIT WORK");

  } // Modificar

  //Desconexion de la Base de Datos
  $sql->disconnect();

  if ($accion==2) {
    mensajenew('DATOS GUARDADOS CORRECTAMENTE !!!','p_manteni.php?vopc=4','S');
    $smarty->display('pie_pag.tpl'); exit(); }
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
  $smarty->assign('subtitulo','Mantenimiento de Expediente / Modificaci&oacute;n');
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
}

//Pase de variables y Etiquetas al template
$smarty->assign('campo1','Expediente No.:');
$smarty->assign('campo2','Fecha Expediente:');
$smarty->assign('campo3','Tipo de Patente:');
$smarty->assign('campo4','Nombre:');
//$smarty->assign('campo5','Clase Internacional:');
//$smarty->assign('campo6','Modalidad:');
$smarty->assign('campo7','&nbsp;&nbsp;Pais de Residencia:');
$smarty->assign('campo8','Resumen:');
$smarty->assign('campo9','Inventor(es):');
$smarty->assign('campo10','Titular(es):');
$smarty->assign('campo11','Poder:');
$smarty->assign('campo12','Agente:');
$smarty->assign('campo13','Tramitante:');
$smarty->assign('campo14','Inventores:');
$smarty->assign('campo15','Logotipo:');
//$smarty->assign('campo16','Lema Aplicado a:');
$smarty->assign('campo17','Prioridad:');

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

$smarty->display('p_manteni.tpl');
$smarty->display('pie_pag.tpl');
?>
