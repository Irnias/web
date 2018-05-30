<?php
;include ('tpl\header.tpl.php')
;include ('functions\workingdays.php')
;include ('functions\functions.php')
?>
<?php
//Define si es TK u OL
  if(isset($_GET['TK'])){
    $tk = $_GET['TK'];
    //  echo "Agarro TK";
    $fromsearch = "Tickets";
    $ticketfieldsearch = "mnTicketNumber";
  }
  if(isset($_GET['OL'])){
    $tk = $_GET['OL'];
    // echo "Agarro OL";
    $fromsearch = "TicketsOL";
    $ticketfieldsearch = "mnOLTicket";
  }

//Query primera tabla
  if(($con=odbc_connect("PTTO","",""))=== false )	//Database connect.
    die("connection error");						//Database connect.

  $sql="SELECT TOP 1 * from $fromsearch where $ticketfieldsearch like ('%".$tk."%') ORDER BY $ticketfieldsearch DESC, mnTicketLineNumber DESC" ;						//Sql query.

  if(($result=odbc_exec($con,$sql))=== false )		//Run query and validate.
    die("Query error." .odbc_errormsg($sql));		//Run query and validate.

    echo"<div class=\"container\"><h1>Details<small></small></h1></div>";
  //CABECERAS    
    //Caso busqueda de TK
      if(isset($_GET['TK'])){
        echo "<div class=\"container\">
                <table class=\"table primary table-striped table-bordered table-hover\">
                  <tr>
                    <th>Ticket Number</th>
                    <th>Team</th>
                    <th>Status</th>
                    <th>Tk created</th>
                    <th>Requestor</th>
                    <th>Description</th>
                    <th>Analyst</th>
                  </tr>";
    //Caso busqueda de Unnasigned
      }else{
      echo "<div class=\"container\">
          <table class=\"table primary table-striped table-bordered table-hover\">
            <tr>
              <th>Team</th>
              <th>Time created</th>
              <th>Requestor</th>
              <th>Description</th>
              <th>Time Delayed</th>
            </tr>";
      }
  //Cuerpos
    while($row = odbc_fetch_array($result))
    {
    //Caso de TK
      if(isset($_GET['TK'])){ 
      echo "<tr>
              <td>TK".str_pad($row['mnTicketNumber'], 8, "0", STR_PAD_LEFT)."</td>
              <td>".$row['szTeam']."</td>
              <td>".$row['szStatus']."</td>
              <td class=\"text-nowrap\">".$row['gdCreationDate']."</td>
              <td >".$row['szRequestor']."</td>
              <td>".$row['szDescription']."</td>
              <td class=\"text-nowrap\">".$row['szResponsible']."</td>
            </tr>";
    //Caso de OL
      }else{
          $open = $row['gdReceived'];
          $TimePassed = number_of_working_days($open , datetimenow());
      echo "<tr>
        <td>".$row['szTeam']."</td>
        <td class=\"text-nowrap\">".$open."</td>
        <td >".$row['szFROM']."</td>
        <td>".$row['szSubject']."</td>
        <td class=\"text-nowrap\">$TimePassed WD</td>
      </tr>";
      }
    }
    echo "</table> </div>";
    odbc_free_result($result);
    odbc_close($con);

//Query Segunda tabla
 if(($con=odbc_connect("PTTO","",""))=== false )	//Database connect.
   die("connection error");						//Database connect.

 $sql="SELECT * from $fromsearch where $ticketfieldsearch = ".$tk.";";						//Sql query.

 if(($result=odbc_exec($con,$sql))=== false )		//Run query and validate.
   die("Query error." .odbc_errormsg($sql));		//Run query and validate.

 echo"<div class=\"container\">
 <h1>History<small></small></h1>
 </div>";

  //Cabeceras
    //Caso busqueda TK
      if(isset($_GET['TK'])){
      echo "<div class=\"container\">
            <table class=\"table primary table-striped table-bordered table-hover\">
              <tr>
                <th>Ticket Number</th>
                <th>N°</th>
                <th>Team</th>
                <th>Status</th>
                <th>Tk created</th>
                <th>Requestor</th>
                <th>Description</th>
                <th>Analyst</th>
              </tr>";
    //Caso busqueda unnnasigned
      }else{
      echo "<div class=\"container\">
            <table class=\"table primary table-striped table-bordered table-hover\">
              <tr>
                <th>N°</th>
                <th>Team</th>
                <th>Time created</th>
                <th>Requestor</th>
                <th>Description</th>
                <th>Time Delayed</th>
              </tr>";
      }
      while($row = odbc_fetch_array($result))
      {
  //Cuerpo
    //Caso TK
      if(isset($_GET['TK'])){
      echo "<tr>
      <td>TK" .$row['mnTicketNumber']."</td>
      <td>" .$row['mnTicketLineNumber']."</td>
      <td>".$row['szTeam']."</td>
      <td>".$row['szStatus']."</td>
      <td class=\"text-nowrap\">".$row['gdCreationDate']."</td>
      <td >".$row['szRequestor']."</td>
      <td>".$row['szDescription']."</td>
      <td class=\"text-nowrap\">".$row['szResponsible']."</td>
      </tr>";
      }
    //Caso OL
      else{
        $open = $row['gdReceived'];
        $TimePassed = number_of_working_days($open , datetimenow());
        echo "<tr>
        <td>" .$row['mnTicketLineNumber']."</td>
        <td>".$row['szTeam']."</td>
        <td class=\"text-nowrap\">".$row['gdReceived']."</td>
        <td >".$row['szFROM']."</td>
        <td>".$row['szSubject']."</td>
        <td class=\"text-nowrap\">$TimePassed WD</td>
      </tr>";
      }
      }
      echo "</table> </div>";
      odbc_free_result($result);
      odbc_close($con);
?>
</body>
<?php
;include ('tpl\footer.tpl.php')
?>
