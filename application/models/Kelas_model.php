<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kelas_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function get_all_kelas()
	{
		$this->db->order_by('nama_kelas', 'ASC');
		return $this->db->get('kelas')->result();
	}

	public function get_kelas_by_id($id_kelas)
	{
		$this->db->where('id_kelas', $id_kelas);
		return $this->db->get('kelas')->row();
	}

	public function add_kelas($data)
	{
		return $this->db->insert('kelas', $data);
	}

	public function update_kelas($id_kelas, $data)
	{
		$this->db->where('id_kelas', $id_kelas);
		return $this->db->update('kelas', $data);
	}

	public function delete_kelas($id_kelas)
	{
		$this->db->where('id_kelas', $id_kelas);
		return $this->db->delete('kelas');
	}

	public function is_nama_kelas_exists($nama_kelas, $id_kelas = null)
	{
		$this->db->where('nama_kelas', $nama_kelas);
		if ($id_kelas) {
			$this->db->where('id_kelas !=', $id_kelas);
		}
		$query = $this->db->get('kelas');
		return $query->num_rows() > 0;
	}
}
