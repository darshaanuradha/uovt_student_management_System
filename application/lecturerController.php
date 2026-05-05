<?php
require_once 'db.php';

// DELETE
if (isset($_GET['action']) && $_GET['action'] === 'delete') {

    if (!isset($_GET['id'])) {
        exit("Invalid request");
    }

    $id = (int) $_GET['id'];

    $stmt = $conn->prepare("CALL delete_lecturer(?)");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    $conn->next_result();

    header("Location: ../presentation/index.php?page=lecturers&success=deleted");
    exit();
}


// POST (INSERT / UPDATE)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $dept_id = (int) $_POST['department'];

    if ($name === '' || $email === '' || $dept_id === 0) {
        header("Location: ../presentation/index.php?page=add_lecturer&error=empty");
        exit();
    }

    // UPDATE
    if (isset($_POST['update'])) {

        $id = (int) $_POST['lecturer_id'];

        $stmt = $conn->prepare("CALL update_lecturer(?, ?, ?, ?)");
        $stmt->bind_param("issi", $id, $name, $email, $dept_id);
        $stmt->execute();
        $stmt->close();
        $conn->next_result();

        header("Location: ../presentation/index.php?page=lecturers&success=updated");
    }

    // INSERT
    else {

        $stmt = $conn->prepare("CALL insert_lecturer(?, ?, ?)");
        $stmt->bind_param("ssi", $name, $email, $dept_id);
        $stmt->execute();
        $stmt->close();

        header("Location: ../presentation/index.php?page=lecturers&success=created");
    }

    exit();
}
