<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
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
			'judul'	=> 'Home',
			'subjudul' => 'Master Data Home'
		];
		$this->load->view('_templates/dashboard/_header.php', $data);
		$this->load->view('home/data');
		$this->load->view('_templates/dashboard/_footer.php');
	}

	public function data()
	{
		$kategori = $this->input->post('kategori', true);
		$this->output_json($this->uploadfile->getDataHome($kategori), false);
	}

	public function detail($id)
    {
        $user = $this->ion_auth->user()->row();
		$data = [
			'user'      => $user,
			'judul'	    => 'Home',
            'subjudul'  => 'Detail Data',
            'home' 		=> $this->uploadfile->getHomeById($id)
        ];

        $this->load->view('_templates/dashboard/_header.php', $data);
		$this->load->view('home/detail');
		$this->load->view('_templates/dashboard/_footer.php');
    }

	public function add($kategori)
	{
		$data = [
			'user' => $this->ion_auth->user()->row(),
			'judul'	=> 'Home',
			'subjudul' => 'Tambah Data',
			'kategori' => $kategori
		];
		$this->load->view('_templates/dashboard/_header.php', $data);
		$this->load->view('home/add');
		$this->load->view('_templates/dashboard/_footer.php');
	}

	public function edit($id)
	{
		$data = [
			'user' 		=> $this->ion_auth->user()->row(),
			'judul'		=> 'Home',
			'subjudul'	=> 'Edit Data',
			'home' 		=> $this->uploadfile->getHomeById($id),
		];
		$this->load->view('_templates/dashboard/_header.php', $data);
		$this->load->view('home/edit');
		$this->load->view('_templates/dashboard/_footer.php');
	}

	public function validasi($kategori)
    {
		$this->form_validation->set_rules('kategori', $kategori, 'required');
		$this->form_validation->set_rules('deskripsi', $kategori, 'required');
    }

	public function file_config()
    {
        $allowed_type 	= [
            "image/jpeg", "image/jpg", "image/png", "image/gif"
        ];
        $config['upload_path']      = FCPATH.'uploads/home/';
        $config['allowed_types']    = 'jpeg|jpg|png|gif';
        $config['encrypt_name']     = TRUE;
        
        return $this->load->library('upload', $config);
    }

	public function save()
	{
		$user 		= $this->ion_auth->user()->row();
		$method 	= $this->input->post('method', true);
		$kategori	= $this->input->post('kategori', true);
		
		$this->validasi($kategori);
		$this->file_config();

		if ($this->form_validation->run() === FALSE) {
			$method==='add'? $this->add($kategori) : $this->edit();
		}else{
			if ($kategori === 'Slogan'){
				$data = [
					'deskripsi'	=> $this->input->post('deskripsi', true),
					'kategori'	=> $kategori,  
				];
			}else if($kategori === 'IKM'){
				foreach ($_FILES as $key => $val){
					$img_src = FCPATH.'uploads/home/';
					$gethome = $this->uploadfile->getHomeById($this->input->post('id_home', true));

					$error = '';
					if ($key === 'file'){
						if (!empty($_FILES['file']['name'])){
							if (!$this->upload->do_upload('file')){
								$error = $this->upload->display_errors();
								show_error($error, 500, 'File Error');
								exit();
							}else{
								if($method === 'edit'){
									if(!unlink($img_src.$gethome->nama)){
										show_error('Error saat delete gambar <br/>'.var_dump($gethome), 500, 'Error Edit Gambar');
										exit();
									}
								}
								$data = [
									'deskripsi'	=> $this->input->post('deskripsi', true),
									'kategori'	=> $kategori,
									'file'		=> $this->upload->data('file_name'),
									'tipe_file'	=> $this->upload->data('file_type'),
								];
							}
						}
					}
				}
			}else{
				$data = [
					'deskripsi'	=> $this->input->post('deskripsi', true),
					'kategori'	=> $kategori,  
				];
			}
			
			if ($method === 'add') {
                $data['created_date'] = date('Y-m-d H:i:s');
                $data['created_by'] = $user->id;

				$action = $this->master->create('home', $data);
			}else if($method==='edit'){
				$data['updated_date'] = date('Y-m-d H:i:s');
                $data['updated_by'] = $user->id;

				$id_home 	= $this->input->post('id_home', true);
				$action = $this->master->update('home', $data, 'id_home', $id_home);
			}else{
                show_error('Method tidak diketahui', 404);
            }
			redirect('home');
		}
	}

	public function delete()
	{
		$chk = $this->input->post('checked', true);
		if (!$chk) {
			$this->output_json(['status' => false]);
		} else {
			if ($this->master->delete('home', $chk, 'id_home')) {
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
        $id_home = $this->input->post('id_home', true);
        $this->master->update('home', $data, 'id_home', $id_home);
            
        redirect('home');
    }

	public function publish($id_home)
	{
		// Cek Publish
		$data = $this->uploadfile->getHomeById($id_home);
		if ($data->publish == 'True') {
			$input = ['publish'	=> "False",
			'published_date'	=> date('Y-m-d H:i:s')]; 
		} else {
			$input = ['publish'	=> "True",
			'published_date'	=> date('Y-m-d H:i:s')];
		}

        $action = $this->master->update('home', $input, 'id_home', $id_home);

		if ($action) {
			$this->output_json(['status' => true]);
		} else {
			$this->output_json(['status' => false]);
		}
	}

}
