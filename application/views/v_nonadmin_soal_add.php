  <div class="content-wrapper" >
    <section class="content-header">
      <h3>
        Tambah Soal
      </h3>
    </section>
 <!-- Main content -->
    <section class="content" >
      <div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">
						<span>Silahkan melengkapi form berikut</span>
					</h3>
				</div>
				<div class="box-body">
				  <div class="row">
				  <?php echo form_open_multipart("nonadmin/soal_aksi_tambah"); ?>
					<div class="col-md-3">
					<input type="hidden" name="id_formatsoal" value="<?php echo $tbl_formatsoal->id_formatsoal;?>"> 
					<input type="hidden" name="id_user_dosen_soal" value="<?php echo $id_user;?>"> 
						<div class="form-group">
							<label>Mata Kuliah</label>
							<select name="id_matakuliah" id="id_matakuliah" class="form-control select2" data-placeholder="Pilih Mata Kuliah" required style="width: 100%;" >
							</select>
						</div>
						<div class="form-group">
							<label>Semester / Kelas</label>
							<select name="id_kelasmahasiswa" id="id_kelasmahasiswa" class="form-control select2" data-placeholder="Pilih Semester" required style="width: 100%;" >
							</select>
						</div>
						<div class="form-group">
							<label>Hari/Tanggal</label>
							<input type="date" name="tanggal_soal" class="form-control">
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label>Total Waktu</label>
							<input type="number" name="totalwaktu_soal" class="form-control" placeholder="Total Waktu">
						</div>
						<div class="form-group">
							<label>Sifat Ujian</label>
							<select name="sifatujian_soal" id="sifatujian_soal" class="form-control select2" data-placeholder="Pilih Sifat Ujian" required style="width: 100%;" >
								<option></option>
								<option value="0"> Open Book</option>
								<option value="1"> Close Book</option>
							</select>
						</div>
						<div class="form-group">
							<label>Tipe Soal</label>
							<select name="tipe_soal" id="tipe_soal" class="form-control select2" data-placeholder="Pilih Tipe Soal" required style="width: 100%;" >
								<option></option>
								<?php
								foreach (range('A', 'Z') as $char) {
									echo "<option value='$char'> $char </option>";
								}
							   ?>
							</select>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Isi Soal</label>
							<textarea rows="8" id="deskripsi" class="form-control" name="isi_soal" placeholder="Isi Soal" required>Isi Soal</textarea>
						</div>
						<div class="form-group">
							<button type="submit" class="form-control btn btn-success">Submit</button>
						</div>
					</div>
					<?php echo form_close(); ?>
				  </div>
				</div>
			</div>
		</div>
      </div>
    </section>
  </div>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
<script src="<?php echo base_url('assets/plugins/tinymce/tinymce.min.js'); ?>"></script>
<script>  
$(document).ready(function() {	
	
		var id_prodi = $("#id_prodi").val();
		$.ajax({
			url: "<?php echo base_url('nonadmin/kelasmahasiswa_matakuliah');?>",
			type     : 'POST',
			dataType : 'html',
			data: 'id_prodi='+id_prodi,
			cache: false,
			success: function(response){
				$("#id_matakuliah").html(response);
			}
		});
		$("#id_matakuliah").hide();
		
		$.ajax({
			url: "<?php echo base_url('nonadmin/kelasmahasiswa_kelasmahasiswa');?>",
			type     : 'POST',
			dataType : 'html',
			data: 'id_prodi='+id_prodi,
			cache: false,
			success: function(response){
				$("#id_kelasmahasiswa").html(response);
			}
		});
		$("#id_kelasmahasiswa").hide();
			
	tinymce.init({
		selector: '#deskripsi',
		plugins : 'advlist autolink link lists charmap print preview table'
	  });
});	
</script>