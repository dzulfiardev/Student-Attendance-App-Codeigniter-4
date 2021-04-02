<?= $this->extend('templates/teacher/teacher_index') ?>
<?= $this->section('main_content') ?>

<div class="container my-3" style="margin-top:30px">
    <span id="message_operation"></span>
    <div class="card">
        <form method="post" id="profile_form" enctype="multipart/form-data">
            <div class="card-header bg_lightblue">
                <div class="row">
                    <div class="col-md-9">
                        <h3>Profile<h3>
                    </div>
                    <div class="col-md-3" align="right">
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <div class="row">
                        <label class="col-md-4">Teacher Name <span class="text-danger">*</span></label>
                        <div class="col-md-8">
                            <input type="text" name="teacher_name" id="teacher_name" class="form-control" value="<?= $teacher->teacher_name ?>">
                            <span id="error_teacher_name" class="text-danger"></span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-md-4">Address <span class="text-danger">*</span></label>
                        <div class="col-md-8">
                            <textarea name="teacher_address" id="teacher_address" class="form-control"><?= $teacher->teacher_address ?></textarea>
                            <span id="error_teacher_address" class="text-danger"></span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-md-4">Email Address <span class="text-danger">*</span></label>
                        <div class="col-md-8">
                            <input type="text" name="teacher_emailid" id="teacher_emailid" class="form-control" value="<?= $teacher->teacher_emailid ?>">
                            <span id="error_teacher_emailid" class="text-danger"></span>
                        </div>
                    </div>
                </div>
                <hr>
                <label class="text-muted mb-3">
                    <li>Leave blank to not change it</li>
                </label>
                <div class="form-group">
                    <div class="row">
                        <label class="col-md-4">Password <span class="text-danger">*</span></label>
                        <div class="col-md-8">
                            <input type="password" name="teacher_password" id="teacher_password" class="form-control" placeholder="Password">
                            <span id="error_teacher_password" class="text-danger"></span>
                            <div class="valid-feedback"></div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-md-4">Password Repeat<span class="text-danger">*</span></label>
                        <div class="col-md-8">
                            <input type="password" name="teacher_password_repeat" id="teacher_password_repeat" class="form-control" placeholder="Repeat Password">
                            <span id="error_teacher_password_repeat" class="text-danger"></span>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="form-group">
                    <div class="row">
                        <label class="col-md-4">Qualification <span class="text-danger">*</span></label>
                        <div class="col-md-8">
                            <input type="text" name="teacher_qualification" id="teacher_qualification" class="form-control" value="<?= $teacher->teacher_qualification ?>">
                            <span id="error_teacher_qualification" class="text-danger"></span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-md-4">Grade <span class="text-danger">*</span></label>
                        <div class="col-md-8">
                            <select name="teacher_grade_id" id="teacher_grade_id" class="form-control">
                                <option value="<?= $teacher->teacher_grade_id ?>"><?= $teacher->grade_name ?></option>
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
                        <label class="col-md-4">Date of Joining <span class="text-danger">*</span></label>
                        <div class="col-md-8">
                            <input type="text" name="teacher_doj" id="teacher_doj" class="form-control" value="<?= $teacher->teacher_doj ?>" disabled>
                            <input type="hidden" name="teacher_doj_hidden" value="<?= $teacher->teacher_doj ?>">
                            <span id="error_teacher_doj" class="text-danger"></span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label class="col-md-4">Image <span class="text-danger">*</span></label>
                        <div class="col-md-8">
                            <input type="file" name="teacher_image" id="teacher_image" />
                            <span class="text-muted">Only .jpg and .png allowed</span><br />
                            <span id="error_teacher_image" class="text-danger"></span>
                            <div id="image-preview">
                                <img id="teacher_img" src='img/photo/<?= $teacher->teacher_image ?>' class='img-thumbnail my-3 img_thumbnail_edit_profile' width='125px'>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer" align="center">
                <input type="hidden" name="hidden_teacher_image" id="hidden_teacher_image" value="<?= $teacher->teacher_image ?>">
                <input type="hidden" name="teacher_id" id="teacher_id" value="<?= $teacher->teacher_id ?>">
                <input type="submit" name="button_action" id="button_action" class="btn btn-success btn-lg" value="Save" />
            </div>
        </form>

    </div>
</div>

<script>
    const inputFile = document.querySelector('#teacher_image');
    const previewContainer = document.querySelector('#image-preview');
    const previewImage = previewContainer.querySelector('#teacher_img');

    inputFile.addEventListener("change", function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();

            reader.addEventListener("load", function() {
                previewImage.setAttribute("src", this.result);
            });
            reader.readAsDataURL(file);
        }
    })
</script>

<script>
    const password = $('#teacher_password');
    const passwordRepeat = $('#teacher_password_repeat');
    const error = $('#error_teacher_password');
    const errorPassword = $('#error_teacher_password_repeat');

    passwordRepeat.on('keyup', function() {
        if (password.val() == passwordRepeat.val()) {
            passwordRepeat.addClass('is-valid');
            passwordRepeat.removeClass('is-invalid');
            errorPassword.html(`<span class="text-success">Password Match!!</span>`);
        } else if (passwordRepeat.val() == '' || password.val() == '') {
            passwordRepeat.removeClass('is-invalid');
            passwordRepeat.removeClass('is-valid');
            errorPassword.html('');
        } else {
            passwordRepeat.addClass('is-invalid');
            passwordRepeat.removeClass('is-valid');
            errorPassword.html('<span class="text-danger">Password Not Match!!</span>');
        }
    });

    password.on('keyup', function() {
        password.removeClass('is-invalid');
        error.html('');
    })

    $(document).ready(function() {
        $('#profile_form').on('submit', function(e) {
            e.preventDefault()
            $.ajax({
                url: "<?= base_url('teacheruser/update_profile') ?>",
                method: "POST",
                data: new FormData(this),
                dataType: "json",
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $('#button_action').val('Validate...');
                    $('#button_action').attr('disabled', 'disabled');
                },
                success: function(data) {
                    console.log(data);
                    $('#button_action').val('Save');
                    $('#button_action').attr('disabled', false);

                    if (data.success) {
                        Swal.fire(
                            'Success!',
                            `${data.success}`,
                            'success'
                        );
                        $('#message_operation').html(`<div class="alert alert-success">${data.success}</div>`);
                        setTimeout(() => {
                            $('#message_operation').html('')
                        }, 3000)
                        errorPassword.html('');
                        passwordRepeat.removeClass('is-valid');
                        password.val('');
                        passwordRepeat.val('');
                    }

                    if (data.error) {
                        if (data.error.teacher_name) {
                            $('#error_teacher_name').text(data.error.teacher_name);
                            $('#teacher_name').addClass('is-invalid');
                        } else {
                            $('#error_teacher_name').text('');
                            $('#teacher_name').removeClass('');
                        }
                        if (data.error.teacher_address) {
                            $('#error_teacher_address').text(data.error.teacher_address);
                            $('#teacher_address').addClass('is-invalid');
                        } else {
                            $('#error_teacher_address').text('');
                            $('#teacher_address').removeClass('');
                        }
                        if (data.error.teacher_emailid) {
                            $('#error_teacher_emailid').text(data.error.teacher_emailid);
                            $('#teacher_emailid').addClass('is-invalid');
                        } else {
                            $('#error_teacher_emailid').text('');
                            $('#teacher_emailid').removeClass('');
                        }
                        if (data.error.teacher_password) {
                            $('#error_teacher_password').text(data.error.teacher_password);
                            $('#teacher_password').addClass('is-invalid');
                        } else {
                            $('#error_teacher_password').text('');
                            $('#teacher_password').removeClass('');
                        }
                        if (data.error.teacher_qualification) {
                            $('#error_teacher_qualification').text(data.error.teacher_qualification);
                            $('#teacher_qualification').addClass('is-invalid');
                        } else {
                            $('#error_teacher_qualification').text('');
                            $('#teacher_qualification').removeClass('');
                        }
                        if (data.error.teacher_grade_id) {
                            $('#error_teacher_grade_id').text(data.error.teacher_grade_id);
                            $('#teacher_grade_id').addClass('is-invalid');
                        } else {
                            $('#error_teacher_grade_id').text('');
                            $('#teacher_grade_id').removeClass('');
                        }
                        if (data.error.teacher_image) {
                            $('#error_teacher_image').text(data.error.teacher_image);
                            $('#teacher_image').addClass('is-invalid');
                        } else {
                            $('#error_teacher_image').text('');
                            $('#teacher_image').removeClass('');
                        }
                    }
                }
            })
        });
    })
</script>


<?= $this->endSection() ?>