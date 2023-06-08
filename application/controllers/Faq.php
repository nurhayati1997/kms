<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Faq extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if (!$this->ion_auth->logged_in()) {
			redirect('auth');
		} else if (!$this->ion_auth->is_admin() && !$this->ion_auth->in_group('Verifikator') && !$this->ion_auth->in_group('Creator')) {
			show_error('Hanya Administrator yang diberi hak untuk mengakses halaman ini, <a href="' . base_url('dashboard') . '">Kembali ke menu awal</a>', 403, 'Akses Terlarang');
		}
		$this->load->library(['datatables', 'form_validation']); // Load Library Ignited-Datatables
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
			'judul'	=> 'FAQ',
			'subjudul' => 'Data FAQ'
		];
		$this->load->view('_templates/dashboard/_header.php', $data);
		$this->load->view('faq/data');
		$this->load->view('_templates/dashboard/_footer.php');
	}

	public function data()
	{
		$this->output_json($this->uploadfile->getDataFaq(), false);
	}

	public function add()
	{
		$data = [
			'user' 		=> $this->ion_auth->user()->row(),
			'judul'		=> 'Tambah FAQ',
			'subjudul'	=> 'Tambah Data FAQ',
			'banyak'	=> $this->input->post('banyak', true)
		];
		$this->load->view('_templates/dashboard/_header.php', $data);
		$this->load->view('faq/add');
		$this->load->view('_templates/dashboard/_footer.php');
	}

	public function edit()
	{
		$chk = $this->input->post('checked', true);
		if (!$chk) {
			redirect('faq');
		} else {
			$faq = $this->uploadfile->getFaqById($chk);
			$data = [
				'user' 		=> $this->ion_auth->user()->row(),
				'judul'		=> 'Edit FAQ',
				'subjudul'	=> 'Edit Data FAQ',
				'faq'		=> $faq
			];
			$this->load->view('_templates/dashboard/_header.php', $data);
			$this->load->view('faq/edit');
			$this->load->view('_templates/dashboard/_footer.php');
		}
	}

	public function save()
	{
		$rows = count($this->input->post('pertanyaan', true));
		$mode = $this->input->post('mode', true);
		for ($i = 1; $i <= $rows; $i++) {
			$pertanyaan 	= 'pertanyaan[' . $i . ']';
			$jawaban 		= 'jawaban[' . $i . ']';
			$this->form_validation->set_rules($pertanyaan, 'Pertanyaan', 'required');
			$this->form_validation->set_rules($jawaban, 'Jawaban', 'required');
			$this->form_validation->set_message('required', '{field} Wajib diisi');

			if ($this->form_validation->run() === FALSE) {
				$error[] = [
					$pertanyaan 	=> form_error($pertanyaan),
					$jawaban 		=> form_error($jawaban),
				];
				$status = FALSE;
			} else {
				if ($mode == 'add') {
					$insert[] = [
						'pertanyaan' 	=> $this->input->post($pertanyaan, true),
						'jawaban' 		=> $this->input->post($jawaban, true),
					];
				} else if ($mode == 'edit') {
					$update[] = array(
						'id_faq'		=> $this->input->post('id_faq[' . $i . ']', true),
						'pertanyaan' 	=> $this->input->post($pertanyaan, true),
						'jawaban' 		=> $this->input->post($jawaban, true),
					);
				}
				$status = TRUE;
			}
		}
		if ($status) {
			if ($mode == 'add') {
				$this->master->create('faq', $insert, true);
				$data['insert']	= $insert;
			} else if ($mode == 'edit') {
				$this->master->update('faq', $update, 'id_faq', null, true);
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
			if ($this->master->delete('faq', $chk, 'id_faq')) {
				$this->output_json(['status' => true, 'total' => count($chk)]);
			}
		}
	}

}
