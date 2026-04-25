<h1>Manage Students</h1>
<p>Here you can manage the students in your system. You can add new students, edit existing student information, or remove students from the system.</p>
<ul>
    <li><a href="addStudent.php">Add New Student</a></li>
    <li><a href="editStudent.php">Edit Existing Student</a></li>
    <li><a href="removeStudent.php">Remove Student</a></li>

    <form action="../application/studentcontroller.php" method="POST">
        <input type="text" name="student_id" placeholder="Student ID" required>
        <input type="text" name="student_name" placeholder="Student Name" required>
        <input type="email" name="student_email" placeholder="Student Email" required>
        <button type="submit" name="action" value="add_student">Add Student</button>
    </form>
</ul>