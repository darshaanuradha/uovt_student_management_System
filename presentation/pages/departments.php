<?php
$totalResult = $conn->query("SELECT COUNT(*) AS total FROM view_departments");
$totalRow = $totalResult->fetch_assoc();
$totalDepartments = $totalRow['total'];

$departments = $conn->query("SELECT * FROM view_departments ORDER BY dept_name ASC");
?>

<div class="max-w-6xl mx-auto">

    <!-- HEADER -->
    <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 mb-6 px-2">

        <!-- LEFT -->
        <div>
            <h2 class="text-3xl font-extrabold text-emerald-900 tracking-tight">
                Departments
            </h2>
            <p class="text-sm text-emerald-600 mt-1 font-medium">
                Manage and organize departments in the system.
            </p>
        </div>

        <!-- RIGHT -->
        <div class="flex items-center gap-4">

            <!-- STAT CARD -->
            <div class="bg-emerald-50 border border-emerald-200 rounded-xl px-5 py-3 text-center shadow-sm">
                <div class="text-xs text-emerald-600 font-semibold">Total</div>
                <div class="text-2xl font-bold text-emerald-800">
                    <?= $totalDepartments ?>
                </div>
            </div>

            <!-- ACTIONS -->
            <div class="flex flex-col items-end gap-2">

                <a href="index.php?page=add_department"
                    class="bg-gradient-to-r from-emerald-600 to-emerald-500 text-white px-5 py-2 rounded-xl shadow-lg hover:from-emerald-700 hover:to-emerald-600 transition font-semibold text-sm">
                    + New Department
                </a>

                <a href="index.php?page=dashboard"
                    class="text-emerald-700 hover:text-emerald-900 text-sm font-semibold">
                    ← Back to Dashboard
                </a>

            </div>

        </div>

    </div>

    <!-- ALERT -->
    <?php if (isset($_GET['success'])): ?>
        <div id="alertBox" class="flex items-start bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-2xl mb-6 shadow-sm">
            <div class="bg-emerald-500 rounded-full p-1 mr-3 mt-0.5">
                ✓
            </div>
            <div class="text-sm font-medium">
                Operation completed successfully.
            </div>
        </div>
    <?php elseif (isset($_GET['error'])): ?>
        <div id="alertBox" class="flex items-start bg-red-50 border border-red-200 text-red-800 p-4 rounded-2xl mb-6 shadow-sm">
            <div class="bg-red-500 rounded-full p-1 mr-3 mt-0.5 text-white">
                !
            </div>
            <div class="text-sm font-medium">
                Something went wrong.
            </div>
        </div>
    <?php endif; ?>

    <!-- TABLE CARD -->
    <div class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-xl border border-white/50 overflow-hidden relative">

        <!-- Glow Effect -->
        <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-br from-emerald-100 to-transparent rounded-full opacity-50 blur-3xl pointer-events-none -mr-20 -mt-20"></div>

        <div class="overflow-x-auto relative z-10">
            <table class="w-full text-left">

                <!-- HEAD -->
                <thead>
                    <tr class="bg-emerald-100 text-emerald-800 text-sm uppercase">
                        <th class="px-6 py-4">Department Name</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>

                <!-- BODY -->
                <tbody class="divide-y divide-emerald-50">

                    <?php if ($departments && $departments->num_rows > 0): ?>
                        <?php while ($department = $departments->fetch_assoc()): ?>

                            <tr class="hover:bg-emerald-50/60 transition">

                                <td class="px-6 py-4 font-semibold text-gray-800">
                                    <?= htmlspecialchars($department['dept_name']) ?>
                                </td>

                                <td class="px-6 py-4 text-right">

                                    <div class="flex justify-end gap-2">

                                        <!-- EDIT -->
                                        <a href="index.php?page=edit_department&id=<?= $department['dept_id'] ?>"
                                            class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1.5 rounded-lg text-xs font-semibold shadow">
                                            Edit
                                        </a>

                                        <!-- DELETE (POST SAFE) -->
                                        <form method="POST"
                                            action="../application/departmentsController.php"
                                            onsubmit="return confirm('Delete this department?');">

                                            <input type="hidden" name="action" value="delete_department">
                                            <input type="hidden" name="id" value="<?= $department['dept_id'] ?>">

                                            <button type="submit"
                                                class="bg-red-100 text-red-700 px-3 py-1.5 rounded-lg text-xs font-semibold border border-red-200 hover:bg-red-200 transition">
                                                Delete
                                            </button>
                                        </form>

                                    </div>

                                </td>

                            </tr>

                        <?php endwhile; ?>
                    <?php else: ?>

                        <!-- EMPTY STATE -->
                        <tr>
                            <td colspan="2" class="text-center py-10 text-gray-400 italic">
                                No departments found.
                            </td>
                        </tr>

                    <?php endif; ?>

                </tbody>

            </table>
        </div>
    </div>
</div>

<!-- AUTO HIDE ALERT -->
<script>
    setTimeout(() => {
        const alert = document.getElementById('alertBox');
        if (alert) {
            alert.style.transition = "all 0.4s ease";
            alert.style.opacity = "0";
            alert.style.transform = "translateY(-10px)";
            setTimeout(() => alert.remove(), 400);
        }
    }, 3000);
</script>