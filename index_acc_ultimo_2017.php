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
<html>
<title>&Aacute;rea de Ingreso - Sistema de Marcas, Patentes y DNDA</title>
<style type="text/css">
/* .botones {  font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 9pt; color: #FFFFFF; background-color: #00688b; border-color: #000000 ; border-top-width: 1pix; border-right-width: 1pix; border-bottom-width: 1pix; border-left-width: 1pix}

</style>

<body onLoad="this.document.acceso.user.focus()" class="cuerpo">

<div align="center">
<table width="960px" border="0" celspadding="5" collspadding="5" class="cuerpo">
<tr>
<td>

<table border="0" cellspacing="0" cellpadding="0" bordercolor="#0099FF">
  <tr>
    <td width="620">
      <table border="0" cellpadding="0" cellspacing="0" bordercolor="#009999">
        <form name="acceso" action="index1.php" method="post">

          <!-- <tr bgcolor="#00688b">
            <td colspan="2" height="60"> 
              <div align="center"><font face="Arial" color="#FFFFFF" size=2><b>Identificaci&oacute;n
                Usuarios<br><font color="#FFFF00"></b></font></div>
            </td>
          </tr> -->
          <tr> 
            <td class="fondoacc" colspan="2" > 
              <div align="center"> 
                <table border="0" cellspacing="0" cellpadding="5">
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
                    <td width="25%"> 
                      <div align="right"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Usuario 
                        : </font></div>
                    </td>
                    <td width="61%"> 
                      <div align="left"> 
                        <input type="text" name="user" size="15" class="imputbox">
                      </div>
                    </td>
                  </tr>
                  <tr> 
                    <td width="25%"> 
                      <div align="right"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Password Sistema 
                        : </font></div>
                    </td>
                    <td width="61%"> 
                      <div align="left"> 
                        <input type="password" name="pass" size="15" maxlength="10" class="imputbox">
                      </div>
                    </td>
                  </tr>
                  <tr> 
                    <td>&nbsp;</td>
                    <td>
                      <p><a href=''><u><b>Olvido su clave ?</b></u></a></p>
                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="image" name="entrar" src="imagenes/botonentrarsesion.png" value="entrar"></a>
                    </td>                    
                  </tr>
                </table>
              </div>
            </td>
          </tr>
          <!-- <tr valign="middle"> 
            <td colspan="2" height="50"> 
              <div align="center"><font face="Arial" color="black" size="2"> 
                <input name="submit" type="submit" value="  Entrar  " class="botones">
                </font>
              </div>

            </td>
          </tr> -->
        </form>
      </table>
<!-- <br>&nbsp; -->
    </td>
  </tr>
</table>
</td>

<!-- <td width="337"> 
    <div align="justify"><font size="2">
    <I><u>Bienvenido al Sistema de Informaci&oacute;n de Propiedad Intelectual.</u> ( SIPI ) <p>
    Sistema el cual registra todas las gestiones administrativas de los eventos y actos relacionados a un expediente de Marcas, Patentes y Obra de Autor, informaci&oacute;n que puede ser consultada, con la que se puede generar datos para el bolet&iacute;n, generar estad&iacute;sticas, generar reportes de control y/o auditorias, y realizar b&uacute;squedas foneticas y gr&aacute;ficas para el caso marcario.<p>
    <strong>NOTA: Recuerde el grado de importancia que tiene la clave de acceso al sistema SIPI, la cual es personal, privado, por lo que no puede ser transferido a otra persona, si esto ocurriera es bajo su total responsabilidad.</I></strong></p>
    </p>
    <br/>
    </font></div>
</td> -->

    <td width="310"> 
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <img src='imagenes/bienvenido_sesion.png' width="287" height="335"/>&nbsp;
    </td>


</table>
</div>

<br>

</td>
</tr>

<!-- <div align="center">
<table width="960px" border="0" celspadding="5" collspadding="5">
  <tr>
   <td>
    <font size="2">
    <blink><I><strong>ASI MISMO, SE INFORMA QUE <b>BAJO NINGUN CONCEPTO SE HARAN SOLICITUDES DE MODIFICACION, ELIMINACION Y CARGA DE DATOS,</b> SIN ESTAR REGISTRADOS EN EL SISTEMA DE REQUERIMIENTOS "SIRE" en http://sire.sapi.gob.ve. </I></strong></blink></font>
   </td>    
  </tr>
</table>
</div> -->

</table>

</body>
</html>
