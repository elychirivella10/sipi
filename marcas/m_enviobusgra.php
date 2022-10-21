<?php
// *************************************************************************************
// Programa: m_enviobus2.php 
// Realizado por el Analista de Sistema Ing. Romulo Mendoza
// Coordinación de Informática / Dirección de Soporte Administrativo / SAPI / MICO
// Fecha: II Semestre 2010 
// *************************************************************************************

//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");

if (($_SERVER['HTTP_REFERER']=="")) {
  echo "Acceso Denegado..."; exit();
}

//Variables
$usuario  = trim($_SESSION['usuario_login']);
$fechahoy = hoy();
$fecha    = fechahoy();
$tbname_1 = "stmcntrl";
$tbname_2 = "stzhistra";
$tbname_3 = "stmbusweb";
$modulo   = "m_enviobus.php";
$vopc     = $_GET['vopc'];

//Encabezado
$smarty->assign('titulo',$titulo);
$smarty->assign('login',$usuario);
$smarty->assign('fechahoy',$fecha);
$smarty->display('encabezado2.tpl');

echo "<table border='0' cellpadding='0' cellspacing='0' class='titulo_marca'>";
echo " <td>";
echo "   <i><b><font>ReCarga de B&uacute;squedas Gr&aacute;ficas del 08/11/2017</font></b></i>";
echo " </td>";
echo "</table>"; 

$smarty->assign('campo1','N&uacute;mero de Tr&aacute;mite:');
$smarty->assign('campo2','Fecha hoy de Carga:');
$smarty->assign('campod',' desde:');
$smarty->assign('campoh',' hasta:');


if ($vopc==1) {
  $smarty->assign('varfocus','forsolpre.recibo'); 
}

if ($vopc==2) {

  //Validacion de Entrada
  $desdec  = trim($_POST["fecsold"]); 

  //Procesamos y generamos el Archivo para Busquedas GRAFICAS
  //$numerror  = 0;
  $queryg="SELECT * FROM stztramite,stmbugra,stzusuar WHERE tipo_tram IN ('BG','BM')
            AND stztramite.nro_tramite=stmbugra.nro_tramite 
            AND stzusuar.usuario=stztramite.usuario
            AND $where 
          ORDER BY stztramite.nro_tramite,stmbugra.nro_busgra";

  $queryg="SELECT * FROM stmbusweb WHERE (nro_pedido>=124543 AND nro_pedido<=124598) AND fecha_carga='08/11/2017' AND tipo_busq='G' ORDER BY nro_pedido";

  //Ejecuto la Consulta 
  //Verificando conexion
  $sql = new mod_db();
  $sql->connection();

  $obj_query = $sql->query($queryg);
  $cantreg = $sql->nums('',$obj_query);
  //echo " son $cantreg ";

  if ($cantreg==0) {
    $mensaje=$mensaje."No existen pedidos externos Graficos...!!!"; }
  else {
    $archivo = "";
    $pagina  = 0;		
    $sede    = '3';
    $monto   = 3000.00;
    $usuario = "admwebpi";
    $horactual= Hora();
    $fechahoy  = Hoy();

    //Verificando Segunda conexion
    $sql1 = new mod_db();
    $sql1->connection1();

    $ruta_original = $imagen_path."/";
    $ruta_final    = $img_ext_busq."/";

    $horactual=hora();
    $objs = $sql->objects('',$obj_query);
    for($i=0;$i<$cantreg;$i++) { 
      $ntram    = trim($objs->nro_tramite);
      $ngraf    = $objs->nro_busgra;
      $fechatra = $objs->f_tramite;
      $horatra  = $objs->h_tramite;
      $interesado = trim($objs->apellidos)." ".trim($objs->nombres);
      $fechaing   = $objs->fechaing;
      $identifica = trim($objs->cedula);
      $indole   = "N";
      $logotipo = trim($objs->archivo_logo);
      $telefono = trim($objs->telefonoh);
      $clase    = $objs->clase;
      $solicitante = str_replace("'","`",$interesado);
      $cuenta  = trim($objs->usuario); 
      $factura = "T".str_pad($ntram,7,'0',STR_PAD_LEFT); 

      //Generacion del Nuevo Numero de Pedido segun SIPI 
      //$objquery = $sql->query("update stzsystem set figurativo=nextval('stzsystem_figurativo_seq')");
      //$objquery = $sql->query("select last_value from stzsystem_figurativo_seq");
      //$objsys   = $sql->objects('',$objquery);
      //$vauxnum  = $objsys->last_value;
      $imgfinal = $ruta_final.trim($vauxnum).".jpg"; //cambiar a png
      $cmd = "cp $logotipo $imgfinal";
      //echo "$cmd";
      exec($cmd,$salida);
      foreach($salida as $line) { 
      echo "Hola<br>";	
      echo "$line<br>"; }    

      $insbusq    = true;
      $insert_str = "'$vauxnum','$factura','$fechatra','$horatra','$solicitante','$fechahoy','1','$usuario','$logotipo','N','$identifica','$indole','$telefono','3',$clase"; 
      $insbusq    = $sql1->insert1("$tbname_1","","$insert_str","");

      $insweb = true;
      $columnas_str = "usuario,nro_tramite,tipo_busq,ref_busq,estado,clase,fecha_bus,solicitante,nro_pedido,fecha_carga,hora_carga,user_carga";

      $insert_str = "'$cuenta','$ntram','G','$ngraf','1',$clase,'$fechatra','$interesado','$vauxnum','$fechahoy','$horactual','$usercarga'"; 
      $insweb = $sql1->insert1("$tbname_3","$columnas_str","$insert_str","");

      $inshis    = true;
      if (($insbusq) AND ($actbusq) AND ($inshis)) { }
      else { $numerror = $numerror + 1; }

      $objs = $sql->objects('',$obj_query); 
    }

    if ($numerror==0) {
      pg_exec("COMMIT WORK");
      //Desconexion de la Base de Datos
      $sql1->disconnect1();
    }
    else {
      pg_exec("ROLLBACK WORK");
      //Desconexion de la Base de Datos
      $sql1->disconnect1(); 
    }
    		
  } 

  $cmd="scp -P 3535 ".$img_ext_busq."/*.* www-data@172.16.0.30:".$logbext_path;
  exec($cmd,$salida);
  foreach($salida as $line) { 
  echo "Holaa<br>";	
  echo "$line<br>"; }


  Mensajenew('Proceso Terminado ...!!!','../index1.php','S');
  $smarty->display('pie_pag.tpl'); exit();
}

$smarty->display('m_enviobusgra.tpl');
$smarty->display('pie_pag.tpl');
?>
