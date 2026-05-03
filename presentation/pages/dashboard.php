<?php

$deptCount = $conn->query("SELECT COUNT(*) AS total FROM departments")->fetch_assoc()['total'];
$studentCount = $conn->query("SELECT COUNT(*) AS total FROM students")->fetch_assoc()['total'];
$courseCount = $conn->query("SELECT COUNT(*) AS total FROM courses")->fetch_assoc()['total'];
$enrollCount = $conn->query("SELECT COUNT(*) AS total FROM enrollments")->fetch_assoc()['total'];


$activeCourses = $conn->query("SELECT COUNT(*) AS total FROM courses WHERE total_enrolled > 0")->fetch_assoc()['total'];


$recent = $conn->query("
    SELECT s.first_name, s.last_name, c.course_name, e.enrollment_date
    FROM enrollments e
    JOIN students s ON e.student_id = s.student_id
    JOIN courses c ON e.course_id = c.course_id
    ORDER BY e.enrollment_date DESC
    LIMIT 6
");


$topCourses = $conn->query("
    SELECT course_name, total_enrolled
    FROM courses
    ORDER BY total_enrolled DESC
    LIMIT 5
");
?>

<div class="max-w-7xl mx-auto p-6 bg-gray-50 min-h-screen">

    <!-- HEADER -->
    <div class="mb-8">
        <h1 class="text-4xl font-extrabold text-emerald-900 tracking-tight">
            System Dashboard
        </h1>
        <p class="text-emerald-600 mt-1 text-sm font-medium">
            Real-time monitoring of UOVT Student Management System
        </p>
    </div>

    <!-- KPI CARDS -->
    <div class="grid grid-cols-1 md:grid-cols-5 gap-6 mb-10">

        <!-- Departments -->
        <div class="bg-white rounded-2xl shadow border border-emerald-100 p-5">
            <p class="text-sm text-emerald-600 font-semibold">Departments</p>
            <h2 class="text-3xl font-bold text-emerald-900"><?= $deptCount ?></h2>
            <p class="text-xs text-gray-400 mt-1">Total registered units</p>
        </div>

        <!-- Students -->
        <div class="bg-white rounded-2xl shadow border border-emerald-100 p-5">
            <p class="text-sm text-emerald-600 font-semibold">Students</p>
            <h2 class="text-3xl font-bold text-emerald-900"><?= $studentCount ?></h2>
            <p class="text-xs text-gray-400 mt-1">Active student records</p>
        </div>

        <!-- Courses -->
        <div class="bg-white rounded-2xl shadow border border-emerald-100 p-5">
            <p class="text-sm text-emerald-600 font-semibold">Courses</p>
            <h2 class="text-3xl font-bold text-emerald-900"><?= $courseCount ?></h2>
            <p class="text-xs text-gray-400 mt-1">Available modules</p>
        </div>

        <!-- Enrollments -->
        <div class="bg-white rounded-2xl shadow border border-emerald-100 p-5">
            <p class="text-sm text-emerald-600 font-semibold">Enrollments</p>
            <h2 class="text-3xl font-bold text-emerald-900"><?= $enrollCount ?></h2>
            <p class="text-xs text-gray-400 mt-1">Total registrations</p>
        </div>

        <!-- Active Courses -->
        <div class="bg-white rounded-2xl shadow border border-emerald-100 p-5">
            <p class="text-sm text-emerald-600 font-semibold">Active Courses</p>
            <h2 class="text-3xl font-bold text-emerald-900"><?= $activeCourses ?></h2>
            <p class="text-xs text-gray-400 mt-1">With students enrolled</p>
        </div>

    </div>

    <!-- MAIN GRID -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- LEFT: RECENT ACTIVITY -->
        <div class="lg:col-span-2 bg-white rounded-2xl shadow border border-emerald-100 p-6">

            <h2 class="text-xl font-bold text-emerald-900 mb-4">
                Recent Enrollments
            </h2>

            <div class="space-y-4">

                <?php while ($r = $recent->fetch_assoc()): ?>
                    <div class="flex justify-between items-center p-3 rounded-xl hover:bg-emerald-50 transition">

                        <div>
                            <p class="font-semibold text-gray-800">
                                <?= $r['first_name'] . " " . $r['last_name'] ?>
                            </p>
                            <p class="text-xs text-gray-500">
                                <?= $r['course_name'] ?>
                            </p>
                        </div>

                        <span class="text-xs text-emerald-600 font-medium">
                            <?= date("M d, H:i", strtotime($r['enrollment_date'])) ?>
                        </span>

                    </div>
                <?php endwhile; ?>

            </div>
        </div>

        <!-- RIGHT: SYSTEM INSIGHTS -->
        <div class="space-y-6">

            <!-- TOP COURSES -->
            <div class="bg-white rounded-2xl shadow border border-emerald-100 p-6">

                <h2 class="text-lg font-bold text-emerald-900 mb-4">
                    Top Courses
                </h2>

                <div class="space-y-3">

                    <?php while ($c = $topCourses->fetch_assoc()): ?>
                        <div class="flex justify-between items-center">

                            <span class="text-sm text-gray-700 font-medium">
                                <?= $c['course_name'] ?>
                            </span>

                            <span class="bg-emerald-100 text-emerald-700 px-2 py-1 rounded-lg text-xs font-bold">
                                <?= $c['total_enrolled'] ?>
                            </span>

                        </div>
                    <?php endwhile; ?>

                </div>
            </div>

            <!-- SYSTEM STATUS -->
            <div class="bg-white rounded-2xl shadow border border-emerald-100 p-6">

                <h2 class="text-lg font-bold text-emerald-900 mb-4">
                    System Status
                </h2>

                <div class="space-y-3 text-sm">

                    <div class="flex justify-between">
                        <span class="text-gray-600">Database</span>
                        <span class="text-emerald-600 font-bold">Healthy</span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-gray-600">Stored Procedures</span>
                        <span class="text-emerald-600 font-bold">Active</span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-gray-600">Triggers</span>
                        <span class="text-emerald-600 font-bold">Running</span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-gray-600">Enrollments Sync</span>
                        <span class="text-emerald-600 font-bold">OK</span>
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>