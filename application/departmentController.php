<?php
session_start();
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {

    /* ===============================
       ADD NEW DEPARTMENT
    ================================ */
    if ($_POST['action'] === 'add_department') {

        $department_name = trim($_POST['department_name']);
        $description     = trim($_POST['description']);

        if (empty($department_name)) {
            header("Location: ../presentation/index.php?page=add_department&error=empty");
            exit();
        }

        // Check for duplicate department name
        $checkStmt = $conn->prepare(
            "SELECT department_id FROM departments WHERE department_name = ?"
        );
        $checkStmt->bind_param("s", $department_name);
        $checkStmt->execute();
        $checkStmt->store_result();

        if ($checkStmt->num_rows > 0) {
            $checkStmt->close();
            header("Location: ../presentation/index.php?page=add_department&error=duplicate");
            exit();
        }
        $checkStmt->close();

        // Insert department
        $stmt = $conn->prepare(
            "INSERT INTO departments (department_name, description) VALUES (?, ?)"
        );
        $stmt->bind_param("ss", $department_name, $description);

        if ($stmt->execute()) {
            header("Location: ../presentation/index.php?page=departments&success=added");
        } else {
            header("Location: ../presentation/index.php?page=add_department&error=db");
        }
        $stmt->close();
    }

    /* ===============================
       UPDATE EXISTING DEPARTMENT
    ================================ */
    elseif ($_POST['action'] === 'update_department') {

        $department_id   = (int) $_POST['department_id'];
        $department_name = trim($_POST['department_name']);
        $description     = trim($_POST['description']);

        if (empty($department_id) || empty($department_name)) {
            header("Location: ../presentation/index.php?page=departments&error=invalid");
            exit();
        }

        // Prevent duplicate names (excluding itself)
        $checkStmt = $conn->prepare(
            "SELECT department_id FROM departments 
             WHERE department_name = ? AND department_id != ?"
        );
        $checkStmt->bind_param("si", $department_name, $department_id);
        $checkStmt->execute();
        $checkStmt->store_result();

        if ($checkStmt->num_rows > 0) {
            $checkStmt->close();
            header(
                "Location: ../presentation/index.php?page=edit_department&id=$department_id&error=duplicate"
            );
            exit();
        }
        $checkStmt->close();

        // Update record
        $stmt = $conn->prepare(
            "UPDATE departments 
             SET department_name = ?, description = ?
             WHERE department_id = ?"
        );
        $stmt->bind_param("ssi", $department_name, $description, $department_id);

        if ($stmt->execute()) {
            header("Location: ../presentation/index.php?page=departments&success=updated");
        } else {
            header(
                "Location: ../presentation/index.php?page=edit_department&id=$department_id&error=db"
            );
        }
        $stmt->close();
    }

    /* ===============================
       DELETE DEPARTMENT
    ================================ */
    elseif ($_POST['action'] === 'delete_department') {

        $department_id = (int) $_POST['department_id'];

        if (empty($department_id)) {
            header("Location: ../presentation/index.php?page=departments&error=invalid");
            exit();
        }

        /**
         * OPTIONAL SAFETY (recommended):
         * Prevent deleting a department that has courses
         * Uncomment once courses.department_id exists
         */
        /*
        $checkCourses = $conn->prepare(
            "SELECT course_id FROM courses WHERE department_id = ?"
        );
        $checkCourses->bind_param("i", $department_id);
        $checkCourses->execute();
        $checkCourses->store_result();

        if ($checkCourses->num_rows > 0) {
            $checkCourses->close();
            header("Location: ../presentation/index.php?page=departments&error=hascourses");
            exit();
        }
        $checkCourses->close();
        */

        // Delete department
        $stmt = $conn->prepare(
            "DELETE FROM departments WHERE department_id = ?"
        );
        $stmt->bind_param("i", $department_id);

        if ($stmt->execute()) {
            header("Location: ../presentation/index.php?page=departments&success=deleted");
        } else {
            header("Location: ../presentation/index.php?page=departments&error=db");
        }
        $stmt->close();
    }
}

$conn->close();









