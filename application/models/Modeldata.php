<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Modeldata extends CI_Model
{
    public function getAll($tbl)
    {
        return $this->db->get($tbl);
    }

    public function getBy($tbl, $where1, $dtwhere1)
    {
        $this->db->where($where1, $dtwhere1);
        return $this->db->get($tbl);
    }

    public function getBy2($tbl, $where1, $dtwhere1, $where2, $dtwhere2)
    {
        $this->db->where($where1, $dtwhere1);
        $this->db->where($where2, $dtwhere2);
        return $this->db->get($tbl);
    }

    public function getBy3($tbl, $where1, $dtwhere1, $where2, $dtwhere2, $where3, $dtwhere3)
    {
        $this->db->where($where1, $dtwhere1);
        $this->db->where($where2, $dtwhere2);
        $this->db->where($where3, $dtwhere3);
        return $this->db->get($tbl);
    }

    public function getBy3Ord($tbl, $where1, $dtwhere1, $where2, $dtwhere2, $where3, $dtwhere3, $ord, $ls)
    {
        $this->db->where($where1, $dtwhere1);
        $this->db->where($where2, $dtwhere2);
        $this->db->where($where3, $dtwhere3);
        $this->db->order_by($ord, $ls);
        return $this->db->get($tbl);
    }

    public function getAbsensi()
    {
        $this->db->order_by('tanggal', 'DESC');
        return $this->db->get('absensi');
    }

    public function simpan($tbl, $data)
    {
        $this->db->insert($tbl, $data);
    }

    public function absenDetail($id)
    {
        $this->db->select('detail_absen.*, tb_santri.nama, tb_santri.k_formal, tb_santri.r_formal, tb_santri.jurusan');
        $this->db->from('detail_absen');
        $this->db->join('tb_santri', 'ON detail_absen.nis=tb_santri.nis');
        $this->db->where('id_absen', $id);
        return $this->db->get();
    }

    public function absenHarian()
    {
        $this->db->from('harian');
        $this->db->group_by('kode');
        $this->db->order_by('tanggal', 'DESC');
        return $this->db->get();
    }

    public function hapus($tbl, $where1, $dtwhere1)
    {
        $this->db->where($where1, $dtwhere1);
        $this->db->delete($tbl);
    }
}
