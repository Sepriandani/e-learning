<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Auth_model', 'auth');
    }

    public function index()
    {
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/auth-header');
            $this->load->view('auth/index');
            $this->load->view('template/auth-footer');
        } else {
            $this->auth->login();
        }
    }

    public function logout()
    {
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('role_id');

        $this->session->set_tempdata('pesan', '<div class="alert alert-success" role="alert">Logout berhasil</div>', 10);
        redirect('auth');
    }

    public function blocked()
    {
        $this->load->view('auth/blocked');
    }

    public function send_mail($token)
    {
        ini_set("SMTP", "ssl://smtp.googlemail.com");
        ini_set("smtp_port", "465");

        $this->load->library('email');
        $config = array();
        $config['protocol']     = 'smtp'; // you can use 'mail' instead of 'sendmail or smtp'
        $config['smtp_host']    = 'smtp.googlemail.com'; // you can use 'smtp.googlemail.com' or 'smtp.gmail.com' instead of 'ssl://smtp.googlemail.com'
        $config['smtp_user']    = 'dreamproject.sd@gmail.com'; // client email gmail id
        $config['smtp_pass']    = 'Askila22#'; // client password
        $config['smtp_port']    =  465;
        $config['smtp_crypto']  = 'ssl';
        $config['mailtype']     = 'html';
        $config['charset']      = 'utf-8';
        $config['newline']      = "\r\n";
        $config['wordwrap']     = TRUE;
        $config['validate']     = FALSE;
        $this->load->library('email', $config); // intializing email library, whitch is defiend in system
        $this->email->initialize($config);
        $this->email->set_newline("\r\n"); // comuplsory line attechment because codeIgniter interacts with the SMTP server with regards to line break
        $email = $this->input->post('email');
        $this->email->from('dreamproject.sd@gmail.com', 'Scene Cut');
        $this->email->to($email);


        $this->email->subject('Reset Password');
        $this->email->message('Click this link to reset your password! : <a href="' . base_url() . 'auth/resetpassword?email=' . $email . '&token=' . urlencode($token) . '">Reset Password</a>');


        //Send mail
        if ($this->email->send()) {
            return true;
        } else {
            echo "email_not_sent";
            echo $this->email->print_debugger();  // If any error come, its run
            die;
        }
    }

    //lupa password
    public function lupaPassword()
    {
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Forgot Password';
            $this->load->view('template/auth-header', $data);
            $this->load->view('auth/lupa-password');
            $this->load->view('template/auth-footer');
        } else {
            $email = $this->input->post('email');
            $user = $this->db->get_where('user', ['email' => $email, 'is_active' => 1])->row_array();

            if ($user) {
                $token = base64_encode(random_bytes(32));
                $user_token = [
                    'email' => $email,
                    'token' => $token,
                    'date_created' => time()
                ];
                $this->db->insert('user_token', $user_token);
                $this->send_mail($token);

                $this->session->set_tempdata('pesan', '<div class="alert alert-success" role="alert"> Cek email anda untuk melakukan reset password! </div>');
                redirect('auth/lupapassword');
            } else {
                $this->session->set_tempdata('pesan', '<div class="alert alert-danger" role="alert"> Email yang anda masukkan tidak terdaftar atau non-active! </div>');
                redirect('auth/lupapassword');
            }
        }
    }

    public function resetPassword()
    {
        //ambil data dari url
        $email = $this->input->get('email');
        $token = $this->input->get('token');

        //cek data ada di database atau tidak
        $user = $this->db->get_where('user', ['email' => $email])->row_array();

        if ($user) {
            $user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();

            if ($user_token) {
                if (time() - $user_token['date_created'] < (60 * 60 * 24)) {
                    $this->session->set_userdata('reset_email', $email);
                    $this->ubahPassword();
                } else {
                    $this->db->delete('user', ['email' => $email]);
                    $this->db->delete('user_token', ['email' => $email]);

                    $this->session->set_tempdata('pesan', '<div class="alert alert-danger" role="alert"> Account Activation failed! Token expired. </div>');
                    redirect('auth');
                }
            } else {
                $this->session->set_tempdata('pesan', '<div class="alert alert-danger" role="alert"> Reset password failed, Wrong token! </div>');
                redirect('auth');
            }
        } else {
            $this->session->set_tempdata('pesan', '<div class="alert alert-danger" role="alert"> Reset password failed, Wrong email! </div>');
            redirect('auth');
        }
    }

    public function ubahPassword()
    {
        //cek session reset_email ada atau tidak
        //kalau tidak ada method tidak bisa diakses
        if (!$this->session->userdata('reset_email')) {
            redirect('auth');
        }

        $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[6]|matches[password2]');
        $this->form_validation->set_rules('password2', 'Password', 'required|trim|min_length[6]|matches[password1]');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Ubah Password';
            $this->load->view('template/auth-header', $data);
            $this->load->view('auth/ubah-password');
            $this->load->view('template/auth-footer');
        } else {
            //enkripsi password
            $password = password_hash($this->input->post('password1'), PASSWORD_DEFAULT);
            $email = $this->session->userdata('reset_email');

            //ubah password database
            $this->db->set('password', $password);
            $this->db->where('email', $email);
            $this->db->update('user');

            //hapus email session
            $this->session->unset_userdata('reset_email');
            $this->session->set_tempdata('pesan', '<div class="alert alert-success" role="alert"> Password berhasil diubah, silahkan login! </div>');
            redirect('auth');
        }
    }
}
