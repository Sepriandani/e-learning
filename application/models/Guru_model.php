<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Guru_model extends CI_Model
{
    public function tambahMateri($guruId, $pertemuan, $judul, $new_file)
    {
        $this->db->insert('materi', [
            'guru_id' => $guruId,
            'pertemuan' => htmlspecialchars($pertemuan),
            'judul' => htmlspecialchars($judul),
            'file' => $new_file
        ]);

        $this->session->set_tempdata('pesan', '<div class="alert alert-success" role="alert">Berhasil menambah materi!</div>', 10);
        return redirect('guru/materi');
    }

    public function editMateri($materiId, $pertemuan, $judul, $new_file)
    {
        $this->db->set([
            'pertemuan' => htmlspecialchars($pertemuan),
            'judul' => htmlspecialchars($judul),
            'file' => $new_file
        ]);
        $this->db->where('id', $materiId);
        $this->db->update('materi');

        $this->session->set_tempdata('pesan', '<div class="alert alert-success" role="alert">Berhasil mengedit materi!</div>');
        return redirect('guru/materi');
    }

    public function tambahMateriKelas($guruId, $kelasId, $materiId, $deskripsi)
    {
        if ($materiId == 0) {
            $this->session->set_tempdata('pesan', '<div class="alert alert-warning" role="alert">Anda belum memilih pertemuan yang akan ditambahkan</div>');
            return redirect('guru/detailkelas/' . $kelasId);
        } else {
            $cekMateri = $this->db->get_where('kelas_access_materi', ['kelas_id' => $kelasId, 'materi_id' => $materiId]);
            if ($cekMateri->num_rows() > 0) {
                $this->session->set_tempdata('pesan', '<div class="alert alert-danger" role="alert">Gagal menambahkan materi, materi sudah ada!</div>');
                return redirect('guru/detailkelas/' . $kelasId);
            } else {
                $this->db->insert('kelas_access_materi', [
                    'kelas_id' => $kelasId,
                    'materi_id' => $materiId,
                    'guru_id' => $guruId,
                    'deskripsi' => htmlspecialchars($deskripsi),
                    'date_post' => time()
                ]);
                $this->session->set_tempdata('pesan', '<div class="alert alert-success" role="alert">Berhasil menambahkan materi!</div>');
                return redirect('guru/detailkelas/' . $kelasId);
            }
        }
    }
}
