<div role ="tabpanel">
  <ul class="nav nav-tabs" role="tablist">
      <li role"presentation" class="active"><a href="#tab1" aria-controls="tab1" data-toggle="tab" role="tab">Delayed</a></li>
      <li role"presentation"><a href="#tab2" aria-controls="tab2" data-toggle="tab" role="tab">Unassigned</a></li>
      <li role"presentation"><a href="#tab3" aria-controls="tab3" data-toggle="tab" role="tab">In progress</a></li>
      <li role"presentation"><a href="#tab4" aria-controls="tab4" data-toggle="tab" role="tab">Completed</a></li>
  </ul>
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="tab1"> <!--Delayed TAB-->
      <div class="container-fluid">
        <h2 class="bg-danger">In Progress Overdue</h2>
          <?php
            //PreQuery
              $delayedNtk = "";
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
                    $a = ($TimePassed > $row['mnEstimateWD'] ? $row['mnTicketNumber'].", ": "" );
                    $delayedNtk = $delayedNtk.$a;
                  }
                  $delayedNtk = $delayedNtk.$a;
                  $delayedNtk =trim($delayedNtk, ', ');
                  odbc_free_result($result);
                  unset($result);
                  odbc_close($con);
            //Query  
              $querytablaOL = "SELECT *, Subcategories.mnEstimateWD from (Subcategories INNER JOIN Tickets ON Subcategories.szActivitySubCategory = Tickets.szActivitySubCategory) WHERE mnTicketLineNumber = 1 AND mnTicketNumber in (".$delayedNtk.")";
              if(($result=odbc_exec($con,$querytablaOL))=== false )		//Run query and validate.
              die("Query error." .odbc_errormsg($querytablaOL));		//Run query and validate.
              echo "
                <table class=\"table primary table-striped table-bordered table-hover\">
                  <tr class=\"danger\">
                    <th>Ticket</th>
                    <th>Subject</th>
                    <th>From</th>
                    <th>Recived</th>
                    <th class=\"text-nowrap\">Time Passed</th>
                    <th>Target</th>
                    <th class=\"text-nowrap\">Overdue by</th>
                  </tr>";
              while($row = odbc_fetch_array($result))
                {
                  $tk = $row['mnTicketNumber'];
                  $open = $row['gdOpenDate'];
                  $close = datetimenow();
                  $TimePassed = number_of_working_days( $open , $close);
                  $a = ($TimePassed > 0 ? $TimePassed." wd ": "" );
                  $HoursPassed = hours_of_working_days( $open , $close);
                  $Target = $row['szActivitySubCategory'];
                  $overdue = $TimePassed - $row['mnEstimateWD'];
                  echo "
                  <tr>
                    <td>TK".$tk."</td>
                    <td><a href=\"search.php?TK=$tk\">".$row['szDescription']."</a></td>
                    <td>".$row['szRequestor']."</td>
                    <td>".$open."</td>
                    <td>".$a .$HoursPassed." hs</td>
                    <td>".$Target."</td>
                    <td><center>".$overdue." WD</center></td>
                  </tr>";
                }
                echo "
                </table>";
                odbc_free_result($result);
                unset($result);
                odbc_close($con);
          ?>
        <h2 class="bg-danger">Unnasigned Delayed</h2>
            <?php
              $prequery = "select mnOLTicket, gdRecived from TicketOL where szTicketTable <> 'Null' and mnTicketLineNumber = 1";
              $delayedNtk = "";
              if(($result=odbc_exec($con,$prequery))=== false )		//Run query and validate.
                  die("Query error." .odbc_errormsg($prequery));
                  echo "
                  <table class=\"table primary table-striped table-bordered table-hover\">
                  <tr class=\"danger\">
                    <th>Subject</th>
                    <th>From</th>
                    <th>Recived</th>
                    <th class=\"text-nowrap\">Time Passed</th>
                  </tr>";
                while($row = odbc_fetch_array($result))
                {
                  $open = $row['gdRecived'];
                  $close = datetimenow();
                  $TimePassed = number_of_working_days( $open , $close);
                  $a = ($TimePassed > 0 ? $row['mnOLTicket'].", ": "" );
                  $delayedNtk = $delayedNtk.$a;
                }
                $delayedNtk =trim($delayedNtk, ', ');
                odbc_free_result($result);
                unset($result);
                odbc_close($con);
            ?>
            <?php
                $querytablaOL = "SELECT gdRecived, mnOLTicket, szSubject, szFROM from TicketOL where mnOLTicket in (".$delayedNtk.") order by mnOLTicket desc";
                $result=odbc_exec($con,$querytablaOL);
                  if(!$result){
                    echo "Query error." .odbc_errormsg($querytablaOL);
                  }
                while($row = odbc_fetch_array($result))
                  {
                    $open = $row['gdRecived'];
                    $close = datetimenow();
                    $TimePassed = number_of_working_days($open , $close);
                    echo "  
                    <tr>
                      <td><a href=\"search.php?OL=".$row['mnOLTicket']."\">".$row['szSubject']."</a></td>
                      <td>".$row['szFROM']."</td>
                      <td>".$open."</td>
                      <td><center>".$TimePassed." wd</center></td>
                    </tr>";
                  }
                echo "
                </table>";
              odbc_free_result($result);
              unset($result);
              odbc_close($con);
            ?>
      </div>
    </div>
    <div role="tabpanel" class="tab-pane" id="tab2"> <!-- Unnasigned TAB-->
      <?php
        $querytablaOL = "select * from TicketOL where szTicketTable <> 'Null' and mnTicketLineNumber = 1";
        if(($result=odbc_exec($con,$querytablaOL))=== false )		//Run query and validate.
          die("Query error." .odbc_errormsg($querytablaOL));		//Run query and validate.
        echo "
        <div class=\"container-fluid\">
          <table class=\"table primary table-striped table-bordered table-hover\">
            <tr class=\"info\">
              <th>Subject</th>
              <th>From</th>
              <th>Recived</th>
              <th class=\"text-nowrap\">Time Passed</th>
            </tr>";
        while($row = odbc_fetch_array($result))
        {
          $open = $row['gdRecived'];
          $close = datetimenow();
          $TimePassed = number_of_working_days($open , $close);
          echo "  
          <tr>
            <td><a href=\"search.php?OL=".$row['mnOLTicket']."\">".$row['szSubject']."</a></td>
            <td>".$row['szFROM']."</td>
            <td>".$open."</td>
            <td><center>".$TimePassed." wd</center></td>
          </tr>";
        }
            echo "</table></div>";
            odbc_free_result($result);
            odbc_close($con);
      ?>
    </div>
    <div role="tabpanel" class="tab-pane" id="tab3">  <!--In progress TAB-->
              <?php
                $querytablatk = "select * from Tickets where szStatus = 'Open' order by mnTicketNumber desc ";
                if(($result3=odbc_exec($con,$querytablatk))=== false )		//Run query and validate.
                  die("Query error." .odbc_errormsg($querytablatk));		//Run query and validate.
                  echo "
                    <div class=\"container-fluid\">
                      <table class=\"table primary table-striped table-bordered table-hover\">
                        <tr class=\"info\">
                          <th>Ticket</th>
                          <th>Subject</th>
                          <th>From</th>
                          <th>Recived</th>
                          <th>Analyst</th>
                          <th class=\"text-nowrap\">Time Passed</th>
                          <th>Target</th>
                        </tr>";
                while($row = odbc_fetch_array($result3))
                {
                  $tk = $row['mnTicketNumber'];
                  $open = $row['gdOpenDate'];
                  $close = datetimenow();
                  $TimePassed = number_of_working_days( $open , $close);
                  $a = ($TimePassed > 0 ? $TimePassed." wd ": "" );
                  $HoursPassed = hours_of_working_days( $open , $close);
                  $Target = $row['szActivitySubCategory'];
                  echo "
                        <tr>
                          <td>TK".$tk."</td>
                          <td><a href=\"search.php?TK=$tk\">".$row['szDescription']."</a></td>
                          <td>".$row['szRequestor']."</td>
                          <td>".$open."</td>
                          <td>".$row['szResponsible']."</td>
                          <td>".$a .$HoursPassed." hs</td>
                          <td>".$Target."</td>
                        </tr>";
                }
                    echo "
                    </table>
                    </div>";
                    odbc_free_result($result3);
                    odbc_close($con);
              ?>
    </div>
    <div role="tabpanel" class="tab-pane" id="tab4"> <!--Completed TAB -->
      <?php
        $querytablaOL = "select * from Tickets where szStatus= 'closed'";
        if(($result=odbc_exec($con,$querytablaOL))=== false )		//Run query and validate.
          die("Query error." .odbc_errormsg($querytablaOL));		//Run query and validate.
        echo "
        <div class=\"container-fluid\">
          <table class=\"table primary table-striped table-bordered table-hover\">
            <tr class=\"success\">
              <th>Subject</th>
              <th>From</th>
              <th>Analyst</th>
              <th>Recived</th>
              <th class=\"text-nowrap\">Completation date</th>
              <th>Target</th>
              <th>Time Passed</th>
            </tr>";
        while($row = odbc_fetch_array($result))
        {
          $tk = $row['mnTicketNumber'];
                  $open = $row['gdRequestedTime'];
                  $close = $row['gdCloseDate'];
                  $TimePassed = number_of_working_days( $open , $close);
                  $a = ($TimePassed > 0 ? $TimePassed." wd ": "" );
                  $HoursPassed = hours_of_working_days( $open , $close);
                  $Target = $row['szActivitySubCategory'];
          echo "
            <tr>
              <td><a href=\"search.php?TK=$tk\">".$row['szDescription']."</a></td>
              <td>".$row['szRequestor']."</td>
              <td>".$row['szResponsible']."</td>
              <td>".$open."</td>
              <td >".$close."</td>
              <td>".$Target."</td>
              <td>".$a .$HoursPassed." hs</td>
            </tr>";
        }
            echo "</table></div>";
      ?>
    </div>
  </div> 
</div>