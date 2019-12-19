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
				  <?php echo form_open_multipart("superadmin/soal_aksi_tambah"); ?>
					<div class="col-md-3">
						<div class="form-group">
							<label>Fakultas</label>
							<select id="id_fakultas" class="form-control select2" data-placeholder="Pilih Fakultas" required style="width: 100%;" >
								<option></option>
								<?php foreach($tbl_fakultas as $fakultas){?>
								<option value="<?php echo $fakultas->id_fakultas;?>"><?php echo $fakultas->nama_fakultas;?></option>
								<?php } ?>
							</select>
						</div>
						<div class="form-group">
							<label>Prodi</label>
							<select id="id_prodi" class="form-control select2" data-placeholder="Pilih Prodi" required style="width: 100%;" >
							</select>
							<input type="hidden" name="id_formatsoal" id="id_formatsoal" class="form-control" value="">
						</div>
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
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label>Dosen</label>
							<select name="id_user_dosen_soal" id="id_user_dosen_soal" class="form-control select2" data-placeholder="Pilih Dosen" required style="width: 100%;" >
								<option></option>
								<?php foreach($tbl_user as $user){?>
								<option value="<?php echo $user->id_user;?>"><?php echo $user->nidn_user;?> - <?php echo $user->nama_user;?></option>
								<?php } ?>
							</select>
						</div>
						<div class="form-group">
							<label>Hari/Tanggal</label>
							<input type="date" name="tanggal_soal" class="form-control">
						</div>
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
$("#id_fakultas").change(function(){
		var id_fakultas = $("#id_fakultas").val();
		$.ajax({
			url: "<?php echo base_url('superadmin/kelasmahasiswa_prodi');?>",
			type     : 'POST',
			dataType : 'html',
			data: 'id_fakultas='+id_fakultas,
			cache: false,
			success: function(response){
				$("#id_prodi").html(response);
			}
		});
		$("#id_prodi").hide();
	});
	
	$("#id_prodi").change(function(){
		var id_prodi = $("#id_prodi").val();
		$.ajax({
			url: "<?php echo base_url('superadmin/kelasmahasiswa_matakuliah');?>",
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
			url: "<?php echo base_url('superadmin/kelasmahasiswa_kelasmahasiswa');?>",
			type     : 'POST',
			dataType : 'html',
			data: 'id_prodi='+id_prodi,
			cache: false,
			success: function(response){
				$("#id_kelasmahasiswa").html(response);
			}
		});
		$("#id_kelasmahasiswa").hide();
		
		$.ajax({
			url: "<?php echo base_url('superadmin/kelasmahasiswa_formatsoal');?>",
			type     : 'POST',
			dataType : 'html',
			data: 'id_prodi='+id_prodi,
			cache: false,
			success: function(response){
				$('#id_formatsoal').val(response);
			}
		});
	});
	
	tinymce.init({
		selector: '#deskripsi',
		plugins : 'advlist autolink link lists charmap print preview table'
	  });
});	
</script>