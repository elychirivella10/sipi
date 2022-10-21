<?php
// *************************************************************************************
// Programa: m_upimgbol.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Año: II Semestre 2009
// *************************************************************************************
    
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");
//Clase que sube el archivo
include ("$include_lib/upload_class.php"); 
    
?>

<script language="Javascript"> 

function pregunta() { 
  return confirm('Estas seguro de grabar la Informacion ?'); }

</script> 

<?php     

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variables
$usuario = $_SESSION['usuario_login'];


//Variables
$fecha    = fechahoy();
$vopc     =$_GET['vopc'];
$vsol     =$_POST['vsol'];
$accion   =$_POST['accion'];
$nameimage=$_POST['nameimage'];
$ubicacion=$_POST['ubicacion'];

// ****************************************
$smarty->assign('titulo',$substmar);
if (($vopc!=1) && ($vopc!=3) && ($vopc!=4)) {
  $smarty->assign('subtitulo','Mantenimiento de Imagen Presentadas/ Envio al Servidor'); 
}

$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
if (empty($vopc) or ($vopc==1)) {
  $smarty->display('encabezado1.tpl'); }

//echo "Ruta=$ubicacion "; 

//Opcion Grabar...
if ($vopc==2) {
  $smarty->assign('subtitulo','Mantenimiento de Imagen Fondo/ Envio al Servidor'); 
  $smarty->display('encabezado1.tpl');

  //Verificacion de que los campos requeridos esten llenos...
  //if (empty($ubicacion)) {
  //   mensajenew('Hay Informacion basica en el formulario que esta Vacia ...!!!','m_upimgbol.php','N');
  //   $smarty->display('pie_pag.tpl'); exit(); }
      
     //$path=trim($ubicacion);
     //$directorio=dir($path);
     //while ($archivo = $directorio->read())
     //{
     //  if($archivo=="." OR $archivo=="..") {}
     //  else{
     //   echo "$archivo <br>";
     //  }
     //}
     //$directorio->close(); 

    //Variable para la busqueda de la imagen
    $fechahoy = Hoy();
    $horactual= Hora();
    $dirano = substr($vsol,-10,4); 
    $varsol=$vsol;
    //Variable para la busqueda de la imagen
    $vnewnombre=$vsol; 
    $vcarpeta="ef".$dirano."/";
    //Variable para la busqueda de la imagen en busqueda
    $ruta = "/graficos/marcas/".$vcarpeta;
    $archivo = $_FILES['ubicacion']['name'];
    $directorio = "/home/rmendoza/imagen/";
    echo "ruta= $directorio, $archivo y es=";
    $ubicacion = "/home/rmendoza/imagen/";
    print_r($_FILES);
    
    if (isset ($_FILES["ubicacion"])) { 
	   //de ser asi, para procesar los archivos subidos al servidor solo debemos recorrerlo    
	   //obtenemos la cantidad de elementos que tiene el arreglo archivos    
	   $tot = count($_FILES["ubicacion"]["name"]);
	   echo "son=$tot";  
	   //este for recorre el arreglo     
	   for ($i = 0; $i < $tot; $i++){     
		  //con el indice $i, poemos obtener la propiedad que desemos de cada archivo 
		  //para trabajar con este         
		  $tmp_name = $_FILES["ubicacion"]["tmp_name"][$i];   
		  $name = $_FILES["ubicacion"]["name"][$i]; 
		  $newfile = "apl/imagenlog/".$name;   
		  if (is_uploaded_file($tmp_name)) {      
	   	if (!copy($tmp_name,"$newfile")) {   
				print "Error en transferencia de archivo."; 
				exit();          
				} // if copy   
				} // if is_up...
  		  echo("<b>Archivo </b> $key ");     
		  echo("<br />");      
		  echo("<b>el nombre original:</b> ");     
		  echo($name);        
		  echo("<br />");      
		  echo("<b>el nombre temporal:</b> \n");       
		  echo($tmp_name);           
		  echo("<br />");      
		}     
	}   

    exit();

    if (!empty($archivo)) {
       $anterior=$ruta.$vnewnombre.".jpg";
       unlink($anterior);       
       //Copiar archivo de logotipo en ruta final
       $max_size = 1; // the max. size for uploading	
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
       if ($my_upload->upload($vnewnombre)) { echo ''; } 
       else {
	      //Mensage_Error($my_upload->show_error_string());
         mensajenew($my_upload->show_error_string(),"javascript:history.back();","N");
         $smarty->display('pie_pag.tpl'); exit(); }
    }
    else {
       mensajenew('Imagen aun NO seleccionada ...!!!','javascript:history.back();','N');
       $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();
    }       

  //} //Incluir

  // Modificar Solicitud  

  //else {
  //  //Variable para la busqueda de la imagen en busqueda
  //  //$ruta = "/var/www/sistemas/imagenes/marcas/";
  //  $ruta = "/graficos/marcas/";
  //  $archivo = $_FILES['ubicacion']['name'];
  //  if (!empty($archivo)) {
  //     $anterior=$ruta.$vsol1.".jpg";
  //     unlink($anterior);
  //     //Copiar archivo de logotipo en ruta final       
  //     $max_size = 1024*100; // the max. size for uploading	
  //     $my_upload = new file_upload;
  //     //$my_upload->upload_dir = "/var/www/sistemas/imagenes/temp/"; // "files" is the folder for the uploaded files (you have to create this folder)
  //     $my_upload->upload_dir = $ruta; // "files" is the folder for the uploaded files (you have to create this folder)
  //     $my_upload->extensions = array(".jpg", ".jpge",".png"); // specify the allowed extensions here       
  //     $my_upload->max_length_filename = 50; // change this value to fit your field length in your database (standard 100)
  //     $my_upload->rename_file = true;
  //     $my_upload->the_temp_file = $_FILES['ubicacion']['tmp_name'];
  //     $my_upload->the_file = $_FILES['ubicacion']['name'];
  //     $my_upload->http_error = $_FILES['ubicacion']['error'];    
  //     $my_upload->validateExtension();
  //     if ($my_upload->upload($vsol1)) { 
//	  echo '';		
  //     } 
  //     else {    
//	  //Mensage_Error($my_upload->show_error_string());
 //         mensajenew($my_upload->show_error_string(),"javascript:history.back();","N");
 //         $smarty->display('pie_pag.tpl'); 
//	  exit(); }
 //   }
 // } // Modificar

  //Desconexion de la Base de Datos
  //$sql->disconnect();

  Mensajenew('DATOS GUARDADOS CORRECTAMENTE!!!','m_upimgbol.php?vopc=3','S');
  $smarty->display('pie_pag.tpl'); exit();
}

if (($vopc!=1) && ($vopc!=2) && ($vopc!=3) && ($vopc!=4)) {
  $smarty->assign('modo','readonly=readonly');
  $nameimage="../imagenes/sin_imagen.jpg";
  $smarty->assign('nameimage',$nameimage);
}

if ($vopc==3) {
  //La Fecha de Hoy para la solicitud
  $fecharec = hoy();
  $smarty->assign('subtitulo','Mantenimiento de Imagen Presentadas/ Envio al Servidor'); 
  $smarty->assign('varfocus','formarcas1.ubicacion'); 
  $smarty->assign('fecharec',$fecharec);  
  $smarty->display('encabezado1.tpl');
  $smarty->assign('accion',1);
  $nameimage="../imagenes/sin_imagen.jpg";
  $smarty->assign('nameimage',$nameimage);  
}

//Pase de variables y Etiquetas al template
$smarty->assign('campo1','Expediente No.:');

$smarty->assign('vopc',$vopc);
$smarty->assign('usuario',$usuario);
$smarty->assign('vsol',$vsol);
$smarty->assign('nameimage',$nameimage);

$smarty->display('m_upimgbol.tpl');
$smarty->display('pie_pag.tpl');
?>
