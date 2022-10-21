<?php
//Para trabajar con Operaciones de Bases de Datos
include ("../z_includes.php");


 //Verificando conexion
 $sql->connection();

 $obj_query = $sql->query("update stzsystem set nro_derecho=nextval('stzsystem_nro_derecho_seq')");
 if ($obj_query) {
      $obj_query = $sql->query("select last_value from stzsystem_nro_derecho_seq");
      $objs = $sql->objects('',$obj_query);
      $prox_derecho = $objs->last_value; }
  echo "nro_derecho = $prox_derecho ";
  exit();  
 }

?>
