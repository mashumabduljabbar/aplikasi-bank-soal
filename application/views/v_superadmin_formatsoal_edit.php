<div class="content-wrapper" >
    <section class="content-header">
      <h3>
        Ubah Format Soal
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
				  <?php echo form_open_multipart("superadmin/formatsoal_aksi_ubah/$tbl_formatsoal->id_formatsoal"); ?>
					<div class="col-md-6">
					  <div class="form-group">
						<label>Petunjuk</label>
						<textarea id="deskripsi" rows="5" class="form-control" name="petunjukujian_formatsoal" placeholder="Petunjuk" required><?php echo $tbl_formatsoal->petunjukujian_formatsoal;?></textarea>
					  </div>
					</div>
					<div class="col-md-4">
					  <div class="form-group">
						<label>Prodi</label>
						<select name="id_prodi" class="form-control select2" data-placeholder="Pilih Prodi" required >
							<option value="<?php echo $id_prodi;?>"><?php echo $nama_prodi;?></option>
							<?php foreach($tbl_prodi as $prodi){?>
							<option value="<?php echo $prodi->id_prodi;?>"><?php echo $prodi->nama_prodi;?></option>
							<?php } ?>
						</select>
					  </div>
					</div>
					<div class="col-md-4">
					  <div class="form-group">
						<label>Kop Surat</label>
						<img width="220px" class="img img-responsive user-image" id="blah" src="<?php echo base_url();?>assets/dist/img/kop/<?php echo $tbl_formatsoal->kopsurat_formatsoal."?".strtotime("now");?>">
						<input type="hidden" name="kopsurat_formatsoal" value="<?php echo $tbl_formatsoal->kopsurat_formatsoal; ?>">
						<input type="file" onchange="readURL(this);"  class="form-control" name="userfiles" >
					  </div>
					  <div class="form-group">
						<label>&nbsp;</label>
						<input type="submit" value="Submit" class="form-control btn btn-success">
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
 <!-- include summernote css/js -->
<script src="<?php echo base_url('assets/plugins/tinymce/tinymce.min.js'); ?>"></script>
<script type="text/javascript">
	tinymce.init({
    selector: '#deskripsi',
    plugins : 'advlist autolink link lists charmap print preview'
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