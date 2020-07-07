<?php
class Pengaduan extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
		if (!$this->session->userdata('nik_admin'))
		{
			redirect(base_url("admin/akun/masuk"));
		}
		$this->load->model('m_crud');
	}

	function index(){
		$title['judul'] = 'Daftar Pengaduan';
		$title['active'] = 'Pengaduan';

		$data['baru'] = $this->m_crud->readBy('detail_pengaduan', array('status'=>pengaduan_baru));
		$data['proses'] = $this->m_crud->readBy('detail_pengaduan', array('status'=>pengaduan_proses));
		$data['selesai'] = $this->m_crud->readBy('detail_pengaduan', array('status'=>pengaduan_selesai));

		$data['dusun'] = DUSUN;
		$data['judul'] = 'pengaduan';

		$this->load->view('admin/includes/v_header', $title);
		$this->load->view('admin/pengaduan/v_pengaduan', $data);
		$this->load->view('admin/includes/v_footer');
	}

	function detail($id){
		$title['judul'] = 'Detail Pengaduan';
		$title['active'] = 'pengaduan';

		$detail = $this->m_crud->readBy('detail_pengaduan', array('id_pengaduan'=>$id));
		$tahun = '2020';

		$footer['dana'] = $this->m_crud->readBy('tbl_dana', array('status !='=>-1, 'tahun'=>$tahun));

		$data['detail'] = $detail[0];
		$data['judul'] = 'pengaduan';
		$data['dusun'] = DUSUN;

		$this->load->view('admin/includes/v_header', $title);
		$this->load->view('admin/pengaduan/v_detail_pengaduan', $data);
		$this->load->view('admin/includes/v_footer', $footer);
	}

	function proses($id, $status){
		$proses['status'] = $status;
		$pesan = $this->m_crud->update('tbl_pengaduan', $proses, array('id_pengaduan'=>$id));
		if ($pesan) {
			redirect(base_url("admin/pengaduan"));
			die();
		}
	}

	function tolak($id){
		$pesan = $this->m_crud->delete('tbl_pengaduan', array('id_pengaduan'=>$id));
		redirect(base_url("admin/pengaduan"));
	}
}
