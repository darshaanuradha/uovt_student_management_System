<?php
session_start();
require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'])) {

    // Enroll an existing student into a course.
    if ($_POST['action'] === 'enroll_student') {
        // Cast IDs to integers to match schema types.
        $student_id = (int)$_POST['student_id'];
        $course_id = (int)$_POST['course_id'];

        if (empty($student_id) || empty($course_id)) {
            header("Location: ../presentation/enroll_student_form.php?error=empty");
            exit();
        }

        // Procedure runs enrollment logic transactionally.
        $stmt = $conn->prepare("CALL EnrollStudent(?, ?)");
        $stmt->bind_param("ii", $student_id, $course_id);

        if ($stmt->execute()) {
            header("Location: ../presentation/index.php?page=enroll_student_form&success=1");
        } else {
            header("Location: ../presentation/index.php?page=enroll_student_form&error=db");
        }
        $stmt->close();
    }

    // Remove a single enrollment record (unenroll).
    if ($_POST['action'] === 'delete_enrollment') {
        $enrollment_id = (int)$_POST['enrollment_id'];

        // Trigger updates course counts after an enrollment is deleted.
        $stmt = $conn->prepare("DELETE FROM enrollments WHERE enrollment_id=?");
        $stmt->bind_param("i", $enrollment_id);

        if ($stmt->execute()) {
            header("Location: ../presentation/index.php?page=enrollments&success=deleted");
        } else {
            header("Location: ../presentation/index.php?page=enrollments&error=db");
        }
        $stmt->close();
    }
}

$conn->close();
