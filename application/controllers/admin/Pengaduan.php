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
		$pengaduan = $this->m_crud->readBy('detail_pengaduan', array('id_pengaduan'=>$id));
		$footer['pengaduan'] = $pengaduan[0];

		$detail = $this->m_crud->readBy('detail_pengaduan', array('id_pengaduan'=>$id));
		$tahun = '2020';

		$footer['dana'] = $this->m_crud->readBy('tbl_dana', array('status <>'=>-1, 'tahun'=>$tahun));

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
		}
	}

	function cetak($id){
		$detail = $this->m_crud->readBy('detail_pengaduan', array('id_pengaduan'=>$id));

		$hasil = $detail[0];
		$data['judul'] = 'Cetak Pengaduan';

		$data['element']  = "<div style='border-bottom:3px solid black; padding-bottom:20px;'>";
		$data['element'] .= "<h4 class='text-center'>BADAN PERMUSYAWARATAN DESA</h4>";
		$data['element'] .= "<h1 style='margin-top:-8px;' class='text-center'>BPD</h1>";
		$data['element'] .= "<h4 style='margin-top:-8px;' class='text-center'>DESA PAGERNGUMBUK KECAMATAN WONOAYU</h4>";
		$data['element'] .= "</div>";

		$data['element'] .= '<br>';
		$data['element'] .= '<table class="table table-borderless">';
		$data['element'] .= '<tbody>';
		$data['element'] .= '<tr>';
		$data['element'] .= '<td width="10" style="border:none;"></td>';
		$data['element'] .= '<th scope="row" width="120" style="border:none;">Nama</th>';
		$data['element'] .= '<td width="10" style="border:none;">:</td>';
		$data['element'] .= '<td class="garisbawah" style="border-top:none; border-bottom: 1px solid black;">'.$hasil->nama.'</td>';
		$data['element'] .= '<td width="10" style="border:none;"></td>';
		$data['element'] .= '</tr>';
		$data['element'] .= '<tr>';
		$data['element'] .= '<td width="10" style="border:none;"></td>';
		$data['element'] .= '<th scope="row" width="120" style="border:none;">NIK</th>';
		$data['element'] .= '<td width="10" style="border:none;">:</td>';
		$data['element'] .= '<td class="garisbawah" style="border-top:none; border-bottom: 1px solid black;">'.$hasil->nik.'</td>';
		$data['element'] .= '</tr>';
		$data['element'] .= '<tr>';
		$data['element'] .= '<td width="10" style="border:none;"></td>';
		$data['element'] .= '<th scope="row" width="120" style="border:none;">Telp / Email</th>';
		$data['element'] .= '<td width="10" style="border:none;">:</td>';
		$data['element'] .= '<td class="garisbawah" style="border-top:none; border-bottom: 1px solid black;">'.$hasil->no_telp.' / '.$hasil->email.'</td>';
		$data['element'] .= '</tr>';
		$data['element'] .= '<tr>';
		$data['element'] .= '<td width="10" style="border:none;"></td>';
		$data['element'] .= '<th scope="row" width="120" style="border:none;">Alamat</th>';
		$data['element'] .= '<td width="10" style="border:none;">:</td>';
		$data['element'] .= '<td class="garisbawah" style="border-top:none; border-bottom: 1px solid black;">';
		$data['element'] .= "Dusun ".DUSUN[$hasil->rw].", RT 0$hasil->rt";
		$data['element'] .= '</td>';
		$data['element'] .= '</tr>';
		$data['element'] .= '<tr>';
		$data['element'] .= '<td width="10" style="border:none;"></td>';
		$data['element'] .= '<th scope="row" width="120" style="border:none;">Bidang</th>';
		$data['element'] .= '<td width="10" style="border:none;">:</td>';
		$data['element'] .= '<td class="garisbawah" style="border-top:none; border-bottom: 1px solid black;">';
		$data['element'] .= ucwords($hasil->bidang);
		$data['element'] .= '</td>';
		$data['element'] .= '</tr>';
		$data['element'] .= '<tr>';
		$data['element'] .= '<td width="10" style="border:none;"></td>';
		$data['element'] .= '<th scope="row" width="120" style="border:none;">Uraian</th>';
		$data['element'] .= '<td width="10" style="border:none;">:</td>';
		$data['element'] .= '<td class="garisbawah" style="text-align:justify;">';
		$data['element'] .= '<strong>'.$hasil->judul.'</strong>';
		$data['element'] .= '<br/>';
		$data['element'] .= $hasil->uraian;
		$data['element'] .= '</td>';
		$data['element'] .= '</tr>';
		$data['element'] .= '</tbody>';
		$data['element'] .= '</table>';
		$data['element'] .= '<br><br><br><br>';
		$data['element'] .= '<div class="pull-right text-center" style="width: 250px; margin-right:50px; border-bottom:1px solid black;">';
		$data['element'] .= '<h5 for="">Desa Pagerngumbuk, '.date("d M Y").'</h5>';
		$data['element'] .= '<h5 for="">Pengadu</h5>';
		$data['element'] .= "<img src='".base_url($hasil->ttd_file)."' style='width:5cm;'>";
		$data['element'] .= "<h5><strong>$hasil->nama</strong></h5>";
		$data['element'] .= '</div>';

		$this->load->view('v_cetak', $data);
	}
}
