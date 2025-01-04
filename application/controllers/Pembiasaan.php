<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pembiasaan extends CI_Controller
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
        $data['userData'] = $this->Auth_model->current_user();
        $data['data'] = $this->db->query("SELECT *, COUNT(*) as jumlah FROM waqiah GROUP BY tanggal ORDER BY tanggal DESC")->result();

        $this->load->view('head', $data);
        $this->load->view('waqiah', $data);
        $this->load->view('foot');
    }

    public function input()
    {
        $data['userData'] = $this->Auth_model->current_user();
        $data['data'] = $this->db->query("SELECT *, COUNT(*) as jumlah FROM waqiah GROUP BY tanggal ORDER BY tanggal DESC")->result();

        $this->load->view('head', $data);
        $this->load->view('waqiahInput', $data);
        $this->load->view('foot');
    }
    public function input2()
    {
        $data['userData'] = $this->Auth_model->current_user();
        $data['data'] = $this->db->query("SELECT *, COUNT(*) as jumlah FROM waqiah GROUP BY tanggal ORDER BY tanggal DESC")->result();

        $this->load->view('head', $data);
        $this->load->view('waqiahInput2', $data);
        $this->load->view('foot');
    }

    public function loadAbsen()
    {
        $tanggal = $this->input->post('tanggal', 'true');

        $data = $this->db->query("SELECT waqiah.*, tb_santri.nama, tb_santri.k_formal, tb_santri.jurusan, tb_santri.r_formal FROM waqiah JOIN tb_santri ON waqiah.nis=tb_santri.nis WHERE waqiah.tanggal = '$tanggal' ORDER BY waqiah.id DESC LIMIT 5")->result();

        echo json_encode($data);
    }

    public function addAbsens()
    {
        $tanggal = $this->input->post('tanggal', 'true');
        $nis = $this->input->post('nis', 'true');

        $cek = $this->model->getBy2('waqiah', 'nis', $nis, 'tanggal', $tanggal)->row();
        if ($cek) {
            echo json_encode(['status' => 'sudah']);
        } else {
            $ceksiswa = $this->model->getBy('tb_santri', 'nis', $nis)->row();
            if ($ceksiswa) {
                $dataInput = [
                    'nis' => $nis,
                    'tanggal' => $tanggal,
                    'hadir' => date('H:i:s'),
                ];
                $this->model->simpan('waqiah', $dataInput);
                if ($this->db->affected_rows() > 0) {
                    echo json_encode(['status' => 'ok']);
                } else {
                    echo json_encode(['status' => 'error']);
                }
            } else {
                echo json_encode(['status' => 'not_found']);
            }
        }
    }

    public function loadJumlah()
    {
        $tanggal = $this->input->post('tanggal', 'true');
        $hari = date('l', strtotime($tanggal));
        if ($hari == 'Sunday') {
            $batas = '08:45:00';
        } else {
            $batas = '09:45:00';
        }

        $hadir = $this->db->query("SELECT COUNT(*) as jumlah FROM waqiah WHERE tanggal = '$tanggal' AND hadir <= '$batas' ")->row();
        $telat = $this->db->query("SELECT COUNT(*) as jumlah FROM waqiah WHERE tanggal = '$tanggal' AND hadir > '$batas' ")->row();
        $santri = $this->db->query("SELECT COUNT(*) as jumlah FROM tb_santri WHERE aktif = 'Y'")->row();

        echo json_encode([
            'hadir' => $hadir->jumlah,
            'telat' => $telat->jumlah,
            'belum' => $santri->jumlah - ($hadir->jumlah + $telat->jumlah),
            'hadirPrs' => round(($hadir->jumlah / $santri->jumlah) * 100, 2),
            'telatPrs' => round(($telat->jumlah / $santri->jumlah) * 100),
            'belumPrs' => round((($santri->jumlah - ($hadir->jumlah + $telat->jumlah)) / $santri->jumlah) * 100, 2)
        ]);

    }

    public function hapus($id)
    {
        $data = $this->model->getBy('waqiah', 'id', $id)->row();

        $this->model->hapus('waqiah', 'tanggal', $data->tanggal);
        if ($this->db->affected_rows() > 1) {
            $this->session->set_flashdata('ok', 'Hapus data berhasil');
            redirect('pembiasaan');
        } else {
            $this->session->set_flashdata('error', 'Hapus data gagal');
            redirect('pembiasaan');
        }
    }
}
