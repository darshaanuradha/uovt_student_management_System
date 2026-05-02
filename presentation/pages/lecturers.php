<?php
$lecturers = $conn->query("select * from lecturer_departments_view");
?>

<div class="max-w-6xl mx-auto mt-10 p-6 bg-white shadow-xl rounded-2xl border border-gray-100">



            <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            
            <h1 class="text-3xl font-bold text-green-900 mb-6">
                 Lecturers
            </h1>
            <button class="bg-green-900 hover:bg-green-900 text-white px-5 py-2 rounded-lg shadow-sm transition">
                + Add Lecturer
            </button>
        </div>

    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-900 rounded-lg overflow-hidden">

            <thead class="bg-green-900 text-white">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold uppercase tracking-wider">Department</th>
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

                    </tr>
                <?php endwhile; ?>
            </tbody>

        </table>
    </div>

</div>