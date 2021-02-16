<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth_model extends CI_Model
{
    public function login()
    {
        $email = $this->input->post('email');
        //cek username
        $user = $this->db->get_where('user', ['email' => $email])->row_array();
        if ($user) {
            //cek password
            $password = $this->input->post('password');
            if (password_verify($password, $user['password'])) {
                //cek is active
                if ($user['is_active'] == 0) {
                    $this->session->set_tempdata('pesan', '<div class="alert alert-danger" role="alert">Akun anda belum di Aktivan, silahkan hubungi admin untuk aktivasi akun</div>');
                    redirect('auth');
                } else {
                    $data = [
                        'email' => $user['email'],
                        'role_id' => $user['role_id']
                    ];
                    $this->session->set_userdata($data);

                    if ($user['role_id'] == 1) {
                        return redirect('admin');
                    } else if ($user['role_id'] == 2) {
                        return redirect('guru');
                    } else if ($user['role_id'] == 3) {
                        return redirect('siswa');
                    }
                }
            } else {
                $this->session->set_tempdata('pesan', '<div class="alert alert-danger" role="alert">Password Salah</div>', 10);
                return redirect('auth');
            }
        } else {
            $this->session->set_tempdata('pesan', '<div class="alert alert-danger" role="alert">Email tidak terdaftar</div>', 10);
            return redirect('auth');
        }
    }
}
