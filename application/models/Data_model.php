<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Data_model extends CI_Model
{
    //user
    public function setUser($email, $status)
    {
        $this->db->set('is_active', $status);
        $this->db->where('email', $email);
        $this->db->update('user');
    }

    public function tambahUser($nama, $email, $password, $roleId, $status)
    {
        $this->db->insert('user', [
            'name' => htmlspecialchars($nama),
            'email' => htmlspecialchars($email),
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'role_id' => $roleId,
            'is_active' => $status
        ]);
    }

    public function deleteUser($email)
    {
        $data = $this->db->delete('user', ['email' => $email]);
        return $data;
    }

    //siswa
    public function tambahSiswa($nis, $nama, $email, $jurusan, $semester, $kelas, $status)
    {
        $this->db->insert('siswa', [
            'nis' => htmlspecialchars($nis),
            'nama' => htmlspecialchars($nama),
            'email' => htmlspecialchars($email),
            'jurusan_id' => htmlspecialchars($jurusan),
            'semester' => htmlspecialchars($semester),
            'kelas_id' => htmlspecialchars($kelas),
            'gambar' => 'default.jpg',
            'is_active' => htmlspecialchars($status)
        ]);
    }

    public function getSiswa($id)
    {
        $data = $this->db->get_where('siswa', ['id' => $id])->row_array();
        return $data;
    }
    public function setSiswa($id, $nis, $nama, $email, $jurusan, $semester, $kelas, $status)
    {
        $this->db->set([
            'nis' => htmlspecialchars($nis),
            'nama' => htmlspecialchars($nama),
            'email' => htmlspecialchars($email),
            'jurusan_id' => htmlspecialchars($jurusan),
            'semester' => htmlspecialchars($semester),
            'kelas_id' => htmlspecialchars($kelas),
            'is_active' => htmlspecialchars($status)
        ]);
        $this->db->where('id', $id);
        $this->db->update('siswa');
    }
    public function deleteSiswa($id)
    {
        $this->db->delete('siswa', ['id' => $id]);
    }

    //-----------jurusan----------------//
    //created
    public function createJururan($jurusan)
    {
        $this->db->insert('jurusan', ['jurusan' => htmlspecialchars($jurusan)]);
        $this->session->set_tempdata('pesan', '<div class="alert alert-success" role="alert">Berhasil menambahkan jurusan</div>');
        return redirect('data/daftarjurusan');
    }
    //set(edit)
    public function setJurusan($id, $jurusan)
    {
        $this->db->set('jurusan', htmlspecialchars($jurusan));
        $this->db->where('id', $id);
        $this->db->update('jurusan');
        $this->session->set_tempdata('pesan', '<div class="alert alert-success" role="alert">Jurusan berhasil diedit! </div>');
        return redirect('data/daftarjurusan');
    }
    //get
    public function getJurusan($id)
    {
        $result = $this->db->get_where('jurusan', ['id' => $id])->row_array();
        return $result;
    }
    //delete
    public function deleteJurusan($id)
    {
        $this->db->delete('jurusan', ['id' => $id]);
        $this->session->set_tempdata('pesan', '<div class="alert alert-success" role="alert">Berhasil menghapus jurusan</div>', 10);
        return redirect('data/daftarjurusan');
    }

    //................MAPEL..................
    //created
    public function createMapel($jurusanId, $kodeMapel, $mapel, $status)
    {
        $this->db->insert('mapel', [
            'jurusan_id' => $jurusanId,
            'kode_mapel' => htmlspecialchars($kodeMapel),
            'mapel' => htmlspecialchars($mapel),
            'is_active' => $status
        ]);

        $this->session->set_tempdata('pesan', '<div class="alert alert-success" role="alert">Berhasil menambahkan Mapel</div>', 10);
        return redirect('data/daftarmapel');
    }
    //get
    public function getMapel($id)
    {
        $result = $this->db->get_where('mapel', ['id' => $id])->row_array();
        return $result;
    }
    //set (edit)
    public function setMapel($id, $jurusanId, $kodeMapel, $mapel, $status)
    {
        $this->db->set([
            'jurusan_id' => htmlspecialchars($jurusanId),
            'kode_mapel' => htmlspecialchars($kodeMapel),
            'mapel' => htmlspecialchars($mapel),
            'is_active' => htmlspecialchars($status)
        ]);
        $this->db->where('id', $id);
        $this->db->update('mapel');

        $this->session->set_tempdata('pesan', '<div class="alert alert-success" role="alert">Berhasil edit Mata Pelajaran</div>', 10);
        return redirect('data/daftarmapel');
    }
    //delete
    public function deleteMapel($id)
    {
        $this->db->delete('mapel', ['id' => $id]);
        $this->session->set_tempdata('pesan', '<div class="alert alert-success" role="alert">Berhasil menghapus mapel</div>', 10);
        return redirect('data/daftarmapel');
    }

    //.....GURU..........//
    public function tambahGuru($nip, $nama, $email, $mapel, $status)
    {
        $this->db->insert('guru', [
            'nip' => htmlspecialchars($nip),
            'nama' => htmlspecialchars($nama),
            'email' => htmlspecialchars($email),
            'mapel_id' => htmlspecialchars($mapel),
            'gambar' => 'default.jpg',
            'is_active' => htmlspecialchars($status)
        ]);
    }

    public function setGuru($id, $nip, $nama, $email, $mapel, $status)
    {
        $this->db->set([
            'nip' => htmlspecialchars($nip),
            'nama' => htmlspecialchars($nama),
            'email' => htmlspecialchars($email),
            'mapel_id' => htmlspecialchars($mapel),
            'is_active' => htmlspecialchars($status)
        ]);
        $this->db->where('id', $id);
        $this->db->update('guru');
    }

    public function getGuru($id)
    {
        return $this->db->get_where('guru', ['id' => $id])->row_array();
    }

    public function getGuruAkses($id)
    {
        return $this->db->get_where('guru_access_kelas', ['guru_id' => $id])->result_array();
    }

    //guru akses kelas
    public function guruAksesKelas($kelasId, $id)
    {
        $result = $this->db->get_where('guru_access_kelas', ['guru_id' => $id, 'kelas_id' => $kelasId]);

        if ($result->num_rows() > 0) {
            $this->session->set_tempdata('pesan', '<div class="alert alert-danger" role="alert">  Gagal menambahkan kelas, kelas sudah ada! </div>');
            return redirect('data/detailguru/' . $id);
        } else {
            //insert ke tabel guru_access_kelas
            $this->db->insert('guru_access_kelas', [
                'guru_id' => htmlspecialchars($id),
                'kelas_id' => htmlspecialchars($kelasId)
            ]);
            //insert tabel siswa_access_guru
            $mapelGuru = $this->db->get_where('guru', ['id' => $id])->row_array();
            $this->db->insert('mapel_kelas', [
                'kelas_id' => $kelasId,
                'guru_id' => $mapelGuru['id'],
                'mapel_id' => $mapelGuru['mapel_id']
            ]);
            $this->session->set_tempdata('pesan', '<div class="alert alert-success" role="alert">  Berhasil menambahkan Guru akses kelas! </div>');
            return redirect('data/detailguru/' . $id);
        }
    }
    //hapus guru akses
    public function deleteGuruAkses($id, $guruId)
    {
        $this->db->delete('guru_access_kelas', ['id' => $id]);
        $this->session->set_tempdata('pesan', '<div class="alert alert-success" role="alert">Berhasil menghapus guru akses kelas</div>', 10);
        return redirect('data/detailguru/' . $guruId);
    }


    //hapus guru
    public function deleteGuru($id)
    {
        $guru = $this->db->get_where('guru', ['id' => $id])->row_array();
        $this->db->delete('user', ['email' => $guru['email']]);
        $this->db->delete('guru', ['id' => $id]);
        $this->db->delete('guru_access_kelas', ['guru_id' => $id]);
        $this->session->set_tempdata('pesan', '<div class="alert alert-success" role="alert">Berhasil menghapus guru</div>');
        return redirect('data/daftarguru');
    }

    //..........KELAS.........//
    //tambah kelas
    public function tambahKelas($kode, $kelas, $jurusan)
    {
        $this->db->insert('kelas', [
            'kode_kelas' => htmlspecialchars($kode),
            'kelas' => htmlspecialchars($kelas),
            'jurusan_id' => htmlspecialchars($jurusan)
        ]);
        $this->session->set_tempdata('pesan', '<div class="alert alert-success" role="alert">Berhasil menambahkan kelas</div>', 10);
        return redirect('data/daftarkelas');
    }
    //edit kelas
    public function setKelas($id, $kode, $kelas, $jurusan)
    {
        $this->db->set([
            'kode_kelas' => htmlspecialchars($kode),
            'kelas' => htmlspecialchars($kelas),
            'jurusan_id' => htmlspecialchars($jurusan)
        ]);
        $this->db->where('id', $id);
        $this->db->update('kelas');

        $this->session->set_tempdata('pesan', '<div class="alert alert-success" role="alert">Kelas berhasil diedit! </div>');
        return redirect('data/daftarkelas');
    }
    //tambah jadwal kelas
    public function tambahJadwalKelas($kelasId, $mapelId, $hari, $jam)
    {
        $this->db->insert('jadwal_kelas', [
            'kelas_id' => htmlspecialchars($kelasId),
            'mapel_id' => htmlspecialchars($mapelId),
            'hari' => htmlspecialchars($hari),
            'jam' => htmlspecialchars($jam)
        ]);
        $this->session->set_tempdata('pesan', '<div class="alert alert-success" role="alert">Berhasil menambah jadwal kelas</div>');
        return redirect('data/detailkelas/' . $kelasId);
    }
    //edit jadwal kelas
    public function setJadwalKelas($id, $kelasId, $mapelId, $hari, $jam)
    {
        $this->db->set([
            'mapel_id' => htmlspecialchars($mapelId),
            'hari' => htmlspecialchars($hari),
            'jam' => htmlspecialchars($jam)
        ]);
        $this->db->where('id', $id);
        $this->db->update('jadwal_kelas');

        $this->session->set_tempdata('pesan', '<div class="alert alert-success" role="alert">Berhasil mengedit jadwal</div>');
        return redirect('data/detailkelas/' . $kelasId);
    }
    //hapus jadwal kelas
    public function deleteJadwalKelas($kelasId, $id)
    {
        $this->db->delete('jadwal_kelas', ['id' => $id]);
        $this->session->set_tempdata('pesan', '<div class="alert alert-success" role="alert">Berhasil menghapus jadwal</div>', 10);
        return redirect('data/detailkelas/' . $kelasId);
    }
}
