<?php
class Database {
    private static $pdo;

    public static function connect() {
        if (!self::$pdo) {
            // Lire les variables d'environnement ou utiliser des valeurs par défaut
            $host = getenv('DB_HOST') ?: 'localhost';
            $db   = getenv('DB_NAME') ?: 'test';
            $user = getenv('DB_USER') ?: 'root';
            $pass = getenv('DB_PASS') ?: 'root';

            $dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";

            // Tentatives de connexion avec délai progressif
            for ($i = 0; $i < 10; $i++) {
                try {
                    self::$pdo = new PDO($dsn, $user, $pass, [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::ATTR_EMULATE_PREPARES => false,
                    ]);
                    break;
                } catch (PDOException $e) {
                    error_log("Waiting for database... attempt {$i}");
                    sleep(1);
                }
            }

            // Dernière tentative ou lancer une exception si échec
            if (!self::$pdo) {
                throw new PDOException("Database connection failed after 10 attempts.");
            }
        }

        return self::$pdo;
    }
}
