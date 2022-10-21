<!-- <?php 
ob_start();
?> -->

<script language="Javascript"> 

function pregunta() { 
  return confirm('Estas seguro de grabar la Informacion ?'); }

 function browsetitular(var1,var2,var3,var4) {
   open("act_titular.php?vsol="+var1.value+"-"+var2.value+"&vtex="+var3.value+"&vmod="+var4.value,"Ventana", "scrollbars=yes,toolbar=no,directories=no,menubar=no,status=no"); }

 function gestionviena(var1,var2,var3,var4) {
   open("act_viena.php?vsol="+var1.value+"-"+var2.value+"&vtex="+var3.value+"&vmod="+var4.value,"Ventana", "scrollbars=yes,toolbar=no,directories=no,menubar=no,status=no"); }

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
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

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
$tbname_4 = "stmmarce";
$tbname_5 = "stmevtrd";
$tbname_6 = "stmdistd";
$tbname_7 = "stmottid";
$tbname_8 = "stmlogos";
$tbname_9 = "batfon";
$tbname_10 = "stzusuar";
$tbname_11 = "temptitu";
$tbname_12 = "stzbitac";
$tbname_13 = "stzbider";
$tbname_14 = "stmlemad";
$tbname_15 = "stmpriod";

$vopc=$_GET['vopc'];
$vuser=$_GET['vuser'];
$vaccion=$_GET['vaccion'];
$vauxnum=$_GET['vauxnum'];
$depto_id=$_GET['vdepto'];
$vsol1=$_POST['vsol1'];
$vsol2=$_POST['vsol2'];
$vreg1=$_POST['vreg1'];
$vreg2=$_POST['vreg2'];
$vsol=$_POST['vsol'];
$vreg=$_POST['vreg'];
$psoli=$_POST['psoli'];

$modalidad=$_POST['modalidad'];
$fecha_solic=$_POST['fecha_solic'];
$fecha_regis=$_POST['fecha_regis'];
$fecha_venc=$_POST['fecha_venc'];
$tipo_marca=$_POST['tipo_marca'];
$nombre=$_POST['nombre'];
$clase_id=$_POST['clase_id'];
$vclase=$_POST['vclase'];
$agen_id=$_POST['agen_id'];
$vage1=$_POST['vagen'];
$vpod1=$_POST['vpod1'];
$vpod2=$_POST['vpod2'];
$tramitante=$_POST['tramitante'];
$pais_resid=$_POST['pais_resid'];
$distingue=$_POST['distingue'];
$etiqueta=$_POST['etiqueta'];
$depto=$_POST['depto'];
$dirano= $_POST['dirano'];
$vstring=$_POST['vstring'];
$vstring1=$_POST['vstring1'];
$vstring2=$_POST['vstring2'];
$campos=$_POST['campos'];
$accion=$_POST['accion'];
$auxnum=$_POST['auxnum'];
$vnumclase=$_POST['options'];
$vcodpais=$_POST['vcodpais'];
$arraynompais=$_POST['vnompais'];
$vcodage=$_POST['vcodage'];
$vnomagenew=$_POST['vnomage'];
$input1=$_POST['input1'];
$input2=$_POST['input2'];
$vsol3=$_POST['vsol3'];
$vsol4=$_POST['vsol4'];
$vreg1d=$_POST['vreg1d'];
$vreg2d=$_POST['vreg2d'];
$ubicacion= $_POST['ubicacion'];
$vnprior= $_POST['vnprior'];
$vfechaprior= $_POST['vfechaprior'];
$vpaisprior= $_POST['vpaisprior'];

// ******************************************************************************************
$smarty->assign('titulo','Sistema de Marcas');
$smarty->assign('subtitulo','Modificaci&oacute;n de Expediente por Correccion de Error'); 
if ($vopc==3) {
  $smarty->assign('subtitulo','Modificaci&oacute;n de Expediente por Correccion de Error'); }
if ($vopc==4) {
  $smarty->assign('subtitulo','Modificaci&oacute;n de Expediente por Correccion de Error'); }
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

$smarty->assign('arraytipom',array(V,M,N,L,S,C,D));
$smarty->assign('arraynotip',array('','MARCA DE PRODUCTO','NOMBRE COMERCIAL','LEMA COMERCIAL','MARCA DE SERVICIO','MARCA COLECTIVA','DENOMINACION DE ORIGEN'));
$smarty->assign('arrayvclase',array(I,N));
$smarty->assign('arraytclase',array('INTERNACIONAL','NACIONAL'));
$smarty->assign('arrayvmodal',array(N,D,G,M));
$smarty->assign('arraytmodal',array('','DENOMINATIVA','GRAFICA','MIXTA'));

if (($vopc==1) || ($vopc==3)) {
//Obtencion de los Paises
$obj_query = $sql->query("SELECT * FROM $tbname_1 order by nombre");
if (!$obj_query) { 
  mensajenew("Problema al intentar realizar la consulta en la tabla  $tbname_1 ...!!!","javascript:history.back();","N");
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

// Obtencion de las Clases Internacionales
$contobji=0;
$vcodclase[$contobji] = '';
$vnomclase[$contobji] = '';
$objquery = $sql->query("SELECT * FROM stmclinr ORDER BY clase_inter");
$objfilas = $sql->nums('',$objquery);
$objs = $sql->objects('',$objquery);
for ($contobji=1;$contobji<=$objfilas;$contobji++) {
     $vcodclase[$contobji] = $objs->clase_inter;
     $vnomclase[$contobji] = sprintf("%02d",$objs->clase_inter)." ".$objs->productos;
$objs = $sql->objects('',$objquery);}	  
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
  $smarty->assign('subtitulo','Modificaci&oacute;n de Registros'); 
  $smarty->assign('accion',2);

  //Validacion del Numero de Solicitud
  //if (empty($vsol1) && empty($vsol2)) {
  //   mensajenew("No introdujo ningn valor de Expediente ...!!!","javascript:history.back();","N");
  //   $smarty->display('pie_pag.tpl'); exit(); }

  //Armado del Numero de Expediente
  $varreg=$vreg1.$vreg2;
  $varsol=$vsol1."-".sprintf("%06d",$vsol2);
  $dirano=$vsol1;
  //Variable Numero del Expediente
  $numero=substr($varsol,-6,6);
  
  //Verificando conexion
  $sql->connection();
  
  if (!empty($varreg)) {
     $resultado=pg_exec("SELECT * FROM $tbname_4 WHERE registro='$varreg'"); }
  else {
     $resultado=pg_exec("SELECT * FROM $tbname_4 WHERE solicitud='$varsol'"); }

  if (!$resultado) { 
     mensajenew("ERROR AL PROCESAR LA BUSQUEDA ...!!!","javascript:history.back();","N");
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  }	 
  $filas_found=pg_numrows($resultado); 
  if ($filas_found==0) {
     mensajenew("NO EXISTEN DATOS ASOCIADOS ...!!!","javascript:history.back();","N");
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  }	 
  $reg = pg_fetch_array($resultado);

  $vsol=$reg[solicitud];
  $varsol=$vsol; 
  $psoli=$reg[solicitud];
  $smarty->assign('psoli',$psoli); 
  $vsol1=substr($vsol,-11,4);
  $vsol2=substr($vsol,-6,6);
  $registro=$reg[registro];
  $vreg1=substr($registro,-7,1);
  $vreg2=substr($registro,-6,6);
  $estatus=$reg[estatus];
  if ($estatus!=26) {
    mensajenew("Solo se pueden modificar Expedientes en Estatus 26 ...!","m_mdsolerr.php?vopc=4&vaccion=2&vauxnum=0","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  }
  $nombre=trim($reg[nombre]);
  $vcodpais=$reg[pais_resid];
  $tipo_marca=$reg[tipo_marca];
  $vclase=$reg[clase];
  $clase_id=$reg[ind_claseni];
  $modalidad=$reg[modalidad];
  $tramitante=trim($reg[tramitante]);
  $fecha_solic=$reg[fecha_solic];
  $fecha_regis=$reg[fecha_regis];
  $fecha_venc=$reg[fecha_venc];
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
  $valores_fields = array($nombre,$fecha_solic,$fecha_regis,$fecha_venc,$tipo_marca,$vclase,$clase_id,$modalidad,$agen_id,$vpoder,$tramitante,$pais_resid);
  $campos = "nombre|fecha_solic|fecha_regis|fecha_venc|tipo_marca|clase|ind_claseni|modalidad|agente|poder|tramitante|pais_resid";
  $vstring = bitacora_fields();
  $smarty->assign('vstring',$vstring);
  $smarty->assign('campos',$campos);
  
  switch ($modalidad) {
     case "G":
         $nameimage = imagen($vsol1,$vsol2);
         break;
     case "M":
         $nameimage = imagen($vsol1,$vsol2);
         break;
  }
  if ($modalidad=="D") {
    $nameimage="imagenes/sin_imagen.jpg";
  }
  $smarty->assign('ubicacion',$nameimage);
  
  ////Variable para la busqueda de la imagen
  //$vnsol=$dirano.substr($varsol,-6,6);
  ////Nombre de la Imagen del Expediente 
  //$nameimage="imagenes/SAPI_Logo.jpg";
  //$ruta = "imagenes/marcas/ef".$dirano."/";

  ////Verificacion de que si existe la imagen en disco
  //if (($modalidad=="G") || ($modalidad=="M")) {
  //  if (!file_exists($nameimage)) {
  //    Mensage_Error("Imagen no ha sido Encontrada, debe ser Scaneada para proseguir con la modificacion ...!!!");
  //    $smarty->display('pie_pag.tpl'); exit(); } }
 
  $auxnum = $vsol1;
  $smarty->assign('auxnum',$auxnum);
  
  // Obtencion del o los Titulares
  $sql->del("$tbname_11","solicitud='$varsol'");
  $obj_query = $sql->query("SELECT stmottid.titular,stztitur.nombre,stmottid.nacionalidad,stmottid.domicilio,stztitur.pais_resid 
                            FROM stmottid,stztitur WHERE solicitud ='$varsol' and 
                                 stmottid.titular=stztitur.titular");
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

  // Obtencion del Distingue
  $distingue='';
  $obj_query = $sql->query("SELECT * FROM $tbname_6 WHERE solicitud ='$varsol'");
  $obj_filas = $sql->nums('',$obj_query);
  if ($obj_filas!=0) {
    $objs = $sql->objects('',$obj_query);
    $distingue = trim($objs->distingue); }
  $smarty->assign('vstring1',$distingue);

  $etiqueta='';
  // Obtencion de la Etiqueta
  if (($modalidad=="G") || ($modalidad=="M")) {
    $vexist= 0;
    $obj_query = $sql->query("SELECT * FROM $tbname_8 WHERE solicitud ='$varsol'");
    $obj_filas = $sql->nums('',$obj_query);
    if ($obj_filas!=0) {
      $objs = $sql->objects('',$obj_query);
      $etiqueta = trim($objs->descripcion); 
      $vexist= 1;}
    else { $vexist= 0;}
  $smarty->assign('vstring2',$etiqueta);
  }
  $smarty->assign('modalidad',$modalidad);
  $smarty->assign('tipo_marca',$tipo_marca);

}

//Opcion Grabar...
if (($vopc==2) || ($vopc==6)) {
  //La Fecha de Hoy y Hora para la transaccion
  $fechahoy = hoy();
  $horactual= Hora();

  //Verificando conexion
  $sql->connection();

  if ($accion==1) {
    $vclase = substr($vnumclase,0,2); }

  //Validacion del Numero de Solicitud
  if ($accion==2) {
    if (!empty($vsol1) && !empty($vsol2)) { 
      $varsol=$vsol1."-".sprintf("%06d",$vsol2); } 
  else {
    mensajenew("Numero de Solicitud Vacio o con Error ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }
  }
      
  //Verificacion de que los campos requeridos esten llenos...
  $req_fields = array("fecha_solic","tipo_marca","modalidad","distingue");
  $valores = array($fecha_solic,$tipo_marca,$modalidad,$distingue);
  $vacios = check_empty_fields();
  if (!$vacios) { 
     mensajenew("Hay Informacion en el formulario que esta Vacia ...!!!","javascript:history.back();","N");
     $smarty->display('pie_pag.tpl'); exit(); }

  if ($accion==1) {
    $vclase = substr($vnumclase,0,2); }
    
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
       if ($vclase==48) {
           $vclatipo = 1; }
       break;
     case "C":
       if ($vclase>0 and $vclase<46) {
           $vclatipo = 1; }
       break;
  }       
  
  if ($vclatipo==0) {
    mensajenew("Clase Internacional de Niza no corresponde con el Tipo de Marca ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }

  $esmayor=compara_fechas($fecha_solic,$fechahoy);
  if ($esmayor==1) {
    mensajenew("La Fecha de Solicitud No puede ser mayor a la de Hoy ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }
 
   if ($tipo_marca!="L") {
     $vsol3='';
     $vsol4='';
     $vreg1d='';
     $vreg2d='';
   }
   
   if ($tipo_marca=="L") {
     $vsolema = $vsol3."-".$vsol4;
     $vreglema= $vreg1d.$vreg2d;

     if (($vsolema=="-") && empty($vreglema)) {
       mensajenew("La Solicitud por ser Lema necesita a que Marca sera aplicado ...!!!","javascript:history.back();","N");
       $smarty->display('pie_pag.tpl'); exit(); }
     
     if ($vsolema!='') {
       $resulm=pg_exec("select * from stmmarce where solicitud='$vsolema'"); }
     if ($vreglema!='') {
       $resulm=pg_exec("select * from stmmarce where registro='$vreglema'"); }
     $regm= pg_fetch_array($resulm);
     $nfil=pg_numrows($resulm);
     if ($nfil==0) {
       mensajenew("Solicitud o Registro NO existe en la Base de Datos ...!!!","javascript:history.back();","N");
       $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
   }

  //$annno= Obtener_anno($fecha_solic,0);
  //if ($dirano != $annno) { 
  //  Mensage_Error("Los Cuatros primeros digitos del Expediente no son iguales a los cuatros ultimos de su Fecha ...!!!");
  //  $smarty->display('pie_pag.tpl'); exit();  }
    
  if ($modalidad=="N") {
      mensajenew("No ha seleccionado la Modalidad ...!!!","javascript:history.back()","N");
      $smarty->display('pie_pag.tpl'); exit();
  }
    
  //Verificacion de que si existe la imagen en disco y ha sido descrita
  if (($modalidad=="G") || ($modalidad=="M")) {
   if (empty($etiqueta)) {
      mensajenew("Por ser Grafica o Mixta, necesita se describa la Etiqueta ...!!!","javascript:history.back()","N");
      $smarty->display('pie_pag.tpl'); exit(); }  
   $nameimage = imagen($vsol1,$vsol2);
   //if (!file_exists($nameimage)) {
   //   Mensage_Error("Imagen no ha sido Encontrada, debe ser Scaneada para proseguir con la modificacion ...!!!");
   //   $smarty->display('pie_pag.tpl'); exit(); }  
  }
      
  if ($modalidad=="G") { $nombre=""; }

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

  if (empty($input2)) { $vcodpais=""; 
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

  // Tabla de Fonetizacion 
  //$insert_str = "'$varsol'";
  //$sql->insert("$tbname_4","","$insert_str","");
  
  if ($accion==1) {
    // Ingreso de Solicitud

    if ($vnomagenew!='' || !empty($vnomagenew)) {
      $vcodage=$vnomagenew; }
      
    // Ubicacion del usuario
    $resultado=pg_exec("SELECT * FROM stzusuar WHERE usuario='$usuario'");
    if (!$resultado) { 
      mensajenew("Codigo de Usuario NO existe en la Base de Datos ...!!!","javascript:history.back();","N");
      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
    $filas_found=pg_numrows($resultado); 
    if ($filas_found==0) {
      mensajenew("No existen Datos asociados al Usuario ...!!!","javascript:history.back();","N");
      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 
    $regdep = pg_fetch_array($resultado);
    $vdepto=trim($regdep['cod_depto']);

    $resultado=pg_exec("SELECT * FROM stmevmar WHERE evento=200");
    if (!$resultado) { 
      mensajenew("Codigo de Evento NO existe en la Base de Datos ...!!!","javascript:history.back();","N");
      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
    $filas_found=pg_numrows($resultado); 
    if ($filas_found==0) {
      mensajenew("No existen Datos asociados al Evento ...!!!","javascript:history.back();","N");
      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 
    $regeve = pg_fetch_array($resultado);
    $vdes=trim($regeve['mensa_automatico']);
    $documento=0;
    $comentario="";

    //Se obtiene el proximo valor segun stzsystem
    pg_exec("BEGIN WORK");
    pg_exec("LOCK TABLE stzsystem IN SHARE ROW EXCLUSIVE MODE");
    $sys_actual = next_sys("msolicitud");
    $vnumero = grabar_sys("msolicitud",$sys_actual);
    pg_exec("COMMIT WORK");
    $vsol1=substr($vnumero,-10,4);
    $vsol2=substr($vnumero,-6,6);
    $varsol=$vsol1."-".$vsol2;
    $v1=substr($vnumero,-10,4);
    $auxnum = $auxnum."-";
    $dirano = $vsol1;

    $annno= Obtener_anno($fecha_solic,0);
    if ($vsol1 != $annno) { 
      mensajenew("Los Cuatros primeros digitos del Expediente no son iguales a los cuatros ultimos de su Fecha ...!!!","javascript:history.back();","N");
      $smarty->display('pie_pag.tpl'); exit();  }

    //Variable para la busqueda de la imagen
    $vnewnombre=$dirano.substr($varsol,-6,6); 
    $rutatmp = "/var/www/sistemas/imagenes/temp/";
    $ruta = "/var/www/sistemas/imagenes/marcas/ef".$dirano."/";

    //Copiar archivo de logotipo en ruta final
    if (($modalidad=="G") || ($modalidad=="M")) {
	   $max_size = 1024*100; // the max. size for uploading	
	   $my_upload = new file_upload;
	   //$my_upload->upload_dir = "/var/www/sistemas/imagenes/temp/"; // "files" is the folder for the uploaded files (you have to create this folder)
	   $my_upload->upload_dir = $ruta; // "files" is the folder for the uploaded files (you have to create this folder)
	   $my_upload->extensions = array(".jpg", ".jpge",".png"); // specify the allowed extensions here
	   $my_upload->max_length_filename = 50; // change this value to fit your field length in your database (standard 100)
	   $my_upload->rename_file = true;
	   $my_upload->the_temp_file = $_FILES['ubicacion']['tmp_name'];
	   $my_upload->the_file = $_FILES['ubicacion']['name'];
	   $my_upload->http_error = $_FILES['ubicacion']['error'];
	   $my_upload->validateExtension();
	   if ($my_upload->upload($vnewnombre)) { 
		  echo '';		
	   } 
	   else {
		  //Mensage_Error($my_upload->show_error_string());
        mensajenew($my_upload->show_error_string(),"javascript:history.back();","N");
        $smarty->display('pie_pag.tpl'); 
		  exit(); }
    }

    // Tabla de Batfon 
    //$insert_str = "'$varsol'";
    //$sql->insert("$tbname_9","","$insert_str","");
 
    // Tabla Maestra de Marcas
    pg_exec("BEGIN WORK");
    pg_exec("LOCK TABLE stmmarce IN SHARE ROW EXCLUSIVE MODE");
    $resulm=pg_exec("select * from stmmarce where solicitud='$varsol'");
    $regm= pg_fetch_array($resulm);
    $nfil=pg_numrows($resulm);
    if ($nfil>0) {
      mensajenew("Solicitud ya existe en la Base de Datos ...!!!","m_modregis.php?vopc=3","N");
      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

    if ($arraynompais!='' || empty($arraynompais)) {
      $resulpais = pg_exec("select * from stzpaisr where nombre='$arraynompais'");
      $regpais = pg_fetch_array($resulpais);
      $arraycodpais=$regpais[pais];
      $vnompais=$regpais[nombre];
      $vcodpais=$regpais[pais]; }
  
    $col_campos = "solicitud,fecha_solic,tipo_marca,nombre,clase,agente,estatus,poder,modalidad,ind_claseni,tramitante,pais_resid,ubicacion,usuario,edo_ubic";
    $vnom = str_replace("'","´",$nombre);
    $vtra = str_replace("'","´",$tramitante);

    $insert_str = "'$varsol','$fecha_solic','$tipo_marca','$vnom','$vclase','$vcodage',1,'$vpoder','$modalidad','I','$vtra','$vcodpais','$depto','$usuario',0";
    //echo "$insert_str";
    $sql->insert("$tbname_4","$col_campos","$insert_str","");

    //Se obtiene el proximo valor para el secuencial a guardar en stmevtrd a partir de stzsistem
    //pg_exec("BEGIN WORK");
    //pg_exec("LOCK TABLE stzsystem IN SHARE ROW EXCLUSIVE MODE");
    //$sys_actual = next_sys("msecuencial");
    //$vsecuencial = grabar_sys("msecuencial",$sys_actual);
    //pg_exec("COMMIT WORK");

    $horactual = Hora();
    // Tabla de Eventos de Tramite
    $col_campos = "solicitud,evento,fecha_event,secuencial,estat_ant,documento,fecha_trans,usuario,desc_evento,hora";
    $insert_str = "'$varsol',200,'$fecha_solic',nextval('stmevtrd_secuencial_seq'),0,0,'$fechahoy','$usuario','$vdes','$horactual'";
    $sql->insert("$tbname_5","$col_campos","$insert_str","");

    // Tabla de Lemas Asociados 
    if ($tipo_marca=="L") {
      $vsolema = $vsol3."-".$vsol4;
      $vreglema= $vreg1d.$vreg2d;

     if ($vsolema!='') {
       $col_campos = "solicitud,solicitud_aso"; 
       $insert_str = "'$varsol','$vsolema'";  }
     if ($vreglema!='') {
       $col_campos = "solicitud,registro_aso"; 
       $insert_str = "'$varsol','$vreglema'"; }
     $sql->insert("$tbname_14","$col_campos","$insert_str","");
    }

    // Tabla de Distingue
    $vdis = str_replace("'","´",$distingue);
    $insert_str = "'$varsol','$vdis'";
    $sql->insert("$tbname_6","","$insert_str","");
 
    // Tabla de Logos
    if (($modalidad=="G") || ($modalidad=="M")) {
      $vetq = str_replace("'","´",$etiqueta);
      $insert_str = "'$varsol','$vetq'";
      $sql->insert("$tbname_8","","$insert_str","");
    }  
    pg_exec("COMMIT WORK");

    // Tabla de Clasificaciones de Viena
    if (($modalidad=="G") || ($modalidad=="M")) {
      pg_exec("BEGIN WORK");
      pg_exec("LOCK TABLE temviena IN SHARE ROW EXCLUSIVE MODE");
      $res_viena=pg_exec("SELECT * FROM temviena where solicitud='$auxnum'");
      $filas_res_viena=pg_numrows($res_viena); 
      $regviena = pg_fetch_array($res_viena);
      for($i=0;$i<$filas_res_viena;$i++) 
      { 
        $resul=pg_exec("SELECT * FROM stmccvma where solicitud='$varsol' and ccv='$regviena[ccv]'");
        $filas_resul=pg_numrows($resul);
        if ($filas_resul==0) {
         $resultado=pg_exec("INSERT INTO stmccvma (solicitud,ccv) VALUES ('$varsol','$regviena[ccv]')"); }  
        $regviena = pg_fetch_array($res_viena);
      }
      pg_exec("COMMIT WORK");
    }

    // Tabla de Titulares
    pg_exec("BEGIN WORK");
    pg_exec("LOCK TABLE temptitu IN SHARE ROW EXCLUSIVE MODE");
    $res_titu=pg_exec("SELECT * FROM temptitu where solicitud='$auxnum'");
    $filas_res_titu=pg_numrows($res_titu); 
    $regtitu = pg_fetch_array($res_titu);
    for($i=0;$i<$filas_res_titu;$i++) 
    { 
     if ($regtitu[titular]=="0")
       {
          $res_cod=pg_exec("SELECT * FROM stztitur order by titular DESC");
          $regcod = pg_fetch_array($res_cod);
          $vtit=$regcod[titular];
          $vtit=$vtit+1;
          $resultado=pg_exec("INSERT INTO stztitur (titular,nombre,pais_resid) VALUES ('$vtit','$regtitu[nombre]','$regtitu[pais_resid]')");
          $resultado=pg_exec("INSERT INTO stmottid (solicitud,titular,nacionalidad,domicilio) VALUES ('$varsol','$vtit','$regtitu[nacionalidad]','$regtitu[domicilio]')");
       }
     else
       {
          $resul=pg_exec("SELECT * FROM stmottid where solicitud='$varsol' and titular='$regtitu[titular]'");
          $filas_resul=pg_numrows($resul);
          if ($filas_resul==0) {
             $resultado=pg_exec("INSERT INTO stmottid (solicitud,titular,nacionalidad,domicilio) VALUES ('$varsol','$regtitu[titular]','$regtitu[nacionalidad]','$regtitu[domicilio]')");
             }  
       }
     $regtitu = pg_fetch_array($res_titu);
    }
    pg_exec("COMMIT WORK");

  } //Incluir
  else {
    // Modificar Solicitud
    $varsol = sprintf("%02d-%06d",$vsol1,$vsol2);

    //Se obtiene el proximo valor para el secuencial a guardar en stzbitac a partir de stzsistem
    pg_exec("BEGIN WORK");
    pg_exec("LOCK TABLE stzsystem IN SHARE ROW EXCLUSIVE MODE");
    $sys_actual = next_sys("nbitaco");
    $vsecuencial = grabar_sys("nbitaco",$sys_actual);
    
    // Almaceno registro original en Bitacora
    $insert_str = "'$vsecuencial','$fechahoy','$horactual','$usuario','$tbname_4','M','M','$varsol','$vstring','$campos'";
    $sql->insert("$tbname_12","","$insert_str","");
    pg_exec("COMMIT WORK");

    //Se obtiene el proximo valor para el secuencial a guardar en stzbider a partir de stzsistem para distingue
    pg_exec("BEGIN WORK");
    pg_exec("LOCK TABLE stzsystem IN SHARE ROW EXCLUSIVE MODE");
    $sys_actual = next_sys("nbitaco");
    $vsecuencial = grabar_sys("nbitaco",$sys_actual);

    // Almaceno registro original en Bitacora stzbider
    $insert_str = "'$vsecuencial','$fechahoy','$horactual','$usuario','$tbname_6','M','M','$varsol','$vstring1'";
    $sql->insert("$tbname_13","","$insert_str","");
    pg_exec("COMMIT WORK");

    //Se obtiene el proximo valor para el secuencial a guardar en stzbider a partir de stzsistem para etiqueta
    if (($modalidad=="G") || ($modalidad=="M")) {
      pg_exec("BEGIN WORK");
      pg_exec("LOCK TABLE stzsystem IN SHARE ROW EXCLUSIVE MODE");
      $sys_actual = next_sys("nbitaco");
      $vsecuencial = grabar_sys("nbitaco",$sys_actual);
      // Almaceno registro original en Bitacora stzbider
      $insert_str = "'$vsecuencial','$fechahoy','$horactual','$usuario','$tbname_8','M','M','$varsol','$vstring2'";
      $sql->insert("$tbname_13","","$insert_str","");
      pg_exec("COMMIT WORK");
    }

    if ($modalidad=="D") {
      $sql->del("$tbname_8","solicitud='$varsol'"); }
    
    //Actualizacion del estatus del expediente en la maestra de marcas
    pg_exec("BEGIN WORK");
    pg_exec("LOCK TABLE stmmarce IN SHARE ROW EXCLUSIVE MODE");
    $nombre = str_replace("'","´",$nombre);
    $tramitante = str_replace("'","´",$tramitante);
    $update_str = "fecha_solic='$fecha_solic',tipo_marca='$tipo_marca',
                   nombre='$nombre',clase='$vclase',ind_claseni='I',modalidad='$modalidad',poder='$vpoder',
                   agente='$vcodage',tramitante='$tramitante',pais_resid='$vcodpais'";
    if (!empty($fecha_regis)) {
      $update_str = $update_str.",fecha_regis='$fecha_regis'";
    } 
    if (!empty($fecha_venc)) {
      $update_str = $update_str.",fecha_venc='$fecha_venc',";
    } 
    $sql->update("$tbname_4","$update_str","solicitud='$varsol'");
    
    // Tabla de Distingue
    pg_exec("LOCK TABLE stmdistd IN SHARE ROW EXCLUSIVE MODE");
    $vdis = str_replace("'","´",$distingue);
    $obj_query = $sql->query("SELECT * FROM $tbname_8 WHERE solicitud ='$varsol'");
    $obj_filas = $sql->nums('',$obj_query);
    if ($obj_filas==0) {
      $insert_str = "'$varsol','$vdis'";
      $sql->insert("$tbname_6","","$insert_str",""); }
    else {
      $update_str = "distingue= '$vdis'";
      $sql->update("$tbname_6","$update_str","solicitud='$varsol'"); }
    
    // Tabla de Prioridades
    if (!empty($vnprior)) {
      $insert_str = "'$varsol','$vnprior','$vpaisprior','$vfechaprior'";
      $sql->insert("$tbname_15","","$insert_str",""); }

    // Tabla de Logos
    if (($modalidad=="G") || ($modalidad=="M")) {
      $veti = str_replace("'","´",$etiqueta);
      $obj_query = $sql->query("SELECT * FROM $tbname_8 WHERE solicitud ='$varsol'");
      $obj_filas = $sql->nums('',$obj_query);
      pg_exec("LOCK TABLE stmlogos IN SHARE ROW EXCLUSIVE MODE");
      if ($obj_filas==0) {
        $insert_str = "'$varsol','$veti'";
        $sql->insert("$tbname_8","","$insert_str",""); }
      else {
        $update_str = "descripcion='$veti'";
        $sql->update("$tbname_8","$update_str","solicitud='$varsol'"); }
    }  

    //// Tabla de Logos
    //if (($modalidad=="G") || ($modalidad=="M")) {
    //  $etiqueta = str_replace("'","",$etiqueta);
    //  pg_exec("LOCK TABLE stmlogos IN SHARE ROW EXCLUSIVE MODE");
    //  if ($vexist==0) {
    //    $insert_str = "'$varsol','$etiqueta'";
    //    $sql->insert("$tbname_8","","$insert_str",""); }
    //  else {
    //    $update_str = "descripcion='$etiqueta'";
    //    $sql->update("$tbname_8","$update_str","solicitud='$varsol'"); }
    //}  

    // Tabla de Batfon 
    $insert_str = "'$varsol'";
    $sql->insert("$tbname_9","","$insert_str","");
    
    // Tabla de Titulares
    pg_exec("LOCK TABLE temptitu IN SHARE ROW EXCLUSIVE MODE");
    $res_titu=pg_exec("SELECT * FROM temptitu where solicitud='$varsol'");
    $filas_res_titu=pg_numrows($res_titu);
    if ($filas_res_titu==0) {
      Mensage_Error("Solicitud No tiene ningun titular asociado ...!!!");
      $smarty->display('pie_pag.tpl'); exit(); }
    
    $sql->del("stmottid","solicitud='$varsol'");
    $regtitu = pg_fetch_array($res_titu);
    for($i=0;$i<$filas_res_titu;$i++) 
    { 
     if ($regtitu[titular]=="0")
       {
          $res_cod=pg_exec("SELECT * FROM stztitur order by titular DESC");
          $regcod = pg_fetch_array($res_cod);
          $vtit=$regcod[titular];
          $vtit=$vtit+1;
          $resultado=pg_exec("INSERT INTO stztitur (titular,nombre,pais_resid) VALUES ('$vtit','$regtitu[nombre]','$regtitu[pais_resid]')");
          $resultado=pg_exec("INSERT INTO stmottid (solicitud,titular,nacionalidad,domicilio) VALUES ('$varsol','$vtit','$regtitu[nacionalidad]','$regtitu[domicilio]')");
       }
     else
       {
          $resul=pg_exec("SELECT * FROM stmottid where solicitud='$varsol' and titular='$regtitu[titular]'");
          $filas_resul=pg_numrows($resul);
          if ($filas_resul==0) {
             echo " ingresando titular de nuevo $regtitu[titular] ";
             $resultado=pg_exec("INSERT INTO stmottid (solicitud,titular,nacionalidad,domicilio) VALUES ('$varsol','$regtitu[titular]','$regtitu[nacionalidad]','$regtitu[domicilio]')");
             }  
       }
     $regtitu = pg_fetch_array($res_titu);
    }
    pg_exec("COMMIT WORK");

    // Tabla de Clasificacion de Viena
    if (($modalidad=="G") || ($modalidad=="M")) {
      pg_exec("BEGIN WORK");
      pg_exec("LOCK TABLE temviena IN SHARE ROW EXCLUSIVE MODE");
      $res_viena=pg_exec("SELECT * FROM temviena where solicitud='$varsol'");
      $filas_res_viena=pg_numrows($res_viena);
      //if ($filas_res_viena==0) {
      //  mensajenew("Solicitud No tiene ninguna clasificacion asociada ...!!!","javascript:history.back();","N");
      //  $smarty->display('pie_pag.tpl'); exit(); }
    
      $sql->del("stmccvma","solicitud='$varsol'");
      $regviena = pg_fetch_array($res_viena);
      for($i=0;$i<$filas_res_viena;$i++) { 
        $resul=pg_exec("SELECT * FROM stmccvma where solicitud='$varsol' and ccv='$regviena[ccv]'");
        $filas_resul=pg_numrows($resul);
        if ($filas_resul==0) {
          $resultado=pg_exec("INSERT INTO stmccvma (solicitud,ccv) VALUES ('$varsol','$regviena[ccv]')"); }  
       $regviena = pg_fetch_array($res_viena);
      }
      pg_exec("COMMIT WORK");
    }  

  } // Modificar

  //Desconexion de la Base de Datos
  $sql->disconnect();

   if ($accion==1) {
    Mensaje2("DATOS GUARDADOS CORRECTAMENTE !!!","m_mdsolerr.php?vopc=3","m_genera.php?vnum=$vnumero");
    $smarty->display('pie_pag.tpl'); exit(); }
  else {
    mensajenew('DATOS GUARDADOS CORRECTAMENTE !!!','m_mdsolerr.php?vopc=4','S');
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

if ($vopc==3) {
  $smarty->assign('subtitulo','Mantenimiento de Expediente / Ingreso'); 
  $smarty->assign('varfocus','formarcas2.fecha_solic');
  $smarty->assign('vmodo','readonly=readonly'); 
  $smarty->assign('submitbutton','button');
  $smarty->assign('submitbutton3','submit');
  $smarty->assign('modo1','disabled'); 
  $smarty->assign('modo',''); 
  $smarty->assign('psoli',$vsol); 
  $smarty->assign('modo2',''); 
  $smarty->assign('modo3',''); 
  $smarty->assign('accion',1);

  $tnumera='secuencial';
  //Se obtiene el proximo valor segun stzsystem
  $sys_actual = next_sys("$tnumera");
  $vauxnum = grabar_sys("$tnumera",$sys_actual);
  $smarty->assign('auxnum',$vauxnum);
  $smarty->assign('psoli',$vauxnum.'-'); 
  //La Fecha de Hoy para la solicitud
  $fecha_solic = hoy();
  $nameimage="imagenes/SAPI_Logo.jpg";
  $smarty->assign('nameimage',$nameimage);
}

if ($vopc==4) {
  $smarty->assign('subtitulo','Mantenimiento de Expediente / Modificacion'); 
  $smarty->assign('varfocus','formarcas1.vreg1'); 
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
$smarty->assign('campo1','Registro No.:');
$smarty->assign('campo2','Fecha Expediente:');
$smarty->assign('campo3','Tipo de Marca:');
$smarty->assign('campo4','Nombre:');
$smarty->assign('campo5','Clase Internacional:');
$smarty->assign('campo6','Modalidad:');
$smarty->assign('campo7','&nbsp;&nbsp;Pais de Residencia:');
$smarty->assign('campo8','Distingue:');
$smarty->assign('campo9','Descripcion Etiqueta:');
$smarty->assign('campo10','Titular(es):');
$smarty->assign('campo11','Poder:');
$smarty->assign('campo12','Agente:');
$smarty->assign('campo13','Tramitante:');
$smarty->assign('campo14','Clasificacion de Viena:');
$smarty->assign('campo15','Logotipo:');
$smarty->assign('campo16','Lema Aplicado a:');
$smarty->assign('campo17','Prioridad:');

if ($vopc==1) {
  $smarty->assign('varfocus','formarcas2.fecha_solic');
  $smarty->assign('submitbutton','button');
  $smarty->assign('modalidad','N'); 
  $smarty->assign('tipo_marca','V');
  $smarty->assign('modalidad',$modalidad);
  $smarty->assign('tipo_marca',$tipo_marca);
 }

if ($vopc==2) {
  $smarty->assign('varfocus','formarcas1.vreg1'); 
  $smarty->assign('modo',''); 
  $smarty->assign('psoli',$vsol); 
  $smarty->assign('submitbutton','submit');
  $smarty->assign('modalidad',$modalidad);
  $smarty->assign('tipo_marca',$tipo_marca); }

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
$smarty->assign('vopc',$vopc);
$smarty->assign('n_solic',$varsol);
$smarty->assign('registro1',$vreg1);
$smarty->assign('registro2',$vreg2);
$smarty->assign('fecha_regis',$fecha_regis);
$smarty->assign('fecha_venc',$fecha_venc);

$smarty->display('m_mdsolerr.tpl');
$smarty->display('pie_pag.tpl');
?>
