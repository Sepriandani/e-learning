<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th>No</th>
            <th>NIP</th>
            <th>Name</th>
            <th>Email</th>
            <th>Pengampu</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php $i = $this->uri->segment('3') + 1; ?>
        <?php foreach ($guru as $g) : ?>
            <tr>
                <td><?= $i; ?></td>
                <td><?= $g['nip']; ?></td>
                <td><?= $g['nama']; ?></td>
                <td><?= $g['email']; ?></td>
                <td>
                    <?php
                    $ambilMapel = $this->db->get_where('mapel', ['id' => $g['mapel_id']])->row_array();
                    if ($ambilMapel) {
                        echo $ambilMapel['mapel'];
                    } else {
                        echo '-';
                    }
                    ?>
                </td>
                <td>
                    <?php
                    if ($g['is_active'] == 1) {
                        echo 'Active';
                    } else {
                        echo 'Non-active';
                    }
                    ?>
                </td>
                <td>
                    <a href="<?= base_url('data/detailguru/') . $g['id']; ?>" id="detail" name="detail">
                        <span class="badge rounded-pill badge-info p-1 ml-2">detail</span>
                    </a>
                    <a href="#" class="tombolEditGuru" data-toggle="modal" data-target="#editGuru" data-guru="<?= $g['id']; ?>">
                        <span class="badge rounded-pill badge-warning p-1 ml-2">edit</span>
                    </a>
                    <a href="<?= base_url('data/hapusguru/') . $g['id']; ?>" id="hapus" name="hapus" onclick="return confirm('Yakin ingin menghapus guru <?= $g['nama']; ?> ?')">
                        <span class="badge rounded-pill badge-danger p-1 ml-2">hapus</span>
                    </a>
                </td>
            </tr>
            <?php $i++; ?>
        <?php endforeach; ?>
    </tbody>
</table>