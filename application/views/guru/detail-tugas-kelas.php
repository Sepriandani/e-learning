<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title . $tugas['tugas'] . ' kelas ' . $kelas['kelas']; ?></h1>
    </div>

    <!-- Tabel kelas -->
    <div class="card shadow mb-4">
        <div class="card-header">
            <p class="mb-1">Materi : <?= $tugas['materi'] ?></p>
            <p class="mb-1">Tipe soal : <?= $tugas['tipe']; ?></p>
            <p class="mb-1">Jumlah soal : <?= $tugas['jumlah']; ?> soal</p>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIS</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Nilai</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($tugasNilaiSiswa as $tns) : ?>
                            <?php $siswa = $this->db->get_where('siswa', ['id' => $tns['siswa_id']])->row_array(); ?>
                            <tr>
                                <td><?= $i; ?></td>
                                <td><?= $siswa['nis']; ?></td>
                                <td><?= $siswa['nama']; ?></td>
                                <td><?= $siswa['email'] ?></td>
                                <td><?= $tns['nilai']; ?></td>
                                <td></td>
                            </tr>
                            <?php $i++ ?>
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