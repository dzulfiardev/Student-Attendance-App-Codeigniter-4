<?= $this->extend('templates/admin/admin_index') ?>
<?= $this->section('main_content') ?>

<div class="container my-5">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-9">
                    <h3>Student List</h3>
                </div>
                <div class="col-md-3" align="right">
                    <button type="button" id="add_button" class="btn btn-success">Add</button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <span id="message_operation"></span>
                <table class="table table-striped table-bordered" id="student_table">
                    <thead class="thead-dark">
                        <tr>
                            <th>Student Name</th>
                            <th>Roll No.</th>
                            <th>Date of Birth</th>
                            <th>Grade</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
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

<!-- Student Add Modal -->
<div class="modal fade" id="formModal">
    <div class="modal-dialog">
        <form method="post" id="student_form">
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
                            <label class="col-md-4 text-right">Student Name <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="student_name" id="student_name" class="form-control" />
                                <span id="error_student_name" class="text-danger"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Roll No. <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="student_roll_number" id="student_roll_number" class="form-control" />
                                <span id="error_student_roll_number" class="text-danger"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Date of Birth <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="student_dob" id="student_dob" class="form-control" />
                                <span id="error_student_dob" class="text-danger"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Grade <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <select name="student_grade_id" id="student_grade_id" class="form-control">
                                    <option value="">Select Grade</option>
                                    <?php foreach ($grade as $row) : ?>
                                        <option value="<?= $row->grade_id ?>"><?= $row->grade_name ?></option>
                                    <?php endforeach ?>
                                </select>
                                <span id="error_student_grade_id" class="text-danger"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <input type="hidden" name="student_id" id="student_id" />
                    <input type="hidden" name="action" id="action" value="Add" />
                    <input type="submit" name="button_action" id="button_action" class="btn btn-success btn-sm" value="Add" />
                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                </div>

            </div>
        </form>
    </div>
</div>
<!-- End Student Add Modal -->

<!-- Student Edit Modal -->
<div class="modal fade" id="formModalEdit">
    <div class="modal-dialog">
        <form method="post" id="student_form_edit">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title_edit"></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Student Name <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="student_name" id="student_name_edit" class="form-control" />
                                <span id="error_student_name_edit" class="text-danger"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Roll No. <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="student_roll_number" id="student_roll_number_edit" class="form-control" />
                                <span id="error_student_roll_number_edit" class="text-danger"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Date of Birth <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="student_dob" id="student_dob_edit" class="form-control" />
                                <span id="error_student_dob_edit" class="text-danger"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Grade <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <select name="student_grade_id" id="student_grade_id_edit" class="form-control">
                                    <option value="">Select Grade</option>
                                    <?php foreach ($grade as $row) : ?>
                                        <option value="<?= $row->grade_id ?>"><?= $row->grade_name ?></option>
                                    <?php endforeach ?>
                                </select>
                                <span id="error_student_grade_id_edit" class="text-danger"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <input type="hidden" name="student_id" id="student_id_edit" />
                    <input type="hidden" name="action" id="action_edit" value="Add" />
                    <input type="submit" name="button_action" id="button_action_edit" class="btn btn-success btn-sm" value="Add" />
                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                </div>

            </div>
        </form>
    </div>
</div>
<!-- End Student Add Modal -->

<!-- Delete Teacher Modal -->
<div class="modal fade" id="deleteModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Delete Confirmation</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <h3 align="center">Are you sure you want to remove this?</h3>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" name="ok_button" id="ok_button" class="btn btn-primary btn-sm">OK</button>
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>
<!-- End Teacher Modal -->

<script>
    $(document).ready(function() {
        var dataTable = $('#student_table').DataTable({
            "aoColumnDefs": [{
                "bSortable": false,
                "aTargets": [2, 3, 4, 5]
            }],
            "order": [],
            "serverSide": true,
            "ajax": {
                url: "<?= base_url('student/fetch_all') ?>",
                type: 'POST'
            }
        }); // Show Student List on Datatable

        $('#student_dob' && '#student_dob_edit').datepicker({
            format: "yyyy-mm-dd",
            autoclose: true,
            container: '#formModal modal-body'
        }); // DatePicker

        function clearField() {
            $('#student_form')[0].reset();
            $('#error_student_name').text('');
            $('#error_student_roll_number').text('');
            $('#error_student_dob').text('');
            $('#error_student_grade_id').text('');

            $('#student_name').removeClass('is-invalid');
            $('#student_roll_number').removeClass('is-invalid');
            $('#student_dob').removeClass('is-invalid');
            $('#student_grade_id').removeClass('is-invalid');
        } // Clear field function add student form modal

        $('#add_button').click(function() {
            $('#modal_title').text('Add Teacher');
            $('#button_action').val('Add');
            $('#action').val('Add');
            $('#formModal').modal('show');
            clearField();
        }); // Menampilkan add student modal form

        $('#student_form').on('submit', function(e) {
            e.preventDefault()
            $.ajax({
                url: "<?= base_url('student/add_student') ?>",
                method: "POST",
                data: $(this).serialize(),
                dataType: "json",
                beforeSend: function() {
                    $('#button_action').val('Validate...');
                    $('#button_action').attr('disabled', 'disabled');
                },
                success: function(data) {
                    $('#button_action').attr('disabled', false);
                    $('#button_action').val($('#action').val());
                    if (data.success) {
                        $('#message_operation').html(`<div class="alert alert-success">${data.success}</div>`);
                        clearField();
                        $('#formModal').modal('hide');
                        dataTable.ajax.reload();
                        setTimeout(() => {
                            $('#message_operation').html('');
                        }, 3000)
                    }
                    if (data.error) {
                        if (data.error.student_name) {
                            $('#error_student_name').text(data.error.student_name);
                            $('#student_name').addClass('is-invalid');
                        } else {
                            $('#error_student_name').text('');
                            $('#student_name').removeClass('is-invalid');
                        }
                        if (data.error.student_roll_number) {
                            $('#error_student_roll_number').text(data.error.student_roll_number);
                            $('#student_roll_number').addClass('is-invalid');
                        } else {
                            $('#error_student_roll_number').text('');
                            $('#student_roll_number').removeClass('is-invalid');
                        }
                        if (data.error.student_dob) {
                            $('#error_student_dob').text(data.error.student_dob);
                            $('#student_dob').addClass('is-invalid');
                        } else {
                            $('#error_student_dob').text('');
                            $('#student_dob').removeClass('is-invalid');
                        }
                        if (data.error.student_grade_id) {
                            $('#error_student_grade_id').text(data.error.student_grade_id);
                            $('#student_grade_id').addClass('is-invalid');
                        } else {
                            $('#error_student_grade_id').text('');
                            $('#student_grade_id').removeClass('is-invalid');
                        }
                    }
                }
            })
        }) // Add student form

        var student_id = '';

        $(document).on('click', '.edit_student', function() {
            student_id = $(this).attr('id');
            clearField();
            $.ajax({
                url: "<?= base_url('student/edit_student') ?>",
                type: "POST",
                data: {
                    student_id: student_id
                },
                dataType: "json",
                success: function(data) {
                    $('#student_id_edit').val(data.student_id);
                    $('#student_name_edit').val(data.student_name);
                    $('#student_roll_number_edit').val(data.student_roll_number);
                    $('#student_dob_edit').val(data.student_dob);
                    $('#student_grade_id_edit').val(data.student_grade_id);
                    $('#modal_title_edit').text("Edit Student");
                    $('#button_action_edit').val('Edit');
                    $('#action_edit').val('Edit');
                    $('#formModalEdit').modal('show');
                }
            })
        })

        $('#student_form_edit').on('submit', function(event) {
            event.preventDefault();
            $.ajax({
                url: "<?= base_url('student/update_student') ?>",
                type: "POST",
                data: $(this).serialize(),
                dataType: "json",
                beforeSend: function() {
                    $('#button_action_edit').val('Validate..');
                    $('#button_action_edit').attr('disabled', 'disabled');
                },
                success: function(data) {
                    $('#button_action_edit').attr('disabled', false);
                    $('#button_action_edit').val($('#action').val());
                    if (data.success) {
                        $('#message_operation').html(`<div class="alert alert-success">${data.success}</div>`);
                        clearField();
                        $('#formModalEdit').modal('hide');
                        dataTable.ajax.reload();
                        setTimeout(() => {
                            $('#message_operation').html('')
                        }, 3000);
                    }

                    if (data.error) {
                        if (data.error.student_name) {
                            $('#error_student_name_edit').text(data.error.student_name);
                            $('#student_name_edit').addClass('is-invalid');
                        } else {
                            $('#error_student_name_edit').text('');
                            $('#student_name_edit').removeClass('is-invalid');
                        }
                        if (data.error.student_roll_number) {
                            $('#error_student_roll_number_edit').text(data.error.student_roll_number);
                            $('#student_roll_number_edit').addClass('is-invalid');
                        } else {
                            $('#error_student_roll_number_edit').text('');
                            $('#student_roll_number_edit').removeClass('is-invalid');
                        }
                        if (data.error.student_dob) {
                            $('#error_student_dob_edit').text(data.error.student_dob);
                            $('#student_dob_edit').addClass('is-invalid');
                        } else {
                            $('#error_student_dob_edit').text('');
                            $('#student_dob_edit').removeClass('is-invalid');
                        }
                        if (data.error.student_grade_id) {
                            $('#error_student_grade_id_edit').text(data.error.student_grade_id);
                            $('#student_grade_id_edit').addClass('is-invalid');
                        } else {
                            $('#error_student_grade_id_edit').text('');
                            $('#student_grade_id_edit').removeClass('is-invalid');
                        }
                    }
                }
            })
        }); // Edit student

        $(document).on('click', '.delete_student', function() {
            student_id = $(this).attr('id');
            $('#deleteModal').modal('show');
        });
        $('#ok_button').click(function() {
            $.ajax({
                url: "<?= base_url('student/delete_student') ?>",
                method: "POST",
                data: {
                    student_id: student_id
                },
                dataType: "json",
                success: function(data) {
                    $('#message_operation').html(`<div class="alert alert-success">${data.success}</div>`);
                    $('#deleteModal').modal('hide');
                    dataTable.ajax.reload();
                    setTimeout(() => {
                        $('#message_operation').html('');
                    }, 3000);
                }
            });
        }); // Delete Student

    })
</script>
<?= $this->endSection() ?>