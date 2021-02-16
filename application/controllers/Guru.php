<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Guru extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Password_model', 'password');
        $this->load->model('Guru_model', 'guru');

        date_default_timezone_set("Asia/Jakarta");

        is_logged_in();
    }
    public function index()
    {
        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('user', ['email' => $email])->row_array();
        $data['title'] = 'Home';
        $data['guru'] = $this->db->get_where('guru', ['email' => $data['user']['email']])->row_array();
        $data['kelas'] = $this->db->get_where('guru_access_kelas', ['guru_id' => $data['guru']['id']])->result_array();
        $data['pengumuman'] = $this->db->get_where('pengumuman', ['is_active' => 1])->result_array();

        $this->load->view('template/user-header', $data);
        $this->load->view('template/guru-sidebar');
        $this->load->view('template/user-topbar', $data);
        $this->load->view('guru/index');
        $this->load->view('template/user-footer');
    }
    public function profile()
    {
        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('user', ['email' => $email])->row_array();
        $data['title'] = 'Profile';
        $data['guru'] = $this->db->get_where('guru', ['email' => $data['user']['email']])->row_array();

        $this->load->view('template/user-header', $data);
        $this->load->view('template/guru-sidebar');
        $this->load->view('template/user-topbar');
        $this->load->view('guru/profile');
        $this->load->view('template/user-footer');
    }

    public function editprofile()
    {
        $data['title'] = 'Edit Profile';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['guru'] = $this->db->get_where('guru', ['email' => $data['user']['email']])->row_array();
        $data['mapel'] = $this->db->get('mapel')->result_array();

        $this->form_validation->set_rules('name', 'Full Name', 'required|trim');
        $this->form_validation->set_rules('nip', 'NIP', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/user-header', $data);
            $this->load->view('template/guru-sidebar');
            $this->load->view('template/user-topbar');
            $this->load->view('guru/edit-profile');
            $this->load->view('template/user-footer');
        } else {
            $name = $this->input->post('name');
            $email = $this->input->post('email');
            $nip = $this->input->post('nip');
            $mapelId = $this->input->post('mapelId');

            //cek gambar
            $upload_image = $_FILES['image']['name'];

            if ($upload_image) {
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_size'] = '2048';
                $config['upload_path'] = './assets/img/profile';

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('image')) {
                    $old_image = $data['guru']['gambar'];
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
            $this->db->set('nip', $nip);
            $this->db->set('mapel_id', $mapelId);
            $this->db->where('email', $email);
            $this->db->update('guru');

            $this->session->set_tempdata('pesan', '<div class="alert alert-success" role="alert">Berhasil mengubah profile!</div>', 10);
            redirect('guru/profile');
        }
    }

    //materi
    public function materi()
    {
        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('user', ['email' => $email])->row_array();
        $data['title'] = 'Materi';
        $data['guru'] = $this->db->get_where('guru', ['email' => $data['user']['email']])->row_array();
        $data['materi'] = $this->db->get_where('materi', ['guru_id' => $data['guru']['id']])->result_array();
        $data['video'] = $this->db->get_where('video_pembelajaran', ['guru_id' => $data['guru']['id']])->result_array();

        $this->form_validation->set_rules('pertemuan', 'Pertemuan', 'required|trim');
        $this->form_validation->set_rules('judul', 'Judul', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/user-header', $data);
            $this->load->view('template/guru-sidebar');
            $this->load->view('template/user-topbar');
            $this->load->view('guru/materi');
            $this->load->view('template/user-footer');
        } else {
            $id = $this->input->post('id');
            $pertemuan = $this->input->post('pertemuan');
            $judul = $this->input->post('judul');
            $result = $this->db->get_where('materi', ['id' => $id])->row_array();
            $cekPertemuan = $this->db->get_where('materi', ['guru_id' => $data['guru']['id'], 'pertemuan' => $pertemuan])->row_array();
            $new_file = $result['file'];

            //cek file
            $upload_file = $_FILES['file']['name'];

            if ($upload_file) {
                $config['allowed_types'] = 'pdf|ppt|doc';
                $config['max_size'] = '2048';
                $config['upload_path'] = './assets/file';

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('file')) {
                    $old_file = $data['materi']['file'];
                    if ($old_file != 'default.pdf') {
                        unlink(FCPATH . 'assets/file/' . $old_file);
                    }

                    $new_file = $this->upload->data('file_name');
                } else {
                    echo $this->upload->display_errors();
                }
            }

            if ($result) {
                if ($cekPertemuan['id'] == $id || $cekPertemuan['id'] == 0) {
                    $this->guru->editMateri($id, $pertemuan, $judul, $new_file);
                } else {
                    $this->session->set_tempdata('pesan', '<div class="alert alert-danger" role="alert">Gagal mengedit materi, pertemuan sudah ada!</div>');
                    redirect('guru/materi');
                }
            } else {
                if ($cekPertemuan) {
                    $this->session->set_tempdata('pesan', '<div class="alert alert-danger" role="alert">Gagal menambah materi, sudah ada pertemuan sebelumya!</div>');
                    redirect('guru/materi');
                } else {
                    $this->guru->tambahMateri($data['guru']['id'], $pertemuan, $judul, $new_file);
                }
            }
        }
    }

    //edit materi
    public function editMateri()
    {
        echo json_encode($this->getMateri($_POST['id']));
    }
    //ambil data materi
    public function getMateri($id)
    {
        $result = $this->db->get_where('materi', ['id' => $id])->row_array();
        return $result;
    }
    //hapus materi
    public function hapusMateri($id)
    {
        $this->db->delete('materi', ['id' => $id]);

        $this->session->set_tempdata('pesan', '<div class="alert alert-success" role="alert">Berhasil menghapus materi materi!</div>');
        redirect('guru/materi');
    }

    //tambah video
    public function tambahVideo($guruId)
    {
        $this->form_validation->set_rules('judulVideo', 'Judul', 'required');
        $this->form_validation->set_rules('link', 'Link', 'required');

        if ($this->form_validation->run() == false) {
            $this->session->set_tempdata('pesan', '<div class="alert alert-danger" role="alert">Gagal menambah video!</div>');
            redirect('guru/materi');
        } else {
            $videoId = $this->input->post('videoId');
            $judul = $this->input->post('judulVideo');
            $link = $this->input->post('link');
            $result = $this->db->get_where('video_pembelajaran', ['id' => $videoId]);
            $cekJudul = $this->db->get_where('video_pembelajaran', ['judul' => $judul])->row_array();
            $cekLink = $this->db->get_where('video_pembelajaran', ['link' => $link])->row_array();

            if ($result->num_rows() > 0) {
                //cek judul
                if ($cekJudul['id'] == $videoId || $cekJudul['id'] == 0) {
                    //cek link
                    if ($cekLink['id'] == $videoId || $cekLink['id'] == 0) {
                        $this->db->set([
                            'judul' => $judul,
                            'link' => $link
                        ]);
                        $this->db->where('id', $videoId);
                        $this->db->update('video_pembelajaran');

                        $this->session->set_tempdata('pesan', '<div class="alert alert-success" role="alert">Berhasil mengedit video!</div>');
                        redirect('guru/materi');
                    } else {
                        $this->session->set_tempdata('pesan', '<div class="alert alert-danger" role="alert">Gagal mengedit video, Link video sudah ada!</div>');
                        redirect('guru/materi');
                    }
                } else {
                    $this->session->set_tempdata('pesan', '<div class="alert alert-danger" role="alert">Gagal mengedit video, judul sudah ada!</div>');
                    redirect('guru/materi');
                }
            } else {
                $cekGuru = $this->db->get_where('guru', ['id' => $guruId])->row_array();
                if ($cekGuru) {
                    //cek judul
                    if ($cekJudul == false) {
                        //cek link
                        if ($cekLink == false) {
                            $this->db->insert('video_pembelajaran', [
                                'guru_id' => htmlspecialchars($guruId),
                                'judul' => htmlspecialchars($judul),
                                'link' => htmlspecialchars($link)
                            ]);

                            $this->session->set_tempdata('pesan', '<div class="alert alert-success" role="alert">Berhasil menambah video!</div>');
                            redirect('guru/materi');
                        } else {
                            $this->session->set_tempdata('pesan', '<div class="alert alert-danger" role="alert">Gagal menambah video, Link video sudah ada!</div>');
                            redirect('guru/materi');
                        }
                    } else {
                        $this->session->set_tempdata('pesan', '<div class="alert alert-danger" role="alert">Gagal menambah video, judul video sudah ada!</div>');
                        redirect('guru/materi');
                    }
                } else {
                    $this->session->set_tempdata('pesan', '<div class="alert alert-danger" role="alert">Gagal menambah video!</div>');
                    redirect('guru/materi');
                }
            }
        }
    }
    //hapus video
    public function hapusVideo($videoId)
    {
        $this->db->delete('video_pembelajaran', ['id' => $videoId]);
        $this->session->set_tempdata('pesan', '<div class="alert alert-success" role="alert">Berhasil menghapus video!</div>');
        redirect('guru/materi');
    }
    //edit video
    public function editVideo()
    {
        echo json_encode($this->getVideo($_POST['id']));
    }
    public function getVideo($id)
    {
        $result = $this->db->get_where('video_pembelajaran', ['id' => $id])->row_array();
        return $result;
    }

    //kelas
    public function kelas()
    {
        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('user', ['email' => $email])->row_array();
        $data['title'] = 'Kelas';
        $data['guru'] = $this->db->get_where('guru', ['email' => $data['user']['email']])->row_array();

        $this->load->view('template/user-header', $data);
        $this->load->view('template/guru-sidebar');
        $this->load->view('template/user-topbar');
        $this->load->view('guru/kelas');
        $this->load->view('template/user-footer');
    }

    public function detailKelas($id)
    {
        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('user', ['email' => $email])->row_array();
        $data['title'] = 'Detail Kelas';
        $data['guru'] = $this->db->get_where('guru', ['email' => $data['user']['email']])->row_array();
        $data['kelas'] = $this->db->get_where('kelas', ['id' => $id])->row_array();
        $data['siswa'] = $this->db->get_where('siswa', ['kelas_id' => $id])->result_array();
        $data['jmlSiswa'] = $this->db->get_where('siswa', ['kelas_id' => $id])->num_rows();
        $data['materiKelas'] = $this->db->get_where('kelas_access_materi', ['kelas_id' => $id, 'guru_id' => $data['guru']['id']])->result_array();
        $data['materi'] = $this->db->get_where('materi', ['guru_id' => $data['guru']['id']])->result_array();
        $data['presensi'] = $this->db->get_where('set_presensi', ['guru_id' => $data['guru']['id'], 'kelas_id' => $id])->result_array();
        $data['setPresensi'] = $this->db->get_where('set_presensi', ['guru_id' => $data['guru']['id'], 'kelas_id' => $id, 'is_active' => 1])->row_array();

        $guruId = $data['guru']['id'];
        $queryTugas = "
        SELECT *
        FROM `tugas_kelas` JOIN `kelas_access_materi`
        ON `tugas_kelas`.`materi_kelas_id` = `kelas_access_materi`.`id`
        WHERE `kelas_access_materi`.`guru_id` = $guruId AND `kelas_access_materi`.`kelas_id` = $id
        ";

        $data['tugasKelas'] = $this->db->query($queryTugas)->result_array();

        $this->load->view('template/user-header', $data);
        $this->load->view('template/guru-sidebar');
        $this->load->view('template/user-topbar');
        $this->load->view('guru/detail-kelas');
        $this->load->view('template/user-footer');
    }
    //tambah materi kelas
    public function tambahMateriKelas($guruId, $kelasId)
    {
        $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'required|trim');
        $this->form_validation->set_rules('pertemuan', 'Pertemuan', 'required');
        if ($this->form_validation->run() == false) {
            $this->session->set_tempdata('pesan', '<div class="alert alert-danger" role="alert">Gagal menambahkan materi</div>');
            redirect('guru/detailkelas/' . $kelasId);
        } else {
            $materiId = $this->input->post('pertemuan');
            $deskripsi = $this->input->post('deskripsi');
            $this->guru->tambahMateriKelas($guruId, $kelasId, $materiId, $deskripsi);
        }
    }
    //hapus materi kelas
    public function hapusMateriKelas($kelasId, $id)
    {
        $this->db->delete('kelas_access_materi', ['id' => $id]);
        $this->session->set_tempdata('pesan', '<div class="alert alert-success" role="alert">Berhasil menghapus materi materi!</div>');
        redirect('guru/detailkelas/' . $kelasId);
    }
    //detail kelas materi
    public function detailKelasMateri($id)
    {
        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('user', ['email' => $email])->row_array();
        $data['guru'] = $this->db->get_where('guru', ['email' => $data['user']['email']])->row_array();
        $data['title'] = 'Materi Pembelajaran';
        $data['materiKelas'] = $this->db->get_where('kelas_access_materi', ['id' => $id])->row_array();
        $data['kelas'] = $this->db->get_where('kelas', ['id' => $data['materiKelas']['kelas_id']])->row_array();
        $data['tugas'] = $this->db->get_where('tugas', ['guru_id' => $data['guru']['id']])->result_array();

        $this->form_validation->set_rules('tugas', 'Tugas', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/user-header', $data);
            $this->load->view('template/guru-sidebar');
            $this->load->view('template/user-topbar');
            $this->load->view('guru/detail-kelas-materi');
            $this->load->view('template/user-footer');
        } else {
            $tugasId = $this->input->post('tugas');
            $this->db->insert('tugas_kelas', [
                'kelas_id' => $data['kelas']['id'],
                'materi_kelas_id' => $data['materiKelas']['id'],
                'tugas_id' => $tugasId,
                'date_post' => time(),
                'deadline' => time()
            ]);

            $this->session->set_tempdata('pesan', '<div class="alert alert-success" role="alert">Berhasil menambahkan tugas!</div>');
            redirect('guru/detailkelasmateri/' . $data['materiKelas']['id']);
        }
    }
    //detai tugas kelas
    public function detailTugasKelas($kelasId, $id)
    {
        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('user', ['email' => $email])->row_array();
        $data['guru'] = $this->db->get_where('guru', ['email' => $data['user']['email']])->row_array();
        $data['title'] = 'Daftar nilai tugas ke-';
        $data['kelas'] = $this->db->get_where('kelas', ['id' => $kelasId])->row_array();
        $data['tugas'] = $this->db->get_where('tugas', ['id' => $id])->row_array();
        $data['tugasNilaiSiswa'] = $this->db->get_where('tugas_nilai_siswa', ['kelas_id' => $kelasId, 'guru_id' => $data['guru']['id'], 'tugas_id' => $id])->result_array();

        $this->load->view('template/user-header', $data);
        $this->load->view('template/guru-sidebar');
        $this->load->view('template/user-topbar');
        $this->load->view('guru/detail-tugas-kelas');
        $this->load->view('template/user-footer');
    }
    //edit tugas kelas
    public function editTugasKelas()
    {
        echo json_encode($this->getTugasKelas($_POST['id']));
    }
    public function getTugasKelas($id)
    {
        $result = $this->db->get_where('tugas_kelas', ['id' => $id])->row_array();
        return $result;
    }
    //hapus tugas kelas
    public function hapusTugasKelas($materiKelasId, $id)
    {
        $this->db->delete('tugas_kelas', ['id' => $id]);

        $this->session->set_tempdata('pesan', '<div class="alert alert-success" role="alert">Berhasil menghapus tugas!</div>');
        redirect('guru/detailkelasmateri/' . $materiKelasId);
    }


    //set Presensi
    public function setPresensi($guruId, $kelasId)
    {

        $this->form_validation->set_rules('pertemuanPresensi', 'Pertemuan', 'required');
        $this->form_validation->set_rules('jamMulai', 'Jam Mulai', 'required');
        $this->form_validation->set_rules('menitMulai', 'Menit Mulai', 'required');
        $this->form_validation->set_rules('jamBerakhir', 'Jam Berakhir', 'required');
        $this->form_validation->set_rules('menitBerakhir', 'Menit Berakhir', 'required');

        if ($this->form_validation->run() == false) {
            redirect('guru/detailkelas/' . $kelasId);
        } else {
            $id = $this->input->post('idPresensi');
            $pertemuan = $this->input->post('pertemuanPresensi');
            $jamMulai = $this->input->post('jamMulai');
            $menitMulai = $this->input->post('menitMulai');
            $detikMulai = $this->input->post('detikMulai');
            $jamBerakhir = $this->input->post('jamBerakhir');
            $menitBerakhir = $this->input->post('menitBerakhir');
            $detikBerakhir = $this->input->post('detikBerakhir');

            $waktuMulai = strtotime($jamMulai . ':' . $menitMulai . ':' . $detikMulai);
            $waktuBerakhir = strtotime($jamBerakhir . ':' . $menitBerakhir . ':' . $detikBerakhir);

            //cek id
            $result = $this->db->get_where('set_presensi', ['id' => $id]);
            //cek pertemuan
            $cekPertemuan = $this->db->get_where('set_presensi', ['guru_id' => $guruId, 'kelas_id' => $kelasId, 'pertemuan' => $pertemuan])->row_array();

            if ($result->num_rows() > 0) {
                if ($cekPertemuan['id'] == $id || $cekPertemuan['id'] == 0) {
                    //edit presensi
                    $this->db->set([
                        'pertemuan' => htmlspecialchars($pertemuan),
                        'tanggal' => time(),
                        'waktu_mulai' => $waktuMulai,
                        'waktu_berakhir' => $waktuBerakhir,
                    ]);
                    $this->db->where('id', $id);
                    $this->db->update('set_presensi');

                    $this->session->set_tempdata('pesan', '<div class="alert alert-success" role="alert">berhasil mengedit presensi!</div>');
                    redirect('guru/detailkelas/' . $kelasId);
                } else {
                    $this->session->set_tempdata('pesan', '<div class="alert alert-danger" role="alert">Gagal mengedit presensi, pertemuan yang dimasukkan sudah ada!</div>');
                    redirect('guru/detailkelas/' . $kelasId);
                }
            } else {
                if ($cekPertemuan) {
                    $this->session->set_tempdata('pesan', '<div class="alert alert-danger" role="alert">Gagal menambahkan presensi, pertemuan yang dimasukkan sudah ada!</div>');
                    redirect('guru/detailkelas/' . $kelasId);
                } else {
                    //insert presensi
                    $this->db->insert('set_presensi', [
                        'guru_id' => $guruId,
                        'kelas_id' => $kelasId,
                        'pertemuan' => htmlspecialchars($pertemuan),
                        'tanggal' => time(),
                        'waktu_mulai' => $waktuMulai,
                        'waktu_berakhir' => $waktuBerakhir,
                        'is_active' => 1

                    ]);

                    $this->session->set_tempdata('pesan', '<div class="alert alert-success" role="alert">Berhasil mengatur presensi!</div>');
                    redirect('guru/detailkelas/' . $kelasId);
                }
            }
        }
    }
    //hapus presensi
    public function hapusPresensi($kelasId, $id)
    {
        $this->db->delete('set_presensi', ['id' => $id]);
        $this->db->delete('presensi_siswa', ['presensi_id' => $id]);

        $this->session->set_tempdata('pesan', '<div class="alert alert-success" role="alert">Berhasil menghapus presensi!</div>');
        redirect('guru/detailkelas/' . $kelasId);
    }
    //off presensi
    public function offPresensi()
    {
        $this->db->set([
            'is_active' => 0
        ]);
        $this->db->where('id', $_POST['id']);
        $this->db->get('set_presensi');
    }
    //edit presensi
    public function editPresensi()
    {
        echo json_encode($this->getPresensi($_POST['id']));
    }
    public function getPresensi($id)
    {
        $data = $this->db->get_where('set_presensi', ['id' => $id])->row_array();
        $result = [
            'id' => $data['id'],
            'pertemuan' => $data['pertemuan'],
            'jam_mulai' => date('H', $data['waktu_mulai']),
            'menit_mulai' => date('i', $data['waktu_mulai']),
            'detik_mulai' => date('s', $data['waktu_mulai']),
            'jam_berakhir' => date('H', $data['waktu_berakhir']),
            'menit_berakhir' => date('i', $data['waktu_berakhir']),
            'detik_berakhir' => date('s', $data['waktu_berakhir']),
        ];

        return $result;
    }

    //detail presensi
    public function detailPresensi($kelasId, $presensiId)
    {
        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('user', ['email' => $email])->row_array();
        $data['title'] = 'Daftar Hadir Kelas';
        $data['guru'] = $this->db->get_where('guru', ['email' => $data['user']['email']])->row_array();
        $data['kelas'] = $this->db->get_where('kelas', ['id' => $kelasId])->row_array();
        $data['presensi'] = $this->db->get_where('set_presensi', ['id' => $presensiId])->row_array();
        $data['siswa'] = $this->db->get_where('siswa', ['kelas_id' => $kelasId])->result_array();
        $data['presensiSiswa'] = $this->db->get_where('presensi_siswa', ['kelas_id' => $kelasId, 'guru_id' => $data['guru']['id'], 'presensi_id' => $presensiId])->result_array();

        $this->load->view('template/user-header', $data);
        $this->load->view('template/guru-sidebar');
        $this->load->view('template/user-topbar');
        $this->load->view('guru/detail-presensi');
        $this->load->view('template/user-footer');
    }


    public function tugas()
    {
        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('user', ['email' => $email])->row_array();
        $data['title'] = 'Tugas';
        $data['guru'] = $this->db->get_where('guru', ['email' => $data['user']['email']])->row_array();
        $data['tugas'] = $this->db->get_where('tugas', ['guru_id' => $data['guru']['id']])->result_array();

        $this->form_validation->set_rules('tugas', 'Tugas', 'required|trim');
        $this->form_validation->set_rules('materi', 'Materi', 'required|trim');
        $this->form_validation->set_rules('jumlah', 'Jumlah', 'required|trim');
        $this->form_validation->set_rules('tipe', 'Tipe', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/user-header', $data);
            $this->load->view('template/guru-sidebar');
            $this->load->view('template/user-topbar');
            $this->load->view('guru/tugas');
            $this->load->view('template/user-footer');
        } else {
            $id = $this->input->post('id');
            $tugas = $this->input->post('tugas');
            $materi = $this->input->post('materi');
            $jumlah = $this->input->post('jumlah');
            $tipe = $this->input->post('tipe');
            $cekTugas = $this->db->get_where('tugas', ['guru_id' => $data['guru']['id'], 'tugas' => $tugas])->row_array();
            $result = $this->db->get_where('tugas', ['id' => $id])->row_array();

            //cek id
            if ($result) {
                if ($cekTugas['id'] == $id || $cekTugas['id'] == 0) {
                    $this->db->set([
                        'tugas' => htmlspecialchars($tugas),
                        'materi' => htmlspecialchars($materi),
                        'tipe' => htmlspecialchars($tipe),
                        'jumlah' => htmlspecialchars($jumlah)
                    ]);
                    $this->db->where('id', $id);
                    $this->db->update('tugas');

                    $this->session->set_tempdata('pesan', '<div class="alert alert-success" role="alert">Berhasil mengedit tugas</div>');
                    redirect('guru/tugas');
                } else {
                    $this->session->set_tempdata('pesan', '<div class="alert alert-danger" role="alert">Gagal edit tugas, tugas sudah ada !</div>');
                    redirect('guru/tugas');
                }
            } else {
                if ($cekTugas) {
                    $this->session->set_tempdata('pesan', '<div class="alert alert-danger" role="alert">Gagal menambah tugas, tugas sudah ada !</div>');
                    redirect('guru/tugas');
                } else {
                    $this->db->insert('tugas', [
                        'guru_id' => $data['guru']['id'],
                        'tugas' => htmlspecialchars($tugas),
                        'materi' => htmlspecialchars($materi),
                        'tipe' => htmlspecialchars($tipe),
                        'jumlah' => htmlspecialchars($jumlah)
                    ]);
                    $this->session->set_tempdata('pesan', '<div class="alert alert-success" role="alert">Berhasil menambahkan tugas, klik buat soal untuk membuat soal!</div>');
                    redirect('guru/tugas');
                }
            }
        }
    }
    //edit tugas
    public function editTugas()
    {
        echo json_encode($this->getTugas($_POST['id']));
    }
    public function getTugas($id)
    {
        return $this->db->get_where('tugas', ['id' => $id])->row_array();
    }
    //hapus tugas
    public function hapusTugas($id)
    {
        $tugas = $this->db->get_where('tugas', ['id' => $id])->row_array();
        //hapus tabel tugas
        $this->db->delete('tugas', ['id' => $id]);
        //hapus tugas kelas
        $this->db->delete('tugas_kelas', ['tugas_id' => $id]);
        //hapus jawaban siswa
        $this->db->delete('tugas_jawaban_siswa', ['tugas_id' => $id]);
        //hapus nilai siswa
        $this->db->delete('tugas_nilai_siswa', ['tugas_id' => $id]);



        //hapus soal
        if ($tugas['tipe'] == 'objectiv') {
            $this->db->delete('soal_objectiv', ['tugas_id' => $id]);
        } else {
            $this->db->delete('soal_essay', ['tugas_id' => $id]);
        }
        $this->session->set_tempdata('pesan', '<div class="alert alert-success" role="alert">Berhasil menghapus tugas</div>');
        redirect('guru/tugas');
    }

    //buat soal
    public function buatSoal($id, $tipe)
    {
        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('user', ['email' => $email])->row_array();
        $data['title'] = 'Buat Soal';
        $data['guru'] = $this->db->get_where('guru', ['email' => $data['user']['email']])->row_array();
        $data['tugas'] = $this->db->get_where('tugas', ['id' => $id])->row_array();

        if ($tipe == 'objectiv') {

            for ($i = 1; $i <= $data['tugas']['jumlah']; $i++) {
                $this->form_validation->set_rules('pertanyaan-' . $i, 'Pertanyaan-' . $i, 'required|trim');
                $this->form_validation->set_rules('pilihan-A-' . $i, 'Pilihan-A-' . $i, 'required|trim');
                $this->form_validation->set_rules('pilihan-B-' . $i, 'Pilihan-B-' . $i, 'required|trim');
                $this->form_validation->set_rules('pilihan-C-' . $i, 'Pilihan-C-' . $i, 'required|trim');
                $this->form_validation->set_rules('pilihan-D-' . $i, 'Pilihan-D-' . $i, 'required|trim');
                $this->form_validation->set_rules('pilihan-E-' . $i, 'Pilihan-E-' . $i, 'required|trim');
            }
            if ($this->form_validation->run() == false) {
                $this->load->view('template/user-header', $data);
                $this->load->view('template/guru-sidebar');
                $this->load->view('template/user-topbar');
                $this->load->view('guru/buat-soal');
                $this->load->view('template/user-footer');
            } else {

                if ($data['tugas']) {
                    for ($i = 1; $i <= $data['tugas']['jumlah']; $i++) {
                        $pertanyaan = $this->input->post('pertanyaan-' . $i);
                        $pilihanA = $this->input->post('pilihan-A-' . $i);
                        $pilihanB = $this->input->post('pilihan-B-' . $i);
                        $pilihanC = $this->input->post('pilihan-C-' . $i);
                        $pilihanD = $this->input->post('pilihan-D-' . $i);
                        $pilihanE = $this->input->post('pilihan-E-' . $i);

                        $this->db->insert('soal_objectiv', [
                            'guru_id' => $data['guru']['id'],
                            'tugas_id' => $id,
                            'pertanyaan' => htmlspecialchars($pertanyaan),
                            'pilihan_a' => htmlspecialchars($pilihanA),
                            'pilihan_b' => htmlspecialchars($pilihanB),
                            'pilihan_c' => htmlspecialchars($pilihanC),
                            'pilihan_d' => htmlspecialchars($pilihanD),
                            'pilihan_e' => htmlspecialchars($pilihanE),
                        ]);
                    }
                    $this->session->set_tempdata('pesan', '<div class="alert alert-success" role="alert">Berhasil membuat soal</div>');
                    redirect('guru/soal/' . $id);
                } else {
                    $this->session->set_tempdata('pesan', '<div class="alert alert-danger" role="alert">Gagal membuat soal, tugas tidak ada</div>');
                    redirect('guru/buatsoal/' . $id . '/' . $tipe);
                }
            }
        } else {
            //loping pertanyaan
            for ($i = 1; $i <= $data['tugas']['jumlah']; $i++) {
                $this->form_validation->set_rules('pertanyaan-' . $i, 'Pertanyaan-' . $i, 'required|trim');
            }

            //jika form validation gagal
            if ($this->form_validation->run() == false) {
                $this->load->view('template/user-header', $data);
                $this->load->view('template/guru-sidebar');
                $this->load->view('template/user-topbar');
                $this->load->view('guru/buat-soal');
                $this->load->view('template/user-footer');
            } else {
                //jika berhasil
                //cek tugas
                if ($data['tugas']) {
                    for ($i = 1; $i <= $data['tugas']['jumlah']; $i++) {
                        $pertanyaan = $this->input->post('pertanyaan-' . $i);

                        $this->db->insert('soal_essay', [
                            'guru_id' => $data['guru']['id'],
                            'tugas_id' => $id,
                            'pertanyaan' => htmlspecialchars($pertanyaan),
                        ]);
                    }
                    $this->session->set_tempdata('pesan', '<div class="alert alert-success" role="alert">Berhasil membuat soal</div>');
                    redirect('guru/soal/' . $id);
                }
            }
        }
    }

    public function soal($id)
    {
        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('user', ['email' => $email])->row_array();
        $data['title'] = 'Soal';
        $data['guru'] = $this->db->get_where('guru', ['email' => $data['user']['email']])->row_array();
        $data['tugas'] = $this->db->get_where('tugas', ['id' => $id])->row_array();
        //cek tipe soal
        if ($data['tugas']['tipe'] == 'objectiv') {
            $data['soal'] = $this->db->get_where('soal_objectiv', ['guru_id' => $data['guru']['id'], 'tugas_id' => $id])->result_array();
        } else {
            $data['soal'] = $this->db->get_where('soal_essay', ['guru_id' => $data['guru']['id'], 'tugas_id' => $id])->result_array();
        }

        $this->form_validation->set_rules('id', 'ID', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/user-header', $data);
            $this->load->view('template/guru-sidebar');
            $this->load->view('template/user-topbar');
            $this->load->view('guru/soal');
            $this->load->view('template/user-footer');
        } else {
            $soalId = $this->input->post('id');
            $pertanyaan = $this->input->post('pertanyaan');
            $result = $this->db->get_where('soal_objectiv', ['id' => $soalId])->row_array();
            $cekPertanyaan = $this->db->get_where('soal_objectiv', ['guru_id' => $data['guru']['id'], 'tugas_id' => $id, 'pertanyaan' => $pertanyaan])->row_array();

            if ($result) {
                if ($cekPertanyaan['pertanyaan'] == $result['pertanyaan'] || $cekPertanyaan['pertanyaan'] == 0) {
                    $this->db->set([
                        'pertanyaan' => htmlspecialchars($this->input->post('pertanyaan')),
                        'pilihan_a' => htmlspecialchars($this->input->post('pilihan-A')),
                        'pilihan_b' => htmlspecialchars($this->input->post('pilihan-B')),
                        'pilihan_c' => htmlspecialchars($this->input->post('pilihan-C')),
                        'pilihan_d' => htmlspecialchars($this->input->post('pilihan-D')),
                        'pilihan_e' => htmlspecialchars($this->input->post('pilihan-E')),
                    ]);
                    $this->db->where('id', $soalId);
                    $this->db->update('soal_objectiv');

                    $this->session->set_tempdata('pesan', '<div class="alert alert-success" role="alert">Berhasil edit soal soal</div>');
                    redirect('guru/soal/' . $id);
                } else {
                    $this->session->set_tempdata('pesan', '<div class="alert alert-danger" role="alert">Gagal edit soal, pertanyaan sudah ada</div>');
                    redirect('guru/soal/' . $id);
                }
            }
        }
    }
    //edit soal
    public function editSoal()
    {
        echo json_encode($this->getSoal($_POST['id'], $_POST['tipe']));
    }
    public function getSoal($id, $tipe)
    {
        if ($tipe == 'objectiv') {
            $result = $this->db->get_where('soal_objectiv', ['id' => $id])->row_array();
        } else {
            $result = $this->db->get_where('soal_essay', ['id' => $id])->row_array();
        }
        return $result;
    }
    //hapus soal
    public function hapusSoal($tugasId, $id)
    {
        $tugas = $this->db->get_where('tugas', ['id' => $tugasId])->row_array();
        //cek tipe dan hapus soal
        if ($tugas['tipe'] == 'objectiv') {
            $this->db->delete('soal_objectiv', ['id' => $id]);
        } else {
            $this->db->delete('soal_essay', ['id' => $id]);
        }

        //edit jumlah soal tugas
        $jumlah = $tugas['jumlah'] - 1;
        $this->db->set('jumlah', $jumlah);
        $this->db->where('id', $tugasId);
        $this->db->update('tugas');

        $this->session->set_tempdata('pesan', '<div class="alert alert-success" role="alert">Berhasil menghapus soal</div>');
        redirect('guru/soal/' . $tugasId);
    }

    //kunci jawaban
    public function kunciJawaban($guruId, $tugasId)
    {
        $soal = $this->db->get_where('soal_objectiv', ['guru_id' => $guruId, 'tugas_id' => $tugasId])->result_array();
        $i = 1;
        foreach ($soal as $s) {
            $id = $this->input->post('idSoal-' . $i);
            $jawaban = $this->input->post('jawabanSoal-' . $i);

            $this->db->set('kunci_jawaban', htmlspecialchars($jawaban));
            $this->db->where('id', $id);
            $this->db->update('soal_objectiv');

            $i++;
        }

        $this->session->set_tempdata('pesan', '<div class="alert alert-success" role="alert">Berhasil menambahkan kunci jawaban</div>');
        redirect('guru/soal/' . $tugasId);
    }
    //bobot nilai
    public function bobotNilai($guruId, $tugasId)
    {
        $soal = $this->db->get_where('soal_objectiv', ['guru_id' => $guruId, 'tugas_id' => $tugasId])->result_array();
        $i = 1;
        foreach ($soal as $s) {
            $id = $this->input->post('idSoal-' . $i);
            $bobotNilai = $this->input->post('bobotNilaiSoal-' . $i);

            $this->db->set('bobot_nilai', htmlspecialchars($bobotNilai));
            $this->db->where('id', $id);
            $this->db->update('soal_objectiv');

            $i++;
        }

        $this->session->set_tempdata('pesan', '<div class="alert alert-success" role="alert">Berhasil menambahkan bobot nilai</div>');
        redirect('guru/soal/' . $tugasId);
    }

    public function jadwal()
    {
        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('user', ['email' => $email])->row_array();
        $data['title'] = 'Jadwal';
        $data['guru'] = $this->db->get_where('guru', ['email' => $data['user']['email']])->row_array();

        $this->load->view('template/user-header', $data);
        $this->load->view('template/guru-sidebar');
        $this->load->view('template/user-topbar', $data);
        $this->load->view('guru/jadwal');
        $this->load->view('template/user-footer');
    }
    public function ubahPassword()
    {
        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('user', ['email' => $email])->row_array();
        $data['title'] = 'Ubah Password';
        $data['guru'] = $this->db->get_where('guru', ['email' => $data['user']['email']])->row_array();

        $this->form_validation->set_rules('current_password', 'Current Password', 'required|trim');
        $this->form_validation->set_rules('new_password1', 'New Password1', 'required|trim|min_length[6]|matches[new_password2]');
        $this->form_validation->set_rules('new_password2', 'New Password2', 'required|trim|matches[new_password1]');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/user-header', $data);
            $this->load->view('template/guru-sidebar');
            $this->load->view('template/user-topbar');
            $this->load->view('guru/ubah-password');
            $this->load->view('template/user-footer');
        } else {
            $password = $this->input->post('current_password');
            $newPassword1 = $this->input->post('new_password1');

            $this->password->changePassword($email, $data['user']['password'], $password, $newPassword1);
        }
    }
}
