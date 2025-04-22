<?php 

    // Include the functions file
    require_once '../includes/functions.php';

    // Check if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        // Get the form data
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        // Validate the form data
        if (!empty($username) && !empty($password)) {

            if (comprobarLogin($username, $password)) {
                echo "Login correcto";
                header("Location: ../index.php");
            
            }
        } else {
            echo "Login incorrecto";
        }
    }

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title>Login</title>

    <!-- Boostrap downloaded import -->
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    

</head>
<body>
    
    <form action="login.php" method="post" class="bg-light">
        <div class="container">
            <h1 class="bg-text-primary">Iniciar Sesión</h1>
            <!-- Form group for username -->
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" name="username" placeholder="Username" required>
            </div>
            <!-- Form group for password -->
            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" class="form-control" name="password" placeholder="Contraseña" required>
            </div>

            <button type="submit" class="btn btn-primary">Inciar Sesión</button>

            <p>¿No tienes cuenta? <a href="register.php">Registrate</a></p>
        </div>

    </form>


</body>
</html>