<?php
// Include the functions file
require_once '../includes/functions.php';

// Initialize variables to store errors and form data for persistence
$errores = [];
$nombre = $apellidos = $username = $email = $birthdate = '';
$registroExitoso = false;

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $nombre = $_POST['name'] ?? '';
    $apellidos = $_POST['lastname'] ?? '';
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $birthdate = $_POST['birthdate'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirmPassword'] ?? '';

    // Validate the form data
    if (!empty($nombre) && !empty($apellidos) && !empty($username) && !empty($email) && !empty($birthdate) && !empty($password) && !empty($confirmPassword)) {
        // Check name
        $validacionNombre = comprobarNombre($nombre);
        if ($validacionNombre !== true) {
            $errores['nombre'] = $validacionNombre;
        }
        
        // Check last name
        $validacionApellidos = comprobarApellidos($apellidos);
        if ($validacionApellidos !== true) {
            $errores['apellidos'] = $validacionApellidos;
        }
        
        // Check username
        $validacionUsername = comprobarUsername($username);
        if ($validacionUsername !== true) {
            $errores['username'] = $validacionUsername;
        }
        
        // Check email
        $validacionEmail = comprobarEmail($email);
        if ($validacionEmail !== true) {
            $errores['email'] = $validacionEmail;
        }
        
        // Check password
        $validacionPassword = comprobarContrasena($password, $confirmPassword);
        if (!$validacionPassword['valido']) {
            $errores['password'] = $validacionPassword['errores'];
        }
        
        // If no errors, register the user and create the directory for save the posts and profile image
        if (empty($errores)) {
            $userId = registrarUsuario($nombre, $apellidos, $username, $email, $password, $confirmPassword);
            creardirectoriobase($username);
            
            if ($userId > 0) {
                // Redirect to login page with success parameter
                header("Location: login.php?registro=exitoso");
                exit;
            } else {
                $errores['general'] = "Ha ocurrido un error al registrar el usuario. Por favor, inténtalo de nuevo.";
            }
        }
    } else {
        $errores['general'] = "Todos los campos son obligatorios.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Registrarse - Gameord</title>

    <!-- Boostrap downloaded import -->
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../node_modules/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="shortcut icon" href="../assets/App-images/Gameord-logo.webp" type="image/x-icon">
    
    <link rel="stylesheet" href="../assets/css/register.css">
</head>

<body class="bg-light">
    <div class="container">
        <div class="register-container bg-white">
            <div class="text-center mb-4">
                <img src="../assets/App-images/Gameord-logo.webp" alt="Gameord Logo" height="60" class="mb-2 rounded-2">
                <h2 class="text-primary">Crear una cuenta</h2>
                <p class="text-muted">Únete a nuestra comunidad gamer y comparte tus experiencias</p>
            </div>
            
            <?php if (!empty($errores)): ?>
                <div class="alert alert-danger">
                    <?php 
                        if (isset($errores['general'])) {
                            echo $errores['general'];
                        } else {
                            // Display the first error
                            $primerError = '';
                            foreach ($errores as $campo => $error) {
                                if (is_array($error)) {
                                    $primerError = reset($error);
                                } else {
                                    $primerError = $error;
                                }
                                break;
                            }
                            echo $primerError;
                        }
                    ?>
                </div>
            <?php endif; ?>

            <!-- Register form -->
            <form action="register.php" method="post">
                <div class="row">
                    <!-- Form group for name -->
                    <div class="col-md-6 mb-3">
                        <label for="name">Nombre</label>
                        <div class="input-with-icon">
                            <i class="bi bi-person"></i>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Nombre" maxlength="50" required value="<?php echo htmlspecialchars($nombre); ?>">
                        </div>
                        <?php if (isset($errores['nombre'])): ?>
                            <small class="text-danger"><?php echo $errores['nombre']; ?></small>
                        <?php endif; ?>
                    </div>

                    <!-- Form group for last name -->
                    <div class="col-md-6 mb-3">
                        <label for="lastname">Apellidos</label>
                        <div class="input-with-icon">
                            <i class="bi bi-person"></i>
                            <input type="text" class="form-control" name="lastname" id="lastname" placeholder="Apellidos" maxlength="100" required value="<?php echo htmlspecialchars($apellidos); ?>">
                        </div>
                        <?php if (isset($errores['apellidos'])): ?>
                            <small class="text-danger"><?php echo $errores['apellidos']; ?></small>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Form group for username -->
                <div class="mb-3">
                    <label for="username">Nombre de usuario</label>
                    <div class="input-with-icon">
                        <i class="bi bi-person-badge"></i>
                        <input type="text" class="form-control" name="username" id="username" placeholder="Nombre de usuario" maxlength="20" required value="<?php echo htmlspecialchars($username); ?>">
                    </div>
                    <?php if (isset($errores['username'])): ?>
                        <small class="text-danger"><?php echo $errores['username']; ?></small>
                    <?php endif; ?>
                </div>

                <!-- Form group for email -->
                <div class="mb-3">
                    <label for="email">Correo electrónico</label>
                    <div class="input-with-icon">
                        <i class="bi bi-envelope"></i>
                        <input type="email" class="form-control" name="email" id="email" placeholder="Correo electrónico" maxlength="100" required value="<?php echo htmlspecialchars($email); ?>">
                    </div>
                    <?php if (isset($errores['email'])): ?>
                        <small class="text-danger"><?php echo $errores['email']; ?></small>
                    <?php endif; ?>
                </div>

                <!-- Form group for birthdate -->
                <div class="mb-3">
                    <label for="birthdate">Fecha de nacimiento</label>
                    <div class="input-with-icon">
                        <i class="bi bi-calendar"></i>
                        <input type="date" name="birthdate" id="birthdate" class="form-control" required value="<?php echo htmlspecialchars($birthdate); ?>">
                    </div>
                    <small class="form-text text-muted">Debes tener al menos 16 años para registrarte.</small>
                </div>

                <div class="row">
                    <!-- Form group for password -->
                    <div class="col-md-6 mb-3">
                        <label for="password">Contraseña</label>
                        <div class="input-with-icon">
                            <i class="bi bi-lock"></i>
                            <input type="password" class="form-control" name="password" id="password" placeholder="Contraseña" required>
                        </div>
                        <div class="password-requirements">
                            <small>La contraseña debe tener:</small>
                            <ul class="ps-3 mb-0">
                                <li><small>Al menos 8 caracteres</small></li>
                                <li><small>Al menos una mayúscula</small></li>
                                <li><small>Al menos una minúscula</small></li>
                                <li><small>Al menos un número</small></li>
                                <li><small>Al menos un carácter especial</small></li>
                            </ul>
                        </div>
                    </div>

                    <!-- Form group for confirm password -->
                    <div class="col-md-6 mb-3">
                        <label for="confirmPassword">Confirmar Contraseña</label>
                        <div class="input-with-icon">
                            <i class="bi bi-lock"></i>
                            <input type="password" class="form-control" name="confirmPassword" id="confirmPassword" placeholder="Confirmar Contraseña" required>
                        </div>
                    </div>
                </div>
                
                <?php if (isset($errores['password']) && is_array($errores['password'])): ?>
                    <div class="mb-3">
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php foreach ($errores['password'] as $passwordError): ?>
                                    <li><?php echo $passwordError; ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Submit button and link to login -->
                <button type="submit" class="btn btn-primary w-100 mb-3">Registrarse</button>
                <p class="text-center">¿Ya tienes cuenta? <a href="login.php">Iniciar Sesión</a></p>
            </form>
        </div>
    </div>

    <!-- Scripts -->
    <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/register.js"></script>
</body>

</html>