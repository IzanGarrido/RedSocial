<?php
// Incluir el archivo de control de sesiones
require_once './includes/session_control.php';

// Si no hay sesión activa, redirigir al login
// Si quieres que la página principal sea accesible sin iniciar sesión, comenta estas líneas
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
      <!-- Logo and name -->
      <a class="navbar-brand d-flex align-items-center" href="#">
        <img src="./assets/App-images/Gameord-logo.webp" alt="Logo" class="me-2 rounded-2" height="40">
        <span class="fw-bold fs-4 d-none d-sm-inline">Gameord</span>
      </a>

      <!-- Search - Hide on small screens, show on medium and up -->
      <div class="position-relative d-none d-md-block mx-3 flex-grow-1">
        <i class="bi bi-search position-absolute search-icon"></i>
        <input type="text" class="form-control search-box" placeholder="Buscar juegos, categorías, usuarios...">
      </div>

      <!-- Hamburger -->
      <button class="navbar-toggler ms-2" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Collapsible content -->
      <div class="collapse navbar-collapse flex-grow-0" id="navbarContent">
        <!-- Icons -->
        <ul class="navbar-nav d-flex align-items-center">
          <!-- Search button mobile - visible only on small screens -->
          <li class="nav-item d-md-none mx-1">
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
          <li class="nav-item mx-2">
            <div class="dropdown">
              <a class="nav-link" href="#" id="Notificaciones" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-bell nav-icon"></i>
                <span class="position-absolute top-15 start-25 translate-middle badge rounded-pill bg-danger">
                  3
                  <span class="visually-hidden">notificaciones no leídas</span>
                </span>
              </a>
              <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="Notificaciones" style="min-width: 300px;">
                <li class="px-3 py-2 bg-light fw-bold">Notificaciones</li>
                <li>
                  <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item d-flex align-items-center py-2" href="#">
                    <div class="flex-shrink-0">
                      <img src="./assets/App-images/Gameord-logo.webp" alt="User" class="rounded-circle" width="40">
                    </div>
                    <div class="flex-grow-1 ms-3">
                      <p class="mb-0"><strong>Usuario1</strong> comentó tu publicación</p>
                      <small class="text-muted">Hace 5 minutos</small>
                    </div>
                  </a></li>
                <li><a class="dropdown-item d-flex align-items-center py-2" href="#">
                    <div class="flex-shrink-0">
                      <img src="./assets/App-images/Gameord-logo.webp" alt="User" class="rounded-circle" width="40">
                    </div>
                    <div class="flex-grow-1 ms-3">
                      <p class="mb-0"><strong>Usuario2</strong> te envió una solicitud de amistad</p>
                      <small class="text-muted">Hace 2 horas</small>
                    </div>
                  </a></li>
                <li><a class="dropdown-item d-flex align-items-center py-2" href="#">
                    <div class="flex-shrink-0">
                      <img src="./assets/App-images/Gameord-logo.webp" alt="User" class="rounded-circle" width="40">
                    </div>
                    <div class="flex-grow-1 ms-3">
                      <p class="mb-0">¡Nuevo evento para <strong>Fortnite</strong>!</p>
                      <small class="text-muted">Hace 1 día</small>
                    </div>
                  </a></li>
                <li>
                  <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item text-center text-primary" href="#">Ver todas las notificaciones</a></li>
              </ul>
            </div>
          </li>
          <!-- Create post -->
          <li class="nav-item mx-2">
            <a class="nav-link" href="./pages/post.php" title="Crear publicación">
              <i class="bi bi-plus-circle nav-icon"></i>
            </a>
          </li>
          <!-- User profile and settings -->
          <li class="nav-item mx-2">
            <div class="dropdown">
              <a class="nav-link d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="./assets/App-images/Gameord-logo.webp" alt="User" class="rounded-circle me-1" width="32" height="32">
                <span class="d-none d-lg-block ms-1">
                  <?php echo isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'Usuario'; ?>
                </span>
              </a>
              <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                <li><a class="dropdown-item" href="./pages/profile.php"><i class="bi bi-person me-2"></i>Mi perfil</a></li>
                <li><a class="dropdown-item" href="./pages/settings.php"><i class="bi bi-gear me-2"></i>Configuración</a></li>
                <li><a class="dropdown-item" href="#"><i class="bi bi-people me-2"></i>Mis amigos</a></li>
                <li>
                  <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="./pages/logout.php"><i class="bi bi-box-arrow-right me-2"></i>Cerrar sesión</a></li>
              </ul>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </header>

  <!-- Search Modal for mobile -->
  <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="searchModalLabel">Buscar</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="input-group">
            <span class="input-group-text"><i class="bi bi-search"></i></span>
            <input type="text" class="form-control" placeholder="Buscar juegos, categorías, usuarios...">
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Sidebar Wrapper -->
  <div class="sidebar-wrapper">
    <!-- Categories Section -->
    <div class="mx-3 mb-4 mt-3">
      <section class="sidebar-section">
        <h5 class="sidebar-header mb-3">Categorías</h5>
        <ul class="list-unstyled" id="categorias-lista">
          <?php
          include_once('includes/functions.php');
          // Consulta para obtener todas las categorías
          $categorias = obtenerCategorias();

          // Definir cuántas categorías mostrar inicialmente
          $categoriasVisibles = 6;
          $totalCategorias = count($categorias);

          // Mostrar solo las primeras categorías
          for ($i = 0; $i < min($categoriasVisibles, $totalCategorias); $i++) {
            echo '<li><a href="#" class="category-item" data-id="' . $categorias[$i]['ID_CATEGORIA'] . '"><i class="bi bi-controller category-icon"></i> ' . $categorias[$i]['CATEGORIA'] . '</a></li>';
          }
          ?>
        </ul>

        <?php if ($totalCategorias > $categoriasVisibles): ?>
          <!-- Lista oculta con todas las categorías -->
          <ul class="list-unstyled" id="categorias-todas" style="display: none;">
            <?php
            foreach ($categorias as $categoria) {
              echo '<li><a href="#" class="category-item" data-id="' . $categoria['ID_CATEGORIA'] . '"><i class="bi bi-controller category-icon"></i> ' . $categoria['CATEGORIA'] . '</a></li>';
            }
            ?>
          </ul>

          <!-- Botón para mostrar/ocultar todas las categorías -->
          <div class="text-center mt-2">
            <button class="btn btn-sm btn-outline-primary" id="btn-toggle-categorias">Ver más categorías</button>
          </div>
        <?php endif; ?>
      </section>
    </div>

    <!-- Juegos Populares Section -->
    <div class="mx-3 mb-4">
      <section class="sidebar-section">
        <h5 class="sidebar-header mb-3">Juegos populares</h5>
        <ul class="list-unstyled" id="juegos-lista">
          <!-- Ejemplo de juegos, estos vendrían de la base de datos -->
          <li><a href="#" class="category-item" data-id="1"><i class="bi bi-joystick game-icon"></i> Fortnite</a></li>
          <li><a href="#" class="category-item" data-id="2"><i class="bi bi-joystick game-icon"></i> Minecraft</a></li>
          <li><a href="#" class="category-item" data-id="3"><i class="bi bi-joystick game-icon"></i> Call of Duty</a></li>
          <li><a href="#" class="category-item" data-id="4"><i class="bi bi-joystick game-icon"></i> FIFA 25</a></li>
        </ul>

        <!-- Lista oculta con todos los juegos, esto sería dinámico -->
        <ul class="list-unstyled" id="juegos-todos" style="display: none;">
          <li><a href="#" class="category-item" data-id="1"><i class="bi bi-joystick game-icon"></i> Fortnite</a></li>
          <li><a href="#" class="category-item" data-id="2"><i class="bi bi-joystick game-icon"></i> Minecraft</a></li>
          <li><a href="#" class="category-item" data-id="3"><i class="bi bi-joystick game-icon"></i> Call of Duty</a></li>
          <li><a href="#" class="category-item" data-id="4"><i class="bi bi-joystick game-icon"></i> FIFA 25</a></li>
          <li><a href="#" class="category-item" data-id="5"><i class="bi bi-joystick game-icon"></i> GTA V</a></li>
          <li><a href="#" class="category-item" data-id="6"><i class="bi bi-joystick game-icon"></i> League of Legends</a></li>
          <li><a href="#" class="category-item" data-id="7"><i class="bi bi-joystick game-icon"></i> Valorant</a></li>
          <li><a href="#" class="category-item" data-id="8"><i class="bi bi-joystick game-icon"></i> Overwatch</a></li>
        </ul>

        <!-- Botón para mostrar/ocultar todos los juegos -->
        <div class="text-center mt-2">
          <button class="btn btn-sm btn-outline-primary" id="btn-toggle-juegos">Ver más juegos</button>
        </div>
      </section>
    </div>
  </div>

  <!-- Main Content -->
  <div class="main-content">
    <!-- Posts Section -->
    <section class="content-section">
      <div class="card mb-3">
        <div class="card-header bg-transparent d-flex align-items-center">
          <img src="./assets/App-images/Gameord-logo.webp" class="rounded-circle me-2" width="40" height="40" alt="User">
          <div>
            <h6 class="mb-0">Usuario123</h6>
            <small class="text-muted">Hace 2 horas</small>
          </div>
        </div>
        <div class="card-body">
          <div class="d-flex justify-content-center">
            <img src="./assets/Games-logos/Rockstar Games/gta5-logo.webp" class="img-fluid rounded mb-3 w-50" alt="Post image">
          </div>
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus lacinia odio vitae vestibulum vestibulum.</p>
              <button class="btn btn-sm btn-outline-primary me-2"><i class="bi bi-heart"></i> 24</button>
              <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-chat"></i> 8</button>
            </div>
            <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-share"></i> Compartir</button>
          </div>
        </div>
      </div>

      <!-- Ejemplo de otra publicación -->
      <div class="card mb-3">
        <div class="card-header bg-transparent d-flex align-items-center">
          <img src="./assets/App-images/Gameord-logo.webp" class="rounded-circle me-2" width="40" height="40" alt="User">
          <div>
            <h6 class="mb-0">Usuario234</h6>
            <small class="text-muted">Hace 5 horas</small>
          </div>
        </div>
        <div class="card-body">
          <p class="card-text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Ut minima dolores, deserunt odit nostrum ex quia aspernatur, sit eum consectetur eaque sunt id vero voluptatem, libero quas? Dolores, aliquam vero!</p>
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <button class="btn btn-sm btn-outline-primary me-2"><i class="bi bi-heart"></i> 42</button>
              <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-chat"></i> 15</button>
            </div>
            <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-share"></i> Compartir</button>
          </div>
        </div>
      </div>
    </section>
  </div>

  <!-- Scripts -->
  <script src="./node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="./assets/js/index.js"></script>
</body>

</html>