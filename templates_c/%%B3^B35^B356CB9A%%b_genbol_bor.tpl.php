<?php /* Smarty version 2.6.8, created on 2022-02-11 20:12:59
         compiled from b_genbol_bor.tpl */ ?>
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

<body onLoad="this.document.<?php echo $this->_tpl_vars['varfocus']; ?>
.focus()">

<div align="center">

<!-- <?php if ($this->_tpl_vars['vopc'] == 3): ?>
  <form name="forboletin1" id="forboletin1" action="b_genbol.php?vopc=4" method="post">
<?php endif; ?>-->
<?php if ($this->_tpl_vars['vopc'] == 5): ?>
  <form name="forboletin1" id="forboletin1" action="b_genbol_bor.php?vopc=4" method="post">
<?php endif; ?> 
  <input type='hidden' name='nconex' value='<?php echo $this->_tpl_vars['n_conex']; ?>
'>
  <table width="390">
  <tr> 
    <tr>
      <br >
  <br >
   <br >
  <br >
      <td class="izq5-color"><?php echo $this->_tpl_vars['campo1']; ?>
</td>
      <td class="der-color">
         <input type="text" name="nbol" size="3" maxlength="3" >
       <!-- <input type="text" name="nbol" size="3" maxlength="3" value='<?php echo $this->_tpl_vars['nbol']; ?>
' <?php echo $this->_tpl_vars['modo']; ?>
 onKeyPress="return acceptChar(event,2, this)" >&nbsp;&nbsp; -->
      </td>	

        <td class="cnt">
          <input type="image" src="../imagenes/boletin.png" width="48" height="35" value="Generar Boletin">Generar Borrador de Boletin</td>
      <!--  </form> -->
  
      </td>
    </tr>
  </tr>
  </table>

<!--<form name="forboletin2" id="forboletin2" enctype="multipart/form-data" action="b_genbol.php?vopc=2" method="POST" onsubmit='return pregunta();'> -->
  <br >
  <br >
   <br >
  <br >
  <table width="200">
        <tr>
        <td class="cnt"><a href="b_genbol_bor.php?vopc=5&nconex=<?php echo $this->_tpl_vars['n_conex']; ?>
&salir=1&conx=0"><img src="../imagenes/cancel_f2.png" border="0"></a>  Cancelar  </td>
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