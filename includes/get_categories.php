<?php
require_once 'functions.php';

header('Content-Type: application/json');

try {
    // Obtaining categories from the database
    $categorias = obtenerCategorias();

    // Formting the data for the frontend
    $formattedCategories = array_map(function ($categoria) {
        return [
            'id' => $categoria['ID_CATEGORIA'],
            'name' => $categoria['CATEGORIA'],
            'icon' => 'bi-controller'
        ];
    }, $categorias);

    echo json_encode($formattedCategories);
} catch (Exception $e) {
    error_log("Error en get_categories.php: " . $e->getMessage());
    echo json_encode(['error' => 'Error al obtener las categorías']);
}
