<?php

namespace App\Core;

use App\Core\Config;

class Database {
    public function connect()
    {
        $host = Config::DB_SERVER;
        $dbname = Config::DB_NAME;

        $connection = new \PDO("mysql:host=$host;dbname=$dbname;charset=UTF8", Config::DB_USER, Config::DB_PASSWORD);

        return $connection;
    }
}