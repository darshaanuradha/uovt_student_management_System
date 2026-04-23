<?php
session_start();
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../presentation/index.php?page=login');
    exit;
}

$action = $_POST['action'] ?? '';

if ($action === 'login') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);


    if (empty($email) || empty($password)) {
        header("Location: ../presentation/index.php?page=login&error=emptyfields");
        exit();
    }

    $stmt = $conn->prepare("SELECT user_id, role, password_hash FROM system_users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        if (password_verify($password, $row['password_hash'])) {
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['role'] = $row['role'];
            header("Location: ../presentation/index.php?page=dashboard");
            exit();
        }
    }
    $stmt->close();
    $conn->close();
    header('Location: ../presentation/index.php?page=login&error=invalidcredentials');
    exit;
}

if ($action === 'logout') {
    $_SESSION = [];
    session_destroy();
    $conn->close();
    header('Location: ../presentation/index.php?page=login');
    exit;
}

$conn->close();
header('Location: ../presentation/index.php?page=login&error=1');
exit;
?>