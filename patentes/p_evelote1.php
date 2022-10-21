<script language="Javascript"> 

function max(txarea,totalc) 
 { 
   total = totalc; 
   tam = txarea.value.length; 
   str=""; 
   str=str+tam; 
   Digitado.innerHTML = str; 
   Restante.innerHTML = total - str; 
   if (tam > total){ 
      aux = txarea.value; 
      txarea.value = aux.substring(0,total); 
      Digitado.innerHTML = total 
      Restante.innerHTML = 0 
   } 
 } 

</script> 

<?php
// *************************************************************************************
// Programa: p_evelote1.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MILCO
// Año: 2006
// Modificado Año 2009 BD - Relacional 
// *************************************************************************************
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

//Variable
$sql = new mod_db();
$tbname_1 = "stppatee";
$tbname_2 = "stzevder";
$tbname_3 = "stzstder";
$tbname_4 = "stzevtrd";
$tbname_5 = "stzmigrr";
$tbname_6 = "stzsystem";
$tbname_7 = "stzderec";

$fecha   = fechahoy();

$vsol1=$_POST['vsol1'];
$vsol2=$_POST['vsol2'];
$vsol3=$_POST['vsol3'];
$vsol4=$_POST['vsol4'];
$vuser=$_POST['vuser'];
$vsola=$_POST['vsola'];
$vsolb=$_POST['vsolb'];
$est_id1=$_POST['est_id1'];
$est_id2=$_POST['est_id2'];
$usuario=$_POST['usuario'];
$fechat1=$_POST['fechat1'];
$fechat2=$_POST['fechat2'];
$input1=$_POST['input1']; 
$input2=$_POST['input2'];
$input3=$_POST['input3'];
$input3=$_POST['input4'];
$evento_id=$_POST['evento_id'];
$evento2_id=$_POST['evento2_id'];
$vdoc=$_POST['vdoc'];
$fechapub=$_POST['fechapub'];
$fechaven=$_POST['fechaven'];
$role=$_POST['role'];
$resultado=false;

$smarty->assign('titulo',$substpat);
$smarty->assign('subtitulo','Actualizacion de Expedientes por Lotes');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Verificando conexion
$sql->connection($usuario);

//Extrae los datos del Estatus
if (!empty($est_id1)) { 
  $est_id1= $est_id1+2000;
  $nomest1 = estatus($est_id1);
  $est_id1= $est_id1-2000;  
}

if (!empty($est_id2)) { 
  $est_id2= $est_id2+2000;
  $nomest2 = estatus($est_id2); 
  $est_id2= $est_id2-2000;
}

//Extrae los datos del Evento
if (!empty($evento_id)) { 
  $evento_id = $evento_id+2000;
  $uevendesc = desc_evento($evento_id);
  $evento_id = $evento_id-2000;
}

if (!empty($evento2_id)) { 
  $evento2_id = $evento2_id+2000;
  //Se verifica si el usuario puede o no cargar el evento seleccionado
  $aplica = even_rol($role,$evento2_id);
  if ($aplica==0) {
    mensajenew('El Usuario NO tiene permiso para Cargar el Evento Seleccionado ...!!!','javascript:history.back();','N');
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 

  $resultado=pg_exec("SELECT * FROM $tbname_2 WHERE evento='$evento2_id'");
  $filas_found=pg_numrows($resultado); 
  $regeve = pg_fetch_array($resultado);
  $evendesc = trim($regeve['descripcion']);
  $tipo_evento = $regeve['tipo_evento'];
  $inf_adicional=trim($regeve['inf_adicional']);
  $mensa_automatico=trim($regeve['mensa_automatico']);
  $tit_comenta=trim($regeve['tit_comenta']);
  $tit_nro_doc=trim($regeve['tit_nro_doc']);
  $tipo_plazo=$regeve['tipo_plazo'];
  $plazo_ley=$regeve['plazo_ley'];
  $documento=0;
  $comentario='';
  
  $evento2_id = $evento2_id-2000;
  
  //Desconexion de la BD 
  $sql->disconnect();  
  
  if ($tipo_evento == "C") { 
    Mensajenew('Evento de Tipo Cableado, NO puede ser ejecutado desde esta pantalla ...!!!','p_evelote.php','N');
    $smarty->display('pie_pag.tpl'); exit(); }
}

//Pase de variables y Etiquetas al template
$smarty->assign('campo1','Rango de Expedientes:');
$smarty->assign('campo2','Evento aplicado:');
$smarty->assign('campo3','En Estatus actual:');
$smarty->assign('campo4','En Estatus anterior:');
$smarty->assign('campo5','Cargados por:');
$smarty->assign('campo6','Fecha de Transaccion:');
$smarty->assign('campo7','con Fecha de Evento:');
$smarty->assign('campo8','con Documento Nro.:');

$smarty->assign('campo9','Evento a aplicar:');
$smarty->assign('campo10','Fecha de Evento:');
$smarty->assign('campo11','Fecha de Publicacion:');
$smarty->assign('campo12','Fecha de Vencimiento:');
$smarty->assign('campo13','Comentario:');
$smarty->assign('campo14','Documento:');

$smarty->assign('usuario',$usuario);
$smarty->assign('role',$role);
$smarty->assign('vsola',$vsola);
$smarty->assign('vsolb',$vsolb);
$smarty->assign('vsol1',$vsol1); 
$smarty->assign('vsol2',$vsol2); 
$smarty->assign('vsol3',$vsol3); 
$smarty->assign('vsol4',$vsol4); 
$smarty->assign('arrayevento',$arrayevento);
$smarty->assign('arraydescri',$arraydescri);
$smarty->assign('evento_id',$evento_id);
$smarty->assign('evento2_id',$evento2_id);
$smarty->assign('arrayest1',$arrayest1);
$smarty->assign('arraynom1',$arraynom1);
$smarty->assign('arrayest2',$arrayest2);
$smarty->assign('arraynom2',$arraynom2);
$smarty->assign('input1',$input1);
$smarty->assign('input2',$input2);
$smarty->assign('input3',$input3);
$smarty->assign('input4',$input4);
$smarty->assign('est_id1',$est_id1);
$smarty->assign('est_id2',$est_id2);
$smarty->assign('evenombre',$uevendesc);
$smarty->assign('nomest1',$nomest1);
$smarty->assign('nomest2',$nomest2);
$smarty->assign('eve_nombre',$evendesc);
$smarty->assign('inf_adicional',$inf_adicional);
$smarty->assign('tipo_evento',$tipo_evento);
$smarty->assign('plazo_ley',$plazo_ley);
$smarty->assign('tipo_plazo',$tipo_plazo);
$smarty->assign('mensa_automatico',$mensa_automatico);
$smarty->assign('tit_comenta',$tit_comenta);
$smarty->assign('tit_nro_doc',$tit_nro_doc);
$smarty->assign('comentario',$comentario);
$smarty->assign('documento',$documento);
$smarty->assign('fechapub',$fechapub);
$smarty->assign('fechaven',$fechaven);

$smarty->display('p_evelote1.tpl');
$smarty->display('pie_pag.tpl');
?>
