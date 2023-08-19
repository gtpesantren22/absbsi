<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Absensi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Modeldata', 'model');
        $this->load->model('Auth_model');

        $this->bulan = array('', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');

        $user = $this->Auth_model->current_user();

        if (!$this->Auth_model->current_user() || $user->level != 'adm' && $user->level != 'admin') {
            redirect('login/logout');
        }
    }

    public function index()
    {
        $data['data'] = $this->model->getAbsensi();
        $data['bln'] = $this->bulan;

        $this->load->view('head');
        $this->load->view('absen', $data);
        $this->load->view('foot');
    }

    public function buat()
    {
        $minggu = $this->input->post('minggu', true);
        $bulan = $this->input->post('bulan', true);
        $tahun = $this->input->post('tahun', true);
        $rentang = $this->input->post('rentang', true);
        $id = $this->uuid->v4();

        $rtm = explode(' s/d ', $rentang);
        $dari = $rtm[0];
        $sampai = $rtm[1];

        $data = [
            'id_absen' => $id,
            'tanggal' => date('Y-m-d'),
            'minggu' => $minggu,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'rentang' => $rentang,
            'at' => date('Y-m-d H:i:s'),
        ];

        $this->model->simpan('absensi', $data);
        if ($this->db->affected_rows() > 0) {

            // $dsan = $this->model->getAll('tb_santri')->result();
            $absn = $this->db->query("SELECT *, SUM(sakit) AS sakitAll, SUM(izin) AS izinAll, SUM(alpha) AS alphaAll FROM harian WHERE tanggal BETWEEN '$dari' AND '$sampai' GROUP BY nis ")->result();

            foreach ($absn as $san) {

                $sakit = $absn ? $san->sakitAll : '0';
                $izin = $absn ? $san->izinAll : '0';
                $alpha = $absn ? $san->alphaAll  : '0';

                $dtsnt = [
                    'id_absen' => $id,
                    'nis' => $san->nis,
                    'sakit' => $sakit,
                    'izin' => $izin,
                    'alpha' => $alpha,
                ];

                $this->model->simpan('detail_absen', $dtsnt);
            }

            if ($this->db->affected_rows() > 0) {
                $this->session->set_flashdata('ok', 'Rekap Absen Berhasil');
                redirect('absensi/detail/' . $id);
            } else {
                $this->session->set_flashdata('error', 'Rekap Absen Gagal');
                redirect('absensi');
            }
        }
    }

    public function detail($id)
    {
        $data['data'] = $this->model->absenDetail($id);
        $data['detail'] = $this->model->getBy('absensi', 'id_absen', $id);
        $data['kelas'] = $this->model->getBy('kl_formal', 'lembaga', 'SMK');

        $data['bln'] = $this->bulan;

        $this->load->view('head');
        $this->load->view('absenDetail', $data);
        $this->load->view('foot');
    }

    public function input()
    {
        $data['data'] = $this->model->absenHarian();
        $data['bln'] = $this->bulan;

        $this->load->view('head');
        $this->load->view('absenHarian', $data);
        $this->load->view('foot');
    }

    public function inputHarian()
    {
        $data['bln'] = $this->bulan;
        $data['guru'] = $this->model->getAll('guru');
        $data['mapel'] = $this->model->getAll('mapel');
        $data['kelas'] = $this->model->getBy('kl_formal', 'lembaga', 'SMK');

        $this->load->view('head');
        $this->load->view('inputHarian', $data);
        $this->load->view('foot');
    }

    public function cariKelas()
    {
        $kls = explode('-', $this->input->post('dppk', true));

        $kelas = $kls[0];
        $jur = $kls[1];
        $rombel = $kls[2];

        $data['listdata'] = $this->model->getBy3Ord('tb_santri', 'k_formal', $kelas, 'r_formal', $rombel, 'jurusan', $jur, 'nama', 'ASC');

        $this->load->view('listdata', $data);
    }

    public function save_multiple_data()
    {
        $guru = $this->input->post('guru', true);
        $mapel = $this->input->post('mapel', true);
        $dari = $this->input->post('dari', true);
        $sampai = $this->input->post('sampai', true);
        $data = $this->input->post('data', true);
        $kelas = $this->input->post('kelas', true);
        $kode = $this->uuid->v4();

        $jmlAbs = ($sampai - $dari) + 1;

        if (!empty($data)) {
            foreach ($data as $item) {

                if ($item['ket'] == 'alpha') {
                    $sakit = 0;
                    $izin = 0;
                    $alpha = $jmlAbs;
                } elseif ($item['ket'] == 'sakit') {
                    $sakit = $jmlAbs;
                    $izin = 0;
                    $alpha = 0;
                } elseif ($item['ket'] == 'izin') {
                    $sakit = 0;
                    $izin = $jmlAbs;
                    $alpha = 0;
                } else {
                    $sakit = 0;
                    $izin = 0;
                    $alpha = 0;
                }

                $dtsm = [
                    'kode' => $kode,
                    'tanggal' => date('Y-m-d'),
                    'kelas' => $kelas,
                    'mapel' => $mapel,
                    'guru' => $guru,
                    'dari' => $dari,
                    'sampai' => $sampai,
                    'nis' => $item['nis'],
                    'ket' => $item['ket'],
                    'sakit' => $sakit,
                    'izin' => $izin,
                    'alpha' => $alpha,
                ];
                $this->model->simpan('harian', $dtsm);
            }

            if ($this->db->affected_rows() > 0) {
                $this->session->set_flashdata('ok', 'Input Absen Berhasil');
                redirect('absensi/input');
            } else {
                $this->session->set_flashdata('error', 'Input Absen Gagal');
                redirect('absensi/input');
            }
        }
    }

    public function hapusHarian($kode)
    {
        $this->model->hapus('harian', 'kode', $kode);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('ok', 'Hapus Absen Berhasil');
            redirect('absensi/input');
        } else {
            $this->session->set_flashdata('ok', 'Hapus Absen Gagal');
            redirect('absensi/input');
        }
    }

    public function delAbsen($id)
    {
        $this->model->hapus('absensi', 'id_absen', $id);
        $this->model->hapus('detail_absen', 'id_absen', $id);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('ok', 'Hapus Absen Berhasil');
            redirect('absensi');
        } else {
            $this->session->set_flashdata('ok', 'Hapus Absen Gagal');
            redirect('absensi');
        }
    }
}
