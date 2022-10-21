<? 
   //para trabajar con smarty 
   include("../setting.inc.php");
   
   $sql = new mod_db();
   $sql->connection();   
   
   echo "<table>";
      
   $tabla1='stzroles';
   $tabla2='stzroles1';
   
   $resultado=pg_exec("SELECT * FROM $tabla2");
   $reg = pg_fetch_array($resultado);
   $cantfil = pg_numrows($resultado);
   for ($cont=0;$cont<$cantfil;$cont++) {
       $vrol=$reg[role]; 
       $vdes=$reg[descripcion];
       $update_str="descripcion = '$vdes'";
       $sql->update("$tabla1","$update_str","role='$vrol'");
       $reg = pg_fetch_array($resultado);
   }
   // Mensaje final *************************************
   echo "<tr><td>$cont Registros actualizados en la tabla $tabla1</td></tr>"; 
      
   $sql->disconnect(); exit(); 

   echo "</table>";   
?>
