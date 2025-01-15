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

        if ($user->kode_guru != '07' && $user->kode_guru != '11' && $user->kode_guru != '14' && $user->kode_guru != '13') {
            redirect('login/logout');
            // $this->cek = 'benar';
        } else {
            // $this->cek = 'salah';
        }
    }

    public function index()
    {
        $data['userData'] = $this->Auth_model->current_user();
        $data['data'] = $this->db->query("SELECT *, COUNT(*) as jumlah FROM mengajar GROUP BY tanggal ORDER BY tanggal DESC")->result();
        // $data['cek'] = $this->cek;

        $this->load->view('head', $data);
        $this->load->view('mengajar', $data);
        $this->load->view('foot');
    }
    public function input($id = null)
    {
        if ($id == null) {
            $harini = date('l');
            $tglni = date('Y-m-d');
        } else {
            $dataCari = $this->model->getBy('mengajar', 'id', $id)->row();
            $harini = date('l', strtotime($dataCari->tanggal));
            $tglni = $dataCari->tanggal;
        }


        $data['userData'] = $this->Auth_model->current_user();
        // $harini = 'Monday';
        $dataJadwal = $this->db->query("SELECT * FROM guru ORDER BY kode_guru ASC ")->result();
        $dataKirim = [];
        foreach ($dataJadwal as $key) {
            $hadir = $this->db->query("SELECT * FROM kehadiran WHERE tanggal = '$tglni' AND guru = '$key->kode_guru' ")->row();
            $jam = $this->db->query("SELECT * FROM jadwal WHERE hari = '$harini' AND guru = '$key->kode_guru' ")->result();
            $array_hasil = [];
            foreach ($jam as $datas) {
                $array_range = range($datas->jam_dari, $datas->jam_sampai);
                $array_hasil = array_merge($array_hasil, $array_range);
            }
            $dataKirim[] = [
                'guru' => $key->kode_guru,
                'hadir' => $hadir ? $hadir->ket : '',
                'nama_guru' => $key->nama_guru,
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
            $guru = $data['guru'];
            $jam = $data['jam'];
            $tanggal = date('Y-m-d');
            $ket = $data['value'];

            $cek = $this->model->getBy3('mengajar', 'guru', $guru, 'jam', $jam, 'tanggal', $tanggal)->row();
            if ($cek) {
                $this->db->where('guru', $guru);
                $this->db->where('jam', $jam);
                $this->db->where('tanggal', $tanggal);
                $this->db->update('mengajar', ['ket' => $ket]);
            } else {
                $simpan = [
                    'guru' => $guru,
                    'jam' =>  $jam,
                    'ket' =>  $ket,
                    'tanggal' =>  $tanggal,
                ];
                $this->model->simpan('mengajar', $simpan);
            }
        }

        echo json_encode(['status' => 'success']);
    }

    public function kehadiran()
    {
        $guru = $this->input->post('guru');
        $ket = $this->input->post('status');
        $tanggal = date('Y-m-d');
        $cek = $this->model->getBy2('kehadiran', 'guru', $guru, 'tanggal', $tanggal)->row();
        if ($cek) {
            $this->db->where('guru', $guru);
            $this->db->where('tanggal', $tanggal);
            $this->db->update('kehadiran', ['ket' => $ket]);

            echo json_encode(['status' => 'success']);
        } else {
            $simpan = [
                'guru' => $guru,
                'ket' =>  $ket,
                'tanggal' =>  $tanggal,
            ];
            $this->model->simpan('kehadiran', $simpan);
            echo json_encode(['status' => 'success']);
        }
    }

    public function rekap($id)
    {
        $data['userData'] = $this->Auth_model->current_user();
        $dataCari = $this->model->getBy('mengajar', 'id', $id)->row();
        $harini = date('l', strtotime($dataCari->tanggal));
        $tglni = $dataCari->tanggal;
        // $harini = 'Monday';
        $dataJadwal = $this->db->query("SELECT * FROM guru ORDER BY kode_guru ASC ");
        $dataKirim = [];
        $totalkehadiran = 0;
        $totaljamwajib = 0;
        $totaljammasuk = 0;
        foreach ($dataJadwal->result() as $key) {
            $hadir = $this->db->query("SELECT * FROM kehadiran WHERE tanggal = '$tglni' AND guru = '$key->kode_guru' ")->row();
            $jam = $this->db->query("SELECT SUM((jam_sampai-jam_dari)+1) as jmlJam FROM jadwal WHERE hari = '$harini' AND guru = '$key->kode_guru' ")->row();
            $masuk = $this->db->query("SELECT COUNT(*) as jmlJam FROM mengajar WHERE tanggal = '$tglni' AND guru = '$key->kode_guru' AND ket = 'H' ")->row();
            $jamwajib = $jam->jmlJam != 0 ? $jam->jmlJam : 0;
            $dataKirim[] = [
                'guru' => $key->kode_guru,
                'hadir' => $hadir ? $hadir->ket : '',
                'nama_guru' => $key->nama_guru,
                'jam' => $jamwajib,
                'masuk' => $masuk->jmlJam,
                'persen' => $jamwajib == 0 ? 0 : ($masuk->jmlJam / $jamwajib) * 100,
            ];
            $totalkehadiran += $hadir ? 1 : 0;
            $totaljamwajib += $jamwajib;
            $totaljammasuk += $masuk->jmlJam;
        }
        $data['data'] = $dataKirim;
        $data['hari'] = $harini;
        $data['tanggal'] = $tglni;
        $data['totalguru'] = $dataJadwal->num_rows();
        $data['totalkehadiran'] = $totalkehadiran;
        $data['totaljamwajib'] = $totaljamwajib;
        $data['totaljammasuk'] = $totaljammasuk;

        // echo '<pre>';
        // var_dump($dataKirim);
        // echo '</pre>';
        $this->load->view('head', $data);
        $this->load->view('mengajarRekap', $data);
        $this->load->view('foot');
    }

    public function hapus($id)
    {
        $dataCari = $this->model->getBy('mengajar', 'id', $id)->row();

        $this->model->hapus('mengajar', 'tanggal', $dataCari->tanggal);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('ok', 'Data berhasil dihapus');
            redirect('mengajar');
        } else {
            $this->session->set_flashdata('error', 'Data gagal dihapus');
            redirect('mengajar');
        }
    }
}
