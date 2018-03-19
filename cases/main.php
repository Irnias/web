<?php
session_start();
$_SESSION['webid']=1;
header("refresh:0;url=../index.php");
?>
