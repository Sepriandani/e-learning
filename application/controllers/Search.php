<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Search extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        is_logged_in();
    }

    public function daftarMapelSearch()
    {
        $keyword = $_GET['keyword'];

        $query = "SELECT * FROM mapel WHERE 
		kode_mapel LIKE '%$keyword%' OR 
		mapel LIKE '%$keyword%'
		";
        $data['mapel'] = $this->db->query($query)->result_array();

        $this->load->view('search/daftar-mapel-search', $data);
    }

    public function daftarKelasSearch()
    {
        $keyword = $_GET['keyword'];

        $query = "SELECT * FROM kelas WHERE 
		kode_kelas LIKE '%$keyword%' OR 
		kelas LIKE '%$keyword%'
		";
        $data['kelas'] = $this->db->query($query)->result_array();

        $this->load->view('search/daftar-kelas-search', $data);
    }

    public function daftarSiswaSearch()
    {
        $keyword = $_GET['keyword'];

        $query = "SELECT * FROM siswa WHERE 
		nis LIKE '%$keyword%' OR 
		nama LIKE '%$keyword%' OR 
		email LIKE '%$keyword%'
		";
        $data['siswa'] = $this->db->query($query)->result_array();

        $this->load->view('search/daftar-siswa-search', $data);
    }

    public function daftarGuruSearch()
    {
        $keyword = $_GET['keyword'];

        $query = "SELECT * FROM guru WHERE 
		nip LIKE '%$keyword%' OR 
		nama LIKE '%$keyword%' OR 
		email LIKE '%$keyword%'
		";
        $data['guru'] = $this->db->query($query)->result_array();

        $this->load->view('search/daftar-guru-search', $data);
    }
}
