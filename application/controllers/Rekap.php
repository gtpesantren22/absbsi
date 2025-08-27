<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rekap extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        $this->load->model('Modeldata', 'model');
    }

    public function mengajar()
    {
        $hari_ini = date('Y-m-d');
        // $hari_ini = date('2025-01-07');
        $dataCari = $this->model->getBy('mengajar', 'tanggal', $hari_ini)->row();
        if ($dataCari) {
            $harini = date('l', strtotime($dataCari->tanggal));
            $tglni = $dataCari->tanggal;
        } else {
            $harini = date('l', strtotime($hari_ini));
            $tglni = $hari_ini;
        }

        // $harini = 'Monday';
        $dataJadwal = $this->db->query("SELECT * FROM kehadiran WHERE tanggal = '$tglni' ORDER BY guru ASC ");
        $dataKirim = [];
        $totalkehadiran = 0;
        $totaljamwajib = 0;
        $totaljammasuk = 0;
        foreach ($dataJadwal->result() as $key) {
            $hadir = $this->db->query("SELECT * FROM kehadiran WHERE tanggal = '$tglni' AND guru = '$key->guru' ")->row();
            $guru = $this->db->query("SELECT nama_guru FROM guru WHERE kode_guru = '$key->guru' ")->row();
            // $jam = $this->db->query("SELECT SUM((jam_sampai-jam_dari)+1) as jmlJam FROM jadwal WHERE hari = '$harini' AND guru = '$key->guru' ")->row();
            $jam = $this->db->query("SELECT COUNT(*) as jmlJam FROM mengajar WHERE tanggal = '$tglni' AND guru = '$key->guru' ")->row();
            $masuk = $this->db->query("SELECT COUNT(*) as jmlJam FROM mengajar WHERE tanggal = '$tglni' AND guru = '$key->guru' AND ket = 'H' ")->row();
            $alasan = $this->db->query("SELECT * FROM mengajar WHERE tanggal = '$tglni' AND guru = '$key->guru' AND alasan != '-' ")->row();
            $jamwajib = $jam->jmlJam != 0 ? $jam->jmlJam : 0;
            $dataKirim[] = [
                'guru' => $key->guru,
                'hadir' => $hadir ? $hadir->ket : '',
                'nama_guru' => $guru->nama_guru,
                'jam' => $jamwajib,
                'masuk' => $masuk->jmlJam,
                'persen' => $jamwajib == 0 ? 0 : ($masuk->jmlJam / $jamwajib) * 100,
                'alasan' => $alasan ? $alasan->alasan : '-',
            ];
            $totalkehadiran += $hadir && $hadir->ket == 1 ? 1 : 0;
            $totaljamwajib += $jamwajib;
            $totaljammasuk += $masuk->jmlJam;
        }
        $data['data'] = $dataKirim;
        $data['hari'] = translateDay($harini, 'id');
        $data['tanggal'] = $tglni;
        $data['totalguru'] = $dataJadwal->num_rows();
        $data['totalkehadiran'] = $totalkehadiran;
        $data['totaljamwajib'] = $totaljamwajib;
        $data['totaljammasuk'] = $totaljammasuk;

        // echo '<pre>';
        // var_dump($dataKirim);
        // echo '</pre>';

        $this->load->view('rekap/mengajar', $data);
    }

    public function apel_guru()
    {
        $hari_ini = date('Y-m-d');
        // $hari_ini = date('2025-01-07');
        $dataCari = $this->model->getBy('apel_guru', 'tanggal', $hari_ini)->row();
        if ($dataCari) {
            $harini = date('l', strtotime($dataCari->tanggal));
            $tglni = $dataCari->tanggal;
        } else {
            $harini = date('l', strtotime($hari_ini));
            $tglni = $hari_ini;
        }

        $dataJadwal = $this->db->query("SELECT a.*, b.nama_guru FROM apel_guru a JOIN guru b ON a.kode_guru=b.kode_guru WHERE a.tanggal = '$tglni' ORDER BY a.kode_guru ASC ");
        $data['hadir'] = $this->db->query("SELECT COUNT(*) as ttl FROM apel_guru WHERE tanggal = '$tglni' AND ket = 'hadir' ")->row();
        $data['izin'] = $this->db->query("SELECT COUNT(*) as ttl FROM apel_guru WHERE tanggal = '$tglni' AND ket = 'izin' ")->row();
        $data['alpha'] = $this->db->query("SELECT COUNT(*) as ttl FROM apel_guru WHERE tanggal = '$tglni' AND ket = 'alpha' ")->row();

        $data['data'] = $dataJadwal->result();
        $data['hari'] = translateDay($harini, 'id');
        $data['tanggal'] = $tglni;


        $this->load->view('rekap/apel_guru', $data);
    }
}
