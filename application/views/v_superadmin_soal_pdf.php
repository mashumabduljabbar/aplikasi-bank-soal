<!DOCTYPE html>
<html>
<head>
	<title>
		Soal <?php echo $id_soal;  ?>
	</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css">
<style>
body {font-family: Times New Roman;
	font-size: 9pt;
}

hr { 
    display: block;
    margin-top: 2em;
    margin-bottom: 0.5em;
    margin-left: AUTO;
    margin-right: auto;
    border-style: inset;
    border-width: 20px;
	border: 2;
    height: 1.5px;
    color: black;
}
 
table { border-collapse: separate; border-spacing: 2px; }
th, td { border-radius: 2.25em; border-style: solid; }

p {	margin: 0pt; }
table.items {
	border: none;
}
td { vertical-align: top; }

table thead td { background-color: #EEEEEE;
	text-align: center;
	border: 0.1mm solid #bbbbbb;
	font-size: 9pt;
}

strong { font-weight: bold; }

</style>
</head>
<body>
<table border='0' width='100%' style="border-bottom: 1px solid black;">
<tr border='0'>
<td><img style='vertical-align: top' width='100%' height='' class="img img-responsive user-image" id="blah" src="<?php echo base_url();?>assets/dist/img/kop/<?php echo $tbl_formatsoal->kopsurat_formatsoal."?".strtotime("now");?>" ></td></tr>
</table>
<h5 style="text-align:center;">Naskah Ujian Semester <?php echo $tbl_soal->gg_kelasmahasiswa;?> <br>Tahun Akademik <?php echo $tbl_soal->periode_kelasmahasiswa;?></h5>
<br>
<table border='0' width='100%' style="border-bottom: 1px solid black;">
	<tr>
		<td style="text-align:center;" width='30%'>
			<table border='0'>
				<tr>
					<td style="font-size:25pt; border:1px solid black; padding:10px; margin:10px; text-align:center;"> &nbsp;<?php echo $tbl_soal->tipe_soal;?>&nbsp;</td>
				</tr>
			</table>
		</td>
		<td width='70%'>
			<table border='0'>
				<tr>
					<td style="padding-left:5px;">Mata Kuliah </td>
					<td style="padding-left:5px;"> : </td>
					<td style="padding-left:5px;"> <?php echo $tbl_soal->nama_matakuliah;?> </td>
				</tr>
				<tr>
					<td style="padding-left:5px;">Prodi/Semester </td>
					<td style="padding-left:5px;"> : </td>
					<td style="padding-left:5px;"> <?php echo $tbl_soal->nama_prodi;?> / <?php echo $tbl_soal->semester;?> </td>
				</tr>
				<tr>
					<td style="padding-left:5px;">Dosen </td>
					<td style="padding-left:5px;"> : </td>
					<td style="padding-left:5px;"> <?php echo $tbl_soal->nama_user;?> </td>
				</tr>
				<tr>
					<td style="padding-left:5px;">Hari / Tanggal </td>
					<td style="padding-left:5px;"> : </td>
					<td style="padding-left:5px;"> <?php echo $haritanggal;?> </td>
				</tr>
				<tr>
					<td style="padding-left:5px;">Waktu </td>
					<td style="padding-left:5px;"> : </td>
					<td style="padding-left:5px;"> <?php echo $tbl_soal->totalwaktu_soal;?> Menit</td>
				</tr>
				<tr>
					<td style="padding-left:5px;">Sifat Ujian </td>
					<td style="padding-left:5px;"> : </td>
					<td style="padding-left:5px;"> <?php echo $tbl_soal->sifatujian;?> </td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<table border='0' style="border-bottom: 1px solid black;" width="100%">
	<tr>
		<td style="padding-left:5px;">Petunjuk </td>
	</tr>
	<tr>
		<td style="padding-left:5px;"><?php echo $tbl_formatsoal->petunjukujian_formatsoal;?> </td>
	</tr>
</table>
<br>
<?php echo $tbl_soal->isi_soal;?> </td>
