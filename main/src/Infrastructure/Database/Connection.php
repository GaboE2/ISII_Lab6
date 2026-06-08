<?php

namespace Farmacia\Infrastructure\Database;

class Connection
{
    private static ?\mysqli $instance = null;
    private string $host;
    private string $user;
    private string $password;
    private string $database;
    private int $port;

    private function __construct(
        string $host,
        string $user,
        string $password,
        string $database,
        int $port
    ) {
        $this->host = $host;
        $this->user = $user;
        $this->password = $password;
        $this->database = $database;
        $this->port = $port;
    }

    public static function getInstance(
        string $host = "localhost",
        string $user = "root",
        string $password = "",
        string $database = "login_db",
        int $port = 3310
    ): \mysqli {
        if (self::$instance === null) {
            $connection = new self($host, $user, $password, $database, $port);
            self::$instance = $connection->connect();
        }
        return self::$instance;
    }

    private function connect(): \mysqli
    {
        $conn = new \mysqli($this->host, $this->user, $this->password, $this->database, $this->port);

        if ($conn->connect_error) {
            throw new \Exception("Conexión fallida: " . $conn->connect_error);
        }

        $conn->set_charset("utf8");
        return $conn;
    }

    public static function closeConnection(): void
    {
        if (self::$instance !== null) {
            self::$instance->close();
            self::$instance = null;
        }
    }
}
