<script language="Javascript"> 

function pregunta() { 
  return confirm('Estas seguro de grabar la Informacion ?'); }

</script> 

<?php
// ************************************************************************************* 
// Programa: p_regsolp.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Creado Año 2007 
// Modificado Año: 2009 BD - Relacional 
// *************************************************************************************

//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado";
   exit();}

//Variables
$usuario = $_SESSION['usuario_login'];
$role = $_SESSION['usuario_rol'];
$sql  = new mod_db();
$fecha   = fechahoy();

$tbname_1 = "stppatee";
$tbname_2 = "stzagenr";
$tbname_3 = "stzstder";
$tbname_4 = "stzevtrd";
$tbname_5 = "stzsystem";
$tbname_6 = "stzderec";

$evento = 2795;
$vdes   = "REGISTRO DE PATENTES";

$vopc      =$_GET['vopc'];
$vsol1     =$_POST['vsol1'];
$vsol2     =$_POST['vsol2'];
$vsol      =$_POST['vsol'];
$vder      =$_POST['vder'];
$fechasolic=$_POST['fechasolic'];
$tipo_p    =$_POST['tipo_p']; 
$vfecvi    =$_POST['vfecvi'];
$vfechaven =$_POST['vfechaven'];
$pago      =$_POST['pago'];
$vest1     =$_POST['vest1'];
$tnumera   =$_POST['tnumera'];
$letrareg  =$_POST['letrareg'];

$smarty->assign('titulo',$substpat);
$smarty->assign('subtitulo','Asignacion de N&uacute;mero de Registro a Expediente');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Verificando conexion
$sql->connection($usuario);

//Se verifica si el usuario puede o no cargar el evento seleccionado
$aplica = even_rol($role,$evento);
if ($aplica==0) {
    mensajenew('AVISO: El Usuario NO tiene permiso para Asignar Registro ...!!!','../index1.php','N');
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 

/*
//$fecha = date('Y-m-d');

$nueva_fecha=date("Y-m-d",strtotime($fecha."+ 20 year"));
$fecha2= date("Y-m-d", strtotime(str_replace('/', '-',$fecha)));
$nuevafecha = strtotime ( '+16 year' , $fecha2) ;
$nuevafecha = date ( 'Y-m-d' , $nuevafecha );
//echo $fecha."<br>".$nueva_fecha; exit();
*/

if ($vopc==1) {
  //Validacion del Numero de Solicitud
  if (empty($vsol1) & empty($vsol2))
   {
    mensajenew('ERROR: No introdujo ningún valor de Expediente ...!!!','p_regsolp.php','N');
    $smarty->display('pie_pag.tpl'); exit(); }

  //Armado del Numero de Expediente
  $vsol=$vsol1."-".sprintf("%06d",$vsol2);
  $dirano=$vsol1;
  $numero=sprintf("%06d",$vsol2);
  //Variable para la busqueda de la imagen
  $varsol=$dirano.substr($vsol,-6,6);
  //Nombre de la Imagen del Expediente 
  $nameimage="../imagenes/SAPI_Logo.jpg";
  $resultado=pg_exec("SELECT * FROM $tbname_6 WHERE solicitud='$vsol' AND solicitud!='' AND tipo_mp='P'");
  if (!$resultado) { 
    mensajenew('ERROR: PROBLEMA AL PROCESAR LA BUSQUEDA ...!!!','p_regsolp.php','N');
	 $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  }	 
  $filas_found=pg_numrows($resultado); 
  if ($filas_found==0) {
    mensajenew('ERROR: NO EXISTEN DATOS ASOCIADOS ...!!!','p_regsolp.php','N');
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  }	 
  $reg = pg_fetch_array($resultado);
  $vder=$reg['nro_derecho'];
  $vsol=$reg['solicitud'];
  $vsol1=substr($vsol,-11,4);
  $vsol2=substr($vsol,-6,6);
  $fechasolic=$reg['fecha_solic'];
  $vnombre=$reg['nombre'];
  $tipo_p=$reg['tipo_derecho'];
  $vcodage=$reg['agente'];
  $vtra=$reg['tramitante'];
  $vest1=$reg['estatus'];
  
  if ($vest1!=2410) {
     mensajenew('ERROR: Evento NO aplica para este Estatus o no esta definido la Migracion ...!!!','p_regsolp.php','N');
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  }
  //$nameimage="../imagenes/patentes/di".$dirano."/".$varsol.".jpg";

  switch ($tipo_p) {
      case "A":
         $tipo='INVENCION';
         $tnumera='ninvencion';
         $letrareg = "A";
         break;
      case "B":
         $tipo='DIBUJO INDUSTRIAL';
         $tnumera='ndibujo';
         $letrareg = "B";
         break;
      case "G":
         $tipo='DISEÑO INDUSTRIAL';
         $tnumera='ndiseno';
         $letrareg = "G";
         break;
      case "F":
         $tipo='MODELO DE UTILIDAD';
         $tnumera='nutilidad';
         $letrareg = "F";
         break;
      case "E":
         $tipo='MODELO INDUSTRIAL';
         $tnumera='nindustrial';
         $letrareg = "E";
         break;
  }

  // Nombre del Agente si es el caso      
  if ($vcodage!='') {
      $resulage=pg_exec("SELECT nombre FROM $tbname_2 WHERE agente=$vcodage");
      $regage = pg_fetch_array($resulage);
      $vnomage=$regage['nombre'];
      $vtra=$vcodage." - ".$vnomage;
  }
  // Descripcon del estatus 
  $vest2 = estatus($vest1);

  // Titular Actual
  $resultit=pg_exec("SELECT a.titular,b.nombre,a.nacionalidad,a.domicilio,c.nombre as nombrep 
                     FROM stzottid a, stzsolic b, stzpaisr c 
                     WHERE a.nro_derecho='$vder' and a.titular=b.titular and a.nacionalidad=c.pais");
  $regtit = pg_fetch_array($resultit);
  $vcodtit=$regtit['titular'];
  $vnomtit=$regtit['nombre'];
  $vnactit=$regtit['nacionalidad'];
  $vnadtit=$regtit['nombrep'];
  $vdomtit=$regtit['domicilio'];

  $resuleve=pg_exec("SELECT documento,fecha_event FROM stzevtrd WHERE nro_derecho='$vder' AND evento in (2122) AND estat_ant in (2101)");   
  $regconc = pg_fetch_array($resuleve);
  //$vfecvi = $regconc[fecha_event];
  $vboletin=$regconc['documento'];

  $resulbol=pg_exec("SELECT fecha_pub,fecha_vig FROM stzboletin WHERE nro_boletin='$vboletin'");   
  $regbol = pg_fetch_array($resulbol);
//  $vfecvi = $regbol['fecha_pub'];
  $vfecvi = $regbol['fecha_vig'];

  switch ($tipo_p) {
    case "A":
       $plazofecha = 20;
       break;
    case "B":
       $plazofecha = 10;
       break;
    case "E":
       $plazofecha = 10;
       break;
    case "F":
       $plazofecha = 10;
       break;
    case "G":
       $plazofecha = 10;
       break;
  }
  //$vfecvi = $fechasolic;
  //$vfechaven = calculo_fechas($vfecvi,$plazofecha,"A","/");

  /*
      $dia = strtok($vfecvi,"/");
      $mes = strtok($modo);
      $anyo = strtok($modo);
      $anno = $anyo+$plazofecha; 
      $fexplode = explode("/",$vfecvi);
      $d = $fexplode[0];
      $m = $fexplode[1];
      $a = $fexplode[2];
      $sa = $a + $plazofecha; 
      //$fecha = mktime(0,0,0,$mes,$dia,$anyo+$plazo);
      $fecha = mktime(0,0,0,$mes,$dia,$anno);
      //$fechasig=$dia."/".$mes."/".$anno;
      //$fecha1= date("d/m/Y",$fechasig);
      //echo "fecha=$dia,$mes,$anyo,$anno,$fecha,$fechasig,$fecha1";

      $fechav = date("d/m/Y",$fecha);
      $fechavencimiento = date("d/m/Y",mktime(0,0,0,$m,$d,$sa));
      $fechavencimiento = $d."/".$m."/".$sa;

      $plazofecha = 10;
      $fecha_actual = date("Y-m-d",$vfecvi);
      $nuevafecha = strtotime("+ $plazofecha year",strtotime($fecha_actual));
      $nuevafecha = date("Y-m-d",$nuevafecha);
      //echo $fechavencimiento,$nuevafecha; exit();

      $fecha_actual = date("Y-m-d");
      $dt_5AniosDespues = date('Y-m-d', strtotime('+17 year')) ; // Suma 5 años
      //Mostrar fechas
      echo $fecha_actual,$dt_5AniosDespues; exit();

      //sumo 1 año
      //echo date("d-m-Y",strtotime($fecha_actual."+ 1 year"))
      //echo date("Y-m-d",strtotime($fecha_actual."+ $plazofecha year"));
      //echo "$tipo_p,$d,$m,$a,$sa,$dia,$mes,$anyo,plazo=$plazofecha,S=$anno,V=$fecha,$fechav ---$fechavencimiento"; exit();
*/

  //$vfechaven = calculo_fechas($fechasolic,$plazofecha,"A","/");
  $pago=0;
  //echo " $vboletin,$fechasolic,$vfecvi,$vfechaven  "; exit();

}

if ($vopc==2) {
  //Verificacion de que los campos requeridos esten llenos...
  if (($vfecvi=='') || ($vsol=='') || ($vsol=='0000-000000'))
   { 
     mensajenew('ERROR: Hay Informacion en el formulario que esta Vacia ...!!!','p_regsolp.php','N');
     $smarty->display('pie_pag.tpl'); exit(); 
   }
  $numbereg = "";
  //Verificando el Numero de Expediente en Maestra de Patentes
  $obj_query = $sql->query("SELECT * FROM $tbname_6 WHERE solicitud='$vsol' AND solicitud!='' AND tipo_mp='P'");
  if (!$obj_query) { 
    mensajenew('ERROR: Problema al intentar consultar la tabla Maestra Stzderec ...!!!','p_regsolp.php','N');
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
  $filas_found=$sql->nums('',$obj_query);
  $objs = $sql->objects('',$obj_query);
  $numbereg = trim($objs->registro);
  if (!empty($numbereg)) {
    mensajenew('ERROR: Expediente ya le fue asignado Numero de Registro ...!!!','p_regsolp.php','N');
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 
  if (empty($vfecvi)) { 
    mensajenew('ERROR: La Fecha de Vigencia del Registro esta vacia ...!!!','p_regsolp.php','N');
    $smarty->display('pie_pag.tpl'); exit(); }

  //La Fecha de Hoy para la transaccion
  $fechahoy = hoy();
  $documento=0;
  $solfecha = Convertir_en_fecha($fechasolic,0);
  $esmayor=0;
  $esmayor=compara_fechas($vfecvi,$fechahoy);
  if ($esmayor==1) {
    mensajenew('Fecha de Registro NO puede ser mayor a la fecha actual ...!!!','p_regsolp.php','N');
    $smarty->display('pie_pag.tpl'); exit(); } 
  $esmayor=0;
  $esmayor=compara_fechas($solfecha,$vfecvi);
  if ($esmayor==1) {
    $smarty->display('encabezado.tpl');
    mensajenew('Fecha de Registro NO puede ser menor a la Fecha de la Solicitud ...!!!','p_regsolp.php','N');
    $smarty->display('pie_pag.tpl'); exit(); } 
  
  $fechaexito = 0;
  //$esmayor=0;
  //$fechacorte = "05/08/1992";
  //$esmayor=compara_fechas($fechacorte,$fechasolic); //($fechasolic<'05/08/1992')
  //if ($esmayor==1) {
  //  $opcion=1;     
  //  $plazofecha = 10;
  //  $vfecve= calculo_fechas($vfecvi,$plazofecha,"A","/");
  //  if ($vfechaven <= $vfecve) { $fechaexito = 0; } 
  //}
  //$esmayor=0;
  //$esmayor1=0;
  //$fechacorte = "04/08/1992";
  //$fechacorte1= "01/01/1996";
  //$esmayor=compara_fechas($fechasolic,$fechacorte);  // ($fechasolic>'04/08/1992')
  //$esmayor1=compara_fechas($fechacorte1,$fechasolic);  // ($fechasolic<='31/12/1995')
  //if (($esmayor==1) AND ($esmayor1==1)) {
  //if (($fechasolic>'04/08/1992') and ($fechasolic<'31/12/1995')) {
  //$opcion=2;
  //  switch ($tipo_p) {
  //    case "A":
  //       $plazofecha = 15;
  //       break;
  //    case "G":
  //       $plazofecha = 8;
  //       break;
  //    case "F":
  //       $plazofecha = 10;
  //       break;
  //    case "B":
  //       $plazofecha = 10;
  //       break;
  //    case "E":
  //       $plazofecha = 10;
  //       break;
  //  }
  //  $vfecve= calculo_fechas($vfecvi,$plazofecha,"A","/");
  //  if ($vfechaven <= $vfecve) { $fechaexito = 0; } 
  //}
  //$esmayor=0;
  //$esmayor1=0;
  //$fechacorte = "31/12/1995";
  //$fechacorte1= "01/12/2000";
  //$esmayor=compara_fechas($fechasolic,$fechacorte);  // ($fechasolic>'01/01/1996')
  //$esmayor1=compara_fechas($fechacorte1,$fechasolic);  // ($fechasolic<='30/11/2000')
  //if (($esmayor==1) and ($esmayor1==1)) {
//  if (($fechasolic>='01/01/1996') and ($fechasolic<='30/11/2000')) {
  //$opcion=3;
  //  switch ($tipo_p) {
  //    case "A":
  //       $plazofecha = 20;
  //       break;
  //    case "G":
  //       $plazofecha = 8;
  //       break;
  //    case "F":
  //       $plazofecha = 10;
  //       break;
  //    case "B":
  //       $plazofecha = 10;
  //       break;
  //    case "E":
  //       $plazofecha = 10;
  //       break;
  //  }
  //  $vfecve= calculo_fechas($vfecvi,$plazofecha,"A","/");
  //  if ($vfechaven <= $vfecve) { $fechaexito = 0; } 
  //}
  //$esmayor=0;
  //$fechacorte = "30/11/2000";
  //$esmayor=compara_fechas($fechasolic,$fechacorte); //($fechasolic>='01/12/2000')
  //if ($esmayor==1) {
  //  $opcion=4;
  //  switch ($tipo_p) {
  //    case "A":
  //       $plazofecha = 20;
  //       break;
  //    case "G":
  //       $plazofecha = 10;
  //       break;
  //    case "F":
  //       $plazofecha = 10;
  //       break;
  //    case "B":
  //       $plazofecha = 10;
  //       break;
  //    case "E":
  //       $plazofecha = 10;
  //       break;
  //  }
  //  $vfecve= calculo_fechas($vfecvi,$plazofecha,"A","/");
  //  if ($vfechaven <= $vfecve) { $fechaexito = 0; } 
  //}
  //echo " $tipo_p - $opcion / $solfecha - $vfecvi - $vfecve - $vfechaven ";

  if ($fechaexito==1) {
    mensajenew('ERROR: Fecha de Vencimiento Invalida ...!!!','p_regsolp.php','N');
    $smarty->display('pie_pag.tpl'); exit(); 
  }

  switch ($tipo_p) {
    case "G":
       $comentaley="Solicitud presentada como diseño industrial conforme a la legislacion vigente en ese momento";
       break;
    case "F":
       $comentaley="Solicitud presentada como modelo de utilidad conforme a la legislacion vigente en ese momento";
       break;
  }

  // Comienzo de Transaccion 
  pg_exec("BEGIN WORK");
 
  //Se obtiene el proximo valor del registro
  $vnumreg    = next_sys("$tnumera");
  $sys_actual = grabar_sys("$tnumera",$vnumreg);
 //$res_sol=pg_exec("select dsolicitud from stzsystem");
 //$reg_sol = pg_fetch_array($res_sol); 
 //$v_sol=$reg_sol[dsolicitud]+1;
 //$v_sol=str_repeat('0',6-strlen($v_sol)).$v_sol; 
 //$update_str="dsolicitud='$v_sol'";
 //$valido1 = $sql->update("stzsystem","$update_str","true");
 
  $vregis  = $letrareg.sprintf("%06d",$vnumreg);
  $vcomenta = $vregis;
  //echo "reg= $vcomenta "; exit();
  
  $upd_derec = true;
  //Se actualiza Maestra de Derecho 
  $update_str = "estatus=2555,registro='$vregis',fecha_regis='$vfecvi',fecha_venc='$vfechaven'";
  $upd_derec  = $sql->update("$tbname_6","$update_str","nro_derecho='$vder' AND tipo_mp='P'");

  /* AQUI VERIFICAR ESTO Y ACOMODARLO MPARA QUE SUME DE 10 en 10 AÑOS
  $resultado = pg_exec("UPDATE stzderec SET fecha_venc='$vfechaven' WHERE nro_derecho='$vder' AND tipo_mp='P'");
  */
  
  $ins_tram  = true;
  $horactual = hora();
  // Tabla de Eventos de Tramite
  $col_campos = "nro_derecho,evento,fecha_event,secuencial,estat_ant,fecha_venc,documento,fecha_trans,usuario,desc_evento,comentario,hora";
  $insert_str = "'$vder',$evento,'$vfecvi',nextval('stzevtrd_secuencial_seq'),'$vest1','$vfechaven','$documento','$fechahoy','$usuario','$vdes','$vregis','$horactual'";
  $ins_tram = $sql->insert("$tbname_4","$col_campos","$insert_str","");

  //echo "der=$vder,$tnumera,sys= $vnumreg,$sys_actual, update=$update_str, $insert_str"; exit();
  // Verificacion y actualizacion real de los Datos en BD 
  if ($upd_derec AND $ins_tram) {
    pg_exec("COMMIT WORK");  
    //Desconexion de la Base de Datos
    $sql->disconnect();
      
    Mensajenew('DATOS GUARDADOS CORRECTAMENTE. REGISTRO Nro: '.$vregis.' con Vencimiento el: '.$vfechaven.' ...!!!','p_regsolp.php','S');
    $smarty->display('pie_pag.tpl'); exit(); } 
  else {
    pg_exec("ROLLBACK WORK"); 
    //Desconexion de la Base de Datos
    $sql->disconnect();

    if (!$upd_derec) { $error_derec = " - Maestra de Derecho "; }
    if (!$ins_tram)  { $error_tram  = " - Tramite "; }
    
    Mensajenew("Falla de Ingreso de Datos en la BD, Transacciones Abortadas ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit();    
  }
   
}

//Pase de variables y Etiquetas al template
$smarty->assign('submitbutton','submit'); 
$smarty->assign('submitbutton1','button'); 

$smarty->assign('campo1','Expediente No.:');
$smarty->assign('campo2','Fecha Expediente:');
$smarty->assign('campo3','Tipo de Patente:');
$smarty->assign('campo4','Nombre:');
$smarty->assign('campo6','Estatus:');
$smarty->assign('campo7','Titular:');
$smarty->assign('campo8','Pais de Residencia:');
$smarty->assign('campo9','Tramitante:');
$smarty->assign('campo11','Fecha de Vigencia:');
$smarty->assign('campo12','Fecha de Vencimiento:');

if ($vopc==1) 
 { $smarty->assign('varfocus','formarcas2.vfechaven'); 
   $smarty->assign('vmodo',''); }
else 
 { $smarty->assign('varfocus','formarcas1.vsol1'); 
   $smarty->assign('vmodo','readonly'); 
 }

$smarty->assign('usuario',$vuser);
$smarty->assign('role',$role);
$smarty->assign('nameimage',$nameimage);
$smarty->assign('vsol1',$vsol1);
$smarty->assign('vsol2',$vsol2);
$smarty->assign('vsol',$vsol);
$smarty->assign('vder',$vder);
$smarty->assign('dirano',$dirano);
$smarty->assign('fechasolic',$fechasolic);
$smarty->assign('vfecvi',$vfecvi);
$smarty->assign('vnombre',$vnombre); 
$smarty->assign('vest1',$vest1); 
$smarty->assign('vest2',$vest2); 
$smarty->assign('tipo_p',$tipo_p);
$smarty->assign('tipo',$tipo);
$smarty->assign('vtra',$vtra);
$smarty->assign('vnomtit',$vnomtit);
$smarty->assign('vnactit',$vnactit);
$smarty->assign('vnadtit',$vnadtit);
$smarty->assign('tnumera',$tnumera);
$smarty->assign('letrareg',$letrareg);
$smarty->assign('vfechaven',$vfechaven);

$smarty->display('p_regsolp.tpl');
$smarty->display('pie_pag.tpl');
?>
