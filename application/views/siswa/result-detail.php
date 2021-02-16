<!-- Begin Page Content -->
<div class="container-fluid">

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

                <!-- jika tipe soal objectiv eksekusi ini -->
                <?php if ($tugas['tipe'] == 'objectiv') : ?>

                    <?php $i = 1; ?>
                    <?php foreach ($soal as $s) : ?>
                        <?php
                        $jawabanSiswa = $this->db->get_where('tugas_jawaban_siswa', ['siswa_id' => $siswa['id'], 'tugas_id' => $tugas['id'], 'soal_id' => $s['id']])->row_array();
                        ?>
                        <div class="soal mb-3">
                            <p class="mb-1 font-weight-bold h6"><?= $i . '. ' . $s['pertanyaan']; ?> <span class="mb-1 small inline"><?= ' (' . $s['bobot_nilai'] . ' point)'; ?></span></p>
                            <div class="objectiv ml-2 col-12">

                                <!-- pilihan a -->
                                <?php if ($s['pilihan_a'] == $s['kunci_jawaban']) : ?>
                                    <div class="row">
                                        <div class="alert alert-success col-lg-4 pt-1 pl-1 pb-1 m-0 ml-2" role="alert">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" <?= check_access($siswa['id'], $tugas['id'], $s['id'], $s['pilihan_a']); ?>>
                                                <label class="form-check-label"><strong>A.</strong> <?= $s['pilihan_a']; ?></label>
                                            </div>
                                        </div>
                                    </div>
                                <?php elseif ($s['pilihan_a'] == $s['kunci_jawaban'] && $jawabanSiswa['jawaban'] != $s['kunci_jawaban']) : ?>
                                    <div class="row">
                                        <div class="alert alert-danger col-lg-4 pt-1 pl-1 pb-1 m-0 ml-2" role="alert">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" <?= check_access($siswa['id'], $tugas['id'], $s['id'], $s['pilihan_a']); ?>>
                                                <label class="form-check-label"><strong>A.</strong> <?= $s['pilihan_a']; ?></label>
                                            </div>
                                        </div>
                                    </div>
                                <?php else : ?>
                                    <?php if ($s['pilihan_a'] == $jawabanSiswa['jawaban'] && $jawabanSiswa['jawaban'] != $s['kunci_jawaban']) : ?>
                                        <div class="row">
                                            <div class="alert alert-danger col-lg-4 pt-1 pl-1 pb-1 m-0 ml-2" role="alert">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" <?= check_access($siswa['id'], $tugas['id'], $s['id'], $s['pilihan_a']); ?>>
                                                    <label class="form-check-label"><strong>A.</strong> <?= $s['pilihan_a']; ?></label>
                                                </div>
                                            </div>
                                        </div>
                                    <?php else : ?>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" <?= check_access($siswa['id'], $tugas['id'], $s['id'], $s['pilihan_a']); ?>>
                                            <label class="form-check-label"><strong>A.</strong> <?= $s['pilihan_a']; ?></label>
                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>

                                <!-- pilihan b -->
                                <?php if ($s['pilihan_b'] == $s['kunci_jawaban']) : ?>
                                    <div class="row">
                                        <div class="alert alert-success col-lg-4 pt-1 pl-1 pb-1 m-0 ml-2" role="alert">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" <?= check_access($siswa['id'], $tugas['id'], $s['id'], $s['pilihan_b']); ?>>
                                                <label class="form-check-label"><strong>B.</strong> <?= $s['pilihan_b']; ?></label>
                                            </div>
                                        </div>
                                    </div>
                                <?php else : ?>
                                    <?php if ($s['pilihan_b'] == $jawabanSiswa['jawaban'] && $jawabanSiswa['jawaban'] != $s['kunci_jawaban']) : ?>
                                        <div class="row">
                                            <div class="alert alert-danger col-lg-4 pt-1 pl-1 pb-1 m-0 ml-2" role="alert">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" <?= check_access($siswa['id'], $tugas['id'], $s['id'], $s['pilihan_b']); ?>>
                                                    <label class="form-check-label"><strong>B.</strong> <?= $s['pilihan_b']; ?></label>
                                                </div>
                                            </div>
                                        </div>
                                    <?php else : ?>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" <?= check_access($siswa['id'], $tugas['id'], $s['id'], $s['pilihan_b']); ?>>
                                            <label class="form-check-label"><strong>B.</strong> <?= $s['pilihan_b']; ?></label>
                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>

                                <!-- pilihan c -->
                                <?php if ($s['pilihan_c'] == $s['kunci_jawaban']) : ?>
                                    <div class="row">
                                        <div class="alert alert-success col-lg-4 pt-1 pl-1 pb-1 m-0 ml-2" role="alert">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" <?= check_access($siswa['id'], $tugas['id'], $s['id'], $s['pilihan_c']); ?>>
                                                <label class="form-check-label"><strong>C.</strong> <?= $s['pilihan_c']; ?></label>
                                            </div>
                                        </div>
                                    </div>
                                <?php else : ?>
                                    <?php if ($s['pilihan_c'] == $jawabanSiswa['jawaban'] && $jawabanSiswa['jawaban'] != $s['kunci_jawaban']) : ?>
                                        <div class="row">
                                            <div class="alert alert-danger col-lg-4 pt-1 pl-1 pb-1 m-0 ml-2" role="alert">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" <?= check_access($siswa['id'], $tugas['id'], $s['id'], $s['pilihan_c']); ?>>
                                                    <label class="form-check-label"><strong>C.</strong> <?= $s['pilihan_c']; ?></label>
                                                </div>
                                            </div>
                                        </div>
                                    <?php else : ?>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" <?= check_access($siswa['id'], $tugas['id'], $s['id'], $s['pilihan_c']); ?>>
                                            <label class="form-check-label"><strong>C.</strong> <?= $s['pilihan_c']; ?></label>
                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>

                                <!-- pilihan d -->
                                <?php if ($s['pilihan_d'] == $s['kunci_jawaban']) : ?>
                                    <div class="row">
                                        <div class="alert alert-success col-lg-4 pt-1 pl-1 pb-1 m-0 ml-2" role="alert">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" <?= check_access($siswa['id'], $tugas['id'], $s['id'], $s['pilihan_d']); ?>>
                                                <label class="form-check-label"><strong>D.</strong> <?= $s['pilihan_d']; ?></label>
                                            </div>
                                        </div>
                                    </div>
                                <?php else : ?>
                                    <?php if ($s['pilihan_d'] == $jawabanSiswa['jawaban'] && $jawabanSiswa['jawaban'] != $s['kunci_jawaban']) : ?>
                                        <div class="row">
                                            <div class="alert alert-danger col-lg-4 pt-1 pl-1 pb-1 m-0 ml-2" role="alert">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" <?= check_access($siswa['id'], $tugas['id'], $s['id'], $s['pilihan_d']); ?>>
                                                    <label class="form-check-label"><strong>D.</strong> <?= $s['pilihan_d']; ?></label>
                                                </div>
                                            </div>
                                        </div>
                                    <?php else : ?>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" <?= check_access($siswa['id'], $tugas['id'], $s['id'], $s['pilihan_d']); ?>>
                                            <label class="form-check-label"><strong>D.</strong> <?= $s['pilihan_d']; ?></label>
                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>

                                <!-- pilihan e -->
                                <?php if ($s['pilihan_e'] == $s['kunci_jawaban']) : ?>
                                    <div class="row">
                                        <div class="alert alert-success col-lg-4 pt-1 pl-1 pb-1 m-0 ml-2" role="alert">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" <?= check_access($siswa['id'], $tugas['id'], $s['id'], $s['pilihan_e']); ?>>
                                                <label class="form-check-label"><strong>E.</strong> <?= $s['pilihan_e']; ?></label>
                                            </div>
                                        </div>
                                    </div>
                                <?php else : ?>
                                    <?php if ($s['pilihan_e'] == $jawabanSiswa['jawaban'] && $jawabanSiswa['jawaban'] != $s['kunci_jawaban']) : ?>
                                        <div class="row">
                                            <div class="alert alert-danger col-lg-4 pt-1 pl-1 pb-1 m-0 ml-2" role="alert">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" <?= check_access($siswa['id'], $tugas['id'], $s['id'], $s['pilihan_e']); ?>>
                                                    <label class="form-check-label"><strong>E.</strong> <?= $s['pilihan_e']; ?></label>
                                                </div>
                                            </div>
                                        </div>
                                    <?php else : ?>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" <?= check_access($siswa['id'], $tugas['id'], $s['id'], $s['pilihan_e']); ?>>
                                            <label class="form-check-label"><strong>E</strong> <?= $s['pilihan_e']; ?></label>
                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>
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
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->