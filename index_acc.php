<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>&Aacute;rea de Ingreso - Sistema de Marcas, Patentes y DNDA</title>
  <script src="jquery-2.1.4.min.js" type="text/javascript"></script>
        <script>
        {literal}
          $("#for-pic1").hide();
          $("#for-pic1").show(3000);
        {/literal}
      </script>

</head>

<style type="text/css">
/* .botones {  font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 9pt; color: #FFFFFF; background-color: #00688b; border-color: #000000 ; border-top-width: 1pix; border-right-width: 1pix; border-bottom-width: 1pix; border-left-width: 1pix} */
</style>

<body onLoad="this.document.acceso.user.focus()" class="cuerpo">

<?php
// No almacenar en el cache del navegador esta página.
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");             		// Expira en fecha pasada
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");		// Siempre página modificada
header("Cache-Control: no-store, no-cache, must-revalidate");  	// HTTP/1.1
header("Cache-Control: post-check=0, pre-check=0", false );
header("Pragma: no-cache");                                   		// HTTP/1.0
ob_start();
ob_end_clean(); 
?>

<div align="center">
<table width="100%" border="0" celspadding="5" collspadding="5" class="cuerpo">
<tr>
<td>
<!-- 960px 620px -->
<table width="600px" border="0" cellspacing="0" cellpadding="0" bordercolor="#0099FF">
  <tr>
    <td >
      <table border="0" cellpadding="0" cellspacing="0" bordercolor="#009999">
        <form name="acceso" action="index1.php" method="post">
          <tr> 
            <td  colspan="3" > 
              <div align="center"> 
                <table border="0" cellspacing="0" cellpadding="4" >
                 <!-- style="background: rgba(84, 153, 199, 0.9); border: 1px solid rgba(100, 200, 0, 0.3);" -->
                  <tr valign="middle"> 
                    <td width="07%"> 
                      <!-- <div align="right"><img src="imagenes/control_play_blue.png" ></div> -->
                    </td>
                    <td colspan="2" height="24"> 
                      <div align="left">
                         <font class="titulo_sesion">Inicio de Sesi&oacute;n</font>
                         <?
                          // Mostrar error de Autentificación.
                          include ("aut_mensaje_error.inc.php");
                          if (isset($_GET['error_login'])){
                             $error=$_GET['error_login'];
                             echo "<font face='Verdana, Arial, Helvetica, sans-serif' size='1' color='#FF0000'><br>ERROR: $error_login_ms[$error]<br>";
                          }
                         ?>
                      </div>
                    </td>
                  </tr>
                  <tr> 
                    <td width="06%"> 
                      <!-- <div align="right"><img src="imagenes/user1.png" ></div> -->
                    </td>
                    <td width="20%"> 
                      <div align="left"> 
                        <font face="Verdana, Arial, Helvetica, sans-serif" size="3">Usuario: </font>
                        <input type="text" name="user" size="64" class="imputbox" placeholder="Cuenta Usuario">
                        &nbsp;
                      </div>
                    </td>
                    <td width="08%"> 
                      <!-- <div align="center"><a href='usuario_help.php'><img src="imagenes/servicios_faq.gif" width="40px"></a></div> -->
                    </td>
                  </tr>
                  <tr> 
                    <td colspan="3" height="15">
                      <p>&nbsp;</p>
                    </td> 
                  </tr>
                  <tr> 
                    <td width="06%"> 
                      <!-- <div align="right"><img src="imagenes/security_f2.png" ></div> -->
                    </td>
                    <td width="61%"> 
                      <div align="left"> 
                        <font face="Verdana, Arial, Helvetica, sans-serif" size="3">Clave: </font>
                        <input type="password" name="pass" size="64" maxlength="10" placeholder="Password o Clave del Usuario" class="imputbox">
                        <br><font face='Verdana, Arial, Helvetica, sans-serif' size="1">&nbsp;M&aacute;ximo 10 Caracteres</font></br>
                      </div>
                    </td>
                    <td width="08%"> 
                      <!-- <div align="center"><a href='clave_help.php'><img src="imagenes/servicios_faq.gif" width="40px"></a></div> -->
                    </td>
                  </tr>
                  <tr> 
                    <td colspan="3" height="15">
                      <p>&nbsp;</p>
                    </td> 
                  </tr>
                  <tr> 
                    <td width="06%"> 
                      <!--<div align="right"><img src="imagenes/servicios_contactenos.gif" width="35px"></div> --->
                      <!-- <div align="right"><img src="imagenes/messagebox_info.png" width="40px"></div>  -->
                    </td>
                    <td colspan="2" height="18">
                      <!-- <a href=''><u><b>Olvido su clave ?</b></u></a> -->
                    </td> 
                  </tr>
                  <tr> 
                    <td>&nbsp;</td>
                    <td>
                      <div align="right"> 
                        <input type="image" name="entrar" src="imagenes/botonentrar003.png"></a>
                      </div>
                    </td> 
                    <td>
                      &nbsp;
                    </td>
                  </tr>
                  <!-- <tr> 
                    <td colspan="3" height="18">
                      &nbsp;
                    </td> 
                  </tr> -->
                </table>
              </div>
            </td>
          </tr>
        </form>
      </table>
    </td>
  </tr>
</table>
</td>

    <td width="310"> 
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img id="for-pic1" src='imagenes/bienvenido_sesion.png' width="287" height="351"/>
    </td>


</table>
</div>

<br>

</td>
</tr>

</table>

</body>
</html>
