<?php
session_start();
$_SESSION['webid']=7;
header("refresh:0;url=../index.php");
?>