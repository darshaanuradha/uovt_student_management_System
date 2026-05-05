<?php
require_once '../application/studentcontroller.php';

$isEdit = false;
$student = null;
$action = 'add';
$buttonText = 'Add Student';
$titleText = 'Add New Student';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $studentId = intval($_GET['id']);
    $student = getStudentById($studentId);

    if ($student) {
        $isEdit = true;
        $action = 'edit';
        $buttonText = 'Save Changes';
        $titleText = 'Edit Student Details';
    }
}

$firstName = $isEdit ? htmlspecialchars($student['first_name']) : '';
$lastName = $isEdit ? htmlspecialchars($student['last_name']) : '';
$contactEmail = $isEdit ? htmlspecialchars($student['contact_email']) : '';
?>

<div class="min-h-full flex flex-col pb-10">

    <!-- ══════════════════════════════════════════════════════════ BREADCRUMB -->
    <nav class="mb-6 flex items-center gap-2 text-sm text-emerald-500">
        <a href="index.php?page=students" class="hover:text-emerald-700 transition-colors flex items-center gap-1.5">
            Manage Students
        </a>
        <svg class="w-4 h-4 text-emerald-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <span class="text-emerald-700 font-medium"><?= $titleText ?></span>
    </nav>

    <!-- ══════════════════════════════════════════════════════════ PAGE HEADER -->
    <div class="mb-8 flex items-start gap-4">
        <div class="h-12 w-12 rounded-2xl bg-gradient-to-br from-emerald-500 to-emerald-700 flex items-center justify-center shadow-lg shadow-emerald-200 shrink-0">
            <?php if ($isEdit): ?>
                <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
            <?php else: ?>
                <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                </svg>
            <?php endif; ?>
        </div>
        <div>
            <h1 class="text-2xl font-bold text-emerald-900 tracking-tight"><?= $titleText ?></h1>
            <p class="text-sm text-emerald-500 mt-0.5">Enter the student's details below.</p>
        </div>
    </div>

    <!-- ══════════════════════════════════════════════════════════ ALERTS -->
    <?php if (isset($_GET['error'])): ?>
        <div id="alertBox" class="flex items-center gap-3 bg-red-50 border border-red-200 text-red-800 px-5 py-4 rounded-xl mb-6 shadow-sm max-w-2xl w-full">
            <svg class="w-5 h-5 text-red-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
            <span class="text-sm font-medium">
                <?php if ($_GET['error'] === 'duplicate_email'): ?>
                    A student with this email address already exists!
                <?php else: ?>
                    Invalid data provided. Please check the form fields.
                <?php endif; ?>
            </span>
        </div>
    <?php endif; ?>

    <!-- ══════════════════════════════════════════════════════════ FORM CARD -->
    <div class="bg-white rounded-2xl border border-emerald-100 shadow-sm overflow-hidden max-w-2xl w-full">

        <!-- Card Header -->
        <div class="bg-gradient-to-r from-emerald-700 to-emerald-600 px-6 py-4 flex items-center gap-3">
            <div class="h-8 w-8 rounded-lg bg-white/15 flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
            <span class="text-white font-semibold text-sm tracking-wide">Student Details</span>
        </div>

        <!-- Form Body -->
        <form action="../application/studentcontroller.php" method="POST" class="px-6 py-7 space-y-6">
            <input type="hidden" name="action" value="<?= $action ?>">
            <?php if ($isEdit): ?>
                <input type="hidden" name="student_id" value="<?= $student['student_id'] ?>">
            <?php endif; ?>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- First Name -->
                <div class="sm:col-span-1">
                    <label for="first_name" class="block text-sm font-semibold text-emerald-800 mb-1.5">
                        First Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="first_name" name="first_name" required placeholder="e.g. Jane"
                        class="w-full px-4 py-2.5 rounded-xl border border-emerald-200 text-emerald-900 placeholder-emerald-300 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all duration-200"
                        value="<?= $firstName ?>">
                </div>

                <!-- Last Name -->
                <div class="sm:col-span-1">
                    <label for="last_name" class="block text-sm font-semibold text-emerald-800 mb-1.5">
                        Last Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="last_name" name="last_name" required placeholder="e.g. Doe"
                        class="w-full px-4 py-2.5 rounded-xl border border-emerald-200 text-emerald-900 placeholder-emerald-300 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all duration-200"
                        value="<?= $lastName ?>">
                </div>
            </div>

            <!-- Email -->
            <div>
                <label for="contact_email" class="block text-sm font-semibold text-emerald-800 mb-1.5">
                    Email Address <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5">
                        <svg class="w-4 h-4 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <input type="email" id="contact_email" name="contact_email" required placeholder="jane.doe@example.com"
                        class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-emerald-200 text-emerald-900 placeholder-emerald-300 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all duration-200"
                        value="<?= $contactEmail ?>">
                </div>
            </div>

            <!-- Divider -->
            <div class="border-t border-emerald-50 pt-2"></div>

            <!-- Actions -->
            <div class="flex flex-col sm:flex-row gap-3">
                <a href="index.php?page=students"
                    class="flex-1 inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl border border-emerald-200 text-emerald-700 font-semibold text-sm hover:bg-emerald-50 transition-colors duration-200">
                    Cancel
                </a>
                <button type="submit"
                    class="flex-1 inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 active:scale-95 text-white font-semibold text-sm shadow-md shadow-emerald-200 transition-all duration-200">
                    <?= $buttonText ?>
                </button>
            </div>
        </form>
    </div>
</div>