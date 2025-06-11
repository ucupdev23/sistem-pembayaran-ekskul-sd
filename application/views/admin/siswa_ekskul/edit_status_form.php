<div class="container mt-5">
	<h2><?= $title; ?></h2>
	<hr>
	<?php if ($this->session->flashdata('error')): ?>
		<div class="alert alert-danger" role="alert">
			<?= $this->session->flashdata('error'); ?>
		</div>
	<?php endif; ?>

	<div class="card mb-4">
		<div class="card-header">
			Detail Pendaftaran
		</div>
		<div class="card-body">
			<p><strong>Siswa:</strong> <?= $pendaftaran_data->nama_siswa; ?> (NISN: <?= $pendaftaran_data->nisn; ?>)</p>
			<p><strong>Kelas:</strong> <?= $pendaftaran_data->nama_kelas; ?></p>
			<p><strong>Ekstrakurikuler:</strong> <?= $pendaftaran_data->nama_ekskul; ?> (Biaya: Rp<?= number_format($pendaftaran_data->biaya, 0, ',', '.'); ?>)</p>
			<p><strong>Tanggal Daftar:</strong> <?= date('d-m-Y', strtotime($pendaftaran_data->tanggal_daftar)); ?></p>
			<p><strong>Status Keanggotaan Saat Ini:</strong>
				<?php if ($pendaftaran_data->status_keanggotaan == 'aktif'): ?>
					<span class="badge badge-success">Aktif</span>
				<?php else: ?>
					<span class="badge badge-secondary">Non-Aktif</span>
				<?php endif; ?>
			</p>
		</div>
	</div>

	<form action="<?= site_url('admin/edit_status_siswa_ekskul/' . $pendaftaran_data->id_siswa_ekskul) ?>" method="post">
		<div class="form-group">
			<label for="status_keanggotaan">Ubah Status Keanggotaan</label>
			<select class="form-control" id="status_keanggotaan" name="status_keanggotaan" required>
				<option value="aktif" <?= set_select('status_keanggotaan', 'aktif', ($pendaftaran_data->status_keanggotaan == 'aktif')); ?>>Aktif</option>
				<option value="non_aktif" <?= set_select('status_keanggotaan', 'non_aktif', ($pendaftaran_data->status_keanggotaan == 'non_aktif')); ?>>Non-Aktif</option>
			</select>
			<?= form_error('status_keanggotaan', '<small class="text-danger">', '</small>'); ?>
		</div>
		<button type="submit" class="btn btn-primary">Simpan Perubahan</button>
		<a href="<?= site_url('admin/siswa_ekskul') ?>" class="btn btn-secondary">Batal</a>
	</form>
</div>
