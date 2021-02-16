<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th>No</th>
            <th>ID Mapel</th>
            <th>Kode Mapel</th>
            <th>Nama Mapel</th>
            <th>Jurusan</th>
            <th>status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1; ?>
        <?php foreach ($mapel as $m) : ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= $m['id']; ?></td>
                <td><?= $m['kode_mapel']; ?></td>
                <td><?= $m['mapel']; ?></td>
                <td>
                    <?php
                    $j = $this->db->get_where('jurusan', ['id' => $m['jurusan_id']])->row_array();
                    echo $j['jurusan'];
                    ?>
                </td>
                <td>
                    <?php if ($m['is_active'] == 1) {
                        echo 'Active';
                    } else {
                        echo 'Non-active';
                    } ?>
                </td>
                <td>
                    <a href="#" class="tombolEditMapel" data-toggle="modal" data-target="#tambahMapel" data-mapel="<?= $m['id']; ?>">
                        <span class="badge rounded-pill badge-warning px-2 py-1 ml-2">edit</span>
                    </a>
                    <a href="<?= base_url('data/hapusmapel/') . $m['id']; ?>" id="hapus" name="hapus" onclick="return confirm('Yakin ingin menghapus sub menu ?')">
                        <span class="badge rounded-pill badge-danger px-2 py-1 ml-2">hapus</span>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>