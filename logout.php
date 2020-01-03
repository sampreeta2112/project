<?php
include('dynamic.php');

$_SESSION[SES_ADMIN]->log_stat="X";

unset($_SESSION[SES_ADMIN]);
header('location:../login.php');
exit;

?>