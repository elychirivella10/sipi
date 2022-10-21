<?php /* Smarty version 2.6.8, created on 2020-10-20 10:22:54
         compiled from z_rptuser.tpl */ ?>
<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <link rel="stylesheet" href="../include/template_css.css" type="text/css" />
</head>

<body onLoad="this.document.<?php echo $this->_tpl_vars['varfocus']; ?>
.focus()">

<!-- <h3> <?php echo $this->_tpl_vars['H3']; ?>
</h3> -->

<form name="forcronol" action="z_rptuser.php?vopc=2" method="POST">
  <div align="center">
  <input type='hidden' name='nconex' value='<?php echo $this->_tpl_vars['n_conex']; ?>
'>
  <input type='hidden' name='id_estado' value='<?php echo $this->_tpl_vars['id_estado']; ?>
'>

  <table >
  <tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo1']; ?>
</td>
      <td class="der-color">
	<input type="text" name="vuser" align="right" size="12" maxlength="12" value='<?php echo $this->_tpl_vars['vuser']; ?>
' onKeyPress="return acceptChar(event,0, this)" onkeyup="checkLength(event,this,12,document.forusing1.vcedula)" <?php echo $this->_tpl_vars['modo2']; ?>
 >
      </td>
    </tr>
    <tr>
      <td></td> 
      <td></td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo2']; ?>
</td>
      <td class="der-color">
       <input type="text" name="cedula" size="9" maxlength="9" value='<?php echo $this->_tpl_vars['cedula']; ?>
' <?php echo $this->_tpl_vars['modo2']; ?>
 onKeyPress="return acceptChar(event,2, this)">
      </td>
      <td class="cnt">
         <input type='image' src="../imagenes/buscar_f2.png" width="28" height="24" value="Buscar">  Buscar  
      </td>

    </tr>
    <tr>
      <td></td> 
      <td></td>
    </tr>
   
  </table><!--</font>--></center>
  <p></p>

  <table>
  <tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo3']; ?>
</td>
      <td class="der-color">
        <input type='text' name='nombre' value='<?php echo $this->_tpl_vars['nombre']; ?>
' <?php echo $this->_tpl_vars['modo2']; ?>
 size='80' maxlength="80" onKeyPress="return acceptChar(event,0, this)" onkeyup="checkLength(event,this,60,document.forusing1.email)">
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo4']; ?>
</td>
      <td class="der-color">
        <input type='text' name='email' value='<?php echo $this->_tpl_vars['email']; ?>
' <?php echo $this->_tpl_vars['modo2']; ?>
 size='80' maxlength="80"></td>
    </tr>
    <td class="izq-color" ><?php echo $this->_tpl_vars['campo5']; ?>
</td>
      <td class="der-color" >
        <input type='text' name='depto_id' value='<?php echo $this->_tpl_vars['depto_id']; ?>
' <?php echo $this->_tpl_vars['modo2']; ?>
 size='2' maxlength="2" <?php echo $this->_tpl_vars['modo2']; ?>
>-
        <input type='text' name='unidad' value='<?php echo $this->_tpl_vars['unidad']; ?>
' <?php echo $this->_tpl_vars['modo2']; ?>
 size='74' maxlength="77" <?php echo $this->_tpl_vars['modo2']; ?>
>
    </td>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo10']; ?>
</td>
      <td class="der-color">
        <input type='text' name='ingreso' value='<?php echo $this->_tpl_vars['ingreso']; ?>
' <?php echo $this->_tpl_vars['modo2']; ?>
 size='25' maxlength="25">
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo6']; ?>
</td>
      <td class="der-color" >
        <input type='text' name='estado' value='<?php echo $this->_tpl_vars['estado']; ?>
' <?php echo $this->_tpl_vars['modo2']; ?>
 size='10' maxlength="7">
      </td>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo7']; ?>
</td>
      <td class="der-color">
        <input type='text' name='rol' value='<?php echo $this->_tpl_vars['rol']; ?>
' <?php echo $this->_tpl_vars['modo2']; ?>
 size='10' maxlength="10">
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo7']; ?>
</td>
      <td class="der-color">
        <input type='text' name='namrol' value='<?php echo $this->_tpl_vars['namrol']; ?>
' <?php echo $this->_tpl_vars['modo2']; ?>
 size='70' maxlength="80">
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo8']; ?>
</td>
      <td class="der-color">
       <textarea onkeyUp="max(this,1000)" onkeyPress="max(this,1000)" onChange="Vacio(document.forrole.descripcion)" cols='88' rows='4' name='descripcion' value='<?php echo $this->_tpl_vars['descripcion']; ?>
' <?php echo $this->_tpl_vars['modo2']; ?>
><?php echo $this->_tpl_vars['descripcion']; ?>
</textarea>
    </tr>
    <tr>
      <td class="izq-color" ><?php echo $this->_tpl_vars['campo9']; ?>
</td>
      <td class="der-color">
        <input type='text' name='creacion' value='<?php echo $this->_tpl_vars['creacion']; ?>
' <?php echo $this->_tpl_vars['modo2']; ?>
 size='25' maxlength="25">
    </tr>

  </tr>
  </table>
  <p>EVENTOS ASIGNADOS</p>

  <iframe name='frmevmar' id='frmevmar' style='width:75%;height:150px' src="../comun/z_coneve.php?vrol=<?php echo $this->_tpl_vars['rol']; ?>
&vtipo=M"></iframe>
<p>&nbsp;</p>

  <iframe name='frmevpat' id='frmevpat' style='width:75%;height:150px' src="../comun/z_coneve.php?vrol=<?php echo $this->_tpl_vars['rol']; ?>
&vtipo=P"></iframe>
<p>&nbsp;</p>

  <iframe name='frmevpat' id='frmevpat' style='width:75%;height:150px' src="../comun/z_coneve.php?vrol=<?php echo $this->_tpl_vars['rol']; ?>
&vtipo=A"></iframe>


<table class="menubar2" cellpadding="0" cellspacing="0" border="1">
  <tr>
   <td class="menudottedline">
     <div class="pathway">
       <!--<img src="../imagenes/systeminfo.png"  align="left" border="0" /><br/>-->
     <p>
     <font size="-2">M&oacute;dulo:&nbsp;&nbsp;z_rptuser.php<p><p></b>Descripci&oacute;n: especificados.</font>
     </div>	
   </td>
   
   <td class="menudottedline" width="9%"></td>
      <td class="menudottedline" align="right">
	<table cellpadding="0" cellspacing="0" border="0" id="toolbar">
	  <tr valign="left" align="left">
	    <td>&nbsp;</td>
	    <td>
	      <a class="toolbar" href="../comun/z_rptuser.php?vopc=1">
	      <img src="../imagenes/cancel_f2.png" alt="&nbsp;Cancelar" name="Cancelar" title="Cancelar" align="left" border="0" /><br/>&nbsp;Cancelar</a>
	    </td>
	    <td>&nbsp;</td>
	    <td>
	      <a class="toolbar" href="../comun/z_rptusuar.php?vus=<?php echo $this->_tpl_vars['vuser']; ?>
&vcd=<?php echo $this->_tpl_vars['cedula']; ?>
">
	      <img src="../imagenes/print_f2.png" alt="&nbsp;Imprimir" name="Imprimir" title="Imprimir" align="left" border="0" /><br/>&nbsp;Imprimir</a>
	    </td>
	    <td>&nbsp;</td>
	    <td>
	      <a class="toolbar" href="../comun/z_rptusuart.php">
	      <img src="../imagenes/print_f2.png" alt="&nbsp;Imprimir" name="Imprimir" title="Imprimir" align="left" border="0" /><br/>&nbsp;Imp. Todos</a>
	    </td>
	    <td>&nbsp;</td>
	    <td>
	      <a class="toolbar" href="../comun/z_adminis.php">
	      <img src="../imagenes/salir_f2.png"  alt="&nbsp;Logout" name="Salir" title="Salir" align="left" border="0" /><br/>&nbsp;Salir</a>
	    </td>
	    <td>&nbsp;</td>
	 </tr>
	</table>
      </td>
   </td>
  </tr>
  </table>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  </center>

  </div>  
</form>

</body>
</html>