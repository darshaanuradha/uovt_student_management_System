<?php
// departments_view.php
require_once '../application/db.php';
?>

<div class="max-w-6xl mx-auto">
    <!-- Header -->
    <div class="flex justify-between items-end mb-6 px-2">
        <div>
            <h2 class="text-3xl font-extrabold text-emerald-900 tracking-tight">Departments</h2>
            <p class="text-sm text-emerald-600 mt-1 font-medium">Manage academic departments</p>
        </div>
        <a href="index.php?page=add_department" class="bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold px-5 py-3 rounded-xl shadow transition">
            + Add Department
        </a>
    </div>

    <!-- Card -->
    <div class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-xl border border-white/50 overflow-hidden">

        <!-- Alerts -->
        <?php if (isset($_GET['success'])): ?>
            <div class="m-6 bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-2xl">
                Operation completed successfully.
            </div>
        <?php elseif (isset($_GET['error'])): ?>
            <div class="m-6 bg-red-50 border border-red-200 text-red-800 p-4 rounded-2xl">
                Operation failed. Please try again.
            </div>
        <?php endif; ?>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-emerald-600 text-white">
                    <tr>
                        <th class="px-6 py-4 text-left font-bold">#</th>
                        <th class="px-6 py-4 text-left font-bold">Department Name</th>
                        <th class="px-6 py-4 text-left font-bold">Description</th>
                        <th class="px-6 py-4 text-center font-bold">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    <?php
                    $result = $conn->query("SELECT department_id, department_name, description FROM departments ORDER BY department_name ASC");

                    if ($result && $result->num_rows > 0):
                        $i = 1;
                        while ($row = $result->fetch_assoc()):
                    ?>
                    <tr class="hover:bg-emerald-50 transition">
                        <td class="px-6 py-4 font-semibold text-gray-700"><?= $i++ ?></td>
                        <td class="px-6 py-4 font-medium text-gray-800">
                            <?= htmlspecialchars($row['department_name']) ?>
                        </td>
                        <td class="px-6 py-4 text-gray-600">
                            <?= htmlspecialchars($row['description']) ?>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex justify-center space-x-3">
                                <!-- Edit -->
                                <a href="index.php?page=edit_department&id=<?= $row['department_id'] ?>"
                                   class="bg-emerald-500 hover:bg-emerald-600 text-white px-4 py-2 rounded-lg font-semibold shadow">
                                    Edit
                                </a>

                                <!-- Delete -->
                                <form method="POST" action="../application/departmentsController.php"
                                      onsubmit="return confirm('Are you sure you want to delete this department?');">
                                    <input type="hidden" name="action" value="delete_department">
                                    <input type="hidden" name="department_id" value="<?= $row['department_id'] ?>">
                                    <button type="submit"
                                            class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg font-semibold shadow">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endwhile; else: ?>
                    <tr>
                        <td colspan="4" class="px-6 py-10 text-center text-gray-500 font-medium">
                            No departments found.
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>