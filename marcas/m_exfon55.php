<script language="Javascript"> 

function pregunta() { 
  return confirm('Estas seguro de grabar la Informacion ?'); }

function getKey(keyStroke) {  
isNetscape=(document.layers); 
eventChooser = (isNetscape) ? keyStroke.which : event.keyCode;    
if (eventChooser==13) {      
   return false; 
   }  
} 
document.onkeypress = getKey;

$('#vsol2').keydown(function (e){
    if(e.keyCode == 13){
         $("#buscar").focus();
    }
})

</script> 

<?php
// *************************************************************************************
// Programa: m_exfon55.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MILCO, MPPCN
// Año: 2006
// Creado I Semestre 2009 BD - Relacional   
// Modificado 2015 I Semestre, 2018 II Semestre 
// *************************************************************************************

//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variables
$usuario   = $_SESSION['usuario_login'];
$role      = $_SESSION['usuario_rol'];
$sql       = new mod_db();
$fecha     = fechahoy();
$modulo    = "m_exfon55.php";
$fechahoy  = hoy();

$tbname_1  = "stzpaisr";
$tbname_2  = "stzagenr";
$tbname_3  = "stzsolic";
$tbname_4  = "stmmarce";
$tbname_5  = "stzevtrd";
$tbname_6  = "stzderec";  
$tbname_7  = "stzottid";
$tbname_8  = "stmlogos";
$tbname_9  = "stzusuar";
$tbname_10 = "stmlemad";
$tbname_11 = "stzstder";
$tbname_12 = "stzevder";

$vopc   = $_GET['vopc'];
$salir  = $_GET['salir']; 
$vsol1  = $_POST['vsol1'];
$vsol2  = $_POST['vsol2'];
$vsol   = $_POST['vsol'];
$vder   = $_POST['vder'];

$opcion       = $_POST['opcion'];
$modal        = $_POST['modal'];
$fevento      = $_POST['fevento'];
$fevento1     = $_POST['fevento1'];
$fevento2     = $_POST['fevento2'];
$fevento3     = $_POST['fevento3'];
$fevento4     = $_POST['fevento4'];
$modalidad    = $_POST['modalidad'];
$fecha_solic  = $_POST['fecha_solic'];
$tipo_marca   = $_POST['tipo_marca'];
$nombre       = $_POST['nombre'];
$estatus      = $_POST['estatus'];
$vclase       = $_POST['vclase'];
$vpod1        = $_POST['vpod1'];
$vpod2        = $_POST['vpod2'];
$fpoder       = $_POST['fpoder'];
$facultad     = $_POST['facultad'];
$tramitante   = $_POST['tramitante'];
$pais_resid   = $_POST['pais_resid'];
$distingue    = $_POST['distingue'];
$etiqueta     = $_POST['etiqueta'];
$vnomagenew   = $_POST['vnomage'];
$arraynompais = $_POST['vnompais'];
$vcodpais     = $_POST['vcodpais'];
$vcodage      = $_POST['vcodage'];
$vsol3        = $_POST['vsol3'];
$vsol4        = $_POST['vsol4'];
$comenta2     = $_POST['comenta2'];

$vcausa1      = $_POST['causa1'];  
$vcausa2      = $_POST['causa2'];  
$vcausa3      = $_POST['causa3'];  
$vcausa4      = $_POST['causa4'];
$vcausa5      = $_POST['causa5'];  
$vcausa6      = $_POST['causa6'];  
$vcausa7      = $_POST['causa7'];  
$vcausa8      = $_POST['causa8'];
$vcausa9      = $_POST['causa9'];  
$vcausa10     = $_POST['causa10']; 
$vcausa11     = $_POST['causa11']; 
$vcausa12     = $_POST['causa12'];
$vcausa13     = $_POST['causa13']; 
$vcausa14     = $_POST['causa14']; 
$vcausa15     = $_POST['causa15'];
$vcausa16     = $_POST['causa16'];
$vcausa17     = $_POST['causa17'];
$vcausa18     = $_POST['causa18'];
$vcausa19     = $_POST['causa19']; 
$vcausa20     = $_POST['causa20']; 
$vcausa21     = $_POST['causa21'];
$vcausa22     = $_POST['causa22']; 
$vcausa23     = $_POST['causa23']; 
$vcausa24     = $_POST['causa24'];
$vcausa25     = $_POST['causa25'];
$votro        = $_POST['otro'];

$vart      = $_POST['art'];
$vlit1     = $_POST['lit1'];
$vlit2     = $_POST['lit2'];
$vcom      = $_POST['comenta1'];
$vreg11    = $_POST['vlit1reg11'];
$vreg12    = $_POST['vlit1reg12'];
$vreg21    = $_POST['vlit1reg21'];
$vreg22    = $_POST['vlit1reg22'];
$vreg31    = $_POST['vlit1reg31'];
$vreg32    = $_POST['vlit1reg32'];
$vreg41    = $_POST['vlit2reg11'];
$vreg42    = $_POST['vlit2reg12'];
$vreg51    = $_POST['vlit2reg21'];
$vreg52    = $_POST['vlit2reg22'];
$vreg61    = $_POST['vlit2reg31'];
$vreg62    = $_POST['vlit2reg32'];
$vreg1     = $vreg11.$vreg12;
$vreg2     = $vreg21.$vreg22;
$vreg3     = $vreg31.$vreg32;
$vreg4     = $vreg41.$vreg42;
$vreg5     = $vreg51.$vreg52;
$vreg6     = $vreg61.$vreg62;

// ************************************************************************************  
$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Examen de Forma y Fondo a Expediente LPI-55'); 
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

// ************************************************************************************  
//Opcion Mostrar Datos
if ($vopc==1) {
  $smarty->assign('vmodo','readonly=readonly'); 
  $smarty->assign('modo',''); 
  $smarty->assign('varfocus','formarcas2.fecha_solic');
  $fevento = hoy();
  $fevento1 = hoy();
  $fevento2 = hoy();
  $fevento3 = hoy();
  $fevento4 = hoy();
  
  //Validacion del Numero de Solicitud
  if (empty($vsol1) && empty($vsol2)) {
     mensajenew("ERROR: No introdujo ning&uacute;n valor de Expediente ...!!!","m_exfon55.php","N");
     $smarty->display('pie_pag.tpl'); exit(); }

  //Armado del Numero de Expediente
  $varsol=$vsol1."-".sprintf("%06d",$vsol2);
  //Nombre de la Imagen del Expediente 
  $nameimage="../imagenes/sin_imagen8.png";
  
  //Verificando conexion
  $sql->connection($usuario);
  
  $resultado=pg_exec("SELECT * FROM $tbname_6 WHERE solicitud='$varsol' and solicitud!=''AND tipo_mp='M'");

  if (!$resultado) { 
      mensajenew('ERROR: PROBLEMAS AL PROCESAR LA BUSQUEDA ...!!!','m_exfon55.php','N');
	   $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  }	 
  $filas_found=pg_numrows($resultado); 
  if ($filas_found==0) {
      mensajenew('ERROR: NO EXISTEN DATOS ASOCIADOS ...!!!','m_exfon55.php','N');
	   $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  }	 
  $reg = pg_fetch_array($resultado);

  $vsol    = trim($reg[solicitud]);
  $vsol1   = substr($vsol,-11,4);
  $varsol2 = substr($vsol,-6,6);
  $varsol1 = substr($vsol,-11,4);
  $vsol2   = substr($vsol,-6,6);
  $vder    = $reg[nro_derecho];  
  $estatus = $reg[estatus];
  
  if (($estatus!=1001) && ($estatus!=1008) && ($estatus!=1104) && ($estatus!=1027) && ($estatus!=1029) && ($estatus!=1300) && ($estatus!=1305) && ($estatus!=1120)) {
    mensajenew('ERROR: Solo se pueden examinar Expedientes en Estatus 1, 8, 27, 29, 104, 120, 300 o 305...!!!','m_exfon55.php','N');
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  }

  //Validacion para nuevo procedimiento de forma y fondo.
  //if (($estatus==1001) && ($vsol<'2014-007442')) {
  //  mensajenew('ERROR: Expediente NO se puede examinar, solo mayores a 2014-007441 en estatus 1 ...!!!','m_exfon55.php','N');
  //  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  //}

  //if (($estatus==1008) && ($vsol>='2014-007442')) {
  //  mensajenew('ERROR: Expediente NO se puede examinar, solo menores a 2014-007442 en estatus 8 ...!!!','m_exfon55.php','N');
  //  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  //}

  //echo "sol= $vsol,$vsol1,$vsol2,$varsol1,$varsol2 - $estatus ";
  if ($estatus==1300) { 
   if ($vsol<'2014-007442') {
    //if ($vsol2<'007442') {
    mensajenew('ERROR: Expediente NO se puede examinar, solo mayores a 2014-007441 en estatus 300 ...!!!','m_exfon55.php','N');
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 
  }
  
  $resulconc=pg_exec("SELECT * FROM stzevtrd WHERE nro_derecho='$vder' AND evento in (1124) AND estat_ant in (1006)");   
  $regcon = pg_fetch_array($resulconc);
  $fvencim = $regcon[fecha_venc];
  $vbol = $regcon[documento];

  //if ($vbol!=539) {
  //  // Se verifica si la fecha de hoy es mayor a la del vencimiento del boletin donde salio como solicitada 
  //  $esmayor=compara_fechas($fechahoy,$fvencim);
  //  if ($esmayor==1) { }
  //  else { 
  //    // fecha actual menor a la fecha de vencimiento del boletin  
  //    mensajenew('ERROR: Expediente en Estatus 8 publicado en Boletin '.$vbol.', vigente en espera de plazo de Observaciones ...!!!','m_exfon55.php','N');
  //    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  //  }    
  //}

  $registro=$reg[registro];
  $nombre=trim($reg[nombre]);
  $vcodpais=$reg[pais_resid];
  $tipo_marca=$reg[tipo_derecho];
  $tramitante=trim($reg[tramitante]);
  $fecha_solic=$reg[fecha_solic];
  $poder = trim($reg[poder]);
  $vpod1 = trim(substr($poder,-9,4));
  $vpod2 = trim(substr($poder,-4,4));
  $vcodage=$reg[agente];
  $tram = agente_tramp($vcodage,$tramitante,$poder);
  
  $distingue='';
  //Obtención de datos de la Marca 
  $obj_query = $sql->query("SELECT * FROM $tbname_4 WHERE nro_derecho='$vder'");
  $objs = $sql->objects('',$obj_query);
  $modalidad = $objs->modalidad;
  $vclase    = $objs->clase;
  $ind_clase = $objs->ind_claseni;
  $distingue = trim($objs->distingue);
  $smarty->assign('vstring1',$distingue);

  $indclase = Ind_clase($ind_clase); 

  //Validacion de si esta hecha la busqueda grafica de fondo 
  if ($modalidad!="D") {
    //Verificando si el expediente ya presenta dicho evento 
    //$resul1=pg_exec("SELECT * FROM stzevtrd WHERE nro_derecho='$vder' AND evento=1050");
    //$filas1_found=pg_numrows($resul1); 
    //$resul2=pg_exec("SELECT * FROM stmaudef WHERE pedido='$varsol'");
    //$filas2_found=pg_numrows($resul2);  
    //if (($filas1_found==0) && ($filas2_found==0)) {
    //  mensajenew("ERROR: Expediente Gr&aacute;fico o Mixto sin B&uacute;squeda Gr&aacute;fica de Fondo ...!!!","m_exfon55.php","N");     
    //  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
    //} 
    //if (($filas1_found==0) || ($filas2_found==0)) {
    //  mensajenew("ERROR: Expediente Gr&aacute;fico o Mixto sin B&uacute;squeda Gr&aacute;fica de Fondo ...!!!","m_exfon55.php","N");     
    //  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
    //} 
  }
 
  switch ($modalidad) {
     case "G":
         $modal = "Grafica";
         break;
     case "M":
         $modal = "Mixta";
         break;
     case "D":
         $modal = "Denominativa";
         break;
  }
  $tipomarca= Tipo_marca($tipo_marca); 

  if ($modalidad=="D") {
    $nameimage="../imagenes/sin_imagen8.png"; }
  else { $nameimage = ver_imagen($vsol1,$vsol2,"M"); 
         $nameimage = "../graficos/marcas/ef".$vsol1."/".$vsol1.$vsol2.".jpg"; }  

  if (!file_exists($nameimage)) {
    $nameimage="../imagenes/sin_imagen8.png"; }
  $smarty->assign('nameimage',$nameimage);

  $etiqueta='';
  //Obtención de datos del logotipo de la Marca 
  $obj_query = $sql->query("SELECT * FROM $tbname_8 WHERE nro_derecho='$vder'");
  $objs = $sql->objects('',$obj_query);
  $etiqueta = trim($objs->descripcion);
  $smarty->assign('vstring1',$etiqueta);

  // Obtencion de la Descripcion del Estatus
  $nombest='';
  $nombest = estatus($estatus);

  // Obtencion del Nombre Pais
  $npais='';
  $pais_resid = pais($vcodpais);

  // Obtencion de los Titulares
  $restitu=pg_exec("SELECT stzottid.titular, stzsolic.nombre, stzottid.nacionalidad, stzottid.domicilio, stzsolic.indole, stzsolic.identificacion
                    FROM stzottid, stzsolic,stmmarce WHERE stzottid.nro_derecho='$vder'
			           AND stmmarce.nro_derecho=stzottid.nro_derecho
                    AND stzsolic.titular = stzottid.titular");
   
  $filas_tit=pg_numrows($restitu);
  $regtit = pg_fetch_array($restitu);
  for($cont1=0;$cont1<$filas_tit;$cont1++) 
   { 
     $arraytit1[$cont1]=$regtit[titular];
     $arraytit2[$cont1]=$regtit[nombre];
     $arraytit3[$cont1]=$regtit[domicilio];
     $arraytit4[$cont1]=$regtit[nacionalidad];
     $arraytit5[$cont1]=$regtit[indole];
     $arraytit6[$cont1]=$regtit[identificacion];
     $regtit = pg_fetch_array($restitu);
   }
  $smarty->assign('arr_tph1',$arraytit1); 
  $smarty->assign('arr_tph2',$arraytit2);
  $smarty->assign('arr_tph3',$arraytit3); 
  $smarty->assign('arr_tph4',$arraytit4);
  $smarty->assign('arr_tph5',$arraytit5);
  $smarty->assign('arr_tph6',$arraytit6);
  $smarty->assign('vtitrows',$filas_tit);

  // Obtencion de la Cronologia
  $rescron=pg_exec("SELECT * FROM stzevtrd WHERE nro_derecho='$vder' order by fecha_event,evento");   
  $filas_cron=pg_numrows($rescron);
  $reg = pg_fetch_array($rescron);
  $imagenresultado = "";
  for($cont=0;$cont<$filas_cron;$cont++) 
     { 
	    $evento      = $reg[evento]-1000;
	    $estatus_ant = $reg[estat_ant]-1000;
	    $boletin     = $reg[documento];
	    $archivodev  = "";
       $arraycron1[$cont]=$reg[fecha_event];
       $arraycron2[$cont]=$reg[fecha_venc];
       $arraycron3[$cont]=$reg[documento];
       $arraycron4[$cont]=$reg[evento];
       $arraycron5[$cont]=$reg[desc_evento];
       $arraycron6[$cont]=$reg[fecha_trans];
       $arraycron7[$cont]=$reg[comentario];
       if (($evento==122) AND (($estatus_ant==200) || ($estatus_ant==116)) AND ($boletin>=587)) { 
         $imagenresultado = "../imagenes/ver_devolucion.png";
         if ($estatus_ant==200) { 
           $archivodev = "../documentos/devueltas/marcas/forma/boletin".$boletin."/".$varsol1.$varsol2.".pdf"; } 
         else {
           $archivodev = "../documentos/devueltas/marcas/fondo/boletin".$boletin."/".$varsol1.$varsol2.".pdf"; }         
           //if (is_file($name)) {
           //  echo "<td align='left'><a href='$name' target='_blank'><img border='1' src='$imagenresultado' width='80' height='80'></a>";
           //echo "<td width='10%' class='celda8'><a href='$archivodev' target='_blank'><img border='1' src='$imagenresultado' width='40' height='40'></a></td>";
       }
       //else {
         //echo "<td width='10%' class='celda8'>&nbsp;&nbsp;</td>";
       //}
       //$varsol1="2018";
       //$varsol2="003650";
       //$boletin="587";
       //$archivodev = "../documentos/devueltas/marcas/forma/boletin".$boletin."/".$varsol1.$varsol2.".pdf";
       $arraycron8[$cont]=$archivodev;
       $arraycron9[$cont]=$reg[usuario];
       $arraycron10[$cont]=$reg[estat_ant];
       $reg = pg_fetch_array($rescron);
     }
  $smarty->assign('arr_ph1',$arraycron1); 
  $smarty->assign('arr_ph2',$arraycron2);
  $smarty->assign('arr_ph3',$arraycron3); 
  $smarty->assign('arr_ph4',$arraycron4);
  $smarty->assign('arr_ph5',$arraycron5);
  $smarty->assign('arr_ph6',$arraycron6);
  $smarty->assign('arr_ph7',$arraycron7);
  $smarty->assign('arr_ph8',$arraycron8);
  $smarty->assign('arr_ph9',$arraycron9);
  $smarty->assign('arr_ph10',$arraycron10);
  $smarty->assign('imagenresultado',$imagenresultado);
  $smarty->assign('vnumrows',$filas_cron);

  if ($poder<>"-") {
    $resultado=pg_exec("SELECT * FROM stzpoder WHERE poder='$poder'");
    $filas_found=pg_numrows($resultado); 
    // Elimina posibles registros existentes en el temporal
    $sql->del("temptitu","solicitud='$vsol'");
    $sql->del("tmppohad","poder='$poder'");
    // Se llenan los temporales
    $regresul = pg_fetch_array($resultado);
    $facultad=$regresul[facultad];
    $fpoder=$regresul[fecha_poder];
    for ($cont=0;$cont<$filas_found;$cont++) {
      $vtitular=$regresul[titular];
      //Ubicar el nombre del titular
      $resultit=pg_exec("SELECT nombre FROM stzsolic WHERE titular=$vtitular");
      $regtit = pg_fetch_array($resultit); 
      $vnomb=str_replace("'","`",$regtit[nombre]);
      $vnomb=str_replace("¶","Ñ",$regtit[nombre]);   
	   $insert_campos="solicitud,titular,nombre";
	   $insert_valores="'$vsol',$vtitular,'$vnomb'";	 
	   $sql->insert("temptitu","$insert_campos","$insert_valores","");
      $regresul = pg_fetch_array($resultado);
    }
    $resulpod=pg_exec("SELECT * FROM stzpohad WHERE poder='$poder'");
    $filas_pod=pg_numrows($resulpod); 
    $regpod = pg_fetch_array($resulpod); 
    for ($cont=0;$cont<$filas_pod;$cont++) {
      $vpoha=$regpod[poderhabi];
      //Ubicar el nombre del poderhabiente (agente)
      $resulag=pg_exec("SELECT nombre FROM stzagenr WHERE agente=$vpoha");
      $regag = pg_fetch_array($resulag); 
      $vnomb=str_replace("'","`",$regag[nombre]);
      $vnomb=str_replace("¶","Ñ",$regag[nombre]);  
	   $insert_campos="poder,poderhabi,nombre";
	   $insert_valores="'$poder',$vpoha,'$vnomb'";	 
	   $sql->insert("tmppohad","$insert_campos","$insert_valores","");
      $regpod = pg_fetch_array($resulpod);
    }
    $smarty ->assign('fpoder',$fpoder);
    $smarty ->assign('facultad',$facultad);
  }
  
  // Vector Causales de la Devolucion
  $obj_query = $sql->query("SELECT * FROM stzcoded where derecho='M' and grupo='M' 
                            ORDER BY derecho,grupo,cod_causa");
  $obj_filas = $sql->nums('',$obj_query);
  $contobj = 0;
  $objs = $sql->objects('',$obj_query);
  for ($contobj=0;$contobj<=$obj_filas;$contobj++) {
    $vcodcausa[$contobj] = $objs->cod_causa;
    $vdescausa[$contobj] = $objs->desc_causa;
   $objs = $sql->objects('',$obj_query);}

  $name ="../documentos/planilla/pl".$varsol1."/".$varsol1.$varsol2.".pdf"; 
  if (is_file($name)) { $fplanilla=1; } // planilla
         
  $name ="../documentos/poder/ef".$varsol1."/".$varsol1.$varsol2.".pdf"; 
  if (is_file($name)) { $fpoder=1; } // poder
         
  $name ="../documentos/reglamento/ef".$varsol1."/".$varsol1.$varsol2.".pdf"; 
  if (is_file($name)) { $freglamento=1; }  // reglamento uso de marca     
         
  $name ="../documentos/prioridad/ef".$varsol1."/".$varsol1.$varsol2.".pdf"; 
  if (is_file($name)) { $fprioridad=1; } // documento de prioridad  
         
  $name ="../documentos/tasa/ef".$varsol1."/".$varsol1.$varsol2.".pdf"; 
  if (is_file($name)) { $ftasa=1; } // tasa de registro 
                  
  $name ="../documentos/mercantil/ef".$varsol1."/".$varsol1.$varsol2.".pdf"; 
  if (is_file($name)) { $fmercantil=1; } //registro mercantil               

  $name ="../documentos/asamblea/ef".$varsol1."/".$varsol1.$varsol2.".pdf"; 
  if (is_file($name)) { $fasamblea=1; } // acta ultima asamblea

  $name ="../documentos/cedula/ef".$varsol1."/".$varsol1.$varsol2.".pdf"; 
  if (is_file($name)) { $fcedula=1; } // copia de ci
                 
  $name ="../documentos/rif/ef".$varsol1."/".$varsol1.$varsol2.".pdf"; 
  if (is_file($name)) { $frif=1; } //copia de rif  

  $name ="../documentos/fonetica/ef".$varsol1."/".$varsol1.$varsol2.".pdf"; 
  if (is_file($name)) { $ffonetica=1; } //busq fonetica  

  $name ="../documentos/grafica/ef".$varsol1."/".$varsol1.$varsol2.".pdf"; 
  if (is_file($name)) { $fgrafica=1; } //busq grafica  
       
  $name ="../documentos/otros/ef".$varsol1."/".$varsol1.$varsol2.".pdf"; 
  if (is_file($name)) { $fotros=1; } // Otros  

  $name ="../documentos/escritos/marcas/ef".$varsol1."/".$varsol1.$varsol2.".pdf"; 
  if (is_file($name)) { $fescritos=1; } //Escritos  

  $name ="../documentos/certificado/ef".$varsol1."/".$varsol1.$varsol2.".pdf"; 
  if (is_file($name)) { $fcertificado=1; } //Certificado de Registro  
   
  $resultado=pg_exec("SELECT comentario FROM stzevtrd a, stzderec b
                      WHERE a.evento='1022' and a.nro_derecho=b.nro_derecho 
                      AND b.solicitud= '$varsol' and b.solicitud!=''");
  $registro = pg_fetch_array($resultado);
  $filas_resultado=pg_numrows($resultado); 
  $total=$filas_resultado;
  if ($total>0) {
    $varcomenta=$registro['comentario'];
    $primeras6=substr($varcomenta,0,6);
    if ($primeras6=='Ciudad') {$var1='Ciudad Caracas'; 
                               $var2=substr($varcomenta,22,2).substr($varcomenta,25,2).substr($varcomenta,28,4); 
                               $var3=substr($varcomenta,39,2);
                               $vname='mar_'.$var1.'_'.$var2.'_'.trim($var3).'.pdf';
    }
    if ($primeras6=='Ultima') {$var1='Ultimas Noticias'; 
                               $var2=substr($varcomenta,24,2).substr($varcomenta,27,2).substr($varcomenta,30,4); 
                               $var3=substr($varcomenta,41,2);
                               $vname='mar_'.$var1.'_'.$var2.'_'.trim($var3).'.pdf';
    }
    if ($primeras6=='Diario') {$var1='Diario Vea'; 
                               $var2=substr($varcomenta,18,2).substr($varcomenta,21,2).substr($varcomenta,24,4); 
                               $var3=substr($varcomenta,35,2);
                               $vname='mar_'.$var1.'_'.$var2.'_'.trim($var3).'.pdf';
    }
    $name22 ="../graficos/prensa/".$vname; 
    if (is_file($name22)) { $fpub_prensa22=1; } // Publicacion Prensa (Evento 22)
  }
         
  $resultado=pg_exec("SELECT comentario FROM stzevtrd a, stzderec b
                      WHERE a.evento='1032' and a.nro_derecho=b.nro_derecho 
 	              AND b.solicitud= '$varsol' and b.solicitud!=''");
  $registro = pg_fetch_array($resultado);
  $filas_resultado=pg_numrows($resultado); 
  $total=$filas_resultado;
  if ($total>0) {
    $varcomenta=$registro['comentario'];
    $primeras6=substr($varcomenta,0,6);
    if ($primeras6=='Ciudad') {$var1='Ciudad Caracas'; 
                               $var2=substr($varcomenta,22,2).substr($varcomenta,25,2).substr($varcomenta,28,4); 
                               $var3=substr($varcomenta,39,2);
                               $vname='mar_'.$var1.'_'.$var2.'_'.trim($var3).'.pdf';
    }
    if ($primeras6=='Ultima') {$var1='Ultimas Noticias'; 
                               $var2=substr($varcomenta,24,2).substr($varcomenta,27,2).substr($varcomenta,30,4); 
                               $var3=substr($varcomenta,41,2);
                               $vname='mar_'.$var1.'_'.$var2.'_'.trim($var3).'.pdf';
    }
    if ($primeras6=='Diario') {$var1='Diario Vea'; 
                               $var2=substr($varcomenta,18,2).substr($varcomenta,21,2).substr($varcomenta,24,4); 
                               $var3=substr($varcomenta,35,2);
                               $vname='mar_'.$var1.'_'.$var2.'_'.trim($var3).'.pdf';
    }
    $name32 ="../graficos/prensa/".$vname; 
    if (is_file($name32)) { $fpub_prensa32=1; } // Publicacion Prensa Extemporaneo (Evento 32)
  }

  $resultado=pg_exec("SELECT comentario FROM stzevtrd a, stzderec b
                      WHERE a.evento='1033' and a.nro_derecho=b.nro_derecho 
  	              AND b.solicitud= '$varsol' and b.solicitud!=''");
  $registro = pg_fetch_array($resultado);
  $filas_resultado=pg_numrows($resultado); 
  $total=$filas_resultado;
  if ($total>0) {
    $varcomenta=$registro['comentario'];
    $primeras6=substr($varcomenta,0,6);
    if ($primeras6=='Ciudad') {$var1='Ciudad Caracas'; 
                               $var2=substr($varcomenta,22,2).substr($varcomenta,25,2).substr($varcomenta,28,4); 
                               $var3=substr($varcomenta,39,2);
                               $vname='mar_'.$var1.'_'.$var2.'_'.trim($var3).'.pdf';
    }
    if ($primeras6=='Ultima') {$var1='Ultimas Noticias'; 
                               $var2=substr($varcomenta,24,2).substr($varcomenta,27,2).substr($varcomenta,30,4); 
                               $var3=substr($varcomenta,41,2);
                               $vname='mar_'.$var1.'_'.$var2.'_'.trim($var3).'.pdf';
    }
    if ($primeras6=='Diario') {$var1='Diario Vea'; 
                               $var2=substr($varcomenta,18,2).substr($varcomenta,21,2).substr($varcomenta,24,4); 
                               $var3=substr($varcomenta,35,2);
                               $vname='mar_'.$var1.'_'.$var2.'_'.trim($var3).'.pdf';
    }
    $name33 ="../graficos/prensa/".$vname; 
    if (is_file($name33)) { $fpub_prensa33=1; } // Publicacion Prensa Defectuoso (Evento 33)
  }
  
}

// ************************************************************************************  
if ($vopc==3) {

}

// ************************************************************************************  
//Opcion Grabar...
if ($vopc==2) {
  $n_conex = $_POST['nconex'];

  //La Fecha de Hoy y Hora para la transaccion
  $fechahoy = hoy();
  $horactual= Hora();
  $varsol=$vsol1."-".sprintf("%06d",$vsol2);

  //Verificando conexion
  $sql->connection($usuario);

  if ($estatus==1120) {
    mensajenew('ERROR: Solo se puede realizar fondo a Expedientes en Estatus 8, 27, 29, 104, 300 o 305...!!!','m_exfon55.php','N');
    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
  }
  
  switch ($opcion) {
    case "Prensa":
      $evento = "1021";
      $estatus= $estatus + 1000;
      //echo "$estatus, $varsol, $vsol ";

      if ($estatus==1001) {
        if ($varsol>'2014-007441') { }
        else {
        mensajenew('ERROR: Opcion NO aplicable a este Expediente, solo se puede aplicar a solicitudes mayores a 2014-007441 en estatus 1 ...!!!','m_exfon55.php','N');
          $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();
        }   
      }

      if ($estatus==1300) {
        if ($varsol>'2014-007441') { }
        else {
        mensajenew('ERROR: Opcion NO aplicable a este Expediente, solo se puede aplicar a solicitudes mayores a 2014-007441 en estatus 300 ...!!!','m_exfon55.php','N');
          $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();
        }   
      }

      //if ($estatus!=1001) {
      //  mensajenew('ERROR: Opcion NO aplicable a este Expediente, solo se puede aplicar a solicitudes mayores a 2014-007441 en estatus 1 ...!!!','m_exfon55.php','N');
      //  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
      //}
      
      if (($estatus==1001) || ($estatus==1300)) { 
         //Estatus correctos
      } else {
         //mensajenew('ERROR: Solo Aplica a Solicitudes que tengan Estatus: 1 ...!!!','m_exfon55.php','N');
         mensajenew('ERROR: Opcion NO aplicable a este Expediente, solo se puede aplicar a solicitudes mayores a 2014-007441 en estatus 1 o 300 ...!!!','m_exfon55.php','N');
	      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
      }
      if ($fevento=='') {
        mensajenew('ERROR: DATOS INCORRECTOS O VACIOS ...!!!','javascript:history.back();','N');
	     $smarty->display('pie_pag.tpl'); exit();  
      }
      $esmayor=compara_fechas($fevento,$fechahoy);
      if ($esmayor==1) {
         mensajenew('ERROR: No se puede cargar un Evento a futuro ...!!!','javascript:history.back();','N');
         $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
      }
      $esmayor=compara_fechas($fecha_solic,$fevento);
      if ($esmayor==1) {
         mensajenew('ERROR: No se puede cargar un Evento previo a la fecha de la Solicitud ...!!!','javascript:history.back();','N');
         $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
      }

      // Obtencion de la Descripcion del Evento
      $nombeven='';
      $obj_query = $sql->query("SELECT * FROM $tbname_12 WHERE evento ='$evento'");
      $obj_filas = $sql->nums('',$obj_query);
      if ($obj_filas!=0) {
        $objs = $sql->objects('',$obj_query);
        $nombeven = trim($objs->mensa_automatico); }

      pg_exec("BEGIN WORK");
      pg_exec("LOCK TABLE stzderec IN SHARE ROW EXCLUSIVE MODE");
      //Validacion adiconal por si acaso otro usuario cambia la solicitud
      $resulsol=pg_exec("SELECT * FROM stzderec WHERE nro_derecho='$vder' AND tipo_mp='M'");
      $regsol = pg_fetch_array($resulsol);
      $vest   = $regsol[estatus];
      if (($vest==1001) || ($vest==1300)) { //Esta bien
      } else {
         Mensajenew('ERROR: La solicitud ha sido modificada por otro usuario','m_exfon55.php','N');
	      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
      }

      $vestfin = 1002;
      $actprim = true;
      $instram = true;
      $insexam = true;
      // Actualizar Maestra principal e insertar en Tramite 
      $update_str="estatus='$vestfin'";
      $actprim = $sql->update("stzderec","$update_str","nro_derecho='$vder'");     
            
      $insert_campos="nro_derecho,evento,fecha_event,secuencial,estat_ant,documento,fecha_trans,usuario,desc_evento,hora";
      $insert_valores ="'$vder',$evento,'$fevento4',nextval('stzevtrd_secuencial_seq'),'$estatus',0,'$fechahoy','$usuario','$nombeven','$horactual'";
      $instram = $sql->insert("stzevtrd","$insert_campos","$insert_valores","");	 

      $insert_campos="nro_derecho,solicitud,evento,fecha_trans,hora,usuario";
      //$insert_valores ="'$vder','$varsol','1051','$fechahoy','$horactual','$usuario'";
      //$insexam = $sql->insert("stmforfon","$insert_campos","$insert_valores","");	 

      // Verificacion y actualizacion real de los Datos en BD 
      if ($actprim and $instram and $insexam) {
        pg_exec("COMMIT WORK");
        //Desconexion de la Base de Datos
        $sql->disconnect();
   
        Mensajenew("DATOS GUARDADOS CORRECTAMENTE...!","m_exfon55.php?nconex=$n_conex&salir=1&conx=0",'S');
        $smarty->display('pie_pag.tpl'); exit();
      }
      else {
        pg_exec("ROLLBACK WORK");
        //Desconexion de la Base de Datos
        $sql->disconnect();
        Mensajenew("ERROR: Falla de Actualizaci&oacute;n / Inserci&oacute;n de Datos en la BD ...!!!","javascript:history.back();","N");
        $smarty->display('pie_pag.tpl'); exit();
      }
      break;

    case "Conceder":
      $evento = "1051";
      $estatus= $estatus + 1000;
      //echo "$estatus, $varsol ";
      if (($estatus==1008) || ($estatus==1027) || ($estatus==1029) || ($estatus==1104) || ($estatus==1305)) { 
         //Estatus correctos
      }  else {
         mensajenew('ERROR: Solo Aplica en Solicitudes que tengan Estatus: 8, 27, 29, 104 ...!!!','m_exfon55.php','N');
	      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
      }

      if ($estatus==1300) { 
         mensajenew('ERROR: Opción NO aplicable para Solicitudes que tengan Estatus: 300 ...!!!','m_exfon55.php','N');
	      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
      }

      if ($estatus==1305) { 
        if ($vsol>'2014-007442') {
        mensajenew('ERROR: Expediente NO se puede examinar, solo menores a 2014-007441 en estatus 305 ...!!!','m_exfon55.php','N');
        $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 
      }

      //if (($estatus==1008) || ($estatus==1027) || ($estatus==1029) || ($estatus==1104) || ($estatus==1305))  {
      //  if ($varsol<'2014-007441') { }
      //  else {
      //  	 mensajenew('ERROR: Expediente NO se puede examinar, solo menores a 2014-007442 en estatus 8 ...!!!','m_exfon55.php','N');
      //    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();
      //  }   
      //}

      if ($fevento=='') {
         mensajenew('ERROR: DATOS INCORRECTOS O VACIOS ...!!!','javascript:history.back();','N');
	      $smarty->display('pie_pag.tpl'); exit();  
      }
      $esmayor=compara_fechas($fevento,$fechahoy);
      if ($esmayor==1) {
         mensajenew('ERROR: No se puede cargar un Evento a futuro ...!!!','javascript:history.back();','N');
         $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
      }
      $esmayor=compara_fechas($fecha_solic,$fevento);
      if ($esmayor==1) {
         mensajenew('ERROR: No se puede cargar un Evento previo a la fecha de la Solicitud ...!!!','javascript:history.back();','N');
         $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
      }

      // Obtencion de la Descripcion del Evento
      $nombeven='';
      $obj_query = $sql->query("SELECT * FROM $tbname_12 WHERE evento ='$evento'");
      $obj_filas = $sql->nums('',$obj_query);
      if ($obj_filas!=0) {
        $objs = $sql->objects('',$obj_query);
        $nombeven = trim($objs->mensa_automatico); }

      pg_exec("BEGIN WORK");
      pg_exec("LOCK TABLE stzderec IN SHARE ROW EXCLUSIVE MODE");
      //Validacion adiconal por si acaso otro usuario cambia la solicitud
      $resulsol=pg_exec("SELECT * FROM stzderec WHERE nro_derecho='$vder' AND tipo_mp='M'");
      $regsol = pg_fetch_array($resulsol);
      $vest   = $regsol[estatus];
      if (($vest==1008) || ($vest==1027) || ($vest==1029) || ($vest==1104) || ($vest==1305)) { //Esta bien
      } else {
         Mensajenew('ERROR: La solicitud ha sido modificada por otro usuario','m_exfon55.php','N');
	      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
      }

      $vestfin = 1101;
      $actprim = true;
      $instram = true;
      // Actualizar Maestra principal e insertar en Tramite 
      $update_str="estatus='$vestfin'";
      $actprim = $sql->update("stzderec","$update_str","nro_derecho='$vder'");     
            
      $insert_campos="nro_derecho,evento,fecha_event,secuencial,estat_ant,documento,fecha_trans,usuario,desc_evento,hora";
      $insert_valores ="'$vder',$evento,'$fevento',nextval('stzevtrd_secuencial_seq'),'$estatus',0,'$fechahoy','$usuario','$nombeven','$horactual'";
      $instram = $sql->insert("stzevtrd","$insert_campos","$insert_valores","");	 

      // Verificacion y actualizacion real de los Datos en BD 
      if ($actprim and $instram) {
        pg_exec("COMMIT WORK");
        //Desconexion de la Base de Datos
        $sql->disconnect();
   
        Mensajenew("DATOS GUARDADOS CORRECTAMENTE...!","m_exfon55.php?nconex=$n_conex&salir=1&conx=0",'S');
        $smarty->display('pie_pag.tpl'); exit();
      }
      else {
        pg_exec("ROLLBACK WORK");
        //Desconexion de la Base de Datos
        $sql->disconnect();

        if (!$actprim) { $error_pri  = " - Maestra Principal"; } 
        if (!$instram) { $error_tra  = " - Tr&aacute;mite "; }
        Mensajenew("ERROR: Falla de Actualizaci&oacute;n / Inserci&oacute;n de Datos en la BD $error_pri $error_tra  ...!!!","javascript:history.back();","N");
        $smarty->display('pie_pag.tpl'); exit();
      }
      break;

    case "Devolver":
      $evento = "1500"; 
      $estatus= $estatus + 1000;
      if ((($estatus==1008) OR ($estatus==1104)) && ($vsol<='2014-007441')) { }
      else {
        mensajenew('ERROR: Expediente NO se puede examinar, solo menores a 2014-007442 en estatus 8 o 104 ...!!!','m_exfon55.php','N');
        $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
      }
      
      if($vcausa1 =='on'){$vc1 ='X';};if($vcausa2 =='on'){$vc2 ='X';};if($vcausa3 =='on'){$vc3 ='X';}
      if($vcausa4 =='on'){$vc4 ='X';};if($vcausa5 =='on'){$vc5 ='X';};if($vcausa6 =='on'){$vc6 ='X';}
      if($vcausa7 =='on'){$vc7 ='X';};if($vcausa8 =='on'){$vc8 ='X';};if($vcausa9 =='on'){$vc9 ='X';}
      if($vcausa10=='on'){$vc10='X';};if($vcausa11=='on'){$vc11='X';};if($vcausa12=='on'){$vc12='X';}
      if($vcausa13=='on'){$vc13='X';};if($vcausa14=='on'){$vc14='X';};if($vcausa15=='on'){$vc15='X';}
      if($vcausa16=='on'){$vc16='X';};if($vcausa17=='on'){$vc17='X';};if($vcausa18=='on'){$vc18='X';}
      if($vcausa19=='on'){$vc19='X';};if($vcausa20=='on'){$vc20='X';};if($vcausa21=='on'){$vc21='X';}
      if($vcausa22=='on'){$vc22='X';};if($vcausa23=='on'){$vc23='X';};if($vcausa24=='on'){$vc24='X';}
      if($vcausa25=='on'){$vc25='X';}

      $allcausas = $vc1.$vc2.$vc3.$vc4.$vc5.$vc6.$vc7.$vc8.$vc9.$vc10.$vc11.$vc12.$vc13.$vc14.
                   $vc15.$vc16.$vc17.$vc18.$vc19.$vc20.$vc21.$vc22.$vc23.$vc24.$vc25.$votro;
      if ($fevento1=='' || $allcausas=='') {
        mensajenew('ERROR AL INTENTAR GRABAR - DATOS INCORRECTOS','javascript:history.back();','N');
	     $smarty->display('pie_pag.tpl'); exit();  
      }

      $esmayor=compara_fechas($fevento1,$fechahoy);
      if ($esmayor==1) {
         mensajenew('ERROR: No se puede cargar un Evento a futuro ...!!!','javascript:history.back();','N');
         $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
      }
      $esmayor=compara_fechas($fecha_solic,$fevento1);
      if ($esmayor==1) {
         mensajenew('ERROR: No se puede cargar un Evento previo a la fecha de la Solicitud ...!!!','javascript:history.back();','N');
         $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
      }

      pg_exec("LOCK TABLE stzderec IN SHARE ROW EXCLUSIVE MODE");
      //Validacion adiconal por si acaso otro usuario cambia la solicitud
      $resulsol=pg_exec("SELECT * FROM stzderec WHERE nro_derecho='$vder' AND tipo_mp='M'");
      $regsol = pg_fetch_array($resulsol);
      $vest   = $regsol[estatus];
      if (($vest==1008) OR ($vest==1104)) { //Esta bien 
      } else {
         mensajenew('ERROR: La solicitud ha sido modificada por otro usuario o no esta en el estatus adecuado ...!!!','m_exfon55.php','N');
	      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
      }
      // Evento Cableado (500) se presume que los estatus finales son:
      if ($vest ==1103) {$vestfin =1116; $vtipdev='2'; $vdese='SOLICITUD EN EXAMEN DE FONDO';}
      if ($vest ==1123) {$vestfin =1117; $vtipdev='2'; $vdese='SOLICITUD EN EXAMEN DE FONDO';}
      if ($vest ==1008) {$vestfin =1116; $vtipdev='2'; $vdese='SOLICITUD EN EXAMEN DE FONDO';}
      if ($vest ==1104) {$vestfin =1116; $vtipdev='2'; $vdese='SOLICITUD EN EXAMEN DE FONDO';}

      //if ($vest-1000==8) {$vestfin = 116; $vtipdev='2'; $vdese='SOLICITUD EN EXAMEN DE FONDO';}

      pg_exec("BEGIN WORK");
      // Inserta en Stzcaded
      $ins_de=true;
      $inscaus = 0;
      $col_campos = "nro_derecho,cod_causa,derecho,grupo,tipo_dev,fecha_dev,hora";
      if ($vcausa1 =='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$vder',1,'M','M','D','$fechahoy','$horactual'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa2 =='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$vder',2,'M','M','D','$fechahoy','$horactual'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa3 =='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$vder',3,'M','M','D','$fechahoy','$horactual'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa4 =='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$vder',4,'M','M','D','$fechahoy','$horactual'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa5 =='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$vder',5,'M','M','D','$fechahoy','$horactual'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa6 =='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$vder',6,'M','M','D','$fechahoy','$horactual'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa7 =='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$vder',7,'M','M','D','$fechahoy','$horactual'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa8 =='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$vder',8,'M','M','D','$fechahoy','$horactual'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa9 =='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$vder',9,'M','M','D','$fechahoy','$horactual'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa10=='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$vder',10,'M','M','D','$fechahoy','$horactual'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa11=='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$vder',11,'M','M','D','$fechahoy','$horactual'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa12=='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$vder',12,'M','M','D','$fechahoy','$horactual'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa13=='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$vder',13,'M','M','D','$fechahoy','$horactual'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa14=='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$vder',14,'M','M','D','$fechahoy','$horactual'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa15=='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$vder',15,'M','M','D','$fechahoy','$horactual'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa16=='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$vder',16,'M','M','D','$fechahoy','$horactual'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa17=='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$vder',17,'M','M','D','$fechahoy','$horactual'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa18=='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$vder',18,'M','M','D','$fechahoy','$horactual'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa19=='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$vder',19,'M','M','D','$fechahoy','$horactual'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa20=='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$vder',20,'M','M','D','$fechahoy','$horactual'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      //if ($vcausa21=='on') {
      //  $ins_de=$sql->insert("stzcaded","$col_campos","'$vder',21,'M','M','D','$fechahoy','$horactual'","");
      //  if (!$ins_de) { $inscaus = $inscaus + 1; } }
      //if ($vcausa22=='on') {
      //  $ins_de=$sql->insert("stzcaded","$col_campos","'$vder',22,'M','M','D','$fechahoy','$horactual'","");
      //  if (!$ins_de) { $inscaus = $inscaus + 1; } }
      //if ($vcausa23=='on') {
      //  $ins_de=$sql->insert("stzcaded","$col_campos","'$vder',23,'M','M','D','$fechahoy','$horactual'","");
      //  if (!$ins_de) { $inscaus = $inscaus + 1; } }
      //if ($vcausa24=='on') {
      //  $ins_de=$sql->insert("stzcaded","$col_campos","'$vder',24,'M','M','D','$fechahoy','$horactual'","");
      //  if (!$ins_de) { $inscaus = $inscaus + 1; } }
      //if ($vcausa25=='on') {
      //  $ins_de=$sql->insert("stzcaded","$col_campos","'$vder',25,'M','M','D','$fechahoy','$horactual'","");
      //  if (!$ins_de) { $inscaus = $inscaus + 1; } }

      $votro = trim($votro);
      if ($votro<>'') {
        $col_campos = "nro_derecho,otros,derecho,grupo,tipo_dev,fecha_dev,hora";
        $ins_otros = $sql->insert("stzotrde","$col_campos","'$vder','$votro','M','M','D','$fechahoy','$horactual'",""); 
        if (!$ins_otros) { $inscaus = $inscaus + 1; } }

      // Actualizar Stzderec
      $update_str="estatus='$vestfin'";
      $ins_otros = $sql->update("stzderec","$update_str","nro_derecho='$vder'");    
      if (!$ins_otros) { $inscaus = $inscaus + 1; }             
      $vdese = "DEVUELTA POR EXAMEN DE FONDO";
      // Insertar en Stzevtrd 
      //Carga del Evento 71 
      $insert_campos="nro_derecho,evento,fecha_event,estat_ant,documento,fecha_trans,usuario,desc_evento,hora";
      $insert_valores ="$vder,1071,'$fevento1','$vest',0,'$fechahoy','$usuario','$vdese','$horactual'";
      $ins_otros = $sql->insert("stzevtrd","$insert_campos","$insert_valores","");	 
      if (!$ins_otros) { $inscaus = $inscaus + 1; }
      
      $vdese = "OFICIO DE DEVOLUCION";
      //Carga del Evento 500    
      $insert_campos="nro_derecho,evento,fecha_event,estat_ant,documento,fecha_trans,usuario,desc_evento,hora";
      $insert_valores ="$vder,1500,'$fevento1','$vest',0,'$fechahoy','$usuario','$vdese','$horactual'";
      $ins_otros = $sql->insert("stzevtrd","$insert_campos","$insert_valores","");	 
      if (!$ins_otros) { $inscaus = $inscaus + 1; }

      if ($inscaus==0) { 
        pg_exec("COMMIT WORK"); $sql->disconnect(); 
        mensajenew('DATOS GUARDADOS CORRECTAMENTE !!!','m_exfon55.php','S');
        $smarty->display('pie_pag.tpl'); exit();   
      }
      else {
        pg_exec("ROLLBACK WORK"); $sql->disconnect();
        mensajenew("ERROR: Falla de Ingreso de Datos en la BD, Transacciones Abortadas ...!!!","javascript:history.back();","N");
        $smarty->display('pie_pag.tpl'); exit();    
      }
      break;
    case "Negar":
      $evento = "1225";
      $estatus= $estatus + 1000;
      //echo "$estatus, $varsol ";
      //Validacion de Nuevo Procedimiento Forma/Fondo       
      //if ($estatus==1008) {
      //  if ($varsol<'2014-007441') { }
      //  else {
      //  	 mensajenew('ERROR: Expediente NO se puede examinar, solo menores a 2014-007442 en estatus 8 ...!!!','m_exfon55.php','N');
      //    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();
      //  }   
      //}

      //Cambio realizado Miercoles 29/03/2017
      //Validacion Forma-Fondo 
      //if ($estatus==1001) {
      //  if ($varsol>'2014-007441') { }
      //  else {
      //  mensajenew('ERROR: Opcion NO aplicable a este Expediente, solo se puede aplicar a solicitudes mayores a 2014-007441 en estatus 1 ...!!!','m_exfon55.php','N');
      //    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();
      //  }   
      //}

      // Validaciones
      if ($vart=='') {
        $sql->disconnect();
        mensajenew('ERROR: PROBLEMA AL INTENTAR GRABAR: - DATOS INCORRECTOS O VACIOS ...!!!','m_exfon55.php','N');
	     $smarty->display('pie_pag.tpl'); exit();  
      }
      
      //Validacion adiconal por si acaso otro usuario cambia la solicitud
      $resulsol=pg_exec("SELECT * FROM stzderec WHERE nro_derecho='$vder'");
      $regsol = pg_fetch_array($resulsol);
      $vest   = $regsol[estatus];
      $vfecsol= $regsol[fecha_solic];
      if ($vest==1001 || $vest==1008 || $vest==1027 || $vest==1029 || $vest==1104 || $vest==1129 || $vest==1300 || $vest==1305) { //Esta bien
      } else {
         $sql->disconnect();
         mensajenew('ERROR: PROBLEMA AL INTENTAR GRABAR: - La Solicitud ha sido Modificada por otro Usuario ...!!!','m_exfon55.php','N');
	      $smarty->display('pie_pag.tpl'); exit(); 
      }

      if (($vreg1!='' && ($vreg1==$vreg2 || $vreg1==$vreg3 || $vreg1==$vreg4 || $vreg1==$vreg5 || $vreg1==$vreg6)) ||
      ($vreg2!='' && ($vreg2==$vreg3 || $vreg2==$vreg4 || $vreg2==$vreg5 || $vreg2==$vreg6)) ||
      ($vreg3!='' && ($vreg3==$vreg4 || $vreg3==$vreg5 || $vreg3==$vreg6)) ||
      ($vreg4!='' && ($vreg4==$vreg5 || $vreg4==$vreg6)) ||
      ($vreg5!='' && ($vreg5==$vreg6))) {
         $sql->disconnect(); 
         mensajenew('ERROR: PROBLEMA AL INTENTAR GRABAR - Existen Registros Duplicados','m_exfon55.php','N');
	      $smarty->display('pie_pag.tpl'); exit(); 
      }
      $noexiste=0;
      if ($vreg1!='') {$resul=pg_exec("SELECT * FROM stzderec WHERE registro='$vreg1' 
                                       and tipo_mp='M'");
                      $filasr=pg_numrows($resul); if ($filasr==0) {$noexiste=1;} }
      if ($vreg2!='') {$resul=pg_exec("SELECT * FROM stzderec WHERE registro='$vreg2'
                                       and tipo_mp='M'");
                      $filasr=pg_numrows($resul); if ($filasr==0) {$noexiste=1;} }
      if ($vreg3!='') {$resul=pg_exec("SELECT * FROM stzderec WHERE registro='$vreg3'
                                       and tipo_mp='M'");
                      $filasr=pg_numrows($resul); if ($filasr==0) {$noexiste=1;} }
      if ($vreg4!='') {$resul=pg_exec("SELECT * FROM stzderec WHERE registro='$vreg4'
                                       and tipo_mp='M'");
                      $filasr=pg_numrows($resul); if ($filasr==0) {$noexiste=1;} }
      if ($vreg5!='') {$resul=pg_exec("SELECT * FROM stzderec WHERE registro='$vreg5'
                                       and tipo_mp='M'");
                      $filasr=pg_numrows($resul); if ($filasr==0) {$noexiste=1;} }
      if ($vreg6!='') {$resul=pg_exec("SELECT * FROM stzderec WHERE registro='$vreg6'
                                       and tipo_mp='M'");
                      $filasr=pg_numrows($resul); if ($filasr==0) {$noexiste=1;} }
      if ($noexiste==1) {
        $smarty->display('encabezado1.tpl');
        mensajenew('ERROR AL INTENTAR GRABAR - Algún Registro no fué Encontrado','m_exfon55.php','N');
	     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();
      }

      $esmayor=compara_fechas($fevento2,$fechahoy);
      if ($esmayor==1) {
        mensajenew('ERROR: No se puede cargar Eventos a futuro ...!!!','javascript:history.back();','N');
        $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
      $esmayor=compara_fechas($fecha_solic,$fevento2);
      if ($esmayor==1) {
        mensajenew('ERROR: No se puede cargar un Evento previo a la fecha de la Solicitud ...!!!','javascript:history.back();','N');
        $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
      }
      // Evento Cableado (225) se presume que los estatus finales son:
      $vestfin =1102;
      $vdese='SOLICITUD EN EXAMEN DE FONDO - POR PUBLICAR DECISION';
      
      if (($vart=='33' && ($vlit1<1 or $vlit1>12)) || ($vart=='34' && ($vlit1<1 or $vlit1>2)) || 
          ($vlit1!='' && !strpos('3527',$vart)===false)) {
        $sql->disconnect(); 
        $smarty->display('encabezado1.tpl');
        mensajenew('ERROR: PROBLEMA AL INTENTAR GRABAR - Articulo y Literal no se corresponden','m_negacion56.php','N');
	     $smarty->display('pie_pag.tpl'); exit(); 
      }
      if ($vlit2!='' && (($vart=='33' && ($vlit2<1 or $vlit2>12)) || ($vart=='34' && ($vlit2<1 or $vlit2>2)) || 
        (!strpos('3527',$vart)===false))) {
        $sql->disconnect();
        $smarty->display('encabezado1.tpl');
        mensajenew('ERROR: PROBLEMA AL INTENTAR GRABAR - Articulo y Literal no se corresponden','m_negacion56.php','N');
	     $smarty->display('pie_pag.tpl'); exit(); 
      }	  
      if (($vart=='33' && $vlit1==11 && $vreg1=='') || ($vart=='33' && $vlit2==11 && $vreg4=='')) {
        $sql->disconnect(); 
        $smarty->display('encabezado1.tpl');
        mensajenew('ERROR: PROBLEMA AL INTENTAR GRABAR - Falta colocar el Numero de Registro para aplicar el Art.33 Num.11','m_negacion56.php','N');
	     $smarty->display('pie_pag.tpl'); exit(); 
      }

      pg_exec("BEGIN WORK");
      $sw_act=0;
      // inserta en Stzevtrd
      $insert_campos="nro_derecho,evento,fecha_event,secuencial,estat_ant,documento,fecha_trans,usuario,desc_evento,comentario,hora";
      $insert_valores ="'$vder',1225,'$fevento2',nextval('stzevtrd_secuencial_seq'),'$vest',0,'$fechahoy','$usuario','$vdese','$vcom','$horactual'";

      //$insert_campos="nro_derecho,evento,fecha_event,secuencial,estat_ant,documento,fecha_trans,usuario,desc_evento,comentario,hora";
      //$insert_valores ="'$vder',1225,'$fevento2',nextval('stzevtrd_secuencial_seq'),'$vest','0','$fechahoy','$usuario','$vdese','$vcom','$horactual'";
      //$instram = $sql->insert("stzevtrd","$insert_campos","$insert_valores","");

      $sw_ins=$sql->insert("stzevtrd","$insert_campos","$insert_valores","");	 

      if (!$sw_ins) {$sw_act=$sw_act+1;}

      // inserta en Stmliaor
      $sql->del("stmliaor","nro_derecho='$vder'");    
      $insert_campos="nro_derecho,articulo,literal,reg_base";   
      if (substr($vlit1,0,1)=='0') {$vlit1=substr($vlit1,1,1);}
      if (substr($vlit2,0,1)=='0') {$vlit2=substr($vlit2,1,1);}
      $insert_valores="'$vder','$vart','$vlit1','$vreg1'";
      $sw_ins=$sql->insert("stmliaor","$insert_campos","$insert_valores","");
      if (!$sw_ins) {$sw_act=$sw_act+1;}
      if ($vreg2!='') {
      $insert_campos="nro_derecho,articulo,literal,reg_base";
      $insert_valores="'$vder','$vart','$vlit1','$vreg2'";
      $sw_ins=$sql->insert("stmliaor","$insert_campos","$insert_valores",""); }      
      if (!$sw_ins) {$sw_act=$sw_act+1;}
      if ($vreg3!='') {
      $insert_campos="nro_derecho,articulo,literal,reg_base"; 
      $insert_valores="'$vder','$vart','$vlit1','$vreg3'";
      $sw_ins=$sql->insert("stmliaor","$insert_campos","$insert_valores",""); }
      if (!$sw_ins) {$sw_act=$sw_act+1;}
      if ($vlit2!='' && $vreg4=='') {
      $insert_campos="nro_derecho,articulo,literal,reg_base"; 
      $insert_valores="'$vder','$vart','$vlit2','$vreg4'";
      $sw_ins=$sql->insert("stmliaor","$insert_campos","$insert_valores",""); }
      if (!$sw_ins) {$sw_act=$sw_act+1;}
      if ($vlit2=='') {$vlit2=$vlit1;}      
      if ($vreg4!='') {
      $insert_campos="nro_derecho,articulo,literal,reg_base"; 
      $insert_valores="'$vder','$vart','$vlit2','$vreg4'";
      $sw_ins=$sql->insert("stmliaor","$insert_campos","$insert_valores",""); }
      if (!$sw_ins) {$sw_act=$sw_act+1;}
      if ($vreg5!='') {
      $insert_campos="nro_derecho,articulo,literal,reg_base"; 
      $insert_valores="'$vder','$vart','$vlit2','$vreg5'";
      $sw_ins=$sql->insert("stmliaor","$insert_campos","$insert_valores",""); }
      if (!$sw_ins) {$sw_act=$sw_act+1;}
      if ($vreg6!='') {
      $insert_campos="nro_derecho,articulo,literal,reg_base"; 
      $insert_valores="'$vder','$vart','$vlit2','$vreg6'";
      $sw_ins=$sql->insert("stmliaor","$insert_campos","$insert_valores",""); }
      if (!$sw_ins) {$sw_act=$sw_act+1;} 
      
      // Actualizar Stmmarce
      $update_str="estatus=1102";
      $sw_upd=$sql->update("stzderec","$update_str","nro_derecho='$vder'");    
      if (!$sw_upd) {$sw_act=$sw_act+1;} 

      //Cambio realizado Miercoles 29/03/2017
      //Validacion Forma-Fondo 
      if ($estatus==1001) {
        if ($varsol>'2014-007441') { 
          $insexam = true;
          $insert_campos="nro_derecho,solicitud,evento,fecha_trans,hora,usuario";
          $insert_valores ="'$vder','$varsol','1225','$fechahoy','$horactual','$usuario'";
          $insexam = $sql->insert("stmforfon","$insert_campos","$insert_valores","");	 
          if (!$insexam) {$sw_act=$sw_act+1;}
        }
        else {  }   
      }
      
      //Cambio realizado Miercoles 29/03/2017
      //$insexam = true;
      //if ($vest==1001) { 
      //  $insert_campos="nro_derecho,solicitud,evento,fecha_trans,hora,usuario";
      //  $insert_valores ="'$vder','$varsol','1225','$fechahoy','$horactual','$usuario'";
      //  $insexam = $sql->insert("stmforfon","$insert_campos","$insert_valores","");	 
      //  if (!$insexam) {$sw_act=$sw_act+1;}
      //}  	 
      
      // Verificacion y actualizacion real de los Datos en BD 
      if ($sw_act==0) { 
        pg_exec("COMMIT WORK"); $sql->disconnect(); 
        mensajenew('DATOS GUARDADOS CORRECTAMENTE !!!','m_exfon55.php','S');
        $smarty->display('pie_pag.tpl'); exit();   
      }
      else {
        pg_exec("ROLLBACK WORK"); $sql->disconnect();
        mensajenew("ERROR: Falla de Ingreso de Datos en la BD, Transacciones Abortadas ...!!!","javascript:history.back();","N");
        $smarty->display('pie_pag.tpl'); exit();    
      } 
      break;

    case "Detener":
      $evento = "1054";
      $estatus= $estatus + 1000;
      if ($estatus==1001  || $estatus==1008  || $estatus==1027 || $estatus==1129 || $estatus==1104 || $estatus==1300 || $estatus==1305) { 
         //Estatus correctos
      }  else {
         mensajenew('AVISO: Solo Aplica en Solicitudes que tengan Estatus: 1, 8, 27, 104, 129, 300 o 305...!!!','m_exfon55.php','N');
	      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
      }
      //Validacion de Nuevo Procedimiento Forma/Fondo  
      //if ($estatus==1008) {
      //  if ($varsol<'2014-007441') { }
      //  else {
      //  	 mensajenew('ERROR: Expediente NO se puede examinar, solo menores a 2014-007442 en estatus 8 ...!!!','m_exfon55.php','N');
      //    $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();
      //  }   
      //}

      if ($estatus==1001) {
        if ($varsol>'2014-007441') { }
        else {
        mensajenew('ERROR: Opcion NO aplicable a este Expediente, solo se puede aplicar a solicitudes mayores a 2014-007441 en estatus 1 ...!!!','m_exfon55.php','N');
          $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();
        }   
      }

      if ($estatus==1300) {
        if ($varsol>'2014-007441') { }
        else {
        mensajenew('ERROR: Opcion NO aplicable a este Expediente, solo se puede aplicar a solicitudes mayores a 2014-007441 en estatus 300 ...!!!','m_exfon55.php','N');
          $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();
        }   
      }

      $esmayor=compara_fechas($fevento3,$fechahoy);
      if ($esmayor==1) {
         mensajenew('ERROR: No se puede cargar Eventos a futuro ...!!!','javascript:history.back();','N');
         $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
      }
      $esmayor=compara_fechas($fecha_solic,$fevento3);
      if ($esmayor==1) {
         mensajenew('ERROR: No se puede cargar un Evento previo a la fecha de la Solicitud ...!!!','javascript:history.back();','N');
         $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
      }
      $comenta2 = trim($comenta2);
      if (empty($comenta2)) {
         mensajenew('ERROR: No ingres&oacute; el comentario de la Detenci&oacute;n ...!!!','javascript:history.back();','N');
         $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
      }
      // Obtencion de la Descripcion del Evento
      $nombeven='';
      $obj_query = $sql->query("SELECT * FROM $tbname_12 WHERE evento ='$evento'");
      $obj_filas = $sql->nums('',$obj_query);
      if ($obj_filas!=0) {
        $objs = $sql->objects('',$obj_query);
        $nombeven = trim($objs->mensa_automatico); }

      pg_exec("BEGIN WORK");
      pg_exec("LOCK TABLE stzderec IN SHARE ROW EXCLUSIVE MODE");
      //Validacion adiconal por si acaso otro usuario cambia la solicitud
      $resulsol=pg_exec("SELECT * FROM stzderec WHERE nro_derecho='$vder' AND tipo_mp='M'");
      $regsol = pg_fetch_array($resulsol);
      $vest   = $regsol[estatus];
      $vfecsol= $regsol[fecha_solic];
      if ($vest==1001 || $vest==1008 || $vest==1027 || $vest==1129 || $vest==1104 || $vest==1300 || $vest==1305) { //Esta bien
      } else {
         Mensajenew('ERROR: La solicitud ha sido modificada por otro usuario ...!!!','m_exfon55.php','N');
	      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
      }
      // Evento Cableado (54) se presume que los estatus finales son:
      $vestfin = 1104;
      $actprim = true;
      $instram = true;
      $insexam = true;
      $insdete = true;
      //$vdese='SOLICITUD EN EXAMEN DE FONDO - POR PUBLICAR DECISION';

      if ($estatus==1008  || $estatus==1027 || $estatus==1129 || $estatus==1104 || $estatus==1305) { 
        // Actualizar Maestra principal e insertar en Tramite 
        $update_str="estatus='$vestfin'";
        $actprim = $sql->update("stzderec","$update_str","nro_derecho='$vder'");     
            
        $insert_campos="nro_derecho,evento,fecha_event,secuencial,estat_ant,documento,fecha_trans,usuario,desc_evento,comentario,hora";
        $insert_valores ="'$vder',$evento,'$fevento3',nextval('stzevtrd_secuencial_seq'),'$vest',0,'$fechahoy','$usuario','$nombeven','$comenta2','$horactual'";
        $instram = $sql->insert("stzevtrd","$insert_campos","$insert_valores","");
      }  	 

      if ($estatus==1001) { 
        $vestfin = 1002;
        $evento  = "1021";
        // Obtencion de la Descripcion del Evento de Publicacion en Prensa 
        $nombeven='';
        $obj_query = $sql->query("SELECT * FROM $tbname_12 WHERE evento ='$evento'");
        $obj_filas = $sql->nums('',$obj_query);
        if ($obj_filas!=0) {
          $objs = $sql->objects('',$obj_query);
          $nombeven = trim($objs->mensa_automatico); }

        // Actualizar Maestra principal e insertar en Tramite 
        $update_str="estatus='$vestfin'";
        $actprim = $sql->update("stzderec","$update_str","nro_derecho='$vder'");     
            
        $insert_campos="nro_derecho,evento,fecha_event,secuencial,estat_ant,documento,fecha_trans,usuario,desc_evento,hora";
        $insert_valores ="'$vder',$evento,'$fevento3',nextval('stzevtrd_secuencial_seq'),'$estatus',0,'$fechahoy','$usuario','$nombeven','$horactual'";
        $instram = $sql->insert("stzevtrd","$insert_campos","$insert_valores","");	 

        $insert_campos="nro_derecho,solicitud,evento,fecha_trans,hora,usuario";
        $insert_valores ="'$vder','$varsol','1054','$fechahoy','$horactual','$usuario'";
        //$insexam = $sql->insert("stmforfon","$insert_campos","$insert_valores","");	 

        $insert_campos="nro_derecho,solicitud,evento,fecha_trans,hora,usuario,comentario";
        $insert_valores ="'$vder','$varsol','1054','$fechahoy','$horactual','$usuario','$comenta2'";
        //$insdete = $sql->insert("stmdtforfon","$insert_campos","$insert_valores","");
      }  	 

      if ($estatus==1300) { 
        $vestfin = 1002;
        $evento  = "1021";
        // Obtencion de la Descripcion del Evento de Publicacion en Prensa 
        $nombeven='';
        $obj_query = $sql->query("SELECT * FROM $tbname_12 WHERE evento ='$evento'");
        $obj_filas = $sql->nums('',$obj_query);
        if ($obj_filas!=0) {
          $objs = $sql->objects('',$obj_query);
          $nombeven = trim($objs->mensa_automatico); }

        // Actualizar Maestra principal e insertar en Tramite 
        $update_str="estatus='$vestfin'";
        $actprim = $sql->update("stzderec","$update_str","nro_derecho='$vder'");     
            
        $insert_campos="nro_derecho,evento,fecha_event,secuencial,estat_ant,documento,fecha_trans,usuario,desc_evento,hora";
        $insert_valores ="'$vder',$evento,'$fevento3',nextval('stzevtrd_secuencial_seq'),'$estatus',0,'$fechahoy','$usuario','$nombeven','$horactual'";
        $instram = $sql->insert("stzevtrd","$insert_campos","$insert_valores","");	 

        $insert_campos="nro_derecho,solicitud,evento,fecha_trans,hora,usuario";
        $insert_valores ="'$vder','$varsol','1054','$fechahoy','$horactual','$usuario'";
        //$insexam = $sql->insert("stmforfon","$insert_campos","$insert_valores","");	 

        $insert_campos="nro_derecho,solicitud,evento,fecha_trans,hora,usuario,comentario";
        $insert_valores ="'$vder','$varsol','1054','$fechahoy','$horactual','$usuario','$comenta2'";
        //$insdete = $sql->insert("stmdtforfon","$insert_campos","$insert_valores","");
      }  	 

      // Verificacion y actualizacion real de los Datos en BD 
      if ($actprim AND $instram AND $insexam AND $insdete) {
        pg_exec("COMMIT WORK");
        //Desconexion de la Base de Datos
        $sql->disconnect();
   
        Mensajenew("DATOS GUARDADOS CORRECTAMENTE...!","m_exfon55.php?nconex=$n_conex&salir=1&conx=0",'S');
        $smarty->display('pie_pag.tpl'); exit();
      }
      else {
        pg_exec("ROLLBACK WORK");
        //Desconexion de la Base de Datos
        $sql->disconnect();

        if (!$actprim) { $error_pri  = " - Maestra Principal"; } 
        if (!$instram) { $error_tra  = " - Tr&aacute;mite "; }
        Mensajenew("ERROR: Falla de Actualizaci&oacute;n / Inserci&oacute;n de Datos en la BD $error_pri $error_tra  ...!!!","javascript:history.back();","N");
        $smarty->display('pie_pag.tpl'); exit();
      }
      break;
  }
  //Mensaje("DATOS GUARDADOS CORRECTAMENTE...!","m_exfondo.php?nconex=$n_conex&salir=1&conx=0");
  //$smarty->display('pie_pag.tpl'); exit(); 
}

if (($vopc!=1) && ($vopc!=2)) {
  $nameimage="../imagenes/sin_imagen8.png";
  $smarty->assign('nameimage',$nameimage);
  $smarty->assign('vmodo','disabled'); 
  $smarty->assign('modo','disabled'); 
  $smarty->assign('varfocus','formarcas1.vsol1'); 
}

$smarty->assign('varfocus','formarcas1.vsol1'); 
//Pase de variables y Etiquetas al template
$smarty->assign('campo1','Expediente No.:');
$smarty->assign('campo2','de Fecha:');
$smarty->assign('campo3','Tipo de Marca:');
$smarty->assign('campo4','Nombre:');
$smarty->assign('campo5','Clase:');
$smarty->assign('campo6','Modalidad:');
$smarty->assign('campo7','Pais de Residencia:');
$smarty->assign('campo8','Logotipo:');
$smarty->assign('campo9','Tramitante/Apoderado(s):');
$smarty->assign('campo10','Poder:');
$smarty->assign('campo11','Agente(s):');
$smarty->assign('campo12','Lema Aplicado a:');
$smarty->assign('campo13','Titular:');
$smarty->assign('campo14','Evento:');
$smarty->assign('campo15','Fecha de Evento:');
$smarty->assign('campo16','Estatus:');

$smarty->assign('campo17','Prioridad:');
$smarty->assign('campo18','Recaudos:');
$smarty->assign('campo19','Otros:');

//$smarty->assign('uno','01'); 
//$smarty->assign('dos','02'); 
//$smarty->assign('tres','03'); 
//$smarty->assign('cuatro','04'); 
//$smarty->assign('cinco','05'); 
//$smarty->assign('seis','06'); 
//$smarty->assign('siete','07'); 
//$smarty->assign('ocho','08'); 
//$smarty->assign('nueve','09'); 
//$smarty->assign('diez','10'); 
//$smarty->assign('once','11'); 
//$smarty->assign('doce','12'); 
//$smarty->assign('trece','13'); 
//$smarty->assign('catorce','14'); 
//$smarty->assign('quince','15'); 
//$smarty->assign('dieciseis','16');
//$smarty->assign('diecisiete','17');
$smarty->assign('lotro','Otro:'); 

//Descripción de causales para Devolución por fondo
//$smarty->assign('lcausadev','Causales de Devolución - Examen de Fondo:'); 
//$smarty->assign('luno',    'Identificaci&oacute;n del Peticionario o Tramitante'); 
//$smarty->assign('ldos',    'Indicar productos/servicios de la Clase'); 
//$smarty->assign('ltres',   'Anexar copia certif. Documento de la Sociedad'); 
//$smarty->assign('lcuatro', 'Anexar copia certif. Acta Asamblea Sociedad'); 
//$smarty->assign('lcinco',  'Anexar Instrum. Poder que acredite represent.'); 
//$smarty->assign('lseis',   'Anexar copia Solicitud/Registro en otro pa&iacute;s'); 
//$smarty->assign('lsiete',  'Traducir al Castellano'); 
//$smarty->assign('locho',   'Indicar correctamente la Clase Internacional'); 
//$smarty->assign('lnueve',  'Delimitar Productos/Actividades que distingue'); 
//$smarty->assign('ldiez',   'Anexar 5 Fascimiles que no excedan de 5x5cms'); 
//$smarty->assign('lonce',   'Eliminar de la Marca las leyendas gen&eacute;ricas'); 
//$smarty->assign('ldoce',   'Efectuar descripci&oacute;n detallada de la Etiqueta'); 
//$smarty->assign('ltrece',  'Indicar tipo de Marca:Producto,Servicio,Nombre,Lema'); 
//$smarty->assign('lcatorce','Excluir Productos/Servicios q no son de la Clase'); 
//$smarty->assign('lquince', 'Indicar la Marca a la cual se aplicara el Lema');
//$smarty->assign('ldieciseis', 'Falta la Firma del Solicitante');
//$smarty->assign('ldiecisiete', 'Anexar lista de productos no mencionados en Planilla');

$smarty ->assign('causa1',$vcausa1); 
$smarty ->assign('causa2',$vcausa2); 
$smarty ->assign('causa3',$vcausa3); 
$smarty ->assign('causa4',$vcausa4); 
$smarty ->assign('causa5',$vcausa5); 
$smarty ->assign('causa6',$vcausa6); 
$smarty ->assign('causa7',$vcausa7); 
$smarty ->assign('causa8',$vcausa8); 
$smarty ->assign('causa9',$vcausa9); 
$smarty ->assign('causa10',$vcausa10); 
$smarty ->assign('causa11',$vcausa11); 
$smarty ->assign('causa12',$vcausa12); 
$smarty ->assign('causa13',$vcausa13); 
$smarty ->assign('causa14',$vcausa14); 
$smarty ->assign('causa15',$vcausa15); 
$smarty ->assign('causa16',$vcausa16); 
$smarty ->assign('causa17',$vcausa17);
$smarty ->assign('causa18',$vcausa18); 
$smarty ->assign('causa19',$vcausa19); 
$smarty ->assign('causa20',$vcausa20); 
$smarty ->assign('causa21',$vcausa21); 
$smarty ->assign('causa22',$vcausa22); 
$smarty ->assign('causa23',$vcausa23); 
$smarty ->assign('causa24',$vcausa24); 
$smarty ->assign('causa25',$vcausa25); 
$smarty ->assign('codcausa',$vcodcausa);
$smarty ->assign('descausa',$vdescausa); 

$smarty->assign('lart','Articulo:'); 
$smarty->assign('llit','Literal:'); 
$smarty->assign('lreg','Registro:'); 
$smarty->assign('lsol','Solicitud:'); 
$smarty->assign('lcomentario','Comentario:'); 

$smarty->assign('vder',$vder); 
$smarty->assign('usuario',$usuario);
$smarty->assign('vnomage',$vnomage);
$smarty->assign('vcodage',$vcodage);
$smarty->assign('vcodpais',$vcodpais);
$smarty->assign('nameimage',$nameimage);
$smarty->assign('vsol1',$vsol1);
$smarty->assign('vsol2',$vsol2);
$smarty->assign('varsol',$varsol);
$smarty->assign('nombre',$nombre);
$smarty->assign('indclase',$indclase);
$smarty->assign('vclase',$vclase);
$smarty->assign('agen_id',$vcodage);
$smarty->assign('nagente',$nagente);
$smarty->assign('vcodpais',$vcodpais);
$smarty->assign('pais_resid',$pais_resid);
$smarty->assign('tramitante',$tramitante);
$smarty->assign('tramitante',$tram);
$smarty->assign('fecha_solic',$fecha_solic);
$smarty->assign('distingue',$distingue);
$smarty->assign('etiqueta',$etiqueta);
$smarty->assign('vpod1',$vpod1);
$smarty->assign('vpod2',$vpod2);
$smarty->assign('vopc',$vopc);
$smarty->assign('modalidad',$modalidad);
$smarty->assign('modal',$modal);
$smarty->assign('tipo_marca',$tipo_marca);
$smarty->assign('tipomarca',$tipomarca);
$smarty->assign('estatus',$estatus-1000);
$smarty->assign('fevento',$fevento);
$smarty->assign('fevento1',$fevento1);
$smarty->assign('fevento2',$fevento2);
$smarty->assign('fevento3',$fevento3);
$smarty->assign('fevento4',$fevento4);
$smarty->assign('nombest',$nombest);
$smarty->assign('comenta2',$comenta2);

$smarty ->assign('varsol1',$varsol1);
$smarty ->assign('varsol2',$varsol2);

$smarty->assign('name22',$name22);
$smarty->assign('name32',$name32);
$smarty->assign('name33',$name33);   
$smarty->assign('fpub_prensa22',$fpub_prensa22);
$smarty->assign('fpub_prensa32',$fpub_prensa32);
$smarty->assign('fpub_prensa33',$fpub_prensa33);
$smarty->assign('fplanilla',$fplanilla);
$smarty->assign('ffonetica',$ffonetica);
$smarty->assign('fcedula',$fcedula);
$smarty->assign('fpoder',$fpoder);
$smarty->assign('freglamento',$freglamento);
$smarty->assign('fprioridad',$fprioridad);
$smarty->assign('fcronologia',1);
$smarty->assign('fgrafica',$fgrafica);
$smarty->assign('frif',$frif);
$smarty->assign('fmercantil',$fmercantil);
$smarty->assign('fasamblea',$fasamblea);
$smarty->assign('fotros',$fotros);
$smarty->assign('ftasa',$ftasa);
$smarty->assign('fescritos',$fescritos);
$smarty->assign('fcertificado',$fcertificado);


$smarty->display('m_exfon55.tpl');
$smarty->display('pie_pag.tpl');
?>
