<?php
require_once '../includes/config.php';
require_once '../includes/session_control.php';

// Logout
logoutUser();

// Redirect to login
header('Location: login.php');
exit;
