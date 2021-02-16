<?php
defined('BASEPATH') or exit('No direct script access allowed');

//load Spout Library
require_once APPPATH . 'third_party/spout/src/Spout/Autoloader/autoload.php';

use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;

class Data extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->library('form_validation');
        $this->load->model('Page_model', 'page');
        $this->load->model('Data_model', 'data');
        $this->load->model('app');
        is_logged_in();
    }

    //daftar siswa
    public function daftarSiswa()
    {
        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('user', ['email' => $email])->row_array();
        $data['title'] = 'Daftar Siswa';
        $data['kelas'] = $this->db->get('kelas')->result_array();
        $data['jurusan'] = $this->db->get('jurusan')->result_array();
        //pagination
        $tabel = 'siswa';
        $url = 'data/daftarsiswa/';
        $dataPerHalaman = 7;
        $from = $this->uri->segment(3);
        $data['siswa'] = $this->page->getPagination($tabel, $url, $dataPerHalaman, $from);


        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim');
        $this->form_validation->set_rules('status', 'Status', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/user-header', $data);
            $this->load->view('template/admin-sidebar');
            $this->load->view('template/user-topbar');
            $this->load->view('data/daftar-siswa');
            $this->load->view('template/user-footer');
        } else {
            $id = $this->input->post('id');
            $nis = $this->input->post('nis');
            $nama = $this->input->post('nama');
            $email = $this->input->post('email');
            $jurusan = $this->input->post('jurusan');
            $semester = $this->input->post('semester');
            $kelas = $this->input->post('kelas');
            $status = $this->input->post('status');
            $password = $this->input->post('password');
            $result = $this->db->get_where('siswa', ['id' => $id])->row_array();

            if ($result) {
                //update tabel siswa
                $this->data->setSiswa($id, $nis, $nama, $email, $jurusan, $semester, $kelas, $status);
                //update user
                $this->data->setUser($email, $status);
                //redirect ke halaman daftar siswa
                $this->session->set_tempdata('pesan', '<div class="alert alert-success" role="alert">Berhasil mengedit siswa</div>');
                redirect('data/daftarsiswa');
            } else {
                //tambah siswa
                $this->data->tambahSiswa($nis, $nama, $email, $jurusan, $semester, $kelas, $status);
                //tambah user
                $this->data->tambahUser($nama, $email, $password, 3, $status);

                $this->session->set_tempdata('pesan', '<div class="alert alert-success" role="alert">Berhasil menambah siswa</div>', 10);
                redirect('data/daftarsiswa');
            }
        }
    }

    //detail siswa
    public function detailSiswa($id)
    {
        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('user', ['email' => $email])->row_array();
        $data['title'] = 'Detail Siswa';
        $data['siswa'] = $this->db->get_where('siswa', ['id' => $id])->row_array();

        $this->load->view('template/user-header', $data);
        $this->load->view('template/admin-sidebar');
        $this->load->view('template/user-topbar');
        $this->load->view('data/detail-siswa');
        $this->load->view('template/user-footer');
    }

    //hapus siswa
    public function hapusSiswa($id)
    {
        $siswa = $this->db->get_where('siswa', ['id' => $id])->row_array();
        $this->data->deleteUser($siswa['email']);
        $this->data->deleteSiswa($id);
        $this->session->set_tempdata('pesan', '<div class="alert alert-success" role="alert">Berhasil menghapus siswa</div>');
        redirect('data/daftarsiswa');
    }
    //edit siswa
    public function editSiswa()
    {
        echo json_encode($this->data->getSiswa($_POST['id']));
    }

    //daftra guru
    public function daftarGuru()
    {
        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('user', ['email' => $email])->row_array();
        $data['title'] = 'Daftar Guru';
        $data['mapel'] = $this->db->get('mapel')->result_array();
        //pagination
        $tabel = 'guru';
        $url = 'data/daftarguru/';
        $dataPerHalaman = 7;
        $from = $this->uri->segment(3);
        $data['guru'] = $this->page->getPagination($tabel, $url, $dataPerHalaman, $from);

        $this->form_validation->set_rules('nip', 'NIP', 'required|trim');
        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim');
        $this->form_validation->set_rules('mapel', 'Mapel', 'required');
        $this->form_validation->set_rules('status', 'Status', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/user-header', $data);
            $this->load->view('template/admin-sidebar');
            $this->load->view('template/user-topbar');
            $this->load->view('data/daftar-guru');
            $this->load->view('template/user-footer');
        } else {
            $id = $this->input->post('id');
            $nip = $this->input->post('nip');
            $nama = $this->input->post('nama');
            $email = $this->input->post('email');
            $mapel = $this->input->post('mapel');
            $status = $this->input->post('status');
            $password = $this->input->post('password');
            $result = $this->db->get_where('guru', ['id' => $id])->row_array();

            if ($result) {
                //update guru
                $this->data->setGuru($id, $nip, $nama, $email, $mapel, $status);
                //update user
                $this->data->setUser($email, $status);

                $this->session->set_tempdata('pesan', '<div class="alert alert-success" role="alert">Berhasil mengedit guru</div>', 10);
                redirect('data/daftarguru');
            } else {
                //tambah guru
                $this->data->tambahGuru($nip, $nama, $email, $mapel, $status);
                //tambah user
                $this->data->tambahUser($nama, $email, $password, 2, $status);

                $this->session->set_tempdata('pesan', '<div class="alert alert-success" role="alert">Berhasil menambah guru</div>', 10);
                redirect('data/daftarguru');
            }
        }
    }
    //detail guru
    public function detailGuru($id)
    {
        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('user', ['email' => $email])->row_array();
        $data['title'] = 'Detail Guru';
        $data['guru'] = $this->data->getGuru($id);
        $data['kelas'] = $this->db->get('kelas')->result_array();
        $data['guru_access_kelas'] = $this->data->getGuruAkses($id);

        $this->form_validation->set_rules('kelas', 'Kelas', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/user-header', $data);
            $this->load->view('template/admin-sidebar');
            $this->load->view('template/user-topbar');
            $this->load->view('data/detail-guru');
            $this->load->view('template/user-footer');
        } else {
            $kelasId = $this->input->post('kelas');
            $this->data->guruAksesKelas($kelasId, $id);
        }
    }
    //hapus hspus guru akses kelas
    public function hapusGuruAccessKelas($guruId, $id)
    {
        $this->data->deleteGuruAkses($id, $guruId);
    }

    //hapus guru
    public function hapusguru($id)
    {
        $this->data->deleteGuru($id);
    }
    //edit guru
    public function editGuru()
    {
        echo json_encode($this->data->getGuru($_POST['id']));
    }


    //daftar jurusan
    public function daftarJurusan()
    {
        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('user', ['email' => $email])->row_array();
        $data['title'] = 'Daftar Jurusan';
        $data['jurusan'] = $this->db->get('jurusan')->result_array();

        $this->form_validation->set_rules('jurusan', 'Jurusan', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/user-header', $data);
            $this->load->view('template/admin-sidebar');
            $this->load->view('template/user-topbar');
            $this->load->view('data/daftar-jurusan');
            $this->load->view('template/user-footer');
        } else {
            $id = $this->input->post('id');
            $jurusan = $this->input->post('jurusan');
            $result = $this->db->get_where('jurusan', ['id' => $id]);
            $title = $this->db->get_where('jurusan', ['jurusan' => $jurusan])->row_array();
            if ($result->num_rows() > 0) {
                if ($title['id'] == $id || $title['id'] == 0) {
                    //edit jurusan
                    $this->data->setJurusan($id, $jurusan);
                } else {
                    $this->session->set_tempdata('pesan', '<div class="alert alert-danger" role="alert"> Edit jurusan gagal!, jurusan sudah ada sudah ada! </div>');
                    redirect('data/daftarjurusan');
                }
            } else {
                if ($title) {
                    $this->session->set_tempdata('pesan', '<div class="alert alert-warning" role="alert"> jurusan yang anda tambahkan sudah ada! </div>');
                    redirect('data/daftarjurusan');
                } else {
                    $this->data->createJururan($jurusan);
                }
            }
        }
    }
    //edit jurusan
    public function editJurusan()
    {
        echo json_encode($this->data->getJurusan($_POST['id']));
    }
    //hapus jurusn
    public function hapusJurusan($id)
    {
        $this->data->deleteJurusan($id);
    }

    //daftar Mata pelajaran
    public function daftarMapel()
    {
        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('user', ['email' => $email])->row_array();
        $data['title'] = 'Daftar Mata Pelajaran';
        $data['jurusan'] = $this->db->get('jurusan')->result_array();
        // $data['mapel'] = $this->db->get('mapel')->result_array();
        //pagination
        $tabel = 'mapel';
        $url = 'data/daftarmapel/';
        $dataPerHalaman = 7;
        $from = $this->uri->segment(3);
        $data['mapel'] = $this->page->getPagination($tabel, $url, $dataPerHalaman, $from);


        $this->form_validation->set_rules('kodeMapel', 'Kode Mapel', 'required|trim');
        $this->form_validation->set_rules('mapel', 'Mapel', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/user-header', $data);
            $this->load->view('template/admin-sidebar');
            $this->load->view('template/user-topbar');
            $this->load->view('data/daftar-mapel');
            $this->load->view('template/user-footer');
        } else {
            $id = $this->input->post('id');
            $kodeMapel = $this->input->post('kodeMapel');
            $mapel = $this->input->post('mapel');
            $jurusanId = $this->input->post('jurusanId');
            $status = $this->input->post('status');

            //cek data mapel
            $result = $this->db->get_where('mapel', ['id' => $id]);
            $title = $this->db->get_where('mapel', ['mapel' => $mapel])->row_array();
            $kode = $this->db->get_where('mapel', ['kode_mapel' => $kodeMapel])->row_array();

            if ($result->num_rows() > 0) {
                //cek nama mapel
                if ($title['id'] == $id || $title['id'] == 0) {

                    //cek kode mapel
                    if ($kode['id'] == $id || $kode['id'] == 0) {
                        //edit tabel mapel
                        $this->data->setMapel($id, $jurusanId, $kodeMapel, $mapel, $status);
                    } else {
                        $this->session->set_tempdata('pesan', '<div class="alert alert-danger" role="alert">Gagal edit, Kode Mapel sudah ada</div>', 10);
                        redirect('data/daftarmapel');
                    }
                } else {
                    $this->session->set_tempdata('pesan', '<div class="alert alert-danger" role="alert">Gagal edit, Mata pelajaran sudah ada</div>', 10);
                    redirect('data/daftarmapel');
                }
            } else {
                if ($title) {
                    $this->session->set_tempdata('pesan', '<div class="alert alert-danger" role="alert">Gagal menambahkan mapel, Mata pelajaran sudah ada</div>', 10);
                    redirect('data/daftarmapel');
                } else if ($kode) {
                    $this->session->set_tempdata('pesan', '<div class="alert alert-danger" role="alert">Gagal menambahkan mapel, Kode Mapel sudah ada</div>', 10);
                    redirect('data/daftarmapel');
                } else {
                    $this->data->createMapel($jurusanId, $kodeMapel, $mapel, $status);
                }
            }
        }
    }
    //edit Mapel
    public function editMapel()
    {
        echo json_encode($this->data->getMapel($_POST['id']));
    }
    //hapus mapel
    public function hapusMapel($mapelId)
    {
        $this->data->deleteMapel($mapelId);
    }


    //daftar kelas
    public function daftarKelas()
    {
        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('user', ['email' => $email])->row_array();
        $data['title'] = 'Daftar Kelas';
        $data['jurusan'] = $this->db->get('jurusan')->result_array();
        //pagination
        $tabel = 'kelas';
        $url = 'data/daftarkelas/';
        $dataPerHalaman = 7;
        $from = $this->uri->segment(3);
        $data['kelas'] = $this->page->getPagination($tabel, $url, $dataPerHalaman, $from);

        $this->form_validation->set_rules('kode', 'Kode', 'required|trim');
        $this->form_validation->set_rules('kelas', 'Kelas', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/user-header', $data);
            $this->load->view('template/admin-sidebar');
            $this->load->view('template/user-topbar');
            $this->load->view('data/daftar-kelas');
            $this->load->view('template/user-footer');
        } else {
            $id = $this->input->post('id');
            $kode = $this->input->post('kode');
            $kelas = $this->input->post('kelas');
            $jurusan = $this->input->post('kelasJurusan');
            $result = $this->db->get_where('kelas', ['id' => $id]);
            $title = $this->db->get_where('kelas', ['kelas' => $kelas])->row_array();
            $cekKode = $this->db->get_where('kelas', ['kode_kelas' => $kode])->row_array();

            if ($result->num_rows() > 0) {
                if ($title['id'] == $id || $title['id'] == 0) {
                    //edit kelas
                    $this->data->setKelas($id, $kode, $kelas, $jurusan);
                } else {
                    $this->session->set_tempdata('pesan', '<div class="alert alert-danger" role="alert"> Edit kelas gagal!, kelas sudah ada sudah ada! </div>');
                    redirect('data/daftarkelas');
                }
            } else {
                if ($title) {
                    $this->session->set_tempdata('pesan', '<div class="alert alert-warning" role="alert"> Kelas yang anda tambahkan sudah ada! </div>');
                    redirect('data/daftarkelas');
                } else if ($cekKode) {
                    $this->session->set_tempdata('pesan', '<div class="alert alert-danger" role="alert">Nama Kelas yang anda tambahkan sudah ada</div>', 10);
                    redirect('data/daftarkelas');
                } else {
                    //tambah kelas
                    $this->data->tambahKelas($kode, $kelas, $jurusan);
                }
            }
        }
    }
    //edit kelas
    public function editKelas()
    {
        echo json_encode($this->getkelas($_POST['id']));
    }
    public function getkelas($id)
    {
        $result = $this->db->get_where('kelas', ['id' => $id])->row_array();
        return $result;
    }
    //hapus kelas
    public function hapuskelas($kelasId)
    {
        $this->db->delete('kelas', ['id' => $kelasId]);
        $this->db->delete('guru_access_kelas', ['kelas_id' => $kelasId]);
        $this->db->delete('jadwal_kelas', ['kelas_id' => $kelasId]);
        $this->session->set_tempdata('pesan', '<div class="alert alert-success" role="alert">Berhasil menghapus kelas</div>', 10);
        redirect('data/daftarkelas');
    }


    //detail kelas awal
    public function detailKelas($id)
    {
        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('user', ['email' => $email])->row_array();
        $data['title'] = 'Detail Kelas';
        $data['kelas'] = $this->db->get_where('kelas', ['id' => $id])->row_array();
        $data['siswa'] = $this->db->get_where('siswa', ['kelas_id' => $id])->result_array();
        $data['guruAksesKelas'] = $this->db->get_where('guru_access_kelas', ['kelas_id' => $id])->result_array();
        $data['mapel'] = $this->db->get('mapel')->result_array();
        $data['jadwalKelas'] = $this->db->get_where('jadwal_kelas', ['kelas_id' => $id])->result_array();

        $this->form_validation->set_rules('mapel', 'Mapel', 'required|trim');
        $this->form_validation->set_rules('hari', 'Hari', 'required|trim');
        $this->form_validation->set_rules('jam', 'Jam', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/user-header', $data);
            $this->load->view('template/admin-sidebar');
            $this->load->view('template/user-topbar');
            $this->load->view('data/detail-kelas');
            $this->load->view('template/user-footer');
        } else {
            $this->tambahJadwal($id);
        }
    }

    //set jadwal
    public function tambahJadwal($kelasId)
    {
        $id = $this->input->post('id');
        $mapelId = $this->input->post('mapel');
        $jam = $this->input->post('jam');
        $hari = $this->input->post('hari');
        $result = $this->db->get_where('jadwal_kelas', ['id' => $id]);
        $cekJam = $this->db->get_where('jadwal_kelas', ['kelas_id' => $kelasId, 'jam' => $jam]);
        $cekHari = $this->db->get_where('jadwal_kelas', ['kelas_id' => $kelasId, 'hari' => $hari]);

        if ($result->num_rows() > 0) {
            //edit kelas
            $this->data->setJadwalKelas($id, $kelasId, $mapelId, $hari, $jam);
        } else {
            if ($cekJam->num_rows() > 0) {
                if ($cekHari->num_rows() > 0) {
                    $this->session->set_tempdata('pesan', '<div class="alert alert-danger" role="alert">Gagal menambah jadwal kelas, sudah ada mapel pada jadwal tersebut</div>');
                    redirect('data/detailkelas/' . $kelasId);
                } else {
                    //tambah kelas
                    $this->data->tambahJadwalKelas($kelasId, $mapelId, $hari, $jam);
                }
            } else {
                //tambah kelas
                $this->data->tambahJadwalKelas($kelasId, $mapelId, $hari, $jam);
            }
        }
    }
    //edit detail kelas
    public function editJadwal()
    {
        echo json_encode($this->getJadwal($_POST['id']));
    }
    public function getJadwal($id)
    {
        $result = $this->db->get_where('jadwal_kelas', ['id' => $id])->row_array();
        return $result;
    }
    //hapus jadwal
    public function hapusJadwalKelas($kelasId, $jadwalId)
    {
        $this->data->deleteJadwalKelas($kelasId, $jadwalId);
    }


    //import data mengunakan excel
    //import mapel
    public function importMapel()
    {
        $upload_file = $_FILES['excel']['name'];
        //ketika upload file berhasil
        if ($upload_file) {
            $config['upload_path']      = './temp_doc/'; //siapkan path untuk upload file
            $config['allowed_types']    = 'xlsx|xls'; //siapkan format file
            $config['file_name']        = 'doc' . time(); //rename file yang diupload

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('excel')) {
                //fetch data upload
                $file   = $this->upload->data();

                $reader = ReaderEntityFactory::createXLSXReader(); //buat xlsx reader
                $reader->open('temp_doc/' . $file['file_name']); //open file xlsx yang baru saja diunggah

                //looping pembacaat sheet dalam file        
                foreach ($reader->getSheetIterator() as $sheet) {
                    $numRow = 1;

                    //siapkan variabel array kosong untuk menampung variabel array data
                    $save   = array();

                    //looping pembacaan row dalam sheet
                    foreach ($sheet->getRowIterator() as $row) {

                        if ($numRow > 1) {
                            //ambil cell
                            $cells = $row->getCells();

                            $data = array(
                                'kode_mapel' => $cells[0],
                                'mapel' => $cells[1],
                                'jurusan_id' => $cells[2],
                                'is_active' => 1
                            );

                            //tambahkan array $data ke $save
                            array_push($save, $data);
                        }

                        $numRow++;
                    }
                    //simpan data ke database
                    $this->app->simpanMapel($save);

                    //tutup spout reader
                    $reader->close();

                    //hapus file yang sudah diupload
                    unlink('temp_doc/' . $file['file_name']);

                    $this->session->set_tempdata('pesan', '<div class="alert alert-success" role="alert">Berhasil menambah mapel secara masal</div>');
                    redirect('data/daftarmapel');
                }
            } else {
                echo "Error :" . $this->upload->display_errors(); //tampilkan pesan error jika file gagal diupload
            }
        }
        $this->session->set_tempdata('pesan', '<div class="alert alert-danger" role="alert">Gagal, upload data</div>');
        redirect('data/daftarmapel');
    }

    //import kelas
    public function importKelas()
    {
        $upload_file = $_FILES['excel']['name'];
        //ketika upload file berhasil
        if ($upload_file) {
            $config['upload_path']      = './temp_doc/'; //siapkan path untuk upload file
            $config['allowed_types']    = 'xlsx|xls'; //siapkan format file
            $config['file_name']        = 'doc' . time(); //rename file yang diupload

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('excel')) {
                //fetch data upload
                $file   = $this->upload->data();

                $reader = ReaderEntityFactory::createXLSXReader(); //buat xlsx reader
                $reader->open('temp_doc/' . $file['file_name']); //open file xlsx yang baru saja diunggah

                //looping pembacaat sheet dalam file        
                foreach ($reader->getSheetIterator() as $sheet) {
                    $numRow = 1;

                    //siapkan variabel array kosong untuk menampung variabel array data
                    $save   = array();

                    //looping pembacaan row dalam sheet
                    foreach ($sheet->getRowIterator() as $row) {

                        if ($numRow > 1) {
                            //ambil cell
                            $cells = $row->getCells();

                            $data = array(
                                'kode_kelas' => $cells[0],
                                'kelas' => $cells[1],
                                'jurusan_id' => $cells[2]
                            );

                            //tambahkan array $data ke $save
                            array_push($save, $data);
                        }

                        $numRow++;
                    }
                    //simpan data ke database
                    $this->app->simpanKelas($save);

                    //tutup spout reader
                    $reader->close();

                    //hapus file yang sudah diupload
                    unlink('temp_doc/' . $file['file_name']);

                    $this->session->set_tempdata('pesan', '<div class="alert alert-success" role="alert">Berhasil menambah kelas secara masal</div>');
                    redirect('data/daftarkelas');
                }
            } else {
                echo "Error :" . $this->upload->display_errors(); //tampilkan pesan error jika file gagal diupload
            }
        }
        $this->session->set_tempdata('pesan', '<div class="alert alert-danger" role="alert">Gagal, upload data</div>');
        redirect('data/daftarkelas');
    }

    //import siswa
    public function importSiswa()
    {
        $upload_file = $_FILES['excel']['name'];
        //ketika upload file berhasil
        if ($upload_file) {
            $config['upload_path']      = './temp_doc/'; //siapkan path untuk upload file
            $config['allowed_types']    = 'xlsx|xls'; //siapkan format file
            $config['file_name']        = 'doc' . time(); //rename file yang diupload

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('excel')) {
                //fetch data upload
                $file   = $this->upload->data();
                // $this->importUser($file);

                $reader = ReaderEntityFactory::createXLSXReader(); //buat xlsx reader
                $reader->open('temp_doc/' . $file['file_name']); //open file xlsx yang baru saja diunggah

                //looping pembacaat sheet dalam file        
                foreach ($reader->getSheetIterator() as $sheet) {
                    $numRow = 1;

                    //siapkan variabel array kosong untuk menampung variabel array data
                    $save   = array();
                    $saveUser   = array();

                    //looping pembacaan row dalam sheet
                    foreach ($sheet->getRowIterator() as $row) {

                        if ($numRow > 1) {
                            //ambil cell
                            $cells = $row->getCells();

                            //siswa
                            $data = array(
                                'nis' => $cells[0],
                                'nama' => $cells[1],
                                'email' => $cells[2],
                                'jurusan_id' => $cells[3],
                                'semester' => $cells[4],
                                'kelas_id' => $cells[5],
                                'gambar' => 'default.jpg',
                                'is_active' => 0
                            );
                            //tambahkan array $data ke $save
                            array_push($save, $data);

                            //user siswa
                            $user = array(
                                'name' => $cells[1],
                                'email' => $cells[2],
                                'password' => password_hash($cells[6], PASSWORD_DEFAULT),
                                'role_id' => 3,
                                'is_active' => 0
                            );

                            array_push($saveUser, $user);
                        }

                        $numRow++;
                    }
                    //simpan data ke database
                    $this->app->simpanUser($saveUser);
                    $this->app->simpanSiswa($save);

                    //tutup spout reader
                    $reader->close();

                    //hapus file yang sudah diupload
                    unlink('temp_doc/' . $file['file_name']);

                    $this->session->set_tempdata('pesan', '<div class="alert alert-success" role="alert">Berhasil menambah siswa secara masal</div>');
                    redirect('data/daftarsiswa');
                }
            } else {
                echo "Error :" . $this->upload->display_errors(); //tampilkan pesan error jika file gagal diupload
            }
        }
        $this->session->set_tempdata('pesan', '<div class="alert alert-danger" role="alert">Gagal, upload data</div>');
        redirect('data/daftarsiswa');
    }

    //import guru
    public function importGuru()
    {
        $upload_file = $_FILES['excel']['name'];
        //ketika upload file berhasil
        if ($upload_file) {
            $config['upload_path']      = './temp_doc/'; //siapkan path untuk upload file
            $config['allowed_types']    = 'xlsx|xls'; //siapkan format file
            $config['file_name']        = 'doc' . time(); //rename file yang diupload

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('excel')) {
                //fetch data upload
                $file   = $this->upload->data();
                // $this->importUser($file);

                $reader = ReaderEntityFactory::createXLSXReader(); //buat xlsx reader
                $reader->open('temp_doc/' . $file['file_name']); //open file xlsx yang baru saja diunggah

                //looping pembacaat sheet dalam file        
                foreach ($reader->getSheetIterator() as $sheet) {
                    $numRow = 1;

                    //siapkan variabel array kosong untuk menampung variabel array data
                    $save   = array();
                    $saveUser   = array();

                    //looping pembacaan row dalam sheet
                    foreach ($sheet->getRowIterator() as $row) {

                        if ($numRow > 1) {
                            //ambil cell
                            $cells = $row->getCells();

                            //siswa
                            $data = array(
                                'nip' => $cells[0],
                                'nama' => $cells[1],
                                'email' => $cells[2],
                                'mapel_id' => $cells[3],
                                'gambar' => 'default.jpg',
                                'is_active' => 0
                            );
                            //tambahkan array $data ke $save
                            array_push($save, $data);

                            //user siswa
                            $user = array(
                                'name' => $cells[1],
                                'email' => $cells[2],
                                'password' => password_hash($cells[4], PASSWORD_DEFAULT),
                                'role_id' => 2,
                                'is_active' => 0
                            );

                            array_push($saveUser, $user);
                        }

                        $numRow++;
                    }
                    //simpan data ke database
                    $this->app->simpanUser($saveUser);
                    $this->app->simpanGuru($save);

                    //tutup spout reader
                    $reader->close();

                    //hapus file yang sudah diupload
                    unlink('temp_doc/' . $file['file_name']);

                    $this->session->set_tempdata('pesan', '<div class="alert alert-success" role="alert">Berhasil menambah guru secara masal</div>');
                    redirect('data/daftarguru');
                }
            } else {
                echo "Error :" . $this->upload->display_errors(); //tampilkan pesan error jika file gagal diupload
            }
        }
        $this->session->set_tempdata('pesan', '<div class="alert alert-danger" role="alert">Gagal, upload data</div>');
        redirect('data/daftarguru');
    }
}
