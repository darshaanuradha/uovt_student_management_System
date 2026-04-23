<?php
session_start();

// Default page
$page = $_GET['page'] ?? 'login';

// Whitelist (VERY IMPORTANT for security)
$allowed_pages = [
    'login',
    'dashboard'
];

// Validate page
if (!in_array($page, $allowed_pages)) {
    $page = '404';
}

// Authentication check
if (!isset($_SESSION['user_id']) && $page !== 'login') {
    header("Location: index.php?page=login");
    exit;
}

// Load page
switch ($page) {
    case 'login':
        require 'pages/login.php';
        break;

    case 'dashboard':
        require 'pages/dashboard.php';
        break;


    case 'logout':
        session_destroy();
        header("Location: index.php?page=login");
        exit;

    default:
        require 'pages/404.php';
        break;
}