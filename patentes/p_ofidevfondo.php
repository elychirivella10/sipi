<script language="Javascript"> 

function pregunta() { 
  return confirm('Estas seguro de grabar la Informacion ?'); }

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
// Programa: p_ofidevfondo.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Dirección de Sistemas y Tecnologias de la Información / SAPI / MPPCN
// Desarrollado Año: 2022
// *************************************************************************************

//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");
//Clase que sube un archivo de imagen
include ("$include_lib/upload_class.php"); 

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variables
$usuario = trim($_SESSION['usuario_login']);
$sql     = new mod_db();
$fecha   = fechahoy();
$modulo  = "p_modtitular.php";

$tbname_1  = "stzpaisr";
$tbname_2  = "stpdvfondo";
$tbname_3  = "stzsolic";  
$tbname_4  = "stppatee";
$tbname_5  = "stzevtrd";
$tbname_6  = "stzderec";
$tbname_7  = "stzottid";
$tbname_8  = "stzevder";
$tbname_10 = "stzusuar";

$vopc     = $_GET['vopc'];

$vsol1 = $_POST['vsol1'];
$vsol2 = $_POST['vsol2'];

$fecha_solic = $_POST['fecha_solic'];
$tipo_marca  = $_POST['tipo_marca'];
$nombre = $_POST['nombre'];
$motivo = $_POST['motivo'];
$vder   = $_POST['vder'];
$nbol   = $_POST['boletin'];

// ************************************************************************************  
$smarty->assign('titulo',$substpat);
$smarty->assign('subtitulo','Oficio de DEVOLUCI&Oacute;n de FONDO de Patente'); 
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

if (($usuario=='ngonzalez') || ($usuario=='rmendoza')) { }
else {
  Mensajenew("ERROR: Usuario NO tiene Permiso para este modulo ...!!!","../index1.php","N");
  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();
}

$smarty->assign('arraytipom',array(V,A,B,C,D,E,F,G));
$smarty->assign('arraynotip',array('','INVENCION','DIBUJO INDUSTRIAL','MEJORA','INTRODUCCION','MODELO INDUSTRIAL','MODELO DE UTILIDAD','DISEÑO INDUSTRIAL'));

// ************************************************************************************  

//Opcion Modificar
if ($vopc==1) {
  $smarty->assign('modo1','disabled'); 
  $smarty->assign('vmodo',''); 
  $smarty->assign('modo',''); 
  $smarty->assign('modo2',''); 
  $smarty->assign('modo3',''); 
  //$smarty->assign('accion',2);
  $fechahoy = hoy();
  
  //Armado del Numero de Expediente
  $varsol=$vsol1."-".sprintf("%06d",$vsol2);
  //Variable Numero del Expediente
  $numero=substr($varsol,-6,6);
  
  //Verificando conexion
  $sql->connection($usuario);
  
  $resultado=pg_exec("SELECT * FROM $tbname_6 WHERE solicitud='$varsol' AND tipo_mp='P'");
  if (!$resultado) { 
     mensajenew("ERROR: PROBLEMA AL PROCESAR LA BUSQUEDA ...!!!","p_ofidevfondo.php?vopc=4","N");
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  }	 
  $filas_found=pg_numrows($resultado); 
  if ($filas_found==0) {
     mensajenew("ERROR: NO EXISTEN DATOS ASOCIADOS ...!!!","p_ofidevfondo.php?vopc=4","N");
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  }	 
  $reg = pg_fetch_array($resultado);

  $vder    = $reg['nro_derecho'];  
  $vsol    = $reg['solicitud'];
  $varsol  = $vsol; 
  $vsol1   = substr($vsol,-11,4);
  $vsol2   = substr($vsol,-6,6);
  $estatus = $reg['estatus'];

  $nombre=trim($reg['nombre']);
  $nombre = str_replace("'","´",$nombre);
  $tipo_marca=$reg['tipo_derecho'];
  $fecha_solic=$reg['fecha_solic'];
  $nagen=$reg['agente'];
  $poder=$reg['nro_poder'];

  if ($estatus!=2008) {
     mensajenew("ERROR: Solicitud en Estatus NO adecuado para Devolver en Fondo ...!!!","p_ofidevfondo.php?vopc=4","N");
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  }	 

  $gestor = agente_tramp($nagen,trim($reg[tramitante]),$poder);    

  $res_estatus=pg_exec("SELECT * FROM stzstder WHERE estatus='$estatus'");
  $restat = pg_fetch_array($res_estatus);
  $vestatus = $estatus." - ".$restat['descripcion'];
  
  $resumen='';
  //Obtención de datos de la Patente 
  $obj_query = $sql->query("SELECT * FROM $tbname_4 WHERE nro_derecho='$vder'");
  $objs = $sql->objects('',$obj_query);
  $resumen = trim($objs->resumen);

  $nameimage="../imagenes/sin_imagen8.png";
  //else {   $nameimage = "../graficos/marcas/ef".$vsol1."/".$vsol1.$vsol2.".jpg"; }

  if (!file_exists($nameimage)) {
    $nameimage="../imagenes/sin_imagen8.png"; }

  $smarty->assign('ubicacion',$nameimage);
 
  //$auxnum = $vsol1;
  //$smarty->assign('auxnum',$auxnum);

  // Obtencion de Inventores  
  $obj_query = $sql->query("SELECT * FROM stpinved WHERE nro_derecho='$vder' ORDER BY nombre_inv");
  $filas_found=$sql->nums('',$obj_query);
  $objs = $sql->objects('',$obj_query);
  for($cont=0;$cont<$filas_found;$cont++) { 
     $datain[$cont][0]=$objs->nombre_inv;
     $res_pais=pg_exec("SELECT * FROM stzpaisr WHERE pais='$objs->nacionalidad'");
     $respainac = pg_fetch_array($res_pais);
     $datain[$cont][1]=$objs->nacionalidad." - ".$respainac['nombre'];
     $objs = $sql->objects('',$obj_query); 
  }
  $smarty->assign('custidinv',$datain); 

  // Obtencion del o los Titular(es)  
  $obj_query = $sql->query("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio, stzottid.pais_domicilio, stzsolic.indole, stzsolic.identificacion
       FROM stzottid, stzsolic,stppatee WHERE stzottid.nro_derecho='$vder'
			                AND stppatee.nro_derecho=stzottid.nro_derecho
                                        AND stzsolic.titular = stzottid.titular");
  $obj_filas = $sql->nums('',$obj_query);
  $objs = $sql->objects('',$obj_query);
  for ($contobj=0;$contobj<$obj_filas;$contobj++) {
     $datat[$contobj][0]=$objs->titular;
     $datat[$contobj][1]=$objs->nombre;
     $datat[$contobj][2]=trim($objs->domicilio);
     $res_pais=pg_exec("SELECT * FROM stzpaisr WHERE pais='$objs->pais_domicilio'");
     $respaidom = pg_fetch_array($res_pais);
     $datat[$contobj][3]=$objs->pais_domicilio." - ".$respaidom['nombre'];
     $res_pais=pg_exec("SELECT * FROM stzpaisr WHERE pais='$objs->nacionalidad'");
     $respainac = pg_fetch_array($res_pais);
     $datat[$contobj][4]=$objs->nacionalidad." - ".$respainac['nombre'];
     $datat[$contobj][5]=$objs->identificacion;
     $objs = $sql->objects('',$obj_query); 
  }	  
  $smarty->assign('custidtit',$datat); 

  // Obtencion de la Cronologia  
  $obj_query = $sql->query("SELECT * FROM stzevtrd WHERE nro_derecho='$vder' order by fecha_event,secuencial");
  $filas_found=$sql->nums('',$obj_query);
  $objs = $sql->objects('',$obj_query);
  for($cont=0;$cont<$filas_found;$cont++) { 
     $data[$cont][0]=$objs->fecha_event;
     $data[$cont][1]=$objs->evento-2000;
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
if ($vopc==2)  {
  $estatus= $_POST['estatus'];

  //La Fecha de Hoy y Hora para la transaccion
  $fechahoy = hoy();
  $horactual= Hora();

  //Verificando conexion
  $sql->connection($usuario);

  //Validacion del Numero de Solicitud
  if (!empty($vsol1) && !empty($vsol2)) { 
      $varsol=$vsol1."-".sprintf("%06d",$vsol2); } 
  else {
    mensajenew("ERROR: Numero de Solicitud Vacio ...!!!","p_ofidevfondo.php?vopc=4","N");
    $smarty->display('pie_pag.tpl'); exit(); }
  
  //$varsol = sprintf("%02d-%06d",$vsol1,$vsol2);
  $motivo = str_replace("'","´",$motivo);
  $motivo = stripslashes($motivo);

  if (empty($motivo)) {
    mensajenew("Motivo de la Devolucion Vacio ...!!!","p_ofidevfondo.php?vopc=4","N");
    $smarty->display('pie_pag.tpl'); exit(); }

  $evento1 = 2053;
  $comentario53 = "";
  //busqueda de evento 53
  $obj_query = $sql->query("SELECT * FROM $tbname_8 WHERE evento='$evento1'");
  $objs = $sql->objects('',$obj_query1);
  $mensa_automatico53 = trim($objs->mensa_automatico); 
  $tipo_evento = $objs->tipo_evento;

  if ($tipo_evento == "M") {
    //Validacion adicional por si acaso otro usuario cambia la solicitud
    $resulsol=pg_exec("SELECT * FROM $tbname_6 WHERE nro_derecho='$vder' AND tipo_mp='P'");
    $regsol = pg_fetch_array($resulsol);
    $vest   = $regsol[estatus];
    $restfin= estatus_final($evento1,$vest,"P");
    if (!empty($restfin)) { //Esta bien
    } else {
        $smarty->display('encabezado1.tpl');
        mensajenew('ERROR: La solicitud ha sido modificada por otro usuario','p_ofidevfondo.php?vopc=4','N');
    	   $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
      }
  }

  //Comienzo de Transaccion 
  pg_exec("BEGIN WORK");

  $numinsert = 0;
  $instram = true;
  //Inserto Datos en la tabla de Tramite stzevtrd evento 53
  $col_campos = "nro_derecho,evento,fecha_event,secuencial,estat_ant,fecha_trans,usuario,desc_evento,documento,comentario,hora";
  $insert_str = "$vder,$evento1,'$fechahoy',nextval('stzevtrd_secuencial_seq'),'$estatus','$fechahoy','$usuario','$mensa_automatico53',0,'$comentario53','$horactual'"; 
  $instram = $sql->insert("$tbname_5","$col_campos","$insert_str","");
  if ($instram) { }
    else { $numinsert = $numinsert + 1; }  
      
  $actestat = true;
  //Actualizo la maestra en estatus a 103 
  $update_str = "estatus='$restfin'";
  $actestat = $sql->update("stzderec","$update_str","nro_derecho=$vder");
  if ($actestat) { }
    else { $numinsert = $numinsert + 1; }  

  //Inserto Motivo de Fondo 
  $insfondo = true;  
  $insert_str = "$vder,'$motivo','$nbol'";
  $insfondo = $sql->insert("$tbname_2","","$insert_str","");
  if ($insfondo) { }
    else { $numinsert = $numinsert + 1; }  
  
  /*
    //Actualizacion de la maestra principal 
    pg_exec("LOCK TABLE stpdvfondo IN SHARE ROW EXCLUSIVE MODE");
    $motivo = str_replace("'","´",$motivo);
    $motivo = stripslashes($motivo);
    //$update_str = "motivo='$motivo',boletin='$nbol'";
    //$upddevol = $sql->update("$tbname_2","$update_str","nro_derecho='$vder'");
  */
  
  if ($numinsert==0) {
    pg_exec("COMMIT WORK");
    //Desconexion de la Base de Datos
    $sql->disconnect();

    Mensajenew("DATOS GUARDADOS CORRECTAMENTE ...!!!","p_ofidevfondo.php?vopc=4","S");
    $smarty->display('pie_pag.tpl'); exit();
  } 
  else {
    pg_exec("ROLLBACK WORK");
    //Desconexion de la Base de Datos
    $sql->disconnect();

    Mensajenew("Falla de Actualizaci&oacute;n de Datos en la BD ...!!!","p_ofidevfondo.php?vopc=4","N");
    $smarty->display('pie_pag.tpl'); exit();
  }
 
}

// ************************************************************************************  
if (($vopc!=1) && ($vopc!=2) && ($vopc!=3) && ($vopc!=4)) {
  $smarty->assign('modo1',''); 
  $smarty->assign('modo2','disabled'); 
  $smarty->assign('modo3','disabled'); 
  $smarty->assign('vmodo','readonly=readonly'); 
  $smarty->assign('modo','readonly=readonly'); 
}

// ************************************************************************************  
if ($vopc==4) {
  $smarty->assign('varfocus','formarcas1.vsol1'); 
  $smarty->assign('modo1','disabled'); 
  $smarty->assign('modo2','disabled'); 
  $smarty->assign('modo3','disabled'); 
  $smarty->assign('vmodo',''); 
  $smarty->assign('modo','readonly=readonly'); 
  $nameimage="../imagenes/sin_imagen8.png";
}

// ************************************************************************************  
if ($vopc==1) {
  $smarty->assign('varfocus','formarcas2.fecha_solic');
  $smarty->assign('tipo_marca','V');
  $smarty->assign('modo','readonly=readonly'); 
  $smarty->assign('modo1','disabled'); 
  $smarty->assign('tipo_marca',$tipo_marca);
 }

// ************************************************************************************  
if ($vopc==2) {
  $smarty->assign('varfocus','formarcas1.vsol1'); 
  $smarty->assign('modo',''); 
  $smarty->assign('tipo_marca',$tipo_marca); }

// ************************************************************************************  
//Pase de variables y Etiquetas al template
$smarty->assign('campo1','Hacer Publicada en el Boletin No.:');
$smarty->assign('campo2','Fecha Expediente:');
$smarty->assign('campo3','Tipo de Patente:');
$smarty->assign('campo4','Titulo:');
$smarty->assign('campo5','Tramitante/Agente:');
$smarty->assign('campo6','Estatus:');

$smarty->assign('vopc',$vopc);
$smarty->assign('usuario',$usuario);
$smarty->assign('vder',$vder);
$smarty->assign('nameimage',$nameimage);
$smarty->assign('vsol1',$vsol1);
$smarty->assign('vsol2',$vsol2);
$smarty->assign('varsol',$varsol);
$smarty->assign('nombre',$nombre);
$smarty->assign('fecha_solic',$fecha_solic);
$smarty->assign('tramitante',$gestor);
$smarty->assign('estatus',$estatus);
$smarty->assign('vresumen',$resumen);
$smarty->assign('n_solic',$varsol);

$smarty->display('p_ofidevfondo.tpl');
$smarty->display('pie_pag.tpl');
?>
