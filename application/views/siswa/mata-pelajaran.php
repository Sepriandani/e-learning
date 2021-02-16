<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Mata Pelajaran</h1>
    </div>

    <!-- Content Row -->
    <div class="row">

        <?php
        $kelasId = $siswa['kelas_id'];
        //join user_menu dengan user_access_menu
        $queryMenu = "
                SELECT `guru`.`id`, `guru`.`mapel_id`, `nama`
                FROM `guru` JOIN `mapel_kelas`
                ON `guru`.`mapel_id` = `mapel_kelas`.`mapel_id`
                WHERE `mapel_kelas`.`kelas_id` = $kelasId
                ORDER BY `mapel_kelas`.`kelas_id` ASC
            ";
        $guru = $this->db->query($queryMenu)->result_array();
        ?>

        <!-- mata pelajaran -->
        <?php foreach ($mapelJurusan as $mj) : ?>
            <?php $ambilGuruId = $this->db->get_where('mapel_kelas', ['kelas_id' => $kelasId, 'mapel_id' => $mj['id']])->row_array();
            if ($ambilGuruId == false) {
                $ambilGuruId['guru_id'] = 0;
            }
            ?>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="h5 font-weight-bold text-primary text-uppercase mb-1">
                                    <a class="card-link" href="<?= base_url('siswa/materi/') . $ambilGuruId['guru_id'] . '/' . $mj['id']; ?>"><?= $mj['mapel']; ?></a>
                                </div>
                                <div class="text-xs mb-0 font-weight-bold text-gray-800">
                                    <?php
                                    if ($ambilGuruId) {
                                        $ambilGuruNama = $this->db->get_where('guru', ['id' => $ambilGuruId['guru_id']])->row_array();
                                        if ($ambilGuruNama) {
                                            echo $ambilGuruNama['nama'];
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="col-auto">
                                <a href="<?= base_url('siswa/materi/') . $ambilGuruId['guru_id'] . '/' . $mj['id']; ?>">
                                    <i class="fas fa-folder fa-2x text-gray-300"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

        <!-- mata pelajaran umum -->
        <?php foreach ($mapelUmum as $mu) : ?>
            <?php $guruUmum = $this->db->get_where('mapel_kelas', ['kelas_id' => $kelasId, 'mapel_id' => $mu['id']])->row_array();
            if ($guruUmum == false) {
                $guruUmum['guru_id'] = 0;
            }
            ?>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="h5 font-weight-bold text-primary text-uppercase mb-1">
                                    <a class="card-link" href="<?= base_url('siswa/materi/') . $guruUmum['guru_id'] . '/' . $mu['id']; ?>"><?= $mu['mapel']; ?></a>
                                </div>
                                <div class="text-xs mb-0 font-weight-bold text-gray-800">
                                    <?php
                                    if ($guruUmum) {
                                        $guruUmumNama = $this->db->get_where('guru', ['id' => $guruUmum['guru_id']])->row_array();
                                        if ($guruUmumNama) {
                                            echo $guruUmumNama['nama'];
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="col-auto">
                                <a href="<?= base_url('siswa/materi/') . $guruUmum['guru_id'] . '/' . $mu['id']; ?>">
                                    <i class="fas fa-folder fa-2x text-gray-300"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>


    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->