<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laptop extends CI_Controller
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
        $data['jenis'] = $this->model->getBy('settings', 'namaset', 'jenis_absen')->row();
        $data['data'] = $this->db->query("SELECT *, COUNT(*) as jumlah FROM waqiah GROUP BY tanggal ORDER BY tanggal DESC")->result();

        // $this->load->view('head', $data);
        $this->load->view('laptop', $data);
        // $this->load->view('foot');
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
        $tanggal = $this->input->post('tanggal', TRUE);

        $data = $this->db->query("SELECT laptop.*, tb_santri.nama, tb_santri.k_formal, tb_santri.jurusan, tb_santri.r_formal FROM laptop JOIN tb_santri ON laptop.nis=tb_santri.nis WHERE laptop.tanggal = '$tanggal' ORDER BY laptop.id DESC ")->result();

        echo json_encode($data);
    }

    public function addAbsens()
    {
        $tanggal = $this->input->post('tanggal', TRUE);
        $nis = $this->input->post('nis', TRUE);
        $jenis = $this->model->getBy('settings', 'namaset', 'jenis_absen')->row('isi');

        $cek = $this->db->query("SELECT * FROM laptop WHERE nis = $nis AND tanggal = '$tanggal' AND $jenis != '' ")->row();
        if ($cek) {
            echo json_encode(['status' => 'sudah', 'message' => 'siswa sudah absen']);
        } else {
            $ceksiswa = $this->model->getBy('tb_santri', 'nis', $nis)->row();
            if ($ceksiswa) {
                $waktu = date('H:i:s');
                if ($jenis == 'ambil') {
                    $dataInput = [
                        'nis' => $nis,
                        'tanggal' => $tanggal,
                        'ambil' => $waktu,
                    ];
                    $this->model->simpan('laptop', $dataInput);
                } else {
                    $cek = $this->db->query("SELECT * FROM laptop WHERE nis = $nis AND tanggal = '$tanggal' ")->row();
                    if (!$cek) {
                        echo json_encode(['status' => 'not_found', 'message' => 'Belum absen pengambilan']);
                        die();
                    } else {
                        $this->db->query("UPDATE laptop SET kembali = '$waktu' WHERE nis = $nis AND tanggal = '$tanggal' ");
                    }
                }

                if ($this->db->affected_rows() > 0) {
                    echo json_encode([
                        'status' => 'ok',
                        'message' => 'absensi berhasil',
                        'nama' => $ceksiswa->nama,
                        'kelas' => $ceksiswa->k_formal . ' ' . $ceksiswa->jurusan . ' ' . $ceksiswa->r_formal,
                        'waktu' => $waktu,
                        'nis' => $nis,
                        'jenis' => $jenis,
                    ]);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'absensi gagal']);
                }
            } else {
                echo json_encode(['status' => 'not_found', 'message' => 'Siswa tidak terdaftar']);
            }
        }
    }

    public function loadJumlah()
    {
        $tanggal = $this->input->post('tanggal', TRUE);
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

    public function gantiSesi()
    {
        $jenis = $this->model->getBy('settings', 'namaset', 'jenis_absen')->row();
        $sesi = $jenis->isi == 'ambil' ? 'kembali' : 'ambil';
        $this->model->edit('settings', ['isi' => $sesi], 'namaset', 'jenis_absen');
        if ($this->db->affected_rows() > 1) {
            $this->session->set_flashdata('ok', 'Ganti sesi berhasil');
            redirect('laptop');
        } else {
            $this->session->set_flashdata('error', 'Ganti sesi gagal');
            redirect('laptop');
        }
    }
}
