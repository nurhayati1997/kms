<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Soal_model extends CI_Model {
    
    public function getDataSoal($kelas,$dosen)
    {
        $this->datatables->select('a.id_soal, a.soal, FROM_UNIXTIME(a.created_on) as created_on, FROM_UNIXTIME(a.updated_on) as updated_on, 
        IF(a.kelas_id = 0,"Semua",b.nama_kelas) as nama_kelas,
        IF(a.dosen_id = 0,"Administrator",c.nama_dosen) as nama_dosen');
        $this->datatables->from('tb_soal a');
        $this->datatables->join('kelas b', 'b.id_kelas=a.kelas_id','left');
        $this->datatables->join('dosen c', 'c.id_dosen=a.dosen_id','left');
        $this->datatables->join('users d', 'd.username=c.nip','left');
        $this->datatables->where('a.kelas_id', $kelas);  
        if ($dosen!=='00000000'){
            $this->datatables->where('a.dosen_id', $dosen);
        }
        return $this->datatables->generate();
    }

    public function getSoalById($id)
    {
        return $this->db->get_where('tb_soal', ['id_soal' => $id])->row();
    }

    public function getAllDosen()
    {
        $this->db->select('*');
        $this->db->from('dosen a');
        $this->db->join('matkul b', 'a.matkul_id=b.id_matkul');
        return $this->db->get()->result();
    }

    public function getKelasDosen()
    {
        $this->db->select('*');
        $this->db->from('kelas_dosen a');
        $this->db->join('dosen b', 'a.dosen_id=b.id_dosen');
        $this->db->join('kelas c', 'a.kelas_id=c.id_kelas');
        $this->db->order_by("kelas_id", "asc");
        return $this->db->get()->result();
    }
}