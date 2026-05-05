<?php
$totalResult = $conn->query("SELECT COUNT(*) AS total FROM view_departments");
$totalRow = $totalResult->fetch_assoc();
$totalDepartments = $totalRow['total'];

$departments = $conn->query("SELECT * FROM view_departments ORDER BY dept_name ASC");
?>

<!-- ══════════════════════════════════════════════════════════ PAGE HEADER -->
<div class="mb-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-emerald-900 tracking-tight">Departments</h1>
            <p class="text-sm text-emerald-600 mt-1">Manage and organize departments in the system</p>
        </div>
        <div class="flex items-center gap-4">
            <div class="bg-white rounded-xl border border-emerald-100 shadow-sm px-4 py-2 flex items-center gap-3">
                <span class="text-xs text-emerald-500 font-medium uppercase tracking-wider">Total</span>
                <span class="text-lg font-bold text-emerald-900"><?= $totalDepartments ?></span>
            </div>
            <a href="index.php?page=add_department"
                class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 active:scale-95
                       text-white font-semibold px-5 py-2.5 rounded-xl shadow-md shadow-emerald-200
                       transition-all duration-200">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                </svg>
                New Department
            </a>
        </div>
    </div>
</div>

<!-- ══════════════════════════════════════════════════════════ ALERTS -->
<?php if (isset($_GET['success'])): ?>
    <div id="alertBox" class="flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 px-5 py-4 rounded-xl mb-6 shadow-sm">
        <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
        </svg>
        <span class="text-sm font-medium">Operation completed successfully.</span>
    </div>
<?php elseif (isset($_GET['error'])): ?>
    <div id="alertBox" class="flex items-center gap-3 bg-red-50 border border-red-200 text-red-800 px-5 py-4 rounded-xl mb-6 shadow-sm">
        <svg class="w-5 h-5 text-red-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
        <span class="text-sm font-medium">Something went wrong. Please try again.</span>
    </div>
<?php endif; ?>

<!-- ══════════════════════════════════════════════════════════ TABLE -->
<div class="bg-white rounded-2xl border border-emerald-100 shadow-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-emerald-50 flex items-center justify-between">
        <h2 class="text-sm font-semibold text-emerald-800 uppercase tracking-wider">All Departments</h2>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead>
                <tr class="bg-emerald-50/70 text-emerald-600 uppercase text-xs tracking-wider">
                    <th class="px-6 py-3 font-semibold">Department Name</th>
                    <th class="px-6 py-3 font-semibold text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-emerald-50">
                <?php if ($departments && $departments->num_rows > 0): ?>
                    <?php while ($department = $departments->fetch_assoc()): ?>
                        <tr class="hover:bg-emerald-50/40 transition-colors duration-150">
                            <td class="px-6 py-4 font-semibold text-emerald-900">
                                <?= htmlspecialchars($department['dept_name']) ?>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="index.php?page=edit_department&id=<?= $department['dept_id'] ?>"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium
                                          bg-emerald-50 text-emerald-700 border border-emerald-200
                                          hover:bg-emerald-600 hover:text-white hover:border-emerald-600 transition-all">
                                        Edit
                                    </a>
                                    <form method="POST" action="../application/departmentsController.php" onsubmit="return confirm('Delete this department? This cannot be undone.');">
                                        <input type="hidden" name="action" value="delete_department">
                                        <input type="hidden" name="id" value="<?= $department['dept_id'] ?>">
                                        <button type="submit"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium
                                                   bg-red-50 text-red-600 border border-red-200
                                                   hover:bg-red-500 hover:text-white hover:border-red-500 transition-all">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="2" class="text-center py-10 text-emerald-400 italic">No departments found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    setTimeout(() => {
        const alert = document.getElementById('alertBox');
        if (alert) {
            alert.style.transition = "all 0.4s ease";
            alert.style.opacity = "0";
            setTimeout(() => alert.remove(), 400);
        }
    }, 3500);
</script>