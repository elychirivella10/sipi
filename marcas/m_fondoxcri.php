<?php
//Para trabajar con Operaciones de Bases de Datos
include ("../setting.inc.php");
//Comienzo del Programa por los encabezados del reporte
//ob_start();
include ("../z_includes.php");

//Variable de sesion
if (($_SERVER['HTTP_REFERER'] == "")){
  echo "Acceso Indebido";
  exit();
}

$login = $_SESSION['usuario_login'];
$fecha   = fechahoy();

//Encabezados de pantalla
$smarty->assign('titulo',$substmar); 
$smarty->assign('subtitulo','Generaci&oacute;n de Archivo TXT para realizar B&uacute;squeda Fonetica para Forma/Fondo por Criterio');
$smarty->assign('login',$login);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado1.tpl');

//Validacion de Entrada
$desde=$_POST["desdec"];
$hasta=$_POST["hastac"];
$desdet=$_POST["desdet"];
$hastat=$_POST["hastat"];
$evento=$_POST["evento"];
$eventoplus=$_POST["eventoplus"];
$claseplus=$_POST["claseplus"];
$vplus=$_POST["vplus"];
$cplus=$_POST["cplus"];
$usuario=$_POST["usuario"];
$estatus=$_POST["estatus"];
$estatusant=$_POST["estatusant"];
$boletin1=$_POST["boletin1"];
$boletin2=$_POST["boletin2"];
if (empty($boletin2)) {$boletin2=$boletin1;}
$modalidad=$_POST["modalidad"];
$indole=$_POST["indole"];
$orden = $_POST["orden"];

//PDF Encabezados
$encab_principal= "Sistema de Marcas";
$encabezado= "Listado";

//Query para buscar las opciones deseadas
$where='';
$titulo='';
$fechahoy = Hoy();

$esmayor=compara_fechas($desde,$hasta);
if ($esmayor==1) {
     $smarty->display('encabezado1.tpl');
     mensajenew('ERROR: Rango de Fechas erroneo ...!!!','javascript:history.back();','N');    
     $smarty->display('pie_pag.tpl'); exit(); }

if(!empty($desde) and !empty($hasta)) { 
	if(!empty($where)) {
	   $where = $where." and"." ((stzevtrd.fecha_trans >= '$desde') and (stzevtrd.fecha_trans <='$hasta'))";
	   $titulo= $titulo." Fecha Trans:"."$desde"." al: "."$hasta";
	}
	else { 
		$where = $where." ((stzevtrd.fecha_trans >= '$desde') and (stzevtrd.fecha_trans <='$hasta'))";
      $titulo= $titulo." Fecha Trans:"."$desde"." al: "."$hasta";
	}
}

$esmayor=compara_fechas($desdet,$hastat);
if ($esmayor==1) {
     $smarty->display('encabezado1.tpl');
     mensajenew('ERROR: Rango de Fechas erroneo ...!!!','javascript:history.back();','N');    
     $smarty->display('pie_pag.tpl'); exit(); }

if(!empty($desdet) and !empty($hastat)) { 
	if(!empty($where)) {
	   $where = $where." and"." ((stzevtrd.fecha_event >= '$desdet') and (stzevtrd.fecha_event <='$hastat'))";
	   $titulo= $titulo." Fec Evento:"."$desdet"." al: "."$hastat";
	}
	else { 
		$where = $where." ((stzevtrd.fecha_event >= '$desdet') and (stzevtrd.fecha_event <='$hastat'))";
      $titulo= $titulo." Fec Evento:"."$desdet"." al: "."$hastat";
	}
}
if(!empty($evento)) { 
   $evento1=$evento-1000;
	if(!empty($where)) {
	   $where = $where." and"." (stzevtrd.evento = '$evento')";
 	   $titulo= $titulo." Evento:"."$evento1";
	}
	else { 
		$where = $where." (stzevtrd.evento = '$evento')";
 	   $titulo= $titulo." Evento:"."$evento1";
	}
}
if(!empty($usuario)) { 
	if(!empty($where)) {
	   $where = $where." and"." (stzevtrd.usuario = '$usuario')";
  	   $titulo= $titulo." Usuario:"."$usuario";  
	}
	else { 
		$where = $where." (stzevtrd.usuario = '$usuario')";
 	   $titulo= $titulo." Usuario:"."$usuario";
	}
}
if(!empty($estatus) and ($estatus!='0')) {
	if(!empty($where)) {
	   $where = $where." and"." (stzderec.estatus = '$estatus')";
           $estatus1=$estatus-1000;
  	   $titulo= $titulo." Estatus:"."$estatus1";
	}
	else { 
		$where = $where." (stzderec.estatus = '$estatus')";
           $estatus1=$estatus-1000;
  	   $titulo= $titulo." Estatus:"."$estatus1";
	}
}
if(!empty($estatusant) and ($estatusant!='0')) {
	if(!empty($where)) {
	   $where = $where." and"." (stzevtrd.estat_ant = '$estatusant')";
           $estatus2=$estatusant-1000;
  	   $titulo= $titulo." Estatus Anterior:"."$estatus2";
	}
	else { 
		$where = $where." (stzevtrd.estat_ant = '$estatusant')";
           $estatus2=$estatusant-1000;
  	   $titulo= $titulo." Estatus Anterior:"."$estatus2";
	}
}
if(!empty($boletin1)) { 
	if(!empty($where)) {
	   $where = $where." and"." (stzevtrd.documento >= '$boletin1' and stzevtrd.documento <= '$boletin2')";
  	   $titulo= $titulo." Boletin:"."$boletin1"." al:"."$boletin2";
	}
	else { 
		$where = $where." (stzevtrd.documento >= '$boletin1' and stzevtrd.documento <= '$boletin2')";
  	   $titulo= $titulo." Boletin:"."$boletin1"." al:"."$boletin2";
	}
}

if(!empty($modalidad)) { 
	if(!empty($where)) {
	   $where = $where." and"." (position(stmmarce.modalidad in upper('$modalidad')) > 0)";
  	   $titulo= $titulo." Modalidad:"."$modalidad";
	}
	else { 
		$where = $where." (position(stmmarce.modalidad in upper('$modalidad')) > 0)";
  	   $titulo= $titulo." Modalidad:"."$modalidad";
	}
}

if(!empty($claseplus)) { 
      if(!empty($where)) {
         if ($cplus==2) {
            $where = $where." and"." (not (stmmarce.clase = '$claseplus' and ind_claseni='I'))";
            $titulo= $titulo." Distinto a la Clase Internacional:"."$claseplus";
         } else {
            $where = $where." and"." (stmmarce.clase = '$claseplus' and ind_claseni='I')";
            $titulo= $titulo." Igual a la Clase Internacional:"."$claseplus";
         }
      }
      else { 
         if ($cplus==2) { 
            $where= $where." (not (stmmarce.clase = '$claseplus' and ind_claseni='I'))";
            $titulo= $titulo." Distinto a la Clase Internacional:"."$claseplus";
         } else {
            $where= $where." (stmmarce = '$claseplus' and ind_claseni='I')";
            $titulo= $titulo." Igual a la Clase Internacional:"."$claseplus";
         }
      }
}

if(!empty($eventoplus)) { 
      $eventoplus1=$eventoplus-1000;
      if(!empty($where)) {
         if ($vplus==2) {
            $where = $where." and"." (stzderec.nro_derecho not in (select nro_derecho from stzevtrd where evento = '$eventoplus'))";
            $titulo= $titulo." Sin Evento Adicional:"."$eventoplus1";
         } else {
            $where = $where." and"." (stzderec.nro_derecho in (select nro_derecho from stzevtrd where evento = '$eventoplus'))";
            $titulo= $titulo." Con Evento Adicional:"."$eventoplus1";
         }
      }
      else { 
         if ($vplus==2) { 
            $where= $where." (stzderec.nro_derecho not in (select nro_derecho from stzevtrd where evento = '$eventoplus'))";
            $titulo= $titulo." Sin Evento Adicional:"."$eventoplus1";
         } else {
            $where= $where." (stzderec.nro_derecho in (select nro_derecho from stzevtrd where evento = '$eventoplus'))";
            $titulo= $titulo." Con Evento Adicional:"."$eventoplus1";
         }
      }
}

//Conexion 
$sql = new mod_db();
$sql->connection($login);

//  Armando el query
//  Borrado del query a peticion de nelson DISTINCT ON(stmmarce.solicitud)
//  Se condiciono el select y el order by porque cuando no se indica un evento
//  se trae todos los eventos de stmevtrd. 

//  Borrado del query por problema en los eventos cargados por sandra DISTINCT ON(stmmarce.solicitud) 25/07/2013
//if (empty($evento)) {$select = "SELECT DISTINCT ON (stzderec.solicitud) ";
//                     $orderby= "stzderec.solicitud"; }

//$select = "SELECT ";
$select = "SELECT DISTINCT ON (stzderec.solicitud) stzderec.solicitud ";
$orderby = "stzderec.solicitud";

//if (empty($orden)) { 
//  if (!empty($evento)) { $select = "SELECT DISTINCT ON (stzderec.solicitud) "; }   
//}

//stzevtrd.documento
//if (empty($evento)) {$select = "SELECT ";
//                     $orderby= "stzderec.solicitud"; }
//else {$select = "SELECT ";
//      //$orderby= "stzevtrd.documento, stzderec.solicitud"; 
//      $orderby= "stzderec.solicitud"; 
//}

//$qquery = "$select stzderec.solicitud  
//						FROM  stmmarce, stzevtrd, stzderec
//						WHERE $where 
//						AND stzevtrd.nro_derecho = stzderec.nro_derecho
//						AND stzderec.nro_derecho=stmmarce.nro_derecho
//						AND stzderec.tipo_mp = 'M'
//						ORDER BY $orderby";
//$resultado=pg_exec($select." stzderec.solicitud
						
//$qquery ="$select FROM  stmmarce, stzevtrd, stzderec
//						WHERE $where 
//						AND stzevtrd.nro_derecho = stzderec.nro_derecho
//						AND stzderec.nro_derecho=stmmarce.nro_derecho
//						AND stzderec.tipo_mp = 'M'
//						ORDER BY $orderby";

//echo "$qquery  "; 
						
$resultado=pg_exec($select." 
						FROM  stmmarce, stzevtrd, stzderec
						WHERE $where 
						AND stzevtrd.nro_derecho = stzderec.nro_derecho
						AND stzderec.nro_derecho=stmmarce.nro_derecho
						AND stzderec.tipo_mp = 'M'
						ORDER BY ".$orderby);	
 
//verificando los resultados
if (!$resultado)    { 
     mensajenew('ERROR: Problema al Procesar la Busqueda ...!!!','javascript:history.back();','N');
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }
$filas_found=pg_numrows($resultado); 
if ($filas_found==0)    {
     mensajenew('ERROR: No existen Datos Asociados ...!!!','javascript:history.back();','N');
     $smarty->display('pie_pag.tpl'); $sql->disconnect(); exit(); }

//$registro = pg_fetch_array($resultado);
//$filas_resultado=pg_numrows($resultado); 

 $separador="|";
 //RUTA Para el archivo TXT 
 $via= "../../";
 $via1= "pedidosexternos/";
 $filesal = 'fondosol.txt';
 //Genero el archivo TXT 
 $open = fopen($via.$via1.$filesal,"w+") or die ("Error de lectura");

 //Genero el listado segun la petición
 //$query = "SELECT stzderec.solicitud FROM stzderec,stmmarce WHERE $where ORDER BY 1"; 
 //Ejecuto la Consulta 
 //$resultado=pg_exec($query);
 //$cantreg = pg_numrows($resultado);

   $archivo="";				    	
   $npag = 0;	
   while ($registro=pg_fetch_array($resultado)){
     $vsol = $registro['solicitud'];
     $vanno = substr($vsol,2,2); 
     $vnumero=substr($vsol,-6,6);
     $vexp = $vanno.'-'.$vnumero;  
     $archivo = $archivo.$vexp.$separador.$separador.$fechahoy.$separador.$npag.$separador.$login."\n";
   } 
   //Lo escribo en el TXT
   fputs($open, "$archivo");
   fclose($open);		

 $cmd="scp /var/www/apl/pedidosexternos/fondosol.txt www-data@192.8.18.19:/home/taquilla/"; 
 exec($cmd,$salida);
 foreach($salida as $line) { 
 echo "Holaa<br>";	
 echo "$line<br>"; }

//Desconexion a la base de datos
 $sql->disconnect();
 
 
 Mensajenew("TOTAL SOLICITUDES GENERADAS: ".$filas_found,"m_fondotxtcri.php",'S');
 $smarty->display('pie_pag2.tpl');
 exit();  

?>
