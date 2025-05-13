<?php
// Include necessary files
require_once 'config.php';
require_once 'functions.php';
require_once 'session_control.php';

// Verify if there is an active session
if (!isset($_SESSION['user_id'])) {
    header('Location: ../pages/login.php');
    exit;
}

// Obtain the user ID from the session
$userId = $_SESSION['user_id'];

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtain the form data
    $contenido = isset($_POST['postContent']) ? trim($_POST['postContent']) : '';
    $gameId = !empty($_POST['gameId']) ? (int)$_POST['gameId'] : null;
    
    // Verify that there is content or a file
    if (empty($contenido) && empty($_FILES['postMedia']['name'])) {
        header('Location: ../index.php?error=empty_post');
        exit;
    }
    
    $archivo = isset($_FILES['postMedia']) && !empty($_FILES['postMedia']['name']) ? $_FILES['postMedia'] : null;
    $result = crearPublicacion($userId, $contenido, $archivo, $gameId);
    
} else {
    header('Location: ../index.php');
}
exit;