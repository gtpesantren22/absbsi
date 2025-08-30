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

        if (!$user) {
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
        $this->load->view('mengajar/mengajar', $data);
        $this->load->view('foot');
    }
    public function input($id = null)
    {
        if ($id == null) {
            $harini = date('l');
            $tglni = date('Y-m-d');

            $cek = $this->model->getBy('kehadiran', 'tanggal', $tglni)->row();
            if (!$cek) {
                $dataguru = $this->model->getAll('guru')->result();
                foreach ($dataguru as $data) {
                    $instdata = ['guru' => $data->kode_guru, 'tanggal' => $tglni, 'ket' => 0];
                    $this->model->simpan('kehadiran', $instdata);
                }
                redirect('mengajar/input');
            }
        } else {
            $dataCari = $this->model->getBy('mengajar', 'id', $id)->row();
            $harini = date('l', strtotime($dataCari->tanggal));
            $tglni = $dataCari->tanggal;
        }


        $data['userData'] = $this->Auth_model->current_user();
        // $harini = 'Monday';
        $dataJadwal = $this->db->query("SELECT * FROM kehadiran WHERE tanggal = '$tglni' ORDER BY guru ASC ")->result();
        $dataKirim = [];
        foreach ($dataJadwal as $key) {
            $hadir = $this->db->query("SELECT * FROM kehadiran WHERE tanggal = '$tglni' AND guru = '$key->guru' ")->row();
            $jam = $this->db->query("SELECT * FROM jadwal WHERE hari = '$harini' AND guru = '$key->guru' ")->result();
            $guru = $this->db->query("SELECT nama_guru FROM guru WHERE kode_guru = '$key->guru' ")->row();
            $array_hasil = [];
            foreach ($jam as $datas) {
                $array_range = range($datas->jam_dari, $datas->jam_sampai);
                $array_hasil = array_merge($array_hasil, $array_range);
            }
            $dataKirim[] = [
                'guru' => $key->guru,
                'hadir' => $hadir ? $hadir->ket : '',
                'nama_guru' => $guru->nama_guru,
                'jam' => $array_hasil,
            ];
        }
        $data['data'] = $dataKirim;
        $data['tanggal'] = $tglni;
        $data['hari'] = $harini;

        // echo '<pre>';
        // var_dump($dataKirim);
        // echo '</pre>';

        $this->load->view('mengajar/mengajarInput', $data);
    }

    public function cekGuru()
    {
        $kdguru = $this->input->post('guru', true);
        $tanggal = $this->input->post('tanggal', true);
        $harini = date('l', strtotime($tanggal));

        $data['guru'] = $this->model->getBy('guru', 'kode_guru', $kdguru)->row();

        // $mapel = $this->model->getBy('mapel', 'kode_mapel', $key->mapel)->row();
        $data['jadwal'] = $this->db->query("SELECT * FROM jadwal WHERE hari = '$harini' AND guru = '$kdguru' ORDER BY jam_dari ASC ")->result();
        $array_hasil = [];
        foreach ($data['jadwal'] as $datas) {
            $array_range = range($datas->jam_dari, $datas->jam_sampai);
            $array_hasil = array_merge($array_hasil, $array_range);
        }

        $data['jam'] = $array_hasil;
        $data['tanggalIni'] = $tanggal;

        $this->load->view('mengajar/tampilMengajar', $data);
    }

    public function simpanJam()
    {
        $datas = $this->input->post('datas', true);
        $tanggal = $this->input->post('tanggal', true);

        foreach ($datas as $data) {
            $guru = $data['guru'];
            $jam = $data['jam'];
            $ket = $data['value'];
            $alasan = !empty($data['alasan']) ? $data['alasan'] : '-';

            $cek = $this->model->getBy3('mengajar', 'guru', $guru, 'jam', $jam, 'tanggal', $tanggal)->row();
            if ($cek) {
                $this->db->where('guru', $guru);
                $this->db->where('jam', $jam);
                $this->db->where('tanggal', $tanggal);
                $this->db->update('mengajar', ['ket' => $ket, 'alasan' => $alasan]);
            } else {
                $simpan = [
                    'guru' => $guru,
                    'jam' =>  $jam,
                    'ket' =>  $ket,
                    'tanggal' =>  $tanggal,
                    'alasan' =>  $alasan,
                ];
                $this->model->simpan('mengajar', $simpan);
            }
        }

        echo json_encode(['status' => 'success']);
    }

    public function kehadiran()
    {
        $guru = $this->input->post('guru', true);
        $ket = $this->input->post('status', true);
        $tanggal = $this->input->post('tanggal', true);
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

    public function rekap_old($id)
    {
        $data['userData'] = $this->Auth_model->current_user();
        $dataCari = $this->model->getBy('mengajar', 'id', $id)->row();
        $harini = date('l', strtotime($dataCari->tanggal));
        $tglni = $dataCari->tanggal;
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
        $this->load->view('mengajar/mengajarRekap', $data);
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

    public function delKehadiranGuru()
    {
        $kode_guru = $this->input->post('kode_guru', true);
        $tanggal = $this->input->post('tanggal', true);

        $this->model->hapus2('kehadiran', 'guru', $kode_guru, 'tanggal', $tanggal);
        $this->model->hapus2('mengajar', 'guru', $kode_guru, 'tanggal', $tanggal);
        if ($this->db->affected_rows() > 0) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error']);
        }
    }

    public function refresh()
    {
        $tanggal = $this->input->post('tanggal', true);

        $guru = $this->model->getAll('guru')->result();
        foreach ($guru as $r) {
            $cek = $this->model->getBy2('kehadiran', 'guru', $r->kode_guru, 'tanggal', $tanggal)->row();
            if (!$cek) {
                $this->model->simpan('kehadiran', [
                    'guru' => $r->kode_guru,
                    'tanggal' => $tanggal,
                    'ket' => 0,
                ]);
            }
        }
        if ($this->db->affected_rows() > 0) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'success']);
        }
    }
    public function rekap()
    {
        $data['userData'] = $this->Auth_model->current_user();
        $data['data'] = $this->db->query("SELECT * FROM mengajar_rekap ORDER BY created_at DESC")->result();
        // $data['cek'] = $this->cek;

        $this->load->view('head', $data);
        $this->load->view('mengajar/rekap', $data);
        $this->load->view('foot');
    }

    public function addRekap()
    {
        $bulan = $this->input->post('bulan', TRUE);
        $dari = $this->input->post('dari', TRUE);
        $sampai = $this->input->post('sampai', TRUE);

        $cek = $this->model->getBy('mengajar_rekap', 'bulan', $bulan)->row();
        if ($cek) {
            $this->session->set_flashdata('error', 'Data absen sudah ada dibulan ini');
            redirect('mengajar/rekap');
            die();
        }

        $simpn = [
            'id' => $this->uuid->v4(),
            'bulan' => $bulan,
            'dari' => $dari,
            'sampai' => $sampai,
            'created_at' => date('Y-m-d H:i:s')
        ];
        $this->model->simpan('mengajar_rekap', $simpn);

        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('ok', 'Data berhasil ditambahkan');
            redirect('mengajar/rekap');
        } else {
            $this->session->set_flashdata('error', 'Data gagal ditambahkan');
            redirect('mengajar/rekap');
        }
    }

    public function cekRekap($id)
    {
        $data['userData'] = $this->Auth_model->current_user();
        $data['dtrekap'] = $this->model->getBy('mengajar_rekap', 'id', $id)->row();
        $cek = $this->model->getBy('mengajar_wajib', 'rekap_id', $id)->row();
        if (!$cek) {
            $guru = $this->model->getAll('guru')->result();
            foreach ($guru as $dr) {
                $dts = [
                    'rekap_id' => $id,
                    'guru_id' => $dr->kode_guru,
                ];
                $this->model->simpan('mengajar_wajib', $dts);
            }
        }
        $dari = $data['dtrekap']->dari;
        $sampai = $data['dtrekap']->sampai;

        $data['data'] = $this->db->query("SELECT a.*, b.nama_guru,b.kode_guru FROM mengajar_wajib a JOIN guru b ON a.guru_id=b.kode_guru WHERE rekap_id = '$id'")->result();

        $gurudata = $this->db->query("SELECT a.*, b.nama_guru,b.kode_guru FROM mengajar_wajib a JOIN guru b ON a.guru_id=b.kode_guru WHERE rekap_id = '$id'")->result();
        $dtkr = [];
        foreach ($gurudata as $gr) {
            $dtjam = $this->db->query("SELECT 
            SUM(CASE WHEN ket = 'H' THEN 1 ELSE 0 END) as hadir,
            SUM(CASE WHEN ket = 'I' THEN 1 ELSE 0 END) as izin,
            SUM(CASE WHEN ket = 'S' THEN 1 ELSE 0 END) as sakit,
            SUM(CASE WHEN ket = 'C' THEN 1 ELSE 0 END) as cuti,
            SUM(CASE WHEN ket = 'A' THEN 1 ELSE 0 END) as alpha,
            SUM(CASE WHEN ket = 'T' THEN 1 ELSE 0 END) as telat,
            SUM(CASE WHEN ket != 'H' THEN 1 ELSE 0 END) as th
            FROM mengajar WHERE guru = '$gr->kode_guru' AND tanggal >= '$dari' AND tanggal <= '$sampai' ")->row();
            $dthadir = $this->db->query("SELECT 
            SUM(CASE WHEN ket = 1 THEN 1 ELSE 0 END) as hadir,
            SUM(CASE WHEN ket = 0 THEN 1 ELSE 0 END) as izin
            FROM mengajar WHERE guru = '$gr->kode_guru' AND tanggal >= '$dari' AND tanggal <= '$sampai' ")->row();

            $dtkr[] = [
                'nama' => $gr->nama_guru,
                'jam_wajib' => $gr->jam_wajib,
                'jam_hadir' => $dtjam->hadir,
                'jam_sakit' => $dtjam->sakit,
                'jam_izin' => $dtjam->izin,
                'jam_cuti' => $dtjam->cuti,
                'jam_alpha' => $dtjam->alpha,
                'jam_telat' => $dtjam->telat,
                'jam_th' => $dtjam->th,
                'jam_prsn' => $dtjam->hadir != 0 && $gr->jam_wajib != 0 ? $dtjam->hadir / $gr->jam_wajib * 100 : 0,
                // Kehadiran
                'hadir_wajib' => $gr->hadir_wajib,
                'hadir_hadir' => $dthadir->hadir,
                'hadir_izin' => $dthadir->izin,
                'hadir_prsn' => $dthadir->hadir != 0 && $gr->hadir_wajib != 0 ? $dthadir->hadir / $gr->hadir_wajib * 100 : 0,
            ];
        }
        $data['datas'] = $dtkr;

        $this->load->view('head', $data);
        $this->load->view('mengajar/cek', $data);
        $this->load->view('foot');
    }
    public function saveJam()
    {
        $data = $this->input->post('data', true);
        if (!empty($data)) {
            foreach ($data as $item) {
                $dtsm = [
                    'jam_wajib' => $item['jam'],
                    'hadir_wajib' => $item['hadir'],
                ];
                $this->model->edit('mengajar_wajib', $dtsm, 'id', $item['id']);
            }
        }
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('ok', 'Simpan Jam Berhasil');
            redirect('mengajar/cekRekap/');
        } else {
            $this->session->set_flashdata('error', 'Simpan Jam Gagal');
            redirect('mengajar/cekRekap/');
        }
    }
}
