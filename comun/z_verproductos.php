<html>
<style type="text/css">
body {background-color: WHITE;}
</style>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <script language="javascript" src="../include/cal2.js"></script>
  <script language="javascript" src="../include/cal_conf2.js"></script>
  <script language="javascript" src="../include/js/wforms.js"></script>
  <script language="javascript">
     function VerDistingue(formulario) {
        alert (formulario.valordis.value);     
     }
  </script>
</head>
<body onload="window.close(); ">
<?php

//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variable
$usuario = $_SESSION['usuario_login'];
$sql   = new mod_db();

//Verificacion de Conexion 
$sql->connection();   

$vsol=$_GET['psol'];
$vacc=$_GET['vacc'];

$mandis=1;
if ($vacc==1 or $vacc==2 or $vacc==3) {
  // Eliminar del temporal stztmppro
  $valido=$sql->del("stmtmppro","solicitud='$vsol'"); 
  $mandis=0;
}

if ($vacc==1 or $vacc==2 or empty($vacc)) {
 $resultado=pg_exec("SELECT * FROM stmtmpnac WHERE solicitud=$vsol");
 $filas_found=pg_numrows($resultado);
 if ($filas_found>0) {
  $regp = pg_fetch_array($resultado); 
  $vcla=$regp['clase_int'];
  $vclanac=$regp['clase_nac'];
  if ($mandis==1) {$vdis=$regp['distingue'];}
  if ($vacc==1) {
     $resultado=pg_exec("SELECT distinct on (a.orden) a.orden,descripcion FROM stmnizarel a, stmniza b WHERE a.orden=b.orden and clase_inter=$vcla and clase_nacion=$vclanac order by a.orden");
     $filas_found=pg_numrows($resultado);
     $vdis='Para distinguir: ';
     for($cont=1;$cont<=$filas_found;$cont++) { 
        $regp = pg_fetch_array($resultado); 
        $vord=trim($regp['orden']);
        $vdes=trim($regp['descripcion']);
        $lenp=strlen($vdes);
        $finp=strpos($vdes,'—)');
        if ($finp>0) {
           $inip=strpos($vdes,'(');
           $par1=substr($vdes,0,$inip);
           $par2=substr($vdes,$inip+1,$finp-1-$inip);
           $par3=substr($vdes,$finp+4,$lenp);
           $vdes=trim($par2).' '.trim($par1).' '.trim($par3);
        }
        $vdis=$vdis.trim($vdes).'; ';
        $insert_campo="solicitud,orden";
        $insert_valor="$vsol,'$vord'";
        $valido=$sql->insert("stmtmppro","$insert_campo","$insert_valor","");  
     }
     $lendis=strlen($vdis);
     $vdis=substr($vdis,0,$lendis-2).'.';
     $update_str="distingue='$vdis'";
     $update_cond="solicitud='$vsol'";
     $valido=$sql->update("stmtmpnac","$update_str","$update_cond");
  }
  $resultado=pg_exec("SELECT distinct on (a.orden) a.orden,descripcion FROM stmnizarel a, stmniza b WHERE a.orden=b.orden and clase_inter=$vcla and clase_nacion=$vclanac order by a.orden");
  $filas_found=pg_numrows($resultado);
  $tampx=$filas_found*20;
  $tamst="width:100%;height:".trim($tampx)."px;background-color:WHITE;";
  echo "<form name='verdistin1' action='z_verproductos.php?psol=$vsol&vacc=3' method='post'>";
  echo "<input type='hidden' name='valordis' value='$vdis'>";
  echo "<table width='100%' cellspacing='0' cellpadding='0'>";
  if ($filas_found>0) { 
     echo "<tr><td class='der'><a href='z_verproductos.php?psol=$vsol&vacc=1'><input type='button' value='Incluir todos los productos' class='boton_blue'></a> <a href='z_verproductos.php?psol=$vsol&vacc=2'><input type='button' value='Quitar todos los productos' class='boton_blue'></a> <input type='button' value='Ver el Distingue' class='boton_blue' onclick='VerDistingue(this.form)'></td></tr>"; 
  }
  for($cont=1;$cont<=$filas_found;$cont++) { 
   $regp = pg_fetch_array($resultado); 
   $vord=$regp['orden'];
   $vdes=$regp['descripcion'];
   if ($vacc==2 or empty($vacc)) {
     $sw=0;
     $res_check=pg_exec("SELECT * FROM stmtmppro WHERE solicitud='$vsol' and orden='$vord'");
     $fil_enc=pg_numrows($res_check);
     if ($fil_enc>0) {$sw=1;}
     if ($sw==0) {
        echo "<tr><td><input type='submit' name='$vdes' value='&nbsp;&nbsp;' onclick='this.form.$vord.checked=true;'>
              <input type='checkbox' name='$vord' style='display:none' onclick='this.checked=!this.checked'>$vdes</td>";
     } else {
        echo "<tr><td><input type='submit' name='$vdes' value='X' onclick='this.form.$vord.checked=false;'>
              <input type='checkbox' name='$vord' style='display:none' checked onclick='this.checked=!this.checked'>$vdes</td>";
     }
   }
   if ($vacc==1) {
     echo "<tr><td><input type='submit' name='$vdes' value='X' onclick='this.form.$vord.checked=false;'>
              <input type='checkbox' name='$vord' style='display:none' checked onclick='this.checked=!this.checked'>$vdes</td>";     
     //echo "<tr><td><input type='checkbox' name='$vord' checked>$vdes</td>";
   }
   echo "</tr>";
  }
  echo "</table>";
  echo "</form>";
  if ($vcla==46) {echo "<p align='left'>Nombre Comercial</p>";
                  $vdis='Nombre Comercial';}
  if ($vcla==47) {echo "<p align='left'>Lema Comercial</p>";
                  $vdis='Lema Comercial';}
  $update_str="distingue='$vdis'";
  $update_cond="solicitud='$vsol'";
  $valido=$sql->update("stmtmpnac","$update_str","$update_cond");
 } else {
  echo "<p align='center'><font face='Arial' color='#000000' size='1'><br><br><br><br><br><<< <font face='Arial' color='#800000' size='1'>Obligatorio: <font face='Arial' color='#000000' size='1'>Debe seleccionar las palabras que conformaran su distingue. >>><br></font></p>";
 }
}

if ($vacc==3) {
  //$valido=$sql->del("stmtmppro","solicitud='$vsol'");
  $resultado=pg_exec("SELECT * FROM stmtmpnac WHERE solicitud='$vsol'");
  $filas_found=pg_numrows($resultado);
  if ($filas_found>0) {
    $regp = pg_fetch_array($resultado); 
    $vcla=$regp['clase_int'];
    $vclanac=$regp['clase_nac']; 
  }
  $resultado=pg_exec("SELECT distinct on (a.orden) a.orden,descripcion FROM stmnizarel a, stmniza b WHERE a.orden=b.orden and clase_inter=$vcla and clase_nacion=$vclanac order by a.orden");
  $filas_found=pg_numrows($resultado);
  $vdis='Para distinguir: ';
  for($cont=1;$cont<=$filas_found;$cont++) { 
     $regp = pg_fetch_array($resultado); 
     $varbd=$regp['orden'];  
     $vdes=trim($regp['descripcion']);
     $lenp=strlen($vdes);
     $finp=strpos($vdes,'—)');
     if ($finp>0) {
        $inip=strpos($vdes,'(');
        $par1=substr($vdes,0,$inip);
        $par2=substr($vdes,$inip+1,$finp-1-$inip);
        $par3=substr($vdes,$finp+4,$lenp);
        $vdes=trim($par2).' '.trim($par1).' '.trim($par3);
     }
     if(isset($_POST[$varbd])) {
         $vdis=$vdis.trim($vdes).'; ';
         $insert_campo="solicitud,orden";
         $insert_valor="$vsol,'$varbd'";
         $valido=$sql->insert("stmtmppro","$insert_campo","$insert_valor","");  
     }
  }
  $lendis=strlen($vdis);
  $vdis=substr($vdis,0,$lendis-2).'.';
  if ($vdis=='Para distinguir.') {$vdis='';}
  $resultado=pg_exec("SELECT distinct on (a.orden) a.orden,descripcion FROM stmnizarel a, stmniza b WHERE a.orden=b.orden and clase_inter=$vcla and clase_nacion=$vclanac order by a.orden");
  $filas_found=pg_numrows($resultado);
  echo "<form action='z_verproductos.php?psol=$vsol&vacc=3' name='verdistin2' method='post'>";
  echo "<input type='hidden' name='valordis' value='$vdis'>";
  echo "<table width='100%' cellspacing='0' cellpadding='0'>";
  if ($filas_found>0) { 
     echo "<tr><td class='der'><a href='z_verproductos.php?psol=$vsol&vacc=1'><input type='button' value='Incluir todos los productos' class='boton_blue'></a> <a href='z_verproductos.php?psol=$vsol&vacc=2'><input type='button' value='Quitar todos los productos' class='boton_blue'></a> <input type='button' value='Ver el Distingue' class='boton_blue' onclick='VerDistingue(this.form)'></td></tr>"; 
  }
  for($cont=1;$cont<=$filas_found;$cont++) { 
     $regp = pg_fetch_array($resultado); 
     $varbd=$regp['orden'];  
     $vdes=$regp['descripcion'];  
     if(isset($_POST[$varbd])) {
       echo "<tr><td><input type='submit' name='$vdes' value='X' onclick='this.form.$varbd.checked=false;'>
             <input type='checkbox' name='$varbd' style='display:none' checked onclick='this.checked=!this.checked'>$vdes</td>";
     }
     if(!isset($_POST[$varbd])) {
       echo "<tr><td><input type='submit' name='$vdes' value='&nbsp;&nbsp;' onclick='this.form.$varbd.checked=true;'>
             <input type='checkbox' name='$varbd' style='display:none' onclick='this.checked=!this.checked'>
             $vdes</td>";
     }
     if ($cont==1) {
       $update_str="distingue='$vdis'";
       $update_cond="solicitud='$vsol'";
       $valido=$sql->update("stmtmpnac","$update_str","$update_cond");
     }
     echo "</tr>";
  }
  echo "</table>";
  echo "</form>";
  if ($vcla==46) {echo "<p align='left'>Nombre Comercial</p>";
                  $vdis='Nombre Comercial';}
  if ($vcla==47) {echo "<p align='left'>Lema Comercial</p>";
                  $vdis='Lema Comercial';}
  $update_str="distingue='$vdis'";
  $update_cond="solicitud='$vsol'";
  $valido=$sql->update("stmtmpnac","$update_str","$update_cond");
}

//Desconexion de la Base de Datos
//$sql->disconnect();

?>
</body>
</html>



