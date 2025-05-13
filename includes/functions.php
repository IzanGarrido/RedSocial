<?php

/**
 * @author Izan Garrido Quintana
 */
// Include the config file
require_once 'config.php';

// Function to register a new user
function registrarUsuario($nombre, $apellidos, $usuario, $correo, $password)
{
    try {
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // SQL query to insert user in table usuario 
        $sql = "INSERT INTO usuario (USUARIO, HASH_PASSWORD, NOMBRE, APELLIDOS, CORREO) VALUES (?, ?, ?, ?, ?)";
        $params = [$usuario, $hashedPassword, $nombre, $apellidos, $correo];

        // Execute the query for usuario table
        $userId = DB::insert($sql, $params);

        return $userId;
    } catch (Exception $e) {
        error_log("Error en registrar Usuario: " . $e->getMessage());
        return 0;
    }
}

// Function to check the name of the register form
function comprobarNombre($nombre)
{
    // Remove spaces
    $nombre = trim($nombre);

    // Check if empty
    if (empty($nombre)) {
        return "El nombre es obligatorio.";
    }

    // Check if the name only contains letters and spaces
    if (!preg_match("/^[a-zA-Z]*$/", $nombre)) {
        return "El nombre solo puede contener letras.";
    }

    return true;
}

// Function to check the last name of the register form
function comprobarApellidos($apellidos)
{
    // Remove spaces
    $apellidos = trim($apellidos);

    // Check if empty
    if (empty($apellidos)) {
        return "Los apellidos son obligatorios.";
    }

    // Check if the lastname only contains letters and spaces
    if (!preg_match("/^[a-zA-Z ]*$/", $apellidos)) {
        return "Los apellidos solo pueden contener letras y espacios.";
    }

    return true;
}

// Function to check the username of the register form
function comprobarUsername($username)
{
    // Check if empty
    if (empty($username)) {
        return "El nombre de usuario es obligatorio.";
    }

    // Check username format (alphanumeric and underscore only)
    if (!preg_match("/^[a-zA-Z0-9_]*$/", $username)) {
        return "El nombre de usuario solo puede contener letras, números y guiones bajos.";
    }

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
        error_log("Error al comprobar el nombre de usuario: " . $e->getMessage());
        return "Error al verificar el nombre de usuario.";
    }

    return true;
}

// Function to check the email of the register form
function comprobarEmail($email)
{
    // Check if empty
    if (empty($email)) {
        return "El correo electrónico es obligatorio.";
    }

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return "El formato del correo electrónico no es válido.";
    }

    try {
        // SQL query to check if the email already exists
        $sql = "SELECT CORREO FROM usuario WHERE CORREO = ?";
        $params = [$email];
        $query = DB::executeQuery($sql, $params);

        // Check if the email already exists
        if ($query->rowCount() > 0) {
            return "El correo ya existe.";
        }
    } catch (Exception $e) {
        error_log("Error en comprobarEmail: " . $e->getMessage());
        return "Error al verificar el correo electrónico.";
    }

    return true;
}

// Function to check the password of the register form
function comprobarContrasena($password, $confirmPassword)
{
    // Array to store errors
    $errores = [];

    // Check if the password is empty
    if (empty($password)) {
        $errores[] = "La contraseña es obligatoria";
        return [
            'valido' => false,
            'errores' => $errores
        ];
    }

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

    return [
        'valido' => empty($errores),
        'errores' => $errores
    ];
}

// Function to create the user directory
function creardirectoriobase($username)
{
    $directorio = "../assets/users/$username";
    if (!file_exists($directorio)) {
        mkdir($directorio, 0777, true);
    }
}

// Function to check the login
function comprobarlogin($username, $password)
{
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

// Function to validate login form data
function validarFormularioLogin($username, $password)
{
    $errores = [];

    // Validate username
    if (empty($username)) {
        $errores['username'] = "El nombre de usuario es obligatorio";
    }

    // Validate password
    if (empty($password)) {
        $errores['password'] = "La contraseña es obligatoria";
    }

    // If there are no validation errors, check credentials
    if (empty($errores)) {
        if (!comprobarlogin($username, $password)) {
            $errores['credenciales'] = "Usuario o contraseña incorrectos";
        }
    }

    return [
        'valido' => empty($errores),
        'errores' => $errores
    ];
}

// Function to get a user by ID
function obtenerUsuarioPorId($userId)
{
    try {
        $sql = "SELECT u.IDUSUARIO, u.USUARIO, ui.NOMBRE, ui.APELLIDOS, ui.CORREO 
                FROM usuari 
                WHERE IDUSUARIO = ?";
        $user = DB::getOne($sql, [$userId]);
        return $user;
    } catch (Exception $e) {
        error_log("Error en obtenerUsuarioPorId: " . $e->getMessage());
        return null;
    }
}

// Function to get a user by username
function obtenerUsuarioPorUsername($username)
{
    try {
        $sql = "SELECT u.IDUSUARIO FROM usuario u WHERE u.USUARIO = ?";
        $user = DB::getOne($sql, [$username]);
        return $user ? $user['IDUSUARIO'] : null;
    } catch (Exception $e) {
        error_log("Error en obtenerUsuarioPorUsername: " . $e->getMessage());
        return null;
    }
}

// Function to get all the categories from index page
function obtenerCategorias()
{
    $categorias = DB::getAll("SELECT ID_CATEGORIA, CATEGORIA FROM categorias ORDER BY CATEGORIA ASC");
    return $categorias;
}

// Function to get all the games
function obtenerJuegos()
{
    $juegos = DB::getAll("SELECT IDJUEGO, JUEGO, URL_IMAGEN FROM juegos ORDER BY JUEGO ASC");
    return $juegos;
}

// Function to create a new post and save it in the database
function crearPublicacion($userId, $contenido, $archivo = null, $gameId = null)
{
    try {
        $url = null;

        // If there is a file, process it
        if ($archivo && !empty($archivo['name'])) {
            // SQL query to get the username by user ID
            $sql = "SELECT USUARIO FROM usuario WHERE IDUSUARIO = ?";
            $usuario = DB::getOne($sql, [$userId]);

            // Check if the user exists
            if (!$usuario) {
                error_log("Error: No se encontró el usuario con ID $userId");
                return false;
            }

            // Get the username
            $username = $usuario['USUARIO'];

            // Create the user directory if it doesn't exist
            $userDir = "../assets/users/{$username}";
            $postsDir = "{$userDir}/posts";

            if (!file_exists($userDir)) {
                mkdir($userDir, 0777, true);
            }
            if (!file_exists($postsDir)) {
                mkdir($postsDir, 0777, true);
            }

            // Generate a unique name for the file using timestamp
            $timestamp = time();
            $fileExtension = pathinfo($archivo['name'], PATHINFO_EXTENSION);
            $fileName = "{$timestamp}.{$fileExtension}";
            $filePath = "{$postsDir}/{$fileName}";

            // Relative path for saving in the database
            $url = "./assets/users/{$username}/posts/{$fileName}";

            // Move the uploaded file to the destination
            if (!move_uploaded_file($archivo['tmp_name'], $filePath)) {
                error_log("Error: No se pudo mover el archivo subido a $filePath");
                return false;
            }
        }

        // Insert the post in the database
        $sql = "INSERT INTO PUBLICACIONES_USUARIOS (IDUSUARIO, URL, CONTENIDO, IDJUEGO) VALUES (?, ?, ?, ?)";
        $params = [$userId, $url, $contenido, $gameId];

        // Execute the query and get the ID
        $postId = DB::insert($sql, $params);

        return $postId;
    } catch (Exception $e) {
        error_log("Error al crear publicación: " . $e->getMessage());
        return false;
    }
}
