<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url('admin'); ?>">
        <div class="sidebar-brand-icon">
            <!-- <i class="fas fa-laugh-wink"></i> -->
            <img src="<?= base_url('assets/img/logo-sidebar.jpg'); ?>" class="rounded-circle" width="45">
        </div>
        <div class="sidebar-brand-text mx-3">e-learning</div>
    </a>

    <!-- Admin -->
    <!-- Heading -->
    <div class="sidebar-heading mt-4">
        Admin
    </div>
    <!-- Divider -->
    <hr class="sidebar-divider my-0 mb-2">

    <!-- Nav Item - Dashboard -->
    <?php if ($title == 'Dasboard') : ?>
        <li class="nav-item active">
        <?php else : ?>
        <li class="nav-item">
        <?php endif; ?>
        <a class="nav-link" href="<?= base_url('admin'); ?>">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dasboard</span></a>
        </li>
        <!-- profile -->
        <?php if ($title == 'Profile') : ?>
            <li class="nav-item active">
            <?php else : ?>
            <li class="nav-item">
            <?php endif; ?>
            <a class="nav-link" href="<?= base_url('admin/profile'); ?>">
                <i class="fas fa-fw fa-user-alt"></i>
                <span>Profile</span></a>
            </li>
            <!-- pengumuman -->
            <?php if ($title == 'Pengumuman') : ?>
                <li class="nav-item active">
                <?php else : ?>
                <li class="nav-item">
                <?php endif; ?>
                <a class="nav-link" href="<?= base_url('admin/pengumuman'); ?>">
                    <i class="fas fa-fw fa-bullhorn"></i>
                    <span>Pengumuman</span></a>
                </li>

                <!-- Tutorial -->
                <?php if ($title == 'Tutorial') : ?>
                    <li class="nav-item active">
                    <?php else : ?>
                    <li class="nav-item">
                    <?php endif; ?>
                    <a class="nav-link" href="<?= base_url('admin/tutorial'); ?>">
                        <i class="fab fa-fw fa-youtube"></i>
                        <span>Tutorial</span></a>
                    </li>

                    <!-- Ubah password -->
                    <?php if ($title == 'Ubah Password') : ?>
                        <li class="nav-item active">
                        <?php else : ?>
                        <li class="nav-item">
                        <?php endif; ?>
                        <a class="nav-link" href="<?= base_url('admin/ubahpassword'); ?>">
                            <i class="fas fa-fw fa-key"></i>
                            <span>Ubah Password</span>
                        </a>
                        </li>
                        <!-- End Admin -->

                        <!-- Data -->
                        <div>
                            <!-- Heading -->
                            <div class="sidebar-heading mt-2">Data</div>
                            <!-- Divider -->
                            <hr class="sidebar-divider my-0 mb-2">


                            <!-- Daftar Jurusan -->
                            <?php if ($title == 'Daftar Jurusan') : ?>
                                <li class="nav-item active">
                                <?php else : ?>
                                <li class="nav-item">
                                <?php endif; ?>
                                <a class="nav-link" href="<?= base_url('data/daftarjurusan'); ?>">
                                    <i class="fas fa-fw fa-th-list"></i>
                                    <span>Daftar Jurusan</span>
                                </a>
                                </li>
                                <!-- Daftar Mapel -->
                                <?php if ($title == 'Daftar Mata Pelajaran') : ?>
                                    <li class="nav-item active">
                                    <?php else : ?>
                                    <li class="nav-item">
                                    <?php endif; ?>
                                    <a class="nav-link" href="<?= base_url('data/daftarmapel'); ?>">
                                        <i class="fas fa-fw fa-list-alt"></i>
                                        <span>Daftar Mapel</span>
                                    </a>
                                    </li>
                                    <!-- Daftar Kelas -->
                                    <?php if ($title == 'Daftar Kelas' || $title == 'Detail Kelas') : ?>
                                        <li class="nav-item active">
                                        <?php else : ?>
                                        <li class="nav-item">
                                        <?php endif; ?>
                                        <a class="nav-link" href="<?= base_url('data/daftarkelas'); ?>">
                                            <i class="fas fa-fw fa-users"></i>
                                            <span>Daftar Kelas</span>
                                        </a>
                                        </li>
                                        <!-- daftar siswa -->
                                        <?php if ($title == 'Daftar Siswa' || $title == 'Detail Siswa') : ?>
                                            <li class="nav-item active">
                                            <?php else : ?>
                                            <li class="nav-item">
                                            <?php endif; ?>
                                            <a class="nav-link" href="<?= base_url('data/daftarsiswa'); ?>">
                                                <i class="fas fa-fw fa-user-graduate"></i>
                                                <span>Daftar Siswa</span>
                                            </a>
                                            </li>
                                            <!-- Daftar Guru -->
                                            <?php if ($title == 'Daftar Guru' || $title == 'Detail Guru') : ?>
                                                <li class="nav-item active">
                                                <?php else : ?>
                                                <li class="nav-item">
                                                <?php endif; ?>
                                                <a class="nav-link" href="<?= base_url('data/daftarguru'); ?>">
                                                    <i class="fas fa-fw fa-user-tie"></i>
                                                    <span>Daftar Guru</span>
                                                </a>
                                                </li>

                        </div>
                        <!-- End Data -->



                        <!-- logout -->
                        <li class="nav-item mt-4">
                            <a class="nav-link" href="<?= base_url('auth/logout'); ?>">
                                <i class="fas fa-fw fa-sign-out-alt"></i>
                                <span>Logout</span></a>
                        </li>


                        <!-- Divider -->
                        <hr class="sidebar-divider d-none d-md-block">

                        <!-- Sidebar Toggler (Sidebar) -->
                        <div class="text-center d-none d-md-inline">
                            <button class="rounded-circle border-0" id="sidebarToggle"></button>
                        </div>

</ul>
<!-- End of Sidebar -->