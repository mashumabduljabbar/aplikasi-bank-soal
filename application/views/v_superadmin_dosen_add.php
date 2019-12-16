  <div class="content-wrapper" >
    <section class="content-header">
      <h3>
        Tambah Dosen
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
					<?php 
					if($err==1){
							$nidn_user = $nidn_user;
							$user_password = $user_password;
							$nama_user = $nama_user;
							$notelp_user = $notelp_user;
							$email_user = $email_user;
							$level_user = $level_user;
					?>
						<p style="color:red;"><i>ID Dosen sudah digunakan, silahkan coba yang lain.</i></p>
					<?php 
					}else{
							$nidn_user = "";
							$user_password = "";
							$nama_user = "";
							$notelp_user = "";
							$email_user = "";
							$email_user = "";
							$level_user = "";
					}?>
				</div>
				<div class="box-body">
				  <div class="row">
				  <?php echo form_open_multipart("superadmin/dosen_aksi_tambah"); ?>
					<div class="col-md-4">
					  <div class="form-group">
						<label>NIDN Dosen</label>
						<input type="text" class="form-control" name="nidn_user" placeholder="NIDN Dosen" value="<?php echo $nidn_user;?>" required>
					  </div>
					  <div class="form-group">
						<label>Nama Dosen</label>
						<input type="text" class="form-control" name="nama_user" placeholder="Nama Dosen" value="<?php echo $nama_user;?>" required>
					  </div>
					  <div class="form-group">
						<label>Password</label>
						<input type="password" class="form-control" name="user_password" placeholder="Password" value="<?php echo $user_password;?>" required>
					  </div>
					   <div class="form-group">
						<label>Level</label>
						<select name="level_user" class="form-control select2" data-placeholder="Pilih Level" required >
							<option value="<?php echo $level_user;?>"><?php echo $level_user;?></option>
							<option value="superadmin">Super Admin</option>
							<option value="adminprodi">Admin Prodi</option>
							<option value="nonadmin">Non Admin</option>
						</select>
					  </div>
					</div>
					<div class="col-md-4">
						 <div class="form-group">
						<label>No Telp / HP</label>
						<input type="text" class="form-control" name="notelp_user" placeholder="No Telp / HP" value="<?php echo $notelp_user;?>" required>
					  </div>
					  <div class="form-group">
						<label>Email</label>
						<input type="text" class="form-control" name="email_user" placeholder="Email" value="<?php echo $email_user;?>" required>
					  </div>
					  <div class="form-group">
						<label>Prodi</label>
						<select name="id_prodi" class="form-control select2" data-placeholder="Pilih Prodi" required >
							<option></option>
							<?php foreach($tbl_prodi as $prodi){?>
							<option value="<?php echo $prodi->id_prodi;?>"><?php echo $prodi->nama_prodi;?></option>
							<?php } ?>
							<option value="0"> Tidak Ada </option>
						</select>
					  </div>
					  <div class="form-group">
						<label>&nbsp;</label>
						<input type="submit" value="Submit" class="form-control btn btn-success">
					  </div>
					</div>
					<div class="col-md-4">
					  <div class="form-group">
						<label>Foto Profil</label>
						<img class="img img-responsive user-image" id="blah" >
						<input type="file" onchange="readURL(this);"  class="form-control" name="userfiles" required>
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

 <script type="text/javascript">
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