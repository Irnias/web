
  <br>
<?php
	if(($con=odbc_connect("PTTO","",""))=== false )	//Database connect.
		die("connection error");						//Database connect.

	$sql="select * from Tickets where szStatus = 'Open' and mnTicketNumber not in (select mnTicketNumber from Tickets where szStatus = 'close')";//Sql query.

	if(($result=odbc_exec($con,$sql))=== false )		//Run query and validate.
		die("Query error." .odbc_errormsg($sql));		//Run query and validate.
// BU
// MyITCase
// DaysOpened
// ActivityCategory
// Comments

  echo"<div class=\"container\">
  <h1>Open Cases <small> MIS </small></h1>
</div>";

echo "<div class=\"container\"><table class=\"table primary table-striped table-bordered table-hover\"><tr><th>TicketNumber</th><th>Team</th><th>Status</th><th>Tk created</th><th>Requestor</th><th>Description</th><th>Analyst</th><th class=\"text-nowrap\" >More info</th></tr>";
while($row = odbc_fetch_array($result))
{
  $tk = $row['mnTicketNumber'];
  echo "<a href=\"index.php\"><tr><td>TK" .$row['mnTicketNumber']."</td><td>".$row['szTeam']."</td><td>".$row['szStatus']."</td><td class=\"text-nowrap\">".$row['gdCreationDate']."</td><td >".$row['szRequestor']."</td><td>".$row['szDescription']."</td><td class=\"text-nowrap\">".$row['szResponsible']."</td><td><a href=\"search.php?TK=$tk\">Details</a></td></tr></a>";
}
	echo "</table> </div>";
	odbc_free_result($result);
	odbc_close($con);
?>
</body>
