<?php
session_start();

$page = $_GET['page'] ?? 'login';

if (!isset($_SESSION['user_id']) && $page !== 'login') {
    header("Location: index.php?page=login");
    exit;
}

$allowed_pages = [
    'login',
    'dashboard',
    'manageStudents',
    'enrollments',
    'coursesDepartments',
    'course_add_form',
    'lecturers',
    '404',
];

if (!in_array($page, $allowed_pages)) {
    $page = '404';
}

$content = "pages/$page.php";


if ($page === 'login') {
    require $content;
} else {
    require 'layouts/main.php';
}
