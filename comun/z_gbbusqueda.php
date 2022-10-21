<script language="javascript">
function cerrar_windows_1(){
  window.opener.frames[0].location.reload();
  window.opener.frames[1].location.reload();
  window.opener.frames[2].location.reload();
  window.opener.frames[3].location.reload();
  window.opener.frames[4].location.reload();
  window.opener.frames[5].location.reload();
  window.close();
}
</script>
<?php
 include ("../z_includes.php");
?>

<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Sistema de Informaci&oacute;n de Propiedad Intelectual</title>
</head> 

<body onload="cerrar_windows_1();" > 

<?php
    
$sql = new mod_db();
// onload="cerrar_windows_1();" 
//Verificando conexion
$sql->connection();

if ($_POST["accion1"]=='Aceptar') {$vact='Incluir';}
if ($_POST["accion2"]=='Rechazar')  {$vact='Eliminar';}

$fechahoy = hoy();

// Incluir datos del signo
if ($vact=='Incluir') {
   $vsol=$_POST["vsol"];
   $vtpm=$_POST["vtpm"];
   $vcla=$_POST["vcla"];
   $vclanac=$_POST["clasesnac"];
   //if ($vlsol=='0000-000000' or $lensol<11) {$vlsol='';}
   echo "<p align='center'>Sol:$vsol clase:$vcla, es $vclanac </p>";
   
   $insert_campo="solicitud,tipo_marca,clase_int,clase_nac";
   $insert_valor="$vsol,'$vtpm',$vcla,$vclanac";

   // Si existe en la tabla temporal, lo eliminamos
   $resul_verif=pg_exec("SELECT * FROM stmtmpnac WHERE solicitud='$vsol'");
   pg_exec("BEGIN WORK");
   $cant_error=0;
   if (pg_numrows($resul_verif)>0) {  
     $valido=$sql->del("stmtmpnac","solicitud='$vsol'");
     if (!$valido) { $cant_error=$cant_error+1; }
   }
   // Se inserta en la tabla temporal
   $valido=$sql->insert("stmtmpnac","$insert_campo","$insert_valor","");  
   if (!$valido) { $cant_error=$cant_error+1; }
   if ($cant_error==0) { pg_exec("COMMIT WORK"); } else { pg_exec("ROLLBACK WORK"); }
}

// Eliminar Titular
if ($vact=='Eliminar') {
   $vtra=$_POST["vtra"];
   $vsol=$_POST["vsol"];
   $vtmp=$_POST["vtmp"];
   pg_exec("BEGIN WORK");
   $cant_error=0;
   $valido=$sql->del("stztmpbus","nro_tramite=$vtra and solicitud=$vsol");
   if (!$valido) {$cant_error=$cant_error+1;}
   if ($cant_error==0) {pg_exec("COMMIT WORK");} else {pg_exec("ROLLBACK WORK");}
}

//Desconexion de la Base de Datos
$sql->disconnect();

?>
</body>
</html>
