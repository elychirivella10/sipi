<? 
   //para trabajar con smarty 
   //include("/apl/sipi/setting.inc.php");
   //include ("/apl/sipi/z_includes.php");   
   //Para trabajar con Operaciones de Bases de Datos
   include ("setting.inc.php");
   include ("$include_lib/library.php");

   $sql = new mod_db();
   $sql->connection();   
   
   echo "<table>";
      
   $tabla1='stzotrde';
   $resultado=pg_exec("SELECT * FROM $tabla1 where hora='11:00:00 AM' order by fecha_dev");
   $reg = pg_fetch_array($resultado);
   $cantfil = pg_numrows($resultado);
   for ($cont=0;$cont<$cantfil;$cont++) {
     $vder  = $reg[nro_derecho];
     $derecho = $reg[derecho];
     $fdev  = $reg[fecha_dev];
     $grupo = $reg[grupo];
     $tipo  = $reg[tipo_dev];
     $horactual = Hora();
     $update_str = "hora='$horactual'";
     $condicion = "nro_derecho='$vder' AND fecha_dev='$fdev' AND derecho='$derecho' AND grupo='$grupo' AND tipo_dev='$tipo' AND hora='11:00:00 AM'";
     //echo "C=$update_str, $condicion ";
     $actprim = $sql->update("$tabla1","$update_str","$condicion");
     sleep(3);
     $reg = pg_fetch_array($resultado);
   }
   // Mensaje final
   echo "<tr><td>De $cantfil, Registros actualizados en la tabla $tabla1</td></tr>"; 
   echo "</table>";   
   $sql->disconnect(); exit(); 
   
?>
