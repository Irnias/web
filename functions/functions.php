<?php

function releasconnection($result,$con){
    $result = $result;
    $con = $con;
    odbc_free_result($result);
    unset($result);
    odbc_close($con);
    return 0;
}

?>