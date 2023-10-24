<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kepala extends CI_Controller
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

        if ((!$this->Auth_model->current_user() && $user->level != 'kepala') || (!$this->Auth_model->current_user() && $user->level != 'admin')) {
            redirect('login/logout');
        }
    }

    public function index()
    {
        $data['userData'] = $this->Auth_model->current_user();

        $data['jadwal'] = $this->model->getBy2Ord('jadwal', 'hari', date('l'), 'guru', $this->userKode, 'jam_dari', 'ASC');

        $this->load->view('head', $data);
        $this->load->view('indexGuru');
        $this->load->view('foot');
    }

    public function kontrolAbsen()
    {
        $data['userData'] = $this->Auth_model->current_user();
        $days = date('l');

        $data['jadwal'] = $this->db->query("SELECT * FROM jadwal WHERE hari = '$days' GROUP BY kelas ORDER BY kelas ASC ");
        $data['piket'] = $this->db->query("SELECT * FROM piket WHERE hari = '$days' AND guru = '$this->userKode' ");

        $this->load->view('head', $data);
        $this->load->view('kontrol');
        $this->load->view('foot');
    }

    public function hasilAbsen()
    {
        $data['data'] = $this->model->absenHarian();
        $data['bln'] = $this->bulan;

        $data['userData'] = $this->Auth_model->current_user();
        $this->load->view('head', $data);
        $this->load->view('hasilAbsen', $data);
        $this->load->view('foot');
    }
    public function hasilAbsenDay()
    {
        $data['data'] = $this->model->absenHariIni();
        $data['bln'] = $this->bulan;

        $data['userData'] = $this->Auth_model->current_user();
        $this->load->view('head', $data);
        $this->load->view('hasilAbsen', $data);
        $this->load->view('foot');
    }

    public function detailHarian($kode)
    {
        $data['listdata'] = $this->db->query("SELECT *, tb_santri.nama FROM harian JOIN tb_santri ON tb_santri.nis=harian.nis WHERE kode = '$kode' ORDER BY tb_santri.nama ASC ");

        $data['jadwal'] = $this->db->query("SELECT * FROM harian JOIN guru ON guru.kode_guru=harian.guru JOIN mapel ON mapel.kode_mapel=harian.mapel WHERE kode = '$kode' GROUP BY kode ")->row();

        $data['userData'] = $this->Auth_model->current_user();
        $this->load->view('head', $data);
        $this->load->view('detailJurnalGuru', $data);
        $this->load->view('foot');
    }

    public function rekap()
    {
        $data['data'] = $this->model->getAbsensi();
        $data['bln'] = $this->bulan;

        $data['userData'] = $this->Auth_model->current_user();
        $this->load->view('head', $data);
        $this->load->view('absenKep', $data);
        $this->load->view('foot');
    }

    public function detail($id)
    {
        $data['data'] = $this->model->absenDetail($id);
        $data['detail'] = $this->model->getBy('absensi', 'id_absen', $id);
        $data['kelas'] = $this->model->getByOrd('kl_formal', 'lembaga', 'SMK', 'nm_kelas', 'ASC');

        $jmlSiswa = $this->model->getBy('tb_santri', 'aktif', 'Y')->num_rows();
        $rentang = explode(' s/d ', $data['detail']->row('rentang'));
        $dari = new DateTime($rentang[0]);
        $sampai = new DateTime($rentang[1]);
        $selisih = $dari->diff($sampai);
        $hari = $selisih->format('%a');

        $dariOk = $dari->format('Y-m-d');
        $sampaiOk = $sampai->format('Y-m-d');
        $totalAbsen = ($hari * 8) * $jmlSiswa;

        $data['id'] = $id;
        $data['dariOk'] = $dariOk;
        $data['sampaiOk'] = $sampaiOk;
        $data['hari'] = $hari;


        $sakit = $this->db->query("SELECT SUM(sakit) as sakit FROM detail_absen WHERE id_absen = '$id' ")->row();
        $izin = $this->db->query("SELECT SUM(izin) as izin FROM detail_absen WHERE id_absen = '$id' ")->row();
        $alpha = $this->db->query("SELECT SUM(alpha) as alpha FROM detail_absen WHERE id_absen = '$id' ")->row();
        $hadir = $this->db->query("SELECT SUM((sampai-dari)+1) as hadir FROM harian WHERE alpha = 0 AND izin = 0 AND sakit = 0 AND tanggal BETWEEN '$dariOk' AND '$sampaiOk' ")->row();
        $tidak = $totalAbsen - ($sakit->sakit + $izin->izin + $alpha->alpha + $hadir->hadir);

        $data['sakit'] = round(($sakit->sakit / $totalAbsen) * 100, 1);
        $data['izin'] = round(($izin->izin / $totalAbsen) * 100, 1);
        $data['alpha'] = round(($alpha->alpha / $totalAbsen) * 100, 1);
        $data['hadir'] = round(($hadir->hadir / $totalAbsen) * 100, 1);
        $data['tidak'] = round(($tidak / $totalAbsen) * 100, 1);

        $data['bln'] = $this->bulan;

        $data['userData'] = $this->Auth_model->current_user();
        $this->load->view('head', $data);
        $this->load->view('absenDetailKep', $data);
        $this->load->view('foot');
    }
}
