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
		$con=odbc_connect("PTTO","","");
		$_SESSION['log']=3;
		$sql="select * from ACN_Users where szUserID = '".$userID."' and szWebpw = '".$pincode."'";
		$result=odbc_exec($con,$sql);
		$count=odbc_fetch_row($result);
			//If exist:
			if($count==1)
			{
				$_SESSION['log']=1;
				$_SESSION['webid']=1;
 			//GET Name instead user.
				$sql2= "select szUsername, szEmailname, szUserTeam from ACN_Users where szUserID = '".$userID."'";
				if(($result=odbc_exec($con,$sql2))=== false )		//Run query and validate.
					die("Query error." .odbc_errormsg($sql2));		//Run query and validate.
				{
					$row = odbc_fetch_array($result);
					$analystName = $row['szUsername']; // Get Analyst Name from database
					$userID = $row['szEmailname']; // Get Analyst ID from database
					$analystTeam = $row['szUserTeam']; // Get Analyst Team from database
					$_SESSION['logedas']=$userID; //Assign UserID global variable
					$_SESSION['aname']=$analystName; //Assign Analist Name global variable
					$_SESSION['team']=$analystTeam; //Assign Analist Team global variable
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
	header("refresh:1;url=index.php");
}
?>
