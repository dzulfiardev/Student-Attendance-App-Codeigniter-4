<?= $this->extend('templates/admin/admin_index') ?>
<?= $this->section('main_content') ?>

<div class="container my-5">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-9">
                    <h3>Grade List</h3>
                </div>
                <div class="col-md-3" align="right">
                    <button type="button" id="add_button" class="btn btn-success">Add</button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <span id="message_operation"></span>
                <table class="table-striped table table-bordered" id="grade_table">
                    <thead class="thead-dark">
                        <tr>
                            <th>Grade Name</th>
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

<!-- Add Grade Modal -->
<div class="modal fade" id="formModal">
    <div class="modal-dialog">
        <form method="post" id="grade_form">
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
                            <label class="col-md-4 text-right">Grade Name <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="grade_name" id="grade_name" class="form-control" />
                                <span id="error_grade_name" class="text-danger"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <input type="hidden" name="grade_id" id="grade_id" />
                    <input type="hidden" name="action" id="action" value="Add" />
                    <input type="submit" name="button_action" id="button_action" class="btn btn-success btn-sm" value="Add" />
                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                </div>

            </div>
        </form>
    </div>
</div>
<!-- End Add Grade Modal -->

<!-- Update Grade Modal -->
<div class="modal fade" id="formModalUpdate">
    <div class="modal-dialog">
        <form method="post" id="grade_form_edit">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title" id="modal_title_edit"></h4>
                    <button type="button" id="btn_close_edit_sm" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Grade Name <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="grade_name" id="grade_name_edit" class="form-control" />
                                <span id="error_grade_name_edit" class="text-danger"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <input type="hidden" name="grade_id" id="grade_id_edit" />
                    <input type="hidden" name="action" id="action_edit" value="Add" />
                    <input type="submit" name="button_action" id="button_action_edit" class="btn btn-success btn-sm" value="Add" />
                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal" id="btn_close_edit">Close</button>
                </div>

            </div>
        </form>
    </div>
</div>
<!-- End Update Grade Modal -->

<!-- Delete Modal -->
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
<!-- End Delete Modal -->

<script>
    $(document).ready(function() {
        var dataTable = $('#grade_table').DataTable({
            "aoColumnDefs": [{
                "bSortable": false,
                "aTargets": [1, 2]
            }],
            "order": [],
            "serverSide": true,
            "ajax": {
                url: "<?= base_url('admin/grade_action') ?>",
                type: 'POST'
            }
        }) // Show Grade List on Datatables

        $('#add_button').click(function() {
            $('#modal_title').text('Add Grade');
            $('#button_action').val('Add');
            $('#action').val('Add');
            $('#formModal').modal('show');
            clear_field();
        }); // Default Modal Element

        function clear_field() {
            $('#grade_form')[0].reset();
            $('#error_grade_name').text('');
        }

        $('#grade_form').on('submit', function(event) {
            event.preventDefault();
            $.ajax({
                url: "<?= base_url('admin/add_grade') ?>",
                method: "POST",
                data: $(this).serialize(),
                dataType: "json",
                beforeSend: function() {
                    $('#button_action').attr('disabled', 'disabled');
                    $('#button_action').val('Validate..');
                },
                success: function(data) {

                    $('#button_action').attr('disabled', false);
                    $('#button_action').val($('#action').val());

                    if (data.success) {
                        $('#message_operation').html(`<div class="alert alert-success">${data.success}</div>`);
                        setTimeout(() => {
                            $('#message_operation').html('');
                        }, 3000);

                        dataTable.ajax.reload();
                        $('#formModal').modal('hide');
                        $('#grade_name').removeClass('is-invalid');
                    }
                    if (data.error) {
                        if (data.error.grade_name) {
                            $('#grade_name').addClass('is-invalid');
                            $('#error_grade_name').text(data.error.grade_name);
                            setTimeout(() => {
                                $('#grade_name').removeClass('is-invalid');
                                $('#error_grade_name').text('');
                            }, 3000);
                        }
                    }
                }
            })
        }); // Submit Grade Action

        $(document).on('click', '.edit_grade', function() {
            grade_id = $(this).attr('id');
            clear_field();
            $.ajax({
                url: "<?= base_url('admin/edit_grade') ?>",
                method: "POST",
                data: {
                    grade_id: grade_id
                },
                dataType: "json",
                success: function(data) {
                    console.log(data)
                    $('#formModalUpdate').modal('show');
                    $('#grade_name_edit').val(data.grade_name);
                    $('#grade_id_edit').val(data.grade_id);
                    $('#modal_title_edit').text("Edit Grade");
                    $('#button_action_edit').val('Edit');
                    $('#action_edit').val('Edit');
                }
            })
        }); // Modal Edit Grade

        $('#grade_form_edit').on('submit', function(event) {
            event.preventDefault();
            $.ajax({
                url: "<?= base_url('admin/update_grade') ?>",
                method: "POST",
                data: $(this).serialize(),
                dataType: "json",
                beforeSend: function() {
                    $('#button_action_edit').attr('disabled', 'disabled');
                    $('#button_action_edit').val('Validate..');
                },
                success: function(data) {

                    $('#button_action_edit').attr('disabled', false);
                    $('#button_action_edit').val($('#action').val());

                    // $('#btn_close_edit').on('click', function() {
                    //     $('#grade_name_edit').removeClass('is-invalid');
                    //     $('#error_grade_name_edit').text('');
                    // })
                    // $('#btn_close_edit_sm').on('click', function() {
                    //     $('#grade_name_edit').removeClass('is-invalid');
                    //     $('#error_grade_name_edit').text('');
                    // })

                    if (data.success) {
                        $('#message_operation').html(`<div class="alert alert-success">${data.success}</div>`);
                        setTimeout(() => {
                            $('#message_operation').html('');
                        }, 3000);

                        dataTable.ajax.reload();
                        $('#formModalUpdate').modal('hide');
                        $('#grade_name_edit').removeClass('is-invalid');
                        $('#error_grade_name_edit').text('');
                    }
                    if (data.error) {
                        if (data.error.grade_name) {
                            $('#grade_name_edit').addClass('is-invalid');
                            $('#error_grade_name_edit').text(data.error.grade_name);
                            setTimeout(() => {
                                $('#grade_name_edit').removeClass('is-invalid');
                                $('#error_grade_name_edit').text('');
                            }, 3000);
                        }
                    }
                }
            })
        }); // Submit Update Grade Action

        $(document).on('click', '.delete_grade', function() {
            grade_id = $(this).attr('id');
            $('#deleteModal').modal('show');
        });

        $('#ok_button').click(function() {
            $.ajax({
                url: "<?= base_url('admin/delete_grade') ?>",
                method: "POST",
                dataType: "json",
                data: {
                    grade_id: grade_id
                },
                success: function(data) {
                    console.log(data);
                    $('#message_operation').html(`<div class="alert alert-success">${data.success}</div>`);
                    $('#deleteModal').modal('hide');
                    dataTable.ajax.reload();
                    setTimeout(() => {
                        $('#message_operation').html('')
                    }, 3000)
                }
            });
        }); // Delete Action

    })
</script>

<?= $this->endSection() ?>