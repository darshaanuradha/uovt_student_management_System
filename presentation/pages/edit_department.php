<?php
$dept_id = intval($_GET['id'] ?? 0);
$stmt = $conn->prepare("SELECT * FROM view_departments WHERE dept_id = ?");
$stmt->bind_param("i", $dept_id);
$stmt->execute();
$result = $stmt->get_result();
$department = $result->fetch_assoc();
$stmt->close();
?>
<div class="min-h-full flex flex-col">
    <!-- Breadcrumb -->
    <nav class="mb-6 flex items-center gap-2 text-sm text-emerald-500">
        <a href="index.php?page=departments" class="hover:text-emerald-700 transition-colors flex items-center gap-1.5">
            Departments
        </a>
        <svg class="w-4 h-4 text-emerald-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <span class="text-emerald-700 font-medium">Edit Department</span>
    </nav>

    <!-- Page Header -->
    <div class="mb-8 flex items-start gap-4">
        <div class="h-12 w-12 rounded-2xl bg-gradient-to-br from-emerald-500 to-emerald-700 flex items-center justify-center shadow-lg shadow-emerald-200 shrink-0">
            <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
        </div>
        <div>
            <h1 class="text-2xl font-bold text-emerald-900 tracking-tight">Edit Department</h1>
            <p class="text-sm text-emerald-500 mt-0.5">Update the details for this department below.</p>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-2xl border border-emerald-100 shadow-sm overflow-hidden max-w-2xl w-full">
        <div class="bg-gradient-to-r from-emerald-700 to-emerald-600 px-6 py-4 flex items-center gap-3">
            <div class="h-8 w-8 rounded-lg bg-white/15 flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
            </div>
            <span class="text-white font-semibold text-sm tracking-wide">Department Details</span>
        </div>

        <form action="../application/departmentsController.php" method="POST" class="px-6 py-7 space-y-6">
            <input type="hidden" name="action" value="edit_department">
            <input type="hidden" name="dept_id" value="<?= $department['dept_id'] ?>">

            <div>
                <label class="block text-sm font-semibold text-emerald-800 mb-1.5">
                    Department Name <span class="text-red-500">*</span>
                </label>
                <input type="text" name="dept_name" value="<?= htmlspecialchars($department['dept_name']) ?>" required
                    class="w-full px-4 py-2.5 rounded-xl border border-emerald-200 text-emerald-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all duration-200">
            </div>

            <div class="border-t border-emerald-50 pt-2"></div>

            <div class="flex flex-col sm:flex-row gap-3">
                <a href="index.php?page=departments"
                    class="flex-1 inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl border border-emerald-200 text-emerald-700 font-semibold text-sm hover:bg-emerald-50 transition-colors duration-200">
                    Cancel
                </a>
                <button type="submit"
                    class="flex-1 inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 active:scale-95 text-white font-semibold text-sm shadow-md shadow-emerald-200 transition-all duration-200">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>