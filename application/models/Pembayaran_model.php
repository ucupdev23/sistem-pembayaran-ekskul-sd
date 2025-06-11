<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pembayaran_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function get_all_pembayaran()
	{
		$this->db->select('p.*, se.id_siswa_ekskul, s.nisn, s.nama_siswa, k.nama_kelas, e.nama_ekskul, e.biaya as biaya_ekskul, u.nama as nama_admin_verifikasi');
		$this->db->from('pembayaran p');
		$this->db->join('siswa_ekskul se', 'se.id_siswa_ekskul = p.id_siswa_ekskul');
		$this->db->join('siswa s', 's.id_siswa = se.id_siswa');
		$this->db->join('kelas k', 'k.id_kelas = s.id_kelas');
		$this->db->join('ekskul e', 'e.id_ekskul = se.id_ekskul');
		$this->db->join('users u', 'u.id_user = p.id_admin_verifikasi', 'left');
		$this->db->order_by('p.tanggal_bayar', 'DESC');
		return $this->db->get()->result();
	}

	public function get_pembayaran_by_id($id_pembayaran)
	{
		$this->db->select('p.*, se.id_siswa_ekskul, se.id_siswa, s.nisn, s.nama_siswa, k.nama_kelas, e.nama_ekskul, e.biaya as biaya_ekskul, u.nama as nama_admin_verifikasi');
		$this->db->from('pembayaran p');
		$this->db->join('siswa_ekskul se', 'se.id_siswa_ekskul = p.id_siswa_ekskul');
		$this->db->join('siswa s', 's.id_siswa = se.id_siswa');
		$this->db->join('kelas k', 'k.id_kelas = s.id_kelas');
		$this->db->join('ekskul e', 'e.id_ekskul = se.id_ekskul');
		$this->db->join('users u', 'u.id_user = p.id_admin_verifikasi', 'left');
		$this->db->where('p.id_pembayaran', $id_pembayaran);
		return $this->db->get()->row();
	}

	public function add_pembayaran($data)
	{
		return $this->db->insert('pembayaran', $data);
	}

	public function update_status_pembayaran($id_pembayaran, $data)
	{
		$this->db->where('id_pembayaran', $id_pembayaran);
		return $this->db->update('pembayaran', $data);
	}

	public function get_pembayaran_by_siswa_id($id_siswa)
	{
		$this->db->select('p.*, se.id_siswa_ekskul, e.nama_ekskul, e.biaya as biaya_ekskul, u.nama as nama_admin_verifikasi');
		$this->db->from('pembayaran p');
		$this->db->join('siswa_ekskul se', 'se.id_siswa_ekskul = p.id_siswa_ekskul');
		$this->db->join('ekskul e', 'e.id_ekskul = se.id_ekskul');
		$this->db->join('users u', 'u.id_user = p.id_admin_verifikasi', 'left');
		$this->db->where('se.id_siswa', $id_siswa);
		$this->db->order_by('p.tanggal_bayar', 'DESC');
		return $this->db->get()->result();
	}

	public function get_ekskul_for_siswa_pembayaran($id_siswa)
	{
		$this->db->select('se.id_siswa_ekskul, e.nama_ekskul, e.biaya');
		$this->db->from('siswa_ekskul se');
		$this->db->join('ekskul e', 'e.id_ekskul = se.id_ekskul');
		$this->db->where('se.id_siswa', $id_siswa);
		$this->db->where('se.status_keanggotaan', 'aktif');
		return $this->db->get()->result();
	}

	public function get_total_biaya_ekskul_by_siswa_ekskul_id($id_siswa_ekskul)
	{
		$this->db->select('e.biaya');
		$this->db->from('siswa_ekskul se');
		$this->db->join('ekskul e', 'e.id_ekskul = se.id_ekskul');
		$this->db->where('se.id_siswa_ekskul', $id_siswa_ekskul);
		$query = $this->db->get()->row();
		return $query ? $query->biaya : 0;
	}
}
