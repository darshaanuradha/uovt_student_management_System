<?php
$totalResult = $conn->query("SELECT COUNT(*) AS total FROM ViewEnrollments");
$totalRow = $totalResult->fetch_assoc();
$totalEnrollments = $totalRow['total'];

$result = $conn->query('SELECT * FROM ViewEnrollments ORDER BY enrollment_date DESC');
?>

<!-- ══════════════════════════════════════════════════════════ PAGE HEADER -->
<div class="mb-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-emerald-900 tracking-tight">Course Enrollments</h1>
            <p class="text-sm text-emerald-600 mt-1">View and manage student course registrations</p>
        </div>

        <div class="flex items-center gap-4">
            <!-- Stat Badge -->
            <div class="bg-white rounded-xl border border-emerald-100 shadow-sm px-4 py-2 flex items-center gap-3">
                <span class="text-xs text-emerald-500 font-medium uppercase tracking-wider">Total</span>
                <span class="text-lg font-bold text-emerald-900"><?= $totalEnrollments ?></span>
            </div>

            <!-- Action Button -->
            <a href="index.php?page=enroll_student_form"
                class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 active:scale-95
                       text-white font-semibold px-5 py-2.5 rounded-xl shadow-md shadow-emerald-200
                       transition-all duration-200">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                </svg>
                New Enrollment
            </a>
        </div>
    </div>
</div>

<!-- ══════════════════════════════════════════════════════════ ALERTS -->
<?php if (isset($_GET['success']) && $_GET['success'] == 'deleted'): ?>
    <div id="alertBox" class="flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 px-5 py-4 rounded-xl mb-6 shadow-sm">
        <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
        </svg>
        <span class="text-sm font-medium">Student successfully unenrolled. Course totals updated.</span>
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
        <h2 class="text-sm font-semibold text-emerald-800 uppercase tracking-wider">Active Enrollments</h2>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead>
                <tr class="bg-emerald-50/70 text-emerald-600 uppercase text-xs tracking-wider">
                    <th class="px-6 py-3 font-semibold">Date</th>
                    <th class="px-6 py-3 font-semibold">Student</th>
                    <th class="px-6 py-3 font-semibold">Course</th>
                    <th class="px-6 py-3 font-semibold text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-emerald-50">
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <?php $date = date("M j, Y • H:i", strtotime($row['enrollment_date'])); ?>

                        <tr class="hover:bg-emerald-50/40 transition-colors duration-150">
                            <!-- Date -->
                            <td class="px-6 py-4 text-emerald-500 text-xs font-medium whitespace-nowrap">
                                <?= $date ?>
                            </td>

                            <!-- Student Info -->
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="h-8 w-8 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-700 font-bold text-xs shrink-0 border border-emerald-200">
                                        <?= strtoupper(substr($row['first_name'], 0, 1) . substr($row['last_name'], 0, 1)) ?>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-emerald-900">
                                            <?= htmlspecialchars($row['first_name'] . " " . $row['last_name']) ?>
                                        </p>
                                        <p class="text-xs text-emerald-500 mt-0.5 font-mono">
                                            ID: <?= htmlspecialchars($row['student_id']) ?>
                                        </p>
                                    </div>
                                </div>
                            </td>

                            <!-- Course Info -->
                            <td class="px-6 py-4">
                                <p class="font-semibold text-emerald-900">
                                    <?= htmlspecialchars($row['course_name']) ?>
                                </p>
                                <p class="text-xs text-emerald-500 font-mono mt-0.5">
                                    <?= htmlspecialchars($row['course_id']) ?>
                                </p>
                            </td>

                            <!-- Actions -->
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center">
                                    <form action="../application/enrollmentsController.php" method="POST" onsubmit="return confirm('Are you sure you want to remove this student from the course?');">
                                        <input type="hidden" name="action" value="delete_enrollment">
                                        <input type="hidden" name="enrollment_id" value="<?= $row['enrollment_id'] ?>">
                                        <button type="submit"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium
                                                   bg-red-50 text-red-600 border border-red-200
                                                   hover:bg-red-500 hover:text-white hover:border-red-500 transition-all">
                                            Unenroll
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center py-10 text-emerald-400 italic">
                            No active enrollments found.
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
            alert.style.transition = "all 0.4s ease";
            alert.style.opacity = "0";
            setTimeout(() => alert.remove(), 400);
        }
    }, 3500);
</script>