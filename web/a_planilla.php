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
// Programa: w_ingresol.php 
// Realizado por el Analista de Sistema  Karina Pérez
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MILCO
// Año 2010
// *************************************************************************************
// *************************************************************************************
include ("../setting.inc.php");
//include ("../setting.inc.pruebafm02.php");
ob_start();

//Comienzo del Programa por los encabezados del reporte
include ("../z_includes.php");
//include ("../z_includes.pruebafm02.php");

//funcion del formulario
//include ("w_formulario.php");

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
$smarty->assign('subtitulo','Ingreso de Solicitud al SIPI');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');
$smarty->assign('varfocus','wingresol.vtramt'); 
$smarty->assign('modo2','readonly');


//Verificando conexion
$sql->connection($usuario);

//****************************************************************************
if ($vopc==4) {
    $sql1 = new mod_db();
    $sql1->connection1();
    $resultado_tram = pg_exec("SELECT * FROM stdsolobra, stztramite
    			 	WHERE stdsolobra.nro_tramite = '$vtramt'  
    			 	AND  stdsolobra.nro_referencia = '$vsol'
    			 	AND stdsolobra.nro_tramite = stztramite.nro_tramite  
    			 	AND stztramite.estatus_tra = '50' ");
    $filas_resultado_tram = pg_numrows($resultado_tram); 
    $sql1->disconnect1();
    $sql1 = new mod_db();
    $sql1->connection1();
    //verficar si se pide poder
    //$result_poder = pg_exec("SELECT * FROM stdztmpage WHERE nro_tramite='$vtramt' and solicitud='$vsol'");
    //$reg_poder = pg_fetch_array($result_poder);    
    //$vtipo_persona = $reg_poder['tipo_per'];
    $vpedirpoder='N';
    //if ($vtipo_persona=='1' or $vtipo_persona=='3') {$vpedirpoder='S';}    

    //ejecuto el shell para traer la imagen
    //$result_tra = pg_exec("SELECT ref_gra FROM stmsolref where nro_tramite='$vtramt' and solicitud='$vsol'");
    //$reg_t = pg_fetch_array($result_tra);    
    //$nro_busgra = $reg_t['ref_gra'];
    //$nro_bus = $reg_t['archivo_logo'];    
    
   //  echo "nro: $nro_busgra";
   //    $cmd="scp -P  22 www-data@172.16.0.7:/var/www/consulta/apl/logotipos/".$nro_busgra.".png  /var/www/apl/sipi2011/graficos/docutemp/";
//    $cmd="scp -P  22 www-data@172.16.0.7:/var/www/apl/webpi/imagentemp/".$nro_busgra.".jpg  /var/www/apl/sipi/docutemp/";
//    $cmd="scp -P  22 www-data@172.16.0.7:/var/www/apl/webpint/imagentemp/".$nro_busgra.".jpg  /var/www/apl/sipi/graficos/docutemp/";    
//        exec($cmd);
    //if ($nro_busgra>0) {
    //   $cmd="scp -P 3535 www-data@172.16.0.7:/var/www/apl/webpi/imagentemp/".$nro_busgra.".jpg /var/www/apl/sipi/docutemp/".$vsol.".jpg"; 
    //   exec($cmd,$salida);
    //   $nameimage='../docutemp/'.$vsol.'.jpg'; 
    //}

 
    //copia los documentos del webpi a una carpeta temporal en el sipi, hasta validarlos y moverlos al sitio correcto
//    $cmd="scp -P  22 www-data@172.16.0.7:/var/www/consulta/apl/documentos/poder/".$vsol.".pdf  /var/www/apl/sipi2011/graficos/docutemp/poder/"; 
//    exec($cmd);
//    $cmd="scp -P  22 www-data@172.16.0.7:/var/www/consulta/apl/documentos/asamblea/".$vsol.".pdf  /var/www/apl/sipi2011/graficos/docutemp/asamblea/"; 
//    exec($cmd);
//    $cmd="scp -P  22 www-data@172.16.0.7:/var/www/consulta/apl/documentos/reglamento/".$vsol.".pdf  /var/www/apl/sipi2011/graficos/docutemp/reglamento/"; 
//    exec($cmd);
//    $cmd="scp -P  22 www-data@172.16.0.7:/var/www/consulta/apl/documentos/cedula/".$vsol.".pdf  /var/www/apl/sipi2011/graficos/docutemp/cedula/"; 
//    exec($cmd);
//    $cmd="scp -P  22 www-data@172.16.0.7:/var/www/consulta/apl/documentos/prioridad/".$vsol.".pdf  /var/www/apl/sipi2011/graficos/docutemp/prioridad/"; 
//    exec($cmd);
//    $cmd="scp -P  22 www-data@172.16.0.7:/var/www/consulta/apl/documentos/rif/".$vsol.".pdf  /var/www/apl/sipi2011/graficos/docutemp/rif/"; 
//    exec($cmd);
//    $cmd="scp -P  22 www-data@172.16.0.7:/var/www/consulta/apl/documentos/mercantil/".$vsol.".pdf  /var/www/apl/sipi2011/graficos/docutemp/mercantil/"; 
//    exec($cmd);
//    $cmd="scp -P  22 www-data@172.16.0.7:/var/www/consulta/apl/documentos/otros/".$vsol.".pdf  /var/www/apl/sipi2011/graficos/docutemp/otros/"; 
//    exec($cmd);

    //$formulario=formulario($vtramt,$vsol); 
    //$planilla= 'formulario'.$vtramt.'_'.$vsol.'.pdf';
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
   $resultadosoltra=pg_exec("select a.nro_tramite,a.nro_referencia,a.titulo_obra,a.tipo_obra,b.usuario from stdsolobra a,stztramite b where a.nro_tramite='$vtramt' and a.nro_referencia='$vsol' and a.nro_tramite=b.nro_tramite order by a.nro_tramite,a.nro_referencia");
   $vcansol=pg_numrows($resultadosoltra); 
   $regsoltra = pg_fetch_array($resultadosoltra); 
   $vusuario=$regsoltra['usuario'];
   //
   $vnsolsipi=$regsoltra['titulo_obra'];
   $vnclasipi=$regsoltra['tipo_obra'];
   $vntipobra=tipo_obra2($regsoltra['tipo_obra']);
   //if ($vusuario<>$usuario) {
   //  mensajenew('Error: El Tramite pertenece a otro Usuario! Verifique...','javascript:history.back();','N');
   //  $smarty->display('pie_pag.tpl'); exit(); 
   //}
   if ($vcansol<1) {
     mensajenew('Error: Tramite No Registrado! Verifique...','javascript:history.back();','N');
     $smarty->display('pie_pag.tpl'); exit(); 
   }
   for($cont=1;$cont<=$vcansol;$cont++) { 
     $vnumsol=$regsoltra['nro_referencia'];
     $vrefsol[$cont]=$regsoltra['nro_referencia'];
     $vnomsol[$cont]=$regsoltra['titulo_obra'];
     $vtipder[$cont]=$regsoltra['tipo_obra'];
     $vtipobr[$cont]=tipo_obra2($regsoltra['tipo_obra']);
     //$vclaint[$cont]=$regsoltra['clase'];
     //$vclanac[$cont]=$regsoltra['clase_nac'];
//$resultadodocsol0=pg_exec("select a.cod_anexo,a.estatus,b.desc_anexo,b.ruta from stzanxtra a,stzanexo b where nro_tramite='$vtramt' and solicitud='$vnumsol' and a.cod_anexo=b.cod_anexo and a.estatus='0' order by 1");
//     $vcandoc0=pg_numrows($resultadodocsol0); 
//     $vcanane0[$cont]=$vcandoc0;
//     $resultadodocsol=pg_exec("select a.cod_anexo,a.estatus,b.desc_anexo,b.ruta from stzanxtra a,stzanexo b where nro_tramite='$vtramt' and solicitud='$vnumsol' and a.cod_anexo=b.cod_anexo order by 1");
//     $vcandoc=pg_numrows($resultadodocsol); 
//     $vcanane[$cont]=$vcandoc;
//     for($cont2=1;$cont2<=$vcandoc;$cont2++) { 
//        $regdocsol = pg_fetch_array($resultadodocsol); 
//        $vcodane[$cont][$cont2]=$regdocsol['cod_anexo'];
//        $vdesane[$cont][$cont2]=$regdocsol['desc_anexo'];
//        $vestane[$cont][$cont2]=$regdocsol['estatus'];
//        $vsubdir[$cont][$cont2]=$regdocsol['ruta'];
//     }
     $regsoltra = pg_fetch_array($resultadosoltra); 
   }
   //$sql1->disconnect1();
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
   $sql->disconnect();
}   


//Pase de variables y Etiquetas al template
$smarty->assign('submitbutton','submit'); 
$smarty->assign('submitbutton1','button'); 

$smarty->assign('campo1','Nro. Tramite:');
$smarty->assign('usuario',$usuario);
$smarty->assign('vopc',$vopc);
//$smarty->assign('accion',$accion);
$smarty->assign('vtramt',$vtramt);
$smarty->assign('vsol',$vsol);
$smarty->assign('vnsolsipi',$vnsolsipi);
$smarty->assign('vnclasipi',$vnclasipi);
$smarty->assign('vntipobra',$vntipobra);
$smarty->assign('nameimage',$nameimage);

$smarty->assign('usuario',$usuario);
$smarty->assign('vreftra',$vtramt);
$smarty->assign('vcansol',$vcansol);
$smarty->assign('vrefsol',$vrefsol);
$smarty->assign('vnomsol',$vnomsol);
$smarty->assign('vtipder',$vtipder);
$smarty->assign('vtipobr',$vtipobr);
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

$smarty->display('a_ingresol1.tpl');
$smarty->display('pie_pag.tpl');
//ob_end_clean(); 
?>
