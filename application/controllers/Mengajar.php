<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mengajar extends CI_Controller
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
        $data['data'] = $this->db->query("SELECT *, COUNT(*) as jumlah FROM mengajar GROUP BY tanggal ORDER BY tanggal DESC")->result();

        $this->load->view('head', $data);
        $this->load->view('mengajar', $data);
        $this->load->view('foot');
    }
    public function input()
    {
        $data['userData'] = $this->Auth_model->current_user();
        $harini = date('l');
        // $harini = 'Monday';
        $dataJadwal = $this->db->query("SELECT * FROM jadwal WHERE hari = '$harini' GROUP BY guru ORDER BY guru ASC ")->result();
        $dataKirim = [];
        foreach ($dataJadwal as $key) {
            $guru = $this->model->getBy('guru', 'kode_guru', $key->guru)->row();
            $mapel = $this->model->getBy('mapel', 'kode_mapel', $key->mapel)->row();
            $jam = $this->db->query("SELECT * FROM jadwal WHERE hari = '$harini' AND guru = '$key->guru' ")->result();
            $array_hasil = [];
            foreach ($jam as $datas) {
                $array_range = range($datas->jam_dari, $datas->jam_sampai);
                $array_hasil = array_merge($array_hasil, $array_range);
            }
            $dataKirim[] = [
                'id_jadwal' => $key->id_jadwal,
                'guru' => $key->guru,
                'kelas' => $key->kelas,
                'nama_guru' => $guru->nama_guru,
                'nama_mapel' => $mapel->nama_mapel,
                'jam' => $array_hasil,
            ];
        }
        $data['data'] = $dataKirim;

        // echo '<pre>';
        // var_dump($dataKirim);
        // echo '</pre>';
        $this->load->view('head', $data);
        $this->load->view('mengajarInput', $data);
        $this->load->view('foot');
    }

    public function cekGuru()
    {
        $kdguru = $this->input->post('guru');

        $data['guru'] = $this->model->getBy('guru', 'kode_guru', $kdguru)->row();
        $harini = date('l');

        // $mapel = $this->model->getBy('mapel', 'kode_mapel', $key->mapel)->row();
        $data['jadwal'] = $this->db->query("SELECT * FROM jadwal WHERE hari = '$harini' AND guru = '$kdguru' ORDER BY jam_dari ASC ")->result();
        $array_hasil = [];
        foreach ($data['jadwal'] as $datas) {
            $array_range = range($datas->jam_dari, $datas->jam_sampai);
            $array_hasil = array_merge($array_hasil, $array_range);
        }

        $data['jam'] = $array_hasil;

        $this->load->view('tampilMengajar', $data);
    }

    public function simpanJam()
    {
        $datas = $this->input->post('datas');

        foreach ($datas as $data) {
            $simpan = [
                'guru' => $data['guru'],
                'jam' =>  $data['jam'],
                'ket' =>  $data['value'],
                'tanggal' =>  date('Y-m-d'),
            ];

            // Simpan data ke database
            $this->model->simpan('mengajar', $simpan);
        }

        echo json_encode(['status' => 'success']);
    }
}
