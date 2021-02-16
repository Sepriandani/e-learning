<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Daftar Kelas</h1>
        <div class="float-right">
            <!-- tombol tambah kelas -->
            <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#tambahKelas" id="tombolTambahkelas">Tambah Kelas</a>
            <!-- tombol tambah mapel -->
            <a href="" class="btn btn-primary mb-3 ml-3" data-toggle="modal" data-target="#tambahKelasMasal" id="tombolTambahKelasMasal">Tambah Kelas Masal</a>
        </div>
    </div>
    <?= $this->session->tempdata('pesan'); ?>
    <?= $this->session->unset_tempdata('pesan'); ?>


    <!-- Tabel kelas -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar kelas SMAN16 Bandar Lampung</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <div class="dataTables_length" id="dataTable_length">
                                <label>Show
                                    <select name="dataTable_length" aria-controls="dataTable" class="custom-select custom-select-sm form-control form-control-sm">
                                        <option value="5">7</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </select> entries
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div id="dataTable_filter" class="dataTables_filter">
                                <form action="" method="GET">
                                    <input type="text" class="form-control form-control-sm" id="keyword" name="keyword" placeholder="cari...." aria-controls="dataTable">
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div id="containerKelas">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>ID Kelas</th>
                                            <th>Kode ruangan</th>
                                            <th>Nama Kelas</th>
                                            <th>Jurusan</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = $this->uri->segment('3') + 1; ?>
                                        <?php foreach ($kelas as $k) : ?>
                                            <tr>
                                                <td><?= $i; ?></td>
                                                <td><?= $k['id']; ?></td>
                                                <td><?= $k['kode_kelas']; ?></td>
                                                <td><?= $k['kelas']; ?></td>
                                                <td>
                                                    <?php
                                                    $kelasJurusan = $this->db->get_where('jurusan', ['id' => $k['jurusan_id']])->row_array();
                                                    echo $kelasJurusan['jurusan'];
                                                    ?>
                                                </td>
                                                <td>
                                                    <a href="<?= base_url('data/detailkelas/') . $k['id']; ?>" id="detail" name="detail">
                                                        <span class="badge rounded-pill badge-info p-1 ml-2">detail</span>
                                                    </a>
                                                    <a href="#" class="tombolEditKelas" data-toggle="modal" data-target="#tambahKelas" data-kelas="<?= $k['id']; ?>">
                                                        <span class="badge rounded-pill badge-warning p-1 ml-2">edit</span>
                                                    </a>
                                                    <a href="<?= base_url('data/hapuskelas/') . $k['id']; ?>" id="hapus" name="hapus" onclick="return confirm('Yakin ingin menghapus sub menu ?')">
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

                        <div class="row">
                            <div class="col">
                                <?= $this->pagination->create_links(); ?>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal-->
    <div class="modal fade" id="tambahKelas" tabindex="-1" role="dialog" aria-labelledby="tambahKelasLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header card-header">
                    <h5 class="modal-title" id="tambahKelasLabel">Tambah Kelas</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="<?= base_url('data/daftarkelas'); ?>" method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="text" class="form-control" id="id" name="id" hidden>
                        </div>
                        <div class="form-group">
                            <label for="kode" class="form-label">Kode Kelas</label>
                            <input type="text" class="form-control" id="kode" name="kode" placeholder="masukkan kode kelas...">
                        </div>
                        <?= form_error('kelas', '<small class="text-danger pl-3">', '</small>'); ?>
                        <div class="form-group">
                            <label for="kelas" class="form-label">Kelas</label>
                            <input type="text" class="form-control" id="kelas" name="kelas" placeholder="masukkan nama kelas...">
                            <?= form_error('kelas', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                        <div class="form-group">
                            <label for="kelasJurusan" class="form-label">Jurusan</label>
                            <select class="form-control" name="kelasJurusan" id="kelasJurusan">
                                <?php foreach ($jurusan as $jr) : ?>
                                    <option value="<?= $jr['id']; ?>"><?= $jr['jurusan']; ?></option>
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

    <!-- Modal tambah masal-->
    <div class="modal fade" id="tambahKelasMasal" tabindex="-1" role="dialog" aria-labelledby="tambahKelasMasalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header card-header">
                    <h5 class="modal-title" id="tambahKelasMasalLabel">Tambah Kelas Masal</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <?= form_open_multipart('data/importkelas'); ?>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" id="id" name="id" hidden>
                    </div>
                    <div class="form-group">
                        <label for="file" class="form-label">File</label>
                        <div class="col-sm-10">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="excel" name="excel">
                                <label for="file" class="custom-file-label">Pilih File</label>
                            </div>
                            <?= form_error('file', '<small class="text-danger pl-3">', '</small>'); ?>
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
    <!-- end modal tambah masa -->

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->