<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Master extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Modeldata', 'model');
        $this->load->model('Auth_model');

        $this->bulan = array('', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');

        $user = $this->Auth_model->current_user();

        if (!$this->Auth_model->current_user() || $user->level != 'admin') {
            redirect('login/logout');
        }
    }

    public function index()
    {
    }

    public function guru()
    {
        $data['guru'] = $this->model->getAll('guru')->result();

        $this->load->view('head');
        $this->load->view('guru', $data);
        $this->load->view('foot');
    }
    public function mapel()
    {
        $data['mapel'] = $this->model->getAll('mapel')->result();

        $this->load->view('head');
        $this->load->view('mapel', $data);
        $this->load->view('foot');
    }

    public function piket()
    {
        $data['mapel'] = $this->db->query("SELECT * FROM piket JOIN guru ON piket.guru=guru.kode_guru ORDER BY piket.hari ASC, piket.tempat ASC")->result();
        $data['guru'] = $this->model->getAll('guru');

        $this->load->view('head');
        $this->load->view('piket', $data);
        $this->load->view('foot');
    }

    public function addPiket()
    {
        $data = [
            'hari' => $this->input->post('hari', true),
            'guru' => $this->input->post('guru', true),
            'tempat' => $this->input->post('tempat', true),
        ];

        $this->model->simpan('piket', $data);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('ok', 'input Piket Berhasil');
            redirect('master/piket');
        } else {
            $this->session->set_flashdata('ok', 'input Piket Gagal');
            redirect('master/piket');
        }
    }

    public function jadwal()
    {
        $data['jadwal'] = $this->model->getJadwal();
        $data['guru'] = $this->model->getAll('guru');
        $data['mapel'] = $this->model->getAll('mapel');
        $data['kelas'] = $this->model->getBy('kl_formal', 'lembaga', 'SMK');

        $data['Saturday'] = $this->db->query("SELECT *, (SELECT COUNT(kelas) FROM jadwal WHERE kelas=A.kelas AND hari = 'Saturday') AS jumlah FROM jadwal A JOIN guru ON guru.kode_guru=A.guru JOIN mapel ON mapel.kode_mapel=A.mapel WHERE hari = 'Saturday' ORDER BY A.kelas ASC, A.jam_dari ASC");
        $data['Sunday'] = $this->db->query("SELECT *, (SELECT COUNT(kelas) FROM jadwal WHERE kelas=A.kelas AND hari = 'Sunday') AS jumlah FROM jadwal A JOIN guru ON guru.kode_guru=A.guru JOIN mapel ON mapel.kode_mapel=A.mapel WHERE hari = 'Sunday' ORDER BY A.kelas ASC, A.jam_dari ASC");

        $this->load->view('head');
        $this->load->view('jadwal', $data);
        $this->load->view('foot');
    }

    public function saveMapel()
    {
        $data = [
            'id_jadwal' => $this->uuid->v4(),
            'hari' => $this->input->post('hari', true),
            'jam_dari' => $this->input->post('dari', true),
            'jam_sampai' => $this->input->post('sampai', true),
            'guru' => $this->input->post('guru', true),
            'mapel' => $this->input->post('mapel', true),
            'kelas' => $this->input->post('kelas', true),
        ];

        $this->model->simpan('jadwal', $data);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('ok', 'input Jadwal Berhasil');
            redirect('master/jadwal');
        } else {
            $this->session->set_flashdata('ok', 'input Jadwal Gagal');
            redirect('master/jadwal');
        }
    }

    public function hapusJadwal($id)
    {
        $this->model->hapus('jadwal', 'id_jadwal', $id);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('ok', 'Hapus Jadwal Berhasil');
            redirect('master/jadwal');
        } else {
            $this->session->set_flashdata('ok', 'Hapus Jadwal Gagal');
            redirect('master/jadwal');
        }
    }

    public function delPiket($id)
    {
        $this->model->hapus('piket', 'id_piket', $id);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('ok', 'Hapus Jadwal Piket Berhasil');
            redirect('master/piket');
        } else {
            $this->session->set_flashdata('ok', 'Hapus Jadwal Piket Gagal');
            redirect('master/piket');
        }
    }
}
