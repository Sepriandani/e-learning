<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
    </div>

    <?= $this->session->tempdata('pesan'); ?>
    <?= $this->session->unset_tempdata('pesan'); ?>

    <!-- tombol tambah tugas -->
    <a href="#" class="btn btn-primary mb-3" data-toggle="modal" data-target="#tambahTugas" id="tombolTambahTugas">Tambah Tugas</a>
    <!-- <div class="btn-group float-right mr-3">
        <a href="#" class="btn btn-primary">Active link</a>
        <a href="#" class="btn btn-primary">Link</a>
        <a href="#" class="btn btn-primary">Link</a>
    </div> -->

    <!-- Tabel Tugas -->
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table mr-1"></i>
            Daftar Tugas
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Tugas</th>
                            <th>Materi</th>
                            <th>Tipe</th>
                            <th>jml soal</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tugas as $t) : ?>
                            <tr>
                                <td>Tugas ke-<?= $t['tugas']; ?></td>
                                <td><?= $t['materi']; ?></td>
                                <td><?= $t['tipe']; ?></td>
                                <td><?= $t['jumlah']; ?> soal</td>
                                <td>
                                    <?php
                                    //cek tipe soal
                                    if ($t['tipe'] == 'objectiv') {
                                        $cekSoal = $this->db->get_where('soal_objectiv', ['tugas_id' => $t['id']])->num_rows();
                                    } else {
                                        $cekSoal = $this->db->get_where('soal_essay', ['tugas_id' => $t['id']])->num_rows();
                                    }

                                    if ($cekSoal > 0) {
                                        $link = base_url('guru/soal/' . $t['id']);
                                        $label = 'Lihat Soal';
                                        $warna = 'info';
                                    } else {
                                        $link = base_url('guru/buatsoal/' . $t['id'] . '/' . $t['tipe']);
                                        $label = 'Buat Soal';
                                        $warna = 'primary';
                                    }
                                    ?>
                                    <a href="<?= $link; ?>" id="buatSoal" name="buatSoal" class="card-link ">
                                        <span class="badge rounded-pill badge-<?= $warna; ?> p-1 ml-2"><?= $label; ?></span>
                                    </a>
                                    <a href="#" class="tombolEditTugas" data-toggle="modal" data-target="#tambahTugas" data-tugas="<?= $t['id']; ?>">
                                        <span class="badge rounded-pill badge-warning p-1 pl-2 pr-2 ml-2">Edit</span>
                                    </a>
                                    <a href="<?= base_url('guru/hapustugas/') . $t['id']; ?>" id="hapus" name="hapus" onclick="return confirm('Yakin ingin menghapus tugas ke-<?= $t['tugas']; ?> ?')">
                                        <span class="badge rounded-pill badge-danger p-1 ml-2">hapus</span>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal buat Tugas-->
    <div class="modal fade" id="tambahTugas" tabindex="-1" role="dialog" aria-labelledby="tambahTugasLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header card-header">
                    <h5 class="modal-title" id="tambahTugasLabel">Tambah Tugas</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="<?= base_url('guru/tugas'); ?>" method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="text" class="form-control" id="id" name="id" hidden>
                        </div>
                        <div class="form-group">
                            <label for="tugas" class="form-label">Tugas ke-</label>
                            <input type="text" class="form-control" id="tugas" name="tugas" placeholder="masukkan dalam angka (ex : 1)...">
                        </div>
                        <?= form_error('kelas', '<small class="text-danger pl-3">', '</small>'); ?>
                        <div class="form-group">
                            <label for="materi" class="form-label">Materi</label>
                            <input type="text" class="form-control" id="materi" name="materi" placeholder="masukkan judul materi...">
                            <?= form_error('materi', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                        <div class="form-group">
                            <label for="jumlah" class="form-label">Jumlah soal</label>
                            <input type="text" class="form-control" id="jumlah" name="jumlah" placeholder="masukkan dalam angka (ex: 10)...">
                            <?= form_error('jumlah', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                        <div class="form-group">
                            <label for="tipe" class="form-label">Tipe soal</label>
                            <select class="form-control" name="tipe" id="tipe">
                                <option>Piilih tipe</option>
                                <option value="objectiv">Objectiv</option>
                                <option value="essay">Essay</option>
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