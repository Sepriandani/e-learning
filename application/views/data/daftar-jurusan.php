<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Daftar Jurusan</h1>
    </div>
    <?= $this->session->tempdata('pesan'); ?>
    <?= $this->session->unset_tempdata('pesan'); ?>

    <!-- tombol tambah jurusan -->
    <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#tambahJurusan" id="tombolTambahJurusan">Tambah jurusan</a>
    <!-- Tabel jurusan -->
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table mr-1"></i>
            Daftar jurusan SMAN16 Bandar Lampung
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID Jurusan</th>
                            <th>Nama Jurusan</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($jurusan as $j) : ?>
                            <tr>
                                <td><?= $i; ?></td>
                                <td><?= $j['id']; ?></td>
                                <td><?= $j['jurusan']; ?></td>
                                <td>
                                    <a href="#" class="tombolEditJurusan" data-toggle="modal" data-target="#tambahJurusan" data-jurusan="<?= $j['id']; ?>">
                                        <span class="badge rounded-pill badge-warning p-1 ml-2">edit</span>
                                    </a>
                                    <a href="<?= base_url('data/hapusjurusan/') . $j['id']; ?>" id="hapus" name="hapus" onclick="return confirm('Yakin ingin menghapus sub menu ?')">
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

    <!-- Modal-->
    <div class="modal fade" id="tambahJurusan" tabindex="-1" role="dialog" aria-labelledby="tambahJurusanLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header card-header">
                    <h5 class="modal-title" id="tambahJurusanLabel">Tambah Jurusan</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="<?= base_url('data/daftarjurusan'); ?>" method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="text" class="form-control" id="id" name="id" hidden>
                        </div>
                        <div class="form-group">
                            <label for="jurusan" class="form-label">Jurusan</label>
                            <input type="text" class="form-control" id="jurusan" name="jurusan" placeholder="masukkan jurusan...">
                        </div>
                        <?= form_error('jurusan', '<small class="text-danger pl-3">', '</small>'); ?>
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