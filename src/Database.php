<?php
class Database {
    private static $pdo;

    public static function connect() {
        if (!self::$pdo) {
            $host = 'db';
            $db = 'test';
            $user = 'root';
            $pass = 'root';
            $dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";
            self::$pdo = new PDO($dsn, $user, $pass);
        }
        return self::$pdo;
    }
}
