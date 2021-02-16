<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th>No</th>
            <th>NIS</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Jurusan</th>
            <th>Kelas</th>
            <th>Semester</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php $i = $this->uri->segment('3') + 1; ?>
        <?php foreach ($siswa as $s) : ?>
            <tr>
                <td><?= $i; ?></td>
                <td><?= $s['nis']; ?></td>
                <td><?= $s['nama']; ?></td>
                <td><?= $s['email']; ?></td>
                <td>
                    <?php
                    $ambilJurusan = $this->db->get_where('jurusan', ['id' => $s['jurusan_id']])->row_array();
                    if ($ambilJurusan) {
                        echo $ambilJurusan['jurusan'];
                    } else {
                        echo '-';
                    }
                    ?>
                </td>
                <td>
                    <?php
                    $ambilKelas = $this->db->get_where('kelas', ['id' => $s['kelas_id']])->row_array();
                    if ($ambilKelas) {
                        echo $ambilKelas['kelas'];
                    } else {
                        echo '-';
                    }
                    ?>
                </td>
                <td><?= $s['semester']; ?></td>
                <td>
                    <?php
                    if ($s['is_active'] == 1) {
                        echo 'Active';
                    } else {
                        echo 'No-active';
                    }
                    ?>
                </td>
                <td>
                    <a href="<?= base_url('data/detailsiswa/') . $s['id']; ?>" id="detail" name="detail">
                        <span class="badge rounded-pill badge-info p-1 ml-2">detail</span>
                    </a>
                    <a href="#" class="tombolEditSiswa" data-toggle="modal" data-target="#editSiswa" data-siswa="<?= $s['id']; ?>">
                        <span class="badge rounded-pill badge-warning p-1 ml-2">edit</span>
                    </a>
                    <a href="<?= base_url('data/hapussiswa/') . $s['id']; ?>" id="hapus" name="hapus" onclick="return confirm('Yakin ingin menghapus Siswa <?= $s['nama']; ?> ?')">
                        <span class="badge rounded-pill badge-danger p-1 ml-2">hapus</span>
                    </a>
                </td>
            </tr>
            <?php $i++; ?>
        <?php endforeach; ?>
    </tbody>
</table>