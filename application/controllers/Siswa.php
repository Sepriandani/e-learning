<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Siswa extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Password_model', 'password');
        date_default_timezone_set("Asia/Jakarta");
        is_logged_in();
    }
    public function index()
    {
        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('user', ['email' => $email])->row_array();
        $data['title'] = 'Home';
        $data['siswa'] = $this->db->get_where('siswa', ['email' => $data['user']['email']])->row_array();
        $data['pengumuman'] = $this->db->get_where('pengumuman', ['is_active' => 1])->result_array();

        $this->load->view('template/user-header', $data);
        $this->load->view('template/siswa-sidebar');
        $this->load->view('template/user-topbar');
        $this->load->view('siswa/index');
        $this->load->view('template/user-footer');
    }
    public function profile()
    {
        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('user', ['email' => $email])->row_array();
        $data['title'] = 'Profile';
        $data['siswa'] = $this->db->get_where('siswa', ['email' => $data['user']['email']])->row_array();

        $this->load->view('template/user-header', $data);
        $this->load->view('template/siswa-sidebar');
        $this->load->view('template/user-topbar', $data);
        $this->load->view('siswa/profile', $data);
        $this->load->view('template/user-footer');
    }
    public function editProfile()
    {
        $data['title'] = 'Edit Profile';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['siswa'] = $this->db->get_where('siswa', ['email' => $data['user']['email']])->row_array();
        $data['jurusan'] = $this->db->get('jurusan')->result_array();
        $data['kelas'] = $this->db->get('kelas')->result_array();

        $this->form_validation->set_rules('name', 'Full Name', 'required|trim');
        $this->form_validation->set_rules('nis', 'NIS', 'required|trim');
        $this->form_validation->set_rules('jurusanId', 'Jurusan', 'required');
        $this->form_validation->set_rules('semester', 'Semester', 'required|trim');
        $this->form_validation->set_rules('kelasId', 'Kelas', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/user-header', $data);
            $this->load->view('template/siswa-sidebar');
            $this->load->view('template/user-topbar', $data);
            $this->load->view('siswa/edit-profile', $data);
            $this->load->view('template/user-footer', $data);
        } else {
            $name = $this->input->post('name');
            $email = $this->input->post('email');
            $nis = $this->input->post('nis');
            $jurusanId = $this->input->post('jurusanId');
            $semester = $this->input->post('semester');
            $kelasId = $this->input->post('kelasId');

            //cek gambar
            $upload_image = $_FILES['image']['name'];

            if ($upload_image) {
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_size'] = '2048';
                $config['upload_path'] = './assets/img/profile';

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('image')) {
                    $old_image = $data['siswa']['gambar'];
                    if ($old_image != 'default.jpg') {
                        unlink(FCPATH . 'assets/img/profile/' . $old_image);
                    }

                    $new_image = $this->upload->data('file_name');
                    $this->db->set('gambar', $new_image);
                } else {
                    echo $this->upload->display_errors();
                }
            }

            $this->db->set('nama', $name);
            $this->db->set('nis', $nis);
            $this->db->set('jurusan_id', $jurusanId);
            $this->db->set('semester', $semester);
            $this->db->set('kelas_id', $kelasId);
            $this->db->where('email', $email);
            $this->db->update('siswa');

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
			Your profile has been updated!
			</div>');
            redirect('siswa/profile');
        }
    }

    public function mataPelajaran()
    {
        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('user', ['email' => $email])->row_array();
        $data['title'] = 'Mata Pelajaran';
        $data['siswa'] = $this->db->get_where('siswa', ['email' => $data['user']['email']])->row_array();

        //ambil data mata pelajaran
        $data['mapelJurusan'] = $this->db->get_where('mapel', ['jurusan_id' => $data['siswa']['jurusan_id']])->result_array();
        $data['mapelUmum'] = $this->db->get_where('mapel', ['jurusan_id' => 1])->result_array();

        $this->load->view('template/user-header', $data);
        $this->load->view('template/siswa-sidebar');
        $this->load->view('template/user-topbar');
        $this->load->view('siswa/mata-pelajaran');
        $this->load->view('template/user-footer');
    }
    //detail materi pelajaran
    public function materi($guruId, $mapelId)
    {
        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('user', ['email' => $email])->row_array();
        $data['title'] = 'Materi Pembelajaran';
        $data['siswa'] = $this->db->get_where('siswa', ['email' => $data['user']['email']])->row_array();
        $data['guru'] = $this->db->get_where('guru', ['id' => $guruId])->row_array();
        $data['mapel'] = $this->db->get_where('mapel', ['id' => $mapelId])->row_array();
        $data['setPresensi'] = $this->db->get_where('set_presensi', ['guru_id' => $guruId, 'kelas_id' => $data['siswa']['kelas_id'], 'is_active' => 1])->row_array();

        $this->db->order_by('id', 'DESC');
        $data['materiKelas'] = $this->db->get_where('kelas_access_materi', ['kelas_id' => $data['siswa']['kelas_id'], 'guru_id' => $guruId])->result_array();

        $this->load->view('template/user-header', $data);
        $this->load->view('template/siswa-sidebar');
        $this->load->view('template/user-topbar');
        $this->load->view('siswa/materi');
        $this->load->view('template/user-footer', $data);
    }
    //presensi siswa
    public function presensiSiswa($kelasId, $guruId, $presensiId)
    {
        $mapel = $this->db->get_where('guru', ['id' => $guruId])->row_array();

        $this->form_validation->set_rules('nis', 'NIS', 'required|trim');
        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');

        if ($this->form_validation->run() == false) {
            $this->session->set_tempdata('pesan', '<div class="alert alert-danger" role="alert">Gagal melakukan presensi, teliti kembali memasukkan nis, nama, dan nim</div>');
            redirect('siswa/materi/' . $guruId . '/' . $mapel['mapel_id']);
        } else {
            $siswaId = $this->input->post('id');
            $nis = $this->input->post('nis');
            $nama = $this->input->post('nama');
            $email = $this->input->post('email');
            $result = $this->db->get_where('siswa', ['id' => $siswaId])->row_array();

            if ($result['nis'] == $nis && $result['nama'] == $nama && $result['email'] == $email) {
                $this->db->insert('presensi_siswa', [
                    'kelas_id' => htmlspecialchars($kelasId),
                    'guru_id' => htmlspecialchars($guruId),
                    'presensi_id' => htmlspecialchars($presensiId),
                    'siswa_id' => htmlspecialchars($siswaId),
                ]);
                $this->session->set_tempdata('pesan', '<div class="alert alert-success" role="alert">Berhasil melakukan presensi</div>');
                redirect('siswa/materi/' . $guruId . '/' . $mapel['mapel_id']);
            } else {
                $this->session->set_tempdata('pesan', '<div class="alert alert-danger" role="alert">Gagal melakukan presensi, NIS/Nama/Email yang kamu masukkan salah</div>');
                redirect('siswa/materi/' . $guruId . '/' . $mapel['mapel_id']);
            }
        }
    }



    public function tugas()
    {
        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('user', ['email' => $email])->row_array();
        $data['title'] = 'Tugas';
        $data['siswa'] = $this->db->get_where('siswa', ['email' => $data['user']['email']])->row_array();
        $this->db->order_by('id', 'DESC');
        $data['tugasKelas'] = $this->db->get_where('tugas_kelas', ['kelas_id' => $data['siswa']['kelas_id']])->result_array();


        $this->load->view('template/user-header', $data);
        $this->load->view('template/siswa-sidebar');
        $this->load->view('template/user-topbar', $data);
        $this->load->view('siswa/tugas');
        $this->load->view('template/user-footer');
    }

    public function soal($id)
    {
        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('user', ['email' => $email])->row_array();
        $data['title'] = 'Soal';
        $data['siswa'] = $this->db->get_where('siswa', ['email' => $data['user']['email']])->row_array();
        $data['tugas'] = $this->db->get_where('tugas', ['id' => $id])->row_array();

        //cek tipe soal
        if ($data['tugas']['tipe'] == 'objectiv') {
            $data['soal'] = $this->db->get_where('soal_objectiv', ['tugas_id' => $id])->result_array();
        } else {
            $data['soal'] = $this->db->get_where('soal_essay', ['tugas_id' => $id])->result_array();
        }

        //cek apakah sudah mengerjakan tugas
        $cekJawaban = $this->db->get_where('tugas_jawaban_siswa', ['siswa_id' => $data['siswa']['id'], 'tugas_id' => $data['tugas']['id']])->num_rows();
        if ($cekJawaban > 0) {
            redirect('siswa/result/' . $id);
        }

        $jumlahSoal = $this->db->get_where('soal_objectiv', ['tugas_id' => $id])->num_rows();
        for ($i = 1; $i <= $jumlahSoal; $i++) {
            $this->form_validation->set_rules('jawaban-' . $i, 'Jawaban', 'required');
        }


        if ($this->form_validation->run() == false) {
            $this->load->view('template/user-header', $data);
            $this->load->view('template/siswa-sidebar');
            $this->load->view('template/user-topbar');
            $this->load->view('siswa/soal');
            $this->load->view('template/user-footer');
        } else {
            $j = 1;
            foreach ($data['soal'] as $s) {
                $jawaban = $this->input->post('jawaban-' . $j);

                //input jawaban
                $this->db->insert('tugas_jawaban_siswa', [
                    'siswa_id' => $data['siswa']['id'],
                    'tugas_id' => $s['tugas_id'],
                    'soal_id' => $s['id'],
                    'soal_tipe' => $data['tugas']['tipe'],
                    'jawaban' => htmlspecialchars($jawaban)
                ]);

                $j++;
            }

            $this->session->set_tempdata('pesan', '<div class="alert alert-success" role="alert">Berhasil submit soal</div>');
            redirect('siswa/result/' . $id);
        }
    }

    public function result($id)
    {
        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('user', ['email' => $email])->row_array();
        $data['title'] = 'Result';
        $data['siswa'] = $this->db->get_where('siswa', ['email' => $data['user']['email']])->row_array();
        $data['tugas'] = $this->db->get_where('tugas', ['id' => $id])->row_array();
        $data['jawaban'] = $this->db->get_where('tugas_jawaban_siswa', ['siswa_id' => $data['siswa']['id'], 'tugas_id' => $data['tugas']['id']])->result_array();

        $totalNilai = 0;
        foreach ($data['jawaban'] as $j) {
            $soal = $this->db->get_where('soal_objectiv', ['id' => $j['soal_id']])->row_array();
            if ($j['jawaban'] == $soal['kunci_jawaban']) {
                $nilai = $soal['bobot_nilai'];
            } else {
                $nilai = 0;
            }
            $totalNilai += $nilai;
        }
        $data['nilai'] = $totalNilai;

        //insert nilai siswa
        $this->db->insert('tugas_nilai_siswa', [
            'siswa_id' => $data['siswa']['id'],
            'kelas_id' => $data['siswa']['kelas_id'],
            'guru_id' => $data['tugas']['guru_id'],
            'tugas_id' => htmlspecialchars($id),
            'nilai' => $totalNilai
        ]);


        $this->load->view('template/user-header', $data);
        $this->load->view('template/siswa-sidebar');
        $this->load->view('template/user-topbar');
        $this->load->view('siswa/result');
        $this->load->view('template/user-footer');
    }

    public function resultDetail($id)
    {
        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('user', ['email' => $email])->row_array();
        $data['title'] = 'Result detail';
        $data['siswa'] = $this->db->get_where('siswa', ['email' => $data['user']['email']])->row_array();
        $data['tugas'] = $this->db->get_where('tugas', ['id' => $id])->row_array();

        //cek tipe soal
        if ($data['tugas']['tipe'] == 'objectiv') {
            $data['soal'] = $this->db->get_where('soal_objectiv', ['tugas_id' => $id])->result_array();
        } else {
            $data['soal'] = $this->db->get_where('soal_essay', ['tugas_id' => $id])->result_array();
        }

        $this->load->view('template/user-header', $data);
        $this->load->view('template/siswa-sidebar');
        $this->load->view('template/user-topbar');
        $this->load->view('siswa/result-detail');
        $this->load->view('template/user-footer');
    }

    public function jadwal()
    {
        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('user', ['email' => $email])->row_array();
        $data['title'] = 'Jadwal Pelajaran';
        $data['siswa'] = $this->db->get_where('siswa', ['email' => $data['user']['email']])->row_array();
        $data['kelas'] = $this->db->get_where('kelas', ['id' => $data['siswa']['kelas_id']])->row_array();
        $data['jadwalKelas'] = $this->db->get_where('jadwal_kelas', ['kelas_id' => $data['siswa']['kelas_id']])->result_array();

        $this->load->view('template/user-header', $data);
        $this->load->view('template/siswa-sidebar');
        $this->load->view('template/user-topbar');
        $this->load->view('siswa/jadwal');
        $this->load->view('template/user-footer');
    }
    public function ubahPassword()
    {
        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('user', ['email' => $email])->row_array();
        $data['title'] = 'Ubah Password';
        $data['siswa'] = $this->db->get_where('siswa', ['email' => $data['user']['email']])->row_array();

        $this->form_validation->set_rules('current_password', 'Current Password', 'required|trim');
        $this->form_validation->set_rules('new_password1', 'New Password1', 'required|trim|min_length[6]|matches[new_password2]');
        $this->form_validation->set_rules('new_password2', 'New Password2', 'required|trim|matches[new_password1]');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/user-header', $data);
            $this->load->view('template/siswa-sidebar');
            $this->load->view('template/user-topbar', $data);
            $this->load->view('siswa/ubah-password');
            $this->load->view('template/user-footer');
        } else {
            $password = $this->input->post('current_password');
            $newPassword1 = $this->input->post('new_password1');

            $this->password->changePassword($email, $data['user']['password'], $password, $newPassword1);
        }
    }
}
