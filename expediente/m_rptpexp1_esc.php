<?php
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER'] == "")) {
  echo "Acceso Indebido";
  exit();
}


$usuario = $_SESSION['usuario_login'];
$role = $_SESSION['usuario_rol'];
$fecha   = fechahoy();
$modulo= "m_rptpexp_esc.php";

$conx   = $_GET['conx']; 
$nconex = $_GET['nconex'];
$salir  = $_GET['salir']; 



$varsol1=$_POST["vsol1"];
$varsol2=$_POST["vsol2"];
$varsol=($varsol1.'-'.$varsol2);
if ($varsol=='-') {
   $varsol=$_GET['vsol'];
   $varsol1=substr($varsol,0,4); 
   $varsol2=substr($varsol,5,6);
}



//Verificando Segunda conexion
$sql = new mod_db();
$sql->connection();

$resultado=pg_exec("SELECT clase,solicitud,nombre,modalidad,c.estatus,c.descripcion
                        FROM stmmarce a, stzderec b, stzstder c 
                        WHERE a.nro_derecho=b.nro_derecho and b.estatus=c.estatus
		        AND b.tipo_mp='M' 
		        AND b.solicitud= '$varsol' and b.solicitud!=''");
//$resultado = pg_exec("SELECT * FROM stzderec WHERE  solicitud = '$varsol' AND tipo_mp = 'M' ");
$registro = pg_fetch_array($resultado);
$filas_resultado=pg_numrows($resultado); 
$total=$filas_resultado;

if ($filas_resultado==0) {
   //Pantalla Titulos
   $smarty->assign('titulo',$substmar); 
   $smarty->assign('subtitulo','Documentos del Expediente Electr&oacute;nico');
   $smarty->assign('login',$usuario);
   $smarty->assign('fechahoy',$fecha);
   $smarty->display('encabezado1.tpl');
   mensaje('ERROR AL INTENTAR PROCESAR - DATOS INCORRECTOS O VACIOS','javascript:history.back();','N');
   $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
else {

   $nombre = $registro['nombre'];
   $clase = $registro['clase'];
   $modalidad = $registro['modalidad'];
   if ($modalidad=='D') {$modalidad='DENOMINATIVO';}
   if ($modalidad=='M') {$modalidad='COMPLEJO';} 
   if ($modalidad=='G') {$modalidad='GRAFICO';}  
   $estatus = $registro['estatus'];
   $des_estatus = $registro['descripcion'];
      
$vsol1=substr($nsolic,-11,4);

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

         $name ="../documentos/escritos/ef".$varsol1."/".$varsol1.$varsol2.".pdf"; 
         if (is_file($name)) { $fescritos=1; } // Otros  

         $name ="../documentos/certificado/ef".$varsol1."/".$varsol1.$varsol2.".pdf"; 
         if (is_file($name)) { $fcertificado=1; } // Otros  
   
}
   
$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Documentos del Expediente Electr&oacute;nico');
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');
$smarty ->assign('varsol',$varsol);
$smarty ->assign('varsol1',$varsol1);
$smarty ->assign('varsol2',$varsol2);
$smarty ->assign('nombre',$nombre);
$smarty ->assign('clase',$clase);
$smarty ->assign('modalidad',$modalidad);
$smarty ->assign('estatus',$estatus);
$smarty ->assign('des_estatus',$des_estatus);
$smarty ->assign('vopc',$vopc);
$smarty ->assign('fplanilla',$fplanilla);
$smarty ->assign('ffonetica',$ffonetica);
$smarty ->assign('fcedula',$fcedula);
$smarty ->assign('fpoder',$fpoder);
$smarty ->assign('freglamento',$freglamento);
$smarty ->assign('fprioridad',$fprioridad);
$smarty ->assign('fcronologia',1);
$smarty ->assign('fgrafica',$fgrafica);
$smarty ->assign('frif',$frif);
$smarty ->assign('fmercantil',$fmercantil);
$smarty ->assign('fasamblea',$fasamblea);
$smarty ->assign('fotros',$fotros);
$smarty ->assign('ftasa',$ftasa);
$smarty ->assign('fescritos',$fescritos);
$smarty ->assign('fcertificado',$fcertificado);
$smarty ->assign('planilla','/planilla/pl'.$varsol1.'/');
$smarty ->assign('fonetica','/fonetica/ef'.$varsol1.'/');
$smarty ->assign('grafica','/grafica/ef'.$varsol1.'/');
$smarty ->assign('cedula','/cedula/ef'.$varsol1.'/');
$smarty ->assign('rif','/rif/ef'.$varsol1.'/');
$smarty ->assign('poder','/poder/ef'.$varsol1.'/');
$smarty ->assign('mercantil','/mercantil/ef'.$varsol1.'/');
$smarty ->assign('reglamento','/reglamento/ef'.$varsol1.'/');
$smarty ->assign('asamblea','/asamblea/ef'.$varsol1.'/');
$smarty ->assign('prioridad','/prioridad/ef'.$varsol1.'/');
$smarty ->assign('escritos','/escritos/ef'.$varsol1.'/');
$smarty ->assign('certificado','/certificado/ef'.$varsol1.'/');
$smarty ->assign('tasa','/tasa/ef'.$varsol1.'/');
$smarty ->assign('otros','/otros/ef'.$varsol1.'/');
$smarty->assign('campo1','Nro. Expediente:');
$smarty->assign('varfocus','forcronol.vsol1'); 
$smarty->display('m_rptpexp1_esc.tpl');
$smarty->display('pie_pag.tpl');
?>
