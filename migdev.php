<? 
   //para trabajar con smarty 
   //include("/apl/sipi/setting.inc.php");
   //include ("/apl/sipi/z_includes.php");   
   //Para trabajar con Operaciones de Bases de Datos
   include ("setting.inc.php");

   $sql = new mod_db();
   $sql->connection();   
   
   echo "<table>";
      
      kjhkh;
   $tabla1='solicitudes';
   $tabla2='deresol';
   $van = 0;
   $resultado=pg_exec("SELECT solicitud FROM $tabla1 order by solicitud");
   $reg = pg_fetch_array($resultado);
   $cantfil = pg_numrows($resultado);
   for ($cont=0;$cont<$cantfil;$cont++) {
       $vdoc   = $reg[solicitud];
       $resder = pg_exec("SELECT nro_derecho FROM stzderec WHERE tipo_mp='P' AND solicitud='$vdoc'");
       $fil = pg_numrows($resder);
       if ($fil != 0) {
         $van++;
         $regd = pg_fetch_array($resder);
         $vder = $regd[nro_derecho];
         $valores="'$vder','$vdoc'";
         $res_insert = $sql->insert("$tabla2","","$valores","");
       }
       $reg = pg_fetch_array($resultado);
   }
      
   // Mensaje final
   echo "<tr><td>De $cantfil, $van Registros actualizados en la tabla $tabla2</td></tr>"; 
   echo "</table>";   
   $sql->disconnect(); exit(); 
   
?>
