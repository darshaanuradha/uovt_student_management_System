<?php
$isEdit = false;
$student = null;
$action = 'add';
$buttonText = 'Add Student';
$titleText = 'Add New Student';

// Future edit logic can be placed here.
?>

<div class="bg-white border border-emerald-100 rounded-xl shadow-sm p-6 mb-6 max-w-2xl mx-auto">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-emerald-800"><?= $titleText ?></h2>
        <p class="text-sm text-emerald-600 mt-1">Enter the student's details below.</p>
    </div>

    <!-- Alerts -->
    <?php if (isset($_GET['error'])): ?>
        <?php if ($_GET['error'] === 'duplicate_email'): ?>
            <div class="bg-red-100 text-red-800 p-3 rounded mb-4 text-sm font-medium">
                A student with this email address already exists!
            </div>
        <?php else: ?>
            <div class="bg-red-100 text-red-800 p-3 rounded mb-4 text-sm font-medium">
                Invalid data provided. Please check the form fields.
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <form action="../application/studentcontroller.php" method="POST">
        <input type="hidden" name="action" value="<?= $action ?>">
        
        <div class="space-y-4">
            <div>
                <label for="first_name" class="block text-sm font-medium text-gray-700 mb-1">First Name <span class="text-red-500">*</span></label>
                <input type="text" id="first_name" name="first_name" required
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition"
                    value="">
            </div>
            
            <div>
                <label for="last_name" class="block text-sm font-medium text-gray-700 mb-1">Last Name <span class="text-red-500">*</span></label>
                <input type="text" id="last_name" name="last_name" required
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition"
                    value="">
            </div>
            
            <div>
                <label for="contact_email" class="block text-sm font-medium text-gray-700 mb-1">Email Address <span class="text-red-500">*</span></label>
                <input type="email" id="contact_email" name="contact_email" required
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition"
                    value="">
            </div>
        </div>

        <div class="mt-6 flex justify-end gap-3">
            <a href="index.php?page=students" 
                class="px-4 py-2 text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg transition font-medium text-sm">
                Cancel
            </a>
            <button type="submit" 
                class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg shadow transition font-semibold text-sm">
                <?= $buttonText ?>
            </button>
        </div>
    </form>
</div>
