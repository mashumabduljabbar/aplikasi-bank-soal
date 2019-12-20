<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include APPPATH . 'third_party/ssp.php';
class Nonadmin extends CI_Controller {
	public function __construct(){
		parent::__construct();
		if($this->session->userdata('status') != "login" or $this->session->userdata('level') != "nonadmin"){
			redirect(base_url("login"));
		}
		$this->load->model('m_general');
	}
	
	////////////////////////////////////
	
	public function index()
    {
		redirect("nonadmin/profile");
    }
	
	public function profile()
    {
		
		$id_user = $this->session->userdata("userid");
		$where = array("id_user" => $id_user);
		$data['tbl_user'] = $this->m_general->view_by("tbl_user",$where);
		if($data['tbl_user']->id_prodi>0){
			$tbl_prodi_by= $this->m_general->view_by("tbl_prodi",array("id_prodi" => $data['tbl_user']->id_prodi));
			$data['nama_prodi'] = $tbl_prodi_by->nama_prodi;
		}else{
			$data['nama_prodi'] = "Tidak Ada";
		}
		$data['err'] = "";
		$data['tbl_prodi'] = $this->m_general->view_order("tbl_prodi","nama_prodi ASC");
		$this->load->view("v_superadmin_header");
		$this->load->view('v_nonadmin_profile_edit', $data);
		$this->load->view("v_superadmin_footer");
	}
	
	public function profile_aksi_ubah()
    {
			$id_user = $this->session->userdata("userid");
			$where['id_user'] = $id_user;
			$data['tbl_user'] = $this->m_general->view_by("tbl_user",$where);
			$tbl_user = $this->m_general->view_by("tbl_user",$where);
			$nidn_user = $this->input->post('nidn_user')[0];
			$nidn_user_old = $this->input->post('nidn_user')[1];
			$user_password = $this->input->post('user_password')[0];
			$user_password_old = $this->input->post('user_password')[1];
			
			$id_prodi = $this->input->post('id_prodi');
			$level_user = $this->input->post('level_user');
			$nama_user = $this->input->post('nama_user');
			$notelp_user = $this->input->post('notelp_user');
			$email_user = $this->input->post('email_user');
			$foto_user = $this->input->post('foto_user');
			$id_prodi = $this->input->post('id_prodi');
			
			if($nidn_user!=$nidn_user_old){
				$check_user = $this->m_general->countdata("tbl_user", array("nidn_user" => $nidn_user));
				$_POST['nidn_user'] = $nidn_user;
			}else{
				$check_user = 0;
				$_POST['nidn_user'] = $nidn_user;
			}
			
			if($check_user==0){
				if($user_password!=$user_password_old){
					$_POST['user_password'] = md5($user_password);
				}else{
					$_POST['user_password'] = $user_password;
				}
					$folder = "avatar";
					$file_upload = $_FILES['userfiles'];
					$files = $file_upload;
					
					if($files['name'] != "" OR $files['name'] != NULL){
						$file = './assets/dist/img/avatar/'.$tbl_user->foto_user;
						if($tbl_user->foto_user!="default/user.png" && is_readable($file)){
							unlink($file);
						}
						$_POST['foto_user'] = $this->m_general->file_upload($files, $folder);
					}else{
						$_POST['foto_user'] = $foto_user;
					}
					$_POST['user_name'] = $nidn_user;
					$this->m_general->edit("tbl_user", $where, $_POST);
					redirect('nonadmin/profile/sukses');
			}else{
					$data['err'] = 1;
					$data['nidn_user'] = $nidn_user;
					$data['user_password'] = $user_password;
					$data['nama_user'] = $nama_user;
					$data['notelp_user'] = $notelp_user;
					$data['email_user'] = $email_user;
					$data['level_user'] = $level_user;
					$data['id_prodi'] = $id_prodi;
					if($id_prodi>0){
						$tbl_prodi_by= $this->m_general->view_by("tbl_prodi",array("id_prodi" => $id_prodi));
						$data['nama_prodi'] = $tbl_prodi_by->nama_prodi;
					}else{
						$data['nama_prodi'] = "Tidak Ada";
					}
					$data['tbl_prodi'] = $this->m_general->view_order("tbl_prodi","nama_prodi ASC");
					$this->load->view("v_superadmin_header");
					$this->load->view("v_nonadmin_profile_edit",$data);
					$this->load->view("v_superadmin_footer");
			}
    }	
	
	
	////////////////////////////////////
	
	////////////////////////////////////
	
	public function kelasmahasiswa_matakuliah()
    {
		$id_user = $this->session->userdata("userid");
		$user = $this->db->query("select * from tbl_user where id_user='$id_user'")->row();
		$query = $this->db->query("select * from tbl_prodi where id_prodi='$user->id_prodi'");
		if($query->num_rows()>0){
			$prodi = $query->row();
			$where['id_prodi'] = $prodi->id_prodi;
		}else{
			$where['id_prodi'] = "0";
		}	
		$tbl_prodi = $this->m_general->view_by("tbl_prodi",$where);
		$tbl_matakuliah = $this->m_general->view_where("tbl_matakuliah", array("id_prodi" => $tbl_prodi->id_prodi), "nama_matakuliah ASC");
			echo "<option>-- Pilih Mata Kuliah --</option>";
		foreach($tbl_matakuliah as $matakuliah){
			echo "<option value='$matakuliah->id_matakuliah'>$matakuliah->nama_matakuliah</option>";
		}
    }
	
	public function kelasmahasiswa_kelasmahasiswa()
    {
		$id_user = $this->session->userdata("userid");
		$user = $this->db->query("select * from tbl_user where id_user='$id_user'")->row();
		$query = $this->db->query("select * from tbl_prodi where id_prodi='$user->id_prodi'");
		if($query->num_rows()>0){
			$prodi = $query->row();
			$where['id_prodi'] = $prodi->id_prodi;
		}else{
			$where['id_prodi'] = "0";
		}	
		$tbl_prodi = $this->m_general->view_by("tbl_prodi",$where);
		
		$tbl_kelasmahasiswa = $this->m_general->view_where("tbl_kelasmahasiswa", array("id_prodi" => $tbl_prodi->id_prodi), "semester_kelasmahasiswa ASC");
			echo "<option>-- Pilih Kelas --</option>";
		foreach($tbl_kelasmahasiswa as $kelasmahasiswa){
			$semester = array("","I","II","III","IV","V","VI");
			$nama_semester = $semester[$kelasmahasiswa->semester_kelasmahasiswa];
			echo "<option value='$kelasmahasiswa->id_kelasmahasiswa'>T.A : $kelasmahasiswa->periode_kelasmahasiswa - Semester : $nama_semester - Kelas : $kelasmahasiswa->nomor_kelasmahasiswa</option>";
		}
    }
	
	////////////////////////////////////
	
	////////////////////////////////////
	
	public function get_data_master_soal()
	{		
		$id_user = $this->session->userdata("userid");
		$user = $this->db->query("select * from tbl_user where id_user='$id_user'")->row();
		$query = $this->db->query("select * from tbl_prodi where id_prodi='$user->id_prodi'");
		if($query->num_rows()>0){
			$prodi = $query->row();
			$where = $prodi->id_prodi;
		}else{
			$where = "0";
		}
		$table = "
        (
            SELECT (@cnt := @cnt + 1) AS rowNumber, d.nama_fakultas, c.nama_prodi, b.nama_matakuliah, 
		CONCAT(
				CASE
					 	WHEN e.semester_kelasmahasiswa='1' THEN 'I'
					 	WHEN e.semester_kelasmahasiswa='2' THEN 'II'
					 	WHEN e.semester_kelasmahasiswa='3' THEN 'III'
					 	WHEN e.semester_kelasmahasiswa='4' THEN 'IV'
					 	WHEN e.semester_kelasmahasiswa='5' THEN 'V'
					 	WHEN e.semester_kelasmahasiswa='6' THEN 'VI'						 
					END
		,' / ',e.nomor_kelasmahasiswa) as semester, f.nama_user, a.tanggal_soal,
                a.totalwaktu_soal, CASE
					 	WHEN a.sifatujian_soal='0' THEN 'Open Book'
					 	WHEN a.sifatujian_soal='1' THEN 'Close Book'
					END as sifatujian, a.id_soal, a.tipe_soal, a.id_user_dosen_soal
            FROM
                tbl_soal a
					 LEFT JOIN tbl_matakuliah b ON b.id_matakuliah=a.id_matakuliah
					 LEFT JOIN tbl_prodi c ON c.id_prodi=b.id_prodi
					 LEFT JOIN tbl_fakultas d ON d.id_fakultas=c.id_fakultas
					 LEFT JOIN tbl_kelasmahasiswa e ON e.id_kelasmahasiswa=a.id_kelasmahasiswa
					 LEFT JOIN tbl_user f ON f.id_user=a.id_user_dosen_soal
					 CROSS JOIN (SELECT @cnt := 0) AS dummy
					 WHERE c.id_prodi='$where'
        )temp";
		
        $primaryKey = 'id_soal';
        $columns = array(
        array( 'db' => 'rowNumber',     'dt' => 0 ),
        array( 'db' => 'nama_fakultas',     'dt' => 1 ),
        array( 'db' => 'nama_prodi',        'dt' => 2 ),
        array( 'db' => 'nama_matakuliah',       'dt' => 3 ),
        array( 'db' => 'semester',       'dt' => 4 ),
        array( 'db' => 'nama_user',       'dt' => 5 ),
        array( 'db' => 'tanggal_soal',       'dt' => 6 ),
        array( 'db' => 'tipe_soal',       'dt' => 7 ),
        array( 'db' => 'id_soal',       'dt' => 8 ),
        array( 'db' => 'id_user_dosen_soal',       'dt' => 9 ),
        );

        $sql_details = array(
            'user' => $this->db->username,
            'pass' => $this->db->password,
            'db'   => $this->db->database,
            'host' => $this->db->hostname
        );
        echo json_encode(
            SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns)
        );
	}	
	
	public function soal()
    {
		$data['id_user'] = $this->session->userdata("userid");
		$this->load->view("v_superadmin_header");
        $this->load->view("v_nonadmin_soal", $data);
        $this->load->view("v_superadmin_footer");
    }		
	public function soal_tambah()
    {
		$data['err'] = "";
		$id_user = $this->session->userdata("userid");
		$user = $this->db->query("select * from tbl_user where id_user='$id_user'")->row();
		$query = $this->db->query("select * from tbl_prodi where id_prodi='$user->id_prodi'");
		if($query->num_rows()>0){
			$prodi = $query->row();
			$query2 = $this->db->query("select * from tbl_formatsoal where id_prodi='$prodi->id_prodi' limit 1");
			$query3 = $this->db->query("select * from tbl_formatsoal limit 1");
			
			if($query2->num_rows()>0){
				$formatsoal = $query2->row();
			}else{
				$formatsoal = $query3->row();
			}
			
			$where = $formatsoal->id_prodi;
		}else{
			$prodi = $query->row();
			$query2 = $this->db->query("select * from tbl_formatsoal limit 1");
			$formatsoal = $query2->row();
			$where = $formatsoal->id_prodi;
		}
		
		$where2['id_prodi'] = $where;
		$data['tbl_formatsoal'] = $this->m_general->view_by("tbl_formatsoal", $where2);
		$data['id_user'] = $id_user;
		$this->load->view("v_superadmin_header");
        $this->load->view("v_nonadmin_soal_add",$data);
		$this->load->view("v_superadmin_footer");
    }
	public function soal_ubah($id_soal)
	{
		$where = array("id_soal" => $id_soal);
		$data['tbl_soal'] = $this->m_general->view_by("tbl_soal",$where);
		$data['err'] = "";
		$tbl_matakuliah = $this->m_general->view_by("tbl_matakuliah",array("id_matakuliah" => $data['tbl_soal']->id_matakuliah));
		$data['tbl_matakuliah'] = $this->m_general->view_where("tbl_matakuliah", array("id_prodi"=>$tbl_matakuliah->id_prodi),"nama_matakuliah ASC");
		$data['tbl_matakuliah_by']= $this->m_general->view_by("tbl_matakuliah",array("id_matakuliah" => $data['tbl_soal']->id_matakuliah));
		
		$data['tbl_kelasmahasiswa'] = $this->m_general->view_where("tbl_kelasmahasiswa", array("id_prodi"=>$tbl_matakuliah->id_prodi), "periode_kelasmahasiswa ASC");
		
		$data['tbl_kelasmahasiswa_by']= $this->m_general->view_by("tbl_kelasmahasiswa",array("id_kelasmahasiswa" => $data['tbl_soal']->id_kelasmahasiswa));
		$data['tbl_user'] = $this->m_general->view_order("tbl_user","nama_user ASC");
		$data['tbl_user_by']= $this->m_general->view_by("tbl_user",array("id_user" => $data['tbl_soal']->id_user_dosen_soal));
		$this->load->view("v_superadmin_header");
		$this->load->view('v_nonadmin_soal_edit', $data);
		$this->load->view("v_superadmin_footer");
	}	
	public function soal_aksi_tambah()
    {
			$_POST['id_soal'] = $this->m_general->bacaidterakhir("tbl_soal", "id_soal");
			$this->m_general->add("tbl_soal", $_POST);
			redirect('nonadmin/soal');
	}				
	public function soal_aksi_ubah($id_soal)
    {
			$where['id_soal'] = $id_soal;
			$this->m_general->edit("tbl_soal", $where, $_POST);
			redirect('nonadmin/soal');		
    }	
	public function soal_aksi_hapus($id_soal){
			$where['id_soal'] = $id_soal;
			$this->m_general->hapus("tbl_soal", $where); // Panggil fungsi hapus() yang ada di m_general.php
			redirect('nonadmin/soal');
	}
	
	public function soal_cetak($id_soal){
		$where['id_soal'] = $id_soal;
		$tbl_soal =  $this->m_general->view_by("tbl_soal", $where);
		$where2['id_formatsoal'] = $tbl_soal->id_formatsoal;
		$tbl_formatsoal =  $this->m_general->view_by("tbl_formatsoal", $where2);
		$data['tbl_soal'] =  $this->db->query("SELECT (@cnt := @cnt + 1) AS rowNumber, d.nama_fakultas, c.nama_prodi, b.nama_matakuliah, 
		CASE
					 	WHEN e.semester_kelasmahasiswa='1' THEN 'I'
					 	WHEN e.semester_kelasmahasiswa='2' THEN 'II'
					 	WHEN e.semester_kelasmahasiswa='3' THEN 'III'
					 	WHEN e.semester_kelasmahasiswa='4' THEN 'IV'
					 	WHEN e.semester_kelasmahasiswa='5' THEN 'V'
					 	WHEN e.semester_kelasmahasiswa='6' THEN 'VI'						 
					END
		 as semester, f.nama_user, a.tanggal_soal, e.gg_kelasmahasiswa, e.periode_kelasmahasiswa,
                a.totalwaktu_soal, CASE
					 	WHEN a.sifatujian_soal='0' THEN 'Open Book'
					 	WHEN a.sifatujian_soal='1' THEN 'Close Book'
					END as sifatujian, a.id_soal, a.tipe_soal, a.isi_soal
            FROM
                tbl_soal a
					 LEFT JOIN tbl_matakuliah b ON b.id_matakuliah=a.id_matakuliah
					 LEFT JOIN tbl_prodi c ON c.id_prodi=b.id_prodi
					 LEFT JOIN tbl_fakultas d ON d.id_fakultas=c.id_fakultas
					 LEFT JOIN tbl_kelasmahasiswa e ON e.id_kelasmahasiswa=a.id_kelasmahasiswa
					 LEFT JOIN tbl_user f ON f.id_user=a.id_user_dosen_soal
					 CROSS JOIN (SELECT @cnt := 0) AS dummyb where id_soal='$id_soal'")->row();
		$data['tbl_formatsoal'] =  $tbl_formatsoal;
		$data['id_soal'] =  $id_soal;
		$data['haritanggal'] = $this->m_general->getHari($tbl_soal->tanggal_soal)." / ".$this->m_general->getTanggalIndo($tbl_soal->tanggal_soal);
		$mpdf = new \Mpdf\Mpdf([
		'mode' => 'utf-8', 
		'format' => 'A4-P',
		'margin_left' => 12,
		'margin_right' => 12,
		'margin_top' => 5,
		'margin_bottom' => 10,
		'margin_header' => 3,
		'margin_footer' => 3,
		]); //L For Landscape , P for Portrait
        $mpdf->SetTitle($tbl_soal->id_soal);
		$halaman = $this->load->view('v_superadmin_soal_pdf',$data,true);
		$mpdf->setFooter('{PAGENO}');
        $mpdf->WriteHTML($halaman);
        $mpdf->Output();
	}
	
	////////////////////////////////////
	
	////////////////////////////////////
}