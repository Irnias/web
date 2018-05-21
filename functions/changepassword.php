<?php
session_start();
ob_start();

if(isset($_POST['submit']))
{

    $pasact = $_POST['actual_password'];
    $pasnew = $_POST['new_password'];
    $pasren = $_POST['new_re_password'];

    //*****************Validations*****************//
    //Check spesialcharacters**********************//
    if(preg_match('/[^a-zA-Z\d]/', $pasact) or preg_match('/[^a-zA-Z\d]/', $pasnew) or preg_match('/[^a-zA-Z\d]/', $pasren))
    {
        echo "Tiene caracteres especiales";
        $_SESSION['pw']=1; //Spesialcharerror
        header("refresh:0;url=../index.php");

        //Check que sean iguales******************//
        if($pasren <> $pasnew)
        {
            echo "Las contraseñas no coinciden";
            $_SESSION['pw']=2; //Passwords does not equals
            header("refresh:0;url=../index.php");
        }
    }
    

}

?>
