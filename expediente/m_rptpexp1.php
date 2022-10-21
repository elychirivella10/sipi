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
$modulo= "m_rptpexp.php";

$conx   = $_GET['conx']; 
$nconex = $_GET['nconex'];
$salir  = $_GET['salir']; 

$varsol1=$_POST["vsol1"];
$varsol2=$_POST["vsol2"];
$varsol=($varsol1.'-'.$varsol2);

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
   $smarty->assign('subtitulo','Consulta de Expediente Electr&oacute;nico');
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
$smarty->assign('name22',$name22);
$smarty->assign('name32',$name32);
$smarty->assign('name33',$name33);   
$smarty->assign('fpub_prensa22',$fpub_prensa22);
$smarty->assign('fpub_prensa32',$fpub_prensa32);
$smarty->assign('fpub_prensa33',$fpub_prensa33);
$smarty->assign('titulo',$substmar);
$smarty->assign('subtitulo','Consulta de Expediente Electr&oacute;nico');
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
$smarty->assign('campo1','Nro. Expediente:');
$smarty->assign('varfocus','forcronol.vsol1'); 
$smarty->display('m_rptpexp1.tpl');
$smarty->display('pie_pag.tpl');
?>
