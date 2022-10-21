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

{if $vopc eq 5}
  <form name="forboletin1" id="forboletin1" action="b_pdfaviso.php?vopc=4" method="post">
{/if} 
  <input type='hidden' name='nconex' value='{$n_conex}'>
  <table width="450">
  <tr> 
    <tr>
      <br >
  <br >
   <br >
  <br >
      <td class="izq-color">{$campo1}</td>
      <td class="der-color">
         <input type="text" name="nbol" size="3" maxlength="3" >
      </td>	

        <td class="cnt">
          <input type="image" src="../imagenes/boletin.png" width="48" height="35" value="Generar">Generar</td>
  
      </td>
    </tr>
  </tr>
  </table>

  <br >
  <br >
   <br >
  <br >
  <table width="200">
        <tr>
        <td class="cnt"><a href="b_pdfaviso.php?vopc=5&nconex={$n_conex}&salir=1&conx=0"><img src="../imagenes/cancel_f2.png" border="0"></a>  Cancelar  </td>
        <td class="cnt"><a href="../index1.php"><img src="../imagenes/salir_f2.png" border="0">
            </a>Salir</td>
	</tr>
     </table>
    </td>
  </tr>
  </table>
</form>
</div>  
&nbsp;
</body>
</html>
