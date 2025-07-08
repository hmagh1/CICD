<?php
require_once __DIR__ . '/Database.php';

class User {
    public static function create(string $name, string $email): bool {
        $pdo = Database::connect();
        $stmt = $pdo->prepare("INSERT INTO users (name, email) VALUES (?, ?)");
        return $stmt->execute([$name, $email]);
    }

    public static function all(): array {
        $pdo = Database::connect();
        $stmt = $pdo->query("SELECT * FROM users");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function deleteAll(): void {
        $pdo = Database::connect();
        $pdo->exec("DELETE FROM users");
    }
    // src/User.php
public static function unusedMethod() {
    return "I am not covered";
}

}
