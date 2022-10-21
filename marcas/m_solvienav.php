<script language="Javascript"> 

function gestionvienap(var1,var3,var4) {
  open("adm_bviena.php?vsol="+var1.value+"&vtex="+var3.value+"&vmod="+var4.value,"Ventana", "scrollbars=yes,toolbar=no,directories=no,menubar=no,status=no"); }

</script>

<?php
// *************************************************************************************
// Programa: m_solviena.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MILCO
// Año: 2006
// Modificado I Semestre 2009 - BD.Relacional por Maryury Bonilla el 20/05/2009, 9:30AM 
// *************************************************************************************

//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }
?>
<script language="Javascript"> 

function pregunta() { 
  return confirm('Estas seguro de grabar la Informacion ?'); }

</script>

<?php
//Variables
$usuario = $_SESSION['usuario_login'];
//$role = $_SESSION['usuario_rol'];
$sql  = new mod_db();
$tbname_1 = "stmmarce";
$tbname_2 = "stzderec";
$tbname_3 = "stmviena";
$tbname_4 = "stzagenr";
$tbname_5 = "stmccvma";
$tbname_6 = "stmlogos";
$tbname_7 = "stmverif";
$tbname_8 = "stzstder";
$tbname_9 = "stmtmpcvs";

$fecha    = fechahoy();
	
$vopc     = $_GET['vopc'];
$vsol1    = $_POST['vsol1'];
$vsol2    = $_POST['vsol2'];
$vsol     = $_POST['vsol'];
$vest     = $_POST['vest'];
$modal_id = $_POST['modal_id'];
$vcomenta = $_POST['vcomenta'];
$estatus_id = $_POST['estatus_id'];
$nameimage  = $_POST['nameimage'];
$accion   = $_POST['accion'];
$vstring2 = $_POST['vstring2'];
$etiqueta = $_POST['etiqueta'];
$vexist   = $_POST['vexist'];

$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Clasificaci&oacute;n de Solicitud seg&uacute;n Viena');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Submit cuando vopc es diferente de 1 y 2 y cuando pasa la primera vez  
//$smarty ->assign('submitbutton','submit'); 
$smarty ->assign('varfocus','formarcas1.vsol1'); 
$smarty ->assign('vmodo',''); 

//Verificando conexion
$sql->connection($usuario);

if (!empty($vsol1) && !empty($vsol2))
{
  //Armado del Numero de Expediente
  $vsol=sprintf("%04d-%06d",$vsol1,$vsol2);
}  
$resultado=true;
$resultado1=true;

//Obtención de los Codigos de Viena
$obj_query = $sql->query("SELECT * FROM $tbname_3 ORDER BY ccv");
if (!$obj_query) { 
  Mensage_Error("Problema al intentar realizar la consulta en la tabla $tbname_3 ...!!!");
  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
  
$filas_found=$sql->nums('',$obj_query);
if ($filas_found==0) {
  Mensage_Error("Tabla de Viena vacia...!!!");
  $smarty->display('pie_pag.tpl');  $sql->disconnect(); exit(); } 

$cont = 0;
$arraycodest[$cont]=0;
$arraynombre[$cont]='';
$objs = $sql->objects('',$obj_query);
for($cont=1;$cont<=$filas_found;$cont++) { 
  $arraycodest[$cont]=$objs->ccv;
  $arraynombre[$cont]=$objs->ccv." -- ".substr($objs->descripcion,0,80);
  $objs = $sql->objects('',$obj_query);
}

if ($vopc!=1 || $vopc!=5) {
  $smarty ->assign('modo','readonly=readonly'); 
  $smarty ->assign('modo1',''); }

if ($vopc==1) {
    //$smarty ->assign('submitbutton','button'); 
    $smarty ->assign('varfocus','formarcas3.vdoc'); 
    $smarty ->assign('vmodo','readonly=readonly'); 
    $smarty ->assign('modo1','disabled'); 

    //Validacion del Numero de Solicitud
    if (empty($vsol1) && empty($vsol2)) {
      mensajenew('No introdujo ningún valor de Expediente ...!!!','m_solviena.php','N');
      $smarty->display('pie_pag.tpl'); exit(); }

    $resultado=pg_exec("SELECT * FROM $tbname_2 WHERE solicitud='$vsol' and solicitud!='' and tipo_mp='M' ");
    if (!$resultado) { 
      mensajenew('ERROR AL PROCESAR LA BUSQUEDA ...!!!','m_solviena.php','N');
      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
    }	 
    $filas_found=pg_numrows($resultado); 
    if ($filas_found==0) {
      mensajenew('NO EXISTEN DATOS ASOCIADOS ...!!!','m_solviena.php','N');
      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }	 
    
    $reg   = pg_fetch_array($resultado);
    $vsol  = $reg[solicitud];
    $vest  = $reg[estatus];
	 $vdere = $reg[nro_derecho]; 
    $vsol1 = substr($vsol,-11,4);
    $vsol2 = substr($vsol,-6,6);
    $vreg  = $reg[registro];
    $vreg1 = substr($vreg,-7,1);
    $vreg2 = substr($vreg,1);
    $vnom  = $reg[nombre];
    $vfecsol = $reg[fecha_solic];
    $vfecreg = $reg[fecha_regis];
    $vfecven = $reg[fecha_venc];
    $vcodage = $reg[agente]; 
    $vtra  = $reg[tramitante];
    $vtipo = $reg[tipo_derecho];
            
    $resultado1=pg_exec("SELECT * FROM $tbname_1 WHERE nro_derecho=$vdere");   
    if (!$resultado1) { 
      mensajenew('ERROR AL PROCESAR LA BUSQUEDA ...!!!','m_solviena.php','N');
      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
    }	 
    $filas_found=pg_numrows($resultado1); 
    if ($filas_found==0) {
      mensajenew('ERROR: NO EXISTEN DATOS ASOCIADOS ...!!!','m_solviena.php','N');
      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }	 
    $reg1 = pg_fetch_array($resultado1);    
    
    //if ($vest!=1008) {
    //  Mensajenew('ERROR EXPEDIENTE DIFERENTE A ESTATUS 8: PUBLICADA COMO SOLICITADA ...!!!','m_solviena.php','N');
    //  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
    //}	 
    
    $modal=$reg1[modalidad];
    
    if (($modal!='G') && ($modal!='M')) {
      mensajenew('SOLICITUD DEBE SER GRAFICA O MIXTA PARA CLASIFICARLA ...!!!','m_solviena.php','N');
      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
    
    $vclase = $reg1[clase];
    $vindc  = $reg1[ind_claseni];
    $modal_id = $modal;   
	 $modal  = modalida_marca($modal_id);
    $vtip   = tipo_marca($vtipo);
    $vindcla= ind_clase($vindc);    
      		
    switch ($modal_id) {
      case "G":
         $nameimage = ver_imagen($vsol1,$vsol2,"M");
         break;
      case "M":
         $nameimage = ver_imagen($vsol1,$vsol2,"M");
         break;
    }
  
  //Verificacion de que si existe la imagen en disco
  if (!file_exists($nameimage)) {
    Mensajenew("La Imagen $nameimage NO ha sido Encontrada, debe ser Scaneada para proseguir con la Verificacion ...!!!","javascript:history.back();","N");
    $smarty->display('pie_pag.tpl'); exit(); }     

    // Nombre del Agente si es el caso      
    if ($vcodage!='') {
      $resulage=pg_exec("SELECT nombre FROM $tbname_4 WHERE agente=$vcodage");
      $regage = pg_fetch_array($resulage);
      $vnomage=$regage[nombre];
      $vtra=$vcodage." - ".$vnomage;
    }
    // Descripcon del estatus 
    $resulest=pg_exec("SELECT * FROM $tbname_8 WHERE estatus='$vest' and tipo_mp='M'");
    $regest = pg_fetch_array($resulest);
    $vdesest=$regest[descripcion];
    
    // Titular Actual
    $resultit=pg_exec("SELECT a.titular,b.nombre,a.nacionalidad,a.domicilio,c.nombre as nombrep 
							FROM stzottid a, stzsolic b, stzpaisr c 
										WHERE a.nro_derecho=$vdere and a.titular=b.titular and a.nacionalidad=c.pais");
    $regtit = pg_fetch_array($resultit);
    $vcodtit=$regtit[titular];
    $vnomtit=$regtit[nombre];
    $vnactit=$regtit[nacionalidad];
    $vnadtit=$regtit[nombrep];
    $vdomtit=$regtit[domicilio];

    $resulpoh=pg_exec("SELECT a.ccv,b.descripcion FROM stmccvma a,stmviena b WHERE a.nro_derecho=$vdere and a.ccv=b.ccv"); 
    $regpoh = pg_fetch_array($resulpoh);
    $filaspoh=pg_numrows($resulpoh);
    // se elimina cualquier ocurrencia en la tabla tmpccvso
    pg_exec("BEGIN WORK");
    pg_exec("LOCK TABLE stmtmpcvs IN SHARE ROW EXCLUSIVE MODE");
    $sql->del("$tbname_9","solicitud='$vsol'");
    for($cont=0;$cont<$filaspoh;$cont++) { 
      //se inserta en tabla auxiliar de viena
      $insert_valores ="'$vsol','$regpoh[ccv]'";
      $sql->insert("$tbname_9","","$insert_valores","");
      // se inicializa vector de viena
      $vpoderhab1[$cont]=$regpoh[ccv];
      if (strlen(trim($regpoh[descripcion])) > 60) {
        $vpoderhab2[$cont] = substr(trim($regpoh[descripcion]),0,60)."..."; }
      else {
        $vpoderhab2[$cont] = substr(trim($regpoh[descripcion]),0,60); }
      $regpoh = pg_fetch_array($resulpoh);
    }
    pg_exec("COMMIT WORK"); 	 
    $smarty->assign('arr_ph1',$vpoderhab1); 
    $smarty->assign('arr_ph2',$vpoderhab2); 
    $smarty->assign('vnumrows',$filaspoh);

    $etiqueta='';
    // Obtencion de la Etiqueta
    $vexist= 0;
    $obj_query = $sql->query("SELECT * FROM $tbname_6 WHERE nro_derecho=$vdere");
    $obj_filas = $sql->nums('',$obj_query);
    if ($obj_filas!=0) {
      $objs = $sql->objects('',$obj_query);
      $etiqueta = trim($objs->descripcion); 
      $vexist= 1;}
    else { $vexist= 0;}
    $smarty->assign('vstring2',$etiqueta);
    $smarty->assign('etiqueta',$etiqueta);
    $smarty->assign('vexist',$vexist);
}

   if ($vopc==4 || ($vopc==5 && $accion!='Guardar')) {
      //$smarty ->assign('submitbutton','button'); 
      $smarty ->assign('varfocus','formarcas3.etiqueta'); 
      $smarty ->assign('modo1','disabled'); 
      $smarty ->assign('vmodo','readonly=readonly'); 
      $smarty ->assign('modo',''); 
      
      // Validaciones iniciales
      $vccv=$_POST['vccv'];
      $vsol= $_GET['vsol'];
      $accion=$_POST['accion'];
      $vsol1=substr($vsol,-11,4);
      $vsol2=substr($vsol,-6,6);
      
      //Datos de la Marca
      $resultado=pg_exec("SELECT * FROM $tbname_2 WHERE solicitud='$vsol' and tipo_mp='M'");
      $filas_found=pg_numrows($resultado); 
      $reg = pg_fetch_array($resultado);      
      $vsol=$reg[solicitud];
      $vest=$reg[estatus];
      $vdere=$reg[nro_derecho];    
      $vfecsol=$reg[fecha_solic];
      $vfecreg=$reg[fecha_regis];
      $vfecven=$reg[fecha_venc];
      $vcodagen=$reg[agente];      
      $vtra=$reg[tramitante];
      $vsol1=substr($vsol,-11,4);
      $vsol2=substr($vsol,-6,6);
      $vreg=$reg[registro];
      $vreg1=substr($vreg,-7,1);
      $vreg2=substr($vreg,1);
      $vnom=$reg[nombre]; 
      $vtipo=$reg[tipo_derecho];       
    	$resultado1=pg_exec("SELECT * FROM $tbname_1 WHERE nro_derecho=$vdere");
    	if (!$resultado1) { 
      mensajenew('ERROR AL PROCESAR LA BUSQUEDA ...!!!','m_solviena.php','N');
      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
    	}	 
    	$filas_found=pg_numrows($resultado1); 
    	if ($filas_found==0) {
      mensajenew('NO EXISTEN DATOS ASOCIADOS ...!!!','m_solviena.php','N');
      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }	 
    	$reg1 = pg_fetch_array($resultado1);    
    	$modal=$reg1[modalidad];
      $vclase=$reg1[clase];
      $vindc=$reg1[ind_claseni]; 
      $modal_id=$reg1[modalidad];

		$modal= modalida_marca($modal_id);
      $vtip=tipo_marca($vtipo);
      $vindcla=ind_clase($vindc);    
      		
    switch ($modal_id) {
      case "G":
         $nameimage = ver_imagen($vsol1,$vsol2,"M");
         break;
      case "M":
         $nameimage = ver_imagen($vsol1,$vsol2,"M");
         break;
    }
 
      // Nombre del Agente si es el caso      
      if ($vcodagen!='') {
       $resulage=pg_exec("SELECT nombre FROM $tbname_4 WHERE agente=$vcodagen");
       $regagen = pg_fetch_array($resulage);
       $vnomagen=$regagen[nombre];
       $vtra=$vcodagen." - ".$vnomagen;
      }
      // Descripcon del estatus 
      $resulest=pg_exec("SELECT * FROM $tbname_8 WHERE estatus='$vest' and tipo_mp='M'");
      $regest = pg_fetch_array($resulest);
      $vdesest=$regest[descripcion];
      
      // Titular Actual
      $resultit=pg_exec("SELECT a.titular,b.nombre,a.nacionalidad,a.domicilio,c.nombre as nombrep 
							FROM stzottid a, stzsolic b, stzpaisr c 
										WHERE a.nro_derecho=$vdere and a.titular=b.titular and a.nacionalidad=c.pais");
      $regtit = pg_fetch_array($resultit);
      $vcodtit=$regtit[titular];
      $vnomtit=$regtit[nombre];
      $vnactit=$regtit[nacionalidad];
      $vnadtit=$regtit[nombrep];
      $vdomtit=$regtit[domicilio];

      $etiqueta='';
      // Obtencion de la Etiqueta
      $vexist= 0;
      $v1=substr($vsoli,-9,9);
      $obj_query = $sql->query("SELECT * FROM $tbname_6 WHERE nro_derecho=$vdere");
      $obj_filas = $sql->nums('',$obj_query);
      if ($obj_filas!=0) {
        $objs = $sql->objects('',$obj_query);
        $etiqueta = trim($objs->descripcion); 
        $vexist= 1;}
      else { $vexist= 0;}
      $smarty->assign('vstring2',$etiqueta);
      $smarty->assign('etiqueta',$etiqueta);
      $smarty->assign('vexist',$vexist);

      // Vectores de Codigos de Viena
      $obj_query = $sql->query("SELECT * FROM $tbname_3 ORDER BY ccv");
      $obj_filas = $sql->nums('',$obj_query);
      $contobj = 0;
      $vcodage[$contobj] = 0;
      $vnomage[$contobj] = '';
      $objs = $sql->objects('',$obj_query);
      for ($contobj=1;$contobj<=$obj_filas;$contobj++) {
        $vcodage[$contobj] = $objs->ccv;
        if (strlen(trim($objs->descripcion)) > 60) {
          $vnomage[$contobj] = $objs->ccv." ".substr(trim($objs->descripcion),0,60)."..."; }
        else {
          $vnomage[$contobj] = $objs->ccv." ".substr(trim($objs->descripcion),0,60); }
  	   $objs = $sql->objects('',$obj_query);
      }

      if ($vopc==5 && ($accion!="Guardar" && $accion!="Incluir")) {
         $vopc=4;
         pg_exec("BEGIN WORK");
         pg_exec("LOCK TABLE stmtmpcvs IN SHARE ROW EXCLUSIVE MODE");
         pg_exec("delete from stmtmpcvs where solicitud='$vsol' AND ccv='$accion'");
         pg_exec("COMMIT WORK"); 
      }
      if ($vopc==5 && $accion=="Incluir") {
       $vopc=4;
	    $insert_valores ="'$vsol','$vccv'";
	    if ($vccv>0) {
	         pg_exec("BEGIN WORK");
            pg_exec("LOCK TABLE stmtmpcvs IN SHARE ROW EXCLUSIVE MODE");
            pg_exec("delete from stmtmpcvs where solicitud='$vsol' and ccv='$vccv'");
            $sql->insert("$tbname_9","","$insert_valores","");
            pg_exec("COMMIT WORK"); 
	 }  }
  
      $resulpoh=pg_exec("SELECT a.ccv,b.descripcion FROM stmtmpcvs a,stmviena b WHERE a.solicitud='$vsol' AND a.ccv=b.ccv");
      $regpoh = pg_fetch_array($resulpoh);
      $filaspoh=pg_numrows($resulpoh);
      for($cont=0;$cont<$filaspoh;$cont++) { 
         $vpoderhab1[$cont]=$regpoh[ccv];
         if (strlen(trim($regpoh[descripcion])) > 60) {
           $vpoderhab2[$cont] = substr(trim($regpoh[descripcion]),0,60)."..."; }
         else {
           $vpoderhab2[$cont] = substr(trim($regpoh[descripcion]),0,60); }
         $regpoh = pg_fetch_array($resulpoh);
      }
      $smarty->assign('arr_ph1',$vpoderhab1); 
      $smarty->assign('arr_ph2',$vpoderhab2);
      $smarty->assign('vnumrows',$filaspoh);
      $smarty->assign('vcodage',$vcodage);
      $smarty->assign('vnomage',$vnomage);
       
      $smarty->assign('codage',0); 
   }

   if ($vopc==5 && $accion=='Guardar') {
     $vsol     = $_GET['vsol'];
     //$vexist   = $_POST['vexist'];
     $etiqueta = $_POST['etiqueta'];

     //Datos de Derecho de la Marca
     $resultado=pg_exec("SELECT * FROM $tbname_2 WHERE solicitud='$vsol' AND tipo_mp='M'");
     $filas_found=pg_numrows($resultado); 
     $reg = pg_fetch_array($resultado);
     $vdere=$reg[nro_derecho];   

     // Actualiza tabla de logos
     $actlog = true; 
     $inslogo = true;
     pg_exec("BEGIN WORK");
     $etiqueta = str_replace("'","´",$etiqueta);

     //Verificacion de si existe o no la descripcion de la etiqueta 
     $obj_query = $sql->query("SELECT * FROM $tbname_6 WHERE nro_derecho=$vdere");
     $obj_filas = $sql->nums('',$obj_query);
     echo "son=$obj_filas ";
     if ($obj_filas!=0) {
       pg_exec("LOCK TABLE $tbname_6 IN SHARE ROW EXCLUSIVE MODE");
       $update_str = "descripcion='$etiqueta'";        
       $actlog = $sql->update("$tbname_6","$update_str","nro_derecho=$vdere"); }
     else { 
       $insert_str = "'$vdere','$etiqueta'";
       $inslogo = $sql->insert("$tbname_6","","$insert_str",""); }
     
     //if ($vexist==0) {
     //  $insert_str = "'$vdere','$etiqueta'";
     //  $inslogo = $sql->insert("$tbname_6","","$insert_str","");}
     //else {
     //  pg_exec("LOCK TABLE $tbname_6 IN SHARE ROW EXCLUSIVE MODE");
     //  $update_str = "descripcion='$etiqueta'";        
     //  $actlog = $sql->update("$tbname_6","$update_str","nro_derecho=$vdere"); }
       
     // Elimina todos los registros existentes para luego actualizarlos
     $numccv = 0;  
     $insccv = true;
     $resultmp=pg_exec("SELECT * FROM stmtmpcvs WHERE solicitud='$vsol'");
     $regtmp = pg_fetch_array($resultmp);
     $filtmp = pg_numrows($resultmp);
     $sql->del("$tbname_5","nro_derecho=$vdere");
     for ($cont=0;$cont<$filtmp;$cont++) {
       $var=$regtmp[ccv];
       // Verificacion de que el codigo existe o no en la base de datos         
       $obj_query = $sql->query("SELECT * FROM $tbname_3 WHERE ccv='$var'");
       $obj_filas = $sql->nums('',$obj_query);
       if ($obj_filas==0) {
         Mensajenew("Codigo $var NO existe en la Base de Datos, debe ser cargado ...!!!","javascript:history.back();","N");
         $smarty->display('pie_pag.tpl'); exit(); }     
       $insert_valores="$vdere,'$var'";
       $insccv = $sql->insert("$tbname_5","","$insert_valores","");
       if (!$insccv) { $numccv = $numccv + 1; } 
       $regtmp = pg_fetch_array($resultmp);
     }

     //Insertar datos de Verificacion del usuario 
     $fechahoy = hoy();
     $horactual= Hora();
     $insaud = true;
     $insert_col="fecha_proc,hora,usuario,solicitud";
     $insert_str = "'$fechahoy','$horactual','$usuario','$vsol'";
     $insaud = $sql->insert("$tbname_7","$insert_col","$insert_str","");
     
     if ($actlog AND $inslogo AND $insaud AND $numccv==0) {
       pg_exec("COMMIT WORK");
       //Desconexion de la Base de Datos
       $sql->disconnect();
   
       Mensajenew("DATOS GUARDADOS CORRECTAMENTE ...!!!","m_solviena.php","S");
       $smarty->display('pie_pag.tpl'); exit();
     }
     else {
       pg_exec("ROLLBACK WORK");
       //Desconexion de la Base de Datos
       $sql->disconnect();

       if (!$actlog) { $error_log  = " - Descripci&oacute;n de logo "; }
       if (!$numccv) { $error_ccv  = " - C&oacute;digos de Viena x Marca "; } 
       if (!$insaud) { $error_aud  = " - Auditor&iacute;a "; }
       Mensajenew("Falla de Actualizaci&oacute;n / Inserci&oacute;n de Datos en la BD $error_log $error_ccv $error_aud ...!!!","javascript:history.back();","N");
       $smarty->display('pie_pag.tpl'); exit();
     }
   }

$smarty->assign('campo1','Expediente No.:');
$smarty->assign('campo2','Registro No.:');
$smarty->assign('campo3','de Fecha:');
$smarty->assign('campo4','Tipo:');
$smarty->assign('campo5','Clase:');
$smarty->assign('campo6','Nombre:');
$smarty->assign('campo7','Estatus:');
$smarty->assign('campo8','Fecha Registro:');
$smarty->assign('campo9','Fecha Vencimiento:');
$smarty->assign('campo10','Agente/Tramitante:');
$smarty->assign('campo11','Titular:');
$smarty->assign('campo12','Pais:');
$smarty->assign('campo13','Fecha del Evento:');
$smarty->assign('campo14','Cod. Viena:');
$smarty->assign('campo15','Etiqueta:');
$smarty ->assign('lcpoder','Codigo:'); 
$smarty ->assign('lnpoder','Descripcion:'); 
$smarty ->assign('vopc',$vopc);
$smarty ->assign('vdere',$vdere); 
$smarty->assign('vsol1',$vsol1); 
$smarty->assign('vsol2',$vsol2); 
$smarty->assign('vsol',$vsol);
$smarty->assign('vreg1',$vreg1);
$smarty->assign('vreg2',$vreg2);
$smarty->assign('vreg',$vreg);
$smarty->assign('vfec',$vfec);
$smarty->assign('nombre',$vnom); 
$smarty->assign('vest',$vest); 
$smarty->assign('vdesest',$vdesest);
$smarty->assign('vfecsol',$vfecsol); 
$smarty->assign('vfecreg',$vfecreg); 
$smarty->assign('vfecven',$vfecven); 
$smarty->assign('nameimage',$nameimage);
$smarty->assign('modal_id',$modal_id);
$smarty->assign('modal',$modal);
$smarty->assign('vtip',$vtip);
$smarty->assign('vtipo',$vtipo);
$smarty->assign('vclase',$vclase);
$smarty->assign('vindcla',$vindcla);
$smarty->assign('vtra',$vtra);
$smarty->assign('vcodtit',$vcodtit);
$smarty->assign('vnomtit',$vnomtit);
$smarty->assign('vnactit',$vnactit);
$smarty->assign('vnadtit',$vnadtit);
$smarty->assign('vdomtit',$vdomtit);
$smarty->assign('etiqueta',$etiqueta);
$smarty->assign('vmodo','readonly=readonly'); 
$smarty->assign('varfocus','formarcas1.vsol1'); 
$smarty->assign('usuario',$usuario);

$smarty->display('m_solviena.tpl');
$smarty->display('pie_pag.tpl');
?>
