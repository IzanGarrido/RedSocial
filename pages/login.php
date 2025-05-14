<?php 
    // Include the functions file and session control
    require_once '../includes/functions.php';
    require_once '../includes/session_control.php';
    
    // If the user is already logged in, redirect to the main page
    if (isset($_SESSION['user_id'])) {
        header('Location: ../index.php');
        exit;
    }
    
    // Variable to store the error message
    $error = '';

    // Check if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get the form data
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        
        // Default to true for "remember me" functionality
        $rememberMe = true;

        // Validate the form data
        if (!empty($username) && !empty($password)) {
            if (comprobarLogin($username, $password)) {
                // Obtain the user ID
                try {
                    $sql = "SELECT IDUSUARIO FROM USUARIO WHERE USUARIO = ?";
                    $params = [$username];
                    $userId = DB::getOne($sql, $params)['IDUSUARIO'];
                    
                    // Create the session and always set the cookie
                    if (createUserSession($userId, $rememberMe)) {
                        // Redirect to the last visited page or the main page
                        $redirect = $_SESSION['redirect_url'] ?? '../index.php';
                        unset($_SESSION['redirect_url']);
                        header("Location: $redirect");
                        exit;
                    }
                } catch (Exception $e) {
                    error_log("Error al obtener usuario: " . $e->getMessage());
                    $error = "Error al iniciar sesión. Inténtalo de nuevo.";
                }
            } else {
                $error = "Usuario o contraseña incorrectos";
            }
        } else {
            $error = "Por favor, completa todos los campos";
        }
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login - Gameord</title>

    <!-- Boostrap downloaded import -->
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../node_modules/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="shortcut icon" href="../assets/App-images/Gameord-logo.webp" type="image/x-icon">
    
    <link rel="stylesheet" href="../assets/css/login.css">
</head>
<body class="bg-light">
    
    <div class="container">
        <div class="login-container bg-white">
            <div class="text-center mb-4">
                <img src="../assets/App-images/Gameord-logo.webp" alt="Gameord Logo" height="60" class="mb-2 rounded-2">
                <h2 class="text-primary">Iniciar Sesión</h2>
            </div>
            
            <?php if (!empty($error)): ?>
                <div class="error-message"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <form action="login.php" method="post">
                <!-- Form group for username -->
                <div class="form-group mb-3">
                    <label for="username">Nombre de usuario</label>
                    <div class="input-with-icon">
                        <i class="bi bi-person icon-left"></i>
                        <input type="text" class="form-control" name="username" id="username" placeholder="Nombre de usuario" required>
                    </div>
                </div>
                
                <!-- Form group for password -->
                <div class="form-group mb-3">
                    <label for="password">Contraseña</label>
                    <div class="input-with-icon">
                        <i class="bi bi-lock icon-left"></i>
                        <input type="password" class="form-control" name="password" id="password" placeholder="Contraseña" required>
                        <i class="bi bi-eye-slash icon-right" id="togglePassword"></i>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100 mb-3">Iniciar Sesión</button>

                <p class="text-center">¿No tienes cuenta? <a href="register.php">Regístrate</a></p>
            </form>
        </div>
    </div>

    <!-- Scripts -->
    <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/login.js"></script>
</body>
</html>