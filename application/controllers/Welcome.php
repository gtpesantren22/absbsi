<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Welcome extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->load->model('Modeldata', 'model');
		$this->load->model('Auth_model');
		$user = $this->Auth_model->current_user();

		if (!$this->Auth_model->current_user() || $user->level != 'adm' && $user->level != 'admin') {
			redirect('login/logout');
		}
	}

	public function index()
	{
		$this->load->view('head');
		$this->load->view('index');
		$this->load->view('foot');
	}

	public function santri($jkl)
	{
		$jkl == 'putra' ? $jkl = 'Laki-laki' : $jkl = 'Perempuan';
		$data['data'] = $this->model->getBy3('tb_santri', 'aktif', 'Y', 't_formal', 'SMK', 'jkl', $jkl);

		$data['dataTtl'] = $this->model->getBy2('tb_santri', 'aktif', 'Y', 't_formal', 'SMK');
		$data['jmlPusat'] = is_array($this->dataPusat()) ? count($this->dataPusat()) : 'Bukan Array';

		$this->load->view('head');
		$this->load->view('siswa', $data);
		$this->load->view('foot');
	}

	public function dataPusat()
	{
		$api_url = 'https://dpontren.ppdwk.com/api-data.php';

		// Token API yang akan dikirimkan
		$api_token = '2y10bMXpw6ajVkXVjP6nEjg4pus6rw5cZy0fBcukr614aS88CBsbna7YK';

		// Data yang akan dikirimkan ke API (jika ada)
		$data = array(
			'api_token' => $api_token
		);

		// Membuat context HTTP
		$context = stream_context_create(array(
			'http' => array(
				'method' => 'POST',
				'header' => 'Content-Type: application/x-www-form-urlencoded',
				'content' => http_build_query($data)
			)
		));

		// Mengirim permintaan ke API
		$response = file_get_contents($api_url, false, $context);

		// Menampilkan hasil dari API
		$data = json_decode($response, true);
		// echo $response;

		return $data;
		// if ($data !== null) {
		// 	// Menggunakan data yang telah diubah menjadi array asosiatif
		// 	foreach ($data as $item) {
		// 		echo "ID: " . $item['nis'] . ", Nama: " . $item['nama'] . "<br>";
		// 	}
		// } else {
		// 	// Menampilkan pesan jika data tidak dapat diubah menjadi array asosiatif
		// 	echo "Gagal mengonversi data menjadi array asosiatif.";
		// }
	}

	public function sincr()
	{
		$data = $this->dataPusat();

		if ($data !== null) {
			$this->db->truncate('tb_santri');



			foreach ($data as $item) {
				$dts = [
					// 'id_santri' => $item->id_santri,
					'nis' => $item['nis'],
					'nisn' => $item['nisn'],
					'nik' => $item['nik'],
					'no_kk' => $item['no_kk'],
					'email' => $item['email'],
					'nama' => $item['nama'],
					'tempat' => $item['tempat'],
					'tanggal' => $item['tanggal'],
					'jkl' => $item['jkl'],
					'jln' => $item['jln'],
					'rt' => $item['rt'],
					'rw' => $item['rw'],
					'kd_pos' => $item['kd_pos'],
					'desa' => $item['desa'],
					'kec' => $item['kec'],
					'kab' => $item['kab'],
					'prov' => $item['prov'],
					'k_formal' => $item['k_formal'],
					't_formal' => $item['t_formal'],
					'r_formal' => $item['r_formal'],
					'jurusan' => $item['jurusan'],
					'k_madin' => $item['k_madin'],
					'r_madin' => $item['r_madin'],
					'komplek' => $item['komplek'],
					'kamar' => $item['kamar'],
					'anak_ke' => $item['anak_ke'],
					'jml_sdr' => $item['jml_sdr'],
					'bapak' => $item['bapak'],
					'nik_a' => $item['nik_a'],
					'tempat_a' => $item['tempat_a'],
					'tanggal_a' => $item['tanggal_a'],
					'pend_a' => $item['pend_a'],
					'pkj_a' => $item['pkj_a'],
					'status_a' => $item['status_a'],
					'foto_a' => $item['foto_a'],
					'ibu' => $item['ibu'],
					'nik_i' => $item['nik_i'],
					'tempat_i' => $item['tempat_i'],
					'tanggal_i' => $item['tanggal_i'],
					'pend_i' => $item['pend_i'],
					'pkj_i' => $item['pkj_i'],
					'status_i' => $item['status_i'],
					'foto_i' => $item['foto_i'],
					'wali' => $item['wali'],
					'nik_w' => $item['nik_w'],
					'tempat_w' => $item['tempat_w'],
					'tanggal_w' => $item['tanggal_w'],
					'pend_w' => $item['pend_w'],
					'pkj_w' => $item['pkj_w'],
					'hp' => $item['hp'],
					'pass' => $item['pass'],
					'foto' => $item['foto'],
					'stts' => $item['stts'],
					't_kos' => $item['t_kos'],
					'ket' => $item['ket'],
					'aktif' => $item['aktif'],
				];

				$this->db->insert('tb_santri', $dts);

				// var_dump($dts);
				// echo $item['nama'];
			}

			if ($this->db->affected_rows() > 0) {
				redirect('welcome/santri/putra');
			} else {
				echo "Sinkron Gagal";
			}

			// echo count($data);
		} else {
			// Menampilkan pesan jika data tidak dapat diubah menjadi array asosiatif
		}
	}
}
