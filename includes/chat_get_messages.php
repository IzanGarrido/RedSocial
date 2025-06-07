<?php
session_start();
require_once 'functions.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'No hay sesión activa']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['error' => 'Método no permitido']);
    exit;
}

$contactId = isset($_POST['contact_id']) ? (int)$_POST['contact_id'] : 0;

if (!$contactId) {
    echo json_encode(['error' => 'ID de contacto requerido']);
    exit;
}

try {
    $userId = $_SESSION['user_id'];

    // Obtain messages between the two users
    $sql = "SELECT m.ID_MENSAJE, m.CONTENIDO, m.FECHA_MENSAJE, m.IDUSUARIO_ORIGEN,
                   u.USUARIO, u.URL_FOTO
            FROM MENSAJES m
            JOIN USUARIO u ON m.IDUSUARIO_ORIGEN = u.IDUSUARIO
            WHERE (m.IDUSUARIO_ORIGEN = ? AND m.IDUSUARIO_DESTINO = ?)
               OR (m.IDUSUARIO_ORIGEN = ? AND m.IDUSUARIO_DESTINO = ?)
            ORDER BY m.FECHA_MENSAJE ASC
            LIMIT 100";

    $mensajes = DB::getAll($sql, [$userId, $contactId, $contactId, $userId]);

    // Set messages as read for the current user
    DB::executeQuery(
        "UPDATE MENSAJES SET LEIDO = TRUE WHERE IDUSUARIO_ORIGEN = ? AND IDUSUARIO_DESTINO = ? AND LEIDO = FALSE",
        [$contactId, $userId]
    );

    //Function to correct image paths
    function correctImagePath($imagePath)
    {
        if (empty($imagePath)) {
            return '../assets/App-images/default_profile.png';
        }

        // If the path starts with ./ we convert it to ../
        if (strpos($imagePath, './') === 0) {
            return str_replace('./', '../', $imagePath);
        }

        // If the path does not start with /, http, or ../, we prepend ../
        if (strpos($imagePath, '/') !== 0 && strpos($imagePath, 'http') !== 0 && strpos($imagePath, '../') !== 0) {
            return '../' . $imagePath;
        }

        return $imagePath;
    }

    // Format messages for the frontend
    $mensajesFormateados = array_map(function ($mensaje) use ($userId) {
        return [
            'id' => $mensaje['ID_MENSAJE'],
            'contenido' => htmlspecialchars($mensaje['CONTENIDO']),
            'fecha' => date('d-m', strtotime($mensaje['FECHA_MENSAJE'])),
            'es_propio' => $mensaje['IDUSUARIO_ORIGEN'] == $userId,
            'usuario_origen' => $mensaje['USUARIO'],
            'foto_origen' => correctImagePath($mensaje['URL_FOTO'])
        ];
    }, $mensajes);

    echo json_encode(['success' => true, 'mensajes' => $mensajesFormateados]);
} catch (Exception $e) {
    echo json_encode(['error' => 'Error al obtener mensajes']);
}
