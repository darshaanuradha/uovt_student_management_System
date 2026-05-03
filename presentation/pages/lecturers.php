<?php
$lecturers = $conn->query("select * from lecturer_departments_view");
?>


<div class="max-w-6xl mx-auto mt-10 p-6 bg-white shadow-xl rounded-2xl border border-gray-100">

    <!-- Header -->
    <div class="flex items-center justify-between mb-6">

        <h1 class="text-3xl font-bold text-green-900 mb-6">
            Lecturers

        </h1>
        <div class="flex items-center justify-between bg-white p-4 rounded-xl shadow border">

            <div>
                <p class="text-xs text-emerald-900 font-medium uppercase tracking-wider">
                    Total Lecturers
                </p>
                <p class="text-2xl font-bold text-green-900">
                    <?php echo $lecturers->num_rows; ?>
                </p>
            </div>

            <img src="https://cdn-icons-png.flaticon.com/512/3135/3135755.png"
                class="w-10 h-10"
                alt="Lecturer Icon">

        </div>

        <a href="../presentation/index.php?page=add_lecturer">
            <button class="bg-green-900 hover:bg-green-900 text-white px-5 py-2 rounded-lg shadow-sm transition">
                + Add Lecturer
            </button>
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-900 rounded-lg overflow-hidden">

            <thead class="bg-green-900 text-white">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold uppercase tracking-wider">Department</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold uppercase tracking-wider">Actions</th>
                </tr>
            </thead>

            <tbody class="bg-white divide-y divide-gray-200">
                <?php while ($lecturer = $lecturers->fetch_assoc()) : ?>
                    <tr class="hover:bg-green-50 transition duration-200">

                        <td class="px-6 py-4 text-gray-700 font-medium">
                            <?php echo $lecturer['lecturer_id'] ?>
                        </td>

                        <td class="px-6 py-4 text-gray-800">
                            <?php echo $lecturer['name'] ?>
                        </td>

                        <td class="px-6 py-4 text-gray-600">
                            <?php echo $lecturer['email'] ?>
                        </td>

                        <td class="px-6 py-4">
                            <span class="px-3 py-1 text-sm font-semibold text-green-900 bg-green-100 rounded-full">
                                <?php echo $lecturer['dept_name'] ?>
                            </span>
                        </td>

                        <td class="px-6 py-4 text-sm font-medium">
                            <a href="../presentation/index.php?page=edit_lecturer&id=<?php echo $lecturer['lecturer_id']; ?>" class="text-green-600 hover:text-green-900">Edit</a>
                            <a href="../application/lecturerController.php?action=delete&id=<?php echo $lecturer['lecturer_id']; ?>"
                                onclick="return confirm('Are you sure you want to delete this lecturer?');"
                                class="text-red-600 hover:text-red-900 ml-3">
                                Delete
                            </a>

                    </tr>
                <?php endwhile; ?>
            </tbody>

        </table>
    </div>

</div>