<script language="Javascript"> 

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
// Programa: m_reingres.php  
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinaci??n de Inform??tica / Direcci??n de Soporte Administrativo / SAPI / MILCO
// A??o: 2006
// Modificado A??o 2009 BD - Relacional 
// *************************************************************************************
 
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");
//Clase que sube un archivo de imagen
include ("$include_lib/upload_class.php"); 

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variables
$usuario = $_SESSION['usuario_login'];
$role    = $_SESSION['usuario_rol'];
$sql     = new mod_db();
$fecha   = fechahoy();

$tbname_1  = "stzpaisr";
$tbname_2  = "stzagenr";
$tbname_3  = "stzsolic";  
$tbname_4  = "stmmarce";
$tbname_5  = "stzevtrd";
$tbname_6  = "stzderec";
$tbname_7  = "stzottid";
$tbname_8  = "stmlogos";
$tbname_9  = "stztmptit";
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
$tbname_20 = "stmviena";
$tbname_21 = "stmbatfon";
$tbname_22 = "stmclnac";

$vopc    =$_GET['vopc'];
$vuser   =$_GET['vuser'];
$vaccion =$_GET['vaccion'];
$vauxnum =$_GET['vauxnum'];
$depto_id=$_GET['vdepto'];
$vsol1   =$_POST['vsol1'];
$vsol2   =$_POST['vsol2'];
$vsol    =$_POST['vsol'];
$psoli   =$_POST['psoli'];

$modalidad=$_POST['modalidad'];
$fecha_solic=$_POST['fecha_solic'];
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
$vder = $_POST['vder'];
$vclnac  = $_POST['vclnac'];

// ******************************************************************************************
$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Reingreso de Expediente'); 
if (($vopc==5) || ($vopc==6)){
  $smarty->assign('subtitulo','Reingreso de Expediente'); }
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

$smarty->assign('arraytipom',array(V,M,N,L,S,C,D));
$smarty->assign('arraynotip',array('','MARCA DE PRODUCTO','NOMBRE COMERCIAL','LEMA COMERCIAL','MARCA DE SERVICIO','MARCA COLECTIVA','DENOMINACION DE ORIGEN'));
$smarty->assign('arrayvclase',array(I,N));
$smarty->assign('arraytclase',array('INTERNACIONAL','NACIONAL'));
$smarty->assign('arrayvmodal',array(N,D,G,M));
$smarty->assign('arraytmodal',array('','DENOMINATIVA','GRAFICA','MIXTA'));

if (($vopc==1) || ($vopc==3) || ($vopc==6)) {
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

//Opcion Modificar
if (($vopc==1) || ($vopc==6)) {
  $smarty->assign('modo1','disabled'); 
  $smarty->assign('vmodo',''); 
  $smarty->assign('modo',''); 
  $smarty->assign('modo2',''); 
  $smarty->assign('modo3','disabled'); 
  $smarty->assign('submitbutton3','submit');
  $smarty->assign('submitbutton','button');
  if ($vopc==6){
     $smarty->assign('subtitulo','Reingreso de Expediente'); }
  $smarty->assign('accion',2);

  //Validacion del Numero de Solicitud
  if (empty($vsol1) && empty($vsol2)) {
     mensajenew("No introdujo ningn valor de Expediente ...!!!","javascript:history.back();","N");
     $smarty->display('pie_pag.tpl'); exit(); }

  //Armado del Numero de Expediente
  $varsol=$vsol1."-".sprintf("%06d",$vsol2);
  $dirano=$vsol1;
  //Variable Numero del Expediente
  $numero=substr($varsol,-6,6);
  
  //Verificando conexion
  $sql->connection($usuario);
  
  $resultado=pg_exec("SELECT * FROM $tbname_6 WHERE solicitud='$varsol' AND solicitud!='' AND tipo_mp='M'");
  if (!$resultado) { 
     Mensajenew("ERROR: PROBLEMA AL PROCESAR LA BUSQUEDA ...!!!","javascript:history.back();","N");
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  }	 
  $filas_found=pg_numrows($resultado); 
  if ($filas_found==0) {
     Mensajenew("ERROR: NO EXISTEN DATOS ASOCIADOS ...!!!","javascript:history.back();","N");
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  }	 
  $reg = pg_fetch_array($resultado);

  $vder    = $reg[nro_derecho];  
  $vsol    = $reg[solicitud];
  $vsol1   = substr($vsol,-11,4);
  $vsol2   = substr($vsol,-6,6);
  $varsol  = $vsol; 
  $psoli   = $reg[solicitud];
  $smarty->assign('psoli',$psoli); 
  $estatus = $reg[estatus];

  if ($estatus!=1113 && $estatus!=1118 && $estatus!=1115 && $estatus!=1200) {
    mensajenew("Solo se puede Reingresar Expedientes en Estatus 113, 118, 115 o 200!!!","m_reingres.php?vopc=5&vaccion=2&vauxnum=0","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  }

  $nombre=trim($reg[nombre]);
  $nombre = str_replace("'","??",$nombre);
  $tipo_marca=$reg[tipo_derecho];
  $fecha_solic=$reg[fecha_solic];
  $fecha_regis=$reg[fecha_regis];
  $fecha_venc=$reg[fecha_venc];
  $poder = $reg[poder];
  $vcodpais=$reg[pais_resid];
  $tramitante=trim($reg[tramitante]);
  $vcodage=$reg[agente];
  $vpod1 = trim(substr($poder,-9,4));
  $vpod2 = trim(substr($poder,-4,4));
  //$vestatus=$reg[estatus];
  $smarty->assign('estatus',$estatus);
  //echo "estatus = $estatus ";
  if (!empty($vpod1) && !empty($vpod2))
   { $vpoder= $vpod1."-".$vpod2; } else
   { $vpoder=''; }

  $distingue='';
  //Obtenci??n de datos de la Marca 
  $obj_query = $sql->query("SELECT * FROM $tbname_4 WHERE nro_derecho='$vder'");
  $objs = $sql->objects('',$obj_query);
  $modalidad = $objs->modalidad;
  $vclase    = $objs->clase;
  $clase_id  = $objs->ind_claseni;
  $distingue = trim($objs->distingue);
  $smarty->assign('vstring1',$distingue);

  //Obtenci??n de la clase nacional de la Marca 
  $obj_query = $sql->query("SELECT * FROM $tbname_22 WHERE nro_derecho='$vder'");
  $objs = $sql->objects('',$obj_query);
  $vclnac    = $objs->clase_nac;

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
  else { $nameimage = ver_imagen($vsol1,$vsol2,"M"); }  

  if (!file_exists($nameimage)) {
    $nameimage="../imagenes/sin_imagen8.png"; }

  $smarty->assign('ubicacion',$nameimage);
  $auxnum = $vsol1;
  $smarty->assign('auxnum',$auxnum);

  $etiqueta='';
  // Obtencion de la Etiqueta
  if (($modalidad=="G") || ($modalidad=="M")) {
    $vexist= 0;
    $obj_query = $sql->query("SELECT * FROM $tbname_8 WHERE nro_derecho ='$vder'");
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

  if ($tipo_marca=="L") {
    $vsolema= '';
    $vreglema='';
    $obj_query = $sql->query("SELECT * FROM $tbname_14 WHERE nro_derecho ='$vder'"); 
    $obj_filas = $sql->nums('',$obj_query);
    if ($obj_filas!=0) {
      $objs = $sql->objects('',$obj_query);
      $vsolema=trim($objs->solicitud_aso);
      $vreglema=trim($objs->registro_aso);
      if ($vsolema!='') {
        $vsol3 = substr($vsolema,-11,4); 
        $vsol4 = substr($vsolema,-6,6); 
        $smarty->assign('vsol3',$vsol3); 
        $smarty->assign('vsol4',$vsol4); }
      if ($vreglema!='') {
        $vreg1d = substr($vreglema,-7,1);
        $vreg2d = substr($vreglema,-6,6); 
        $smarty->assign('vreg1d',$vreg1d);
        $smarty->assign('vreg2d',$vreg2d);}
    }
  }

  // Obtencion de Agentes  
  $sql->del("$tbname_18","solicitud='$varsol'");
  if ($vcodage>0) {
    $obj_query = $sql->query("SELECT * FROM $tbname_2 WHERE agente=$vcodage");
    $objs = $sql->objects('',$obj_query);
    $col_campos = "solicitud,agente,nombre,domicilio,tipo_mp";
    $insert_str = "'$varsol',$vcodage,'$objs->nombre','$objs->domicilio','M'";
    $insagen = $sql->insert("$tbname_18","$col_campos","$insert_str",""); }
  $obj_query = $sql->query("SELECT * FROM $tbname_16,$tbname_2 WHERE nro_derecho=$vder AND $tbname_16.agente=$tbname_2.agente ORDER BY $tbname_2.agente");
  $obj_filas = $sql->nums('',$obj_query);
  if ($obj_filas > 0) {  
    $objs = $sql->objects('',$obj_query);
    for ($contobj=0;$contobj<$obj_filas;$contobj++) {
      $vcod = $objs->agente;
      $nomb = $objs->nombre;
      $nomb = str_replace("'","??",$nomb);
      $domi = $objs->domicilio;
      $col_campos = "solicitud,agente,nombre,domicilio,tipo_mp";
      $obj_ag_query = $sql->query("SELECT * FROM $tbname_18 WHERE solicitud='$varsol' AND agente=$vcodage AND tipo_mp='M'");
      $obj_fil_agen = $sql->nums('',$obj_ag_query);
      if ($obj_fil_agen==0) {  
        $insert_str = "'$varsol','$vcod','$nomb','$domi','M'";
        $insagen = $sql->insert("$tbname_18","$col_campos","$insert_str",""); }
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
      $insert_str = "'$varsol','$vcod','$pais','$fech','M'";
      $insprio = $sql->insert("$tbname_19","$col_campos","$insert_str","");
      $objs = $sql->objects('',$obj_query); }	  
  }

  // Obtencion de Codigos de Viena     
  $sql->del("$tbname_11","solicitud='$varsol'");
  $obj_query = $sql->query("SELECT * FROM $tbname_17,$tbname_20 WHERE $tbname_17.nro_derecho=$vder AND $tbname_17.ccv=$tbname_20.ccv ORDER BY $tbname_17.ccv");
  $obj_filas = $sql->nums('',$obj_query);
  if ($obj_filas > 0) {  
    $objs = $sql->objects('',$obj_query);
    for ($contobj=0;$contobj<$obj_filas;$contobj++) {
      $vcod = $objs->ccv;
      $desc = $objs->descripcion;
      $insert_str = "'$varsol','$vcod','$desc'";
      $insccv = $sql->insert("$tbname_11","","$insert_str","");
      $objs = $sql->objects('',$obj_query); }	  
  }

  // Obtencion del o los Titular(es)  
  $sql->del("$tbname_9","solicitud='$varsol'");
  $obj_query = $sql->query("SELECT stzottid.titular,stzsolic.nombre,stzsolic.indole,stzottid.domicilio,stzottid.nacionalidad,stzottid.pais_domicilio 
                            FROM stzottid,stzsolic WHERE stzottid.nro_derecho ='$vder' AND  
                                 stzottid.titular=stzsolic.titular");
  $obj_filas = $sql->nums('',$obj_query);
  $objs = $sql->objects('',$obj_query);
  for ($contobj=0;$contobj<$obj_filas;$contobj++) {
     $vcod = $objs->titular;
     $nomb = $objs->nombre;
     $nomb = str_replace("'","??",$nomb);
     $domi = $objs->domicilio;
     $domi = str_replace("'","??",$domi); 
     $pais = $objs->nacionalidad;
     $indo = $objs->indole;
     $pdom = $objs->pais_domicilio;
     if (empty($indo)) { $indo = "P"; }  
     $col_campos = "solicitud,titular,nombre,domicilio,nacionalidad,indole,tipo_mp,pais_domicilio";
     $insert_str = "'$varsol','$vcod','$nomb','$domi','$pais','$indo','M','$pdom'";
     $sql->insert("$tbname_9","$col_campos","$insert_str","");
  $objs = $sql->objects('',$obj_query); }	  

}

//Opcion Grabar...
if (($vopc==2) || ($vopc==7)) {
  //La Fecha de Hoy y Hora para la transaccion
  $fechahoy = hoy();
  $horactual= Hora();
  $vest=$_POST['estatus'];

  //Verificando conexion
  $sql->connection($usuario);
  //echo " ERRORRRRRRRRRR estatus= $vest "; exit();
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
  $req_fields = array("fecha_solic","tipo_marca","modalidad","distingue");
  $valores = array($fecha_solic,$tipo_marca,$modalidad,$distingue);
  $vacios = check_empty_fields();
  if (!$vacios) { 
     mensajenew("Hay Informacion en el formulario que esta Vacia ...!!!","javascript:history.back();","N");
     $smarty->display('pie_pag.tpl'); exit(); }

  if ($accion==1) {
    $vclase = substr($vnumclase,0,2); }
    
  // Verificacion de Clase y Tipo de Marca en funcion del indicador
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
       if ($vclase>0 and $vclase<=46) {
           $vclatipo = 1; }
       break;
  }       
  if ($vclatipo==0) {
    mensajenew("Clase Internacional de Niza NO corresponde con el Tipo de Marca ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }

  if (($vclnac==0) || (empty($vclnac))) {
    Mensajenew("Error en Clase Nacional o esta vacia ...!!!","javascript:history.back();","N");
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
     case "C":
       if ($vclnac>0 and $vclnac<51) {  
           $vclatipo = 1; }
       break;
  }       

  if ($vclatipo==0) {
    mensajenew("Clase Nacional NO corresponde con el Tipo de Marca ...!!!","javascript:history.back();","N");
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
       $resulm=pg_exec("select * from $tbname_6 where solicitud='$vsolema' AND tipo_mp='M'"); }
     if ($vreglema!='') {
       $resulm=pg_exec("select * from $tbname_6 where registro='$vreglema' AND tipo_mp='M'"); }
     $regm= pg_fetch_array($resulm);
     $nfil=pg_numrows($resulm);
     if ($nfil==0) {
       mensajenew("Solicitud o Registro NO existe en la Base de Datos ...!!!","javascript:history.back();","N");
       $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
   }

  if ($modalidad=="N") {
      mensajenew("No ha seleccionado la Modalidad ...!!!","javascript:history.back()","N");
      $smarty->display('pie_pag.tpl'); exit();
  }

  //Verificacion de que si existe la imagen en disco y ha sido descrita
  if (($modalidad=="G") || ($modalidad=="M")) {
   if (empty($etiqueta)) {
      mensajenew("Por ser Grafica o Mixta, necesita se describa la Etiqueta ...!!!","javascript:history.back()","N");
      $smarty->display('pie_pag.tpl'); exit(); }  
   $nameimage = ver_imagen($vsol1,$vsol2,"M");
   //if (!file_exists($nameimage)) {
   //   Mensage_Error("Imagen no ha sido Encontrada, debe ser Scaneada para proseguir con la modificacion ...!!!");
   //   $smarty->display('pie_pag.tpl'); exit(); }  
  }
      
  if ($modalidad=="G") { $nombre=""; }

  $restitu=pg_exec("SELECT * FROM $tbname_9 where solicitud='$varsol'");
  $filas_titular=pg_numrows($restitu); 
  if ($filas_titular==0) {
    mensajenew("Expediente $varsol sin ningun Titular asociado ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); 
  }

  if (empty($vcodpais)) {
    Mensajenew("Expediente $varsol sin ningun Pa&iacute;s de Residencia asociado ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); 
  } 

  $vcodage=0;
  // Validacion de Agentes  
  $res_agen=pg_exec("SELECT * FROM $tbname_18 where solicitud='$varsol' AND tipo_mp='M' ORDER BY agente");
  $filas_res_age=pg_numrows($res_agen); 
  $regagen = pg_fetch_array($res_agen);
  if ($filas_res_age==0) { $vcodage=0; }
  else { 
   if ($regagen[agente]!="0") { 
     $vcodage=$regagen[agente]; 
     $del_datos = $sql->del("$tbname_18","solicitud='$varsol' AND agente=$vcodage AND tipo_mp='M'"); } 
  } 

  //Validacion del Poder
  if (!empty($vpod1) && !empty($vpod2))
   { $vpoder= $vpod1."-".sprintf("%04d",$vpod2); } else
   { $vpoder=""; }

  if (empty($tramitante) && empty($vpoder) && empty($vcodage)) {
      mensajenew("Debe tener Tramitante o Poder o Agente(s) ...!!!","javascript:history.back();","N");
      $smarty->display('pie_pag.tpl'); exit(); }

  if ($tramitante!="") {
    if (($vpoder!="") || ($vcodage!="0")) {
      mensajenew("Solo puede tener Tramitante o Poder o Agente(s) ...!!!","javascript:history.back();","N");
      $smarty->display('pie_pag.tpl'); exit(); } }

  if (empty($input2)) { $vcodpais=""; 
      Mensajenew("Debe indicar Pais de Residencia ...!!!","javascript:history.back();","N");
      $smarty->display('pie_pag.tpl'); exit(); }
  
  if ($accion==1) {
    // Ingreso de Solicitud
  } //Incluir
  else {
    // Modificar Solicitud
    $resultado=pg_exec("SELECT * FROM stzevder WHERE evento=1600");
    if (!$resultado) { 
      mensajenew("C??digo de Evento NO existe en la Base de Datos ...!!!","javascript:history.back();","N");
      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
    $filas_found=pg_numrows($resultado); 
    if ($filas_found==0) {
      mensajenew("No existen Datos asociados al Evento ...!!!","javascript:history.back();","N");
      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 
    $regeve = pg_fetch_array($resultado);
    $vdes=trim($regeve['mensa_automatico']);
    $documento=0;
    $comentario="";

    $varsol = sprintf("%02d-%06d",$vsol1,$vsol2);

    $resultado=pg_exec("SELECT * FROM $tbname_6 WHERE solicitud='$varsol' AND solicitud!='' AND tipo_mp='M'");
    $regmarcas = pg_fetch_array($resultado);
    $vestatus=$regmarcas[estatus];
    
    pg_exec("BEGIN WORK");
    $insfon   = true; 
    $inslema  = true;
    $insagen  = true;
    $insccv   = true;
    $inslogo  = true;
    $insprio  = true;
    $insfon   = true;
    $instram  = true;  
    $updmarce = true;
    $updderecho = true; 

    //Direccion IP de la Maquina
    $dirIP = getRealIP(); 

    $insaud = true;
    // Tabla Auditoria de Modificacion 
    $columnas_str = "fecha,hora,ip_acceso,usuario,solicitud,registro,tipo_mp,modulo";
    $insert_str = "'$fechahoy','$horactual','$dirIP','$usuario','$varsol','','M','m_reingres.php'"; 
    $insaud = $sql->insert("stzaudmod","$columnas_str","$insert_str","");

    if ($modalidad=="D") {
      $sql->del("$tbname_8","nro_derecho='$vder'"); 
      $sql->del("$tbname_17","nro_derecho='$vder'"); }

    $estatusfin = 1300;
    if ($vest==1118) { $estatusfin = 1305; }
    //Actualizacion de la maestra principal 
    pg_exec("LOCK TABLE stzderec IN SHARE ROW EXCLUSIVE MODE");
    $nombre = str_replace("'","??",$nombre);
    $tramitante = str_replace("'","??",$tramitante);
    $update_str = "fecha_solic='$fecha_solic',tipo_derecho='$tipo_marca',nombre='$nombre',
    poder='$vpoder',agente=$vcodage,tramitante='$tramitante',pais_resid='$input2',estatus=$estatusfin";
    $updderecho = $sql->update("$tbname_6","$update_str","nro_derecho='$vder'");
    
    //Actualizacion del resto de los datos de la maestra de marcas 
    $vdis = str_replace("'","??",$distingue);
    pg_exec("LOCK TABLE stmmarce IN SHARE ROW EXCLUSIVE MODE");
    $update_str = "clase=$vclase,ind_claseni='$clase_id',modalidad='$modalidad',distingue='$vdis'";
    $updmarce = $sql->update("$tbname_4","$update_str","nro_derecho='$vder'");

    $horactual = Hora();
    // Tabla de Eventos de Tramite  
    $col_campos = "nro_derecho,evento,fecha_event,secuencial,estat_ant,documento,fecha_trans,usuario,desc_evento,hora";
    $insert_str = "'$vder',1600,'$fechahoy',nextval('stzevtrd_secuencial_seq'),$vestatus,0,'$fechahoy','$usuario','$vdes','$horactual'";
    $instram = $sql->insert("$tbname_5","$col_campos","$insert_str","");

    // Tabla de Batfon 
    //$insert_str = "'$varsol'";
    //$insfon = $sql->insert("$tbname_21","","$insert_str","");

    $updclanac=true;
    //Actualizacion de la Clase Nacional   
    $update_str = "clase_nac=$vclnac";
    $updclanac = $sql->update("$tbname_22","$update_str","nro_derecho='$vder'");

    // Tabla de Lemas Asociados 
    if ($tipo_marca=="L") {
      $sql->del("$tbname_14","nro_derecho='$vder'");
      $vsolema = $vsol3."-".$vsol4;
      $vreglema= $vreg1d.$vreg2d;

     if ($vsolema!='') {
       $col_campos = "nro_derecho,solicitud_aso"; 
       $insert_str = "'$vder','$vsolema'";  }
     if ($vreglema!='') {
       $col_campos = "nro_derecho,registro_aso"; 
       $insert_str = "'$vder','$vreglema'"; }
     $inslema = $sql->insert("$tbname_14","$col_campos","$insert_str","");
    }

    // Tabla de Agentes  
    $del_datos = $sql->del("$tbname_16","nro_derecho='$vder'");
    $res_agen=pg_exec("SELECT * FROM $tbname_18 where solicitud='$varsol' AND tipo_mp='M' ORDER BY agente");
    $filas_res_age=pg_numrows($res_agen); 
    $regagen = pg_fetch_array($res_agen);
    
    $numagen = 0; 
    for($i=0;$i<$filas_res_age;$i++) 
    {
     if ($i!=0) {
       if ($regagen[agente]!="0") {
           $obj_query = $sql->query("SELECT * FROM $tbname_16 where nro_derecho='$vder' and agente='$regagen[agente]'");
           if (!$obj_query) { 
             Mensajenew("Problema al intentar realizar la consulta en la tabla $tbname_16 ...!!!","javascript:history.back();","N");
             $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
           $filas_agente=$sql->nums('',$obj_query);
           if ($filas_agente==0) {
             $col_campos = "nro_derecho,agente";
             $insert_str = "'$vder','$regagen[agente]'";
             $insagen = $sql->insert("$tbname_16","$col_campos","$insert_str","");
             if ($insagen) { }
             else { $numagen = $numagen + 1; }  
           } 
       }
     }
     $regagen = pg_fetch_array($res_agen); 
    }
    $del_datos = $sql->del("$tbname_18","solicitud='$varsol' AND tipo_mp='M'");

    $numprio = 0; 
    // Tabla de Prioridades   
    $del_datos = $sql->del("$tbname_15","nro_derecho='$vder'");
    $res_prio=pg_exec("SELECT * FROM $tbname_19 where solicitud='$varsol' AND tipo_mp='M'");
    $filas_res_prio=pg_numrows($res_prio); 
    $regprio = pg_fetch_array($res_prio);
    for($i=0;$i<$filas_res_prio;$i++) { 
      $obj_query = $sql->query("SELECT * FROM $tbname_15 where nro_derecho='$vder' AND prioridad='$regprio[prioridad]'");
      if (!$obj_query) { 
         Mensajenew("Problema al intentar realizar la consulta en la tabla $tbname_15 ...!!!","javascript:history.back();","N");
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
    $del_datos = $sql->del("$tbname_19","solicitud='$varsol' AND tipo_mp='M'");

    // Tabla de Logos
    if (($modalidad=="G") || ($modalidad=="M")) {
      $veti = str_replace("'","??",$etiqueta);
      $obj_query = $sql->query("SELECT * FROM $tbname_8 WHERE nro_derecho ='$vder'");
      $obj_filas = $sql->nums('',$obj_query);
      pg_exec("LOCK TABLE stmlogos IN SHARE ROW EXCLUSIVE MODE");
      if ($obj_filas==0) {
        $insert_str = "'$vder','$veti'";
        $inslogo = $sql->insert("$tbname_8","","$insert_str",""); }
      else {
        $update_str = "descripcion='$veti'";
        $inslogo = $sql->update("$tbname_8","$update_str","nro_derecho='$vder'"); }
    }  

    $numccv = 0;
    // Tabla de Clasificaciones de Viena
    if (($modalidad=="G") || ($modalidad=="M")) {
      $del_datos = $sql->del("$tbname_17","nro_derecho='$vder'");
      $obj_query = $sql->query("SELECT * FROM $tbname_11 WHERE solicitud='$varsol'");
      $obj_filas = $sql->nums('',$obj_query);
      $objs = $sql->objects('',$obj_query);
      for($i=0;$i<$obj_filas;$i++) { 
        $resul=pg_exec("SELECT * FROM $tbname_17 WHERE nro_derecho='$vder' AND ccv='$objs->ccv'");
        $filas_resul=pg_numrows($resul);
        if ($filas_resul==0) {
          $insert_str = "'$vder','$objs->ccv'";  
          $insccv = $sql->insert("$tbname_17","","$insert_str","");
          if (!$insccv) { $numccv = $numccv + 1; } 
        }   
        $objs = $sql->objects('',$obj_query);
      }
      $del_datos = $sql->del("$tbname_11","solicitud='$varsol'");
    }

    // Tabla de Solicitantes o Titulares 
    $res_titu=pg_exec("SELECT * FROM $tbname_9 where solicitud='$varsol' AND tipo_mp='M'");
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
         $vnombret = str_replace("'","??",$regtitu[nombre]);
         $insert_str = "nextval('stzsolic_titular_seq'),'$regtitu[identificacion]','$vnombret','$regtitu[indole]','$regtitu[telefono1]','$regtitu[telefono2]','$regtitu[fax]','$regtitu[email]'"; 
         $ins_solic = $sql->insert("$tbname_3","$col_campos","$insert_str","");

         $obj_query = $sql->query("select last_value from stzsolic_titular_seq");
         $objs = $sql->objects('',$obj_query);
         $act_titular = $objs->last_value;
         $vdom = str_replace("'","??",$regtitu[domicilio]);

         $col_campos = "nro_derecho,titular,nacionalidad,domicilio,pais_domicilio";
         $insert_str = "'$vder','$act_titular','$regtitu[nacionalidad]','$vdom','$regtitu[pais_domicilio]'";
         $ins_titur = $sql->insert("$tbname_7","$col_campos","$insert_str","");
         if ($ins_solic AND $ins_titur) { }
         else { $numtitu = $numtitu + 1; }  
       }
     else
       {
         $obj_query = $sql->query("SELECT * FROM $tbname_7 where nro_derecho='$vder' and titular='$regtitu[titular]'");
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
         } 
       }
     $regtitu = pg_fetch_array($res_titu);
    }
    $del_datos = $sql->del("$tbname_9","solicitud='$varsol' AND tipo_mp='M'");

    if ($numtitu==0 AND $numccv==0 AND $instram AND $inslema AND $inslogo AND 
        $numprio==0 AND $numagen==0 AND $updmarce AND $updderecho) {
      pg_exec("COMMIT WORK");
      //Desconexion de la Base de Datos
      $sql->disconnect();

      Mensajenew('DATOS GUARDADOS CORRECTAMENTE !!!','m_reingres.php?vopc=5','S');
      $smarty->display('pie_pag.tpl'); exit();
    } 
    else {
      pg_exec("ROLLBACK WORK");
      //Desconexion de la Base de Datos
      $sql->disconnect();

      if (!$inslema)    { $error_lem = " - Lema "; }
      if (!$instram)    { $error_tra = " - Tramite "; }
      if (!$inslogo)    { $error_log = " - Descripcion del Logo "; }
      if (!$updmarce)   { $error_mar = " - Marcas "; }
      if (!$updderecho) { $error_der = " - Derecho "; }
      if ($numtitu!=0)  { $error_tit = " - Titular(es) "; }
      if ($numccv!=0)   { $error_ccv = " - Clasificacion Vienna "; }
      if ($numprio!=0)  { $error_pri = " - Prioridad "; }
      if ($numagen!=0)  { $error_age = " - Agente(s) "; }
      if (!$updclanac)  { $error_cla = " - Clase Nacional "; } 
            
      Mensajenew("Falla de Actualizaci&oacute;n de Datos en la BD $error_lem, $error_log, $error_pri, $error_age, $error_mar, $error_der, $error_tit, $error_ccv ...!!!","javascript:history.back();","N");
      $smarty->display('pie_pag.tpl'); exit();
    }

  } // Modificar
}

if (($vopc!=1) && ($vopc!=2) && ($vopc!=3) && ($vopc!=4) && ($vopc!=5) && ($vopc!=6) && ($vopc!=7)) {
  $smarty->assign('modo1',''); 
  $smarty->assign('modo2','disabled'); 
  $smarty->assign('modo3','disabled'); 
  $smarty->assign('submitbutton','button');
  $smarty->assign('submitbutton3','button');
  $smarty->assign('vmodo','readonly=readonly'); 
  $smarty->assign('psoli',$vsol); 
  $smarty->assign('modo','readonly=readonly'); 
}

if ($vopc==5) {
  $smarty->assign('subtitulo','Reingreso de Expediente'); 
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
$smarty->assign('campo3','Tipo de Marca:');
$smarty->assign('campo4','Nombre:');
$smarty->assign('campo5','Clase Internacional:');
//$smarty->assign('campo5','Clase:');
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
$smarty->assign('campo20','Clase Nacional:');

if (($vopc==1) || ($vopc==6)){
  $smarty->assign('varfocus','formarcas2.fecha_solic');
  $smarty->assign('submitbutton','button');
  $smarty->assign('modalidad','N'); 
  $smarty->assign('tipo_marca','V');
  $smarty->assign('modalidad',$modalidad);
  $smarty->assign('tipo_marca',$tipo_marca);
 }

if (($vopc==2) && ($vopc==7)) {
  $smarty->assign('varfocus','formarcas1.vsol1'); 
  $smarty->assign('modo',''); 
  $smarty->assign('psoli',$vsol); 
  $smarty->assign('submitbutton','submit');
  $smarty->assign('modalidad',$modalidad);
  $smarty->assign('tipo_marca',$tipo_marca); }

$smarty->assign('vder',$vder);
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
$smarty->assign('vclnac',$vclnac);
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

$smarty->display('m_reingres.tpl');
$smarty->display('pie_pag.tpl');
?>
