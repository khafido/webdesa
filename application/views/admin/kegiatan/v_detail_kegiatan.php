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
							<th width="150">Nama Kegiatan</th>
							<th width="50">:</th>
							<td><?=$detail->nama?></td>
						</tr>
						<tr>
							<th>Bidang</th>
							<th>:</th>
							<td><?=$detail->bidang?></td>
						</tr>
						<tr>
							<th>Tgl Mulai</th>
							<th>:</th>
							<td><?=$detail->tgl_mulai?></td>
						</tr>
						<tr>
							<th>Tgl Selesai</th>
							<th>:</th>
							<td><?=$detail->tgl_selesai?></td>
						</tr>
						<tr>
							<th>Output</th>
							<th>:</th>
							<td><?=$detail->output?></td>
						</tr>
						<th>Ketua Pelaksana</th>
						<th>:</th>
						<td><?=$detail->ketua_pelaksana?></td>
					</tr>
					<tr>
						<th>Sumber Dana</th>
						<th>:</th>
						<td><?=$detail->dana?></td>
					</tr>
					<tr>
						<th>Pengusul</th>
						<th>:</th>
						<td><?=$detail->pelapor?></td>
					</tr>
					<tr>
						<th>Foto Lampiran</th>
						<th>:</th>
						<td><a id="file_lampiran" href="<?=base_url($detail->lampiran_file)?>" target="_blank">Lihat</a></td>
					</tr>
					<?php $status = $detail->status;?>
					<?php if ($status==1): ?>
						<tr>
							<th>Catatan</th>
							<th>:</th>
							<td class="text-danger"><?=$detail->catatan?></td>
						</tr>
					<?php endif; ?>
				</tbody>
			</table>
			<?php if ($status==0): ?>
				<button onclick="buatRencana('<?=base_url()?>admin/kegiatan/buat_itemkeuangan/<?=$detail->id_pengaduan?>')" class="btn btn-success btn-fill">Buat Rencana Anggaran</button>
				<button onclick="proses('<?=base_url("admin/$menu/hapus/$detail->id_pengaduan")?>')" class="btn btn-danger btn-fill">Hapus</button>
				&ensp;&ensp;&ensp;
				<a href="<?=base_url("admin/$menu/form/ubah/$detail->id_pengaduan")?>" class="btn btn-info btn-fill">Ubah</a>
			<?php endif; ?>

			<?php if ($status==kegiatan_rencana): ?>
				<button onclick="ubahRencana('<?=base_url()?>admin/kegiatan/ubah_itemkeuangan/<?=$detail->id_pengaduan?>')" class="btn btn-info btn-fill" id="btnlihatrencana">Revisi Rencana Anggaran</button>
				<button onclick="lihatRencana()" class="btn btn-primary btn-fill" id="btnlihatrencana">Lihat Rencana Anggaran</button>
				<button onclick="proses('<?=base_url("admin/$menu/proses/$detail->id_pengaduan/2")?>')" class="btn btn-success btn-fill">RAB Valid</button>
				<button onclick="catatan('<?=base_url("admin/$menu/revisi/$detail->id_pengaduan")?>')" class="btn btn-danger btn-fill">RAB Tidak Valid</button>
				<a href="<?=base_url("admin/$menu/cetak_rab/$detail->id_pengaduan")?>" class="pull-right btn btn-dark btn-fill">Cetak RAB</a>
			<?php endif; ?>

			<?php if ($status==kegiatan_proses): ?>
				<button onclick="proses('<?=base_url()?>admin/kegiatan/proses/<?=$detail->id_pengaduan?>/3')" class="btn btn-success btn-fill">Kegiatan Selesai</button>
				<button onclick="lihatRencana()" class="btn btn-primary btn-fill" id="btnlihatrencana">Lihat Rencana Anggaran</button>
				<a href="<?=base_url("admin/$menu/cetak_rab/$detail->id_pengaduan")?>" class="pull-right btn btn-dark btn-fill">Cetak RAB</a>
			<?php endif; ?>

			<?php if ($status==kegiatan_selesai): ?>
				<button onclick="buatLPJ('<?=$detail->id_pengaduan?>')" class="btn btn-success btn-fill">Buat LPJ Kegiatan</button>
				<a href="<?=base_url("admin/$menu/cetak_lpj/$detail->id_pengaduan")?>" class="pull-right btn btn-dark btn-fill">Cetak LPJ</a>
				<a href="<?=base_url("admin/$menu/cetak_rab/$detail->id_pengaduan")?>" class="pull-right btn btn-dark btn-fill" style="margin-right:10px;">Cetak RAB</a>
			<?php endif; ?>

			<?php if ($status==kegiatan_arsip): ?>
				<button onclick="lihatLPJ()" class="btn btn-primary btn-fill" id="btnlihatrencana">Lihat LPJ</button>
				<a href="<?=base_url("admin/$menu/cetak_lpj/$detail->id_pengaduan")?>" class="pull-right btn btn-dark btn-fill">Cetak LPJ</a>
				<a href="<?=base_url("admin/$menu/cetak_rab/$detail->id_pengaduan")?>" class="pull-right btn btn-dark btn-fill" style="margin-right:10px;">Cetak RAB</a>
			<?php endif; ?>
		</div>
	</div>
</div>
</div>
