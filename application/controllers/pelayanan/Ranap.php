<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ranap extends CI_Controller
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
			'judul'	=> 'Data Pelayanan Rawat Inap',
			'subjudul' => 'Pelayanan Rawat Inap'
		];

		$this->load->view('_templates/dashboard/_header.php', $data);
		$this->load->view('pelayanan/ranap/data');
		$this->load->view('_templates/dashboard/_footer.php');
	}

	public function data()
	{
        $this->output_json($this->uploadfile->getDataPelayananRanap(), false);	
	}

	public function add()
	{
		$data = [
			'user' => $this->ion_auth->user()->row(),
			'judul'	=> 'Pelayanan Rawat Inap',
			'subjudul' => 'Tambah Data',
			'ruang'		=> $this->uploadfile->getAllRuangan('1')
		];
		$this->load->view('_templates/dashboard/_header.php', $data);
		$this->load->view('pelayanan/ranap/add');
		$this->load->view('_templates/dashboard/_footer.php');
	}

	public function edit($id)
	{
		$data = [
			'user' 		=> $this->ion_auth->user()->row(),
			'judul'		=> 'Pelayanan Rawat Inap',
			'subjudul'	=> 'Edit Data',
			'data' 		=> $this->uploadfile->getPelayananRanap($id),
			'ruang'		=> $this->uploadfile->getAllRuangan('1')
		];
		$this->load->view('_templates/dashboard/_header.php', $data);
		$this->load->view('pelayanan/ranap/edit');
		$this->load->view('_templates/dashboard/_footer.php');
	}

	public function detail($id)
    {
        $user = $this->ion_auth->user()->row();
		$data = [
			'user'      => $user,
			'judul'	    => 'Pelayanan Rawat Inap',
            'subjudul'  => 'Detail',
            'data' 	=> $this->uploadfile->getPelayananRanapById($id)
        ];

        $this->load->view('_templates/dashboard/_header.php', $data);
		$this->load->view('pelayanan/ranap/detail');
		$this->load->view('_templates/dashboard/_footer.php');
    }

	public function validasi()
    {
		$this->form_validation->set_rules('ruang', 'Ruangan', 'required'); 
    }

	public function file_config()
    {
        $allowed_type 	= [
            "image/jpeg", "image/jpg", "image/png", "image/gif"
        ];
        $config['upload_path']      = FCPATH.'uploads/pelayanan/ranap/';
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
                'id_ruangan'=> $this->input->post('ruang', true), 
            ];

           foreach ($_FILES as $key => $val) {
                $img_src = FCPATH.'uploads/pelayanan/ranap/';
                $getdata = $this->uploadfile->getPelayananRanapById($this->input->post('id_pelayanan_ranap', true));
                
                $error = '';
                if($key === 'file'){
                    if(!empty($_FILES['file']['name'])){
                        if (!$this->upload->do_upload('file')){
                            $error = $this->upload->display_errors();
                            show_error($error, 500, 'File Error');
                            exit();
                        }else{
                            if($method === 'edit'){
                                if(!unlink($img_src.$getdata->file)){
                                    show_error('Error saat delete gambar <br/>'.var_dump($getdata), 500, 'Error Edit Gambar');
                                    exit();
                                }
                            }
                            $data['file'] = $this->upload->data('file_name');
                            $data['tipe_file'] = $this->upload->data('file_type');
                        }
                    }
                }
            }
            
            if($method==='add'){
                //push array
                $data['created_date'] = date('Y-m-d H:i:s');
                $data['created_by'] = $user->id;
                
                //insert data
                $this->master->create('pelayanan_ranap', $data);
            }else if($method==='edit'){
                //push array
                $data['updated_date'] = date('Y-m-d H:i:s');
                $data['updated_by'] = $user->id;

                //update data
                $id_pelayanan_ranap = $this->input->post('id_pelayanan_ranap', true);
                $this->master->update('pelayanan_ranap', $data, 'id_pelayanan_ranap', $id_pelayanan_ranap);
            }else{
                show_error('Method tidak diketahui', 404);
            }
            redirect('pelayanan/ranap');
        }
	}

	public function delete()
	{
		$chk = $this->input->post('checked', true);
		if (!$chk) {
			$this->output_json(['status' => false]);
		} else {
			if ($this->master->delete('pelayanan_ranap', $chk, 'id_pelayanan_ranap')) {
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
        $id_pelayanan_ranap = $this->input->post('id_pelayanan_ranap', true);
        $this->master->update('pelayanan_ranap', $data, 'id_pelayanan_ranap', $id_pelayanan_ranap);
            
        redirect('pelayanan/ranap');
    }

	public function publish($id)
	{
		// Cek Publish
		$data = $this->uploadfile->getPelayananRanapById($id);
		if ($data->publish == 'True') {
			$input = ['publish'	=> "False",	
			'published_date'	=> date('Y-m-d H:i:s')]; 
		} else {
			$input = ['publish'	=> "True",
			'published_date'	=> date('Y-m-d H:i:s')];
		}

        $action = $this->master->update('pelayanan_ranap', $input, 'id_pelayanan_ranap', $id);

		if ($action) {
			$this->output_json(['status' => true]);
		} else {
			$this->output_json(['status' => false]);
		}
	}

}
