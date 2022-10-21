<script language="Javascript">

function browsecedente(var1,var2,var3,var4) {
  this.derecho='M';
  open("adm_titum.php?vsol="+var1.value+"-"+var2.value+"&vtex="+var3.value+"&vmod="+var4.value+"&vtip="+this.derecho,"Ventana", "scrollbars=yes,toolbar=no,directories=no,menubar=no,status=no"); }

function browsetitularp(var1,var2,var3,var4) {
  this.derecho='M';
  open("adm_titum.php?vsol="+var1.value+"-"+var2.value+"&vtex="+var3.value+"&vmod="+var4.value+"&vtip="+this.derecho,"Ventana", "scrollbars=yes,toolbar=no,directories=no,menubar=no,status=no"); }
  
</script>

<?php
// *************************************************************************************
// Programa: m_marginalfm04.php 
// Realizado por el Analista de Sistema Romulo Mendoza 
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MPPEF
// Creado Año 2018 I Semestre BD - Relacional 
// *************************************************************************************

//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variables
$usuario = $_SESSION['usuario_login'];
$role = $_SESSION['usuario_rol'];
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
//$tbname_8  = "stzmargi";
$tbname_8  = "stzmargibol";
$tbname_9  = "stztmptit";

$smarty ->assign('titulo',$substmar); 
$smarty ->assign('subtitulo','Publicacion de Renovacion en Boletin'); 
$smarty ->assign('login',$usuario); 
$smarty ->assign('fechahoy',$fecha); 
   
   $vuser    =$usuario;  
   
   //Captura Variables leidas en formulario inicial
   $vopc =  $_GET['vopc'];
   $vder =  $_POST['vder'];
   $vsol1=  $_POST['vsol1'];
   $vsol2=  $_POST['vsol2'];
   $vreg1=  $_POST['vreg1'];
   $vreg2=  $_POST['vreg2'];
   $vnom=   $_POST['vnom'];
   $vest=   $_POST['vest'];
   $vfecsol=$_POST['vfecsol'];
   $vfecreg=$_POST['vfecreg'];
   $vfecven=$_POST['vfecven'];
   $vfecv=$_POST['vfecv'];
   $vdoc=$_POST['vdoc'];
   $vcodtn=$_POST['vcodtn'];
   $vnomtn=$_POST['vnomtn'];
   $vcodtit=$_POST['vcodtit'];
   $vnomtit=$_POST['vnomtit'];
   //$vtipo=$_POST['vtipo'];
   $vcomenta=$_POST['vcomenta'];
   $vdomnew=$_POST['vdomnew'];
   $vdomant=$_POST['vdomant'];
   $vnompai=$_POST['vnompai'];
   $vdomtit=$_POST['vdomtit'];
   $vnactit=$_POST['vnactit'];
   $vtra=$_POST['vtra'];
   $vcodagen=$_POST['vcodagen'];
   $vnomage=$_POST['vnomage'];
   $vtranew=$_POST['vtranew'];
   $vsolh=  $_POST['vsolh'];
   $vregh=  $_POST['vregh'];
   $vnacnew=$_POST['vnacnew'];
   $vclasint=$_POST['vclasint'];
   $vnomagenew=$_POST['options'];
   $vpub=$_POST['vpub'];
   $vseldoc=$_POST['vseldoc'];
   $input2=$_POST['input2'];
   $vbol=$_POST['vbol'];
   $vtipo="R";
   $vseldoc="S";
           
   $vsol=sprintf("%04d-%06d",$vsol1,$vsol2);
   $vreg=   $vreg1.$vreg2;
   $resultado=false;
   $vfec=hoy();
   
   //Submit cuando vopc es diferente de 1 y 2 y cuando pasa la primera vez  
   $smarty ->assign('submitbutton','submit'); 
   $smarty ->assign('varfocus','formarcas1.vreg1'); 
   $smarty ->assign('vmodo',''); 
   
   // Verificando Conexion 
   $sql->connection($usuario);   
   
   if ($vopc==1) {
      $resultado=pg_exec("SELECT * FROM $tbname_6 WHERE solicitud='$vsol' AND tipo_mp='M'");      
   }

   if ($vopc==2) {
      $resultado=pg_exec("SELECT * FROM $tbname_6 WHERE registro='$vreg' AND tipo_mp='M'");
   }

   if ($vopc==1 || $vopc==2) {
      $smarty ->assign('submitbutton','button'); 
      $smarty ->assign('varfocus','formarcas3.vfevh'); 
      $smarty ->assign('vmodo','readonly'); 
      
      if (!$resultado) { 
         $smarty->display('encabezado1.tpl');
         mensajenew('ERROR AL PROCESAR LA BUSQUEDA...!!!','m_marginalfm05.php','N');
	 $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
      }	 
      $filas_found=pg_numrows($resultado); 
      if ($filas_found==0) {
         $smarty->display('encabezado1.tpl');
         mensajenew('NO EXISTEN DATOS ASOCIADOS...!!!','m_marginalfm05.php','N');
	 $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
      }	 
      $reg     =pg_fetch_array($resultado);
      $vder    =$reg[nro_derecho];
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
      $vtipom  =$reg[tipo_derecho];
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
      }  ELSE {
         $smarty->display('encabezado1.tpl');
         mensajenew('Solo aplica a MARCAS con REGISTRO ASIGNADO ...!!!','m_marginalfm05.php','N');
	      $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
      }
      // Obtencion de la Descripcion del Estatus
      $vdesest='';
      $vdesest= estatus($vest);

      // Elimina posibles registros existentes en el temporal
      $sql->del("stztmptit","solicitud='$vsol' AND tipo_mp='M'"); 
     
      // Titular Actual
      $resultit=pg_exec("SELECT a.titular,b.nombre,b.identificacion,b.indole,a.nacionalidad,a.domicilio,a.pais_domicilio,c.nombre as nombrep FROM 
                         stzottid a, stzsolic b, stzpaisr c
                         WHERE a.nro_derecho='$vder' AND a.titular=b.titular AND a.nacionalidad=c.pais");
      $regtit = pg_fetch_array($resultit);
      $vcodtit=$regtit[titular];
      $vnomtit=$regtit[nombre];
      $vnactit=$regtit[nacionalidad];
      $vnadtit=$regtit[nombrep];
      $vdomtit=$regtit[domicilio];
      $vpaidom=$regtit[pais_domicilio];
      $vindole=$regtit[indole];
      $vindent=$regtit[indentificacion];
            
      $col_campos = "solicitud,titular,identificacion,nombre,domicilio,pais_domicilio,nacionalidad,indole,tipo_mp";
      $insert_str = "'$vsol','$vcodtit','$vindent','$vnomtit','$vdomtit','$vpaidom','$vnactit','$vindole','M'";
      $institu = $sql->insert("$tbname_9","$col_campos","$insert_str","");  
      
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
	  
   }   
      
   if ($vopc==3) {
      $vder =  $_POST['vder'];
      $vseldoc='S';
      
      //echo "$vsolh,$vregh,$vtipo";
      
      // Validaciones iniciales
      if ($vsolh=='-' || $vregh=='' || $vtipo=='') {
        $smarty->display('encabezado1.tpl');
        mensajenew('ERROR: PROBLEMA AL INTENTAR GRABAR - DATOS INCORRECTOS O VACIOS...!!!','javascript:history.back();','N');
	     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
	   }

      if ($vtipo=='R') {
        $restitu=pg_exec("SELECT * FROM $tbname_9 where solicitud='$vsolh'");
        $filas_titular=pg_numrows($restitu); 
        if ($filas_titular==0) {
          Mensajenew("ERROR: Expediente $vsolh sin ningun Titular o Solicitante ...!!!","javascript:history.back();","N");
          $smarty->display('pie_pag.tpl'); exit();  }
      }

      if ($vtipo=='R') {
        if (empty($vfecv) || empty($vclasint) || $vclasint==0) {
          $smarty->display('encabezado1.tpl'); 
          Mensajenew("ERROR: No ha ingresado datos de Vencimiento o Clase Internacional para la Renovacion ...!!!","javascript:history.back();","N");
          $smarty->display('pie_pag.tpl'); exit();  }
      } else {
        $vclasint=0;
      }

      //if ($vseldoc=='') { 
      //  $smarty->display('encabezado1.tpl');
      //  mensajenew('NO selecciono si presenta N&uacute;mero de Documento ...!!!','javascript:history.back();','N');
	   //  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
	   //}

      if ($vseldoc=='S') {
        if ($vdoc=='') { 
          $smarty->display('encabezado1.tpl');
          mensajenew('ERROR: NO ha indicado el N&uacute;mero de Documento ...!!!','javascript:history.back();','N');
	       $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 
	   } else { $vdoc=0; } 
      
      if ($vpub=='') { 
        $smarty->display('encabezado1.tpl');
        mensajenew('ERROR: NO selecciono si ya fue o va hacer Publicado ...!!!','javascript:history.back();','N');
	     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
	   }

      if ($vpub=='S') {
        if ($vbol=='' || $vbol==0) { 
          $smarty->display('encabezado1.tpl');
          Mensajenew('ERROR: NO ha indicado el Bolet&iacute;n donde fue Publicado ...!!!','javascript:history.back();','N');
	       $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 
	   }

      if ($vbol=='' || $vbol==0) { 
        $smarty->display('encabezado1.tpl');
        Mensajenew('ERROR: NO ha indicado el Bolet&iacute;n donde fue o sera Publicado ...!!!','javascript:history.back();','N');
	     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); } 

      $esmayor=compara_fechas($vfecsol,$vfec);
      if ($esmayor==1) {
        $smarty->display('encabezado1.tpl');
        mensajenew('ERROR: No se puede cargar un evento previo a la Fecha de la Solicitud...!!!','javascript:history.back();','N');
	     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
      }
       
      // Guardar Tabla Nueva para posteriores actualizaciones
      //if ($vnacnew!='') {$vnacf=$vnacnew;} else {$vnacf=$vnactit;}
      if ($input2!='') {$vnacf=$input2;} else {$vnacf="SP";}
      if ($vdomnew!='') {$vdomf=$vdomnew;} else {$vdomf=$vdomtit;}
      
      if ($vnomagenew=='' && $vtranew=='' && $vcodagen!='') {$vagef=$vcodagen; $vtraf=$vnomage;} 
      else {$vagef=0; $vtraf=$vtranew;}

      if ($vnomagenew!='' || !empty($vnomagenew)) {
         $resulage=pg_exec("SELECT * FROM $tbname_2 WHERE nombre='$vnomagenew'");
         $regage = pg_fetch_array($resulage);
         $vcodagenew=$regage[agente];}  else {$vcodagenew=0;}
      
      if ($vnomagenew!='') {$vagef=$vcodagenew; $vtraf=$vnomagenew;} 
      else {if ($vtranew!='') {$vagef=0; $vtraf=$vtranew;}} 	
      
      if ($vagef>0) {
         $resulage=pg_exec("SELECT nombre FROM $tbname_2 WHERE agente=$vagef");
         $regage = pg_fetch_array($resulage);
         $vtraf=$regage[nombre];}             

      if (empty($vbol)) { $vbol=0; }
      if (empty($vagef)) { $vagef=0; }

      if ($vtraf=='') {
        $smarty->display('encabezado1.tpl');
        mensajenew('NO selecciono Agente o escribio Tramitante alguno ...!!!','javascript:history.back();','N');
	     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
	   }

      //if ($vpub=='S') { $vok = 'S'; } else { $vok = 'N'; }
      $vok = 'S';

      $ins_mar = true;
      pg_exec("BEGIN WORK");
      
      // Tabla de Solicitantes o Titulares 
      $res_titu=pg_exec("SELECT * FROM $tbname_9 WHERE solicitud='$vsolh' AND tipo_mp='M'");
      $filas_res_titu=pg_numrows($res_titu); 
      $regtitu = pg_fetch_array($res_titu);

      if ($vtipo=='R') {
        if ($filas_res_titu==0) {
          $smarty->display('encabezado1.tpl'); 
          Mensajenew("No ha ingresado los datos asociados al Titular al momento de presentar la Renovacion ...!!!","javascript:history.back();","N");
          $smarty->display('pie_pag.tpl'); exit();  }
      }       

      $numerror = 0; 
      $valido = true;
      for($i=0;$i<$filas_res_titu;$i++) 
      { 
       $act_titular = $regtitu[titular];
       $regtitu[nombre] = str_replace("'","´",$regtitu[nombre]);
       $regtitu[domicilio] = str_replace("'","´",$regtitu[domicilio]);
       if ($regtitu[titular]=="0")
         {
           $col_campos = "titular,identificacion,nombre,indole,telefono1,telefono2,fax,email";
           $vident = $regtitu[identificacion];
           $insert_str = "nextval('stzsolic_titular_seq'),'$regtitu[identificacion]','$regtitu[nombre]','$regtitu[indole]','$regtitu[telefono1]','$regtitu[telefono2]','$regtitu[fax]','$regtitu[email]'";
           $valido = $sql->insert("$tbname_3","$col_campos","$insert_str","");
           if (!$valido) { $numerror = $numerror + 1; } 
           $obj_query = $sql->query("select last_value from stzsolic_titular_seq");
           $objs = $sql->objects('',$obj_query);
           $act_titular = $objs->last_value;
         }
         
       if (empty($vfecv)) {
         $insert_campos= "nro_anotacion,nro_derecho,solicitud,documento,nro_docum,tramitante,agente,codtit1,titular1,codtit2,titular2,domicilio_ant,domicilio,pais,tipo_tramite,publicado,boletin,tipo_mp,usuario,fecha_trans,hora,verificado";
         $insert_valores= "nextval('stzmargibol_nro_anotacion_seq'),'$vder','$vsolh','$vseldoc',$vdoc,'$vtraf',$vagef,$vcodtit,'$vcomenta',$act_titular,'$regtitu[nombre]','$vdomant','$regtitu[domicilio]','$regtitu[nacionalidad]','$vtipo','$vpub',$vbol,'M','$usuario','$vfec','$hh','$vok'";
       } 
       else {
         $insert_campos= "nro_anotacion,nro_derecho,solicitud,documento,nro_docum,vencimiento,tramitante,agente,codtit1,titular1,codtit2,titular2,domicilio_ant,domicilio,pais,tipo_tramite,publicado,boletin,tipo_mp,usuario,fecha_trans,hora,verificado,claseint";
         $insert_valores= "nextval('stzmargibol_nro_anotacion_seq'),'$vder','$vsolh','$vseldoc',$vdoc,'$vfecv','$vtraf',$vagef,$vcodtit,'$vcomenta',$act_titular,'$regtitu[nombre]','$vdomant','$regtitu[domicilio]','$regtitu[nacionalidad]','$vtipo','$vpub',$vbol,'M','$usuario','$vfec','$hh','$vok','$vclasint'";
       }
       
       $valido = $sql->insert("$tbname_8","$insert_campos","$insert_valores","");
       if (!$valido) { $numerror = $numerror + 1; }
       $regtitu = pg_fetch_array($res_titu);
      }

      // Verificacion e insercion real de los Datos en BD 
      if ($numerror==0) {
        $del_datos = $sql->del("$tbname_9","solicitud='$vsolh' AND tipo_mp='M'");
        pg_exec("COMMIT WORK");
        //Desconexion de la Base de Datos
        $sql->disconnect();
        
        $smarty->display('encabezado1.tpl');
        mensajenew('DATOS GUARDADOS CORRECTAMENTE!!!','m_marginalfm04.php','S');
        $smarty->display('pie_pag.tpl'); exit(); } 
      else {
        pg_exec("ROLLBACK WORK"); 
        //Desconexion de la Base de Datos
        $sql->disconnect();
        
        mensajenew("Falla de Ingreso de Datos en la BD ...!!!","javascript:history.back();","N");
        $smarty->display('pie_pag.tpl'); exit();
      }

   }
   //Asignacion de variables para pasarlas a Smarty
   $smarty ->assign('opcion',$vopc); 
   $smarty ->assign('vder',$vder); 
   $smarty ->assign('solicitud1',$vsol1); 
   $smarty ->assign('solicitud2',$vsol2); 
   $smarty->assign('vsol1',$vsol1);
   $smarty->assign('vsol2',$vsol2);
   $smarty ->assign('psoli',$vsol1.'-'.$vsol2); 
   $smarty ->assign('vsol',$vsol);
   $smarty ->assign('vfec',$vfec);
   $smarty ->assign('registro1',$vreg1);
   $smarty ->assign('registro2',$vreg2);
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
   $smarty ->assign('vtipo_id',array(R,C,F,N,D,L,)); 
   $smarty ->assign('vtipo_de',array('Renovacion','Cesion','Fusion','Cambio de Nombre','Cambio de Domicilio','Licencia de Uso'));
   $smarty ->assign('vpub_id',array(S,N)); 
   $smarty ->assign('vpub_de',array('Si','No'));
   $smarty ->assign('vdoc_id',array(S,N)); 
   $smarty ->assign('vdoc_de',array('Si','No'));
   $smarty ->assign('lsolicitud','Solicitud:'); 
   $smarty ->assign('lregistro','Registro:'); 
   $smarty ->assign('lnombre','Nombre:');
   $smarty ->assign('lest','Estatus:'); 
   $smarty ->assign('ltipom','Tipo:');
   $smarty ->assign('lclase','Clase:');
   $smarty ->assign('lmodal','Modalidad:');
   $smarty ->assign('ltitular','Titular Actual:'); 
   $smarty ->assign('ltitularnew','Titular:');
   $smarty ->assign('lcedente','Datos del Cedente al momento de presentar la Cesi&oacute;n:'); 
   $smarty ->assign('lpropietario','Datos del Cesionario:'); 
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
   $smarty ->assign('lpub','Publicado:');
   $smarty ->assign('espacios',''); 
   $smarty->display('encabezado1.tpl');
   $smarty->display('m_marginalfm05.tpl'); 
   $smarty->display('pie_pag.tpl');
?>
