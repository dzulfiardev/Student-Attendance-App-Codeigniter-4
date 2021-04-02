<?= $this->extend('templates/admin/admin_index') ?>
<?= $this->section('main_content') ?>

<div class="container my-5">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-9">
                    <h3><?= $title ?> List</h3>
                </div>
                <div class="col-md-3" align="right">
                    <button type="button" id="add_button" class="btn btn-success">Add</button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <span id="message_operation"></span>
                <table class="table-striped table table-bordered" id="teacher_table">
                    <thead class="thead-dark">
                        <tr>
                            <th>Image</th>
                            <th>Teacher Name</th>
                            <th>Email Address</th>
                            <th>Grade</th>
                            <th>View</th>
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

<!-- Add Teacher Modal -->
<div class="modal fade" id="formModal">
    <div class="modal-dialog">
        <form method="post" id="teacher_form" enctype="multipart/form-data">
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
                            <label class="col-md-4 text-right">Teacher Name <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="teacher_name" id="teacher_name" class="form-control" />
                                <span id="error_teacher_name" class="text-danger"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Address <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <textarea name="teacher_address" id="teacher_address" class="form-control"></textarea>
                                <span id="error_teacher_address" class="text-danger"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Email Address <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="teacher_emailid" id="teacher_emailid" class="form-control" />
                                <span id="error_teacher_emailid" class="text-danger"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Password <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="password" name="teacher_password" id="teacher_password" class="form-control" />
                                <span id="error_teacher_password" class="text-danger"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Qualification <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="teacher_qualification" id="teacher_qualification" class="form-control" />
                                <span id="error_teacher_qualification" class="text-danger"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Grade <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <select name="teacher_grade_id" id="teacher_grade_id" class="form-control">
                                    <option value="">Select Grade</option>
                                    <?php foreach ($grade as $row) : ?>
                                        <option value="<?= $row->grade_id ?>"><?= $row->grade_name ?></option>
                                    <?php endforeach ?>

                                </select>
                                <span id="error_teacher_grade_id" class="text-danger"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Date of Joining <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="teacher_doj" id="teacher_doj" class="form-control" />
                                <span id="error_teacher_doj" class="text-danger"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Image <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="file" name="teacher_image" id="teacher_image" />
                                <span class="text-muted">Only .jpg and .png allowed</span><br />
                                <span id="error_teacher_image" class="text-danger"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <input type="hidden" name="hidden_teacher_image" id="hidden_teacher_image" value="" />
                    <input type="hidden" name="teacher_id" id="teacher_id" />
                    <input type="hidden" name="action" id="action" value="Add" />
                    <input type="submit" name="button_action" id="button_action" class="btn btn-success btn-sm" value="Add" />
                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                </div>

            </div>
        </form>
    </div>
</div>
<!-- End Add Teacher Modal -->

<!-- Edit Teacher Modal -->
<div class="modal fade" id="formModalEdit">
    <div class="modal-dialog">
        <form method="post" id="teacher_form_edit" enctype="multipart/form-data">
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
                            <label class="col-md-4 text-right">Teacher Name <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="teacher_name" id="teacher_name_edit" class="form-control" />
                                <span id="error_teacher_name_edit" class="text-danger"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Address <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <textarea name="teacher_address" id="teacher_address_edit" class="form-control"></textarea>
                                <span id="error_teacher_address" class="text-danger"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Email Address <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="teacher_emailid" id="teacher_emailid_edit" class="form-control" />
                                <span id="error_teacher_emailid_edit" class="text-danger"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Password <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="password" name="teacher_password" id="teacher_password_edit" class="form-control" disabled>
                                <span id="error_teacher_password" class="text-danger"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Qualification <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="teacher_qualification" id="teacher_qualification_edit" class="form-control" />
                                <span id="error_teacher_qualification" class="text-danger"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Grade <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <select name="teacher_grade_id" id="teacher_grade_id_edit" class="form-control">
                                    <option value="">Select Grade</option>
                                    <?php foreach ($grade as $row) : ?>
                                        <option value="<?= $row->grade_id ?>"><?= $row->grade_name ?></option>
                                    <?php endforeach ?>
                                    <input type="hidden" name="teacher_grade" id="teacher_grade_id_edit_hidden">
                                </select>
                                <span id="error_teacher_grade_id_edit" class="text-danger"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Date of Joining <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="teacher_doj" id="teacher_doj_edit" class="form-control" />
                                <span id="error_teacher_doj_edit" class="text-danger"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Image </label>
                            <div class="col-md-8">
                                <input type="file" name="teacher_image" id="teacher_image_edit" />
                                <span class="text-muted">Only .jpg and .png allowed</span><br />
                                <span id="error_teacher_image_edit" class="text-danger"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <input type="hidden" name="hidden_teacher_image" id="hidden_teacher_image_edit" value="" />
                    <input type="hidden" name="teacher_id" id="teacher_id_edit" />
                    <input type="hidden" name="action" id="action_edit" value="Add" />
                    <input type="submit" name="button_action" id="button_action_edit" class="btn btn-success btn-sm" value="Add" />
                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                </div>

            </div>
        </form>
    </div>
</div>
<!-- End Teacher Modal -->

<!-- View Teacher Modal -->
<div class="modal fade" id="viewModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Teacher Details</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body" id="teacher_details">

            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>
<!-- End Delete Teacher Modal -->

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
        var dataTable = $('#teacher_table').DataTable({
            "aoColumnDefs": [{
                "bSortable": false,
                "aTargets": [0, 2, 3, 4, 5, 6]
            }],
            "order": [],
            "serverSide": true,
            "ajax": {
                url: "<?= base_url('teacher/fetch_all') ?>",
                type: 'POST'
            }
        }); // Show Teacher List on Datatable

        $('#teacher_doj').datepicker({
            format: "yyyy-mm-dd",
            autoclose: true,
            container: '#formModal modal-body'
        });
        $('#teacher_doj_edit').datepicker({
            format: "yyyy-mm-dd",
            autoclose: true,
            container: '#formModal modal-body'
        });

        function clear_field() {
            $('#teacher_form')[0].reset();
            $('#error_teacher_name').text('');
            $('#error_teacher_address').text('');
            $('#error_teacher_emailid').text('');
            $('#error_teacher_password').text('');
            $('#error_teacher_qualification').text('');
            $('#error_teacher_doj').text('');
            $('#error_teacher_image').text('');
            $('#error_teacher_grade_id').text('');

            $('#teacher_name').removeClass('is-invalid');
            $('#teacher_address').removeClass('is-invalid');
            $('#teacher_emailid').removeClass('is-invalid');
            $('#teacher_password').removeClass('is-invalid');
            $('#teacher_qualification').removeClass('is-invalid');
            $('#teacher_doj').removeClass('is-invalid');
            $('#teacher_grade_id').removeClass('is-invalid');

            $('#teacher_form_edit')[0].reset();
            $('#error_teacher_name_edit').text('');
            $('#error_teacher_address_edit').text('');
            $('#error_teacher_emailid_edit').text('');
            $('#error_teacher_password_edit').text('');
            $('#error_teacher_qualification_edit').text('');
            $('#error_teacher_doj_edit').text('');
            $('#error_teacher_image_edit').text('');
            $('#error_teacher_grade_id_edit').text('');

            $('#teacher_name_edit').removeClass('is-invalid');
            $('#teacher_address_edit').removeClass('is-invalid');
            $('#teacher_emailid_edit').removeClass('is-invalid');
            $('#teacher_password_edit').removeClass('is-invalid');
            $('#teacher_qualification_edit').removeClass('is-invalid');
            $('#teacher_doj_edit').removeClass('is-invalid');
            $('#teacher_grade_id_edit').removeClass('is-invalid');
        }

        $('#add_button').click(function() {
            $('#modal_title').text("Add Teacher");
            $('#button_action').val('Add');
            $('#action').val('Add');
            $('#formModal').modal('show');
            clear_field();
        });

        $('#teacher_form').on('submit', function(event) {
            event.preventDefault();
            $.ajax({
                url: "<?= base_url('teacher/add_teacher') ?>",
                method: "POST",
                data: new FormData(this),
                dataType: "json",
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $('#button_action_e').val('Validate...');
                    $('#button_action').attr('disabled', 'disabled');
                },
                success: function(data) {
                    $('#button_action').attr('disabled', false);
                    $('#button_action').val($('#action').val());
                    if (data.success) {
                        $('#message_operation').html('<div class="alert alert-success">' + data.success + '</div>');
                        clear_field();
                        $('#formModal').modal('hide');
                        dataTable.ajax.reload();
                        setTimeout(() => {
                            $('#message_operation').html('')
                        }, 3000);
                    }
                    if (data.error) {
                        console.log(data.error)
                        if (data.error.error_teacher_name) {
                            $('#error_teacher_name').text(data.error.error_teacher_name);
                            $('#teacher_name').addClass('is-invalid');
                        } else {
                            $('#error_teacher_name').text('');
                            $('#teacher_name').removeClass('is-invalid');
                        }
                        if (data.error.error_teacher_address) {
                            $('#error_teacher_address').text(data.error.error_teacher_address);
                            $('#teacher_address').addClass('is-invalid');
                        } else {
                            $('#error_teacher_address').text('');
                            $('#teacher_address').removeClass('is-invalid');
                        }
                        if (data.error.error_teacher_emailid) {
                            $('#error_teacher_emailid').text(data.error.error_teacher_emailid);
                            $('#teacher_emailid').addClass('is-invalid');
                        } else {
                            $('#error_teacher_emailid').text('');
                            $('#teacher_emailid').removeClass('is-invalid');
                        }
                        if (data.error.error_teacher_password) {
                            $('#error_teacher_password').text(data.error.error_teacher_password);
                            $('#teacher_password').addClass('is-invalid');
                        } else {
                            $('#error_teacher_password').text('');
                            $('#teacher_password').removeClass('is-invalid');
                        }
                        if (data.error.error_teacher_grade_id) {
                            $('#error_teacher_grade_id').text(data.error.error_teacher_grade_id);
                            $('#teacher_grade_id').addClass('is-invalid');
                        } else {
                            $('#error_teacher_grade_id').text('');
                            $('#teacher_grade_id').removeClass('is-invalid');
                        }
                        if (data.error.error_teacher_qualification) {
                            $('#error_teacher_qualification').text(data.error.error_teacher_qualification);
                            $('#teacher_qualification').addClass('is-invalid');
                        } else {
                            $('#error_teacher_qualification').text('');
                            $('#teacher_qualification').removeClass('is-invalid');
                        }
                        if (data.error.error_teacher_doj) {
                            $('#error_teacher_doj').text(data.error.error_teacher_doj);
                            $('#teacher_doj').addClass('is-invalid');
                        } else {
                            $('#error_teacher_doj').text('');
                            $('#teacher_doj').removeClass('is-invalid');
                        }
                        if (data.error.error_teacher_image) {
                            $('#error_teacher_image').text(data.error.error_teacher_image);
                        } else {
                            $('#error_teacher_image').text('');
                        }
                    }
                }
            });
        }); // Add Teacher Modal

        var teacher_id = '';

        $(document).on('click', '.edit_teacher', function() {
            teacher_id = $(this).attr('id');
            clear_field();
            $.ajax({
                url: "<?= base_url('teacher/edit_teacher') ?>",
                method: "POST",
                data: {
                    teacher_id: teacher_id
                },
                dataType: "json",
                success: function(data) {
                    $('#teacher_name_edit').val(data.teacher_name);
                    $('#teacher_address_edit').val(data.teacher_address);
                    $('#teacher_emailid_edit').val(data.teacher_emailid);
                    $('#teacher_grade_id_edit').val(data.grade_id);
                    $('#teacher_qualification_edit').val(data.teacher_qualification);
                    $('#teacher_doj_edit').val(data.teacher_doj);
                    $('#error_teacher_image_edit').html('<img src="img/photo/' + data.teacher_image + '" class="img-thumbnail" width="100" />');
                    $('#hidden_teacher_image_edit').val(data.teacher_image);
                    $('#teacher_id_edit').val(data.teacher_id);
                    $('#modal_title_edit').text("Edit Teacher");
                    $('#button_action_edit').val('Edit');
                    $('#action_edit_edit').val('Edit');
                    $('#formModalEdit').modal('show');
                }
            });
        }); // Single Fetch / Edit modal 

        $('#teacher_form_edit').on('submit', function(event) {
            event.preventDefault();
            $.ajax({
                url: "<?= base_url('teacher/update_teacher') ?>",
                method: "POST",
                data: new FormData(this),
                dataType: "json",
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $('#button_action_edit').val('Validate...');
                    $('#button_action_edit').attr('disabled', 'disabled');
                },
                success: function(data) {
                    $('#button_action_edit').attr('disabled', false);
                    $('#button_action_edit').val($('#action').val());
                    if (data.success) {
                        $('#message_operation').html(`<div class="alert alert-success">${data.success}</div>`);
                        clear_field();
                        $('#formModalEdit').modal('hide');
                        dataTable.ajax.reload();
                        setTimeout(() => {
                            $('#message_operation').html('')
                        }, 3000);
                    }
                    if (data.error) {
                        console.log(data.error)
                        if (data.error.error_teacher_name) {
                            $('#error_teacher_name_edit').text(data.error.error_teacher_name);
                            $('#teacher_name_edit').addClass('is-invalid');
                        } else {
                            $('#error_teacher_name_edit').text('');
                            $('#teacher_name_edit').removeClass('is-invalid');
                        }
                        if (data.error.error_teacher_address) {
                            $('#error_teacher_address_edit').text(data.error.error_teacher_address);
                            $('#teacher_address_edit').addClass('is-invalid');
                        } else {
                            $('#error_teacher_address_edit').text('');
                            $('#teacher_address_edit').removeClass('is-invalid');
                        }
                        if (data.error.error_teacher_emailid) {
                            $('#error_teacher_emailid_edit').text(data.error.error_teacher_emailid);
                            $('#teacher_emailid_edit').addClass('is-invalid');
                        } else {
                            $('#error_teacher_emailid_edit').text('');
                            $('#teacher_emailid_edit').removeClass('is-invalid');
                        }
                        if (data.error.error_teacher_password) {
                            $('#error_teacher_password_edit').text(data.error.error_teacher_password);
                            $('#teacher_password_edit').addClass('is-invalid');
                        } else {
                            $('#error_teacher_password_edit').text('');
                            $('#teacher_password_edit').removeClass('is-invalid');
                        }
                        if (data.error.error_teacher_grade_id) {
                            $('#error_teacher_grade_id_edit').text(data.error.error_teacher_grade_id);
                            $('#teacher_grade_id_edit').addClass('is-invalid');
                        } else {
                            $('#error_teacher_grade_id_edit').text('');
                            $('#teacher_grade_id_edit').removeClass('is-invalid');
                        }
                        if (data.error.error_teacher_qualification) {
                            $('#error_teacher_qualification_edit').text(data.error.error_teacher_qualification);
                            $('#teacher_qualification_edit').addClass('is-invalid');
                        } else {
                            $('#error_teacher_qualification_edit').text('');
                            $('#teacher_qualification_edit').removeClass('is-invalid');
                        }
                        if (data.error.error_teacher_doj) {
                            $('#error_teacher_doj_edit').text(data.error.error_teacher_doj);
                            $('#teacher_doj_edit').addClass('is-invalid');
                        } else {
                            $('#error_teacher_doj_edit').text('');
                            $('#teacher_doj_edit').removeClass('is-invalid');
                        }
                        if (data.error.error_teacher_image) {
                            $('#error_teacher_image_edit').text(data.error.error_teacher_image);
                        } else {
                            $('#error_teacher_image_edit').text('');
                        }
                    }
                }
            });
        }); // Update Action Teacher Modal

        $(document).on('click', '.view_teacher', function() {
            var teacher_id = $(this).attr('id');
            $.ajax({
                url: "<?= base_url('teacher/view_teacher') ?>",
                method: "POST",
                data: {
                    teacher_id: teacher_id
                },
                dataType: "json",
                success: function(data) {
                    $('#viewModal').modal('show');
                    $('#teacher_details').html(data);
                }
            })
        }) // View Teacher Modal

        $(document).on('click', '.delete_teacher', function() {
            var teacher_id = $(this).attr('id');
            $('#deleteModal').modal('show');
        }); // Delete Teacher Mdal

        $('#ok_button').click(function() {
            $.ajax({
                url: "<?= base_url('teacher/delete_teacher') ?>",
                method: "POST",
                data: {
                    teacher_id: teacher_id,
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
        }); // Delete Teacher Action

    })
</script>

<?= $this->endSection() ?>