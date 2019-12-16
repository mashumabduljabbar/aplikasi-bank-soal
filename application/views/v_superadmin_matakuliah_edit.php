  <div class="content-wrapper" >
    <section class="content-header">
      <h3>
        Ubah Matakuliah
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
							$kode_matakuliah = $kode_matakuliah;
							$nama_matakuliah = $nama_matakuliah;
							$totalsks_matakuliah = $totalsks_matakuliah;
							$id_prodi = $tbl_prodi_by->id_prodi;
							$nama_prodi = $tbl_prodi_by->nama_prodi;
					?>
						<p style="color:red;"><i>Nama Matakuliah sudah digunakan, silahkan coba yang lain.</i></p>
					<?php 
					}else{
							$kode_matakuliah = $tbl_matakuliah->kode_matakuliah;
							$nama_matakuliah = $tbl_matakuliah->nama_matakuliah;
							$totalsks_matakuliah = $tbl_matakuliah->totalsks_matakuliah;
							$id_prodi = $tbl_prodi_by->id_prodi;
							$nama_prodi = $tbl_prodi_by->nama_prodi;
					}?>
				</div>
				<div class="box-body">
				  <div class="row">
				  <?php echo form_open_multipart("superadmin/matakuliah_aksi_ubah/$tbl_matakuliah->id_matakuliah"); ?>
					<div class="col-md-4">
					  <div class="form-group">
						<label>Kode Matakuliah</label>
						<input type="text" class="form-control" name="kode_matakuliah[]" placeholder="Kode Matakuliah" value="<?php echo $kode_matakuliah;?>" required>
						<input type="hidden" name="kode_matakuliah[]" value="<?php echo $tbl_matakuliah->kode_matakuliah;?>" >
					  </div>
					  <div class="form-group">
						<label>Nama Matakuliah</label>
						<input type="text" class="form-control" name="nama_matakuliah" placeholder="Nama Matakuliah" value="<?php echo $nama_matakuliah;?>" required>
					  </div>
					  <div class="form-group">
						<label>Total SKS</label>
						<input type="number" class="form-control" name="totalsks_matakuliah" placeholder="Total SKS Matakuliah" value="<?php echo $totalsks_matakuliah;?>" required>
					  </div>
					  <div class="form-group">
						<label>Prodi</label>
						<select name="id_prodi" class="form-control select2" data-placeholder="Pilih Prodi" required >
							<option value="<?php echo $id_prodi;?>"><?php echo $nama_prodi;?></option>
							<?php foreach($tbl_prodi as $prodi){?>
							<option value="<?php echo $prodi->id_prodi;?>"><?php echo $prodi->nama_prodi;?></option>
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