<?php
class Surat extends CI_Controller{
	function __construct(){
		parent::__construct();
		if ($this->session->userdata('status')==0){
			redirect(base_url("akun/profil"));
		} elseif (!$this->session->userdata('nik')){
			$allowed = array("none");
			$method = $this->router->fetch_method();
			if(!in_array($method, $allowed)){
				redirect(base_url("akun/masuk"));
			}
		}
		$this->load->model('m_crud');
	}

	function index(){
		$title['judul'] = 'Pengurusan Surat';
		$data = null;
		$this->load->view('includes/v_header', $title);
		$this->load->view('surat/v_surat', $data);
		$this->load->view('includes/v_footer');
	}

	function buat_kelahiran(){
		// if (isset($_POST['kelahiran'])) {
		// $this->form_validation->set_rules('pengantar_file', 'Pengantar', 'required');
		// $this->form_validation->set_rules('ket_file', 'Bukti Kelahiran', 'required');
		// $this->form_validation->set_rules('kk_file', 'KK', 'required');
		// $this->form_validation->set_rules('ktp_file', 'KTP', 'required');
		// $this->form_validation->set_rules('buku_file', 'Buku Nikah', 'required');
		$this->form_validation->set_rules('anak', 'Nama Anak', 'required');
		$this->form_validation->set_rules('tgllahir', 'Tanggal Lahir', 'required');
		$this->form_validation->set_rules('tempatlahir', 'Tempat Lahir', 'required');
		$this->form_validation->set_rules('ayah', 'Nama Ayah', 'required');
		$this->form_validation->set_rules('ibu', 'Nama Ibu', 'required');
		if ($this->form_validation->run() != FALSE){
			$nik = $_SESSION['nik'];
			$default_img = "default.jpg";
			$kelahiran['nik'] = $nik;
			$kelahiran['hubungan'] = $_POST['hubungan'];
			$kelahiran['anak'] = preg_replace("/[^a-zA-Z\s]+/", "", $_POST['anak']);
			$kelahiran['tgl_lahir'] = $_POST['tgllahir'];
			$kelahiran['tempat_lahir'] = $_POST['tempatlahir'];
			$kelahiran['jk'] = $_POST['jk'];
			$kelahiran['ayah'] = preg_replace("/[^a-zA-Z\s]+/", "", $_POST['ayah']);
			$kelahiran['ibu'] = preg_replace("/[^a-zA-Z\s]+/", "", $_POST['ibu']);
			$kelahiran['rw'] = $_POST['rw'];
			$kelahiran['rt'] = $_POST['rt'];

			$config['allowed_types'] = 'jpg|png|jpeg|pdf';
			$config['max_size']      = 2048;
			$config['upload_path']   = "./assets/img/surat/kelahiran/";

			// $status = true;
			// $lampiran = array("pengantar_file","ket_file","kk_file","ktp_file","buku_file");
			// foreach ($lampiran as $kl => $vl) {
			// 	$post = $vl;
			// 	$filename = $_FILES[$post]['name'];
			// 	$name = $this->m_crud->upload_file($nik, $filename, $post, $config);
			// 	if ($name!=$default_img) {
			// 		$kelahiran[$post] = $config['upload_path'].'/'.$name;
			// 	} else {
			// 		$status = false;
			// 		break;
			// 	}
			// }
			$pengantar_file = $this->m_crud->upload_file($nik, $_FILES['pengantar_file']['name'], "pengantar_file", $config);
			$ket_file = $this->m_crud->upload_file($nik, $_FILES['ket_file']['name'], "ket_file", $config);
			$kk_file = $this->m_crud->upload_file($nik, $_FILES['kk_file']['name'], "kk_file", $config);
			$ktp_file = $this->m_crud->upload_file($nik, $_FILES['ktp_file']['name'], "ktp_file", $config);
			$buku_file = $this->m_crud->upload_file($nik, $_FILES['buku_file']['name'], "buku_file", $config);

			if ($pengantar_file!=$default_img && $ket_file!=$default_img && $kk_file!=$default_img && $ktp_file!=$default_img && $buku_file!=$default_img) {
				$kelahiran['pengantar_file'] = $config['upload_path'].$pengantar_file;
				$kelahiran['ket_file'] = $config['upload_path'].$ket_file;
				$kelahiran['kk_file'] = $config['upload_path'].$kk_file;
				$kelahiran['ktp_file'] = $config['upload_path'].$ktp_file;
				$kelahiran['buku_file'] = $config['upload_path'].$buku_file;

				$id = $this->m_crud->saveID('tbl_kelahiran', $kelahiran);
				$this->m_crud->update('tbl_kelahiran', array('id_kelahiran'=>$id.'/I/'.date("j/n/Y")), array('id'=>$id));
				$this->session->set_flashdata('sukses', 'Buat Surat Sukses!');
				redirect(base_url("surat/riwayat"));
			}
		}
		//  else {
		// 	$this->session->set_flashdata( 'error', '<div class="col-md-12 alert alert-danger text-center">Tolong Lengkapi Data</div>');
		// }
		$title['judul'] = 'Surat Kelahiran';
		$this->load->view('includes/v_header', $title);
		$this->load->view('surat/v_surat_kelahiran');
		$this->load->view('includes/v_footer');
		// }
	}

	function kematian(){
		$nik = $_SESSION['nik'];
		if (isset($_POST['kematian'])) {
			$kematian['nik'] = $nik;
			$kematian['hubungan'] = $_POST['hubungan'];
			$kematian['nik_alm'] = $_POST['nik_alm'];
			$kematian['nama'] = $_POST['nama_alm'];
			$kematian['tgl_lahir'] = $_POST['tgllahir'];
			$kematian['jk'] = $_POST['jk'];
			$kematian['kwn'] = $_POST['kwn'];
			$kematian['agama'] = $_POST['agama'];
			$kematian['status_kawin'] = $_POST['status_kawin'];
			$kematian['pekerjaan'] = $_POST['pekerjaan'];
			$kematian['alamat'] = $_POST['alamat'];

			$kematian['tgl_meninggal'] = $_POST['tgl_meninggal'];
			$kematian['tempat_meninggal'] = $_POST['tempat_meninggal'];
			$kematian['penyebab'] = $_POST['penyebab'];
			$kematian['penentu'] = $_POST['penentu'];

			$status = true;
			$config['allowed_types'] = 'jpg|png|jpeg|pdf';
			$config['max_size']      = 2048;

			// Upload Pengantar
			$post = 'pernyataan_file';
			if ($_FILES[$post]["name"]!="") {
				$filename = $_FILES[$post]['name'];
				$config['upload_path']   = "./assets/img/surat/kematian";

				$name = $this->m_crud->upload_file($nik, $filename, $post, $config);
				if ($name==false) {
					$status = false;
				} else {
					$kematian[$post] = $config['upload_path'].'/'.$name;
				}
			}

			// Upload KK
			$post = 'kk_file';
			if ($_FILES[$post]["name"]!="") {
				$filename = $_FILES[$post]['name'];
				$config['upload_path']   = "./assets/img/surat/kematian";

				$name = $this->m_crud->upload_file($nik, $filename, $post, $config);
				if ($name==false) {
					$status = false;
				} else {
					$kematian[$post] = $config['upload_path'].'/'.$name;
				}
			}

			// Upload KTP
			$post = 'ktp_file';
			if ($_FILES[$post]["name"]!="") {
				$filename = $_FILES[$post]['name'];
				$config['upload_path']   = "./assets/img/surat/kematian";

				$name = $this->m_crud->upload_file($nik, $filename, $post, $config);
				if ($name==false) {
					$status = false;
				} else {
					$kematian[$post] = $config['upload_path'].'/'.$name;
				}
			}

			// Upload KK Alm
			$post = 'kk_alm_file';
			if ($_FILES[$post]["name"]!="") {
				$filename = $_FILES[$post]['name'];
				$config['upload_path']   = "./assets/img/surat/kematian";

				$name = $this->m_crud->upload_file($nik, $filename, $post, $config);
				if ($name==false) {
					$status = false;
				} else {
					$kematian[$post] = $config['upload_path'].'/'.$name;
				}
			}

			// Upload KTP
			$post = 'ktp_alm_file';
			if ($_FILES[$post]["name"]!="") {
				$filename = $_FILES[$post]['name'];
				$config['upload_path']   = "./assets/img/surat/kematian";

				$name = $this->m_crud->upload_file($nik, $filename, $post, $config);
				if ($name==false) {
					$status = false;
				} else {
					$kematian[$post] = $config['upload_path'].'/'.$name;
				}
			}

			$jumlah = $this->m_crud->read('tbl_kematian');
			$id = count($jumlah)+1;
			$date = date("j/n/Y");
			$kematian['id_kematian'] = $id.'/II/'.$date;

			if($status){
				$pesan = $this->m_crud->save('tbl_kematian', $kematian);
				if ($pesan) {
					redirect(base_url("surat/riwayat"));
					die();
				}
			}
		}

		$data['perkawinan'] = PERKAWINAN;
		$data['pekerjaan'] = PEKERJAAN;
		$data['agama'] = AGAMA;

		$title['judul'] = 'Surat Kematian';
		$this->load->view('includes/v_header', $title);
		$this->load->view('surat/v_surat_kematian', $data);
		$this->load->view('includes/v_footer');
	}

	function tidak_mampu(){
		$nik = $_SESSION['nik'];
		if (isset($_POST['tdkmampu'])) {
			$tdkmampu['nik'] = $nik;

			$tdkmampu['jenis'] = $_POST['jenis'];
			$tdkmampu['nama_terkait'] = $_POST['nama_terkait'];
			$tdkmampu['tujuan'] = $_POST['tujuan'];
			$tdkmampu['pekerjaan'] = $_POST['pekerjaan'];
			$tdkmampu['alamat'] = $_POST['alamat'];

			$status = true;
			$config['allowed_types'] = 'jpg|png|jpeg|pdf';
			$config['max_size']      = 2048;

			// Upload Pengantar
			$post = 'pengantar_file';
			if ($_FILES[$post]["name"]!="") {
				$filename = $_FILES[$post]['name'];
				$config['upload_path']   = "./assets/img/surat/tidak_mampu";

				$name = $this->m_crud->upload_file($nik, $filename, $post, $config);
				if ($name==false) {
					$status = false;
				} else {
					$tdkmampu[$post] = $config['upload_path'].'/'.$name;
				}
			}

			// Upload Pernyataan
			$post = 'pernyataan_file';
			if ($_FILES[$post]["name"]!="") {
				$filename = $_FILES[$post]['name'];
				$config['upload_path']   = "./assets/img/surat/tidak_mampu";

				$name = $this->m_crud->upload_file($nik, $filename, $post, $config);
				if ($name==false) {
					$status = false;
				} else {
					$tdkmampu[$post] = $config['upload_path'].'/'.$name;
				}
			}

			// Upload KK
			$post = 'kk_file';
			if ($_FILES[$post]["name"]!="") {
				$filename = $_FILES[$post]['name'];
				$config['upload_path']   = "./assets/img/surat/tidak_mampu";

				$name = $this->m_crud->upload_file($nik, $filename, $post, $config);
				if ($name==false) {
					$status = false;
				} else {
					$tdkmampu[$post] = $config['upload_path'].'/'.$name;
				}
			}

			// Upload KTP
			$post = 'ktp_file';
			if ($_FILES[$post]["name"]!="") {
				$filename = $_FILES[$post]['name'];
				$config['upload_path']   = "./assets/img/surat/tidak_mampu";

				$name = $this->m_crud->upload_file($nik, $filename, $post, $config);
				if ($name==false) {
					$status = false;
				} else {
					$tdkmampu[$post] = $config['upload_path'].'/'.$name;
				}
			}

			$jumlah = $this->m_crud->read('tbl_tdk_mampu');
			$id = count($jumlah)+1;
			$date = date("j/n/Y");
			$tdkmampu['id_tdk_mampu'] = $id.'/III/'.$date;

			if($status){
				$pesan = $this->m_crud->save('tbl_tdk_mampu', $tdkmampu);
				if ($pesan) {
					redirect(base_url("surat/riwayat"));
					die();
				}
			}
		}

		$data['pekerjaan'] = PEKERJAAN;

		$title['judul'] = 'Surat Tidak Mampu';
		$this->load->view('includes/v_header', $title);
		$this->load->view('surat/v_surat_tdkmampu', $data);
		$this->load->view('includes/v_footer');
	}

	function biodata(){
		$nik = $_SESSION['nik'];
		if (isset($_POST['biodata'])) {
			$biodata['nik'] = $nik;

			$biodata['nama_kepala'] = $_POST['nama_kepala'];
			$biodata['alamat'] = $_POST['alamat'];

			$anggota = array();
			for ($i=0; $i < count($_POST['nama']); $i++) {
				$nama = $_POST['nama'][$i];
				$nik = $_POST['nik'][$i];
				$jk = $_POST['jk'][$i];
				$tempat = $_POST['tempat'][$i];
				$tgl = $_POST['tgl'][$i];
				$jk = $_POST['jk'][$i];
				$hubungan = $_POST['hubungan'][$i];
				$pendidikan = $_POST['pendidikan'][$i];
				$goldar = $_POST['goldar'][$i];
				$kawin = $_POST['kawin'][$i];
				$agama = $_POST['agama'][$i];
				$pekerjaan = $_POST['pekerjaan'][$i];
				$ayah = $_POST['ayah'][$i];
				$ibu = $_POST['ibu'][$i];

				array_push($anggota, array('nama'=>$nama,'nik'=>$nik,'jk'=>$jk,'tempat'=>$tempat,'tgl'=>$tgl,'jk'=>$jk,'hubungan'=>$hubungan,'pendidikan'=>$pendidikan,'goldar'=>$goldar,'kawin'=>$kawin,'agama'=>$agama,'pekerjaan'=>$pekerjaan,'ayah'=>$ayah,'ibu'=>$ibu));
			}
			$biodata['anggota'] = json_encode($anggota);

			$status = true;
			$config['allowed_types'] = 'jpg|png|jpeg|pdf';
			$config['max_size']      = 2048;

			// Upload Pengantar
			$post = 'pengantar_file';
			if ($_FILES[$post]["name"]!="") {
				$filename = $_FILES[$post]['name'];
				$config['upload_path']   = "./assets/img/surat/biodata";

				$name = $this->m_crud->upload_file($nik, $filename, $post, $config);
				if ($name==false) {
					$status = false;
				} else {
					$biodata[$post] = $config['upload_path'].'/'.$name;
				}
			}

			// Upload Akta Lahir
			$post = 'akta_lahir_file';
			if ($_FILES[$post]["name"]!="") {
				$filename = $_FILES[$post]['name'];
				$config['upload_path']   = "./assets/img/surat/biodata";

				$name = $this->m_crud->upload_file($nik, $filename, $post, $config);
				if ($name==false) {
					$status = false;
				} else {
					$biodata[$post] = $config['upload_path'].'/'.$name;
				}
			}

			// Upload Akta Kawin
			$post = 'akta_kawin_file';
			if ($_FILES[$post]["name"]!="") {
				$filename = $_FILES[$post]['name'];
				$config['upload_path']   = "./assets/img/surat/biodata";

				$name = $this->m_crud->upload_file($nik, $filename, $post, $config);
				if ($name==false) {
					$status = false;
				} else {
					$biodata[$post] = $config['upload_path'].'/'.$name;
				}
			}

			// Upload Ijazah
			$post = 'ijazah_file';
			if ($_FILES[$post]["name"]!="") {
				$filename = $_FILES[$post]['name'];
				$config['upload_path']   = "./assets/img/surat/biodata";

				$name = $this->m_crud->upload_file($nik, $filename, $post, $config);
				if ($name==false) {
					$status = false;
				} else {
					$biodata[$post] = $config['upload_path'].'/'.$name;
				}
			}

			// Upload KK
			$post = 'kk_file';
			if ($_FILES[$post]["name"]!="") {
				$filename = $_FILES[$post]['name'];
				$config['upload_path']   = "./assets/img/surat/biodata";

				$name = $this->m_crud->upload_file($nik, $filename, $post, $config);
				if ($name==false) {
					$status = false;
				} else {
					$biodata[$post] = $config['upload_path'].'/'.$name;
				}
			}

			// Upload KTP
			$post = 'ktp_file';
			if ($_FILES[$post]["name"]!="") {
				$filename = $_FILES[$post]['name'];
				$config['upload_path']   = "./assets/img/surat/biodata";

				$name = $this->m_crud->upload_file($nik, $filename, $post, $config);
				if ($name==false) {
					$status = false;
				} else {
					$biodata[$post] = $config['upload_path'].'/'.$name;
				}
			}

			$jumlah = $this->m_crud->read('tbl_biodata');
			$id = count($jumlah)+1;
			$date = date("j/n/Y");
			$biodata['id_biodata'] = $id.'/IV/'.$date;

			if($status){
				$pesan = $this->m_crud->save('tbl_biodata', $biodata);
				if ($pesan) {
					redirect(base_url("surat/riwayat"));
					die();
				}
			}
		}

		$data['pendidikan'] = PENDIDIKAN;
		$data['perkawinan'] = PERKAWINAN;
		$data['goldar'] = GOLDAR;
		$data['agama'] = AGAMA;
		$data['pekerjaan'] = PEKERJAAN;

		$title['judul'] = 'Surat Biodata Penduduk';
		$this->load->view('includes/v_header', $title);
		$this->load->view('surat/v_surat_biodata', $data);
		$this->load->view('includes/v_footer');
	}

	function umum(){
		$nik = $_SESSION['nik'];
		if (isset($_POST['umum'])) {
			$umum['nik'] = $nik;

			$umum['tujuan'] = $_POST['tujuan'];

			$config['upload_path']   = "./assets/img/surat/umum";
			$config['allowed_types'] = 'jpg|png|jpeg|pdf';
			$config['allowed_size'] = 2048;
			$status = true;

			$lampiran = array("pengantar_file","kk_file","ktp_file");
			foreach ($lampiran as $kl => $vl) {
				$post = $vl;
				$filename = $_FILES[$post]['name'];
				$config['upload_path']   = "./assets/img/surat/umum";

				$name = $this->m_crud->upload_file($nik, $filename, $post, $config);
				$umum[$post] = $config['upload_path'].'/'.$name;
			}
			// // Upload Pengantar
			// $post = 'pengantar_file';
			// if ($_FILES[$post]["name"]!="") {
			// 	$filename = $_FILES[$post]['name'];
			//
			// 	$name = $this->m_crud->upload_file($nik, $filename, $post, $config);
			// 	// if ($name==false) {
			// 	// 	$status = false;
			// 	// } else {
			// 	// }
			// 	$umum[$post] = $config['upload_path'].'/'.$name;
			// }
			//
			// // Upload KK
			// $post = 'kk_file';
			// if ($_FILES[$post]["name"]!="") {
			// 	$filename = $_FILES[$post]['name'];
			//
			// 	$name = $this->m_crud->upload_file($nik, $filename, $post, $config);
			// 	if ($name==false) {
			// 		$status = false;
			// 	} else {
			// 		$umum[$post] = $config['upload_path'].'/'.$name;
			// 	}
			// }
			//
			// // Upload KTP
			// $post = 'ktp_file';
			// if ($_FILES[$post]["name"]!="") {
			// 	$filename = $_FILES[$post]['name'];
			//
			// 	$name = $this->m_crud->upload_file($nik, $filename, $post, $config);
			// 	if ($name==false) {
			// 		$status = false;
			// 	} else {
			// 		$umum[$post] = $config['upload_path'].'/'.$name;
			// 	}
			// }

			$jumlah = $this->m_crud->read('tbl_umum');
			$id = count($jumlah)+1;
			$date = date("j/n/Y");
			$umum['id_umum'] = $id.'/V/'.$date;

			if($status){
				$pesan = $this->m_crud->save('tbl_umum', $umum);
				if ($pesan) {
					redirect(base_url("surat/riwayat"));
					die();
				}
			}
		}

		$title['judul'] = 'Surat Umum';
		$this->load->view('includes/v_header', $title);
		$this->load->view('surat/v_surat_umum');
		$this->load->view('includes/v_footer');
	}

	function domisili(){
		$nik = $_SESSION['nik'];
		if (isset($_POST['domisili'])) {
			$domisili['nik'] = $nik;

			$domisili['jenis'] = $_POST['jenis'];
			$domisili['nama_usaha'] = $_POST['nama_usaha'];
			$domisili['alamat'] = $_POST['alamat'];

			$config['upload_path']   = "./assets/img/surat/domisili";
			$config['allowed_types'] = 'jpg|png|jpeg|pdf';
			$status = true;

			// Upload Pengantar
			$post = 'pengantar_file';
			if ($_FILES[$post]["name"]!="") {
				$filename = $_FILES[$post]['name'];

				$name = $this->m_crud->upload_file($nik, $filename, $post, $config);
				if ($name==false) {
					$status = false;
				} else {
					$domisili[$post] = $config['upload_path'].'/'.$name;
				}
			}

			// Upload KK
			$post = 'kk_file';
			if ($_FILES[$post]["name"]!="") {
				$filename = $_FILES[$post]['name'];

				$name = $this->m_crud->upload_file($nik, $filename, $post, $config);
				if ($name==false) {
					$status = false;
				} else {
					$domisili[$post] = $config['upload_path'].'/'.$name;
				}
			}

			// Upload KTP
			$post = 'ktp_file';
			if ($_FILES[$post]["name"]!="") {
				$filename = $_FILES[$post]['name'];

				$name = $this->m_crud->upload_file($nik, $filename, $post, $config);
				if ($name==false) {
					$status = false;
				} else {
					$domisili[$post] = $config['upload_path'].'/'.$name;
				}
			}

			// Upload Akta Usaha
			$post = 'akta_usaha_file';
			if ($_FILES[$post]["name"]!="") {
				$filename = $_FILES[$post]['name'];

				$name = $this->m_crud->upload_file($nik, $filename, $post, $config);
				if ($name==false) {
					$status = false;
				} else {
					$domisili[$post] = $config['upload_path'].'/'.$name;
				}
			}

			// Upload Pernyataan
			$post = 'pernyataan_file';
			if ($_FILES[$post]["name"]!="") {
				$filename = $_FILES[$post]['name'];

				$name = $this->m_crud->upload_file($nik, $filename, $post, $config);
				if ($name==false) {
					$status = false;
				} else {
					$domisili[$post] = $config['upload_path'].'/'.$name;
				}
			}

			// Upload Perjanjian
			$post = 'perjanjian_file';
			if ($_FILES[$post]["name"]!="") {
				$filename = $_FILES[$post]['name'];

				$name = $this->m_crud->upload_file($nik, $filename, $post, $config);
				if ($name==false) {
					$status = false;
				} else {
					$domisili[$post] = $config['upload_path'].'/'.$name;
				}
			}

			// Upload Kepemilikan
			$post = 'kepemilikan_file';
			if ($_FILES[$post]["name"]!="") {
				$filename = $_FILES[$post]['name'];

				$name = $this->m_crud->upload_file($nik, $filename, $post, $config);
				if ($name==false) {
					$status = false;
				} else {
					$domisili[$post] = $config['upload_path'].'/'.$name;
				}
			}

			$jumlah = $this->m_crud->read('tbl_domisili');
			$id = count($jumlah)+1;
			$date = date("j/n/Y");
			$domisili['id_domisili'] = $id.'/VI/'.$date;

			if($status){
				$pesan = $this->m_crud->save('tbl_domisili', $domisili);
				if ($pesan) {
					redirect(base_url("surat/riwayat"));
					die();
				}
			}
		}

		$title['judul'] = 'Surat Domisili';
		$this->load->view('includes/v_header', $title);
		$this->load->view('surat/v_surat_domisili');
		$this->load->view('includes/v_footer');
	}

	function riwayat(){
		$nik = $_SESSION['nik'];
		$data['kelahiran'] = $this->m_crud->readBy('tbl_kelahiran', array('nik'=>$nik));
		$data['kematian'] = $this->m_crud->readBy('tbl_kematian', array('nik'=>$nik));
		$data['tdk_mampu'] = $this->m_crud->readBy('tbl_tdk_mampu', array('nik'=>$nik));
		$data['umum'] = $this->m_crud->readBy('tbl_umum', array('nik'=>$nik));
		$data['domisili'] = $this->m_crud->readBy('tbl_domisili', array('nik'=>$nik));
		$data['biodata'] = $this->m_crud->readBy('tbl_biodata', array('nik'=>$nik));
		$data['surat'] = $this;

		$title['judul'] = 'Riwayat Surat';
		$this->load->view('includes/v_header', $title);
		$this->load->view('surat/v_surat_riwayat', $data);
		$this->load->view('includes/v_footer');
	}

	function cek_status($id){
		switch ($id) {
			case 0:
			echo "Tahap Validasi";
			break;
			case 1:
			echo "Tahap Proses";
			break;
			case 2:
			echo "Bisa Diambil";
			break;
			case 3:
			echo "Sudah Diterima";
			break;
			default:
			echo "Surat Ditolak";
		}
	}

	function tes(){
		// var_dump($_POST);
		$anggota = array();
		for ($i=0; $i < count($_POST['nama']); $i++) {
			$nama = $_POST['nama'][$i];
			$nik = $_POST['nik'][$i];
			$jk = $_POST['jk'][$i];
			$tempat = $_POST['tempat'][$i];
			$tgl = $_POST['tgl'][$i];
			$jk = $_POST['jk'][$i];
			$hubungan = $_POST['hubungan'][$i];
			$pendidikan = $_POST['pendidikan'][$i];
			$goldar = $_POST['goldar'][$i];
			$kawin = $_POST['kawin'][$i];
			$agama = $_POST['agama'][$i];
			$pekerjaan = $_POST['pekerjaan'][$i];
			$ayah = $_POST['ayah'][$i];
			$ibu = $_POST['ibu'][$i];

			array_push($anggota, array('nama'=>$nama,'nik'=>$nik,'jk'=>$jk,'tempat'=>$tempat,'tgl'=>$tgl,'jk'=>$jk,'hubungan'=>$hubungan,'pendidikan'=>$pendidikan,'goldar'=>$goldar,'kawin'=>$kawin,'agama'=>$agama,'pekerjaan'=>$pekerjaan,'ayah'=>$ayah,'ibu'=>$ibu));
		}
		$biodata['anggota'] = json_encode($anggota);
	}
}
