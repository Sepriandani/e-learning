<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Password_model extends CI_Model
{
    public function changePassword($email, $passwordDatabase, $passwordInput, $newPassword)
    {
        $roleId = $this->session->userdata('role_id');
        $role = $this->db->get_where('user_role', ['id' => $roleId])->row_array();
        if (password_verify($passwordInput, $passwordDatabase)) {
            if ($passwordInput == $newPassword) {
                $this->session->set_tempdata('pesan', '<div class="alert alert-warning" role="alert">Password lama dan password baru yang anda masukkan sama</div>');
                return redirect($role['role'] . '/ubahpassword');
            } else {
                $newPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                $this->db->set('password', $newPassword);
                $this->db->where('email', $email);
                $this->db->update('user');
            }

            $this->session->set_tempdata('pesan', '<div class="alert alert-success" role="alert">Password berhasil diubah</div>', 10);
            return redirect($role['role'] . '/ubahpassword');
        } else {
            $this->session->set_tempdata('pesan', '<div class="alert alert-danger" role="alert">Password lama salah!</div>', 10);
            return redirect($role['role'] . '/ubahpassword');
        }
    }
}
