<div class="container mt-5">
	<h2>Daftar Data Siswa</h2>
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

	<div class="row mb-3">
		<div class="col-md-6">
			<a href="<?= site_url('admin/tambah_siswa') ?>" class="btn btn-primary">Tambah Siswa Baru</a>
		</div>
		<div class="col-md-6 text-right">
			<a href="<?= site_url('admin/export_excel_siswa') ?>" class="btn btn-success">Download Excel</a>
		</div>
	</div>

	<table class="table table-bordered table-striped">
		<thead>
			<tr>
				<th>No</th>
				<th>NISN</th>
				<th>Nama Siswa</th>
				<th>Kelas</th>
				<th>Tanggal Lahir</th>
				<th>Alamat</th>
				<th>Aksi</th>
			</tr>
		</thead>
		<tbody>
			<?php if (!empty($siswa)): ?>
				<?php $no = 1;
				foreach ($siswa as $s): ?>
					<tr>
						<td><?= $no++; ?></td>
						<td><?= $s->nisn; ?></td>
						<td><?= $s->nama_siswa; ?></td>
						<td><?= $s->nama_kelas; ?></td>
						<td><?= date('d-m-Y', strtotime($s->tanggal_lahir)); ?></td>
						<td><?= $s->alamat ? $s->alamat : '-'; ?></td>
						<td>
							<a href="<?= site_url('admin/edit_siswa/' . $s->id_siswa) ?>" class="btn btn-warning btn-sm">Edit</a>
							<a href="<?= site_url('admin/hapus_siswa/' . $s->id_siswa) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus siswa ini? Menghapus siswa akan menghapus semua pendaftaran ekskul dan pembayaran terkait.');">Hapus</a>
						</td>
					</tr>
				<?php endforeach; ?>
			<?php else: ?>
				<tr>
					<td colspan="7" class="text-center">Tidak ada data siswa.</td>
				</tr>
			<?php endif; ?>
		</tbody>
	</table>
	<a href="<?= site_url('admin/dashboard') ?>" class="btn btn-secondary mt-3">Kembali ke Dashboard</a>
</div>