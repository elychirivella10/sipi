<?php
 //Programa solo para refrescar e invocar el metodo de eliminación de la(s) persona(s) Natural(es) o Juridica(s)
 //Clase que contiene los metodos 
 include_once("../include/cpNatuJuri.php");

 //variable POST 
 $psol        = $_POST['idsol'];
 $idcod       = $_POST['elimina'];
 $persona     = $_POST['persona'];
 $solicitante = $_POST['solicitante'];
 $dtipo       = $_POST['dtipo'];
 $derecho     = $_POST['derecho'];
 
 //sleep(1);
 //Declaracion del Objeto a partir de la Clase y usamos su método eliminar
 $objsolicitante=new cpNatuJuri;

 switch ($dtipo) {
     case "Solicitante":
       if ($objsolicitante->eliminar($psol,$idcod,"stdtmpso")==true){
  	      //echo "Registro eliminado correctamente";
	      $consulta=$objsolicitante->consultar($psol,"stdtmpso",$dtipo);}
       else { echo "Ocurrio un error al eliminar"; }
       break;
     case "Productor":
       if ($objsolicitante->eliminar($psol,$idcod,"stdtmppt")==true){
  	      //echo "Registro eliminado correctamente";
	      $consulta=$objsolicitante->consultar($psol,"stdtmppt",$dtipo); }
       else { echo "Ocurrio un error al eliminar"; }
       break;
     case "Autor":
       if ($objsolicitante->eliminar($psol,$idcod,"stdtmpau")==true){
  	      //echo "Registro eliminado correctamente";
	      $consulta=$objsolicitante->consultar($psol,"stdtmpau",$dtipo); }
       else { echo "Ocurrio un error al eliminar"; }
       break;
     case "Coautor1":
       if ($objsolicitante->eliminar($psol,$idcod,"stdtmpco"," and tipo_autor='CD'")==true){
  	      //echo "Registro eliminado correctamente";
	      $consulta=$objsolicitante->consultar($psol,"stdtmpco",$dtipo); }
       else { echo "Ocurrio un error al eliminar"; }
       break;
     case "Coautor2":
       if ($objsolicitante->eliminar($psol,$idcod,"stdtmpco"," and tipo_autor='CA'")==true){
  	      //echo "Registro eliminado correctamente";
	      $consulta=$objsolicitante->consultar($psol,"stdtmpco",$dtipo); }
       else { echo "Ocurrio un error al eliminar"; }
       break;
     case "Coautor3":
       if ($objsolicitante->eliminar($psol,$idcod,"stdtmpco"," and tipo_autor='CG'")==true){
  	      //echo "Registro eliminado correctamente";
	      $consulta=$objsolicitante->consultar($psol,"stdtmpco",$dtipo); }
       else { echo "Ocurrio un error al eliminar"; }
       break;
     case "Coautor4":
       if ($objsolicitante->eliminar($psol,$idcod,"stdtmpco"," and tipo_autor='CM'")==true){
  	      //echo "Registro eliminado correctamente";
	      $consulta=$objsolicitante->consultar($psol,"stdtmpco",$dtipo); }
       else { echo "Ocurrio un error al eliminar"; }
       break;
     case "Artista":
       if ($objsolicitante->eliminar($psol,$idcod,"stdtmpar")==true){
  	      //echo "Registro eliminado correctamente";
	      $consulta=$objsolicitante->consultar($psol,"stdtmpar",$dtipo); }
       else { echo "Ocurrio un error al eliminar"; }
       break;
     case "Editor":
       if ($objsolicitante->eliminar($psol,$idcod,"stdtmped")==true){
  	      //echo "Registro eliminado correctamente";
	      $consulta=$objsolicitante->consultar($psol,"stdtmped",$dtipo); }
       else { echo "Ocurrio un error al eliminar"; }
       break;
     case "Titular":
       if ($objsolicitante->eliminar($psol,$idcod,"stdtmpti")==true){
  	      //echo "Registro eliminado correctamente";
	      $consulta=$objsolicitante->consultar($psol,"stdtmpti",$dtipo); }
       else { echo "Ocurrio un error al eliminar"; }
       break;
     case "Atista":
       if ($objsolicitante->eliminarat($psol,$idcod,"stdtmpat")==true){
  	      //echo "Registro eliminado correctamente";
	      $consulta=$objsolicitante->consultarat($psol,"stdtmpat",$dtipo); }
       else { echo "Ocurrio un error al eliminar"; }
       break;
     case "Inventor":
       if ($objsolicitante->borrarinv($psol,$idcod,"stptmpinv")==true){
	      $consulta=$objsolicitante->consultainv($psol,"stptmpinv",$dtipo); }
       else { echo "Ocurrio un error al eliminar"; }
       break;
     case "Clasificacion":
       if ($objsolicitante->eliminacla($psol,$idcod,"stptmpipc")==true){
	      $consulta=$objsolicitante->consulclas($psol,"stptmpipc",$dtipo); }
       else { echo "Ocurrio un error al eliminar"; }
       break;
     case "Prioridad":
       if ($objsolicitante->eliminapri($psol,$idcod,"stztmpri",$derecho)==true){
	      $consulta=$objsolicitante->consulpri($psol,"stztmpri",$dtipo,$derecho); }
       else { echo "Ocurrio un error al eliminar"; }
       break;
     case "Equivalente":
       if ($objsolicitante->elimequiv($psol,$idcod,"stptmpeq",$derecho)==true){
	      $consulta=$objsolicitante->consequiv($psol,"stptmpeq",$dtipo,$derecho); }
       else { echo "Ocurrio un error al eliminar"; }
       break;
     case "Titular2":
       if ($objsolicitante->eliminatit($psol,$idcod,"stztmpti",$derecho)==true){
	      $consulta=$objsolicitante->consultatit($psol,"stztmpti",$dtipo); }
       else { echo "Ocurrio un error al eliminar"; }
       break;

  }
  //pg_exec("COMMIT WORK");       
?>
