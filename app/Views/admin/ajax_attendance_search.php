<div class="table-responsive">
    <table class="table table-striped table-bordered" id="attendance_table">
        <thead class="thead-dark">
            <tr>
                <th>Student Name</th>
                <th>Roll Number</th>
                <th>Grade</th>
                <th>Attendance Status</th>
                <th>Attendance Date</th>
                <th>Teacher</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($result as $row) : ?>
                <tr>
                    <td><?= $row->student_name ?></td>
                    <td><?= $row->student_roll_number ?></td>
                    <td><?= $row->grade_name ?></td>
                    <?php if ($row->attendance_status == 'Present') : ?>
                        <td><span class="badge bg_lightgreen">Present</span></td>
                    <?php else : ?>
                        <td><span class="badge bg_tomato text-white">Absent</span></td>
                    <?php endif ?>
                    <td><?= $row->attendance_date ?></td>
                    <td><?= $row->teacher_name ?></td>
                </tr>
            <?php endforeach ?>
        </tbody>

    </table>
</div>

<!-- JS Data Tables -->
<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
<script>
    $('#attendance_table').DataTable({
        "order": [],
        "search": {
            "smart": false
        }
    });
</script>