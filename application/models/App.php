<?php
defined('BASEPATH') or exit('No direct script access allowed');

class App extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    function simpanMapel($data = array())
    {
        $jumlah = count($data);

        if ($jumlah > 0) {
            $this->db->insert_batch('mapel', $data);
        }
    }

    function simpanKelas($data = array())
    {
        $jumlah = count($data);

        if ($jumlah > 0) {
            $this->db->insert_batch('kelas', $data);
        }
    }

    function simpanSiswa($data = array())
    {
        $jumlah = count($data);

        if ($jumlah > 0) {
            $this->db->insert_batch('siswa', $data);
        }
    }

    function simpanGuru($data = array())
    {
        $jumlah = count($data);

        if ($jumlah > 0) {
            $this->db->insert_batch('guru', $data);
        }
    }

    function simpanUser($data = array())
    {
        $jumlah = count($data);

        if ($jumlah > 0) {
            $this->db->insert_batch('user', $data);
        }
    }
}
