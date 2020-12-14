<?php
class Pengaduan extends CI_Controller{
	function __construct(){
		parent::__construct();
		if (!$this->session->userdata('nik')){
			$allowed = array("lihat","detail");
			$method = $this->router->fetch_method();
			if(!in_array($method, $allowed)){
				redirect(base_url("akun/masuk"));
			}
		}
		$this->load->model('m_crud');
	}

	function index(){
		$title['judul'] = 'Aspirasi/Keluhan';
		$data = null;
		$this->load->view('includes/v_header', $title);
		$this->load->view('pengaduan/v_buat_pengaduan', $data);
		$this->load->view('includes/v_footer');
	}

	function buat_pengaduan(){
		$nik = $_SESSION['nik'];
		if (isset($_POST['pengaduan'])) {
			$this->form_validation->set_rules('judul', 'Judul', 'required', array('required'=>'Isi Judul'));
			$this->form_validation->set_rules('kategori', 'Kategori', 'required', array('required'=>'Isi Kategori'));
			$this->form_validation->set_rules('lokasi', 'Lokasi', 'required', array('required'=>'Isi Lokasi'));
			$this->form_validation->set_rules('bidang', 'Bidang', 'required', array('required'=>'Isi Bidang'));
			$this->form_validation->set_rules('uraian', 'Uraian', 'required', array('required'=>'Isi Uraian'));
			$this->form_validation->set_rules('ttd', 'TTD', 'required', array('required'=>'Isi TTD'));

			if ($this->form_validation->run() != false){
				$img = $_POST['ttd'];
				$img = str_replace('data:image/png;base64,', '', $img);
				$img = str_replace(' ', '+', $img);
				$data = base64_decode($img);
				$file = './assets/img/pengaduan/' . uniqid() . '.png';

				$success = file_put_contents($file, $data);
				$config['upload_path']   = "./assets/img/pengaduan/";
				$config['allowed_types'] = 'jpg|png|jpeg';
				$config['allowed_size'] = 2048;


				// Upload Pengantar
				$post = 'lampiran_file';
				$pengaduan[$post] = './assets/img/pengaduan/default.jpg';
				$status = true;

				if ($_FILES[$post]["name"]!="") {
					$filename = $_FILES[$post]['name'];

					$name = $this->m_crud->upload_file($nik, $filename, $post, $config);
					// if ($name!=="default.jpg") {
					// 	$status = true;
						$pengaduan[$post] = $config['upload_path'].$name;
					// } else {
					// 	$status = false;
					// }
				}
				$pengaduan['judul'] = $_POST['judul'];
				$pengaduan['kategori'] = $_POST['kategori'];
				$pengaduan['lokasi'] = $_POST['lokasi'];
				$pengaduan['bidang'] = $_POST['bidang'];
				$pengaduan['uraian'] = $_POST['uraian'];
				$pengaduan['nik'] = $nik;
				$pengaduan['ttd_file'] = $file;

				// if ($status) {
					$this->m_crud->save('tbl_pengaduan', $pengaduan);
					$this->session->set_flashdata('sukses', 'Buat Pengaduan Sukses!');
					redirect(base_url("pengaduan/riwayat"));
				// } else {
				// 	$this->session->set_flashdata( 'upload_error', '<div class="alert alert-danger" role="alert">Perhatikan Ukuran(Maks 2MB) atau Tipe File(JPG,PNG,PDF)!</div>');
				// }
			}
		}

		$title['judul'] = 'Buat Pengaduan';
		$data = null;
		$this->load->view('includes/v_header', $title);
		$this->load->view('pengaduan/v_buat_pengaduan', $data);
		$this->load->view('includes/v_footer');
	}

	function lihat($id){
		$pengaduan = $this->m_crud->readBy('detail_pengaduan', array('status='=>pengaduan_proses, 'bidang'=>$id));
		// $sql = "select `p`.`id_pengaduan` AS `id_pengaduan`,`p`.`judul` AS `judul`,`p`.`bidang` AS `bidang`,`p`.`lokasi` AS `lokasi`,`p`.`kategori` AS `kategori`,`p`.`uraian` AS `uraian`,`p`.`tgl_pengaduan` AS `tgl_pengaduan`,`p`.`status` AS `status`,`p`.`lampiran_file` AS `lampiran_file`,`p`.`nik` AS `nik`,`w`.`nama` AS `nama`,`w`.`no_telp` AS `no_telp`,`w`.`email` AS `email`,`w`.`rw` AS `rw`,`w`.`rt` AS `rt`,`p`.`ttd_file` AS `ttd_file` from (`tbl_pengaduan` `p` join `tbl_warga` `w` on((`p`.`nik` = `w`.`nik`)))";
		// $pengaduan = $this->db->query($sql." WHERE bidang='$id' AND p.status=".pengaduan_proses)->result();
		if ($id=="semua") {
			$active = "semua";
			$pengaduan = $this->m_crud->readBy('detail_pengaduan', array('status<>'=>pengaduan_ditolak));
			// $pengaduan = $this->db->query($sql." WHERE p.status<>".pengaduan_ditolak)->result();
		} elseif ($id=="infrastruktur") {
			$active = "infrastruktur";
		} elseif ($id=="pendidikan") {
			$active = "pendidikan";
		} elseif ($id=="kesehatan") {
			$active = "kesehatan";
		} elseif ($id=="administrasi") {
			$active = "administrasi";
		} elseif ($id=="kasus") {
			$active = "kasus";
		} elseif ($id=="lain") {
			$active = "lain";
		}
		$data['active'] = $active;

		$data['pengaduan'] = $pengaduan;
		$data['cont'] = $this;

		$title['judul'] = 'Lihat Pengaduan';
		$this->load->view('includes/v_header', $title);
		$this->load->view('pengaduan/v_lihat_pengaduan', $data);
		$this->load->view('includes/v_footer');
	}

	function riwayat(){
		$nik = $_SESSION['nik'];
		$title['judul'] = 'Riwayat Pengaduan';
		$data['pengaduan'] = $this->m_crud->readBy('tbl_pengaduan', array('nik'=>$nik));
		$data['cont'] = $this;
		$this->load->view('includes/v_header', $title);
		$this->load->view('pengaduan/v_riwayat_pengaduan', $data);
		$this->load->view('includes/v_footer');
	}

	function detail($id){
		$pengaduan = $this->m_crud->readBy('detail_pengaduan', array('id_pengaduan'=>$id));
		// $sql = "select `p`.`id_pengaduan` AS `id_pengaduan`,`p`.`judul` AS `judul`,`p`.`bidang` AS `bidang`,`p`.`lokasi` AS `lokasi`,`p`.`kategori` AS `kategori`,`p`.`uraian` AS `uraian`,`p`.`tgl_pengaduan` AS `tgl_pengaduan`,`p`.`status` AS `status`,`p`.`lampiran_file` AS `lampiran_file`,`p`.`nik` AS `nik`,`w`.`nama` AS `nama`,`w`.`no_telp` AS `no_telp`,`w`.`email` AS `email`,`w`.`rw` AS `rw`,`w`.`rt` AS `rt`,`p`.`ttd_file` AS `ttd_file` from (`tbl_pengaduan` `p` join `tbl_warga` `w` on((`p`.`nik` = `w`.`nik`)))";
		// $pengaduan = $this->db->query($sql." WHERE p.id_pengaduan=".$id)->result();

		$data['pengaduan'] = $pengaduan[0];
		$data['cont'] = $this;

		$data['tanggapan'] = $this->m_crud->readBy('detail_tanggapan_pengaduan', array('id_pengaduan'=>$id));
		// $data['tanggapan'] = null;

		$title['judul'] = 'Detail Pengaduan';
		$this->load->view('includes/v_header', $title);
		$this->load->view('pengaduan/v_detail_pengaduan', $data);
		$this->load->view('includes/v_footer');
	}

	function tanggapan($id){
		if (isset($_POST['tanggapan'])) {
			$pengaduan['tanggapan'] = $_POST['komen'];
			$pengaduan['id_pengaduan'] = $id;
			$pengaduan['nik'] = $_SESSION['nik'];
			$pesan = $this->m_crud->save('tbl_tanggapan_pengaduan', $pengaduan);
			if ($pesan) {
				redirect(base_url("pengaduan/detail/$id"));
				die();
			}
			var_dump($pesan);
		}
	}

	function cari(){
		if (isset($_POST['caripengaduan'])) {
			$id=$_POST['bidang'];
			$judul = $_POST['judul'];

			$pengaduan = $this->m_crud->selectLike('detail_pengaduan', array('status <>'=>pengaduan_ditolak, 'bidang'=>$_POST['bidang']), array('judul'=>$_POST['judul']));

			// $sql = "select `p`.`id_pengaduan` AS `id_pengaduan`,`p`.`judul` AS `judul`,`p`.`bidang` AS `bidang`,`p`.`lokasi` AS `lokasi`,`p`.`kategori` AS `kategori`,`p`.`uraian` AS `uraian`,`p`.`tgl_pengaduan` AS `tgl_pengaduan`,`p`.`status` AS `status`,`p`.`lampiran_file` AS `lampiran_file`,`p`.`nik` AS `nik`,`w`.`nama` AS `nama`,`w`.`no_telp` AS `no_telp`,`w`.`email` AS `email`,`w`.`rw` AS `rw`,`w`.`rt` AS `rt`,`p`.`ttd_file` AS `ttd_file` from `tbl_pengaduan` `p` join `tbl_warga` `w` on `p`.`nik` = `w`.`nik`";
			// $pengaduan = $this->db->query($sql." WHERE p.status<>".pengaduan_ditolak." AND bidang='".$_POST['judul']."' AND judul LIKE '%$judul%'")->result();
			if ($id=="semua") {
				$active = "semua";
				$pengaduan = $this->m_crud->selectLike('detail_pengaduan', array('status <>'=>pengaduan_ditolak), array('judul'=>$_POST['judul']));
				// $pengaduan = $this->db->query($sql." WHERE p.status<>".pengaduan_ditolak." AND judul LIKE '%".$_POST['judul']."%'")->result();
			}
			$data['pengaduan'] = $pengaduan;
			$data['active'] = $id;
			$data['cont'] = $this;

			$title['judul'] = 'Hasil Pencarian '.$_POST['judul'];
			$this->load->view('includes/v_header', $title);
			$this->load->view('pengaduan/v_lihat_pengaduan', $data);
			$this->load->view('includes/v_footer');
		}
	}

	function ubah($id){
		$nik = $_SESSION['nik'];
		if (isset($_POST['pengaduan'])) {
			$this->form_validation->set_rules('judul', 'Judul', 'required', array('required'=>'Isi Judul'));
			$this->form_validation->set_rules('kategori', 'Kategori', 'required', array('required'=>'Isi Kategori'));
			$this->form_validation->set_rules('lokasi', 'Lokasi', 'required', array('required'=>'Isi Lokasi'));
			$this->form_validation->set_rules('kategori', 'Kategori', 'required', array('required'=>'Isi Kategori'));
			$this->form_validation->set_rules('bidang', 'Bidang', 'required', array('required'=>'Isi Bidang'));
			$this->form_validation->set_rules('uraian', 'Uraian', 'required', array('required'=>'Isi Uraian'));

			if ($this->form_validation->run() != false){
				$pengaduan['judul'] = $_POST['judul'];
				$pengaduan['kategori'] = $_POST['kategori'];
				$pengaduan['lokasi'] = $_POST['lokasi'];
				$pengaduan['bidang'] = $_POST['bidang'];
				$pengaduan['uraian'] = $_POST['uraian'];
				$pengaduan['nik'] = $nik;

				$config['upload_path']   = "./assets/img/pengaduan/";
				$config['allowed_types'] = 'jpg|png|jpeg';
				$config['allowed_size'] = 2048;

				// Upload Pengantar
				$post = 'lampiran_file';
				$pengaduan[$post] = './assets/img/pengaduan/default.jpg';
				$status = true;

				if ($_FILES[$post]["name"]!="") {
					$filename = $_FILES[$post]['name'];

					$name = $this->m_crud->upload_file($nik, $filename, $post, $config);
					if ($name==false) {
						$status = false;
					} else {
						$pengaduan[$post] = $config['upload_path'].$name;
					}
				}

				if ($status) {
					$pesan = $this->m_crud->save('tbl_pengaduan', $pengaduan);
					if ($pesan) {
						redirect(base_url("pengaduan/riwayat"));
						die();
					}
				}
			}
		}

		$title['judul'] = 'Aspirasi/Keluhan';
		$data = null;
		$this->load->view('includes/v_header', $title);
		$this->load->view('pengaduan/v_buat_pengaduan', $data);
		$this->load->view('includes/v_footer');
	}

	function hapus($id){
		$pesan = $this->m_crud->hard_delete('tbl_pengaduan', array('id_pengaduan'=>$id));
		redirect(base_url("pengaduan/riwayat"));
	}

	function cek_status($id){
		switch ($id) {
			case pengaduan_baru:
			echo "Validasi";
			break;
			case pengaduan_proses:
			echo "Sudah Terbit";
			break;
			case pengaduan_selesai:
			echo "Dilanjutkan";
			default:
			echo "";
		}
	}
}
