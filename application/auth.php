<?php
session_start();
require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    echo "done";

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
    header("Location: ../presentation/index.php?page=login&error=invalidcredentials");
    $stmt->close();
}
$conn->close();
?>