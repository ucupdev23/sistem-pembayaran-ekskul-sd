<div class="container mt-5">
	<h2><?= $title; ?></h2>
	<hr>
	<?php if ($this->session->flashdata('error')): ?>
		<div class="alert alert-danger" role="alert">
			<?= $this->session->flashdata('error'); ?>
		</div>
	<?php endif; ?>

	<form action="<?= isset($ekskul_data) ? site_url('admin/edit_ekskul/' . $ekskul_data->id_ekskul) : site_url('admin/tambah_ekskul') ?>" method="post">
		<div class="form-group">
			<label for="nama_ekskul">Nama Ekstrakurikuler</label>
			<input type="text" class="form-control" id="nama_ekskul" name="nama_ekskul" value="<?= set_value('nama_ekskul', isset($ekskul_data) ? $ekskul_data->nama_ekskul : ''); ?>" required>
			<?= form_error('nama_ekskul', '<small class="text-danger">', '</small>'); ?>
		</div>
		<div class="form-group">
			<label for="biaya">Biaya (Rp)</label>
			<input type="number" class="form-control" id="biaya" name="biaya" step="0.01" value="<?= set_value('biaya', isset($ekskul_data) ? $ekskul_data->biaya : ''); ?>" required>
			<?= form_error('biaya', '<small class="text-danger">', '</small>'); ?>
		</div>
		<div class="form-group">
			<label for="deskripsi">Deskripsi</label>
			<textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"><?= set_value('deskripsi', isset($ekskul_data) ? $ekskul_data->deskripsi : ''); ?></textarea>
			<?= form_error('deskripsi', '<small class="text-danger">', '</small>'); ?>
		</div>
		<button type="submit" class="btn btn-primary">Simpan</button>
		<a href="<?= site_url('admin/ekskul') ?>" class="btn btn-secondary">Batal</a>
	</form>
</div>
