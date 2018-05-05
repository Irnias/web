<?php
;include ('tpl\header.tpl.php')

?>
<?php
$tk = $_GET['TK'];
if ($tk = "OL") {
  $fromsearch = "TicketOL"
  $ticketfieldsearch = "OLTicket"
} else {
  $fromsearch = "Tickets"
}
 if(($con=odbc_connect("PTTO","",""))=== false )	//Database connect.
   die("connection error");						//Database connect.

 $sql="select TOP 1 * from $fromsearch where $ticketfieldsearch like ('%".$tk."%') ORDER BY mnTicketNumber DESC, mnTicketLineNumber DESC" ;						//Sql query.

 if(($result=odbc_exec($con,$sql))=== false )		//Run query and validate.
   die("Query error." .odbc_errormsg($sql));		//Run query and validate.

 echo"<div class=\"container\">
 <h1>Details<small></small></h1>
 </div>";

 echo "<div class=\"container\"><table class=\"table primary table-striped table-bordered table-hover\"><tr><th>Ticket Number</th><th>Team</th><th>Status</th><th>Tk created</th><th>Requestor</th><th>Description</th><th>Analyst</th></tr>";
 while($row = odbc_fetch_array($result))
 {
  echo "<a href=\"index.php\"><tr><td>TK".str_pad($row['mnTicketNumber'], 8, "0", STR_PAD_LEFT)."</td><td>".$row['szTeam']."</td><td>".$row['szStatus']."</td><td class=\"text-nowrap\">".$row['gdCreationDate']."</td><td >".$row['szRequestor']."</td><td>".$row['szDescription']."</td><td class=\"text-nowrap\">".$row['szResponsible']."</td></tr></a>";
 }
 echo "</table> </div>";
 odbc_free_result($result);
 odbc_close($con);


 if(($con=odbc_connect("PTTO","",""))=== false )	//Database connect.
   die("connection error");						//Database connect.

 $sql="select * from WebTickets where mnTicketNumber = $tk";						//Sql query.

 if(($result=odbc_exec($con,$sql))=== false )		//Run query and validate.
   die("Query error." .odbc_errormsg($sql));		//Run query and validate.

 echo"<div class=\"container\">
 <h1>History<small></small></h1>
 </div>";

 echo "<div class=\"container\"><table class=\"table primary table-striped table-bordered table-hover\"><tr><th>Ticket Number</th><th>N°</th><th>Team</th><th>Status</th><th>Tk created</th><th>Requestor</th><th>Description</th><th>Analyst</th></tr>";
 while($row = odbc_fetch_array($result))
 {
 echo "<a href=\"index.php\"><tr><td>TK" .$row['mnTicketNumber']."</td><td>" .$row['mnTicketLineNumber']."</td><td>".$row['szTeam']."</td><td>".$row['szStatus']."</td><td class=\"text-nowrap\">".$row['gdCreationDate']."</td><td >".$row['szRequestor']."</td><td>".$row['szDescription']."</td><td class=\"text-nowrap\">".$row['szResponsible']."</td></tr></a>";
 }
 echo "</table> </div>";
 odbc_free_result($result);
 odbc_close($con);
?>
</body>
<?php
;include ('tpl\footer.tpl.php')
?>
