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

        $this->user = $user->nama;
        if (!$this->Auth_model->current_user() || $user->level != 'adm' && $user->level != 'admin') {
            redirect('login/logout');
        }
    }

    public function index()
    {
        $data['data'] = $this->model->getAbsensi();
        $data['bln'] = $this->bulan;

        $data['userData'] = $this->Auth_model->current_user();
        $this->load->view('head', $data);
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
            $absn = $this->db->query("SELECT *, SUM(sakit) AS sakitAll, SUM(izin) AS izinAll, SUM(alpha) AS alphaAll FROM harian WHERE tanggal >= '$dari' AND tanggal <= '$sampai' GROUP BY nis ")->result();

            foreach ($absn as $san) {

                $sakit = $absn ? $san->sakitAll : '0';
                $izin = $absn ? $san->izinAll : '0';
                $alpha = $absn ? $san->alphaAll  : '0';

                $dtsnt = [
                    'id_absen' => $id,
                    'nis' => $san->nis,
                    'kelas' => $san->kelas,
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

        $jmlSiswa = $this->model->getBy('tb_santri', 'aktif', 'Y')->num_rows();
        $rentang = explode(' s/d ', $data['detail']->row('rentang'));
        $dari = new DateTime($rentang[0]);
        $sampai = new DateTime($rentang[1]);
        $selisih = $dari->diff($sampai);
        $hari = $selisih->format('%a') + 1;
        $libur = $this->model->getBy2('libur', 'tanggal >=', $rentang[0], 'tanggal <=', $rentang[1])->num_rows();
        $hariEfektif = $hari - $libur;

        $dariOk = $dari->format('Y-m-d');
        $sampaiOk = $sampai->format('Y-m-d');
        $totalAbsen = ($hariEfektif * 8) * $jmlSiswa;

        $sakit = $this->db->query("SELECT SUM(sakit) as sakit FROM detail_absen WHERE id_absen = '$id' ")->row();
        $izin = $this->db->query("SELECT SUM(izin) as izin FROM detail_absen WHERE id_absen = '$id' ")->row();
        $alpha = $this->db->query("SELECT SUM(alpha) as alpha FROM detail_absen WHERE id_absen = '$id' ")->row();
        $hadir = $this->db->query("SELECT SUM((sampai-dari)+1) as hadir FROM harian WHERE alpha = 0 AND izin = 0 AND sakit = 0 AND tanggal >= '$dariOk' AND tanggal <= '$sampaiOk' ")->row();
        $tidak = $totalAbsen - ($sakit->sakit + $izin->izin + $alpha->alpha + $hadir->hadir);

        $data['sakit'] = round(($sakit->sakit / $totalAbsen) * 100, 1);
        $data['izin'] = round(($izin->izin / $totalAbsen) * 100, 1);
        $data['alpha'] = round(($alpha->alpha / $totalAbsen) * 100, 1);
        $data['hadir'] = round(($hadir->hadir / $totalAbsen) * 100, 1);
        $data['tidak'] = round(($tidak / $totalAbsen) * 100, 1);

        $data['bln'] = $this->bulan;

        $data['userData'] = $this->Auth_model->current_user();

        $this->load->view('head', $data);
        $this->load->view('absenDetail', $data);
        $this->load->view('foot');
    }

    public function input()
    {
        $data['data'] = $this->model->absenHarian();
        $data['bln'] = $this->bulan;

        $data['userData'] = $this->Auth_model->current_user();
        $this->load->view('head', $data);
        $this->load->view('absenHarian', $data);
        $this->load->view('foot');
    }

    public function inputHarian()
    {
        $data['bln'] = $this->bulan;
        $data['guru'] = $this->model->getAll('guru');
        $data['mapel'] = $this->model->getAll('mapel');
        $data['kelas'] = $this->model->getBy('kl_formal', 'lembaga', 'SMK');

        $data['userData'] = $this->Auth_model->current_user();
        $this->load->view('head', $data);
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

    public function inputGuru()
    {
        $thisDay = date('Y-m-d');
        $data['data'] = $this->db->query("SELECT * FROM harian_guru WHERE tanggal = '$thisDay' GROUP BY kelas ORDER BY kelas ASC ");

        $data['userData'] = $this->Auth_model->current_user();
        $this->load->view('head', $data);
        $this->load->view('absenGuru', $data);
        $this->load->view('foot');
    }

    public function generate()
    {
        $hariIni = date('l');
        $tglNow = date('Y-m-d');

        $cek = $this->model->getBy('harian_guru', 'tanggal', $tglNow);
        if ($cek->num_rows() > 0) {
            $this->session->set_flashdata('error', 'Maaf Absensi Hari ini sudah ada');
            redirect('absensi/inputGuru');
        } else {
            $jadwal = $this->model->getBy('jadwal', 'hari', 'Saturday')->result();

            foreach ($jadwal as $dataJadwal) {
                $jumlahJam = ($dataJadwal->jam_sampai - $dataJadwal->jam_dari) + 1;

                for ($i = 1; $i <= $jumlahJam; $i++) {
                    $data = [
                        'id_harian' => $this->uuid->v4(),
                        'tanggal' => $tglNow,
                        'kelas' => $dataJadwal->kelas,
                        'guru' => $dataJadwal->guru,
                        'mapel' => $dataJadwal->mapel,
                        'jam' => $dataJadwal->jam_dari + $i - 1,
                        'hadir' => 0,
                        'izin' => 0,
                        'petugas' => $this->user,
                        'at' => date('Y-m-d H:i:s'),
                    ];

                    $this->model->simpan('harian_guru', $data);
                    // echo "Data yang akan disimpan: ";
                    // print_r($data);
                    // echo "<br><br>";
                }
            }
        }
    }

    public function sendAbsen($kls, $id_absen)
    {
        $detail = $this->model->getBy2('detail_absen', 'kelas', $kls, 'id_absen', $id_absen);
        // $detail = $this->db->query("SELECT * FROM detail_absen WHERE id_absen = '$id_absen' LIMIT 1 ");
        $absen = $this->model->getBy('absensi', 'id_absen', $id_absen)->row();

        foreach ($detail->result() as $hasil) {
            $dtlS = $this->model->getBy('tb_santri', 'nis', $hasil->nis)->row();
            $kt = 'Alhamdulillah, Putra bpk/ibu mengikuti semua jam pelajaran dalam 1 minggu ini';

            if ($hasil->sakit == 0) {
                $sakit = 0;
            } else {
                if ($hasil->sakit % 8 == 0) {
                    $sakit = intval($hasil->sakit / 8) . ' hari';
                } else {
                    $sakit = intval($hasil->sakit / 8) . ' hari ' . ($hasil->sakit % 8) . ' jam';
                }
            }

            if ($hasil->izin == 0) {
                $izin = 0;
            } else {
                if ($hasil->izin % 8 == 0) {
                    $izin = intval($hasil->izin / 8) . ' hari';
                } else {
                    $izin = intval($hasil->izin / 8) . ' hari ' . ($hasil->izin % 8) . ' jam';
                }
            }

            if ($hasil->alpha == 0) {
                $alpha = 0;
            } else {
                if ($hasil->alpha % 8 == 0) {
                    $alpha = intval($hasil->alpha / 8) . ' hari';
                } else {
                    $alpha = intval($hasil->alpha / 8) . ' hari ' . ($hasil->alpha % 8) . ' jam';
                }
            }


            $psn = '*Assalamualaikum wr wb.*';
            $psn .= "\n" . "\n";
            $psn .= 'Yth Wali murid SMK Darul Lughah Wal Karomah,Rekap kehadiran siswa selama 1 minggu (Minggu ke-' . $absen->minggu . ') bulan ' . bulan($absen->bulan) . ' ' . $absen->tahun . ' kls ' . $kls . ' atas :';
            $psn .= "\n" . "\n";
            $psn .= 'Nama : ' . $dtlS->nama . "\n";
            $psn .= 'Sakit : ' . $sakit . "\n";
            $psn .= 'Izin : ' . $izin . "\n";
            $psn .= 'Alpha : ' . $alpha . "\n";
            $psn .=  $sakit == 0 && $izin == 0 && $alpha == 0 ? $kt : '';
            $psn .= "\n" . "\n";
            $psn .= '(Dalam 1 hari terdapat 8 jam pelajaran)' . "\n";
            $psn .= 'Atas Perhatanya kami ucapkan Termakasih.' . "\n" . "\n";
            $psn .= '*Wassalam Wr. Wb.*';
            $psn .= "\n" . "\n";
            $psn .= '_NB : Nomor ini hanya mengirimkan informasi. Jika ada pertanyaan atau lainnya bisa menghubungi Wali Kelas masing-masing siswa_' . "\n";

            // kirim_person('085236924510', $psn);
            kirim_person($dtlS->hp, $psn);
            // echo $psn . '<br>' . '<br>';
        }

        // redirect('absensi/detail/' . $id_absen);
    }

    public function libur()
    {
        $data['data'] = $this->model->getAllOrd('libur', 'tanggal', 'DESC');
        $data['bln'] = $this->bulan;

        $data['userData'] = $this->Auth_model->current_user();
        $this->load->view('head', $data);
        $this->load->view('libur', $data);
        $this->load->view('foot');
    }

    public function liburSave()
    {
        $dari = strtotime($this->input->post('dari', true));
        $sampai = strtotime($this->input->post('sampai', true));
        $ket = $this->input->post('ket', true);
        $pelaksana = $this->input->post('pelaksana', true);
        // $interval = $dari->diff($sampai);
        // $jmlHari = $interval->days;

        while ($dari <= $sampai) {
            $currentDate = date("Y-m-d", $dari);
            $dari = strtotime("+1 day", $dari);

            $data = [
                'tanggal' => $currentDate,
                'ket' => $ket,
                'pelaksana' => $pelaksana,
            ];

            $this->model->simpan('libur', $data);
        }

        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('ok', 'Simpan libur berhasil');
            redirect('absensi/libur');
        } else {
            $this->session->set_flashdata('ok', 'Simpan libur gagal');
            redirect('absensi/libur');
        }
    }

    public function delLibur($kode)
    {
        $this->model->hapus('libur', 'id_libur', $kode);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('ok', 'Hapus Data Libur Berhasil');
            redirect('absensi/libur');
        } else {
            $this->session->set_flashdata('ok', 'Hapus Data Libur Gagal');
            redirect('absensi/libur');
        }
    }
}
