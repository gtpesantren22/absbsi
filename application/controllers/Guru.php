<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Guru extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Modeldata', 'model');
        $this->load->model('Auth_model');

        $this->bulan = array('', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');

        $user = $this->Auth_model->current_user();

        $this->user = $user->nama;
        $this->userKode = $user->kode_guru;

        if (!$this->Auth_model->current_user() || $user->level != 'adm' && $user->level != 'admin') {
            redirect('login/logout');
        }
    }

    public function index()
    {
    }

    public function absenSiswa()
    {
        $data['bln'] = $this->bulan;
        $data['user'] = $this->user;

        $data['guru'] = $this->model->getAll('guru');
        $data['mapel'] = $this->model->getAll('mapel');

        $isDay = date('l');
        $data['kelas'] = $this->db->query("SELECT * FROM jadwal WHERE hari = 'Saturday' AND guru = '$this->userKode' GROUP BY kelas ORDER BY kelas ASC ");

        $this->load->view('head');
        $this->load->view('jurnalGuru', $data);
        $this->load->view('foot');
    }
}
