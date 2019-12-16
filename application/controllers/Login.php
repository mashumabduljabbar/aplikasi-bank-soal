<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	function __construct()
	{
		parent::__construct();		
		$this->load->model('m_general');
		date_default_timezone_set("Asia/Bangkok");
	}	
	
	public function index()
	{
		$data['hasillogin'] = "";
		$this->load->view('v_login_index',$data);
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect(base_url('login'));
	}
	
	function aksi_login(){
		$user_name = $this->input->post('user_name');
		$user_password = md5($this->input->post('user_password'));
		$where = array(
			'user_name' => $user_name,
			'user_password' => $user_password
			);
		$checking = $this->m_general->check_login('tbl_user', array('user_name' => $user_name), array('user_password' => $user_password));
		
		if($checking > 0){
			foreach ($checking as $apps) {
				$data_session = array(
					'userid' => $apps->id_user,
					'user_name' => $apps->user_name,
					'level' => $apps->level_user,
					'status' => "login"
					);
	 
				$this->session->set_userdata($data_session);
				
				if($apps->level_user=="superadmin"){
					redirect(base_url("superadmin"));
				}elseif($apps->level_user=="adminprodi"){
					redirect(base_url("adminprodi"));
				}elseif($apps->level_user=="nonadmin"){
					redirect(base_url("nonadmin"));
				}else{
					$data['hasillogin'] = "<i style='color:red;'>Login Gagal !</i>";
					$this->load->view('v_login_index', $data);
				}
			}
		}else{
			$data['hasillogin'] = "<i style='color:red;'>Username dan password salah !</i>";
			$this->load->view('v_login_index' , $data);
		}
	}
 
}
