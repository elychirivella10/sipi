

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
{if $vopc eq 1}
  <form name="forboletin1" id="forboletin1" action="b_unionftp.php?vopc=2" method="post">
{/if}
   Archivo: <input name="archivo1" type="text" size="20" maxlength="20" >
      <br>
   Archivo: <input name="archivo2" type="text" size="20" maxlength="20" >
      <br>
   Archivo: <input name="archivo3" type="text" size="20" maxlength="20" >
      <br>
   Archivo: <input name="archivo4" type="text" size="20" maxlength="20" >
      <br>
   Archivo: <input name="archivo5" type="text" size="20" maxlength="20" >
      <br>   <br>   <br>
  <img src="../imagenes/Address.png" width="60" height="40" >
  <input type="submit" name="Submit" class="boton_blue" value="Concatenar!" />
  <br />
  <br />

 
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
