<?php
$totalResult = $conn->query("SELECT COUNT(*) AS total FROM ViewEnrollments");
$totalRow = $totalResult->fetch_assoc();
$totalEnrollments = $totalRow['total'];

$result = $conn->query('SELECT * FROM ViewEnrollments ORDER BY enrollment_date DESC');
?>

<div class="bg-white border border-emerald-100 rounded-xl shadow-sm p-6 mb-6">

    <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">

        <!-- LEFT SIDE -->
        <div>
            <h2 class="text-2xl font-bold text-emerald-800">
                Course Enrollments
            </h2>
            <p class="text-sm text-emerald-600 mt-1">
                View and manage student course registrations
            </p>
        </div>

        <!-- RIGHT SIDE -->
        <div class="flex items-center gap-4">

            <!-- STAT CARD -->
            <div class="bg-emerald-50 border border-emerald-200 rounded-lg px-4 py-2 text-center">
                <div class="text-xs text-emerald-600">Total Enrollments</div>
                <div class="text-xl font-bold text-emerald-800">
                    <?= $totalEnrollments ?>
                </div>
            </div>

            <!-- ACTIONS -->
            <div class="flex flex-col items-end gap-2">

                <a href="index.php?page=enroll_student_form"
                    class="bg-emerald-600 text-white px-4 py-2 rounded-lg shadow hover:bg-emerald-700 transition font-semibold text-sm">
                    + New Enrollment
                </a>

                <a href="index.php?page=dashboard"
                    class="text-emerald-700 hover:text-emerald-900 text-sm font-semibold">
                    ← Back to Dashboard
                </a>

            </div>

        </div>

    </div>
</div>

<!-- Alerts -->
<?php if (isset($_GET['success']) && $_GET['success'] == 'deleted'): ?>
    <div id="alertBox" class="bg-emerald-100 text-emerald-800 p-3 rounded mb-4 text-sm font-medium">
        Student successfully unenrolled. Course totals updated via database trigger.
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
                <th class="p-3 border-b">Date</th>
                <th class="p-3 border-b">Student Name</th>
                <th class="p-3 border-b">Course</th>
                <th class="p-3 border-b text-right">Actions</th>
            </tr>
        </thead>

        <tbody>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <?php
                    $date = date("M j, Y h:i A", strtotime($row['enrollment_date']));
                    ?>

                    <tr class="hover:bg-emerald-50/50 transition border-b border-emerald-50">
                        <td class="p-3 text-sm font-medium text-gray-500">
                            <?= $date ?>
                        </td>

                        <td class="p-3 text-sm text-gray-800 font-semibold">
                            <?= $row['first_name'] . " " . $row['last_name'] ?>
                            <span class="text-xs text-gray-400 font-normal">
                                (ID: <?= $row['student_id'] ?>)
                            </span>
                        </td>

                        <td class="p-3 text-sm text-gray-700">
                            <span class="font-bold text-emerald-700">
                                <?= $row['course_id'] ?>
                            </span>
                            - <?= $row['course_name'] ?>
                        </td>

                        <td class="p-3 text-right">
                            <form action="../application/enrollmentsController.php"
                                method="POST"
                                onsubmit="return confirm('Remove this student from the course?');">
                                <input type="hidden" name="action" value="delete_enrollment">
                                <input type="hidden" name="enrollment_id" value="<?= $row['enrollment_id'] ?>">

                                <button type="submit"
                                    class="bg-red-100 text-red-700 px-3 py-1 rounded hover:bg-red-200 transition font-semibold text-xs border border-red-200">
                                    Unenroll
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" class="p-4 text-center text-gray-500 italic">
                        No active enrollments found.
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