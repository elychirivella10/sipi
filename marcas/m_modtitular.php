<script language="Javascript"> 

function pregunta() { 
  return confirm('Estas seguro de grabar la Informacion ?'); }

function browsetitularp(var1,var2,var3,var4) {
  this.derecho='M';
  open("../comun/adm_solotitular.php?vsol="+var1.value+"-"+var2.value+"&vtex="+var3.value+"&vmod="+var4.value+"&vtip="+this.derecho,"Ventana", "scrollbars=yes,toolbar=no,directories=no,menubar=no,status=no"); }

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
// *************************************************************************************
// Programa: m_modtitular.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MPPCN
// Desarrollado Año: 2019
// Modificado Año 2019 II Semestre BD - Relacional 
// *************************************************************************************

//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");
//Clase que sube un archivo de imagen
include ("$include_lib/upload_class.php"); 

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variables
$usuario = trim($_SESSION['usuario_login']);
$role    = $_SESSION['usuario_rol'];
$sql     = new mod_db();
$fecha   = fechahoy();
$modulo  = "m_modtitular.php";

$tbname_1  = "stzpaisr";
$tbname_3  = "stzsolic";  
$tbname_4  = "stmmarce";
$tbname_5  = "stzevtrd";
$tbname_6  = "stzderec";
$tbname_7  = "stzottid";
$tbname_9  = "stztmptit";
$tbname_10 = "stzusuar";
$tbname_12 = "stzbitac";
$tbname_13 = "stzbider";

$vopc     = $_GET['vopc'];
$vuser    = $_GET['vuser'];
$vaccion  = $_GET['vaccion'];
$vauxnum  = $_GET['vauxnum'];
$depto_id = $_GET['vdepto'];

$vsol1 = $_POST['vsol1'];
$vsol2 = $_POST['vsol2'];
$vreg1 = $_POST['vreg1'];
$vreg2 = $_POST['vreg2'];
$vsol  = $_POST['vsol'];
$vreg  = $_POST['vreg'];
$psoli = $_POST['psoli'];

$modalidad=$_POST['modalidad'];
$fecha_solic=$_POST['fecha_solic'];
$fecha_regis=$_POST['fecha_regis'];
$fecha_venc=$_POST['fecha_venc'];
$tipo_marca=$_POST['tipo_marca'];
$nombre=$_POST['nombre'];
$clase_id=$_POST['clase_id'];
$vclase=$_POST['vclase'];
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
$input1=$_POST['input1'];
$input2=$_POST['input2'];
$vsol3=$_POST['vsol3'];
$vsol4=$_POST['vsol4'];
$vreg1d=$_POST['vreg1d'];
$vreg2d=$_POST['vreg2d'];
$vder = $_POST['vder'];

// ************************************************************************************  
$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Modificaci&oacute;n de Titular Solicitud/Registros'); 
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

if (($usuario=='ipacheco') || ($usuario=='fobando') || ($usuario=='dadiaz') || ($usuario=='jamaranto') || ($usuario=='ngonzalez') || ($usuario=='rmendoza')) { }
else {
  Mensajenew("ERROR: Usuario NO tiene Permiso para este modulo ...!!!","../index1.php","N");
  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();
}

$smarty->assign('arraytipom',array(V,M,N,L,S,C,D));
$smarty->assign('arraynotip',array('','MARCA DE PRODUCTO','NOMBRE COMERCIAL','LEMA COMERCIAL','MARCA DE SERVICIO','MARCA COLECTIVA','DENOMINACION DE ORIGEN'));
$smarty->assign('arrayvclase',array(V,I,N));
$smarty->assign('arraytclase',array('','INTERNACIONAL','NACIONAL'));
$smarty->assign('arrayvmodal',array(N,D,G,M));
$smarty->assign('arraytmodal',array('','DENOMINATIVA','GRAFICA','MIXTA'));

// ************************************************************************************  
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

// ************************************************************************************  
//Opcion Modificar
if ($vopc==1) {
  $smarty->assign('modo1','disabled'); 
  $smarty->assign('vmodo',''); 
  $smarty->assign('modo',''); 
  $smarty->assign('modo2',''); 
  $smarty->assign('modo3','disabled'); 
  $smarty->assign('submitbutton3','submit');
  $smarty->assign('submitbutton','button');
  $smarty->assign('accion',2);
  $fechahoy = hoy();
  
  //Armado del Numero de Expediente
  $varreg=$vreg1.$vreg2;
  $varsol=$vsol1."-".sprintf("%06d",$vsol2);
  $dirano=$vsol1;
  //Variable Numero del Expediente
  $numero=substr($varsol,-6,6);
  
  //Verificando conexion
  $sql->connection($usuario);
  
  if (!empty($varreg)) {
     $resultado=pg_exec("SELECT * FROM $tbname_6 WHERE registro='$varreg' AND tipo_mp='M'"); }
  else {
     $resultado=pg_exec("SELECT * FROM $tbname_6 WHERE solicitud='$varsol' AND tipo_mp='M'"); }

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

  $vder    = $reg['nro_derecho'];  
  $vsol    = $reg['solicitud'];
  $varsol  = $vsol; 
  $psoli   = $reg['solicitud'];
  $smarty->assign('psoli',$psoli); 
  $vsol1   = substr($vsol,-11,4);
  $vsol2   = substr($vsol,-6,6);
  $registro= $reg['registro'];
  $vreg1   = substr(trim($registro),-7,1);
  $vreg2   = substr(trim($registro),-6,6);
  $estatus = $reg['estatus'];

  $nombre=trim($reg['nombre']);
  $nombre = str_replace("'","´",$nombre);
  $tipo_marca=$reg['tipo_derecho'];
  $fecha_solic=$reg['fecha_solic'];
  $fecha_regis=$reg['fecha_regis'];
  $fecha_venc=$reg['fecha_venc'];

  $distingue='';
  //Obtención de datos de la Marca 
  $obj_query = $sql->query("SELECT * FROM $tbname_4 WHERE nro_derecho='$vder'");
  $objs = $sql->objects('',$obj_query);
  $modalidad = $objs->modalidad;
  $vclase    = $objs->clase;
  $clase_id  = $objs->ind_claseni;
  $distingue = trim($objs->distingue);
  $smarty->assign('vstring1',$distingue);

  //Almaceno en un string los valores de los campos antes de modificar alguno
  $pais_resid = $vcodpais;
  if (!empty($vcodagenew)) { $agen_id = $vcodagenew; }
  $valores_fields = array($nombre,$fecha_solic,$fecha_regis,$fecha_venc,$tipo_marca,$vclase,$clase_id,$modalidad,$agen_id,$vpoder,$tramitante,$pais_resid);
  $campos = "nombre|fecha_solic|fecha_regis|fecha_venc|tipo_marca|clase|ind_claseni|modalidad|agente|poder|tramitante|pais_resid";
  $vstring = bitacora_fields();
  $smarty->assign('vstring',$vstring);
  $smarty->assign('campos',$campos);

  if ($modalidad=="D") {
    $nameimage="../imagenes/sin_imagen8.png"; }
  else {   $nameimage = "../graficos/marcas/ef".$vsol1."/".$vsol1.$vsol2.".jpg"; }

  if (!file_exists($nameimage)) {
    $nameimage="../imagenes/sin_imagen8.png"; }

  $smarty->assign('ubicacion',$nameimage);
 
  $auxnum = $vsol1;
  $smarty->assign('auxnum',$auxnum);

  // Obtencion del o los Titular(es)  
  $sql->del("$tbname_9","solicitud='$varsol'");
  $obj_query = $sql->query("SELECT stzottid.titular,stzsolic.identificacion,stzsolic.nombre,stzsolic.indole,stzsolic.telefono1,stzsolic.telefono2,stzsolic.fax,stzsolic.email,stzsolic.email2, stzottid.domicilio,stzottid.nacionalidad,stzottid.pais_domicilio 
                            FROM stzottid,stzsolic WHERE stzottid.nro_derecho ='$vder' AND  
                                 stzottid.titular=stzsolic.titular");
  $obj_filas = $sql->nums('',$obj_query);
  $objs = $sql->objects('',$obj_query);
  for ($contobj=0;$contobj<$obj_filas;$contobj++) {
     $vcod = $objs->titular;
     $vide = $objs->identificacion;
     $nomb = trim($objs->nombre);
     $nomb = str_replace("'","´",$nomb);
     $domi = trim($objs->domicilio);
     $domi = str_replace("'","´",$domi);
     $pais = $objs->nacionalidad;
     $pdomi = $objs->pais_domicilio;
     $indo = $objs->indole;
     $tlf1 = $objs->telefono1;
     $tlf2 = $objs->telefono2;
     $vfax = $objs->fax;
     $mail1= trim($objs->email);
     $mail2= trim($objs->email2);
     if (empty($indo)) { $indo = "P"; }  
     $col_campos = "solicitud,titular,identificacion,nombre,domicilio,pais_domicilio,nacionalidad,indole,telefono1,telefono2,fax,email,email2,tipo_mp,fecha_carga";
     $insert_str = "'$varsol','$vcod','$vide','$nomb','$domi','$pdomi','$pais','$indo','$tlf1','$tlf1','$vfax','$mail1','$mail2','M','$fechahoy'"; 
     $sql->insert("$tbname_9","$col_campos","$insert_str","");
  $objs = $sql->objects('',$obj_query); }	  

  // Obtencion de la Cronologia  
  $obj_query = $sql->query("SELECT * FROM stzevtrd WHERE nro_derecho='$vder' order by fecha_event,secuencial");
  $filas_found=$sql->nums('',$obj_query);
  $objs = $sql->objects('',$obj_query);
  for($cont=0;$cont<$filas_found;$cont++) { 
     $data[$cont][0]=$objs->fecha_event;
     $data[$cont][1]=$objs->evento-1000;
     $data[$cont][2]=$objs->desc_evento;
     $data[$cont][3]=$objs->fecha_trans;
     $data[$cont][4]=$objs->documento;
     $data[$cont][5]=trim($objs->comentario);
     $objs = $sql->objects('',$obj_query); 
  }
  $smarty->assign('custid',$data); 

}

// ************************************************************************************  
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
    mensajenew("Numero de Solicitud Vacio o con Error ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }
  }

  $dirano=$vsol1;
  $esmayor=compara_fechas($fecha_solic,$fechahoy);
  if ($esmayor==1) {
    mensajenew("La Fecha de Solicitud No puede ser mayor a la de Hoy ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }

  $annno= Obtener_anno($fecha_solic,0);
  if ($dirano != $annno) { 
    //Mensage_Error("Los Cuatros primeros digitos del Expediente no son iguales a los cuatros ultimos de su Fecha ...!!!");
    Mensajenew("Los Cuatros primeros digitos del Expediente no son iguales a los cuatros ultimos de su Fecha ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit();  }
      
  //Verificacion de que los campos requeridos esten llenos...
  $req_fields = array("fecha_solic","tipo_marca","modalidad");
  $valores = array($fecha_solic,$tipo_marca,$modalidad);
  $vacios = check_empty_fields();
  if (!$vacios) { 
     mensajenew("Hay Informacion en el formulario que esta Vacia ...!!!","javascript:history.back();","N");
     $smarty->display('pie_pag.tpl'); exit(); }

  // Verificacion de Clase y Tipo de Marca en funcion del indicador
  $vclatipo = 0;
  if ($clase_id=="I") {
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
       if ($vclase>0 and $vclase<=46) {
           $vclatipo = 1; }
       break;
    }       
    if ($vclatipo==0) {
      mensajenew("Clase Internacional de Niza NO corresponde con el Tipo de Marca ...!!!","javascript:history.back();","N");
      $smarty->display('pie_pag.tpl'); exit(); }
  }

  if ($clase_id=="N") {
    switch ($tipo_marca) {
     case "M":
       if ($vclase>0 and $vclase<=50) {
           $vclatipo = 1; }
       break;
     case "S":
       if ($vclase==50) { 
           $vclatipo = 1; }
       break;
     case "N":
       if ($vclase==50) { 
           $vclatipo = 1; }
       break;
     case "L":
       if ($vclase==50) { 
           $vclatipo = 1; }
       break;
     case "D":
       if ($vclase==50) {  
           $vclatipo = 1; }
       break;
     case "C":
       if ($vclase>0 and $vclase<=50) { 
           $vclatipo = 1; }
       break;
    }       
    if ($vclatipo==0) {
      mensajenew("Clase Nacional NO corresponde con el Tipo de Marca ...!!!","javascript:history.back();","N");
      $smarty->display('pie_pag.tpl'); exit(); }
  }
    
  if ($modalidad=="N") {
      mensajenew("No ha seleccionado la Modalidad ...!!!","javascript:history.back()","N");
      $smarty->display('pie_pag.tpl'); exit();
  }

  $restitu=pg_exec("SELECT * FROM $tbname_9 where solicitud='$varsol'");
  $filas_titular=pg_numrows($restitu); 
  if ($filas_titular==0) {
    mensajenew("Expediente $varsol sin ningun Titular asociado ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); 
  }

  if ($modalidad=="G") { $nombre=""; }

  if ($accion==1) {
  } //Incluir
  else {
    // Modificar Solicitud
    $varsol = sprintf("%02d-%06d",$vsol1,$vsol2);

    pg_exec("BEGIN WORK");
    $insfon   = true; 
    $inslema  = true;
    $insagen  = true;
    $insccv   = true;
    $inslogo  = true;
    $insprio  = true;
    $insfon   = true; 
    $updmarce = true;
    $updderecho = true; 

    //Actualizacion de la maestra principal 
    pg_exec("LOCK TABLE stzderec IN SHARE ROW EXCLUSIVE MODE");
    $nombre = str_replace("'","´",$nombre);
    $nombre = stripslashes($nombre);
    $update_str = "fecha_solic='$fecha_solic',tipo_derecho='$tipo_marca',nombre='$nombre'";

    if (!empty($fecha_regis)) {
      $update_str = $update_str.",fecha_regis='$fecha_regis'";
    }
    if (!empty($fecha_venc)) {
      $update_str = $update_str.",fecha_venc='$fecha_venc'";
    }
    $updderecho = $sql->update("$tbname_6","$update_str","nro_derecho='$vder'");

    pg_exec("LOCK TABLE stmmarce IN SHARE ROW EXCLUSIVE MODE");
    $update_str = "clase=$vclase,ind_claseni='$clase_id',modalidad='$modalidad'";
    $updmarce = $sql->update("$tbname_4","$update_str","nro_derecho='$vder'");

    $numtitu = 0; 
    //Verificacion de si tiene Cesion o Fusion o Cambio de Titular 
    $reg_tit=pg_exec("SELECT * FROM $tbname_5 WHERE nro_derecho='$vder' AND evento IN (1204,1205,1206,1208,1209)");
    $filas_reg_eve=pg_numrows($reg_tit);
    $filas_reg_eve=0; 
    if ($filas_reg_eve==0) {
      // Tabla de Solicitantes o Titulares 
      $res_titu=pg_exec("SELECT * FROM $tbname_9 where solicitud='$varsol' AND tipo_mp='M'");
      $filas_res_titu=pg_numrows($res_titu); 
      $regtitu = pg_fetch_array($res_titu);

      $ins_solic = true;
      $ins_titur = true; 
      $del_datos = $sql->del("$tbname_7","nro_derecho='$vder'");
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

           $col_campos = "nro_derecho,titular,nacionalidad,domicilio,pais_domicilio";
           $vdom = str_replace("'","´",$regtitu[domicilio]);
           $insert_str = "'$vder','$act_titular','$regtitu[nacionalidad]','$vdom','$regtitu[pais_domicilio]'";
           $ins_titur = $sql->insert("$tbname_7","$col_campos","$insert_str","");
           if ($ins_solic AND $ins_titur) { }
           else { $numtitu = $numtitu + 1; }  
         }
       else
         {
           $obj_query = $sql->query("SELECT * FROM $tbname_7 where nro_derecho='$vder' AND titular='$regtitu[titular]'");
           if (!$obj_query) { 
             Mensajenew("Problema al intentar realizar la consulta en la tabla $tbname_7 ...!!!","javascript:history.back();","N");
             $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
           $filas_titular=$sql->nums('',$obj_query);
           if ($filas_titular==0) {
             $col_campos = "nro_derecho,titular,nacionalidad,domicilio,pais_domicilio";
             $insert_str = "'$vder','$regtitu[titular]','$regtitu[nacionalidad]','$regtitu[domicilio]','$regtitu[pais_domicilio]'";
             $ins_titur = $sql->insert("$tbname_7","$col_campos","$insert_str","");
             if ($ins_titur) { }
             else { $numtitu = $numtitu + 1; }
             
             $vide   = $regtitu[identificacion];
             $vnom   = str_replace("'","´",$regtitu[nombre]);
             $vind   = $regtitu[indole];
             $vtlf1  = $regtitu[telefono1];
             $vtlf2  = $regtitu[telefono2];
             $vfax   = $regtitu[fax];
             $vmail1 = $regtitu[email];
             $vmail2 = $regtitu[emai2];

             $vcodl = substr($vide,0,1);
             $vcod  = substr($vide,1);
             if ($vcod=='000000000') { $vide=''; } 
             $update_str1 = "identificacion='$vide',nombre='$vnom',indole='$vind',telefono1='$vtlf1',telefono2='$vtlf2',fax='$vfax',email='$vmail1',email2='$vmail2'"; 
             $acttitu1 = $sql->update("$tbname_3","$update_str1","titular='$regtitu[titular]'");
             if ($acttitu1) { }
             else { $numtitu = $numtitu + 1; }  
           } 
         }
       $regtitu = pg_fetch_array($res_titu);
      }
    } else {
      // Tabla de Solicitantes o Titulares para actualizar sus datos, nada mas si coincide el codigo de titular 
      $res_titu=pg_exec("SELECT * FROM $tbname_9 where solicitud='$varsol' AND tipo_mp='M'");
      $filas_res_titu=pg_numrows($res_titu); 
      $regtitu = pg_fetch_array($res_titu);

      $ins_solic = true;
      $ins_titur = true; 
      for($i=0;$i<$filas_res_titu;$i++) 
      { 
        $vtit   = $regtitu[titular];
        $vide   = $regtitu[identificacion];
        $vnom   = str_replace("'","´",$regtitu[nombre]);
        $vdom   = str_replace("'","´",$regtitu[domicilio]);
        $vnac   = $regtitu[nacionalidad];
        $vind   = $regtitu[indole];
        $vtlf1  = $regtitu[telefono1];
        $vtlf2  = $regtitu[telefono2];
        $vfax   = $regtitu[fax];
        $vmail1 = $regtitu[email];
        $vmail2 = $regtitu[emai2];
        $vpdo   = $regtitu[pais_domicilio];

        $vcodl = substr($vide,0,1);
        $vcod  = substr($vide,1);
        if ($vcod=='000000000') { $vide=''; } 

        $obj_query = $sql->query("SELECT * FROM $tbname_7 WHERE nro_derecho='$vder' AND titular='$vtit'"); 
        if (!$obj_query) { 
          Mensajenew("Problema al intentar realizar la consulta en la tabla $tbname_7 ...!!!","javascript:history.back();","N");
          $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
        $filas_titular=$sql->nums('',$obj_query);
        if ($filas_titular!=0) { 
          $update_str1 = "identificacion='$vide',nombre='$vnom',indole='$vind',telefono1='$vtlf1',telefono2='$vtlf2',fax='$vfax',email='$vmail1',email2='$vmail2'"; 
          $acttitu1 = $sql->update("$tbname_3","$update_str1","titular='$vtit'");
          if ($acttitu1) { }
             else { $numtitu = $numtitu + 1; }  
          $update_str2 = "domicilio='$vdom',nacionalidad='$vnac',pais_domicilio='$vpdo'";         
          $acttitu2 = $sql->update("$tbname_7","$update_str2","titular='$vtit' AND nro_derecho='$vder'");
          if ($acttitu2) { }
             else { $numtitu = $numtitu + 1; }  
        } 
        $regtitu = pg_fetch_array($res_titu);
      }
    }
    $del_datos = $sql->del("$tbname_9","solicitud='$varsol' AND tipo_mp='M'");
    
    if ($numtitu==0 AND $updmarce AND $updderecho) {
      pg_exec("COMMIT WORK");
      //Desconexion de la Base de Datos
      $sql->disconnect();

      Mensajenew("DATOS GUARDADOS CORRECTAMENTE ...!!!","m_modtitular.php?vopc=4","S");
      $smarty->display('pie_pag.tpl'); exit();
    } 
    else {
      pg_exec("ROLLBACK WORK");
      //Desconexion de la Base de Datos
      $sql->disconnect();

      if (!$updmarce)   { $error_mar = " - Marcas "; }
      if (!$updderecho) { $error_der = " - Derecho "; }
      if ($numtitu!=0)  { $error_tit = " - Titular(es) "; }
            
      Mensajenew("Falla de Actualizaci&oacute;n de Datos en la BD $error_mar, $error_der, $error_tit ...!!!","javascript:history.back();","N");
      $smarty->display('pie_pag.tpl'); exit();
    }

  } // Modificar
}

// ************************************************************************************  
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

// ************************************************************************************  
if ($vopc==4) {
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
  $nameimage="../imagenes/sin_imagen8.png";
}

// ************************************************************************************  
if ($vopc==1) {
  $smarty->assign('varfocus','formarcas2.fecha_solic');
  $smarty->assign('submitbutton','button');
  $smarty->assign('modalidad','N'); 
  $smarty->assign('tipo_marca','V');
  $smarty->assign('modalidad',$modalidad);
  $smarty->assign('tipo_marca',$tipo_marca);
 }

// ************************************************************************************  
if ($vopc==2) {
  $smarty->assign('varfocus','formarcas1.vreg1'); 
  $smarty->assign('modo',''); 
  $smarty->assign('psoli',$vsol); 
  $smarty->assign('submitbutton','submit');
  $smarty->assign('modalidad',$modalidad);
  $smarty->assign('tipo_marca',$tipo_marca); }

// ************************************************************************************  
//Pase de variables y Etiquetas al template
$smarty->assign('campo1','Registro No.:');
$smarty->assign('campo2','Fecha Expediente:');
$smarty->assign('campo3','Tipo de Marca:');
$smarty->assign('campo4','Nombre:');
$smarty->assign('campo5','Clase:');
$smarty->assign('campo6','Modalidad:');
$smarty->assign('campo7','&nbsp;&nbsp;Pais de Residencia:');
$smarty->assign('campo10','Actualizaci&oacute;n de Titular(es):');

$smarty->assign('vder',$vder);
$smarty->assign('usuario',$usuario);
$smarty->assign('depto_id',$depto_id);
$smarty->assign('role',$role);
$smarty->assign('arraycodpais',$arraycodpais);
$smarty->assign('arraynompais',$arraynompais);
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
$smarty->assign('pais_resid',$pais_resid);
$smarty->assign('vcodpais',$vcodpais);
$smarty->assign('fecha_solic',$fecha_solic);
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

$smarty->display('m_modtitular.tpl');
$smarty->display('pie_pag.tpl');
?>
