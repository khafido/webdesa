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

	public function buat_lpj($id){
		$item = array();
		$fisik = array();

		if (isset($_POST['lpj'])) {
			for ($i=0; $i < count($_POST['kode']); $i++) {
				$kode = $_POST['kode'][$i];
				$jumlah = $_POST['jumlah'][$i];;
				$realisasi = $_POST['realisasi'][$i];
				$persen = ($realisasi/$jumlah)*100;
				$prosentase = strval($persen);
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
				$this->session->set_flashdata('sukses', '<div class="alert alert-success" role="alert">Buat LPJ Sukses!</div>');
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

	function cetak_rab($id){
		$detail = $this->m_crud->readBy('detail_kegiatan', array('id_kegiatan'=>$id));

		$hasil = $detail[0];
		$data['judul'] = 'Cetak RAB';

		$data['element']  = "<div style='border-bottom:3px solid black; padding-bottom:20px;'>";
		$data['element'] .= "<h3 class='text-center'><strong>RENCANA ANGGARAN BIAYA</strong></h3>";
		$data['element'] .= "<h4 style='margin-top:-8px;' class='text-center'>DESA PAGERNGUMBUK KECAMATAN WONOAYU</h4>";
		$data['element'] .= "<h4 style='margin-top:-8px;' class='text-center'>TAHUN ANGGARAN ".TAHUN."</h4>";
		$data['element'] .= "</div>";

		$data['element'] .= '<br>';
		$data['element'] .= '<table class="table table-borderless">';
		$data['element'] .= '<tbody>';
		$data['element'] .= '<tr>';
		$data['element'] .= '<td width="10" style="border:none;"></td>';
		$data['element'] .= '<th scope="row" width="160" style="border:none;">Bidang</th>';
		$data['element'] .= '<td width="10" style="border:none;">:</td>';
		$data['element'] .= '<td class="garisbawah" style="border-top:none; border-bottom: 1px dotted black;">'.ucwords($hasil->bidang).'</td>';
		$data['element'] .= '<td width="10" style="border:none;"></td>';
		$data['element'] .= '</tr>';
		$data['element'] .= '<tr>';
		$data['element'] .= '<td width="10" style="border:none;"></td>';
		$data['element'] .= '<th scope="row" width="160" style="border:none;">Kegiatan</th>';
		$data['element'] .= '<td width="10" style="border:none;">:</td>';
		$data['element'] .= '<td class="garisbawah" style="border-top:none; border-bottom: 1px dotted black;">'.ucwords($hasil->nama).'</td>';
		$data['element'] .= '<td width="10" style="border:none;"></td>';
		$data['element'] .= '</tr>';
		$data['element'] .= '<tr>';
		$data['element'] .= '<td width="10" style="border:none;"></td>';
		$data['element'] .= '<th scope="row" width="160" style="border:none;">Waktu Pelaksanaan</th>';
		$data['element'] .= '<td width="10" style="border:none;">:</td>';
		$data['element'] .= '<td class="garisbawah" style="border-top:none; border-bottom: 1px dotted black;">'.date("d/m/Y",strtotime($hasil->tgl_mulai)).' sampai '.date("d/m/Y",strtotime($hasil->tgl_selesai)).'</td>';
		$data['element'] .= '<td width="10" style="border:none;"></td>';
		$data['element'] .= '</tr>';
		$data['element'] .= '<tr>';
		$data['element'] .= '<td width="10" style="border:none;"></td>';
		$data['element'] .= '<th scope="row" width="160" style="border:none;">Sumber Dana</th>';
		$data['element'] .= '<td width="10" style="border:none;">:</td>';
		$data['element'] .= '<td class="garisbawah" style="border-top:none; border-bottom: 1px dotted black;">'.$hasil->dana.'</td>';
		$data['element'] .= '<td width="10" style="border:none;"></td>';
		$data['element'] .= '</tr>';
		$data['element'] .= '<tr>';
		$data['element'] .= '<td width="10" style="border:none;"></td>';
		$data['element'] .= '<th scope="row" width="160" style="border:none;">Output</th>';
		$data['element'] .= '<td width="10" style="border:none;">:</td>';
		$data['element'] .= '<td class="garisbawah" style="border-top:none; border-bottom: 1px dotted black;">'.$hasil->output.'</td>';
		$data['element'] .= '<td width="10" style="border:none;"></td>';
		$data['element'] .= '</tr>';
		$data['element'] .= '</tbody>';
		$data['element'] .= '</table>';
		$data['element'] .= '<h5 style="margin-left:25px;">Rincian Pendanaan :<h5>';
		$data['element'] .= '<table style="width:95%; margin-left:25px;" class="table table-bordered">';
		$data['element'] .= '<thead class="" style="background:#B6F081;">';
		$data['element'] .= '<th scope="col">#</th>';
    $data['element'] .= '<th scope="col">Kode</th>';
    $data['element'] .= '<th scope="col">Uraian</th>';
    $data['element'] .= '<th scope="col">Volume</th>';
    $data['element'] .= '<th scope="col">Satuan</th>';
    $data['element'] .= '<th scope="col">Harga Satuan (Rp)</th>';
    $data['element'] .= '<th scope="col">Jumlah (Rp)</th>';
		$data['element'] .= '</thead>';
		$data['element'] .= '<tbody>';
		$item = $this->m_crud->readBy('tbl_item_keuangan', array('id_kegiatan'=>$id));
		$no = 1;
		$jumlah = 0;
		foreach ($item as $k => $i) {
			$data['element'] .= '<tr>';
			$data['element'] .= '<td>'.$no++.'</td>';
			$data['element'] .= '<td>'.$i->kode.'</td>';
			$data['element'] .= '<td>'.$i->uraian.'</td>';
			$data['element'] .= '<td>'.$i->volume.'</td>';
			$data['element'] .= '<td>'.$i->satuan.'</td>';
			$data['element'] .= '<td>'.$i->harga_satuan.'</td>';
			$data['element'] .= '<td>'.$i->jumlah.'</td>';
			$data['element'] .= '</tr>';
			$jumlah += $i->jumlah;
		}

		$data['element'] .= '<tr>';
		$data['element'] .= '<td colspan="6" align="center">Jumlah</td>';
		$data['element'] .= '<td>'.$jumlah.'</td>';
		$data['element'] .= '</tr>';

		$data['element'] .= '</tbody>';
		$data['element'] .= '</table>';
		$data['element'] .= '<br><br>';
		$data['element'] .= '<div class="pull-right text-center" style="width: 100%;"><h5>Desa Pagerngumbuk, '.date("d M Y").'</h5></div>';
		$data['element'] .= '<div class="pull-right text-center" style="width: 40%; margin-right:0px; border-bottom:1px solid black;">';
		$data['element'] .= '<h5 for="">Ketua Pelaksana</h5><br><br><br><br>';
		$data['element'] .= '<h5><strong>'.$hasil->ketua_pelaksana.'</strong></h5>';
		$data['element'] .= '</div>';
		$data['element'] .= '<div class=" text-center" style="margin-top:35px; width: 40%; margin-right:0px; border-bottom:1px solid black;">';
		$data['element'] .= '<h5 for="">Disetujui </h5>';
		$data['element'] .= '<h5 for="" style="margin-top:-8px;">Kepala Desa</h5><br><br><br>';
		$data['element'] .= '<h5><strong>Khoirul Anam</strong></h5>';
		$data['element'] .= '</div>';

		$this->load->view('v_cetak', $data);
	}

	function cetak_lpj($id){
		$detail = $this->m_crud->readBy('detail_kegiatan', array('id_kegiatan'=>$id));

		$hasil = $detail[0];
		$data['judul'] = 'Cetak LPJ';

		$data['element']  = "<div style='padding-bottom:20px;'>";
		$data['element'] .= "<h3 class='text-center'><strong>LAPORAN KEGIATAN ".strtoupper($hasil->nama)."</strong></h3>";
		$data['element'] .= "<h4 style='margin-top:-8px;' class='text-center'>DESA PAGERNGUMBUK KECAMATAN WONOAYU</h4>";
		$data['element'] .= "<h4 style='margin-top:-8px;' class='text-center'>TAHUN ANGGARAN ".TAHUN."</h4>";
		$data['element'] .= "</div>";

		$data['element'] .= '<div style="margin-left:25px;">';
		$data['element'] .= '<h5>Yth. Kepala Desa <strong>Khoirul Anam</strong></h5>';
		$data['element'] .= '<h5>melalui Sekretaris Kesa</h5>';
		$data['element'] .= '<h5>di Tempat</h5>';
		$data['element'] .= '</div>';
		$data['element'] .= '<div style="margin-top:25px; margin-left:25px;">';
		$data['element'] .= '<p>Dengan memperhatikan Peraturan Kepala Daerah........No.....Tahun.....Tentang Pengelolaan Keu Desa, bersama ini kami sampaikan Laporan Kegiatan '.ucwords($hasil->nama).' sebagai berikut:</p>';
		$data['element'] .= '</div>';
		$data['element'] .= '<h5 style="margin-top:25px; margin-left:25px;">A. Realisasi Keuangan:<h5>';
		$data['element'] .= '<table style="width:95%; margin-left:25px;" class="table table-bordered">';
		$data['element'] .= '<thead class="" style="background:#B6F081;">';
		$data['element'] .= '<th scope="col">#</th>';
    $data['element'] .= '<th scope="col">Kode</th>';
    $data['element'] .= '<th scope="col">Uraian</th>';
    $data['element'] .= '<th scope="col">Anggaran (Rp)</th>';
    $data['element'] .= '<th scope="col">Realisasi (Rp)</th>';
    $data['element'] .= '<th scope="col">%</th>';
		$data['element'] .= '</thead>';
		$data['element'] .= '<tbody>';
		$item = $this->m_crud->readBy('tbl_item_keuangan', array('id_kegiatan'=>$id));
		$no = 1;
		$jumlah = 0;
		$realisasi = 0;
		$prosentase = 0.0;
		foreach ($item as $k => $i) {
			$data['element'] .= '<tr>';
			$data['element'] .= '<td>'.$no.'</td>';
			$data['element'] .= '<td>'.$i->kode.'</td>';
			$data['element'] .= '<td>'.$i->uraian.'</td>';
			$data['element'] .= '<td>'.$i->jumlah.'</td>';
			$data['element'] .= '<td>'.$i->realisasi.'</td>';
			$data['element'] .= '<td>'.$i->prosentase.'</td>';
			$data['element'] .= '</tr>';
			$jumlah += $i->jumlah;
			$realisasi += $i->realisasi;
			$prosentase += $i->prosentase;
			$no++;
		}
		$data['element'] .= '<tr>';
		$data['element'] .= '<td colspan="3" align="center">Jumlah</td>';
		$data['element'] .= '<td>'.$jumlah.'</td>';
		$data['element'] .= '<td>'.$realisasi.'</td>';
		$data['element'] .= '<td>'.$prosentase/($no-1).'</td>';
		$data['element'] .= '</tr>';
		$data['element'] .= '</tbody>';
		$data['element'] .= '</table>';
		$data['element'] .= '<h5 style="margin-top:25px; margin-left:25px;">B. Realisasi Fisik/Output:<h5>';
		$data['element'] .= '<h5 style="margin-left:45px;">Output akhir dari kegiatan yang dilakukan sebagai berikut:<h5>';
		$data['element'] .= '<table style="width:95%; margin-left:25px;" class="table table-bordered">';
		$data['element'] .= '<thead class="" style="background:#B6F081;">';
		$data['element'] .= '<th scope="col">#</th>';
    $data['element'] .= '<th scope="col">Uraian</th>';
    $data['element'] .= '<th scope="col">Satuan</th>';
		$data['element'] .= '<th scope="col">Volume</th>';
    $data['element'] .= '<th scope="col">Nilai (Rp)</th>';
    $data['element'] .= '<th scope="col">ket</th>';
		$data['element'] .= '</thead>';
		$data['element'] .= '<tbody>';
		$item = $this->m_crud->readBy('tbl_item_fisik', array('id_kegiatan'=>$id));
		$no = 1;
		$nilai = 0;
		foreach ($item as $k => $i) {
			$data['element'] .= '<tr>';
			$data['element'] .= '<td>'.$no++.'</td>';
			$data['element'] .= '<td>'.$i->uraian.'</td>';
			$data['element'] .= '<td>'.$i->satuan.'</td>';
			$data['element'] .= '<td>'.$i->volume.'</td>';
			$data['element'] .= '<td>'.$i->nilai.'</td>';
			$data['element'] .= '<td>'.$i->ket.'</td>';
			$data['element'] .= '</tr>';
			$nilai += $i->nilai;
		}
		$data['element'] .= '<tr>';
		$data['element'] .= '<td colspan="4" align="center">Jumlah</td>';
		$data['element'] .= '<td>'.$nilai.'</td>';
		$data['element'] .= '<td></td>';
		$data['element'] .= '</tr>';
		$data['element'] .= '</tbody>';
		$data['element'] .= '</table>';
		$data['element'] .= '<h5 style="margin-top:-10px; margin-left:25px;">Nilai output/aset merupakan keseluruhan belanja yang dikeluarkan (Belanja Barang dan Jasa + Belanja Modal)<h5>';
		$data['element'] .= '<h5 style="margin-top:25px; margin-left:25px;">C. Kendala dan Upaya Mengatasinya<h5>';
		$data['element'] .= '<h5 style="margin-top:-5px; margin-left:43px; text-align:justify;">'.$hasil->kendala.'<h5>';
		$data['element'] .= '<h5 style="margin-top:25px; margin-left:25px;">D. Saran dan Rekomendasi<h5>';
		$data['element'] .= '<h5 style="margin-top:-5px; margin-left:43px; text-align:justify;">'.$hasil->saran.'<h5>';
		$data['element'] .= '<div class="text-center" style="width: 40%; margin-left:60%; border-bottom:1px solid black;">';
		$data['element'] .= '<h5 for="">Desa Pagerngumbuk, '.date("d M Y").'</h5>';
		$data['element'] .= '<h5 for=""><strong>Ketua Pelaksana</strong></h5><br><br><br><br>';
		$data['element'] .= '<h5><strong>'.$hasil->ketua_pelaksana.'</strong></h5>';
		$data['element'] .= '</div>';
		// $data['element'] .= '<div class=" text-center" style="color:white;margin-top:35px; width: 40%; margin-right:0px;">';
		// $data['element'] .= '<h5 for="">Disetujui </h5>';
		// $data['element'] .= '<h5 for="" style="margin-top:-8px;">Kepala Desa</h5><br><br><br>';
		// $data['element'] .= '<h5><strong>Khoirul Anam</strong></h5>';
		// $data['element'] .= '</div>';

		$this->load->view('v_cetak', $data);
	}
}
