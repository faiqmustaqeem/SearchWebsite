<?php

//$Connection = mysqli_connect('localhost', 'extendic_urluser', '123456', 'extendic_urldb');
$Connection = mysqli_connect('localhost', 'root', '', 'search_websites');
if (!$Connection || mysqli_errno($Connection))
	die('Can not connect to database.');

function Search_Query($Query, $FirstRow = false, $PrintError = false)
{
	global $Connection;
	$QueryResult = mysqli_query($Connection, $Query);

	if ($PrintError == true)
	{
		echo mysqli_error($Connection);
	}

	$Result = array();
	if (mysqli_num_rows($QueryResult) > 0)
	{
		$i = 0;
		while($Result[$i] = mysqli_fetch_assoc($QueryResult))
			$i++;
		unset($Result[$i]);

		if ($FirstRow)
			return $Result[0];
	}
	
	return $Result;
}

function Single_Value_Query($Query)
{
	global $Connection;
	$QueryResult = mysqli_query($Connection, $Query);

	if(mysqli_num_rows($QueryResult) > 0)
	{
		while ($Row = mysqli_fetch_array($QueryResult,MYSQLI_BOTH))
		{
			return $Row[0];
		}
	}
	return false;
}

?>