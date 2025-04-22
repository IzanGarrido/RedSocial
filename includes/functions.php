<?php
// Include the config file
require_once 'config.php';

// Function to register a new user
function registrarUsuario($nombre, $apellidos, $usuario, $correo, $password, $confirmarPassword) {
    try {
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // SQL query to insert user in table usuario 
        $sql = "INSERT INTO usuario (USUARIO, HASH_PASSWORD) VALUES (?, ?)";
        $params = [$usuario, $hashedPassword];

        // Execute the query for usuario table
        $userId = DB::insert($sql, $params);

        // SQL query to insert user in table usuarios_info
        $sql = "INSERT INTO usuarios_info (IDUSUARIO, NOMBRE, APELLIDOS, CORREO) VALUES (?, ?, ?, ?)";
        $params = [$userId, $nombre, $apellidos, $correo];

        // Execute the query for usuarios_info table
        DB::insert($sql, $params);

        return $userId;
    } catch (Exception $e) {
        error_log("Error en registrar Usuario: " . $e->getMessage());
        return 0;
    }
}
// Function to check the name of the register form
function comprobarNombre($nombre) {
    
    $nombre = trim($nombre); // Remove spaces

    // Check if the name only contains letters and spaces
    if (!preg_match("/^[a-zA-Z ]*$/", $nombre)) {
        return "El nombre solo puede contener letras y espacios.";
    }
    echo "Nombre correcto";
    return true;

}

// Function to check the last name of the register form
function comprobarApellidos($apellidos) {
    echo "Entrando";

    $apellidos = trim($apellidos); // Remove spaces

    // Check if the lastname only contains letters and spaces
    if (!preg_match("/^[a-zA-Z ]*$/", $apellidos)) {
        return "El Apellido solo puede contener letras y espacios.";
    }
    echo "Apellido correcto";
    return true;

}

// Function to check the username of the register form
function comprobarUsername($username) {
    try {
        // SQL query to check if the username already exists
        $sql = "SELECT USUARIO FROM usuario WHERE USUARIO = ?";
        $params = [$username];
        $query = DB::executeQuery($sql, $params);

        // Check if the username already exists
        if ($query->rowCount() > 0) {
            return "El nombre de usuario ya existe.";
        }
    } catch (Exception $e) {
        error_log("Error en comprobarUsername: " . $e->getMessage());      
    }
    echo "Username correcto";
    return true;

}

// Function to check the email of the register form
function comprobarEmail($email) {
    try {
        // SQL query to check if the email already exists
        $sql = "SELECT CORREO FROM usuarios_info WHERE CORREO = ?";
        $params = [$email];
        $query = DB::executeQuery($sql, $params);

        // Check if the email already exists
        if ($query->rowCount() > 0) {
            return "El correo ya existe.";
        }
    } catch (Exception $e) {
        error_log("Error en comprobarEmail: " . $e->getMessage());      
    }
    echo "Email correcto";
    return true;

}

// Function to check the password of the register form
function comprobarContrasena($password, $confirmPassword) {
    // Array to store errors
    $errores = [];
    
    // Check if the password is at least 8 characters
    if (strlen($password) < 8) {
        $errores[] = "La contraseña debe tener al menos 8 caracteres";
    }
    
    // Check if the password contains at least one lowercase letter
    if (!preg_match('/[a-z]/', $password)) {
        $errores[] = "La contraseña debe incluir al menos una letra minúscula";
    }
    
    // Check if the password contains at least one uppercase letter
    if (!preg_match('/[A-Z]/', $password)) {
        $errores[] = "La contraseña debe incluir al menos una letra mayúscula";
    }
    
    // Check if the password contains at least one number
    if (!preg_match('/[0-9]/', $password)) {
        $errores[] = "La contraseña debe incluir al menos un número";
    }
    
    // Check if the password contains at least one special character
    if (!preg_match('/[!@#$%^&*()_+\-=\[\]{};\':"\\|,.<>\/?]/', $password)) {
        $errores[] = "La contraseña debe incluir al menos un carácter especial";
    }
        
    // Check if the password and confirm password match
    if ($password !== $confirmPassword) {
        $errores[] = "Las contraseñas no coinciden";
    }
    echo "Contraseña correcta";
    return [
        'valido' => empty($errores),
        'errores' => $errores
    ];

}

// Function to check the login
function comprobarlogin($username, $password) {
    try {
        // SQL query to fetch the user data by username only
        $sql = "SELECT USUARIO, HASH_PASSWORD FROM usuario WHERE USUARIO = ?";
        $params = [$username];
        $query = DB::executeQuery($sql, $params);

        // Check if the user exists
        if ($query->rowCount() > 0) {
            // Fetch the user data from the database and store it in a variable
            $user = $query->fetch(PDO::FETCH_ASSOC); // PDO::FETCH_ASSOC returns an array with column names as keys
            $hashedPassword = $user['HASH_PASSWORD'];
            
            // Verify the password against the stored hash
            if (password_verify($password, $hashedPassword)) {
                return true;
            }
        }
    } catch (Exception $e) {
        error_log("Error en comprobarlogin: " . $e->getMessage());      
    }
    return false;
}

?>