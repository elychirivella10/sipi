<script language="Javascript"> 

function buscarconcedida(var1,var2,var3,var4,var5,var6,var7) { 
  open("adm_mconcedida.php?vsol="+var1.value+"-"+var2.value+"&vmod="+var3.value+"&vcod="+var4.value+"&vbol="+var5.value+"&vtip="+var6.value+"&pmar="+var7.value,"Ventana", "height=800,scrollbars=YES,titlebar=YES,menubar=NO,toolbar=NO,directories=NO,location=NO,status=NO,resizable=NO"); }

function pregunta() { 
  return confirm('Estas seguro de grabar la Informacion de la(s) Publicacion(es) ?'); }

function habilita(formulario,valor) {
   formulario.modal.value = valor;
   if (formulario.nbusfon.value==0) {
     alert('AVISO: NO puede seleccionar Marcas porque la cantidad es Cero ...!!!');
     formulario.rmodalidad[0].disabled = true;
     formulario.rmodalidad[1].disabled = false
     formulario.vvienai.disabled = true;
     formulario.vvienae.disabled = true;
   }
   else {
     formulario.vvienai.disabled = false;
     formulario.vvienae.disabled = false;
     formulario.vvienai.focus()
   }
} 

function deshabilita(formulario,valor) {  
   formulario.modal.value = valor;
   if (formulario.nbusgra.value==0) {
     alert('AVISO: NO puede seleccionar Patentes porque la cantidad es Cero ...!!!');
     formulario.rmodalidad[0].disabled = false;
     formulario.rmodalidad[1].disabled = true
     formulario.vvienai.disabled = true;
     formulario.vvienae.disabled = true;
   }
   else {
     formulario.vvienai.disabled = false;
     formulario.vvienae.disabled = false;
     formulario.vvienai.focus()
   }
} 

</script>

<?php
// *************************************************************************************
// Programa: z_ingdermarnac.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Desarrollado en Año: 2016 II Semestre
// *************************************************************************************
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");
include ("../setting.mysql.php"); 
include("$include_lib/class.phpmailer.php"); 

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variables
$tbname_1 = "stztramite";
$tbname_5 = "stzsertra";
$tbname_6 = "stzusuar";
$fecha    = fechahoy();

$vopc       = $_GET['vopc'];
$banco      = $_POST['banco'];
$deposito   = $_POST['deposito'];
$fechadep   = $_POST['fechadep'];
$montodep   = $_POST['montodep'];
$banco1     = $_POST['banco1'];
$deposito1  = trim($_POST['deposito1']);
$fechadep1  = trim($_POST['fechadep1']);
$montodep1  = $_POST['montodep1'];
$rmodalidad = $_POST['rmodalidad'];
$accion     = $_POST['accion'];
$nbusfon    = $_POST['nbusfon'];
$nbusgra    = $_POST['nbusgra'];
$montofon   = $_POST['montofon'];
$montogra   = $_POST['montogra'];
$nboletin   = $_POST['nboletin'];
$usuario    = trim($_SESSION['usuario_login']);

$subtitulo  = "Servicio de Pago de Derechos de Registro de Marcas Nacionales";

// ****************************************
$smarty->assign('titulo',$titulo);
if (($vopc!=1) && ($vopc!=3) && ($vopc!=4)) {
  //$smarty->assign('subtitulo','Solicitud de B&uacute;squeda Fon&eacute;tica y/o Gr&aacute;fica'); 
}
if ($vopc==1) {
  //$smarty->assign('subtitulo','Solicitud de B&uacute;squeda Fon&eacute;tica y/o Gr&aacute;fica'); 
}
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->assign('boletinvigente',$boletinvigente);
$smarty->assign('fechatopepago30',$fechatopepago30);
if (empty($vopc) or ($vopc==1)) {
  $smarty->display('encabezado2.tpl'); }

$dia  = substr($fechadep,0,2);
$mes  = substr($fechadep,3,2);
$anno = substr($fechadep,6,4);
$vfechadep = $anno.'-'.$mes.'-'.$dia; 

if (!empty($fechadep1)) {
  $dia  = substr($fechadep1,0,2);
  $mes  = substr($fechadep1,3,2);
  $anno = substr($fechadep1,6,4);
  $vfechadep1 = $anno.'-'.$mes.'-'.$dia; 
}

//Verificando conexion a Mysql para consulta a facturacion
$mysql = new mod_mysql_db(); 
$mysql->connection_mysql();

if (($usuario!='rmendoza@sapi.gob.ve') AND ($usuario!='ngonzalez@sapi.gob.ve')) {
  //Verificación de Datos del Deposito en facturacion tabla sfa_txtdep   
  $objquery = $mysql->query_mysql("SELECT * FROM sfa_txtdep WHERE txt_numdep='$deposito' AND txt_fecha='$vfechadep' AND ef_rif='$banco' AND txt_abono=$montodep");  
  $objfilas = $mysql->nums_mysql('',$objquery);
  if ($objfilas==0) {
    $smarty->display('encabezado2.tpl');
    mensajenew('ERROR: Primer Dep&oacute;sito NO realizado en el Banco, debe haber sido realizado 24 Horas antes en el Banco o hay un error en el mismo ...!!!','javascript:history.back();','N');
    $mysql->disconnect_mysql(); 
    $smarty->display('pie_pag.tpl'); exit(); }

  if ((!empty($banco1)) && (!empty($deposito1)) && (!empty($fechadep1)) && (!empty($montodep1))) {
    //Verificación de Datos del Segundo Deposito en facturacion tabla sfa_txtdep   
    $objquery = $mysql->query_mysql("SELECT * FROM sfa_txtdep WHERE txt_numdep='$deposito1' AND txt_fecha='$vfechadep1' AND ef_rif='$banco1' AND txt_abono=$montodep1");  
    $objfilas = $mysql->nums_mysql('',$objquery);
    if ($objfilas==0) {
      $smarty->display('encabezado2.tpl');
      mensajenew('ERROR: Segundo Dep&oacute;sito NO realizado en el Banco, debe haber sido realizado 24 Horas antes en el Banco o hay un error en el mismo ...!!!','javascript:history.back();','N');
      $mysql->disconnect_mysql(); 
      $smarty->display('pie_pag.tpl'); exit(); }
  }
}

//echo "SELECT forma_fecha_dep FROM sfa_forma_pg WHERE forma_num_dep='$deposito' AND forma_fecha='$vfechadep' AND ef_rif='$banco'";
//Verificación de Datos del Deposito en facturacion tabla sfa_forma_pg
//$objquery = $mysql->query_mysql("SELECT forma_fecha_dep FROM sfa_forma_pg WHERE forma_num_dep='$deposito' AND forma_fecha='$vfechadep' AND ef_rif='$banco' AND forma_cod=1");  
//$objfilas = $mysql->nums_mysql('',$objquery);
//if ($objfilas!=0) {
//  $smarty->display('encabezado2.tpl');
//  mensajenew('ERROR: No. de Deposito YA existe en la Base de Datos, favor reviselo o dirijase a nuestra oficina en Caracas ...!!!','javascript:history.back();','N');
//  $mysql->disconnect_mysql(); 
//  $smarty->display('pie_pag.tpl'); exit(); }

if (($usuario!='rmendoza@sapi.gob.ve') AND ($usuario!='ngonzalez@sapi.gob.ve')) {
  $objquery = $mysql->query_mysql("SELECT fac_id FROM sfa_forma_pg WHERE forma_num_dep='$deposito' AND forma_fecha='$vfechadep' AND ef_rif='$banco' AND forma_cod=1");  
  $objfilas = $mysql->nums_mysql('',$objquery);
  if ($objfilas!=0) {
    $objs  = $mysql->objects_mysql('',$objquery);
    $facid = $objs->fac_id;
    //echo " son $objfilas con fac= $facid  ";
    $objanulada = $mysql->query_mysql("SELECT fac_id FROM sfa_devolucion WHERE fac_id=$facid");
    $objfilanul = $mysql->nums_mysql('',$objanulada);
    //echo " viene para anulada con $objfilanul ";
    if ($objfilanul==0) {
      $smarty->display('encabezado2.tpl');
      mensajenew('ERROR: Primer Dep&oacute;sito YA existe en la Base de Datos, favor reviselo o dirijase a nuestra oficina en Caracas ...!!!','javascript:history.back();','N');
      $mysql->disconnect_mysql(); 
      $smarty->display('pie_pag.tpl'); exit(); }
  }
}

//Verificación de Datos del Deposito en facturacion tabla sfa_forma_pg
if (($usuario!='rmendoza@sapi.gob.ve') AND ($usuario!='ngonzalez@sapi.gob.ve')) {
$objquery = $mysql->query_mysql("SELECT forma_fecha FROM sfa_forma_pg WHERE forma_nvouche_cheque='$deposito' AND forma_fecha='$vfechadep' AND ef_rif='$banco' AND forma_cod<>1");  
$objfilas = $mysql->nums_mysql('',$objquery);
if ($objfilas!=0) {
  $smarty->display('encabezado2.tpl');
  //mensajenew('ERROR: No. de Deposito YA existe en la Base de Datos, favor dirijase a nuestra oficina en Caracas ...!!!','javascript:history.back();','N');
  mensajenew('ERROR: El Valor introducido NO es un N&uacute;mero de Dep&oacute;sito ...!!!','javascript:history.back();','N');
  $mysql->disconnect_mysql(); 
  $smarty->display('pie_pag.tpl'); exit(); }

//Verificación de Datos del Segundo Deposito en facturacion tabla sfa_forma_pg
if ((!empty($banco1)) && (!empty($deposito1)) && (!empty($fechadep1))) {
  $objquery = $mysql->query_mysql("SELECT forma_fecha FROM sfa_forma_pg WHERE forma_nvouche_cheque='$deposito1' AND forma_fecha='$vfechadep1' AND ef_rif='$banco1' AND forma_cod<>1");  
  $objfilas = $mysql->nums_mysql('',$objquery);
  if ($objfilas!=0) {
    $smarty->display('encabezado2.tpl');
    //mensajenew('ERROR: No. de Deposito YA existe en la Base de Datos, favor dirijase a nuestra oficina en Caracas ...!!!','javascript:history.back();','N');
    mensajenew('ERROR: El Valor introducido en el segundo NO es un N&uacute;mero de Dep&oacute;sito ...!!!','javascript:history.back();','N');
    $mysql->disconnect_mysql(); 
    $smarty->display('pie_pag.tpl'); exit(); }
}    
}

 //Verificacion del Boletin
 $sql1 = new mod_db();
 $sql1->connection1();  

 $resultado=pg_exec("SELECT * FROM stzboletin WHERE nro_boletin = $nboletin");
 $filas_bol = pg_numrows($resultado);
 if ($filas_bol==0) {
   $smarty->display('encabezado2.tpl');
   mensajenew('AVISO: Boletin NO Existe o NO ha sido Generado por el RPI ...!!!','javascript:history.back();','N');
   $smarty->display('pie_pag.tpl'); exit();
 } else {
   $regbol = pg_fetch_array($resultado);
   $vfecvenbol = $regbol['fecha_2meses'];  
   $fechahoy = hoy();
   $esmayor=compara_fechas($fechahoy,$vfecvenbol);
   if ($esmayor==1) { 
     $smarty->display('encabezado2.tpl');
     mensajenew('AVISO: Fecha de Publicacion Extemporanea, ya pasaron los (2) dos meses de plazo para publicar ...!!!','javascript:history.back();','N');
     $smarty->display('pie_pag.tpl'); exit();
   }
 }

//Verificando conexion
$sql = new mod_db();
$sql->connection();

$contobji=0;
$vcodsede[$contobji] = '';
$vnomsede[$contobji] = '';
$objquery = $sql->query("SELECT * FROM stzbancos WHERE tipo=1 ORDER BY nombre");
$objfilas = $sql->nums('',$objquery);
$objs = $sql->objects('',$objquery);
for ($contobji=1;$contobji<=$objfilas;$contobji++) {
  $vcodban[$contobji] = $objs->rif;
  $vnomban[$contobji] = trim($objs->nombre);
  $objs = $sql->objects('',$objquery); }	  

$costo_fon = calculo_costo("N","PDM");

if (($vopc!=1) && ($vopc!=2) && ($vopc!=3) && ($vopc!=4)) {
  $smarty->assign('modo1',''); 
  $smarty->assign('modo2','disabled'); 
  //$smarty->assign('modo3','disabled'); 
  $smarty->assign('vmodo','readonly=readonly'); 
  $smarty->assign('modo','readonly=readonly'); 
}

if ($vopc==5) {
  $fechahoy = hoy();
  //echo "$banco $deposito $fechadep $montodep - $banco1 $deposito1 $fechadep1 $montodep1 ";
  
  //Verificacion de que los campos requeridos esten llenos...
  if (empty($deposito) || empty($fechadep) || empty($montodep)) {
     $smarty->display('encabezado2.tpl');
     mensajenew('AVISO: Hay Informacion b&aacute;sica en el formulario que esta Vacia ...!!!','javascript:history.back();','N');
     $smarty->display('pie_pag.tpl'); exit(); }

  if (!is_numeric($deposito)) {
     $smarty->display('encabezado2.tpl');
     mensajenew('ERROR: El N&uacute;mero del primer Deposito es Incorrecto ...!!!','javascript:history.back();','N');
     $smarty->display('pie_pag.tpl'); exit(); }

  $esmayor=compara_fechas($fechadep,$fechahoy);
  if ($esmayor==1) {
    $smarty->display('encabezado2.tpl');
    mensajenew("AVISO: La Fecha del Deposito No puede ser mayor a la de Hoy ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }

  $fechainicio = "01/09/2014"; // Inicio del Servicio de Busqueda por Webpi
  $esmayor=compara_fechas($fechainicio,$fechadep);
  if ($esmayor==1) {
    $smarty->display('encabezado2.tpl');
    mensajenew("AVISO: La Fecha del Deposito No puede ser Menor a $fechainicio ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }

  //Verificacion de si existe o no el Numero de Deposito en la BD... 
  $resultado=pg_exec("SELECT * FROM stztramite WHERE nro_deposito='$deposito' AND rif_banco='$banco' AND f_deposito='$fechadep'");
  $filas_found=pg_numrows($resultado); 
  if ($filas_found!=0) {
     $smarty->display('encabezado2.tpl');
     mensajenew('ERROR: N&uacute;mero del Primer Dep&oacute;sito YA existe en la Base de Datos ...!!!','javascript:history.back();','N');
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

  $resultado=pg_exec("SELECT * FROM stztramdep2 WHERE nro_deposito='$deposito' AND rif_banco='$banco' AND f_deposito='$fechadep'");
  $filas_found=pg_numrows($resultado); 
   if ($filas_found!=0) {
     $smarty->display('encabezado2.tpl');
     mensajenew('ERROR: N&uacute;mero del Primer Dep&oacute;sito YA existe en la Base de Datos ...!!!','javascript:history.back();','N');
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

  //Verificacion de si existe o no el Segundo Numero de Deposito en la BD... 
  if ((!empty($banco1)) && (!empty($deposito1)) && (!empty($fechadep1)) && (!empty($montodep1))) {
   $resultado=pg_exec("SELECT * FROM stztramite WHERE nro_deposito='$deposito1' AND rif_banco='$banco1' AND f_deposito='$fechadep1'");
   $filas_found=pg_numrows($resultado); 
    if ($filas_found!=0) {
      $smarty->display('encabezado2.tpl');
      mensajenew('ERROR: N&uacute;mero del Segundo Dep&oacute;sito YA existe en la Base de Datos ...!!!','javascript:history.back();','N');
      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

   $resultado=pg_exec("SELECT * FROM stztramdep2 WHERE nro_deposito='$deposito1' AND rif_banco='$banco1' AND f_deposito='$fechadep1'");
   $filas_found=pg_numrows($resultado); 
    if ($filas_found!=0) {
      $smarty->display('encabezado2.tpl');
      mensajenew('ERROR: N&uacute;mero del Segundo Dep&oacute;sito YA existe en la Base de Datos ...!!!','javascript:history.back();','N');
      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

    if (!empty($deposito1)) {
      if (!is_numeric($deposito1)) {
        $smarty->display('encabezado2.tpl');
        mensajenew('ERROR: El N&uacute;mero del Segundo Dep&oacute;sito es Incorrecto ...!!!','javascript:history.back();','N');
        $smarty->display('pie_pag.tpl'); exit(); }

      if ($deposito1==$deposito) {
        $smarty->display('encabezado2.tpl');
        mensajenew('ERROR: El N&uacute;mero del Segundo Dep&oacute;sito es identico al Primer Dep&oacute;sito ...!!!','javascript:history.back();','N');
        $smarty->display('pie_pag.tpl'); exit(); }
    }

    if (!empty($fechadep1)) {
      $esmayor=compara_fechas($fechadep1,$fechahoy);
      if ($esmayor==1) {
        $smarty->display('encabezado2.tpl');
        mensajenew("AVISO: La Fecha del Segundo Dep&oacute;sito No puede ser mayor a la de Hoy ...!!!","javascript:history.back();","N");
        $smarty->display('pie_pag.tpl'); exit(); }

      $fechainicio = "01/09/2014"; // Inicio del Servicio de Busqueda por Webpi
      $esmayor=compara_fechas($fechainicio,$fechadep1);
      if ($esmayor==1) {
        $smarty->display('encabezado2.tpl');
        mensajenew("AVISO: La Fecha del Segundo Dep&oacute;sito No puede ser Menor a $fechainicio ...!!!","javascript:history.back();","N");
        $smarty->display('pie_pag.tpl'); exit(); }
    }
  }

  //Verificacion del Monto ...
  if ($costo_fon < $costo_gra) {
    $costo_menor = $costo_fon;
  } else { $costo_menor = $costo_gra; }

  $monto_depositado = $montodep+$montodep1;
  //echo " $monto_depositado $montodep $montodep1 $costo_menor ";  

  if ($monto_depositado < $costo_menor) {
    $smarty->display('encabezado2.tpl');
    mensajenew("ERROR: Monto del Deposito menor al permitido ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit();
  }

  if (($nbusfon==0) AND ($nbusgra==0)) {
    $smarty->display('encabezado2.tpl');
    Mensajenew("ERROR: NO ha ingresado cantidad alguna de b&uacute;squedas Foneticas o Gr&aacute;ficas a realizar ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit();
  }

  $monto_fon = $nbusfon * $costo_fon;
  $monto_gra = $nbusgra * $costo_gra;
  $monto_acumulado = $monto_fon+$monto_gra;
  //$monto_depositado = $montodep+$montodep1;
 
  if ($monto_acumulado > 0) {
    if ($monto_acumulado > $monto_depositado) {
      $smarty->display('encabezado2.tpl');
      mensajenew("ERROR: Monto insuficiente para los Servicios a solicitar ...!!!","javascript:history.back();","N");
      $smarty->display('pie_pag.tpl'); exit();
    }
    if ($monto_depositado > $monto_acumulado) {
     $afavor = ($monto_depositado-$monto_acumulado);
     $caracter='.';
     $posicion = strpos($afavor, $caracter);
     if ($posicion === false) { $afavor = $afavor.".00"; } 
$smarty->assign('afavor',$afavor); 

    }
  }

  $caracter='.';
  $posicion = strpos($monto_depositado, $caracter);
  if ($posicion === false) { $monto_depositado = $monto_depositado.".00"; } 
  $caracter='.';
  $posicion = strpos($montofon, $caracter);
  if ($posicion === false) { $montofon = $montofon.".00"; } 
  $caracter='.';
  $posicion = strpos($montogra, $caracter);
  if ($posicion === false) { $montogra = $montogra.".00"; } 

  //La Fecha de Hoy para la solicitud
  $fecharec = hoy();
  $obj_query = $sql->query("update stzsystem set nro_tramite=nextval('stzsystem_nro_tramite_seq')");
  $obj_query = $sql->query("select last_value from stzsystem_nro_tramite_seq");
  $objs = $sql->objects('',$obj_query);
  $sys_actual = $objs->last_value;
  $vsol1 = $sys_actual;
  
  $smarty->assign('fecharec',$fecharec);
  $smarty->display('encabezado2.tpl');
  $smarty->assign('varfocus','formarcas2.rmodalidad');
  $smarty->assign('vmodo','readonly=readonly'); 
  $smarty->assign('modo1','disabled'); 
  $smarty->assign('modo','readonly=readonly'); 
  $smarty->assign('modo2','disabled'); 
  $smarty->assign('modo3','disabled'); 
  $smarty->assign('modo4',''); 
  $smarty->assign('accion',1);
  $smarty->assign('vsol1',$vsol1);
}

//Pase de variables y Etiquetas al template
$smarty->assign('campo1','Tr&aacute;mite Control No.: ');
$smarty->assign('campo2','Entidad Financiera:');
$smarty->assign('campo3','Deposito No.:');
$smarty->assign('campo4','Fecha Deposito:');
//$smarty->assign('campo5','Hora Deposito:');
//$smarty->assign('campo6','Monto Deposito Bs.:');
//$smarty->assign('campo7','Nombre o Denominaci&oacute;n a Buscar:');
//$smarty->assign('campo8','Clases:');
$smarty->assign('campo9','Cantidad de Marcas a Pagar:');
//$smarty->assign('campo10','Cantidad de Patentes a publicar:');
$smarty->assign('campo11','Del Bolet&iacute;n Vigente:');

if ($vopc==1) {
  $smarty->assign('varfocus','formarcas2.banco');
  $smarty->assign('modo3','disabled'); }

$blanco=0;
$blanco1='';
$cont=0;
$arrayannos[$cont]=$blanco;
$arraynameano[$cont]=$Blanco1;
$valorano = $topeanno;
$vannoini = $totalannos;
for($cont=1;$cont<$vannoini;$cont++) { 
  $arrayannos[$cont]  =$valorano;
  $arraynameano[$cont]=$valorano;
  $valorano = $valorano-1;
}

$smarty->assign('arrayannos',$arrayannos); 
$smarty->assign('arraynameano',$arraynameano);

$smarty->assign('vopc',$vopc);
$smarty->assign('usuario',$usuario);
$smarty->assign('vsol1',$vsol1);
$smarty->assign('banco',$banco);
$smarty->assign('deposito',$deposito);
$smarty->assign('fechadep',$fechadep);
$smarty->assign('montodep',$montodep);
$smarty->assign('banco1',$banco1);
$smarty->assign('deposito1',$deposito1);
$smarty->assign('fechadep1',$fechadep1);
$smarty->assign('montodep1',$montodep1);
$smarty->assign('costo_fon',$costo_fon);
$smarty->assign('costo_gra',$costo_gra);
$smarty->assign('nbusfon',$nbusfon);
$smarty->assign('nbusgra',$nbusgra);
$smarty->assign('montofon',$montofon);
$smarty->assign('montogra',$montogra);
$smarty->assign('vcodban',$vcodban);
$smarty->assign('vnomban',$vnomban); 
$smarty->assign('afavor',$afavor); 
$smarty->assign('nboletin',$nboletin);

$smarty->display('z_ingdermarnac.tpl');
$smarty->display('pie_pag2.tpl');

?>

