<div class="flex justify-between items-center mb-6 border-b border-emerald-100 pb-4">
    <div>
        <h2 class="text-2xl font-bold text-emerald-800">Course Enrollments</h2>
        <p class="text-sm text-emerald-600 mt-1">View and manage student course registrations.</p>
    </div>
    <div class="space-x-4">
        <a href="index.php?page=enroll_student_form" class="bg-emerald-600 text-white px-4 py-2 rounded shadow hover:bg-emerald-700 transition font-semibold">+ New Enrollment</a>
        <a href="index.php?page=dashboard" class="text-emerald-600 hover:text-emerald-800 text-sm font-semibold">&larr; Back to Dashboard</a>
    </div>
</div>

<?php if (isset($_GET['success']) && $_GET['success'] == 'deleted'): ?>
    <div id="alertBox" class="bg-emerald-100 text-emerald-800 p-3 rounded mb-4 text-sm font-medium">
        Student successfully unenrolled. Course totals updated via database trigger.
    </div>
<?php elseif (isset($_GET['error'])): ?>
    <div id="alertBox" class="bg-red-100 text-red-800 p-3 rounded mb-4 text-sm font-medium">
        Error processing request.
    </div>
<?php endif; ?>

<div class="overflow-x-auto">
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
            <?php
            $result = $conn->query('SELECT * FROM ViewEnrollments ORDER BY enrollment_date DESC;');
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()):
                    $date = date("M j, Y", strtotime($row['enrollment_date']));
            ?>
                    <tr class="hover:bg-emerald-50/50 transition border-b border-emerald-50">
                        <td class="p-3 text-sm font-medium text-gray-500"><?php echo $date; ?></td>
                        <td class="p-3 text-sm text-gray-800 font-semibold">
                            <?php echo $row['first_name'] . " " . $row['last_name']; ?>
                            <span class="text-xs text-gray-400 font-normal">(ID: <?php echo $row['student_id']; ?>)</span>
                        </td>
                        <td class="p-3 text-sm text-gray-700">
                            <span class="font-bold text-emerald-700"><?php echo $row['course_id']; ?></span> -
                            <?php echo $row['course_name']; ?>
                        </td>
                        <td class="p-3 text-sm text-right flex justify-end">
                            <form action="../application/enrollmentsController.php" method="POST" onsubmit="return confirm('Remove this student from the course?');">
                                <input type="hidden" name="action" value="delete_enrollment">
                                <input type="hidden" name="enrollment_id" value="<?php echo $row['enrollment_id']; ?>">
                                <button type="submit" class="bg-red-100 text-red-700 px-3 py-1 rounded hover:bg-red-200 transition font-semibold text-xs border border-red-200">Unenroll</button>
                            </form>
                        </td>
                    </tr>
            <?php endwhile;
            } else {
                echo "<tr><td colspan='4' class='p-4 text-center text-gray-500 italic'>No active enrollments found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<script>
    setTimeout(function() {
        var alert = document.getElementById('alertBox');
        if (alert) {
            alert.style.transition = "opacity 0.5s ease";
            alert.style.opacity = "0";
            setTimeout(() => alert.remove(), 500); // remove after fade
        }
    }, 3000);
</script>