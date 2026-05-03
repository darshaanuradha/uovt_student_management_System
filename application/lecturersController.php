<?php

require_once 'db.php';

if (isset($_POST['formEkeNama'])) {
    if ($_POST['formEkeNama'] === 'add_lecturer') {
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $department = trim($_POST['department']);

        $stmt = $conn->prepare("CALL AddLecturer(?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $department);
        $stmt->execute();
        $stmt->close();
        header("Location: ../presentation/index.php?page=lecturers");
        exit();
    }

    if ($_POST['formEkeNama'] === 'edit_lecturer') {
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $department = trim($_POST['department']);
        $lecturer_id = trim($_POST['lecturer_id']);


        $stmt = $conn->prepare("UPDATE lecturers SET name = ?, email = ?, dept_id = ? WHERE lecturer_id = ?");
        $stmt->bind_param("sssi", $name, $email, $department, $lecturer_id);
        $stmt->execute();
        $stmt->close();
        header("Location: ../presentation/index.php?page=lecturers");
        exit();
    }
}


if ($_POST['action'] === 'delete') {
    $lecturer_id = trim($_POST['lecturer_id']);
    $stmt = $conn->prepare("DELETE FROM lecturers WHERE lecturer_id = ?");
    $stmt->bind_param("i", $lecturer_id);
    $stmt->execute();
    $stmt->close();
    header("Location: ../presentation/index.php?page=lecturers");
    exit();
}
