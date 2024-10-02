<?php
declare(strict_types=1);

namespace Config;

require_once './config/config.php';

use PDO;

class Database {
    private static ?PDO $pdo = null;

    /**
     * Récupération de la connexion à la base de données
     * @return PDO
     */
    public static function db() : PDO
    {
        if (self::$pdo == null) {
            self::$pdo = self::connection();
        }
        return self::$pdo;
    }

    /**
     * Connexion à la base de données
     * @return PDO
     */
    private static function connection() : PDO
    {
        try {
            $db = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $db;
        }
        catch (\PDOException $e) {
            echo $e->getMessage();
            die();
        }
    }
}
