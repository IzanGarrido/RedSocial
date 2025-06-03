<?php
/**
 * @author Izan Garrido Quintana
 */

// This will make the PHP session persist for 30 days instead of the default time
ini_set('session.gc_maxlifetime', 2592000);
ini_set('session.cookie_lifetime', 2592000);

// Start or resume the session
session_start();

// Function to check if there is an active session
function checkSession() {
    // If there is no session or the user is not authenticated, redirect to login
    if (!isset($_SESSION['user_id'])) {
        // Verify if there is a remember_token cookie
        if (isset($_COOKIE['remember_token'])) {
            // Attempt to authenticate with cookie
            if (authenticateWithCookie()) {
                // If authentication with cookie is successful, return true
                return true;
            }
        }
        
        // Save the current URL for redirecting after login
        $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
        
        // Redirect to login
        header('Location: ' . getBasePath() . 'pages/login.php');
        exit;
    }
    
    // Update the last activity time
    $_SESSION['last_activity'] = time();
    
    // Verify if the user has been inactive for more than 7 days
    if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 604800)) {
        // If the user has been inactive for more than 7 days, log them out
        logoutUser();
        header('Location: ' . getBasePath() . 'pages/login.php');
        exit;
    }
    
    return true;
}

// Function to authenticate with cookie
function authenticateWithCookie() {
    // Obtain the token from the cookie
    $token = $_COOKIE['remember_token'];
    
    // Include the config file if not already included
    if (!function_exists('DB::getOne')) {
        require_once 'config.php';
    }
    
    try {
        // Find the user in the database based on the token
        $sql = "SELECT IDUSUARIO, USUARIO, NOMBRE, APELLIDOS, CORREO 
                FROM USUARIO
                WHERE REMEMBER_TOKEN = ? AND TOKEN_EXPIRY > NOW()";
        $user = DB::getOne($sql, [$token]);
        
        if ($user) {
            // Create the session for the user
            $_SESSION['user_id'] = $user['IDUSUARIO'];
            $_SESSION['username'] = $user['USUARIO'];
            $_SESSION['user_name'] = $user['NOMBRE'];
            $_SESSION['user_lastname'] = $user['APELLIDOS'];
            $_SESSION['user_email'] = $user['CORREO'];
            $_SESSION['last_activity'] = time();
        
            // Generate a new token and update in the DB
            $new_token = bin2hex(random_bytes(32));
            // Extends the expiration to 90 days for longer duration
            $expiry = date('Y-m-d H:i:s', strtotime('+90 days'));
            
            $updateSql = "UPDATE USUARIO SET REMEMBER_TOKEN = ?, TOKEN_EXPIRY = ? WHERE IDUSUARIO = ?";
            DB::executeQuery($updateSql, [$new_token, $expiry, $user['IDUSUARIO']]);
            
            // Update the cookie with a longer duration (90 days)
            setcookie('remember_token', $new_token, time() + (86400 * 90), '/', '', false, true);
            
            return true;
        }
    } catch (Exception $e) {
    }

    // If we get here, authentication failed
    // Delete invalid cookie
    setcookie('remember_token', '', time() - 3600, '/', '', false, true);
    return false;
}

// Función para crear sesión de usuario
// Function for create user session
function createUserSession($userId, $rememberMe = false) {
    try {
        // Obtain the user data from the database
        $sql = "SELECT IDUSUARIO, USUARIO, NOMBRE, APELLIDOS, CORREO 
                FROM USUARIO
                WHERE IDUSUARIO = ?";
        $user = DB::getOne($sql, [$userId]);
        
        if ($user) {
            // Create the session for the user
            $_SESSION['user_id'] = $user['IDUSUARIO'];
            $_SESSION['username'] = $user['USUARIO'];
            $_SESSION['user_name'] = $user['NOMBRE'];
            $_SESSION['user_lastname'] = $user['APELLIDOS'];
            $_SESSION['user_email'] = $user['CORREO'];
            $_SESSION['last_activity'] = time();
            
            // If rememberMe is true, generate a new token and update in the DB
            if ($rememberMe) {
                // Generate a unique token
                $token = bin2hex(random_bytes(32));
                // Expire the token in 90 days
                $expiry = date('Y-m-d H:i:s', strtotime('+90 days'));
                
                // Asegure that the user table has columns REMEMBER_TOKEN and TOKEN_EXPIRY
                $updateSql = "UPDATE USUARIO SET REMEMBER_TOKEN = ?, TOKEN_EXPIRY = ? WHERE IDUSUARIO = ?";
                DB::executeQuery($updateSql, [$token, $expiry, $user['IDUSUARIO']]);
                
                // Create the cookie (90 days)
                setcookie('remember_token', $token, time() + (86400 * 90), '/', '', false, true);
            }
            
            return true;
        }
    } catch (Exception $e) {
    }
    
    return false;
}

// Function to log out the user
function logoutUser() {
    // If there is a remember_token cookie, delete it from the DB
    if (isset($_COOKIE['remember_token']) && isset($_SESSION['user_id'])) {
        try {
            // Verify if the DB class is available, if not, include config.php
            if (!class_exists('DB')) {
                require_once __DIR__ . '/config.php';
            }
            
            $updateSql = "UPDATE USUARIO SET REMEMBER_TOKEN = NULL, TOKEN_EXPIRY = NULL WHERE IDUSUARIO = ?";
            DB::executeQuery($updateSql, [$_SESSION['user_id']]);
        } catch (Exception $e) {
        }
        
        // Delete the cookie
        setcookie('remember_token', '', time() - 3600, '/', '', false, true);
    }
    
    // Unset all session variables
    session_unset();
    
    // Destroy the session
    session_destroy();
}

// Auxiliary function to get the base path
function getBasePath() {
    $currentPath = $_SERVER['PHP_SELF'];
    $pathInfo = pathinfo($currentPath);
    $hostName = $_SERVER['HTTP_HOST'];
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
    
    // If the current path contains '/pages', remove it
    if (strpos($pathInfo['dirname'], '/pages') !== false) {
        return $protocol . $hostName . str_replace('/pages', '', $pathInfo['dirname']) . '/';
    }
    
    return $protocol . $hostName . $pathInfo['dirname'] . '/';
}
?>