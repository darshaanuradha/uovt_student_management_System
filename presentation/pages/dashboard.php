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

<div class="min-h-full flex flex-col pb-10">

    <!-- ══════════════════════════════════════════════════════════ PAGE HEADER -->
    <div class="mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-emerald-900 tracking-tight">System Dashboard</h1>
                <p class="text-sm text-emerald-600 mt-1">Real-time monitoring of UOVT Student Management System</p>
            </div>

            <!-- Date Badge -->
            <div class="inline-flex items-center gap-2 bg-white px-4 py-2 rounded-xl border border-emerald-100 shadow-sm text-sm font-semibold text-emerald-700 shrink-0">
                <svg class="w-4 h-4 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <?= date("F d, Y") ?>
            </div>
        </div>
    </div>

    <!-- ══════════════════════════════════════════════════════════ STATS GRID -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mb-8">

        <!-- Departments -->
        <div class="bg-white rounded-xl border border-emerald-100 shadow-sm px-5 py-4 flex items-center gap-4 hover:shadow-md transition-shadow duration-200">
            <div class="h-10 w-10 rounded-lg bg-emerald-100 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
            </div>
            <div>
                <p class="text-xs text-emerald-500 font-medium uppercase tracking-wider">Departments</p>
                <p class="text-2xl font-bold text-emerald-900"><?= $deptCount ?></p>
            </div>
        </div>

        <!-- Students -->
        <div class="bg-white rounded-xl border border-emerald-100 shadow-sm px-5 py-4 flex items-center gap-4 hover:shadow-md transition-shadow duration-200">
            <div class="h-10 w-10 rounded-lg bg-emerald-100 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </div>
            <div>
                <p class="text-xs text-emerald-500 font-medium uppercase tracking-wider">Students</p>
                <p class="text-2xl font-bold text-emerald-900"><?= $studentCount ?></p>
            </div>
        </div>

        <!-- Courses -->
        <div class="bg-white rounded-xl border border-emerald-100 shadow-sm px-5 py-4 flex items-center gap-4 hover:shadow-md transition-shadow duration-200">
            <div class="h-10 w-10 rounded-lg bg-emerald-100 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253" />
                </svg>
            </div>
            <div>
                <p class="text-xs text-emerald-500 font-medium uppercase tracking-wider">Courses</p>
                <p class="text-2xl font-bold text-emerald-900"><?= $courseCount ?></p>
            </div>
        </div>

        <!-- Enrollments -->
        <div class="bg-white rounded-xl border border-emerald-100 shadow-sm px-5 py-4 flex items-center gap-4 hover:shadow-md transition-shadow duration-200">
            <div class="h-10 w-10 rounded-lg bg-emerald-100 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
            <div>
                <p class="text-xs text-emerald-500 font-medium uppercase tracking-wider">Enrollments</p>
                <p class="text-2xl font-bold text-emerald-900"><?= $enrollCount ?></p>
            </div>
        </div>

        <!-- Active Courses -->
        <div class="bg-white rounded-xl border border-emerald-100 shadow-sm px-5 py-4 flex items-center gap-4 hover:shadow-md transition-shadow duration-200">
            <div class="h-10 w-10 rounded-lg bg-emerald-100 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                </svg>
            </div>
            <div>
                <p class="text-xs text-emerald-500 font-medium uppercase tracking-wider">Active</p>
                <p class="text-2xl font-bold text-emerald-900"><?= $activeCourses ?></p>
            </div>
        </div>

    </div>

    <!-- ══════════════════════════════════════════════════════════ DATA SECTIONS -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Recent Enrollments -->
        <div class="lg:col-span-2 bg-white rounded-2xl border border-emerald-100 shadow-sm overflow-hidden flex flex-col">

            <div class="bg-gradient-to-r from-emerald-700 to-emerald-600 px-6 py-4 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="h-8 w-8 rounded-lg bg-white/15 flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h2 class="text-white font-semibold text-sm tracking-wide">Recent Enrollments</h2>
                </div>
            </div>

            <div class="overflow-x-auto">
                <ul class="divide-y divide-emerald-50">
                    <?php if ($recent->num_rows > 0): ?>
                        <?php while ($r = $recent->fetch_assoc()): ?>
                            <li class="px-6 py-4 hover:bg-emerald-50/40 transition-colors duration-150 flex flex-col sm:flex-row sm:items-center justify-between gap-4 group">
                                <div class="flex items-center gap-4">
                                    <div class="h-9 w-9 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-700 font-bold text-xs shrink-0 border border-emerald-200">
                                        <?= strtoupper(substr($r['first_name'], 0, 1) . substr($r['last_name'], 0, 1)) ?>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-emerald-900 text-sm">
                                            <?= htmlspecialchars($r['first_name'] . " " . $r['last_name']) ?>
                                        </p>
                                        <p class="text-xs text-emerald-500 mt-0.5">
                                            <?= htmlspecialchars($r['course_name']) ?>
                                        </p>
                                    </div>
                                </div>
                                <span class="text-xs font-medium text-emerald-600 bg-emerald-50 px-3 py-1.5 rounded-lg border border-emerald-100 group-hover:bg-white transition-colors shrink-0">
                                    <?= date("M d, Y • H:i", strtotime($r['enrollment_date'])) ?>
                                </span>
                            </li>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <li class="px-6 py-8 text-center text-emerald-400 text-sm italic">
                            No recent enrollments found.
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>

        <!-- Sidebar (Top Courses) -->
        <div class="space-y-6">
            <div class="bg-white rounded-2xl border border-emerald-100 shadow-sm overflow-hidden flex flex-col">

                <div class="bg-gradient-to-r from-emerald-700 to-emerald-600 px-6 py-4 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="h-8 w-8 rounded-lg bg-white/15 flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <h2 class="text-white font-semibold text-sm tracking-wide">Top Courses</h2>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <ul class="divide-y divide-emerald-50">
                        <?php if ($topCourses->num_rows > 0): ?>
                            <?php while ($c = $topCourses->fetch_assoc()): ?>
                                <li class="px-6 py-4 hover:bg-emerald-50/40 transition-colors duration-150 flex justify-between items-center gap-4">
                                    <span class="text-sm font-semibold text-emerald-800 line-clamp-1">
                                        <?= htmlspecialchars($c['course_name']) ?>
                                    </span>
                                    <span class="inline-flex items-center justify-center h-7 min-w-[2rem] px-2 rounded-full bg-emerald-100 text-emerald-700 font-bold text-xs border border-emerald-200 shrink-0">
                                        <?= $c['total_enrolled'] ?>
                                    </span>
                                </li>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <li class="px-6 py-8 text-center text-emerald-400 text-sm italic">
                                No courses available.
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>

            </div>
        </div>

    </div>

</div>