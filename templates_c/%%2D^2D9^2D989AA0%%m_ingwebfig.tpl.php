<?php /* Smarty version 2.6.8, created on 2021-08-12 15:42:01
         compiled from m_ingwebfig.tpl */ ?>
<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <script language="javascript" src="../include/cal2.js"></script>
  <script language="javascript" src="../include/cal_conf2.js"></script>
</head>

<body onLoad="this.document.<?php echo $this->_tpl_vars['varfocus']; ?>
.focus()">

<div align="center">

<form name="formarcas2" enctype="multipart/form-data" action="m_ingwebfig.php?vopc=2" method="POST" onsubmit='return pregunta();'>
  <input type ='hidden' name='usuario' value=<?php echo $this->_tpl_vars['usuario']; ?>
>
  <input type ='hidden' name='modo' value=<?php echo $this->_tpl_vars['vmodo']; ?>
>
  <input type ='hidden' name='accion' value=<?php echo $this->_tpl_vars['accion']; ?>
>

  &nbsp;
  &nbsp;

  <table width="220" >
  <tr>
    <td class="cnt"><input tabindex="10" name="Guardar" type="image" src="../imagenes/dbrestore.png" value="Guardar">	Transferir 	</td> 
    <td class="cnt">
      <?php if ($this->_tpl_vars['vopc'] == 1 || $this->_tpl_vars['vopc'] == 4): ?>
         <a href="m_bexlogo.php?vopc=4"><img tabindex="11" src="../imagenes/cancel_f2.png" border="0"></a>  Cancelar   
      <?php endif; ?>    
      <?php if ($this->_tpl_vars['vopc'] == 3): ?>
         <a><img tabindex="12" src="../imagenes/cancel_f2.png" border="0"></a>  Cancelar  
      <?php endif; ?>    
      <?php if ($this->_tpl_vars['vopc'] == 5): ?>
         <a href="m_bexlogo.php?vopc=3"><img tabindex="12" src="../imagenes/cancel_f2.png" border="0"></a>  Cancelar  
      <?php endif; ?>    
    </td>      
    <td class="cnt"><a href="../index1.php"><img tabindex="13" src="../imagenes/salir_f2.png" border="0"></a>	Salir 		</td>
  </tr>
  </table>

</form>
</div>  

</body>
</html>