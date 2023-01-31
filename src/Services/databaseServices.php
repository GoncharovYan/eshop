<?php

require_once 'configurationServices.php';

function getDbConnection()
{
	static $connection = null;
	if ($connection === null)
	{
		$dbHost = option('DB_HOST');
		$dbUser = option('DB_USER');
		$dbPass = option('DB_PASSWORD');
		$dbName = option('DB_NAME');
        echo  $dbHost;
		$connection = mysqli_init();
		$connected = mysqli_real_connect($connection, $dbHost, $dbUser, $dbPass, $dbName);
		if (!$connected)
		{
			$error = mysqli_connect_error() . ': ' . mysqli_connect_error();
			throw new Exception($error);
		}

		$encodingResult = mysqli_set_charset($connection, 'utf8');
		if (!$encodingResult)
		{
			throw new Exception(mysqli_error($connection));
		}
	}
	return $connection;
}

$connection = getDbConnection();