<?php

class Database {
    private static ?Database $instance = null;
    private ?PDO $connection = null;
    private string $host;
    private string $db_name;
    private string $username;
    private string $password;

    private function __construct() { // Construtor privado para evitar múltiplas instâncias
          $this->host = getenv('DB_HOST') ?: 'localhost';
        $this->db_name = getenv('DB_NAME') ?: 'banco';
        $this->username = getenv('DB_USER') ?: 'usuario';
        $this->password = getenv('DB_PASSWORD') ?: 'senha';

        try {
            $this->connection = new PDO(
                "mysql:host={$this->host};dbname={$this->db_name}",
                $this->username,
                $this->password
            );
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            die("Erro de conexão: " . $exception->getMessage());
        }
    }

    public static function getInstance(): Database {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection(): PDO {
        return $this->connection;
    }
}

?>

