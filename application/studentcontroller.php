<?php
require_once __DIR__ . '/db.php';

// Function for views to fetch all students
if (!function_exists('getAllStudents')) {
    function getAllStudents() {
        global $conn;
        $students = [];
        $stmt = $conn->prepare("CALL sp_get_students()");
        if ($stmt) {
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result) {
                while ($row = $result->fetch_assoc()) {
                    $students[] = $row;
                }
            }
            $stmt->close();
            while($conn->more_results() && $conn->next_result()) { /* flush */ }
        }
        return $students;
    }
}
?>
