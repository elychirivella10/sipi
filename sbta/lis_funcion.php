<?php 
// (Lis_funcion.php)
// Realizado Por Ing. Romulo Mendoza

//includes 
include ("inc/constantes.inc");

function sqlcompara($campo,$criterio,$valor)
{
  //echo "en funcion= $campo, $criterio, $valor ";
  $valor=trim($valor);
  if(!empty($valor)) {
   switch($criterio)
   {
     case BÚSQUEDA_NOMBRE_PALABRAS_EXACTAS:
       switch($campo)
        {
          case TITULO:
	         $resultado=pg_exec("INSERT INTO consulta SELECT solicitud FROM stzderec WHERE nombre = '$valor' AND stzderec.tipo_mp='P' ");
            break;
          case INVENTOR:
	         $resultado=pg_exec("INSERT INTO consulta SELECT DISTINCT stzderec.solicitud FROM stzderec, stpinved WHERE stpinved.nombre_inv = '$valor' 
                                AND stzderec.nro_derecho=stpinved.nro_derecho 
				AND stzderec.tipo_mp='P'");
            break;                    
          case TIPO:
	         $resultado=pg_exec("INSERT INTO consulta SELECT solicitud FROM stzderec WHERE tipo_derecho = '$valor' AND stzderec.tipo_mp='P'");
            break;
          case TITULAR:
            $resultado=pg_exec("INSERT INTO consulta SELECT DISTINCT stzderec.solicitud 
		                       FROM stzottid, stzsolic, stzderec 
				       WHERE stzsolic.nombre = '$valor' 
				       AND stzderec.nro_derecho=stzottid.nro_derecho
		                       AND stzsolic.titular = stzottid.titular
		  		       AND stzderec.tipo_mp='P' "); 
            break;
          case RESUMEN:
            $resultado=pg_exec("INSERT INTO consulta SELECT stzderec.solicitud
			                       FROM stzderec, stppatee 
					       WHERE stppatee.resumen  = '$valor' 
			                       AND stzderec.nro_derecho=stppatee.nro_derecho 
						AND stzderec.tipo_mp='P'");
            break;
          case EQUIVALENTE:
            $resultado=pg_exec("INSERT INTO consulta SELECT DISTINCT stzderec.solicitud 
			              FROM stzderec, stpequiv  
				      WHERE stpequiv.equivalente = '$valor'
			              AND stpequiv.nro_derecho = stzderec.nro_derecho 
				      AND stzderec.tipo_mp='P'"); 
            break;
          case PRIORIDAD:
            $resultado=pg_exec("INSERT INTO consulta SELECT DISTINCT stzderec.solicitud 
			        FROM stzderec, stzpriod 
				WHERE stzpriod.prioridad = '$valor'
				AND stzderec.nro_derecho=stzpriod.nro_derecho
			        AND stzderec.tipo_mp='P' ");

            break;
          case CLASIFICACION:	
            $resultado=pg_exec("INSERT INTO consulta SELECT DISTINCT stzderec.solicitud 
			           FROM stpclsfd, stzderec
				   WHERE stpclsfd.clasificacion = '$valor'
			           AND stzderec.nro_derecho=stpclsfd.nro_derecho
		        	   AND stzderec.tipo_mp='P' "); 
            break;
          case LOCARNO:
            $resultado=pg_exec("INSERT INTO consulta SELECT stzderec.solicitud 
			        FROM stplocad, stzderec 
				WHERE stplocad.clasi_locarno = '$valor'
			        AND stzderec.nro_derecho=stplocad.nro_derecho
		        	AND stzderec.tipo_mp='P' "); 
            break;
          case PAIS:
            $resultado=pg_exec("INSERT INTO consulta SELECT stzderec.solicitud 
				     FROM stzderec, stzpaisr 
				     WHERE stzpaisr.nombre = '$valor' 
                                     AND stzderec.pais_resid=stzpaisr.pais
		                     AND stzderec.tipo_mp='P'");
            break;
          case SOLICITUD:
            $resultado=pg_exec("INSERT INTO consulta SELECT stzderec.solicitud 
                                FROM stzderec WHERE stzderec.solicitud = '$valor' 
				AND stzderec.tipo_mp='P' ");
            break;
          case REGISTRO:
            $resultado=pg_exec("INSERT INTO consulta SELECT stzderec.solicitud 
                                FROM stzderec 
				WHERE stzderec.registro = '$valor' and registro!=''
				AND stzderec.tipo_mp='P' ");
            break;
          case TRAMITANTE:
	         $resultado=pg_exec("INSERT INTO consulta SELECT stzderec.solicitud 
				     FROM stzderec WHERE stzderec.tramitante = '$valor'
				     AND stzderec.tipo_mp='P' ");
            break;
          case AGENTE:
	         $resultado=pg_exec("INSERT INTO consulta SELECT DISTINCT stzderec.solicitud 
			              FROM stzderec, stzautod, stzagenr 
		                      WHERE stzagenr.nombre = '$valor' 
   					AND stzautod.agente = stzagenr.agente
		                         AND stzderec.nro_derecho =stzautod.nro_derecho 
  				         AND stzderec.tipo_mp='P'");
            break;
          case PRESENTACION:
            $resultado=pg_exec("INSERT INTO consulta SELECT stzderec.solicitud 
                                FROM stzderec WHERE stzderec.fecha_solic='$valor' AND stzderec.tipo_mp='P' ");
            break;
          case PUBLICACION:
            $resultado=pg_exec("INSERT INTO consulta SELECT stzderec.solicitud 
                                FROM stzderec WHERE stzderec.fecha_publi='$valor' AND stzderec.tipo_mp='P'");
            break;
          case VENCIMIENTO:
            $resultado=pg_exec("INSERT INTO consulta SELECT stzderec.solicitud 
                                FROM stzderec WHERE stzderec.fecha_venc='$valor' AND stzderec.tipo_mp='P'");
            break;
          case BOLETIN:
            $resultado=pg_exec("INSERT INTO consulta SELECT stzderec.solicitud 
			                       FROM stzderec,stzevtrd WHERE stzevtrd.documento = '$valor' 
			                       AND stzderec.nro_derecho = stzevtrd.nro_derecho 
			                       AND stzderec.tipo_mp='P'"); 
            break;
          case PALABRA:
            $resultado=pg_exec("INSERT INTO consulta SELECT DISTINCT stppacld.solicitud 
			                       FROM stptesar, stppacld WHERE stptesar.palabra = '$valor' 
			                       AND stptesar.apuntador=stppacld.apuntador"); 
            break;
          case ESTATUS:
            $resultado=pg_exec("INSERT INTO consulta SELECT stzderec.solicitud 
			                       FROM stzderec WHERE stzderec.estatus = (2000+$valor) AND stzderec.tipo_mp='P'"); 
            break;
          case PODER:
            $resultado=pg_exec("INSERT INTO consulta SELECT stzderec.solicitud 
			                       FROM stzderec WHERE stzderec.poder = '$valor' AND stzderec.tipo_mp='P'"); 
            break;          
        }
       break;


     case BÚSQUEDA_NOMBRE_PALABRA_CONTENIDA:
       switch($campo)
        {
          case TITULO:
	         $resultado=pg_exec("INSERT INTO consulta SELECT solicitud FROM stzderec WHERE nombre like '%$valor%' AND stzderec.tipo_mp='P' ");
            break;
          case INVENTOR:
	         $resultado=pg_exec("INSERT INTO consulta SELECT DISTINCT stzderec.solicitud FROM stzderec, stpinved WHERE stpinved.nombre_inv like '%$valor%' 
                                AND stzderec.nro_derecho=stpinved.nro_derecho 
				AND stzderec.tipo_mp='P'");
            break;                    
          case TIPO:
	         $resultado=pg_exec("INSERT INTO consulta SELECT solicitud FROM stzderec WHERE tipo_derecho like '%$valor%' AND stzderec.tipo_mp='P'");
            break;
          case TITULAR:
            $resultado=pg_exec("INSERT INTO consulta SELECT DISTINCT stzderec.solicitud 
		                       FROM stzottid, stzsolic, stzderec 
				       WHERE stzsolic.nombre like '%$valor%' 
				       AND stzderec.nro_derecho=stzottid.nro_derecho
		                       AND stzsolic.titular = stzottid.titular
		  		       AND stzderec.tipo_mp='P' "); 
            break;
          case RESUMEN:
            $resultado=pg_exec("INSERT INTO consulta SELECT stzderec.solicitud
			                       FROM stzderec, stppatee 
					       WHERE stppatee.resumen  like '%$valor%' 
			                       AND stzderec.nro_derecho=stppatee.nro_derecho 
						AND stzderec.tipo_mp='P'");
            break;
          case TITULORESUMEN:
		      $resultado = pg_exec("INSERT INTO consulta SELECT stzderec.solicitud
                      FROM stzderec 
			             WHERE stzderec.tipo_mp='P'
                      AND stzderec.nombre LIKE '%$valor%'
			             UNION 
                      SELECT stzderec.solicitud
                      FROM stppatee, stzderec 
                      WHERE stzderec.nro_derecho=stppatee.nro_derecho
                      AND stppatee.resumen LIKE '%$valor%' 
                      AND stzderec.tipo_mp='P'");
            break;
          case EQUIVALENTE:
            $resultado=pg_exec("INSERT INTO consulta SELECT DISTINCT stzderec.solicitud 
			              FROM stzderec, stpequiv  
				      WHERE stpequiv.equivalente like '%$valor%'
			              AND stpequiv.nro_derecho = stzderec.nro_derecho 
				      AND stzderec.tipo_mp='P'"); 
            break;
          case PRIORIDAD:
            $resultado=pg_exec("INSERT INTO consulta SELECT DISTINCT stzderec.solicitud 
			        FROM stzderec, stzpriod 
				WHERE stzpriod.prioridad like '%$valor%'
				AND stzderec.nro_derecho=stzpriod.nro_derecho
			        AND stzderec.tipo_mp='P' ");

            break;
          case CLASIFICACION:	
            $resultado=pg_exec("INSERT INTO consulta SELECT DISTINCT stzderec.solicitud 
			           FROM stpclsfd, stzderec
				   WHERE stpclsfd.clasificacion like '%$valor%'
			           AND stzderec.nro_derecho=stpclsfd.nro_derecho
		        	   AND stzderec.tipo_mp='P' "); 
            break;
          case LOCARNO:
            $resultado=pg_exec("INSERT INTO consulta SELECT stzderec.solicitud 
			        FROM stplocad, stzderec 
				WHERE stplocad.clasi_locarno like '%$valor%'
			        AND stzderec.nro_derecho=stplocad.nro_derecho
		        	AND stzderec.tipo_mp='P' "); 
            break;
          case PAIS:
            $resultado=pg_exec("INSERT INTO consulta SELECT stzderec.solicitud 
				     FROM stzderec, stzpaisr 
				     WHERE stzpaisr.nombre like '%$valor%' 
                                     AND stzderec.pais_resid=stzpaisr.pais
		                     AND stzderec.tipo_mp='P'");
            break;
          case SOLICITUD:
            $resultado=pg_exec("INSERT INTO consulta SELECT stzderec.solicitud 
                                FROM stzderec WHERE stzderec.solicitud like '%$valor%' 
				AND stzderec.tipo_mp='P' ");
            break;
          case REGISTRO:
            $resultado=pg_exec("INSERT INTO consulta SELECT stzderec.solicitud 
                                FROM stzderec 
				WHERE stzderec.registro like '%$valor%' and registro!=''
				AND stzderec.tipo_mp='P' ");
            break;
          case TRAMITANTE:
	         $resultado=pg_exec("INSERT INTO consulta SELECT stzderec.solicitud 
				     FROM stzderec WHERE stzderec.tramitante like '%$valor%'
				     AND stzderec.tipo_mp='P' ");
            break;
          case AGENTE:
	         $resultado=pg_exec("INSERT INTO consulta SELECT DISTINCT stzderec.solicitud 
			              FROM stzderec, stzautod, stzagenr 
		                      WHERE stzagenr.nombre like '%$valor%' 
   					AND stzautod.agente = stzagenr.agente
		                         AND stzderec.nro_derecho =stzautod.nro_derecho 
  				         AND stzderec.tipo_mp='P'");
            break;
          case PRESENTACION:
            $resultado=pg_exec("INSERT INTO consulta SELECT stzderec.solicitud 
                                FROM stzderec WHERE stzderec.fecha_solic like '%$valor%' AND stzderec.tipo_mp='P' ");
            break;
          case PUBLICACION:
            $resultado=pg_exec("INSERT INTO consulta SELECT stzderec.solicitud 
                                FROM stzderec WHERE stzderec.fecha_publi like '%$valor%' AND stzderec.tipo_mp='P'");
            break;
          case VENCIMIENTO:
            $resultado=pg_exec("INSERT INTO consulta SELECT stzderec.solicitud 
                                FROM stzderec WHERE stzderec.fecha_venc like '%$valor%' AND stzderec.tipo_mp='P'");
            break;
          case BOLETIN:
            $resultado=pg_exec("INSERT INTO consulta SELECT stzderec.solicitud 
			                       FROM stzderec,stzevtrd WHERE stzevtrd.documento like '%$valor%' 
			                       AND stzderec.nro_derecho = stzevtrd.nro_derecho 
			                       AND stzderec.tipo_mp='P'"); 
            break;
          case PALABRA:
            $resultado=pg_exec("INSERT INTO consulta SELECT DISTINCT stppacld.solicitud 
			                       FROM stptesar, stppacld WHERE stptesar.palabra like '%$valor%' 
			                       AND stptesar.apuntador=stppacld.apuntador"); 
            break;
          case ESTATUS:
            $resultado=pg_exec("INSERT INTO consulta SELECT stzderec.solicitud 
			                       FROM stzderec WHERE stzderec.estatus like '%$valor%' AND stzderec.tipo_mp='P'"); 
            break;
          case PODER:
            $resultado=pg_exec("INSERT INTO consulta SELECT stzderec.solicitud 
			                       FROM stzderec WHERE stzderec.poder like '%$valor%' AND stzderec.tipo_mp='P'"); 
            break;          
        }
       break;

     case BÚSQUEDA_NOMBRE_COMIENCE_POR:
        switch($campo)
        {
          case TITULO:
	         $resultado=pg_exec("INSERT INTO consulta SELECT solicitud FROM stzderec WHERE nombre like '$valor%' AND stzderec.tipo_mp='P' ");
            break;
          case INVENTOR:
	         $resultado=pg_exec("INSERT INTO consulta SELECT DISTINCT stzderec.solicitud FROM stzderec, stpinved WHERE stpinved.nombre_inv like '$valor%' 
                                AND stzderec.nro_derecho=stpinved.nro_derecho 
				AND stzderec.tipo_mp='P'");
            break;                    
          case TIPO:
	         $resultado=pg_exec("INSERT INTO consulta SELECT solicitud FROM stzderec WHERE tipo_derecho like '$valor%' AND stzderec.tipo_mp='P'");
            break;
          case TITULAR:
            $resultado=pg_exec("INSERT INTO consulta SELECT DISTINCT stzderec.solicitud 
		                       FROM stzottid, stzsolic, stzderec 
				       WHERE stzsolic.nombre like '$valor%' 
				       AND stzderec.nro_derecho=stzottid.nro_derecho
		                       AND stzsolic.titular = stzottid.titular
		  		       AND stzderec.tipo_mp='P' "); 
            break;
          case RESUMEN:
            $resultado=pg_exec("INSERT INTO consulta SELECT stzderec.solicitud
			                       FROM stzderec, stppatee 
					       WHERE stppatee.resumen  like '$valor%' 
			                       AND stzderec.nro_derecho=stppatee.nro_derecho 
						AND stzderec.tipo_mp='P'");
            break;
          case TITULORESUMEN:
		      $resultado = pg_exec("INSERT INTO consulta SELECT stzderec.solicitud
                      FROM stzderec 
			             WHERE stzderec.tipo_mp='P'
                      AND stzderec.nombre LIKE '$valor%'
			             UNION 
                      SELECT stzderec.solicitud
                      FROM stppatee, stzderec 
                      WHERE stzderec.nro_derecho=stppatee.nro_derecho
                      AND stppatee.resumen LIKE '$valor%' 
                      AND stzderec.tipo_mp='P'");
            break;
          case EQUIVALENTE:
            $resultado=pg_exec("INSERT INTO consulta SELECT DISTINCT stzderec.solicitud 
			              FROM stzderec, stpequiv  
				      WHERE stpequiv.equivalente like '$valor%'
			              AND stpequiv.nro_derecho = stzderec.nro_derecho 
				      AND stzderec.tipo_mp='P'"); 
            break;
          case PRIORIDAD:
            $resultado=pg_exec("INSERT INTO consulta SELECT DISTINCT stzderec.solicitud 
			        FROM stzderec, stzpriod 
				WHERE stzpriod.prioridad like '$valor%'
				AND stzderec.nro_derecho=stzpriod.nro_derecho
			        AND stzderec.tipo_mp='P' ");

            break;
          case CLASIFICACION:	
            $resultado=pg_exec("INSERT INTO consulta SELECT DISTINCT stzderec.solicitud 
			           FROM stpclsfd, stzderec
				   WHERE stpclsfd.clasificacion like '$valor%'
			           AND stzderec.nro_derecho=stpclsfd.nro_derecho
		        	   AND stzderec.tipo_mp='P' "); 
            break;
          case LOCARNO:
            $resultado=pg_exec("INSERT INTO consulta SELECT stzderec.solicitud 
			        FROM stplocad, stzderec 
				WHERE stplocad.clasi_locarno like '$valor%'
			        AND stzderec.nro_derecho=stplocad.nro_derecho
		        	AND stzderec.tipo_mp='P' "); 
            break;
          case PAIS:
            $resultado=pg_exec("INSERT INTO consulta SELECT stzderec.solicitud 
				     FROM stzderec, stzpaisr 
				     WHERE stzpaisr.nombre like '$valor%' 
                                     AND stzderec.pais_resid=stzpaisr.pais
		                     AND stzderec.tipo_mp='P'");
            break;
          case SOLICITUD:
            $resultado=pg_exec("INSERT INTO consulta SELECT stzderec.solicitud 
                                FROM stzderec WHERE stzderec.solicitud like '$valor%' 
				AND stzderec.tipo_mp='P' ");
            break;
          case REGISTRO:
            $resultado=pg_exec("INSERT INTO consulta SELECT stzderec.solicitud 
                                FROM stzderec 
				WHERE stzderec.registro like '$valor%' and registro!=''
				AND stzderec.tipo_mp='P' ");
            break;
          case TRAMITANTE:
	         $resultado=pg_exec("INSERT INTO consulta SELECT stzderec.solicitud 
				     FROM stzderec WHERE stzderec.tramitante like '$valor%'
				     AND stzderec.tipo_mp='P' ");
            break;
          case AGENTE:
	         $resultado=pg_exec("INSERT INTO consulta SELECT DISTINCT stzderec.solicitud 
			              FROM stzderec, stzautod, stzagenr 
		                      WHERE stzagenr.nombre like '$valor%' 
   					AND stzautod.agente = stzagenr.agente
		                         AND stzderec.nro_derecho =stzautod.nro_derecho 
  				         AND stzderec.tipo_mp='P'");
            break;
          case PRESENTACION:
            $resultado=pg_exec("INSERT INTO consulta SELECT stzderec.solicitud 
                                FROM stzderec WHERE stzderec.fecha_solic like '$valor%' AND stzderec.tipo_mp='P' ");
            break;
          case PUBLICACION:
            $resultado=pg_exec("INSERT INTO consulta SELECT stzderec.solicitud 
                                FROM stzderec WHERE stzderec.fecha_publi like '$valor%' AND stzderec.tipo_mp='P'");
            break;
          case VENCIMIENTO:
            $resultado=pg_exec("INSERT INTO consulta SELECT stzderec.solicitud 
                                FROM stzderec WHERE stzderec.fecha_venc like '$valor%' AND stzderec.tipo_mp='P'");
            break;
          case BOLETIN:
            $resultado=pg_exec("INSERT INTO consulta SELECT stzderec.solicitud 
			                       FROM stzderec,stzevtrd WHERE stzevtrd.documento like '$valor%' 
			                       AND stzderec.nro_derecho = stzevtrd.nro_derecho 
			                       AND stzderec.tipo_mp='P'"); 
            break;
          case PALABRA:
            $resultado=pg_exec("INSERT INTO consulta SELECT DISTINCT stppacld.solicitud 
			                       FROM stptesar, stppacld WHERE stptesar.palabra like '$valor%' 
			                       AND stptesar.apuntador=stppacld.apuntador"); 
            break;
          case ESTATUS:
            $resultado=pg_exec("INSERT INTO consulta SELECT stzderec.solicitud 
			                       FROM stzderec WHERE stzderec.estatus like '$valor%' AND stzderec.tipo_mp='P'"); 
            break;
          case PODER:
            $resultado=pg_exec("INSERT INTO consulta SELECT stzderec.solicitud 
			                       FROM stzderec WHERE stzderec.poder like '$valor%' AND stzderec.tipo_mp='P'"); 
            break;          
        }
       break;
   }
  }
  return $resultado;
}

?>
