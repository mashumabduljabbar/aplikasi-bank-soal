  <div class="content-wrapper" >
    <section class="content-header">
      <h3>
        Ubah Soal
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
				  <?php echo form_open_multipart("adminprodi/soal_aksi_ubah/$tbl_soal->id_soal"); ?>
					<div class="col-md-4">
						<div class="form-group">
							<label>Mata Kuliah</label>
							<select name="id_matakuliah" id="id_matakuliah" class="form-control select2" data-placeholder="Pilih Mata Kuliah" required style="width: 100%;" >
								<option value="<?php echo $tbl_matakuliah_by->id_matakuliah;?>"><?php echo $tbl_matakuliah_by->nama_matakuliah;?></option>
								<?php foreach($tbl_matakuliah as $matakuliah){?>
								<option value="<?php echo $matakuliah->id_matakuliah;?>"><?php echo $matakuliah->nama_matakuliah;?></option>
								<?php } ?>
							</select>
						</div>
						<div class="form-group">
							<label>Semester / Kelas</label>
							<select name="id_kelasmahasiswa" id="id_kelasmahasiswa" class="form-control select2" data-placeholder="Pilih Semester" required style="width: 100%;" >
								<option value="<?php $semester = array("","I","II","III","IV","V","VI"); $nama_semester = $semester[$tbl_kelasmahasiswa_by->semester_kelasmahasiswa]; echo $tbl_kelasmahasiswa_by->id_kelasmahasiswa;?>"><?php echo "T.A : $tbl_kelasmahasiswa_by->periode_kelasmahasiswa - Semester : $nama_semester - Kelas : $tbl_kelasmahasiswa_by->nomor_kelasmahasiswa";?></option>
								<?php foreach($tbl_kelasmahasiswa as $kelasmahasiswa){?>
								<option value="<?php echo $kelasmahasiswa->id_kelasmahasiswa;?>"><?php $nama_semester2 = $semester[$kelasmahasiswa->semester_kelasmahasiswa]; echo "T.A : $kelasmahasiswa->periode_kelasmahasiswa - Semester : $nama_semester2 - Kelas : $kelasmahasiswa->nomor_kelasmahasiswa";?></option>
								<?php } ?>
							</select>
						</div>
						<div class="form-group">
							<label>Dosen</label>
							<select name="id_user_dosen_soal" id="id_user_dosen_soal" class="form-control select2" data-placeholder="Pilih Dosen" required style="width: 100%;" >
								<option value="<?php echo $tbl_user_by->id_user;?>"><?php echo $tbl_user_by->nidn_user;?> - <?php echo $tbl_user_by->nama_user;?></option>
								<?php foreach($tbl_user as $user){?>
								<option value="<?php echo $user->id_user;?>"><?php echo $user->nidn_user;?> - <?php echo $user->nama_user;?></option>
								<?php } ?>
							</select>
						</div>
						<div class="form-group">
							<label>&nbsp;</label>
							<input type="submit" value="Submit" class="form-control btn btn-success">
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label>Hari/Tanggal</label>
							<input type="date" name="tanggal_soal" class="form-control" value="<?php echo $tbl_soal->tanggal_soal;?>">
						</div>
						<div class="form-group">
							<label>Total Waktu</label>
							<input type="number" name="totalwaktu_soal" class="form-control" value="<?php echo $tbl_soal->totalwaktu_soal;?>">
						</div>
						<div class="form-group">
							<label>Sifat Ujian</label>
							<select name="sifatujian_soal" id="sifatujian_soal" class="form-control select2" data-placeholder="Pilih Sifat Ujian" required style="width: 100%;" >
								<option value="<?php echo $tbl_soal->sifatujian_soal;?>"><?php $sifat_ujian = array("Open Book","Close Book"); echo $sifat_ujian[$tbl_soal->sifatujian_soal];?></option>
								<option value="0"> Open Book</option>
								<option value="1"> Close Book</option>
							</select>
						</div>
						<div class="form-group">
							<label>Tipe Soal</label>
							<select name="tipe_soal" id="tipe_soal" class="form-control select2" data-placeholder="Pilih Tipe Soal" required style="width: 100%;" >
								<option value="<?php echo $tbl_soal->tipe_soal;?>"><?php echo $tbl_soal->tipe_soal;?></option>
								<?php
								foreach (range('A', 'Z') as $char) {
									echo "<option value='$char'> $char </option>";
								}
							   ?>
							</select>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label>Isi Soal</label>
							<textarea rows="12" id="deskripsi" class="form-control" name="isi_soal" placeholder="Isi Soal" required><?php echo $tbl_soal->isi_soal;?></textarea>
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
 
<script src="<?php echo base_url('assets/plugins/tinymce/tinymce.min.js'); ?>"></script>
<script type="text/javascript">
	tinymce.init({
    selector: '#deskripsi',
    plugins : 'advlist autolink link lists charmap print preview table'
  });
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#blah').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
</script>