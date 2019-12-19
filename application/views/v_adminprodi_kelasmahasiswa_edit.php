  <div class="content-wrapper" >
    <section class="content-header">
      <h3>
        Ubah Kelas Mahasiswa
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
				  <?php echo form_open_multipart("adminprodi/kelasmahasiswa_aksi_ubah/$tbl_kelasmahasiswa->id_kelasmahasiswa"); ?>
					<div class="col-md-4">
						<input type="hidden" name="id_prodi" value="<?php echo $tbl_kelasmahasiswa->id_prodi;?>">
					  <div class="form-group">
						<label>Periode</label>
						<select name="periode_kelasmahasiswa" id="periode_kelasmahasiswa" class="form-control select2" data-placeholder="Pilih Periode" required style="width: 100%;" >
							<option value="<?php echo $tbl_kelasmahasiswa->periode_kelasmahasiswa.' '.$tbl_kelasmahasiswa->gg_kelasmahasiswa;?>"><?php echo $tbl_kelasmahasiswa->periode_kelasmahasiswa.' '.$tbl_kelasmahasiswa->gg_kelasmahasiswa;?></option>
							<?php 
								$firstYear = (int)date('Y');
								$lastYear = $firstYear + 20;
								for($i=$firstYear;$i<=$lastYear;$i++)
								{
									echo '<option value="'.$i.'/'.($i+1).' Ganjil">'.$i.'/'.($i+1).' Ganjil</option>';
									echo '<option value="'.$i.'/'.($i+1).' Genap">'.$i.'/'.($i+1).' Genap</option>';
								}
							?>
						</select>
					  </div>
					  <div class="form-group">
						<label>Semester</label>
						<select name="semester_kelasmahasiswa" id="semester_kelasmahasiswa" class="form-control select2" data-placeholder="Pilih Semester" required style="width: 100%;" >
							
						</select>
					  </div>
					  <div class="form-group">
						<label>Nomor Kelas Mahasiswa</label>
						<input type="number" class="form-control" name="nomor_kelasmahasiswa" placeholder="Nomor Kelas Mahasiswa"  required value="<?php echo $tbl_kelasmahasiswa->nomor_kelasmahasiswa;?>">
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
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
<script>  
$(document).ready(function() {		
		var periode_kelasmahasiswa = $("#periode_kelasmahasiswa").val();
		$.ajax({
			url: "<?php echo base_url('adminprodi/kelasmahasiswa_semester/'.$tbl_kelasmahasiswa->id_kelasmahasiswa);?>",
			type     : 'POST',
			dataType : 'html',
			data: 'periode_kelasmahasiswa='+periode_kelasmahasiswa,
			cache: false,
			success: function(response){
				$("#semester_kelasmahasiswa").html(response);
			}
		});
		$("#semester_kelasmahasiswa").hide();
});	
</script>