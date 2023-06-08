<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Writer\Csv;

class Tipe extends CI_Controller
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
			'judul'	=> 'Tipe',
			'subjudul' => 'Data Tipe'
		];
		$this->load->view('_templates/dashboard/_header', $data);
		$this->load->view('master/tipe/data');
		$this->load->view('_templates/dashboard/_footer');
	}

	public function add()
	{
		$data = [
			'user' 		=> $this->ion_auth->user()->row(),
			'judul'		=> 'Tambah Tipe',
			'subjudul'	=> 'Tambah Data Tipe',
			'banyak'	=> $this->input->post('banyak', true)
		];
		$this->load->view('_templates/dashboard/_header', $data);
		$this->load->view('master/tipe/add');
		$this->load->view('_templates/dashboard/_footer');
	}

	public function data()
	{
		$this->output_json($this->master->getDataJurusan(), false);
	}

	public function edit()
	{
		$chk = $this->input->post('checked', true);
		if (!$chk) {
			redirect('jurusan');
		} else {
			$jurusan = $this->master->getJurusanById($chk);
			$data = [
				'user' 		=> $this->ion_auth->user()->row(),
				'judul'		=> 'Edit Tipe',
				'subjudul'	=> 'Edit Data Tipe',
				'jurusan'	=> $jurusan
			];
			$this->load->view('_templates/dashboard/_header', $data);
			$this->load->view('master/tipe/edit');
			$this->load->view('_templates/dashboard/_footer');
		}
	}

	public function save()
	{
		$rows = count($this->input->post('nama_jurusan', true));
		$mode = $this->input->post('mode', true);
		for ($i = 1; $i <= $rows; $i++) {
			$nama_jurusan = 'nama_jurusan[' . $i . ']';
			$this->form_validation->set_rules($nama_jurusan, 'Jurusan', 'required');
			$this->form_validation->set_message('required', '{field} Wajib diisi');

			if ($this->form_validation->run() === FALSE) {
				$error[] = [
					$nama_jurusan => form_error($nama_jurusan)
				];
				$status = FALSE;
			} else {
				if ($mode == 'add') {
					$insert[] = [
						'nama_jurusan' => $this->input->post($nama_jurusan, true)
					];
				} else if ($mode == 'edit') {
					$update[] = array(
						'id_jurusan'	=> $this->input->post('id_jurusan[' . $i . ']', true),
						'nama_jurusan' 	=> $this->input->post($nama_jurusan, true)
					);
				}
				$status = TRUE;
			}
		}
		if ($status) {
			if ($mode == 'add') {
				$this->master->create('jurusan', $insert, true);
				$data['insert']	= $insert;
			} else if ($mode == 'edit') {
				$this->master->update('jurusan', $update, 'id_jurusan', null, true);
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
			if ($this->master->delete('jurusan', $chk, 'id_jurusan')) {
				$this->output_json(['status' => true, 'total' => count($chk)]);
			}
		}
	}

	public function load_jurusan()
	{
		$data = $this->master->getJurusan();
		$this->output_json($data);
	}

}
