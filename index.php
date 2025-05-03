<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Gameord</title>

    <link rel="shortcut icon" href="./assets/App-images/Gameord-logo.webp" type="image/x-icon">
    <link rel="stylesheet" href="./node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./node_modules/bootstrap-icons/font/bootstrap-icons.css">

    <script src="./node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>


</head>

<header class="navbar navbar-expand-lg navbar-dark bg-primary py-2 sticky-top">
  <div class="container-fluid">
    <!-- Logo and name -->
    <a class="navbar-brand d-flex align-items-center" href="#">
      <img src="./assets/App-images/Gameord-logo.webp" alt="Logo" class="me-2 rounded-2" height="40">
      <span class="fw-bold fs-4 d-lg-block d-none">Gameord</span>
    </a>
    
    <!-- Search -->
    <div class="position-relative mx-3 flex-grow-1 ">
      <i class="bi bi-search position-absolute text-muted" style="top: 7px; left: 12px;"></i>
      <input type="text" class="form-control ps-5" placeholder="Buscar">
    </div>
    
    <!-- Hamburger -->
    <button class="navbar-toggler ms-2" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <!-- Collapable content -->
    <div class="collapse navbar-collapse flex-grow-0" id="navbarContent">
      <!-- Icons -->
      <ul class="navbar-nav d-flex align-items-center">
        <!-- Chat -->
        <li class="nav-item mx-1 mx-lg-2">
          <a class="nav-link" href="./pages/chat.php" title="Chat">
            <i class="bi bi-chat fs-4"></i>
          </a>
        </li>
        <!-- Notifications -->
        <li class="nav-item mx-1 mx-lg-2">
          <div class="dropdown">
            <a class="nav-link dropdown-toggle" href="" id="Notificaciones" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="bi bi-headset fs-4"></i>
            </a>
            <ul class="dropdown-menu" aria-labelledby="Notificaciones">
              <li><a class="dropdown-item-text text-decoration-none" href="">Sin notificaciones</a></li>
            </ul>
          </div>
        </li>
        <!-- Create post -->
        <li class="nav-item mx-1 mx-lg-2">
          <a class="nav-link" href="./pages/post.php" title="Crear">
            <i class="bi bi-plus-circle fs-4"></i>
          </a>
        </li>
        <!-- User profile and settings -->
        <li class="nav-item mx-1 mx-lg-2">
          <div class="dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="bi bi-person-circle fs-4"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
              <li><a class="dropdown-item" href="./pages/profile.php">Mi perfil</a></li>
              <li><a class="dropdown-item" href="#">Configuración</a></li>
              <li><a class="dropdown-item" href="#">Cambiar de cuenta</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="./pages/register.php">Cerrar sesión</a></li>
            </ul>
          </div>
        </li>
      </ul>
    </div>
  </div>
</header>

<body>

</body>

<footer>

</footer>

</html>