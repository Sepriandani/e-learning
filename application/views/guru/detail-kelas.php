<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- card coundown presensi -->
    <div id="demo" style="display: none;">
        <h5 class="text-center text-uppercase">Presensi Siswa Kelas <?= $kelas['kelas']; ?></h5>
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
    </div>


    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title . ' ' . $kelas['kelas']; ?></h1>
    </div>
    <?= $this->session->tempdata('pesan'); ?>
    <?= $this->session->unset_tempdata('pesan'); ?>

    <!-- tombol tambah materi -->
    <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#tambahMateriKelas" id="tombolTambahMateriKelas">Tambah Materi</a>

    <!-- Tabel Materi Kelas -->
    <div class="card shadow mb-4" width="100%">
        <div class="card-header">
            <i class="fas fa-table mr-1"></i>
            Materi Pembelajaran <?= $kelas['kelas']; ?>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Pertemuan</th>
                            <th>Judul</th>
                            <th>File</th>
                            <th>Tanggal terbit</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($materiKelas as $mk) : ?>
                            <?php $ambilMateri = $this->db->get_where('materi', ['id' => $mk['materi_id']])->row_array(); ?>
                            <tr>
                                <td><?= $i; ?></td>
                                <td>Pertemuan ke-<?= $ambilMateri['pertemuan']; ?></td>
                                <td><?= $ambilMateri['judul']; ?></td>
                                <td>
                                    <i class="fas fa-file-pdf"></i>
                                    <a href="<?= base_url('assets/file/') . $ambilMateri['file']; ?>" style="overflow: hidden; white-space:nowrap; text-overflow:ellipsis;"><?= $ambilMateri['file']; ?></a>
                                </td>
                                <td><?= date('d F Y', $mk['date_post']); ?></td>
                                <td>
                                    <a href="<?= base_url('guru/detailkelasmateri/') . $mk['id']; ?>" id="detail" name="detail">
                                        <span class="badge rounded-pill badge-info p-1 ml-2">detail</span>
                                    </a>
                                    <a href="<?= base_url('guru/hapusmaterikelas/') . $mk['kelas_id'] . '/' . $mk['id']; ?>" id="hapus" name="hapus" onclick="return confirm('Yakin ingin menghapus materi pertemuan ke-<?= $ambilMateri['pertemuan']; ?> ?')">
                                        <span class="badge rounded-pill badge-danger p-1 ml-2">hapus</span>
                                    </a>
                                </td>
                            </tr>
                            <?php $i++; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- end materi -->

    <!-- presensi -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Presensi kelas <?= $kelas['kelas']; ?></h1>
    </div>
    <!-- tombol tambah presensi -->
    <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#tambahPresensiKelas" id="tombolTambahPresensiKelas">Tambah Presensi</a>

    <div class="card shadow mb-4">
        <div class="card-header">
            <i class="fas fa-table mr-1"></i>
            Presensi Siswa kelas <?= $kelas['kelas']; ?>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Pertemuan</th>
                            <th>Tanggal</th>
                            <th>Jam Presensi</th>
                            <th>Status</th>
                            <th>Hadir</th>
                            <th>Tidak hadir</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $j = 1; ?>
                        <?php foreach ($presensi as $p) : ?>
                            <tr>
                                <td><?= $i; ?></td>
                                <td>Pertemuan ke-<?= $p['pertemuan']; ?></td>
                                <td><?= date('d F Y', $p['tanggal']); ?></td>
                                <td><?= date('H:i:s', $p['waktu_mulai']); ?> - <?= date('H:i:s', $p['waktu_berakhir']); ?></td>
                                <td id="statusPresensi">Active</td>
                                <td>
                                    <?= $siswaHadir = $this->db->get_where('presensi_siswa', ['presensi_id' => $p['id']])->num_rows(); ?>
                                </td>
                                <td><?= $jmlSiswa - $siswaHadir; ?></td>
                                <td>
                                    <a href="<?= base_url('guru/detailpresensi/') . $kelas['id'] . '/' . $p['id']; ?>" id="detail" name="detail">
                                        <span class="badge rounded-pill badge-info p-1 ml-2">detail</span>
                                    </a>
                                    <a href="#" class="tombolEditPresensiKelas" data-toggle="modal" data-target="#tambahPresensiKelas" data-presensi="<?= $p['id'] ?>">
                                        <span class="badge rounded-pill badge-warning p-1 ml-2">edit</span>
                                    </a>
                                    <a href="<?= base_url('guru/hapuspresensi/') . $kelas['id'] . '/' . $p['id']; ?>" id="hapus" name="hapus" onclick="return confirm('Yakin ingin menghapus materi pertemuan ke- ?')">
                                        <span class="badge rounded-pill badge-danger p-1 ml-2">hapus</span>
                                    </a>
                                </td>
                            </tr>
                            <?php $i++; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- end presensi -->

    <!-- Tugas -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Daftar Tugas <?= $kelas['kelas']; ?></h1>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header">
            <i class="fas fa-table mr-1"></i>
            Daftar Tugas Siswa kelas <?= $kelas['kelas']; ?>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tugas</th>
                            <th>Materi</th>
                            <th>Terbit</th>
                            <th>Deadline</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $k = 1; ?>
                        <?php foreach ($tugasKelas as $tk) : ?>
                            <tr>
                                <td><?= $k; ?></td>
                                <td><?php
                                    $tugas = $this->db->get_where('tugas', ['id' => $tk['tugas_id']])->row_array();
                                    echo 'Tugas ke-' . $tugas['tugas'];
                                    ?></td>
                                <td><?= $tugas['materi']; ?></td>
                                <td></td>
                                <td></td>
                                <td>
                                    <a href="<?= base_url('guru/detailTugasKelas/') . $kelas['id'] . '/' . $tugas['id']; ?>" id="detail" name="detail">
                                        <span class="badge rounded-pill badge-info p-1 ml-2">detail</span>
                                    </a>
                                    <a href="#" class="tombolEditPresensiKelas" data-toggle="modal" data-target="#tambahPresensiKelas" data-presensi="">
                                        <span class="badge rounded-pill badge-warning p-1 ml-2">edit</span>
                                    </a>
                                    <a href="<?= base_url('guru/hapusTugasKelas/') . $tk['id']; ?>" id="hapus" name="hapus" onclick="return confirm('Yakin ingin menghapus materi pertemuan ke- ?')">
                                        <span class="badge rounded-pill badge-danger p-1 ml-2">hapus</span>
                                    </a>
                                </td>
                            </tr>
                            <?php $k++; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- end tugas -->

    <!-- siswa -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Siswa kelas <?= $kelas['kelas']; ?></h1>
    </div>

    <!-- Tabel siswa -->
    <div class="card shadow mb-4">
        <div class="card-header">
            <i class="fas fa-table mr-1"></i>
            Daftar Siswa kelas <?= $kelas['kelas']; ?>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIS</th>
                            <th>Nama</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($siswa as $s) : ?>
                            <tr>
                                <td><?= $i; ?></td>
                                <td><?= $s['nis']; ?></td>
                                <td><?= $s['nama']; ?></td>
                                <td><?= $s['email']; ?></td>
                            </tr>
                            <?php $i++; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Kelas Materi-->
    <div class="modal fade" id="tambahMateriKelas" tabindex="-1" role="dialog" aria-labelledby="tambahMateriKelasLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header card-header">
                    <h5 class="modal-title" id="tambahMateriKelasLabel">Tambah Materi Kelas <?= $kelas['kelas']; ?></h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="<?= base_url('guru/tambahmaterikelas/') . $guru['id'] . '/' . $kelas['id']; ?>" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="text" class="form-control" id="videoId" name="videoId" hidden>
                        </div>
                        <div class="form-group">
                            <label for="deskripsi" class="form-label">Deskripsi materi</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" aria-label="With textarea" placeholder="masukkan deskripsi...."></textarea>
                        </div>
                        <div class="form-group">
                            <label for="pertemuan" class="form-label">Pilih materi</label>
                            <select class="form-control" name="pertemuan" id="pertemuan">
                                <option value="0">Pilih pertemuan</option>
                                <?php foreach ($materi as $m) : ?>
                                    <option value="<?= $m['id']; ?>">Pertemuan ke-<?= $m['pertemuan']; ?></option>
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

    <!-- Modal Presensi-->
    <div class="modal fade" id="tambahPresensiKelas" tabindex="-1" role="dialog" aria-labelledby="tambahPresensiKelasLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header card-header">
                    <h5 class="modal-title" id="tambahPresensiKelasLabel">Tambah Presensi Kelas <?= $kelas['kelas']; ?></h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="<?= base_url('guru/setpresensi/') . $guru['id'] . '/' . $kelas['id']; ?>" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="text" class="form-control" id="idPresensi" name="idPresensi" hidden>
                        </div>
                        <div class="form-group">
                            <label for="pertemuan" class="form-label">Pilih materi</label>
                            <select class="form-control" name="pertemuanPresensi" id="pertemuanPresensi">
                                <option value="0">Pilih pertemuan</option>
                                <?php foreach ($materi as $m) : ?>
                                    <option value="<?= $m['id']; ?>">Pertemuan ke-<?= $m['pertemuan']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="JamMulai" class="form-label">Atur jam mulai presensi</label>
                            <div class="row col-lg-8 pl-0 form-group">
                                <div class="col-sm">
                                    <input type="text" class="form-control" id="jamMulai" name="jamMulai" placeholder="Jam">
                                </div>
                                <span class="h4 font-weight-bold pt-1">:</span>
                                <div class="col-sm">
                                    <input type="text" class="form-control" id="menitMulai" name="menitMulai" placeholder="Menit">
                                </div>
                                <span class="h4 font-weight-bold pt-1">:</span>
                                <div class="col-sm">
                                    <input type="text" class="form-control" id="detikMulai" name="detikMulai" placeholder="detik">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="jamBerakhir" class="form-label">Atur jam berakhir presensi</label>
                            <div class="row col-lg-8 pl-0 form-group">
                                <div class="col-sm">
                                    <input type="text" class="form-control" id="jamBerakhir" name="jamBerakhir" placeholder="Jam">
                                </div>
                                <span class="h4 font-weight-bold pt-1">:</span>
                                <div class="col-sm">
                                    <input type="text" class="form-control" id="menitBerakhir" name="menitBerakhir" placeholder="Menit">
                                </div>
                                <span class="h4 font-weight-bold pt-1">:</span>
                                <div class="col-sm">
                                    <input type="text" class="form-control" id="detikBerakhir" name="detikBerakhir" placeholder="detik">
                                </div>
                            </div>
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