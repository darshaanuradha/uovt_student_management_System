

<h1>Add Lecturer</h1>

<form action="../application/lecturerController.php" method="POST">
    <div>
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
    </div>
    <div>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
    </div>
    <div>
        <label for="department">Department:</label>
        <select id="department" name="department" required>
            <option value="">Select Department</option>
            <?php
            $departments = $conn->query("SELECT * FROM departments");
            while ($dept = $departments->fetch_assoc()) {
                echo "<option value='{$dept['dept_id']}'>{$dept['dept_name']}</option>";
            }
            ?>
        </select>
    </div>
    <button type="submit">Add Lecturer</button>
</form>