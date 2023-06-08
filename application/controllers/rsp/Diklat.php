<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Diklat extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if (!$this->ion_auth->logged_in()) {
			redirect('auth');
		} else if (!$this->ion_auth->is_admin() && !$this->ion_auth->in_group('Verifikator') && !$this->ion_auth->in_group('Creator')) {
			show_error('Mohon maaf Anda tidak diberi hak untuk mengakses halaman ini, <a href="' . base_url('dashboard') . '">Kembali ke menu awal</a>', 403, 'Akses Terlarang');
		}
		$this->load->library(['datatables', 'form_validation']); // Load Library Ignited-Datatables
		$this->load->helper('my');
		$this->load->model('Master_model', 'master');
		$this->load->model('Upload_model', 'uploadfile');
		$this->form_validation->set_error_delimiters('', '');
	}

	public function output_json($data, $encode = true)
	{
		if ($encode) $data = json_encode($data);
		$this->output->set_content_type('application/json')->set_output($data);
	}

	public function index()
	{
		$data = [
			'user' => $this->ion_auth->user()->row(),
			'judul'	=> 'Diklat',
			'subjudul' => 'RS Pendidikan'
		];
		$this->load->view('_templates/dashboard/_header.php', $data);
		$this->load->view('rsp/diklat/data');
		$this->load->view('_templates/dashboard/_footer.php');
	}

	public function data()
	{
		$this->output_json($this->uploadfile->getDataDiklat(), false);
	}

	public function add()
	{
		$data = [
			'user' => $this->ion_auth->user()->row(),
			'judul'	=> 'Diklat',
			'subjudul' => 'Tambah Data'
		];
		$this->load->view('_templates/dashboard/_header.php', $data);
		$this->load->view('rsp/diklat/add');
		$this->load->view('_templates/dashboard/_footer.php');
	}

	public function edit($id)
	{
		$data = [
			'user' 		=> $this->ion_auth->user()->row(),
			'judul'		=> 'Diklat',
			'subjudul'	=> 'Informasi',
			'diklat' 	=> $this->uploadfile->getDiklatById($id)
		];
		$this->load->view('_templates/dashboard/_header.php', $data);
		$this->load->view('rsp/diklat/edit');
		$this->load->view('_templates/dashboard/_footer.php');
	}

	public function detail($id)
    {
        $user = $this->ion_auth->user()->row();
		$data = [
			'user'      => $user,
			'judul'	    => 'Diklat',
            'subjudul'  => 'Detail',
            'diklat' 	=> $this->uploadfile->getDiklatById($id)
        ];

        $this->load->view('_templates/dashboard/_header.php', $data);
		$this->load->view('rsp/diklat/detail');
		$this->load->view('_templates/dashboard/_footer.php');
    }

	public function validasi()
    {
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'required');
    }

	public function file_config()
    {
        $allowed_type 	= [
            "image/jpeg", "image/jpg", "image/png", "image/gif"
        ];
        $config['upload_path']      = FCPATH.'uploads/rsp/diklat/';
        $config['allowed_types']    = 'jpeg|jpg|png|gif';
        $config['encrypt_name']     = TRUE;
        
        return $this->load->library('upload', $config);
    }

	public function save()
	{
		$user = $this->ion_auth->user()->row();
		$method = $this->input->post('method', true);
        $this->validasi();
        $this->file_config();

        
        if($this->form_validation->run() === FALSE){
            $method==='add'? $this->add() : $this->edit();
        }else{
            $data = [
                'keterangan'   => $this->input->post('keterangan', true),  
            ];

           foreach ($_FILES as $key => $val) {
                $img_src = FCPATH.'uploads/rsp/diklat/';
                $getdiklat = $this->uploadfile->getDiklatById($this->input->post('id_diklat', true));
                
                $error = '';
                if($key === 'file'){
                    if(!empty($_FILES['file']['name'])){
                        if (!$this->upload->do_upload('file')){
                            $error = $this->upload->display_errors();
                            show_error($error, 500, 'File Error');
                            exit();
                        }else{
                            if($method === 'edit'){
                                if(!unlink($img_src.$getdiklat->file)){
                                    show_error('Error saat delete gambar <br/>'.var_dump($getdiklat), 500, 'Error Edit Gambar');
                                    exit();
                                }
                            }
                            $data['file'] 		= $this->upload->data('file_name');
                            $data['tipe_file'] 	= $this->upload->data('file_type');
                        }
                    }
                }
            }
            
            if($method==='add'){
                //push array
                $data['created_date'] = date('Y-m-d H:i:s');
                $data['created_by'] = $user->id;
                
                //insert data
                $this->master->create('diklat', $data);
            }else if($method==='edit'){
                //push array
                $data['updated_date'] = date('Y-m-d H:i:s');
                $data['updated_by'] = $user->id;

                //update data
                $id_diklat = $this->input->post('id_diklat', true);
                $this->master->update('diklat', $data, 'id_diklat', $id_diklat);
            }else{
                show_error('Method tidak diketahui', 404);
            }
            redirect('rsp/diklat');
        }
	}

	public function delete()
	{
		$chk = $this->input->post('checked', true);
		if (!$chk) {
			$this->output_json(['status' => false]);
		} else {
			if ($this->master->delete('diklat', $chk, 'id_diklat')) {
				$this->output_json(['status' => true, 'total' => count($chk)]);
			}
		}
	}

	public function verify()
    {
        $user = $this->ion_auth->user()->row();
            
        //push array
        $data['status'] = $this->input->post('btn_submit', true);
        $data['verified_date'] = date('Y-m-d H:i:s');
        $data['verified_by'] = $user->id;

        //update data
        $id_diklat = $this->input->post('id_diklat', true);
        $this->master->update('diklat', $data, 'id_diklat', $id_diklat);
            
        redirect('rsp/diklat');
    }

	public function publish($id)
	{
		// Cek Publish
		$data = $this->uploadfile->getDiklatById($id);
		if ($data->publish == 'True') {
			$input = ['publish'	=> "False",
			'published_date'	=> date('Y-m-d H:i:s')]; 
		} else {
			$input = ['publish'	=> "True",
			'published_date'	=> date('Y-m-d H:i:s')];
		}

        $action = $this->master->update('diklat', $input, 'id_diklat', $id);

		if ($action) {
			$this->output_json(['status' => true]);
		} else {
			$this->output_json(['status' => false]);
		}
	}

}
