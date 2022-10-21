<?
//Cabecera para generar xls //
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=archivo.xls");
//Fin Cabecera para generar xls //

// Lineas del Z_include.php //
$root_path    = "/var/www/apl/asistencia";
$include_lib  = "/var/www/apl/librerias";
$include_path = "$root_path/include";
//Para trabajar con Smarty 
require ("$root_path/include.php");
//Para trabajar con sessiones
require("$root_path/aut_verifica.inc.php");
//LLamadas a funciones de Libreria 
//include ("/var/www/apl/librerias/library.php");

$sql = new mod_db(); 
$db = mysql_connect("$mysql_host", "$mysql_usuario", "$mysql_pass");
mysql_select_db("$mysql_db");

// Descomentar ///////
//$fecha=fechahoy();
$vopc=$_POST['vopc'];
$vfec1=$_POST['vfec1'];
$vfec2=$_POST['vfec2'];
$vced=$_POST['vced'];
$vdep=$_POST['vdep'];
$vtip=$_POST['vtip'];
$vcom1=$_POST['vcom1'];
$vcom2=$_POST['vcom2'];
$vcom3=$_POST['vcom3'];
$vsyd=$_POST['vsyd'];
$vord1=$_POST['vord1'];
$vord2=$_POST['vord2'];
$vord3=$_POST['vord3'];
$vord4=$_POST['vord4'];
if (empty($vord1)) {$vord1='fecha';}
if (empty($vord2)) {$vord2='departamento';}
if (empty($vord3)) {$vord3='tipo';}
if (empty($vord4)) {$vord4='cedula';}
//$vfec1=substr($vfec1,6,4).'-'.substr($vfec1,3,2).'-'.substr($vfec1,0,2);
//$vfec2=substr($vfec2,6,4).'-'.substr($vfec2,3,2).'-'.substr($vfec2,0,2);
$cond="fecha between '$vfec1' and '$vfec2'";
if (!empty($vced)) {
   $cond=$cond." and a.cedula='$vced'";
} else {
  if ($vdep<>'--Todos--') {
      $cond=$cond." and departamento='$vdep'";
   }
   if ($vtip<>'--Todos--') {
      $cond=$cond." and tipo='$vtip'";
   }
}
if ($depaso<>'') {
   $cond=$cond." and departamento in (".$depaso.")";
}
if ($vcom1<>'--Todos--' and !empty($vcom1)) {
   if ($vcom1=='1') {$cond=$cond." and hora_entrada<'08:00:00'";}
   if ($vcom1=='2') {$cond=$cond." and hora_entrada between '08:00:00' and '08:15:00'";}
   if ($vcom1=='3') {$cond=$cond." and hora_entrada>'08:00:00'";}
   if ($vcom1=='4') {$cond=$cond." and hora_entrada>'08:15:00'";}
   if ($vcom1=='5') {$cond=$cond." and hora_entrada<>''";}
   if ($vcom1=='6') {$cond=$cond." and hora_entrada=''";}
}
if ($vcom2<>'--Todos--' and !empty($vcom2)) {
   if ($vcom2=='1') {$cond=$cond." and hora_salida<'16:30:00' and hora_salida<>'' and hora_entrada<>''";}
   if ($vcom2=='2') {$cond=$cond." and hora_salida>='16:30:00'";}
   if ($vcom2=='3') {$cond=$cond." and hora_salida='' and hora_entrada<>''";}
}
if ($vcom3<>'--No Aplicar--' and !empty($vcom3)) {
   if ($vcom3=='1') {$cond=$cond." and b.tipo like 'Vacac%'";}
   if ($vcom3=='2') {$cond=$cond." and b.tipo like 'Repos%'";}
   if ($vcom3=='3') {$cond=$cond." and b.tipo like 'Permi%'";}
   if ($vcom3=='4') {$cond=$cond." and b.tipo like 'Comis%'";}
   if ($vcom3=='5') {$cond=$cond." and b.tipo like 'Justi%'";}
   if ($vcom3=='6') {$cond=$cond." and b.tipo like 'Notif%'";}
   $mainquery="SELECT fecha,departamento,a.tipo,a.cedula,nombre,hora_entrada,hora_salida,tiempo_laborado FROM asistencia a, reganexos b WHERE a.cedula=b.cedula and fecha>=fecha_inicial and fecha<=fecha_final and ".$cond." order by ".$vord1.",".$vord2.",".$vord3.",".$vord4;
} else {
  $mainquery="SELECT * FROM asistencia a WHERE ".$cond." order by ".$vord1.",".$vord2.",".$vord3.",".$vord4;
}
$datos_compe = mysql_query($mainquery);
$filas_found=mysql_num_rows($datos_compe);

if ($filas_found>0) {
   echo "<table width='100%' border='0' align='center' cellpadding='0' cellspacing='0'>";
   echo "<tr>";
   echo "    <td width='8%'><div align='left'><font face='Arial' color='#000000' size='2'><b>Fecha</b></font></div></td>";
   echo "    <td width='14%'><div align='left'><font face='Arial' color='#000000' size='2'><b>Departamento</b></font></div></td>";
   echo "    <td width='8%'><div align='left'><font face='Arial' color='#000000' size='2'><b>Tipo</b></font></div></td>";
   echo "    <td width='8%'><div align='center'><font face='Arial' color='#000000' size='2'><b>Cedula</b></font></div></td>";
   echo "    <td width='18%'><div align='left'><font face='Arial' color='#000000' size='2'><b>Nombre</b></font></div></td>";
   echo "    <td width='8%'><div align='center'><font face='Arial' color='#000000' size='2'><b>Entrada</b></font></div></td>";
   echo "    <td width='8%'><div align='center'><font face='Arial' color='#000000' size='2'><b>Salida</b></font></div></td>";
   echo "    <td width='8%'><div align='center'><font face='Arial' color='#000000' size='2'><b>Trabajado</b></font></div></td>";
   echo "    <td width='20%'><div align='center'><font face='Arial' color='#000000' size='2'><b>Comentario</b></font></div></td>";
   echo "</tr>";
   $datcompe = mysql_fetch_array($datos_compe);
   $cont=0;
   for($cont=1;$cont<=$filas_found;$cont++) { 
       $v1=$datcompe['fecha'];
       $v11=$datcompe['fecha'];
       $v1=substr($v1,8,2).'/'.substr($v1,5,2).'/'.substr($v1,0,4);
       $v2=$datcompe['departamento'];
       $v3=$datcompe['tipo'];
       $v4=$datcompe['cedula'];
       $v5=$datcompe['nombre'];
       $v6=$datcompe['hora_entrada'];
       $v7=$datcompe['hora_salida'];
       $v71=$datcompe['hora_salida'];
       $v8=$datcompe['tiempo_laborado']; 
       if ($v6=='') {$v6='Inasistente';} 
       if ($v7<>'' and $v7>='13:00:00') { 
          $hv7=substr($v7,0,2)-12;
          if ($hv7<10) {$hv7='0'.$hv7;}
          $v7=$hv7.substr($v7,2,6);  
       }
       $v9='';
       // Buscar en registros anexos
       $datos_anexos = mysql_query("SELECT * FROM reganexos WHERE cedula='".$v4."'");
       $filas_anexos=mysql_num_rows($datos_anexos);
       if ($filas_anexos>0) {
           $datanexos = mysql_fetch_array($datos_anexos);
           for($conta=1;$conta<=$filas_anexos;$conta++) { 
              $f1=$datanexos['fecha_inicial'];    
              $f2=$datanexos['fecha_final'];    
              if ($v11>=$f1 and $v11<=$f2) {$v9=$v9.$datanexos['tipo'].' '.trim($datanexos['comentario']);}    
              $datanexos = mysql_fetch_array($datos_anexos);
           }
       }
       $df='';
       // Buscar en feriados
       $datos_feriado=mysql_query("SELECT * FROM diaferiado WHERE diaferiado='".$v11."'");
       $filas_feriado=mysql_num_rows($datos_feriado);
       if ($filas_feriado>0) {
          $datferiado = mysql_fetch_array($datos_feriado);
          $df='Feriado: '.trim($datferiado['describe']);    
       }
       // dia de la semana
       $adia=array(0 => "Domingo",1 => "Lunes",2 => "Martes",3 => "Miercoles",4 => "Jueves",5 => "Viernes",6 => "Sabado");
       $vdia=date("w", mktime(0, 0, 0, substr($v11,5,2), substr($v11,8,2), substr($v11,0,4) ));
       $dia=$adia[$vdia];
       if ($v6=='Inasistente' and $v9=='') {$v9=$dia.' '.$df;}
       if ( (($vdia==0 or $vdia==6) and $vsyd<>'NO') or ($vdia>0 and $vdia<6) ) {
          echo "<tr><td><div align='left'><font face='Arial' color='#000000' size='1'>$v1</font></div></td>";
          echo "    <td><div align='left'><font face='Arial' color='#000000' size='1'>$v2</font></div></td>";
          echo "    <td><div align='left'><font face='Arial' color='#000000' size='1'>$v3</font></div></td>";
          echo "    <td><div align='right'><font face='Arial' color='#000000' size='1'>$v4&nbsp;&nbsp;&nbsp;&nbsp;</font></div></td>";
          echo "    <td><div align='left'><font face='Arial' color='#000000' size='1'>$v5</font></div></td>";
          if ($v6>'08:00:00' and $v6<='08:15:00') {
             echo "    <td><div align='center'><font face='Arial' color='#00688b' size='1'>$v6</font></div></td>";
          }
          if ($v6=='Inasistente' or $v6>'08:15:00') {
             echo "    <td><div align='center'><font face='Arial' color='#800000' size='1'>$v6</font></div></td>";
          }
          if ($v6<='08:00:00') {
             echo "    <td><div align='center'><font face='Arial' color='#000000' size='1'>$v6</font></div></td>";
          }
          if ($v71<'16:30:00') {
             echo "    <td><div align='center'><font face='Arial' color='#800000' size='1'>$v7</font></div></td>";
          }
          if ($v71>='16:30:00') {
             echo "    <td><div align='center'><font face='Arial' color='#000000' size='1'>$v7</font></div></td>";
          }  
          echo "    <td><div align='center'><font face='Arial' color='#000000' size='1'>$v8</font></div></td>";
          echo "    <td><div align='center'><font face='Arial' color='#000000' size='1'>$v9</font></div></td>";
          echo "</tr>";       
       }
       $datcompe = mysql_fetch_array($datos_compe); 
   }
   echo "</table>";
}
echo "$mainquery,$filas_found";
?>

