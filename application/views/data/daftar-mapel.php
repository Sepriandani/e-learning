<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Daftar Mata Pelajaran</h1>
        <div class="float-right">
            <!-- tombol tambah mapel -->
            <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#tambahMapel" id="tombolTambah">Tambah Mata Pelajaran</a>
            <!-- tombol tambah mapel -->
            <a href="" class="btn btn-primary mb-3 ml-3" data-toggle="modal" data-target="#tambahMapelMasal" id="tombolTambahMapelMasal">Tambah Mapel Masal</a>
        </div>
    </div>

    <?= $this->session->tempdata('pesan'); ?>
    <?= $this->session->unset_tempdata('pesan'); ?>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Mata Pelajaran SMAN16 Bandar Lampung</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
                    <div class="row mb-2">
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
                            <div id="container">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>ID Mapel</th>
                                            <th>Kode Mapel</th>
                                            <th>Nama Mapel</th>
                                            <th>Jurusan</th>
                                            <th>status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = $this->uri->segment('3') + 1; ?>
                                        <?php foreach ($mapel as $m) : ?>
                                            <tr>
                                                <td><?= $no++; ?></td>
                                                <td><?= $m['id']; ?></td>
                                                <td><?= $m['kode_mapel']; ?></td>
                                                <td><?= $m['mapel']; ?></td>
                                                <td>
                                                    <?php
                                                    $j = $this->db->get_where('jurusan', ['id' => $m['jurusan_id']])->row_array();
                                                    echo $j['jurusan'];
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php if ($m['is_active'] == 1) {
                                                        echo 'Active';
                                                    } else {
                                                        echo 'Non-active';
                                                    } ?>
                                                </td>
                                                <td>
                                                    <a href="#" class="tombolEditMapel" data-toggle="modal" data-target="#tambahMapel" data-mapel="<?= $m['id']; ?>">
                                                        <span class="badge rounded-pill badge-warning px-2 py-1 ml-2">edit</span>
                                                    </a>
                                                    <a href="<?= base_url('data/hapusmapel/') . $m['id']; ?>" id="hapus" name="hapus" onclick="return confirm('Yakin ingin menghapus sub menu ?')">
                                                        <span class="badge rounded-pill badge-danger px-2 py-1 ml-2">hapus</span>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <?= $this->pagination->create_links(); ?>
                        </div>
                    </div>
                    <!-- <div class="row">
                        <div class="col-sm-12 col-md-5">
                            <div class="dataTables_info" id="dataTable_info" role="status" aria-live="polite">Showing 51 to 57 of 57 entries</div>
                        </div>
                        <div class="col-sm-12 col-md-7">
                            <div class="dataTables_paginate paging_simple_numbers" id="dataTable_paginate">
                                <ul class="pagination">
                                    <li class="paginate_button page-item previous" id="dataTable_previous"><a href="#" aria-controls="dataTable" data-dt-idx="0" tabindex="0" class="page-link">Previous</a></li>

                                    <li class="paginate_button page-item "><a href="#" aria-controls="dataTable" data-dt-idx="1" tabindex="0" class="page-link">1</a></li>

                                    <li class="paginate_button page-item active"><a href="#" aria-controls="dataTable" data-dt-idx="6" tabindex="0" class="page-link">6</a></li>
                                    <li class="paginate_button page-item next disabled" id="dataTable_next"><a href="#" aria-controls="dataTable" data-dt-idx="7" tabindex="0" class="page-link">Next</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>  -->
                </div>
            </div>
        </div>
    </div>


    <!-- Tabel Mapel
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table mr-1"></i>
            Daftar Mata Pelajaran SMAN16 Bandar Lampung
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID Mapel</th>
                            <th>Kode Mapel</th>
                            <th>Nama Mapel</th>
                            <th>Jurusan</th>
                            <th>status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = $this->uri->segment('3') + 1; ?>
                        <?php foreach ($mapel as $m) : ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= $m['id']; ?></td>
                                <td><?= $m['kode_mapel']; ?></td>
                                <td><?= $m['mapel']; ?></td>
                                <td>
                                    <?php
                                    $j = $this->db->get_where('jurusan', ['id' => $m['jurusan_id']])->row_array();
                                    echo $j['jurusan'];
                                    ?>
                                </td>
                                <td>
                                    <?php if ($m['is_active'] == 1) {
                                        echo 'Active';
                                    } else {
                                        echo 'Non-active';
                                    } ?>
                                </td>
                                <td>
                                    <a href="#" class="tombolEditMapel" data-toggle="modal" data-target="#tambahMapel" data-mapel="<?= $m['id']; ?>">
                                        <span class="badge rounded-pill badge-warning px-2 py-1 ml-2">edit</span>
                                    </a>
                                    <a href="<?= base_url('data/hapusmapel/') . $m['id']; ?>" id="hapus" name="hapus" onclick="return confirm('Yakin ingin menghapus sub menu ?')">
                                        <span class="badge rounded-pill badge-danger px-2 py-1 ml-2">hapus</span>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?= $this->pagination->create_links(); ?>
        </div>
    </div> -->

    <!-- Modal-->
    <div class="modal fade" id="tambahMapel" tabindex="-1" role="dialog" aria-labelledby="tambahMapelLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header card-header">
                    <h5 class="modal-title" id="tambahMapelLabel">Tambah Mapel</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="<?= base_url('data/daftarmapel'); ?>" method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="text" class="form-control" id="id" name="id" hidden>
                        </div>
                        <div class="form-group">
                            <label for="kodeMapel" class="form-label">Kode Mapel</label>
                            <input type="text" class="form-control" id="kodeMapel" name="kodeMapel">
                            <?= form_error('kodeMapel', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                        <div class="form-group">
                            <label for="mapel" class="form-label">Mapel</label>
                            <input type="text" class="form-control" id="mapel" name="mapel">
                            <?= form_error('mapel', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                        <div class="form-group">
                            <label for="jurusanId" class="form-label">Jurusan</label>
                            <select class="form-control" name="jurusanId" id="jurusanId">
                                <?php foreach ($jurusan as $jr) : ?>
                                    <option value="<?= $jr['id']; ?>"><?= $jr['jurusan']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-control" name="status" id="status">
                                <?php for ($i = 0; $i <= 1; $i++) : ?>
                                    <option value="<?= $i; ?>">
                                        <?php if ($i == 1) {
                                            echo 'Active';
                                        } else {
                                            echo 'Non-active';
                                        } ?>
                                    </option>
                                <?php endfor; ?>
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
    <div class="modal fade" id="tambahMapelMasal" tabindex="-1" role="dialog" aria-labelledby="tambahMapelMasalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header card-header">
                    <h5 class="modal-title" id="tambahMapelMasalLabel">Tambah mapel masal</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <?= form_open_multipart('data/importmapel'); ?>
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
    <!-- end modal tambah masal -->

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->