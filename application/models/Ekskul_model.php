<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ekskul_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function get_all_ekskul()
	{
		$this->db->order_by('nama_ekskul', 'ASC');
		return $this->db->get('ekskul')->result();
	}

	public function get_ekskul_by_id($id_ekskul)
	{
		$this->db->where('id_ekskul', $id_ekskul);
		return $this->db->get('ekskul')->row();
	}

	public function add_ekskul($data)
	{
		return $this->db->insert('ekskul', $data);
	}

	public function update_ekskul($id_ekskul, $data)
	{
		$this->db->where('id_ekskul', $id_ekskul);
		return $this->db->update('ekskul', $data);
	}

	public function delete_ekskul($id_ekskul)
	{
		$this->db->where('id_ekskul', $id_ekskul);
		return $this->db->delete('ekskul');
	}

	public function is_nama_ekskul_exists($nama_ekskul, $id_ekskul = null)
	{
		$this->db->where('nama_ekskul', $nama_ekskul);
		if ($id_ekskul) {
			$this->db->where('id_ekskul !=', $id_ekskul);
		}
		$query = $this->db->get('ekskul');
		return $query->num_rows() > 0;
	}
}
