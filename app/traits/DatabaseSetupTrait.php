<?php

namespace App\Traits;

use PDO;
use PDOException;
use App\Core\Database;

trait DatabaseSetupTrait
{
    public function testConnection(): bool
    {
        try {
            $db = Database::getInstance();
            $db->query("SELECT 1");
            echo "✅ Conexão bem-sucedida.\n";
            return true;
        } catch (PDOException $e) {
            echo "❌ Erro na conexão: " . $e->getMessage() . "\n";
            return false;
        }
    }

    public function installDatabase(): void
    {
        if (!$this->testConnection()) {
            echo "🛑 Abandonando instalação por falha de conexão.\n";
            return;
        }

        $db = Database::getInstance();

        $sql = file_get_contents(__DIR__."/../storage/schemas.sql");

        try {
            $db->exec($sql);
            echo "✅ Banco de dados instalado com sucesso.\n";
        } catch (PDOException $e) {
            echo "❌ Erro ao instalar banco: " . $e->getMessage() . "\n";
        }
    }
}
