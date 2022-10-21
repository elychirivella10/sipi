

<html>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

</style>
</head>

<body>
<div align="center">
<table>
<tr>
<td>
<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1" action="b_unionftp.php">
 <div align="center">
  <span class="style1"><b>Fusionar los Archivos PDF </b> </span><br />
  <br />
  Selecciones los archivos PDF: <br />
  <br />
  <input name="file[]" type="file" id="file[]" />
  <br />
  <input name="file[]" type="file" id="file[]" />
  <br />
  <input name="file[]" type="file" id="file[]" />
  <br />
  <input name="file[]" type="file" id="file[]" />
  <br />
  <input name="file[]" type="file" id="file[]" />
  <br />
  <br />
  
  <img src="../imagenes/Address.png" width="60" height="40" >
  <input type="submit" name="submit" value="Concatenar!" />
  <br />
  <br />

<!-- </form> -->
</td> 
 <td width="15"> 
</td>
</td> 
 <td width="180" align="center"> 
  <br> Recuerde 
   <img src="../imagenes/search.png" border="0"></a>  <br>Numerar las Paginas!</td>
  <br />
  <br /> 
</td>
<td>
 &nbsp; &nbsp; 
<!--  <form action="" method="post" enctype="multipart/form-data" name="form2" id="form2" action="b_unionftp.php?vopc=2" > -->
 <div align="center">
  <span class="style1"><b>Dividir en tomos el PDF </b> </span><br />
  <br >
  Documento Boletin.PDF: <br />
  <br />

  <br>
  Pag. Inicial: <input name="pag_ini" type="text" size="4" maxlength="4" >
    <br>
  Pag. Final: <input name="pag_fin" type="text" size="4" maxlength="4" >
    <br>
  Nombre: <input name="nombre" type="text" size="15" maxlength="15" >
  <br />
  <br />
  
  <img src="../imagenes/library.png" width="60" height="40" >
  <input type="submit" name="submit" value="Dividir!" />
  <br />
  <br />

</td> 
 &nbsp;
 
     <table width="210">
        <tr>
        <td class="cnt"><a href="b_unionftp.php?vopc=1&nconex={$n_conex}&salir=1&conx=0"><img src="../imagenes/cancel_f2.png" border="0"></a>  Cancelar  </td>
        <td class="cnt"><a href="../index1.php"><img src="../imagenes/salir_f2.png" border="0">
            </a>Salir</td>
	</tr>
     </table>
</form>				  
</div>  


</body>
</html>
