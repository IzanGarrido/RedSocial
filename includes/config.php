<?php

const MYSQL_ROOT="root";
const MYSQL_ROOT_PASSWORD="";
const MYSQL_USER="tu_usuario";
const MYSQL_PASSWORD="tu_password";

trait config {
    
    public static function connectDB()
    {
        try {
            $dsn = "mysql:host=127.0.0.1;port=3306;dbname=gameord;charset=utf8mb4";
            $conn = new PDO($dsn, MYSQL_ROOT, MYSQL_ROOT_PASSWORD, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
         } catch (PDOException $e) {
            die("Conexión fallida: " . $e->getMessage());
        }
        
        return $conn;
    }
    
    // Método para ejecutar consultas
    public static function executeQuery($sql, $params = [])
    {
        try {
            $conn = self::connectDB();
            $stmt = $conn->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            die("Error en la consulta: " . $e->getMessage());
        }
    }
    
    // Método para obtener todos los registros
    public static function getAll($sql, $params = [])
    {
        $stmt = self::executeQuery($sql, $params);
        return $stmt->fetchAll();
    }
    
    // Método para obtener un solo registro
    public static function getOne($sql, $params = [])
    {
        $stmt = self::executeQuery($sql, $params);
        return $stmt->fetch();
    }
    
    public static function insert($sql, $params = []) {
    try {
        $conn = self::connectDB();
        $stmt = $conn->prepare($sql);
        $result = $stmt->execute($params);
        $lastId = $conn->lastInsertId();
        
        // Debug info
        error_log("SQL: " . $sql);
        error_log("Execute result: " . ($result ? "true" : "false"));
        error_log("Last inserted ID: " . $lastId);
        
        return $lastId;
    } catch (PDOException $e) {
        error_log("Insert error: " . $e->getMessage());
        die("Error en la inserción: " . $e->getMessage());
    }
}

    
}

class DB {
    use config;
}
?>