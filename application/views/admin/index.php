<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dasboard</h1>
    </div>

    <!-- info -->
    <div class="row justify-content-center">
        <div class="col-xl-2 col-md-6">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body text-center p-2">
                    <div class="h4 font-weight-bold text-white mb-0"><?= $this->db->get('siswa')->num_rows(); ?></div>
                    <span class="small text-white text-uppercase">Siswa/i</span>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-gray-800 stretched-link" href="<?= base_url('data/daftarsiswa'); ?>">View Details</a>
                    <div class="small text-gray-800"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-md-6">
            <div class="card bg-info nt-weighttext-white mb-4">
                <div class="card-body text-center p-2">
                    <div class="h4 fo-bold text-white mb-0"><?= $this->db->get('guru')->num_rows(); ?></div>
                    <span class="small text-white text-uppercase">Guru</span>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-gray-800 stretched-link" href="<?= base_url('data/daftarguru'); ?>">View Details</a>
                    <div class="small text-gray-800"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-md-6">
            <div class="card bg-success nt-weighttext-white mb-4">
                <div class="card-body text-center p-2">
                    <div class="h4 fo-bold text-white mb-0"><?= $this->db->get('jurusan')->num_rows(); ?></div>
                    <span class="small text-white text-uppercase">Jurusan</span>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-gray-800 stretched-link" href="<?= base_url('data/daftarjurusan'); ?>">View Details</a>
                    <div class="small text-gray-800"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-md-6">
            <div class="card bg-warning nt-weighttext-white mb-4">
                <div class="card-body text-center p-2">
                    <div class="h4 fo-bold text-white mb-0"><?= $this->db->get('mapel')->num_rows(); ?></div>
                    <span class="small text-white text-uppercase">Mata Pelajaran</span>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-gray-800 stretched-link" href="<?= base_url('data/daftarmapel'); ?>">View Details</a>
                    <div class="small text-gray-800"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-md-6">
            <div class="card bg-danger nt-weighttext-white mb-4">
                <div class="card-body text-center p-2">
                    <div class="h4 fo-bold text-white mb-0"><?= $this->db->get('kelas')->num_rows(); ?></div>
                    <span class="small text-white text-uppercase">Ruangan Kelas</span>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-gray-800 stretched-link" href="<?= base_url('data/daftarkelas'); ?>">View Details</a>
                    <div class="small text-gray-800"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
    </div>
    <!-- end info -->

    <!-- pengumuman -->
    <div class="mt-4">
        <div class="h5 mb-4">
            <i class="fas fa-fw fa-bullhorn"></i>
            Pengumuman/Berita
        </div>
        <div class="row">
            <?php foreach ($pengumuman as $p) : ?>
                <div class="col-lg-6">
                    <div class="card mb-4">
                        <img src="<?= base_url('assets/img/pengumuman/') . $p['gambar']; ?>" class="card-img-top">
                        <div class="card-header bg-white font-weight-bold">
                            <?= $p['headline']; ?>
                        </div>
                        <div class="card-body">
                            <div class="text-gray-800">
                                <?= $p['pengumuman']; ?>
                            </div>
                        </div>
                        <div class="card-footer small text-muted bg-whit">Terakhir diedit: <?= date('d F Y', $p['date_post']); ?></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <!-- end pengumuman -->

    <!-- tutorial -->
    <div class="mt-4 mb4">
        <div class="h5 mb-4">
            <i class="fab fa-fw fa-youtube"></i>
            Video Tutorial
        </div>
    </div>
    <!-- end tutorial -->

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->