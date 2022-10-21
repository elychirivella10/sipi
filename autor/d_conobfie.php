<?php
 //Programa solo para trabajar con la(s) persona(s) Natural(es) o Juridica(s) //Clase que contiene los metodos 
 include_once("../include/coFijinEje.php");

 //variable POST
 $psol=$_GET['psol'];
 $dtipo=$_GET['vtipo'];
 //Declaracion del Objeto a partir de la Clase 
 $objobrafie = new coFijinEje;
 $consulta=$objobrafie->consultar($psol,"stdtmpfie",$dtipo);
?>
