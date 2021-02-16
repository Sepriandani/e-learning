<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>

    </div>

    <?= $this->session->tempdata('pesan'); ?>
    <?= $this->session->unset_tempdata('pesan'); ?>

    <div class="container mb-4">
        <div class="row justify-content-center">
            <div class="text-center">
                <img src="<?= base_url('assets/img/profile/') . $guru['gambar']; ?>" class="rounded-circle img-thumbnail" width="150">
                <h2 class="display-4"><?= $guru['nama']; ?></h2>
                <h3 class="lead"><?= $guru['email']; ?></h3>
                <h3 class="lead"><?= $guru['nip']; ?></h3>
                <h3 class="lead">
                    <?php
                    $mapel = $this->db->get_where('mapel', ['id' => $guru['mapel_id']])->row_array();
                    echo $mapel['mapel'];
                    ?>
                </h3>
            </div>
        </div>
    </div>

    <!-- Tabel Guru -->
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table mr-1"></i>
            Daftar Kelas yang diajar <?= $guru['nama']; ?>
            <a href="#" class="tombolTambahGuruAkseskelas" data-toggle="modal" data-target="#tambahGuruAksesKelas">
                <span class="badge rounded-pill badge-primary px-2 py-1 ml-2">Tambah kelas</span>
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Kelas</th>
                            <th>Kelas</th>
                            <th>jurusan</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($guru_access_kelas as $gak) : ?>
                            <tr>
                                <?php
                                $kelas_access = $this->db->get_where('kelas', ['id' => $gak['kelas_id']])->row_array();
                                $jurusan = $this->db->get_where('jurusan', ['id' => $kelas_access['jurusan_id']])->row_array();
                                ?>
                                <td><?= $i; ?></td>
                                <td><?= $kelas_access['kode_kelas']; ?></td>
                                <td><?= $kelas_access['kelas']; ?></td>
                                <td><?= $jurusan['jurusan']; ?></td>
                                <td>
                                    <a href="<?= base_url('data/hapusguruaccesskelas/') . $guru['id'] . '/' . $gak['id']; ?>" id="hapus" name="hapus" onclick="return confirm('Yakin ingin menghapus akses <?= $guru['nama'] . ' pada kelas ' . $kelas_access['kelas']; ?> ?')">
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

    <!-- Tabel Jadwal Guru -->
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table mr-1"></i>
            Jadwal mengajar <?= $guru['nama']; ?>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <!-- query jadwal -->
                        <?php
                        $guru_id = $guru['id'];
                        //join user_menu dengan user_access_menu
                        $queryKelas = "
                            SELECT `jadwal_kelas`.`id`, `jadwal_kelas`.`kelas_id`, `mapel_id`, `hari`, `jam`
                            FROM `jadwal_kelas` JOIN `guru_access_kelas`
                            ON `jadwal_kelas`.`kelas_id` = `guru_access_kelas`.`kelas_id`
                            WHERE `guru_access_kelas`.`guru_id` = $guru_id
                            ORDER BY `guru_access_kelas`.`kelas_id` ASC
                        ";
                        $jadwalKelas = $this->db->query($queryKelas)->result_array();
                        ?>

                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Kode Kelas</th>
                            <th scope="col">Kelas</th>
                            <th scope="col">Hari</th>
                            <th scope="col">jam</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($jadwalKelas as $jk) : ?>
                            <tr>
                                <?php if ($jk['mapel_id'] == $guru['mapel_id']) : ?>
                                    <td><?= $i; ?></td>
                                    <?php
                                    $ambilKelas = $this->db->get_where('kelas', ['id' => $jk['kelas_id']])->row_array();
                                    ?>
                                    <td><?= $ambilKelas['kode_kelas']; ?></td>
                                    <td><?= $ambilKelas['kelas']; ?></td>
                                    <td><?= $jk['hari']; ?></td>
                                    <td><?= $jk['jam']; ?></td>
                            </tr>
                            <?php $i++; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal jadwal-->
    <div class="modal fade" id="tambahGuruAksesKelas" tabindex="-1" role="dialog" aria-labelledby="tambahGuruAksesKelasLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header card-header">
                    <h5 class="modal-title" id="tambahGuruAksesKelasLabel">Tambah Guru Akses Kelas</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="<?= base_url('data/detailguru/') . $guru['id']; ?>" method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="text" class="form-control" id="id" name="id" hidden>
                        </div>
                        <div class="form-group">
                            <label for="kelas" class="form-label">Pilih Kelas</label>
                            <select class="form-control" name="kelas" id="kelas">
                                <option>Pilih kelas</option>
                                <?php foreach ($kelas as $k) : ?>
                                    <option value="<?= $k['id']; ?>"><?= $k['kelas']; ?></option>
                                <?php endforeach; ?>
                                <?= form_error('kelas', '<small class="text-danger pl-3">', '</small>'); ?>
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