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
      
   $van = 0;
   $tabla1='deresol';
   $tabla2='stzevtrd';
   $horactual = Hora();
   $fechahoy = hoy();
   $resultado=pg_exec("SELECT * FROM $tabla1 order by solicitud");
   $reg = pg_fetch_array($resultado);
   $cantfil = pg_numrows($resultado);
   //for ($cont=0;$cont<$cantfil;$cont++) {
   for ($cont=0;$cont<$cantfil;$cont++) {
       $vdoc  = $reg[solicitud];
       $vder  = $reg[nro_derecho];
       $resder = pg_exec("SELECT nro_derecho FROM stzevtrd WHERE nro_derecho='$vder' AND evento=2015");
       $fil = pg_numrows($resder);
       if ($fil==0) {
         $van++;
         $ressol = pg_exec("SELECT estatus FROM stzderec WHERE nro_derecho='$vder' AND tipo_mp='P'");
         $regsol = pg_fetch_array($ressol);
         $vest = $regsol[estatus];
         $col_campos = "nro_derecho,evento,fecha_event,secuencial,estat_ant,documento,fecha_trans,usuario,desc_evento,hora";
         $insert_str = "'$vder',2015,'$fechahoy',nextval('stzevtrd_secuencial_seq'),$vest,0,'$fechahoy','malvarez','MEMORIA DESCRIPTIVA DIGITALIZADA','$horactual'";
         $instram = $sql->insert("stzevtrd","$col_campos","$insert_str","");
       }
       $reg = pg_fetch_array($resultado);
   }
      
   // Mensaje final
   echo "<tr><td>De $cantfil, $van Registros actualizados en la tabla $tabla2</td></tr>"; 
   echo "</table>";   
   $sql->disconnect(); exit(); 
   
?>
