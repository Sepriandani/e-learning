<!-- Tabel Jadwal Guru -->
<?php $i = 1; ?>
<?php foreach ($materiKelas as $mk) : ?>
    <?php $ambilMateri = $this->db->get_where('materi', ['id' => $mk['materi_id']])->row_array(); ?>
    <div class="row p-3">
        <div class="card mb-4" style="width: 25rem; height:auto">
            <div class="card-header p-2">
                <div class="row">
                    <div class="col-lg-3">
                        <img class="rounded-circle img-thumbnail p-0 m-1" src="<?= base_url('assets/img/profile/') . $guru['gambar'] ?>">
                    </div>
                    <div class="p-0 ml-2 mt-3 col-lg-6">
                        <h5 class="card-title mr-2"><?= $guru['nama']; ?></h5>
                        <h6 class="card-subtitle mb-2 text-muted mr-2">Card subtitle</h6>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.Some quick example text to build on the card title and make up the bulk of the card's content</p>
                <p>Lampiran :</p>
                <i class="fas fa-file-pdf"></i>
                <a href="<?= base_url('assets/file/') . $ambilMateri['file']; ?>"><?= $ambilMateri['file']; ?></a>
            </div>
        </div>
    </div>
    <?php $i++; ?>
<?php endforeach; ?>