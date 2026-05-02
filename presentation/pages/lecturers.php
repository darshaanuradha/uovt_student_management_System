<?php

$lecturers = $conn->query("select * from lecturer_departments_view");

?>

<h1>Lecturers</h1>
<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Department</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($lecturer = $lecturers->fetch_assoc()) : ?>
            <tr>
                <td><?php echo $lecturer['lecturer_id'] ?></td>
                <td><?php echo $lecturer['name'] ?></td>
                <td><?php echo $lecturer['email'] ?></td>
                <td><?php echo $lecturer['dept_name'] ?></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>