<?php 
namespace Code\Database;

class Connection
{
    static private $instance = null;

    private function __construct(){}

    static public function getInstance()
    {
        if(!self::$instance) {
            $dsn = 'mysql:dbname=' . DB_NAME . ';host=' . DB_HOST;

            self::$instance = new \PDO($dsn, DB_USER, DB_PASSWORD);
            self::$instance->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            self::$instance->exec('SET NAMES UTF8;');
        }

        return self::$instance;
    }
}