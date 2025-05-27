<?php
session_start();
require_once 'functions.php';

header('Content-Type: application/json');

// Log for debug
error_log("chat_send_message.php - Inicio");

if (!isset($_SESSION['user_id'])) {
    error_log("No hay sesión activa");
    echo json_encode(['success' => false, 'error' => 'No hay sesión activa']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    error_log("Método no permitido: " . $_SERVER['REQUEST_METHOD']);
    echo json_encode(['success' => false, 'error' => 'Método no permitido']);
    exit;
}

$contact = isset($_POST['contact']) ? $_POST['contact'] : '';
$mensaje = isset($_POST['mensaje']) ? trim($_POST['mensaje']) : '';

error_log("Datos recibidos - contact: $contact, mensaje: $mensaje");

if (!$contact || empty($mensaje)) {
    error_log("Datos incompletos - contact: $contact, mensaje: $mensaje");
    echo json_encode(['success' => false, 'error' => 'Datos incompletos']);
    exit;
}

try {
    $userId = $_SESSION['user_id'];

    // The contact can be a user ID or a username
    $contactId = null;

    // If is numeric, it is an ID
    if (is_numeric($contact)) {
        $contactId = (int)$contact;
        // Verify that the user exists
        $contactRow = DB::getOne("SELECT IDUSUARIO FROM USUARIO WHERE IDUSUARIO = ?", [$contactId]);
    } else {
        $contactRow = DB::getOne("SELECT IDUSUARIO FROM USUARIO WHERE USUARIO = ?", [$contact]);
        if ($contactRow) {
            $contactId = $contactRow['IDUSUARIO'];
        }
    }

    if (!$contactRow || !$contactId) {
        error_log("Usuario no encontrado: $contact");
        echo json_encode(['success' => false, 'error' => 'Usuario no encontrado']);
        exit;
    }

    error_log("Usuario encontrado - contactId: $contactId");

    // Insert the message into the database
    $sql = "INSERT INTO MENSAJES (IDUSUARIO_ORIGEN, IDUSUARIO_DESTINO, CONTENIDO) VALUES (?, ?, ?)";
    $params = [$userId, $contactId, $mensaje];
    $mensajeId = DB::insert($sql, $params);

    if ($mensajeId) {
        // Create notification
        if ($contactId != $userId) {
            addNotification($contactId, $userId, 'mensaje');
        }

        error_log("Mensaje enviado correctamente - ID: $mensajeId");
        echo json_encode([
            'success' => true,
            'mensaje_id' => $mensajeId,
            'fecha' => date('H:i')
        ]);
    } else {
        error_log("Error al insertar mensaje en la base de datos");
        echo json_encode(['success' => false, 'error' => 'Error al enviar el mensaje']);
    }
} catch (Exception $e) {
    error_log("Error en chat_send_message.php: " . $e->getMessage());
    echo json_encode(['success' => false, 'error' => 'Error del servidor: ' . $e->getMessage()]);
}
