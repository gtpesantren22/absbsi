<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Guru extends CI_Controller
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

        if ((!$this->Auth_model->current_user() && $user->level != 'guru') || (!$this->Auth_model->current_user() && $user->level != 'admin')) {
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

    public function absenSiswa()
    {
        $data['bln'] = $this->bulan;
        $data['user'] = $this->user;

        $data['guru'] = $this->model->getAll('guru');
        $data['mapel'] = $this->model->getAll('mapel');

        $isDay = date('l');
        $data['kelas'] = $this->db->query("SELECT * FROM jadwal WHERE hari = '$isDay' AND guru = '$this->userKode' ORDER BY jam_dari ASC ");

        $data['userData'] = $this->Auth_model->current_user();
        $this->load->view('head', $data);
        $this->load->view('jurnalGuru', $data);
        $this->load->view('foot');
    }

    public function cariKelas()
    {
        $idJadwal = $this->input->post('dppk', true);
        $data['jadwal'] = $this->model->getBy('jadwal', 'id_jadwal', $idJadwal)->row();

        $kls = explode('-', $data['jadwal']->kelas);

        $kelas = $kls[0];
        $jur = $kls[1];
        $rombel = $kls[2];

        $dyas = date('l');

        $data['listdata'] = $this->model->getBy3Ord('tb_santri', 'k_formal', $kelas, 'r_formal', $rombel, 'jurusan', $jur, 'nama', 'ASC');
        $data['mapel'] = $this->model->getBy('mapel', 'kode_mapel', $data['jadwal']->mapel)->row();

        $this->load->view('listdata', $data);

        // var_dump($data['mapel']);
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
        $tanggal = date('Y-m-d');

        $jmlAbs = ($sampai - $dari) + 1;

        $cek = $this->model->getBy5('harian', 'guru', $guru, 'mapel', $mapel, 'kelas', $kelas, 'tanggal', $tanggal, 'dari', $dari)->row();

        $nmGuru = $this->model->getBy('guru', 'kode_guru', $guru)->row();
        $nmMapel = $this->model->getBy('mapel', 'kode_mapel', $mapel)->row();

        if ($cek) {
            $this->session->set_flashdata('error', 'Absensi sudah ada. Jika ada kelasahan silahkan dihapus atau diupdate kembali');
            redirect('guru/absenSiswa');
        } else {
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
                        'tanggal' => $tanggal,
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

                    $hadirHsl = $this->model->getBy2('harian', 'ket', 'hadir', 'kode', $kode);
                    $sakitHsl = $this->db->query("SELECT harian.*, tb_santri.nama FROM harian JOIN tb_santri ON tb_santri.nis=harian.nis WHERE harian.ket= 'sakit' AND harian.kode = '$kode'");
                    $izinHsl = $this->db->query("SELECT harian.*, tb_santri.nama FROM harian JOIN tb_santri ON tb_santri.nis=harian.nis WHERE harian.ket= 'izin' AND harian.kode = '$kode'");
                    $alphaHsl = $this->db->query("SELECT harian.*, tb_santri.nama FROM harian JOIN tb_santri ON tb_santri.nis=harian.nis WHERE harian.ket= 'alpha' AND harian.kode = '$kode'");

                    $psn = '*LAPORAN KEHADIRAN SISWA*
*' . translateDay(date('l'), 'id') . ', ' . date('d-m-Y') . '*

Guru : ' . $nmGuru->nama_guru . '
Mapel : ' . $nmMapel->nama_mapel . '
Kelas : ' . $kelas . '
Jam ke : ' . $dari . ' - ' . $sampai . '

*Sakit*
';
                    foreach ($sakitHsl->result() as $skt) {
                        $psn .= '- ' . $skt->nama . "\n";
                    }
                    $psn .= "\n" . '*Izin*' . "\n";
                    foreach ($izinHsl->result() as $izn) {
                        $psn .= '- ' . $izn->nama . "\n";
                    }
                    $psn .= "\n" . '*Alpha*' . "\n";
                    foreach ($alphaHsl->result() as $alp) {
                        $psn .= '- ' . $alp->nama . "\n";
                    }

                    $psn .= "\n" . '*Hadir :*' . "\n" . $hadirHsl->num_rows() . ' siswa';
                    $psn .= "\n" . "\n" . '_Demikian Laporan ini kami sampaikan terimakasih_';

                    // echo $psn;
                    kirim_person('085236924510', $psn);
                    // kirim_group('6285258800849-1471341787@g.us', $psn);

                    $this->session->set_flashdata('ok', 'Input Absen Berhasil');
                    redirect('guru/absenSiswa');
                } else {
                    $this->session->set_flashdata('error', 'Input Absen Gagal');
                    redirect('guru/absenSiswa');
                }
            }
        }
    }

    public function hasilAbsen()
    {
        $data['data'] = $this->model->absenHarianDay($this->userKode);
        $data['bln'] = $this->bulan;

        $data['userData'] = $this->Auth_model->current_user();
        $this->load->view('head', $data);
        $this->load->view('hasilAbsen', $data);
        $this->load->view('foot');
    }

    public function hapusHarian($kode)
    {
        $this->model->hapus('harian', 'kode', $kode);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('ok', 'Hapus Absen Berhasil');
            redirect('guru/hasilAbsen');
        } else {
            $this->session->set_flashdata('ok', 'Hapus Absen Gagal');
            redirect('guru/hasilAbsen');
        }
    }

    public function editHarian($kode)
    {
        $data['listdata'] = $this->db->query("SELECT *, tb_santri.nama FROM harian JOIN tb_santri ON tb_santri.nis=harian.nis WHERE kode = '$kode' ORDER BY tb_santri.nama ASC ");

        $data['jadwal'] = $this->db->query("SELECT * FROM harian JOIN guru ON guru.kode_guru=harian.guru JOIN mapel ON mapel.kode_mapel=harian.mapel WHERE kode = '$kode' GROUP BY kode ")->row();

        $data['userData'] = $this->Auth_model->current_user();
        $this->load->view('head', $data);
        $this->load->view('editJurnalGuru', $data);
        $this->load->view('foot');
    }

    public function update_multiple_data()
    {

        $dari = $this->input->post('dari', true);
        $sampai = $this->input->post('sampai', true);
        $data = $this->input->post('data', true);
        $kode = $this->input->post('kode', true);

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
                    'ket' => $item['ket'],
                    'sakit' => $sakit,
                    'izin' => $izin,
                    'alpha' => $alpha,
                ];
                $this->model->edit('harian', $dtsm, 'id_harian', $item['id']);
            }

            if ($this->db->affected_rows() > 0) {

                $this->session->set_flashdata('ok', 'Update Absen Berhasil');
                redirect('guru/editHarian/' . $kode);
            } else {
                $this->session->set_flashdata('error', 'Update Absen Gagal');
                redirect('guru/editHarian/' . $kode);
            }
        }
    }
}
