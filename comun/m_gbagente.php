<script language="javascript">
function cerrarwindows0(){
  window.opener.frames[0].location.reload();
  window.opener.frames[1].location.reload();
  window.opener.frames[2].location.reload();  
  window.opener.frames[3].location.reload();
  window.close();
}
</script>
<?php
 include ("../z_includes.php");
 // ************************************************************************************* 
 // Programa: m_gbagente.php 
 // Realizado por el Analista de Sistema Romulo Mendoza 
 // Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
 // Año: 2009 BD - Relacional 
 // *************************************************************************************
?>

<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Servicio Autonomo de la Propiedad Intelectual</title>
</head> 

<body onload="cerrarwindows0()" bgcolor="#D8E6FF"> 

<?php
//onload="cerrarwindows0()" 
//Variables 
$sql = new mod_db();

$tbname_t = "stztmpage";

//Verificando conexion
$sql->connection();

$vmod=$_POST["vmod"];
$vsol=$_POST["vsol"];
$vfil=$_POST["vfil"];
$vder=$_POST["vder"];

if ($vmod=='Buscar/Incluir' || $vmod=='Grabar') {
  if ($vfil==0) 
   { // Good Nuevo 
   }
   else {
       for($cont=0;$cont<$vfil;$cont++) {
         $vb[$cont]=$_POST["B$cont"];
         $vtit[$cont]=$_POST["vtit$cont"];
         $vnom[$cont]=$_POST["vnom$cont"];
         $vdom[$cont]=$_POST["vdom$cont"];
         if ($vb[$cont]=="on") { 
           $resulcon=pg_exec("select * from stztmpage where solicitud='$vsol' AND agente='$vtit[$cont]' AND tipo_mp='$vder' AND tipo_per='1'");
           $totalage = pg_numrows($resulcon); echo " son= $totalage ";
           if (pg_numrows($resulcon)==0) {
             $col_campos = "solicitud,agente,nombre,domicilio,tipo_mp,tipo_per";
             $insert_str = "'$vsol','$vtit[$cont]','$vnom[$cont]','$vdom[$cont]','$vder','1'";
             $institu = $sql->insert("$tbname_t","$col_campos","$insert_str","");  
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
          {$resultado=pg_exec("DELETE FROM stztmpage WHERE solicitud='$vsol' AND agente='$ti[$cont]' AND nombre='$no[$cont]' AND domicilio='$do[$cont]' AND tipo_per='1'"); 
          } 
       }
   }

//Desconexion de la Base de Datos
$sql->disconnect();

?>
</body>
</html>
