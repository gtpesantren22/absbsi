<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SendInfoAutoCall extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Modeldata', 'model');
        $this->load->model('Auth_model');

        $this->bulan = array('', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');

        $user = $this->Auth_model->current_user();
    }

    public function sendMapel()
    {
        $days = date('l');

        $jadwal = $this->db->query("SELECT * FROM jadwal WHERE hari = '$days' GROUP BY guru");
        // $jadwal = $this->db->query("SELECT * FROM jadwal WHERE hari = '$days' AND guru = '15' GROUP BY guru");
        $piketPa = $this->db->query("SELECT * FROM piket JOIN guru ON piket.guru=guru.kode_guru WHERE hari = '$days' AND tempat = 'putra' ");
        $piketPi = $this->db->query("SELECT * FROM piket JOIN guru ON piket.guru=guru.kode_guru WHERE hari = '$days' AND tempat = 'putri' ");

        foreach ($jadwal->result() as $jdwl) {
            $jdlHasil = $this->db->query("SELECT * FROM jadwal WHERE hari = '$days' AND guru = '$jdwl->guru' ");
            $guru = $this->model->getBy('guru', 'kode_guru', $jdwl->guru)->row();

            $psn = 'Assalamualaikum Wr. Wb.
Kpd Yth. *' . $guru->nama_guru . '*

Berikut jadwal mengajar Ustd/Ustdh Hari ini *' . translateDay(date('l'), 'id') . ', ' . date('d-m-Y') . '* di SMK DWK : 
';
            foreach ($jdlHasil->result() as $jdlHsl) {
                $mapel = $this->model->getBy('mapel', 'kode_mapel', $jdlHsl->mapel)->row();
                $psn .= "\n" . '*Mapel : ' . $mapel->nama_mapel . "*\n";
                $psn .= '*Jam ke : ' . $jdlHsl->jam_dari . ' - ' . $jdlHsl->jam_sampai . "*\n";
                $psn .= '*Kelas : ' . $jdlHsl->kelas . "*\n";
            }

            $psn .= "\n";
            $psn .= 'Jika berhalangan hadir, silahkan konfirmasi kepada guru piket berikut :';
            $psn .= "\n";
            $psn .= "\n" . '*Piket Putra*' . "\n";
            foreach ($piketPa->result() as $value) {
                $psn .= '- ' . $value->nama_guru . "\n";
            }
            $psn .= "\n" . '*Piket Putri*' . "\n";
            foreach ($piketPi->result() as $value) {
                $psn .= '- ' . $value->nama_guru . "\n";
            }
            $psn .= "\n";
            $psn .= '_Atas perhatiannya kami sampaikan terimakasih_';

            kirim_person($guru->no_hp, $psn);
            // echo $psn;
            // echo '<br><br>';
        }
        redirect('master/jadwal');
    }
    public function sendMapelGroup()
    {
        $days = date('l');

        $jadwal = $this->db->query("SELECT * FROM jadwal WHERE hari = '$days' GROUP BY kelas ORDER BY kelas ASC");
        // $jadwal = $this->db->query("SELECT * FROM jadwal WHERE hari = '$days' AND guru = '15' GROUP BY guru");
        $piketPa = $this->db->query("SELECT * FROM piket JOIN guru ON piket.guru=guru.kode_guru WHERE hari = '$days' AND tempat = 'putra' ");
        $piketPi = $this->db->query("SELECT * FROM piket JOIN guru ON piket.guru=guru.kode_guru WHERE hari = '$days' AND tempat = 'putri' ");

        $psn = '*JADWAL PELAJARAN SMK DWK*
Hari *' . translateDay(date('l'), 'id') . ', ' . date('d-m-Y') . ':*
';
        foreach ($jadwal->result() as $jdwl) {
            $jdlHasil = $this->db->query("SELECT * FROM jadwal WHERE hari = '$days' AND kelas = '$jdwl->kelas' ORDER BY jam_dari ASC ");

            $psn .= "\n";
            $psn .= '*' . $jdwl->kelas . '*' . "\n";
            foreach ($jdlHasil->result() as $jdlHsl) {
                $guru = $this->model->getBy('guru', 'kode_guru', $jdlHsl->guru)->row();
                $mapel = $this->model->getBy('mapel', 'kode_mapel', $jdlHsl->mapel)->row();
                $psn .= $jdlHsl->jam_dari . '-' . $jdlHsl->jam_sampai . ' : ' . $guru->nama_guru . ' _(' . $mapel->nama_mapel . ")_\n";
                // $psn .= '*Jam ke : ' . $jdlHsl->jam_dari . ' - ' . $jdlHsl->jam_sampai . "*\n";
                // $psn .= '*Kelas : ' . $jdlHsl->kelas . "*\n";
            }
        }

        $psn .= "\n";
        $psn .= "\n" . '*Piket Putra*' . "\n";
        foreach ($piketPa->result() as $value) {
            $psn .= '- ' . $value->nama_guru . "\n";
        }
        $psn .= "\n" . '*Piket Putri*' . "\n";
        foreach ($piketPi->result() as $value) {
            $psn .= '- ' . $value->nama_guru . "\n";
        }

        $psn .= "\n" . '_NB: Mohon kepada Guru yang memiliki jam mengajar untuk hadir tepat waktu minimal 10 menit sebelum KBM berlangsung. Dan bagi guru yang tidak bisa Hadir kesekolah diminta untuk konfirmasi dan menitipkan tugas Group Sekolah._';
        $psn .= "\n" . "\n" . 'Atas Perhatian dan kerjasamanya kami sampaikan terimakasih';
        $psn .= "\n" . '----------------------------------';
        $psn .= "\n" . "\n" . 'Semangat Mengabdi💪 Barokalloh🤲';

        kirim_group('085236924510', $psn);
        // kirim_group('6285258800849-1471341787@g.us', $psn);
        redirect('master/jadwal');
    }
}
