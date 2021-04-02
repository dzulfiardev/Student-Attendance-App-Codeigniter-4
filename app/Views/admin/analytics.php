<?= $this->extend('templates/admin/admin_index') ?>
<?= $this->section('main_content') ?>

<div class="container" id="main_content_analytics" style="margin-top:30px">
    <div class="card">
        <div class="card-header bg_lightblue">
            <div class="row">
                <div class="col-md">
                    <h3>Overall Student Attendance</h3>
                </div>
            </div>
        </div>
        <div class="card-body" id="card_body_content">
            <div class="table-responsive" id="datatable">
                <span id="message_operation"></span>
                <table class="table table-striped table-bordered" id="attendance_table">
                    <thead class="thead-dark">
                        <tr>
                            <th>Student Name</th>
                            <th width="20%">Roll Number</th>
                            <th>Grade</th>
                            <th>Teacher</th>
                            <th width="20%">Attendance Percentage</th>
                            <th></th>
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
                <h4 class="modal-title">PDF Report</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <div class="form-group">
                    <form method="post" action="<?= base_url('attendance/export_pdf_by_admin') ?>">
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
                <input type="hidden" name="student_id" id="student_id" />
                <button type="submit" name="create_report" id="create_report" class="btn btn-success btn-sm" target="_blank"><i class="fas fa-file-pdf"></i> Create Report</button>
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
            </div>
            </form>

        </div>
    </div>
</div>

<!-- Chart Report Modal -->
<div class="modal fade" id="chartReportModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Chart Report</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <div class="form-group">
                    <div class="input-daterange row">
                        <div class="col-md-6">
                            <input type="text" name="chart_from_date" id="chart_from_date" class="form-control" placeholder="From Date" autocomplete="off">
                            <span id="chart_error_from_date" class="text-danger"></span>
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="chart_to_date" id="chart_to_date" class="form-control" placeholder="To Date" autocomplete="off">
                            <span id="error_to_date" class="text-danger"></span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <input type="hidden" name="chart_student_id" id="chart_student_id">
                <button type="submit" name="chart_create_report" id="chart_create_report" class="btn btn-success btn-sm"><i class="fas fa-file-pdf"></i> Create Report</button>
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
            </div>
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
                url: "<?= base_url('attendance/fetch_all_analytics') ?>",
                type: "POST"
            }
        });

        // Pdf report modal datepicker
        $('#from_date').datepicker({
            format: 'yyyy-mm-dd',
            container: '.input-daterange',
            autoclose: true,
        })
        $('#to_date').datepicker({
            format: 'yyyy-mm-dd',
            container: '.input-daterange',
            autoclose: true
        })

        // Chart report modal datepicker
        $('#chart_from_date').datepicker({
            format: "yyyy-mm-dd",
            autoclose: true,
            container: '.input-daterange'
        })
        $('#chart_to_date').datepicker({
            format: "yyyy-mm-dd",
            autoclose: true,
            container: '.input-daterange'
        })

        $(document).on('click', '.report_btn', function() {
            const student_id = $(this).attr('id');
            $('#reportModal').modal('show');
            $('#from_date').val('');
            $('#to_date').val('');
            $('#student_id').val(student_id);
        });

        $(document).on('click', '.chart_btn', function() {
            const student_id = $(this).attr('id');
            $('#chartReportModal').modal('show');
            $('#chart_from_date').val('');
            $('#chart_to_date').val('');
            $('#chart_student_id').val(student_id);
        }); // Chart Report Date Modal

        $('#chart_create_report').click(function() {
            const fromDate = $('#chart_from_date').val();
            const toDate = $('#chart_to_date').val();
            const studentId = $('#chart_student_id').val();

            if (toDate == '' || fromDate == '') {
                alert('Please input date');
            } else {
                $.ajax({
                    url: "<?= base_url('attendance/admin_chart_report') ?>",
                    type: "POST",
                    data: {
                        from_date: fromDate,
                        to_date: toDate,
                        student_id: studentId
                    },
                    dataType: "json",
                    success: function(data) {
                        console.log(data);
                        $('#main_content_analytics').html(data.success);
                        $('#chartReportModal').modal('hide');
                    }
                })
            } // Chart Report
        });
    })
</script>

<?= $this->endSection() ?>