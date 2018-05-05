<?php
;include ('tpl\header.tpl.php')
?>
<?php
if($_SESSION['log'] == 1 )
{
switch ($_SESSION['webid']) {
	case '1':
include ('tpl\main.tpl.php');
		break;
	case '2':
include ('tpl\mycases.tpl.php');
		break;
	case '3':
include ('tpl\particularcase.tpl.php');
		break;
	case '4':
include ('tpl\ocases.tpl.php');
		break;
		case '5':
	include ('tpl\full.tpl.php');
			break;
		case '6':
	include ('tpl\myocases.tpl.php');
			break;
default:
	echo "";
		break;
}

}
else
{
	include ('tpl\login.tpl.php');
}
?>
<?php
;include ('tpl\footer.tpl.php')
?>
