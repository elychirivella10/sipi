<script language="javascript">
function cerrarwindows2(){
         
window.opener.frames[1].location.reload();
window.close();
}
</script>
<?php
include ("../z_includes.php");
?>

<html>
<head>
<title>Servicio Autonomo de la Propiedad Intelectual</title>
</head> 

<body onload="cerrarwindows2()" bgcolor="#D8E6FF"> 

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

echo "Si esta entrando $vmod $vfil $vnac $vdom $vnom $vpai";

if ($vmod=='Buscar/Incluir')
   {if ($vfil==0) 
       { // nothing
       }
       else
       {for($cont=0;$cont<$vfil;$cont++) 
           {$vb[$cont]=$_POST["B$cont"];
            $vtit[$cont]=$_POST["vtit$cont"];
            $vnom[$cont]=$_POST["vnom$cont"];
            if ($vb[$cont]=="on")
               {$resulcon=pg_exec("select * from tmppohad where poder='$vsol' and poderhabi='$vtit[$cont]'");
                if (pg_numrows($resulcon)==0)
                   {$resultado=pg_exec("INSERT INTO tmppohad (poder,poderhabi,nombre) VALUES
                                 ('$vsol','$vtit[$cont]','$vnom[$cont]')");
                   }
               } 
           }
       }
   }

if ($vmod=='Buscar/Eliminar')
   {
    for($cont=0;$cont<$vfil;$cont++) 
       {$vb[$cont]=$_POST["B$cont"];
       $ti[$cont]=$_POST["tit$cont"];
       $no[$cont]=$_POST["nom$cont"];
       if ($vb[$cont]=="on")
       {$resultado=pg_exec("DELETE FROM tmppohad WHERE poder='$vsol' and poderhabi='$ti[$cont]'"); 
          } 
       }
   }

//Desconexion de la Base de Datos
$sql->disconnect();

?>
</body>
</html>
