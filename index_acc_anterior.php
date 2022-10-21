<?
// No almacenar en el cache del navegador esta página.
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");             		// Expira en fecha pasada
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");		// Siempre página modificada
header("Cache-Control: no-store, no-cache, must-revalidate");  	// HTTP/1.1
header("Cache-Control: post-check=0, pre-check=0", false );
header("Pragma: no-cache");                                   		// HTTP/1.0
ob_start();
ob_end_clean(); 
?>
<html>
<title>&Aacute;rea de Ingreso - Sistema de Marcas, Patentes y DNDA</title>
<style type="text/css">
/* .botones {  font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 9pt; color: #FFFFFF; background-color: #00688b; border-color: #000000 ; border-top-width: 1pix; border-right-width: 1pix; border-bottom-width: 1pix; border-left-width: 1pix}
/* .imputbox {  font-size: 10pt; color: #000000; background-color: #C1C1C1; font-family: Verdana, Arial, Helvetica, sans-serif; border: 1pix #000000 solid; border-color: #000000 solid; font-weight: normal}
</style>

<body onLoad="this.document.acceso.user.focus()" bgcolor="#FFFFFF">

<br><br><br><br><br><br>
<table width="390" border="1" cellspacing="0" cellpadding="0" align="center" bordercolor="#0099FF">
  <tr>
    <td>
      <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#009999" bgcolor="#FFFFFF">
        <form name="acceso" action="index1.php" method="post">

          <tr bgcolor="#00688b">
            <td colspan="2" height="60"> 
              <div align="center"><font face="Arial" color="#FFFFFF" size=2><b>Identificaci&oacute;n
                Usuarios<br><font color="#FFFF00"></b></font></div>
              <div align="center"><font face="Arial" color="#FFFFFF" size=2><b>SIPI<br><font color="#FFFF00"></b></font></div>
                
            </td>
          </tr>
          <tr> 
            <td colspan="2"> 
              <div align="center"> 
                <table width="100%" border="0" cellspacing="0" cellpadding="5">
                  <tr valign="middle"> 
                    <td colspan="2" height="30"> 
                      <div align="center">

                         <?
                          // Mostrar error de Autentificación.
                          include ("aut_mensaje_error.inc.php");
                          if (isset($_GET['error_login'])){
                             $error=$_GET['error_login'];
                             echo "<font face='Verdana, Arial, Helvetica, sans-serif' size='1' color='#FF0000'>Error: $error_login_ms[$error]";
                          }
                         ?>
                         
                    </div>
                    </td>
                  </tr>
                  <tr> 
                    <td width="39%"> 
                      <div align="right"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Usuario 
                        : </font></div>
                    </td>
                    <td width="61%"> 
                      <div align="left"> 
                        <input type="text" name="user" size="15" class="imputbox">
                      </div>
                    </td>
                  </tr>
                 <!-- <tr> 
                    <td width="39%"> 
                      <div align="right"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Password LDAP o Internet
                        : </font></div>
                    </td>
                    <td width="61%"> 
                      <div align="left"> 
                        <input type="password" name="passldap" size="15" class="imputbox">
                      </div>
                    </td>
                  </tr> -->
                  <tr> 
                    <td width="39%"> 
                      <div align="right"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Password Sistema 
                        : </font></div>
                    </td>
                    <td width="61%"> 
                      <div align="left"> 
                        <input type="password" name="pass" size="15" maxlength="10" class="imputbox">
                      </div>
                    </td>
                  </tr>
                </table>
              </div>
            </td>
          </tr>
          <tr valign="middle"> 
            <td colspan="2" height="50"> 
              <div align="center"><font face="Arial" color="black" size="2"> 
                <input name="submit" type="submit" value="  Entrar  " class="botones">
                </font>
              </div>
            </td>
          </tr>
        </form>
      </table>
    </td>
  </tr>
</table>
<br><br><br><br><br><br><br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</body>
</html>
