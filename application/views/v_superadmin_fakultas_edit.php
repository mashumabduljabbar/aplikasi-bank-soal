  <div class="content-wrapper" >
    <section class="content-header">
      <h3>
        Ubah Fakultas
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
							$nama_fakultas = $nama_fakultas;
							$alamat_fakultas = $alamat_fakultas;
							$notelp_fakultas = $notelp_fakultas;
							$email_fakultas = $email_fakultas;
					?>
						<p style="color:red;"><i>Nama Fakultas sudah digunakan, silahkan coba yang lain.</i></p>
					<?php 
					}else{
							$nama_fakultas = $tbl_fakultas->nama_fakultas;
							$alamat_fakultas = $tbl_fakultas->alamat_fakultas;
							$notelp_fakultas = $tbl_fakultas->notelp_fakultas;
							$email_fakultas = $tbl_fakultas->email_fakultas;
					}?>
				</div>
				<div class="box-body">
				  <div class="row">
				  <?php echo form_open_multipart("superadmin/fakultas_aksi_ubah/$tbl_fakultas->id_fakultas"); ?>
					<div class="col-md-4">
					  <div class="form-group">
						<label>Nama Fakultas</label>
						<input type="text" class="form-control" name="nama_fakultas[]" placeholder="Nama Fakultas" value="<?php echo $nama_fakultas;?>" required>
						<input type="hidden" name="nama_fakultas[]" value="<?php echo $tbl_fakultas->nama_fakultas;?>" >
					  </div>
					  <div class="form-group">
						<label>Alamat Fakultas</label>
						<input type="text" class="form-control" name="alamat_fakultas" placeholder="Alamat Fakultas" value="<?php echo $alamat_fakultas;?>" required>
					  </div>
					  <div class="form-group">
						<label>No Telp Fakultas</label>
						<input type="text" class="form-control" name="notelp_fakultas" placeholder="No Telp Fakultas" value="<?php echo $notelp_fakultas;?>" required>
					  </div>
					  <div class="form-group">
						<label>Email Fakultas</label>
						<input type="email" class="form-control" name="email_fakultas" placeholder="Email Fakultas" value="<?php echo $email_fakultas;?>" required>
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