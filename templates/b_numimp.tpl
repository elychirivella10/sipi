

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
  <form name="forboletin1" id="forboletin1" action="b_numimp.php?vopc=2" method="post">
{/if}

  <div align="center">
  <span class="style1"><b>Orden de Numeros de Paginas a Imprimir </b> </span><br />
 <br />
  <br />

  <br>
  Pag. Inicial: <input name="pag_ini" type="text" size="4" maxlength="4" >
    <br>
  Pag. Final: <input name="pag_fin" type="text" size="4" maxlength="4" >
    <br>
  <br />
  <br />
  
  <img src="../imagenes/library.png" width="60" height="40" >
  <input type="submit" name="Submit" class="boton_blue" value="Calcular!" />
  <br />
  <br />

</td> 

  <br />
  <br />

     <table width="210">
        <tr>
        <td class="cnt"><a href="b_numimp.php?vopc=1&nconex={$n_conex}&salir=1&conx=0"><img src="../imagenes/cancel_f2.png" border="0"></a>  Cancelar  </td>
        <td class="cnt"><a href="../index1.php"><img src="../imagenes/salir_f2.png" border="0">
            </a>Salir</td>
	</tr>
     </table>
</form>				  
</div>  


</body>
</html>
