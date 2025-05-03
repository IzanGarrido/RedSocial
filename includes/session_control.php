<?php
// Archivo para control de sesiones

// Configuración para que la sesión PHP persista más tiempo
// Esto hace que la sesión PHP dure 30 días en lugar del tiempo predeterminado
ini_set('session.gc_maxlifetime', 2592000); // 30 días en segundos
ini_set('session.cookie_lifetime', 2592000); // 30 días para la cookie de sesión PHP

// Iniciar o reanudar la sesión
session_start();

// Función para verificar si hay una sesión activa
function checkSession() {
    // Si no existe la sesión o no está autenticado, redirigir al login
    if (!isset($_SESSION['user_id'])) {
        // Verificar si existe una cookie de "recordarme"
        if (isset($_COOKIE['remember_token'])) {
            // Intentar autenticar con la cookie
            if (authenticateWithCookie()) {
                // Si la autenticación fue exitosa, continuar
                return true;
            }
        }
        
        // Guardar la URL actual para volver después del login
        $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
        
        // Redirigir al login
        header('Location: ' . getBasePath() . 'pages/login.php');
        exit;
    }
    
    // Opcional: Actualizar la hora de último acceso
    $_SESSION['last_activity'] = time();
    
    // Opcional: Verificar tiempo de inactividad (aumentado a 7 días para mayor comodidad)
    if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 604800)) {
        // Si han pasado más de 7 días de inactividad, destruir la sesión
        logoutUser();
        header('Location: ' . getBasePath() . 'pages/login.php');
        exit;
    }
    
    // Si todo está bien, el script continúa normalmente
    return true;
}

// Función para autenticar con cookie
function authenticateWithCookie() {
    // Obtener el token de la cookie
    $token = $_COOKIE['remember_token'];
    
    // Incluir el archivo de funciones si no está incluido
    if (!function_exists('DB::getOne')) {
        require_once 'config.php';
    }
    
    try {
        // Buscar el usuario con ese token
        $sql = "SELECT u.IDUSUARIO, u.USUARIO, ui.NOMBRE, ui.APELLIDOS, ui.CORREO 
                FROM usuario u 
                JOIN usuarios_info ui ON u.IDUSUARIO = ui.IDUSUARIO 
                WHERE u.REMEMBER_TOKEN = ? AND u.TOKEN_EXPIRY > NOW()";
        $user = DB::getOne($sql, [$token]);
        
        if ($user) {
            // Crear la sesión para el usuario
            $_SESSION['user_id'] = $user['IDUSUARIO'];
            $_SESSION['username'] = $user['USUARIO'];
            $_SESSION['user_name'] = $user['NOMBRE'];
            $_SESSION['user_lastname'] = $user['APELLIDOS'];
            $_SESSION['user_email'] = $user['CORREO'];
            $_SESSION['last_activity'] = time();
            
            // Generar un nuevo token y actualizar en la BD (seguridad adicional)
            $new_token = bin2hex(random_bytes(32));
            // Extiende la expiración a 90 días para mayor duración
            $expiry = date('Y-m-d H:i:s', strtotime('+90 days'));
            
            $updateSql = "UPDATE usuario SET REMEMBER_TOKEN = ?, TOKEN_EXPIRY = ? WHERE IDUSUARIO = ?";
            DB::executeQuery($updateSql, [$new_token, $expiry, $user['IDUSUARIO']]);
            
            // Actualizar la cookie con mayor duración (90 días)
            setcookie('remember_token', $new_token, time() + (86400 * 90), '/', '', false, true);
            
            return true;
        }
    } catch (Exception $e) {
        error_log("Error en authenticateWithCookie: " . $e->getMessage());
    }
    
    // Si llegamos aquí, la autenticación falló
    // Borrar la cookie inválida
    setcookie('remember_token', '', time() - 3600, '/', '', false, true);
    return false;
}

// Función para crear sesión de usuario
function createUserSession($userId, $rememberMe = false) {
    try {
        // Obtener los datos del usuario
        $sql = "SELECT u.IDUSUARIO, u.USUARIO, ui.NOMBRE, ui.APELLIDOS, ui.CORREO 
                FROM usuario u 
                JOIN usuarios_info ui ON u.IDUSUARIO = ui.IDUSUARIO 
                WHERE u.IDUSUARIO = ?";
        $user = DB::getOne($sql, [$userId]);
        
        if ($user) {
            // Crear la sesión
            $_SESSION['user_id'] = $user['IDUSUARIO'];
            $_SESSION['username'] = $user['USUARIO'];
            $_SESSION['user_name'] = $user['NOMBRE'];
            $_SESSION['user_lastname'] = $user['APELLIDOS'];
            $_SESSION['user_email'] = $user['CORREO'];
            $_SESSION['last_activity'] = time();
            
            // Si el usuario marcó "recordarme" o queremos que siempre se recuerde
            if ($rememberMe) {
                // Generar un token único
                $token = bin2hex(random_bytes(32));
                // Expiración extendida a 90 días
                $expiry = date('Y-m-d H:i:s', strtotime('+90 days'));
                
                // Asegurarse de que la tabla usuario tenga las columnas REMEMBER_TOKEN y TOKEN_EXPIRY
                $updateSql = "UPDATE usuario SET REMEMBER_TOKEN = ?, TOKEN_EXPIRY = ? WHERE IDUSUARIO = ?";
                DB::executeQuery($updateSql, [$token, $expiry, $user['IDUSUARIO']]);
                
                // Crear cookie (90 días para mayor duración)
                setcookie('remember_token', $token, time() + (86400 * 90), '/', '', false, true);
            }
            
            return true;
        }
    } catch (Exception $e) {
        error_log("Error en createUserSession: " . $e->getMessage());
    }
    
    return false;
}

// Función para cerrar sesión
function logoutUser() {
    // Si hay una cookie de recordar, eliminarla de la BD
    if (isset($_COOKIE['remember_token']) && isset($_SESSION['user_id'])) {
        try {
            // Verificar si la clase DB está disponible, si no, incluir config.php
            if (!class_exists('DB')) {
                require_once __DIR__ . '/config.php';
            }
            
            $updateSql = "UPDATE usuario SET REMEMBER_TOKEN = NULL, TOKEN_EXPIRY = NULL WHERE IDUSUARIO = ?";
            DB::executeQuery($updateSql, [$_SESSION['user_id']]);
        } catch (Exception $e) {
            error_log("Error al eliminar token: " . $e->getMessage());
        }
        
        // Eliminar la cookie
        setcookie('remember_token', '', time() - 3600, '/', '', false, true);
    }
    
    // Destruir todas las variables de sesión
    session_unset();
    
    // Destruir la sesión
    session_destroy();
}

// Función auxiliar para obtener la ruta base del proyecto
function getBasePath() {
    $currentPath = $_SERVER['PHP_SELF'];
    $pathInfo = pathinfo($currentPath);
    $hostName = $_SERVER['HTTP_HOST'];
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
    
    // Si estamos en una subcarpeta como 'pages'
    if (strpos($pathInfo['dirname'], '/pages') !== false) {
        return $protocol . $hostName . str_replace('/pages', '', $pathInfo['dirname']) . '/';
    }
    
    return $protocol . $hostName . $pathInfo['dirname'] . '/';
}
?>