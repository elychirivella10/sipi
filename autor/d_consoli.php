<?php
 //Programa solo para trabajar con la(s) persona(s) Natural(es) o Juridica(s)
 //Clase que contiene los metodos 
 include_once("../include/cpNatuJuri.php");

 //variable POST
 $psol=$_GET['psol'];
 $dtipo=$_GET['vtipo'];
 //Declaracion del Objeto a partir de la Clase 
 $objsolicitante = new cpNatuJuri;

 switch ($dtipo) {
     case "Solicitante":
       $consulta=$objsolicitante->consultar($psol,"stdtmpso",$dtipo);
       break;
     case "Productor":
       $consulta=$objsolicitante->consultar($psol,"stdtmppt",$dtipo);
       break;
     case "Autor":
       $consulta=$objsolicitante->consultar($psol,"stdtmpau",$dtipo);
       break;
     case "Coautor1":
       $consulta=$objsolicitante->consultar($psol,"stdtmpco",$dtipo);
       break;
     case "Coautor2":
       $consulta=$objsolicitante->consultar($psol,"stdtmpco",$dtipo);
       break;
     case "Coautor3":
       $consulta=$objsolicitante->consultar($psol,"stdtmpco",$dtipo);
       break;
     case "Coautor4":
       $consulta=$objsolicitante->consultar($psol,"stdtmpco",$dtipo);
       break;
     case "Artista":
       $consulta=$objsolicitante->consultar($psol,"stdtmpar",$dtipo);
       break;
     case "Editor":
       $consulta=$objsolicitante->consultar($psol,"stdtmped",$dtipo);
       break;
     case "Titular":
       $consulta=$objsolicitante->consultar($psol,"stdtmpti",$dtipo);
       break;
     case "Atista":
       $consulta=$objsolicitante->consultarat($psol,"stdtmpat",$dtipo);
       break;

  }       
?>
