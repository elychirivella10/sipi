<?php
/*======================================================================
 PDFBarcode Class - Usage example
 http://www.grana.to/pdfbarcode

 Copyright (C) 2004 Valerio Granato (valerio at grana.to)
 Last Modified: 2005-04-07 09:25 CEST

 Author:  Valerio Granato (valerio at grana.to)
 Version: 1.0
 Package: PDFBarcode Class

 Thanks to:
 Tibor Thurnay <tibor.thurnay at swr3.de>
 - genbarcode added to programs needed to run the example
 - now barcodes can be rotated: 0°, 90°, 180°, 270°


 A simple usage example - to use this example you NEED:
 - GNU-Barcode
 - Cpdf (see links above)
 - genbarcode by by Folke Ashberg (http://www.ashberg.de/php-barcode/download/)

*/

include ('class.ezpdf.php');
include ('class.pdfbarcode.php');
$pdf =& new Cezpdf('a5', 'landscape');
$barcode_options = array (
    'scale'     => 1,
    'fontscale' => 0,
    'font'      => './fonts/Helvetica.afm',
    'rotation'  => 0
);

$barcode = new PDFBarcode($pdf, $barcode_options);

$fp=popen('/usr/bin/genbarcode 1234567890', "r");
$bars=rtrim(fgets($fp, 1024));
$text=rtrim(fgets($fp, 1024));
$encoding=rtrim(fgets($fp, 1024));
pclose($fp);

if (ereg('^(EAN|ISBN|code 39)', $encoding)) { $fontscale = 4; } else { $fontscale = 0; }

$id = $barcode->generate($text, $bars, '20', '400', $fontscale);

// the x is 28 and not 20 to align vertically to the bars
// and not to the first char
$pdf->addText(28, 320, 12, $encoding. ' 0°');
$pdf->addObject($id);

$fp=popen('/usr/bin/genbarcode 87217254', "r");
$bars=rtrim(fgets($fp, 1024));
$text=rtrim(fgets($fp, 1024));
$encoding=rtrim(fgets($fp, 1024));
pclose($fp);

if (ereg('^(EAN|ISBN|code 39)', $encoding)) { $fontscale = 4; } else { $fontscale = 0; }

// Calling function without collecting the returned value
$barcode->generate($text, $bars, '120', '200', $fontscale, '', 1);

$pdf->addText(70, 275, 12, $encoding. ' 90°');
// Now we use $barcode-id to specify the object
$pdf->addObject($barcode->id);

$fp=popen('/usr/bin/genbarcode 001200130014 128C', "r");
$bars=rtrim(fgets($fp, 1024));
$text=rtrim(fgets($fp, 1024));
$encoding=rtrim(fgets($fp, 1024));
pclose($fp);

if (ereg('^(EAN|ISBN|code 39)', $encoding)) { $fontscale = 4; } else { $fontscale = 0; }

$id = $barcode->generate($text, $bars, '300', '340', $fontscale, '', 2);

$pdf->addText(200, 320, 12, $encoding. ' 180°');
$pdf->addObject($id);

$fp=popen('/usr/bin/genbarcode 0102030405', "r");
$bars=rtrim(fgets($fp, 1024));
$text=rtrim(fgets($fp, 1024));
$encoding=rtrim(fgets($fp, 1024));
pclose($fp);

if (ereg('^(EAN|ISBN|code 39)', $encoding)) { $fontscale = 4; } else { $fontscale = 0; }

$id = $barcode->generate($text, $bars, '200', '165', $fontscale, '', 3);

$pdf->addText(200, 275, 12, $encoding. ' 270°');
$pdf->addObject($id);


$fp=popen('/usr/bin/genbarcode 000008590 39', "r");
$bars=rtrim(fgets($fp, 1024));
$text=rtrim(fgets($fp, 1024));
$encoding=rtrim(fgets($fp, 1024));
pclose($fp);

if (ereg('^(EAN|ISBN|code 39)', $encoding)) { $fontscale = 4; } else { $fontscale = 0; }

$id = $barcode->generate($text, $bars, '320', '270', $fontscale);

$pdf->addText(320, 190, 12, $encoding. ' 0°');
$pdf->addObject($id);


$pdf->ezStream();
?>
