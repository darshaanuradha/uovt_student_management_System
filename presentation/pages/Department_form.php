<?php
// department_add_form.php
require_once '../application/db.php';

// Default mode: ADD
$mode = 'add';
$title = 'Add Department';
$buttonText = 'Create Department';

$department_id = '';
$department_name = '';
$description = '';

// If ID is set → EDIT mode
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $mode = 'edit';
    $title = 'Edit Department';
    $buttonText = 'Update Department';

    $department_id = (int) $_GET['id'];

    $stmt = $conn->prepare(
        "SELECT department_name, description FROM departments WHERE department_id = ?"
    );
    $stmt->bind_param("i", $department_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $department_name = $row['department_name'];
        $description = $row['description'];
    } else {
        header("Location: index.php?page=departments&error=notfound");
        exit();
    }

    $stmt->close();
}
?>

<div class="max-w-3xl mx-auto">
    <!-- Header -->
    <div class="flex justify-between items-end mb-6 px-2">
        <div>
            <h2 class="text-3xl font-extrabold text-emerald-900 tracking-tight">
                <?= $title ?>
            </h2>
            <p class="text-sm text-emerald-600 mt-1 font-medium">
                <?= ($mode === 'add') ? 'Create a new academic department' : 'Update department details' ?>
            </p>
        </div>
        <a href="index.php?page=departments"
           class="text-emerald-600 hover:text-emerald-800 text-sm font-bold transition">
            ← Back to Departments
        </a>
    </div>

    <!-- Card -->
    <div class="bg-white/80 backdrop-blur-xl p-8 rounded-3xl shadow-xl border border-white/50">

        <!-- Alerts -->
        <?php if (isset($_GET['error'])): ?>
            <div class="mb-6 bg-red-50 border border-red-200 text-red-800 p-4 rounded-2xl">
                Operation failed. Please check the details.
            </div>
        <?php endif; ?>

        <!-- Form -->
        <form method="POST" action="../application/departmentsController.php" class="space-y-6">
            <input type="hidden" name="action" value="<?= ($mode === 'add') ? 'add_department' : 'update_department' ?>">
            <?php if ($mode === 'edit'): ?>
                <input type="hidden" name="department_id" value="<?= $department_id ?>">
            <?php endif; ?>

            <!-- Department Name -->
            <div class="space-y-2">
                <label class="block text-sm font-bold text-gray-700">
                    Department Name
                </label>
                <input type="text"
                       name="department_name"
                       required
                       value="<?= htmlspecialchars($department_name) ?>"
                       placeholder="e.g. Engineering, IT, Medicine & Health"
                       class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl
                              focus:bg-white focus:ring-4 focus:ring-emerald-500/20
                              focus:border-emerald-500 outline-none transition font-medium">
            </div>

            <!-- Description -->
            <div class="space-y-2">
                <label class="block text-sm font-bold text-gray-700">
                    Description
                </label>
                <textarea name="description"
                          rows="4"
                          placeholder="Brief description of the department (optional)"
                          class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl
                                 focus:bg-white focus:ring-4 focus:ring-emerald-500/20
                                 focus:border-emerald-500 outline-none transition font-medium"><?= htmlspecialchars($description) ?></textarea>
            </div>

            <!-- Submit Button -->
            <div class="pt-4">
                <button type="submit"
                        class="w-full bg-gradient-to-r from-emerald-600 to-emerald-500
                               text-white font-bold text-lg py-4 rounded-xl
                               hover:from-emerald-700 hover:to-emerald-600
                               transition-all shadow-lg hover:shadow-emerald-500/30
                               transform hover:-translate-y-0.5">
                    <?= $buttonText ?>
                </button>
            </div>
        </form>
    </div>
</div>