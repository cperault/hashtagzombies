<?php
/******************************************************************************************************************\
 *File:    Database.php                                                                                            *
 *Project: #ZOMBIES                                                                                                *
 *Date:    October 23, 2019                                                                                        *
 *Purpose: This class will set up the connection to the MySql database.                                            *
\******************************************************************************************************************/
class Database
{
    private static $dsn = 'mysql:host=teamgreen.db.2823567.578.hostedresource.net;dbname=teamgreen';
    private static $username = 'teamgreen';
    private static $password = 'Blueteam@sucks2';
    private static $db;
    private function __construct()
    { }
    public static function getDB()
    {
        if (!isset(self::$db)) {
            try {
                self::$db = new PDO(self::$dsn, self::$username, self::$password);
                self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                $error_message = $e->getMessage();
                exit("Error caught from Database.php: " . $error_message);
            }
        }
        return self::$db;
    }
}