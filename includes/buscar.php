<?php
require_once 'functions.php';

$term = isset($_POST['term']) ? trim($_POST['term']) : '';

if ($term === '') {
    echo json_encode([]);
    exit;
}

try {
    // Search users
    $usuarios = DB::getAll("SELECT USUARIO, URL_FOTO FROM USUARIO WHERE USUARIO LIKE ? LIMIT 5", ["%$term%"]);
    // Search games
    $juegos = DB::getAll("SELECT IDJUEGO, JUEGO, URL_IMAGEN FROM JUEGOS WHERE JUEGO LIKE ? LIMIT 5", ["%$term%"]);
    // Search categories
    $categorias = DB::getAll("SELECT ID_CATEGORIA, CATEGORIA FROM CATEGORIAS WHERE CATEGORIA LIKE ? LIMIT 5", ["%$term%"]);

    echo json_encode([
        'usuarios' => $usuarios,
        'juegos' => $juegos,
        'categorias' => $categorias
    ]);
} catch (Exception $e) {
    echo json_encode(['error' => 'Error en la búsqueda']);
}
