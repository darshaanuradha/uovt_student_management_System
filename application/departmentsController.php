<?php
session_start();
require_once 'db.php';

try {

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {

        // ADD DEPARTMENT
        if ($_POST['action'] === 'add_department') {

            $dept_name = trim($_POST['dept_name']);

            if ($dept_name === '') {
                throw new Exception("Department name is required");
            }

            $stmt = $conn->prepare("CALL AddDepartment(?)");
            $stmt->bind_param("s", $dept_name);

            if (!$stmt->execute()) {
                throw new Exception($stmt->error);
            }

            $stmt->close();
            $conn->next_result();

            header("Location: ../presentation/index.php?page=departments&success=added");
            exit();
        }

        // EDIT DEPARTMENT (USE PROCEDURE)
        if ($_POST['action'] === 'edit_department') {

            $dept_id = intval($_POST['dept_id']);
            $dept_name = trim($_POST['dept_name']);

            if ($dept_name === '') {
                throw new Exception("Department name is required");
            }

            $stmt = $conn->prepare("CALL UpdateDepartment(?, ?)");
            $stmt->bind_param("is", $dept_id, $dept_name);

            if (!$stmt->execute()) {
                throw new Exception($stmt->error);
            }

            $stmt->close();
            $conn->next_result();

            header("Location: ../presentation/index.php?page=departments&success=updated");
            exit();
        }

        // DELETE DEPARTMENT (POST ONLY)
        if ($_POST['action'] === 'delete_department') {

            $dept_id = intval($_POST['id']);

            $stmt = $conn->prepare("CALL DeleteDepartment(?)");
            $stmt->bind_param("i", $dept_id);

            if (!$stmt->execute()) {
                throw new Exception($stmt->error);
            }

            $stmt->close();
            $conn->next_result();

            header("Location: ../presentation/index.php?page=departments&success=deleted");
            exit();
        }
    }
} catch (Exception $e) {

    header("Location: ../presentation/index.php?page=departments&error=1");
    exit();
}
