<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include APPPATH . 'third_party/ssp.php';
class Adminprodi extends CI_Controller {
	public function __construct(){
		parent::__construct();
		if($this->session->userdata('status') != "login" or $this->session->userdata('level') != "adminprodi"){
			redirect(base_url("login"));
		}
		$this->load->model('m_general');
	}
	
	////////////////////////////////////
	
	public function index()
    {
		redirect("adminprodi/profile");
    }
	
	public function profile()
    {
		$this->load->view("v_superadmin_header");
		$id_user = $this->session->userdata("userid");
		$query = $this->db->query("select * from tbl_prodi where id_user_admin_prodi='$id_user' limit 1");
		if($query->num_rows()>0){
			$prodi = $query->row();
			$where = array("id_prodi" => $prodi->id_prodi);
			$data['tbl_prodi'] = $this->m_general->view_by("tbl_prodi",$where);
			$data['err'] = "";
			$data['tbl_fakultas'] = $this->m_general->view_order("tbl_fakultas","nama_fakultas ASC");
			$data['tbl_fakultas_by'] = $this->m_general->view_by("tbl_fakultas", array("id_fakultas" => $data['tbl_prodi']->id_fakultas));
			$data['tbl_user'] = $this->m_general->view_order("tbl_user","nama_user ASC");
			$data['tbl_user1_by'] = $this->m_general->view_by("tbl_user",array("id_user" => $data['tbl_prodi']->id_user_kepala_prodi));
			$data['tbl_user2_by'] = $this->m_general->view_by("tbl_user",array("id_user" => $data['tbl_prodi']->id_user_admin_prodi));
			$this->load->view("v_adminprodi_profile",$data);
		}else{
			 $this->load->view("v_error_page");
		}
        $this->load->view("v_superadmin_footer");
	}
	
	public function profile_aksi_ubah($id_prodi)
    {
			$kode_prodi = $this->input->post('kode_prodi')[0];
			$kode_prodi_old = $this->input->post('kode_prodi')[1];
			$nama_prodi = $this->input->post('nama_prodi');
			$id_fakultas = $this->input->post('id_fakultas');
			$id_user_kepala_prodi = $this->input->post('id_user_kepala_prodi');
			$id_user_admin_prodi = $this->input->post('id_user_admin_prodi');
			$check_prodi = $this->m_general->countdata("tbl_prodi", array("kode_prodi" => $kode_prodi));
			
			if($kode_prodi!=$kode_prodi_old){
				$check_prodi = $this->m_general->countdata("tbl_prodi", array("kode_prodi" => $kode_prodi));
			}else{
				$check_prodi = 0;
			}
			
			if($check_prodi==0){
					$where['id_prodi'] = $id_prodi;
					$_POST['kode_prodi'] = $kode_prodi;
					$this->m_general->edit("tbl_prodi", $where, $_POST);
					redirect('adminprodi/profile/sukses');
			}else{
					$where = array("id_prodi" => $id_prodi);
					$data['tbl_prodi'] = $this->m_general->view_by("tbl_prodi",$where);
					$data['err'] = 1;
					$data['tbl_fakultas'] = $this->m_general->view_order("tbl_fakultas","nama_fakultas ASC");
					$data['tbl_fakultas_by'] = $this->m_general->view_by("tbl_fakultas", array("id_fakultas" => $id_fakultas));
					$data['tbl_user'] = $this->m_general->view_order("tbl_user","nama_user ASC");
					$data['tbl_user1_by'] = $this->m_general->view_by("tbl_user",array("id_user" => $id_user_kepala_prodi));
					$data['tbl_user2_by'] = $this->m_general->view_by("tbl_user",array("id_user" => $id_user_admin_prodi));
					$data['kode_prodi'] = $kode_prodi;
					$data['nama_prodi'] = $nama_prodi;
					$this->load->view("v_superadmin_header");
					$this->load->view("v_adminprodi_profile",$data);
					$this->load->view("v_superadmin_footer");
			}
    }	
	
	////////////////////////////////////
	
	////////////////////////////////////
	
	public function get_data_master_dosen()
	{		
		$id_user = $this->session->userdata("userid");
		$query = $this->db->query("select * from tbl_prodi where id_user_admin_prodi='$id_user' limit 1");
		if($query->num_rows()>0){
			$prodi = $query->row();
			$where = $prodi->id_prodi;
		}else{
			$where = "0";
		}
			
		$table = "
        (
            SELECT (@cnt := @cnt + 1) AS rowNumber,
                a.*, b.nama_prodi
            FROM
                tbl_user a
					 LEFT JOIN tbl_prodi b ON b.id_prodi=a.id_prodi
					 CROSS JOIN (SELECT @cnt := 0) AS dummy
			WHERE b.id_prodi='$where'
        )temp";
		
        $primaryKey = 'id_user';
        $columns = array(
        array( 'db' => 'rowNumber',     'dt' => 0 ),
        array( 'db' => 'nidn_user',     'dt' => 1 ),
        array( 'db' => 'nama_user',        'dt' => 2 ),
        array( 'db' => 'nama_prodi',       'dt' => 3 ),
        array( 'db' => 'notelp_user',       'dt' => 4 ),
        array( 'db' => 'email_user',       'dt' => 5 ),
        array( 'db' => 'level_user',       'dt' => 6 ),
        array( 'db' => 'id_user',       'dt' => 7 ),
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
	
	public function dosen()
    {
		$this->load->view("v_superadmin_header");
        $this->load->view("v_adminprodi_dosen");
        $this->load->view("v_superadmin_footer");
    }		
	public function dosen_tambah()
    {
		$data['err'] = "";
		$id_user = $this->session->userdata("userid");
		$query = $this->db->query("select * from tbl_prodi where id_user_admin_prodi='$id_user' limit 1");
		if($query->num_rows()>0){
			$prodi = $query->row();
			$where['id_prodi'] = $prodi->id_prodi;
		}else{
			$where['id_prodi'] = "0";
		}	
		$data['tbl_prodi'] = $this->m_general->view_by("tbl_prodi",$where);
		$this->load->view("v_superadmin_header");
        $this->load->view("v_adminprodi_dosen_add",$data);
		$this->load->view("v_superadmin_footer");
    }
	public function dosen_ubah($id_user)
	{
		$where2 = array("id_user" => $id_user);
		$data['tbl_user'] = $this->m_general->view_by("tbl_user",$where2);
		$data['err'] = "";
		$id_user = $this->session->userdata("userid");
		$query = $this->db->query("select * from tbl_prodi where id_user_admin_prodi='$id_user' limit 1");
		if($query->num_rows()>0){
			$prodi = $query->row();
			$where['id_prodi'] = $prodi->id_prodi;
		}else{
			$where['id_prodi'] = "0";
		}	
		$data['tbl_prodi'] = $this->m_general->view_by("tbl_prodi",$where);
		$this->load->view("v_superadmin_header");
		$this->load->view('v_adminprodi_dosen_edit', $data);
		$this->load->view("v_superadmin_footer");
	}	
	public function dosen_aksi_tambah()
    {
			$nidn_user = $this->input->post('nidn_user');
			$user_password = $this->input->post('user_password');
			$nama_user = $this->input->post('nama_user');
			$notelp_user = $this->input->post('notelp_user');
			$email_user = $this->input->post('email_user');
			$check_user = $this->m_general->countdata("tbl_user", array("nidn_user" => $nidn_user));
			if($check_user==0){
					$_POST['id_user'] = $this->m_general->bacaidterakhir("tbl_user", "id_user");
					$_POST['user_name'] = $nidn_user;
					$_POST['user_password'] = md5($user_password);
					
					$folder = "avatar";
					$file_upload = $_FILES['userfiles'];
					$files = $file_upload;
					
					if($files['name'] != "" OR $files['name'] != NULL){
						$_POST['foto_user'] = $this->m_general->file_upload($files, $folder);
					}else{
						$_POST['foto_user'] = "";
					}
					$this->m_general->add("tbl_user", $_POST);
					redirect('adminprodi/dosen');
			}else{
					$data['err'] = 1;
					$id_user = $this->session->userdata("userid");
					$query = $this->db->query("select * from tbl_prodi where id_user_admin_prodi='$id_user' limit 1");
					if($query->num_rows()>0){
						$prodi = $query->row();
						$where['id_prodi'] = $prodi->id_prodi;
					}else{
						$where['id_prodi'] = "0";
					}	
					$data['tbl_prodi'] = $this->m_general->view_by("tbl_prodi",$where);
					$data['nidn_user'] = $nidn_user;
					$data['user_password'] = $user_password;
					$data['nama_user'] = $nama_user;
					$data['notelp_user'] = $notelp_user;
					$data['email_user'] = $email_user;
					$this->load->view("v_superadmin_header");
					$this->load->view("v_adminprodi_dosen_add",$data);
					$this->load->view("v_superadmin_footer");
			}
    }	
	public function dosen_aksi_ubah($id_user)
    {
			$where['id_user'] = $id_user;
			$data['tbl_user'] = $this->m_general->view_by("tbl_user",$where);
			$tbl_user = $this->m_general->view_by("tbl_user",$where);
			$nidn_user = $this->input->post('nidn_user')[0];
			$nidn_user_old = $this->input->post('nidn_user')[1];
			$user_password = $this->input->post('user_password')[0];
			$user_password_old = $this->input->post('user_password')[1];
			
			$nama_user = $this->input->post('nama_user');
			$notelp_user = $this->input->post('notelp_user');
			$email_user = $this->input->post('email_user');
			$foto_user = $this->input->post('foto_user');
			
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
					redirect('adminprodi/dosen');
			}else{
					$data['err'] = 1;
					$data['nidn_user'] = $nidn_user;
					$data['user_password'] = $user_password;
					$data['nama_user'] = $nama_user;
					$data['notelp_user'] = $notelp_user;
					$data['email_user'] = $email_user;
					$id_user = $this->session->userdata("userid");
					$query = $this->db->query("select * from tbl_prodi where id_user_admin_prodi='$id_user' limit 1");
					if($query->num_rows()>0){
						$prodi = $query->row();
						$where['id_prodi'] = $prodi->id_prodi;
					}else{
						$where['id_prodi'] = "0";
					}	
					$data['tbl_prodi'] = $this->m_general->view_by("tbl_prodi",$where);
					$this->load->view("v_superadmin_header");
					$this->load->view("v_adminprodi_dosen_edit",$data);
					$this->load->view("v_superadmin_footer");
			}
    }	
	public function dosen_aksi_hapus($id_user){
			$where['id_user'] = $id_user;
			$tbl_user = $this->m_general->view_by("tbl_user", $where);
			$file = './assets/dist/img/avatar/'.$tbl_user->foto_user;
			if($tbl_user->foto_user!="default/user.png" && is_readable($file)){
				unlink($file);
			}
			$this->m_general->hapus("tbl_user", $where); // Panggil fungsi hapus() yang ada di m_general.php
			redirect('adminprodi/dosen');
	}
	
	////////////////////////////////////
	
	////////////////////////////////////
	
	public function get_data_master_kelasmahasiswa()
	{
		$id_user = $this->session->userdata("userid");
		$query = $this->db->query("select * from tbl_prodi where id_user_admin_prodi='$id_user' limit 1");
		if($query->num_rows()>0){
			$prodi = $query->row();
			$where = $prodi->id_prodi;
		}else{
			$where = "0";
		}
		
		$table = "
        (
            SELECT (@cnt := @cnt + 1) AS rowNumber,
                c.nama_fakultas, b.nama_prodi, a.periode_kelasmahasiswa, 
					 a.gg_kelasmahasiswa,
					@semester:= CASE
					 	WHEN a.semester_kelasmahasiswa='1' THEN 'I'
					 	WHEN a.semester_kelasmahasiswa='2' THEN 'II'
					 	WHEN a.semester_kelasmahasiswa='3' THEN 'III'
					 	WHEN a.semester_kelasmahasiswa='4' THEN 'IV'
					 	WHEN a.semester_kelasmahasiswa='5' THEN 'V'
					 	WHEN a.semester_kelasmahasiswa='6' THEN 'VI'						 
					END as semester, a.nomor_kelasmahasiswa, a.id_kelasmahasiswa, CONCAT(periode_kelasmahasiswa,' ',gg_kelasmahasiswa) as sem
				FROM
                tbl_kelasmahasiswa a 
         	LEFT JOIN tbl_prodi b ON b.id_prodi=a.id_prodi
				LEFT JOIN tbl_fakultas c ON c.id_fakultas=b.id_fakultas
				CROSS JOIN (SELECT @cnt := 0) AS dummy
				WHERE b.id_prodi='$where'
				order by a.periode_kelasmahasiswa ASC
        )temp";
		
        $primaryKey = 'id_kelasmahasiswa';
        $columns = array(
        array( 'db' => 'rowNumber',     'dt' => 0 ),
        array( 'db' => 'nama_fakultas',     'dt' => 1 ),
        array( 'db' => 'nama_prodi',     'dt' => 2 ),
        array( 'db' => 'sem',        'dt' => 3 ),
        array( 'db' => 'semester',       'dt' => 4 ),
        array( 'db' => 'nomor_kelasmahasiswa',       'dt' => 5 ),
        array( 'db' => 'id_kelasmahasiswa',       'dt' => 6 ),
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
	
	public function kelasmahasiswa_matakuliah()
    {
		$id_user = $this->session->userdata("userid");
		$query = $this->db->query("select * from tbl_prodi where id_user_admin_prodi='$id_user' limit 1");
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
		$query = $this->db->query("select * from tbl_prodi where id_user_admin_prodi='$id_user' limit 1");
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
	
	public function kelasmahasiswa_semester($id_kelasmahasiswa="")
    {
		if($id_kelasmahasiswa!=""){
			$where = array("id_kelasmahasiswa" => $id_kelasmahasiswa);
			$tbl_kelasmahasiswa = $this->m_general->view_by("tbl_kelasmahasiswa",$where);
			$sem = array("","I","II","III","IV","V","VI");
			$semester = $sem[$tbl_kelasmahasiswa->semester_kelasmahasiswa];
			echo "<option value='$tbl_kelasmahasiswa->semester_kelasmahasiswa'>$semester</option>";
		}
		
		$periode_kelasmahasiswa = $_POST['periode_kelasmahasiswa'];
		$gg = explode(" ",$periode_kelasmahasiswa);
		if($gg[1]=="Ganjil"){
			echo "<option value='1'>I</option>";
			echo "<option value='3'>III</option>";
			echo "<option value='5'>V</option>";
		}else if($gg[1]=="Genap"){
			echo "<option value='2'>II</option>";
			echo "<option value='4'>IV</option>";
			echo "<option value='6'>VI</option>";
		}
    }
	public function kelasmahasiswa()
    {
		$this->load->view("v_superadmin_header");
        $this->load->view("v_adminprodi_kelasmahasiswa");
        $this->load->view("v_superadmin_footer");
    }		
	public function kelasmahasiswa_tambah()
    {
		$data['err'] = "";
		$id_user = $this->session->userdata("userid");
		$query = $this->db->query("select * from tbl_prodi where id_user_admin_prodi='$id_user' limit 1");
		if($query->num_rows()>0){
			$prodi = $query->row();
			$where['id_prodi'] = $prodi->id_prodi;
		}else{
			$where['id_prodi'] = "0";
		}	
		$data['tbl_prodi'] = $this->m_general->view_by("tbl_prodi",$where);
		$this->load->view("v_superadmin_header");
        $this->load->view("v_adminprodi_kelasmahasiswa_add",$data);
		$this->load->view("v_superadmin_footer");
    }
	public function kelasmahasiswa_ubah($id_kelasmahasiswa)
	{
		$where = array("id_kelasmahasiswa" => $id_kelasmahasiswa);
		$data['tbl_kelasmahasiswa'] = $this->m_general->view_by("tbl_kelasmahasiswa",$where);
		$data['err'] = "";
		$this->load->view("v_superadmin_header");
		$this->load->view('v_adminprodi_kelasmahasiswa_edit', $data);
		$this->load->view("v_superadmin_footer");
	}	
	public function kelasmahasiswa_aksi_tambah()
    {
			$_POST['id_kelasmahasiswa'] = $this->m_general->bacaidterakhir("tbl_kelasmahasiswa", "id_kelasmahasiswa");
			$periode_kelasmahasiswa = $this->input->post('periode_kelasmahasiswa');
			$explode_periode_kelasmahasiswa = explode(" ",$periode_kelasmahasiswa);
			$_POST['periode_kelasmahasiswa'] = $explode_periode_kelasmahasiswa[0];
			$_POST['gg_kelasmahasiswa'] = $explode_periode_kelasmahasiswa[1];
			$this->m_general->add("tbl_kelasmahasiswa", $_POST);
			redirect('adminprodi/kelasmahasiswa');
    }	
	public function kelasmahasiswa_aksi_ubah($id_kelasmahasiswa)
    {
			$periode_kelasmahasiswa = $this->input->post('periode_kelasmahasiswa');
			$explode_periode_kelasmahasiswa = explode(" ",$periode_kelasmahasiswa);
			$_POST['periode_kelasmahasiswa'] = $explode_periode_kelasmahasiswa[0];
			$_POST['gg_kelasmahasiswa'] = $explode_periode_kelasmahasiswa[1];
					$where['id_kelasmahasiswa'] = $id_kelasmahasiswa;
					$this->m_general->edit("tbl_kelasmahasiswa", $where, $_POST);
					redirect('adminprodi/kelasmahasiswa');
    }	
	public function kelasmahasiswa_aksi_hapus($id_kelasmahasiswa){
			$where['id_kelasmahasiswa'] = $id_kelasmahasiswa;
			$this->m_general->hapus("tbl_kelasmahasiswa", $where); // Panggil fungsi hapus() yang ada di m_general.php
			redirect('adminprodi/kelasmahasiswa');
	}
	
	////////////////////////////////////
	
	////////////////////////////////////
	
	////////////////////////////////////
	
	////////////////////////////////////
	
	public function get_data_master_matakuliah()
	{
		$id_user = $this->session->userdata("userid");
		$query = $this->db->query("select * from tbl_prodi where id_user_admin_prodi='$id_user' limit 1");
		if($query->num_rows()>0){
			$prodi = $query->row();
			$where = $prodi->id_prodi;
		}else{
			$where = "0";
		}
		
		$table = "
        (
            SELECT (@cnt := @cnt + 1) AS rowNumber,
                a.*, b.nama_prodi
            FROM
                tbl_matakuliah a 
				LEFT JOIN tbl_prodi b ON a.id_prodi=b.id_prodi
				CROSS JOIN (SELECT @cnt := 0) AS dummy
				WHERE b.id_prodi='$where'
				order by nama_matakuliah ASC
        )temp";
		
        $primaryKey = 'id_matakuliah';
        $columns = array(
        array( 'db' => 'rowNumber',     'dt' => 0 ),
        array( 'db' => 'nama_prodi',     'dt' => 1 ),
        array( 'db' => 'kode_matakuliah',     'dt' => 2 ),
        array( 'db' => 'nama_matakuliah',     'dt' => 3 ),
        array( 'db' => 'totalsks_matakuliah',        'dt' => 4 ),
        array( 'db' => 'id_matakuliah',       'dt' => 5 ),
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
	
	public function matakuliah()
    {
		$this->load->view("v_superadmin_header");
        $this->load->view("v_adminprodi_matakuliah");
        $this->load->view("v_superadmin_footer");
    }		
	public function matakuliah_tambah()
    {
		$data['err'] = "";
		$id_user = $this->session->userdata("userid");
		$query = $this->db->query("select * from tbl_prodi where id_user_admin_prodi='$id_user' limit 1");
		if($query->num_rows()>0){
			$prodi = $query->row();
			$where['id_prodi'] = $prodi->id_prodi;
		}else{
			$where['id_prodi'] = "0";
		}	
		$data['tbl_prodi'] = $this->m_general->view_by("tbl_prodi",$where);
		$this->load->view("v_superadmin_header");
        $this->load->view("v_adminprodi_matakuliah_add",$data);
		$this->load->view("v_superadmin_footer");
    }
	public function matakuliah_ubah($id_matakuliah)
	{
		$where2 = array("id_matakuliah" => $id_matakuliah);
		$data['tbl_matakuliah'] = $this->m_general->view_by("tbl_matakuliah",$where2);
		$data['err'] = "";
		$id_user = $this->session->userdata("userid");
		$query = $this->db->query("select * from tbl_prodi where id_user_admin_prodi='$id_user' limit 1");
		if($query->num_rows()>0){
			$prodi = $query->row();
			$where['id_prodi'] = $prodi->id_prodi;
		}else{
			$where['id_prodi'] = "0";
		}	
		$data['tbl_prodi'] = $this->m_general->view_by("tbl_prodi",$where);
		$this->load->view("v_superadmin_header");
		$this->load->view('v_adminprodi_matakuliah_edit', $data);
		$this->load->view("v_superadmin_footer");
	}	
	public function matakuliah_aksi_tambah()
    {
			$kode_matakuliah = $this->input->post('kode_matakuliah');
			$nama_matakuliah = $this->input->post('nama_matakuliah');
			$totalsks_matakuliah = $this->input->post('totalsks_matakuliah');
			$check_matakuliah = $this->m_general->countdata("tbl_matakuliah", array("kode_matakuliah" => $kode_matakuliah));
			if($check_matakuliah==0){
					$_POST['id_matakuliah'] = $this->m_general->bacaidterakhir("tbl_matakuliah", "id_matakuliah");
					$this->m_general->add("tbl_matakuliah", $_POST);
					redirect('adminprodi/matakuliah');
			}else{
					$data['err'] = 1;
					$id_user = $this->session->userdata("userid");
					$query = $this->db->query("select * from tbl_prodi where id_user_admin_prodi='$id_user' limit 1");
					if($query->num_rows()>0){
						$prodi = $query->row();
						$where['id_prodi'] = $prodi->id_prodi;
					}else{
						$where['id_prodi'] = "0";
					}	
					$data['tbl_prodi'] = $this->m_general->view_by("tbl_prodi",$where);
					$data['kode_matakuliah'] = $kode_matakuliah;
					$data['nama_matakuliah'] = $nama_matakuliah;
					$data['totalsks_matakuliah'] = $totalsks_matakuliah;
					$this->load->view("v_superadmin_header");
					$this->load->view("v_adminprodi_matakuliah_add",$data);
					$this->load->view("v_superadmin_footer");
			}
    }	
	public function matakuliah_aksi_ubah($id_matakuliah)
    {
			$kode_matakuliah = $this->input->post('kode_matakuliah')[0];
			$kode_matakuliah_old = $this->input->post('kode_matakuliah')[1];
			$nama_matakuliah = $this->input->post('nama_matakuliah');
			$totalsks_matakuliah = $this->input->post('totalsks_matakuliah');
			$check_matakuliah = $this->m_general->countdata("tbl_matakuliah", array("kode_matakuliah" => $kode_matakuliah));
			
			if($kode_matakuliah!=$kode_matakuliah_old){
				$check_matakuliah = $this->m_general->countdata("tbl_matakuliah", array("kode_matakuliah" => $kode_matakuliah));
			}else{
				$check_matakuliah = 0;
			}
			
			if($check_matakuliah==0){
					$where['id_matakuliah'] = $id_matakuliah;
					$_POST['kode_matakuliah'] = $kode_matakuliah;
					$this->m_general->edit("tbl_matakuliah", $where, $_POST);
					redirect('adminprodi/matakuliah');
			}else{
					$where = array("id_matakuliah" => $id_matakuliah);
					$data['tbl_matakuliah'] = $this->m_general->view_by("tbl_matakuliah",$where);
					$data['err'] = 1;
					$data['kode_matakuliah'] = $kode_matakuliah;
					$data['nama_matakuliah'] = $nama_matakuliah;
					$data['totalsks_matakuliah'] = $totalsks_matakuliah;
					$this->load->view("v_superadmin_header");
					$this->load->view("v_adminprodi_matakuliah_edit",$data);
					$this->load->view("v_superadmin_footer");
			}
    }	
	public function matakuliah_aksi_hapus($id_matakuliah){
			$where['id_matakuliah'] = $id_matakuliah;
			$this->m_general->hapus("tbl_matakuliah", $where); // Panggil fungsi hapus() yang ada di m_general.php
			redirect('adminprodi/matakuliah');
	}
	
	////////////////////////////////////
	
	////////////////////////////////////
	
	////////////////////////////////////
	
	////////////////////////////////////
	
	public function get_data_master_soal()
	{		
		$id_user = $this->session->userdata("userid");
		$query = $this->db->query("select * from tbl_prodi where id_user_admin_prodi='$id_user' limit 1");
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
					END as sifatujian, a.id_soal, a.tipe_soal
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
		$this->load->view("v_superadmin_header");
        $this->load->view("v_adminprodi_soal");
        $this->load->view("v_superadmin_footer");
    }		
	public function soal_tambah()
    {
		$data['err'] = "";
		$id_user = $this->session->userdata("userid");
		$query = $this->db->query("select * from tbl_prodi where id_user_admin_prodi='$id_user' limit 1");
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
		$data['tbl_user'] = $this->m_general->view_order("tbl_user","nama_user ASC");
		$this->load->view("v_superadmin_header");
        $this->load->view("v_adminprodi_soal_add",$data);
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
		$this->load->view('v_adminprodi_soal_edit', $data);
		$this->load->view("v_superadmin_footer");
	}	
	public function soal_aksi_tambah()
    {
			$_POST['id_soal'] = $this->m_general->bacaidterakhir("tbl_soal", "id_soal");
			$this->m_general->add("tbl_soal", $_POST);
			redirect('adminprodi/soal');
	}				
	public function soal_aksi_ubah($id_soal)
    {
			$where['id_soal'] = $id_soal;
			$this->m_general->edit("tbl_soal", $where, $_POST);
			redirect('adminprodi/soal');		
    }	
	public function soal_aksi_hapus($id_soal){
			$where['id_soal'] = $id_soal;
			$this->m_general->hapus("tbl_soal", $where); // Panggil fungsi hapus() yang ada di m_general.php
			redirect('adminprodi/soal');
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