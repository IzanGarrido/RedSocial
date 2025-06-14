<?php
session_start();
require_once 'functions.php';

// Function to add a like
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['user_id'] ?? null;
    $publicacionId = $_POST['publicacion_id'] ?? null;
    $accion = $_POST['accion'] ?? null;

    // Validate inputs
    if ($userId && $publicacionId) {
        if ($accion === 'dar') {
            $resultado = darLike($userId, $publicacionId);
        } else if ($accion === 'quitar') {
            $resultado = quitarLike($userId, $publicacionId);
        } else {
        }
        // Return the number of likes after the action
        $likes = obtenerNumeroLikes($publicacionId);
        echo json_encode(['success' => true, 'likes' => $likes]);
    } else {
        echo "Faltan datos";
    }
} else {
    echo "Método no permitido";
}