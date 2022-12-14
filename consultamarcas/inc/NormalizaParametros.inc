<?php
// Alfabeto contemplado
$mayusculas = "ABCDEFGHIJKLMN?OPQRSTUVWXYZ??????";
$minusculas = "abcdefghijklmn?opqrstuvwxyz??????";

// Elimina todos los caracteres blanco del principio y final de 
// una cadena as? como los que se encuentre en n?mero superior a
// 1 entre 2 palabras
function quitar_blancos($cadena)
   {  
   // Expresiones regulares que representan respectivamente a los 
   // blancos del principio, de en medio y del final de una cadena
   static $expresion_blancos = 
                         array("/^[ ]+/m", "/[ ]+/m", "/[ ]+\$/m");
   
   // Cadenas que sustituyen  respectivamente a los blancos del 
   // principio, de en medio y del final de una cadena
	 static $blancos = array("", " ", "");
   return preg_replace($expresion_blancos, $blancos, $cadena);
   }
	 
// Elimina los caracteres escape de m?s introducidos por el 
// interprete al recuperar los valores enviados por la 
// p?gina que invoca al script 
function quitar_escapes_de_mas($cadena)
   {
   return stripcslashes($cadena);
   }	 

// Convierte $cadena a min?sculas   
function cambiar_a_minusculas($cadena)
   {
   return strtr($cadena,
                $GLOBALS["mayusculas"], $GLOBALS["minusculas"]);
   }
   
// Convierte $cadena a may?sculas   
function cambiar_a_mayusculas($cadena)
   {  
   return strtr($cadena, 
                $GLOBALS["minusculas"], $GLOBALS["mayusculas"]);
   }
	 
// Convierte la primera letra de cada palabra a may?sculas y 
// el resto de car?cateres a min?sculas   
function normaliza_texto($cadena)
   {
   // Divimos la cadena en l?neas separadas por el car?cter "\n"
   $lineas = preg_split("/[\n]/", $cadena);
   
   for ($i = 0; $i < count($lineas); $i++)
      {
      // Dividimos cada l?nea en palabras separadas por blancos
      $palabras = preg_split("/ /", $lineas[$i]);
      
      for ($j = 0; $j < count($palabras); $j++)
         {
         // Obtenemos el primer car?cter de una palabra
         $principio = substr($palabras[$j], 0, 1);
         
         // Obtenemos la subcadena de la palabra que contiene todos 
         // los caracteres a excepci?n del primero
         $final = substr($palabras[$j], 1, strlen($palabras[$j]));
         
         // Cambiamos las primera letra a may?sculas y el resto a 
         // min?sculas y formamos la palabra de nuevo
         $principio = cambiar_a_mayusculas($principio);
         $final = cambiar_a_mayusculas($final);
         $palabras[$j] = $principio . $final;
         }
      // Juntamos las palabras en una l?nea   
      $lineas[$i] = join(" ", $palabras);
      }
   // Juntamos todas las l?neas en la cadena de salida
   return join("\n", $lineas);	 
   }

// Convierte la primera letra de cada palabra a may?sculas y 
// el resto de car?cateres a min?sculas   
function normaliza_solicitud($cadena)
   {
   // Divimos la cadena en l?neas separadas por el car?cter "\n"
   $lineas = preg_split("/[\n]/", $cadena);
   
   for ($i = 0; $i < count($lineas); $i++)
      {
      // Dividimos cada l?nea en palabras separadas por blancos
      $palabras = preg_split("/ /", $lineas[$i]);
      
      for ($j = 0; $j < count($palabras); $j++)
         {
         // Obtenemos el primer car?cter de una palabra
         $principio = substr($palabras[$j], 0, 1);
         
         // Obtenemos la subcadena de la palabra que contiene todos 
         // los caracteres a excepci?n del primero
         $final = substr($palabras[$j], 1, strlen($palabras[$j]));
         
         // Cambiamos las primera letra a may?sculas y el resto a 
         // min?sculas y formamos la palabra de nuevo
         $principio = cambiar_a_mayusculas($principio);
         $final = cambiar_a_mayusculas($final);
         $palabras[$j] = $principio . $final;
         }
      // Juntamos las palabras en una l?nea   
      $lineas[$i] = join("", $palabras);
      }
   // Juntamos todas las l?neas en la cadena de salida
   return join("\n", $lineas);	 
   }



// Convierte los valores del array asociativo que contiene las 
// variables proporcionadas por la p?gina que invoca al script 
// teniendo en cuenta las transformaciones activadas
function transforma_un_array(&$variables, $quita_blancos, 
                             $normaliza, $quita_escapes_de_mas)                          
   {				
   // Situamos el puntero interno del array en el primer elemento 			
   reset($variables);
   							
   // Obtemos cada una de los pares clave-valor
   foreach ($variables as $clave => $valor)
      {
      if (!is_array($valor)) 
         {
         if ($quita_blancos)
            $variables[$clave] = 
               quitar_blancos($variables[$clave]);
         if ($quita_escapes_de_mas)
            $variables[$clave] = 
               quitar_escapes_de_mas($variables[$clave]);
         if ($normaliza)	 
            $variables[$clave] = normaliza($variables[$clave]);
         $GLOBALS[$clave] = $variables[$clave];
         }
      else 
         {
         // obtemos cada uno de los elementos del array
         for ($i = 0; $i < count($GLOBALS[$clave]); $i++)
            {
            if ($quita_blancos)
               $variables[$clave][$i] = 
                  quitar_blancos($variables[$clave][$i]);
            if ($quita_escapes_de_mas)		
               $variables[$clave][$i] = 
                  quitar_escapes_de_mas($variables[$clave][$i]);
            if ($normaliza)
               $variables[$clave][$i] = 
                  normaliza($variables[$clave][$i]);
            $GLOBALS[$clave][$i] = $variables[$clave][$i];									
            }
         }
      }
   }			
  
// Realiza la transformaci?n de los par?metros recibidos de la 
// p?gina que invoca a este script teniendo en cuenta las 
// transformaciones activadas  
function transformar_parametros(&$HTTP_GET_VARS, &$HTTP_POST_VARS,
                                $quita_blancos, $normaliza, 
                                $quita_escapes_de_mas)
   {
   if (isset($HTTP_GET_VARS))
      transforma_un_array($HTTP_GET_VARS, $quita_blancos,
                          $normaliza, $quita_escapes_de_mas);
   if (isset($HTTP_POST_VARS))
      transforma_un_array($HTTP_POST_VARS, $quita_blancos,
                          $normaliza, $quita_escapes_de_mas);																
   }
?>
