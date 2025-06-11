<div class="container mt-5">
	<h2><?= $title; ?></h2>
	<hr>
	<?php if ($this->session->flashdata('error')): ?>
		<div class="alert alert-danger" role="alert">
			<?= $this->session->flashdata('error'); ?>
		</div>
	<?php endif; ?>

	<form action="<?= isset($siswa_data) ? site_url('admin/edit_siswa/' . $siswa_data->id_siswa) : site_url('admin/tambah_siswa') ?>" method="post">
		<div class="form-group">
			<label for="nisn">NISN</label>
			<input type="text" class="form-control" id="nisn" name="nisn" value="<?= set_value('nisn', isset($siswa_data) ? $siswa_data->nisn : ''); ?>" required>
			<?= form_error('nisn', '<small class="text-danger">', '</small>'); ?>
		</div>
		<div class="form-group">
			<label for="nama_siswa">Nama Siswa</label>
			<input type="text" class="form-control" id="nama_siswa" name="nama_siswa" value="<?= set_value('nama_siswa', isset($siswa_data) ? $siswa_data->nama_siswa : ''); ?>" required>
			<?= form_error('nama_siswa', '<small class="text-danger">', '</small>'); ?>
		</div>
		<div class="form-group">
			<label for="nomor_hp">WhatsApp Siswa</label>
			<input type="text" class="form-control" id="nomor_hp" name="nomor_hp" value="<?= set_value('nomor_hp', isset($siswa_data) ? $siswa_data->nomor_hp : ''); ?>" required>
			<?= form_error('nomor_hp', '<small class="text-danger">', '</small>'); ?>
		</div>
		<div class="form-group">
			<label for="id_kelas">Kelas</label>
			<select class="form-control" id="id_kelas" name="id_kelas" required>
				<option value="">Pilih Kelas</option>
				<?php foreach ($kelas_options as $kelas): ?>
					<option value="<?= $kelas->id_kelas ?>" <?= set_select('id_kelas', $kelas->id_kelas, (isset($siswa_data) && $siswa_data->id_kelas == $kelas->id_kelas)); ?>>
						<?= $kelas->nama_kelas ?>
					</option>
				<?php endforeach; ?>
			</select>
			<?= form_error('id_kelas', '<small class="text-danger">', '</small>'); ?>
		</div>
		<div class="form-group">
			<label for="tanggal_lahir">Tanggal Lahir (YYYY-MM-DD)</label>
			<input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="<?= set_value('tanggal_lahir', isset($siswa_data) ? $siswa_data->tanggal_lahir : ''); ?>" required>
			<?= form_error('tanggal_lahir', '<small class="text-danger">', '</small>'); ?>
		</div>
		<div class="form-group">
			<label for="alamat">Alamat</label>
			<textarea class="form-control" id="alamat" name="alamat" rows="3"><?= set_value('alamat', isset($siswa_data) ? $siswa_data->alamat : ''); ?></textarea>
			<?= form_error('alamat', '<small class="text-danger">', '</small>'); ?>
		</div>
		<div class="form-group">
			<label for="password">Password Login Siswa <?= isset($siswa_data) ? '(Kosongkan jika tidak ingin mengubah)' : ''; ?></label>
			<input type="password" class="form-control" id="password" name="password" <?= isset($siswa_data) ? '' : 'required'; ?>>
			<?= form_error('password', '<small class="text-danger">', '</small>'); ?>
		</div>
		<div class="form-group">
			<label for="password_conf">Konfirmasi Password</label>
			<input type="password" class="form-control" id="password_conf" name="password_conf" <?= isset($siswa_data) ? '' : 'required'; ?>>
			<?= form_error('password_conf', '<small class="text-danger">', '</small>'); ?>
		</div>
		<button type="submit" class="btn btn-primary">Simpan</button>
		<a href="<?= site_url('admin/siswa') ?>" class="btn btn-secondary">Batal</a>
	</form>
</div>
