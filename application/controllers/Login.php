<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        // $this->load->model('DataModel');
        $this->load->model('Auth_model');
    }

    public function index()
    {

        // $data['daftar'] = $this->DataModel->data()->result();

        // $this->load->view('layout/head');
        $this->load->view('login');
        // $this->load->view('layout/foot');
    }

    public function masuk()
    {
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        // $rules = $this->Auth_model->rules();
        // $this->form_validation->set_rules($rules);

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('login');
        }

        $username = $this->input->post('username', true);
        $password = $this->input->post('password', true);
        // $tujuan = $this->input->post('tujuan', true);

        if ($this->Auth_model->login($username, $password)) {
            $user = $this->Auth_model->current_user();
            $this->session->set_flashdata('ok', 'Login Berhasil');
            redirect('welcome');
        } else {
            // $this->session->set_flashdata('message_login_error', 'Login Gagal, pastikan username dan passwrod benar!');
            $this->session->set_flashdata('error', 'Maaf username atau password salah');
            redirect('login');
        }
    }

    public function daftar()
    {
        $this->load->view('daftar');
    }

    public function daftarAct()
    {
        $username = $this->input->post('username', true);
        $password = $this->input->post('password', true);
        $passOk = password_hash($password, PASSWORD_BCRYPT);

        $data = [
            'id_user' => $this->uuid->v4(),
            'nama' => strtoupper($this->input->post('nama', true)),
            'jabatan' => $this->input->post('jabatan', true),
            'username' => $username,
            'password' => $passOk,
            'aktif' => 'T',
            'level' => 'adm',

        ];

        $this->Auth_model->tambah('user', $data);
        if ($this->db->affected_rows()) {
            $this->session->set_flashdata('ok', 'Akun sudah dibuat. Silahkan menghubungi admin untuk aktifasi akun anda');
            redirect('login/daftar');
        }
    }

    public function logout()
    {
        // $this->load->model('Auth_model');
        if ($this->Auth_model->logout()) {
            $this->session->set_flashdata('ok', 'Anda Berhasil Keluar');
            redirect('login');
        }
    }
}
