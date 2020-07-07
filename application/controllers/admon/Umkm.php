<?php
class Umkm extends CI_Controller{
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
		$title['judul'] = 'Daftar UMKM';
		$title['active'] = 'umkm';

		$data['hasil'] = $this->m_crud->readBy('detail_umkm', array('status !='=>-1));
		$data['judul'] = 'umkm';

		$this->load->view('admin/includes/v_header', $title);
		$this->load->view('admin/umkm/v_umkm', $data);
		$this->load->view('admin/includes/v_footer');
	}

	function form($action){
		$nik = $_SESSION['nik_admin'];
		if (isset($_POST['umkm'])) {
			$store['nama'] = $_POST['nama'];
			$store['bidang'] = $_POST['bidang'];
			$store['nik_pemilik'] = $_POST['nik_pemilik'];
			$store['alamat'] = $_POST['alamat'];
			$store['deskripsi'] = $_POST['deskripsi'];
			$store['tgl_berdiri'] = $_POST['tgl_berdiri'];
			$store['no_telp'] = $_POST['no_telp'];

			$status	= true;
			$post = "logo_file";
			$store[$post] = './assets/img/umkm/default.jpg';
			if ($_FILES[$post]["name"]!="") {
				$filename = $_FILES[$post]['name'];
				$logo['upload_path']   = "./assets/img/umkm/";
				$logo['allowed_types'] = 'jpg|png|jpeg';
				$logo['max_size']      = 2048;

				$name = $this->m_crud->upload_file($nik, $filename, $post, $logo);
				if ($name==false) {
					$status = false;
				} else {
					$store[$post] = base_url("assets/img/umkm/").$name;
				}
			}

			if ($status) {
				if ($action=="tambah") {
					$pesan = $this->m_crud->save('tbl_umkm', $store);
				} else {
					$id = $this->uri->segment(5);
					$pesan = $this->m_crud->update('tbl_umkm', $store, array('id_umkm'=>$id));
				}

				if ($pesan==true) {
					redirect(base_url("admin/umkm"));
					die();
				}
			}
		}

		if ($action=="tambah") {
			$kolom = $this->m_crud->daftar_kolom('tbl_umkm');
			$detail = new stdClass();
			foreach ($kolom as $key => $value) {
				$detail->$value = '';
			}
			$data['detail'] = $detail;
		} elseif ($action=="ubah") {
			$id = $this->uri->segment(5);
			$detail = $this->m_crud->readBy('tbl_umkm',array('id_umkm'=>$id))[0];
			$data['detail'] = $detail;
		}

		$title['judul'] = 'Form UMKM';
		$title['active'] = 'umkm';
		$data['judul'] = 'umkm';

		$this->load->view('admin/includes/v_header', $title);
		$this->load->view('admin/umkm/v_umkm_form', $data);
		$this->load->view('admin/includes/v_footer');
	}

	function hapus($id){
		$pesan = $this->m_crud->delete('tbl_umkm', array('id_umkm'=>$id));
		redirect(base_url("admin/umkm"));
	}
}
