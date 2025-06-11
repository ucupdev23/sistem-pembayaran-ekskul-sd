<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function login_admin($username, $password)
	{
		$this->db->where('username', $username);
		$query = $this->db->get('users');
		$user = $query->row();

		if ($user) {
			if (password_verify($password, $user->password)) {
				return $user;
			}
		}
		return false;
	}

	public function login_siswa($nisn, $password)
	{
		$this->db->where('nisn', $nisn);
		$query = $this->db->get('siswa');
		$siswa = $query->row();

		if ($siswa) {
			if (password_verify($password, $siswa->password)) {
				return $siswa;
			}
		}
		return false;
	}
}
