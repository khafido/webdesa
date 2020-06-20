<?php
	$menu = $this->uri->segment(2);
?>
<div class="col-md-12">
	<div class="card">
		<div class="header">
			<a href="<?=base_url("admin/$menu")?>" class="btn btn-warning btn-fill pull-right">Kembali</a>
			<h4 class="title" style="text-transform:capitalize;">Data <?=$judul?></h4>
			<!-- <p class="category">Last Campaign Performance</p> -->
		</div>
		<div class="content">
			<div class="content table-responsive table-full-width">
				<table class="table table-hover table-striped table-borderless">
					<thead>
					</thead>
					<tbody>
						<tr>
							<th>Judul</th>
							<th>:</th>
							<td><?=$detail->judul?></td>
						</tr>
						<tr>
							<th>Bidang</th>
							<th>:</th>
							<td><?=$detail->bidang?></td>
						</tr>
						<tr>
							<th>Kategori</th>
							<th>:</th>
							<td><?=$detail->kategori?></td>
						</tr>
						<tr>
						<th>Lokasi</th>
							<th>:</th>
							<td><?=$detail->lokasi?></td>
						</tr>
						<th>Uraian</th>
							<th>:</th>
							<td><?=$detail->uraian?></td>
						</tr>
						<tr>
						<th>Tgl Pengaduan</th>
							<th>:</th>
							<td><?=$detail->tgl_pengaduan?></td>
						</tr>
						<tr>
							<th>Pelapor</th>
							<th>:</th>
							<td><?=$detail->nama?></td>
						</tr>
						<tr>
							<th>Foto Lampiran</th>
							<th>:</th>
							<td><a id="file_lampiran" href="<?=base_url($detail->lampiran_file)?>" target="_blank">Lihat</a></td>
						</tr>
					</tbody>
				</table>
				<button onclick="buatKegiatan('<?=$detail->id_pengaduan?>')" class="btn btn-success btn-fill">Buat Kegiatan</button>
				<!-- <a href="<?=base_url("admin/kegiatan/tambah/$detail->id_pengaduan")?>" class="btn btn-success btn-fill">Buat Kegiatan</a> -->
				<button onclick="proses('<?=base_url("admin/$menu/tolak/$detail->id_pengaduan")?>')" class="btn btn-danger btn-fill">Tolak</button>
				<!-- &ensp;&ensp;&ensp;
				<a href="<?=base_url("admin/$menu/form/ubah/$detail->id_pengaduan")?>" class="btn btn-info btn-fill">Ubah</a> -->
			</div>
		</div>
	</div>
</div>
