<?php
/**
 * @author Izan Garrido Quintana
 */

// Config for the database
const MYSQL_ROOT="root";
const MYSQL_ROOT_PASSWORD="";
const MYSQL_USER="tu_usuario";
const MYSQL_PASSWORD="tu_password";

// Trait 
trait config {
    
    // Method to connect to the database
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
    
    // Method to execute a query
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
    
    // Method to get all records
    public static function getAll($sql, $params = [])
    {
        $stmt = self::executeQuery($sql, $params);
        return $stmt->fetchAll();
    }
    
    // Method to get one record
    public static function getOne($sql, $params = [])
    {
        $stmt = self::executeQuery($sql, $params);
        return $stmt->fetch();
    }
    
    // Method to insert a record
    public static function insert($sql, $params = []) {
    try {
        $conn = self::connectDB();
        $stmt = $conn->prepare($sql);
        $result = $stmt->execute($params);
        $lastId = $conn->lastInsertId();
            
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