<?php

declare(strict_types=1);

namespace App;

use PDO;
use PDOStatement;

class Database
{
  private static ?PDO $pdo = null;
  private static ?self $instance = null;

  public static function instance(): self
  {
    return self::$instance ??= new self();
  }

  public function query(string $sql, array $params = []): PDOStatement
  {
    $stmt = self::pdo()->prepare($sql);
    $stmt->execute($params);
    return $stmt;
  }

  public function lastInsertId(): string
  {
    return (string)self::pdo()->lastInsertId();
  }

  public static function pdo(): PDO
  {
    if (self::$pdo !== null) {
      return self::$pdo;
    }

    $config = [];
    foreach (['host', 'port', 'name', 'user', 'password'] as $key) {
      $envKey = 'DB_'.strtoupper($key);
      if (!isset($_ENV[$envKey])) {
        throw new \Exception("missing db environment variable: {$envKey}");
      }
      $config[$key] = $_ENV[$envKey];
    }

    self::$pdo = new PDO(
      sprintf(
        'mysql:host=%s;port=%d;dbname=%s;charset=utf8mb4',
        $config['host'],
        (int) $config['port'],
        $config['name']
      ),
      $config['user'],
      $config['password'],
      [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
      ]
    );

    return self::$pdo;
  }

  // Fetch related records from a table based on a foreign key
  public function related(string $table, string $foreignKey, mixed $id, string $columns = '*'): array
  {
    return $this->query("SELECT $columns FROM $table WHERE $foreignKey = :id", ['id' => $id])->fetchAll();
  }
}
