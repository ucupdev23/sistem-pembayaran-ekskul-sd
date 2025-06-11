<div class="container mt-5">
	<h2>Daftar Pendaftaran Siswa ke Ekstrakurikuler</h2>
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
			<a href="<?= site_url('admin/daftar_siswa_ekskul') ?>" class="btn btn-primary">Daftarkan Siswa ke Ekskul</a>
		</div>
		<div class="col-md-6 text-right">
			<a href="<?= site_url('admin/export_excel_siswa_ekskul') ?>" class="btn btn-success">Download Excel</a>
		</div>
	</div>

	<table class="table table-bordered table-striped">
		<thead>
			<tr>
				<th>No</th>
				<th>NISN</th>
				<th>Nama Siswa</th>
				<th>Kelas</th>
				<th>Ekstrakurikuler</th>
				<th>Biaya Ekskul</th>
				<th>Tanggal Daftar</th>
				<th>Status</th>
				<th>Aksi</th>
			</tr>
		</thead>
		<tbody>
			<?php if (!empty($siswa_ekskul)): ?>
				<?php $no = 1;
				foreach ($siswa_ekskul as $se): ?>
					<tr>
						<td><?= $no++; ?></td>
						<td><?= $se->nisn; ?></td>
						<td><?= $se->nama_siswa; ?></td>
						<td><?= $se->nama_kelas; ?></td>
						<td><?= $se->nama_ekskul; ?></td>
						<td>Rp<?= number_format($se->biaya, 0, ',', '.'); ?></td>
						<td><?= date('d-m-Y', strtotime($se->tanggal_daftar)); ?></td>
						<td>
							<?php if ($se->status_keanggotaan == 'aktif'): ?>
								<span class="badge badge-success">Aktif</span>
							<?php else: ?>
								<span class="badge badge-secondary">Non-Aktif</span>
							<?php endif; ?>
						</td>
						<td>
							<a href="<?= site_url('admin/edit_status_siswa_ekskul/' . $se->id_siswa_ekskul) ?>" class="btn btn-info btn-sm">Edit Status</a>
							<a href="<?= site_url('admin/hapus_siswa_ekskul/' . $se->id_siswa_ekskul) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus pendaftaran ini? Ini akan menghapus riwayat pembayaran terkait juga.');">Hapus</a>
						</td>
					</tr>
				<?php endforeach; ?>
			<?php else: ?>
				<tr>
					<td colspan="9" class="text-center">Tidak ada siswa yang terdaftar di ekskul.</td>
				</tr>
			<?php endif; ?>
		</tbody>
	</table>
	<a href="<?= site_url('admin/dashboard') ?>" class="btn btn-secondary mt-3">Kembali ke Dashboard</a>
</div>