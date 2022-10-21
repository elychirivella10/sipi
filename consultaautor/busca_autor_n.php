<html>
<head>
  <LINK REL='STYLESHEET' TYPE='text/css' HREF='../main.css'>  
  <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
  <script type="text/javascript">

   function checkKey(evt) 
    {if (evt.keyCode == '17') 
    {alert("Comando No Permitido ...!!!"); 
     return false} 
   return true}

   function cerrarwindows() {
     window.close(); }
    
  </script>
</head>

<body oncontextmenu="return false" onkeydown="return checkKey(event)">

<?php 
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

$login = $_SESSION['usuario_login'];
$fecha = fechahoy();
$titulo  = "Sistema En L&iacute;nea de Propiedad Intelectual Caracas - Venezuela";
$subtitulo = "Consulta Administrativa de Derecho de Autor";
$confidencial="Contenido Confidencial";
$sql   = new mod_db();

$smarty->assign('titulo',$titulo);
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado3.tpl');

$fechahoy = Hoy();

echo "<table border='0' cellpadding='0' cellspacing='0' class='titulo_autor'>";
echo " <td>";
echo "   <i><b><font>$subtitulo</font></b></i>";
echo " </td>";
echo "</table>"; 

error_reporting(E_ERROR); 

$vtipuser=$_GET['vusuario'];
if ($vtipuser==1)
    {$vhomepage='indexfull.php';}
if ($vtipuser==2)
    {$vhomepage='indexautor.php';}

$vopcion=$_GET["vopc"];
$captchai=$_POST["codigo"];
$captchaf=$_POST["captcha"];

$varsol=$_POST["vsol1"];
$longitud=strlen($varsol);
if ($longitud==1)
 {$varsol='00000'.$varsol;}
if ($longitud==2)
 {$varsol='0000'.$varsol;}
if ($longitud==3)
 {$varsol='000'.$varsol;}
if ($longitud==4)
 {$varsol='00'.$varsol; }
if ($longitud==5)
 {$varsol='0'.$varsol;}

//Verificando Conexion
$sql->connection();
 
if ($vopcion==1)
   {$resultado=pg_exec("SELECT * FROM stdobras WHERE stdobras.solicitud='$varsol'");
   }

if (!$resultado) { 
     echo "&nbsp;";
     echo "&nbsp;";
     echo "&nbsp;";
     echo "<p align='center'><b>ERROR: NO SE PUDO PROCESAR LA BUSQUEDA ...!!</b>"; 
     echo "&nbsp;";
     echo "&nbsp;";
     echo "<p align='center'><a href='indexautor.php'><input type='image' name='Aceptar' value='Salir' src='../imagenes/regresarboton.png' height='35'></a>";
     echo "&nbsp;";
     echo "&nbsp;";
     echo "<div align='center'>";
     echo "<tr><td>&nbsp;</td></tr>";
     $smarty->display('pie_pag3.tpl');   
     echo "</div>";
     // Desconexion de la Base de datos 
     $sql->disconnect1();
     exit(); 
   }

$filas_found=pg_numrows($resultado); 
if ($filas_found==0) 
   {
   echo "&nbsp;";
     echo "&nbsp;";
     echo "&nbsp;";
     echo "<p align='center'><b>ERROR: NO EXISTEN DATOS ASOCIADOS ...!!</b>\n"; 
     echo "&nbsp;";
     echo "&nbsp;";
     //echo "<p align='center'><a href='indexmp_n.php'><input type=button value='Aceptar' class='botones'></a>";
     echo "<p align='center'><a href='indexautor.php'><input type='image' name='Aceptar' value='Salir' src='../imagenes/regresarboton.png' height='35'></a>";
     echo "&nbsp;";
     echo "&nbsp;";
     echo "<div align='center'>";
     echo "<tr><td>&nbsp;</td></tr>";
     $smarty->display('pie_pag3.tpl');   
     echo "</div>";
     // Desconexion de la Base de datos 
     $sql->disconnect1();
     exit();
   } 

$reg = pg_fetch_array($resultado);
$varsol=$reg['solicitud'];

$nregis=$reg['registro'];

$nderec=$reg['nro_derecho'];

$vporc='83%';

?>

<?php 
error_reporting(E_ERROR); 
?>

<table border="0" cellpadding="2" cellspacing="2" width="100%">
  <tr>
    <td width="22%" class='der8-color'>Solicitud:</font></b></td>
   <?php echo "    <td width=$vporc class='izq6a-color'>$reg[solicitud]</td>"; 
//?>

  </tr>
  <tr>
    <td width="22%" class='der8-color'>Fecha Solicitud:</td>
<?php echo "    <td width=$vporc class='izq6a-color'>$reg[fecha_solic]</td>"; ?>
  </tr>
  <tr>
  <td width="22%" class='der8-color'>Tipo de Obra:</td>
<?php
     if ($reg['tipo_obra']=='OM'){$tipo_obra='OBRA MUSICAL';}
     if ($reg['tipo_obra']=='OL'){$tipo_obra='OBRA LITERARIA';}
     if ($reg['tipo_obra']=='OE'){$tipo_obra='OBRA ESCENICA';}
     if ($reg['tipo_obra']=='AV'){$tipo_obra='ARTE VISUAL';}
     if ($reg['tipo_obra']=='AR'){$tipo_obra='OBRA AUDIOVISUAL Y RADIOFONICA';}
     if ($reg['tipo_obra']=='PC'){$tipo_obra='PROGRAMAS DE COMPUTACION Y BASES DE DATOS';}
     if ($reg['tipo_obra']=='PF'){$tipo_obra='PRODUCCIONES FONOGRAFICAS';}
     if ($reg['tipo_obra']=='IE'){$tipo_obra='INTERPRETACIONES Y EJECUCIONES ARTISTICAS';}
     if ($reg['tipo_obra']=='AC'){$tipo_obra='ACTOS Y CONTRATOS';}
     echo "    <td width=$vporc class='izq6a-color'>$reg[tipo_obra]- $tipo_obra</td>"; 
 ?>
 </tr>
 <tr>
 <td width="22%" class='der8-color'>Nro Planilla:</td>
<?php echo "    <td width=$vporc class='izq6a-color'>$reg[nplanilla]</td>"; ?>
  </tr>
  <tr>
  <td width="22%" class='der8-color'>No de Registro:</td>
<?php echo " <td width=$vporc class='izq6a-color'>$reg[registro]</td>"; ?>
  </tr>
  <tr>
  <td width="22%" class='der8-color'>Fecha Registro:</td>
<?php echo "    <td width=$vporc class='izq6a-color'>$reg[fecha_regis]</td>"; ?>
  </tr>
 <?php
 // Datos Comunes a todas las planillas 
  echo"<tr>";
  echo"<td width='22%' class='der8-color'>País:</font></b></td>";
  $res_pais=pg_exec("SELECT * FROM stzpaisr WHERE pais='$reg[pais_origen]' and pais!=''");
  $respai = pg_fetch_array($res_pais);
  echo "<td width='20%' class='izq6a-color'>$reg[pais_origen] - $respai[nombre]</td>";  
  echo"</tr>";
  echo"<tr>";
  echo"<td width='22%' class='der8-color'>Idioma:</font></b></td>";

  $res_idioma=pg_exec("SELECT * FROM stdidiom WHERE cod_idioma='$reg[cod_idioma]'");
  $residio = pg_fetch_array($res_idioma);
  
  echo"<td width=$vporc class='izq6a-color'>$reg[cod_idioma]- $residio[idioma]</td>";
  echo"</tr>";
  echo"<tr>";
  echo"<td width='22%' class='der8-color'>Estatus:</font></b></td>";
 
 $res_estatus=pg_exec("SELECT * FROM stdstobr WHERE estatus='$reg[estatus]'");
 $restat = pg_fetch_array($res_estatus);
 echo " <td width=$vporc class='izq6a-color'>$reg[estatus]-$restat[descripcion]</td>";
echo" </tr>";
if ($reg['tipo_obra']!='IE') 
{
  echo" <tr>";
  echo" <td width='22%' class='der8-color'>T&iacute;tulo:</td>";
  if ($reg['clase']!='I')  { echo" <td width=$vporc class='izq6a-color'>$reg[titulo_obra]</td>"; }
     else                  { echo" <td width=$vporc class='izq6a-color'>$confidencial</td>"; 
  }
  echo" </tr>";  
 } 

if (($reg['tipo_obra']!='PF') and ($reg['tipo_obra']!='IE') and($reg['tipo_obra']!='AC') and ($reg['tipo_obra']!='OE'))
{
 echo"<tr>";
 echo "<td width='22%' class='der8-color'>Descripci&oacute;n:</td>";
 if ($reg['clase']!='I')  { echo" <td width=$vporc class='izq6a-color'>$reg[descrip_obra]</td>"; }
    else                  { echo" <td width=$vporc class='izq6a-color'>$confidencial</td>"; 
 }
 echo "</tr>";
 }
 if (($reg['tipo_obra']!='PF') and ($reg['tipo_obra']!='IE') and($reg['tipo_obra']!='AC') )
{
 echo "<tr>";
 echo "<td width='22%' class='der8-color'>Clasificación:</td>";

 if ($reg['clase']=='P'){$clase='Publicada';} 
 if ($reg['clase']=='I'){$clase='Inedita';} 
 if ($reg['origen']=='O'){$origen='Originaria';}  
 if ($reg['origen']=='D'){$origen='Derivada';} 
 if ($reg['forma']=='I'){$forma='Individual';}  
 if ($reg['forma']=='E'){$forma='En Colaboración';} 
 if ($reg['forma']=='C'){$forma='Colectiva';} 
 $clasificacion=$clase.'   '.$origen.'   '.$forma;
echo "<td width=$vporc class='izq6a-color'>$clasificacion</td>"; 
echo "</tr>";     
echo "<br>";
}
?>

<?php
//Planilla AC
if ($reg['tipo_obra']=='AC') 
  {
    $resul_actos=pg_exec("SELECT * FROM stdactos WHERE nro_derecho = '$nderec'");
    $regac = pg_fetch_array($resul_actos);
    echo"<tr>";
    echo"<td class='der8-color'>Partes que intervienen:</td>";  
    echo"<td width='20%' class='izq6a-color'>$regac[partes]</td>";
    echo"</tr>"; 
    echo"<tr>";    
    echo"<td class='der8-color'>Objeto:</td>";
    echo "<td width='20%' class='izq6a-color'>$regac[objeto]</td>";
    echo"</tr>";   
 }
?>
</table>
<?php 
// Datos del Autor
 if (($reg['tipo_obra']=='OM') or ($reg['tipo_obra']=='OL')or ($reg['tipo_obra']=='OE') or ($reg['tipo_obra']=='AV') or ($reg['tipo_obra']=='AR') or ($reg['tipo_obra']=='PC'))
  {
   $resultado=pg_exec("SELECT stzsolic.nombre, stdobaut.doc_autor, stdobaut.titular,stdobaut.domicilio,stdobaut.tipo_autor,stzsolic.telefono1 FROM stzsolic, stdobaut WHERE (stdobaut.nro_derecho=$nderec) and (stzsolic.titular= stdobaut.titular) order by stdobaut.doc_autor");   
   $filas_found=pg_numrows($resultado);   
   if ($filas_found>0)
   {  
    echo "<p align='center'><b><font size='3' face='Tahoma'>Autor(es)</font></b></p>";
    echo "<table border='0' cellpadding='1' cellspacing='1' width='100%'>";
    echo" <tr>";
    echo" <td width='10%' class='Estilo5'>C&eacute;dula / Rif</b></font></td>";
    echo"  <td width='20%' class='Estilo5'>Autor</td>";
    echo"  <td width='20%' class='Estilo5'>Domicilio</td>";
    echo"  <td width='10%' class='Estilo5'>Tipo</td>";
    echo"  <td width='10%' class='Estilo5'>Titular</td>";
    echo"</tr>";   
    $reg1 = pg_fetch_array($resultado);
    for($cont=0;$cont<$filas_found;$cont++) 
      { 
	  
	    echo "<tr>";
       echo "<td width='10%' class='izq6a-color'>$reg1[doc_autor]</td>";
       echo "<td width='20%' class='izq6a-color'>$reg1[nombre]</td>";  
       $domiciliocomp=$reg1['domicilio'].' / '.trim($reg1['telefono1']);
       echo "<td width='20%' class='izq6a-color'>$domiciliocomp</td>"; 
       if ($reg1[tipo_autor]=='AU'){$tipo_autor='Autor';}  
       if ($reg1[tipo_autor]=='CD'){$tipo_autor='Coautor Director o Realizador';} 
       if ($reg1[tipo_autor]=='CA'){$tipo_autor='Coautor Argumento de la Adaptación';} 
       if ($reg1[tipo_autor]=='CG'){$tipo_autor='Coautor del Guión o Diálogos';}
       if ($reg1[tipo_autor]=='CM'){$tipo_autor='Coautor Música Compuesta';}     
       echo "<td width='10%' class='izq6a-color'>$tipo_autor</td>";
       echo "<td width='10%' class='izq6a-color'>$reg1[titular]</td>";    
       echo "</tr>";
       $reg1 = pg_fetch_array($resultado);
     }
     echo"</table>";
    } 
  }
  
 //Datos del PRODUCTOR 
 if (($reg['tipo_obra']=='PF') or ($reg['tipo_obra']=='PC') or ($reg['tipo_obra']=='AR') or ($reg['tipo_obra']=='OE'))
  {
    $resul_prod=pg_exec("SELECT stzsolic.nombre, stzsolic.identificacion, stdobpro.domicilio, stzsolic.telefono1,stdobpro.titular   FROM stzsolic,stdobpro WHERE (stdobpro.nro_derecho=$nderec) and (stzsolic.titular= stdobpro.titular) ");
	 $regis = pg_fetch_array($resul_prod);
	 $filas_found=pg_numrows($resul_prod);
	 if ($filas_found<>0)
	 {
	 echo "<p align='center'><b><font size='3' face='Tahoma'>Productor(es)</font></b></p>";
    echo "<table border='0' cellpadding='1' cellspacing='1' width='100%'>";
    echo" <tr>";
    echo" <td width='10%' class='Estilo5'>C&eacute;dula / Rif</td>";
    echo"  <td width='20%' class='Estilo5'>Productor</td>";
    echo"  <td width='20%' class='Estilo5'>Domicilio</td>";
    echo"  <td width='10%' class='Estilo5'>Titular</td>";
    echo"</tr>";
    for($cont=0;$cont<$filas_found;$cont++) 
     { 
	    $domicilio=$regis['domicilio'].' / '.trim($regis['telefono1']);
	    echo "<tr>";
       echo "<td width='10%' class='izq6a-color'>$regis[identificacion]</td>";
       echo "<td width='20%' class='izq6a-color'>$regis[nombre]</td>";     
       echo "<td width='20%' class='izq6a-color'>$domicilio</td>"; 
       echo "<td width='10%' class='izq6a-color'>$regis[titular]</td>";    
       echo "</tr>";
       $regis = pg_fetch_array($resultado);
    }
    echo "</table>";  
  }  
  }
//Datos del Titular 
 if (($reg['tipo_obra']=='PC') or ($reg['tipo_obra']=='AV'))
  {
     $resul_prod=pg_exec("SELECT stzsolic.nombre, stzsolic.identificacion, stdobtit.domicilio, stzsolic.telefono1,stdobtit.titulo_presun   FROM stzsolic,stdobtit WHERE (stdobtit.nro_derecho=$nderec) and (stzsolic.titular= stdobtit.titular) ");
	  $regis = pg_fetch_array($resul_prod);
	  $filas_found=pg_numrows($resul_prod);
	  if ($filas_found>0)
	  {
      echo "<p align='center'><b><font size='4' face='Tahoma'>Titular(es)</font></b></p>";
      echo "<table border='0' cellpadding='1' cellspacing='1' width='100%'>";
      echo" <tr>";
      echo" <td width='10%' class='Estilo5'>C&eacute;dula / Rif</td>";
      echo"  <td width='20%' class='Estilo5'>Titular</td>";
      echo"  <td width='20%' class='Estilo5'>Domicilio</td>";
      echo"  <td width='10%' class='Estilo5'>T&iacute;tulo</td>";
      echo"</tr>";
    
     for($cont=0;$cont<$filas_found;$cont++) 
      { 
	     $domicilio=$regis['domicilio'].' / '.trim($regis['telefono1']);
	     echo "<tr>";
        echo "<td width='10%' class='izq6a-color'>$regis[identificacion]</td>";
        echo "<td width='20%' class='izq6a-color'>$regis[nombre]</td>";     
        echo "<td width='20%' class='izq6a-color'>$domicilio</td>"; 
        echo "<td width='10%' class='izq6a-color'>$regis[titulo_presun]</td>";    
        echo "</tr>";
        $regis = pg_fetch_array($resultado);
      }
    echo "</table>";
    }  
  }   
 
  //Datos de los Artistas e interpretes  

 if ($reg['tipo_obra']=='IE')
   {
     $resul_prod=pg_exec("SELECT stzsolic.nombre, stzdaper.seudonimo,stzsolic.identificacion, stdobart.domicilio, stzsolic.telefono1,stdobart.titular   FROM stzsolic,stdobart,stzdaper WHERE (stdobart.nro_derecho=$nderec) and (stzsolic.titular= stdobart.titular) and (stzdaper.titular= stdobart.titular)");
	  $regis = pg_fetch_array($resul_prod);
	  $filas_found=pg_numrows($resul_prod);
	  if ($filas_found >0)
	  {
      echo "<p align='center'><b><font size='3' face='Tahoma'>Artistas, Interpretes o Ejecutantes</font></b></p>";
      echo "<table border='0' cellpadding='1' cellspacing='1' width='100%'>";
      echo" <tr>";
      echo" <td width='10%' class='Estilo5'>C&eacute;dula / Rif</td>";
      echo"  <td width='20%' class='Estilo5'>Nombre</td>";
      echo"  <td width='20%' class='Estilo5'>Seud&oacute;nimo</td>";
      echo"  <td width='20%' class='Estilo5'>Domicilio</td>";
      echo"  <td width='10%' class='Estilo5'>Titular</td>";
      echo"</tr>";
     
     for($cont=0;$cont<$filas_found;$cont++) 
       { 
	      $domicilio=$regis['domicilio'].' / '.trim($regis['telefono1']);
         echo "<tr>";
         echo "<td width='10%' class='izq6a-color'>$regis[identificacion]</td>";
         echo "<td width='20%' class='izq6a-color'>$regis[nombre]</td>";  
         echo "<td width='20%' class='izq6a-color'>$regis[seudonimo]</td>";   
         echo "<td width='20%' class='izq6a-color'>$domicilio</td>"; 
         echo "<td width='10%' class='izq6a-color'>$regis[titular]</td>";    
         echo "</tr>";
         $regis = pg_fetch_array($resultado);
     }
  echo "</table>";
  }
  }

// Datos de las obras Fijadas 
  if ($reg['tipo_obra']=='PF' or $reg['tipo_obra']=='IE')
    {
     $res_fij=pg_exec("SELECT * FROM stdfijin WHERE nro_derecho='$nderec'");
     $resfij = pg_fetch_array($res_fij);
     $filas_found_regfij =pg_numrows($res_fij);
     if ($filas_found_regfij <> 0) 
      { 
       echo "<br>";  
       echo "<p align='center'><b><font size='4' face='Tahoma'>Obras Fijadas</font></b></p>";
       echo "<table border='0' cellpadding='1' cellspacing='1' width='100%'>";
       echo "<tr>";
       echo "<td width='10%' class='Estilo5'>T&iacute;tulo</td>";
       echo "<td width='20%' class='Estilo5'>Autor</td>";
       echo "<td width='20%' class='Estilo5'>Arreglos</td>";
       echo "<td width='10%' class='Estilo5'>Int&eacute;rprete</td>";
       echo "<td width='10%' class='Estilo5'>Tipo</td>";
       echo "</tr>";
      for($cont3=0;$cont3<$filas_found_regfij;$cont3++)
        {
         echo "<tr>";
         echo "<td width='20%' class='izq6a-color'>$resfij[titulo_obfija]</td>";
         echo "<td width='20%' class='izq6a-color'>$resfij[nombre_autor]</td>";     
         echo "<td width='10%' class='izq6a-color'>$resfij[arreglista]</td>"; 
         echo "<td width='20%' class='izq6a-color'>$resfij[interprete]</td>";
         echo "<td width='10%' class='izq6a-color'>$resfij[tipo_obfija]</td>";    
         echo "</tr>";    
         $resfij = pg_fetch_array($res_fij);
        }     
       echo "</table>";  
     }
   }

 //Datos del Solicitante
  if  (($reg['tipo_obra']=='IE') or ($reg['tipo_obra']=='OM')or($reg['tipo_obra']=='PF')or ($reg['tipo_obra']=='AC') or ($reg['tipo_obra']=='PC') or ($reg['tipo_obra']=='OL') or ($reg['tipo_obra']=='OE') or ($reg['tipo_obra']=='AV') or ($reg['tipo_obra']=='AR'))
  {
    $resultado=pg_exec("SELECT stzsolic.telefono1,stzsolic.nombre, stzsolic.identificacion, stdobsol.titular,stdobsol.domicilio FROM stzsolic, stdobsol WHERE (stdobsol.nro_derecho=$nderec) and (stzsolic.titular= stdobsol.titular)");   
    $filas_found=pg_numrows($resultado);
    $reg = pg_fetch_array($resultado);
    if ($filas_found<>0)
     {
      echo "<br>";  
      echo "<p align='center'><b><font size='3' face='Tahoma'>Solicitante</font></b></p>";
      echo "<table border='0' cellpadding='1' cellspacing='1' width='100%'>";
      echo "<tr>";
      echo "<td width='10%' class='Estilo5'>C&eacute;dula / Rif</td>";
      echo "<td width='20%' class='Estilo5'>Solicitante</td>";
      echo "<td width='20%' class='Estilo5'>Domicilio</td>";
      echo "<td width='10%' class='Estilo5'>Titular</td>";
     //td width="20%" class='izq3-color'>Pa&iacute;s
     //   Residencia</b></font></td> 
      echo "</tr>";
 
      for($cont=0;$cont<$filas_found;$cont++) 
        { 
	      $domicilio=$reg['domicilio'].' / '.trim($reg['telefono1']);
         echo "<tr>";
         echo "<td width='10%' class='izq6a-color'>$reg[identificacion]</td>";
         echo "<td width='20%' class='izq6a-color'>$reg[nombre]</td>";     
         echo "<td width='20%' class='izq6a-color'>$domicilio</td>"; 
         echo "<td width='10%' class='izq6a-color'>$reg[titular]</td>";    
         echo "</tr>";
         $reg = pg_fetch_array($resultado);
         }
       echo "</table>";
       }
     }  
 ?>
 <br>
<p align="center"><b><font size="3" face="Tahoma">Cronolog&iacute;a de Eventos</font></b></p>
<table border="1" cellpadding="1" cellspacing="1" width="100%">
  <tr>
    <td width="10%" class='Estilo5'>Fecha Evento</td>
    <td width="10%" class='Estilo5'>Evento</td>
    <td width="28%" class='Estilo5'>Descripci&oacute;n</td>
    <td width="10%" class='Estilo5'>Fecha Transacci&oacute;n</td>
    <td width="10%" class='Estilo5'>Documento</td>
    <td width="30%" class='Estilo5'>Comentario</td>
    <!-- <td width="10%" class='Estilo5'>Vencimiento</td> -->
    <td width="8%" class='Estilo5'>Doc</td>
    </tr>
<?php
   
   $resultado=pg_exec("SELECT * FROM stdevtrd WHERE nro_derecho=$nderec order by fecha_event,secuencial");   
   $filas_found=pg_numrows($resultado);

   $reg = pg_fetch_array($resultado);
   for($cont=0;$cont<$filas_found;$cont++) 
     { 
	    $evento= $reg[evento];
       echo "<tr>";
       echo "<td width='10%' class='izq6a-color'>$reg[fecha_event]</td>";
       echo "<td width='10%' class='izq6a-color'> $evento </td>";
       echo "<td width='28%' class='izq6a-color'>$reg[desc_evento]</td>";
       echo "<td width='10%' class='izq6a-color'>$reg[fecha_trans]</td>";
       echo "<td width='10%' class='izq6a-color'>$reg[documento]</td>";
       echo "<td width='30%' class='izq6a-color'>$reg[comentario]</td>";
       //echo "<td width='10%' class='izq6a-color'>$reg[fecha_venc]</td>";
       $imagenresultado = "../imagenes/ver_devolucion.png";
       $conpdf=0;
       if ($evento==94) { 
         //if ($estatus_ant==7) { 
           $archivodev = "../documentos/devueltas/autor/forma/".$varsol.".pdf";
         //   } 
         echo "<td width='10%' class='celda8'><a href='$archivodev' target='_blank'><img border='1' src='$imagenresultado' width='40' height='40'></a></td>";
         $conpdf=1;
       }
       echo "</tr>";
       $reg = pg_fetch_array($resultado);
     }
 ?>
</table>
&nbsp;
&nbsp; 

<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" height="15">
   <tr><td class="nota6"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Los datos emitidos por la siguiente consulta son netamente informativos, la informaci&oacute;n contenida en la presente p&aacute;gina no obliga ni compromete la responsabilidad del SAPI. Por lo anterior, no reemplaza en ning&uacute;n caso los mecanismos legales de notificaci&oacute;n y se constituye exclusivamente en una ayuda adicional para los usuarios de la misma.</b></td></tr>
   <tr><td class="nota6">&nbsp;</td></tr>
</table>

<table border="0" cellpadding="0" cellspacing="0" width="100%" height="15">
<?
  echo "<tr><td><p align='center'><img src='../imagenes/boton_imprimir_rojo.png' onclick='window.print();'>&nbsp;&nbsp;";
  echo "<a href=$vhomepage><img src='../imagenes/boton_nuevabusqueda_azul.png'></a>&nbsp;&nbsp;";
  echo "<img src='../imagenes/boton_cancelar_rojo.png' onclick='cerrarwindows();'></td></tr>";     
  echo "<tr><td>&nbsp;</td></tr>";
?>
</table>

&nbsp;
&nbsp; 

<?php
  echo "<div align='center'>";
  echo "<tr><td>&nbsp;</td></tr>";
  $smarty->display('pie_pag.tpl');
  echo "</div>";
?>

