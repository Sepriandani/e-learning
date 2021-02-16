<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
    </div>
    <?= $this->session->tempdata('pesan'); ?>
    <?= $this->session->unset_tempdata('pesan'); ?>

    <!-- form buat soal -->
    <div class="card mb-4">
        <div class="card-header">
            <div class="card-text">
                <h5 class="card-title font-weight-bold">Tugas ke-<?= $tugas['tugas']; ?></h5>
                <p class="mb-1">Materi : <?= $tugas['materi']; ?></p>
                <p class="mb-1">Tipe soal : <?= $tugas['tipe']; ?></p>
                <p class="mb-1">Jumlah soal : <?= $tugas['jumlah']; ?> soal</p>
            </div>
        </div>
        <div class="card-body">
            <div class="container">
                <form class="form-group" action="<?= base_url('guru/buatsoal/') . $tugas['id'] . '/' . $tugas['tipe']; ?>" method="POST">
                    <?php
                    if ($tugas['tipe'] == 'objectiv') {
                        $display = 'block';
                    } else {
                        $display = 'none';
                    }
                    ?>
                    <?php for ($i = 1; $i <= $tugas['jumlah']; $i++) : ?>
                        <div class="soal mb-5">
                            <div class="mb-3 row">
                                <label for="pertanyaan-<?= $i; ?>" class="col-form-label font-weight-bold"><?= $i; ?>. </label>
                                <div class="col-sm-8">
                                    <textarea class="form-control" id="pertanyaan-<?= $i; ?>" name="pertanyaan-<?= $i; ?>" aria-label="With textarea" placeholder="masukkan soal...." value="<?= set_value('pertanyaan-' . $i); ?>"></textarea>
                                    <?= form_error('pertanyaan-' . $i, '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                            </div>

                            <div class="ml-3 col-12" id="objectiv" style="display: <?= $display; ?>;">
                                <div class="form-group form-check-inline">
                                    <label class="form-label mr-2 font-weight-bold" for="pilihan-A-<?= $i; ?>">A. </label>
                                    <input type="text" class="form-control" id="pilihan-A-<?= $i; ?>" name="pilihan-A-<?= $i; ?>" value="<?= set_value('pilihan-A-' . $i); ?>">
                                    <?= form_error('pilihan-A-' . $i, '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                                <div class="form-group form-check-inline">
                                    <label class="form-label mr-2 font-weight-bold" for="pilihan-B-<?= $i; ?>">B. </label>
                                    <input type="text" class="form-control" id="pilihan-B-<?= $i; ?>" name="pilihan-B-<?= $i; ?>" value="<?= set_value('pilihan-B-' . $i); ?>">
                                    <?= form_error('pilihan-B-' . $i, '<small class="text-danger pl-3">', '</small>'); ?>

                                </div>
                                <div class="form-group form-check-inline">
                                    <label class="form-label mr-2 font-weight-bold" for="pilihan-C-<?= $i; ?>">C. </label>
                                    <input type="text" class="form-control" id="pilihan-C-<?= $i; ?>" name="pilihan-C-<?= $i; ?>" value="<?= set_value('pilihan-C-' . $i); ?>">
                                    <?= form_error('pilihan-C-' . $i, '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                                <div class="form-group form-check-inline">
                                    <label class="form-label mr-2 font-weight-bold" for="pilihan-D-<?= $i; ?>">D. </label>
                                    <input type="text" class="form-control" id="pilihan-C-<?= $i; ?>" name="pilihan-D-<?= $i; ?>" value="<?= set_value('pilihan-D-' . $i); ?>">
                                    <?= form_error('pilihan-D-' . $i, '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                                <div class="form-group form-check-inline">
                                    <label class="form-label mr-2 font-weight-bold" for="pilihan-E-<?= $i; ?>">E. </label>
                                    <input type="text" class="form-control" id="pilihan-C-<?= $i; ?>" name="pilihan-E-<?= $i; ?>" value="<?= set_value('pilihan-E-' . $i); ?>">
                                    <?= form_error('pilihan-E-' . $i, '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                            </div>
                        </div>
                    <?php endfor; ?>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Buat Soal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->