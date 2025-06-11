<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once(APPPATH . 'third_party/spout/src/Spout/Autoloader/autoload.php');

use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Common\Entity\Style\StyleBuilder;
use Box\Spout\Common\Entity\Row;
use Box\Spout\Writer\Common\Creator\Style\Style;

class Admin extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->load->model('User_model');
		$this->load->model('Kelas_model');
		$this->load->model('Ekskul_model');
		$this->load->model('Siswa_model');
		$this->load->model('Pembayaran_model');
		$this->load->library('form_validation');
		$this->load->library('fonnte_lib');

		if (!$this->session->userdata('logged_in') || ($this->session->userdata('role') != 'admin' && $this->session->userdata('role') != 'super_admin')) {
			redirect('auth');
		}
	}

	public function dashboard()
	{
		$data['title'] = 'Dashboard Admin';
		$data['user'] = $this->session->userdata();

		$data['total_siswa'] = count($this->Siswa_model->get_all_siswa());
		$data['total_ekskul'] = count($this->Ekskul_model->get_all_ekskul());
		$data['total_pembayaran_pending'] = $this->db->get_where('pembayaran', array('status_pembayaran' => 'pending'))->num_rows();
		$data['total_pembayaran_terverifikasi'] = $this->db->get_where('pembayaran', array('status_pembayaran' => 'terverifikasi'))->num_rows();

		$this->load->view('templates/header', $data);
		$this->load->view('admin/dashboard', $data);
		$this->load->view('templates/footer');
	}

	public function kelola_admin()
	{
		if ($this->session->userdata('role') != 'super_admin') {
			$this->session->set_flashdata('error', 'Anda tidak memiliki akses untuk halaman ini.');
			redirect('admin/dashboard');
		}

		$data['title'] = 'Kelola Admin';
		$data['users'] = $this->User_model->get_all_users();

		$this->load->view('templates/header', $data);
		$this->load->view('admin/kelola_admin', $data);
		$this->load->view('templates/footer');
	}

	public function tambah_admin()
	{
		if ($this->session->userdata('role') != 'super_admin') {
			$this->session->set_flashdata('error', 'Anda tidak memiliki akses untuk halaman ini.');
			redirect('admin/dashboard');
		}

		$data['title'] = 'Tambah Admin Baru';

		$this->form_validation->set_rules('nama', 'Nama Lengkap', 'required|trim');
		$this->form_validation->set_rules(
			'username',
			'Username',
			'required|trim|is_unique[users.username]',
			array('is_unique' => 'Username ini sudah terdaftar.')
		);
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
		$this->form_validation->set_rules('password_conf', 'Konfirmasi Password', 'required|matches[password]');
		$this->form_validation->set_rules('role', 'Role', 'required|in_list[super_admin,admin]');

		if ($this->form_validation->run() == FALSE) {
			$this->load->view('templates/header', $data);
			$this->load->view('admin/form_admin', $data);
			$this->load->view('templates/footer');
		} else {
			$user_data = array(
				'nama'      => $this->input->post('nama'),
				'username'  => $this->input->post('username'),
				'password'  => $this->input->post('password'),
				'role'      => $this->input->post('role')
			);

			if ($this->User_model->add_user($user_data)) {
				$this->session->set_flashdata('success', 'Data admin berhasil ditambahkan.');
				redirect('admin/kelola_admin');
			} else {
				$this->session->set_flashdata('error', 'Gagal menambahkan data admin. Silakan coba lagi.');
				redirect('admin/tambah_admin');
			}
		}
	}

	public function edit_admin($id_user)
	{
		if ($this->session->userdata('role') != 'super_admin') {
			$this->session->set_flashdata('error', 'Anda tidak memiliki akses untuk halaman ini.');
			redirect('admin/dashboard');
		}

		$data['title'] = 'Edit Admin';
		$data['user_data'] = $this->User_model->get_user_by_id($id_user);

		if (empty($data['user_data'])) {
			$this->session->set_flashdata('error', 'Data admin tidak ditemukan.');
			redirect('admin/kelola_admin');
		}

		$this->form_validation->set_rules('nama', 'Nama Lengkap', 'required|trim');
		$this->form_validation->set_rules('username', 'Username', 'required|trim');
		if ($this->input->post('password')) {
			$this->form_validation->set_rules('password', 'Password', 'min_length[6]');
			$this->form_validation->set_rules('password_conf', 'Konfirmasi Password', 'matches[password]');
		}
		$this->form_validation->set_rules('role', 'Role', 'required|in_list[super_admin,admin]');

		if ($this->form_validation->run() == FALSE) {
			if ($this->input->post('username') && $this->User_model->is_username_exists($this->input->post('username'), $id_user)) {
				$this->session->set_flashdata('error', 'Username ini sudah terdaftar untuk user lain.');
			}
			$this->load->view('templates/header', $data);
			$this->load->view('admin/form_admin', $data);
			$this->load->view('templates/footer');
		} else {
			if ($this->User_model->is_username_exists($this->input->post('username'), $id_user)) {
				$this->session->set_flashdata('error', 'Username ini sudah terdaftar untuk user lain.');
				$this->load->view('templates/header', $data);
				$this->load->view('admin/form_admin', $data);
				$this->load->view('templates/footer');
				return;
			}

			$user_data_update = array(
				'nama'      => $this->input->post('nama'),
				'username'  => $this->input->post('username'),
				'role'      => $this->input->post('role')
			);

			if ($this->input->post('password')) {
				$user_data_update['password'] = $this->input->post('password');
			}

			if ($this->User_model->update_user($id_user, $user_data_update)) {
				$this->session->set_flashdata('success', 'Data admin berhasil diperbarui.');
				redirect('admin/kelola_admin');
			} else {
				$this->session->set_flashdata('error', 'Gagal memperbarui data admin. Silakan coba lagi.');
				redirect('admin/edit_admin/' . $id_user);
			}
		}
	}

	public function hapus_admin($id_user)
	{
		if ($this->session->userdata('role') != 'super_admin') {
			$this->session->set_flashdata('error', 'Anda tidak memiliki akses untuk halaman ini.');
			redirect('admin/dashboard');
		}

		if ($id_user == $this->session->userdata('id_user')) {
			$this->session->set_flashdata('error', 'Anda tidak bisa menghapus akun Anda sendiri.');
			redirect('admin/kelola_admin');
		}

		if ($this->User_model->delete_user($id_user)) {
			$this->session->set_flashdata('success', 'Data admin berhasil dihapus.');
		} else {
			$this->session->set_flashdata('error', 'Gagal menghapus data admin. Silakan coba lagi.');
		}
		redirect('admin/kelola_admin');
	}

	public function kelas()
	{
		if ($this->session->userdata('role') != 'admin' && $this->session->userdata('role') != 'super_admin') {
			redirect('admin/dashboard');
		}

		$data['title'] = 'Kelola Data Kelas';
		$data['kelas'] = $this->Kelas_model->get_all_kelas();

		$this->load->view('templates/header', $data);
		$this->load->view('admin/kelas/index', $data);
		$this->load->view('templates/footer');
	}

	public function tambah_kelas()
	{
		if ($this->session->userdata('role') != 'admin' && $this->session->userdata('role') != 'super_admin') {
			redirect('admin/dashboard');
		}

		$data['title'] = 'Tambah Kelas Baru';

		$this->form_validation->set_rules(
			'nama_kelas',
			'Nama Kelas',
			'required|trim|is_unique[kelas.nama_kelas]',
			array('is_unique' => 'Nama kelas ini sudah ada.')
		);

		if ($this->form_validation->run() == FALSE) {
			$this->load->view('templates/header', $data);
			$this->load->view('admin/kelas/form', $data);
			$this->load->view('templates/footer');
		} else {
			$kelas_data = array(
				'nama_kelas' => $this->input->post('nama_kelas')
			);

			if ($this->Kelas_model->add_kelas($kelas_data)) {
				$this->session->set_flashdata('success', 'Data kelas berhasil ditambahkan.');
				redirect('admin/kelas');
			} else {
				$this->session->set_flashdata('error', 'Gagal menambahkan data kelas. Silakan coba lagi.');
				redirect('admin/tambah_kelas');
			}
		}
	}

	public function edit_kelas($id_kelas)
	{
		if ($this->session->userdata('role') != 'admin' && $this->session->userdata('role') != 'super_admin') {
			redirect('admin/dashboard');
		}

		$data['title'] = 'Edit Kelas';
		$data['kelas_data'] = $this->Kelas_model->get_kelas_by_id($id_kelas);

		if (empty($data['kelas_data'])) {
			$this->session->set_flashdata('error', 'Data kelas tidak ditemukan.');
			redirect('admin/kelas');
		}

		$this->form_validation->set_rules('nama_kelas', 'Nama Kelas', 'required|trim');

		if ($this->form_validation->run() == FALSE) {
			if ($this->input->post('nama_kelas') && $this->Kelas_model->is_nama_kelas_exists($this->input->post('nama_kelas'), $id_kelas)) {
				$this->session->set_flashdata('error', 'Nama kelas ini sudah digunakan.');
			}
			$this->load->view('templates/header', $data);
			$this->load->view('admin/kelas/form', $data);
			$this->load->view('templates/footer');
		} else {
			if ($this->Kelas_model->is_nama_kelas_exists($this->input->post('nama_kelas'), $id_kelas)) {
				$this->session->set_flashdata('error', 'Nama kelas ini sudah digunakan.');
				$this->load->view('templates/header', $data);
				$this->load->view('admin/kelas/form', $data);
				$this->load->view('templates/footer');
				return;
			}

			$kelas_data_update = array(
				'nama_kelas' => $this->input->post('nama_kelas')
			);

			if ($this->Kelas_model->update_kelas($id_kelas, $kelas_data_update)) {
				$this->session->set_flashdata('success', 'Data kelas berhasil diperbarui.');
				redirect('admin/kelas');
			} else {
				$this->session->set_flashdata('error', 'Gagal memperbarui data kelas. Silakan coba lagi.');
				redirect('admin/edit_kelas/' . $id_kelas);
			}
		}
	}

	public function hapus_kelas($id_kelas)
	{
		if ($this->session->userdata('role') != 'admin' && $this->session->userdata('role') != 'super_admin') {
			redirect('admin/dashboard');
		}

		if ($this->Kelas_model->delete_kelas($id_kelas)) {
			$this->session->set_flashdata('success', 'Data kelas berhasil dihapus.');
		} else {
			$this->session->set_flashdata('error', 'Gagal menghapus data kelas. Pastikan tidak ada siswa yang terhubung dengan kelas ini.');
		}
		redirect('admin/kelas');
	}

	public function ekskul()
	{
		if ($this->session->userdata('role') != 'admin' && $this->session->userdata('role') != 'super_admin') {
			redirect('admin/dashboard');
		}

		$data['title'] = 'Kelola Data Ekskul';
		$data['ekskul'] = $this->Ekskul_model->get_all_ekskul();

		$this->load->view('templates/header', $data);
		$this->load->view('admin/ekskul/index', $data);
		$this->load->view('templates/footer');
	}

	public function tambah_ekskul()
	{
		if ($this->session->userdata('role') != 'admin' && $this->session->userdata('role') != 'super_admin') {
			redirect('admin/dashboard');
		}

		$data['title'] = 'Tambah Ekskul Baru';

		$this->form_validation->set_rules(
			'nama_ekskul',
			'Nama Ekskul',
			'required|trim|is_unique[ekskul.nama_ekskul]',
			array('is_unique' => 'Nama ekskul ini sudah ada.')
		);
		$this->form_validation->set_rules('biaya', 'Biaya', 'required|numeric|greater_than_equal_to[0]');
		$this->form_validation->set_rules('deskripsi', 'Deskripsi', 'trim');

		if ($this->form_validation->run() == FALSE) {
			$this->load->view('templates/header', $data);
			$this->load->view('admin/ekskul/form', $data);
			$this->load->view('templates/footer');
		} else {
			$ekskul_data = array(
				'nama_ekskul' => $this->input->post('nama_ekskul'),
				'biaya'       => $this->input->post('biaya'),
				'deskripsi'   => $this->input->post('deskripsi')
			);

			if ($this->Ekskul_model->add_ekskul($ekskul_data)) {
				$this->session->set_flashdata('success', 'Data ekskul berhasil ditambahkan.');
				redirect('admin/ekskul');
			} else {
				$this->session->set_flashdata('error', 'Gagal menambahkan data ekskul. Silakan coba lagi.');
				redirect('admin/tambah_ekskul');
			}
		}
	}

	public function edit_ekskul($id_ekskul)
	{
		if ($this->session->userdata('role') != 'admin' && $this->session->userdata('role') != 'super_admin') {
			redirect('admin/dashboard');
		}

		$data['title'] = 'Edit Ekskul';
		$data['ekskul_data'] = $this->Ekskul_model->get_ekskul_by_id($id_ekskul);

		if (empty($data['ekskul_data'])) {
			$this->session->set_flashdata('error', 'Data ekskul tidak ditemukan.');
			redirect('admin/ekskul');
		}

		$this->form_validation->set_rules('nama_ekskul', 'Nama Ekskul', 'required|trim');
		$this->form_validation->set_rules('biaya', 'Biaya', 'required|numeric|greater_than_equal_to[0]');
		$this->form_validation->set_rules('deskripsi', 'Deskripsi', 'trim');

		if ($this->form_validation->run() == FALSE) {
			if ($this->input->post('nama_ekskul') && $this->Ekskul_model->is_nama_ekskul_exists($this->input->post('nama_ekskul'), $id_ekskul)) {
				$this->session->set_flashdata('error', 'Nama ekskul ini sudah digunakan.');
			}
			$this->load->view('templates/header', $data);
			$this->load->view('admin/ekskul/form', $data);
			$this->load->view('templates/footer');
		} else {
			if ($this->Ekskul_model->is_nama_ekskul_exists($this->input->post('nama_ekskul'), $id_ekskul)) {
				$this->session->set_flashdata('error', 'Nama ekskul ini sudah digunakan.');
				$this->load->view('templates/header', $data);
				$this->load->view('admin/ekskul/form', $data);
				$this->load->view('templates/footer');
				return;
			}

			$ekskul_data_update = array(
				'nama_ekskul' => $this->input->post('nama_ekskul'),
				'biaya'       => $this->input->post('biaya'),
				'deskripsi'   => $this->input->post('deskripsi')
			);

			if ($this->Ekskul_model->update_ekskul($id_ekskul, $ekskul_data_update)) {
				$this->session->set_flashdata('success', 'Data ekskul berhasil diperbarui.');
				redirect('admin/ekskul');
			} else {
				$this->session->set_flashdata('error', 'Gagal memperbarui data ekskul. Silakan coba lagi.');
				redirect('admin/edit_ekskul/' . $id_ekskul);
			}
		}
	}

	public function hapus_ekskul($id_ekskul)
	{
		if ($this->session->userdata('role') != 'admin' && $this->session->userdata('role') != 'super_admin') {
			redirect('admin/dashboard');
		}

		if ($this->Ekskul_model->delete_ekskul($id_ekskul)) {
			$this->session->set_flashdata('success', 'Data ekskul berhasil dihapus.');
		} else {
			$this->session->set_flashdata('error', 'Gagal menghapus data ekskul. Pastikan tidak ada siswa yang terdaftar di ekskul ini.');
		}
		redirect('admin/ekskul');
	}

	public function siswa()
	{
		if ($this->session->userdata('role') != 'admin' && $this->session->userdata('role') != 'super_admin') {
			redirect('admin/dashboard');
		}

		$data['title'] = 'Kelola Data Siswa';
		$data['siswa'] = $this->Siswa_model->get_all_siswa();

		$this->load->view('templates/header', $data);
		$this->load->view('admin/siswa/index', $data);
		$this->load->view('templates/footer');
	}

	public function tambah_siswa()
	{
		if ($this->session->userdata('role') != 'admin' && $this->session->userdata('role') != 'super_admin') {
			redirect('admin/dashboard');
		}

		$this->load->model('Kelas_model');
		$data['title'] = 'Tambah Siswa Baru';
		$data['kelas_options'] = $this->Kelas_model->get_all_kelas();

		$this->form_validation->set_rules(
			'nisn',
			'NISN',
			'required|trim|is_unique[siswa.nisn]',
			array('is_unique' => 'NISN ini sudah terdaftar.')
		);
		$this->form_validation->set_rules('nama_siswa', 'Nama Siswa', 'required|trim');
		$this->form_validation->set_rules('nomor_hp', 'WhatsApp Siswa', 'required|min_length[8]');
		$this->form_validation->set_rules('id_kelas', 'Kelas', 'required|numeric');
		$this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'required|valid_date');
		$this->form_validation->set_rules('alamat', 'Alamat', 'trim');
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
		$this->form_validation->set_rules('password_conf', 'Konfirmasi Password', 'required|matches[password]');

		if ($this->form_validation->run() == FALSE) {
			$this->load->view('templates/header', $data);
			$this->load->view('admin/siswa/form', $data);
			$this->load->view('templates/footer');
		} else {
			$siswa_data = array(
				'nisn'          => $this->input->post('nisn'),
				'nama_siswa'    => $this->input->post('nama_siswa'),
				'nomor_hp'    => $this->input->post('nomor_hp'),
				'id_kelas'      => $this->input->post('id_kelas'),
				'tanggal_lahir' => $this->input->post('tanggal_lahir'),
				'alamat'        => $this->input->post('alamat'),
				'password'      => $this->input->post('password')
			);

			if ($this->Siswa_model->add_siswa($siswa_data)) {
				$this->session->set_flashdata('success', 'Data siswa berhasil ditambahkan. Akun login siswa dengan NISN sebagai username dan password yang diinputkan telah dibuat.');
				redirect('admin/siswa');
			} else {
				$this->session->set_flashdata('error', 'Gagal menambahkan data siswa. Silakan coba lagi.');
				redirect('admin/tambah_siswa');
			}
		}
	}

	public function edit_siswa($id_siswa)
	{
		if ($this->session->userdata('role') != 'admin' && $this->session->userdata('role') != 'super_admin') {
			redirect('admin/dashboard');
		}

		$this->load->model('Kelas_model');
		$data['title'] = 'Edit Siswa';
		$data['siswa_data'] = $this->Siswa_model->get_siswa_by_id($id_siswa);
		$data['kelas_options'] = $this->Kelas_model->get_all_kelas();

		if (empty($data['siswa_data'])) {
			$this->session->set_flashdata('error', 'Data siswa tidak ditemukan.');
			redirect('admin/siswa');
		}

		$this->form_validation->set_rules('nisn', 'NISN', 'required|trim');
		$this->form_validation->set_rules('nama_siswa', 'Nama Siswa', 'required|trim');
		$this->form_validation->set_rules('nomor_hp', 'WhatsApp Siswa', 'required|min_length[8]');
		$this->form_validation->set_rules('id_kelas', 'Kelas', 'required|numeric');
		$this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'required|valid_date');
		$this->form_validation->set_rules('alamat', 'Alamat', 'trim');
		if ($this->input->post('password')) {
			$this->form_validation->set_rules('password', 'Password', 'min_length[6]');
			$this->form_validation->set_rules('password_conf', 'Konfirmasi Password', 'matches[password]');
		}

		if ($this->form_validation->run() == FALSE) {
			if ($this->input->post('nisn') && $this->Siswa_model->is_nisn_exists($this->input->post('nisn'), $id_siswa)) {
				$this->session->set_flashdata('error', 'NISN ini sudah terdaftar untuk siswa lain.');
			}
			$this->load->view('templates/header', $data);
			$this->load->view('admin/siswa/form', $data);
			$this->load->view('templates/footer');
		} else {
			if ($this->Siswa_model->is_nisn_exists($this->input->post('nisn'), $id_siswa)) {
				$this->session->set_flashdata('error', 'NISN ini sudah terdaftar untuk siswa lain.');
				$this->load->view('templates/header', $data);
				$this->load->view('admin/siswa/form', $data);
				$this->load->view('templates/footer');
				return;
			}

			$siswa_data_update = array(
				'nisn'          => $this->input->post('nisn'),
				'nama_siswa'    => $this->input->post('nama_siswa'),
				'nomor_hp'    => $this->input->post('nomor_hp'),
				'id_kelas'      => $this->input->post('id_kelas'),
				'tanggal_lahir' => $this->input->post('tanggal_lahir'),
				'alamat'        => $this->input->post('alamat')
			);
			if ($this->input->post('password')) {
				$siswa_data_update['password'] = $this->input->post('password');
			}

			if ($this->Siswa_model->update_siswa($id_siswa, $siswa_data_update)) {
				$this->session->set_flashdata('success', 'Data siswa berhasil diperbarui.');
				redirect('admin/siswa');
			} else {
				$this->session->set_flashdata('error', 'Gagal memperbarui data siswa. Silakan coba lagi.');
				redirect('admin/edit_siswa/' . $id_siswa);
			}
		}
	}

	public function hapus_siswa($id_siswa)
	{
		if ($this->session->userdata('role') != 'admin' && $this->session->userdata('role') != 'super_admin') {
			redirect('admin/dashboard');
		}

		if ($this->Siswa_model->delete_siswa($id_siswa)) {
			$this->session->set_flashdata('success', 'Data siswa berhasil dihapus.');
		} else {
			$this->session->set_flashdata('error', 'Gagal menghapus data siswa. Silakan coba lagi.');
		}
		redirect('admin/siswa');
	}

	public function siswa_ekskul()
	{
		if ($this->session->userdata('role') != 'admin' && $this->session->userdata('role') != 'super_admin') {
			redirect('admin/dashboard');
		}

		$data['title'] = 'Daftar Pendaftaran Siswa ke Ekskul';
		$data['siswa_ekskul'] = $this->Siswa_model->get_all_siswa_ekskul();

		$this->load->view('templates/header', $data);
		$this->load->view('admin/siswa_ekskul/index', $data);
		$this->load->view('templates/footer');
	}

	public function daftar_siswa_ekskul()
	{
		if ($this->session->userdata('role') != 'admin' && $this->session->userdata('role') != 'super_admin') {
			redirect('admin/dashboard');
		}

		$this->load->model('Ekskul_model');
		$data['title'] = 'Daftarkan Siswa ke Ekskul';
		$data['siswa_options'] = $this->Siswa_model->get_all_siswa();
		$data['ekskul_options'] = $this->Ekskul_model->get_all_ekskul();

		$this->form_validation->set_rules('id_siswa', 'Siswa', 'required|numeric');
		$this->form_validation->set_rules('id_ekskul', 'Ekstrakurikuler', 'required|numeric');
		$this->form_validation->set_rules('tanggal_daftar', 'Tanggal Daftar', 'required|valid_date');
		$this->form_validation->set_rules('status_keanggotaan', 'Status Keanggotaan', 'required|in_list[aktif,non_aktif]');

		if ($this->form_validation->run() == FALSE) {
			$this->load->view('templates/header', $data);
			$this->load->view('admin/siswa_ekskul/form', $data);
			$this->load->view('templates/footer');
		} else {
			$siswa_ekskul_data = array(
				'id_siswa'         => $this->input->post('id_siswa'),
				'id_ekskul'        => $this->input->post('id_ekskul'),
				'tanggal_daftar'   => $this->input->post('tanggal_daftar'),
				'status_keanggotaan' => $this->input->post('status_keanggotaan')
			);

			if ($this->Siswa_model->add_siswa_ekskul($siswa_ekskul_data)) {
				$this->session->set_flashdata('success', 'Siswa berhasil didaftarkan ke ekstrakurikuler.');
				redirect('admin/siswa_ekskul');
			} else {
				$this->session->set_flashdata('error', 'Siswa sudah terdaftar di ekskul ini atau terjadi kesalahan.');
				redirect('admin/daftar_siswa_ekskul');
			}
		}
	}

	public function edit_status_siswa_ekskul($id_siswa_ekskul)
	{
		if ($this->session->userdata('role') != 'admin' && $this->session->userdata('role') != 'super_admin') {
			redirect('admin/dashboard');
		}

		$data['title'] = 'Ubah Status Keanggotaan Ekskul';
		$pendaftaran = $this->Siswa_model->get_siswa_ekskul_by_id($id_siswa_ekskul);

		if (empty($pendaftaran)) {
			$this->session->set_flashdata('error', 'Pendaftaran ekskul tidak ditemukan.');
			redirect('admin/siswa_ekskul');
		}

		$this->form_validation->set_rules('status_keanggotaan', 'Status Keanggotaan', 'required|in_list[aktif,non_aktif]');

		if ($this->form_validation->run() == FALSE) {
			$data['pendaftaran_data'] = $pendaftaran;
			$this->load->view('templates/header', $data);
			$this->load->view('admin/siswa_ekskul/edit_status_form', $data);
			$this->load->view('templates/footer');
		} else {
			$update_data = array(
				'status_keanggotaan' => $this->input->post('status_keanggotaan')
			);

			if ($this->db->where('id_siswa_ekskul', $id_siswa_ekskul)->update('siswa_ekskul', $update_data)) {
				$this->session->set_flashdata('success', 'Status keanggotaan ekskul berhasil diperbarui.');
				redirect('admin/siswa_ekskul');
			} else {
				$this->session->set_flashdata('error', 'Gagal memperbarui status keanggotaan ekskul. Silakan coba lagi.');
				redirect('admin/edit_status_siswa_ekskul/' . $id_siswa_ekskul);
			}
		}
	}

	public function hapus_siswa_ekskul($id_siswa_ekskul)
	{
		if ($this->session->userdata('role') != 'admin' && $this->session->userdata('role') != 'super_admin') {
			redirect('admin/dashboard');
		}

		if ($this->Siswa_model->delete_siswa_ekskul($id_siswa_ekskul)) {
			$this->session->set_flashdata('success', 'Pendaftaran siswa ke ekskul berhasil dihapus.');
		} else {
			$this->session->set_flashdata('error', 'Gagal menghapus pendaftaran siswa ke ekskul.');
		}
		redirect('admin/siswa_ekskul');
	}

	public function pembayaran()
	{
		if ($this->session->userdata('role') != 'admin' && $this->session->userdata('role') != 'super_admin') {
			redirect('admin/dashboard');
		}

		$this->load->model('Pembayaran_model');
		$data['title'] = 'Verifikasi Pembayaran Siswa';
		$data['pembayaran'] = $this->Pembayaran_model->get_all_pembayaran();

		$this->load->view('templates/header', $data);
		$this->load->view('admin/pembayaran/index', $data);
		$this->load->view('templates/footer');
	}

	public function verifikasi_pembayaran($id_pembayaran)
	{
		if ($this->session->userdata('role') != 'admin' && $this->session->userdata('role') != 'super_admin') {
			redirect('auth');
		}

		$this->load->model('Pembayaran_model');
		$this->load->model('Siswa_model');
		$data['title'] = 'Detail & Verifikasi Pembayaran';

		$pembayaran_data = $this->Pembayaran_model->get_pembayaran_by_id($id_pembayaran);

		if (empty($pembayaran_data)) {
			$this->session->set_flashdata('error', 'Data pembayaran tidak ditemukan.');
			redirect('admin/pembayaran');
			return;
		}

		$data['pembayaran_data'] = $pembayaran_data;

		$this->form_validation->set_rules('status_pembayaran', 'Status Pembayaran', 'required|in_list[pending,terverifikasi,ditolak]');
		$this->form_validation->set_rules('catatan_admin', 'Catatan Admin', 'trim');

		if ($this->form_validation->run() == FALSE) {
			$this->load->view('templates/header', $data);
			$this->load->view('admin/pembayaran/verifikasi_form', $data);
			$this->load->view('templates/footer');
		} else {
			$status = $this->input->post('status_pembayaran');
			$catatan = $this->input->post('catatan_admin');

			$update_data = array(
				'status_pembayaran' => $status,
				'catatan_admin'     => $catatan,
				'id_admin_verifikasi' => $this->session->userdata('id_user'),
				'tanggal_verifikasi'  => date('Y-m-d H:i:s')
			);

			if ($this->Pembayaran_model->update_status_pembayaran($id_pembayaran, $update_data)) {
				$this->session->set_flashdata('success', 'Status pembayaran berhasil diperbarui menjadi ' . $status . '.');

				$siswa_info = $this->Siswa_model->get_siswa_by_id($pembayaran_data->id_siswa);
				$nomor_siswa_hp = isset($siswa_info->nomor_hp) ? $siswa_info->nomor_hp : '';

				if (!empty($nomor_siswa_hp)) {
					$pesan_status = ($status == 'terverifikasi') ? "telah *TERVERIFIKASI*." : "telah *DITOLAK* dengan catatan: " . $catatan;
					$pesan_siswa = "Halo " . $siswa_info->nama_siswa . ",\n"
						. "Pembayaran ekskul " . $pembayaran_data->nama_ekskul . " Anda sebesar Rp" . number_format($pembayaran_data->jumlah_bayar, 0, ',', '.') . " " . $pesan_status . "\n"
						. "Silakan cek riwayat pembayaran Anda di aplikasi.\n"
						. "Sistem Pembayaran Ekskul SD";

					$this->fonnte_lib->send_message($nomor_siswa_hp, $pesan_siswa);
				}
				redirect('admin/pembayaran');
			} else {
				$this->session->set_flashdata('error', 'Gagal memperbarui status pembayaran. Silakan coba lagi.');
				redirect('admin/verifikasi_pembayaran/' . $id_pembayaran);
			}
		}
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect('auth');
	}

	public function export_excel_siswa()
	{
		$this->load->model('siswa_model');
		$data = $this->siswa_model->get_all_siswa();

		$fileName = "data_siswa.xlsx";
		$writer = WriterEntityFactory::createXLSXWriter();
		$writer->openToBrowser($fileName);

		$headerRow = WriterEntityFactory::createRowFromArray([
			'NISN',
			'Nama',
			'No HP',
			'Kelas',
			'Tanggal Lahir',
			'Alamat'
		]);
		$writer->addRow($headerRow);

		foreach ($data as $siswa) {
			$row = WriterEntityFactory::createRowFromArray([
				$siswa->nisn,
				$siswa->nama_siswa,
				$siswa->nomor_hp,
				$siswa->nama_kelas,
				$siswa->tanggal_lahir,
				$siswa->alamat
			]);
			$writer->addRow($row);
		}

		$writer->close();
		exit;
	}

	public function export_excel_ekskul()
	{
		$this->load->model('ekskul_model');
		$data = $this->ekskul_model->get_all_ekskul();

		$fileName = "data_ekskul.xlsx";
		$writer = WriterEntityFactory::createXLSXWriter();
		$writer->openToBrowser($fileName);

		$headerRow = WriterEntityFactory::createRowFromArray([
			'ID Ekskul',
			'Nama Ekskul',
			'Deskripsi',
			'Biaya'
		]);
		$writer->addRow($headerRow);

		foreach ($data as $ekskul) {
			$row = WriterEntityFactory::createRowFromArray([
				$ekskul->id_ekskul,
				$ekskul->nama_ekskul,
				$ekskul->deskripsi,
				$ekskul->biaya
			]);
			$writer->addRow($row);
		}

		$writer->close();
		exit;
	}

	public function export_excel_siswa_ekskul()
	{
		$this->load->model('siswa_model');
		$data = $this->siswa_model->get_all_siswa_ekskul();

		$fileName = "data_siswa_ekskul.xlsx";
		$writer = WriterEntityFactory::createXLSXWriter();
		$writer->openToBrowser($fileName);

		$headerRow = WriterEntityFactory::createRowFromArray([
			'NISN',
			'Nama',
			'Kelas',
			'Ekskul',
			'Biaya',
			'Waktu Daftar',
			'Status'
		]);
		$writer->addRow($headerRow);

		foreach ($data as $siswa_ekskul) {
			$row = WriterEntityFactory::createRowFromArray([
				$siswa_ekskul->nisn,
				$siswa_ekskul->nama_siswa,
				$siswa_ekskul->nama_kelas,
				$siswa_ekskul->nama_ekskul,
				$siswa_ekskul->biaya,
				$siswa_ekskul->tanggal_daftar,
				$siswa_ekskul->status_keanggotaan
			]);
			$writer->addRow($row);
		}

		$writer->close();
		exit;
	}

	public function export_excel_pembayaran()
	{
		$this->load->model('pembayaran_model');
		$data = $this->pembayaran_model->get_all_pembayaran();

		$fileName = "data_pembayaran_ekskul.xlsx";
		$writer = WriterEntityFactory::createXLSXWriter();
		$writer->openToBrowser($fileName);

		$headerRow = WriterEntityFactory::createRowFromArray([
			'NISN',
			'Nama',
			'Kelas',
			'Ekskul',
			'Jumlah Bayar',
			'Waktu Bayar',
			'Status Pembayaran',
			'Catatan Siswa',
			'Admin Verifikator',
			'Waktu Verifikasi',
			'Catatan Admin'
		]);
		$writer->addRow($headerRow);

		foreach ($data as $pembayaran_ekskul) {
			$row = WriterEntityFactory::createRowFromArray([
				$pembayaran_ekskul->nisn,
				$pembayaran_ekskul->nama_siswa,
				$pembayaran_ekskul->nama_kelas,
				$pembayaran_ekskul->nama_ekskul,
				$pembayaran_ekskul->jumlah_bayar,
				$pembayaran_ekskul->tanggal_bayar,
				$pembayaran_ekskul->status_pembayaran,
				$pembayaran_ekskul->note_siswa,
				$pembayaran_ekskul->nama_admin_verifikasi,
				$pembayaran_ekskul->tanggal_verifikasi,
				$pembayaran_ekskul->catatan_admin
			]);
			$writer->addRow($row);
		}

		$writer->close();
		exit;
	}
}
