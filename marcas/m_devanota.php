<script language="Javascript"> 
function gestionagente(var1,var2,var3) {
  this.derecho='M';
  open("../marcas/adm_agentram.php?vpod="+var1.value+"-"+var2.value+"&vtra="+var3.value+"&vtip="+this.derecho,"Ventana", 
       "scrollbars=yes,toolbar=no,directories=no,menubar=no,status=no"); }
</script>

<?

//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
   echo "Acceso Denegado..."; exit(); }

//Variables
$usuario = $_SESSION['usuario_login'];
$hh      = hora();
$sql     = new mod_db(); 
$fecha   = fechahoy();  
$tbname_1  = "stzcoded";
$tbname_2  = "stzderec";
$tbname_3  = "stzagenr";
$tbname_4  = "stmmarce";
$tbname_5  = "stzevtrd";

$smarty->assign('titulo',$substmar); 
$smarty->assign('subtitulo','Devoluci&oacute;n de Anotaciones Marginales'); 
$smarty->display('encabezado1.tpl');
$smarty->assign('login',$usuario); 
$smarty->assign('fechahoy',$fecha); 
$smarty->assign('arrayvtrami',array(B,C,F,L,N,O,R));
$smarty->assign('arrayttrami',array('','Cesi&oacute;n','Fusi&oacute;n','Licencia de Uso','Cambio de Nombre','Cambio de Domicilio','Renovaci&oacute;n'));
   
$vuser = $usuario;
     
//Captura Variables leidas en formulario inicial
 $vopc  = $_GET['vopc'];
 $vder  = $_POST['vder'];
 $vreg1 = $_POST['vreg1'];
 $vreg2 = $_POST['vreg2'];
 $vsol1 = $_POST['vsol1'];
 $vsol2 = $_POST['vsol2'];
 $vfecsol = $_POST['vfecsol'];
 $vsol  = sprintf("%04d-%06d",$vsol1,$vsol2);
 $vnom  = $_POST['vnom'];
 $vcla  = $_POST['vcla'];
 $vindcla = $_POST['vindcla'];
 $resultado=false;
  
 $vsolh   = $_POST['vsolh'];
 $vfevh   = $_POST['vfevh'];
 $vcausa1 = $_POST['causa1'];  $vcausa2 =$_POST['causa2'];  $vcausa3 =$_POST['causa3'];  
 $vcausa4 = $_POST['causa4'];  $vcausa5 =$_POST['causa5'];  $vcausa6 =$_POST['causa6'];  
 $vcausa7 = $_POST['causa7'];  $vcausa8 =$_POST['causa8'];  $vcausa9 =$_POST['causa9'];  
 $vcausa10= $_POST['causa10']; $vcausa11=$_POST['causa11']; $vcausa12=$_POST['causa12'];
 $vcausa13= $_POST['causa13']; $vcausa14=$_POST['causa14']; $vcausa15=$_POST['causa15'];
 $vcausa16= $_POST['causa16']; $vcausa17=$_POST['causa17']; $vcausa18=$_POST['causa18'];
 $vcausa19= $_POST['causa19']; $vcausa20=$_POST['causa20']; $vcausa21=$_POST['causa21'];
 $otro   = $_POST['otro'];
 $vtra  = $_POST['tramite'];
 $vfechr  = $_POST['vfechr'];
 $vnumtram= $_POST['vnumtram'];
 $tramitante= trim($_POST['tramitante']);
 $vest   = $_POST['vest'];
 $vpoder  = $_POST['vpoder'];
 $vtramita= $_POST['vtramita'];

 $vfec    = hoy();
 $vpod1=$_POST['vpod1'];  
 $vpod2=$_POST['vpod2']; 
 $vpod=$vpod1.'-'.$vpod2;
 

 $sql->connection($usuario);

//fragmento de codigo para visualizar el nuevo poder en caso de ser distinto al del expediente
 if ($vopc==3) {
    $vopcpod=$_POST['vopcpod'];
    if ($vopcpod==1) { 
       $vopc=1; 
       if ($vpod1=='0000') {$vpod1='';} 
       if ($vpod2=='0000') {$vpod2='';}
       $vpod=$vpod1.'-'.$vpod2;
       if ($vpod=='-') { $poderhabi ='Debe ingresar correctamente el numero del PODER! Verifique...'; $vpod1=''; $vpod2=''; 
       } else          { $poderhabi = agente_tram_am($nagen,trim($vnomtram),$vpod); }
    }
 }

 if (!empty($vreg1) && !empty($vreg2)) { $vreg = $vreg1.$vreg2; }

   //Submit cuando vopc es diferente de 1 y 2 y cuando pasa la primera vez  
   $smarty ->assign('submitbutton','submit'); 
   $smarty ->assign('varfocus','formarcas1.vreg1'); 
   $smarty ->assign('vmodo','readonly'); 
   $smarty ->assign('modo',''); 
   
//   $sql->connection($usuario);   

   //Verifica si el progrma esta en mantenimiento
   $manphp = vman_php("m_devanota.php");
   if ($manphp==1) {
     MensageError('Modulo en Mantenimiento ...!!!','N');
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }     

   if ($vopc==1) {
    //Validacion del Numero de Registro
   if (empty($vreg1) && empty($vreg2)) {
      mensajenew("AVISO: No introdujo ningún valor de Expediente ...!!!","m_devanota.php","N");
      $smarty->display('pie_pag.tpl'); exit(); }

     $resultado=pg_exec("SELECT * FROM $tbname_2 WHERE registro='$vreg' AND tipo_mp='M'");      
   }
   
   if ($vopc==1) {
      $smarty ->assign('submitbutton','button'); 
      $smarty ->assign('varfocus','formarcas2.tramite'); 
      $smarty ->assign('vmodo','readonly'); 
      $smarty ->assign('modo','readonly'); 
      
      if (!$resultado) { 
         mensajenew('ERROR: PROBLEMA AL ACCESAR LA BASE DE DATOS ...!!!','m_devanota.php','N');
	 $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
      }	 
      $filas_found=pg_numrows($resultado); 
      if ($filas_found==0) {
         mensajenew('AVISO: NO EXISTEN DATOS ASOCIADOS ...!!!','m_devanota.php','N');
	 $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
      }	 
      $reg = pg_fetch_array($resultado);
      $vder=$reg[nro_derecho];
      $vsol=$reg[solicitud];
      $vsol1=substr($vsol,-11,4);
      $vsol2=substr($vsol,-6,6);
      $vnom=$reg[nombre];
      $vest=$reg[estatus];
      $vfecsol=$reg[fecha_solic];
      $fechavenc=$reg[fecha_venc];
      $fechareg =$reg[fecha_regis];
      $vtramita=trim($reg[tramitante]); 
      $agente = $reg[agente];
      $vpoder = $reg[poder];
      if (empty($vpoder) or $vpoder==0) { $ltramage='Tramitante:';}
      else { $ltramage='Agente(s):'; }

      //Generar numero unico de transaccion (para el archivo temporal) 
      pg_exec("LOCK TABLE stzsystem IN ROW EXCLUSIVE MODE");
      $update_str = "devolucion = nextval('stzsystem_devolucion_seq')";
      $upd_sys = $sql->update("stzsystem","$update_str","");    
      
      $obj_query = $sql->query("SELECT * FROM stzsystem");
      $objs = $sql->objects('',$obj_query);
      $numdoc  = $objs->devolucion;

      //Obtención de datos de la Marca 
      $obj_query = $sql->query("SELECT * FROM $tbname_4 WHERE nro_derecho='$vder'");
      $objs = $sql->objects('',$obj_query);
      $vmod    = $objs->modalidad;
      $vcla    = $objs->clase;
      $vindcla = $objs->ind_claseni;

      if ($vmod=='D') {$vmodal='DENOMINATIVA';}
      if ($vmod=='G') {$vmodal='GRAFICA';}
      if ($vmod=='M') {$vmodal='MIXTA';}
      if ($reg['tipo_derecho']=='M') {$lctipo='M'; $tipomarca='MARCA DE PRODUCTO';}
      if ($reg['tipo_derecho']=='C') {$lctipo='C'; $tipomarca='MARCA COLECTIVA';}
      if ($reg['tipo_derecho']=='L') {$lctipo='L'; $tipomarca='LEMA COMERCIAL';}
      if ($reg['tipo_derecho']=='N') {$lctipo='N'; $tipomarca='NOMBRE COMERCIAL';}
      if ($reg['tipo_derecho']=='S') {$lctipo='S'; $tipomarca='MARCA DE SERVICIO';}
      //if ($reg['tipo_derecho']=='D') {$lctipo='D'; $tipomarca='DENOMINACION DE ORIGEN';}

      //Obtención de la Descripción del Estatus 
      $obj_query = $sql->query("SELECT * FROM stzstder WHERE estatus='$vest'");
      $objs = $sql->objects('',$obj_query);
      $vdest = $objs->descripcion;

      //Obtención del agente si tramitante is NULL 
//      $vtragen = agente_tramp($agente,trim($reg['tramitante']),$vpoder);
      $vtragen = agente_tramp($agente,'',$vpoder);
      //if ($agente > 0) {
      //  $obj_query = $sql->query("SELECT a.nombre FROM stzagenr a,stzderec b WHERE a.agente = b.agente and a.agente='$agente'");
      //  $objs = $sql->objects('',$obj_query);
      //  $vnbage = $objs->nombre; }
      //if ($agente > 0) { $vtragen= $agente." - ".$vnbage; }
      //else { $vtragen= $vtramita; }


      if ($vmod=="D") {
        $nameimage="../imagenes/sin_imagen.jpg"; }
      else { $nameimage = ver_imagen($vsol1,$vsol2,"M"); }  

      if (!file_exists($nameimage)) {
        $nameimage="../imagenes/sin_imagen.jpg"; }

      $smarty ->assign('vmod',$vmod); 
      $smarty ->assign('vmodal',$vmodal); 
      $smarty ->assign('nameimage',$nameimage); 


      if ($vest==1555) { 
        //Descripcion de causales para Devolucion
        $smarty ->assign('lcausadev','Causales de Devoluci&oacute;n:'); 
        $resultadoc=pg_exec("SELECT * FROM $tbname_1 WHERE cod_causa=1 and derecho='M' and grupo='A'");$regc=pg_fetch_array($resultadoc);
        $smarty ->assign('luno',$regc[desc_causa]);
        $resultadoc=pg_exec("SELECT * FROM $tbname_1 WHERE cod_causa=2 and derecho='M' and grupo='A'");$regc=pg_fetch_array($resultadoc);
        $smarty ->assign('ldos',    $regc[desc_causa]); 
        $resultadoc=pg_exec("SELECT * FROM $tbname_1 WHERE cod_causa=3 and derecho='M' and grupo='A'");$regc=pg_fetch_array($resultadoc);
        $smarty ->assign('ltres',   $regc[desc_causa]); 
        $resultadoc=pg_exec("SELECT * FROM $tbname_1 WHERE cod_causa=4 and derecho='M' and grupo='A'");$regc=pg_fetch_array($resultadoc);
        $smarty ->assign('lcuatro', $regc[desc_causa]); 
        $resultadoc=pg_exec("SELECT * FROM $tbname_1 WHERE cod_causa=5 and derecho='M' and grupo='A'");$regc=pg_fetch_array($resultadoc);
        $smarty ->assign('lcinco',  $regc[desc_causa]); 
        $resultadoc=pg_exec("SELECT * FROM $tbname_1 WHERE cod_causa=6 and derecho='M' and grupo='A'");$regc=pg_fetch_array($resultadoc);
        $smarty ->assign('lseis',   $regc[desc_causa]); 
        $resultadoc=pg_exec("SELECT * FROM $tbname_1 WHERE cod_causa=7 and derecho='M' and grupo='A'");$regc=pg_fetch_array($resultadoc);
        $smarty ->assign('lsiete',  $regc[desc_causa]); 
        $resultadoc=pg_exec("SELECT * FROM $tbname_1 WHERE cod_causa=8 and derecho='M' and grupo='A'");$regc=pg_fetch_array($resultadoc);
        $smarty ->assign('locho',   $regc[desc_causa]); 
        $resultadoc=pg_exec("SELECT * FROM $tbname_1 WHERE cod_causa=9 and derecho='M' and grupo='A'");$regc=pg_fetch_array($resultadoc);
        $smarty ->assign('lnueve',  $regc[desc_causa]); 
        $resultadoc=pg_exec("SELECT * FROM $tbname_1 WHERE cod_causa=10 and derecho='M' and grupo='A'");$regc=pg_fetch_array($resultadoc);
        $smarty ->assign('ldiez',   $regc[desc_causa]); 
        $resultadoc=pg_exec("SELECT * FROM $tbname_1 WHERE cod_causa=11 and derecho='M' and grupo='A'");$regc=pg_fetch_array($resultadoc);
        $smarty ->assign('lonce',   $regc[desc_causa]); 
        $resultadoc=pg_exec("SELECT * FROM $tbname_1 WHERE cod_causa=12 and derecho='M' and grupo='A'");$regc=pg_fetch_array($resultadoc);
        $smarty ->assign('ldoce',   $regc[desc_causa]); 
        $resultadoc=pg_exec("SELECT * FROM $tbname_1 WHERE cod_causa=13 and derecho='M' and grupo='A'");$regc=pg_fetch_array($resultadoc);
        $smarty ->assign('ltrece',  $regc[desc_causa]); 
        $resultadoc=pg_exec("SELECT * FROM $tbname_1 WHERE cod_causa=14 and derecho='M' and grupo='A'");$regc=pg_fetch_array($resultadoc);
        $smarty ->assign('lcatorce',$regc[desc_causa]); 
        $resultadoc=pg_exec("SELECT * FROM $tbname_1 WHERE cod_causa=15 and derecho='M' and grupo='A'");$regc=pg_fetch_array($resultadoc);
        $smarty ->assign('lquince', $regc[desc_causa]); 
        $resultadoc=pg_exec("SELECT * FROM $tbname_1 WHERE cod_causa=16 and derecho='M' and grupo='A'");$regc=pg_fetch_array($resultadoc);
        $smarty ->assign('ldieciseis', $regc[desc_causa]); 
        $resultadoc=pg_exec("SELECT * FROM $tbname_1 WHERE cod_causa=17 and derecho='M' and grupo='A'");$regc=pg_fetch_array($resultadoc);
        $smarty ->assign('ldiecisiete', $regc[desc_causa]); 
        $resultadoc=pg_exec("SELECT * FROM $tbname_1 WHERE cod_causa=18 and derecho='M' and grupo='A'");$regc=pg_fetch_array($resultadoc);
        $smarty ->assign('ldieciocho', $regc[desc_causa]); 
        $resultadoc=pg_exec("SELECT * FROM $tbname_1 WHERE cod_causa=19 and derecho='M' and grupo='A'");$regc=pg_fetch_array($resultadoc);
        $smarty ->assign('ldiecinueve', $regc[desc_causa]); 
        $resultadoc=pg_exec("SELECT * FROM $tbname_1 WHERE cod_causa=20 and derecho='M' and grupo='A'");$regc=pg_fetch_array($resultadoc);
        $smarty ->assign('lveinte', $regc[desc_causa]); 
        $resultadoc=pg_exec("SELECT * FROM $tbname_1 WHERE cod_causa=21 and derecho='M' and grupo='A'");$regc=pg_fetch_array($resultadoc);
        $smarty ->assign('lveintiuno', $regc[desc_causa]); 
        $smarty ->assign('lveintidos', 'Otros:');
      } else {
          $smarty->display('encabezado1.tpl');
          mensajenew('AVISO: Solo Aplica en Solicitudes que tengan Estatus: 555-Registradas','m_devanota.php','N');
	  $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
      }
   }
   
   if ($vopc==3) {
      if (($vcausa1=='' and $vcausa2=='' and $vcausa3=='' and 
         $vcausa4=='' and $vcausa5=='' and $vcausa6=='' and $vcausa7=='' and
         $vcausa8=='' and $vcausa9=='' and $vcausa10=='' and $vcausa11=='' and
         $vcausa12=='' and $vcausa13=='' and $vcausa14=='' and $vcausa15=='' and  
         $vcausa16=='' and $vcausa17=='' and $vcausa18=='' and $vcausa19=='' and
         $vcausa20=='' and $vcausa21=='' and $otro=='')) {
         mensajenew("ERROR: Debe Indicar los Causales de Devoluci&oacute;n! Verifique...!!!","javascript:history.back();","N");
	 $smarty->display('pie_pag.tpl'); exit();  
      }
      //$esmayor=compara_fechas($vfevh,$vfec);
      //if ($esmayor==1) {
      //   $smarty->display('encabezado1.tpl');
      //   mensajenew("No se puede cargar un Evento a futuro ...!!!","javascript:history.back();","N");
      //   $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
      //}
      if ($vtra=='B') {
        mensajenew("ERROR: Debe indicar el Tipo de Anotaci&oacute;n Marginal! Verifique...","javascript:history.back();","N");
        $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();
      }
      if (empty($vfechr)) {
        mensajenew("ERROR: Debe indicar la fecha de la Anotaci&oacute;n Marginal! Verifique...","javascript:history.back();","N");
        $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();
      }
      if (empty($vnumtram) or $vnumtram<=0) {
        mensajenew("ERROR: Debe indicar el n&uacute;mero de la Anotaci&oacute;n Marginal! Verifique...","javascript:history.back();","N");
        $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();
      }

      //Validacion adicional por si acaso otro usuario cambia la solicitud
      $resulsol=pg_exec("SELECT * FROM stzderec WHERE nro_derecho='$vder' AND tipo_mp='M'");
      $regsol = pg_fetch_array($resulsol);
      $vest   = $regsol[estatus];
      $vfecsol= $regsol[fecha_solic];
      if ($vest==1555) { //Esta bien
      } else {
         mensajenew('ERROR: PROBLEMA AL INTENTAR GRABAR - La solicitud ha sido modificada por otro usuario ...!!!','javascript:history.back();','N');
	 $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
      }

      //Validacion adicional por si acaso otro usuario cambia la solicitud
      $numcontrol='%No. Control Anotacion: '.$vnumtram.'%';
      $resulcon=pg_exec("SELECT * FROM stzevtrd WHERE comentario like '$numcontrol' AND evento=1502");
      $regcon = pg_numrows($resulcon);
      if ($regcon>0) {
         mensajenew('ERROR: PROBLEMA AL INTENTAR GRABAR - EL No. Control Anotacion ya existe!. Verifique...','javascript:history.back();','N');
	 $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
      }

      //$vfecsol=convertir_en_fecha($vfecsol,1);
      //$esmayor=compara_fechas($vfecsol,$vfevh);
      $esmayor=compara_fechas($vfecsol,$vfechr);  
      if ($esmayor==1) {
         mensajenew('AVISO: No se puede cargar un evento previo a la Fecha de la Solicitud ...!!!','javascript:history.back();','N');
	 $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
      }

      switch ($vtra) {
        case "C":
          $vcomenta = "Cesión";
          break;
        case "F":
          $vcomenta = "Fusión";
          break;
        case "N":
          $vcomenta = "Cambio de Nombre";
          break;
        case "O":
          $vcomenta = "Cambio de Domicilio";
          break;
        case "L":
          $vcomenta = "Licencia de Uso";
          break;
        case "R":
          $vcomenta = "Renovación";
          break;
      }  
      $comentario2='';
      $vtragen = agente_tramp($agente,'',$vpoder);
      if (!empty($vpoder) and $vpoder<>'' and $vpoder<>'-' and $vtragen<>'') { $comentario2= "Poder: "."$vpoder"; }
      else { 
         if (!empty($vtramita)) { $comentario2= "Tramitante: "."$vtramita"; }
      }
      $vtragen2 = agente_tramp($agente,'',$vpod);
      if (!empty($vpod) and $vpod<>'' and $vpod<>'-' and $vtragen2<>'') { $comentario2= "Poder: "."$vpod"; }
      else { 
         if (!empty($tramitante)) { $comentario2= "Tramitante: "."$tramitante"; }
      }
      if ($comentario2=='') {
         mensajenew('ERROR: PROBLEMA AL INTENTAR GRABAR - Poder / Tramitante Invalidos...!!!','javascript:history.back();','N');
	 $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); 
      }
          
      $vdese='REGISTRO CON SOLICITUD DE ANOTACION MARGINAL EN EXAMEN DE FORMA';
      pg_exec("BEGIN WORK");

      pg_exec("LOCK TABLE stzsystem IN ROW EXCLUSIVE MODE");
      $update_str = "devolucion = nextval('stzsystem_devolucion_seq')";
      $upd_sys = $sql->update("stzsystem","$update_str","");    
      
      $obj_query = $sql->query("SELECT * FROM stzsystem");
      $objs = $sql->objects('',$obj_query);
      $doc  = $objs->devolucion;

      //update stzsystem set ntitular = nextval('stzsystem_ntitular_seq');
      //SELECT currval('stzsystem_ntitular_seq');
      //SELECT nextval('stzsystem_ntitular_seq');

      // Inserta en Stzcaded
      $ins_de=true;
      $inscaus = 0;
      $col_campos = "nro_derecho,cod_causa,derecho,grupo,tipo_dev,fecha_dev,hora,documento";
      if ($vcausa1 =='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$vder',1,'M','A','$vtra','$vfec','$hh','$doc'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa2 =='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$vder',2,'M','A','$vtra','$vfec','$hh','$doc'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa3 =='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$vder',3,'M','A','$vtra','$vfec','$hh','$doc'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa4 =='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$vder',4,'M','A','$vtra','$vfec','$hh','$doc'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa5 =='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$vder',5,'M','A','$vtra','$vfec','$hh','$doc'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa6 =='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$vder',6,'M','A','$vtra','$vfec','$hh','$doc'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa7 =='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$vder',7,'M','A','$vtra','$vfec','$hh','$doc'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa8 =='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$vder',8,'M','A','$vtra','$vfec','$hh','$doc'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa9 =='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$vder',9,'M','A','$vtra','$vfec','$hh','$doc'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa10=='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$vder',10,'M','A','$vtra','$vfec','$hh','$doc'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa11=='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$vder',11,'M','A','$vtra','$vfec','$hh','$doc'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa12=='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$vder',12,'M','A','$vtra','$vfec','$hh','$doc'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa13=='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$vder',13,'M','A','$vtra','$vfec','$hh','$doc'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa14=='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$vder',14,'M','A','$vtra','$vfec','$hh','$doc'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa15=='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$vder',15,'M','A','$vtra','$vfec','$hh','$doc'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa16=='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$vder',16,'M','A','$vtra','$vfec','$hh','$doc'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa17=='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$vder',17,'M','A','$vtra','$vfec','$hh','$doc'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa18=='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$vder',18,'M','A','$vtra','$vfec','$hh','$doc'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa19=='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$vder',19,'M','A','$vtra','$vfec','$hh','$doc'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa20=='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$vder',20,'M','A','$vtra','$vfec','$hh','$doc'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa21=='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$vder',21,'M','A','$vtra','$vfec','$hh','$doc'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa22=='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$vder',22,'M','A','$vtra','$vfec','$hh','$doc'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }
      if ($vcausa23=='on') {
        $ins_de=$sql->insert("stzcaded","$col_campos","'$vder',23,'M','A','$vtra','$vfec','$hh','$doc'","");
        if (!$ins_de) { $inscaus = $inscaus + 1; } }

      $otro = trim($otro);
      if ($otro<>'') {
        $col_campos = "nro_derecho,otros,derecho,grupo,tipo_dev,fecha_dev,hora,documento";
        $ins_otros = $sql->insert("stzotrde","$col_campos","'$vder','$otro','M','A','$vtra','$vfec','$hh','$doc'",""); 
        if (!$ins_otros) { $inscaus = $inscaus + 1; } }

      // Inserta evento en Stzevtrd
      $ins_evento=true;
      $comentario = "$vtra"." - "."$vcomenta"." de Fecha: "."$vfechr".", No. Control Anotacion: "."$vnumtram"." $comentario2";
      //
      $insert_campos="nro_derecho,evento,fecha_event,estat_ant,documento,fecha_trans,
                      usuario,desc_evento,comentario,hora";
      $insert_valores="'$vder',1502,'$vfechr',$vest,$doc,'$vfec',
                     '$vuser','$vdese','$comentario','$hh'";
      $ins_evento= $sql->insert("stzevtrd","$insert_campos","$insert_valores","");	 

      // Mensaje final
      if ($ins_evento and $inscaus==0) { 
        pg_exec("COMMIT WORK");  
        mensajenew('DATOS GUARDADOS CORRECTAMENTE ...!!!','m_devanota.php','S');
        $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();   
      }
      else {
        pg_exec("ROLLBACK WORK");
        mensajenew("ERROR: Falla de Ingreso de Datos en la BD, Transacciones Abortadas ...!!!",
                   "javascript:history.back();","N");
        $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit();    
      }

   }   

   //Asignacion de variables para pasarlas a Smarty
   $smarty->assign('vopc',$vopc); 
   $smarty->assign('vder',$vder); 
   $smarty->assign('vsol1',$vsol1); 
   $smarty->assign('vsol2',$vsol2); 
   $smarty->assign('vreg1',$vreg1); 
   $smarty->assign('vreg2',$vreg2); 
   $smarty->assign('nombre',$vnom); 
   $smarty->assign('clase',$vcla); 
   $smarty->assign('vfevh',$vfevh); 
   $smarty->assign('vfec',$vfec);
   $smarty->assign('vmod',$vmod);  
   $smarty->assign('vest',$vest-1000);
   $smarty->assign('vdest',$vdest);
   $smarty->assign('vtragen',$vtragen);
   $smarty->assign('vtramita',$vtramita);
   $smarty->assign('vpoder',$vpoder);
   $smarty->assign('vnumdoc',$numdoc);
   $smarty->assign('lctipo',$lctipo);  
   $smarty->assign('vfecsol',$vfecsol); 
   $smarty->assign('causa1',$vcausa1); 
   $smarty->assign('causa2',$vcausa2); 
   $smarty->assign('causa3',$vcausa3); 
   $smarty->assign('causa4',$vcausa4); 
   $smarty->assign('causa5',$vcausa5); 
   $smarty->assign('causa6',$vcausa6); 
   $smarty->assign('causa7',$vcausa7); 
   $smarty->assign('causa8',$vcausa8); 
   $smarty->assign('causa9',$vcausa9); 
   $smarty->assign('causa10',$vcausa10); 
   $smarty->assign('causa11',$vcausa11); 
   $smarty->assign('causa12',$vcausa12); 
   $smarty->assign('causa13',$vcausa13); 
   $smarty->assign('causa14',$vcausa14); 
   $smarty->assign('causa15',$vcausa15); 
   $smarty->assign('causa16',$vcausa16); 
   $smarty->assign('causa17',$vcausa17);
   $smarty->assign('causa18',$vcausa18);
   $smarty->assign('causa19',$vcausa19);
   $smarty->assign('causa20',$vcausa20);
   $smarty->assign('causa21',$vcausa21);
   if ($vcausa1=='on') {$smarty->assign('ck_causa1','checked');} else {$smarty->assign('ck_causa1','');}
   if ($vcausa2=='on') {$smarty->assign('ck_causa2','checked');} else {$smarty->assign('ck_causa2','');}
   if ($vcausa3=='on') {$smarty->assign('ck_causa3','checked');} else {$smarty->assign('ck_causa3','');}
   if ($vcausa4=='on') {$smarty->assign('ck_causa4','checked');} else {$smarty->assign('ck_causa4','');}
   if ($vcausa5=='on') {$smarty->assign('ck_causa5','checked');} else {$smarty->assign('ck_causa5','');}
   if ($vcausa6=='on') {$smarty->assign('ck_causa6','checked');} else {$smarty->assign('ck_causa6','');}
   if ($vcausa7=='on') {$smarty->assign('ck_causa7','checked');} else {$smarty->assign('ck_causa7','');}
   if ($vcausa8=='on') {$smarty->assign('ck_causa8','checked');} else {$smarty->assign('ck_causa8','');}
   if ($vcausa9=='on') {$smarty->assign('ck_causa9','checked');} else {$smarty->assign('ck_causa9','');}
   if ($vcausa10=='on') {$smarty->assign('ck_causa10','checked');} else {$smarty->assign('ck_causa10','');}
   if ($vcausa11=='on') {$smarty->assign('ck_causa11','checked');} else {$smarty->assign('ck_causa11','');}
   if ($vcausa12=='on') {$smarty->assign('ck_causa12','checked');} else {$smarty->assign('ck_causa12','');}
   if ($vcausa13=='on') {$smarty->assign('ck_causa13','checked');} else {$smarty->assign('ck_causa13','');}
   if ($vcausa14=='on') {$smarty->assign('ck_causa14','checked');} else {$smarty->assign('ck_causa14','');}
   if ($vcausa15=='on') {$smarty->assign('ck_causa15','checked');} else {$smarty->assign('ck_causa15','');}
   if ($vcausa16=='on') {$smarty->assign('ck_causa16','checked');} else {$smarty->assign('ck_causa16','');}
   if ($vcausa17=='on') {$smarty->assign('ck_causa17','checked');} else {$smarty->assign('ck_causa17','');}
   if ($vcausa18=='on') {$smarty->assign('ck_causa18','checked');} else {$smarty->assign('ck_causa18','');}
   if ($vcausa19=='on') {$smarty->assign('ck_causa19','checked');} else {$smarty->assign('ck_causa19','');}
   if ($vcausa20=='on') {$smarty->assign('ck_causa20','checked');} else {$smarty->assign('ck_causa20','');}
   if ($vcausa21=='on') {$smarty->assign('ck_causa21','checked');} else {$smarty->assign('ck_causa21','');}
   $smarty->assign('causa3',$vcausa3); 
   $smarty->assign('causa4',$vcausa4); 
   $smarty->assign('causa5',$vcausa5); 
   $smarty->assign('causa6',$vcausa6); 
   $smarty->assign('causa7',$vcausa7); 
   $smarty->assign('causa8',$vcausa8); 
   $smarty->assign('causa9',$vcausa9); 
   $smarty->assign('causa10',$vcausa10); 
   $smarty->assign('causa11',$vcausa11); 
   $smarty->assign('causa12',$vcausa12); 
   $smarty->assign('causa13',$vcausa13); 
   $smarty->assign('causa14',$vcausa14); 
   $smarty->assign('causa15',$vcausa15); 
   $smarty->assign('causa16',$vcausa16); 
   $smarty->assign('causa17',$vcausa17);
   $smarty->assign('causa18',$vcausa18);
   $smarty->assign('causa19',$vcausa19);
   $smarty->assign('causa20',$vcausa20);
   $smarty->assign('causa21',$vcausa21);
   $smarty->assign('otro',$otro);
   $smarty->assign('fecha_venc',$fecha_venc);
   $smarty->assign('tipomarca',$tipomarca);
   $smarty->assign('solicitud1',$vsol1); 
   $smarty->assign('solicitud2',$vsol2); 
   $smarty->assign('uno','01'); 
   $smarty->assign('dos','02'); 
   $smarty->assign('tres','03'); 
   $smarty->assign('cuatro','04'); 
   $smarty->assign('cinco','05'); 
   $smarty->assign('seis','06'); 
   $smarty->assign('siete','07'); 
   $smarty->assign('ocho','08'); 
   $smarty->assign('nueve','09'); 
   $smarty->assign('diez','10'); 
   $smarty->assign('once','11'); 
   $smarty->assign('doce','12'); 
   $smarty->assign('trece','13'); 
   $smarty->assign('catorce','14'); 
   $smarty->assign('quince','15');
   $smarty->assign('dieciseis','16');
   $smarty->assign('diecisiete','17');
   $smarty->assign('dieciocho','18');
   $smarty->assign('diecinueve','19');
   $smarty->assign('veinte','20');
   $smarty->assign('veintiuno','21');
   if ($vindcla=="I") {$smarty ->assign('ind_claseni','INTERNACIONAL');}; 
   if ($vindcla=="N") {$smarty ->assign('ind_claseni','NACIONAL');}; 
   $smarty->assign('lsolicitud','Solicitud:'); 
   $smarty->assign('lregistro','Registro:'); 
   $smarty->assign('lctipom','Tipo:'); 
   $smarty->assign('lfechasolic','Fecha de Solicitud:'); 
   $smarty->assign('lfechaevent','Fecha del Evento:'); 
   $smarty->assign('lfecharen','de Fecha:'); 
   $smarty->assign('lnombre','Nombre:');
   $smarty->assign('lclase','Clase:'); 
   $smarty->assign('lotro','Otro:'); 
   $smarty->assign('lmodal','Modalidad:'); 
   $smarty->assign('lestatus','Estatus:'); 
   $smarty->assign('ltramage',$ltramage); 
   $smarty->assign('lpoder','Poder:'); 
   $smarty->assign('espacios',''); 
   $smarty->assign('ltramite','Tipo Anotacion:');
   $smarty->assign('lnumtra','N&uacute;mero Anotaci&oacute;n:'); 
   $smarty->assign('vpod1',$vpod1);
   $smarty->assign('vpod2',$vpod2);
   $smarty->assign('poderhabi',$poderhabi);
   $smarty->assign('tramite',$vtra);
   $smarty->assign('vfechr',$vfechr);
   $smarty->assign('vnumtram',$vnumtram);
   $smarty->assign('tramitante',$tramitante);
 
   $smarty->display('m_devanota.tpl'); 
   $smarty->display('pie_pag.tpl');
?>
