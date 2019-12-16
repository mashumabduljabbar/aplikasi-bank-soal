<?php 
$id_user = $this->session->userdata("userid");
$user = $this->db->query("select * from tbl_user where id_user='$id_user'")->row();?>
  <header class="main-header">
    <a href="" class="logo">
      <span class="logo-mini"><b>M</b></span>
      <span class="logo-lg"><b>MENU</b></span>
    </a>
    <nav class="navbar navbar-static-top" >
		<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
			<span class="sr-only">Toggle navigation</span>
		</a>
		
		<div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
		  <!-- User Account: style can be found in dropdown.less -->
			  <li class="dropdown user user-menu">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">
				  <img src="<?php echo base_url();?>assets/dist/img/avatar/<?php echo $user->foto_user."?".strtotime("now");?>" class="user-image" alt="User Image">
				  <span class="hidden-xs">Hi, { <?php echo $user->nama_user; ?> }</span>
				</a>
				<ul class="dropdown-menu">
				  <!-- User image -->
				  <li class="user-header">
					<img src="<?php echo base_url();?>assets/dist/img/avatar/<?php echo $user->foto_user."?".strtotime("now");?>" class="img-circle" alt="User Image">
					<p>
					  <?php echo $user->nama_user; ?>
					  <small>Waktu : [ <span id="clock"></span> ] <?php
$hari = date('l');
/*$new = date('l, F d, Y', strtotime($Today));*/
if ($hari=="Sunday") {
 echo "Minggu";
}elseif ($hari=="Monday") {
 echo "Senin";
}elseif ($hari=="Tuesday") {
 echo "Selasa";
}elseif ($hari=="Wednesday") {
 echo "Rabu";
}elseif ($hari=="Thursday") {
 echo("Kamis");
}elseif ($hari=="Friday") {
 echo "Jum'at";
}elseif ($hari=="Saturday") {
 echo "Sabtu";
}
?>,

<?php
$tgl =date('d');
echo $tgl;
$bulan =date('F');
if ($bulan=="January") {
 echo " Januari ";
}elseif ($bulan=="February") {
 echo " Februari ";
}elseif ($bulan=="March") {
 echo " Maret ";
}elseif ($bulan=="April") {
 echo " April ";
}elseif ($bulan=="May") {
 echo " Mei ";
}elseif ($bulan=="June") {
 echo " Juni ";
}elseif ($bulan=="July") {
 echo " Juli ";
}elseif ($bulan=="August") {
 echo " Agustus ";
}elseif ($bulan=="September") {
 echo " September ";
}elseif ($bulan=="October") {
 echo " Oktober ";
}elseif ($bulan=="November") {
 echo " November ";
}elseif ($bulan=="December") {
 echo " Desember ";
}
$tahun=date('Y');
echo $tahun;
?></small>
					</p>
					
				  </li>
				  <!-- Menu Footer-->
				  <li class="user-footer">
					<div class="pull-right">
					  <a href="<?php echo base_url(); ?>login/logout" class="btn btn-default btn-flat">Sign out</a>
					</div>
				  </li>
				</ul>
			  </li>
			</ul>
      </div>
    </nav>
  </header>
  <?php
  $geturl = $this->uri->segment(2);
  $beranda = "";
  $DataFakultas = "";
  $DataProdi = "";
  $DataDosen = "";
  $DataKelasMahasiswa = "";
  $DataMatakuliah = "";
  $DataFormatSoal = "";
  $DataSoal = "";
  
  if($geturl=="" or strpos($geturl, "index")!== FALSE){
	  $beranda = "active";
  }
  if(strpos($geturl, "fakultas")!== FALSE){
	  $DataFakultas = "active";
  }
  if(strpos($geturl, "prodi")!== FALSE){
	  $DataProdi = "active";
  }
  if(strpos($geturl, "dosen")!== FALSE){
	  $DataDosen = "active";
  }
  if(strpos($geturl, "kelasmahasiswa")!== FALSE){
	  $DataKelasMahasiswa = "active";
  }
  if(strpos($geturl, "matakuliah")!== FALSE){
	  $DataMatakuliah = "active";
  }
  if(strpos($geturl, "formatsoal")!== FALSE){
	  $DataFormatSoal = "active";
  }
  if($this->uri->segment(2)=="soal"){
	  $DataSoal = "active";
  }
  
  ?>
  <aside class="main-sidebar">
    <section class="sidebar">
      <ul class="sidebar-menu">
        <li class="<?php echo $beranda;?>">
          <a href="<?php echo base_url(); ?>superadmin">
            <span>Home</span>
          </a>
        </li>
		<li class="<?php echo $DataFakultas;?>">
          <a href="<?php echo base_url(); ?>superadmin/fakultas">
            <span>Data Fakultas</span>
          </a>
        </li>
		<li class="<?php echo $DataProdi;?>">
          <a href="<?php echo base_url(); ?>superadmin/prodi">
            <span>Data Prodi</span>
          </a>
        </li>
		<li class="<?php echo $DataDosen;?>">
          <a href="<?php echo base_url(); ?>superadmin/dosen">
            <span>Data Dosen</span>
          </a>
        </li>
		<li class="<?php echo $DataKelasMahasiswa;?>">
          <a href="<?php echo base_url(); ?>superadmin/kelasmahasiswa">
            <span>Data Kelas Mahasiswa</span>
          </a>
        </li>
		<li class="<?php echo $DataMatakuliah;?>">
          <a href="<?php echo base_url(); ?>superadmin/matakuliah">
            <span>Data Matakuliah</span>
          </a>
        </li>
		<li class="<?php echo $DataFormatSoal;?>">
          <a href="<?php echo base_url(); ?>superadmin/formatsoal">
            <span>Data Format Soal</span>
          </a>
        </li>
		<li class="<?php echo $DataSoal;?>">
          <a href="<?php echo base_url(); ?>superadmin/soal">
            <span>Data Soal</span>
          </a>
        </li>
		<li class="">
          <a href="<?php echo base_url(); ?>login/logout">
            <span>Logout</span>
          </a>
        </li>
      </ul>
    </section>
  </aside>