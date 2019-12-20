  <div class="content-wrapper ">
    <section class="content-header">
      <h3>
        Data Soal
      </h3>
    </section>
    <!-- Main content -->
    <section class="content" >
      <div class="row">
		<div class="col-xs-12">
			<div class="box">
				<!-- /.box-header -->
				<div class="box-header">
					<h3 class="box-title">
					<label>
					<a class="btn-sm btn-primary" href="<?php echo base_url("nonadmin/soal_tambah");?>"><i class="fa fa-plus"></i> <span>Tambah Soal</span></a>
					</label>
					</h3>
				</div>
				<div class="box-body">
				<table id="datatable" class="table table-bordered table-striped display responsive nowrap" cellspacing="0" width="100%">
					<thead>
					<tr>
						<th>No</th>
						<th>Fakultas</th>
						<th>Prodi</th>
						<th>Matakuliah</th>
						<th>Smt/Kelas</th>
						<th>Dosen</th>
						<th>Hari/Tgl</th>
						<th>Tipe Soal</th>
						<th width="150px"> Action</th>
					</tr>
					</thead>
					<tbody>
					</tbody>
				  </table>
				</div>
				<!-- /.box-body -->
			  </div>
		</div>
      </div>
    </section>
  </div>
<script src="<?php echo base_url(); ?>assets/plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.responsive.min.js"></script>
<script>
var myTable =  $('#datatable').DataTable({
			"processing": true,
			"serverSide": true,
			"autoWidth": true,
			"paging": true,
			"info": true,
			'order': [[0, 'asc']],
			"ajax": "<?php echo base_url('nonadmin/get_data_master_soal/');?>" ,
			columnDefs: [{
				   targets: [8],
				   data: null,
				   render: function ( data, type, row, meta ) {                   
						var lihat = "<a href='<?php echo base_url();?>nonadmin/soal_cetak/"+row[8]+"'> <button type='button' class='btn btn-xs btn-success'><i class='fa fa-file-pdf-o'></i> Lihat </button></a> ";
						if(row[9]=="<?php echo $id_user;?>"){
							return lihat+" <a href='<?php echo base_url();?>nonadmin/soal_ubah/"+row[8]+"'> <button type='button' class='btn btn-xs btn-warning'><i class='fa fa-pencil'></i> </button></a> <a onclick=\"return confirm('Yakin untuk menghapus soal ini ?')\" href='<?php echo base_url();?>nonadmin/soal_aksi_hapus/"+row[8]+"'> <button type='button' class='btn btn-xs btn-danger'><i class='fa fa-trash'></i> </button></a>";
						}else{
							return lihat;
						}
				   }
				},],
		});

setInterval( function () {
    myTable.ajax.reload();
}, 4000 );
</script>