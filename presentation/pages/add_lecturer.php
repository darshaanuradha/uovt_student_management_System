<div class="min-h-full flex flex-col">
    <!-- Breadcrumb -->
    <nav class="mb-6 flex items-center gap-2 text-sm text-emerald-500">
        <a href="index.php?page=lecturers" class="hover:text-emerald-700 transition-colors flex items-center gap-1.5">
            Lecturers
        </a>
        <svg class="w-4 h-4 text-emerald-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <span class="text-emerald-700 font-medium">Add Lecturer</span>
    </nav>

    <!-- Page Header -->
    <div class="mb-8 flex items-start gap-4">
        <div class="h-12 w-12 rounded-2xl bg-gradient-to-br from-emerald-500 to-emerald-700 flex items-center justify-center shadow-lg shadow-emerald-200 shrink-0">
            <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
            </svg>
        </div>
        <div>
            <h1 class="text-2xl font-bold text-emerald-900 tracking-tight">Add New Lecturer</h1>
            <p class="text-sm text-emerald-500 mt-0.5">Register a new lecturer to the system.</p>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-2xl border border-emerald-100 shadow-sm overflow-hidden max-w-2xl w-full">
        <div class="bg-gradient-to-r from-emerald-700 to-emerald-600 px-6 py-4 flex items-center gap-3">
            <div class="h-8 w-8 rounded-lg bg-white/15 flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
            <span class="text-white font-semibold text-sm tracking-wide">Lecturer Details</span>
        </div>

        <form action="../application/lecturerController.php" method="POST" class="px-6 py-7 space-y-6">

            <div>
                <label class="block text-sm font-semibold text-emerald-800 mb-1.5">Full Name <span class="text-red-500">*</span></label>
                <input type="text" name="name" required placeholder="e.g. John Doe"
                    class="w-full px-4 py-2.5 rounded-xl border border-emerald-200 text-emerald-900 placeholder-emerald-300 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all duration-200">
            </div>

            <div>
                <label class="block text-sm font-semibold text-emerald-800 mb-1.5">Email Address <span class="text-red-500">*</span></label>
                <input type="email" name="email" required placeholder="john.doe@example.com"
                    class="w-full px-4 py-2.5 rounded-xl border border-emerald-200 text-emerald-900 placeholder-emerald-300 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all duration-200">
            </div>

            <div>
                <label class="block text-sm font-semibold text-emerald-800 mb-1.5">Department <span class="text-red-500">*</span></label>
                <select name="department" required
                    class="w-full px-4 py-2.5 rounded-xl border border-emerald-200 text-emerald-900 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all duration-200">
                    <option value="" disabled selected>— Select a department —</option>
                    <?php
                    $departments = $conn->query("SELECT * FROM departments");
                    while ($dept = $departments->fetch_assoc()) {
                        echo "<option value='{$dept['dept_id']}'>{$dept['dept_name']}</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="border-t border-emerald-50 pt-2"></div>

            <div class="flex flex-col sm:flex-row gap-3">
                <a href="index.php?page=lecturers"
                    class="flex-1 inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl border border-emerald-200 text-emerald-700 font-semibold text-sm hover:bg-emerald-50 transition-colors duration-200">
                    Cancel
                </a>
                <button type="submit"
                    class="flex-1 inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 active:scale-95 text-white font-semibold text-sm shadow-md shadow-emerald-200 transition-all duration-200">
                    Add Lecturer
                </button>
            </div>
        </form>
    </div>
</div>