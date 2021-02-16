<div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

        <div class="col-lg-6">

            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="justify-content-center">

                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Lupa Password</h1>
                            </div>

                            <?= $this->session->tempdata('pesan'); ?>
                            <?= $this->session->unset_tempdata('pesan'); ?>

                            <form class="user" action="<?= base_url('auth/lupapassword'); ?>" method="POST">
                                <div class="form-group">
                                    <input type="email" class="form-control form-control-user" id="email" name="email" placeholder="Enter Email Address...">
                                    <?= form_error('email', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                                <button type="submit" class="btn btn-primary btn-user btn-block">Reset Password!</button>
                            </form>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="<?= base_url('auth'); ?>">Kembali ke-login</a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>

    </div>

</div>