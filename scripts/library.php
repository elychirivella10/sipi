<?php
 function mensaje($vmessage,$vurl) {
   echo "<H3><p align='center'>$vmessage</p></H3>"; 
   echo "<p align='center'><a href='$vurl'><img src='../imagenes/restore_f2.png' border='0'></a>  Volver  </p>";
 } 

 function mensajenew($vmessage,$vurl,$valido) {
   if ($valido=='N') 
     {echo "<H3><p><img src='../imagenes/messagebox_warning.png' align='middle'>  $vmessage</p></H3>"; 
      echo "<p align='center'><a href='$vurl'><img src='../imagenes/restore_f2.png' border='0' onclick='javascript:history.back()' ></a>  Volver  </p>";}
   if ($valido=='S') 
     {echo "<H3><p><img src='../imagenes/messagebox_info.png' align='middle'>  $vmessage</p></H3>"; 
      echo "<p align='center'><a href='$vurl'><img src='../imagenes/apply_f2.png' border='0'></a>  Continuar  </p>";}
 } 

 function mensajebrowse($vmessage,$vurl) {
   echo "<H3><p align='center'>$vmessage</p></H3>"; 
   echo "<p align='center'><input type='button' name='button' value='Aceptar' onclick=\"cerrarwindows();location.href='$vurl'\"></p>";
 }

 function continuar($vmessage,$opc1,$opc2,$vurl1,$vurl2) {
   echo "<H3><p><img src='../imagenes/messagebox_warning.png' align='middle'>  $vmessage</p></H3>"; 
   echo "<p align='center'><a href='$vurl1'><img src='../imagenes/apply_f2.png' border='0'></a>  $opc1  <a href='$vurl2'><img src='imagenes/cancel_f2.png' border='0'></a>  $opc2 </p>";
   // echo "<p align='center'><input type='button' name='button' value='$opc1' onclick=\"location.href='$vurl1'\">     <input type='button' name='button' value='$opc2' onclick=\"location.href='$vurl2'\"></p>";
 } 

 //Muestra el Mensaje de Error suministrado como parametro
 function MensageError($mensaje,$valido)
 {
   if (!empty($mensaje))
   {
     if ($valido=='N') {
       echo "<H3><p><img src='../imagenes/messagebox_warning.png' align='middle'><b> $mensaje </b></p></H3>"; 
       //echo "<p align='center'><img src='imagenes/restore_f2.png' border='0'> Volver </p>";
       //onclick='javascript:history.back()' 
       echo "<p align='center'><input type='image' name='aceptar' value='Aceptar' src='../imagenes/restore_f2.png' onclick='javascript:history.back()' alt='Aceptar' align='middle' border='0' />";
     }
   }
   else {
     echo "<H3><p align='center'><b>Error: En el pase de parametros de la funcion de Mensaje de Error... </b>\n</H3>"; 
   }
 }

 //Muestra el Mensaje de Error suministrado como parametro
 function Mensage_Error($mensaje)
 {
   if (!empty($mensaje))
   {
     echo "<H3><p align='center'><b>Error: $mensaje</b></p></H3>"; 
     echo "<p align='center'><input type='button' name='button' value='Aceptar' onclick='javascript:history.back()'></p>";
   }
   else {
     echo "<H3><p align='center'><b>Error: En el pase de parametros de la funcion de Mensaje de Error... </b>\n</H3>"; 
   }
 }

 //Muestra el Mensaje de Error suministrado como parametro
 function MsgErrorCerrar($mensaje)
 {
   if (!empty($mensaje)) {
     echo "<H3><p><img src='../imagenes/messagebox_warning.png' align='middle'>Error: $mensaje</p></H3>"; 
     //echo "<p align='center'><input type='image' name='cerrar' value='Cerrar' src='../imagenes/salir_f2.png' onclick='window.close()' alt='cerrar' align='middle' border='0' />&nbsp;Cerrar&nbsp;&nbsp;</p>";
     echo "<p align='center'><input type='image' name='cerrar' value='Cerrar' src='../imagenes/apply_f2.png' onclick='window.close()' alt='cerrar' align='middle' border='0' />&nbsp;&nbsp;Continuar&nbsp;&nbsp;</p>";
   }
 }

 // Funcion que dependiendo del boton que presione, ejecuta un programa
 function mensaje2($vmessage,$vurl,$vurl2) {
   //echo "<H3><p align='center'>$vmessage</p></H3>"; 
   //echo "<p align='center'><input type='button' name='button' value='Aceptar' onclick=\"location.href='$vurl'\">
   //                        <input type='button' name='button' value='Imprimir' onclick=\"location.href='$vurl2'\"></p>";
   echo "<H3><p><img src='../imagenes/messagebox_info.png' align='middle'>$vmessage</p></H3>"; 
   echo "<p align='center'><a href='$vurl'><img src='../imagenes/apply_f2.png' border='0'></a>  Continuar&nbsp;&nbsp;&nbsp;&nbsp;<a href='$vurl2'><img src='../imagenes/printmgr.png' border='0'></a> Imprimir </p>";
 } 

 // Funcion que dependiendo del boton que presione, ejecuta un programa
 function mensaje3($vmessage,$vurl,$vurl2,$vurl3) {
   echo "<H3><p><img src='../imagenes/messagebox_info.png' align='middle'>$vmessage</p></H3>"; 
   echo "<p align='center'><a href='$vurl'><img src='../imagenes/apply_f2.png' border='0'></a>  Continuar&nbsp;&nbsp;&nbsp;&nbsp;<a href='$vurl2'><img src='../imagenes/printmgr.png' border='0'></a> Mostrar/Imprimir <a href='$vurl3'><img src='../imagenes/printmgr.png' border='0'></a> Mostrar/Imprimir S/Resultado </p>";
 } 

 // Funcion que dependiendo del boton que presione, ejecuta un programa
 function mensaje4($vmessage,$vurl,$vurl2) {
   echo "<H3><p><img src='../imagenes/messagebox_info.png' align='middle'>$vmessage</p></H3>"; 
   echo "<p align='center'><a href='$vurl'><img src='../imagenes/apply_f2.png' border='0'></a>  Continuar&nbsp;&nbsp;&nbsp;&nbsp;<a href='$vurl2'><img src='../imagenes/printmgr.png' border='0'></a> Mostrar/Imprimir </p>";
 } 

 function tipo_de_marca($var) {
   if ($var>0  && $var<35) {return "P";}
   if ($var>34 && $var<46) {return "S";}
   if ($var==46) {return "N";}
   if ($var==47) {return "L";} 
 }

 // Funcion que permite llevar la fecha de numeros a letras
 function Cambiar_fecha_mes($fechaini)
 {
   $dia=substr($fechaini,0,2);
   $mes=substr($fechaini,3,2);
   $anio=substr($fechaini,6,4);
   if ($mes=='01') {$mes=' DE ENERO DE ';}
   if ($mes=='02') {$mes=' DE FEBRERO DE ';}
   if ($mes=='03') {$mes=' DE MARZO DE ';}
   if ($mes=='04') {$mes=' DE ABRIL DE ';}
   if ($mes=='05') {$mes=' DE MAYO DE ';}
   if ($mes=='06') {$mes=' DE JUNIO DE ';}
   if ($mes=='07') {$mes=' DE JULIO DE ';}
   if ($mes=='08') {$mes=' DE AGOSTO DE ';}
   if ($mes=='09') {$mes=' DE SEPTIEMBRE DE ';}
   if ($mes=='10') {$mes=' DE OCTUBRE DE ';}
   if ($mes=='11') {$mes=' DE NOVIEMBRE DE ';}
   if ($mes=='12') {$mes=' DE DICIEMBRE DE ';}
   $fecha=$dia.$mes.$anio;
   return $fecha;
 }

 //Retorna la Descripcion del Estatus 
 function estatus($estatus)
 {
   $descripcion = "";
   $res_estatus=pg_exec("SELECT * FROM stzstder WHERE estatus='$estatus'");
   $restat = pg_fetch_array($res_estatus);
   $descripcion= $restat['descripcion'];
   return $descripcion;
 }

 //Retorna la Descripcion del Evento 
 function desc_evento($evento)
 {
   $descripcion = "";
   $res_evento=pg_exec("SELECT * FROM stzevder WHERE evento='$evento'");
   if ($res_evento) {
     $filas_found=pg_numrows($res_evento);
     if ($filas_found!=0) {
       $reseve = pg_fetch_array($res_evento);
       $descripcion= $reseve['descripcion']; }
   }    
   return $descripcion;
 }

 //Retorna el Nombre del Paises 
 function pais($pais)
 {
   $res_pais=pg_exec("SELECT * FROM stzpaisr WHERE pais='$pais' and pais!=''");
   $respai = pg_fetch_array($res_pais);
   $pais_nombre=trim(sprintf($respai['nombre']));
   return $pais_nombre;
 }

 //Modalida de marca
 function modalida_marca($var) {
   if ($var=='D') {return "DENOMINATIVA";}
   if ($var=='M') {return "MIXTA";}
   if ($var=='G') {return "GRAFICA";}
 }

 //Retorna el Tipo de Marca en Letra 
 function tipo_marcac($var) {
	if ($var=='MARCA DE PRODUCTO')      {return "M";}
	if ($var=='NOMBRE COMERCIAL')       {return "N";}
	if ($var=='LEMA COMERCIAL')         {return "L";}
	if ($var=='MARCA DE SERVICIO')      {return "S";}
	if ($var=='MARCA COLECTIVA')        {return "C";}
	if ($var=='DENOMINACION DE ORIGEN') {return "D";}
 }
 
 //Retorna el tipo de marca en palabra 
 function tipo_marca($var) {
   if ($var=='M') {return "MARCA DE PRODUCTO";}
   if ($var=='N') {return "NOMBRE COMERCIAL";}
   if ($var=='L') {return "LEMA COMERCIAL";}
   if ($var=='S') {return "MARCA DE SERVICIO";}
   if ($var=='C') {return "MARCA COLECTIVA";}
   if ($var=='D') {return "DENOMINACION DE ORIGEN";}
 }

 //Retorna el Indicador de clases en palabras  
 function ind_clase($var) {
   if ($var=='N') {return "NACIONAL";}
   if ($var=='I') {return "INTERNACIONAL";}
 }

 //Retorna el Nombre del agente o tramitante 
function agente_tram($nagen,$reg_tramit,$ind)
{       $res_agen=pg_exec("SELECT * FROM stzagenr WHERE agente='$nagen'");
	$regage = pg_fetch_array($res_agen);
	if ($regage['agente']<=0)
           { $tram = trim(sprintf($reg_tramit)); }
	if ($regage['agente']>0)
	   { $tram= "Codigo: ".$regage['agente']." ".trim(sprintf($regage['nombre']));
	     if ($ind==1) { $tram= trim(sprintf($regage['nombre']));}
           }
return $tram;
}

 // Funcion que permite generar la ruta de la imagen asociada a una solicitud mixta o grafica de Marcas o Patentes 
 function ver_imagen($vsol1,$vsol2,$derecho)
 {
   $varsol=$vsol1.$vsol2;
   if ($derecho == "M")
    { $name="../graficos/marcas/ef".$vsol1."/".$varsol.".jpg"; }
   if ($derecho == "P")    
    { $name="../graficos/patentes/di".$vsol1."/".$varsol.".jpg"; }
   return $name;
 }

 // Funcion que permite generar el archivo txt para el menu dependiendo del rol
 function gen_txt($vrol) 
 {
   $resultado=pg_exec("SELECT * FROM stzrolmenu where role = '$vrol' ");
   $filas_found=pg_numrows($resultado); 
   $reg = pg_fetch_array($resultado);
   if ($filas_found==0)    {
      echo "<hr>";     
      echo "<p align='center'><b>Error: en tabla de sistema....!</b>\n"; 
      echo "<hr>";
    } 
   for($cont=0;$cont<$filas_found;$cont++)   {  
	$res_menu=pg_exec("SELECT * FROM stzmenu where codmenu = '$reg[codmenu]'");
	$reg_menu = pg_fetch_array($res_menu);
	$nomen=trim($reg_menu['nomenclatura']);
        $longitud=strlen($nomen);
        $ultimoc=substr($nomen,$longitud-3,$longitud);

    //if ($ultimoc=='php') {$archivo=$archivo.$nomen.'?vrol='.$vrol."\n"; } 
    if ($ultimoc=='php') {$archivo=$archivo.$nomen."\n"; } 
       else { $archivo=$archivo.$nomen."\n"; }
	$reg = pg_fetch_array($resultado);
   }
	//echo $archivo;
	$nombre=trim($vrol);
	//if (file_exists($vusuario.'.txt')) {
	$open = fopen('../roles/'.$nombre.'.txt',"w+") or die ("Error de lectura");
	fputs($open, "$archivo");
	fclose($open);
	//}
   //return $sys_act;
 }

 //Obtiene el actual número a incrementar de la tabla stzsystem, con solo pasar como string
 //el nombre del campo de la tabla 
 function next_sys($vtipo)
 {
   $sys_act="0";
   $ressys=pg_exec("SELECT * FROM stzsystem");
   $filasys_found=pg_numrows($ressys); 
   if ($filasys_found==0) 
    {
      echo "<hr>";     
      echo "<p align='center'><b>Error: en tabla de sistema con $vtipo....!</b>\n"; 
      echo "<hr>";
    }
   else 
    { 
      $sysact = pg_fetch_array($ressys); 
      $sys_act=$sysact[$vtipo];
    }
   return $sys_act;
 }

 //Incrementa en uno (1) el valor actual del campo de la tabla stzsystem, con solo pasar como 
 //string el nombre del campo de la tabla y su valor actual 
 function grabar_sys($vtipo,$valor)
 {
   $sys_sig=$valor+1; 
   $actualiza=pg_exec("UPDATE stzsystem SET $vtipo='$sys_sig'");
   return $sys_sig;
 }

 //Verifica que el valor actual suministrado sea menor o igual contra el valor del campo de la tabla
 function chequea_sol($valor,$tipo)
 {
   $vok = 0;
   $ressys=pg_exec("SELECT $tipo FROM stzsystem");
   $filasys_found=pg_numrows($ressys); 
   if ($filasys_found!=0) {
     $sysact = pg_fetch_array($ressys); 
     $sys_act=$sysact[$tipo];
     if ($valor > $sys_act) { $vok = 1; }
   }  
   return $vok;
 }

 //Obtiene el Role del Usuario, pasando como string el login o cuenta del usuario
 function user_rol($vusuario)
 {
   $rol_found="";
   if (!empty($vusuario))
   {
     $resroluse=pg_exec("SELECT * FROM stzuserol WHERE usuario='$vusuario'");
     $filasr_found=pg_numrows($resroluse); 
     if ($filasr_found==0) 
      {
        echo "<hr>";     
        echo "<p align='center'><b>Error: El Usuario No posee Rol Asignado....!</b>\n"; 
        echo "<hr>";
      }
     else { $usrol = pg_fetch_array($resroluse);
           $rol_found=$usrol['role'];
     }
   }
   return $rol_found;
 }

 //Verifica si el evento suministrado junto al rol del usuario le corresponde cargarlo
 function even_rol($vrol,$vevento)
 {
   $filasr_found=0;
   if (!empty($vrol) and !empty($vevento))
   {
     $resrolve=pg_exec("SELECT * FROM stzroleve WHERE role='$vrol' and evento='$vevento'");
     $filasr_found=pg_numrows($resrolve); 
   }
   return $filasr_found;
 }

 //Verifica si el Usuario existe o no 
 function Ex_user($vusuario)
 {
   $filasu_found=0;
   if (!empty($vusuario))
   {
     $resuse=pg_exec("SELECT * FROM stzusuar WHERE usuario='$vusuario'");
     $filasu_found=pg_numrows($resuse); 
   }
   return $filasu_found;
 }

 //Obtiene el Estado de la Base de Datos 
 function Edo_bd()
 {
   $edo_found="";
   $resedo=pg_exec("SELECT * FROM stzedobd");
   $filasr_found=pg_numrows($resedo); 
   if ($filasr_found==0) 
    {
      echo "<hr>";     
      echo "<p align='center'><b>Error: Estado de Base de Datos desconocido....!</b>\n"; 
      echo "<hr>";
    }
   else { $bdedo = pg_fetch_array($resedo);
       $edo_found=$bdedo['estado'];
   }
   return $edo_found;
 }

 //Verifica si un modulo esta en mantenimiento o NO 
 function vman_php($vmodulo)
 {
   $filasr_found=0;
   if (!empty($vmodulo))
   {
     $resphp=pg_exec("SELECT * FROM stzphpman WHERE modulo='$vmodulo' and estado='1'");
     $filasr_found=pg_numrows($resphp);
   }
   return $filasr_found;
 }

 //Obtiene el Estatus Final a partir del Estatus Inicial y Evento dado
 function estatus_final($evento,$estatus_ini,$derecho)
 {
   $est_fin_found="";
   $tbname = "stzmigrr";
   //echo "funcion=$evento,$estatus_ini,$derecho";
   //if ($derecho == "M")
   // { $tbname = "stzmigrr"; }
   //if ($derecho == "P")    
   // { $tbname = "stzmigrr"; }
   if ($derecho == "A")    
    { $tbname = "stdmigrr"; }
   if (!empty($estatus_ini))
   {
     if ($derecho == "A") {    
       $resesteve=pg_exec("SELECT estatus_fin FROM $tbname WHERE evento='$evento' AND (estatus_ini='$estatus_ini' or estatus_ini=888)"); }
     if ($derecho == "M") {    
       $resesteve=pg_exec("SELECT estatus_fin FROM $tbname WHERE evento='$evento' AND tipo_mp='$derecho' AND (estatus_ini='$estatus_ini' or estatus_ini=1888)"); }
     if ($derecho == "P") {    
       $resesteve=pg_exec("SELECT estatus_fin FROM $tbname WHERE evento='$evento' AND tipo_mp='$derecho' AND (estatus_ini='$estatus_ini' or estatus_ini=2888)"); }
       
     $filase_found=pg_numrows($resesteve); 
     if ($filase_found==0) 
      {
        //echo "<hr>";     
        //echo "<p align='center'><b>Error: No Existe Migración alguna para el Evento dado....!</b>\n"; 
        //echo "<hr>";
      }
     else { $estfin = pg_fetch_array($resesteve);
           $est_fin_found=$estfin['estatus_fin'];
     }
   }
   return $est_fin_found;
 }

 //Verifica si un evento determinado ya fue asignado a un Rol
 function Exroleve($rol,$evento,$derecho)
 {
   $eve_rol_found=0;
   $resevrol=pg_exec("SELECT * FROM stzroleve WHERE role='$rol' and evento='$evento' and tip_derecho='$derecho'");
   $eve_rol_found=pg_numrows($resevrol); 
   return $eve_rol_found;
 }

 //Verifica si un objeto determinado ya fue asignado a un Rol
 function Exrolobj($rol,$objeto)
 {
   $obj_rol_found=0;
   $resobrol=pg_exec("SELECT * FROM stzrolobj WHERE role='$rol' and formnombre='$objeto'");
   $obj_rol_found=pg_numrows($resobrol); 
   return $obj_rol_found;
 }

 //Verifica si un usuario posee Rol o no, pasando como string el login o cuenta del usuario
 function Verirolusr($vusuario)
 {
   $rol_found=0;
   if (!empty($vusuario))
   {
     $resroluse=pg_exec("SELECT * FROM stzusuar WHERE usuario='$vusuario'");
     $filasr_found=pg_numrows($resroluse); 
     if ($filasr_found!=0) { 
       $usrol = pg_fetch_array($resroluse);
       $nbrole= trim($usrol['role']);
       if (!empty($nbrole)) { $rol_found=1; }
     }
   }
   return $rol_found;
 }

 //Verifica si una opcion de menu determinado ya fue asignado a un Rol
 function Exrolmenu($rol,$opcion)
 {
   $eve_rol_found=0;
   $resevrol=pg_exec("SELECT * FROM stzrolmenu WHERE role='$rol' and codmenu='$opcion'");
   $eve_rol_found=pg_numrows($resevrol); 
   return $eve_rol_found;
 }

 //Obtiene el nombre del Usuario quien posea un expediente determinado
 function user_exp($vexp)
 {
   $user_found="";
   if (!empty($vexp))
   {
     $resuser=pg_exec("SELECT usuario FROM stmmarce WHERE solicitud='$vexp'");
     $filasr_found=pg_numrows($resuser); 
     $nusers = pg_fetch_array($resuser);
     $user_found=$nusers['usuario'];
   }
   return $user_found;
 }

 // Funcion q permite grabar los datos relacionados al acceso a un modulo  
 function insconex($nbusuario,$nbmodulo,$op)
 {  
   //Verificando conexion
   $tbname_1 = "stzconex";
   $sql      = new mod_db();
   $sql->connection($nbusuario);

   // La Fecha de Hoy y Hora para la transaccion
   $fechahoy = hoy();
   $horactual= Hora();

   // Comienzo de Transaccion 
   pg_exec("BEGIN WORK");

   //Inserto Datos en la tabla de conexion
   $col_campos = "conex,usuario,fecha_conex,modulo,oper,hora_entrada";
   $insert_str = "default,'$nbusuario','$fechahoy','$nbmodulo','$op','$horactual'";
   $ins_conx = $sql->insert("$tbname_1","","$insert_str","");
   
   $obj_query = $sql->query("select last_value from stzconex_conex_seq");
   $objs = $sql->objects('',$obj_query);
   $valor_seq=trim($objs->last_value);

   // Verificacion y actualizacion real de los Datos en BD 
   if ($ins_conx) {
     pg_exec("COMMIT WORK"); 
     //Desconexion de la Base de Datos
     $sql->disconnect();
     return $valor_seq;
   }
   else {
     pg_exec("ROLLBACK WORK");
     //Desconexion de la Base de Datos
     $sql->disconnect();
     return 0;
   }
 }

 // Funcion para actualizar la conexion ante una salida de un programa PHP
 function salirconx($conexion)
 {
   //Definicion de Variables 
   $tbname_1 = "stzconex";
   $sql      = new mod_db();

   //Verificando conexion 
   $sql->connection();

   // La Hora para la transaccion
   $horactual= date("h:i:s A");

   // Comienzo de Transaccion 
   pg_exec("BEGIN WORK");

   //Actualizo Datos en la tabla
   $update_str = "hora_salida='$horactual'";
   $act_conex = $sql->update("$tbname_1","$update_str","conex='$conexion'");

   // Verificacion y actualizacion real de los Datos en BD 
   if ($act_conex) {
     pg_exec("COMMIT WORK"); 
     //Desconexion de la Base de Datos
     $sql->disconnect();
     return true; 
   }    
   else {
     pg_exec("ROLLBACK WORK");
     //Desconexion de la Base de Datos
     $sql->disconnect(); 
     return false; 
   }
 }

 //Funcion que verifica si una Persona Natural o Juridica ya esta incluida en el temporal 
 function verifica_interesesado($nbtabla,$vsol,$vcod,$vtco='')
   {
     $filas_found=0;
     if ($vtco!='') {
       $resint=pg_exec("SELECT * FROM $nbtabla where solicitud='$vsol' and codigo='$vcod' and tipo_autor='$vtco'");
     } else {
       $resint=pg_exec("SELECT * FROM $nbtabla where solicitud='$vsol' and codigo='$vcod'");
     }
     $filas_found=pg_numrows($resint); 
     return $filas_found; 
   }

 //Guarda los datos relacionados a la Persona Natural o Juridico dependiendo del interesado
function guardar_interesado($dtipo,$vsol,$vder,$modo,$tipo_caracter='',$otro_caracter='',$prueba_repres='',$vnoedic='',$vanopue='',$vnoejem='',$vcar_ed='',$vtipoed='')
   {  

//Verificando conexion
  $sql  = new mod_db();
//   $sql->connection();

   switch ($dtipo) {
      case "Solicitante":
        $nbtabla="stdtmpso";
        $tabla="stdobsol";
        break;
      case "Productor":
        $nbtabla="stdtmppt"; 
        $tabla="stdobpro";
	break;
      case "Autor":
        $nbtabla="stdtmpau"; 
        $tabla="stdobaut";
        break;
      case "Coautor":
        $nbtabla="stdtmpco"; 
        $tabla="stdobaut";
	break;
      case "Artista":
        $nbtabla="stdtmpar"; 
        $tabla="stdobart";
        break;
      case "Titular":
        $nbtabla="stdtmpti"; 
        $tabla="stdobtit";
        break;
      case "Editor":
        $nbtabla="stdtmped"; 
        $tabla="stdedici";
        break;

   }
   $gbcorrecto=0;
   $tbnpjur= "stzdajur";
   $tbnpnat= "stzdaper";
   $tbnrepr= "stdrepre";
   $res_soli=pg_exec("SELECT * FROM $nbtabla where solicitud='$vsol'");
   $filas_res_soli=pg_numrows($res_soli); 
   if ($modo=='U') { $filas_res_soli=1; }
   $regsol = pg_fetch_array($res_soli);
   //$vn_pais = $regsol[pais];
   //$vn_domi = $regsol[domicilio]; 
   for($i=0;$i<$filas_res_soli;$i++) 
    { 
     $vtit=$regsol[codigo];
     $codigo=$regsol[ced_rif];   
     $vn_pais = $regsol[pais];
     $vn_domi = $regsol[domicilio]; 
     //$res_titnat=pg_exec("select * from stzsolic where titular='$codigo'");
     //$regtitnat = pg_fetch_array($res_titnat); 
     //$vtit=$regtitnat[titular];
     //$codigo=$regtitnat[identificacion];
     //$nombre = str_replace("'","`",$regsol[nombre]);
     if ($regsol[tipo_persona]=="N")
       {  
          $res_nat=pg_exec("SELECT * FROM stzsolic WHERE titular='$vtit'"); 
          $filas_natur=pg_numrows($res_nat);
          if ($regsol[estado_civil]=='') {$estc='S';} else {$estc=$regsol[estado_civil];}
          if ($filas_natur==0 and $regsol[pais]!='' and $regsol[domicilio]!='') {
            $col_campos = "identificacion,nombre,indole,telefono1,telefono2,fax,email";
            $insert_str = "'$codigo','$regsol[nombre]','$regsol[indole]',
                           '$regsol[telefono1]','$regsol[telefono2]','$regsol[fax]',
                           '$regsol[email]'";
            $valido = $sql->insert("stzsolic","$col_campos","$insert_str","");
            if (!$valido) {$gbcorrecto=$gbcorrecto+1;}
            //$res_titnat=pg_exec("select titular from stzsolic where identificacion='$codigo'");
            //$regtitnat = pg_fetch_array($res_titnat); 
            $res_vtitu=pg_exec("select last_value from stzsolic_titular_seq"); 
            $reg_vtitu = pg_fetch_array($res_vtitu); 
            $vtit=$reg_vtitu[last_value]; 
            $col_campos = "titular,estado_civil,profesion,seudonimo";
            $insert_str = "'$vtit','$estc','$regsol[profesion]','$regsol[seudonimo]'";
            if (!empty($regsol[fecha_nacim])) {
             $col_campos = $col_campos.",fecha_nacim";
             $insert_str = $insert_str.",'$regsol[fecha_nacim]'";
            }
            $valido = $sql->insert("stzdaper","$col_campos","$insert_str","");
            if (!$valido) {$gbcorrecto=$gbcorrecto+1;}
          }
       }
     else
       {
          $res_jur=pg_exec("SELECT * FROM stzsolic WHERE titular='$vtit'");
          $filas_juridr=pg_numrows($res_jur);
          if ($filas_juridr==0 and $regsol[pais]!='' and $regsol[domicilio]!='') {
            $col_campos = "identificacion,nombre,indole,telefono1,telefono2,fax,email";
            $insert_str = "'$codigo','$regsol[nombre]','$regsol[indole]',
                           '$regsol[telefono1]','$regsol[telefono2]','$regsol[fax]',
                           '$regsol[email]'";
            $valido = $sql->insert("stzsolic","$col_campos","$insert_str","");
            if (!$valido) {$gbcorrecto=$gbcorrecto+1;} 
            //$res_titnat=pg_exec("select titular from stzsolic where identificacion='$codigo'");
            //$regtitnat = pg_fetch_array($res_titnat); 
            $res_vtitu=pg_exec("select last_value from stzsolic_titular_seq"); 
            $reg_vtitu = pg_fetch_array($res_vtitu); 
            $vtit=$reg_vtitu[last_value]; 
            $col_campos = "titular,datos_registro,cedula_repre";
            $insert_str = "'$vtit','$regsol[datos_registro]','$regsol[cedula_repre]'";
            $valido = $sql->insert("stzdajur","$col_campos","$insert_str","");
            if (!$valido) {$gbcorrecto=$gbcorrecto+1;}
            // stdrepre
            $res_repre=pg_exec("select * from stdrepre where nro_derecho='$vderec' and
                                cedula_repre='$regsol[cedula_repre]' and
                                nombre_repre='$regsol[nombre_repre]'");
            $filas_repre=pg_numrows($res_repre); 
            if ($filas_repre==0) {
               $col_campos = "nro_derecho,cedula_repre,nombre_repre,cualidad_repre,prueba";
               $insert_str = "'$vder','$regsol[cedula_repre]','$regsol[nombre_repre]',
                              '$regsol[cualidad_repre]','$regsol[prueba]'";
               $valido = $sql->insert("$tbnrepr","$col_campos","$insert_str",""); 
               if (!$valido) {$gbcorrecto=$gbcorrecto+1;}
            }
          }
       }
     //$vtit=100;
     //$v_pais='VE';     
     if ($dtipo=='Solicitante') {
       $col_campos = "nro_derecho,titular,caracter,otro_caracter,prueba_repres,
                      domicilio,pais_resid";
       $insert_str = "'$vder','$vtit','$tipo_caracter','$otro_caracter',
                      '$prueba_repres','$vn_domi','$vn_pais'";            
       $valido = pg_exec("insert into stdobsol   
       (nro_derecho,titular,caracter,otro_caracter,prueba_repres,domicilio,pais_resid) values
      ('$vder','$vtit','$tipo_caracter','$otro_caracter','$prueba_repres','$vn_domi','$vn_pais')");
       //$valido = $sql->insert("$tabla","$col_campos","$insert_str","");
       if (!$valido) {$gbcorrecto=$gbcorrecto+1;} 
       //$del_dattmp= $sql->del("$nbtabla","solicitud='$vsol'");
     }
     if ($dtipo=='Productor') {
       $col_campos = "nro_derecho,doc_productor,domicilio,pais_resid,titular";
       $insert_str = "'$vder','$codigo','$vn_domi','$vn_pais','$vtit'";            
       $valido = pg_exec("insert into stdobpro
       (nro_derecho,doc_productor,domicilio,pais_resid,titular) values
       ('$vder','$codigo','$vn_domi','$vn_pais','$vtit')");
       // $valido = $sql->insert("$tabla","$col_campos","$insert_str",""); 
       if (!$valido) {$gbcorrecto=$gbcorrecto+1;}
       //$del_dattmp= $sql->del("$nbtabla","solicitud='$vsol'");
     }
     if ($dtipo=='Autor' || $dtipo=='Coautor') {
       if ($dtipo=='Autor') { $tipoautor='AU'; } 
       else { $tipoautor=$regsol[tipo_autor]; } 
       $col_campos = "nro_derecho,doc_autor,tipo_autor,domicilio,pais_resid,titular";
       $insert_str = "'$vder','$codigo','$tipoautor','$vn_domi','$vn_pais','$vtit'";            
       $valido = pg_exec("insert into stdobaut   
       (nro_derecho,doc_autor,tipo_autor,domicilio,pais_resid,titular) values
       ('$vder','$codigo','$tipoautor','$vn_domi','$vn_pais','$vtit')");
       // $valido = $sql->insert("$tabla","$col_campos","$insert_str",""); 
       if (!$valido) {$gbcorrecto=$gbcorrecto+1;}
       //$del_dattmp= $sql->del("$nbtabla","solicitud='$vsol'");
     }
     if ($dtipo=='Artista') {
       $col_campos = "nro_derecho,doc_artista,domicilio,pais_resid,titular";
       $insert_str = "'$vder','$codigo','$vn_domi','$vn_pais','$vtit'";
       $valido = pg_exec("insert into stdobart
       (nro_derecho,doc_artista,domicilio,pais_resid,titular) values
       ('$vder','$codigo','$vn_domi','$vn_pais','$vtit')");     
       // $valido = $sql->insert("$tabla","$col_campos","$insert_str",""); 
       if (!$valido) {$gbcorrecto=$gbcorrecto+1;}
       //$del_dattmp= $sql->del("$nbtabla","solicitud='$vsol'");
     }
     if ($dtipo=='Titular') {
       $titulolega = str_replace("'","`",$regsol[titulo_legal]);
       $doctransfe = str_replace("'","`",$regsol[doc_trans]);
       $col_campos = "nro_derecho,doc_titular,titulo_presun,doc_transfer,domicilio,pais_resid,titular";
       $insert_str = "'$vder','$codigo','$titulolega','$doctransfe',
                      '$vn_domi','$vn_pais','$vtit'";
       $valido = pg_exec("insert into stdobtit
       (nro_derecho,doc_titular,titulo_presun,doc_transfer,domicilio,pais_resid,titular) values
       ('$vder','$codigo','$titulolega','$doctransfe','$vn_domi','$vn_pais','$vtit')");
       // $valido = $sql->insert("$tabla","$col_campos","$insert_str",""); 
       if (!$valido) {$gbcorrecto=$gbcorrecto+1;}
       //$del_dattmp= $sql->del("$nbtabla","solicitud='$vsol'");
     }
     if ($dtipo=='Editor') {
       $col_campos = "nro_derecho,doc_edimpres,n_edicion,anno_publica,titular,
                         n_ejemplares,caracteristicas,editor_impres,domicilio,pais_resid";
       $insert_str = "'$vder','$codigo',$vnoedic,$vanopue,'$vtit',$vnoejem,'$vcar_ed',
                      '$vtipoed','$vn_domi','$vn_pais'";
       $valido = pg_exec("insert into stdedici
       (nro_derecho,doc_edimpres,n_edicion,anno_publica,titular,
                         n_ejemplares,caracteristicas,editor_impres,domicilio,pais_resid) values
       ('$vder','$codigo',$vnoedic,$vanopue,'$vtit',$vnoejem,'$vcar_ed',
                      '$vtipoed','$vn_domi','$vn_pais')");
       // $valido = $sql->insert("$tabla","$col_campos","$insert_str",""); 
       if (!$valido) {$gbcorrecto=$gbcorrecto+1;}
       //$del_dattmp= $sql->del("$nbtabla","solicitud='$vsol'");
     } 
    $regsol = pg_fetch_array($res_soli);
    }
   
   return $gbcorrecto;
 }

 //Llena los temporales con los datos relacionados a la Persona Natural o Juridico 
 function llenatemporal($vtablafij,$vtablatmp,$vdoc,$vsol)
 {  
   //Verificando conexion
   $sql  = new mod_db();
   //$sql->connection();
   if ($vdoc=='') {$vdoc=0;}
   $resul= pg_exec(
      "select distinct on (doc) b.titular as doc,'J' as tipo_per,nombre,identificacion,
              null as fecha_nacim,null as fecha_defun,
              '' as estado_civil,indole,telefono1,telefono2,
              fax,'' as datos_reg,'' as cedula_repre,'' as profesion,'' as seudonimo,
              '' as nombre_repre,'' as cualidad_repre,'' as prueba,pais_resid,domicilio
         from stzsolic b, stdobras c, $vtablafij d 
        where c.solicitud='$vsol' and c.nro_derecho=d.nro_derecho and b.titular='$vdoc'");
   //    union
   //    select distinct on (doc) c.titular as doc,'J' as tipo_per,nombre,
   //           null,null,'',indole,telefono1,telefono2,fax,' ' as datos_registro,
   //           '' as cedula_repre,'','','','','',pais_resid,domicilio
   //      from stzsolic c, stdobras d, $vtablafij e  
   //     where d.solicitud='$vsol' and d.nro_derecho=e.nro_derecho and
   //           c.titular='$vdoc'");
   $regsol = pg_fetch_array($resul);
   $filas_resul = pg_numrows($resul);
   for($i=0;$i<$filas_resul;$i++) {
       $col_campos = "solicitud,tipo_persona,codigo,nombre,ced_rif,
                      estado_civil,domicilio,pais,indole,telefono1,telefono2,
                      fax,profesion,seudonimo,
                      datos_registro,cedula_repre,nombre_repre,cualidad_repre,prueba";
       if ($regsol['estado_civil']=='') {$estc='S';} else {$estc=$regsol['estado_civil'];} 
       $insert_str = "'$vsol','$regsol[tipo_per]','$regsol[doc]','$regsol[nombre]',
                      '$regsol[identificacion]','$estc','$regsol[domicilio]','$regsol[pais_resid]',
                      '$regsol[indole]','$regsol[telefono1]',
                      '$regsol[telefono2]','$regsol[fax]','$regsol[profesion]',
                      '$regsol[seudonimo]','$regsol[datos_reg]',
                      '$regsol[cedula_repre]','$regsol[nombre_repre]',
                      '$regsol[cualidad_repre]','$regsol[prueba]'";            
       if ($regsol['fecha_nacim']<>'') {$col_campos=$col_campos.",fecha_nacim";
                                        $insert_str=$insert_str.",'$regsol[fecha_nacim]'";}
       if ($regsol['fecha_defun']<>'') {$col_campos=$col_campos.",fecha_defun";
                                        $insert_str=$insert_str.",'$regsol[fecha_defun]'";}
       $ins_datint = $sql->insert("$vtablatmp","$col_campos","$insert_str",""); 
   }
   return true;
 }

 //Forma una cadena con los valores de los campos suministrados separados por el caracter |
 function bitacora_fields() {
   global $valores_fields;
   
   $registro="";
   foreach ($valores_fields as $key => $val) {
       $field_val = (array_key_exists($key, $valores_fields)) ?  $valores_fields[$key] : $key;
       $registro .= "|".$field_val;
   }
   return $registro;
 }

 //Chequea si los campos estan vacios
 function check_empty_fields($method = "post") {
    global $req_fields, $valores, $msg;
   
    $invalid = false;
    $data_array = ($method == "post") ? $_POST : $_GET;
    $errors = "";
    $count_empty = 0;
    //foreach ($data_array as $key => $val) {
    foreach ($req_fields as $key => $val) {
        //echo " Key= $key, val= $val ";
        $field_name = (array_key_exists($key, $req_fields)) ?  $req_fields[$key] : $key;
        $field_val = (array_key_exists($key, $valores)) ?  $valores[$key] : $key;
        //echo "Campo= $field_name VALOR= $field_val ";
        //if (in_array($field_name, $req_fields) &&    $val == "") {
        if (in_array($field_name, $req_fields) && empty($field_val)) {
            $GLOBALS[$field_name] = false;
            $errors .= "|".$field_name;
            $count_empty++;
        }
    }
    if ($count_empty == 0) {
        $msg = "";
        return true;
    } else {
        $msg_parts = explode("|", ltrim($errors, "|"));
        $num_parts = count($msg_parts);
        $msg .= "<br>";
        for ($i = 0; $i < $num_parts; $i++) {
            $msg .= $msg_parts[$i];
            if ($i <= $num_parts - 2) {
                $msg .= ($i == $num_parts - 2) ? " &amp; " : ", ";
            }
        }
        //echo "Errores= $msg";
        return false;
    }
 }

 //Determina si la fecha suministrada esta en la tabla de feriado stzferir
 function feriado($fecha,$formato)
 {
   $fecha_found=0;
   if ($fecha != "")
   { 
     $dia=substr($fecha,0,2);
     $mes=substr($fecha,3,2);
     $anio=substr($fecha,6,4);
     if ($formato=="0")
       { $fechabus= date( "m/d/Y", mktime(0,0,0,$mes,$dia,$anio) ); }
     else   
       { $fechabus= date( "Y-M-d", mktime(0,0,0,$mes,$dia,$anio) ); }
     $resfecha=pg_exec("SELECT * FROM stzferir WHERE fecha_fer='$fechabus'");
     $fecha_found=pg_numrows($resfecha); 
   }
   return $fecha_found;
 }

 //Obtiene la fecha del dia
 function Hoy()
 {
   $fecha= mktime(0,0,0,date('m'),date('d'),date('Y'));
   $fechahoy= date("d/m/Y",$fecha);
   return $fechahoy;
 }

 //Obtiene la Hora actual
 function Hora()
 {
   $horahoy= date("h:i:s A");
   return $horahoy;
 }

 //Obtiene el año de la fecha
 function Obtener_anno($fechaini,$forma)
 {
   if ($fechaini != "")
   { 
     switch ($forma) {
     case 0:
         $anio=substr($fechaini,6,4);
         break;
     case 1:
         $anio=substr($fechaini,0,4);
         break;
     }
    return $anio;
   }
 }

 //Convierte el valor suministrado por el template a valor de tipo fecha
 function Convertir_en_fecha($fechaini,$forma)
 {
   if ($forma==0) {
     $dia=substr($fechaini,0,2);
     $mes=substr($fechaini,3,2);
     $anio=substr($fechaini,6,4);
     return date("d/m/Y",mktime(0,0,0,$mes,$dia,$anio)); }
   else {
    if (!empty($fechaini)) {
     $dia=substr($fechaini,8,2);
     $mes=substr($fechaini,5,2);
     $anio=substr($fechaini,0,4);
     return date("d/m/Y",mktime(0,0,0,$mes,$dia,$anio)); }}
 }

 //Determina si el valor de fecha1 es mayor que fecha2
 function compara_Fechas($fecha1,$fecha2)
 {
   $mayor=0;
   list( $day, $month, $year ) = split( '[/.-]', $fecha1 );
   $fe1=$year.$month.$day;
   list( $day, $month, $year ) = split( '[/.-]', $fecha2 );
   $fe2=$year.$month.$day;
   if ($fe1>$fe2) { $mayor= 1; }
   return $mayor;
 }

 //Calcula los dias entre los valores de fecha1 y fecha2
 function dias_entre_fechas($fecha1, $fecha2)
 {
   $dia1 = strtok($fecha1, "-");
   $mes1 = strtok("-");
   $anyo1 = strtok("-");
   $dia2 = strtok($fecha2, "-");
   $mes2 = strtok("-");
   $anyo2 = strtok("-");

   $num_dias = 0;
   if ($anyo1 < $anyo2)
   {
     $dias_anyo1 = date("z", mktime(0,0,0,12,31,$anyo1)) - date("z", mktime(0,0,0,$mes1,$dia1,$anyo1));
     $dias_anyo2 = date("z", mktime(0,0,0,$mes2,$dia2,$anyo2));
     $num_dias = $dias_anyo1 + $dias_anyo2;
   }
   else
     $num_dias = date("z", mktime(0,0,0,$mes2,$dia2,$anyo2)) - date("z", mktime(0,0,0,$mes1,$dia1,$anyo1));
   return $num_dias;
 }

 //Suma la cantidad de ($plazo) a la fecha suministrada ($fecha) de acuerdo al tipo de plazo 
 //($tipo) para obtener una fecha de vencimiento
 function calculo_fechas($fecha, $plazo, $Tipo, $modo)
  {
    if ($Tipo == "A")
    { 
      $dia = strtok($fecha,$modo);
      $mes = strtok($modo);
      $anyo = strtok($modo);
      $anno = $anyo+$plazo; 
      //$fecha = mktime(0,0,0,$mes,$dia,$anyo+$plazo);
      $fecha = mktime(0,0,0,$mes,$dia,$anno);
      //$fechasig=$dia."/".$mes."/".$anno;
      //$fecha1= date("d/m/Y",$fechasig);
      //echo "fecha=$dia,$mes,$anyo,$anno,$fecha,$fechasig,$fecha1";
      $fechav = date("d/m/Y",$fecha);
    }
    if ($Tipo == "M")
    {
      $dia=substr($fecha,0,2);
      $mes=substr($fecha,3,2);
      $anio=substr($fecha,6,4);
      //Sumamos los meses requeridos
      $tmpanio=floor($plazo/12);
      $tmpmes=$plazo%12;
      $anionew=$anio+$tmpanio;
      $mesnew=$mes+$tmpmes;
      if ($mesnew>12)
      {
        $mesnew=$mesnew-12;
        if ($mesnew<10)
         { $mesnew="0".$mesnew; }
        $anionew=$anionew+1;
      }
      $fechav=date( "d/m/Y", mktime(0,0,0,$mesnew,$dia,$anionew) );
    }
    if ($Tipo == "H")
    { 
      $dia=substr($fecha,0,2);
      $mes=substr($fecha,3,2);
      $anio=substr($fecha,6,4);
      $d = $dia;
      $ndias=1;
      while ($ndias <= $plazo)
      {
        $d = $d + 1;
        $fechasig = mktime(0,0,0,$mes,$d,$anio);
        $diasemana=date("w", $fechasig);
        $nroferiado = feriado(date("d/m/Y",$fechasig),"1");
        if (($diasemana != 6) && ($diasemana != 0) && ($nroferiado==0))
          { $ndias = $ndias + 1; }
        $fechav = date("d/m/Y",$fechasig);
      }
    }
  return $fechav;
  }

  //Obtiene la fecha en formato completo, indicando el dia de la semana
  function fechaHoy()
  {
    // Obtenemos y traducimos el nombre del día
    $dia=date("l");
    if ($dia=="Monday") $dia="Lunes";
    if ($dia=="Tuesday") $dia="Martes";
    if ($dia=="Wednesday") $dia="Mi&eacute;rcoles";
    if ($dia=="Thursday") $dia="Jueves";
    if ($dia=="Friday") $dia="Viernes";
    if ($dia=="Saturday") $dia="S&aacute;bado";
    if ($dia=="Sunday") $dia="Domingo";
    // Obtenemos el número del día
    $dia2=date("d");
    // Obtenemos y traducimos el nombre del mes
    $mes=date("F");
    if ($mes=="January") $mes="Enero";
    if ($mes=="February") $mes="Febrero";
    if ($mes=="March") $mes="Marzo";
    if ($mes=="April") $mes="Abril";
    if ($mes=="May") $mes="Mayo";
    if ($mes=="June") $mes="Junio";
    if ($mes=="July") $mes="Julio";
    if ($mes=="August") $mes="Agosto";
    if ($mes=="September") $mes="Septiembre";
    if ($mes=="October") $mes="Octubre";
    if ($mes=="November") $mes="Noviembre";
    if ($mes=="December") $mes="Diciembre";
    // Obtenemos el año
    $ano=date("Y");
    $hoyes= "$dia $dia2 de $mes de $ano";
    // Imprimimos la fecha completa
    //echo "$dia $dia2 de $mes de $ano";
    return $hoyes;
  }

 // Funcion que permite borrar de la Base de Datos tablas temporales dejada por 
 // Elemento Figurativo cuando el usuario se sale mal o retrocede con el toolbars 
 function del_tmpef() 
 {
   $fechahoy = hoy(); 
   $resultado=pg_exec("select * from stmtmpef where fecha < $fechahoy");
   $filas_found=pg_numrows($resultado); 
   $reg = pg_fetch_array($resultado);
   if ($filas_found > 0) {
     for($cont=0;$cont<$filas_found;$cont++)   {  
	    $nametable=trim($reg[tabla]);
       $delresul=pg_exec("drop table $nametable");
       $reg = pg_fetch_array($resultado);
     }
   } 
 }

 function delri_tmpef() 
 {
   $fechahoy = hoy(); 
   $resultado=pg_exec("select tablename from pg_tables where tablename like 'tmpr%'");
   $filas_found=pg_numrows($resultado); 
   $reg = pg_fetch_array($resultado);
   if ($filas_found > 0) {
     for($cont=0;$cont<$filas_found;$cont++)   {  
	    $nametable=trim($reg[tablename]);
       $delresul=pg_exec("drop table $nametable");
       $reg = pg_fetch_array($resultado);
     }
   } 
 }


 //Funciones anteriores a Elementos Figurativo x Rev. 
 function verifica_viena($cdviena,$vnv)
 {
   $filasfound=0;
   if (!empty($cdviena))
   {
     $resviena=pg_exec("SELECT * FROM stmviena WHERE ccv='$cdviena'");
     $filasfound=pg_numrows($resviena); 
     if ($filasfound==0) 
       {
         echo "<hr>";     
         echo "<p align='center'><b>Error: $vnv Clasificación NO Existe....!</b>\n"; 
         echo "<hr>";
       }
   }
   return $filasfound;
 }
 
 function verifica_ccvsol($vsol,$cdviena)
 {
   $filasv_found=0;
   if (!empty($vsol) and !empty($cdviena))
   {
     $resccvma=pg_exec("SELECT * FROM stmccvma WHERE solicitud='$vsol' and ccv='$cdviena'");
     $filasv_found=pg_numrows($resccvma); 
   }
   return $filasv_found;
 }

 function verifica_etiqueta($vsol)
 {
   $filase_found=0;
   if (!empty($vsol))
   {
     $resetiqueta=pg_exec("SELECT * FROM stmimage WHERE solicitud='$vsol'");
     $filase_found=pg_numrows($resetiqueta); 
   }
   return $filase_found;
 }

 function verifica_palabra($vpal)
 {
   $filasp_found=0;
   $identificador=0;
   if (!empty($vpal))
   {
     $respalabra=pg_exec("SELECT * FROM stptesar WHERE palabra=trim('$vpal')");
     $filasp_found=pg_numrows($respalabra);
     if ($filasp_found==0) 
      {
        echo "<hr>";     
        echo "<p align='center'><b>Error: Palabra $vpal NO Existe....!</b>\n"; 
        echo "<hr>";
      }
     else { $rpal = pg_fetch_array($respalabra);
           $identificador=$rpal['apuntador'];
     }
   }
   return $identificador;
 }

 function verifica_palsol($vsol,$cdapunta)
 {
   $filasp_found=0;
   if (!empty($vsol) and !empty($cdapunta))
   {
     $respalpa=pg_exec("SELECT * FROM stppacld WHERE solicitud='$vsol' and apuntador='$cdapunta'");
     $filasp_found=pg_numrows($respalpa); 
   }
   return $filasp_found;
 }

 function verifica_clasol($vsol,$clas)
 {
   $filasp_found=0;
   if (!empty($vsol) and !empty($clas))
   {
     $resclspa=pg_exec("SELECT * FROM stpclsfd WHERE solicitud='$vsol' and clasificacion='$clas'");
     $filasp_found=pg_numrows($resclspa); 
   }
   return $filasp_found;
 }

 function bd_conectar()
 {
   $bd = pg_connect("dbname=sapi host=localhost user=rmendoza password=rmendoza");
   return $bd;	 
 }

 function makePass(){
   $makepass="";
   $salt = "abchefghjkmnpqrstuvwxyz0123456789";
   srand((double)microtime()*1000000);
   $i = 0;
   while ($i <= 7) {
     $num = rand() % 33;
     $tmp = substr($salt, $num, 1);
     $makepass = $makepass . $tmp;
     $i++;
   }
   return ($makepass);
 }

// funciones de patentes
//Nombre del tipo de patentes desde la base de datos
function tipo_patente($var) {
    if ($var=='A') {return 'INVENCION';}
    if ($var=='C') {return 'MEJORA';}
    if ($var=='E') {return 'MODELO INDUSTRIAL';}
    if ($var=='G') {return 'DISEÑO INDUSTRIAL';}
    if ($var=='B') {return 'DIBUJO INDUSTRIAL';}
    if ($var=='D') {return 'INTRODUCCION';}
    if ($var=='F') {return 'MODELO DE UTILIDAD';}
    if ($var=='V') {return 'VARIEDADES VEGETALES';}
}

//Nombre del tipo de patentes desde combos
function tipo_patentec($tipo) {
if ($tipo=='INVENCION') {return 'A';}
if ($tipo=='DIBUJO INDUSTRIAL') {return 'B';}
if ($tipo=='DISEÑO INDUSTRIAL') {return 'G';}
if ($tipo=='MODELO DE UTILIDAD') {return 'F';}
if ($tipo=='MODELO INDUSTRIAL') {return 'E';}
if ($tipo=='VARIEDAD VEGETAL') {return 'V';}
if ($tipo=='MEJORA') {return 'C';}
if ($tipo=='INDUCCION') {return 'D';}
}

//Nombre del tipo de patentes en minuscula para hojas de inicio pdf
function tipo_patentei($var) {
    if ($var=='A') {return 'Invencion';}
    if ($var=='C') {return 'Mejora';}
    if ($var=='E') {return 'Modelo Industrial';}
    if ($var=='G') {return 'Diseño Industrial';}
    if ($var=='B') {return 'Dibujo Industrial';}
    if ($var=='D') {return 'Introducción';}
    if ($var=='F') {return 'Modelo de Utilidad';}
    if ($var=='V') {return 'Variedades Vegetales';}
}


// Funciones de Derecho de Autor

//tipo de obra de derecho de autor
function tipo_obra($var) {
	if ($var=='OL') {return 'LITERARIAS';}
	if ($var=='AV') {return 'ARTE VISUAL';}
	if ($var=='OE') {return 'ESCENICAS';}
	if ($var=='OM') {return 'MUSICALES';}
	if ($var=='AR') {return 'AUDIOVISUALES Y RADIOFONICAS';}
	if ($var=='PC') {return 'PROGRAMAS DE COMPUTACION Y BASE DE DATOS';}
	if ($var=='PF') {return 'PRODUCIONES FONOGRAFICAS';}
	if ($var=='IE') {return 'INTERPRETACIONES Y EJECUCIONES ARTISTICAS';}
	if ($var=='AC') {return 'ACTOS Y CONTRATOS';}
}

//Estatus derecho de autor
function estatus_dnda($estatus)
{
 $res_estatus=pg_exec("SELECT * FROM stdstobr WHERE estatus='$estatus'");
 $restat = pg_fetch_array($res_estatus);
 $descripcion= $restat['descripcion'];
 return $descripcion;
}

//Idioma derecho de autor
function idioma_dnda($idiom)
{
 $res_idioma=pg_exec("SELECT * FROM stdidiom WHERE cod_idioma='$idiom'");
 $residi = pg_fetch_array($res_idioma);
 $idioma= $residi['idioma'];
 return $idioma;
}



?>

<script language="javascript">

function autoComplete (field, select, property, forcematch) {
	var found = false;
	for (var i = 0; i < select.options.length; i++) {
	if (select.options[i][property].toUpperCase().indexOf(field.value.toUpperCase()) == 0) {
		found=true; break;
		}
	}
	if (found) { select.selectedIndex = i; }
	else { select.selectedIndex = -1; }
	if (field.createTextRange) {
		if (forcematch && !found) {
			field.value=field.value.substring(0,field.value.length-1);
			return;
			}
		var cursorKeys ="8;46;37;38;39;40;33;34;35;36;45;";
		if (cursorKeys.indexOf(event.keyCode+";") == -1) {
			var r1 = field.createTextRange();
			var oldValue = r1.text;
			var newValue = found ? select.options[i][property] : oldValue;
			if (newValue != field.value) {
				field.value = newValue;
				var rNew = field.createTextRange();
				rNew.moveStart('character', oldValue.length) ;
				rNew.select();
			}
		}
	}
}

// Valida el articulo de negacion
  function validart(oTxt,oTxtsig1,oTxtsig2){
   if (oTxt.value==135 || oTxt.value==136 || oTxt.value==137 || oTxt.value==177 || oTxt.value==178 || oTxt.value==192  || oTxt.value==194) { // Esta bien 
       if (oTxt.value==135 || oTxt.value==136 || oTxt.value==194) {
          oTxtsig1.focus();
       } else {
       	  oTxtsig2.focus();}    
   } else {
       alert('Error! Los Articulos deben ser: 135,136,137,177,178,192 o 194');
       oTxt.value='';
       oTxt.focus();    
  }}

  function validaliteral(oTxt,oArt,oTxtsig){
   var oVar = 'S';
   if (oArt.value==137 || oArt.value==177 || oArt.value==178 || oArt.value==192) {  
      oTxt.value='';}
   if (oArt.value==135 && oTxt.value>='q') {  
      oTxt.value='';
      oTxt.focus();
      var oVar = 'N';}
   if (oArt.value==136 && oTxt.value>='i') {  
      oTxt.value='';
      oTxt.focus();
      var oVar = 'N';} 
   if (oArt.value==194 && oTxt.value>='e') {  
      oTxt.value='';
      oTxt.focus();
      var oVar = 'N';}
   if (oVar=='S') {oTxtsig.focus();}
  }

function validart56(oTxt,oTxtsig1,oTxtsig2){
   if (oTxt.value==27 || oTxt.value==28 || oTxt.value==33 || oTxt.value==34 || oTxt.value==35) { // Esta bien 
       if (oTxt.value==33 || oTxt.value==34) {
          oTxtsig1.focus();
       } else {
       	  oTxtsig2.focus();}    
   } else {
       alert('Error! Los Articulos deben ser: 27,28,33,34 o 35');
       oTxt.value='';
       oTxt.focus();    
  }}

  function validaliteral56(oTxt,oArt,oTxtsig){
   var oVar = 'S';
   if (oArt.value==35 || oArt.value==27 || oArt.value==28) {  
      alert('Error! Este Articulo no tiene numerales (deje este campo en blanco)');
      oTxt.value='';}
   if (oArt.value==33 && (oTxt.value>=13 || oTxt.value<=0)) {  
      alert('Error! Los Numerales validos van del 1 al 12');
      oTxt.value='';
      oTxt.focus();
      var oVar = 'N';}
   if (oArt.value==34 && (oTxt.value>=3 || oTxt.value<=0)) {  
      alert('Error! Los Numerales validos son 1 o 2');
      oTxt.value='';
      oTxt.focus();
      var oVar = 'N';} 
   if (oVar=='S') {oTxtsig.focus();}
  }
    
// Chequea la longitud de valor a medida que se va introduciendo
  function checkLength(evt,oTxt,vlen,oTxtsig){
   var key = nav4plus ? evt.which : evt.keyCode;
   if (oTxt.value.length==0) {
      oTxt.focus();    
   } else {   
     if (oTxt.value.length>=vlen || key==13){
      oTxtsig.focus(); } 
      }
  }

// rellena con ceros a la izquierda  
  function Rellena(vtxt,vlen){
     var i = vtxt.value.length;
     if (i<vlen || i=="")
     { for(i=0; i <= vlen; i++){
        vtxt.value = "0".concat(vtxt.value);
        var i = vtxt.value.length; 
       }
     }
  }
   
// Conjunto de funciones empleados para la validación de datos tipo fecha   
   function valSep(oTxt){ 
    var bOk = false; 
    var sep1 = oTxt.value.charAt(2); 
    var sep2 = oTxt.value.charAt(5); 
    bOk = bOk || ((sep1 == "-") && (sep2 == "-")); 
    bOk = bOk || ((sep1 == "/") && (sep2 == "/")); 
    return bOk; 
   } 

   function finMes(oTxt){ 
    var nMes = parseInt(oTxt.value.substr(3, 2), 10); 
    var nAno = parseInt(oTxt.value.substr(6), 10); 
    var nRes = 0; 
    switch (nMes){ 
     case 1: nRes = 31; break; 
     case 2: nRes = 28; break; 
     case 3: nRes = 31; break; 
     case 4: nRes = 30; break; 
     case 5: nRes = 31; break; 
     case 6: nRes = 30; break; 
     case 7: nRes = 31; break; 
     case 8: nRes = 31; break; 
     case 9: nRes = 30; break; 
     case 10: nRes = 31; break; 
     case 11: nRes = 30; break; 
     case 12: nRes = 31; break; 
    } 
    return nRes + (((nMes == 2) && (nAno % 4) == 0)? 1: 0); 
   } 

   function valDia(oTxt){ 
    var bOk = false; 
    var nDia = parseInt(oTxt.value.substr(0, 2), 10); 
    bOk = bOk || ((nDia >= 1) && (nDia <= finMes(oTxt))); 
    return bOk; 
   } 

   function valMes(oTxt){ 
    var bOk = false; 
    var nMes = parseInt(oTxt.value.substr(3, 2), 10); 
    bOk = bOk || ((nMes >= 1) && (nMes <= 12)); 
    return bOk; 
   } 

   function valAno(oTxt){ 
    var bOk = true; 
    var nAno = oTxt.value.substr(6); 
    bOk = bOk && ((nAno.length == 2) || (nAno.length == 4)); 
    if (bOk){ 
     for (var i = 0; i < nAno.length; i++){ 
      bOk = bOk && esDigito(nAno.charAt(i)); 
     } 
    } 
    return bOk; 
   } 

   function valFecha(oTxt,oTxtsig){ 
    var bOk = true; 
    if (oTxt.value == "" || oTxt.value.length!=10) {
       alert("Fecha inválida");
       oTxt.value = "";
       oTxt.focus(); 
       } else {
    if (oTxt.value != "" && oTxt.value.length==10){ 
     bOk = bOk && (valAno(oTxt)); 
     bOk = bOk && (valMes(oTxt)); 
     bOk = bOk && (valDia(oTxt)); 
     bOk = bOk && (valSep(oTxt)); 
     if (!bOk){ 
      alert("Fecha inválida"); 
      oTxt.value = "";
      oTxt.focus(); 
     } else oTxtsig.focus(); 
    } }
   } 
// Fin validacion de la Fecha //

 function esDigito(sChr){ 
    var sCod = sChr.charCodeAt(0); 
    return ((sCod > 47) && (sCod < 58)); 
   } 

// Valida la clase internacional que no sea > 47
function valrangoclase(oTxt, oTxtsig, claseant, nhija, vhija, vnumh) {
   if (claseant.value=='') {
      alert('Error! Debe llenar la casilla anterior');
      nhija.value='';
      oTxt.value='';
      claseant.focus();
   } else {
   if (oTxt.value>47 || oTxt.value<1) {
      nhija.value='';
      oTxt.value='';
      alert('El rango de Clases Válidas es: desde 01 hasta 47');
      oTxt.focus();
   } else {nhija.value=vhija;
           oTxtsig.focus();
     } }
}
   
// Permite realizar el salto automatico al siguiente campo del formulario
// despues de que el usuario presiona la tecla ENTER

function codigotecla(evt,oTxtsig){
 var key = nav4plus ? evt.which : evt.keyCode;
 if (key==13) {oTxtsig.focus();}
}

// Permite desplazar el control de ingreso al siguiente campo del formulario
function Avanzafocus(oTxtsig)
{
oTxtsig.focus();
}

function centrarwindows() { 
    //toolbar=no,directories=no,menubar=no,status=no;
    resizeTo(screen.width/1.0, screen.height/1.5); 
    iz=(screen.width-document.body.clientWidth) / 2; 
    de=(screen.height-document.body.clientHeight) / 2; 
    moveTo(iz,de); 
}

function mostrarsol(var1,var2) {
open("datsolicitud.php?vsol="+var1.value+"-"+var2.value);
}

function tbrowse() {
open("t_browse.php","Ventana","scrollbars=yes,toolbar=no,directories=no,menubar=no,status=no"); }

function controla_salida(){ 
event.returnValue = false;}
 
function cerrarwindows(){ 
close();}

function validarcampos(v1,v2,v3,v4,v5){ 
    var bOk = true; 
    if (v2.value == "" || v3.value == "" || v4.value == "" || v5.value == "") { 
       alert("Campo Vacio!"); 
       v2.focus();
    } 
    else  
    {
       alert("Guardado Correctamente"); 
       close();
    } 
} 

function valclase(etip,ecni,ecla,oTxtsig){ 
    x=window.event.keyCode;
    var bOk = false; 
    if (ecni.value == "N"){
        if (etip.value == "M" && ecla.value>0 && ecla.value<50){
           var bOk = true;}
        if (etip.value != "M" && ecla.value==50){
           var bOk = true;}
    }
    if (ecni.value == "I"){
        if (etip.value == "M" && ecla.value>0 && ecla.value<35){
           var bOk = true;}
        if (etip.value == "S" && ecla.value>34 && ecla.value<46){
           var bOk = true;}
        if (etip.value == "N" && ecla.value==46){
           var bOk = true;}
        if (etip.value == "L" && ecla.value==47){
           var bOk = true;} 
        if (etip.value == "D" && ecla.value==48){
           var bOk = true;} 
        if (etip.value == "C" && ecla.value<49){
           var bOk = true;} 
    }  
    if (ecla.value.length>0 && x==13){
       if (!bOk){ 
          alert("Clase inválida"); 
          ecla.value = "";
          ecla.focus(); 
       }  
       else 
       { oTxtsig.focus(); 
       }
    } 
} 

function valtipo(etip,ecni,ecla){ 
    if (ecni.value == "N"){
        if (etip.value == "M"){
           ecla.value = "";}
        if (etip.value != "M"){
           ecla.value = 50;}
    }
    if (ecni.value == "I"){
        if (etip.value == "M" && ecla.value>34){
           ecla.value = "";}
        if (etip.value == "S" && ecla.value<35){
           ecla.value = "";}
        if (etip.value == "S" && ecla.value>45){
           ecla.value = "";}
        if (etip.value == "N"){
           ecla.value = 46;}
        if (etip.value == "L"){
           ecla.value = 47;}
        if (etip.value == "D"){
           ecla.value = 48;}  
    }  
} 

function valagente(v1,v2){ 
    if (v1!=""){
       v2.value=v1.value;
    }
}

function valanno(v1,v2){ 
    if (v1.value>v2.value.substring(10,6)) {
       alert("Año Invalido, no puede ser mayor al de la Solicitud!"); 
       v1.value='';
       v1.focus(); 
    }
}

function valfacultad(v1) { 
    if (v1.value!="M" && v1.value!="P" && v1.value!="A" && v1.value!="m" && v1.value!="p" && v1.value!="a"){
       alert("Facultad Inválida"); 
       v1.focus(); 
       v1.value='';
    }        
}

function grabarsol(var1,var2,var3,var4,var5,var6,var7,var8,var9,var10,var11,var12,var13,var14) {
close();
open("ingresol.php?vsol="+var1.value+"-"+var2.value+"&vfec="+var3.value+"&vtip="+var4.value+"&vnom="+var5.value+"&vicl="+var6.value+"&vcla="+var7.value+"&vmod="+var8.value+"&vpai="+var9.value+"&vpod="+var10.value+"-"+var11.value+"&vage="+var12.value+"&vtra="+var13.value+"&vdis="+var14.value,"Ventana","scrollbars=yes,toolbar=no,directories=no,menubar=no,status=no"); 
open("input_marcas.php");}

</script>

<script language="JavaScript">
var mask_string = new Array()

function property_mask(msk, msg){

this.msk = msk
this.msg = msg

}

function populate_array(){
mask_string[0] =new property_mask( /[^\d]/i, "Puede introducir cualquier caracter menos los números.")
mask_string[1] =new property_mask(/[\d\s]/, "Solo se puede intruducir números y espacios.")
mask_string[2] =new property_mask( /\d/, "Solo se pueden introducir números.")
mask_string[3] =new property_mask(/[A-Zñ\d]/i,"Solo se puede introducir letras y números,\n no se permiten espacios.")
mask_string[4] =new property_mask(/[ABCDEFGV]/i,"Solo se puede introducir las letras ABCDEFGV.")
mask_string[5] =new property_mask(/[A-Zñ]/i,"Solo se puede introducir las letras A-Z.")
mask_string[6] =new property_mask(/[ACDFGLMNPS]/i,"Solo se puede introducir las letras ACDFGLMNPS.")
mask_string[7] =new property_mask(/[ABCDEFGH]/i,"Solo se puede introducir las letras ABCDEFGH.")
mask_string[8] =new property_mask(/[PS]/i,"Solo se puede introducir las letras PS.")
mask_string[9] =new property_mask(/[\d\s()]/, "Solo se puede intruducir Numeros,Espacios y Parentesis.")
}

populate_array()
var nav4plus = window.Event ? true : false;

function acceptChar(evt,nba,obj){
var key = nav4plus ? evt.which : evt.keyCode;
if(key==13 || key==8) { return true}
if(mask_string[nba].msk.test(String.fromCharCode(key))){ return true}
else{ obj.focus(); if (key!=0) { alert(mask_string[nba].msg)}; return false}
}

function valida_indclase(oTxt,oTxtsig1){
  if (oTxt.value=='N' || oTxt.value=='I' || oTxt.value=='A')
     { // Esta bien 
     oTxtsig1.focus(); }
  else {
     alert('Valores validos son: (N)acional - (I)nternacional - (T)odas');
     oTxt.value='';
     oTxt.focus();  }}

</script>
