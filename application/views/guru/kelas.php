<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Kelas yang diajar</h1>
    </div>

    <!-- Tabel kelas -->
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table mr-1"></i>
            Daftar kelas <?= $guru['nama']; ?>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>

                        <!-- query menu -->
                        <?php
                        $guru_id = $guru['id'];
                        //join user_menu dengan user_access_menu
                        $queryMenu = "
                            SELECT `kelas`.`id`, `kode_kelas`, `kelas`
                            FROM `kelas` JOIN `guru_access_kelas`
                            ON `kelas`.`id` = `guru_access_kelas`.`kelas_id`
                            WHERE `guru_access_kelas`.`guru_id` = $guru_id
                            ORDER BY `guru_access_kelas`.`kelas_id` ASC 
                        ";
                        $kelas = $this->db->query($queryMenu)->result_array();
                        ?>

                        <tr>
                            <th>No</th>
                            <th>Kode ruangan</th>
                            <th>Nama Kelas</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($kelas as $k) : ?>
                            <tr>
                                <td><?= $i; ?></td>
                                <td><?= $k['kode_kelas']; ?></td>
                                <td><?= $k['kelas']; ?></td>
                                <td>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <a class="small text-info-800" href="<?= base_url('guru/detailkelas/') . $k['id']; ?>">Lihat kelas</a>
                                        <div class="small text-info"><i class="fas fa-angle-right"></i></div>
                                    </div>
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