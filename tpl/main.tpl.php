<?php
ini_set('display_errors', '1');
if(($con=odbc_connect("PTTO","",""))=== false )	//Database connect.
  die("connection error");						//Database connect.
if(isset($_GET['taskOption']))
{
  $teamoption = $_GET['taskOption'];
}
else {
$teamoption = $_SESSION['team'];
}

//QUERYS
//Variables:
$selectWhat = "count('szCID') as resultado";
$where_cond = "szTicketTable = 'Null' ";
if(isset($_SSESION['team']))
{
  //Busca nivel de la jerarquia
  $hierarchysearchquery = "select intLevel from Teams where szTeam = '$teamoption'";
  if(($result=odbc_exec($con,$hierarchysearchquery))=== false )		//Run query and validate.
    die("Query error." .odbc_errormsg($hierarchysearchquery));		//Run query and validate.
  {
    $row = odbc_fetch_array($result);
    $teamlist = $row['intLevel'];
  }
  $where_cond = $where_cond . " and szTeam in (select szTeam from Teams where $teamlist = '$teamoption' )";
}
$fuulquery= "select $selectWhat from TicketOL where $where_cond";
if(($result=odbc_exec($con,$fuulquery))=== false )		//Run query and validate.
  die("Query error." .odbc_errormsg($fuulquery));		//Run query and validate.
{
  $row = odbc_fetch_array($result);
  $cantopunnasigned = $row['resultado'];

  //Query total:
  $querytotalOL = "select count(szCID) as resultado from (Select distinct szCID from TicketOL)";
  if(($result=odbc_exec($con,$querytotalOL))=== false )		//Run query and validate.
    die("Query error." .odbc_errormsg($querytotalOL));		//Run query and validate.
  {
    $row = odbc_fetch_array($result);
    $CantOL = $row['resultado'];
  }


  $cantopunnasigned = ($cantopunnasigned / $CantOL) * 100;
  $cantAssigned = 100 - $cantopunnasigned;
}
/////*****NEW QUERYS *****/////

?>

<div class="container-fluid"> <br> <br> Welcome <?php echo $_SESSION['aname']; ?></div><br><br><br>
<!-- Tables! -->
<div class="container-fluid">
  <div class="container col-xs-1">
    <center>Filters</center>
    <div role="tabpanel">
      <ul class="nav nav-pills nav-stacked">
        <li class="btn btn-default active"><a href="#select1" aria-controls="select1" data-toggle="tab" role="tab">Nile</a></li>
        <li class="btn btn-default"><a href="#select2" aria-controls="select2" data-toggle="tab" role="tab">Settl.</a></li>
        <li class="btn btn-default"><a href="#select3" aria-controls="select3" data-toggle="tab" role="tab">Bulk</a></li>
        <li class="btn btn-default"><a href="#select3" aria-controls="select3" data-toggle="tab" role="tab">Truck</a></li>
      </ul>
    </div>
  </div>
  <div class="clearfix visible-xs-block"></div>
  <div class="container col-xs-3">
      <!-- Chart code -->
      <script>
      var gaugeChart = AmCharts.makeChart("chartdiv", {
        "type": "gauge",
        "theme": "none",
        "axes": [{
          "axisAlpha": 0,
          "tickAlpha": 0,
          "labelsEnabled": false,
          "startValue": 0,
          "endValue": 100,
          "startAngle": -90,
          "endAngle": 180,
          "bands": [{
            "color": "#eee",
            "startValue": 0,
            "endValue": 100,
            "radius": "100%",
            "innerRadius": "85%"
          }, {
            "color": "#5587a2",
            "startValue": 0,
            "endValue": 80,
            "radius": "100%",
            "innerRadius": "85%",
            "balloonText": "90%"
          }, {
            "color": "#eee",
            "startValue": 0,
            "endValue": 100,
            "radius": "80%",
            "innerRadius": "65%"
          }, {
            "color": "#f76e6e",
            "startValue": 0,
            "endValue": 35,
            "radius": "80%",
            "innerRadius": "65%",
            "balloonText": "35%"
          }, {
            "color": "#eee",
            "startValue": 0,
            "endValue": 100,
            "radius": "60%",
            "innerRadius": "45%"
          }, {
            "color": "#f6a54c",
            "startValue": 0,
            "endValue": <?php echo $cantopunnasigned; ?>,
            "radius": "60%",
            "innerRadius": "45%",
            "balloonText": "<?php echo $cantopunnasigned." % Delayed Unassigned"; ?>"
          }, {
            "color": "#eee",
            "startValue": 0,
            "endValue": 100,
            "radius": "40%",
            "innerRadius": "25%"
          }, {
            "color": "#1cb0b0",
            "startValue": 0,
            "endValue": 68,
            "radius": "40%",
            "innerRadius": "25%",
            "balloonText": "68%"
          }]
        }],
        "allLabels": [{
          "text": "Delayed %",
          "x": "49%",
          "y": "76%",
          "size": 15,
          "bold": true,
          "color": "#5587a2",
          "align": "right"
        }, {
          "text": "Delayed UN %",
          "x": "49%",
          "y": "70%",
          "size": 15,
          "bold": true,
          "color": "#f76e6e",
          "align": "right"
        }, {
          "text": "Delayed IP %",
          "x": "49%",
          "y": "64%",
          "size": 15,
          "bold": true,
          "color": "#f6a54c",
          "align": "right"
        }, {
          "text": "Unassigned %",
          "x": "49%",
          "y": "58%",
          "size": 15,
          "bold": true,
          "color": "#8aafc1",
          "align": "right"
        }],
        "export": {
          "enabled": false
        }
      });
      </script>
      <!-- HTML -->
      <div id="chartdiv"></div>
  </div>
  <div class="clearfix visible-xs-block"></div>
    <div class="container col-xs-8">
    <?php
    include ('tpl\include\main.column3.tpl.php')
    ?>
</div>
</body>
<br><br><br><br><br>