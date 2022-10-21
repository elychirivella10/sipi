<script language="javascript">
function cerrarwindows1(){
  window.opener.frames[0].location.reload();
  window.opener.frames[1].location.reload();  
  window.opener.frames[2].location.reload();  
  window.close();
}
</script>
<?php
 include ("../z_includes.php");
 // ************************************************************************************* 
 // Programa: m_gbpriorid.php 
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

<body  onload="cerrarwindows1()" bgcolor="#D8E6FF"> 

<?php
//Variables   
$sql = new mod_db();

$tbname_t = "stztmprio";

//Verificando conexion
$sql->connection();

$vmod=$_POST["vmod"];
$vsol=$_POST["vsol"];
$vfil=$_POST["vfil"];
$vder=$_POST["vder"];

if ($vmod=='Buscar/Incluir' || $vmod=='Grabar') {
  if ($vfil==0) 
       { // Good Nuevo
         $vnum=$_POST["vnum"];
         $vfec=$_POST["vfec"];
         $vnac=$_POST["vnac"];

         if (!empty($vnum)) {
           $resultt=pg_exec("SELECT * FROM $tbname_t WHERE solicitud='$vsol' AND tipo_mp='$vder' AND 
                             prioridad='$vnum' AND fecha_priori='$vfec' AND pais_priori='$vnac' ");                     
           if (pg_numrows($resultt)==0) {
             $col_campos = "solicitud,prioridad,fecha_priori,pais_priori,tipo_mp";
             $insert_str = "'$vsol','$vnum','$vfec','$vnac','$vder'";
             $institu = $sql->insert("$tbname_t","$col_campos","$insert_str",""); } 
         }  
       }
}

if ($vmod=='Buscar/Eliminar')
   {
    for($cont=0;$cont<$vfil;$cont++) 
       {
       $vb[$cont]=$_POST["B$cont"];
       $nu[$cont]=$_POST["num$cont"];
       $fe[$cont]=$_POST["fec$cont"];
       $pa[$cont]=$_POST["pai$cont"];
       if ($vb[$cont]=="on")
          {$resultado=pg_exec("DELETE FROM $tbname_t WHERE solicitud='$vsol' AND prioridad='$nu[$cont]' AND pais_priori='$pa[$cont]' AND fecha_priori='$fe[$cont]'"); 
          } 
       }
   
   }

//Desconexion de la Base de Datos
$sql->disconnect();

?>
</body>
</html>
