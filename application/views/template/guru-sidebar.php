<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url('guru'); ?>">
        <div class="sidebar-brand-icon">
            <!-- <i class="fas fa-laugh-wink"></i> -->
            <img src="<?= base_url('assets/img/logo-sidebar.jpg'); ?>" class="rounded-circle" width="45">
        </div>
        <div class="sidebar-brand-text mx-3">e-learning</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0 mb-4">

    <!-- Nav Item - Dashboard -->
    <?php if ($title == 'Home') : ?>
        <li class="nav-item active">
        <?php else : ?>
        <li class="nav-item">
        <?php endif; ?>
        <a class="nav-link" href="<?= base_url('guru'); ?>">
            <i class="fas fa-fw fa-home"></i>
            <span>Home</span></a>
        </li>

        <?php if ($title == 'Profile' || $title == 'Edit Profile') : ?>
            <li class="nav-item active">
            <?php else : ?>
            <li class="nav-item">
            <?php endif; ?>
            <a class="nav-link" href="<?= base_url('guru/profile'); ?>">
                <i class="fas fa-fw fa-user-alt"></i>
                <span>Profile</span></a>
            </li>

            <?php if ($title == 'Materi') : ?>
                <li class="nav-item active">
                <?php else : ?>
                <li class="nav-item">
                <?php endif; ?>
                <a class="nav-link" href="<?= base_url('guru/materi'); ?>">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Materi</span></a>
                </li>

                <?php if ($title == 'Kelas' || $title == 'Detail Kelas') : ?>
                    <li class="nav-item active">
                    <?php else : ?>
                    <li class="nav-item">
                    <?php endif; ?>
                    <a class="nav-link" href="<?= base_url('guru/kelas'); ?>">
                        <i class="fas fa-fw fa-users"></i>
                        <span>Kelas</span></a>
                    </li>

                    <?php if ($title == 'Tugas') : ?>
                        <li class="nav-item active">
                        <?php else : ?>
                        <li class="nav-item">
                        <?php endif; ?>
                        <a class="nav-link" href="<?= base_url('guru/tugas'); ?>">
                            <i class="fas fa-fw fa-clipboard-list"></i>
                            <span>Tugas</span></a>
                        </li>

                        <?php if ($title == 'Jadwal') : ?>
                            <li class="nav-item active">
                            <?php else : ?>
                            <li class="nav-item">
                            <?php endif; ?>
                            <a class="nav-link" href="<?= base_url('guru/jadwal'); ?>">
                                <i class="far fa-fw fa-clock"></i>
                                <span>Jadwal Mengajar</span></a>
                            </li>

                            <?php if ($title == 'Ubah Password') : ?>
                                <li class="nav-item active">
                                <?php else : ?>
                                <li class="nav-item">
                                <?php endif; ?>
                                <a class="nav-link" href="<?= base_url('guru/ubahpassword'); ?>">
                                    <i class="fas fa-fw fa-key"></i>
                                    <span>Ubah Password</span></a>
                                </li>


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