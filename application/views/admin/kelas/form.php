<div class="container mt-5">
	<h2><?= $title; ?></h2>
	<hr>
	<?php if ($this->session->flashdata('error')): ?>
		<div class="alert alert-danger" role="alert">
			<?= $this->session->flashdata('error'); ?>
		</div>
	<?php endif; ?>

	<form action="<?= isset($kelas_data) ? site_url('admin/edit_kelas/' . $kelas_data->id_kelas) : site_url('admin/tambah_kelas') ?>" method="post">
		<div class="form-group">
			<label for="nama_kelas">Nama Kelas (Contoh: 1A, 2B, 3C)</label>
			<input type="text" class="form-control" id="nama_kelas" name="nama_kelas" value="<?= set_value('nama_kelas', isset($kelas_data) ? $kelas_data->nama_kelas : ''); ?>" required>
			<?= form_error('nama_kelas', '<small class="text-danger">', '</small>'); ?>
		</div>
		<button type="submit" class="btn btn-primary">Simpan</button>
		<a href="<?= site_url('admin/kelas') ?>" class="btn btn-secondary">Batal</a>
	</form>
</div>
