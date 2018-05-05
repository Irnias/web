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

<div class="container-fluid"> <br> <br> Welcome <?php echo $_SESSION['aname']; ?></div>
<!-- Tables! -->
<div class="container-fluid">
  <div class="container col-xs-2">
    <center> Columna 1</center>
  </div>
  <div class="clearfix visible-xs-block"></div>
  <div class="container col-xs-4">
    <center> Columna 2</center>
    <div id="chartHolder" style="width:100%; height:500px;"></div>

<script>
var chartVars = "KoolOnLoadCallFunction=chartReadyHandler";

KoolChart.create("chart1", "chartHolder", chartVars, "100%", "100%");

function chartReadyHandler(id) {
  document.getElementById(id).setLayout(layoutStr);
  document.getElementById(id).setData(chartData);
}

var layoutStr =
  '<KoolChart>'
   +'<Gauge innerRatio="0.5" nameField="name" valueField="value" backgroundColors="[#f0f0f0]" foregroundColors="[#5587a2,#20cbc2,#f6a54c]" minimum="0" maximum="100" startAngle="-90" minimumAngle="0" maximumAngle="270" color="#ffffff" fontSize="20" fontWeight="bold" labelYOffset="-4">'
    +'<backgroundElements>'
     +'<Box width="100%" height="100%" horizontalAlign="center" verticalAlign="middle">'
      +'<SubLegend direction="vertical" fontSize="13" color="#666666" borderStyle="none">'
       +'<LegendItem label=" <?php echo "Unnasigned " ?> ">'
        +'<fill>'
         +'<SolidColor color="#5587a2"/>'
        +'</fill>'
       +'</LegendItem>'
       +'<LegendItem label="Assigned">'
        +'<fill>'
         +'<SolidColor color="#20cbc2"/>'
        +'</fill>'
       +'</LegendItem>'
       +'<LegendItem label="Delayed">'
        +'<fill>'
         +'<SolidColor color="#f6a54c"/>'
        +'</fill>'
       +'</LegendItem>'
      +'</SubLegend>'
     +'</Box>'
    +'</backgroundElements>'
   +'</Gauge>'
  +'</KoolChart>';

var chartData =
  [{"name" : "Unnasigne %", "value" : <?php echo $cantopunnasigned ?>},
  {"name" : "Assigned", "value" : <?php echo $cantAssigned ?>},
  {"name" : "Delayed", "value" : 82}];
</script>
  </div>
  <div class="clearfix visible-xs-block"></div>
    <div class="container col-xs-6">
      <div role ="tabpanel">

        <ul class="nav nav-tabs" role="tablist">
            <li role"presentation" class="active"><a href="#tab1" aria-controls="tab1" data-toggle="tab" role="tab">Delayed</a></li>
            <li role"presentation"><a href="#tab2" aria-controls="tab2" data-toggle="tab" role="tab">Unssigned</a></li>
            <li role"presentation"><a href="#tab3" aria-controls="tab3" data-toggle="tab" role="tab">In progress</a></li>
            <li role"presentation"><a href="#tab4" aria-controls="tab4" data-toggle="tab" role="tab">Completed</a></li>
        </ul>

        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="tab1">
                  <?php
    $date = date('Y-m-d h:i:s', time());
    $querytablaOL = "select * from TicketOL";
    if(($result=odbc_exec($con,$querytablaOL))=== false )		//Run query and validate.
      die("Query error." .odbc_errormsg($querytablaOL));		//Run query and validate.

      echo"<div class=\"container\">

    </div>";
    echo "<div class=\"container-fluid\"><table class=\"table primary table-striped table-bordered table-hover\"><tr class=\"danger\"><th>Subject</th><th>From</th><th>Recived</th><th class=\"text-nowrap\">Time Passed</th></tr> </div>";
    while($row = odbc_fetch_array($result))
    {
      $row = odbc_fetch_array($result);
      $tk = $row['mnOLTicket'];
            echo "<a href=\"index.php\"><tr><td><a href=\"search.php?OL=$tk\">" .$row['szSubject']."</a></td><td>".$row['szFROM']."</td><td>".$row['szRecived']."</td><td >".$date."</td></tr></a>";
    }
        echo "</table></div>";
    ?>
            </div>
            <div role="tabpanel" class="tab-pane" id="tab2">
              <?php
$date = date('Y-m-d h:i:s', time());
$querytablaOL = "select * from TicketOL";
if(($result=odbc_exec($con,$querytablaOL))=== false )		//Run query and validate.
  die("Query error." .odbc_errormsg($querytablaOL));		//Run query and validate.

  echo"<div class=\"container\">

</div>";
echo "<div class=\"container-fluid\"><table class=\"table primary table-striped table-bordered table-hover\"><tr class=\"info\"><th>Subject</th><th>From</th><th>Recived</th><th class=\"text-nowrap\">Time Passed</th></tr> </div>";
while($row = odbc_fetch_array($result))
{
  $row = odbc_fetch_array($result);
  $tk = $row['mnOLTicket'];
        echo "<a href=\"index.php\"><tr><td><a href=\"search.php?OL=$tk\">" .$row['szSubject']."</a></td><td>".$row['szFROM']."</td><td>".$row['szRecived']."</td><td >"."1 WD, 14hs"."</td></tr></a>";
}
    echo "</table></div>";
?>
            </div>
            <div role="tabpanel" class="tab-pane" id="tab3">
              <?php
$date = date('Y-m-d h:i:s', time());
$querytablaOL = "select * from TicketOL";
if(($result=odbc_exec($con,$querytablaOL))=== false )		//Run query and validate.
  die("Query error." .odbc_errormsg($querytablaOL));		//Run query and validate.

  echo"<div class=\"container\">

</div>";
echo "<div class=\"container-fluid\"><table class=\"table primary table-striped table-bordered table-hover\"><tr class=\"info\"><th>Subject</th><th>From</th><th>Recived</th><th class=\"text-nowrap\">Time Passed</th></tr> </div>";
while($row = odbc_fetch_array($result))
{
  $row = odbc_fetch_array($result);
  $tk = $row['mnOLTicket'];
        echo "<a href=\"index.php\"><tr><td><a href=\"search.php?OL=$tk\">" .$row['szSubject']."</a></td><td>".$row['szFROM']."</td><td>".$row['szRecived']."</td><td >".$date."</td></tr></a>";
}
    echo "</table></div>";
?>
            </div>
            <div role="tabpanel" class="tab-pane" id="tab4">
              <?php
$date = date('Y-m-d h:i:s', time());
$querytablaOL = "select * from TicketOL";
if(($result=odbc_exec($con,$querytablaOL))=== false )		//Run query and validate.
  die("Query error." .odbc_errormsg($querytablaOL));		//Run query and validate.

  echo"<div class=\"container\">

</div>";
echo "<div class=\"container-fluid\"><table class=\"table primary table-striped table-bordered table-hover\"><tr class=\"success\"><th>Subject</th><th>From</th><th>Recived</th><th class=\"text-nowrap\">Time Passed</th></tr> </div>";
while($row = odbc_fetch_array($result))
{
  $row = odbc_fetch_array($result);
  $tk = $row['mnOLTicket'];
        echo "<a href=\"index.php\"><tr><td><a href=\"search.php?OL=$tk\">" .$row['szSubject']."</a></td><td>".$row['szFROM']."</td><td>".$row['szRecived']."</td><td >".$date."</td></tr></a>";
}
    echo "</table></div>";
?>
            </div>
        </div>
    </div>
</div>
</body>
<br><br><br><br><br>
