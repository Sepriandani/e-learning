<!-- Begin Page Content -->
<div class="container-fluid">


    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="card shadow">
                <h5 class="card-header font-weight-bold text-center">Tugas Ke-<?= $tugas['tugas']; ?></h5>

                <div class="card-body">
                    <div class="row col-lg-12">
                        <div class="col-lg-6 mb-2">
                            <p class="card-title mb-1">Nama: <?= $siswa['nama']; ?></p>
                            <p class="card-title mb-1">NIS : <?= $siswa['nis']; ?></p>
                            <p class="card-text mb-1">Telah dikerjakan</p>
                            <p class="card-text">05:18, 12 Februari 2021</p>
                        </div>
                        <div class="col-lg-6">
                            <div class="text-center">
                                <h5 class="card-text mb-1 p-0">Nilai</h5>
                                <h1 class="card-text font-weight-bold mt-0 p-0"><?= $nilai; ?></h1>
                                <a href="<?= base_url('siswa/resultdetail/') . $tugas['id']; ?>" class="btn btn-primary p-1 text-center">Lihat Hasil</a>
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