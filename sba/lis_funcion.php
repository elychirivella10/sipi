<?php 
// (Lis_funcion.php)
// Realizado Por Ing. Karina Perez

//includes 
include ("inc/constantes.inc");

function sqlcompara($campo,$criterio,$valor)
{

  if(!empty($valor)) {
   switch($criterio)
   {
     case BÚSQUEDA_NOMBRE_PALABRA_CONTENIDA:
       switch($campo)
        {
          case SOLICITUD:
	         $resultado=pg_exec("INSERT INTO consulta SELECT solicitud FROM stdobras WHERE solicitud like '%$valor%' ");
            break;
          case REGISTRO:
	         $resultado=pg_exec("INSERT INTO consulta SELECT solicitud FROM stdobras WHERE registro like '%$valor%' ");
            break;                    
          case FECHA:
	         $resultado=pg_exec("INSERT INTO consulta SELECT solicitud 
FROM stdobras WHERE fecha_solic like '%$valor%'");
            break;
          case ESTATUS:
            $resultado=pg_exec("INSERT INTO consulta SELECT solicitud 
			                       FROM stdobras WHERE estatus like '%$valor%'"); 
            break;
          case TIPO:
            $resultado=pg_exec("INSERT INTO consulta SELECT solicitud 
			                       FROM stdobras WHERE tipo_obra like '%$valor%'");
            break;
 
          case PAIS:
            $resultado=pg_exec("INSERT INTO consulta SELECT solicitud 
				     FROM stdobras
				     WHERE pais_origen like '%$valor%' ");

            break;
          case TITULO:	
            $resultado=pg_exec("INSERT INTO consulta SELECT solicitud 
				     FROM stdobras
				     WHERE titulo_obra like '%$valor%'"); 
            break;
          case DESCRIPCION:
            $resultado=pg_exec("INSERT INTO consulta SELECT solicitud 
				     FROM stdobras
				     WHERE descrip_obra like '%$valor%'"); 
            break;
          case AUTOR:
	     $resultado =pg_exec("INSERT INTO consulta SELECT stdobras.solicitud 
					FROM stdobras, stdobaut, stzsolic
					WHERE stzsolic.nombre LIKE '%$valor%' 
					and stzsolic.titular = stdobaut.titular
					and stdobaut.nro_derecho = stdobras.nro_derecho");
              break;
          case SOLICITANTE:
            $resultado =pg_exec("INSERT INTO consulta SELECT stdobras.solicitud 
			       FROM stzsolic,stdobsol, stdobras
			       WHERE stzsolic.nombre LIKE '%$valor%' 
			       AND stzsolic.titular = stdobsol.titular 
			       and stdobsol.nro_derecho = stdobras.nro_derecho ");

            break;
          case PLANILLA:
	         $resultado=pg_exec("INSERT INTO consulta SELECT solicitud 
				     FROM stdobras
				     WHERE nplanilla like '%$valor%'");
            break;
     
        }
       break;


     case BÚSQUEDA_NOMBRE_PALABRAS_EXACTAS:
            switch($campo)
        {
          case SOLICITUD:
	         $resultado=pg_exec("INSERT INTO consulta SELECT solicitud FROM stdobras WHERE solicitud = '$valor' ");
            break;
          case REGISTRO:
	         $resultado=pg_exec("INSERT INTO consulta SELECT solicitud FROM stdobras WHERE registro = '$valor' ");
            break;                    
          case FECHA:
	         $resultado=pg_exec("INSERT INTO consulta SELECT solicitud 
FROM stdobras WHERE fecha_solic = '$valor'");
            break;
          case ESTATUS:
            $resultado=pg_exec("INSERT INTO consulta SELECT solicitud 
			                       FROM stdobras WHERE estatus = '$valor'"); 
            break;
          case TIPO:
            $resultado=pg_exec("INSERT INTO consulta SELECT solicitud 
			                       FROM stdobras WHERE tipo_obra = '$valor'");
            break;

          case PAIS:
            $resultado=pg_exec("INSERT INTO consulta SELECT solicitud 
				     FROM stdobras
				     WHERE pais_origen = '$valor' ");

            break;
          case TITULO:	
            $resultado=pg_exec("INSERT INTO consulta SELECT solicitud 
				     FROM stdobras
				     WHERE titulo_obra = '$valor'"); 
            break;
          case DESCRIPCION:
            $resultado=pg_exec("INSERT INTO consulta SELECT solicitud 
				     FROM stdobras
				     WHERE descrip_obra = '$valor'"); 
            break;
          case AUTOR:
	     $resultado =pg_exec("INSERT INTO consulta SELECT stdobras.solicitud 
					FROM stdobras, stdobaut, stzsolic
					WHERE stzsolic.nombre LIKE '$valor' 
					and stzsolic.titular = stdobaut.titular
					and stdobaut.nro_derecho = stdobras.nro_derecho");
            break;
          case SOLICITANTE:
            $resultado =pg_exec("INSERT INTO consulta SELECT stdobras.solicitud 
			       FROM stzsolic,stdobsol, stdobras
			       WHERE stzsolic.nombre LIKE '$valor' 
			       AND stzsolic.titular = stdobsol.titular 
			       and stdobsol.nro_derecho = stdobras.nro_derecho ");
            break;
          case PLANILLA:
	         $resultado=pg_exec("INSERT INTO consulta SELECT solicitud 
				     FROM stdobras
				     WHERE nplanilla = '$valor'");
            break;
    
        }
       break;

     case BÚSQUEDA_NOMBRE_COMIENCE_POR:
        switch($campo)
        {
           case SOLICITUD:
	         $resultado=pg_exec("INSERT INTO consulta SELECT solicitud FROM stdobras WHERE solicitud like '$valor%' ");
            break;
          case REGISTRO:
	         $resultado=pg_exec("INSERT INTO consulta SELECT solicitud FROM stdobras WHERE registro like '$valor%' ");
            break;                    
          case FECHA:
	         $resultado=pg_exec("INSERT INTO consulta SELECT solicitud 
FROM stdobras WHERE fecha_solic like '$valor%'");
            break;
          case ESTATUS:
            $resultado=pg_exec("INSERT INTO consulta SELECT solicitud 
			                       FROM stdobras WHERE estatus like '$valor%'"); 
            break;
          case TIPO:
            $resultado=pg_exec("INSERT INTO consulta SELECT solicitud 
			                       FROM stdobras WHERE tipo_obra like '$valor%'");
            break;

          case PAIS:
            $resultado=pg_exec("INSERT INTO consulta SELECT solicitud 
				     FROM stdobras
				     WHERE pais_origen like '$valor%' ");

            break;
          case TITULO:	
            $resultado=pg_exec("INSERT INTO consulta SELECT solicitud 
				     FROM stdobras
				     WHERE titulo_obra like '$valor%'"); 
            break;
          case DESCRIPCION:
            $resultado=pg_exec("INSERT INTO consulta SELECT solicitud 
				     FROM stdobras
				     WHERE descrip_obra like '$valor%'"); 
            break;
          case AUTOR:
	     $resultado =pg_exec("INSERT INTO consulta SELECT stdobras.solicitud 
					FROM stdobras, stdobaut, stzsolic
					WHERE stzsolic.nombre LIKE '$valor%' 
					and stzsolic.titular = stdobaut.titular
					and stdobaut.nro_derecho = stdobras.nro_derecho");
            break;
          case SOLICITANTE:
            $resultado =pg_exec("INSERT INTO consulta SELECT stdobras.solicitud 
			       FROM stzsolic,stdobsol, stdobras
			       WHERE stzsolic.nombre LIKE '$valor%' 
			       AND stzsolic.titular = stdobsol.titular 
			       and stdobsol.nro_derecho = stdobras.nro_derecho ");
            break;
          case PLANILLA:
	         $resultado=pg_exec("INSERT INTO consulta SELECT solicitud 
				     FROM stdobras
				     WHERE nplanilla like '$valor%'");
            break;
      
        }
       break;
   
      case AUTOR:
	$numero=substr($valor,1,9);
	$letra=substr($valor,0,1);
	$numero1 = str_pad($numero, 9, "0", STR_PAD_LEFT); 
	$valor=$letra.$numero1;
        switch($campo)
        {
 	case DOCUMENTO:
	     $resultado =pg_exec("INSERT INTO consulta SELECT stdobras.solicitud 
					FROM stzsolic,stdobaut, stdobras
					WHERE stzsolic.identificacion = '$valor' 
					and stdobaut.nro_derecho = stdobras.nro_derecho 
					and stzsolic.titular = stdobaut.titular");
            break;   
        }
       break;

      case SOLICITANTE:
	$numero=substr($valor,1,9);
	$letra=substr($valor,0,1);
	$numero1 = str_pad($numero, 9, "0", STR_PAD_LEFT); 
	$valor=$letra.$numero1;
        switch($campo)
        {
 	case DOCUMENTO:
            $resultado =pg_exec("INSERT INTO consulta SELECT stdobras.solicitud 
			       FROM stzsolic,stdobsol, stdobras
			       WHERE stzsolic.identificacion LIKE '$valor' 
			       AND stzsolic.titular = stdobsol.titular 
			       and stdobsol.nro_derecho = stdobras.nro_derecho ");
            break;   
        }
       break;

       case ARTISTA:
	$numero=substr($valor,1,9);
	$letra=substr($valor,0,1);
	$numero1 = str_pad($numero, 9, "0", STR_PAD_LEFT); 
	$valor=$letra.$numero1;
        switch($campo)
        {
 	case DOCUMENTO:
	     $resultado =pg_exec("INSERT INTO consulta SELECT stdobras.solicitud  
			       FROM stzsolic,stdobart, stdobras 
			       WHERE stzsolic.identificacion = '$valor' 
				and stdobart.nro_derecho = stdobras.nro_derecho 
				and stzsolic.titular = stdobart.titular");
            break;   
        }
       break;

       case PRODUCTOR:
	$numero=substr($valor,1,9);
	$letra=substr($valor,0,1);
	$numero1 = str_pad($numero, 9, "0", STR_PAD_LEFT); 
	$valor=$letra.$numero1;
        switch($campo)
        {
 	case DOCUMENTO:
	     $resultado =pg_exec("INSERT INTO consulta SELECT stdobras.solicitud  
			       FROM stzsolic,stdobpro, stdobras 
			       WHERE stzsolic.identificacion ='$valor'
				and stdobpro.nro_derecho = stdobras.nro_derecho 
			       AND stzsolic.titular = stdobpro.titular ");
            break;   
        }
       break;

       case TITULAR:
	$numero=substr($valor,1,9);
	$letra=substr($valor,0,1);
	$numero1 = str_pad($numero, 9, "0", STR_PAD_LEFT); 
	$valor=$letra.$numero1;
        switch($campo)
        {
 	case DOCUMENTO:
	     $resultado =pg_exec("INSERT INTO consulta SELECT stdobras.solicitud
			       FROM stzsolic,stdobtit, stdobras
			       WHERE stzsolic.identificacion = '$valor'
				and stdobtit.nro_derecho = stdobras.nro_derecho 
			       AND stzsolic.titular = stdobtit.titular");
            break;   
        }
       break;

       case REPRESENTANTE:
	$numero=substr($valor,1,9);
	$letra=substr($valor,0,1);
	$numero1 = str_pad($numero, 9, "0", STR_PAD_LEFT); 
	$valor=$letra.$numero1;
        switch($campo)
        {
 	case DOCUMENTO:
	     $resultado =pg_exec("INSERT INTO consulta SELECT stdobras.solicitud 
			       FROM stdobras, stdrepre 
			       WHERE stdrepre.cedula_repre = '$valor'
			       AND stdrepre.nro_derecho = stdobras.nro_derecho ");
            break;   
        }
       break;


   }
  }
  return $resultado;
}

?>
