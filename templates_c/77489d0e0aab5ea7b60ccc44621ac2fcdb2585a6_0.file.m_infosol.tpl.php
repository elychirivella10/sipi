<?php
/* Smarty version 3.1.47, created on 2022-10-17 17:20:46
  from '\var\www\apl\sipi\templates\m_infosol.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.47',
  'unifunc' => 'content_634d72ce8fd979_77652548',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '77489d0e0aab5ea7b60ccc44621ac2fcdb2585a6' => 
    array (
      0 => '\\var\\www\\apl\\sipi\\templates\\m_infosol.tpl',
      1 => 1436990833,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_634d72ce8fd979_77652548 (Smarty_Internal_Template $_smarty_tpl) {
?><html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body>

<?php if ($_smarty_tpl->tpl_vars['vopc']->value == 3) {?>
  <form name="forminfor" action="m_ingresol.php?vopc=3&conx=1&salir=1" method="post">
<?php }
if ($_smarty_tpl->tpl_vars['vopc']->value == 4) {?>
  <form name="forminfor" action="m_manteni.php?vopc=4" method="post">
<?php }
if ($_smarty_tpl->tpl_vars['vopc']->value == 5) {?>
  <form name="forminfor" action="m_reingres.php?vopc=5" method="post">
<?php }
if ($_smarty_tpl->tpl_vars['vopc']->value == 6) {?>
  <form name="forminfor" action="m_modregis.php?vopc=4" method="post">
<?php }?>

  <div align="center">

   <tr><td>&nbsp;</td></tr>
   <tr><td>&nbsp;</td></tr>
   <tr><td>&nbsp;</td></tr>
   <tr><td>&nbsp;</td></tr>
   <tr><td>&nbsp;</td></tr>
   <tr><td>&nbsp;</td></tr>
   <tr><td>&nbsp;</td></tr>
   <tr><td>&nbsp;</td></tr>
   <tr><td>&nbsp;</td></tr>
   <tr><td>&nbsp;</td></tr>
   <tr><td>&nbsp;</td></tr>
   <tr><td>&nbsp;</td></tr>

  <font size="4"><b>Estimado Usuario Transcriptor:</b></font></p>
  </p>

  <table width="35" >
   <tr>
    <font size="3"></p>
    Se les recuerda el grado de importancia que tiene para nuestra Instituci&oacute;n</p> la Unidad Receptora de Documentos asi como de carga inicial de los mismos al Sistema,</p> es por ello necesario cargar correctamente toda la informaci&oacute;n de los expedientes y escritos,</p> en virtud que los mismos es publicada en el Organo Oficial de Notificaci&oacute;n</p> como lo es el Bolet&iacute;n de la Propiedad Industrial. <p><small><I><b><blink><U>Recuerde que:</U></blink> Es obligatorio cargar el Rif en caso de Empresas Nacionales, <p> y/o la C&eacute;dula de Identidad del tramitante, agente y titular o solicitante si esta presente en el expediente. </b></I></small></font></p>
   </tr>
  </table>

  &nbsp;
  <table width="255" >
  <tr>
    <td class="cnt"><input type="image" src="../imagenes/boton_continuar_azul.png" value="Continuar"></td> 
    <td class="cnt"><a href="../index1.php"><img src="../imagenes/boton_salir_rojo.png" border="0"></a></td>
  </tr>
  </table>
  <br><br><br><br><br>
  </div>  
</form>
    
</body>
</html>
<?php }
}
