<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Password_model', 'password');
        is_logged_in();
    }

    public function index()
    {
        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('user', ['email' => $email])->row_array();
        $data['title'] = 'Dasboard';

        $this->db->order_by('id', 'DESC');
        $data['pengumuman'] = $this->db->get_where('pengumuman', ['is_active' => 1])->result_array();

        $this->load->view('template/user-header', $data);
        $this->load->view('template/admin-sidebar');
        $this->load->view('template/user-topbar', $data);
        $this->load->view('admin/index');
        $this->load->view('template/user-footer');
    }

    public function profile()
    {
        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('user', ['email' => $email])->row_array();
        $data['title'] = 'Profile';
        $data['admin'] = $this->db->get_where('admin', ['email' => $email])->row_array();

        $this->load->view('template/user-header', $data);
        $this->load->view('template/admin-sidebar');
        $this->load->view('template/user-topbar', $data);
        $this->load->view('admin/profile');
        $this->load->view('template/user-footer');
    }
    public function editprofile()
    {
        $data['title'] = 'Edit Profile';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['admin'] = $this->db->get_where('admin', ['email' => $data['user']['email']])->row_array();

        $this->form_validation->set_rules('name', 'Full Name', 'required|trim');
        $this->form_validation->set_rules('nip', 'NIP', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/user-header', $data);
            $this->load->view('template/admin-sidebar');
            $this->load->view('template/user-topbar');
            $this->load->view('admin/edit-profile');
            $this->load->view('template/user-footer');
        } else {
            $name = $this->input->post('name');
            $email = $this->input->post('email');
            $nip = $this->input->post('nip');

            //cek gambar
            $upload_image = $_FILES['image']['name'];

            if ($upload_image) {
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_size'] = '2048';
                $config['upload_path'] = './assets/img/profile';

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('image')) {
                    $old_image = $data['admin']['gambar'];
                    if ($old_image != 'default.jpg') {
                        unlink(FCPATH . 'assets/img/profile/' . $old_image);
                    }

                    $new_image = $this->upload->data('file_name');
                    $this->db->set('gambar', $new_image);
                } else {
                    echo $this->upload->display_errors();
                }
            }

            $this->db->set('nip', $nip);
            $this->db->set('nama', $name);
            $this->db->where('email', $email);
            $this->db->update('admin');

            $this->session->set_tempdata('pesan', '<div class="alert alert-success" role="alert">Berhasil mengubah profile!</div>', 10);
            redirect('admin/profile');
        }
    }
    public function pengumuman()
    {
        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('user', ['email' => $email])->row_array();
        $data['title'] = 'Pengumuman';

        $this->db->order_by('id', 'DESC');
        $data['pengumuman'] = $this->db->get('pengumuman')->result_array();

        $this->form_validation->set_rules('headline', 'Headline', 'required|trim');
        $this->form_validation->set_rules('pengumuman', 'Pengumuman', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/user-header', $data);
            $this->load->view('template/admin-sidebar');
            $this->load->view('template/user-topbar', $data);
            $this->load->view('admin/pengumuman');
            $this->load->view('template/user-footer');
        } else {
            $id = $this->input->post('id');
            $headline = $this->input->post('headline');
            $pengumuman = $this->input->post('pengumuman');
            $result = $this->db->get_where('pengumuman', ['id' => $id])->row_array();
            $cekHeadline = $this->db->get_where('pengumuman', ['headline' => $headline])->row_array();
            $new_image = $result['gambar'];

            //cek gambar
            $upload_image = $_FILES['image']['name'];

            if ($upload_image) {
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_size'] = '2048';
                $config['upload_path'] = './assets/img/pengumuman';

                $this->load->library('upload', $config);
                if ($this->upload->do_upload('image')) {
                    $old_file = $result['gambar'];
                    if ($old_file != 'default.pdf') {
                        unlink(FCPATH . 'assets/file/' . $old_file);
                    }
                    $new_image = $this->upload->data('file_name');
                } else {
                    echo $this->upload->display_errors();
                }
            }
            if ($result) {
                if ($cekHeadline['id'] == $id || $cekHeadline['id'] == 0) {
                    $this->db->set([
                        'headline' => htmlspecialchars($headline),
                        'pengumuman' => htmlspecialchars($pengumuman),
                        'gambar' => $new_image
                    ]);
                    $this->db->where('id', $id);
                    $this->db->update('pengumuman');

                    $this->session->set_tempdata('pesan', '<div class="alert alert-success" role="alert">Berhasil mengedit pengumuman</div>');
                    redirect('admin/pengumuman');
                } else {
                    $this->session->set_tempdata('pesan', '<div class="alert alert-success" role="alert">Gagal mengedit pengumuman. Headline yang anda masukkan sudah ada</div>');
                    redirect('admin/pengumuman');
                }
            } else {
                if ($cekHeadline) {
                    $this->session->set_tempdata('pesan', '<div class="alert alert-success" role="alert">Gagal menambahkan pengumuman, Headline sudah ada</div>');
                    redirect('admin/pengumuman');
                } else {
                    $this->db->insert('pengumuman', [
                        'headline' => $headline,
                        'pengumuman' => htmlspecialchars($pengumuman),
                        'gambar' => $new_image,
                        'date_created' => time(),
                        'date_post' => 0,
                        'is_active' => 0
                    ]);

                    $this->session->set_tempdata('pesan', '<div class="alert alert-success" role="alert">Berhasil menambahkan pengumuman</div>');
                    redirect('admin/pengumuman');
                }
            }
        }
    }
    //hapus pengumuman
    public function hapuspengumuman($id)
    {
        $this->db->delete('pengumuman', ['id' => $id]);
        $this->session->set_tempdata('pesan', '<div class="alert alert-success" role="alert">Berhasil menghapus pengumuman</div>');
        redirect('admin/pengumuman');
    }
    //edit Pengumuman
    public function editPengumuman()
    {
        echo json_encode($this->getPengumuman($_POST['id']));
    }
    public function getPengumuman($id)
    {
        $result = $this->db->get_where('pengumuman', ['id' => $id])->row_array();
        return $result;
    }
    //terbitkan pengumuman
    public function terbitkanPengumuman($id, $status)
    {
        $pengumuman = $this->db->get_where('pengumuman', ['id' => $id])->row_array();
        if ($status == 'Active') {
            $this->db->set([
                'date_post' => 0,
                'is_active' => 0
            ]);
            $this->db->where('id', $id);
            $this->db->update('pengumuman');

            $this->session->set_tempdata('pesan', '<div class="alert alert-success" role="alert">Pengumunan <strong>' . $pengumuman['headline'] . '</strong> berhasil di Non-aktifkan</div>');
            redirect('admin/pengumuman');
        } else {
            $this->db->set([
                'date_post' => time(),
                'is_active' => 1
            ]);
            $this->db->where('id', $id);
            $this->db->update('pengumuman');

            $this->session->set_tempdata('pesan', '<div class="alert alert-success" role="alert">Pengumunan <strong>' . $pengumuman['headline'] . '</strong> berhasil diterbitkan</div>');
            redirect('admin/pengumuman');
        }
    }

    public function tutorial()
    {
        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('user', ['email' => $email])->row_array();
        $data['title'] = 'Tutorial';

        $this->load->view('template/user-header', $data);
        $this->load->view('template/admin-sidebar');
        $this->load->view('template/user-topbar', $data);
        $this->load->view('admin/tutorial');
        $this->load->view('template/user-footer');
    }

    public function ubahpassword()
    {
        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('user', ['email' => $email])->row_array();
        $data['title'] = 'Ubah Password';

        $this->form_validation->set_rules('current_password', 'Current Password', 'required|trim');
        $this->form_validation->set_rules('new_password1', 'New Password1', 'required|trim|min_length[6]|matches[new_password2]');
        $this->form_validation->set_rules('new_password2', 'New Password2', 'required|trim|matches[new_password1]');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/user-header', $data);
            $this->load->view('template/admin-sidebar');
            $this->load->view('template/user-topbar', $data);
            $this->load->view('admin/ubah-password');
            $this->load->view('template/user-footer');
        } else {
            $password = $this->input->post('current_password');
            $newPassword1 = $this->input->post('new_password1');

            $this->password->changePassword($email, $data['user']['password'], $password, $newPassword1);
        }
    }
}
