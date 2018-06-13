<?php
/* 
Main TPL
Fecha 5-29-2018
Version 1
Test V1 
*/

//TestV1-OK-- Database Connection*****/////
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
//TestV1-OK--//****UN %       *****/////
  if ($teamoption <> ""){
    //TestV1-OK--//Buscar nivel de Jerarquia para usar en la query total.
      // echo "Test Teamoption: " . $teamoption."<br>";
      $hsearch = "SELECT intLevel FROM Teams WHERE szTeam = '$teamoption'";
      $result = odbc_exec($con,$hsearch);
      if(!$result){
        echo "<center>Error detected:Query <b>".$hsearch."</b>did not work.<br>Please contact the administrator</center><br>".odbc_errormsg($hsearch);
      }else{
        $row = odbc_fetch_array($result);
        $teamlist = $row['intLevel'];
      }
      // echo "Test intlevel: ".$teamlist."<br>";
      releasconnection($result,$con);
    //TestV1-OK--//Busca la lista de teams debajo del nivel buscado.
      $htsearch = "SELECT szTeam FROM Teams WHERE $teamlist = '$teamoption'";
      $result = odbc_exec($con,$htsearch);
      if(!$result){
        echo "<center>Error detected:Query <b>".$htsearch."</b>did not work.<br>Please contact the administrator</center><br>".odbc_errormsg($htsearch);
      }else{
        $userteams = "'";
        while($row = odbc_fetch_array($result)){
          $userteams = $userteams.$row['szTeam']."', '";
        }
        $userteams ="'".trim($userteams, ", '") ."'" ;//En el formato 'team1','team2',etc
        // echo "Test query: ".$userteams."<br>";
       }
       releasconnection($result,$con);
    //TestV1-OK--//Busca cantidad total de unnasigned aplicando filtro de usuario.
      $uncountquery = "SELECT count(szTeam) AS resultado FROM TicketsOL WHERE szTeam in ($userteams) and mnTicketLineNumber = 1 and szTicketTable = '0'" ;
      $result = odbc_exec($con,$uncountquery);
      if(!$result){
        echo "<center>Error detected:Query <b>".$uncountquery."</b>did not work.<br>Please contact the administrator</center><br>".odbc_errormsg($uncountquery);
      }else{
        $row = odbc_fetch_array($result);
        $total_unnasigned = $row['resultado'];
      }
      releasconnection($result,$con);
    //TestV1-OK--//Busca la cantidad total de tickets en la tabla OL aplicando filtro de usuario.
      $OLquery = "SELECT count(szTeam) AS resultado FROM TicketsOL WHERE szTeam in ($userteams) and mnTicketLineNumber = 1";
      $result = odbc_exec($con,$OLquery);
      if(!$result){
        echo "<center>Error detected:Query <b>".$OLquery."</b>did not work.<br>Please contact the administrator</center><br>".odbc_errormsg($OLquery);
      }else{
        $row = odbc_fetch_array($result);
        $total_OL = $row['resultado'];
      }
      releasconnection($result,$con);
  }else{
    echo "<center>Error detected: Team is not declared.<br>Please contact the administrator</center>";
  }
    //echo "test OK UN % query";

//TestV1-OK--//*****IP overdue *****/////
  //TestV1-OK--//Busca los numeros de TK con delay para usarlos en la siguiente query.
    $delayedNtk2 = "";
    $prequery_ipdelayed = "SELECT Tickets.mnTicketNumber, Tickets.gdOpenDate, Subcategories.mnEstimateWD from (Subcategories INNER JOIN Tickets ON Subcategories.ConcatSA = Tickets.ConcatTK) WHERE Tickets.szStatus ='Open' AND Tickets.szTeam in ($userteams)";
    $result = odbc_exec($con,$prequery_ipdelayed);
     //echo "Query: ".$prequery_ipdelayed."<br>";
    if(!$result){
      echo "<center>Error detected:Query <b>".$prequery_ipdelayed."</b>did not work.<br>Please contact the administrator</center><br>".odbc_errormsg($prequery_ipdelayed);
    }else{
    while($row = odbc_fetch_array($result))
        {
          $TimePassed = number_of_working_days( $row['gdOpenDate'] , datetimenow());
          // echo "TK = ". $row['mnTicketNumber']." delay = ".$TimePassed;
          $a = ($TimePassed >= $row['mnEstimateWD'] ? $row['mnTicketNumber'].", ": " " );
          $delayedNtk2 = $delayedNtk2.$a;
          // echo $delayedNtk2;
        }
        $delayedNtk2 = trim(trim($delayedNtk2), ', ');
      }
        // echo $delayedNtk2;
        releasconnection($result,$con);
  //TestV1-OK--//Busca el numero de casos in progress con delay.  
    $queryextra = ($delayedNtk2 == "" ? "": "AND mnTicketNumber IN ($delayedNtk2)" );
    $querytablaOL = "SELECT mnTicketNumber FROM Tickets WHERE mnTicketLineNumber = 1".$queryextra;
    // echo "Query:".$querytablaOL."<br>";
    $result=odbc_exec($con,$querytablaOL);
    if(!$result){
      echo "<center>Error detected:Query <b>".$querytablaOL."</b>did not work.<br>Please contact the administrator</center><br>".odbc_errormsg($querytablaOL);
    }else{
      $items = 0;
    while ($row = odbc_fetch_array($result))
      {
      $items++;
      }
    }
    releasconnection($result,$con);
    $totalopeoverdue = $items;
    // echo "Total Open items con delay= ".$totalopeoverdue."<br>";
  //TestV1-OK--//Busca total de tickets
    $query2 = "SELECT mnTicketNumber FROM Tickets WHERE mnTicketLineNumber = 1";
    if(($result=odbc_exec($con,$query2))=== false )
    die("Query error." .odbc_errormsg($query2));
    $items = 0;
    while ($row = odbc_fetch_array($result))
    {
      $items++;
    }
    $totalIP = $items;
    releasconnection($result,$con);
  //TestV1-OK--//Busca total de tickets OPEN
    $query3 = "SELECT mnTicketNumber FROM Tickets WHERE mnTicketLineNumber = 1 AND szStatus = 'Open'";
    if(($result=odbc_exec($con,$query3))=== false )
    die("Query error." .odbc_errormsg($query3));
    $items = 0;
    while ($row = odbc_fetch_array($result))
    {
      $items++;
    }
    $totalIPo = $items;
    releasconnection($result,$con);
    // echo "total IP Open ".$totalIPo."<br>";
    //echo "cantoipoverdue ".$totalopeoverdue."<br>";
  //TestV1-OK--//Calculo de porcentaje de In progress con delay
    $cantoipoverdue = round((($totalopeoverdue / canntdividebyzero($totalIP)) * 100),1);// % total de Inprogress Overdue
    //echo "cantoipoverdue ".$totalopeoverdue."<br>";
    //echo "Test OK IP overdue %";

    
//TestV1-OK--/////*****UN overdue *****/////
  //TestV1-OK--//Query para obtener los mnOLticket con delay(lista de tk y cantidad).
    $oloverduelist = "SELECT mnOLTicket, gdReceived from TicketsOL where szTicketTable = '0' and mnTicketLineNumber = 1";
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
  //TestV1-OK--//Calculo de procentaje de UN Delayed
    $un_overdueporcentaje =round((($cantidadUNoverdue / canntdividebyzero($total_unnasigned)) * 100),1);// % total de unnasigned overdue
//TestV1-OK--/////*****Delayed %  *****/////
  $totun = $cantidadUNoverdue+$totalopeoverdue;
  $tottot = $totalIP + $total_OL;
  // echo "totalUNdelayed = ".$cantidadUNoverdue."<br>";
  // echo "cantoipoverdue = ".$totalopeoverdue."<br>";
  // echo "totalIP = ".$totalIP."<br>";
  // echo "CantOL = ".$total_OL."<br>";  
  // echo "totun = ".$totun."<br>";
  // echo "tottot = ".$tottot."<br>";
  $Totaloverdue = ($totun/canntdividebyzero($tottot))*100;
  $Totaloverdue = round($Totaloverdue,1);
  // echo "totun / tottot = ".$Totaloverdue."<br>";
//TestV1-OK--//////*****Total completed */
  //echo "Team Optiom test: " . $teamoption."<br>";
  $totalCompleted = "SELECT count(szTeam) AS resultado FROM Tickets WHERE szTeam = '$teamoption' and mnTicketLineNumber =1 AND szStatus = 'Closed'";
  $result = odbc_exec($con,$totalCompleted);
  if(!$result){
    echo "<center>Error detected:Query <b>".$totalCompleted."</b>did not work.<br>Please contact the administrator</center><br>".odbc_errormsg($totalCompleted);
  }else{
    $row = odbc_fetch_array($result);
    $total_Completed = $row['resultado'];
  }
  releasconnection($result,$con);
  
//TestV1-OK--//Calculo del procentaje
$un_porcentaje =round((($total_unnasigned / canntdividebyzero($total_unnasigned+$totalIP+$total_Completed)) * 100),1);// % total de unnasigned
//echo "Total Unnasigned: ".$total_unnasigned."<br>";
// echo "Total OL: ".$total_OL."<br>";
//echo "Porcentaje de UN: ". $un_porcentaje."<br>";
?>