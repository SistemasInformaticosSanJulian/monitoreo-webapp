<?php

declare(strict_types=1);

namespace App\Utils;

class Sqlite
{
    private \SQLite3 $connection;
    private static $database;

    private function __construct()
    {
        $config = Dotenv::load();
        $filename = $config['DB_DATABASE'];
        $flags = $config['DB_FLAGS'];
        $encryptionKey = $config['DB_ENCRYPTION_KEY'];

        $this->connection = new \SQLite3($filename, $flags, $encryptionKey);
    }

    public static function getInstance(): Sqlite
    {
        if (!self::$database instanceof self) {
            self::$database = new self();
        }

        return self::$database;
    }

    private function getConnection(): \SQLite3
    {
        return $this->connection;
    }

    private static function isConnected(): bool
    {
        return self::getInstance()->getConnection() !== null;
    }

    public function executeQuery(string $sql, array $dataColumns, bool $insertMode = false): int
    {
        if (!self::isConnected()) return 0;

        $statement = self::getInstance()->getConnection()->prepare($sql);
        if ($statement === false) return 0;

        for ($i = 0; $i < count($dataColumns); $i++) {
            $statement->bindValue($i + 1, $dataColumns[$i]);
        }

        $rows = $statement->execute();
        if ($rows === false) return 0;

        return $insertMode ?
            self::getInstance()->getConnection()->lastInsertRowID() :
            self::getInstance()->getConnection()->changes();
    }

    public static function execInsert(string $sql, array $dataColumns): int
    {
        if (!self::isConnected()) return 0;

        $statement = self::getInstance()->getConnection()->prepare($sql);
        if ($statement === false) return 0;

        for ($i = 0; $i < count($dataColumns); $i++) {
            $statement->bindValue($i + 1, $dataColumns[$i]);
        }

        $rows = $statement->execute();
        if ($rows === false) return 0;

        return self::getInstance()->getConnection()->lastInsertRowID();
    }

    public static function execUpdateOrDelete(string $sql, array $dataColumns): int
    {
        if (!self::isConnected()) return 0;

        $statement = self::getInstance()->getConnection()->prepare($sql);
        if ($statement === false) return 0;

        for ($i = 0; $i < count($dataColumns); $i++) {
            $statement->bindValue($i + 1, $dataColumns[$i]);
        }

        $rows = $statement->execute();
        if ($rows === false) return 0;

        return self::getInstance()->getConnection()->changes();
    }

    /**
     * @return array|false
     */
    public static function fetchAll(string $sql, array $columns = [], int $mode = SQLITE3_ASSOC)
    {
        if (!self::isConnected()) return [];

        $statement = self::getInstance()->getConnection()->prepare($sql);
        if ($statement === false) return [];

        for ($i = 0; $i < count($columns); $i++) {
            $statement->bindValue($i + 1, $columns[$i]);
        }

        $rows = $statement->execute();
        if ($rows === false) return false;

        $models = [];
        while ($row = $rows->fetchArray($mode)) {
            array_push($models, $row);
        }

        $rows->finalize();
        return $models;
    }

    /**
     * @return array|false
     */
    public static function fetchOne(string $sql, array $columns = [], int $mode = SQLITE3_ASSOC)
    {
        $rows = self::fetchAll($sql, $columns, $mode);
        if ($rows === false) return false;
        return count($rows) > 0 ? $rows[0] : [];
    }
}
