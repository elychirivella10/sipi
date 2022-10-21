<script language="JavaScript">
function pregunta() { 
  return confirm('Estas seguro de grabar la Informacion ?'); }

function browsesolicitante(var1,var2,var3) {
  this.interesado='Solicitante';
  open("adm_solobra.php?vsol="+var1.value+"&vtex="+var2.value+"&vmod="+var3.value+"&vtip="+this.interesado,"Ventana", "scrollbars=yes,toolbar=no,directories=no,menubar=no,status=no"); }

function browseautor(var1,var2,var3) {
  this.interesado='Autor';
  open("adm_solobra.php?vsol="+var1.value+"&vtex="+var2.value+"&vmod="+var3.value+"&vtip="+this.interesado,"Ventana", "scrollbars=yes,toolbar=no,directories=no,menubar=no,status=no"); }

function browsecoautor(var1,var2,var3) {
  this.interesado='Coautor';
  open("d_opinsoli.php?vsol="+var1.value+"&vtex="+var2.value+"&vmod="+var3.value+"&vtip="+this.interesado,"Ventana", "scrollbars=yes,toolbar=no,directories=no,menubar=no,status=no"); }

function browsetitular(var1,var2,var3) {
  this.interesado='Titular';
  open("adm_solobra.php?vsol="+var1.value+"&vtex="+var2.value+"&vmod="+var3.value+"&vtip="+this.interesado,"Ventana", "scrollbars=yes,toolbar=no,directories=no,menubar=no,status=no"); }

function browseproductor(var1,var2,var3) {
  this.interesado='Productor';
  open("adm_solobra.php?vsol="+var1.value+"&vtex="+var2.value+"&vmod="+var3.value+"&vtip="+this.interesado,"Ventana", "scrollbars=yes,toolbar=no,directories=no,menubar=no,status=no"); }

function browseeditor(var1,var2,var3) {
  this.interesado='Editor';
  open("adm_solobra.php?vsol="+var1.value+"&vtex="+var2.value+"&vmod="+var3.value+"&vtip="+this.interesado,"Ventana", "scrollbars=yes,toolbar=no,directories=no,menubar=no,status=no"); }

function browseatista(var1,var2,var3) {
  this.interesado='Atista';
  open("d_otrasati.php?vsol="+var1.value+"&vtex="+var2.value+"&vmod="+var3.value+"&vtip="+this.interesado,"Ventana", "scrollbars=yes,toolbar=no,directories=no,menubar=no,status=no"); }

</script> 
<?php
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variables
$usuario = $_SESSION['usuario_login'];
$login = $_SESSION['usuario_login'];
$role = $_SESSION['usuario_rol'];
$sql  = new mod_db();
$fecha   = fechahoy();
$horactual= date("h:i:s");
$vopc=$_GET['vopc'];
$vpla=$_GET['vpla'];
$vsol   =$_POST['vsol'];
$vfechas=$_POST['vfechas'];
$vnumpla=substr($_POST['vsol'],0,6);
$vtitulo=$_POST['vtitulo'];
$vpaisor=$_POST['vpaisor']; 
$vidioma=$_POST['vidioma']; 
$vtraduc=$_POST['vtraduc'];
$vanorea=$_POST['vanorea'];
$vanoppu=$_POST['vanoppu'];
$vgenero=$_POST['vgenero'];
$vgener2=$_POST['vgener2'];
$vritmo =$_POST['vritmo'];  
$vdescri=$_POST['vdescri'];
$vtit_oo=$_POST['vtit_oo'];
$vaut_oo=$_POST['vaut_oo'];
$vano_oo=$_POST['vano_oo'];
$votroto=$_POST['votroto'];
$vdesarg=$_POST['vdesarg'];
$vdesmus=$_POST['vdesmus'];
$vdesmov=$_POST['vdesmov'];
$vdat_pf=$_POST['vdat_pf'];
$vano_fs=$_POST['vano_fs'];
$vubi_ex=$_POST['vubi_ex'];
$vdat_pu=$_POST['vdat_pu'];
$vubi_ed=$_POST['vubi_ed'];
$vano_fi=$_POST['vano_fi'];
$vsop_fi=$_POST['vsop_fi'];
$vobs_fi=$_POST['vobs_fi'];
$vtransf=$_POST['vtransf'];
$vnum_ej=$_POST['vnum_ej'];
$vsop_de=$_POST['vsop_de'];
$vobs_de=$_POST['vobs_de'];
$vnum_ho=$_POST['vnum_ho'];
$vamplia=$_POST['vamplia'];
$vadicio=$_POST['vadicio'];
$vtipoed=$_POST['vtipoed'];
$vanopue=$_POST['vanopue'];
$vnoedic=$_POST['vnoedic'];
$vnoejem=$_POST['vnoejem'];
$vcar_ed=$_POST['vcar_ed'];
$vartis1=$_POST['vartis1'];
$vletra =$_POST['vletra'];  
$vclasif=$_POST['vclasif'];
$vorigen=$_POST['vorigen'];
$vforma =$_POST['vforma'];  
$vtip_od=$_POST['vtip_od'];
$vcla_oe=$_POST['vcla_oe'];
$vexhibi=$_POST['vexhibi'];
$vpublic=$_POST['vpublic'];
$vedific=$_POST['vedific'];
$vtip_fi=$_POST['vtip_fi'];
$vhoj_ad=$_POST['vhoj_ad'];
$solicitante  =$_POST['solicitante'];
$tipo_caracter=$_POST['tipo_caracter'];
$otro_caracter=$_POST['otro_caracter'];
$prueba_repres=$_POST['prueba_repres'];

$smarty->assign('vpla',$vpla);
$smarty->assign('vhora',$horactual);
$smarty->assign('vnumpla',$vnumpla);
$smarty->assign('tipo_soli',array(N,J));
$smarty->assign('soli_def',array('Natural','Juridico'));
$smarty->assign('tipo_carac',array(A,N,C,P,T,H,O));
$smarty->assign('carac_def',array('Autor','En Nombre del Titular','Por Cesi&oacute;n','Parte que Interviene','Como Titular Derivado','Heredero','Otro'));

// ******************************************************************************************
$smarty->assign('titulo','Sistema de Derecho de Autor');
if ($vopc<=5) {$literal='Ingreso'; $accion=2; $vac='I';} else {$literal='Modificacion'; $vac='M'; $accion=9;}
if ($vpla=='OL') {$smarty->assign('subtitulo',$literal.' / Obras Literarias');}
if ($vpla=='OM') {$smarty->assign('subtitulo',$literal.' / Obras Musicales');}
if ($vpla=='OE') {$smarty->assign('subtitulo',$literal.' / Obras Escenicas');}
if ($vpla=='AR') {$smarty->assign('subtitulo',$literal.' / Audiovisuales y Radiofonicas');}
if ($vpla=='AV') {$smarty->assign('subtitulo',$literal.' / Arte Visual');}
if ($vpla=='PC') {$smarty->assign('subtitulo',$literal.' / Prog.Computacion y B.Datos');}

$modulo = 'a_otrasobrnw.php '.$vpla;
$nconexion = $_POST['nconexion'];
if (empty($nconexion)) { $nconexion = $_GET['nconexion']; }
$nveces = $_POST['nveces'];
if (empty($nveces)) { $nveces = $_GET['nveces']; }
$nveces = $nveces+1;
if ($nveces==1) { $nconexion = insconex($usuario,$modulo,$vac); }
$smarty ->assign('nveces',$nveces); 
$smarty ->assign('nconexion',$nconexion);

$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

if ($vopc==3 or $vopc==7) {
  $smarty->assign('varfocus','foroobras.vsol');
  $smarty->assign('modo1','disabled'); 
  $smarty->assign('modo2',''); 
  $smarty->assign('bmodo','disabled'); 
}

if ($vopc==4 or $vopc==8) {
  if (empty($vsol)) {
     //Mensage_Error("No introdujo ning&uacute;n valor de Expediente ...!!!");
     mensajenew("No introdujo ning&uacute;n valor de Expediente ...!!!","javascript:history.back();","N");
     $smarty->display('pie_pag.tpl'); exit(); 
  } 

  //Verificando conexion
  if ($vopc==4) {
    $sql->connection($login);
    $res_obra = pg_exec("select * from stdobras where solicitud='$vsol'");
    $rega = pg_fetch_array($res_obra);
    $nfil = pg_numrows($res_obra);
    if ($nfil>0) {
     $sql->disconnect();
     mensajenew("Solicitud ya existe en la Base de Datos ...!!!","javascript:history.back();","N");
     $smarty->display('pie_pag.tpl'); exit(); } 
  
    // Se Limpian los temporales
    $sql->del("stdtmpso","solicitud='$vsol'"); //solicitante
    $sql->del("stdtmpau","solicitud='$vsol'"); //autor
    $sql->del("stdtmpti","solicitud='$vsol'"); //titular
    $sql->del("stdtmpco","solicitud='$vsol'"); //coautor
    $sql->del("stdtmppt","solicitud='$vsol'"); //productor
    $sql->del("stdtmped","solicitud='$vsol'"); //editor
    $sql->del("stdtmpar","solicitud='$vsol'"); //artista

    //La Fecha de Hoy para la solicitud
    $vfechas = hoy();
    $smarty->assign('vfechas',$vfechas);
    $smarty->assign('varfocus','forautor.vfechas');
    $smarty->assign('modo1',''); 
    $smarty->assign('modo2','disabled'); 
    $smarty->assign('bmodo','');  
  }

  if ($vopc==8) {
     // se inicializan las variables con la data almacenada
     $sql->connection($login);
     $res_obra = pg_exec("select * from stdobras where solicitud='$vsol'");
     $rega = pg_fetch_array($res_obra);
     $nfil=pg_numrows($res_obra);
     if ($nfil==0) {
        $sql->disconnect();
        mensajenew("Solicitud No existe en la Base de Datos..!!!",
                   "javascript:history.back();","N");
        $smarty->display('pie_pag.tpl'); exit(); 
     } 
     if ($vpla<>$rega['tipo_obra']) {
        $sql->disconnect();
        mensajenew("Solicitud corresponde a otro tipo de Obra...!!! ($rega[tipo_obra])",
                   "javascript:history.back();","N");
        $smarty->display('pie_pag.tpl'); exit(); 
     } 
     //obras
     $rega['tipo_obra'];
     $vfechas=$rega['fecha_solic'];
     $vnumpla=$rega['nplanilla'];
     $vtitulo=$rega['titulo_obra'];
     $vpaisor=$rega['pais_origen']; 
     $vidioma=$rega['cod_idioma']; 
     $vtraduc=$rega['traduccion'];
     $vanorea=$rega['anno_realiza'];
     $vanoppu=$rega['anno_1publica'];
     $vdescri=$rega['descrip_obra'];
     $vnum_ej=$rega['n_ejemplares'];
     $vsop_de=$rega['tipo_soporte'];
     $vobs_de=$rega['observacion'];
     $vnum_ho=$rega['n_hojas_adic'];
     $vamplia=$rega['datos_ampli'];
     $vadicio=$rega['datos_adicio'];
     $vclasif=$rega['clase'];
     $vorigen=$rega['origen'];
     $vforma =$rega['forma'];  
     $vder=$rega['nro_derecho'];   
     if ($vnum_ho>0) {$vhoj_ad='S';} else {$vhoj_ad='N';}
     //derivada
     $res_obra = pg_exec("select * from stdderiv where nro_derecho='$vder'");
     $rega = pg_fetch_array($res_obra); 
     $vtit_oo=$rega['titulo_original'];  
     $vaut_oo=$rega['datos_autor'];  
     $vtip_od=$rega['tipo_obra_deri'];  
     $vano_oo=$rega['anno_pub_orig'];  
     //transferencia
     $res_obra = pg_exec("select * from stdtrans where nro_derecho='$vder'");
     $rega = pg_fetch_array($res_obra); 
     $vtransf=$rega['transferencia'];  
     //solicitante
     $del_dattmp= $sql->del("stdtmpso","solicitud='$vsol'");
     $res_tab = pg_exec("select * from stdobsol a,stzsolic b 
                          where nro_derecho='$vder' and a.titular=b.titular");
     $rega = pg_fetch_array($res_tab); 
     $vartmp = llenatemporal('stdobsol','stdtmpso',$rega['titular'],$vsol);
     $tipo_caracter=$rega['caracter'];
     $otro_caracter=$rega['otro_caracter'];
     $prueba_repres=$rega['prueba_repres']; 
     //autor
     $del_dattmp= $sql->del("stdtmpau","solicitud='$vsol'");
     $res_tab = pg_exec("select * from stdobaut where nro_derecho='$vder' and tipo_autor='AU'");
     $rega = pg_fetch_array($res_tab); 
     $nfil = pg_numrows($res_tab);
     for ($i=0;$i<$nfil;$i++) {
         $vartmp=llenatemporal('stdobaut','stdtmpau',$rega['titular'],$vsol);
         $rega = pg_fetch_array($res_tab); 
     }
     //titular
     $del_dattmp= $sql->del("stdtmpti","solicitud='$vsol'");
     $res_tab = pg_exec("select * from stdobtit where nro_derecho='$vder'");
     $rega = pg_fetch_array($res_tab); 
     $nfil = pg_numrows($res_tab);
     for ($i=0;$i<$nfil;$i++) {
         $vartmp=llenatemporal('stdobtit','stdtmpti',$rega['titular'],$vsol);
         $update_str="titulo_legal='$rega[titulo_presun]',doc_trans='$rega[doc_transfer]'";
         $update_cond="Solicitud='$vsol' and codigo='$rega[titular]'";
         $ins_t= $sql->update("stdtmpti","$update_str","$update_cond");  
         $rega = pg_fetch_array($res_tab); 
     }
     //coautor
     $del_dattmp= $sql->del("stdtmpco","solicitud='$vsol'");
     $res_tab = pg_exec("select * from stdobaut where nro_derecho='$vder' and tipo_autor<>'AU'");
     $rega = pg_fetch_array($res_tab);
     $nfil = pg_numrows($res_tab);
     for ($i=0;$i<$nfil;$i++) {
         $vartmp=llenatemporal('stdobaut','stdtmpco',$rega['titular'],$vsol);
         //update para actualizar el campo tipo_coautor en stdtmpco
         $update_str="tipo_autor='$rega[tipo_autor]'";
         $update_cond="Solicitud='$vsol' and codigo='$rega[titular]' and tipo_autor is null";
         $ins_t= $sql->update("stdtmpco","$update_str","$update_cond");  
         $rega = pg_fetch_array($res_tab); 
     } 
     //productor
     $del_dattmp= $sql->del("stdtmppt","solicitud='$vsol'");
     $res_tab = pg_exec("select * from stdobpro where nro_derecho='$vder'");
     $rega = pg_fetch_array($res_tab); 
     $nfil = pg_numrows($res_tab);
     for ($i=0;$i<$nfil;$i++) {
         $vartmp=llenatemporal('stdobpro','stdtmppt',$rega['titular'],$vsol);
         $rega = pg_fetch_array($res_tab); 
     } 
     //editor
     $del_dattmp= $sql->del("stdtmped","solicitud='$vsol'");
     $res_tab = pg_exec("select * from stdedici where nro_derecho='$vder'");
     $rega = pg_fetch_array($res_tab); 
     $vartmp = llenatemporal('stdedici','stdtmped',$rega['titular'],$vsol);
     $vnoedic=$rega['n_edicion'];
     $vanopue=$rega['anno_publica'];
     $vnoejem=$rega['n_ejemplares'];
     $vcar_ed=$rega['caracteristicas'];
     $vtipoed=$rega['editor_impres'];
///////obra musical
     $res_obra = pg_exec("select * from stdmusic where nro_derecho='$vder'");
     $rega = pg_fetch_array($res_obra); 
     $vgenero=$rega['cod_genero'];
     $vletra=$rega['letra'];
     if ($vletra==t) {$vletra='S';} else {$vletra='N';}
     $vritmo=$rega['ritmo'];
     $vdat_pf=$rega['dat_produ_fon'];
     $vano_fs=$rega['anno_fija_sono'];     
     //obra escenica
     $res_obra = pg_exec("select * from stdescen where nro_derecho='$vder'");
     $rega = pg_fetch_array($res_obra); 
     $vcla_oe=$rega['tipoobraesc'];
     $votroto=$rega['otraobraesc'];
     $vdesarg=$rega['argumento'];
     $vdesmus=$rega['musica'];
     $vdesmov=$rega['movimiento'];  
     //obra visual
     $res_obra = pg_exec("select * from stdvisua where nro_derecho='$vder'");
     $rega = pg_fetch_array($res_obra); 
     $vgener2=$rega['genero'];
     $vexhibi=$rega['exhibida'];
     $vpublic=$rega['publicada'];
     $vedific=$rega['edificada'];
     if ($vexhibi==t) {$vexhibi='S';} else {$vexhibi='N';}
     $vubi_ex=$rega['ubica_exhibi'];
     if ($vpublic==t) {$vpublic='S';} else {$vpublic='N';}
     $vdat_pu=$rega['datos_public'];    
     if ($vedific==t) {$vedific='S';} else {$vedific='N';}  
     $vubi_ed=$rega['ubica_edifica'];   
     //fijacion
     $res_obra = pg_exec("select * from stdfijac where nro_derecho='$vder'");
     $rega = pg_fetch_array($res_obra); 
     $vano_fi=$rega['anno_fijacion'];
     $vtip_fi=$rega['tipo_fijacion'];
     $vobs_fi=$rega['ficha_datos'];

  }


  //Obtención de los idiomas 
  $obj_query = $sql->query("SELECT * FROM stdidiom order by idioma");
  if (!$obj_query) { 
    $sql->disconnect();
    mensajenew("Problema al intentar realizar la consulta en la tabla de Idiomas...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }
  $filas_found=$sql->nums('',$obj_query);
  if ($filas_found==0) {
    $sql->disconnect();
    mensajenew("La Tabla de Idiomas esta Vacia ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); } 
  
  $cont = 0;
  $arraycodidiom[$cont]=0;
  $arraynomidiom[$cont]='';
  $objs = $sql->objects('',$obj_query);
  for($cont=1;$cont<=$filas_found;$cont++) { 
    $arraycodidiom[$cont]=$objs->cod_idioma;
    $arraynomidiom[$cont]=trim($objs->idioma);
    $objs = $sql->objects('',$obj_query);  }

  //Obtención del Genero 
  $obj_query = $sql->query("SELECT * FROM stdgener order by desc_genero");
  if (!$obj_query) { 
    $sql->disconnect();
    mensajenew("Problema al intentar realizar la consulta en la tabla de Generos...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }
  $filas_found=$sql->nums('',$obj_query);
  if ($filas_found==0) {
    $sql->disconnect();
    mensajenew("La Tabla de Generos esta Vacia ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); } 
  
  $cont = 0;
  $arraycodgenero[$cont]=0;
  $arraynomgenero[$cont]='';
  $objs = $sql->objects('',$obj_query);
  for($cont=1;$cont<=$filas_found;$cont++) { 
    $arraycodgenero[$cont]=$objs->cod_genero;
    $arraynomgenero[$cont]=trim($objs->desc_genero);
    $objs = $sql->objects('',$obj_query);  }

  //Obtención de los Paises
  $obj_query = $sql->query("SELECT * FROM stzpaisr order by nombre");
  if (!$obj_query) { 
    $sql->disconnect();
    mensajenew("Problema al intentar realizar la consulta en la tabla   
                de Paises...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }

  $filas_found=$sql->nums('',$obj_query);
  if ($filas_found==0) {
    $sql->disconnect();
    mensajenew("La Tabla de Paises esta Vacia ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); } 

  $cont = 0;
  $arraycodpais[$cont]=0;
  $arraynompais[$cont]='';
  $objs = $sql->objects('',$obj_query);
  for($cont=1;$cont<=$filas_found;$cont++) { 
    $arraycodpais[$cont]=$objs->pais;
    $arraynompais[$cont]=trim($objs->nombre);
    $objs = $sql->objects('',$obj_query);  }
}

//Opcion Grabar...
if ($vopc==2 or $vopc==9) {
  //La Fecha de Hoy y Hora para la transaccion
  $fechahoy = hoy();
  $horactual= Hora();
  
  //Verificando conexion
  $sql->connection($login);
 
  if ($vopc==2) {
     //Código del Evento de Ingreso 
     $evento = 200;
  
     // Validacion Tabla Maestra de Obras 
     $resula=pg_exec("select * from stdobras where solicitud='$vsol'");
     $rega= pg_fetch_array($resula);
     $nfil=pg_numrows($resula);
     if ($nfil>0) {
       $sql->disconnect();
       mensajenew("Solicitud $vsol ya existe en la Base de Datos ...!!!",
                  "a_obractos.php?vopc=3&vpla=$vpla","N");
       $smarty->display('pie_pag.tpl'); exit(); }

     // Validacion de Numero de Planilla 
     //$resplan=pg_exec("select * from stdobras where nplanilla='$vnumpla'");
     //$nfil=pg_numrows($resplan);
     //if ($nfil>0) {
     //  mensajenew("Numero de Planilla $nplanilla ya existe en la Base de Datos ...!!!",
     //             "javascript:history.back();","N");
     //  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
 
     //Verificación de que el Evento 200 de Carga Inicial existe 
     $resultado=pg_exec("SELECT * FROM stdevobr WHERE evento=200");
     if (!$resultado) { 
        $sql->disconnect();
        mensajenew("Código de Evento NO existe en la Base de Datos ...!!!",
                   "javascript:history.back();","N");
        $smarty->display('pie_pag.tpl'); exit(); }
     $filas_found=pg_numrows($resultado); 
     if ($filas_found==0) {
        $sql->disconnect();
        mensajenew("No existen Datos asociados al Evento ...!!!","javascript:history.back();","N");
        $smarty->display('pie_pag.tpl'); exit(); } 
     $regeve = pg_fetch_array($resultado);
     $vdescrip=trim($regeve['mensa_automatico']);
     $comentario="";
  }else{
  // Validacion de Numero de Planilla 
  //   $resplan=pg_exec("select * from stdobras where nplanilla='$vnumpla'");
  //   $nfil=pg_numrows($resplan);
  //   $regp= pg_fetch_array($resplan);
  //   $numsol=$regp[solicitud]; 
  //   if ($nfil>0 and trim($vsol)!=trim($numsol)) {
  //     mensajenew("Numero de Planilla $nplanilla ya existe en la Base de Datos ...!!!",
  //                "javascript:history.back();","N");
  //     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
  } 
  //Comparación de la fecha de Solicitud
  $esmayor=compara_fechas($fecha_solic,$fechahoy);
  if ($esmayor==1) {
    $sql->disconnect();
    mensajenew("La Fecha de Solicitud No puede ser mayor a la de Hoy ...!!!",
               "javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }

  //Verificacion de que los campos requeridos esten llenos...
  $req_fields = array("vfechas","vidioma","vpaisor");
// $valores = array($vfechas,$vidioma,$vpaisor);
 $valores = array($vfechas,'CA',$vpaisor);
 $vacios = check_empty_fields();
  if (!$vacios) {
     $sql->disconnect(); 
     mensajenew("Hay Informacion asociada a la OBRA que esta Vacia ...!!!$vfechas,$vidioma,$vpaisor",
                "javascript:history.back();","N");
     $smarty->display('pie_pag.tpl'); exit(); }

  //Validación de que los campos requeridos en Obra Musical esten llenos
  if ($vpla=='OM') {
    $req_fields = array("vgenero","vletra","vritmo");
    $valores = array($vgenero,$vletra,$vritmo);
    $vacios = check_empty_fields();
    if (!$vacios) { 
     $sql->disconnect();
     mensajenew("Hay Informacion asociada a la OBRA Musical que esta Vacia ...!!!",
                "javascript:history.back();","N");
     $smarty->display('pie_pag.tpl'); exit(); }
  }

  //Validación de que los campos requeridos en Obra Escenica esten llenos
  if ($vpla=='OE') {
    $req_fields = array("vcla_oe","vdesarg","vdesmov");
    $valores = array($vcla_oe,$vdesarg,$vdesmov);
    $vacios = check_empty_fields();
    if (!$vacios) { 
     $sql->disconnect();
     mensajenew("Hay Informacion asociada a la OBRA Escenica que esta Vacia ...!!!",
                "javascript:history.back();","N");
     $smarty->display('pie_pag.tpl'); exit(); }
  }

  //Verificacion de que los campos requeridos esten llenos...
  $req_fields = array("vnum_ej","vsop_de");
  $valores = array($vnum_ej,$vsop_de);
  $vacios = check_empty_fields();
  if (!$vacios) { 
     $sql->disconnect();
     mensajenew("Hay Informacion asociada al DEPOSITO que esta Vacia ...!!!",
                "javascript:history.back();","N");
     $smarty->display('pie_pag.tpl'); exit(); }

  //Validación de que se le haya cargado el solicitante
  $resoli=pg_exec("SELECT * FROM stdtmpso where solicitud='$vsol'");
  $filas_solicita=pg_numrows($resoli); 
  if ($filas_solicita==0) {
    $sql->disconnect();
    mensajenew("No existe ningún SOLICITANTE asociado ...!!!",
               "javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }
  if ($filas_solicita>0) {
    $req_fields = array("tipo_caracter");
    $valores = array($tipo_caracter);
    $vacios = check_empty_fields();
    if (!$vacios) { 
     $sql->disconnect();
     mensajenew("Hay Informacion asociada al SOLICITANTE que esta Vacia ...!!!",
                "javascript:history.back();","N");
     $smarty->display('pie_pag.tpl'); exit(); }
  }

  //Validación de que se le haya cargado al menos un Autor
  if ($vpla<>'AR' and $vforma<>'C') {
     $resoli=pg_exec("SELECT * FROM stdtmpau where solicitud='$vsol'");
     $filas_solicita=pg_numrows($resoli); 
     if ($filas_solicita==0) {
       $sql->disconnect();
       mensajenew("No existe ningún AUTOR asociado ...!!!",
               "javascript:history.back();","N");
       $smarty->display('pie_pag.tpl'); exit(); }
  }

  //Validación de que se le hayan cargado los datos asociados si tiene editor 
  $resoli=pg_exec("SELECT * FROM stdtmped where solicitud='$vsol'");
  $filas_solicita=pg_numrows($resoli); 
  if ($filas_solicita>0) {
    $req_fields = array("vnoedic","vnoejem","vanopue","vcar_ed","vtipoed");
    $valores = array($vnoedic,$vnoejem,$vanopue,$vcar_ed,$vtipoed);
    $vacios = check_empty_fields();
    if (!$vacios) { 
     $sql->disconnect();
     mensajenew("Hay Informacion asociada al EDITOR/IMPRESOR que esta Vacia ...!!!",
                "javascript:history.back();","N");
     $smarty->display('pie_pag.tpl'); exit(); }
  }

  //Validación de que se le hayan cargado los datos asociados si es Obra Derivada 
  if ($vtit_oo!='' or !empty($vtit_oo)) {
    $req_fields = array("vtip_od");
    $valores = array($vtip_od);
    $vacios = check_empty_fields();
    if (!$vacios) { 
     $sql->disconnect();
     mensajenew("Hay Informacion asociada a OBRA DERIVADA que esta Vacia ...!!!",
                "javascript:history.back();","N");
     $smarty->display('pie_pag.tpl'); exit(); }
  }
 
  $vtitulo = str_replace("'","´",$vtitulo);
  $vtraduc = str_replace("'","´",$vtraduc);
  $vritmo  = str_replace("'","´",$vritmo);
  $vdescri = str_replace("'","´",$vdescri);
  $vtit_oo = str_replace("'","´",$vtit_oo);
  $vaut_oo = str_replace("'","´",$vaut_oo);
  $votroto = str_replace("'","´",$votroto);
  $vdesarg = str_replace("'","´",$vdesarg);
  $vdesmus = str_replace("'","´",$vdesmus);
  $vdesmov = str_replace("'","´",$vdesmov);
  $vdat_pf = str_replace("'","´",$vdat_pf);
  $vubi_ex = str_replace("'","´",$vubi_ex);
  $vdat_pu = str_replace("'","´",$vdat_pu);
  $vubi_ed = str_replace("'","´",$vubi_ed);
  $vsop_fi = str_replace("'","´",$vsop_fi);
  $vobs_fi = str_replace("'","´",$vobs_fi);
  $vtransf = str_replace("'","´",$vtransf);
  $vsop_de = str_replace("'","´",$vsop_de);
  $vobs_de = str_replace("'","´",$vobs_de);
  $vamplia = str_replace("'","´",$vamplia);
  $vadicio = str_replace("'","´",$vadicio);
  $vcar_ed = str_replace("'","´",$vcar_ed);
  $vgener2 = str_replace("'","´",$vgener2);

  // Colocar valores a variables cuando esten en blanco
  if ($vanoppu=='') { $vanoppu=0;}
  if ($vanorea=='') { $vanorea=0;}
  if ($vano_fs=='') { $vano_fs=0;}
  if ($vano_oo=='') { $vano_oo=0;}
  if ($vnumpla=='') { $vnumpla=0;}
  if ($vexhibi=='') { $vexhibi='N';}
  if ($vpublic=='') { $vpublic='N';}
  if ($vedific=='') { $vedific='N';}
  if ($vclasif=='') { $vclasif='N';}
  if ($vorigen=='') { $vorigen='N';}
  if ($vforma=='')  { $vforma='N';}
  if ($tipo_soporte=='') {$tipo_soporte=='PAPEL';}

  //Validación de datos asociados a hojas adicionales 
  if ($vhoj_ad=="N" or $vhoj_ad=='') { $vnum_ho=0;}
  if ($vhoj_ad=="S") {
    if (empty($vnum_ho)) {
     $sql->disconnect();
      mensajenew("Debe indicar la Informacion en la pestaña de Hojas Adicionales ...!!!",
                 "javascript:history.back();","N");
      $smarty->display('pie_pag.tpl'); exit(); }
  }

  pg_exec("BEGIN WORK");
  // Insertamos primero en la Tabla Maestra de Obras 
  $can_error=0;
  $res_vder=pg_exec("SELECT nextval('stzsystem_nro_derecho_seq') as vder FROM stzsystem");
  $reg_vder = pg_fetch_array($res_vder); 
  $vder=$reg_vder[vder]; 
  $col_campos = "nro_derecho,solicitud,fecha_solic,titulo_obra,tipo_obra,clase,origen,forma,
  cod_idioma,estatus,pais_origen,n_ejemplares,tipo_soporte,observacion,n_hojas_adic,datos_ampli,
                 datos_adicio,nplanilla,descrip_obra,traduccion,anno_realiza,anno_1publica";
  $insert_str = "$vder,
                 '-','$vfechas','$vtitulo','$vpla','$vclasif','$vorigen','$vforma',
                 'CA',
                 1,'$vpaisor',$vnum_ej,'$vsop_de','$vobs_de',$vnum_ho,'$vamplia',
                 '$vadicio','$vnumpla','$vdescri','$vtraduc',$vanorea,$vanoppu";
  if ($vopc==2) {$valido = $sql->insert("stdobras","$col_campos","$insert_str","");
                 if (!$valido) {$can_error=$can_error+1;} 
  } else         {$update_str= "fecha_solic='$vfechas',titulo_obra='$vtitulo',
                 tipo_obra='$vpla',clase='$vclasif',origen='$vorigen',forma='$vforma',
                 cod_idioma='$vidioma',pais_origen='$vpaisor',n_ejemplares=$vnum_ej,
                 tipo_soporte='$vsop_de',observacion='$vobs_de',n_hojas_adic=$vnum_ho,
                 datos_ampli='$vamplia',datos_adicio='$vadicio',nplanilla='$vnumpla',
                 descrip_obra='$vdescri',traduccion='$vtraduc',anno_realiza=$vanorea,
                 anno_1publica=$vanoppu";
                 $update_cond="solicitud='$vsol'";
                 $valido = $sql->update("stdobras","$update_str","$update_cond");
                 if (!$valido) {$can_error=$can_error+1;} }
//  $res_derec=pg_exec("select nro_derecho from stdobras where solicitud='$vsol'");
//  $regderec = pg_fetch_array($res_derec); 
//  $vder=$regderec[nro_derecho]; 
  // Insertamos en la Tabla Derivadas
  if ($vtit_oo!='' or !empty($vtit_oo)) {
     $col_campos = "nro_derecho,titulo_original,datos_autor,tipo_obra_deri,anno_pub_orig,
                    n_versiones_aut";
     $insert_str = "'$vder','$vtit_oo','$vaut_oo','$vtip_od','$vano_oo',0";
     if ($vopc==2) {$valido = $sql->insert("stdderiv","$col_campos","$insert_str","");
                    if (!$valido) {$can_error=$can_error+1;} }
     else          {$update_str= "titulo_original='$vtit_oo',datos_autor='$vaut_oo',
                   tipo_obra_deri='$vtip_od',anno_pub_orig='$vano_oo'";
                   $update_cond="nro_derecho='$vder'";
                   $valido = $sql->update("stdderiv","$update_str","$update_cond");
                   if (!$valido) {$can_error=$can_error+1;} }
  } 

  // Insertamos en la Tabla Transferencia
  if ($vtransf!='' or !empty($vtransf)) {
     $col_campos = "nro_derecho,transferencia";
     $insert_str = "'$vder','$vtransf'";
     if ($vopc==2) {$ins_trans = $sql->insert("stdtrans","$col_campos","$insert_str","");}
     else          {$rtr=pg_exec("SELECT * FROM stdtrans where nro_derecho='$vder'");
                    $f_rtr=pg_numrows($rtr);
                    if ($f_rtr>0) {  
                       $update_str="transferencia='$vtransf'";
                       $update_cond="nro_derecho='$vder'";
                       $valido = $sql->update("stdtrans","$update_str","$update_cond");
                       if (!$valido) {$can_error=$can_error+1;} }
                    else  
                       {$valido = $sql->insert("stdtrans","$col_campos","$insert_str","");
                        if (!$valido) {$can_error=$can_error+1;} }
                   }
  } 

  // Insertamos en la Tabla de Tramite 
  if ($vopc==2) {
     $col_campos = "nro_derecho,evento,fecha_event,estat_ant,secuencial,
                    fecha_trans,usuario,desc_evento,hora";
     $insert_str = "'$vder','200','$vfechas','0',nextval('stdevtrd_secuencial_seq'),
                    '$fechahoy','$usuario','$vdescrip','$horactual'";
     $valido = $sql->insert("stdevtrd","$col_campos","$insert_str",""); 
     if (!$valido) {$can_error=$can_error+1;} }

  // Tabla de Solicitante y Persona Natural o Juridica 
  $del_tab= $sql->del("stdobsol","nro_derecho='$vder'");
  $gb=0;
//1-->>
  $gb=guardar_interesado('Solicitante',$vsol,$vder,'U',$tipo_caracter,$otro_caracter,
                               $prueba_repres);
  $can_error=$can_error+$gb;
  $del_tab= $sql->del("stdtmpso","solicitud='$vsol'");
           
  // Tabla de Autores y Persona Natural o Juridica 
  $del_tab= $sql->del("stdobaut","nro_derecho='$vder' and tipo_autor='AU'");
  $gb=0; 
//2-->>
  $gb=guardar_interesado('Autor',$vsol,$vder,'V');
  $can_error=$can_error+$gb;
  $del_tab= $sql->del("stdtmpau","solicitud='$vsol' and tipo_autor='AU'");


  // Tabla de Editor y Persona Natural o Juridica 
  $del_tab= $sql->del("stdedici","nro_derecho='$vder'");
  $resulb=pg_exec("select * from stdtmped where solicitud='$vsol'");
  $nfil=pg_numrows($resulb);
//3-->>
  if ($nfil>0) {$gb=0; $gb=guardar_interesado('Editor',$vsol,$vder,'U','','','',
                $vnoedic,$vanopue,$vnoejem,$vcar_ed,$vtipoed); 
                $can_error=$can_error+$gb;}
  $del_tab= $sql->del("stdtmped","solicitud='$vsol'");

  // Tabla de Titular y Persona Natural o Juridica 
  $del_tab= $sql->del("stdobtit","nro_derecho='$vder'");
  $resulb=pg_exec("select * from stdtmpti where solicitud='$vsol'");
  $nfil=pg_numrows($resulb);
//4-->>
  if ($nfil>0) {$gb=0; $gb=guardar_interesado('Titular',$vsol,$vder,'V'); 
                $can_error=$can_error+$gb;}
  $del_tab= $sql->del("stdtmpti","solicitud='$vsol'");
  
  // Tabla de Co-Autores y Persona Natural o Juridica 
  $del_tab= $sql->del("stdobaut","nro_derecho='$vder' and tipo_autor<>'AU'");
  $resulb=pg_exec("select * from stdtmpco where solicitud='$vsol'");
  $nfil=pg_numrows($resulb);
//5-->>
  if ($nfil>0) {$gb=0; $gb=guardar_interesado('Coautor',$vsol,$vder,'V'); 
                $can_error=$can_error+$gb;}
  $del_tab= $sql->del("stdtmpco","solicitud='$vsol' and tipo_autor<>'AU'");

  // Tabla de Productores y Persona Natural o Juridica 
  $del_tab= $sql->del("stdobpro","nro_derecho='$vder'");
  $resulb=pg_exec("select * from stdtmppt where solicitud='$vsol'");
  $nfil=pg_numrows($resulb);
//6-->>
  if ($nfil>0) {$gb=0; $gb=guardar_interesado('Productor',$vsol,$vder,'V'); 
                $can_error=$can_error+$gb; }
  $del_tab= $sql->del("stdtmppt","solicitud='$vsol'");

  // Insertamos en la Tabla Obra Musical 
  if ($vpla=='OM') {
     if ($vletra=='S') {$vlet='TRUE';} else {$vlet='FALSE';}
     if ($vdat_pf<>'' or $vano_fs<>'') {$vfin='TRUE';} else {$vfin='FALSE';}
     $col_campos = "nro_derecho,cod_genero,letra,ritmo,fin_comercial,dat_produ_fon,anno_fija_sono";
     $insert_str = "'$vder','$vgenero',$vlet,'$vritmo',$vfin,'$vdat_pf',$vano_fs";
     $resmus=pg_exec("SELECT * FROM stdmusic where nro_derecho='$vder'");
     $filas_resmus=pg_numrows($resmus); 
     if ($vopc==2 or $filas_resmus==0) {
         $valido = $sql->insert("stdmusic","$col_campos","$insert_str","");
         if (!$valido) {$can_error=$can_error+1;} }
     else          {$update_str="cod_genero='$vgenero',letra=$vlet,ritmo='$vritmo',
                   fin_comercial=$vfin,dat_produ_fon='$vdat_pf',anno_fija_sono=$vano_fs";
                   $update_cond="nro_derecho='$vder'";
                   $valido = $sql->update("stdmusic","$update_str","$update_cond");
                   if (!$valido) {$can_error=$can_error+1;}}
  } 

  // Insertamos en la Tabla Obra Escenica y la tabla Fijacion
  if ($vpla=='OE') {
     if ($votroto!='') {$vcla_oe='O';}
     $col_campos = "nro_derecho,tipoobraesc,otraobraesc,argumento,musica,movimiento";
     $insert_str = "'$vder','$vcla_oe','$votroto','$vdesarg','$vdesmus','$vdesmov'";
     $resoes=pg_exec("SELECT * FROM stdescen where nro_derecho='$vder'");
     $filas_resoes=pg_numrows($resoes); 
     if ($vopc==2 or $filas_resoes==0) {
         $valido = $sql->insert("stdescen","$col_campos","$insert_str","");
         if (!$valido) {$can_error=$can_error+1;} }
     else          {$update_str="tipoobraesc='$vcla_oe',otraobraesc='$votroto',
                   argumento='$vdesarg',musica='$vdesmus',movimiento='$vdesmov'";
                   $update_cond="nro_derecho='$vder'";
                   $valido = $sql->update("stdescen","$update_str","$update_cond");
                   if (!$valido) {$can_error=$can_error+1;} }
     if ($vano_fi<>'' or $vtip_fi<>' ' or $vobs_fi<>'') {
        $col_campos = "nro_derecho,anno_fijacion,tipo_fijacion,ficha_datos";
        $insert_str = "'$vder','$vano_fi','$vtip_fi','$vobs_fi'";
        $resfij=pg_exec("SELECT * FROM stdfijac where nro_derecho='$vder'");
        $filas_resfij=pg_numrows($resfij); 
        if ($vopc==2 or $filas_resfij==0) {
            $valido = $sql->insert("stdfijac","$col_campos","$insert_str","");
            if (!$valido) {$can_error=$can_error+1;} }
        else          {$update_str="anno_fijacion='$vano_fi',tipo_fijacion='$vtip_fi',
                      ficha_datos='$vobs_fi'";
                      $update_cond="nro_derecho='$vder'";
                      $valido = $sql->update("stdfijac","$update_str","$update_cond");
                      if (!$valido) {$can_error=$can_error+1;} }
     }
  } 

  // Insertamos en la Tabla Obra Visual 
  if ($vpla=='AV') {
     if ($vexhibi=='S') {$vex='TRUE';} else {$vex='FALSE';}
     if ($vpublic=='S') {$vpu='TRUE';} else {$vpu='FALSE';}
     if ($vedific=='S') {$ved='TRUE';} else {$ved='FALSE';}
     $col_campos = "nro_derecho,cod_genero,exhibida,ubica_exhibi,publicada,datos_public,
                    edificada,ubica_edifica";
     $insert_str = "'$vder','$vgener2',$vex,'$vubi_ex',$vpu,'$vdat_pu',
                    $ved,'$vubi_ed'";
     if ($vopc==2) {$valido = $sql->insert("stdvisua","$col_campos","$insert_str","");
                    if (!$valido) {$can_error=$can_error+1;} }
     else          {$update_str="exhibida=$vex,ubica_exhibi='$vubi_ex',
                   publicada=$vpu,datos_public='$vdat_pu',edificada=$ved,ubica_edifica='$vubi_ed',cod_genero='$vgener2'";
                   $update_cond="nro_derecho='$vder'";
                   $valido = $sql->update("stdvisua","$update_str","$update_cond");
                   if (!$valido) {$can_error=$can_error+1;} }    
  } 

  if ($can_error==0) { 
     $res_sol=pg_exec("select dsolicitud from stzsystem");
     $reg_sol = pg_fetch_array($res_sol); 
     $v_sol=$reg_sol[dsolicitud]+1;
     $v_sol=str_repeat('0',6-strlen($v_sol)).$v_sol; 
     $update_str="dsolicitud='$v_sol'";
     $valido1 = $sql->update("stzsystem","$update_str","true");
     $update_str="solicitud='$v_sol'";
     $update_cond="nro_derecho='$vder'";
     $valido2 = $sql->update("stdobras","$update_str","$update_cond");
     if ($valido1 and $valido2) {
        pg_exec("COMMIT WORK");  
        $sql->disconnect();
        Mensaje("DATOS GUARDADOS CORRECTAMENTE BAJO EL NUMERO DE EXPEDIENTE: ".$v_sol,
             "a_otrasobrnw.php?vopc=7&vpla=$vpla");
     } else {
        pg_exec("ROLLBACK WORK"); 
        $sql->disconnect();
        mensajenew("Falla de Ingreso de Datos en la BD, Transacciones Abortadas, 
                 Error en datos asociados...!!!","javascript:history.back();","N");
        $smarty->display('pie_pag.tpl'); exit();    
     }
  } else {
     pg_exec("ROLLBACK WORK"); 
     $sql->disconnect();
     mensajenew("Falla de Ingreso de Datos en la BD, Transacciones Abortadas, 
                 Error en datos asociados...!!!","javascript:history.back();","N");}
     $smarty->display('pie_pag.tpl'); exit();    

}


//Pase de variables y Etiquetas al template
$smarty->assign('campo15','Nombre o Raz&oacute;n Social:');
$smarty->assign('campo16','Car&aacute;cter con el que Act&uacute;a:');
$smarty->assign('campo17','Otro Car&aacute;cter con el que Act&uacute;a:');
$smarty->assign('campo18','Prueba Representaci&oacute;n o Transferencia Derechos:');

$smarty->assign('vopc',$vopc);
$smarty->assign('vpla',$vpla);
$smarty->assign('accion',$accion);
$smarty->assign('vsol',$vsol);
$smarty->assign('usuario',$usuario);
$smarty->assign('estatus',$estatus);
$smarty->assign('arraycodpais',$arraycodpais);
$smarty->assign('arraynompais',$arraynompais);
$smarty->assign('arraycodidiom',$arraycodidiom);
$smarty->assign('arraynomidiom',$arraynomidiom);
$smarty->assign('arraycodgenero',$arraycodgenero);
$smarty->assign('arraynomgenero',$arraynomgenero);

$smarty->assign('vfechas',$vfechas);
$smarty->assign('vnumpla',$vnumpla);
$smarty->assign('vtitulo',$vtitulo);
$smarty->assign('vpaisor',$vpaisor); 
$smarty->assign('vidioma',$vidioma); 
$smarty->assign('vtraduc',$vtraduc);
$smarty->assign('vanorea',$vanorea);
$smarty->assign('vanoppu',$vanoppu);
$smarty->assign('vgenero',$vgenero);
$smarty->assign('vgener2',$vgener2);
$smarty->assign('vritmo' ,$vritmo);  
$smarty->assign('vdescri',$vdescri);
$smarty->assign('vtit_oo',$vtit_oo);
$smarty->assign('vaut_oo',$vaut_oo);
$smarty->assign('vano_oo',$vano_oo);
$smarty->assign('votroto',$votroto);
$smarty->assign('vdesarg',$vdesarg);
$smarty->assign('vdesmus',$vdesmus);
$smarty->assign('vdesmov',$vdesmov);
$smarty->assign('vdat_pf',$vdat_pf);
$smarty->assign('vano_fs',$vano_fs);
$smarty->assign('vubi_ex',$vubi_ex);
$smarty->assign('vdat_pu',$vdat_pu);
$smarty->assign('vubi_ed',$vubi_ed);
$smarty->assign('vano_fi',$vano_fi);
$smarty->assign('vsop_fi',$vsop_fi);
$smarty->assign('vobs_fi',$vobs_fi);
$smarty->assign('vtransf',$vtransf);
$smarty->assign('vnum_ej',$vnum_ej);
$smarty->assign('vsop_de',$vsop_de);
$smarty->assign('vobs_de',$vobs_de);
$smarty->assign('vnum_ho',$vnum_ho);
$smarty->assign('vamplia',$vamplia);
$smarty->assign('vadicio',$vadicio);
$smarty->assign('vletra',$vletra);  
$smarty->assign('vclasif',$vclasif);
$smarty->assign('vorigen',$vorigen);
$smarty->assign('vforma',$vforma);  
$smarty->assign('vtip_od',$vtip_od);
$smarty->assign('vcla_oe',$vcla_oe);
$smarty->assign('vexhibi',$vexhibi);
$smarty->assign('vpublic',$vpublic);
$smarty->assign('vedific',$vedific);
$smarty->assign('vtip_fi',$vtip_fi);
$smarty->assign('vhoj_ad',$vhoj_ad);
$smarty->assign('vtipoed',$vtipoed);
$smarty->assign('vanopue',$vanopue);
$smarty->assign('vnoedic',$vnoedic);
$smarty->assign('vnoejem',$vnoejem);
$smarty->assign('vcar_ed',$vcar_ed);
$smarty->assign('tipo_caracter',$tipo_caracter);
$smarty->assign('otro_caracter',$otro_caracter);
$smarty->assign('prueba_repres',$prueba_repres); 
$smarty->assign('vartis1',$vartis1);
$smarty->assign('vtip_od_id',$vtipo_od_id);
$smarty->assign('vtip_od_de',$vtipo_od_de);
$smarty->assign('vexhibi_id',array('S','N')); 
$smarty->assign('vexhibi_de',array('Si','No'));
$smarty->assign('vpublic_id',array('S','N')); 
$smarty->assign('vpublic_de',array('Si','No'));
$smarty->assign('vedific_id',array('S','N')); 
$smarty->assign('vedific_de',array('Si','No'));
$smarty->assign('vhoj_ad_id',array('S','N')); 
$smarty->assign('vhoj_ad_de',array('Si','No'));
$smarty->assign('vletra_id' ,array('S','N')); 
$smarty->assign('vletra_de' ,array('Con Letra','Sin Letra'));
$smarty->assign('vtip_fi_id',array(' ','S','A')); 
$smarty->assign('vtip_fi_de',array(' ','Sonora','Audiovisual'));
$smarty->assign('vclasif_id',array('I','P')); 
$smarty->assign('vclasif_de',array('Inedita','Publicada'));
$smarty->assign('vorigen_id',array('O','D')); 
$smarty->assign('vorigen_de',array('Originaria','Derivada'));
$smarty->assign('vforma_id' ,array('I','E','C')); 
$smarty->assign('vforma_de' ,array('Individual','En Colaboraci&oacute;n','Colectiva'));
$smarty->assign('vcla_oe_id',array('D','C','M','O')); 
$smarty->assign('vcla_oe_de',array('Dram&aacute;tica','Coreograf&iacute;a',
'Dram&aacute;tico-Musical','Otro:'));
$smarty->assign('vtip_od_id',array(" ","AC","AD","AN","AR","CO","ME","RE","TR","TF","VE"));
$smarty->assign('vtip_od_de',array(" ","Actualizaci&oacute;n","Adaptaci&oacute;n",
"Antolog&iacute;a","Arreglo","Compilaci&oacute;n","Mejora","Recopilaci&oacute;n",
"Traducci&oacute;n","Transformaci&oacute;n","Versi&oacute;n"));
$smarty->assign('vtipoed_id' ,array('E','I')); 
$smarty->assign('vtipoed_de' ,array('Editor','Impresor'));
$smarty->display('a_otrasobrnw.tpl');
$smarty->display('pie_pag.tpl');
?>
</body>
</html>
