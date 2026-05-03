<div class="min-h-screen bg-gray-100 flex items-center justify-center py-10">

    <div class="w-full max-w-xl bg-white p-8 rounded-xl shadow-sm border border-gray-200">

        <h1 class="text-2xl font-semibold text-gray-800 mb-6">
            Add Lecturer
        </h1>

        <form action="../application/lecturerController.php" method="POST" class="space-y-5">

            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                    Name
                </label>
                <input type="text" id="name" name="name" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-600 focus:border-green-600 outline-none transition">
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                    Email
                </label>
                <input type="email" id="email" name="email" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-600 focus:border-green-600 outline-none transition">
            </div>

            <!-- Department -->
            <div>
                <label for="department" class="block text-sm font-medium text-gray-700 mb-1">
                    Department
                </label>
                <select id="department" name="department" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white focus:ring-2 focus:ring-green-600 focus:border-green-600 outline-none transition">
                    
                    <option value="">Select Department</option>

                    <?php
                    $departments = $conn->query("SELECT * FROM departments");
                    while ($dept = $departments->fetch_assoc()) {
                        echo "<option value='{$dept['dept_id']}'>{$dept['dept_name']}</option>";
                    }
                    ?>

                </select>
            </div>

            <!-- Button -->
            <div class="pt-2">
                <button type="submit"
                    class="w-full bg-green-700 hover:bg-green-800 text-white font-medium py-2.5 rounded-lg shadow-sm transition">
                    Add Lecturer
                </button>
            </div>

        </form>

    </div>

</div>