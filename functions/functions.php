<?php
function randomPassword($length=4)
	{

		$chars		= '0123456789';
		$i		= 0;
		$pass		= '' ;

		srand((double)microtime()*1000000);

		while ($i <= $length)
		{
			$num	= rand() % 10;
			$tmp	= substr($chars, $num, 1);
			$pass	= $pass . $tmp;
			$i++;
		}

		return $pass;

	}

?>