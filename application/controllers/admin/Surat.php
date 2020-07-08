<?php
class Surat extends CI_Controller{
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
		$title['judul'] = 'Daftar Surat';
		$title['active'] = 'surat';

		$data['warga'] = $this->m_crud->readBy('tbl_warga', array('status <>'=>-1));
		$data['judul'] = 'surat';

		$this->load->view('admin/includes/v_header', $title);
		$this->load->view('admin/surat/v_surat', $data);
		$this->load->view('admin/includes/v_footer');
	}

	function lihat($surat){
		$title['judul'] = CAPTION[$surat];
		$view = array('kelahiran' => 'v_surat_kelahiran', 'kematian'=>'v_surat_kematian', 'tdkmampu'=>'v_surat_tdkmampu', 'biodata'=>'v_surat_biodata', 'umum'=>'v_surat_umum', 'domisili'=>'v_surat_domisili');
		$title['active'] = 'surat';

		$tbl = TABEL[$surat];
		$data['baru'] = $this->m_crud->readBy($tbl, array('status'=>surat_baru));
		$data['proses'] = $this->m_crud->readBy($tbl, array('status'=>surat_proses));
		$data['selesai'] = $this->m_crud->readBy($tbl, array('status'=>surat_selesai));

		$data['judul'] = 'surat';
		$data['surat'] = $surat;

		$this->load->view('admin/includes/v_header', $title);
		$this->load->view("admin/surat/$view[$surat]", $data);
		$this->load->view('admin/includes/v_footer');
	}

	function detail($surat, $id){
		$tbl = TABEL[$surat];
		$caption = CAPTION[$surat];
		$view = array('kelahiran' => 'v_detail_kelahiran', 'kematian'=>'v_detail_kematian', 'tdkmampu'=>'v_detail_tdkmampu', 'biodata'=>'v_detail_biodata', 'umum'=>'v_detail_umum', 'domisili'=>'v_detail_domisili');

		$title['judul'] = "Detail $caption";
		$title['active'] = 'surat';
		$title['menu'] = "surat/lihat/$surat";

		$detail = $this->m_crud->readBy($tbl, array('id'=>$id));
		$data['detail'] = $detail[0];
		$data['judul'] = $title['judul'];
		$data['dusun'] = DUSUN;
		$data['surat'] = $surat;

		$this->load->view('admin/includes/v_header', $title);
		$this->load->view("admin/surat/$view[$surat]", $data);
		$this->load->view('admin/includes/v_footer');
	}

	function form($surat, $action){
		$tbl = TABEL;;
		$nosurat = array('kelahiran' => 'I', 'kematian'=>'II', 'tdkmampu'=>'III', 'biodata'=>'IV', 'umum'=>'V', 'domisili'=>'VI');
		$idsurat = array('kelahiran' => 'id_kelahiran', 'kematian'=>'id_kematian', 'tdkmampu'=>'id_tdk_mampu', 'biodata'=>'id_biodata', 'umum'=>'id_umum', 'domisili'=>'id_domisili');

		if (isset($_POST[$surat])) {
			$nik = $_POST['nik'];
			$data['nik'] = $nik;

			$check = $this->m_crud->readBy('tbl_warga', array("nik"=>$nik));
			if (count($check)>0) {
				$status = true;
				$config['allowed_types'] = 'jpg|png|jpeg|pdf';
				$config['max_size']      = 2048;

				if ($surat=='kelahiran') {
					// KELAHIRAN
					$data['hubungan'] = $_POST['hubungan'];
					$data['anak'] = $_POST['anak'];
					$data['tgl_lahir'] = $_POST['tgl_lahir'];
					$data['tempat_lahir'] = $_POST['tempatlahir'];
					$data['jk'] = $_POST['jk'];
					$data['ayah'] = $_POST['ayah'];
					$data['ibu'] = $_POST['ibu'];
					$data['rw'] = $_POST['rw'];
					$data['rt'] = $_POST['rt'];

					$config['upload_path']   = "./assets/img/surat/kelahiran";

					// Upload Pengantar
					$post = 'pengantar_file';
					if ($_FILES[$post]["name"]!="") {
						$filename = $_FILES[$post]['name'];

						$name = $this->m_crud->upload_file($nik, $filename, $post, $config);
						if ($name==false) {
							$status = false;
						} else {
							$data[$post] = $config['upload_path'].'/'.$name;
						}
					}

					// Upload Keterangan
					$post = 'ket_file';
					if ($_FILES[$post]["name"]!="") {
						$filename = $_FILES[$post]['name'];

						$name = $this->m_crud->upload_file($nik, $filename, $post, $config);
						if ($name==false) {
							$status = false;
						} else {
							$data[$post] = $config['upload_path'].'/'.$name;
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
							$data[$post] = $config['upload_path'].'/'.$name;
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
							$data[$post] = $config['upload_path'].'/'.$name;
						}
					}

					// Upload Buku Nikah
					$post = 'buku_file';
					if ($_FILES[$post]["name"]!="") {
						$filename = $_FILES[$post]['name'];

						$name = $this->m_crud->upload_file($nik, $filename, $post, $config);
						if ($name==false) {
							$status = false;
						} else {
							$data[$post] = $config['upload_path'].'/'.$name;
						}
					}
				} elseif ($surat=='kematian') {
					// KEMATIAN
					$data['hubungan'] = $_POST['hubungan'];
					$data['nik_alm'] = $_POST['nik_alm'];
					$data['nama'] = $_POST['nama_alm'];
					$data['tgl_lahir'] = $_POST['tgllahir'];
					$data['jk'] = $_POST['jk'];
					$data['kwn'] = $_POST['kwn'];
					$data['agama'] = $_POST['agama'];
					$data['status_kawin'] = $_POST['status_kawin'];
					$data['pekerjaan'] = $_POST['pekerjaan'];
					$data['alamat'] = $_POST['alamat'];

					$data['tgl_meninggal'] = $_POST['tgl_meninggal'];
					$data['tempat_meninggal'] = $_POST['tempat_meninggal'];
					$data['penyebab'] = $_POST['penyebab'];
					$data['penentu'] = $_POST['penentu'];

					$config['upload_path']   = "./assets/img/surat/kematian";

					// Upload Pengantar
					$post = 'pernyataan_file';
					if ($_FILES[$post]["name"]!="") {
						$filename = $_FILES[$post]['name'];

						$name = $this->m_crud->upload_file($nik, $filename, $post, $config);
						if ($name==false) {
							$status = false;
						} else {
							$data[$post] = $config['upload_path'].'/'.$name;
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
							$data[$post] = $config['upload_path'].'/'.$name;
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
							$data[$post] = $config['upload_path'].'/'.$name;
						}
					}

					// Upload KK Alm
					$post = 'kk_alm_file';
					if ($_FILES[$post]["name"]!="") {
						$filename = $_FILES[$post]['name'];

						$name = $this->m_crud->upload_file($nik, $filename, $post, $config);
						if ($name==false) {
							$status = false;
						} else {
							$data[$post] = $config['upload_path'].'/'.$name;
						}
					}

					// Upload KTP
					$post = 'ktp_alm_file';
					if ($_FILES[$post]["name"]!="") {
						$filename = $_FILES[$post]['name'];

						$name = $this->m_crud->upload_file($nik, $filename, $post, $config);
						if ($name==false) {
							$status = false;
						} else {
							$data[$post] = $config['upload_path'].'/'.$name;
						}
					}
				} elseif ($surat=='tdkmampu') {
					// TIDAK MAMPU
					$data['jenis'] = $_POST['jenis'];
					$data['nama_terkait'] = $_POST['nama_terkait'];
					$data['tujuan'] = $_POST['tujuan'];
					$data['pekerjaan'] = $_POST['pekerjaan'];
					$data['alamat'] = $_POST['alamat'];

					$config['upload_path']   = "./assets/img/surat/tidak_mampu";
					// Upload Pengantar
					$post = 'pengantar_file';
					if ($_FILES[$post]["name"]!="") {
						$filename = $_FILES[$post]['name'];

						$name = $this->m_crud->upload_file($nik, $filename, $post, $config);
						if ($name==false) {
							$status = false;
						} else {
							$data[$post] = $config['upload_path'].'/'.$name;
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
							$data[$post] = $config['upload_path'].'/'.$name;
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
							$data[$post] = $config['upload_path'].'/'.$name;
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
							$data[$post] = $config['upload_path'].'/'.$name;
						}
					}
				} elseif ($surat=='biodata') {
					// BIODATA
					$data['nama_kepala'] = $_POST['nama_kepala'];
					$data['alamat'] = $_POST['alamat'];

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
					$data['anggota'] = json_encode($anggota);


					$config['upload_path']   = "./assets/img/surat/biodata";

					// Upload Pengantar
					$post = 'pengantar_file';
					if ($_FILES[$post]["name"]!="") {
						$filename = $_FILES[$post]['name'];

						$name = $this->m_crud->upload_file($nik, $filename, $post, $config);
						if ($name==false) {
							$status = false;
						} else {
							$data[$post] = $config['upload_path'].'/'.$name;
						}
					}

					// Upload Akta Lahir
					$post = 'akta_lahir_file';
					if ($_FILES[$post]["name"]!="") {
						$filename = $_FILES[$post]['name'];

						$name = $this->m_crud->upload_file($nik, $filename, $post, $config);
						if ($name==false) {
							$status = false;
						} else {
							$data[$post] = $config['upload_path'].'/'.$name;
						}
					}

					// Upload Akta Kawin
					$post = 'akta_kawin_file';
					if ($_FILES[$post]["name"]!="") {
						$filename = $_FILES[$post]['name'];

						$name = $this->m_crud->upload_file($nik, $filename, $post, $config);
						if ($name==false) {
							$status = false;
						} else {
							$data[$post] = $config['upload_path'].'/'.$name;
						}
					}

					// Upload Ijazah
					$post = 'ijazah_file';
					if ($_FILES[$post]["name"]!="") {
						$filename = $_FILES[$post]['name'];

						$name = $this->m_crud->upload_file($nik, $filename, $post, $config);
						if ($name==false) {
							$status = false;
						} else {
							$data[$post] = $config['upload_path'].'/'.$name;
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
							$data[$post] = $config['upload_path'].'/'.$name;
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
							$data[$post] = $config['upload_path'].'/'.$name;
						}
					}
				} elseif ($surat=='umum') {
					// UMUM
					$data['tujuan'] = $_POST['tujuan'];

					$config['upload_path']   = "./assets/img/surat/umum";
					// Upload Pengantar
					$post = 'pengantar_file';
					if ($_FILES[$post]["name"]!="") {
						$filename = $_FILES[$post]['name'];

						$name = $this->m_crud->upload_file($nik, $filename, $post, $config);
						if ($name==false) {
							$status = false;
						} else {
							$data[$post] = $config['upload_path'].'/'.$name;
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
							$data[$post] = $config['upload_path'].'/'.$name;
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
							$data[$post] = $config['upload_path'].'/'.$name;
						}
					}
				} elseif ($surat=='domisili') {
					// DOMISILI
					$data['jenis'] = $_POST['jenis'];
					$data['nama_usaha'] = $_POST['nama_usaha'];
					$data['alamat'] = $_POST['alamat'];

					$config['upload_path']   = "./assets/img/surat/domisili";

					// Upload Pengantar
					$post = 'pengantar_file';
					if ($_FILES[$post]["name"]!="") {
						$filename = $_FILES[$post]['name'];

						$name = $this->m_crud->upload_file($nik, $filename, $post, $config);
						if ($name==false) {
							$status = false;
						} else {
							$data[$post] = $config['upload_path'].'/'.$name;
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
							$data[$post] = $config['upload_path'].'/'.$name;
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
							$data[$post] = $config['upload_path'].'/'.$name;
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
							$data[$post] = $config['upload_path'].'/'.$name;
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
							$data[$post] = $config['upload_path'].'/'.$name;
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
							$data[$post] = $config['upload_path'].'/'.$name;
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
							$data[$post] = $config['upload_path'].'/'.$name;
						}
					}
				}

				if($status){
					if ($action=="tambah") {
						$jumlah = $this->m_crud->read($tbl[$surat]);
						$id = count($jumlah)+1;
						$date = date("j/n/Y");
						$data[$idsurat[$surat]] = $id.'/'.$nosurat[$surat].'/'.$date;
						$pesan = $this->m_crud->save($tbl[$surat], $data);
					} elseif ($action=="ubah") {
						$id = $this->uri->segment(6);
						$pesan = $this->m_crud->update($tbl[$surat], $data, array('id'=>$id));
					}

					if ($pesan) {
						redirect(base_url("admin/surat/lihat/$surat"));
						die();
					}
				}
			} else {
				$this->session->set_flashdata( 'transaksi_error', '<div class="alert alert-danger" role="alert">Warga Tidak Terdaftar Di Dalam Sistem, Silahkan Masukkan Data Warga Terlebih Dahulu!</div>');
			}
		}

		if ($action=="tambah") {
			$kolom = $this->m_crud->daftar_kolom($tbl[$surat]);
			$hasil = new stdClass();
			foreach ($kolom as $key => $value) {
				$hasil->$value = '';
			}
			$data['hasil'] = $hasil;
		} elseif ($action=="ubah") {
			$id = $this->uri->segment(6);
			$hasil = $this->m_crud->readBy($tbl[$surat],array('id'=>$id))[0];
			$data['hasil'] = $hasil;
		}

		$data['judul'] = CAPTION[$surat];
		$view = array('kelahiran' => 'v_form_kelahiran', 'kematian'=>'v_form_kematian', 'tdkmampu'=>'v_form_tdkmampu', 'biodata'=>'v_form_biodata', 'umum'=>'v_form_umum', 'domisili'=>'v_form_domisili');

		$title['judul'] = "Form ".$data['judul'];
		$title['active'] = 'surat';
		$title['menu'] = "surat/lihat/$surat";
		$title['surat'] = $surat;

		$this->load->view('admin/includes/v_header', $title);
		$this->load->view("admin/surat/$view[$surat]", $data);
		$this->load->view('admin/includes/v_footer');
	}

	function proses($id, $surat, $status){
		$tbl = TABEL;
		$proses['status'] = $status;
		$pesan = $this->m_crud->update($tbl[$surat], $proses, array('id'=>$id));
		if ($pesan) {
			redirect(base_url("admin/surat/lihat/$surat"));
			die();
		}
	}

	function tolak($id, $surat){
		$tbl = TABEL;
		$pesan = $this->m_crud->delete($tbl[$surat], array('id'=>$id));
		redirect(base_url("admin/surat/lihat/$surat"));
	}

	public function cetak($id, $surat){
		$data = array(
			"dataku" => array(
				"nama" => "Petani Kode",
				"url" => "http://petanikode.com"
			)
		);

		$this->load->library('pdf');

		$this->pdf->setPaper('A4', 'potrait');
		$this->pdf->filename = "laporan-petanikode.pdf";
		$this->pdf->load_view('laporan_pdf', $data);
	}
}
