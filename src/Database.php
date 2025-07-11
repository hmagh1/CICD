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

            // Tentatives de connexion pendant 10 secondes max
            for ($i = 0; $i < 10; $i++) {
                try {
                    self::$pdo = new PDO($dsn, $user, $pass);
                    break;
                } catch (PDOException $e) {
                    echo "Waiting for database... attempt {$i}\n";
                    sleep(1);
                }
            }

            // Si toujours pas connecté, lancer une exception normale
            if (!self::$pdo) {
                self::$pdo = new PDO($dsn, $user, $pass);
            }
        }
        return self::$pdo;
    }
}
