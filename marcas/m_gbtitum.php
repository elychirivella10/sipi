<script language="javascript">
function cerrarwindows1(){
  window.opener.frames[0].location.reload();
  window.close();
}
</script>
<?php
 include ("../z_includes.php");
?>

<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Servicio Autonomo de la Propiedad Intelectual</title>
</head> 

<body onload="cerrarwindows1()" bgcolor="#D8E6FF"> 

<?php
 // ************************************************************************************* 
 // Programa: m_gbtitum.php 
 // Realizado por el Analista de Sistema Romulo Mendoza 
 // Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
 // Año: 2009 BD - Relacional 
 // *************************************************************************************

//Variables  onload="cerrarwindows1()"        
    
$sql = new mod_db();

$tbname_t = "stztmptit";

//Verificando conexion
$sql->connection();

$vmod=$_POST["vmod"];
$vsol=$_POST["vsol"];
$vfil=$_POST["vfil"];
$vder=$_POST["vder"];

if ($vmod=='Buscar/Incluir' || $vmod=='Grabar') {
  if ($vfil==0) 
       { // Good Nuevo 
         $vcod=$_POST["vcod"];
         $vcodl=$_POST["vcodl"];
         $vnom=$_POST["vnom"];
         $vdom=$_POST["vdom"];
         $vtlf1=$_POST["tlf1"];
         $vtlf2=$_POST["tlf2"];
         $vfax=$_POST["vfax"];
         $vnac=$_POST["vnac"];
         $vind=$_POST["vind"];
         $vemail=$_POST["vemail"];
         
         //$vnom = str_replace("&","&amp;",$vnom);
         //$vdom = str_replace("&","&amp;",$vdom);
         $col_campos = "solicitud,titular,identificacion,nombre,domicilio,nacionalidad,indole,telefono1,telefono2,fax,email,tipo_mp";
         $insert_str = "'$vsol',0,'$vcodl$vcod','$vnom','$vdom','$vnac','$vind','$tlf1','$tlf2','$fax','$vemail','$vder'";
         $institu = $sql->insert("$tbname_t","$col_campos","$insert_str","");  
       }
       else {
         for($cont=0;$cont<$vfil;$cont++) {
           $vb[$cont]=$_POST["B$cont"];
           $vtit[$cont]=$_POST["vtit$cont"];
           $vnom[$cont]=$_POST["vnom$cont"];
           $vdom[$cont]=$_POST["vdom$cont"];
           $vpai[$cont]=$_POST["vpai$cont"];
           $vind[$cont]=$_POST["vind$cont"];   
           if (!empty($vdom[$cont])) {
             if ($vb[$cont]=="on") {
               $resulcon=pg_exec("select * from stztmptit where solicitud='$vsol' and titular='$vtit[$cont]'");
               if (pg_numrows($resulcon)==0) {
                 //$vnom[$cont] = str_replace("&","&amp;",$vnom[$cont]);
                 //$vdom[$cont] = str_replace("&","&amp;",$vdom[$cont]);
                 $col_campos = "solicitud,titular,identificacion,nombre,domicilio,nacionalidad,indole,tipo_mp";
                 $insert_str = "'$vsol','$vtit[$cont]',0,'$vnom[$cont]','$vdom[$cont]','$vpai[$cont]','$vind[$cont]','$vder'";
                 $institu = $sql->insert("$tbname_t","$col_campos","$insert_str","");  
               }
             }      
           } 
         }
       }
}

if ($vmod=='Buscar/Eliminar')
   {
    for($cont=0;$cont<$vfil;$cont++) 
       {
       $vb[$cont]=$_POST["B$cont"];
       $ti[$cont]=$_POST["tit$cont"];
       $na[$cont]=$_POST["nac$cont"];
       $no[$cont]=$_POST["nom$cont"];
       $do[$cont]=$_POST["dom$cont"];
       if ($vb[$cont]=="on")
          {$resultado=pg_exec("DELETE FROM stztmptit WHERE solicitud='$vsol' AND titular='$ti[$cont]' AND nombre='$no[$cont]' AND nacionalidad='$na[$cont]' AND domicilio='$do[$cont]'"); 
          } 
       }
   
   }

//Desconexion de la Base de Datos
$sql->disconnect();

?>
</body>
</html>
