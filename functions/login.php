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

		try {
		    $mbd = new PDO('mysql:host=localhost dbname=ptt', "USERREAD", "1234");
				$mbd-> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$sqluser = "select * from ACN_Users where UserID = '".$userID."' and Pincode = '".$pincode."'";
				$statement = $mdb->prepare($sqluser);
				$statement->execute();
				$count = $statement->rowcount();

				$_SESSION['log']=3;
				if($count > 0)
				{
					$_SESSION['log']=1;
					$_SESSION['webid']=1;
			header("refresh:0;url=../index.php");
				//$result = $mbd->query($sqluser)->rowcount();
				}
		}
		 catch (PDOException $e) {
		    print "¡Error!: " . $e->getMessage() . "<br/>";
		    die();
		}
	}
		//
		// $con=mysqli_connect("127.0.0.1","","");
		// $_SESSION['log']=3;
		// $sql="select * from ACN_Users where UserID = '".$userID."' and Pincode = '".$pincode."'";
		// $result=mysqli_exec($con,$sql);
		// $count=mysqli_fetch_row($result);
	// 		//If exist:
	// 		if($result)
	// 		{
	// // 			$_SESSION['log']=1;
	// // 			$_SESSION['webid']=1;
 // // GET Name instead user.
 //   $sql2= "select * from ACN_Users where UserID = '".$userID."'";
 //   // if(($result=mysqli_exec($con,$sql2))=== false )		//Run query and validate.
 //   //   die("Query error." .mysqli_errormsg($sql2));		//Run query and validate.
 //   // {
	// 	//  $row = mysqli_fetch_array($result);
	// 	//  $analystName = $row['AnalystName']; // Get Analyst Name from database
 //   //   $userID = $row['Analyst']; // Get Analyst ID from database
	// 	//  $analystTeam = $row['AnalystTeam']; // Get Analyst Team from database
	// 	//  $_SESSION['logedas']=$userID; //Assign UserID global variable
	// 	//  $_SESSION['aname']=$analystName; //Assign Analist Name global variable
	// 	//  $_SESSION['team']=$analystTeam; //Assign Analist Team global variable
 //   // }
 //   mysqli_free_result($result);
 //   mysqli_close($con);

 //
	// 		}
			// else
			// {
			// 	header("refresh:0;url=../index.php");
			// }

}
else
{
	echo "Invalid request, please log in first.";
	header("refresh:1;url=index.php");
}
?>
