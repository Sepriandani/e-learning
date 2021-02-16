<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="text-center">
                <img src="<?= base_url('assets/img/profile/') . $siswa['gambar']; ?>" class="rounded-circle img-thumbnail" width="150">
                <h1 class="display-4"><?= $siswa['nama']; ?></h1>
                <h3 class="lead"><?= $siswa['email']; ?></h3>
                <h3 class="lead"><?= $siswa['nis']; ?></h3>
                <div class="row mt-3">
                    <div class="col-md mb-4">
                        <div class="card bg-primary text-white">
                            <div class="card-body text-center p-2">
                                <div class="h4 font-weight-bold text-white mb-0"><?= $siswa['semester']; ?></div>
                                <span class="small text-gray-800 text-uppercase">Semester</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md mb-4">
                        <div class="card bg-warning text-white">
                            <div class="card-body text-center p-2">
                                <div class="h4 font-weight-bold text-white mb-0">
                                    <?php
                                    $jurusan = $this->db->get_where('jurusan', ['id' => $siswa['jurusan_id']])->row_array();
                                    echo $jurusan['jurusan'];
                                    ?>
                                </div>
                                <span class="small text-gray-800 text-uppercase">jurusan</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md mb-4">
                        <div class="card bg-info text-white">
                            <div class="card-body text-center p-2">
                                <div class="h4 font-weight-bold text-white mb-0">
                                    <?php
                                    $kelas = $this->db->get_where('kelas', ['id' => $siswa['kelas_id']])->row_array();
                                    echo $kelas['kelas'];
                                    ?>
                                </div>
                                <span class="small text-gray-800 text-uppercase">Kelas</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->