<?php
session_start();
$_SESSION['webid']=2;
header("refresh:0;url=../index.php");
?>
