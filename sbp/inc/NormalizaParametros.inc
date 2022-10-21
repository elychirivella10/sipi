<?php
// Alfabeto contemplado
$mayusculas = "ABCDEFGHIJKLMNÑOPQRSTUVWXYZÁÉÍÓÚÜ";
$minusculas = "abcdefghijklmnñopqrstuvwxyzáéíóúü";

// Elimina todos los caracteres blanco del principio y final de 
// una cadena así como los que se encuentre en número superior a
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
	 
// Elimina los caracteres escape de más introducidos por el 
// interprete al recuperar los valores enviados por la 
// página que invoca al script 
function quitar_escapes_de_mas($cadena)
   {
   return stripcslashes($cadena);
   }	 

// Convierte $cadena a minúsculas   
function cambiar_a_minusculas($cadena)
   {
   return strtr($cadena,
                $GLOBALS["mayusculas"], $GLOBALS["minusculas"]);
   }
   
// Convierte $cadena a mayúsculas   
function cambiar_a_mayusculas($cadena)
   {  
   return strtr($cadena, 
                $GLOBALS["minusculas"], $GLOBALS["mayusculas"]);
   }
	 
// Convierte la primera letra de cada palabra a mayúsculas y 
// el resto de carácateres a minúsculas   
function normaliza_texto($cadena)
   {
   // Divimos la cadena en líneas separadas por el carácter "\n"
   $lineas = preg_split("/[\n]/", $cadena);
   
   for ($i = 0; $i < count($lineas); $i++)
      {
      // Dividimos cada línea en palabras separadas por blancos
      $palabras = preg_split("/ /", $lineas[$i]);
      
      for ($j = 0; $j < count($palabras); $j++)
         {
         // Obtenemos el primer carácter de una palabra
         $principio = substr($palabras[$j], 0, 1);
         
         // Obtenemos la subcadena de la palabra que contiene todos 
         // los caracteres a excepción del primero
         $final = substr($palabras[$j], 1, strlen($palabras[$j]));
         
         // Cambiamos las primera letra a mayúsculas y el resto a 
         // minúsculas y formamos la palabra de nuevo
         $principio = cambiar_a_mayusculas($principio);
         $final = cambiar_a_mayusculas($final);
         $palabras[$j] = $principio . $final;
         }
      // Juntamos las palabras en una línea   
      $lineas[$i] = join(" ", $palabras);
      }
   // Juntamos todas las líneas en la cadena de salida
   return join("\n", $lineas);	 
   }

// Convierte la primera letra de cada palabra a mayúsculas y 
// el resto de carácateres a minúsculas   
function normaliza_solicitud($cadena)
   {
   // Divimos la cadena en líneas separadas por el carácter "\n"
   $lineas = preg_split("/[\n]/", $cadena);
   
   for ($i = 0; $i < count($lineas); $i++)
      {
      // Dividimos cada línea en palabras separadas por blancos
      $palabras = preg_split("/ /", $lineas[$i]);
      
      for ($j = 0; $j < count($palabras); $j++)
         {
         // Obtenemos el primer carácter de una palabra
         $principio = substr($palabras[$j], 0, 1);
         
         // Obtenemos la subcadena de la palabra que contiene todos 
         // los caracteres a excepción del primero
         $final = substr($palabras[$j], 1, strlen($palabras[$j]));
         
         // Cambiamos las primera letra a mayúsculas y el resto a 
         // minúsculas y formamos la palabra de nuevo
         $principio = cambiar_a_mayusculas($principio);
         $final = cambiar_a_mayusculas($final);
         $palabras[$j] = $principio . $final;
         }
      // Juntamos las palabras en una línea   
      $lineas[$i] = join("", $palabras);
      }
   // Juntamos todas las líneas en la cadena de salida
   return join("\n", $lineas);	 
   }



// Convierte los valores del array asociativo que contiene las 
// variables proporcionadas por la página que invoca al script 
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
  
// Realiza la transformación de los parámetros recibidos de la 
// página que invoca a este script teniendo en cuenta las 
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
