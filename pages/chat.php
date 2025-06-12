<?php
// Include the session control file
require_once '../includes/session_control.php';

// Check if there is an active session
checkSession();

// Include functions for database operations
require_once '../includes/functions.php';

// Get user information
$userId = $_SESSION['user_id'];
$username = $_SESSION['username'];
$profileImage = getProfileImage($username);

// Get contacts (users with message history)
$contactsQuery = "SELECT DISTINCT 
    CASE 
        WHEN m.IDUSUARIO_ORIGEN = ? THEN m.IDUSUARIO_DESTINO 
        ELSE m.IDUSUARIO_ORIGEN 
    END AS contact_id,
    u.USUARIO, 
    u.URL_FOTO,
    MAX(m.FECHA_MENSAJE) as ultima_fecha
FROM MENSAJES m
JOIN USUARIO u ON u.IDUSUARIO = CASE 
    WHEN m.IDUSUARIO_ORIGEN = ? THEN m.IDUSUARIO_DESTINO 
    ELSE m.IDUSUARIO_ORIGEN 
END
WHERE m.IDUSUARIO_ORIGEN = ? OR m.IDUSUARIO_DESTINO = ?
GROUP BY contact_id, u.USUARIO, u.URL_FOTO
ORDER BY ultima_fecha DESC";

$contacts = DB::getAll($contactsQuery, [$userId, $userId, $userId, $userId]);


function getCorrectProfileImage($profileUrl)
{
    if (empty($profileUrl)) {
        return '../assets/App-images/default_profile.png';
    }

    // If the URL starts with ./, we replace it with ../
    if (strpos($profileUrl, './') === 0) {
        return str_replace('./', '../', $profileUrl);
    }
    if (!strpos($profileUrl, '/') === 0 && !strpos($profileUrl, 'http') === 0) {
        return '../' . $profileUrl;
    }

    return $profileUrl;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Chat - Gameord</title>

    <link rel="shortcut icon" href="../assets/App-images/Gameord-logo.webp" type="image/x-icon">
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../node_modules/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/css/index.css">
    <link rel="stylesheet" href="../assets/css/chat.css">

</head>

<body>
    <!-- Navbar -->
    <header class="navbar navbar-expand-lg navbar-dark py-2 sticky-top">
        <div class="container-fluid">
            <div class="d-flex align-items-center">
                <!-- Logo y nombre -->
                <a class="navbar-brand d-flex align-items-center" href="../index.php">
                    <img src="../assets/App-images/Gameord-logo.webp" alt="Logo" class="me-2 rounded-2" height="40">
                    <span class="fw-bold fs-4 d-none d-sm-inline">Gameord</span>
                </a>
            </div>
            <ul class="navbar-nav d-flex align-items-center flex-row flex-nowrap">

                <!-- Chat (active) -->
                <li class="nav-item mx-2">
                    <a class="nav-link" href="#" title="Chat">
                        <i class="bi bi-chat-fill nav-icon" style="color: var(--accent-color) !important;"></i>
                    </a>
                </li>

                <!-- Notifications -->
                <li class="nav-item mx-2 position-static">
                    <div class="dropdown">
                        <a class="nav-link position-relative" href="#" id="Notificaciones" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                            <i class="bi bi-bell nav-icon"></i>
                            <?php if (obtenerNumeroNotificacionesNoLeidas($userId) > 0) { ?>
                                <span class="position-absolute top-40 start-60 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6em;">
                                    <?php echo obtenerNumeroNotificacionesNoLeidas($userId) > 9 ? '9+' : obtenerNumeroNotificacionesNoLeidas($userId); ?>
                                    <span class="visually-hidden">notificaciones no leídas</span>
                                </span>
                            <?php } ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0" aria-labelledby="Notificaciones" style="min-width: 300px; max-height: 400px; overflow-y: auto;">
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
                        <a class="nav-link d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                            <img src="<?php echo $profileImage; ?>" alt="User" class="rounded-circle me-1" width="32" height="32">
                            <span class="d-none d-lg-block ms-1"><?php echo $username; ?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0" aria-labelledby="userDropdown" style="min-width: 200px;">
                            <li class="px-3 py-2 border-bottom">
                                <div class="d-flex align-items-center">
                                    <img src="<?php echo $profileImage; ?>" alt="User" class="rounded-circle me-2" width="40" height="40">
                                    <div>
                                        <div class="fw-bold"><?php echo $username; ?></div>
                                        <small class="text-muted"><?php echo $_SESSION['user_email']; ?></small>
                                    </div>
                                </div>
                            </li>
                            <li><a class="dropdown-item py-2" href="/user.php?user=<?php echo urlencode($_SESSION['username']); ?>"><i class="bi bi-person me-2"></i>Mi perfil</a></li>
                            <li><a class="dropdown-item py-2" href="../pages/settings.php"><i class="bi bi-gear me-2"></i>Configuración</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item py-2 text-danger" href="../pages/logout.php"><i class="bi bi-box-arrow-right me-2"></i>Cerrar sesión</a></li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </header>

    <!-- Chat Container -->
    <div class="chat-container">
        <!-- Contacts Sidebar -->
        <div class="contacts-sidebar" id="contactsSidebar">
            <div class="contacts-header">
                <h5 class="mb-3 fw-bold text-primary">
                    <i class="bi bi-chat-dots me-2"></i>Mensajes
                </h5>
                <div class="position-relative">
                    <i class="bi bi-search position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #6c757d;"></i>
                    <input type="text" id="searchContacts" class="form-control search-contacts" placeholder="Buscar contactos..." style="padding-left: 35px;">
                </div>
            </div>

            <div class="contacts-list" id="contactsList">
                <?php
                if (empty($contacts)) {
                    echo '<div class="text-center py-4">
                            <i class="bi bi-chat-square-text text-muted" style="font-size: 3rem;"></i>
                            <p class="text-muted mt-2">No tienes conversaciones aún</p>
                            <small class="text-muted">Busca usuarios arriba para empezar a chatear</small>
                          </div>';
                } else {
                    foreach ($contacts as $contact) {
                        // Obtain the last message with this contact
                        $lastMessageQuery = "SELECT CONTENIDO, FECHA_MENSAJE 
                           FROM MENSAJES 
                           WHERE (IDUSUARIO_ORIGEN = ? AND IDUSUARIO_DESTINO = ?) 
                              OR (IDUSUARIO_ORIGEN = ? AND IDUSUARIO_DESTINO = ?)
                           ORDER BY FECHA_MENSAJE DESC 
                           LIMIT 1";
                        $lastMessage = DB::getOne($lastMessageQuery, [$userId, $contact['contact_id'], $contact['contact_id'], $userId]);

                        // Count unread messages from this contact
                        $unreadQuery = "SELECT COUNT(*) as unread_count 
                       FROM MENSAJES 
                       WHERE IDUSUARIO_ORIGEN = ? AND IDUSUARIO_DESTINO = ? AND LEIDO = FALSE";
                        $unreadResult = DB::getOne($unreadQuery, [$contact['contact_id'], $userId]);
                        $unreadCount = $unreadResult['unread_count'] ?? 0;

                        // Edit profile image URL
                        $profileImage = $contact['URL_FOTO'];
                        if (empty($profileImage)) {
                            $profileImage = '../assets/App-images/default_profile.png';
                        } else if (strpos($profileImage, './') === 0) {
                            $profileImage = str_replace('./', '../', $profileImage);
                        }

                        $lastMessageContent = $lastMessage ? htmlspecialchars(substr($lastMessage['CONTENIDO'], 0, 50) . (strlen($lastMessage['CONTENIDO']) > 50 ? '...' : '')) : 'Sin mensajes';

                        echo '<div class="contact-item" 
                        data-contact-id="' . $contact['contact_id'] . '"
                        data-contact-name="' . htmlspecialchars($contact['USUARIO']) . '"
                        data-contact-image="' . $profileImage . '"
                        onclick="selectContact(' . $contact['contact_id'] . ', \'' . htmlspecialchars($contact['USUARIO']) . '\', \'' . $profileImage . '\')">
                        <img src="' . $profileImage . '" alt="' . htmlspecialchars($contact['USUARIO']) . '" class="contact-avatar">
                        <div class="contact-info">
                            <div class="contact-name">' . htmlspecialchars($contact['USUARIO']) . '</div>
                            <div class="contact-preview">' . $lastMessageContent . '</div>
                        </div>
                        <div class="d-flex flex-column align-items-end">';

                        if ($unreadCount > 0) {
                            echo '<div class="unread-badge">' . $unreadCount . '</div>';
                        }

                        echo '</div>
              </div>';
                    }
                }
                ?>
            </div>
        </div>

        <!-- Chat Area -->
        <div class="chat-area">
            <!-- Chat Header -->
            <div class="chat-header">
                <button class="btn btn-link mobile-menu-btn d-md-none p-0 me-3" onclick="toggleSidebar()">
                    <i class="bi bi-list fs-4" style="color: var(--primary-color);"></i>
                </button>

                <div class="chat-user-info">
                    <img src="../assets/App-images/default_profile.png" alt="Usuario" class="chat-avatar" id="chatAvatar">
                    <div>
                        <div class="chat-user-name" id="chatUserName">Selecciona una conversación</div>
                    </div>
                </div>

            </div>

            <!-- Messages Container -->
            <div class="messages-container" id="messagesContainer">
                <div class="empty-chat">
                    <i class="bi bi-chat-square-text"></i>
                    <p>Bienvenido a tu chat</p>
                    <small>Selecciona una conversación de la izquierda o busca un usuario para empezar</small>
                </div>
            </div>

            <!-- Message Input -->
            <div class="message-input-container">
                <form class="message-input-form" id="messageForm" onsubmit="sendMessage(event)">
                    <input type="hidden" id="currentContactId" value="">

                    <button type="button" class="btn btn-link p-0" title="Buscar usuarios" onclick="toggleUserSearch()">
                        <i class="bi bi-person-plus fs-5" style="color: var(--primary-color);"></i>
                    </button>

                    <input type="text"
                        id="messageInput"
                        class="form-control message-input "
                        placeholder="Selecciona una conversación o busca un usuario para empezar a chatear"
                        onkeydown="handleKeyPress(event)"
                        
                        disabled>

                    <button type="submit" class="send-button" title="Enviar mensaje" disabled>
                        <i class="bi bi-send"></i>
                    </button>
                </form>

                <!-- Search users dropdown -->
                <div id="userSearchDropdown" class="position-absolute w-100 bg-white border rounded shadow-sm" style="bottom: 70px; display: none; z-index: 1000;">
                    <div class="p-3">
                        <input type="text" id="userSearchInput" class="form-control mb-2" placeholder="Buscar usuarios..." oninput="searchUsers(this.value)">
                        <div id="userSearchResults"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Scripts -->
        <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
        <script src="../assets/js/chat.js"></script>

</body>

</html>