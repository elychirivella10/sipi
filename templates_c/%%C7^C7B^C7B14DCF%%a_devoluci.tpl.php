<?php /* Smarty version 2.6.8, created on 2020-10-21 14:03:40
         compiled from a_devoluci.tpl */ ?>
<html>
  <head>
    <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
    <title><?php echo $this->_tpl_vars['titulo']; ?>
</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  </head>

  <body onLoad="this.document.<?php echo $this->_tpl_vars['varfocus']; ?>
.focus()">
  
  <div align="center">
    <form name="formarcas1" action="a_devoluci.php?vopc=1" method="post">
      <table>
        <tr><td class="izq5-color"><?php echo $this->_tpl_vars['lsolicitud']; ?>
</td>
	    <td class="der-color">
            <input type="text" name="vsol" size="6" maxlength="6" value='<?php echo $this->_tpl_vars['vsol']; ?>
' <?php echo $this->_tpl_vars['modo']; ?>
 
                   onchange="Rellena(document.formarcas1.vsol,6)">
            <td class="cnt">
            &nbsp;<input type='image' src="../imagenes/boton_buscar_azul.png" value="Buscar"></td>
    </form>			  
    <form name="formarcas2" action="a_devoluci.php?vopc=3" method="post" 
          onsubmit='return pregunta();'>
            &nbsp;&nbsp;<input type='hidden' name='vsol' value=<?php echo $this->_tpl_vars['vsol']; ?>
>
    	    <td><?php echo $this->_tpl_vars['espacios']; ?>
</td>
	    <td class="izq5-color"><?php echo $this->_tpl_vars['lfechaevent']; ?>
</td>
	    <td class="der-color"><input size="10" type="text" name="vfevh" 
                value='<?php echo $this->_tpl_vars['vfec']; ?>
' onkeyup="checkLength(event,this,10,document.formarcas1.submit)"
                onchange="valFecha(this,document.formarcas2.otro)"><td></tr>
      </table>
      &nbsp; 
      <table cellspacing="1" border="1">	
        <tr><td class="izq-color"><?php echo $this->_tpl_vars['ltipo']; ?>
</td>
	    <td class="der-color"><input size="63" type="text" name="vtipo" 
                value='<?php echo $this->_tpl_vars['vtipo']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
></td>
        </tr>        
        <tr><td class="izq-color"><?php echo $this->_tpl_vars['ltitulo']; ?>
</td>
	    <td class="der-color"><input size="63" type="text" name="vtitu"       
                value='<?php echo $this->_tpl_vars['vtitu']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
></td>
	</tr>
        <tr><td class="izq-color"><?php echo $this->_tpl_vars['lfechasolic']; ?>
</td>
	    <td class="der-color"><input size="10" type="text" name="vfecsol" 
                value='<?php echo $this->_tpl_vars['vfecsol']; ?>
' <?php echo $this->_tpl_vars['vmodo']; ?>
></td>
   	</tr>
	<tr><td class="izq-color" ><?php echo $this->_tpl_vars['lsolicitante']; ?>
</td>
            <td class="der-color"><input size="63" type="text" name="vsolt"  
                value='<?php echo $this->_tpl_vars['vsolt']; ?>
' '<?php echo $this->_tpl_vars['vmodo']; ?>
'></td>
        </tr> 
      </table>
      <?php if ($this->_tpl_vars['vopc'] != 0): ?>
      <H3><?php echo $this->_tpl_vars['lcausadev']; ?>
</H3>
      <table cellspacing="1" border="1">	    
	<tr>
	 <td class="izq-color"><?php echo $this->_tpl_vars['uno']; ?>
</td><td class="der-color"><input type="checkbox" 
             name="causa1"><td>
	 <td class="der-color"><?php echo $this->_tpl_vars['luno']; ?>
</td>
	 <td class="izq-color"><?php echo $this->_tpl_vars['dos']; ?>
</td><td class="der-color"><input type="checkbox"  
             name="causa2"><td>
	 <td class="der-color"><?php echo $this->_tpl_vars['ldos']; ?>
</td></tr><tr>
	 <td class="izq-color"><?php echo $this->_tpl_vars['tres']; ?>
</td><td class="der-color"><input type="checkbox" 
             name="causa3"><td>
	 <td class="der-color"><?php echo $this->_tpl_vars['ltres']; ?>
</td>
	 <td class="izq-color"><?php echo $this->_tpl_vars['cuatro']; ?>
</td><td class="der-color"><input type="checkbox" 
             name="causa4"><td>
	 <td class="der-color"><?php echo $this->_tpl_vars['lcuatro']; ?>
</td></tr><tr>
	 <td class="izq-color"><?php echo $this->_tpl_vars['cinco']; ?>
</td><td class="der-color"><input type="checkbox"  
             name="causa5"><td>
	 <td class="der-color"><?php echo $this->_tpl_vars['lcinco']; ?>
</td>
	 <td class="izq-color"><?php echo $this->_tpl_vars['seis']; ?>
</td><td class="der-color"><input type="checkbox" 
             name="causa6"><td>
	 <td class="der-color"><?php echo $this->_tpl_vars['lseis']; ?>
</td></tr><tr>
	 <td class="izq-color"><?php echo $this->_tpl_vars['siete']; ?>
</td><td class="der-color"><input type="checkbox" 
             name="causa7"><td>
	 <td class="der-color"><?php echo $this->_tpl_vars['lsiete']; ?>
</td>
	 <td class="izq-color"><?php echo $this->_tpl_vars['ocho']; ?>
</td><td class="der-color"><input type="checkbox" 
             name="causa8"><td>
	 <td class="der-color"><?php echo $this->_tpl_vars['locho']; ?>
</td></tr><tr>
	 <td class="izq-color"><?php echo $this->_tpl_vars['nueve']; ?>
</td><td class="der-color"><input type="checkbox"  
             name="causa9"><td>
	 <td class="der-color"><?php echo $this->_tpl_vars['lnueve']; ?>
</td>
	 <td class="izq-color"><?php echo $this->_tpl_vars['diez']; ?>
</td><td class="der-color"><input type="checkbox" 
             name="causa10"><td>
	 <td class="der-color"><?php echo $this->_tpl_vars['ldiez']; ?>
</td></tr><tr>
	 <td class="izq-color"><?php echo $this->_tpl_vars['once']; ?>
</td><td class="der-color"><input type="checkbox" 
             name="causa11"><td>
	 <td class="der-color"><?php echo $this->_tpl_vars['lonce']; ?>
</td>
	 <td class="izq-color"><?php echo $this->_tpl_vars['doce']; ?>
</td><td class="der-color"><input type="checkbox" 
             name="causa12"><td>
	 <td class="der-color"><?php echo $this->_tpl_vars['ldoce']; ?>
</td></tr><tr>
	 <td class="izq-color"><?php echo $this->_tpl_vars['trece']; ?>
</td><td class="der-color"><input type="checkbox" 
             name="causa13"><td>
	 <td class="der-color"><?php echo $this->_tpl_vars['ltrece']; ?>
</td>
	 <td class="izq-color"><?php echo $this->_tpl_vars['catorce']; ?>
</td><td class="der-color"><input type="checkbox" 
             name="causa14"><td>
	 <td class="der-color"><?php echo $this->_tpl_vars['lcatorce']; ?>
</td></tr><tr>
	 <?php if ($this->_tpl_vars['lquince'] != ''): ?>
	 <td class="izq-color"><?php echo $this->_tpl_vars['quince']; ?>
</td><td class="der-color"><input type="checkbox" 
             name="causa15"><td>
	 <td class="der-color"><?php echo $this->_tpl_vars['lquince']; ?>
</td>
	 <?php endif; ?>
         <?php if ($this->_tpl_vars['ldieciseis'] != ''): ?>
	 <td class="izq-color"><?php echo $this->_tpl_vars['dieciseis']; ?>
</td><td class="der-color"><input type="checkbox" 
             name="causa16"><td>
	 <td class="der-color"><?php echo $this->_tpl_vars['ldieciseis']; ?>
</td>
	 <?php endif; ?>
	</tr>
	</table>
	<table>
	<tr>
	   <td class="izq-color"><?php echo $this->_tpl_vars['lotro']; ?>
</td><td class="der-color"><input size="90" type="text" 
               name="otro" maxlength="800"><td>
	</tr>
	</table>
     </table>
     <?php endif; ?>

     <br>
     <table width="20%">
        <tr>
        <td class="cnt"><input type="image" src="../imagenes/boton_guardar_rojo.png" value="Guardar"></td> 
        <td class="cnt"><a href="a_devoluci.php"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
        <td class="cnt"><a href="../index1.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
	</tr>
     </table>

    </form>
 <br> <br>
  </div>  
  </body>
</html>
