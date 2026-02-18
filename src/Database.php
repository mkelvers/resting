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
}
