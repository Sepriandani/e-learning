<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
    </div>
    <?= $this->session->tempdata('pesan'); ?>
    <?= $this->session->unset_tempdata('pesan'); ?>

    <!-- Tabel detail kelas -->
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table mr-1"></i>
            Detail siswa kelas <?= $kelas['kelas']; ?>
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
                        <?php $i = $this->uri->segment('3') + 1; ?>
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
            <?= $this->pagination->create_links(); ?>
        </div>
    </div>

    <!-- Tabel detail guru -->
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table mr-1"></i>
            Detail siswa guru <?= $kelas['kelas']; ?>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIP</th>
                            <th>Nama</th>
                            <th>Pengampu Mapel</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $x = 1; ?>
                        <?php foreach ($guruAksesKelas as $gak) : ?>
                            <?php $guru = $this->db->get_where('guru', ['id' => $gak['guru_id']])->row_array(); ?>
                            <tr>
                                <td><?= $x; ?></td>
                                <td><?= $guru['nip']; ?></td>
                                <td><?= $guru['nama']; ?></td>
                                <td>
                                    <?php
                                    $namaMapel = $this->db->get_where('mapel', ['id' => $guru['mapel_id']])->row_array();
                                    echo $namaMapel['mapel'];
                                    ?>
                                </td>
                                <td><?= $guru['email']; ?></td>
                            </tr>
                            <?php $x++; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Tabel jadwal pelajaran -->
    <div class="card mb-4" id="tabelJadwal">
        <div class="card-header">
            <i class="fas fa-table mr-1"></i>
            Jadwal pelajaran siswa <?= $kelas['kelas']; ?>
            <a href="#" class="tombolTambahJadwalKelas" data-toggle="modal" data-target="#tambahJadwalKelas" data-kelas="<?= $kelas['id']; ?>">
                <span class="badge rounded-pill badge-primary px-2 py-1 ml-2">Tambah jadwal</span>
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Kode Kelas</th>
                            <th scope="col">Kelas</th>
                            <th scope="col">Mapel</th>
                            <th scope="col">Guru</th>
                            <th scope="col">Hari</th>
                            <th scope="col">jam</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($jadwalKelas as $jk) : ?>
                            <tr>
                                <td><?= $i; ?></td>
                                <td><?= $kelas['kode_kelas']; ?></td>
                                <td><?= $kelas['kelas']; ?></td>
                                <td>
                                    <?php
                                    $namaMapel = $this->db->get_where('mapel', ['id' => $jk['mapel_id']])->row_array();
                                    echo $namaMapel['mapel'];
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    $ambilGuru = $this->db->get_where('guru', ['mapel_id' => $jk['mapel_id']])->result_array();
                                    foreach ($ambilGuru as $ag) {
                                        $cekAksesGuru = $this->db->get_where('guru_access_kelas', ['guru_id' => $ag['id'], 'kelas_id' => $kelas['id']])->row_array();
                                        if ($cekAksesGuru) {
                                            $namGuru = $this->db->get_where('guru', ['id' => $cekAksesGuru['guru_id']])->row_array();
                                            echo $namGuru['nama'];
                                        }
                                    }
                                    ?>
                                </td>
                                <td><?= $jk['hari']; ?></td>
                                <td><?= $jk['jam']; ?></td>
                                <td>
                                    <a href="#" class="tombolEditJadwalKelas" data-toggle="modal" data-target="#tambahJadwalKelas" data-id="<?= $jk['id']; ?>">
                                        <span class="badge rounded-pill badge-warning p-1 ml-2">edit</span>
                                    </a>
                                    <a href="<?= base_url('data/hapusjadwalkelas/') . $kelas['id'] . '/' . $jk['id']; ?>" id="hapus" name="hapus" onclick="return confirm('Yakin ingin menghapus jadwal ?')">
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

    <!-- Modal kelas-->
    <div class="modal fade" id="tambahJadwalKelas" tabindex="-1" role="dialog" aria-labelledby="tambahJadwalKelasLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header card-header">
                    <h5 class="modal-title" id="tambahJadwalkelasLabel">Tambah Jadwal</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="<?= base_url('data/detailkelas/') . $kelas['id']; ?>" method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="text" class="form-control" id="id" name="id" hidden>
                        </div>
                        <div class="form-group">
                            <label for="mapel" class="form-label">Mapel</label>
                            <select class="form-control" name="mapel" id="mapel">
                                <option>Pilih mapel</option>
                                <?php foreach ($mapel as $m) : ?>
                                    <option value="<?= $m['id']; ?>"><?= $m['mapel']; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <?= form_error('senin', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                        <div class="form-group">
                            <label for="hari" class="form-label">hari</label>
                            <input type="text" class="form-control" id="hari" name="hari" placeholder="masukkan hari kelas...">
                            <?= form_error('jam', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                        <div class="form-group">
                            <label for="jam" class="form-label">Jam</label>
                            <input type="text" class="form-control" id="jam" name="jam" placeholder="masukkan jam kelas...">
                            <?= form_error('jam', '<small class="text-danger pl-3">', '</small>'); ?>
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