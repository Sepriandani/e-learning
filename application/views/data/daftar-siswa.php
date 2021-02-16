<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Daftar Siswa</h1>
        <div class="float-right">
            <!-- tombol tambah mapel -->
            <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#editSiswa" id="tombolTambahSiswa">Tambah Siswa</a>
            <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#tambahSiswaMasal" id="tombolTambahSiswaMasal">Tambah Siswa Masal</a>
        </div>
    </div>
    <?= $this->session->tempdata('pesan'); ?>
    <?= $this->session->unset_tempdata('pesan'); ?>


    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Siswa SMAN16 Bandar Lampung</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
                    <div class="row mb-2">
                        <div class="col-sm-12 col-md-6">
                            <div class="dataTables_length" id="dataTable_length">
                                <label>Show
                                    <select name="dataTable_length" aria-controls="dataTable" class="custom-select custom-select-sm form-control form-control-sm">
                                        <option value="5">5</option>
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
                                    <input type="text" class="form-control form-control-sm" id="keyword" name="keyword" placeholder="cari siswa...." aria-controls="dataTable">
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div id="containerSiswa">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>NIS</th>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>Jurusan</th>
                                            <th>Kelas</th>
                                            <th>Semester</th>
                                            <th>Status</th>
                                            <th>Action</th>
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
                                                <td>
                                                    <?php
                                                    $ambilJurusan = $this->db->get_where('jurusan', ['id' => $s['jurusan_id']])->row_array();
                                                    if ($ambilJurusan) {
                                                        echo $ambilJurusan['jurusan'];
                                                    } else {
                                                        echo '-';
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    $ambilKelas = $this->db->get_where('kelas', ['id' => $s['kelas_id']])->row_array();
                                                    if ($ambilKelas) {
                                                        echo $ambilKelas['kelas'];
                                                    } else {
                                                        echo '-';
                                                    }
                                                    ?>
                                                </td>
                                                <td><?= $s['semester']; ?></td>
                                                <td>
                                                    <?php
                                                    if ($s['is_active'] == 1) {
                                                        echo 'Active';
                                                    } else {
                                                        echo 'No-active';
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <a href="<?= base_url('data/detailsiswa/') . $s['id']; ?>" id="detail" name="detail">
                                                        <span class="badge rounded-pill badge-info p-1 ml-2">detail</span>
                                                    </a>
                                                    <a href="#" class="tombolEditSiswa" data-toggle="modal" data-target="#editSiswa" data-siswa="<?= $s['id']; ?>">
                                                        <span class="badge rounded-pill badge-warning p-1 ml-2">edit</span>
                                                    </a>
                                                    <a href="<?= base_url('data/hapussiswa/') . $s['id']; ?>" id="hapus" name="hapus" onclick="return confirm('Yakin ingin menghapus Siswa <?= $s['nama']; ?> ?')">
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
                    <div class="row">
                        <div class="col">
                            <?= $this->pagination->create_links(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal edit siswa-->
    <div class="modal fade" id="editSiswa" tabindex="-1" role="dialog" aria-labelledby="editSiswaLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header card-header">
                    <h5 class="modal-title" id="editSiswaLabel">Edit Siswa</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="<?= base_url('data/daftarsiswa'); ?>" method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="text" class="form-control" id="id" name="id" hidden readonly>
                        </div>
                        <div class="form-group">
                            <label for="nis" class="form-label">NIS</label>
                            <input type="text" class="form-control" id="nis" name="nis">
                            <?= form_error('nip', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                        <div class="form-group">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama">
                            <?= form_error('nama', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                        <div class="form-group">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email">
                            <?= form_error('email', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                        <div class="form-group">
                            <label for="jurusan" class="form-label">Jurusan</label>
                            <select class="form-control" name="jurusan" id="jurusan">
                                <option>Pilih Jurusan</option>
                                <?php foreach ($jurusan as $j) : ?>
                                    <option value="<?= $j['id']; ?>"><?= $j['jurusan']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="kelas" class="form-label">Kelas</label>
                            <select class="form-control" name="kelas" id="kelas">
                                <option>Pilih Kelas</option>
                                <?php foreach ($kelas as $k) : ?>
                                    <option value="<?= $k['id']; ?>"><?= $k['kelas']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="semester" class="form-label">Semester</label>
                            <select class="form-control" name="semester" id="semester">
                                <option>Pilih Semester</option>
                                <?php for ($i = 1; $i <= 6; $i++) : ?>
                                    <option value="<?= $i; ?>"><?= $i; ?></option>
                                <?php endfor; ?>
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
                        <div class="password" style="display: none;">
                            <div class="form-group">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password">
                                <?= form_error('email', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>
                            <div class="form-group">
                                <label for="password2" class="form-label">Ulangi Password</label>
                                <input type="password" class="form-control" id="password2" name="password2">
                                <?= form_error('email', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer card-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Edit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- end modal tambah siswa -->

    <!-- Modal tambah masal-->
    <div class="modal fade" id="tambahSiswaMasal" tabindex="-1" role="dialog" aria-labelledby="tambahSiswaMasalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header card-header">
                    <h5 class="modal-title" id="tambahSiswaMasalLabel">Import siswa masal</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <?= form_open_multipart('data/importsiswa'); ?>
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


</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->