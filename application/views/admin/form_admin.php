<div class="container mt-5">
	<h2><?= $title; ?></h2>
	<hr>
	<?php if ($this->session->flashdata('error')): ?>
		<div class="alert alert-danger" role="alert">
			<?= $this->session->flashdata('error'); ?>
		</div>
	<?php endif; ?>

	<form action="<?= isset($user_data) ? site_url('admin/edit_admin/' . $user_data->id_user) : site_url('admin/tambah_admin') ?>" method="post">
		<div class="form-group">
			<label for="nama">Nama Lengkap</label>
			<input type="text" class="form-control" id="nama" name="nama" value="<?= set_value('nama', isset($user_data) ? $user_data->nama : ''); ?>" required>
			<?= form_error('nama', '<small class="text-danger">', '</small>'); ?>
		</div>
		<div class="form-group">
			<label for="username">Username</label>
			<input type="text" class="form-control" id="username" name="username" value="<?= set_value('username', isset($user_data) ? $user_data->username : ''); ?>" required>
			<?= form_error('username', '<small class="text-danger">', '</small>'); ?>
		</div>
		<div class="form-group">
			<label for="password">Password <?= isset($user_data) ? '(Kosongkan jika tidak ingin mengubah)' : ''; ?></label>
			<input type="password" class="form-control" id="password" name="password" <?= isset($user_data) ? '' : 'required'; ?>>
			<?= form_error('password', '<small class="text-danger">', '</small>'); ?>
		</div>
		<div class="form-group">
			<label for="password_conf">Konfirmasi Password</label>
			<input type="password" class="form-control" id="password_conf" name="password_conf" <?= isset($user_data) ? '' : 'required'; ?>>
			<?= form_error('password_conf', '<small class="text-danger">', '</small>'); ?>
		</div>
		<div class="form-group">
			<label for="role">Role</label>
			<select class="form-control" id="role" name="role" required>
				<option value="admin" <?= set_select('role', 'admin', (isset($user_data) && $user_data->role == 'admin')); ?>>Admin</option>
				<option value="super_admin" <?= set_select('role', 'super_admin', (isset($user_data) && $user_data->role == 'super_admin')); ?>>Super Admin</option>
			</select>
			<?= form_error('role', '<small class="text-danger">', '</small>'); ?>
		</div>
		<button type="submit" class="btn btn-primary">Simpan</button>
		<a href="<?= site_url('admin/kelola_admin') ?>" class="btn btn-secondary">Batal</a>
	</form>
</div>
