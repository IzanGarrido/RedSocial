<?php
session_start();
require_once 'functions.php';

// Verify that there is an active session
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'No hay sesión activa']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $post_id = isset($_POST['post_id']) ? (int)$_POST['post_id'] : 0;
    $content = isset($_POST['content']) ? trim($_POST['content']) : '';
    $user_id = $_SESSION['user_id'];

    // Validate input
    if (empty($post_id) || empty($content)) {
        echo json_encode(['success' => false, 'message' => 'Faltan datos requeridos']);
        exit;
    }

    try {
        // Query to insert the comment
        $sql = "INSERT INTO COMENTARIOS (ID_PUBLICACION, IDUSUARIO, CONTENIDO) VALUES (?, ?, ?)";
        $params = [$post_id, $user_id, $content];
        $comment_id = DB::insert($sql, $params);

        if ($comment_id) {
            echo json_encode(['success' => true, 'message' => 'Comentario guardado correctamente']);

            // Function to add a notification
            addNotification(getUserIdByPostId($post_id), $user_id, "comentario");

        } else {
            echo json_encode(['success' => false, 'message' => 'Error al guardar el comentario']);
        }
    } catch (Exception $e) {
        error_log("Error al guardar comentario: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'Error en el servidor']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
}
