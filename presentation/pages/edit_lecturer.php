<?php
require_once '../application/db.php';

if (!isset($_GET['id'])) {
    echo "Invalid request";
    exit();
}

$id = $_GET['id'];
// echo $id;


$stmt = $conn->prepare("SELECT * FROM lecturers WHERE lecturer_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();
$lecturer = $result->fetch_assoc();

if (!$lecturer) {
    echo "Lecturer not found";
    exit();
}
?>

<div class="min-h-screen bg-gray-100 flex items-center justify-center py-10">

    <div class="w-full max-w-xl bg-white p-8 rounded-xl shadow-sm border">

        <h1 class="text-2xl font-semibold mb-6">Edit Lecturer</h1>

        <form action="../application/lecturerController.php" method="POST">

            <!-- Hidden ID -->
            <input type="hidden" name="lecturer_id" value="<?php echo $lecturer['lecturer_id']; ?>">

            <!-- Name -->
            <input type="text" name="name"
                value="<?php echo $lecturer['name']; ?>"
                class="w-full border p-2 mb-3" required>

            <!-- Email -->
            <input type="email" name="email"
                value="<?php echo $lecturer['email']; ?>"
                class="w-full border p-2 mb-3" required>

            <!-- Department -->
            <select name="department" class="w-full border p-2 mb-3">

                <?php
                $departments = $conn->query("SELECT * FROM departments");

                while ($dept = $departments->fetch_assoc()) {
                    $selected = ($dept['dept_id'] == $lecturer['dept_id']) ? "selected" : "";
                    echo "<option value='{$dept['dept_id']}' $selected>{$dept['dept_name']}</option>";
                }
                ?>

            </select>

            <button type="submit" name="update"
                class="bg-green-700 text-white px-4 py-2 rounded">
                Update Lecturer
            </button>

        </form>

    </div>

</div>