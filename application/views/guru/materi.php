<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
    </div>
    <?= $this->session->tempdata('pesan'); ?>
    <?= $this->session->unset_tempdata('pesan'); ?>

    <!-- tombol tambah materi -->
    <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#tambahMateri" id="tombolTambahMateri">Tambah Materi</a>

    <!-- Tabel Jadwal Guru -->
    <div class="card mb-4" width="100%">
        <div class="card-header">
            <i class="fas fa-table mr-1"></i>
            Materi Pembelajaran <?= $guru['nama']; ?>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Pertemuan</th>
                            <th>File</th>
                            <th>Judul</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($materi as $m) : ?>
                            <tr>
                                <td><?= $i; ?></td>
                                <td>Pertemuan ke-<?= $m['pertemuan']; ?></td>
                                <td>
                                    <i class="fas fa-file-pdf"></i>
                                    <a href="<?= base_url('assets/file/') . $m['file']; ?>" style="overflow: hidden; white-space:nowrap; text-overflow:ellipsis;"><?= $m['file']; ?></a>
                                </td>
                                <td><?= $m['judul']; ?></td>
                                <td>
                                    <a href="<?= base_url('assets/file/') . $m['file']; ?>" id="detail" name="detail">
                                        <span class="badge rounded-pill badge-info p-1 ml-2">lihat</span>
                                    </a>
                                    <a href="#" class="tombolEditMateri" data-toggle="modal" data-target="#tambahMateri" data-materi="<?= $m['id']; ?>">
                                        <span class="badge rounded-pill badge-warning p-1 ml-2">edit</span>
                                    </a>
                                    <a href="<?= base_url('guru/hapusmateri/') . $m['id']; ?>" id="hapus" name="hapus" onclick="return confirm('Yakin ingin menghapus materi pertemuan ke-<?= $m['pertemuan']; ?> ?')">
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

    <!-- Heading video -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Video Pembelajaran</h1>
    </div>

    <!-- tombol tambah Video -->
    <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#tambahVideo" id="tombolTambahVideo">Tambah Video</a>

    <div class="row p-2">
        <?php foreach ($video as $v) : ?>
            <div class="card mb-5 mr-4" style="width: 18rem;">
                <iframe class="card-img-top" src="<?= $v['link']; ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                <div class="card-body p-2 text-center font-weight-bold">
                    <?= $v['judul']; ?>
                </div>
                <div class="card-footer">
                    <a href="#" class="tombolEditVideo" data-toggle="modal" data-target="#tambahVideo" data-video="<?= $v['id']; ?>">
                        <span class="badge rounded-pill badge-warning pl-2 pr-2 pt-1 pb-1 ml-2">edit</span>
                    </a>
                    <a href="<?= base_url('guru/hapusvideo/') . $v['id']; ?>" id="hapus" name="hapus" onclick="return confirm('Yakin ingin menghapus Video <?= $v['judul']; ?> ?')">
                        <span class="badge rounded-pill badge-danger p-1 ml-2">hapus</span>
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>


    <!-- Modal Materi-->
    <div class="modal fade" id="tambahMateri" tabindex="-1" role="dialog" aria-labelledby="tambahMateriLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header card-header">
                    <h5 class="modal-title" id="tambahMateriLabel">Tambah Materi</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <?= form_open_multipart('guru/materi'); ?>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" id="id" name="id" hidden>
                    </div>
                    <div class="form-group">
                        <label for="pertemuan" class="form-label">Pertemuan ke-</label>
                        <input type="text" class="form-control" id="pertemuan" name="pertemuan" placeholder="masukkan pertemuan...">
                        <?= form_error('pertemuan', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                    <div class="form-group">
                        <label for="judul" class="form-label">Judul</label>
                        <input type="text" class="form-control" id="judul" name="judul" placeholder="masukkan judul...">
                        <?= form_error('judul', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                    <div class="form-group">
                        <label for="file" class="form-label">File</label>
                        <div class="col-sm-10">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="file" name="file">
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

    <!-- Modal video-->
    <div class="modal fade" id="tambahVideo" tabindex="-1" role="dialog" aria-labelledby="tambahVideoLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header card-header">
                    <h5 class="modal-title" id="tambahVideoLabel">Tambah Video</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="<?= base_url('guru/tambahvideo/') . $guru['id']; ?>" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="text" class="form-control" id="videoId" name="videoId" hidden>
                        </div>
                        <div class="form-group">
                            <label for="judulVideo" class="form-label">Judul</label>
                            <input type="text" class="form-control" id="judulVideo" name="judulVideo" placeholder="masukkan judul...">
                            <?= form_error('judulVideo', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                        <div class="form-group">
                            <label for="link" class="form-label">link</label>
                            <input type="text" class="form-control" id="link" name="link" placeholder="masukkan link...">
                            <?= form_error('link', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                        <div class="modal-footer card-footer">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Tambah</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->