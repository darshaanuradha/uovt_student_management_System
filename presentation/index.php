<?php
session_start();
require_once '../application/db.php';
$page = $_GET['page'] ?? 'dashboard';

if (!isset($_SESSION['user_id']) && $page !== 'login') {
    header("Location: index.php?page=login");
    exit;
}

$content = "pages/$page.php";

if ($page === 'login') {
    require $content;
} else {
    require 'layouts/main.php';
}
