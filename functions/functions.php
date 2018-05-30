<?php

function releasconnection($result,$con){
    $result = $result;
    $con = $con;
    odbc_free_result($result);
    unset($result);
    odbc_close($con);
    return 0;
}

function canntdividebyzero($var){
    $value = $var;
    if ($value == 0){
        $value = 1;
    }
    return$value;

}


?>