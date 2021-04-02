<?= $this->extend('templates/auth/auth_template') ?>
<?= $this->section('main-content') ?>

<br>
<div class="container" style="min-height:100vh">
    <h2 align="center">Student Attendance System</h2>
    <br>
    <div class="d-flex justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg_lightblue">
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

                    <form action="<?= base_url('auth/check_teacher_login') ?>" method="post" id="teacher_login_form">
                        <?= csrf_field() ?>
                        <div class="form-group">
                            <label>Enter Email</label>
                            <input type="text" name="teacher_email" id="teacher_email" class="form-control" placeholder="Teacher Email">
                            <span id="error_teacher_email" class="text-danger"></span>
                        </div>
                        <div class="form-group">
                            <label>Enter Password</label>
                            <input type="password" name="teacher_password" id="teacher_password" class="form-control" placeholder="Password">
                            <span id="error_teacher_password" class="text-danger"></span>
                        </div>

                        <br>
                        <div class="form-group">
                            <button type="submit" name="teacher_login" id="teacher_login" class="btn btn-primary btn-block">Login</button>
                        </div>
                        <hr>
                        <div class="text-center">
                            <small><a href="<?= base_url('/admin_login') ?>">Login as Admin</a></small>
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

<?= $this->endSection() ?>