<div class="max-w-3xl mx-auto">
    <div class="flex justify-between items-end mb-6 px-2">
        <div>
            <h2 class="text-3xl font-extrabold text-emerald-900 tracking-tight">New Enrollment</h2>
            <p class="text-sm text-emerald-600 mt-1 font-medium">Assign a student to a university course.</p>
        </div>
        <a href="index.php?page=enrollments" class="text-emerald-600 hover:text-emerald-800 text-sm font-bold flex items-center group transition">
            <svg class="w-4 h-4 mr-1 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to List
        </a>
    </div>

    <div class="bg-white/80 backdrop-blur-xl p-8 rounded-3xl shadow-xl border border-white/50 relative overflow-hidden">

        <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-br from-emerald-100 to-transparent rounded-full opacity-50 blur-3xl pointer-events-none -mr-20 -mt-20"></div>

        <?php if (isset($_GET['success'])): ?>
            <div id="alertBox" class="flex items-start bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-2xl mb-8 shadow-sm">
                <div class="bg-emerald-500 rounded-full p-1 mr-3 shrink-0 mt-0.5">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <div>
                    <h4 class="font-bold text-sm">Enrollment Successful</h4>
                    <p class="text-xs text-emerald-600 mt-0.5 font-medium">Database transaction completed securely.</p>
                </div>
            </div>
        <?php elseif (isset($_GET['error'])): ?>
            <div id="alertBox" class="flex items-start bg-red-50 border border-red-200 text-red-800 p-4 rounded-2xl mb-8 shadow-sm">
                <div class="bg-red-500 rounded-full p-1 mr-3 shrink-0 mt-0.5">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </div>
                <div>
                    <h4 class="font-bold text-sm">Enrollment Failed</h4>
                    <p class="text-xs text-red-600 mt-0.5 font-medium">Error processing request. The student may already be enrolled.</p>
                </div>
            </div>
        <?php endif; ?>

        <form action="../application/enrollmentsController.php" method="POST" class="space-y-6 relative z-10">
            <input type="hidden" name="action" value="enroll_student">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="block text-sm font-bold text-gray-700">
                        Student
                    </label>
                    <div class="relative">
                        <select name="student_id" required class="w-full pl-4 pr-10 py-3.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-emerald-500/20 focus:border-emerald-500 outline-none transition-all duration-200 text-gray-700 font-medium appearance-none shadow-sm cursor-pointer">
                            <option value="">Select a student...</option>
                            <?php
                            $students = $conn->query("SELECT student_id, first_name, last_name FROM students ORDER BY last_name ASC");
                            if ($students) {
                                while ($s = $students->fetch_assoc()) {
                                    echo "<option value='" . $s['student_id'] . "'>" . $s['first_name'] . " " . $s['last_name'] . " (ID: " . $s['student_id'] . ")</option>";
                                }
                            }
                            ?>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-bold text-gray-700">
                        Course
                    </label>
                    <div class="relative">
                        <select name="course_id" required class="w-full pl-4 pr-10 py-3.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-emerald-500/20 focus:border-emerald-500 outline-none transition-all duration-200 text-gray-700 font-medium appearance-none shadow-sm cursor-pointer">
                            <option value="">Select a course...</option>
                            <?php
                            $courses = $conn->query("SELECT course_id, course_name FROM courses ORDER BY course_name ASC");
                            if ($courses) {
                                while ($c = $courses->fetch_assoc()) {
                                    echo "<option value='" . $c['course_id'] . "'>" . $c['course_name'] . " (" . $c['course_id'] . ")</option>";
                                }
                            }
                            ?>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-emerald-50/50 border border-emerald-100 rounded-xl p-4 flex items-start mt-6">
                <svg class="w-5 h-5 text-emerald-500 mt-0.5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="text-xs font-medium text-emerald-700 leading-relaxed">
                    <strong>System Note:</strong> Processing this enrollment will automatically trigger the MySQL database to update the total student capacity count in the selected course.
                </p>
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full bg-gradient-to-r from-emerald-600 to-emerald-500 text-white font-bold text-lg py-4 rounded-xl hover:from-emerald-700 hover:to-emerald-600 transition-all duration-300 shadow-lg hover:shadow-emerald-500/30 transform hover:-translate-y-0.5">
                    Process Enrollment
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    setTimeout(function() {
        const alert = document.getElementById('alertBox');
        if (alert) {
            alert.style.transition = "all 0.5s cubic-bezier(0.4, 0, 0.2, 1)";
            alert.style.opacity = "0";
            alert.style.transform = "translateY(-10px)";
            setTimeout(() => alert.remove(), 500);
        }
    }, 4000);
</script>