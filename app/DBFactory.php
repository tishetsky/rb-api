<?php


namespace App;


class DBFactory
{
    static $db;

    public static function getDbInstance()
    {
        global $config;

        if (!self::$db instanceof \PDO) {
            ['dsn' => $dsn, 'user' => $user, 'pass' => $pass] = $config['db'];

            self::$db = new \PDO($dsn, $user, $pass);
        }

        return self::$db;
    }
}
