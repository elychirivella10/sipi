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
// Programa: m_manteni.php 
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
$usuario   = trim($_SESSION['usuario_login']);
$role      = $_SESSION['usuario_rol'];
$sql       = new mod_db();
$fecha     = fechahoy();
$modulo    = "m_manteni.php";

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

$vopc     = $_GET['vopc'];
$vuser    = $_GET['vuser'];
$vaccion  = $_GET['vaccion'];
$vauxnum  = $_GET['vauxnum'];
$depto_id = $_GET['vdepto'];
$vsol1    = $_POST['vsol1'];
$vsol2    = $_POST['vsol2'];
$vsol     = $_POST['vsol'];
$psoli    = $_POST['psoli'];

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
$input1=$_POST['input1'];
$input2=$_POST['input2'];
$vsol3=$_POST['vsol3'];
$vsol4=$_POST['vsol4'];
$vreg1d=$_POST['vreg1d'];
$vreg2d=$_POST['vreg2d'];
$ubicacion= $_POST['ubicacion'];
$vder     = $_POST['vder'];
$vclnac   = $_POST['vclnac'];

// ************************************************************************************  
$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Mantenimiento de Expediente  Modificaci&oacute;n'); 
if ($vopc==4) {
  $smarty->assign('subtitulo','Mantenimiento de Expediente / Modificaci&oacute;n'); }
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

$smarty->assign('arraytipom',array(V,M,N,L,S,C,D,O));
$smarty->assign('arraynotip',array('','MARCA DE PRODUCTO','NOMBRE COMERCIAL','LEMA COMERCIAL','MARCA DE SERVICIO','MARCA COLECTIVA','DENOMINACION COMERCIAL','DENOMINACION DE ORIGEN'));
$smarty->assign('arrayvclase',array(I,N));
$smarty->assign('arraytclase',array('INTERNACIONAL','NACIONAL'));
$smarty->assign('arrayvmodal',array(N,D,G,M));
$smarty->assign('arraytmodal',array('','DENOMINATIVA','GRAFICA','MIXTA'));

// ************************************************************************************  
$nconexion = $_POST['nconexion'];
if (empty($nconexion)) { $nconexion = $_GET['nconexion']; }
$nveces = $_POST['nveces'];
if (empty($nveces)) { $nveces = $_GET['nveces']; }

// ************************************************************************************  
if (($vopc==1) || ($vopc==3)) {
  $nveces = $nveces + 1; 
  if ($nveces==1) { $nconexion = insconex($usuario,$modulo,'M'); } 

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
     mensajenew("No introdujo ningn valor de Expediente ...!!!","javascript:history.back();","N");
     $smarty->display('pie_pag.tpl'); exit(); }

  if (($vresol=="-") || ($vresol=="0000-000000")) {
    mensajenew("Numero de Solicitud Vacio ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }

  if (($vsol1=="0000") || ($vsol2=="000000")) { 
    mensajenew("Numero de Solicitud Vacio o Erroneo ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }

  //Armado del Numero de Expediente
  $varsol=$vsol1."-".sprintf("%06d",$vsol2);
  $dirano=$vsol1;
  //Variable Numero del Expediente
  $numero=substr($varsol,-6,6);
  
  //Verificando conexion
  $sql->connection($usuario);
  
  $resultado=pg_exec("SELECT * FROM $tbname_6 WHERE solicitud='$varsol' and solicitud!='' AND tipo_mp='M'");

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

  $vsol    = $reg[solicitud];
  $psoli   = $reg[solicitud];
  $vsol1   = substr($vsol,-11,4);
  $vsol2   = substr($vsol,-6,6);
  $estatus = $reg[estatus];
  $smarty->assign('psoli',$psoli); 

if ($usuario=='rbasalo999') {
  if(($varsol<'1988-999999') AND ($estatus==1008)) { }
  else {
    Mensajenew("ERROR: Usuario NO tiene Permiso para modificar esta Solicitud bajo este Estatus ...!!!","m_manteni.php?vopc=4&vaccion=2&vauxnum=0","N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();
  }
} else {
	
$vbol = "yes";
if ($vbol=="yes") {
  if (($estatus==1001) || ($estatus==1002) || ($estatus==1004) || ($estatus==1005) || ($estatus==1006) || ($estatus==1200) || ($estatus==1113) || ($estatus==1101)) { }  
  else { 
    if (($estatus==1008) || ($estatus==1104) || ($estatus==1300) || ($estatus==1305) || ($estatus==1030) || ($estatus==1404) || ($estatus==1120) || ($estatus==1150) || ($estatus==1400)) { 
      if (($usuario=='aperez') || ($usuario=='evelasquez') || ($usuario=='ynavarro') || ($usuario=='mfranco') || ($usuario=='lchacon') || ($usuario=='cpirela') || ($usuario=='aamaro') || ($usuario=='gzambrano') || ($usuario=='mesculpi') || ($usuario=='wrivas')) { }
      else {
        Mensajenew("ERROR: Usuario NO tiene Permiso para modificar bajo este Estatus ...!!!","m_manteni.php?vopc=4&vaccion=2&vauxnum=0","N");
        $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();
      }  
    }
    else {
      //if (($estatus==1008) || ($estatus==1030) || ($estatus==1027)) { 
      if (($estatus==1101) || ($estatus==1102)) { 
        if (($usuario=='aamaro') || ($usuario=='jcastellano') || ($usuario=='jzambrano') || ($usuario=='mesculpi')) { }
        else {
          Mensajenew("ERROR: Usuario NO tiene Permiso para modificar bajo este Estatus ...!!!","m_manteni.php?vopc=4&vaccion=2&vauxnum=0","N");
          $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();
        }
      }  
      else { 
       if (($estatus==1121) || ($estatus==1122) || ($estatus==1124)) { 
         if (($usuario=='aperez') || ($usuario=='wrivas')) { }
         else {
           Mensajenew("ERROR: Usuario NO tiene Permiso para modificar bajo este Estatus ...!!!","m_manteni.php?vopc=4&vaccion=2&vauxnum=0","N");
           $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();
         }  
       }
       else {
         if (($estatus==1910) || ($estatus==1914) || ($estatus==1003) || ($estatus==1911) || ($estatus==1750) || ($estatus==1025) || ($estatus==1800) || ($estatus==1801) || ($estatus==1802) || ($estatus==1803) || ($estatus==1804) || ($estatus==1805) || ($estatus==1806) || ($estatus==1807) || ($estatus==1808) || ($estatus==1809) || ($estatus==1821) || ($estatus==1822) || ($estatus==1823) || ($estatus==1824) || ($estatus==1825) || ($estatus==1830) || ($estatus==1831) || ($estatus==1833) || ($estatus==1835) || ($estatus==1836) || ($estatus==1837) || ($estatus==1838)) { 
           if (($usuario=='aperez') || ($usuario=='ogamardo') || ($usuario=='jzambrano') || ($usuario=='toliveros')) { }
           else {
             Mensajenew("ERROR: Usuario NO tiene Permiso para modificar bajo este Estatus ...!!!","m_manteni.php?vopc=4&vaccion=2&vauxnum=0","N");
             $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();
           }  
         }
         else {
           if ($estatus==1116) { 
             if (($usuario=='aperez')) { }
             else {
               Mensajenew("ERROR: Usuario NO tiene Permiso para modificar bajo este Estatus ...!!!","m_manteni.php?vopc=4&vaccion=2&vauxnum=0","N");
               $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();
             }  
           }    
           else {
             Mensajenew("ERROR: Solicitud en estatus NO Modificable ...!!!","m_manteni.php?vopc=4&vaccion=2&vauxnum=0","N");
             $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();
           }
         }  
       }  
      }
    }    
  }
}
else {
  if (($estatus==1001) || ($estatus==1002) || ($estatus==1004) || ($estatus==1005) || ($estatus==1006) || ($estatus==1200) || ($estatus==1113) || ($estatus==1101)) { }  
  else {
    if (($estatus==1002) || ($estatus==1008) || ($estatus==1101) || ($estatus==1102) || ($estatus==1104) || ($estatus==1120) || ($estatus==1150) || ($estatus==1305) || ($estatus==1400)) { 
      if (($usuario=='aperez') || ($usuario=='mfranco') || ($usuario=='lchacon') || ($usuario=='cpirela') || ($usuario=='evelasquez') || ($usuario=='ynavarro') || ($usuario=='aamaro') || ($usuario=='jcastellano') || ($usuario=='jzambrano') || ($usuario=='mesculpi') || ($usuario=='rmendoza')) { }
      else {
        Mensajenew("ERROR: Usuario NO tiene Permiso para modificar bajo este Estatus ...!!!","m_manteni.php?vopc=4&vaccion=2&vauxnum=0","N");
        $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); //|| ($usuario=='cayelhett')
      }
    }
    else { 
      Mensajenew("ERROR: Solicitud en estatus NO Modificable ...!!!","m_manteni.php?vopc=4&vaccion=2&vauxnum=0","N");
      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();
    }
  }  
}
} 

  //if (($estatus==1001) || ($estatus==1002) || ($estatus==1004) || ($estatus==1006)) { }  
  //else { 
  //  if (($estatus==1101) || ($estatus==1102) || ($estatus==1003) || ($estatus==1025) || ($estatus==1914)) { 
  //    if (($usuario=='cvelasquez') || ($usuario=='hbriceno') || ($usuario=='cayelhett') || ($usuario=='rtory')) { }
  //    else {
  //      Mensajenew("ERROR: Usuario NO tiene Permiso para modificar bajo este Estatus ...!!!","m_manteni.php?vopc=4&vaccion=2&vauxnum=0","N");
  //      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();
  //    }
  //  }
  //  else {
  //    Mensajenew("ERROR: Solicitud en estatus NO Modificable ...!!!","m_manteni.php?vopc=4&vaccion=2&vauxnum=0","N");
  //    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();
  //  }    
  //}

  $vder        = $reg[nro_derecho];  
  $fecha_solic = $reg[fecha_solic];
  $nombre      = trim($reg[nombre]);
  $nombre      = str_replace("'","´",$nombre);
  $tipo_marca  = $reg[tipo_derecho];
  $tramitante  = trim($reg[tramitante]);
  $poder       = $reg[poder];
  $vpod1       = trim(substr($poder,-9,4));
  $vpod2       = trim(substr($poder,-4,4));
  $vcodage     = $reg[agente];
  $vcodpais    = $reg[pais_resid];

  if (!empty($vpod1) && !empty($vpod2))
   { $vpoder= $vpod1."-".$vpod2; } else
   { $vpoder=''; }

  $distingue='';
  //Obtención de datos de la Marca 
  $obj_query = $sql->query("SELECT * FROM $tbname_4 WHERE nro_derecho='$vder'");
  $objs = $sql->objects('',$obj_query);
  $modalidad = $objs->modalidad;
  $vclase    = $objs->clase;
  $clase_id  = $objs->ind_claseni;
  $distingue = trim($objs->distingue);
  $smarty->assign('vstring1',$distingue);

  $auxnum = $vsol1;
  $smarty->assign('auxnum',$auxnum);

  //Obtención de la clase nacional de la Marca 
  $obj_query = $sql->query("SELECT * FROM $tbname_22 WHERE nro_derecho='$vder'");
  $objs = $sql->objects('',$obj_query);
  $vclnac    = $objs->clase_nac;

  //Almaceno en un string los valores de los campos antes de modificar alguno
  $pais_resid = $vcodpais;
  if (!empty($vcodagenew)) { $agen_id = $vcodagenew; }
  $valores_fields = array($nombre,$fecha_solic,$tipo_marca,$vclase,$clase_id,$modalidad,$vcodage,$vpoder,$tramitante,$pais_resid);
  $campos = "nombre|fecha_solic|tipo_marca|clase|ind_claseni|modalidad|agente|poder|tramitante|pais_resid";
  $vstring = bitacora_fields();
  $smarty->assign('vstring',$vstring);
  $smarty->assign('campos',$campos);
  
  if ($modalidad=="D") {
    $nameimage="../imagenes/sin_imagen8.png"; }
  else { $nameimage = ver_imagen($vsol1,$vsol2,"M"); }  

  if (!file_exists($nameimage)) {
    $nameimage="../imagenes/sin_imagen8.png"; }
  $smarty->assign('ubicacion',$nameimage);

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

  $etiqueta='';
  // Obtencion de la Etiqueta
  if (($modalidad=="G") || ($modalidad=="M")) {
    $vexist= 0;
    $obj_query = $sql->query("SELECT * FROM $tbname_8 WHERE nro_derecho ='$vder'");
    $obj_filas = $sql->nums('',$obj_query);
    if ($obj_filas!=0) {
      $objs = $sql->objects('',$obj_query);
      $etiqueta = trim($objs->descripcion); 
      $etiqueta = str_replace("'","´",$etiqueta);
      $vexist= 1;}
    else { $vexist= 0;}
  $smarty->assign('vstring2',$etiqueta);
  }
  $smarty->assign('modalidad',$modalidad);
  $smarty->assign('tipo_marca',$tipo_marca);

  // Obtencion de Agentes  
  //$vector_agente = array();  
  $sql->del("$tbname_18","solicitud='$varsol' AND tipo_mp='M'");
  if ($vcodage>0) {
    $obj_query = $sql->query("SELECT * FROM $tbname_2 WHERE agente=$vcodage");
    $objs = $sql->objects('',$obj_query);
    $col_campos = "solicitud,agente,nombre,domicilio,tipo_mp,tipo_per";
    $insert_str = "'$varsol',$vcodage,'$objs->nombre','$objs->domicilio','M','1'";
    $insagen = $sql->insert("$tbname_18","$col_campos","$insert_str",""); }
  $obj_query = $sql->query("SELECT * FROM $tbname_16,$tbname_2 WHERE nro_derecho=$vder AND $tbname_16.agente=$tbname_2.agente ORDER BY $tbname_2.agente");
  $obj_filas = $sql->nums('',$obj_query);
  if ($obj_filas > 0) {  
    $objs = $sql->objects('',$obj_query);
    for ($contobj=0;$contobj<$obj_filas;$contobj++) {
      $vcod = $objs->agente;
      $nomb = $objs->nombre;
      $domi = $objs->domicilio;
      //$vector_agente[] = $vcod;
      $col_campos = "solicitud,agente,nombre,domicilio,tipo_mp,tipo_per";
      $insert_str = "'$varsol','$vcod','$nomb','$domi','M','1'";
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
      $desc = str_replace("'","´",$desc);
      $insert_str = "'$varsol','$vcod','$desc'";
      $insccv = $sql->insert("$tbname_11","","$insert_str","");
      $objs = $sql->objects('',$obj_query); }	  
  }

  // Obtencion del o los Titular(es)  
  $sql->del("$tbname_9","solicitud='$varsol'");
  $obj_query = $sql->query("SELECT stzottid.titular,stzsolic.identificacion,stzsolic.nombre,stzsolic.indole, stzottid.domicilio,stzottid.nacionalidad,stzottid.pais_domicilio 
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
     $paisdom = $objs->pais_domicilio;
     $indo = $objs->indole;
     $vide = trim($objs->identificacion);
     if (empty($indo)) { $indo = "P"; }  
     $col_campos = "solicitud,titular,identificacion,nombre,domicilio,nacionalidad,indole,tipo_mp,pais_domicilio";
     $insert_str = "'$varsol','$vcod','$vide','$nomb','$domi','$pais','$indo','M','$paisdom'";
     $sql->insert("$tbname_9","$col_campos","$insert_str","");
  $objs = $sql->objects('',$obj_query); }	  

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
    Mensajenew("ERROR: Numero de Solicitud Vacio o con Error ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }
  }

  $esmayor=compara_fechas($fecha_solic,$fechahoy);
  if ($esmayor==1) {
    mensajenew("ERROR: La Fecha de Solicitud No puede ser mayor a la de Hoy ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }
  
  $annno= Obtener_anno($fecha_solic,0);
  if ($dirano != $annno) { 
    Mensajenew("ERROR: Los Cuatros primeros digitos del Expediente no son iguales a los cuatros ultimos de su Fecha ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit();  }
      
  //Verificacion de que los campos requeridos esten llenos...
  $req_fields = array("fecha_solic","tipo_marca","modalidad","distingue");
  $valores = array($fecha_solic,$tipo_marca,$modalidad,$distingue);
  $vacios = check_empty_fields();
  if (!$vacios) { 
     mensajenew("AVISO: Hay Informacion en el formulario que esta Vacia ...!!!","javascript:history.back();","N");
     $smarty->display('pie_pag.tpl'); exit(); }

  if ($accion==1) {
    $vclase = substr($vnumclase,0,2); }

  if (empty($vclase)) {
    Mensajenew("ERROR: Clase Internacional Vacia ...!!!","javascript:history.back();","N");
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
    mensajenew("ERROR: Clase Internacional de Niza no corresponde con el Tipo de Marca ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }

  if (($vclnac==0) || (empty($vclnac))) {
    $vclnac=50;
    //Mensajenew("ERROR en Clase Nacional o esta vacia ...!!!","javascript:history.back();","N");
    //$smarty->display('pie_pag.tpl'); exit(); 
  }

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
    Mensajenew("ERROR: Clase Nacional NO corresponde con el Tipo de Marca ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }

  $esmayor=compara_fechas($fecha_solic,$fechahoy);
  if ($esmayor==1) {
    mensajenew("ERROR: La Fecha de Solicitud No puede ser mayor a la de Hoy ...!!!","javascript:history.back();","N");
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
       mensajenew("AVISO: La Solicitud por ser Lema necesita a que Marca sera aplicado ...!!!","javascript:history.back();","N");
       $smarty->display('pie_pag.tpl'); exit(); }
     
     if ($vsolema!='') {
       $resulm=pg_exec("select * from $tbname_6 where solicitud='$vsolema' AND tipo_mp='M'"); }
     if ($vreglema!='') {
       $resulm=pg_exec("select * from $tbname_6 where registro='$vreglema' AND tipo_mp='M'"); }
     $regm= pg_fetch_array($resulm);
     $nfil=pg_numrows($resulm);
     if ($nfil==0) {
       Mensajenew("ERROR: Solicitud o Registro asociado al Lema NO existe en la Base de Datos ...!!!","javascript:history.back();","N");
       $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
   }

  if ($modalidad=="N") {
      mensajenew("ERROR: No ha seleccionado la Modalidad ...!!!","javascript:history.back()","N");
      $smarty->display('pie_pag.tpl'); exit();
  }

  $varsol=$vsol1."-".$vsol2;
  $restitu=pg_exec("SELECT * FROM $tbname_9 where solicitud='$varsol'");
  $filas_titular=pg_numrows($restitu); 
  if ($filas_titular==0) {
    mensajenew("ERROR: Expediente $varsol sin ningun Titular asociado ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); 
  }

  if (empty($vcodpais)) {
    Mensajenew("ERROR: Expediente $varsol sin ningun Pa&iacute;s de Residencia asociado ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); 
  } 
    
  //Verificacion de que si existe la imagen en disco y ha sido descrita
  if (($modalidad=="G") || ($modalidad=="M")) {
   if (empty($etiqueta)) {
      mensajenew("AVISO: Por ser Grafica o Mixta, necesita se describa la Etiqueta ...!!!","javascript:history.back()","N");
      $smarty->display('pie_pag.tpl'); exit(); }  
   $nameimage = ver_imagen($vsol1,$vsol2,"M");
   //if (!file_exists($nameimage)) {
   //   Mensage_Error("Imagen no ha sido Encontrada, debe ser Scaneada para proseguir con la modificacion ...!!!");
   //   $smarty->display('pie_pag.tpl'); exit(); }  
  }
      
  if ($modalidad=="G") { $nombre=""; }

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
  
  if ($accion==1) {
  } //Incluir
  else {
    // Modificar Solicitud
    $varsol = sprintf("%02d-%06d",$vsol1,$vsol2);

    //Se obtiene el proximo valor para el secuencial a guardar en stzbitac a partir de stzsistem
    //pg_exec("BEGIN WORK");
    //pg_exec("LOCK TABLE stzsystem IN SHARE ROW EXCLUSIVE MODE");
    //$sys_actual = next_sys("nbitaco");
    //$vsecuencial = grabar_sys("nbitaco",$sys_actual);
    //pg_exec("COMMIT WORK");
    
    // Corregir luego campo a tipo serial, para grabar, en ambas  
    // Almaceno registro original en Bitacora
    //$insert_str = "'$vsecuencial','$fechahoy','$horactual','$usuario','$tbname_4','M','M','$varsol','$vstring','$campos'";
    //$sql->insert("$tbname_12","","$insert_str","");

    //Se obtiene el proximo valor para el secuencial a guardar en stzbider a partir de stzsistem para distingue
    //pg_exec("BEGIN WORK");
    //pg_exec("LOCK TABLE stzsystem IN SHARE ROW EXCLUSIVE MODE");
    //$sys_actual = next_sys("nbitaco");
    //$vsecuencial = grabar_sys("nbitaco",$sys_actual);
    //pg_exec("COMMIT WORK");

    // Almaceno registro original en Bitacora stzbider
    //$insert_str = "'$vsecuencial','$fechahoy','$horactual','$usuario','$tbname_6','M','M','$varsol','$vstring1'";
    //$sql->insert("$tbname_13","","$insert_str","");

    //Se obtiene el proximo valor para el secuencial a guardar en stzbider a partir de stzsistem para etiqueta
    //if (($modalidad=="G") || ($modalidad=="M")) {
      //pg_exec("BEGIN WORK");
      //pg_exec("LOCK TABLE stzsystem IN SHARE ROW EXCLUSIVE MODE");
      //$sys_actual = next_sys("nbitaco");
      //$vsecuencial = grabar_sys("nbitaco",$sys_actual);
      //pg_exec("COMMIT WORK");
      // Almaceno registro original en Bitacora stzbider
      //$insert_str = "'$vsecuencial','$fechahoy','$horactual','$usuario','$tbname_8','M','M','$varsol','$vstring2'";
      //$sql->insert("$tbname_13","","$insert_str","");
    //}

    pg_exec("BEGIN WORK");
    $inslema  = true;
    $insagen  = true;
    $insccv   = true;
    $inslogo  = true;
    $insprio  = true;
    $insfon   = true; 
    $updmarce = true;
    $updderecho = true; 
    $updtramite = true;
    
    if ($modalidad=="D") {
      $sql->del("$tbname_8","nro_derecho='$vder'");
      $sql->del("$tbname_17","nro_derecho='$vder'"); }

    //Actualizacion de la maestra principal 
    pg_exec("LOCK TABLE stzderec IN SHARE ROW EXCLUSIVE MODE");
    $nombre = str_replace("'","´",$nombre);
    $nombre = stripslashes($nombre);    
   
    $tramitante = str_replace("'","´",$tramitante);
    $update_str = "fecha_solic='$fecha_solic',tipo_derecho='$tipo_marca',nombre='$nombre',
    poder='$vpoder',agente=$vcodage,tramitante='$tramitante',pais_resid='$input2'";
    $updderecho = $sql->update("$tbname_6","$update_str","nro_derecho='$vder'");
    //Actualizacion del resto de los daros de la maestra de marcas 
    $vdis = str_replace("'","´",$distingue);
    $vdis = stripslashes($distingue);
    pg_exec("LOCK TABLE stmmarce IN SHARE ROW EXCLUSIVE MODE");
    $update_str = "clase=$vclase,ind_claseni='I',modalidad='$modalidad',distingue='$vdis'";
    $updmarce = $sql->update("$tbname_4","$update_str","nro_derecho='$vder'");

    //Actualizacion de la maestra de eventos de tramite
    $update_str = "fecha_event='$fecha_solic'";
    $updtramite = $sql->update("$tbname_5","$update_str","nro_derecho='$vder' AND evento=1200");

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
      $veti = str_replace("'","´",$etiqueta);
      $veti = stripslashes($etiqueta);      
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
    $numtitu = 0; 
    //Verificacion de si tiene Cesion o Fusion o Cambio de Titular 
    $reg_tit=pg_exec("SELECT * FROM $tbname_5 WHERE nro_derecho='$vder' AND evento IN (1204,1205,1206,1208,1209)");
    $filas_reg_eve=pg_numrows($reg_tit); 
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
        $vpdo   = $regtitu[pais_domicilio];
        $vind   = $regtitu[indole];
        $vtlf1  = $regtitu[telefono1];
        $vtlf2  = $regtitu[telefono2];
        $vfax   = $regtitu[fax];
        $vmail1 = $regtitu[email];
        $vmail2 = $regtitu[emai2];

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
    
    //$res_titu=pg_exec("SELECT * FROM $tbname_9 where solicitud='$varsol' AND tipo_mp='M'");
    //$filas_res_titu=pg_numrows($res_titu); 
    //$regtitu = pg_fetch_array($res_titu);

    //$numtitu = 0; 
    //$ins_solic = true;
    //$ins_titur = true; 
    //$del_datos = $sql->del("$tbname_7","nro_derecho='$vder'");
    //for($i=0;$i<$filas_res_titu;$i++) 
    //{ 
    // if ($regtitu[titular]=="0")
    //   {
    //     $col_campos = "titular,identificacion,nombre,indole,telefono1,telefono2,fax,email";
    //     $vident = $regtitu[identificacion];
    //     $vnombret = str_replace("'","´",$regtitu[nombre]);
    //     $insert_str = "nextval('stzsolic_titular_seq'),'$regtitu[identificacion]','$vnombret','$regtitu[indole]','$regtitu[telefono1]','$regtitu[telefono2]','$regtitu[fax]','$regtitu[email]'";
    //     $ins_solic = $sql->insert("$tbname_3","$col_campos","$insert_str","");

    //     $obj_query = $sql->query("select last_value from stzsolic_titular_seq");
    //     $objs = $sql->objects('',$obj_query);
    //     $act_titular = $objs->last_value;
    //     $vdom = str_replace("'","´",$regtitu[domicilio]);

    //     $col_campos = "nro_derecho,titular,nacionalidad,domicilio";
    //     $insert_str = "'$vder','$act_titular','$regtitu[nacionalidad]','$vdom'";
    //     $ins_titur = $sql->insert("$tbname_7","$col_campos","$insert_str","");
    //     if ($ins_solic AND $ins_titur) { }
    //     else { $numtitu = $numtitu + 1; }  
    //   }
    // else
    //   {
    //     $obj_query = $sql->query("SELECT * FROM $tbname_7 where nro_derecho='$vder' and titular='$regtitu[titular]'");
    //     if (!$obj_query) { 
    //       Mensajenew("Problema al intentar realizar la consulta en la tabla $tbname_7 ...!!!","javascript:history.back();","N");
    //       $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
    //     $filas_titular=$sql->nums('',$obj_query);
    //     if ($filas_titular==0) {
    //       $col_campos = "nro_derecho,titular,nacionalidad,domicilio";
    //       $insert_str = "'$vder','$regtitu[titular]','$regtitu[nacionalidad]','$regtitu[domicilio]'";
    //       $ins_titur = $sql->insert("$tbname_7","$col_campos","$insert_str","");
    //       if ($ins_titur) { }
    //       else { $numtitu = $numtitu + 1; }  
    //     } 
    //   }
    // $regtitu = pg_fetch_array($res_titu);
    //}
    //$del_datos = $sql->del("$tbname_9","solicitud='$varsol' AND tipo_mp='M'");

    if ($numtitu==0 AND $numccv==0 AND $inslema AND $inslogo AND 
        $numprio==0 AND $numagen==0 AND $updmarce AND $updderecho AND $updclanac AND $updtramite) {
      pg_exec("COMMIT WORK");
      //Desconexion de la Base de Datos
      $sql->disconnect();

      Mensajenew("DATOS GUARDADOS CORRECTAMENTE ...!!!","m_manteni.php?vopc=4&nconexion=".$nconexion."&nveces=".$nveces,"S");
      $smarty->display('pie_pag.tpl'); exit();
    } 
    else {
      pg_exec("ROLLBACK WORK");
      //Desconexion de la Base de Datos
      $sql->disconnect();

      if (!$inslema)    { $error_lem = " - Lema "; }
      if (!$inslogo)    { $error_log = " - Descripcion del Logo "; }
      if (!$updmarce)   { $error_mar = " - Marcas "; }
      if (!$updderecho) { $error_der = " - Derecho "; }
      if (!$updtramite) { $error_tra = " - Tramite "; }
      if ($numtitu!=0)  { $error_tit = " - Titular(es) "; }
      if ($numccv!=0)   { $error_ccv = " - Clasificacion Vienna "; }
      if ($numprio!=0)  { $error_pri = " - Prioridad "; }
      if ($numagen!=0)  { $error_age = " - Agente(s) "; }
      if (!$updclanac)  { $error_cla = " - Clase Nacional "; } 
            
      Mensajenew("Falla de Actualizaci&oacute;n / Inserci&oacute;n de Datos en la BD $error_lem, $error_log, $error_pri, $error_age, $error_mar, $error_der, $error_tit, $error_ccv, $error_cla, $error_tra ...!!!","javascript:history.back();","N");
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
  $nameimage="imagenes/sin_imagen8.png";
  $smarty->assign('nameimage',$nameimage);
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
  $nameimage="../imagenes/sin_imagen8.png";
}

//Pase de variables y Etiquetas al template
$smarty->assign('campo1','Expediente No.:');
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
$smarty->assign('campo20','Clase Nacional:');

if ($vopc==1) {
  $smarty->assign('subtitulo','Mantenimiento de Expediente / Modificaci&oacute;n'); 
  $smarty->assign('varfocus','formarcas2.fecha_solic');
  $smarty->assign('submitbutton','button');
  $smarty->assign('modalidad','N'); 
  $smarty->assign('tipo_marca','V');
  $smarty->assign('modalidad',$modalidad);
  $smarty->assign('tipo_marca',$tipo_marca);
 }

if ($vopc==2) {
  $smarty->assign('varfocus','formarcas1.vsol1'); 
  $smarty->assign('modo',''); 
  $smarty->assign('psoli',$vsol); 
  $smarty->assign('submitbutton','submit');
  $smarty->assign('modalidad',$modalidad);
  $smarty->assign('tipo_marca',$tipo_marca); }

$smarty->assign('vder',$vder);
$smarty->assign('usuario',$usuario);
$smarty->assign('role',$role);
$smarty->assign('arraycodpais',$arraycodpais);
$smarty->assign('arraynompais',$arraynompais);
$smarty->assign('vcodage',$vcodage);
$smarty->assign('vcodpais',$vcodpais);
$smarty->assign('nameimage',$nameimage);
$smarty->assign('vsol1',$vsol1);
$smarty->assign('vsol2',$vsol2);
$smarty->assign('varsol',$varsol);
$smarty->assign('dirano',$dirano);
$smarty->assign('nombre',$nombre);
$smarty->assign('clase_id',$clase_id);
if ($clase_id=='I') { $smarty->assign('vclase',$vclase); $smarty->assign('vclnac',$vclnac); }
else { $smarty->assign('vclnac',$vclase); }
//$smarty->assign('vclase',$vclase);
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
$smarty->assign('nconexion',$nconexion); 
$smarty->assign('nveces',$nveces);  

$smarty->display('m_manteni.tpl');
$smarty->display('pie_pag.tpl');
?>
