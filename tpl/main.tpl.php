<?php

/////*****Database Connection*****/////
  ini_set('display_errors', '1');
  if(($con=odbc_connect("PTTO","",""))=== false )
    die("connection error");
  if(isset($_GET['taskOption']))
  {
    //Define el team elegido para los filtros
    $teamoption = $_GET['taskOption'];
  }
  else {
    //Define el team por defecto
    $teamoption = $_SESSION['team'];
  }
//QUERYS First Chart
/////*****UN %       *****/////
  if ($teamoption <> ""){
    //Buscar Jerarquia para usar en la query total.
      $hsearch = "SELECT intLevel FROM Teams WHERE szTeam = '$teamoption'";
      $result = odbc_exec($con,$hsearch);
      if(!$result){
        echo "<center>Error detected:Query <b>".$hsearch."</b>did not work.<br>Please contact the administrator</center><br>".odbc_errormsg($hsearch);
      }else{
        $row = odbc_fetch_array($result);
        $teamlist = $row['intLevel'];
      }
      releasconnection($result,$con);
    //Busca la lista de teams debajo del nivel buscado.
      $htsearch = "SELECT szTeam FROM Teams WHERE $teamlist = '$teamoption'";
      $result = odbc_exec($con,$htsearch);
      if(!$result){
        echo "<center>Error detected:Query <b>".$htsearch."</b>did not work.<br>Please contact the administrator</center><br>".odbc_errormsg($htsearch);
      }else{
        $userteams = "'";
        while($row = odbc_fetch_array($result)){
          $userteams = $userteams.$row['szTeam']."', '";
        }
        $userteams ="'".trim($userteams, ", '") ."'" ;
        //echo "Test query: ".$userteams."<br>";
       }
       releasconnection($result,$con);
    //Busca unnasigned aplicando filtro de usuario.
      $uncountquery = "SELECT count(szCID) AS resultado FROM TicketOL WHERE szTeam in ($userteams)";
      $result = odbc_exec($con,$uncountquery);
      if(!$result){
        echo "<center>Error detected:Query <b>".$uncountquery."</b>did not work.<br>Please contact the administrator</center><br>".odbc_errormsg($uncountquery);
      }else{
        $row = odbc_fetch_array($result);
        $total_unnasigned = $row['resultado'];
      }
      releasconnection($result,$con);
    //totalOLtable
      $OLquery = "SELECT count(szCID) AS resultado FROM TicketOL WHERE szTeam in ($userteams)";
      $result = odbc_exec($con,$OLquery);
      if(!$result){
        echo "<center>Error detected:Query <b>".$OLquery."</b>did not work.<br>Please contact the administrator</center><br>".odbc_errormsg($OLquery);
      }else{
        $row = odbc_fetch_array($result);
        $total_OL = $row['resultado'];
      }
      releasconnection($result,$con);
    //Calculo del procentaje
      $un_porcentaje =round((($total_unnasigned / $total_OL) * 100),1);// % total de unnasigned
      //echo "Total Unnasigned: ".$total_unnasigned."<br>";
      //echo "Total OL: ".$total_OL."<br>";
      //echo "Porcentaje de UN: ". $un_porcentaje."<br>";
  }else{
    echo "<center>Error detected: Team is not declared.<br>Please contact the administrator</center>";
  }
  //echo "test OK UN % query";
/////*****IP overdue *****/////
  $delayedNtk2 = "";
  $prequery_ipdelayed = "SELECT
  Tickets.mnTicketNumber, 
  Tickets.gdOpenDate, 
  Subcategories.mnEstimateWD
  FROM Subcategories 
  INNER JOIN Tickets 
  ON Subcategories.szActivitySubCategory = Tickets.szActivitySubCategory 
  where szStatus ='Open'";
  if(($result=odbc_exec($con,$prequery_ipdelayed))=== false )		//Run query and validate.
  die("Query error." .odbc_errormsg($prequery_ipdelayed));
  while($row = odbc_fetch_array($result))
      {
        $open = $row['gdOpenDate'];
        $close = datetimenow();
        $TimePassed = number_of_working_days( $open , $close);
        $a = ($TimePassed > $row['mnEstimateWD'] ? $row['mnTicketNumber'].", ": " " );
        $delayedNtk2 = $delayedNtk2.$a;
      }
      $delayedNtk2 =trim($delayedNtk2);
      $delayedNtk2 =trim($delayedNtk2, ', ');
      //echo $delayedNtk2;
      odbc_free_result($result);
      unset($result);
      odbc_close($con);
  //Query  
  $queryextra = ($delayedNtk2 = "" ? "": "$delayedNtk2" );
  $querytablaOL = "SELECT mnTicketNumber FROM Tickets WHERE mnTicketLineNumber = 1".$queryextra;
  //echo "query:".$querytablaOL;
  if(($result=odbc_exec($con,$querytablaOL))=== false )		//Run query and validate.
  die("Query error." .odbc_errormsg($querytablaOL));		//Run query and validate.
  $items = 0;
  while ($row = odbc_fetch_array($result)) 
  {
    $items++;                           
  }  
  $totalopeoverdue = $items;
  $query2 = "SELECT mnTicketNumber FROM Tickets WHERE mnTicketLineNumber = 1";
  if(($result=odbc_exec($con,$query2))=== false )		//Run query and validate.
  die("Query error." .odbc_errormsg($query2));		//Run query and validate.
  $items = 0;
  while ($row = odbc_fetch_array($result)) 
  {
    $items++;   
  }
  $totalIP = $items;
  if($totalIP == ""){
    $totalIP = 1 ;
  }
  if ($totalopeoverdue == ""){
    $totalopeoverdue = 1;
  }
  //echo "total IP ".$totalIP."<br>";
  //echo "cantoipoverdue ".$totalopeoverdue."<br>";
  $cantoipoverdue = round(100 - (($totalopeoverdue / $totalIP) * 100),1);// % total de Inprogress Overdue
  $totalIP = $totalIP-1;
  //echo "cantoipoverdue ".$totalopeoverdue."<br>";
    odbc_free_result($result);
    unset($result);
    odbc_close($con);
    //echo "Test OK IP overdue %";
/////*****UN overdue *****/////
  //Query para obtener los mnOLticket con delay(lista de tk y cantidad).
    $oloverduelist = "SELECT mnOLTicket, gdReceived from TicketOL where szTicketTable = '0' and mnTicketLineNumber = 1";
    $result = odbc_exec($con,$oloverduelist);
    if(!$result){
      echo "<center>Error detected:Query <b>".$oloverduelist."</b>did not work.<br>Please contact the administrator</center><br>".odbc_errormsg($oloverduelist);
    }else{
      $items = 0;
      $delayedNtk = '';
      while($row = odbc_fetch_array($result))
      {
        $TimePassed = number_of_working_days( $row['gdReceived'] , datetimenow());
        //echo "<br>".$row['gdReceived'].datetimenow()."<br>";
        $a = ($TimePassed >= 1 ? $row['mnOLTicket'].", ": "" );
        $delayedNtk = $delayedNtk.$a;
        $items++;
      }
      $delayedNtk_forlist =trim($delayedNtk, ', ');
      $cantidadUNoverdue = $items;
      releasconnection($result,$con);
      //echo "Lista de unnasigned con delay: ".$delayedNtk."<br>";
      //echo "Suma de unnasigned con delay: ".$items."<br>";
    }
    //Calculo de procentaje de UN Delayed
    $un_overdueporcentaje =round((($cantidadUNoverdue / $total_OL) * 100),1);// % total de unnasigned overdue


/////*****Delayed %  *****/////
  $totun = $cantidadUNoverdue+$cantoipoverdue;
  if($totun == 0){
    $totun = 1;    
  }
  $tottot = $totalIP + $total_OL;
  //echo "totalUNdelayed = ".$cantidadUNoverdue."<br>";
  //echo "cantoipoverdue = ".$cantoipoverdue."<br>";
  //echo "totalIP = ".$totalIP."<br>";
  //echo "CantOL = ".$total_OL."<br>";  
  //echo "totun = ".$totun."<br>";
  //echo "tottot = ".$tottot."<br>";
  $Totaloverdue = ($totun/$tottot)*100;
  $Totaloverdue = round($Totaloverdue,1);
  //echo "totun / tottot = ".$Totaloverdue."<br>";
?>
<div class="container-fluid"> <br> <br> Welcome <?php echo $_SESSION['aname']; ?></div><br><br><br>
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
            "endValue": <?php echo $Totaloverdue; ?>,
            "radius": "100%",
            "innerRadius": "85%",
            "balloonText": "<?php echo $Totaloverdue."% Overdue"; ?>"
          }, {
            "color": "#eee",
            "startValue": 0,
            "endValue": 100,
            "radius": "80%",
            "innerRadius": "65%"
          }, {
            "color": "#f76e6e",
            "startValue": 0,
            "endValue": <?php echo $un_overdueporcentaje; ?>,
            "radius": "80%",
            "innerRadius": "65%",
            "balloonText": "<?php echo $un_overdueporcentaje."% UN Overdue"; ?>"
          }, {
            "color": "#eee",
            "startValue": 0,
            "endValue": 100,
            "radius": "60%",
            "innerRadius": "45%"
          }, {
            "color": "#f6a54c",
            "startValue": 0,
            "endValue": <?php echo $cantoipoverdue; ?>,
            "radius": "60%",
            "innerRadius": "45%",
            "balloonText": "<?php echo $cantoipoverdue."% IP Overdue"; ?>"
          }, {
            "color": "#eee",
            "startValue": 0,
            "endValue": 100,
            "radius": "40%",
            "innerRadius": "25%"
          }, {
            "color": "#1cb0b0",
            "startValue": 0,
            "endValue": <?php echo $un_porcentaje; ?>,
            "radius": "40%",
            "innerRadius": "25%",
            "balloonText": "<?php echo $un_porcentaje."% Unassigned"; ?>"
          }]
        }],
        "allLabels": [{
          "text": "Delayed %",
          "x": "49%",
          "y": "76%",
          "size": 14,
          "bold": true,
          "color": "#5587a2",
          "align": "right"
        }, {
          "text": "UN Overdue %",
          "x": "49%",
          "y": "70%",
          "size": 14,
          "bold": true,
          "color": "#f76e6e",
          "align": "right"
        }, {
          "text": "IP Overdue %",
          "x": "49%",
          "y": "64%",
          "size": 14,
          "bold": true,
          "color": "#f6a54c",
          "align": "right"
        }, {
          "text": "Unassigned %",
          "x": "49%",
          "y": "58%",
          "size": 14,
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