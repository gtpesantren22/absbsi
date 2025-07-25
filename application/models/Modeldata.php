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
    public function getBy4($tbl, $where1, $dtwhere1, $where2, $dtwhere2, $where3, $dtwhere3, $where4, $dtwhere4)
    {
        $this->db->where($where1, $dtwhere1);
        $this->db->where($where2, $dtwhere2);
        $this->db->where($where3, $dtwhere3);
        $this->db->where($where4, $dtwhere4);
        return $this->db->get($tbl);
    }
    public function getBy5($tbl, $where1, $dtwhere1, $where2, $dtwhere2, $where3, $dtwhere3, $where4, $dtwhere4, $where5, $dtwhere5)
    {
        $this->db->where($where1, $dtwhere1);
        $this->db->where($where2, $dtwhere2);
        $this->db->where($where3, $dtwhere3);
        $this->db->where($where4, $dtwhere4);
        $this->db->where($where5, $dtwhere5);
        return $this->db->get($tbl);
    }

    public function getBy2Ord($tbl, $where1, $dtwhere1, $where2, $dtwhere2, $ord, $ls)
    {
        $this->db->where($where1, $dtwhere1);
        $this->db->where($where2, $dtwhere2);
        $this->db->order_by($ord, $ls);
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

    public function getByOrd($tbl, $where1, $dtwhere1, $ord, $ls)
    {
        $this->db->where($where1, $dtwhere1);
        $this->db->order_by($ord, $ls);
        return $this->db->get($tbl);
    }
    public function getAllOrd($tbl, $ord, $ls)
    {
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

    public function edit($table, $data, $where, $dtwhere)
    {
        $this->db->where($where, $dtwhere);
        $this->db->update($table, $data);
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
        $this->db->join('guru', 'ON harian.guru=guru.kode_guru');
        $this->db->join('mapel', 'ON harian.mapel=mapel.kode_mapel');
        $this->db->group_by('kode');
        $this->db->order_by('tanggal', 'DESC');
        return $this->db->get();
    }
    public function absenHariIni()
    {
        $isDay = date('Y-m-d');
        $this->db->from('harian');
        $this->db->join('guru', 'ON harian.guru=guru.kode_guru');
        $this->db->join('mapel', 'ON harian.mapel=mapel.kode_mapel');
        $this->db->where('harian.tanggal', $isDay);
        $this->db->group_by('kode');
        $this->db->order_by('tanggal', 'DESC');
        return $this->db->get();
    }

    public function absenHarianDay($user)
    {
        $this->db->from('harian');
        $this->db->join('guru', 'ON harian.guru=guru.kode_guru');
        $this->db->join('mapel', 'ON harian.mapel=mapel.kode_mapel');
        $this->db->where('tanggal', date('Y-m-d'));
        $this->db->where('harian.guru', $user);
        $this->db->group_by('kode');
        $this->db->order_by('tanggal', 'DESC');
        return $this->db->get();
    }

    public function hapus($tbl, $where1, $dtwhere1)
    {
        $this->db->where($where1, $dtwhere1);
        $this->db->delete($tbl);
    }
    public function hapus2($tbl, $where1, $dtwhere1, $where2, $dtwhere2)
    {
        $this->db->where($where1, $dtwhere1);
        $this->db->where($where2, $dtwhere2);
        $this->db->delete($tbl);
    }

    function getJadwal()
    {
        $this->db->from('jadwal');
        $this->db->join('guru', 'ON guru.kode_guru=jadwal.guru');
        $this->db->join('mapel', 'ON mapel.kode_mapel=jadwal.mapel');
        // $this->db->group_by('hari');
        return $this->db->get();
    }

    function getJoin($tbl1, $tbl2, $on1, $on2)
    {
        $this->db->from($tbl1);
        $this->db->join($tbl2, 'ON ' . $tbl1 . '.' . $on1 . '=' . $tbl2 . '.' . $on2);
        return $this->db->get();
    }
}
