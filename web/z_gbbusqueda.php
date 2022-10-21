<script language="javascript">
function cerrar_windows_1(){
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
  <title>Sistema En Line de Propiedad Intelectual Caracas - Venezuela</title>
</head> 

<body onload="cerrar_windows_1();"> 

<?php
    
$sql = new mod_db();
//
//Verificando conexion
$sql->connection();

if ($_POST["accion1"]=='Aceptar') {$vact='Incluir';}
if ($_POST["accion2"]=='Rechazar')  {$vact='Eliminar';}

$fechahoy = hoy();

// Incluir datos del signo
if ($vact=='Incluir') {
   $vtra=$_POST["vtra"];
   $vsol=$_POST["vsol"];
   $vtmp=$_POST["vtmp"];
   $tbus=$_POST["tbus"];
   if ($tbus==1 or $tbus=='') {$tsig='N';}
   if ($tbus==2) {$tsig='G';}
   if ($tbus==3) {$tsig='M';}
   $vfon=$_POST["vfon"];
   if ($vfon=='') {$vfon=0;}
   $vgra=$_POST["vgra"];
   if ($vgra=='') {$vgra=0;}
   $vnom=$_POST["vnom"];
   $vrut=$_POST["vrut"];
   $vcla=$_POST["vcla"];
   $vclanac=$_POST["clasesnac"];
   $vlmar=$_POST["vlmar"];
   $vlsol1=$_POST["vlsol1"];
   $vlsol2=$_POST["vlsol2"];
   $vlreg1=$_POST["vlreg1"];
   $vlreg2=$_POST["vlreg2"];
   $vlsol=$vlsol1.'-'.$vlsol2;
   $vlreg=$vlreg1.$vlreg2;
   $lensol=strlen(trim($vlsol));
   $lenreg=strlen(trim($vlreg));
   if ($vlsol=='0000-000000' or $lensol<11) {$vlsol='';}
   if ($lenreg<7) {$vlreg='';}
   $vtipom=tipo_de_marca($vcla);
//echo "<p align='center'>Tra:$tra Sol:$vsol Lensol:$lensol Lenreg:$lenreg</p>";
   
   // Se verifican los campos obligatorios en caso de Lema Comercial
   if ($vcla<>47 or ($vcla==47 and ($vlsol<>'-' or $vlreg<>''))) { 
    $insert_campo="nro_tramite,solicitud,tipo_marca,clase_int,ruta_signo,nombre,fecha_carga, lc_amarca,lc_solicitud,lc_registro,clase_nac,tipo_signo,ref_fonetica,ref_grafica,tipo_mp";
    $insert_valor="$vtra,$vsol,'$vtipom',$vcla,'$vrut','$vnom','$fechahoy','$vlmar','$vlsol', '$vlreg',$vclanac,'$tsig',$vfon,$vgra,'$vtmp'";

    // Si existe en la tabla temporal, lo eliminamos
    $resul_verif=pg_exec("SELECT * FROM stztmpbus WHERE nro_tramite='$vtra' and solicitud='$vsol'");
    pg_exec("BEGIN WORK");
    $cant_error=0;
    if (pg_numrows($resul_verif)>0) {  
      $valido=$sql->del("stztmpbus","nro_tramite='$vtra' and solicitud='$vsol'");
      if (!$valido) {$cant_error=$cant_error+1;}
    }
    // Se inserta en la tabla temporal
    $valido=$sql->insert("stztmpbus","$insert_campo","$insert_valor","");  
    if (!$valido) {$cant_error=$cant_error+1;}
    if ($cant_error==0) {pg_exec("COMMIT WORK");} else {pg_exec("ROLLBACK WORK");}
   }
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
