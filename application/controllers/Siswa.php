<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Siswa extends CI_Controller
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

		if (!$this->session->userdata('logged_in') || $this->session->userdata('role') != 'siswa') {
			redirect('auth');
		}
	}

	public function dashboard()
	{
		$data['title'] = 'Dashboard Siswa';
		$data['siswa'] = $this->session->userdata();

		$id_siswa = $this->session->userdata('id_siswa');
		$data['pembayaran_siswa'] = $this->Pembayaran_model->get_pembayaran_by_siswa_id($id_siswa);
		$data['total_pending'] = 0;
		$data['total_terverifikasi'] = 0;

		foreach ($data['pembayaran_siswa'] as $p) {
			if ($p->status_pembayaran == 'pending') {
				$data['total_pending']++;
			} elseif ($p->status_pembayaran == 'terverifikasi') {
				$data['total_terverifikasi']++;
			}
		}

		$this->load->view('templates/header', $data);
		$this->load->view('siswa/dashboard', $data);
		$this->load->view('templates/footer');
	}

	public function ekskul()
	{
		$data['title'] = 'Daftar Ekskul Saya & Pembayaran';
		$id_siswa = $this->session->userdata('id_siswa');
		$data['ekskul_terdaftar'] = $this->Siswa_model->get_all_siswa_ekskul();

		$data['ekskul_terdaftar_siswa'] = array_filter($data['ekskul_terdaftar'], function ($item) use ($id_siswa) {
			return $item->id_siswa == $id_siswa;
		});

		$this->load->view('templates/header', $data);
		$this->load->view('siswa/ekskul/index', $data);
		$this->load->view('templates/footer');
	}

	public function bayar_ekskul($id_siswa_ekskul)
	{
		$data['title'] = 'Form Pembayaran Ekskul';
		$pendaftaran_ekskul = $this->Siswa_model->get_siswa_ekskul_by_id($id_siswa_ekskul);

		if (empty($pendaftaran_ekskul) || $pendaftaran_ekskul->id_siswa != $this->session->userdata('id_siswa')) {
			$this->session->set_flashdata('error', 'Pendaftaran ekskul tidak valid atau bukan milik Anda.');
			redirect('siswa/ekskul');
		}

		$data['pendaftaran_ekskul'] = $pendaftaran_ekskul;

		$this->form_validation->set_rules('jumlah_bayar', 'Jumlah Pembayaran', 'required|numeric|greater_than[0]');
		$this->form_validation->set_rules('note_siswa', 'Catatan Pembayaran', 'trim');

		if ($this->form_validation->run() == FALSE) {
			$this->load->view('templates/header', $data);
			$this->load->view('siswa/ekskul/form_pembayaran', $data);
			$this->load->view('templates/footer');
		} else {
			$config['upload_path']   = './uploads/bukti_pembayaran/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$config['max_size']      = 2048;
			$config['encrypt_name']  = TRUE;

			$this->load->library('upload', $config);

			if (! $this->upload->do_upload('bukti_pembayaran')) {
				$error = $this->upload->display_errors();
				$this->session->set_flashdata('error', 'Gagal mengunggah bukti pembayaran: ' . strip_tags($error));
				redirect('siswa/bayar_ekskul/' . $id_siswa_ekskul);
			} else {
				$upload_data = $this->upload->data();
				$file_name = $upload_data['file_name'];

				$pembayaran_data = array(
					'id_siswa_ekskul' => $id_siswa_ekskul,
					'jumlah_bayar'    => $this->input->post('jumlah_bayar'),
					'tanggal_bayar'   => date('Y-m-d H:i:s'),
					'bukti_pembayaran' => $file_name,
					'note_siswa'      => $this->input->post('note_siswa'),
					'status_pembayaran' => 'pending'
				);

				if ($this->Pembayaran_model->add_pembayaran($pembayaran_data)) {
					$this->session->set_flashdata('success', 'Pembayaran berhasil dikirim. Menunggu verifikasi admin.');

					$siswa_info = $this->Siswa_model->get_siswa_by_id($this->session->userdata('id_siswa'));

					$nomor_admin_hp = '6285691489851';

					$pesan_admin = "Notifikasi Pembayaran Baru:\n"
						. "Siswa: " . $siswa_info->nama_siswa . " | NISN: " . $siswa_info->nisn . "\n"
						. "Ekskul: " . $pendaftaran_ekskul->nama_ekskul . "\n"
						. "Jumlah: Rp" . number_format($pembayaran_data['jumlah_bayar'], 0, ',', '.') . "\n"
						. "Status: PENDING\n"
						. "Catetan: " . $this->input->post('note_siswa') . "\n\n"
						. "Silakan lakukan verifikasi di dashboard admin.\n"
						. site_url('admin/pembayaran');

					if (!empty($nomor_admin_hp)) {
						$this->fonnte_lib->send_message($nomor_admin_hp, $pesan_admin);
					}

					redirect('siswa/riwayat_pembayaran');
				} else {
					unlink($upload_data['full_path']);
					$this->session->set_flashdata('error', 'Gagal menyimpan data pembayaran. Silakan coba lagi.');
					redirect('siswa/bayar_ekskul/' . $id_siswa_ekskul);
				}
			}
		}
	}

	public function riwayat_pembayaran()
	{
		$data['title'] = 'Riwayat Pembayaran Saya';
		$id_siswa = $this->session->userdata('id_siswa');
		$data['riwayat_pembayaran'] = $this->Pembayaran_model->get_pembayaran_by_siswa_id($id_siswa);

		$this->load->view('templates/header', $data);
		$this->load->view('siswa/pembayaran/riwayat', $data);
		$this->load->view('templates/footer');
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect('auth');
	}
}
