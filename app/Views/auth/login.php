<?= $this->extend('templates/auth/auth_template') ?>
<?= $this->section('main-content') ?>

<br>
<div class="container" style="min-height:100vh">
    <h2 align="center">Student Attendance System</h2>
    <br>
    <div class="d-flex justify-content-center">
        <div class="col-md-6">
            <div class="panel panel-default card">
                <div class="panel-heading card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h3><?= $title ?></h3>
                        </div>
                        <div class="col-md-6">
                            <img width="125px" align="right" src="<?= base_url() ?>/img/logo-black.png" alt="dzulfikardev">
                        </div>
                    </div>
                </div>
                <div class="panel-body card-body">

                    <?php if (session()->getFlashdata('msg')) : ?>
                        <div class="alert alert-danger"><?= session()->getFlashdata('msg') ?></div>
                    <?php endif; ?>

                    <form action="<?= base_url('auth/check_admin_login') ?>" method="post" id="admin_login_form">
                        <?= csrf_field() ?>
                        <div class="form-group">
                            <label>Enter Username</label>
                            <input type="text" name="admin_user_name" id="admin_user_name" class="form-control" placeholder="Username">
                            <span id="error_admin_user_name" class="text-danger"></span>
                        </div>
                        <div class="form-group">
                            <label>Enter Password</label>
                            <input type="password" name="admin_password" id="admin_password" class="form-control" placeholder="Password">
                            <span id="error_admin_password" class="text-danger"></span>
                        </div>

                        <br>
                        <div class="form-group">
                            <button type="submit" name="admin_login" id="admin_login" class="btn btn-primary btn-block">Login</button>
                        </div>
                        <hr>
                        <div class="text-center">
                            <small><a href="<?= base_url() ?>">Login as Teacher</a></small>
                            <br>
                            <hr>
                            <p><i class="fas fa-envelope"></i> dzulfikar.sauki@gmail.com <i class="ml-1 fab fa-whatsapp"></i> 088801995989</p>
                        </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>

<!-- <script>
    $(document).ready(function() {
        $('#admin_login_form').on('submit', function(event) {
            event.preventDefault();
            // if ($('#admin_user_name').val() == '') {
            //     $('#admin_user_name').addClass('is-invalid');
            //     $('#error_admin_user_name').html('<span class-"text-danger">Is Required</span>');
            // }
            $.ajax({
                url: "",
                method: "POST",
                data: $(this).serialize(),
                dataType: "json",
                beforeSend: function() {
                    $('#admin_login').val('Validate . .');
                    $('#admin_login').attr('disabled', 'disabled');
                },
                success: function(data) {
                    console.log(data);
                    if (data.success) {
                        location.href = ""
                    }
                    if (data.error) {
                        $('#admin_login').val('Login');
                        $('#admin_login').attr('disabled', false);

                        if (data.admin_user_name != '') {
                            $('#error_admin_user_name').text(data.error_admin_user_name);
                        } else {
                            $('#error_admin_user_name').text('');
                        }

                        if (data.error_admin_password != '') {
                            $('#error_admin_password').text(data.error_admin_password);
                        } else {
                            $('#error_admin_password').text('');
                        }
                    }
                }
            })
        })


    })
</script> -->

<?= $this->endSection() ?>