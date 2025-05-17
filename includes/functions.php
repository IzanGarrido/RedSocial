<?php

/**
 * @author Izan Garrido Quintana
 */
// Include the config file
require_once 'config.php';



// Function to get the base path of the application
function obtenerRutaBase($tipo = 'absoluta') 
{
    switch ($tipo) {
        case 'absoluta':

            return realpath(dirname(__FILE__) . '/..') . '/';
            
        case 'relativa':
            $directorioActual = dirname($_SERVER['PHP_SELF']);
            
            if (strpos($directorioActual, '/includes') !== false) {
                return '..';
            } elseif (strpos($directorioActual, '/pages') !== false) {
                return '..';
            }
            
            return '.';
            
        default:
            return realpath(dirname(__FILE__) . '/..') . '/';
    }
}

// Function to register a new user
function registrarUsuario($nombre, $apellidos, $usuario, $correo, $password)
{
    try {
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // SQL query to insert user in table usuario 
        $sql = "INSERT INTO USUARIO (USUARIO, HASH_PASSWORD, NOMBRE, APELLIDOS, CORREO) VALUES (?, ?, ?, ?, ?)";
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
        $sql = "SELECT USUARIO FROM USUARIO WHERE USUARIO = ?";
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
        $sql = "SELECT CORREO FROM USUARIO WHERE CORREO = ?";
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
    $rutaBase = obtenerRutaBase('absoluta');
    $directorio = $rutaBase . "assets/users/$username";
    
    if (!file_exists($directorio)) {
        mkdir($directorio, 0777, true);
        
        // Crear también el directorio para posts
        $postsDir = "$directorio/posts";
        if (!file_exists($postsDir)) {
            mkdir($postsDir, 0777, true);
        }
    }
    
    // Add default profile image
    $defaultProfileImage = $rutaBase . "assets/App-images/default_profile.png";
    $profileImagePath = "$directorio/profile.png";
    
    if (!file_exists($profileImagePath)) {
        copy($defaultProfileImage, $profileImagePath);
    }

    // URL relativa para la base de datos
    $urlRelativa = "./assets/users/$username/profile.png";
    
    // Add the url to the database
    $sql = "UPDATE USUARIO SET URL_FOTO = ? WHERE USUARIO = ?";
    $params = [$urlRelativa, $username];
    DB::executeQuery($sql, $params);
}

// Function to get the user profile image
function getProfileImage($username)
{
    $rutaRelativa = obtenerRutaBase('relativa');
    $profileImagePath = "$rutaRelativa/assets/users/$username/profile.png";
    
    // Comprobar si existe la imagen
    $rutaAbsoluta = obtenerRutaBase('absoluta') . "assets/users/$username/profile.png";
    
    if (!file_exists($rutaAbsoluta)) {
        // Si no existe, devolver la imagen por defecto
        return "$rutaRelativa/assets/img/default_profile.png";
    }
    
    return $profileImagePath;
}

// Function to check the login
function comprobarlogin($username, $password)
{
    try {
        // SQL query to fetch the user data by username only
        $sql = "SELECT USUARIO, HASH_PASSWORD FROM USUARIO WHERE USUARIO = ?";
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
        $sql = "SELECT IDUSUARIO, USUARIO, NOMBRE, APELLIDOS, CORREO 
                FROM USUARIO 
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
        $sql = "SELECT IDUSUARIO FROM USUARIO WHERE USUARIO = ?";
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
    $categorias = DB::getAll("SELECT ID_CATEGORIA, CATEGORIA FROM CATEGORIAS ORDER BY CATEGORIA ASC");
    return $categorias;
}

// Function to get all the games
function obtenerJuegos()
{
    $juegos = DB::getAll("SELECT IDJUEGO, JUEGO, URL_IMAGEN FROM JUEGOS ORDER BY JUEGO ASC");
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
            $sql = "SELECT USUARIO FROM USUARIO WHERE IDUSUARIO = ?";
            $usuario = DB::getOne($sql, [$userId]);

            // Check if the user exists
            if (!$usuario) {
                error_log("Error: No se encontró el usuario con ID $userId");
                return false;
            }

            // Get the username
            $username = $usuario['USUARIO'];

            // Obtener rutas usando la nueva función
            $rutaBase = obtenerRutaBase('absoluta');
            $userDir = $rutaBase . "assets/users/{$username}";
            $postsDir = "{$userDir}/posts";
            
            // Asegurar que los directorios existan
            if (!file_exists($userDir)) {
                if (!mkdir($userDir, 0777, true)) {
                    error_log("Error: No se pudo crear el directorio $userDir");
                    return false;
                }
            }
            
            if (!file_exists($postsDir)) {
                if (!mkdir($postsDir, 0777, true)) {
                    error_log("Error: No se pudo crear el directorio $postsDir");
                    return false;
                }
            }

            // Generate a unique name for the file using timestamp
            $timestamp = time();
            $fileExtension = pathinfo($archivo['name'], PATHINFO_EXTENSION);
            $fileName = "{$timestamp}.{$fileExtension}";
            $filePath = "{$postsDir}/{$fileName}";

            // Ruta relativa para guardar en la base de datos
            // Usamos un formato consistente para URLs
            $url = "./assets/users/{$username}/posts/{$fileName}";

            // Añadimos logs para depuración
            error_log("Intentando mover archivo desde: " . $archivo['tmp_name']);
            error_log("Hacia: " . $filePath);

            // Move the uploaded file to the destination
            if (!move_uploaded_file($archivo['tmp_name'], $filePath)) {
                error_log("Error: No se pudo mover el archivo subido a $filePath");
                error_log("Error de PHP: " . error_get_last()['message']);
                return false;
            }
            
            error_log("Archivo movido correctamente a: " . $filePath);
        }

        // Insert the post in the database
        $sql = "INSERT INTO PUBLICACIONES_USUARIOS (IDUSUARIO, URL, CONTENIDO, IDJUEGO) VALUES (?, ?, ?, ?)";
        $params = [$userId, $url, $contenido, $gameId];

        // Execute the query and get the ID
        $postId = DB::insert($sql, $params);
        
        if ($postId) {
            error_log("Publicación creada con éxito, ID: " . $postId);
        } else {
            error_log("Error al insertar en la base de datos");
        }

        return $postId;
    } catch (Exception $e) {
        error_log("Error al crear publicación: " . $e->getMessage());
        error_log("Traza: " . $e->getTraceAsString());
        return false;
    }
}

// Function to get all posts from the database
function obtenerPublicaciones()
{
    try {
        // SQL query to get all posts from the database
        $sql = "SELECT p.ID_PUBLICACION, p.CONTENIDO, p.URL, p.FECHA_CREACION, 
                 u.USUARIO, u.URL_FOTO AS USER_PHOTO,
                 j.JUEGO, j.URL_IMAGEN AS GAME_IMAGE,
                 (SELECT COUNT(*) FROM INTERACCIONES WHERE ID_PUBLICACION = p.ID_PUBLICACION AND TIPO = 'like') AS LIKES_COUNT,
                 (SELECT COUNT(*) FROM COMENTARIOS WHERE ID_PUBLICACION = p.ID_PUBLICACION) AS COMMENTS_COUNT
          FROM PUBLICACIONES_USUARIOS p
          JOIN USUARIO u ON p.IDUSUARIO = u.IDUSUARIO
          LEFT JOIN JUEGOS j ON p.IDJUEGO = j.IDJUEGO
          ORDER BY p.FECHA_CREACION DESC
          LIMIT 10";
        $posts = DB::getAll($sql);

        return $posts;
    } catch (Exception $e) {
        error_log("Error al obtener publicaciones: " . $e->getMessage());
        return [];
    }
}
