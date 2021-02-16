<div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center mt-5">

        <div class="col-lg-8">

            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row justify-content-center">
                        <div class="col-lg-5 text-center">
                            <div class="pl-4 pt-4 pr-4 pb-0 mt-4">
                                <img src="<?= base_url('assets/img/'); ?>logo.jpeg" width="100">
                                <!-- <p class="text-gray-900">Selamat Datang</p> -->
                                <p class="text-gray-900 mt-3 text-uppercase">E-learning <br> SMAN 16 Bandar Lampung</p>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="p-4">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Login!</h1>
                                </div>
                                <?= $this->session->tempdata('pesan'); ?>
                                <?= $this->session->unset_tempdata('pesan'); ?>
                                <form class="user" action="<?= base_url('auth'); ?>" method="POST">
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-user" id="email" name="email" placeholder="Enter Email Address...">
                                        <?= form_error('email', '<small class="text-danger pl-3">', '</small>'); ?>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user" id="password" name="password" placeholder="Password">
                                        <?= form_error('password', '<small class="text-danger pl-3">', '</small>'); ?>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-user btn-block">Login!</button>
                                </form>
                                <hr>
                                <div class="text-center">
                                    <a class="small" href="<?= base_url('auth/lupapassword'); ?>">Lupa Password?</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>