<div class="container mt-5">
	<h2>Daftar Akun Admin</h2>
	<hr>
	<?php if ($this->session->flashdata('success')): ?>
		<div class="alert alert-success" role="alert">
			<?= $this->session->flashdata('success'); ?>
		</div>
	<?php endif; ?>
	<?php if ($this->session->flashdata('error')): ?>
		<div class="alert alert-danger" role="alert">
			<?= $this->session->flashdata('error'); ?>
		</div>
	<?php endif; ?>

	<a href="<?= site_url('admin/tambah_admin') ?>" class="btn btn-primary mb-3">Tambah Admin Baru</a>

	<table class="table table-bordered table-striped">
		<thead>
			<tr>
				<th>No</th>
				<th>Nama Lengkap</th>
				<th>Username</th>
				<th>Role</th>
				<th>Aksi</th>
			</tr>
		</thead>
		<tbody>
			<?php if (!empty($users)): ?>
				<?php $no = 1;
				foreach ($users as $user): ?>
					<tr>
						<td><?= $no++; ?></td>
						<td><?= $user->nama; ?></td>
						<td><?= $user->username; ?></td>
						<td><?= ucfirst(str_replace('_', ' ', $user->role)); ?></td>
						<td>
							<a href="<?= site_url('admin/edit_admin/' . $user->id_user) ?>" class="btn btn-warning btn-sm">Edit</a>
							<?php if ($user->id_user != $this->session->userdata('id_user')): ?>
								<a href="<?= site_url('admin/hapus_admin/' . $user->id_user) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus admin ini?');">Hapus</a>
							<?php else: ?>
								<button class="btn btn-danger btn-sm" disabled title="Tidak bisa menghapus akun sendiri">Hapus</button>
							<?php endif; ?>
						</td>
					</tr>
				<?php endforeach; ?>
			<?php else: ?>
				<tr>
					<td colspan="5" class="text-center">Tidak ada data admin.</td>
				</tr>
			<?php endif; ?>
		</tbody>
	</table>
	<a href="<?= site_url('admin/dashboard') ?>" class="btn btn-secondary mt-3">Kembali ke Dashboard</a>
</div>