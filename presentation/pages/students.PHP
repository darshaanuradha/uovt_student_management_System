<?php
require_once '../application/studentcontroller.php';
$students = getAllStudents();
?>

<div class="bg-white border border-emerald-100 rounded-xl shadow-sm p-6 mb-6">
    <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
        <!-- LEFT SIDE -->
        <div>
            <h2 class="text-2xl font-bold text-emerald-800">
                Manage Students
            </h2>
            <p class="text-sm text-emerald-600 mt-1">
                View and manage registered students
            </p>
        </div>

        <!-- RIGHT SIDE -->
        <div class="flex items-center gap-4">
            <!-- STAT CARD -->
            <div class="bg-emerald-50 border border-emerald-200 rounded-lg px-4 py-2 text-center">
                <div class="text-xs text-emerald-600">Total Students</div>
                <div class="text-xl font-bold text-emerald-800">
                    <?= count($students) ?>
                </div>
            </div>

            <!-- ACTIONS -->
            <div class="flex flex-col items-end gap-2">
                <a href="index.php?page=student_add_form"
                    class="bg-emerald-600 text-white px-4 py-2 rounded-lg shadow hover:bg-emerald-700 transition font-semibold text-sm">
                    + Add New Student
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Alerts -->
<?php if (isset($_GET['success'])): ?>
    <div id="alertBox" class="bg-emerald-100 text-emerald-800 p-3 rounded mb-4 text-sm font-medium">
        Operation completed successfully.
    </div>
<?php elseif (isset($_GET['error'])): ?>
    <div id="alertBox" class="bg-red-100 text-red-800 p-3 rounded mb-4 text-sm font-medium">
        Error processing request.
    </div>
<?php endif; ?>

<!-- Table -->
<div class="overflow-x-auto bg-white rounded-lg shadow-sm border border-emerald-100">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-emerald-100 text-emerald-800">
                <th class="p-3 border-b">ID</th>
                <th class="p-3 border-b">First Name</th>
                <th class="p-3 border-b">Last Name</th>
                <th class="p-3 border-b">Email Address</th>
                <th class="p-3 border-b text-right">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($students)): ?>
                <?php foreach ($students as $row): ?>
                    <tr class="hover:bg-emerald-50/50 transition border-b border-emerald-50">
                        <td class="p-3 text-sm font-medium text-gray-500">
                            <?= htmlspecialchars($row['student_id']) ?>
                        </td>
                        <td class="p-3 text-sm text-gray-800 font-semibold">
                            <?= htmlspecialchars($row['first_name']) ?>
                        </td>
                        <td class="p-3 text-sm text-gray-800 font-semibold">
                            <?= htmlspecialchars($row['last_name']) ?>
                        </td>
                        <td class="p-3 text-sm text-gray-700">
                            <?= htmlspecialchars($row['contact_email']) ?>
                        </td>
                        <td class="p-3 text-right">
                            <div class="flex justify-end gap-2">
                                <a href="index.php?page=student_add_form&id=<?= $row['student_id'] ?>" 
                                   class="bg-blue-100 text-blue-700 px-3 py-1 rounded hover:bg-blue-200 transition font-semibold text-xs border border-blue-200">
                                    Edit
                                </a>
                                <form action="../application/studentcontroller.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this student?');" class="inline">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="student_id" value="<?= $row['student_id'] ?>">
                                    <button type="submit" class="bg-red-100 text-red-700 px-3 py-1 rounded hover:bg-red-200 transition font-semibold text-xs border border-red-200">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="p-4 text-center text-gray-500 italic">
                        No students found.
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Auto-hide alert -->
<script>
    setTimeout(function() {
        const alert = document.getElementById('alertBox');
        if (alert) {
            alert.style.transition = "opacity 0.5s ease";
            alert.style.opacity = "0";
            setTimeout(() => alert.remove(), 500);
        }
    }, 3000);
</script>
