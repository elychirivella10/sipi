<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Servicio Autónomo de la Propiedad Intelectual</title>
</head><body onload="centrarwindows()" bgcolor="F9F7ED">   

<form action="" method="post" enctype="multipart/form-data" name="form1">
      Cantidad de archivos a subir:<br /><input name="cantidad" type="text" id="cantidad">
      <input type="submit" name="Submit" value="Submit"><br>

<?php      
    if(isset($_POST['Submit']))
    {
        echo "Elegir Imágenes para Subir<br>";
        for($i=1;$i<=$_POST['cantidad'];++$i)
        {
            echo "<input type='file' name='archivo[]'><br>";
        }
        echo "<input type='submit' name='Submit2' value='Submit2'>";
        echo "<input type='hidden' name='cant1' value='$i'>";
    }
    
    if(isset($_POST['Submit2']))
    {
        $cantidad2 =count($_FILES["archivo"]);
        for ($j=0;$j<=$_POST['cant1'];$j++)
        {
            $archivo = $_FILES["archivo"]["tmp_name"][$j];
            $tamanio = $_FILES["archivo"]["size"][$j];
            $tipo    = $_FILES["archivo"]["type"][$j];
            $nombre  = $_FILES["archivo"]["name"][$j];
            $x=$j;
           
            do
            {
                $x++;
                if( $archivo != "" )
                {
                    //Abrir y coger el contenido del fichero
                    $fp = fopen($archivo, "rb");
                    $contenido = fread($fp, $tamanio);
                    $contenido = addslashes($contenido);
                    fclose($fp);
                   
                    //Aqui mostramos el contenido del fichero
                    //También se podria guaradar en una base de datos
                    echo "<strong>Fichero ".$x."</strong>
                          <br><i>".$nombre."</i>
                          <br><br>".$contenido."<br><br>";
                }
            }
            while($x<$j);
        }
    }
?>       
</form>  
</html>
