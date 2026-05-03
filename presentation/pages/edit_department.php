<?php
$dept_id = intval($_GET['id'] ?? 0);

$stmt = $conn->prepare("SELECT * FROM view_departments WHERE dept_id = ?");
$stmt->bind_param("i", $dept_id);
$stmt->execute();

$result = $stmt->get_result();
$department = $result->fetch_assoc();

$stmt->close();
?>
<div class="max-w-3xl mx-auto">

    <!-- HEADER -->
    <div class="flex justify-between items-end mb-6 px-2">
        <div>
            <h2 class="text-3xl font-extrabold text-emerald-900 tracking-tight">
                Edit Department
            </h2>
            <p class="text-sm text-emerald-600 mt-1 font-medium">
                Update department information.
            </p>
        </div>

        <a href="index.php?page=departments"
            class="text-emerald-600 hover:text-emerald-800 text-sm font-bold flex items-center group transition">

            <svg class="w-4 h-4 mr-1 transform group-hover:-translate-x-1 transition-transform"
                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>

            Back to List
        </a>
    </div>

    <!-- CARD -->
    <div class="bg-white/80 backdrop-blur-xl p-8 rounded-3xl shadow-xl border border-white/50 relative overflow-hidden">

        <!-- Glow -->
        <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-br from-emerald-100 to-transparent rounded-full opacity-50 blur-3xl pointer-events-none -mr-20 -mt-20"></div>

        <!-- FORM -->
        <form action="../application/departmentsController.php" method="POST" class="space-y-6 relative z-10">

            <input type="hidden" name="action" value="edit_department">
            <input type="hidden" name="dept_id" value="<?= $department['dept_id'] ?>">

            <!-- INPUT -->
            <div class="space-y-2">
                <label class="block text-sm font-bold text-gray-700">
                    Department Name
                </label>

                <input type="text"
                    name="dept_name"
                    value="<?= htmlspecialchars($department['dept_name']) ?>"
                    required
                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl 
                           focus:bg-white focus:ring-4 focus:ring-emerald-500/20 
                           focus:border-emerald-500 outline-none transition-all duration-200 
                           text-gray-700 font-medium shadow-sm">
            </div>

            <!-- INFO BOX -->
            <div class="bg-emerald-50/50 border border-emerald-100 rounded-xl p-4 flex items-start">
                <svg class="w-5 h-5 text-emerald-500 mt-0.5 mr-3"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>

                <p class="text-xs font-medium text-emerald-700">
                    <strong>Note:</strong> Updating this department will reflect across all related records.
                </p>
            </div>

            <!-- BUTTON -->
            <div class="pt-4">
                <button type="submit"
                    class="w-full bg-gradient-to-r from-emerald-600 to-emerald-500 
                           text-white font-bold text-lg py-4 rounded-xl 
                           hover:from-emerald-700 hover:to-emerald-600 
                           transition-all duration-300 shadow-lg 
                           hover:shadow-emerald-500/30 transform hover:-translate-y-0.5">
                    Save Changes
                </button>
            </div>

        </form>
    </div>
</div>