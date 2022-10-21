<script language="javascript">
function cerrar_windows_1(){
  window.opener.frames[2].location.reload();
  window.close();
}
</script>
<?php
include ("../setting.inc.php");
ob_start();
 include ("../z_includes.php");
?>

<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Sistema En Line de Propiedad Intelectual Caracas - Venezuela</title>
</head> 

<body onload="cerrar_windows_1();">

<?php
    
$sql = new mod_db();
//
//Verificando conexion
$sql->connection();
$sql->disconnect();
$sql1 = new mod_db();
$sql1->connection1();  

if ($_POST["accion1"]=='Incluir')  {$vact='Incluir';}
if ($_POST["accion2"]=='Eliminar') {$vact='Eliminar';}

$fechahoy = hoy();

// Incluir agente/tramitante
if ($vact=='Incluir') {
   $vtra=$_POST["vtra"];
   $vsol=$_POST["vsol"];
   $vtmp=$_POST["vtmp"];
   $vpri=$_POST["vpri"];
   $vpai=$_POST["vpai"];
   $fechadep=$_POST["fechadep"];
   $insert_campo="nro_tramite,solicitud,prioridad,pais_priori,fecha_priori,tipo_mp,fecha_carga";
   $insert_valor="$vtra,$vsol,'$vpri','$vpai','$fechadep','$vtmp','$fechahoy'";
   if ($vpri<>'' and $vpai<>'' and $fechadep<>'' and $fechadep<=$fechahoy) {
      // Si existe en la tabla temporal, lo eliminamos
      $resul_verif=pg_exec("SELECT * FROM stztmprio WHERE nro_tramite='$vtra' and solicitud='$vsol' and prioridad='$vpri' and tipo_mp='$vtmp'");
      pg_exec("BEGIN WORK");
      $cant_error=0;
      if (pg_numrows($resul_verif)>0) {  
         $valido=pg_exec("DELETE FROM stztmprio WHERE nro_tramite='$vtra' and solicitud='$vsol' and prioridad='$vpri' and tipo_mp='$vtmp'");
      if (!$valido) {$cant_error=$cant_error+1;}
      }
      // Se inserta en la tabla temporal
      $valido=pg_exec("INSERT INTO stztmprio (nro_tramite,solicitud,prioridad,pais_priori,fecha_priori,tipo_mp,fecha_carga) VALUES ($vtra,$vsol,'$vpri','$vpai','$fechadep','$vtmp','$fechahoy')");  
      if (!$valido) {$cant_error=$cant_error+1;}
      if ($cant_error==0) {pg_exec("COMMIT WORK");} else {pg_exec("ROLLBACK WORK");}
   }
}

// Eliminar Titular
if ($vact=='Eliminar') {
   $vtra=$_POST["vtra"];
   $vsol=$_POST["vsol"];
   $vtmp=$_POST["vtmp"];
   $vpri=$_POST["vpri"];
   $valido=pg_exec("DELETE FROM stztmprio WHERE nro_tramite='$vtra' and solicitud='$vsol' and prioridad='$vpri' and tipo_mp='$vtmp'");
}

//Desconexion de la Base de Datos
$sql1->disconnect1();

?>
</body>
</html>
