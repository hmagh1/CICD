<?php
class Database {
    private static $pdo;

    public static function connect() {
        if (!self::$pdo) {
            $host = getenv('DB_HOST') ?: 'db';
            $db   = getenv('DB_NAME') ?: 'test';
            $user = getenv('DB_USER') ?: 'root';
            $pass = getenv('DB_PASS') ?: 'root';
            $dsn  = "mysql:host=$host;dbname=$db;charset=utf8mb4";

            for ($i = 0; $i < 10; $i++) {
                try {
                    self::$pdo = new PDO($dsn, $user, $pass);
                    return self::$pdo;
                } catch (PDOException $e) {
                    echo "Waiting for database... attempt {$i}\n";
                    sleep(1);
                }
            }

            throw new PDOException("Database connection failed after 10 attempts.");
        }

        return self::$pdo;
    }
}
