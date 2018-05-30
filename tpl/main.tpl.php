<?php
  include ('tpl\Queries\main.query.tpl.php')
?>
<div class="container-fluid"> <br> Welcome <?php echo $_SESSION['aname']; ?></div><br><br><br>
<div class="container-fluid">
  <div class="container col-xs-1">
    <center>Filters</center>
    <div role="tabpanel">
      <ul class="nav nav-pills nav-stacked">
        <!-- <li class="btn btn-default active"><a href="#select1" aria-controls="select1" data-toggle="tab" role="tab">Nile</a></li> -->
        <li class="btn btn-default active"><a href="#select2" aria-controls="select2" data-toggle="tab" role="tab">Settl.</a></li>
        <!-- <li class="btn btn-default"><a href="#select3" aria-controls="select3" data-toggle="tab" role="tab">Bulk</a></li>
        <li class="btn btn-default"><a href="#select3" aria-controls="select3" data-toggle="tab" role="tab">Truck</a></li> -->
      </ul>
    </div>
  </div>
  <div class="clearfix visible-xs-block"></div>
  <div class="container col-xs-3">
    <?php
    include ('tpl\include\main.column2.tpl.php')
    ?>
  </div>
  <div class="clearfix visible-xs-block"></div>
    <div class="container col-xs-8">
    <?php
    include ('tpl\include\main.column3.tpl.php')
    ?>
</div>
</body>
<br><br><br><br><br>