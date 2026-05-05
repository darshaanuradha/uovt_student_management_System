<?php
$lecturers = $conn->query("SELECT * FROM lecturer_departments_view");
?>

<div class="min-h-full flex flex-col pb-10">

    <!-- ══════════════════════════════════════════════════════════ PAGE HEADER -->
    <div class="mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-emerald-900 tracking-tight">Manage Lecturers</h1>
                <p class="text-sm text-emerald-600 mt-1">View and manage registered lecturers</p>
            </div>

            <div class="flex items-center gap-4">
                <!-- Stat Badge -->
                <div class="bg-white rounded-xl border border-emerald-100 shadow-sm px-4 py-2 flex items-center gap-3">
                    <span class="text-xs text-emerald-500 font-medium uppercase tracking-wider">Total</span>
                    <span class="text-lg font-bold text-emerald-900"><?php echo $lecturers->num_rows; ?></span>
                </div>

                <!-- Action Button -->
                <a href="../presentation/index.php?page=add_lecturer"
                    class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 active:scale-95
                           text-white font-semibold px-5 py-2.5 rounded-xl shadow-md shadow-emerald-200
                           transition-all duration-200">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                    </svg>
                    Add Lecturer
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
            <span class="text-sm font-medium">Error processing request. Please try again.</span>
        </div>
    <?php endif; ?>

    <!-- ══════════════════════════════════════════════════════════ TABLE -->
    <div class="bg-white rounded-2xl border border-emerald-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-emerald-50 flex items-center justify-between">
            <h2 class="text-sm font-semibold text-emerald-800 uppercase tracking-wider">All Lecturers</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead>
                    <tr class="bg-emerald-50/70 text-emerald-600 uppercase text-xs tracking-wider">
                        <th class="px-6 py-3 font-semibold">ID</th>
                        <th class="px-6 py-3 font-semibold">Name</th>
                        <th class="px-6 py-3 font-semibold">Email</th>
                        <th class="px-6 py-3 font-semibold">Department</th>
                        <th class="px-6 py-3 font-semibold text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-emerald-50">
                    <?php if ($lecturers && $lecturers->num_rows > 0): ?>
                        <?php while ($lecturer = $lecturers->fetch_assoc()) : ?>
                            <tr class="hover:bg-emerald-50/40 transition-colors duration-150">

                                <!-- ID -->
                                <td class="px-6 py-4 text-emerald-500 font-mono text-xs">
                                    <?php echo htmlspecialchars($lecturer['lecturer_id']); ?>
                                </td>

                                <!-- Name (with avatar initial) -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="h-8 w-8 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-700 font-bold text-xs shrink-0 border border-emerald-200">
                                            <?php echo strtoupper(substr(trim($lecturer['name']), 0, 1)); ?>
                                        </div>
                                        <span class="font-semibold text-emerald-900">
                                            <?php echo htmlspecialchars($lecturer['name']); ?>
                                        </span>
                                    </div>
                                </td>

                                <!-- Email -->
                                <td class="px-6 py-4 text-emerald-600">
                                    <?php echo htmlspecialchars($lecturer['email']); ?>
                                </td>

                                <!-- Department Badge -->
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center justify-center px-3 py-1 rounded-full bg-emerald-100 text-emerald-700 font-semibold text-xs border border-emerald-200">
                                        <?php echo htmlspecialchars($lecturer['dept_name']); ?>
                                    </span>
                                </td>

                                <!-- Actions -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="../presentation/index.php?page=edit_lecturer&id=<?php echo $lecturer['lecturer_id']; ?>"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium
                                              bg-emerald-50 text-emerald-700 border border-emerald-200
                                              hover:bg-emerald-600 hover:text-white hover:border-emerald-600 transition-all">
                                            Edit
                                        </a>

                                        <a href="../application/lecturerController.php?action=delete&id=<?php echo $lecturer['lecturer_id']; ?>"
                                            onclick="return confirm('Are you sure you want to delete this lecturer?');"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium
                                                   bg-red-50 text-red-600 border border-red-200
                                                   hover:bg-red-500 hover:text-white hover:border-red-500 transition-all">
                                            Delete
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center py-10 text-emerald-400 italic">
                                No lecturers found.
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
            setTimeout(() => alert.remove(), 400);
        }
    }, 3500);
</script>