<? 
   $archivo = "http://172.16.0.7/patente/venezuela/2002001804.PDF";
   //$archivo = "http://consulta.sapi.gob.ve/patente/venezuela/2002001804.PDF";

   if (file_exists($archivo)) {
     echo "¡El archivo $archivo existe!"; 
   } else {
     echo "¡El archivo $archivo no existe!"; }
  
?>
