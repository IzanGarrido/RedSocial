<?php
// Include the functions file
require_once '../includes/functions.php';

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

        if (
            comprobarNombre($nombre) &&
            comprobarApellidos($apellidos) &&
            comprobarUsername($username) &&
            comprobarEmail($email) &&
            comprobarContrasena($password, $confirmPassword)
        ) {
            echo "Registrando";
            registrarUsuario($nombre, $apellidos, $username, $email, $password, $confirmPassword);
            header("Location: ./login.php");
        }
    } else {
        echo "Todos los campos son obligatorios.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Registrarse</title>

    <!-- Boostrap downloaded import -->
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">

</head>

<body>

    <!-- Register form -->
    <form action="register.php" method="post" class="bg-light">
        <div class="container">
            <h1 class="bg-text-primary">Registrarse</h1>

            <!-- Form group for name -->
            <div class="form-group">
                <label for="name">Nombre</label>
                <input type="text" class="form-control" name="name" placeholder="Nombre" maxlength="50" required>
            </div>

            <!-- Form group for last name -->
            <div class="form-group">
                <label for="lastname">Apellidos</label>
                <input type="text" class="form-control" name="lastname" placeholder="Apellidos" maxlength="100" requiredº>
            </div>

            <!-- Form group for username -->
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" name="username" placeholder="Username" maxlength="20" required>
            </div>

            <!-- Form group for email -->
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" name="email" placeholder="Email" maxlength="100" required>
            </div>

            <!-- Form group for birthdate -->
            <div class="form-group">
                <label for="birthdate">Fecha de nacimiento</label>
                <input type="date" name="birthdate" id="birthdate" class="form-control" max="" required>
            </div>

            <!-- Form group for password -->
            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" class="form-control" name="password" placeholder="Contraseña" required>
            </div>

            <!-- Form group for confirm password -->
            <div class="form-group">
                <label for="password">Confirmar Contraseña</label>
                <input type="password" class="form-control" name="confirmPassword" placeholder="Confirmar Contraseña" required>
            </div>

            <!-- Submit button and link to login -->
            <button type="submit" class="btn btn-primary">Registrarse</button>
            <p>¿Ya tienes cuenta? <a href="login.php">Iniciar Sesión</a></p>
        </div>

    </form>

    <script src="../assets/js/register.js"></script>
</body>

</html>