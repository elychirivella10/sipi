<? 
   //para trabajar con smarty 
   //include("/var/www/apl/sipi/setting.inc.php");
   //include ("/var/www/apl/sipi/z_includes.php");   
   //Para trabajar con Operaciones de Bases de Datos
   include ("/var/www/apl/sipi/setting.inc.php");

   $sql = new mod_db();
   $sql->connection();   
   
   echo "<table>";
      
   $tabla1='stmbufon';
   $tabla2='stmbusweb';
   $tabla3='stmbugra';
   
   $resultado=pg_exec("SELECT * FROM $tabla1 order by nro_busfon");
   $reg = pg_fetch_array($resultado);
   $cantfil = pg_numrows($resultado);
   for ($cont=0;$cont<$cantfil;$cont++) {
       $vnom    = $reg[denominacion];
       $fecha   = $reg[f_transac];
       $vclas   = $reg[clase];
       $vref    = $reg[nro_busfon];
       $vder    = $reg[nro_tramite];
       
       $update_str="nombre='$vnom',clase = $vclas,fecha_bus = '$fecha'";
       $sql->update("$tabla2","$update_str","nro_tramite='$vder' AND tipo_busq='F' AND ref_busq='$vref'");

       $reg = pg_fetch_array($resultado);
   }

   // Mensaje final
   echo "<tr><td>$cont Registros actualizados en la tabla $tabla</td></tr>"; 

   $resultado=pg_exec("SELECT * FROM $tabla3 order by nro_busgra");
   $reg = pg_fetch_array($resultado);
   $cantfil = pg_numrows($resultado);
   for ($cont=0;$cont<$cantfil;$cont++) {
       $fecha   = $reg[f_transac];
       $vclas   = $reg[clase];
       $vref    = $reg[nro_busgra];
       $vder    = $reg[nro_tramite];
       
       $update_str="clase = $vclas,fecha_bus = '$fecha'";
       $sql->update("$tabla2","$update_str","nro_tramite='$vder' AND tipo_busq='G' AND ref_busq='$vref'");

       $reg = pg_fetch_array($resultado);
   }

   // Mensaje final
   echo "<tr><td>$cont Registros actualizados en la tabla $tabla</td></tr>"; 

   echo "</table>";   
   $sql->disconnect(); exit(); 
   
?>
