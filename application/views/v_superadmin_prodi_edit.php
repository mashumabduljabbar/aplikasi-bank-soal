  <div class="content-wrapper" >
    <section class="content-header">
      <h3>
        Ubah Prodi
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
							$kode_prodi = $kode_prodi;
							$nama_prodi = $nama_prodi;
							$id_fakultas = $tbl_fakultas_by->id_fakultas;
							$nama_fakultas = $tbl_fakultas_by->nama_fakultas;
							$id_user_kepala_prodi = $tbl_user1_by->id_user;
							$nama_kepala_prodi = $tbl_user1_by->nama_user;
							$id_user_admin_prodi = $tbl_user2_by->id_user;
							$nama_admin_prodi = $tbl_user2_by->nama_user;
					?>
						<p style="color:red;"><i>Nama Prodi sudah digunakan, silahkan coba yang lain.</i></p>
					<?php 
					}else{
							$kode_prodi = $tbl_prodi->kode_prodi;
							$nama_prodi = $tbl_prodi->nama_prodi;
							$id_fakultas = $tbl_fakultas_by->id_fakultas;
							$nama_fakultas = $tbl_fakultas_by->nama_fakultas;
							$id_user_kepala_prodi = $tbl_user1_by->id_user;
							$nama_kepala_prodi = $tbl_user1_by->nama_user;
							$id_user_admin_prodi = $tbl_user2_by->id_user;
							$nama_admin_prodi = $tbl_user2_by->nama_user;
					}?>
				</div>
				<div class="box-body">
				  <div class="row">
				  <?php echo form_open_multipart("superadmin/prodi_aksi_ubah/$tbl_prodi->id_prodi"); ?>
					<div class="col-md-4">
					  <div class="form-group">
						<label>Kode Prodi</label>
						<input type="text" class="form-control" name="kode_prodi[]" placeholder="Kode Prodi" value="<?php echo $kode_prodi;?>" required>
						<input type="hidden" name="kode_prodi[]" value="<?php echo $tbl_prodi->kode_prodi;?>" >
					  </div>
					  <div class="form-group">
						<label>Nama Prodi</label>
						<input type="text" class="form-control" name="nama_prodi" placeholder="Nama Prodi" value="<?php echo $nama_prodi;?>" required>
					  </div>
					  <div class="form-group">
						<label>Fakultas</label>
						<select name="id_fakultas" class="form-control select2" data-placeholder="Pilih Fakultas" required >
							<option value="<?php echo $id_fakultas;?>"><?php echo $nama_fakultas;?></option>
							<?php foreach($tbl_fakultas as $fakultas){?>
							<option value="<?php echo $fakultas->id_fakultas;?>"><?php echo $fakultas->nama_fakultas;?></option>
							<?php } ?>
						</select>
					  </div>
					  <div class="form-group">
						<label>Kaprodi</label>
						<select name="id_user_kepala_prodi" class="form-control select2" data-placeholder="Pilih Fakultas" required >
							<option value="<?php echo $tbl_user1_by->id_user;?>"><?php echo $tbl_user1_by->nama_user;?></option>
							<?php foreach($tbl_user as $user){?>
							<option value="<?php echo $user->id_user;?>"><?php echo $user->nama_user;?></option>
							<?php } ?>
						</select>
					  </div>
					  <div class="form-group">
						<label>Admin Prodi</label>
						<select name="id_user_admin_prodi" class="form-control select2" data-placeholder="Pilih Fakultas" required >
							<option value="<?php echo $tbl_user2_by->id_user;?>"><?php echo $tbl_user2_by->nama_user;?></option>
							<?php foreach($tbl_user as $user){?>
							<option value="<?php echo $user->id_user;?>"><?php echo $user->nama_user;?></option>
							<?php } ?>
						</select>
					  </div>
					  <div class="form-group">
						<input type="submit" value="Submit" class="btn btn-success">
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