<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>UOVT Student Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-emerald-50 h-screen flex items-center justify-center font-sans">
   <div class="bg-white/80 backdrop-blur-md p-10 rounded-2xl shadow-xl border border-emerald-100 w-full max-w-md">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-extrabold text-emerald-800">UOVT SMS</h1>
            <p class="text-emerald-600 mt-2">Sign in to your account</p>
        </div>

        <?php if(isset($_GET['error'])): ?>
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4 text-sm text-center">
                Invalid credentials or empty fields.
            </div>
        <?php endif; ?>

        <form action="../application/auth.php" method="POST" class="space-y-6">
            <input type="hidden" name="action" value="login">
            <div>
                <label class="block text-sm font-medium text-emerald-700">Email Address</label>
                <input type="email" name="email" required class="mt-1 w-full p-3 border border-emerald-200 rounded-lg focus:ring-2 focus:ring-emerald-500 outline-none transition">
            </div>
            <div>
                <label class="block text-sm font-medium text-emerald-700">Password</label>
                <input type="password" name="password" required class="mt-1 w-full p-3 border border-emerald-200 rounded-lg focus:ring-2 focus:ring-emerald-500 outline-none transition">
            </div>
            <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 px-4 rounded-lg shadow-md transition duration-200">
                Log In
            </button>
        </form>
    </div>
</body>
</html>

