<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Profile</h1>
    </div>
    <?= $this->session->tempdata('pesan'); ?>
    <?= $this->session->unset_tempdata('pesan'); ?>

    <!-- tombol edit profile -->
    <a href="<?= base_url('guru/editprofile'); ?>" class="btn btn-primary mb-3">Edit Profile</a>

    <div class="container">
        <div class="row justify-content-center">
            <div class="text-center">
                <img src="<?= base_url('assets/img/profile/') . $guru['gambar']; ?>" class="rounded-circle img-thumbnail" width="150">
                <h1 class="display-4"><?= $guru['nama']; ?></h1>
                <h3 class="lead"><?= $guru['email']; ?></h3>
                <h3 class="lead"><?= $guru['nip']; ?></h3>
                <h3 class="lead">
                    <?php
                    $mapel = $this->db->get_where('mapel', ['id' => $guru['mapel_id']])->row_array();
                    echo $mapel['mapel'];
                    ?>
                </h3>
            </div>
        </div>
    </div>


</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->