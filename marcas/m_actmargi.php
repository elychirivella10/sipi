<script language="Javascript">
function browsetitularp(var1,var2,var3,var4) {
  this.derecho='M';
  open("adm_titum.php?vsol="+var1.value+"-"+var2.value+"&vtex="+var3.value+"&vmod="+var4.value+"&vtip="+this.derecho,"Ventana", "scrollbars=yes,toolbar=no,directories=no,menubar=no,status=no"); }
</script>

<?php
// *************************************************************************************
// Programa: m_actmargi.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MILCO
// Año: 2010
// *************************************************************************************

//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variables
$usuario = $_SESSION['usuario_login'];
$hh   = hora();
$sql  = new mod_db();
$fecha= fechahoy();

$tbname_1  = "stzpaisr";
$tbname_2  = "stzagenr";
$tbname_3  = "stzsolic";  
$tbname_4  = "stmmarce";
$tbname_5  = "stzevtrd";
$tbname_6  = "stzderec";
$tbname_7  = "stzottid";
$tbname_8  = "stzmargi";
$tbname_9  = "stztmptit";

$smarty->assign('titulo',$substmar); 
$smarty->assign('subtitulo','Publicaciones de Anotaciones Marginales'); 
$smarty->assign('login',$usuario); 
$smarty->assign('fechahoy',$fecha); 
$smarty->assign('hora_id',array(NN,AM,PM)); 
$smarty->assign('hora_de',array('','AM','PM'));
$smarty->assign('arrayvtrami',array(B,C,F,L,N,D,R));
$smarty->assign('arrayttrami',array('','Cesi&oacute;n','Fusi&oacute;n','Licencia de Uso','Cambio de Nombre','Cambio de Domicilio','Renovaci&oacute;n'));
   
//Captura Variables leidas en formulario inicial
   $vopc  = $_GET['vopc'];
   $vreg1 = $_POST['vreg1'];
   $vreg2 = $_POST['vreg2'];
   $vfechr= $_POST['vfechr'];
   $vhora = $_POST['vhora'];
   $vampm = $_POST['vampm'];
   $tramite = $_POST['tramite'];
   $vdoc    = $_POST['vdoc'];
   $vbol    = $_POST['vbol'];

   $vder    = $_POST['vder'];
   $vsolh   = $_POST['vsolh'];
   $vregh   = $_POST['vregh'];
   $vnom    = $_POST['vnom'];
   $vest    = $_POST['vest'];
   $vfecsol = $_POST['vfecsol'];
   $vfecreg = $_POST['vfecreg'];
   $vfecven = $_POST['vfecven'];
   $vfecv   = $_POST['vfecv'];
   $vcodtn  = $_POST['vcodtn'];
   $vnomtn  = $_POST['vnomtn'];
   $vcodtit = $_POST['vcodtit'];
   $vnomtit = $_POST['vnomtit'];
   $vtipo   = $_POST['vtipo'];
   $vcomenta= $_POST['vcomenta'];
   $vdomnew = $_POST['vdomnew'];
   $vdomant = $_POST['vdomant'];
   $vnompai = $_POST['vnompai'];
   $vdomtit = $_POST['vdomtit'];
   $vnactit = $_POST['vnactit'];
   $vcodagen= $_POST['vcodagen'];
   $vnomage = $_POST['vnomage'];
   $vtranew = $_POST['vtranew'];
   $vnacnew = $_POST['vnacnew'];
   $vclasint= $_POST['vclasint'];
   $vnomagenew=$_POST['options'];
   $input2  = $_POST['input2'];
        
   $vsol=sprintf("%04d-%06d",$vsol1,$vsol2);
   $vreg=   $vreg1.trim($vreg2);
   $resultado=false;
   $vfec=hoy();

   // Verificando Conexion 
   $sql->connection($usuario);   

   if ($vopc==1) {
      $smarty ->assign('varfocus','formarcas1.vreg1'); 
      $smarty ->assign('vmodo','readonly'); 
   }
   if ($vopc==2) {
     if (empty($vreg1) || empty($vreg2) || empty($vfechr) || ($tramite=="B") || empty($vbol) || empty($vhora) || ($vampm=="NN")) {
       $smarty->display('encabezado1.tpl');
       mensajenew('ERROR: Falta alg&uacute;n dato para Procesar la B&uacute;squeda ...!!!','javascript:history.back();','N');
       $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
     }

     $smarty ->assign('modo1','disabled'); 
     $smarty ->assign('vmodo','readonly'); 

     $resultado=pg_exec("SELECT * FROM $tbname_6 WHERE registro='$vreg' AND tipo_mp='M'");
     if (!$resultado) { 
       $smarty->display('encabezado1.tpl');
       mensajenew('ERROR AL PROCESAR LA BUSQUEDA ...!!!','m_actmargi.php?vopc=1','N');
       $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
     }	 
     $filas_found=pg_numrows($resultado); 
     if ($filas_found==0) {
       $smarty->display('encabezado1.tpl');
       mensajenew('ERROR: Registro NO Existe en la Base de Datos ...!!!','m_actmargi.php?vopc=1','N');
       $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
     else {
      $reg     =pg_fetch_array($resultado);
      $vder    =$reg[nro_derecho];

     $horacar = trim($vhora)." ".$vampm; 
     if ($vdoc!='') { 
        $resmarg=pg_exec("SELECT * FROM $tbname_8 WHERE nro_derecho=$vder AND tipo_mp='M' AND tipo_tramite='$tramite' AND boletin=$vbol AND nro_docum='$vdoc' AND fecha_trans='$vfechr' AND hora='$horacar'"); }
     else {
        $resmarg=pg_exec("SELECT * FROM $tbname_8 WHERE nro_derecho=$vder AND tipo_mp='M' AND tipo_tramite='$tramite' AND boletin=$vbol AND fecha_trans='$vfechr' AND hora='$horacar'"); }
     $filas=pg_numrows($resmarg); 
     if ($filas==0) {
       $smarty->display('encabezado1.tpl');
       mensajenew('ERROR: Datos de Publicación del Registro NO Existe ...!!!','m_actmargi.php?vopc=1','N');
       $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();
     }

      $vsol    =$reg[solicitud];
      $vsol1   =substr($vsol,-11,4);
      $vsol2   =substr($vsol,-6,6);
      $vreg    =$reg[registro];
      $vest    =$reg[estatus];
      $vreg1   =substr($vreg,-8,1);
      $vreg2   =substr($vreg,1);
      $vnom    =$reg[nombre];
      $vest    =$reg[estatus];
      $vfecsol =$reg[fecha_solic];
      $vfecreg =$reg[fecha_regis];
      $vfecven =$reg[fecha_venc];
      $vtipom  =$reg[tipo_mp];
      $vcodage =$reg[agente];
      $vtra    =$reg[tramitante];
      $vtit    =$reg[titular];

      //Obtención de datos de la Marca 
      $obj_query = $sql->query("SELECT * FROM $tbname_4 WHERE nro_derecho='$vder'");
      $objs = $sql->objects('',$obj_query);
      $modal_id= $objs->modalidad;
      $vclas   = $objs->clase;
      $vindc   = $objs->ind_claseni;
      $vtip    = Tipo_marca($vtipom); 
      $vindcla = Ind_clase($vindc);

      switch ($modal_id) {
        case "D":
          $modal = "DENOMINATIVA";
          break;
        case "G":
          $modal = "GRAFICA";
          break;
        case "M":
          $modal = "MIXTA";
          break;
      }

      if ($vcodage!='') {
      $resulage=pg_exec("SELECT nombre FROM $tbname_2 WHERE agente=$vcodage");
      $regage = pg_fetch_array($resulage);
      $vnomage=$regage[nombre];
      }
                  
      if ($vreg!='') { //Esta bien 
      }  else {
         $smarty->display('encabezado1.tpl');
         mensajenew('Solo aplica a MARCAS con REGISTRO ASIGNADO ...!!!','m_actmargi.php?vopc=1','N');
	      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
      }
      // Obtencion de la Descripcion del Estatus
      $vdesest='';
      $vdesest= estatus($vest);
     
      // Titular Actual
      $resultit=pg_exec("SELECT a.titular,b.nombre,a.nacionalidad,a.domicilio,c.nombre as nombrep FROM 
                         stzottid a, stzsolic b, stzpaisr c
                         WHERE a.nro_derecho='$vder' AND a.titular=b.titular AND a.nacionalidad=c.pais");
      $regtit = pg_fetch_array($resultit);
      $vcodtit=$regtit[titular];
      $vnomtit=$regtit[nombre];
      $vnactit=$regtit[nacionalidad];
      $vnadtit=$regtit[nombrep];
      $vdomtit=$regtit[domicilio];
      
      // Vectores de Paises
      $obj_query = $sql->query("SELECT * FROM $tbname_1 ORDER BY nombre");
      $obj_filas = $sql->nums('',$obj_query);
      $contobj = 0;
      $objs = $sql->objects('',$obj_query);
      for ($contobj=0;$contobj<=$obj_filas;$contobj++) {
          $vcodpai[$contobj] = $objs->pais;
          $vnompai[$contobj] = trim($objs->nombre);
	   $objs = $sql->objects('',$obj_query);}

      // Vectores de Agentes
      $obj_query = $sql->query("SELECT * FROM $tbname_2 ORDER BY nombre");
      $obj_filas = $sql->nums('',$obj_query);
      $contobj = 0;
      $vcodagenew[$contobj] = '';
      $vnomagenew[$contobj] = '';
      $objs = $sql->objects('',$obj_query);
      for ($contobj=1;$contobj<=$obj_filas;$contobj++) {
          $vcodagenew[$contobj] = $objs->agente;
          $vnomagenew[$contobj] = trim($objs->nombre);
	  $objs = $sql->objects('',$obj_query);}
	  
     // Elimina posibles registros existentes en el temporal
     $sql->del("stztmptit","solicitud='$vsol' AND tipo_mp='M'"); 

     $regmarg = pg_fetch_array($resmarg);
     $vfecv  = $regmarg[vencimiento];
     $vtraf  = $regmarg[tramitante];
     $vcomenta = $regmarg[titular1];
     $vnewtit  = $regmarg[titular2];
     $vdomant = $regmarg[domicilio_ant];
     $vdomtit = $regmarg[domicilio];
     //$v    = $regmarg[pais];
    }
   }   
      
   if ($vopc==3) {
      $vder =  $_POST['vder'];
      $vreg1 = $_POST['vreg1'];
      $vreg2 = $_POST['vreg2'];
      $vregh = $_POST['vregh'];
      $horacar = trim($vhora)." ".$vampm; 
      //echo "$vder || $vregh || $vfechr || $tramite || $vbol | $vhora || $vampm";
      if (empty($vregh) || empty($vfechr) || ($tramite=="B") || empty($vbol) || empty($vhora) || ($vampm=="NN")) {
        $smarty->display('encabezado1.tpl');
        mensajenew('ERROR: Falta alg&uacute;n dato para Procesar la B&uacute;squeda ...!!!','javascript:history.back();','N');
        $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
      }

      // Comienzo de Transaccion
      $del_mar = true;
      pg_exec("BEGIN WORK");
      //echo "nro_derecho=$vder AND tipo_mp='M' AND tipo_tramite='$tramite' AND boletin=$vbol AND fecha_trans='$vfechr' AND hora='$horacar'";
      //exit();
      
      // Tabla de Solicitantes o Titulares 
      $del_mar = $sql->del("stzmargi","nro_derecho=$vder AND tipo_mp='M' AND tipo_tramite='$tramite' AND boletin=$vbol AND fecha_trans='$vfechr' AND hora='$horacar'"); 

      // Verificacion de Operacion en BD 
      if ($del_mar) {
        pg_exec("COMMIT WORK");
        //Desconexion de la Base de Datos
        $sql->disconnect();
        
        $smarty->display('encabezado1.tpl');
        mensajenew('DATOS ELIMINADOS CORRECTAMENTE ...!!!','m_actmargi.php?vopc=1','S');
        $smarty->display('pie_pag.tpl'); exit(); } 
      else {
        pg_exec("ROLLBACK WORK"); 
        //Desconexion de la Base de Datos
        $sql->disconnect();
        
        mensajenew("Falla de Eliminaci&oacute;n de Datos en la BD ...!!!","javascript:history.back();","N");
        $smarty->display('pie_pag.tpl'); exit();
      }

   }
   //Asignacion de variables para pasarlas a Smarty
   $smarty->assign('vder',$vder); 
   $smarty->assign('vsol1',$vsol1);
   $smarty->assign('vsol2',$vsol2);
   $smarty->assign('vsol',$vsol);
   $smarty->assign('vfec',$vfec);
   $smarty->assign('vreg1',$vreg1);
   $smarty->assign('vreg2',$vreg2);
   $smarty->assign('tramite',$tramite);
   $smarty->assign('vfechr',$vfechr);
   $smarty->assign('vseldoc','$vseldoc');
   $smarty->assign('vdoc',$vdoc);
   $smarty->assign('vbol',$vbol);
   $smarty->assign('vhora',$vhora);
   $smarty->assign('vampm',$vampm);

   $smarty ->assign('nombre',$vnom); 
   $smarty ->assign('vdesest',$vdesest); 
   $smarty ->assign('vest',$vest); 
   $smarty ->assign('vfecsol',$vfecsol); 
   $smarty ->assign('vfecreg',$vfecreg); 
   $smarty ->assign('vfecven',$vfecven); 
   $smarty ->assign('vcodtit',$vcodtit); 
   $smarty ->assign('vcodtn',$vcodtn);
   $smarty ->assign('vnomtit',$vnomtit);
   $smarty ->assign('vcodtitnew',$vcodtitnew); 
   $smarty ->assign('vnomtitnew',$vnomtitnew);
   $smarty ->assign('vnactit',$vnactit); 
   $smarty ->assign('vnadtit',$vnadtit); 
   $smarty ->assign('vcodpai',$vcodpai);
   $smarty ->assign('vnompai',$vnompai);

   $smarty ->assign('vnewtit',$vnewtit);
   $smarty ->assign('vcomenta',$vcomenta);
   $smarty ->assign('vdomant',$vdomant); 
   $smarty ->assign('vtraf',$vtraf);

   $smarty ->assign('vdomtit',$vdomtit); 
   $smarty ->assign('vcodagenew',$vcodagenew);
   $smarty ->assign('vnomagenew',$vnomagenew);
   $smarty ->assign('vtranew',$vtranew); 
   $smarty ->assign('vcodage',$vcodage);
   $smarty ->assign('vnomage',$vnomage);
   $smarty ->assign('vtra',$vtra);
   $smarty ->assign('vtip',$vtip);   
   $smarty ->assign('vmodal',$modal);   
   $smarty ->assign('vindc',$vindcla);   
   $smarty ->assign('vclas',$vclas);   

   $smarty->assign('lfecharen','con Fecha Transacci&oacute;n:'); 
   $smarty->assign('ltramite','Tipo Tramite:');
   $smarty->assign('lnumtra','N&uacute;mero Tr&aacute;mite:'); 
   $smarty ->assign('lhora','Hora de Transacci&oacute;n:'); 

   $smarty ->assign('lsolicitud','Solicitud:'); 
   $smarty ->assign('lregistro','Registro:'); 
   $smarty ->assign('lnombre','Nombre:');
   $smarty ->assign('lest','Estatus:'); 
   $smarty ->assign('ltipom','Tipo:');
   $smarty ->assign('lclase','Clase:');
   $smarty ->assign('lmodal','Modalidad:');
   $smarty ->assign('ltitular','Titular Actual:'); 
   $smarty ->assign('ltitularnew','Titular:');
   $smarty ->assign('lfusion','Licenciante, Empresas a Fusionarse, Cedente o Titular Anterior'); 
   $smarty ->assign('lpropietario','Licenciatario, Sobreviviente, Cesionario, Titular Nuevo, Cambio de Domicilio'); 
   $smarty ->assign('lfecsol','Fecha Solicitud:'); 
   $smarty ->assign('lfecreg','Fecha Registro:'); 
   $smarty ->assign('lfecven','Fecha Vencimiento:'); 
   $smarty ->assign('ltipo','Tipo de Anotaci&oacute;n:'); 
   $smarty ->assign('lfechaven','Fecha de Vencimiento:');
   $smarty ->assign('lclaseint','Clase Internacional:');
   $smarty ->assign('ldocumento','N&uacute;mero de Documento:'); 
   $smarty ->assign('lcomenta','Titular(es) Anterior(es):'); 
   $smarty ->assign('ldomant','Domicilio Anterior:'); 
   $smarty ->assign('ldomnew','Domicilio:'); 
   $smarty ->assign('ldomicilio','Domicilio Actual:'); 
   $smarty ->assign('lnacionalidad','Nacionalidad Actual:'); 
   $smarty ->assign('lnacnew','Nacionalidad:'); 
   $smarty ->assign('lagenew','Agente:'); 
   $smarty ->assign('ltranew','Tramitante:'); 
   $smarty ->assign('ltrage','Tramitante/Agente Actual:');
   $smarty ->assign('lboletin','Boletin:');
   $smarty ->assign('lnomtit','Nombre:'); 

   $smarty ->assign('espacios',''); 
   $smarty->display('encabezado1.tpl');
   $smarty->display('m_actmargi.tpl'); 
   $smarty->display('pie_pag.tpl');
?>
