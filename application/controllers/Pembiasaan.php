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

        // if (!$this->Auth_model->current_user() || $user->level != 'admin') {
        //     redirect('login/logout');
        // }
    }

    public function index()
    {
        // $data['userData'] = $this->Auth_model->current_user();
        $data['data'] = $this->db->query("SELECT *, COUNT(*) as jumlah FROM waqiah GROUP BY tanggal ORDER BY tanggal DESC")->result();

        $this->load->view('head2', $data);
        $this->load->view('waqiah', $data);
        $this->load->view('foot');
    }

    public function guru()
    {
        if (!$this->Auth_model->current_user()) {
            redirect('login/logout');
        }

        $data['userData'] = $this->Auth_model->current_user();
        $data['data'] = $this->db->query("SELECT *, COUNT(*) as jumlah FROM apel_guru GROUP BY tanggal ORDER BY tanggal DESC")->result();

        $this->load->view('head', $data);
        $this->load->view('apel_guru', $data);
        $this->load->view('foot');
    }

    public function input_apel()
    {
        $data['userData'] = $this->Auth_model->current_user();
        $harini = date('l');
        $data['data'] = $this->db->query("SELECT a.*, b.nama_guru FROM apel_sett a JOIN guru b ON a.kode_guru=b.kode_guru WHERE hari = '$harini' ")->result();

        $this->load->view('head', $data);
        $this->load->view('apelGuruInput', $data);
        $this->load->view('foot');
    }
    public function apelSett()
    {
        $data['userData'] = $this->Auth_model->current_user();
        $gru = $this->model->getAll('guru')->result();
        $datakirim = [];
        foreach ($gru as $value) {
            $haris = $this->db->query("SELECT GROUP_CONCAT(hari ORDER BY hari SEPARATOR ',') AS daftar_hari FROM apel_sett WHERE kode_guru = '$value->kode_guru' GROUP BY kode_guru")->row();
            $datakirim[] = [
                'kode_guru' => $value->kode_guru,
                'nama_guru' => $value->nama_guru,
                'daftar_hari' => $haris ? $haris->daftar_hari : '0,0,0',
            ];
        }
        $data['data'] = $datakirim;

        $this->load->view('head', $data);
        $this->load->view('apelSetting', $data);
        $this->load->view('foot');
    }

    public function saveApel()
    {
        $kode_guru = $this->input->post('kode_guru', true);
        $hari = $this->input->post('hari', true);
        $status = $this->input->post('status', true);

        if ($status == 1) {
            $save = [
                'kode_guru' => $kode_guru,
                'hari' => $hari
            ];
            $this->model->simpan('apel_sett', $save);
            echo json_encode(['status' => 'success', 'message' => 'input data success']);
        } else {
            $this->model->hapus2('apel_sett', 'kode_guru', $kode_guru, 'hari', $hari);
            echo json_encode(['status' => 'success', 'message' => 'hapus data success']);
        }
    }

    public function saveApelGuru()
    {
        $data = $this->input->post('data', true);
        $tanggal = date('Y-m-d');
        $cek = $this->model->getBy('apel_guru', 'tanggal', $tanggal)->row();
        if ($cek) {
            $this->session->set_flashdata('error', 'Absensi sudah ada');
            redirect('pembiasaan/guru');
            die();
        }
        if (!empty($data)) {
            foreach ($data as $item) {
                $dtsm = [
                    'tanggal' => $tanggal,
                    'kode_guru' => $item['kode_guru'],
                    'ket' => $item['ket'],
                ];
                $this->model->simpan('apel_guru', $dtsm);
            }
        }
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('ok', 'Input Absen Berhasil');
            redirect('pembiasaan/guru');
        } else {
            $this->session->set_flashdata('error', 'Input Absen Gagal');
            redirect('pembiasaan/guru');
        }
    }

    public function input()
    {
        // $data['userData'] = $this->Auth_model->current_user();
        $data['data'] = $this->db->query("SELECT *, COUNT(*) as jumlah FROM waqiah GROUP BY tanggal ORDER BY tanggal DESC")->result();

        $this->load->view('head2', $data);
        $this->load->view('waqiahInput', $data);
        $this->load->view('foot');
    }

    public function input2()
    {
        // $data['userData'] = $this->Auth_model->current_user();
        $data['data'] = $this->db->query("SELECT *, COUNT(*) as jumlah FROM waqiah GROUP BY tanggal ORDER BY tanggal DESC")->result();

        $this->load->view('head2', $data);
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
    public function hapus_guru($id)
    {
        $data = $this->model->getBy('apel_guru', 'id', $id)->row();

        $this->model->hapus('apel_guru', 'tanggal', $data->tanggal);
        if ($this->db->affected_rows() > 1) {
            $this->session->set_flashdata('ok', 'Hapus data berhasil');
            redirect('pembiasaan/guru');
        } else {
            $this->session->set_flashdata('error', 'Hapus data gagal');
            redirect('pembiasaan/guru');
        }
    }

    public function rekap()
    {
        $this->load->view('rekap/rekap_pembiasaan_siswa');
    }

    public function loadRekapSiswa()
    {
        $hari_ini = date('Y-m-d');
        $awal = $this->db->query("SELECT a.*, b.nama, b.k_formal, b.r_formal, b.jurusan, b.foto FROM waqiah a JOIN tb_santri b ON a.nis=b.nis WHERE a.tanggal = '$hari_ini' ORDER BY a.hadir ASC LIMIT 1 ")->row();
        $akhir = $this->db->query("SELECT a.*, b.nama, b.k_formal, b.r_formal, b.jurusan, b.foto FROM waqiah a JOIN tb_santri b ON a.nis=b.nis WHERE a.tanggal = '$hari_ini' ORDER BY a.hadir DESC LIMIT 1 ")->row();

        echo json_encode([
            'status' => 'success',
            'awal' => $awal,
            'akhir' => $akhir,
        ]);
    }
}
