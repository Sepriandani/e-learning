<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title . ' ' . $kelas['kelas'] . ' Pertemuan ke-' . $presensi['pertemuan']; ?></h1>
    </div>

    <!-- Tabel kelas -->
    <div class="card shadow mb-4">
        <div class="card-header">
            <i class="fas fa-table mr-1"></i>
            Tabel daftar presensi siswa pertemuan ke-<?= $presensi['pertemuan']; ?>
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
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($siswa as $s) : ?>
                            <?php $cekPresensi = $this->db->get_where('presensi_siswa', ['kelas_id' => $kelas['id'], 'guru_id' => $guru['id'], 'presensi_id' => $presensi['id'], 'siswa_id' => $s['id']])->num_rows(); ?>
                            <tr>
                                <td><?= $i; ?></td>
                                <td><?= $s['nis']; ?></td>
                                <td><?= $s['nama']; ?></td>
                                <td><?= $s['email']; ?></td>
                                <?php if ($cekPresensi > 0) : ?>
                                    <td>Hadir</td>
                                <?php else : ?>
                                    <td class="text-danger">Tidak Hadir</td>
                                <?php endif; ?>
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