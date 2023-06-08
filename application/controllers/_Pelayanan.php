<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pelayanan extends CI_Controller {

	public function __construct(){
		parent::__construct();
		if (!$this->ion_auth->logged_in()){
			redirect('auth');
		}else if ( !$this->ion_auth->is_admin() && !$this->ion_auth->in_group('Verifikator') && !$this->ion_auth->in_group('Unit') ){
			show_error('Mohon maaf Anda tidak diberi hak untuk mengakses halaman ini, <a href="'.base_url('dashboard').'">Kembali ke menu awal</a>', 403, 'Akses Terlarang');
		}
		$this->load->library(['datatables', 'form_validation']);// Load Library Ignited-Datatables
		$this->load->helper('my');// Load Library Ignited-Datatables
		$this->load->model('Master_model', 'master');
		$this->load->model('Upload_model', 'uploadfile');
		$this->form_validation->set_error_delimiters('','');
	}

	public function output_json($data, $encode = true)
	{
        if($encode) $data = json_encode($data);
        $this->output->set_content_type('application/json')->set_output($data);
    }

    public function index()
	{
        $user = $this->ion_auth->user()->row();
		$data = [
			'user' => $user,
			'judul'	=> 'Pelayanan',
			'subjudul'=> 'Master Data Pelayanan'
        ];
        
        if($this->ion_auth->is_admin()){
            //Jika admin maka tampilkan semua matkul
            $data['pelayanan'] = $this->uploadfile->getAllPj($user->id);
        }else{
            //Jika bukan maka matkul dipilih otomatis sesuai matkul dosen
            $data['pelayanan'] = $this->uploadfile->getPjById($user->id);
        }

		$this->load->view('_templates/dashboard/_header.php', $data);
		$this->load->view('pelayanan/data');
		$this->load->view('_templates/dashboard/_footer.php');
    }
    
    public function detail($id)
    {
        $user = $this->ion_auth->user()->row();
		$data = [
			'user'      => $user,
			'judul'	    => 'Pelayanan',
            'subjudul'  => 'Edit Pelayanan',
            'pelayanan' => $this->uploadfile->getPelayananById($id),
        ];

        $this->load->view('_templates/dashboard/_header.php', $data);
		$this->load->view('pelayanan/detail');
		$this->load->view('_templates/dashboard/_footer.php');
    }
    
    public function add()
	{
        $user = $this->ion_auth->user()->row();
		$data = [
			'user'      => $user,
			'judul'	    => 'Pelayanan',
            'subjudul'  => 'Tambah Konten Pelayanan',
            'ruang'     => $this->uploadfile->getAllRuanganByBidang('2')
        ];
        
		$this->load->view('_templates/dashboard/_header.php', $data);
		$this->load->view('pelayanan/add');
		$this->load->view('_templates/dashboard/_footer.php');
    }

    public function edit($id)
	{
		$user = $this->ion_auth->user()->row();
		$data = [
			'user'      => $user,
			'judul'	    => 'Pelayanan',
            'subjudul'  => 'Edit Konten Pelayanan',
            'pelayanan' => $this->uploadfile->getPelayananById($id),
        ];
        
		$this->load->view('_templates/dashboard/_header.php', $data);
		$this->load->view('pelayanan/edit');
		$this->load->view('_templates/dashboard/_footer.php');
	}

	public function data($pj=null,$jenis=null)
	{
        if($this->ion_auth->is_admin() || $this->ion_auth->in_group('Verifikator')){
            //Jika admin maka tampilkan semua matkul
            $this->output_json($this->uploadfile->getDataPelayananAll($jenis), false);
        }else{
            //Jika bukan maka matkul dipilih otomatis sesuai matkul dosen
            $this->output_json($this->uploadfile->getDataPelayanan($pj,$jenis), false);
        }
		//$this->output_json($this->uploadfile->getDataPelayanan($pj,$jenis), false);
    }

    public function validasi()
    {
        //if($this->ion_auth->is_admin()){
            //$this->form_validation->set_rules('dosen_id', 'Dosen', 'required');
        //}
        $this->form_validation->set_rules('jenis', 'Jenis Pelayanan', 'required');
        $this->form_validation->set_rules('pelayanan', 'Pelayanan', 'required');
        //$this->form_validation->set_rules('file', 'File', 'required');
        //$this->form_validation->set_rules('deskripsi', 'Deskripsi', 'required');
        // $this->form_validation->set_rules('jawaban_d', 'Jawaban D', 'required');
        // $this->form_validation->set_rules('jawaban_e', 'Jawaban E', 'required');
        //$this->form_validation->set_rules('jawaban', 'Kunci Jawaban', 'required');
        //$this->form_validation->set_rules('bobot', 'Bobot Soal', 'required|max_length[2]');
    }

    public function file_config()
    {
        $allowed_type 	= [
            "image/jpeg", "image/jpg", "image/png", "image/gif"
        ];
        $config['upload_path']      = FCPATH.'uploads/bank_soal/';
        $config['allowed_types']    = 'jpeg|jpg|png|gif';
        $config['encrypt_name']     = TRUE;
        
        return $this->load->library('upload', $config);
    }
    
    public function save()
    {
        $method = $this->input->post('method', true);
        $this->validasi();
        $this->file_config();

        
        if($this->form_validation->run() === FALSE){
            $method==='add'? $this->add() : $this->edit();
        }else{
            $data = [
                'pelayanan'   => $this->input->post('pelayanan', true),
                'deskripsi'   => $this->input->post('deskripsi', true),
                'id_ruangan'  => $this->input->post('ruang', true),
                'jenis'       => $this->input->post('jenis', true),
            ];
            
            //$i = 0;
           foreach ($_FILES as $key => $val) {
                $img_src = FCPATH.'uploads/bank_soal/';
                $getpelayanan = $this->uploadfile->getPelayananById($this->input->post('id_pelayanan', true));
                
                $error = '';
                if($key === 'file'){
                    if(!empty($_FILES['file']['name'])){
                        if (!$this->upload->do_upload('file')){
                            $error = $this->upload->display_errors();
                            show_error($error, 500, 'File Error');
                            exit();
                        }else{
                            if($method === 'edit'){
                                if(!unlink($img_src.$getpelayanan->file)){
                                    show_error('Error saat delete gambar <br/>'.var_dump($getpelayanan), 500, 'Error Edit Gambar');
                                    exit();
                                }
                            }
                            $data['file'] = $this->upload->data('file_name');
                            $data['tipe_file'] = $this->upload->data('file_type');
                        }
                    }
                }
            }
            
            $user = $this->ion_auth->user()->row();
            if($method==='add'){
                //push array
                $data['id_penanggungjawab'] = $user->id;
                $data['created_date'] = date('Y-m-d H:i:s');
                $data['created_by'] = $user->first_name." ".$user->last_name;
                $data['updated_date'] = date('Y-m-d H:i:s');
                $data['updated_by'] = $user->first_name." ".$user->last_name;
                
                //insert data
                $this->master->create('pelayanan', $data);
            }else if($method==='edit'){
                //push array
                $data['id_penanggungjawab'] = $user->id;
                $data['updated_date'] = date('Y-m-d H:i:s');
                $data['updated_by'] = $user->first_name." ".$user->last_name;

                //update data
                $id_pelayanan = $this->input->post('id_pelayanan', true);
                $this->master->update('pelayanan', $data, 'id_pelayanan', $id_pelayanan);
            }else{
                show_error('Method tidak diketahui', 404);
            }
            redirect('pelayanan');
        }
    }

    public function delete()
    {
        $chk = $this->input->post('checked', true);
        
        // Delete File
        foreach($chk as $id){
            //$abjad = ['a', 'b', 'c', 'd', 'e'];
            $path = FCPATH.'uploads/bank_soal/';
            $soal = $this->uploadfile->getPelayananById($id);
            // Hapus File Soal
            if(!empty($soal->file)){
                if(file_exists($path.$soal->file)){
                    unlink($path.$soal->file);
                }
            }
        }

        if(!$chk){
            $this->output_json(['status'=>false]);
        }else{
            if($this->master->delete('pelayanan', $chk, 'id_pelayanan')){
                $this->output_json(['status'=>true, 'total'=>count($chk)]);
            }
        }
    }

    public function verify()
    {
        $user = $this->ion_auth->user()->row();
            
        //push array
        $data['status'] = $this->input->post('btn_submit', true);
        $data['verified_date'] = date('Y-m-d H:i:s');
        $data['verified_by'] = $user->first_name." ".$user->last_name;

        //update data
        $id_pelayanan = $this->input->post('id_pelayanan', true);
        $this->master->update('pelayanan', $data, 'id_pelayanan', $id_pelayanan);
            
        redirect('pelayanan');
        
    }
}