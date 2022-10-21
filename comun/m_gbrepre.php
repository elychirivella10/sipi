<script language="javascript">
function cerrarwindows1(){
  window.opener.frames[0].location.reload();
  window.opener.frames[1].location.reload();
  window.opener.frames[2].location.reload();
  window.opener.frames[3].location.reload();
  window.close();
}
</script>
<?php
 include ("../z_includes.php");
?>

<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>SIPI - Servicio Autonomo de la Propiedad Intelectual</title>
</head> 

<body onload="cerrarwindows1()" bgcolor="#D8E6FF"> 

<?php

//Variables  onload="cerrarwindows1()"        
    
$sql = new mod_db();

$tbname_t = "stztmprepre";

//Verificando conexion
$sql->connection();

$vmod=$_POST["vmod"];
$vsol=$_POST["vsol"];
$vfil=$_POST["vfil"];
$vder=$_POST["vder"];

$fechahoy = hoy();

if ($vmod=='Buscar/Incluir' || $vmod=='Grabar') {
  if ($vfil==0) 
       { // Good Nuevo 
         $vcod=$_POST["vcod"];
         $vcodl=$_POST["vcodl"];
         $vnom=trim($_POST["vnom"]);
         $vdom=trim($_POST["vdom"]);
         $vcargo=trim($_POST["vcargo"]);
         $vcarac=trim($_POST["vcarac"]);
         $vpdo=$_POST["vpdo"];
         $vtlf1=$_POST["tlf1"];
         $vtlf2=$_POST["tlf2"];
         $vfax=$_POST["vfax"];
         $vnac=$_POST["vnac"];
         $vind=$_POST["vind"];
         $vemail=$_POST["vemail"];
         
         //$vnom = str_replace("&","&amp;",$vnom);
         //$vdom = str_replace("&","&amp;",$vdom);
         $col_campos = "solicitud,titular,identificacion,nombre,domicilio,nacionalidad,indole,telefono1,telefono2,fax,email,tipo_mp,fecha_carga,pais_domicilio,cargo,caracter";
         $insert_str = "'$vsol',0,'$vcodl$vcod','$vnom','$vdom','$vnac','$vind','$tlf1','$tlf2','$fax','$vemail','$vder','$fechahoy', '$vpdo','$vcargo','$vcarac'";
         $institu = $sql->insert("$tbname_t","$col_campos","$insert_str","");  
       }
       else {
         for($cont=0;$cont<$vfil;$cont++) {
           $vb[$cont]=$_POST["B$cont"];
           $vtit[$cont]=$_POST["vtit$cont"];
           $vnom[$cont]=trim($_POST["vnom$cont"]);
           $vdom[$cont]=trim($_POST["vdom$cont"]);
           $vcargo[$cont]=trim($_POST["vcargo$cont"]);
           $vcarac[$cont]=trim($_POST["vcarac$cont"]);
           $vpai[$cont]=$_POST["vpai$cont"];
           $vpdo[$cont]=$_POST["vpdo$cont"];
           $vind[$cont]=$_POST["vind$cont"];   
           if (!empty($vdom[$cont])) {
             if ($vb[$cont]=="on") {
               $resulcon=pg_exec("select * from stztmprepre where solicitud='$vsol' AND titular='$vtit[$cont]'"); 
               if (pg_numrows($resulcon)==0) {
                 //$vnom[$cont] = str_replace("&","&amp;",$vnom[$cont]);
                 //$vdom[$cont] = str_replace("&","&amp;",$vdom[$cont]);
                 $col_campos = "solicitud,titular,identificacion,nombre,domicilio,nacionalidad,indole,tipo_mp,fecha_carga,pais_domicilio,cargo,caracter";
                 $insert_str = "'$vsol','$vtit[$cont]',0,'$vnom[$cont]','$vdom[$cont]','$vpai[$cont]','$vind[$cont]','$vder','$fechahoy','$vpdo[$cont]','$vcargo[$cont]','$vcarac[$cont]'";
                 $institu = $sql->insert("$tbname_t","$col_campos","$insert_str","");  
               }
             }      
           } 
         }
       }
}

if ($vmod=='Modificar') {
  $tbname_1 = "stzottid";
  $tbname_2 = "stzsolic";

  $vtit =$_POST["vtit"];
  $vind =trim($_POST["vind"]);
  $vlet =trim($_POST["vcodl"]);
  $vcod =trim($_POST["vcod"]);
  $vnom =trim($_POST["vnom"]);
  $vnac =trim($_POST["vnac"]);
  $vdom =trim($_POST["vdom"]); 
  $vcargo=trim($_POST["vcargo"]); 
  $vcarac=trim($_POST["vcarac"]); 
  $vpdo =trim($_POST["vpdo"]); 
  $vtel =trim($_POST["vtel"]);
  $vcel =trim($_POST["vcel"]); 
  $vfax =trim($_POST["vfax"]);
  $vcor =trim($_POST["vcor"]);
  $vcor2=trim($_POST["vcor2"]);

  if (($vind=='V') OR ($vind=='J') OR ($vind=='E') OR ($vind=='G')) {
    $vcod = str_pad($vcod,10,"0",STR_PAD_LEFT); }
  $vide = $vlet.$vcod;
  if (empty($vcod) OR ($vcod=='000000000')) { $vide =''; }  
  
  $acttitu = true;
  $update_str = "identificacion='$vide',nombre='$vnom',nacionalidad='$vnac',domicilio='$vdom',pais_domicilio='$vpdo',indole='$vind',telefono1='$vtel', telefono2='$vcel',fax='$vfax',email='$vcor',email2='$vcor2',cargo='$vcargo',caracter='$vcarac'"; 
  $acttitu = $sql->update("$tbname_t","$update_str","titular='$vtit' AND solicitud='$vsol' AND tipo_mp='$vder'");
}

if ($vmod=='Corregir') {
  $tbname_1 = "stzottid";
  $tbname_2 = "stzsolic";

  $vtit =$_POST["vtit"];
  $vind =trim($_POST["vind"]);
  $vlet =trim($_POST["vcodl"]);
  $vcod =trim($_POST["vcod"]);
  $vnom =trim($_POST["vnom"]);
  $vnac =trim($_POST["vnac"]);
  $vpdo =trim($_POST["vpdo"]);
  $vdom =trim($_POST["vdom"]);
  $vcargo=trim($_POST["vcargo"]);
  $vcarac=trim($_POST["vcarac"]);
  $vtel =trim($_POST["vtel"]);
  $vcel =trim($_POST["vcel"]); 
  $vfax =trim($_POST["vfax"]);
  $vcor =trim($_POST["vcor"]);
  $vcor2=trim($_POST["vcor2"]);

  if (($vind=='V') OR ($vind=='J') OR ($vind=='E') OR ($vind=='G')) {
    $vcod = str_pad($vcod,10,"0",STR_PAD_LEFT); }
  $vide = $vlet.$vcod;
  if (empty($vcod) OR ($vcod=='000000000')) { $vide =''; }  
  
  $acttitu = true;
  $update_str = "identificacion='$vide',nacionalidad='$vnac',domicilio='$vdom',indole='$vind',telefono1='$vtel',telefono2='$vcel', fax='$vfax',email='$vcor',email2='$vcor2',pais_domicilio='$vpdo',cargo='$vcargo',caracter='$vcarac'"; 
  $acttitu = $sql->update("$tbname_t","$update_str","titular='$vtit' AND solicitud='$vsol' AND tipo_mp='$vder'");
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
          {$resultado=pg_exec("DELETE FROM stztmprepre WHERE solicitud='$vsol' AND titular='$ti[$cont]' AND nombre='$no[$cont]' AND nacionalidad='$na[$cont]' AND domicilio='$do[$cont]'"); 
          } 
       }
   
   }

//Desconexion de la Base de Datos
$sql->disconnect();

?>
</body>
</html>
