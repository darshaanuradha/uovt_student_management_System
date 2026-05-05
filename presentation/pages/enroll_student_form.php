<div class="min-h-full flex flex-col pb-10">

    <!-- ══════════════════════════════════════════════════════════ BREADCRUMB -->
    <nav class="mb-6 flex items-center gap-2 text-sm text-emerald-500">
        <a href="index.php?page=enrollments" class="hover:text-emerald-700 transition-colors flex items-center gap-1.5">
            Course Enrollments
        </a>
        <svg class="w-4 h-4 text-emerald-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <span class="text-emerald-700 font-medium">New Enrollment</span>
    </nav>

    <!-- ══════════════════════════════════════════════════════════ PAGE HEADER -->
    <div class="mb-8 flex items-start gap-4">
        <div class="h-12 w-12 rounded-2xl bg-gradient-to-br from-emerald-500 to-emerald-700 flex items-center justify-center shadow-lg shadow-emerald-200 shrink-0">
            <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
            </svg>
        </div>
        <div>
            <h1 class="text-2xl font-bold text-emerald-900 tracking-tight">New Enrollment</h1>
            <p class="text-sm text-emerald-500 mt-0.5">Assign a student to a course.</p>
        </div>
    </div>

    <!-- ══════════════════════════════════════════════════════════ ALERTS -->
    <?php if (isset($_GET['success'])): ?>
        <div id="alertBox" class="flex items-start gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 px-5 py-4 rounded-xl mb-6 shadow-sm max-w-2xl w-full">
            <div class="bg-emerald-500 rounded-full p-1 shrink-0 mt-0.5">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <div>
                <h4 class="font-bold text-sm">Enrollment Successful</h4>
                <p class="text-xs text-emerald-600 mt-0.5 font-medium">Database transaction completed securely.</p>
            </div>
        </div>
    <?php elseif (isset($_GET['error'])): ?>
        <div id="alertBox" class="flex items-start gap-3 bg-red-50 border border-red-200 text-red-800 px-5 py-4 rounded-xl mb-6 shadow-sm max-w-2xl w-full">
            <div class="bg-red-500 rounded-full p-1 shrink-0 mt-0.5">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </div>
            <div>
                <h4 class="font-bold text-sm">Enrollment Failed</h4>
                <p class="text-xs text-red-600 mt-0.5 font-medium">Error processing request. The student may already be enrolled.</p>
            </div>
        </div>
    <?php endif; ?>

    <!-- ══════════════════════════════════════════════════════════ FORM CARD -->
    <div class="bg-white rounded-2xl border border-emerald-100 shadow-sm overflow-hidden max-w-2xl w-full">

        <!-- Card Header -->
        <div class="bg-gradient-to-r from-emerald-700 to-emerald-600 px-6 py-4 flex items-center gap-3">
            <div class="h-8 w-8 rounded-lg bg-white/15 flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                </svg>
            </div>
            <span class="text-white font-semibold text-sm tracking-wide">Enrollment Details</span>
        </div>

        <!-- Form Body -->
        <form action="../application/enrollmentsController.php" method="POST" class="px-6 py-7 space-y-6">
            <input type="hidden" name="action" value="enroll_student">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Student Dropdown -->
                <div>
                    <label class="block text-sm font-semibold text-emerald-800 mb-1.5">
                        Student <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <select name="student_id" required
                            class="w-full px-4 py-2.5 rounded-xl border border-emerald-200 text-emerald-900 bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all duration-200 appearance-none text-sm">
                            <option value="" disabled selected>— Select a student —</option>
                            <?php
                            $students = $conn->query("SELECT student_id, first_name, last_name FROM students ORDER BY last_name ASC");
                            if ($students) {
                                while ($s = $students->fetch_assoc()) {
                                    echo "<option value='" . htmlspecialchars($s['student_id']) . "'>" . htmlspecialchars($s['first_name'] . " " . $s['last_name']) . " (ID: " . htmlspecialchars($s['student_id']) . ")</option>";
                                }
                            }
                            ?>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3.5">
                            <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Course Dropdown -->
                <div>
                    <label class="block text-sm font-semibold text-emerald-800 mb-1.5">
                        Course <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <select name="course_id" required
                            class="w-full px-4 py-2.5 rounded-xl border border-emerald-200 text-emerald-900 bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all duration-200 appearance-none text-sm">
                            <option value="" disabled selected>— Select a course —</option>
                            <?php
                            $courses = $conn->query("SELECT course_id, course_name FROM courses ORDER BY course_name ASC");
                            if ($courses) {
                                while ($c = $courses->fetch_assoc()) {
                                    echo "<option value='" . htmlspecialchars($c['course_id']) . "'>" . htmlspecialchars($c['course_name']) . " (" . htmlspecialchars($c['course_id']) . ")</option>";
                                }
                            }
                            ?>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3.5">
                            <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- System Note Box -->
            <div class="bg-emerald-50 border border-emerald-100 rounded-xl p-4 flex items-start mt-6">
                <svg class="w-5 h-5 text-emerald-500 mt-0.5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="text-xs font-medium text-emerald-700 leading-relaxed">
                    <strong>System Note:</strong> Processing this enrollment will automatically trigger the MySQL database to update the total student capacity count in the selected course.
                </p>
            </div>

            <!-- Divider -->
            <div class="border-t border-emerald-50 pt-2"></div>

            <!-- Actions -->
            <div class="flex flex-col sm:flex-row gap-3">
                <a href="index.php?page=enrollments"
                    class="flex-1 inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl border border-emerald-200 text-emerald-700 font-semibold text-sm hover:bg-emerald-50 transition-colors duration-200">
                    Cancel
                </a>
                <button type="submit"
                    class="flex-1 inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 active:scale-95 text-white font-semibold text-sm shadow-md shadow-emerald-200 transition-all duration-200">
                    Process Enrollment
                </button>
            </div>
        </form>
    </div>
</div>

<!-- AUTO HIDE ALERT -->
<script>
    setTimeout(function() {
        const alert = document.getElementById('alertBox');
        if (alert) {
            alert.style.transition = "all 0.4s ease";
            alert.style.opacity = "0";
            setTimeout(() => alert.remove(), 400);
        }
    }, 3500);
</script>