<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function get_all_users()
	{
		$this->db->order_by('nama', 'ASC');
		return $this->db->get('users')->result();
	}

	public function get_user_by_id($id_user)
	{
		$this->db->where('id_user', $id_user);
		return $this->db->get('users')->row();
	}

	public function add_user($data)
	{
		$data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
		return $this->db->insert('users', $data);
	}

	public function update_user($id_user, $data)
	{
		if (isset($data['password']) && !empty($data['password'])) {
			$data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
		} else {
			unset($data['password']);
		}
		$this->db->where('id_user', $id_user);
		return $this->db->update('users', $data);
	}

	public function delete_user($id_user)
	{
		$this->db->where('id_user', $id_user);
		return $this->db->delete('users');
	}

	public function is_username_exists($username, $id_user = null)
	{
		$this->db->where('username', $username);
		if ($id_user) {
			$this->db->where('id_user !=', $id_user);
		}
		$query = $this->db->get('users');
		return $query->num_rows() > 0;
	}
}
