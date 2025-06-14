<?php
require_once '../includes/session_control.php';
require_once '../includes/functions.php';
checkSession();

// Obtain the game ID from the URL 
$gameId = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if (!$gameId) {
    header('Location: ../index.php');
    exit;
}

// Obtain game information from the database
try {
    $gameInfo = DB::getOne("SELECT j.*, c.CATEGORIA, comp.COMPAÑIA 
                           FROM JUEGOS j 
                           LEFT JOIN CATEGORIAS c ON j.ID_CATEGORIA = c.ID_CATEGORIA 
                           LEFT JOIN COMPAÑIAS comp ON j.ID_COMPAÑIA = comp.ID_COMPAÑIA 
                           WHERE j.IDJUEGO = ?", [$gameId]);
    if (!$gameInfo) {
        header('Location: ../index.php');
        exit;
    }
} catch (Exception $e) {
    header('Location: ../index.php');
    exit;
}

$userId = $_SESSION['user_id'];

// Verify if the user already has this game in favorites
function comprobarJuegoFavorito($userId, $gameId)
{
    try {
        $sql = "SELECT COUNT(*) as count FROM USUARIOS_JUEGOS WHERE IDUSUARIO = ? AND IDJUEGO = ?";
        $result = DB::getOne($sql, [$userId, $gameId]);

        $count = isset($result['count']) ? (int) $result['count'] : 0;

        return $count > 0;
    } catch (Exception $e) {
        return false;
    }
}

// Add or remove game from favorites
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['toggle_favorite'])) {
    try {
        $esFavorito = comprobarJuegoFavorito($userId, $gameId);

        if ($esFavorito) {
            // Remove the game from favorites
            DB::executeQuery("DELETE FROM USUARIOS_JUEGOS WHERE IDUSUARIO = ? AND IDJUEGO = ?", [$userId, $gameId]);
            $_SESSION['mensaje'] = "Juego eliminado de favoritos";
        } else {
            // Add the game to favorites
            DB::executeQuery("INSERT INTO USUARIOS_JUEGOS (IDUSUARIO, IDJUEGO) VALUES (?, ?)", [$userId, $gameId]);
            $_SESSION['mensaje'] = "Juego agregado a favoritos";
        }

        // Redirect to the same page to prevent form resubmission
        header("Location: games.php?id=" . $gameId);
        exit;
    } catch (Exception $e) {

        $_SESSION['error'] = "Error al actualizar favoritos";
        header("Location: games.php?id=" . $gameId);
        exit;
    }
}

$esFavorito = comprobarJuegoFavorito($userId, $gameId);

// Obtain the posts related to this game
function obtenerPublicacionesPorJuego($gameId)
{
    try {
        $sql = "SELECT p.ID_PUBLICACION, p.CONTENIDO, p.URL, p.FECHA_CREACION, 
                 u.USUARIO, u.URL_FOTO AS USER_PHOTO, j.IDJUEGO,
                 j.JUEGO, c.CATEGORIA, c.ID_CATEGORIA,
                 j.URL_IMAGEN AS GAME_IMAGE,
                 (SELECT COUNT(*) FROM INTERACCIONES WHERE ID_PUBLICACION = p.ID_PUBLICACION AND TIPO = 'like') AS LIKES_COUNT,
                 (SELECT COUNT(*) FROM COMENTARIOS WHERE ID_PUBLICACION = p.ID_PUBLICACION) AS COMMENTS_COUNT
          FROM PUBLICACIONES_USUARIOS p
          JOIN USUARIO u ON p.IDUSUARIO = u.IDUSUARIO
          LEFT JOIN JUEGOS j ON p.IDJUEGO = j.IDJUEGO
          LEFT JOIN CATEGORIAS c ON j.ID_CATEGORIA = c.ID_CATEGORIA
          WHERE p.IDJUEGO = ?
          ORDER BY p.FECHA_CREACION DESC";

        return DB::getAll($sql, [$gameId]);
    } catch (Exception $e) {
        return [];
    }
}

$publicaciones = obtenerPublicacionesPorJuego($gameId);
$username = $_SESSION['username'];
$profileImage = getProfileImage($username);

// Auxiliary function to correct game image paths
function getCorrectGameImagePath($imagePath)
{
    if (empty($imagePath)) {
        return '../assets/App-images/default_game.png';
    }

    // If starts with ./ we convert it to ../
    if (strpos($imagePath, './') === 0) {
        return str_replace('./', '../', $imagePath);
    }

    // If it doesn't have a path prefix, we add ../
    if (!preg_match('/^(\/|http|\.\.\/|data:)/', $imagePath)) {
        return '../' . $imagePath;
    }

    return $imagePath;
}

// Función auxiliar para corregir rutas de imágenes de usuarios
function getCorrectUserImage($imagePath)
{
    if (empty($imagePath)) {
        return '../assets/App-images/default_profile.png';
    }

    // If starts with ./ we convert it to ../
    if (strpos($imagePath, './') === 0) {
        return str_replace('./', '../', $imagePath);
    }

    // If it doesn't have a path prefix, we add ../
    if (!preg_match('/^(\/|http|\.\.\/|data:)/', $imagePath)) {
        return '../' . $imagePath;
    }

    return $imagePath;
}

// Auxiliary function to correct post image paths
function getCorrectPostImage($imagePath)
{
    if (empty($imagePath)) {
        return '';
    }

    // If starts with ./ we convert it to ../
    if (strpos($imagePath, './') === 0) {
        return str_replace('./', '../', $imagePath);
    }

    // If it doesn't have a path prefix, we add ../
    if (!preg_match('/^(\/|http|\.\.\/|data:)/', $imagePath)) {
        return '../' . $imagePath;
    }

    return $imagePath;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($gameInfo['JUEGO']); ?> - Gameord</title>

    <link rel="shortcut icon" href="../assets/App-images/Gameord-logo.webp" type="image/x-icon">
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../node_modules/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/css/index.css">
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

            <!-- Icons -->
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

                <!-- User profile -->
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
                                        <small class="text-muted"><?php echo $_SESSION['user_email']; ?></small>
                                    </div>
                                </div>
                            </li>
                            <li><a class="dropdown-item py-2"
                                    href="./user.php?user=<?php echo urlencode($username); ?>"><i
                                        class="bi bi-person me-2"></i>Mi perfil</a></li>
                            <li><a class="dropdown-item py-2" href="./settings.php"><i
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

    <!-- Game Header -->
    <div class="container-fluid bg-light py-4 border-bottom">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-auto">
                    <img src="<?php echo getCorrectGameImagePath($gameInfo['URL_IMAGEN']); ?>"
                        alt="<?php echo htmlspecialchars($gameInfo['JUEGO']); ?>" class="rounded-3 shadow-sm"
                        style="width: 120px; height: 120px; object-fit: cover;"
                        onerror="this.src='../assets/App-images/default_game.png'">
                </div>
                <div class="col">
                    <h1 class="mb-2 text-primary fw-bold"><?php echo htmlspecialchars($gameInfo['JUEGO']); ?></h1>

                    <div class="mb-3">
                        <?php if ($gameInfo['CATEGORIA']) { ?>
                            <span class="badge bg-secondary me-2">
                                <i class="bi bi-controller me-1"></i><?php echo htmlspecialchars($gameInfo['CATEGORIA']); ?>
                            </span>
                        <?php } ?>
                        <?php if ($gameInfo['COMPAÑIA']) { ?>
                            <span class="badge bg-info">
                                <i class="bi bi-building me-1"></i><?php echo htmlspecialchars($gameInfo['COMPAÑIA']); ?>
                            </span>
                        <?php } ?>
                    </div>

                    <?php if ($gameInfo['DESCRIPCION']) { ?>
                        <p class="text-muted mb-3"><?php echo htmlspecialchars($gameInfo['DESCRIPCION']); ?></p>
                    <?php } ?>

                    <form method="post" class="d-inline">
                        <button type="submit" name="toggle_favorite"
                            class="btn <?php echo $esFavorito ? 'btn-warning' : 'btn-outline-warning'; ?>">
                            <i class="bi <?php echo $esFavorito ? 'bi-star-fill' : 'bi-star'; ?> me-2"></i>
                            <?php echo $esFavorito ? 'Eliminar de favoritos' : 'Agregar a favoritos'; ?>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-8">
                <?php if (empty($publicaciones)) { ?>
                    <div class="text-center py-5">
                        <i class="bi bi-joystick text-muted" style="font-size: 4rem;"></i>
                        <h3 class="text-muted mt-3">No hay publicaciones</h3>
                        <p class="text-muted">Aún no hay publicaciones sobre
                            <?php echo htmlspecialchars($gameInfo['JUEGO']); ?>.
                        </p>
                        <a href="../index.php" class="btn btn-primary">
                            <i class="bi bi-plus-circle me-2"></i>Crear primera publicación
                        </a>
                    </div>
                <?php } else { ?>
                    <?php foreach ($publicaciones as $publicacion) { ?>
                        <div class="card post-card mb-4 shadow-sm">
                            <div
                                class="card-header bg-transparent d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <img src="<?php echo getCorrectUserImage($publicacion['USER_PHOTO']); ?>"
                                        class="rounded-circle me-2 user-avatar" width="40" height="40" alt="User"
                                        onerror="this.src='../assets/App-images/default_profile.png'">
                                    <div>
                                        <h6 class="mb-0 fw-bold user-name">
                                            <a href="./user.php?user=<?php echo urlencode($publicacion['USUARIO']); ?>"
                                                class="text-decoration-none text-dark">
                                                <?php echo $publicacion['USUARIO']; ?>
                                            </a>
                                        </h6>
                                        <small
                                            class="text-muted post-date"><?php echo date("d-m-y H:i", strtotime($publicacion['FECHA_CREACION'])); ?></small>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center justify-content-end">
                                    <div class="d-flex align-items-center game-info me-3">
                                        <img src="<?php echo getCorrectGameImagePath($publicacion['GAME_IMAGE']); ?>"
                                            class="rounded-circle me-2 game-image" width="40" height="40" alt="Game">
                                        <div>
                                            <h6 class="mb-0 game-title">
                                                <a href="./games.php?id=<?php echo $publicacion['IDJUEGO'] ?? ''; ?>"
                                                    class="text-decoration-none text-dark">
                                                    <?php echo $publicacion['JUEGO']; ?>
                                                </a>
                                            </h6>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center game-info">
                                        <i class="bi bi-controller category-icon me-2"></i>
                                        <div>
                                            <h6 class="mb-0 game-title">
                                                <a href="./categories.php?id=<?php echo $publicacion['ID_CATEGORIA'] ?? ''; ?>"
                                                    class="text-decoration-none text-body-tertiary">
                                                    <?php echo $publicacion['CATEGORIA']; ?>
                                                </a>
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <?php if ($publicacion['URL'] != '') { ?>
                                    <?php if (in_array(strtolower(pathinfo($publicacion['URL'], PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'gif', 'webp'])) { ?>
                                        <div class="d-flex justify-content-center media-container">
                                            <img src="<?php echo getCorrectPostImage($publicacion['URL']); ?>"
                                                class="post-media img-fluid" alt="Post image" onerror="this.style.display='none'">
                                        </div>
                                    <?php } elseif (in_array(strtolower(pathinfo($publicacion['URL'], PATHINFO_EXTENSION)), ['mp4', 'webm', 'avi', 'mov'])) { ?>
                                        <div class="d-flex justify-content-center media-container">
                                            <video controls class="post-media">
                                                <source src="<?php echo getCorrectPostImage($publicacion['URL']); ?>" type="video/mp4">
                                                Tu navegador no soporta la reproducción de videos.
                                            </video>
                                        </div>
                                    <?php } ?>
                                <?php } ?>

                                <p class="card-text post-content mt-3">
                                    <?php echo htmlspecialchars($publicacion['CONTENIDO']); ?>
                                </p>
                            </div>

                            <div class="card-footer bg-white d-flex justify-content-between align-items-center">
                                <div class="post-stats d-flex align-items-center">
                                    <?php
                                    $likeado = comprobarLike($userId, $publicacion['ID_PUBLICACION']);
                                    $btnClass = $likeado ? 'like-btn-red' : 'like-btn';
                                    $iconClass = 'bi bi-heart';
                                    ?>
                                    <button class="btn btn-sm me-3 <?php echo $btnClass; ?>"
                                        onclick="toggleLike(this, <?php echo $userId; ?>, <?php echo $publicacion['ID_PUBLICACION']; ?>)"
                                        data-likeado="<?php echo $likeado ? '1' : '0'; ?>">
                                        <i class="<?php echo $iconClass; ?>"></i>
                                        <span class="ms-1 like-count"><?php echo $publicacion['LIKES_COUNT']; ?></span>
                                    </button>

                                    <button class="btn btn-sm btn-outline-secondary comment-btn"
                                        onclick="openCommentsModal(<?php echo $publicacion['ID_PUBLICACION']; ?>)">
                                        <i class="bi bi-chat"></i>
                                        <span class="ms-1"><?php echo $publicacion['COMMENTS_COUNT']; ?></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
    </div>

    <!-- Comments Modal -->
    <div class="modal fade" id="commentsModal" tabindex="-1" aria-labelledby="commentsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="commentsModalLabel">Comentarios</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <div class="comments-scroll-container px-3 py-2">
                        <!-- Comments will be loaded here -->
                        <div id="comments-container" class="mb-2">
                            <div class="text-center py-3">
                                <div class=" text-primary" role="status">
                                    <span class="visually-hidden">Cargando...</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form to add a new comment -->
                    <div class="comment-form-container px-3 py-3 border-top bg-white">
                        <form id="commentForm">
                            <input type="hidden" id="post_id" name="post_id" value="">
                            <div class="mb-2">
                                <textarea class="form-control" id="commentContent" name="content" rows="2"
                                    placeholder="Escribe tu comentario..." required></textarea>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">Comentar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Scripts -->
    <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/user_categories_games.js"></script>
</body>

</html>