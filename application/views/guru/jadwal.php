<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
    </div>

    <!-- Tabel Jadwal Guru -->
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table mr-1"></i>
            Jadwal mengajar <?= $guru['nama']; ?>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <!-- query jadwal -->
                        <?php
                        $guru_id = $guru['id'];
                        //join user_menu dengan user_access_menu
                        $queryKelas = "
                            SELECT `jadwal_kelas`.`id`, `jadwal_kelas`.`kelas_id`, `mapel_id`, `hari`, `jam`
                            FROM `jadwal_kelas` JOIN `guru_access_kelas`
                            ON `jadwal_kelas`.`kelas_id` = `guru_access_kelas`.`kelas_id`
                            WHERE `guru_access_kelas`.`guru_id` = $guru_id
                            ORDER BY `guru_access_kelas`.`kelas_id` ASC
                        ";
                        $jadwalKelas = $this->db->query($queryKelas)->result_array();
                        ?>

                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Kode Kelas</th>
                            <th scope="col">Kelas</th>
                            <th scope="col">Hari</th>
                            <th scope="col">jam</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($jadwalKelas as $jk) : ?>
                            <tr>
                                <?php if ($jk['mapel_id'] == $guru['mapel_id']) : ?>
                                    <td><?= $i; ?></td>
                                    <?php
                                    $ambilKelas = $this->db->get_where('kelas', ['id' => $jk['kelas_id']])->row_array();
                                    ?>
                                    <td><?= $ambilKelas['kode_kelas']; ?></td>
                                    <td><?= $ambilKelas['kelas']; ?></td>
                                    <td><?= $jk['hari']; ?></td>
                                    <td><?= $jk['jam']; ?></td>
                            </tr>
                            <?php $i++; ?>
                        <?php endif; ?>
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