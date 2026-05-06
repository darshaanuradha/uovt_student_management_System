<?php
require_once '../application/studentcontroller.php';

/* ================= SEARCH LOGIC ================= */
$search = $_GET['search'] ?? '';

if (!empty($search)) {
    $students = searchStudents($search);
} else {
    $students = getAllStudents();
}
?>

<!-- ══════════════════════════════════════════════════════════ PAGE HEADER -->
<div class="mb-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

        <div>
            <h1 class="text-2xl font-bold text-emerald-900 tracking-tight">Manage Students</h1>
            <p class="text-sm text-emerald-600 mt-1">View and manage registered students</p>
        </div>

        <div class="flex items-center gap-4">

            <!-- SEARCH BAR -->
            <form method="GET" class="flex items-center gap-2">
                <input type="hidden" name="page" value="students">

                <input type="text"
                    name="search"
                    value="<?= htmlspecialchars($search) ?>"
                    placeholder="Search students..."
                    class="px-4 py-2 border border-emerald-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-emerald-500">

                <button type="submit"
                    class="px-4 py-2 bg-emerald-600 text-white rounded-xl hover:bg-emerald-700">
                    Search
                </button>

                <?php if (!empty($search)): ?>
                    <a href="index.php?page=students"
                        class="px-4 py-2 bg-gray-200 text-gray-700 rounded-xl hover:bg-gray-300">
                        Clear
                    </a>
                <?php endif; ?>
            </form>

            <!-- TOTAL BADGE -->
            <div class="bg-white rounded-xl border border-emerald-100 shadow-sm px-4 py-2 flex items-center gap-3">
                <span class="text-xs text-emerald-500 font-medium uppercase tracking-wider">Total</span>
                <span class="text-lg font-bold text-emerald-900"><?= count($students) ?></span>
            </div>

            <!-- ADD BUTTON -->
            <a href="index.php?page=student_add_form"
                class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 active:scale-95
                       text-white font-semibold px-5 py-2.5 rounded-xl shadow-md shadow-emerald-200
                       transition-all duration-200">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                </svg>
                Add New Student
            </a>

        </div>
    </div>
</div>

<!-- ══════════════════════════════════════════════════════════ SEARCH RESULT INFO -->
<?php if (!empty($search)): ?>
    <div class="mb-4 text-sm text-emerald-700">
        Search results for: <strong><?= htmlspecialchars($search) ?></strong>
    </div>
<?php endif; ?>

<!-- ══════════════════════════════════════════════════════════ ALERTS -->
<?php if (isset($_GET['success'])): ?>
    <div id="alertBox" class="flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 px-5 py-4 rounded-xl mb-6 shadow-sm">
        <span class="text-sm font-medium">Operation completed successfully.</span>
    </div>

<?php elseif (isset($_GET['error'])): ?>
    <div id="alertBox" class="flex items-center gap-3 bg-red-50 border border-red-200 text-red-800 px-5 py-4 rounded-xl mb-6 shadow-sm">
        <span class="text-sm font-medium">Error processing request. Please try again.</span>
    </div>
<?php endif; ?>

<!-- ══════════════════════════════════════════════════════════ TABLE -->
<div class="bg-white rounded-2xl border border-emerald-100 shadow-sm overflow-hidden">

    <div class="px-6 py-4 border-b border-emerald-50">
        <h2 class="text-sm font-semibold text-emerald-800 uppercase tracking-wider">All Students</h2>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">

            <thead>
                <tr class="bg-emerald-50/70 text-emerald-600 uppercase text-xs tracking-wider">
                    <th class="px-6 py-3">ID</th>
                    <th class="px-6 py-3">First Name</th>
                    <th class="px-6 py-3">Last Name</th>
                    <th class="px-6 py-3">Email</th>
                    <th class="px-6 py-3 text-center">Actions</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-emerald-50">

                <?php if (!empty($students)): ?>
                    <?php foreach ($students as $row): ?>
                        <tr class="hover:bg-emerald-50/40 transition">

                            <td class="px-6 py-4 text-emerald-500 font-mono text-xs">
                                <?= htmlspecialchars($row['student_id']) ?>
                            </td>

                            <td class="px-6 py-4 font-semibold text-emerald-900">
                                <?= htmlspecialchars($row['first_name']) ?>
                            </td>

                            <td class="px-6 py-4 font-semibold text-emerald-900">
                                <?= htmlspecialchars($row['last_name']) ?>
                            </td>

                            <td class="px-6 py-4 text-emerald-600">
                                <?= htmlspecialchars($row['contact_email']) ?>
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex justify-center gap-2">

                                    <a href="index.php?page=student_add_form&id=<?= $row['student_id'] ?>"
                                        class="px-3 py-1.5 text-xs bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-lg hover:bg-emerald-600 hover:text-white">
                                        Edit
                                    </a>

                                    <form action="../application/studentcontroller.php" method="POST"
                                        onsubmit="return confirm('Delete this student?');">

                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="student_id" value="<?= $row['student_id'] ?>">

                                        <button type="submit"
                                            class="px-3 py-1.5 text-xs bg-red-50 text-red-600 border border-red-200 rounded-lg hover:bg-red-500 hover:text-white">
                                            Delete
                                        </button>
                                    </form>

                                </div>
                            </td>

                        </tr>
                    <?php endforeach; ?>

                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center py-10 text-emerald-400 italic">
                            No students found.
                        </td>
                    </tr>
                <?php endif; ?>

            </tbody>
        </table>
    </div>
</div>

<!-- AUTO HIDE ALERT -->
<script>
    setTimeout(() => {
        const alert = document.getElementById('alertBox');
        if (alert) {
            alert.style.opacity = "0";
            setTimeout(() => alert.remove(), 400);
        }
    }, 3500);
</script>