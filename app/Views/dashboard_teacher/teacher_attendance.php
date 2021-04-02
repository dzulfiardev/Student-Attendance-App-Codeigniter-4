<?= $this->extend('templates/teacher/teacher_index') ?>
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
                    <button type="button" id="add_button" class="btn btn-success">Add</button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive" id="datatable">
                <span id="message_operation"></span>
                <table class="table table-striped table-bordered" id="attendance_table">
                    <thead class="thead-dark">
                        <tr>
                            <th>Student Name</th>
                            <th width="15%">Roll Number</th>
                            <th width="15%">Grade</th>
                            <th width="18%">Attendance Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="formModal">
    <div class="modal-dialog">
        <form method="post" id="attendance_form">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title"></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Grade <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <?= $grade['grade_name'] ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Attendance Date <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="attendance_date" id="attendance_date" class="form-control" autocomplete="off">
                                <span id="error_attendance_date" class="text-danger"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" id="student_details">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered" id="add_table">
                                <thead clas="thead-dark">
                                    <tr>
                                        <th>Roll No.</th>
                                        <th>Student Name</th>
                                        <th>Present</th>
                                        <th>Absent</th>
                                    </tr>
                                </thead>

                            </table>
                        </div>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <input type="hidden" name="attendance_id" id="attendance_id" />
                    <input type="hidden" name="action" id="action" value="Add" />
                    <input type="submit" name="button_action" id="button_action" class="btn btn-success" value="Add">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>

            </div>
        </form>
    </div>
</div>

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
                    <form method="post" action="<?= base_url('teacheruser/export_pdf') ?>">
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
                "aTargets": [2, 3, 4]
            }],
            "serverSide": true,
            "ajax": {
                url: "<?= base_url('teacheruser/attendance_fetch') ?>",
                type: "POST"
            }
        }); // Fetch attendance data

        var addDataTable = $('#add_table').DataTable({
            "order": [],
            "aoColumnDefs": [{
                "bSortable": false,
                "aTargets": [2, 3]
            }],
            "serverSide": true,
            "ajax": {
                url: "<?= base_url('teacheruser/atteandance_add_fetch') ?>",
                type: "POST"
            } // 
        }); // Fetch Attendance add data

        $('#attendance_date').datepicker({
            format: "yyyy-mm-dd",
            autoclose: true,
            container: '#formModal modal-body'
        }); // Datepicker

        function clearField() {
            $('#attendance_form')[0].reset();
            $('#error_attendance_date').html('');
            $('#attendance_date').removeClass('is-invalid');
        } // Clear Field

        $('#add_button').click(function() {
            $('#modal_title').text('Add Attendance');
            $('#formModal').modal('show');
            clearField();
            // addDataTable.ajax.reload();
            //$('#button_action').val('Add');
            //$('#action').val('Add');
        });

        $('#attendance_form').on('submit', function(e) {
            e.preventDefault()
            $.ajax({
                url: "<?= base_url('teacheruser/submit_attendance') ?>",
                type: "POST",
                data: $(this).serialize(),
                dataType: "json",
                beforeSend: function() {
                    $('#button_action').val('Validate...');
                    $('#button_action').attr('disabled', 'disabled');
                },
                success: function(data) {
                    console.log(data);
                    $('#button_action').val('Add');
                    $('#button_action').attr('disabled', false);
                    if (data.success) {
                        $('#message_operation').html(data.success);
                        setTimeout(() => {
                            $('#message_operation').html('');
                        }, 3000)
                        $('#formModal').modal('hide');
                        dataTable.ajax.reload();
                    }
                    if (data.error) {
                        if (data.error.attendance_date) {
                            $('#attendance_date').addClass('is-invalid');
                            $('#error_attendance_date').html(data.error.attendance_date);
                        } else {
                            $('#attendance_date').removeClass('is-invalid');
                            $('#attendance_error').html('');
                        }
                    }
                }
            });
        }); // Add attendance action.

        $('#submit_date').click(function() {
            const firstDate = $('#first_date');
            const lastDate = $('#last_date');

            if (firstDate.val() != '' && lastDate.val() != '') {
                $.ajax({
                    url: "<?= base_url('teacheruser/search_filter') ?>",
                    type: "post",
                    data: {
                        first_date: firstDate.val(),
                        last_date: lastDate.val()
                    },
                    dataType: "json",
                    success: function(data) {
                        $('#datatable').html(data.success);
                    }
                })
            } else {
                alert('Please select date');
            }
        }); // End filter date

        const fromDate = $('#from_date');
        const toDate = $('#to_date');

        $('#report_button').click(function() {
            $('#reportModal').modal('show');
            fromDate.val('');
            toDate.val('');
        }); // Report Modal


        fromDate.datepicker({
            format: "yyyy-mm-dd",
            autoclose: true,
            container: '#input-daterange'
        }); // Datepicker from date
        toDate.datepicker({
            format: "yyyy-mm-dd",
            autoclose: true,
            container: "#input-daterange"
        }); // Datepicker to data
    });
</script>

<?= $this->endSection() ?>