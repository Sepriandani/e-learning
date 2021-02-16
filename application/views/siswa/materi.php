<!-- Begin Page Content -->
<div class="container-fluid">
    <div id="demo" style="display: none;">
        <h5 class="text-center text-uppercase">Presensi pertemuan ke-<?= $setPresensi['pertemuan'] . ' ' . $mapel['mapel']; ?></h5>
        <div class="row justify-content-center">
            <div class="col-xl-2 col-md-6">
                <div class="card bg-info nt-weighttext-white mb-4">
                    <div class="card-body text-center p-2">
                        <div class="h4 fo-bold text-white mb-0" id="jam"></div>
                        <span class="small text-white text-uppercase">Jam</span>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-md-6">
                <div class="card bg-info nt-weighttext-white mb-4">
                    <div class="card-body text-center p-2">
                        <div class="h4 fo-bold text-white mb-0" id="menit"></div>
                        <span class="small text-white text-uppercase">Menit</span>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-md-6">
                <div class="card bg-info nt-weighttext-white mb-4">
                    <div class="card-body text-center p-2">
                        <div class="h4 fo-bold text-white mb-0" id="detik"></div>
                        <span class="small text-white text-uppercase">Detik</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#presensiSiswa" id="tombolPresensiSiswa">klik, Presensi Sekarang</a>
        </div>
    </div>

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title . ' ' . $mapel['mapel']; ?></h1>
    </div>

    <div class="container p-0 m-0">
        <div class="row">
            <div class="col-lg-11">
                <?= $this->session->tempdata('pesan'); ?>
                <?= $this->session->unset_tempdata('pesan'); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3 mb-3">
                <div class="card shadow mr-4" style="width: 16rem;">
                    <div class="card-body">
                        <h6 class="card-title text-uppercase text-dark font-weight-bold mb-0">Tugas</h6>
                        <small class="card-subtitle text-muted">23:59, 30 januari 2021</small>

                        <?php $j = 1; ?>
                        <?php foreach ($materiKelas as $m) : ?>
                            <?php
                            $tugasKelas = $this->db->get_where('tugas_kelas', ['materi_kelas_id' => $m['id']])->row_array();
                            if ($tugasKelas == false) :
                            ?>
                                <p class="card-text text-center mt-2 pt-2 pb-2" style="opacity: 50%;">Belum ada tugas</p>
                            <?php else : ?>
                                <?php if ($j == 1) : ?>
                                    <?php
                                    $ambilTugas = $this->db->get_where('tugas', ['id' => $tugasKelas['tugas_id']])->row_array();
                                    ?>

                                    <div class="action mt-2">
                                        <a href="<?= base_url('siswa/soal/') . $tugasKelas['tugas_id']; ?>" class="card-link text-center mt-2 pt-2 pb-2"><?= 'Tugas ke-' . $ambilTugas['tugas'] . ' | ' . $ambilTugas['materi'] . ' | ' . $ambilTugas['tipe']; ?></a>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>

                    </div>
                </div>
            </div>

            <!-- card materi -->
            <div class="col-lg-9">
                <?php $i = 0; ?>
                <?php foreach ($materiKelas as $mk) : ?>
                    <div class="card shadow mb-3">
                        <div class="card-header bg-transparent border-white">
                            <div class="row p-0">
                                <img class="rounded-circle p-1 m-1" src="<?= base_url('assets/img/profile/') . $guru['gambar'] ?>" width="50" height="50">
                                <div class="p-0 ml-2 mt-2 col-lg-6">
                                    <h6 class="card-title mr-2 mb-0 text-uppercase text-dark font-weight-bold"><?= $guru['nama']; ?></h6>
                                    <small class="card-subtitle text-muted mr-2"><?= date('d F Y', $mk['date_post']); ?></small>
                                </div>
                            </div>
                        </div>
                        <div class="card-body text-gray m-0 pt-1">
                            <h6 class="card-title text-dark font-weight-bold">Pertemuan ke-
                                <?php
                                $materi = $this->db->get_where('materi', ['id' => $mk['materi_id']])->row_array();
                                echo $materi['pertemuan'];
                                ?>
                            </h6>
                            <p class="card-text">
                                <?= $mk['deskripsi']; ?>
                            </p>
                            <p class="card-text">Lampiran : </p>
                            <i class="fas fa-file-pdf"></i>
                            <a class="card-link" href="<?= base_url('assets/file/') . $materi['file']; ?>"><?= $materi['file']; ?></a>
                        </div>
                        <!-- komentar -->
                        <hr class="m-0 mb-2 ">

                        <?php
                        $komentar = $this->db->get_where('pesan', ['materi_kelas_id' => $mk['id']]);
                        $jumlahKomentar = $komentar->num_rows();
                        ?>
                        <a href="#" class="comment-toggler card-link mb-1 mt-0 ml-3" data-target="comment-<?= $i; ?>"><?= $jumlahKomentar; ?> class comment</a>
                        <div id="comment-<?= $i; ?>" style="display: none;">
                            <?php
                            if ($komentar) {
                                foreach ($komentar->result_array() as $k) {
                                    $ambilUser = $this->db->get_where('user', ['id' => $k['user_id']])->row_array();
                                    if ($ambilUser['role_id']  == 2) {
                                        $data = $this->db->get_where('guru', ['email' => $ambilUser['email']])->row_array();
                                    } else {
                                        $data = $this->db->get_where('siswa', ['email' => $ambilUser['email']])->row_array();
                                    }
                                    echo '
                                    <div class="card-body pt-0 mt-0">
                                        <div class="row p-0">
                                            <div class="col-lg-auto p-0 m-0">
                                                <img class="rounded-circle p-0 m-1" src="' . base_url('assets/img/profile/') . $data['gambar'] . '" width="40" height="40">
                                            </div>
                                            <div class="p-0 ml-0 mr-0 mr-1 col-lg-auto">
                                                <p class="card-title mr-2 mb-0 text-inline text-lowercase text-dark font-weight-bold d-sm-inline-block">' . $data['nama'] . '</p>
                                                <span class="card-subtitle text-muted text-xs mt-0 mr-2">' . date('d F Y', $k['date_created']) . '</span>
                                                <p class="card-text m-0">' . $k['pesan'] . '</p>
                                            </div>
                                        </div>
                                    </div>
                                    ';
                                }
                            }
                            ?>

                        </div>
                        <div class="card-footer bg-transparent">
                            <form action="<?= base_url('pesan/komentar/') . $user['id'] . '/' . $mk['id'] . '/' . $mapel['id']; ?>" method="post">
                                <div class="input-group">
                                    <img class="rounded-circle p-0 mt-0 mr-2" src="<?= base_url('assets/img/profile/') . $siswa['gambar'] ?>" width="40" height="40">
                                    <input type="text" class="form-control bg-light" id="komentar" name="komentar" style="border-radius:20px 20px 20px 20px;" placeholder="Tambahkan komentar....">
                                    <button type="submit" style="font-size: 1.5em; color: #4e73df;" class="input-group-text rounded-circle bg-transparent border-white" id="kirim">
                                        <i class="fas fa-paper-plane"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <?php $i++; ?>
                <?php endforeach; ?>
            </div>
            <!-- end card materi -->
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->