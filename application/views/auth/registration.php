<div class="container">

    <div class="row justify-content-center">
        <div class="card col-lg-6 my-5">
            <div class="p-5">
                <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Daftar e-learning!</h1>
                </div>
                <form class="user" action="<?= base_url('auth/registration'); ?>" method="POST">
                    <div class="form-group">
                        <input type="text" class="form-control form-control-user" id="name" name="name" placeholder="Full Name.....">
                        <?= form_error('name', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control form-control-user" id="email" name="email" placeholder="Email Address...">
                        <?= form_error('email', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <input type="password" class="form-control form-control-user" id="password1" name="password1" placeholder="Password">
                            <?= form_error('password1', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                        <div class="col-sm-6">
                            <input type="password" class="form-control form-control-user" id="password2" name="password2" placeholder="Repeat Password">
                            <?= form_error('password2', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <span class="ml-3">Daftar sebagai : </span>
                        <input class="form-group-input ml-3" type="checkbox" id="siswa" name="siswa" data="3">
                        <label for="siswa">Siswa</label>
                        <input class="form-group-input ml-3" type="checkbox" id="guru" name="guru" data="2">
                        <label for="guru">Guru</label>
                    </div>
                    <button type="submit" class="btn btn-primary btn-user btn-block">Daftar</button>
                </form>
                <hr>
                <div class="text-center">
                    <a class="small" href="forgot-password.html">Forgot Password?</a>
                </div>
                <div class="text-center">
                    <a class="small" href="<?= base_url('auth'); ?>">Sudah punya akun? Login!</a>
                </div>
            </div>
        </div>
    </div>

</div>