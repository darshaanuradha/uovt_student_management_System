<?php
session_start();
require_once 'db.php';

// Guard: only authenticated Admins may manage courses
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Admin') {
    header('Location: ../presentation/index.php?page=login');
    exit();
}

$action = $_POST['action'] ?? $_GET['action'] ?? '';

// ── CREATE ────────────────────────────────────────────────────────────────────
if ($action === 'create') {
    $course_name = trim($_POST['course_name'] ?? '');
    $lecturer_id = (int)($_POST['lecturer_id'] ?? 0);

    if (empty($course_name) || $lecturer_id <= 0) {
        header('Location: ../presentation/index.php?page=coursesDepartments&error=validation');
        exit();
    }

    $stmt = $conn->prepare("CALL sp_insert_course(?, ?)");
    $stmt->bind_param("si", $course_name, $lecturer_id);
    $stmt->execute();
    $stmt->close();
    $conn->close();

    header('Location: ../presentation/index.php?page=coursesDepartments&success=created');
    exit();
}

// ── UPDATE ────────────────────────────────────────────────────────────────────
if ($action === 'update') {
    $course_id   = (int)($_POST['course_id'] ?? 0);
    $course_name = trim($_POST['course_name'] ?? '');
    $lecturer_id = (int)($_POST['lecturer_id'] ?? 0);

    if ($course_id <= 0 || empty($course_name) || $lecturer_id <= 0) {
        header('Location: ../presentation/index.php?page=coursesDepartments&error=validation');
        exit();
    }

    $stmt = $conn->prepare("CALL sp_update_course(?, ?, ?)");
    $stmt->bind_param("isi", $course_id, $course_name, $lecturer_id);
    $stmt->execute();
    $stmt->close();
    $conn->close();

    header('Location: ../presentation/index.php?page=coursesDepartments&success=updated');
    exit();
}

// ── DELETE ────────────────────────────────────────────────────────────────────
if ($action === 'delete') {
    $course_id = (int)($_GET['course_id'] ?? $_POST['course_id'] ?? 0);

    if ($course_id <= 0) {
        header('Location: ../presentation/index.php?page=coursesDepartments&error=invalid');
        exit();
    }

    $stmt = $conn->prepare("CALL sp_delete_course(?)");
    $stmt->bind_param("i", $course_id);
    $stmt->execute();
    $stmt->close();
    $conn->close();

    header('Location: ../presentation/index.php?page=coursesDepartments&success=deleted');
    exit();
}

// Fallback
if (isset($conn)) {
    $conn->close();
}
header('Location: ../presentation/index.php?page=coursesDepartments&error=unknownaction');
exit();
?>
