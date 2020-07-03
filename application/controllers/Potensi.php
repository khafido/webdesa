<?php
class Potensi extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->model('m_crud');
	}

	function index(){
		$title['judul'] = 'Profil Desa';
		$this->load->view('includes/v_header', $title);
		$this->load->view('v_profil');
		$this->load->view('includes/v_footer');
	}

	function profil(){
		$title['judul'] = 'Profil Desa';
		$this->load->view('includes/v_header', $title);
		$this->load->view('potensi/v_profil');
		$this->load->view('includes/v_footer');
	}

	function goldar(){
		$title['judul'] = 'Data Golongan Darah';
		$this->load->view('includes/v_header', $title);
		$this->load->view('potensi/v_goldar');
		$this->load->view('includes/v_footer');
	}

	function pendidikan(){
		$title['judul'] = 'Data Pendidikan';
		$this->load->view('includes/v_header', $title);
		$this->load->view('potensi/v_pendidikan');
		$this->load->view('includes/v_footer');
	}

	function pekerjaan(){
		$title['judul'] = 'Data Pekerjaan';
		$this->load->view('includes/v_header', $title);
		$this->load->view('potensi/v_pekerjaan');
		$this->load->view('includes/v_footer');
	}

	function agama(){
		$title['judul'] = 'Data Agama';
		$this->load->view('includes/v_header', $title);
		$this->load->view('potensi/v_agama');
		$this->load->view('includes/v_footer');
	}

	function bumdes(){
		$title['judul'] = 'Data BUMDes';
		$this->load->view('includes/v_header', $title);
		$this->load->view('potensi/v_bumdes');
		$this->load->view('includes/v_footer');
	}
}
