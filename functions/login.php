<?php
session_start();
ob_start();

// GET USER and Password from user.
if(isset($_POST['submit']))
$userID = $_POST['userid'];
$pincode = $_POST['pincode'];
$_SESSION['login']=$userID;

//Validations
$userID = htmlspecialchars($userID);
$userID = stripslashes($userID);
$pincode = htmlspecialchars($pincode);
$pincode = stripslashes($pincode);

//Login process
if(isset($_POST['submit']))
{
		//Valid no blanks
		if($userID=="" || $pincode=="")
		{
			$_SESSION['log']=2;// empty fields.
			header("refresh:0;url=../index.php");
		}
		else
		{
		//Busca user y password en la base de datos
		$con=odbc_connect("Test1","","");
		$_SESSION['log']=3;
		$sql="select * from ACN_Users where UserID = '".$userID."' and Pincode = '".$pincode."'";
		$result=odbc_exec($con,$sql);
		$count=odbc_fetch_row($result);
			//If exist:
			if($count==1)
			{
				$_SESSION['log']=1;
				$_SESSION['webid']=1;

 //GET Name instead user.
   $sql2= "select ACN_Users.[Analyst] from ACN_Users where UserID = '".$userID."'";
   if(($result=odbc_exec($con,$sql2))=== false )		//Run query and validate.
     die("Query error." .odbc_errormsg($sql2));		//Run query and validate.
   {
		 $row = odbc_fetch_array($result);
     $userID = $row['Analyst'];
		 $_SESSION['logedas']=$userID;
   }
   odbc_free_result($result);
   odbc_close($con);
				header("refresh:0;url=../index.php");

			}
			else
			{
				header("refresh:0;url=../index.php");
			}
		}
}
else
{
	echo "Invalid request, please log in first.";
	header("refresh:0;url=index.php");
}
?>
