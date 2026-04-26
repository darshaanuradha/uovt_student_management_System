<?php
require_once __DIR__ . '/db.php';

$action = $_REQUEST['action'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($action === 'add') {
        $firstName = trim($_POST['first_name'] ?? '');
        $lastName = trim($_POST['last_name'] ?? '');
        $email = trim($_POST['contact_email'] ?? '');

        if (!empty($firstName) && !empty($lastName) && !empty($email)) {
            $stmt = $conn->prepare("CALL sp_insert_student(?, ?, ?)");
            if ($stmt) {
                try {
                    $stmt->bind_param("sss", $firstName, $lastName, $email);
                    $stmt->execute();
                    $stmt->close();
                    while($conn->more_results()) { $conn->next_result(); }
                    header("Location: ../presentation/index.php?page=students&success=added");
                    exit();
                } catch (mysqli_sql_exception $e) {
                    if ($e->getCode() == 1062) { // 1062 is Duplicate entry for key
                        header("Location: ../presentation/index.php?page=student_add_form&error=duplicate_email");
                        exit();
                    }
                    throw $e;
                }
            }
        }
        header("Location: ../presentation/index.php?page=students&error=invalid_data");
        exit();
    }
}
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
