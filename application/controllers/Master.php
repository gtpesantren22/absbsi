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

    public function index() {}

    public function guru()
    {
        $data['guru'] = $this->model->getAll('guru')->result();

        $data['userData'] = $this->Auth_model->current_user();
        $this->load->view('head', $data);
        $this->load->view('guru', $data);
        $this->load->view('foot');
    }
    public function mapel()
    {
        $data['mapel'] = $this->model->getAll('mapel')->result();

        $data['userData'] = $this->Auth_model->current_user();
        $this->load->view('head', $data);
        $this->load->view('mapel', $data);
        $this->load->view('foot');
    }

    public function piket()
    {
        $data['mapel'] = $this->db->query("SELECT * FROM piket JOIN guru ON piket.guru=guru.kode_guru ORDER BY piket.hari ASC, piket.tempat ASC")->result();
        $data['guru'] = $this->model->getAll('guru');

        $data['userData'] = $this->Auth_model->current_user();
        $this->load->view('head', $data);
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


        $data['userData'] = $this->Auth_model->current_user();
        $this->load->view('head', $data);
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
            // $this->session->set_flashdata('ok', 'input Jadwal Berhasil');
            // redirect('master/jadwal');
            echo json_encode(['status' => 'success']);
        } else {
            // $this->session->set_flashdata('ok', 'input Jadwal Gagal');
            // redirect('master/jadwal');
            echo json_encode(['status' => 'error']);
        }
    }
    public function updateMapel()
    {
        $id_jadwal = $this->input->post('idjadwal', true);
        $data = [
            'hari' => $this->input->post('hari', true),
            'jam_dari' => $this->input->post('dari', true),
            'jam_sampai' => $this->input->post('sampai', true),
            'guru' => $this->input->post('guru', true),
            'mapel' => $this->input->post('mapel', true),
            'kelas' => $this->input->post('kelas', true),
        ];

        $this->model->edit('jadwal', $data, 'id_jadwal', $id_jadwal);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('ok', 'update Jadwal Berhasil');
            redirect('master/jadwal');
        } else {
            $this->session->set_flashdata('error', 'update Jadwal Gagal');
            redirect('master/jadwal');
        }
    }

    public function hapusJadwal()
    {
        $id = $this->input->post('idjadwal', true);
        $this->model->hapus('jadwal', 'id_jadwal', $id);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('ok', 'Hapus Jadwal Berhasil');
            redirect('master/jadwal');
        } else {
            $this->session->set_flashdata('error', 'Hapus Jadwal Gagal');
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
            $this->session->set_flashdata('error', 'Hapus Jadwal Piket Gagal');
            redirect('master/piket');
        }
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

        // kirim_group('085236924510', $psn);
        kirim_group('6285258800849-1471341787@g.us', $psn);
        redirect('master/jadwal');
    }

    public function guru_mapel()
    {
        $data['data'] = $this->db->query("SELECT guru_mapel.*, nama_guru, nama_mapel FROM guru_mapel JOIN guru ON guru_mapel.guru=guru.kode_guru JOIN mapel ON guru_mapel.mapel=mapel.kode_mapel ORDER BY guru.kode_guru ASC, guru_mapel.kode ASC")->result();
        $data['guru'] = $this->model->getAll('guru');
        $data['mapel'] = $this->model->getAll('mapel');

        $data['userData'] = $this->Auth_model->current_user();
        $this->load->view('head', $data);
        $this->load->view('guru_mapel', $data);
        $this->load->view('foot');
    }

    public function addGuruMapel()
    {
        $guru = $this->input->post('guru', true);
        $mapel = $this->input->post('mapel', true);
        $kode = $this->input->post('kode', true);
        $kodeOk = $guru . $kode;

        $cek = $this->model->getBy3('guru_mapel', 'guru', $guru, 'mapel', $mapel, 'kode', $kode)->row();
        if ($cek) {
            $this->session->set_flashdata('message', 'Data sudah ada');
            redirect('master/guru_mapel');
        } else {

            $data = [
                'guru' => $guru,
                'mapel' => $mapel,
                'kode' => $kode,
                'gabung' => $kodeOk
            ];
            $this->model->simpan('guru_mapel', $data);
            if ($this->db->affected_rows() > 0) {
                $this->session->set_flashdata('ok', 'Data berhasil ditambahkan');
                redirect('master/guru_mapel');
            } else {
                $this->session->set_flashdata('error', 'Data gagal ditambahkan');
                redirect('master/guru_mapel');
            }
        }
    }

    public function delgurumapel($id)
    {
        $this->model->hapus('guru_mapel', 'id_guma', $id);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('ok', 'Data berhasil dihapus');
            redirect('master/guru_mapel');
        } else {
            $this->session->set_flashdata('error', 'Data gagal dihapus');
            redirect('master/guru_mapel');
        }
    }

    public function updateGuru()
    {
        $kode_guru = $this->input->post('kode_guru', true);
        $nama_guru = $this->input->post('nama_guru', true);
        $no_hp = $this->input->post('no_hp', true);
        $warna = $this->input->post('warna', true);
        $data = [
            'kode_guru' => $kode_guru,
            'nama_guru' => $nama_guru,
            'no_hp' => $no_hp,
            'warna' => $warna,
        ];
        $this->model->edit('guru', $data, 'kode_guru', $kode_guru);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('ok', 'Data berhasil diubah');
            redirect('master/guru');
        } else {
            $this->session->set_flashdata('error', 'Data gagal diubah');
            redirect('master/guru');
        }
    }

    public function getgurumapel()
    {
        $kode_guru = $this->input->post('guru', true);
        $data = $this->db->query(
            "SELECT mapel.nama_mapel, guru_mapel.* FROM guru_mapel JOIN mapel ON guru_mapel.mapel=mapel.kode_mapel WHERE guru_mapel.guru = ?",
            array($kode_guru)
        )->result_array();
        if (!empty($data)) {
            echo json_encode($data);
        } else {
            // Jika tidak ada data, kirimkan array kosong
            echo json_encode([]);
        }
    }

    public function getMapel()
    {
        $this->load->view('jadwalview');
    }
}
