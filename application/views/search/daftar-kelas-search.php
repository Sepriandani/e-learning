<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th>No</th>
            <th>ID Kelas</th>
            <th>Kode ruangan</th>
            <th>Nama Kelas</th>
            <th>Jurusan</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php $i = $this->uri->segment('3') + 1; ?>
        <?php foreach ($kelas as $k) : ?>
            <tr>
                <td><?= $i; ?></td>
                <td><?= $k['id']; ?></td>
                <td><?= $k['kode_kelas']; ?></td>
                <td><?= $k['kelas']; ?></td>
                <td>
                    <?php
                    $kelasJurusan = $this->db->get_where('jurusan', ['id' => $k['jurusan_id']])->row_array();
                    echo $kelasJurusan['jurusan'];
                    ?>
                </td>
                <td>
                    <a href="<?= base_url('data/detailkelas/') . $k['id']; ?>" id="detail" name="detail">
                        <span class="badge rounded-pill badge-info p-1 ml-2">detail</span>
                    </a>
                    <a href="#" class="tombolEditKelas" data-toggle="modal" data-target="#tambahKelas" data-kelas="<?= $k['id']; ?>">
                        <span class="badge rounded-pill badge-warning p-1 ml-2">edit</span>
                    </a>
                    <a href="<?= base_url('data/hapuskelas/') . $k['id']; ?>" id="hapus" name="hapus" onclick="return confirm('Yakin ingin menghapus sub menu ?')">
                        <span class="badge rounded-pill badge-danger p-1 ml-2">hapus</span>
                    </a>
                </td>
            </tr>
            <?php $i++; ?>
        <?php endforeach; ?>
    </tbody>
</table>