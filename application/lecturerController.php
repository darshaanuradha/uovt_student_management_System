<?php
require_once '../application/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $dept_id = trim($_POST['department']);  

    if ($name === '' || $email === '' || $dept_id === '') {
        header("Location: ../presentation/index.php?page=add_lecturer&error=Please fill in all fields");
        exit();
    }
    $stmt = $conn->prepare("INSERT INTO lecturers (name, email, dept_id) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $name, $email, $dept_id);
    $stmt->execute();
    $stmt->close();
    header("Location: ../presentation/index.php?page=lecturers");
    exit();
}
?>