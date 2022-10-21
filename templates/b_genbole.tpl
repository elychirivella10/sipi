<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <link id="luna-tab-style-sheet" type="text/css" rel="stylesheet" href="../include/js/tabs/tabpane.css" />
  <script type="text/javascript" src="../include/js/tabs/tabpane.js"></script>
  <script language="JavaScript" src="../include/js/mambojavascript.js" type="text/javascript"></script>
  <script language="javascript" src="../include/cal2.js"></script>
  <script language="javascript" src="../include/cal_conf2.js"></script>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body onLoad="this.document.{$varfocus}.focus()">

<div align="center">

<!-- {if $vopc eq 3}
  <form name="forboletin1" id="forboletin1" action="b_genbol.php?vopc=4" method="post">
{/if}-->
{if $vopc eq 5}
  <form name="forboletin1" id="forboletin1" action="b_genbole.php?vopc=4" method="post">
{/if} 
  <input type='hidden' name='nconex' value='{$n_conex}'>
  <table width="340">
  <tr> 
    <tr>
     <br >
     <br >
     <br >
     <br >
      <td class="izq5-color">{$campo1}</td>
      <td class="der-color">
         <input type="text" name="nbol" size="3" maxlength="3" >
       <!-- <input type="text" name="nbol" size="3" maxlength="3" value='{$nbol}' {$modo} onKeyPress="return acceptChar(event,2, this)" >&nbsp;&nbsp; -->
      </td>	

        <td class="cnt">
          <input type="image" src="../imagenes/boletin.png" width="48" height="35" value="Generar Boletin">Generar Boletin</td>
      <!--  </form> -->
  
      </td>
    </tr>
  </tr>
  </table>

<!--<form name="forboletin2" id="forboletin2" enctype="multipart/form-data" action="b_genbol.php?vopc=2" method="POST" onsubmit='return pregunta();'> -->
  <br >
  <br >
  <table width="200">
   <tr>
     <td class="cnt"><a href="b_genbole.php?vopc=5"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
     <td class="cnt"><a href="../index1.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
	</tr>
  </table>
  </td>
  </tr>
  </table>
  <br >
  <br >
  <br >
  <br >
  <br >
      </form>
</div>  
&nbsp;
</body>
</html>
