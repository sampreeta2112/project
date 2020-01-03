<?php
include('dynamic.php');

$url_str=$_SESSION[SES_ADMIN]->inv_url_str;

$disp_url = "invoice.php"."?page=1".$url_str;

if(isset($_GET["id"])) $txtid = $_GET["id"];
else if(isset($_POST["txtid"])) $txtid = $_POST["txtid"];
else $txtid = '0';

?>
<html xmlns="http://www.w3.org/1999/xhtml">
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<head>
<?php include('_header.php'); ?>
</head>
<body>
<?php
//============================================================+
// File name   : example_009.php
// Begin       : 2008-03-04
// Last Update : 2013-05-14
//
// Description : Example 009 for TCPDF class
//               Test Image
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: Test Image
 * @author Nicola Asuni
 * @since 2008-03-04
 */

// Include the main TCPDF library (search for installation path).
//require_once('../tcpdf/tcpdf_include.php');
    require_once('../tcpdf/config/tcpdf_config.php');
    require_once('../tcpdf/tcpdf.php');

    class MYPDF extends TCPDF {
    //Page header
    public function Header() {
        // get the current page break margin
        $bMargin = $this->getBreakMargin();
        // get current auto-page-break mode
        $auto_page_break = $this->AutoPageBreak;
        // disable auto-page-break
        $this->SetAutoPageBreak(false, 0);
        // set bacground image
        $img_file = K_PATH_IMAGES.'logo.png';
       // $this->Image($img_file, 0, 4, 50, 26, '', '', '', false, 300, 'L', false, false, 0);
        //set background color
        $this->SetFillColor( 255, 255, 255 );
        $this->Rect(0, 0, 0, 0, 'DF', '', array(0,200,0));
        // restore auto-page-break status
        $this->SetAutoPageBreak($auto_page_break, $bMargin);
        // set the starting point for the page content
        $this->setPageMark();
    }
}
// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('TCPDF Example 009');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, 500, PDF_HEADER_TITLE.' 009', PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// -------------------------------------------------------------------

// add a page
$pdf->AddPage();

// set JPEG quality
$pdf->setJPEGQuality(100);

// Image method signature:
// Image($file, $x='', $y='', $w=0, $h=0, $type='', $link='', $align='', $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, $border=0, $fitbox=false, $hidden=false, $fitonpage=false)

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

// Example of Image from data stream ('PHP rules')
//$imgdata = base64_decode('iVBORw0KGgoAAAANSUhEUgAAABwAAAASCAMAAAB/2U7WAAAABlBMVEUAAAD///+l2Z/dAAAASUlEQVR4XqWQUQoAIAxC2/0vXZDrEX4IJTRkb7lobNUStXsB0jIXIAMSsQnWlsV+wULF4Avk9fLq2r8a5HSE35Q3eO2XP1A1wQkZSgETvDtKdQAAAABJRU5ErkJggg==');

// The '@' character is used to indicate that follows an image data stream and not an image file name
//$pdf->Image('@'.$imgdata);

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

// Image example with resizing
//$pdf->Image(K_PATH_IMAGES.'logo.png', 15, 140, 75, 113, 'PNG', 'http://www.tcpdf.org', '', true, 150, '', false, false, 1, false, false, false);

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

// test fitbox with all alignment combinations

$horizontal_alignments = array('L', 'C', 'R');
$vertical_alignments = array('T', 'M', 'B');

$x = 15;
$y = 35;
$w = 30;
$h = 30;
// test all combinations of alignments
/*
for ($i = 0; $i < 4; ++$i) {
    $fitbox = $horizontal_alignments[$i].' ';
    $x = 15;
    for ($j = 0; $j < 3; ++$j) {
        $fitbox[1] = $vertical_alignments[$j];
        $pdf->Rect($x, $y, $w, $h, 'F', array(), array(128,255,128));
        $pdf->Image(K_PATH_IMAGES.'logo.png', $x, $y, $w, $h, 'PNG', '', '', false, 300, '', false, false, 0, $fitbox, false, false);
        $x += 32; // new column
    }
    $y += 32; // new row
}
*/

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

// Stretching, position and alignment example

$pdf->SetXY(0, 0);
$pdf->Image('../media/dddbig.png', '', '', auto, auto, '', '', 'T', true, 300, '', false, false, 0, false, false, false);
// add a page
//$pdf->AddPage();

// set JPEG quality
//$pdf->setJPEGQuality(75);
//$pdf->SetXY(0, 0);
//$pdf->Image(K_PATH_IMAGES.'logo.png', '', '', 80, 40, '', '', '', false, 300, '', false, false, 1, false, false, false);

// -------------------------------------------------------------------

//Close and output PDF document
$filePath='credit_sales_Inv-'.$order_id.".pdf";
$pdf->Output($filePath, 'F');
echo "<script>
				window.open('".$filePath."');
				</script>";
		exit;
//============================================================+
// END OF FILE
//============================================================+
?>
</body>
</html>