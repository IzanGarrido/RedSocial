<?php
// Incluir el archivo que contiene el trait
require_once 'config.php';

// Clase de ejemplo que utiliza el trait
class Database {
    // Usar el trait en la clase
    use config;
    
    // Puedes añadir más métodos específicos aquí
}

// Ejemplo de uso
try {
    // Prueba de conexión
    echo "<h2>Probando la conexión a la base de datos</h2>";
    $conn = Database::connectDB();
    echo "<p>Conexión exitosa a la base de datos</p>";
    
    $reactions = Database::getAll("SELECT REACCION, EMOJI FROM reacciones LIMIT 10");
    
    if (count($reactions) > 0) {
        echo "<ul>";
        foreach ($reactions as $reaction) {
            echo "<li>ID: " . $reaction["REACCION"] . " - Emoji: " . $reaction["EMOJI"] . "</li>";
        }
        echo "</ul>";
    }
    
} catch (Exception $e) {
    echo "<p>Error: " . $e->getMessage() . "</p>";
}
?>