<?php
session_start();
if(isset($_SESSION['log']))
{

}
else {
	$_SESSION['log']=0;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">
	<link rel="stylesheet" href="css\bootstrap.min.css">
	<link rel="stylesheet" href="css\style.css">



	<!--ESTAS  LIBRERIAS LA USA PARA LOS GRAFICOS
	<link rel="stylesheet" href="//cdn.jsdelivr.net/chartist.js/latest/chartist.min.css">
	<script src="//cdn.jsdelivr.net/chartist.js/latest/chartist.min.js"></script>
	<script src="https://www.koolchart.com/demo/LicenseKey/codepen/KoolChartLicense.js"></script>
	<script src="https://www.koolchart.com/demo/KoolChart/JS/KoolIntegration.js"></script>
	<link rel="stylesheet" href="https://www.koolchart.com/demo/KoolChart/Assets/Css/KoolChart.css"/>
	<link rel="stylesheet" href="https://www.koolchart.com/demo/Samples/Web/sample.css"/>
-->


	<!--LAS SIGUIENTES TRES LINEAS CARGAN ESTILOS QUE SE USAN PARA EL FORMULARIO DE LOG IN-->
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
	<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>



<title>Performance Tracking Tool Online</title>

</head>
<!--<body class="loginpagebackimage">-->
<?php
if (isset($_SESSION['log'])) {
?>
<body class="loginpagebackimage">
<?php
} else {
?>
<body class="loginpagebackimage">
<?php
}
?>
	<nav class="navbar navbar-default navbar-inverse navbar-fixed-top">
  <div class="container-fluid">
<?php
if(isset($_SESSION['log'])){
	if ($_SESSION['log']==1)
{

	function log_ptt(){
		$file = 'log/log.txt';
		$file2 ='log/count.txt';
			$sumlog = file_get_contents($file2) + 1 ;
			file_put_contents($file2,$sumlog);
			$time = time();
	 		$datetoday = date("d-m-Y (H:i:s)", $time);
			$loginsert = $sumlog . " - " . $datetoday . " - " . $_SESSION['logedas'] . " \n ";
			file_put_contents($file, $loginsert, FILE_APPEND);
			return $sumlog;
	}
log_ptt();
?>
		<div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
<span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="cases/main.php">PTT Online</a>
    </div>
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class=<?php if($_SESSION['webid']==1){ echo "\"active\""; }?>><a href="cases/main.php">Main<span class="sr-only">(current)</span></a></li>
        <li class=<?php if($_SESSION['webid']==4){ echo "\"active\""; }?>><a href="cases/ocases.php">Open cases</a></li>
        <!-- <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Reports<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="#">Action</a></li>
            <li><a href="#">Another action</a></li>
            <li><a href="#">Something else here</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="#">Separated link</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="#">One more separated link</a></li>
          </ul>
        </li> -->
      </ul>
      <form class="navbar-form navbar-left" method="GET" action="search.php">
        <div class="form-group">
          <input type="text" name="TK" class="form-control" placeholder="Search">
        </div>
        <button type="submit" class="btn btn-default">Search</button>
      </form>
      <ul class="nav navbar-nav navbar-right">
        <!-- <li><a href="#">Link</a></li> -->
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <?php echo $_SESSION['logedas']; ?>  <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li class=<?php if($_SESSION['webid']==5){ echo "\"active\""; }?>><a href="cases/allcases.php">All cases</a></li>
						<li class=<?php if($_SESSION['webid']==2){ echo "\"active\""; }?>><a href="cases/mycases.php" >My cases</a></li>
            <li class=<?php if($_SESSION['webid']==6){ echo "\"active\""; }?>><a href="cases/myocases.php">My Open cases</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="functions/logout.php">Log out</a></li>
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
<?php
}
		else
{
?>

			<div class="navbar-header">
				<a class="navbar-brand" href="index.php">Performance Tracking Tool</a>
			</div>
<?php
}
}

?>
  </div>
</nav>
