<?php
// Define our CSS classes for active and inactive states
$activeClass = "bg-emerald-800/80 text-white shadow-md border border-emerald-500/30";
$inactiveClass = "text-emerald-100/80 border border-transparent hover:bg-emerald-800/40 hover:text-white hover:border-emerald-700/30";

// Define our Icon classes for active and inactive states
$activeIcon = "text-emerald-300";
$inactiveIcon = "text-emerald-500 transition-transform duration-200 group-hover:scale-110 group-hover:text-emerald-400";

// Grab the current page, defaulting to dashboard
$currentPage = $page ?? 'dashboard';
?>
<aside class="w-72 min-h-screen bg-gradient-to-b from-emerald-950 to-emerald-900 text-emerald-50 flex flex-col shadow-2xl border-r border-emerald-800/50 z-10 relative overflow-hidden">

    <div class="absolute top-0 left-0 w-full h-32 bg-emerald-500/10 blur-3xl rounded-full -translate-y-1/2"></div>

    <div class="p-6 border-b border-emerald-800/50 relative z-10">
        <div class="flex items-center gap-3 mb-4">
            <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-emerald-400 to-emerald-600 flex items-center justify-center shadow-lg shadow-emerald-900/50">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
                </svg>
            </div>
            <h2 class="text-2xl font-bold tracking-tight text-white">UOVT SMS</h2>
        </div>

        <div class="flex items-center gap-3 rounded-lg bg-emerald-900/40 p-3 border border-emerald-700/30 backdrop-blur-sm">
            <div class="relative flex h-3 w-3 items-center justify-center">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-400"></span>
            </div>
            <div class="flex flex-col">
                <span class="text-[10px] font-medium text-emerald-400 uppercase tracking-wider">Logged in as</span>
                <span class="text-sm font-semibold text-emerald-50"><?php echo htmlspecialchars($userRole); ?></span>
            </div>
        </div>
    </div>

    <nav class="flex-1 p-4 space-y-8 overflow-y-auto relative z-10 custom-scrollbar">

        <div>
            <p class="mb-3 px-3 text-xs font-semibold text-emerald-500/80 uppercase tracking-widest">Overview</p>
            <a href="index.php?page=dashboard" class="group flex items-center gap-3 rounded-xl px-3 py-2.5 transition-all duration-200 <?php echo $currentPage === 'dashboard' ? $activeClass : $inactiveClass; ?>">
                <svg class="h-5 w-5 <?php echo $currentPage === 'dashboard' ? $activeIcon : $inactiveIcon; ?>" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                </svg>
                <span class="font-medium text-sm">Dashboard Reports</span>
            </a>
        </div>

        <?php if ($userRole === 'Admin'): ?>
            <div>
                <p class="mb-3 px-3 text-xs font-semibold text-emerald-500/80 uppercase tracking-widest">Management</p>
                <div class="space-y-1">
                    <a href="index.php?page=manageStudents" class="group flex items-center gap-3 rounded-xl px-3 py-2.5 transition-all duration-200 <?php echo $currentPage === 'manageStudents' ? $activeClass : $inactiveClass; ?>">
                        <svg class="h-5 w-5 <?php echo $currentPage === 'manageStudents' ? $activeIcon : $inactiveIcon; ?>" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <span class="font-medium text-sm">Manage Students</span>
                    </a>

                    <a href="index.php?page=enrollments" class="group flex items-center gap-3 rounded-xl px-3 py-2.5 transition-all duration-200 <?php echo $currentPage === 'enrollments' ? $activeClass : $inactiveClass; ?>">
                        <svg class="h-5 w-5 <?php echo $currentPage === 'enrollments' ? $activeIcon : $inactiveIcon; ?>" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                        <span class="font-medium text-sm">Enrollments</span>
                    </a>

                    <a href="index.php?page=coursesDepartments" class="group flex items-center gap-3 rounded-xl px-3 py-2.5 transition-all duration-200 <?php echo $currentPage === 'coursesDepartments' ? $activeClass : $inactiveClass; ?>">
                        <svg class="h-5 w-5 <?php echo $currentPage === 'coursesDepartments' ? $activeIcon : $inactiveIcon; ?>" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        <span class="font-medium text-sm">Courses, Departments</span>
                    </a>
                    <a href="index.php?page=lecturers" class="group flex items-center gap-3 rounded-xl px-3 py-2.5 transition-all duration-200 <?php echo $currentPage === 'lecturers' ? $activeClass : $inactiveClass; ?>">
                        <svg class="h-5 w-5 <?php echo $currentPage === 'lecturers' ? $activeIcon : $inactiveIcon; ?>" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        <span class="font-medium text-sm">Lecturers</span>
                    </a>
                </div>
            </div>
        <?php endif; ?>
    </nav>

    <div class="p-4 border-t border-emerald-800/50 relative z-10 bg-emerald-950/50 backdrop-blur-sm">
        <form action="../application/auth.php" method="POST">
            <input type="hidden" name="action" value="logout">
            <button type="submit" class="group flex w-full items-center justify-center gap-2 rounded-xl bg-rose-500/10 px-4 py-2.5 font-medium text-rose-400 transition-all duration-200 hover:bg-rose-500 hover:text-white hover:shadow-md hover:shadow-rose-500/20">
                <svg class="h-5 w-5 transition-transform duration-200 group-hover:-translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                <span>Log out</span>
            </button>
        </form>
    </div>
</aside>