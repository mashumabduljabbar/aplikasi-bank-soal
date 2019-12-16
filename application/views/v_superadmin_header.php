<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Bank Soal</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/iCheck/all.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/colorpicker/bootstrap-colorpicker.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/select2/select2.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/skins/_all-skins.min.css">
  <style>
.none {
    display:none;
}
</style>
</head>
<body class="hold-transition skin-red sidebar-mini" onload="tampilkanwaktu();setInterval('tampilkanwaktu()', 1000);">
<table width="100%" style="border-bottom:1px solid black;">
<tr>
	<td style="text-align:right; padding:10px;" width="15%">
		<img src="<?php echo base_url(); ?>assets/dist/img/logo.png" width="60px">
	</td>
	<td style="text-align:left;" width="85%">
		<h4 style="text-align:center; font-size:1.1em"><b>Aplikasi Bank Soal <br>
		Universitas Lancang Kuning</b></h4>
	</td>
</tr>
</table>
<div class="wrapper"> 
<?php if($this->uri->segment(1)=="superadmin"){
	include("v_superadmin_menu.php");
}elseif($this->uri->segment(1)=="adminprodi"){
	include("v_adminprodi_menu.php");
}elseif($this->uri->segment(1)=="nonadmin"){
	include("v_nonadmin_menu.php");
}
?>