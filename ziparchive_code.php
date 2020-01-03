<?php
include('dynamic.php');
$files = array( 'file-imgpdf/img1.pdf','file-imgpdf/img2.pdf','file-imgpdf/img3.pdf','file-imgpdf/img4.pdf');

$zipname = 'file-test-demo150031.zip';
$zip = new ZipArchive;
$zip->open($zipname, ZipArchive::CREATE);
foreach ($files as $file) {
  $zip->addFile($file);
}
$zip->close();
header('Content-Type: application/zip');
header('Content-disposition: attachment; filename='.$zipname);
header('Content-Length: ' . filesize($zipname));
readfile($zipname);
?>