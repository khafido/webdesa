<?php
class Kegiatan extends CI_Controller{
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
		$title['judul'] = 'Daftar Kegiatan';
		$title['active'] = 'Kegiatan';

		$data['hasil'] = $this->m_crud->readBy('detail_kegiatan', array('status'=>kegiatan_baru));
		$data['rencana'] = $this->m_crud->readBy('detail_kegiatan', array('status'=>kegiatan_rencana));
		$data['proses'] = $this->m_crud->readBy('detail_kegiatan', array('status'=>kegiatan_proses));
		$data['selesai'] = $this->m_crud->readBy('detail_kegiatan', array('status'=>kegiatan_selesai));
		$data['arsip'] = $this->m_crud->readBy('detail_kegiatan', array('status'=>kegiatan_arsip));

		$data['dusun'] = DUSUN;
		$data['judul'] = 'kegiatan';

		$this->load->view('admin/includes/v_header', $title);
		$this->load->view('admin/kegiatan/v_kegiatan', $data);
		$this->load->view('admin/includes/v_footer');
	}

	function detail($id){
		$title['judul'] = 'Detail Kegiatan';
		$title['active'] = 'kegiatan';

		$detail = $this->m_crud->readBy('detail_kegiatan', array('id_kegiatan'=>$id));
		$item = $this->m_crud->readBy('tbl_item_keuangan', array('id_kegiatan'=>$id));
		$fisik = $this->m_crud->readBy('tbl_item_fisik', array('id_kegiatan'=>$id));
		$data['itemkeuangan'] = json_encode($item);
		$data['itemfisik'] = json_encode($fisik);
		$data['item'] = count($item);

		$data['detail'] = $detail[0];
		$data['judul'] = 'kegiatan';
		$data['dusun'] = DUSUN;

		$this->load->view('admin/includes/v_header', $title);
		$this->load->view('admin/kegiatan/v_detail_kegiatan', $data);
		$this->load->view('admin/includes/v_footer');
	}

	function form($action){
		$nik = $_SESSION['nik_admin'];
		if (isset($_POST['nama'])) {
			$store['nama'] = $_POST['nama'];
			$store['bidang'] = $_POST['bidang'];
			$store['tgl_mulai'] = $_POST['tgl_mulai'];
			$store['tgl_selesai'] = $_POST['tgl_selesai'];
			$store['output'] = $_POST['output'];
			$store['kode'] = $_POST['dana'];
			$store['ketua_pelaksana'] = $_POST['ketua'];

			$status	= true;
			$post = 'lampiran';
			if ($_FILES[$post]["name"]!="") {
				$filename = $_FILES[$post]['name'];
				$foto_config['upload_path']   = "./assets/img/kegiatan/";
				$foto_config['allowed_types'] = 'jpg|png|jpeg';
				$foto_config['max_size']      = 2048;

				$name = $this->m_crud->upload_file($nik, $filename, $post, $foto_config);
				if ($name==false) {
					$status = false;
				} else {
					$store['lampiran_file'] = $name;
				}
			}

			if ($status) {
				if ($action=="tambah") {
					$id = $this->uri->segment(5);
					$store['id_pengaduan'] = $id;
					$pengaduan['status'] = pengaduan_selesai;
					$this->m_crud->update('tbl_pengaduan', $pengaduan, array('id_pengaduan'=>$id));
					$pesan = $this->m_crud->save('tbl_kegiatan', $store);
				} else {
					$id = $this->uri->segment(5);
					$pesan = $this->m_crud->update('tbl_kegiatan', $store, array('id_kegiatan'=>$id));
				}

				if ($pesan==true) {
					redirect(base_url("admin/kegiatan"));
					die();
				}
			}
		}

		if ($action=="tambah") {
			$kolom = $this->m_crud->daftar_kolom('tbl_kegiatan');
			$detail = new stdClass();
			foreach ($kolom as $key => $value) {
				$detail->$value = '';
			}
			$data['detail'] = $detail;
		} elseif ($action=="ubah") {
			$id = $this->uri->segment(5);
			$detail = $this->m_crud->readBy('tbl_kegiatan',array('id_kegiatan'=>$id))[0];
			$data['detail'] = $detail;
		}

		$data['d_jk'] = JK;
		$data['d_goldar'] = GOLDAR;
		$data['d_agama'] = AGAMA;
		$data['d_pendidikan'] = PENDIDIKAN;
		$data['d_pekerjaan'] = PEKERJAAN;
		$data['d_rw'] = DUSUN;
		$data['judul'] = 'kegiatan';

		$title['judul'] = 'Form Kegiatan';
		$title['active'] = 'kegiatan';
		$data['dana'] = $this->m_crud->read('tbl_dana');

		$this->load->view('admin/includes/v_header', $title);
		$this->load->view('admin/kegiatan/v_kegiatan_form', $data);
		$this->load->view('admin/includes/v_footer');
	}

	function buat_itemkeuangan($id){
		$item = array();
		if (isset($_POST['rencana'])) {
			for ($i=0; $i < count($_POST['kode']); $i++) {
				$kode = $_POST['kode'][$i];
				$uraian = $_POST['uraian'][$i];
				$volume = $_POST['volume'][$i];
				$satuan = $_POST['satuan'][$i];
				$harga_satuan = $_POST['harga'][$i];
				$jumlah = (int)$volume * (int)$harga_satuan;
				array_push($item, array('kode'=>$kode, 'uraian'=>$uraian, 'volume'=>$volume, 'satuan'=>$satuan, 'harga_satuan'=>$harga_satuan, 'jumlah'=>$jumlah, 'id_kegiatan'=>$id));
			}
			$keu = $this->m_crud->saveBatch('tbl_item_keuangan', $item);

			$store['status'] = kegiatan_rencana;
			$keg = $this->m_crud->update('tbl_kegiatan', $store, array('id_kegiatan'=>$id));
			if ($keu==true && $keg==true) {
				redirect(base_url("admin/kegiatan"));
				die();
			}
		}
	}

	function ubah_itemkeuangan($id){
		$item = array();
		if (isset($_POST['rencana'])) {
			for ($i=0; $i < count($_POST['kode']); $i++) {
				$kode = $_POST['kode'][$i];
				$uraian = $_POST['uraian'][$i];
				$volume = $_POST['volume'][$i];
				$satuan = $_POST['satuan'][$i];
				$harga_satuan = $_POST['harga'][$i];
				$jumlah = (int)$volume * (int)$harga_satuan;
				array_push($item, array('kode'=>$kode, 'uraian'=>$uraian, 'volume'=>$volume, 'satuan'=>$satuan, 'harga_satuan'=>$harga_satuan, 'jumlah'=>$jumlah, 'id_kegiatan'=>$id));
			}

			$this->m_crud->hard_delete('tbl_item_keuangan', array('id_kegiatan'=>$id));
			$pesan = $this->m_crud->saveBatch('tbl_item_keuangan', $item);
			if ($pesan==true) {
				redirect(base_url("admin/kegiatan/detail/$id"));
				die();
			}
		}
	}

	function buat_lpj($id){
		$item = array();
		$fisik = array();
		// var_dump($_POST);
		if (isset($_POST['lpj'])) {
			for ($i=0; $i < count($_POST['kode']); $i++) {
				$kode = $_POST['kode'][$i];
				$jumlah = $_POST['jumlah'][$i];;
				$realisasi = $_POST['realisasi'][$i];
				$prosentase = ($realisasi/$jumlah)*100;
				array_push($item, array("kode"=>$kode, "realisasi"=>$realisasi, "prosentase"=>$prosentase));
			}

			for ($j=0; $j < count($_POST['output_fisik']); $j++) {
				$output_fisik = $_POST['output_fisik'][$j];
				$volume_fisik = $_POST['volume_fisik'][$j];;
				$satuan_fisik = $_POST['satuan_fisik'][$j];
				$nilai = $_POST['nilai'][$j];
				$ket = $_POST['ket'][$j];

				array_push($fisik, array("uraian"=>$output_fisik, "volume"=>$volume_fisik, "satuan"=>$satuan_fisik, "nilai"=>$nilai, "ket"=>$ket, "id_kegiatan"=>$id));
			}

			$store['kendala'] = $_POST['kendala'];
			$store['saran'] = $_POST['saran'];
			$store['status'] = kegiatan_arsip;
			$keg = $this->m_crud->update('tbl_kegiatan', $store, array('id_kegiatan'=>$id));
			$fisik = $this->m_crud->saveBatch('tbl_item_fisik', $fisik);
			$keu = $this->m_crud->updateBatch('tbl_item_keuangan', $item, 'kode');
			if ($keu==true && $keg==true && $fisik==true) {
				redirect(base_url("admin/kegiatan/"));
				die();
			}
		}
	}

	function revisi($id){
		$proses['catatan'] = $_POST['catatan'];
		$pesan = $this->m_crud->update('tbl_kegiatan', $proses, array('id_kegiatan'=>$id));
		if ($pesan) {
			redirect(base_url("admin/kegiatan"));
			die();
		}
	}

	function proses($id, $status){
		$proses['status'] = $status;
		$pesan = $this->m_crud->update('tbl_kegiatan', $proses, array('id_kegiatan'=>$id));
		if ($pesan) {
			redirect(base_url("admin/kegiatan"));
			die();
		}
	}

	function hapus($id){
		$pesan = $this->m_crud->delete('tbl_kegiatan', array('id_kegiatan'=>$id));
		redirect(base_url("admin/kegiatan"));
	}
}
