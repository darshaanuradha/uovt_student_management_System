<?php
require_once '../application/db.php';

// ── Guard: Admin only ─────────────────────────────────────────────────────────
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Admin') {
    header('Location: ../presentation/index.php?page=login');
    exit();
}

// ── Determine mode: Add or Edit ───────────────────────────────────────────────
$editId     = (int)($_GET['edit'] ?? 0);
$isEditMode = $editId > 0;
$editCourse = null;

// ── Fetch all lecturers for dropdown ─────────────────────────────────────────
$lecturers = [];
$lResult = $conn->query("CALL sp_get_all_lecturers()");
if ($lResult) {
    while ($row = $lResult->fetch_assoc()) {
        $lecturers[] = $row;
    }
    $lResult->close();
    $conn->next_result();
}

// ── If edit mode: fetch the course to pre-fill the form ──────────────────────
if ($isEditMode) {
    $stmt = $conn->prepare("CALL sp_get_course_by_id(?)");
    $stmt->bind_param("i", $editId);
    $stmt->execute();
    $eResult = $stmt->get_result();
    if ($eResult) {
        $editCourse = $eResult->fetch_assoc();
    }
    $stmt->close();
    $conn->next_result();

    // If course not found, redirect back with error
    if (!$editCourse) {
        $conn->close();
        header('Location: index.php?page=coursesDepartments&error=invalid');
        exit();
    }
}

$conn->close();

// ── Labels & values based on mode ────────────────────────────────────────────
$pageTitle    = $isEditMode ? 'Edit Course'      : 'Add New Course';
$formAction   = $isEditMode ? 'update'           : 'create';
$submitLabel  = $isEditMode ? 'Save Changes'     : 'Add Course';
$courseNameVal = $isEditMode ? htmlspecialchars($editCourse['course_name']) : '';
$lecturerIdVal = $isEditMode ? (int)$editCourse['lecturer_id'] : 0;
$courseIdVal   = $isEditMode ? (int)$editCourse['course_id']   : 0;
?>

<!-- ══════════════════════════════════════════════════════ PAGE WRAPPER -->
<div class="min-h-full flex flex-col">

    <!-- ── Breadcrumb ────────────────────────────────────────────────────── -->
    <nav class="mb-6 flex items-center gap-2 text-sm text-emerald-500">
        <a href="index.php?page=coursesDepartments"
           class="hover:text-emerald-700 transition-colors duration-150 flex items-center gap-1.5">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
            </svg>
            Courses &amp; Departments
        </a>
        <svg class="w-4 h-4 text-emerald-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <span class="text-emerald-700 font-medium"><?php echo $pageTitle; ?></span>
    </nav>

    <!-- ── Page Header ───────────────────────────────────────────────────── -->
    <div class="mb-8 flex items-start gap-4">
        <div class="h-12 w-12 rounded-2xl bg-gradient-to-br from-emerald-500 to-emerald-700
                    flex items-center justify-center shadow-lg shadow-emerald-200 shrink-0">
            <?php if ($isEditMode): ?>
                <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5
                             m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
            <?php else: ?>
                <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                          d="M12 4v16m8-8H4" />
                </svg>
            <?php endif; ?>
        </div>
        <div>
            <h1 class="text-2xl font-bold text-emerald-900 tracking-tight"><?php echo $pageTitle; ?></h1>
            <p class="text-sm text-emerald-500 mt-0.5">
                <?php echo $isEditMode
                    ? 'Update the details for this course below.'
                    : 'Fill in the details to create a new course.'; ?>
            </p>
        </div>
    </div>

    <!-- ── Form Card ─────────────────────────────────────────────────────── -->
    <div class="bg-white rounded-2xl border border-emerald-100 shadow-sm overflow-hidden max-w-2xl w-full">

        <!-- Card header bar -->
        <div class="bg-gradient-to-r from-emerald-700 to-emerald-600 px-6 py-4 flex items-center gap-3">
            <div class="h-8 w-8 rounded-lg bg-white/15 flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586
                             a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
            <span class="text-white font-semibold text-sm tracking-wide">Course Details</span>
            <?php if ($isEditMode): ?>
                <span class="ml-auto inline-flex items-center gap-1 text-xs font-medium
                             bg-white/15 text-white px-2.5 py-1 rounded-full">
                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536
                                 L6.5 21.036H3v-3.572L16.732 3.732z" />
                    </svg>
                    Editing ID #<?php echo $courseIdVal; ?>
                </span>
            <?php else: ?>
                <span class="ml-auto inline-flex items-center gap-1 text-xs font-medium
                             bg-emerald-500/30 text-emerald-100 px-2.5 py-1 rounded-full">
                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 4v16m8-8H4" />
                    </svg>
                    New Course
                </span>
            <?php endif; ?>
        </div>

        <!-- Form body -->
        <form action="../application/courseController.php"
              method="POST"
              id="courseForm"
              class="px-6 py-7 space-y-6">

            <!-- Hidden fields -->
            <input type="hidden" name="action"    value="<?php echo $formAction; ?>">
            <?php if ($isEditMode): ?>
                <input type="hidden" name="course_id" value="<?php echo $courseIdVal; ?>">
            <?php endif; ?>

            <!-- ── Course Name ─────────────────────────────────────────── -->
            <div>
                <label for="course_name"
                       class="block text-sm font-semibold text-emerald-800 mb-1.5">
                    Course Name <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5">
                        <svg class="w-4 h-4 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13" />
                        </svg>
                    </div>
                    <input type="text"
                           id="course_name"
                           name="course_name"
                           required
                           maxlength="150"
                           value="<?php echo $courseNameVal; ?>"
                           placeholder="e.g. Web Application Development"
                           class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-emerald-200
                                  text-emerald-900 placeholder-emerald-300 text-sm
                                  focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent
                                  transition-all duration-200">
                </div>
                <p class="mt-1.5 text-xs text-emerald-400">Maximum 150 characters.</p>
            </div>

            <!-- ── Assigned Lecturer ───────────────────────────────────── -->
            <div>
                <label for="lecturer_id"
                       class="block text-sm font-semibold text-emerald-800 mb-1.5">
                    Assigned Lecturer <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5">
                        <svg class="w-4 h-4 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <select id="lecturer_id"
                            name="lecturer_id"
                            required
                            class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-emerald-200
                                   text-emerald-900 text-sm bg-white
                                   focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent
                                   transition-all duration-200 appearance-none">
                        <option value="" disabled <?php echo $isEditMode ? '' : 'selected'; ?>>
                            — Select a lecturer —
                        </option>
                        <?php foreach ($lecturers as $lecturer): ?>
                            <option value="<?php echo $lecturer['lecturer_id']; ?>"
                                <?php echo ($lecturerIdVal === (int)$lecturer['lecturer_id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($lecturer['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <!-- Custom chevron -->
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3.5">
                        <svg class="w-4 h-4 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>
                <?php if (empty($lecturers)): ?>
                    <p class="mt-1.5 text-xs text-amber-500 flex items-center gap-1">
                        <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 9v2m0 4h.01M12 2a10 10 0 110 20A10 10 0 0112 2z" />
                        </svg>
                        No lecturers found. Please add lecturers first.
                    </p>
                <?php else: ?>
                    <p class="mt-1.5 text-xs text-emerald-400">
                        <?php echo count($lecturers); ?> lecturer(s) available.
                    </p>
                <?php endif; ?>
            </div>

            <!-- ── Divider ─────────────────────────────────────────────── -->
            <div class="border-t border-emerald-50 pt-2"></div>

            <!-- ── Action Buttons ──────────────────────────────────────── -->
            <div class="flex flex-col sm:flex-row gap-3">
                <!-- Cancel -->
                <a href="index.php?page=coursesDepartments"
                   id="cancelBtn"
                   class="flex-1 inline-flex items-center justify-center gap-2
                          px-5 py-2.5 rounded-xl border border-emerald-200
                          text-emerald-700 font-semibold text-sm
                          hover:bg-emerald-50 transition-colors duration-200">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Cancel
                </a>

                <!-- Submit -->
                <button type="submit"
                        id="submitBtn"
                        class="flex-1 inline-flex items-center justify-center gap-2
                               px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700
                               active:scale-95 text-white font-semibold text-sm
                               shadow-md shadow-emerald-200 transition-all duration-200">
                    <?php if ($isEditMode): ?>
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M5 13l4 4L19 7" />
                        </svg>
                    <?php else: ?>
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                  d="M12 4v16m8-8H4" />
                        </svg>
                    <?php endif; ?>
                    <?php echo $submitLabel; ?>
                </button>
            </div>
        </form>
    </div>

    <!-- ── Info note ─────────────────────────────────────────────────────── -->
    <div class="mt-5 max-w-2xl flex items-start gap-2.5 px-4 py-3.5
                bg-emerald-50 border border-emerald-100 rounded-xl text-xs text-emerald-600">
        <svg class="w-4 h-4 shrink-0 mt-0.5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 110 20A10 10 0 0112 2z" />
        </svg>
        <span>
            All course operations are handled securely through stored procedures.
            Fields marked <span class="text-red-500 font-semibold">*</span> are required.
        </span>
    </div>

</div>

<!-- ══════════════════════════════════════════════════════ CLIENT-SIDE VALIDATION -->
<script>
document.getElementById('courseForm').addEventListener('submit', function (e) {
    const name     = document.getElementById('course_name').value.trim();
    const lecturer = document.getElementById('lecturer_id').value;
    const btn      = document.getElementById('submitBtn');

    if (!name || !lecturer) {
        e.preventDefault();
        // Shake the empty fields
        [document.getElementById('course_name'), document.getElementById('lecturer_id')].forEach(el => {
            if (!el.value.trim()) {
                el.classList.add('ring-2', 'ring-red-400', 'border-red-300');
                el.addEventListener('input', () => {
                    el.classList.remove('ring-2', 'ring-red-400', 'border-red-300');
                }, { once: true });
            }
        });
        return;
    }

    // Loading state
    btn.disabled = true;
    btn.innerHTML = `
        <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581
                     m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
        </svg>
        Processing…`;
});
</script>
