<?php /* Smarty version 2.6.8, created on 2022-08-17 14:47:55
         compiled from a_asigregi_autp.tpl */ ?>
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
    <form name="formarcas1" action="a_asigregi_autp.php?vopc=1" method="post">
      <table>
        <tr><td class="izq5-color"><?php echo $this->_tpl_vars['lsolicitud']; ?>
</td>
	    <td class="der-color">
            <input type="text" name="vsol" size="6" maxlength="6" value='<?php echo $this->_tpl_vars['vsol']; ?>
' <?php echo $this->_tpl_vars['modo']; ?>
 
                   onKeyup="this.value=this.value.toUpperCase();"
                   onChange="Rellena(document.formarcas1.vsol,6)">
            <td class="cnt">
            <input type='image' src="../imagenes/boton_buscar_azul.png" value="Buscar"></td>
    </form>			  
    <form name="formarcas2" action="a_asigregi_autp.php?vopc=3" method="post" 
          onsubmit='return pregunta();'>
            <input type ='hidden' name='vsol' value='<?php echo $this->_tpl_vars['vsol']; ?>
'>
            <input type ='hidden' name='vder' value='<?php echo $this->_tpl_vars['vder']; ?>
'>
            <input type ='hidden' name='vannact' value='<?php echo $this->_tpl_vars['vannact']; ?>
'>
    	</tr>
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
     &nbsp;
     <table cellspacing="1" border="1">
       <tr><td class="izq-color"><?php echo $this->_tpl_vars['lfechavig']; ?>
</td>
	   <td class="der-color"><input size="10" type="text" name="vfechavig" 
                value='<?php echo $this->_tpl_vars['vfechavig']; ?>
' '<?php echo $this->_tpl_vars['vmodo1']; ?>
'  
                onkeyup="checkLength(event,this,10,document.formarcas2.vregistro)"
                onchange="valFecha(this,document.formarcas2.vregistro)"></td>
       </tr>
     </table>
     &nbsp;
     <table>
       <tr><td></td>
	   <td></td>
       </tr>
     </table>
     &nbsp;
     <B>Datos del Protocolo</B>
     &nbsp;
     <table cellspacing="1" border="1">
       <tr><td class="izq-color">Libro:</td>
	    <td class="der-color">
             <input type="text" name="vlib" size="6" maxlength="6" 
                   value=0 <?php echo $this->_tpl_vars['vmodo1']; ?>

                   onKeyPress="return acceptChar(event,2, this)"
                   onkeyup="checkLength (event,this,6,document.formarcas2.vann)"> </td></tr>
       <tr><td class="izq-color">Año:<?php echo $this->_tpl_vars['vannact']; ?>
</td>
	    <td class="der-color">
             <input type="text" name="vann" size="6" maxlength="4" 
                   value=0 <?php echo $this->_tpl_vars['vmodo1']; ?>
 
                   onKeyPress="return acceptChar(event,2, this)"
                   onkeyup="checkLength(event,this,4,document.formarcas2.vann)" 
                   onchange="valanno2(this,document.formarcas2.vannact)" > </td></tr>
       <tr><td class="izq-color">Trimestre:</td>
	    <td class="der-color">
             <input type="text" name="vtri" size="6" maxlength="6" 
                   value=0 <?php echo $this->_tpl_vars['vmodo1']; ?>
 
                   onKeyup="this.value=this.value.toUpperCase();" > </td></tr>
       <tr><td class="izq-color">Folio Inicial:</td>
	    <td class="der-color">
             <input type="text" name="vfoi" size="6" maxlength="6" 
                   value=0 <?php echo $this->_tpl_vars['vmodo1']; ?>
 
                   onKeyPress="return acceptChar(event,2, this)"
                   onkeyup="checkLength (event,this,6,document.formarcas2.vfof)" > </td></tr>
       <tr><td class="izq-color">Folio Final:</td>
	    <td class="der-color">
             <input type="text" name="vfof" size="6" maxlength="6" 
                   value=0 <?php echo $this->_tpl_vars['vmodo1']; ?>
 
                   onKeyPress="return acceptChar(event,2, this)"
                   onkeyup="checkLength (event,this,6,document.formarcas2.vfof)" > </td>
       </tr>
     </table>
     &nbsp;
     <table width="30%">
        <tr>
        <td class="cnt"><a href="a_rptcronol.php?vsol=<?php echo $this->_tpl_vars['vsol']; ?>
"><input type="image" src="../imagenes/boton_cronologia_rojo.png"></a></td>
        <td class="cnt"><input type="image" src="../imagenes/boton_guardar_rojo.png" value="Guardar"></td> 
        <td class="cnt"><a href="a_asigregi_autp.php"><img src="../imagenes/boton_cancelar_rojo.png" border="0"></a></td>
        <td class="cnt"><a href="../index1.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
	</tr>
     </table>
    </form>
  </div>  
  </body>
</html>
