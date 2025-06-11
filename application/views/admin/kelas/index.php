<div class="container mt-5">
	<h2>Daftar Data Kelas</h2>
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

	<a href="<?= site_url('admin/tambah_kelas') ?>" class="btn btn-primary mb-3">Tambah Kelas Baru</a>

	<table class="table table-bordered table-striped">
		<thead>
			<tr>
				<th>No</th>
				<th>Nama Kelas</th>
				<th>Aksi</th>
			</tr>
		</thead>
		<tbody>
			<?php if (!empty($kelas)): ?>
				<?php $no = 1;
				foreach ($kelas as $k): ?>
					<tr>
						<td><?= $no++; ?></td>
						<td><?= $k->nama_kelas; ?></td>
						<td>
							<a href="<?= site_url('admin/edit_kelas/' . $k->id_kelas) ?>" class="btn btn-warning btn-sm">Edit</a>
							<a href="<?= site_url('admin/hapus_kelas/' . $k->id_kelas) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus kelas ini? Menghapus kelas akan menghapus semua siswa di dalamnya.');">Hapus</a>
						</td>
					</tr>
				<?php endforeach; ?>
			<?php else: ?>
				<tr>
					<td colspan="3" class="text-center">Tidak ada data kelas.</td>
				</tr>
			<?php endif; ?>
		</tbody>
	</table>
	<a href="<?= site_url('admin/dashboard') ?>" class="btn btn-secondary mt-3">Kembali ke Dashboard</a>
</div>