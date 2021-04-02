<?= $this->extend('templates/admin/admin_index') ?>
<?= $this->section('main_content') ?>
<div class="container" style="margin-top:30px">
    <div class="card">
        <div class="card-header bg_lightblue">
            <div class="row">
                <div class="col-md-4">
                    <h2><?= $title ?></h2>
                </div>
                <div class="col-md-6">
                    <div class=" form-group">
                        <div class="row">
                            <div class="col-md-4 my-1">
                                <input type="date" name="first_date" id="first_date" class="form-control form-control-sm" placeholder="First Date">
                            </div>
                            <div class="col-md-4 my-1">
                                <input type="date" name="last_date" id="last_date" class="form-control form-control-sm" placeholder="Last Date">
                            </div>
                            <div class="col-md-4 my-1">
                                <button type="submit" name="submit_date" id="submit_date" class="btn btn-block btn-sm btn-secondary"><i class="fas fa-calendar"></i> Filter Date</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2" align="right">
                    <button type="button" id="report_button" class="btn btn_tomato"><i class="fas fa-file-pdf"></i> Report</button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive" id="datatable">
                <span id="message_operation"></span>
                <table class="table table-striped table-bordered" id="attendance_table">
                    <thead class="thead-dark">
                        <tr>
                            <th width="25%">Student Name</th>
                            <th width="13%">Roll Number</th>
                            <th width="10%">Grade</th>
                            <th width="18%">Attendance Status</th>
                            <th>Date</th>
                            <th>Teacher</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Report Modal -->
<div class="modal fade" id="reportModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Make Report</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <div class="form-group">
                    <form method="post" action="<?= base_url('attendance/report_grade_date_pdf') ?>">
                        <div class="row">
                            <div class="col-md">
                                <div class="form-group">
                                    <select type="text" class="form-control" name="grade_id" id="grade_id" required>
                                        <option value="">Select Grade</option>
                                        <?php foreach ($grade as $row) : ?>
                                            <option value="<?= $row['grade_id'] ?>"><?= $row['grade_name'] ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="input-daterange row">
                            <div class="col-md-6">
                                <input type="text" name="from_date" id="from_date" class="form-control" placeholder="From Date" autocomplete="off" required>
                                <span id="error_from_date" class="text-danger"></span>
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="to_date" id="to_date" class="form-control" placeholder="To Date" autocomplete="off" required>
                                <span id="error_to_date" class="text-danger"></span>
                            </div>
                        </div>
                </div>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <!-- <input type="hidden" name="student_id" id="student_id" /> -->
                <button type="submit" name="create_report" id="create_report" class="btn btn-success btn-sm" target="_blank"><i class="fas fa-file-pdf"></i> Create Report</button>
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
            </div>
            </form>

        </div>
    </div>
</div>

<script type="text/javascript" src="https://www.eyecon.ro/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<link rel="stylesheet" href="https://www.eyecon.ro/bootstrap-datepicker/css/datepicker.css" />

<style>
    .datepicker {
        z-index: 1600 !important;
        /* has to be larger than 1050 */
    }
</style>

<script>
    $(document).ready(function() {
        var dataTable = $('#attendance_table').DataTable({
            "order": [],
            "aoColumnDefs": [{
                "bSortable": false,
                "aTargets": [2, 3, 4, 5]
            }],
            "serverSide": true,
            "ajax": {
                url: "<?= base_url('attendance/fetch_all') ?>",
                type: "POST"
            }
        })

        $('#submit_date').click(function() {
            const firstDate = $('#first_date').val();
            const lastDate = $('#last_date').val();

            if (firstDate != '' && lastDate != '') {
                $.ajax({
                    url: "<?= base_url('attendance/filter_date') ?>",
                    type: "POST",
                    data: {
                        first_date: firstDate,
                        last_date: lastDate
                    },
                    dataType: "json",
                    success: function(data) {
                        $('#datatable').html(data.success);
                        $('#message_operation').html(data.alert);
                    }
                })
            } else {
                alert('Please input date!');
            }
        });

        $('#report_button').click(function() {
            $('#reportModal').modal('show');
            $('#grade_id').val('');
            $('#from_date').val('');
            $('#to_date').val('');
        });

        $('#from_date').datepicker({
            format: "yyyy-mm-dd",
            autoclose: true,
            container: '.input-daterange'
        }); // Datepicker from date
        $('#to_date').datepicker({
            format: "yyyy-mm-dd",
            autoclose: true,
            container: ".input-daterange"
        }); // Datepicker to data

    });
</script>

<?= $this->endSection() ?>