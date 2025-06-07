<?php
session_start();
require_once 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['post_id'])) {
    $post_id = (int)$_POST['post_id'];
    echo mostrarComentarios($post_id);
} else {
    echo '<p class="text-muted">No se pudo cargar los comentarios.</p>';
}

// Function to get comments for a post
function obtenerComentarios($post_id)
{
    $sql = "SELECT c.ID_COMENTARIO, c.CONTENIDO, c.FECHA_COMENTARIO, 
                 u.USUARIO, u.URL_FOTO AS USER_PHOTO
          FROM COMENTARIOS c
          JOIN USUARIO u ON c.IDUSUARIO = u.IDUSUARIO
          WHERE c.ID_PUBLICACION = ?
          ORDER BY c.FECHA_COMENTARIO DESC";

    return DB::getAll($sql, [$post_id]);
}

// Auxiliary function to correct the user image path
function getCorrectUserImage($imagePath)
{
    if (empty($imagePath)) {
        return obtenerRutaBase() . '/assets/App-images/default_profile.png';
    }
    if (preg_match('/^(\/|http|data:)/', $imagePath)) {
        return $imagePath;
    }
    // If the path is relative, prepend the base path of the project
    return "../" . $imagePath;
}

// Function to display comments in HTML format
function mostrarComentarios($post_id)
{
    $comentarios = obtenerComentarios($post_id);
    $html = '';

    if (count($comentarios) <= 0) {
        $html .= '<div class="text-center py-3"><p class="text-muted">No hay comentarios para mostrar.</p></div>';
    } else {
        $html .= '<div class="comments-list">';
        foreach ($comentarios as $comentario) {
            $User_PHOTO = getCorrectUserImage($comentario['USER_PHOTO']);
            $html .= '<div class="card mb-2 shadow-sm">
                <div class="card-body py-2 px-3">
                    <div class="d-flex align-items-center">
                        <img src="' . $User_PHOTO . '" class="rounded-circle me-2 user-avatar" width="32" height="32" alt="User">
                        <div>
                            <h6 class="mb-0 fw-bold user-name">' . $comentario['USUARIO'] . '</h6>
                            <small class="text-muted comment-date">' . date("d-m-y", strtotime($comentario['FECHA_COMENTARIO'])) . '</small>
                        </div>
                    </div>
                    <p class="card-text comment-content mt-2 mb-1">' . htmlspecialchars($comentario['CONTENIDO']) . '</p>
                </div>
            </div>';
        }
        $html .= '</div>';
    }

    return $html;
}
