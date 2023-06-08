<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Writer\Csv;

class Poli extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if (!$this->ion_auth->logged_in()) {
			redirect('auth');
		} else if (!$this->ion_auth->is_admin()) {
			show_error('Hanya Administrator yang diberi hak untuk mengakses halaman ini, <a href="' . base_url('dashboard') . '">Kembali ke menu awal</a>', 403, 'Akses Terlarang');
		}
		$this->load->library(['datatables', 'form_validation']); // Load Library Ignited-Datatables
		$this->load->model('Master_model', 'master');
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
			'judul'	=> 'Poli',
			'subjudul' => 'Data Poli'
		];
		$this->load->view('_templates/dashboard/_header', $data);
		$this->load->view('master/poli/data');
		$this->load->view('_templates/dashboard/_footer');
	}

	public function add()
	{
		$data = [
			'user' 		=> $this->ion_auth->user()->row(),
			'judul'		=> 'Tambah Poli',
			'subjudul'	=> 'Tambah Data Poli',
			'banyak'	=> $this->input->post('banyak', true)
		];
		$this->load->view('_templates/dashboard/_header', $data);
		$this->load->view('master/poli/add');
		$this->load->view('_templates/dashboard/_footer');
	}

	public function data()
	{
		$this->output_json($this->master->getDataPoli(), false);
	}

	public function edit()
	{
		$chk = $this->input->post('checked', true);
		if (!$chk) {
			redirect('poli');
		} else {
			$poli = $this->master->getPoliById($chk);
			$data = [
				'user' 		=> $this->ion_auth->user()->row(),
				'judul'		=> 'Edit Poli',
				'subjudul'	=> 'Edit Data Poli',
				'poli'		=> $poli
			];
			$this->load->view('_templates/dashboard/_header', $data);
			$this->load->view('master/poli/edit');
			$this->load->view('_templates/dashboard/_footer');
		}
	}

	public function save()
	{
		$rows = count($this->input->post('nama_poli', true));
		$mode = $this->input->post('mode', true);
		for ($i = 1; $i <= $rows; $i++) {
			$nama_poli = 'nama_poli[' . $i . ']';
			$kelas_id = 'kelas_id[' . $i . ']';
			$this->form_validation->set_rules($nama_poli, 'Poli', 'required');
			$this->form_validation->set_message('required', '{field} Wajib diisi');

			if ($this->form_validation->run() === FALSE) {
				$error[] = [
					$nama_poli => form_error($nama_poli)
				];
				$status = FALSE;
			} else {
				if ($mode == 'add') {
					$insert[] = [
						'nama_poli' => $this->input->post($nama_poli, true),
						'kelas_id' => $this->input->post($kelas_id, true)
					];
				} else if ($mode == 'edit') {
					$update[] = array(
						'id_poli'	=> $this->input->post('id_poli[' . $i . ']', true),
						'nama_poli' 	=> $this->input->post($nama_poli, true)
					);
				}
				$status = TRUE;
			}
		}
		if ($status) {
			if ($mode == 'add') {
				$this->master->create('poli', $insert, true);
				$data['insert']	= $insert;
			} else if ($mode == 'edit') {
				$this->master->update('poli', $update, 'id_poli', null, true);
				$data['update'] = $update;
			}
		} else {
			if (isset($error)) {
				$data['errors'] = $error;
			}
		}
		$data['status'] = $status;
		$this->output_json($data);
	}

	public function delete()
	{
		$chk = $this->input->post('checked', true);
		if (!$chk) {
			$this->output_json(['status' => false]);
		} else {
			if ($this->master->delete('poli', $chk, 'id_poli')) {
				$this->output_json(['status' => true, 'total' => count($chk)]);
			}
		}
	}

	public function load_poli()
	{
		$data = $this->master->getPoli();
		$this->output_json($data);
	}
	
}
