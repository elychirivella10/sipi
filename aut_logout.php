<?
//  Autentificator
//  Gestión de Usuarios PHP+Mysql+sesiones
//  by Pedro Noves V. (Cluster)
//  clus@hotpop.com
//  Modificado por Ing. Romulo Mendoza
// -----------------------------------------

// Cargamos variables
require ("aut_config.inc.php");

// le damos un mobre a la sesion (por si quisieramos identificarla)
session_name($usuarios_sesion);
// iniciamos sesiones
session_start();
// destruimos la session de usuarios.
session_destroy();
?>
<html>
<head>
  <LINK REL="STYLESHEET" TYPE="text/css" HREF="main.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<table border="1" cellspacing="0" cellpadding="0" align="center" bordercolor="#0099FF" width="100%">
  <tr>
    <td>
      <table border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#009999" bgcolor="#FFFFFF"  class="salida">
          <tr bgcolor="#00688b">
            <td colspan="2" height="20"> 
              <div align="center"><font face="Arial" color="#FFFFFF" size=2><b>Hasta luego...!, que tenga un buen dia.<br><font color="#FFFF00"></b></font>
              </div>
            </td>
          </tr>
          <tr> 
            <td colspan="2"> 
              <div align="center"> 
                <table border="0" cellspacing="0" cellpadding="5">
                  <tr valign="middle"> 
                    <td colspan="2" height="30"> <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
                    </td>
                  </tr>
                </table>
              </div>
            </td>
          </tr>
          <tr valign="middle"> 
            <td colspan="2" height="50"> 
              <div align="center"><font face="Arial" color="black" size="2"> 
                <a href="index.php">
                 <input name="cerrar" type="button" value=" CERRAR " class="botones">
                </a>
              </div>
            </td>
          </tr>
      </table>
    </td>
  </tr>
</table>

</body>
</html>
