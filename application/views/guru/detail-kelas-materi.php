<!-- Begin Page Content -->
<div class="container-fluid">

    <?php
    $materi = $this->db->get_where('materi', ['id' => $materiKelas['materi_id']])->row_array();
    ?>

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $kelas['kelas'] . ' pertemuan ke-' . $materi['pertemuan']; ?></h1>
    </div>

    <?= $this->session->tempdata('pesan'); ?>
    <?= $this->session->unset_tempdata('pesan'); ?>

    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="card mr-4" style="width: 16rem;">
                    <div class="card-body">
                        <h6 class="card-title text-uppercase text-dark font-weight-bold mb-0">Tugas</h6>
                        <small class="card-subtitle text-muted">23:59, 30 januari 2021</small>
                        <?php
                        $tugasKelas = $this->db->get_where('tugas_kelas', ['materi_kelas_id' => $materiKelas['id']])->row_array();
                        if ($tugasKelas == false) :
                        ?>
                            <p class="card-text text-center mt-2 pt-2 pb-2" style="opacity: 50%;">Belum ada tugas</p>
                            <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#tambahTugasKelas" id="tombolTambahTugasKelas">Tambah Tugas</a>
                        <?php else : ?>
                            <?php
                            $ambilTugas = $this->db->get_where('tugas', ['id' => $tugasKelas['tugas_id']])->row_array();
                            ?>
                            <div class="action mt-2">
                                <a href="<?= base_url('guru/soal/') . $tugasKelas['tugas_id']; ?>" class="card-link text-center mt-2 pt-2 pb-2"><?= 'Tugas ke-' . $ambilTugas['tugas'] . ' | ' . $ambilTugas['materi'] . ' | ' . $ambilTugas['tipe']; ?></a>
                                <div class="tombol mt-2">
                                    <a href="#" class="tombolEditTugasKelas" data-toggle="modal" data-target="#tambahTugasKelas" data-id="<?= $tugasKelas['id']; ?>">
                                        <span class="badge rounded-pill badge-warning p-1 pl-2 pr-2">Edit</span>
                                    </a>
                                    <a href="<?= base_url('guru/hapustugaskelas/') . $materiKelas['id'] . '/' . $tugasKelas['id']; ?>" id="hapus" name="hapus" onclick="return confirm('Yakin ingin menghapus tugas ke- ?')">
                                        <span class="badge rounded-pill badge-danger p-1 ml-2">hapus</span>
                                    </a>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- card materi -->
            <div class="col-lg-8">
                <div class="card mb-2">
                    <div class="card-header bg-transparent border-white">
                        <div class="row p-0">
                            <img class="rounded-circle p-1 m-1" src="<?= base_url('assets/img/profile/') . $guru['gambar'] ?>" width="50" height="50">
                            <div class="p-0 ml-2 mt-2 col-lg-6">
                                <h6 class="card-title mr-2 mb-0 text-uppercase text-dark font-weight-bold"><?= $guru['nama']; ?></h6>
                                <small class="card-subtitle text-muted mr-2"><?= date('d F Y', $materiKelas['date_post']); ?></small>
                            </div>
                        </div>
                    </div>
                    <div class="card-body text-gray m-0 pt-1">
                        <h6 class="card-title text-dark font-weight-bold">Pertemuan ke-<?= $materi['pertemuan'] . ' | ' . $materi['judul']; ?></h6>
                        <p class="card-text">
                            <?= $materiKelas['deskripsi']; ?>
                        </p>
                        <p class="card-text mb-1">Lampiran : </p>
                        <i class="fas fa-file-pdf"></i>
                        <a class="card-link" href="<?= base_url('assets/file/') . $materi['file']; ?>"><?= $materi['file']; ?></a>
                    </div>
                    <!-- komentar -->
                    <hr class="m-0 mb-2 ">

                    <?php
                    $komentar = $this->db->get_where('pesan', ['materi_kelas_id' => $materiKelas['id']]);
                    $jumlahKomentar = $komentar->num_rows();
                    ?>
                    <a href="#" class="comment-toggler card-link mb-1 mt-0 ml-3" data-target="comment"><?= $jumlahKomentar; ?> class comment</a>
                    <div id="comment" style="display: none;">
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
                                            <img class="rounded-circle p-0 m-1" src="' . base_url('assets/img/profile/') . $data['gambar'] . '" width="40" height="40">
                                            <div class="p-0 ml-2 mt-1 col-lg-6">
                                                <p class="card-title mr-2 mb-0 text-inline text-lowercase text-dark font-weight-bold d-sm-inline-block">' . $data['nama'] . '</p>
                                                <span class="card-subtitle text-muted text-xs mr-2">' . date('d F Y', $k['date_created']) . '</span>
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
                        <form action="<?= base_url('pesan/komentar/') . $user['id'] . '/' . $materiKelas['id'] . '/' . $guru['mapel_id']; ?>" method="post">
                            <div class="input-group">
                                <img class="rounded-circle p-0 mt-0 mr-2" src="<?= base_url('assets/img/profile/') . $guru['gambar'] ?>" width="40" height="40">
                                <input type="text" class="form-control bg-light" id="komentar" name="komentar" style="border-radius:20px 20px 20px 20px;" placeholder="Tambahkan komentar....">
                                <button type="submit" style="font-size: 1.5em; color: #4e73df;" class="input-group-text rounded-circle bg-transparent border-white" id="kirim">
                                    <i class="fas fa-paper-plane"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- end card materi -->
        </div>
    </div>

    <!-- Modal buat Tugas-->
    <div class="modal fade" id="tambahTugasKelas" tabindex="-1" role="dialog" aria-labelledby="tambahTugasKelasLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header card-header">
                    <h5 class="modal-title" id="tambahTugasKelasLabel">Tambah Tugas kelas <?= $kelas['kelas']; ?></h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="<?= base_url('guru/detailkelasmateri/') . $materiKelas['id']; ?>" method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="text" class="form-control" id="id" name="id" hidden>
                        </div>
                        <div class="form-group">
                            <label for="tugas" class="form-label">Tugas</label>
                            <select class="form-control" name="tugas" id="tugas">
                                <option>Pilih tugas</option>
                                <?php foreach ($tugas as $t) : ?>
                                    <option value="<?= $t['id']; ?>"><?= 'Tugas ke-' . $t['tugas'] . ' | ' . $t['materi'] . ' (' . $t['tipe'] . ')'; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer card-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->