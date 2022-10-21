<script language="javascript">
function cerrarwindows1(){
  window.opener.frames[0].location.reload();
  window.close();
}
</script>
<?php
 include ("../z_includes.php");
//Clase que sube el archivo
include ("$include_lib/upload_class.php"); 
 // ************************************************************************************* 
 // Programa: m_gbclases1.php 
 // Realizado por el Analista de Sistema Romulo Mendoza 
 // Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
 // Año: 2009 BD - Relacional
 // Modificado Año: 2012, 2013
 // *************************************************************************************
?>

<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Servicio Autonomo de la Propiedad Intelectual</title>
</head> 

<body onload="cerrarwindows1()" bgcolor="#FFFFFF"> 

<?php
//Variables   onload="cerrarwindows1()" 
$sql = new mod_db();

$tbname_1 = "stmtmpbus";
$tbname_2 = "stmcvplan";

//Verificando conexion
$sql->connection();

$vmod=$_POST["vmod"];
$vfac=$_POST["vfac"];
$vfil=$_POST["vfil"];
$vtex=trim($_POST["vtex"]);
$vtip=$_POST["vtip"];
$user=trim($_POST["vusuario"]);
$ubicacion=trim($_POST['ubicacion']);

$fechahoy = Hoy();
$horactual= Hora();
if ($vmod=='Incluir/Busqueda' || $vmod=='Grabar') {

  if ($vtip!="G") {
    if (trim($vtex)=='') { 
      //mensajenew('No ingres&oacute; el Nombre o la Denominaci&oacute;n a buscar ...!!!','javascript:history.back();','N');
      //$smarty->display('pie_pag.tpl'); 
      $sql->disconnect(); exit();
    }
  }
  //$obj_query = $sql->query("SELECT * FROM stmtmpbus WHERE nro_factura='$vfac'");
  //$obj_filas = $sql->nums('',$obj_query);
  //if ($obj_filas==0) {
  //  mensajenew('AVISO: NO ingres&oacute; b&uacute;squeda(s) Fonetica o Gr&aacute;fica ...!!!','javascript:history.back();','N');
  //  $smarty->display('pie_pag.tpl'); exit(); }
  if ($vfil==0) { 
    if ($vtip!="G") {
      $total = 47;
      for($cont=1;$cont<=$total;$cont++) { 
        $vtmp = $_POST['clase'.$cont];
        if ($vtmp=='on') {
         $vplan = trim($_POST['planilla'.$cont]);
         echo " pla= $vplan, $vnomarca, $vfac  ";
         if (($vplan!='') || ($vplan!='0')) { 
           //Verificacion que no haya cargado anteriormente la planilla con ese numero de factura
           $obj_query = $sql->query("SELECT * FROM stmtmpbus WHERE nro_factura='$vfac' AND nro_planilla='$vplan'");
           $obj_filas = $sql->nums('',$obj_query);
           if ($obj_filas==0) {
             $objquery = $sql->query("SELECT * FROM stmbusplan WHERE cod_planilla='$vplan'");
             $objfilas = $sql->nums('',$objquery);
             if ($objfilas==0) {
               $vnomarca = str_replace("'","´",$vtex);  
               $insert_val = "'$vfac',$vplan,'F','$vnomarca',$cont,'$user','$fechahoy','$horactual'";
               $sql->insert("stmtmpbus","","$insert_val","");
             }   
           }
         }  
        } else { }
      } 
    } // Busquedas Foneticas

    if (($vtip=="G") || ($vtip=="M")) {
      $total = 46;
      //$del_datos = $sql->del("stmcvplan","factura='$vfac'");
      //$ruta = "/var/www/consulta/apl/imagentemp/";
      $ruta = $imagen_temp."/";
      //$vtex = trim($_FILES['ubicacion']['name']);
      $archivo = trim($_FILES['ubicacion']['name']);
      $caracter = ".";
      $posi = strpos($archivo, $caracter);
      $vnewnombre=substr($archivo,0,$posi); 
      for($cont=1;$cont<=$total;$cont++) { 
        $vtmp = $_POST['clase'.$cont];
        if ($vtmp=='on') {
        	 $vplan = trim($_POST['planilla'.$cont]);
          echo " pla= $vplan, $vnewnombre, $vfac  ";
          if (($vplan!='') || ($vplan!='0')) {
            //Verificacion que no haya cargado anteriormente la clase con ese nombre de marca
            //$obj_query = $sql->query("SELECT * FROM stmtmpbus WHERE tipo_bus='G' AND clase=$cont AND denominacion='$archivo' AND nro_factura='$vfac'");
            $obj_query = $sql->query("SELECT * FROM stmtmpbus WHERE nro_factura='$vfac' AND nro_planilla='$vplan'");
            $obj_filas = $sql->nums('',$obj_query);
            if ($obj_filas==0) {
              //$vnewnombre = $vplan; 
              //$file_logo  = $vnewnombre.".jpg";  
              //$insert_val = "'$vfac',$vplan,'G','$file_logo',$cont,'$user','$fechahoy','$horactual'";
              //$sql->insert("stmtmpbus","","$insert_val","");
              
              $objsqlccv = $sql->query("SELECT ccv,descripcion FROM stmtmpcvfac WHERE factura='$vfac'");
              $objfilccv = $sql->nums('',$objsqlccv);
              //if ($objfilccv!=0) {
                $vnewnombre = $vplan; 
                $file_logo  = $vnewnombre.".jpg";  
                $insert_val = "'$vfac',$vplan,'G','$file_logo',$cont,'$user','$fechahoy','$horactual'";
                $sql->insert("stmtmpbus","","$insert_val","");

              if ($objfilccv!=0) {
                $objcampo  = $sql->objects('',$objsqlccv);
                for($i=0;$i<$objfilccv;$i++) { 
                  $codv = $objcampo->ccv;
                  $insert_ccv = "'$vfac',$vplan,'$codv'";
                  $sql->insert("stmcvplan","","$insert_ccv","");
                  $objcampo  = $sql->objects('',$objsqlccv);
                }   
              }
                            
              if (!empty($archivo)) {
        		    //$anterior=$ruta.$vnewnombre.".jpg";
        		    //unlink($anterior);       
        		    //Copiar archivo de logotipo en ruta final
        		    $max_size = 50; // the max. size for uploading	
        		    $my_upload = new file_upload;
        		    //$my_upload->upload_dir = "/var/www/sistemas/imagenes/temp/"; // "files" is the folder for the uploaded files (you have to create this folder)
        		    $my_upload->upload_dir = $ruta; // "files" is the folder for the uploaded files (you have to create this folder)
        		    //$my_upload->extensions = array(".pdf"); // specify the allowed extensions here
        		    $my_upload->extensions = array(".jpg"); // specify the allowed extensions here  
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
          		   //echo "estoy en el priemer else : $tipo";
	       		   //Mensage_Error($my_upload->show_error_string());
          		   mensajenew($my_upload->show_error_string(),"javascript:history.back();","N");
          		   //$sql->insert("stmtmpbus","","$insert_val","");
          		   //$del_datos = $sql->del("stmtmpbus","nro_tramite='$vsol' AND tipo_bus='G'");
          		   $smarty->display('pie_pag.tpl'); exit(); } 
          	  }
      		  else {
        		    //echo "estoy en el 2do else : $tipo";
        		    mensajenew('Imagen aun NO seleccionada ...!!!','javascript:history.back();','N');
        		    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();
      		  }
            }
          } else { }
        } else { }
      }
      $del_datos = $sql->del("stmtmpcvfac","factura='$vfac'");
    } // Busquedas graficas

    //if (($vtip=="G") || ($vtip=="M")) {
    if (($vtip=="A") || ($vtip=="B")) {
      //$vnewnombre="$vsol"; 
      //Variable para la busqueda de la imagen en busqueda
      //$ruta = "/var/www/consulta/apl/imagentemp/";
      $ruta = $imagen_temp."/";
      $archivo = trim($_FILES['ubicacion']['name']);
      $caracter = ".";
      $posi = strpos($archivo, $caracter);
      $vnewnombre=substr($archivo,0,$posi); 
      
      //print_r($_FILES);

      if (!empty($archivo)) {
        //$anterior=$ruta.$vnewnombre.".jpg";
        //unlink($anterior);       
        //Copiar archivo de logotipo en ruta final
        $max_size = 50; // the max. size for uploading	
        $my_upload = new file_upload;
        //$my_upload->upload_dir = "/var/www/sistemas/imagenes/temp/"; // "files" is the folder for the uploaded files (you have to create this folder)
        $my_upload->upload_dir = $ruta; // "files" is the folder for the uploaded files (you have to create this folder)
        //$my_upload->extensions = array(".pdf"); // specify the allowed extensions here
        $my_upload->extensions = array(".jpg"); // specify the allowed extensions here 
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
          //echo "estoy en el priemer else : $tipo";
	       //Mensage_Error($my_upload->show_error_string());
          mensajenew($my_upload->show_error_string(),"javascript:history.back();","N");
          $sql->insert("stmtmpbus","","$insert_val","");
          $del_datos = $sql->del("stmtmpbus","nro_tramite='$vsol' AND tipo_bus='G'");
          $smarty->display('pie_pag.tpl'); 
	       exit(); }
      }
      else {
        //echo "estoy en el 2do else : $tipo";
        mensajenew('Imagen aun NO seleccionada ...!!!','javascript:history.back();','N');
        $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();
      }

    }
  }
}

if ($vmod=='Buscar/Eliminar')
   {
    for($cont=0;$cont<$vfil;$cont++) 
       {
       $vb[$cont]=$_POST["B$cont"];
       $nu[$cont]=$_POST["num$cont"];
       $de[$cont]=$_POST["den$cont"];
       $cl[$cont]=$_POST["cla$cont"];
       if ($vb[$cont]=="on")
          {$resultado=pg_exec("DELETE FROM stmtmpbus WHERE nro_factura='$vfac' AND nro_planilla='$nu[$cont]' AND clase='$cl[$cont]'"); 
          } 
       }
   
   }

//Desconexion de la Base de Datos
$sql->disconnect();

?>
</body>
</html>
