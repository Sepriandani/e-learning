<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Guru Akses Kelas</h1>
    </div>

    <?= $this->session->tempdata('pesan'); ?>
    <?= $this->session->unset_tempdata('pesan'); ?>


    <div class="row">
        <div class="col-lg-6">
            <form action="<?= base_url('data/guruaccesskelas'); ?>" method="POST">
                <div class="form-group">
                    <label for="name" class="col-sm-2 col-form-label">Guru</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="guruId" id="guruId">
                            <?php foreach ($guru as $g) : ?>
                                <option value="<?= $g['id']; ?>"><?= $g['nama']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="name" class="col-sm-2 col-form-label">Kelas</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="kelasId" id="kelasId">
                            <?php foreach ($kelas as $k) : ?>
                                <option value="<?= $k['id']; ?>"><?= $k['kelas']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Tambah akses</button>
                </div>
            </form>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->