<?php
require_once 'functions.php';

header('Content-Type: application/json');

try {
    // Obtaining all games
    $juegos = obtenerJuegos();

    // Formatting the data for the frontend
    $formattedGames = array_map(function ($juego) {
        return [
            'id' => $juego['IDJUEGO'],
            'name' => $juego['JUEGO'],
            'image' => $juego['URL_IMAGEN']
        ];
    }, $juegos);

    echo json_encode($formattedGames);
} catch (Exception $e) {
    error_log("Error en get_games.php: " . $e->getMessage());
    echo json_encode(['error' => 'Error al obtener los juegos']);
}
