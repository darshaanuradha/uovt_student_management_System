<?php
require_once '../application/db.php';

// ── Fetch all courses via stored procedure ────────────────────────────────────
$courses = [];
$result = $conn->query("CALL sp_get_courses()");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $courses[] = $row;
    }
    $result->close();
    $conn->next_result(); // flush multi-result from stored procedure
}

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

// ── Fetch single course for editing (edit mode) ───────────────────────────────
$editCourse = null;
$editId = (int)($_GET['edit'] ?? 0);
if ($editId > 0) {
    $stmt = $conn->prepare("CALL sp_get_course_by_id(?)");
    $stmt->bind_param("i", $editId);
    $stmt->execute();
    $eResult = $stmt->get_result();
    if ($eResult) {
        $editCourse = $eResult->fetch_assoc();
    }
    $stmt->close();
    $conn->next_result();
}

$conn->close();

// ── Toast message helpers ─────────────────────────────────────────────────────
$toastMsg  = '';
$toastType = 'success';
if (isset($_GET['success'])) {
    $map = [
        'created' => 'Course added successfully!',
        'updated' => 'Course updated successfully!',
        'deleted' => 'Course deleted successfully!',
    ];
    $toastMsg = $map[$_GET['success']] ?? 'Operation successful.';
} elseif (isset($_GET['error'])) {
    $toastType = 'error';
    $map = [
        'validation'    => 'Please fill in all required fields.',
        'invalid'       => 'Invalid course selected.',
        'unknownaction' => 'Unknown action requested.',
    ];
    $toastMsg = $map[$_GET['error']] ?? 'Something went wrong.';
}
?>

<!-- ══════════════════════════════════════════════════════════ TOAST NOTIFICATION -->
<?php if ($toastMsg): ?>
    <div id="toast"
        class="fixed top-6 right-6 z-50 flex items-center gap-3 px-5 py-4 rounded-xl shadow-2xl text-white text-sm font-medium transition-all duration-500
            <?php echo $toastType === 'success'
                ? 'bg-gradient-to-r from-emerald-500 to-emerald-600'
                : 'bg-gradient-to-r from-red-500 to-red-600'; ?>">
        <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <?php if ($toastType === 'success'): ?>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            <?php else: ?>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            <?php endif; ?>
        </svg>
        <?php echo htmlspecialchars($toastMsg); ?>
    </div>
    <script>
        setTimeout(() => {
            const t = document.getElementById('toast');
            if (t) {
                t.style.opacity = '0';
                setTimeout(() => t.remove(), 500);
            }
        }, 3500);
    </script>
<?php endif; ?>

<!-- ══════════════════════════════════════════════════════════ PAGE HEADER -->
<div class="mb-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-emerald-900 tracking-tight">Course Management</h1>
            <p class="text-sm text-emerald-600 mt-1">Manage all courses and assigned lecturers</p>
        </div>
        <button id="openAddModal"
            class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 active:scale-95
                       text-white font-semibold px-5 py-2.5 rounded-xl shadow-md shadow-emerald-200
                       transition-all duration-200">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
            </svg>
            Add New Course
        </button>
    </div>

    <!-- Stats bar -->
    <div class="mt-5 grid grid-cols-2 sm:grid-cols-3 gap-4">
        <div class="bg-white rounded-xl border border-emerald-100 shadow-sm px-5 py-4 flex items-center gap-4">
            <div class="h-10 w-10 rounded-lg bg-emerald-100 flex items-center justify-center">
                <svg class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253" />
                </svg>
            </div>
            <div>
                <p class="text-xs text-emerald-500 font-medium uppercase tracking-wider">Total Courses</p>
                <p class="text-2xl font-bold text-emerald-900"><?php echo count($courses); ?></p>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-emerald-100 shadow-sm px-5 py-4 flex items-center gap-4">
            <div class="h-10 w-10 rounded-lg bg-emerald-100 flex items-center justify-center">
                <svg class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0" />
                </svg>
            </div>
            <div>
                <p class="text-xs text-emerald-500 font-medium uppercase tracking-wider">Total Enrolled</p>
                <p class="text-2xl font-bold text-emerald-900">
                    <?php echo array_sum(array_column($courses, 'total_enrolled')); ?>
                </p>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-emerald-100 shadow-sm px-5 py-4 flex items-center gap-4">
            <div class="h-10 w-10 rounded-lg bg-emerald-100 flex items-center justify-center">
                <svg class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
            <div>
                <p class="text-xs text-emerald-500 font-medium uppercase tracking-wider">Lecturers</p>
                <p class="text-2xl font-bold text-emerald-900"><?php echo count($lecturers); ?></p>
            </div>
        </div>
    </div>
</div>

<!-- ══════════════════════════════════════════════════════════ COURSES TABLE -->
<div class="bg-white rounded-2xl border border-emerald-100 shadow-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-emerald-50 flex items-center justify-between">
        <h2 class="text-sm font-semibold text-emerald-800 uppercase tracking-wider">All Courses</h2>
        <span class="text-xs text-emerald-400"><?php echo count($courses); ?> record(s)</span>
    </div>

    <?php if (empty($courses)): ?>
        <div class="flex flex-col items-center justify-center py-20 text-center">
            <div class="h-16 w-16 rounded-full bg-emerald-50 flex items-center justify-center mb-4">
                <svg class="w-8 h-8 text-emerald-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13" />
                </svg>
            </div>
            <p class="text-emerald-700 font-semibold">No courses found</p>
            <p class="text-emerald-400 text-sm mt-1">Click "Add New Course" to get started.</p>
        </div>
    <?php else: ?>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-emerald-50/70 text-emerald-600 uppercase text-xs tracking-wider">
                        <th class="px-6 py-3 text-left font-semibold">#</th>
                        <th class="px-6 py-3 text-left font-semibold">Course Name</th>
                        <th class="px-6 py-3 text-left font-semibold">Assigned Lecturer</th>
                        <th class="px-6 py-3 text-center font-semibold">Enrolled</th>
                        <th class="px-6 py-3 text-center font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-emerald-50">
                    <?php foreach ($courses as $i => $course): ?>
                        <tr class="hover:bg-emerald-50/40 transition-colors duration-150 group">
                            <td class="px-6 py-4 text-emerald-400 font-mono text-xs"><?php echo $i + 1; ?></td>
                            <td class="px-6 py-4">
                                <span class="font-semibold text-emerald-900">
                                    <?php echo htmlspecialchars($course['course_name']); ?>
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <?php if ($course['lecturer_name']): ?>
                                    <div class="flex items-center gap-2">
                                        <div class="h-7 w-7 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 font-bold text-xs shrink-0">
                                            <?php echo strtoupper(substr($course['lecturer_name'], 0, 1)); ?>
                                        </div>
                                        <span class="text-emerald-700"><?php echo htmlspecialchars($course['lecturer_name']); ?></span>
                                    </div>
                                <?php else: ?>
                                    <span class="text-emerald-300 italic">Unassigned</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center justify-center h-7 min-w-[2rem] px-2 rounded-full
                                         bg-emerald-100 text-emerald-700 font-semibold text-xs">
                                    <?php echo (int)$course['total_enrolled']; ?>
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    <!-- Edit button -->
                                    <a href="index.php?page=coursesDepartments&edit=<?php echo $course['course_id']; ?>"
                                        id="edit-course-<?php echo $course['course_id']; ?>"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium
                                          bg-emerald-50 text-emerald-700 border border-emerald-200
                                          hover:bg-emerald-600 hover:text-white hover:border-emerald-600
                                          transition-all duration-200">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        Edit
                                    </a>
                                    <!-- Delete button -->
                                    <form action="../application/courseController.php" method="POST"
                                        onsubmit="return confirm('Delete \'<?php echo addslashes($course['course_name']); ?>\'? This cannot be undone.')">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="course_id" value="<?php echo $course['course_id']; ?>">
                                        <button type="submit"
                                            id="delete-course-<?php echo $course['course_id']; ?>"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium
                                                   bg-red-50 text-red-600 border border-red-200
                                                   hover:bg-red-500 hover:text-white hover:border-red-500
                                                   transition-all duration-200">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<!-- ══════════════════════════════════════════════════════════ ADD/EDIT MODAL -->
<div id="courseModal"
    class="fixed inset-0 z-50 flex items-center justify-center p-4
            bg-black/40 backdrop-blur-sm
            <?php echo $editCourse ? '' : 'hidden'; ?>
            transition-opacity duration-300">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden
                transform transition-all duration-300">

        <!-- Modal header -->
        <div class="bg-gradient-to-r from-emerald-700 to-emerald-600 px-6 py-5 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="h-9 w-9 rounded-lg bg-white/20 flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13" />
                    </svg>
                </div>
                <h3 id="modalTitle" class="text-white font-bold text-lg">
                    <?php echo $editCourse ? 'Edit Course' : 'Add New Course'; ?>
                </h3>
            </div>
            <button id="closeModal"
                class="h-8 w-8 rounded-lg bg-white/10 hover:bg-white/25 flex items-center justify-center
                           text-white transition-colors duration-150">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Modal body: single form for both Add & Edit -->
        <form action="../application/courseController.php" method="POST" class="px-6 py-6 space-y-5">
            <input type="hidden" name="action" id="formAction" value="<?php echo $editCourse ? 'update' : 'create'; ?>">
            <input type="hidden" name="course_id" id="formCourseId" value="<?php echo $editCourse ? $editCourse['course_id'] : ''; ?>">

            <!-- Course Name -->
            <div>
                <label for="course_name" class="block text-sm font-semibold text-emerald-800 mb-1.5">
                    Course Name <span class="text-red-500">*</span>
                </label>
                <input type="text"
                    id="course_name"
                    name="course_name"
                    required
                    maxlength="150"
                    placeholder="e.g. Web Application Development"
                    value="<?php echo $editCourse ? htmlspecialchars($editCourse['course_name']) : ''; ?>"
                    class="w-full px-4 py-2.5 rounded-xl border border-emerald-200 text-emerald-900 placeholder-emerald-300
                              focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent
                              transition-all duration-200 text-sm">
            </div>

            <!-- Lecturer Dropdown -->
            <div>
                <label for="lecturer_id" class="block text-sm font-semibold text-emerald-800 mb-1.5">
                    Assigned Lecturer <span class="text-red-500">*</span>
                </label>
                <select id="lecturer_id"
                    name="lecturer_id"
                    required
                    class="w-full px-4 py-2.5 rounded-xl border border-emerald-200 text-emerald-900
                               focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent
                               transition-all duration-200 text-sm bg-white">
                    <option value="" disabled <?php echo $editCourse ? '' : 'selected'; ?>>— Select a lecturer —</option>
                    <?php foreach ($lecturers as $lecturer): ?>
                        <option value="<?php echo $lecturer['lecturer_id']; ?>"
                            <?php echo ($editCourse && $editCourse['lecturer_id'] == $lecturer['lecturer_id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($lecturer['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Action buttons -->
            <div class="flex gap-3 pt-2">
                <button type="button" id="cancelModal"
                    class="flex-1 px-4 py-2.5 rounded-xl border border-emerald-200 text-emerald-700 font-semibold text-sm
                               hover:bg-emerald-50 transition-colors duration-200">
                    Cancel
                </button>
                <button type="submit" id="submitBtn"
                    class="flex-1 px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-sm
                               shadow-md shadow-emerald-200 transition-all duration-200 active:scale-95">
                    <?php echo $editCourse ? 'Save Changes' : 'Add Course'; ?>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ══════════════════════════════════════════════════════════ MODAL JAVASCRIPT -->
<script>
    const modal = document.getElementById('courseModal');
    const modalTitle = document.getElementById('modalTitle');
    const formAction = document.getElementById('formAction');
    const formCourseId = document.getElementById('formCourseId');
    const courseNameInput = document.getElementById('course_name');
    const lecturerSelect = document.getElementById('lecturer_id');
    const submitBtn = document.getElementById('submitBtn');

    function openModal(mode, id, name, lecturerId) {
        if (mode === 'edit') {
            modalTitle.textContent = 'Edit Course';
            formAction.value = 'update';
            formCourseId.value = id;
            courseNameInput.value = name;
            lecturerSelect.value = lecturerId;
            submitBtn.textContent = 'Save Changes';
        } else {
            modalTitle.textContent = 'Add New Course';
            formAction.value = 'create';
            formCourseId.value = '';
            courseNameInput.value = '';
            lecturerSelect.value = '';
            submitBtn.textContent = 'Add Course';
        }
        modal.classList.remove('hidden');
        courseNameInput.focus();
    }

    function closeModal() {
        modal.classList.add('hidden');
        // Remove ?edit= from URL without reload
        const url = new URL(window.location.href);
        url.searchParams.delete('edit');
        history.replaceState(null, '', url.toString());
    }

    // Open for Add
    document.getElementById('openAddModal').addEventListener('click', () => openModal('add'));

    // Close buttons
    document.getElementById('closeModal').addEventListener('click', closeModal);
    document.getElementById('cancelModal').addEventListener('click', closeModal);

    // Close on backdrop click
    modal.addEventListener('click', (e) => {
        if (e.target === modal) closeModal();
    });

    // Close on Escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closeModal();
    });

    // Auto-open in edit mode if PHP flagged it
    <?php if ($editCourse): ?>
        openModal(
            'edit',
            <?php echo $editCourse['course_id']; ?>,
            <?php echo json_encode($editCourse['course_name']); ?>,
            <?php echo (int)$editCourse['lecturer_id']; ?>
        );
    <?php endif; ?>
</script>