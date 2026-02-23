<?php

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

  public static function pdo(): PDO
  {
    if (self::$pdo !== null) {
      return self::$pdo;
    }

    $config = [];
    foreach (['host', 'port', 'name', 'user', 'password'] as $key) {
      $config[$key] = $_ENV['DB_'.strtoupper($key)] ?? '';
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

  /**
   * Fetch related records from a table based on a foreign key.
   * 
   * @param string $table The name of the related table.
   * @param string $foreignKey The name of the foreign key column in the related table.
   * @param mixed $id The value of the foreign key to match.
   * @param string $columns The columns to select (default is '*').
   * 
   * @return array An array of related records.
   */
  public function related(string $table, string $foreignKey, mixed $id, string $columns = '*'): array
  {
    return $this->query("SELECT $columns FROM $table WHERE $foreignKey = :id", ['id' => $id])->fetchAll();
  }
}
