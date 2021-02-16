<?php

function is_logged_in()
{
    $ci = get_instance();

    if (!$ci->session->userdata('email')) {
        redirect('auth');
    } else {
        $role_id = $ci->session->userdata('role_id');
        $halaman = $ci->uri->segment(1);

        if ($role_id == 1) {
            if ($halaman == 'siswa' || $halaman == 'guru') {
                redirect('auth/blocked');
            }
        } else if ($role_id == 2) {
            if ($halaman == 'admin' || $halaman == 'data' || $halaman == 'siswa') {
                redirect('auth/blocked');
            }
        } else {
            if ($halaman == 'admin' || $halaman == 'data' || $halaman == 'guru') {
                redirect('auth/blocked');
            }
        }
    }
}

function check_access($siswaId, $tugasId, $soalId, $pilihan)
{
    $ci = get_instance();

    $soal = $ci->db->get_where('soal_objectiv', ['id' => $soalId])->row_array();
    $jawabanSiswa = $ci->db->get_where('tugas_jawaban_siswa', ['siswa_id' => $siswaId, 'tugas_id' => $tugasId, 'soal_id' => $soalId])->row_array();


    if ($jawabanSiswa['jawaban'] == $pilihan) {
        return "checked = 'checked'";
    } else if ($pilihan == $soal['kunci_jawaban']) {
        return "checked = 'checked' disabled";
    } else {
        return "disabled";
    }
}
