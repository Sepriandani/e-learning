<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
    </div>

    <!-- Tabel jadwal pelajaran -->
    <div class="card shadow mb-4" id="tabelJadwal">
        <div class="card-header">
            <i class="fas fa-table mr-1"></i>
            Daftar tugas <?= $siswa['nama']; ?>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Mapel</th>
                            <th scope="col">Tugas</th>
                            <th scope="col">Materi</th>
                            <th scope="col">Nilai</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($tugasKelas as $tk) : ?>
                            <tr>
                                <td><?= $i; ?></td>
                                <td>
                                    <?php
                                    $tugas = $this->db->get_where('tugas', ['id' => $tk['tugas_id']])->row_array();
                                    $guru = $this->db->get_where('guru', ['id' => $tugas['guru_id']])->row_array();
                                    $mapel = $this->db->get_where('mapel', ['id' => $guru['mapel_id']])->row_array();

                                    echo $mapel['mapel'];
                                    ?>
                                </td>
                                <td><?= 'Tugas ke-' . $tugas['tugas']; ?></td>
                                <td><?= $tugas['materi']; ?></td>
                                <td>
                                    <?php
                                    $nilaiTugas = $this->db->get_where('tugas_nilai_siswa', ['siswa_id' => $siswa['id'], 'tugas_id' => $tk['tugas_id']])->row_array();
                                    if ($nilaiTugas) {
                                        echo $nilaiTugas['nilai'];
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    $jawabanSiswa = $this->db->get_where('tugas_jawaban_siswa', ['siswa_id' => $siswa['id'], 'tugas_id' => $tk['tugas_id']])->num_rows();
                                    if ($jawabanSiswa > 0) {
                                        echo 'Telah dikerjakan';
                                    } else {
                                        echo 'Belum dikerjakan';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php if ($jawabanSiswa > 0) : ?>
                                        <a href="<?= base_url('siswa/resultdetail/') . $tk['tugas_id'] ?>" class="card-link">
                                            <span class="badge rounded-pill badge-info pl-2 pr-2 ml-2">lihat hasil</span>
                                        </a>
                                    <?php else : ?>
                                        <a href="<?= base_url('siswa/soal/') . $tk['tugas_id'] ?>" class="card-link ">
                                            <span class="badge rounded-pill badge-warning pl-2 pr-2  ml-2">Kerjakan</span>
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php $i++; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->