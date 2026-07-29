<?php
namespace App\Core;

use PDO;
use PDOException;
use Throwable;

/**
 * Enterprise PDO Database Singleton Layer with Prepared Statements & Exception Resiliency
 */
class Database
{
    private static ?PDO $instance = null;

    public static function getInstance(): ?PDO
    {
        if (self::$instance === null) {
            try {
                $dsn = sprintf(
                    "mysql:host=%s;port=%s;dbname=%s;charset=%s",
                    DB_HOST,
                    DB_PORT,
                    DB_NAME,
                    DB_CHARSET
                );

                $options = [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => true,
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES " . DB_CHARSET
                ];

                self::$instance = new PDO($dsn, DB_USER, DB_PASS, $options);
            } catch (Throwable $e) {
                error_log("Database Connection Warning: " . $e->getMessage());
                return null;
            }
        }

        return self::$instance;
    }

    public static function query(string $sql, array $params = []): ?\PDOStatement
    {
        try {
            $pdo = self::getInstance();
            if (!$pdo) return null;
            $stmt = $pdo->prepare($sql);
            if (!$stmt) return null;
            $stmt->execute($params);
            return $stmt;
        } catch (Throwable $e) {
            error_log("Database Query Error: [" . $sql . "] — " . $e->getMessage());
            return null;
        }
    }

    public static function fetchAll(string $sql, array $params = []): array
    {
        try {
            $stmt = self::query($sql, $params);
            if (!$stmt) return [];
            return $stmt->fetchAll() ?: [];
        } catch (Throwable $e) {
            error_log("Database fetchAll Error: " . $e->getMessage());
            return [];
        }
    }

    public static function fetchOne(string $sql, array $params = []): ?array
    {
        try {
            $stmt = self::query($sql, $params);
            if (!$stmt) return null;
            $result = $stmt->fetch();
            return $result ?: null;
        } catch (Throwable $e) {
            error_log("Database fetchOne Error: " . $e->getMessage());
            return null;
        }
    }

    public static function insert(string $table, array $data): int
    {
        try {
            $keys = array_keys($data);
            $fields = implode(', ', array_map(fn($k) => "`$k`", $keys));
            $placeholders = implode(', ', array_map(fn($k) => ":$k", $keys));

            $sql = "INSERT INTO `$table` ($fields) VALUES ($placeholders)";
            $stmt = self::query($sql, $data);
            if (!$stmt) return 0;

            $pdo = self::getInstance();
            return $pdo ? (int) $pdo->lastInsertId() : 0;
        } catch (Throwable $e) {
            error_log("Database Insert Error: " . $e->getMessage());
            return 0;
        }
    }

    public static function update(string $table, array $data, string $where, array $whereParams = []): int
    {
        try {
            $fields = implode(', ', array_map(fn($k) => "`$k` = :val_$k", array_keys($data)));
            $sql = "UPDATE `$table` SET $fields WHERE $where";

            $params = [];
            foreach ($data as $key => $val) {
                $params["val_$key"] = $val;
            }
            $params = array_merge($params, $whereParams);

            $stmt = self::query($sql, $params);
            return $stmt ? $stmt->rowCount() : 0;
        } catch (Throwable $e) {
            error_log("Database Update Error: " . $e->getMessage());
            return 0;
        }
    }

    public static function delete(string $table, string $where, array $params = []): int
    {
        try {
            $sql = "DELETE FROM `$table` WHERE $where";
            $stmt = self::query($sql, $params);
            return $stmt ? $stmt->rowCount() : 0;
        } catch (Throwable $e) {
            error_log("Database Delete Error: " . $e->getMessage());
            return 0;
        }
    }

    public static function beginTransaction(): void
    {
        try {
            $pdo = self::getInstance();
            if ($pdo) $pdo->beginTransaction();
        } catch (Throwable $e) {}
    }

    public static function commit(): void
    {
        try {
            $pdo = self::getInstance();
            if ($pdo && $pdo->inTransaction()) $pdo->commit();
        } catch (Throwable $e) {}
    }

    public static function rollBack(): void
    {
        try {
            $pdo = self::getInstance();
            if ($pdo && $pdo->inTransaction()) $pdo->rollBack();
        } catch (Throwable $e) {}
    }
}
