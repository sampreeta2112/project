<?php
include('dynamic.php');
$txtid=$_GET['id'];
$getfilename=GetSingleValue("select file_name from file_records where file_id=$txtid");
$fetchattach="select * from attachments where file_id=$txtid";
$resattach=RunQry($fetchattach);
$files = array();
for($i=1; $objattach = mysqli_fetch_object($resattach); $i++) 
{
$att_filename=$objattach->att_filename;
array_push($files, $att_filename);
}
$zipname = $getfilename.date('ymdhms').'.zip';
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
unlink($zipname);
?>