<?php
require_once 'db.php';

// DELETE (GET request)
if (isset($_GET['action']) && $_GET['action'] === 'delete') {

    if (!isset($_GET['id'])) {
        echo "Invalid request";
        exit();
    }

    $id = $_GET['id'];

    $stmt = $conn->prepare("DELETE FROM lecturers WHERE lecturer_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    header("Location: ../presentation/index.php?page=lecturers");
    exit();
}



if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //  UPDATE
    if (isset($_POST['update'])) {

        $id = $_POST['lecturer_id'];
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $dept_id = trim($_POST['department']);

        $stmt = $conn->prepare("UPDATE lecturers SET name=?, email=?, dept_id=? WHERE lecturer_id=?");
        $stmt->bind_param("ssii", $name, $email, $dept_id, $id);
        $stmt->execute();
        $stmt->close();

    } 
    //  INSERT
    else {

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
    }

    header("Location: ../presentation/index.php?page=lecturers");
    exit();
}
?>