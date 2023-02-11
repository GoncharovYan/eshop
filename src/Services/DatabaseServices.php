<?php

namespace Services;

class DatabaseServices
{
    public static function getDbConnection()
    {
        static $connection = null;
        if ($connection === null)
        {
            $dbHost = ConfigurationServices::option('DB_HOST');
            $dbUser = ConfigurationServices::option('DB_USER');
            $dbPass = ConfigurationServices::option('DB_PASSWORD');
            $dbName = ConfigurationServices::option('DB_NAME');
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

	public static function getPdoConnection(){
		static $db = null;
		if($db === null) {
			$dbHost = ConfigurationServices::option('DB_HOST');
			$dbUser = ConfigurationServices::option('DB_USER');
			$dbPass = ConfigurationServices::option('DB_PASSWORD');
			$dbName = ConfigurationServices::option('DB_NAME');
			try {
				$db = new \PDO('mysql:host='.$dbHost.';dbname='.$dbName, $dbUser, $dbPass);
			} catch(\Exception $e) {
				throw new \Exception('Error creating a database connection ');
			}
		}
		return $db;
	}
}