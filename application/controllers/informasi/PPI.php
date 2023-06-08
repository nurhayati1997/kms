<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PPI extends CI_Controller
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
			'judul'	=> 'Data PPI',
			'subjudul' => 'Informasi'
		];
		$this->load->view('_templates/dashboard/_header.php', $data);
		$this->load->view('informasi/ppi/data');
		$this->load->view('_templates/dashboard/_footer.php');
	}

	public function data()
	{
		$this->output_json($this->uploadfile->getDataPPI(), false);
	}

	public function add()
	{
		$data = [
			'user' => $this->ion_auth->user()->row(),
			'judul'	=> 'PPI',
			'subjudul' => 'Tambah Data'
		];
		$this->load->view('_templates/dashboard/_header.php', $data);
		$this->load->view('informasi/ppi/add');
		$this->load->view('_templates/dashboard/_footer.php');
	}

	public function edit($id)
	{
		$data = [
			'user' 		=> $this->ion_auth->user()->row(),
			'judul'		=> 'PPI',
			'subjudul'	=> 'Informasi',
			'ppi' 		=> $this->uploadfile->getPPIById($id)
		];
		$this->load->view('_templates/dashboard/_header.php', $data);
		$this->load->view('informasi/ppi/edit');
		$this->load->view('_templates/dashboard/_footer.php');
	}

	public function detail($id)
    {
        $user = $this->ion_auth->user()->row();
		$data = [
			'user'      => $user,
			'judul'	    => 'PPI',
            'subjudul'  => 'Informasi',
            'ppi' 		=> $this->uploadfile->getPPIById($id)
        ];

        $this->load->view('_templates/dashboard/_header.php', $data);
		$this->load->view('informasi/ppi/detail');
		$this->load->view('_templates/dashboard/_footer.php');
    }

	public function validasi()
    {
        $this->form_validation->set_rules('kegiatan', 'Kegiatan', 'required');
		$this->form_validation->set_rules('definisi', 'Definisi', 'required');   
    }

	public function save()
	{
		$this->validasi();

		$user 		= $this->ion_auth->user()->row();
		$method 	= $this->input->post('method', true);
		
		if ($this->form_validation->run() == FALSE) {
			$data = [
				'status'	=> false,
				'errors'	=> [
					'kegiatan' => form_error('kegiatan'),
					'definisi' => form_error('definisi'),
				]
			];
			$this->output_json($data);
		} else {
			$input = [
				'kegiatan' 		=> $this->input->post('kegiatan', true),
				'definisi' 		=> $this->input->post('definisi', true),
			];
			if ($method === 'add') {
				$input['created_date']	= date('Y-m-d H:i:s');
                $input['created_by'] 	= $user->id;

				$action = $this->master->create('ppi', $input);
			} else if ($method === 'edit') {
				$input['updated_date']	= date('Y-m-d H:i:s');
                $input['updated_by'] 	= $user->id;
				
				$id_ppi 	= $this->input->post('id_ppi', true);
				$action = $this->master->update('ppi', $input, 'id_ppi', $id_ppi);
			}

			if ($action) {
				$this->output_json(['status' => true]);
			} else {
				$this->output_json(['status' => false]);
			}
		}
	}

	public function delete()
	{
		$chk = $this->input->post('checked', true);
		if (!$chk) {
			$this->output_json(['status' => false]);
		} else {
			if ($this->master->delete('dokter', $chk, 'id_dokter')) {
				$this->output_json(['status' => true, 'total' => count($chk)]);
			}
		}
	}

	public function verify()
    {
        $user = $this->ion_auth->user()->row();
            
        //push array
        $data['status'] 		= $this->input->post('btn_submit', true);
        $data['verified_date'] 	= date('Y-m-d H:i:s');
        $data['verified_by'] 	= $user->id;

        //update data
        $id_ppi = $this->input->post('id_ppi', true);
        $this->master->update('ppi', $data, 'id_ppi', $id_ppi);
            
        redirect('informasi/ppi');
    }

	public function publish($id)
	{
		// Cek Publish
		$data = $this->uploadfile->getPPIById($id);
		if ($data->publish == 'True') {
			$input = ['publish'	=> "False",
			'published_date'	=> date('Y-m-d H:i:s')]; 
		} else {
			$input = ['publish'	=> "True",
			'published_date'	=> date('Y-m-d H:i:s')];
		}

        $action = $this->master->update('ppi', $input, 'id_ppi', $id);

		if ($action) {
			$this->output_json(['status' => true]);
		} else {
			$this->output_json(['status' => false]);
		}
	}

}
