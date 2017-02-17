<?php

// Optionally define the filesystem path to your system fonts
// otherwise tFPDF will use [path to tFPDF]/font/unifont/ directory
// define("_SYSTEM_TTFONTS", "C:/Windows/Fonts/");

require('fpdf.php');

$pdf = new FPDF();
$pdf->AddPage();

// Add a Unicode font (uses UTF-8)
$pdf->AddFont('corbel', '', 'corbel.php');
$pdf->SetFont('corbel','',14);

// Load a UTF-8 string from a file and print it
//$txt = file_get_contents('HelloWorld.txt');
// $txt = file_get_contents('SampleCyrillicText_ANSI_CP1251.txt');
$txt = file_get_contents('SampleCyrillicText_UTF-8.txt');
$cyr_text =  mb_convert_encoding ( $txt , 'CP1251', 'UTF-8');
$pdf->Write( 8 , $cyr_text );

// Select a standard font (uses windows-1252)
$pdf->SetFont('Arial','',14);
$pdf->Ln(10);
$pdf->Write(5,'The file size of this PDF is only 12 KB.');

$pdf->Output('D:/Users/User/Documents/prestashop_1.2.4.0/FPDF17Test.pdf', 'F');
?>
