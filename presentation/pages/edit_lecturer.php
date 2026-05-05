<?php
require_once '../application/db.php';
if (!isset($_GET['id'])) {
    echo "Invalid request";
    exit();
}
$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM lecturers WHERE lecturer_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$lecturer = $result->fetch_assoc();

if (!$lecturer) {
    echo "Lecturer not found";
    exit();
}
?>

<div class="min-h-full flex flex-col">
    <!-- Breadcrumb -->
    <nav class="mb-6 flex items-center gap-2 text-sm text-emerald-500">
        <a href="index.php?page=lecturers" class="hover:text-emerald-700 transition-colors flex items-center gap-1.5">
            Lecturers
        </a>
        <svg class="w-4 h-4 text-emerald-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <span class="text-emerald-700 font-medium">Edit Lecturer</span>
    </nav>

    <!-- Page Header -->
    <div class="mb-8 flex items-start gap-4">
        <div class="h-12 w-12 rounded-2xl bg-gradient-to-br from-emerald-500 to-emerald-700 flex items-center justify-center shadow-lg shadow-emerald-200 shrink-0">
            <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
        </div>
        <div>
            <h1 class="text-2xl font-bold text-emerald-900 tracking-tight">Edit Lecturer</h1>
            <p class="text-sm text-emerald-500 mt-0.5">Update the details for this lecturer below.</p>
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
            <input type="hidden" name="lecturer_id" value="<?php echo $lecturer['lecturer_id']; ?>">

            <div>
                <label class="block text-sm font-semibold text-emerald-800 mb-1.5">Full Name <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="<?php echo htmlspecialchars($lecturer['name']); ?>" required
                    class="w-full px-4 py-2.5 rounded-xl border border-emerald-200 text-emerald-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all duration-200">
            </div>

            <div>
                <label class="block text-sm font-semibold text-emerald-800 mb-1.5">Email Address <span class="text-red-500">*</span></label>
                <input type="email" name="email" value="<?php echo htmlspecialchars($lecturer['email']); ?>" required
                    class="w-full px-4 py-2.5 rounded-xl border border-emerald-200 text-emerald-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all duration-200">
            </div>

            <div>
                <label class="block text-sm font-semibold text-emerald-800 mb-1.5">Department <span class="text-red-500">*</span></label>
                <select name="department" required
                    class="w-full px-4 py-2.5 rounded-xl border border-emerald-200 text-emerald-900 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all duration-200">
                    <?php
                    $departments = $conn->query("SELECT * FROM departments");
                    while ($dept = $departments->fetch_assoc()) {
                        $selected = ($dept['dept_id'] == $lecturer['dept_id']) ? "selected" : "";
                        echo "<option value='{$dept['dept_id']}' $selected>{$dept['dept_name']}</option>";
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
                <button type="submit" name="update"
                    class="flex-1 inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 active:scale-95 text-white font-semibold text-sm shadow-md shadow-emerald-200 transition-all duration-200">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>