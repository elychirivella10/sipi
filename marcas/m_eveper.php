<script language="Javascript"> 

function pregunta() { 
  return confirm('Estas seguro de grabar la Informacion ?'); }

function buscarprensa(var1,var2,var3,var4,var5) {
  open("adm_prensa.php?vsol="+var1.value+"-"+var2.value+"&vmod="+var3.value+"&vcod="+var4.value+"&evto="+var5.value,"Ventana", "scrollbars=yes,toolbar=no,directories=no,menubar=no,status=no"); }

 
</script>
<?php
// *************************************************************************************
// Programa: m_eveper.php 
// Realizado por el Analista de Sistema  Karina Pérez
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MILCO
// Año 2010
// *************************************************************************************


//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

//Clase que sube el archivo
include ("$include_lib/upload_class.php");

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado"; exit();}

//Variables
$usuario   = trim($_SESSION['usuario_login']);
$role      = $_SESSION['usuario_rol'];
$fecha     = fechahoy();
$fechahoy  = hoy();
$sql = new mod_db();
$tbname_1  = "stmmarce";
$tbname_2  = "stzevder";
$tbname_3  = "stzstder";
$tbname_4  = "stzevtrd";
$tbname_5  = "stzmigrr";
$tbname_6  = "stzsystem";
$tbname_7  = "stzderec";

$vopc      = $_GET['vopc'];
$tipo      = $_POST['tipo'];
$fechaper  = $_POST['fechaper'];
$vpag      = $_POST['vpag'];
$ubicacion = $_POST['ubicacion'];

$vsola=$vsol1."-".sprintf("%06d",$vsol2);
$vsolb=$vsol3."-".sprintf("%06d",$vsol4);
$resultado=false;

$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Actualizacion de Expedientes por Aviso en Prensa');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');
$smarty->assign('varfocus','formarcas1.vsol1'); 
$smarty->assign('modo2','readonly');

if (($usuario!='rmendoza')) {
  mensajenew('AVISO: Usuario NO Autorizado para usar esta Opci&oacute;n del Sistema ...!!!','javascript:history.back();','N');
  $smarty->display('pie_pag.tpl'); exit();
}

//Verificando conexion
$sql->connection($usuario);

//Carga el tipo de marca para mostrarlo en el combo
 $blanco='';
 $arraytipo[0]='';
 $arraytipo[1]='Ultimas Noticias';
 $arraytipo[2]='Diario Vea';
 $arraytipo[3]='Ciudad Caracas';

 if ($vopc==4) {
  //Se obtiene el proximo valor para el secuencial a guardara partir de stzsistem
  $sys_actual = next_sys("nprensa");
  $vsecuencial = grabar_sys("nprensa",$sys_actual);
  $nprensa=$vsecuencial;
}   
   
 if ($vopc==2) {
   //Validacion de los campos
    //echo "diario= $tipo";
    if (empty($tipo) ) {
      mensajenew('ERROR: No introdujo el Nombre de la Prensa ...!!!','javascript:history.back();','N');
      $smarty->display('pie_pag.tpl'); exit(); }
    if (empty($fechaper) ) {
      mensajenew('ERROR: No introdujo la Fecha de Prensa ...!!!','javascript:history.back();','N');
      $smarty->display('pie_pag.tpl'); exit(); }
      
$fec_hoy = hoy();
$rev_fecha = Convertir_en_fecha($fechaper,0);
$esmayor=compara_fechas($rev_fecha,$fec_hoy);
if ($esmayor==1) {
     $smarty->display('encabezado1.tpl');
     mensajenew('AVISO: NO se pueden ejecutar eventos a Futuros ...!!!','javascript:history.back();','N');
     $smarty->display('pie_pag.tpl'); exit();  } 
      
    if (empty($vpag) ) {
      mensajenew('ERROR: No introdujo el Numero de la Pagina ...!!!','javascript:history.back();','N');
      $smarty->display('pie_pag.tpl'); exit(); }
         
   //Nombre de la Imagen de Prensa 
   $dia = substr($fechaper, 0, 2);
   $mes = substr($fechaper, 3, 2);
   $ano = substr($fechaper, 6, 4);
   $fecha = $dia.$mes.$ano;
            
    $vnewnombre= "mar_".$tipo."_".$fecha."_".$vpag;

    //Variable para la busqueda de la imagen en busqueda
    $ruta= "../graficos/prensa/";
    $archivo = trim($_FILES['ubicacion']['name']);
 
    if (!empty($archivo)) {
       //Copiar archivo de logotipo en ruta final
       $max_size = 50; // the max. size for uploading	
       $my_upload = new file_upload;
       //$my_upload->upload_dir = "/var/www/sistemas/imagenes/temp/"; // "files" is the folder for the uploaded files (you have to create this folder)
       $my_upload->upload_dir = $ruta; // "files" is the folder for the uploaded files (you have to create this folder)
       $my_upload->extensions = array(".pdf"); // specify the allowed extensions here
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
       //   echo "estoy en el primer else : $tipo";
       //   echo "ruta: $ruta";
          
	  //Mensage_Error($my_upload->show_error_string());
          mensajenew($my_upload->show_error_string(),"javascript:history.back();","N");
          $smarty->display('pie_pag.tpl'); 
	  exit(); }
    }
    else {
       //echo "estoy en el 2do else : $tipo";
       mensajenew('ERROR: Imagen aun NO seleccionada ...!!!','javascript:history.back();','N');
       $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();
    }
  
   $instram  = true;
   $actestat = true;
   $vcod=$_POST['nprensa'];

   $resultado=pg_exec("SELECT c.solicitud, b.nro_derecho, b.estatus FROM stzderec b, stzprensa c
			   WHERE c.nprensa = $vcod AND
                           c.solicitud = b.solicitud AND
                           b.tipo_mp='M' ");
   $filas_found=pg_numrows($resultado);    

   if ($filas_found == 0) {
      mensajenew('ERROR: No introdujo ningún valor de Expediente asociados a la Prensa ...!!!','javascript:history.back();','N');
      $smarty->display('pie_pag.tpl'); exit(); }

   //busqueda de evento 22
   $resul=pg_exec("SELECT * FROM $tbname_2 WHERE evento='1022'");
   $filas_f = pg_numrows($resul); 
   $regeve  = pg_fetch_array($resul);
   $mensa_automatico=trim($regeve['mensa_automatico']);
    
   $resultado=pg_exec("SELECT c.solicitud, b.nro_derecho, b.estatus FROM stzderec b, stzprensa c
			   WHERE c.nprensa = $vcod AND
                           c.solicitud = b.solicitud AND
                           b.tipo_mp='M' AND
                           c.evento='1022'");
   $filas_found=pg_numrows($resultado);    
                       
   $errorgrabar = 0;
   for ($cont=0;$cont<$filas_found;$cont++) {     
       $reg = pg_fetch_array($resultado); 
       $horactual=hora();
       $instram = true;
       $comentario=$tipo.' Fecha: '.$fechaper.' Pag.: '.$vpag;
       $vder = $reg[nro_derecho];
       //Inserto Datos en la tabla de Tramite stzevtrd
       $col_campos = "nro_derecho,evento,fecha_event,secuencial,estat_ant,fecha_trans,usuario,desc_evento,documento,comentario,hora";
       $insert_str = "$vder,1022,'$fechaper',nextval('stzevtrd_secuencial_seq'),1004,'$fechahoy','$usuario','$mensa_automatico',0,'$comentario','$horactual'";
       $instram = $sql->insert("$tbname_4","$col_campos","$insert_str",""); 
          
       //Actualizo la maestra en estatus a 5
       $update_str = "estatus=1005";
       $actestat = $sql->update("$tbname_7","$update_str","nro_derecho=$vder");
       
       if ($instram AND $actestat) { }
       else {
         $errorgrabar = $errorgrabar+1; }
   }  
   
   
   
   //busqueda de evento 32
   $resul=pg_exec("SELECT * FROM $tbname_2 WHERE evento='1032'");
   $filas_f = pg_numrows($resul); 
   $regeve  = pg_fetch_array($resul);
   $mensa_automatico=trim($regeve['mensa_automatico']);
    
   $resultado=pg_exec("SELECT c.solicitud, b.nro_derecho, b.estatus FROM stzderec b, stzprensa c
			   WHERE c.nprensa = $vcod AND
                           c.solicitud = b.solicitud AND
                           b.tipo_mp='M' AND
                           c.evento='1032'");
   $filas_found=pg_numrows($resultado);    
                       
   $errorgrabar = 0;
   for ($cont=0;$cont<$filas_found;$cont++) {     
       $reg = pg_fetch_array($resultado); 
       $horactual=hora();
       $instram = true;
       $comentario=$tipo.' Fecha: '.$fechaper.' Pag.: '.$vpag;
       $vder = $reg[nro_derecho];
       //Inserto Datos en la tabla de Tramite stzevtrd
       $col_campos = "nro_derecho,evento,fecha_event,secuencial,estat_ant,fecha_trans,usuario,desc_evento,documento,comentario,hora";
       $insert_str = "$vder,1032,'$fechaper',nextval('stzevtrd_secuencial_seq'),1004,'$fechahoy','$usuario','$mensa_automatico',0,'$comentario','$horactual'";
       $instram = $sql->insert("$tbname_4","$col_campos","$insert_str",""); 
          
       //Actualizo la maestra en estatus a 23
       $update_str = "estatus=1023";
       $actestat = $sql->update("$tbname_7","$update_str","nro_derecho=$vder");
       
       if ($instram AND $actestat) { }
       else {
         $errorgrabar = $errorgrabar+1; }
   }     
     
   
   //busqueda de evento 33
   $resul=pg_exec("SELECT * FROM $tbname_2 WHERE evento='1033'");
   $filas_f = pg_numrows($resul); 
   $regeve  = pg_fetch_array($resul);
   $mensa_automatico=trim($regeve['mensa_automatico']);
    
   $resultado=pg_exec("SELECT c.solicitud, b.nro_derecho, b.estatus FROM stzderec b, stzprensa c
			   WHERE c.nprensa = $vcod AND
                           c.solicitud = b.solicitud AND
                           b.tipo_mp='M' AND
                           c.evento='1033'");
   $filas_found=pg_numrows($resultado);    
                       
   $errorgrabar = 0;
   for ($cont=0;$cont<$filas_found;$cont++) {     
       $reg = pg_fetch_array($resultado); 
       $horactual=hora();
       $instram = true;
       $comentario=$tipo.' Fecha: '.$fechaper.' Pag.: '.$vpag;
       $vder = $reg[nro_derecho];
       //Inserto Datos en la tabla de Tramite stzevtrd
       $col_campos = "nro_derecho,evento,fecha_event,secuencial,estat_ant,fecha_trans,usuario,desc_evento,documento,comentario,hora";
       $insert_str = "$vder,1033,'$fechaper',nextval('stzevtrd_secuencial_seq'),1004,'$fechahoy','$usuario','$mensa_automatico',0,'$comentario','$horactual'";
       $instram = $sql->insert("$tbname_4","$col_campos","$insert_str",""); 
          
       //Actualizo la maestra en estatus a 24
       $update_str = "estatus=1024";
       $actestat = $sql->update("$tbname_7","$update_str","nro_derecho=$vder");
       
       if ($instram AND $actestat) { }
       else {
         $errorgrabar = $errorgrabar+1; }
   }    
   
   
   // Verificacion y actualizacion real de los Datos en BD 
   if ($errorgrabar == 0) {    //Validacion del Numero de Solicitud
         pg_exec("COMMIT WORK");
         //Desconexion de la Base de Datos
         $sql->disconnect();
         Mensajenew('DATOS GUARDADOS CORRECTAMENTE!!!','m_eveper.php?vopc=4','S');
         $smarty->display('pie_pag.tpl'); exit();
   }
   else {
        pg_exec("ROLLBACK WORK");
        //Desconexion de la Base de Datos
        $sql->disconnect();
        if (!$actestat) { $error_pri  = " - Maestra "; } 
        if (!$instram)  { $error_tra  = " - Tr&aacute;mite "; }
        Mensajenew("Falla de Actualizaci&oacute;n / Inserci&oacute;n de Datos en la BD $error_pri $error_tra  ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit();
   }
    
 }

//Paso de variables de datos
$smarty->assign('arraytipo',$arraytipo);
$smarty->assign('tipo_id',0);

//Pase de variables y Etiquetas al template
$smarty->assign('submitbutton','submit'); 
$smarty->assign('submitbutton1','button'); 

$smarty->assign('campo1','Peri&oacute;dico:');
$smarty->assign('campo2','Fecha de Publicaci&oacute;n:');
$smarty->assign('campo3','N&uacute;mero de Pagina:');
$smarty->assign('campo4','No. Control :');
$smarty->assign('campo5','Imagen Escaneada del Peri&oacute;dico:');
$smarty->assign('usuario',$usuario);
$smarty->assign('role',$role);
$smarty->assign('tipo',$tipo);
$smarty->assign('fechaper',$fechaper);
$smarty->assign('vpag',$vpag); 
$smarty->assign('fechat',$fechat); 
$smarty->assign('fechaeven',$fechaeven); 
$smarty->assign('nprensa',$nprensa); 

$smarty->display('m_eveper.tpl');
$smarty->display('pie_pag.tpl');

?>
