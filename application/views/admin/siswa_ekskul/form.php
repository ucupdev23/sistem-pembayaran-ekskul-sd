<div class="container mt-5">
	<h2><?= $title; ?></h2>
	<hr>
	<?php if ($this->session->flashdata('error')): ?>
		<div class="alert alert-danger" role="alert">
			<?= $this->session->flashdata('error'); ?>
		</div>
	<?php endif; ?>

	<form action="<?= site_url('admin/daftar_siswa_ekskul') ?>" method="post">
		<div class="form-group">
			<label for="id_siswa">Pilih Siswa</label>
			<select class="form-control" id="id_siswa" name="id_siswa" required>
				<option value="">Pilih Siswa</option>
				<?php foreach ($siswa_options as $s): ?>
					<option value="<?= $s->id_siswa ?>" <?= set_select('id_siswa', $s->id_siswa); ?>>
						<?= $s->nisn ?> - <?= $s->nama_siswa ?> (<?= $s->nama_kelas ?>)
					</option>
				<?php endforeach; ?>
			</select>
			<?= form_error('id_siswa', '<small class="text-danger">', '</small>'); ?>
		</div>
		<div class="form-group">
			<label for="id_ekskul">Pilih Ekstrakurikuler</label>
			<select class="form-control" id="id_ekskul" name="id_ekskul" required>
				<option value="">Pilih Ekskul</option>
				<?php foreach ($ekskul_options as $e): ?>
					<option value="<?= $e->id_ekskul ?>" <?= set_select('id_ekskul', $e->id_ekskul); ?>>
						<?= $e->nama_ekskul ?> (Biaya: Rp<?= number_format($e->biaya, 0, ',', '.'); ?>)
					</option>
				<?php endforeach; ?>
			</select>
			<?= form_error('id_ekskul', '<small class="text-danger">', '</small>'); ?>
		</div>
		<div class="form-group">
			<label for="tanggal_daftar">Tanggal Pendaftaran</label>
			<input type="date" class="form-control" id="tanggal_daftar" name="tanggal_daftar" value="<?= set_value('tanggal_daftar', date('Y-m-d')); ?>" required>
			<?= form_error('tanggal_daftar', '<small class="text-danger">', '</small>'); ?>
		</div>
		<div class="form-group">
			<label for="status_keanggotaan">Status Keanggotaan</label>
			<select class="form-control" id="status_keanggotaan" name="status_keanggotaan" required>
				<option value="aktif" <?= set_select('status_keanggotaan', 'aktif'); ?>>Aktif</option>
				<option value="non_aktif" <?= set_select('status_keanggotaan', 'non_aktif'); ?>>Non-Aktif</option>
			</select>
			<?= form_error('status_keanggotaan', '<small class="text-danger">', '</small>'); ?>
		</div>
		<button type="submit" class="btn btn-primary">Daftarkan</button>
		<a href="<?= site_url('admin/siswa_ekskul') ?>" class="btn btn-secondary">Batal</a>
	</form>
</div>