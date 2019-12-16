<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include APPPATH . 'third_party/ssp.php';
class Superadmin extends CI_Controller {
	public function __construct(){
		parent::__construct();
		if($this->session->userdata('status') != "login" or $this->session->userdata('level') != "superadmin"){
			redirect(base_url("login"));
		}
		$this->load->model('m_general');
	}
	
	////////////////////////////////////
	
	public function index()
    {
		$this->load->view("v_superadmin_header");
        $this->load->view("v_superadmin_index");
        $this->load->view("v_superadmin_footer");
    }
	
	
	////////////////////////////////////
	
	////////////////////////////////////
	
	public function get_data_master_fakultas()
	{
		$table = "
        (
            SELECT (@cnt := @cnt + 1) AS rowNumber,
                tbl_fakultas.*
            FROM
                tbl_fakultas CROSS JOIN (SELECT @cnt := 0) AS dummy
				order by nama_fakultas ASC
        )temp";
		
        $primaryKey = 'id_fakultas';
        $columns = array(
        array( 'db' => 'rowNumber',     'dt' => 0 ),
        array( 'db' => 'nama_fakultas',     'dt' => 1 ),
        array( 'db' => 'alamat_fakultas',        'dt' => 2 ),
        array( 'db' => 'notelp_fakultas',       'dt' => 3 ),
        array( 'db' => 'email_fakultas',       'dt' => 4 ),
        array( 'db' => 'id_fakultas',       'dt' => 5 ),
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
	
	public function fakultas()
    {
		$this->load->view("v_superadmin_header");
        $this->load->view("v_superadmin_fakultas");
        $this->load->view("v_superadmin_footer");
    }		
	public function fakultas_tambah()
    {
		$data['err'] = "";
		$this->load->view("v_superadmin_header");
        $this->load->view("v_superadmin_fakultas_add",$data);
		$this->load->view("v_superadmin_footer");
    }
	public function fakultas_ubah($id_fakultas)
	{
		$where = array("id_fakultas" => $id_fakultas);
		$data['tbl_fakultas'] = $this->m_general->view_by("tbl_fakultas",$where);
		$data['err'] = "";
		$this->load->view("v_superadmin_header");
		$this->load->view('v_superadmin_fakultas_edit', $data);
		$this->load->view("v_superadmin_footer");
	}	
	public function fakultas_aksi_tambah()
    {
			$nama_fakultas = $this->input->post('nama_fakultas');
			$alamat_fakultas = $this->input->post('alamat_fakultas');
			$notelp_fakultas = $this->input->post('notelp_fakultas');
			$email_fakultas = $this->input->post('email_fakultas');
			$check_fakultas = $this->m_general->countdata("tbl_fakultas", array("nama_fakultas" => $nama_fakultas));
			if($check_fakultas==0){
					$_POST['id_fakultas'] = $this->m_general->bacaidterakhir("tbl_fakultas", "id_fakultas");
					$this->m_general->add("tbl_fakultas", $_POST);
					redirect('superadmin/fakultas');
			}else{
					$data['err'] = 1;
					$data['nama_fakultas'] = $nama_fakultas;
					$data['alamat_fakultas'] = $alamat_fakultas;
					$data['notelp_fakultas'] = $notelp_fakultas;
					$data['email_fakultas'] = $email_fakultas;
					$this->load->view("v_superadmin_header");
					$this->load->view("v_superadmin_fakultas_add",$data);
					$this->load->view("v_superadmin_footer");
			}
    }	
	public function fakultas_aksi_ubah($id_fakultas)
    {
			$nama_fakultas = $this->input->post('nama_fakultas')[0];
			$nama_fakultas_old = $this->input->post('nama_fakultas')[1];
			$alamat_fakultas = $this->input->post('alamat_fakultas');
			$notelp_fakultas = $this->input->post('notelp_fakultas');
			$email_fakultas = $this->input->post('email_fakultas');
			
			if($nama_fakultas!=$nama_fakultas_old){
				$check_fakultas = $this->m_general->countdata("tbl_fakultas", array("nama_fakultas" => $nama_fakultas));
			}else{
				$check_fakultas = 0;
			}
			
			if($check_fakultas==0){
					$where['id_fakultas'] = $id_fakultas;
					$_POST['nama_fakultas'] = $nama_fakultas;
					$this->m_general->edit("tbl_fakultas", $where, $_POST);
					redirect('superadmin/fakultas');
			}else{
					$where = array("id_fakultas" => $id_fakultas);
					$data['tbl_fakultas'] = $this->m_general->view_by("tbl_fakultas",$where);
					$data['err'] = 1;
					$data['nama_fakultas'] = $nama_fakultas;
					$data['alamat_fakultas'] = $alamat_fakultas;
					$data['notelp_fakultas'] = $notelp_fakultas;
					$data['email_fakultas'] = $email_fakultas;
					$this->load->view("v_superadmin_header");
					$this->load->view('v_superadmin_fakultas_edit', $data);
					$this->load->view("v_superadmin_footer");
			}
    }	
	public function fakultas_aksi_hapus($id_fakultas){
			$where['id_fakultas'] = $id_fakultas;
			$this->m_general->hapus("tbl_fakultas", $where); // Panggil fungsi hapus() yang ada di m_general.php
			redirect('superadmin/fakultas');
	}
	
	////////////////////////////////////
	
	////////////////////////////////////
	
	public function get_data_master_prodi()
	{
		$table = "
        (
            SELECT (@cnt := @cnt + 1) AS rowNumber,
                a.*, b.nama_fakultas, c.nama_user as nama_ka_prodi, c.notelp_user as hp_ka_prodi, d.nama_user as nama_admin_prodi
            FROM
                tbl_prodi a 
				LEFT JOIN tbl_fakultas b ON a.id_fakultas=b.id_fakultas
				LEFT JOIN tbl_user c ON a.id_user_kepala_prodi=c.id_user
				LEFT JOIN tbl_user d ON a.id_user_admin_prodi=d.id_user
				CROSS JOIN (SELECT @cnt := 0) AS dummy
				order by nama_prodi ASC
        )temp";
		
        $primaryKey = 'id_prodi';
        $columns = array(
        array( 'db' => 'rowNumber',     'dt' => 0 ),
        array( 'db' => 'kode_prodi',     'dt' => 1 ),
        array( 'db' => 'nama_prodi',     'dt' => 2 ),
        array( 'db' => 'nama_ka_prodi',        'dt' => 3 ),
        array( 'db' => 'hp_ka_prodi',       'dt' => 4 ),
        array( 'db' => 'nama_admin_prodi',       'dt' => 5 ),
        array( 'db' => 'nama_fakultas',       'dt' => 6 ),
        array( 'db' => 'id_prodi',       'dt' => 7 ),
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
	
	public function prodi()
    {
		$this->load->view("v_superadmin_header");
        $this->load->view("v_superadmin_prodi");
        $this->load->view("v_superadmin_footer");
    }		
	public function prodi_tambah()
    {
		$data['err'] = "";
		$data['tbl_fakultas'] = $this->m_general->view_order("tbl_fakultas","nama_fakultas ASC");
		$data['tbl_user'] = $this->m_general->view_order("tbl_user","nama_user ASC");
		$this->load->view("v_superadmin_header");
        $this->load->view("v_superadmin_prodi_add",$data);
		$this->load->view("v_superadmin_footer");
    }
	public function prodi_ubah($id_prodi)
	{
		$where = array("id_prodi" => $id_prodi);
		$data['tbl_prodi'] = $this->m_general->view_by("tbl_prodi",$where);
		$data['err'] = "";
		$data['tbl_fakultas'] = $this->m_general->view_order("tbl_fakultas","nama_fakultas ASC");
		$data['tbl_fakultas_by'] = $this->m_general->view_by("tbl_fakultas", array("id_fakultas" => $data['tbl_prodi']->id_fakultas));
		$data['tbl_user'] = $this->m_general->view_order("tbl_user","nama_user ASC");
		$data['tbl_user1_by'] = $this->m_general->view_by("tbl_user",array("id_user" => $data['tbl_prodi']->id_user_kepala_prodi));
		$data['tbl_user2_by'] = $this->m_general->view_by("tbl_user",array("id_user" => $data['tbl_prodi']->id_user_admin_prodi));
		$this->load->view("v_superadmin_header");
		$this->load->view('v_superadmin_prodi_edit', $data);
		$this->load->view("v_superadmin_footer");
	}	
	public function prodi_aksi_tambah()
    {
			$kode_prodi = $this->input->post('kode_prodi');
			$nama_prodi = $this->input->post('nama_prodi');
			$check_prodi = $this->m_general->countdata("tbl_prodi", array("kode_prodi" => $kode_prodi));
			if($check_prodi==0){
					$_POST['id_prodi'] = $this->m_general->bacaidterakhir("tbl_prodi", "id_prodi");
					$this->m_general->add("tbl_prodi", $_POST);
					redirect('superadmin/prodi');
			}else{
					$data['err'] = 1;
					$data['tbl_fakultas'] = $this->m_general->view_order("tbl_fakultas","nama_fakultas ASC");
					$data['tbl_user'] = $this->m_general->view_order("tbl_user","nama_user ASC");
					$data['kode_prodi'] = $kode_prodi;
					$data['nama_prodi'] = $nama_prodi;
					$this->load->view("v_superadmin_header");
					$this->load->view("v_superadmin_prodi_add",$data);
					$this->load->view("v_superadmin_footer");
			}
    }	
	public function prodi_aksi_ubah($id_prodi)
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
					redirect('superadmin/prodi');
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
					$this->load->view("v_superadmin_prodi_edit",$data);
					$this->load->view("v_superadmin_footer");
			}
    }	
	public function prodi_aksi_hapus($id_prodi){
			$where['id_prodi'] = $id_prodi;
			$this->m_general->hapus("tbl_prodi", $where); // Panggil fungsi hapus() yang ada di m_general.php
			redirect('superadmin/prodi');
	}
	
	////////////////////////////////////
	
	////////////////////////////////////
	
	public function get_data_master_dosen($sortir = "")
	{		
		$table = "
        (
            SELECT (@cnt := @cnt + 1) AS rowNumber,
                a.*, b.nama_prodi
            FROM
                tbl_user a
					 LEFT JOIN tbl_prodi b ON b.id_prodi=a.id_prodi
					 CROSS JOIN (SELECT @cnt := 0) AS dummy
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
        $this->load->view("v_superadmin_dosen");
        $this->load->view("v_superadmin_footer");
    }		
	public function dosen_tambah()
    {
		$data['err'] = "";
		$data['tbl_prodi'] = $this->m_general->view_order("tbl_prodi","nama_prodi ASC");
		$this->load->view("v_superadmin_header");
        $this->load->view("v_superadmin_dosen_add",$data);
		$this->load->view("v_superadmin_footer");
    }
	public function dosen_ubah($id_user)
	{
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
		$this->load->view('v_superadmin_dosen_edit', $data);
		$this->load->view("v_superadmin_footer");
	}	
	public function dosen_aksi_tambah()
    {
			$nidn_user = $this->input->post('nidn_user');
			$user_password = $this->input->post('user_password');
			$nama_user = $this->input->post('nama_user');
			$notelp_user = $this->input->post('notelp_user');
			$email_user = $this->input->post('email_user');
			$level_user = $this->input->post('level_user');
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
					redirect('superadmin/dosen');
			}else{
					$data['err'] = 1;
					$data['tbl_prodi'] = $this->m_general->view_order("tbl_prodi","nama_prodi ASC");
					$data['nidn_user'] = $nidn_user;
					$data['user_password'] = $user_password;
					$data['nama_user'] = $nama_user;
					$data['notelp_user'] = $notelp_user;
					$data['email_user'] = $email_user;
					$data['level_user'] = $level_user;
					$this->load->view("v_superadmin_header");
					$this->load->view("v_superadmin_dosen_add",$data);
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
					redirect('superadmin/dosen');
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
					$this->load->view("v_superadmin_dosen_edit",$data);
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
			redirect('superadmin/dosen');
	}
	
	////////////////////////////////////
	
	////////////////////////////////////
	
	public function get_data_master_kelasmahasiswa()
	{
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
	
	public function kelasmahasiswa_prodi()
    {
		$id_fakultas = $_POST['id_fakultas'];
		$tbl_prodi = $this->m_general->view_where("tbl_prodi", array("id_fakultas" => $id_fakultas), "nama_prodi ASC");
		foreach($tbl_prodi as $prodi){
			echo "<option value='$prodi->id_prodi'>$prodi->nama_prodi</option>";
		}
    }
	public function kelasmahasiswa_semester()
    {
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
        $this->load->view("v_superadmin_kelasmahasiswa");
        $this->load->view("v_superadmin_footer");
    }		
	public function kelasmahasiswa_tambah()
    {
		$data['err'] = "";
		$data['tbl_user'] = $this->m_general->view_order("tbl_user","nama_user ASC");
		$data['tbl_fakultas'] = $this->m_general->view_order("tbl_fakultas","nama_fakultas ASC");
		$this->load->view("v_superadmin_header");
        $this->load->view("v_superadmin_kelasmahasiswa_add",$data);
		$this->load->view("v_superadmin_footer");
    }
	public function kelasmahasiswa_ubah($id_kelasmahasiswa)
	{
		$where = array("id_kelasmahasiswa" => $id_kelasmahasiswa);
		$data['tbl_kelasmahasiswa'] = $this->m_general->view_by("tbl_kelasmahasiswa",$where);
		$data['err'] = "";
		$data['tbl_prodi'] = $this->m_general->view_order("tbl_prodi","nama_prodi ASC");
		$data['tbl_prodi_by'] = $this->m_general->view_by("tbl_prodi", array("id_prodi" => $data['tbl_kelasmahasiswa']->id_prodi));
		$this->load->view("v_superadmin_header");
		$this->load->view('v_superadmin_kelasmahasiswa_edit', $data);
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
			redirect('superadmin/kelasmahasiswa');
    }	
	public function kelasmahasiswa_aksi_ubah($id_kelasmahasiswa)
    {
			$periode_kelasmahasiswa = $this->input->post('periode_kelasmahasiswa');
			$explode_periode_kelasmahasiswa = explode(" ",$periode_kelasmahasiswa);
			$_POST['periode_kelasmahasiswa'] = $explode_periode_kelasmahasiswa[0];
			$_POST['gg_kelasmahasiswa'] = $explode_periode_kelasmahasiswa[1];
					$where['id_kelasmahasiswa'] = $id_kelasmahasiswa;
					$this->m_general->edit("tbl_kelasmahasiswa", $where, $_POST);
					redirect('superadmin/kelasmahasiswa');
    }	
	public function kelasmahasiswa_aksi_hapus($id_kelasmahasiswa){
			$where['id_kelasmahasiswa'] = $id_kelasmahasiswa;
			$this->m_general->hapus("tbl_kelasmahasiswa", $where); // Panggil fungsi hapus() yang ada di m_general.php
			redirect('superadmin/kelasmahasiswa');
	}
	
	////////////////////////////////////
	
	////////////////////////////////////
	
	////////////////////////////////////
	
	////////////////////////////////////
	
	public function get_data_master_matakuliah()
	{
		$table = "
        (
            SELECT (@cnt := @cnt + 1) AS rowNumber,
                a.*, b.nama_prodi
            FROM
                tbl_matakuliah a 
				LEFT JOIN tbl_prodi b ON a.id_prodi=b.id_prodi
				CROSS JOIN (SELECT @cnt := 0) AS dummy
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
        $this->load->view("v_superadmin_matakuliah");
        $this->load->view("v_superadmin_footer");
    }		
	public function matakuliah_tambah()
    {
		$data['err'] = "";
		$data['tbl_prodi'] = $this->m_general->view_order("tbl_prodi","nama_prodi ASC");
		$data['tbl_user'] = $this->m_general->view_order("tbl_user","nama_user ASC");
		$this->load->view("v_superadmin_header");
        $this->load->view("v_superadmin_matakuliah_add",$data);
		$this->load->view("v_superadmin_footer");
    }
	public function matakuliah_ubah($id_matakuliah)
	{
		$where = array("id_matakuliah" => $id_matakuliah);
		$data['tbl_matakuliah'] = $this->m_general->view_by("tbl_matakuliah",$where);
		$data['err'] = "";
		$data['tbl_prodi'] = $this->m_general->view_order("tbl_prodi","nama_prodi ASC");
		$data['tbl_prodi_by'] = $this->m_general->view_by("tbl_prodi", array("id_prodi" => $data['tbl_matakuliah']->id_prodi));
		$this->load->view("v_superadmin_header");
		$this->load->view('v_superadmin_matakuliah_edit', $data);
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
					redirect('superadmin/matakuliah');
			}else{
					$data['err'] = 1;
					$data['tbl_prodi'] = $this->m_general->view_order("tbl_prodi","nama_prodi ASC");
					$data['kode_matakuliah'] = $kode_matakuliah;
					$data['nama_matakuliah'] = $nama_matakuliah;
					$data['totalsks_matakuliah'] = $totalsks_matakuliah;
					$this->load->view("v_superadmin_header");
					$this->load->view("v_superadmin_matakuliah_add",$data);
					$this->load->view("v_superadmin_footer");
			}
    }	
	public function matakuliah_aksi_ubah($id_matakuliah)
    {
			$kode_matakuliah = $this->input->post('kode_matakuliah')[0];
			$kode_matakuliah_old = $this->input->post('kode_matakuliah')[1];
			$nama_matakuliah = $this->input->post('nama_matakuliah');
			$totalsks_matakuliah = $this->input->post('totalsks_matakuliah');
			$id_prodi = $this->input->post('id_prodi');
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
					redirect('superadmin/matakuliah');
			}else{
					$where = array("id_matakuliah" => $id_matakuliah);
					$data['tbl_matakuliah'] = $this->m_general->view_by("tbl_matakuliah",$where);
					$data['err'] = 1;
					$data['tbl_prodi'] = $this->m_general->view_order("tbl_prodi","nama_prodi ASC");
					$data['tbl_prodi_by'] = $this->m_general->view_by("tbl_prodi", array("id_prodi" => $id_prodi));
					$data['kode_matakuliah'] = $kode_matakuliah;
					$data['nama_matakuliah'] = $nama_matakuliah;
					$data['totalsks_matakuliah'] = $totalsks_matakuliah;
					$this->load->view("v_superadmin_header");
					$this->load->view("v_superadmin_matakuliah_edit",$data);
					$this->load->view("v_superadmin_footer");
			}
    }	
	public function matakuliah_aksi_hapus($id_matakuliah){
			$where['id_matakuliah'] = $id_matakuliah;
			$this->m_general->hapus("tbl_matakuliah", $where); // Panggil fungsi hapus() yang ada di m_general.php
			redirect('superadmin/matakuliah');
	}
	
	////////////////////////////////////
	
	////////////////////////////////////
	
	////////////////////////////////////
	
	////////////////////////////////////
	
	public function get_data_master_formatsoal()
	{		
		$table = "
        (
            SELECT (@cnt := @cnt + 1) AS rowNumber,
                a.*, b.nama_prodi
            FROM
                tbl_formatsoal a
					 LEFT JOIN tbl_prodi b ON b.id_prodi=a.id_prodi
					 CROSS JOIN (SELECT @cnt := 0) AS dummy
        )temp";
		
        $primaryKey = 'id_formatsoal';
        $columns = array(
        array( 'db' => 'rowNumber',     'dt' => 0 ),
        array( 'db' => 'nama_prodi',     'dt' => 1 ),
        array( 'db' => 'kopsurat_formatsoal',        'dt' => 2 ),
        array( 'db' => 'petunjukujian_formatsoal',       'dt' => 3 ),
        array( 'db' => 'id_formatsoal',       'dt' => 4 ),
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
	
	public function formatsoal()
    {
		$this->load->view("v_superadmin_header");
        $this->load->view("v_superadmin_formatsoal");
        $this->load->view("v_superadmin_footer");
    }		
	public function formatsoal_tambah()
    {
		$data['err'] = "";
		$data['tbl_prodi'] = $this->m_general->view_order("tbl_prodi","nama_prodi ASC");
		$this->load->view("v_superadmin_header");
        $this->load->view("v_superadmin_formatsoal_add",$data);
		$this->load->view("v_superadmin_footer");
    }
	public function formatsoal_ubah($id_formatsoal)
	{
		$where = array("id_formatsoal" => $id_formatsoal);
		$data['tbl_formatsoal'] = $this->m_general->view_by("tbl_formatsoal",$where);
		$tbl_prodi_by= $this->m_general->view_by("tbl_prodi",array("id_prodi" => $data['tbl_formatsoal']->id_prodi));
		$data['nama_prodi'] = $tbl_prodi_by->nama_prodi;
		$data['id_prodi'] = $tbl_prodi_by->id_prodi;
		$data['err'] = "";
		$data['tbl_prodi'] = $this->m_general->view_order("tbl_prodi","nama_prodi ASC");
		$this->load->view("v_superadmin_header");
		$this->load->view('v_superadmin_formatsoal_edit', $data);
		$this->load->view("v_superadmin_footer");
	}	
	public function formatsoal_aksi_tambah()
    {
					$_POST['id_formatsoal'] = $this->m_general->bacaidterakhir("tbl_formatsoal", "id_formatsoal");
					$folder = "kop";
					$file_upload = $_FILES['userfiles'];
					$files = $file_upload;
					
					if($files['name'] != "" OR $files['name'] != NULL){
						$_POST['kopsurat_formatsoal'] = $this->m_general->file_upload($files, $folder);
					}else{
						$_POST['kopsurat_formatsoal'] = "";
					}
					$this->m_general->add("tbl_formatsoal", $_POST);
					redirect('superadmin/formatsoal');
	}				
	public function formatsoal_aksi_ubah($id_formatsoal)
    {
			$where['id_formatsoal'] = $id_formatsoal;
			$tbl_formatsoal = $this->m_general->view_by("tbl_formatsoal",$where);
			$folder = "kop";
			$file_upload = $_FILES['userfiles'];
			$files = $file_upload;
					
			if($files['name'] != "" OR $files['name'] != NULL){
						$file = './assets/dist/img/kop/'.$tbl_formatsoal->kopsurat_formatsoal;
						if($tbl_formatsoal->kopsurat_formatsoal!="default/formatsoal.png" && is_readable($file)){
							unlink($file);
						}
						$_POST['kopsurat_formatsoal'] = $this->m_general->file_upload($files, $folder);
			}else{
						$_POST['kopsurat_formatsoal'] = $kopsurat_formatsoal;
			}
			$this->m_general->edit("tbl_formatsoal", $where, $_POST);
			redirect('superadmin/formatsoal');		
    }	
	public function formatsoal_aksi_hapus($id_formatsoal){
			$where['id_formatsoal'] = $id_formatsoal;
			$tbl_formatsoal = $this->m_general->view_by("tbl_formatsoal", $where);
			$file = './assets/dist/img/kop/'.$tbl_formatsoal->kopsurat_formatsoal;
			if($tbl_formatsoal->kopsurat_formatsoal!="default/formatsoal.png" && is_readable($file)){
				unlink($file);
			}
			$this->m_general->hapus("tbl_formatsoal", $where); // Panggil fungsi hapus() yang ada di m_general.php
			redirect('superadmin/formatsoal');
	}
	
	////////////////////////////////////
	
	////////////////////////////////////
}