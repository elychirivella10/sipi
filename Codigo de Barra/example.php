<?php
ob_start();
require_once('pdfbarcode128.inc');

	$pdf = new fpdf();
	$code = new pdfbarcode128('90-000001', 6 );
	$pdf->Open();
	$pdf->AddPage();
	$code->set_pdf_document($pdf);
	$width = $code->get_width();
	$code->draw_barcode(120, 5, 15, true );
//	$code->draw_barcode(10, 2, 15, true );
       ob_end_clean(); 
	$pdf->Output();
	unset($code);
	unset($pdf);
?>
