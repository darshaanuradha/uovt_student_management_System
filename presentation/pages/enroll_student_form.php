<div class="flex justify-between items-center mb-8 border-b border-emerald-100 pb-4">
    <div>
        <h2 class="text-3xl font-bold text-emerald-800">New Course Enrollment</h2>
        <p class="text-sm text-emerald-600 mt-1">Assign a student to a university course.</p>
    </div>
    <a href="index.php?page=enrollments"
        class="text-emerald-600 hover:text-emerald-800 text-sm font-semibold transition">
        &larr; Back to Enrollment List
    </a>
</div>

<div class="bg-white p-8 rounded-2xl shadow-lg border border-emerald-100 max-w-2xl mx-auto">

    <!-- Alerts -->
    <?php if (isset($_GET['success'])): ?>
        <div id="alertBox" class="flex items-center justify-between bg-emerald-100 text-emerald-800 p-4 rounded-lg mb-6 text-sm font-semibold shadow-sm">
            <span>✅ Enrollment successful! Database transaction completed securely.</span>
            <button onclick="this.parentElement.remove()" class="ml-4 text-emerald-700 hover:text-emerald-900">&times;</button>
        </div>
    <?php elseif (isset($_GET['error'])): ?>
        <div id="alertBox" class="flex items-center justify-between bg-red-100 text-red-800 p-4 rounded-lg mb-6 text-sm font-semibold shadow-sm">
            <span>❌ Error processing enrollment. Student may already be enrolled.</span>
            <button onclick="this.parentElement.remove()" class="ml-4 text-red-700 hover:text-red-900">&times;</button>
        </div>
    <?php endif; ?>

    <!-- Form -->
    <form action="../application/enrollmentsController.php" method="POST" class="space-y-6">
        <input type="hidden" name="action" value="enroll_student">

        <!-- Student Select -->
        <div>
            <label class="block text-sm font-semibold text-emerald-700 mb-2">
                Select Student
            </label>
            <select name="student_id" required
                class="w-full p-3 border border-emerald-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none bg-emerald-50/40 transition">
                <option value="">-- Choose a Student --</option>
                <?php
                $students = $conn->query("SELECT student_id, first_name, last_name FROM students ORDER BY last_name ASC");
                if ($students) {
                    while ($s = $students->fetch_assoc()) {
                        echo "<option value='" . $s['student_id'] . "'>"
                            . $s['first_name'] . " " . $s['last_name']
                            . " (ID: " . $s['student_id'] . ")</option>";
                    }
                }
                ?>
            </select>
        </div>

        <!-- Course Select -->
        <div>
            <label class="block text-sm font-semibold text-emerald-700 mb-2">
                Select Course
            </label>
            <select name="course_id" required
                class="w-full p-3 border border-emerald-200 rounded-xl focus:ring-2 focus:ring-emerald-500 outline-none bg-emerald-50/40 transition">
                <option value="">-- Choose a Course --</option>
                <?php
                $courses = $conn->query("SELECT course_id, course_name FROM courses ORDER BY course_name ASC");
                if ($courses) {
                    while ($c = $courses->fetch_assoc()) {
                        echo "<option value='" . $c['course_id'] . "'>"
                            . $c['course_name']
                            . " (Course ID: " . $c['course_id'] . ")</option>";
                    }
                }
                ?>
            </select>
        </div>

        <!-- Submit -->
        <button type="submit"
            class="w-full bg-emerald-600 text-white font-bold py-3 rounded-xl hover:bg-emerald-700 transition shadow-md tracking-wide">
            Process Enrollment
        </button>
    </form>
</div>

<!-- Auto-dismiss alert -->
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