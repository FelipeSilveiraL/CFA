<?php

require_once '../vendor/autoload.php';

// Creating the new document...
$phpWord = new \PhpOffice\PhpWord\PhpWord();

/* Note: any element you append to a document must reside inside of a Section. */

// Adding an empty Section to the document...
$section = $phpWord->addSection();

// Adding Text element with font customized using explicitly created font style object...
$fontStyleTitulo = new \PhpOffice\PhpWord\Style\Font();
$fontStyleTitulo->setBold(true);
$fontStyleTitulo->setName('Tahoma');
$fontStyleTitulo->setSize(13);
$titulo = $section->addText('Recibo de Doador');
$titulo->setFontStyle($fontStyleTitulo);

// Saving the document as OOXML file...
$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007', $download = true);
header("Content-Disposition: attachment; filename=File.docx");
$objWriter->save('php://output');

?>