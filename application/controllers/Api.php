<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Api extends CI_Controller
{

    private $api_key;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Modeldata', 'model');
        $apk = $this->model->getBy('settings', 'namaset', 'apiKey')->row();
        $this->api_key = $apk ? $apk->isi : null;

        header('Content-Type: application/json');

        // Cek API key dari header
        $header_key = $this->input->get_request_header('X-API-KEY');
        if ($header_key !== $this->api_key) {
            echo json_encode([
                'status' => 'error',
                'message' => 'API key tidak valid'
            ]);
            exit; // Stop eksekusi
        }
    }

    public function update_rfid()
    {
        $rfdata = $this->input->post('rfid', TRUE);
        $nis = $this->model->getBy('settings', 'namaset', 'nis')->row();
        $this->model->edit('tb_santri', ['rfid' => $rfdata], 'nis', $nis->isi);
        $error = $this->db->error();
        if ($this->db->affected_rows() > 0) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Data bulan berhasil diperbarui',
                'test' => $rfdata
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Gagal memperbarui data: ' . $error['message'],
                'test' => $rfdata
            ]);
        }
    }
}
