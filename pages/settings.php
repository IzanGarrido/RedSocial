<?php
// Include the session control file
require_once '../includes/session_control.php';
require_once '../includes/functions.php';

// Check if there is an active session
checkSession();

// Get user information
$userId = $_SESSION['user_id'];
$currentUser = obtenerUsuarioPorId($userId);

if (!$currentUser) {
    header('Location: ../index.php');
    exit;
}

// Variables for form persistence and errors
$errores = [];
$exito = '';
$nombre = $currentUser['NOMBRE'] ?? '';
$apellidos = $currentUser['APELLIDOS'] ?? '';
$username = $currentUser['USUARIO'] ?? '';
$email = $currentUser['CORREO'] ?? '';
$fechaNacimiento = $currentUser['FECHA_NACIMIENTO'] ?? '';

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Profile image update
    if (isset($_POST['update_profile_image']) && isset($_FILES['profile_image'])) {
        $file = $_FILES['profile_image'];

        if ($file['error'] === UPLOAD_ERR_OK) {
            // Validate file
            $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
            $fileType = $file['type'];
            $fileSize = $file['size'];
            $maxSize = 5 * 1024 * 1024; // 5MB

            if (!in_array($fileType, $allowedTypes)) {
                $errores['profile_image'] = 'Solo se permiten archivos JPG, PNG, GIF o WEBP .';
            } elseif ($fileSize > $maxSize) {
                $errores['profile_image'] = 'El archivo es demasiado grande. Máximo 5MB.';
            } else {
                // Create user directory if it doesn't exist
                $rutaBase = obtenerRutaBase('absoluta');
                $userDir = $rutaBase . "assets/users/{$username}";

                if (!file_exists($userDir)) {
                    mkdir($userDir, 0777, true);
                }

                // Generate unique filename
                $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
                $filename = 'profile.' . $extension;
                $filePath = $userDir . '/' . $filename;

                // Remove old profile image (except default)
                $oldFiles = glob($userDir . '/profile.*');
                foreach ($oldFiles as $oldFile) {
                    if (file_exists($oldFile)) {
                        unlink($oldFile);
                    }
                }

                // Move uploaded file
                if (move_uploaded_file($file['tmp_name'], $filePath)) {
                    // Update database
                    $urlRelativa = "./assets/users/{$username}/{$filename}";
                    $sql = "UPDATE USUARIO SET URL_FOTO = ? WHERE IDUSUARIO = ?";
                    DB::executeQuery($sql, [$urlRelativa, $userId]);

                    $exito = 'Imagen de perfil actualizada correctamente.';
                } else {
                    $errores['profile_image'] = 'Error al subir la imagen.';
                }
            }
        } elseif ($file['error'] !== UPLOAD_ERR_NO_FILE) {
            $errores['profile_image'] = 'Error al subir el archivo.';
        }
    }

    // Profile information update
    if (isset($_POST['update_profile'])) {
        $newNombre = trim($_POST['nombre'] ?? '');
        $newApellidos = trim($_POST['apellidos'] ?? '');
        $newUsername = trim($_POST['username'] ?? '');
        $newEmail = trim($_POST['email'] ?? '');
        $newFechaNacimiento = $_POST['fecha_nacimiento'] ?? '';

        // Validate name
        if (empty($newNombre)) {
            $errores['nombre'] = 'El nombre es obligatorio.';
        } elseif (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]*$/", $newNombre)) {
            $errores['nombre'] = 'El nombre solo puede contener letras.';
        }

        // Validate last names
        if (empty($newApellidos)) {
            $errores['apellidos'] = 'Los apellidos son obligatorios.';
        } elseif (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]*$/", $newApellidos)) {
            $errores['apellidos'] = 'Los apellidos solo pueden contener letras y espacios.';
        }

        // Validate username (only if different from current)
        if ($newUsername !== $username) {
            if (empty($newUsername)) {
                $errores['username'] = 'El nombre de usuario es obligatorio.';
            } elseif (!preg_match("/^[a-zA-Z0-9_]*$/", $newUsername)) {
                $errores['username'] = 'El nombre de usuario solo puede contener letras, números y guiones bajos.';
            } else {
                // Check if username already exists
                $checkUsernameQuery = "SELECT IDUSUARIO FROM USUARIO WHERE USUARIO = ? AND IDUSUARIO != ?";
                $existingUser = DB::getOne($checkUsernameQuery, [$newUsername, $userId]);
                if ($existingUser) {
                    $errores['username'] = 'El nombre de usuario ya existe.';
                }
            }
        }

        // Validate email (only if different from current)
        if ($newEmail !== $email) {
            if (empty($newEmail)) {
                $errores['email'] = 'El correo electrónico es obligatorio.';
            } elseif (!filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
                $errores['email'] = 'El formato del correo electrónico no es válido.';
            } else {
                // Check if email already exists
                $checkEmailQuery = "SELECT IDUSUARIO FROM USUARIO WHERE CORREO = ? AND IDUSUARIO != ?";
                $existingEmail = DB::getOne($checkEmailQuery, [$newEmail, $userId]);
                if ($existingEmail) {
                    $errores['email'] = 'El correo electrónico ya existe.';
                }
            }
        }

        // Validate birthdate
        $validacionFecha = comprobarFechaNacimiento($newFechaNacimiento);
        if ($validacionFecha !== true) {
            $errores['fecha_nacimiento'] = $validacionFecha;
        }

        // If no errors, update the user
        if (empty($errores)) {
            try {
                // Handle username change (rename directory if necessary)
                if ($newUsername !== $username) {
                    $rutaBase = obtenerRutaBase('absoluta');
                    $oldDir = $rutaBase . "assets/users/{$username}";
                    $newDir = $rutaBase . "assets/users/{$newUsername}";

                    if (file_exists($oldDir) && !file_exists($newDir)) {
                        rename($oldDir, $newDir);

                        // Update URL_FOTO path in database
                        $updatePhotoQuery = "UPDATE USUARIO SET URL_FOTO = REPLACE(URL_FOTO, './assets/users/{$username}/', './assets/users/{$newUsername}/') WHERE IDUSUARIO = ?";
                        DB::executeQuery($updatePhotoQuery, [$userId]);

                        // Update posts URLs
                        $updatePostsQuery = "UPDATE PUBLICACIONES_USUARIOS SET URL = REPLACE(URL, './assets/users/{$username}/', './assets/users/{$newUsername}/') WHERE IDUSUARIO = ?";
                        DB::executeQuery($updatePostsQuery, [$userId]);
                    }
                }

                // Update user information
                $updateQuery = "UPDATE USUARIO SET NOMBRE = ?, APELLIDOS = ?, USUARIO = ?, CORREO = ?, FECHA_NACIMIENTO = ? WHERE IDUSUARIO = ?";
                DB::executeQuery($updateQuery, [$newNombre, $newApellidos, $newUsername, $newEmail, $newFechaNacimiento, $userId]);

                // Update session variables
                $_SESSION['username'] = $newUsername;
                $_SESSION['user_name'] = $newNombre;
                $_SESSION['user_lastname'] = $newApellidos;
                $_SESSION['user_email'] = $newEmail;

                // Update variables for form display
                $nombre = $newNombre;
                $apellidos = $newApellidos;
                $username = $newUsername;
                $email = $newEmail;
                $fechaNacimiento = $newFechaNacimiento;

                $exito = 'Perfil actualizado correctamente.';
            } catch (Exception $e) {
                $errores['general'] = 'Error al actualizar el perfil. Inténtalo de nuevo.';
            }
        }
    }

    // Additional information update
    if (isset($_POST['update_additional'])) {
        $newBio = trim($_POST['bio'] ?? '');

        // Validate bio length
        if (strlen($newBio) > 500) {
            $errores['bio'] = 'La biografía no puede superar los 500 caracteres.';
        }

        // If no errors, update bio
        if (empty($errores)) {
            try {
                $updateBioQuery = "UPDATE USUARIO SET BIO = ? WHERE IDUSUARIO = ?";
                DB::executeQuery($updateBioQuery, [$newBio, $userId]);
                $exito = 'Información adicional actualizada correctamente.';
            } catch (Exception $e) {
                $errores['bio'] = 'Error al actualizar la biografía. Inténtalo de nuevo.';
            }
        }
    }

    // Password change
    if (isset($_POST['change_password'])) {
        $currentPassword = $_POST['current_password'] ?? '';
        $newPassword = $_POST['new_password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        if (empty($currentPassword)) {
            $errores['current_password'] = 'La contraseña actual es obligatoria.';
        } else {
            // Verify current password
            if (!comprobarlogin($username, $currentPassword)) {
                $errores['current_password'] = 'La contraseña actual es incorrecta.';
            }
        }

        // Validate new password
        $validacionPassword = comprobarContrasena($newPassword, $confirmPassword);
        if (!$validacionPassword['valido']) {
            $errores['new_password'] = $validacionPassword['errores'];
        }

        // If no errors, update password
        if (empty($errores)) {
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $updatePasswordQuery = "UPDATE USUARIO SET HASH_PASSWORD = ? WHERE IDUSUARIO = ?";
            DB::executeQuery($updatePasswordQuery, [$hashedPassword, $userId]);

            $exito = 'Contraseña actualizada correctamente.';
        }
    }

    // Delete account
    if (isset($_POST['delete_account'])) {
        $deletePassword = $_POST['delete_password'] ?? '';

        if (empty($deletePassword)) {
            $errores['delete_password'] = 'La contraseña es obligatoria para eliminar la cuenta.';
        } else {
            // Verify password
            if (!comprobarlogin($username, $deletePassword)) {
                $errores['delete_password'] = 'La contraseña es incorrecta.';
            } else {
                // Delete account
                try {
                    // Delete user directory
                    $rutaBase = obtenerRutaBase('absoluta');
                    $userDir = $rutaBase . "assets/users/{$username}";

                    if (file_exists($userDir)) {
                        function eliminarDirectorio($dir)
                        {
                            if (!file_exists($dir))
                                return true;
                            if (!is_dir($dir))
                                return unlink($dir);

                            foreach (scandir($dir) as $item) {
                                if ($item == '.' || $item == '..')
                                    continue;
                                if (!eliminarDirectorio($dir . DIRECTORY_SEPARATOR . $item))
                                    return false;
                            }

                            return rmdir($dir);
                        }

                        eliminarDirectorio($userDir);
                    }

                    // Delete user from database (foreign keys will handle related data)
                    DB::executeQuery("DELETE FROM USUARIO WHERE IDUSUARIO = ?", [$userId]);

                    // Logout and redirect
                    logoutUser();
                    header('Location: login.php?account_deleted=1');
                    exit;
                } catch (Exception $e) {
                    $errores['delete_password'] = 'Error al eliminar la cuenta. Inténtalo de nuevo.';
                }
            }
        }
    }
}

// Get current profile image
$profileImage = getProfileImage($username);
$rangoFechas = obtenerRangoFechas();

// Get current user complete info including bio
function obtenerUsuarioCompleto($userId)
{
    try {
        $sql = "SELECT IDUSUARIO, USUARIO, NOMBRE, APELLIDOS, CORREO, FECHA_NACIMIENTO, URL_FOTO, BIO
                FROM USUARIO 
                WHERE IDUSUARIO = ?";
        $user = DB::getOne($sql, [$userId]);
        return $user;
    } catch (Exception $e) {
        return null;
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Configuración - Gameord</title>

    <link rel="shortcut icon" href="../assets/App-images/Gameord-logo.webp" type="image/x-icon">
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../node_modules/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/css/index.css">
    <link rel="stylesheet" href="../assets/css/settings.css">
</head>

<body>
    <!-- Navbar -->
    <header class="navbar navbar-expand-lg navbar-dark py-2 sticky-top">
        <div class="container-fluid">
            <div class="d-flex align-items-center">
                <a class="navbar-brand d-flex align-items-center" href="../index.php">
                    <img src="../assets/App-images/Gameord-logo.webp" alt="Logo" class="me-2 rounded-2" height="40">
                    <span class="fw-bold fs-4 d-none d-sm-inline">Gameord</span>
                </a>
            </div>

            <ul class="navbar-nav d-flex align-items-center flex-row flex-nowrap">
                <!-- Chat -->
                <li class="nav-item mx-2">
                    <a class="nav-link" href="./chat.php" title="Chat">
                        <i class="bi bi-chat nav-icon"></i>
                    </a>
                </li>

                <!-- Notifications -->
                <li class="nav-item mx-2 position-static">
                    <div class="dropdown">
                        <a class="nav-link position-relative" href="#" id="Notificaciones" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                            <i class="bi bi-bell nav-icon"></i>
                            <?php if (obtenerNumeroNotificacionesNoLeidas($userId) > 0) { ?>
                            <span
                                class="position-absolute top-40 start-60 translate-middle badge rounded-pill bg-danger"
                                style="font-size: 0.6em;">
                                <?php echo obtenerNumeroNotificacionesNoLeidas($userId) > 9 ? '9+' : obtenerNumeroNotificacionesNoLeidas($userId); ?>
                                <span class="visually-hidden">notificaciones no leídas</span>
                            </span>
                            <?php } ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0" aria-labelledby="Notificaciones"
                            style="min-width: 300px; max-height: 400px; overflow-y: auto;">
                            <?php
                            $notificaciones = obtenerNotificacionesNoLeidas($userId);
                            if (count($notificaciones) > 0) {
                                foreach ($notificaciones as $notificacion) {
                                    $text = match ($notificacion['TIPO']) {
                                        'like' => 'te ha dado un like a tu publicación',
                                        'comentario' => 'ha comentado en tu publicación',
                                        'seguimiento' => 'te ha seguido',
                                        'sistema' => 'Tienes un mensaje del sistema',
                                        'mensaje' => 'te ha enviado un mensaje',
                                        default => 'te ha enviado una notificación'
                                    };

                                    echo '<li>
                                            <a class="dropdown-item d-flex align-items-start py-3 px-3 border-bottom" href="#">
                                                <div class="flex-shrink-0">
                                                    <img src="' . getProfileImage($notificacion['ORIGEN']) . '" alt="User" class="rounded-circle" width="40" height="40">
                                                </div>
                                                <div class="flex-grow-1 ms-3 overflow-hidden">
                                                    <p class="mb-1 text-wrap"><strong>' . $notificacion['ORIGEN'] . '</strong> ' . $text . '</p>
                                                    <small class="text-muted">' . date("d-m-y H:i", strtotime($notificacion['FECHA'])) . '</small>
                                                </div>
                                            </a>
                                          </li>';
                                }
                            } else {
                                echo '<li>
                                        <div class="dropdown-item text-center py-4">
                                            <i class="bi bi-bell-slash text-muted" style="font-size: 2rem;"></i>
                                            <p class="mb-0 mt-2 text-muted">No tienes notificaciones</p>
                                        </div>
                                      </li>';
                            }
                            ?>
                        </ul>
                    </div>
                </li>

                <!-- Create post -->
                <li class="nav-item mx-2">
                    <a class="nav-link" href="../index.php" title="Crear publicación">
                        <i class="bi bi-plus-circle nav-icon"></i>
                    </a>
                </li>

                <!-- User profile and settings -->
                <li class="nav-item mx-2 position-static">
                    <div class="dropdown">
                        <a class="nav-link d-flex align-items-center" href="#" id="userDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                            <img src="<?php echo $profileImage; ?>" alt="User" class="rounded-circle me-1" width="32"
                                height="32">
                            <span class="d-none d-lg-block ms-1"><?php echo $username; ?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0" aria-labelledby="userDropdown"
                            style="min-width: 200px;">
                            <li class="px-3 py-2 border-bottom">
                                <div class="d-flex align-items-center">
                                    <img src="<?php echo $profileImage; ?>" alt="User" class="rounded-circle me-2"
                                        width="40" height="40">
                                    <div>
                                        <div class="fw-bold"><?php echo $username; ?></div>
                                        <small class="text-muted"><?php echo $email; ?></small>
                                    </div>
                                </div>
                            </li>
                            <li><a class="dropdown-item py-2"
                                    href="./user.php?user=<?php echo urlencode($username); ?>"><i
                                        class="bi bi-person me-2"></i>Mi perfil</a></li>
                            <li><a class="dropdown-item py-2 bg-light" href="./settings.php"><i
                                        class="bi bi-gear me-2"></i>Configuración</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item py-2 text-danger" href="./logout.php"><i
                                        class="bi bi-box-arrow-right me-2"></i>Cerrar sesión</a></li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </header>

    <!-- Main Content -->
    <div class="container-fluid">
        <div class="settings-container">
            <div class="text-center mb-4">
                <h2 class="text-primary fw-bold">
                    <i class="bi bi-gear me-2"></i>Configuración de la cuenta
                </h2>
                <p class="text-muted">Administra tu información personal y configuración de la cuenta</p>
            </div>

            <!-- Success Message -->
            <?php if (!empty($exito)): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i><?php echo $exito; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php endif; ?>

            <!-- Profile Image Section -->
            <div class="settings-section">
                <h5><i class="bi bi-image me-2"></i>Imagen de perfil</h5>

                <form method="post" enctype="multipart/form-data">
                    <div class="image-upload-area">
                        <div class="profile-image-container">
                            <img src="<?php echo $profileImage; ?>" alt="Imagen de perfil" class="profile-image-preview"
                                id="imagePreview">
                        </div>

                        <div class="mt-3">
                            <label for="profileImageInput" class="file-input-label">
                                <i class="bi bi-camera me-2"></i>Seleccionar nueva imagen
                            </label>
                            <input type="file" id="profileImageInput" name="profile_image" class="file-input-custom"
                                accept="image/*" onchange="previewImage(this)">
                        </div>

                        <?php if (isset($errores['profile_image'])): ?>
                        <div class="alert alert-danger mt-3">
                            <i class="bi bi-exclamation-triangle me-2"></i><?php echo $errores['profile_image']; ?>
                        </div>
                        <?php endif; ?>

                        <div class="mt-4">
                            <button type="submit" name="update_profile_image" class="btn btn-primary">
                                <i class="bi bi-upload me-2"></i>Actualizar imagen
                            </button>
                        </div>

                        <div class="mt-3">
                            <small class="text-muted">
                                <i class="bi bi-info-circle me-1"></i>
                                Formatos admitidos: JPG, PNG, GIF, WEBP • Tamaño máximo: 5MB • Dimensiones recomendadas:
                                400x400px
                            </small>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Profile Information Section -->
            <div class="settings-section">
                <h5><i class="bi bi-person me-2"></i>Información personal</h5>

                <form method="post">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text"
                                class="form-control <?php echo isset($errores['nombre']) ? 'is-invalid' : ''; ?>"
                                id="nombre" name="nombre" value="<?php echo htmlspecialchars($nombre); ?>"
                                maxlength="50" required>
                            <?php if (isset($errores['nombre'])): ?>
                            <div class="invalid-feedback"><?php echo $errores['nombre']; ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="apellidos" class="form-label">Apellidos</label>
                            <input type="text"
                                class="form-control <?php echo isset($errores['apellidos']) ? 'is-invalid' : ''; ?>"
                                id="apellidos" name="apellidos" value="<?php echo htmlspecialchars($apellidos); ?>"
                                maxlength="100" required>
                            <?php if (isset($errores['apellidos'])): ?>
                            <div class="invalid-feedback"><?php echo $errores['apellidos']; ?></div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="username" class="form-label">Nombre de usuario</label>
                            <input type="text"
                                class="form-control <?php echo isset($errores['username']) ? 'is-invalid' : ''; ?>"
                                id="username" name="username" value="<?php echo htmlspecialchars($username); ?>"
                                maxlength="20" required>
                            <?php if (isset($errores['username'])): ?>
                            <div class="invalid-feedback"><?php echo $errores['username']; ?></div>
                            <?php endif; ?>
                            <small class="text-muted">Solo se puede cambiar si el nuevo nombre no existe</small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Correo electrónico</label>
                            <input type="email"
                                class="form-control <?php echo isset($errores['email']) ? 'is-invalid' : ''; ?>"
                                id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" maxlength="100"
                                required>
                            <?php if (isset($errores['email'])): ?>
                            <div class="invalid-feedback"><?php echo $errores['email']; ?></div>
                            <?php endif; ?>
                            <small class="text-muted">Solo se puede cambiar si el nuevo correo no existe</small>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="fecha_nacimiento" class="form-label">Fecha de nacimiento</label>
                        <input type="date"
                            class="form-control <?php echo isset($errores['fecha_nacimiento']) ? 'is-invalid' : ''; ?>"
                            id="fecha_nacimiento" name="fecha_nacimiento" value="<?php echo $fechaNacimiento; ?>"
                            min="<?php echo $rangoFechas['min']; ?>" max="<?php echo $rangoFechas['max']; ?>" required>
                        <?php if (isset($errores['fecha_nacimiento'])): ?>
                        <div class="invalid-feedback"><?php echo $errores['fecha_nacimiento']; ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="text-end">
                        <button type="submit" name="update_profile" class="btn btn-primary">
                            <i class="bi bi-save me-2"></i>Guardar cambios
                        </button>
                    </div>
                </form>
            </div>

            <!-- Password Change Section -->
            <div class="settings-section">
                <h5><i class="bi bi-shield-lock me-2"></i>Cambiar contraseña</h5>

                <form method="post">
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Contraseña actual</label>
                        <input type="password"
                            class="form-control <?php echo isset($errores['current_password']) ? 'is-invalid' : ''; ?>"
                            id="current_password" name="current_password" required>
                        <?php if (isset($errores['current_password'])): ?>
                        <div class="invalid-feedback"><?php echo $errores['current_password']; ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="new_password" class="form-label">Nueva contraseña</label>
                            <input type="password"
                                class="form-control <?php echo isset($errores['new_password']) ? 'is-invalid' : ''; ?>"
                                id="new_password" name="new_password" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="confirm_password" class="form-label">Confirmar nueva contraseña</label>
                            <input type="password"
                                class="form-control <?php echo isset($errores['new_password']) ? 'is-invalid' : ''; ?>"
                                id="confirm_password" name="confirm_password" required>
                        </div>
                    </div>

                    <?php if (isset($errores['new_password']) && is_array($errores['new_password'])): ?>
                    <div class="mb-3">
                        <div class="alert alert-danger">
                            <strong>Requisitos de la contraseña:</strong>
                            <ul class="mb-0 mt-2">
                                <?php foreach ($errores['new_password'] as $passwordError): ?>
                                <li><?php echo $passwordError; ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                    <?php endif; ?>

                    <div class="password-requirements mb-3">
                        <strong><i class="bi bi-info-circle me-2"></i>Requisitos de la contraseña:</strong>
                        <ul class="mt-2 mb-0">
                            <li>Al menos 8 caracteres</li>
                            <li>Una letra minúscula</li>
                            <li>Una letra mayúscula</li>
                            <li>Un número</li>
                            <li>Un carácter especial (!@#$%^&*)</li>
                        </ul>
                    </div>

                    <div class="text-end">
                        <button type="submit" name="change_password" class="btn btn-primary">
                            <i class="bi bi-key me-2"></i>Cambiar contraseña
                        </button>
                    </div>
                </form>
            </div>

            <!-- Additional Settings Section -->
            <div class="settings-section">
                <h5><i class="bi bi-person-lines-fill me-2"></i>Información adicional</h5>

                <form method="post">
                    <div class="mb-3">
                        <label for="bio" class="form-label">Biografía</label>
                        <textarea class="form-control <?php echo isset($errores['bio']) ? 'is-invalid' : ''; ?>"
                            id="bio" name="bio" rows="4" placeholder="Cuéntanos algo sobre ti..." maxlength="500"><?php
                            $currentUserComplete = obtenerUsuarioCompleto($userId);
                            echo htmlspecialchars($currentUserComplete['BIO'] ?? '');
                            ?></textarea>
                        <?php if (isset($errores['bio'])): ?>
                        <div class="invalid-feedback"><?php echo $errores['bio']; ?></div>
                        <?php endif; ?>
                        <small class="text-muted">Máximo 500 caracteres</small>
                    </div>

                    <div class="text-end">
                        <button type="submit" name="update_additional" class="btn btn-primary">
                            <i class="bi bi-save me-2"></i>Guardar información adicional
                        </button>
                    </div>
                </form>
            </div>

            <!-- Danger Zone Section -->
            <div class="settings-section danger-zone">
                <h5><i class="bi bi-exclamation-triangle me-2"></i>Zona de peligro</h5>

                <div class="mb-4">
                    <h6 class="text-danger">Eliminar cuenta</h6>
                    <p class="text-muted mb-3">
                        Una vez que elimines tu cuenta, no hay vuelta atrás. Se eliminarán permanentemente
                        todos tus datos, publicaciones, comentarios y configuraciones.
                    </p>

                    <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                        data-bs-target="#deleteAccountModal">
                        <i class="bi bi-trash me-2"></i>Eliminar mi cuenta
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Account Modal -->
    <div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteAccountModalLabel">
                        <i class="bi bi-exclamation-triangle me-2"></i>Confirmar eliminación de cuenta
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger">
                        <strong>¡Atención!</strong> Esta acción no se puede deshacer.
                    </div>

                    <p><strong>Se eliminarán permanentemente:</strong></p>
                    <ul>
                        <li>Tu perfil y toda la información personal</li>
                        <li>Todas tus publicaciones y comentarios</li>
                        <li>Tus imágenes y archivos subidos</li>
                        <li>Tu historial de mensajes</li>
                        <li>Todas las configuraciones de la cuenta</li>
                    </ul>

                    <form method="post" id="deleteAccountForm">
                        <div class="mb-3">
                            <label for="delete_password" class="form-label">
                                Para confirmar, introduce tu contraseña actual:
                            </label>
                            <input type="password"
                                class="form-control <?php echo isset($errores['delete_password']) ? 'is-invalid' : ''; ?>"
                                id="delete_password" name="delete_password" required placeholder="Tu contraseña actual">
                            <?php if (isset($errores['delete_password'])): ?>
                            <div class="invalid-feedback"><?php echo $errores['delete_password']; ?></div>
                            <?php endif; ?>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Cancelar
                    </button>
                    <button type="submit" name="delete_account" class="btn btn-danger">
                        <i class="bi bi-trash me-2"></i>Sí, eliminar mi cuenta
                    </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/settings.js"></script>
</body>

</html>