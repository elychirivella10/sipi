<?php 
// (Lis_funcion.php)
// Realizado Por Ing. Romulo Mendoza

//includes 
include ("inc/constantes.inc");

function sqlcompara($campo,$criterio,$valor)
{
  //echo "en funcion= $campo, $criterio, $valor ";

  if(!empty($valor)) {
   switch($criterio)
   {
     case BÚSQUEDA_NOMBRE_PALABRAS_EXACTAS:
       switch($campo)
        {
          case TITULO:
	         $resultado=pg_exec("INSERT INTO consulta SELECT solicitud FROM stppatee WHERE nombre = '$valor'");
            break;
          case INVENTOR:
	         $resultado=pg_exec("INSERT INTO consulta SELECT DISTINCT stppatee.solicitud FROM stppatee, stpinved WHERE stpinved.nombre_inv = '$valor' 
                                AND stppatee.solicitud=stpinved.solicitud");
            break;                    
          case TIPO:
	         $resultado=pg_exec("INSERT INTO consulta SELECT solicitud FROM stppatee WHERE tipo_paten = '$valor'");
            break;
          case TITULAR:
            $resultado=pg_exec("INSERT INTO consulta SELECT DISTINCT stppatee.solicitud 
			                       FROM stpottid, stztitur,stppatee WHERE stztitur.nombre = '$valor' 
			                       AND stpottid.titular=stztitur.titular
			                       AND stppatee.solicitud=stpottid.solicitud "); 
            break;
          case RESUMEN:
            $resultado=pg_exec("INSERT INTO consulta SELECT stpresud.solicitud
			                       FROM stpresud, stppatee WHERE stpresud.resumen = '$valor' 
			                       AND stpresud.solicitud=stppatee.solicitud ");
            break;
          case EQUIVALENTE:
            $resultado=pg_exec("INSERT INTO consulta SELECT DISTINCT stppatee.solicitud 
			                       FROM stppatee, stpequiv  WHERE stpequiv.equivalente = '$valor'
			                       AND stpequiv.solicitud = stppatee.solicitud "); 
            break;
          case PRIORIDAD:
            $resultado=pg_exec("INSERT INTO consulta SELECT DISTINCT stppatee.solicitud 
			                       FROM stppatee, stppriod WHERE stppriod.prioridad = '$valor'
			                       AND stppriod.solicitud = stppatee.solicitud");

            break;
          case CLASIFICACION:
            $resultado=pg_exec("INSERT INTO consulta SELECT DISTINCT stppatee.solicitud 
			                       FROM stppatee, stpclsfd  WHERE stpclsfd.clasificacion = '$valor'
			                       AND stpclsfd.solicitud = stppatee.solicitud "); 
            break;
          case LOCARNO:
            $resultado=pg_exec("INSERT INTO consulta SELECT stppatee.solicitud 
			                       FROM stppatee, stplocad  WHERE stplocad.clasi_locarno = '$valor'
			                       AND stplocad.solicitud = stppatee.solicitud "); 
            break;
          case PAIS:
	         $resultado=pg_exec("INSERT INTO consulta SELECT stppatee.solicitud 
				                    FROM stppatee, stzpaisr WHERE stzpaisr.nombre = '$valor' 
                                AND stppatee.pais_resid = stzpaisr.pais");
            break;
          case SOLICITUD:
            $resultado=pg_exec("INSERT INTO consulta SELECT stppatee.solicitud 
                                FROM stppatee WHERE stppatee.solicitud = '$valor'");
            break;
          case REGISTRO:
            $resultado=pg_exec("INSERT INTO consulta SELECT stppatee.solicitud 
                                FROM stppatee WHERE stppatee.registro = '$valor' and registro!=''");
            break;
          case TRAMITANTE:
	         $resultado=pg_exec("INSERT INTO consulta SELECT stppatee.solicitud 
				                    FROM stppatee WHERE stppatee.tramitante = '$valor'");
            break;
          case AGENTE:
	         $resultado=pg_exec("INSERT INTO consulta SELECT DISTINCT stppatee.solicitud 
				                    FROM stppatee, stpautod, stzagenr 
				                    WHERE stzagenr.nombre = '$valor' 
                                AND stppatee.solicitud=stpautod.solicitud 
                                AND stpautod.agente=stzagenr.agente");
            break;
          case PRESENTACION:
            $resultado=pg_exec("INSERT INTO consulta SELECT stppatee.solicitud 
                                FROM stppatee WHERE stppatee.fecha_solic='$valor'");
            break;
          case PUBLICACION:
            $resultado=pg_exec("INSERT INTO consulta SELECT stppatee.solicitud 
                                FROM stppatee WHERE stppatee.fecha_publi='$valor'");
            break;
          case PALABRA:
            $resultado=pg_exec("INSERT INTO consulta SELECT DISTINCT stppacld.solicitud 
			                       FROM stptesar, stppacld WHERE stptesar.palabra = '$valor' 
			                       AND stptesar.apuntador=stppacld.apuntador"); 
            break;
          case ESTATUS:
            $resultado=pg_exec("INSERT INTO consulta SELECT stppatee.solicitud 
			                       FROM stppatee WHERE stppatee.estatus = '$valor'"); 
            break;
          case PODER:
            $resultado=pg_exec("INSERT INTO consulta SELECT stppatee.solicitud 
			                       FROM stppatee WHERE stppatee.poder = '$valor'"); 
            break;
           
        }
       break;
     case BÚSQUEDA_NOMBRE_PALABRA_CONTENIDA:
       switch($campo)
        {
          case TITULO:
	         $resultado=pg_exec("INSERT INTO consulta SELECT solicitud FROM stppatee WHERE nombre like '%$valor%'");
            break;
          case INVENTOR:
	         $resultado=pg_exec("INSERT INTO consulta SELECT DISTINCT stppatee.solicitud FROM stppatee, stpinved WHERE stpinved.nombre_inv like '%$valor%' 
                                AND stppatee.solicitud=stpinved.solicitud");
            break;                    
          case TIPO:
	         $resultado=pg_exec("INSERT INTO consulta SELECT solicitud FROM stppatee WHERE tipo_paten like '%$valor%'");
            break;
          case TITULAR:
            $resultado=pg_exec("INSERT INTO consulta SELECT DISTINCT stppatee.solicitud 
			                       FROM stpottid, stztitur,stppatee WHERE stztitur.nombre like '%$valor%' 
			                       AND stpottid.titular=stztitur.titular
			                       AND stppatee.solicitud=stpottid.solicitud "); 
            break;
          case RESUMEN:
            $resultado=pg_exec("INSERT INTO consulta SELECT stpresud.solicitud
			                       FROM stpresud, stppatee WHERE stpresud.resumen like '%$valor%' 
			                       AND stpresud.solicitud=stppatee.solicitud ");
            break;
          case EQUIVALENTE:
            $resultado=pg_exec("INSERT INTO consulta SELECT DISTINCT stppatee.solicitud 
			                       FROM stppatee, stpequiv  WHERE stpequiv.equivalente like '%$valor%'
			                       AND stpequiv.solicitud = stppatee.solicitud "); 
            break;
          case PRIORIDAD:
            $resultado=pg_exec("INSERT INTO consulta SELECT DISTINCT stppatee.solicitud 
			                       FROM stppatee, stppriod WHERE stppriod.prioridad like '%$valor%'
			                       AND stppriod.solicitud = stppatee.solicitud");
            break;
          case CLASIFICACION:
            $resultado=pg_exec("INSERT INTO consulta SELECT DISTINCT stppatee.solicitud 
			                       FROM stppatee, stpclsfd  WHERE stpclsfd.clasificacion like '%$valor%'
			                       AND stpclsfd.solicitud = stppatee.solicitud "); 
            break;
          case LOCARNO:
            $resultado=pg_exec("INSERT INTO consulta SELECT stppatee.solicitud 
			                       FROM stppatee, stplocad  WHERE stplocad.clasi_locarno like '%$valor%'
			                       AND stplocad.solicitud = stppatee.solicitud "); 
            break;
          case PAIS:
	         $resultado=pg_exec("INSERT INTO consulta SELECT stppatee.solicitud 
				                    FROM stppatee, stzpaisr WHERE stzpaisr.nombre like '%$valor%' 
                                AND stppatee.pais_resid = stzpaisr.pais");
            break;
          case SOLICITUD:
            $resultado=pg_exec("INSERT INTO consulta SELECT stppatee.solicitud 
                                FROM stppatee WHERE stppatee.solicitud like '%$valor%'");
            break;
          case REGISTRO:
            $resultado=pg_exec("INSERT INTO consulta SELECT stppatee.solicitud 
                                FROM stppatee WHERE stppatee.registro like '%$valor%' and registro!=''");

            break;
          case TRAMITANTE:
	         $resultado=pg_exec("INSERT INTO consulta SELECT stppatee.solicitud 
				                    FROM stppatee WHERE stppatee.tramitante like '%$valor%'");
            break;
          case AGENTE:
	         $resultado=pg_exec("INSERT INTO consulta SELECT stppatee.solicitud 
				                    FROM stppatee, stpautod, stzagenr 
				                    WHERE stzagenr.nombre like '%$valor%' 
                                AND stppatee.solicitud=stpautod.solicitud 
                                AND stpautod.agente=stzagenr.agente");
            break;
          case PRESENTACION:
            $resultado=pg_exec("INSERT INTO consulta SELECT stppatee.solicitud 
                                FROM stppatee WHERE stppatee.fecha_solic like '%$valor%'");
            break;
          case PUBLICACION:
            $resultado=pg_exec("INSERT INTO consulta SELECT stppatee.solicitud 
                                FROM stppatee WHERE stppatee.fecha_publi like '%$valor%'");
            break;
          case PALABRA:
            $resultado=pg_exec("INSERT INTO consulta SELECT DISTINCT stppacld.solicitud 
			                       FROM stptesar, stppacld WHERE stptesar.palabra like '%$valor%' 
			                       AND stptesar.apuntador=stppacld.apuntador"); 
            break;
          case ESTATUS:
            $resultado=pg_exec("INSERT INTO consulta SELECT stppatee.solicitud 
			                       FROM stppatee WHERE stppatee.estatus like '%$valor%'"); 
            break;
          case PODER:
            $resultado=pg_exec("INSERT INTO consulta SELECT stppatee.solicitud 
			                       FROM stppatee WHERE stppatee.poder like '%$valor%'"); 
            break;
        }
       break;
     case BÚSQUEDA_NOMBRE_COMIENCE_POR:
       switch($campo)
        {
          case TITULO:
	         $resultado=pg_exec("INSERT INTO consulta SELECT solicitud FROM stppatee WHERE nombre like '$valor%'");
            break;
          case INVENTOR:
	         $resultado=pg_exec("INSERT INTO consulta SELECT DISTINCT stppatee.solicitud FROM stppatee, stpinved WHERE stpinved.nombre_inv like '$valor%' 
                                AND stppatee.solicitud=stpinved.solicitud");
            break;
          case TIPO:
	         $resultado=pg_exec("INSERT INTO consulta SELECT solicitud FROM stppatee WHERE tipo_paten like '$valor%'");
            break;
          case TITULAR:
            $resultado=pg_exec("INSERT INTO consulta SELECT DISTINCT stppatee.solicitud 
			                       FROM stpottid, stztitur,stppatee WHERE stztitur.nombre like '$valor%' 
			                       AND stpottid.titular=stztitur.titular
			                       AND stppatee.solicitud=stpottid.solicitud "); 
            break;
          case RESUMEN:
            $resultado=pg_exec("INSERT INTO consulta SELECT stpresud.solicitud
			                       FROM stpresud, stppatee WHERE stpresud.resumen like '$valor%' 
			                       AND stpresud.solicitud=stppatee.solicitud ");
            break;
          case EQUIVALENTE:
            $resultado=pg_exec("INSERT INTO consulta SELECT DISTINCT stppatee.solicitud 
			                       FROM stppatee, stpequiv  WHERE stpequiv.equivalente like '$valor%'
			                       AND stpequiv.solicitud = stppatee.solicitud "); 
            break;
          case PRIORIDAD:
            $resultado=pg_exec("INSERT INTO consulta SELECT DISTINCT stppatee.solicitud 
			                       FROM stppatee, stppriod WHERE stppriod.prioridad like '$valor%'
			                       AND stppriod.solicitud = stppatee.solicitud");

            break;
          case CLASIFICACION:
            $resultado=pg_exec("INSERT INTO consulta SELECT DISTINCT stppatee.solicitud 
			                       FROM stppatee, stpclsfd  WHERE stpclsfd.clasificacion like '$valor%'
			                       AND stpclsfd.solicitud = stppatee.solicitud "); 
            break;
          case LOCARNO:
            $resultado=pg_exec("INSERT INTO consulta SELECT stppatee.solicitud 
			                       FROM stppatee, stplocad  WHERE stplocad.clasi_locarno like '$valor%'
			                       AND stplocad.solicitud = stppatee.solicitud "); 
            break;
          case PAIS:
	         $resultado=pg_exec("INSERT INTO consulta SELECT stppatee.solicitud 
				                    FROM stppatee, stzpaisr WHERE stzpaisr.nombre like '$valor%' 
                                AND stppatee.pais_resid=stzpaisr.pais");
            break;
          case SOLICITUD:
            $resultado=pg_exec("INSERT INTO consulta SELECT stppatee.solicitud 
                                FROM stppatee WHERE solicitud like '$valor%'");
            break;
          case REGISTRO:
            $resultado=pg_exec("INSERT INTO consulta SELECT stppatee.solicitud 
                                FROM stppatee WHERE registro like '$valor%' and registro!=''");
            break;
          case TRAMITANTE:
	         $resultado=pg_exec("INSERT INTO consulta SELECT stppatee.solicitud 
				                    FROM stppatee WHERE stppatee.tramitante like '$valor%'");
            break;
          case AGENTE:
	         $resultado=pg_exec("INSERT INTO consulta SELECT stppatee.solicitud 
				                    FROM stppatee, stpautod, stzagenr 
				                    WHERE stzagenr.nombre like '$valor%' 
                                AND stppatee.solicitud=stpautod.solicitud 
                                AND stpautod.agente=stzagenr.agente");
            break;
          case PRESENTACION:
            $resultado=pg_exec("INSERT INTO consulta SELECT stppatee.solicitud 
                                FROM stppatee WHERE stppatee.fecha_solic like '$valor%'");
            break;
          case PUBLICACION:
            $resultado=pg_exec("INSERT INTO consulta SELECT stppatee.solicitud 
                                FROM stppatee WHERE stppatee.fecha_publi like '$valor%'");
            break;
          case PALABRA:
            $resultado=pg_exec("INSERT INTO consulta SELECT DISTINCT stppacld.solicitud 
			                       FROM stptesar, stppacld WHERE stptesar.palabra like '$valor%' 
			                       AND stptesar.apuntador=stppacld.apuntador"); 
            break;
          case ESTATUS:
            $resultado=pg_exec("INSERT INTO consulta SELECT stppatee.solicitud 
			                       FROM stppatee WHERE stppatee.estatus like '$valor%'"); 
            break;
          case PODER:
            $resultado=pg_exec("INSERT INTO consulta SELECT stppatee.solicitud 
			                       FROM stppatee WHERE stppatee.poder like '$valor%'"); 
            break;
        }
       break;
   }
  }
  return $resultado;
}

?>
