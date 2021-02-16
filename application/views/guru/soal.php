<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
        <?php if ($tugas['tipe'] == 'objectiv') : ?>
            <div class="float-right">
                <?php if ($soal[0]['kunci_jawaban']) : ?>
                    <a href="#" class="btn btn-warning mb-3" data-toggle="modal" data-target="#kunciJawaban" id="tombolKunciJawaban">Edit Kunci Jawaban</a>
                    <a href="#" class="btn btn-info mb-3" data-toggle="modal" data-target="#kunciJawaban" id="tombolLihatJawaban">Lihat kunci jawaban</a>
                <?php else : ?>
                    <a href="#" class="btn btn-primary mb-3" data-toggle="modal" data-target="#kunciJawaban" id="tombolKunciJawaban">Buat Kunci Jawaban</a>
                <?php endif; ?>
                <a href="#" class="btn btn-success mb-3" data-toggle="modal" data-target="#bobotNilai" id="tombolBobotNilai">Bobot Nilai</a>
            </div>
        <?php endif; ?>
    </div>

    <?= $this->session->tempdata('pesan'); ?>
    <?= $this->session->unset_tempdata('pesan'); ?>

    <!-- form buat soal -->
    <div class="card mb-4">
        <div class="card-header">
            <div class="card-text">
                <h5 class="card-title font-weight-bold">Tugas Ke-<?= $tugas['tugas']; ?></h5>
                <p class="mb-1">Materi : <?= $tugas['materi'] ?></p>
                <p class="mb-1">Tipe soal : <?= $tugas['tipe']; ?></p>
                <p class="mb-1">Jumlah soal : <?= $tugas['jumlah']; ?> soal</p>
            </div>
        </div>
        <div class="card-body">
            <div class="container">

                <!-- jika tipe soal objectiv eksekusi ini -->
                <?php if ($tugas['tipe'] == 'objectiv') : ?>

                    <?php $i = 1; ?>
                    <?php foreach ($soal as $s) : ?>
                        <div class="soal mb-3">
                            <div class="tombol float-right">
                                <a href="#" class="tombolEditSoal card-link" data-toggle="modal" data-target="#editSoal" data-edit="<?= $s['id']; ?>" data-tipe="<?= $tugas['tipe']; ?>">
                                    <span class="badge rounded-pill badge-warning pl-2 pr-2 pt-1 pb-1">Edit</span>
                                </a>
                                <a href="<?= base_url('guru/hapussoal/') . $tugas['id'] . '/' . $s['id']; ?>" class="card-link" id="hapus" name="hapus" onclick="return confirm('Yakin ingin menghapus soal no-<?= $i; ?> ?')">
                                    <span class="badge rounded-pill badge-danger p1-2 pr-2 pt-1 pb-1">hapus</span>
                                </a>
                            </div>
                            <p class="mb-1 font-weight-bold h6 inline"><?= $i . '. ' . $s['pertanyaan']; ?><span class="mb-1 h6 inline"><?= ' (' . $s['bobot_nilai'] . ' point)'; ?></span></p>
                            <div class="objectiv col-12">
                                <div class="form-check form-check">
                                    <label class="form-check-label" for="inlineRadio1"><strong>A.</strong> <?= $s['pilihan_a']; ?></label>
                                </div>
                                <div class="form-check form-check">
                                    <label class="form-check-label" for="inlineRadio2"><strong>B.</strong> <?= $s['pilihan_b']; ?></label>
                                </div>
                                <div class="form-check form-check">
                                    <label class="form-check-label" for="inlineRadio2"><strong>C.</strong> <?= $s['pilihan_c']; ?></label>
                                </div>
                                <div class="form-check form-check">
                                    <label class="form-check-label" for="inlineRadio2"><strong>D.</strong> <?= $s['pilihan_d']; ?></label>
                                </div>
                                <div class="form-check form-check">
                                    <label class="form-check-label" for="inlineRadio2"><strong>E.</strong> <?= $s['pilihan_e']; ?></label>
                                </div>
                            </div>
                        </div>
                        <?php $i++; ?>
                    <?php endforeach; ?>
                    <!-- jika tipe soal essay ekseskusi ini -->
                <?php else : ?>

                    <?php $i = 1; ?>
                    <?php foreach ($soal as $so) : ?>
                        <div class="soal mb-3">
                            <p class="mb-1 font-weight-bold h6"><?= $i . '. ' . $so['pertanyaan']; ?></p>
                        </div>
                        <?php $i++; ?>
                    <?php endforeach; ?>

                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Modal edit soal-->
    <div class="modal fade" id="editSoal" tabindex="-1" role="dialog" aria-labelledby="editSoalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header card-header">
                    <h5 class="modal-title" id="editSoalLabel">Edit Soal</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="<?= base_url('guru/soal/' . $tugas['id']); ?>" method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="text" class="form-control" id="id" name="id" hidden>
                        </div>
                        <div class="form-group">
                            <label for="pertanyaan" class="form-label">Pertanyaan</label>
                            <textarea class="form-control" id="pertanyaan" name="pertanyaan" aria-label="With textarea"></textarea>
                            <?= form_error('kelas', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                        <div class="form-group form-check-inline">
                            <label for="pilihan-A" class="form-label form-check-inline">A. </label>
                            <input type="text" class="form-control" id="pilihan-A" name="pilihan-A">
                            <?= form_error('pilihan-A', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                        <div class="form-group form-check-inline">
                            <label for="pilihan-B" class="form-label form-check-inline">B. </label>
                            <input type="text" class="form-control" id="pilihan-B" name="pilihan-B">
                            <?= form_error('pilihan-A', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                        <div class="form-group form-check-inline">
                            <label for="pilihan-C" class="form-label form-check-inline">C. </label>
                            <input type="text" class="form-control" id="pilihan-C" name="pilihan-C">
                            <?= form_error('pilihan-C', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                        <div class="form-group form-check-inline">
                            <label for="pilihan-D" class="form-label form-check-inline">D. </label>
                            <input type="text" class="form-control" id="pilihan-D" name="pilihan-D">
                            <?= form_error('pilihan-D', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                        <div class="form-group form-check-inline">
                            <label for="pilihan-E" class="form-label form-check-inline">E. </label>
                            <input type="text" class="form-control" id="pilihan-E" name="pilihan-E">
                            <?= form_error('pilihan-E', '<small class="text-danger pl-3">', '</small>'); ?>
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

    <!-- Modal Kunci jawaban-->
    <div class="modal fade" id="kunciJawaban" tabindex="-1" role="dialog" aria-labelledby="kunciJawabanLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header card-header">
                    <h5 class="modal-title" id="kunciJawabanLabel">Buat kunci jawaban</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="<?= base_url('guru/kuncijawaban/') . $guru['id'] . '/' . $tugas['id']; ?>" method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="text" class="form-control" id="id" name="id" hidden>
                        </div>
                        <div id="tampilKunciJawaban" style="display: none;">
                            <?php $j = 1; ?>
                            <?php foreach ($soal as $so) : ?>
                                <div class="form-group">
                                    <p class="mb-1 font-weight-bold h6"><?= $j . '. ' . $so['pertanyaan']; ?></p>
                                    <?php
                                    if ($so['kunci_jawaban'] == $so['pilihan_a']) {
                                        $pilihan = 'A. ';
                                    } elseif ($so['kunci_jawaban'] == $so['pilihan_b']) {
                                        $pilihan = 'B. ';
                                    } elseif ($so['kunci_jawaban'] == $so['pilihan_c']) {
                                        $pilihan = 'C. ';
                                    } elseif ($so['kunci_jawaban'] == $so['pilihan_d']) {
                                        $pilihan = 'D. ';
                                    } else {
                                        $pilihan = 'E. ';
                                    }
                                    ?>
                                    <p class="ml-3 mb-1 h6"><strong><?= $pilihan; ?></strong><?= $so['kunci_jawaban']; ?></p>
                                </div>
                                <?php $j++; ?>
                            <?php endforeach; ?>
                        </div>
                        <div id="inputKunciJawaban">
                            <?php $i = 1; ?>
                            <?php foreach ($soal as $kj) : ?>

                                <div class="form-group">
                                    <input type="text" class="form-control" id="idSoal-<?= $i; ?>" name="idSoal-<?= $i; ?>" value="<?= $kj['id']; ?>" hidden>
                                    <p class="mb-1 font-weight-bold h6"><?= $i . '. ' . $kj['pertanyaan']; ?></p>
                                    <select class="form-control" name="jawabanSoal-<?= $i; ?>" id="jawabanSoal-<?= $i; ?>">
                                        <option>Piilih jawaban</option>
                                        <option value="<?= $kj['pilihan_a']; ?>">A. <?= $kj['pilihan_a']; ?></option>
                                        <option value="<?= $kj['pilihan_b']; ?>">B. <?= $kj['pilihan_b']; ?></option>
                                        <option value="<?= $kj['pilihan_c']; ?>">C. <?= $kj['pilihan_c']; ?></option>
                                        <option value="<?= $kj['pilihan_d']; ?>">D. <?= $kj['pilihan_d']; ?></option>
                                        <option value="<?= $kj['pilihan_e']; ?>">E. <?= $kj['pilihan_e']; ?></option>
                                    </select>
                                </div>
                                <?php $i++; ?>
                            <?php endforeach; ?>
                        </div>
                        <div id="inputBobotNilai" style="display: none;">
                            <?php $k = 1; ?>
                            <?php foreach ($soal as $bn) : ?>
                                <div class="form-group">
                                    <input type="text" class="form-control" id="idSoal-<?= $k; ?>" name="idSoal-<?= $k; ?>" value="<?= $bn['id']; ?>" hidden>
                                    <p class="mb-1 font-weight-bold h6"><?= $k . '. ' . $bn['pertanyaan']; ?></p>
                                    <input type="text" class="form-control" id="bobotNilaiSoal-<?= $k; ?>" name="bobotNilaiSoal-<?= $k; ?>" placeholder="ex: 10">

                                </div>
                                <?php $k++; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="modal-footer card-footer" id="kunciJawabanFooter">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Buat</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <!-- Modal bobot nilai-->
    <div class="modal fade" id="bobotNilai" tabindex="-1" role="dialog" aria-labelledby="bobotNilaiLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header card-header">
                    <h5 class="modal-title" id="bobotNilaiLabel">Tambah bobot nilai per-soal</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="<?= base_url('guru/bobotnilai/') . $guru['id'] . '/' . $tugas['id']; ?>" method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="text" class="form-control" id="id" name="id" hidden>
                        </div>
                        <?php $k = 1; ?>
                        <?php foreach ($soal as $bn) : ?>
                            <div class="form-group">
                                <input type="text" class="form-control" id="idSoal-<?= $k; ?>" name="idSoal-<?= $k; ?>" value="<?= $bn['id']; ?>" hidden>
                                <p class="mb-1 font-weight-bold h6"><?= $k . '. ' . $bn['pertanyaan']; ?></p>
                                <input type="text" class="form-control" id="bobotNilaiSoal-<?= $k; ?>" name="bobotNilaiSoal-<?= $k; ?>" placeholder="ex: 10">

                            </div>
                            <?php $k++; ?>
                        <?php endforeach; ?>
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