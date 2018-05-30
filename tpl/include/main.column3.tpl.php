<div role ="tabpanel">
  <ul class="nav nav-tabs" role="tablist">
    <li role"presentation" class="active">
      <a href="#tab1" aria-controls="tab1" data-toggle="tab" role="tab" class="text-nowrap">Delayed
        <span class="badge">
          <?php echo $totun ; ?>
        </span>
      </a>
    </li>
    <li role"presentation">
      <a href="#tab2" aria-controls="tab2" data-toggle="tab" role="tab">Unassigned
        <span class="badge">
          <?php echo $total_unnasigned;?>
        </span>
      </a>
    </li>
    <li role"presentation">
      <a href="#tab3" aria-controls="tab3" data-toggle="tab" role="tab">In progress
        <span class="badge">
          <?php echo $totalIPo; ?>
        </span>
      </a>
    </li>
    <li role"presentation">
      <a href="#tab4" aria-controls="tab4" data-toggle="tab" role="tab">Completed
      <span class="badge">
          <?php echo $total_Completed; ?>
        </span>
      </a>
    </li>
  </ul>
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="tab1"> <!--Delayed TAB-->
      <div class="container-fluid">
        <h2 class="bg-danger">In Progress Overdue</h2>
          <?php
            //Query  
              $querytablaOL = "SELECT *, Subcategories.mnEstimateWD from (Subcategories INNER JOIN Tickets ON Subcategories.szActivitySubCategory = Tickets.szActivitySubCategory) WHERE mnTicketLineNumber = 1 AND mnTicketNumber in (".$delayedNtk2.")";
              // echo "Query IP OVerdue: ".$querytablaOL."<br>";
              if(($result=odbc_exec($con,$querytablaOL))=== false )		//Run query and validate.
              die("Query error." .odbc_errormsg($querytablaOL));		//Run query and validate.
              echo "
                <table class=\"table primary table-striped table-bordered table-hover\">
                  <tr class=\"danger\">
                    <th class=\"text-nowrap\" style=\"font-size:13px\"><center>Ticket</center></th>
                    <th class=\"text-nowrap\" style=\"font-size:13px\"><center>Subject</center></th>
                    <th class=\"text-nowrap\" style=\"font-size:13px\"><center>From</center></th>
                    <th class=\"text-nowrap\" style=\"font-size:13px\"><center>Recived</center></th>
                    <th class=\"text-nowrap\" style=\"font-size:13px\"><center>Time Passed</center></th>
                    <th class=\"text-nowrap\" style=\"font-size:13px\"><center>Target</center></th>
                    <th style=\"font-size:13px\"><center>Overdue</center></th>
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
                    <td class=\"text-nowrap\" style=\"font-size:11px\" >TK".$tk."</td>
                    <td class=\"text-nowrap\" style=\"font-size:11px\" ><a href=\"search.php?TK=$tk\">".$row['szDescription']."</a></td>
                    <td class=\"text-nowrap\" style=\"font-size:11px\" >".$row['szRequestor']."</td>
                    <td class=\"text-nowrap\" style=\"font-size:11px\" >".$open."</td>
                    <td class=\"text-nowrap\" style=\"font-size:11px\" >".$a .$HoursPassed." hs</td>
                    <td class=\"text-nowrap\" style=\"font-size:11px\" >".$Target."</td>
                    <td class=\"text-nowrap\" style=\"font-size:11px\" ><center>".$overdue." WD</center></td>
                  </tr>";
                }
                echo "
                </table>";
                releasconnection($result,$con);

          ?>
        <h2 class="bg-danger">Unnasigned Overdue</h2>
            <?php
                $querytablaOL = "SELECT gdReceived, mnOLTicket, szSubject, szFrom FROM TicketsOL WHERE mnOLTicket IN (".$delayedNtk_forlist.") order by mnOLTicket desc";
                $result=odbc_exec($con,$querytablaOL);
                  if(!$result){
                    echo "Query error." .odbc_errormsg($querytablaOL);
                  }
                  echo "
                  <table class=\"table primary table-striped table-bordered table-hover\">
                    <tr class=\"danger\">
                      <th class=\"text-nowrap\" style=\"font-size:13px\"><center>Subject</center></th>
                      <th class=\"text-nowrap\" style=\"font-size:13px\"><center>From</center></th>
                      <th class=\"text-nowrap\" style=\"font-size:13px\"><center>Recived</center></th>
                      <th class=\"text-nowrap\" style=\"font-size:13px\"><center>Time Passed</center></th>
                    </tr>";
                while($row = odbc_fetch_array($result))
                  {
                    $open = $row['gdReceived'];
                    $close = datetimenow();
                    $TimePassed = number_of_working_days($open , $close);
                    echo "  
                    <tr>
                      <td class=\"text-nowrap\" style=\"font-size:11px\"><a href=\"search.php?OL=".$row['mnOLTicket']."\">".$row['szSubject']."</a></td>
                      <td class=\"text-nowrap\" style=\"font-size:11px\">".$row['szFrom']."</td>
                      <td class=\"text-nowrap\" style=\"font-size:11px\">".$open."</td>
                      <td class=\"text-nowrap\" style=\"font-size:11px\"><center>".$TimePassed." wd</center></td>
                    </tr>";
                  }
                echo "
                </table>";
                releasconnection($result,$con);
            ?>
      </div>
    </div>
    <div role="tabpanel" class="tab-pane" id="tab2"> <!-- Unnasigned TAB-->
      <?php
        $querytablaOL = "select * from TicketsOL where szTicketTable = '0' and mnTicketLineNumber = 1";
        if(($result=odbc_exec($con,$querytablaOL))=== false )		//Run query and validate.
          die("Query error." .odbc_errormsg($querytablaOL));		//Run query and validate.
        echo "
        <div class=\"container-fluid\">
          <table class=\"table primary table-striped table-bordered table-hover\">
            <tr class=\"info\">
              <th class=\"text-nowrap\" style=\"font-size:13px\">Subject</th>
              <th class=\"text-nowrap\" style=\"font-size:13px\">From</th>
              <th class=\"text-nowrap\" style=\"font-size:13px\">Recived</th>
              <th class=\"text-nowrap\" style=\"font-size:13px\">Time Passed</th>
            </tr>";
        while($row = odbc_fetch_array($result))
        {
          $open = $row['gdReceived'];
          $close = datetimenow();
          $TimePassed = number_of_working_days($open , $close);
          echo "
          <tr>
            <td class=\"text-nowrap\" style=\"font-size:11px\"><a href=\"search.php?OL=".$row['mnOLTicket']."\">".$row['szSubject']."</a></td>
            <td class=\"text-nowrap\" style=\"font-size:11px\">".$row['szFROM']."</td>
            <td class=\"text-nowrap\" style=\"font-size:11px\">".$open."</td>
            <td class=\"text-nowrap\" style=\"font-size:11px\"><center>".$TimePassed." wd</center></td>
          </tr>";
        }
            echo "</table></div>";
            odbc_free_result($result);
            odbc_close($con);
      ?>
    </div>
    <div role="tabpanel" class="tab-pane" id="tab3">  <!--In progress TAB-->
              <?php
                $querytablatk = "SELECT * FROM Tickets WHERE szStatus = 'Open' order by mnTicketNumber desc ";
                if(($result3=odbc_exec($con,$querytablatk))=== false )		//Run query and validate.
                  die("Query error." .odbc_errormsg($querytablatk));		//Run query and validate.
                  echo "
                    <div class=\"container-fluid\">
                      <table class=\"table primary table-striped table-bordered table-hover\">
                        <tr class=\"info\">
                          <th class=\"text-nowrap\" style=\"font-size:13px\">Ticket</th>
                          <th class=\"text-nowrap\" style=\"font-size:13px\">Subject</th>
                          <th class=\"text-nowrap\" style=\"font-size:13px\">From</th>
                          <th class=\"text-nowrap\" style=\"font-size:13px\">Recived</th>
                          <th class=\"text-nowrap\" style=\"font-size:13px\">Analyst</th>
                          <th class=\"text-nowrap\" style=\"font-size:13px\">Time Passed</th>
                          <th class=\"text-nowrap\" style=\"font-size:13px\">Target</th>
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
                          <td class=\"text-nowrap\" style=\"font-size:11px\">TK".$tk."</td>
                          <td class=\"text-nowrap\" style=\"font-size:11px\"><a href=\"search.php?TK=$tk\">".$row['szDescription']."</a></td>
                          <td class=\"text-nowrap\" style=\"font-size:11px\">".$row['szRequestor']."</td>
                          <td class=\"text-nowrap\" style=\"font-size:11px\">".$open."</td>
                          <td class=\"text-nowrap\" style=\"font-size:11px\">".$row['szResponsible']."</td>
                          <td class=\"text-nowrap\" style=\"font-size:11px\">".$a .$HoursPassed." hs</td>
                          <td class=\"text-nowrap\" style=\"font-size:11px\">".$Target."</td>
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
        $querytablaOL = "select * from Tickets where szStatus= 'closed' and mnTicketLinenumber = 1 ";
        if(($result=odbc_exec($con,$querytablaOL))=== false )		//Run query and validate.
          die("Query error." .odbc_errormsg($querytablaOL));		//Run query and validate.
        echo "
        <div class=\"container-fluid\">
          <table class=\"table primary table-striped table-bordered table-hover\">
            <tr class=\"success\">
              <th class=\"text-nowrap\" style=\"font-size:13px\">Subject</th>
              <th class=\"text-nowrap\" style=\"font-size:13px\">From</th>
              <th class=\"text-nowrap\" style=\"font-size:13px\">Analyst</th>
              <th class=\"text-nowrap\" style=\"font-size:13px\">Recived</th>
              <th class=\"text-nowrap\" style=\"font-size:13px\">Completation date</th>
              <th class=\"text-nowrap\" style=\"font-size:13px\">Target</th>
              <th class=\"text-nowrap\" style=\"font-size:13px\">Time Passed</th>
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
              <td class=\"text-nowrap\" style=\"font-size:11px\"><a href=\"search.php?TK=$tk\">".$row['szDescription']."</a></td>
              <td class=\"text-nowrap\" style=\"font-size:11px\">".$row['szRequestor']."</td>
              <td class=\"text-nowrap\" style=\"font-size:11px\">".$row['szResponsible']."</td>
              <td class=\"text-nowrap\" style=\"font-size:11px\">".$open."</td>
              <td class=\"text-nowrap\" style=\"font-size:11px\">".$close."</td>
              <td class=\"text-nowrap\" style=\"font-size:11px\">".$Target."</td>
              <td class=\"text-nowrap\" style=\"font-size:11px\">".$a .$HoursPassed." hs</td>
            </tr>";
        }
            echo "</table></div>";
      ?>
    </div>
  </div> 
</div>