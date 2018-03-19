<?php
session_start();
$_SESSION['webid']=4;
header("refresh:0;url=../index.php");
?>
