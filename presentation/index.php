<?php
session_start();

$page = $_GET['page'] ?? 'login';

// If not logged in and trying to access a secure page, redirect to the router's login
if (!isset($_SESSION['user_id']) && $page !== 'login') {
    header("Location: index.php?page=login"); 
    exit;
}

$allowed_pages = [
    'login',
    'dashboard',
    'manageStudents',
    'enrollments',
    'coursesDepartmentslecturers',
    '404',
];

if (!in_array($page, $allowed_pages)) {
    $page = '404';
}

$content = "pages/$page.php";

// If it's the login page, just load the standalone file. 
// Otherwise, load the secure layout with the sidebar.
if ($page === 'login') {
    require $content;
} else {
    require 'layouts/main.php'; 
}
?>