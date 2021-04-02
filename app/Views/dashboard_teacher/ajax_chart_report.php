<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-9">
                <b>Attendance Chart</b>
            </div>
            <div class="col-md-3" align="right">
                <a href="<?= base_url('teacheruser') ?>" class="btn btn-sm btn-secondary"><i class="fas fa-backward"></i> Back</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <div class="table-responsive">
                <table class="table table-bordered table-striped mt-3 mb-5">
                    <tr>
                        <th width="40%">Student Name</th>
                        <td><?= $result_student_data->student_name ?></td>
                    </tr>
                    <tr>
                        <th>Grade</th>
                        <td><?= $result_student_data->grade_name ?></td>
                    </tr>
                    <tr>
                        <th>Teacher Name</th>
                        <td><?= $result_student_data->teacher_name ?></td>
                    </tr>
                    <tr>
                        <th>Time Period</th>
                        <td><strong><?= $from_date ?></strong> to <strong><?= $to_date ?></strong></td>
                    </tr>
                </table>

                <div id="piechart" style="width: 100%; height: 400px;"></div>

                <table class="table table-striped table-bordered">
                    <tr>
                        <th>Date</th>
                        <th>Attendance Status</th>
                    </tr>
                    <?php
                    $total_present = 0;
                    $total_absent = 0;
                    ?>
                    <?php foreach ($result_student as $row) : ?>
                        <tr>
                            <td><?= $row->attendance_date ?></td>
                            <?php if ($row->attendance_status == 'Present') : ?>
                                <td><span class="badge bg_lightgreen">Present</span></td>
                                <?php $total_present++ ?>
                            <?php else : ?>
                                <td><span class="badge bg_tomato text-white">Absent</span></td>
                                <?php $total_absent++ ?>
                            <?php endif ?>
                        </tr>
                        <?php
                        $present_percentage = ($total_present / $total_row) * 100;
                        $absent_percentage = ($total_absent / $total_row) * 100;
                        ?>
                    <?php endforeach ?>
                </table>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    google.charts.load('current', {
        'packages': ['corechart']
    });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

        var data = google.visualization.arrayToDataTable([
            ['Attendance Status', 'Percentage'],
            ['Present', <?= $present_percentage ?>],
            ['Absent', <?= $absent_percentage ?>]
        ]);

        var options = {
            title: 'Overall Attendance Analytics',
            hAxis: {
                title: 'Percentage',
                minValue: 0,
                maxValue: 100
            },
            vAxis: {
                title: 'Attendance Status'
            }
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
    }
</script>