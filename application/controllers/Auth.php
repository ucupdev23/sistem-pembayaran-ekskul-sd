<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Auth_model');
		$this->load->library('form_validation');
		$this->load->helper('url');
	}

	public function index()
	{
		if ($this->session->userdata('logged_in')) {
			if ($this->session->userdata('role') == 'super_admin' || $this->session->userdata('role') == 'admin') {
				redirect('admin/dashboard');
			} elseif ($this->session->userdata('role') == 'siswa') {
				redirect('siswa/dashboard');
			}
		}
		$this->load->view('auth/login');
	}

	public function process_login()
	{
		$this->form_validation->set_rules('username', 'Username/NISN', 'required|trim');
		$this->form_validation->set_rules('password', 'Password', 'required');

		if ($this->form_validation->run() == FALSE) {
			$this->load->view('auth/login');
		} else {
			$username = $this->input->post('username');
			$password = $this->input->post('password');

			$user = $this->Auth_model->login_admin($username, $password);

			if ($user) {
				$session_data = array(
					'id_user'   => $user->id_user,
					'username'  => $user->username,
					'nama'      => $user->nama,
					'role'      => $user->role,
					'logged_in' => TRUE
				);
				$this->session->set_userdata($session_data);

				if ($user->role == 'super_admin' || $user->role == 'admin') {
					redirect('admin/dashboard');
				}
			} else {
				$siswa = $this->Auth_model->login_siswa($username, $password);

				if ($siswa) {
					$session_data = array(
						'id_siswa'  => $siswa->id_siswa,
						'nisn'      => $siswa->nisn,
						'nama_siswa' => $siswa->nama_siswa,
						'id_kelas'  => $siswa->id_kelas,
						'role'      => 'siswa',
						'logged_in' => TRUE
					);
					$this->session->set_userdata($session_data);
					redirect('siswa/dashboard');
				} else {
					$this->session->set_flashdata('error', 'Username/NISN atau Password salah!');
					redirect('auth');
				}
			}
		}
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect('auth');
	}
}
