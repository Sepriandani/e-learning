<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pesan extends CI_Controller
{
    //komentar
    public function komentar($userId, $materiKelasId, $mapelId)
    {
        $komentar = $this->input->post('komentar');
        $guruId = $this->db->get_where('kelas_access_materi', ['id' => $materiKelasId])->row_array();

        $this->db->insert('pesan', [
            'user_id' => $userId,
            'materi_kelas_id' => $materiKelasId,
            'pesan' => htmlspecialchars($komentar),
            'date_created' => time()
        ]);

        $user = $this->db->get_where('user', ['id' => $userId])->row_array();
        if ($user['role_id'] == 2) {
            redirect('guru/detailkelasmateri/' . $materiKelasId);
        } else {
            redirect('siswa/materi/' . $guruId['guru_id'] . '/' . $mapelId);
        }
    }
}
