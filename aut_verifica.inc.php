<?
//  Autentificator
//  Gesti�n de Usuarios PHP+Mysql+sesiones
//  by Pedro Noves V. (Cluster)
//  clus@hotpop.com
//  v1.0  - 17/04/2002 Versi�n inicial.
//  v1.01 - 24/04/2002 Solucionado error sintactico en aut_verifica.inc.php.
//  v1.05 - 17/05/2002 Optimizaci�n c�digo aut_verifia.inc.php
//  v1.06 - 03/06/2002 Correcci�n de errores de la versi�n 1.05 y error con navegadores Netscape
//  v2.00 - 18/08/2002 Optimizaci�n c�digo + Seguridad.
//                     Ahora funciona con la directiva registre_globals= OFF. (PHP > 4.1.x)
//                     Optimizaci�n Tablas SQL. (rangos de tipos).
//  v2.01 - 16/10/2002 Solucionado "despistes" de la versi�n 2.00 de Autentificator
//                     en aut_verifica.inc.php y aut_gestion_usuarios.php que ocasionavan errores
//                     al trabajar con la directiva registre_globals= OFF.
//                     Solucionado error definici�n nombre de la sessi�n.
//
// Modificado por Ing. Romulo Mendoza (Caracas - Venezuela)
// Descripci�n:
// Gesti�n de P�ginas restringidas a Usuarios, con nivel de acceso
// y gesti�n de errores en el Login
// + administraci�n de usuarios (altas/bajas/modificaciones)
//
// Licencia GPL con estas extensiones:
// - Uselo con el fin que quiera (personal o lucrativo).
// - Si encuentra el c�digo de utilidad y lo usas, mandeme un mail si lo desea.
// - Si mejora el c�digo o encuentra errores, hagamelo saber el mail indicado.
//
// Instalaci�n y uso del Gestor de usuarios en:
// documentacion.htm
//  ----------------------------------------------------------------------------

// Motor autentificaci�n usuarios.

// Cargar datos conexion y otras variables.
require ("aut_config.inc.php");
// chequear p�gina que lo llama para devolver errores a dicha p�gina.
$url = explode("?",$_SERVER['HTTP_REFERER']);
$pag_referida=$url[0];
$redir=$pag_referida;

// chequear si se llama directo al script.
if ($_SERVER['HTTP_REFERER'] == ""){
  die ("Error cod.:1 - Acceso incorrecto!");
  exit;
}
// Chequeamos si se est� autentificandose un usuario por medio del formulario
if (isset($_POST['user']) && isset($_POST['pass'])) {

// Conexi�n base de datos.
// si no se puede conectar a la BD salimos del scrip con error 0 y
// redireccionamos a la pagina de error.

  $pg_usuario = $_POST['user'];
  //$pg_pass    = $_POST['pass'];

  // clave LDAP para verificacion contra servidor
  require ("../librerias/ldap.class.php");  

  $pasldap    = $_POST['passldap'];

  $info = true;
  //$ldap = new LDAP();
  //$info = $ldap->Verificar_Datos($pg_usuario,$pasldap);
  //echo "conexion= $info ";

  if ($info==true)
  {
   //echo "<br>se pudo conectar por el dominio.";
  }
  else 
  {
	 echo "<br>ERROR: La Clave de LDAP o de Internet NO es Correcta ...!!";
	 exit(); 	
  }

  //Para trabajar con Operaciones de Bases de Datos de Produccion
  include ("setting.inc.php");

  //Para trabajar con Smarty 
  require ("include.php");

  //Variables
  $sql_user = $_POST['user'];
  $sql_pass = $_POST['pass'];

  //if (empty($sql_user)) {  
  //  $smarty->display('encabezado.tpl');
  //  mensajenew('ERROR: No se introdujo el Usuario ...!!!','javascript:history.back();','N');
  //  $smarty->display('pie_pag.tpl'); exit(); }

  //echo "dbname=$sql_name host=$sql_host user=$sql_user password=$sql_pass";
  
  $db = pg_connect("dbname=$sql_name host=$sql_host user=$sql_user password=''");
  if (!$db) {
    //echo "ERROR: Fallo en la Conexi&oacute;n a PostgreSQL BD Producci&oacute;n... <br>\n"; exit(); } 
    $smarty->display('encabezado.tpl');
    echo "<br><br><br>";
    echo "<table width=60% border='0' align='center' cellpadding='0' cellspacing='0' bordercolor='#009999' bgcolor='#FFFFFF'>"; 
    echo "   <tr>";
    echo "     <td colspan='2' height='60'>";
    echo "        <img src='../imagenes/messagebox_warning.png' align='middle'>";
    echo "     </td>";
    echo "     <td colspan='2' height='60'>";
    echo "       <div align='center'><font face='Arial' color='#000000' size='2'><b>ERROR: Fallo en la Conexi&oacute;n a BD PostgreSQL; Usuario NO Existe ...!!! ...!!!<br><br><font color='#FFFF00'></b></font>";
    echo "       </div>";
    echo "     </td>";
    echo "   </tr>";
    echo "</table>";
    echo "<p align='center'><a href='javascript:history.back();'><img src='../imagenes/restore_f2.png' border='0' onclick='javascript:history.back()' ></a>  Volver  </p>";
    echo "<div align='center'>";
    echo "<tr><td>&nbsp;</td></tr>";
    echo "<tr><td>&nbsp;</td></tr>";
    $smarty->display('pie_pag.tpl');   
    echo "</div>";
    exit();
  }
   
//$db = pg_connect("dbname=bdrpi host=192.8.18.4 user=postgres password=") or die(header ("Location:  $redir?error_login=0"));

//$db_conexion= mysql_connect("$sql_host", "$sql_usuario", "$sql_pass") or die(header ("Location:  $redir?error_login=0"));
//mysql_select_db("$sql_db");

// realizamos la consulta a la BD para chequear datos del Usuario.

$usuario_consulta = pg_exec("SELECT id,usuario,pass,nivel_acceso,role,sede,nombre FROM stzusuar WHERE estatus='1' and role != '' and usuario='".$_POST['user']."'") or die(header ("Location:  $redir?error_login=1"));

//$usuario_consulta = mysql_query("SELECT ID,usuario,pass,nivel_acceso FROM $sql_tabla WHERE usuario='".$_POST['user']."'") or die(header ("Location:  $redir?error_login=1"));

 // miramos el total de resultado de la consulta (si es distinto de 0 es que existe el usuario)
 //if (mysql_num_rows($usuario_consulta) != 0) {
 if (pg_numrows($usuario_consulta) != 0) {

    // eliminamos barras invertidas y dobles en sencillas
    //$login = stripslashes($_POST['user']);
    $login = $_POST['user'];
    // encriptamos el password en formato md5 irreversible.
    $password = md5($_POST['pass']);

    // almacenamos datos del Usuario en un array para empezar a chequear.
    // $usuario_datos = mysql_fetch_array($usuario_consulta);
    $usuario_datos = pg_fetch_array($usuario_consulta);
  
    // liberamos la memoria usada por la consulta, ya que tenemos estos datos en el Array.
    // mysql_free_result($usuario_consulta);
    // cerramos la Base de dtos.
    // mysql_close($db_conexion);
    
    // chequeamos el nombre del usuario otra vez contrastandolo con la BD
    // esta vez sin barras invertidas, etc ...
    // si no es correcto, salimos del script con error 4 y redireccionamos a la
    // p�gina de error.

    if ($login != trim($usuario_datos['usuario'])) {
       Header ("Location: $redir?error_login=4");
       exit; }

    // si el password no es correcto ..
    // salimos del script con error 3 y redireccinamos hacia la p�gina de error
    if ($password != trim($usuario_datos['pass'])) {
        Header ("Location: $redir?error_login=3");
        exit; }

    // Paranoia: destruimos las variables login y password usadas
    unset($login);
    unset ($password);

    // En este punto, el usuario ya esta validado.
    // Grabamos los datos del usuario en una sesion.
    
    // le damos un mobre a la sesion.
    session_name($usuarios_sesion);
    // incia sessiones
    session_start();

    // Paranoia: decimos al navegador que no "cachee" esta p�gina.
    session_cache_limiter('nocache,private');
    
    // Asignamos variables de sesi�n con datos del Usuario para el uso en el
    // resto de p�ginas autentificadas.

    // definimos usuarios_id como IDentificador del usuario en nuestra BD de usuarios
    $_SESSION['usuario_id']=$usuario_datos['id'];
    
    // definimos usuario_nivel con el Nivel de acceso del usuario de nuestra BD de usuarios
    $_SESSION['usuario_nivel']=$usuario_datos['nivel_acceso'];
    
    //definimos usuario_nivel con el Nivel de acceso del usuario de nuestra BD de usuarios
    $_SESSION['usuario_login']=$usuario_datos['usuario'];

    //definimos usuario_password con el password del usuario de la sesi�n actual (formato md5 encriptado)
    $_SESSION['usuario_password']=$usuario_datos['pass'];
    $_SESSION['usuario_rol']=$usuario_datos['role'];
    $_SESSION['usuario_sede']=$usuario_datos['sede'];
    $_SESSION['usuario_nombre']=$usuario_datos['nombre'];

    // Hacemos una llamada a si mismo (scritp) para que queden disponibles
    // las variables de session en el array asociado $HTTP_...
    $pag=$_SERVER['PHP_SELF'];
    Header ("Location: $pag?");
    exit;
    
 } else {
    // si no esta el nombre de usuario en la BD o el password ..
    // se devuelve a pagina q lo llamo con error
    Header ("Location: $redir?error_login=2");
    exit; }
} else {

// -------- Chequear sesi�n existe -------

// usamos la sesion de nombre definido.
session_name($usuarios_sesion);
// Iniciamos el uso de sesiones
if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 


// Chequeamos si estan creadas las variables de sesi�n de identificaci�n del usuario,
// El caso mas comun es el de una vez "matado" la sesion se intenta volver hacia atras
// con el navegador.

if (!isset($_SESSION['usuario_login']) && !isset($_SESSION['usuario_password'])){
  // Borramos la sesion creada por el inicio de session anterior
  session_destroy();
  die ("Error cod.: 2 - Acceso incorrecto!");
  exit; }

}
?>
