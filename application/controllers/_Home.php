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
            'subjudul'  => 'Detail',
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
			'subjudul' => 'Tambah',
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
			'subjudul'	=> 'Edit',
			'home' 		=> $this->uploadfile->getHomeById($id),
		];
		$this->load->view('_templates/dashboard/_header.php', $data);
		$this->load->view('home/edit');
		$this->load->view('_templates/dashboard/_footer.php');
	}

	public function validasi($kategori)
    {
		if ($kategori === 'Misi' || $kategori === 'Slogan'){
			$this->form_validation->set_rules('kategori', $kategori, 'required');
			$this->form_validation->set_rules('nama', 'Nama', 'required');
			$this->form_validation->set_rules('home', 'Home', 'required');
		}else if($kategori === 'IKM'){
			$this->form_validation->set_rules('kategori', $kategori, 'required');
			$this->form_validation->set_rules('home', 'Home', 'required');
		}else{
			$this->form_validation->set_rules('kategori', $kategori, 'required');
			$this->form_validation->set_rules('home', 'Home', 'required');
		}
        
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
		$id_home 	= $this->input->post('id_home', true);
		$home 		= $this->input->post('home', true);
		$nama 		= $this->input->post('nama', true);
		$this->validasi($kategori);
		$this->file_config();

		if ($this->form_validation->run() === FALSE) {
			$data = [
				'status'	=> false,
				'errors'	=> ['home' => form_error('home')]
			];
			$this->output_json($data);
		} else {
			

			if ($method === 'add') {
				$input = [
					'deskripsi'		=> $home,
					'kategori'		=> $kategori,
					'created_date'	=> date('Y-m-d H:i:s'),
					'created_by' 	=> $user->id
				];
				
				if ($kategori === 'Misi' || $kategori == 'Slogan'){
					$input['nama']	= $nama;
				}else if($kategori === 'IKM'){
					foreach ($_FILES as $key => $val){
						$img_src = FCPATH.'uploads/home/';
						$gethome = $this->uploadfile->getHomeById($id_home);
	
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
									$input['file'] = $this->upload->data('file_name');
									$input['tipe_file'] = $this->upload->data('file_type');
									$input['nama']	= $kategori;
								}
							}
						}
					}
				}else{
					$input['nama']	= $kategori;
				}
				$action = $this->master->create('home', $input);
			} else if ($method === 'edit') {
				$dbdata=$this->uploadfile->getHomeById($id_home);
				$input = [
					'deskripsi'		=> $home === '<p><br></p>' ? $dbdata->deskripsi : $home,
					'updated_date' 	=> date('Y-m-d H:i:s'),
					'updated_by' 	=> $user->id
				];

				if ($kategori === 'Misi' || $kategori == 'Slogan'){
					$input['nama']			= $nama === '' ? $dbdata->nama : $nama;
				}else if($kategori === 'IKM'){
					foreach ($_FILES as $key => $val){
						$img_src = FCPATH.'uploads/home/';
						$gethome = $this->uploadfile->getHomeById($id_home);
	
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
									$input['file'] = $this->upload->data('file_name');
									$input['tipe_file'] = $this->upload->data('file_type');
									$input['nama']	= $kategori;
								}
							}
						}
					}
				}else{
					$input['nama']			= $kategori;
				}
				
				$action = $this->master->update('home', $input, 'id_home', $id_home);
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

	public function preview()
	{
		$config['upload_path']		= './uploads/import/';
		$config['allowed_types']	= 'xls|xlsx|csv';
		$config['max_size']			= 2048;
		$config['encrypt_name']		= true;

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('upload_file')) {
			$error = $this->upload->display_errors();
			echo $error;
			die;
		} else {
			$file = $this->upload->data('full_path');
			$ext = $this->upload->data('file_ext');

			switch ($ext) {
				case '.xlsx':
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
					break;
				case '.xls':
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
					break;
				case '.csv':
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
					break;
				default:
					echo "unknown file ext";
					die;
			}

			$spreadsheet = $reader->load($file);
			$sheetData = $spreadsheet->getActiveSheet()->toArray();
			$data = [];
			for ($i = 1; $i < count($sheetData); $i++) {
				$data[] = [
					'nip' => $sheetData[$i][0],
					'nama_dosen' => $sheetData[$i][1],
					'email' => $sheetData[$i][2],
					'matkul_id' => $sheetData[$i][3]
				];
			}

			unlink($file);

			$this->import($data);
		}
	}

	public function do_import()
	{
		$input = json_decode($this->input->post('data', true));
		$data = [];
		foreach ($input as $d) {
			$data[] = [
				'nip' => $d->nip,
				'nama_dosen' => $d->nama_dosen,
				'email' => $d->email,
				'matkul_id' => $d->matkul_id
			];
		}

		$save = $this->master->create('dosen', $data, true);
		if ($save) {
			redirect('dosen');
		} else {
			redirect('dosen/import');
		}
	}
}
