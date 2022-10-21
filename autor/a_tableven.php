<script language="Javascript"> 

 function pregunta() { 
    return confirm('Estas seguro de grabar la Informacion ?'); }

 function habilinf(vtipo,vcampo,vcampo1)
 {
   if (vtipo.value == "A") {
      vcampo.disabled = false;
      vcampo1.disabled = false;
      }
   if (vtipo.value == "N") {
      vcampo.value = ""; 
      vcampo.disabled = true;
      vcampo1.value = ""; 
      vcampo1.disabled = true;
      }
   if (vtipo.value == "D") {
      vcampo1.value = ""; 
      vcampo1.disabled = true;
      vcampo.disabled = false;
      }
   if (vtipo.value == "C") {
      vcampo.value = ""; 
      vcampo.disabled = true;
      vcampo1.disabled = false;
      }
 }

 function habilplz(vtipo,vcampo)
 {
   if (vtipo.value == "N") {
      vcampo.value = 0; 
      vcampo.disabled = true;
      }
   else { vcampo.value = "";
          vcampo.disabled = false; 
          }

 }
</script>

<?php
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
  echo "Acceso Denegado..."; exit(); }

//Variables
$usuario  = $_SESSION['usuario_login'];
$role     = $_SESSION['usuario_rol'];
$sql      = new mod_db();
$fecha   = fechahoy();

$vopc   = $_GET['vopc'];
$accion = $_POST['accion'];
$evento = $_POST['evento'];
$nombre = $_POST['nombre'];
$tipo_evento  = $_POST['tipo_evento'];
$inf_adicional= $_POST['inf_adicional'];
$mensa_automatico = $_POST['mensa_automatico'];
$tipo_plazo= $_POST['tipo_plazo'];
$plazo_ley = $_POST['plazo_ley'];
$evento2 = $_POST['evento2'];
$documento  = $_POST['documento'];
$comentario = $_POST['comentario'];
$aplica = $_POST['aplica'];
$vstring= $_POST['vstring'];
$campos = $_POST['campos'];

$smarty->assign('titulo','Sistema de Derecho de Autor');
$smarty->assign('subtitulo','Mantenimiento de Eventos / '.$accion); 
if ($vopc==3) {
  $smarty->assign('subtitulo','Mantenimiento de Eventos / Ingreso'); }
if ($vopc==4) {
  $smarty->assign('subtitulo','Mantenimiento de Eventos / Modificacion'); }
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

if ($vopc==1 && $accion=='Modificacion') {
  $smarty->assign('vmodo','readonly=readonly'); 
  $smarty->assign('modo',''); 
  $smarty->assign('modo2',''); 
  $smarty->assign('accion',2);
  $smarty->assign('varfocus','frmstatus2.nombre');

  //Verificando conexion
  $sql->connection();

  $resultado=pg_exec("SELECT * FROM stdevobr WHERE evento='$evento'");
  $filas_found=pg_numrows($resultado); 
  if ($filas_found==0) {
    mensajenew("NO EXISTEN DATOS ASOCIADOS ...!!!",'a_tableven.php?vopc=4',"N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  }	 
  $reg = pg_fetch_array($resultado);
  $evento=$reg[evento];
  $descripcion=trim($reg[descripcion]);
  $tipo_evento=$reg[tipo_evento];
  $inf_adicional=$reg[inf_adicional];
  $mensa_automatico=trim($reg[mensa_automatico]);
  $plazo_ley=$reg[plazo_ley];
  $tipo_plazo=$reg[tipo_plazo];
  $tit_comenta=trim($reg[tit_comenta]);
  $tit_nro_doc=trim($reg[tit_nro_doc]);
  $aplica=$reg[aplica];

  //Paso a Smarty los Valores
  $smarty->assign('evento',$evento);
  $smarty->assign('nombre',$descripcion);
  $smarty->assign('tipo_evento',$tipo_evento);
  $smarty->assign('inf_adicional',$inf_adicional);
  $smarty->assign('mensa_automatico',$mensa_automatico);
  $smarty->assign('tipo_plazo',$tipo_plazo);
  $smarty->assign('plazo_ley',$plazo_ley);
  $smarty->assign('documento',$tit_nro_doc);
  $smarty->assign('comentario',$tit_comenta);
}

if ($vopc==1 && $accion=='Ingreso') {
  $smarty->assign('vmodo','readonly=readonly'); 
  $smarty->assign('modo',''); 
  $smarty->assign('modo2',''); 
  $smarty->assign('accion',1);
  $smarty->assign('varfocus','frmstatus2.nombre');

  //Verificando conexion
  $sql->connection();

  $resultado=pg_exec("SELECT * FROM stdevobr WHERE evento='$evento'");
  $filas_found=pg_numrows($resultado);
  if ($filas_found>0) { 
    mensajenew("EL ESTATUS YA ESTA REGISTRADO...!!!",'a_tableven.php?vopc=3',"N");
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  }	 
  
  //Paso a Smarty los Valores
  $smarty->assign('evento',$evento);
  $smarty->assign('nombre',$descripcion);
  $smarty->assign('tipo_evento',$tipo_evento);
  $smarty->assign('inf_adicional',$inf_adicional);
  $smarty->assign('mensa_automatico',$mensa_automatico);
  $smarty->assign('tipo_plazo',$tipo_plazo);
  $smarty->assign('plazo_ley',$plazo_ley);
  $smarty->assign('documento',$tit_nro_doc);
  $smarty->assign('comentario',$tit_comenta);
}

if ($vopc==3) {
  $smarty->assign('varfocus','frmstatus1.evento'); 
  $smarty->assign('modo1','disabled'); 
  $smarty->assign('modo2','disabled'); 
  $smarty->assign('vmodo',''); 
  $smarty->assign('modo','readonly=readonly'); 
  $smarty->assign('accion',1);
}

if ($vopc==4) {
  $smarty->assign('varfocus','frmstatus1.evento'); 
  $smarty->assign('modo1','disabled'); 
  $smarty->assign('modo2','disabled'); 
  $smarty->assign('vmodo',''); 
  $smarty->assign('modo','readonly=readonly'); 
  $smarty->assign('accion',2);
}

//Opcion Grabar...
if ($vopc==2) {
  //Verificando conexion
  $sql->connection();

  if ($accion==1) { 
    $valor_even=$evento2; }
  else {
    $valor_even=$evento; }
  
  if ($tipo_evento=="N") { $tipo_plazo="N"; $plazo_ley=0; }
  switch ($inf_adicional) {
     case "N":
         $documento=""; $comentario="";
         break;
     case "D":
         $comentario="";
         break;
     case "C":
         $documento="";
         break;
  }

  //Verificacion de que los campos requeridos esten llenos...
  if (empty($nombre) || empty($tipo_evento) || empty($inf_adicional) || 
    empty($mensa_automatico) || empty($tipo_plazo)) {
    mensajenew("Hay Informacion basica en el formulario que esta Vacia ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }

   pg_exec("BEGIN WORK");
  //al Incluir
  if ($accion==1) {
    pg_exec("LOCK TABLE stdevobr IN SHARE ROW EXCLUSIVE MODE");
    $resultado=pg_exec("SELECT * FROM stdevobr WHERE evento='$evento'");
    $filas_found=pg_numrows($resultado); 
    if ($filas_found!=0) {
      mensajenew("Codigo de Evento YA existe en la Base de Datos ...!!!","javascript:history.back();","N");
      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 
  
    $insert_str = "$evento,'$nombre','$tipo_evento','$inf_adicional','$mensa_automatico',$plazo_ley,'$tipo_plazo','$comentario','$documento','$aplica'";
    $sql->insert("stdevobr","","$insert_str","");
  }

  //al Modificar
  if ($accion==2) {
    //La Fecha de Hoy y Hora para la transaccion
    $fechahoy = Hoy();
    $horactual= Hora();

    // Actualizo en Maestra de Eventos
    pg_exec("LOCK TABLE stdevobr IN SHARE ROW EXCLUSIVE MODE");
    $update_str = "descripcion='$nombre',tipo_evento='$tipo_evento',inf_adicional='$inf_adicional',mensa_automatico='$mensa_automatico',plazo_ley='$plazo_ley',tipo_plazo='$tipo_plazo',tit_comenta='$comentario',tit_nro_doc='$documento',aplica='$aplica'";
    $sql->update("stdevobr","$update_str","evento='$evento'");
  }

  pg_exec("COMMIT WORK");
  //Desconexion de la Base de Datos
  $sql->disconnect();

  if ($accion==1) {
    mensajenew('DATOS GUARDADOS CORRECTAMENTE !!!','a_tableven.php?vopc=3','S');
    $smarty->display('pie_pag.tpl'); exit(); }
  else {
    mensajenew('DATOS GUARDADOS CORRECTAMENTE !!!','a_tableven.php?vopc=4','S');
    $smarty->display('pie_pag.tpl'); exit(); }
}

$smarty->assign('tipo_eve',array(N,M,C));
$smarty->assign('even_def',array('No Migrable','Migrable','Cableado'));
$smarty->assign('tipo_inf',array(V,N,A,D,C));
$smarty->assign('info_def',array('','Ninguno','Ambos','Documento','Comentario'));
$smarty->assign('tipo_plz',array(V,N,H,M,A));
$smarty->assign('plazo_def',array('','Ninguno','Habiles','Mensual','Anual'));
$smarty->assign('apli_inf',array(T,R,A));
$smarty->assign('apli_def',array('Tramite','Registro','Ambos'));

$smarty->assign('campo1','Evento:');
$smarty->assign('campo2','Descripcion:');
$smarty->assign('campo3','Tipo:');
$smarty->assign('campo4','Informacion Adicional:');
$smarty->assign('campo5','Mensaje Automatico:');
$smarty->assign('campo6','Tipo Plazo:');
$smarty->assign('campo7','Plazo de Ley:');
$smarty->assign('campo8','Titulo de Documento:');
$smarty->assign('campo9','Titulo de Comentario:');
$smarty->assign('campo10','Aplica a:');
$smarty->assign('vopc',$vopc);
$smarty->assign('evento',$evento);

$smarty->display('a_tableven.tpl');
$smarty->display('pie_pag.tpl');
?>
