<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <script language="javascript" src="../include/cal2.js"></script>
  <script language="javascript" src="../include/cal_conf2.js"></script>
</head>

<body onLoad="this.document.{$varfocus}.focus()">

<div align="center">

<form name="formarcas2" enctype="multipart/form-data" action="m_ingwebfig.php?vopc=2" method="POST" onsubmit='return pregunta();'>
  <input type ='hidden' name='usuario' value={$usuario}>
  <input type ='hidden' name='modo' value={$vmodo}>
  <input type ='hidden' name='accion' value={$accion}>

  &nbsp;
  &nbsp;

  <table width="220" >
  <tr>
    <td class="cnt"><input tabindex="10" name="Guardar" type="image" src="../imagenes/dbrestore.png" value="Guardar">	Transferir 	</td> 
    <td class="cnt">
      {if $vopc eq 1 || $vopc eq 4}
         <a href="m_bexlogo.php?vopc=4"><img tabindex="11" src="../imagenes/cancel_f2.png" border="0"></a>  Cancelar   
      {/if}    
      {if $vopc eq 3}
         <a><img tabindex="12" src="../imagenes/cancel_f2.png" border="0"></a>  Cancelar  
      {/if}    
      {if $vopc eq 5}
         <a href="m_bexlogo.php?vopc=3"><img tabindex="12" src="../imagenes/cancel_f2.png" border="0"></a>  Cancelar  
      {/if}    
    </td>      
    <td class="cnt"><a href="../index1.php"><img tabindex="13" src="../imagenes/salir_f2.png" border="0"></a>	Salir 		</td>
  </tr>
  </table>

</form>
</div>  

</body>
</html>
