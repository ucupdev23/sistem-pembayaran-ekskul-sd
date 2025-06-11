<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Siswa_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function get_all_siswa()
	{
		$this->db->select('siswa.*, kelas.nama_kelas');
		$this->db->from('siswa');
		$this->db->join('kelas', 'kelas.id_kelas = siswa.id_kelas');
		$this->db->order_by('siswa.nama_siswa', 'ASC');
		return $this->db->get()->result();
	}

	public function get_siswa_by_id($id_siswa)
	{
		$this->db->select('siswa.*, kelas.nama_kelas');
		$this->db->from('siswa');
		$this->db->join('kelas', 'kelas.id_kelas = siswa.id_kelas');
		$this->db->where('siswa.id_siswa', $id_siswa);
		return $this->db->get()->row();
	}

	public function add_siswa($data)
	{
		$data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
		return $this->db->insert('siswa', $data);
	}

	public function update_siswa($id_siswa, $data)
	{
		if (isset($data['password']) && !empty($data['password'])) {
			$data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
		} else {
			unset($data['password']);
		}
		$this->db->where('id_siswa', $id_siswa);
		return $this->db->update('siswa', $data);
	}

	public function delete_siswa($id_siswa)
	{
		$this->db->where('id_siswa', $id_siswa);
		return $this->db->delete('siswa');
	}

	public function is_nisn_exists($nisn, $id_siswa = null)
	{
		$this->db->where('nisn', $nisn);
		if ($id_siswa) {
			$this->db->where('id_siswa !=', $id_siswa);
		}
		$query = $this->db->get('siswa');
		return $query->num_rows() > 0;
	}

	public function get_all_siswa_ekskul()
	{
		$this->db->select('se.*, s.nama_siswa, s.nisn, k.nama_kelas, e.nama_ekskul, e.biaya');
		$this->db->from('siswa_ekskul se');
		$this->db->join('siswa s', 's.id_siswa = se.id_siswa');
		$this->db->join('kelas k', 'k.id_kelas = s.id_kelas');
		$this->db->join('ekskul e', 'e.id_ekskul = se.id_ekskul');
		$this->db->order_by('s.nama_siswa', 'ASC');
		$this->db->order_by('e.nama_ekskul', 'ASC');
		return $this->db->get()->result();
	}

	public function get_siswa_ekskul_by_id($id_siswa_ekskul)
	{
		$this->db->select('se.*, s.nama_siswa, s.nisn, k.nama_kelas, e.nama_ekskul, e.biaya');
		$this->db->from('siswa_ekskul se');
		$this->db->join('siswa s', 's.id_siswa = se.id_siswa');
		$this->db->join('kelas k', 'k.id_kelas = s.id_kelas');
		$this->db->join('ekskul e', 'e.id_ekskul = se.id_ekskul');
		$this->db->where('se.id_siswa_ekskul', $id_siswa_ekskul);
		return $this->db->get()->row();
	}

	public function add_siswa_ekskul($data)
	{
		$this->db->where('id_siswa', $data['id_siswa']);
		$this->db->where('id_ekskul', $data['id_ekskul']);
		$query = $this->db->get('siswa_ekskul');
		if ($query->num_rows() > 0) {
			return false;
		}
		return $this->db->insert('siswa_ekskul', $data);
	}

	public function delete_siswa_ekskul($id_siswa_ekskul)
	{
		$this->db->where('id_siswa_ekskul', $id_siswa_ekskul);
		return $this->db->delete('siswa_ekskul');
	}

	public function get_ekskul_for_siswa_dropdown($id_siswa)
	{
		$this->db->select('e.id_ekskul, e.nama_ekskul');
		$this->db->from('ekskul e');
		$this->db->where_not_in('e.id_ekskul', '(SELECT id_ekskul FROM siswa_ekskul WHERE id_siswa = ' . $id_siswa . ')', FALSE);
		return $this->db->get()->result();
	}
}
