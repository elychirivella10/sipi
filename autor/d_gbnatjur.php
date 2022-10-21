<script language="javascript">
function cerrarwindows2(){
  window.close();
  window.opener.frames[0].location.reload();
  window.opener.frames[1].location.reload();
  window.opener.frames[2].location.reload();
  window.opener.frames[3].location.reload();
  window.opener.frames[4].location.reload();    
  window.opener.frames[5].location.reload();    
  window.opener.frames[6].location.reload();    
  window.opener.frames[7].location.reload();    
  window.opener.frames[8].location.reload();    
}
</script>

<?php
//Para trabajar con Operaciones de Bases de Datos
//include ("../setting.inc.php");
//LLamadas a funciones de Libreria 
//include ("$include_path/libreria.php");
//include ("$include_path/library.php");
include ("../z_includes.php");
?>

<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Servicio Autonomo de la Propiedad Intelectual</title>
</head> 
<body onload="cerrarwindows2();" bgcolor="#D8E6FF"> 

<?php

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variable
$sql = new mod_db();

$usuario = $_SESSION['usuario_login'];
//$login = $_SESSION['usuario_login'];
$role = $_SESSION['usuario_rol'];
//Verificando conexion
$sql->connection($usuario);

$vmod=$_POST["vmod"];
$vsol=$_POST["vsol"];
$vfil=$_POST["vfil"];
$dtipo=$_POST["vtip"];
$caracterp=$_POST["caracter"];
$vtco=$_POST["vtco"];

$arraycaracter[0][nbtabla]="stdtmpau";
$arraycaracter[1][nbtabla]="stdtmpco";
$arraycaracter[2][nbtabla]="stdtmped";
$arraycaracter[3][nbtabla]="stdtmppt";
$arraycaracter[4][nbtabla]="stdtmpti";
$arraycaracter[5][nbtabla]="stdtmpar";
$arraycaracter[6][nbtabla]="stdtmpso";

for ($cont=0;$cont<7;$cont++)
 { 
   if (!empty($caracterp[$cont])) { 
     $arraycaracter[$cont][seleccion]=1; }
   else { $arraycaracter[$cont][seleccion]=0; }
 }

switch ($dtipo) {
	case "Solicitante":
     $nbtabla="stdtmpso";
	  break;
   case "Productor":
     $nbtabla="stdtmppt"; 
	  break;
   case "Autor":
     $nbtabla="stdtmpau"; 
     break;
   case "Coautor":
     $nbtabla="stdtmpco"; 
	  break;
   case "Artista":
     $nbtabla="stdtmpar"; 
     break;
   case "Editor":
     $nbtabla="stdtmped"; 
     break;
   case "Titular":
     $nbtabla="stdtmpti"; 
     break;
}       

pg_exec("BEGIN WORK");
if ($vmod=='Natural' || $vmod=='Juridica' || $vmod=='Grabar Nuevo Solicitante') {
  if ($vfil==0) {
    $vcod=$_POST["vcod"];
    $vcodl=$_POST["vcodl"];
    $vnom=$_POST["vnom"];
    $vdom=$_POST["vdom"];
    $vindole=$_POST["vindole"];
    $vtlf=$_POST["vtlf"];
    $vtlf2=$_POST["vtlf2"];
    $vfax=$_POST["vfax"];
    $vemail=$_POST["vemail"];
    $vpai=$_POST["vpai"];
    $vfec=$_POST["vfec"];
    $vedo=$_POST["vedo"];
    $vpro=$_POST["vpro"];
    $vseu=$_POST["vseu"];
    $vdat=$_POST["vdat"];
    $vrep=$_POST["vrep"];
    $vrepl=$_POST["vrepl"];
    $vnre=$_POST["vnre"];
    $vcua=$_POST["vcua"];
    $vpru=$_POST["vpru"];
    $vleg=$_POST["vleg"];
    $vtra=$_POST["vtra"];
    $vtco=$_POST["vtco"];
    
    if (empty($vfec)) {$vfec=null; }
           
    //if ($vcod!="" AND  $vnom!="" AND $vdom!="" AND $vpai!="") {
    if ($vcod!="" AND  $vnom!="") {
      if ($vmod=='Natural') {
        $col_campos = "solicitud,tipo_persona,ced_rif,nombre,estado_civil,domicilio,pais,indole,
                telefono1,telefono2,fax,profesion,seudonimo,titulo_legal,doc_trans,email,codigo";
        $insert_str = "'$vsol','N','$vcodl$vcod','$vnom','$vedo','$vdom','$vpai','$vindole',
                      '$vtlf','$vtlf2','$vfax','$vpro','$vseu','$vleg','$vtra','$vemail',0";
        if (!empty($vfec)) {
          $col_campos = $col_campos.",fecha_nacim";
          $insert_str = $insert_str.",'$vfec'"; } 
      }
      if ($vmod=='Juridica') {
        $col_campos = "solicitud,tipo_persona,ced_rif,nombre,domicilio,pais,indole,
                       telefono1,telefono2,fax,datos_registro,cedula_repre,nombre_repre,
                       cualidad_repre,prueba,titulo_legal,doc_trans,email,codigo";
        $insert_str = "'$vsol','J','$vcodl$vcod','$vnom','$vdom','$vpai','$vindole',
                       '$vtlf','$vtlf2','$vfax','$vdat','$vrepl$vrep','$vnre',
                       '$vcua','$vpru','$vleg','$vtra','$vemail',0"; 
      }
      $vsel=0;
      
      for ($cont=0;$cont<7;$cont++) { 
        if ($arraycaracter[$cont][seleccion]==1) {
          $vsel=1;
          $nbtabla = $arraycaracter[$cont][nbtabla];
          if ($nbtabla=="stdtmpco") {
            $col_campos = $col_campos.",tipo_autor";
            $insert_str = $insert_str.",'$vtco'"; 
          }
          $grabar_int = verifica_interesesado($nbtabla,$vsol,$vcod,$vtco);
          if ($grabar_int==0) { 
            $ins_datperjur = $sql->insert("$nbtabla","$col_campos","$insert_str","");
          }   
        }
      }
      if ($vsel==0) {
        if ($nbtabla=="stdtmpco") {
            $col_campos = $col_campos.",tipo_autor";
            $insert_str = $insert_str.",'$vtco'";
        } 
        $grabar_int = verifica_interesesado($nbtabla,$vsol,$vcod,$vtco);
        if ($grabar_int==0) { 
           $ins_datperjur = $sql->insert("$nbtabla","$col_campos","$insert_str","");
        }   
      }            
    }
  }
  else { 
     for($cont=0;$cont<$vfil;$cont++) {
        $vb[$cont]=$_POST["B$cont"];
        $vtit[$cont]=$_POST["vtit$cont"];
        $vced[$cont]=$_POST["vced$cont"];
        $vnom[$cont]=$_POST["vnom$cont"];
        $vnac[$cont]=$_POST["vnac$cont"];
        $vdom[$cont]=$_POST["vdom$cont"];
        $vpai[$cont]=$_POST["vpai$cont"]; 
        $vdtr[$cont]=$_POST["vdoctra$cont"]; 
        $vtpr[$cont]=$_POST["vtitpre$cont"]; 
        $vtco[$cont]=$_POST["vtipoco$cont"]; 
        $vfna[$cont]=$_POST["vfna$cont"]; 
        $veci[$cont]=$_POST["veci$cont"]; 
        $vind[$cont]=$_POST["vind$cont"]; 
        $vte1[$cont]=$_POST["vte1$cont"]; 
        $vte2[$cont]=$_POST["vte2$cont"]; 
        $vfax[$cont]=$_POST["vfax$cont"]; 
        $vpro[$cont]=$_POST["vpro$cont"]; 
        $vseu[$cont]=$_POST["vseu$cont"]; 
        $vema[$cont]=$_POST["vema$cont"]; 

        if ($vb[$cont]=="on") {
          if ($vtco[$cont]!='') {
            $resulcon=pg_exec("select * from $nbtabla where solicitud='$vsol' and 
                               codigo='$vtit[$cont]' and tipo_autor='$vtco[$cont]'");
          } else {
            $resulcon=pg_exec("select * from $nbtabla where solicitud='$vsol' and 
                               codigo='$vtit[$cont]'");
          }
          if (pg_numrows($resulcon)==0) {
            if ($vmod=='Natural') {
              $col_campos = "solicitud,tipo_persona,codigo,nombre,domicilio,pais,tipo_autor,
                             titulo_legal,doc_trans,ced_rif,indole,
                             telefono1,telefono2,fax,profesion,seudonimo,email";
              $insert_str = "'$vsol','N','$vtit[$cont]','$vnom[$cont]','$vdom[$cont]',
                             '$vnac[$cont]','$vtco[$cont]','$vtpr[$cont]','$vdtr[$cont]',
                             '$vced[$cont]','$vind[$cont]',
                             '$vte1[$cont]','$vte2[$cont]',
                             '$vfax[$cont]','$vpro[$cont]','$vseu[$cont]','$vema[$cont]'";
            }
            if ($vmod=='Juridica') {
              $col_campos = "solicitud,tipo_persona,codigo,nombre,domicilio,pais,tipo_autor,
                             titulo_legal,doc_trans,ced_rif,indole,
                             telefono1,telefono2,fax,profesion,seudonimo,email";
              $insert_str = "'$vsol','J','$vtit[$cont]','$vnom[$cont]','$vdom[$cont]',
                             '$vnac[$cont]','$vtco[$cont]','$vtpr[$cont]','$vdtr[$cont]',
                             '$vced[$cont]','$vind[$cont]',
                             '$vte1[$cont]','$vte2[$cont]',
                             '$vfax[$cont]','$vpro[$cont]','$vseu[$cont]','$vema[$cont]'";
            } 
            $vsel=0;
            $vcod= $vtit[$cont];
            for ($cont1=0;$cont1<7;$cont1++) { 
              if ($arraycaracter[$cont1][seleccion]==1) {
                $vsel=1;
                $nbtabla = $arraycaracter[$cont1][nbtabla];
                $grabar_int = verifica_interesesado($nbtabla,$vsol,$vcod,$vtco[$cont]);
                if ($grabar_int==0) { 
                  $ins_datperjur = $sql->insert("$nbtabla","$col_campos","$insert_str",""); 
                } 
              }
            }
            if ($vsel==0) {
              $grabar_int = verifica_interesesado($nbtabla,$vsol,$vcod,$vtco[$cont]);
              if ($grabar_int==0) { 
                $ins_datperjur = $sql->insert("$nbtabla","$col_campos","$insert_str",""); 
              } 
            } 
          }
        } // on 
     }
  }
}
pg_exec("COMMIT WORK");
//mensajecerrarwindows2("Cerrar $vmod,$vfil,$grabar_int ($col_campos) value ($insert_str)");
//Desconexion de la Base de Datos
$sql->disconnect();
?>
</body>
</html>
