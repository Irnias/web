<?php
session_start();
$_SESSION['webid']=5;
header("refresh:0;url=../index.php");
?>
