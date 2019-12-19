  <div class="content-wrapper" >
    <section class="content-header">
      <h3>
        Tambah Matakuliah
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
							$nama_matakuliah = $nama_matakuliah;
							$kode_matakuliah = $kode_matakuliah;
							$totalsks_matakuliah = $totalsks_matakuliah;
					?>
						<p style="color:red;"><i>Kode Matakuliah sudah digunakan, silahkan coba yang lain.</i></p>
					<?php 
					}else{
							$nama_matakuliah = "";
							$kode_matakuliah = "";
							$totalsks_matakuliah = "";
					}?>
				</div>
				<div class="box-body">
				  <div class="row">
				  <?php echo form_open_multipart("adminprodi/matakuliah_aksi_tambah"); ?>
					<div class="col-md-4">
					  <div class="form-group">
						<label>Kode Matakuliah</label>
						<input type="text" class="form-control" name="kode_matakuliah" placeholder="Kode Matakuliah" value="<?php echo $kode_matakuliah;?>" required>
					  </div>
					  <div class="form-group">
						<label>Nama Matakuliah</label>
						<input type="text" class="form-control" name="nama_matakuliah" placeholder="Nama Matakuliah" value="<?php echo $nama_matakuliah;?>" required>
					  </div>
					  <div class="form-group">
						<label>Total SKS</label>
						<input type="number" class="form-control" name="totalsks_matakuliah" placeholder="Total SKS Matakuliah" value="<?php echo $totalsks_matakuliah;?>" required>
					  </div>
					  <input type="hidden" name="id_prodi" value="<?php echo $tbl_prodi->id_prodi;?>">
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