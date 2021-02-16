<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Pengumuman</h1>
        <button type="button" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#tambahPengumuman" id="tombolTambahPengumuman">Tambah Pengumuman</button>
    </div>
    <div class="col-lg-6">
        <?= $this->session->tempdata('pesan'); ?>
        <?= $this->session->unset_tempdata('pesan'); ?>
    </div>

    <div class="mt-5">
        <div class="row">
            <div class="col-lg-3">
                <ul class="list-group">
                    <?php foreach ($pengumuman as $active) : ?>
                        <?php
                        if ($active['is_active'] == 0) {
                            $status = 'Non-active';
                            $label = 'Terbitkan';
                        } else {
                            $status = 'Active';
                            $label = 'Non-aktifkan';
                        }
                        ?>
                        <li class="list-group-item p" style="overflow: hidden; white-space:nowrap; text-overflow:ellipsis;">
                            <a href="#" class="card-link detail-toggler" data-target="detail-<?= $active['id'] ?>">
                                <i class="fas fa-fw fa-chevron-down"></i>
                                <span><?= $active['headline']; ?></span>
                            </a>
                            <div class="action" style="display: none;" id="detail-<?= $active['id'] ?>">
                                <div class="card-text mt-2 mb-2">
                                    <p class="mb-1">Status : <?= $status; ?></p>
                                    <p class="mb-1">Dibuat : <?= date('d F Y', $active['date_created']); ?></p>
                                    <p class="mb-1">Terbit :
                                        <?php
                                        if ($active['date_post'] == 0) {
                                            echo 'belum diterbitkan';
                                        } else {
                                            echo date('d F Y', $active['date_post']);
                                        }
                                        ?>
                                    </p>
                                </div>
                                <a href="<?= base_url('admin/terbitkanPengumuman/') . $active['id'] . '/' . $status; ?>" id="detail" name="detail">
                                    <span class="badge rounded-pill badge-info p-1"><?= $label; ?></span>
                                </a>
                                <a href="#" class="tombolEditPengumuman" data-toggle="modal" data-target="#tambahPengumuman" data-id="<?= $active['id']; ?>">
                                    <span class="badge rounded-pill badge-warning pl-2 pr-2 pt-1 pb-1 ml-2">edit</span>
                                </a>
                                <a href="<?= base_url('admin/hapuspengumuman/') . $active['id']; ?>" id="hapus" name="hapus" onclick="return confirm('Yakin ingin menghapus pengumuman <?= $active['headline'] ?> ?')">
                                    <span class="badge rounded-pill badge-danger p-1 ml-2">hapus</span>
                                </a>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- card pengumuman -->
            <div class="col-lg-7">
                <?php foreach ($pengumuman as $p) : ?>
                    <section id="pengumuman<?= $p['id']; ?>">
                        <div class="card mb-4">
                            <img src="<?= base_url('assets/img/pengumuman/') . $p['gambar']; ?>" class="card-img-top" alt="...">
                            <div class="card-header bg-white font-weight-bold">
                                <?= $p['headline']; ?>
                            </div>
                            <div class="card-body">
                                <div class="text-gray-800">
                                    <?= $p['pengumuman']; ?>
                                </div>
                            </div>
                            <div class="card-footer small text-muted bg-whit">Terakhir diedit:
                                <?php
                                if ($active['date_post'] == 0) {
                                    echo 'belum diterbitkan';
                                } else {
                                    echo date('d F Y', $active['date_post']);
                                }
                                ?>
                            </div>
                        </div>
                    </section>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Modal Pengumuman-->
    <div class="modal fade" id="tambahPengumuman" tabindex="-1" role="dialog" aria-labelledby="tambahPengumumanLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header card-header">
                    <h5 class="modal-title" id="tambahPengumumanLabel">Tambah Pengumuman</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <?= form_open_multipart('admin/pengumuman'); ?>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" id="id" name="id" hidden>
                    </div>
                    <div class="form-group">
                        <label for="headline" class="form-label">Headline</label>
                        <input class="form-control" id="headline" name="headline" placeholder="masukkan headline...."></input>
                        <?= form_error('headline', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                    <div class="form-group">
                        <label for="pengumuman" class="form-label">Isi Pengumuman</label>
                        <textarea class="form-control" id="pengumuman" name="pengumuman" aria-label="With textarea" placeholder="masukkan pengumuman...."></textarea>
                        <?= form_error('pengumuman', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                    <!-- <div class="form-group">
                            <label for="pengumuman" class="form-label">upload file</label>
                            <br>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="gambar" value="option1">
                                <label class="form-check-label" for="inlineRadio1">Gambar</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="document" value="option2">
                                <label class="form-check-label" for="inlineRadio2">Document</label>
                            </div>
                        </div> -->
                    <div class="form-group">
                        <label class="form-label">pilih gambar</label>
                        <div class="col-sm-10">
                            <div class="row">
                                <!-- <div class="col-sm-3">
                                        <img src="<?= base_url('assets/img/profile/default.jpg'); ?>" class="img-thumbnail">
                                    </div> -->
                                <div class="col-sm-9">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="image" name="image">
                                        <label for="image" class="custom-file-label">Chose file</label>
                                    </div>
                                </div>
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
    <!-- End Modal -->

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->