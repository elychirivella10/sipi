<script language="javascript">
function cerrar_windows_1(){
  window.opener.frames[0].location.reload();
  window.opener.frames[1].location.reload();
  window.opener.frames[2].location.reload();
  window.opener.frames[3].location.reload();
  window.opener.frames[4].location.reload();
  window.close();
}
</script>
<?php
 include ("../z_includes.php");
?>

<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Sistema Webpi de Propiedad Intelectual Caracas - Venezuela</title>
</head> 

<body onload="cerrar_windows_1();" > 

<?php
// onload="cerrar_windows_1();" 
    
$sql = new mod_db();

//Verificando conexion
$sql->connection();

if ($_POST["accion1"]=='Incluir')  {$vact='Incluir';}
if ($_POST["accion2"]=='Eliminar') {$vact='Eliminar';}

$fechahoy = hoy();

// Incluir Titular
if ($vact=='Incluir') {
   $vtra=$_POST["vtra"];
   $vsol=$_POST["vsol"];
   $vtmp=$_POST["vtmp"];
   $vtit=$_POST["vtit"];
   $vide=$_POST["vide"];
   $vtip=$_POST["vtip"];
   $vnom=$_POST["vnom"];
   $vnac=$_POST["vnac"];
   $vdom=$_POST["vdom"];
   $vcor=$_POST["vcor"];
   $vcor2=$_POST["vcor2"];
   $vtel=$_POST["vtel"];
   $vcel=$_POST["vcel"];
   $vfax=$_POST["vfax"];
   if ($vtip=='Persona Natural')           {$vind='N';}
   if ($vtip=='Cooperativa')               {$vind='C';}
   if (substr_count($vtip,'Nacional')>0)   {$vind='P';}
   if (substr_count($vtip,'Extranjera')>0) {$vind='E'; $vide='X'.str_repeat('0',9-strlen($vide)).$vide;}
   $insert_campo="solicitud,titular,identificacion,nombre,domicilio,nacionalidad,
                  indole,telefono1,telefono2,fax,email,tipo_mp,fecha_carga,email2";
   $insert_valor="$vsol,$vtit,'$vide','$vnom','$vdom','$vnac',
                  '$vind','$vtel','$vcel','$vfax','$vcor','$vtmp','$fechahoy','$vcor2'";
   echo " $insert_valor ";                  
   if (substr($vnom,0,1)<>' ' and $vnom<>'' and substr($vdom,0,1)<>' ' and $vdom<>'' and $vnac<>'' and $vide<>'') {
      // Si existe en la tabla temporal, lo eliminamos
      $resul_verif=pg_exec("SELECT * FROM stztmptit WHERE nro_tramite='$vtra' and solicitud='$vsol' and titular='$vtit' and tipo_mp='$vtmp'");
      pg_exec("BEGIN WORK");
      $cant_error=0;
      if (pg_numrows($resul_verif)>0) {  
         $valido=$sql->del("stztmptit","solicitud='$vsol' and titular='$vtit' and tipo_mp='$vtmp'");
      if (!$valido) {$cant_error=$cant_error+1;}
      }
      // Se inserta en la tabla temporal
      $valido=$sql->insert("stztmptit","$insert_campo","$insert_valor","");  
      if (!$valido) {$cant_error=$cant_error+1;}
      if ($cant_error==0) {pg_exec("COMMIT WORK");} else {pg_exec("ROLLBACK WORK");}
   }
}

// Eliminar Titular
if ($vact=='Eliminar') {
   $vtra=$_POST["vtra"];
   $vsol=$_POST["vsol"];
   $vtmp=$_POST["vtmp"];
   $vtit=$_POST["vtit"];
echo "<p align='center'>Tra:$vtra Sol:$vsol Tmp:$vtmp Tit:$vtit</p>";
   $valido=$sql->del("stztmptit","solicitud=$vsol and titular=$vtit and tipo_mp='$vtmp' ");
}


//Desconexion de la Base de Datos
$sql->disconnect();

?>
</body>
</html>
