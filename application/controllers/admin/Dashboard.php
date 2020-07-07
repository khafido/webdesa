<?php
class Dashboard extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
    $this->load->model('m_crud');
		if (!$this->session->userdata('nik_admin'))
		{
      redirect(base_url("admin/akun/masuk"));
		}
	}

	function index(){
		$title['judul'] = 'Dashboard';
    $title['active'] = 'dashboard';
		$data = null;
		$this->load->view('admin/includes/v_header', $title);
    $this->load->view('admin/v_dashboard', $data);
		$this->load->view('admin/includes/v_footer');
	}
}
