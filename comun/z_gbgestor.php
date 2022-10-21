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
// Incluir agente/tramitante
if ($vact=='Incluir') {
   //$vtra=$_POST["vtra"];
   $vsol=$_POST["vsol"];
   $vtmp=$_POST["vtmp"];
   $vage=$_POST["vage"];
   $vide=$_POST["vide"];
   $lced=$_POST["lcedtit"];
   $vcedula=$_POST["vcedtit"];
   $vpasaporte=$_POST["vpastit"];
   if ($lced=='P') {$vced=$lced.$_POST["vpastit"];}
             else  {$vced=$lced.$_POST["vcedtit"];}
   $vtip=$_POST["vtip"];
   if ($vtip=='') {$vtip='1';}
   $vnom=$_POST["vnom"];
   $vnac=$_POST["vnac"];
   $vdom=$_POST["vdom"];
   $vpod1=$_POST["vpod1"];
   $vpod2=$_POST["vpod2"];
   $vpod=$vpod1.'-'.$vpod2; 
   if ($vtip=='2') {$vpod=''; $vage=0;}
   $vcor=$_POST["vcor"];
   $vcor2=$_POST["vcor2"];
   $vtel=$_POST["vtel"];
   $vcel=$_POST["vcel"];
   $vfax=$_POST["vfax"];
   if ($vtip=='2' or $vtip=='3') {$vced=$vide;}
   $grabarcorrecto='NO';
   //echo "Vsol:$vsol Vtip:$vtip Vtmp:$vtmp Vage:$vage Vnom:$vnom Vnac:$vnac Vced:$vcedula Vpas:$vpasaporte Vdom:$vdom Vpod:$vpod Vpod1:$vpod1 Vpod2:$vpod2";
   if ($vtip==1 and $vnom<>'' and substr($vnom,0,1)<>' ' and $vnac<>'' and ($vcedula<>'' or $vpasaporte<>'') and $vdom<>'' and substr($vdom,0,1)<>' ' and $vpod<>'-' and $vpod1<>'0000' and $vpod2<>'0000')  { $grabarcorrecto='SI';}
   if ($vtip==2 and $vnom<>'' and substr($vnom,0,1)<>' ' and $vnac<>'' and $vdom<>'' and substr($vdom,0,1)<>' ')  { $grabarcorrecto='SI';}
   if ($vtip==3 and $vnom<>'' and substr($vnom,0,1)<>' ' and $vnac<>'' and $vdom<>'' and substr($vdom,0,1)<>' ' and $vpod<>'-' and $vpod1<>'0000' and $vpod2<>'0000')  { $grabarcorrecto='SI';}
   //echo "grabar $grabarcorrecto ";
   if ($grabarcorrecto=='SI') {
      // Si existe en la tabla temporal, lo eliminamos
      pg_exec("BEGIN WORK");
      $cant_error=0;
      if ($vtip==1) {
         $resul_verif=pg_exec("SELECT * FROM stztmpage WHERE solicitud='$vsol' and agente='$vage' and tipo_mp='$vtmp'");
         if (pg_numrows($resul_verif)>0) {  
            $valido=$sql->del("stztmpage","solicitud='$vsol' and agente='$vage' and tipo_mp='$vtmp'");
            if (!$valido) {$cant_error=$cant_error+1;}
         }
      } else {
         $resul_verif=pg_exec("SELECT * FROM stztmpage WHERE solicitud='$vsol' and identificacion='$vced' and tipo_mp='$vtmp'");
         if (pg_numrows($resul_verif)>0) {  
            $valido=$sql->del("stztmpage","solicitud='$vsol' and identificacion='$vced' and tipo_mp='$vtmp'");
            if (!$valido) {$cant_error=$cant_error+1;}
         }
      }
      // Se inserta en la tabla temporal
      if ($vtip==3 and ($vage==0 or $vage=='')) {
         //Generar numero de Apoderado
         $obj_query = $sql->query("update stzsystem set nro_apoderado=nextval('stzsystem_nro_apoderado_seq')");
         $obj_query = $sql->query("select last_value from stzsystem_nro_apoderado_seq");
         $objs = $sql->objects('',$obj_query);
         $vage = $objs->last_value;
      } 
      $insert_campo="solicitud,agente,identificacion,nombre,domicilio,nacionalidad,
                  telefono1,telefono2,fax,email,tipo_mp,fecha_carga,email2,poder,tipo_per";
      $insert_valor="$vsol,$vage,'$vced','$vnom','$vdom','$vnac',
                  '$vtel','$vcel','$vfax','$vcor','$vtmp','$fechahoy','$vcor2','$vpod','$vtip'";
      $valido=$sql->insert("stztmpage","$insert_campo","$insert_valor","");  
      if (!$valido) {$cant_error=$cant_error+1;}
      if ($cant_error==0) {pg_exec("COMMIT WORK");} else {pg_exec("ROLLBACK WORK");}
   }
}

// Eliminar Titular
if ($vact=='Eliminar') {
   $vtra=$_POST["vtra"];
   $vsol=$_POST["vsol"];
   $vtmp=$_POST["vtmp"];
   $vage=$_POST["vage"];
   $vide=$_POST["vide"];
   $vtip=$_POST["vtip"];
   if ($vtip=='') {$vtip='1';}
   if ($vtip=='1') {
       $valido=$sql->del("stztmpage","solicitud='$vsol' and agente='$vage' and tipo_mp='$vtmp' and tipo_per='$vtip'");
   } else {
       $valido=$sql->del("stztmpage","solicitud='$vsol' and identificacion='$vide' and tipo_mp='$vtmp' and tipo_per='$vtip'");
   }
}

//Desconexion de la Base de Datos
$sql->disconnect();

?>
</body>
</html>
