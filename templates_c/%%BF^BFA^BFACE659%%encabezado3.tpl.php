<?php /* Smarty version 2.6.8, created on 2022-07-19 10:42:54
         compiled from encabezado3.tpl */ ?>
<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title><?php echo $this->_tpl_vars['titulo']; ?>
</title>
</head>

<header>

<body onload="mueveReloj()">

<div align="center">

<table width="977px" align="center">
 <tr>
  <td>

<table align="center" border="0" width="982px" height="50px" align="center">
  <tr>
    <td>
      <img src="../imagenes/header_sapi20.png" width="100%" height="80" /> 

      <!-- <img src="../imagenes/topesipi_fotografico.png" width="982px" height="152" /> --> 
    </td>
  </tr>
</table>

<table width="985px" align="center" >
  <tr height="30" >
    <td width="5%" class="subtitulo2">
      <b><i><a href="">Inicio</a></i></b>
    </td>
    <td width="5%" class="subtitulo2">
      <b><i><a href="http://www.sapi.gob.ve" target="blank">Sapi</a></i></b> 
    </td>
    <td width="5%" class="subtitulo2">
      <b><i><a href="http://correo.sapi.gob.ve" target="blank">Correo</a></i></b>
    </td>
    <td width="5%" class="subtitulo2">
      <b><i><a href="http://sire.sapi.gob.ve/" target="blank">Sire</a></i></b> 
    </td>
    <td width="12%" class="subtitulo2">
      <b><i><a href="http://www.bancodevenezuela.com/" target="blank">Banco de Venezuela</a></i></b>
    </td>
    <td width="42%" class="subtitulo1">
		<MARQUEE><b><i>Sistema Automatizado de Marcas, Patentes y Derecho de Autor&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Impulsando el Software Libre como parte del Gobierno Electr&oacute;nico</i></b></MARQUEE>
    </td>
  </tr>
</table>

<form name="form_reloj">

  <table width="985px">
   <tr>
    <td width="30%" class="izq2-color">
     <?php if ($this->_tpl_vars['login'] <> 'ngonzalez' && $this->_tpl_vars['login'] <> 'rmendoza'): ?>
         <font class="Estilo9">Usuario: <?php echo $this->_tpl_vars['login']; ?>
</font>
     <?php endif; ?>
    </td>
    <td width="40%" class="cnt-color3">
      <font class="Estilo10"><?php echo $this->_tpl_vars['subtitulo']; ?>
</font>
    </td>
    <td width="45%" class="der2-color">
      <font class="Estilo9"><?php echo $this->_tpl_vars['fechahoy']; ?>
</font>
    </td>
    </tr>
  </table>

<table width="985px" border="0" cellpadding="0" cellspacing="1" bgcolor="#FFFFFF">
  <tr>
    <td class="der">
      <div align="right">
        <I><font class="Estilo11"><b><?php echo $this->_tpl_vars['titulo']; ?>
</b></font></I>
            &nbsp;&nbsp;<font face="Arial" size="2" > 
            <input type="text" name="reloj" size="15" style="background-color : Rich Blue; color : Black; font-family : Verdana, Arial, Helvetica; font-size : 8pt; text-align : center; font-weight: bold;" onfocus="window.document.form_reloj.reloj.blur()"><br/>
            </font>


      </div>
    </td>
  </tr>
</table>

</form>