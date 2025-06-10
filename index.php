<?php
// Include the session control file
require_once './includes/session_control.php';

// If there is no active session, redirect to login
if (!isset($_SESSION['user_id'])) {
  header('Location: ./pages/login.php');
  exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Gameord - Tu comunidad gamer</title>

  <link rel="shortcut icon" href="./assets/App-images/Gameord-logo.webp" type="image/x-icon">
  <link rel="stylesheet" href="./node_modules/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="./node_modules/bootstrap-icons/font/bootstrap-icons.css">
  <link rel="stylesheet" href="./assets/css/index.css">

</head>

<body>
  <!-- Navbar -->
  <header class="navbar navbar-expand-lg navbar-dark py-2 sticky-top">
    <div class="container-fluid">

      <div class="d-flex align-items-center">
        <!-- Logo and name -->
        <a class="navbar-brand d-flex align-items-center" href="index.php">
          <img src="./assets/App-images/Gameord-logo.webp" alt="Logo" class="me-2 rounded-2" height="40">
          <span class="fw-bold fs-4 d-none d-sm-inline">Gameord</span>
        </a>

        <button class="btn btn-outline-light d-lg-none ms-2" type="button" data-bs-toggle="modal" data-bs-target="#mobileMenuModal" title="Menú">
          <i class="bi bi-list fs-5"></i>
        </button>
      </div>


      <!-- Search -->
      <div class="position-relative d-none d-md-block mx-3 flex-grow-1">
        <i class="bi bi-search position-absolute search-icon"></i>
        <input type="text" id="searchInput" class="form-control search-box" 
        placeholder="Buscar juegos, categorías, usuarios..." aria-label="Buscar">
        <div id="searchResults" class="search-results-list d-none"></div>
      </div>

      <!-- Icons -->
      <ul class="navbar-nav d-flex align-items-center flex-row flex-nowrap">
        <!-- Search button mobile - visible only on small screens -->
        <li class="nav-item d-md-none mx-2">
          <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#searchModal" title="Buscar">
            <i class="bi bi-search nav-icon"></i>
          </a>
        </li>

        <!-- Chat -->
        <li class="nav-item mx-2">
          <a class="nav-link" href="./pages/chat.php" title="Chat">
            <i class="bi bi-chat nav-icon"></i>
          </a>
        </li>

        <!-- Notifications -->
        <li class="nav-item mx-2 position-static">
          <div class="dropdown">
            <a class="nav-link position-relative " href="#" id="Notificaciones" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
              <i class="bi bi-bell nav-icon"></i>
              <!-- Check if there are unread notifications -->
              <?php include 'includes/functions.php';
              if (obtenerNumeroNotificacionesNoLeidas($_SESSION['user_id']) > 0) { ?>
                <span class="position-absolute top-40 start-60 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6em;">
                  <?php
                  // Include the functions file
                  include_once('includes/functions.php');
                  // function to get the number of unread notifications
                  if (obtenerNumeroNotificacionesNoLeidas($_SESSION['user_id']) > 9) {
                    echo '9+';
                  } else {
                    echo obtenerNumeroNotificacionesNoLeidas($_SESSION['user_id']);
                  }
                  ?>
                  <span class="visually-hidden">notificaciones no leídas</span>
                </span>
              <?php } ?>
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0" aria-labelledby="Notificaciones" style="min-width: 300px; max-height: 400px; overflow-y: auto;">
              <?php
              // Include the functions file
              include_once('includes/functions.php');
              // function to get the notifications
              $notificaciones = obtenerNotificacionesNoLeidas($_SESSION['user_id']);

              // Check if there are notifications
              if (count($notificaciones) > 0) {
                foreach ($notificaciones as $notificacion) {
                  switch ($notificacion['TIPO']) {
                    case 'like':
                      $text = 'te ha dado un like a tu publicación';
                      break;
                    case 'comentario':
                      $text = 'ha comentado en tu publicación';
                      break;
                    case 'seguimiento':
                      $text = 'te ha seguido';
                      break;
                    case 'sistema':
                      $text = 'Tienes un mensaje del sistema';
                      break;
                    case 'mensaje':
                      $text = 'Te ha enviado un mensaje';
                      break;
                    default:
                      $text = 'te ha enviado una notificación';
                  }
                  echo '<li>
                        <a class="dropdown-item d-flex align-items-start py-3 px-3 border-bottom" href="#">
                          <div class="flex-shrink-0">
                            <img src="' . getProfileImage($notificacion['ORIGEN']) . '" alt="User" class="rounded-circle" width="40" height="40">
                          </div>
                          <div class="flex-grow-1 ms-3 overflow-hidden">
                            <p class="mb-1 text-wrap"><strong>' . $notificacion['ORIGEN'] . '</strong> ' . $text . '</p>
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
          <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#createPostModal" title="Crear publicación">
            <i class="bi bi-plus-circle nav-icon"></i>
          </a>
        </li>

        <!-- User profile and settings -->
        <li class="nav-item mx-2 position-static">
          <div class="dropdown">
            <a class="nav-link d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
              <?php
              // Get user profile image
              include_once('includes/functions.php');
              // function to get user profile image
              $profileImage = getProfileImage($_SESSION['username']);
              ?>
              <img src="<?php echo $profileImage; ?>" alt="User" class="rounded-circle me-1" width="32" height="32">
              <span class="d-none d-lg-block ms-1">
                <?php echo isset($_SESSION['username']) ? $_SESSION['username'] : 'Usuario'; ?>
              </span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0" aria-labelledby="userDropdown" style="min-width: 200px;">
              <li class="px-3 py-2 border-bottom">
                <div class="d-flex align-items-center">
                  <img src="<?php echo $profileImage; ?>" alt="User" class="rounded-circle me-2" width="40" height="40">
                  <div>
                    <div class="fw-bold"><?php echo $_SESSION['username']; ?></div>
                    <small class="text-muted"><?php echo $_SESSION['user_email']; ?></small>
                  </div>
                </div>
              </li>
              <li><a class="dropdown-item py-2" href="./pages/user.php?user=<?php echo urlencode($_SESSION['username']); ?>"><i class="bi bi-person me-2"></i>Mi perfil</a></li>
              <li><a class="dropdown-item py-2" href="./pages/settings.php"><i class="bi bi-gear me-2"></i>Configuración</a></li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li><a class="dropdown-item py-2 text-danger" href="./pages/logout.php"><i class="bi bi-box-arrow-right me-2"></i>Cerrar sesión</a></li>
            </ul>
          </div>
        </li>
      </ul>
    </div>
  </header>

  <!-- Modal for mobile menu -->
  <div class="modal fade" id="mobileMenuModal" tabindex="-1" aria-labelledby="mobileMenuModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header bg-gradient" style="background: linear-gradient(to right, var(--primary-color), var(--secondary-color));">
          <h5 class="modal-title text-white fw-bold" id="mobileMenuModalLabel">
            <i class="bi bi-controller me-2"></i>Explorar
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body p-0">
          <ul class="nav nav-tabs nav-fill border-0" id="mobileMenuTabs" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link active px-4 py-3 fw-semibold" id="categories-tab" data-bs-toggle="tab" data-bs-target="#categories-content" type="button" role="tab">
                <i class="bi bi-grid-3x3-gap-fill me-2"></i>Categorías
              </button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link px-4 py-3 fw-semibold" id="games-tab" data-bs-toggle="tab" data-bs-target="#games-content" type="button" role="tab">
                <i class="bi bi-joystick me-2"></i>Juegos
              </button>
            </li>
          </ul>

          <!-- Tabs Content -->
          <div class="tab-content" id="mobileMenuTabContent">
            <!-- Categorías Tab -->
            <div class="tab-pane fade show active" id="categories-content" role="tabpanel">
              <div class="p-3">
                <div class="row g-2" id="mobile-categories-container">
                  <!-- The categories will be loaded here dynamically -->
                </div>
              </div>
            </div>

            <!-- Games Tab -->
            <div class="tab-pane fade" id="games-content" role="tabpanel">
              <div class="p-3">
                <!-- Search bar for games -->
                <div class="mb-3">
                  <div class="input-group">
                    <span class="input-group-text bg-light border-end-0">
                      <i class="bi bi-search text-muted"></i>
                    </span>
                    <input type="text" id="mobile-games-search" class="form-control border-start-0" placeholder="Buscar juegos..." autocomplete="off">
                  </div>
                </div>

                <div class="row g-2" id="mobile-games-container" style="max-height: 400px; overflow-y: auto;">
                  <!-- The games will be loaded here dynamically -->
                </div>

                <!-- Loading indicator -->
                <div id="mobile-games-loading" class="text-center py-4 d-none">
                  <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Cargando...</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Search Modal for mobile -->
  <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="searchModalLabel">Buscar</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <i class="bi bi-search position-absolute search-icon ms-3"></i>
          <input type="text" id="searchInput2" class="form-control search-box" placeholder="Buscar juegos, categorías, usuarios..." aria-label="Buscar">
          <div id="searchResults2" class="search-results-list d-none"></div>
        </div>
      </div>
    </div>
  </div>

  <!-- Create Post Modal -->
  <div class="modal fade" id="createPostModal" tabindex="-1" aria-labelledby="createPostModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="createPostModalLabel">Crear publicación</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="createPostForm" action="includes/create_post.php" method="post" enctype="multipart/form-data">
            <div class="mb-3">
              <textarea class="form-control" id="postContent" name="postContent" rows="3" placeholder="¿Qué estás pensando?" required></textarea>
            </div>

            <div class="mb-3">
              <label class="form-label">Añadir foto o video</label>
              <div class="media-buttons">
                <button type="button" id="addPhotoBtn" class="media-btn add-photo-btn">
                  <i class="bi bi-image"></i> Añadir foto
                </button>
                <button type="button" id="addVideoBtn" class="media-btn add-video-btn">
                  <i class="bi bi-camera-video"></i> Añadir video
                </button>
              </div>
              <input class="form-control d-none" type="file" id="postMedia" name="postMedia" accept="image/*,video/*">
              <div class="file-limits-info">
                <small>Límites: Tamaño entre 1KB y 25MB. Duración máxima de videos: 2 minutos.</small>
              </div>
              <div id="mediaError" class="media-error d-none"></div>
              <div id="mediaPreview" class="preview-container mt-2 d-none">
                <img id="imagePreview" class="img-fluid rounded d-none" alt="Vista previa de la imagen">
                <video id="videoPreview" class="img-fluid rounded d-none" controls></video>
              </div>
            </div>

            <div class="mb-3 custom-datalist-container">
              <label for="gameSelect" class="form-label">Relacionar con un juego</label>
              <div class="position-relative">
                <select id="gameSelect" class="game-select" name="gameId" required>
                  <option value="">Selecciona un juego...</option>
                  <?php
                  include_once('includes/functions.php');
                  // Query to obtain all games
                  $juegos = obtenerJuegos();

                  // Show all games
                  foreach ($juegos as $juego) {
                    echo '<option value="' . $juego['IDJUEGO'] . '">' . $juego['JUEGO'] . '</option>';
                  }
                  ?>
                </select>
                <i class="bi bi-chevron-down select-arrow"></i>
              </div>
            </div>

            <div class="d-flex justify-content-end align-items-center">
              <button type="submit" class="btn btn-primary">Publicar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Main Content -->
  <div class="container-fluid">
    <div class="row">
      <!-- Sidebar Column - visible in lg and xl, hidden in sm and xs -->
      <div class="col-lg-3 d-none d-lg-block p-0 position-fixed ">
        <div class="sidebar-wrapper">
          <!-- Categories Section -->
          <div class="mx-3 mb-4 mt-3">
            <section class="sidebar-section">
              <h5 class="sidebar-header mb-3">Categorías</h5>
              <ul class="list-unstyled" id="categorias-lista">
                <?php
                include_once('includes/functions.php');
                // Query to obtain all categories
                $categorias = obtenerCategorias();

                // Define the maximum number of categories to display
                $categoriasVisibles = 6;
                $totalCategorias = count($categorias);

                // Show only some categories
                for ($i = 0; $i < min($categoriasVisibles, $totalCategorias); $i++) {
                  echo '<li><a href="./pages/categories.php?id=' . $categorias[$i]['ID_CATEGORIA'] . '" class="category-item" data-id="' . $categorias[$i]['ID_CATEGORIA'] . '"><i class="bi bi-controller category-icon"></i> ' . $categorias[$i]['CATEGORIA'] . '</a></li>';
                }
                ?>
              </ul>

              <?php if ($totalCategorias > $categoriasVisibles): ?>
                <!-- Hidden list of all categories -->
                <ul class="list-unstyled" id="categorias-todas" style="display: none;">
                  <?php
                  foreach ($categorias as $categoria) {
                    echo '<li><a href="./pages/categories.php?id=' . $categoria['ID_CATEGORIA'] . '" class="category-item" data-id="' . $categoria['ID_CATEGORIA'] . '"><i class="bi bi-controller category-icon"></i> ' . $categoria['CATEGORIA'] . '</a></li>';
                  }
                  ?>
                </ul>

                <!-- Button for showing/hiding all categories -->
                <div class="text-center mt-2">
                  <button class="btn btn-sm btn-outline-primary" id="btn-toggle-categorias">Ver más categorías</button>
                </div>
              <?php endif; ?>
            </section>
          </div>

          <!-- Games Section -->
          <div class="mx-3 mb-4">
            <section class="sidebar-section">
              <h5 class="sidebar-header mb-3">Juegos</h5>
              <ul class="list-unstyled" id="juegos-lista">
                <?php
                include_once('includes/functions.php');
                // Query to obtain all games
                $juegos = obtenerJuegos();

                // Define the maximum number of games to display
                $juegosVisibles = 6;
                $totalJuegos = count($juegos);

                // Show only some games
                for ($i = 0; $i < min($juegosVisibles, $totalJuegos); $i++) {
                  echo '<li><a href="./pages/games.php?id=' . $juegos[$i]['IDJUEGO'] . '" class="game-item" data-id="' . $juegos[$i]['IDJUEGO'] . '"><img src="' . $juegos[$i]['URL_IMAGEN'] . '" class="rounded-5 game-img" alt="Game image">' . $juegos[$i]['JUEGO'] . '</a></li>';
                }
                ?>
              </ul>

              <?php if ($totalJuegos > $juegosVisibles): ?>
                <!-- Hidden list of all games -->
                <ul class="list-unstyled" id="juegos-todos" style="display: none;">
                  <?php
                  foreach ($juegos as $juego) {
                    echo '<li><a href="./pages/games.php?id=' . $juego['IDJUEGO'] . '" class="game-item" data-id="' . $juego['IDJUEGO'] . '"><img src="' . $juego['URL_IMAGEN'] . '" class="rounded-5 game-img" alt="Game image">' . $juego['JUEGO'] . '</a></li>';
                  }
                  ?>
                </ul>

                <!-- Button for showing/hiding all games -->
                <div class="text-center mt-2">
                  <button class="btn btn-sm btn-outline-primary" id="btn-toggle-juegos">Ver más juegos</button>
                </div>
              <?php endif; ?>

            </section>
          </div>
        </div>
      </div>

      <!-- Main Content Column -->
      <div class="col-12 col-lg-9 offset-lg-3">
        <div class="main-content">
          <!-- Posts Section -->
          <section class="content-section">
            <?php if (count(obtenerPublicaciones()) <= 0) { ?>
              <div class="text-center">
                <p class="text-muted">No hay publicaciones para mostrar.</p>
              </div>
            <?php } else { ?>
              <?php foreach (obtenerPublicaciones() as $publicacion) { ?>
                <div class="card post-card mb-4 shadow-sm">
                  <div class="card-header bg-transparent d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between">
                    <div class="d-flex align-items-center">
                      <img src="<?php echo $publicacion['USER_PHOTO']; ?>" class="rounded-circle me-2 user-avatar" width="40" height="40" alt="User">
                      <div>
                        <h6 class="mb-0 fw-bold user-name">
                          <a href="./pages/user.php?user=<?php echo urlencode($publicacion['USUARIO']); ?>" class="text-decoration-none text-dark">
                            <?php echo $publicacion['USUARIO']; ?>
                          </a>
                        </h6>
                        <small class="text-muted post-date"><?php echo date("d-m-y", strtotime($publicacion['FECHA_CREACION'])); ?></small>
                      </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-end">
                      <div class="d-flex align-items-center game-info me-3">
                        <img src="<?php echo $publicacion['GAME_IMAGE']; ?>" class="rounded-circle me-2 game-image" width="40" height="40" alt="Game">
                        <div>
                          <h6 class="mb-0 game-title">
                            <a href="./pages/games.php?id=<?php echo $publicacion['IDJUEGO'] ?? ''; ?>" class="text-decoration-none text-dark">
                              <?php echo $publicacion['JUEGO']; ?>
                            </a>
                          </h6>
                        </div>
                      </div>
                      <div class="d-flex align-items-center game-info">
                        <i class="bi bi-controller category-icon me-2"></i>
                        <div>
                          <h6 class="mb-0 game-title">
                            <a href="./pages/categories.php?id=<?php echo $publicacion['ID_CATEGORIA'] ?? ''; ?>" class="text-decoration-none text-body-tertiary">
                              <?php echo $publicacion['CATEGORIA']; ?>
                            </a>
                          </h6>
                        </div>
                      </div>
                    </div>

                  </div>

                  <div class="card-body">
                    <?php if ($publicacion['URL'] != '') { ?>
                      <!-- Check if the file is an image -->
                      <?php if (in_array(strtolower(pathinfo($publicacion['URL'], PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'gif', 'webp'])) { ?>
                        <div class="d-flex justify-content-center media-container">
                          <img src="<?php echo $publicacion['URL']; ?>" class="post-media img-fluid" alt="Post image">
                        </div>
                        <!-- Check if the file is a video -->
                      <?php } elseif (in_array(strtolower(pathinfo($publicacion['URL'], PATHINFO_EXTENSION)), ['mp4', 'webm', 'avi', 'mov'])) { ?>
                        <div class="d-flex justify-content-center media-container">
                          <video controls class="post-media">
                            <source src="<?php echo $publicacion['URL']; ?>" type="video/mp4">
                            <source src="<?php echo $publicacion['URL']; ?>" type="video/webm">
                            <source src="<?php echo $publicacion['URL']; ?>" type="video/avi">
                            <source src="<?php echo $publicacion['URL']; ?>" type="video/quicktime">
                            Tu navegador no soporta la reproducción de videos.
                          </video>
                        </div>
                      <?php } ?>
                    <?php } ?>

                    <p class="card-text post-content mt-3"><?php echo $publicacion['CONTENIDO']; ?></p>
                  </div>

                  <div class="card-footer bg-white d-flex justify-content-between align-items-center">
                    <div class="post-stats d-flex align-items-center">

                      <?php
                      $likeado = comprobarLike($_SESSION['user_id'], $publicacion['ID_PUBLICACION']);
                      $btnClass = $likeado ? 'like-btn-red' : 'like-btn';
                      $iconClass = 'bi bi-heart'; // puedes cambiarlo a 'bi-heart-fill' si quieres
                      ?>
                      <button class="btn btn-sm me-3 <?php echo $btnClass; ?>"
                        onclick="toggleLike(this, <?php echo $_SESSION['user_id']; ?>, <?php echo $publicacion['ID_PUBLICACION']; ?>)"
                        data-likeado="<?php echo $likeado ? '1' : '0'; ?>">
                        <i class="<?php echo $iconClass; ?>"></i>
                        <span class="ms-1 like-count"><?php echo $publicacion['LIKES_COUNT']; ?></span>
                      </button>


                      <button class="btn btn-sm btn-outline-secondary comment-btn" onclick="openCommentsModal(<?php echo $publicacion['ID_PUBLICACION']; ?>)">
                        <i class="bi bi-chat"></i>
                        <span class="ms-1"><?php echo $publicacion['COMMENTS_COUNT']; ?></span>
                      </button>

                    </div>
                  </div>
                </div>
              <?php } ?>
            <?php } ?>

          </section>
        </div>
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
                <textarea class="form-control" id="commentContent" name="content" rows="2" placeholder="Escribe tu comentario..." required></textarea>
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
  <script src="./node_modules/bootstrap/dist/js/bootstrap.bundle.min.js">
  </script>
  <script src="./assets/js/index.js"></script>
</body>

</html>