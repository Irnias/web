<?php
ini_set('display_errors', '1');
if(($con=odbc_connect("PTTO","",""))=== false )	//Database connect.
  die("connection error");						//Database connect.
if(isset($_GET['taskOption']))
{
  $teamoption = $_GET['taskOption'];
}
else {
$teamoption = "MIS";
}

//QUERYS
//OPEN CASES TOTAL
$sql1= "select count('Open') as resultado from Tickets where szStatus = 'open'";
if(($result=odbc_exec($con,$sql1))=== false )		//Run query and validate.
  die("Query error." .odbc_errormsg($sql2));		//Run query and validate.
{
  $row = odbc_fetch_array($result);
  $cantopen = $row['resultado'];
}
//CLOSED CASES TOTAL
$sql2= "select count('Closed') as resultado from Tickets where szStatus = 'Closed'";
if(($result2=odbc_exec($con,$sql2))=== false )		//Run query and validate.
  die("Query error." .odbc_errormsg($sql2));		//Run query and validate.
{
  $row = odbc_fetch_array($result2);
  $cantclose = $row['resultado'];
}
//MyOpen CASES
$sql3= "select count('Open') as resultado from Tickets where szStatus = 'Open' and szResponsible = '".$_SESSION['logedas']."'";
if(($result3=odbc_exec($con,$sql3))=== false )		//Run query and validate.
  die("Query error." .odbc_errormsg($sql3));		//Run query and validate.
{
  $row = odbc_fetch_array($result3);
  $mycantopen = $row['resultado'];
}
//OPEN ASSIGNMENTS MAPPING OAMAP = $oamap
$sql4= "select count('Open') as resultado from Tickets where szStatus = 'open' and szTeam = 'MAP' ";
if(($result4=odbc_exec($con,$sql4))=== false )		//Run query and validate.
  die("Query error." .odbc_errormsg($sql4));		//Run query and validate.
{
  $row = odbc_fetch_array($result4);
  $oamap = $row['resultado'];
}
//OPEN ASSIGNMENTS GT1 OAGT1 = $oagt1
$sql5= "select count('Open') as resultado from Tickets where szStatus = 'open' and szTeam = 'GT1' ";
if(($result5=odbc_exec($con,$sql5))=== false )		//Run query and validate.
  die("Query error." .odbc_errormsg($sql5));		//Run query and validate.
{
  $row = odbc_fetch_array($result5);
  $oagt1 = $row['resultado'];
}
//OPEN ASSIGNMENTS BPC OABPC = $oabpc
$sql6= "select count('Open') as resultado from Tickets where szStatus = 'open' and szTeam = 'BPC' ";
if(($result6=odbc_exec($con,$sql6))=== false )		//Run query and validate.
  die("Query error." .odbc_errormsg($sql6));		//Run query and validate.
{
  $row = odbc_fetch_array($result6);
  $oabpc = $row['resultado'];
}
//OPEN ASSIGNMENTS BSI OABSI = $oabsi
$sql7= "select count('Open') as resultado from Tickets where szStatus = 'open' and szTeam = 'BSI' ";
if(($result7=odbc_exec($con,$sql7))=== false )		//Run query and validate.
  die("Query error." .odbc_errormsg($sql7));		//Run query and validate.
{
  $row = odbc_fetch_array($result7);
  $oabsi = $row['resultado'];
}
//CLOSED ASSIGNMENTS MAPPING CAMAP = $camap
$sql8= "select count('Closed') as resultado from Tickets where szStatus = 'Close' and szTeam = 'MAP' ";
if(($result8=odbc_exec($con,$sql8))=== false )		//Run query and validate.
  die("Query error." .odbc_errormsg($sql8));		//Run query and validate.
{
  $row = odbc_fetch_array($result8);
  $camap = $row['resultado'];
}
//CLOSED ASSIGNMENTS GT1 OAGT1 = $oagt1
$sql9= "select count('Closed') as resultado from Tickets where szStatus = 'Close' and szTeam = 'GT1' ";
if(($result9=odbc_exec($con,$sql9))=== false )		//Run query and validate.
  die("Query error." .odbc_errormsg($sql9));		//Run query and validate.
{
  $row = odbc_fetch_array($result9);
  $cagt1 = $row['resultado'];
}
//CLOSED ASSIGNMENTS BPC OABPC = $oabpc
$sql10= "select count('Closed') as resultado from Tickets where szStatus = 'Close' and szTeam = 'BPC' ";
if(($result10=odbc_exec($con,$sql10))=== false )		//Run query and validate.
  die("Query error." .odbc_errormsg($sql10));		//Run query and validate.
{
  $row = odbc_fetch_array($result10);
  $cabpc = $row['resultado'];
}
//CLOSED ASSIGNMENTS BSI OABSI = $oabsi
$sql10= "select count('Closed') as resultado from Tickets where szStatus = 'Close' and szTeam = 'BSI' ";
if(($result10=odbc_exec($con,$sql10))=== false )		//Run query and validate.
  die("Query error." .odbc_errormsg($sql10));		//Run query and validate.
{
  $row = odbc_fetch_array($result10);
  $cabsi = $row['resultado'];
}
//Querys second Table
//category On-day $COnday
$sqlt201= "select count('open') as resultado from Tickets where szStatus = 'open' and szTeam = '$teamoption' ";
if(($result201=odbc_exec($con,$sqlt201))=== false )		//Run query and validate.
  die("Query error." .odbc_errormsg($sqlt201));		//Run query and validate.
{
  $row = odbc_fetch_array($result201);
  $COnday = $row['resultado'];
}
//Page information
 echo "<center>";
	echo "Total Open Cases: ".$cantopen. " <a href=\"cases/ocases.php\">More Info</a> | ";
  echo "Total Close Cases: ".$cantclose." | ";
	echo "You have ".$mycantopen." Open Case/s - <a href=\"cases/myocases.php\">More Info</a><br>";
  echo "</center> <br> <br>";
?>
<!-- Tables! -->
<div class="container-fluid">
  <div class="container col-xs-6">
    <table class="table table-bordered">
      <tr>
        <th colspan="4"> <center>Cases / Assignments</center> </th>
      </tr>
      <tr>
        <th>Area</th><th>Open Assignments</th><th>Closed Assignments</th><th>Total</th>
      </tr>
      <tr>
        <th>Mapping</th><td><?php echo $oamap; ?></td><td><?php echo $camap; ?></td><td><?php echo $oamap+$camap; ?></td>
      </tr>
      <tr>
        <th>GTOne</th><td><?php echo $oagt1; ?></td><td><?php echo $cagt1; ?></td><td><?php echo $oagt1+$cagt1; ?></td>
      </tr>
      <tr>
        <th>BPC</th><td><?php echo $oabpc; ?></td><td><?php echo $cabpc; ?></td><td><?php echo $oabpc+$cabpc; ?></td>
      </tr>
      <tr>
        <th>BSI</th><td><?php echo $oabsi; ?></td><td><?php echo $cabsi; ?></td><td><?php echo $oabsi+$cabsi; ?></td>
      </tr>
      <tr>
        <th>Totals</th>
        <th><?php echo $oatotal = $oamap + $oagt1 + $oabpc + $oabsi; ?></th>
        <th><?php echo $catotal =$camap+$cagt1+$cabpc+$cabsi; ?></th>
        <th><?php echo $oatotal+$catotal; ?></th>
      </tr>
    </table>
  </div>
  <div class="clearfix visible-xs-block"></div>
  <div class="container col-xs-6">
    <table class="table table-bordered">
<tr>
  <th>Teams</th><th colspan="4"> <center>Delays</center> </th>
</tr>
<tr>
  <th><form class="form-inline">
    <select class="form-control" action ="" method="get" name="taskOption">
      <option value="MIS">MIS</option>
      <option value="MAP">MAP</option>
      <option value="BSI">BSI</option>
      <option value="BPC">BPC</option>
      <option value="GT1">GT1</option>
    </select><input type="submit" class="btn" value="Refresh!" > </form>
  </th>
  <th colspan="2"><center>Quantity</center></th>
  <th colspan="2"><center>%</center></th>
</tr>
<tr>
  <th>Categories</th>
  <th>Opened</th>
  <th>Closed</th>
  <th>Opened</th>
  <th>Closed</th>
</tr>
<tr>
  <th>On-Day</th>
  <td><?php echo $oamap; ?></td>
  <td><?php echo $camap; ?></td>
  <td><?php echo $oamap + $camap; ?></td>
  <td><?php echo $oamap + $camap; ?></td>
</tr>
<tr>
  <th>A (<=2)</th>
  <td><?php echo $oagt1; ?></td>
  <td><?php echo $cagt1; ?></td>
  <td><?php echo $oagt1 + $cagt1; ?></td>
  <td><?php echo $oamap + $camap; ?></td>
</tr>
<tr>
  <th>B (>2<=5)</th>
  <td><?php echo $oabpc; ?></td>
  <td><?php echo $cabpc; ?></td>
  <td><?php echo $oabpc + $cabpc; ?></td>
  <td><?php echo $oamap + $camap; ?></td>
</tr>
<tr>
  <th>c (>5<=10)</th>
  <td><?php echo $oabsi; ?></td>
  <td><?php echo $cabsi; ?></td>
  <td><?php echo $oabsi+$cabsi; ?></td>
  <td><?php echo $oamap+$camap; ?></td>
</tr>
<tr>
  <th>D (>10)</th>
  <td><?php echo $oatotal = $oamap + $oagt1 + $oabpc + $oabsi; ?> </td>
  <td><?php echo $catotal = $camap + $cagt1 + $cabpc + $cabsi; ?></td>
  <td><?php echo $oatotal + $catotal; ?></td>
  <td><?php echo $oamap + $camap; ?></td>
</tr>
 <tr>
  <th>Totals</th>
  <th><?php echo $oatotal = $oamap + $oagt1 + $oabpc + $oabsi; ?> </th>
  <th><?php echo $catotal = $camap + $cagt1 + $cabpc + $cabsi; ?> </th>
  <th><?php echo $oatotal + $catotal; ?> </th>
  <th><?php echo $oamap + $camap; ?> </th>
</tr>
    </table>
  </div>
</div>
</body>
