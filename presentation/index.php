<?php
session_start();

$page = $_GET['page'] ?? 'login';

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
