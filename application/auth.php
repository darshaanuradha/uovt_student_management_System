<?php
session_start();
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../presentation/index.php?page=login');
    exit;
}

$action = $_POST['action'] ?? '';

if ($action === 'login') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email === '' || $password === '') {
        header('Location: ../presentation/index.php?page=login&error=1');
        exit;
    }

    $stmt = $conn->prepare('SELECT id, password FROM users WHERE email = ? LIMIT 1');
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $stmt->close();
            $conn->close();
            header('Location: ../presentation/index.php?page=dashboard');
            exit;
        }
    }

    $stmt->close();
    $conn->close();
    header('Location: ../presentation/index.php?page=login&error=1');
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