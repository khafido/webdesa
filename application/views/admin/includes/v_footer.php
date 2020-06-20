</div>
</div>
</div>



<!-- <footer class="footer">
<div class="container-fluid">
<nav class="pull-left">
<ul>
  <li>
    <a href="#">
      Home
    </a>
  </li>
  <li>
    <a href="#">
      Company
    </a>
  </li>
  <li>
    <a href="#">
      Portfolio
    </a>
  </li>
  <li>
    <a href="#">
      Blog
    </a>
  </li>
</ul>
</nav>
<p class="copyright pull-right">
&copy; 2016 <a href="http://www.creative-tim.com">Creative Tim</a>, made with love for a better web
</p>
</div>
</footer> -->

</div>
</div>


<!-- Modal -->
<div class="modal fade" id="dataDiriModal" tabindex="-1" role="dialog" aria-labelledby="dataDiriModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="dataDiriModalTitle">Data Diri</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6">
            <label for="" class="control-label modal-label">Nama Lengkap<span class="text-danger">*</span> </label>
            <input class="form-control" type="text" name="m_nama" id="m_nama" value="">
          </div>
          <div class="col-md-6">
            <label for="" class="control-label modal-label">NIK<span class="text-danger">*</span> </label>
            <input class="form-control" type="text" name="m_nik" id="m_nik" value="">
          </div>
          <div class="col-md-6">
            <label for="" class="control-label modal-label">Tempat Lahir<span class="text-danger">*</span> </label>
            <input class="form-control" type="text" name="m_tempat" id="m_tempat" value="">
          </div>
          <div class="col-md-6">
            <label for="" class="control-label modal-label">Tanggal Lahir<span class="text-danger">*</span> </label>
            <input class="form-control" type="date" name="m_tgl" id="m_tgl" value="">
          </div>
          <div class="form-group col-md-6">
            <label for="" class="control-label modal-label">Jenis Kelamin <span class="text-danger">*</span> </label>
            <select class="form-control" name="m_jk" id="m_jk">
              <option value="L">Laki-laki</option>
              <option value="P">Perempuan</option>
            </select>
          </div>
          <div class="form-group col-md-6">
            <label for="" class="control-label modal-label">Pendidikan <span class="text-danger">*</span> </label>
            <select class="form-control" name="m_pendidikan" id="m_pendidikan">
              <?php
              $pendidikan = PENDIDIKAN;
							foreach ($pendidikan as $v => $c){
                echo "<option value='$v'>$c</option>";
              } ?>
            </select>
          </div>
          <div class="form-group col-md-6">
            <label for="" class="control-label modal-label">Golongan Darah <span class="text-danger">*</span> </label>
            <select class="form-control" name="m_goldar" id="m_goldar">
              <?php
              $goldar = GOLDAR;
							foreach ($goldar as $v => $c){
               echo "<option value='$v'>$c</option>";
              } ?>
            </select>
          </div>
          <div class="form-group col-md-6">
            <label for="" class="control-label modal-label">Status Kawin <span class="text-danger">*</span> </label>
            <select class="form-control" name="m_kawin" id="m_kawin">
              <?php
              $perkawinan = PERKAWINAN;
							foreach ($perkawinan as $v => $c){
                echo "<option value='$v'>$c</option>";
              } ?>
            </select>
          </div>
          <div class="form-group col-md-6">
            <label for="" class="control-label modal-label">Agama<span class="text-danger">*</span> </label>
            <select class="form-control" name="m_agama" id="m_agama">
              <?php
              $agama = AGAMA;
							foreach ($agama as $v => $c){
               echo "<option value='$v'>$c</option>";
              } ?>
            </select>
          </div>
          <div class="form-group col-md-6">
            <label for="" class="control-label modal-label">Pekerjaan<span class="text-danger">*</span> </label>
            <select class="form-control" name="m_pekerjaan" id="m_pekerjaan">
              <?php
              $pekerjaan = PEKERJAAN;
							foreach ($pekerjaan as $v => $c){
                echo "<option value='$v'>$c</option>";
              } ?>
            </select>
          </div>
          <div class="form-group col-md-4">
            <label for="" class="control-label modal-label">Hubungan <span class="text-danger">*</span> </label>
            <input class="form-control" list="hubungan" name="m_hubungan" id="m_hubungan" value="">
            <datalist id="hubungan">
              <option value="Kakek Buyut">Kakek Buyut</option>
              <option value="Nenek Buyut">Nenek Buyut</option>
              <option value="Kakek">Kakek</option>
              <option value="Nenek">Nenek</option>
              <option value="Ayah">Ayah</option>
              <option value="Ibu">Ibu</option>
              <option value="Paman">Paman</option>
              <option value="Bibi">Bibi</option>
              <option value="Mertua Ayah">Mertua Ayah</option>
              <option value="Mertua Ibu">Mertua Ibu</option>
              <option value="Ayah Tiri">Ayah Tiri</option>
              <option value="Ayah Angkat">Ayah Angkat</option>
              <option value="Ayah Asuh">Ayah Asuh</option>
              <option value="Ibu Tiri">Ibu Tiri</option>
              <option value="Ibu Angkat">Ibu Angkat</option>
              <option value="Ibu Asuh">Ibu Asuh</option>
              <option value="Besan">Besan</option>
              <option value="Kepala Keluarga">Kepala Keluarga</option>
              <option value="Kakak">Kakak</option>
              <option value="Adik">Adik</option>
              <option value="Sepupu">Sepupu</option>
              <option value="Ipar">Saudara Ipar</option>
              <option value="Saudara Angkat">Saudara Angkat</option>
              <option value="Saudara Tiri">Saudara Tiri</option>
              <option value="Suami">Suami</option>
              <option value="Istri">Istri</option>
              <option value="Anak Kandung">Anak Kandung</option>
              <option value="Anak Angkat">Anak Angkat</option>
              <option value="Anak Tiri">Anak Tiri</option>
              <option value="Anak Asuh">Anak Asuh</option>
              <option value="Menantu">Menantu</option>
              <option value="Keponakan">Keponakan</option>
              <option value="Cucu">Cucu</option>
              <option value="Cicit">Cicit</option>
              <option value="Canggah">Canggah</option>
            </datalist>
          </div>
          <div class="form-group col-md-4">
            <label for="" class="control-label modal-label">Nama Ibu<span class="text-danger">*</span> </label>
            <input class="form-control" type="text" name="m_ibu" id="m_ibu" value="">
          </div>
          <div class="form-group col-md-4">
            <label for="" class="control-label modal-label">Nama Ayah<span class="text-danger">*</span> </label>
            <input class="form-control" type="text" name="m_ayah" id="m_ayah" value="">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
        <button type="button" class="btn btn-primary" id="btnsimpan">Simpan</button>
      </div>
    </div>
  </div>
</div>
<!-- END MODAL -->

<!-- Modal -->
<div class="modal fade" id="modalhapus" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Konfirmasi</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Apakah Kamu Yakin?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-fill" data-dismiss="modal">Tidak</button>
        <a href="#" class="btn btn-danger btn-fill text-white" id="btnyakin">Yakin</a>
      </div>
    </div>
  </div>
</div>


<!-- Modal Kegiatan -->
<div class="modal fade" id="modalKegiatan" tabindex="-1" role="dialog" aria-labelledby="dataDiriModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="dataDiriModalTitle">Data Diri</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6">
            <label for="" class="control-label modal-label">Nama Lengkap<span class="text-danger">*</span> </label>
            <input class="form-control" type="text" name="m_nama" id="m_nama" value="">
          </div>
          <div class="col-md-6">
            <label for="" class="control-label modal-label">NIK<span class="text-danger">*</span> </label>
            <input class="form-control" type="text" name="m_nik" id="m_nik" value="">
          </div>
          <div class="col-md-6">
            <label for="" class="control-label modal-label">Tempat Lahir<span class="text-danger">*</span> </label>
            <input class="form-control" type="text" name="m_tempat" id="m_tempat" value="">
          </div>
          <div class="col-md-6">
            <label for="" class="control-label modal-label">Tanggal Lahir<span class="text-danger">*</span> </label>
            <input class="form-control" type="date" name="m_tgl" id="m_tgl" value="">
          </div>
          <div class="form-group col-md-6">
            <label for="" class="control-label modal-label">Jenis Kelamin <span class="text-danger">*</span> </label>
            <select class="form-control" name="m_jk" id="m_jk">
              <option value="L">Laki-laki</option>
              <option value="P">Perempuan</option>
            </select>
          </div>
          <div class="form-group col-md-6">
            <label for="" class="control-label modal-label">Pendidikan <span class="text-danger">*</span> </label>
            <select class="form-control" name="m_pendidikan" id="m_pendidikan">
              <?php
              $pendidikan = PENDIDIKAN;
							foreach ($pendidikan as $v => $c){
                echo "<option value='$v'>$c</option>";
              } ?>
            </select>
          </div>
          <div class="form-group col-md-6">
            <label for="" class="control-label modal-label">Golongan Darah <span class="text-danger">*</span> </label>
            <select class="form-control" name="m_goldar" id="m_goldar">
              <?php
              $goldar = GOLDAR;
							foreach ($goldar as $v => $c){
               echo "<option value='$v'>$c</option>";
              } ?>
            </select>
          </div>
          <div class="form-group col-md-6">
            <label for="" class="control-label modal-label">Status Kawin <span class="text-danger">*</span> </label>
            <select class="form-control" name="m_kawin" id="m_kawin">
              <?php
              $perkawinan = PERKAWINAN;
							foreach ($perkawinan as $v => $c){
                echo "<option value='$v'>$c</option>";
              } ?>
            </select>
          </div>
          <div class="form-group col-md-6">
            <label for="" class="control-label modal-label">Agama<span class="text-danger">*</span> </label>
            <select class="form-control" name="m_agama" id="m_agama">
              <?php
              $agama = AGAMA;
							foreach ($agama as $v => $c){
               echo "<option value='$v'>$c</option>";
              } ?>
            </select>
          </div>
          <div class="form-group col-md-6">
            <label for="" class="control-label modal-label">Pekerjaan<span class="text-danger">*</span> </label>
            <select class="form-control" name="m_pekerjaan" id="m_pekerjaan">
              <?php
              $pekerjaan = PEKERJAAN;
							foreach ($pekerjaan as $v => $c){
                echo "<option value='$v'>$c</option>";
              } ?>
            </select>
          </div>
          <div class="form-group col-md-4">
            <label for="" class="control-label modal-label">Hubungan <span class="text-danger">*</span> </label>
            <input class="form-control" list="hubungan" name="m_hubungan" id="m_hubungan" value="">
            <datalist id="hubungan">
              <option value="Kakek Buyut">Kakek Buyut</option>
              <option value="Nenek Buyut">Nenek Buyut</option>
              <option value="Kakek">Kakek</option>
              <option value="Nenek">Nenek</option>
              <option value="Ayah">Ayah</option>
              <option value="Ibu">Ibu</option>
              <option value="Paman">Paman</option>
              <option value="Bibi">Bibi</option>
              <option value="Mertua Ayah">Mertua Ayah</option>
              <option value="Mertua Ibu">Mertua Ibu</option>
              <option value="Ayah Tiri">Ayah Tiri</option>
              <option value="Ayah Angkat">Ayah Angkat</option>
              <option value="Ayah Asuh">Ayah Asuh</option>
              <option value="Ibu Tiri">Ibu Tiri</option>
              <option value="Ibu Angkat">Ibu Angkat</option>
              <option value="Ibu Asuh">Ibu Asuh</option>
              <option value="Besan">Besan</option>
              <option value="Kepala Keluarga">Kepala Keluarga</option>
              <option value="Kakak">Kakak</option>
              <option value="Adik">Adik</option>
              <option value="Sepupu">Sepupu</option>
              <option value="Ipar">Saudara Ipar</option>
              <option value="Saudara Angkat">Saudara Angkat</option>
              <option value="Saudara Tiri">Saudara Tiri</option>
              <option value="Suami">Suami</option>
              <option value="Istri">Istri</option>
              <option value="Anak Kandung">Anak Kandung</option>
              <option value="Anak Angkat">Anak Angkat</option>
              <option value="Anak Tiri">Anak Tiri</option>
              <option value="Anak Asuh">Anak Asuh</option>
              <option value="Menantu">Menantu</option>
              <option value="Keponakan">Keponakan</option>
              <option value="Cucu">Cucu</option>
              <option value="Cicit">Cicit</option>
              <option value="Canggah">Canggah</option>
            </datalist>
          </div>
          <div class="form-group col-md-4">
            <label for="" class="control-label modal-label">Nama Ibu<span class="text-danger">*</span> </label>
            <input class="form-control" type="text" name="m_ibu" id="m_ibu" value="">
          </div>
          <div class="form-group col-md-4">
            <label for="" class="control-label modal-label">Nama Ayah<span class="text-danger">*</span> </label>
            <input class="form-control" type="text" name="m_ayah" id="m_ayah" value="">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
        <button type="button" class="btn btn-primary" id="btnsimpan">Simpan</button>
      </div>
    </div>
  </div>
</div>
<!-- END MODAL -->

</body>
<!--   Core JS Files   -->
<!-- <script src="<?=base_url("assets/admin")?>/js/jquery-1.10.2.js" type="text/javascript"></script> -->
<!-- <script src="<?=base_url()?>assets/lib/jquery/jquery.min.js"></script> -->
<script src="<?=base_url("assets/admin")?>/js/bootstrap.min.js" type="text/javascript"></script>


<!--  Checkbox, Radio & Switch Plugins -->
<script src="<?=base_url("assets/admin")?>/js/bootstrap-checkbox-radio-switch.js"></script>

<!--  Charts Plugin -->
<script src="<?=base_url("assets/admin")?>/js/chartist.min.js"></script>

<!--  Notifications Plugin    -->
<script src="<?=base_url("assets/admin")?>/js/bootstrap-notify.js"></script>

<!--  Google Maps Plugin    -->
<!-- <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script> -->

<!-- Light Bootstrap Table Core javascript and methods for Demo purpose -->
<script src="<?=base_url("assets/admin")?>/js/light-bootstrap-dashboard.js"></script>

<!-- Light Bootstrap Table DEMO methods, don't include it in your project! -->
<script src="<?=base_url("assets/admin")?>/js/demo.js"></script>

<script type="text/javascript">
$(document).ready(function(){

// demo.initChartist();
//
// $.notify({
//   	icon: 'pe-7s-gift',
//   	message: "Welcome to <b>Light Bootstrap Dashboard</b> - a beautiful freebie for every web developer."
//
//   },{
//       type: 'info',
//       timer: 4000
//   });

$('#tbl_surat_baru').DataTable();
  $('#tbl_surat_proses').DataTable();
  $('#tbl_surat_selesai').DataTable();
});
</script>

</html>
