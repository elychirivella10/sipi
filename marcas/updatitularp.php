<script language="javascript">
function cerrarwindows2(){
window.opener.frames[0].location.reload();
window.close();}
function cerrarwindows3(){
window.opener.frames[1].location.reload();
window.close();}

</script>
<?php
include ("../z_includes.php");
?>

<html>
<head>
<title>Servicio Autonomo de la Propiedad Intelectual</title>
</head> 

<?php

//Variable
//$usuario = $_SESSION['usuario_login'];
//$login = $_SESSION['usuario_login'];
//$role = $_SESSION['usuario_rol'];
$sql = new mod_db();

//Verificando conexion
$sql->connection();

$vmod=$_POST["vmod"];
$vsol=$_POST["vsol"];
$vfil=$_POST["vfil"];
$vtip=$_POST["vtip"];

if ($vtip=='M' or $vtip=='P') {
   echo "<body onload='cerrarwindows3()' bgcolor='#D8E6FF'> ";
} else {
  echo "<body onload='cerrarwindows2()' bgcolor='#D8E6FF'> "; }

//echo "Si esta entrando $vsol $vmod $vfil $vtip";

if ($vmod=='Buscar/Incluir' || $vmod=='Grabar Nuevo Titular')
   {if ($vfil==0) 
       { // Titular Nuevo
         $vcod=$_POST["vcod"];
         $vcodl=$_POST["vcodl"];
         $vnom=$_POST["vnom"];
         $vdom=$_POST["vdom"];
         $vtl1=$_POST["vtl1"];
         $vtl2=$_POST["vtl2"];
         $vind=$_POST["vind"];
         $vfax=$_POST["vfax"];
         $vnac=$_POST["vnac"];
         $vema=$_POST["vema"];
         $col_campos = "solicitud,titular,identificacion,nombre,domicilio,nacionalidad,
                        telefono1,telefono2,indole,fax,email,tipo_mp";
         $insert_str = "'$vsol',0,'$vcodl$vcod','$vnom', 
                        '$vdom','$vnac','$vtl1','$vtl2','$vind','$vfax','$vema','$vtip'";
         $resultt=pg_exec("select * from temptitu where solicitud='$vsol' and 
                           tipo_mp='$vtip' and titular=0 and nombre='$vnom'");
         if (pg_numrows($resultt)==0)
         { $institu = $sql->insert("temptitu","$col_campos","$insert_str",""); } 
       }
       else
       {for($cont=0;$cont<$vfil;$cont++) 
           {$vb[$cont]=$_POST["B$cont"];
            $vtit[$cont]=$_POST["vtit$cont"];
            $vnom[$cont]=$_POST["vnom$cont"];
            $vnac[$cont]=$_POST["vnac$cont"];
            $vdom[$cont]=$_POST["vdom$cont"];
            if ($vb[$cont]=="on")
               {
                if ($vtip=='M' or $vtip=='P') {
                $resulcon=pg_exec("select * from temptitu where solicitud='$vsol' and titular='$vtit[$cont]' and tipo_mp='$vtip'");
                if (pg_numrows($resulcon)==0)
                   {$resultado=pg_exec("INSERT INTO temptitu (solicitud,titular,nombre,nacionalidad,domicilio,tipo_mp) VALUES
                                 ('$vsol','$vtit[$cont]','$vnom[$cont]','$vnac[$cont]','$vdom[$cont]','$vtip')");
                   }
                } else {
                $resulcon=pg_exec("select * from temptitu where solicitud='$vsol' and titular='$vtit[$cont]'");
                if (pg_numrows($resulcon)==0)
                   {$resultado=pg_exec("INSERT INTO temptitu (solicitud,titular,nombre) VALUES
                                 ('$vsol','$vtit[$cont]','$vnom[$cont]')");
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
          {
           if ($vtip=='M' or $vtip=='P') {
           $resultado=
           pg_exec("DELETE FROM temptitu WHERE solicitud='$vsol' and titular='$ti[$cont]' and tipo_mp='$vtip' and nacionalidad='$na[$cont]' and nombre='$no[$cont]'"); 
           } else {
           $resultado=
           pg_exec("DELETE FROM temptitu WHERE solicitud='$vsol' and titular='$ti[$cont]'"); }
          } 
    }
   
   }

if ($vmod=='Cambiar Domicilio')
   {
    for($cont=0;$cont<$vfil;$cont++) 
    {  $vb[$cont]=$_POST["B$cont"];
       $ti[$cont]=$_POST["vtit$cont"];
       $na[$cont]=$_POST["vnac$cont"];
       $do[$cont]=$_POST["vdom$cont"];
       if ($vb[$cont]=="on")
       {  if (trim($na[$cont])<>'')
          { $resultado=
            pg_exec("update temptitu set nacionalidad='$na[$cont]'
                     WHERE solicitud='$vsol' and titular='$ti[$cont]' and tipo_mp='$vtip'");
          }  
          if (trim($do[$cont])<>'')
          { $resultado=
            pg_exec("update temptitu set domicilio='$do[$cont]'
                   WHERE solicitud='$vsol' and titular='$ti[$cont]' and tipo_mp='$vtip'"); 
          }
       } 
    }
   }
//Desconexion de la Base de Datos
$sql->disconnect();

?>
</body>
</html>
