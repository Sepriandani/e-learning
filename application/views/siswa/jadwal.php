<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Jadwal Pelajaran</h1>
    </div>

    <!-- Tabel jadwal pelajaran -->
    <div class="card mb-4" id="tabelJadwal">
        <div class="card-header">
            <i class="fas fa-table mr-1"></i>
            Jadwal pelajaran siswa <?= $kelas['kelas']; ?>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Kode Kelas</th>
                            <th scope="col">Kelas</th>
                            <th scope="col">Mapel</th>
                            <th scope="col">Guru</th>
                            <th scope="col">Hari</th>
                            <th scope="col">jam</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($jadwalKelas as $jk) : ?>
                            <tr>
                                <td><?= $i; ?></td>
                                <td><?= $kelas['kode_kelas']; ?></td>
                                <td><?= $kelas['kelas']; ?></td>
                                <td>
                                    <?php
                                    $namaMapel = $this->db->get_where('mapel', ['id' => $jk['mapel_id']])->row_array();
                                    echo $namaMapel['mapel'];
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    $ambilGuru = $this->db->get_where('guru', ['mapel_id' => $jk['mapel_id']])->result_array();
                                    foreach ($ambilGuru as $ag) {
                                        $cekAksesGuru = $this->db->get_where('guru_access_kelas', ['guru_id' => $ag['id'], 'kelas_id' => $kelas['id']])->row_array();
                                        if ($cekAksesGuru) {
                                            $namGuru = $this->db->get_where('guru', ['id' => $cekAksesGuru['guru_id']])->row_array();
                                            echo $namGuru['nama'];
                                        }
                                    }
                                    ?>
                                </td>
                                <td><?= $jk['hari']; ?></td>
                                <td><?= $jk['jam']; ?></td>
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