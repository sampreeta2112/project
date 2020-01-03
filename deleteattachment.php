<?php
include("dynamic.php");
$attach_id=$_GET['id'];
$filename=$_GET['filename'];
$query="delete from attachments where att_id=$attach_id";
RunQry($query);
unlink($filename);
?>