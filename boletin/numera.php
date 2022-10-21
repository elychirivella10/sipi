<?php

$inicio = 0;
$final  = 12;
$pos    = 1;
$texto  = $final;
$tope   = $final;

$txtinicial = 0;
$txtfinal  = 1;
while ($pos<=($tope-1)) {
  if ($pos%2==0) { }
  else {
    echo "impar $pos ";
    if ($txtinicial==0) { $txtinicial=1; $txtfinal=0; }
    else { if ($txtfinal==0) { $txtfinal=1; $txtinicial=0; } }
  }
  if ($txtinicial==1) { 
    $inicio = $inicio + 1;
    $siguiente = $inicio;
  }
  if ($txtfinal==1) {
    $final = $final - 1;
    $siguiente = $final;
  }
  $texto = $texto.",".$siguiente;
  $pos = $pos + 1;
}
echo "text=$texto";
?>

