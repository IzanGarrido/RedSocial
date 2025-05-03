<?php
// Incluir el archivo de control de sesiones
require_once '../includes/config.php';
require_once '../includes/session_control.php';

// Cerrar la sesión
logoutUser();

// Redirigir al login
header('Location: login.php');
exit;
