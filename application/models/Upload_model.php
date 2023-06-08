<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Upload_model extends CI_Model {
    
    // public function getDataPelayananAll($jenis)
    // {
    //     $this->datatables->select('id_pelayanan, pelayanan, file, status, jenis, pelayanan.updated_date');
    //     $this->datatables->from('pelayanan');
    //     $this->datatables->join('users', 'users.id = pelayanan.id_penanggungjawab');
    //     $this->datatables->join('users_groups', 'users_groups.user_id = users.id');
    //     $this->datatables->join('groups', 'groups.id = users_groups.group_id');
    //     // $this->datatables->join('dosen', 'dosen.nip = users.username');
    //     if($jenis!=="All"){  
    //         $this->datatables->where('jenis', $jenis);
    //     }

    //     return $this->datatables->generate();
    // }

    // public function getDataPelayanan($pj,$jenis)
    // {
        
    //     $this->datatables->select('id_pelayanan, pelayanan, file, status, jenis, pelayanan.updated_date');
    //     $this->datatables->from('pelayanan');
    //     $this->datatables->join('users', 'users.id = pelayanan.id_penanggungjawab');
    //     $this->datatables->join('users_groups', 'users_groups.user_id = users.id');
    //     $this->datatables->join('groups', 'groups.id = users_groups.group_id');
    //     // $this->datatables->join('dosen', 'dosen.nip = users.username');
    //     if($jenis!=="All"){
    //         $this->datatables->where('id_penanggungjawab', $pj);
    //         $this->datatables->where('jenis', $jenis);
    //     }else{
    //         $this->datatables->where('id_penanggungjawab', $pj);
    //     }

    //     return $this->datatables->generate();
    // } 

    // public function getPelayananById($id)
    // {
    //     return $this->db->get_where('pelayanan', ['id_pelayanan' => $id])->row();
    // }

    // public function getPjById($pj)
    // {
    //     $this->db->select('*');
    //     $this->db->join('dosen', 'dosen.nip=users.username');
    //     $this->db->from('users')->where('id', $pj);
    //     return $this->db->get()->row();
    // }

    // public function getAllPj($pj)
    // {
    //     $this->db->select('*');
    //     $this->db->from('users')->where('id', $pj);
    //     return $this->db->get()->row();
    // }

    // public function getAllRuanganByBidang($bidang)
    // {
    //     $this->db->select('*');
    //     $this->db->from('kelas a');
    //     $this->db->join('jurusan b', 'a.jurusan_id=b.id_jurusan');
    //     $this->db->where('a.jurusan_id', $bidang);
    //     return $this->db->get()->result();
    // }

    public function getAllPoli()
    {
        $this->db->select('*');
        $this->db->from('poli');
        return $this->db->get()->result();
    }

    public function getAllRuangan($ruang)
    {
        $this->db->select('*');
        $this->db->from('kelas');
        if($ruang==1){
            $this->db->where('jurusan_id', $ruang);
            $this->db->like('nama_kelas', 'IRNA', 'after');
        }else{
            $this->db->where('jurusan_id', $ruang); 
        }
        return $this->db->get()->result();
    }

    //--------------------Berita--------------------
    public function getDataBerita($user)
    {
        $this->datatables->select('id_berita, nama, keterangan, status, publish');
        $this->datatables->from('berita');
        if($user!=1){
            $this->datatables->where('created_by', $user);
        }
        return $this->datatables->generate();
    }

    public function getBeritaById($id)
    {
        return $this->db->get_where('berita', ['id_berita' => $id])->row();
    }

    //--------------------Home--------------------
    public function getDataHome($kategori)
    {
        $this->datatables->select('id_home, deskripsi, status, publish, created_date');
        $this->datatables->from('home');
        $this->datatables->where('kategori', $kategori);
        return $this->datatables->generate();
    }

    public function getHomeById($id)
    {
        return $this->db->get_where('home', ['id_home' => $id])->row();
    }

    //--------------------Upload/Pelayanan/Unggulan--------------------
    public function getDataPelayananUnggulan()
    {
        $this->datatables->select('id_pelayanan_unggulan, nama, keterangan, status, publish');
        $this->datatables->from('pelayanan_unggulan');
        return $this->datatables->generate();
    }

    public function getPelayananUnggulanById($id)
    {
        return $this->db->get_where('pelayanan_unggulan', ['id_pelayanan_unggulan' => $id])->row();
    }

    //--------------------Upload/Pelayanan/IGD--------------------
    public function getDataPelayananIGD()
    {
        $this->datatables->select('id_pelayanan_igd, keterangan, file, status, publish');
        $this->datatables->from('pelayanan_igd');
        return $this->datatables->generate();
    }

    public function getPelayananIGDById($id)
    {
        return $this->db->get_where('pelayanan_igd', ['id_pelayanan_igd' => $id])->row();
    }

    //--------------------Upload/Pelayanan/Rajal--------------------
    public function getDataPelayananRajal()
    {
        $this->datatables->select('id_pelayanan_rajal, nama_poli, file, status, publish');
        $this->datatables->from('pelayanan_rajal');
        $this->datatables->join('poli', 'poli.id_poli = pelayanan_rajal.id_poli');
        return $this->datatables->generate();
    }

    public function getPelayananRajalById($id)
    {
        $this->db->select('*');
        $this->db->from('pelayanan_rajal');
        $this->db->join('poli', 'poli.id_poli = pelayanan_rajal.id_poli');
        $this->db->where('id_pelayanan_rajal', $id);
        return $this->db->get()->row();
    }

    //--------------------Upload/Pelayanan/Ranap--------------------
    public function getDataPelayananRanap()
    {
        $this->datatables->select('id_pelayanan_ranap, nama_kelas, file, status, publish');
        $this->datatables->from('pelayanan_ranap');
        $this->datatables->join('kelas', 'kelas.id_kelas = pelayanan_ranap.id_ruangan');
        return $this->datatables->generate();
    }

    public function getPelayananRanapById($id)
    {
        $this->db->select('*');
        $this->db->from('pelayanan_ranap');
        $this->db->join('kelas', 'kelas.id_kelas = pelayanan_ranap.id_ruangan');
        $this->db->where('id_pelayanan_ranap', $id);
        return $this->db->get()->row();
    } 

    //--------------------Upload/Pelayanan/Penunjang--------------------
    public function getDataPelayananPenunjang()
    {
        $this->datatables->select('id_pelayanan_penunjang, nama_kelas, keterangan, file, status, publish');
        $this->datatables->from('pelayanan_penunjang');
        $this->datatables->join('kelas', 'kelas.id_kelas = pelayanan_penunjang.id_ruangan');
        return $this->datatables->generate();
    }

    public function getPelayananPenunjangById($id)
    {
        $this->db->select('*');
        $this->db->from('pelayanan_penunjang');
        $this->db->join('kelas', 'kelas.id_kelas = pelayanan_penunjang.id_ruangan');
        $this->db->where('id_pelayanan_penunjang', $id);
        return $this->db->get()->row();
    }  
    
    //--------------------Upload/Informasi/Dokter--------------------
    public function getDataDokter()
    {
        $this->datatables->select('*, poli.id_poli as poli_id');
        $this->datatables->from('dokter');
        $this->datatables->join('poli', 'poli.id_poli = dokter.id_poli');
        return $this->datatables->generate();
    }

    public function getDokterById($id)
    {
        $this->db->select('*');
        $this->db->from('dokter');
        $this->db->where('id_dokter', $id);
        $this->db->order_by('nama');
        return $this->db->get()->row();
    }

    // public function getDokterPoliById($id)
    // {
    //     $this->db->select('*, GROUP_CONCAT(poli.nama_poli) as nama_poli');
    //     $this->db->from('dokter');
    //     $this->db->join('poli', 'poli.id_poli = dokter.id_poli');
    //     $this->db->where('id_dokter', $id);
    //     return $this->db->get()->row();
    // }

    //--------------------Upload/Informasi/PPI--------------------
    public function getDataPPI()
    {
        $this->datatables->select('id_ppi, kegiatan, definisi, status, publish');
        $this->datatables->from('ppi');
        return $this->datatables->generate();
    }

    public function getPPIById($id)
    {
        return $this->db->get_where('ppi', ['id_ppi' => $id])->row();
    }

    //--------------------Upload/Informasi/Imut--------------------
    public function getDataImut()
    {
        $this->datatables->select('id_imut, nama, file, status, publish');
        $this->datatables->from('indikator_mutu');
        return $this->datatables->generate();
    }

    public function getImutById($id)
    {
        return $this->db->get_where('indikator_mutu', ['id_imut' => $id])->row();
    }

    //--------------------Upload/Informasi/Jadwal--------------------
    public function getDataJadwal()
    {
        $this->datatables->select('id_jadwal, keterangan, file, status, publish');
        $this->datatables->from('jadwal');
        return $this->datatables->generate();
    }

    public function getJadwalById($id)
    {
        return $this->db->get_where('jadwal', ['id_jadwal' => $id])->row();
    }

    //--------------------Upload/RSP/Jejaring--------------------
    public function getDataJejaring($kategori)
    {
        $this->datatables->select('id_jejaring, keterangan, file, status, publish, updated_date');
        $this->datatables->from('jejaring');
        $this->datatables->where('kategori', $kategori);
        return $this->datatables->generate();
    }

    public function getJejaringById($id)
    {
        return $this->db->get_where('jejaring', ['id_jejaring' => $id])->row();
    }

    //--------------------Upload/RSP/Diklat--------------------
    public function getDataDiklat()
    {
        $this->datatables->select('id_diklat, keterangan, kategori, status, publish');
        $this->datatables->from('diklat');
        return $this->datatables->generate();
    }

    public function getDiklatById($id)
    {
        return $this->db->get_where('diklat', ['id_diklat' => $id])->row();
    }

    //--------------------Upload/RSP/Litbang--------------------
    public function getDataLitbang()
    {
        $this->datatables->select('id_litbang, nama, keterangan, status, publish');
        $this->datatables->from('litbang');
        return $this->datatables->generate();
    }

    public function getLitbangById($id)
    {
        return $this->db->get_where('litbang', ['id_litbang' => $id])->row();
    }

    //--------------------Upload/RSP/E-Library--------------------
    public function getDataElibrary()
    {
        $this->datatables->select('id_elibrary, kategori, keterangan, status, publish');
        $this->datatables->from('elibrary');
        return $this->datatables->generate();
    }

    public function getElibraryById($id)
    {
        return $this->db->get_where('elibrary', ['id_elibrary' => $id])->row();
    }

    //--------------------Arsip--------------------
    public function getDataArsip()
    {
        $this->datatables->select('id_arsip, nama, keterangan, status, publish');
        $this->datatables->from('arsip');
        return $this->datatables->generate();
    }

    public function getArsipById($id)
    {
        return $this->db->get_where('arsip', ['id_arsip' => $id])->row();
    }

    //--------------------FAQ--------------------
    public function getDataFaq()
    {
        $this->datatables->select('id_faq, pertanyaan, jawaban');
        $this->datatables->from('faq');
        $this->datatables->add_column('bulk_select', '<div class="text-center"><input type="checkbox" class="check" name="checked[]" value="$1"/></div>', 'id_faq, pertanyaan, jawaban, status');
        return $this->datatables->generate();
    }

    public function getFaqById($id)
    {
        $this->db->where_in('id_faq', $id);
        $this->db->order_by('pertanyaan');
        $query = $this->db->get('faq')->result();
        return $query;
    }
}