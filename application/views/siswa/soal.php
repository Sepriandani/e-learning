<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
    </div>

    <?= $this->session->tempdata('pesan'); ?>
    <?= $this->session->unset_tempdata('pesan'); ?>

    <!-- form soal -->
    <div class="card shadow mb-4">
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
                <!-- input data nama, nis -->
                <div class="card-text mb-3">
                    <p class="mb-1">Nama : <?= $siswa['nama']; ?></p>
                    <p class="mb-1">NIS : <?= $siswa['nis']; ?></p>
                </div>
                <form action="<?= base_url('siswa/soal/') . $tugas['id']; ?>" method="post" class="form-group">
                    <!-- jika tipe soal objectiv eksekusi ini -->
                    <?php if ($tugas['tipe'] == 'objectiv') : ?>

                        <?php $i = 1; ?>
                        <?php foreach ($soal as $s) : ?>
                            <div class="soal mb-3">
                                <p class="mb-1 font-weight-bold h6"><?= $i . '. ' . $s['pertanyaan']; ?></p>
                                <div class="objectiv ml-2 col-12">
                                    <div class="form-check form-check">
                                        <input class="form-check-input" type="radio" name="jawaban-<?= $i; ?>" id="jawaban-<?= $i; ?>" value="<?= $s['pilihan_a']; ?>">
                                        <label class="form-check-label" for="jawaban-<?= $i; ?>"><strong>A.</strong> <?= $s['pilihan_a']; ?></label>
                                    </div>
                                    <div class="form-check form-check">
                                        <input class="form-check-input" type="radio" name="jawaban-<?= $i; ?>" id="jawaban-<?= $i; ?>" value="<?= $s['pilihan_b']; ?>">
                                        <label class="form-check-label" for="jawaban-<?= $i; ?>"><strong>B.</strong> <?= $s['pilihan_b']; ?></label>
                                    </div>
                                    <div class="form-check form-check">
                                        <input class="form-check-input" type="radio" name="jawaban-<?= $i; ?>" id="jawaban-<?= $i; ?>" value="<?= $s['pilihan_c']; ?>">
                                        <label class="form-check-label" for="jawaban-<?= $i; ?>"><strong>C.</strong> <?= $s['pilihan_c']; ?></label>
                                    </div>
                                    <div class="form-check form-check">
                                        <input class="form-check-input" type="radio" name="jawaban-<?= $i; ?>" id="jawaban-<?= $i; ?>" value="<?= $s['pilihan_d']; ?>">
                                        <label class="form-check-label" for="jawaban-<?= $i; ?>"><strong>D.</strong> <?= $s['pilihan_d']; ?></label>
                                    </div>
                                    <div class="form-check form-check">
                                        <input class="form-check-input" type="radio" name="jawaban-<?= $i; ?>" id="jawaban-<?= $i; ?>" value="<?= $s['pilihan_e']; ?>">
                                        <label class="form-check-label" for="jawaban"><strong>E.</strong> <?= $s['pilihan_e']; ?></label>
                                    </div>
                                    <?= form_error('jawaban-' . $i, '<small class="text-danger pl-3">', '</small>'); ?>
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
                                <textarea class="form-control" id="jawaban-<?= $i; ?>" name="jawaban-<?= $i; ?>" aria-label="With textarea" placeholder="jawaban soal...."></textarea>
                            </div>
                            <?php $i++; ?>
                        <?php endforeach; ?>

                    <?php endif; ?>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->