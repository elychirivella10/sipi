<html>
<head>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
 <LINK REL="STYLESHEET" TYPE="text/css" HREF="../main.css">

<?php 
// (Lis_funcion.php)
// Realizado Por Ing. Romulo Mendoza

//includes 
include ("inc/constantes.inc");

function sqlcompara($campo,$criterio,$valor)
{
  //echo "en funcion= $campo, $criterio, $valor ";
  $valor=trim($valor);
  //$valor=utf8_encode($valor);
  
  if(!empty($valor)) {
   switch($criterio)
   {
     case BÚSQUEDA_NOMBRE_PALABRAS_EXACTAS:
       $Uvalor=strtoupper($valor);
       $Lvalor=strtolower($valor); 
       $Tvalor=strtoupper(substr($valor,0,1)).strtolower(substr($valor,1)); 
       switch($campo)
        {
          case TITULO:
	         $resultado=pg_exec("INSERT INTO consulta SELECT solicitud FROM stzderec 
                                  WHERE (nombre = '$Uvalor' or nombre = '$Lvalor' or nombre = '$Tvalor') 
                                  AND stzderec.tipo_mp='P' ");
            break;
          case INVENTOR:
	         $resultado=pg_exec("INSERT INTO consulta SELECT DISTINCT stzderec.solicitud FROM stzderec, stpinved 
                                  WHERE (stpinved.nombre_inv = '$Uvalor' or stpinved.nombre_inv = '$Lvalor' or stpinved.nombre_inv = '$Tvalor') 
                                AND stzderec.nro_derecho=stpinved.nro_derecho 
				AND stzderec.tipo_mp='P'");
            break;                    
          case TIPO:
	         $resultado=pg_exec("INSERT INTO consulta SELECT solicitud FROM stzderec 
                                  WHERE (tipo_derecho = '$Uvalor' or tipo_derecho = '$Lvalor') AND stzderec.tipo_mp='P'");
            break;
          case TITULAR:
            $resultado=pg_exec("INSERT INTO consulta SELECT DISTINCT stzderec.solicitud 
		                       FROM stzottid, stzsolic, stzderec 
				       WHERE (stzsolic.nombre = '$Uvalor' or stzsolic.nombre = '$Lvalor' or stzsolic.nombre = '$Tvalor')
				       AND stzderec.nro_derecho=stzottid.nro_derecho
		                       AND stzsolic.titular = stzottid.titular
		  		       AND stzderec.tipo_mp='P' "); 
            break;
          case RESUMEN:
            $resultado=pg_exec("INSERT INTO consulta SELECT stzderec.solicitud
			                       FROM stzderec, stppatee 
					       WHERE (stppatee.resumen  = '$Uvalor' or stppatee.resumen  = '$Lvalor' or stppatee.resumen  = '$Tvalor') 
			                       AND stzderec.nro_derecho=stppatee.nro_derecho 
						AND stzderec.tipo_mp='P'");
            break;
          case EQUIVALENTE:
            $resultado=pg_exec("INSERT INTO consulta SELECT DISTINCT stzderec.solicitud 
			              FROM stzderec, stpequiv  
				      WHERE (stpequiv.equivalente = '$Uvalor' or stpequiv.equivalente = '$Lvalor' or stpequiv.equivalente = '$Tvalor')
			              AND stpequiv.nro_derecho = stzderec.nro_derecho 
				      AND stzderec.tipo_mp='P'"); 
            break;
          case PRIORIDAD:
            $resultado=pg_exec("INSERT INTO consulta SELECT DISTINCT stzderec.solicitud 
			        FROM stzderec, stzpriod 
				WHERE (stzpriod.prioridad = '$Uvalor' or stzpriod.prioridad = '$Lvalor' or stzpriod.prioridad = '$Tvalor')
				AND stzderec.nro_derecho=stzpriod.nro_derecho
			        AND stzderec.tipo_mp='P' ");

            break;
          case CLASIFICACION:	
            $resultado=pg_exec("INSERT INTO consulta SELECT DISTINCT stzderec.solicitud 
			           FROM stpclsfd, stzderec
				   WHERE (stpclsfd.clasificacion = '$Uvalor' or stpclsfd.clasificacion = '$Lvalor' or stpclsfd.clasificacion = '$Tvalor')
			           AND stzderec.nro_derecho=stpclsfd.nro_derecho
		        	   AND stzderec.tipo_mp='P' "); 
            break;
          case LOCARNO:
            $resultado=pg_exec("INSERT INTO consulta SELECT stzderec.solicitud 
			        FROM stplocad, stzderec 
				WHERE (stplocad.clasi_locarno = '$Uvalor' or stplocad.clasi_locarno = '$Lvalor' or stplocad.clasi_locarno = '$Tvalor')
			        AND stzderec.nro_derecho=stplocad.nro_derecho
		        	AND stzderec.tipo_mp='P' "); 
            break;
          case PAIS:
            $resultado=pg_exec("INSERT INTO consulta SELECT stzderec.solicitud 
				     FROM stzderec, stzpaisr 
				     WHERE (stzpaisr.nombre = '$Uvalor' or stzpaisr.nombre = '$Lvalor' or stzpaisr.nombre = '$Tvalor')
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
				WHERE (stzderec.registro = '$Uvalor' or stzderec.registro = '$Lvalor') and registro!=''
				AND stzderec.tipo_mp='P' ");
            break;
          case TRAMITANTE:
	         $resultado=pg_exec("INSERT INTO consulta SELECT stzderec.solicitud 
				     FROM stzderec WHERE (stzderec.tramitante = '$Uvalor' or stzderec.tramitante = '$Lvalor' or stzderec.tramitante = '$Tvalor')
				     AND stzderec.tipo_mp='P' ");
            break;
          case AGENTE:
	         $resultado=pg_exec("INSERT INTO consulta SELECT DISTINCT stzderec.solicitud 
			              FROM stzderec, stzautod, stzagenr 
		                      WHERE (stzagenr.nombre = '$Uvalor' or stzagenr.nombre = '$Lvalor' or stzagenr.nombre = '$Tvalor') 
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
            $resultado=pg_exec("INSERT INTO consulta SELECT DISTINCT stzderec.solicitud 
	                       FROM stptesar, stppacld, stzderec WHERE (stptesar.palabra = '$Uvalor' or stptesar.palabra = '$Lvalor' or stptesar.palabra = '$Tvalor') 
			                       AND stptesar.apuntador=stppacld.apuntador AND stzderec.nro_derecho=stppacld.nro_derecho");
            break;
          case ESTATUS:
            $resultado=pg_exec("INSERT INTO consulta SELECT stzderec.solicitud 
			                       FROM stzderec WHERE stzderec.estatus = (2000+$valor) AND stzderec.tipo_mp='P'"); 
            break;
          case PODER:
            $resultado=pg_exec("INSERT INTO consulta SELECT stzderec.solicitud 
			                       FROM stzderec WHERE stzderec.poder = '$valor' AND stzderec.tipo_mp='P'"); 
            break;    
          case EVENTO:
            $resultado=pg_exec("INSERT INTO consulta SELECT stzderec.solicitud 
                             FROM stzderec,stzevtrd WHERE stzevtrd.evento = (2000+$valor) 
                             AND stzderec.nro_derecho = stzevtrd.nro_derecho 
                             AND stzderec.tipo_mp='P'"); 
            break;
        }
       break;


     case BÚSQUEDA_NOMBRE_PALABRA_CONTENIDA:
       $Uvalor=strtoupper($valor);
       $Lvalor=strtolower($valor);  
       $Tvalor=strtoupper(substr($valor,0,1)).strtolower(substr($valor,1));  
       //$Uvalor=str_replace('ñ','Ñ',$Uvalor);
       //$Lvalor=str_replace('Ñ','ñ',$Lvalor); 
       switch($campo)
        {
          case TITULO:
	         $resultado=pg_exec("INSERT INTO consulta SELECT solicitud FROM stzderec 
                                   WHERE (nombre like '%$Uvalor%' or nombre like '%$Lvalor%' or nombre like '%$Tvalor%') 
                                     AND stzderec.tipo_mp='P'");
            break;
          case INVENTOR:
	         $resultado=pg_exec("INSERT INTO consulta SELECT DISTINCT stzderec.solicitud FROM stzderec, stpinved 
                             WHERE (stpinved.nombre_inv like '%$Uvalor%' or stpinved.nombre_inv like '%$Lvalor%' or stpinved.nombre_inv like '%$Tvalor%') 
                               AND stzderec.nro_derecho=stpinved.nro_derecho 
				AND stzderec.tipo_mp='P'");
            break;                    
          case TIPO:
	         $resultado=pg_exec("INSERT INTO consulta SELECT solicitud FROM stzderec 
                                WHERE (tipo_derecho like '%$Uvalor%' or tipo_derecho like '%$Lvalor%')
                                AND stzderec.tipo_mp='P'");
            break;
          case TITULAR:
            $resultado=pg_exec("INSERT INTO consulta SELECT DISTINCT stzderec.solicitud 
		                          FROM stzottid, stzsolic, stzderec 
				                    WHERE (stzsolic.nombre like '%$Uvalor%' or stzsolic.nombre like '%$Lvalor%' or stzsolic.nombre like '%$Tvalor%')
				                    AND stzderec.nro_derecho=stzottid.nro_derecho
		                          AND stzsolic.titular = stzottid.titular
		  		                    AND stzderec.tipo_mp='P' "); 
            break;
          case RESUMEN:
            $resultado=pg_exec("INSERT INTO consulta SELECT stzderec.solicitud
			                   FROM stzderec, stppatee 
					        WHERE (stppatee.resumen LIKE '%$Uvalor%' or stppatee.resumen LIKE '%$Lvalor%' or stppatee.resumen LIKE '%$Tvalor%') 
                                   AND stzderec.nro_derecho=stppatee.nro_derecho AND stzderec.tipo_mp='P'");
            break;
          case TITULORESUMEN:
            $valormin = strtolower($valor);
            $valormay = strtoupper($valor);
		      $resultado = pg_exec("INSERT INTO consulta SELECT stzderec.solicitud
                          FROM stzderec 
			                 WHERE stzderec.tipo_mp='P'
                          AND (stzderec.nombre LIKE '%$Uvalor%' or stzderec.nombre LIKE '%$Lvalor%' or stzderec.nombre LIKE '%$Tvalor%')
			                 UNION 
                          SELECT stzderec.solicitud
                          FROM stppatee, stzderec 
                          WHERE stzderec.nro_derecho=stppatee.nro_derecho
                          AND (stppatee.resumen LIKE '%$Uvalor%' or stppatee.resumen LIKE '%$Lvalor%' or stppatee.resumen LIKE '%$Tvalor%')
                          AND stzderec.tipo_mp='P'");
            break;
          case EQUIVALENTE:
            $resultado=pg_exec("INSERT INTO consulta SELECT DISTINCT stzderec.solicitud 
			              FROM stzderec, stpequiv  
				      WHERE (stpequiv.equivalente like '%$Uvalor%' or stpequiv.equivalente like '%$Lvalor%' or stpequiv.equivalente like '%$Tvalor%')
			              AND stpequiv.nro_derecho = stzderec.nro_derecho 
				      AND stzderec.tipo_mp='P'"); 
            break;
          case PRIORIDAD:
            $resultado=pg_exec("INSERT INTO consulta SELECT DISTINCT stzderec.solicitud 
			        FROM stzderec, stzpriod 
				WHERE (stzpriod.prioridad like '%$Uvalor%' or stzpriod.prioridad like '%$Lvalor%' or stzpriod.prioridad like '%$Tvalor%')
				AND stzderec.nro_derecho=stzpriod.nro_derecho
			        AND stzderec.tipo_mp='P' ");

            break;
          case CLASIFICACION:	
            $resultado=pg_exec("INSERT INTO consulta SELECT DISTINCT stzderec.solicitud 
			           FROM stpclsfd, stzderec
				   WHERE (stpclsfd.clasificacion like '%$Uvalor%' or stpclsfd.clasificacion like '%$Lvalor%' or stpclsfd.clasificacion like '%$Tvalor%') AND stzderec.nro_derecho=stpclsfd.nro_derecho
		        	   AND stzderec.tipo_mp='P' "); 
            break;
          case LOCARNO:
            $resultado=pg_exec("INSERT INTO consulta SELECT stzderec.solicitud 
			        FROM stplocad, stzderec 
				WHERE (stplocad.clasi_locarno like '%$Uvalor%' or stplocad.clasi_locarno like '%$Lvalor%' or stplocad.clasi_locarno like '%$Tvalor%')
			        AND stzderec.nro_derecho=stplocad.nro_derecho
		        	AND stzderec.tipo_mp='P' "); 
            break;
          case PAIS:
            $resultado=pg_exec("INSERT INTO consulta SELECT stzderec.solicitud 
				     FROM stzderec, stzpaisr 
				     WHERE (stzpaisr.nombre like '%$Uvalor%' or stzpaisr.nombre like '%$Lvalor%' or stzpaisr.nombre like '%$Tvalor%') 
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
				WHERE (stzderec.registro like '%$Uvalor%' or stzderec.registro like '%$Lvalor%') and registro!=''
				AND stzderec.tipo_mp='P' ");
            break;
          case TRAMITANTE:
	         $resultado=pg_exec("INSERT INTO consulta SELECT stzderec.solicitud 
				     FROM stzderec WHERE (stzderec.tramitante like '%$Uvalor%' or stzderec.tramitante like '%$Lvalor%' or stzderec.tramitante like '%$Tvalor%') AND stzderec.tipo_mp='P' ");
            break;
          case AGENTE:
	         $resultado=pg_exec("INSERT INTO consulta SELECT DISTINCT stzderec.solicitud 
			              FROM stzderec, stzautod, stzagenr 
		                      WHERE (stzagenr.nombre like '%$Uvalor%' or stzagenr.nombre like '%$Lvalor%' or stzagenr.nombre like '%$Tvalor%') 
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
            $resultado=pg_exec("INSERT INTO consulta SELECT DISTINCT stzderec.solicitud 
			                       FROM stptesar, stppacld, stzderec WHERE (stptesar.palabra like '%$Uvalor%' or stptesar.palabra like '%$Lvalor%' or stptesar.palabra like '%$Tvalor%') AND stptesar.apuntador=stppacld.apuntador AND stzderec.nro_derecho=stppacld.nro_derecho"); 
            break;
          case ESTATUS:
            $resultado=pg_exec("INSERT INTO consulta SELECT stzderec.solicitud 
			                       FROM stzderec WHERE stzderec.estatus like '%$valor%' AND stzderec.tipo_mp='P'"); 
            break;
          case PODER:
            $resultado=pg_exec("INSERT INTO consulta SELECT stzderec.solicitud 
			                       FROM stzderec WHERE stzderec.poder like '%$valor%' AND stzderec.tipo_mp='P'"); 
            break;          
          case OBSERVATITULORESUMEN:
            $resultado = pg_exec("INSERT INTO consulta SELECT stzderec.solicitud
                                  FROM stzderec 
			                         WHERE stzderec.tipo_mp='P'
                                  AND (stzderec.nombre LIKE '%$Uvalor%' or stzderec.nombre LIKE '%$Lvalor%' or stzderec.nombre LIKE '%$Tvalor%')
			                         UNION 
                                  SELECT stzderec.solicitud
                                  FROM stppatee, stzderec 
                                  WHERE stzderec.nro_derecho=stppatee.nro_derecho
                                  AND (stppatee.resumen LIKE '%$Uvalor%' or stppatee.resumen LIKE '%$Lvalor%' or stppatee.resumen LIKE '%$Tvalor%')
                                  UNION
                                  SELECT stzderec.solicitud
                                  FROM stppatee, stzderec, stpnotas 
                                  WHERE stzderec.nro_derecho=stppatee.nro_derecho
                                  AND stzderec.nro_derecho=stpnotas.nro_derecho
                                  AND (stpnotas.notas LIKE '%$Uvalor%' or stpnotas.notas LIKE '%$Lvalor%' or stpnotas.notas LIKE '%$Tvalor%')
                                  AND stzderec.tipo_mp='P'");
            break;
          case EVENTO:
            $resultado=pg_exec("INSERT INTO consulta SELECT stzderec.solicitud 
                             FROM stzderec,stzevtrd WHERE stzevtrd.evento LIKE '%$valor%' 
                             AND stzderec.nro_derecho = stzevtrd.nro_derecho 
                             AND stzderec.tipo_mp='P'"); 
            break;

        }
       break;

     case BÚSQUEDA_NOMBRE_COMIENCE_POR:
       $Uvalor=strtoupper($valor);
       $Lvalor=strtolower($valor); 
       $Tvalor=strtoupper(substr($valor,0,1)).strtolower(substr($valor,1)); 
        switch($campo)
        {
          case TITULO:
	         $resultado=pg_exec("INSERT INTO consulta SELECT solicitud FROM stzderec WHERE (nombre like '$Uvalor%' or nombre like '$Lvalor%' or nombre like '$Tvalor%') AND stzderec.tipo_mp='P' ");
            break;
          case INVENTOR:
	         $resultado=pg_exec("INSERT INTO consulta SELECT DISTINCT stzderec.solicitud FROM stzderec, stpinved 
                                 WHERE (stpinved.nombre_inv like '$Uvalor%' or stpinved.nombre_inv like '$Lvalor%' or stpinved.nombre_inv like '$Tvalor%')
                                AND stzderec.nro_derecho=stpinved.nro_derecho 
				AND stzderec.tipo_mp='P'");
            break;                    
          case TIPO:
	         $resultado=pg_exec("INSERT INTO consulta SELECT solicitud FROM stzderec 
                                  WHERE (tipo_derecho like '$Uvalor%' or tipo_derecho like '$Lvalor%' or tipo_derecho like '$Tvalor%') 
                                  AND stzderec.tipo_mp='P'");
            break;
          case TITULAR:
            $resultado=pg_exec("INSERT INTO consulta SELECT DISTINCT stzderec.solicitud 
		                       FROM stzottid, stzsolic, stzderec 
				       WHERE (stzsolic.nombre like '$Uvalor%' or stzsolic.nombre like '$Lvalor%' or stzsolic.nombre like '$Tvalor%')
				       AND stzderec.nro_derecho=stzottid.nro_derecho
		                       AND stzsolic.titular = stzottid.titular
		  		       AND stzderec.tipo_mp='P' "); 
            break;
          case RESUMEN:
            $resultado=pg_exec("INSERT INTO consulta SELECT stzderec.solicitud
			                       FROM stzderec, stppatee 
					       WHERE (stppatee.resumen  like '$Uvalor%' or stppatee.resumen like '$Lvalor%' or stppatee.resumen like '$Tvalor%') 
			                       AND stzderec.nro_derecho=stppatee.nro_derecho 
						AND stzderec.tipo_mp='P'");
            break;
          case TITULORESUMEN:
		      $resultado = pg_exec("INSERT INTO consulta SELECT stzderec.solicitud
                      FROM stzderec 
			             WHERE stzderec.tipo_mp='P'
                      AND (stzderec.nombre LIKE '$Uvalor%' or stzderec.nombre LIKE '$Lvalor%' or stzderec.nombre LIKE '$Tvalor%')
			             UNION 
                      SELECT stzderec.solicitud
                      FROM stppatee, stzderec 
                      WHERE stzderec.nro_derecho=stppatee.nro_derecho
                      AND (stppatee.resumen LIKE '$Uvalor%' or stppatee.resumen LIKE '$Lvalor%' or stppatee.resumen LIKE '$Tvalor%')
                      AND stzderec.tipo_mp='P'");
            break;
          case EQUIVALENTE:
            $resultado=pg_exec("INSERT INTO consulta SELECT DISTINCT stzderec.solicitud 
			              FROM stzderec, stpequiv  
				      WHERE (stpequiv.equivalente like '$Uvalor%' or stpequiv.equivalente like '$Lvalor%' or stpequiv.equivalente like '$Tvalor%')
			              AND stpequiv.nro_derecho = stzderec.nro_derecho 
				      AND stzderec.tipo_mp='P'"); 
            break;
          case PRIORIDAD:
            $resultado=pg_exec("INSERT INTO consulta SELECT DISTINCT stzderec.solicitud 
			        FROM stzderec, stzpriod 
				WHERE (stzpriod.prioridad like '$Uvalor%' or stzpriod.prioridad like '$Lvalor%' or stzpriod.prioridad like '$Tvalor%')
				AND stzderec.nro_derecho=stzpriod.nro_derecho
			        AND stzderec.tipo_mp='P' ");

            break;
          case CLASIFICACION:	
            $resultado=pg_exec("INSERT INTO consulta SELECT DISTINCT stzderec.solicitud 
			           FROM stpclsfd, stzderec
				   WHERE (stpclsfd.clasificacion like '$Uvalor%' or stpclsfd.clasificacion like '$Lvalor%' or stpclsfd.clasificacion like '$Tvalor%')
			           AND stzderec.nro_derecho=stpclsfd.nro_derecho
		        	   AND stzderec.tipo_mp='P' "); 
            break;
          case LOCARNO:
            $resultado=pg_exec("INSERT INTO consulta SELECT stzderec.solicitud 
			        FROM stplocad, stzderec 
				WHERE (stplocad.clasi_locarno like '$Uvalor%' or stplocad.clasi_locarno like '$Lvalor%' or stplocad.clasi_locarno like '$Tvalor%')
			        AND stzderec.nro_derecho=stplocad.nro_derecho
		        	AND stzderec.tipo_mp='P' "); 
            break;
          case PAIS:
            $resultado=pg_exec("INSERT INTO consulta SELECT stzderec.solicitud 
				     FROM stzderec, stzpaisr 
				     WHERE (stzpaisr.nombre like '$Uvalor%' or stzpaisr.nombre like '$Lvalor%' or stzpaisr.nombre like '$Tvalor%') 
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
				WHERE (stzderec.registro like '$Uvalor%' or stzderec.registro like '$Lvalor%') and registro!=''
				AND stzderec.tipo_mp='P' ");
            break;
          case TRAMITANTE:
	         $resultado=pg_exec("INSERT INTO consulta SELECT stzderec.solicitud 
				     FROM stzderec WHERE (stzderec.tramitante like '$Uvalor%' or stzderec.tramitante like '$Lvalor%' or stzderec.tramitante like '$Tvalor%') AND stzderec.tipo_mp='P' ");
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
            $resultado=pg_exec("INSERT INTO consulta SELECT DISTINCT stzderec.solicitud 
			                       FROM stptesar, stppacld, stzderec WHERE (stptesar.palabra like '$Uvalor%' or stptesar.palabra like '$Lvalor%' or stptesar.palabra like '$Tvalor%') AND stptesar.apuntador=stppacld.apuntador AND stzderec.nro_derecho=stppacld.nro_derecho"); 
            break;
          case ESTATUS:
            $resultado=pg_exec("INSERT INTO consulta SELECT stzderec.solicitud 
			                       FROM stzderec WHERE stzderec.estatus like '$valor%' AND stzderec.tipo_mp='P'"); 
            break;
          case PODER:
            $resultado=pg_exec("INSERT INTO consulta SELECT stzderec.solicitud 
			                       FROM stzderec WHERE stzderec.poder like '$valor%' AND stzderec.tipo_mp='P'"); 
            break;          
          case OBSERVATITULORESUMEN:
		      $resultado = pg_exec("INSERT INTO consulta SELECT stzderec.solicitud
                      FROM stzderec 
			             WHERE stzderec.tipo_mp='P'
                      AND (stzderec.nombre LIKE '$Uvalor%' or stzderec.nombre LIKE '$Lvalor%' or stzderec.nombre LIKE '$Tvalor%')
			             UNION 
                      SELECT stzderec.solicitud
                      FROM stppatee, stzderec 
                      WHERE stzderec.nro_derecho=stppatee.nro_derecho
                      AND (stppatee.resumen LIKE '$Uvalor%' or stppatee.resumen LIKE '$Lvalor%' or stppatee.resumen LIKE '$Tvalor%') 
			             UNION 
                      SELECT stzderec.solicitud
                      FROM stppatee, stzderec, stpnotas 
                      WHERE stzderec.nro_derecho=stppatee.nro_derecho
                      AND   stzderec.nro_derecho=stpnotas.nro_derecho
                      AND (stpnotas.notas LIKE '$Uvalor%' or stpnotas.notas LIKE '$Lvalor%' or stpnotas.notas LIKE '$Tvalor%')
                      AND stzderec.tipo_mp='P'");
            break;
          case EVENTO:
            $resultado=pg_exec("INSERT INTO consulta SELECT stzderec.solicitud 
                             FROM stzderec,stzevtrd WHERE stzevtrd.evento LIKE '$valor%' 
                             AND stzderec.nro_derecho = stzevtrd.nro_derecho 
                             AND stzderec.tipo_mp='P'"); 
            break;

        }
       break;
   }
  }
  return $resultado;
}

?>
</head>
</html>
