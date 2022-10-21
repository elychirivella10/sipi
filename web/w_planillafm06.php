<script language="Javascript"> 
function pregunta() { 
  return confirm('Estas seguro de enviar la Informacion ?'); }

function checkear(f)	{
				function no_prever() {
					alert("El archivo buscado y seleccionado no es valido ...!!!");
					f.value='';
				}
				function prever() {
					var campos = new Array("maxpeso", "maxalto", "maxancho");
					for (i = 0, total = campos.length; i < total; i ++)
						f.form[campos[i]].disabled = false;
					actionActual = f.form.action;
					targetActual = f.form.target;
					f.form.action = "previsor.php";
					f.form.target = "ver";
					f.form.submit();
					for (i = 0, total = campos.length; i < total; i ++)
						f.form[campos[i]].disabled = true;
					f.form.action = actionActual;
					f.form.target = targetActual;
				}

				(/\.(pdf)$/i.test(f.value)) ? prever() : no_prever();
			}
</script>

<?php
// *************************************************************************************
// Programa: w_planillafm06.php 
// Realizado por el Analista de Sistema  Ing. Romulo Meedoza
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MPPCN
// Año 2019 II Semestre
// *************************************************************************************
// *************************************************************************************
include ("../setting.inc.php");
//ob_start();

//Comienzo del Programa por los encabezados del reporte
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado"; exit();}

//Variables
$usuario   = $_SESSION['usuario_login'];
$role      = $_SESSION['usuario_rol'];
$fecha     = fechahoy();
$fechahoy  = hoy();
$sql = new mod_db();

$tbname_1 = "stzpaisr";
$tbname_2 = "stzagenr";
$tbname_3 = "stzsolic";
$tbname_4 = "stmmarce";
$tbname_5 = "stzevtrd";
$tbname_6 = "stzderec";
$tbname_7 = "stzottid";
$tbname_8 = "stmlogos";
$tbname_9 = "stztmptit";
$tbname_10 = "stzusuar";
$tbname_11 = "stmtmpccv";
$tbname_12 = "stzbitac";
$tbname_13 = "stzbider";
$tbname_14 = "stmlemad";
$tbname_15 = "stzpriod";
$tbname_16 = "stzautod";
$tbname_17 = "stmccvma";
$tbname_18 = "stztmpage";
$tbname_19 = "stztmprio";
$tbname_20 = "stzanxtra";

$vopc = $_GET['vopc'];
$vtramt=$_GET['vtramt'];
$vsol=$_GET['vsol'];


$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Ingreso de Cambio de Domicilio de Marcas al SIPI');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');
$smarty->assign('varfocus','wingreren.vtramt'); 
$smarty->assign('modo2','readonly');


//Verificando conexion
$sql->connection($usuario);

//****************************************************************************
if ($vopc==4) {
    $sql1 = new mod_db();
    $sql1->connection1();

    $resultado_tram = pg_exec("SELECT * FROM stzsolcam, stztramite
    			 	WHERE stzsolcam.nro_tramite = '$vtramt'  
    			 	AND  stzsolcam.nro_referencia = '$vsol'
    			 	AND stzsolcam.nro_tramite = stztramite.nro_tramite  
    			 	AND stztramite.estatus_tra = '72' ");
    $filas_resultado_tram = pg_numrows($resultado_tram); 
    //$sql1->disconnect1();
    //$sql1 = new mod_db();
    //$sql1->connection1();

    //verficar si se pide poder
    $result_poder = pg_exec("SELECT * FROM stztmpage WHERE nro_tramite='$vtramt' and solicitud='$vsol'");
    $reg_poder = pg_fetch_array($result_poder);    
    $vtipo_persona = $reg_poder['tipo_per'];
    $vpedirpoder='N';
    if ($vtipo_persona=='1' or $vtipo_persona=='3') {$vpedirpoder='S';}    

    //ejecuto el shell para traer la imagen
    //$result_tra = pg_exec("SELECT * FROM stmbugra WHERE nro_tramite= '$vtramt'");
    //$reg_t = pg_fetch_array($result_tra);    
    //$nro_busgra = $reg_t['nro_busgra'];
    //$nro_bus = $reg_t['archivo_logo'];    
    
    $vtramite= $vtramt;


    //echo "<iframe src= $planilla width='100%' height='70%' align='center' ></iframe>"; 
    $sql1->disconnect1();
  
  //  unlink("$planilla");

   $verplanilla='N';
   $sql1 = new mod_db();
   $sql1->connection1();
   //$resulfinal=pg_exec("select * from stzanxtra where nro_tramite='$vtramt' and solicitud='$vsol' and estatus='0'");
   //$vcanfin=pg_numrows($resulfinal); 
   //if ($vcanfin==0) {$verplanilla='S';}

   //$resuldoc=pg_exec("select stzanxtra.cod_anexo,stzanexo.desc_anexo from stzanxtra, stzanexo 
   //                    where stzanxtra.cod_anexo=stzanexo.cod_anexo and nro_tramite='$vtramt' and solicitud='$vsol'");
   //$regsoldoc=pg_fetch_array($resuldoc); 
   //$vcandoc=pg_numrows($resuldoc); 
   //$vdocanexoa='N';$vdocanexob='N';$vdocanexoc='N';$vdocanexof='N';$vdocanexog='N';$vdocanexoh='N';$vdocanexoi='N';
   //for($cont=1;$contdoc<=$vcandoc;$contdoc++) { 
   //   if ($regsoldoc['cod_anexo']=='A') {$vdocanexoa='S'; $vlitanexoa=$regsoldoc['desc_anexo'];}
   //   if ($regsoldoc['cod_anexo']=='B') {$vdocanexob='S'; $vlitanexob=$regsoldoc['desc_anexo'];} 
   //   if ($regsoldoc['cod_anexo']=='C') {$vdocanexoc='S'; $vlitanexoc=$regsoldoc['desc_anexo'];} 
   //   if ($regsoldoc['cod_anexo']=='F') {$vdocanexof='S'; $vlitanexof=$regsoldoc['desc_anexo'];} 
   //   if ($regsoldoc['cod_anexo']=='G') {$vdocanexog='S'; $vlitanexog=$regsoldoc['desc_anexo'];} 
   //   if ($regsoldoc['cod_anexo']=='H') {$vdocanexoh='S'; $vlitanexoh=$regsoldoc['desc_anexo'];} 
   //   if ($regsoldoc['cod_anexo']=='I') {$vdocanexoi='S'; $vlitanexoi=$regsoldoc['desc_anexo'];} 
   //   $regsoldoc=pg_fetch_array($resuldoc); 
   //}
   //
//   $resultadosoltra=pg_exec("select a.nro_tramite,a.solicitud,a.nombre,a.tipo_derecho,b.clase,c.clase_nac,d.usuario from stzderec a,stmmarce b,stmclnac c,stztramite d where a.nro_tramite='$vtramt' and a.solicitud='$vsol' and a.nro_tramite=b.nro_tramite and a.solicitud=b.solicitud and a.nro_tramite=c.nro_tramite and a.solicitud=c.solicitud and a.nro_tramite=d.nro_tramite order by a.nro_tramite,a.solicitud");
   $resultadosoltra=pg_exec("select a.nro_tramite,a.nro_referencia,a.nombre,a.registro,a.nro_solicitud,a.tipo_derecho,a.clase,a.clase_nac,a.ind_clase,a.poder,b.usuario,b.f_tramite from stzsolcam a,stztramite b 
where a.nro_tramite='$vtramt' and a.nro_referencia='$vsol' and a.nro_tramite=b.nro_tramite order by a.nro_tramite,a.nro_referencia");
   $vcansol=pg_numrows($resultadosoltra); 
   $regsoltra = pg_fetch_array($resultadosoltra); 
   $vusuario =$regsoltra['usuario'];
   $vfec_tram=$regsoltra['f_tramite'];

   $vnmarsipi=$regsoltra['nombre'];
   $vnclasint=$regsoltra['clase'];
   $vnclasnac=$regsoltra['clase_nac'];
   $vnregsipi=$regsoltra['registro'];
   $vnsolsipi=$regsoltra['nro_solicitud'];
   $vnumref  =$regsoltra['nro_referencia'];
   $vpoder   =trim($regsoltra['poder']);
   $vpod1=substr($vpoder,0,4);
   $vpod2=str_pad(substr($vpoder,5,4),4,"0");

   $new_domicilio = "";
   $res_domicilio = pg_exec("SELECT * FROM stzcamdom WHERE stzcamdom.nro_tramite='$vtramt' AND stzcamdom.nro_referencia='$vsol'");
   $filas_cfound1=pg_numrows($res_domicilio);
   $regtc = pg_fetch_array($res_domicilio);
   for($cont1=0;$cont1<$filas_cfound1;$cont1++)   { 
      $domicilio = $regtc['domicilio_actual'];
      $pais_domicilio=pais($regtc['pais_actual']);
      $new_domicilio = $new_domicilio.$domicilio.", ".$pais_domicilio;
      $regtc = pg_fetch_array($res_domicilio);
   } 
   $vnclasnac = $new_domicilio; 

   //if ($vusuario<>$usuario) {
   //  mensajenew('Error: El Tramite pertenece a otro Usuario! Verifique...','javascript:history.back();','N');
   //  $smarty->display('pie_pag.tpl'); exit(); 
   //}
   if ($vcansol<1) {
     mensajenew('AVISO: Nro. de Tramite No Registrado!, Verifique ...!!!','../web/w_ingredomm.php?vopc=3','N');
     $smarty->display('pie_pag.tpl'); exit(); 
   }
   for($cont=1;$cont<=$vcansol;$cont++) { 
     $vnumsol=$regsoltra['nro_referencia'];
     $vrefsol[$cont]=$regsoltra['nro_referencia'];
     $vnomsol[$cont]=$regsoltra['nombre'];
     $vtipder[$cont]=$regsoltra['tipo_derecho'];
     $vclaint[$cont]=$regsoltra['clase'];
     $vclanac[$cont]=$regsoltra['clase_nac'];
$resultadodocsol0=pg_exec("select a.cod_anexo,a.estatus,b.desc_anexo,b.ruta from stzanxtra a,stzanexo b where nro_tramite='$vtramt' and solicitud='$vnumsol' and a.cod_anexo=b.cod_anexo and a.estatus='0' order by 1");
     $vcandoc0=pg_numrows($resultadodocsol0); 
     $vcanane0[$cont]=$vcandoc0;
     //$resultadodocsol=pg_exec("select a.cod_anexo,a.estatus,b.desc_anexo,b.ruta from stzanxtra a,stzanexo b where nro_tramite='$vtramt' and solicitud='$vnumsol' and a.cod_anexo=b.cod_anexo order by 1");
     //$vcandoc=pg_numrows($resultadodocsol); 
     //$vcanane[$cont]=$vcandoc;
     //for($cont2=1;$cont2<=$vcandoc;$cont2++) { 
     //   $regdocsol = pg_fetch_array($resultadodocsol); 
     //   $vcodane[$cont][$cont2]=$regdocsol['cod_anexo'];
     //   $vdesane[$cont][$cont2]=$regdocsol['desc_anexo'];
     //   $vestane[$cont][$cont2]=$regdocsol['estatus'];
     //   $vsubdir[$cont][$cont2]=$regdocsol['ruta'];
     //}
     $regsoltra = pg_fetch_array($resultadosoltra); 
   }
   $sql1->disconnect1();
   //$sql = new mod_db();
   //$sql->connection();
   // Vector Causales de la Devolucion
   //$obj_query = $sql->query("SELECT * FROM stzcoded where derecho='M' and grupo='M' and cod_causa in ('06','10','11')
   //                          ORDER BY derecho,grupo,cod_causa");
   //$obj_filas = $sql->nums('',$obj_query);
   //$contobj = 0;
   //$objs = $sql->objects('',$obj_query);
   //for ($contobj=0;$contobj<=$obj_filas;$contobj++) {
   //    $vcodcausa[$contobj] = $objs->cod_causa;
   //    $vdescausa[$contobj] = $objs->desc_causa;
   //    $objs = $sql->objects('',$obj_query);
   //}
   //$sql->disconnect();
}   


//Pase de variables y Etiquetas al template
$smarty->assign('campo1','Nro. Tramite:');
$smarty->assign('usuario',$usuario);
$smarty->assign('vopc',$vopc);
$smarty->assign('vtramt',$vtramt); 
$smarty->assign('vfec_tram',$vfec_tram);  
$smarty->assign('vsol',$vsol);
$smarty->assign('vnumref',$vnumref);
$smarty->assign('vnsolsipi',$vnsolsipi);
$smarty->assign('vnregsipi',$vnregsipi);
$smarty->assign('vnmarsipi',$vnmarsipi);
$smarty->assign('vnclasint',$vnclasint);
$smarty->assign('vnclasnac',$vnclasnac);
$smarty->assign('nameimage',$nameimage);
$smarty->assign('vpod1',$vpod1);
$smarty->assign('vpod2',$vpod2);

$smarty->assign('usuario',$usuario);
$smarty->assign('vreftra',$vtramt);
$smarty->assign('vcansol',$vcansol);
$smarty->assign('vrefsol',$vrefsol);
$smarty->assign('vnomsol',$vnomsol);
$smarty->assign('vtipder',$vtipder);
$smarty->assign('vclaint',$vclaint);
$smarty->assign('vclanac',$vclanac);
$smarty->assign('vcodane',$vcodane);
$smarty->assign('vdesane',$vdesane);
$smarty->assign('vestane',$vestane);
$smarty->assign('vsubdir',$vsubdir);
$smarty->assign('vcanane',$vcanane);
$smarty->assign('vcanane0',$vcanane0);
$smarty->assign('verplanilla',$verplanilla);
$smarty->assign('vpedirpoder',$vpedirpoder);

   $smarty ->assign('causa1',$vcausa1); 
   $smarty ->assign('causa2',$vcausa2); 
   $smarty ->assign('causa3',$vcausa3); 
   $smarty ->assign('causa4',$vcausa4); 
   $smarty ->assign('causa5',$vcausa5); 
   $smarty ->assign('causa6',$vcausa6); 
   $smarty ->assign('causa7',$vcausa7); 
   $smarty ->assign('codcausa',$vcodcausa);
   $smarty ->assign('descausa',$vdescausa); 

$smarty ->assign('vdocanexoa',$vdocanexoa);
$smarty ->assign('vdocanexob',$vdocanexob);
$smarty ->assign('vdocanexoc',$vdocanexoc);
$smarty ->assign('vdocanexof',$vdocanexof);
$smarty ->assign('vdocanexog',$vdocanexog);
$smarty ->assign('vdocanexoh',$vdocanexoh);
$smarty ->assign('vdocanexoi',$vdocanexoi);
$smarty ->assign('vlitanexoa',$vlitanexoa);
$smarty ->assign('vlitanexob',$vlitanexob);
$smarty ->assign('vlitanexoc',$vlitanexoc);
$smarty ->assign('vlitanexof',$vlitanexof);
$smarty ->assign('vlitanexog',$vlitanexog);
$smarty ->assign('vlitanexoh',$vlitanexoh);
$smarty ->assign('vlitanexoi',$vlitanexoi);

$smarty ->assign('fecha_reno',$fechahoy);

$smarty->display('w_ingrefm06.tpl');
$smarty->display('pie_pag.tpl');
//ob_end_clean(); 
?>
